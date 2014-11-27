<?php
	/*
	Template Name: Contact
	*/
	get_header(); 
	the_post(); 
	$option = get_option('montreal_theme_options'); 
?>

<div id="map" <?php if( get_post_meta( $post->ID, '_cmb_the_map_switch', true ) == 'on' ) : ?>style="background:url(<?php $url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full'); echo $url[0]; ?>);background-position:center fixed;"<?php endif; ?>>
</div>


<div class="container" style="background:url(<?php echo $option['background_image']; ?>);">

	<section class="row white">
	
	<!-- FORM COLUMN -->
	<div class="seven columns leftpadding bigpadding" data-role="form">
		<h3 class="extrabold blacktext midbottommargin uppercase"><?php the_title(); ?></h3>
		<div class="meta"><?php the_content(); ?></div>
		<form method="post" action="#" id="contactform">
			<div class="row">
				<dl class="field eight columns">
					<dd><label for="name"><?php _e('Your name*', 'montreal'); ?></label></dd>
					<dt class="text"><input type="text" name="name" id="name"/>
					</dt>
					<dd class="msg"><?php _e('You filled this out wrong.', 'montreal'); ?></dd>
				</dl>
			</div>
			<div class="row">
				<dl class="field eight columns">
					<dd><label for="email"><?php _e('Your E-mail*', 'montreal'); ?></label></dd>
					<dt class="text"><input type="text" name="email" id="email"/>
					</dt>
					<dd class="msg"><?php _e('You filled this out wrong.', 'montreal'); ?></dd>
				</dl>
			</div>
			<div class="row">
				<dl class="field eight columns">
					<dd><label for="email"><?php _e('Subject', 'montreal'); ?></label></dd>
					<dt class="text"><input type="text" name="subject" id="subject"/>
					</dt>
					<dd class="msg"><?php _e('You filled this out wrong.', 'montreal'); ?></dd>
				</dl>
			</div>
			<dl class="field row">
				<dd><label for="message"><?php _e('Your message*', 'montreal'); ?></label></dd>
				<dt class="textarea">
				<textarea name="message" id="message"></textarea></dt>
				<dd class="error msg"><?php _e('You filled this out wrong.', 'montreal'); ?></dd>
			</dl>
			<div class="row">
				<input class="submit three columns" type="button" value="<?php _e('Submit','montreal'); ?>" id="contact-submit"/>
			</div>
		</form>
		<!-- END FORM -->
		<div class="row midpadding" id="success">
		</div>
	</div>
		<?php if( is_active_sidebar('sidebar-contact') ) get_sidebar('contact'); ?>
	</section>
	
</div>


	<script>
	<?php if( get_post_meta( $post->ID, '_cmb_the_map_switch', true ) !='on' ) : ?>
	jQuery(document).ready(function(){
	    jQuery('#map').goMap({ address: '<?php echo get_post_meta( $post->ID, '_cmb_the_gMaps', true ); ?>',
	    	zoom: 14,
	    	navigationControl: true, 
	    	maptype: 'ROADMAP',
	    	draggable: false, zoomControl: false, scrollwheel: false, disableDragging: true,
	    	markers: [
	    		{ 'address' : '<?php echo get_post_meta( $post->ID, '_cmb_the_gMaps', true ); ?>' }
	    	] });
	});
	<?php endif; ?> 
	jQuery(document).ready(function(){
		jQuery('#contact-submit').click(function(){
			jQuery.post("<?php echo get_template_directory_uri(); ?>/email_scripts/sendemail.php", jQuery("#contactform").serialize(),  function(response) {
				jQuery('#success').html(response);
				if(response == '<h6>Thank you for you enquiry. We will be in touch shortly.</h6>'){
					jQuery("#contactform")[0].reset();
				}
				});
			return false;
		});
	});
	</script>

<?php 
	get_footer();