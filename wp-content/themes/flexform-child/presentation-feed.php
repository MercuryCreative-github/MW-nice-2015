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
			$startTime=date('g:i a',get_post_meta($presentationId,'_TMF_presentations_start_date',true));
			$endTime=date('g:i a',get_post_meta($presentationId,'_TMF_presentations_end_date',true));

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