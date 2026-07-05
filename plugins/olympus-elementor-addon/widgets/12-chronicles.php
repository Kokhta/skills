<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Olympus_12_Chronicles_Widget extends \Elementor\Widget_Base {

	public function get_name() { return '12-chronicles'; }
	public function get_title() { return esc_html__( '12. Olympus Chronicles', 'olympus-elementor-addon' ); }
	public function get_icon() { return 'eicon-time-line'; }
	public function get_categories() { return [ 'general' ]; }
	public function get_script_depends() { return [ 'olympus-scripts' ]; }

	protected function register_controls() {
		$this->start_controls_section('section_header', ['label' => esc_html__( 'Header', 'olympus-elementor-addon' ), 'tab' => \Elementor\Controls_Manager::TAB_CONTENT]);
		$this->add_control('label', ['label' => 'Label', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'The Age of Gods']);
		$this->add_control('title', ['label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Chronicles of Olympus']);
		$this->add_control('subtitle', ['label' => 'Subtitle', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'From the birth of the cosmos...']);
		$this->end_controls_section();

		$this->start_controls_section('section_timeline', ['label' => 'Timeline', 'tab' => \Elementor\Controls_Manager::TAB_CONTENT]);
		$repeater = new \Elementor\Repeater();
		$repeater->add_control('item_date', ['label' => 'Date/Era', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Before Time']);
		$repeater->add_control('item_event', ['label' => 'Event', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'The Birth of Chaos']);
		$repeater->add_control('item_desc', ['label' => 'Description', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Before existence itself...']);
		$repeater->add_control('item_align', ['label' => 'Alignment', 'type' => \Elementor\Controls_Manager::SELECT, 'options' => ['left' => 'Left', 'right' => 'Right'], 'default' => 'left']);
		$this->add_control('items', ['label' => 'Timeline Items', 'type' => \Elementor\Controls_Manager::REPEATER, 'fields' => $repeater->get_controls(), 'default' => [['item_event' => 'The Birth of Chaos', 'item_align' => 'left']], 'title_field' => '{{{ item_event }}}']);
		$this->end_controls_section();
		olympus_add_theme_control($this);
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$theme_class = olympus_get_theme_class($settings);
		?>
		<section class="ol-sec ol-chronicles <?php echo esc_attr($theme_class); ?>" id="chronicles">
			<div class="ol-sec-inner">
				<div style="max-width: 820px; margin: 0 auto;">
					<div class="ol-sec-label ol-reveal"><?php echo esc_html( $settings['label'] ); ?></div>
					<h2 class="ol-sec-title ol-reveal"><?php echo esc_html( $settings['title'] ); ?></h2>
					<p class="ol-sec-sub ol-reveal"><?php echo esc_html( $settings['subtitle'] ); ?></p>
					<div class="ol-timeline">
						<?php foreach ( $settings['items'] as $item ) : ?>
							<div class="ol-tl-item">
								<div class="ol-tl-left"><?php if ( 'left' === $item['item_align'] ) : ?><div class="ol-tl-date ol-reveal"><?php echo esc_html( $item['item_date'] ); ?></div><div class="ol-tl-event ol-reveal"><?php echo esc_html( $item['item_event'] ); ?></div><p class="ol-tl-desc ol-reveal"><?php echo esc_html( $item['item_desc'] ); ?></p><?php endif; ?></div>
								<div class="ol-tl-dot ol-reveal"></div>
								<div class="ol-tl-right"><?php if ( 'right' === $item['item_align'] ) : ?><div class="ol-tl-date ol-reveal"><?php echo esc_html( $item['item_date'] ); ?></div><div class="ol-tl-event ol-reveal"><?php echo esc_html( $item['item_event'] ); ?></div><p class="ol-tl-desc ol-reveal"><?php echo esc_html( $item['item_desc'] ); ?></p><?php endif; ?></div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</section>
		<?php
	}

	protected function content_template() {
		?>
		<# var themeClass = settings.widget_theme !== 'inherit' ? 'ol-theme-' + settings.widget_theme : ''; #>
		<section class="ol-sec ol-chronicles {{ themeClass }}">
			<div class="ol-sec-inner">
				<div style="max-width: 820px; margin: 0 auto;">
					<div class="ol-sec-label ol-reveal">{{{ settings.label }}}</div>
					<h2 class="ol-sec-title ol-reveal">{{{ settings.title }}}</h2>
					<div class="ol-timeline">
						<# _.each( settings.items, function( item ) { #>
							<div class="ol-tl-item">
								<div class="ol-tl-left"><# if ( item.item_align === 'left' ) { #><div class="ol-tl-date ol-reveal">{{{ item.item_date }}}</div><div class="ol-tl-event ol-reveal">{{{ item.item_event }}}</div><p class="ol-tl-desc ol-reveal">{{{ item.item_desc }}}</p><# } #></div>
								<div class="ol-tl-dot ol-reveal"></div>
								<div class="ol-tl-right"><# if ( item.item_align === 'right' ) { #><div class="ol-tl-date ol-reveal">{{{ item.item_date }}}</div><div class="ol-tl-event ol-reveal">{{{ item.item_event }}}</div><p class="ol-tl-desc ol-reveal">{{{ item.item_desc }}}</p><# } #></div>
							</div>
						<# } ); #>
					</div>
				</div>
			</div>
		</section>
		<?php
	}
}
