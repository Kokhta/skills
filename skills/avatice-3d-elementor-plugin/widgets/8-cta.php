<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class Avatice_CTA_Widget extends \Elementor\Widget_Base {
	public function get_name() { return 'avatice_cta'; }
	public function get_title() { return '8-CTA'; }
	public function get_icon() { return 'eicon-call-to-action'; }
	public function get_categories() { return [ 'general' ]; }

	protected function register_controls() {
		$this->start_controls_section('content', ['label' => 'Content']);
		$this->add_control('title', ['label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'ما بــرای شما فرصت‌ها را شــکــار می‌کنیم']);
		$this->add_control('subtitle', ['label' => 'Subtitle', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'بزرگ‌ترین و بیشترین ســهــم از بازارتان برای شماست...']);
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<section id="cta" class="avatice-section" data-stop="9">
			<div style="max-width:680px;margin:0 auto;width:100%;text-align:center">
				<h2 class="avatice-reveal" style="margin:0;font:800 clamp(28px,3.6vw,46px)/1.3 Vazirmatn; color:white;"><?php echo esc_html($settings['title']); ?></h2>
				<p class="avatice-reveal" style="margin:16px 0 32px;font:500 16px/1.9 Vazirmatn;color:#a9c4d2"><?php echo esc_html($settings['subtitle']); ?></p>
				<div id="form-cta-3d-bottom" style="width:100%;height:450px;position:relative;display:flex;align-items:center;justify-content:center;font:700 20px Vazirmatn;color:#2bb8ec">فرم هوشمند تماس آواتک</div>
			</div>
		</section>
		<?php
	}
}
