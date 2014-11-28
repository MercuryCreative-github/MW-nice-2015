<?php
	/*
	Template Name: Portfolio Drag
	*/
	get_header(); 
	the_post(); 
	$option = get_option('montreal_theme_options'); 
?>

<div class="bigpadding" style="background:url(<?php echo $option['background_image']; ?>);"></div>

<div class="container black nopadding">
	<section class="row bigtoppadding">
	<h3 class="whitetext bold midbottommargin center"><?php the_title(); ?></h3>
	<div class="five columns alpha centered whitehorizontal">
	</div>
	<div class="four columns centered smalltoppadding">
		<div class="center meta">
			<?php the_content(); ?>
		</div>
	</div>
	</section>
	
	<div class="drag">
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
				($counter%3 == 1) ? $alpha = 'alpha' : $alpha = '';
			?>
			
				<div <?php post_class('greyvertical midtopmargin item leftpadding rightpadding'); ?>>
					<?php the_post_thumbnail(); ?>
					<h5 class="whitetext extrabold icon-circle-arrow-right smalltoppadding">&nbsp; 
						<a href="<?php the_permalink(); ?>" class="whitetext"><?php the_title(); ?></a>
						<span class="right light">0<?php echo $counter; ?></span>
					</h5>
					<h6 class="whitetext leftpadding"><?php echo the_simple_terms(); ?></h6>
					<div class="meta leftpadding smalltoppadding">
						<?php the_excerpt(); ?>
					</div>
					<a href="<?php the_permalink(); ?>" class="whitetext smallfont leftpadding"><?php echo $option['view_project']; ?></a>
				</div>
				
			<?php 
				endwhile; 
				endif; 
				wp_reset_query(); 
			?>
			
		</div>
	</div>
</div>

<?php 
	get_footer();