<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

class Olympus_06_oracle_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return '06-oracle';
	}

	public function get_title() {
		return esc_html__( '06 Oracle', 'olympus-elementor' );
	}

	public function get_icon() {
		return 'eicon-blockquote';
	}

	public function get_categories() {
		return [ 'olympus' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Content', 'olympus-elementor' ),
			]
		);

		$this->add_control(
			'watermark',
			[
				'label' => esc_html__( 'Watermark Text', 'olympus-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'ΧΡΗΣΜΟΣ',
			]
		);

		$this->add_control(
			'icon',
			[
				'label' => esc_html__( 'Icon (Emoji)', 'olympus-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '🏛️',
			]
		);

		$this->add_control(
			'quote',
			[
				'label' => esc_html__( 'Quote', 'olympus-elementor' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => '"Know thyself. Nothing in excess.<br><em>Certainty brings insanity.</em>"',
			]
		);

		$this->add_control(
			'attribution',
			[
				'label' => esc_html__( 'Attribution', 'olympus-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '— The Three Maxims of Delphi, inscribed at Apollo\'s Temple',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<section class="oracle site-body">
			<div class="oracle-bg"><?php echo esc_html( $settings['watermark'] ); ?></div>
			<div class="oracle-inner">
				<span class="oracle-icon reveal"><?php echo esc_html( $settings['icon'] ); ?></span>
				<div class="sec-label reveal"><?php echo esc_html__( 'The Oracle of Delphi', 'olympus-elementor' ); ?></div>
				<div class="g-rule reveal">
					<div class="g-rule-line"></div>
					<div class="g-rule-sym">✦</div>
					<div class="g-rule-line rev"></div>
				</div>
				<div class="oracle-quote reveal"><?php echo $settings['quote']; ?></div>
				<div class="g-rule reveal">
					<div class="g-rule-line"></div>
					<div class="g-rule-sym">✦</div>
					<div class="g-rule-line rev"></div>
				</div>
				<div class="oracle-attr reveal"><?php echo esc_html( $settings['attribution'] ); ?></div>
			</div>
		</section>
		<div class="olympus-meander"></div>
		<?php
	}
}
