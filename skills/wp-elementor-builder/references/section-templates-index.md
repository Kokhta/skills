# Section Templates Index

Curated, validated JSON templates that the composer can fill with content. Use these by setting `section.template = "<slug>"` in the blueprint.

If a section in the proposal does not match any of these, generate inline JSON per `references/dynamic-section-generation.md`.

## Heroes (4)

### `hero-collage-mixed-headline`
**Use for:** large headline (with one word in accent color via `<span>`) on left, image collage on right. Agency / creative landing pages.
**Content keys:** `headline_html`, `body1`, `body2`, `cta_text`, `cta_url`
**Asset keys:** `COLLAGE_1`, `COLLAGE_2`, `COLLAGE_3`, `COLLAGE_4`
**Globals used:** primary (button bg), text, accent

### `hero-photo-bubble-cta`
**Use for:** hero with full-bleed dark background, person photo on left, white card with rounded-left corner containing headline + body + CTA on right. Personal brand / consultant.
**Content keys:** `headline_html`, `body`, `cta_text`, `cta_url`
**Asset keys:** `PERSON_PHOTO`
**Globals used:** primary, accent (button), text

### `hero-bg-curves-headline`
**Use for:** full-bleed background image (or graphic) with white headline on top, body, and outline button. Professional firm.
**Content keys:** `headline_html`, `body`, `cta_text`, `cta_url`
**Asset keys:** `HERO_BG`
**Globals used:** typography only (colors are forced white over the bg)

### `hero-typography-statement`
**Use for:** large statement headline as a section by itself (e.g. "time to be seen"). Visual breather between content blocks.
**Content keys:** `statement_html` (can include `<span>` with brand color via global)
**Asset keys:** none
**Globals used:** primary (text), typography primary

## Page Headers (2)

### `page-header-centered`
**Use for:** simple centered title for inner pages — Blog index, "Planeación Estratégica", "Metodología", etc.
**Content keys:** `title`
**Asset keys:** none

### `page-header-back-arrow`
**Use for:** blog post detail header with ← back arrow + title + author + date + share buttons + divider.
**Content keys:** `back_url`, `title`, `author`, `date_and_readtime`
**Asset keys:** none
**Notes:** uses `share-buttons` widget for FB/WhatsApp/Email.

## Services / Features (4)

### `services-iconbox-3col`
**Use for:** 3-column feature grid with icon-box widgets in card containers. Generic services intro.
**Content keys:** `headline`, `intro`, `icon1`–`icon3`, `title1`–`title3`, `desc1`–`desc3`
**Asset keys:** none (uses Font Awesome icons)
**Globals used:** primary (icons), text, accent (card bg)

### `services-cards-bubble-3col`
**Use for:** 3 colored cards (turquoise / blue / gray) each with icon + title + desc + button. Visually distinctive — for personal brand sites.
**Content keys:** `headline`, plus per card: `icon{1,2,3}`, `title{1,2,3}`, `desc{1,2,3}`, `cta{1,2,3}_text`, `cta{1,2,3}_url`
**Asset keys:** none

### `services-grid-2groups`
**Use for:** intro headline + 3 sub-cards with just icon + title (compact directory). Use twice if you have two groups (e.g. "Services for businesses" + "Services for individuals").
**Content keys:** `group_title`, `icon{1,2,3}`, `title{1,2,3}`
**Asset keys:** none

### `proposal-3col-with-active`
**Use for:** value-prop section with 3 columns where one (the first) has a shadow/active state and the others are muted gray.
**Content keys:** `headline`, `intro`, `icon{1,2,3}`, `title{1,2,3}`, `desc{1,2,3}`
**Asset keys:** none

## Dynamic Listings (5) — use widget `posts` with CPTs

### `posts-blog-featured-plus-3`
**Use for:** blog index with one large featured horizontal post + 3 smaller below in a row.
**Content keys:** `post_type` (default: `post`)
**Asset keys:** images come from each post's featured image automatically
**Notes:** featured post uses `posts_offset: 0, posts_posts_per_page: 1`. The grid below uses `posts_offset: 1, posts_posts_per_page: 3`.

### `posts-blog-3col`
**Use for:** simpler 3-column blog listing on home / category pages, with optional CTA below.
**Content keys:** `headline`, `post_type`, `cta_text`, `cta_url`

### `posts-events-list-vertical`
**Use for:** vertical list of events with image-left layout, "Ver Evento" button per row.
**Content keys:** `headline`, `post_type` (default: `evento`)
**Notes:** requires `evento` CPT. See `custom-post-types.md`.

### `posts-resources-cards-list`
**Use for:** vertical list of downloadable resources with "Descargar" button.
**Content keys:** `headline`, `post_type` (default: `recurso`)
**Notes:** requires `recurso` CPT.

### `posts-cases-carousel`
**Use for:** 3-column grid of campaigns/cases with image + title + button.
**Content keys:** `headline`, `post_type` (default: `caso`)
**Notes:** requires `caso` CPT. Despite the name, this template is currently a static grid (carousel as variant TBD). Use the carousel by enabling Elementor's Pro carousel mode on the rendered widget if needed.

## Service Detail Pages (3)

### `service-detail-image-text`
**Use for:** service inner page with hero photo + 2-column body (text + side image) + paragraph below + center CTA. Agency style.
**Content keys:** `body1`, `body2`, `body3`, `body_long`, `cta_text`, `cta_url`
**Asset keys:** `HERO_PHOTO`, `SIDE_PHOTO`

### `service-detail-bubble-text`
**Use for:** service inner page with text on left (icon + title + body) and large photo in colored bubble on right.
**Content keys:** `icon`, `title_html`, `body1`, `body2`
**Asset keys:** `SERVICE_PHOTO`

### `service-detail-hero-body`
**Use for:** service inner page with title+icon row on top, hero image, intro paragraph, two-col body+image, back+CTA buttons row.
**Content keys:** `icon`, `title`, `body_intro`, `body_detail`, `back_url`, `cta_text`, `cta_url`
**Asset keys:** `HERO_PHOTO`, `SIDE_PHOTO`

## Bio (1)

### `bio-photo-bubble-text`
**Use for:** "About [name]" page with photo in a brand-colored bubble on left + name + body + CTA on right.
**Content keys:** `name_html`, `body1`, `body2`, `cta_text`, `cta_url`
**Asset keys:** `BIO_PHOTO`
**Globals used:** primary (bubble bg), accent (button)

## Testimonials (2)

### `testimonials-3col-photo-quote`
**Use for:** 4-column row alternating photo cards and a brand-colored quote card with author. Compact social proof.
**Content keys:** `headline`, `quote`, `author`
**Asset keys:** `PHOTO_1`, `PHOTO_2`, `PHOTO_3`

### `testimonials-quote-photo-bubble`
**Use for:** large headline + body + CTA on left, rotating testimonial-carousel widget on right with quote-in-bubble + photo. Personal brand variant.
**Content keys:** `headline_html`, `body`, `cta_text`, `cta_url`, `slides` (array of testimonial objects)
**Notes:** `slides` array shape: `[{content, name, title, image: {id, url}}, ...]`. Pre-fill image attachment IDs from assets_library before placing in `content.slides`.

## Blog Internal (1)

### `blog-post-content`
**Use for:** body of a blog post — featured image at top, paragraphs centered, then 2-column block (image left + paragraphs right).
**Content keys:** `paragraph_1`, `paragraph_2`, `paragraph_3`, `paragraph_4`, `paragraph_5`
**Asset keys:** `FEATURED_IMAGE`, `SIDE_IMAGE`
**Notes:** for real WP posts this would normally be the post's `the_content()` rendered via `theme-post-content` widget in a single template. This template is for cases where the user wants the inner blog as a static page rather than a dynamic single-template.

## Contact Forms (3)

### `contact-form-2col-text-form`
**Use for:** contact page with copy on left (headline + body) + 7-field form on right. Default for most sites.
**Content keys:** `headline_html`, `body`, `email_to`
**Notes:** form fields are hardcoded (FirstName, LastName, Email, Company, Role, Source, Message). Modify the template if your site needs different fields.

### `contact-form-bubble-photo`
**Use for:** dramatic contact page — person photo in colored bubble on left half, dark form panel on right half, all rounded.
**Content keys:** `email_to`
**Asset keys:** `PERSON_PHOTO`
**Notes:** form has 5 fields (Name, LastName, Email, Phone, Message). Bubble + dark panel form a single bordered card.

### `contact-form-long-narrative`
**Use for:** long copy on left (headline + 2 paragraphs explaining what to expect) + 7-field form on right. For services/B2B sites where lead qualification matters.
**Content keys:** `headline_html`, `body_long`, `body_detail`, `submit_text`, `email_to`

## Special Pages (2)

### `thank-you-large`
**Use for:** post-form-submit "Gracias" page with large centered message in a dark rounded card.
**Content keys:** `headline`, `body`

### `faq-accordion`
**Use for:** FAQ section with collapsible items, plus/minus icons.
**Content keys:** `headline`, `tabs` (array of `{tab_title, tab_content}`)
**Notes:** tab_content can include HTML. Example:
```json
[
  { "tab_title": "¿Cuánto cuesta?", "tab_content": "<p>Depende del alcance. Agenda una cita.</p>" }
]
```

## CTA (1)

### `cta-final-banner`
**Use for:** closing CTA banner with headline + button on a brand-color background. Goes near footer.
**Content keys:** `headline`, `cta_text`, `cta_url`
**Globals used:** primary (bg), white (text + button)

## Adding new templates

1. Build the section inline via the dynamic-generation flow on a real page.
2. Once it builds + validates, save the pre-substitution JSON to `section-templates/<slug>.json`.
3. Add an entry here with: Use for, Content keys, Asset keys, Globals used, optional Notes.
4. Validate JSON parses (`python3 -c "import json; json.load(open('section-templates/x.json'))"`) before commit.

## Naming convention

`<archetype>[-<variant>].json` in kebab-case. Variants describe layout intent, not content. Examples:
- Heroes: `hero-collage-mixed-headline`, `hero-photo-bubble-cta`, `hero-bg-curves-headline`, `hero-typography-statement`
- Pricing: `pricing-3col`, `pricing-2col-comparison`
- Team: `team-grid-4col`, `team-grid-3col-cards`

Keep slugs descriptive enough that Claude's reasoning can pick one without opening the JSON.

---

## Batch 2 — Orange Consulting + Dirección Financiera (added 2026-04-27)

### `hero-fullbleed-photo-shapes-cta`
**Use for:** fullbleed hero with brand-colored bg + decorative shapes (use as bg image), headline + body + CTA on left, person photo right (Orange Home, Orange Programas).
**Content keys:** `headline_html`, `body`, `cta_text`, `cta_url`
**Asset keys:** `HERO_BG_SHAPES`, `PERSON_PHOTO`

### `intro-typography-decorative-2col`
**Use for:** large decorative typographic word/letters on left + intro paragraphs on right (Orange "¿Quiénes somos?" with giant "OO").
**Content keys:** `overtitle`, `decorative` (e.g. "OO" or short giant statement), `body1`, `body2`, `body3`

### `services-cards-4col-alternating`
**Use for:** 4 service cards in a single row over a dark wrapper, each with a different brand color (yellow / dark-blue / primary / gray). Stacks 2x2 on tablet, 1x4 on mobile.
**Content keys:** per card: `icon1-4`, `title1-4`, `desc1-4`, `cta1-4_url`

### `feature-rows-alternating-photo-block`
**Use for:** 3 alternating rows of "image left + colored card right" with large display title + body. First row dark bg, second/third light bg (Orange Programas).
**Content keys:** per row: `title1-3`, `body1-3`
**Asset keys:** `PHOTO_1`, `PHOTO_2`, `PHOTO_3`

### `feature-cards-photo-text-stacked`
**Use for:** 2 vertical cards with photo on left + light blue card on right with display title + body (Orange Programa Interna sub-cards).
**Content keys:** `title1`, `body1`, `title2`, `body2`
**Asset keys:** `PHOTO_1`, `PHOTO_2`

### `page-header-dark-band`
**Use for:** full-width dark band with single white headline (Orange Programa Interna title "IA").
**Content keys:** `title`

### `methodology-video-body`
**Use for:** big headline + YouTube video embed (with poster overlay) + 3 paragraphs centered (Orange Metodología).
**Content keys:** `headline`, `youtube_url`, `paragraph_1-3`
**Asset keys:** `VIDEO_POSTER`

### `contact-form-dark-fields`
**Use for:** contact form where each field is a dark rounded pill (Orange Propuesta / Contacto).
**Content keys:** `headline`, `body`, `submit_text`, `email_to`
**Asset keys:** `PERSON_PHOTO`
**Notes:** uses Elementor Pro Forms widget. Form has 5 fields fixed (Name, Phone, Email, Service, Message).

### `form-lead-magnet-checkboxes`
**Use for:** download/lead-magnet form with headline + body on left + 4-field form + 2 checkboxes (ToS, opt-in) on right (DF Descargar Recursos).
**Content keys:** `headline`, `body`, `email_to`, `redirect_url`
**Notes:** redirect_url should point to the thank-you page. Uses `acceptance` field type for checkboxes.

### `posts-blog-6-grid`
**Use for:** 3x2 grid (6 posts) with image-top + meta + title + excerpt + "Leer Más" button (DF Artículos, Orange Blog).
**Content keys:** `headline`, `post_type`

### `cta-banner-link-inline`
**Use for:** brand-color banner with single headline that contains an inline underlined link (Orange "¿Busca talento? Visite Orange Talent Consulting").
**Content keys:** `headline_html`, `link_url`
**Notes:** the underlined word should be wrapped in `<a>` tags in `headline_html`. The `link_url` is also applied to the whole heading as fallback.

### `team-grid-categorized`
**Use for:** team page with multiple sub-categories (e.g. Directores / Gerentes / Projects Managers), each with title + 4-column grid of members below. Uses `posts` widget with category filter (Orange Quiénes Somos sección Equipo).
**Content keys:** `headline`, `group1_title`, `group2_title`, `group3_title`, `post_type` (default: `miembro`)
**Notes:** requires `miembro` CPT plus a category taxonomy on it. The actual category filtering is done via the editor (set `posts_filter_rule_categories_in` per group post-build) — the template defaults to all members in each group. To wire categories correctly, document this in the build flow when using this template.
