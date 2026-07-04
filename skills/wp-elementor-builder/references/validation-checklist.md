# Validation Checklist

Pre-delivery checklist. Run mentally before reporting "page built" to the user. If anything is "no", do not deliver — fix or report.

## Per-page checklist

### Build correctness
- [ ] Page post exists in WP with correct title and slug
- [ ] `post_status = publish`
- [ ] `_elementor_edit_mode = builder`
- [ ] `_elementor_data` is non-empty valid JSON
- [ ] Page template is `elementor_canvas` (or `elementor_header_footer` / `default` if explicitly chosen)

### JSON correctness
- [ ] Top-level is an array
- [ ] Every element has `id`, `elType`, `settings`, `elements`
- [ ] No element ID is duplicated within the page
- [ ] Every `widget`'s `widgetType` is in the allowed catalog
- [ ] Every `image` setting has both `id` and `url`, and the attachment exists
- [ ] No literal hex color where a Global token of that role exists
- [ ] No literal font family where a Global font token covers it
- [ ] All `link` objects use the `{"url": "...", "is_external": "", "nofollow": ""}` shape

### Render correctness
- [ ] HTTP 200 for the published URL
- [ ] DOM contains `.e-con` or `.elementor-section` or `[data-elementor-type]`
- [ ] No "critical error", "Fatal error", "Parse error" in the rendered HTML
- [ ] Both desktop and mobile screenshots saved and >5KB

### Globals consistency
- [ ] Header template renders on this page (visible in screenshots)
- [ ] Footer template renders on this page (visible in screenshots)
- [ ] Colors used match the approved palette
- [ ] Fonts loaded match the approved typography

### Content correctness
- [ ] All headings present and at the right hierarchy (H1 once, etc.)
- [ ] All buttons have correct text and link destinations
- [ ] All images are the ones the user mapped (not placeholders)
- [ ] No `[needs text from user]` placeholders remain
- [ ] No Lorem Ipsum left over

### Responsive
- [ ] Mobile screenshot doesn't show horizontal scroll
- [ ] Mobile screenshot shows the layout flips defined in the proposal
- [ ] Tap targets (buttons, links) are at least 40px tall

### State persistence
- [ ] `_skill_state/blueprint.json` updated with `page_build_status = "published"`
- [ ] Screenshot paths recorded in blueprint
- [ ] Asset mapping recorded
- [ ] No stale "building" or "failed" status from prior attempts

## Per-globals checklist (one-time, after globals are built)

- [ ] Active kit has the proposed colors with the agreed IDs
- [ ] Active kit has the proposed fonts
- [ ] Header template exists in `elementor_library` with `_elementor_template_type = header`
- [ ] Footer template exists with `_elementor_template_type = footer`
- [ ] Both have `_elementor_conditions` set to "general / entire site"
- [ ] No conflicting older header/footer templates active

## Pre-delivery report format

When everything passes, report exactly:

```
✓ <Page Title>  →  <URL>
  Desktop:  <path>
  Mobile:   <path>
  Sections: <N>  (Hero, Logos, ..., CTA)
  Globals:  Header ✓  Footer ✓  Colors ✓  Fonts ✓
  Notes:    <short summary, only if relevant>
```

When something fails, report exactly:

```
✗ <Page Title>  build incomplete (kept as draft)
  Failed check: <which checklist item>
  Details: <error path or short reason>
  Suggested next step: <reopen section / retry / provide missing asset>
```

No celebration emojis, no fluff. The user reviews and moves on.
