<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Olympus_04_Intro_Widget extends \Elementor\Widget_Base {

	public function get_name() { return '04-intro'; }
	public function get_title() { return esc_html__( '04. Olympus Intro', 'olympus-elementor-addon' ); }
	public function get_icon() { return 'eicon-text-area'; }
	public function get_categories() { return [ 'general' ]; }
	public function get_script_depends() { return [ 'olympus-scripts' ]; }

	protected function register_controls() {
		$this->start_controls_section('section_content', ['label' => esc_html__( 'Content', 'olympus-elementor-addon' ), 'tab' => \Elementor\Controls_Manager::TAB_CONTENT]);
		$this->add_control('label', ['label' => esc_html__( 'Label', 'olympus-elementor-addon' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => esc_html__( 'The Ancient World', 'olympus-elementor-addon' )]);
		$this->add_control('quote', ['label' => esc_html__( 'Quote', 'olympus-elementor-addon' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => esc_html__( '"From Chaos came the Earth, and from the Earth came all things divine — the twelve immortals who shaped the fate of gods and men alike from their thrones upon Mount Olympus."', 'olympus-elementor-addon' )]);
		$this->add_control('source', ['label' => esc_html__( 'Source', 'olympus-elementor-addon' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => esc_html__( '— Hesiod · Theogony · 700 BCE', 'olympus-elementor-addon' )]);
		$this->end_controls_section();
		olympus_add_theme_control($this);
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$theme_class = olympus_get_theme_class($settings);
		?>
		<section class="ol-intro <?php echo esc_attr($theme_class); ?>">
			<div class="ol-intro-inner">
				<div class="ol-sec-label ol-reveal"><?php echo esc_html( $settings['label'] ); ?></div>
				<div class="ol-g-rule ol-reveal"><div class="ol-g-rule-line"></div><div class="ol-g-rule-sym">⚡</div><div class="ol-g-rule-line rev"></div></div>
				<p class="ol-intro-quote ol-reveal"><?php echo wp_kses( $settings['quote'], [ 'em' => [] ] ); ?></p>
				<div class="ol-g-rule ol-reveal"><div class="ol-g-rule-line"></div><div class="ol-g-rule-sym">✦</div><div class="ol-g-rule-line rev"></div></div>
				<div class="ol-intro-source ol-reveal"><?php echo esc_html( $settings['source'] ); ?></div>
			</div>
		</section>
		<?php
	}

	protected function content_template() {
		?>
		<# var themeClass = settings.widget_theme !== 'inherit' ? 'ol-theme-' + settings.widget_theme : ''; #>
		<section class="ol-intro {{ themeClass }}">
			<div class="ol-intro-inner">
				<div class="ol-sec-label ol-reveal">{{{ settings.label }}}</div>
				<div class="ol-g-rule ol-reveal"><div class="ol-g-rule-line"></div><div class="ol-g-rule-sym">⚡</div><div class="ol-g-rule-line rev"></div></div>
				<p class="ol-intro-quote ol-reveal">{{{ settings.quote }}}</p>
				<div class="ol-g-rule ol-reveal"><div class="ol-g-rule-line"></div><div class="ol-g-rule-sym">✦</div><div class="ol-g-rule-line rev"></div></div>
				<div class="ol-intro-source ol-reveal">{{{ settings.source }}}</div>
			</div>
		</section>
		<?php
	}
}
