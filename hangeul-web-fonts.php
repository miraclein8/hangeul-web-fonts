<?php
/**
 * Plugin Name: 한글 웹폰트 - Hangeul Web Fonts
 * Description: 워드프레스용 한글 웹폰트 - Hangeul Web Fonts for WordPress
 * Version: 0.2
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

	class Hangeul_Web_Fonts {

		private static $instance;

		private $admin_page;

		public function __construct() {
			load_plugin_textdomain( 'hwfonts', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

			add_action( 'wp_enqueue_scripts', array( $this, 'register_fonts_css' ) );
			add_action( 'admin_menu', array( $this, 'register_fonts_admin_css') );

			$this -> load_files();
		}

		public function load_files() {
			require_once ( 'includes/class-admin.php' );
		}

		public function register_fonts_css() {
			$admin_page = new stdClass();
			$admin_page->options = get_option( 'hwfonts_options' );

			if ( isset($admin_page->options['is_sdmisaeng']) && $admin_page->options['is_sdmisaeng'] === '1' ) {
				wp_register_style('sdmisaeng', plugins_url( 'hangeul-web-fonts/css/SDMiSaeng.css' ) );
				wp_enqueue_style('sdmisaeng');
			}
			if ( isset($admin_page->options['is_jejuhallasan']) && $admin_page->options['is_jejuhallasan'] === '1' ) {
				wp_register_style('jejuhallasan', 'http://fonts.googleapis.com/earlyaccess/jejuhallasan.css' );
				wp_enqueue_style('jejuhallasan');
			}
			if ( isset($admin_page->options['is_jejugothic']) && $admin_page->options['is_jejugothic'] === '1' ) {
				wp_register_style('jejugothic', 'http://fonts.googleapis.com/earlyaccess/jejugothic.css' );
				wp_enqueue_style('jejugothic');
			}
			if ( isset($admin_page->options['is_jejumyeongjo']) && $admin_page->options['is_jejumyeongjo'] === '1' ) {
				wp_register_style('jejumyeongjo', 'http://fonts.googleapis.com/earlyaccess/jejumyeongjo.css' );
				wp_enqueue_style('jejumyeongjo');
			}
		}

		public function register_fonts_admin_css() {
			wp_register_style('fonts_admin', plugins_url( 'hangeul-web-fonts/css/admin.css' ) );
			wp_enqueue_style('fonts_admin');

			wp_register_style('font_jejuhallasan', 'http://fonts.googleapis.com/earlyaccess/jejuhallasan.css' );
			wp_enqueue_style('font_jejuhallasan');

			wp_register_style('font_jejugothic', 'http://fonts.googleapis.com/earlyaccess/jejugothic.css' );
			wp_enqueue_style('font_jejugothic');

			wp_register_style('font_jejumyeongjo', 'http://fonts.googleapis.com/earlyaccess/jejumyeongjo.css' );
			wp_enqueue_style('font_jejumyeongjo');
		}

		public static function getInstance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance             = new Hangeul_Web_Fonts;
				self::$instance->admin_page = new Hangeul_Web_Fonts_admin;
			}
			return self::$instance;
		}
	}
}

function Hangeul_Web_Fonts(){
	return Hangeul_Web_Fonts::getInstance();
}

Hangeul_Web_Fonts();
