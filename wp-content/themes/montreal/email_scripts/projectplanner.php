<?php 
	$absolute_path = __FILE__;
	$path_to_file = explode( 'wp-content', $absolute_path );
	$path_to_wp = $path_to_file[0];
	require_once( $path_to_wp.'/wp-load.php' );
	require_once( $path_to_wp.'/wp-includes/functions.php');
	ob_start();
	// change here, if you want. or use add_filter
	if( $_REQUEST['fieldnm_99'] !='' ) { exit('SPAM'); }
	$fromemail = $_REQUEST['fieldnm_1'] . "<" . $_REQUEST['fieldnm_2'] . ">"; 
	$toemail   = apply_filters("montreal_projectplaner_emailaddress", get_bloginfo('admin_email'));
	$sub       = apply_filters("montreal_projectplaner_subject", "Project Planner");
	$option = get_option('montreal_theme_options');
	$success_page_name=$option['thanks_url'];
	////// do not change in following 
	if($_SERVER['REQUEST_METHOD']=="POST") 
	{
	$fieldnm_1=str_replace ( array("\n"), array("<br>"),trim($_REQUEST['fieldnm_1']));  
	$fieldnm_2=str_replace ( array("\n"), array("<br>"),trim($_REQUEST['fieldnm_2']));  
	$fieldnm_3=str_replace ( array("\n"), array("<br>"),trim($_REQUEST['fieldnm_3']));  
	$fieldnm_4=str_replace ( array("\n"), array("<br>"),trim($_REQUEST['fieldnm_4']));  
	$fieldnm_5=str_replace ( array("\n"), array("<br>"),trim($_REQUEST['fieldnm_5']));  
	$fieldnm_6=str_replace ( array("\n"), array("<br>"),trim($_REQUEST['fieldnm_6']));  
	$fieldnm_7=str_replace ( array("\n"), array("<br>"),trim($_REQUEST['fieldnm_7']));  
	$fieldnm_8=str_replace ( array("\n"), array("<br>"),trim($_REQUEST['fieldnm_8']));  
	$fieldnm_9=str_replace ( array("\n"), array("<br>"),trim($_REQUEST['fieldnm_9']));  
	$fieldnm_10=str_replace ( array("\n"), array("<br>"),trim($_REQUEST['fieldnm_10']));  
	$fieldnm_11=str_replace ( array("\n"), array("<br>"),trim($_REQUEST['fieldnm_11']));  
	$fieldnm_12=str_replace ( array("\n"), array("<br>"),trim($_REQUEST['fieldnm_12']));  
	$fieldnm_13=str_replace ( array("\n"), array("<br>"),trim($_REQUEST['fieldnm_13']));  
	$fieldnm_14=str_replace ( array("\n"), array("<br>"),trim($_REQUEST['fieldnm_14']));  
	$fieldnm_15=str_replace ( array("\n"), array("<br>"),trim($_REQUEST['fieldnm_15']));  
	$fieldnm_16=str_replace ( array("\n"), array("<br>"),trim($_REQUEST['fieldnm_16']));  
	
	
	$contentmsg=stripslashes("<br><b><font style=color:#CC3300>$sub</font></b><br>
	<table width=708 border=0 cellpadding=2 cellspacing=1 bgcolor=#CCCCCC>
	
	<tr>
	      <td width=165 align=right valign=top bgcolor=#FFFFFF><B>" . __('Your Name*', 'montreal') . "</b> </td>
	      <td width=565 align=left valign=top bgcolor=#FFFFFF>$fieldnm_1</td>
	</tr>
	
	<tr>
	      <td width=165 align=right valign=top bgcolor=#FFFFFF><B>" . __('Your E-mail*', 'montreal') . "</b> </td>
	      <td width=565 align=left valign=top bgcolor=#FFFFFF>$fieldnm_2</td>
	</tr>
	
	<tr>
	      <td width=165 align=right valign=top bgcolor=#FFFFFF><B>" . __('Telephone number', 'montreal') . "</b> </td>
	      <td width=565 align=left valign=top bgcolor=#FFFFFF>$fieldnm_3</td>
	</tr>
	
	<tr>
	      <td width=165 align=right valign=top bgcolor=#FFFFFF><B>" . __('Company name', 'montreal') . "</b> </td>
	      <td width=565 align=left valign=top bgcolor=#FFFFFF>$fieldnm_4</td>
	</tr>
	
	<tr>
	      <td width=165 align=right valign=top bgcolor=#FFFFFF><B>" . __('Website URL (if applicable)', 'montreal') ."</b> </td>
	      <td width=565 align=left valign=top bgcolor=#FFFFFF>$fieldnm_5</td>
	</tr>
	
	<tr>
	      <td width=165 align=right valign=top bgcolor=#FFFFFF><B>" . __('Your location', 'montreal') . "</b> </td>
	      <td width=565 align=left valign=top bgcolor=#FFFFFF>$fieldnm_6</td>
	</tr>
	
	<tr>
	      <td width=165 align=right valign=top bgcolor=#FFFFFF><B>" . __('Please describe your project concept or idea', 'montreal') . "</b> </td>
	      <td width=565 align=left valign=top bgcolor=#FFFFFF>$fieldnm_7</td>
	</tr>
	
	<tr>
	      <td width=165 align=right valign=top bgcolor=#FFFFFF><B>" . __('Project requirements', 'montreal') . "</b> </td>
	      <td width=565 align=left valign=top bgcolor=#FFFFFF>$fieldnm_8</td>
	</tr>
	
	<tr>
	      <td width=165 align=right valign=top bgcolor=#FFFFFF><B>" . __('When do you hope to start', 'montreal') . "</b> </td>
	      <td width=565 align=left valign=top bgcolor=#FFFFFF>$fieldnm_9</td>
	</tr>
	
	<tr>
	      <td width=165 align=right valign=top bgcolor=#FFFFFF><B>" . __('When do you hope to launch', 'montreal') . "</b> </td>
	      <td width=565 align=left valign=top bgcolor=#FFFFFF>$fieldnm_10</td>
	</tr>
	
	<tr>
	      <td width=165 align=right valign=top bgcolor=#FFFFFF><B>" . __('Your budget*', 'montreal') . "</b> </td>
	      <td width=565 align=left valign=top bgcolor=#FFFFFF>$fieldnm_11</td>
	</tr>
	
	<tr>
	      <td width=165 align=right valign=top bgcolor=#FFFFFF><B>" . __('Please describe your desired look and feel', 'montreal') . "</b> </td>
	      <td width=565 align=left valign=top bgcolor=#FFFFFF>$fieldnm_12</td>
	</tr>
	
	<tr>
	      <td width=165 align=right valign=top bgcolor=#FFFFFF><B>" . __('Any inspiration for your project', 'montreal') . "</b> </td>
	      <td width=565 align=left valign=top bgcolor=#FFFFFF>$fieldnm_13</td>
	</tr>
	
	<tr>
	      <td width=165 align=right valign=top bgcolor=#FFFFFF><B>" . __('Anything else you want us to know', 'montreal') . "</b> </td>
	      <td width=565 align=left valign=top bgcolor=#FFFFFF>$fieldnm_14</td>
	</tr>
	
	</table>
	");
	
	////
	$headers  = "MIME-Version: 1.0
	";
	$headers .= "Content-type: text/html; charset=iso-8859-1
	";
					
	$from=$fromemail;
					
	$headers .= "From: ".$from." 
	";
					
	@wp_mail($toemail,$sub,$contentmsg,$headers);
					
					
	header("Location:$success_page_name");
	
	}
?>
