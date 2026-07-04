<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

class Olympus_Footer_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'olympus-footer';
	}

	public function get_title() {
		return esc_html__( '7-Footer', 'olympus-elementor-widgets' );
	}

	public function get_icon() {
		return 'eicon-footer';
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
			'logo',
			[
				'label' => esc_html__( 'Logo Text', 'olympus-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'OLYMPUS',
			]
		);

		$this->add_control(
			'tagline',
			[
				'label' => esc_html__( 'Tagline', 'olympus-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'ΟΛΥΜΠΟΣ · Realm of the Eternal Gods',
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'text',
			[
				'label' => esc_html__( 'Link Text', 'olympus-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'Link',
			]
		);

		$repeater->add_control(
			'url',
			[
				'label' => esc_html__( 'Link URL', 'olympus-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::URL,
				'default' => [
					'url' => '#',
				],
			]
		);

		$this->add_control(
			'links',
			[
				'label' => esc_html__( 'Nav Links', 'olympus-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[ 'text' => 'The Gods', 'url' => [ 'url' => '#pantheon' ] ],
					[ 'text' => 'Myths', 'url' => [ 'url' => '#myths' ] ],
					[ 'text' => 'Oracle', 'url' => [ 'url' => '#oracle' ] ],
					[ 'text' => 'Chronicles', 'url' => [ 'url' => '#chronicles' ] ],
				],
				'title_field' => '{{{ text }}}',
			]
		);

		$this->add_control(
			'copyright',
			[
				'label' => esc_html__( 'Copyright Text', 'olympus-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '✦ MMXXVI · Where the Gods Dwell Eternal ✦',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<footer class="olympus-footer">
			<div class="foot-top">
				<div>
					<div class="foot-logo"><?php echo esc_html($settings['logo']); ?></div>
					<div class="foot-tagline"><?php echo esc_html($settings['tagline']); ?></div>
				</div>
				<ul class="foot-nav">
					<?php foreach ( $settings['links'] as $link ) : ?>
						<li><a href="<?php echo esc_url($link['url']['url']); ?>"><?php echo esc_html($link['text']); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>
			<div class="foot-bottom">
				<div class="foot-copy"><?php echo esc_html($settings['copyright']); ?></div>
			</div>
		</footer>
		<?php
	}
}
