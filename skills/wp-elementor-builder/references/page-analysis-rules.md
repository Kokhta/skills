# Page Analysis Rules

How to turn screenshots, HTML, or design references into a structured page proposal.

## Inputs you may receive

- **Screenshots only** (most common): images of the desired page, possibly mobile + desktop.
- **HTML files**: existing markup, possibly from another builder or static site.
- **Mixed**: HTML for some pages, screenshots for others, plus loose design notes.
- **Live URL**: the user provides a URL of an existing page to replicate.

Treat each input source independently and only merge into a single proposal at the end.

## Step 1: Identify section boundaries

A section is a horizontally-spanning block with a single visual purpose. Common boundary signals:

- background color or image change
- significant vertical whitespace (≥40px)
- shift in content type (text → image grid → testimonials)
- container width change (full-bleed → boxed)

When ambiguous, prefer **more sections** over fewer — splitting is easier than merging in Elementor later.

## Step 2: Classify each section

Map every detected section to a known section type from the catalog in `elementor-native-widgets.md` ("Mapping common section needs to widget combos"):

- Hero
- Logo strip
- Feature grid (2/3/4 columns)
- Image + text 50/50
- Stats / counters
- Testimonials (single, grid, carousel)
- FAQ
- Pricing
- Team grid
- Gallery
- Form / Contact
- CTA banner
- Footer-adjacent (newsletter signup, social proof)

If a section doesn't match a known type, describe it in plain words and propose the closest combination.

## Step 3: Extract content

For each section, extract:

- **Headings** (and hierarchy: H1, H2, H3...)
- **Body copy** (preserve line breaks but not styling)
- **CTAs** (button text + intended destination if known)
- **Image references** (filename if user provided assets, otherwise placeholder)
- **Counts** (number of cards, items, testimonials, etc.)

If the input is a screenshot and text is unreadable, list `[needs text from user]` and ask in the asset mapping turn or earlier.

## Step 4: Detect responsive intent

From the references, infer:

- Does the layout flip from row to column on mobile? (almost always for multi-col sections)
- Are there elements hidden on mobile?
- Are font sizes drastically different mobile vs desktop?

Set the responsive strategy in the blueprint, but only emit `_tablet` / `_mobile` overrides when there's a real flip — not just to be exhaustive.

## Step 5: Detect global elements

Before classifying anything as a "section", remove what belongs to header or footer:

- Top nav bar with logo + menu = **header**, not page section
- Bottom block with copyright + secondary nav = **footer**, not page section

If header/footer are not yet built, flag them — they should be built before the first page.

## Step 6: Identify shared elements across pages

When analyzing multiple pages, detect:

- repeated CTA banners → propose a single saved template that's reused
- consistent "trust strip" → same
- repeated section structures with different content → use the same widget combo per section type for consistency

## Step 7: Spot widget mismatches

Some visual elements look simple but don't have a perfect native widget. Flag these explicitly:

- Custom shapes / SVG illustrations as backgrounds → use container background image; if it's overlaid with elements, use background + inner container
- Animated SVG illustrations → consider `lottie` widget if a Lottie JSON exists, otherwise static image with a note
- Marquee / infinite scroll text → no native widget; propose alternatives (animated-headline, image-carousel with text-as-image, or accept it can't be replicated)
- Complex hover-only states → most native widgets have hover but not arbitrary hover layouts; flag the limitation
- Sticky scroll-triggered animations → Elementor's "motion effects" cover basic sticky/parallax; complex scroll storytelling is not native

When you flag a mismatch, propose 2 alternatives the user can choose from. Do not silently approximate.

## Step 8: Output the analysis

Produce the consolidated blueprint per the format in `page-proposal-format.md`. Include:

- ordered section list
- content extracted per section
- recommended widget combo per section
- alternatives where they matter
- responsive notes only where they matter
- assets required (filenames)
- explicit limitations or mismatches

Then ask the user for approval in a single turn.
