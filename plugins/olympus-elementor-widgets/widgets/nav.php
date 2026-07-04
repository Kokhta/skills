<?php
if ( ! defined( 'ABSPATH' ) ) {
	return;
}

class Olympus_Nav_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'olympus_nav';
	}

	public function get_title() {
		return esc_html__( 'Olympus Header Nav', 'olympus-elementor' );
	}

	public function get_icon() {
		return 'eicon-nav-menu';
	}

	public function get_categories() {
		return [ 'olympus' ];
	}

	protected function register_controls() {
		$this->start_controls_section( 'section_content', [ 'label' => 'Content' ] );
		$this->add_control( 'logo_text', [ 'label' => 'Logo Text', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'OLYMPUS' ] );

		$repeater = new \Elementor\Repeater();
		$repeater->add_control( 'link_text', [ 'label' => 'Text', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'The Gods' ] );
		$repeater->add_control( 'link_url', [ 'label' => 'URL', 'type' => \Elementor\Controls_Manager::URL, 'default' => [ 'url' => '#' ] ] );
		$this->add_control( 'links_list', [ 'label' => 'Links', 'type' => \Elementor\Controls_Manager::REPEATER, 'fields' => $repeater->get_controls(), 'title_field' => '{{{ link_text }}}' ] );
		$this->end_controls_section();

		$this->start_controls_section( 'section_style', [ 'label' => 'Style', 'tab' => \Elementor\Controls_Manager::TAB_STYLE ] );
		$this->add_control( 'accent_color', [ 'label' => 'Accent Color', 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#C9A227', 'selectors' => [ '{{WRAPPER}} .ol-nav-logo' => 'color: {{VALUE}}', '{{WRAPPER}} .ol-nav-links a:hover' => 'color: {{VALUE}}', '{{WRAPPER}} .ol-nav-links a::after' => 'background: {{VALUE}}' ] ] );
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<nav class="olympus-nav" id="olympus-nav">
			<a href="#" class="ol-nav-logo"><?php echo esc_html( $settings['logo_text'] ); ?></a>
			<ul class="ol-nav-links">
				<?php foreach ( $settings['links_list'] as $link ) : ?>
					<li><a href="<?php echo esc_url($link['link_url']['url']); ?>"><?php echo esc_html($link['link_text']); ?></a></li>
				<?php endforeach; ?>
			</ul>
		</nav>
		<?php
	}
}
