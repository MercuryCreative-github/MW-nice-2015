<?php /* Template Name: Presentation Speakers Update */ 
$numposts = 10; // number of posts in feed

$arr = array();
$i=0;
$presentations = array();

if( isset( $_GET['id'] ) ) {

	global $wpdb;
	$wpdb->query( 'delete from wp_usermeta where meta_key="speaker_at" or meta_key="moderator_at" or meta_key="panelist_at" or meta_key="facilitator_at" or meta_key="collaborator_at"' );

	$id = $_GET['id'];
	
	/*if( (int)$id == 0 ) {
		echo "Id missingdd"; die;
	}*/
	
	$args = array(
									'posts_per_page' 	 => -1,
									'orderby'          => 'post_date',
									'order'            => 'DESC',
									'post_type'        => 'tmf_presentations',
									'post_status'      => 'publish'
								);
								
								
								
	/*if( $id != 'all' ) {
		$args['include'] = $id;
	}*/
									
	$presentations = get_posts( $args );
	
	foreach ( $presentations as $presentation ) {
		echo "<br/><br/>========================================================================================================================";
		echo "<br/> Id: " .  $presentation->ID;
		echo "<br/> Title: " . $presentation->post_title;
	
		// ===========================================================================================================================
		// Speakers
		
		$postMeta = get_post_meta( $presentation->ID, 'speakers' );
		echo "<br/> Original Speakers: "; 
		echo "<pre>"; print_r( $postMeta ); echo "</pre>";
		$presentationIds = array();
		if( !empty( $postMeta )) {
			$userIds = $postMeta[0];
			$sizeOfUserIds = sizeof( $userIds );
			if( $sizeOfUserIds > 0 ) {
				for( $i = 0; $i < $sizeOfUserIds; $i++ ) {
					$userMeta = get_user_meta( $userIds[$i], 'speaker_at' );
					echo "<br/> Speakers as per new conventions: "; 
					echo "<pre>"; print_r( $userMeta ); echo "</pre>";
					if( !empty( $userMeta ) ) {
						$presentationIds = $userMeta[0];
						if( !in_array( $presentation->ID, $presentationIds )) {
							$presentationIds[] = $presentation->ID;
							update_user_meta( $userIds[$i], 'speaker_at', $presentationIds );
						}
					} else {
						$presentationIds[] = $presentation->ID;
						update_user_meta( $userIds[$i], 'speaker_at', $presentationIds );
					}
				}
			}
		}
		
		$userArgs = array(	
												'meta_key'     => 'speaker_at',
												'meta_value'   => $presentation->ID,
												'meta_compare' => 'LIKE',
												'fields'       => 'ID',
											);
		$users = get_users( $userArgs );
		echo "<br/> Speakers after updation: ";
		echo '<pre>'; print_r( $users ); echo "</pre>";
		
		// ===========================================================================================================================
		// Moderators
		echo "<br/>------------------------------------------------------------------------------------------------------------------------";
		$postMeta = get_post_meta( $presentation->ID, 'moderators' );
		echo "<br/> Original Moderators: "; 
		echo "<pre>"; print_r( $postMeta ); echo "</pre>";
		$presentationIds = array();
		if( !empty( $postMeta )) {
			$userIds = $postMeta[0];
			$sizeOfUserIds = sizeof( $userIds );
			if( $sizeOfUserIds > 0 ) {
				for( $i = 0; $i < $sizeOfUserIds; $i++ ) {
					$userMeta = get_user_meta( $userIds[$i], 'moderator_at' );
					echo "<br/> Moderators as per new conventions: "; 
					echo "<pre>"; print_r( $userMeta ); echo "</pre>";
					if( !empty( $userMeta ) ) {
						$presentationIds = $userMeta[0];
						if( !in_array( $presentation->ID, $presentationIds )) {
							$presentationIds[] = $presentation->ID;
							update_user_meta( $userIds[$i], 'moderator_at', $presentationIds );
						}
					} else {
						$presentationIds[] = $presentation->ID;
						update_user_meta( $userIds[$i], 'moderator_at', $presentationIds );
					}
				}
			}
		}
		
		$userArgs = array(	
												'meta_key'     => 'moderator_at',
												'meta_value'   => $presentation->ID,
												'meta_compare' => 'LIKE',
												'fields'       => 'ID',
											);
		$users = get_users( $userArgs );
		echo "<br/> Moderators after updation: ";
		echo '<pre>'; print_r( $users ); echo "</pre>";
		
		// ===========================================================================================================================
		// Facilitators
		echo "<br/>------------------------------------------------------------------------------------------------------------------------";
		$postMeta = get_post_meta( $presentation->ID, 'facilitators' );
		echo "<br/> Original Facilitators: "; 
		echo "<pre>"; print_r( $postMeta ); echo "</pre>";
		$presentationIds = array();
		if( !empty( $postMeta )) {
			$userIds = $postMeta[0];
			$sizeOfUserIds = sizeof( $userIds );
			if( $sizeOfUserIds > 0 ) {
				for( $i = 0; $i < $sizeOfUserIds; $i++ ) {
					$userMeta = get_user_meta( $userIds[$i], 'facilitator_at' );
					echo "<br/> Facilitators as per new conventions: "; 
					echo "<pre>"; print_r( $userMeta ); echo "</pre>";
					if( !empty( $userMeta ) ) {
						$presentationIds = $userMeta[0];
						if( !in_array( $presentation->ID, $presentationIds )) {
							$presentationIds[] = $presentation->ID;
							update_user_meta( $userIds[$i], 'facilitator_at', $presentationIds );
						}
					} else {
						$presentationIds[] = $presentation->ID;
						update_user_meta( $userIds[$i], 'facilitator_at', $presentationIds );
					}
				}
			}
		}
		
		$userArgs = array(	
												'meta_key'     => 'facilitator_at',
												'meta_value'   => $presentation->ID,
												'meta_compare' => 'LIKE',
												'fields'       => 'ID',
											);
		$users = get_users( $userArgs );
		echo "<br/> Facilitator after updation: ";
		echo '<pre>'; print_r( $users ); echo "</pre>";
		
		// ===========================================================================================================================
		// Panelists
		echo "<br/>------------------------------------------------------------------------------------------------------------------------";
		$postMeta = get_post_meta( $presentation->ID, 'panelists' );
		echo "<br/> Original Panelists: "; 
		echo "<pre>"; print_r( $postMeta ); echo "</pre>";
		$presentationIds = array();
		if( !empty( $postMeta )) {
			$userIds = $postMeta[0];
			$sizeOfUserIds = sizeof( $userIds );
			if( $sizeOfUserIds > 0 ) {
				for( $i = 0; $i < $sizeOfUserIds; $i++ ) {
					$userMeta = get_user_meta( $userIds[$i], 'panelist_at' );
					echo "<br/> Panelists as per new conventions: "; 
					echo "<pre>"; print_r( $userMeta ); echo "</pre>";
					if( !empty( $userMeta ) ) {
						$presentationIds = $userMeta[0];
						if( !in_array( $presentation->ID, $presentationIds )) {
							$presentationIds[] = $presentation->ID;
							update_user_meta( $userIds[$i], 'panelist_at', $presentationIds );
						}
					} else {
						$presentationIds[] = $presentation->ID;
						update_user_meta( $userIds[$i], 'panelist_at', $presentationIds );
					}
				}
			}
		}
		
		$userArgs = array(	
												'meta_key'     => 'panelist_at',
												'meta_value'   => $presentation->ID,
												'meta_compare' => 'LIKE',
												'fields'       => 'ID',
											);
		$users = get_users( $userArgs );
		echo "<br/> Panelists after updation: ";
		echo '<pre>'; print_r( $users ); echo "</pre>";
		
		// ===========================================================================================================================
		// collaborators
		echo "<br/>------------------------------------------------------------------------------------------------------------------------";
		$postMeta = get_post_meta( $presentation->ID, 'collaborators' );
		echo "<br/> Original collaborators: "; 
		echo "<pre>"; print_r( $postMeta ); echo "</pre>";
		$presentationIds = array();
		if( !empty( $postMeta )) {
			$userIds = $postMeta[0];
			$sizeOfUserIds = sizeof( $userIds );
			if( $sizeOfUserIds > 0 ) {
				for( $i = 0; $i < $sizeOfUserIds; $i++ ) {
					$userMeta = get_user_meta( $userIds[$i], 'collaborator_at' );
					echo "<br/> Panelists as per new conventions: "; 
					echo "<pre>"; print_r( $userMeta ); echo "</pre>";
					if( !empty( $userMeta ) ) {
						$presentationIds = $userMeta[0];
						if( !in_array( $presentation->ID, $presentationIds )) {
							$presentationIds[] = $presentation->ID;
							update_user_meta( $userIds[$i], 'collaborator_at', $presentationIds );
						}
					} else {
						$presentationIds[] = $presentation->ID;
						update_user_meta( $userIds[$i], 'collaborator_at', $presentationIds );
					}
				}
			}
		}
		
		$userArgs = array(	
												'meta_key'     => 'collaborator_at',
												'meta_value'   => $presentation->ID,
												'meta_compare' => 'LIKE',
												'fields'       => 'ID',
											);
		$users = get_users( $userArgs );
		echo "<br/> Collabator after updation: ";
		echo '<pre>'; print_r( $users ); echo "</pre>";
	}
} else {
	echo "Id missing"; die;
}
?>