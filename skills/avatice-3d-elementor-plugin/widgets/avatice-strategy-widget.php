<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class Avatice_Strategy_Widget extends \Elementor\Widget_Base {
	public function get_name() { return 'avatice_strategy'; }
	public function get_title() { return 'Avatice Strategy Section'; }
	public function get_icon() { return 'eicon-info-box'; }
	public function get_categories() { return [ 'general' ]; }

	protected function register_controls() {
		$this->start_controls_section('content', ['label' => 'Content']);
		$this->add_control('title', ['label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'دیگه طراحی سایت و اجرای تبلیغات جواب نمیده']);
		$this->add_control('subtitle', ['label' => 'Subtitle', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'در عوض از استراتژی زیر استفاده کنید — ویدئوی پایین را تماشا کنید']);
		$this->add_control('video_id', ['label' => 'Video Placeholder Text', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'APARAT EMBED · yta05fa']);
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<section class="avatice-section" data-stop="2">
			<div style="max-width:880px;margin:0 auto;text-align:center;width:100%">
				<h2 class="avatice-reveal" style="margin:0;font:800 clamp(24px,3vw,38px)/1.4 Vazirmatn;color:white;"><?php echo esc_html($settings['title']); ?></h2>
				<p class="avatice-reveal" style="margin:14px 0 30px;font:500 17px Vazirmatn;color:#a9c4d2"><?php echo esc_html($settings['subtitle']); ?></p>
				<div class="avatice-reveal" style="position:relative;aspect-ratio:16/9;border-radius:20px;overflow:hidden;border:1px solid rgba(43,184,236,.25);background:repeating-linear-gradient(135deg,rgba(255,255,255,.05) 0 12px,transparent 12px 24px);display:flex;align-items:center;justify-content:center;box-shadow:0 30px 80px rgba(0,0,0,.5)">
					<div style="width:74px;height:74px;border-radius:50%;background:rgba(43,184,236,.9);display:flex;align-items:center;justify-content:center;box-shadow:0 0 40px rgba(43,184,236,.6)"><div style="width:0;height:0;border-top:14px solid transparent;border-bottom:14px solid transparent;border-right:22px solid #04121b;margin-right:-4px"></div></div>
					<div style="position:absolute;bottom:14px;font:700 11px 'Space Mono',monospace;color:#6f93a6"><?php echo esc_html($settings['video_id']); ?></div>
				</div>
			</div>
		</section>
		<?php
	}
}
