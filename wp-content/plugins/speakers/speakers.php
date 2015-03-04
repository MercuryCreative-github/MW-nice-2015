<?php
/*
 * 	Plugin Name: Speakers and Presentations mapping
 * 	Plugin URI: http://aress.com
 * 	Description: To create custom metaboxes for speakers, moderators, panelists and facilitators in Presentations and save the data against Speakers.
 * 	Author: TM Forum
 * 	Version: 1.0
 * 	Author URI: http://www.tmforum.org
 * 	Text Domain: N/A
 */

if (!class_exists('Speakers')) {

/**
 * Speakers class contains all methods.
 */
	class Speakers {
	
		private $boxes;
	
		/**
		 * Constructor
		 *
		 * @uses add_action()
		 */
		public function __construct( $args ) {
			$this->boxes = $args;
			add_action( 'plugins_loaded', array( $this, 'start_up' ) );
		}
	
		/**
		 * Adds meta box on product page
		 *
		 * @uses add_action()
		 */
		public function start_up() {
			add_action( 'add_meta_boxes', array( $this, 'add_mb' ) );
		}
	
		/**
		 * Adds meta box on product page
		 *
		 * @uses add_meta_box()
		 */
		public function add_mb() {
			foreach( $this->boxes as $box )
				add_meta_box( 
					$box['id'], 
					$box['title'], 
					array( $this, 'mb_callback' ), 
					$box['post_type'], 
					isset( $box['context'] ) ? $box['context'] : 'normal', 
					isset( $box['priority'] ) ? $box['priority'] : 'default', 
					$box['args']
				);
		}
		
		/**
		 * Saves speaker meta page/post
		 *
		 * @uses update_user_meta(), get_user_meta()
		 */		
		public function save_meta() {



		if(!function_exists('update_speakers_by_role')){


		    function update_speakers_by_role($role_to_update) {




			if( isset( $_POST[$role_to_update.'s_hidden'] ) ) {

				$speakerIds = $_POST[$role_to_update.'s_meta'];
				$sizeSpeakers = sizeof( $speakerIds );
				$presentationIds[] = $_POST['post_ID'];

				// remove the presentation to the unselected users
					$args = array(
					'meta_query' =>array(array('meta_key' => $role_to_update.'_at' ,'value' => $presentationId ,'compare' => 'LIKE'),) 
					);

					$user_query = new WP_User_Query( $args );

					if ( ! empty( $user_query->results ) ) {
					foreach ( $user_query->results as $user ) {

						$userMeta = get_user_meta( $user->ID, $role_to_update.'_at' );

						if(!$userMeta){}


						else if( !empty( $userMeta ) ) {
							$presentationIds = $userMeta[0];
							if(is_array ( $presentationIds ))
							if(($key = array_search($_POST['post_ID'], $presentationIds)) !== false) {
								unset($presentationIds[$key]);
								update_user_meta( $user->ID, $role_to_update.'_at', $presentationIds );
							}							
						}
						}
					}

				// add the preentation to the users selected
				if( $sizeSpeakers > 0 ) {
					for( $i = 0; $i < $sizeSpeakers; $i++ ) {
						$userMeta = get_user_meta( $speakerIds[$i], $role_to_update.'_at' );
						
						if( !empty( $userMeta ) ) {
							$presentationIds = $userMeta[0];
							if(is_array ( $presentationIds ))
							if( !in_array( $_POST['post_ID'], $presentationIds )) {
								$presentationIds[] = $_POST['post_ID'];
								update_user_meta( $speakerIds[$i], $role_to_update.'_at', $presentationIds );
							}
						}

						if(!$userMeta){
							$presentationIds[] = $_POST['post_ID'];
							add_user_meta( $speakerIds[$i], $role_to_update.'_at',  $presentationIds);

						}
					}
				}
			}
		};

	};

		$roles=array('speaker','panelist','collaborator','facilitator','moderator');

		foreach ($roles as $role_to_update) {
			update_speakers_by_role($role_to_update);
		}

		}
			
	
		/**
		 * Loads multiselect metabox
		 *
		 * returns html for the multiselect option
		 */
		public function mb_callback( $post, $box ) {
			$userType = $box['id'];
			$meta_key = $box['args']['meta_key'];
			$this->multiselect( $box, $post, $userType, $meta_key );
		}
		
		/**
		 * Loads multiselect metabox
		 *
		 * returns html for the multiselect option
		 */	
		private function multiselect( $box, $post, $userType = 'speakers', $meta_key = 'speaker_at' ) {
			global $wpdb;
			
			$userArgs = array(	
													'meta_key'     => $meta_key,
													'meta_value'   => $post->ID,
													'meta_compare' => 'LIKE',
													'fields'       => 'ID',

												);
			$speakers = get_users( $userArgs );
			
			$users = get_users( array(
				 'role' => 'Speaker',
				 'fields' => array( 'ID','display_name'),
				 'orderby' => 'display_name',
				 'order' => 'asc',
			));
			
			$html = '<select style="width:100%%;height:250px;" name="' . $userType . '_meta[]" multiple>';
			foreach ( $users as $user_data ) {
				$selected = '';
				if( !empty( $speakers ) ) {
					$selected = ( in_array( $user_data->ID, $speakers ) ) ? ' selected="selected" ' : '' ;
				}
				$html .= '<option value="' . $user_data->ID . '"' . $selected . '>' . $user_data->display_name . '</option>';
			}
			$html .= '</select>
			<input type="hidden" name="' . $userType . '_hidden" value="1" />';
			
			printf(
				'<p class="label"><label> %s: </label></p>' . $html . '<br/>',
				$box['args']['desc']
			);
		}
	}
}

$args = array(
	array(
		'id' => 'speakers',
		'title' => 'Speakers',
		'post_type' => 'agenda_tracks',
		'context' => 'advanced',
		'priority' => 'high',
		'args' => array(
			'desc' => 'Select one or more Speakers. Selecting multiple options vary in different operating systems and browsers: For windows: Hold down the control (ctrl) button to select multiple options. For Mac: Hold down the command button to select multiple options',
			'field' => 'multiselect',
			'meta_key'=> 'speaker_at'
		)
	),
	array(
		'id' => 'moderators',
		'title' => 'Moderators',
		'post_type' => 'agenda_tracks',
		'context' => 'advanced',
		'priority' => 'high',
		'args' => array(
			'desc' => 'Select one or more Moderators. Selecting multiple options vary in different operating systems and browsers: For windows: Hold down the control (ctrl) button to select multiple options. For Mac: Hold down the command button to select multiple options',
			'field' => 'multiselect',
			'meta_key'=> 'moderator_at'
		)
	),
	array(
		'id' => 'facilitators',
		'title' => 'Facilitators',
		'post_type' => 'agenda_tracks',
		'context' => 'advanced',
		'priority' => 'high',
		'args' => array(
			'desc' => 'Select one or more Facilitators. Selecting multiple options vary in different operating systems and browsers: For windows: Hold down the control (ctrl) button to select multiple options. For Mac: Hold down the command button to select multiple options',
			'field' => 'multiselect',
			'meta_key'=> 'facilitator_at'
		)
	),
	array(
		'id' => 'collaborators',
		'title' => 'Collaborators',
		'post_type' => 'agenda_tracks',
		'context' => 'advanced',
		'priority' => 'high',
		'args' => array(
			'desc' => 'Select one or more Collaborators. Selecting multiple options vary in different operating systems and browsers: For windows: Hold down the control (ctrl) button to select multiple options. For Mac: Hold down the command button to select multiple options',
			'field' => 'multiselect',
			'meta_key'=> 'collaborator_at'
		)
	),
	array(
		'id' => 'panelists',
		'title' => 'Panelists',
		'post_type' => 'agenda_tracks',
		'context' => 'advanced',
		'priority' => 'high',
		'args' => array(
			'desc' => 'Select one or more Panelists. Selecting multiple options vary in different operating systems and browsers: For windows: Hold down the control (ctrl) button to select multiple options. For Mac: Hold down the command button to select multiple options',
			'field' => 'multiselect',
			'meta_key'=> 'panelist_at'
		)
	)
);
new Speakers( $args );

if ( isset( $_POST['panelists_hidden'] ) ) {
	add_action( 'wp_insert_post', array( 'Speakers', 'save_meta' ), 10, 1 );
}
?>