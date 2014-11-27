<?php

////////////////////////////////////////////////////////
////////QUEUE UP FRAMEWORK/////////////////////////////
//////////////////////////////////////////////////////

//STYLES & SCRIPTS
	require_once ( "ebor_framework/styles_scripts.php");
	
//MENUS & WIDGETS
	require_once ( "ebor_framework/mandw.php");
	
//CUSTOM POST TYPES
	require_once ( "ebor_framework/cpt.php");
	
//THEME FUNCTIONS
	require_once ( "ebor_framework/theme_functions.php");
	
//THEME OPTIONS
	require_once ( "ebor_framework/theme_options.php");
	
//THEME SUPPORT
	require_once ( "ebor_framework/theme_support.php");
	
//THEME CUSTOM FILTERS
	require_once ( "ebor_framework/theme_filters.php");
	
//CUSTOM METABOXES
	require_once ( "ebor_framework/metaboxes.php");
	
//SHORTCODES
	require_once ( 'ebor_framework/shortcodes.php' );
	
//WIDGETS
	require_once ( 'ebor_framework/widgets.php' );
			   
	
/////////////////////////////////////////////
////////CUSTOM COMMENTS/////////////////////
///////////////////////////////////////////

function custom_comment($comment, $args, $depth) { $GLOBALS['comment'] = $comment; ?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class('row midtoppadding'); ?>>

		<div class="two columns">
			<?php echo get_avatar( $comment->comment_author_email, 48 ); ?>
		</div>
		<div class="ten columns smalltoppadding comment">
	
			<div class="row">
				<p class="meta greytext">
					<?php printf(__('<span class="extrabold">%s</span>'), get_comment_author_link()) ?> - <?php echo get_comment_date(); ?> - <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
				</p>
			</div>
	
			<div class="row">
				<p class="blacktext meta">
					<?php echo get_comment_text(); ?>
				</p>
			</div>
				<?php if ($comment->comment_approved == '0') : ?>
				<p><em><?php _e('Your comment is awaiting moderation.', 'montreal') ?></em></p>
				<?php endif; ?>
			<div class="smalltoppadding grey">
			</div>
			
		</div>
	
	</li>

 <?php }