<?php
/**
 * Plugin Name: Avatice 3D Scroll Experience for Elementor
 * Description: Adds advanced 3D scroll-driven effects to Elementor using Three.js.
 * Version: 1.3.0
 * Author: Avatice
 * Text Domain: avatice-3d
 */

if ( ! defined( 'ABSPATH' ) ) {
	header('Status: 403 Forbidden');
	header('HTTP/1.1 403 Forbidden');
	exit;
}

final class Avatice_3D_Elementor {

	const VERSION = '1.3.0';

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
			return;
		}

		// Require Admin logic
		if ( is_admin() ) {
			require_once( __DIR__ . '/includes/admin.php' );
			new Avatice_3D_Admin();
		}

		add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );
		add_action( 'elementor/frontend/after_enqueue_scripts', [ $this, 'frontend_scripts' ] );
		add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'editor_scripts' ] );

		add_action( 'elementor/element/common/_section_style/after_section_end', [ $this, 'register_3d_controls' ], 10, 2 );
		add_action( 'elementor/element/section/_section_responsive/after_section_end', [ $this, 'register_3d_controls' ], 10, 2 );
		add_action( 'elementor/element/column/_section_responsive/after_section_end', [ $this, 'register_3d_controls' ], 10, 2 );

		add_action( 'elementor/element/before_add_render_attributes', [ $this, 'inject_3d_attributes' ], 10, 1 );
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
		require_once( __DIR__ . '/widgets/0-canvas-core.php' );
		require_once( __DIR__ . '/widgets/z-depth-rail.php' );
		require_once( __DIR__ . '/widgets/3d-interaction-area.php' );

		$widgets_manager->register( new \Avatice_Canvas_Core_Widget() );
		$widgets_manager->register( new \Avatice_Z_Depth_Rail_Widget() );
		$widgets_manager->register( new \Avatice_3D_Interaction_Widget() );
	}

	public function register_3d_controls( $element, $args ) {
		$element->start_controls_section(
			'avatice_3d_scroll_section',
			[
				'label' => esc_html__( 'Avatice 3D Scroll Effects', 'avatice-3d' ),
				'tab' => \Elementor\Controls_Manager::TAB_ADVANCED,
			]
		);

		$element->add_control(
			'avatice_enable_reveal',
			[
				'label' => esc_html__( 'Enable Reveal Animation', 'avatice-3d' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'avatice-3d' ),
				'label_off' => esc_html__( 'No', 'avatice-3d' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$element->add_control(
			'avatice_z_stop',
			[
				'label' => esc_html__( 'Z-Depth Stop Number', 'avatice-3d' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 10,
				'step' => 1,
			]
		);

		$element->add_control(
			'avatice_parallax_factor',
			[
				'label' => esc_html__( '3D Parallax Factor', 'avatice-3d' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 2,
						'step' => 0.1,
					],
				],
				'default' => [
					'size' => 1,
				],
			]
		);

		$element->end_controls_section();
	}

	public function inject_3d_attributes( $element ) {
		$settings = $element->get_settings_for_display();

		if ( ! empty( $settings['avatice_enable_reveal'] ) && 'yes' === $settings['avatice_enable_reveal'] ) {
			$element->add_render_attribute( '_wrapper', 'data-reveal', '' );
			$element->add_render_attribute( '_wrapper', 'class', 'avatice-reveal' );
		}

		if ( ! empty( $settings['avatice_z_stop'] ) ) {
			$element->add_render_attribute( '_wrapper', 'data-stop', $settings['avatice_z_stop'] );
			$element->add_render_attribute( '_wrapper', 'class', 'avatice-section' );
		}

		if ( ! empty( $settings['avatice_parallax_factor']['size'] ) ) {
			$element->add_render_attribute( '_wrapper', 'data-parallax', $settings['avatice_parallax_factor']['size'] );
		}
	}

	public function create_3d_page($title) {
		$new_page = array(
			'post_type' => 'page',
			'post_title' => $title,
			'post_content' => '',
			'post_status' => 'publish',
			'post_author' => get_current_user_id(),
		);
		$page_id = wp_insert_post($new_page);

		if ($page_id) {
			update_post_meta($page_id, '_wp_page_template', 'elementor_canvas');
            update_post_meta($page_id, '_elementor_edit_mode', 'builder');

            $elementor_data = [
                [
                    'id' => 'avatice-core-section',
                    'elType' => 'section',
                    'elements' => [
                        [
                            'id' => 'avatice-core-column',
                            'elType' => 'column',
                            'elements' => [
                                [
                                    'id' => 'avatice-canvas-widget',
                                    'elType' => 'widget',
                                    'widgetType' => 'avatice_canvas_core'
                                ],
                                [
                                    'id' => 'avatice-rail-widget',
                                    'elType' => 'widget',
                                    'widgetType' => 'avatice_z_depth_rail'
                                ]
                            ]
                        ]
                    ]
                ],
                [
                    'id' => 'hero-section',
                    'elType' => 'section',
                    'settings' => [ 'avatice_z_stop' => 1 ],
                    'elements' => [
                        [
                            'id' => 'hero-column',
                            'elType' => 'column',
                            'elements' => [
                                [
                                    'id' => 'hero-heading',
                                    'elType' => 'widget',
                                    'widgetType' => 'heading',
                                    'settings' => [
                                        'title' => 'جذب منظم و هفتگی مشتریان جدید برای کسب و کار شما',
                                        'avatice_enable_reveal' => 'yes'
                                    ]
                                ],
                                [
                                    'id' => 'hero-3d',
                                    'elType' => 'widget',
                                    'widgetType' => 'avatice_3d_interaction',
                                    'settings' => [ 'interaction_id' => 'form-hero-3d' ]
                                ]
                            ]
                        ]
                    ]
                ],
                [
                    'id' => 'strategy-section',
                    'elType' => 'section',
                    'settings' => [ 'avatice_z_stop' => 2 ],
                    'elements' => [
                        [
                            'id' => 'strategy-column',
                            'elType' => 'column',
                            'elements' => [
                                [
                                    'id' => 'strategy-heading',
                                    'elType' => 'widget',
                                    'widgetType' => 'heading',
                                    'settings' => [
                                        'title' => 'دیگه طراحی سایت و اجرای تبلیغات جواب نمیده',
                                        'avatice_enable_reveal' => 'yes'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ];
            update_post_meta($page_id, '_elementor_data', json_encode($elementor_data));
		}
        return $page_id;
	}
}

Avatice_3D_Elementor::instance();
