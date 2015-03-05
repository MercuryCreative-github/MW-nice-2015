<?php
if (!class_exists('tmf_presentation_Post_Type')) {
	class tmf_presentation_Post_Type {

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
            self::register_presentation_post_type();
        }
        
        private static function init_hooks() {
            self::$initiated = true;
        }
        
        private static function register_presentation_post_type() {
            $labels = array(
                'name'                => _x( 'TM Forum Presentations', 'Post Type General Name', 'text_domain' ),
                'singular_name'       => _x( 'Presentation', 'Post Type Singular Name', 'text_domain' ),
                'menu_name'           => __( 'Presentations', 'text_domain' ),
                'parent_item_colon'   => __( 'Parent Item:', 'text_domain' ),
                'all_items'           => __( 'All Presentations', 'text_domain' ),
                'view_item'           => __( 'View Presentation', 'text_domain' ),
                'add_new_item'        => __( 'Add New Presentation', 'text_domain' ),
                'add_new'             => __( 'Add Presentation', 'text_domain' ),
                'edit_item'           => __( 'Edit Presentation', 'text_domain' ),
                'update_item'         => __( 'Update Presentation', 'text_domain' ),
                'search_items'        => __( 'Search Presentation', 'text_domain' ),
                'not_found'           => __( 'Presentation Not found', 'text_domain' ),
                'not_found_in_trash'  => __( 'Presentation Not found in Trash', 'text_domain' ),
            );
            $args = array(
                'label'               => __( 'Presentations_type', 'text_domain' ),
                'menu_icon'           => 'dashicons-microphone',//ADD_PRESENTATION_POST_TYPE__PLUGIN_DIR.'/assets/img/Presentation_icon_16x16.png',
                'description'         => __( 'Presentations', 'text_domain' ),
                'public'              => true,
                'show_ui'             => true,
                'show_in_menu'        => true,
                'show_in_nav_menus'   => true,
                'show_in_admin_bar'   => true,
                'labels'              => $labels,
                'taxonomies'          => array( 'post_type_Presentations_category' ),
                'hierarchical'        => false,
                'menu_position'       => 7,
                'can_export'          => true,
                'has_archive'         => true,
                'exclude_from_search' => false,
                'publicly_queryable'  => true,
                'capability_type'     => 'page',
                'map_meta_cap' => true, // Set to false, if users are not allowed to edit/delete existing posts
                
                'supports'          => array(
                    'title',
					'editor',
                    /*'thumbnail',
                    'custom-fields',
                    'excerpt',*/
                    'revisions',                    
                ),
                'rewrite'=>array(
                    'slug'=>'presentations','with_front' => true),
            );
            register_post_type( 'agenda_tracks', $args );
        }
      
        
        
      
        
    }
}