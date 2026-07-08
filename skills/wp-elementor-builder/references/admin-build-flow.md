# Admin Build Flow

The exact sequence to take an approved page blueprint and turn it into a live, validated WordPress page.

## Preconditions before this flow

- Prechecks passed (see `runtime-prechecks.md`)
- Design tokens approved and written to active kit
- Header and footer templates built and conditioned globally
- Page blueprint approved in conversation
- Asset mapping confirmed by user

## Steps

### 1. Create the post as draft

```bash
PAGE_ID=$(ddev wp post create \
  --post_type=page \
  --post_title="<Title>" \
  --post_name="<slug>" \
  --post_status=draft \
  --post_author=$ADMIN_ID \
  --porcelain)
```

Save `$PAGE_ID` in the blueprint immediately:

```jsonc
// _skill_state/blueprint.json → pages[i].page_id = <PAGE_ID>
//                              → pages[i].page_build_status = "building"
```

### 2. Mark as Elementor-built

```bash
ddev wp post meta update $PAGE_ID _elementor_edit_mode builder
ddev wp post meta update $PAGE_ID _elementor_template_type wp-page
ddev wp post meta update $PAGE_ID _wp_page_template elementor_canvas
```

`elementor_canvas` is the blank Elementor template (no theme header/footer rendering on the page itself — header/footer come from Theme Builder templates we built earlier).

If the user wants the theme's wrapper, use `elementor_header_footer` instead. Default to `elementor_canvas` only when both header and footer templates exist; otherwise use `default` and warn.

### 3. Assemble the page JSON

Build `_elementor_data` by composing section templates from `section-templates/` with the approved content and asset attachment IDs. This is a JS/Node operation:

```bash
node scripts/page_blueprint_from_input.js \
  --blueprint _skill_state/blueprint.json \
  --page-id $PAGE_ID \
  --out _skill_state/elementor-data-page-$PAGE_ID.json
```

The output is the final JSON array. Validate it per `elementor-json-schema.md` "Validating a JSON before injection" before continuing.

### 4. Inject the JSON

```bash
scripts/inject_elementor_data.sh $PAGE_ID _skill_state/elementor-data-page-$PAGE_ID.json
```

The script wraps:

```bash
ddev wp post meta update $PAGE_ID _elementor_data "$(cat $JSON_FILE)" --format=json
ddev wp elementor flush_css 2>/dev/null || true
ddev wp cache flush
```

### 5. Validate render

```bash
SITE_URL=$(ddev describe -j | jq -r '.raw.primary_url')
PAGE_URL="$SITE_URL/?p=$PAGE_ID"   # or $SITE_URL/<slug> if pretty perms confirmed

node scripts/validate_page.js \
  --url "$PAGE_URL" \
  --out-desktop _skill_state/screenshots/page-$PAGE_ID-desktop.png \
  --out-mobile  _skill_state/screenshots/page-$PAGE_ID-mobile.png
```

Validation checks:

- HTTP 200 returned
- DOM has at least one `.elementor-section, .e-con` (Elementor rendered)
- No PHP fatal errors visible
- No "Sorry, you are not allowed to access this page" text
- Screenshots captured at 1440×900 desktop and 390×844 mobile

### 6. Decide publish vs keep-draft

Pass conditions:

- HTTP 200
- Elementor markup present
- No fatal errors detected
- Screenshots exist and are non-zero size

If pass:

```bash
ddev wp post update $PAGE_ID --post_status=publish
```

Update blueprint:

```jsonc
// pages[i].page_build_status = "published"
// pages[i].last_screenshots = { desktop, mobile }
```

If fail:

- Keep as draft.
- Capture the error (HTTP code, missing markup, etc.) to `_skill_state/errors/page-$PAGE_ID.log`.
- Update blueprint: `page_build_status = "failed"`.
- Report to user with the error log path.

### 7. Deliver to user

Output exactly:

```
✓ Page <Title> built
  URL:        <full URL>
  Desktop:    <screenshot path>
  Mobile:     <screenshot path>
  Status:     published   (or "draft — validation failed: <reason>")
  Sections:   <count>     (Hero, Logos, Features, ...)
  Diffs:      <bullet list if reference comparison was possible, else "n/a">

Next page? Or should we revisit something?
```

## Idempotency

Re-running this flow for the same page should be safe:

- If `page_id` exists in blueprint, the script reuses it.
- `_elementor_data` is overwritten (last write wins).
- Status returns to `draft` during rebuild, then back to `publish` after validation.

## Concurrency

Do not build multiple pages in parallel. WP-CLI commands are cheap but Elementor's CSS regeneration is global and racy. Sequential is correct.
