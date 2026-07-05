<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Olympus_02_Hero_Widget extends \Elementor\Widget_Base {

	public function get_name() { return '02-hero'; }
	public function get_title() { return esc_html__( '02. Olympus Hero', 'olympus-elementor-addon' ); }
	public function get_icon() { return 'eicon-parallax'; }
	public function get_categories() { return [ 'general' ]; }
	public function get_script_depends() { return [ 'olympus-scripts' ]; }

	protected function register_controls() {
		$this->start_controls_section('section_content', ['label' => esc_html__( 'Content', 'olympus-elementor-addon' ), 'tab' => \Elementor\Controls_Manager::TAB_CONTENT]);
		$this->add_control('video_url', ['label' => esc_html__( 'Video URL', 'olympus-elementor-addon' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'https://assets.mixkit.co/videos/preview/mixkit-stars-in-the-night-sky-4006-large.mp4', 'label_block' => true]);
		$this->add_control('eyebrow', ['label' => esc_html__( 'Eyebrow', 'olympus-elementor-addon' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => esc_html__( 'Ἐν ἀρχῇ ἦν τὸ Χάος', 'olympus-elementor-addon' )]);
		$this->add_control('title', ['label' => esc_html__( 'Title', 'olympus-elementor-addon' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => esc_html__( 'OLYMPUS', 'olympus-elementor-addon' )]);
		$this->add_control('title_greek', ['label' => esc_html__( 'Title (Greek)', 'olympus-elementor-addon' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => esc_html__( 'ΟΛΥΜΠΟΣ', 'olympus-elementor-addon' )]);
		$this->add_control('subtitle', ['label' => esc_html__( 'Subtitle', 'olympus-elementor-addon' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => esc_html__( "Where thunder meets the stars, and mortals kneel\nbefore the eternal throne of the divine", 'olympus-elementor-addon' )]);
		$this->add_control('gods_list', ['label' => esc_html__( 'Gods List', 'olympus-elementor-addon' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => esc_html__( 'Ζεύς · Ποσειδῶν · Ἅιδης · Ἀθηνᾶ · Ἀπόλλων · Ἄρης', 'olympus-elementor-addon' ), 'label_block' => true]);
		$this->end_controls_section();
		olympus_add_theme_control($this);
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$theme_class = olympus_get_theme_class($settings);
		?>
		<section class="ol-hero-wrap <?php echo esc_attr($theme_class); ?>">
			<div class="ol-hero-sticky">
				<video id="ol-hero-video" class="ol-hero-video" preload="auto" muted playsinline webkit-playsinline src="<?php echo esc_url( $settings['video_url'] ); ?>"></video>
				<div class="ol-hero-overlay"></div>
				<div class="ol-hero-grain"></div>
				<div class="ol-hero-rule"></div>
				<div class="ol-corner tl"></div><div class="ol-corner tr"></div><div class="ol-corner bl"></div><div class="ol-corner br"></div>
				<div class="ol-hero-content" id="ol-hero-content">
					<div class="ol-hero-eyebrow"><?php echo esc_html( $settings['eyebrow'] ); ?></div>
					<div class="ol-hero-gem"><div class="ol-hero-gem-line"></div><div class="ol-hero-gem-dot">✦</div><div class="ol-hero-gem-line"></div></div>
					<h1 class="ol-hero-title"><?php echo esc_html( $settings['title'] ); ?><span class="ol-hero-title-greek"><?php echo esc_html( $settings['title_greek'] ); ?></span></h1>
					<p class="ol-hero-sub"><?php echo nl2br( esc_html( $settings['subtitle'] ) ); ?></p>
					<div class="ol-hero-gods"><?php echo esc_html( $settings['gods_list'] ); ?></div>
				</div>
				<div class="ol-scroll-cue" id="ol-scroll-cue"><span>Scroll</span><div class="ol-scroll-cue-line"></div></div>
			</div>
		</section>
		<?php
	}

	protected function content_template() {
		?>
		<# var themeClass = settings.widget_theme !== 'inherit' ? 'ol-theme-' + settings.widget_theme : ''; #>
		<section class="ol-hero-wrap {{ themeClass }}">
			<div class="ol-hero-sticky">
				<video id="ol-hero-video" class="ol-hero-video" src="{{ settings.video_url }}" muted></video>
				<div class="ol-hero-overlay"></div><div class="ol-hero-grain"></div><div class="ol-hero-rule"></div>
				<div class="ol-corner tl"></div><div class="ol-corner tr"></div><div class="ol-corner bl"></div><div class="ol-corner br"></div>
				<div class="ol-hero-content" id="ol-hero-content">
					<div class="ol-hero-eyebrow">{{{ settings.eyebrow }}}</div>
					<div class="ol-hero-gem"><div class="ol-hero-gem-line"></div><div class="ol-hero-gem-dot">✦</div><div class="ol-hero-gem-line"></div></div>
					<h1 class="ol-hero-title">{{{ settings.title }}}<span class="ol-hero-title-greek">{{{ settings.title_greek }}}</span></h1>
					<p class="ol-hero-sub">{{{ settings.subtitle.replace(/\n/g, '<br>') }}}</p>
					<div class="ol-hero-gods">{{{ settings.gods_list }}}</div>
				</div>
				<div class="ol-scroll-cue" id="ol-scroll-cue"><span>Scroll</span><div class="ol-scroll-cue-line"></div></div>
			</div>
		</section>
		<?php
	}
}
