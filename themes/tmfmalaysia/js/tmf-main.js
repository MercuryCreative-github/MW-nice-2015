// Initialize the plugin with no custom options
jQuery(document).ready(function($) {

    // Add title set in admin next to social icon.
    jQuery('#navigationmain .menu .social-icon a').each(function() {
        if (jQuery(this).attr('title')) jQuery(this).append('<span class="social-title">' + jQuery(this).attr('title') + '</span>');
    });

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

    menuChanges();
});

jQuery(window).resize(function() {
    resizeBoxex();
});

jQuery(window).load(function() {
    resizeBoxex();

});

function resizeBoxex() {

function resizeBoxex() {



    boxHeight = 0;


    jQuery('.third-section .box').each(function() {

        jQuery(this).attr('img', jQuery('img',this).height())

        if (jQuery(this).outerHeight() > boxHeight) {boxHeight = jQuery(this).outerHeight();}

    });


    //jQuery('.third-section .box').css('height', boxHeight);

    //jQuery('.third-section .box .wpb_single_image').css({'position':'absolute','bottom': '-8px','left': 0});

    //jQuery('style').append('.third-section .box{height:'+boxHeight+'px!important;}');


    /*if(jQuery(window).width()<768){windowWidth=jQuery(window).width()}
    if(windowWidth<768 && windowWidth<jQuery(window).width()){jQuery(window).reload();}*/

}

function menuChanges(){
    mainnav=jQuery('#navigationmain').addClass('originalNav').css('margin',0).html();
    jQuery('.head .twelve.columns.nav-border').prepend('<nav id="navigationmain" class="secondNav">'+mainnav+'</nav>');


    jQuery('.secondNav ul').css({'position':'absolute', 'right':0});
    
    jQuery('.secondNav ul li').each(function(){
        if(!jQuery(this).hasClass('social-icon')){jQuery(this).hide();}
    })

    jQuery('.originalNav ul li').each(function(){
        if(jQuery(this).hasClass('social-icon')){jQuery(this).remove();}
    })

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


}


/* Responsive Table */
/* This fixes the left col and scroll the others in smaller resolutions */
jQuery(document).ready(function() {
   
  var switched = false;
  var updateTables = function() {
    if ((jQuery(window).width() < 767) && !switched ){
      switched = true;
      jQuery("table.responsive").each(function(i, element) {
        splitTable(jQuery(element));
      });
      return true;
    }
    else if (switched && (jQuery(window).width() > 767)) {
      switched = false;
      jQuery("table.responsive").each(function(i, element) {
        unsplitTable(jQuery(element));
      });
    }
  };
   
  jQuery(window).load(updateTables);
  jQuery(window).on("redraw",function(){switched=false;updateTables();}); // An event to listen for
  jQuery(window).on("resize", updateTables);
   
    
    function splitTable(original)
    {
        original.wrap("<div class='table-wrapper' />");
        
        var copy = original.clone();
        copy.find("td:not(:first-child), th:not(:first-child)").css("display", "none");
        copy.removeClass("responsive");
        
        original.closest(".table-wrapper").append(copy);
        copy.wrap("<div class='pinned' />");
        original.wrap("<div class='scrollable' />");

    setCellHeights(original, copy);
    }
    
    function unsplitTable(original) {
    original.closest(".table-wrapper").find(".pinned").remove();
    original.unwrap();
    original.unwrap();
    }

  function setCellHeights(original, copy) {
    var tr = original.find('tr'),
        tr_copy = copy.find('tr'),
        heights = [];

    tr.each(function (index) {
      var self = jQuery(this),
          tx = self.find('th, td');

      tx.each(function () {
        var height = jQuery(this).outerHeight(true);
        heights[index] = heights[index] || 0;
        if (height > heights[index]) heights[index] = height;
      });

    });

   jQuery('table.responsive tr').each(function (index) {
      jQuery(this).css('height',Math.max(55,jQuery('.pinned table tr:eq('+index+')').height()));
      jQuery('.pinned table tr:eq('+index+')').css('height',Math.max(55,jQuery('.pinned table tr:eq('+index+')').height()));
   });
   
   jQuery('.pinned table tr:eq(0)').each(function (index) {
      jQuery(this).css('height',Math.max(55,jQuery('table.responsive tr:eq('+index+')').height()));
   });
	
	
	
	
  }

});