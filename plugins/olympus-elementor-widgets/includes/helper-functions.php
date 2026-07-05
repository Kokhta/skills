<?php
/**
 * Helper functions for Olympus Elementor Widgets
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * Get the meander SVG pattern as a CSS data URI
 */
function olympus_get_meander_pattern() {
	return "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='44' height='22'%3E%3Cpath d='M0 11h6V5h6v6h6V5h6v11h-6v-5h-6v5h-6V5H0z' fill='none' stroke='%23C9A227' stroke-width='1'/%3E%3C/svg%3E";
}
