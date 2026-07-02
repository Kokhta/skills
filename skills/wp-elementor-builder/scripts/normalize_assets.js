#!/usr/bin/env node
/**
 * normalize_assets.js — copy assets to a normalized output dir with kebab-case filenames.
 * No image processing (no resize, no format conversion). The skill defaults to
 * leaving images as-is to keep dependencies minimal. If you want resizing,
 * pre-process before placing in _input/assets/.
 *
 * Usage:
 *   node scripts/normalize_assets.js --in _input/assets --out _skill_state/assets-normalized
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
      if (!next || next.startsWith('--')) {
        args[key] = true;
      } else {
        args[key] = next; i++;
      }
    }
  }
  return args;
}

function kebab(name) {
  const ext = path.extname(name);
  const base = path.basename(name, ext);
  const k = base
    .normalize('NFD').replace(/[\u0300-\u036f]/g, '')   // strip accents
    .replace(/[^a-zA-Z0-9]+/g, '-')
    .replace(/^-+|-+$/g, '')
    .toLowerCase();
  return `${k}${ext.toLowerCase()}`;
}

function main() {
  const args = parseArgs(process.argv.slice(2));
  const inDir  = args.in  || '_input/assets';
  const outDir = args.out || '_skill_state/assets-normalized';

  if (!fs.existsSync(inDir)) {
    console.error(`ERROR: input dir not found: ${inDir}`);
    process.exit(2);
  }

  fs.mkdirSync(outDir, { recursive: true });

  const exts = new Set(['.jpg', '.jpeg', '.png', '.webp', '.gif', '.svg', '.mp4', '.webm']);
  const map = {};
  const files = fs.readdirSync(inDir);

  for (const f of files) {
    const src = path.join(inDir, f);
    const stat = fs.statSync(src);
    if (!stat.isFile()) continue;
    const ext = path.extname(f).toLowerCase();
    if (!exts.has(ext)) continue;

    const k = kebab(f);
    let dst = path.join(outDir, k);

    // collision handling
    let i = 1;
    while (fs.existsSync(dst)) {
      const base = path.basename(k, ext);
      dst = path.join(outDir, `${base}-${i}${ext}`);
      i++;
    }

    fs.copyFileSync(src, dst);
    map[f] = path.basename(dst);
  }

  console.log(JSON.stringify({ in: inDir, out: outDir, mapping: map }, null, 2));
}

main();
