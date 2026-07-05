<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

class Olympus_02_hero_Widget extends \Elementor\Modules\NestedElements\Base\Widget_Nested_Base {

	public function get_name() {
		return '02-hero';
	}

	public function get_title() {
		return esc_html__( '02 Hero', 'olympus-elementor' );
	}

	public function get_icon() {
		return 'eicon-video-camera';
	}

	public function get_categories() {
		return [ 'olympus' ];
	}

	public function is_container() {
		return true;
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_import',
			[
				'label' => esc_html__( 'Setup', 'olympus-elementor' ),
			]
		);

		$this->add_control(
			'import_button',
			[
				'label' => esc_html__( 'Import Default Content', 'olympus-elementor' ),
				'type' => \Elementor\Controls_Manager::BUTTON,
				'button_type' => 'success',
				'text' => esc_html__( 'Import', 'olympus-elementor' ),
				'event' => 'olympus:import:default',
				'event_data' => [
					'type' => 'hero',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_settings',
			[
				'label' => esc_html__( 'Animation Settings', 'olympus-elementor' ),
			]
		);

		$this->add_control(
			'scrub_value',
			[
				'label' => esc_html__( 'Scrub Value', 'olympus-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => 0.25,
				'step' => 0.05,
			]
		);

		$this->add_control(
			'video_scale_end',
			[
				'label' => esc_html__( 'Video Scale End', 'olympus-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => 1.07,
				'step' => 0.01,
			]
		);

		$this->add_control(
			'content_fade_percent',
			[
				'label' => esc_html__( 'Content Fade %', 'olympus-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => 28,
				'min' => 1,
				'max' => 100,
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<section class="hero-wrap"
                 data-scrub="<?php echo esc_attr($settings['scrub_value']); ?>"
                 data-scale="<?php echo esc_attr($settings['video_scale_end']); ?>"
                 data-fade-percent="<?php echo esc_attr($settings['content_fade_percent']); ?>">
			<div class="hero-sticky">
				<?php $this->print_child_widgets_content(); ?>
			</div>
		</section>
		<?php
	}

	protected function content_template() {
		?>
		<section class="hero-wrap">
			<div class="hero-sticky">
				<div class="elementor-child-contents"></div>
			</div>
		</section>
		<?php
	}
}
