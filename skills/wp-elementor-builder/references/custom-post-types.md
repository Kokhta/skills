# Custom Post Types

Many sections in templates use the `posts` widget to render dynamic listings (blog, events, resources, cases, testimonials, team). For those listings to have content, the matching Custom Post Type must exist in WordPress.

This document defines how the skill detects which CPTs are needed, registers them, and seeds initial content.

## Detection rules

When analyzing a page proposal, the skill flags a CPT requirement whenever a section template uses the `posts` widget with `posts_post_type` set to a value other than `post` (the WP default).

Scan templates that need CPTs:

| Template | `post_type` | When it appears |
|---|---|---|
| `posts-blog-featured-plus-3` | `post` (native) | Blog listing |
| `posts-blog-3col` | `post` or any | Blog grid on home |
| `posts-events-list-vertical` | `evento` | Events list (e.g. "Próximos Eventos") |
| `posts-resources-cards-list` | `recurso` | Downloadable resources |
| `posts-cases-carousel` | `caso` | Cases / Campaigns / Trabajos |

If a content key in the blueprint says `post_type: caso` and `caso` doesn't exist in WP, the skill must register it before building the page that lists it.

## Standard CPT slugs and labels

Always use these slugs unless the user overrides them. They are short, single-word, lowercase, no accents — the standard for stable WP development.

| Slug | Singular label | Plural label | Use case |
|---|---|---|---|
| `evento` | Evento | Eventos | Events / agenda |
| `recurso` | Recurso | Recursos | Downloadable PDFs, guides |
| `caso` | Caso | Casos | Cases, campaigns, portfolio entries |
| `testimonial` | Testimonial | Testimoniales | Reusable testimonials |
| `miembro` | Miembro | Miembros | Team members |
| `servicio` | Servicio | Servicios | Service entries (when not pages) |

If the user's site has a different convention (e.g. English slugs, plurals), let them override before registering.

## Registration via WP-CLI

WordPress doesn't ship with a UI for registering CPTs. The skill uses a small drop-in plugin written via WP-CLI so the registration is portable, version-controlled, and not tied to the active theme.

### Step 1 — Generate the registration plugin

The skill writes one file per CPT (or a single combined file) to `wp-content/mu-plugins/`. The `mu-plugins` directory loads automatically — no activation required.

```bash
DDEV_DOCROOT=$(ddev describe -j | jq -r '.raw.docroot')
MU_DIR="$DDEV_DOCROOT/wp-content/mu-plugins"
ddev exec mkdir -p "$MU_DIR"
```

Then create `wp-elementor-builder-cpts.php`:

```php
<?php
/**
 * Plugin Name: WP Elementor Builder — Custom Post Types
 * Description: CPT registrations created by wp-elementor-builder skill.
 * Version: 1.0
 */

add_action('init', function () {
    // EVENTOS
    register_post_type('evento', [
        'labels' => [
            'name'          => 'Eventos',
            'singular_name' => 'Evento',
            'add_new'       => 'Agregar evento',
            'add_new_item'  => 'Agregar nuevo evento',
            'edit_item'     => 'Editar evento',
            'all_items'     => 'Todos los eventos',
        ],
        'public'              => true,
        'has_archive'         => true,
        'show_in_rest'        => true,
        'menu_icon'           => 'dashicons-calendar-alt',
        'supports'            => ['title', 'editor', 'thumbnail', 'excerpt'],
        'rewrite'             => ['slug' => 'eventos'],
    ]);

    // RECURSOS
    register_post_type('recurso', [
        'labels' => [
            'name'          => 'Recursos',
            'singular_name' => 'Recurso',
        ],
        'public'              => true,
        'has_archive'         => true,
        'show_in_rest'        => true,
        'menu_icon'           => 'dashicons-download',
        'supports'            => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'],
        'rewrite'             => ['slug' => 'recursos'],
    ]);

    // CASOS / CAMPAÑAS
    register_post_type('caso', [
        'labels' => [
            'name'          => 'Casos',
            'singular_name' => 'Caso',
        ],
        'public'              => true,
        'has_archive'         => true,
        'show_in_rest'        => true,
        'menu_icon'           => 'dashicons-portfolio',
        'supports'            => ['title', 'editor', 'thumbnail', 'excerpt'],
        'rewrite'             => ['slug' => 'casos'],
    ]);

    // TESTIMONIALES
    register_post_type('testimonial', [
        'labels' => [
            'name'          => 'Testimoniales',
            'singular_name' => 'Testimonial',
        ],
        'public'              => true,
        'has_archive'         => false,
        'show_in_rest'        => true,
        'menu_icon'           => 'dashicons-format-quote',
        'supports'            => ['title', 'editor', 'thumbnail'],
    ]);

    // MIEMBROS / EQUIPO
    register_post_type('miembro', [
        'labels' => [
            'name'          => 'Miembros',
            'singular_name' => 'Miembro',
        ],
        'public'              => true,
        'has_archive'         => true,
        'show_in_rest'        => true,
        'menu_icon'           => 'dashicons-groups',
        'supports'            => ['title', 'editor', 'thumbnail'],
        'rewrite'             => ['slug' => 'equipo'],
    ]);
});

// Flush rewrite rules once after install
add_action('init', function () {
    if (get_option('wpeb_cpts_rewrite_flushed') !== '1') {
        flush_rewrite_rules();
        update_option('wpeb_cpts_rewrite_flushed', '1');
    }
}, 99);
```

The skill writes only the CPTs the project actually needs — it does not register all 5 by default.

### Step 2 — Trigger the registration

Once the file is in place, registration is automatic. Verify:

```bash
ddev wp post-type list --format=csv | grep -E "evento|recurso|caso|testimonial|miembro"
```

If a CPT doesn't appear, check the log:

```bash
ddev logs web | tail -50
```

### Step 3 — Flush rewrites

The plugin flushes rewrites once. If permalinks for CPT archives don't work:

```bash
ddev wp rewrite flush
```

## When to register CPTs in the flow

Add this step between **prechecks (step 1)** and **input analysis (step 2)** in the conversation flow:

```
1. Prechecks                          (env validation)
   ↓
1.5. Detect required CPTs              (NEW: scan blueprint for posts widgets)
   ↓
1.6. Confirm CPT registration plan     (NEW: show user which CPTs will be created, ask)
   ↓
1.7. Register approved CPTs            (NEW: write mu-plugin file, verify)
   ↓
2. Initial input analysis
   ...
```

The CPT step happens once at the start, even if it covers CPTs needed by pages later in the flow. This avoids interrupting page builds for plugin file writes.

### Confirmation message format

When asking the user to approve CPT registration:

```
Detected dynamic listings in your pages that require Custom Post Types:

  caso        → Casos/Campañas (used in: Home — sección "Algunos trabajos")
  evento      → Eventos        (used in: Home — sección "Próximos Eventos")
  recurso     → Recursos       (used in: Recursos — listing principal)

I'll register these by writing wp-content/mu-plugins/wp-elementor-builder-cpts.php.

Slugs above are defaults. Override any if you prefer different names.
Approve to continue?
```

## Seeding initial content

After registering CPTs, the listings would render empty. Two options:

### A. Skill seeds placeholder entries

When the user has no real content yet, the skill creates 3–5 placeholder posts per CPT so the listing widgets show something. Use:

```bash
for i in 1 2 3; do
  ddev wp post create \
    --post_type=evento \
    --post_title="Evento de ejemplo $i" \
    --post_content="<p>Descripción placeholder del evento $i</p>" \
    --post_status=publish \
    --post_author=$ADMIN_ID
done
```

Featured images come from the `assets_library` if the user provided generic event/case/resource imagery.

### B. User seeds real content

If the user has spreadsheet or CSV with real entries, the skill can ingest:

```bash
ddev wp post-type list  # confirm CPT exists
# user provides CSV: title, content, date, image_id (optional)
# skill loops through and creates real posts via wp post create
```

Always ask the user which path they prefer. Default to A (placeholders) so they see the layout immediately.

## Custom fields for specific CPTs

Some CPTs need extra fields beyond title/content:

- `evento` → start date, end date, location, registration URL
- `recurso` → file URL or attachment ID, file type icon
- `miembro` → role, social links

The skill does NOT install ACF or other custom-field plugins. It uses native postmeta:

```bash
ddev wp post meta update <post_id> evento_fecha "2026-05-15"
ddev wp post meta update <post_id> evento_hora "10:00"
ddev wp post meta update <post_id> recurso_archivo_id 42
```

Templates that consume these need to read meta. For the listing widgets used in this skill's templates, the `posts` widget reads title + excerpt + featured image — meta fields are surfaced via the post detail page (which would need its own template, future work).

For now, mention this limitation when building event/resource pages: "I can list them with title + image + excerpt. For dates, registration buttons, and download links per item, you'll either edit each post's body to include them, or we'll need single-post templates (next iteration)."

## Custom taxonomies for grouping CPTs

Some templates need to group CPT entries by category — for example `team-grid-4col-grouped` displays members grouped under "Directores", "Gerentes", "Projects Managers". This requires a custom taxonomy attached to the CPT.

### Pattern: `miembro` + `categoria_miembro`

Add to the same mu-plugin file, inside the same `init` action:

```php
// TAXONOMÍA: Categorías de miembro
register_taxonomy('categoria_miembro', 'miembro', [
    'labels' => [
        'name'              => 'Categorías de Miembro',
        'singular_name'     => 'Categoría de Miembro',
        'add_new_item'      => 'Agregar nueva categoría',
        'all_items'         => 'Todas las categorías',
    ],
    'public'              => true,
    'hierarchical'        => true,
    'show_in_rest'        => true,
    'show_admin_column'   => true,
]);
```

Then seed the terms (only once, after first install):

```bash
ddev wp term create categoria_miembro "Directores" --slug=directores
ddev wp term create categoria_miembro "Gerentes" --slug=gerentes
ddev wp term create categoria_miembro "Projects Managers" --slug=projects-managers
```

When using `team-grid-4col-grouped` in a blueprint, pass the term ID (returned by `wp term list`) into `content.group_term_id`. The skill's flow should fetch term IDs after creating the terms and store them in `globals.cpts.taxonomies`:

```jsonc
"globals": {
  "cpts": {
    "registered": ["miembro"],
    "taxonomies": {
      "categoria_miembro": {
        "directores":         { "term_id": 12 },
        "gerentes":           { "term_id": 13 },
        "projects-managers":  { "term_id": 14 }
      }
    }
  }
}
```

Then the page proposal references the term ID:

```jsonc
{
  "template": "team-grid-4col-grouped",
  "content": {
    "group_title": "Directores",
    "post_type": "miembro",
    "group_term_id": 12
  }
}
```

This pattern works for any CPT that needs grouping (e.g. `recurso` with `categoria_recurso` for filtering downloads by topic, `caso` with `industria` for filtering case studies).

## Removing CPTs

If the user wants to drop a CPT, do NOT delete the posts of that CPT first — they may be wanted later. Instead:

1. Comment out the registration block in the mu-plugin (or delete the plugin if all CPTs go).
2. Posts remain in the DB as orphaned but recoverable.
3. To fully remove: `ddev wp post delete $(ddev wp post list --post_type=<slug> --format=ids) --force` — only with explicit user confirmation.

## State persistence

After registering, update `_skill_state/blueprint.json`:

```jsonc
"globals": {
  "cpts": {
    "registered": ["evento", "recurso", "caso"],
    "plugin_path": "wp-content/mu-plugins/wp-elementor-builder-cpts.php",
    "registered_at": "2026-04-26T15:30:00Z"
  }
}
```

Subsequent sessions check this before proposing CPT registration again.
