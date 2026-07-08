#!/usr/bin/env bash
# inject_elementor_data.sh — write _elementor_data to a post and flush caches
# Usage: scripts/inject_elementor_data.sh <post_id> <json_file_path>

set -euo pipefail

POST_ID="${1:-}"
JSON_FILE="${2:-}"

if [ -z "$POST_ID" ] || [ -z "$JSON_FILE" ]; then
  echo "ERROR: usage: $0 <post_id> <json_file_path>" >&2
  exit 2
fi

if [ ! -f "$JSON_FILE" ]; then
  echo "ERROR: JSON file not found: $JSON_FILE" >&2
  exit 2
fi

# Validate JSON parses
if ! jq empty "$JSON_FILE" 2>/dev/null; then
  echo "ERROR: JSON file is not valid JSON: $JSON_FILE" >&2
  exit 3
fi

# Validate top-level is array
TOP_TYPE=$(jq -r 'type' "$JSON_FILE")
if [ "$TOP_TYPE" != "array" ]; then
  echo "ERROR: top-level must be an array, got: $TOP_TYPE" >&2
  exit 3
fi

# Confirm post exists
if ! ddev wp post get "$POST_ID" --field=ID >/dev/null 2>&1; then
  echo "ERROR: post ID $POST_ID does not exist" >&2
  exit 4
fi

# Set Elementor edit mode and template if not already set
ddev wp post meta update "$POST_ID" _elementor_edit_mode "builder" >/dev/null

# Set canvas template only for pages (not for elementor_library entries)
POST_TYPE=$(ddev wp post get "$POST_ID" --field=post_type | tr -d '\r\n')
if [ "$POST_TYPE" = "page" ]; then
  CURRENT_TEMPLATE=$(ddev wp post meta get "$POST_ID" _wp_page_template 2>/dev/null | tr -d '\r\n' || true)
  if [ -z "$CURRENT_TEMPLATE" ] || [ "$CURRENT_TEMPLATE" = "default" ]; then
    ddev wp post meta update "$POST_ID" _wp_page_template "elementor_canvas" >/dev/null
  fi
fi

# Inject the JSON. Use --format=json so WP-CLI handles serialization.
# Pipe via stdin to avoid arg-length and shell-escaping issues.
cat "$JSON_FILE" | ddev wp post meta update "$POST_ID" _elementor_data --format=json >/dev/null

# Flush Elementor CSS cache (command may not exist on older versions)
ddev wp elementor flush_css >/dev/null 2>&1 || true

# Flush WP cache
ddev wp cache flush >/dev/null 2>&1 || true

echo "OK: injected _elementor_data into post $POST_ID ($(wc -c < "$JSON_FILE") bytes)"
