<?php
if (!class_exists('tmf_reset_presentations_and_speakers')) {
	class tmf_reset_presentations_and_speakers {

		private static $initiated = false;
        
        
        /**
		 * Constructor
		 *
		 * @uses add_action() , add_shortcode(), add_filter(), register_activation_hook()
		*/
		function __construct() {
        } 
        
        public static function install(){
            self::init();
            flush_rewrite_rules();
            self::reset_presentations_and_speakers();
        }
        
        public static function init(){
            if ( ! self::$initiated ) {
			 self::init_hooks();
            }
        }
        
        private static function init_hooks() {
            self::$initiated = true;
        }
        
        private static function reset_presentations_and_speakers() {

        	$roles=array('speaker','panelist','collaborator','facilitator','moderator');
        	$emptyArray[]='Nothing Selected';

        	$args=array(
        		'post_type'	=> 'agenda_tracks',
        		);


        	$presentationToAdd = new WP_Query( $args );

        	if ( $presentationToAdd->have_posts() ) {

				while ( $presentationToAdd->have_posts() ) {

					$presentationToAdd->the_post();
					$presentationToAddId=get_the_ID();

					foreach ($roles as $role_to_update) {

					delete_post_meta( $presentationToAddId, $role_to_update.'s_meta');
					add_post_meta( $presentationToAddId, $role_to_update.'s_meta',  $emptyArray);

					}


				}

			}

	       	// Reset Users
	        	$user_query = new WP_User_Query( array( 'role' => 'Speaker' ) );

			
	        	if ( ! empty( $user_query->results ) ) {
						foreach ( $user_query->results as $user ) {

							foreach ($roles as $role_to_update) {
								delete_user_meta( $user->ID, $role_to_update.'_at');
								add_user_meta( $user->ID, $role_to_update.'_at', $emptyArray);

							}
				
						}
				}
			}

        
    }
}