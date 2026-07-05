<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

class Olympus_04_pantheon_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return '04-pantheon';
	}

	public function get_title() {
		return esc_html__( '04 Pantheon', 'olympus-elementor' );
	}

	public function get_icon() {
		return 'eicon-gallery-grid';
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
			'title',
			[
				'label' => esc_html__( 'Title', 'olympus-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'The Divine Pantheon', 'olympus-elementor' ),
			]
		);

		$this->add_control(
			'subtitle',
			[
				'label' => esc_html__( 'Subtitle', 'olympus-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Rulers of the cosmos, shaping the destiny of mortals from their eternal thrones atop sacred Mount Olympus.', 'olympus-elementor' ),
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'symbol',
			[
				'label' => esc_html__( 'Symbol', 'olympus-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '⚡',
			]
		);

		$repeater->add_control(
			'realm',
			[
				'label' => esc_html__( 'Realm', 'olympus-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'King of the Gods',
			]
		);

		$repeater->add_control(
			'name',
			[
				'label' => esc_html__( 'Name', 'olympus-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'Zeus',
			]
		);

		$repeater->add_control(
			'description',
			[
				'label' => esc_html__( 'Description', 'olympus-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => 'Lord of sky, thunder, and lightning. Father of gods and men, wielder of the thunderbolt, supreme ruler of Olympus.',
			]
		);

		$repeater->add_control(
			'number',
			[
				'label' => esc_html__( 'Number', 'olympus-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'I',
			]
		);

		$this->add_control(
			'gods',
			[
				'label' => esc_html__( 'Gods', 'olympus-elementor' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[ 'symbol' => '⚡', 'realm' => 'King of the Gods', 'name' => 'Zeus', 'description' => 'Lord of sky, thunder, and lightning.', 'number' => 'I' ],
					[ 'symbol' => '🔱', 'realm' => 'God of the Sea', 'name' => 'Poseidon', 'description' => 'Master of the oceans and earthquakes.', 'number' => 'II' ],
					[ 'symbol' => '🦉', 'realm' => 'Goddess of Wisdom', 'name' => 'Athena', 'description' => 'Goddess of wisdom and strategic war.', 'number' => 'III' ],
				],
				'title_field' => '{{{ name }}}',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<section class="sec pantheon site-body">
			<div class="sec-inner">
				<div class="sec-label reveal"><?php echo esc_html__( 'The Twelve Olympians', 'olympus-elementor' ); ?></div>
				<h2 class="sec-title reveal"><?php echo esc_html( $settings['title'] ); ?></h2>
				<p class="sec-sub reveal"><?php echo esc_html( $settings['subtitle'] ); ?></p>

				<div class="gods-grid">
					<?php foreach ( $settings['gods'] as $god ) : ?>
						<div class="god-card reveal">
							<span class="god-sym"><?php echo esc_html( $god['symbol'] ); ?></span>
							<div class="god-realm"><?php echo esc_html( $god['realm'] ); ?></div>
							<div class="god-name"><?php echo esc_html( $god['name'] ); ?></div>
							<p class="god-desc"><?php echo esc_html( $god['description'] ); ?></p>
							<div class="god-num"><?php echo esc_html( $god['number'] ); ?></div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
		<div class="olympus-meander"></div>
		<?php
	}
}
