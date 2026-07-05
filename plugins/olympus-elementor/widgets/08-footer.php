<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

class Olympus_08_footer_Widget extends \Elementor\Modules\NestedElements\Base\Widget_Nested_Base {

	public function get_name() {
		return '08-footer';
	}

	public function get_title() {
		return esc_html__( '08 Footer', 'olympus-elementor' );
	}

	public function get_icon() {
		return 'eicon-footer';
	}

	public function get_categories() {
		return [ 'olympus' ];
	}

	protected function get_default_children_elements() {
		return [
			[ 'elType' => 'widget', 'widgetType' => 'html', 'settings' => [ 'html' => '<div class="foot-top"><div><div class="foot-logo">OLYMPUS</div><div class="foot-tagline">ΟΛΥΜΠΟΣ · Realm of the Eternal Gods</div></div><ul class="foot-nav"><li><a href="#pantheon">The Gods</a></li><li><a href="#myths">Myths</a></li><li><a href="#oracle">Oracle</a></li></ul></div>' ] ],
			[ 'elType' => 'widget', 'widgetType' => 'html', 'settings' => [ 'html' => '<div class="foot-bottom"><div class="foot-copy">✦ MMXXVI · Where the Gods Dwell Eternal ✦</div></div>' ] ],
		];
	}

	protected function get_default_repeater_title_setting_key() {
		return '';
	}

	protected function render() {
		?>
		<footer class="site-body">
			<?php
			if ( method_exists( $this, 'print_child_widgets_content' ) ) {
				$this->print_child_widgets_content();
			} else {
				foreach ( $this->get_settings( 'elements' ) as $child_element ) {
					$child_element->print_element();
				}
			}
			?>
		</footer>
		<?php
	}

	protected function content_template() {
		?>
		<footer class="site-body">
			<div class="elementor-child-contents"></div>
		</footer>
		<?php
	}
}
