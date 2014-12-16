<?php

//REGISTER CUSTOM MENUS
function register_my_menus() {
  register_nav_menus( array(
  	'primary' => __( 'Primary Navigation', 'montreal' ),
  	'footer' => __( 'Footer Navigation', 'montreal' ),
  ) );
}
add_action( 'init', 'register_my_menus' );

register_sidebar(array(
  'name' => __( 'Sidebar', 'montreal' ),
  'id' => 'sidebar',
  'before_widget' => '<div id="%1$s" class="twelve columns midtopmargin %2$s">',
  'after_widget'  => '</div><div class="twelve columns blackhorizontal midmargin"></div>',
  'before_title' => '<h5 class="blacktext extrabold uppercase">',
  'after_title' => '</h5>'
));

register_sidebar(array(
  'name' => __( 'Contact Page Sidebar', 'montreal' ),
  'id' => 'sidebar-contact',
  'before_widget' => '<div id="%1$s" class="twelve columns smallmargin alpha %2$s">',
  'after_widget'  => '</div><div class="twelve columns blackhorizontal midmargin"></div>',
  'before_title' => '<h5 class="blacktext extrabold smallbottompadding uppercase">',
  'after_title' => '</h5>'
));

register_sidebar(array(
  'name' => __( 'Footer Widget Area', 'montreal' ),
  'id' => 'footer-widgets',
  'before_widget' => '<div id="%1$s" class="three columns %2$s">',
  'after_widget'  => '</div>',
  'before_title' => '<h5 class="whitetext light">',
  'after_title' => '</h5>'
));

?>