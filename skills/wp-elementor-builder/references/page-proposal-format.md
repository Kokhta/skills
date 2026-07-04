# Page Proposal Format

Every page is proposed as **a single consolidated blueprint** in one turn. The user approves in bulk or requests targeted adjustments. Section-by-section conversation only happens for genuine ambiguity.

## Format

```
PAGE: <Title>  (slug: /<slug>)
─────────────────────────────────────────────────────────────
N. <Section name>
   Goal: <one-line purpose>
   Content: <heading | body summary | CTA>
   Widgets:    <recommended combination>           [recommended]
   Alternative: <alternative combination>          (if relevant)
   Responsive: <only if a flip is needed>
   Assets:     <filenames or [needs from user]>
   Notes:      <only for limitations/mismatches>
─────────────────────────────────────────────────────────────
[repeat per section]

ASSETS REQUIRED FOR THIS PAGE:
  - hero-bg.jpg
  - logo-1.svg ... logo-6.svg
  - team-1.jpg ... team-3.jpg

GLOBALS USED:
  Header: locked (Site Header template)
  Footer: locked (Site Footer template)
  Colors: Primary, Secondary, Text, Accent
  Fonts:  Primary (headings), Secondary (body)

LIMITATIONS / DECISIONS PENDING:
  - Section 4 has an animated marquee in the reference. Native Elementor
    has no marquee widget. Options:
      a) Replace with image-carousel of logos
      b) Use animated-headline with rotating words
      c) Static image-carousel (no animation)

QUESTION: Approve as-is, or which sections should I adjust?
```

## Concrete example

```
PAGE: Home  (slug: /)
─────────────────────────────────────────────────────────────
1. Hero
   Goal: First impression + primary CTA
   Content: H1 "Build sites faster", body 2 lines, button "Start now"
   Widgets:    container + heading + text-editor + button + image       [recommended]
   Alternative: container + image (background) + inner container + heading + button
   Responsive: stack to column on mobile, image below text
   Assets:     hero-illustration.svg
─────────────────────────────────────────────────────────────
2. Logos strip
   Goal: Social proof
   Content: 6 client logos
   Widgets:    image-carousel (autoplay, no nav, slow)                  [recommended]
   Alternative: container (flex row) + 6 × image
   Assets:     logo-1.svg ... logo-6.svg
─────────────────────────────────────────────────────────────
3. Three features
   Goal: Explain key value props
   Content: 3 cards with icon + heading + 2-line description
   Widgets:    container (flex row) + 3 × icon-box                      [recommended]
   Alternative: 3 × image-box if user wants images instead of icons
   Responsive: column on mobile, gap 24px
─────────────────────────────────────────────────────────────
4. Testimonials
   Goal: Build trust with quotes
   Content: 4 testimonials, photo + quote + name + role
   Widgets:    testimonial-carousel                                     [recommended]
   Alternative: container + 4 replicated testimonial widgets (grid)
   Assets:     person-1.jpg ... person-4.jpg
─────────────────────────────────────────────────────────────
5. FAQ
   Goal: Address top 6 objections
   Content: 6 Q/A pairs
   Widgets:    accordion (one open by default)                          [recommended]
   Alternative: tabs (vertical layout)
─────────────────────────────────────────────────────────────
6. Final CTA
   Goal: Convert
   Content: H2 "Ready to start?" + button "Get started free"
   Widgets:    container + heading + button                             [recommended]
   Alternative: call-to-action widget (composite)
─────────────────────────────────────────────────────────────

ASSETS REQUIRED:
  - hero-illustration.svg
  - logo-1.svg ... logo-6.svg
  - person-1.jpg ... person-4.jpg

GLOBALS:
  Header / Footer: locked
  Colors: Primary (navy), Secondary (orange), Text, Accent (off-white)
  Fonts:  Primary (Playfair Display), Secondary (Inter)

LIMITATIONS:
  None — all sections replicable with native widgets.

QUESTION: Approve as-is, or which sections should I adjust?
```

## Adjustments grammar

The user may reply with:

- **Bulk approval**: "approved", "ok", "go", "yes", "build it"
- **Targeted change**: "section 3 use option B" / "section 5 swap accordion for tabs"
- **Content change**: "in section 1 change the headline to '...'"
- **Add/remove**: "remove section 2" / "add a stats section between 3 and 4"
- **Mixed**: "ok but section 4 use the grid alternative"

Parse and apply. Only ask for clarification if ambiguous.

## After approval

1. Confirm asset mapping in the next turn (separate, single turn).
2. Build.
3. Validate.
4. Deliver.
