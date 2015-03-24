<?php
/* ------------------------------------------------------------------------------------
*  COPYRIGHT AND TRADEMARK NOTICE
*  Copyright 2008-2014 AJdG Solutions (Arnan de Gans). All Rights Reserved.
*  ADROTATE is a trademark of Arnan de Gans.

*  COPYRIGHT NOTICES AND ALL THE COMMENTS SHOULD REMAIN INTACT.
*  By using this code you agree to indemnify Arnan de Gans from any
*  liability that might arise from it's use.
------------------------------------------------------------------------------------ */

/*  
dev4: sales@ajdg.net / 104-S-4fc269c5-f56a-4355-a405-90fa4171d551
*/

/*-------------------------------------------------------------
 Name:      AJdG Solutions Licensing Library
 Version:	1.1
-------------------------------------------------------------*/

function adrotate_licensed_update() {
	add_filter('pre_set_site_transient_update_plugins', 'adrotate_update_check');
	add_filter('plugins_api', 'adrotate_get_updatedetails', 10, 3);
}

function adrotate_update_check($checked_data) {
	global $adrotate_api_url;
	
	if(empty($checked_data->checked)) {
		return $checked_data;	
	}

   	$license = get_option('adrotate_activate');
	if($license['status'] == 1) {	
		$request_args = array(
			'slug' => 'adrotate',
			'version' => $checked_data->checked[ADROTATE_FOLDER .'/adrotate.php'],
			'instance' => $license['instance'],
			'platform' => get_option('siteurl'),
		);
		$raw_response = wp_remote_post($adrotate_api_url, adrotate_license_prepare_request('basic_check', adrotate_license_array_to_object($request_args)));
		
		if(!is_wp_error($raw_response) || wp_remote_retrieve_response_code($raw_response) === 200) {
			$response = unserialize($raw_response['body']);	
		}
		
		if (is_object($response) && !empty($response)) { // Feed the update data into WP updater
			$checked_data->response[ADROTATE_FOLDER .'/adrotate.php'] = $response;
		}
	}

	return $checked_data;
}

function adrotate_get_updatedetails($def, $action, $args) {
	global $adrotate_api_url;
	
	if(!isset($args->slug) || $args->slug != 'adrotate') {
		return $def;	
	}

   	$license = get_option('adrotate_activate');
	
	// Get the current version
	$plugin_info = get_site_transient('update_plugins');
	$current_version = $plugin_info->checked[ADROTATE_FOLDER .'/adrotate.php'];
	$args->version = $current_version;
	$args->instance = $license['instance'];
	$args->email = $license['email'];
	$args->platform = get_option('siteurl');

	$request = wp_remote_post($adrotate_api_url, adrotate_license_prepare_request($action, $args));
	
	if(is_wp_error($request)) {
		$response = new WP_Error('plugins_api_failed', __('An Unexpected HTTP Error occurred during the API request.</p> <p><a href="?" onclick="document.location.reload(); return false;">Try again</a>'), wp_remote_retrieve_response_code($request));
	} else {
		$response = unserialize($request['body']);
		if($response === false) {
			$response = new WP_Error('plugins_api_failed', __('An unknown error occurred'), $request['body']);		
		}
	}
	
	return $response;
}

function adrotate_support_api_request() {
	if(wp_verify_nonce($_POST['adrotate_nonce_support'],'adrotate_nonce_support_request')) {
		$author = esc_attr($_POST['adrotate_updater_username']);
		$useremail = esc_attr($_POST['adrotate_updater_email']);
		$subject = strip_tags(stripslashes(trim($_POST['adrotate_updater_subject'], "\t\n ")));
		$text = strip_tags(stripslashes(trim($_POST['adrotate_updater_message'], "\t\n ")));
		if(adrotate_is_networked()) {
			$a = get_site_option('adrotate_activate');
			$networked = 'Yes';
		} else {
			$a = get_option('adrotate_activate');
			$networked = 'No';
		}

		if(strlen($text) < 1 OR strlen($subject) < 1 OR strlen($author) < 1 OR strlen($useremail) < 1) {
			adrotate_return('adrotate', 505);
		} else {
			$data = array(
			    'name' => $author,
			    'email' => $useremail,
			    'subject' => $subject,
			    'message' => $text,
			    'website' => get_bloginfo('wpurl'),
			    'wpversion' => get_bloginfo('version'),
			    'wpmultisite' => (is_multisite()) ? 'Yes' : 'No',
			    'pluginnetwork' => $networked,
			    'wplanguage' => get_bloginfo('language'),
			    'wpcharset' => get_bloginfo('charset'),
			    'pluginversion' => ADROTATE_DISPLAY,
			    'topicId' => 2,
			    'source' => 'API',
			    'ip' => '0.0.0.0',
			    'attachments' => array()
			);

			$request = wp_remote_post('https://ajdg.solutions/support/api/http.php/tickets.json', array(
				'timeout' => 15,
				'sslverify' => false,
				'user-agent' => 'AdRotate/'.ADROTATE_DISPLAY.' SupportAPI Client',
				'headers' => array('Expect:' => '', 'X-API-Key' => 'E084B50052E9CBA7963D55C1AC90032A'),
				'body' => json_encode($data),
				'cookies' => array()
			    )
			);

			if(is_wp_error($request) || wp_remote_retrieve_response_code($request) != 201) {
				$response = new WP_Error('plugins_api_failed', __('An Unexpected HTTP Error occurred during the Support API request.</p>', 'adrotate'), wp_remote_retrieve_response_code($request));
			} else {
				adrotate_return('adrotate', 701, array('ticket' => $request['body']));
				exit;
			}
			adrotate_return('adrotate', 702, $response->errors);
			exit;
		}
	} else {
		adrotate_nonce_error();
		exit;
	}
}

function adrotate_license_prepare_request($action, $args) {
	global $wp_version;
	
	return array(
		'body' => array(
			'action' => $action, 
			'request' => serialize($args),
		),
		'user-agent' => 'AdRotate Pro/' . $args->version . '; WordPress/'. $wp_version . '; ' . get_option('siteurl')
	);	
}

function adrotate_license_array_to_object($array = array()) {
    if (empty($array) || !is_array($array))
		return false;
		
	$data = new stdClass;
    foreach ($array as $akey => $aval)
            $data->{$akey} = $aval;
	return $data;
}
?>