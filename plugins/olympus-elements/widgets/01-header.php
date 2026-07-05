<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Modules\NestedElements\Base\Widget_Nested_Base;

class Olympus_01_Header_Widget extends Widget_Nested_Base {

	public function get_name() {
		return 'olympus-header';
	}

	public function get_title() {
		return esc_html__( '01-Header', 'olympus-elements' );
	}

	public function get_icon() {
		return 'eicon-header';
	}

	public function get_categories() {
		return [ 'olympus' ];
	}

	protected function get_default_children_config() {
		return [];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Content', 'olympus-elements' ),
			]
		);

		$this->add_control(
			'logo_text',
			[
				'label' => esc_html__( 'Logo Text', 'olympus-elements' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'OLYMPUS', 'olympus-elements' ),
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'text',
			[
				'label' => esc_html__( 'Text', 'olympus-elements' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'The Gods', 'olympus-elements' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'link',
			[
				'label' => esc_html__( 'Link', 'olympus-elements' ),
				'type' => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'olympus-elements' ),
				'default' => [
					'url' => '#pantheon',
				],
			]
		);

		$this->add_control(
			'menu_items',
			[
				'label' => esc_html__( 'Menu Items', 'olympus-elements' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[ 'text' => esc_html__( 'The Gods', 'olympus-elements' ), 'link' => [ 'url' => '#pantheon' ] ],
					[ 'text' => esc_html__( 'Myths', 'olympus-elements' ), 'link' => [ 'url' => '#myths' ] ],
					[ 'text' => esc_html__( 'Oracle', 'olympus-elements' ), 'link' => [ 'url' => '#oracle' ] ],
					[ 'text' => esc_html__( 'Chronicles', 'olympus-elements' ), 'link' => [ 'url' => '#chronicles' ] ],
				],
				'title_field' => '{{{ text }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_logo',
			[
				'label' => esc_html__( 'Logo', 'olympus-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'logo_color',
			[
				'label' => esc_html__( 'Color', 'olympus-elements' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .nav-logo' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'logo_typography',
				'selector' => '{{WRAPPER}} .nav-logo',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_menu',
			[
				'label' => esc_html__( 'Menu Items', 'olympus-elements' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'menu_color',
			[
				'label' => esc_html__( 'Color', 'olympus-elements' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .nav-links a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'menu_hover_color',
			[
				'label' => esc_html__( 'Hover Color', 'olympus-elements' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .nav-links a:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .nav-links a:hover::after' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'menu_typography',
				'selector' => '{{WRAPPER}} .nav-links a',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<nav class=\"nav\" id=\"nav\">
			<a href=\"#\" class=\"nav-logo\"><?php echo esc_html( $settings['logo_text'] ); ?></a>
			<?php if ( $settings['menu_items'] ) : ?>
				<ul class=\"nav-links\">
					<?php foreach ( $settings['menu_items'] as $item ) :
						$target = $item['link']['is_external'] ? ' target=\"_blank\"' : '';
						$nofollow = $item['link']['nofollow'] ? ' rel=\"nofollow\"' : '';
						?>
						<li><a href=\"<?php echo esc_url( $item['link']['url'] ); ?>\"<?php echo $target . $nofollow; ?>><?php echo esc_html( $item['text'] ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</nav>
		<div class=\"ol-nested-container\">
			<?php $this->print_child_elements(); ?>
		</div>
		<?php
	}

	protected function content_template() {
		?>
		<nav class=\"nav\" id=\"nav\">
			<a href=\"#\" class=\"nav-logo\">{{{ settings.logo_text }}}</a>
			<# if ( settings.menu_items.length ) { #>
				<ul class=\"nav-links\">
					<# _.each( settings.menu_items, function( item ) { #>
						<li><a href=\"{{{ item.link.url }}}\">{{{ item.text }}}</a></li>
					<# } ); #>
				</ul>
			<# } #>
		</nav>
		<div class=\"ol-nested-container\">
			{{{ view.getEditModel().get( 'elements' ).models }}}
		</div>
		<?php
	}
}
