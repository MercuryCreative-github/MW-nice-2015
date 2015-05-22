<?php
/**

 * Plugin Name: List Widget

 */



add_action( 'widgets_init', 'mvp_list_load_widgets' );



function mvp_list_load_widgets() {

	register_widget( 'mvp_list_widget' );

}



class mvp_list_widget extends WP_Widget {



	/**

	 * Widget setup.

	 */

	function mvp_list_widget() {

		/* Widget settings. */

		$widget_ops = array( 'classname' => 'mvp_list_widget', 'description' => __('A widget that displays posts in a list from a category of your choice.', 'mvp_list_widget') );



		/* Widget control settings. */

		$control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'mvp_list_widget' );



		/* Create the widget. */

		$this->WP_Widget( 'mvp_list_widget', __('Braxton: List Widget', 'mvp_list_widget'), $widget_ops, $control_ops );

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


    // Get the URL of this category
    $category_link = get_category_link( $categories );

	if(function_exists('cc_get_color')) { $category_color = cc_get_color($categories);} 
	if($category_color=='default'){$category_color='66AAD7';}

?>




<style>
.cat-<? echo $categories ?> .home-view-more,
.sidebar-widget ul.home-list.cat-<? echo $categories ?> li:hover h2,
.home-widget ul.home-list.cat-<? echo $categories ?> li:hover h2,
.cat-<? echo $categories ?> span.widget-info{
    color:#<? echo $category_color ?>!important;
  
}

</style>


<div class="view-all-widget">
<a href="<?php echo esc_url( $category_link ); ?>"  style="background-color: #<? echo $category_color ?>">VIEW ALL</a>
</div>


					<ul class="home-list cat-<? echo $categories ?>" style="border-top-color: red; border-top: 4px solid #<? echo $category_color ?>">
						<?php $recent = new WP_Query(array( 'cat' => $categories, 'posts_per_page' => $number )); $i = 1; while($recent->have_posts()) : $recent->the_post();?>


						
						 <?php if (in_category( 'news' )) { ?> 
						 	<?php if($i > 10) {
								$url_news = "category/news/page/2/#";
						 	} else { 
								$url_news = "category/news/#";
						 	} ?>
						 <a href="<?php echo $url_news; ?><?php the_ID(); ?>" class="item-<?php echo $i; ?>">
						 	<?php $i++; } else { ?>
                        		<a href="<?php the_permalink(); ?>"> 
                        <?php } ?>

						<li>

							
								<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { ?>
								<div class="home-list-img"><?php the_post_thumbnail('thumb'); ?></div><!--home-list-img-->
								<?php } ?>
							

							<div class="home-list-content">
								
								<span class="widget-info"><span class="category-span"> <?php $category = get_the_category(); echo $category[0]->cat_name; ?> <span>I</span> </span>  
								<?php the_time(get_option('date_format')); ?></span>
								<h2>
								  <?php  the_title(); ?>
								</h2>


								<p><?php 

				

								if ( in_category( 'news' ) ) {

									// DO NO ERASE THIS, IT'S VERY USEFUL
									$content_post = get_post();
									$content = $content_post->post_content;
									$content = apply_filters('the_content', $content);
									$content = str_replace(']]>', ']]&gt;', $content);
									$content = str_replace("\r", "<br />", $content);
									
									// we are not using this animore so I am not printing the result							
									//echo $content; 
									

									
								

								}else {echo excerpt(25);}?></p>

                                <div class="clear" style="height: 10px"></div>

                                <?php if (!in_category( 'news' ) ) {?>

								
                                <div class="home-view-more"><img src="/wp-content/themes/braxton/images/arrow-more.png" />VIEW MORE</div>
								
                                <div class="s-box">
                                	<div class="s-box-items">
                                	    <div class="social-home"><img src="/wp-content/themes/braxton/images/social.png" width="21" height="33" /></div>
                                	    <ul class="social-ul">
				                            <li><a href="http://www.facebook.com/share.php?u=<?php the_permalink(); ?>&t=<?php the_title(); ?>" target="_blank"><img src="/wp-content/themes/braxton/images/fb.png" width="10" height="23" /></a></li>
				                            <li><a href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode(get_permalink($post->ID)); ?>&title=<?php the_title(); ?>&source=<?php echo urlencode(get_permalink($post->ID)); ?>" target="_blank"><img src="/wp-content/themes/braxton/images/linkedin.png" /></a></li>
				                            <script>[CBC country="cn" show="n"]</script><li><a href="http://twitter.com/home?status=<?php the_title(); ?> in <?php the_permalink(); ?>+%23tmforuminform+%23tmforumorg" target="_blank"><img src="/wp-content/themes/braxton/images/tw.png" width="19" height="23" /></a></li><script>[/CBC]</script>
				                            <li><a href="https://plus.google.com/share?url=<?php the_title(); ?> in <?php the_permalink(); ?>+%23tmforuminform+%23tmforumorg" target="_blank" ><img src="/wp-content/themes/braxton/images/gmas.png" width="22" height="23" /></a></li>
				                        </ul>
				                    </div>
				                </div>
							
								<?php } ?>
							</div><!--home-list-content-->

						</li>

						 <?php if (in_category( 'news' ) ) {?> </a> <?php } ?>


						
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

				<?php foreach($categories as $category) {  ?>

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