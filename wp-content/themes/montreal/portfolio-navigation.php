<!--POST NAVIGATION-->
<?php if( is_singular('portfolio') ) : ?>
	<p class="smallfont midpadding portfolio-navigation">
		<?php 
			if ( get_adjacent_post() ){ previous_post_link('%link', __('PREVIOUS PROJECT','montreal')); echo ' &nbsp; / &nbsp; '; }
			if ( get_adjacent_post(false,'',false) ){ next_post_link('%link', __('NEXT PROJECT','montreal')); } 
		?>
	</p>
<?php else : ?>
	<p class="smallfont midpadding portfolio-navigation">
		<?php 
			if ( get_adjacent_post() ){ previous_post_link('%link', __('PREVIOUS POST','montreal')); echo ' &nbsp; / &nbsp; '; }
			if ( get_adjacent_post(false,'',false) ){ next_post_link('%link', __('NEXT POST','montreal')); } 
		?>
	</p>
<?php endif; ?>