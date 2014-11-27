// Initialize the plugin with no custom options
jQuery(document).ready(function($) {

    // Add title set in admin next to social icon.
    jQuery('#navigationmain .menu .social-icon a').each(function() {
        if (jQuery(this).attr('title')) jQuery(this).append('<span class="social-title">' + jQuery(this).attr('title') + '</span>');
    });


    resizeBoxex(jQuery(window).width());

    //menu open/close
    var menu_flag = false; 
    
    jQuery( ".navbar-toggle" ).click(
      function() {
      if(menu_flag == false)
        {
          jQuery( ".navbar-collapse" ).slideDown();
          menu_flag = true;
        }
      else
        {
          jQuery( ".navbar-collapse" ).slideUp();
          menu_flag = false;
        } 
      }
    );
});

jQuery(window).resize(function() {
    resizeBoxex(jQuery(window).width());
});


function resizeBoxex(windowWidth) {
    boxHeight = 0;


    jQuery('.third-section .box').each(function() {

        if (jQuery(this).outerHeight() > boxHeight) {
            boxHeight = jQuery(this).outerHeight();
        }

    });

    //alert(boxHeight)
    jQuery('.third-section .box').css('height', boxHeight);


	//jQuery('style').append('.third-section .box{height:'+boxHeight+'px!important;}');


    /*if(jQuery(window).width()<768){windowWidth=jQuery(window).width()}
    if(windowWidth<768 && windowWidth<jQuery(window).width()){jQuery(window).reload();}*/

}

//change social icons
jQuery('.icon-linkedin-sign').removeClass('icon-linkedin-sign').addClass('icon-linkedin');
jQuery('.icon-facebook-sign').removeClass('icon-facebook-sign').addClass('icon-facebook');
jQuery('.icon-twitter-sign').removeClass('icon-twitter-sign').addClass('icon-twitter');
jQuery('.icon-google-plus-sign').removeClass('icon-google-plus-sign').addClass('icon-google-plus');

//call to action remove <li>, move class to <a>
var classes = jQuery('#menu-item-2463').attr('class'); //keep updated
jQuery('#menu-item-2463 a').addClass(classes);
//remove <li>
jQuery('#menu-item-2463 a').unwrap();

//add clasess to updated footer button
jQuery('#updated').addClass(classes);

var classes = jQuery('#menu-item-2464').attr('class'); // register
jQuery('#menu-item-2464 a').addClass(classes);
jQuery('#menu-item-2464 a').unwrap();

//add clasess to register footer button
jQuery('#register').addClass(classes);

//get register link for mobile and footer button
var a_href = jQuery('.register-btn').attr('href');
jQuery('.register-btn-mobile').attr('href',a_href);
jQuery('#register').attr('href',a_href);

//get keep updated button link for footer button
var a_href = jQuery('.keep-updated-btn').attr('href');
jQuery('#updated').attr('href',a_href);










