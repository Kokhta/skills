<?php
/**
 * Helper functions for Olympus Elementor Widgets.
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * Get dynamic SVG meander pattern.
 */
function olympus_get_meander_svg( $color = 'currentColor' ) {
	return sprintf(
		'<svg class="ol-meander-svg" xmlns="http://www.w3.org/2000/svg" width="44" height="22" style="flex-shrink: 0;"><path d="M0 11h6V5h6v6h6V5h6v11h-6v-5h-6v5h-6V5H0z" fill="none" stroke="%s" stroke-width="1"/></svg>',
		esc_attr( $color )
	);
}
