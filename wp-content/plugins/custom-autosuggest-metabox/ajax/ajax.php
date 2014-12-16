<?php
/**
 * File : ajax/ajax.php
 * Description : Ajax file to return data called from an ajax function
 */

// Include wordpress defaults.
include_once( "../../../../wp-load.php" );

$postData = $_POST;

$returnStr = '';
$userid = $postData['userid'];
$method = $postData['method'];
$companyName = $postData['companyName'];
$jobRole = $postData['jobRole'];
$selectedCompanies = $postData['selectedCompanies'];
$selectedJobRoles = $postData['selectedJobRoles'];

function saveCompany( $companyName, $jobRole, $selectedCompanies, $selectedJobRoles, $userid ) {
	global $wpdb;
	 
	if(empty($selectedJobRoles)){
		$job_user_meta = get_user_meta( $userid, 'job_role' );
		$job_user_meta = is_array( $job_user_meta[0] ) ? $job_user_meta[0] : unserialize( $job_user_meta[0] );
	} else {
		$job_role_array = explode( ",", $selectedJobRoles );
		$job_role_array = array_filter($job_role_array);
		
		$job_user_meta = array();
		foreach($job_role_array as $data_arr){
			if(!empty($data_arr)){
				$val_arr = explode( "|", $data_arr );
				$txt = $val_arr[0];
				$id = $val_arr[1];
				$job_user_meta[$id] =  $txt;
			}	
		 }
	
	}
	$job_user_meta = array_filter($job_user_meta);
	 
	
	
	$results_array = array();
	$i = 0;
	
	$results_array['company'] = $companyName;
	
	// Create post object
	$my_post = array(
		'post_title'    => wp_strip_all_tags( $_POST['companyName'] ),
		'post_content'  => '',
		'post_status'   => 'publish',
		'post_author'   => 1,
		'post_type'   => 'companies'
	);
	
	// Insert the post into the database
	$results_array['id'] = wp_insert_post( $my_post );
	
	if( (int)$results_array['id'] == 0 ) {
		return $results_array;
	} else {
		$args = array(
			'posts_per_page'   => -1,
			'post_type'        => 'companies',
			'post_status'      => 'publish'
		);
		
		$companies = get_posts( $args );
		
		$i = 0;
		foreach( $companies as $company ) {
			$list[$i]['value'] = $company->ID;
			$list[$i]['name'] = $company->post_title;
			$list[$i]['job_role'] = '';
			$i++;
		}
		
		$results_array['list'] = $list;
		$selectedCompanies = explode( ",", $selectedCompanies );
		$selectedCompanies[] = $results_array['id'];
		
		$args = array(
			'posts_per_page'   => -1,
			'orderby'		   => 'post__in',
			'post_type'        => 'companies',
			'post_status'      => 'publish',
			'include'		   => $selectedCompanies
		);
		
		$companies = get_posts( $args );
		
		$i = 0;
		$list = array();
		foreach( $companies as $company ) {
			$list[$i]['value'] = $company->ID;
			$list[$i]['name'] = $company->post_title;
			
			
			
			if($results_array['id'] ==  $company->ID){
				$list[$i]['job_role'] = $jobRole;
			} else {
				$list[$i]['job_role'] = ((!empty( $job_user_meta[$company->ID] ) && $job_user_meta[$company->ID] != NULL ) ? $job_user_meta[$company->ID] : '' );
			}
				
			$i++;
		}
		$results_array['prepopulatedList'] = $list;
		 
		return $results_array;
	}
	
	//return $results_array;
}

switch( $method ) {
	case 'saveCompany' :
		$returnStr = saveCompany( $companyName, $jobRole, $selectedCompanies, $selectedJobRoles, $userid );
		break;
}
echo json_encode( $returnStr ); 