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
            add_action('admin_head', array( 'TMF_Summit_Post_Type', 'hd_add_buttons' ) );
            add_action('admin_init', array( 'TMF_Summit_Post_Type', 'add_edit_Summit_caps') );
            add_filter( 'single_template', array( 'TMF_Summit_Post_Type','get_custom_post_type_template'), 10,1);
        }
        
        private static function register_Summit_post_type() {
            $labels = array(
                'name'                => _x( 'TM Forum Registered Summits', 'Post Type General Name', 'text_domain' ),
                'singular_name'       => _x( 'Summit', 'Post Type Singular Name', 'text_domain' ),
                'menu_name'           => __( 'Summits', 'text_domain' ),
                'parent_item_colon'   => __( 'Parent Item:', 'text_domain' ),
                'all_items'           => __( 'All Summits', 'text_domain' ),
                'view_item'           => __( 'View Summit', 'text_domain' ),
                'add_new_item'        => __( 'Add New Summit', 'text_domain' ),
                'add_new'             => __( 'Add Summit', 'text_domain' ),
                'edit_item'           => __( 'Edit Summit', 'text_domain' ),
                'update_item'         => __( 'Update Summit', 'text_domain' ),
                'search_items'        => __( 'Search Summit', 'text_domain' ),
                'not_found'           => __( 'Summit Not found', 'text_domain' ),
                'not_found_in_trash'  => __( 'Summit Not found in Trash', 'text_domain' ),
            );
            $args = array(
                'label'               => __( 'Summits_type', 'text_domain' ),
                'description'         => __( 'Summits', 'text_domain' ),
                'labels'              => $labels,
                'taxonomies'          => array( 'post_type_dummits_category', 'post_tag' ),
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
                'menu_icon'           => ADD_SUMMIT_POST_TYPE__PLUGIN_URL.'/assets/img/Summit_icon_16x16.png',
                'map_meta_cap' => true, // Set to false, if users are not allowed to edit/delete existing posts
                'capabilities' => array(
                    // meta caps (don't assign these to roles)
                    'edit_post' => 'edit_tmf_Summit',
                    'read_post' => 'read_tmf_Summit',
                    'delete_post' => 'delete_tmf_Summit',
                     
                    // primitive/meta caps
                    'create_posts' => 'create_tmf_summit',
                     
                    // primitive caps used outside of map_meta_cap()
                    'edit_posts' => 'edit_tmf_summits',
                    'edit_others_posts' => 'manage_tmf_summits',
                    'publish_posts' => 'edit_tmf_summits',
                    'read_private_posts' => 'read',
                     
                    // primitive caps used inside of map_meta_cap()
                    'read' => 'read',
                    'delete_posts' => 'delete_tmf_summits',
                    'delete_private_posts' => 'delete_tmf_summits',
                    'delete_published_posts' => 'delete_tmf_summits',
                    'delete_others_posts' => 'delete_tmf_summits',
                    'edit_private_posts' => 'edit_tmf_summits',
                    'edit_published_posts' => 'edit_tmf_summits'
                ),                
                'supports'          => array(
                    'title',
					'editor',
                    'thumbnail',
                    'custom-fields',
                    'excerpt',
                    
                ),
                'rewrite'=>array(
                    'slug'=>'Summits',),
            );
            register_post_type( 'tmf_summits', $args );
        }
        
        public function taxonomies(){
            
            $taxonomies = array();
            $taxonomies['tmf_summit_category']=array(
                'hierarchical'=> true,
                'query_var'=>'tmfsummit',
				'show_admin_column' => true,
                'rewrite'  =>array(
                    'slug'=>'tmforum-summits'
                ),
                'labels'=> array(
                    'name'                       => _x( 'Sessions', 'Sessions General Name', 'text_domain' ),
                    'singular_name'              => _x( 'Session', 'Taxonomy Singular Name', 'text_domain' ),
                    'menu_name'                  => __( 'Sessions', 'text_domain' ),
                    'all_items'                  => __( 'All Items', 'text_domain' ),
                    'parent_item'                => __( 'Parent Session', 'text_domain' ),
                    'parent_item_colon'          => __( 'Parent Item:', 'text_domain' ),
                    'new_item_name'              => __( 'New Session', 'text_domain' ),
                    'add_new_item'               => __( 'Add New Session', 'text_domain' ),
                    'edit_item'                  => __( 'Edit Session', 'text_domain' ),
                    'update_item'                => __( 'Update Session', 'text_domain' ),
                    'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
                    'search_items'               => __( 'Search Sessions', 'text_domain' ),
                    'add_or_remove_items'        => __( 'Add or remove Sessions', 'text_domain' ),
                    'choose_from_most_used'      => __( 'Choose from the most used Sessions', 'text_domain' ),
                    'not_found'                  => __( 'Not Found', 'text_domain' ),                
                ),
                //'public'=> false,
            ); 

            self::register_all_taxonomies($taxonomies);
        }
        
        public function register_all_taxonomies($taxonomies){
            foreach($taxonomies as $name=>$arr){
                if( ! taxonomy_exists( $name ) ){
                    register_taxonomy($name, array('tmf_summits'), $arr);    
                }
            }
        }
        
        public static function hd_add_buttons() {
            global $pagenow;
            if(is_admin()){
                ?>
                    <style>
                    #menu-posts-tmf_summits_type .current img{
                        opacity: 1;} 
                    </style>
                <?php
            }  
        }
        
        public static function add_edit_Summit_caps(){
            $admin_role = get_role( 'administrator' );
                $admin_role  ->add_cap( 'edit_tmf_summits' );
                $admin_role  ->add_cap( 'manage_tmf_summits' );
                $admin_role  ->add_cap( 'create_tmf_summit' );
                
            
            $editor_role = get_role( 'editor' );
                $editor_role ->add_cap( 'edit_tmf_summits' );
                $editor_role ->add_cap( 'manage_tmf_summits' );
                $admin_role  ->add_cap( 'create_tmf_summit' );

        }

        private function is_Summit_post_type(){
            $slug = 'tmf_summits';
            $is_Summit= false;
            if ( (isset($_POST['post_type']) && $slug == $_POST['post_type'] ) || $slug == $GLOBALS['post_type']) {
                $is_Summit= true;
            }
            return $is_Summit;
        }
        
        public function get_custom_post_type_template($single_template){
            
            if (!self::is_Summit_post_type())
            return $single_template;
            
            global $post;

            if (self::is_Webinar($post)) {
                $webinar_template = get_stylesheet_directory() . '/theme/templates/Summits/webinar.php';
                if (file_exists($webinar_template  )){
                   $single_template = $webinar_template  ; 
                }
            }else{
                $Summit_template = get_stylesheet_directory() . '/theme/templates/Summits/Summit.php';
                if (file_exists($Summit_template)){
                   $single_template = $Summit_template;
                }
            }
            return $single_template;
        }
        
        private function is_Webinar($post){
            
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