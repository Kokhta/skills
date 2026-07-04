<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class Avatice_Footer_Widget extends \Elementor\Widget_Base {
	public function get_name() { return 'avatice_footer'; }
	public function get_title() { return '9-Footer'; }
	public function get_icon() { return 'eicon-footer'; }
	public function get_categories() { return [ 'general' ]; }

	protected function register_controls() {
		$this->start_controls_section('content', ['label' => 'Content']);
		$this->add_control('description', ['label' => 'Description', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'آژانس دیجیتال مارکتینگ آواتک افتخار فعالیت از سال ۱۳۹۸ با همکاری با بیش از صد مشتری و رشد کسب‌وکارهای آنلاین را دارد.']);
		$this->add_control('copyright', ['label' => 'Copyright Text', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '© Copyright 2026 powered by Avatice.com']);
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<footer class="avatice-section" data-stop="10" style="position:relative;padding:60px 24px 30px;background:linear-gradient(180deg,rgba(8,14,20,.4),rgba(7,10,15,.95));border-top:1px solid rgba(43,184,236,.15); display:block;">
			<div style="max-width:1040px;margin:0 auto;display:grid;grid-template-columns:1.6fr 1fr 1fr 1.1fr;gap:36px">
				<div>
					<p style="margin:0;font:400 13px/1.95 Vazirmatn;color:#88a6b6;max-width:300px"><?php echo esc_html($settings['description']); ?></p>
				</div>
				<div>
					<h4 style="margin:0 0 14px;font:700 14px Vazirmatn;color:#eaf6fb">صفحات</h4>
					<div style="display:flex;flex-direction:column;gap:10px;font:400 13px Vazirmatn">
						<a href="#hero" style="color:#a9c4d2;text-decoration:none">خانه</a>
					</div>
				</div>
                <div>
					<h4 style="margin:0 0 14px;font:700 14px Vazirmatn;color:#eaf6fb">خدمات</h4>
					<div style="display:flex;flex-direction:column;gap:10px;font:400 13px Vazirmatn">
						<a href="#" style="color:#a9c4d2;text-decoration:none">طراحی وب‌سایت</a>
					</div>
				</div>
                <div>
					<h4 style="margin:0 0 14px;font:700 14px Vazirmatn;color:#eaf6fb">ارتباط با ما</h4>
                    <div style="display:flex;flex-direction:column;gap:10px;font:400 13px 'Space Mono',monospace;color:#a9c4d2;direction:ltr;text-align:right">
                        <span>0996 633 0107</span>
                    </div>
				</div>
			</div>
			<div style="max-width:1040px;margin:30px auto 0;padding-top:20px;border-top:1px solid rgba(255,255,255,.08);text-align:center;font:400 12px 'Space Mono',monospace;color:#5a7585;direction:ltr"><?php echo esc_html($settings['copyright']); ?></div>
		</footer>
		<?php
	}
}
