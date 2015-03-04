<?php /* Template Name: Full Feed */ 
$numposts = 10; // number of posts in feed
$posts = query_posts('showposts='.$numposts.'&cat=-1'); // replace the number 1 with the ID of your tumblelog category
$more = 1;
$arr = array();
$i=0;

function callPresentations($userId,$user,$day){
// The Vars to run the Query that gets all the Agenda Tracks (presentations) with the speaker asociated
$args = array(
	'post_type' => 'agenda_tracks',
	'meta_key' => 'day', // para ordenar por dia asc primero defino meta_key
  'orderby'   => 'meta_value', // luego el order orderby
	'order' => 'ASC', // finalmente si es asc o desc
	'meta_query' =>array(
		array('value' => $userId,'compare' => 'LIKE'), // en algun meta tiene el ID de este usuario (speaker, moderator, facilitator, panelist)
		array('key' =>'day','compare' => 'EXISTS'), // existe el "day"
	),// meta_query
); // args

$loop = new WP_Query( $args );

$presentations='';

while ( $loop->have_posts() ) : $loop->the_post();

// get the selected day
$day=get_field('day');
$dayAtt='';
$speakersDisplay='';
$moderatorsDisplay='';
$panelistsDisplay='';
$daytag='';
$time='';
$hour='';
$mins='';
$displayTime='';
$subtitle='';
$content='';

for($j=0;$j<count($day);$j++){
	$dayAtt = $day[$j];
	$term = get_term_by('id', $dayAtt,'events_category');
	$daytag.= ($term -> slug);
}

$forumLink = get_permalink( get_field('forum') );
$forum = '<a href="'.$forumLink.'">'.get_the_title( get_field('forum') ).'</a>';

$time= get_field('time');
$time= split(":", $time);
$hour = $time[0];
$mins = $time[1];
$time=$hour.'.'.$mins;
if($hour>12){$displayTime=($hour-12).':'.$mins.' PM';}
else{$displayTime=($hour).':'.$mins.' AM';};

if($daytag=='monday'){$dnumber='08';}
else if($daytag=='tuesday'){$dnumber='09';}
else if($daytag=='wednesday'){$dnumber='10';}
else if($daytag=='thursday'){$dnumber='11';}
else {$dnumber='';}

// define subtitle
$subtitle= get_field('sub_title').' - ';
if($subtitle==' - '){$subtitle='';}
$content = apply_filters( 'the_content', get_the_content() );
$content = str_replace( ']]>', ']]&gt;', $content );
$linkToForum = get_permalink();

$presentations.='<schedule>';
$presentations.='<linkforum>'.$linkToForum.'</linkforum>';
$presentations.='<title><![CDATA['.get_the_title().']]></title>';
$presentations.='<subtitle><![CDATA['.$subtitle.']]></subtitle><daytag><![CDATA['.$daytag.']]></daytag><displayTime><![CDATA['.$displayTime.']]></displayTime>';
$presentations.= '<content><![CDATA['.$content . ']]></content><forum><![CDATA['.$forum.']]></forum></schedule>';

endwhile;

// Reset Post Data
wp_reset_postdata();

if($presentations!=='<div class="wpb_wrapper clearfix"><h2>' . esc_html( $user->display_name ) . '&#39;s schedule</h2></div>'){return $presentations;}
return '';
}

if(isset($_GET['id'])){$id=$_GET['id'];}else{
	$users = get_users( 'orderby=name&role=speaker'.$id );
	$user_id = esc_html( $user->ID );
	$avatar = get_user_meta($sid, 'image',1);}

	foreach ( $users as $user ) {
		$speaker= '<speaker>';
		$speaker.= '<id>' . esc_html( $user->ID ) . '</id>' ;
		$speaker.= '<diplayName>' . esc_html( $user->display_name ) . '</diplayName>' ;
		$speaker.= '<thumb>' . wp_get_attachment_image($user->image) . '</thumb>';
		$speaker.= '<span class="name">' . esc_html( $user->display_name ) . '</span>';
		$speaker.= '<role>' . esc_html( $user->role ) . '</role>';
		$speaker.= '<twitter>' . $user->twitter_alias . '</twitter>';

		$speaker.= '<company>' . get_the_title($user->company[0]) . '</company>';

		$companyId = $user->company[0];
		$companyObj = get_post($companyId);
		$companyTitle = $companyObj->post_title;
		$companyURL = $companyObj->url;
		$companyThumb = get_the_post_thumbnail($companyId, 'medium');

		$speaker.= '<companyUrl>' . $companyURL . '</companyUrl>';
		$speaker.= '<companyLogo>' . $companyThumb . '</companyLogo>';


     	$speaker.= '<specification>' . esc_html( $user->speaker_attribs[0] ) . '</specification>';
		
		$speaker.= callPresentations($user->ID,$user,'monday');
		$speaker.= '</speaker>';
		array_push($arr,$speaker);

		
	} 





header('Content-Type: '.feed_content_type('rss-http').'; charset='.get_option('blog_charset'), true);
echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'>';
?>

<rss version="2.0"
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:wfw="http://wellformedweb.org/CommentAPI/"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:atom="http://www.w3.org/2005/Atom"
	xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
	xmlns:slash="http://purl.org/rss/1.0/modules/slash/"
	<?php do_action('rss2_ns'); ?>
>
<channel>
	<title><?php bloginfo_rss('name'); wp_title_rss(); ?> - Article Feed</title>
	<atom:link href="<?php self_link(); ?>" rel="self" type="application/rss+xml" />
	<link><?php bloginfo_rss('url') ?></link>
	<description><?php bloginfo_rss("description") ?></description>
	<lastBuildDate><?php echo mysql2date('D, d M Y H:i:s +0000', get_lastpostmodified('GMT'), false); ?></lastBuildDate>
	<?php the_generator( 'rss2' ); ?>
	<language><?php echo get_option('rss_language'); ?></language>
	<sy:updatePeriod><?php echo apply_filters( 'rss_update_period', 'hourly' ); ?></sy:updatePeriod>
	<sy:updateFrequency><?php echo apply_filters( 'rss_update_frequency', '1' ); ?></sy:updateFrequency>
	<?php do_action('rss2_head'); ?>
	<?php

	foreach ( $users as $user ) {
echo $arr[$i]; 
$i++;

	}
	

	
	  ?>

</channel>
</rss>