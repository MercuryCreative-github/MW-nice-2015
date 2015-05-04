<?php /* Template Name: Speakers Feed */ ?>
<?php header('Content-Type: '.feed_content_type('rss-http').'; charset='.get_option('blog_charset'), true);
echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'>';?>
<?php 
$numposts = 10; // number of posts in feed
$posts = query_posts('showposts='.$numposts.'&cat=-1'); // replace the number 1 with the ID of your tumblelog category
$more = 1;
$arr = array();
$i=0;
if(isset($_GET['id'])){$id=$_GET['id'];}else{
	$users = get_users( 'orderby=name&role=speaker'.$id );
	$user_id = esc_html( $user->ID );
	$avatar = get_user_meta($sid, 'image',1);}

	foreach ( $users as $user ) {
		$speaker= '<item>';
		$speaker.= '<title>' . esc_html( $user->first_name ) . ' ' . esc_html( $user->last_name ) . '</title>' ;
		$speaker.= '<first_name>' . esc_html( $user->first_name ) . '</first_name>' ;
		$speaker.= '<last_name>' . esc_html( $user->last_name ) . '</last_name>' ;
		$speaker.= '<job_role>' . esc_html( $user->job_role ) . '</job_role>';

		// Get companies and job role
		$companies = $user->company;
		$companyIds = $companies[0];

		$speaker.= '<company>';

		// Get companies and job role
		$companyIds = getUserCompanies( esc_html( $user->ID ) );
		$jobRole = '';

		$i = 0;
		foreach( $companyIds as $companyId ) {
			if( (int)$companyId == 0 ) continue;
			$speaker .= '<item>';
			$company = '';

			$company = get_the_title( $companyId );  // cambia , por </br> 

			$speaker .= '<companyId>' . $companyId . '</companyId>';
			$speaker .= '<companyName>' . $company . '</companyName>';
			$speaker .= '<jobRole>' . esc_html( $user->job_role ) . '</jobRole>';

			$i++;
			$speaker .= '</item>';
		}
		$speaker.= '</company>';
		
		$speaker.= '<description>' . htmlspecialchars ($user->biography) . '</description>';
		$speaker.= '<imageurl>' . wp_get_attachment_image($user->image) . '</imageurl>';
		$speaker.= '<website>' . esc_html( $user->website ) . '</website>';
		$speaker.= '<twitter>' . $user->twitter_alias . '</twitter>';
		$sessionIds = get_user_meta( $user->ID, "speaker_at" );
		$speaker.= '<SessionIDs>'; // Kushal put the IDs here
			if( !empty( $sessionIds ) ) {
				$ids = $sessionIds[0];
				$size = sizeof( $ids );
				for( $i = 0; $i < $size; $i++ ) {
					$speaker .= '<item>' . $ids[$i] . '</item>';
				}
			}
		$speaker .= '</SessionIDs>';
		$speaker.= '<id>' . esc_html( $user->ID ) . '</id>' ;
    $speaker.= '<specification>' . esc_html( $user->speaker_attribs[0] ) . '</specification>';
		$speaker.= '</item>';
		array_push($arr,$speaker);
	}
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
	<language><?php echo substr(get_bloginfo('language'), 0, 2); ?></language>
	<sy:updatePeriod><?php echo apply_filters( 'rss_update_period', 'hourly' ); ?></sy:updatePeriod>
	<sy:updateFrequency><?php echo apply_filters( 'rss_update_frequency', '1' ); ?></sy:updateFrequency>
	<?php do_action('rss2_head'); ?>
	<?php
	foreach ( $users as $user ) {echo $arr[$i]; $i++;}?>
</channel>
</rss>