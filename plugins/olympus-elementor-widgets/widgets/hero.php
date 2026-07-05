<?php
if ( ! defined( 'ABSPATH' ) ) {
	return;
}

class Elementor_Olympus_Hero_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'olympus_hero';
	}

	public function get_title() {
		return esc_html__( 'Olympus Hero', 'olympus-widgets' );
	}

	public function get_icon() {
		return 'eicon-animated-headline';
	}

	public function get_categories() {
		return [ 'general' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'olympus-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'olympus-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'OLYMPUS', 'olympus-widgets' ),
			]
		);

		$this->add_control(
			'title_greek',
			[
				'label' => esc_html__( 'Greek Title', 'olympus-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'ΟΛΥΜΠΟΣ', 'olympus-widgets' ),
			]
		);

		$this->add_control(
			'eyebrow',
			[
				'label' => esc_html__( 'Eyebrow', 'olympus-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Ἐν ἀρχῇ ἦν τὸ Χάος', 'olympus-widgets' ),
			]
		);

		$this->add_control(
			'subtitle',
			[
				'label' => esc_html__( 'Subtitle', 'olympus-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Where thunder meets the stars, and mortals kneel before the eternal throne of the divine', 'olympus-widgets' ),
			]
		);

		$this->add_control(
			'gods_list',
			[
				'label' => esc_html__( 'Gods List', 'olympus-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Ζεύς · Ποσειδῶν · Ἅιδης · Ἀθηνᾶ · Ἀπόλλων · Ἄρης', 'olympus-widgets' ),
			]
		);

		$this->add_control(
			'video_url',
			[
				'label' => esc_html__( 'Video URL', 'olympus-widgets' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'media_type' => 'video',
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$video_url = ! empty( $settings['video_url']['url'] ) ? $settings['video_url']['url'] : '';
		?>
		<style>
			.ol-hero-wrap { height: 420vh; position: relative; }
			.ol-hero-sticky { position: sticky; top: 0; height: 100vh; width: 100%; overflow: hidden; background: #050510; }
			.ol-hero-video { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; will-change: transform; transform-origin: center center; }
			.ol-hero-overlay { position: absolute; inset: 0; z-index: 1; background: linear-gradient(to bottom, rgba(3,3,10,.55) 0%, rgba(3,3,10,.15) 35%, rgba(3,3,10,.25) 65%, rgba(3,3,10,.75) 100%); }
			.ol-hero-grain { position: absolute; inset: 0; z-index: 2; pointer-events: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='300'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.8' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='.04'/%3E%3C/svg%3E"); background-size: 250px; opacity: .55; }
			.ol-corner { position: absolute; z-index: 4; width: 52px; height: 52px; opacity: .55; }
			.ol-corner.tl { top: 1.6rem; left: 2rem; border-top: 1px solid var(--gold); border-left: 1px solid var(--gold); }
			.ol-corner.tr { top: 1.6rem; right: 2rem; border-top: 1px solid var(--gold); border-right: 1px solid var(--gold); }
			.ol-corner.bl { bottom: 5rem; left: 2rem; border-bottom: 1px solid var(--gold); border-left: 1px solid var(--gold); }
			.ol-corner.br { bottom: 5rem; right: 2rem; border-bottom: 1px solid var(--gold); border-right: 1px solid var(--gold); }
			.ol-hero-rule { position: absolute; z-index: 4; left: 50%; top: 1.4rem; transform: translateX(-50%); width: min(560px, 85vw); height: 1px; background: linear-gradient(to right, transparent, var(--gold-dim), transparent); }
			.ol-hero-content { position: absolute; inset: 0; z-index: 5; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; padding: 2rem; will-change: transform, opacity; }
			.ol-hero-eyebrow { font-family: 'Cinzel', serif; font-size: clamp(.6rem, 1.2vw, .75rem); letter-spacing: .55em; text-transform: uppercase; color: var(--gold); opacity: .9; margin-bottom: 1.8rem; }
			.ol-hero-gem { display: flex; align-items: center; gap: 1rem; width: min(380px, 80vw); margin-bottom: 1.6rem; }
			.ol-hero-gem-line { flex: 1; height: 1px; background: linear-gradient(to right, transparent, var(--gold-dim), transparent); }
			.ol-hero-gem-dot { color: var(--gold); font-size: .8rem; }
			.ol-hero-title { font-family: 'Cinzel Decorative', serif; font-size: clamp(3.2rem, 10vw, 9.5rem); font-weight: 900; line-height: .95; letter-spacing: .08em; color: #FFFFFF; text-shadow: 0 0 80px rgba(212,175,55,.35), 0 4px 35px rgba(0,0,0,.55); margin-bottom: 1.2rem; }
			.ol-hero-title-greek { display: block; font-size: clamp(1.1rem, 3vw, 2.8rem); color: var(--gold); letter-spacing: .22em; opacity: .85; margin-top: .4rem; }
			.ol-hero-sub { font-family: 'Cormorant Garamond', serif; font-size: clamp(1rem, 2.2vw, 1.45rem); font-weight: 300; font-style: italic; color: rgba(255,255,255,.78); letter-spacing: .08em; margin: 1.4rem 0 1.2rem; max-width: 540px; line-height: 1.65; }
			.ol-hero-gods { font-family: 'Cinzel', serif; font-size: clamp(.55rem, 1.1vw, .72rem); letter-spacing: .38em; color: rgba(212,175,55,.6); }
			.ol-scroll-cue { position: absolute; bottom: 2.8rem; left: 50%; transform: translateX(-50%); z-index: 5; display: flex; flex-direction: column; align-items: center; gap: .45rem; color: rgba(255,255,255,.5); }
			.ol-scroll-cue span { font-family: 'Cinzel', serif; font-size: .58rem; letter-spacing: .44em; text-transform: uppercase; }
			.ol-scroll-cue-line { width: 1px; height: 46px; background: linear-gradient(to bottom, var(--gold), transparent); animation: ol-pulse-line 2.2s ease-in-out infinite; }
			@keyframes ol-pulse-line { 0%,100% { opacity: .35; transform: scaleY(1); } 50% { opacity: .95; transform: scaleY(1.08); } }
		</style>
		<section class="ol-hero-wrap">
			<div class="ol-hero-sticky">
				<?php if ( $video_url ) : ?>
					<video id="hero-video" class="ol-hero-video" src="<?php echo esc_url( $video_url ); ?>" preload="auto" muted playsinline webkit-playsinline></video>
				<?php endif; ?>

				<div class="ol-hero-overlay"></div>
				<div class="ol-hero-grain"></div>
				<div class="ol-hero-rule"></div>

				<div class="ol-corner tl"></div>
				<div class="ol-corner tr"></div>
				<div class="ol-corner bl"></div>
				<div class="ol-corner br"></div>

				<div class="ol-hero-content" id="hero-content">
					<div class="ol-hero-eyebrow"><?php echo esc_html( $settings['eyebrow'] ); ?></div>
					<div class="ol-hero-gem">
						<div class="ol-hero-gem-line"></div>
						<div class="ol-hero-gem-dot">✦</div>
						<div class="ol-hero-gem-line"></div>
					</div>
					<h1 class="ol-hero-title">
						<?php echo esc_html( $settings['title'] ); ?>
						<span class="ol-hero-title-greek"><?php echo esc_html( $settings['title_greek'] ); ?></span>
					</h1>
					<p class="ol-hero-sub"><?php echo nl2br( esc_html( $settings['subtitle'] ) ); ?></p>
					<div class="ol-hero-gods"><?php echo esc_html( $settings['gods_list'] ); ?></div>
				</div>

				<div class="ol-scroll-cue" id="scroll-cue">
					<span><?php esc_html_e( 'Scroll', 'olympus-widgets' ); ?></span>
					<div class="ol-scroll-cue-line"></div>
				</div>
			</div>
		</section>
		<script>
		(function($){
			$(window).on('load', function(){
				const vid = document.getElementById('hero-video');
				if(!vid) return;

				function setupScrub() {
					if (!vid.duration) return;
					ScrollTrigger.create({
						trigger: '.ol-hero-wrap',
						start: 'top top',
						end: 'bottom bottom',
						scrub: 0.25,
						onUpdate(self) {
							if (vid.readyState >= 2) {
								vid.currentTime = vid.duration * self.progress;
							}
						}
					});
				}
				vid.addEventListener('loadedmetadata', setupScrub);
				if (vid.readyState >= 1) setupScrub();

				gsap.to('#hero-content', {
					yPercent: -28, opacity: 0, ease: 'none',
					scrollTrigger: { trigger: '.ol-hero-wrap', start: 'top top', end: '28% top', scrub: true }
				});

				gsap.fromTo('.ol-hero-video', { scale: 1 }, {
					scale: 1.07, ease: 'none',
					scrollTrigger: { trigger: '.ol-hero-wrap', start: 'top top', end: 'bottom bottom', scrub: true }
				});
			});
		})(jQuery);
		</script>
		<?php
	}

}
