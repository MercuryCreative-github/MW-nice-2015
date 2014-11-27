<?php 
/**
 * Custom script to insert/update the meta_value for job_role.
 *
 *  
 */
 
require_once("../wp-load.php");

global $wpdb;

//Get all user for the meta key role
$job_role_old = $wpdb->get_results("SELECT `meta_key`,`meta_value`, `user_id` FROM `wp_usermeta` WHERE `meta_key` = 'role'");


foreach($job_role_old as $job_role_old_data){
	$job_role = array();
	 
	 // Get user id
 	 $user_id = $job_role_old_data->user_id;
	 
	 //Get company data
	 $company_meta = get_user_meta( $user_id, 'company' );	 
	 $company_id = $company_meta[0][0];
	 
	 //Create arry for meta value job_role
	 $job_role[$company_id] = $job_role_old_data->meta_value;
 	 
 	 update_user_meta( $user_id, 'job_role' , $job_role );
	 update_user_meta( $user_id, '_job_role', $job_role );
}