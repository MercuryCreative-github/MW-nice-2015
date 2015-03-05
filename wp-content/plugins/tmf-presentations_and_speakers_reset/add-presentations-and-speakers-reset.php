<?php
/*
 * 	Plugin Name: Presentations and Speakers Reset
 * 	Plugin URI: http://aress.com
 * 	Description: DO NOT ACTIVATE! This plugnin is to reset Presentations and Speakers related data activade and deactivate this plugin. It will take a while to activate, be patient. Once activated, please deactivate inmediately.
 * 	Author: TM Forum
 * 	Version: 1.0
 * 	Author URI: http://www.tmforum.org
 * 	Text Domain: N/A
 */

if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly

define( 'ADD_RESET__PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'ADD_RESET__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );


require_once( ADD_RESET__PLUGIN_DIR . 'class.tmf-reset-presentations-and-speakers.php' );

register_activation_hook(__FILE__, array('tmf_reset_presentations_and_speakers', 'install'));

add_action( 'init', array( 'tmf_reset_presentations_and_speakers', 'init' ) );

?>