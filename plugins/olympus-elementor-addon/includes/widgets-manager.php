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
require_once( __DIR__ . '/helper-functions.php' );
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
		// List of widget IDs with ordering
		$widgets = [
			'01-wrapper',
			'02-hero',
			'04-intro',
			'06-pantheon',
			'08-myths',
			'10-oracle',
			'12-chronicles',
			'15-footer',
		];

		foreach ( $widgets as $widget ) {
			$file_path = __DIR__ . '/../widgets/' . $widget . '.php';
			if ( file_exists( $file_path ) ) {
				require_once( $file_path );

				// Construct class name: Olympus_02_Hero_Widget, etc.
				// str_replace '-' with '_' and capitalize each part
				$class_parts = explode( '-', $widget );
				$class_name = 'Olympus_' . implode( '_', array_map( 'ucfirst', $class_parts ) ) . '_Widget';

				if ( class_exists( $class_name ) ) {
					$widgets_manager->register( new $class_name() );
				}
			}
		}
	}
}
