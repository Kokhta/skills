<?php
if ( ! defined( 'ABSPATH' ) ) { return; }

class Elementor_Olympus_Myths_Widget extends \Elementor\Widget_Base {
	public function get_name() { return 'olympus_myths'; }
	public function get_title() { return esc_html__( 'Olympus Myths', 'olympus-widgets' ); }
	public function get_icon() { return 'eicon-image-before-after'; }
	public function get_categories() { return [ 'general' ]; }

	protected function register_controls() {
		$this->start_controls_section('header', ['label' => 'Header']);
		$this->add_control('label', ['label' => 'Label', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Sacred Tales']);
		$this->add_control('title', ['label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'The Great Myths']);
		$this->end_controls_section();

		$this->start_controls_section('myths_section', ['label' => 'Myths']);
		$repeater = new \Elementor\Repeater();
		$repeater->add_control('title', ['label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Myth Title']);
		$repeater->add_control('label', ['label' => 'Label', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Myth Label']);
		$repeater->add_control('body', ['label' => 'Body', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Myth description...']);
		$repeater->add_control('symbol', ['label' => 'Symbol', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '⚡']);
		$repeater->add_control('caption', ['label' => 'Caption', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Myth Caption']);
		$repeater->add_control('flip', ['label' => 'Flip Layout', 'type' => \Elementor\Controls_Manager::SWITCHER, 'default' => '']);
		$this->add_control('myths', ['label' => 'Myths', 'type' => \Elementor\Controls_Manager::REPEATER, 'fields' => $repeater->get_controls()]);
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<style>
			.ol-myths { background: var(--bg); padding: 8rem 4rem; transition: background var(--tt); }
			.ol-myth-pair { display: grid; grid-template-columns: 1fr 1fr; gap: 4.5rem; align-items: center; margin-top: 5rem; }
			.ol-myth-pair.flip .ol-myth-vis { order: 1; }
			.ol-myth-vis { aspect-ratio: 4/5; background: var(--bg-alt); border: 1px solid var(--border); position: relative; overflow: hidden; transition: background var(--tt), border-color var(--tt); }
			.ol-myth-vis-bg { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; font-size: 7rem; opacity: .12; }
			.ol-myth-vis-caption { position: absolute; bottom: 0; left: 0; right: 0; padding: 1.5rem; background: linear-gradient(to top, rgba(0,0,0,.55), transparent); font-family: 'Cinzel', serif; font-size: .58rem; letter-spacing: .42em; color: rgba(255,255,255,.7); }
			.ol-myth-title { font-family: 'Cinzel', serif; font-size: clamp(1.6rem, 3vw, 2.6rem); font-weight: 700; color: var(--text); margin-bottom: 1.3rem; line-height: 1.2; transition: color var(--tt); }
			.ol-myth-body { font-size: 1.05rem; font-weight: 300; color: var(--text-muted); line-height: 1.92; margin-bottom: 1.4rem; transition: color var(--tt); }
		</style>
		<section class="ol-myths">
			<div class="ol-sec-inner">
				<div class="ol-sec-label ol-reveal"><?php echo esc_html($settings['label']); ?></div>
				<h2 class="ol-sec-title ol-reveal"><?php echo esc_html($settings['title']); ?></h2>
				<?php foreach($settings['myths'] as $myth) : ?>
					<div class="ol-myth-pair <?php echo $myth['flip'] === 'yes' ? 'flip' : ''; ?>">
						<div class="ol-myth-vis ol-reveal">
							<div class="ol-myth-vis-bg"><?php echo esc_html($myth['symbol']); ?></div>
							<div class="ol-myth-vis-caption"><?php echo esc_html($myth['caption']); ?></div>
						</div>
						<div>
							<div class="ol-sec-label ol-reveal"><?php echo esc_html($myth['label']); ?></div>
							<h3 class="ol-myth-title ol-reveal"><?php echo esc_html($myth['title']); ?></h3>
							<p class="ol-myth-body ol-reveal"><?php echo nl2br(esc_html($myth['body'])); ?></p>
							<a href="#" class="myth-link ol-reveal">Read the Full Myth →</a>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</section>
		<?php
	}
}
