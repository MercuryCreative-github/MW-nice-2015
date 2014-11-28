<?php
	/*
	Template Name: Portfolio Stripe
	*/
	get_header(); 
	the_post(); 
	$option = get_option('montreal_theme_options'); 
?>

<div class="container dragbig">
	<div id="scroll">
	
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
		
			<div <?php post_class('itemstripe'); ?>>
				<img src="<?php echo get_post_meta( $post->ID, '_cmb_stripe_gallery', true ); ?>" alt="item">
				<a href="<?php the_permalink(); ?>">
				<div class="infowhite midpadding leftpadding rightpadding">
					<h5 class="blacktext extrabold smalltoppadding midtoppadding uppercase"><?php the_title(); ?><span class="right light">0<?php echo $counter; ?></span></h5>
					<h6 class="blacktext uppercase"><?php echo the_simple_terms(); ?></h6>
					<span class="blacktext smallfont"><?php echo $option['view_project']; ?></span>
				</div>
				</a>
			</div>
			
		<?php 
			endwhile; 
			endif; 
			wp_reset_query(); 
		?>
		
	</div>
</div>

<?php 
	get_footer('stripe');