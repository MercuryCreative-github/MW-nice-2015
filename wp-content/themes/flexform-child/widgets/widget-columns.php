<?php
/**
 * Plugin Name: Columns Widget
 */

add_action( 'widgets_init', 'mvp_columns_load_widgets' );

function mvp_columns_load_widgets() {
	register_widget( 'mvp_columns_widget' );
}

class mvp_columns_widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function mvp_columns_widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'mvp_columns_widget', 'description' => __('A widget that displays posts in two columns (in one column in the sidebar or footer) from a category of your choice.', 'mvp_columns_widget') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'mvp_columns_widget' );

		/* Create the widget. */
		$this->WP_Widget( 'mvp_columns_widget', __('Braxton: Columns Widget', 'mvp_columns_widget'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$categories = $instance['categories'];
		$number = $instance['number'];

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;

		?>

<div>

<?php

    // Get the URL of this category
    $category_link = get_category_link( $categories );

	if(function_exists('cc_get_color')) { $category_color = cc_get_color($categories);} 
	if($category_color=='default'){$category_color='66AAD7';}


?>





<!-- Print a link to this category -->
<div class="view-all-widget">
<a href="<?php echo esc_url( $category_link ); ?>"  style="background-color: #<? echo $category_color ?>">VIEW ALL</a>
</div>

</div>



<style>  

.cat-<? echo $categories ?> .home-view-more, .cat-<? echo $categories ?> .home-view-more a,
.home-widget ul.home-list.cat-<? echo $categories ?> li:hover h2,
.sidebar-widget ul.home-list.cat-<? echo $categories ?> li:hover h2,
ul.split-columns.cat-<? echo $categories ?> li:hover h2,	
.cat-<? echo $categories ?> span.widget-info{
    color:#<? echo $category_color ?>!important;
  
}

</style>



<ul class="split-columns cat-<? echo $categories ?>"  style="border-top-color: red; border-top: 4px solid #<? echo $category_color ?>">
						<?php $recent = new WP_Query(array( 'cat' => $categories, 'posts_per_page' => $number )); while($recent->have_posts()) : $recent->the_post();?>
						<li>

						
								<?php 

								// not using this but could be helpful... 
								$tag_name  = array();

								$posttags = get_the_tags();
								if ($posttags) {
								  foreach($posttags as $tag) {
								    array_push($tag_name, $tag->name);
								  }
								}
								


								 ?>


								

								
                            <div  class="topic-box"><?php $category = get_the_category(); $last_category = end($category); echo $last_category->cat_name; ?></div>
                            <div class="s-box">
                                	<div class="s-box-items">
                                	    <div class="social-home"><img src="/wp-content/themes/braxton/images/social.png" width="21" height="33" /></div>
 										<ul class="social-ul">
				                            <li><script>[CBC country="cn" show="n"]</script><a href="http://www.facebook.com/share.php?u=<?php the_permalink(); ?>&t=<?php the_title(); ?>" target="_blank"><script>[/CBC]</script><img src="/wp-content/themes/braxton/images/fb.png" width="10" height="23" /><script>[CBC country="cn" show="n"]</script></a><script>[/CBC]</script></li>
				                            <li><script>[CBC country="cn" show="n"]</script><a href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode(get_permalink($post->ID)); ?>&title=<?php the_title(); ?>&source=<?php echo urlencode(get_permalink($post->ID)); ?>" target="_blank"><script>[/CBC]</script><img src="/wp-content/themes/braxton/images/linkedin.png" /><script>[CBC country="cn" show="n"]</script></a><script>[/CBC]</script></li>
				                            <li><script>[CBC country="cn" show="n"]</script><a href="http://twitter.com/home?status=<?php the_title(); ?> in <?php the_permalink(); ?>+%23tmforuminform+%23tmforumorg" target="_blank"><script>[/CBC]</script><img src="/wp-content/themes/braxton/images/tw.png" width="19" height="23" /><script>[CBC country="cn" show="n"]</script></a><script>[/CBC]</script></li>
				                            <li><script>[CBC country="cn" show="n"]</script><a href="https://plus.google.com/share?url=<?php the_title(); ?> in <?php the_permalink(); ?>+%23tmforuminform+%23tmforumorg" target="_blank" ><script>[/CBC]</script><img src="/wp-content/themes/braxton/images/gmas.png" width="22" height="23" /><script>[CBC country="cn" show="n"]</script></a><script>[/CBC]</script></li>
				                        </ul>
				                    </div>
				                </div>
<div style="clear:both"></div>
                         <?php if (in_category( 'news' ) ) {?> <a href="/category/news/#<?php the_ID(); ?>  "><div class="split-text noImg"><?php } 
                               else{ ?> <a href="<?php the_permalink(); ?>" rel="bookmark"> 
							   
							   <?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { ?>
									<div class="split-img"><?php the_post_thumbnail('thumbnail'); ?></div><!--split-img-->
									<div class="split-text">
						  		<?php } else{ ?><div class="split-text noImg"><?php } ?>
							   
							   
							   <?php } ?>  

						 		
							
								<span class="widget-info"><?php the_time(get_option('date_format')); ?></span>
								<h2><?php the_title(); ?></h2>
								<p><?php echo excerpt(20); ?></p>
                                 <div class="clear"></div>
                                

                                <?php if (!in_category( 'news' ) ) {?>

                                 
                                <div class="home-view-more">
                                	<a href="<?php the_permalink(); ?>" rel="bookmark">
                                	<img src="/wp-content/themes/braxton/images/arrow-more.png" />VIEW MORE
                                	</a>
                                </div>
                                <div class="clear"></div>

                                <?php } ?> 



							</div><!--split-text-->
							</a>
                              <div class="line-bot"></div>
						</li>
						<?php endwhile; ?>
					</ul>


		<?php

		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['categories'] = $new_instance['categories'];
		$instance['number'] = strip_tags( $new_instance['number'] );


		return $instance;
	}


	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => 'Title', 'links' => 'on', 'number' => 4);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:90%;" />
		</p>

		<!-- Category -->
		<p>
			<label for="<?php echo $this->get_field_id('categories'); ?>">Select category:</label>
			<select id="<?php echo $this->get_field_id('categories'); ?>" name="<?php echo $this->get_field_name('categories'); ?>" style="width:100%;">
				<option value='all' <?php if ('all' == $instance['categories']) echo 'selected="selected"'; ?>>All Categories</option>
				<?php $categories = get_categories('hide_empty=0&depth=1&type=post'); ?>
				<?php foreach($categories as $category) { ?>
				<option value='<?php echo $category->term_id; ?>' <?php if ($category->term_id == $instance['categories']) echo 'selected="selected"'; ?>><?php echo $category->cat_name; ?></option>
				<?php } ?>
			</select>
		</p>

		<!-- Number of posts -->
		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>">Number of posts to display:</label>
			<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" value="<?php echo $instance['number']; ?>" size="3" />
		</p>


	<?php
	}
}

?>