<?php
/**
 * Plugin Name: Olympus Elements
 * Description: Custom Elementor widgets for the Olympus project.
 * Version: 1.0.0
 * Author: Jules
 * Text Domain: olympus-elements
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Olympus_Elements {

	const VERSION = '1.0.0';
	const MINIMUM_ELEMENTOR_VERSION = '3.10.0';
	const MINIMUM_PHP_VERSION = '7.4';

	private static $_instance = null;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function __construct() {
		if ( $this->is_compatible() ) {
			add_action( 'elementor/init', [ $this, 'init' ] );
		}
	}

	public function is_compatible() {
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
			return false;
		}

		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return false;
		}

		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return false;
		}

		return true;
	}

	public function init() {
		add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );
		add_action( 'elementor/frontend/after_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
		add_action( 'elementor/elements/categories_registered', [ $this, 'add_elementor_widget_categories' ] );
	}

	public function add_elementor_widget_categories( $elements_manager ) {
		$elements_manager->add_category(
			'olympus',
			[
				'title' => esc_html__( 'Olympus', 'olympus-elements' ),
				'icon' => 'fa fa-bolt',
			]
		);
	}

	public function register_widgets( $widgets_manager ) {
		require_once( __DIR__ . '/widgets/01-header.php' );
		require_once( __DIR__ . '/widgets/02-loader.php' );
		require_once( __DIR__ . '/widgets/03-hero.php' );
		require_once( __DIR__ . '/widgets/04-intro.php' );
		require_once( __DIR__ . '/widgets/05-meander.php' );
		require_once( __DIR__ . '/widgets/06-pantheon.php' );
		require_once( __DIR__ . '/widgets/07-myths.php' );
		require_once( __DIR__ . '/widgets/08-oracle.php' );
		require_once( __DIR__ . '/widgets/09-chronicles.php' );
		require_once( __DIR__ . '/widgets/10-footer.php' );

		$widgets_manager->register( new \Olympus_01_Header_Widget() );
		$widgets_manager->register( new \Olympus_02_Loader_Widget() );
		$widgets_manager->register( new \Olympus_03_Hero_Widget() );
		$widgets_manager->register( new \Olympus_04_Intro_Widget() );
		$widgets_manager->register( new \Olympus_05_Meander_Widget() );
		$widgets_manager->register( new \Olympus_06_Pantheon_Widget() );
		$widgets_manager->register( new \Olympus_07_Myths_Widget() );
		$widgets_manager->register( new \Olympus_08_Oracle_Widget() );
		$widgets_manager->register( new \Olympus_09_Chronicles_Widget() );
		$widgets_manager->register( new \Olympus_10_Footer_Widget() );
	}

	public function enqueue_scripts() {
		wp_enqueue_script( 'gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js', [], '3.12.5', true );
		wp_enqueue_script( 'gsap-scrolltrigger', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js', ['gsap'], '3.12.5', true );
		wp_enqueue_script( 'olympus-frontend', plugins_url( 'assets/js/olympus-frontend.js', __FILE__ ), ['gsap', 'gsap-scrolltrigger'], self::VERSION, true );
		wp_enqueue_style( 'olympus-frontend', plugins_url( 'assets/css/olympus-frontend.css', __FILE__ ), [], self::VERSION );
	}

	public function admin_notice_missing_main_plugin() {
		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
		$message = sprintf( '\"%1$s\" requires \"%2$s\" to be installed and activated.', '<strong>Olympus Elements</strong>', '<strong>Elementor</strong>' );
		printf( '<div class=\"notice notice-warning is-dismissible\"><p>%1$s</p></div>', $message );
	}

	public function admin_notice_minimum_elementor_version() {
		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
		$message = sprintf( '\"%1$s\" requires \"%2$s\" version %3$s or greater.', '<strong>Olympus Elements</strong>', '<strong>Elementor</strong>', self::MINIMUM_ELEMENTOR_VERSION );
		printf( '<div class=\"notice notice-warning is-dismissible\"><p>%1$s</p></div>', $message );
	}

	public function admin_notice_minimum_php_version() {
		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
		$message = sprintf( '\"%1$s\" requires \"%2$s\" version %3$s or greater.', '<strong>Olympus Elements</strong>', '<strong>PHP</strong>', self::MINIMUM_PHP_VERSION );
		printf( '<div class=\"notice notice-warning is-dismissible\"><p>%1$s</p></div>', $message );
	}
}

Olympus_Elements::instance();
