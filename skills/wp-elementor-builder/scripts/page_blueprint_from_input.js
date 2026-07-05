#!/usr/bin/env node
/**
 * page_blueprint_from_input.js — assemble Elementor page JSON.
 *
 * For each section in the blueprint:
 *   - If section.template is set → load section-templates/<n>.json, fill placeholders.
 *   - Else if section.inline_json is set → use that object/array directly (regenerating IDs).
 *   - Else → error.
 *
 * Validates the composed JSON against the schema rules in
 * references/elementor-json-schema.md before writing.
 *
 * Usage:
 *   node scripts/page_blueprint_from_input.js \
 *     --blueprint _skill_state/blueprint.json \
 *     --page-id 30 \
 *     --templates-dir section-templates \
 *     --catalog references/widget-catalog.json \
 *     --out _skill_state/elementor-data-page-30.json
 */

const fs = require('fs');
const path = require('path');

function parseArgs(argv) {
  const args = {};
  for (let i = 0; i < argv.length; i++) {
    const a = argv[i];
    if (a.startsWith('--')) {
      const key = a.slice(2);
      const next = argv[i + 1];
      if (!next || next.startsWith('--')) { args[key] = true; }
      else { args[key] = next; i++; }
    }
  }
  return args;
}

function newId() {
  return Math.random().toString(16).slice(2, 9).padStart(7, '0');
}

/**
 * Recursively walk an Elementor element tree:
 *  - regenerate every `id` field
 *  - replace __CONTENT_*__ tokens in strings
 *  - replace __ASSET_*__ tokens in image-shaped objects
 */
function fillTemplate(element, content = {}, assetsMap = {}) {
  if (Array.isArray(element)) {
    return element.map(e => fillTemplate(e, content, assetsMap));
  }
  if (element === null || typeof element !== 'object') return element;

  const out = {};
  for (const [k, v] of Object.entries(element)) {
    if (k === 'id') {
      out.id = newId();
    } else if (k === 'elements') {
      out.elements = fillTemplate(v, content, assetsMap);
    } else if (k === 'settings') {
      out.settings = fillSettings(v, content, assetsMap);
    } else {
      out[k] = v;
    }
  }
  return out;
}

function fillSettings(settings, content, assetsMap) {
  const out = {};
  for (const [k, v] of Object.entries(settings)) {
    out[k] = fillValue(v, content, assetsMap, k);
  }
  return out;
}

function fillValue(v, content, assetsMap, key = '') {
  if (typeof v === 'string') {
    return v.replace(/__CONTENT_([A-Z0-9_]+)__/g, (_, name) => {
      const k = name.toLowerCase();
      return content[k] !== undefined ? String(content[k]) : '';
    });
  }
  if (Array.isArray(v)) {
    return v.map(item => fillValue(item, content, assetsMap));
  }
  if (v && typeof v === 'object') {
    if ('id' in v && 'url' in v && typeof v.id === 'string' && v.id.startsWith('__ASSET_')) {
      const filename = v.id.replace(/^__ASSET_/, '').replace(/__$/, '');
      const asset = assetsMap[filename];
      if (asset) return { id: asset.attachment_id, url: asset.url };
      // Leave placeholder intact so validation catches it as unresolved
      return v;
    }
    const out = {};
    for (const [k, val] of Object.entries(v)) {
      out[k] = fillValue(val, content, assetsMap, k);
    }
    return out;
  }
  return v;
}

/* ---------- Validation ---------- */

const ALLOWED_EL_TYPES = new Set(['container', 'section', 'column', 'widget']);

/**
 * Strict validation against Elementor JSON schema rules.
 * Returns array of error strings; empty array = valid.
 */
function validate(json, allowedWidgetTypes) {
  const errors = [];
  const seenIds = new Set();

  if (!Array.isArray(json)) {
    errors.push('Top-level must be an array');
    return errors;
  }

  function walk(el, pathStr) {
    if (!el || typeof el !== 'object' || Array.isArray(el)) {
      errors.push(`${pathStr}: element must be an object`);
      return;
    }
    if (typeof el.id !== 'string' || !el.id) {
      errors.push(`${pathStr}: missing id`);
    } else {
      if (seenIds.has(el.id)) {
        errors.push(`${pathStr}: duplicate id "${el.id}"`);
      }
      seenIds.add(el.id);
    }
    if (!ALLOWED_EL_TYPES.has(el.elType)) {
      errors.push(`${pathStr}: invalid elType "${el.elType}"`);
    }
    if (typeof el.settings !== 'object' || el.settings === null || Array.isArray(el.settings)) {
      errors.push(`${pathStr}: settings must be an object`);
    }
    if (!Array.isArray(el.elements)) {
      errors.push(`${pathStr}: elements must be an array`);
    }
    if (el.elType === 'widget') {
      if (typeof el.widgetType !== 'string' || !el.widgetType) {
        errors.push(`${pathStr}: widget missing widgetType`);
      } else if (allowedWidgetTypes && !allowedWidgetTypes.has(el.widgetType)) {
        errors.push(`${pathStr}: widgetType "${el.widgetType}" not in allowed catalog`);
      }
      if (Array.isArray(el.elements) && el.elements.length > 0) {
        errors.push(`${pathStr}: widget must have empty elements array`);
      }
    }
    if (el.settings && typeof el.settings === 'object') {
      checkImageShape(el.settings, `${pathStr}.settings`);
      checkLinkShape(el.settings, `${pathStr}.settings`);
      checkUnreplacedTokens(el.settings, `${pathStr}.settings`);
    }
    if (Array.isArray(el.elements)) {
      el.elements.forEach((child, i) => walk(child, `${pathStr}.elements[${i}]`));
    }
  }

  function checkImageShape(settings, pathStr) {
    for (const [k, v] of Object.entries(settings)) {
      if (k === 'image' && v && typeof v === 'object') {
        if (!('id' in v) || !('url' in v)) {
          errors.push(`${pathStr}.${k}: image must have both id and url`);
        }
        if (typeof v.id === 'string' && v.id.startsWith('__ASSET_')) {
          errors.push(`${pathStr}.${k}: unresolved asset placeholder "${v.id}"`);
        }
      }
    }
  }

  function checkLinkShape(settings, pathStr) {
    for (const [k, v] of Object.entries(settings)) {
      if (k === 'link' && v && typeof v === 'object') {
        if (!('url' in v)) {
          errors.push(`${pathStr}.${k}: link must have url`);
        }
      }
    }
  }

  function checkUnreplacedTokens(obj, pathStr) {
    for (const [k, v] of Object.entries(obj)) {
      if (typeof v === 'string') {
        if (/__CONTENT_[A-Z0-9_]+__/.test(v)) {
          errors.push(`${pathStr}.${k}: unreplaced content token in "${v.slice(0, 60)}"`);
        }
        if (/__ASSET_[A-Z0-9_]+__/.test(v)) {
          errors.push(`${pathStr}.${k}: unreplaced asset token in "${v.slice(0, 60)}"`);
        }
      } else if (v && typeof v === 'object' && !Array.isArray(v)) {
        checkUnreplacedTokens(v, `${pathStr}.${k}`);
      }
    }
  }

  json.forEach((el, i) => walk(el, `[${i}]`));
  return errors;
}

function loadAllowedWidgetTypes(catalogPath) {
  if (!catalogPath || !fs.existsSync(catalogPath)) return null;
  try {
    const cat = JSON.parse(fs.readFileSync(catalogPath, 'utf8'));
    return new Set(cat.widgets || []);
  } catch (err) {
    console.error(`WARN: could not load catalog ${catalogPath}: ${err.message}`);
    return null;
  }
}

function main() {
  const args = parseArgs(process.argv.slice(2));
  const required = ['blueprint', 'page-id', 'out'];
  for (const k of required) {
    if (!args[k]) { console.error(`ERROR: missing --${k}`); process.exit(2); }
  }

  const blueprintPath = args.blueprint;
  const pageId = parseInt(args['page-id'], 10);
  const templatesDir = args['templates-dir'] || 'section-templates';
  const catalogPath = args['catalog'] || path.join('references', 'widget-catalog.json');
  const outPath = args.out;
  const skipValidation = args['skip-validation'] === true;

  const bp = JSON.parse(fs.readFileSync(blueprintPath, 'utf8'));
  const page = (bp.pages || []).find(p => p.page_id === pageId);
  if (!page) {
    console.error(`ERROR: page_id ${pageId} not found in blueprint`);
    process.exit(2);
  }

  const assetsMap = bp.assets_library || {};
  const composed = [];

  for (const section of page.sections || []) {
    let raw;
    let sourceLabel;

    if (section.template) {
      const tplPath = path.join(templatesDir, `${section.template}.json`);
      if (!fs.existsSync(tplPath)) {
        console.error(`ERROR: template not found: ${tplPath}`);
        process.exit(3);
      }
      raw = JSON.parse(fs.readFileSync(tplPath, 'utf8'));
      sourceLabel = `template:${section.template}`;
    } else if (section.inline_json) {
      raw = section.inline_json;
      sourceLabel = `inline:${section.section_id}`;
    } else {
      console.error(`ERROR: section ${section.section_id} has neither "template" nor "inline_json"`);
      process.exit(3);
    }

    const content = section.content || {};
    const filled = fillTemplate(raw, content, assetsMap);

    if (Array.isArray(filled)) {
      composed.push(...filled);
    } else {
      composed.push(filled);
    }

    console.error(`  composed section ${section.section_id || '(unknown)'} from ${sourceLabel}`);
  }

  if (!skipValidation) {
    const allowed = loadAllowedWidgetTypes(catalogPath);
    const errors = validate(composed, allowed);
    if (errors.length > 0) {
      console.error('VALIDATION FAILED:');
      errors.slice(0, 20).forEach(e => console.error(`  - ${e}`));
      if (errors.length > 20) console.error(`  ... and ${errors.length - 20} more`);
      const badPath = outPath + '.invalid';
      fs.mkdirSync(path.dirname(badPath), { recursive: true });
      fs.writeFileSync(badPath, JSON.stringify(composed, null, 2));
      console.error(`Bad JSON written to ${badPath} for inspection`);
      process.exit(4);
    }
  }

  fs.mkdirSync(path.dirname(outPath), { recursive: true });
  fs.writeFileSync(outPath, JSON.stringify(composed, null, 2));
  console.log(`OK: wrote ${composed.length} top-level sections to ${outPath}`);
}

main();
