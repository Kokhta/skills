<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Olympus_Chronicles_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'olympus-chronicles';
	}

	public function get_title() {
		return esc_html__( 'Olympus Chronicles', 'olympus-elementor-addon' );
	}

	public function get_icon() {
		return 'eicon-time-line';
	}

	public function get_categories() {
		return [ 'general' ];
	}

	public function get_script_depends() {
		return [ 'olympus-scripts' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_header',
			[
				'label' => esc_html__( 'Header', 'olympus-elementor-addon' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'label',
			[
				'label' => esc_html__( 'Label', 'olympus-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'The Age of Gods', 'olympus-elementor-addon' ),
			]
		);

		$this->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'olympus-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Chronicles of Olympus', 'olympus-elementor-addon' ),
			]
		);

		$this->add_control(
			'subtitle',
			[
				'label' => esc_html__( 'Subtitle', 'olympus-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'From the birth of the cosmos to the twilight of the gods.', 'olympus-elementor-addon' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_timeline',
			[
				'label' => esc_html__( 'Timeline', 'olympus-elementor-addon' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'item_date',
			[
				'label' => esc_html__( 'Date/Era', 'olympus-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Before Time', 'olympus-elementor-addon' ),
			]
		);

		$repeater->add_control(
			'item_event',
			[
				'label' => esc_html__( 'Event', 'olympus-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'The Birth of Chaos', 'olympus-elementor-addon' ),
			]
		);

		$repeater->add_control(
			'item_desc',
			[
				'label' => esc_html__( 'Description', 'olympus-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Before existence itself, there was Chaos — the primordial void from which all of creation emerged.', 'olympus-elementor-addon' ),
			]
		);

		$repeater->add_control(
			'item_align',
			[
				'label' => esc_html__( 'Alignment', 'olympus-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'left'  => esc_html__( 'Left', 'olympus-elementor-addon' ),
					'right' => esc_html__( 'Right', 'olympus-elementor-addon' ),
				],
				'default' => 'left',
			]
		);

		$this->add_control(
			'items',
			[
				'label' => esc_html__( 'Timeline Items', 'olympus-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'item_date' => esc_html__( 'Before Time', 'olympus-elementor-addon' ),
						'item_event' => esc_html__( 'The Birth of Chaos', 'olympus-elementor-addon' ),
						'item_align' => 'left',
					],
					[
						'item_date' => esc_html__( 'The First Age', 'olympus-elementor-addon' ),
						'item_event' => esc_html__( 'Rise of the Titans', 'olympus-elementor-addon' ),
						'item_align' => 'right',
					],
				],
				'title_field' => '{{{ item_event }}}',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<section class="ol-sec ol-chronicles" id="chronicles">
			<div class="ol-sec-inner">
				<div style="max-width: 820px; margin: 0 auto;">
					<div class="ol-sec-label ol-reveal"><?php echo esc_html( $settings['label'] ); ?></div>
					<h2 class="ol-sec-title ol-reveal"><?php echo esc_html( $settings['title'] ); ?></h2>
					<p class="ol-sec-sub ol-reveal"><?php echo esc_html( $settings['subtitle'] ); ?></p>

					<div class="ol-timeline">
						<?php foreach ( $settings['items'] as $item ) : ?>
							<div class="ol-tl-item">
								<div class="ol-tl-left">
									<?php if ( 'left' === $item['item_align'] ) : ?>
										<div class="ol-tl-date ol-reveal"><?php echo esc_html( $item['item_date'] ); ?></div>
										<div class="ol-tl-event ol-reveal"><?php echo esc_html( $item['item_event'] ); ?></div>
										<p class="ol-tl-desc ol-reveal"><?php echo esc_html( $item['item_desc'] ); ?></p>
									<?php endif; ?>
								</div>
								<div class="ol-tl-dot ol-reveal"></div>
								<div class="ol-tl-right">
									<?php if ( 'right' === $item['item_align'] ) : ?>
										<div class="ol-tl-date ol-reveal"><?php echo esc_html( $item['item_date'] ); ?></div>
										<div class="ol-tl-event ol-reveal"><?php echo esc_html( $item['item_event'] ); ?></div>
										<p class="ol-tl-desc ol-reveal"><?php echo esc_html( $item['item_desc'] ); ?></p>
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

	protected function content_template() {
		?>
		<section class="ol-sec ol-chronicles">
			<div class="ol-sec-inner">
				<div style="max-width: 820px; margin: 0 auto;">
					<div class="ol-sec-label ol-reveal">{{{ settings.label }}}</div>
					<h2 class="ol-sec-title ol-reveal">{{{ settings.title }}}</h2>
					<p class="ol-sec-sub ol-reveal">{{{ settings.subtitle }}}</p>

					<div class="ol-timeline">
						<# _.each( settings.items, function( item ) { #>
							<div class="ol-tl-item">
								<div class="ol-tl-left">
									<# if ( item.item_align === 'left' ) { #>
										<div class="ol-tl-date ol-reveal">{{{ item.item_date }}}</div>
										<div class="ol-tl-event ol-reveal">{{{ item.item_event }}}</div>
										<p class="ol-tl-desc ol-reveal">{{{ item.item_desc }}}</p>
									<# } #>
								</div>
								<div class="ol-tl-dot ol-reveal"></div>
								<div class="ol-tl-right">
									<# if ( item.item_align === 'right' ) { #>
										<div class="ol-tl-date ol-reveal">{{{ item.item_date }}}</div>
										<div class="ol-tl-event ol-reveal">{{{ item.item_event }}}</div>
										<p class="ol-tl-desc ol-reveal">{{{ item.item_desc }}}</p>
									<# } #>
								</div>
							</div>
						<# } ); #>
					</div>
				</div>
			</div>
		</section>
		<?php
	}
}
