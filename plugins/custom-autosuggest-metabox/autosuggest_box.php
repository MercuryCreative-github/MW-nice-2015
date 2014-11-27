<?php

class acf_autosuggest_box extends acf_field
{
	// vars
	var $settings   // will hold info such as dir / path
		, $defaults // will hold default field options
		, $domain   // holds the language domain
		, $lang;

	/*
	*  __construct
	*
	*  Set name / label needed for actions / filters
	*
	*  @since	3.6
	*  @date	23/01/13
	*/

	function __construct() {
		// vars
		$this->name = 'autosuggest_box';
		$this->label = __('Autosuggest Box');
		$this->category = __("jQuery", $this->domain); // Basic, Content, Choice, etc
		$this->domain = 'acf-field-autosuggest-box';
		$this->defaults = array();



		// do not delete!
    	parent::__construct();


    	// settings
		$this->settings = array(
			'path'      => apply_filters('acf/helpers/get_path', __FILE__),
			'dir'     => apply_filters('acf/helpers/get_dir', __FILE__),
			'version' => '2.0.9'
		);

	}


	/*
	*  create_options()
	*
	*  Create extra options for your field. This is rendered when editing a field.
	*  The value of $field['name'] can be used (like bellow) to save extra data to the $field
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field	- an array holding all the field's data
	*/

	function create_options( $field ) {
		$field = array_merge($this->defaults, $field);
		$key = $field['name'];
	}



	/*
	*  create_field()
	*
	*  Create the HTML interface for your field
	*
	*  @param	$field - an array holding all the field's data
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*/

	public function create_field( $field ) {
	
		global $wpdb;
		
		
		
		$tmp = explode( '_', $_POST['option_name'] );
		$job_user_meta = get_user_meta( $tmp[1], 'job_role' );
		$job_user_meta = is_array( $job_user_meta[0] ) ? $job_user_meta[0] : unserialize( $job_user_meta[0] );
		$post_ids = array();
 		
		$user_meta = get_user_meta( $tmp[1], $field['_name'] );
		$arr = '[';
		if( !empty( $field ) ) {
			$post_ids = is_array( $user_meta[0] ) ? $user_meta[0] : unserialize( $user_meta[0] );
 			if( !empty( $post_ids )) {
				foreach( $post_ids as $id ) {  
					$post_title = get_the_title( $id );
 					$arr .= '{\"value\":\"' . $id . '\",\"name\":\"' . $post_title . '\",\"job_role\":\"' . $job_user_meta[$id] . '\"},';
				}
			}
		} 
		$arr = trim( $arr, ',' );
		$arr .= ']';
		
		
		$args = array(
			'posts_per_page'   => -1,
			'orderby'          => 'post_date',
			'order'            => 'DESC',
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
		$list = json_encode( $list );
		
		echo '<link rel="stylesheet" type="text/css" href="' . plugins_url() . '/custom-autosuggest-metabox/css/token-input.css?time=' . strtotime( date( "Y-m-d H:i:s" )) . '" />
			<script type="text/javascript" src="' . plugins_url() . '/custom-autosuggest-metabox/js/jquery.tokeninput.js?time=' . strtotime( date( "Y-m-d H:i:s" )) . '"></script>';

		
		$htmlTxt = '<input type="text" id="inputs" placeholder="Search here for a company name" name="inputs" style="width:100%" />\<input type="hidden" name="' . $field['_name'] . '" value="1" /><input type="hidden" name="field_name" value="' . $field['_name'] . '" /><input type="hidden" name="field_key" value="' . $field['key'] . '" />';
				
		echo '<div id="outter-box-autosuggest">
						<input type="text" id="inputs" name="inputs" placeholder="Search here for a company name" style="width:100%" />
						<input type="hidden" name="' . $field['_name'] . '" value="1" />
						<input type="hidden" name="field_name" value="' . $field['_name'] . '" />
						<input type="hidden" name="field_key" value="' . $field['key'] . '" />
					</div>
					<a href="javascript:void(0);" id="addCompanyLink" style="padding: 10px 0;float:left;">Add Company</a>
					<div id="formDiv" style="display:none;float:left;width:100%;" class="form-company">
						<form action="" method="post">
							<div class="add-company-row"><label>Company Name:</label> <input type="text" value="" placeholder="Enter Company Name" id="companyNameText" /></div>
							<div class="add-company-row"><label>Job Role: </label><input type="text" value="" placeholder="Enter Job Role" id="jobRole" /></div>
							<div style="float: left;padding: 5px 0; margin-left:128px;">
								<input type="button" value="Save Company" id="addCompanyButton" />
								<input type="button" value="Cancel" id="removeCompanyButton" />
							</div>
						</form>
					</div>
					<script>
						var userid = ' . ( !empty( $tmp[1] ) ? $tmp[1] : 0 ) .';
						function trimChar(string, charToRemove) {
								while(string.charAt(0)==charToRemove) {
										string = string.substring(1);
								}
						
								while(string.charAt(string.length-1)==charToRemove) {
										string = string.substring(0,string.length-2);
								}
						
								return string;
						}
						var obj = jQuery.parseJSON( ' . json_encode( $list ) . ' );
						jQuery(document).ready(function() {
							var x = jQuery("#inputs").tokenInput(obj,{
								prePopulate: jQuery.parseJSON("' . $arr . '")
							});
							jQuery("#addCompanyLink").click(function() {
								jQuery("#formDiv").css( "display", "block" );
							});
							jQuery("form").keyup(function(e) {
								return e.which !== 13  
							});
							jQuery("form").keypress(function(e) {
								return e.which !== 13  
							});
							jQuery("#removeCompanyButton").click(function() {
								jQuery("#formDiv").css( "display", "none" );
							});
							
							jQuery( "#companyNameText" ).keypress( function(e) {
								if(e.which == 13){//Enter key pressed
									jQuery( "#addCompanyButton" ).focus();
									jQuery("#addCompanyButton").click();//Trigger save company button click event
								}
							});	
							
							jQuery( "#jobRole" ).keypress( function(e) {
								if(e.which == 13){//Enter key pressed
 							 		jQuery( "#addCompanyButton" ).focus();
									jQuery("#addCompanyButton").click();//Trigger save company button click event
 								}
							});	
								
							jQuery( "#addCompanyButton" ).click( function() {
								var functionName = "saveCompany";
								selectedCompanies = "";
								selectedJobRoles = " ";
								companyName = jQuery( "#companyNameText" ).val();
								jobRole = jQuery( "#jobRole" ).val();
								
								if( companyName == "" ) {
									alert( "Please enter company name." );
									jQuery( "#companyNameText" ).focus();
 									return false;
								}
								if( jobRole == "" ) {
									alert( "Please enter job role." );
									jQuery( "#jobRole" ).focus();
 									return false;
								}
								jQuery("input").attr("disabled",true);
								jQuery( ".selectedLi" ).each(function() {
									selectedCompanies += "," + jQuery( this ).val();
								});
								
								jQuery( ".job_role_text" ).each(function() {
									selectedJobRolesVal = jQuery( this ).val();
									selectedJobRolesId  =  jQuery( this ).attr("job_id");
									
									selectedJobRoles += "," +selectedJobRolesVal+"|"+selectedJobRolesId
								});
								 
								var param = jQuery.extend({ "companyName": companyName,  "jobRole": jobRole, "method": functionName, "selectedCompanies":selectedCompanies, "selectedJobRoles":selectedJobRoles,"userid": userid, }, param);
								var url = "' . plugins_url() . '/custom-autosuggest-metabox/ajax/ajax.php";
						
								jQuery.ajax({
									type: "POST",
									url: url,
									async: false,
									data: param,
									cache: false,
									dataType: "json",
									success: function( data ) {
										
										if( parseInt( data.id ) == 0 ) {
											alert( "Error in saving company." );
										} else {
											
											alert( "Company added successfully." );
											
											jQuery( "#outter-box-autosuggest" ).html(\'' . $htmlTxt . '\');
											jQuery( "#companyNameText" ).val( "" );
											jQuery( "#jobRole" ).val( "" );
											jQuery("input").attr("disabled",false);
											
											var x = jQuery("#inputs").tokenInput(data.list,{
												prePopulate: data.prepopulatedList
											});
											jQuery("#formDiv").css( "display", "none" );
										}
									}
								});
							});
						});
					</script>';
	}
}


// create field
new acf_autosuggest_box();

add_action ('user_register', "save_meta");
function save_meta( $user_id ) {
 	 
	$field_name = $_POST['field_name'];
	$field_key =  $_POST['field_key'];
	$company_names = $_POST['company_names'];
	$job_role = $_POST['job_role'];
	
	if( !empty( $field_name ) && !empty( $field_key ) ) {
		update_user_meta( $user_id, $field_name, $company_names );
		update_user_meta( $user_id, '_' . $field_name, $company_names );
		update_user_meta( $user_id, 'job_role' , $job_role );
		update_user_meta( $user_id, '_job_role', $job_role );
	}
}



add_action( 'profile_update', 'updates_meta', 10, 2 );

function updates_meta( $user_id, $old_user_data ) { //echo '<pre>'; print_r($_POST); die;
 	    $field_name = $_POST['field_name'];
		$field_key =  $_POST['field_key'];
		$company_names = $_POST['company_names'];
	 	$job_role = $_POST['job_role'];
 		if( !empty( $field_name ) && !empty( $field_key ) ) {
			update_user_meta( $user_id, $field_name, $company_names );
			update_user_meta( $user_id, '_' . $field_name, $company_names );
			update_user_meta( $user_id, 'job_role' , $job_role );
			update_user_meta( $user_id, '_job_role', $job_role );
		}
}


add_action('wp_trash_post', 'delete_meta_values');
function delete_meta_values($post_id) {
    $post = get_post($post_id);
    if ($post->post_type == 'companies') {
        
		//Get all user for the meta key role 
		$args = array(
				 'fields'       => 'ID',
				 'meta_query'   => array(
						'relation' => 'OR',
		
					array(
						'key' => 'company',
						'value' => $post_id,
						'compare' => 'LIKE'
					)
				)
			);
			
		$user_data = get_users($args);
		
		//Update user meta vlaues for company
		foreach($user_data as $user_id){ echo $user_id.'==>';
			 
			//Update company meta key
			$company = get_user_meta( $user_id, 'company' );
			$company = $company[0];
 			if(($key = array_search($post_id, $company)) !== false) {
				unset($company[$key]);
			}
			$company = array_values($company);
 			 update_user_meta( $user_id, 'company' , $company );
			 update_user_meta( $user_id, '_company' , $company );
			
			//Update job role meta key
			$job_role = get_user_meta( $user_id, 'job_role' );
 			unset($job_role[0][$post_id]);
			$job_role = $job_role[0];
 			 update_user_meta( $user_id, 'job_role' , $job_role );
			 update_user_meta( $user_id, '_job_role' , $job_role );
			
		 }

		
       }
}

?>