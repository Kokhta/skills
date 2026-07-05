<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

class Olympus_06_oracle_Widget extends \Elementor\Modules\NestedElements\Base\Widget_Nested_Base {

	public function get_name() {
		return '06-oracle';
	}

	public function get_title() {
		return esc_html__( '06 Oracle', 'olympus-elementor' );
	}

	public function get_icon() {
		return 'eicon-blockquote';
	}

	public function get_categories() {
		return [ 'olympus' ];
	}

	protected function get_default_children_elements() {
		return [
			[ 'elType' => 'widget', 'widgetType' => 'html', 'settings' => [ 'html' => '<div class="oracle-bg">ΧΡΗΣΜΟΣ</div>' ] ],
			[ 'elType' => 'widget', 'widgetType' => 'text-editor', 'settings' => [ 'content' => '🏛️', '_class' => 'oracle-icon reveal' ] ],
			[ 'elType' => 'widget', 'widgetType' => 'text-editor', 'settings' => [ 'content' => 'The Oracle of Delphi', '_class' => 'sec-label reveal' ] ],
			[ 'elType' => 'widget', 'widgetType' => 'html', 'settings' => [ 'html' => '<div class="g-rule reveal"><div class="g-rule-line"></div><div class="g-rule-sym">✦</div><div class="g-rule-line rev"></div></div>' ] ],
			[ 'elType' => 'widget', 'widgetType' => 'text-editor', 'settings' => [ 'content' => '"Know thyself. Nothing in excess.<br><em>Certainty brings insanity.</em>"', '_class' => 'oracle-quote reveal' ] ],
			[ 'elType' => 'widget', 'widgetType' => 'html', 'settings' => [ 'html' => '<div class="g-rule reveal"><div class="g-rule-line"></div><div class="g-rule-sym">✦</div><div class="g-rule-line rev"></div></div>' ] ],
			[ 'elType' => 'widget', 'widgetType' => 'text-editor', 'settings' => [ 'content' => '— The Three Maxims of Delphi, inscribed at Apollo\'s Temple', '_class' => 'oracle-attr reveal' ] ],
		];
	}

	protected function get_default_repeater_title_setting_key() {
		return '';
	}

	protected function render() {
		?>
		<section class="oracle site-body">
			<div class="oracle-inner">
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
		<section class="oracle site-body">
			<div class="oracle-inner">
				<div class="elementor-child-contents"></div>
			</div>
		</section>
		<div class="olympus-meander"></div>
		<?php
	}
}
