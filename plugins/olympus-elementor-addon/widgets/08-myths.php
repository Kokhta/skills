<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Olympus_08_Myths_Widget extends \Elementor\Widget_Base {

	public function get_name() { return '08-myths'; }
	public function get_title() { return esc_html__( '08. Olympus Myths', 'olympus-elementor-addon' ); }
	public function get_icon() { return 'eicon-image-before-after'; }
	public function get_categories() { return [ 'general' ]; }
	public function get_script_depends() { return [ 'olympus-scripts' ]; }

	protected function register_controls() {
		$this->start_controls_section('section_header', ['label' => esc_html__( 'Header', 'olympus-elementor-addon' ), 'tab' => \Elementor\Controls_Manager::TAB_CONTENT]);
		$this->add_control('label', ['label' => esc_html__( 'Label', 'olympus-elementor-addon' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => esc_html__( 'Sacred Tales', 'olympus-elementor-addon' )]);
		$this->add_control('title', ['label' => esc_html__( 'Title', 'olympus-elementor-addon' ), 'type' => \Elementor\Controls_Manager::TEXT, 'default' => esc_html__( 'The Great Myths', 'olympus-elementor-addon' )]);
		$this->end_controls_section();

		$this->start_controls_section('section_myths', ['label' => esc_html__( 'Myths', 'olympus-elementor-addon' ), 'tab' => \Elementor\Controls_Manager::TAB_CONTENT]);
		$repeater = new \Elementor\Repeater();
		$repeater->add_control('myth_symbol', ['label' => 'Symbol', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '⚡']);
		$repeater->add_control('myth_caption', ['label' => 'Caption', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'The War of the Titans · c. 700 BCE']);
		$repeater->add_control('myth_label', ['label' => 'Label', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'The Titanomachy']);
		$repeater->add_control('myth_title', ['label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'The War That Shaped Creation']);
		$repeater->add_control('myth_body', ['label' => 'Body', 'type' => \Elementor\Controls_Manager::WYSIWYG, 'default' => 'For ten savage years...']);
		$repeater->add_control('myth_link', ['label' => 'Link', 'type' => \Elementor\Controls_Manager::URL, 'default' => ['url' => '#']]);
		$repeater->add_control('myth_reverse', ['label' => 'Reverse Layout', 'type' => \Elementor\Controls_Manager::SWITCHER, 'return_value' => 'flip', 'default' => '']);
		$this->add_control('myths', ['label' => 'Myth Pairs', 'type' => \Elementor\Controls_Manager::REPEATER, 'fields' => $repeater->get_controls(), 'default' => [['myth_symbol' => '⚡', 'myth_title' => 'The War That Shaped Creation']], 'title_field' => '{{{ myth_title }}}']);
		$this->end_controls_section();
		olympus_add_theme_control($this);
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$theme_class = olympus_get_theme_class($settings);
		?>
		<section class="ol-sec ol-myths <?php echo esc_attr($theme_class); ?>" id="myths">
			<div class="ol-sec-inner">
				<div class="ol-sec-label ol-reveal"><?php echo esc_html( $settings['label'] ); ?></div>
				<h2 class="ol-sec-title ol-reveal"><?php echo esc_html( $settings['title'] ); ?></h2>
				<?php foreach ( $settings['myths'] as $myth ) : ?>
					<div class="ol-myth-pair <?php echo esc_attr( $myth['myth_reverse'] ); ?>">
						<?php if ( 'flip' !== $myth['myth_reverse'] ) : ?>
							<div class="ol-myth-vis ol-reveal"><div class="ol-myth-vis-bg"><?php echo esc_html( $myth['myth_symbol'] ); ?></div><div class="ol-myth-vis-caption"><?php echo esc_html( $myth['myth_caption'] ); ?></div></div>
						<?php endif; ?>
						<div>
							<div class="ol-myth-label ol-reveal"><?php echo esc_html( $myth['myth_label'] ); ?></div>
							<h3 class="ol-myth-title ol-reveal"><?php echo esc_html( $myth['myth_title'] ); ?></h3>
							<div class="ol-myth-body ol-reveal"><?php echo wp_kses_post( $myth['myth_body'] ); ?></div>
							<?php if ( ! empty( $myth['myth_link']['url'] ) ) : ?>
								<a href="<?php echo esc_url( $myth['myth_link']['url'] ); ?>" class="ol-myth-link ol-reveal" <?php echo $myth['myth_link']['is_external'] ? 'target="_blank"' : ''; ?>>Read the Full Myth →</a>
							<?php endif; ?>
						</div>
						<?php if ( 'flip' === $myth['myth_reverse'] ) : ?>
							<div class="ol-myth-vis ol-reveal"><div class="ol-myth-vis-bg"><?php echo esc_html( $myth['myth_symbol'] ); ?></div><div class="ol-myth-vis-caption"><?php echo esc_html( $myth['myth_caption'] ); ?></div></div>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
		</section>
		<?php
	}

	protected function content_template() {
		?>
		<# var themeClass = settings.widget_theme !== 'inherit' ? 'ol-theme-' + settings.widget_theme : ''; #>
		<section class="ol-sec ol-myths {{ themeClass }}">
			<div class="ol-sec-inner">
				<div class="ol-sec-label ol-reveal">{{{ settings.label }}}</div>
				<h2 class="ol-sec-title ol-reveal">{{{ settings.title }}}</h2>
				<# _.each( settings.myths, function( myth ) { #>
					<div class="ol-myth-pair {{ myth.myth_reverse }}">
						<# if ( myth.myth_reverse !== 'flip' ) { #>
							<div class="ol-myth-vis ol-reveal"><div class="ol-myth-vis-bg">{{{ myth.myth_symbol }}}</div><div class="ol-myth-vis-caption">{{{ myth.myth_caption }}}</div></div>
						<# } #>
						<div>
							<div class="ol-myth-label ol-reveal">{{{ myth.myth_label }}}</div>
							<h3 class="ol-myth-title ol-reveal">{{{ myth.myth_title }}}</h3>
							<div class="ol-myth-body ol-reveal">{{{ myth.myth_body }}}</div>
						</div>
						<# if ( myth.myth_reverse === 'flip' ) { #>
							<div class="ol-myth-vis ol-reveal"><div class="ol-myth-vis-bg">{{{ myth.myth_symbol }}}</div><div class="ol-myth-vis-caption">{{{ myth.myth_caption }}}</div></div>
						<# } #>
					</div>
				<# } ); #>
			</div>
		</section>
		<?php
	}
}
