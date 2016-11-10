<?php
/**
*
*/

// Exit if accessed directely
if ( ! defined( 'ABSPATH' ) ) exit;

class Hangeul_Web_Fonts_admin {

	private $options;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_hwfonts_options_page' ) );
		add_action( 'admin_init', array( $this, 'page_init' ) );
	}

	public function add_hwfonts_options_page() {
		add_options_page(
			__( 'Hangeul Web Fonts', 'hwfonts' ), 
			__( 'Hangeul Web Fonts', 'hwfonts' ), 
			'manage_options', 
			'hangeul-web-fonts', 
			array( $this, 'create_hwfonts_page' )
		);
	}

	public function create_hwfonts_page() {
		$this->options = get_option( 'hwfonts_options' );
		?>
		<div class="wrap">
			<h1><?php _e( 'Hangeul Web Fonts', 'hwfonts' ) ?></h1>
			<form method="post" action="options.php">
				<?php
					settings_fields( 'hwfonts_options_group' );
					do_settings_sections( 'hangeul-web-fonts' );
					submit_button();
				?>
			</form>
		</div>
		<?php
	}

	public function page_init() {        
		register_setting(
			'hwfonts_options_group', // Option group
			'hwfonts_options', // Option name
			array( $this, 'sanitize' ) // Sanitize
		);

		add_settings_section(
			'web_fonts_settings_section', // ID
			__( '', 'hwfonts' ), // Title
			array( $this, 'web_fonts_section_desc' ), // Callback
			'hangeul-web-fonts' // Page
		);  

		add_settings_field(
			'web_fonts_to_use', // ID
			__( 'Web Fonts To Use', 'hwfonts' ), // Title 
			array( $this, 'web_fonts_to_use_cb' ), // Callback
			'hangeul-web-fonts', // Page
			'web_fonts_settings_section' // Section           
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

		return $new_input;
	}

	public function web_fonts_section_desc() {
		//print 'Enter your settings below:';
	}

	public function web_fonts_to_use_cb() {
		printf(
			'<input %s type="checkbox" name="hwfonts_options[is_sdmisaeng]" id="is_sdmisaeng" value="1" /> <label class="lbl_sdmisaeng">' . __( 'SDMiSaeng', 'hwfonts' ) . '</label> <label> ( font-family: SDMiSaeng; ) </label><p></p><br />',
			( isset( $this->options['is_sdmisaeng'] ) && $this->options['is_sdmisaeng'] === '1' ) ? 'checked' : ''
			
		);
		printf(
			'<input %s type="checkbox" name="hwfonts_options[is_jejuhallasan]" id="is_jejuhallasan" value="1" /> <label class="lbl_jejuhallasan">' . __( 'Jeju Hallasan', 'hwfonts' ) . '</label> <label> ( font-family: Jeju Hallasan; ) </label><p></p><br />',
			( isset( $this->options['is_jejuhallasan'] ) && $this->options['is_jejuhallasan'] === '1' ) ? 'checked' : ''
		);
		printf(
			'<input %s type="checkbox" name="hwfonts_options[is_jejugothic]" id="is_jejugothic" value="1" /> <label class="lbl_jejugothic">' . __( 'Jeju Gothic', 'hwfonts' ) . '</label> <label> ( font-family: Jeju Gothic; ) </label><p></p><br />',
			( isset( $this->options['is_jejugothic'] ) && $this->options['is_jejugothic'] === '1' ) ? 'checked' : ''
		);
		printf(
			'<input %s type="checkbox" name="hwfonts_options[is_jejumyeongjo]" id="is_jejumyeongjo" value="1" /> <label class="lbl_jejumyeongjo">' . __( 'Jeju Myeongjo', 'hwfonts' ) . '</label> <label> ( font-family: Jeju Myeongjo; ) </label><p></p>',
			( isset( $this->options['is_jejumyeongjo'] ) && $this->options['is_jejumyeongjo'] === '1' ) ? 'checked' : ''
		);
	}
}