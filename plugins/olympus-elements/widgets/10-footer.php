<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Modules\NestedElements\Base\Widget_Nested_Base;

class Olympus_10_Footer_Widget extends Widget_Nested_Base {

	public function get_name() { return 'olympus-footer'; }
	public function get_title() { return esc_html__( '10-Footer', 'olympus-elements' ); }
	public function get_icon() { return 'eicon-footer'; }
	public function get_categories() { return [ 'olympus' ]; }

	protected function register_controls() {
		$this->start_controls_section('section_content', ['label' => 'Content']);
		$this->add_control('logo', ['label' => 'Logo Text', 'type' => Controls_Manager::TEXT, 'default' => 'OLYMPUS']);
		$this->add_control('tagline', ['label' => 'Tagline', 'type' => Controls_Manager::TEXT, 'default' => 'ΟΛΥΜΠΟΣ · Realm of the Eternal Gods']);
		$this->add_control('copyright', ['label' => 'Copyright', 'type' => Controls_Manager::TEXT, 'default' => '✦ MMXXVI · Where the Gods Dwell Eternal ✦']);
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<footer>
			<div class=\"foot-top\">
				<div>
					<div class=\"foot-logo\"><?php echo esc_html($settings['logo']); ?></div>
					<div class=\"foot-tagline\"><?php echo esc_html($settings['tagline']); ?></div>
				</div>
			</div>
			<div class=\"foot-bottom\">
				<div class=\"foot-copy\"><?php echo esc_html($settings['copyright']); ?></div>
			</div>
			<?php $this->print_child_elements(); ?>
		</footer>
		<?php
	}
}
