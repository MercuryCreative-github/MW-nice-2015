<?php $option = get_option('montreal_theme_options'); ?>
<div class="container bigtoppadding midtoppadding" style="background:url(<?php echo $option['background_image']; ?>);">
	<section class="row midbottompadding bigtoppadding">
		<h2 class="black whitetext bold leftpadding rightpadding uppercase"><?php the_title(); ?></h2>
	</section>
</div>
<div class="container white bigpadding">
	<section class="row">
	
	<!-- LEFT SLIDER -->
	<div class="eight columns blackvertical">
		<?php $format = get_post_format(); if( false === $format || $format == 'image' ) { $format = 'standard'; } //FIND POST FORMAT ?>
		<?php get_template_part( '/postformats/format-' . $format . '-portfolio' ); //GET POST FORMAT ?>
	</div>
	
	<!-- RIGHT SIDE -->
	<div class="four columns blogContent">
		<?php the_content(); get_template_part('portfolio-navigation'); ?>
	</div>
	</section>
</div>
<!-- end of #container -->