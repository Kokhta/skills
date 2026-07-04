# Revision Flow

How to change something already built without rebuilding everything.

## Three revision scopes

### A. Reopen a section

User says: "section 3 in /home, swap the icon-box trio for image-boxes"

Steps:

1. Load `_skill_state/blueprint.json`. Find the page and section.
2. Load the current `_elementor_data` from the page post:
   ```bash
   ddev wp post meta get $PAGE_ID _elementor_data --format=json > _skill_state/current-page-$PAGE_ID.json
   ```
3. Locate the section by `section_id` (top-level array index — sections are top-level containers in the page JSON).
4. Propose alternatives for that section per `page-proposal-format.md` rules (single-section variant).
5. On approval, regenerate just that section's JSON object.
6. Replace the array element at the same index in the full JSON.
7. Re-inject the full JSON via `scripts/inject_elementor_data.sh`.
8. Re-validate (full page).
9. Update blueprint:
   - `sections[i].chosen_option`
   - `sections[i].build_status = "rebuilt"`
   - `pages[i].page_build_status = "published"` (assuming validation passes)

The page status stays `publish`. Other sections are untouched. The user sees a fresh screenshot for the change.

### B. Reopen header or footer

User says: "change the header — make the menu centered and move the logo to the left as a separate column"

Steps:

1. Load the existing template post (`elementor_library` with `_elementor_template_type = header`).
2. Read its current `_elementor_data`.
3. Propose modifications.
4. On approval, regenerate the template JSON.
5. Inject:
   ```bash
   ddev wp post meta update $HEADER_TEMPLATE_ID _elementor_data "$(cat new.json)" --format=json
   ddev wp elementor flush_css 2>/dev/null || true
   ddev wp cache flush
   ```
6. Validate by capturing a screenshot of any one already-built page.
7. The change reflects on every page automatically. No page rebuild needed.
8. Update blueprint: `globals.header_template.build_status = "rebuilt"`.

### C. Reopen design tokens

User says: "change Primary from navy to dark teal"

Steps:

1. Read current kit settings.
2. Update the relevant token color or font.
3. Write back to the kit:
   ```bash
   ddev wp post meta update $KIT_ID _elementor_page_settings "$(cat new-kit.json)" --format=json
   ddev wp elementor flush_css 2>/dev/null || true
   ddev wp cache flush
   ```
4. Re-run validation screenshots on a sample of existing pages (1–2) to confirm propagation.
5. Page JSON is NOT touched — widgets reference tokens by ID.
6. Update blueprint: log the token change with a timestamp.

## What never to do in revisions

- Never rebuild a whole page when only one section changed.
- Never touch other pages when revising one page's section.
- Never re-propose globals during a section revision.
- Never re-confirm asset mappings already confirmed unless the section's assets change.

## Detecting "global" intent during revision

If the user says "change the button color in section 3" but the button uses a global color token, the skill should:

1. Notice that `button_text_color` references `globals/colors?id=secondary`.
2. Ask: "That button uses the global Secondary color. Do you want to change Secondary globally (affects everywhere) or override it just on this button (no longer follows the token)?"

Only one question. Wait for user choice. Default to global change unless the user explicitly says "just here".

## Section ID stability

When sections are first built, their top-level container IDs are persisted in the blueprint as `section_id`. When revising:

- A section replacement should preserve the `section_id` of the container if possible (rebuild with the same id), so external references (anchors, menu items) still work.
- If the user adds or removes sections, generate fresh IDs and update the blueprint.

## Logging revisions

Append to `_skill_state/revisions.log`:

```
2026-04-25T10:42Z  page=home  section=3  change=icon-box→image-box  status=ok
2026-04-25T11:05Z  globals=header  change=center-menu  status=ok
2026-04-25T11:30Z  globals=tokens  change=primary-color #0E2A47→#0F3D4A  status=ok
```

Useful for audit and for the user to recall what's changed.
