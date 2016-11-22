<?php
/**
 * class Hangeul_Web_Fonts_admin
 */

// Exit if accessed directely
if ( ! defined( 'ABSPATH' ) ) exit;

class Hangeul_Web_Fonts_admin {

	private $options;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_hwfonts_page' ) );
		add_action( 'admin_init', array( $this, 'hwfonts_page_init' ) );
	}

	public function add_hwfonts_page() {
		add_options_page(
			__( 'Hangeul Web Fonts', 'hangeul-web-fonts' ), // $page_title
			__( 'Hangeul Web Fonts', 'hangeul-web-fonts' ), // $menu_title
			'manage_options', // $capability
			'hangeul-web-fonts', // $menu_slug
			array( $this, 'create_hwfonts_page' ) // function
		);
	}

	public function hwfonts_page_init() {

		// tab
		add_settings_section(
			'fonts_section', // $id
			'', // $title
			array( $this, 'fonts_section_desc' ), // $callback
			'hwfonts_fonts_page' // $page
		);

		add_settings_field(
			'sdmisaeng_font', // $id
			__( 'SDMiSaeng Font', 'hangeul-web-fonts' ), // $title
			array( $this, 'sdmisaeng_font_cb' ), // $callback
			'hwfonts_fonts_page', // $page
			'fonts_section' // $section
			 // $args
		);

		add_settings_field(
			'jeju_fonts', // $id
			__( 'Jeju Fonts', 'hangeul-web-fonts' ) . '<br />- by Google Fonts Early Access', // $title
			array( $this, 'jeju_fonts_cb' ), // $callback
			'hwfonts_fonts_page', // $page
			'fonts_section' // $section
			 // $args
		);

		add_settings_field(
			'nanum_fonts', // $id
			__( 'Nanum Fonts', 'hangeul-web-fonts' ) . ' (Naver)<br />- by Google Fonts Early Access', // $title
			array( $this, 'nanum_fonts_cb' ), // $callback
			'hwfonts_fonts_page', // $page
			'fonts_section' // $section
			 // $args
		);

		register_setting(
			'fonts_group', // $option_group
			'fonts_options' // $option_name
			// $sanitize_callback
		);

		// CSS Options Tab
		add_settings_section(
			'css_section', // $id
			'', // $title
			array( $this, 'css_section_desc' ), // $callback
			'hwfonts_css_page' // $page
		);

		add_settings_field(
			'css_settings', // $id
			__( 'CSS Settings', 'hangeul-web-fonts'), // $title
			array( $this, 'css_settings_cb' ), // $callback
			'hwfonts_css_page', // $page
			'css_section' // $section
			 // $args
		);

		register_setting(
			'css_group', // $option_group
			'css_options' // $option_name
			// $sanitize_callback
		);
	}

	public function fonts_section_desc() {
		/* */
	}

	public function sdmisaeng_font_cb() {
		$this->generator_fonts_check('fonts_options', 'sdmisaeng', 'SDMiSaeng', '1.25rem;');
	}

	public function jeju_fonts_cb() {
		$this->generator_fonts_check('fonts_options', 'jejuhallasan', 'Jeju Hallasan');
		$this->generator_fonts_check('fonts_options', 'jejugothic', 'Jeju Gothic');
		$this->generator_fonts_check('fonts_options', 'jejumyeongjo', 'Jeju Myeongjo');
	}

	public function nanum_fonts_cb() {
		$this->generator_fonts_check('fonts_options', 'nanumbrushscript', 'Nanum Brush Script', '1.15rem;');
		$this->generator_fonts_check('fonts_options', 'nanumpenscript', 'Nanum Pen Script', '1.15rem;');
		$this->generator_fonts_check('fonts_options', 'nanumgothic', 'Nanum Gothic');
		$this->generator_fonts_check('fonts_options', 'nanummyeongjo', 'Nanum Myeongjo');
	}

	public function generator_fonts_check( $option, $is_font, $font_name, $font_size = '') {
		$this->options = get_option($option);
		printf(
			'<input %s type="checkbox" name="'.$option.'[is_'.$is_font.']" id="is_'.$is_font.'" value="1" /> <label class="lbl_'.$is_font.'">' . __( $font_name, 'hangeul-web-fonts' ) . '</label> <label>{ font-family: '.$font_name.'; %s}</label><p></p>',
			( isset( $this->options['is_$is_font'] ) && $this->options['is_$is_font'] === '1' ) ? 'checked' : '',
			! $font_size == '' ? 'font-size: '.$font_size.' ' : ''
		);
	}

	public function css_section_desc() {
		/* */
	}

	public function css_settings_cb() {
		/* */
	}

	public function create_hwfonts_page() {
	?>
		<div class="wrap">
			<h1><?php _e( 'Hangeul Web Fonts', 'hangeul-web-fonts' );?></h1>
			<?php
				$active_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : 'fonts_options';
			?>

			<h2 class="nav-tab-wrapper">
				<a href="?page=hangeul-web-fonts&tab=fonts_options" class="nav-tab <?php echo $active_tab == 'fonts_options' ? 'nav-tab-active' : ''; ?>" ><?php _e( 'Web Fonts To Use', 'hangeul-web-fonts' ); ?></a>
				<a href="?page=hangeul-web-fonts&tab=css_options" class="nav-tab <?php echo $active_tab == 'css_options' ? 'nav-tab-active' : ''; ?>" ><?php _e( 'CSS Options', 'hangeul-web-fonts' ); ?></a>
			</h2>          

			<form method="post" action="options.php">
			<?php
				if( $active_tab == 'fonts_options' ) {
					settings_fields('fonts_group'); // $option_group
					do_settings_sections('hwfonts_fonts_page'); // $page
				} else if( $active_tab == 'css_options' ) {
					settings_fields('css_group'); // $option_group
					do_settings_sections('hwfonts_css_page'); // $page
				}
				submit_button();
			?>
			</form>
		</div>
	<?php
	}
}