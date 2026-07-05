<?php
if ( ! defined( 'ABSPATH' ) ) {
	return;
}

class Elementor_Olympus_Page_Container_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'olympus_page_container';
	}

	public function get_title() {
		return esc_html__( 'Olympus Page Container', 'olympus-widgets' );
	}

	public function get_icon() {
		return 'eicon-container';
	}

	public function get_categories() {
		return [ 'general' ];
	}

	public function get_keywords() {
		return [ 'olympus', 'container', 'wrapper' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Settings', 'olympus-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_loader',
			[
				'label' => esc_html__( 'Show Loader', 'olympus-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'olympus-widgets' ),
				'label_off' => esc_html__( 'Hide', 'olympus-widgets' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'loader_title',
			[
				'label' => esc_html__( 'Loader Title', 'olympus-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'OLYMPUS', 'olympus-widgets' ),
				'condition' => [
					'show_loader' => 'yes',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<div class="olympus-page-wrapper">
			<?php if ( 'yes' === $settings['show_loader'] ) : ?>
				<div id="ol-loader">
					<div class="ol-loader-title"><?php echo esc_html( $settings['loader_title'] ); ?></div>
					<div class="ol-loader-bar"></div>
					<div class="ol-loader-sub"><?php esc_html_e( 'Entering the Realm of Gods', 'olympus-widgets' ); ?></div>
				</div>
			<?php endif; ?>
		</div>
		<?php
	}

}
