<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Modules\NestedElements\Base\Widget_Nested_Base;

class Olympus_06_Pantheon_Widget extends Widget_Nested_Base {

	public function get_name() { return 'olympus-pantheon'; }
	public function get_title() { return esc_html__( '06-Pantheon', 'olympus-elements' ); }
	public function get_icon() { return 'eicon-gallery-grid'; }
	public function get_categories() { return [ 'olympus' ]; }

	protected function register_controls() {
		$this->start_controls_section('section_content', ['label' => 'Content']);
		$this->add_control('label', ['label' => 'Label', 'type' => Controls_Manager::TEXT, 'default' => 'The Twelve Olympians']);
		$this->add_control('title', ['label' => 'Title', 'type' => Controls_Manager::TEXT, 'default' => 'The Divine Pantheon']);
		$this->add_control('subtitle', ['label' => 'Subtitle', 'type' => Controls_Manager::TEXTAREA, 'default' => 'Rulers of the cosmos...']);

		$repeater = new \Elementor\Repeater();
		$repeater->add_control('symbol', ['label' => 'Symbol', 'type' => Controls_Manager::TEXT, 'default' => '⚡']);
		$repeater->add_control('realm', ['label' => 'Realm', 'type' => Controls_Manager::TEXT, 'default' => 'King of the Gods']);
		$repeater->add_control('name', ['label' => 'Name', 'type' => Controls_Manager::TEXT, 'default' => 'Zeus']);
		$repeater->add_control('desc', ['label' => 'Description', 'type' => Controls_Manager::TEXTAREA, 'default' => 'Lord of sky...']);
		$repeater->add_control('num', ['label' => 'Roman Numeral', 'type' => Controls_Manager::TEXT, 'default' => 'I']);

		$this->add_control('gods', ['label' => 'Gods', 'type' => Controls_Manager::REPEATER, 'fields' => $repeater->get_controls(), 'default' => [ ['name' => 'Zeus'], ['name' => 'Poseidon'] ]]);
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<section class=\"sec pantheon\" id=\"pantheon\">
			<div class=\"sec-inner\">
				<div class=\"sec-label reveal\"><?php echo esc_html($settings['label']); ?></div>
				<h2 class=\"sec-title reveal\"><?php echo esc_html($settings['title']); ?></h2>
				<p class=\"sec-sub reveal\"><?php echo esc_html($settings['subtitle']); ?></p>
				<div class=\"gods-grid\">
					<?php foreach ($settings['gods'] as $god): ?>
					<div class=\"god-card reveal\">
						<span class=\"god-sym\"><?php echo esc_html($god['symbol']); ?></span>
						<div class=\"god-realm\"><?php echo esc_html($god['realm']); ?></div>
						<div class=\"god-name\"><?php echo esc_html($god['name']); ?></div>
						<p class=\"god-desc\"><?php echo esc_html($god['desc']); ?></p>
						<div class=\"god-num\"><?php echo esc_html($god['num']); ?></div>
					</div>
					<?php endforeach; ?>
				</div>
			</div>
			<?php $this->print_child_elements(); ?>
		</section>
		<?php
	}
}
