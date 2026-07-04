<?php
if ( ! defined( 'ABSPATH' ) ) {
	return;
}

class Olympus_Intro_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'olympus_intro';
	}

	public function get_title() {
		return esc_html__( 'Olympus Intro', 'olympus-elementor' );
	}

	public function get_icon() {
		return 'eicon-blockquote';
	}

	public function get_categories() {
		return [ 'olympus' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Content', 'olympus-elementor' ),
			]
		);

		$this->add_control(
			'label',
			[
				'label' => esc_html__( 'Label', 'olympus-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'The Ancient World', 'olympus-elementor' ),
			]
		);

		$this->add_control(
			'quote',
			[
				'label' => esc_html__( 'Quote', 'olympus-elementor' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => esc_html__( '"From Chaos came the Earth, and from the Earth came all things divine — the <em>twelve immortals</em> who shaped the fate of gods and men alike from their thrones upon Mount Olympus."', 'olympus-elementor' ),
			]
		);

		$this->add_control(
			'source',
			[
				'label' => esc_html__( 'Source', 'olympus-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( '— Hesiod · Theogony · 700 BCE', 'olympus-elementor' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label' => esc_html__( 'Style', 'olympus-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'padding',
			[
				'label' => esc_html__( 'Padding', 'olympus-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .ol-intro' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'quote_typography',
				'label' => esc_html__( 'Quote Typography', 'olympus-elementor' ),
				'selector' => '{{WRAPPER}} .ol-intro-quote',
			]
		);

		$this->add_control(
			'quote_color',
			[
				'label' => esc_html__( 'Quote Color', 'olympus-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ol-intro-quote' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'accent_color',
			[
				'label' => esc_html__( 'Accent Color', 'olympus-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#C9A227',
				'selectors' => [
					'{{WRAPPER}} .ol-sec-label' => 'color: {{VALUE}}',
					'{{WRAPPER}} .ol-g-rule-sym' => 'color: {{VALUE}}',
					'{{WRAPPER}} .ol-intro-quote em' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<section class="ol-intro">
			<div class="ol-intro-inner">
				<div class="ol-sec-label ol-reveal"><?php echo esc_html( $settings['label'] ); ?></div>
				<div class="ol-g-rule ol-reveal">
					<div class="ol-g-rule-line"></div>
					<div class="ol-g-rule-sym">⚡</div>
					<div class="ol-g-rule-line rev"></div>
				</div>
				<div class="ol-intro-quote ol-reveal">
					<?php echo $settings['quote']; ?>
				</div>
				<div class="ol-g-rule ol-reveal">
					<div class="ol-g-rule-line"></div>
					<div class="ol-g-rule-sym">✦</div>
					<div class="ol-g-rule-line rev"></div>
				</div>
				<div class="ol-intro-source ol-reveal"><?php echo esc_html( $settings['source'] ); ?></div>
			</div>
		</section>
		<?php
	}
}
