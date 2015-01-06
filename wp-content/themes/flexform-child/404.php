<?php get_header(); ?>

<?php
	$options = get_option('sf_flexform_options');
	$default_page_heading_bg_alt = $options['default_page_heading_bg_alt'];
?>

<div class="row">
<div class="page-heading span12 clearfix page404">
  <img src="/wp-content/themes/flexform-child/images/404.png" width="87" height="112" />
  <h2>ERROR</h2></div>
</div>

<?php /*?><?php 
	// BREADCRUMBS
	echo sf_breadcrumbs();
?>
<?php */?>
<div class="inner-page-wrap row has-right-sidebar has-one-sidebar clearfix">

	<article class="help-text span8 page-404">
    <div class="page-404-box">
	    <div class="404-image"><img src="/wp-content/uploads/2015/01/n404.png" /></div>
	    <div class="404-text">
		    <p><strong>This page have been moved or deleted.</strong></p>
		    <p>From here you can go back to where you were, head straight to our home page or watch videos from our last conference.</p>
	    </div>
    </div>
    <div class="page-404-buttons">
    	<div class="404-btn-home">
    		<img src="/wp-content/uploads/2015/01/404-hp-icon.png">
    		<p>Check out <img src="/wp-content/uploads/2015/01/404-logo.png">Nice 2015<br/><small>Learn more about the 2015 conference!</small></p>
    	</div>
    	<div class="404-btn-video">
    		<img src="/wp-content/uploads/2015/01/404-video-icon.png">
    		<p>Wach videos of<br/><img src="/wp-content/uploads/2015/01/404-logo.png">Nice 2014</p>
    	</div>
    </div>
	
	</article>
	
	<aside class="sidebar right-sidebar span4">
		<?php dynamic_sidebar('404sidebar'); ?>
	</aside>
	
</div>

<!--// WordPress Hook //-->
<?php get_footer(); ?>