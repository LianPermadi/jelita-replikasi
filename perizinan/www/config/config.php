<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
/*
|--------------------------------------------------------------------------
| Base Site URL
|--------------------------------------------------------------------------
|
| URL to your CodeIgniter root. Typically this will be your base URL,
| WITH a trailing slash:
|
|	http://example.com/
|
*/
$php_self = $_SERVER['SCRIPT_NAME'];

if (strpos($php_self, 'index.php') !== false) {
    // Kalau mengandung 'index.php', kita hapus semua 'index.php'-nya
    $clean_path = str_replace('index.php', '', $php_self);
} else {
    // Kalau nggak ada, tetapin aja
    $clean_path = $php_self;
}

// echo $clean_path;
// ====== LOGGING MANUAL ======
$log_dir  = $_SERVER['DOCUMENT_ROOT'].$clean_path . 'assets/log'; // Folder log ada di /jelita/log
$log_date = date('Y-m-d'); // Contoh: 2025-05-16
$log_file = $log_dir . "/log-$log_date.log"; // Contoh: log-2025-05-16.log

// Buat folder log kalau belum ada
if (!is_dir($log_dir)) {
    mkdir($log_dir, 0777, true);
}

// Buat file log kalau belum ada
if (!file_exists($log_file)) {
    file_put_contents($log_file, "");
}

// Tangkap info request
$timestamp = date('Y-m-d H:i:s');
$ip        = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '-';
$method    = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : '-';
$uri       = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '-';
$agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '-';

$local_ips = ['127.0.0.1', '::1', 'localhost'];
$is_local = in_array($ip, $local_ips) || stripos($ip, '127.0.0.') === 0 || stripos($ip, '192.168.') === 0 || stripos($ip, '10.0.') === 0;

if (!$is_local) {
    if (stripos($agent, 'Amazonbot') !== false) {
        header("Location: https://dpmptsp.jabarprov.go.id/error/404");
        exit;
        show_404();
    }

    $bots = [
        'Googlebot', 'Bingbot', 'Slurp', 'DuckDuckBot', 'Baiduspider',
        'YandexBot', 'Sogou', 'Exabot', 'facebot', 'ia_archiver',
        'AhrefsBot', 'SemrushBot', 'MJ12bot', 'DotBot', 'SeznamBot',
        'BLEXBot', 'CCBot', 'Amazonbot', 'PetalBot', 'AspiegelBot',
        'DataForSeoBot', 'megaindex.ru', 'ZoominfoBot', 'Trendictionbot',
        'YisouSpider', 'crawler', 'spider', 'robot', 'python-requests',
        'Go-http-client', 'wget', 'curl', 'libwww', 'Scrapy'
      ];
      
      foreach ($bots as $bot) {
        if (stripos($_SERVER['HTTP_USER_AGENT'], $bot) !== false) {
            header("Location: https://dpmptsp.jabarprov.go.id/error/404");
            exit;
          show_404();
        }
      }
}
  

// ====== AMBIL KOORDINAT LOKASI ======
$lat = '-';
$lon = '-';
if ($ip != '127.0.0.1' && preg_match('/^[0-9\.]+$/', $ip)) {
    $geo_url = "http://ip-api.com/json/$ip";
    $geo_json = @file_get_contents($geo_url);

    if ($geo_json !== false) {
        $geo_data = json_decode($geo_json, true);
        if (is_array($geo_data) && isset($geo_data['lat']) && isset($geo_data['lon'])) {
            $lat = $geo_data['lat'];
            $lon = $geo_data['lon'];
        }
    }
}

// ====== SIMPAN LOG ======
$log_line = "[" . $timestamp . "] $ip - $method - $uri - \"$agent\" - LAT:$lat LON:$lon\n";

// Tulis ke file log harian
file_put_contents($log_file, $log_line, FILE_APPEND);

// $link = $_SERVER['REQUEST_SCHEME'] .((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "s" : "") . "://";

// $link = 'https' .((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "s" : "") . "://";
$link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on" ? "https" : "http") . "://";
$server = isset($_SERVER['HTTP_HOST']) ?$_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'];
$config['base_url']  = $link . $server;
//$config['base_url'] .= dirname($_SERVER['SCRIPT_NAME']).'/';
$config['base_url'] .= preg_replace('@/+$@','',dirname($_SERVER['SCRIPT_NAME'])).'/';
// var_dump($config);die();

/*
|--------------------------------------------------------------------------
| Index File
|--------------------------------------------------------------------------
|
| Typically this will be your index.php file, unless you've renamed it to
| something else. If you are using mod_rewrite to remove the page set this
| variable so that it is blank.
|
*/
$config['index_page'] = "";

/*
|--------------------------------------------------------------------------
| URI PROTOCOL
|--------------------------------------------------------------------------
|
| This item determines which server global should be used to retrieve the
| URI string.  The default setting of "AUTO" works for most servers.
| If your links do not seem to work, try one of the other delicious flavors:
|
| 'AUTO'			Default - auto detects
| 'PATH_INFO'		Uses the PATH_INFO
| 'QUERY_STRING'	Uses the QUERY_STRING
| 'REQUEST_URI'		Uses the REQUEST_URI
| 'ORIG_PATH_INFO'	Uses the ORIG_PATH_INFO
|
*/
$config['uri_protocol']	= "AUTO";

/*
|--------------------------------------------------------------------------
| URL suffix
|--------------------------------------------------------------------------
|
| This option allows you to add a suffix to all URLs generated by CodeIgniter.
| For more information please see the user guide:
|
| http://codeigniter.com/user_guide/general/urls.html
*/

$config['url_suffix'] = "";

/*
|--------------------------------------------------------------------------
| Default Language
|--------------------------------------------------------------------------
|
| This determines which set of language files should be used. Make sure
| there is an available translation if you intend to use something other
| than english.
|
*/
$config['language']	= "english";

/*
|--------------------------------------------------------------------------
| Default Character Set
|--------------------------------------------------------------------------
|
| This determines which character set is used by default in various methods
| that require a character set to be provided.
|
*/
$config['charset'] = "UTF-8";

/*
|--------------------------------------------------------------------------
| Enable/Disable System Hooks
|--------------------------------------------------------------------------
|
| If you would like to use the "hooks" feature you must enable it by
| setting this variable to TRUE (boolean).  See the user guide for details.
|
*/
$config['enable_hooks'] = FALSE;


/*
|--------------------------------------------------------------------------
| Class Extension Prefix
|--------------------------------------------------------------------------
|
| This item allows you to set the filename/classname prefix when extending
| native libraries.  For more information please see the user guide:
|
| http://codeigniter.com/user_guide/general/core_classes.html
| http://codeigniter.com/user_guide/general/creating_libraries.html
|
*/
$config['subclass_prefix'] = 'MY_';


/*
|--------------------------------------------------------------------------
| Allowed URL Characters
|--------------------------------------------------------------------------
|
| This lets you specify with a regular expression which characters are permitted
| within your URLs.  When someone tries to submit a URL with disallowed
| characters they will get a warning message.
|
| As a security measure you are STRONGLY encouraged to restrict URLs to
| as few characters as possible.  By default only these are allowed: a-z 0-9~%.:_-
|
| Leave blank to allow all characters -- but only if you are insane.
|
| DO NOT CHANGE THIS UNLESS YOU FULLY UNDERSTAND THE REPERCUSSIONS!!
|
*/
//$config['permitted_uri_chars'] = 'a-z 0-9~%.:_\-';
$config['permitted_uri_chars'] = 'a-z 0-9~.:_\-';


/*
|--------------------------------------------------------------------------
| Enable Query Strings
|--------------------------------------------------------------------------
|
| By default CodeIgniter uses search-engine friendly segment based URLs:
| example.com/who/what/where/
|
| You can optionally enable standard query string based URLs:
| example.com?who=me&what=something&where=here
|
| Options are: TRUE or FALSE (boolean)
|
| The other items let you set the query string "words" that will
| invoke your controllers and its functions:
| example.com/index.php?c=controller&m=function
|
| Please note that some of the helpers won't work as expected when
| this feature is enabled, since CodeIgniter is designed primarily to
| use segment based URLs.
|
*/
$config['enable_query_strings'] = FALSE;
$config['controller_trigger'] 	= 'c';
$config['function_trigger'] 	= 'm';
$config['directory_trigger'] 	= 'd'; // experimental not currently in use

/*
|--------------------------------------------------------------------------
| Error Logging Threshold
|--------------------------------------------------------------------------
|
| If you have enabled error logging, you can set an error threshold to 
| determine what gets logged. Threshold options are:
| You can enable error logging by setting a threshold over zero. The
| threshold determines what gets logged. Threshold options are:
|
|	0 = Disables logging, Error logging TURNED OFF
|	1 = Error Messages (including PHP errors)
|	2 = Debug Messages
|	3 = Informational Messages
|	4 = All Messages
|
| For a live site you'll usually only enable Errors (1) to be logged otherwise
| your log files will fill up very fast.
|
*/
$config['log_threshold'] = 1;

/*
|--------------------------------------------------------------------------
| Error Logging Directory Path
|--------------------------------------------------------------------------
|
| Leave this BLANK unless you would like to set something other than the default
| system/logs/ folder.  Use a full server path with trailing slash.
|
*/
$config['log_path'] = '';

/*
|--------------------------------------------------------------------------
| Date Format for Logs
|--------------------------------------------------------------------------
|
| Each item that is logged has an associated date. You can use PHP date
| codes to set your own date formatting
|
*/
$config['log_date_format'] = 'Y-m-d H:i:s';

/*
|--------------------------------------------------------------------------
| Cache Directory Path
|--------------------------------------------------------------------------
|
| Leave this BLANK unless you would like to set something other than the default
| system/cache/ folder.  Use a full server path with trailing slash.
|
*/
$config['cache_path'] = '';

/*
|--------------------------------------------------------------------------
| Encryption Key
|--------------------------------------------------------------------------
|
| If you use the Encryption class or the Sessions class with encryption
| enabled you MUST set an encryption key.  See the user guide for info.
|
*/
//$config['encryption_key'] = "";
$config['encryption_key'] = "!@#waditra)(*";

/*
|--------------------------------------------------------------------------
| Session Variables
|--------------------------------------------------------------------------
|
| 'session_cookie_name' = the name you want for the cookie
| 'encrypt_sess_cookie' = TRUE/FALSE (boolean).  Whether to encrypt the cookie
| 'session_expiration'  = the number of SECONDS you want the session to last.
|  by default sessions last 7200 seconds (two hours).  Set to zero for no expiration.
| 'time_to_update'		= how many seconds between CI refreshing Session Information
|
*/
$config['sess_cookie_name']	= 'ci_session';
//$config['sess_expiration']	= 1800;
$config['sess_expiration']	= 0;
$config['sess_encrypt_cookie']	= TRUE;
$config['sess_use_database']	= FALSE;
$config['sess_table_name']	= 'ci_sessions';
$config['sess_match_ip']	= FALSE;
$config['sess_match_useragent']	= TRUE;
$config['sess_time_to_update'] 	= 300;

/*
|--------------------------------------------------------------------------
| Cookie Related Variables
|--------------------------------------------------------------------------
|
| 'cookie_prefix' = Set a prefix if you need to avoid collisions
| 'cookie_domain' = Set to .your-domain.com for site-wide cookies
| 'cookie_path'   =  Typically will be a forward slash
|
*/
$config['cookie_prefix']	= "";
$config['cookie_domain']	= "";
$config['cookie_path']		= "/";

/*
|--------------------------------------------------------------------------
| Global XSS Filtering
|--------------------------------------------------------------------------
|
| Determines whether the XSS filter is always active when GET, POST or
| COOKIE data is encountered
|
*/
$config['global_xss_filtering'] = TRUE;

/*
|--------------------------------------------------------------------------
| Cross Site Request Forgery
|--------------------------------------------------------------------------
| Enables a CSRF cookie token to be set. When set to TRUE, token will be
| checked on a submitted form. If you are accepting user data, it is strongly
| recommended CSRF protection be enabled.
|
| 'csrf_token_name' = The token name
| 'csrf_cookie_name' = The cookie name
| 'csrf_expire' = The number in seconds the token should expire.
*/
$config['csrf_protection'] = TRUE;
$config['csrf_token_name'] = 'csrf_simpatik';
$config['csrf_cookie_name'] = 'csrf_cookie_simpatik';
$config['csrf_expire'] = 7200;

/*
|--------------------------------------------------------------------------
| Output Compression
|--------------------------------------------------------------------------
|
| Enables Gzip output compression for faster page loads.  When enabled,
| the output class will test whether your server supports Gzip.
| Even if it does, however, not all browsers support compression
| so enable only if you are reasonably sure your visitors can handle it.
|
| VERY IMPORTANT:  If you are getting a blank page when compression is enabled it
| means you are prematurely outputting something to your browser. It could
| even be a line of whitespace at the end of one of your scripts.  For
| compression to work, nothing can be sent before the output buffer is called
| by the output class.  Do not "echo" any values with compression enabled.
|
*/
$config['compress_output'] = FALSE;
$config['composer_autoload'] = FCPATH . 'vendor/autoload.php';


/*
|--------------------------------------------------------------------------
| Master Time Reference
|--------------------------------------------------------------------------
|
| Options are "local" or "gmt".  This pref tells the system whether to use
| your server's local time as the master "now" reference, or convert it to
| GMT.  See the "date helper" page of the user guide for information
| regarding date handling.
|
*/
$config['time_reference'] = 'local';


/*
|--------------------------------------------------------------------------
| Rewrite PHP Short Tags
|--------------------------------------------------------------------------
|
| If your PHP installation does not have short tag support enabled CI
| can rewrite the tags on-the-fly, enabling you to utilize that syntax
| in your view files.  Options are TRUE or FALSE (boolean)
|
*/
$config['rewrite_short_tags'] = FALSE;


/*
|--------------------------------------------------------------------------
| Reverse Proxy IPs
|--------------------------------------------------------------------------
|
| If your server is behind a reverse proxy, you must whitelist the proxy IP
| addresses from which CodeIgniter should trust the HTTP_X_FORWARDED_FOR
| header in order to properly identify the visitor's IP address.
| Comma-delimited, e.g. '10.0.1.200,10.0.1.201'
|
*/
$config['proxy_ips'] = '';


/*
| -------------------------------------------------------------------
|  Native Auto-load
| -------------------------------------------------------------------
|
| Nothing to do with config/autoload.php, this allows PHP autoload to work
| for base controllers and some third-party libraries.
|
*/

// function __autoload($class) {
//     if (strpos($class, 'CI_') !== 0) {
//         @include_once( APPPATH . 'libraries/' . $class . EXT );
//     }
// }
// PHPMyAdmin
// https://perijinan.papuabaratprov.go.id/phpmyadmin/
// root / m4nokw4r1


/* End of file config.php */
/* Location: ./system/application/config/config.php */
