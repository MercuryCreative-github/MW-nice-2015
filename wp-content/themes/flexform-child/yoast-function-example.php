<?php 
/**
 * Add custom fields to Yoast SEO analysis
 */

add_filter('wpseo_pre_analysis_post_content', 'add_custom_to_yoast');

function add_custom_to_yoast( $content ) {
	global $post;
	$pid = $post->ID;

	$custom = get_post_custom($pid);
	unset($custom['_yoast_wpseo_focuskw']); // Don't count the keyword in the Yoast field!

	foreach( $custom as $key => $value ) {


		if ( 'agenda_tracks' == get_post_type($pid) ) {
		// Returns true when 'agenda_tracks.php' is being used.

			if($key=='_TMF_presentation_session'){

				$custom_content .= 'Session Title: '.get_the_title($value[0]). '</br>';

			}
			else if($key=='speakers_meta' ||$key=='panelists_meta' ||$key=='collaborators_meta' ||$key=='facilitators_meta' ||$key=='moderators_meta' ){

				$title= substr($key,0,-6);
					foreach (unserialize($value[0]) as $speaker) {
							$custom_content .= $title . ' : ' . get_user_meta($speaker,'first_name',true) . ' ' . get_user_meta($speaker,'last_name',true). '</br>';
					}
			}
			else if($key=='_TMF_presentations_start_date'){

				$custom_content .= 'Presentation Starts: '.date('F j, Y, g:i a',$value[0]). '</br>';

			}
			else if($key=='_TMF_presentations_end_date'){

				$custom_content .= 'Presentation Ends: '.date('F j, Y, g:i a',$value[0]). '</br>';

			}

			else{
			  if (is_array($value)){
			  	$custom_content .= implode ( ',' , $value) . '</br>';
			  }else{
			  	$custom_content .=$value[0]. '</br>';
			  }
			}

		} else if( basename( get_page_template() ) == 'speakers-template.php') {

			// we may need code here

			$blogusers = get_users( 'role=Speaker' );
			// Save user ID to pass on data to Speaker page
			$user_id = esc_html( $user->ID );
			$avatar = get_user_meta($sid, 'image',1);

			foreach ( $blogusers as $user ) {

				$custom_content.= wp_get_attachment_image($user->image) . '<br/>';
				$custom_content.= esc_html( $user->display_name ) . '<br/>';

				// New mapping of user and companies with job role
				// Get companies and job role
				$companyIds = getUserCompanies( esc_html( $user->ID ), true );

				if( (int)$companyIds > 0 ) {
					$jobRole = getUserJobRolesByCompanyId( $user->ID, $companyIds );
					if( empty( $jobRole ) ) {
					 	$jobRole = esc_html( $user->role );
					}
					$custom_content.= esc_html( $jobRole ) . '<br/>';
					$custom_content.= get_the_title( $companyIds );
				}

			}

		} else if( basename( get_page_template() ) == 'homepage.php') {

		 	$custom_content.= '<div class="sec-main-content">
	<div class="section05-title"><h1>THE REVIEWS</h1></div>
	<ul class="reviews">
		<li style="display: list-item;">
			<div class="review-photo"><img src="/wp-content/uploads/2015/02/wolfgang-gentzsch.png"></div>
			<div class="review-content">
				<div class="review-text">“I was very impressed by the large number of IT and business leaders, and many of the presentations have left a permanent impression. The large number of IT celebrities around the world stood out. I can’t wait to come to Nice again next year!”</div>
				<div class="review-name"><img src="/wp-content/uploads/2015/02/icon-reviews.png"><p><strong>Wolfgang Gentzsch</strong><br>CEO, The UberCloud</p></div>
			</div>
		</li>
		<li style="display: none;">
			<div class="review-photo"><img src="/wp-content/uploads/2015/02/ulf_sm.gif"></div>
			<div class="review-content">
				<div class="review-text">"This year at TM Forum Live!, there are more participants than ever from other industries wanting to know what telecom networks can do for them. And that is happening because cloud, mobility and broadband are transforming their businesses.”</div>
				<div class="review-name"><img src="/wp-content/uploads/2015/02/icon-reviews.png"><p><strong>Ulf Ewaldsson</strong><br>SVP and CTO, Ericsson</p></div>
			</div>
		</li>
		<li style="display: none;">
			<div class="review-photo"></div>
			<div class="review-content">
				<div class="review-text">“Congrats on the 2014 event, the thematic was very well received and the event meticulously organized, great feedback from attendees, vendors and industry icons alike. The future looks bright!”</div>
				<div class="review-name"><img src="/wp-content/uploads/2015/02/icon-reviews.png"><p>CIO, Global Digital Service Provider</p></div>
			</div>
		</li>
	</ul>
</div>';

		} 


	}

	if(isset($custom_content)){$content = $content . ' ' . $custom_content;}

	// comment this line to hide results after finishing.
	//var_dump($content);
	return $content;

	remove_filter('wpseo_pre_analysis_post_content', 'add_custom_to_yoast'); // don't let WP execute this twice
}