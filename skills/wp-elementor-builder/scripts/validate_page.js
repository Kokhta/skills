#!/usr/bin/env node
/**
 * validate_page.js — render a page in headless Chromium and capture screenshots.
 *
 * Usage:
 *   node scripts/validate_page.js \
 *     --url https://site.ddev.site/?p=30 \
 *     --out-desktop /path/to/desktop.png \
 *     --out-mobile  /path/to/mobile.png \
 *     [--reference-desktop /path/to/ref-desktop.png] \
 *     [--reference-mobile  /path/to/ref-mobile.png]
 *
 * Exits 0 if validation passes, non-zero otherwise.
 * Writes a JSON summary to stdout.
 */

const fs = require('fs');
const path = require('path');

function parseArgs(argv) {
  const args = {};
  for (let i = 0; i < argv.length; i++) {
    const a = argv[i];
    if (a.startsWith('--')) {
      const key = a.slice(2);
      const next = argv[i + 1];
      if (!next || next.startsWith('--')) {
        args[key] = true;
      } else {
        args[key] = next;
        i++;
      }
    }
  }
  return args;
}

async function main() {
  const args = parseArgs(process.argv.slice(2));
  const required = ['url', 'out-desktop', 'out-mobile'];
  for (const k of required) {
    if (!args[k]) {
      console.error(`ERROR: missing required arg --${k}`);
      process.exit(2);
    }
  }

  let chromium;
  try {
    ({ chromium } = require('playwright'));
  } catch (err) {
    console.error('ERROR: playwright not installed. Run: npm install --save-dev playwright && npx playwright install chromium');
    process.exit(2);
  }

  const result = {
    url: args.url,
    http_status: null,
    elementor_present: false,
    fatal_php: false,
    screenshots: {},
    errors: []
  };

  const browser = await chromium.launch();

  const sizes = [
    { key: 'desktop', viewport: { width: 1440, height: 900 }, out: args['out-desktop'] },
    { key: 'mobile',  viewport: { width: 390,  height: 844 }, out: args['out-mobile']  }
  ];

  for (const { key, viewport, out } of sizes) {
    const ctx = await browser.newContext({ viewport, ignoreHTTPSErrors: true });
    const page = await ctx.newPage();
    try {
      const resp = await page.goto(args.url, { waitUntil: 'networkidle', timeout: 30000 });
      if (key === 'desktop') {
        result.http_status = resp ? resp.status() : null;
        const html = await page.content();
        result.elementor_present = /\b(e-con|elementor-section|data-elementor-type)\b/.test(html);
        result.fatal_php = /Fatal error|critical error|Parse error|Uncaught.*Exception/i.test(html);
      }
      await page.waitForTimeout(500);

      // Ensure output directory exists
      fs.mkdirSync(path.dirname(out), { recursive: true });
      await page.screenshot({ path: out, fullPage: true });
      result.screenshots[key] = out;
    } catch (err) {
      result.errors.push(`${key}: ${err.message}`);
    } finally {
      await ctx.close();
    }
  }

  await browser.close();

  const ok =
    result.http_status === 200 &&
    result.elementor_present &&
    !result.fatal_php &&
    result.screenshots.desktop &&
    result.screenshots.mobile &&
    fs.existsSync(result.screenshots.desktop) &&
    fs.existsSync(result.screenshots.mobile) &&
    fs.statSync(result.screenshots.desktop).size > 5000 &&
    fs.statSync(result.screenshots.mobile).size > 5000;

  result.passed = ok;
  console.log(JSON.stringify(result, null, 2));
  process.exit(ok ? 0 : 1);
}

main().catch(err => {
  console.error('FATAL:', err);
  process.exit(2);
});
