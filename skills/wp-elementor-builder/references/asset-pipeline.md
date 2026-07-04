# Asset Pipeline

How user-provided images become WordPress media library entries that widgets can reference.

## Input contract

The user places assets in `_input/assets/` of the project (or provides a path). Supported formats:

- Raster: `.jpg`, `.jpeg`, `.png`, `.webp`, `.gif`
- Vector: `.svg`
- Other: `.mp4`, `.webm` for video widgets

If a referenced asset is missing, the skill must list it under "MISSING" in the asset mapping turn and wait for the user to provide it. Do not invent placeholders.

## Pipeline steps

### 1. Inventory

```bash
find _input/assets -type f \( -iname '*.jpg' -o -iname '*.jpeg' -o -iname '*.png' \
  -o -iname '*.webp' -o -iname '*.svg' -o -iname '*.gif' \
  -o -iname '*.mp4' -o -iname '*.webm' \) > _skill_state/assets-inventory.txt
```

### 2. Normalize (optional)

Run `scripts/normalize_assets.js` if the user has not pre-optimized:

- Strip EXIF metadata
- Convert filenames to kebab-case
- Resize raster images larger than 2400px wide to 2400px (preserving aspect)
- Optionally generate `.webp` siblings for raster

The original files in `_input/assets/` are never modified. Normalized output goes to `_skill_state/assets-normalized/`.

### 3. SVG sanitization

WordPress doesn't allow SVG uploads by default. Two options:

- **A. Don't enable SVG support**: convert SVG logos to PNG at 2x, accept the quality loss for raster, use as `image` widget. Default for safety.
- **B. Use sanitization plugin**: only if the user has installed one and confirmed. Do not install plugins from the skill.

The skill should default to A and inform the user. If the user wants B, they install the plugin manually.

### 4. Upload to media library

```bash
# upload all normalized assets, capture attachment IDs
scripts/upload_assets.sh _skill_state/assets-normalized > _skill_state/assets-map.json
```

The script wraps `ddev wp media import` and parses the output to build:

```json
{
  "hero-illustration.svg": { "attachment_id": 12, "url": "https://.../hero-illustration.png" },
  "logo-1.svg":            { "attachment_id": 13, "url": "https://.../logo-1.png" },
  ...
}
```

Note: SVGs converted to PNG are mapped under their original filename so the widget JSON can reference the original key.

### 5. Confirm mapping with user

Before assigning to widgets, present the page-level mapping in one turn:

```
Page Home — asset mapping:
  hero-illustration.png   → Hero (background)
  logo-{1..6}.png         → Logos strip
  person-{1..4}.jpg       → Testimonials carousel

Confirm to continue?
```

After confirmation, the skill writes attachment IDs into the page JSON's `image` settings.

### 6. Reference in widget JSON

In Elementor JSON, image settings always include both `id` and `url`:

```json
"image": {
  "id": 13,
  "url": "https://example.ddev.site/wp-content/uploads/2026/04/logo-1.png"
}
```

Both fields are required. Elementor uses `url` for rendering and `id` for size variants and editor-side operations.

### 7. Persistent mapping

Save the final mapping to `_skill_state/assets-map.json`. Reuse on subsequent pages — don't re-upload the same file. If the user adds new assets later, run steps 1–4 only on new files.

## Cleanup

The skill never deletes uploads or files in `_input/assets/`. If the user wants to remove old media, that's a manual step.

## Common issues

| Issue | Cause | Fix |
|---|---|---|
| `ddev wp media import` returns "Could not import" | File path resolution inside container | Use absolute paths from project root, not host paths |
| Image renders as broken in page | URL mismatch (HTTPS vs HTTP) | Confirm `siteurl` and `home` options match what the browser uses |
| SVG uploads fail | WP doesn't allow SVG by default | Convert to PNG (default A) or install a sanitizer plugin (option B) |
| Filename collisions | Same name uploaded twice | WP appends `-1`, `-2`. Update mapping with the new URL |
