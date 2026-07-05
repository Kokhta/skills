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

	protected function get_default_children_elements() {
		return [
			[ 'elType' => 'widget', 'widgetType' => 'text-editor', 'settings' => [ 'content' => 'The Ancient World', '_class' => 'sec-label reveal' ] ],
			[ 'elType' => 'widget', 'widgetType' => 'html', 'settings' => [ 'html' => '<div class="g-rule reveal"><div class="g-rule-line"></div><div class="g-rule-sym">⚡</div><div class="g-rule-line rev"></div></div>' ] ],
			[ 'elType' => 'widget', 'widgetType' => 'text-editor', 'settings' => [ 'content' => '"From Chaos came the Earth, and from the Earth came all things divine — the <em>twelve immortals</em> who shaped the fate of gods and men alike from their thrones upon Mount Olympus."', '_class' => 'intro-quote reveal' ] ],
			[ 'elType' => 'widget', 'widgetType' => 'html', 'settings' => [ 'html' => '<div class="g-rule reveal"><div class="g-rule-line"></div><div class="g-rule-sym">✦</div><div class="g-rule-line rev"></div></div>' ] ],
			[ 'elType' => 'widget', 'widgetType' => 'text-editor', 'settings' => [ 'content' => '— Hesiod · Theogony · 700 BCE', '_class' => 'intro-source reveal' ] ],
		];
	}

	protected function get_default_repeater_title_setting_key() {
		return '';
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
