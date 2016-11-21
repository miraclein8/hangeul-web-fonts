<?php
/**
*
*/

// Exit if accessed directely
if ( ! defined( 'ABSPATH' ) ) exit;

class Hangeul_Web_Fonts_admin {

	private $fonts_options;
	private $etc_options;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_hwfonts_page' ) );
		add_action( 'admin_init', array( $this, 'hwfonts_init' ) );
	}

	public function add_hwfonts_page() {
		add_options_page(
			__( 'Hangeul Web Fonts', 'hangeul-web-fonts' ), 
			__( 'Hangeul Web Fonts', 'hangeul-web-fonts' ), 
			'manage_options', 
			'hangeul-web-fonts', 
			array( $this, 'create_hwfonts_page' )
		);
	}

	public function hwfonts_init() {
		
	}

http://wordpress.stackexchange.com/questions/127493/wordpress-settings-api-implementing-tabs-on-custom-menu-page



	public function create_hwfonts_page() {
		$this->options = get_option( 'hwfonts_options' );
		?>
		<div class="wrap">
			<h1><?php _e( 'Hangeul Web Fonts', 'hangeul-web-fonts' ) ?></h1>
			<?php
			$active_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : 'fonts_tab';
			?>
			<h2 class="nav-tab-wrapper">
				<a href="?page=options_tab=fonts_tab" class="nab-tab"></a>
			</h2>

			<h2 class="nav-tab-wrapper">
				<a href="?page=hangeul-web-fonts&tab=fonts-options" class="nav-tab <?php if($active_tab == 'fonts-options'){echo 'nav-tab-active';} ?> "><?php _e('Web Fonts To Use', 'hangeul-web-fonts'); ?></a>
				<a href="?page=hangeul-web-fonts&tab=etc-options" class="nav-tab <?php if($active_tab == 'etc-options'){echo 'nav-tab-active';} ?>"><?php _e('Etc Options', 'hangeul-web-fonts'); ?></a>
			</h2>

			<form method="post" action="options.php">
				<?php
				if( $active_tab == 'fonts_options' ) {
					settings_fields( 'hwfonts_fonts_group' );
					do_settings_sections( 'hangeul-web-fonts' );
				} else if( $active_tab == 'fonts_options' ) {
					settings_fields( 'hwfonts_etc_group' );
					do_settings_sections( 'hangeul-web-fonts' );
				}
				submit_button();
				?>
			</form>
		</div>
		<?php
	}

	public function page_init() {        

		add_settings_section(
			'hwfonts_fonts_section', // ID
			__( 'Web Fonts To Use', 'hangeul-web-fonts' ), // Title
			array( $this, 'hwfonts_fonts_section_desc' ), // Callback
			'hangeul-web-fonts' // Page
		);

		add_settings_section(
			'hwfonts_etc_section', // ID
			__( 'Etc Options', 'hangeul-web-fonts' ), // Title
			array( $this, 'hwfonts_etc_section_desc' ), // Callback
			'hangeul-web-fonts' // Page
		);

		/**
		 * Web Fonts To Use
		 */

		add_settings_field(
			'sdmisaeng_font', // ID
			__( 'SDMiSaeng', 'hangeul-web-fonts' ), // Title 
			array( $this, 'sdmisaeng_fonts_cb' ), // Callback
			'hangeul-web-fonts', // Page
			'web_fonts_settings_section' // Section           
		);

		add_settings_field(
			'jeju_font', // ID
			__( 'Jeju Fonts', 'hangeul-web-fonts' ) . '<br />- by Google Fonts Early Access', // Title 
			array( $this, 'jeju_fonts_cb' ), // Callback
			'hangeul-web-fonts', // Page
			'web_fonts_settings_section' // Section           
		);

		add_settings_field(
			'nanum_font', // ID
			__( 'Nanum Fonts', 'hangeul-web-fonts' ) . ' (Naver)<br />- by Google Fonts Early Access', // Title 
			array( $this, 'nanum_fonts_cb' ), // Callback
			'hangeul-web-fonts', // Page
			'web_fonts_settings_section' // Section           
		);

		register_setting(
			'hwfonts_fonts_group', // Option group
			'hwfonts_options', // Option name
			array( $this, 'sanitize' ) // Sanitize
		);
	}

	public function sanitize( $input ) {
		$new_input = array();

		if( isset( $input['is_sdmisaeng'] ) )
			$new_input['is_sdmisaeng'] = $input['is_sdmisaeng'];

		if( isset( $input['is_jejuhallasan'] ) )
			$new_input['is_jejuhallasan'] = $input['is_jejuhallasan'];
		if( isset( $input['is_jejugothic'] ) )
			$new_input['is_jejugothic'] = $input['is_jejugothic'];
		if( isset( $input['is_jejuhallasan'] ) )
			$new_input['is_jejumyeongjo'] = $input['is_jejumyeongjo'];

		if( isset( $input['is_nanumbrushscript'] ) )
			$new_input['is_nanumbrushscript'] = $input['is_nanumbrushscript'];
		if( isset( $input['is_nanumpenscript'] ) )
			$new_input['is_nanumpenscript'] = $input['is_nanumpenscript'];
		if( isset( $input['is_nanumgothic'] ) )
			$new_input['is_nanumgothic'] = $input['is_nanumgothic'];
		if( isset( $input['is_nanummyeongjo'] ) )
			$new_input['is_nanummyeongjo'] = $input['is_nanummyeongjo'];

		return $new_input;
	}

	public function hwfonts_fonts_section_desc() {
		//print 'Enter your settings below:';
	}

	public function hwfonts_etc_section_desc() {
		//print 'Enter your settings below:';
	}

	public function sdmisaeng_fonts_cb() {
		printf(
			'<input %s type="checkbox" name="hwfonts_options[is_sdmisaeng]" id="is_sdmisaeng" value="1" /> <label class="lbl_sdmisaeng">' . __( 'SDMiSaeng', 'hangeul-web-fonts' ) . '</label> <label> { font-family: SDMiSaeng; font-size: 1.25rem; } </label><p></p>',
			( isset( $this->options['is_sdmisaeng'] ) && $this->options['is_sdmisaeng'] === '1' ) ? 'checked' : ''
		);
	}

	public function jeju_fonts_cb() {
		printf(
			'<input %s type="checkbox" name="hwfonts_options[is_jejuhallasan]" id="is_jejuhallasan" value="1" /> <label class="lbl_jejuhallasan">' . __( 'Jeju Hallasan', 'hangeul-web-fonts' ) . '</label> <label> { font-family: Jeju Hallasan; } </label><p></p><br />',
			( isset( $this->options['is_jejuhallasan'] ) && $this->options['is_jejuhallasan'] === '1' ) ? 'checked' : ''
		);
		printf(
			'<input %s type="checkbox" name="hwfonts_options[is_jejugothic]" id="is_jejugothic" value="1" /> <label class="lbl_jejugothic">' . __( 'Jeju Gothic', 'hangeul-web-fonts' ) . '</label> <label> { font-family: Jeju Gothic; } </label><p></p><br />',
			( isset( $this->options['is_jejugothic'] ) && $this->options['is_jejugothic'] === '1' ) ? 'checked' : ''
		);
		printf(
			'<input %s type="checkbox" name="hwfonts_options[is_jejumyeongjo]" id="is_jejumyeongjo" value="1" /> <label class="lbl_jejumyeongjo">' . __( 'Jeju Myeongjo', 'hangeul-web-fonts' ) . '</label> <label> { font-family: Jeju Myeongjo; } </label><p></p>',
			( isset( $this->options['is_jejumyeongjo'] ) && $this->options['is_jejumyeongjo'] === '1' ) ? 'checked' : ''
		);
	}

	public function nanum_fonts_cb() {
		printf(
			'<input %s type="checkbox" name="hwfonts_options[is_nanumbrushscript]" id="is_nanumbrushscript" value="1" /> <label class="lbl_nanumbrushscript">' . __( 'Nanum Brush Script', 'hangeul-web-fonts' ) . '</label> <label> { font-family: Nanum Brush Script; font-size: 1.15rem; } </label><p></p><br />',
			( isset( $this->options['is_nanumbrushscript'] ) && $this->options['is_nanumbrushscript'] === '1' ) ? 'checked' : ''
		);
		printf(
			'<input %s type="checkbox" name="hwfonts_options[is_nanumpenscript]" id="is_nanumpenscript" value="1" /> <label class="lbl_nanumpenscript">' . __( 'Nanum Pen Script', 'hangeul-web-fonts' ) . '</label> <label> { font-family: Nanum Pen Script; font-size: 1.15rem; } </label><p></p><br />',
			( isset( $this->options['is_nanumpenscript'] ) && $this->options['is_nanumpenscript'] === '1' ) ? 'checked' : ''
		);
		printf(
			'<input %s type="checkbox" name="hwfonts_options[is_nanumgothic]" id="is_nanumgothic" value="1" /> <label class="lbl_nanumgothic">' . __( 'Nanum Gothic', 'hangeul-web-fonts' ) . '</label> <label> { font-family: Nanum Gothic; } </label><p></p><br />',
			( isset( $this->options['is_nanumgothic'] ) && $this->options['is_nanumgothic'] === '1' ) ? 'checked' : ''
		);
		printf(
			'<input %s type="checkbox" name="hwfonts_options[is_nanummyeongjo]" id="is_nanummyeongjo" value="1" /> <label class="lbl_nanummyeongjo">' . __( 'Nanum Myeongjo', 'hangeul-web-fonts' ) . '</label> <label> { font-family: Nanum Myeongjo; } </label><p></p>',
			( isset( $this->options['is_nanummyeongjo'] ) && $this->options['is_nanummyeongjo'] === '1' ) ? 'checked' : ''
		);
	}
}