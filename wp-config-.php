<?php
# Database Configuration
define( 'DB_NAME', 'wp_devsanjose2014' );
define( 'DB_USER', 'root' );
define( 'DB_PASSWORD', 'ameba' );
define( 'DB_HOST', '127.0.0.1' );
define( 'DB_HOST_SLAVE', '127.0.0.1' );
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', 'utf8_unicode_ci');
$table_prefix = 'wp_';

# Security Salts, Keys, Etc
define('AUTH_KEY', 'WGiPQ6?5a[]v8S&7^F9mXbFftc^Nl-:x`+Aj<-UOY 6yg3L AiMw5p`~|4/7ktnj');
define('SECURE_AUTH_KEY', '3Yp_KnF0I,+xk&F)E fVs)@knd8G#3gk~5+2O4.]qZkYl$+4UEthn^:CIk@gupOA');
define('LOGGED_IN_KEY', 'Gv9N?taUyM~Fm:]CX;38JrG~7wC/Pv.%q9K -8J:M|#<p:z8L;B*Qg 2,l{G#TT4');
define('NONCE_KEY', '/ueb7fVa;(3&R7^XIOei|vOD.m-6i}mR^|MZWN8azdo[hxP3c({uf9hVlmjI)RS-');
define('AUTH_SALT',        'T*-u;^|@+pF-n56c{Xx3w/(Z<o$tNk^;<g>uPP,r<NgoR|k=l1yklmpDd>q8)8)+');
define('SECURE_AUTH_SALT', '2<,jwcDAcJjJ+JFcgnZF;f*QxN+b}7E-kmm9dKcKUqXtM?M%U2Y2}j-PB:MJrM<u');
define('LOGGED_IN_SALT',   'E~*TJ5]j~<+]v7hX9TsE7DE-e+f~Tw+a0q2:(8Q$X0I+ROj &-1a)Q_6s5*&L{E-');
define('NONCE_SALT',       'DYH-+5lZ NIlu-hK2[^fn;?{WZ2ig%O%bW#]OJF}.xHq|^9+BB+!eT1{x$w}?x<s');


# Localized Language Stuff


define( 'WP_AUTO_UPDATE_CORE', false );

define( 'PWP_NAME', 'devsanjose2014' );

define( 'FS_METHOD', 'direct' );

define( 'FS_CHMOD_DIR', 0775 );

define( 'FS_CHMOD_FILE', 0664 );

define( 'PWP_ROOT_DIR', '/nas/wp' );

define( 'WPE_APIKEY', '6861f00a0df4ca70efb847c1380ac902194d8f23' );

define( 'WPE_FOOTER_HTML', "" );

define( 'WPE_CLUSTER_ID', '1736' );

define( 'WPE_CLUSTER_TYPE', 'pod' );

define( 'WPE_ISP', true );

define( 'WPE_BPOD', false );

define( 'WPE_RO_FILESYSTEM', false );

define( 'WPE_LARGEFS_BUCKET', 'largefs.wpengine' );

define( 'WPE_CDN_DISABLE_ALLOWED', false );

define( 'DISALLOW_FILE_EDIT', FALSE );

define( 'DISALLOW_FILE_MODS', FALSE );

define( 'DISABLE_WP_CRON', false );

define( 'WPE_FORCE_SSL_LOGIN', false );

define( 'FORCE_SSL_LOGIN', false );

/*SSLSTART*/ if ( isset($_SERVER['HTTP_X_WPE_SSL']) && $_SERVER['HTTP_X_WPE_SSL'] ) $_SERVER['HTTPS'] = 'on'; /*SSLEND*/

define( 'WPE_EXTERNAL_URL', false );

define( 'WP_POST_REVISIONS', 5 );

define( 'WPE_WHITELABEL', 'wpengine' );

define( 'WP_TURN_OFF_ADMIN_BAR', false );

define( 'WPE_BETA_TESTER', false );

umask(0002);

$wpe_cdn_uris=array ( );

$wpe_no_cdn_uris=array ( );

$wpe_content_regexs=array ( );

$wpe_all_domains=array ( 0 => 'ameba_server/devsanjose2014/', );

$wpe_varnish_servers=array ( 0 => 'pod-1736', );

$wpe_ec_servers=array ( );

$wpe_largefs=array ( );

$wpe_netdna_domains=array ( );

$wpe_netdna_push_domains=array ( );

$wpe_domain_mappings=array ( );

$memcached_servers=array ( 'default' =>  array ( 0 => 'unix:///tmp/memcached.sock', ), );

$wpe_special_ips=array ( 0 => '66.175.209.28', );

$wpe_netdna_domains_secure=array ( );

define( 'WP_SITEURL', 'http://local.tmflive2015.com/' );

define( 'WP_HOME', 'http://local.tmflive2015.com/' );

define( 'WPE_CACHE_TYPE', 'generational' );

define( 'WP_CACHE', TRUE );

define( 'WPE_LBMASTER_IP', '66.175.209.28' );
define('WPLANG','');

# WP Engine ID


# WP Engine Settings






# That's It. Pencils down
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
require_once(ABSPATH . 'wp-settings.php');

$_wpe_preamble_path = null; if(false){}
