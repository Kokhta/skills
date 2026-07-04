<?php
/**
 * Plugin Name: Olympus Elementor Addon
 * Description: A premium Elementor addon inspired by the "Olympus" landing page, featuring sticky video hero, GSAP animations, and custom mythology-themed widgets.
 * Version: 1.0.0
 * Author: Jules
 * Text Domain: olympus-elementor-addon
 *
 * Elementor tested up to: 3.20.0
 * Elementor Pro tested up to: 3.20.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Main Olympus Elementor Addon Class
 */
final class Olympus_Elementor_Addon {

	/**
	 * Plugin Version
	 * @var string
	 */
	const VERSION = '1.0.0';

	/**
	 * Minimum Elementor Version
	 * @var string
	 */
	const MINIMUM_ELEMENTOR_VERSION = '3.0.0';

	/**
	 * Minimum PHP Version
	 * @var string
	 */
	const MINIMUM_PHP_VERSION = '7.4';

	/**
	 * Instance
	 * @var Olympus_Elementor_Addon
	 */
	private static $_instance = null;

	/**
	 * Get Instance
	 * @return Olympus_Elementor_Addon
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Constructor
	 */
	public function __construct() {
		if ( $this->is_compatible() ) {
			add_action( 'plugins_loaded', [ $this, 'init' ] );
		}
	}

	/**
	 * Compatibility Check
	 */
	public function is_compatible() {
		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
			return false;
		}

		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return false;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return false;
		}

		return true;
	}

	/**
	 * Initialize the plugin
	 */
	public function init() {
		add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );
		add_action( 'elementor/frontend/after_register_scripts', [ $this, 'register_frontend_scripts' ] );
		add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'enqueue_frontend_styles' ] );
	}

	/**
	 * Register Widgets
	 */
	public function register_widgets( $widgets_manager ) {
		require_once( __DIR__ . '/includes/widgets-manager.php' );
		$olympus_widgets_manager = new Olympus_Widgets_Manager( $widgets_manager );
	}

	/**
	 * Register Frontend Scripts
	 */
	public function register_frontend_scripts() {
		wp_register_script( 'gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js', [], '3.12.5', true );
		wp_register_script( 'gsap-scroll-trigger', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js', ['gsap'], '3.12.5', true );
		wp_register_script( 'olympus-scripts', plugins_url( 'assets/js/olympus-scripts.js', __FILE__ ), ['gsap', 'gsap-scroll-trigger', 'jquery'], self::VERSION, true );
	}

	/**
	 * Enqueue Frontend Styles
	 */
	public function enqueue_frontend_styles() {
		wp_enqueue_style( 'olympus-widgets', plugins_url( 'assets/css/olympus-widgets.css', __FILE__ ), [], self::VERSION );
	}

	/**
	 * Admin notices
	 */
	public function admin_notice_missing_main_plugin() {
		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
		$message = sprintf(
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'olympus-elementor-addon' ),
			'<strong>' . esc_html__( 'Olympus Elementor Addon', 'olympus-elementor-addon' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'olympus-elementor-addon' ) . '</strong>'
		);
		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	public function admin_notice_minimum_elementor_version() {
		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
		$message = sprintf(
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'olympus-elementor-addon' ),
			'<strong>' . esc_html__( 'Olympus Elementor Addon', 'olympus-elementor-addon' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'olympus-elementor-addon' ) . '</strong>',
			self::MINIMUM_ELEMENTOR_VERSION
		);
		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	public function admin_notice_minimum_php_version() {
		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
		$message = sprintf(
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'olympus-elementor-addon' ),
			'<strong>' . esc_html__( 'Olympus Elementor Addon', 'olympus-elementor-addon' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'olympus-elementor-addon' ) . '</strong>',
			self::MINIMUM_PHP_VERSION
		);
		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}
}

Olympus_Elementor_Addon::instance();
