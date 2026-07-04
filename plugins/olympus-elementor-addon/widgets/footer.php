<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Olympus_Footer_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'olympus-footer';
	}

	public function get_title() {
		return esc_html__( 'Olympus Footer', 'olympus-elementor-addon' );
	}

	public function get_icon() {
		return 'eicon-footer';
	}

	public function get_categories() {
		return [ 'general' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Content', 'olympus-elementor-addon' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'logo',
			[
				'label' => esc_html__( 'Logo Text', 'olympus-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'OLYMPUS', 'olympus-elementor-addon' ),
			]
		);

		$this->add_control(
			'tagline',
			[
				'label' => esc_html__( 'Tagline', 'olympus-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'ΟΛΥΜΠΟΣ · Realm of the Eternal Gods', 'olympus-elementor-addon' ),
				'label_block' => true,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'link_text',
			[
				'label' => esc_html__( 'Text', 'olympus-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Link', 'olympus-elementor-addon' ),
			]
		);

		$repeater->add_control(
			'link_url',
			[
				'label' => esc_html__( 'URL', 'olympus-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::URL,
				'default' => [
					'url' => '#',
				],
			]
		);

		$this->add_control(
			'nav_links',
			[
				'label' => esc_html__( 'Navigation Links', 'olympus-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[ 'link_text' => esc_html__( 'The Gods', 'olympus-elementor-addon' ) ],
					[ 'link_text' => esc_html__( 'Myths', 'olympus-elementor-addon' ) ],
					[ 'link_text' => esc_html__( 'Oracle', 'olympus-elementor-addon' ) ],
					[ 'link_text' => esc_html__( 'Chronicles', 'olympus-elementor-addon' ) ],
				],
				'title_field' => '{{{ link_text }}}',
			]
		);

		$this->add_control(
			'copyright',
			[
				'label' => esc_html__( 'Copyright', 'olympus-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( '✦ MMXXVI · Where the Gods Dwell Eternal ✦', 'olympus-elementor-addon' ),
				'label_block' => true,
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<footer class="ol-footer">
			<div class="ol-foot-top">
				<div>
					<div class="ol-foot-logo"><?php echo esc_html( $settings['logo'] ); ?></div>
					<div class="ol-foot-tagline"><?php echo esc_html( $settings['tagline'] ); ?></div>
				</div>
				<ul class="ol-foot-nav">
					<?php foreach ( $settings['nav_links'] as $link ) : ?>
						<li><a href="<?php echo esc_url( $link['link_url']['url'] ); ?>"><?php echo esc_html( $link['link_text'] ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>
			<div class="ol-foot-bottom">
				<div class="ol-foot-copy"><?php echo esc_html( $settings['copyright'] ); ?></div>
			</div>
		</footer>
		<?php
	}

	protected function content_template() {
		?>
		<footer class="ol-footer">
			<div class="ol-foot-top">
				<div>
					<div class="ol-foot-logo">{{{ settings.logo }}}</div>
					<div class="ol-foot-tagline">{{{ settings.tagline }}}</div>
				</div>
				<ul class="ol-foot-nav">
					<# _.each( settings.nav_links, function( link ) { #>
						<li><a href="{{ link.link_url.url }}">{{{ link.link_text }}}</a></li>
					<# } ); #>
				</ul>
			</div>
			<div class="ol-foot-bottom">
				<div class="ol-foot-copy">{{{ settings.copyright }}}</div>
			</div>
		</footer>
		<?php
	}
}
