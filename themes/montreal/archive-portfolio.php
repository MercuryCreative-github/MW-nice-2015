<?php 
	get_header(); 
	global $post; 
	$option = get_option('montreal_theme_options'); 
?>

<div class="container bigpadding" style="background:url(<?php echo $option['background_image']; ?>);"></div>

<div class="container white bigpadding">
	<section class="row">
		<h3 class="blacktext bold midbottommargin center"><?php echo $option['portfolio_title']; ?></h3>
		<div class="five columns alpha centered blackhorizontal"></div>
	</section>
	
	<section class="row bigtoppadding">
	
	<?php if( have_posts() ) : $counter = '0'; while( have_posts() ) : the_post(); $counter++; ?>
	
		<div class="six columns griditem <?php if( $counter % 2 !== 0 ){ echo 'alpha'; } ?>">
			<?php the_post_thumbnail(); ?>
			<a href="<?php the_permalink(); ?>">
				<div class="gridinfo">
					<h3 class="whitetext extrabold bigtoppadding center uppercase"><?php the_title(); ?></h3>
					<h5 class="whitetext center"><?php echo the_simple_terms(); ?></h5>
					<span class="smallfont space"><?php echo $option['view_project']; ?></span>
				</div>
				<div class="gridblack">
					<h2 class="whitetext uppercase"><?php echo the_grid_simple_terms(); ?></h2>
				</div>
			</a>
	   </div>
	   
	<?php endwhile; endif; ?>
	
	</section>
</div>

<?php 
	get_footer();