<?php
/**
 * Plugin Name: Olympus Elementor Widgets
 * Description: Production-ready custom Elementor widgets for the Olympus landing page.
 * Version: 1.0.0
 * Author: Jules
 * Text Domain: olympus-widgets
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

final class Olympus_Elementor_Widgets {

	const VERSION = '1.0.0';
	const MINIMUM_ELEMENTOR_VERSION = '3.0.0';
	const MINIMUM_PHP_VERSION = '7.0';

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
		load_plugin_textdomain( 'olympus-widgets' );
	}

	public function init() {
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
			return;
		}

		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return;
		}

		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return;
		}

		add_action( 'elementor/widgets/register', [ $this, 'init_widgets' ] );
		add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'widget_styles' ] );
		add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ] );
	}

	public function admin_notice_missing_main_plugin() {
		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
		$message = sprintf(
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'olympus-widgets' ),
			'<strong>' . esc_html__( 'Olympus Elementor Widgets', 'olympus-widgets' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'olympus-widgets' ) . '</strong>'
		);
		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	public function admin_notice_minimum_elementor_version() {
		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
		$message = sprintf(
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'olympus-widgets' ),
			'<strong>' . esc_html__( 'Olympus Elementor Widgets', 'olympus-widgets' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'olympus-widgets' ) . '</strong>',
			 self::MINIMUM_ELEMENTOR_VERSION
		);
		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	public function admin_notice_minimum_php_version() {
		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
		$message = sprintf(
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'olympus-widgets' ),
			'<strong>' . esc_html__( 'Olympus Elementor Widgets', 'olympus-widgets' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'olympus-widgets' ) . '</strong>',
			 self::MINIMUM_PHP_VERSION
		);
		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	public function init_widgets( $widgets_manager ) {
		require_once( __DIR__ . '/widgets/page-container.php' );
		require_once( __DIR__ . '/widgets/hero.php' );
		require_once( __DIR__ . '/widgets/intro.php' );
		require_once( __DIR__ . '/widgets/pantheon.php' );
		require_once( __DIR__ . '/widgets/myths.php' );
		require_once( __DIR__ . '/widgets/oracle.php' );
		require_once( __DIR__ . '/widgets/chronicles.php' );
		require_once( __DIR__ . '/widgets/footer.php' );

		$widgets_manager->register( new \Elementor_Olympus_Page_Container_Widget() );
		$widgets_manager->register( new \Elementor_Olympus_Hero_Widget() );
		$widgets_manager->register( new \Elementor_Olympus_Intro_Widget() );
		$widgets_manager->register( new \Elementor_Olympus_Pantheon_Widget() );
		$widgets_manager->register( new \Elementor_Olympus_Myths_Widget() );
		$widgets_manager->register( new \Elementor_Olympus_Oracle_Widget() );
		$widgets_manager->register( new \Elementor_Olympus_Chronicles_Widget() );
		$widgets_manager->register( new \Elementor_Olympus_Footer_Widget() );
	}

	public function widget_styles() {
		wp_enqueue_style( 'olympus-fonts', 'https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700;900&family=Cinzel+Decorative:wght@400;700;900&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400;1,600&display=swap' );
		wp_enqueue_style( 'olympus-main', plugins_url( '/assets/css/main.css', __FILE__ ) );
	}

	public function widget_scripts() {
		wp_register_script( 'gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js', [], '3.12.5', true );
		wp_register_script( 'gsap-scroll-trigger', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js', ['gsap'], '3.12.5', true );
		wp_register_script( 'olympus-animations', plugins_url( '/assets/js/animations.js', __FILE__ ), ['gsap-scroll-trigger'], self::VERSION, true );
	}

}

Olympus_Elementor_Widgets::instance();
