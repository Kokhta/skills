# Failure Recovery

Builds fail. The skill must remain idempotent and resumable.

## Failure modes and their handling

### 1. JSON validation fails before injection

**Symptom:** the assembled `_elementor_data` doesn't pass schema checks (missing `widgetType`, malformed IDs, broken references).

**Action:**
- Do NOT inject.
- Save the offending JSON to `_skill_state/errors/page-<id>-invalid-<timestamp>.json`.
- Log the validation errors to `_skill_state/errors/page-<id>.log`.
- Update blueprint: `pages[i].page_build_status = "failed"`, add a `last_error` field with the first 3 errors.
- Report to the user with the log path and a summary. Ask whether to retry or adjust the proposal.

### 2. WP-CLI injection fails

**Symptom:** `ddev wp post meta update` returns non-zero, or the meta value is truncated/corrupted.

**Action:**
- Capture stderr to the log.
- Verify the post still exists and `_elementor_edit_mode = builder`.
- Common cause: the JSON contains characters that break shell escaping. Pass via stdin or a tempfile, not inline.
- The script `inject_elementor_data.sh` already uses tempfile + `--format=json`. If it still fails, inspect the file for non-UTF-8 characters.
- If unrecoverable, keep page as draft, blueprint shows failed status, ask user.

### 3. Validation script fails (HTTP error or no Elementor markup)

**Symptom:** `validate_page.js` exits non-zero.

**Action:**
- Page stays as draft.
- Both screenshots may be missing or show error pages — keep them anyway for the user to see what went wrong.
- Common causes:
  - Theme doesn't render Elementor canvas template → switch to `elementor_header_footer` or `default`
  - Header/footer template has display conditions that throw → check ProElements settings
  - PHP fatal in a widget setting → revert to a simpler section template, retry
  - Permalinks issue → run `ddev wp rewrite flush`
- Update blueprint with failure reason. Report to user.

### 4. Validation passes but visual diff is large

**Symptom:** validation passes the technical checks but the page looks wrong compared to the reference.

**Action:**
- Page stays as draft (NOT auto-published).
- Report diff details to the user.
- Offer: (a) accept and publish, (b) reopen specific sections, (c) reopen the whole page.
- Wait for user choice.

### 5. Asset upload fails partially

**Symptom:** some images uploaded, others failed.

**Action:**
- The mapping file `_skill_state/assets-map.json` only contains successful uploads.
- Identify which assets are missing.
- Report to user: list missing files with their original paths and the error message per file.
- Do NOT proceed to page build until all required assets are mapped or the user explicitly approves placeholders.

### 6. Mid-conversation interruption

**Symptom:** the user stops responding mid-flow, then comes back later (possibly in a new session).

**Action on resume:**
- Reload `_skill_state/blueprint.json`.
- Find the first item with `approval_status = "pending"` or `build_status = "failed"`.
- Summarize state: "We were here: globals approved, header/footer built, page Home approved and built (published), page About approved but build failed at validation. Resume from About?"
- Wait for confirmation before doing anything.

## State file: `_skill_state/blueprint.json`

This is the single source of truth. It's read at the start of every action and written after every state change.

Layout (full):

```json
{
  "version": 1,
  "project": {
    "ddev_path": "/Users/me/sites/myproject",
    "site_url": "https://myproject.ddev.site",
    "admin_id": 1,
    "kit_id": 4
  },
  "globals": {
    "design_tokens": {
      "approval_status": "locked",
      "colors": [{"id":"primary","title":"Primary","color":"#0E2A47"}, ...],
      "fonts":  [{"id":"primary","title":"Primary","family":"Playfair Display","weight":"600"}, ...]
    },
    "header_template": {
      "template_id": 21,
      "approval_status": "locked",
      "build_status": "built",
      "data_path": "_skill_state/header-data.json"
    },
    "footer_template": {
      "template_id": 22,
      "approval_status": "locked",
      "build_status": "built",
      "data_path": "_skill_state/footer-data.json"
    }
  },
  "pages": [
    {
      "slug": "/",
      "title": "Home",
      "page_id": 30,
      "page_approval_status": "approved",
      "page_build_status": "published",
      "elementor_data_path": "_skill_state/elementor-data-page-30.json",
      "last_screenshots": {
        "desktop": "_skill_state/screenshots/page-30-desktop.png",
        "mobile":  "_skill_state/screenshots/page-30-mobile.png"
      },
      "sections": [
        {
          "section_id": "a1b2c3d",
          "goal": "Hero — first impression",
          "content": { "h1": "...", "body": "...", "cta": "..." },
          "recommended_option": "container + heading + text-editor + button + image",
          "alternative_options": ["container + bg image + inner container..."],
          "chosen_option": "recommended",
          "widgets": ["container","heading","text-editor","button","image"],
          "responsive": { "mobile": "stack column" },
          "assets_required": ["hero-illustration.svg"],
          "assets_mapped":   [{"file":"hero-illustration.svg","attachment_id":12}],
          "approval_status": "approved",
          "build_status": "built"
        }
      ]
    }
  ],
  "assets_library": {
    "hero-illustration.svg": { "attachment_id": 12, "url": "https://..." }
  },
  "revisions": [
    { "ts": "2026-04-25T10:42Z", "scope": "section", "page": "/", "section": "a1b2c3d", "change": "icon-box→image-box", "status": "ok" }
  ]
}
```

## Recovery commands the user can run

If state gets corrupted or the user wants to start fresh:

```bash
# Soft reset: delete blueprint but keep WP content (pages and templates remain)
rm -rf _skill_state/

# Hard reset: also delete WP content created by this skill
# (use with caution — only if the user explicitly asks)
ddev wp post list --post_type=page --post_status=draft,publish --format=ids \
  | xargs ddev wp post delete --force
ddev wp post list --post_type=elementor_library --format=ids \
  | xargs ddev wp post delete --force
```

The skill should NEVER run a hard reset without explicit confirmation in chat ("yes, delete all pages and templates").
