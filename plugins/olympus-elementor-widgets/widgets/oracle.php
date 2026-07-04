<?php
if ( ! defined( 'ABSPATH' ) ) {
	return;
}

class Olympus_Oracle_Widget extends \Elementor\Widget_Base {

	public function get_name() { return 'olympus_oracle'; }
	public function get_title() { return esc_html__( 'Olympus Oracle', 'olympus-elementor' ); }
	public function get_icon() { return 'eicon-testimonial'; }
	public function get_categories() { return [ 'olympus' ]; }

	protected function register_controls() {
		$this->start_controls_section( 'section_content', [ 'label' => 'Content' ] );
		$this->add_control( 'bg_text', [ 'label' => 'Background Text', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'ΧΡΗΣΜΟΣ' ] );
		$this->add_control( 'icon', [ 'label' => 'Icon', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '🏛️' ] );
		$this->add_control( 'label', [ 'label' => 'Label', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'The Oracle of Delphi' ] );
		$this->add_control( 'quote', [ 'label' => 'Quote', 'type' => \Elementor\Controls_Manager::WYSIWYG, 'default' => '"Know thyself. Nothing in excess.<br><em>Certainty brings insanity.</em>"' ] );
		$this->add_control( 'attribution', [ 'label' => 'Attribution', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '— The Three Maxims of Delphi' ] );
		$this->end_controls_section();

		$this->start_controls_section( 'section_style', [ 'label' => 'Style', 'tab' => \Elementor\Controls_Manager::TAB_STYLE ] );

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [ 'name' => 'quote_tg', 'label' => 'Quote Typography', 'selector' => '{{WRAPPER}} .ol-oracle-quote' ] );
		$this->add_control( 'quote_color', [ 'label' => 'Quote Color', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .ol-oracle-quote' => 'color: {{VALUE}}' ] ] );

		$this->add_control( 'accent_color', [ 'label' => 'Accent Color', 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#C9A227', 'selectors' => [
			'{{WRAPPER}} .ol-oracle-bg' => 'color: {{VALUE}}',
			'{{WRAPPER}} .ol-sec-label' => 'color: {{VALUE}}',
			'{{WRAPPER}} .ol-g-rule-sym' => 'color: {{VALUE}}',
			'{{WRAPPER}} .ol-oracle-quote em' => 'color: {{VALUE}}'
		] ] );

		$this->add_responsive_control( 'padding', [ 'label' => 'Padding', 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'selectors' => [ '{{WRAPPER}} .ol-oracle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}' ] ] );
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<section class="ol-oracle">
			<div class="ol-oracle-bg"><?php echo esc_html( $settings['bg_text'] ); ?></div>
			<div class="ol-oracle-inner">
				<span class="ol-oracle-icon ol-reveal"><?php echo esc_html( $settings['icon'] ); ?></span>
				<div class="ol-sec-label ol-reveal"><?php echo esc_html( $settings['label'] ); ?></div>
				<div class="ol-g-rule ol-reveal"><div class="ol-g-rule-line"></div><div class="ol-g-rule-sym">✦</div><div class="ol-g-rule-line rev"></div></div>
				<div class="ol-oracle-quote ol-reveal"><?php echo $settings['quote']; ?></div>
				<div class="ol-g-rule ol-reveal"><div class="ol-g-rule-line"></div><div class="ol-g-rule-sym">✦</div><div class="ol-g-rule-line rev"></div></div>
				<div class="ol-oracle-attr ol-reveal"><?php echo esc_html( $settings['attribution'] ); ?></div>
			</div>
		</section>
		<?php
	}
}
