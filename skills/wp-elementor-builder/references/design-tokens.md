# Design Tokens (Global Colors & Fonts)

Design tokens live in the **active Elementor kit**. They are a serialized array stored in the postmeta key `_elementor_page_settings` of the kit post (id = `elementor_active_kit` option). All widgets reference tokens by ID, never by literal value.

## Why tokens first

A widget that hardcodes `#1a3a5c` cannot follow a brand color change. A widget that references `_id: "primary"` updates automatically when you change the kit. Building globals first prevents rebuilds later.

## Reading the current kit

```bash
KIT_ID=$(ddev wp option get elementor_active_kit)
ddev wp post meta get $KIT_ID _elementor_page_settings --format=json > /tmp/kit-settings.json
```

The structure looks like:

```json
{
  "system_colors": [
    {"_id": "primary",   "title": "Primary",   "color": "#6EC1E4"},
    {"_id": "secondary", "title": "Secondary", "color": "#54595F"},
    {"_id": "text",      "title": "Text",      "color": "#7A7A7A"},
    {"_id": "accent",    "title": "Accent",    "color": "#61CE70"}
  ],
  "custom_colors": [
    {"_id": "abc123de", "title": "Brand Navy", "color": "#0E2A47"}
  ],
  "system_typography": [
    {"_id": "primary",   "title": "Primary",   "typography_typography": "custom",
     "typography_font_family": "Inter", "typography_font_weight": "600"},
    {"_id": "secondary", "title": "Secondary", "typography_typography": "custom",
     "typography_font_family": "Inter", "typography_font_weight": "400"},
    {"_id": "text",      "title": "Text",      "typography_typography": "custom",
     "typography_font_family": "Inter", "typography_font_weight": "400"},
    {"_id": "accent",    "title": "Accent",    "typography_typography": "custom",
     "typography_font_family": "Inter", "typography_font_weight": "500"}
  ],
  "custom_typography": []
}
```

## Proposing tokens

From the input references (screenshots/HTML), extract:

- **2–6 colors max** for system + a small custom palette. Don't over-collect.
- **1–2 font families.** Headings family + body family. If they're the same family with different weights, that's fine and preferred.

Present them to the user with role names and hex values. Example:

```
Proposed Global Colors:
  Primary    #0E2A47  (deep navy — buttons, headings accents)
  Secondary  #E76F2A  (warm orange — CTAs, links)
  Text       #1F2937  (body copy)
  Accent     #F5F1EA  (warm off-white — section backgrounds)
  Custom: Muted   #6B7280  (captions, meta)

Proposed Global Fonts:
  Primary    Playfair Display, weight 600   (headings H1–H3)
  Secondary  Inter, weight 400              (body)
  Accent     Inter, weight 500              (buttons, labels)
```

## Writing tokens to the kit

Build the new settings JSON and write it back:

```bash
KIT_ID=$(ddev wp option get elementor_active_kit)
ddev wp post meta update $KIT_ID _elementor_page_settings "$(cat /tmp/new-kit-settings.json)" --format=json
ddev wp elementor flush_css   # if available; otherwise next save flushes
ddev wp cache flush
```

If `wp elementor flush_css` is not available, opening the Site Settings panel and saving will regenerate the global CSS file. The skill should note this in the output.

## Referencing tokens in widget JSON

Widgets reference tokens via specific settings keys. The most common:

- **Color:** `__globals__` map points settings keys to global IDs:
  ```json
  "settings": {
    "title_color": "",
    "__globals__": {
      "title_color": "globals/colors?id=primary"
    }
  }
  ```
- **Typography:** same pattern with `typography_typography` key:
  ```json
  "settings": {
    "typography_typography": "",
    "__globals__": {
      "typography_typography": "globals/typography?id=primary"
    }
  }
  ```

The empty string in the direct setting is intentional. Elementor reads the `__globals__` reference when present.

## Locking tokens

After approval, mark `globals.design_tokens.approval_status = "locked"` in `_skill_state/blueprint.json`. Do not propose tokens again unless the user explicitly says "reopen tokens" or "change the palette".

## Reopening tokens

If the user requests a token change after pages exist:

1. Update the kit settings JSON.
2. Flush CSS / clear cache.
3. Re-run validation screenshots on existing pages to confirm propagation.
4. Do NOT touch page `_elementor_data` — references remain valid.
