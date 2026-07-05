<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

class Olympus_07_chronicles_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return '07-chronicles';
	}

	public function get_title() {
		return esc_html__( '07 Chronicles', 'olympus-elementor' );
	}

	public function get_icon() {
		return 'eicon-time-line';
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
				'default' => esc_html__( 'Chronicles of Olympus', 'olympus-elementor' ),
			]
		);

		$this->add_control(
			'subtitle',
			[
				'label' => esc_html__( 'Subtitle', 'olympus-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'From the birth of the cosmos to the twilight of the gods.', 'olympus-elementor' ),
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'date',
			[
				'label' => esc_html__( 'Date', 'olympus-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'Before Time',
			]
		);

		$repeater->add_control(
			'event',
			[
				'label' => esc_html__( 'Event', 'olympus-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'The Birth of Chaos',
			]
		);

		$repeater->add_control(
			'description',
			[
				'label' => esc_html__( 'Description', 'olympus-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => 'Before existence itself, there was Chaos — the primordial void from which all of creation emerged.',
			]
		);

		$repeater->add_control(
			'side',
			[
				'label' => esc_html__( 'Side', 'olympus-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left' => esc_html__( 'Left', 'olympus-elementor' ),
					'right' => esc_html__( 'Right', 'olympus-elementor' ),
				],
			]
		);

		$this->add_control(
			'items',
			[
				'label' => esc_html__( 'Timeline Items', 'olympus-elementor' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[ 'date' => 'Before Time', 'event' => 'The Birth of Chaos', 'side' => 'left' ],
					[ 'date' => 'The First Age', 'event' => 'Rise of the Titans', 'side' => 'right' ],
				],
				'title_field' => '{{{ event }}}',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<section class="sec chronicles site-body">
			<div class="sec-inner">
				<div style="max-width: 820px; margin: 0 auto;">
					<div class="sec-label reveal"><?php echo esc_html__( 'The Age of Gods', 'olympus-elementor' ); ?></div>
					<h2 class="sec-title reveal"><?php echo esc_html( $settings['title'] ); ?></h2>
					<p class="sec-sub reveal"><?php echo esc_html( $settings['subtitle'] ); ?></p>

					<div class="timeline">
						<?php foreach ( $settings['items'] as $item ) : ?>
							<div class="tl-item">
								<div class="tl-left">
									<?php if ( $item['side'] === 'left' ) : ?>
										<div class="tl-date reveal"><?php echo esc_html( $item['date'] ); ?></div>
										<div class="tl-event reveal"><?php echo esc_html( $item['event'] ); ?></div>
										<p class="tl-desc reveal"><?php echo esc_html( $item['description'] ); ?></p>
									<?php endif; ?>
								</div>
								<div class="tl-dot reveal"></div>
								<div class="tl-right">
									<?php if ( $item['side'] === 'right' ) : ?>
										<div class="tl-date reveal"><?php echo esc_html( $item['date'] ); ?></div>
										<div class="tl-event reveal"><?php echo esc_html( $item['event'] ); ?></div>
										<p class="tl-desc reveal"><?php echo esc_html( $item['description'] ); ?></p>
									<?php endif; ?>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</section>
		<?php
	}
}
