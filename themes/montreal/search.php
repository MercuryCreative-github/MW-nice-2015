<?php 
	get_header(); 
	$option = get_option('montreal_theme_options'); 
	global $wp_query; 
	$total_results = $wp_query->found_posts; 
?>

<div class="bigpadding" style="background:url(<?php echo $option['background_image']; ?>);"></div>

<div class="container white bigpadding">

	<section class="row">
	
		<h3 class="blacktext bold midbottommargin center uppercase"><?php _e( 'Your Search Found ', 'montreal' ); echo $total_results; if( $total_results == '1' ){ _e(' Item','montreal'); } else { _e(' Items','montreal'); } ?></h3>
		
		<div class="five columns alpha centered blackhorizontal"></div>
	
		<?php if( $total_results == '0' ) : ?>
		
			<div class="four columns alpha centered midtopmargin">
				<p class="center meta">
					<?php _e('Whoops! It seems your search returned 0 results, try searching again for a different keyword.', 'montreal'); ?>
				</p>
			</div>
	</section>
		
		<?php else : ?>
		
			<div class="four columns alpha centered midtopmargin">
				<p class="center meta">
					<?php _e('Search Results For ', 'montreal') . the_search_query(); ?>
				</p>
			</div>
	</section>
			<section class="row bigtoppadding centered">
				<ul class="list bullet centered">
		    		<?php while ( have_posts() ) : the_post(); ?>
		    			<li class="blacktext"><h5 class="aligncenter"><a href="<?php the_permalink(); ?>" class="blacktext"><?php the_title(); ?></a></h5></li>
		    		<?php endwhile; ?>
				</ul>
			</section>
		
		<?php endif; ?>
	
</div>
							
<?php 
	get_footer();