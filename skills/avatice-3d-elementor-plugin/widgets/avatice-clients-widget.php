<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class Avatice_Clients_Widget extends \Elementor\Widget_Base {
	public function get_name() { return 'avatice_clients'; }
	public function get_title() { return 'Avatice Clients Section'; }
	public function get_icon() { return 'eicon-gallery-grid'; }
	public function get_categories() { return [ 'general' ]; }

	protected function register_controls() {
		$this->start_controls_section('content', ['label' => 'Content']);
		$this->add_control('title', ['label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'معتمد بیشتر از 100 کسب و کار بزرگ']);
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<section class="avatice-section" data-stop="3" style="padding:60px 0;overflow:hidden; display:block;">
			<p class="avatice-reveal" style="text-align: center; color: #5a8aa0; margin: 0 0 28px; font-family: Vazirmatn; font-size: 25px; font-weight: 700; line-height: 1"><?php echo esc_html($settings['title']); ?></p>
			<div style="display:flex;width:max-content;gap:22px;animation:mqR 32s linear infinite;margin-bottom:18px">
				<div style="display:flex;gap:22px">
					<?php for($i=0; $i<10; $i++): ?>
						<div style="width: 150px; height: 64px; border-radius: 14px; border: 1px dashed rgba(255,255,255,.16); background: rgba(255,255,255,0.04); display: flex; align-items: center; justify-content: center; font: 700 10px 'Space Mono'; color: #5a7585; opacity: 0.5">LOGO <?php echo $i; ?></div>
					<?php endfor; ?>
				</div>
			</div>
		</section>
		<?php
	}
}
