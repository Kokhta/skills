<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Modules\NestedElements\Base\Widget_Nested_Base;

class Olympus_02_Loader_Widget extends Widget_Nested_Base {

	public function get_name() {
		return 'olympus-loader';
	}

	public function get_title() {
		return esc_html__( '02-Loader', 'olympus-elements' );
	}

	public function get_icon() {
		return 'eicon-loading-ready';
	}

	public function get_categories() {
		return [ 'olympus' ];
	}

	protected function get_default_children_config() {
		return [];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Content', 'olympus-elements' ),
			]
		);

		$this->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'olympus-elements' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'OLYMPUS', 'olympus-elements' ),
			]
		);

		$this->add_control(
			'subtitle',
			[
				'label' => esc_html__( 'Subtitle', 'olympus-elements' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Entering the Realm of Gods', 'olympus-elements' ),
			]
		);

		$this->add_control(
			'duration',
			[
				'label' => esc_html__( 'Fade Out Duration (ms)', 'olympus-elements' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 5000,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label' => esc_html__( 'Style', 'olympus-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'bg_color',
			[
				'label' => esc_html__( 'Background Color', 'olympus-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#030308',
				'selectors' => [
					'{{WRAPPER}} .ol-loader' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Title Color', 'olympus-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#D4AF37',
				'selectors' => [
					'{{WRAPPER}} .ol-loader-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .ol-loader-title',
			]
		);

		$this->add_control(
			'subtitle_color',
			[
				'label' => esc_html__( 'Subtitle Color', 'olympus-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => 'rgba(212,175,55,.4)',
				'selectors' => [
					'{{WRAPPER}} .ol-loader-sub' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'subtitle_typography',
				'selector' => '{{WRAPPER}} .ol-loader-sub',
			]
		);

		$this->add_control(
			'bar_color',
			[
				'label' => esc_html__( 'Progress Bar Color', 'olympus-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#D4AF37',
				'selectors' => [
					'{{WRAPPER}} .ol-loader-bar::after' => 'background: linear-gradient(90deg, transparent, {{VALUE}}, transparent);',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<div id=\"loader\" class=\"ol-loader\" data-duration=\"<?php echo esc_attr($settings['duration']); ?>\">
			<div class=\"ol-loader-title\"><?php echo esc_html($settings['title']); ?></div>
			<div class=\"ol-loader-bar\"></div>
			<div class=\"ol-loader-sub\"><?php echo esc_html($settings['subtitle']); ?></div>
		</div>
		<?php
	}

	protected function content_template() {
		?>
		<div id=\"loader\" class=\"ol-loader\">
			<div class=\"ol-loader-title\">{{{ settings.title }}}</div>
			<div class=\"ol-loader-bar\"></div>
			<div class=\"ol-loader-sub\">{{{ settings.subtitle }}}</div>
		</div>
		<?php
	}
}
