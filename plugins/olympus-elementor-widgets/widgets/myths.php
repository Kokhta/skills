<?php
if ( ! defined( 'ABSPATH' ) ) {
	return;
}

class Olympus_Myths_Widget extends \Elementor\Widget_Base {

	public function get_name() { return 'olympus_myths'; }
	public function get_title() { return esc_html__( 'Olympus Myths', 'olympus-elementor' ); }
	public function get_icon() { return 'eicon-image-box'; }
	public function get_categories() { return [ 'olympus' ]; }

	protected function register_controls() {
		$this->start_controls_section( 'section_header', [ 'label' => 'Header' ] );
		$this->add_control( 'label', [ 'label' => 'Label', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Sacred Tales' ] );
		$this->add_control( 'title', [ 'label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'The Great Myths' ] );
		$this->end_controls_section();

		$this->start_controls_section( 'section_myths', [ 'label' => 'Myths' ] );
		$repeater = new \Elementor\Repeater();
		$repeater->add_control( 'myth_label', [ 'label' => 'Label', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'The Titanomachy' ] );
		$repeater->add_control( 'myth_title', [ 'label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'The War That Shaped Creation' ] );
		$repeater->add_control( 'myth_body', [ 'label' => 'Body', 'type' => \Elementor\Controls_Manager::WYSIWYG, 'default' => '...' ] );
		$repeater->add_control( 'myth_link', [ 'label' => 'Link URL', 'type' => \Elementor\Controls_Manager::URL, 'default' => [ 'url' => '#' ] ] );
		$repeater->add_control( 'myth_link_text', [ 'label' => 'Link Text', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Read the Full Myth →' ] );
		$repeater->add_control( 'myth_image', [ 'label' => 'Image', 'type' => \Elementor\Controls_Manager::MEDIA ] );
		$repeater->add_control( 'myth_symbol', [ 'label' => 'Symbol', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '⚡' ] );
		$repeater->add_control( 'myth_caption', [ 'label' => 'Caption', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'The War of the Titans' ] );
		$repeater->add_control( 'myth_flip', [ 'label' => 'Flip Layout', 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'flip', 'default' => '' ] );
		$this->add_control( 'myths_list', [ 'label' => 'Myths List', 'type' => \Elementor\Controls_Manager::REPEATER, 'fields' => $repeater->get_controls(), 'title_field' => '{{{ myth_title }}}' ] );
		$this->end_controls_section();

		$this->start_controls_section( 'section_style', [ 'label' => 'Style', 'tab' => \Elementor\Controls_Manager::TAB_STYLE ] );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [ 'name' => 'title_tg', 'label' => 'Title Typography', 'selector' => '{{WRAPPER}} .ol-sec-title, {{WRAPPER}} .ol-myth-title' ] );
		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [ 'name' => 'body_tg', 'label' => 'Body Typography', 'selector' => '{{WRAPPER}} .ol-myth-body' ] );
		$this->add_control( 'accent_color', [ 'label' => 'Accent Color', 'type' => \Elementor\Controls_Manager::COLOR, 'default' => '#C9A227', 'selectors' => [
			'{{WRAPPER}} .ol-sec-label' => 'color: {{VALUE}}',
			'{{WRAPPER}} .ol-myth-label' => 'color: {{VALUE}}',
			'{{WRAPPER}} .ol-myth-link' => 'color: {{VALUE}}; border-color: {{VALUE}}'
		] ] );
		$this->add_responsive_control( 'padding', [ 'label' => 'Padding', 'type' => \Elementor\Controls_Manager::DIMENSIONS, 'selectors' => [ '{{WRAPPER}} .ol-myths' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}' ] ] );
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<section class="ol-sec ol-myths" id="myths">
			<div class="ol-sec-inner">
				<div class="ol-sec-label ol-reveal"><?php echo esc_html( $settings['label'] ); ?></div>
				<h2 class="ol-sec-title ol-reveal"><?php echo esc_html( $settings['title'] ); ?></h2>
				<?php foreach ( $settings['myths_list'] as $myth ) : ?>
					<div class="ol-myth-pair <?php echo esc_attr($myth['myth_flip']); ?>">
						<?php if ( $myth['myth_flip'] !== 'flip' ) : ?>
							<div class="ol-myth-vis ol-reveal"><?php if ( !empty($myth['myth_image']['url']) ) : ?><img src="<?php echo esc_url($myth['myth_image']['url']); ?>" alt=""><?php else : ?><div class="ol-myth-vis-bg"><?php echo esc_html($myth['myth_symbol']); ?></div><?php endif; ?><div class="ol-myth-vis-caption"><?php echo esc_html($myth['myth_caption']); ?></div></div>
						<?php endif; ?>
						<div>
							<div class="ol-myth-label ol-reveal"><?php echo esc_html( $myth['myth_label'] ); ?></div>
							<h3 class="ol-myth-title ol-reveal"><?php echo esc_html( $myth['myth_title'] ); ?></h3>
							<div class="ol-myth-body ol-reveal"><?php echo $myth['myth_body']; ?></div>
							<a href="<?php echo esc_url($myth['myth_link']['url']); ?>" class="ol-myth-link ol-reveal"><?php echo esc_html( $myth['myth_link_text'] ); ?></a>
						</div>
						<?php if ( $myth['myth_flip'] === 'flip' ) : ?>
							<div class="ol-myth-vis ol-reveal"><?php if ( !empty($myth['myth_image']['url']) ) : ?><img src="<?php echo esc_url($myth['myth_image']['url']); ?>" alt=""><?php else : ?><div class="ol-myth-vis-bg"><?php echo esc_html($myth['myth_symbol']); ?></div><?php endif; ?><div class="ol-myth-vis-caption"><?php echo esc_html($myth['myth_caption']); ?></div></div>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
		</section>
		<?php
	}
}
