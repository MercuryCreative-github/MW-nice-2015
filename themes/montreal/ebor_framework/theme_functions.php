<?php 

/////////////////////////////////////////////
////////CUSTOM FUNCTIONS////////////////////
///////////////////////////////////////////

add_action('admin_notices', 'ebor_admin_notice');

function ebor_admin_notice() {
	global $current_user ;
        $user_id = $current_user->ID;
        /* Check that the user hasn't already clicked to ignore the message */
	if ( ! get_user_meta($user_id, 'ebor_ignore_notice') ) {
        echo '<div class="updated"><p>'; 
        printf(__('<b>Hey there! Thanks for installing montreal</b><br />
        If you have just upgraded montreal, dismiss this message.<br />
        As a new user here is a few things you need to do to get going with the theme;<br />
        <ol>
        	<li>Please visit the <a href="customize.php">Theme Customizer</a> and make any small change to enable the "Save Changes" button, hit the button, this will write the theme styling to your database properly for the first time.</li>
        	<li>Be sure to ready through the included documentation and watch the included set-up videos, they will help you out loads in getting going with montreal</li>
        	<li>Above all, have fun and enjoy your new theme!</li>
        </ol> | <a href="%1$s">Hide Notice</a>', 'montreal'), '?ebor_nag_ignore=0');
        echo "</p></div>";
	}
}

add_action('admin_init', 'ebor_nag_ignore');

function ebor_nag_ignore() {
	global $current_user;
        $user_id = $current_user->ID;
        /* If user clicks to ignore the notice, add that to their user meta */
        if ( isset($_GET['ebor_nag_ignore']) && '0' == $_GET['ebor_nag_ignore'] ) {
             add_user_meta($user_id, 'ebor_ignore_notice', 'true', true);
	}
}

/**
 * Portfolio Unlimited
 *
 * Uses pre_get_posts to provide unlimited portfolio posts when viewing the /portfolio/ archive
 *
 * @since 1.0.0
 */
 
function portfolio_unlimited( $query ) {
    if ( is_post_type_archive('portfolio') ) {
        // Display unlimited posts when looking in portfolio-archive
        $query->set( 'posts_per_page', -1 );
        return;
    }
}
add_action( 'pre_get_posts', 'portfolio_unlimited' );

function wpb_set_post_views($postID) {
    $count_key = 'wpb_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}

//PAGIANTION, COURTESY OF KREISI
function kriesi_pagination($pages = '', $range = 2)
{
$showitems = ($range * 2)+1;

global $paged;
if(empty($paged)) $paged = 1;

if($pages == '')
{
global $wp_query;
$pages = $wp_query->max_num_pages;
if(!$pages)
{
$pages = 1;
}
}

if(1 != $pages)
{
echo "<ul class='pagination'>";
if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<li><a href='".get_pagenum_link(1)."'>&laquo;</a></li>";
if($paged > 1 && $showitems < $pages) echo "<li><a href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a></li>";

for ($i=1; $i <= $pages; $i++)
{
if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
{
echo ($paged == $i)? "<li class='current'><a href='#'>".$i."</a></li>":"<li><a href='".get_pagenum_link($i)."'>".$i."</a></li>";
}
}

if ($paged < $pages && $showitems < $pages) echo "<li><a href='".get_pagenum_link($paged + 1)."'>&rsaquo;</a></li>";
if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<li><a href='".get_pagenum_link($pages)."'>&raquo;</a></li>";
echo "</ul>\n";
}
}

function the_simple_terms() {
global $post;
	if( get_the_terms($post->ID,'portfolio-category') ) {
		$terms = get_the_terms($post->ID,'portfolio-category','',', ','');
		$terms = array_map('_simple_cb', $terms);
		return implode(' / ', $terms);
	}
}

function the_grid_simple_terms() {
global $post;
	if( get_the_terms($post->ID,'portfolio-category') ) {
		$terms = get_the_terms($post->ID,'portfolio-category','',', ','');
		$terms = array_map('_simple_cb', $terms);
		return implode('<br />', $terms);
	}
}

function _simple_cb($t) {  return $t->name; }

//Replace wp_trim_excerpt with a commented out strip_shortcodes()
function improved_trim_excerpt($text) {
	$raw_excerpt = $text;
	if ( '' == $text ) {
		$text = get_the_content('');

		//$text = strip_shortcodes( $text );

		$text = apply_filters('the_content', $text);
		$text = str_replace(']]>', ']]>', $text);
		$text = strip_tags($text);
		$excerpt_length = apply_filters('excerpt_length', 55);
		$excerpt_more = apply_filters('excerpt_more', ' ' . '[...]');
		$words = preg_split("/[\n\r\t ]+/", $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);
		if ( count($words) > $excerpt_length ) {
			array_pop($words);
			$text = implode(' ', $words);
			$text = $text . $excerpt_more;
		} else {
			$text = implode(' ', $words);
		}
	}
	return apply_filters('improved_trim_excerpt', $text, $raw_excerpt);
}
remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'improved_trim_excerpt');

//SHORTCODE DROP DOWN
add_action('media_buttons','add_sc_select',11);
function add_sc_select(){
    global $shortcode_tags; $shortcodes_list='';
    /** Any Shortcodes that should be excluded from this list should be added below */
    $exclude = array("wp_caption", "embed", 'caption', 'gallery');
    echo '<select style="float:right;margin-right:15px;position:relative;top:5px;height:20px;" id="sc_select">
    <option>Insert Shortcode...</option>';
    foreach ($shortcode_tags as $key => $val){
            if(!in_array($key,$exclude)){
            	if($key=='blockquote'){ $output = "[blockquote]This could be a blockquote.[/blockquote]"; }
            	if($key=='drawer'){ $output = "[drawer title='THIS IS A TOGGLE DRAWER' instructions='Click to toggle drawer']Hello, this is a drawer[/drawer]"; }
            	if($key=='fancy_headline'){ $output = "[fancy_headline]A Fancy Headline[/fancy_headline]"; }
            	if($key=='fancy_list'){ $output = "[fancy_list type='tick']
            	<ul>
            		<li>Item One</li>
            		<li>Item Two</li>
            		<li>Add more if you want...</li>
            	</ul>
            	[/fancy_list]"; }
            	if($key=='dropcap'){ $output = "[dropcap]Your content[/dropcap]"; }
            	if($key=='fancy_link'){ $output = "[fancy_link link='http://www.google.com']Your content[/fancy_link]"; }
            	if($key=='full_width'){ $output = "[full_width]Content goes here[/full_width]"; }
            	if($key=='centered_column'){ $output = "[centered_column]Content goes here[/centered_column]"; }
            	if($key=='one_half'){ $output = "[one_half]Content goes here[/one_half]"; }
            	if($key=='one_third'){ $output = "[one_third]Content goes here[/one_third]"; }
            	if($key=='one_quarter'){ $output = "[one_quarter]Content goes here[/one_quarter]"; }
            	if($key=='three_quarters'){ $output = "[three_quarters]Content goes here[/three_quarters]"; }
            	if($key=='two_thirds'){ $output = "[two_thirds]Content goes here[/two_thirds]"; }
            	if($key=='button'){ $output = "[button type='secondbutton' link='#']Button[/button]"; }
            	if($key=='big_button'){ $output = "[big_button link='#' type='secondary' margin='push_one']Button[/big_button]"; }
            	if($key=='tabgroup'){ $output = "[tabgroup]
            	[tab title='Tab 1' id='t1' active='active']Lorem ipsum dolor sit amet.[/tab]
            	[tab title='Tab 2' id='t2']Lorem ipsum dolor sit amet.[/tab]
            	[tab title='Tab 3' id='t3']Lorem ipsum dolor sit amet.[/tab]
            	[/tabgroup]"; }
            	if($key=='tab'){ $output = "[tab title='Tab 1' id='t1']Lorem ipsum dolor sit amet.[/tab]"; }
            	if($key=='clear'){ $output = "[clear]"; }
            	if($key=='big_clear'){ $output = "[big_clear]"; }
            	if($key=='clearline'){ $output = "[clearline]"; }
            	if($key=='largefont'){ $output = "[largefont]Your Content[/largefont]"; }
            	if($key=='metafont'){ $output = "[metafont]Your Content[/metafont]"; }
            	if($key=='smallfont'){ $output = "[smallfont]Your Content[/smallfont]"; }
            	if($key=='testimonials'){ $output = "[testimonials title='Testimonials Shortcode']"; }
            	if($key=='clients'){ $output = "[clients title='Clients Shortcode']"; }
            	if($key=='team_members'){ $output = "[team_members title='Team Members Shortcode']"; }
            $shortcodes_list .= '<option value="'.$output.'">'.$key.'</option>';
            }
        }
     echo $shortcodes_list;
     echo '</select>';
}
add_action('admin_head', 'button_js');
function button_js() {
    echo '<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery("#sc_select").change(function() {
            send_to_editor(jQuery("#sc_select :selected").val());
                return false;
            });
        });
    </script>';
}

function testimonial($title){ ?>

	<section class="row">
		<h4 class="italic center"><?php echo $title ?></h4>
	</section>
	<section class="row midtoppadding smallbottompadding">
		<h2 class="light blacktext center icon-certificate"></h2>
	</section>
	
	<section class="row">
	<div class="seven columns centered">
		<div class="flexslider">
			<ul class="slides">
				<?php 
					$testimonial_query = new WP_Query('post_type=testimonial&posts_per_page=-1'); 
					if( $testimonial_query->have_posts() ) : while( $testimonial_query->have_posts() ) : $testimonial_query->the_post(); 
					global $post; 
				?>
				
					<li>
					<div>
						<h5 class="light blacktext center"><?php $content = get_the_content(); echo strip_tags($content); ?></h5>
						<h6 class="center bold meta midtopmargin blacktext"><?php the_title(); ?></h6>
					</div>
					</li>
					
				<?php 
					endwhile; 
					endif; 
					wp_reset_query(); 
				?>
			</ul>
		</div>
	</div>
	</section>

<?php }

function clients($title){ ?>

	<section class="row white bigpadding leftpadding rightpadding">
	
	<section class="row">
		<h4 class="blacktext midbottommargin center"><?php echo $title; ?></h4>
			<div class="three columns alpha centered blackhorizontal"></div>
	</section>
	
	<section class="row midtopmargin bigbottommargin clients_section">
		<?php 
			$clients_query = new WP_Query('post_type=clients&posts_per_page=-1'); 
			if( $clients_query->have_posts() ) : while( $clients_query->have_posts() ) : $clients_query->the_post(); 
			global $post; 
		?>
		
			<div class="two columns">
				<?php the_post_thumbnail('client'); ?>
			</div>
			
		<?php 
			endwhile; 
			endif; 
			wp_reset_query(); 
		?>
	</section>

<?php } 

	function team($title){ ?>
	
	<section class="row">
	<h3 class="whitetext bold midbottommargin center"><?php echo $title; ?></h3>
	<div class="three columns alpha centered whitehorizontal">
	</div>
	</section>
	<section class="row midtopmargin">
	
		<?php 
			$team_query = new WP_Query('post_type=team&posts_per_page=-1'); 
			if( $team_query->have_posts() ) : while( $team_query->have_posts() ) : $team_query->the_post(); 
			global $post; 
		?>
		
			<div class="three columns team">
				<div class="person smallbottommargin">
					<?php the_post_thumbnail(); ?>
					<div class="personinfo">
						<p class="center bigtoppadding">
							<?php if( get_post_meta( $post->ID, '_cmb_the_team_social1_link', true ) !=''  ) : ?><a href="<?php echo get_post_meta( $post->ID, '_cmb_the_team_social1_link', true ); ?>" class="smallfont whitetext" target="_blank"><?php echo get_post_meta( $post->ID, '_cmb_the_team_social1_name', true ); ?></a> &nbsp; <?php endif; ?>
							<?php if( get_post_meta( $post->ID, '_cmb_the_team_social2_link', true ) !=''  ) : ?><a href="<?php echo get_post_meta( $post->ID, '_cmb_the_team_social2_link', true ); ?>" class="smallfont whitetext" target="_blank"><?php echo get_post_meta( $post->ID, '_cmb_the_team_social2_name', true ); ?></a> &nbsp; <?php endif; ?>
							<?php if( get_post_meta( $post->ID, '_cmb_the_team_social3_link', true ) !=''  ) : ?><a href="<?php echo get_post_meta( $post->ID, '_cmb_the_team_social3_link', true ); ?>" class="smallfont whitetext" target="_blank"><?php echo get_post_meta( $post->ID, '_cmb_the_team_social3_name', true ); ?></a> <?php endif; ?>
						</p>
					</div>
				</div>
				<!-- PERSON INFO -->
				<h5 class="whitetext"><?php the_title(); ?></h5>
				<h6 class="whitetext"><?php echo get_post_meta( $post->ID, '_cmb_the_job_title', true ); ?></h6>
			</div>
			
		<?php 
			endwhile;
			endif; 
			wp_reset_query(); 
		?>
	
	</section>

<?php }