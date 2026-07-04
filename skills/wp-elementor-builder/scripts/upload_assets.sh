#!/usr/bin/env bash
# upload_assets.sh — upload a directory of assets to WP media library
# Usage: scripts/upload_assets.sh <assets_dir> [output_map_file]
# Outputs JSON map of filename -> { attachment_id, url } on stdout

set -euo pipefail

ASSETS_DIR="${1:-}"
OUTPUT_FILE="${2:-/dev/stdout}"

if [ -z "$ASSETS_DIR" ] || [ ! -d "$ASSETS_DIR" ]; then
  echo "ERROR: assets directory not found: $ASSETS_DIR" >&2
  exit 2
fi

# Build JSON map iteratively
TMP_MAP=$(mktemp)
echo "{}" > "$TMP_MAP"

# Find all supported assets
shopt -s nullglob nocaseglob 2>/dev/null || true

while IFS= read -r -d '' FILE; do
  BASENAME=$(basename "$FILE")
  echo "Uploading: $BASENAME" >&2

  # ddev wp media import returns a line like:
  # Imported file '/path/to/file.jpg' as attachment ID 42.
  IMPORT_OUTPUT=$(ddev wp media import "$FILE" --porcelain 2>&1 || true)
  ATTACHMENT_ID=$(echo "$IMPORT_OUTPUT" | grep -oE '[0-9]+' | tail -n1 || true)

  if [ -z "$ATTACHMENT_ID" ]; then
    echo "WARN: failed to upload $BASENAME — output was: $IMPORT_OUTPUT" >&2
    continue
  fi

  URL=$(ddev wp post get "$ATTACHMENT_ID" --field=guid 2>/dev/null | tr -d '\r\n' || true)

  # Update map
  jq --arg key "$BASENAME" --argjson id "$ATTACHMENT_ID" --arg url "$URL" \
    '. + {($key): {attachment_id: $id, url: $url}}' "$TMP_MAP" > "$TMP_MAP.new"
  mv "$TMP_MAP.new" "$TMP_MAP"
done < <(find "$ASSETS_DIR" -type f \( \
    -iname '*.jpg' -o -iname '*.jpeg' -o -iname '*.png' -o -iname '*.webp' \
    -o -iname '*.gif' -o -iname '*.svg' -o -iname '*.mp4' -o -iname '*.webm' \
  \) -print0)

cat "$TMP_MAP" > "$OUTPUT_FILE"
rm -f "$TMP_MAP"

echo "Uploaded assets map written to: $OUTPUT_FILE" >&2
