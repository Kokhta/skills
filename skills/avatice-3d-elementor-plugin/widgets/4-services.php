<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class Avatice_Services_Widget extends \Elementor\Widget_Base {
	public function get_name() { return 'avatice_services'; }
	public function get_title() { return '4-Services'; }
	public function get_icon() { return 'eicon-bullet-list'; }
	public function get_categories() { return [ 'general' ]; }

	protected function register_controls() {
		$this->start_controls_section('content', ['label' => 'Content']);
		$this->add_control('title', ['label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'خـــدمـــات مـــا چــیســـت؟']);
		$this->add_control('subtitle', ['label' => 'Subtitle', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'ما فقط ۲ سرویس داریم — و خدماتی را که از آن مطمئن نباشیم ارائه نمی‌دهیم']);
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<section class="avatice-section" data-stop="4">
			<div style="max-width:1000px;margin:0 auto;width:100%">
				<div class="avatice-reveal" style="text-align:center;margin-bottom:40px">
					<h2 style="margin:0;font:800 clamp(26px,3.4vw,42px) Vazirmatn;color:white;"><?php echo esc_html($settings['title']); ?></h2>
					<p style="margin:14px 0 0;font:500 16px/1.9 Vazirmatn;color:#a9c4d2"><?php echo esc_html($settings['subtitle']); ?></p>
				</div>
				<div style="display:grid;grid-template-columns:1fr 1fr;gap:24px">
					<div id="form-cta-3d-top" style="width:100%;height:450px;position:relative;display:flex;align-items:center;justify-content:center;font:700 20px Vazirmatn;color:#2bb8ec">درگاه تعاملی ثبت درخواست</div>
				</div>
			</div>
		</section>
		<?php
	}
}
