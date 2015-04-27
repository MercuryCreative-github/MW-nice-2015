<?php 
 /**
 * Plugin Name: TM Forum Flexform customizer
 * Description: Mercury Creative
 * Plugin URI: http://wwww.mercurycreative.net
 * Author: Miguel Vallve
 * Author URI: http://www.mercurycreative.net
 * Version: 1.0
 * License: GPL2
 * Text Domain: Mercury Creative
 * Domain Path: Mercury Creative
 */
 
 /*
 Copyright (C) 2015  Miguel Vallve  miguel@mercurycreative.net
 
 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License, version 2, as
 published by the Free Software Foundation.
 
 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.
 
 You should have received a copy of the GNU General Public License
 along with this program; if not, write to the Free Software
 Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */
 /**
  * Snippet Wordpress Plugin Boilerplate based on:
  *
  * - https://github.com/purplefish32/sublime-text-2-wordpress/blob/master/Snippets/Plugin_Head.sublime-snippet
  * - http://wordpress.stackexchange.com/questions/25910/uninstall-activate-deactivate-a-plugin-typical-features-how-to/25979#25979
  *
  * By default the option to uninstall the plugin is disabled,
  * to use uncomment or remove if not used.
  *
  * This Template does not have the necessary code for use in multisite. 
  *
  * Also delete this comment block is unnecessary once you have read.
  *
  * Version 1.0
  */
 
 if ( ! defined( 'ABSPATH' ) ) exit;
 
 add_action( 'plugins_loaded', array( 'tmf_flexform_customizer', 'get_instance' ) );
 register_activation_hook( __FILE__, array( 'tmf_flexform_customizer', 'activate' ) );
 register_deactivation_hook( __FILE__, array( 'tmf_flexform_customizer', 'deactivate' ) );
 // register_uninstall_hook( __FILE__, array( 'tmf_flexform_customizer', 'uninstall' ) );
 
 class tmf_flexform_customizer {
 
 	private static $instance = null;
 
 	public static function get_instance() {
 		if ( ! isset( self::$instance ) )
 			self::$instance = new self;
 			self::hide_not_used(); 
 		return self::$instance;

 	}
 
 	private function __construct() {}
 
 	public static function activate() {



 	}
 
 	public static function deactivate() {}


 	public static function hide_not_used(){

 	function hide_menu_items() {

 			// Team: I cannot recall where we are using these?
			//remove_menu_page( 'edit.php?post_type=team' );

 			// Jobs: not using
			remove_menu_page( 'edit.php?post_type=jobs' );

			// Clients: not using
			remove_menu_page( 'edit.php?post_type=clients' );

			// Portfolio: not using
			remove_menu_page( 'edit.php?post_type=portfolio' );

			// Testiminials: We are using this on the HP
			//remove_menu_page( 'edit.php?post_type=testimonials' );

			// FAQ: we are not using but we may should be
			remove_menu_page( 'edit.php?post_type=faqs' );

			// There are no posts that allow commenting
			remove_menu_page( 'edit-comments.php' );
		}

 		//Hide menu options not used by TM Forum Live
 		add_action( 'admin_menu', 'hide_menu_items' );
	}

 /*
 	public static function uninstall() {
 		if ( __FILE__ != WP_UNINSTALL_PLUGIN )
 			return;
 	}
 */
 }
  ?>