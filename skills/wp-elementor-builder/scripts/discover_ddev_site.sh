#!/usr/bin/env bash
# discover_ddev_site.sh — runtime prechecks for wp-elementor-builder
# Usage: scripts/discover_ddev_site.sh <ddev_project_path>
# Exits 0 with JSON to stdout if all checks pass.
# Exits non-zero with an error message to stderr otherwise.

set -euo pipefail

DDEV_PATH="${1:-}"
if [ -z "$DDEV_PATH" ]; then
  echo "ERROR: missing ddev project path" >&2
  echo "Usage: $0 <ddev_project_path>" >&2
  exit 2
fi

if [ ! -d "$DDEV_PATH" ]; then
  echo "ERROR: path does not exist: $DDEV_PATH" >&2
  exit 2
fi

if [ ! -f "$DDEV_PATH/.ddev/config.yaml" ]; then
  echo "ERROR: not a DDEV project (no .ddev/config.yaml): $DDEV_PATH" >&2
  exit 2
fi

# Docker
if ! docker info >/dev/null 2>&1; then
  echo "ERROR: Docker is not running. Start Docker Desktop and try again." >&2
  exit 3
fi

# DDEV
if ! command -v ddev >/dev/null 2>&1; then
  echo "ERROR: ddev not found in PATH. Install DDEV: https://ddev.com/" >&2
  exit 3
fi

cd "$DDEV_PATH"

# DDEV running
DDEV_STATUS=$(ddev describe -j 2>/dev/null || true)
if [ -z "$DDEV_STATUS" ] || ! echo "$DDEV_STATUS" | grep -q '"status":"running"'; then
  echo "ERROR: DDEV project is not running. Run: cd $DDEV_PATH && ddev start" >&2
  exit 3
fi

# jq required for parsing
if ! command -v jq >/dev/null 2>&1; then
  echo "ERROR: jq is required. Install jq (brew install jq / apt-get install jq)." >&2
  exit 3
fi

SITE_URL=$(echo "$DDEV_STATUS" | jq -r '.raw.primary_url')
if [ -z "$SITE_URL" ] || [ "$SITE_URL" = "null" ]; then
  echo "ERROR: could not determine site URL from ddev describe" >&2
  exit 3
fi

# WordPress reachable
if ! curl -sfk -o /dev/null --max-time 10 "$SITE_URL"; then
  echo "ERROR: WordPress not reachable at $SITE_URL" >&2
  exit 4
fi

# WP-CLI working
if ! ddev wp core version >/dev/null 2>&1; then
  echo "ERROR: WP-CLI not available via 'ddev wp'. Is WordPress installed?" >&2
  exit 4
fi

WP_VERSION=$(ddev wp core version 2>/dev/null | tr -d '\r\n')

# Elementor active
if ! ddev wp plugin is-active elementor >/dev/null 2>&1; then
  echo "ERROR: Elementor is not active. Run: ddev wp plugin activate elementor" >&2
  exit 5
fi

ELEMENTOR_VERSION=$(ddev wp plugin get elementor --field=version 2>/dev/null | tr -d '\r\n')

# ProElements active (slug is pro-elements)
if ! ddev wp plugin is-active pro-elements >/dev/null 2>&1; then
  echo "ERROR: ProElements is not active. Run: ddev wp plugin activate pro-elements" >&2
  exit 5
fi

PRO_ELEMENTS_VERSION=$(ddev wp plugin get pro-elements --field=version 2>/dev/null | tr -d '\r\n')

# Admin user
ADMIN_ID=$(ddev wp user list --role=administrator --field=ID --number=1 2>/dev/null | head -n1 | tr -d '\r\n')
if [ -z "$ADMIN_ID" ]; then
  echo "ERROR: no administrator user found" >&2
  exit 5
fi

# Active kit
KIT_ID=$(ddev wp option get elementor_active_kit 2>/dev/null | tr -d '\r\n')
if [ -z "$KIT_ID" ] || [ "$KIT_ID" = "0" ]; then
  echo "ERROR: no active Elementor kit. Open Elementor once in wp-admin (Templates → Site Settings) and try again." >&2
  exit 5
fi

# All good — emit env JSON
cat <<EOF
{
  "ddev_path": "$DDEV_PATH",
  "site_url": "$SITE_URL",
  "admin_id": $ADMIN_ID,
  "kit_id": $KIT_ID,
  "wp_version": "$WP_VERSION",
  "elementor_version": "$ELEMENTOR_VERSION",
  "pro_elements_version": "$PRO_ELEMENTS_VERSION"
}
EOF
