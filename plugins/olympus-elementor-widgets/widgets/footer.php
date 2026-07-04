<?php
if ( ! defined( 'ABSPATH' ) ) {
	return;
}

class Olympus_Footer_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'olympus_footer';
	}

	public function get_title() {
		return esc_html__( 'Olympus Footer', 'olympus-elementor' );
	}

	public function get_icon() {
		return 'eicon-footer';
	}

	public function get_categories() {
		return [ 'olympus' ];
	}

	protected function register_controls() {

		$this->start_controls_section( 'section_content', [ 'label' => 'Content' ] );
		$this->add_control( 'logo_text', [ 'label' => 'Logo Text', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'OLYMPUS' ] );
		$this->add_control( 'tagline', [ 'label' => 'Tagline', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'ΟΛΥΜΠΟΣ · Realm of the Eternal Gods' ] );
		$this->add_control( 'copyright', [ 'label' => 'Copyright', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '✦ MMXXVI · Where the Gods Dwell Eternal ✦' ] );

		$repeater = new \Elementor\Repeater();
		$repeater->add_control( 'link_text', [ 'label' => 'Text', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'The Gods' ] );
		$repeater->add_control( 'link_url', [ 'label' => 'URL', 'type' => \Elementor\Controls_Manager::URL, 'default' => [ 'url' => '#' ] ] );
		$this->add_control( 'links_list', [ 'label' => 'Links', 'type' => \Elementor\Controls_Manager::REPEATER, 'fields' => $repeater->get_controls(), 'title_field' => '{{{ link_text }}}' ] );
		$this->end_controls_section();

		$this->start_controls_section( 'section_style', [ 'label' => 'Style', 'tab' => \Elementor\Controls_Manager::TAB_STYLE ] );
		$this->add_control( 'accent_color', [ 'label' => 'Accent Color', 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#C9A227', 'selectors' => [ '{{WRAPPER}} .ol-foot-logo' => 'color: {{VALUE}}', '{{WRAPPER}} .ol-foot-nav a:hover' => 'color: {{VALUE}}' ] ] );
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<footer class="olympus-footer">
			<div class="ol-foot-top">
				<div>
					<div class="ol-foot-logo"><?php echo esc_html( $settings['logo_text'] ); ?></div>
					<div class="ol-foot-tagline"><?php echo esc_html( $settings['tagline'] ); ?></div>
				</div>
				<ul class="ol-foot-nav">
					<?php foreach ( $settings['links_list'] as $link ) : ?>
						<li><a href="<?php echo esc_url($link['link_url']['url']); ?>"><?php echo esc_html($link['link_text']); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>
			<div class="ol-foot-bottom">
				<div class="ol-foot-copy"><?php echo esc_html( $settings['copyright'] ); ?></div>
			</div>
		</footer>
		<?php
	}
}
