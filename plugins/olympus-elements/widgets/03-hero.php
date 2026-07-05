<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Modules\NestedElements\Base\Widget_Nested_Base;

class Olympus_03_Hero_Widget extends Widget_Nested_Base {

	public function get_name() {
		return 'olympus-hero';
	}

	public function get_title() {
		return esc_html__( '03-Hero', 'olympus-elements' );
	}

	public function get_icon() {
		return 'eicon-image-hotspot';
	}

	public function get_categories() {
		return [ 'olympus' ];
	}

	protected function get_default_children_config() {
		return [];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Content', 'olympus-elements' ),
			]
		);

		$this->add_control(
			'video',
			[
				'label' => esc_html__( 'Hero Video', 'olympus-elements' ),
				'type' => Controls_Manager::MEDIA,
				'media_types' => [ 'video' ],
			]
		);

		$this->add_control(
			'eyebrow',
			[
				'label' => esc_html__( 'Eyebrow Text', 'olympus-elements' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Ἐν ἀρχῇ ἦν τὸ Χάος', 'olympus-elements' ),
			]
		);

		$this->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'olympus-elements' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'OLYMPUS', 'olympus-elements' ),
			]
		);

		$this->add_control(
			'title_greek',
			[
				'label' => esc_html__( 'Greek Title', 'olympus-elements' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'ΟΛΥΜΠΟΣ', 'olympus-elements' ),
			]
		);

		$this->add_control(
			'subtitle',
			[
				'label' => esc_html__( 'Subtitle', 'olympus-elements' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => esc_html__( "Where thunder meets the stars, and mortals kneel\nbefore the eternal throne of the divine", 'olympus-elements' ),
			]
		);

		$this->add_control(
			'gods_text',
			[
				'label' => esc_html__( 'Gods List', 'olympus-elements' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Ζεύς · Ποσειδῶν · Ἅιδης · Ἀθηνᾶ · Ἀπόλλων · Ἄρης', 'olympus-elements' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_overlay',
			[
				'label' => esc_html__( 'Overlay & Layout', 'olympus-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'overlay_bg',
			[
				'label' => esc_html__( 'Overlay Gradient', 'olympus-elements' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => 'linear-gradient(to bottom, rgba(3,3,10,.55) 0%, rgba(3,3,10,.15) 35%, rgba(3,3,10,.25) 65%, rgba(3,3,10,.75) 100%)',
				'selectors' => [
					'{{WRAPPER}} .ol-hero-overlay' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'corner_color',
			[
				'label' => esc_html__( 'Corner Brackets Color', 'olympus-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#C9A227',
				'selectors' => [
					'{{WRAPPER}} .ol-corner' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_typography',
			[
				'label' => esc_html__( 'Typography', 'olympus-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'eyebrow_typography',
				'label' => esc_html__( 'Eyebrow', 'olympus-elements' ),
				'selector' => '{{WRAPPER}} .hero-eyebrow',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => esc_html__( 'Title', 'olympus-elements' ),
				'selector' => '{{WRAPPER}} .hero-title',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'subtitle_typography',
				'label' => esc_html__( 'Subtitle', 'olympus-elements' ),
				'selector' => '{{WRAPPER}} .hero-sub',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$video_url = $settings['video']['url'];
		?>
		<section class="ol-hero-wrap" id="hero">
			<div class="ol-hero-sticky">
				<video id="hero-video" class="ol-hero-video" preload="auto" muted playsinline webkit-playsinline src="<?php echo esc_url($video_url); ?>"></video>

				<div class="ol-hero-overlay"></div>
				<div class="ol-hero-grain"></div>
				<div class="hero-rule"></div>

				<div class="ol-corner tl"></div>
				<div class="ol-corner tr"></div>
				<div class="ol-corner bl"></div>
				<div class="ol-corner br"></div>

				<div class="ol-hero-content" id="hero-content">
					<div class="hero-eyebrow"><?php echo esc_html($settings['eyebrow']); ?></div>
					<div class="hero-gem">
						<div class="hero-gem-line"></div>
						<div class="hero-gem-dot">✦</div>
						<div class="hero-gem-line"></div>
					</div>
					<h1 class="hero-title">
						<?php echo esc_html($settings['title']); ?>
						<span class="hero-title-greek"><?php echo esc_html($settings['title_greek']); ?></span>
					</h1>
					<p class="hero-sub">
						<?php echo nl2br(esc_html($settings['subtitle'])); ?>
					</p>
					<div class="hero-gods"><?php echo esc_html($settings['gods_text']); ?></div>
				</div>

				<div class="scroll-cue" id="scroll-cue">
					<span>Scroll</span>
					<div class="scroll-cue-line"></div>
				</div>
			</div>
		</section>
		<div class="ol-nested-container">
			<?php $this->print_child_elements(); ?>
		</div>
		<?php
	}

	protected function content_template() {
		?>
		<section class="ol-hero-wrap">
			<div class="ol-hero-sticky">
				<video id="hero-video" class="ol-hero-video" src="{{{ settings.video.url }}}"></video>
				<div class="ol-hero-overlay"></div>
				<div class="ol-hero-content">
					<div class="hero-eyebrow">{{{ settings.eyebrow }}}</div>
					<h1 class="hero-title">
						{{{ settings.title }}}
						<span class="hero-title-greek">{{{ settings.title_greek }}}</span>
					</h1>
					<p class="hero-sub">{{{ settings.subtitle }}}</p>
				</div>
			</div>
		</section>
		<div class="ol-nested-container">
			{{{ view.getEditModel().get( 'elements' ).models }}}
		</div>
		<?php
	}
}
