<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Olympus_10_Oracle_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return '10-oracle';
	}

	public function get_title() {
		return esc_html__( '10. Olympus Oracle', 'olympus-elementor-addon' );
	}

	public function get_icon() {
		return 'eicon-blockquote';
	}

	public function get_categories() {
		return [ 'general' ];
	}

	public function get_script_depends() {
		return [ 'olympus-scripts' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Content', 'olympus-elementor-addon' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'bg_text',
			[
				'label' => esc_html__( 'Background Text', 'olympus-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'ΧΡΗΣΜΟΣ', 'olympus-elementor-addon' ),
			]
		);

		$this->add_control(
			'icon',
			[
				'label' => esc_html__( 'Icon', 'olympus-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '🏛️',
			]
		);

		$this->add_control(
			'label',
			[
				'label' => esc_html__( 'Label', 'olympus-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'The Oracle of Delphi', 'olympus-elementor-addon' ),
			]
		);

		$this->add_control(
			'quote',
			[
				'label' => esc_html__( 'Quote', 'olympus-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( "\"Know thyself. Nothing in excess.\nCertainty brings insanity.\"", 'olympus-elementor-addon' ),
			]
		);

		$this->add_control(
			'attribution',
			[
				'label' => esc_html__( 'Attribution', 'olympus-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( '— The Three Maxims of Delphi, inscribed at Apollo\'s Temple', 'olympus-elementor-addon' ),
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<section class="ol-oracle" id="oracle">
			<div class="ol-oracle-bg"><?php echo esc_html( $settings['bg_text'] ); ?></div>
			<div class="ol-oracle-inner">
				<span class="ol-oracle-icon ol-reveal"><?php echo esc_html( $settings['icon'] ); ?></span>
				<div class="ol-sec-label ol-reveal"><?php echo esc_html( $settings['label'] ); ?></div>
				<div class="ol-g-rule ol-reveal">
					<div class="ol-g-rule-line"></div>
					<div class="ol-g-rule-sym">✦</div>
					<div class="ol-g-rule-line rev"></div>
				</div>
				<p class="ol-oracle-quote ol-reveal">
					<?php echo wp_kses( nl2br( $settings['quote'] ), [ 'em' => [], 'br' => [] ] ); ?>
				</p>
				<div class="ol-g-rule ol-reveal">
					<div class="ol-g-rule-line"></div>
					<div class="ol-g-rule-sym">✦</div>
					<div class="ol-g-rule-line rev"></div>
				</div>
				<div class="ol-oracle-attr ol-reveal"><?php echo esc_html( $settings['attribution'] ); ?></div>
			</div>
		</section>
		<?php
	}

	protected function content_template() {
		?>
		<section class="ol-oracle">
			<div class="ol-oracle-bg">{{{ settings.bg_text }}}</div>
			<div class="ol-oracle-inner">
				<span class="ol-oracle-icon ol-reveal">{{{ settings.icon }}}</span>
				<div class="ol-sec-label ol-reveal">{{{ settings.label }}}</div>
				<div class="ol-g-rule ol-reveal">
					<div class="ol-g-rule-line"></div>
					<div class="ol-g-rule-sym">✦</div>
					<div class="ol-g-rule-line rev"></div>
				</div>
				<p class="ol-oracle-quote ol-reveal">{{{ settings.quote.replace(/\n/g, '<br>') }}}</p>
				<div class="ol-g-rule ol-reveal">
					<div class="ol-g-rule-line"></div>
					<div class="ol-g-rule-sym">✦</div>
					<div class="ol-g-rule-line rev"></div>
				</div>
				<div class="ol-oracle-attr ol-reveal">{{{ settings.attribution }}}</div>
			</div>
		</section>
		<?php
	}
}
