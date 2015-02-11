jQuery(document).ready(ini);

function ini() {
    pricingPage();
    genericSmoothScroll();
    masornyCall();
    megaMenu();
    if (!getParameterByName('testing')){agendaAtaGlance()};
    fullAgenda();
    openClose();
    modalListener();
    showHiddenMenuText();
    menuWidgetLiLinks();
    moveSponsors();   
    reRowIotTabs();
    homepageSectionsResize();

}

function homepageSectionsResize(){
    var $ = jQuery;
    if($('.page-template-homepage-php').index()>0){

        var sponsorsHeight  = $('.section01-sponsors').outerHeight();
        var minHeight       = 760-sponsorsHeight;
        var screenHeight    = Math.max($(window).height(),minHeight);
        var menuHeight      = $('#header-section').outerHeight();

        // remove boxed layout
        $('.boxed-layout').removeClass('boxed-layout');

        // every section from 1 to 4 has full height or 768 (min)
        $('section:lt(4)').css('height',screenHeight);

        // section01 (the woman) must be full height but taking out the menu and the sponsors height.
        $('.section01').css('height',screenHeight-menuHeight);

        var section01Margin = Math.max((screenHeight-menuHeight-sponsorsHeight-$('.section01-info').outerHeight())/2,0);

        $('.section01-info').css('margin-top',section01Margin);
    }

    $('ul.reviews li').hide();
    showReview = Math.floor(3*Math.random());
    $('ul.reviews li:eq('+showReview+')').show();

}

function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " ")); 

}

function reRowIotTabs() {

   jQuery('.summit-tabs div[id|="tab"]').each(function(){

    // save div content from last row
    var newSpan4 =  jQuery('.row:eq(2) .span12', this);    

    // remove last row
    jQuery('.row:eq(2)', this).remove();

    //rename second row to row-fluid and span12 to span8
    jQuery('.row:eq(1) .span12', this).removeClass( "span12" ).addClass( "span8" );
    jQuery('.row:eq(1)', this).removeClass( "row" ).addClass( "row-fluid tabs-summits-content");

    //append newSpan4 to Rowfluid
    jQuery('.row-fluid', this).append(newSpan4);
    jQuery('.row-fluid .span12', this).removeClass( "span12" ).addClass( "span4" );

    }) 
}       




function agendaAtaGlance() {
    // chequeo que sea solo las paginas que tienen un .tt_timetable
    if (!jQuery('body').hasClass('page-child') &&  jQuery('.tt_timetable').length > -1){

        // agrego iconos según el nombre del evento. Si es Cable Summit -> cable.png
        jQuery('.event_header').each(function() {
            eventLink = jQuery(this).attr('title').split(' ');
            tab='#'+(jQuery(this).closest('div.wpb_tab').attr('id'));
            thisHref=jQuery(this).attr('href');
            jQuery(this).attr('href',thisHref+tab);
            var eventIcon = '/wp-content/uploads/2014/08/' + eventLink[0].toLowerCase() + '.png';
            // Si el evento es alguno de los "breaks", no agregamos nada.
            if(eventLink[0].toLowerCase()=='afternoon' || eventLink[0].toLowerCase()=='morning' || eventLink[0].toLowerCase()=='lunch' || eventLink[0].toLowerCase()=='registration' || eventLink[0].toLowerCase()=='hub' || eventLink[0].toLowerCase()=='continuous' || eventLink[0].toLowerCase()=='catalyst' ){
            }else{jQuery(this).parent().prepend('<img class="aag-icon" id="imgId" src="' + eventIcon + '">');}
        });

        // elimino los tooltip. Ahora no se están usando pero en la versión anterior de la agenda se usaban para conectar los foros con las presentaciones
        // por lo que seguro quedó algo de basura en este campo
        jQuery('.tt_tooltip_text').html('');
        jQuery('.tt_tooltip').removeClass('tt_tooltip');

        // Si el foro tiene no una url custom (/events/) cancelo las acciones y le saco el over, mouse pointer, etc a todo el bloque
        // En caso contrario tomo todo el bloque como link con un "onClick" que agrego
        jQuery('a.event_header').each(function() {
            linktocheck = jQuery(this).attr('href');
            if(linktocheck.indexOf('/events/')>-1){
                jQuery(this).parent().parent().removeAttr('onmouseover').removeAttr('onClick').removeAttr('onmouseout');
                jQuery(this).removeAttr('href');
                jQuery(this).css('cursor','default!important');
          }else{
            jQuery(this).parent().css({'cursor':'pointer'}).attr('onClick','window.location.href="'+linktocheck+'"');
        }
    });

    }

    // para cada tabla (lunes, martes, miercoles, jueves) busco cual es el máximo de columnas y lo guardo como atributo de los tr como tmax
    jQuery('.tt_timetable').each(function() {var tmax=0;jQuery('tr',this).each(function() { tmax = Math.max(tmax,jQuery('td',this).length); jQuery(this).attr('tmax',tmax);});});

    // por cada tr busco vacios y los borro. Ademas cambio el colspan de los que si tienen contenido. (esto hace que se vean bloques más grandes)
    jQuery('.tt_timetable tr').each(function() {

        // inicializo variables
        var colspan=1; // colspan a insertar
        var i=0;      // con esta variable recoro todos los td
        var j=1;     // con esta variable me fijo en el siguiente td
        var t = jQuery('td',this).length; // chequeo cuantos td tengo en este tr
        tmax= jQuery(this).attr('tmax'); // re-defino la cantidad de td máximo que tengo en la tabla
        jQuery('td',this).addClass('y'); // le agrego a cada td la clase "y" que luego uso verificar si el td sigue como estaba originalmente

        //une iguales: esta funcion no se usa casi pues no estamos repitiendo los mismos bloques como lo hacíamos originalmente
        for (i=0;i<=t;i++){
             j=i+1;

             // si el contenido del td es igual al contenido del siguiente td y que no sea vacio para borrar el siguiente y agrandar (colspan) este
             if(jQuery('td:eq('+i+')',this).text()==jQuery('td:eq('+j+')',this).text() && jQuery('td:eq('+i+')',this).text()!==''){
                colspan++;
                jQuery('td:eq('+j+')',this).remove();
                jQuery('td:eq('+i+')',this).attr('colspan',colspan).removeClass('y');
                i--;
            }
        }

        // busco los td vacios y les agrega la clase n
        for (i=0;i<=t;i++){if(jQuery('td:eq('+i+')',this).text()===''){jQuery('td:eq('+i+')',this).addClass('n');}}

        // n es el numero de td vacios en este tr
        n = jQuery('td.n',this).length;

        // defino cuanto voy a agrandar los td no vacios
        colspan=n;
        // si estan todos vacios menos uno, ese lo pongo a todo el ancho con colspan=t
        if(n==t-1){colspan=t;}

        if(t==tmax){

        // si tengo tantos td el máximo en esta tabla agrando los td y les agrego atributos
        //jQuery('td.y',this).attr('colspan',colspan);
        jQuery('td.y',this).attr('emp',n);
        jQuery('td.y',this).attr('total',t);
        jQuery('td.y',this).attr('max-total',tmax);

        // todos los td vacios de este tr se borran
        jQuery('td.n',this).attr('remove','si');
        jQuery('td.n',this).remove();
        if(jQuery('td.y',this).attr('colspan')==t-1){jQuery(this).remove();}
        }

    });

    // quito el rowspan a todos los td y borro todos los tr que solo contengan td vacios y no hayan sido borrados pues t era menor que tmax (t<tmax)
    jQuery('.tt_timetable tr').each(function() {
        jQuery('td.y',this).attr('rowspan','');
        n = jQuery('td.n',this).length;
        if(n == jQuery('td',this).length){
            jQuery(this).attr('borrar','si');
            jQuery(this).remove();
        }
        jQuery('td.n',this).remove();
      });

 

/*
   // si me quedo una fila de 1 td y la fila siguiente tiene tmax-1 tds, copio el td solitario y lo agrego a la fila siguiente
    jQuery('.tt_timetable tr').each(function() {
        tmax= jQuery(this).attr('tmax');
        nextTr= jQuery(this).next();
        if(jQuery('td',this).length==1){
            if(jQuery('td',nextTr).length==tmax-1){
                cut = jQuery(this).html();
                nextTr.append(cut);
                jQuery(this).remove();
            }
        }
    });

   // si me quedo una fila de 1 td y la fila anterior tiene tmax-1 tds, copio el td solitario y lo agrego a la fila anterior
    jQuery('.tt_timetable tr').each(function() {
        tmax= jQuery(this).attr('tmax');
        prevTr= jQuery(this).prev();
        if(jQuery('td',this).length==1){
            if(jQuery('td',prevTr).length==tmax-1){
                cut = jQuery(this).html();
                prevTr.append(cut);
                jQuery(this).remove();
            }
        }
    });*/

    // luego de todo este borrado, puede que quede algun td solo en un tr.
    jQuery('.tt_timetable tr').each(function(){
        if(jQuery('td', this).length==1){
            jQuery('td', this).attr('colspan',jQuery(this).attr('tmax'));
        }
    });

   
    //new tweaks passng to 12 columns width
    jQuery('.tt_timetable tr').each(function(){

         var $ = jQuery;
         var tds = jQuery('td', this).length;
         var tmax = $(this).attr('tmax');
         colspan =  60/tds;
         
         $('td',this).each(function(){
           $(this).attr('colspan',colspan)
           $(this).css('width',100/(60/colspan)+'%')  
         })
    })



    //borro los heads donde dice el titulo de la columna ej: "1st column Monday"
    jQuery('.tt_timetable thead').remove();
    // borro los filtros de navegacion del plug
    jQuery(".tt_tabs_navigation").remove();


    /* el responsive se hace 100% de nuevo */
    jQuery('.tt_timetable.small').html('');
    // agrego un ul tal cual lo tiene el plug original
    jQuery('.tt_timetable.small').append('<ul class="tt_items_list thin page_margin_top timetable_clearfix"></ul>');

    // por cada td en la tabla original voy a agregar un li al ul
    jQuery('.tt_timetable tr td').each(function(){
        eventLink="'"+jQuery('a', this).attr('href')+"'";
        if(eventLink.indexOf('/')<0){linkTo='';}else{linkTo='onClick="window.location.href='+eventLink+'"';}
        eventTitle=jQuery('.event_header', this).text();
        eventHour=jQuery('.hours', this).text();
        eventIcon=jQuery('.aag-icon', this).attr('href');
        eventText=jQuery('.before_hour_text', this).text();
        eventdiv = jQuery(this).parent().parent().parent().next();
        jQuery('ul', eventdiv)
        .append('<li class="timetable_clearfix icon_clock_black" title="'+eventTitle+'" '+linkTo+' ><div class="value">'+eventHour+'</div><h4>'+eventTitle+'</h4></br>'+eventText+'</li>');
    });

    // tomo el contendor de los tabs (que tienen las tablas adentro) y lo copio en el div fullwidthcontent que está justo antes del pie.
    if(jQuery('.getRidofClasses').length>0){
       // le saco el span8 que le agrega el page builder
       jQuery('.getRidofClasses').removeClass('span8');
       // copio el contenido
       agendaCopied=jQuery('.getRidofClasses').parent().html();
       // lo borro del content
       jQuery('.getRidofClasses').parent().remove();
       // lo agrego en fullwidthcontent
       jQuery('#fullwidthcontent').append('<div class="">'+agendaCopied+'</div>');
    }
}

jQuery(window).resize(function() {
    resizeSponsors();
    scrollListener();
    moveSponsors();
    //resizeNetcrackBanner();
    homepageSectionsResize();
});

jQuery(window).load(function() {
    jQuery( ".getRidofClasses" ).fadeTo('slow',1);
    resizeSponsors();
    scrollListener();
});

function fullAgenda(){
    if (jQuery('body').hasClass('page-child') &&  jQuery('.tt_timetable').length > -1){
    ///apis-new-oxygen/
    jQuery('.event_container').each(function(){
        jQuery('.tt_tooltip_content a').remove();
        //guardar contenido en una variable
        trackContent=jQuery(this).html();
        trackhours=jQuery('.hours',this).text();
        trackhours=trackhours.split(' - ');
        startHour=trackhours[0];
        endHour=trackhours[1];

        //eliminar el contenido
        jQuery(this).html('');
        jQuery(this).append('<div class="defTrack" starhour="'+startHour+'" endhour="'+endHour+'">'+trackContent+'</div>');
        jQuery(this).append('<div class="textTrack este"></div>');

        tab=(jQuery(this).closest('div.wpb_tab').attr('id')).substring(4);
        var arrayOfPresentations=[];

        jQuery('.moveDiv[day*="'+tab+'"]').each(function(){
            if(jQuery(this).attr('time')>=startHour){
                if(jQuery(this).attr('time')<endHour){

                    toAppend= jQuery(this).html();
                    //jQuery(this).hide();
                    key = jQuery('.timeTrack',this).text();

                    hiddenKey='<span style="display:none">'+key+'.00</span>';
                    arrayOfPresentations.push([hiddenKey+toAppend]);
                }
            }
        });

        arrayOfPresentations= arrayOfPresentations.sort();
        jQuery('.este').append(arrayOfPresentations.join(''));
        jQuery('.este').removeClass('este');
        arrayOfPresentations='';

        jQuery(this).parent().removeAttr('style').removeAttr('onmouseout').removeAttr('onmouseover');

        jQuery(this).removeAttr('style');
        jQuery('.defTrack img', this).remove();
        jQuery('.hours_container', this).remove();
        jQuery('.event_header').remove();
        jQuery(this).parent().removeClass('tt_tooltip');
        jQuery(this).removeClass('event_container');
    });

    jQuery('div.small').remove();
    //elimina todas las clases y elementos q no se necesitan
    jQuery('.tt_timetable').removeClass('tt_timetable');
    jQuery('.tt_tooltip_content').parent().remove();
    jQuery('#fullwidthcontent').children('.row').removeClass('row');
    jQuery('#fullwidthcontent tr').each(function(){if(jQuery(this).text()===''){jQuery(this).remove();}});

    jQuery('.imgMove').each(function(){
        var $ = jQuery;
        day = $(this).attr('day');
        start = $(this).attr('starthour');    
        cual=$('#tab-'+day+' .defTrack[starhour="'+start+'"]').append($(this));
    })

     jQuery('.defTrack .imgMove').removeClass('imgMove').addClass('sponsorLogo');
     jQuery('.defTrack').each(function(){

         var $ = jQuery;
         if($('img',this).length>0) {
         $('img:eq(0)',this).before('<p style="padding-bottom: 0;">Sponsored by:</p>');

         }



     })


    } // end if
}

function scrollListener() {


    offset=100;

    var hash = window.location.hash;
    if(hash=="#tab-monday" || hash=="#tab-tuesday" || hash=="#tab-wednesday" || hash=="#tab-thursday"){
        offset=200;
    }
    
    if(hash!==''){

    var screenTop = jQuery(document).scrollTop();
    var where = jQuery(hash).offset().top-offset; // antes decía +200 y comentado "+160"
    var time = 400;
    var direccion=1;
    jQuery("html,body").stop().animate({scrollTop: where}, time*2);
    jQuery(".page-content").fadeTo(time,1);
    }
}

function showHiddenMenuText() {
    jQuery('.fa-hidden').each(function() {
        if (jQuery(this).text() !== 'Menu Item') {
            jQuery(this).removeClass('fa-hidden').addClass('twitterhastag');
        }
    });
}

// function contactPeople() {
//     var cnames = ['Vanessa Lefebvre', 'Jessica Nagotko', 'Aaron Boasman', 'Janelle Morse', 'Rachael Jacobi', 'Elizabeth Coyne', 'Rebecca Huft', 'Renee Harris', 'Hugues Bardin', 'Carine Vandevelde', 'Mark Cartmell', 'Claire Ardley'];

//     for (c = 0; c < cnames.length; c++) {
//         contactname = cnames[c];
//         jQuery('.page-content div').each(function() {
//             if (jQuery(this).text().indexOf(contactname) > 0) {
//                 aname = cnames[c].split(' ');
//                 cmail = (aname[0][0] + aname[1]).toLowerCase();
//                 mailchange = '<a href="mailto:' + cmail + '@tmforum.org">' + contactname + '</a>';
//                 var replaced = jQuery(this).html().replace(contactname, mailchange);
//                 jQuery(this).html(replaced);
//             }
//         });
//     }
// }

function menuWidgetLiLinks() {
    jQuery('li[linkTo]').click(function(){
        if(jQuery(this).attr('external')==1){window.open(jQuery(this).attr('linkTo'));}
        else{window.location.href=jQuery(this).attr('linkTo');}
    });
}


function weather() {
    wfeed = 'http://wxdata.weather.com/wxdata/weather/rss/local/USCA0993?cm_ven=LWO&cm_cat=rss';
    jQuery(".home-list-icon ul li:eq(0)").append("<ul class='weatherfeed'></ul>");
    jQuery.ajax({
        type: "GET",
        url: wfeed,
        dataType: "xml",
        success: function(xml) {
            jQuery(xml).find('item').each(function() {
                var sTitle = jQuery(this).find('description').text();
                jQuery("<li></li>").html(sTitle).appendTo(".weatherfeed");
            });
        },
        error: function() {
            alert("An error occurred while processing XML file.");
        }
    });
}


function pricingPage() {

        // Pricing page for iframe
    if (jQuery('body.passes-prices #container').index() >= 0) {
        //jQuery('body.passes-prices #container').css('box-shadow', 'none');
        cambia(100);
        jQuery('.nomember').click(function() {
            cambia(100);
        });
        jQuery('.member').click(function() {
            cambia(-100);
        });
    }

    // Pricing page Member / No-Member buttons
    function cambia(cuanto) {
        if (cuanto == 100) {
            vip = '$2,399';
            gold = '$1,599';
            silver = '$650';
            vip1 = '$2,399';
            gold1 = '$1,599';
            vip2 = '$2,499';
            gold2 = '$1,899';
            jQuery('.nomember a').addClass('active');
            jQuery('.member a').removeClass('active');
        }
        if (cuanto == -100) {
            vip = '$2,299';
            gold = '$1,499';
            silver = '$550';
            vip1 = '$2,299';
            gold1 = '$1,499';
            vip2 = '$2,399';
            gold2 = '$1,799';
            jQuery('.member a').addClass('active');
            jQuery('.nomember a').removeClass('active');
        }

        jQuery('body.passes-prices .pricing-table-prices .td-blue').text(vip);
        jQuery('body.passes-prices .pricing-table-prices .td-orange').text(gold);
        jQuery('body.passes-prices .pricing-table-prices .td-grey').text(silver);

        jQuery('.v1').text(vip1);
        jQuery('.g1').text(gold1);
        jQuery('.s1').text(silver);
        jQuery('.v2').text(vip2);
        jQuery('.g2').text(gold2);
        jQuery('.s2').text(silver);

    }

    jQuery(".pricing-table-column ul li").after("<hr />");

    responsiveTables();
}

function customSearches() {
    //  HOME div links
    jQuery('.homelinks').each(function() {
        var div = jQuery(this);
        var href = jQuery('img', div).parent().attr('href');

        div.attr('link', href);
        div.css('cursor', 'pointer');

        jQuery(this).click(function() {
            var href = jQuery(this).attr('link');
            window.location = href;
        });
    });
}

function customSearches() {
    // custom search for speakers
    jQuery('#sspeakers').change(function() {
        jQuery('.fullName').each(function() {
            jQuery(this).parent().hide();
            if (jQuery(this).text().toUpperCase().indexOf(jQuery('#sspeakers').val().toUpperCase()) >= 0) {
                jQuery(this).parent().show();
            }
            if (jQuery('#sspeakers').val() === '') {
                jQuery(this).parent().show();
            }
        });
    });


    // custom search for justify
    jQuery('#sjustify').change(function() {
        jQuery('.attendees').each(function() {
            jQuery(this).hide();
            if (jQuery(this).text().toUpperCase().indexOf(jQuery('#sjustify').val().toUpperCase()) >= 0) {
                jQuery(this).show();
            }
            if (jQuery('#sjustify').val() === '') {
                jQuery(this).show();
            }
        });
    });
}

function modalListener() {
    // add modal data toggle to all the links with class .keep-updated
    jQuery('a.keep-updated').attr('data-toggle', "modal");
    jQuery('li.keep-updated a').attr('data-toggle', "modal");
    jQuery('[linkTo="#modal-2"]').attr('data-toggle', "modal").attr('href', "#modal-2");

}

function actOnIntegration() {
    // Act-On integration
    if (window.location.href.indexOf(".staging.") === -1) {
        jQuery("body").append('<img src="http://marketing.tmforum.org/acton/bn/1332/visitor.gif?ts=' + new Date().getTime() + '&ref=' + escape(document.referrer) + '">');
    }
}

function genericSmoothScroll() {
    /*  Scroll To Media center, Event Sponsors Justify Your Trip, FAQ*/
    jQuery("#menu-media-center li a").addClass("anchorScroll");
    jQuery("#menu-event-sponsors-event-sponsors-menu li a").addClass("anchorScroll");
    jQuery("#menu-justify-your-trip li a").addClass("anchorScroll");
    jQuery("#menu-aag li a").addClass("anchorScroll");
    jQuery(".faqs-page .questions li a").addClass("anchorScroll");
    /*Generic Smooth scroll to anchor*/
    jQuery(".anchorScroll").click(function(e) {href = jQuery(this).attr('href');doScroll(e, href);});
    /*Generic Smooth scroll to anchor in questions list*/
    jQuery(".questions ul li").click(function(e) {href = jQuery(".anchorScroll", this).attr('href');doScroll(e, href);});
    jQuery(".scroll-to-top").click(function(e) {href = '#main-container';doScroll(e, href);});
    jQuery(".scroll-to-top a").click(function(e) {href = '#main-container';doScroll(e, href);});

}

function doScroll(e, href) {
    if(e!==null){e.preventDefault();e.stopPropagation();}
    var screenTop = jQuery(document).scrollTop();
    var where = jQuery(href).offset().top - 140;
    var time = 500;
    var direccion=1;
    if(where-screenTop<0){direccion=-1;}
    whereA = screenTop + direccion*time;
    jQuery(".page-content").fadeTo(time,0, function(){jQuery("html,body").stop(true,true).animate({scrollTop: where}, 0);});
    jQuery("html,body").stop().animate({scrollTop: whereA}, time*2);
    jQuery(".page-content").fadeTo(time,1);
}

function masornyCall() {
    if (jQuery('#mcontainer').length > 0) {
        jQuery('#mcontainer').masonry({
            columnWidth: 20,
            itemSelector: '.item',
            "gutter": 5,
            "isFitWidth": true
        });
    }
}

function hideSponsorsBeforeResize() {
    // hide images under sponsors pages (sponsors, catalyst, bla) before resizing them
    jQuery(".sponsors .wpb_single_image img").css('opacity', '0');
    jQuery(".sponsors .image-caption").css('opacity', '0');
}

function megaMenu() {
    jQuery("#megaMenu").clone().appendTo("#mini-navigation"); //uber menu clone
    //uber menu mini styles
    jQuery("#mini-navigation #megaMenu").css("top", "34px");
    jQuery("#mini-navigation #megaMenu").css("width", "980px");
    jQuery("#mini-navigation #megaMenu").css("padding-left", "80px");
    //uber mini menu hover
    jQuery("#mini-navigation #megaMenu li").hover(
        function() {
            jQuery(this).children("ul").fadeIn();
        },
        function() {
            jQuery(this).children("ul").fadeOut();
        }
    );
}

/*Home - Conference Widget Move Node Function*/
function conference_move_widget_node() {
    var title = jQuery('#text-159').detach();
    var icons = jQuery('#text-158').detach();
    if (jQuery(document).width() < 768) {
        jQuery('.conference-widget-responsive-container').append(title);
        jQuery('.conference-widget-responsive-container').append(icons);
    } else {
        title = jQuery('#text-159').detach();
        icons = jQuery('#text-158').detach();
        jQuery('.sidebar').prepend(icons);
        jQuery('.sidebar').prepend(title);
    }
}
/*End conference_move_widget_node*/


/*========= align sponsor logos vertically according to height and ajust size to fit design ========== */
function resizeSponsors() {
    var logo = 0;

    

    jQuery(".sponsors .wpb_single_image img").each(function() {

        logo++;
        var coef = 1;
        var alignLogo = 'auto';
        var percentage = 0.35;
        jQuery(this).attr('style', '');
        var hbox = 100;
        if (jQuery(this).parent().parent().parent().parent().hasClass('span4')) {
            hbox = 150;
        }
        if (jQuery(this).parent().parent().parent().parent().hasClass('span-third')) {
            hbox = 150;
        }

        //hbox = 150 * coef;
        var himg = jQuery(this).height();
        var wimg = jQuery(this).width();
        var imgRate = jQuery(this).width() / himg;


        if (imgRate > 4.0) {
            percentage = 0.8;
        } else if (imgRate > 3.5) {
            percentage = 0.7;
        } else if (imgRate > 3.0) {
            percentage = 0.65;
        } else if (imgRate > 2.5) {
            percentage = 0.6;
        } else if (imgRate > 2.0) {
            percentage = 0.55;
        } else if (imgRate > 1.5) {
            percentage = 0.5;
        } else if (imgRate > 1) {
            percentage = 0.45;
        } else {
            percentage = 0.35;
        }

        var mimg = (hbox - himg * percentage * coef) / 2;
        if (jQuery(window).width() < 768) {
            percentage *= 0.5;
            coef *= 1.2;
            mimg = 20;
        }

        jQuery(this).height(himg * percentage * coef);
        jQuery(this).width(wimg * percentage * coef);
        jQuery(this).attr('por', percentage * coef);
        jQuery(this).attr('rat', imgRate);

        jQuery(this).css("margin", 'auto');
        jQuery(this).parent().css("padding-top", mimg + 'px ');
        jQuery(".sponsors .wpb_single_image img").css('opacity', '1');
        jQuery(".sponsors .image-caption").css('opacity', '1');

    });

    jQuery( ".inner-page-wrap" ).animate({opacity: 1,}, 1000, function() {});

}

function responsiveTables() {
    var switched = false;
    var updateTables = function() {
        if ((jQuery(window).width() < 767) && !switched) {
            switched = true;
            jQuery("table.responsive").each(function(i, element) {
                splitTable(jQuery(element));
            });
            return true;
        } else if (switched && (jQuery(window).width() > 767)) {
            switched = false;
            jQuery("table.responsive").each(function(i, element) {
                unsplitTable(jQuery(element));
            });
        }
        correctionTMF();
    };

    jQuery(window).load(updateTables);
    jQuery(window).on("redraw", function() {
        switched = false;
        updateTables();
    }); // An event to listen for
    jQuery(window).on("resize", updateTables);


    function splitTable(original) {
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

        tr.each(function(index) {
            var self = jQuery(this),
                tx = self.find('th, td');

            tx.each(function() {
                var height = jQuery(this).outerHeight(true);
                heights[index] = heights[index] || 0;
                if (height > heights[index]) heights[index] = height;
            });

        });

        tr_copy.each(function(index) {
            jQuery(this).height(heights[index]);
        });

        correctionTMF();
    }



    function correctionTMF() {
        tr = 0;
        jQuery('.pinned table tr').each(function() {
            oHeiht = jQuery(this).outerHeight();
            jQuery('.scrollable table.responsive tr:eq(' + tr + ')').height(oHeiht);
            tr++;
        });
    }
}

// A $( document ).ready() block.
function openClose() {
    //menu open/close
    var menu_flag = false;

    jQuery(".navbar-toggle").click(
        function() {
            if (menu_flag === false) {
                jQuery(".navbar-collapse").slideDown();
                menu_flag = true;
            } else {
                jQuery(".navbar-collapse").slideUp();
                menu_flag = false;
            }
        }
    );

    //get register link for mobile button
    var a_href = jQuery('.register-btn > a').attr('href');
    jQuery('.register-btn-mobile').attr('href', a_href);
}

// Responsive fix: move Sponsors logos to the bottom
// Use it when window.width < 768
function moveSponsors(){
    var topSponsors = jQuery('.top-sponsors-logos').html();
    var secSponsors = jQuery('.other-sponsors').html();

    /* Moving Logos */
    jQuery(".responsive-sponsors .main-sponsors").html(topSponsors);
    jQuery(".responsive-sponsors .secondary-sponsors .title").html(secSponsors);

    if (jQuery(window).width() < 768) {jQuery('.top-sponsors-logos').hide();jQuery('.responsive-sponsors').show();}
    else{jQuery('.top-sponsors-logos').show();jQuery('.responsive-sponsors').hide();}
}

// Online Training Page: Equal the height of the divs.
function equalCoursesBoxes(){
	var highestCourse = 0;
	jQuery('.online-training .about-table').each(function(){
		if(jQuery(this).height() > highestCourse){
			highestCourse = jQuery(this).height();
		}
	});
	console.log(highestCourse);
	jQuery('.online-training .about-table').each(function(){
		jQuery(this).height(highestCourse);
	});
}
