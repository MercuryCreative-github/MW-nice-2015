<?php
$absolute_path = __FILE__;
$path_to_file = explode( 'wp-content', $absolute_path );
$path_to_wp = $path_to_file[0];
require_once( $path_to_wp.'/wp-load.php' );
require_once( $path_to_wp.'/wp-includes/functions.php');

if(!$_POST) exit;

// Email address verification, do not edit.
function tommus_email_validate($email) { return filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match('/@.+\./', $email); }

if (!defined("PHP_EOL")) define("PHP_EOL", "\r\n");

$email    = $_POST['email'];

 if(!tommus_email_validate($email)) {
	echo '<div class="error_message">' . __('Attention! You have entered an invalid e-mail address, try again.','montreal') . '</div>';
	exit();
}

$address = get_bloginfo('admin_email');

$e_subject =  __('You have a new subscriber to your newsletter.','montreal');

$e_body = "$email wishes to be added to your newsletter list." . PHP_EOL . PHP_EOL;

$msg = wordwrap( $e_body, 70 );

$headers = "From: $email" . PHP_EOL;
$headers .= "Reply-To: $email" . PHP_EOL;
$headers .= "MIME-Version: 1.0" . PHP_EOL;
$headers .= "Content-type: text/plain; charset=utf-8" . PHP_EOL;
$headers .= "Content-Transfer-Encoding: quoted-printable" . PHP_EOL;

if(wp_mail($address, $e_subject, $msg, $headers)) { echo "<fieldset><div id='success_page'><p>" . __('Email Submitted Successfully.','montreal') . "<p></div></fieldset>"; }