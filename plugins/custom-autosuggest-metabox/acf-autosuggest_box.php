<?php
/*
Plugin Name: Advanced Custom Fields: Companies Autosuggest Box
Plugin URI: http://aress.com
Description: Users autosuggest field for Advanced Custom Fields
Author: Aress Software
Version: 1.0
Author URI: http://aress.com
Text Domain: N/A
*/


class acf_autosuggest_plugin {
	/*
	*  Construct
	*
	*  @description:
	*/

	function __construct() {
		//load_plugin_textdomain( 'acf-field-autosuggest-box', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

		add_action('acf/include_field_types', array($this, 'include_field_types'));	

		add_action('acf/register_fields', array($this, 'register_fields'));

		add_action( 'init', array( $this, 'init' ));
	}


	/*
	*  Init
	*
	*  @description:
	*/

	function init() {
		if( function_exists( 'register_field' ) ) {
			register_field( 'acf_autosuggest_box', dirname(__File__) . '/autosuggest_box.php' );
		}
	}

	/*
	*  register_fields
	*
	*  @description:
	*/

	function register_fields() {
		include_once( 'autosuggest_box.php' );
	}


	function include_field_types() {
		include_once( 'autosuggest_box.php' );
	}

}

new acf_autosuggest_plugin();

?>