<?php
	/*
	Template Name: Portfolio Basic
	*/
	get_header(); 
	the_post(); 
	$option = get_option('montreal_theme_options'); 
?>

<div class="container bigtoppadding midtoppadding" style="background:url(<?php echo $option['background_image']; ?>);">
	<section class="row midbottompadding bigtoppadding">
	<h2 class="black whitetext bold leftpadding rightpadding"><?php the_title(); ?></h2>
	</section>
</div>

<div class="container white bigpadding">

	<div class="row smallbottompadding greytext smallfont">
		<?php the_content(); ?>
	</div>
	
	<section class="row">
	
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
		
			<div <?php post_class('item four columns ' . $alpha); ?>>
				<div class="item-img">
					<?php the_post_thumbnail(); ?>
						<div class="item-hover">
							<h4 class="circle"><a href="<?php $url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full'); echo $url[0]; ?>" class="whitetext" rel="prettyPhoto[gal]" title="<?php the_title(); ?>"><i class="icon-zoom-in"></i></a></h4>
						</div>
				</div>
				<h5 class="blacktext extrabold smalltoppadding uppercase"><?php the_title(); ?><span class="right light">0<?php echo $counter; ?></span></h5>
				<h6 class="blacktext"><?php echo the_simple_terms(); ?></h6>
				<a href="<?php the_permalink(); ?>" class="blacktext smallfont" title="<?php the_title(); ?>"><?php echo $option['view_project']; ?></a>
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
