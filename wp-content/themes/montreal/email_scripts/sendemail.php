<?php
$absolute_path = __FILE__;
$path_to_file = explode( 'wp-content', $absolute_path );
$path_to_wp = $path_to_file[0];
require_once( $path_to_wp.'/wp-load.php' );
require_once( $path_to_wp.'/wp-includes/functions.php');

/*
Credits: Bit Repository
URL: http://www.bitrepository.com/
*/

define("CONTACT_EMAIL", get_bloginfo('admin_email'));

function ValidateEmail($email)
	{
	/*
	(Name) Letters, Numbers, Dots, Hyphens and Underscores
	(@ sign)
	(Domain) (with possible subdomain(s) ).
	Contains only letters, numbers, dots and hyphens (up to 255 characters)
	(. sign)
	(Extension) Letters only (up to 10 (can be increased in the future) characters)
	*/

	$regex = '/([a-z0-9_.-]+)'. # name

	'@'. # at

	'([a-z0-9.-]+){2,255}'. # domain & possibly subdomains

	'.'. # period

	'([a-z]+){2,10}/i'; # domain extension 

	if($email == '') { 
			return false;
		}
		else {
			$eregi = preg_replace($regex, '', $email);
	}

	return empty($eregi) ? true : false;
} // end function ValidateEmail



error_reporting (E_ALL ^ E_NOTICE);

$post = (!empty($_POST)) ? true : false;

if($post) {
	//include 'functions.php';

	$name = stripslashes($_POST['name']);
	$email = trim($_POST['email']);
	$subject = stripslashes($_POST['subject']);
	$message = stripslashes($_POST['message']);

	$error = '';

	// Check name
	if(!$name) {
		if (!$error) $error .= '<p><ul style="list-style:none;">';
		$error .= '<li>' . __('Please enter your name.','montreal') . '</li>';
	}

	// Check email

	if(!$email) {
		if (!$error) $error .= '<p><ul>';
		$error .= '<li>' . __('Please enter an e-mail address.','montreal') . '</li>';
	}

	if($email && !ValidateEmail($email)) {
		if (!$error) $error .= '<p><ul>';	
		$error .= '<li>' . __('Please enter a valid e-mail address.','montreal') . '</li>';
	}

	// Check message (length)

	if(!$message) {
		if (!$error) $error .= '<p><ul>';	
		$error .= "<li>" . __('Please enter your message.','montreal') . "</li>";
	}
	
	if( strpos($message, 'href') !== false || strpos($message, '[url') !== false ) {
		if (!$error) $error .= '<p><ul>';	
		$error .= "<li>" . __('Please leave all links as plain text.','montreal') . "</li>";
	}


		if(!$error) {
		$mail = wp_mail(CONTACT_EMAIL, $subject, $message,
			 "From: ".$name." <".$email.">\r\n"
			."Reply-To: ".$email."\r\n"
			."X-Mailer: PHP/" . phpversion());


		if($mail) {
			echo '<h6>' . __('Thank you for you enquiry. We will be in touch shortly.','montreal') . '</h6>';
		} else {
			echo '<div class="notification_error">' . __('Email was not sent. Error!','montreal') . '</div>';
		}

	}
	else
	{
		$error .= '</ul></p>';
		echo '<div class="notification_error">'.$error.'</div>';
	}

}
?>