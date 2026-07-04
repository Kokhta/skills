<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class Avatice_Differentiation_Widget extends \Elementor\Widget_Base {
	public function get_name() { return 'avatice_differentiation'; }
	public function get_title() { return 'Avatice Differentiation Section'; }
	public function get_icon() { return 'eicon-skill-bar'; }
	public function get_categories() { return [ 'general' ]; }

	protected function register_controls() {
		$this->start_controls_section('content', ['label' => 'Content']);
		$this->add_control('title', ['label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'متفاوت نبودن در دنیای کسب‌وکار یعنی خودکشی!']);
		$this->add_control('description', ['label' => 'Description', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'کسب‌وکار شما در میان انبوه تبلیغات و شلوغی‌ها دیده نمی‌شود، مگر آنکه متفاوت باشید...']);
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<section class="avatice-section" data-stop="8">
			<div style="max-width:1000px;margin:0 auto;display:grid;grid-template-columns:1fr 1fr;gap:48px;align-items:center;width:100%">
				<div class="avatice-reveal">
					<h2 style="margin:0;font:800 clamp(26px,3.4vw,42px)/1.35 Vazirmatn; color:white;"><?php echo esc_html($settings['title']); ?></h2>
					<p style="margin:18px 0 26px;font:400 15px/1.95 Vazirmatn;color:#a9c4d2"><?php echo esc_html($settings['description']); ?></p>
					<a href="#cta" style="display:inline-flex;align-items:center;gap:8px;padding:15px 26px;border-radius:12px;background:linear-gradient(135deg,#2bb8ec,#1273a8);color:#04121b;font:700 15px Vazirmatn;text-decoration:none;box-shadow:0 10px 30px rgba(43,184,236,.4)">برای شروع همکاری کلیک کنید</a>
				</div>
				<div class="avatice-reveal" style="position:relative;border-radius:24px;border:1px dashed rgba(255,255,255,.2);background:rgba(255,255,255,0.05);aspect-ratio:1;display:flex;align-items:center;justify-content:center;">
					<div class="glb-placeholder" style="width:55%;height:200px;background:rgba(43,184,236,0.1);border-radius:20px;display:flex;align-items:center;justify-content:center;color:#2bb8ec;font-weight:bold">3D LOGO VIEW</div>
				</div>
			</div>
		</section>
		<?php
	}
}
