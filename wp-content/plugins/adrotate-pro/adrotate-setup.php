<?php
/* ------------------------------------------------------------------------------------
*  COPYRIGHT AND TRADEMARK NOTICE
*  Copyright 2008-2015 AJdG Solutions (Arnan de Gans). All Rights Reserved.
*  ADROTATE is a registered trademark of Arnan de Gans.

*  COPYRIGHT NOTICES AND ALL THE COMMENTS SHOULD REMAIN INTACT.
*  By using this code you agree to indemnify Arnan de Gans from any
*  liability that might arise from it's use.
------------------------------------------------------------------------------------ */

/*-------------------------------------------------------------
 Name:      adrotate_activate

 Purpose:   Set up AdRotate on your current blog
 Receive:   -none-
 Return:	-none-
 Since:		3.9.8
-------------------------------------------------------------*/
function adrotate_activate($network_wide) {
	if(is_multisite() && $network_wide) {
		global $wpdb;
 
		$current_blog = $wpdb->blogid;
		$activated = array();
 
		$blog_ids = $wpdb->get_col("SELECT `blog_id` FROM $wpdb->blogs;");
		foreach($blog_ids as $blog_id) {
			switch_to_blog($blog_id);
			adrotate_activate_setup();
			$activated[] = $blog_id;
		}
 
		switch_to_blog($current_blog);
		return;
	}
	adrotate_activate_setup();
}

/*-------------------------------------------------------------
 Name:      adrotate_activate_setup

 Purpose:   Creates database table if it doesnt exist
 Receive:   -none-
 Return:	-none-
 Since:		0.1
-------------------------------------------------------------*/
function adrotate_activate_setup() {
	global $wpdb, $current_user, $userdata;

	if(!current_user_can('activate_plugins')) {
		deactivate_plugins(plugin_basename('adrotate-pro/adrotate.php'));
		wp_die('You do not have appropriate access to activate this plugin! Contact your administrator!<br /><a href="'. get_option('siteurl').'/wp-admin/plugins.php">Back to plugins</a>.'); 
		return; 
	} else {
		// Set defaults for internal versions
		add_option('adrotate_db_version', array('current' => ADROTATE_DB_VERSION, 'previous' => ''));
		add_option('adrotate_version', array('current' => ADROTATE_VERSION, 'previous' => ''));

		// Install tables for AdRotate
		adrotate_check_upgrade();

		// Set default settings and values
		add_option('adrotate_config', array());
		add_option('adrotate_notifications', array());
		add_option('adrotate_crawlers', array());
		add_option('adrotate_db_timer', date('U'));
		add_option('adrotate_debug', array('general' => false, 'dashboard' => false, 'userroles' => false, 'userstats' => false, 'stats' => false, 'track' => false));
		add_option('adrotate_advert_status', array('error' => 0, 'expired' => 0, 'expiressoon' => 0, 'normal' => 0, 'unknown' => 0, 'total' => 0));
		add_option('adrotate_geo_required', 0);
		add_option('adrotate_geo_requests', 0);
		add_option('adrotate_responsive_required', 0);
		add_option('adrotate_dynamic_required', 0);

		add_option('adrotate_activate', array('status' => 0, 'instance' => '', 'activated' => '', 'deactivated' => '', 'type' => '', 'key' => '', 'email' => '', 'version' => '', 'firstrun' => 1));
		add_option('adrotate_hide_license', 0);

		adrotate_check_config();

		// Set the capabilities for the administrator
		$role = get_role('administrator');		
		$role->add_cap("adrotate_advertiser");
		$role->add_cap("adrotate_global_report");
		$role->add_cap("adrotate_ad_manage");
		$role->add_cap("adrotate_ad_delete");
		$role->add_cap("adrotate_group_manage");
		$role->add_cap("adrotate_group_delete");
		$role->add_cap("adrotate_schedule_manage");
		$role->add_cap("adrotate_schedule_delete");
		$role->add_cap("adrotate_moderate");
		$role->add_cap("adrotate_moderate_approve");
	
		// Switch additional roles off
 		adrotate_remove_roles();
		update_option('adrotate_roles', '0');

		// Set up some schedules
		$firstrun = adrotate_now();
		if(!wp_next_scheduled('adrotate_notification')) { // Ad notifications
			wp_schedule_event($firstrun + 900, 'daily', 'adrotate_notification');
		}

		if(!wp_next_scheduled('adrotate_clean_trackerdata')) { // Periodically clean trackerdata
			wp_schedule_event($firstrun + 1800, 'twicedaily', 'adrotate_clean_trackerdata');
		}

		if(!wp_next_scheduled('adrotate_evaluate_ads')) { // Periodically check ads
			wp_schedule_event($firstrun + 2700, 'twicedaily', 'adrotate_evaluate_ads');
		}

		// Attempt to make the some folders
		if(!is_dir(ABSPATH.'/wp-content/banners')) mkdir(ABSPATH.'/wp-content/banners', 0755);
		if(!is_dir(ABSPATH.'/wp-content/reports')) mkdir(ABSPATH.'/wp-content/reports', 0755);
	}
}

/*-------------------------------------------------------------
 Name:      adrotate_deactivate

 Purpose:   Deactivate script
 Receive:   -none-
 Return:	-none-
 Since:		2.0
-------------------------------------------------------------*/
function adrotate_deactivate($network_wide) {
    adrotate_network_propagate('adrotate_deactivate_setup', $network_wide);
}

/*-------------------------------------------------------------
 Name:      adrotate_deactivate_setup

 Purpose:   Deactivate script
 Receive:   -none-
 Return:	-none-
 Since:		2.0
-------------------------------------------------------------*/
function adrotate_deactivate_setup() {
	// Clear out roles
	$adrotate_roles	= get_option('adrotate_roles');
	if($adrotate_roles == 1) {
		adrotate_remove_roles();
	}

	// Clean up capabilities from ALL users
	adrotate_remove_capability("adrotate_advertiser");
	adrotate_remove_capability("adrotate_global_report");
	adrotate_remove_capability("adrotate_ad_manage");
	adrotate_remove_capability("adrotate_ad_delete");
	adrotate_remove_capability("adrotate_group_manage");
	adrotate_remove_capability("adrotate_group_delete");
	adrotate_remove_capability("adrotate_schedule_manage");
	adrotate_remove_capability("adrotate_schedule_delete");
	adrotate_remove_capability("adrotate_moderate");
	adrotate_remove_capability("adrotate_moderate_approve");

	// Clear out wp_cron
	wp_clear_scheduled_hook('adrotate_notification');
	wp_clear_scheduled_hook('adrotate_clean_trackerdata');
	wp_clear_scheduled_hook('adrotate_evaluate_ads');
}

/*-------------------------------------------------------------
 Name:      adrotate_uninstall

 Purpose:   Initiate uninstallation
 Receive:   -none-
 Return:	-none-
 Since:		2.4.2
-------------------------------------------------------------*/
function adrotate_uninstall() {
    adrotate_network_propagate('adrotate_uninstall_setup', $network_wide);
}

/*-------------------------------------------------------------
 Name:      adrotate_uninstall_setup

 Purpose:   Delete the entire AdRotate database and remove the options on uninstall
 Receive:   -none-
 Return:	-none-
 Since:		2.4.2
-------------------------------------------------------------*/
function adrotate_uninstall_setup() {
	global $wpdb, $wp_roles;

	// Clean up roles and scheduled tasks
	adrotate_deactivate_setup();

	// Drop MySQL Tables
	$wpdb->query("DROP TABLE IF EXISTS `".$wpdb->prefix."adrotate`");
	$wpdb->query("DROP TABLE IF EXISTS `".$wpdb->prefix."adrotate_groups`");
	$wpdb->query("DROP TABLE IF EXISTS `".$wpdb->prefix."adrotate_tracker`");
	$wpdb->query("DROP TABLE IF EXISTS `".$wpdb->prefix."adrotate_blocks`"); // Obsolete in 3.9.10
	$wpdb->query("DROP TABLE IF EXISTS `".$wpdb->prefix."adrotate_linkmeta`");
	$wpdb->query("DROP TABLE IF EXISTS `".$wpdb->prefix."adrotate_stats`");
	$wpdb->query("DROP TABLE IF EXISTS `".$wpdb->prefix."adrotate_schedule`");

	// De-activate License
	adrotate_license_deactivate_uninstall();
	
	// Delete Options	
	delete_option('adrotate_active');
	delete_option('adrotate_advert_status');
	delete_option('adrotate_config');
	delete_option('adrotate_crawlers');
	delete_option('adrotate_db_timer');
	delete_option('adrotate_db_version');
	delete_option('adrotate_debug');
	delete_option('adrotate_hide_license');
	delete_option('adrotate_notifications');
	delete_option('adrotate_geo_required');
	delete_option('adrotate_responsive_required');
	delete_option('adrotate_dynamic_required');
	delete_option('adrotate_roles');
	delete_option('adrotate_server'); // Obsolete in 3.12.3
	delete_option('adrotate_server_hide'); // Obsolete in 3.12.3
	delete_option('adrotate_version');
	delete_site_option('adrotate_multisite'); // Obsolete in 3.11.8

	// Clear out userroles
	remove_role('adrotate_advertiser');
}

/*-------------------------------------------------------------
 Name:      adrotate_network_propagate

 Purpose:   Check how many sites use AdRotate
 Receive:   -none-
 Return:    -none-
 Since:		3.9.9
-------------------------------------------------------------*/
function adrotate_network_propagate($pfunction, $network_wide) {
    global $wpdb;
 
    if(is_multisite() && $network_wide) {
        $current_blog = $wpdb->blogid;
        // Get all blog ids
        $blogids = $wpdb->get_col("SELECT `blog_id` FROM $wpdb->blogs;");
        foreach ($blogids as $blog_id) {
            switch_to_blog($blog_id);
            call_user_func($pfunction, $network_wide);
        }
        switch_to_blog($current_blog);
        return;
    } 
    call_user_func($pfunction, $network_wide);
}

/*-------------------------------------------------------------
 Name:      adrotate_check_upgrade

 Purpose:   Checks if the plugin needs to upgrade stuff upon activation
 Receive:   -none-
 Return:	-none-
 Since:		3.7.3
-------------------------------------------------------------*/
function adrotate_check_upgrade() {
	global $wpdb, $current_user, $userdata;

	if(version_compare(PHP_VERSION, '5.3.0', '<') == -1) { 
		deactivate_plugins(plugin_basename('adrotate-pro/adrotate.php'));
		wp_die('AdRotate 3.10.8 and up requires PHP 5.3 or higher. You have version '.PHP_VERSION.'. Contact your hosting provider about upgrading your server!<br /><a href="'. get_option('siteurl').'/wp-admin/plugins.php">Back to plugins</a>.'); 
		return; 
	} else {
		$adrotate_db_version = get_option("adrotate_db_version");
		$adrotate_version = get_option("adrotate_version");
	
		// Check if there are tables with AdRotate in the name
		if($wpdb->get_var("SHOW TABLES LIKE '".$wpdb->prefix."adrotate%';")) {
			// Old version? Upgrade
			if(is_array($adrotate_db_version) AND $adrotate_db_version['current'] < ADROTATE_DB_VERSION) {
				adrotate_database_upgrade();
				// Verify all ads
				adrotate_prepare_evaluate_ads(false);
			}
		} else {
			// Install new database
			adrotate_database_install();

			// Insert initial data
			$now 			= adrotate_now();
			$in84days 		= $now + 7257600;
			$wpdb->insert($wpdb->prefix.'adrotate_schedule', array('name' => 'Schedule 1', 'starttime' => $now, 'stoptime' => $in84days, 'maxclicks' => 0, 'maximpressions' => 0, 'spread' => 'N', 'dayimpressions' => 0));
		    $schedule_id = $wpdb->insert_id;
	
			// Demo ad 1
		    $wpdb->insert($wpdb->prefix."adrotate", array('title' => 'Demo ad 468x60', 'bannercode' => '&lt;a href=\&quot;https:\/\/ajdg.solutions\/products\/adrotate-for-wordpress\/\&quot;&gt;&lt;img src=\&quot;http://ajdg.solutions/assets/dummy-banners/adrotate-468x60.jpg\&quot; /&gt;&lt;/a&gt;', 'thetime' => $now, 'updated' => $now, 'author' => $current_user->user_login, 'imagetype' => '', 'image' => '', 'link' => '', 'tracker' => 'N', 'responsive' => 'N', 'type' => 'active', 'weight' => 6, 'sortorder' => 0, 'cbudget' => 0, 'ibudget' => 0, 'crate' => 0, 'irate' => 0, 'cities' => serialize(array()), 'countries' => serialize(array())));
		    $ad_id = $wpdb->insert_id;
			$wpdb->insert($wpdb->prefix.'adrotate_linkmeta', array('ad' => $ad_id, 'group' => 0, 'block' => 0, 'user' => 0, 'schedule' => $schedule_id));
			unset($ad_id);
	
			// Demo ad 2
		    $wpdb->insert($wpdb->prefix."adrotate", array('title' => 'Demo ad 200x200', 'bannercode' => '&lt;a href=\&quot;https:\/\/ajdg.solutions\/products\/adrotate-for-wordpress\/\&quot;&gt;&lt;img src=\&quot;http://ajdg.solutions/assets/dummy-banners/adrotate-200x200.jpg\&quot; /&gt;&lt;/a&gt;', 'thetime' => $now, 'updated' => $now, 'author' => $current_user->user_login, 'imagetype' => '', 'image' => '', 'link' => '', 'tracker' => 'N', 'responsive' => 'N', 'type' => 'active', 'weight' => 6, 'sortorder' => 0, 'cbudget' => 0, 'ibudget' => 0, 'crate' => 0, 'irate' => 0, 'cities' => serialize(array()), 'countries' => serialize(array())));
		    $ad_id = $wpdb->insert_id;
			$wpdb->insert($wpdb->prefix.'adrotate_linkmeta', array('ad' => $ad_id, 'group' => 0, 'block' => 0, 'user' => 0, 'schedule' => $schedule_id));
			unset($ad_id, $schedule_id);
		}
	
		// Check if there are changes to core that need upgrading
		if(is_array($adrotate_version) AND $adrotate_version['current'] < ADROTATE_VERSION) {
			adrotate_core_upgrade();
		}
	}
}

/*-------------------------------------------------------------
 Name:      adrotate_check_config

 Purpose:   Default options for AdRotate
 Receive:   -none-
 Return:    -none-
 Since:		0.1
-------------------------------------------------------------*/
function adrotate_check_config() {
	
	$config = get_option('adrotate_config');
	$notifications = get_option('adrotate_notifications');
	$crawlers = get_option('adrotate_crawlers');
	$debug = get_option('adrotate_debug');

	if(!isset($config)) $config = array();
	if(!isset($notifications)) $notifications = array();
	if(!isset($crawlers)) $crawlers = array();
	if(!isset($debug)) $debug = array();
	
	if(!isset($config['advertiser'])) $config['advertiser'] = 'subscriber';
	if(!isset($config['global_report'])) $config['global_report'] = 'administrator';
	if(!isset($config['ad_manage'])) $config['ad_manage'] = 'administrator';
	if(!isset($config['ad_delete'])) $config['ad_delete'] = 'administrator';
	if(!isset($config['group_manage'])) $config['group_manage'] = 'administrator';
	if(!isset($config['group_delete'])) $config['group_delete'] = 'administrator';
	if(!isset($config['schedule_manage'])) $config['schedule_manage'] = 'administrator';
	if(!isset($config['schedule_delete'])) $config['schedule_delete'] = 'administrator';
	if(!isset($config['moderate'])) $config['moderate'] = 'administrator';
	if(!isset($config['moderate_approve'])) $config['moderate_approve'] = 'administrator';
	if(!isset($config['enable_advertisers']) OR ($config['enable_advertisers'] != 'Y' AND $config['enable_advertisers'] != 'N')) $config['enable_advertisers'] = 'N';
	if(!isset($config['enable_editing']) OR ($config['enable_editing'] != 'Y' AND $config['enable_editing'] != 'N')) $config['enable_editing'] = 'N';
	if(!isset($config['enable_stats']) OR ($config['enable_stats'] != 'Y' AND $config['enable_stats'] != 'N')) $config['enable_stats'] = 'Y';
	if(!isset($config['enable_loggedin_impressions']) OR ($config['enable_loggedin_impressions'] != 'Y' AND $config['enable_loggedin_impressions'] != 'N')) $config['enable_loggedin_impressions'] = 'Y';
	if(!isset($config['enable_loggedin_clicks']) OR ($config['enable_loggedin_clicks'] != 'Y' AND $config['enable_loggedin_clicks'] != 'N')) $config['enable_loggedin_clicks'] = 'Y';
	if(!isset($config['enable_geo'])) $config['enable_geo'] = 0;
	if(!isset($config['geo_email'])) $config['geo_email'] = '';
	if(!isset($config['geo_pass'])) $config['geo_pass'] = '';
	if(!isset($config['geo_cookie_life'])) $config['geo_cookie_life'] = 86400;
	if(!isset($config['enable_geo_advertisers'])) $config['enable_geo_advertisers'] = 0;
	if(!isset($config['banner_folder'])) $config['banner_folder'] = "wp-content/banners/";
	if(!isset($config['adminbar']) OR ($config['adminbar'] != 'Y' AND $config['adminbar'] != 'N')) $config['adminbar'] = 'Y';
	if(!isset($config['dashboard_notifications']) OR ($config['dashboard_notifications'] != 'Y' AND $config['dashboard_notifications'] != 'N')) $config['dashboard_notifications'] = 'Y';
	if(!isset($config['impression_timer']) OR $config['impression_timer'] < 10 OR $config['impression_timer'] > 3600) $config['impression_timer'] = 60;
	if(!isset($config['click_timer']) OR $config['click_timer'] < 60 OR $config['click_timer'] > 86400) $config['click_timer'] = 86400;
	if(!isset($config['hide_schedules']) OR ($config['hide_schedules'] != 'Y' AND $config['hide_schedules'] != 'N')) $config['hide_schedules'] = 'N';
	if(!isset($config['widgetalign']) OR ($config['widgetalign'] != 'Y' AND $config['widgetalign'] != 'N')) $config['widgetalign'] = 'N';
	if(!isset($config['widgetpadding']) OR ($config['widgetpadding'] != 'Y' AND $config['widgetpadding'] != 'N')) $config['widgetpadding'] = 'N';
	if(!isset($config['w3caching']) OR ($config['w3caching'] != 'Y' AND $config['w3caching'] != 'N')) $config['w3caching'] = 'N';
	if(!isset($config['supercache']) OR ($config['supercache'] != 'Y' AND $config['supercache'] != 'N')) $config['supercache'] = 'N';
	if(!isset($config['jquery']) OR ($config['jquery'] != 'Y' AND $config['jquery'] != 'N')) $config['jquery'] = 'N';
	if(!isset($config['jsfooter']) OR ($config['jsfooter'] != 'Y' AND $config['jsfooter'] != 'N')) $config['jsfooter'] = 'Y';
	if(!isset($config['adblock']) OR ($config['adblock'] != 'Y' AND $config['adblock'] != 'N')) $config['adblock'] = 'N';
	if(!isset($config['adblock_timer']) OR $config['adblock_timer'] < 0 OR $config['adblock_timer'] > 20) $config['adblock_timer'] = 5;
	if(!isset($config['adblock_message'])) $config['adblock_message'] = "Ad blocker detected! Please wait %time% seconds or disable your ad blocker!";
	if(!isset($config['adblock_loggedin']) OR ($config['adblock_loggedin'] != 'Y' AND $config['adblock_loggedin'] != 'N')) $config['adblock_loggedin'] = "N";
	update_option('adrotate_config', $config);

	if(!isset($notifications['notification_push']) OR ($notifications['notification_push'] != 'Y' AND $notifications['notification_push'] != 'N')) $notifications['notification_push'] = 'N';
	if(!isset($notifications['notification_email']) OR ($notifications['notification_email'] != 'Y' AND $notifications['notification_email'] != 'N')) $notifications['notification_email'] = 'Y';

	if(!isset($notifications['notification_push_geo']) OR ($notifications['notification_push_geo'] != 'Y' AND $notifications['notification_push_geo'] != 'N')) $notifications['notification_push_geo'] = 'N';
	if(!isset($notifications['notification_push_status']) OR ($notifications['notification_push_status'] != 'Y' AND $notifications['notification_push_status'] != 'N')) $notifications['notification_push_status'] = 'N';
	if(!isset($notifications['notification_push_queue']) OR ($notifications['notification_push_queue'] != 'Y' AND $notifications['notification_push_queue'] != 'N')) $notifications['notification_push_queue'] = 'N';
	if(!isset($notifications['notification_push_approved']) OR ($notifications['notification_push_approved'] != 'Y' AND $notifications['notification_push_approved'] != 'N')) $notifications['notification_push_approved'] = 'N';
	if(!isset($notifications['notification_push_rejected']) OR ($notifications['notification_push_rejected'] != 'Y' AND $notifications['notification_push_rejected'] != 'N')) $notifications['notification_push_rejected'] = 'N';
	if(!isset($notifications['notification_push_user'])) $notifications['notification_push_user'] = '';
	if(!isset($notifications['notification_push_api'])) $notifications['notification_push_api'] = '';
	if(!isset($notifications['notification_push_advertisers']) OR ($notifications['notification_push_advertisers'] != 'Y' AND $notifications['notification_push_advertisers'] != 'N')) $notifications['notification_push_advertisers'] = 'N';

	if(!isset($notifications['notification_email_switch']) OR $notifications['notification_email_switch'] != 'Y' AND $notifications['notification_email_switch'] != 'N') $notifications['notification_email_switch'] = 'Y';
	if(!isset($notifications['notification_email_publisher'])) $notifications['notification_email_publisher'] = array(get_option('admin_email'));
	if(!isset($notifications['notification_email_advertiser'])) $notifications['notification_email_advertiser'] = array(get_option('admin_email'));
	update_option('adrotate_notifications', $notifications);

	if(!isset($crawlers) OR count($crawlers) < 1) $crawlers = array("008", "ABACHOBot", "Accoona-AI-Agent", "AddSugarSpiderBot", "alexa", "AnyApexBot", "Arachmo", "B-l-i-t-z-B-O-T", "Baiduspider", "BecomeBot", "BeslistBot","BillyBobBot", "Bimbot", "Bingbot", "BlitzBOT", "boitho.com-dc", "boitho.com-robot", "btbot", "CatchBot", "Cerberian Drtrs","Charlotte", "ConveraCrawler", "cosmos", "Covario IDS", "DataparkSearch", "DiamondBot", "Discobot", "Dotbot", "EmeraldShield.com WebBot", "envolk[ITS]spider", "EsperanzaBot", "Exabot", "FAST Enterprise Crawler", "FAST-WebCrawler", "FDSE robot","FindLinks", "FurlBot", "FyberSpider", "g2crawler", "Gaisbot", "GalaxyBot", "genieBot", "Gigabot", "Girafabot", "Googlebot", "Googlebot-Image", "GurujiBot", "HappyFunBot", "hl_ftien_spider", "Holmes", "htdig", "iaskspider", "ia_archiver", "iCCrawler", "ichiro", "inktomi", "igdeSpyder", "IRLbot", "IssueCrawler", "Jaxified Bot", "Jyxobot", "KoepaBot", "L.webis", "LapozzBot", "Larbin", "LDSpider", "LexxeBot", "Linguee Bot", "LinkWalker", "lmspider", "lwp-trivial", "mabontland", "magpie-crawler", "Mediapartners-Google", "MJ12bot", "Mnogosearch", "mogimogi", "MojeekBot", "Moreoverbot", "Morning Paper", "msnbot", "MSRBot", "MVAClient", "mxbot", "NetResearchServer", "NetSeer Crawler", "NewsGator", "NG-Search", "nicebot", "noxtrumbot", "Nusearch Spider", "NutchCVS", "Nymesis", "obot", "oegp", "omgilibot", "OmniExplorer_Bot", "OOZBOT", "Orbiter", "PageBitesHyperBot", "Peew", "polybot", "Pompos", "PostPost", "Psbot", "PycURL", "Qseero", "Radian6", "RAMPyBot", "RufusBot", "SandCrawler", "SBIder", "ScoutJet", "Scrubby", "SearchSight", "Seekbot", "semanticdiscovery", "Sensis Web Crawler", "SEOChat::Bot", "SeznamBot", "Shim-Crawler", "ShopWiki", "Shoula robot", "silk", "Sitebot", "Snappy", "sogou spider", "Sosospider", "Speedy Spider", "Sqworm", "StackRambler", "suggybot", "SurveyBot", "SynooBot", "Teoma", "TerrawizBot", "TheSuBot", "Thumbnail.CZ robot", "TinEye", "truwoGPS", "TurnitinBot", "TweetedTimes Bot", "TwengaBot", "updated", "Urlfilebot", "Vagabondo", "VoilaBot", "Vortex", "voyager", "VYU2", "webcollage", "Websquash.com", "wf84", "WoFindeIch Robot", "WomlpeFactory", "Xaldon_WebSpider", "yacy", "Yahoo! Slurp", "Yahoo! Slurp China", "YahooSeeker", "YahooSeeker-Testing", "YandexBot", "YandexImages", "Yasaklibot", "Yeti", "YodaoBot", "yoogliFetchAgent", "YoudaoBot", "Zao", "Zealbot", "zspider", "ZyBorg", "crawler", "bot", "froogle","looksmart", "URL_Spider_SQL", "Firefly", "NationalDirectory", "Ask Jeeves", "TECNOSEEK", "InfoSeek", "WebFindBot", "Googlebot", "Scooter", "appie", "WebBug", "Spade", "rabaz", "Feedfetcher-Google", "TechnoratiSnoop", "Rankivabot", "Mediapartners-Google", "Sogou web spider", "WebAlta Crawler");
	update_option('adrotate_crawlers', $crawlers);

	if(!isset($debug['general'])) $debug['general'] = false;
	if(!isset($debug['dashboard'])) $debug['dashboard'] = false;
	if(!isset($debug['userroles'])) $debug['userroles'] = false;
	if(!isset($debug['userstats'])) $debug['userstats'] = false;
	if(!isset($debug['stats'])) $debug['stats'] = false;
	if(!isset($debug['geo'])) $debug['geo'] = false;
	if(!isset($debug['timers'])) $debug['timers'] = false;
	if(!isset($debug['track'])) $debug['track'] = false;
	update_option('adrotate_debug', $debug);

}

/*-------------------------------------------------------------
 Name:      adrotate_database_install

 Purpose:   Creates database table if it doesnt exist
 Receive:   -none-
 Return:	-none-
 Since:		3.0.3
-------------------------------------------------------------*/
function adrotate_database_install() {
	global $wpdb;

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

	$tables = adrotate_list_tables();

	if($wpdb->has_cap('collation')) {
		if(!empty($wpdb->charset)) {
			$charset_collate = " DEFAULT CHARACTER SET $wpdb->charset";
		} 
		if(!empty($wpdb->collate)) {
			$charset_collate .= " COLLATE $wpdb->collate";
		}
	}

	$engine = '';
	$found_engine = $wpdb->get_var("SELECT ENGINE FROM `information_schema`.`TABLES` WHERE `TABLE_SCHEMA` = '".DB_NAME."' AND `TABLE_NAME` = '".$wpdb->prefix."posts';");
	if(strtolower($found_engine) == 'innodb') {
		$engine = ' ENGINE=InnoDB';
	}

	dbDelta("CREATE TABLE IF NOT EXISTS `".$tables['adrotate']."` (
		  	`id` mediumint(8) unsigned NOT NULL auto_increment,
		  	`title` varchar(255) NOT NULL DEFAULT '',
		  	`bannercode` longtext NOT NULL,
		  	`thetime` int(15) NOT NULL default '0',
			`updated` int(15) NOT NULL,
		  	`author` varchar(60) NOT NULL default '',
		  	`imagetype` varchar(10) NOT NULL,
		  	`image` varchar(255) NOT NULL,
		  	`link` longtext NOT NULL,
		  	`tracker` varchar(5) NOT NULL default 'N',
		  	`responsive` varchar(5) NOT NULL default 'N',
		  	`type` varchar(10) NOT NULL default '0',
		  	`weight` int(3) NOT NULL default '6',
			`sortorder` int(5) NOT NULL default '0',
		  	`cbudget` double NOT NULL default '0',
		  	`ibudget` double NOT NULL default '0',
		  	`crate` double NOT NULL default '0',
		  	`irate` double NOT NULL default '0',
			`cities` text NOT NULL,
			`countries` text NOT NULL,
  		PRIMARY KEY  (`id`)
		) ".$charset_collate.$engine.";");

	dbDelta("CREATE TABLE IF NOT EXISTS `".$tables['adrotate_groups']."` (
			`id` mediumint(8) unsigned NOT NULL auto_increment,
			`name` varchar(255) NOT NULL default '',
			`modus` tinyint(1) NOT NULL default '0',
			`fallback` varchar(5) NOT NULL default '0',
			`sortorder` int(5) NOT NULL default '0',
			`cat` longtext NOT NULL,
			`cat_loc` tinyint(1) NOT NULL default '0',
			`cat_par` tinyint(2) NOT NULL default '0',
			`page` longtext NOT NULL,
			`page_loc` tinyint(1) NOT NULL default '0',
			`page_par` tinyint(2) NOT NULL default '0',
			`geo` tinyint(1) NOT NULL default '0',
			`wrapper_before` longtext NOT NULL,
			`wrapper_after` longtext NOT NULL,
			`align` tinyint(1) NOT NULL default '0',
			`gridrows` int(3) NOT NULL DEFAULT '2',
			`gridcolumns` int(3) NOT NULL DEFAULT '2',
			`admargin` int(2) NOT NULL DEFAULT '0',
			`admargin_bottom` int(2) NOT NULL DEFAULT '0',
			`admargin_left` int(2) NOT NULL DEFAULT '0',
			`admargin_right` int(2) NOT NULL DEFAULT '0',
			`adwidth` varchar(6) NOT NULL DEFAULT '125',
			`adheight` varchar(6) NOT NULL DEFAULT '125',
			`adspeed` int(5) NOT NULL DEFAULT '6000',
			PRIMARY KEY  (`id`)
		) ".$charset_collate.$engine.";");

	dbDelta("CREATE TABLE IF NOT EXISTS `".$tables['adrotate_linkmeta']."` (
			`id` mediumint(8) unsigned NOT NULL auto_increment,
			`ad` int(5) NOT NULL default '0',
			`group` int(5) NOT NULL default '0',
			`block` int(5) NOT NULL default '0',
			`user` int(5) NOT NULL default '0',
			`schedule` int(5) NOT NULL default '0',
			PRIMARY KEY  (`id`),
		    KEY `schedule` (`schedule`),
		    KEY `ad` (`ad`)
		) ".$charset_collate.$engine.";");

	dbDelta("CREATE TABLE IF NOT EXISTS `".$tables['adrotate_schedule']."` (
			`id` int(8) unsigned NOT NULL auto_increment,
			`name` varchar(255) NOT NULL default '',
			`starttime` int(15) NOT NULL default '0',
			`stoptime` int(15) NOT NULL default '0',
			`maxclicks` int(15) NOT NULL default '0',
			`maximpressions` int(15) NOT NULL default '0',
		  	`spread` varchar(5) NOT NULL default 'N',
		  	`dayimpressions` int(15) NOT NULL default '0',
			PRIMARY KEY  (`id`),
		    KEY `starttime` (`starttime`),
		    KEY `stoptime` (`stoptime`)
		) ".$charset_collate.$engine.";");

	dbDelta("CREATE TABLE IF NOT EXISTS `".$tables['adrotate_stats']."` (
			`id` bigint(9) unsigned NOT NULL auto_increment,
			`ad` int(5) NOT NULL default '0',
			`group` int(5) NOT NULL default '0',
			`block` int(5) NOT NULL default '0',
			`thetime` int(15) NOT NULL default '0',
			`clicks` int(15) NOT NULL default '0',
			`impressions` int(15) NOT NULL default '0',
			PRIMARY KEY  (`id`),
			INDEX `ad` (`ad`),
			INDEX `group` (`group`)
		) ".$charset_collate.$engine.";");

	dbDelta("CREATE TABLE IF NOT EXISTS `".$tables['adrotate_tracker']."` (
			`id` bigint(9) unsigned NOT NULL auto_increment,
			`ipaddress` varchar(255) NOT NULL default '0',
			`timer` int(15) NOT NULL default '0',
			`bannerid` int(15) NOT NULL default '0',
			`stat` char(1) NOT NULL default 'c',
			`useragent` mediumtext NOT NULL,
			`country` text NOT NULL,
			`city` text NOT NULL,
			PRIMARY KEY  (`id`),
		    KEY `ipaddress` (`ipaddress`),
		    KEY `timer` (`timer`)
		) ".$charset_collate.$engine.";");
}

/*-------------------------------------------------------------
 Name:      adrotate_database_upgrade

 Purpose:   Upgrades AdRotate where required
 Receive:   -none-
 Return:	-none-
 Since:		3.0.3
-------------------------------------------------------------*/
function adrotate_database_upgrade() {
	global $wpdb;

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

	$tables = adrotate_list_tables();

	$adrotate_db_version = get_option("adrotate_db_version");

	// Database: 	24
	// AdRotate:	3.8b412
	if($adrotate_db_version['current'] < 24) {
		if($wpdb->get_var("SHOW TABLES LIKE '".$wpdb->prefix."adrotate_stats_tracker'")) {
			$wpdb->query("RENAME TABLE `".$wpdb->prefix."adrotate_stats_tracker` TO `".$wpdb->prefix."adrotate_stats`;");
		}
		adrotate_del_column($tables['adrotate_blocks'], 'gridborder');
		adrotate_del_column($tables['adrotate_blocks'], 'adpadding');
	}

	// Database: 	25
	// AdRotate:	3.8b413
	if($adrotate_db_version['current'] < 25) {
		$wpdb->query("CREATE INDEX `timer` ON `".$tables['adrotate_tracker']."` (timer);");
		$wpdb->query("CREATE INDEX `ipaddress` ON `".$tables['adrotate_tracker']."` (ipaddress);");
		$wpdb->query("CREATE INDEX `ad` ON `".$tables['adrotate_stats']."` (ad);");
		$wpdb->query("CREATE INDEX `thetime` ON `".$tables['adrotate_stats']."` (thetime);");
		$wpdb->query("CREATE INDEX `ad` ON `".$tables['adrotate_schedule']."` (ad);");
	}

	// Database: 	26
	// AdRotate:	3.8.1
	if($adrotate_db_version['current'] < 26) {
		adrotate_add_column($tables['adrotate'], 'cbudget', 'double NOT NULL default \'0\' AFTER `sortorder`');
		adrotate_add_column($tables['adrotate'], 'ibudget', 'double NOT NULL default \'0\' AFTER `cbudget`');
		adrotate_add_column($tables['adrotate'], 'crate', 'double NOT NULL default \'0\' AFTER `ibudget`');
		adrotate_add_column($tables['adrotate'], 'irate', 'double NOT NULL default \'0\' AFTER `crate`');
	}

	// Database: 	27
	// AdRotate:	3.8.3.1
	if($adrotate_db_version['current'] < 27) {
		$wpdb->query("ALTER TABLE `".$tables['adrotate_blocks']."` CHANGE `adwidth` `adwidth` varchar(6)  NOT NULL  DEFAULT '125';");
		$wpdb->query("ALTER TABLE `".$tables['adrotate_blocks']."` CHANGE `adheight` `adheight` varchar(6)  NOT NULL  DEFAULT '125';");
	}

	// Database: 	30
	// AdRotate:	3.8.3.4
	if($adrotate_db_version['current'] < 30) {
		adrotate_add_column($tables['adrotate_groups'], 'wrapper_before', 'longtext NOT NULL AFTER `page_loc`');
		adrotate_add_column($tables['adrotate_groups'], 'wrapper_after', 'longtext NOT NULL AFTER `wrapper_before`');
	}

	// Database: 	31
	// AdRotate:	3.8.5
	if($adrotate_db_version['current'] < 31) {
		adrotate_add_column($tables['adrotate_groups'], 'token', 'varchar(10) NOT NULL default \'0\' AFTER `name`');
	}

	// Database: 	32
	// AdRotate:	3.8.6
	if($adrotate_db_version['current'] < 32) {
		adrotate_add_column($tables['adrotate'], 'cities', 'text NOT NULL AFTER `irate`');
		adrotate_add_column($tables['adrotate'], 'countries', 'text NOT NULL AFTER `cities`');
		$geo_array = serialize(array());
		$wpdb->query("UPDATE `".$tables['adrotate']."` SET `cities` = '$geo_array' WHERE `cities` = '';");
		$wpdb->query("UPDATE `".$tables['adrotate']."` SET `countries` = '$geo_array' WHERE `countries` = '';");
		adrotate_add_column($tables['adrotate_groups'], 'geo', 'tinyint(1) NOT NULL default \'0\' AFTER `page_loc`');
	}

	// Database: 	33
	// AdRotate:	3.8.8
	if($adrotate_db_version['current'] < 33) {
		adrotate_del_column($tables['adrotate_groups'], 'token');
		adrotate_add_column($tables['adrotate_groups'], 'modus', 'tinyint(1) NOT NULL default \'0\' AFTER `name`');
		adrotate_add_column($tables['adrotate_groups'], 'gridrows', 'int(3) NOT NULL default \'2\' AFTER `wrapper_after`');
		adrotate_add_column($tables['adrotate_groups'], 'gridcolumns', 'int(3) NOT NULL default \'2\' AFTER `gridrows`');
		adrotate_add_column($tables['adrotate_groups'], 'admargin', 'int(3) NOT NULL default \'1\' AFTER `gridcolumns`');
		adrotate_add_column($tables['adrotate_groups'], 'adwidth', 'varchar(4) NOT NULL default \'125\' AFTER `admargin`');
		adrotate_add_column($tables['adrotate_groups'], 'adheight', 'varchar(4) NOT NULL default \'125\' AFTER `adwidth`');
		adrotate_add_column($tables['adrotate_groups'], 'adspeed', 'int(5) NOT NULL default \'6000\' AFTER `adheight`');
	}

	// Database: 	36
	// AdRotate:	3.8.14
	if($adrotate_db_version['current'] < 36) {
		adrotate_add_column($tables['adrotate_groups'], 'admargin_bottom', 'int(3) NOT NULL default \'1\' AFTER `admargin`');
		adrotate_add_column($tables['adrotate_groups'], 'admargin_left', 'int(3) NOT NULL default \'1\' AFTER `admargin_bottom`');
		adrotate_add_column($tables['adrotate_groups'], 'admargin_right', 'int(3) NOT NULL default \'1\' AFTER `admargin_left`');
	}

	// Database: 	37
	// AdRotate:	3.9
	if($adrotate_db_version['current'] < 37) {
		adrotate_add_column($tables['adrotate_linkmeta'], 'schedule', 'int(5) NOT NULL default \'0\' AFTER `user`');
		$schedules = $wpdb->get_results("SELECT `id`, `ad` FROM ".$tables['adrotate_schedule']." ORDER BY `id` ASC;");
		foreach($schedules as $schedule) {
			$wpdb->insert($tables['adrotate_linkmeta'], array('ad' => $schedule->ad, 'group' => 0, 'block' => 0, 'user' => 0, 'schedule' => $schedule->id), array('%d', '%d', '%d', '%d', '%d'));
			unset($schedule);
		}
		unset($schedules);
		adrotate_add_column($tables['adrotate_schedule'], 'name', 'varchar(255) NOT NULL default \'\' AFTER `id`');
		adrotate_del_column($tables['adrotate_schedule'], 'ad');
	}

	// Database: 	38
	// AdRotate:	3.9.1
	if($adrotate_db_version['current'] < 38) {
		$schedules = $wpdb->get_results("SELECT `id` FROM ".$tables['adrotate_schedule']." WHERE `name` = '' ORDER BY `id` ASC;");
		foreach($schedules as $schedule) {
			$wpdb->update($tables['adrotate_schedule'], array('name' => 'Schedule '.$schedule->id), array('id' => $schedule->id));
			unset($schedule);
		}
		unset($schedules);
	}

	// Database: 	39
	// AdRotate:	3.9.2
	if($adrotate_db_version['current'] < 39) {
		adrotate_add_column($tables['adrotate_tracker'], 'country', 'text NOT NULL AFTER `useragent`');
		adrotate_add_column($tables['adrotate_tracker'], 'city', 'text NOT NULL AFTER `country`');
	}

	// Database: 	40
	// AdRotate:	3.9.9
	if($adrotate_db_version['current'] < 40) {
		adrotate_add_column($tables['adrotate'], 'responsive', 'varchar(5) NOT NULL default \'N\' AFTER `tracker`');
	}

	// Database: 	41
	// AdRotate:	3.9.12
	if($adrotate_db_version['current'] < 41) {
		adrotate_add_column($tables['adrotate_groups'], 'page_par', 'tinyint(1) NOT NULL default \'0\' AFTER `page_loc`');
		adrotate_add_column($tables['adrotate_groups'], 'cat_par', 'tinyint(1) NOT NULL default \'0\' AFTER `cat_loc`');
	}

	// Database: 	42
	// AdRotate:	3.10
	if($adrotate_db_version['current'] < 42) {
		adrotate_add_column($tables['adrotate_schedule'], 'spread', 'varchar(5) NOT NULL default \'N\' AFTER `maximpressions`');
		adrotate_add_column($tables['adrotate_schedule'], 'hourimpressions', 'int(15) NOT NULL default \'0\' AFTER `spread`');
		$wpdb->query("ALTER TABLE `".$tables['adrotate_groups']."` CHANGE `page_par` `page_par` tinyint(2) NOT NULL default '0';");
		$wpdb->query("ALTER TABLE `".$tables['adrotate_groups']."` CHANGE `cat_par` `cat_par` tinyint(2) NOT NULL default '0';");
	}

	// Database: 	43
	// AdRotate:	3.10.7
	if($adrotate_db_version['current'] < 43) {
		$wpdb->query("ALTER TABLE `".$tables['adrotate_groups']."` CHANGE `admargin` `admargin` int(2) NOT NULL default '0';");
		$wpdb->query("ALTER TABLE `".$tables['adrotate_groups']."` CHANGE `admargin_bottom` `admargin_bottom` int(2) NOT NULL default '0';");
		$wpdb->query("ALTER TABLE `".$tables['adrotate_groups']."` CHANGE `admargin_left` `admargin_left` int(2) NOT NULL default '0';");
		$wpdb->query("ALTER TABLE `".$tables['adrotate_groups']."` CHANGE `admargin_right` `admargin_right` int(2) NOT NULL default '0';");
	}

	// Database: 	44
	// AdRotate:	3.10.8
	if($adrotate_db_version['current'] < 44) {
		adrotate_del_column($tables['adrotate'], 'timeframe');
		adrotate_del_column($tables['adrotate'], 'timeframelength');
		adrotate_del_column($tables['adrotate'], 'timeframeclicks');
		adrotate_del_column($tables['adrotate'], 'timeframeimpressions');
	}

	// Database: 	45
	// AdRotate:	3.10.11
	if($adrotate_db_version['current'] < 45) {
		if($wpdb->get_var("SHOW INDEX FROM `".$tables['adrotate_tracker']."` WHERE Key_name = 'bannerid';") === null) {
			$wpdb->query("CREATE INDEX `bannerid` ON `".$tables['adrotate_tracker']."` (bannerid);");
		}
		if($wpdb->get_var("SHOW INDEX FROM `".$tables['adrotate_linkmeta']."` WHERE Key_name = 'schedule';") === null) {
			$wpdb->query("CREATE INDEX `schedule` ON `".$tables['adrotate_linkmeta']."` (schedule);");
		}
		if($wpdb->get_var("SHOW INDEX FROM `".$tables['adrotate_stats']."` WHERE Key_name = 'starttime';") === null) {
			$wpdb->query("CREATE INDEX `starttime` ON `".$tables['adrotate_schedule']."` (starttime);");
		}
		if($wpdb->get_var("SHOW INDEX FROM `".$tables['adrotate_stats']."` WHERE Key_name = 'stoptime';") === null) {
			$wpdb->query("CREATE INDEX `stoptime` ON `".$tables['adrotate_schedule']."` (stoptime);");
		}
		if($wpdb->get_var("SHOW INDEX FROM `".$tables['adrotate_stats']."` WHERE Key_name = 'thetime';") === null) {
			$wpdb->query("CREATE INDEX `thetime` ON `".$tables['adrotate_stats']."` (thetime);");
		}
	}

	// Database: 	46
	// AdRotate:	3.11.3
	if($adrotate_db_version['current'] < 46) {
		$wpdb->query("ALTER TABLE `".$tables['adrotate_schedule']."` CHANGE `hourimpressions` `dayimpressions` int(15) NOT NULL default '0';");
	}

	// Database: 	47
	// AdRotate:	3.11.8
	if($adrotate_db_version['current'] < 47) {
		adrotate_add_column($tables['adrotate_groups'], 'align', 'tinyint(1) NOT NULL default \'0\' AFTER `wrapper_after`');
	}

	update_option("adrotate_db_version", array('current' => ADROTATE_DB_VERSION, 'previous' => $adrotate_db_version['current']));
}

/*-------------------------------------------------------------
 Name:      adrotate_core_upgrade

 Purpose:   Upgrades AdRotate where required
 Receive:   -none-
 Return:	-none-
 Since:		3.5
-------------------------------------------------------------*/
function adrotate_core_upgrade() {
	global $wpdb, $wp_roles;

	$firstrun = date('U') + 3600;

	$adrotate_version = get_option("adrotate_version");
	// Legacy compatibility (Support 3.7.4 and older)
	if(!is_array($adrotate_version)) $adrotate_version = array('current' => $adrotate_version, 'previous' => 0);

	if($adrotate_version['current'] < 323) {
		delete_option('adrotate_notification_timer');
	}
	
	if($adrotate_version['current'] < 340) {
		add_option('adrotate_db_timer', date('U'));
	}

	if($adrotate_version['current'] < 350) {
		update_option('adrotate_debug', array('general' => false, 'dashboard' => false, 'userroles' => false, 'userstats' => false, 'stats' => false));
	}

	if($adrotate_version['current'] < 351) {
		wp_clear_scheduled_hook('adrotate_prepare_cache_statistics');
		delete_option('adrotate_stats');
	}

	if($adrotate_version['current'] < 352) {
		adrotate_remove_capability("adrotate_userstatistics"); // OBSOLETE IN 3.5
		adrotate_remove_capability("adrotate_globalstatistics"); // OBSOLETE IN 3.5
		$role = get_role('administrator');		
		$role->add_cap("adrotate_advertiser_report"); // NEW IN 3.5
		$role->add_cap("adrotate_global_report"); // NEW IN 3.5
	}

	if($adrotate_version['current'] < 353) {
		if(!is_dir(ABSPATH.'/wp-content/plugins/adrotate/language')) {
			mkdir(ABSPATH.'/wp-content/plugins/adrotate/language', 0755);
		}
	}

	if($adrotate_version['current'] < 354) {
		$crawlers = array("Teoma", "alexa", "froogle", "Gigabot", "inktomi","looksmart", "URL_Spider_SQL", "Firefly", "NationalDirectory","Ask Jeeves", "TECNOSEEK", "InfoSeek", "WebFindBot", "girafabot","www.galaxy.com", "Googlebot", "Scooter", "Slurp","msnbot", "appie", "FAST", "WebBug", "Spade", "ZyBorg", "rabaz","Baiduspider", "Feedfetcher-Google", "TechnoratiSnoop", "Rankivabot","Mediapartners-Google", "Sogou web spider", "WebAlta Crawler","bot", "crawler", "yahoo", "msn", "ask", "ia_archiver");
		update_option('adrotate_crawlers', $crawlers);
	}

	if($adrotate_version['current'] < 355) {
		if(!is_dir(ABSPATH.'/wp-content/reports')) {
			mkdir(ABSPATH.'/wp-content/reports', 0755);
		}
	}

	if($adrotate_version['current'] < 356) {
		adrotate_remove_capability("adrotate_advertiser_report");
		$role = get_role('administrator');		
		$role->add_cap("adrotate_advertiser");
	}
	
	if($adrotate_version['current'] < 357) {
		$role = get_role('administrator');		
		$role->add_cap("adrotate_moderate");
		$role->add_cap("adrotate_moderate_approve");
	}
	
	// 3.8.3.3
	if($adrotate_version['current'] < 363) {
		// Set defaults for internal versions
		$adrotate_db_version = get_option("adrotate_db_version");
		if(empty($adrotate_db_version)) update_option('adrotate_db_version', array('current' => ADROTATE_DB_VERSION, 'previous' => $adrotate_db_version['current']));
	}

	// 3.8.4
	if($adrotate_version['current'] < 364) {
		// Reset wp-cron tasks
		wp_clear_scheduled_hook('adrotate_ad_notification');
		wp_clear_scheduled_hook('adrotate_prepare_cache_statistics'); // OBSOLETE IN 3.6 - REMOVE IN 4.0
		wp_clear_scheduled_hook('adrotate_clean_trackerdata');
		wp_clear_scheduled_hook('adrotate_evaluate_ads');

		if(!wp_next_scheduled('adrotate_ad_notification')) wp_schedule_event($firstrun, 'daily', 'adrotate_ad_notification');
		if(!wp_next_scheduled('adrotate_clean_trackerdata')) wp_schedule_event($firstrun, 'twicedaily', 'adrotate_clean_trackerdata');
	}

	// 3.8.5
	if($adrotate_version['current'] < 365) {
		add_option('adrotate_activate', array('status' => 0, 'instance' => '', 'activated' => '', 'deactivated' => '', 'type' => '', 'key' => '', 'email' => '', 'version' => '', 'firstrun' => 1));
	}

	// 3.8.5.1
	if($adrotate_version['current'] < 366) {
		if(!wp_next_scheduled('adrotate_check_version')) wp_schedule_event($firstrun, 'daily', 'adrotate_check_version');
	}

	// 3.8.7.1
	if($adrotate_version['current'] < 367) {
		if(!wp_next_scheduled('adrotate_evaluate_ads')) wp_schedule_event($firstrun, 'twicedaily', 'adrotate_evaluate_ads');
	}

	// 3.8.11
	if($adrotate_version['current'] < 368) {
		if(!is_dir(ABSPATH.'/wp-content/banners')) mkdir(ABSPATH.'/wp-content/banners', 0755);
		if(!is_dir(ABSPATH.'/wp-content/reports')) mkdir(ABSPATH.'/wp-content/reports', 0755);
	}

	// 3.8.13
	if($adrotate_version['current'] < 369) {
		$geo_count = $wpdb->get_var("SELECT COUNT(*) as `total` FROM `".$wpdb->prefix."adrotate_groups` WHERE `name` != '' AND `geo` = 1;");
		update_option('adrotate_geo_required', $geo_count);
	}

	// 3.9.5
	if($adrotate_version['current'] < 370) {
		wp_clear_scheduled_hook('adrotate_check_version');
	}

	// 3.9.9
	if($adrotate_version['current'] < 371) {
		// Reset wp-cron tasks
		wp_clear_scheduled_hook('adrotate_ad_notification');
		if(!wp_next_scheduled('adrotate_notification')) wp_schedule_event($firstrun, 'daily', 'adrotate_notification');
		if(!wp_next_scheduled('adrotate_clean_trackerdata')) wp_schedule_event($firstrun + 1800, 'twicedaily', 'adrotate_clean_trackerdata');
		if(!wp_next_scheduled('adrotate_evaluate_ads')) wp_schedule_event($firstrun + 3600, 'twicedaily', 'adrotate_evaluate_ads');
	}

	// 3.10
	if($adrotate_version['current'] < 373) {
		add_option('adrotate_responsive_required', 0);
	}

	// 3.11
	if($adrotate_version['current'] < 374) {
		add_option('adrotate_dynamic_required', 1);
	}

	// 3.11.3
	if($adrotate_version['current'] < 375) {
		wp_clear_scheduled_hook('adrotate_clean_trackerdata');
	}

	// 3.11.4
	if($adrotate_version['current'] < 376) {
		adrotate_check_config();
	}

	// 3.12.3
	if($adrotate_version['current'] < 377) {
		delete_option('adrotate_server');
		delete_option('adrotate_server_hide');
	}

	update_option("adrotate_version", array('current' => ADROTATE_VERSION, 'previous' => $adrotate_version['current']));
}

/*-------------------------------------------------------------
 Name:      adrotate_optimize_database

 Purpose:   Optimizes all AdRotate tables
 Receive:   -none-
 Return:    -none-
 Since:		3.4
-------------------------------------------------------------*/
function adrotate_optimize_database() {
	global $wpdb;
	
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

	$adrotate_db_timer 	= get_option('adrotate_db_timer');
	$now = adrotate_now();
	$tables = adrotate_list_tables();

	if($adrotate_db_timer < ($now - 86400)) {
		dbDelta("OPTIMIZE TABLE `".$tables['adrotate']."`, `".$tables['adrotate_groups']."`, `".$tables['adrotate_linkmeta']."`, `".$tables['adrotate_stats']."`, `".$tables['adrotate_tracker']."`, `".$tables['adrotate_schedule']."`, ;");
		update_option('adrotate_db_timer', $now);
		adrotate_return('adrotate-settings', 403);
	} else {
		adrotate_return('adrotate-settings', 504);
	}
}

/*-------------------------------------------------------------
 Name:      adrotate_cleanup_database

 Purpose:   Clean AdRotate tables
 Receive:   -none-
 Return:    -none-
 Since:		3.5
-------------------------------------------------------------*/
function adrotate_cleanup_database() {
	global $wpdb;

	$now = adrotate_now();
	
	// Delete expired schedules
	if(isset($_POST['adrotate_db_cleanup_schedules'])) {
		$wpdb->query("DELETE FROM `".$wpdb->prefix."adrotate_schedule` WHERE `stoptime` < $now;");
	}

	// Delete old stats
	if(isset($_POST['adrotate_db_cleanup_statistics'])) {
		$lastyear = $now - 30758400;
		$wpdb->query("DELETE FROM `".$wpdb->prefix."adrotate_stats` WHERE `thetime` < $lastyear;");
	}

	// Clean up Tracker data
	$yesterday = $now - 86400;
	$wpdb->query("DELETE FROM `".$wpdb->prefix."adrotate_tracker` WHERE `thetime` < $yesterday;");

	// Delete empty ads, groups and schedules
	$wpdb->query("DELETE FROM `".$wpdb->prefix."adrotate` WHERE `type` = 'empty' OR `type` = 'a_empty';");
	$wpdb->query("DELETE FROM `".$wpdb->prefix."adrotate_groups` WHERE `name` = '';");
	$wpdb->query("DELETE FROM `".$wpdb->prefix."adrotate_schedule` WHERE `name` = '';");
	
	// Clean up meta data
	$ads = $wpdb->get_results("SELECT `id` FROM `".$wpdb->prefix."adrotate` ORDER BY `id`;");
	$metas = $wpdb->get_results("SELECT `id`, `ad` FROM `".$wpdb->prefix."adrotate_linkmeta` WHERE `ad` != '0' ORDER BY `id`;");
	
	$adverts = $linkmeta = array();
	foreach($ads as $ad) {
		$adverts[$ad->id] = $ad->id;
	}
	foreach($metas as $meta) {
		$linkmeta[$meta->id] = $meta->ad;
	}

	$result = array_diff($linkmeta, $adverts);
	foreach($result as $key => $value) {
		$wpdb->query("DELETE FROM `".$wpdb->prefix."adrotate_linkmeta` WHERE `id` = $key;");
		unset($result[$key]);
	}
	unset($ads, $metas, $adverts, $linkmeta, $result);

	// Clean up stray linkmeta
	$wpdb->query("DELETE FROM `".$wpdb->prefix."adrotate_linkmeta` WHERE `ad` = 0 OR `ad` = '';");

	adrotate_return('adrotate-settings', 406);
}

/*-------------------------------------------------------------
 Name:      adrotate_clean_trackerdata

 Purpose:   Removes old statistics
 Receive:   -none-
 Return:    -none-
 Since:		2.0
-------------------------------------------------------------*/
function adrotate_clean_trackerdata() {
	global $wpdb;

	$now = adrotate_now();
	$clicks = $now - 86400;
	$impressions = $now - 3600;

	$wpdb->query("DELETE FROM `".$wpdb->prefix."adrotate_tracker` WHERE (`timer` < ".$clicks." AND `stat` = 'c') OR (`timer` < ".$impressions." AND `stat` = 'i') OR `ipaddress`  = 'unknown' OR `ipaddress`  = '';");
}

/*-------------------------------------------------------------
 Name:      adrotate_add_column

 Purpose:   Check if the column exists in the table
 Receive:   $table_name, $column_name, $attributes
 Return:	Boolean
 Since:		3.0.3
-------------------------------------------------------------*/
function adrotate_add_column($table_name, $column_name, $attributes) {
	global $wpdb;
	
	foreach ($wpdb->get_col("SHOW COLUMNS FROM $table_name;") as $column ) {
		if ($column == $column_name) return true;
	}
	
	$wpdb->query("ALTER TABLE $table_name ADD $column_name " . $attributes.";");
	
	foreach ($wpdb->get_col("SHOW COLUMNS FROM $table_name;") as $column ) {
		if ($column == $column_name) return true;
	}
	
	return false;
}

/*-------------------------------------------------------------
 Name:      adrotate_del_column

 Purpose:   Check if the column exists in the table remove if it does
 Receive:   $table_name, $column_name
 Return:	Boolean
 Since:		3.8.3.3
-------------------------------------------------------------*/
function adrotate_del_column($table_name, $column_name) {
	global $wpdb;
	
	foreach ($wpdb->get_col("SHOW COLUMNS FROM $table_name;") as $column ) {
		if ($column == $column_name) {
			$wpdb->query("ALTER TABLE $table_name DROP $column;");
			return true;
		}
	}
	
	return false;
}

/*-------------------------------------------------------------
 Name:      adrotate_list_tables

 Purpose:   List tables for AdRotate in an array
 Receive:   $blog_id
 Return:	$tables
 Since:		3.4
-------------------------------------------------------------*/
function adrotate_list_tables() {
	global $wpdb;

	$tables = array(
		'adrotate' 					=> $wpdb->prefix . "adrotate",				// Since 0.1
		'adrotate_groups' 			=> $wpdb->prefix . "adrotate_groups",		// Since 0.2
		'adrotate_tracker' 			=> $wpdb->prefix . "adrotate_tracker",		// Since 2.0
		'adrotate_linkmeta' 		=> $wpdb->prefix . "adrotate_linkmeta",		// Since 3.0
		'adrotate_stats' 			=> $wpdb->prefix . "adrotate_stats",		// Since 3.5 (renamed in 3.8)
		'adrotate_schedule'		 	=> $wpdb->prefix . "adrotate_schedule",		// Since 3.6.11a1
	);

	return $tables;
}
?>