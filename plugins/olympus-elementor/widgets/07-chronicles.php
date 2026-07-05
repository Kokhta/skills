<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

class Olympus_07_chronicles_Widget extends \Elementor\Modules\NestedElements\Base\Widget_Nested_Base {

	public function get_name() {
		return '07-chronicles';
	}

	public function get_title() {
		return esc_html__( '07 Chronicles', 'olympus-elementor' );
	}

	public function get_icon() {
		return 'eicon-time-line';
	}

	public function get_categories() {
		return [ 'olympus' ];
	}

	protected function get_default_children_elements() {
		return [
			[ 'elType' => 'widget', 'widgetType' => 'text-editor', 'settings' => [ 'content' => 'The Age of Gods', '_class' => 'sec-label reveal' ] ],
			[ 'elType' => 'widget', 'widgetType' => 'heading', 'settings' => [ 'title' => 'Chronicles of Olympus', '_class' => 'sec-title reveal' ] ],
			[ 'elType' => 'widget', 'widgetType' => 'text-editor', 'settings' => [ 'content' => 'From the birth of the cosmos to the twilight of the gods.', '_class' => 'sec-sub reveal' ] ],
			[ 'elType' => 'widget', 'widgetType' => 'html', 'settings' => [ 'html' => '<div class="timeline"><div class="tl-item"><div class="tl-left"><div class="tl-date reveal">Before Time</div><div class="tl-event reveal">The Birth of Chaos</div><p class="tl-desc reveal">Before existence itself, there was Chaos.</p></div><div class="tl-dot reveal"></div><div class="tl-right"></div></div><div class="tl-item"><div class="tl-left"></div><div class="tl-dot reveal"></div><div class="tl-right"><div class="tl-date reveal">The First Age</div><div class="tl-event reveal">Rise of the Titans</div><p class="tl-desc reveal">Cronus and the Titans ruled creation.</p></div></div></div>' ] ],
		];
	}

	protected function get_default_repeater_title_setting_key() {
		return '';
	}

	protected function render() {
		?>
		<section class="sec chronicles site-body">
			<div class="sec-inner">
				<div style="max-width: 820px; margin: 0 auto;">
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
			</div>
		</section>
		<?php
	}

	protected function content_template() {
		?>
		<section class="sec chronicles site-body">
			<div class="sec-inner">
				<div style="max-width: 820px; margin: 0 auto;">
					<div class="elementor-child-contents"></div>
				</div>
			</div>
		</section>
		<?php
	}
}
