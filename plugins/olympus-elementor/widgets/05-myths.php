<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

class Olympus_05_myths_Widget extends \Elementor\Modules\NestedElements\Base\Widget_Nested_Base {

	public function get_name() {
		return '05-myths';
	}

	public function get_title() {
		return esc_html__( '05 Myths', 'olympus-elementor' );
	}

	public function get_icon() {
		return 'eicon-post-list';
	}

	public function get_categories() {
		return [ 'olympus' ];
	}

	protected function get_default_children_elements() {
		return [
			[ 'elType' => 'widget', 'widgetType' => 'text-editor', 'settings' => [ 'content' => 'Sacred Tales', '_class' => 'sec-label reveal' ] ],
			[ 'elType' => 'widget', 'widgetType' => 'heading', 'settings' => [ 'title' => 'The Great Myths', '_class' => 'sec-title reveal' ] ],
			[ 'elType' => 'widget', 'widgetType' => 'html', 'settings' => [ 'html' => '<div class="myth-pair"><div class="myth-vis reveal"><div class="myth-vis-bg">⚡</div><div class="myth-vis-caption">The War of the Titans · c. 700 BCE</div></div><div><div class="myth-label reveal">The Titanomachy</div><h3 class="myth-title reveal">The War That Shaped Creation</h3><p class="myth-body reveal">For ten savage years, the young Olympian gods waged cosmic war against the ancient Titans for dominion over creation.</p><a href="#" class="myth-link reveal">Read the Full Myth →</a></div></div>' ] ],
			[ 'elType' => 'widget', 'widgetType' => 'html', 'settings' => [ 'html' => '<div class="myth-pair flip"><div><div class="myth-label reveal">The Prometheus Saga</div><h3 class="myth-title reveal">Fire Stolen from Heaven</h3><p class="myth-body reveal">Prometheus, the Titan trickster, defied the will of Zeus by stealing divine fire from the forge of Hephaestus.</p><a href="#" class="myth-link reveal">Read the Full Myth →</a></div><div class="myth-vis reveal"><div class="myth-vis-bg">🔥</div><div class="myth-vis-caption">Prometheus & the Eternal Flame</div></div></div>' ] ],
		];
	}

	protected function get_default_repeater_title_setting_key() {
		return '';
	}

	protected function render() {
		?>
		<section class="sec myths site-body">
			<div class="sec-inner">
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
		<?php
	}

	protected function content_template() {
		?>
		<section class="sec myths site-body">
			<div class="sec-inner">
				<div class="elementor-child-contents"></div>
			</div>
		</section>
		<?php
	}
}
