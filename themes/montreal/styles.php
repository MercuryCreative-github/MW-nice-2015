<?php 
	header("Content-Type: text/css; charset=utf-8");
	//Basics & WordPress Standards
	$absolute_path = __FILE__;
	$path_to_file = explode( 'wp-content', $absolute_path );
	$path_to_wp = $path_to_file[0];
	require_once( $path_to_wp.'/wp-load.php' );
	require_once( $path_to_wp.'/wp-includes/functions.php');
		
	$template_uri = get_template_directory_uri();
	$option = get_option('montreal_theme_options'); 
?>
div.largefont, div.meta, div.smallfont { font-size: 13px; font-size: 1.3rem; font-family: 'Ubuntu', sans-serif; text-align: justify; }
.blogContent h5 { font-weight: 700; margin-bottom: 20px !important; }
<<<<<<< HEAD
<<<<<<< HEAD
.cat-item a { color: #111111 !important; font-size: 1.5px; font-size: 1.5rem; font-weight: 300; text-transform: uppercase; }
=======
.cat-item a { color: <?php echo $option['copy_color']; ?> !important; font-size: 1.5px; font-size: 1.5rem; font-weight: 300; text-transform: uppercase; }
>>>>>>> master
=======
.cat-item a { color: #111111 !important; font-size: 1.5px; font-size: 1.5rem; font-weight: 300; text-transform: uppercase; }
>>>>>>> 3444288e90b247662206560f83abce370fc36145
aside div.twelve:last-of-type { border: none; background: none; }
div.codecolumn { font-size: 13px; font-size: 1.3rem; color: #444; font-family: 'Ubuntu', sans-serif; text-align: justify; margin-bottom: 18px; }
div.codecolumn blockquote { font-size: 16px }
.video-container { position: relative; padding-bottom: 52%; padding-top: 30px; height: 0; overflow: hidden; }
.video-container iframe, .video-container object, .video-container embed { position: absolute; top: 0; left: 0; width: 100%; height: 100%; }
/* 
' BASE
*/
html, body { height: 100% }
body, .codecolumn h5, .the-content h1, .the-content h2, .the-content h3, .the-content h4, .the-content h5, .the-content h6  { font-family: 'Oswald', sans-serif }
<<<<<<< HEAD
<<<<<<< HEAD
header { z-index: 50000; border-top: 1px solid #ffffff; display: block; background-color: #111111; position: fixed; width: 100%; top: 0; }
=======
header { z-index: 50000; border-top: 1px solid <?php echo $option['heading_color']; ?>; display: block; background-color: <?php echo $option['copy_color']; ?>; position: fixed; width: 100%; top: 0; }
>>>>>>> master
=======
header { z-index: 50000; border-top: 1px solid #ffffff; display: block; background-color: #111111; position: fixed; width: 100%; top: 0; }
>>>>>>> 3444288e90b247662206560f83abce370fc36145
.logged-in header { top: 28px; }
footer { width: 100%; z-index: 25; border-top: 1px solid #3c3c3c; display: block; z-index: 5000; }
footer.fixed { position: fixed; z-index: 2000; bottom: 0; height: 40px; overflow: hidden; }
footer .three h5 { margin-bottom: 20px }
.logo { display: block; background-repeat: no-repeat; overflow: hidden; -webkit-transition-duration: .6s; -moz-transition-duration: .6s; -o-transition-duration: .6s; -ms-transition-duration: .6s; margin-top: -5px; }
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 3444288e90b247662206560f83abce370fc36145
::selection { background: #793a89; color: #111111; }
::-moz-selection { background: #793a89; color: #111111; }
::-webkit-scrollbar { width: 15px; background: #ffffff; border-left: 1px solid #111111; }
::-webkit-scrollbar-thumb:vertical { background-color: #111111; border-top: 1px solid #ffffff; }
::-moz-scrollbar { width: 15px; background: #ffffff; border-left: 1px solid #111111; }
::-moz-scrollbar-thumb:vertical { background-color: #111111; border-top: 1px solid #ffffff; }
.white .drawer { border-top: 4px solid #111111 }
.black .drawer { border-top: 4px solid #ffffff }
<<<<<<< HEAD
=======
::selection { background: <?php echo $option['highlight_color']; ?>; color: <?php echo $option['copy_color']; ?>; }
::-moz-selection { background: <?php echo $option['highlight_color']; ?>; color: <?php echo $option['copy_color']; ?>; }
::-webkit-scrollbar { width: 15px; background: <?php echo $option['heading_color']; ?>; border-left: 1px solid <?php echo $option['copy_color']; ?>; }
::-webkit-scrollbar-thumb:vertical { background-color: <?php echo $option['copy_color']; ?>; border-top: 1px solid <?php echo $option['heading_color']; ?>; }
::-moz-scrollbar { width: 15px; background: <?php echo $option['heading_color']; ?>; border-left: 1px solid <?php echo $option['copy_color']; ?>; }
::-moz-scrollbar-thumb:vertical { background-color: <?php echo $option['copy_color']; ?>; border-top: 1px solid <?php echo $option['heading_color']; ?>; }
.white .drawer { border-top: 4px solid <?php echo $option['copy_color']; ?> }
.black .drawer { border-top: 4px solid <?php echo $option['heading_color']; ?> }
>>>>>>> master
=======
>>>>>>> 3444288e90b247662206560f83abce370fc36145
#map { height: 350px }
/*
' padding
*/
.nopadding { padding: 0 !important; margin: 0 auto; }
.smallpadding { padding-top: 10px !important; padding-bottom: 10px !important; }
.smallsidepadding, .intro h5 { padding-left: 10px !important; padding-right: 10px !important; }
.smalltoppadding { padding-top: 10px !important }
.smallbottompadding { padding-bottom: 10px !important }
.leftpadding { padding-left: 20px !important }
.rightpadding { padding-right: 20px !important }
.midpadding { padding-top: 20px !important; padding-bottom: 20px !important; }
.midtoppadding { padding-top: 20px !important }
.midbottompadding { padding-bottom: 20px !important }
<<<<<<< HEAD
<<<<<<< HEAD
.bigpadding { padding-top: 50px !important; padding-bottom: 50px !important; background-color: #fff !important;}
.bigsidepadding { padding-left: 50px !important; padding-right: 50px !important; }
.bigtoppadding { padding-top: 50px}
=======
.bigpadding { padding-top: 50px !important; padding-bottom: 50px !important; }
.bigsidepadding { padding-left: 50px !important; padding-right: 50px !important; }
.bigtoppadding { padding-top: 50px !important }
>>>>>>> master
=======
.bigpadding { padding-top: 50px !important; padding-bottom: 50px !important; background-color: #fff !important;}
.bigsidepadding { padding-left: 50px !important; padding-right: 50px !important; }
.bigtoppadding { padding-top: 50px}
>>>>>>> 3444288e90b247662206560f83abce370fc36145
.bigbottompadding { padding-bottom: 50px !important }
.largepadding { padding-top: 100px !important; padding-bottom: 100px !important; }
.largebottompadding { padding-bottom: 100px !important }
.largetoppadding { padding-top: 100px !important }
/*
' margin
*/
.nomargin { margin: 0 !important }
.smallmargin { margin-top: 10px !important; margin-bottom: 10px !important; }
.smalltopmargin { margin-top: 10px !important }
.smallbottommargin { margin-bottom: 10px !important }
.midmargin, .the-content h1, .the-content h2, .the-content h3, .the-content h4, .the-content h5, .the-content h6 { margin-top: 20px !important; margin-bottom: 20px !important; }
.midtopmargin { margin-top: 20px !important }
.midbottommargin { margin-bottom: 20px !important }
.bigmargin { margin-top: 50px !important; margin-bottom: 50px !important; }
.bigtopmargin { margin-top: 50px !important }
.bigbottommargin { margin-bottom: 50px !important }
.largemargin { margin-top: 100px !important; margin-bottom: 100px !important; }
.largebottommargin { margin-bottom: 100px !important }
.largetopmargin { margin-top: 100px !important }
/*
' HEADINGS
*/
h1 { font-size: 70px; font-size: 7.0rem; line-height: 1; }
h2 { font-size: 52px; font-size: 5.2rem; line-height: 1.2; }
h4.icon { font-size: 30px; font-size: 3.0rem; display: inline; padding-left: 20px; padding-top: 5px; color: #444; -webkit-transition-duration: 0.4s; -moz-transition-duration: 0.4s; -ms-transition-duration: 0.4s; -o-transition-duration: 0.4s; }
<<<<<<< HEAD
<<<<<<< HEAD
h4.icon:hover { color: #ffffff; -webkit-transition-duration: 0.4s; -moz-transition-duration: 0.4s; -ms-transition-duration: 0.4s; -o-transition-duration: 0.4s; }
=======
h4.icon:hover { color: <?php echo $option['heading_color']; ?>; -webkit-transition-duration: 0.4s; -moz-transition-duration: 0.4s; -ms-transition-duration: 0.4s; -o-transition-duration: 0.4s; }
>>>>>>> master
=======
h4.icon:hover { color: #ffffff; -webkit-transition-duration: 0.4s; -moz-transition-duration: 0.4s; -ms-transition-duration: 0.4s; -o-transition-duration: 0.4s; }
>>>>>>> 3444288e90b247662206560f83abce370fc36145
h5, .codecolumn h5 { font-size: 18px; font-size: 1.8rem; font-weight: 400; }
h6 { font-size: 15px; font-size: 1.5rem; font-weight: 300; }
h6 a:hover { text-decoration: underline }
h1.white, h2.white, h3.white, h4.white, h5.white, h6.white, h1.black, h2.black, h3.black, h4.black, h5.black, h6.black, .intro h5 { display: inline-block; margin-bottom: 9px; -webkit-transition-duration: 0.4s; -moz-transition-duration: 0.4s; -ms-transition-duration: 0.4s; -o-transition-duration: 0.4s; }
<<<<<<< HEAD
<<<<<<< HEAD
h1.white:hover, h2.white:hover, h3.white:hover, h4.white:hover, h5.white:hover, h6.white:hover, h1.black:hover, h2.black:hover, h3.black:hover, h4.black:hover, h5.black:hover, h6.black:hover { background: #793a89 !important; -webkit-transition-duration: 0.4s; -moz-transition-duration: 0.4s; -ms-transition-duration: 0.4s; -o-transition-duration: 0.4s; }
h5.border { border-bottom: 3px solid #111111; margin-bottom: 15px; padding-bottom: 15px; }
=======
h1.white:hover, h2.white:hover, h3.white:hover, h4.white:hover, h5.white:hover, h6.white:hover, h1.black:hover, h2.black:hover, h3.black:hover, h4.black:hover, h5.black:hover, h6.black:hover { background: <?php echo $option['highlight_color']; ?> !important; -webkit-transition-duration: 0.4s; -moz-transition-duration: 0.4s; -ms-transition-duration: 0.4s; -o-transition-duration: 0.4s; }
h5.border { border-bottom: 3px solid <?php echo $option['copy_color']; ?>; margin-bottom: 15px; padding-bottom: 15px; }
>>>>>>> master
=======
h1.white:hover, h2.white:hover, h3.white:hover, h4.white:hover, h5.white:hover, h6.white:hover, h1.black:hover, h2.black:hover, h3.black:hover, h4.black:hover, h5.black:hover, h6.black:hover { background: #793a89 !important; -webkit-transition-duration: 0.4s; -moz-transition-duration: 0.4s; -ms-transition-duration: 0.4s; -o-transition-duration: 0.4s; }
h5.border { border-bottom: 3px solid #111111; margin-bottom: 15px; padding-bottom: 15px; }
>>>>>>> 3444288e90b247662206560f83abce370fc36145
/*
' PAGE STYLES
*/
.hidden { overflow: hidden }
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 3444288e90b247662206560f83abce370fc36145
.black { background: #111111 }
.white, .intro h5 { background: #ffffff; box-sizing: border-box; -moz-box-sizing: border-box; -webkit-box-sizing: border-box; }
.grey { background: #e6e6e6 }
.drag { overflow-x: visible; overflow-y: hidden; padding: 0 0 !important; height: 420px; }
.dragbig { overflow-x: visible; overflow-y: hidden; padding: 0 0 !important; height: 100%; }
.slideshow { border-bottom: 6px solid #111111; height: 100%; }
.whitevertical { border-right: 1px solid #ffffff; padding-right: 20px; box-sizing: border-box; -moz-box-sizing: border-box; -webkit-box-sizing: border-box; }
.whitehorizontal { height: 1px; width: 100%; background-color: #ffffff; }
.blackvertical { border-right: 1px solid #111111; padding-right: 20px; box-sizing: border-box; -moz-box-sizing: border-box; -webkit-box-sizing: border-box; }
.blackhorizontal { height: 1px; width: 100%; background-color: #111111; }
<<<<<<< HEAD
=======
.black { background: <?php echo $option['copy_color']; ?> }
.white, .intro h5 { background: <?php echo $option['heading_color']; ?>; box-sizing: border-box; -moz-box-sizing: border-box; -webkit-box-sizing: border-box; }
.grey { background: #e6e6e6 }
.drag { overflow-x: visible; overflow-y: hidden; padding: 0 0 !important; height: 420px; }
.dragbig { overflow-x: visible; overflow-y: hidden; padding: 0 0 !important; height: 100%; }
.slideshow { border-bottom: 6px solid <?php echo $option['copy_color']; ?>; height: 100%; }
.whitevertical { border-right: 1px solid <?php echo $option['heading_color']; ?>; padding-right: 20px; box-sizing: border-box; -moz-box-sizing: border-box; -webkit-box-sizing: border-box; }
.whitehorizontal { height: 1px; width: 100%; background-color: <?php echo $option['heading_color']; ?>; }
.blackvertical { border-right: 1px solid <?php echo $option['copy_color']; ?>; padding-right: 20px; box-sizing: border-box; -moz-box-sizing: border-box; -webkit-box-sizing: border-box; }
.blackhorizontal { height: 1px; width: 100%; background-color: <?php echo $option['copy_color']; ?>; }
>>>>>>> master
=======
>>>>>>> 3444288e90b247662206560f83abce370fc36145
.greyhorizontal { background-color: #3c3c3c; height: 1px; width: 100%; }
.greyvertical { border-right: 1px solid #3c3c3c }
/*
' TEXT STYLES
*/
.uppercase { text-transform: uppercase }
p { font-family: 'Ubuntu', sans-serif }
.black p, footer div.meta ul li a { font-size: 13px; font-size: 1.3rem; color: #888; font-family: 'Ubuntu', sans-serif; }
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 3444288e90b247662206560f83abce370fc36145
/*.white p { font-size: 13px; font-size: 1.3rem; color: #444; font-family: 'Ubuntu', sans-serif; text-align: justify; }*/
.white blockquote { border-left: 2px solid #111111; font-family: 'Droid Serif', serif; font-weight: 400; font-style: italic; }
.black blockquote { border-left: 2px solid #ffffff; font-family: 'Droid Serif', serif; font-weight: 400; font-style: italic; }
.white p.dropcaps:first-letter { font-size: 65px; font-size: 6.5rem; float: left; color: #111111; line-height: 50px; padding-right: 10px; font-family: inherit; }
.black p.dropcaps:first-letter { font-size: 65px; font-size: 6.5rem; float: left; color: #ffffff; line-height: 50px; padding-right: 10px; font-family: inherit; }
.center, .center p { text-align: center !important }
.right { text-align: right !important }
.left { text-align: left !important }
.whitetext, footer.black a, .whitetext h1, .the-content h3.whitetext{ color: #ffffff !important; -webkit-transition-duration: 0.3s; -moz-transition-duration: 0.3s; -ms-transition-duration: 0.3s; -o-transition-duration: 0.3s; }
.blacktext, .the-content h1, .the-content h2, .the-content h3, .the-content h4, .the-content h5, .the-content h6, .white blockquote p, .white blockquote, .intro h5, .codecolumn h5, .url, .comment-reply-link, aside a { color: #111111 !important; -webkit-transition-duration: 0.3s; -moz-transition-duration: 0.3s; -ms-transition-duration: 0.3s; -o-transition-duration: 0.3s; }
.greytext, p.portfolio-navigation a, a[rel="tag"], footer div.meta ul li a { color: #777 !important; -webkit-transition-duration: 0.3s; -moz-transition-duration: 0.3s; -ms-transition-duration: 0.3s; -o-transition-duration: 0.3s; }
.greentext { color: #793a89 !important; -webkit-transition-duration: 0.3s; -moz-transition-duration: 0.3s; -ms-transition-duration: 0.3s; -o-transition-duration: 0.3s; }
a.greentext:hover { color: #ffffff !important; -webkit-transition-duration: 0.3s; -moz-transition-duration: 0.3s; -ms-transition-duration: 0.3s; -o-transition-duration: 0.3s; }
.black a.greytext:hover, footer div.meta li a:hover { color: #ffffff !important; -webkit-transition-duration: 0.3s; -moz-transition-duration: 0.3s; -ms-transition-duration: 0.3s; -o-transition-duration: 0.3s; }
.white a.greytext:hover, p.portfolio-navigation a:hover, .white a[rel="tag"]:hover { color: #111111 !important; -webkit-transition-duration: 0.3s; -moz-transition-duration: 0.3s; -ms-transition-duration: 0.3s; -o-transition-duration: 0.3s; }
<<<<<<< HEAD
=======
.white p { font-size: 13px; font-size: 1.3rem; color: #444; font-family: 'Ubuntu', sans-serif; text-align: justify; }
.white blockquote { border-left: 2px solid <?php echo $option['copy_color']; ?>; font-family: 'Droid Serif', serif; font-weight: 400; font-style: italic; }
.black blockquote { border-left: 2px solid <?php echo $option['heading_color']; ?>; font-family: 'Droid Serif', serif; font-weight: 400; font-style: italic; }
.white p.dropcaps:first-letter { font-size: 65px; font-size: 6.5rem; float: left; color: <?php echo $option['copy_color']; ?>; line-height: 50px; padding-right: 10px; font-family: inherit; }
.black p.dropcaps:first-letter { font-size: 65px; font-size: 6.5rem; float: left; color: <?php echo $option['heading_color']; ?>; line-height: 50px; padding-right: 10px; font-family: inherit; }
.center, .center p { text-align: center !important }
.right { text-align: right !important }
.left { text-align: left !important }
.whitetext, footer.black a, .whitetext h1, .the-content h3.whitetext{ color: <?php echo $option['heading_color']; ?> !important; -webkit-transition-duration: 0.3s; -moz-transition-duration: 0.3s; -ms-transition-duration: 0.3s; -o-transition-duration: 0.3s; }
.blacktext, .the-content h1, .the-content h2, .the-content h3, .the-content h4, .the-content h5, .the-content h6, .white blockquote p, .white blockquote, .intro h5, .codecolumn h5, .url, .comment-reply-link, aside a { color: <?php echo $option['copy_color']; ?> !important; -webkit-transition-duration: 0.3s; -moz-transition-duration: 0.3s; -ms-transition-duration: 0.3s; -o-transition-duration: 0.3s; }
.greytext, p.portfolio-navigation a, a[rel="tag"], footer div.meta ul li a { color: #777 !important; -webkit-transition-duration: 0.3s; -moz-transition-duration: 0.3s; -ms-transition-duration: 0.3s; -o-transition-duration: 0.3s; }
.greentext { color: <?php echo $option['highlight_color']; ?> !important; -webkit-transition-duration: 0.3s; -moz-transition-duration: 0.3s; -ms-transition-duration: 0.3s; -o-transition-duration: 0.3s; }
a.greentext:hover { color: <?php echo $option['heading_color']; ?> !important; -webkit-transition-duration: 0.3s; -moz-transition-duration: 0.3s; -ms-transition-duration: 0.3s; -o-transition-duration: 0.3s; }
.black a.greytext:hover, footer div.meta li a:hover { color: <?php echo $option['heading_color']; ?> !important; -webkit-transition-duration: 0.3s; -moz-transition-duration: 0.3s; -ms-transition-duration: 0.3s; -o-transition-duration: 0.3s; }
.white a.greytext:hover, p.portfolio-navigation a:hover, .white a[rel="tag"]:hover { color: <?php echo $option['copy_color']; ?> !important; -webkit-transition-duration: 0.3s; -moz-transition-duration: 0.3s; -ms-transition-duration: 0.3s; -o-transition-duration: 0.3s; }
>>>>>>> master
=======
>>>>>>> 3444288e90b247662206560f83abce370fc36145
.italic, .white blockquote p, .white blockquote, .the-content h1 em, .the-content h2 em, .the-content h3 em, .the-content h4 em, .the-content h5 em, .the-content h6 em { font-family: 'Droid Serif', serif; font-weight: 400; font-style: italic; }
.italicbold { font-family: 'Droid Serif', serif; font-weight: 700; font-style: italic; }
.light, .intro span, .the-content h1 strong,  .the-content h2 strong,  .the-content h3 strong,  .the-content h4 strong,  .the-content h5 strong,  .the-content h6 strong { font-weight: 300 }
.bold { font-weight: 400 }
.extrabold, .codecolumn h5, strong, b { font-weight: 700 }
.meta, div.meta p, .sidebar p, .intro p { font-size: 12px !important; font-size: 1.2rem !important; }
.smallfont, div.smallfont p, a[rel="tag"] { font-size: 10px !important; font-size: 1.0rem !important; }
.largefont { font-size: 18px !important; font-size: 1.8rem !important; }
/* Tabs */
.tabs div.tab-content { padding-left: 0px }
<<<<<<< HEAD
<<<<<<< HEAD
.tabs ul.tab-nav  { border-bottom: 1px solid #111111 }
.tabs .tab-nav li a { display: block; width: auto; height: 29px; padding: 0 12px; line-height: 30px; border: 1px solid #111111; margin: 0 -1px 0 0; color: #2e2e2e; text-shadow: 0 0; background: #ECECEC; font-size: 12px; }
.tabs .tab-nav li.active a, aside .tabs li.active a { height: 30px; font-weight: 400; color: #ffffff !important; background: #111111; border-width: 1px 1px 0; text-shadow: 0 0; }
=======
.tabs ul.tab-nav  { border-bottom: 1px solid <?php echo $option['copy_color']; ?> }
.tabs .tab-nav li a { display: block; width: auto; height: 29px; padding: 0 12px; line-height: 30px; border: 1px solid <?php echo $option['copy_color']; ?>; margin: 0 -1px 0 0; color: #2e2e2e; text-shadow: 0 0; background: #ECECEC; font-size: 12px; }
.tabs .tab-nav li.active a, aside .tabs li.active a { height: 30px; font-weight: 400; color: <?php echo $option['heading_color']; ?> !important; background: <?php echo $option['copy_color']; ?>; border-width: 1px 1px 0; text-shadow: 0 0; }
>>>>>>> master
=======
.tabs ul.tab-nav  { border-bottom: 1px solid #111111 }
.tabs .tab-nav li a { display: block; width: auto; height: 29px; padding: 0 12px; line-height: 30px; border: 1px solid #111111; margin: 0 -1px 0 0; color: #2e2e2e; text-shadow: 0 0; background: #ECECEC; font-size: 12px; }
.tabs .tab-nav li.active a, aside .tabs li.active a { height: 30px; font-weight: 400; color: #ffffff !important; background: #111111; border-width: 1px 1px 0; text-shadow: 0 0; }
>>>>>>> 3444288e90b247662206560f83abce370fc36145
/*
' navigation
*/
/* default style */
.selectnav { display: none }
/* small screen */
@media screen and (max-width: 767px) { 
	.js #menu { display: none }
<<<<<<< HEAD
<<<<<<< HEAD
	.js .selectnav { display: block; padding: 10px; background-color: #ffffff; font-family: inherit; width: 100% !important; max-width: 400px; border-radius: 4px; text-shadow: 0 1px 1px white; font-family: inherit; font-size: 14px; font-size: 1.4rem; margin-bottom: 20px; float: none; margin: 0 auto 20px; }
}
a { color: #793a89; }
a:hover { color: #793a89; }

nav a { color: #fff; }
nav a:hover { color: #e5e5e5; }
#navigationmain ul { margin: 0; padding: 0; float: right; padding: 15px 0px 0px 0px; }
#navigationmain li { margin: 0; padding: 0; }
#navigationmain li.active a { color: #ccc }
#navigationmain li.active > ul > li > a { color: #111111 }
=======
	.js .selectnav { display: block; padding: 10px; background-color: <?php echo $option['heading_color']; ?>; font-family: inherit; width: 100% !important; max-width: 400px; border-radius: 4px; text-shadow: 0 1px 1px white; font-family: inherit; font-size: 14px; font-size: 1.4rem; margin-bottom: 20px; float: none; margin: 0 auto 20px; }
=======
	.js .selectnav { display: block; padding: 10px; background-color: #ffffff; font-family: inherit; width: 100% !important; max-width: 400px; border-radius: 4px; text-shadow: 0 1px 1px white; font-family: inherit; font-size: 14px; font-size: 1.4rem; margin-bottom: 20px; float: none; margin: 0 auto 20px; }
>>>>>>> 3444288e90b247662206560f83abce370fc36145
}
a { color: <?php echo $option['highlight_color']; ?>; }
a:hover { color: <?php echo $option['highlight_color']; ?>; }

nav a { color: #fff; }
nav a:hover { color: #e5e5e5; }
#navigationmain ul { margin: 0; padding: 0; float: right; padding: 22px 0px 0px 0px; }
#navigationmain li { margin: 0; padding: 0; }
#navigationmain li.active a { color: #ccc }
<<<<<<< HEAD
#navigationmain li.active > ul > li > a { color: <?php echo $option['copy_color']; ?> }
>>>>>>> master
=======
#navigationmain li.active > ul > li > a { color: #111111 }
>>>>>>> 3444288e90b247662206560f83abce370fc36145
#navigationmain a { margin: 0; padding: 0; }
#navigationmain ul { list-style: none; text-transform: uppercase; }
#navigationmain a { text-decoration: none }
#navigationmain { }
/*
#navigationmain > ul > li > ul > li{opacity:0.7;}
#navigationmain > ul > li > ul > li:hover{opacity:1; -webkit-transition-duration:0.1s;} */
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 3444288e90b247662206560f83abce370fc36145
#navigationmain > ul > li { float: left; margin-right: 1px; position: relative; margin-left: 30px;}
#navigationmain > ul > li.active a, #navigationmain > ul > li.current-menu-item a { color: #888 }
#navigationmain > ul > li > a { color: #ffffff; font-family: inherit; font-weight: 300; font-size: 11px; font-size: 1.4rem; letter-spacing: 2px; -webkit-transition-duration: .6s; -moz-transition-duration: .6s; -o-transition-duration: .6s; -ms-transition-duration: .6s; }
#navigationmain ul > ul { padding: 0px }
#navigationmain > ul > li > a:hover { color: white; -webkit-transition-duration: .3s; -moz-transition-duration: .3s; -o-transition-duration: .3s; -ms-transition-duration: .3s; padding: 5px 20px; background: #9d5ca5;}
#navigationmain > ul > li > a:active {color: white;-webkit-transition-duration: .3s;-moz-transition-duration: .3s;-o-transition-duration: .3s;-ms-transition-duration: .3s;padding: 5px 20px;background: #9d5ca5;}
#navigationmain > ul > li > ul { opacity: 0; visibility: hidden; background-color: #ffffff; text-align: left; position: absolute; top: 60px; left: 50%; margin-left: -75px; margin-top: -22px; width: 180px; -webkit-transition: all .3s .1s; -moz-transition: all .3s .1s; -o-transition: all .3s .1s; transition: all .3s .1s; -webkit-box-shadow: 0px 1px 3px rgba(0,0,0,.4); -moz-box-shadow: 0px 1px 3px rgba(0,0,0,.4); box-shadow: 0px 1px 3px rgba(0,0,0,.4); padding-top: 0px; }
#navigationmain > ul > li:hover > ul { opacity: 1; top: 64px; visibility: visible; }
#navigationmain > ul > li > ul:before { content: ''; display: block; border-color: transparent transparent #ffffff transparent; border-style: solid; border-width: 10px; position: absolute; top: -20px; left: 50%; margin-left: -10px; }
#navigationmain > ul ul > li { position: relative }
#navigationmain ul ul a { color: #111111; font-family: inherit; font-size: 13px; font-size: 1.3rem; background-color: #ffffff; padding: 15px 8px 15px 16px; display: block; -webkit-transition: background-color .1s; -moz-transition: background-color .1s; -o-transition: background-color .1s; transition: background-color .1s; }
#navigationmain ul ul a:hover { background-color: #ddd; color: #111111 !important; -webkit-transition: background-color .2s; -moz-transition: background-color .2s; -o-transition: background-color .2s; transition: background-color .2s; }
<<<<<<< HEAD
=======
#navigationmain > ul > li { float: left; margin-right: 1px; position: relative; }
#navigationmain > ul > li.active a, #navigationmain > ul > li.current-menu-item a { color: #888 }
#navigationmain > ul > li > a { color: <?php echo $option['heading_color']; ?>; font-family: inherit; font-weight: 300; font-size: 11px; font-size: 1.1rem; letter-spacing: 2px; padding-left: 30px; -webkit-transition-duration: .6s; -moz-transition-duration: .6s; -o-transition-duration: .6s; -ms-transition-duration: .6s; }
#navigationmain ul > ul { padding: 0px }
#navigationmain > ul > li > a:hover { color: <?php echo $option['highlight_color']; ?>; -webkit-transition-duration: .3s; -moz-transition-duration: .3s; -o-transition-duration: .3s; -ms-transition-duration: .3s; }
#navigationmain > ul > li > ul { opacity: 0; visibility: hidden; background-color: <?php echo $option['heading_color']; ?>; text-align: left; position: absolute; top: 60px; left: 50%; margin-left: -75px; margin-top: -22px; width: 180px; -webkit-transition: all .3s .1s; -moz-transition: all .3s .1s; -o-transition: all .3s .1s; transition: all .3s .1s; -webkit-box-shadow: 0px 1px 3px rgba(0,0,0,.4); -moz-box-shadow: 0px 1px 3px rgba(0,0,0,.4); box-shadow: 0px 1px 3px rgba(0,0,0,.4); padding-top: 0px; }
#navigationmain > ul > li:hover > ul { opacity: 1; top: 64px; visibility: visible; }
#navigationmain > ul > li > ul:before { content: ''; display: block; border-color: transparent transparent <?php echo $option['heading_color']; ?> transparent; border-style: solid; border-width: 10px; position: absolute; top: -20px; left: 50%; margin-left: -10px; }
#navigationmain > ul ul > li { position: relative }
#navigationmain ul ul a { color: <?php echo $option['copy_color']; ?>; font-family: inherit; font-size: 13px; font-size: 1.3rem; background-color: <?php echo $option['heading_color']; ?>; padding: 15px 8px 15px 16px; display: block; -webkit-transition: background-color .1s; -moz-transition: background-color .1s; -o-transition: background-color .1s; transition: background-color .1s; }
#navigationmain ul ul a:hover { background-color: #ddd; color: <?php echo $option['copy_color']; ?> !important; -webkit-transition: background-color .2s; -moz-transition: background-color .2s; -o-transition: background-color .2s; transition: background-color .2s; }
>>>>>>> master
=======
>>>>>>> 3444288e90b247662206560f83abce370fc36145
#navigationmain ul ul ul { visibility: hidden; opacity: 0; position: absolute; top: -16px; left: 206px; padding: 16px 0 20px 0; background-color: rgb(250,250,250); text-align: left; width: 160px; -webkit-transition: all .3s; -moz-transition: all .3s; -o-transition: all .3s; transition: all .3s; -webkit-box-shadow: 0px 1px 3px rgba(0,0,0,.4); -moz-box-shadow: 0px 1px 3px rgba(0,0,0,.4); box-shadow: 0px 1px 3px rgba(0,0,0,.4); }
#navigationmain ul ul > li:hover > ul { opacity: 1; left: 196px; visibility: visible; }
/* ' ABOUT */ 

.client {
	opacity:0.9;
	-webkit-transition-duration:.3s;
	-moz-transition-duration:.3s;
	-o-transition-duration:.3s;
	-ms-transition-duration:.3s;
<<<<<<< HEAD
<<<<<<< HEAD
	border-bottom:3px solid #ffffff;
=======
	border-bottom:3px solid <?php echo $option['heading_color']; ?>;
>>>>>>> master
=======
	border-bottom:3px solid #ffffff;
>>>>>>> 3444288e90b247662206560f83abce370fc36145
}
.client:hover {
	opacity:0.9;
	-webkit-transition-duration:.3s;
	-moz-transition-duration:.3s;
	-o-transition-duration:.3s;
	-ms-transition-duration:.3s;
<<<<<<< HEAD
<<<<<<< HEAD
	border-bottom:3px solid #111111;
=======
	border-bottom:3px solid <?php echo $option['copy_color']; ?>;
>>>>>>> master
=======
	border-bottom:3px solid #111111;
>>>>>>> 3444288e90b247662206560f83abce370fc36145
}
.person {
	position:relative;
	display:block;
	-webkit-transition-duration:.6s;
	-moz-transition-duration:.6s;
	-o-transition-duration:.6s;
	-ms-transition-duration:.6s;
<<<<<<< HEAD
<<<<<<< HEAD
	border:1px solid #ffffff;
=======
	border:1px solid <?php echo $option['heading_color']; ?>;
>>>>>>> master
=======
	border:1px solid #ffffff;
>>>>>>> 3444288e90b247662206560f83abce370fc36145
	zoom:1;
	clear:both;
}
.person img {
	display:block;
	zoom:1;
}
.person:hover img {
	opacity:0.6;
	-webkit-transition-duration:.3s;
	-moz-transition-duration:.3s;
	-o-transition-duration:.3s;
	-ms-transition-duration:.3s;
}
.person:hover {
<<<<<<< HEAD
<<<<<<< HEAD
	-webkit-box-shadow:5px 5px 0px #ffffff;
=======
	-webkit-box-shadow:5px 5px 0px <?php echo $option['heading_color']; ?>;
>>>>>>> master
=======
	-webkit-box-shadow:5px 5px 0px #ffffff;
>>>>>>> 3444288e90b247662206560f83abce370fc36145
	-webkit-transition-duration:.3s;
	-moz-transition-duration:.3s;
	-o-transition-duration:.3s;
	-ms-transition-duration:.3s;
	-webkit-transform:translate(0,-5px)
}
.personinfo {
	position:absolute !important;
	z-index:3;
	width:100%;
	height:100%;
	left:0;
	top:0;
	/* background:url(../img/static.gif);*/ cursor:default;
<<<<<<< HEAD
<<<<<<< HEAD
	background:#111111;
=======
	background:<?php echo $option['copy_color']; ?>;
>>>>>>> master
=======
	background:#111111;
>>>>>>> 3444288e90b247662206560f83abce370fc36145
	-webkit-transition-duration:.6s;
	-moz-transition-duration:.6s;
	-o-transition-duration:.6s;
	-ms-transition-duration:.6s;
	box-sizing:border-box;
	-webkit-box-sizing:border-box;
	-moz-box-sizing:border-box;
	opacity:0;
	padding:20px 20px !important;
	display:none;
	zoom:1;
}
.team {
	-moz-box-sizing:border-box;
	-webkit-box-sizing:border-box;
	display:block;
	zoom:1;
}
.team img {
	width:100%;
	display:block;
}
.person:hover .personinfo,.team:hover .personinfo {
	display:block;
	-webkit-transition-duration:.6s;
	-moz-transition-duration:.6s;
	-o-transition-duration:.6s;
	-ms-transition-duration:.6s;
	opacity:1;
}
.team:hover .person {
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 3444288e90b247662206560f83abce370fc36145
	-webkit-box-shadow:5px 5px 0px #ffffff;
	-moz-box-shadow:5px 5px 0px #ffffff;
	-o-box-shadow:5px 5px 0px #ffffff;
	-ms-box-shadow:5px 5px 0px #ffffff;
<<<<<<< HEAD
=======
	-webkit-box-shadow:5px 5px 0px <?php echo $option['heading_color']; ?>;
	-moz-box-shadow:5px 5px 0px <?php echo $option['heading_color']; ?>;
	-o-box-shadow:5px 5px 0px <?php echo $option['heading_color']; ?>;
	-ms-box-shadow:5px 5px 0px <?php echo $option['heading_color']; ?>;
>>>>>>> master
=======
>>>>>>> 3444288e90b247662206560f83abce370fc36145
	-webkit-transition-duration:.3s;
	-moz-transition-duration:.3s;
	-o-transition-duration:.3s;
	-ms-transition-duration:.3s;
	-webkit-transform: translate(0,-5px)
}
/*
' BLOG
*/
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 3444288e90b247662206560f83abce370fc36145
.blogArticle { -moz-box-sizing: border-box; -webkit-box-sizing: border-box; padding-bottom: 35px; margin-bottom: 15px; -webkit-transition-duration: .4s; -moz-transition-duration: .4s; -o-transition-duration: .4s; -ms-transition-duration: .4s; padding: 10px; background: #ffffff; }
.blogArticle:hover { -webkit-transition-duration: .4s; -moz-transition-duration: .4s; -o-transition-duration: .4s; -ms-transition-duration: .4s; background: #111111; }
.blogArticle:hover .blacktext { color: #ffffff !important; -webkit-transition-duration: .4s; -moz-transition-duration: .4s; -o-transition-duration: .4s; -ms-transition-duration: .4s; }
.blogArticle img { display: block; width: 100%; border: 1px solid #3c3c3c; -webkit-filter: grayscale(); -moz-box-sizing: border-box; -webkit-box-sizing: border-box; }
.blogArticle:hover img { -webkit-filter: saturate(100%) }
.blogArticle:hover p { -webkit-transition-duration: .4s; -moz-transition-duration: .4s; -o-transition-duration: .4s; -ms-transition-duration: .4s; color: #ddd; }
.blogArticle a.greytext:hover, .blogArticle a[rel="tag"]:hover { -webkit-transition-duration: .4s; -moz-transition-duration: .4s; -o-transition-duration: .4s; -ms-transition-duration: .4s; color: #793a89 !important; }
<<<<<<< HEAD
=======
.blogArticle { -moz-box-sizing: border-box; -webkit-box-sizing: border-box; padding-bottom: 35px; margin-bottom: 15px; -webkit-transition-duration: .4s; -moz-transition-duration: .4s; -o-transition-duration: .4s; -ms-transition-duration: .4s; padding: 10px; background: <?php echo $option['heading_color']; ?>; }
.blogArticle:hover { -webkit-transition-duration: .4s; -moz-transition-duration: .4s; -o-transition-duration: .4s; -ms-transition-duration: .4s; background: <?php echo $option['copy_color']; ?>; }
.blogArticle:hover .blacktext { color: <?php echo $option['heading_color']; ?> !important; -webkit-transition-duration: .4s; -moz-transition-duration: .4s; -o-transition-duration: .4s; -ms-transition-duration: .4s; }
.blogArticle img { display: block; width: 100%; border: 1px solid #3c3c3c; -webkit-filter: grayscale(); -moz-box-sizing: border-box; -webkit-box-sizing: border-box; }
.blogArticle:hover img { -webkit-filter: saturate(100%) }
.blogArticle:hover p { -webkit-transition-duration: .4s; -moz-transition-duration: .4s; -o-transition-duration: .4s; -ms-transition-duration: .4s; color: #ddd; }
.blogArticle a.greytext:hover, .blogArticle a[rel="tag"]:hover { -webkit-transition-duration: .4s; -moz-transition-duration: .4s; -o-transition-duration: .4s; -ms-transition-duration: .4s; color: <?php echo $option['highlight_color']; ?> !important; }
>>>>>>> master
=======
>>>>>>> 3444288e90b247662206560f83abce370fc36145
.blogpost { box-sizing: border-box; -moz-box-sizing: border-box; -webkit-box-sizing: border-box; padding: 100px 20px; }
.blogpost img { display: block; max-width: 100%; border: 1px solid #3c3c3c; box-sizing: border-box; -moz-box-sizing: border-box; -webkit-box-sizing: border-box; margin: 15px 0px; }
.sidebar { box-sizing: border-box; -moz-box-sizing: border-box; -webkit-box-sizing: border-box; padding: 100px 20px; }
/*
' PORTFOLIO
*/
.itempost { box-sizing: border-box; -moz-box-sizing: border-box; -webkit-box-sizing: border-box; padding: 100px 20px 100px 0px; }
.itempost img { /* -webkit-filter: grayscale(); WEBKIT BROWSERS RENDER IMAGE GRAYSCALE */ border: 0px !important; }
/* drag */
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 3444288e90b247662206560f83abce370fc36145
.item img { display: block; border: 1px solid #111111; box-sizing: border-box; -moz-box-sizing: border-box; -webkit-box-sizing: border-box; }
.item { -webkit-transition-duration: .2s; -moz-transition-duration: .2s; -o-transition-duration: .2s; -ms-transition-duration: .2s; width: 300px; margin-bottom: 25px; }
.item:hover .whitetext { color: #793a89 !important; -webkit-transition-duration: .6s; -moz-transition-duration: .6s; -o-transition-duration: .6s; -ms-transition-duration: .6s; }
/* stripe */
.itemstripe { width: 200px; height: 100%; display: block; background-color: #ffffff; -webkit-transition-duration: .6s; -moz-transition-duration: .6s; -o-transition-duration: .6s; -ms-transition-duration: .6s; position: relative !important; overflow: hidden; border-right: 1px solid #111111; }
.itemstripe:hover { width: 210px; -webkit-transition-duration: .6s; -moz-transition-duration: .6s; -o-transition-duration: .6s; -ms-transition-duration: .6s; box-shadow: -3px 0 2px rgba(0,0,0,0.3); -webkit-box-shadow: -3px 0 2px rgba(0,0,0,0.3); -moz-box-shadow: -3px 0 2px rgba(0,0,0,0.3); -o-box-shadow: -3px 0 2px rgba(0,0,0,0.3); -ms-box-shadow: -3px 0 2px rgba(0,0,0,0.3); }
.itemstripe img { -webkit-transition-duration: .6s; -moz-transition-duration: .6s; -o-transition-duration: .6s; -ms-transition-duration: .6s; -webkit-filter: grayscale(); }
.itemstripe:hover img { -webkit-transition-duration: .6s; -moz-transition-duration: .6s; -o-transition-duration: .6s; -ms-transition-duration: .6s; -webkit-filter: saturate(100%); }
.infowhite { position: absolute !important; z-index: 3; bottom: 100px; width: 100%; height: 170px; background-color: #ffffff; cursor: default; -webkit-transition-duration: .3s; -moz-transition-duration: .3s; -o-transition-duration: .3s; -ms-transition-duration: .3s; box-sizing: border-box; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; }
.itemstripe:hover .infowhite { background-color: #111111; -webkit-transition-duration: .3s; -moz-transition-duration: .3s; -o-transition-duration: .3s; -ms-transition-duration: .3s; color: #ffffff !important; cursor: pointer; }
.itemstripe a { color: inherit; cursor: pointer; }
.itemstripe .infowhite:hover .view { color: #4DBCE9 !important; -webkit-transition-duration: .4s; -moz-transition-duration: .4s; -o-transition-duration: .4s; -ms-transition-duration: .4s; }
.itemstripe:hover .infowhite .blacktext { color: #ffffff !important; -webkit-transition-duration: .4s; -moz-transition-duration: .4s; -o-transition-duration: .4s; -ms-transition-duration: .4s; }
.itemstripe:hover .infowhite a.blacktext { color: #793a89 !important; -webkit-transition-duration: .4s; -moz-transition-duration: .4s; -o-transition-duration: .4s; -ms-transition-duration: .4s; }
.itemstripe:hover .infowhite span.blacktext { color: #793a89 !important; -webkit-transition-duration: .4s; -moz-transition-duration: .4s; -o-transition-duration: .4s; -ms-transition-duration: .4s; }
<<<<<<< HEAD
=======
.item img { display: block; border: 1px solid <?php echo $option['copy_color']; ?>; box-sizing: border-box; -moz-box-sizing: border-box; -webkit-box-sizing: border-box; }
.item { -webkit-transition-duration: .2s; -moz-transition-duration: .2s; -o-transition-duration: .2s; -ms-transition-duration: .2s; width: 300px; margin-bottom: 25px; }
.item:hover .whitetext { color: <?php echo $option['highlight_color']; ?> !important; -webkit-transition-duration: .6s; -moz-transition-duration: .6s; -o-transition-duration: .6s; -ms-transition-duration: .6s; }
/* stripe */
.itemstripe { width: 200px; height: 100%; display: block; background-color: <?php echo $option['heading_color']; ?>; -webkit-transition-duration: .6s; -moz-transition-duration: .6s; -o-transition-duration: .6s; -ms-transition-duration: .6s; position: relative !important; overflow: hidden; border-right: 1px solid <?php echo $option['copy_color']; ?>; }
.itemstripe:hover { width: 210px; -webkit-transition-duration: .6s; -moz-transition-duration: .6s; -o-transition-duration: .6s; -ms-transition-duration: .6s; box-shadow: -3px 0 2px rgba(0,0,0,0.3); -webkit-box-shadow: -3px 0 2px rgba(0,0,0,0.3); -moz-box-shadow: -3px 0 2px rgba(0,0,0,0.3); -o-box-shadow: -3px 0 2px rgba(0,0,0,0.3); -ms-box-shadow: -3px 0 2px rgba(0,0,0,0.3); }
.itemstripe img { -webkit-transition-duration: .6s; -moz-transition-duration: .6s; -o-transition-duration: .6s; -ms-transition-duration: .6s; -webkit-filter: grayscale(); }
.itemstripe:hover img { -webkit-transition-duration: .6s; -moz-transition-duration: .6s; -o-transition-duration: .6s; -ms-transition-duration: .6s; -webkit-filter: saturate(100%); }
.infowhite { position: absolute !important; z-index: 3; bottom: 100px; width: 100%; height: 170px; background-color: <?php echo $option['heading_color']; ?>; cursor: default; -webkit-transition-duration: .3s; -moz-transition-duration: .3s; -o-transition-duration: .3s; -ms-transition-duration: .3s; box-sizing: border-box; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; }
.itemstripe:hover .infowhite { background-color: <?php echo $option['copy_color']; ?>; -webkit-transition-duration: .3s; -moz-transition-duration: .3s; -o-transition-duration: .3s; -ms-transition-duration: .3s; color: <?php echo $option['heading_color']; ?> !important; cursor: pointer; }
.itemstripe a { color: inherit; cursor: pointer; }
.itemstripe .infowhite:hover .view { color: #4DBCE9 !important; -webkit-transition-duration: .4s; -moz-transition-duration: .4s; -o-transition-duration: .4s; -ms-transition-duration: .4s; }
.itemstripe:hover .infowhite .blacktext { color: <?php echo $option['heading_color']; ?> !important; -webkit-transition-duration: .4s; -moz-transition-duration: .4s; -o-transition-duration: .4s; -ms-transition-duration: .4s; }
.itemstripe:hover .infowhite a.blacktext { color: <?php echo $option['highlight_color']; ?> !important; -webkit-transition-duration: .4s; -moz-transition-duration: .4s; -o-transition-duration: .4s; -ms-transition-duration: .4s; }
.itemstripe:hover .infowhite span.blacktext { color: <?php echo $option['highlight_color']; ?> !important; -webkit-transition-duration: .4s; -moz-transition-duration: .4s; -o-transition-duration: .4s; -ms-transition-duration: .4s; }
>>>>>>> master
=======
>>>>>>> 3444288e90b247662206560f83abce370fc36145
/*.blog {
-moz-box-sizing: border-box;
-webkit-box-sizing: border-box;
padding: 10px;
margin-bottom: 15px;
-webkit-transition-duration: .4s;
-moz-transition-duration: .4s;
-o-transition-duration: .4s;
-ms-transition-duration: .4s;
padding: 10px;
background: 
<<<<<<< HEAD
<<<<<<< HEAD
#ffffff;
}*/
.item:hover a.blacktext, .blog:hover a.blacktext { -webkit-transition-duration: .4s; -moz-transition-duration: .4s; -o-transition-duration: .4s; -ms-transition-duration: .4s; letter-spacing: 3px; color: #111111; }
=======
<?php echo $option['heading_color']; ?>;
}*/
.item:hover a.blacktext, .blog:hover a.blacktext { -webkit-transition-duration: .4s; -moz-transition-duration: .4s; -o-transition-duration: .4s; -ms-transition-duration: .4s; letter-spacing: 3px; color: <?php echo $option['copy_color']; ?>; }
>>>>>>> master
=======
#ffffff;
}*/
.item:hover a.blacktext, .blog:hover a.blacktext { -webkit-transition-duration: .4s; -moz-transition-duration: .4s; -o-transition-duration: .4s; -ms-transition-duration: .4s; letter-spacing: 3px; color: #111111; }
>>>>>>> 3444288e90b247662206560f83abce370fc36145
/*
 GRID
*/
.griditem { margin-bottom: 15px; box-sizing: border-box; display: block; }
.griditem img { -webkit-filter: grayscale(); -webkit-transition-duration: .3s; -moz-transition-duration: .3s; -o-transition-duration: .3s; -ms-transition-duration: .3s; display: block; }
.griditem:hover img { -webkit-filter: saturate(100%); -webkit-transition-duration: .3s; -moz-transition-duration: .3s; -o-transition-duration: .3s; -ms-transition-duration: .3s; }
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 3444288e90b247662206560f83abce370fc36145
.griditem a { color: #ffffff; -webkit-transition-duration: .3s; -moz-transition-duration: .3s; -o-transition-duration: .3s; -ms-transition-duration: .3s; }
.gridinfo { position: absolute !important; z-index: 3; width: 100%; height: 100%; left: 0; top: 0; cursor: pointer; background: #793a89; -webkit-transition-duration: .6s; -moz-transition-duration: .6s; -o-transition-duration: .6s; -ms-transition-duration: .6s; box-sizing: border-box; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; opacity: 0; display: hidden; padding: 50px 20px !important; text-align: center; }
.griditem:hover .gridinfo { display: block; -webkit-transition-duration: .6s; -moz-transition-duration: .6s; -o-transition-duration: .6s; -ms-transition-duration: .6s; opacity: 1; -webkit-transition-delay: 1s; }
.gridblack { position: absolute !important; z-index: 3; width: 100%; height: 100%; left: 0; top: 0; cursor: pointer; background: #111111; -webkit-transition-duration: .6s; -moz-transition-duration: .6s; -o-transition-duration: .6s; -ms-transition-duration: .6s; box-sizing: border-box; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; opacity: 0; display: hidden; padding: 20px 20px !important; }
<<<<<<< HEAD
=======
.griditem a { color: <?php echo $option['heading_color']; ?>; -webkit-transition-duration: .3s; -moz-transition-duration: .3s; -o-transition-duration: .3s; -ms-transition-duration: .3s; }
.gridinfo { position: absolute !important; z-index: 3; width: 100%; height: 100%; left: 0; top: 0; cursor: pointer; background: <?php echo $option['highlight_color']; ?>; -webkit-transition-duration: .6s; -moz-transition-duration: .6s; -o-transition-duration: .6s; -ms-transition-duration: .6s; box-sizing: border-box; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; opacity: 0; display: hidden; padding: 50px 20px !important; text-align: center; }
.griditem:hover .gridinfo { display: block; -webkit-transition-duration: .6s; -moz-transition-duration: .6s; -o-transition-duration: .6s; -ms-transition-duration: .6s; opacity: 1; -webkit-transition-delay: 1s; }
.gridblack { position: absolute !important; z-index: 3; width: 100%; height: 100%; left: 0; top: 0; cursor: pointer; background: <?php echo $option['copy_color']; ?>; -webkit-transition-duration: .6s; -moz-transition-duration: .6s; -o-transition-duration: .6s; -ms-transition-duration: .6s; box-sizing: border-box; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; opacity: 0; display: hidden; padding: 20px 20px !important; }
>>>>>>> master
=======
>>>>>>> 3444288e90b247662206560f83abce370fc36145
.griditem:hover .gridblack { display: block; -webkit-transition-duration: .6s; -moz-transition-duration: .6s; -o-transition-duration: .6s; -ms-transition-duration: .6s; opacity: 1; -webkit-transition-delay: 3s; }
/*
' GRID BLOCK
*/
.gridder { width: 100%; max-width: 1007px; margin: 0 auto; padding-top: 77px !important; }
.gridblock { position: relative; float: left; width: 335px; overflow: hidden; cursor: pointer; }
<<<<<<< HEAD
<<<<<<< HEAD
.gridblock img { display: block; box-sizing: border-box; -moz-box-sizing: border-box; -webkit-box-sizing: border-box; border: 1px solid #111111; }
.gridinfo { position: absolute !important; z-index: 3; width: 100%; height: 100%; left: 0; top: 0; cursor: pointer; background: #793a89; -webkit-transition-duration: .6s; -moz-transition-duration: .6s; -o-transition-duration: .6s; -ms-transition-duration: .6s; box-sizing: border-box; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; opacity: 0; display: block; padding: 20px 20px !important; text-align: center; }
=======
.gridblock img { display: block; box-sizing: border-box; -moz-box-sizing: border-box; -webkit-box-sizing: border-box; border: 1px solid <?php echo $option['copy_color']; ?>; }
.gridinfo { position: absolute !important; z-index: 3; width: 100%; height: 100%; left: 0; top: 0; cursor: pointer; background: <?php echo $option['highlight_color']; ?>; -webkit-transition-duration: .6s; -moz-transition-duration: .6s; -o-transition-duration: .6s; -ms-transition-duration: .6s; box-sizing: border-box; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; opacity: 0; display: block; padding: 20px 20px !important; text-align: center; }
>>>>>>> master
=======
.gridblock img { display: block; box-sizing: border-box; -moz-box-sizing: border-box; -webkit-box-sizing: border-box; border: 1px solid #111111; }
.gridinfo { position: absolute !important; z-index: 3; width: 100%; height: 100%; left: 0; top: 0; cursor: pointer; background: #793a89; -webkit-transition-duration: .6s; -moz-transition-duration: .6s; -o-transition-duration: .6s; -ms-transition-duration: .6s; box-sizing: border-box; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; opacity: 0; display: block; padding: 20px 20px !important; text-align: center; }
>>>>>>> 3444288e90b247662206560f83abce370fc36145
.gridblock:hover .gridinfo { display: block; -webkit-transition-duration: .6s; -moz-transition-duration: .6s; -o-transition-duration: .6s; -ms-transition-duration: .6s; opacity: 1; }
/*
' FORM
*/
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 3444288e90b247662206560f83abce370fc36145
form label { text-transform: uppercase; font-size: 11px; color: #111111; }
.white .field .text, .white .field .search, .white .field .textarea { -webkit-box-shadow: 0px 0px; box-shadow: 0px 0px; background: #ffffff; padding: 6px 5px; border-radius: 0px; border: 1px solid #111111; }
.white .field .text input, .white .field .text input[type="search"], .white form textarea { font-size: 12px !important; font-family: inherit; background-color: #ffffff; letter-spacing: 1.4px; color: #111111; }
.submit, .form-submit input { font-family: inherit; cursor: pointer; }
.white .submit, .form-submit input { font-size: 11px; font-size: 1.1rem; margin-top: 15px; border: 0px; color: #ccc; width: 100%; padding: 7px 0px; display: block; text-align: center; background: #111111; -webkit-transition-duration: 0.4s; -moz-transition-duration: 0.4s; -o-transition-duration: 0.4s; -ms-transition-duration: 0.4s; }
.white .submit:hover, .form-submit input:hover { color: #ffffff; background: #793a89; -webkit-transition-duration: 0.4s; -moz-transition-duration: 0.4s; -o-transition-duration: 0.4s; -ms-transition-duration: 0.4s; }
.black .field .text, .black .field .search, .black .field .textarea { -webkit-box-shadow: 0px 0px; box-shadow: 0px 0px; background: #ffffff; padding: 6px 5px; border-radius: 0px; border: 0px; }
.black .field .text input, .black .field .text input[type="search"], .black form textarea { font-size: 12px !important; font-family: inherit; background-color: #ffffff; letter-spacing: 1.4px; color: #111111; }
.black .submit { font-size: 11px; font-size: 1.1rem; border: 0px; color: #111111; width: 100%; padding: 7px 0px; display: block; text-align: center; background: #ffffff; -webkit-transition-duration: 0.4s; -moz-transition-duration: 0.4s; -o-transition-duration: 0.4s; -ms-transition-duration: 0.4s; }
.black .submit:hover { color: #111111; background: #793a89; -webkit-transition-duration: 0.4s; -moz-transition-duration: 0.4s; -o-transition-duration: 0.4s; -ms-transition-duration: 0.4s; }
/*
' BUTTON
*/
.button { letter-spacing: 1px; font-size: 11px; font-size: 1.1rem; margin-top: 15px; border: 0px; color: #ffffff; background: #111111; width: 100%; padding: 12px 0px; display: block; text-align: center; box-sizing: border-box; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; -ms-box-sizing: border-box; -o-box-sizing: border-box; -webkit-transition-duration: 0.4s; -moz-transition-duration: 0.4s; -o-transition-duration: 0.4s; -ms-transition-duration: 0.4s; }
.button:hover { letter-spacing: 1px; color: #ffffff; text-shadow: 0px 1px 0px rgba(0,0,0,0.15); background: #793a89; box-shadow: 0px 0px #111111; -webkit-box-shadow: 0px 0px #111111; -moz-box-shadow: 0px 0px #111111; -ms-box-shadow: 0px 0px #111111; -o-box-shadow: 0px 0px #111111; -webkit-transition-duration: 0.4s; -moz-transition-duration: 0.4s; -o-transition-duration: 0.4s; -ms-transition-duration: 0.4s; }
.black .button { letter-spacing: 1px; font-size: 11px; font-size: 1.1rem; margin-top: 15px; border: 0px; color: #111111; background: #ffffff; width: 100%; padding: 12px 0px; display: block; text-align: center; box-sizing: border-box; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; -ms-box-sizing: border-box; -o-box-sizing: border-box; -webkit-transition-duration: 0.4s; -moz-transition-duration: 0.4s; -o-transition-duration: 0.4s; -ms-transition-duration: 0.4s; }
.black .button:hover { letter-spacing: 1px; color: #ffffff; text-shadow: 0px 1px 0px rgba(0,0,0,0.15); background: #793a89; box-shadow: 0px 0px #111111; -webkit-box-shadow: 0px 0px #111111; -moz-box-shadow: 0px 0px #111111; -ms-box-shadow: 0px 0px #111111; -o-box-shadow: 0px 0px #111111; -webkit-transition-duration: 0.4s; -moz-transition-duration: 0.4s; -o-transition-duration: 0.4s; -ms-transition-duration: 0.4s; }
.secondbutton { display: block; text-align: center; letter-spacing: 1px; font-size: 12px; font-size: 1.2rem; font-weight: 300; border-radius: 4px; width: 100%; padding: 15px 5px; border: 1px solid #000; color: #ffffff; background: #111111; margin-top: 15px; -webkit-box-shadow: inset 1px 1px 0 0px rgba(255,255,255,0.3), inset 0px 26px 10px 0px rgba(255,255,255,0.08), inset -1px 0px 0 0px rgba(255,255,255,0.3), inset 0px -10px 10px 0px rgba(0,0,0,0.05); -moz-box-shadow: inset 1px 1px 0 0px rgba(255,255,255,0.3), inset 0px 26px 10px 0px rgba(255,255,255,0.08), inset -1px 0px 0 0px rgba(255,255,255,0.3), inset 0px -10px 10px 0px rgba(0,0,0,0.05); box-shadow: inset 1px 1px 0 0px rgba(255,255,255,0.3), inset 0px 26px 10px 0px rgba(255,255,255,0.08), inset -1px 0px 0 0px rgba(255,255,255,0.3), inset 0px -10px 10px 0px rgba(0,0,0,0.05); -webkit-box-sizing: border-box; -moz-box-sizing: border-box; -ms-box-sizing: border-box; box-sizing: border-box; -webkit-transition-duration: 0.4s; -moz-transition-duration: 0.4s; -o-transition-duration: 0.4s; -ms-transition-duration: 0.4s; }
.secondbutton:hover { letter-spacing: 1px; color: #ffffff; text-shadow: 0px 1px 0px rgba(0,0,0,0.15); border: 1px solid inherit; background: #793a89; box-shadow: 0px 0px #111111; -webkit-box-shadow: 0px 0px #111111; -moz-box-shadow: 0px 0px #111111; -ms-box-shadow: 0px 0px #111111; -o-box-shadow: 0px 0px #111111; -webkit-box-shadow: inset 1px 1px 0 0px rgba(255,255,255,0.5), inset 0px 10px 10px 0px rgba(255,255,255,0.05), inset -1px 0px 0 0px rgba(255,255,255,0.5), inset 0px -10px 10px 0px rgba(0,0,0,0.05); -moz-box-shadow: inset 1px 1px 0 0px rgba(255,255,255,0.5), inset 0px 10px 10px 0px rgba(255,255,255,0.05), inset -1px 0px 0 0px rgba(255,255,255,0.5), inset 0px -10px 10px 0px rgba(0,0,0,0.05); box-shadow: inset 1px 1px 0 0px rgba(255,255,255,0.5), inset 0px 10px 10px 0px rgba(255,255,255,0.05), inset -1px 0px 0 0px rgba(255,255,255,0.5), inset 0px -10px 10px 0px rgba(0,0,0,0.05); -webkit-box-sizing: border-box; -moz-box-sizing: border-box; -ms-box-sizing: border-box; box-sizing: border-box; -webkit-transition-duration: 0.4s; -moz-transition-duration: 0.4s; -o-transition-duration: 0.4s; -ms-transition-duration: 0.4s; }
.thirdbutton { display: block; text-align: center; letter-spacing: 1px; font-size: 12px; font-size: 1.2rem; font-weight: 400; border-radius: 4px; width: 100%; padding: 15px 5px; border: 1px solid #ffb72c; color: #ffffff; text-shadow: 0px 1px 0px rgba(0,0,0,0.15); background: #ffd34c; margin-top: 15px; -webkit-box-shadow: inset 1px 1px 0 0px rgba(255,255,255,0.3), inset 0px 26px 10px 0px rgba(255,255,255,0.08), inset -1px 0px 0 0px rgba(255,255,255,0.3), inset 0px -10px 10px 0px rgba(0,0,0,0.05); -moz-box-shadow: inset 1px 1px 0 0px rgba(255,255,255,0.3), inset 0px 26px 10px 0px rgba(255,255,255,0.08), inset -1px 0px 0 0px rgba(255,255,255,0.3), inset 0px -10px 10px 0px rgba(0,0,0,0.05); box-shadow: inset 1px 1px 0 0px rgba(255,255,255,0.3), inset 0px 26px 10px 0px rgba(255,255,255,0.08), inset -1px 0px 0 0px rgba(255,255,255,0.3), inset 0px -10px 10px 0px rgba(0,0,0,0.05); -webkit-box-sizing: border-box; -moz-box-sizing: border-box; -ms-box-sizing: border-box; box-sizing: border-box; -webkit-transition-duration: 0.4s; -moz-transition-duration: 0.4s; -o-transition-duration: 0.4s; -ms-transition-duration: 0.4s; }
.thirdbutton:hover { letter-spacing: 1px; color: #ffffff; text-shadow: 0px 1px 0px rgba(0,0,0,0.15); border: 1px solid #000; background: #793a89; box-shadow: 0px 0px #111111; -webkit-box-shadow: 0px 0px #111111; -moz-box-shadow: 0px 0px #111111; -ms-box-shadow: 0px 0px #111111; -o-box-shadow: 0px 0px #111111; -webkit-box-shadow: inset 1px 1px 0 0px rgba(255,255,255,0.5), inset 0px 10px 10px 0px rgba(255,255,255,0.05), inset -1px 0px 0 0px rgba(255,255,255,0.5), inset 0px -10px 10px 0px rgba(0,0,0,0.05); -moz-box-shadow: inset 1px 1px 0 0px rgba(255,255,255,0.5), inset 0px 10px 10px 0px rgba(255,255,255,0.05), inset -1px 0px 0 0px rgba(255,255,255,0.5), inset 0px -10px 10px 0px rgba(0,0,0,0.05); box-shadow: inset 1px 1px 0 0px rgba(255,255,255,0.5), inset 0px 10px 10px 0px rgba(255,255,255,0.05), inset -1px 0px 0 0px rgba(255,255,255,0.5), inset 0px -10px 10px 0px rgba(0,0,0,0.05); -webkit-box-sizing: border-box; -moz-box-sizing: border-box; -ms-box-sizing: border-box; box-sizing: border-box; -webkit-transition-duration: 0.4s; -moz-transition-duration: 0.4s; -o-transition-duration: 0.4s; -ms-transition-duration: 0.4s; }
.fourthbutton { display: block; text-align: center; letter-spacing: 1px; font-size: 12px; font-size: 1.2rem; font-weight: 300; border-radius: 4px; width: 100%; padding: 15px 5px; border: 1px solid #949494; color: #ffffff; text-shadow: 0px 1px 0px rgba(0,0,0,0.15); background: #b8b8b8; margin-top: 15px; -webkit-box-shadow: inset 1px 1px 0 0px rgba(255,255,255,0.3), inset 0px 26px 10px 0px rgba(255,255,255,0.08), inset -1px 0px 0 0px rgba(255,255,255,0.3), inset 0px -10px 10px 0px rgba(0,0,0,0.05); -moz-box-shadow: inset 1px 1px 0 0px rgba(255,255,255,0.3), inset 0px 26px 10px 0px rgba(255,255,255,0.08), inset -1px 0px 0 0px rgba(255,255,255,0.3), inset 0px -10px 10px 0px rgba(0,0,0,0.05); box-shadow: inset 1px 1px 0 0px rgba(255,255,255,0.3), inset 0px 26px 10px 0px rgba(255,255,255,0.08), inset -1px 0px 0 0px rgba(255,255,255,0.3), inset 0px -10px 10px 0px rgba(0,0,0,0.05); -webkit-box-sizing: border-box; -moz-box-sizing: border-box; -ms-box-sizing: border-box; box-sizing: border-box; -webkit-transition-duration: 0.4s; -moz-transition-duration: 0.4s; -o-transition-duration: 0.4s; -ms-transition-duration: 0.4s; }
.fourthbutton:hover { letter-spacing: 1px; color: #ffffff; text-shadow: 0px 1px 0px rgba(0,0,0,0.15); border: 1px solid #000; background: #793a89; box-shadow: 0px 0px #111111; -webkit-box-shadow: 0px 0px #111111; -moz-box-shadow: 0px 0px #111111; -ms-box-shadow: 0px 0px #111111; -o-box-shadow: 0px 0px #111111; -webkit-box-shadow: inset 1px 1px 0 0px rgba(255,255,255,0.5), inset 0px 10px 10px 0px rgba(255,255,255,0.05), inset -1px 0px 0 0px rgba(255,255,255,0.5), inset 0px -10px 10px 0px rgba(0,0,0,0.05); -moz-box-shadow: inset 1px 1px 0 0px rgba(255,255,255,0.5), inset 0px 10px 10px 0px rgba(255,255,255,0.05), inset -1px 0px 0 0px rgba(255,255,255,0.5), inset 0px -10px 10px 0px rgba(0,0,0,0.05); box-shadow: inset 1px 1px 0 0px rgba(255,255,255,0.5), inset 0px 10px 10px 0px rgba(255,255,255,0.05), inset -1px 0px 0 0px rgba(255,255,255,0.5), inset 0px -10px 10px 0px rgba(0,0,0,0.05); -webkit-box-sizing: border-box; -moz-box-sizing: border-box; -ms-box-sizing: border-box; box-sizing: border-box; -webkit-transition-duration: 0.4s; -moz-transition-duration: 0.4s; -o-transition-duration: 0.4s; -ms-transition-duration: 0.4s; }
<<<<<<< HEAD
=======
form label { text-transform: uppercase; font-size: 11px; color: <?php echo $option['copy_color']; ?>; }
.white .field .text, .white .field .search, .white .field .textarea { -webkit-box-shadow: 0px 0px; box-shadow: 0px 0px; background: <?php echo $option['heading_color']; ?>; padding: 6px 5px; border-radius: 0px; border: 1px solid <?php echo $option['copy_color']; ?>; }
.white .field .text input, .white .field .text input[type="search"], .white form textarea { font-size: 12px !important; font-family: inherit; background-color: <?php echo $option['heading_color']; ?>; letter-spacing: 1.4px; color: <?php echo $option['copy_color']; ?>; }
.submit, .form-submit input { font-family: inherit; cursor: pointer; }
.white .submit, .form-submit input { font-size: 11px; font-size: 1.1rem; margin-top: 15px; border: 0px; color: #ccc; width: 100%; padding: 7px 0px; display: block; text-align: center; background: <?php echo $option['copy_color']; ?>; -webkit-transition-duration: 0.4s; -moz-transition-duration: 0.4s; -o-transition-duration: 0.4s; -ms-transition-duration: 0.4s; }
.white .submit:hover, .form-submit input:hover { color: <?php echo $option['heading_color']; ?>; background: <?php echo $option['highlight_color']; ?>; -webkit-transition-duration: 0.4s; -moz-transition-duration: 0.4s; -o-transition-duration: 0.4s; -ms-transition-duration: 0.4s; }
.black .field .text, .black .field .search, .black .field .textarea { -webkit-box-shadow: 0px 0px; box-shadow: 0px 0px; background: <?php echo $option['heading_color']; ?>; padding: 6px 5px; border-radius: 0px; border: 0px; }
.black .field .text input, .black .field .text input[type="search"], .black form textarea { font-size: 12px !important; font-family: inherit; background-color: <?php echo $option['heading_color']; ?>; letter-spacing: 1.4px; color: <?php echo $option['copy_color']; ?>; }
.black .submit { font-size: 11px; font-size: 1.1rem; border: 0px; color: <?php echo $option['copy_color']; ?>; width: 100%; padding: 7px 0px; display: block; text-align: center; background: <?php echo $option['heading_color']; ?>; -webkit-transition-duration: 0.4s; -moz-transition-duration: 0.4s; -o-transition-duration: 0.4s; -ms-transition-duration: 0.4s; }
.black .submit:hover { color: <?php echo $option['copy_color']; ?>; background: <?php echo $option['highlight_color']; ?>; -webkit-transition-duration: 0.4s; -moz-transition-duration: 0.4s; -o-transition-duration: 0.4s; -ms-transition-duration: 0.4s; }
/*
' BUTTON
*/
.button { letter-spacing: 1px; font-size: 11px; font-size: 1.1rem; margin-top: 15px; border: 0px; color: <?php echo $option['heading_color']; ?>; background: <?php echo $option['copy_color']; ?>; width: 100%; padding: 12px 0px; display: block; text-align: center; box-sizing: border-box; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; -ms-box-sizing: border-box; -o-box-sizing: border-box; -webkit-transition-duration: 0.4s; -moz-transition-duration: 0.4s; -o-transition-duration: 0.4s; -ms-transition-duration: 0.4s; }
.button:hover { letter-spacing: 1px; color: <?php echo $option['heading_color']; ?>; text-shadow: 0px 1px 0px rgba(0,0,0,0.15); background: <?php echo $option['highlight_color']; ?>; box-shadow: 0px 0px <?php echo $option['copy_color']; ?>; -webkit-box-shadow: 0px 0px <?php echo $option['copy_color']; ?>; -moz-box-shadow: 0px 0px <?php echo $option['copy_color']; ?>; -ms-box-shadow: 0px 0px <?php echo $option['copy_color']; ?>; -o-box-shadow: 0px 0px <?php echo $option['copy_color']; ?>; -webkit-transition-duration: 0.4s; -moz-transition-duration: 0.4s; -o-transition-duration: 0.4s; -ms-transition-duration: 0.4s; }
.black .button { letter-spacing: 1px; font-size: 11px; font-size: 1.1rem; margin-top: 15px; border: 0px; color: <?php echo $option['copy_color']; ?>; background: <?php echo $option['heading_color']; ?>; width: 100%; padding: 12px 0px; display: block; text-align: center; box-sizing: border-box; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; -ms-box-sizing: border-box; -o-box-sizing: border-box; -webkit-transition-duration: 0.4s; -moz-transition-duration: 0.4s; -o-transition-duration: 0.4s; -ms-transition-duration: 0.4s; }
.black .button:hover { letter-spacing: 1px; color: <?php echo $option['heading_color']; ?>; text-shadow: 0px 1px 0px rgba(0,0,0,0.15); background: <?php echo $option['highlight_color']; ?>; box-shadow: 0px 0px <?php echo $option['copy_color']; ?>; -webkit-box-shadow: 0px 0px <?php echo $option['copy_color']; ?>; -moz-box-shadow: 0px 0px <?php echo $option['copy_color']; ?>; -ms-box-shadow: 0px 0px <?php echo $option['copy_color']; ?>; -o-box-shadow: 0px 0px <?php echo $option['copy_color']; ?>; -webkit-transition-duration: 0.4s; -moz-transition-duration: 0.4s; -o-transition-duration: 0.4s; -ms-transition-duration: 0.4s; }
.secondbutton { display: block; text-align: center; letter-spacing: 1px; font-size: 12px; font-size: 1.2rem; font-weight: 300; border-radius: 4px; width: 100%; padding: 15px 5px; border: 1px solid #000; color: <?php echo $option['heading_color']; ?>; background: <?php echo $option['copy_color']; ?>; margin-top: 15px; -webkit-box-shadow: inset 1px 1px 0 0px rgba(255,255,255,0.3), inset 0px 26px 10px 0px rgba(255,255,255,0.08), inset -1px 0px 0 0px rgba(255,255,255,0.3), inset 0px -10px 10px 0px rgba(0,0,0,0.05); -moz-box-shadow: inset 1px 1px 0 0px rgba(255,255,255,0.3), inset 0px 26px 10px 0px rgba(255,255,255,0.08), inset -1px 0px 0 0px rgba(255,255,255,0.3), inset 0px -10px 10px 0px rgba(0,0,0,0.05); box-shadow: inset 1px 1px 0 0px rgba(255,255,255,0.3), inset 0px 26px 10px 0px rgba(255,255,255,0.08), inset -1px 0px 0 0px rgba(255,255,255,0.3), inset 0px -10px 10px 0px rgba(0,0,0,0.05); -webkit-box-sizing: border-box; -moz-box-sizing: border-box; -ms-box-sizing: border-box; box-sizing: border-box; -webkit-transition-duration: 0.4s; -moz-transition-duration: 0.4s; -o-transition-duration: 0.4s; -ms-transition-duration: 0.4s; }
.secondbutton:hover { letter-spacing: 1px; color: <?php echo $option['heading_color']; ?>; text-shadow: 0px 1px 0px rgba(0,0,0,0.15); border: 1px solid inherit; background: <?php echo $option['highlight_color']; ?>; box-shadow: 0px 0px <?php echo $option['copy_color']; ?>; -webkit-box-shadow: 0px 0px <?php echo $option['copy_color']; ?>; -moz-box-shadow: 0px 0px <?php echo $option['copy_color']; ?>; -ms-box-shadow: 0px 0px <?php echo $option['copy_color']; ?>; -o-box-shadow: 0px 0px <?php echo $option['copy_color']; ?>; -webkit-box-shadow: inset 1px 1px 0 0px rgba(255,255,255,0.5), inset 0px 10px 10px 0px rgba(255,255,255,0.05), inset -1px 0px 0 0px rgba(255,255,255,0.5), inset 0px -10px 10px 0px rgba(0,0,0,0.05); -moz-box-shadow: inset 1px 1px 0 0px rgba(255,255,255,0.5), inset 0px 10px 10px 0px rgba(255,255,255,0.05), inset -1px 0px 0 0px rgba(255,255,255,0.5), inset 0px -10px 10px 0px rgba(0,0,0,0.05); box-shadow: inset 1px 1px 0 0px rgba(255,255,255,0.5), inset 0px 10px 10px 0px rgba(255,255,255,0.05), inset -1px 0px 0 0px rgba(255,255,255,0.5), inset 0px -10px 10px 0px rgba(0,0,0,0.05); -webkit-box-sizing: border-box; -moz-box-sizing: border-box; -ms-box-sizing: border-box; box-sizing: border-box; -webkit-transition-duration: 0.4s; -moz-transition-duration: 0.4s; -o-transition-duration: 0.4s; -ms-transition-duration: 0.4s; }
.thirdbutton { display: block; text-align: center; letter-spacing: 1px; font-size: 12px; font-size: 1.2rem; font-weight: 400; border-radius: 4px; width: 100%; padding: 15px 5px; border: 1px solid #ffb72c; color: <?php echo $option['heading_color']; ?>; text-shadow: 0px 1px 0px rgba(0,0,0,0.15); background: #ffd34c; margin-top: 15px; -webkit-box-shadow: inset 1px 1px 0 0px rgba(255,255,255,0.3), inset 0px 26px 10px 0px rgba(255,255,255,0.08), inset -1px 0px 0 0px rgba(255,255,255,0.3), inset 0px -10px 10px 0px rgba(0,0,0,0.05); -moz-box-shadow: inset 1px 1px 0 0px rgba(255,255,255,0.3), inset 0px 26px 10px 0px rgba(255,255,255,0.08), inset -1px 0px 0 0px rgba(255,255,255,0.3), inset 0px -10px 10px 0px rgba(0,0,0,0.05); box-shadow: inset 1px 1px 0 0px rgba(255,255,255,0.3), inset 0px 26px 10px 0px rgba(255,255,255,0.08), inset -1px 0px 0 0px rgba(255,255,255,0.3), inset 0px -10px 10px 0px rgba(0,0,0,0.05); -webkit-box-sizing: border-box; -moz-box-sizing: border-box; -ms-box-sizing: border-box; box-sizing: border-box; -webkit-transition-duration: 0.4s; -moz-transition-duration: 0.4s; -o-transition-duration: 0.4s; -ms-transition-duration: 0.4s; }
.thirdbutton:hover { letter-spacing: 1px; color: <?php echo $option['heading_color']; ?>; text-shadow: 0px 1px 0px rgba(0,0,0,0.15); border: 1px solid #000; background: <?php echo $option['highlight_color']; ?>; box-shadow: 0px 0px <?php echo $option['copy_color']; ?>; -webkit-box-shadow: 0px 0px <?php echo $option['copy_color']; ?>; -moz-box-shadow: 0px 0px <?php echo $option['copy_color']; ?>; -ms-box-shadow: 0px 0px <?php echo $option['copy_color']; ?>; -o-box-shadow: 0px 0px <?php echo $option['copy_color']; ?>; -webkit-box-shadow: inset 1px 1px 0 0px rgba(255,255,255,0.5), inset 0px 10px 10px 0px rgba(255,255,255,0.05), inset -1px 0px 0 0px rgba(255,255,255,0.5), inset 0px -10px 10px 0px rgba(0,0,0,0.05); -moz-box-shadow: inset 1px 1px 0 0px rgba(255,255,255,0.5), inset 0px 10px 10px 0px rgba(255,255,255,0.05), inset -1px 0px 0 0px rgba(255,255,255,0.5), inset 0px -10px 10px 0px rgba(0,0,0,0.05); box-shadow: inset 1px 1px 0 0px rgba(255,255,255,0.5), inset 0px 10px 10px 0px rgba(255,255,255,0.05), inset -1px 0px 0 0px rgba(255,255,255,0.5), inset 0px -10px 10px 0px rgba(0,0,0,0.05); -webkit-box-sizing: border-box; -moz-box-sizing: border-box; -ms-box-sizing: border-box; box-sizing: border-box; -webkit-transition-duration: 0.4s; -moz-transition-duration: 0.4s; -o-transition-duration: 0.4s; -ms-transition-duration: 0.4s; }
.fourthbutton { display: block; text-align: center; letter-spacing: 1px; font-size: 12px; font-size: 1.2rem; font-weight: 300; border-radius: 4px; width: 100%; padding: 15px 5px; border: 1px solid #949494; color: <?php echo $option['heading_color']; ?>; text-shadow: 0px 1px 0px rgba(0,0,0,0.15); background: #b8b8b8; margin-top: 15px; -webkit-box-shadow: inset 1px 1px 0 0px rgba(255,255,255,0.3), inset 0px 26px 10px 0px rgba(255,255,255,0.08), inset -1px 0px 0 0px rgba(255,255,255,0.3), inset 0px -10px 10px 0px rgba(0,0,0,0.05); -moz-box-shadow: inset 1px 1px 0 0px rgba(255,255,255,0.3), inset 0px 26px 10px 0px rgba(255,255,255,0.08), inset -1px 0px 0 0px rgba(255,255,255,0.3), inset 0px -10px 10px 0px rgba(0,0,0,0.05); box-shadow: inset 1px 1px 0 0px rgba(255,255,255,0.3), inset 0px 26px 10px 0px rgba(255,255,255,0.08), inset -1px 0px 0 0px rgba(255,255,255,0.3), inset 0px -10px 10px 0px rgba(0,0,0,0.05); -webkit-box-sizing: border-box; -moz-box-sizing: border-box; -ms-box-sizing: border-box; box-sizing: border-box; -webkit-transition-duration: 0.4s; -moz-transition-duration: 0.4s; -o-transition-duration: 0.4s; -ms-transition-duration: 0.4s; }
.fourthbutton:hover { letter-spacing: 1px; color: <?php echo $option['heading_color']; ?>; text-shadow: 0px 1px 0px rgba(0,0,0,0.15); border: 1px solid #000; background: <?php echo $option['highlight_color']; ?>; box-shadow: 0px 0px <?php echo $option['copy_color']; ?>; -webkit-box-shadow: 0px 0px <?php echo $option['copy_color']; ?>; -moz-box-shadow: 0px 0px <?php echo $option['copy_color']; ?>; -ms-box-shadow: 0px 0px <?php echo $option['copy_color']; ?>; -o-box-shadow: 0px 0px <?php echo $option['copy_color']; ?>; -webkit-box-shadow: inset 1px 1px 0 0px rgba(255,255,255,0.5), inset 0px 10px 10px 0px rgba(255,255,255,0.05), inset -1px 0px 0 0px rgba(255,255,255,0.5), inset 0px -10px 10px 0px rgba(0,0,0,0.05); -moz-box-shadow: inset 1px 1px 0 0px rgba(255,255,255,0.5), inset 0px 10px 10px 0px rgba(255,255,255,0.05), inset -1px 0px 0 0px rgba(255,255,255,0.5), inset 0px -10px 10px 0px rgba(0,0,0,0.05); box-shadow: inset 1px 1px 0 0px rgba(255,255,255,0.5), inset 0px 10px 10px 0px rgba(255,255,255,0.05), inset -1px 0px 0 0px rgba(255,255,255,0.5), inset 0px -10px 10px 0px rgba(0,0,0,0.05); -webkit-box-sizing: border-box; -moz-box-sizing: border-box; -ms-box-sizing: border-box; box-sizing: border-box; -webkit-transition-duration: 0.4s; -moz-transition-duration: 0.4s; -o-transition-duration: 0.4s; -ms-transition-duration: 0.4s; }
>>>>>>> master
=======
>>>>>>> 3444288e90b247662206560f83abce370fc36145
.btn a { font-family: inherit; font-weight: 300; font-size: 15px; letter-spacing: 1px; }
.btn a:hover { font-family: inherit; font-weight: 300; font-size: 15px; letter-spacing: 1px; }
/* WORDPRESS STYLES */
a[rel="tag"] { text-transform: uppercase }
footer div.meta ul li { display: inline }
.comment p{ margin:5px 0px; }
#comment-wrap li { list-style: none; }
#commentform h6 {
	padding-bottom: 20px;
}
ul.children {
	padding-left: 10px;
}
.circle {
width: 50px;
height: 50px;
background: rgba(0, 0, 0, 0.65);
border-radius: 50%;
box-sizing: border-box;
margin-left: auto;
margin-right: auto;
display: block;
margin-top: 50px;
text-align: center;
line-height: 47px;
}

.circle .icon-play {
padding-left: 3px;
}

.item:hover .circle a.whitetext{
<<<<<<< HEAD
<<<<<<< HEAD
color:#ffffff !important;
=======
color:<?php echo $option['heading_color']; ?> !important;
>>>>>>> master
=======
color:#ffffff !important;
>>>>>>> 3444288e90b247662206560f83abce370fc36145
}

.item-img {
display: block;
box-sizing: border-box;
position: relative;
}

.item-hover{
display: block;
box-sizing: border-box;
width: 100%;
height: 100%;
background: rgba(255, 255, 255, 0.7);
position: absolute;
top: 0;
<<<<<<< HEAD
<<<<<<< HEAD
border: 1px solid #111111;
=======
border: 1px solid <?php echo $option['copy_color']; ?>;
>>>>>>> master
=======
border: 1px solid #111111;
>>>>>>> 3444288e90b247662206560f83abce370fc36145
opacity:0;
transition-duration: .3s; 
-webkit-transition-duration: .3s; 
-moz-transition-duration: .3s; 
-o-transition-duration: .3s; 
-ms-transition-duration: .3s;
}

.item:hover .item-hover{
opacity:1;
transition-duration: .3s; 
-webkit-transition-duration: .3s; 
-moz-transition-duration: .3s; 
-o-transition-duration: .3s; 
-ms-transition-duration: .3s;
}
.form-submit input { max-width: 120px; }
footer div.three:nth-child(5n){ margin-left: 0; clear: left;}
footer abbr { color: white; }
#searchWrap, #seachWrap input, .field.row input { width: 100%; box-sizing: border-box; -moz-box-sizing: border-box; }
li.cat-item {margin-bottom:3px;}
.scrollableArea div.meta {color: #888;}
footer { color: #fff; }
#searchform .submit { margin-top: 0; }
aside .column:first-child, aside .columns:first-child, aside .alpha{
margin-left: 5px;
}
aside input.alpha { margin-left: 0;}
select { max-width: 100%;}
#calendar_wrap caption {text-align: left;}
.tagcloud a { font-size: 13px; padding: 0 8px; display: inline-block; margin: 0 4px 6px 0; border: 1px solid #e5e5e5; -webkit-box-shadow: 0 1px 0 rgba(50, 50, 50, 0.3); -moz-box-shadow: 0 1px 0 rgba(50, 50, 50, 0.3); box-shadow: 0 1px 0 rgba(50, 50, 50, 0.3); }
aside .tagcloud a { border-color: #333; box-shadow: none;}
aside .tagcloud a:hover { border-color: #111; box-shadow: none;}
.tagcloud a:hover { border-color: #fff }
.white .tweet_list a, .grey .tweet_list a, .greybox .tweet_list a{
<<<<<<< HEAD
<<<<<<< HEAD
color:#793a89;
=======
color:<?php echo $option['highlight_color']; ?>;
>>>>>>> master
=======
color:#793a89;
>>>>>>> 3444288e90b247662206560f83abce370fc36145
}
.three.columns.team { margin-bottom: 15px;}
.three.columns.team:nth-child(4n + 1){ margin-left: 0;}

<<<<<<< HEAD
<<<<<<< HEAD
=======
<?php if( $option['sidebar'] == '0' ) : ?>
aside { display: none !important; }
article.seven.columns.blogpost { width: 100% !important; }
<?php endif; ?>
>>>>>>> master
=======
>>>>>>> 3444288e90b247662206560f83abce370fc36145

@media only screen and (max-width: 960px) {
	body { -webkit-text-size-adjust: none; -ms-text-size-adjust: none; width: 100%; min-width: 0; margin-left: 0; margin-right: 0; padding-left: 0; padding-right: 0; }
	.slideshow { height: auto; }
	}
<<<<<<< HEAD
<<<<<<< HEAD

=======
>>>>>>> master
=======

>>>>>>> 3444288e90b247662206560f83abce370fc36145
<?php echo $option['custom_css']; ?>