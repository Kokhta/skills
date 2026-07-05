<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Modules\NestedElements\Base\Widget_Nested_Base;

class Olympus_04_Intro_Widget extends Widget_Nested_Base {

	public function get_name() { return 'olympus-intro'; }
	public function get_title() { return esc_html__( '04-Intro', 'olympus-elements' ); }
	public function get_icon() { return 'eicon-text-area'; }
	public function get_categories() { return [ 'olympus' ]; }

	protected function register_controls() {
		$this->start_controls_section('section_content', ['label' => esc_html__( 'Content', 'olympus-elements' )]);
		$this->add_control('label', ['label' => 'Label', 'type' => Controls_Manager::TEXT, 'default' => 'The Ancient World']);
		$this->add_control('quote', ['label' => 'Quote', 'type' => Controls_Manager::TEXTAREA, 'default' => '\"From Chaos came the Earth, and from the Earth came all things divine — the <em>twelve immortals</em> who shaped the fate of gods and men alike from their thrones upon Mount Olympus.\"']);
		$this->add_control('source', ['label' => 'Source', 'type' => Controls_Manager::TEXT, 'default' => '— Hesiod · Theogony · 700 BCE']);
		$this->end_controls_section();

		$this->start_controls_section('section_style', ['label' => 'Style', 'tab' => Controls_Manager::TAB_STYLE]);
		$this->add_control('text_color', ['label' => 'Text Color', 'type' => Controls_Manager::COLOR, 'selectors' => ['{{WRAPPER}} .intro' => 'color: {{VALUE}};']]);
		$this->add_group_control(Group_Control_Typography::get_type(), ['name' => 'quote_typography', 'selector' => '{{WRAPPER}} .intro-quote']);
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<section class=\"intro\" id=\"intro\">
			<div class=\"intro-inner\">
				<div class=\"sec-label reveal\"><?php echo esc_html($settings['label']); ?></div>
				<div class=\"g-rule reveal\"><div class=\"g-rule-line\"></div><div class=\"g-rule-sym\">⚡</div><div class=\"g-rule-line rev\"></div></div>
				<p class=\"intro-quote reveal\"><?php echo wp_kses_post($settings['quote']); ?></p>
				<div class=\"g-rule reveal\"><div class=\"g-rule-line\"></div><div class=\"g-rule-sym\">✦</div><div class=\"g-rule-line rev\"></div></div>
				<div class=\"intro-source reveal\"><?php echo esc_html($settings['source']); ?></div>
			</div>
			<?php $this->print_child_elements(); ?>
		</section>
		<?php
	}
}
