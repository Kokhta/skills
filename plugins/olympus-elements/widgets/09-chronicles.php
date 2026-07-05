<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Modules\NestedElements\Base\Widget_Nested_Base;

class Olympus_09_Chronicles_Widget extends Widget_Nested_Base {

	public function get_name() { return 'olympus-chronicles'; }
	public function get_title() { return esc_html__( '09-Chronicles', 'olympus-elements' ); }
	public function get_icon() { return 'eicon-bullet-list'; }
	public function get_categories() { return [ 'olympus' ]; }

	protected function register_controls() {
		$this->start_controls_section('section_content', ['label' => 'Content']);
		$repeater = new \Elementor\Repeater();
		$repeater->add_control('date', ['label' => 'Date', 'type' => Controls_Manager::TEXT, 'default' => 'Before Time']);
		$repeater->add_control('event', ['label' => 'Event', 'type' => Controls_Manager::TEXT, 'default' => 'The Birth of Chaos']);
		$repeater->add_control('desc', ['label' => 'Description', 'type' => Controls_Manager::TEXTAREA]);
		$repeater->add_control('side', ['label' => 'Side', 'type' => Controls_Manager::SELECT, 'options' => ['left' => 'Left', 'right' => 'Right'], 'default' => 'left']);

		$this->add_control('items', ['label' => 'Timeline Items', 'type' => Controls_Manager::REPEATER, 'fields' => $repeater->get_controls()]);
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<section class=\"sec chronicles\" id=\"chronicles\">
			<div class=\"timeline\">
				<?php foreach ($settings['items'] as $item): ?>
				<div class=\"ol-tl-item\">
					<div class=\"ol-tl-left\">
						<?php if ($item['side'] === 'left'): ?>
							<div class=\"tl-date reveal\"><?php echo esc_html($item['date']); ?></div>
							<div class=\"tl-event reveal\"><?php echo esc_html($item['event']); ?></div>
							<p class=\"tl-desc reveal\"><?php echo esc_html($item['desc']); ?></p>
						<?php endif; ?>
					</div>
					<div class=\"tl-dot reveal\"></div>
					<div class=\"tl-right\">
						<?php if ($item['side'] === 'right'): ?>
							<div class=\"tl-date reveal\"><?php echo esc_html($item['date']); ?></div>
							<div class=\"tl-event reveal\"><?php echo esc_html($item['event']); ?></div>
							<p class=\"tl-desc reveal\"><?php echo esc_html($item['desc']); ?></p>
						<?php endif; ?>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
			<?php $this->print_child_elements(); ?>
		</section>
		<?php
	}
}
