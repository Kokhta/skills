<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class Avatice_3D_Interaction_Widget extends \Elementor\Widget_Base {
	public function get_name() { return 'avatice_3d_interaction'; }
	public function get_title() { return '3D Interaction Area'; }
	public function get_icon() { return 'eicon-form-horizontal'; }
	public function get_categories() { return [ 'general' ]; }

	protected function register_controls() {
		$this->start_controls_section('content', ['label' => 'Settings']);
		$this->add_control('label', ['label' => 'Placeholder Label', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '3D INTERACTIVE INTERFACE']);
        $this->add_control('interaction_id', ['label' => 'Interaction ID', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'form-hero-3d']);
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<div id="<?php echo esc_attr($settings['interaction_id']); ?>" style="width:100%;height:450px;position:relative;display:flex;align-items:center;justify-content:center;font:700 20px Vazirmatn;color:#2bb8ec">
            <?php echo esc_html($settings['label']); ?>
        </div>
		<?php
	}
}
