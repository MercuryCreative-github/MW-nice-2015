<?php 
	get_header(); 
	$option = get_option('montreal_theme_options'); 
?>

<div class="container bigtoppadding bigbottompadding" style="background:url(<?php echo $option['background_image']; ?>);">

	<section class="row white bigpadding smallbottommargin">
		<h2 class="center italic blacktext"><?php echo $option['blog_title']; ?></h2>
	</section>

		<?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>
		
			<article <?php post_class('row blogArticle white'); ?>>
			
				<div class="six columns">
	
					<h4 class="blacktext light uppercase"><?php the_title(); ?></h4>
	
					<p>
						<i class="icon-time greytext"></i>
						<a class="smallfont greytext" href="#"><?php the_time(get_option('date_format')); ?></a>
						&nbsp; &nbsp; <i class="greytext icon-folder-open"></i>
						<?php the_tags('',' / ',''); ?>
					</p>
	
					<p class="meta">
						 <?php the_excerpt(); ?>
						 <i class="greytext icon-link"></i> <a class="smallfont greytext" href="<?php the_permalink(); ?>"><?php echo $option['read_post']; ?></a>
					</p>
					
				</div>
	
				<div class="five columns push_one">
					<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
				</div>
			
			</article>
			
		<?php endwhile; endif; ?>

	<section class="row">
		<?php (function_exists('kriesi_pagination')) ? kriesi_pagination() : posts_nav_link(); ?>
	</section>
	
</div>

<?php 
	get_footer();