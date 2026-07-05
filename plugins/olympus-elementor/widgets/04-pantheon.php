<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

class Olympus_04_pantheon_Widget extends \Elementor\Modules\NestedElements\Base\Widget_Nested_Base {

	public function get_name() {
		return '04-pantheon';
	}

	public function get_title() {
		return esc_html__( '04 Pantheon', 'olympus-elementor' );
	}

	public function get_icon() {
		return 'eicon-gallery-grid';
	}

	public function get_categories() {
		return [ 'olympus' ];
	}

	protected function get_default_children_elements() {
		$defaults = [
			[ 'elType' => 'widget', 'widgetType' => 'text-editor', 'settings' => [ 'content' => 'The Twelve Olympians', '_class' => 'sec-label reveal' ] ],
			[ 'elType' => 'widget', 'widgetType' => 'heading', 'settings' => [ 'title' => 'The Divine Pantheon', '_class' => 'sec-title reveal' ] ],
			[ 'elType' => 'widget', 'widgetType' => 'text-editor', 'settings' => [ 'content' => 'Rulers of the cosmos, shaping the destiny of mortals from their eternal thrones atop sacred Mount Olympus.', '_class' => 'sec-sub reveal' ] ],
		];

		$gods = [
			[ 'sym' => '⚡', 'realm' => 'King of the Gods', 'name' => 'Zeus', 'desc' => 'Lord of sky, thunder, and lightning.', 'num' => 'I' ],
			[ 'sym' => '🔱', 'realm' => 'God of the Sea', 'name' => 'Poseidon', 'desc' => 'Master of the oceans, earthquakes, and horses.', 'num' => 'II' ],
			[ 'sym' => '🦉', 'realm' => 'Goddess of Wisdom', 'name' => 'Athena', 'desc' => 'Born fully armored from the head of Zeus.', 'num' => 'III' ],
		];

		foreach ( $gods as $god ) {
			$defaults[] = [
				'elType' => 'widget',
				'widgetType' => 'html',
				'settings' => [
					'html' => sprintf(
						'<div class="god-card reveal"><span class="god-sym">%s</span><div class="god-realm">%s</div><div class="god-name">%s</div><p class="god-desc">%s</p><div class="god-num">%s</div></div>',
						$god['sym'], $god['realm'], $god['name'], $god['desc'], $god['num']
					),
				],
			];
		}

		return $defaults;
	}

	protected function get_default_repeater_title_setting_key() {
		return '';
	}

	protected function render() {
		?>
		<section class="sec pantheon site-body">
			<div class="sec-inner">
				<div class="gods-grid">
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
		<div class="olympus-meander"></div>
		<?php
	}

	protected function content_template() {
		?>
		<section class="sec pantheon site-body">
			<div class="sec-inner">
				<div class="gods-grid">
					<div class="elementor-child-contents"></div>
				</div>
			</div>
		</section>
		<div class="olympus-meander"></div>
		<?php
	}
}
