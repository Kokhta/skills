<?php
if ( ! defined( 'ABSPATH' ) ) {
	return;
}

class Elementor_Olympus_Pantheon_Widget extends \Elementor\Widget_Base {

	public function get_name() { return 'olympus_pantheon'; }
	public function get_title() { return esc_html__( 'Olympus Pantheon', 'olympus-widgets' ); }
	public function get_icon() { return 'eicon-gallery-grid'; }
	public function get_categories() { return [ 'general' ]; }

	protected function register_controls() {
		$this->start_controls_section('header', ['label' => esc_html__( 'Header', 'olympus-widgets' )]);
		$this->add_control('label', ['label' => esc_html__( 'Label', 'olympus-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'The Twelve Olympians']);
		$this->add_control('title', ['label' => esc_html__( 'Title', 'olympus-widgets' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'The Divine Pantheon']);
		$this->add_control('desc', ['label' => esc_html__( 'Description', 'olympus-widgets' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Rulers of the cosmos, shaping the destiny of mortals from their eternal thrones atop sacred Mount Olympus.']);
		$this->end_controls_section();

		$this->start_controls_section('gods_section', ['label' => esc_html__( 'Gods', 'olympus-widgets' )]);
		$repeater = new \Elementor\Repeater();
		$repeater->add_control('name', ['label' => 'Name', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Zeus']);
		$repeater->add_control('realm', ['label' => 'Realm', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'King of the Gods']);
		$repeater->add_control('symbol', ['label' => 'Symbol', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '⚡']);
		$repeater->add_control('desc', ['label' => 'Description', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Lord of sky, thunder, and lightning.']);
		$repeater->add_control('num', ['label' => 'Roman Numeral', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'I']);
		$this->add_control('gods', ['label' => 'Gods', 'type' => \Elementor\Controls_Manager::REPEATER, 'fields' => $repeater->get_controls(), 'default' => [['name' => 'Zeus', 'realm' => 'King of the Gods', 'symbol' => '⚡', 'num' => 'I']]]);
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<style>
			.ol-pantheon { background: var(--bg-alt); padding: 8rem 4rem; transition: background var(--tt); }
			.ol-gods-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(270px, 1fr)); gap: 1.8rem; margin-top: 4.5rem; }
			.ol-god-card { background: var(--bg-card); border: 1px solid var(--border); padding: 2.4rem 2.2rem; position: relative; overflow: hidden; cursor: default; transition: background var(--tt), border-color var(--tt), transform .4s ease, box-shadow .4s ease; }
			.ol-god-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px; background: linear-gradient(to right, transparent, var(--gold), transparent); opacity: 0; transition: opacity .4s ease; }
			.ol-god-card:hover { transform: translateY(-5px); box-shadow: 0 20px 55px rgba(0,0,0,.08), 0 0 40px var(--gold-glow); }
			.ol-god-card:hover::before { opacity: 1; }
			.ol-god-sym { font-size: 2.4rem; display: block; margin-bottom: 1.3rem; }
			.ol-god-realm { font-family: 'Cinzel', serif; font-size: .58rem; letter-spacing: .5em; text-transform: uppercase; color: var(--gold); margin-bottom: .6rem; transition: color var(--tt); }
			.ol-god-name { font-family: 'Cinzel', serif; font-size: 1.75rem; font-weight: 700; color: var(--text); margin-bottom: .9rem; transition: color var(--tt); }
			.ol-god-desc { font-size: .98rem; font-weight: 300; font-style: italic; color: var(--text-muted); line-height: 1.82; transition: color var(--tt); }
			.ol-god-num { position: absolute; bottom: 1.2rem; right: 1.8rem; font-family: 'Cinzel', serif; font-size: 2.8rem; font-weight: 900; color: var(--gold-dim); line-height: 1; transition: color var(--tt); }
		</style>
		<section class="ol-pantheon">
			<div class="ol-sec-inner">
				<div class="ol-sec-label ol-reveal"><?php echo esc_html($settings['label']); ?></div>
				<h2 class="ol-sec-title ol-reveal"><?php echo esc_html($settings['title']); ?></h2>
				<p class="ol-sec-sub ol-reveal"><?php echo esc_html($settings['desc']); ?></p>
				<div class="ol-gods-grid">
					<?php foreach($settings['gods'] as $god) : ?>
						<div class="ol-god-card ol-reveal">
							<span class="ol-god-sym"><?php echo esc_html($god['symbol']); ?></span>
							<div class="ol-god-realm"><?php echo esc_html($god['realm']); ?></div>
							<div class="ol-god-name"><?php echo esc_html($god['name']); ?></div>
							<p class="ol-god-desc"><?php echo esc_html($god['desc']); ?></p>
							<div class="ol-god-num"><?php echo esc_html($god['num']); ?></div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
		<?php
	}
}
