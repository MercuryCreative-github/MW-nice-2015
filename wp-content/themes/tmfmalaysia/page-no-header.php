<?php 
	/*
	Template Name: Page Without Title
	*/
	get_header();
	the_post(); 
	$option = get_option('montreal_theme_options'); 
?>

<div class="bigpadding" style="background:url(<?php echo $option['background_image']; ?>);"></div>

<div class="container white">

	<section class="row">
		
		<div class="five columns alpha centered blackhorizontal"></div>
		
		<div class="four columns alpha centered midtopmargin">
			<p class="center meta">
				<?php echo get_post_meta( $post->ID, '_cmb_the_subtitle', true ); ?>
			</p>
		</div>
		
	</section>
	
	<section <?php post_class('row bigtoppadding the-content'); ?>>
		<?php the_content(); ?>
	</section>

</div>

<script>
	
jQuery('document').ready(function(){

	var hash = window.location.hash;

    if(hash!==""){
      
      src= jQuery('iframe').attr('src');
      jQuery('iframe').attr('src',src+hash);

    }

})

</script>


<script>
jQuery('.tab-selector a').click(function(e){
	var hash = jQuery('this').attr('href').substring(jQuery('this').attr('href').lastIndexOf('#'));
	src= jQuery('iframe').attr('src').substring(0, src.lastIndexOf('/'));
	jQuery('iframe').attr('src',src+hash);
})
</script>


<?php 
	get_footer();