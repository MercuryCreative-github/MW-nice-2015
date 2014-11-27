<?php
/*
 * 	Plugin Name: Sponsored Sessions
 * 	Plugin URI: http://ameba.com.uy
 * 	Description: To create custom metaboxes for sessions in the company profile
 * 	Author: Mercurycreative
 * 	Version: 1.0
 * 	Author URI: http://www.tmforum.org
 * 	Text Domain: N/A
 */

if (!class_exists('sponsoredSessions')) {

/**
 * sponsoredSessions class contains all methods.
 */
	class sponsoredSessions {

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



		if(!function_exists('update_company_sponsored_session')){


		  function update_company_sponsored_session() {

			if( isset( $_POST['ss_hidden'] ) ) {

				$companiesIDs = $_POST['companies_meta'];
				$sizeCompanies = sizeof( $companiesIDs );
				update_post_meta($_POST['post_ID'], 'sponsoredsession',	 $_POST['companies_meta']);

			}// if is set
		}; // function

	}; // if exists

	update_company_sponsored_session();


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
		private function multiselect( $box, $post, $postType = 'companies', $meta_key = 'sponsoredsession' ) {

			global $wpdb;

			$query = "SELECT * FROM `" . $wpdb->prefix . "event_hours` ORDER BY `before_hour_text` ASC";
		//	$query = "SELECT * FROM `" . $wpdb->prefix . "event_hours` AS t1 LEFT JOIN {$wpdb->posts} AS t2 ON t1.weekday_id=t2.ID WHERE t1.event_id='" . $post->ID . "' ORDER BY FIELD(t2.menu_order,2,3,4,5,6,7,1), t1.start, t1.end";
			//$result = mysql_query($query) or die(mysql_error());

		  $event_hours =	$wpdb->get_results($query);
			$event_hours_count = count($event_hours);

			$company_sponsored_sessions  =  get_post_meta($_GET['post'],'sponsoredsession',true);



			//var_dump($event_hours);

			$html = 	'<select style="width:100%%;height:250px;" name="' . $userType . 'companies_meta[]" multiple>';

			foreach ( $event_hours as $row ) {

				$selected = '';
				if(is_array($company_sponsored_sessions))
				if(in_array ( $row->event_hours_id, $company_sponsored_sessions )){
				$selected= 'selected="selected"';
				}

				if($row->category && $row->before_hour_text)

				$html .= '<option value="' . $row->event_hours_id . '"' . $selected . '>' . $row->before_hour_text . '</option>';


				}

			$html .= '</select>
			<input type="hidden" name="ss_hidden" value="1" />';

			printf('<p class="label"><label> %s: </label></p>' . $html . '<br/>',	$box['args']['desc']);
		}
	}
}

$args = array(
	array(
		'id' => 'sessions',
		'title' => 'Sponsored Sessions',
		'post_type' => 'companies',
		'context' => 'normal',
		'priority' => 'low',
		'args' => array(
			'desc' => 'Please choose whether this company sponsors a session',
		)
	)
);


new sponsoredSessions( $args );

	add_action( 'wp_insert_post', array( 'sponsoredSessions', 'save_meta' ), 10, 1 );

?>
