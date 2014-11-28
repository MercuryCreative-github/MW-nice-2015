<?php
	/*
	Template Name: Portfolio Grid White
	*/
	get_header(); 
	the_post(); 
	$option = get_option('montreal_theme_options'); 
?>

<div class="container bigpadding" style="background:url(<?php echo $option['background_image']; ?>);"></div>

<div class="container white bigpadding">
	<section class="row">
	<h3 class="blacktext bold midbottommargin center"><?php the_title(); ?></h3>
	<div class="five columns alpha centered blackhorizontal">
	</div>
	<div class="four columns alpha centered midtopmargin">
		<div class="center meta">
			<?php the_content(); ?>
		</div>
	</div>
	</section>
	
	<section class="row bigtoppadding">
	
		<?php 
			$the_taxonomy = get_post_meta($post->ID, '_cmb_the_taxonomy_category',true );
			
			if( $the_taxonomy !='-1' ) {
				$portfolio_query = new WP_Query(array( 
				    'post_type' => 'portfolio',
				    'showposts' => -1,
				    'tax_query' => array(
				        array(
				            'taxonomy' => 'portfolio-category',
				            'terms' => $the_taxonomy,
				            'field' => 'term_id',
				        )
				    ),
				    'orderby' => 'date',
				    'order' => 'DESC' )
				); 
			} else { 
				$portfolio_query = new WP_Query('post_type=portfolio&posts_per_page=-1'); 
			}
			
			if( $portfolio_query->have_posts() ) : $counter = '0'; while( $portfolio_query->have_posts() ) : $portfolio_query->the_post(); 
			$counter++; 
			($counter%2 == 1) ? $alpha = 'alpha' : $alpha = '';
		?>
		
			<div <?php post_class('six columns griditem ' . $alpha); ?>>
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
		   
		<?php 
			endwhile; 
			endif; 
			wp_reset_query(); 
		?>
	
	</section>
</div>

<?php 
	get_footer();