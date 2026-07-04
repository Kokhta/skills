<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

class Olympus_Myth_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'olympus-myth';
	}

	public function get_title() {
		return esc_html__( '4-Myth', 'olympus-elementor-widgets' );
	}

	public function get_icon() {
		return 'eicon-image-box';
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
			'flip',
			[
				'label' => esc_html__( 'Flip Orientation', 'olympus-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Flip', 'olympus-elementor-widgets' ),
				'label_off' => esc_html__( 'Normal', 'olympus-elementor-widgets' ),
				'return_value' => 'flip',
				'default' => '',
			]
		);

		$this->add_control(
			'symbol',
			[
				'label' => esc_html__( 'Symbol/Icon', 'olympus-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '⚡',
			]
		);

		$this->add_control(
			'caption',
			[
				'label' => esc_html__( 'Visual Caption', 'olympus-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'The War of the Titans · c. 700 BCE',
			]
		);

		$this->add_control(
			'label',
			[
				'label' => esc_html__( 'Label', 'olympus-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'The Titanomachy',
			]
		);

		$this->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'olympus-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'The War That Shaped Creation',
			]
		);

		$this->add_control(
			'body',
			[
				'label' => esc_html__( 'Body Text', 'olympus-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => '<p>For ten savage years, the young Olympian gods waged cosmic war against the ancient Titans for dominion over creation.</p>',
			]
		);

		$this->add_control(
			'link_text',
			[
				'label' => esc_html__( 'Link Text', 'olympus-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'Read the Full Myth →',
			]
		);

		$this->add_control(
			'link_url',
			[
				'label' => esc_html__( 'Link URL', 'olympus-elementor-widgets' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'olympus-elementor-widgets' ),
				'default' => [
					'url' => '#',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$flip_class = $settings['flip'] === 'flip' ? 'flip' : '';
		?>
		<section class="sec myths">
			<div class="sec-inner">
				<div class="myth-pair <?php echo esc_attr($flip_class); ?>">
					<div class="myth-vis reveal">
						<div class="myth-vis-bg"><?php echo esc_html($settings['symbol']); ?></div>
						<div class="myth-vis-caption"><?php echo esc_html($settings['caption']); ?></div>
					</div>
					<div>
						<div class="myth-label reveal"><?php echo esc_html($settings['label']); ?></div>
						<h3 class="myth-title reveal"><?php echo esc_html($settings['title']); ?></h3>
						<div class="myth-body reveal">
							<?php echo $settings['body']; ?>
						</div>
						<?php if ( ! empty( $settings['link_url']['url'] ) ) : ?>
							<a href="<?php echo esc_url($settings['link_url']['url']); ?>" class="myth-link reveal"><?php echo esc_html($settings['link_text']); ?></a>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</section>
		<?php
	}
}
