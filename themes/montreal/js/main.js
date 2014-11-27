// Initialize the plugin with no custom options
		jQuery(document).ready(function($){
			// I just set some of the options
			jQuery("#scroll").smoothDivScroll({
                                mousewheelScrolling: false,
				touchScrolling: true,
				manualContinuousScrolling: true,
				hotSpotScrolling: false,

			});
		});

/// email check

function checkemail(myemail)
{
var str=myemail;
var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i
if (filter.test(str))
{
testresults=true
}
else
{
testresults=false
}
return (testresults)
}

/// to check that perticular value is EMPTY OR NOT
function ISBLANK(xx)
{ 
        var cc=0,tt;
		for(tt=0; tt<xx.length; tt++)
		{
		     if (xx.charAt(tt)==' ')
			 {
			 	cc=cc+1; // count blank character
			 }
		}
		if (cc==xx.length)
		{
			return true;  //// means it is BLANK
		}
	     return false;	//// means it is NOT BLANK
}

function is_radio_button_selected(fieldnm)
{
// set var radio_choice to false
var radio_choice = false;

// Loop from zero to the one minus the number of radio button selections
for (counter = 0; counter < fieldnm.length; counter++)
{
// If a radio button has been selected it will return true
// (If not it will return false)
if (fieldnm[counter].checked)
radio_choice = true; 
}

if (!radio_choice)
{
return (false); /// means not selected
}
return (true); /// means selected
}

jQuery(window).load(function($){
  jQuery('.flexslider').flexslider({
    animation: "slide"
  });
});

jQuery(document).ready(function($){

$().UItoTop({ easingType: 'easeOutQuart' });

		$("a[rel^='prettyPhoto']").prettyPhoto();
		$('footer div.meta ul li a').append('&nbsp;&nbsp; / &nbsp;&nbsp;');
		
		$('div.fancylist ul').addClass('meta left-padding');
		$('div.fancylist li').addClass('blacktext icon-chevron-right').prepend('&nbsp;');
		$('div.fancylist.tick li').removeClass('icon-chevron-right').addClass('icon-ok').prepend('&nbsp;');
		$('div.fancylist.triangle li').removeClass('icon-chevron-right').addClass('icon-caret-right').prepend('&nbsp;');
		$('div.fancylist.arrow li').removeClass('icon-chevron-right').addClass('icon-arrow-right').prepend('&nbsp;');
		$('div.fancylist.hand li').removeClass('icon-chevron-right').addClass('icon-hand-right').prepend('&nbsp;');
		
		selectnav('menu', {
		  label: 'Navigate to...',
		  nested: true,
		  indent: '-'
		});
		
		//AJAXIFY COMMENTS
		//AXAJIFY WORDPRESS COMMENTS//ALSO CREATES FIELD DETECTION
			var commentform=$('#commentform'); // find the comment form
			commentform.prepend('<div id="comment-status" ></div>'); // add info panel before the form to provide feedback or errors
			var statusdiv=$('#comment-status'); // define the infopanel
			
			commentform.submit(function(){
					//serialize and store form data in a variable
					var formdata=commentform.serialize();
					//Add a status message
					statusdiv.html('<p>Processing...</p>');
					//Extract action URL from commentform
					var formurl=commentform.attr('action');
					//Post Form with data
					$.ajax({
						type: 'post',
						url: formurl,
						data: formdata,
						error: function(XMLHttpRequest, textStatus, errorThrown){
							statusdiv.html('<p class="ajax-error" >You might have left one of the fields blank, or be posting too quickly</p>');
						},
						success: function(data, textStatus){
							if(data=="success")
								statusdiv.html('<p class="ajax-success" >Thanks for your comment. We appreciate your response.</p>');
							else
								statusdiv.html('<p class="ajax-error" >Thanks for your comment. We appreciate your response.</p>');
							commentform.find('textarea[name=comment]').val('');
						}
					});
					return false;
				
			});
			
	$('#newsletter').submit(function(){

		var action = $(this).attr('action');
		
		$("footer #message").slideUp(750,function() {
		$('footer #message').hide();

		$.post(action, {
			email: $('#email').val()
		},
			function(data){
				$('footer #message').html(data);
				$('footer #message').slideDown('slow');
				if(data.match('success') != null) $('#newsletter').slideUp('slow');

			}
		);

		});

		return false;

	});
	
	//MEDIA PLAYER
	$('audio,video').mediaelementplayer({
		videoWidth: '100%',
		videoHeight: '100%',
		audioWidth: '100%',
		features: ['playpause','progress','tracks','volume'],
		videoVolume: 'horizontal'
	});
	
	//TEST FOR TOUCH DEVICES
	if( (/iPhone|iPod|iPad|Android|BlackBerry/).test(navigator.userAgent) ) {
		jQuery('#navigationmain ul').css( { 'display' : 'none' } );
		jQuery('select.selectnav').css( { 'display' : 'block', 'padding' : '10px', 'font-family' : 'inherit', 'width' : '60%', 'border-radius' : '4px', 'font-size' : '14px', 'margin-bottom' : '10px', 'margin-top' : '15px', 'float' : 'right' } );
	}	

});

 
// navivation 


