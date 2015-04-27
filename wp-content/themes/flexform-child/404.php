<?php 
	get_header(); 
	$option = get_option('montreal_theme_options'); 
?>

<div class="bigpadding" style="background:url(<?php echo $option['background_image']; ?>);"></div>

<div class="container white bigpadding">

	<section class="row">
		    <div class="page-404-box">
	    <div class="page-404-image"><img src="/wp-content/uploads/2015/04/n404.png" /></div>
	    <div class="page-404-text">
		    <p><strong>This page have been moved or deleted.</strong><br/>From here you can go back to the previous page, head straight to our home page to learn about TM Forum Live 2015 or watch videos from our last conference.</p>
	    </div>
    </div>
    <div class="page-404-buttons">
    	<a href="/">
    	<div class="page-404-btn-home">
    		<img class="page-404-icon" src="/wp-content/uploads/2015/04/404-hp-icon.png">
    		<p>Check out <img src="/wp-content/uploads/2015/01/404-logo.png">Nice 2015<br/><small>Learn more about the 2015 conference!</small></p>
    	</div><a>
    	<a href="http://vimeo.com/tmforumorg/channels" target="_blank">
    	<div class="page-404-btn-video">
    		<img class="page-404-icon" src="/wp-content/uploads/2015/04/404-video-icon.png">
    		<p>Wach videos of<br/><img src="/wp-content/uploads/2015/04/404-logo.png">Nice 2014</p>
    	</div><a>
        <div class="clear"></div>
    </div>
	</section>


</div>

<!--// WordPress Hook //-->
<?php get_footer(); ?>