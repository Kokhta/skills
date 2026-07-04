<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Olympus_01_Wrapper_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return '01-wrapper';
	}

	public function get_title() {
		return esc_html__( '01. Olympus Page Container', 'olympus-elementor-addon' );
	}

	public function get_icon() {
		return 'eicon-frame-expand';
	}

	public function get_categories() {
		return [ 'general' ];
	}

	public function get_keywords() {
		return [ 'olympus', 'wrapper', 'container', 'theme' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Settings', 'olympus-elementor-addon' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'theme_mode',
			[
				'label' => esc_html__( 'Default Theme', 'olympus-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'light',
				'options' => [
					'light'  => esc_html__( 'Light', 'olympus-elementor-addon' ),
					'dark' => esc_html__( 'Dark', 'olympus-elementor-addon' ),
				],
				'prefix_class' => 'olympus-theme-',
			]
		);

		$this->add_control(
			'load_google_fonts',
			[
				'label' => esc_html__( 'Load Google Fonts', 'olympus-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'olympus-elementor-addon' ),
				'label_off' => esc_html__( 'No', 'olympus-elementor-addon' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( 'yes' === $settings['load_google_fonts'] ) {
			echo '<link rel="preconnect" href="https://fonts.googleapis.com">
				  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
				  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700;900&family=Cinzel+Decorative:wght@400;700;900&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400;1,600&display=swap" rel="stylesheet">';
		}

		echo '<div class="olympus-global-wrapper" data-theme="' . esc_attr( $settings['theme_mode'] ) . '">';
	}

	protected function content_template() {
		?>
		<#
		if ( 'yes' === settings.load_google_fonts ) {
			#>
			<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700;900&family=Cinzel+Decorative:wght@400;700;900&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400;1,600&display=swap" rel="stylesheet">
			<#
		}
		#>
		<div class="olympus-global-wrapper" data-theme="{{ settings.theme_mode }}">
		<?php
	}
}
