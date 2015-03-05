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
           // if (is_plugin_active('cmb2/init.php')) {
                add_filter('cmb2_meta_boxes', array('TMF_Add_Custom_metaboxes','cmb2_TMF_metaboxes'));

                //replace permalink to redirect url page setting if exists
                //used for redirect_url metabox
                add_filter('post_type_link', array('TMF_Add_Custom_metaboxes','return_dinamic_permalink_from_page_setting'), 5, 2);
                add_filter('page_link', array('TMF_Add_Custom_metaboxes','return_dinamic_permalink_from_page_setting_page'), 5, 2);
                add_filter('post_link', array('TMF_Add_Custom_metaboxes','return_dinamic_permalink_from_page_setting_post'), 5, 2);
                add_filter('nav_menu_link_attributes', array('TMF_Add_Custom_metaboxes','custom_menu_item_url_from_page_setting'), 5, 3);
                add_action('template_redirect', array('TMF_Add_Custom_metaboxes','redirect_from_settings'));
           // }
        }
        public function cmb2_TMF_metaboxes(array $meta_boxes) {

            // Start with an underscore to hide fields from custom fields list
            $prefix = '_TMF_';

            $meta_boxes['redirect_url']  = array(
                'id' => 'redirect_url',
                'title' => __('TMF - Page Settings', 'cmb2'),
                'object_types' => array('page','tmf_sessions','tmf_presentations', 'post'),
                'context' => 'normal',
                'priority' => 'high',
                'show_names' => true, // Show field names on the left
                'fields' => array(
                    array(
                        'name' => __('Redirect to internal page', 'cmb2'),
                        'desc' => __('Select an internal page to redirect, the permalink will be replaced.', 'cmb2'),
                        'id' => $prefix . 'redirect_url',
                        'type' => 'pw_select',
                        'options' => self::all_pages_select_field_options(),

                    ),
                     array(
                        'name' => __('Redirect to external url', 'cmb2'),
                        'desc' => __('Write a valid url to redirect, the permalink will be replaced. If this is not blank, the above selection will be omitted.', 'cmb2'),
                        'id' => $prefix . 'redirect_external_url',
                        'type' => 'text_url',
                    ),
         
                   
                ),
            );

           $meta_boxes['tmf_events'] = array(
                'id' => 'tmf_events',
                'title' => __('TM Forum Sessions settings', 'cmb2'),
                'object_types' => array('tmf_sessions'), // Post type
                'context' => 'normal',
                'priority' => 'high',
                'show_names' => true, // Show field names on the left
                'fields' => array(
                   
                    array(
                        'name' => __('Sesion start time and date', 'cmb2'),
                        'id' => $prefix . 'session_start_date',
                        'type' => 'text_datetime_timestamp',
                    ),
                    
                    array(
                        'name' => __('Session end time and date', 'cmb2'),
                        'id' => $prefix . 'session_end_date',
                        'type' => 'text_datetime_timestamp',
                    ),

                    array(
                        'name' => 'Chair',
                        'id' => $prefix . 'chair',
                        'desc' => 'Chair',
                        'options' => self::get_all_speakers(),
                        'type' => 'pw_select',
                        'sanitization_cb' => 'pw_select2_sanitise',
                    ),

                    array(
                        'name' => 'Session Sponsor',
                        'id' => $prefix . 'sponsors',
                        'desc' => 'Sponsor',
                        'options' => self::get_all_sponsors(),
                        'type' => 'pw_multiselect',
                        'sanitization_cb' => 'pw_select2_sanitise',
                    ),
                    array(
                        'name' => 'Summit icon',
                        'desc' => 'Upload the summit icon.',
                        'id' => $prefix . 'summit_image',
                        'type' => 'file',
                        // Optionally allow only attachments and not any URL (this hides the text input for the url):
                        "options" => array(
                            "url" => false
                    )

                    /*array(
                        'name' => 'Summit',
                        'id' => $prefix . 'session_summits',
                        'desc' => 'Select the session this summit is included',
                        'options' => self::get_summits(),
                        'type' => 'pw_multiselect',
                        'sanitization_cb' => 'pw_select2_sanitise',

                    ),*/
                )
            );

           $meta_boxes['agenda_tracks'] = array(
                'id' => 'agenda_tracks',
                'title' => __('TM Forum Presentations settings', 'cmb2'),
                'object_types' => array('agenda_tracks'), // Post type
                'context' => 'normal',
                'priority' => 'high',
                'show_names' => true, // Show field names on the left
                'fields' => array(
                   
                    array(
                        'name' => __('Presentations subtitle', 'cmb2'),
                        'id' => $prefix . 'presentations_subtitle',
                        'type' => 'text',
                    ),

                    array(
                        'name' => __('Presentations start time and date', 'cmb2'),
                        'id' => $prefix . 'presentations_start_date',
                        'type' => 'text_datetime_timestamp',
                    ),
                    
                    array(
                        'name' => __('presentations end time and date', 'cmb2'),
                        'id' => $prefix . 'presentations_end_date',
                        'type' => 'text_datetime_timestamp',
                    ),

                    array(
                        'name' => __('Location', 'cmb2'),
                        'id' => $prefix . 'presentations_location',
                        'type' => 'text',
                    ),

                    array(
                        'name' => 'Presentation Speakers',
                        'id' => 'speakers_meta',
                        'desc' => 'Select the Speakers',
                        'options' => self::get_all_speakers(),
                        'type' => 'pw_multiselect',
                        'sanitization_cb' => 'pw_select2_sanitise',
                    ),


                    array(
                        'name' => 'Presentation Collaborators',
                        'id' => 'collaborators_meta',
                        'desc' => 'Select the Collaborators',
                        'options' => self::get_all_speakers(),
                        'type' => 'pw_multiselect',
                        'sanitization_cb' => 'pw_select2_sanitise',
                    ),


                    array(
                        'name' => 'Presentations Panelists',
                        'id' => 'panelists_meta',
                        'desc' => 'Select the Panelists',
                        'options' => self::get_all_speakers(),
                        'type' => 'pw_multiselect',
                        'sanitization_cb' => 'pw_select2_sanitise',
                    ),


                    array(
                        'name' => 'Presentations Facilitators',
                        'id' => 'facilitators_meta',
                        'desc' => 'Select the Facilitators',
                        'options' => self::get_all_speakers(),
                        'type' => 'pw_multiselect',
                        'sanitization_cb' => 'pw_select2_sanitise',
                    ),


                    array(
                        'name' => 'Presentations Moderators',
                        'id' => 'moderators_meta',
                        'desc' => 'Select the Moderators',
                        'options' => self::get_all_speakers(),
                        'type' => 'pw_multiselect',
                        'sanitization_cb' => 'pw_select2_sanitise',
                    ),

                    array(
                        'name' => 'Session',
                        'id' => $prefix . 'presentation_session',
                        'desc' => 'Select the session this presentation is included',
                        'options' => self::get_all_sessions(),
                        'type' => 'pw_select',
                        'sanitization_cb' => 'pw_select2_sanitise',

                    ),
                    array(
                        'name' => __('Revolution slider', 'cmb2'),
                        'id'  => 'revolution_slider',
                        'desc' => 'Please add the slider alis here. Most used sliders: slider-internet-of-things, slider-customer-centricity-analytics, slider-managing-nfv-sdn, slider-business-innovation, slider-digital-operations',
                        'type' => 'text',
                    ),
                    array(
                        'name' => 'Summit Color Picker',
                        'id'   => $prefix . 'summit_colorpicker',
                        'desc' => 'Please add the summit main color. Customer Centricity & Analytics: #F3A626; Internet of Things: #AA1C78; Managing NFV-SDN: #7DB342; Business Innovation: #225F91; Digital Operations: #27ABB2'
                        'type' => 'colorpicker',
                        'default'  => '#AA1C78',
                    )
                    /*array(
                        'name' => 'Summit',
                        'id' => $prefix . 'session_summits',
                        'desc' => 'Select the session this summit is included',
                        'options' => self::get_summits(),
                        'type' => 'pw_multiselect',
                        'sanitization_cb' => 'pw_select2_sanitise',

                    ),*/
                )
            );

            $meta_boxes['agenda_tracks_users'] = array(
                            'id' => 'agenda_tracks_users',
                            'title' => __('TM Forum Presentations', 'cmb2'),
                            'object_types' => array('user'), // Post type
                            'context' => 'normal',
                            'priority' => 'high',
                            'show_names' => true, // Show field names on the left
                            'fields' => array(
                               
                                array(
                                    'name' => 'Speaker at',
                                    'id' =>  'speaker_at',
                                    'desc' => 'Select the Presentations this user speaks at',
                                    'options' => self::get_all_presentations(),
                                    'type' => 'pw_multiselect',
                                    'sanitization_cb' => 'pw_select2_sanitise',
                                ),
                               
                                array(
                                    'name' => 'Moderator at',
                                    'id' =>  'moderator_at',
                                    'desc' => 'Select the Presentations this user moderates at',
                                    'options' => self::get_all_presentations(),
                                    'type' => 'pw_multiselect',
                                    'sanitization_cb' => 'pw_select2_sanitise',
                                ),
                               
                                array(
                                    'name' => 'Panelist at',
                                    'id' =>  'panelist_at',
                                    'desc' => 'Select the Presentations where this user is panelist',
                                    'options' => self::get_all_presentations(),
                                    'type' => 'pw_multiselect',
                                    'sanitization_cb' => 'pw_select2_sanitise'
                                ),

                               
                                array(
                                    'name' => 'Collaborator at',
                                    'id' =>  'collaborator_at',
                                    'desc' => 'Select the Presentations this user collaborates at',
                                    'options' => self::get_all_presentations(),
                                    'type' => 'pw_multiselect',
                                    'sanitization_cb' => 'pw_select2_sanitise',

                                ),

                                array(
                                    'name' => 'Facilitator at',
                                    'id' =>  'facilitator_at',
                                    'desc' => 'Select the Presentations this user faciliatates at',
                                    'options' => self::get_all_presentations(),
                                    'type' => 'pw_multiselect',
                                    'sanitization_cb' => 'pw_select2_sanitise',

                                ),

                                /*array(
                                    'name' => 'Chair at',
                                    'id' =>  'chair_at',
                                    'desc' => 'Select the Session this user is chair.',
                                    'options' => self::get_all_sessions(),
                                    'type' => 'pw_multiselect',
                                    'sanitization_cb' => 'pw_select2_sanitise',

                                ),*/

                                 array(
                                    'name' => 'Company',
                                    'id' => 'company',
                                    'desc' => 'Company',
                                    'options' => self::get_all_sponsors(),
                                    'type' => 'pw_multiselect',
                                    'sanitization_cb' => 'pw_select2_sanitise',
                                ),

                                array(
                                    'name' => __('New Company', 'cmb2'),
                                    'id' => 'new_company',
                                    'type' => 'text',
                                ),

                                array(
                                    'name' => __('Job Role', 'cmb2'),
                                    'id' => 'job_role',
                                    'type' => 'text',
                                ),

                                array(
                                    'name' => __('Twitter Ailas', 'cmb2'),
                                    'id' => 'twitter_alias',
                                    'type' => 'text',
                                ),

                                array(
                                    'name' => __('Biography', 'cmb2'),
                                    'id' => 'biography',
                                    'type' => 'wysiwyg',
                                ),

                                array(
                                    'name' => __('Head shot', 'cmb2'),
                                    'id' => 'image',
                                    'type' => 'file',
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
                'exclude' => false,
                'meta_key' => '',
                'meta_value' => '',
                //tmf_events, tmf_sessions, tmf_programs, post
                'post_type' => array(
                    'page',
                    'tmf_sessions',
                    'agenda_tracks',
                    'posts',
                    ),
                'post_mime_type' => '',
                'post_parent' => '',
                'post_status' => 'publish',
                'suppress_filters' => true);
            $pages = get_posts($args);

            foreach ($pages as $page) {

                $post_type = get_post_type_object( get_post_type( $page->ID ) );

                $front_end_value =  $page->post_title . " [" .  $post_type->label . "] ";
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
            
            if(!is_single() && !is_page())
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

                $args = array(
                'role'=>'speaker',
                );// meta_query);

                $user_query = new WP_User_Query( $args );

                foreach ( $user_query->results as $user ){
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
            'post_type' => 'companies', 
            'posts_per_page' => -1,
     
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
                             'terms' => 'strategic-programs'
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
		
		  public function get_all_related_programs(){
            global $post;
             
            $args = array(
            'post_type' => 'tmf_programs', 
            'posts_per_page' => -1,
            'tax_query' => array(
                            array(
                             'taxonomy' => 'tmf_programs_category',
                             'field' => 'slug',
                             'terms' => 'programs'
                            )
                )
            );
            
            $tmf_programs = get_posts($args);
			 
            $programs = array();
            foreach ($tmf_programs as $page) {
                $post_title = $page->post_title;
                $programs[$page->ID] = __($post_title, 'cmb2');
            }
            return $programs;
        }
		
		 public function get_all_related_publications(){
            global $post;
             
            $args = array(
            'post_type' => 'product',
    		'post_status' => 'publish',
            'posts_per_page' => -1,
            'tax_query' => array(
                            array(
                             'taxonomy' => 'product_cat',
                             'field' => 'slug',
                             'terms' => 'research-and-analysis'
                            )
                )
            );
            
            $tmf_publication = get_posts($args);
			 
            $related_publication = array();
            foreach ($tmf_publication as $page) {
                $post_title = $page->post_title;
                $related_publication[$page->ID] = __($post_title, 'cmb2');
            }
            return $related_publication;
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
        
        public function get_all_sessions(){
            global $post;
             
            $args = array(
            'post_type' => 'tmf_sessions', 
            'posts_per_page' => -1,
            );
            
            $all_events = get_posts($args);

            foreach ($all_events as $page) {
                $post_title = $page->post_title;
                $tmf_events[$page->ID] = __($post_title, 'cmb2');
            }

            return $tmf_events;
        }
        public function get_all_presentations(){
            global $post;
             
            $args = array(
            //'post_type' => 'agenda_tracks', 
            'post_type' => 'agenda_tracks', 
            'posts_per_page' => -1,
            );
            
            $all_events = get_posts($args);

            foreach ($all_events as $page) {
                $post_title = $page->post_title;
                $tmf_events[$page->ID] = __($post_title, 'cmb2');
            }

            wp_reset_query();

            return $tmf_events;
        }


		
         public function get_event_categories(){
            
            $category_id = get_term_by( 'slug', 'webinar', 'tmf_event_category' );
            $webinar_cat = $category_id->term_id; 
            $categories = get_terms( array( 'tmf_event_category' ), array( "parent" => "0", "hide_empty" => false ) );  
            
            

            $event_categories = array();
            foreach ($categories as $category) {
                
                $category_term_id = $category->term_id;
                $category_name = $category->name;
                
                $event_categories[$category_term_id] = __($category_name, 'cmb2');
            }
         
            return $event_categories;
        }

        public function get_summits(){
            
        $taxonomies = array( 
            'tmf_summit_category',
        );
        $terms = get_terms($taxonomies, $args);
        
        $event_categories = array();
        
        foreach ($terms as $category) {
                
           $category_term_id = $category->term_id;
           $category_name = $category->name;
                
           $event_categories[$category_term_id] = __($category_name, 'cmb2');
        }
        
        return $event_categories;

        }

    }

}
