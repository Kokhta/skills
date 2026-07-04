<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Olympus_Myths_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'olympus-myths';
	}

	public function get_title() {
		return esc_html__( 'Olympus Myths', 'olympus-elementor-addon' );
	}

	public function get_icon() {
		return 'eicon-image-before-after';
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
				'default' => esc_html__( 'Sacred Tales', 'olympus-elementor-addon' ),
			]
		);

		$this->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'olympus-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'The Great Myths', 'olympus-elementor-addon' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_myths',
			[
				'label' => esc_html__( 'Myths', 'olympus-elementor-addon' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'myth_symbol',
			[
				'label' => esc_html__( 'Symbol', 'olympus-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '⚡',
			]
		);

		$repeater->add_control(
			'myth_caption',
			[
				'label' => esc_html__( 'Caption', 'olympus-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'The War of the Titans · c. 700 BCE', 'olympus-elementor-addon' ),
			]
		);

		$repeater->add_control(
			'myth_label',
			[
				'label' => esc_html__( 'Label', 'olympus-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'The Titanomachy', 'olympus-elementor-addon' ),
			]
		);

		$repeater->add_control(
			'myth_title',
			[
				'label' => esc_html__( 'Title', 'olympus-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'The War That Shaped Creation', 'olympus-elementor-addon' ),
			]
		);

		$repeater->add_control(
			'myth_body',
			[
				'label' => esc_html__( 'Body', 'olympus-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'For ten savage years, the young Olympian gods waged cosmic war against the ancient Titans for dominion over creation.', 'olympus-elementor-addon' ),
			]
		);

		$repeater->add_control(
			'myth_link',
			[
				'label' => esc_html__( 'Link', 'olympus-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'olympus-elementor-addon' ),
				'default' => [
					'url' => '#',
				],
			]
		);

		$repeater->add_control(
			'myth_reverse',
			[
				'label' => esc_html__( 'Reverse Layout', 'olympus-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'flip',
				'default' => '',
			]
		);

		$this->add_control(
			'myths',
			[
				'label' => esc_html__( 'Myth Pairs', 'olympus-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'myth_symbol' => '⚡',
						'myth_title' => esc_html__( 'The War That Shaped Creation', 'olympus-elementor-addon' ),
					],
					[
						'myth_symbol' => '🔥',
						'myth_title' => esc_html__( 'Fire Stolen from Heaven', 'olympus-elementor-addon' ),
						'myth_reverse' => 'flip',
					],
				],
				'title_field' => '{{{ myth_title }}}',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<section class="ol-sec ol-myths" id="myths">
			<div class="ol-sec-inner">
				<div class="ol-sec-label ol-reveal"><?php echo esc_html( $settings['label'] ); ?></div>
				<h2 class="ol-sec-title ol-reveal"><?php echo esc_html( $settings['title'] ); ?></h2>

				<?php foreach ( $settings['myths'] as $myth ) : ?>
					<div class="ol-myth-pair <?php echo esc_attr( $myth['myth_reverse'] ); ?>">
						<?php if ( 'flip' !== $myth['myth_reverse'] ) : ?>
							<div class="ol-myth-vis ol-reveal">
								<div class="ol-myth-vis-bg"><?php echo esc_html( $myth['myth_symbol'] ); ?></div>
								<div class="ol-myth-vis-caption"><?php echo esc_html( $myth['myth_caption'] ); ?></div>
							</div>
						<?php endif; ?>

						<div>
							<div class="ol-myth-label ol-reveal"><?php echo esc_html( $myth['myth_label'] ); ?></div>
							<h3 class="ol-myth-title ol-reveal"><?php echo esc_html( $myth['myth_title'] ); ?></h3>
							<div class="ol-myth-body ol-reveal">
								<?php echo wp_kses_post( $myth['myth_body'] ); ?>
							</div>
							<?php if ( ! empty( $myth['myth_link']['url'] ) ) : ?>
								<a href="<?php echo esc_url( $myth['myth_link']['url'] ); ?>" class="ol-myth-link ol-reveal" <?php echo $myth['myth_link']['is_external'] ? 'target="_blank"' : ''; ?>>
									<?php echo esc_html__( 'Read the Full Myth →', 'olympus-elementor-addon' ); ?>
								</a>
							<?php endif; ?>
						</div>

						<?php if ( 'flip' === $myth['myth_reverse'] ) : ?>
							<div class="ol-myth-vis ol-reveal">
								<div class="ol-myth-vis-bg"><?php echo esc_html( $myth['myth_symbol'] ); ?></div>
								<div class="ol-myth-vis-caption"><?php echo esc_html( $myth['myth_caption'] ); ?></div>
							</div>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
		</section>
		<?php
	}

	protected function content_template() {
		?>
		<section class="ol-sec ol-myths">
			<div class="ol-sec-inner">
				<div class="ol-sec-label ol-reveal">{{{ settings.label }}}</div>
				<h2 class="ol-sec-title ol-reveal">{{{ settings.title }}}</h2>

				<# _.each( settings.myths, function( myth ) { #>
					<div class="ol-myth-pair {{ myth.myth_reverse }}">
						<# if ( myth.myth_reverse !== 'flip' ) { #>
							<div class="ol-myth-vis ol-reveal">
								<div class="ol-myth-vis-bg">{{{ myth.myth_symbol }}}</div>
								<div class="ol-myth-vis-caption">{{{ myth.myth_caption }}}</div>
							</div>
						<# } #>

						<div>
							<div class="ol-myth-label ol-reveal">{{{ myth.myth_label }}}</div>
							<h3 class="ol-myth-title ol-reveal">{{{ myth.myth_title }}}</h3>
							<div class="ol-myth-body ol-reveal">{{{ myth.myth_body }}}</div>
							<# if ( myth.myth_link && myth.myth_link.url ) { #>
								<a href="{{ myth.myth_link.url }}" class="ol-myth-link ol-reveal">
									<?php echo esc_html__( 'Read the Full Myth →', 'olympus-elementor-addon' ); ?>
								</a>
							<# } #>
						</div>

						<# if ( myth.myth_reverse === 'flip' ) { #>
							<div class="ol-myth-vis ol-reveal">
								<div class="ol-myth-vis-bg">{{{ myth.myth_symbol }}}</div>
								<div class="ol-myth-vis-caption">{{{ myth.myth_caption }}}</div>
							</div>
						<# } #>
					</div>
				<# } ); #>
			</div>
		</section>
		<?php
	}
}
