<?php 

//HERE COME THE THEME OPTIONS
add_action ('admin_menu', 'montreal_admin');
function montreal_admin() {
	// add the Customize link to the admin menu
	add_theme_page( 'Customize montreal', 'Customize montreal', 'edit_theme_options', 'customize.php' );
}

add_action('customize_register', 'montreal_customize');
function montreal_customize($wp_customize) {

class Example_Customize_Textarea_Control extends WP_Customize_Control {
    public $type = 'textarea';
 
    public function render_content() {
        ?>
        <label>
        <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
        <textarea rows="3" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
        </label>
        <?php
    }
}


///////////////////////////////////////
//     SOCIAL SECTION               //
/////////////////////////////////////
	
	//CREATE SOCIAL SUBSECTION
	$wp_customize->add_section( 'social_section', array(
		'title'          => 'Social Profiles',
		'priority'       => 35,
	) ); 
	
	//GOOGLEPLUS
	$wp_customize->add_setting('montreal_theme_options[google_link]', array(
	    'default'        => '',
	    'capability'     => 'edit_theme_options',
	    'type'           => 'option',
	));
	
	$wp_customize->add_control('google_link', array(
	    'label'      => __('Google+ Profile Link (Needs http://)', 'montreal'),
	    'section'    => 'social_section',
	    'settings'   => 'montreal_theme_options[google_link]',
	));
	
	//FACEBOOK
	$wp_customize->add_setting('montreal_theme_options[facebook_link]', array(
	    'default'        => '',
	    'capability'     => 'edit_theme_options',
	    'type'           => 'option',
	));
	
	$wp_customize->add_control('facebook_link', array(
	    'label'      => __('Facebook Profile Link (Needs http://)', 'montreal'),
	    'section'    => 'social_section',
	    'settings'   => 'montreal_theme_options[facebook_link]',
	));
	
	//TWITTER
	$wp_customize->add_setting('montreal_theme_options[twitter_link]', array(
	    'default'        => '',
	    'capability'     => 'edit_theme_options',
	    'type'           => 'option',
	));
	
	$wp_customize->add_control('twitter_link', array(
	    'label'      => __('Twitter Profile Link (Needs http://)', 'montreal'),
	    'section'    => 'social_section',
	    'settings'   => 'montreal_theme_options[twitter_link]',
	));



///////////////////////////////////////
//     COLOURS SECTION              //
/////////////////////////////////////

//HIGHLIGHT COLOUR SETTINGS
$wp_customize->add_setting('montreal_theme_options[highlight_color]', array(
    'default'           => '#43EDAB',
    'sanitize_callback' => 'sanitize_hex_color',
    'capability'        => 'edit_theme_options',
    'type'           => 'option',
 
));

//HIGHLIGHT COLOUR CONTROLS
$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'highlight_color', array(
    'label'    => __('Highlight Colour', 'montreal'),
    'section'  => 'colors',
    'settings' => 'montreal_theme_options[highlight_color]',
)));

//COPY COLOUR SETTINGS
$wp_customize->add_setting('montreal_theme_options[copy_color]', array(
    'default'           => '#111',
    'sanitize_callback' => 'sanitize_hex_color',
    'capability'        => 'edit_theme_options',
    'type'           => 'option',
 
));

//COPY COLOUR CONTROLS
$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'copy_color', array(
    'label'    => __('Colour A', 'montreal'),
    'section'  => 'colors',
    'settings' => 'montreal_theme_options[copy_color]',
)));

//HEADINGS COLOUR SETTINGS
$wp_customize->add_setting('montreal_theme_options[heading_color]', array(
    'default'           => '#fff',
    'sanitize_callback' => 'sanitize_hex_color',
    'capability'        => 'edit_theme_options',
    'type'           => 'option',
 
));

//HEADINGS COLOUR CONTROLS
$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'heading_color', array(
    'label'    => __('Colour B', 'montreal'),
    'section'  => 'colors',
    'settings' => 'montreal_theme_options[heading_color]',
)));
	
///////////////////////////////////////
//     CUSTOM LOGO SECTION          //
/////////////////////////////////////
	
	//CREATE CUSTOM LOGO SUBSECTION
	$wp_customize->add_section( 'custom_logo_section', array(
		'title'          => 'Custom Logo',
		'priority'       => 35,
	) );

	//CUSTOM LOGO SETTINGS
    $wp_customize->add_setting('montreal_theme_options[custom_logo]', array(
        'default'           => get_template_directory_uri() . '/img/logo.png',
        'capability'        => 'edit_theme_options',
        'type'           => 'option',

    ));
	
	//CUSTOM LOGO
    $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'custom_logo', array(
        'label'    => __('Custom Logo Upload', 'montreal'),
        'section'  => 'custom_logo_section',
        'settings' => 'montreal_theme_options[custom_logo]',
    )));
   
   
///////////////////////////////////////
//     CUSTOM FAVICON SECTION       //
/////////////////////////////////////
	

	//CUSTOM FAVICON SETTINGS
    $wp_customize->add_setting('montreal_theme_options[custom_favicon]', array(
        'default'           => get_template_directory_uri() . '/img/logo.png',
        'capability'        => 'edit_theme_options',
        'type'           => 'option',

    ));
	
	//CUSTOM FAVICON
    $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'custom_favicon', array(
        'label'    => __('Custom Favicon Upload', 'montreal'),
        'section'  => 'title_tagline',
        'settings' => 'montreal_theme_options[custom_favicon]',
        'priority'       => 11,
    )));
   


///////////////////////////////////////
//     CUSTOM STYLING SECTION       //
/////////////////////////////////////
	
	//CREATE CUSTOM STYLING SUBSECTION
	$wp_customize->add_section( 'custom_styling', array(
		'title'          => 'Styling',
		'priority'       => 35,
	) ); 
	
	//SIDEBAR
	$wp_customize->add_setting('montreal_theme_options[sidebar]', array(
	    'default'        => '1',
	    'capability'     => 'edit_theme_options',
	    'type'           => 'option',
	));
	
	//SIDEBAR
	$wp_customize->add_control( 'sidebar', array(
	    'settings' => 'montreal_theme_options[sidebar]',
	    'label'   => __('Show Sidebar on Single-Blog Posts?', 'montreal'),
	    'section' => 'custom_styling',
	    'type'    => 'select',
	    'choices'    => array(
	        '1' => 'Yes',
	        '0' => 'No',
	    ),
	));
	
	//BLOG TITLE
	$wp_customize->add_setting('montreal_theme_options[blog_title]', array(
	    'default'        => 'Our Blog',
	    'capability'     => 'edit_theme_options',
	    'type'           => 'option',
	));
	
	$wp_customize->add_control('blog_title', array(
	    'label'      => __('Bold intro for Blog Section', 'montreal'),
	    'section'    => 'custom_styling',
	    'settings'   => 'montreal_theme_options[blog_title]',
	));
	
	//PORTFOLIO TITLE
	$wp_customize->add_setting('montreal_theme_options[portfolio_title]', array(
	    'default'        => 'Our Portfolio',
	    'capability'     => 'edit_theme_options',
	    'type'           => 'option',
	));
	
	$wp_customize->add_control('portfolio_title', array(
	    'label'      => __('Title for /portfolio', 'montreal'),
	    'section'    => 'custom_styling',
	    'settings'   => 'montreal_theme_options[portfolio_title]',
	));
	
	//THANKS PAGE URL
	$wp_customize->add_setting('montreal_theme_options[thanks_url]', array(
	    'default'        => '',
	    'capability'     => 'edit_theme_options',
	    'type'           => 'option',
	));
	
	$wp_customize->add_control('thanks_url', array(
	    'label'      => __('URL of the Thanks Page', 'montreal'),
	    'section'    => 'custom_styling',
	    'settings'   => 'montreal_theme_options[thanks_url]',
	));
   
   //VIEW POST
   $wp_customize->add_setting('montreal_theme_options[view_project]', array(
       'default'        => 'VIEW PROJECT',
       'capability'     => 'edit_theme_options',
       'type'           => 'option',
   ));
   
   $wp_customize->add_control('view_project', array(
       'label'      => __('View Project Text', 'montreal'),
       'section'    => 'custom_styling',
       'settings'   => 'montreal_theme_options[view_project]',
   ));
   
   //VIEW POST
   $wp_customize->add_setting('montreal_theme_options[read_post]', array(
       'default'        => 'READ POST',
       'capability'     => 'edit_theme_options',
       'type'           => 'option',
   ));
   
   $wp_customize->add_control('read_post', array(
       'label'      => __('Read Post Text', 'montreal'),
       'section'    => 'custom_styling',
       'settings'   => 'montreal_theme_options[read_post]',
   ));
   
   //BACKGROUDN IMAGE SETTINGS
       $wp_customize->add_setting('montreal_theme_options[background_image]', array(
           'default'           => get_template_directory_uri() . '/images/stripes.png',
           'capability'        => 'edit_theme_options',
           'type'           => 'option',
   
       ));
   	
   	//BACKGROUND IMAGE
       $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'background_image', array(
           'label'    => __('Background Image', 'montreal'),
           'section'  => 'custom_styling',
           'settings' => 'montreal_theme_options[background_image]',
       )));
       
       //BACKGROUDN IMAGE SETTINGS
           $wp_customize->add_setting('montreal_theme_options[background_image_faded]', array(
               'default'           => get_template_directory_uri() . '/images/stripesblack.png',
               'capability'        => 'edit_theme_options',
               'type'           => 'option',
       
           ));
       	
       	//BACKGROUND IMAGE
           $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'background_image_faded', array(
               'label'    => __('Low Opacity Image for Homepage Slideshow overlay', 'montreal'),
               'section'  => 'custom_styling',
               'settings' => 'montreal_theme_options[background_image_faded]',
           )));
       


   
   ///////////////////////////////////////
   //     CUSTOM CSS SECTION           //
   /////////////////////////////////////
   	
   	//CREATE CUSTOM CSS SUBSECTION
   	$wp_customize->add_section( 'custom_css_section', array(
   		'title'          => 'Custom CSS',
   		'priority'       => 200,
   	) ); 
      
      $wp_customize->add_setting( 'montreal_theme_options[custom_css]', array(
          'default'        => '',
          'capability'     => 'edit_theme_options',
          'type'           => 'option',
      ) );
       
      $wp_customize->add_control( new Example_Customize_Textarea_Control( $wp_customize, 'custom_css', array(
          'label'   => __('Custom CSS', 'montreal'),
          'section' => 'custom_css_section',
          'settings'   => 'montreal_theme_options[custom_css]',
      ) ) );
      
      
      ///////////////////////////////////////
      //     GOOGLE ANALYTICS             //
      /////////////////////////////////////
      	
      	//CREATE CUSTOM CSS SUBSECTION
      	$wp_customize->add_section( 'google_section', array(
      		'title'          => 'Google Analytics Code',
      		'priority'       => 200,
      	) ); 
         
         $wp_customize->add_setting( 'montreal_theme_options[google_analytics]', array(
             'default'        => '',
             'capability'     => 'edit_theme_options',
             'type'           => 'option',
         ) );
          
         $wp_customize->add_control( new Example_Customize_Textarea_Control( $wp_customize, 'google_analytics', array(
             'label'   => __('Google Analytics Code - Include <script> tags!', 'montreal'),
             'section' => 'google_section',
             'settings'   => 'montreal_theme_options[google_analytics]',
         ) ) );
         
   
}

?>