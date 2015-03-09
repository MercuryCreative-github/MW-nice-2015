			function setSponsors($forums,$event_hours) {

				foreach ( $event_hours as $session ) {

					$args = array(
					    'post_type' => 'companies',
					    'order' => 'ASC',
					    'meta_query' => array(
					        array(
					            'key' => 'sponsoredsession',
					            'value' => $forums,
								'compare' => 'LIKE'
					        )
					    )
					);



					$loop = new WP_Query($args);

					echo count($loop);


					while ($loop->have_posts()) : $loop->the_post();

						$thumb_id = get_post_thumbnail_id();
						$thumb_url = wp_get_attachment_image_src($thumb_id,'thumbnail-size', true);
						$img= $thumb_url[0];

						echo $forums;

						$startHour=explode(':',$session->start);

						echo '<img class="imgMove" day="'.$session->category.'" starthour="'.$startHour[0].'.'.$startHour[1].'" endhour="'.$session->end.'" src="'.$img.'">';

					endwhile;

					wp_reset_postdata();
				}

			}



			foreach ($sessionsTocall as $forums) {
					setSponsors($forums,$event_hours);
					
							
			}