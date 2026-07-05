# Native Elementor & ProElements Widgets

This is the allowed widget catalog. Do not propose anything outside this list. If a section requires something not listed, propose the closest combination here and flag the limitation to the user.

## Core (Elementor free)

### Layout
- `container` — flex/grid container (preferred over legacy section/column)
- `section` — legacy, only when needed for compatibility
- `column` — legacy, paired with section

### Basic
- `heading` — H1–H6 with size/color/typography controls
- `text-editor` — rich text with paragraphs, lists, inline links
- `image` — single image with caption, link, lightbox
- `video` — YouTube, Vimeo, self-hosted with cover/play button
- `button` — single button with icon, hover states
- `divider` — horizontal divider
- `spacer` — vertical space
- `icon` — single icon (Font Awesome / SVG)
- `google_maps` — embed
- `html` — raw HTML (use only as exception)
- `menu-anchor` — anchor target

### General
- `image-box` — image + heading + text + link as a unit
- `icon-box` — icon + heading + text + link
- `image-gallery` — grid gallery
- `image-carousel` — slider of images
- `icon-list` — list with icons
- `counter` — animated number
- `progress` — progress bar
- `testimonial` — single testimonial
- `tabs` — tabbed content
- `accordion` — collapsible sections (preferred for FAQ)
- `toggle` — single collapsible
- `social-icons` — social link row
- `alert` — alert box
- `audio` — SoundCloud embed
- `shortcode` — last resort
- `text-path` — text along an SVG path
- `star-rating` — star rating display

## Pro (ProElements)

### Pro general
- `posts` — query loop for posts/CPT
- `portfolio` — portfolio grid
- `gallery` — pro gallery with filters
- `form` — form builder with native fields, submit, redirect, email
- `login` — login form
- `slides` — multi-layered slider
- `nav-menu` — navigation menu (used in header)
- `animated-headline` — animated text heading
- `price-list` — menu/price list
- `price-table` — pricing column
- `flip-box` — front/back card
- `call-to-action` — CTA composite
- `media-carousel` — media carousel
- `testimonial-carousel` — multiple testimonials in carousel
- `reviews` — reviews carousel
- `lottie` — Lottie animation
- `countdown` — countdown timer
- `share-buttons` — social share
- `blockquote` — blockquote with citation
- `paypal-button` — PayPal payment button
- `code-highlight` — code snippet display

### Pro theme (Theme Builder context)
- `theme-site-logo`
- `theme-site-title`
- `theme-page-title`
- `theme-post-title`
- `theme-post-excerpt`
- `theme-post-content`
- `theme-post-featured-image`
- `theme-post-info`
- `theme-archive-title`
- `theme-archive-posts`
- `search-form`
- `breadcrumbs`
- `author-box`
- `post-comments`
- `post-navigation`

### Pro WooCommerce (only if WC active)
- `wc-products`, `wc-product-title`, `wc-product-price`, `wc-add-to-cart`, etc.

## Mapping common section needs to widget combos

| Section type | Recommended (option A) | Alternative (option B) |
|---|---|---|
| Hero centered | `container` + `heading` + `text-editor` + `button` + `image` | `container` + `image` (background) + inner `container` + `heading` + `button` |
| Logo strip | `image-carousel` (autoplay, no nav) | `container` (flex row) + `image` × N |
| 3-column features | `container` (flex row) + 3 × (`container` + `icon-box`) | 3 × `image-box` in a `container` |
| FAQ | `accordion` | `tabs` (if vertical layout fits) |
| Testimonials | `testimonial-carousel` | `container` + replicated `testimonial` widgets |
| Stats / counters | `container` (flex row) + N × `counter` | `container` + N × `heading` (manual numbers) |
| Pricing | N × `price-table` in a flex `container` | `price-list` if it's a menu, not plans |
| Contact form | `form` (native fields) | external embed only with explicit user approval |
| Team grid | `container` + N × `image-box` | `posts` widget if team is a CPT |
| CTA banner | `container` + `heading` + `button` | `call-to-action` widget |
| Image + text 50/50 | `container` (flex row) + `image` + inner `container` (`heading` + `text-editor` + `button`) | `image-box` (limited but compact) |
| Animated hero headline | `animated-headline` | `heading` (no animation) |
| Countdown launch | `countdown` | static `heading` if not time-based |
| Post listing | `posts` widget | `theme-archive-posts` (only in archive templates) |

## Forbidden as primary structure

- `html` widget as the structural base of a section
- `shortcode` widget for layout
- nested `section` + `column` legacy widgets when a `container` solves it
- third-party widgets

## Notes

- Always prefer `container` over `section` + `column` for new builds.
- `flex_direction` (`row` / `column`), `flex_justify_content`, `flex_align_items`, `content_width` (`boxed` / `full`), `width`, and `gap` cover 90% of layout needs.
- For responsive: most settings have `_tablet` and `_mobile` suffixed variants. Set them explicitly when the proposal involves a layout flip.
