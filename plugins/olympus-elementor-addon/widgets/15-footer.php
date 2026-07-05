<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Olympus_15_Footer_Widget extends \Elementor\Widget_Base {

	public function get_name() { return '15-footer'; }
	public function get_title() { return esc_html__( '15. Olympus Footer', 'olympus-elementor-addon' ); }
	public function get_icon() { return 'eicon-footer'; }
	public function get_categories() { return [ 'general' ]; }

	protected function register_controls() {
		$this->start_controls_section('section_content', ['label' => esc_html__( 'Content', 'olympus-elementor-addon' ), 'tab' => \Elementor\Controls_Manager::TAB_CONTENT]);
		$this->add_control('logo', ['label' => 'Logo Text', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'OLYMPUS']);
		$this->add_control('tagline', ['label' => 'Tagline', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'ΟΛΥΜΠΟΣ · Realm of the Eternal Gods', 'label_block' => true]);
		$repeater = new \Elementor\Repeater();
		$repeater->add_control('link_text', ['label' => 'Text', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Link']);
		$repeater->add_control('link_url', ['label' => 'URL', 'type' => \Elementor\Controls_Manager::URL, 'default' => ['url' => '#']]);
		$this->add_control('nav_links', ['label' => 'Navigation Links', 'type' => \Elementor\Controls_Manager::REPEATER, 'fields' => $repeater->get_controls(), 'default' => [['link_text' => 'The Gods']], 'title_field' => '{{{ link_text }}}']);
		$this->add_control('copyright', ['label' => 'Copyright', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '✦ MMXXVI · Where the Gods Dwell Eternal ✦', 'label_block' => true]);
		$this->end_controls_section();
		olympus_add_theme_control($this);
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$theme_class = olympus_get_theme_class($settings);
		?>
		<footer class="ol-footer <?php echo esc_attr($theme_class); ?>">
			<div class="ol-foot-top">
				<div><div class="ol-foot-logo"><?php echo esc_html( $settings['logo'] ); ?></div><div class="ol-foot-tagline"><?php echo esc_html( $settings['tagline'] ); ?></div></div>
				<ul class="ol-foot-nav"><?php foreach ( $settings['nav_links'] as $link ) : ?><li><a href="<?php echo esc_url( $link['link_url']['url'] ); ?>"><?php echo esc_html( $link['link_text'] ); ?></a></li><?php endforeach; ?></ul>
			</div>
			<div class="ol-foot-bottom"><div class="ol-foot-copy"><?php echo esc_html( $settings['copyright'] ); ?></div></div>
		</footer>
		<?php
	}

	protected function content_template() {
		?>
		<# var themeClass = settings.widget_theme !== 'inherit' ? 'ol-theme-' + settings.widget_theme : ''; #>
		<footer class="ol-footer {{ themeClass }}">
			<div class="ol-foot-top">
				<div><div class="ol-foot-logo">{{{ settings.logo }}}</div><div class="ol-foot-tagline">{{{ settings.tagline }}}</div></div>
				<ul class="ol-foot-nav"><# _.each( settings.nav_links, function( link ) { #><li><a href="{{ link.link_url.url }}">{{{ link.link_text }}}</a></li><# } ); #></ul>
			</div>
			<div class="ol-foot-bottom"><div class="ol-foot-copy">{{{ settings.copyright }}}</div></div>
		</footer>
		<?php
	}
}
