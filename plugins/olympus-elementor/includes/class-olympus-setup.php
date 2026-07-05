<?php
/**
 * Setup Class for Olympus Elementor Add-on
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

class Olympus_Elementor_Setup {

	private static $_instance = null;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function __construct() {
		// Register Category
		add_action( 'elementor/elements/categories_registered', [ $this, 'register_categories' ] );

		// Register Widgets
		add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );

		// Enqueue Frontend Assets
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_frontend_assets' ] );

		// Enqueue Editor Assets
		add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'enqueue_editor_assets' ] );
	}

	public function register_categories( $elements_manager ) {
		$elements_manager->add_category(
			'olympus',
			[
				'title' => esc_html__( 'Olympus', 'olympus-elementor' ),
				'icon' => 'fa fa-bolt',
			]
		);
	}

	public function register_widgets( $widgets_manager ) {
		$widgets = [
			'01-page-wrapper',
			'02-hero',
			'03-intro',
			'04-pantheon',
			'05-myths',
			'06-oracle',
			'07-chronicles',
			'08-footer',
		];

		foreach ( $widgets as $widget_id ) {
			$file = plugin_dir_path( __DIR__ ) . 'widgets/' . $widget_id . '.php';
			if ( file_exists( $file ) ) {
				require_once( $file );
				$class_name = 'Olympus_' . str_replace( '-', '_', $widget_id ) . '_Widget';
				if ( class_exists( $class_name ) ) {
					$widgets_manager->register( new $class_name() );
				}
			}
		}
	}

	public function enqueue_frontend_assets() {
		// GSAP & ScrollTrigger
		wp_enqueue_script( 'gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js', [], '3.12.5', true );
		wp_enqueue_script( 'gsap-scrolltrigger', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js', [ 'gsap' ], '3.12.5', true );

		// Custom Frontend Assets
		wp_enqueue_style( 'olympus-frontend', plugin_dir_url( __DIR__ ) . 'assets/css/olympus-frontend.css', [], Olympus_Elementor::VERSION );
		wp_enqueue_script( 'olympus-frontend', plugin_dir_url( __DIR__ ) . 'assets/js/olympus-frontend.js', [ 'gsap', 'gsap-scrolltrigger' ], Olympus_Elementor::VERSION, true );
	}

	public function enqueue_editor_assets() {
		wp_enqueue_script( 'olympus-editor', plugin_dir_url( __DIR__ ) . 'assets/js/olympus-editor.js', [ 'jquery' ], Olympus_Elementor::VERSION, true );
	}
}
