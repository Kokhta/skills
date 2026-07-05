<?php
if ( ! defined( 'ABSPATH' ) ) { return; }

class Elementor_Olympus_Oracle_Widget extends \Elementor\Widget_Base {
	public function get_name() { return 'olympus_oracle'; }
	public function get_title() { return esc_html__( 'Olympus Oracle', 'olympus-widgets' ); }
	public function get_icon() { return 'eicon-testimonial'; }
	public function get_categories() { return [ 'general' ]; }

	protected function register_controls() {
		$this->start_controls_section('content', ['label' => 'Content']);
		$this->add_control('watermark', ['label' => 'Watermark', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'ΧΡΗΣΜΟΣ']);
		$this->add_control('quote', ['label' => 'Quote', 'type' => \Elementor\Controls_Manager::WYSIWYG, 'default' => '"Know thyself. Nothing in excess. <em>Certainty brings insanity.</em>"']);
		$this->add_control('attr', ['label' => 'Attribution', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '— The Three Maxims of Delphi']);
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<style>
			.ol-oracle { padding: 10rem 4rem; background: var(--bg-alt); text-align: center; position: relative; overflow: hidden; transition: background var(--tt); }
			.ol-oracle-bg { position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%); font-family: 'Cinzel Decorative', serif; font-size: 14vw; font-weight: 900; color: var(--gold); opacity: .055; white-space: nowrap; pointer-events: none; transition: color var(--tt); }
			.ol-oracle-inner { position: relative; z-index: 1; max-width: 780px; margin: 0 auto; }
			.ol-oracle-quote { font-size: clamp(1.45rem, 3.5vw, 2.45rem); font-style: italic; font-weight: 300; color: var(--text); line-height: 1.62; transition: color var(--tt); }
			.ol-oracle-quote em { color: var(--gold); font-style: normal; }
		</style>
		<section class="ol-oracle">
			<div class="ol-oracle-bg"><?php echo esc_html($settings['watermark']); ?></div>
			<div class="ol-oracle-inner">
				<span class="oracle-icon ol-reveal">🏛️</span>
				<div class="ol-sec-label ol-reveal">The Oracle of Delphi</div>
				<div class="ol-g-rule ol-reveal"><div class="ol-g-rule-line"></div><div class="ol-g-rule-sym">✦</div><div class="ol-g-rule-line rev"></div></div>
				<div class="ol-oracle-quote ol-reveal"><?php echo $settings['quote']; ?></div>
				<div class="ol-g-rule ol-reveal"><div class="ol-g-rule-line"></div><div class="ol-g-rule-sym">✦</div><div class="ol-g-rule-line rev"></div></div>
				<div class="ol-sec-label ol-reveal"><?php echo esc_html($settings['attr']); ?></div>
			</div>
		</section>
		<?php
	}
}
