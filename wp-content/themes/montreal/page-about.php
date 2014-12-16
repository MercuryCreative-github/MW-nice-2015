<?php
	/*
	Template Name: About
	*/
	get_header(); 
	the_post();
	$option = get_option('montreal_theme_options'); 
?>

<div class="container" style="background:url(<?php $url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full'); echo $url[0]; ?>);background-position:center fixed;">
	<section class="row largetoppadding bigbottompadding">
	<div class="six columns midtoppadding">
		<h1 class="italic whitetext"><?php the_title(); ?></h1>
		<h6 class="whitetext"><?php echo get_post_meta( $post->ID, '_cmb_the_subtitle', true ); ?></h6>
	</div>
	</section>
</div>

<div class="container white">
	<section class="row bigpadding blogContent">
	
		<?php the_content(); ?>
	
	</section>
</div>

<?php if(get_post_meta( $post->ID, '_cmb_the_team_switch', true ) == 'on') : ?>
	<div class="container black bigpadding">
		<section class="row">
		<h3 class="whitetext bold midbottommargin center"><?php echo get_post_meta( $post->ID, '_cmb_the_team_title', true ); ?></h3>
		<div class="three columns alpha centered whitehorizontal">
		</div>
		</section>
		<section class="row midtopmargin">
		
			<?php 
				$team_query = new WP_Query('post_type=team&posts_per_page=-1'); 
				if( $team_query->have_posts() ) : while( $team_query->have_posts() ) : $team_query->the_post(); 
				global $post; 
			?>
				<div class="three columns team">
					<div class="person smallbottommargin">
						<?php the_post_thumbnail(); ?>
						<div class="personinfo">
							<p class="center bigtoppadding">
								<?php if( get_post_meta( $post->ID, '_cmb_the_team_social1_link', true ) !=''  ) : ?><a href="<?php echo get_post_meta( $post->ID, '_cmb_the_team_social1_link', true ); ?>" class="smallfont whitetext"><?php echo get_post_meta( $post->ID, '_cmb_the_team_social1_name', true ); ?></a> &nbsp; <?php endif; ?>
								<?php if( get_post_meta( $post->ID, '_cmb_the_team_social2_link', true ) !=''  ) : ?><a href="<?php echo get_post_meta( $post->ID, '_cmb_the_team_social2_link', true ); ?>" class="smallfont whitetext"><?php echo get_post_meta( $post->ID, '_cmb_the_team_social2_name', true ); ?></a> &nbsp; <?php endif; ?>
								<?php if( get_post_meta( $post->ID, '_cmb_the_team_social3_link', true ) !=''  ) : ?><a href="<?php echo get_post_meta( $post->ID, '_cmb_the_team_social3_link', true ); ?>" class="smallfont whitetext"><?php echo get_post_meta( $post->ID, '_cmb_the_team_social3_name', true ); ?></a> <?php endif; ?>
							</p>
						</div>
					</div>
					<!-- PERSON INFO -->
					<h5 class="whitetext"><?php the_title(); ?></h5>
					<h6 class="whitetext"><?php echo get_post_meta( $post->ID, '_cmb_the_job_title', true ); ?></h6>
				</div>
			<?php 
				endwhile; 
				endif; 
				wp_reset_query(); 
			?>
		
		</section>
	</div>
<?php endif; ?>

<!-- CLIENT CONTAINER -->
<div class="container" style="background:url(<?php echo $option['background_image']; ?>);">

<?php if(get_post_meta( $post->ID, '_cmb_the_client_switch', true ) == 'on') : ?>
	<section class="row white bigpadding leftpadding rightpadding">
	
	<section class="row">
		<h4 class="blacktext midbottommargin center"><?php echo get_post_meta( $post->ID, '_cmb_the_clients_title', true ); ?></h4>
			<div class="three columns alpha centered blackhorizontal"></div>
	</section>
	
	<section class="row midtopmargin bigbottommargin clients_section">
	<?php 
		$clients_query = new WP_Query('post_type=clients&posts_per_page=-1'); 
		if( $clients_query->have_posts() ) : while( $clients_query->have_posts() ) : $clients_query->the_post(); 
		global $post; 
	?>
		<div class="two columns">
			<?php if( get_post_meta( $post->ID, '_cmb_the_client_link', true ) ) : ?>
				<a href="<?php echo get_post_meta( $post->ID, '_cmb_the_client_link', true ); ?>">
			<?php endif; ?>
				<?php the_post_thumbnail('client'); ?>
			<?php if( get_post_meta( $post->ID, '_cmb_the_client_link', true ) ) : ?>
				</a>
			<?php endif; ?>
		</div>
	<?php 
		endwhile; 
		endif; 
		wp_reset_query(); 
	?>
	</section>
<?php endif; ?>
	
<?php if(get_post_meta( $post->ID, '_cmb_the_testimonial_switch', true ) == 'on') : ?>
	<section class="row">
		<h4 class="italic center"><?php echo get_post_meta( $post->ID, '_cmb_the_testimonial_title', true ); ?></h4>
	</section>
	<section class="row midtoppadding smallbottompadding">
		<h2 class="light blacktext center icon-certificate"></h2>
	</section>
	
	<section class="row">
	<div class="seven columns centered">
		<div class="flexslider">
			<ul class="slides">
				<?php 
					$testimonial_query = new WP_Query('post_type=testimonial&posts_per_page=-1'); 
					if( $testimonial_query->have_posts() ) : while( $testimonial_query->have_posts() ) : $testimonial_query->the_post(); 
					global $post; 
				?>
					<li>
						<div>
							<h5 class="light blacktext center"><?php $content = get_the_content(); echo strip_tags($content); ?></h5>
							<h6 class="center bold meta midtopmargin blacktext"><?php the_title(); ?></h6>
						</div>
					</li>
				<?php 
					endwhile; 
					endif; 
					wp_reset_query(); 
				?>
			</ul>
		</div>
	</div>
	</section>
<?php endif; ?>
	
	</section>
</div>
<?php 
	get_footer();