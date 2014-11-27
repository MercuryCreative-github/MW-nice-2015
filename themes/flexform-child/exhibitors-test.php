<?php
  /* TMF LOAD STYLES & SCRIPTS
  ================================================== */

  function tmf_enqueue_scripts() {

    //TMF API REGISTER
    wp_register_script('APICore', get_stylesheet_directory_uri() . '/js/APICore.js', 'jquery', NULL, FALSE);
    wp_register_script('TMFEventsAPI', get_stylesheet_directory_uri() . '/js/TMFEventsAPI.min.js', 'jquery, APICore', NULL, FALSE);

      // TMF API ENQUEUE
    wp_enqueue_script('APICore');
    wp_enqueue_script('TMFEventsAPI');


  }

  add_action('wp_enqueue_scripts', 'tmf_enqueue_scripts');


?>
<?php
/*
Template Name: Exhibitors list TEST
*/
?>
<?php get_header(); ?>

<?php
	$options = get_option('sf_flexform_options');

	$default_show_page_heading = $options['default_show_page_heading'];
	$default_page_heading_bg_alt = $options['default_page_heading_bg_alt'];
	$default_sidebar_config = $options['default_sidebar_config'];
	$default_left_sidebar = $options['default_left_sidebar'];
	$default_right_sidebar = $options['default_right_sidebar'];

	$show_page_title = get_post_meta($post->ID, 'sf_page_title', true);
	$page_title_one = get_post_meta($post->ID, 'sf_page_title_one', true);
	$page_title_two = get_post_meta($post->ID, 'sf_page_title_two', true);
	$page_title_bg = get_post_meta($post->ID, 'sf_page_title_bg', true);

	if ($show_page_title == "") {
		$show_page_title = $default_show_page_heading;
	}
	if ($page_title_bg == "") {
		$page_title_bg = $default_page_heading_bg_alt;
	}

	$sidebar_config = get_post_meta($post->ID, 'sf_sidebar_config', true);
	$left_sidebar = get_post_meta($post->ID, 'sf_left_sidebar', true);
	$right_sidebar = get_post_meta($post->ID, 'sf_right_sidebar', true);

	if ($sidebar_config == "") {
		$sidebar_config = $default_sidebar_config;
	}
	if ($left_sidebar == "") {
		$left_sidebar = $default_left_sidebar;
	}
	if ($right_sidebar == "") {
		$right_sidebar = $default_right_sidebar;
	}

	$page_wrap_class = '';
	if ($sidebar_config == "left-sidebar") {
	$page_wrap_class = 'has-left-sidebar has-one-sidebar row';
	} else if ($sidebar_config == "right-sidebar") {
	$page_wrap_class = 'has-right-sidebar has-one-sidebar row';
	} else if ($sidebar_config == "both-sidebars") {
	$page_wrap_class = 'has-both-sidebars';
	} else {
	$page_wrap_class = 'has-no-sidebar';
	}

	$remove_breadcrumbs = get_post_meta($post->ID, 'sf_no_breadcrumbs', true);
	$remove_bottom_spacing = get_post_meta($post->ID, 'sf_no_bottom_spacing', true);
	$remove_top_spacing = get_post_meta($post->ID, 'sf_no_top_spacing', true);

	if ($remove_bottom_spacing) {
	$page_wrap_class .= ' no-bottom-spacing';
	}
	if ($remove_top_spacing) {
	$page_wrap_class .= ' no-top-spacing';
	}
?>

<?php if (have_posts()) : the_post(); ?>



<?php
	// BREADCRUMBS
	if(!$remove_breadcrumbs) {
		echo sf_breadcrumbs();
} ?>

<div class="inner-page-wrap <?php echo $page_wrap_class; ?> clearfix">

	<!-- OPEN page -->

	<?php if (($sidebar_config == "left-sidebar") || ($sidebar_config == "right-sidebar")) { ?>
	<div <?php post_class('clearfix span8'); ?> id="<?php the_ID(); ?>">
	<?php } else if ($sidebar_config == "both-sidebars") { ?>
	<div <?php post_class('clearfix row'); ?> id="<?php the_ID(); ?>">
	<?php } else { ?>
	<div <?php post_class('clearfix'); ?> id="<?php the_ID(); ?>">
	<?php } ?>

		<?php if ($sidebar_config == "both-sidebars") { ?>

			<div class="page-content span6">




			</div>

			<aside class="sidebar left-sidebar span3">
				<?php dynamic_sidebar($left_sidebar); ?>
			</aside>

		<?php } else { ?>

		<div class="page-content clearfix">
		<div class="text-box"><p>Find out more on becoming a sponsor or exhibitor! <a href="http://marketing.tmforum.org/acton/fs/blocks/showLandingPage/a/1332/p/p-0060/t/page/fm/0" target="_blank">Click here</a></p></div>
			<div class="exhibitors-list"></div>

      <script id="simpleEventTemplate" type="text/x-jQuery-tmpl">
        {{each Echibitors}}



        {{/each}}
    </script>


    <script id="speakersTemplate" type="text/x-jQuery-tmpl">


		<ul>
        {{each Speakers}}
        <li>Id: ${Id}</li>
        <li>ImageUrl: ${ImageUrl}</li>
        <li>Name: ${Name}</li>
        <li>WebSite: ${WebSite}</li>
        <li>Description: ${Description}</li>
        <li>Booth: ${Booth}</li>
        <li>-----------------------------</li>
		</li>
        {{/each}}
        </ul>

        <style>.exhibitors-list ul li {width: 100%;float: none!important;height: 28px;}</style>
   </script>



    <div id="dummy" style="display: none;">
    </div>





    <script type="text/javascript">


	    function loadDataToHandle() {
            var data = TmfAPICore.GetObject("test").Data;
            var container = { Speakers: new Array };
            for (var i = 0; i < data.Events.length; i++) {
                for (var j = 0; j < data.Events[i].Exhibitors.length; j++) {
					container.Speakers.push(data.Events[i].Exhibitors[j]);
                }
            }

            jQuery("#speakersTemplate").tmpl(container).appendTo(".exhibitors-list");

        }



        function LoadShow(showId) {
          jQuery('#dummy').LoadTmfEvents({
          ClientId: "test", Engine: "tmpl", Template: "simpleEventTemplate", PlaceholderText: "loading...",
		  Caching: { ServerSide: { CacheDuration: 10 }, ClientSide: { Mode: "SessionStorage" } }, Events: showId,
          OnError: function (err) {},
          OnComplete: function (obj) {

			    // Load data in HTML
                loadDataToHandle();

				/*========= align sponsor logos vertically according to height and ajust size to fit design ========== */
				exhibitorsList()

				/* Exhibitors List */
				function exhibitorsList(){

					var activeSpeakerClass  = 'list-selected';
					var className  = 'active-panel';

					jQuery('.exhibitors-list a').click(function(e){

						e.preventDefault();

						if(jQuery(this).hasClass(className)){return false;}
						else{
							jQuery('.'+className).removeClass(className);
							var href = jQuery(this).attr('href');
							href=(href.substring(href.indexOf('#')))
							var speakerPanel = jQuery(href);
							jQuery('.keynotes-panel').fadeOut(0)
							jQuery(speakerPanel).addClass(className);
							jQuery(speakerPanel).stop(true, true).fadeIn(500)


							jQuery('.active-panel').parent().css({"background": "url(/wp-content/themes/flexform-child/images/transp.png)","position": "fixed"});


						}


						jQuery('.icon_close').click(function(){
							jQuery('.keynotes-panel').fadeOut(0,function(){jQuery('.exh-panels').css({"background": "none","position": "relative"});});
						});

					})



				}
				/* Exhibitors List END */


				  logo = 0
				  divs='';
				  total = jQuery('.exhibitors-list ul li img').length;

					jQuery(".exhibitors-list ul li img").each(function(){

					   li=jQuery(this).parent().parent()
					   id= jQuery(this).parent().attr('href').substr(1);
					   text= jQuery('.keynotes-panel#'+id+' .Ehxdes').text()
					   web= jQuery('.keynotes-panel#'+id+' .Ehxweb').html()

					   img= '<img src="'+jQuery('.keynotes-panel#'+id+' img').attr('src')+'" width="100%">';
					   div = '<div id="'+id+'" class="keynotes-panel"><a class="icon_close" title="Close Panel" href="javascript:void(0)"><span></span></a><div class="left width03">'+img+'</div><div class="right width06">'+text+'</div><div style="text-align: center;">'+web+'</div></div>';

					   jQuery('.keynotes-panel#'+id+'').remove()
					   divs+=div; logo++;

					   hbox = 200;
					   himg = 60;
					   mimg = (hbox-himg)/2
					   jQuery(this).css("margin-top", mimg)
					   jQuery(this).parent().parent().css('opacity','0');
					   jQuery(this).parent().parent().delay(500).animate({'opacity':1},1000)
					   jQuery(this).parent().css('opacity','0')
					   jQuery(this).load(function(){
						   himg = jQuery(this).height();imgRate = jQuery(this).width()/himg;
						   if(himg>150){jQuery(this).height(150);jQuery(this).width(150*imgRate); himg=150}
						   if(imgRate<2.0){jQuery(this).height(120/imgRate);
						   jQuery(this).width(120); himg=120/imgRate}
						   if(imgRate<1.5){jQuery(this).height(100/imgRate);
						   jQuery(this).width(100); himg=100/imgRate}
						   mimg = (hbox-himg)/2
						   jQuery(this).css("margin-top", mimg)
						   jQuery(this).parent().delay(500).animate({'opacity':1},500)
				 	  })

					   if(logo%4==0 && logo<total){
						   li.css("margin-right", 0);
						   li.after('<div id=divs-'+id+' class="exh-panels"></div>');
						   jQuery('#divs-'+id).append(divs);divs='';
						   }
					   if(logo==total){
						   li.css("margin-right", 0);
						   li.after('<div id=divs-'+id+' class="exh-panels"></div>');
						   jQuery('#divs-'+id).append(divs);divs='';

						   }


				 })
               }
            });
        }




    </script>


    <script id="basicContent" type="text/x-jQuery-tmpl">
         {{each Contents}}
		   <h4>{{html Title}}</h4>
		   <p>{{html Body}}</p>
         {{/each}}
  	</script>

    <script type="text/javascript">

	jQuery(document).ready(function(){LoadShow(744);})

    </script>
		</div>

		<?php } ?>

	<!-- CLOSE page -->
	</div>

	<?php if ($sidebar_config == "left-sidebar") { ?>

		<aside class="sidebar left-sidebar span4">
			<?php dynamic_sidebar($left_sidebar); ?>
		</aside>

	<?php } else if ($sidebar_config == "right-sidebar") { ?>

		<aside class="sidebar right-sidebar span4">
			<?php dynamic_sidebar($right_sidebar); ?>
		</aside>

	<?php } else if ($sidebar_config == "both-sidebars") { ?>

		<aside class="sidebar right-sidebar span3">
			<?php dynamic_sidebar($right_sidebar); ?>
		</aside>

	<?php } ?>

</div>

<?php endif; ?>



<!--// WordPress Hook //-->
<?php get_footer(); ?>
