<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Modules\NestedElements\Base\Widget_Nested_Base;

class Olympus_08_Oracle_Widget extends Widget_Nested_Base {

	public function get_name() { return 'olympus-oracle'; }
	public function get_title() { return esc_html__( '08-Oracle', 'olympus-elements' ); }
	public function get_icon() { return 'eicon-blockquote'; }
	public function get_categories() { return [ 'olympus' ]; }

	protected function register_controls() {
		$this->start_controls_section('section_content', ['label' => 'Content']);
		$this->add_control('bg_text', ['label' => 'Background Text', 'type' => Controls_Manager::TEXT, 'default' => 'ΧΡΗΣΜΟΣ']);
		$this->add_control('quote', ['label' => 'Quote', 'type' => Controls_Manager::TEXTAREA, 'default' => '\"Know thyself. Nothing in excess.<br><em>Certainty brings insanity.</em>\"']);
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<section class=\"oracle\" id=\"oracle\">
			<div class=\"oracle-bg\"><?php echo esc_html($settings['bg_text']); ?></div>
			<div class=\"oracle-inner\">
				<p class=\"oracle-quote reveal\"><?php echo wp_kses_post($settings['quote']); ?></p>
			</div>
			<?php $this->print_child_elements(); ?>
		</section>
		<?php
	}
}
