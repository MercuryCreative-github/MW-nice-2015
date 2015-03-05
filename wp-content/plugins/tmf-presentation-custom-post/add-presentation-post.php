<?php
 /**
 * Plugin Name: Add Presentations
 * Plugin URI: http://www.mercurycreative.net
 * Description: This plugin adds the custom post type "Presentations"
 * Version: 1.0
 * Author: Mercury Creative
 */
 
if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly

define( 'ADD_PRESENTATION_POST_TYPE__PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'ADD_PRESENTATION_POST_TYPE__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );


require_once( ADD_PRESENTATION_POST_TYPE__PLUGIN_DIR . 'class.tmf-presentation-post-type.php' );

register_activation_hook(__FILE__, array('TMF_Presentation_Post_Type', 'install'));

add_action( 'init', array( 'TMF_Presentation_Post_Type', 'init' ) );

?>