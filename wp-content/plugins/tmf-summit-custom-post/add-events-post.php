<?php
 /**
 * Plugin Name: Add Summits custom post
 * Plugin URI: http://www.mercurycreative.net
 * Description: This plugin adds the custom post type "Summits"
 * Version: 1.0
 * Author: Mercury Creative
 */
 
if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly

define( 'ADD_SUMMIT_POST_TYPE__PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'ADD_SUMMIT_POST_TYPE__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );


require_once( ADD_SUMMIT_POST_TYPE__PLUGIN_DIR . 'class.tmf-event-post-type.php' );

register_activation_hook(__FILE__, array('TMF_Summit_Post_Type', 'install'));

add_action( 'init', array( 'TMF_Summit_Post_Type', 'init' ) );

?>