---
name: wp-elementor-builder
description: "Guided WordPress page builder for DDEV environments using native Elementor and ProElements widgets via JSON injection."
category: development
risk: safe
source: community
source_repo: soydiazweb/wp-elementor-builder
source_type: community
date_added: "2026-07-02"
author: soydiazweb
tags: [wordpress, elementor, ddev, page-builder, proelements]
tools: [claude, cursor, gemini, antigravity]
---

# WordPress Elementor Builder (DDEV)

This skill assembles WordPress pages on a local DDEV environment using only native Elementor and ProElements widgets. It never touches theme files, never injects external CSS, and never decides silently when a design choice is ambiguous.

## When to Use

Use this skill when the user provides screenshots, HTML, or design references and asks to build them as WordPress pages on a local DDEV project with Elementor + ProElements active. Typical triggers:

- "build this landing page in my local WordPress"
- "I have screenshots of 5 pages, assemble them in Elementor on ddev"
- "replicate this HTML using only native Elementor widgets"

Do not use for: live production sites, theme/plugin development, sites without DDEV, or sites without Elementor + ProElements active.

## Core Principles

1. **Native widgets only.** No theme CSS, no Custom HTML widget as structural base, no third-party plugins, no shortcodes as primary layout.
2. **JSON-first build.** Pages are constructed by writing valid Elementor JSON to the `_elementor_data` postmeta via WP-CLI. The browser is used only to validate render and capture screenshots.
3. **Globals before pages.** Design tokens (Global Colors + Global Fonts), then header and footer as Theme Builder templates, then pages.
4. **Locked after approval.** Once globals are approved they are reused everywhere and only changed if the user explicitly reopens them.
5. **Consolidated page proposals.** Each page is proposed as a single blueprint with recommended widgets per section plus alternatives; section-by-section conversation only happens for genuine ambiguity.
6. **Draft → validate → publish.** Pages are created as drafts, built, validated visually, and only then published.
7. **Persistent blueprint.** State is written to `./_skill_state/blueprint.json` before every injection so the build is idempotent and recoverable.

## The Flow (Mandatory Order)

### 0. Read references before acting

Before doing anything, read these files from this skill's directory:

- `references/runtime-prechecks.md`
- `references/conversation-flow.md`
- `references/design-tokens.md`
- `references/theme-builder-templates.md`
- `references/custom-post-types.md` — when and how to register CPTs needed by `posts` widgets
- `references/elementor-native-widgets.md`
- `references/elementor-json-schema.md`
- `references/page-analysis-rules.md`
- `references/page-proposal-format.md`
- `references/admin-build-flow.md`
- `references/asset-pipeline.md`
- `references/validation-and-screenshots.md`
- `references/revision-flow.md`
- `references/failure-recovery.md`
- `references/validation-checklist.md`
- `references/section-templates-index.md` — what's available in `section-templates/`
- `references/dynamic-section-generation.md` — how to generate JSON when no template fits

Skim them. They define exact commands, JSON shapes, and decision rules. For each section in a page, prefer a curated `section-templates/*.json` when one fits. When no template fits, generate the JSON inline per `dynamic-section-generation.md` and save it to `section.inline_json` in the blueprint. After a successful build, offer to harvest the inline section as a new reusable template.

### 1. Prechecks

Run `scripts/discover_ddev_site.sh <ddev_project_path>`. It validates:

- Docker running
- DDEV functional
- WordPress reachable
- Elementor active
- ProElements active
- WP-CLI available via `ddev wp`
- Admin access available

Abort cleanly if any check fails. Report exactly which check failed and how to fix it. Do not continue.

### 1.5. Detect required Custom Post Types

Scan all pages in the input. If any page proposal will use templates that need CPTs (`posts-events-list-vertical` → `evento`, `posts-resources-cards-list` → `recurso`, `posts-cases-carousel` → `caso`, etc.), present the registration plan to the user in a single turn.

After approval, write `wp-content/mu-plugins/wp-elementor-builder-cpts.php` per `references/custom-post-types.md`. Verify with `ddev wp post-type list`.

This happens once at the start, even if some CPTs are needed by pages later in the flow. Do not interrupt page builds for CPT registration.

If no dynamic listings are detected in the inputs, skip this step.

### 2. Initial input analysis

Inventory all inputs the user provided (screenshots, HTML, assets, text). Detect:

- how many pages there are
- approximate sections per page
- shared header/footer regions
- color palette and typography hints

Present a **consolidated preliminary inventory** for the user to confirm or adjust before going deeper. Example:

> Detected 3 pages: Home (6 sections), About (4 sections), Contact (3 sections). Shared header and footer across all. Palette appears to be navy + warm orange + off-white. Typography looks like a serif heading + sans body. Confirm before I propose globals?

Wait for confirmation.

### 3. Design tokens (NEW — before header/footer)

Propose Global Colors and Global Fonts based on the references. Write them to Elementor's active kit (`elementor_active_kit` option → postmeta on that kit post).

Use `references/design-tokens.md` for the exact procedure. After approval, every widget references these tokens by ID, never by literal value. This is what makes future palette changes propagate without rebuilding pages.

Locked after approval.

### 4. Header and Footer (Theme Builder templates)

Header and footer are NOT pages. They are entries in the `elementor_library` post type with `_elementor_template_type` set to `header` or `footer`, plus display conditions for "entire site".

Propose 2–3 concrete native-widget combinations for each. Build the approved one via JSON injection into the template post. Locked after approval.

See `references/theme-builder-templates.md`.

### 5. Page-by-page loop

For each page, in the order confirmed in step 2:

1. **Analyze** the page completely.
2. **Propose** a consolidated blueprint (see `references/page-proposal-format.md`):
   - one table-like view with all sections
   - recommended widget combination per section
   - 1–2 alternatives where they matter
   - assets required (filenames)
3. **Wait for approval** in one turn. Accept bulk approval or targeted adjustments ("use option B in section 3").
4. **Confirm asset mapping** for the whole page in a single turn (never per-widget).
5. **Build:**
   - create WP post as `draft`
   - for each section in the approved blueprint, decide between template (set `section.template`) or inline (set `section.inline_json` per `dynamic-section-generation.md`)
   - assemble JSON via `scripts/page_blueprint_from_input.js` (it handles both)
   - the composer validates the result against `references/widget-catalog.json` and shape rules; bad JSON aborts the build before injection
   - inject `_elementor_data` and `_elementor_edit_mode` via `scripts/inject_elementor_data.sh`
   - persist blueprint to `_skill_state/blueprint.json`
6. **Validate:**
   - run `scripts/validate_page.js` (Playwright) to render the public URL and capture desktop + mobile screenshots
   - compare against the reference if available
7. **Publish** only if validation passes. If it fails, keep as draft and report.
8. **Deliver:** URL, screenshots, summary of what was built, any diffs detected.
9. **Harvest (optional):** if any section was built from `inline_json`, offer to save it as a reusable `section-templates/<slug>.json` for future pages. If the user agrees, write the pre-substitution JSON and update the blueprint section to reference the new template.

Move to next page.

### 6. Revisions

- **Reopen a section:** locate it in the existing page JSON, propose alternatives, regenerate only that section, rewrite the full `_elementor_data` for the page.
- **Reopen header/footer:** regenerate the template, all pages reflect changes automatically.
- **Reopen design tokens:** update the kit, all pages and templates inherit the change.

See `references/revision-flow.md`.

## Hard Rules

- Never modify theme files. Never write CSS to the theme.
- Never use the Custom HTML widget as structural base. Only as a last-resort exception with explicit user approval.
- Never use third-party page-builder plugins to fill gaps.
- Never hardcode colors or font families in widget settings when a Global token exists.
- Never publish a page that failed validation.
- Never ask the user to confirm assets one by one; always present the full page mapping in a single turn.
- Never rebuild a whole page when only a section changed.
- If a design element cannot be reproduced exactly with native widgets, propose alternatives and let the user choose. Do not silently approximate.
- Never invent widget settings or `widgetType` values from memory. When generating inline JSON, follow `references/dynamic-section-generation.md` and use only `widgetType` values from `references/widget-catalog.json`.

## Inputs the Skill Expects

- `ddev` project path (required)
- screenshots and/or HTML (at least one source required)
- assets in `./_input/assets/` or path provided
- optional: final copy/text
- optional: page order and slugs

## Outputs the Skill Returns Per Page

- public URL of the built page
- desktop screenshot (1440px) and mobile screenshot (390px)
- short summary of sections and widgets used
- visual diffs detected against the reference (if any)
- pending items if anything needs the user before completion
- path to persisted blueprint for audit/retry

## Failure Recovery

If a build fails partway through:

- the page stays as `draft`
- blueprint persists in `_skill_state/blueprint.json`
- the user can re-trigger the build for that page; the skill resumes using the blueprint

See `references/failure-recovery.md`.
