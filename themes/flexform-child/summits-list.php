﻿<?php
/*
Template Name: Summits List
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

<?php if ($show_page_title) { ?>


    
    <div class="row">
        <div class="page-heading span12 clearfix alt-bg <?php echo $page_title_bg; ?>">
            <?php if ($page_title_one) { ?>
            <h1><?php echo $page_title_one; ?></h1>
            <?php } else { ?>
            <h1><?php the_title(); ?></h1>
            <?php } ?>
            <?php if ($page_title_one) { ?>
            <h3><?php echo $page_title_two; ?></h3>
            <?php } ?>
        </div>
    </div>
<?php } ?>

<?php 
    // BREADCRUMBS
    if(!$remove_breadcrumbs) {  
        echo sf_breadcrumbs();
} ?>

<div class="inner-page-wrap <?php echo $page_wrap_class; ?> clearfix">

    <!-- OPEN page -->

<div class="wpb_content_element wpb_raw_html">         
<div class="wpb_wrapper">
<nav id="mediacenter-navigation">

    <?php
        if(function_exists('wp_nav_menu')) {
        wp_nav_menu(array('theme_location' => 'main_agenda','fallback_cb' => '')); }
    ?>

    <!--// CLOSE MAIN NAV //-->
    </nav>

</div>       
</div>

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
         <?php the_content(); ?>
        
       

  
    

</div>

<!-- load data div  -->
<div id="Data_Loader" style="display: none;"></div>
<div id="CMS_Data_Loader" style="display: none;"></div>
        </div>
        
        
        
        <?php } ?>  
        
        </script> 


    <script type="text/javascript">
    
    function loadUrl(newLocation)
    {
    window.location = newLocation;
    return false;
    }
    
    
    </script>


<script id="simpleEventTemplate" type="text/x-jQuery-tmpl"></script>
<script id="SummitTemplate" type="text/x-jQuery-tmpl">
{{each Tracks}}
    <div class="">
        <div class="track_description">
            ${( $data.trackName= this.Name ),''}
            <h2>${Name}</h2>
        </div>
        <div class="">
          <!--  <a href="#" class="nav_btn float_right alt_color">Stay Updated &raquo;</a> -->
        </div>
        <div class="clear"></div>
        <div class="solid_line"></div>
        <a href="javascript:void(0)" class="show_text" onclick="MoreText(this)">More text &raquo;</a>
        <div class="track_days_nav_wrap">
            <div class="span12" id="track_days_nav">
                ${( $data.TrackId = Id ),''}
                {{each Days}}
                    <a href="?TrackId=${TrackId}&ShowDay=${$value}&goTo" class="nav_btn float_left" data-week-day="${$value}">${GetDayName(Days[$index])} </a>
                {{/each}}
            		<!-- <a href="#" class="nav_btn float_right print_btn">Print Agenda</a> -->
        	</div>
            <div class="row">
        		<div class="track_title_wrapper span12">
        			<!--<span class="track_current_day">${GetSelectedDayinTemplate()} </span>-->
        			<span class="track_title">${Name}</span>
        			<!-- <a href="?ViewMode=search" class="nav_btn float_right " id="find_session">Find a Session</a> -->
        		</div>
            </div>
        </div>
        <div id="track_summit">
        {{each Modules}}        
            {{each ModuleSessions}}
                <div class="highlighted-s module_session">
                    <div class="module_name">
                        ${Name}
                    </div>
                    {{if Chair}}
                        <div class="chairman">
                                    <span class="title">
                                    Chairman :
                                    </span>
                                    <span class="speaker_name">
                                    ${Chair.FullName}
                                    </span>
                                    | 
                                    <span class="speaker_job">
                                    ${Chair.JobTitle}
                                    </span>
                                    -
                                    <span class="speaker_company">
                                    ${Chair.CompanyName}
                                    </span>
                        </div>
                    {{/if}}
                </div>
                <!-- start summit   -->

                {{each Submissions}}
                    ${( $data.printLine= false),''}
                    {{if (($index + 1) < Submissions.length)}}
                        ${( $data.printLine= true),''}
                    {{/if}}
            		<div class="row_color_${($index % 2)+1} row">
                        <div class="span4">
                            <div class="session_time ">
                                ${getStartDate(Start)}
                    		</div>
                            {{if Speakers.length}}
                                    ${( $data.printTitle= true),''}
                                    <div class="summit_chairman">
                                        {{each Speakers}}
                                            {{if Type =='Moderator'}}
                                                {{if (printTitle)}}
                                                    <span class="title">
                            					       Moderator :
                                                    </span>
                                                    ${( $data.printTitle= false),''}
                                                {{/if}}
                                                {{tmpl($value) "#speakersTemplate"}}
                                            {{/if}}
                                        {{/each}}
                                        ${( $data.printTitle= true),''}
                                            {{each Speakers}}
                                                {{if Type =='Speaker'}}
                                                    {{if (printTitle)}}
                                                            <span class="title">
                                                                {{if (($index + 1) < Speakers.length)}}
                                                                    Speakers : 
                                                                {{else}}
                                                                    Speaker :
                                                                {{/if}}
                                                               
                                                            </span>
                                                            ${( $data.printTitle= false),''}
                                                    {{/if}}
                                                    {{tmpl($value) "#speakersTemplate"}}
                                                    {{if (($index + 1) < Speakers.length)}}
                                                        <div class="solid_line"></div>
                                                    {{/if}}
                                                {{/if}}
                                            {{/each}}
                                            ${( $data.printTitle= true),''}
                        			 </div>
                            {{/if}}
                        </div>
            			<div class="span7">
            				{{if Description}}
                                <span class="submission_name has_border">
                            {{else}}
                                <span class="submission_name">
                            {{/if}}
                                {{if testTitle(Name)}}
                                    ${splitStr( Name, '-', 0)}
                                    <span>${splitStr(Name, '-', 1)}</span>
                                {{else}}
                                    ${Name}
                                {{/if}}
            				</span>
            					{{html Description}}
            				<div class="solid_line"></div>
            				<div class="share_session">
            					<!--Share Session<a href="#" title="" class="goggle_plus"></a><a  href="#" title="" class="rss"></a>-->
                                <!--a  href="#" title="Share the session on linkedIN" data-start="${Start}" data-track="${trackName}"data-submissionname ="${Name}" class="linkedin" onclick="linkedInShare(this); return false;"></a>
            					<!--a  href="#"title="Share the session on facebook"class="facebook"data-start="${Start}"                                    data-track="${trackName}"data-submissionname ="${Name}"onclick="facebookShare(this); return false;">                                </a>
            					<!--a  href="#"title="Share the session on twitter"class="twitter"onclick="twitterShare(this); return false;"></a-->
            				</div>
            			</div>
                        <div class="span12">
                            {{if (printLine)}}
                                <div class="line_divider"></div>
                            {{/if}}
                        </div>
            		</div>
                {{/each}}
                <!--end submissions-->
            {{/each}}
            
        {{/each}}
        </div>
    </div><!--end container 5-->
{{/each}}
</script>
<script id="speakersTemplate" type="text/x-jQuery-tmpl">
        <span class="speaker_name">
            &bull;
            ${FirstName} ${LastName} 
             
        </span>
        <span class="speaker_job">
            ${JobTitle}
            
        </span>
        <span class="speaker_company">
            ${CompanyName}
        </span>
        <div class="clear"></div>
</script> 
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

    <div class="span12" >
        <div id="summit_wrapper">
        </div>
        <div class="row">
            <div class="wrapper_track span12 summit_content">
            </div>
        </div>
    </div>
</div><!-- CLOSE page -->

<?php endif; ?>



<!--// WordPress Hook //-->
<?php get_footer(); ?>