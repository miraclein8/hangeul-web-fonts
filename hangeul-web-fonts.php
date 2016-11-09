<?php
/**
 * Plugin Name: Hangeul Font
 * Description: 워드프레스용 한글 폰트 - Hangeul Font for WordPress
 * Version: 0.1
 * Author: miracl2l22
 * License: GPL2
 */

/*  Copyright 2016  miracl2l22  (email : miracl2l22@gmail.com)

    Hangeul Font is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    Hangeul Font is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Hangeul Font; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Exit if accessed directely
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'SDMiSaeng_font' ) ) {

	class SDMiSaeng_font {

		private static $instance;

		public function __construct() {
		  add_action( 'wp_enqueue_scripts', array( $this, 'register_font_css' ) );
		}

		public function register_font_css() {
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
