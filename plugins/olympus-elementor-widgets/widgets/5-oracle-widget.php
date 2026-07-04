<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

class Olympus_Oracle_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'olympus-oracle';
	}

	public function get_title() {
		return esc_html__( '5-Oracle', 'olympus-elementor-widgets' );
	}

	public function get_icon() {
		return 'eicon-blockquote';
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
			'bg_text',
			[
				'label' => esc_html__( 'Background Text', 'olympus-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'ΧΡΗΣΜΟΣ',
			]
		);

		$this->add_control(
			'icon',
			[
				'label' => esc_html__( 'Icon', 'olympus-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '🏛️',
			]
		);

		$this->add_control(
			'label',
			[
				'label' => esc_html__( 'Label', 'olympus-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'The Oracle of Delphi',
			]
		);

		$this->add_control(
			'quote',
			[
				'label' => esc_html__( 'Quote', 'olympus-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => '"Know thyself. Nothing in excess. <em>Certainty brings insanity.</em>"',
			]
		);

		$this->add_control(
			'attribution',
			[
				'label' => esc_html__( 'Attribution', 'olympus-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '— The Three Maxims of Delphi, inscribed at Apollo\'s Temple',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<section class="oracle">
			<div class="oracle-bg"><?php echo esc_html($settings['bg_text']); ?></div>
			<div class="oracle-inner">
				<span class="oracle-icon reveal"><?php echo esc_html($settings['icon']); ?></span>
				<div class="sec-label reveal"><?php echo esc_html($settings['label']); ?></div>
				<div class="g-rule reveal">
					<div class="g-rule-line"></div>
					<div class="g-rule-sym">✦</div>
					<div class="g-rule-line rev"></div>
				</div>
				<div class="oracle-quote reveal">
					<?php echo $settings['quote']; ?>
				</div>
				<div class="g-rule reveal">
					<div class="g-rule-line"></div>
					<div class="g-rule-sym">✦</div>
					<div class="g-rule-line rev"></div>
				</div>
				<div class="oracle-attr reveal"><?php echo esc_html($settings['attribution']); ?></div>
			</div>
		</section>
		<div class="meander"></div>
		<?php
	}
}
