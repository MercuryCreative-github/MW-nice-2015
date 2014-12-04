<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?>> <!--<![endif]-->
<head>
	<?php $option = get_option('montreal_theme_options'); ?>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<title><?php if (is_home() || is_front_page()) { echo bloginfo('name'); } else { echo wp_title(''); } ?></title>	
	<meta name="description" content="<?php bloginfo('description'); ?>"/>
	<?php if ( $option['custom_favicon'] ) : ?>
		<link rel="shortcut icon" href="<?php echo $option['custom_favicon']; ?>">
	<?php endif; ?>
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?> id="<?php the_field('page_id'); ?>">

<header>
	<div class="container">
        <div class="head">
    		<section class="row">
    	
    			<div class="six columns infocus-logo">
    				
                    <a class="logo" href="<?php echo home_url(); ?>"><?php if ( $option['custom_logo'] !='' ) { echo '<img class="scale-with-grid-logo" src="' . $option['custom_logo'] . '" alt="Logo" />'; } else { echo bloginfo('name'); } ?></a>
    			                        
                    <div class="slogan">
                        <span class="title">Nice, France</span><br/>
                        <span class="date">June 1-4, 2015</span>
                    </div> 
                    
                </div>
            
		<div class="six columns action-btns">

			<nav class="call-to-action">

                <?php wp_nav_menu( array('menu' => 'Call to Action', 'container' => 'false', 'items_wrap' => '%3$s' )); ?>           
                
                <div class="slogan-tablet">
                    <span class="title-tablet">Nice, France</span><br/>
                    <span class="date-tablet">June 1-4, 2015</span>
                </div>                
                
			</nav>
	
		</div>            
	
		<div class="twelve columns nav-border">
		
			<nav id="navigationmain">
				<?php wp_nav_menu( array( 'menu_id' => 'menu', 'theme_location' => 'primary', 'container' => 'false' ) ); ?>
			</nav>
            
            <div class="mobile-navigation">
            
                <a class="logo-mobile" href="<?php echo home_url(); ?>"><img class="scale-with-grid-logo" src="/wp-content/uploads/2014/12/LogoDD14.png" alt="Logo" /></a>
                
                <div class="slogan-mobile">
                    <span class="title">Nice, France</span><br/>
                    <span class="date">June 1-4, 2015</span>             
                </div>
                
                <span class="divider"></span>
                
                <a target="_blank" class="register-btn-mobile">REGISTER</a>
                
                <button type="button" class="navbar-toggle">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                </button>
                
                <div class="navbar-collapse">
				    <?php wp_nav_menu( array( 'menu_id' => 'menu', 'theme_location' => 'primary', 'container' => 'false' ) ); ?>                
                </div>
                
            </div>
	
		</div>
		
		</section>
        </div>
	</div>
</header>