<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class Avatice_Z_Depth_Rail_Widget extends \Elementor\Widget_Base {
	public function get_name() { return 'avatice_z_depth_rail'; }
	public function get_title() { return 'Z-Depth Rail'; }
	public function get_icon() { return 'eicon-navigator'; }
	public function get_categories() { return [ 'general' ]; }

	protected function register_controls() {
		$this->start_controls_section('content', ['label' => 'Settings']);
		$this->add_control('rail_color', ['label' => 'Rail Color', 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#2bb8ec']);
        $this->add_control('max_stops', ['label' => 'Total Stops', 'type' => \Elementor\Controls_Manager::NUMBER, 'default' => 10]);
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<div class="avatice-3d-rail" style="pointer-events: none;">
			<div style="font:700 8px 'Space Mono',monospace;color:#5a8aa0;letter-spacing:.1em;writing-mode:vertical-rl">Z-DEPTH</div>
			<div style="width:3px;height:170px;background:rgba(255,255,255,.1);border-radius:3px;position:relative;overflow:hidden">
				<div id="avatice-rail-progress" style="position:absolute;left:0;right:0;top:0;height:8%;background:<?php echo esc_attr($settings['rail_color']); ?>;border-radius:3px;transition:height .15s linear"></div>
			</div>
			<div id="avatice-rail-stop" style="font:700 9px 'Space Mono',monospace;color:#8fd6f4">01<span style="color:#4a6675">/<?php echo esc_html($settings['max_stops']); ?></span></div>
		</div>
		<?php
	}
}
