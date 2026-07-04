<?php
/**
 * Plugin Name: Avatice 3D Scroll Experience for Elementor
 * Description: Adds advanced 3D scroll-driven widgets to Elementor using Three.js.
 * Version: 1.0.0
 * Author: Avatice
 * Text Domain: avatice-3d
 */

if ( ! defined( 'ABSPATH' ) ) {
	header('Status: 403 Forbidden');
	header('HTTP/1.1 403 Forbidden');
	exit;
}

final class Avatice_3D_Elementor {

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
		add_action( 'plugins_loaded', [ $this, 'init' ] );
	}

	public function init() {
		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			return;
		}

		add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );
		add_action( 'elementor/frontend/after_enqueue_scripts', [ $this, 'frontend_scripts' ] );
		add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'editor_scripts' ] );
	}

	public function frontend_scripts() {
		wp_enqueue_script( 'three-js', 'https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js', [], 'r128', true );
		wp_enqueue_script( 'three-gltf-loader', 'https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/loaders/GLTFLoader.js', ['three-js'], '0.128.0', true );
		wp_enqueue_script( 'three-effect-composer', 'https://unpkg.com/three@0.128.0/examples/js/postprocessing/EffectComposer.js', ['three-js'], '0.128.0', true );
		wp_enqueue_script( 'three-render-pass', 'https://unpkg.com/three@0.128.0/examples/js/postprocessing/RenderPass.js', ['three-js'], '0.128.0', true );
		wp_enqueue_script( 'three-shader-pass', 'https://unpkg.com/three@0.128.0/examples/js/postprocessing/ShaderPass.js', ['three-js'], '0.128.0', true );
		wp_enqueue_script( 'three-copy-shader', 'https://unpkg.com/three@0.128.0/examples/js/shaders/CopyShader.js', ['three-js'], '0.128.0', true );
		wp_enqueue_script( 'three-luminosity-shader', 'https://unpkg.com/three@0.128.0/examples/js/shaders/LuminosityHighPassShader.js', ['three-js'], '0.128.0', true );
		wp_enqueue_script( 'three-unreal-bloom', 'https://unpkg.com/three@0.128.0/examples/js/postprocessing/UnrealBloomPass.js', ['three-js'], '0.128.0', true );

		wp_enqueue_script( 'avatice-support', plugins_url( 'assets/js/support.js', __FILE__ ), [], self::VERSION, true );
		wp_enqueue_script( 'avatice-3d-main', plugins_url( 'assets/js/main.js', __FILE__ ), ['three-js', 'avatice-support'], self::VERSION, true );

        wp_enqueue_style( 'avatice-3d-style', plugins_url( 'assets/css/style.css', __FILE__ ), [], self::VERSION );
	}

    public function editor_scripts() {
        wp_enqueue_script( 'avatice-3d-editor', plugins_url( 'assets/js/editor.js', __FILE__ ), ['elementor-editor'], self::VERSION, true );
    }

	public function register_widgets( $widgets_manager ) {
		require_once( __DIR__ . '/widgets/avatice-canvas-widget.php' );
		require_once( __DIR__ . '/widgets/avatice-hero-widget.php' );
        require_once( __DIR__ . '/widgets/avatice-strategy-widget.php' );
        require_once( __DIR__ . '/widgets/avatice-clients-widget.php' );
        require_once( __DIR__ . '/widgets/avatice-services-widget.php' );
        require_once( __DIR__ . '/widgets/avatice-portfolio-widget.php' );
        require_once( __DIR__ . '/widgets/avatice-testimonials-widget.php' );
        require_once( __DIR__ . '/widgets/avatice-differentiation-widget.php' );
        require_once( __DIR__ . '/widgets/avatice-cta-widget.php' );

		$widgets_manager->register( new \Avatice_Canvas_Widget() );
		$widgets_manager->register( new \Avatice_Hero_Widget() );
        $widgets_manager->register( new \Avatice_Strategy_Widget() );
        $widgets_manager->register( new \Avatice_Clients_Widget() );
        $widgets_manager->register( new \Avatice_Services_Widget() );
        $widgets_manager->register( new \Avatice_Portfolio_Widget() );
        $widgets_manager->register( new \Avatice_Testimonials_Widget() );
        $widgets_manager->register( new \Avatice_Differentiation_Widget() );
        $widgets_manager->register( new \Avatice_CTA_Widget() );
	}
}

Avatice_3D_Elementor::instance();
