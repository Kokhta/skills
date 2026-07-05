<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Olympus_10_Oracle_Widget extends \Elementor\Widget_Base {

	public function get_name() { return '10-oracle'; }
	public function get_title() { return esc_html__( '10. Olympus Oracle', 'olympus-elementor-addon' ); }
	public function get_icon() { return 'eicon-blockquote'; }
	public function get_categories() { return [ 'general' ]; }
	public function get_script_depends() { return [ 'olympus-scripts' ]; }

	protected function register_controls() {
		$this->start_controls_section('section_content', ['label' => esc_html__( 'Content', 'olympus-elementor-addon' ), 'tab' => \Elementor\Controls_Manager::TAB_CONTENT]);
		$this->add_control('bg_text', ['label' => 'Background Text', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'ΧΡΗΣΜΟΣ']);
		$this->add_control('icon', ['label' => 'Icon', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '🏛️']);
		$this->add_control('label', ['label' => 'Label', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'The Oracle of Delphi']);
		$this->add_control('quote', ['label' => 'Quote', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => "\"Know thyself. Nothing in excess.\nCertainty brings insanity.\""]);
		$this->add_control('attribution', ['label' => 'Attribution', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '— The Three Maxims of Delphi']);
		$this->end_controls_section();
		olympus_add_theme_control($this);
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$theme_class = olympus_get_theme_class($settings);
		?>
		<section class="ol-oracle <?php echo esc_attr($theme_class); ?>" id="oracle">
			<div class="ol-oracle-bg"><?php echo esc_html( $settings['bg_text'] ); ?></div>
			<div class="ol-oracle-inner">
				<span class="ol-oracle-icon ol-reveal"><?php echo esc_html( $settings['icon'] ); ?></span>
				<div class="ol-sec-label ol-reveal"><?php echo esc_html( $settings['label'] ); ?></div>
				<div class="ol-g-rule ol-reveal"><div class="ol-g-rule-line"></div><div class="ol-g-rule-sym">✦</div><div class="ol-g-rule-line rev"></div></div>
				<p class="ol-oracle-quote ol-reveal"><?php echo wp_kses( nl2br( $settings['quote'] ), [ 'em' => [], 'br' => [] ] ); ?></p>
				<div class="ol-g-rule ol-reveal"><div class="ol-g-rule-line"></div><div class="ol-g-rule-sym">✦</div><div class="ol-g-rule-line rev"></div></div>
				<div class="ol-oracle-attr ol-reveal"><?php echo esc_html( $settings['attribution'] ); ?></div>
			</div>
		</section>
		<?php
	}

	protected function content_template() {
		?>
		<# var themeClass = settings.widget_theme !== 'inherit' ? 'ol-theme-' + settings.widget_theme : ''; #>
		<section class="ol-oracle {{ themeClass }}">
			<div class="ol-oracle-bg">{{{ settings.bg_text }}}</div>
			<div class="ol-oracle-inner">
				<span class="ol-oracle-icon ol-reveal">{{{ settings.icon }}}</span>
				<div class="ol-sec-label ol-reveal">{{{ settings.label }}}</div>
				<div class="ol-g-rule ol-reveal"><div class="ol-g-rule-line"></div><div class="ol-g-rule-sym">✦</div><div class="ol-g-rule-line rev"></div></div>
				<p class="ol-oracle-quote ol-reveal">{{{ settings.quote.replace(/\n/g, '<br>') }}}</p>
				<div class="ol-g-rule ol-reveal"><div class="ol-g-rule-line"></div><div class="ol-g-rule-sym">✦</div><div class="ol-g-rule-line rev"></div></div>
				<div class="ol-oracle-attr ol-reveal">{{{ settings.attribution }}}</div>
			</div>
		</section>
		<?php
	}
}
