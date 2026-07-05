# Runtime Prechecks

Run these before any other action. If any fails, abort with a clear message telling the user exactly what failed and the specific command to fix it. Do not continue.

## Order

1. **DDEV project path provided.** If the user did not provide it, ask once. Do not guess.
2. **Path exists and contains `.ddev/config.yaml`.**
   ```bash
   test -f "$DDEV_PATH/.ddev/config.yaml" || abort "Not a DDEV project: $DDEV_PATH"
   ```
3. **Docker running.**
   ```bash
   docker info >/dev/null 2>&1 || abort "Docker is not running. Start Docker Desktop."
   ```
4. **DDEV project is up.**
   ```bash
   cd "$DDEV_PATH" && ddev describe -j 2>/dev/null | grep -q '"status":"running"' \
     || abort "DDEV project is not running. Run: ddev start"
   ```
5. **WordPress is reachable.** Get the primary URL from `ddev describe -j` and curl it:
   ```bash
   SITE_URL=$(ddev describe -j | jq -r '.raw.primary_url')
   curl -sf -o /dev/null "$SITE_URL" || abort "WordPress not reachable at $SITE_URL"
   ```
6. **WP-CLI works.**
   ```bash
   ddev wp core version >/dev/null 2>&1 || abort "WP-CLI not available via ddev wp"
   ```
7. **Elementor active.**
   ```bash
   ddev wp plugin is-active elementor || abort "Elementor is not active"
   ```
8. **ProElements active.** Plugin slug is typically `pro-elements`. Verify:
   ```bash
   ddev wp plugin is-active pro-elements || abort "ProElements is not active"
   ```
9. **Admin user exists.** Get the first admin to use for ownership of created posts:
   ```bash
   ADMIN_ID=$(ddev wp user list --role=administrator --field=ID --number=1)
   [ -n "$ADMIN_ID" ] || abort "No administrator user found"
   ```
10. **Active Elementor kit exists.** Required for global tokens.
    ```bash
    KIT_ID=$(ddev wp option get elementor_active_kit)
    [ -n "$KIT_ID" ] && [ "$KIT_ID" != "0" ] || abort "No active Elementor kit. Open Elementor once in admin to initialize."
    ```

## Output of prechecks

The skill must capture and persist these values to `_skill_state/env.json`:

```json
{
  "ddev_path": "...",
  "site_url": "...",
  "admin_id": 1,
  "kit_id": 4,
  "elementor_version": "...",
  "pro_elements_version": "...",
  "wp_version": "..."
}
```

These are reused throughout the session — do not re-query them on every step.

## Common failure messages and fixes

| Failure | Message to user |
|---|---|
| Docker not running | "Docker Desktop is not running. Start it and run the skill again." |
| DDEV not started | "Run `ddev start` inside `<path>` and try again." |
| Elementor inactive | "Activate Elementor: `ddev wp plugin activate elementor`" |
| ProElements inactive | "Activate ProElements: `ddev wp plugin activate pro-elements`" |
| No active kit | "Open Elementor once from wp-admin so it creates the active kit, then re-run." |
