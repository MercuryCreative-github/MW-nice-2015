<!-- TITLE CONTAINER WITH BACKGROUND IMAGE. CHANGE BELOW URL TO YOUR OWN IMAGE -->
<div class="container bigpadding" style="background:url(<?php global $post; echo get_post_meta( $post->ID, '_cmb_full_header', true ); ?>);background-position:center;">
	<section class="row largetoppadding bigbottompadding">
	<h2 class="whitetext bold midbottommargin center"><?php the_title(); ?></h2>
	<div class="five columns alpha centered whitehorizontal">
	</div>
	</section>
</div>

<!-- CONTENT CONTAINER -->
<div class="container white">
	<section class="row">
	
	<!-- LEFT SIDE -->
	<div class="eight columns itempost">
		<?php $format = get_post_format(); if( false === $format || $format == 'image' ) { $format = 'standard'; } //FIND POST FORMAT ?>
		<?php get_template_part( '/postformats/format-' . $format . '-portfolio' ); //GET POST FORMAT ?>
	</div>
	
	<!-- RIGHT SIDE -->
	<div class="four columns sidebar grey blogContent">
		<?php the_content(); get_template_part('portfolio-navigation'); ?>
	</div>
	
	</section>
</div>
<!-- end of #container -->