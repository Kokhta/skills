<?php
if ( ! defined( 'ABSPATH' ) ) {
	return;
}

class Olympus_Chronicles_Widget extends \Elementor\Widget_Base {

	public function get_name() { return 'olympus_chronicles'; }
	public function get_title() { return esc_html__( 'Olympus Chronicles', 'olympus-elementor' ); }
	public function get_icon() { return 'eicon-time-line'; }
	public function get_categories() { return [ 'olympus' ]; }

	protected function register_controls() {
		$this->start_controls_section( 'section_header', [ 'label' => 'Header' ] );
		$this->add_control( 'label', [ 'label' => 'Label', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'The Age of Gods' ] );
		$this->add_control( 'title', [ 'label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Chronicles of Olympus' ] );
		$this->add_control( 'subtitle', [ 'label' => 'Subtitle', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'From the birth of the cosmos...' ] );
		$this->end_controls_section();

		$this->start_controls_section( 'section_timeline', [ 'label' => 'Timeline Items' ] );
		$repeater = new \Elementor\Repeater();
		$repeater->add_control( 'item_date', [ 'label' => 'Date', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Before Time' ] );
		$repeater->add_control( 'item_event', [ 'label' => 'Event', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'The Birth of Chaos' ] );
		$repeater->add_control( 'item_desc', [ 'label' => 'Description', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => '...' ] );
		$repeater->add_control( 'item_position', [ 'label' => 'Position', 'type' => \Elementor\Controls_Manager::SELECT, 'options' => [ 'left' => 'Left', 'right' => 'Right' ], 'default' => 'left' ] );
		$this->add_control( 'timeline_list', [ 'label' => 'Timeline List', 'type' => \Elementor\Controls_Manager::REPEATER, 'fields' => $repeater->get_controls(), 'title_field' => '{{{ item_event }}}' ] );
		$this->end_controls_section();

		$this->start_controls_section( 'section_style', [ 'label' => 'Style', 'tab' => \Elementor\Controls_Manager::TAB_STYLE ] );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [ 'name' => 'label_tg', 'label' => 'Label Typography', 'selector' => '{{WRAPPER}} .ol-sec-label' ] );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [ 'name' => 'title_tg', 'label' => 'Title Typography', 'selector' => '{{WRAPPER}} .ol-sec-title' ] );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [ 'name' => 'event_tg', 'label' => 'Event Typography', 'selector' => '{{WRAPPER}} .ol-tl-event' ] );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [ 'name' => 'date_tg', 'label' => 'Date Typography', 'selector' => '{{WRAPPER}} .ol-tl-date' ] );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [ 'name' => 'desc_tg', 'label' => 'Description Typography', 'selector' => '{{WRAPPER}} .ol-tl-desc' ] );

		$this->add_control( 'accent_color', [ 'label' => 'Accent Color', 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#C9A227', 'selectors' => [
			'{{WRAPPER}} .ol-sec-label' => 'color: {{VALUE}}',
			'{{WRAPPER}} .ol-tl-date' => 'color: {{VALUE}}',
			'{{WRAPPER}} .ol-tl-dot' => 'background: {{VALUE}}; box-shadow: 0 0 18px {{VALUE}}33;',
			'{{WRAPPER}} .ol-timeline::before' => 'background: linear-gradient(to bottom, transparent, {{VALUE}}44, transparent);'
		] ] );
		$this->add_responsive_control( 'padding', [ 'label' => 'Padding', 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'selectors' => [ '{{WRAPPER}} .ol-chronicles' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}' ] ] );
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<section class="ol-sec ol-chronicles" id="chronicles">
			<div class="ol-sec-inner">
				<div style="max-width: 820px; margin: 0 auto;">
					<div class="ol-sec-label ol-reveal"><?php echo esc_html( $settings['label'] ); ?></div>
					<h2 class="ol-sec-title ol-reveal"><?php echo esc_html( $settings['title'] ); ?></h2>
					<p class="ol-sec-sub ol-reveal"><?php echo esc_html( $settings['subtitle'] ); ?></p>
					<div class="ol-timeline">
						<?php foreach ( $settings['timeline_list'] as $item ) : ?>
							<div class="ol-tl-item">
								<div class="ol-tl-left"><?php if ( $item['item_position'] === 'left' ) : ?><div class="ol-tl-date ol-reveal"><?php echo esc_html( $item['item_date'] ); ?></div><div class="ol-tl-event ol-reveal"><?php echo esc_html( $item['item_event'] ); ?></div><p class="ol-tl-desc ol-reveal"><?php echo esc_html( $item['item_desc'] ); ?></p><?php endif; ?></div>
								<div class="ol-tl-dot ol-reveal"></div>
								<div class="ol-tl-right"><?php if ( $item['item_position'] === 'right' ) : ?><div class="ol-tl-date ol-reveal"><?php echo esc_html( $item['item_date'] ); ?></div><div class="ol-tl-event ol-reveal"><?php echo esc_html( $item['item_event'] ); ?></div><p class="ol-tl-desc ol-reveal"><?php echo esc_html( $item['item_desc'] ); ?></p><?php endif; ?></div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</section>
		<?php
	}
}
