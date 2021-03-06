<!DOCTYPE html>
<!--// OPEN HTML //-->
<!--[if IE 8]> <html <?php language_attributes(); ?> id="ie8"> <![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?>> <!--<![endif]-->
	<!--// OPEN HEAD //-->
	<head>
		<?php
			$options = get_option('sf_flexform_options');
			$enable_responsive = $options['enable_responsive'];
			$is_responsive = "responsive-fluid";
			if (!$enable_responsive) {
				$is_responsive = "responsive-fixed";
			}
			$header_layout = $options['logo_layout'];
			$page_layout = $options['page_layout'];
			$logo = $retina_logo = "";
			if (isset($options['logo_upload'])) {
			$logo = $options['logo_upload'];
			}
			if (isset($options['retina_logo_upload'])) {
			$retina_logo = $options['retina_logo_upload'];
			}
			if ($logo == "") {
			$logo = get_template_directory_uri() . '/images/logo.png';
			}
			if ($retina_logo == "") {
			$retina_logo = $logo;
			}

			$enable_logo_fade = $options['enable_logo_fade'];
			$enable_page_shadow = $options['enable_page_shadow'];
			$enable_top_bar = $options['enable_top_bar'];
			$top_bar_menu = $options['top_bar_menu'];
			$top_bar_social_icons = $options['top_bar_social_icons'];
			$show_sub = $options['show_sub'];
			$show_translation = $options['show_translation'];
			$show_account = $options['show_account'];
			$show_cart = $options['show_cart'];
			$sub_code = $options['sub_code'];

			$enable_mini_header = $options['enable_mini_header'];
			$enable_nav_indicator = $options['enable_nav_indicator'];

			$enable_header_shadow = $options['enable_header_shadow'];

			$page_class = $logo_class = $nav_class = "";

			if ($enable_page_shadow) {
			$page_class = "page-shadow ";
			}

			if ($enable_logo_fade) {
			$logo_class = "logo-fade";
			}

			if ($enable_nav_indicator) {
			$nav_class .= "nav-indicator ";
			}

			$enable_nav_search = 1;

			if (isset($options['enable_nav_search'])) {
				$enable_nav_search = $options['enable_nav_search'];
			}

			if (isset($_GET['layout'])) {
				$page_layout = $_GET['layout'];
			}

			global $post;
			$extra_page_class = "";
			if ($post) {
				$extra_page_class = get_post_meta($post->ID, 'sf_extra_page_class', true);
				$hide_page_header = get_post_meta($post->ID, 'sf_hide_page_header', true);
				$hide_page_footer = get_post_meta($post->ID, 'sf_hide_page_footer', true);

				if ($hide_page_header) {
					$page_class .= "hide-header ";
				}

				if ($hide_page_footer) {
					$page_class .= "hide-footer ";
				}
			}
		?>

		<!--// SITE META //-->
		<meta http-equiv="Content-Type" content="text/html" charset="<?php bloginfo( 'charset' ); ?>" />




				<!--// SITE TITLE //-->
		<title><?php wp_title( '|', true, 'right' ); ?></title>



		<?php if ($enable_responsive) { ?><meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1"><?php } ?>
		<meta http-equiv="X-UA-Compatible" content="IE=edge"/>

		<!--// PINGBACK & FAVICON //-->
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		<?php if (isset($options['custom_favicon'])) { ?><link rel="shortcut icon" href="<?php echo $options['custom_favicon']; ?>" /><?php } ?>

								<link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,300,300italic,400italic,200italic,200,600,600italic,700,700italic,900' rel='stylesheet' type='text/css'>
		<?php
			$options = get_option('sf_flexform_options');

			$custom_fonts = $google_font_one = $google_font_two = $google_font_three = "";

			$body_font_option = $options['body_font_option'];
			if (isset($options['google_standard_font'])) {
			$google_standard_font = explode(':', $options['google_standard_font']);
			$google_font_one = str_replace("+", " ", $google_standard_font[0]);
			}
			$headings_font_option = $options['headings_font_option'];
			if (isset($options['google_heading_font'])) {
			$google_heading_font = explode(':', $options['google_heading_font']);
			$google_font_two = str_replace("+", " ", $google_heading_font[0]);
			}

			$menu_font_option = $options['menu_font_option'];
			if (isset($options['google_menu_font'])) {
			$google_menu_font = explode(':', $options['google_menu_font']);
			$google_font_three = str_replace("+", " ", $google_menu_font[0]);
			}


			if ($body_font_option == "google" && $google_font_one != "") {
				$custom_fonts .= "'".$google_font_one."', ";
			}
			if ($headings_font_option == "google" && $google_font_two != "") {
				$custom_fonts .= "'".$google_font_two."', ";
			}
			if ($menu_font_option == "google" && $google_font_three != "") {
				$custom_fonts .= "'".$google_font_three."', ";
			}

			$fontdeck_js = $options['fontdeck_js'];
		?>
		<?php if (($body_font_option == "google") || ($headings_font_option == "google") || ($menu_font_option == "google")) { ?>
		<!--// GOOGLE FONT LOADER //-->
		<script>
			var html = document.getElementsByTagName('html')[0];
			html.className += '  wf-loading';
			setTimeout(function() {
				html.className = html.className.replace(' wf-loading', '');
			}, 3000);

			WebFontConfig = {
					google: { families: [<?php echo $custom_fonts; ?> 'Vidaloka'] }
			};

			(function() {
				document.getElementsByTagName("html")[0].setAttribute("class","wf-loading")
				//  NEEDED to push the wf-loading class to your head
				document.getElementsByTagName("html")[0].setAttribute("className","wf-loading")
				// for IE…

			var wf = document.createElement('script');
				wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
				'://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
				wf.type = 'text/javascript';
				wf.async = 'false';
				var s = document.getElementsByTagName('script')[0];
				s.parentNode.insertBefore(wf, s);
			})();
		</script>
		<?php } ?>
		<?php if (($body_font_option == "fontdeck") || ($headings_font_option == "fontdeck") || ($menu_font_option == "fontdeck")) { ?>
		<!--// FONTDECK LOADER //-->
		<?php echo $fontdeck_js; ?>
		<?php } ?>

			<!--// LEGACY HTML5 SUPPORT //-->
			<!--[if lt IE 10]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<script src="<?php echo get_template_directory_uri(); ?>/js/excanvas.compiled.js"></script>
		<![endif]-->

		<!--// WORDPRESS HEAD HOOK //-->
		<?php wp_head(); ?>

	<!--// CLOSE HEAD //-->
	<meta property="og:url" content="http://www.tmforumlive.org/">
	<meta property="og:title" content="TM Forum Live! 2015">
	<meta property="og:description" content="TM Forum Live! Nice, France 1 - 4 June 2015">
	<meta property="og:image" content="/wp-content/uploads/2014/12/LogoDD14.png">
	<meta property="og:image:type" content="image/png">
	<meta property="og:image:width" content="200">
	<meta property="og:image:height" content="200">

	<!-- Facebook Pixel Code -->
	<script>
	!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
	n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
	n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
	t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
	document,'script','//connect.facebook.net/en_US/fbevents.js');

	fbq('init', '547534488732109');
	fbq('track', 'PageView');
	</script>
	<noscript><img height="1" width="1" style="display:none"
	src="https://www.facebook.com/tr?id=547534488732109&ev=PageView&noscript=1"
	/></noscript>
	<!-- End Facebook Pixel Code -->
	</head>

	<!--// OPEN BODY //-->

	<?php if(function_exists('get_field')){ $custom_page_class=get_field('custom_page_class');}else{$custom_page_class='';} ?>

	<body <?php body_class($page_class . ' ' . $is_responsive . ' ' . $extra_page_class. ' ' . $custom_page_class); ?>>

	<img style="display:none;" src="/wp-content/uploads/2015/02/logo-footer.png" alt="TM Forum Live! 2015">

		<?php if (is_single()) { ?>
		<!--// SOCIAL SCRIPTS //-->
		<script src="http://w.sharethis.com/button/buttons.js"></script>
		<script >stLight.options({publisher: "ur-72c8cf80-2647-2464-a894-abc33849d467", doNotHash: true, doNotCopy: true, hashAddressBar: false});</script>
		<?php } ?>

		<!--// NO JS ALERT //-->
		<noscript>
			<div class="no-js-alert"><?php _e("Please enable JavaScript to view this website.", "swiftframework"); ?></div>
		</noscript>

		<!--// OPEN #container //-->
		<?php if ($page_layout == "fullwidth") { ?>
		<div id="container">
		<?php } else { ?>
		<div id="container" class="boxed-layout">
		<?php } ?>

			<?php if ($enable_top_bar) { ?>

			<!--// OPEN TOP BAR //-->
			<?php if ($top_bar_menu) { ?>
			<div id="top-bar" class="top-bar-menu-left">
			<?php } else { ?>
			<div id="top-bar" class="top-bar-menu-right">
			<?php } ?>
				<div class="container">
					<div class="row">
						<a href="#" class="visible-phone show-menu"><?php _e("Select a page", "swiftframework"); ?><i class="icon-angle-down"></i></a>
						<nav id="top-bar-menu" class="top-menu span8 clearfix">
							<div id="aux-nav">
								<ul class="menu">
									<?php if ($show_cart) { ?>
									<li class="parent aux-cart">
										<a href="#" class="cart-menu-item"><?php _e("Cart", "swiftframework"); ?></a>
										<ul id="header-cart" class="sub-menu">
											<?php global $woocommerce; ?>
											<?php if ($woocommerce) { ?>
											<li>
												<a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'woothemes'); ?>"><?php echo sprintf(_n('%d item', '%d items', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count);?> - <?php echo $woocommerce->cart->get_cart_total(); ?></a>
											</li>
											<?php } else { ?>
											<li>
												<div><?php _e("Please install WooCommerce", "swiftframework"); ?></div>
											</li>
											<?php } ?>
										</ul>
									</li>
									<?php } ?>
									<?php if ($show_sub) { ?>
									<li class="parent aux-subscribe">
										<a href="#"><?php _e("Subscribe", "swiftframework"); ?></a>
										<ul class="sub-menu">
											<li>
												<div id="header-subscribe" class="clearfix">
													<?php echo $sub_code; ?>
												</div>
											</li>
										</ul>
									</li>
									<?php } ?>
									<?php if ($show_account) { ?>
									<li class="parent">
										<a href="#"><?php _e("Account", "swiftframework"); ?></a>
										<ul class="sub-menu aux-account">
											<?php if (!is_user_logged_in()) { ?>
											<li>
												<div id="header-login" class="clearfix">
													<form action="<?php echo wp_login_url(); ?>" autocomplete="off" method="post" class="clearfix">
													<label for="username">Username</label>
													<input type="text" name="log" id="username" value="" placeholder="<?php _e("Username", "swiftframework"); ?>" size="20" />
													<label for="username">Password</label>
													<input type="password" name="pwd" id="password" placeholder="<?php _e("Password", "swiftframework"); ?>" size="20" />
													<input type="submit" name="submit" value="Login" id="submit" class="sf-button slightlyrounded accent"/>
													<div class="link-wrap">
													<a href="<?php echo site_url('/wp-login.php?action=register&amp;redirect_to=' . get_permalink()); ?>" class="register"><?php _e("Register", "swiftframework"); ?></a>
													<span> / </span>
													<a href="<?php echo home_url(); ?>/wp-login.php?action=lostpassword" class="recover-password"><?php _e("Forgot login?", "swiftframework"); ?></a>
													</div>
													</form>
												</div>
											</li>
											<?php } else { ?>
											<li>
												<a href="<?php echo get_admin_url(); ?>" class="admin-link"><?php _e("WordPress Admin", "swiftframework"); ?></a>
											</li>
											<li>
												<a href="<?php echo wp_logout_url( home_url() ); ?>" class="logout-link"><?php _e("Logout", "swiftframework"); ?></a>
											</li>
											<?php } ?>
										</ul>
									</li>
									<?php } ?>
									<?php if ($show_translation) { ?>
									<li class="parent aux-languages">
										<a href="#" class="languages-menu-item"><?php _e("Languages", "swiftframework"); ?></a>
										<ul id="header-languages" class="sub-menu">
											<?php
												if (function_exists( 'language_flags' )) {
													language_flags();
												}
											?>
										</ul>
									</li>
									<?php } ?>
								</ul>
							</div>
							<?php
								if(function_exists('wp_nav_menu')) {
								wp_nav_menu(array(
								'theme_location' => 'top_bar_menu',
								'fallback_cb' => ''
								)); }
							?>
						</nav>
					</div>
				</div>
			<!--// CLOSE TOP BAR //-->
			</div>
			<?php } ?>

			<!--MODAL FORM-->
			<div id="modal-1" class="modal hide fade" tabindex="-1">
				<div class="modal-header" style="text-align: center;"><button class="close" type="button" data-dismiss="modal">×</button><img src="/wp-content/uploads/2014/12/LogoDD14.png" alt="Keep up to date with the last event news." style="width: 50%;margin: auto;float: none;"></div>
				<div class="modal-body"><?php echo do_shortcode('[gravityform id=6 true=false description=false title=false ajax=true]'); ?></div>
			</div>


			<!--// OPEN #header-section //-->
			<div id="header-section" class="<?php echo $header_layout; ?> <?php echo $logo_class; ?> clearfix">

				<div class="container">
										<div class="head">
					<header class="row-fluid">

						<!--// OPEN NAV SECTION //-->
						<div id="nav-section" class="<?php echo $nav_class; ?> span12 clearfix">
							<div id="logo">
								<a href="<?php echo home_url(); ?>">
									<img class="standard" src="<?php echo $logo; ?>" alt="<?php bloginfo( 'name' ); ?>">
									<img class="retina" src="<?php echo $retina_logo; ?>" alt="<?php bloginfo( 'name' ); ?>"/>
								</a>

							</div>
							<div class="nav-wrap clearfix">

								<!--// OPEN MAIN NAV //-->
								<a href="#" class="visible-phone show-menu"><?php _e("Select a page", "swiftframework"); ?><i class="icon-angle-down"></i></a>
								<nav id="main-navigation">

									<?php
									if(function_exists('wp_nav_menu')) {
									wp_nav_menu(array(
									'theme_location' => 'main_navigation',
									'fallback_cb' => ''
									)); }
									?>

								<!--// CLOSE MAIN NAV //-->
								</nav>

								<?php if ($enable_nav_search) { ?>

								<div id="nav-search">
									<a href="#" class="nav-search-link"><i class="icon-search"></i></a>
									<form method="get" action="<?php echo home_url(); ?>/">
										<input type="text" name="s" autocomplete="off" />
									</form>
								</div>

								<?php } ?>

							</div>
														<div class="mobile-navigation">

																<a class="logo-mobile" href="<?php echo home_url(); ?>">
																	<img class="retina" src="<?php echo $retina_logo; ?>" alt="<?php bloginfo( 'name' ); ?>">
																</a>

																<button type="button" class="navbar-toggle">
																				<span class="icon-bar"></span>
																				<span class="icon-bar"></span>
																				<span class="icon-bar"></span>
																</button>

																<div class="navbar-collapse">
									<?php
									if(function_exists('wp_nav_menu')) {
									wp_nav_menu(array(
									'theme_location' => 'main_navigation',
									'container' => 'false'
									)); }
									?>
																</div>

														</div>
						<!--// CLOSE NAV SECTION //-->
						</div>

						<!-- google-analytics -->
						<script type="text/javascript">
						var _gaq = _gaq || [];
						_gaq.push(['_setAccount', 'UA-3242766-16']);
						_gaq.push(['_trackPageview']);
						(function () {
						var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
						ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
						var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
						})();
						</script>

					</header>
										</div>
				</div>
			</div>

			<!--// OPEN Scrolled header section //-->
			<?php if ($enable_mini_header) { ?>

			<div id="header-scroll" class="<?php if(!is_home() && !is_front_page()){echo "boxed-layout";} if(is_home() || is_front_page()){echo "header-scroll-home";}?> <?php echo $header_layout; ?> <?php echo $logo_class; ?> clearfix"></div>

			<?php } ?>
			<!--CLOSE Scrolled header section-->

			<!--// OPEN #main-container //-->
			<div id="main-container" class="clearfix">

				<?php if ($enable_header_shadow) { ?>
				<div id="header-shadow"></div>
				<?php } ?>

				<?php
					if (is_page()) {
						$show_posts_slider = get_post_meta($post->ID, 'sf_posts_slider', true);
						$rev_slider_alias = get_post_meta($post->ID, 'sf_rev_slider_alias', true);

						if ($show_posts_slider) {
							get_posts_slider();
						} else if ($rev_slider_alias != "") { ?>
							<div class="home-slider-wrap">
								<?php echo do_shortcode('[rev_slider '.$rev_slider_alias.']'); ?>
							</div>
						<?php }
					}


					if ( is_singular( 'agenda_tracks' ) ) {
						$rev_slider_alias =  get_field('revolution_slider');
						if ($rev_slider_alias != ""){
						?>
							<div class="home-slider-wrap">
								<?php echo do_shortcode('[rev_slider '.$rev_slider_alias.']'); ?>
							</div>
						<?php }
					}
				?>

				<!--// OPEN .container //-->
				<div class="container">

					<!--// OPEN #page-wrap //-->
					<div id="page-wrap">
