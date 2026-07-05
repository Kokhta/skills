# Elementor JSON Schema

Elementor stores every page's structure in the postmeta key `_elementor_data` as a serialized JSON array. This document defines the exact shapes the skill must produce. Always start from a `section-templates/*.json` file and adapt — never compose from memory.

## Top level

`_elementor_data` is a JSON **array**, not object. Each top-level element is a section or container.

```json
[
  { /* container or section #1 */ },
  { /* container or section #2 */ },
  ...
]
```

## Element types (`elType`)

| `elType` | Purpose | Allowed children |
|---|---|---|
| `container` | Flex/grid container (preferred) | `container` (nested), `widget` |
| `section` | Legacy section | `column` only |
| `column` | Legacy column inside section | `widget`, `section` |
| `widget` | A leaf widget | none |

## Container shape

```json
{
  "id": "a1b2c3d",
  "elType": "container",
  "settings": {
    "content_width": "boxed",
    "flex_direction": "column",
    "flex_justify_content": "flex-start",
    "flex_align_items": "stretch",
    "flex_gap": { "size": 20, "unit": "px", "column": "20", "row": "20", "isLinked": true },
    "padding": { "unit": "px", "top": "60", "right": "20", "bottom": "60", "left": "20", "isLinked": false },
    "background_background": "classic",
    "background_color": "",
    "__globals__": {
      "background_color": "globals/colors?id=accent"
    }
  },
  "elements": [ /* children */ ],
  "isInner": false
}
```

Key conventions:

- `id`: 7-character lowercase hex/alphanumeric, unique within the page.
- `content_width`: `"boxed"` or `"full"`.
- `flex_direction`: `"row"` or `"column"`.
- Background colors via `__globals__` map (see below).
- Spacing values use object shape with `unit` and per-side keys.

## Widget shape

```json
{
  "id": "f4e5d6c",
  "elType": "widget",
  "widgetType": "heading",
  "settings": {
    "title": "Welcome to the future",
    "size": "xl",
    "header_size": "h1",
    "align": "center",
    "title_color": "",
    "__globals__": {
      "title_color": "globals/colors?id=primary",
      "typography_typography": "globals/typography?id=primary"
    }
  },
  "elements": [],
  "widgetType_required": true
}
```

`widgetType` matches the slug listed in `elementor-native-widgets.md`.

## Global token references

The `__globals__` object maps **setting keys** to token URIs:

- Color: `"globals/colors?id=<token_id>"`
- Typography: `"globals/typography?id=<token_id>"`

When `__globals__` references a key, the literal value of that setting (e.g., `title_color`) is left as `""` and Elementor resolves the global at render time.

## Responsive settings

Most numeric/dimension settings have `_tablet` and `_mobile` variants:

```json
"settings": {
  "padding":        { "unit": "px", "top": "80", "right": "40", "bottom": "80", "left": "40", "isLinked": false },
  "padding_tablet": { "unit": "px", "top": "60", "right": "24", "bottom": "60", "left": "24", "isLinked": false },
  "padding_mobile": { "unit": "px", "top": "40", "right": "16", "bottom": "40", "left": "16", "isLinked": false },
  "flex_direction": "row",
  "flex_direction_tablet": "row",
  "flex_direction_mobile": "column"
}
```

Only set responsive overrides when the proposal calls for a flip. Don't pollute the JSON with redundant defaults.

## Common widget setting keys (cheat sheet)

### `heading`
- `title` (string)
- `header_size` (`h1`–`h6`)
- `size` (`default`, `small`, `medium`, `large`, `xl`, `xxl`)
- `align`, `title_color`, typography group

### `text-editor`
- `editor` (HTML string with `<p>`, `<strong>`, etc.)
- `align`, `text_color`, typography group

### `button`
- `text` (string)
- `link` (object: `{"url": "...", "is_external": "", "nofollow": ""}`)
- `size` (`xs`–`xl`)
- `button_text_color`, `background_color`, hover variants
- `icon` (icon picker object)
- `selected_icon` (modern icon: `{"value":"fas fa-arrow-right","library":"fa-solid"}`)

### `image`
- `image` (object: `{"id": <attachment_id>, "url": "<url>"}`)
- `image_size` (`thumbnail`, `medium`, `large`, `full`, or custom)
- `align`, `caption_source`, `link_to`

### `image-box`
- `image` (same as image)
- `title_text`, `description_text`
- `link` (object)
- `position` (`top`, `left`, `right`)

### `icon-box`
- `selected_icon` (icon picker)
- `title_text`, `description_text`, `link`
- `position` (`top`, `left`, `right`)

### `accordion`
- `tabs` (array of `{"tab_title": "...", "tab_content": "..."}`)
- `selected_icon`, `selected_active_icon`

### `tabs`
- `tabs` (array of `{"tab_title": "...", "tab_content": "..."}`)

### `form` (Pro)
- `form_name`
- `form_fields` (array; each item has `_id`, `field_label`, `field_type`, `placeholder`, `required`, `width`, etc.)
- `email_to`, `email_subject`, `success_message`

### `nav-menu` (Pro)
- `menu` (slug of registered WP menu)
- `layout` (`horizontal`, `vertical`, `dropdown`)

### `posts` (Pro)
- `posts_post_type`
- `posts_posts_per_page`
- `classic_columns`, `classic_rows_gap`, `classic_columns_gap`
- `classic_show_image`, `classic_show_title`, `classic_show_excerpt`

## ID generation

Generate IDs like:

```js
const id = () => Math.random().toString(16).slice(2, 9).padStart(7, '0');
```

Make sure no two elements in the same page share an ID.

## Validating a JSON before injection

Minimum checks:

1. Top level is an array.
2. Every element has `id`, `elType`, `settings`, `elements`.
3. Every widget has `widgetType` from the allowed list.
4. No literal hex colors when a global token of the same role exists.
5. All `attachment_id` references in `image` settings exist (verify with `ddev wp post get <id> --post_type=attachment`).
6. JSON parses cleanly via `jq .` or `JSON.parse`.

If any check fails, do not inject. Fix and revalidate.
