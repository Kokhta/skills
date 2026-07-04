<?php
/**
 * Plugin Name: Olympus Elementor Widgets
 * Description: A complete suite of custom Elementor widgets based on the Olympus landing page design.
 * Version: 1.0.0
 * Author: Jules
 * Text Domain: olympus-elementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * Main Olympus Elementor Widgets Class
 */
require_once( __DIR__ . '/includes/helpers.php' );
final class Olympus_Elementor_Widgets {

	const VERSION = '1.0.0';
	const MINIMUM_ELEMENTOR_VERSION = '3.0.0';
	const MINIMUM_PHP_VERSION = '7.4';

	private static $_instance = null;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function __construct() {
		add_action( 'init', [ $this, 'i18n' ] );
		add_action( 'plugins_loaded', [ $this, 'init' ] );
	}

	public function i18n() {
		load_plugin_textdomain( 'olympus-elementor' );
	}

	public function init() {
		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
			return;
		}

		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return;
		}

		// Register Widget Categories
		add_action( 'elementor/elements/categories_registered', [ $this, 'register_widget_categories' ] );

		// Register Widgets
		add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );

		// Enqueue Scripts
		add_action( 'elementor/frontend/after_enqueue_scripts', [ $this, 'frontend_scripts' ] );
		add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'frontend_styles' ] );
	}

	public function admin_notice_missing_main_plugin() {
		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
		$message = sprintf(
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'olympus-elementor' ),
			'<strong>' . esc_html__( 'Olympus Elementor Widgets', 'olympus-elementor' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'olympus-elementor' ) . '</strong>'
		);
		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	public function admin_notice_minimum_elementor_version() {
		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
		$message = sprintf(
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'olympus-elementor' ),
			'<strong>' . esc_html__( 'Olympus Elementor Widgets', 'olympus-elementor' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'olympus-elementor' ) . '</strong>',
			 self::MINIMUM_ELEMENTOR_VERSION
		);
		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	public function admin_notice_minimum_php_version() {
		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
		$message = sprintf(
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'olympus-elementor' ),
			'<strong>' . esc_html__( 'Olympus Elementor Widgets', 'olympus-elementor' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'olympus-elementor' ) . '</strong>',
			 self::MINIMUM_PHP_VERSION
		);
		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	public function register_widget_categories( $elements_manager ) {
		$elements_manager->add_category(
			'olympus',
			[
				'title' => esc_html__( 'Olympus', 'olympus-elementor' ),
				'icon' => 'fa fa-bolt',
			]
		);
	}

	public function register_widgets( $widgets_manager ) {
		require_once( __DIR__ . '/widgets/wrapper.php' );
		require_once( __DIR__ . '/widgets/hero.php' );
		require_once( __DIR__ . '/widgets/intro.php' );
		require_once( __DIR__ . '/widgets/pantheon.php' );
		require_once( __DIR__ . '/widgets/myths.php' );
		require_once( __DIR__ . '/widgets/oracle.php' );
		require_once( __DIR__ . '/widgets/chronicles.php' );
		require_once( __DIR__ . '/widgets/footer.php' );
		require_once( __DIR__ . '/widgets/meander.php' );
		require_once( __DIR__ . '/widgets/nav.php' );

		$widgets_manager->register( new \Olympus_Wrapper_Widget() );
		$widgets_manager->register( new \Olympus_Hero_Widget() );
		$widgets_manager->register( new \Olympus_Intro_Widget() );
		$widgets_manager->register( new \Olympus_Pantheon_Widget() );
		$widgets_manager->register( new \Olympus_Myths_Widget() );
		$widgets_manager->register( new \Olympus_Oracle_Widget() );
		$widgets_manager->register( new \Olympus_Chronicles_Widget() );
		$widgets_manager->register( new \Olympus_Footer_Widget() );
		$widgets_manager->register( new \Olympus_Meander_Widget() );
		$widgets_manager->register( new \Olympus_Nav_Widget() );
	}

	public function frontend_scripts() {
		wp_enqueue_script( 'gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js', [], '3.12.5', true );
		wp_enqueue_script( 'gsap-scroll-trigger', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js', ['gsap'], '3.12.5', true );
		wp_enqueue_script( 'olympus-scripts', plugins_url( '/assets/js/olympus-scripts.js', __FILE__ ), [ 'jquery', 'gsap', 'gsap-scroll-trigger' ], self::VERSION, true );
	}

	public function frontend_styles() {
		wp_enqueue_style( 'google-fonts-olympus', 'https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700;900&family=Cinzel+Decorative:wght@400;700;900&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400;1,600&display=swap', [], null );
		wp_enqueue_style( 'olympus-styles', plugins_url( '/assets/css/olympus-style.css', __FILE__ ), [], self::VERSION );
	}
}

Olympus_Elementor_Widgets::instance();
