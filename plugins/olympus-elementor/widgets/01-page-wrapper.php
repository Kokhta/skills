<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

class Olympus_01_page_wrapper_Widget extends \Elementor\Modules\NestedElements\Base\Widget_Nested_Base {

	public function get_name() {
		return '01-page-wrapper';
	}

	public function get_title() {
		return esc_html__( '01 Page Wrapper', 'olympus-elementor' );
	}

	public function get_icon() {
		return 'eicon-site-title';
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
			'section_style',
			[
				'label' => esc_html__( 'Style', 'olympus-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'default_theme',
			[
				'label' => esc_html__( 'Default Theme', 'olympus-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'light',
				'options' => [
					'light' => esc_html__( 'Light', 'olympus-elementor' ),
					'dark' => esc_html__( 'Dark', 'olympus-elementor' ),
				],
			]
		);

		$this->add_control(
			'dark_trigger',
			[
				'label' => esc_html__( 'Scroll-based Dark Mode', 'olympus-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'olympus-elementor' ),
				'label_off' => esc_html__( 'Off', 'olympus-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$this->add_render_attribute( 'wrapper', 'class', 'olympus-page-wrapper' );
		if ( $settings['default_theme'] === 'dark' ) {
			echo '<script>document.documentElement.setAttribute("data-theme", "dark");</script>';
		}

		$data_dark_trigger = ( $settings['dark_trigger'] === 'yes' ) ? 'true' : 'false';
		?>
		<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>
             data-dark-trigger="<?php echo esc_attr( $data_dark_trigger ); ?>">
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
		<style>
			body {
				margin: 0;
				padding: 0;
			}
			.olympus-page-wrapper {
				min-height: 100vh;
			}
		</style>
		<?php
	}

	protected function content_template() {
		?>
		<div class="olympus-page-wrapper" data-dark-trigger="{{ settings.dark_trigger === 'yes' ? 'true' : 'false' }}">
			<div class="elementor-child-contents"></div>
		</div>
		<?php
	}
}
