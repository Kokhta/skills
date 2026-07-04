<?php
if ( ! defined( 'ABSPATH' ) ) {
	return;
}

class Olympus_Wrapper_Widget extends \Elementor\Widget_Base {

	public function get_name() { return 'olympus_wrapper'; }
	public function get_title() { return esc_html__( 'Olympus Global Wrapper', 'olympus-elementor' ); }
	public function get_icon() { return 'eicon-global-settings'; }
	public function get_categories() { return [ 'olympus' ]; }

	protected function register_controls() {
		$this->start_controls_section( 'section_theme', [ 'label' => 'Theme' ] );
		$this->add_control( 'theme_mode', [
			'label' => 'Default Theme Mode',
			'type' => \Elementor\Controls_Manager::SELECT,
			'default' => 'light',
			'options' => [ 'light' => 'Light', 'dark' => 'Dark' ],
		] );
		$this->add_control( 'enable_custom_scrollbar', [
			'label' => 'Enable Custom Scrollbar',
			'type' => \Elementor\Controls_Manager::SWITCHER,
			'default' => 'yes',
		] );
		$this->end_controls_section();

		$this->start_controls_section( 'section_loader', [ 'label' => 'Loader' ] );
		$this->add_control( 'show_loader', [ 'label' => 'Show Loader', 'type' => \Elementor\Controls_Manager::SWITCHER, 'default' => 'yes' ] );
		$this->add_control( 'loader_title', [ 'label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'OLYMPUS' ] );
		$this->add_control( 'loader_sub', [ 'label' => 'Subtitle', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Entering the Realm of Gods' ] );
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<div class="ol-theme-data" data-theme="<?php echo esc_attr( $settings['theme_mode'] ); ?>" data-scrollbar="<?php echo esc_attr( $settings['enable_custom_scrollbar'] ); ?>" style="display:none;"></div>

		<?php if ( $settings['show_loader'] === 'yes' ) : ?>
			<div id="olympus-loader">
				<div class="ol-loader-title"><?php echo esc_html( $settings['loader_title'] ); ?></div>
				<div class="ol-loader-bar"></div>
				<div class="ol-loader-sub"><?php echo esc_html( $settings['loader_sub'] ); ?></div>
			</div>
		<?php endif; ?>

		<script>
		(function($) {
			const $data = $('.ol-theme-data').last();
			const theme = $data.data('theme');
			if (theme === 'dark') {
				$('html').attr('data-theme', 'dark');
			} else {
				$('html').removeAttr('data-theme');
			}
			if ($data.data('scrollbar') === 'yes') {
				$('body').addClass('olympus-custom-scrollbar');
			}
		})(jQuery);
		</script>
		<?php
	}
}
