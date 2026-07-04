<?php
if ( ! defined( 'ABSPATH' ) ) {
	return;
}

class Olympus_Hero_Widget extends \Elementor\Widget_Base {

	public function get_name() { return 'olympus_hero'; }
	public function get_title() { return esc_html__( 'Olympus Hero', 'olympus-elementor' ); }
	public function get_icon() { return 'eicon-hero-section'; }
	public function get_categories() { return [ 'olympus' ]; }

	protected function register_controls() {
		$this->start_controls_section( 'section_video', [ 'label' => 'Video' ] );
		$this->add_control( 'video_url', [ 'label' => 'Video URL', 'type' => \Elementor\Controls_Manager::MEDIA, 'media_type' => 'video' ] );
		$this->add_control( 'scrub_intensity', [ 'label' => 'Scrub Intensity', 'type' => \Elementor\Controls_Manager::NUMBER, 'default' => 0.25 ] );
		$this->end_controls_section();

		$this->start_controls_section( 'section_content', [ 'label' => 'Content' ] );
		$this->add_control( 'eyebrow', [ 'label' => 'Eyebrow', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Ἐν ἀρχῇ ἦν τὸ Χάος' ] );
		$this->add_control( 'title', [ 'label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'OLYMPUS' ] );
		$this->add_control( 'title_greek', [ 'label' => 'Greek Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'ΟΛΥΜΠΟΣ' ] );
		$this->add_control( 'subtitle', [ 'label' => 'Subtitle', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Where thunder meets the stars, and mortals kneel before the eternal throne of the divine' ] );
		$this->add_control( 'gods_list', [ 'label' => 'Gods List', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Ζεύς · Ποσειδῶν · Ἅιδης · Ἀθηνᾶ · Ἀπόλλων · Ἄρης' ] );
		$this->end_controls_section();

		$this->start_controls_section( 'section_style', [ 'label' => 'Style', 'tab' => \Elementor\Controls_Manager::TAB_STYLE ] );

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [ 'name' => 'title_tg', 'label' => 'Title Typography', 'selector' => '{{WRAPPER}} .ol-hero-title' ] );
		$this->add_control( 'title_color', [ 'label' => 'Title Color', 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#FFFFFF', 'selectors' => [ '{{WRAPPER}} .ol-hero-title' => 'color: {{VALUE}}' ] ] );

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [ 'name' => 'subtitle_tg', 'label' => 'Subtitle Typography', 'selector' => '{{WRAPPER}} .ol-hero-sub' ] );
		$this->add_control( 'subtitle_color', [ 'label' => 'Subtitle Color', 'type' => \Elementor\Controls_Manager::COLOR, 'default' => 'rgba(255,255,255,.78)', 'selectors' => [ '{{WRAPPER}} .ol-hero-sub' => 'color: {{VALUE}}' ] ] );

		$this->add_control( 'gold_color', [ 'label' => 'Accent Gold', 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#D4AF37', 'selectors' => [ '{{WRAPPER}} .ol-hero-eyebrow, {{WRAPPER}} .ol-hero-title-greek, {{WRAPPER}} .ol-hero-gem-dot, {{WRAPPER}} .ol-corner' => 'color: {{VALUE}}; border-color: {{VALUE}}' ] ] );

		$this->add_responsive_control( 'padding', [ 'label' => 'Padding', 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'selectors' => [ '{{WRAPPER}} .ol-hero-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}' ] ] );
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$video_url = isset($settings['video_url']['url']) ? $settings['video_url']['url'] : '';
		?>
		<section class="ol-hero-wrap" data-scrub="<?php echo esc_attr($settings['scrub_intensity']); ?>">
			<div class="ol-hero-sticky">
				<video class="ol-hero-video" preload="auto" muted playsinline webkit-playsinline src="<?php echo esc_url($video_url); ?>"></video>
				<div class="ol-hero-overlay"></div>
				<div class="ol-hero-grain"></div>
				<div class="ol-hero-rule"></div>
				<div class="ol-corner tl"></div><div class="ol-corner tr"></div><div class="ol-corner bl"></div><div class="ol-corner br"></div>
				<div class="ol-hero-content">
					<div class="ol-hero-eyebrow"><?php echo esc_html( $settings['eyebrow'] ); ?></div>
					<div class="ol-hero-gem"><div class="ol-hero-gem-line"></div><div class="ol-hero-gem-dot">✦</div><div class="ol-hero-gem-line"></div></div>
					<h1 class="ol-hero-title"><?php echo esc_html( $settings['title'] ); ?><span class="ol-hero-title-greek"><?php echo esc_html( $settings['title_greek'] ); ?></span></h1>
					<p class="ol-hero-sub"><?php echo nl2br( esc_html( $settings['subtitle'] ) ); ?></p>
					<div class="ol-hero-gods"><?php echo esc_html( $settings['gods_list'] ); ?></div>
				</div>
				<div class="ol-scroll-cue"><span><?php esc_html_e( 'Scroll', 'olympus-elementor' ); ?></span><div class="ol-scroll-cue-line"></div></div>
			</div>
		</section>
		<?php
	}
}
