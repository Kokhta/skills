<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

class Olympus_Hero_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'olympus-hero';
	}

	public function get_title() {
		return esc_html__( '1-Hero', 'olympus-elementor-widgets' );
	}

	public function get_icon() {
		return 'eicon-header';
	}

	public function get_categories() {
		return [ 'general' ];
	}

	public function get_keywords() {
		return [ 'olympus', 'hero', 'video', 'scroll' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'olympus-elementor-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'video_url',
			[
				'label' => esc_html__( 'Video URL', 'olympus-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
			]
		);

		$this->add_control(
			'eyebrow',
			[
				'label' => esc_html__( 'Eyebrow Text', 'olympus-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'Ἐν ἀρχῇ ἦν τὸ Χάος',
			]
		);

		$this->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'olympus-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'OLYMPUS',
			]
		);

		$this->add_control(
			'title_greek',
			[
				'label' => esc_html__( 'Greek Title', 'olympus-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'ΟΛΥΜΠΟΣ',
			]
		);

		$this->add_control(
			'subtext',
			[
				'label' => esc_html__( 'Subtext', 'olympus-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => 'Where thunder meets the stars, and mortals kneel before the eternal throne of the divine',
			]
		);

		$this->add_control(
			'gods_list',
			[
				'label' => esc_html__( 'Gods List', 'olympus-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'Ζεύς · Ποσειδῶν · Ἅιδης · Ἀθηνᾶ · Ἀπόλλων · Ἄρης',
			]
		);

		$this->add_control(
			'scroll_text',
			[
				'label' => esc_html__( 'Scroll Cue Text', 'olympus-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'Scroll',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'style_section',
			[
				'label' => esc_html__( 'Style', 'olympus-elementor-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'gold_color',
			[
				'label' => esc_html__( 'Gold Color', 'olympus-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#C9A227',
				'selectors' => [
					'{{WRAPPER}} .hero-eyebrow' => 'color: {{VALUE}};',
					'{{WRAPPER}} .hero-gem-dot' => 'color: {{VALUE}};',
					'{{WRAPPER}} .hero-title-greek' => 'color: {{VALUE}};',
					'{{WRAPPER}} .scroll-cue-line' => 'background: linear-gradient(to bottom, {{VALUE}}, transparent);',
					'{{WRAPPER}} .corner' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<section class="hero-wrap">
			<div class="hero-sticky">
				<video id="hero-video" class="hero-video" preload="auto" muted playsinline webkit-playsinline src="<?php echo esc_url($settings['video_url']); ?>"></video>

				<div class="hero-overlay"></div>
				<div class="hero-grain"></div>
				<div class="hero-rule"></div>

				<div class="corner tl"></div>
				<div class="corner tr"></div>
				<div class="corner bl"></div>
				<div class="corner br"></div>

				<div class="hero-content" id="hero-content">
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
					<p class="hero-sub"><?php echo nl2br(esc_html($settings['subtext'])); ?></p>
					<div class="hero-gods"><?php echo esc_html($settings['gods_list']); ?></div>
				</div>

				<div class="scroll-cue" id="scroll-cue">
					<span><?php echo esc_html($settings['scroll_text']); ?></span>
					<div class="scroll-cue-line"></div>
				</div>
			</div>
		</section>
		<?php
	}
}
