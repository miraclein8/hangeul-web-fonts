<?php
/**
*
*/

// Exit if accessed directely
if ( ! defined( 'ABSPATH' ) ) exit;

class Hangeul_Web_Font_admin extends Hangeul_Web_Font {

	private $options;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_fonts_options' ) );
		add_action( 'admin_init', array( $this, 'page_init' ) );
	}

	public function add_fonts_options() {
		add_options_page(
			'Settings Admin', 
			__( 'Hangeul Web Fonts' , 'hwfonts' ), 
			'manage_options', 
			'hangeul-web-fonts', 
			array( $this, 'create_admin_page' )
		);
	}

	public function create_admin_page() {
		$this->options = get_option( 'my_option_name' );
		?>
			<div class="wrap">
				<h1>Hangeul Web Fonts</h1>
				<div class="card">
				<?php
				settings_fields( 'my_option_group' );
				do_settings_sections( 'my-setting-admin' );
				submit_button();
				?>
				</div>
			</div>
		<?php
	}

	public function page_init() {        
	register_setting(
	'my_option_group', // Option group
	'my_option_name', // Option name
	array( $this, 'sanitize' ) // Sanitize
	);

	add_settings_section(
	'setting_section_id', // ID
	'My Custom Settings', // Title
	array( $this, 'print_section_info' ), // Callback
	'my-setting-admin' // Page
	);  

	add_settings_field(
	'id_number', // ID
	'ID Number', // Title 
	array( $this, 'id_number_callback' ), // Callback
	'my-setting-admin', // Page
	'setting_section_id' // Section           
	);      

	add_settings_field(
	'title', 
	'Title', 
	array( $this, 'title_callback' ), 
	'my-setting-admin', 
	'setting_section_id'
	);      
	}

	public function sanitize( $input ) {
	$new_input = array();
	if( isset( $input['id_number'] ) )
	$new_input['id_number'] = absint( $input['id_number'] );

	if( isset( $input['title'] ) )
	$new_input['title'] = sanitize_text_field( $input['title'] );

	return $new_input;
	}

	public function print_section_info() {
	print 'Enter your settings below:';
	}

	public function id_number_callback() {
	printf(
	'<input type="text" id="id_number" name="my_option_name[id_number]" value="%s" />',
	isset( $this->options['id_number'] ) ? esc_attr( $this->options['id_number']) : ''
	);
	}

	public function title_callback() {
	printf(
	'<input type="text" id="title" name="my_option_name[title]" value="%s" />',
	isset( $this->options['title'] ) ? esc_attr( $this->options['title']) : ''
	);
	}
}