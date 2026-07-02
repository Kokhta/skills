# Handoff: AVATIC — 3D Scroll-Journey Landing Page (آواتک)

## Overview
A single-page, right-to-left (RTL) Persian landing page for **Avatice / آواتک**, a digital
marketing agency. The page's signature feature is a full-viewport **WebGL "depth tunnel"**
(Three.js) behind the content: as the user scrolls, a camera flies forward through the tunnel
past a single 3D AVATIC logo (an extruded chevron/arrow) and a swarm of ~60 marketing-themed
3D icons. All page content (hero + lead form, services, stats, portfolio, testimonials, CTA,
footer) scrolls in glass-morphism panels layered over the 3D scene.

Goal of the page: convert visitors into leads for digital-marketing / web-design services,
driving them to two lead-capture forms and WhatsApp.

## About the Design Files
The files in this bundle are **design references created in HTML** — a working prototype that
demonstrates the intended look, motion, and behavior. They are **not** production code to copy
verbatim. The task is to **recreate this design in the target codebase's environment** (e.g.
React/Next.js, Vue/Nuxt, or a WordPress + Elementor theme with a custom block) using that
project's established patterns, form handling, and asset pipeline.

The prototype was authored as a "Design Component" (`.dc.html`) that runs against a small
in-house runtime (`support.js`). **Ignore the `<x-dc>`, `<helmet>`, `ref="{{ }}"`, `onClick="{{ }}"`,
and `<sc-for>` wrappers** — they are prototype-runtime syntax. What matters is the markup
structure, the inline styles, the Three.js scene code (in the logic class), and the copy.

## Fidelity
**High-fidelity (hifi).** Final colors, typography, spacing, motion, and copy are all present and
intended. Recreate the UI faithfully, including the WebGL tunnel. If a build target genuinely
cannot host WebGL (rare), fall back to a static dark starfield gradient — but the 3D tunnel is
the core of the concept and should be preserved where possible.

---

## Global Style / Design Tokens

### Colors
| Token | Hex | Use |
|---|---|---|
| Background (base) | `#070a0f` | Page background, canvas clear |
| Panel background | `rgba(8,14,20,.55)` | Glass cards (backdrop-blur 16px) |
| Primary cyan | `#2bb8ec` | Brand accent, buttons, links, 3D objects |
| Primary cyan (light) | `#7fe0ff` | Gradients, highlights, counter numerals |
| Primary cyan (deep) | `#1273a8` | Button gradient end |
| 3D palette | `#2bb8ec #7fe0ff #1f9cd6 #158bcb #49c6f0` | Tunnel icon tints |
| Text primary | `#eaf6fb` | Headings, body |
| Text secondary | `#a9c4d2` | Descriptions |
| Text muted | `#88a6b6` / `#5a8aa0` / `#6f93a6` | Captions, labels |
| WhatsApp green | gradient `#25d366 → #0f7a3a` | WhatsApp buttons |
| Warning red | `#ff6b6b` | Emphasis ("جواب نمیده", "خودکشی!") |
| Star gold | `#ffc64a` | Review stars |
| Border (subtle) | `rgba(43,184,236,.22)` | Panel borders |
| Fog (Three.js) | `#070a0f`, near 28 / far 230 | Depth fade |

### Typography
- **Vazirmatn** (Google Fonts, weights 300–900) — all Persian UI text. `direction: rtl`.
- **Space Mono** (400/700) — numerals, labels, tags, the "AVATIC" wordmark, English/LTR bits.
- Heading scale (clamp, responsive): H1 `clamp(30px,4vw,50px)/1.25` 800; section H2
  `clamp(24px,3.4vw,42px)` 800; card H3 21px 700; body 14–17px 400 line-height ~1.9–2.0.
- Counters: `clamp(34px,5vw,58px)` 800 Space Mono, color `#7fe0ff`.

### Spacing / Radius / Shadow
- Section vertical padding: 70–120px; content max-width 680–1080px, centered.
- Card padding: 26–30px. Radius: inputs/buttons 11–13px, cards/panels 20–24px, pills 999px.
- Panel shadow: `0 24px 70px rgba(0,0,0,.55)`; button glow: `0 10px 30px rgba(43,184,236,.4)`.
- Glass panels: `backdrop-filter: blur(16px) saturate(120%)` + `-webkit-` prefix.

### Reveal animation
Every `[data-reveal]` element starts at `opacity:0; translateY(36px)` and transitions to
`opacity:1; none` over `.85s cubic-bezier(.2,.7,.2,1)` when it enters the viewport
(top < 90% of viewport height). Counters (`[data-count]`) ease from 0 to target over 1500ms
(cubic ease-out) and render digits as **Persian numerals** (۰۱۲۳۴۵۶۷۸۹).

> **Implementation note:** In the target codebase prefer `IntersectionObserver` for reveals/counters.
> The prototype uses a scroll+interval polling fallback only because its sandbox blocks IO.

---

## The WebGL Tunnel (core feature)

A fixed full-viewport `<canvas>` (`position:fixed; inset:0; z-index:0`) sits behind all content.
A radial-gradient vignette div (`z-index:1`) darkens the edges; content sits at `z-index:2`.
Header/menu at `z-index:30–50`.

**Library:** Three.js r128. **Renderer:** `WebGLRenderer({antialias, alpha:true})`, pixelRatio
capped at 2. **Scene fog:** `Fog(0x070a0f, 28, 230)`. **Camera:** `PerspectiveCamera(62)` starting
at z=30.

**Scene contents (all recycle/"wrap" in a z-range Z_NEAR=24 → Z_FAR=−320, span 344):**
1. **One hero AVATIC logo** — extruded chevron `Shape` with an inner triangular hole and a bottom
   notch (recreates the logo), `ExtrudeGeometry` depth 0.9 + bevel, `MeshStandardMaterial`
   (color `#2bb8ec`, metalness .7, roughness .2, emissive `#0a4a70`), scaled 1.5, with a bright
   `EdgesGeometry` outline (`#bfeeff`). Slowly rotates on Y, pulses emissive. **Only one logo — do not duplicate it.**
2. **~60 marketing-themed 3D icons** built from shared low-poly primitives, mostly wireframe
   (`opacity .5`) in the 5-tint palette, ~30% solid metallic. Types (each a `THREE.Group`):
   `chart` (growth bars), `target` (concentric torus bullseye), `rocket`, `star` (extruded
   5-point review star), `coin` (ROI), `bubble` (chat/WhatsApp), `gear` (automation),
   `megaphone` (ads), `funnel` (sales funnel), `network` (atom/reach nodes). Each spins on 3
   axes, bobs sinusoidally, and drifts toward the camera; wraps back to far z when it passes.
3. **Structural tunnel walls** — two nested wireframe `CylinderGeometry` tubes (radii ~12 & ~15.5,
   open-ended, low opacity) rotating slowly → gives the "grid corridor" read.
4. **Streaming rings** — 46 additive-blended `TorusGeometry` rings (r~13–16) rushing past +
   22 inner depth rings (r~5–10) → speed & depth cues.
5. **Debris** — 30 wireframe octahedra/icosahedra/tetrahedra shards drifting forward.
6. **Two starfields** — 1500 near (size .5, `#9fe6ff`) + 900 far dust (size .28, `#4f9fd0`),
   additive, streaming toward camera and recycling.
7. **Lights** — ambient `#335066`, two moving point lights (`#2bb8ec`, `#7fe0ff`) that travel
   with the camera, one directional fill.

**Scroll → camera:** `progress = scrollY / (scrollHeight − innerHeight)`; camera target
`z = 30 − progress*230`, eased (`+= (target−z)*0.06`). **Mouse → parallax:** camera x/y offset
eased from pointer position; `lookAt` a point ~45 units ahead. A left-edge **depth rail** UI
reflects progress and shows the current "stop" number (01–10, one per section).

Full, commented scene + loop code is in the logic class of `AVATIC 3D Site.dc.html`
(method `_initThree()` and the `loop()` inside it) — port it directly.

---

## Screens / Sections (top → bottom, RTL)

The page is one scroll. Each section carries `data-screen-label` and `data-stop="1..10"`.

### 00 · Header (sticky, fixed, blur)
- Left (RTL): **hamburger** button (46×46, radius 13, cyan border) → opens off-canvas menu.
- Center: **logo** (`LOGO-2.png`, ~42px tall, drop-shadow) + wordmark "AVATIC" (Space Mono,
  letter-spacing .18em) with "آواتـک" beneath. Links to `#hero`.
- Right (hidden on mobile): two pill buttons — **"دوره تــورنــادو"** (cyan, → cart/Tornado
  course) and **"ارتباط در واتساپ"** (green, → `https://wa.me/989966330107`).

### Off-canvas menu (slides from left)
Overlay (blur) + panel (width min(380px,86vw), gradient bg). Contains: logo, close ✕, heading
"بر روی گزینه مناسب و مورد نظر خود کلیک کنید", and 4 link cards:
- "برای خرید دوره تــورنــادو **اینجا کلیک کنید**" → add product 26449 to cart
- "برای رزرو جلسه مـشـاوره **اینجا کلیک کنید**" → consultation landing page
- "برای ارتباط در واتساپ **اینجا کلیک کنید**" → `wa.me/989966330107` (green)
- "اگر صاحب کسب و کار هستید **اینجا کلیک کنید**" → `/work-with-avatice/`
- Footer text: "آژانس دیجیتال مارکتینگ آواتک . مجموعه سجاد شعیب"
Transform `translateX(-100%)` closed → `0` open, `.42s cubic-bezier(.5,.05,.2,1)`.

### 01 · Hero (`#hero`)
Two-column grid (1.05fr / .95fr), min-height 100vh.
- **Left:** pill badge "٪۱۰۰ تــســت شـــده"; H1 "جذب منظم و هفتگی **مشتریان جدید** برای کسب و کار شما"
  ("مشتریان جدید" in a cyan gradient text-clip); description paragraph (see copy file); a small
  logo + "بیش از ۲۴۷ نظر مثبت ★★★★★" row.
- **Right — Lead form (`#f`)**, glass panel: title "شروع همکاری — فرم تماس"; three inputs —
  (1) text "نام شما / نام کسب و کار" (optional), (2) tel "شماره موبایل *" (required),
  (3) text "به کدام خدمات ما نیاز دارید؟ *" (required); primary submit
  **"ارسال اطلاعات و شــروع هــمــکاری ›"**; helper text; green WhatsApp button
  **"ارسال پیام مستقیم در واتساپ (پاسخ‌دهی سریع‌تر)"**.

### 02 · Strategy
Centered. H2 "دیگه طراحی سایت و اجرای تبلیغات **جواب نمیده**" (last words red); subtitle
"در عوض از استراتژی زیر استفاده کنید — ویدئوی پایین را تماشا کنید"; **video embed** placeholder
(16:9, play button) → Aparat `yta05fa`.

### 03 · Client logos
Two infinite marquee rows (opposite directions): row 1 RTL (`52.png 221.png Untitled-1 48.webp
63.webp`), row 2 LTR (`121212 88.webp 49.webp 36.webp 78.webp`). Each logo a 150×64 tile.
Label "TRUSTED BY 100+ BUSINESSES". CSS `@keyframes mqR/mqL`, 32–34s linear infinite; duplicate
the track for seamless loop.

### 04 · Services
Heading "خـــدمـــات مـــا چــیســـت؟" + sub "ما فقط ۲ سرویس داریم — و خدماتی را که از آن مطمئن
نباشیم ارائه نمی‌دهیم". Two glass cards with a big faint "۱"/"۲" watermark:
- **۱. جذب مخاطب آنلاین** (🎯 icon) — online audience attraction copy.
- **۲. طراحی سایت** (🖥️ icon) — website design copy.
Below: helper text + green WhatsApp button "ارسال پیام در واتساپ برای ثبت سفارش خدمات".

### 05 · Stats (counters)
Gradient panel, 4 columns. Animated counters (Persian numerals): **۷** سال تجربه · **۹۵** پروژهٔ
تمام‌شده · **۲** تعداد سرویس‌ها · **۱۳۹۸** از سال.

### 06 · Portfolio
Heading "تعدادی از وب‌سایت‌های طراحی‌شده توسط تیم ما". Checklist (✓): سرعت بالا · رعایت سئو اولیه ·
طراحی رسپانسیو. Three phone/site mockups in a `perspective` row (outer two rotateY ±20°):
`1113-1.jpg`, `portfolio-5-1.jpg` (center, highlighted), `portfolio-2-1.jpg`. CTA button
"برای شروع همکاری کلیک کنید" → `#cta`.

### 07 · Testimonials
Intro: pulsing 🙅‍♂️ badge + "حرف‌های ما را باور نکنید! حرف کسانی که با ما کار کرده‌اند را نگاه
کنید." Then a **carousel** (glass card, prev/next arrows + dot pagination, auto-advance every
6s) of 4 testimonials — name, title, avatar, star rating, quote (full text in copy file):
1. محسن کاوشی — مدیر مارکتینگ لینگامو — ★★★★½
2. سعید امینی — مدیرعامل کالانه — ★★★★☆
3. سوروش برزگر — کارشناس مارکتینگ آی‌سی‌کده — ★★★★★
4. علی شاه‌آبادی — صاحب برند لوتوس — ★★★★☆

### 08 · Differentiation
Two-column. Left: H2 "متفاوت نبودن در دنیای کسب‌وکار یعنی **خودکشی!**" ("خودکشی!" red) +
paragraph + cyan CTA "برای شروع همکاری کلیک کنید" → `#cta`. Right: square framed mockup with the
**floating logo** (`floatY` 4s) — this is the only other place the logo image appears (2D `<img>`,
not the 3D one).

### 09 · Final CTA (`#cta`)
Centered. H2 "ما بــرای شما فرصت‌ها را **شــکــار** می‌کنیم" (cyan gradient word) + subtitle with
bold "اصولی"/"خلاقانه". **Second lead form** — identical fields to hero form — primary submit
"ارسال اطلاعات و شــروع هــمــکاری" + green WhatsApp button "ارسال پیام مستقیم در واتساپ برای ثبت
سفارش خدمات (پاسخ‌دهی سریع‌تر)".

### 10 · Footer
4-column grid: (a) logo + description "آژانس دیجیتال مارکتینگ آواتک افتخار فعالیت از سال ۱۳۹۸…"
+ social circles (Telegram/LinkedIn/Instagram/YouTube); (b) **صفحات**: دوره تــورنــادو / خانه /
نمونه کارها; (c) **خدمات**: طراحی وب‌سایت / بازاریابی آنلاین و افزایش فروش; (d) **ارتباط با ما**:
Telegram `t.me/+989966330107`, phone `021-33073906`, `0996 633 0107`, + E-NAMAD trust seal.
Copyright bar: "© Copyright 2026 powered by Avatice.com".

---

## Interactions & Behavior
- **Scroll** drives the 3D camera (see tunnel section) and the depth-rail progress/stop counter.
- **Mouse move** parallax-shifts the camera.
- **Reveal on scroll** for `[data-reveal]`; **count-up** for `[data-count]` (Persian numerals).
- **Off-canvas menu** toggle/close (state-driven transform + overlay).
- **Testimonial carousel:** prev/next, dot jump, 6s autoplay (pause optional on hover).
- **Marquees:** pure CSS infinite scroll, opposite directions.
- **Smooth anchor scrolling** (`html{scroll-behavior:smooth}`) for all `#hero`/`#cta`/`#f` links.
- **Forms:** front-end only in the prototype. In production, wire to the real endpoint/CRM;
  validate mobile (required, numeric) and service (required). Provide success/error states.

## State Management
- `menuOpen: boolean` — off-canvas visibility.
- `tIndex: number` — active testimonial (0–3), advanced by autoplay/arrows/dots.
- 3D runtime state (module-local, not React state): scroll `progress`, eased `camZ`, eased mouse
  `mx/my`. Keep the render loop out of the component's render cycle (ref + `requestAnimationFrame`).

## Assets
Copy real assets from the original WordPress/Elementor site; the prototype uses striped
placeholders for everything except the logo.
- **Logo:** `uploads/LOGO-2.png` (included in this bundle — the AVATIC arrow logo).
- Client logos: `52.png, 221.png, U5555itled-1.png (Untitled-1), 48.webp, 63.webp, 121212.webp,
  88.webp, 49.webp, 36.webp, 78.webp`.
- Portfolio: `1113-1.jpg (640×1130), portfolio-5-1.jpg (640×1130), portfolio-2-1.jpg (550×971)`.
- Testimonial avatars: `286176627_…n.jpg, Jophiel_.jpg, photo_2021-11-13_…webp, footer_avatar.webp`.
- Satisfaction badge: `رضایت-مشتریان-آژانس-آواتک.webp (130×43)`.
- Differentiation mockup: `وب-سایت-آواتک-800x800.webp`; overlay logo `LOGO.png`.
- E-NAMAD trust seal image + referral link.
- **Fonts:** Vazirmatn + Space Mono (Google Fonts).
- **Video:** Hero background `Hero-Background1.m4v`; strategy video Aparat id `yta05fa`.

## Files (in this bundle)
- `AVATIC 3D Site.dc.html` — the full hifi prototype (markup + inline styles + Three.js scene in
  the logic class). Primary reference. Strip the `.dc.html` runtime wrappers when porting.
- `LOGO-2.png` — the AVATIC logo asset.
- `copy_persian.md` — all Persian copy strings, ready to paste (avoids transcription errors).
- `AVATIC Wireframes.dc.html` — the earlier 3-direction lo-fi wireframe exploration (context only;
  the chosen direction is "1b سفر در عمق", now realized in the main file).

## Key Contacts / Links (from content)
- WhatsApp: `https://wa.me/989966330107`
- Telegram: `https://t.me/+989966330107`
- Business intake page: `/work-with-avatice/`
- Tornado course: add-to-cart product id `26449`
- Phone: `021-33073906`
