// Initialize the plugin with no custom options
jQuery(document).ready(function($) {

    // Add title set in admin next to social icon.
    jQuery('#navigationmain .menu .social-icon a').each(function() {
        if (jQuery(this).attr('title')) jQuery(this).append('<span class="social-title">' + jQuery(this).attr('title') + '</span>');
    });


    resizeBoxex(jQuery(window).width());






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
