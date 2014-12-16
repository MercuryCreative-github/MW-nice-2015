<?php $option = get_option('montreal_theme_options'); ?>
<div class="bigpadding" style="background:url(<?php echo $option['background_image']; ?>);"></div>

<!-- CONTENT CONTAINER -->
<div class="container white bigpadding">
	<section class="row midbottommargin">
	<h2 class="blacktext bold midbottommargin center"><?php the_title(); ?></h2>
	<div class="three columns alpha centered blackhorizontal">
	</div>
	</section>
	
		<section class="row">
		<!-- SLIDESHOW -->
		<div class="twelve columns hidden">
			<?php $format = get_post_format(); if( false === $format || $format == 'image' ) { $format = 'standard'; } //FIND POST FORMAT ?>
			<?php get_template_part( '/postformats/format-' . $format . '-portfolio' ); //GET POST FORMAT ?>
		</div>
		</section>
	
	<section class="row">
		<?php the_content(); ?>
	</section>
	
	<section class="row">
	<p class="smallfont midpadding">
		<?php get_template_part('portfolio-navigation'); ?>
	</p>
	</section>
	
</div>
<!-- end of #container -->