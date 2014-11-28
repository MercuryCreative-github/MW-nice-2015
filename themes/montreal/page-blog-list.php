<?php
	/*
	Template Name: Blog-List
	*/
	get_header(); 
	the_post(); 
	$option = get_option('montreal_theme_options'); 
?>

<div class="container bigtoppadding bigbottompadding" style="background:url(<?php echo $option['background_image']; ?>);">

	<section class="row white bigpadding smallbottommargin">
		<h2 class="center italic blacktext"><?php echo $option['blog_title']; ?></h2>
	</section>
	
		<?php $args = new WP_Query("post_type=post&paged=$paged"); ?>	
		<?php if( $args->have_posts() ) : while( $args->have_posts() ) : $args->the_post(); ?>
		
			<article <?php post_class('row blogArticle white'); ?>>
			
				<div class="eight columns centered">

					<a href="<?php the_permalink(); ?>" title="Read Note">
						<h4 class="blacktext italic center"><?php the_title(); ?></h4>
					</a>

					<p class="center">
						<i class="icon-time greytext"></i>
						<a class="smallfont greytext" href="#"><?php the_time(get_option('date_format')); ?></a>
						&nbsp; &nbsp; <i class="greytext icon-folder-open"></i>
						<?php the_tags('',' / ',''); ?>
						&nbsp; &nbsp; <i class="greytext icon-link"></i>
						<a class="smallfont greytext" href="<?php the_permalink(); ?>"><?php echo $option['read_post']; ?></a>
					</p>
					
				</div>
				
			</article>
			
		<?php endwhile; endif; ?>

	<!-- PAGINATION -->
	<section class="row">
		<?php 
			(function_exists('kriesi_pagination')) ? kriesi_pagination($args->max_num_pages) : posts_nav_link(); 
			wp_reset_query(); 
		?>
	</section>
	
</div>

<?php 
	get_footer();