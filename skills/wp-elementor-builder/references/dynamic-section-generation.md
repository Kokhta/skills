# Dynamic Section Generation

When a section in a page proposal does not match any file in `section-templates/`, generate the JSON inline. This document is the playbook for doing it correctly.

## When to use templates vs inline generation

```
Section detected in proposal
        │
        ▼
Is there a template in section-templates/ that matches?
        │
   ┌────┴────┐
  YES        NO
   │          │
   ▼          ▼
section.template = "name"   section.inline_json = { ... }
```

Match criteria for "templates that fit":
- The visual layout matches (hero centered vs hero with side image vs split 50/50, etc.)
- The widget combination matches what you would have proposed anyway
- Minor content differences (different headline, different button text) DO NOT disqualify a template — that's what content tokens are for

When in doubt, prefer the template. Generate inline only when no template fits.

## After generating inline: harvest the template

Every inline-generated section that builds and validates successfully is a candidate to become a reusable template. After the page passes validation, ask the user:

> Section "<name>" was generated inline. Save it as a reusable template `section-templates/<slug>.json` for future pages?

If yes, write the **pre-fill** version (with `__CONTENT_*__` placeholders restored) to the templates directory. Update `references/widget-catalog.json` only if a new widget was used (rare).

This is how the library grows organically.

## Procedure for inline generation

### Step 1 — Identify the visual structure

From the screenshot or HTML, determine:

1. **Layout direction:** row, column, or grid?
2. **Number of children at the top level**
3. **Background:** solid color (which token?), image, gradient, or none?
4. **Padding:** large (~80–120px), medium (~40–60px), small (~20–30px)?
5. **Content alignment:** left, center, right?
6. **Responsive behavior:** does it flip to column on mobile? Reorder?

Write these down before producing JSON.

### Step 2 — Pick the widget combination

Use `references/elementor-native-widgets.md` "Mapping common section needs to widget combos" as the lookup. If the section is a known archetype (hero, FAQ, testimonials, pricing, etc.), use the recommended combo. If it's not a known archetype, decompose into the smallest set of native widgets that represents it.

Forbidden as primary structure:
- `html` widget for layout
- `shortcode` widget for layout
- nested `section`/`column` legacy when `container` solves it

### Step 3 — Build the JSON, top-down

Always start with a top-level `container` and nest inwards. Use this skeleton:

```json
{
  "id": "PLACEHOLDER",
  "elType": "container",
  "settings": {
    "content_width": "boxed",
    "flex_direction": "column",
    "flex_align_items": "stretch",
    "flex_gap": { "size": 24, "unit": "px", "column": "24", "row": "24", "isLinked": true },
    "padding": { "unit": "px", "top": "80", "right": "20", "bottom": "80", "left": "20", "isLinked": false }
  },
  "elements": [
    /* widgets and inner containers go here */
  ],
  "isInner": false
}
```

Then add children. For widgets, use this skeleton:

```json
{
  "id": "PLACEHOLDER",
  "elType": "widget",
  "widgetType": "<one from widget-catalog.json>",
  "settings": {
    /* widget-specific settings */
  },
  "elements": []
}
```

For inner containers (nested layout), set `"isInner": true`.

### Step 4 — Apply globals, not literals

Whenever you would write a hex color or a font family, use `__globals__` instead:

```json
"settings": {
  "title_color": "",
  "__globals__": {
    "title_color": "globals/colors?id=primary",
    "typography_typography": "globals/typography?id=primary"
  }
}
```

Token IDs come from `_skill_state/blueprint.json → globals.design_tokens`. Use the canonical role names: `primary`, `secondary`, `text`, `accent`, plus any custom tokens defined in the kit.

If the design uses a color or font that doesn't exist in the kit yet, **stop and ask the user**: "This section uses a color/font not in the global tokens. Add it to globals (recommended) or hardcode it just here?"

### Step 5 — Use placeholders for content and assets

Content text uses `__CONTENT_<KEY>__` (uppercase, no spaces). Examples:

- `__CONTENT_HEADLINE__`
- `__CONTENT_BODY__`
- `__CONTENT_CTA_TEXT__`
- `__CONTENT_CTA_URL__`
- `__CONTENT_QUOTE__`
- `__CONTENT_AUTHOR__`

Image references use the asset-shaped object with `__ASSET_<KEY>__`:

```json
"image": {
  "id": "__ASSET_HERO_IMAGE__",
  "url": "__ASSET_HERO_IMAGE_URL__"
}
```

The composer matches `__ASSET_HERO_IMAGE__` against the assets_library key with the same name (or its filename equivalent). Define the mapping in `section.content` and `bp.assets_library` accordingly.

Then the blueprint section looks like:

```json
{
  "section_id": "abc1234",
  "inline_json": { /* the JSON you built above */ },
  "content": {
    "headline": "Welcome to the future",
    "body": "Build sites in hours, not weeks.",
    "cta_text": "Start now",
    "cta_url": "/start"
  }
}
```

### Step 6 — Generate IDs only at injection time

Every `id` in the inline JSON should be the literal string `"PLACEHOLDER"` (or any string — the composer rewrites all `id` fields with fresh 7-char hex). Do not invent IDs by hand. Do not reuse IDs from another section.

### Step 7 — Set responsive overrides only when needed

Only emit `_tablet` / `_mobile` settings when the proposal explicitly calls for a layout flip or a sizing change. Example: a 50/50 row that stacks on mobile:

```json
"settings": {
  "flex_direction": "row",
  "flex_direction_mobile": "column"
}
```

Or padding that shrinks on mobile:

```json
"settings": {
  "padding":        { "unit": "px", "top": "80", "right": "20", "bottom": "80", "left": "20", "isLinked": false },
  "padding_mobile": { "unit": "px", "top": "40", "right": "16", "bottom": "40", "left": "16", "isLinked": false }
}
```

Don't emit responsive defaults for keys the design doesn't actually change.

### Step 8 — Validate before writing to blueprint

Before persisting `inline_json` to the blueprint, mentally check:

1. Top level is a single object (container or section), not an array of multiple top-level elements.
   - If the section is genuinely two side-by-side blocks, wrap them in an outer container.
2. Every `widget` has a `widgetType` from the catalog.
3. Every `widget` has `"elements": []` (empty array, not omitted).
4. Every `container` has `"elements": [ ... ]` (with children).
5. All `id` values are the placeholder `"PLACEHOLDER"`.
6. Every literal hex color or font family is justified — when a global token of that role exists, use the global instead.
7. `image` settings are full objects (`{id, url}`) using `__ASSET_*__` placeholders, not strings.
8. `link` settings are full objects (`{url, is_external, nofollow}`), not bare strings.

If any check fails, fix before adding to the blueprint. The composer's strict validation will catch these too, but catching them mentally first saves a round trip.

## Common archetypes — inline JSON examples

### Image + text 50/50 (no template — generate inline)

```json
{
  "id": "PLACEHOLDER",
  "elType": "container",
  "settings": {
    "content_width": "boxed",
    "flex_direction": "row",
    "flex_align_items": "center",
    "flex_gap": { "size": 40, "unit": "px", "column": "40", "row": "40", "isLinked": true },
    "flex_direction_mobile": "column",
    "padding": { "unit": "px", "top": "80", "right": "20", "bottom": "80", "left": "20", "isLinked": false }
  },
  "elements": [
    {
      "id": "PLACEHOLDER",
      "elType": "container",
      "settings": {
        "width": { "unit": "%", "size": 50 },
        "width_mobile": { "unit": "%", "size": 100 },
        "flex_direction": "column",
        "flex_gap": { "size": 16, "unit": "px", "column": "16", "row": "16", "isLinked": true }
      },
      "elements": [
        {
          "id": "PLACEHOLDER",
          "elType": "widget",
          "widgetType": "heading",
          "settings": {
            "title": "__CONTENT_HEADLINE__",
            "header_size": "h2",
            "size": "xl",
            "__globals__": {
              "title_color": "globals/colors?id=primary",
              "typography_typography": "globals/typography?id=primary"
            }
          },
          "elements": []
        },
        {
          "id": "PLACEHOLDER",
          "elType": "widget",
          "widgetType": "text-editor",
          "settings": {
            "editor": "<p>__CONTENT_BODY__</p>",
            "__globals__": {
              "text_color": "globals/colors?id=text",
              "typography_typography": "globals/typography?id=secondary"
            }
          },
          "elements": []
        }
      ],
      "isInner": true
    },
    {
      "id": "PLACEHOLDER",
      "elType": "container",
      "settings": {
        "width": { "unit": "%", "size": 50 },
        "width_mobile": { "unit": "%", "size": 100 }
      },
      "elements": [
        {
          "id": "PLACEHOLDER",
          "elType": "widget",
          "widgetType": "image",
          "settings": {
            "image": { "id": "__ASSET_SIDE_IMAGE__", "url": "__ASSET_SIDE_IMAGE_URL__" },
            "image_size": "large"
          },
          "elements": []
        }
      ],
      "isInner": true
    }
  ],
  "isInner": false
}
```

### Stats bar — 4 counters in a row

```json
{
  "id": "PLACEHOLDER",
  "elType": "container",
  "settings": {
    "content_width": "boxed",
    "flex_direction": "row",
    "flex_justify_content": "space-around",
    "flex_align_items": "center",
    "flex_direction_mobile": "column",
    "flex_gap": { "size": 32, "unit": "px", "column": "32", "row": "32", "isLinked": true },
    "padding": { "unit": "px", "top": "60", "right": "20", "bottom": "60", "left": "20", "isLinked": false },
    "background_background": "classic",
    "__globals__": { "background_color": "globals/colors?id=accent" }
  },
  "elements": [
    {
      "id": "PLACEHOLDER", "elType": "widget", "widgetType": "counter",
      "settings": {
        "starting_number": 0,
        "ending_number": "__CONTENT_STAT1_NUM__",
        "title": "__CONTENT_STAT1_LABEL__",
        "__globals__": {
          "number_color": "globals/colors?id=primary",
          "title_color": "globals/colors?id=text"
        }
      },
      "elements": []
    }
    // repeat for stat 2, 3, 4
  ],
  "isInner": false
}
```

## What the composer does with inline_json

1. Reads `section.inline_json` from the blueprint.
2. Walks the tree, replacing every `id` with a fresh 7-char hex.
3. Substitutes `__CONTENT_*__` tokens using `section.content`.
4. Substitutes `__ASSET_*__` placeholders using `bp.assets_library`.
5. Validates the result against `widget-catalog.json` and shape rules.
6. Writes to `_elementor_data` for the page.

## Harvesting a template after success

After a page builds and validates, if a section was generated inline and might be reused:

1. Take the **pre-substitution** inline_json (the version with `__CONTENT_*__` and `__ASSET_*__` placeholders intact).
2. Save it as `section-templates/<descriptive-slug>.json`.
3. Update the blueprint section: replace `inline_json` with `template: "<slug>"` so re-runs use the saved file.
4. Mention it in `references/section-templates-index.md` (one line: name, when to use, expected content keys).

This keeps the inline generation as a fallback, not a default, while the curated library grows.
