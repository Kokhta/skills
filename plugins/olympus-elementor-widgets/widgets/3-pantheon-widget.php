<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

class Olympus_Pantheon_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'olympus-pantheon';
	}

	public function get_title() {
		return esc_html__( '3-Pantheon', 'olympus-elementor-widgets' );
	}

	public function get_icon() {
		return 'eicon-gallery-grid';
	}

	public function get_categories() {
		return [ 'general' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'olympus-elementor-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'label',
			[
				'label' => esc_html__( 'Label', 'olympus-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'The Twelve Olympians',
			]
		);

		$this->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'olympus-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'The Divine Pantheon',
			]
		);

		$this->add_control(
			'description',
			[
				'label' => esc_html__( 'Description', 'olympus-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => 'Rulers of the cosmos, shaping the destiny of mortals from their eternal thrones atop sacred Mount Olympus.',
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'god_symbol',
			[
				'label' => esc_html__( 'Symbol', 'olympus-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '⚡',
			]
		);

		$repeater->add_control(
			'god_realm',
			[
				'label' => esc_html__( 'Realm', 'olympus-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'King of the Gods',
			]
		);

		$repeater->add_control(
			'god_name',
			[
				'label' => esc_html__( 'Name', 'olympus-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'Zeus',
			]
		);

		$repeater->add_control(
			'god_description',
			[
				'label' => esc_html__( 'Description', 'olympus-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => 'Lord of sky, thunder, and lightning.',
			]
		);

		$repeater->add_control(
			'god_number',
			[
				'label' => esc_html__( 'Roman Numeral', 'olympus-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'I',
			]
		);

		$this->add_control(
			'gods',
			[
				'label' => esc_html__( 'Gods', 'olympus-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'god_symbol' => '⚡',
						'god_realm' => 'King of the Gods',
						'god_name' => 'Zeus',
						'god_description' => 'Lord of sky, thunder, and lightning. Father of gods and men, wielder of the thunderbolt, supreme ruler of Olympus.',
						'god_number' => 'I',
					],
					[
						'god_symbol' => '🔱',
						'god_realm' => 'God of the Sea',
						'god_name' => 'Poseidon',
						'god_description' => 'Master of the oceans, earthquakes, and horses. His trident can split mountains and summon tempests from calm waters.',
						'god_number' => 'II',
					],
					[
						'god_symbol' => '🦉',
						'god_realm' => 'Goddess of Wisdom',
						'god_name' => 'Athena',
						'god_description' => 'Born fully armored from the head of Zeus. Goddess of wisdom, strategic war, and craft — patron deity of Athens.',
						'god_number' => 'III',
					],
				],
				'title_field' => '{{{ god_name }}}',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<section class="sec pantheon">
			<div class="sec-inner">
				<div class="sec-label reveal"><?php echo esc_html($settings['label']); ?></div>
				<h2 class="sec-title reveal"><?php echo esc_html($settings['title']); ?></h2>
				<p class="sec-sub reveal"><?php echo esc_html($settings['description']); ?></p>

				<div class="gods-grid">
					<?php foreach ( $settings['gods'] as $index => $god ) : ?>
						<div class="god-card reveal">
							<span class="god-sym"><?php echo esc_html($god['god_symbol']); ?></span>
							<div class="god-realm"><?php echo esc_html($god['god_realm']); ?></div>
							<div class="god_name"><?php echo esc_html($god['god_name']); ?></div>
							<p class="god-desc"><?php echo esc_html($god['god_description']); ?></p>
							<div class="god-num"><?php echo esc_html($god['god_number']); ?></div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
		<div class="meander"></div>
		<?php
	}
}
