# Olympus Elementor Widgets

A production-ready WordPress plugin that adds custom Elementor widgets based on the "Olympus" landing page design.

## Features

- **Everything is Editable**: All text, colors, typography, images, and animation parameters are controllable via Elementor.
- **GSAP Animations**: Seamless scroll-triggered animations using GSAP and ScrollTrigger.
- **Namespaced CSS**: All styles are namespaced (e.g., `.ol-hero`, `.ol-sec`) to prevent conflicts with themes and other plugins.
- **Production-Ready**: Follows WordPress and Elementor development best practices.
- **Responsive**: Fully responsive design that matches the original layout.

## Widgets Included

1. **Olympus Global Wrapper**: Manages global theme (light/dark), custom scrollbars, and the initial page loader.
2. **Olympus Header Nav**: Sticky navigation bar with customizable logo and links.
3. **Olympus Hero**: Sticky video hero with parallax content and scroll-based video scrubbing.
4. **Olympus Intro**: Elegant quote section with decorative rules.
5. **Olympus Pantheon**: Dynamic grid for displaying the gods with customizable cards.
6. **Olympus Myths**: Image and text pairs for storytelling, with reversible layouts.
7. **Olympus Oracle**: Watermarked quote section with a divine feel.
8. **Olympus Chronicles**: A vertical timeline for historical events.
9. **Olympus Meander Separator**: A reusable Greek key separator with dynamic color and opacity.
10. **Olympus Footer**: Custom footer with logo, tagline, and navigation.

## Installation

1. Download or clone this repository.
2. Zip the `olympus-elementor-widgets` folder.
3. In your WordPress admin, go to **Plugins > Add New > Upload Plugin**.
4. Upload the `olympus-elementor-widgets.zip` file.
5. Activate the plugin.

## How to Use

1. Ensure **Elementor** is installed and active.
2. Create a new page or edit an existing one with Elementor.
3. Search for "Olympus" in the widget panel or find the **Olympus** category.
4. Drag and drop the **Olympus Global Wrapper** first to set the theme and enable the loader.
5. Add the other widgets in any order to build your divine landing page.
6. For the **Hero** widget, provide a video URL in the Content settings.

## Developer Notes

- The plugin enqueues GSAP and ScrollTrigger from CDN.
- All styles are loaded from `assets/css/olympus-style.css`.
- Custom JS logic resides in `assets/js/olympus-scripts.js`.
- Translation ready using the `olympus-elementor` text domain.
