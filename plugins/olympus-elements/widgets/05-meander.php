<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Modules\NestedElements\Base\Widget_Nested_Base;

class Olympus_05_Meander_Widget extends Widget_Nested_Base {

	public function get_name() { return 'olympus-meander'; }
	public function get_title() { return esc_html__( '05-Meander', 'olympus-elements' ); }
	public function get_icon() { return 'eicon-divider'; }
	public function get_categories() { return [ 'olympus' ]; }

	protected function register_controls() {
		$this->start_controls_section('section_style', ['label' => 'Style', 'tab' => Controls_Manager::TAB_STYLE]);
		$this->add_control('opacity', ['label' => 'Opacity', 'type' => Controls_Manager::SLIDER, 'range' => ['px' => ['min' => 0, 'max' => 1, 'step' => 0.1]], 'selectors' => ['{{WRAPPER}} .ol-meander' => 'opacity: {{SIZE}};']]);
		$this->end_controls_section();
	}

	protected function render() {
		?>
		<div class=\"ol-meander\"></div>
		<?php $this->print_child_elements(); ?>
		<?php
	}
}
