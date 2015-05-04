<?php /* Template Name: Presentation Feed */ 
$arr = array();
$i=0;
$presentations = array();
if(isset($_GET['id'])){$id=$_GET['id'];}else{
	$args = array(
		'posts_per_page'   => -1,
		'orderby'          => 'meta_value',
		'order'            => 'DESC',
		'post_type'        => 'agenda_tracks',
		'post_status'      => 'publish',
	);			
	$presentations = get_posts( $args );
	foreach ( $presentations as $presentation ) {
		$session  = '<item>';
			$session .= '<title>' . (htmlspecialchars($presentation->post_title)) . '</title>';
			$presentationId=$presentation->ID; 
			$date=date('Y-m-d H:i:s',get_post_meta($presentationId,'_TMF_presentations_start_date',true));
			$startTime=date('g:i a',get_post_meta($presentationId,'_TMF_presentations_start_date',true));
			$endTime=date('g:i a',get_post_meta($presentationId,'_TMF_presentations_end_date',true));
			$session .= '<date>' . $date . ' +0200</date>';
			$session .= '<startTime>' . $startTime . '</startTime>';
			$session .= '<endTime>' . $endTime . '</endTime>';
			$session .= '<description>' . htmlspecialchars( $presentation->post_content ) . '</description>';
			$location = get_post_meta($presentationId,'_TMF_presentations_location',true);
			$session .= '<location>' . $location . '</location>';
			$field = get_field( "forum", $presentation->ID );
			$fieldId = '';
			if( !empty( $field )) {
				$fieldId = $field->ID;
				$fn = get_the_title( $fieldId );
			}
			$sessionId = get_post_meta($presentation->ID, '_TMF_presentation_session', true);
			$summits = get_the_terms($sessionId, 'tmf_summit_category' );
			if(is_array($summits))
			foreach ($summits as $summitTitle) {$session .= '<sessionTrack>' . ( $summitTitle->name ) . '</sessionTrack>';}
			$args = array(
				'role'=>'speaker',
				'meta_query' =>array(array('value' => $presentationId ,'compare' => 'LIKE'),)
				);// meta_query);

			add_action( 'pre_user_query', function( $user_query ) {
				$user_query->query_fields = 'DISTINCT ' . $user_query->query_fields;
			} );
			// The Query
			$user_query = new WP_User_Query( $args );
			// User Loop
			if ( ! empty( $user_query->results ) ) {
				foreach ( $user_query->results as $user ) {
					$SpeakerRole = '<item>'. $user->first_name.' '.$user->last_name . '</item>';	
					if(($user->speaker_at))
					if (in_array($presentationId, $user->speaker_at)) {
						$session .= '<speakerIds>';
						$session .= $SpeakerRole;
						$session .= '</speakerIds>';
					}
					if(($user->moderator_at))
					if (in_array($presentationId, $user->moderator_at)) {
						$session .= '<moderatorIds>';
						$session .= $SpeakerRole;
						$session .= '</moderatorIds>';
					}
					if(($user->panelist_at))
					if (in_array($presentationId, $user->panelist_at)) {
						$session .= '<panelistIds>';
						$session .= $SpeakerRole;
						$session .= '</panelistIds>';
					}
					if(($user->facilitator_at))
					if (in_array($presentationId, $user->facilitator_at)) {
						$session .= '<facilitatorIds>';
						$session .= $SpeakerRole;
						$session .= '</facilitatorIds>';
					}
					if(($user->collaborator_at))
					if (in_array($presentationId, $user->collaborator_at)) {
						$session .= '<collaboratorIds>';
						$session .= $SpeakerRole;
						$session .= '</collaboratorIds>';
					}
				} //close foreach
			} //close if
			$session .= '<linkUrls>' . get_permalink( $presentation->ID ) . '</linkUrls>';
			$session .= '<sessionId>' . $presentation->ID . '</sessionId>';
		$session .= '</item>';
		array_push($arr,$session);
	};
};
header('Content-Type: '.feed_content_type('rss-http').'; charset='.get_option('blog_charset'), true);
echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'>';
?>
<rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/" 
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
	<language><?php echo substr(get_bloginfo('language'), 0, 2); ?></language>
	<sy:updatePeriod><?php echo apply_filters( 'rss_update_period', 'hourly' ); ?></sy:updatePeriod>
	<sy:updateFrequency><?php echo apply_filters( 'rss_update_frequency', '1' ); ?></sy:updateFrequency>
	<?php do_action('rss2_head'); ?>
	<?php foreach ( $presentations as $presentation ) {echo $arr[$i]; $i++;} ?>
</channel>
</rss>