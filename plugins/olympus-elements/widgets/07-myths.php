<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Modules\NestedElements\Base\Widget_Nested_Base;

class Olympus_07_Myths_Widget extends Widget_Nested_Base {

	public function get_name() { return 'olympus-myths'; }
	public function get_title() { return esc_html__( '07-Myths', 'olympus-elements' ); }
	public function get_icon() { return 'eicon-image-box'; }
	public function get_categories() { return [ 'olympus' ]; }

	protected function register_controls() {
		$this->start_controls_section('section_content', ['label' => 'Content']);
		$repeater = new \Elementor\Repeater();
		$repeater->add_control('title', ['label' => 'Title', 'type' => Controls_Manager::TEXT, 'default' => 'The Titanomachy']);
		$repeater->add_control('label', ['label' => 'Label', 'type' => Controls_Manager::TEXT, 'default' => 'Sacred Tales']);
		$repeater->add_control('body', ['label' => 'Body', 'type' => Controls_Manager::TEXTAREA, 'default' => 'For ten savage years...']);
		$repeater->add_control('flip', ['label' => 'Flip Layout', 'type' => Controls_Manager::SWITCHER, 'default' => '']);
		$repeater->add_control('icon', ['label' => 'Icon/Symbol', 'type' => Controls_Manager::TEXT, 'default' => '⚡']);

		$this->add_control('myths', ['label' => 'Myths', 'type' => Controls_Manager::REPEATER, 'fields' => $repeater->get_controls()]);
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<section class=\"sec myths\" id=\"myths\">
			<div class=\"sec-inner\">
				<?php foreach ($settings['myths'] as $myth): ?>
				<div class=\"myth-pair <?php echo $myth['flip'] ? 'flip' : ''; ?>\">
					<div class=\"myth-vis reveal\">
						<div class=\"myth-vis-bg\"><?php echo esc_html($myth['icon']); ?></div>
					</div>
					<div>
						<div class=\"myth-label reveal\"><?php echo esc_html($myth['label']); ?></div>
						<h3 class=\"myth-title reveal\"><?php echo esc_html($myth['title']); ?></h3>
						<p class=\"myth-body reveal\"><?php echo esc_html($myth['body']); ?></p>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
			<?php $this->print_child_elements(); ?>
		</section>
		<?php
	}
}
