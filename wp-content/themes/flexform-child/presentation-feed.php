<?php /* Template Name: Presentation Feed */ 
$numposts = 10; // number of posts in feed
/*$posts = query_posts('showposts='.$numposts.'&cat=-1'); // replace the number 1 with the ID of your tumblelog category
$more = 1;*/
$arr = array();
$i=0;
$presentations = array();
if(isset($_GET['id'])){$id=$_GET['id'];}else{
	$args = array(
									'posts_per_page' 	 => -1,
									'orderby'          => 'post_date',
									'order'            => 'DESC',
									'post_type'        => 'agenda_tracks',
									'post_status'      => 'publish'
								);									
	$presentations = get_posts( $args );
	foreach ( $presentations as $presentation ) {
		$session  = '<presentation>';
			$session .= '<name>' . (htmlspecialchars($presentation->post_title)) . '</name>';
			$time= get_field( "time", $presentation->ID );
			$time= explode(':', $time);
			$hour = $time[0];
			$mins = $time[1];
			if ($hour>12) {
				$startTime=($hour-12).':'.$mins.':00 PM';
			} elseif ($hour==12) {
				$startTime=($hour).':'.$mins.':00 PM';
			} else {
				$startTime=($hour).':'.$mins.':00 AM';
			};
			$time02= get_field( "end_time", $presentation->ID );
			$time02= explode(":", $time02);
			$hour = $time02[0];
			$mins = $time02[1];
			if ($hour>12) {
				$endTime=($hour-12).':'.$mins.':00 PM';
			} elseif ($hour==12) {
				$endTime=($hour).':'.$mins.':00 PM';
			} else {
				$endTime=($hour).':'.$mins.':00 AM';
			};
			$filter = '';
			$fieldId = get_field( "day", $presentation->ID );			
			if( !empty( $fieldId ) ) {
				$filter =  get_term_by( 'id', $fieldId[0], 'events_category' );
				if( !empty( $filter ))
					$filter = $filter->name;
			};
			if ($filter == 'Monday') {
				$filter = '12/08/2014';
			}elseif ($filter == 'Tuesday') {
				$filter = '12/09/2014';
			}elseif ($filter == 'Wednesday') {
				$filter = '12/10/2014';
			}elseif ($filter == 'Thursday') {
				$filter = '12/11/2014';
			};
			$session .= '<startTime>' . $filter . ' ' . $startTime . '</startTime>';
			$session .= '<endTime>' . $filter . ' ' . $endTime . '</endTime>';
			$session .= '<description>' . htmlspecialchars( $presentation->post_content ) . '</description>';
			$session .= '<location>' . get_field( "location", $presentation->ID ) . '</location>';
			$field = get_field( "forum", $presentation->ID );
			$fieldId = '';
			if( !empty( $field )) {
				$fieldId = $field->ID;
				$fn = get_the_title( $fieldId );
			}
			$session .= '<sessionTrack>' . $fn . '</sessionTrack>';
			$userArgs = array(	
													'meta_key'     => 'speaker_at',
													'meta_value'   => $presentation->ID,
													'meta_compare' => 'LIKE',
													'fields'       => 'ID',
												);
			$users = get_users( $userArgs );			
			$size = sizeof( $users );
			$session .= '<speakerIds>';
			if( $size > 0 ) {
				for( $i = 0; $i < $size; $i++ )
					$session .= '<item>' . $users[$i] . '</item>';
			}
			$session .= '</speakerIds>';			
			$userArgs = array(	
													'meta_key'     => 'moderator_at',
													'meta_value'   => $presentation->ID,
													'meta_compare' => 'LIKE',
													'fields'       => 'ID',
												);
			$users = get_users( $userArgs );
			
			$size = sizeof( $users );
			$session .= '<moderatorsIds>';
			if( $size > 0 ) {
				for( $i = 0; $i < $size; $i++ )
					$session .= '<item>' . $users[$i] . '</item>';
			}
			$session .= '</moderatorsIds>';
			
			$userArgs = array(	
													'meta_key'     => 'facilitator_at',
													'meta_value'   => $presentation->ID,
													'meta_compare' => 'LIKE',
													'fields'       => 'ID',
												);
			$users = get_users( $userArgs );
			
			$size = sizeof( $users );
			$session .= '<facilitatorsIds>';
			if( $size > 0 ) {
				for( $i = 0; $i < $size; $i++ )
					$session .= '<item>' . $users[$i] . '</item>';
			}
			$session .= '</facilitatorsIds>';
			
			$userArgs = array(	
													'meta_key'     => 'panelist_at',
													'meta_value'   => $presentation->ID,
													'meta_compare' => 'LIKE',
													'fields'       => 'ID',
												);
			$users = get_users( $userArgs );
			
			$size = sizeof( $users );
			$session .= '<panelistsIds>';
			if( $size > 0 ) {
				for( $i = 0; $i < $size; $i++ )
					$session .= '<item>' . $users[$i] . '</item>';
			}
			$session .= '</panelistsIds>';
			
			$userArgs = array(	
													'meta_key'     => 'collaborator_at',
													'meta_value'   => $presentation->ID,
													'meta_compare' => 'LIKE',
													'fields'       => 'ID',
												);
			$users = get_users( $userArgs );
			
			$size = sizeof( $users );
			$session .= '<collaboratorIds>';
			if( $size > 0 ) {
				for( $i = 0; $i < $size; $i++ )
					$session .= '<item>' . $users[$i] . '</item>';
			}
			$session .= '</collaboratorIds>';			
			$session .= '<linkUrls>' . get_permalink( $presentation->ID ) . '</linkUrls>';
			$session .= '<sessionId>' . $presentation->ID . '</sessionId>';
		$session .= '</presentation>';
		array_push($arr,$session);
	}
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
	<?php do_action('rss2_ns'); ?>>
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
	<?php foreach ( $presentations as $presentation ) {echo $arr[$i]; $i++;} ?>
</channel>
</rss>