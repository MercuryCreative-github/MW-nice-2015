<?php

if (!class_exists('TMF_Add_Custom_metaboxes')) {
    class TMF_Add_Custom_metaboxes {

        private static $initiated = false;

        /**
         * Constructor
         *
         * @uses add_action() , add_shortcode(), add_filter(), register_activation_hook()
         */
        function __construct() {
        }

        public static function install() {
            self::init();
            flush_rewrite_rules();
        }

        public static function init() {
            if (!self::$initiated) {
                self::init_hooks();
            }
        }

        private static function init_hooks() {
            self::$initiated = true;
            if (is_plugin_active('cmb2/init.php')) {
                add_filter('cmb2_meta_boxes', array('TMF_Add_Custom_metaboxes',
                        'cmb2_TMF_metaboxes'));

                //replace permalink to redirect url page setting if exists
                //used for redirect_url metabox
                add_filter('post_type_link', array('TMF_Add_Custom_metaboxes','return_dinamic_permalink_from_page_setting'), 5, 2);
                add_filter('page_link', array('TMF_Add_Custom_metaboxes','return_dinamic_permalink_from_page_setting_page'), 5, 2);
                add_filter('post_link', array('TMF_Add_Custom_metaboxes','return_dinamic_permalink_from_page_setting_post'), 5, 2);
                add_filter('nav_menu_link_attributes', array('TMF_Add_Custom_metaboxes','custom_menu_item_url_from_page_setting'), 5, 3);
                add_action('template_redirect', array('TMF_Add_Custom_metaboxes','redirect_from_settings'));
            }
        }
        public function cmb2_TMF_metaboxes(array $meta_boxes) {

            // Start with an underscore to hide fields from custom fields list
            $prefix = '_TMF_';

            $meta_boxes['redirect_url']  = array(
                'id' => 'redirect_url',
                'title' => __('TMF - Page Settings', 'cmb2'),
                'object_types' => array('page','tmf_press','tmf_programs', 'tmf_events','post','product'),
                'context' => 'normal',
                'priority' => 'high',
                'show_names' => true, // Show field names on the left
                'fields' => array(
                    array(
                        'name' => __('Redirect to internal page', 'cmb2'),
                        'desc' => __('Select an internal page to redirect, the permalink will be replaced.', 'cmb2'),
                        'id' => $prefix . 'redirect_url',
                        'type' => 'select',
                        'options' => array('TMF_Add_Custom_metaboxes', 'all_pages_select_field_options')
                    ),
                     array(
                        'name' => __('Redirect to external url', 'cmb2'),
                        'desc' => __('Write a valid url to redirect, the permalink will be replaced. If this is not blank, the above selection will be omitted.', 'cmb2'),
                        'id' => $prefix . 'redirect_external_url',
                        'type' => 'text_url',
                    ),
                    array(
                        'name' => __( 'Separate Content markup ', 'cmb2' ),
                        'desc' => __( 'Separate Content and ExtraContent', 'cmb2' ),
                        'id'   => $prefix . 'separate_content_and_extracontent',
                        'type' => 'checkbox',
                        'show_on_cb' => array( 'TMF_Add_Custom_metaboxes','show_if_is_page'), // function should return a bool value
                    ),
                    array(
                        'name' => __( 'Sidebar over Header', 'cmb2' ),
                        'desc' => __( 'It will show the sidebar overlaping the header by 70px instead of below it.', 'cmb2' ),
                        'id'   => $prefix . 'sidebar_over_header',
                        'type' => 'checkbox',
                    ),
                    array(
                        'name' => __( 'Slider on Content', 'cmb2' ),
                        'desc' => __( 'It will show the slider on the header inside the content instead of on top of both content and sidebar. Therefore, the sidebar will go up to the top of the page', 'cmb2' ),
                        'id'   => $prefix . 'slider_on_content',
                        'type' => 'checkbox',
                    ),
                    array(
						'name' => 'Highlighted Event',
						'id' => $prefix . 'highlighted_event',
						'desc' => 'Highlighted Event',
 						'options' => self::get_all_events(),
						'type'    => 'select',
						'sanitization_cb' => 'pw_select2_sanitise',
					),
                ),
            );

            $meta_boxes['training_buttons'] = array(
                'id' => 'training_buttons',
                'title' => __('TMF - Training Buttons', 'cmb2'),
                'object_types' => array('page'), // Post type
                //only show it on training pages
                'show_on'      => array( 'key' => 'page-template', 'value' => 'training.php' ),
                'context' => 'normal',
                'priority' => 'high',
                'show_names' => true, // Show field names on the left
                'fields' => array(
                    array(
                        'name' => __('Register button', 'cmb2'),
                        'desc' => __('Register course button URL', 'cmb2'),
                        'id' => $prefix . 'training_button_register',
                        'type' => 'text_url',
                    ),
                    array(
                        'name' => __('Register button text', 'cmb2'),
                        'desc' => __('Register  button text (default:register)', 'cmb2'),
                        'id' => $prefix . 'training_button_register_text',
                        'type' => 'text_medium',
                    ),
                    array(
                        'name' => __('Register icon', 'cmb2'),
                        'desc' => __('Select icon', 'cmb2'),
                        'id' => $prefix . 'training_button_register_icon',
                        'type'    => 'select',
                        'options' => array(
                                          'register' => __( 'register', 'cmb' ),
                                          'contact'   => __( 'contact', 'cmb' ),
                                          'link'     => __( 'link', 'cmb' ),
                                          'members'     => __( 'members', 'cmb' ),
                                           ),
                         'default' => 'custom',
                    ),
                    array(
                        'name' => __('Resume button', 'cmb2'),
                        'desc' => __('Resume training button URL', 'cmb2'),
                        'id' => $prefix . 'training_button_resume',
                        'type' => 'text_url',
                    ),
                     array(
                        'name' => __('Resume icon', 'cmb2'),
                        'id' => $prefix . 'training_button_resume_icon',
                        'type'    => 'checkbox',
                    ),
                    array(
                        'name' => __('Suggested Courses to take next', 'cmb2'),
                        'desc' => __('Suggested Courses to take next' , 'cmb2'),
                        'id' => $prefix . 'suggested_courses_online',
                        'options' => array('TMF_Add_Custom_metaboxes','all_training_courses')
                        'type' => 'pw_multiselect',
                        'sanitization_cb' => 'pw_select2_sanitise',
                    ),
                ),
            );



            $meta_boxes['tmf_testimonials'] = array(
                'id' => 'tmf_testimonials',
                'title' => __('TMF - Testimonials', 'cmb2'),
                'object_types' => array('testimonial'), // Post type
                'context' => 'normal',
                'priority' => 'high',
                'show_names' => true, // Show field names on the left
                'fields' => array(
                    array(
                        'name' => __('Job Role ', 'cmb2'),
                        'id' => $prefix . 'testimonials_role',
                        'type' => 'text_medium',
                    ),
                    array(
                        'name' => __('Company', 'cmb2'),
                        'id' => $prefix . 'testimonials_company',
                        'type' => 'text_medium',
                    ),
                 ),
            );

            $meta_boxes['tmf_events'] = array(
                'id' => 'tmf_events',
                'title' => __('TMF - Events', 'cmb2'),
                'object_types' => array('tmf_events'), // Post type
                'context' => 'normal',
                'priority' => 'high',
                'show_names' => true, // Show field names on the left
                'fields' => array(
                        array(
        				'id'          => $prefix . 'other_cities_time',
        				'type'        => 'group',
        				'description' => __( 'Please select the event location and time zone.<br />For Webinars you can select more than one city in order to give the user time zone references.', 'cmb2' ),
        				'options'     => array(
        					'group_title'   => __( 'Event location and time zone {#}', 'cmb2' ), // {#} gets replaced by row number
        					'add_button'    => __( 'Add Another City', 'cmb2' ),
        					'remove_button' => __( 'Remove City', 'cmb2' ),
        					'sortable'      => true, // beta
        				),
        				// Fields array works the same, except id's only need to be unique for this group. Prefix is not needed.
        				'fields'      => array(
        					array(
        						'name' => 'Location / city',
        						'id'   => 'title',
        						'type' => 'text',
        						// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
        					),
                            array(
                                'name' => __('Time zone', 'cmb2'),
                                'id' => $prefix . 'event_start_date',
                                'type' => 'select_timezone',
                            ),
        				),
        			),

                    array(
                        'name' => 'No start time needed',
                        'id'   => $prefix . 'no_start_time',
                        'type' => 'checkbox',
                        'description'=> 'Check this option if there is no start time. E.g. Past Events',
                    ),
                    array(
                        'name' => __('UTC start time and date', 'cmb2'),
                        'id' => $prefix . 'event_utc_start_date',
                        'type' => 'text_datetime_timestamp',
                    ),
                     array(
                        'name' => 'No end time needed',
                        'id'   => $prefix . 'no_end_time',
                        'type' => 'checkbox',
                        'description'=> 'Check this option if there is no end time. E.g. On-demand Webinars',
                    ),
                    array(
                        'name' => __('UTC end time and date', 'cmb2'),
                        'id' => $prefix . 'event_utc_end_date',
                        'type' => 'text_datetime_timestamp',
                    ),
					array(
                        'name' => 'Event Logo',
                        'desc' => 'Upload an image or enter an URL.',
                        'id' => $prefix . 'event_logo',
                        'type' => 'file',
                        // 'allow' => array( 'url', 'attachment' ) // limit to just attachments with array( 'attachment' )
                    ),
					array(
						'name' => 'Speaker',
						'id' => $prefix . 'speaker',
						'desc' => 'Speaker',
 						'options' => self::get_all_speakers(),
						'type' => 'pw_multiselect',
						'sanitization_cb' => 'pw_select2_sanitise',
					),
					array(
						'name' => 'Sponsor',
						'id' => $prefix . 'sponsor',
						'desc' => 'Sponsor',
 						'options' => self::get_all_sponsors(),
						'type' => 'pw_multiselect',
						'sanitization_cb' => 'pw_select2_sanitise',
					),
					array(
						'name' => 'Strategic Programs',
						'id' => $prefix . 'strategic_programs',
						'desc' => 'Strategic Programs',
 						'options' => self::get_all_strategic_programs(),
						'type' => 'pw_multiselect',
						'sanitization_cb' => 'pw_select2_sanitise',
					),
					
					array(
						'name' => 'Related Webinars',
						'id' => $prefix . 'related_webinars',
						'desc' => 'Related Webinars',
 						'options' => self::get_related_webinars(),
						'type' => 'pw_multiselect',
						'sanitization_cb' => 'pw_select2_sanitise',
					),

					array(
                        'name' => __('Sponsored webinars', 'cmb2'),
                        'desc' => __('Sponsored webinars', 'cmb2' ),
                        'id' => $prefix . 'sponsored_webinars',
                        'type' => 'checkbox',
                    ),

					array(
                        'name' => __('Register Online url', 'cmb2'),
                        'desc' => __('Register Online url', 'cmb2'),
                        'id' => $prefix . 'register_online_url',
                        'type' => 'text_url',
                    ),

					array(
                        'name' => __('View Webinar url', 'cmb2'),
                        'desc' => __('View Webinar url.', 'cmb2'),
                        'id' => $prefix . 'view_webinar_url',
                        'type' => 'text_url',
                    ),
					array(
                        'name' => __('Inform Category Feed URL', 'cmb2'),
                        'desc' => __('Inform Category Feed URL', 'cmb2'),
                        'id' => $prefix . 'inform_category',
                        'type' => 'text_url',
                    ),

                    array(
                        'name' => __('Color', 'cmb2'),
                        'desc' => __('Principal color of the event', 'cmb2'),
                        'id' => $prefix . 'event_color',
                        'type' => 'colorpicker',
                        'default'  => '#444444',
                    ),
                    array(
                        'name' => __('Call For Speakers Phase', 'cmb2'),
                        'desc' => __('Is open to Call for Speakers?', 'cmb2' ),
                        'id' => $prefix . 'event_cfs_phase',
                        'type' => 'checkbox',
                    ),
 

                )
            );
            return $meta_boxes;
        }

        public function all_pages_select_field_options() {
            global $post;
            $args = array(
                'posts_per_page' => -1,
                'offset' => 0,
                'category' => '',
                'category_name' => '',
                'orderby' => 'ID',
                'order' => 'DESC',
                'include' => '',
                //do not show current page
                'exclude' => array(
                    $post->ID,
                    '997',
                    '998',
                    '999',
                    ),
                'meta_key' => '',
                'meta_value' => '',
                //tmf_events, tmf_press, tmf_programs, post
                'post_type' => array(
                    'page',
                    'tmf_programs',
                    ),
                'post_mime_type' => '',
                'post_parent' => '',
                'post_status' => 'publish',
                'suppress_filters' => true);
            $pages = get_posts($args);

            $option_pages = array('' => 'None');
            foreach ($pages as $page) {
                $front_end_value = $page->ID . " [" . $page->post_type . "] -- " . $page->
                    post_title;
                $option_pages[$page->ID] = __($front_end_value, 'cmb2');
            }
            return $option_pages;
        }

        // return all training courses online
        public function all_training_courses() {
            global $post;
            $args = array(
                'posts_per_page' => -1,
                'offset' => 0,
                'category' => '',
                'category_name' => '',
                'orderby' => 'title',
                'order' => 'ASC',
                'include' => '',
                //do not show current page
                'exclude' => array($post->ID),
                'meta_key' => '',
                'meta_value' => '',
                'number'       => 120,
                'post_type' => array(
                    'page',
                    //'tmf_programs',
                    ),
                'post_mime_type' => '',
                'post_parent' => 12250,
                'post_status' => 'publish',
                'suppress_filters' => true);
            $pages = get_posts($args);

            $option_pages = array();
            foreach ($pages as $page) {
                $front_end_value =  $page-> post_title;
                $option_pages[$page->ID] = __($front_end_value, 'cmb2');
            }
            return $option_pages;
        }


        private function has_redirect_setting($postId){

            $internal_redirect = get_post_meta(absint($postId), '_TMF_redirect_url', true);
            $external_redirect = get_post_meta(absint($postId), '_TMF_redirect_external_url', true);
             if (('' !== $external_redirect || '' !== $internal_redirect) && !current_user_can('manage_options')){
                $return = '' != $external_redirect ? $external_redirect : $internal_redirect;
             }else{
                $return = false;
             }

             return $return;
        }

        //replace permalink to redirect url page setting if exists
        public function return_dinamic_permalink_from_page_setting($url, $post) {
            $redirect_to = self::has_redirect_setting($post->ID);
            if($redirect_to){
                if(is_numeric($redirect_to)){
                    remove_filter('post_type_link', 'return_dinamic_permalink_from_page_setting', 10, 2);
                    $url = get_permalink($redirect_to);
                    add_filter('post_type_link', array('TMF_Add_Custom_metaboxes','return_dinamic_permalink_from_page_setting'), 10, 2);
                }else{
                    $url = $redirect_to;
                }
            }
            return $url;
        }

        public function return_dinamic_permalink_from_page_setting_page($url, $postId) {

            $redirect_to = self::has_redirect_setting( $postId);

            if($redirect_to){
                if(is_numeric($redirect_to)){
                    remove_filter('page_link', 'return_dinamic_permalink_from_page_setting_page', 5, 2);
                    $url = get_permalink($redirect_to);
                    add_filter('page_link', array('TMF_Add_Custom_metaboxes','return_dinamic_permalink_from_page_setting_page'), 5, 2);
                }else{
                    $url = $redirect_to;
                }
            }
            return $url;
        }


        public function return_dinamic_permalink_from_page_setting_post($url, $post) {
            $redirect_to = self::has_redirect_setting($post->ID);

            if($redirect_to){
                if(is_numeric($redirect_to)){
                    remove_filter('page_link', 'return_dinamic_permalink_from_page_setting_post', 5, 2);
                    $url = get_permalink($redirect_to);
                    add_filter('page_link', array('TMF_Add_Custom_metaboxes', 'return_dinamic_permalink_from_page_setting_post'), 5, 2);
                }else{
                    $url = $redirect_to;
                }
            }
            return $url;
        }


        public function custom_menu_item_url_from_page_setting($atts, $item, $args) {
            $redirect_to = self::has_redirect_setting($item->object_id);
            if($redirect_to){
                if(is_numeric($redirect_to)){
                    $atts['href'] = get_permalink($redirect_to);
                }else{
                    $atts['rel'] = 'external';
                    $atts['href'] = $redirect_to;
                }
            }
            return $atts;
        }


        public function redirect_from_settings(){
            
            if(!is_single() && !is_page() && !is_product())
            return;
              
            global $post;
            $redirect_to = self::has_redirect_setting($post->ID);
            if($redirect_to){
                if(is_numeric($redirect_to)){
                    wp_redirect(get_permalink($redirect_to));
                    exit();
                }else{
                    wp_redirect($redirect_to, 301);
                    exit();
                }
            }
        }

        public function show_if_is_page($field){
            $slug ='page';
            return (isset($_POST['post_type']) && $slug == $_POST['post_type'] ) || $slug == $GLOBALS['post_type'];
        }

		public function get_all_speakers(){
			global $wpdb;

 			$users = $wpdb->get_results( "SELECT wp_users.ID, wp_users.display_name
										  FROM wp_users, wp_usermeta
										  WHERE (wp_users.ID = wp_usermeta.user_id)
										  AND ( ( meta_key = '_TMF_User_Role')
										  AND (  wp_usermeta.meta_value LIKE '%Speaker%' ) )
										GROUP BY wp_users.ID
										ORDER BY `user_id` ASC" );

			$speakers = array();
			foreach ($users as $user) {
                $display_name =  $user->display_name;
                 $speakers[$user->ID] = __($display_name, 'cmb2');
            }

 			return $speakers;
		}

		public function get_all_sponsors(){
			global $post;

            // get all terms in the taxonomy
            $terms = get_terms( 'sponsorship-categories' ); 
            // convert array of term objects to array of term IDs
            $term_ids = wp_list_pluck( $terms, 'term_id' );
 			
			$args = array(
			'post_type' => 'tmf_companies', 
			'posts_per_page' => -1,
			'tax_query' => array(
							array(
							 'taxonomy' => 'sponsorship-categories',
							 'field' => 'slug',
							 'terms' => 'webinar-sponsor'
							)
				)
			);

			$tmf_companies = get_posts( $args );

            $sponsors = array();
            foreach ($tmf_companies as $page) {
                $post_title = $page->post_title;
                $sponsors[$page->ID] = __($post_title, 'cmb2');
            }
            return $sponsors;
		}

		public function get_all_strategic_programs(){
			global $post;
             
			$args = array(
			'post_type' => 'tmf_programs', 
			'posts_per_page' => -1,
			'tax_query' => array(
							array(
							 'taxonomy' => 'tmf_programs_category',
							 'field' => 'slug',
							 'terms' => 'strategic_programs'
							)
				)
			);
			
            $tmf_programs = get_posts($args);

            $strategic_programs = array();
            foreach ($tmf_programs as $page) {
                $post_title = $page->post_title;
                $strategic_programs[$page->ID] = __($post_title, 'cmb2');
            }
            return $strategic_programs;
		}
		
		public function get_related_webinars(){
			global $post;
             
			$args = array(
			'post_type' => 'tmf_events', 
			'posts_per_page' => -1,
			'tax_query' => array(
							array(
							 'taxonomy' => 'tmf_event_category',
							 'field' => 'slug',
							 'terms' => 'webinar'
							)
				)
			);
			
            $tmf_events = get_posts($args);

            $related_webinars = array();
            foreach ($tmf_events as $page) {
                $post_title = $page->post_title;
                $related_webinars[$page->ID] = __($post_title, 'cmb2');
            }
            return $related_webinars;
		}
		
		public function get_all_events(){
			global $post;
             
			$args = array(
			'post_type' => 'tmf_events', 
			'posts_per_page' => -1,
 			);
			
            $all_events = get_posts($args);

            $tmf_events = array('' => 'None');
            foreach ($all_events as $page) {
                $post_title = $page->post_title;
                $tmf_events[$page->ID] = __($post_title, 'cmb2');
            }
            return $tmf_events;
		}

    }

}
