<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class Avatice_Testimonials_Widget extends \Elementor\Widget_Base {
	public function get_name() { return 'avatice_testimonials'; }
	public function get_title() { return '6-Testimonials'; }
	public function get_icon() { return 'eicon-testimonial'; }
	public function get_categories() { return [ 'general' ]; }

	protected function register_controls() {
		$this->start_controls_section('content', ['label' => 'Content']);
		$this->add_control('title', ['label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'حرف‌های ما را باور نکنید! حرف کسانی که با ما کار کرده‌اند را نگاه کنید.']);
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<section class="avatice-section" data-stop="7">
			<div style="max-width:760px;margin:0 auto;width:100%;text-align:center">
				<div class="avatice-reveal" style="display:flex;flex-direction:column;align-items:center;gap:14px;margin-bottom:34px">
					<div style="width:74px;height:74px;border-radius:50%;border:1px dashed rgba(43,184,236,.4);display:flex;align-items:center;justify-content:center;font-size:34px;animation:pulseB 2.4s ease-in-out infinite">🙅‍♂️</div>
					<p style="margin:0;font:700 19px/1.6 Vazirmatn;max-width:520px; color:white;"><?php echo esc_html($settings['title']); ?></p>
				</div>
				<div class="avatice-reveal" style="position:relative;padding:34px 30px 30px;background:rgba(8,14,20,.6);backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px);border:1px solid rgba(43,184,236,.22);border-radius:24px;box-shadow:0 30px 80px rgba(0,0,0,.5);min-height:250px;">
					<p style="margin:0 0 22px;font:400 16px/2 Vazirmatn;color:#dcecf3;">اگر نخوام تبلیغاتی حرف بزنم، واقعاً همکاری با سجاد شعیب و تیمش خیلی هیجان‌انگیزه...</p>
					<div style="display:flex;align-items:center;gap:14px;justify-content:center">
						<div style="text-align:right">
							<div style="font:700 16px Vazirmatn;color:#eaf6fb">محسن کاوشی</div>
							<div style="font:500 12px Vazirmatn;color:#88a6b6;margin:3px 0">مدیر مارکتینگ لینگامو</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<?php
	}
}
