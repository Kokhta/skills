<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Olympus_06_Pantheon_Widget extends \Elementor\Widget_Base {

	public function get_name() { return '06-pantheon'; }
	public function get_title() { return esc_html__( '06. Olympus Pantheon', 'olympus-elementor-addon' ); }
	public function get_icon() { return 'eicon-gallery-grid'; }
	public function get_categories() { return [ 'general' ]; }
	public function get_script_depends() { return [ 'olympus-scripts' ]; }

	protected function register_controls() {
		$this->start_controls_section('section_header', ['label' => esc_html__( 'Header', 'olympus-elementor-addon' ), 'tab' => \Elementor\Controls_Manager::TAB_CONTENT]);
		$this->add_control('label', ['label' => esc_html__( 'Label', 'olympus-elementor-addon' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => esc_html__( 'The Twelve Olympians', 'olympus-elementor-addon' )]);
		$this->add_control('title', ['label' => esc_html__( 'Title', 'olympus-elementor-addon' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => esc_html__( 'The Divine Pantheon', 'olympus-elementor-addon' )]);
		$this->add_control('subtitle', ['label' => esc_html__( 'Subtitle', 'olympus-elementor-addon' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => esc_html__( 'Rulers of the cosmos, shaping the destiny of mortals from their eternal thrones atop sacred Mount Olympus.', 'olympus-elementor-addon' )]);
		$this->end_controls_section();

		$this->start_controls_section('section_gods', ['label' => esc_html__( 'Gods Grid', 'olympus-elementor-addon' ), 'tab' => \Elementor\Controls_Manager::TAB_CONTENT]);
		$repeater = new \Elementor\Repeater();
		$repeater->add_control('god_sym', ['label' => esc_html__( 'Symbol', 'olympus-elementor-addon' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '⚡']);
		$repeater->add_control('god_realm', ['label' => esc_html__( 'Realm', 'olympus-elementor-addon' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => esc_html__( 'King of the Gods', 'olympus-elementor-addon' )]);
		$repeater->add_control('god_name', ['label' => esc_html__( 'Name', 'olympus-elementor-addon' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => esc_html__( 'Zeus', 'olympus-elementor-addon' )]);
		$repeater->add_control('god_desc', ['label' => esc_html__( 'Description', 'olympus-elementor-addon' ), 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => esc_html__( 'Lord of sky, thunder, and lightning. Father of gods and men, wielder of the thunderbolt, supreme ruler of Olympus.', 'olympus-elementor-addon' )]);
		$repeater->add_control('god_num', ['label' => esc_html__( 'Number (Roman)', 'olympus-elementor-addon' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'I']);
		$this->add_control('gods', ['label' => esc_html__( 'God Cards', 'olympus-elementor-addon' ), 'type' => \Elementor\Controls_Manager::REPEATER, 'fields' => $repeater->get_controls(), 'default' => [['god_sym' => '⚡', 'god_realm' => 'King of the Gods', 'god_name' => 'Zeus', 'god_num' => 'I']], 'title_field' => '{{{ god_name }}}']);
		$this->end_controls_section();
		olympus_add_theme_control($this);
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$theme_class = olympus_get_theme_class($settings);
		?>
		<section class="ol-sec ol-pantheon <?php echo esc_attr($theme_class); ?>" id="pantheon">
			<div class="ol-sec-inner">
				<div class="ol-sec-label ol-reveal"><?php echo esc_html( $settings['label'] ); ?></div>
				<h2 class="ol-sec-title ol-reveal"><?php echo esc_html( $settings['title'] ); ?></h2>
				<p class="ol-sec-sub ol-reveal"><?php echo esc_html( $settings['subtitle'] ); ?></p>
				<div class="ol-gods-grid">
					<?php foreach ( $settings['gods'] as $god ) : ?>
						<div class="ol-god-card ol-reveal">
							<span class="ol-god-sym"><?php echo esc_html( $god['god_sym'] ); ?></span>
							<div class="ol-god-realm"><?php echo esc_html( $god['god_realm'] ); ?></div>
							<div class="ol-god-name"><?php echo esc_html( $god['god_name'] ); ?></div>
							<p class="ol-god-desc"><?php echo esc_html( $god['god_desc'] ); ?></p>
							<div class="ol-god-num"><?php echo esc_html( $god['god_num'] ); ?></div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
		<?php
	}

	protected function content_template() {
		?>
		<# var themeClass = settings.widget_theme !== 'inherit' ? 'ol-theme-' + settings.widget_theme : ''; #>
		<section class="ol-sec ol-pantheon {{ themeClass }}">
			<div class="ol-sec-inner">
				<div class="ol-sec-label ol-reveal">{{{ settings.label }}}</div>
				<h2 class="ol-sec-title ol-reveal">{{{ settings.title }}}</h2>
				<p class="ol-sec-sub ol-reveal">{{{ settings.subtitle }}}</p>
				<div class="ol-gods-grid">
					<# _.each( settings.gods, function( god ) { #>
						<div class="ol-god-card ol-reveal">
							<span class="ol-god-sym">{{{ god.god_sym }}}</span>
							<div class="ol-god-realm">{{{ god.god_realm }}}</div>
							<div class="ol-god-name">{{{ god.god_name }}}</div>
							<p class="ol-god-desc">{{{ god.god_desc }}}</p>
							<div class="ol-god-num">{{{ god.god_num }}}</div>
						</div>
					<# } ); #>
				</div>
			</div>
		</section>
		<?php
	}
}
