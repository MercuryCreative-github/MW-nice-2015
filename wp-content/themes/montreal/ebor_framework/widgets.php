<?php
add_action('widgets_init', 'newsletter_load_widgets');

function newsletter_load_widgets()
{
	register_widget('Newsletter_Widget');
}

class Newsletter_Widget extends WP_Widget {
	
	function Newsletter_Widget()
	{
		$widget_ops = array('classname' => 'newsletter', 'description' => '');

		$control_ops = array('id_base' => 'newsletter-widget');

		$this->WP_Widget('newsletter-widget', 'montreal: Newsletter', $widget_ops, $control_ops);
	}
	
	function widget($args, $instance)
	{
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);

		echo $before_widget;

		if($title) {
			echo  $before_title.$title.$after_title;
		} ?>
		
			<div id="message"></div>
			<form id="newsletter" action="<?php echo get_template_directory_uri(); ?>/email_scripts/newsletter.php" method="post">
				<dl class="field row">
					<dt class="text"><input type="text" id="email" placeholder="<?php _e('Your Email...', 'montreal'); ?>"/></dt>
					<dd class="msg"><span class="caret"></span><?php _e('You filled this out wrong.', 'montreal'); ?></dd>
					</dl>
					<input type="submit" name="Submit" value="Submit" class="submit alpha four columns">
				
			</form>

		<?php echo $after_widget;
	}
	
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;

		$instance['title'] = strip_tags($new_instance['title']);

		return $instance;
	}

	function form($instance)
	{
		$defaults = array('title' => 'Newsletter');
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
	<?php
	}
}
add_action('widgets_init', 'posttab_load_widgets');

function posttab_load_widgets()
{
	register_widget('Tabs_Widget');
}

class Tabs_Widget extends WP_Widget {
	
	function Tabs_Widget()
	{
		$widget_ops = array('classname' => 'tabs', 'description' => '');

		$control_ops = array('id_base' => 'tabs-widget');

		$this->WP_Widget('tabs-widget', 'montreal: Tabs', $widget_ops, $control_ops);
	}
	
	function widget($args, $instance)
	{
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);

		echo $before_widget;

		if($title) {
			echo  $before_title.$title.$after_title;
		} //CONTENT HERE ?>
		
		<div class="tabs">
			<ul class="tab-nav">
				<li class="active"><a href="#tab1"><?php _e('POPULAR', 'montreal'); ?></a></li>
				<li><a href="#tab2"><?php _e('RECENT', 'montreal'); ?></a></li>
			</ul>
			<div class="active tab-content" data-tab="tab1">
				<?php 
				$popularpost = new WP_Query( array( 'posts_per_page' => 3, 'meta_key' => 'wpb_post_views_count', 'orderby' => 'wpb_post_views_count', 'order' => 'DESC'  ) );
				while ( $popularpost->have_posts() ) : $popularpost->the_post(); ?>
				<h6><a href="<?php the_permalink(); ?>" class="blacktext icon-link uppercase"> &nbsp; <?php the_title(); ?></a></h6>
				<?php endwhile; ?>
			</div>
			<div class="tab-content" data-tab="tab2">
				<?php query_posts('post_type=post&posts_per_page=3'); if( have_posts() ) : while( have_posts() ) : the_post(); ?>
				<h6><a href="<?php the_permalink(); ?>" class="blacktext icon-link uppercase"> &nbsp; <?php the_title(); ?></a></h6>
				<?php endwhile; endif; wp_reset_query(); ?>
			</div>
		</div>

		<?php echo $after_widget;
	}
	
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;

		$instance['title'] = strip_tags($new_instance['title']);

		return $instance;
	}

	function form($instance)
	{
		$defaults = array('title' => '');
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
	<?php
	}
}
?>