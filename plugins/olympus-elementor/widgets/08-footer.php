<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

class Olympus_08_footer_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return '08-footer';
	}

	public function get_title() {
		return esc_html__( '08 Footer', 'olympus-elementor' );
	}

	public function get_icon() {
		return 'eicon-footer';
	}

	public function get_categories() {
		return [ 'olympus' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Content', 'olympus-elementor' ),
			]
		);

		$this->add_control(
			'logo_text',
			[
				'label' => esc_html__( 'Logo Text', 'olympus-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'OLYMPUS',
			]
		);

		$this->add_control(
			'tagline',
			[
				'label' => esc_html__( 'Tagline', 'olympus-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'ΟΛΥΜΠΟΣ · Realm of the Eternal Gods',
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'text',
			[
				'label' => esc_html__( 'Text', 'olympus-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'Link',
			]
		);

		$repeater->add_control(
			'url',
			[
				'label' => esc_html__( 'URL', 'olympus-elementor' ),
				'type' => \Elementor\Controls_Manager::URL,
			]
		);

		$this->add_control(
			'links',
			[
				'label' => esc_html__( 'Links', 'olympus-elementor' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[ 'text' => 'The Gods', 'url' => [ 'url' => '#pantheon' ] ],
					[ 'text' => 'Myths', 'url' => [ 'url' => '#myths' ] ],
					[ 'text' => 'Oracle', 'url' => [ 'url' => '#oracle' ] ],
				],
				'title_field' => '{{{ text }}}',
			]
		);

		$this->add_control(
			'copyright',
			[
				'label' => esc_html__( 'Copyright', 'olympus-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '✦ MMXXVI · Where the Gods Dwell Eternal ✦',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<footer class="site-body">
			<div class="foot-top">
				<div>
					<div class="foot-logo"><?php echo esc_html( $settings['logo_text'] ); ?></div>
					<div class="foot-tagline"><?php echo esc_html( $settings['tagline'] ); ?></div>
				</div>
				<ul class="foot-nav">
					<?php foreach ( $settings['links'] as $link ) : ?>
						<li>
							<a href="<?php echo esc_url( $link['url']['url'] ); ?>">
								<?php echo esc_html( $link['text'] ); ?>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
			<div class="foot-bottom">
				<div class="foot-copy"><?php echo esc_html( $settings['copyright'] ); ?></div>
			</div>
		</footer>
		<?php
	}
}
