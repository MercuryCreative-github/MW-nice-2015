<?php
/*
Plugin Name: TMF Testimonials Widget
Version: 0.1
Plugin URI: 
Description: 
Author: 
Author URI: 
*/
defined('ABSPATH') or die("Access to this place is restricted, go home!");

// Creating the widget 
class wpb_widget extends WP_Widget {

	function __construct() {
		parent::__construct(
			// Base ID of your widget
			'wpb_widget', 

			// Widget name will appear in UI
			__('TMF Testimonials', 'wpb_widget_domain'), 

			// Widget description
			array('description' => __('TMF Rotative Testimonials Widget', 'wpb_widget_domain'))
		);
	}

	// Creating widget front-end
	// This is where the action happens
	public function widget($args, $instance) {
		$title = apply_filters('widget_title', $instance['title']);
		$category = apply_filters('widget_category', $instance['category']);
		$testimonials_num = apply_filters('widget_testimonials_num', $instance['testimonials_num']);
		$change_interval = apply_filters('widget_change_interval', $instance['change_interval']);

		$postId = get_the_id();
		$somemeta = get_post_meta($postId);

		$args = array (
			'post_type'			=> 'testimonial',
			'posts_per_page'	=> $testimonials_num,
			'post_status'		=> 'publish',
			'tax_query'			=> array(
				array(
					'taxonomy'	=> 'category-testimonial',
					'field'		=> 'id',
					'terms'		=> $category
				)
			)
		);

		$testimonials_posts = new WP_Query($args);

		if($testimonials_posts->have_posts()) {

			// before and after widget arguments are defined by themes
			echo $args['before_widget'];

			if(!empty($title)) {
				echo $args['before_title'] . $title . $args['after_title'];
			}

			?>
			<div class="textwidget testimonials">
			<?php

			while($testimonials_posts->have_posts()) {

				$testimonials_posts->the_post();
                global $more;
                $more = 0;

                $user_company_name = get_post_meta(get_the_id(), "_TMF_testimonials_company", true);

				?>
				<div class="sidebar-testimonial">
					<blockquote class="text"><?php echo get_the_content(); ?></blockquote>
					<div class="author-photo">
						<div class="photo">
							<?php the_post_thumbnail(array(50,50), array('class'=>'img-rounded')); ?>
						</div>
						<div class="author"><p><?php echo get_the_title(); ?></p><?php echo '<p class="company">'.$user_company_name.'</p>'; ?></div>
					</div>
				</div>

				<?php

			}

			?>
			</div>
			<script>

			jQuery(document).ready(function($) {

				function fadeSidebar() {
				  
					if(!$('.textwidget.testimonials').find('.sidebar-testimonial.shown').length || !$('.textwidget.testimonials').find('.sidebar-testimonial.shown').next().length) {

						$('.textwidget.testimonials')
				    		.find('.sidebar-testimonial.shown')
				    		.removeClass('shown');

						$('.textwidget.testimonials')
				    		.find('.sidebar-testimonial:first')
				    		.addClass('shown');

				    	return;

					}

					$('.textwidget.testimonials')
			    		.find('.sidebar-testimonial.shown')
			    		.removeClass('shown')
			    		.next()
			    		.addClass('shown');

		    	}

		    	setInterval(fadeSidebar, <?php echo $change_interval; ?>);

			});

			</script>
			<?php

		}

		echo $args['after_widget'];
	}
			
	// Widget Backend 
	public function form($instance) {
		if (isset($instance['title'])) {
			$title = $instance['title'];
		}
		else {
			$title = __('New title', 'wpb_widget_domain');
		}

		if (isset($instance['category'])) {
			$category = $instance['category'];
		}
		else {
			$category = -1;
		}

		if (isset($instance['testimonials_num'])) {
			$testimonials_num = $instance['testimonials_num'];
		}
		else {
			$testimonials_num = __('5', 'wpb_widget_domain');
		}

		if (isset($instance['change_interval'])) {
			$change_interval = $instance['change_interval'];
		}
		else {
			$change_interval = __('5000', 'wpb_widget_domain');
		}

		$opts = array(
			'taxonomy'			=> 'category-testimonial',
			'hide_empty'		=> 0,
			'id'				=> $this->get_field_id('category'),
			'name'				=> $this->get_field_name('category'),
			'orderby'			=> 'name',
			'selected'			=> esc_attr($category),
			'hierarchical'		=> true,
			'show_option_none'	=> __('None'),
			'class'				=> 'widefat'
		);

		?>
		
		<!-- Widget admin form -->
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Testimonaial Category:'); ?></label>
			<?php wp_dropdown_categories($opts); ?>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('testimonials_num'); ?>"><?php _e('Testimonaial to load:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('testimonials_num'); ?>" name="<?php echo $this->get_field_name('testimonials_num'); ?>" type="text" value="<?php echo esc_attr($testimonials_num); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('change_interval'); ?>"><?php _e('Testimonial Change Interval (in ms):'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('change_interval'); ?>" name="<?php echo $this->get_field_name('change_interval'); ?>" type="text" value="<?php echo esc_attr($change_interval); ?>" />
		</p>
		<?php 
	}
		
	// Updating widget replacing old instances with new
	public function update($new_instance, $old_instance) {
		$instance = array();
		$instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
		$instance['category'] = (!empty($new_instance['category'])) ? strip_tags($new_instance['category']) : '';
		$instance['testimonials_num'] = (!empty($new_instance['testimonials_num'])) ? strip_tags($new_instance['testimonials_num']) : '';
		$instance['change_interval'] = (!empty($new_instance['change_interval'])) ? strip_tags($new_instance['change_interval']) : '';
		return $instance;
	}
} // Class wpb_widget ends here

// Register and load the widget
function wpb_load_widget() {
	register_widget( 'wpb_widget' );
}
add_action('widgets_init', 'wpb_load_widget');

?>