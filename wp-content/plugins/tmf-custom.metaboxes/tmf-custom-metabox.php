<?php
 /**
 * Plugin Name: Add custom metaboxes programatically
 * Plugin URI: http://www.mercurycreative.net
 * Description: This plugin adds custom Metaboxes
 * Version: 1.0
 * Author: Mercury Creative
 */
 
if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly

define( 'ADD_CUSTOM_METABOXES__PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'ADD_CUSTOM_METABOXES__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );


register_activation_hook(__FILE__, array('TMF_Add_Custom_metaboxes', 'install'));

require_once( ADD_CUSTOM_METABOXES__PLUGIN_DIR . 'class.tmf-add-custom-metaboxes.php' );

add_action( 'init', array( 'TMF_Add_Custom_metaboxes', 'init' ) );

?>