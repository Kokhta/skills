<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

class Olympus_03_intro_Widget extends \Elementor\Modules\NestedElements\Base\Widget_Nested_Base {

	public function get_name() {
		return '03-intro';
	}

	public function get_title() {
		return esc_html__( '03 Intro', 'olympus-elementor' );
	}

	public function get_icon() {
		return 'eicon-type-tool';
	}

	public function get_categories() {
		return [ 'olympus' ];
	}

	public function is_container() {
		return true;
	}

	protected function get_default_children_elements() {
		return [];
	}

	protected function get_default_repeater_title_setting_key() {
		return '';
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
					'type' => 'intro',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		?>
		<section class="intro site-body">
			<div class="intro-inner">
				<?php
				if ( method_exists( $this, 'print_child_widgets_content' ) ) {
					$this->print_child_widgets_content();
				} else {
					foreach ( $this->get_settings( 'elements' ) as $child_element ) {
						$child_element->print_element();
					}
				}
				?>
			</div>
		</section>
		<div class="olympus-meander"></div>
		<?php
	}

	protected function content_template() {
		?>
		<section class="intro site-body">
			<div class="intro-inner">
				<div class="elementor-child-contents"></div>
			</div>
		</section>
		<div class="olympus-meander"></div>
		<?php
	}
}
