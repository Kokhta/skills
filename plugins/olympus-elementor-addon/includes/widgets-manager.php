<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Olympus Widgets Manager
 *
 * Register all Olympus Elementor widgets.
 */
class Olympus_Widgets_Manager {

	/**
	 * Constructor
	 */
	public function __construct( $widgets_manager ) {
		$this->register_widgets( $widgets_manager );
	}

	/**
	 * Register Widgets
	 *
	 * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
	 */
	private function register_widgets( $widgets_manager ) {
		// List of widget IDs
		$widgets = [
			'wrapper',
			'hero',
			'intro',
			'pantheon',
			'myths',
			'oracle',
			'chronicles',
			'footer',
		];

		foreach ( $widgets as $widget ) {
			$file_path = __DIR__ . '/../widgets/' . $widget . '.php';
			if ( file_exists( $file_path ) ) {
				require_once( $file_path );

				// Construct class name: Olympus_Hero_Widget, etc.
				// Note: some might need manual mapping if names are complex
				$class_name = 'Olympus_' . str_replace( ' ', '_', ucwords( str_replace( '-', ' ', $widget ) ) ) . '_Widget';

				if ( class_exists( $class_name ) ) {
					$widgets_manager->register( new $class_name() );
				}
			}
		}
	}
}
