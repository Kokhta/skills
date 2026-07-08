# Theme Builder Templates (Header & Footer)

Header and footer are **not pages**. In Elementor Pro / ProElements they are entries in the `elementor_library` custom post type with a specific template type and display conditions for the entire site.

## Anatomy

A header/footer template is a regular WP post with:

- `post_type = elementor_library`
- `post_status = publish`
- meta `_elementor_template_type = header` (or `footer`)
- meta `_elementor_edit_mode = builder`
- meta `_elementor_data = <JSON of the layout>`
- meta `_elementor_conditions = <serialized PHP array>` describing where the template applies

## Creating a header template via WP-CLI

```bash
HEADER_ID=$(ddev wp post create \
  --post_type=elementor_library \
  --post_title="Site Header" \
  --post_status=publish \
  --porcelain)

ddev wp post meta update $HEADER_ID _elementor_template_type header
ddev wp post meta update $HEADER_ID _elementor_edit_mode builder
ddev wp post meta update $HEADER_ID _elementor_data "$(cat /tmp/header-data.json)" --format=json
```

## Setting display conditions (entire site)

The conditions meta is a PHP-serialized array. Easiest path is via WP-CLI eval:

```bash
ddev wp eval '
  $conditions = [
    [ "type" => "include", "name" => "general", "sub_name" => "", "sub_id" => "" ]
  ];
  update_post_meta('"$HEADER_ID"', "_elementor_conditions", $conditions);
'
```

After this, ProElements' Theme Builder picks it up as the global header. Verify by visiting any page.

For footer, repeat with `_elementor_template_type = footer`.

## Cache and CSS regeneration

```bash
ddev wp elementor flush_css 2>/dev/null || true
ddev wp cache flush
```

If multiple headers exist for the same condition, Elementor uses priority/last-saved. The skill should:

1. Before creating, check for existing headers with global condition:
   ```bash
   ddev wp post list --post_type=elementor_library --meta_key=_elementor_template_type --meta_value=header --format=ids
   ```
2. If one exists and the user is starting fresh, ask whether to replace it or coexist.
3. If replacing, delete the old conditions or remove the post.

## JSON shape for header content

Header JSON is identical in structure to page JSON: a top-level array of section/container elements. Example skeleton:

```json
[
  {
    "id": "hdr01",
    "elType": "container",
    "settings": {
      "flex_direction": "row",
      "flex_justify_content": "space-between",
      "flex_align_items": "center",
      "content_width": "boxed"
    },
    "elements": [
      {
        "id": "hdr02",
        "elType": "widget",
        "widgetType": "theme-site-logo",
        "settings": {}
      },
      {
        "id": "hdr03",
        "elType": "widget",
        "widgetType": "nav-menu",
        "settings": {
          "menu": "primary"
        }
      },
      {
        "id": "hdr04",
        "elType": "widget",
        "widgetType": "button",
        "settings": {
          "text": "Get started",
          "link": { "url": "/contact" }
        }
      }
    ]
  }
]
```

IDs must be unique 7-character hex strings within the page; for templates use a prefix to avoid collisions with page content.

## Recommended native widgets for headers

- `theme-site-logo` — site logo (ProElements)
- `theme-site-title` — site title (ProElements)
- `nav-menu` — main navigation
- `button` — CTA
- `search-form` — site search (ProElements)
- `social-icons` — social links

## Recommended native widgets for footers

- `theme-site-logo`
- `nav-menu` — secondary nav
- `text-editor` — copyright, address
- `icon-list` — quick links, contact details
- `social-icons`
- `theme-post-info` — only for post-context footers

## Locking

After build + validation, set `globals.header_template.approval_status = "locked"` and `build_status = "built"` in the blueprint. Do not touch on later pages.

## Reopening

If the user says "change the header":
1. Load existing `_elementor_data` from the header post.
2. Propose modifications.
3. On approval, write new JSON to the same post.
4. Flush cache.
5. Capture new screenshot of any page to confirm.
