<?php 
	get_header(); 
	//$option = get_option('montreal_theme_options'); 
?>

<!-- <div class="bigpadding" style="background:url(<?php// echo $option['background_image']; ?>);"></div> -->

<div class="container white bigpadding">

	<section class="row">
		    <div class="page-404-box">
	    <div class="404-image"><img src="/wp-content/uploads/2015/01/n404.png" /></div>
	    <div class="404-text">
		    <p><strong>This page have been moved or deleted.</strong><br/> From here you can go back to where you were, head straight to our home page or watch videos from our last conference.</p>
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
	</section>

</div>

<!--// WordPress Hook //-->
<?php get_footer(); ?>