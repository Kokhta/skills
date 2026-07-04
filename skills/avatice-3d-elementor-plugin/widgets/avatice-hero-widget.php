<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class Avatice_Hero_Widget extends \Elementor\Widget_Base {
	public function get_name() { return 'avatice_hero'; }
	public function get_title() { return 'Avatice Hero Section'; }
	public function get_icon() { return 'eicon-header'; }
	public function get_categories() { return [ 'general' ]; }

	protected function register_controls() {
		$this->start_controls_section('content', ['label' => 'Content']);
		$this->add_control('badge', ['label' => 'Badge Text', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '٪۱۰۰ تــســت شـــده']);
		$this->add_control('title', ['label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'جذب منظم و هفتگی مشتریان جدید برای کسب و کار شما']);
		$this->add_control('description', ['label' => 'Description', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'بازاریابی و پیدا کردن مشتریان جدید برای کسب‌وکارها سخت شده است...']);
		$this->add_control('footer_text', ['label' => 'Footer Text', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'بیش از ۲۴۷ نظر مثبت']);
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<section id="hero" class="avatice-section" data-stop="1">
			<div class="avatice-reveal" style="max-width:1080px;margin:0 auto;display:grid;grid-template-columns:1.05fr .95fr;gap:40px;align-items:center;width:100%">
				<div>
					<div style="display:inline-flex;align-items:center;gap:7px;padding:7px 14px;border-radius:999px;border:1px solid rgba(43,184,236,.3);background:rgba(43,184,236,.08);font:600 12px 'Space Mono',monospace;color:#8fd6f4;margin-bottom:18px"><?php echo esc_html($settings['badge']); ?></div>
					<h1 style="margin:0;font:800 clamp(30px,4vw,50px)/1.25 Vazirmatn;color:white;"><?php echo esc_html($settings['title']); ?></h1>
					<p style="margin:18px 0 0;font:400 15px/1.95 Vazirmatn;color:#a9c4d2;max-width:540px"><?php echo esc_html($settings['description']); ?></p>
					<div style="display:flex;align-items:center;gap:12px;margin-top:24px">
						<div style="font:600 13px Vazirmatn;color:#cfeefb"><?php echo esc_html($settings['footer_text']); ?> <span style="color:#ffc64a">★★★★★</span></div>
					</div>
				</div>
				<div id="form-hero-3d" style="width:100%;height:450px;position:relative;display:flex;align-items:center;justify-content:center;font:700 20px Vazirmatn;color:#2bb8ec">3D INTERACTIVE INTERFACE</div>
			</div>
		</section>
		<?php
	}
}
