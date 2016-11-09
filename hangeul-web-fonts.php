<?php
/**
 * Plugin Name: 한글 웹폰트 - Hangeul Web Fonts
 * Description: 워드프레스용 한글 웹폰트 - Hangeul Web Fonts for WordPress
 * Version: 0.1
 * Author: miracl2l22
 * License: GPL2
 */

/*  Copyright 2016  miracl2l22  (email : miracl2l22@gmail.com)

    Hangeul Web Fonts is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    Hangeul Web Fonts is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Hangeul Web Fonts; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Exit if accessed directely
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'Hangeul_Web_Font' ) ) {

	class Hangeul_Web_Font {

		private static $instance;

		private $admin_page;

		public function __construct() {
		  add_action( 'wp_enqueue_scripts', array( $this, 'register_font_css' ) );

			$this -> load_files();
		}

		public function load_files() {
			require_once ( 'includes/class-admin.php' );
		}

		public function register_font_css() {
			wp_register_style('sdmisaeng-font', plugins_url( 'sdmisaeng-font/font/SDMiSaeng.css' ) );
			wp_enqueue_style('sdmisaeng-font');
		}

		public static function getInstance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance             = new Hangeul_Web_Font;
				self::$instance->admin_page = new Hangeul_Web_Font_admin;
			}
			return self::$instance;
		}
	}
}

function Hangeul_Web_Font(){
	return Hangeul_Web_Font::getInstance();
}

Hangeul_Web_Font();
