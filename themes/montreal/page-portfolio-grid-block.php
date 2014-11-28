<?php
	/*
	Template Name: Portfolio Grid Block
	*/
	get_header(); 
	the_post(); 
	$option = get_option('montreal_theme_options'); 
?>

<div class="container nopadding bigtoppadding gridder clearfix">
	
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
	
		<div <?php post_class('gridblock'); ?>>
			<?php the_post_thumbnail(); ?>
			<a href="<?php the_permalink(); ?>">
				<div class="gridinfo">
					<h3 class="whitetext extrabold smalltoppadding center"><?php the_title(); ?></h3>
					<h5 class="whitetext center"><?php echo the_simple_terms(); ?></h5>
					<span class="smallfont space whitetext"><?php echo $option['view_project']; ?></span>
				</div>
			</a>
		</div>
		
	<?php 
		endwhile; 
		endif; 
		wp_reset_query(); 
	?>
	
	<div class="clear"></div>
	
</div>

<div class="clear"></div>

<?php 
	get_footer();