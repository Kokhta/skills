<?php
/**
 * Plugin Name: Olympus Elementor Widgets
 * Description: Custom Elementor widgets inspired by the Olympus theme.
 * Version: 1.0.0
 * Author: Jules
 * Text Domain: olympus-elementor-widgets
 */

if ( ! defined( 'ABSPATH' ) ) {
	die(); // Exit if accessed directly.
}

final class Olympus_Elementor_Widgets {

	const VERSION = '1.0.0';

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
		load_plugin_textdomain( 'olympus-elementor-widgets' );
	}

	public function init() {
		if ( ! did_action( 'elementor/loaded' ) ) {
			return;
		}

		add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );
		add_action( 'elementor/frontend/after_enqueue_scripts', [ $this, 'frontend_scripts' ] );
		add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'frontend_styles' ] );
	}

	public function frontend_scripts() {
		wp_enqueue_script( 'gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js', [], '3.12.5', true );
		wp_enqueue_script( 'gsap-scrolltrigger', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js', [ 'gsap' ], '3.12.5', true );
		wp_enqueue_script( 'olympus-script', plugins_url( 'assets/js/olympus-script.js', __FILE__ ), [ 'jquery', 'gsap', 'gsap-scrolltrigger' ], self::VERSION, true );
	}

	public function frontend_styles() {
		wp_enqueue_style( 'google-fonts-olympus', 'https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700;900&family=Cinzel+Decorative:wght@400;700;900&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400;1,600&display=swap', [], null );
		wp_enqueue_style( 'olympus-style', plugins_url( 'assets/css/olympus-style.css', __FILE__ ), [], self::VERSION );
	}

	public function register_widgets( $widgets_manager ) {
		require_once( __DIR__ . '/widgets/1-hero-widget.php' );
		require_once( __DIR__ . '/widgets/2-intro-widget.php' );
		require_once( __DIR__ . '/widgets/3-pantheon-widget.php' );
		require_once( __DIR__ . '/widgets/4-myth-widget.php' );
		require_once( __DIR__ . '/widgets/5-oracle-widget.php' );
		require_once( __DIR__ . '/widgets/6-chronicles-widget.php' );
		require_once( __DIR__ . '/widgets/7-footer-widget.php' );

		$widgets_manager->register( new \Olympus_Hero_Widget() );
		$widgets_manager->register( new \Olympus_Intro_Widget() );
		$widgets_manager->register( new \Olympus_Pantheon_Widget() );
		$widgets_manager->register( new \Olympus_Myth_Widget() );
		$widgets_manager->register( new \Olympus_Oracle_Widget() );
		$widgets_manager->register( new \Olympus_Chronicles_Widget() );
		$widgets_manager->register( new \Olympus_Footer_Widget() );
	}
}

Olympus_Elementor_Widgets::instance();
