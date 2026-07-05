=== Olympus Elementor Add-on ===
Contributors: Jules
Tags: elementor, olympus, landing page, custom widgets
Requires at least: 5.8
Tested up to: 6.4
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later

== Description ==

A Nested, Auto-Populating Elementor Add-on designed to recreate the Olympus Landing Page perfectly.

== Installation ==

1. Upload the `olympus-elementor` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Ensure Elementor is installed and activated.

== Usage ==

1. Create a new Elementor page.
2. Search for the "Olympus" category in the widget panel.
3. Drag the `01 Page Wrapper` widget onto the canvas first.
4. Inside the `01 Page Wrapper`, drag the other containers in order (02 Hero through 08 Footer).
5. For the `02 Hero` and `03 Intro` widgets:
   - Click the widget to open its settings.
   - Click the "Import" button under the "Setup" section to automatically populate them with native Elementor widgets.
6. For other widgets (`04 Pantheon`, `05 Myths`, etc.), edit their content via the Repeater controls in the Elementor panel.
7. Customize the animation settings in the `02 Hero` widget if needed.
8. The `01 Page Wrapper` handles global theme switching (Light/Dark) based on scroll position by default.

== Changelog ==

= 1.0.0 =
* Initial release.
