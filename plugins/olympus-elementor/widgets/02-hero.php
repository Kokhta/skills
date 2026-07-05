<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

class Olympus_02_hero_Widget extends \Elementor\Modules\NestedElements\Base\Widget_Nested_Base {

	public function get_name() {
		return '02-hero';
	}

	public function get_title() {
		return esc_html__( '02 Hero', 'olympus-elementor' );
	}

	public function get_icon() {
		return 'eicon-video-camera';
	}

	public function get_categories() {
		return [ 'olympus' ];
	}

	protected function get_default_children_elements() {
		return [
			[ 'elType' => 'widget', 'widgetType' => 'video', 'settings' => [ 'video_type' => 'hosted', 'autoplay' => 'yes', 'loop' => 'yes', 'mute' => 'yes', 'controls' => '', '_class' => 'hero-video' ] ],
			[ 'elType' => 'widget', 'widgetType' => 'html', 'settings' => [ 'html' => '<div class="hero-overlay"></div>' ] ],
			[ 'elType' => 'widget', 'widgetType' => 'html', 'settings' => [ 'html' => '<div class="hero-grain"></div>' ] ],
			[ 'elType' => 'widget', 'widgetType' => 'html', 'settings' => [ 'html' => '<div class="hero-rule"></div>' ] ],
			[ 'elType' => 'widget', 'widgetType' => 'html', 'settings' => [ 'html' => '<div class="corner tl"></div><div class="corner tr"></div><div class="corner bl"></div><div class="corner br"></div>' ] ],
			[ 'elType' => 'widget', 'widgetType' => 'heading', 'settings' => [ 'title' => 'Ἐν ἀρχῇ ἦν τὸ Χάος', 'header_size' => 'div', '_class' => 'hero-eyebrow' ] ],
			[ 'elType' => 'widget', 'widgetType' => 'html', 'settings' => [ 'html' => '<div class="hero-gem"><div class="hero-gem-line"></div><div class="hero-gem-dot">✦</div><div class="hero-gem-line"></div></div>' ] ],
			[ 'elType' => 'widget', 'widgetType' => 'heading', 'settings' => [ 'title' => 'OLYMPUS <span class="hero-title-greek">ΟΛΥΜΠΟΣ</span>', 'header_size' => 'h1', '_class' => 'hero-title' ] ],
			[ 'elType' => 'widget', 'widgetType' => 'text-editor', 'settings' => [ 'content' => 'Where thunder meets the stars, and mortals kneel<br>before the eternal throne of the divine', '_class' => 'hero-sub' ] ],
			[ 'elType' => 'widget', 'widgetType' => 'heading', 'settings' => [ 'title' => 'Ζεύς · Ποσειδῶν · Ἅιδης · Ἀθηνᾶ · Ἀπόλλων · Ἄρης', 'header_size' => 'div', '_class' => 'hero-gods' ] ],
			[ 'elType' => 'widget', 'widgetType' => 'html', 'settings' => [ 'html' => '<div class="scroll-cue"><span>Scroll</span><div class="scroll-cue-line"></div></div>' ] ],
		];
	}

	protected function get_default_repeater_title_setting_key() {
		return '';
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_settings',
			[
				'label' => esc_html__( 'Animation Settings', 'olympus-elementor' ),
			]
		);

		$this->add_control(
			'scrub_value',
			[
				'label' => esc_html__( 'Scrub Value', 'olympus-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => 0.25,
				'step' => 0.05,
			]
		);

		$this->add_control(
			'video_scale_end',
			[
				'label' => esc_html__( 'Video Scale End', 'olympus-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => 1.07,
				'step' => 0.01,
			]
		);

		$this->add_control(
			'content_fade_percent',
			[
				'label' => esc_html__( 'Content Fade %', 'olympus-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => 28,
				'min' => 1,
				'max' => 100,
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<section class="hero-wrap"
                 data-scrub="<?php echo esc_attr($settings['scrub_value']); ?>"
                 data-scale="<?php echo esc_attr($settings['video_scale_end']); ?>"
                 data-fade-percent="<?php echo esc_attr($settings['content_fade_percent']); ?>">
			<div class="hero-sticky">
				<div class="hero-content">
					<?php
					if ( method_exists( $this, 'print_child_widgets_content' ) ) {
						$this->print_child_widgets_content();
					} else {
						foreach ( $this->get_settings( 'elements' ) as $child_element ) {
							$child_element->print_element();
						}
					}
					?>
				</div>
			</div>
		</section>
		<?php
	}

	protected function content_template() {
		?>
		<section class="hero-wrap">
			<div class="hero-sticky">
				<div class="hero-content">
					<div class="elementor-child-contents"></div>
				</div>
			</div>
		</section>
		<?php
	}
}
