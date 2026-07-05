# Validation and Screenshots

After injecting `_elementor_data`, render the page and capture screenshots to confirm the build worked.

## Tooling

- **Playwright** (preferred). Install in the project root, not inside the container:
  ```bash
  npm install --save-dev playwright
  npx playwright install chromium
  ```
- Headless Chromium runs against the DDEV public URL (which DDEV exposes via mkcert / `*.ddev.site`).

## Validate-page script contract

`scripts/validate_page.js` accepts:

- `--url` full URL to the page
- `--out-desktop` PNG output path
- `--out-mobile` PNG output path
- `--reference-desktop` (optional) reference image to diff against
- `--reference-mobile` (optional) reference image to diff against

It exits 0 on success, non-zero on failure. Output JSON to stdout summarizing checks:

```json
{
  "url": "https://example.ddev.site/",
  "http_status": 200,
  "elementor_present": true,
  "fatal_php": false,
  "screenshots": {
    "desktop": "/abs/path/desktop.png",
    "mobile":  "/abs/path/mobile.png"
  },
  "diffs": null
}
```

## What "validation passed" means

All of these:

1. HTTP status is 200.
2. Page DOM contains at least one element matching `.e-con, .elementor-section, [data-elementor-type]`.
3. Page does NOT contain text matching `/Fatal error|Parse error|Uncaught.*Exception/i`.
4. Page does NOT contain "There has been a critical error".
5. Both screenshots saved with non-zero file size (>5KB).

If any fail, validation fails. Keep page as draft and report.

## Screenshot dimensions

- Desktop viewport: 1440 × 900
- Mobile viewport: 390 × 844 (iPhone 14 dimensions)
- Full-page screenshots (not just viewport)
- Wait for `networkidle` and an extra 500ms for fonts/animations to settle

## Reference comparison (optional)

If the user provided original screenshots, the skill can:

1. Resize captured screenshot to match reference dimensions.
2. Compute a perceptual diff (e.g., `pixelmatch` or simple histogram comparison).
3. Report a similarity percentage and flag sections with >10% deviation.

This is best-effort. Visual diffing is noisy; treat it as a hint, not a verdict.

## Authentication

The pages being validated should be public (`post_status = publish` after the validation step succeeds). If a page is built as `draft`, the script needs to authenticate to view it:

```bash
# Get a logged-in cookie via WP-CLI
ddev wp user generate-auth-cookie $ADMIN_ID > _skill_state/auth-cookie.txt
```

Pass this cookie to Playwright. After validation, discard the cookie file.

Easier alternative: temporarily flip the page to `publish` for validation, then revert if it fails. The skill currently does the opposite (validate as draft, publish on pass) — adjust if the cookie approach is brittle.

## Skeleton script

```javascript
// scripts/validate_page.js
const { chromium } = require('playwright');
const fs = require('fs');

(async () => {
  const args = require('minimist')(process.argv.slice(2));
  const browser = await chromium.launch();
  const result = { url: args.url, http_status: null, elementor_present: false, fatal_php: false, screenshots: {} };

  for (const [size, viewport, outKey] of [
    ['desktop', { width: 1440, height: 900 }, 'desktop'],
    ['mobile',  { width: 390,  height: 844 }, 'mobile'],
  ]) {
    const ctx = await browser.newContext({ viewport, ignoreHTTPSErrors: true });
    const page = await ctx.newPage();
    const resp = await page.goto(args.url, { waitUntil: 'networkidle' });
    if (size === 'desktop') {
      result.http_status = resp.status();
      const html = await page.content();
      result.elementor_present = /\b(e-con|elementor-section|data-elementor-type)\b/.test(html);
      result.fatal_php = /Fatal error|critical error|Uncaught.*Exception/i.test(html);
    }
    await page.waitForTimeout(500);
    const out = args[`out-${size}`] || args[`out${size.charAt(0).toUpperCase()+size.slice(1)}`];
    await page.screenshot({ path: out, fullPage: true });
    result.screenshots[outKey] = out;
    await ctx.close();
  }

  await browser.close();
  console.log(JSON.stringify(result, null, 2));
  const ok = result.http_status === 200 && result.elementor_present && !result.fatal_php;
  process.exit(ok ? 0 : 1);
})();
```

## When DDEV uses self-signed certs

DDEV's `*.ddev.site` URLs use mkcert. Playwright must accept these:

- Set `ignoreHTTPSErrors: true` on the browser context (shown above), OR
- Trust the mkcert root locally so it's a non-issue.

The skill's script defaults to `ignoreHTTPSErrors: true` for portability.
