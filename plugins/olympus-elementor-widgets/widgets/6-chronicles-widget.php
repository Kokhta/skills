<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

class Olympus_Chronicles_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'olympus-chronicles';
	}

	public function get_title() {
		return esc_html__( '6-Chronicles', 'olympus-elementor-widgets' );
	}

	public function get_icon() {
		return 'eicon-time-line';
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
				'default' => 'The Age of Gods',
			]
		);

		$this->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'olympus-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'Chronicles of Olympus',
			]
		);

		$this->add_control(
			'subtext',
			[
				'label' => esc_html__( 'Subtext', 'olympus-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'From the birth of the cosmos to the twilight of the gods.',
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'date',
			[
				'label' => esc_html__( 'Date', 'olympus-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'Before Time',
			]
		);

		$repeater->add_control(
			'event',
			[
				'label' => esc_html__( 'Event', 'olympus-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'The Birth of Chaos',
			]
		);

		$repeater->add_control(
			'description',
			[
				'label' => esc_html__( 'Description', 'olympus-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => 'Before existence itself, there was Chaos.',
			]
		);

		$repeater->add_control(
			'side',
			[
				'label' => esc_html__( 'Side', 'olympus-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left'  => esc_html__( 'Left', 'olympus-elementor-widgets' ),
					'right' => esc_html__( 'Right', 'olympus-elementor-widgets' ),
				],
			]
		);

		$this->add_control(
			'events',
			[
				'label' => esc_html__( 'Events', 'olympus-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'date' => 'Before Time',
						'event' => 'The Birth of Chaos',
						'description' => 'Before existence itself, there was Chaos — the primordial void from which all of creation emerged.',
						'side' => 'left',
					],
					[
						'date' => 'The First Age',
						'event' => 'Rise of the Titans',
						'description' => 'Cronus and the Titans ruled creation in an age of raw, primordial power before morality was written.',
						'side' => 'right',
					],
				],
				'title_field' => '{{{ event }}}',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<section class="sec chronicles">
			<div class="sec-inner">
				<div style="max-width: 820px; margin: 0 auto;">
					<div class="sec-label reveal"><?php echo esc_html($settings['label']); ?></div>
					<h2 class="sec-title reveal"><?php echo esc_html($settings['title']); ?></h2>
					<p class="sec-sub reveal"><?php echo esc_html($settings['subtext']); ?></p>

					<div class="timeline">
						<?php foreach ( $settings['events'] as $index => $item ) : ?>
							<div class="tl-item">
								<?php if ( $item['side'] === 'left' ) : ?>
									<div class="tl-left">
										<div class="tl-date reveal"><?php echo esc_html($item['date']); ?></div>
										<div class="tl-event reveal"><?php echo esc_html($item['event']); ?></div>
										<p class="tl-desc reveal"><?php echo esc_html($item['description']); ?></p>
									</div>
									<div class="tl-dot reveal"></div>
									<div class="tl-right"></div>
								<?php else : ?>
									<div class="tl-left"></div>
									<div class="tl-dot reveal"></div>
									<div class="tl-right">
										<div class="tl-date reveal"><?php echo esc_html($item['date']); ?></div>
										<div class="tl-event reveal"><?php echo esc_html($item['event']); ?></div>
										<p class="tl-desc reveal"><?php echo esc_html($item['description']); ?></p>
									</div>
								<?php endif; ?>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</section>
		<?php
	}
}
