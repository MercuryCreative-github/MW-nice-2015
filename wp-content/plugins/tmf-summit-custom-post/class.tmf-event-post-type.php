<?php
if (!class_exists('TMF_Summit_Post_Type')) {
	class TMF_Summit_Post_Type {

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
        }
        
        public static function init(){
            if ( ! self::$initiated ) {
			 self::init_hooks();
            }
            self::register_Summit_post_type();
            self::taxonomies();
        }
        
        private static function init_hooks() {
            self::$initiated = true;
            add_filter( 'single_template', array( 'TMF_Summit_Post_Type','get_custom_post_type_template'), 10,1);
        }
        
        private static function register_Summit_post_type() {
            $labels = array(
                'name'                => _x( 'TM Forum Session', 'Post Type General Name', 'text_domain' ),
                'singular_name'       => _x( 'Session', 'Post Type Singular Name', 'text_domain' ),
                'menu_name'           => __( 'Sessions', 'text_domain' ),
                'parent_item_colon'   => __( 'Parent Item:', 'text_domain' ),
                'all_items'           => __( 'All sessions', 'text_domain' ),
                'view_item'           => __( 'View Session', 'text_domain' ),
                'add_new_item'        => __( 'Add New Session', 'text_domain' ),
                'add_new'             => __( 'Add Session', 'text_domain' ),
                'edit_item'           => __( 'Edit Session', 'text_domain' ),
                'update_item'         => __( 'Update Session', 'text_domain' ),
                'search_items'        => __( 'Search Session', 'text_domain' ),
                'not_found'           => __( 'Session Not found', 'text_domain' ),
                'not_found_in_trash'  => __( 'Session Not found in Trash', 'text_domain' ),
            );
            $args = array(
                'label'               => __( 'session_type', 'text_domain' ),
                'description'         => __( 'session', 'text_domain' ),
                'labels'              => $labels,
                'taxonomies'          => array( 'post_type_dummits_category'),
                'hierarchical'        => false,
                'public'              => true,
                'show_ui'             => true,
                'show_in_menu'        => true,
                'show_in_nav_menus'   => true,
                'show_in_admin_bar'   => true,
                'menu_position'       => 5,
                'can_export'          => true,
                'has_archive'         => true,
                'exclude_from_search' => false,
                'publicly_queryable'  => true,
                'capability_type'     => 'page',
                'menu_icon'           => 'dashicons-calendar-alt',//ADD_SUMMIT_POST_TYPE__PLUGIN_URL.'/assets/img/summit_icon_16x16.png',
                'supports'          => array(
                    'title',
					/*'editor',*/
                    /*'thumbnail',*/
                    /*'custom-fields',
                    'excerpt',*/
                    
                ),
                'rewrite'=>array(
                    'slug'=>'session',),
            );
            register_post_type( 'tmf_sessions', $args );
        }
        
        public static function taxonomies(){
            
            $taxonomies = array();
            $taxonomies['tmf_summit_category']=array(
                'hierarchical'=> false, // no parent/children summits allowed
                'query_var'=>'tmfsummit',
				'show_admin_column' => true,
                'rewrite'  =>array(
                    'slug'=>'tmforum-summit'
                ),
                'labels'=> array(
                    'name'                       => _x( 'Summits', 'Summits General Name', 'text_domain' ),
                    'singular_name'              => _x( 'Summit', 'Taxonomy Singular Name', 'text_domain' ),
                    'menu_name'                  => __( 'Summits', 'text_domain' ),
                    'all_items'                  => __( 'All Items', 'text_domain' ),
                    'parent_item'                => __( 'Parent Summit', 'text_domain' ),
                    'parent_item_colon'          => __( 'Parent Item:', 'text_domain' ),
                    'new_item_name'              => __( 'New Summit', 'text_domain' ),
                    'add_new_item'               => __( 'Add New Summit', 'text_domain' ),
                    'edit_item'                  => __( 'Edit Summit', 'text_domain' ),
                    'update_item'                => __( 'Update Summit', 'text_domain' ),
                    'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
                    'search_items'               => __( 'Search Summits', 'text_domain' ),
                    'add_or_remove_items'        => __( 'Add or remove Summits', 'text_domain' ),
                    'choose_from_most_used'      => __( 'Choose from the most used Summits', 'text_domain' ),
                    'not_found'                  => __( 'Not Found', 'text_domain' ),                
                ),
                //'public'=> false,
            ); 

            self::register_all_taxonomies($taxonomies);
        }
        
        public static function register_all_taxonomies($taxonomies){
            foreach($taxonomies as $name=>$arr){
                if( ! taxonomy_exists( $name ) ){
                    register_taxonomy($name, array('tmf_sessions'), $arr);    
                }
            }
        }

        private static function is_Summit_post_type(){
            $slug = 'tmf_sessions';
            $is_Summit= false;
            if ( (isset($_POST['post_type']) && $slug == $_POST['post_type'] ) || $slug == $GLOBALS['post_type']) {
                $is_Summit= true;
            }
            return $is_Summit;
        }
        
        public static function get_custom_post_type_template($single_template){
            
            if (!self::is_Summit_post_type())
            return $single_template;
            
            global $post;

            if (self::is_Webinar($post)) {
                $webinar_template = get_stylesheet_directory() . '/theme/templates/session/webinar.php';
                if (file_exists($webinar_template  )){
                   $single_template = $webinar_template  ; 
                }
            }else{
                $Summit_template = get_stylesheet_directory() . '/theme/templates/session/Summit.php';
                if (file_exists($Summit_template)){
                   $single_template = $Summit_template;
                }
            }
            return $single_template;
        }
        
        private static function is_Webinar($post){
            
            if (!self::is_Summit_post_type())
            return false;
            
            $categories = get_the_terms( $post->ID, 'tmf_Summit_category' );
            $match=false;
            
            if(!$categories)
            return false;
            
            foreach ($categories as $cat) {
                if(strtolower($cat->name) == "webinar"){
                    $match=true;
                    break;
                }
            }
            return $match;
        }
    }
}