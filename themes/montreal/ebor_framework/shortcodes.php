<?php

//TESTIMONIAls
function montreal_testimonials( $atts, $content = null ) {
extract(shortcode_atts(array(
	'title' => ''
), $atts));	
	ob_start();
		testimonial($title);
			$output_string = ob_get_contents();
		ob_end_clean();
	return $output_string;
}
add_shortcode('testimonials', 'montreal_testimonials');

//CLIENTS
function montreal_clients( $atts, $content = null ) {
extract(shortcode_atts(array(
	'title' => ''
), $atts));	
	ob_start();
		clients($title);
			$output_string = ob_get_contents();
		ob_end_clean();
	return $output_string;
}
add_shortcode('clients', 'montreal_clients');

//TEAM MEMBERS
function montreal_team_members( $atts, $content = null ) {
extract(shortcode_atts(array(
	'title' => ''
), $atts));	
	ob_start();
		team($title);
			$output_string = ob_get_contents();
		ob_end_clean();
	return $output_string;
}
add_shortcode('team_members', 'montreal_team_members');

//BLOCKQUOTE
function montreal_blockquote( $atts, $content = null ) {
   return '<blockquote>' . do_shortcode($content) . '</blockquote>';
}
add_shortcode('blockquote', 'montreal_blockquote');

//LARGEFONT
function montreal_largefont( $atts, $content = null ) {
   return '<div class="largefont">' . do_shortcode($content) . '</div>';
}
add_shortcode('largefont', 'montreal_largefont');

//METAFONT
function montreal_metafont( $atts, $content = null ) {
   return '<div class="meta">' . do_shortcode($content) . '</div>';
}
add_shortcode('metafont', 'montreal_metafont');

//SMALLFONT
function montreal_smallfont( $atts, $content = null ) {
   return '<div class="smallfont">' . do_shortcode($content) . '</div>';
}
add_shortcode('smallfont', 'montreal_smallfont');

//DRAWER
function montreal_drawer( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'title' => '',
		'instructions' => ''
	), $atts));	
	$drawer_id = wp_rand(0,10000);
   return '<section class="row">
   		<h5 class="blacktext extrabold midbottommargin">' . $title . '</h5>
   		<a href="#" onClick="return false" class="toggle greytext meta smallbottompadding" gumby-trigger=".' . $drawer_id . '">' . $instructions . '</a>
   	<section class="' . $drawer_id . ' drawer">
   		<div class="container black">
   			<div class="row">
   				<h3 class="whitetext center">' . $content . '</h3>
   			</div>
   		</div>
   	</section>
   </section>
   ';
}
add_shortcode('drawer', 'montreal_drawer');

//FANCY_HEADLINE
function montreal_fancy_headline( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'center' => '',
	), $atts));
	if($center == 'yes'){$center = 'center';}
   return '<h5 class="blacktext extrabold midbottommargin uppercase ' . $center . '">' . do_shortcode($content) . '</h5>';
}
add_shortcode('fancy_headline', 'montreal_fancy_headline');

//FANCY LIST
function montreal_fancy_list( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'type' => '',
	), $atts));
   return '<div class="smallfont leftpadding fancylist ' . $type . '">' . do_shortcode($content) . '</div>';
}
add_shortcode('fancy_list', 'montreal_fancy_list');

//DROPCAP
function montreal_dropcap( $atts, $content = null ) {
   return '<p class="dropcaps">' . do_shortcode($content) . '</p>';
}
add_shortcode('dropcap', 'montreal_dropcap');

//FANCY LINK
function montreal_fancy_link( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'link' => ''
    ), $atts));	
	$button ='';
	$button .= '<p class="icon-link smallsidepadding blacktext">
		<a href="' . $link . '" class="blacktext meta">&nbsp; ';
	$button .= $content;
	$button .= '</a></p>';
	return $button;
}
add_shortcode('fancy_link', 'montreal_fancy_link');

//FULL WIDTH
function montreal_full_width( $atts, $content = null ) {
   return '<div class="codecolumn twelve columns alpha">' . do_shortcode($content) . '</div>';
}
add_shortcode('full_width', 'montreal_full_width');

//CENTERED COLUMN
function montreal_centered_column( $atts, $content = null ) {
   return '<div class="codecolumn eight columns alpha center centered">' . do_shortcode($content) . '</div>';
}
add_shortcode('centered_column', 'montreal_centered_column');

//ONE HALF
function montreal_one_half( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'first' => ''
	), $atts));	
	if($first == 'yes'){ $first = 'alpha'; }
   return '<div class="codecolumn six columns ' . $first . '">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_half', 'montreal_one_half');

//ONE THIRD
function montreal_one_third( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'first' => ''
	), $atts));	
	if($first == 'yes'){ $first = 'alpha'; }
   return '<div class="codecolumn four columns ' .  $first . '">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_third', 'montreal_one_third');

//ONE QUARTER
function montreal_one_quarter( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'first' => ''
	), $atts));	
	if($first == 'yes'){ $first = 'alpha'; }
   return '<div class="codecolumn three columns ' . $first . '">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_quarter', 'montreal_one_quarter');

//THREE QUARTERS
function montreal_three_quarters( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'first' => ''
	), $atts));	
	if($first == 'yes'){ $first = 'alpha'; }
   return '<div class="codecolumn nine columns ' . $first . '">' . do_shortcode($content) . '</div>';
}
add_shortcode('three_quarters', 'montreal_three_quarters');

//TWO THIRDS
function montreal_two_thirds( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'first' => ''
	), $atts));	
	if($first == 'yes'){ $first = 'alpha'; }
   return '<div class="codecolumn eight columns ' . $first . '">' . do_shortcode($content) . '</div>';
}
add_shortcode('two_thirds', 'montreal_two_thirds');

//BUTTONS
function montreal_button( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'link' => '',
		'type' => ''
    ), $atts));	
	return '<a href="' . $link . '" class="' . $type . '">' . $content . '</a>';
}
add_shortcode('button', 'montreal_button');

//big_button
function montreal_big_button( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'link' => '',
		'type' => '',
		'margin' => ''
    ), $atts));	
	return '<div class="three columns ' . $margin . ' btn ' . $type . '"><a href="' . $link . '">' . $content . '</a></div>';
}
add_shortcode('big_button', 'montreal_big_button');


//TABS
add_shortcode( 'tabgroup', 'montreal_tabgroup' );

function montreal_tabgroup( $atts, $content ){
extract(shortcode_atts(array(
	'title' => ''
), $atts));
	
$GLOBALS['tab_count'] = 0;
do_shortcode( $content );

if( is_array( $GLOBALS['tabs'] ) ){
	
foreach( $GLOBALS['tabs'] as $tab ){
$tabs[] = '<li class="' . $tab['active'] . '"><a href="#'.$tab['id'].'">'.$tab['title'].'</a></li>';
$panes[] = '<div class="tab-content ' . $tab['active'] . '"><p>'.$tab['content'].'</p></div>';
}
$return = "\n".'<section class="row bigpadding"><h5 class="blacktext extrabold midbottommargin">' . $title . '</h5><div class="tabs"><ul class="tab-nav">'.implode( "\n", $tabs ).'</ul>'."\n".'<!-- tab "panes" -->'.implode( "\n", $panes ).'</div></section>'."\n";
}
return $return;

}

add_shortcode( 'tab', 'montreal_tab' );
function montreal_tab( $atts, $content ){
extract(shortcode_atts(array(
	'title' => '%d',
	'id' => '%d',
	'active' => ''
), $atts));

$x = $GLOBALS['tab_count'];
$GLOBALS['tabs'][$x] = array(
	'title' => sprintf( $title, $GLOBALS['tab_count'] ),
	'content' =>  do_shortcode($content),
	'id' =>  $id,
	'active' => $active );

$GLOBALS['tab_count']++;
}


//CLEAR
function montreal_break( $atts, $content = null ) {
	return '<div class="clearfix"></div>';
}
add_shortcode('clear', 'montreal_break');

//BIG_CLEAR
function montreal_big_clear( $atts, $content = null ) {
	return '<div class="clearfix bigtoppadding"></div>';
}
add_shortcode('big_clear', 'montreal_big_clear');

//CLEAR
function montreal_clearline( $atts, $content = null ) {
	return '<div class="row midmargin blackhorizontal">
			</div>';
}
add_shortcode('clearline', 'montreal_clearline');

?>