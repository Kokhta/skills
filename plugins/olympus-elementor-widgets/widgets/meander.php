<?php
if ( ! defined( 'ABSPATH' ) ) {
	return;
}

class Olympus_Meander_Widget extends \Elementor\Widget_Base {

	public function get_name() { return 'olympus_meander'; }
	public function get_title() { return esc_html__( 'Olympus Meander Separator', 'olympus-elementor' ); }
	public function get_icon() { return 'eicon-divider-shape'; }
	public function get_categories() { return [ 'olympus' ]; }

	protected function register_controls() {
		$this->start_controls_section( 'section_style', [ 'label' => 'Style' ] );
		$this->add_control( 'color', [
			'label' => 'Color',
			'type' => \Elementor\Controls_Manager::COLOR,
			'default' => '#C9A227',
			'selectors' => [ '{{WRAPPER}} .ol-meander' => 'color: {{VALUE}}' ]
		] );
		$this->add_control( 'opacity', [
			'label' => 'Opacity',
			'type' => \Elementor\Controls_Manager::SLIDER,
			'range' => [ 'px' => [ 'min' => 0, 'max' => 1, 'step' => 0.1 ] ],
			'default' => [ 'size' => 0.45 ],
			'selectors' => [ '{{WRAPPER}} .ol-meander' => 'opacity: {{SIZE}}' ]
		] );
		$this->add_responsive_control( 'margin', [
			'label' => 'Margin',
			'type' => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em', '%' ],
			'selectors' => [ '{{WRAPPER}} .ol-meander' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}' ]
		] );
		$this->end_controls_section();
	}

	protected function render() {
		?>
		<div class="ol-meander" style="width: 100%; height: 22px; background-image: url(&quot;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='44' height='22'%3E%3Cpath d='M0 11h6V5h6v6h6V5h6v11h-6v-5h-6v5h-6V5H0z' fill='none' stroke='currentColor' stroke-width='1'/%3E%3C/svg%3E&quot;); background-repeat: repeat-x; background-position: center;"></div>
		<?php
	}
}
