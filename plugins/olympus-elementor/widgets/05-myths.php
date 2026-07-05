<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

class Olympus_05_myths_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return '05-myths';
	}

	public function get_title() {
		return esc_html__( '05 Myths', 'olympus-elementor' );
	}

	public function get_icon() {
		return 'eicon-post-list';
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
				'default' => esc_html__( 'The Great Myths', 'olympus-elementor' ),
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'label',
			[
				'label' => esc_html__( 'Label', 'olympus-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'The Titanomachy',
			]
		);

		$repeater->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'olympus-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'The War That Shaped Creation',
			]
		);

		$repeater->add_control(
			'body',
			[
				'label' => esc_html__( 'Body', 'olympus-elementor' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => 'For ten savage years, the young Olympian gods waged cosmic war against the ancient Titans.',
			]
		);

		$repeater->add_control(
			'link_text',
			[
				'label' => esc_html__( 'Link Text', 'olympus-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'Read the Full Myth →',
			]
		);

		$repeater->add_control(
			'link_url',
			[
				'label' => esc_html__( 'Link URL', 'olympus-elementor' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'olympus-elementor' ),
			]
		);

		$repeater->add_control(
			'image_emoji',
			[
				'label' => esc_html__( 'Image Emoji', 'olympus-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '⚡',
			]
		);

		$repeater->add_control(
			'caption',
			[
				'label' => esc_html__( 'Caption', 'olympus-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'The War of the Titans · c. 700 BCE',
			]
		);

		$repeater->add_control(
			'flip',
			[
				'label' => esc_html__( 'Flip Layout', 'olympus-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'flip',
				'default' => '',
			]
		);

		$this->add_control(
			'myths',
			[
				'label' => esc_html__( 'Myths', 'olympus-elementor' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[ 'title' => 'The War That Shaped Creation', 'image_emoji' => '⚡', 'flip' => '' ],
					[ 'title' => 'Fire Stolen from Heaven', 'image_emoji' => '🔥', 'flip' => 'flip' ],
				],
				'title_field' => '{{{ title }}}',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<section class="sec myths site-body">
			<div class="sec-inner">
				<div class="sec-label reveal"><?php echo esc_html__( 'Sacred Tales', 'olympus-elementor' ); ?></div>
				<h2 class="sec-title reveal"><?php echo esc_html( $settings['title'] ); ?></h2>

				<?php foreach ( $settings['myths'] as $myth ) : ?>
					<div class="myth-pair <?php echo esc_attr( $myth['flip'] ); ?>">
						<?php if ( $myth['flip'] !== 'flip' ) : ?>
							<div class="myth-vis reveal">
								<div class="myth-vis-bg"><?php echo esc_html( $myth['image_emoji'] ); ?></div>
								<div class="myth-vis-caption"><?php echo esc_html( $myth['caption'] ); ?></div>
							</div>
						<?php endif; ?>

						<div>
							<div class="myth-label reveal"><?php echo esc_html( $myth['label'] ); ?></div>
							<h3 class="myth-title reveal"><?php echo esc_html( $myth['title'] ); ?></h3>
							<div class="myth-body reveal"><?php echo $myth['body']; ?></div>
							<?php if ( ! empty( $myth['link_url']['url'] ) ) : ?>
								<a href="<?php echo esc_url( $myth['link_url']['url'] ); ?>" class="myth-link reveal">
									<?php echo esc_html( $myth['link_text'] ); ?>
								</a>
							<?php else : ?>
								<span class="myth-link reveal"><?php echo esc_html( $myth['link_text'] ); ?></span>
							<?php endif; ?>
						</div>

						<?php if ( $myth['flip'] === 'flip' ) : ?>
							<div class="myth-vis reveal">
								<div class="myth-vis-bg"><?php echo esc_html( $myth['image_emoji'] ); ?></div>
								<div class="myth-vis-caption"><?php echo esc_html( $myth['caption'] ); ?></div>
							</div>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
		</section>
		<?php
	}
}
