<?php 
	get_header(); 
	the_post(); 
	wpb_set_post_views(get_the_ID()); 
	$option = get_option('montreal_theme_options'); 
?>

<div class="container" style="background:url(<?php echo $option['background_image']; ?>);">

	<section class="row white">
	
		<article class="seven columns blogpost">
		
			<?php the_title('<h2 class="blacktext bold uppercase">', '</h2>'); ?>
			
			<p>
				<i class="icon-time greytext"></i>
				<a class="smallfont greytext" href="#"><?php the_time(get_option('date_format')); ?></a>
				&nbsp; &nbsp; <i class="greytext icon-folder-open"></i>
				<?php the_tags('',' / ',''); ?>
			</p>
			
			<?php 
				$format = get_post_format(); 
				if( false === $format || $format == 'image' ) $format = 'standard';
				get_template_part( '/postformats/' . $format . '-format' );
				the_content(); 
				wp_link_pages(); 
				get_template_part('portfolio-navigation');
				if( comments_open() ) comments_template();
			?>
				
		</article>

	<?php 
		get_sidebar(); 
	?>
	
	</section>
	
</div>

<?php 
	get_footer();