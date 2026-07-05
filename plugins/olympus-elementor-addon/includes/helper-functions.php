<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function olympus_add_theme_control( $widget ) {
	$widget->start_controls_section(
		'section_theme',
		[
			'label' => esc_html__( 'Theme', 'olympus-elementor-addon' ),
			'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
		]
	);

	$widget->add_control(
		'widget_theme',
		[
			'label' => esc_html__( 'Widget Theme', 'olympus-elementor-addon' ),
			'type' => \Elementor\Controls_Manager::SELECT,
			'default' => 'dark',
			'options' => [
				'inherit' => esc_html__( 'Inherit from Page', 'olympus-elementor-addon' ),
				'light'   => esc_html__( 'Force Light', 'olympus-elementor-addon' ),
				'dark'    => esc_html__( 'Force Dark', 'olympus-elementor-addon' ),
			],
		]
	);

	$widget->end_controls_section();
}

function olympus_get_theme_class( $settings ) {
	if ( ! isset( $settings['widget_theme'] ) || 'inherit' === $settings['widget_theme'] ) {
		return '';
	}
	return 'ol-theme-' . $settings['widget_theme'];
}
