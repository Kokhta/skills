<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Avatice_Canvas_Core_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'avatice_canvas_core';
	}

	public function get_title() {
		return esc_html__( '0-Canvas Core', 'avatice-3d' );
	}

	public function get_icon() {
		return 'eicon-code';
	}

	public function get_categories() {
		return [ 'general' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_3d_settings',
			[
				'label' => esc_html__( '3D Scene Settings', 'avatice-3d' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'fog_color',
			[
				'label' => esc_html__( 'Fog Color', 'avatice-3d' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#070a0f',
			]
		);

		$this->add_control(
			'primary_light_color',
			[
				'label' => esc_html__( 'Primary Light Color', 'avatice-3d' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#2bb8ec',
			]
		);

        $this->add_control(
			'secondary_light_color',
			[
				'label' => esc_html__( 'Secondary Light Color', 'avatice-3d' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#7fe0ff',
			]
		);

        $this->add_control(
			'scroll_speed',
			[
				'label' => esc_html__( 'Scroll Smoothing', 'avatice-3d' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0.01,
						'max' => 0.2,
						'step' => 0.01,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0.04,
				],
			]
		);

        $this->add_control(
			'icon_count',
			[
				'label' => esc_html__( 'Floating Icons Count', 'avatice-3d' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 10,
				'max' => 200,
				'step' => 10,
				'default' => 60,
			]
		);

        $this->add_control(
			'camera_fov',
			[
				'label' => esc_html__( 'Camera FOV', 'avatice-3d' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 30,
						'max' => 120,
					],
				],
				'default' => [
					'size' => 62,
				],
			]
		);

		$this->end_controls_section();

        $this->start_controls_section(
			'section_overlay_settings',
			[
				'label' => esc_html__( 'Overlay Settings', 'avatice-3d' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

        $this->add_control(
			'overlay_color',
			[
				'label' => esc_html__( 'Radial Overlay Color', 'avatice-3d' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => 'rgba(7,10,15,0.55)',
			]
		);

        $this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
        ?>
        <div class="avatice-3d-layout-wrapper"
             data-fog-color="<?php echo esc_attr($settings['fog_color']); ?>"
             data-light1="<?php echo esc_attr($settings['primary_light_color']); ?>"
             data-light2="<?php echo esc_attr($settings['secondary_light_color']); ?>"
             data-smoothing="<?php echo esc_attr($settings['scroll_speed']['size']); ?>"
             data-icon-count="<?php echo esc_attr($settings['icon_count']); ?>"
             data-fov="<?php echo esc_attr($settings['camera_fov']['size']); ?>">

            <canvas id="avatice-3d-canvas" class="avatice-3d-canvas-container"></canvas>
            <div class="avatice-3d-overlay" style="background: radial-gradient(120% 90% at 50% 0%, transparent 40%, <?php echo esc_attr($settings['overlay_color']); ?> 100%);"></div>
        </div>
        <?php
	}
}
