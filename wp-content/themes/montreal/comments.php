<div class="blackhorizontal"></div><!-- comments -->

	<section class="row midtoppadding">
	<h6 class="blacktext bold"><?php comments_number( __(' 0 COMMENTS', 'montreal'), __(' 1 COMMENT', 'montreal'), __(' % COMMENTS', 'montreal') ); ?></h6>
	</section>
	
		<div id="comment-wrap">
			<?php if ( have_comments() ) : wp_list_comments('type=comment&callback=custom_comment'); endif; ?>
			<?php paginate_comments_links(); ?>
		</div>

<?php $custom_comment_form = array( 'fields' => apply_filters( 'comment_form_default_fields', array(
    'author' => '<section class="row">
    <dl class="field four columns">
    	<dd><label for="name">' . __('Your Name*','montreal') . '</label></dd>
    	<dt class="text"><input type="text" id="author" name="author" data-form="required" value="' . esc_attr( $commenter['comment_author'] ) . '"></dt>
    	<dd class="msg">' . __('You filled this out wrong.','montreal') . '</dd>
    </dl>',
    'email'  => '<dl class="field four columns">
    	<dd><label for="email">' . __('Your E-mail*','montreal') . '</label></dd>
    	<dt class="text"><input name="email" type="text" id="email" data-form="required" value="' . esc_attr(  $commenter['comment_author_email'] ) . '"></dt>
    	<dd class="msg">' . __('You filled this out wrong.','montreal') . '</dd>
    </dl>',
    'url'    => '<dl class="field four columns">
    	<dd><label for="email">' . __('Your Website','montreal') . '</label></dd>
    	<dt class="text"><input name="url" type="text" id="url" data-form="required" value="' . esc_attr(  $commenter['comment_author_url'] ) . '"></dt>
    	<dd class="msg">' . __('You filled this out wrong.','montreal') . '</dd>
    </dl>
    </section>') ),
  	'comment_field' => '<dl class="field row">
  		<dd><label for="message">' . __('Your Comment','montreal') . '</label></dd>
  		<dt class="textarea">
  		<textarea id="comment" name="comment"></textarea></dt>
  		<dd class="msg">' . __('You filled this out wrong.','montreal') . '</dd>
  	</dl>',
  	'logged_in_as' => '<p class="logged-in-as">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a> <a href="%3$s">Log out?</a>' ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink() ) ) ) . '</p>',
  	'title_reply' => '',
  	'comment_notes_before' => '<section class="row bigtoppadding"><h6 class="blacktext bold">' . __('LEAVE A COMMENT','montreal') . '</h6></section>',
  	'comment_notes_after' => '',
  	'cancel_reply_link' => __( 'Cancel' , 'montreal' ),
  	'label_submit' => __( 'Submit' , 'montreal' ),
  	'id_form' => 'commentform'
  ); comment_form($custom_comment_form); ?>