<?php
							$options = get_option('sf_flexform_options');
							$enable_footer = $options['enable_footer'];
							$enable_footer_divider = $options['enable_footer_divider'];
							$enable_copyright = $options['enable_copyright'];
							$enable_copyright_divider = $options['enable_copyright_divider'];
							$show_backlink = $options['show_backlink'];
							$page_layout = $options['page_layout'];
							$footer_config = $options['footer_layout'];
							$copyright_text = __($options['footer_copyright_text'], 'swiftframework');
							$go_top_text = __($options['footer_gotop_text'], 'swiftframework');

							$footer_class = $copyright_class = "";

							if ($enable_footer_divider) { $footer_class = "footer-divider"; }
							if ($enable_copyright_divider) { $copyright_class = "copyright-divider"; }



						?>


						<?php
						$showPop = get_field('show');
						if($showPop!='')
                        $showPop = $showPop[0];

						$mobile = 'false';

						/*require_once 'mobile-detect/Mobile_Detect.php';
						$detect = new Mobile_Detect;

						// Any mobile device (phones or tablets).
						if ( $detect->isMobile() ) {
							$mobile='true';
						}

						*/
						/*if($mobile=='false'){
						if($showPop=='1: check' || $showPop=='1' || $showPop=='check' ){

						    if (!isset($_COOKIE['modal'])){
						    setcookie("modal", "true", time()+86400, "/");
						    ?>
						    <script type="text/javascript">
						    jQuery(window).load(function(){
						        jQuery('#modal-1').modal('show');
						    });
						    </script>
						    <?
						    }
						 }
						}*/
						 ?>

					<!--// CLOSE #page-wrap //-->
					</div>

				<!--// CLOSE .container //-->
				</div>

			<!--// CLOSE #main-container //-->
			</div>

			<?php if ($enable_footer) { ?>

			<!--// OPEN #footer //-->
			<div id="fullwidthcontent"></div>

			<section id="footer" class="<?php echo $footer_class; ?>">
				<div class="netcraker-banner"><?php echo adrotate_ad(6); ?></div>
				<div class="social-contact row-fluid">
				<div class="sec-main-content">
					<div class="span12 textwidget">
						<img src="/wp-content/uploads/2015/02/contact-footer.png" alt="" />
						<h3>Sign up to receive the latest conference announcements</h3>
						<a id="updated" class="sf-button large green standard" href="#modal-1" data-toggle="modal">Join Mailing List</a>
						<div id="modal-1" class="modal hide fade" tabindex="-1">
							<div class="modal-header" style="text-align: center;"><button class="close" type="button" data-dismiss="modal">×</button>
								<img src="/wp-content/uploads/2014/12/LogoDD14.png" alt="Keep up to date with the last event news." style="width: 50%;margin: auto;float: none;">							</div>
							<div class="modal-body"><?php echo do_shortcode('[gravityform id=5 true=false description=false title=false ajax=true]'); ?></div>
						</div>
						<div id="modal-2" class="modal hide fade" tabindex="-1">
							<div class="modal-header" style="text-align: center;"><button class="close" type="button" data-dismiss="modal">×</button>
								<img src="/wp-content/uploads/2014/12/LogoDD14.png" style="width: 50%;margin: auto;float: none;">							</div>
							<div class="modal-body"><?php echo do_shortcode('[contact-form-7 id="18871" title="Keep Updated 2014"]'); ?></div>
						</div>
					</div>
				</div>
				</div>

				<div class="container">
					<div id="footer-widgets" class="row clearfix">
						<?php if ($footer_config == "footer-1") { ?>
						<div class="span3">
						<?php if ( function_exists('dynamic_sidebar') ) { ?>
							<?php dynamic_sidebar('Footer Column 1'); ?>
						<?php } ?>
						</div>
						<div class="span3">
						<?php if ( function_exists('dynamic_sidebar') ) { ?>
							<?php dynamic_sidebar('Footer Column 2'); ?>
						<?php } ?>
						</div>
						<div class="span3">
						<?php if ( function_exists('dynamic_sidebar') ) { ?>
							<?php dynamic_sidebar('Footer Column 3'); ?>
						<?php } ?>
						</div>
						<div class="span3">
						<?php if ( function_exists('dynamic_sidebar') ) { ?>
							<?php dynamic_sidebar('Footer Column 4'); ?>
						<?php } ?>
						</div>

						<?php } else if ($footer_config == "footer-2") { ?>

						<div class="span6">
						<?php if ( function_exists('dynamic_sidebar') ) { ?>
							<?php dynamic_sidebar('Footer Column 1'); ?>
						<?php } ?>
						</div>
						<div class="span3">
						<?php if ( function_exists('dynamic_sidebar') ) { ?>
							<?php dynamic_sidebar('Footer Column 2'); ?>
						<?php } ?>
						</div>
						<div class="span3">
						<?php if ( function_exists('dynamic_sidebar') ) { ?>
							<?php dynamic_sidebar('Footer Column 3'); ?>
						<?php } ?>
						</div>

						<?php } else if ($footer_config == "footer-3") { ?>

						<div class="span3">
						<?php if ( function_exists('dynamic_sidebar') ) { ?>
							<?php dynamic_sidebar('Footer Column 1'); ?>
						<?php } ?>
						</div>
						<div class="span3">
						<?php if ( function_exists('dynamic_sidebar') ) { ?>
							<?php dynamic_sidebar('Footer Column 2'); ?>
						<?php } ?>
						</div>
						<div class="span6">
						<?php if ( function_exists('dynamic_sidebar') ) { ?>
							<?php dynamic_sidebar('Footer Column 3'); ?>
						<?php } ?>
						</div>

						<?php } else if ($footer_config == "footer-4") { ?>

						<div class="span6">
						<?php if ( function_exists('dynamic_sidebar') ) { ?>
							<?php dynamic_sidebar('Footer Column 1'); ?>
						<?php } ?>
						</div>
						<div class="span6">
						<?php if ( function_exists('dynamic_sidebar') ) { ?>
							<?php dynamic_sidebar('Footer Column 2'); ?>
						<?php } ?>
						</div>

						<?php } else if ($footer_config == "footer-5") { ?>

						<div class="span4">
						<?php if ( function_exists('dynamic_sidebar') ) { ?>
							<?php dynamic_sidebar('Footer Column 1'); ?>
						<?php } ?>
						</div>
						<div class="span4">
						<?php if ( function_exists('dynamic_sidebar') ) { ?>
							<?php dynamic_sidebar('Footer Column 2'); ?>
						<?php } ?>
						</div>
						<div class="span4">
						<?php if ( function_exists('dynamic_sidebar') ) { ?>
							<?php dynamic_sidebar('Footer Column 3'); ?>
						<?php } ?>
						</div>

						<?php } else if ($footer_config == "footer-6") { ?>

						<div class="span8">
						<?php if ( function_exists('dynamic_sidebar') ) { ?>
							<?php dynamic_sidebar('Footer Column 1'); ?>
						<?php } ?>
						</div>
						<div class="span4">
						<?php if ( function_exists('dynamic_sidebar') ) { ?>
							<?php dynamic_sidebar('Footer Column 2'); ?>
						<?php } ?>
						</div>

						<?php } else if ($footer_config == "footer-7") { ?>

						<div class="span4">
						<?php if ( function_exists('dynamic_sidebar') ) { ?>
							<?php dynamic_sidebar('Footer Column 1'); ?>
						<?php } ?>
						</div>
						<div class="span8">
						<?php if ( function_exists('dynamic_sidebar') ) { ?>
							<?php dynamic_sidebar('Footer Column 2'); ?>
						<?php } ?>
						</div>

						<?php } else if ($footer_config == "footer-9") { ?>

						<div class="span12">
						<?php if ( function_exists('dynamic_sidebar') ) { ?>
							<?php dynamic_sidebar('Footer Column 1'); ?>
						<?php } ?>
						</div>

						<?php } else { ?>

						<div class="span3">
						<?php if ( function_exists('dynamic_sidebar') ) { ?>
							<?php dynamic_sidebar('Footer Column 1'); ?>
						<?php } ?>
						</div>
						<div class="span6">
						<?php if ( function_exists('dynamic_sidebar') ) { ?>
							<?php dynamic_sidebar('Footer Column 2'); ?>
						<?php } ?>
						</div>
						<div class="span3">
						<?php if ( function_exists('dynamic_sidebar') ) { ?>
							<?php dynamic_sidebar('Footer Column 3'); ?>
						<?php } ?>
						</div>

						<?php } ?>
					</div>
				</div>
				

			<!--// CLOSE #footer //-->
			</section>
			<?php } ?>

			<?php
				$swiftideas_backlink = "";
				if ($show_backlink) {
				$swiftideas_backlink =	apply_filters("swiftideas_link", " &middot; <a href='http://www.swiftideas.net'>Premium WordPress Themes by Swift Ideas</a>");
				}

			if ($enable_copyright) { ?>

			<!--// OPEN #copyright //-->
			<footer id="copyright" class="<?php echo $copyright_class; ?>">
				<div class="container">
					<p class="twelve columns"><?php echo do_shortcode(stripslashes($copyright_text)); ?></p>
					<div class="beam-me-up three columns offset-by-one"><a href="#"><?php echo do_shortcode(stripslashes($go_top_text)); ?><i class="icon-arrow-up"></i></a></div>
				</div>
			<!--// CLOSE #copyright //-->
			</footer>

			<?php } ?>

		<!--// CLOSE #container //-->
		</div>

		<?php

			global $has_portfolio, $has_blog, $include_maps, $include_isotope, $include_carousel, $has_progress_bar, $has_chart, $has_team;

			$sf_inc_class = "";

			if ($has_portfolio) {
				$sf_inc_class .= "has-portfolio ";
			}
			if ($has_blog) {
				$sf_inc_class .= "has-blog ";
			}
			if ($include_maps) {
				$sf_inc_class .= "has-map ";
			}
			if ($include_carousel) {
				$sf_inc_class .= "has-carousel ";
			}
			if ($has_progress_bar) {
				$sf_inc_class .= "has-progress-bar ";
			}
			if ($has_chart) {
				$sf_inc_class .= "has-chart ";
			}
			if ($has_team) {
				$sf_inc_class .= "has-team ";
			}
		?>


		<!--// FRAMEWORK INCLUDES //-->
		<div id="sf-included" class="<?php echo $sf_inc_class; ?>"></div>

		<?php $tracking = $options['google_analytics']; ?>
		<?php if ($tracking != "") { ?>
		<?php echo $tracking; ?>
		<?php } ?>

		<!--// WORDPRESS FOOTER HOOK //-->
		<?php wp_footer(); ?>

	<!--// CLOSE BODY //-->
	</body>

<!--// CLOSE HTML //-->
</html>
