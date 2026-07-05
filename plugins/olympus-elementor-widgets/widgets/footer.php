<?php
if ( ! defined( 'ABSPATH' ) ) { return; }

class Elementor_Olympus_Footer_Widget extends \Elementor\Widget_Base {
	public function get_name() { return 'olympus_footer'; }
	public function get_title() { return esc_html__( 'Olympus Footer', 'olympus-widgets' ); }
	public function get_icon() { return 'eicon-footer'; }
	public function get_categories() { return [ 'general' ]; }

	protected function register_controls() {
		$this->start_controls_section('content', ['label' => 'Content']);
		$this->add_control('logo', ['label' => 'Logo Text', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'OLYMPUS']);
		$this->add_control('tagline', ['label' => 'Tagline', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'ΟΛΥΜΠΟΣ · Realm of the Eternal Gods']);
		$this->add_control('copy', ['label' => 'Copyright', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '✦ MMXXVI · Where the Gods Dwell Eternal ✦']);
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<style>
			.ol-footer { background: var(--bg-alt); border-top: 1px solid var(--border); transition: background var(--tt), border-color var(--tt); }
			.ol-foot-top { max-width: 1320px; margin: 0 auto; padding: 4rem 4rem 3rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 2rem; }
			.ol-foot-logo { font-family: 'Cinzel Decorative', serif; font-size: 1.4rem; font-weight: 900; color: var(--gold); transition: color var(--tt); }
			.ol-foot-tagline { font-family: 'Cinzel', serif; font-size: .58rem; letter-spacing: .48em; color: var(--text-muted); margin-top: .4rem; text-transform: uppercase; transition: color var(--tt); }
			.ol-foot-bottom { border-top: 1px solid var(--border); padding: 1.6rem 4rem; text-align: center; transition: border-color var(--tt); }
			.ol-foot-copy { font-family: 'Cinzel', serif; font-size: .58rem; letter-spacing: .32em; color: var(--text-faint); text-transform: uppercase; transition: color var(--tt); }
		</style>
		<footer class="ol-footer">
			<div class="ol-foot-top">
				<div>
					<div class="ol-foot-logo"><?php echo esc_html($settings['logo']); ?></div>
					<div class="ol-foot-tagline"><?php echo esc_html($settings['tagline']); ?></div>
				</div>
			</div>
			<div class="ol-foot-bottom">
				<div class="ol-foot-copy"><?php echo esc_html($settings['copy']); ?></div>
			</div>
		</footer>
		<?php
	}
}
