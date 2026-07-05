<?php
if ( ! defined( 'ABSPATH' ) ) {
	return;
}

class Elementor_Olympus_Intro_Widget extends \Elementor\Widget_Base {

	public function get_name() { return 'olympus_intro'; }
	public function get_title() { return esc_html__( 'Olympus Intro', 'olympus-widgets' ); }
	public function get_icon() { return 'eicon-t-letter'; }
	public function get_categories() { return [ 'general' ]; }

	protected function register_controls() {
		$this->start_controls_section('content', ['label' => esc_html__( 'Content', 'olympus-widgets' )]);
		$this->add_control('label', ['label' => esc_html__( 'Label', 'olympus-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'The Ancient World']);
		$this->add_control('quote', ['label' => esc_html__( 'Quote', 'olympus-widgets' ), 'type' => \Elementor\Controls_Manager::WYSIWYG, 'default' => '"From Chaos came the Earth, and from the Earth came all things divine — the <em>twelve immortals</em> who shaped the fate of gods and men alike from their thrones upon Mount Olympus."']);
		$this->add_control('source', ['label' => esc_html__( 'Source', 'olympus-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '— Hesiod · Theogony · 700 BCE']);
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<style>
			.ol-intro { padding: 8rem 4rem; background: var(--bg); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border); transition: background var(--tt), border-color var(--tt); }
			.ol-intro-inner { max-width: 860px; margin: 0 auto; text-align: center; }
			.ol-intro-quote { font-size: clamp(1.35rem, 3vw, 2.1rem); font-style: italic; font-weight: 300; color: var(--text); line-height: 1.72; transition: color var(--tt); }
			.ol-intro-quote em { color: var(--gold); font-style: normal; }
			.ol-intro-source { font-family: 'Cinzel', serif; font-size: .65rem; letter-spacing: .42em; color: var(--text-muted); text-transform: uppercase; transition: color var(--tt); }
		</style>
		<section class="ol-intro">
			<div class="ol-intro-inner">
				<div class="ol-sec-label ol-reveal"><?php echo esc_html( $settings['label'] ); ?></div>
				<div class="ol-g-rule ol-reveal"><div class="ol-g-rule-line"></div><div class="ol-g-rule-sym">⚡</div><div class="ol-g-rule-line rev"></div></div>
				<div class="ol-intro-quote ol-reveal"><?php echo $settings['quote']; ?></div>
				<div class="ol-g-rule ol-reveal"><div class="ol-g-rule-line"></div><div class="ol-g-rule-sym">✦</div><div class="ol-g-rule-line rev"></div></div>
				<div class="ol-intro-source ol-reveal"><?php echo esc_html( $settings['source'] ); ?></div>
			</div>
		</section>
		<?php
	}
}
