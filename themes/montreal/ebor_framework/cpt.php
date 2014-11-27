<?php
//LETS REGISTER THE CUSTOM POST TYPE => PORTFOLIO
add_action( 'init', 'register_portfolio' );

//HERE'S THE FUNCTION TO DO IT
function register_portfolio() {

//HERE'S AN ARRAY OF LABELS FOR PORTFOLIOS
    $labels = array( 
        'name' => __( 'Portfolios', 'montreal' ),
        'singular_name' => __( 'Portfolio', 'montreal' ),
        'add_new' => __( 'Add New', 'montreal' ),
        'add_new_item' => __( 'Add New Portfolio', 'montreal' ),
        'edit_item' => __( 'Edit Portfolio', 'montreal' ),
        'new_item' => __( 'New Portfolio', 'montreal' ),
        'view_item' => __( 'View Portfolio', 'montreal' ),
        'search_items' => __( 'Search Portfolios', 'montreal' ),
        'not_found' => __( 'No portfolios found', 'montreal' ),
        'not_found_in_trash' => __( 'No portfolios found in Trash', 'montreal' ),
        'parent_item_colon' => __( 'Parent Portfolio:', 'montreal' ),
        'menu_name' => __( 'Portfolios', 'montreal' ),
    );

//AND HERE'S AN ARRAY OF ARGUMENTS TO DEFINE PORTFOLIOS FUNCTIONALITY
    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        'description' => __('Portfolio entries for the montreal Theme.', 'montreal'),
        'supports' => array( 'title', 'editor', 'thumbnail', 'comments', 'post-formats' ),
        'taxonomies' => array( 'portfolio-category' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => true,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );

    register_post_type( 'portfolio', $args );
}

//ADD PORTFOLIO TAXONOMY
add_action('init', 'create_portfolio_taxonomies');
function create_portfolio_taxonomies(){
	register_taxonomy('portfolio-category', 'portfolio', array('hierarchial' => true, 'label' => 'Portfolio Categories', 'singular_label' => 'Portfolio Category', 'rewrite' => true));
}

//LETS REGISTER THE CUSTOM POST TYPE => TEAM MEMBERS
add_action( 'init', 'register_team' );

//HERE'S THE FUNCTION TO DO IT
function register_team() {

//HERE'S AN ARRAY OF LABELS FOR TEAM MEMBERS
    $labels = array( 
        'name' => __( 'Team Members', 'montreal' ),
        'singular_name' => __( 'Team Member', 'montreal' ),
        'add_new' => __( 'Add New', 'montreal' ),
        'add_new_item' => __( 'Add New Team Member', 'montreal' ),
        'edit_item' => __( 'Edit Team Member', 'montreal' ),
        'new_item' => __( 'New Team Member', 'montreal' ),
        'view_item' => __( 'View Team Member', 'montreal' ),
        'search_items' => __( 'Search Team Members', 'montreal' ),
        'not_found' => __( 'No Team Members found', 'montreal' ),
        'not_found_in_trash' => __( 'No Team Members found in Trash', 'montreal' ),
        'parent_item_colon' => __( 'Parent Team Member:', 'montreal' ),
        'menu_name' => __( 'Team Members', 'montreal' ),
    );

//AND HERE'S AN ARRAY OF ARGUMENTS TO DEFINE TEAM MEMBERS FUNCTIONALITY
    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        'description' => __('Team Member entries for the montreal Theme.', 'montreal'),
        'supports' => array( 'title', 'thumbnail' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => true,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );

    register_post_type( 'team', $args );
}

//LETS REGISTER THE CUSTOM POST TYPE => CLIENTS
add_action( 'init', 'register_clients' );

//HERE'S THE FUNCTION TO DO IT
function register_clients() {

//HERE'S AN ARRAY OF LABELS FOR CLIENTS
    $labels = array( 
        'name' => __( 'Clients', 'montreal' ),
        'singular_name' => __( 'Client', 'montreal' ),
        'add_new' => __( 'Add New', 'montreal' ),
        'add_new_item' => __( 'Add New Client', 'montreal' ),
        'edit_item' => __( 'Edit Client', 'montreal' ),
        'new_item' => __( 'New Client', 'montreal' ),
        'view_item' => __( 'View Client', 'montreal' ),
        'search_items' => __( 'Search Clients', 'montreal' ),
        'not_found' => __( 'No Clients found', 'montreal' ),
        'not_found_in_trash' => __( 'No Clients found in Trash', 'montreal' ),
        'parent_item_colon' => __( 'Parent Client:', 'montreal' ),
        'menu_name' => __( 'Clients', 'montreal' ),
    );

//AND HERE'S AN ARRAY OF ARGUMENTS TO DEFINE CLIENTS FUNCTIONALITY
    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        'description' => __('Client entries for the montreal Theme.', 'montreal'),
        'supports' => array( 'title', 'thumbnail' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => true,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );

    register_post_type( 'clients', $args );
}

//LETS REGISTER THE CUSTOM POST TYPE => TESTIMONIALS
add_action( 'init', 'register_testimonial' );

//HERE'S THE FUNCTION TO DO IT
function register_testimonial() {

//HERE'S AN ARRAY OF LABELS FOR TESTIMONIALS
    $labels = array( 
        'name' => __( 'Testimonials', 'montreal' ),
        'singular_name' => __( 'Testimonial', 'montreal' ),
        'add_new' => __( 'Add New', 'montreal' ),
        'add_new_item' => __( 'Add New Testimonial', 'montreal' ),
        'edit_item' => __( 'Edit Testimonial', 'montreal' ),
        'new_item' => __( 'New Testimonial', 'montreal' ),
        'view_item' => __( 'View Testimonial', 'montreal' ),
        'search_items' => __( 'Search Testimonials', 'montreal' ),
        'not_found' => __( 'No Testimonials found', 'montreal' ),
        'not_found_in_trash' => __( 'No Testimonials found in Trash', 'montreal' ),
        'parent_item_colon' => __( 'Parent Testimonial:', 'montreal' ),
        'menu_name' => __( 'Testimonials', 'montreal' ),
    );

//AND HERE'S AN ARRAY OF ARGUMENTS TO DEFINE TESTIMONIALS FUNCTIONALITY
    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        'description' => __('Testimonial entries for the montreal Theme.', 'montreal'),
        'supports' => array( 'title', 'editor' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => true,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );

    register_post_type( 'testimonial', $args );
}

?>