<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Avatice_Canvas_Core_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'avatice_canvas_core';
	}

	public function get_title() {
		return esc_html__( '0-Canvas Core', 'avatice-3d' );
	}

	public function get_icon() {
		return 'eicon-code';
	}

	public function get_categories() {
		return [ 'general' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_3d_settings',
			[
				'label' => esc_html__( '3D Scene Settings', 'avatice-3d' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'fog_color',
			[
				'label' => esc_html__( 'Fog Color', 'avatice-3d' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#070a0f',
			]
		);

		$this->add_control(
			'primary_light_color',
			[
				'label' => esc_html__( 'Primary Light Color', 'avatice-3d' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#2bb8ec',
			]
		);

        $this->add_control(
			'secondary_light_color',
			[
				'label' => esc_html__( 'Secondary Light Color', 'avatice-3d' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#7fe0ff',
			]
		);

        $this->add_control(
			'scroll_speed',
			[
				'label' => esc_html__( 'Scroll Smoothing', 'avatice-3d' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0.01,
						'max' => 0.2,
						'step' => 0.01,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0.04,
				],
			]
		);

        $this->add_control(
			'icon_count',
			[
				'label' => esc_html__( 'Floating Icons Count', 'avatice-3d' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 10,
				'max' => 200,
				'step' => 10,
				'default' => 60,
			]
		);

        $this->add_control(
			'camera_fov',
			[
				'label' => esc_html__( 'Camera FOV', 'avatice-3d' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 30,
						'max' => 120,
					],
				],
				'default' => [
					'size' => 62,
				],
			]
		);

		$this->end_controls_section();

        $this->start_controls_section(
			'section_overlay_settings',
			[
				'label' => esc_html__( 'Overlay & Background', 'avatice-3d' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

        $this->add_control(
			'overlay_color',
			[
				'label' => esc_html__( 'Radial Overlay Color', 'avatice-3d' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => 'rgba(7,10,15,0.55)',
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
			'section_header_settings',
			[
				'label' => esc_html__( 'Header Settings', 'avatice-3d' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

        $this->add_control(
			'logo',
			[
				'label' => esc_html__( 'Logo', 'avatice-3d' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
			]
		);

        $this->add_control(
			'brand_name',
			[
				'label' => esc_html__( 'Brand Name', 'avatice-3d' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'AVATIC',
			]
		);

        $this->add_control(
			'brand_subtext',
			[
				'label' => esc_html__( 'Brand Subtext', 'avatice-3d' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'آواتـک',
			]
		);

        $this->add_control(
			'cta_text',
			[
				'label' => esc_html__( 'CTA Button Text', 'avatice-3d' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'دوره تــورنــادو',
			]
		);

        $this->add_control(
			'cta_url',
			[
				'label' => esc_html__( 'CTA Button URL', 'avatice-3d' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'avatice-3d' ),
				'default' => [
					'url' => '#cta',
				],
			]
		);

		$this->end_controls_section();

        $this->start_controls_section(
			'section_menu_settings',
			[
				'label' => esc_html__( 'Menu Settings', 'avatice-3d' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

        $this->add_control(
			'menu_title',
			[
				'label' => esc_html__( 'Menu Title', 'avatice-3d' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'بر روی گزینه مناسب و مورد نظر خود کلیک کنید',
			]
		);

        $repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'item_text', [
				'label' => esc_html__( 'Text', 'avatice-3d' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Menu Link' , 'avatice-3d' ),
				'label_block' => true,
			]
		);

        $repeater->add_control(
			'item_link', [
				'label' => esc_html__( 'Link', 'avatice-3d' ),
				'type' => \Elementor\Controls_Manager::URL,
				'label_block' => true,
			]
		);

		$this->add_control(
			'menu_items',
			[
				'label' => esc_html__( 'Menu Items', 'avatice-3d' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'item_text' => esc_html__( 'برای خرید دوره تــورنــادو', 'avatice-3d' ),
					],
                    [
						'item_text' => esc_html__( 'برای رزرو جلسه مـشـاوره', 'avatice-3d' ),
					],
				],
				'title_field' => '{{{ item_text }}}',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
        ?>
        <div class="avatice-3d-layout-wrapper"
             data-fog-color="<?php echo esc_attr($settings['fog_color']); ?>"
             data-light1="<?php echo esc_attr($settings['primary_light_color']); ?>"
             data-light2="<?php echo esc_attr($settings['secondary_light_color']); ?>"
             data-smoothing="<?php echo esc_attr($settings['scroll_speed']['size']); ?>"
             data-icon-count="<?php echo esc_attr($settings['icon_count']); ?>"
             data-fov="<?php echo esc_attr($settings['camera_fov']['size']); ?>">

            <canvas id="avatice-3d-canvas" class="avatice-3d-canvas-container"></canvas>
            <div class="avatice-3d-overlay" style="background: radial-gradient(120% 90% at 50% 0%, transparent 40%, <?php echo esc_attr($settings['overlay_color']); ?> 100%);"></div>

            <!-- Rail UI -->
            <div class="avatice-3d-rail">
                <div style="font:700 8px 'Space Mono',monospace;color:#5a8aa0;letter-spacing:.1em;writing-mode:vertical-rl">Z-DEPTH</div>
                <div style="width:3px;height:170px;background:rgba(255,255,255,.1);border-radius:3px;position:relative;overflow:hidden">
                    <div id="avatice-rail-progress" style="position:absolute;left:0;right:0;top:0;height:8%;background:linear-gradient(#2bb8ec,#1273a8);border-radius:3px;transition:height .15s linear"></div>
                </div>
                <div id="avatice-rail-stop" style="font:700 9px 'Space Mono',monospace;color:#8fd6f4">01<span style="color:#4a6675">/10</span></div>
            </div>

            <!-- Header -->
            <header class="avatice-3d-header">
                <button class="avatice-toggle-menu" aria-label="menu" style="width:46px;height:46px;border-radius:13px;border:1px solid rgba(43,184,236,.3);background:rgba(8,14,20,.6);color:#8fd6f4;cursor:pointer;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:4px">
                    <span style="width:18px;height:2px;background:currentColor;border-radius:2px"></span>
                    <span style="width:18px;height:2px;background:currentColor;border-radius:2px"></span>
                    <span style="width:18px;height:2px;background:currentColor;border-radius:2px"></span>
                </button>
                <a href="#hero" style="display:flex;align-items:center;gap:9px;text-decoration:none">
                    <?php if ( ! empty( $settings['logo']['url'] ) ) : ?>
                        <img src="<?php echo esc_url($settings['logo']['url']); ?>" alt="Logo" style="height:42px;width:auto;">
                    <?php endif; ?>
                    <div style="line-height:1">
                        <div style="font:800 19px 'Space Mono',monospace;letter-spacing:.18em;color:#eaf6fb"><?php echo esc_html($settings['brand_name']); ?></div>
                        <div style="font:600 11px Vazirmatn;color:#5a8aa0;margin-top:2px"><?php echo esc_html($settings['brand_subtext']); ?></div>
                    </div>
                </a>
                <div style="display:flex;gap:10px">
                    <a href="<?php echo esc_url($settings['cta_url']['url']); ?>" class="avatice-btn-primary" style="display:inline-flex;align-items:center;padding:11px 18px;border-radius:11px;background:linear-gradient(135deg,#2bb8ec,#1273a8);color:#04121b;font:700 13px Vazirmatn;text-decoration:none;box-shadow:0 8px 24px rgba(43,184,236,.35)"><?php echo esc_html($settings['cta_text']); ?></a>
                </div>
            </header>

            <!-- Off-Canvas Menu -->
            <div class="avatice-menu-overlay" style="position: fixed; inset: 0; z-index: 49; background: rgba(3,6,10,.7); backdrop-filter: blur(4px); display: none;"></div>
            <aside class="avatice-sidebar" style="position:fixed;top:0;bottom:0;left:0;z-index:50;width:min(380px,86vw);padding:30px 26px;background:linear-gradient(160deg,#0b1219,#0a0f15);border-right:1px solid rgba(43,184,236,.25);transform:translateX(-100%);transition:transform .42s cubic-bezier(.5,.05,.2,1);display:flex;flex-direction:column;gap:18px;overflow-y:auto">
                <div style="display:flex;align-items:center;justify-content:space-between">
                    <?php if ( ! empty( $settings['logo']['url'] ) ) : ?>
                        <img src="<?php echo esc_url($settings['logo']['url']); ?>" alt="Logo" style="height:38px">
                    <?php endif; ?>
                    <button class="avatice-close-menu" style="width:40px;height:40px;border-radius:11px;border:1px solid rgba(255,255,255,0.16);background:rgba(255,255,255,0.04);color:#8fd6f4;font-size:18px;cursor:pointer">✕</button>
                </div>
                <h3 style="margin:6px 0 2px;font:700 16px Vazirmatn;color:#eaf6fb"><?php echo esc_html($settings['menu_title']); ?></h3>
                <?php foreach ( $settings['menu_items'] as $item ) : ?>
                    <a href="<?php echo esc_url($item['item_link']['url']); ?>" style="padding:15px 16px;border-radius:13px;border:1px solid rgba(43,184,236,0.22);background:rgba(43,184,236,0.07);color:#cfeefb;text-decoration:none;font:500 14px Vazirmatn"><?php echo esc_html($item['item_text']); ?></a>
                <?php endforeach; ?>
            </aside>
        </div>
        <script>
            jQuery(document).ready(function($) {
                $('.avatice-toggle-menu').on('click', function() {
                    $('.avatice-sidebar').css('transform', 'translateX(0)');
                    $('.avatice-menu-overlay').fadeIn();
                });
                $('.avatice-close-menu, .avatice-menu-overlay').on('click', function() {
                    $('.avatice-sidebar').css('transform', 'translateX(-100%)');
                    $('.avatice-menu-overlay').fadeOut();
                });
            });
        </script>
        <?php
	}
}
