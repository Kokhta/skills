<?php
if ( ! defined( 'ABSPATH' ) ) { return; }

class Elementor_Olympus_Chronicles_Widget extends \Elementor\Widget_Base {
	public function get_name() { return 'olympus_chronicles'; }
	public function get_title() { return esc_html__( 'Olympus Chronicles', 'olympus-widgets' ); }
	public function get_icon() { return 'eicon-time-line'; }
	public function get_categories() { return [ 'general' ]; }

	protected function register_controls() {
		$this->start_controls_section('header', ['label' => 'Header']);
		$this->add_control('title', ['label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Chronicles of Olympus']);
		$this->end_controls_section();

		$this->start_controls_section('timeline', ['label' => 'Timeline']);
		$repeater = new \Elementor\Repeater();
		$repeater->add_control('date', ['label' => 'Date', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'The First Age']);
		$repeater->add_control('event', ['label' => 'Event', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Rise of the Titans']);
		$repeater->add_control('desc', ['label' => 'Description', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Description...']);
		$repeater->add_control('side', ['label' => 'Side', 'type' => \Elementor\Controls_Manager::SELECT, 'options' => ['left' => 'Left', 'right' => 'Right'], 'default' => 'right']);
		$this->add_control('items', ['label' => 'Items', 'type' => \Elementor\Controls_Manager::REPEATER, 'fields' => $repeater->get_controls()]);
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<style>
			.ol-chronicles { background: var(--bg); padding: 8rem 4rem; transition: background var(--tt); }
			.ol-timeline { margin-top: 5rem; position: relative; max-width: 820px; margin-left: auto; margin-right: auto; }
			.ol-timeline::before { content: ''; position: absolute; left: 50%; top: 0; bottom: 0; width: 1px; background: linear-gradient(to bottom, transparent, var(--gold-dim), transparent); transition: background var(--tt); }
			.ol-tl-item { display: grid; grid-template-columns: 1fr 52px 1fr; margin-bottom: 3.8rem; align-items: flex-start; }
			.ol-tl-left { text-align: right; padding-right: 2.8rem; }
			.ol-tl-right { padding-left: 2.8rem; }
			.ol-tl-dot { width: 10px; height: 10px; background: var(--gold); border-radius: 50%; margin: .5rem auto 0; box-shadow: 0 0 18px var(--gold-dim); transition: background var(--tt), box-shadow var(--tt); }
			.ol-tl-event { font-family: 'Cinzel', serif; font-size: 1.05rem; font-weight: 600; color: var(--text); margin-bottom: .65rem; transition: color var(--tt); }
			.ol-tl-desc { font-size: .97rem; font-weight: 300; font-style: italic; color: var(--text-muted); line-height: 1.8; transition: color var(--tt); }
		</style>
		<section class="ol-chronicles">
			<div class="ol-sec-inner">
				<h2 class="ol-sec-title ol-reveal" style="text-align: center;"><?php echo esc_html($settings['title']); ?></h2>
				<div class="ol-timeline">
					<?php foreach($settings['items'] as $item) : ?>
						<div class="ol-tl-item">
							<div class="ol-tl-left">
								<?php if($item['side'] === 'left') : ?>
									<div class="ol-sec-label ol-reveal"><?php echo esc_html($item['date']); ?></div>
									<div class="ol-tl-event ol-reveal"><?php echo esc_html($item['event']); ?></div>
									<p class="ol-tl-desc ol-reveal"><?php echo esc_html($item['desc']); ?></p>
								<?php endif; ?>
							</div>
							<div class="ol-tl-dot ol-reveal"></div>
							<div class="ol-tl-right">
								<?php if($item['side'] === 'right') : ?>
									<div class="ol-sec-label ol-reveal"><?php echo esc_html($item['date']); ?></div>
									<div class="ol-tl-event ol-reveal"><?php echo esc_html($item['event']); ?></div>
									<p class="ol-tl-desc ol-reveal"><?php echo esc_html($item['desc']); ?></p>
								<?php endif; ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
		<?php
	}
}
