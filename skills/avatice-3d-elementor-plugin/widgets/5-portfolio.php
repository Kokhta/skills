<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class Avatice_Portfolio_Widget extends \Elementor\Widget_Base {
	public function get_name() { return 'avatice_portfolio'; }
	public function get_title() { return '5-Portfolio'; }
	public function get_icon() { return 'eicon-image-box'; }
	public function get_categories() { return [ 'general' ]; }

	protected function register_controls() {
		$this->start_controls_section('content', ['label' => 'Content']);
		$this->add_control('title', ['label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'تعدادی از وب‌سایت‌های طراحی‌شده توسط تیم ما']);
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<section class="avatice-section" data-stop="6">
			<div style="max-width:1000px;margin:0 auto;width:100%;text-align:center">
				<h2 class="avatice-reveal" style="margin:0;font:800 clamp(24px,3.2vw,40px)/1.4 Vazirmatn;color:white;"><?php echo esc_html($settings['title']); ?></h2>
				<div class="avatice-reveal" style="display:flex;justify-content:center;gap:22px;flex-wrap:wrap;margin:22px 0 36px">
					<span style="display:inline-flex;align-items:center;gap:7px;font:600 14px Vazirmatn;color:#cfeefb"><span style="color:#2bb8ec">✓</span> سرعت بالا</span>
					<span style="display:inline-flex;align-items:center;gap:7px;font:600 14px Vazirmatn;color:#cfeefb"><span style="color:#2bb8ec">✓</span> رعایت سئو اولیه</span>
					<span style="display:inline-flex;align-items:center;gap:7px;font:600 14px Vazirmatn;color:#cfeefb"><span style="color:#2bb8ec">✓</span> طراحی رسپانسیو</span>
				</div>
				<div class="avatice-reveal" style="display:flex;justify-content:center;align-items:flex-end;gap:24px;perspective:1200px;flex-wrap:wrap">
					<div style="width: 200px; height: 360px; border-radius: 18px; border: 1px dashed rgba(43,184,236,.35); background: rgba(43,184,236,0.1); box-shadow: 0 36px 70px rgba(0,0,0,.55);"></div>
					<div style="width: 200px; height: 360px; border-radius: 18px; border: 1px dashed rgba(43,184,236,.35); background: rgba(43,184,236,0.1); box-shadow: 0 36px 70px rgba(0,0,0,.55);"></div>
				</div>
			</div>
		</section>
		<?php
	}
}
