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
    <h2 class="page-404">Page not found</h2>
		<?php _e("Sorry but we couldn't find the page you are looking for. Please check to make sure you've typed the URL correctly. You may also want to search for what you are looking for.", "swiftframework"); ?> 
		<form method="get" class="search-form" action="http://tmflive.staging.wpengine.com/">
			<input class="adminbar-input page-404" name="s" type="text">
		</form>
		<a class="sf-button small accent page-404" href="javascript:history.go(-1)" target="_self"><span><?php _e("Return to the previous page", "swiftframework"); ?></span><span class="arrow"></span></a>
	</article>
	
	<aside class="sidebar right-sidebar span4">
		<?php dynamic_sidebar('404sidebar'); ?>
	</aside>
	
</div>

<!--// WordPress Hook //-->
<?php get_footer(); ?>