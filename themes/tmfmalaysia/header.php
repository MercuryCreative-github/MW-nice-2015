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
		<section class="row">
	
			<div class="four columns">
				<a href="<?php echo home_url(); ?>"><?php if ( $option['custom_logo'] !='' ) { echo '<img class="scale-with-grid-logo" src="' . $option['custom_logo'] . '" alt="Logo" />'; } else { echo bloginfo('name'); } ?></a>
			</div>
	
		<div class="eight columns">
		
			<nav id="navigationmain">
				<?php wp_nav_menu( array( 'menu_id' => 'menu', 'theme_location' => 'primary', 'container' => 'false' ) ); ?>

</nav>


	
		</div>
		
		</section>
	</div>
</header>