<?php /* Template Name: Speakers Feed */ 
$arr = array();
$s=1;
$args = array(
	//'order' => 'ASC',
	'orderby' => 'id',
	'role' => 'speaker',
);

$user_query = new WP_User_Query( $args );
$users = $user_query->results;

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

		foreach( $companyIds as $companyId ) {
			if( (int)$companyId == 0 ) continue;
			$speaker .= '<item>';
			$company = '';

			$company = get_the_title( $companyId );  // cambia , por </br> 

			$speaker .= '<companyId>' . $companyId . '</companyId>';
			$speaker .= '<companyName>' . $company . '</companyName>';
			$speaker .= '<jobRole>' . esc_html( $user->job_role ) . '</jobRole>';

			$speaker .= '</item>';
		}
		$speaker.= '</company>';
		


		$speaker.= '<description>' . htmlspecialchars ($user->biography) . '</description>';
		$speaker.= '<imageurl>' . $user->image . '</imageurl>';
		$speaker.= '<website>' . esc_html( $user->website ) . '</website>';
		$speaker.= '<twitter>' . $user->twitter_alias . '</twitter>';
		$sessionIds = array();

		$speaker_at = get_user_meta( $user->ID, "speaker_at",true);
		$moderator_at = get_user_meta( $user->ID, "moderator_at",true);
		$panelist_at = get_user_meta( $user->ID, "panelist_at",true);
		$collaborator_at = get_user_meta( $user->ID, "collaborator_at",true);
		$facilitator_at = get_user_meta( $user->ID, "facilitator_at",true);

		if(is_array($speaker_at))
		$sessionIds = array_merge($sessionIds,$speaker_at);


		if(is_array($moderator_at))
		$sessionIds = array_merge($sessionIds,$moderator_at);


		if(is_array($panelist_at))
		$sessionIds = array_merge($sessionIds,$panelist_at);


		if(is_array($collaborator_at))
		$sessionIds = array_merge($sessionIds,$collaborator_at);


		if(is_array($facilitator_at))
		$sessionIds = array_merge($sessionIds,$facilitator_at);

		$speaker.= '<SessionIDs>'; 
		
		foreach ($sessionIds as $sesionId) {
			$presentationStatus=get_post_status( $sesionId,true );
			if('publish'==$presentationStatus){$speaker .= '<item>' . $sesionId . '</item>';}
		}
				
		$speaker.= '</SessionIDs>';
		$speaker.= '<id>' . esc_html( $user->ID ) . '</id>' ;
		$speaker.= '<specification>' . esc_html( $user->speaker_attribs[0] ) . '</specification>';
		$speaker.= '<countNumber>' . $s . '</countNumber>';
		$speaker.= '</item>';


		array_push($arr,$speaker);
		//array_push($arr,'<item>'.implode(',',$sessionIds).' - '. $user->first_name.' - '.$s.'</item>');
		$s++;
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
	<language><?php echo substr(get_bloginfo('language'), 0, 2); ?></language>
	<sy:updatePeriod><?php echo apply_filters( 'rss_update_period', 'hourly' ); ?></sy:updatePeriod>
	<sy:updateFrequency><?php echo apply_filters( 'rss_update_frequency', '1' ); ?></sy:updateFrequency>
	<?php do_action('rss2_head'); ?>
	<?php foreach ( $users as $user ) {echo $arr[$i]; $i++;}?>
</channel>
</rss>