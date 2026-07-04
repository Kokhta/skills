<?php
if ( ! defined( 'ABSPATH' ) ) {
	return;
}

class Olympus_Pantheon_Widget extends \Elementor\Widget_Base {

	public function get_name() { return 'olympus_pantheon'; }
	public function get_title() { return esc_html__( 'Olympus Pantheon', 'olympus-elementor' ); }
	public function get_icon() { return 'eicon-gallery-grid'; }
	public function get_categories() { return [ 'olympus' ]; }

	protected function register_controls() {

		$this->start_controls_section( 'section_header', [ 'label' => 'Header' ] );
		$this->add_control( 'label', [ 'label' => 'Label', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'The Twelve Olympians' ] );
		$this->add_control( 'title', [ 'label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'The Divine Pantheon' ] );
		$this->add_control( 'subtitle', [ 'label' => 'Subtitle', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Rulers of the cosmos...' ] );
		$this->end_controls_section();

		$this->start_controls_section( 'section_gods', [ 'label' => 'Gods' ] );
		$repeater = new \Elementor\Repeater();
		$repeater->add_control( 'god_symbol', [ 'label' => 'Symbol', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '⚡' ] );
		$repeater->add_control( 'god_realm', [ 'label' => 'Realm', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'King of the Gods' ] );
		$repeater->add_control( 'god_name', [ 'label' => 'Name', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Zeus' ] );
		$repeater->add_control( 'god_desc', [ 'label' => 'Description', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => '...' ] );
		$repeater->add_control( 'god_number', [ 'label' => 'Number', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'I' ] );
		$this->add_control( 'gods_list', [ 'label' => 'Gods List', 'type' => \Elementor\Controls_Manager::REPEATER, 'fields' => $repeater->get_controls(), 'title_field' => '{{{ god_name }}}' ] );
		$this->end_controls_section();

		$this->start_controls_section( 'section_style_header', [ 'label' => 'Header Style', 'tab' => \Elementor\Controls_Manager::TAB_STYLE ] );
		$this->add_responsive_control( 'padding', [ 'label' => 'Padding', 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'selectors' => [ '{{WRAPPER}} .ol-pantheon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}' ] ] );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [ 'name' => 'label_tg', 'label' => 'Label Typography', 'selector' => '{{WRAPPER}} .ol-sec-label' ] );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [ 'name' => 'title_tg', 'label' => 'Title Typography', 'selector' => '{{WRAPPER}} .ol-sec-title' ] );
		$this->add_control( 'accent_color', [ 'label' => 'Accent Color', 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#C9A227', 'selectors' => [ '{{WRAPPER}} .ol-sec-label' => 'color: {{VALUE}}' ] ] );
		$this->end_controls_section();

		$this->start_controls_section( 'section_style_card', [ 'label' => 'Card Style', 'tab' => \Elementor\Controls_Manager::TAB_STYLE ] );
		$this->add_control( 'card_bg', [ 'label' => 'Card Background', 'type' => \Elementor\Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .ol-god-card' => 'background: {{VALUE}}' ] ] );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [ 'name' => 'god_name_tg', 'label' => 'God Name Typography', 'selector' => '{{WRAPPER}} .ol-god-name' ] );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [ 'name' => 'god_realm_tg', 'label' => 'Realm Typography', 'selector' => '{{WRAPPER}} .ol-god-realm' ] );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [ 'name' => 'god_desc_tg', 'label' => 'Description Typography', 'selector' => '{{WRAPPER}} .ol-god-desc' ] );
		$this->add_control( 'card_accent_color', [ 'label' => 'Card Accent Color', 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#C9A227', 'selectors' => [
			'{{WRAPPER}} .ol-god-realm' => 'color: {{VALUE}}',
			'{{WRAPPER}} .ol-god-num' => 'color: {{VALUE}}',
			'{{WRAPPER}} .ol-god-card::before' => 'background: linear-gradient(to right, transparent, {{VALUE}}, transparent)'
		] ] );
		$this->add_responsive_control( 'grid_gap', [ 'label' => 'Grid Gap', 'type' => \Elementor\Controls_Manager::SLIDER, 'range' => [ 'px' => [ 'min' => 0, 'max' => 100 ] ], 'selectors' => [ '{{WRAPPER}} .ol-gods-grid' => 'gap: {{SIZE}}{{UNIT}}' ] ] );
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<section class="ol-sec ol-pantheon" id="pantheon">
			<div class="ol-sec-inner">
				<div class="ol-sec-label ol-reveal"><?php echo esc_html( $settings['label'] ); ?></div>
				<h2 class="ol-sec-title ol-reveal"><?php echo esc_html( $settings['title'] ); ?></h2>
				<p class="ol-sec-sub ol-reveal"><?php echo esc_html( $settings['subtitle'] ); ?></p>
				<div class="ol-gods-grid">
					<?php foreach ( $settings['gods_list'] as $god ) : ?>
						<div class="ol-god-card ol-reveal">
							<span class="ol-god-sym"><?php echo esc_html( $god['god_symbol'] ); ?></span>
							<div class="ol-god-realm"><?php echo esc_html( $god['god_realm'] ); ?></div>
							<div class="ol-god-name"><?php echo esc_html( $god['god_name'] ); ?></div>
							<p class="ol-god-desc"><?php echo esc_html( $god['god_desc'] ); ?></p>
							<div class="ol-god-num"><?php echo esc_html( $god['god_number'] ); ?></div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
		<?php
	}
}
