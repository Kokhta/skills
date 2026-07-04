<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

class Olympus_Intro_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'olympus-intro';
	}

	public function get_title() {
		return esc_html__( '2-Intro', 'olympus-elementor-widgets' );
	}

	public function get_icon() {
		return 'eicon-text-area';
	}

	public function get_categories() {
		return [ 'general' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'olympus-elementor-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'label',
			[
				'label' => esc_html__( 'Label', 'olympus-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'The Ancient World',
			]
		);

		$this->add_control(
			'quote',
			[
				'label' => esc_html__( 'Quote', 'olympus-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => '"From Chaos came the Earth, and from the Earth came all things divine — the <em>twelve immortals</em> who shaped the fate of gods and men alike from their thrones upon Mount Olympus."',
			]
		);

		$this->add_control(
			'source',
			[
				'label' => esc_html__( 'Source', 'olympus-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '— Hesiod · Theogony · 700 BCE',
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<section class="intro">
			<div class="intro-inner">
				<div class="sec-label reveal"><?php echo esc_html($settings['label']); ?></div>
				<div class="g-rule reveal">
					<div class="g-rule-line"></div>
					<div class="g-rule-sym">⚡</div>
					<div class="g-rule-line rev"></div>
				</div>
				<div class="intro-quote reveal">
					<?php echo $settings['quote']; ?>
				</div>
				<div class="g-rule reveal">
					<div class="g-rule-line"></div>
					<div class="g-rule-sym">✦</div>
					<div class="g-rule-line rev"></div>
				</div>
				<div class="intro-source reveal"><?php echo esc_html($settings['source']); ?></div>
			</div>
		</section>
		<div class="meander"></div>
		<?php
	}
}
