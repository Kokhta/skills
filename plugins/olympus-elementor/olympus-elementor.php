<?php
/**
 * Plugin Name: Olympus Elementor Add-on
 * Description: A Nested, Auto-Populating Elementor Add-on for the Olympus Landing Page.
 * Version: 1.0.0
 * Author: Jules
 * Text Domain: olympus-elementor
 *
 * Elementor tested up to: 3.20.0
 * Elementor Pro tested up to: 3.20.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	die(); // Exit if accessed directly.
}

/**
 * Main Olympus Elementor Class
 */
final class Olympus_Elementor {

	const VERSION = '1.0.0';
	const MINIMUM_ELEMENTOR_VERSION = '3.5.0';
	const MINIMUM_PHP_VERSION = '7.4';

	private static $_instance = null;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function __construct() {
		add_action( 'plugins_loaded', [ $this, 'init' ] );
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

		require_once( __DIR__ . '/includes/class-olympus-setup.php' );
		\Olympus_Elementor_Setup::instance();
	}

	public function admin_notice_missing_main_plugin() {
		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
		$message = sprintf(
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'olympus-elementor' ),
			'<strong>' . esc_html__( 'Olympus Elementor Add-on', 'olympus-elementor' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'olympus-elementor' ) . '</strong>'
		);
		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	public function admin_notice_minimum_elementor_version() {
		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
		$message = sprintf(
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'olympus-elementor' ),
			'<strong>' . esc_html__( 'Olympus Elementor Add-on', 'olympus-elementor' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'olympus-elementor' ) . '</strong>',
			 self::MINIMUM_ELEMENTOR_VERSION
		);
		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	public function admin_notice_minimum_php_version() {
		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
		$message = sprintf(
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'olympus-elementor' ),
			'<strong>' . esc_html__( 'Olympus Elementor Add-on', 'olympus-elementor' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'olympus-elementor' ) . '</strong>',
			 self::MINIMUM_PHP_VERSION
		);
		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

}

Olympus_Elementor::instance();
