<?php
/**
 * Plugin Name: SDMiSaeng font
 * Description: 미생체
 * Version: 0.1
 * Author: miracl2l22
 */

// Exit if accessed directely
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'SDMiSaeng_font' ) ) {

	class SDMiSaeng_font {

		private static $instance;

		public function __construct() {
		  add_action( 'wp_enqueue_scripts', array( $this, 'register_font_style' ) );
		}

		public function register_font_style() {
			wp_register_style('sdmisaeng-font', plugins_url( 'sdmisaeng-font/font/SDMiSaeng.css' ) );
			wp_enqueue_style('sdmisaeng-font');
		}

		public static function getInstance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance           = new SDMiSaeng_font;
			}
			return self::$instance;
		}
	}
}

function SDMiSaeng_font(){
	return SDMiSaeng_font::getInstance();
}

SDMiSaeng_font();