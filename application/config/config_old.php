<?php
defined('BASEPATH') OR exit('No direct script access allowed');
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
  | WARNING: You MUST set this value!
  |
  | If it is not set, then CodeIgniter will try guess the protocol and path
  | your installation, but due to security concerns the hostname will be set
  | to $_SERVER['SERVER_ADDR'] if available, or localhost otherwise.
  | The auto-detection mechanism exists only for convenience during
  | development and MUST NOT be used in production!
  |
  | If you need to allow multiple domains, remember that this file is still
  | a PHP script and you can easily do that on your own.
  |
 */



$config['base_url'] = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
$config['base_url'] .= "://".$_SERVER['HTTP_HOST'];
$config['base_url'] .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);

$config['site_name'] = 'Emergency Medical Services';
$config['site'] = 'Emergency Medical Services';
$config['event_api_url'] = 'http://10.108.1.105/Factsheet/singlerecord.php?eventtype=2&userid=10012&moduleid=10';
$config['avaya_server_url'] = 'http://10.108.1.57:8061/pbx/callcenter/v1/';
$config['avaya_server_url'] = 'http://10.108.1.58:8080/TeleWebAPI.svc/';
$config['corel_server_url'] = 'http://10.108.1.57:8061/pbx/callcenter/v1/';
$config['ameyo_server_url'] = 'https://ameyo.jaesmp.com:8443';

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
$config['index_page'] = 'index.php';
//$config['index_page'] = '';

/*
  |--------------------------------------------------------------------------
  | URI PROTOCOL
  |--------------------------------------------------------------------------
  |
  | This item determines which server global should be used to retrieve the
  | URI string.  The default setting of 'REQUEST_URI' works for most servers.
  | If your links do not seem to work, try one of the other delicious flavors:
  |
  | 'REQUEST_URI'    Uses $_SERVER['REQUEST_URI']
  | 'QUERY_STRING'   Uses $_SERVER['QUERY_STRING']
  | 'PATH_INFO'      Uses $_SERVER['PATH_INFO']
  |
  | WARNING: If you set this to 'PATH_INFO', URIs will always be URL-decoded!
 */
$config['uri_protocol'] = 'REQUEST_URI';

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
$config['url_suffix'] = '';

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
$config['language'] = 'english';

/*
  |--------------------------------------------------------------------------
  | Default Character Set
  |--------------------------------------------------------------------------
  |
  | This determines which character set is used by default in various methods
  | that require a character set to be provided.
  |
  | See http://php.net/htmlspecialchars for a list of supported charsets.
  |
 */
$config['charset'] = 'UTF-8';

/*
  |--------------------------------------------------------------------------
  | Enable/Disable System Hooks
  |--------------------------------------------------------------------------
  |
  | If you would like to use the 'hooks' feature you must enable it by
  | setting this variable to TRUE (boolean).  See the user guide for details.
  |
 */
$config['enable_hooks'] = TRUE;

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
$config['subclass_prefix'] = 'EMS_';

/*
  |--------------------------------------------------------------------------
  | Composer auto-loading
  |--------------------------------------------------------------------------
  |
  | Enabling this setting will tell CodeIgniter to look for a Composer
  | package auto-loader script in application/vendor/autoload.php.
  |
  |	$config['composer_autoload'] = TRUE;
  |
  | Or if you have your vendor/ directory located somewhere else, you
  | can opt to set a specific path as well:
  |
  |	$config['composer_autoload'] = '/path/to/vendor/autoload.php';
  |
  | For more information about Composer, please visit http://getcomposer.org/
  |
  | Note: This will NOT disable or override the CodeIgniter-specific
  |	autoloading (application/config/autoload.php)
 */
$config['composer_autoload'] = TRUE;
$config['composer_autoload'] = 'application/libraries/vendor/autoload.php';

/*
  |--------------------------------------------------------------------------
  | Allowed URL Characters
  |--------------------------------------------------------------------------
  |
  | This lets you specify which characters are permitted within your URLs.
  | When someone tries to submit a URL with disallowed characters they will
  | get a warning message.
  |
  | As a security measure you are STRONGLY encouraged to restrict URLs to
  | as few characters as possible.  By default only these are allowed: a-z 0-9~%.:_-
  |
  | Leave blank to allow all characters -- but only if you are insane.
  |
  | The configured value is actually a regular expression character group
  | and it will be executed as: ! preg_match('/^[<permitted_uri_chars>]+$/i
  |
  | DO NOT CHANGE THIS UNLESS YOU FULLY UNDERSTAND THE REPERCUSSIONS!!
  |
 */
$config['permitted_uri_chars'] = 'a-z 0-9~%.:_@()\-' . urlencode('??????????');

/*
  |--------------------------------------------------------------------------
  | Enable Query Strings
  |--------------------------------------------------------------------------
  |
  | By default CodeIgniter uses search-engine friendly segment based URLs:
  | example.com/who/what/where/
  |
  | By default CodeIgniter enables access to the $_GET array.  If for some
  | reason you would like to disable it, set 'allow_get_array' to FALSE.
  |
  | You can optionally enable standard query string based URLs:
  | example.com?who=me&what=something&where=here
  |
  | Options are: TRUE or FALSE (boolean)
  |
  | The other items let you set the query string 'words' that will
  | invoke your controllers and its functions:
  | example.com/index.php?c=controller&m=function
  |
  | Please note that some of the helpers won't work as expected when
  | this feature is enabled, since CodeIgniter is designed primarily to
  | use segment based URLs.
  |
 */
$config['allow_get_array'] = TRUE;
$config['enable_query_strings'] = FALSE;
$config['controller_trigger'] = 'c';
$config['function_trigger'] = 'm';
$config['directory_trigger'] = 'd';

/*
  |--------------------------------------------------------------------------
  | Error Logging Threshold
  |--------------------------------------------------------------------------
  |
  | You can enable error logging by setting a threshold over zero. The
  | threshold determines what gets logged. Threshold options are:
  |
  |	0 = Disables logging, Error logging TURNED OFF
  |	1 = Error Messages (including PHP errors)
  |	2 = Debug Messages
  |	3 = Informational Messages
  |	4 = All Messages
  |
  | You can also pass an array with threshold levels to show individual error types
  |
  | 	array(2) = Debug Messages, without Error Messages
  |
  | For a live site you'll usually only enable Errors (1) to be logged otherwise
  | your log files will fill up very fast.
  |
 */
$config['log_threshold'] = 0;

/*
  |--------------------------------------------------------------------------
  | Error Logging Directory Path
  |--------------------------------------------------------------------------
  |
  | Leave this BLANK unless you would like to set something other than the default
  | application/logs/ directory. Use a full server path with trailing slash.
  |
 */
$config['log_path'] = '';

/*
  |--------------------------------------------------------------------------
  | Log File Extension
  |--------------------------------------------------------------------------
  |
  | The default filename extension for log files. The default 'php' allows for
  | protecting the log files via basic scripting, when they are to be stored
  | under a publicly accessible directory.
  |
  | Note: Leaving it blank will default to 'php'.
  |
 */
$config['log_file_extension'] = '';

/*
  |--------------------------------------------------------------------------
  | Log File Permissions
  |--------------------------------------------------------------------------
  |
  | The file system permissions to be applied on newly created log files.
  |
  | IMPORTANT: This MUST be an integer (no quotes) and you MUST use octal
  |            integer notation (i.e. 0700, 0644, etc.)
 */
$config['log_file_permissions'] = 0644;

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
  | Error Views Directory Path
  |--------------------------------------------------------------------------
  |
  | Leave this BLANK unless you would like to set something other than the default
  | application/views/errors/ directory.  Use a full server path with trailing slash.
  |
 */
$config['error_views_path'] = '';

/*
  |--------------------------------------------------------------------------
  | Cache Directory Path
  |--------------------------------------------------------------------------
  |
  | Leave this BLANK unless you would like to set something other than the default
  | application/cache/ directory.  Use a full server path with trailing slash.
  |
 */
$config['cache_path'] = '';

/*
  |--------------------------------------------------------------------------
  | Cache Include Query String
  |--------------------------------------------------------------------------
  |
  | Whether to take the URL query string into consideration when generating
  | output cache files. Valid options are:
  |
  |	FALSE      = Disabled
  |	TRUE       = Enabled, take all query parameters into account.
  |	             Please be aware that this may result in numerous cache
  |	             files generated for the same page over and over again.
  |	array('q') = Enabled, but only take into account the specified list
  |	             of query parameters.
  |
 */
$config['cache_query_string'] = FALSE;

/*
  |--------------------------------------------------------------------------
  | Encryption Key
  |--------------------------------------------------------------------------
  |
  | If you use the Encryption class, you must set an encryption key.
  | See the user guide for more info.
  |
  | http://codeigniter.com/user_guide/libraries/encryption.html
  |
 */
$config['encryption_key'] = '';

/*
  |--------------------------------------------------------------------------
  | Session Variables
  |--------------------------------------------------------------------------
  |
  | 'sess_driver'
  |
  |	The storage driver to use: files, database, redis, memcached
  |
  | 'sess_cookie_name'
  |
  |	The session cookie name, must contain only [0-9a-z_-] characters
  |
  | 'sess_expiration'
  |
  |	The number of SECONDS you want the session to last.
  |	Setting to 0 (zero) means expire when the browser is closed.
  |
  | 'sess_save_path'
  |
  |	The location to save sessions to, driver dependent.
  |
  |	For the 'files' driver, it's a path to a writable directory.
  |	WARNING: Only absolute paths are supported!
  |
  |	For the 'database' driver, it's a table name.
  |	Please read up the manual for the format with other session drivers.
  |
  |	IMPORTANT: You are REQUIRED to set a valid save path!
  |
  | 'sess_match_ip'
  |
  |	Whether to match the user's IP address when reading the session data.
  |
  |	WARNING: If you're using the database driver, don't forget to update
  |	         your session table's PRIMARY KEY when changing this setting.
  |
  | 'sess_time_to_update'
  |
  |	How many seconds between CI regenerating the session ID.
  |
  | 'sess_regenerate_destroy'
  |
  |	Whether to destroy session data associated with the old session ID
  |	when auto-regenerating the session ID. When set to FALSE, the data
  |	will be later deleted by the garbage collector.
  |
  | Other session cookie settings are shared with the rest of the application,
  | except for 'cookie_prefix' and 'cookie_httponly', which are ignored here.
  |
 */
$config['sess_driver'] = 'files';
$config['sess_cookie_name'] = 'emssession';
/* $config['sess_expiration'] = 60*60*24*5;*/
$config['sess_expiration'] = 60*60*24;
$config['sess_save_path'] = BASEPATH . 'sessions/cache/';
$config['sess_match_ip'] = FALSE;
/*
$config['sess_time_to_update'] = 36536000;
*/
$config['sess_time_to_update'] = 43200;
$config['sess_regenerate_destroy'] = TRUE;
$config['sess_match_useragent'] = FALSE;
$config['sess_encrypt_cookie'] = FALSE;
/*
  |--------------------------------------------------------------------------
  | Cookie Related Variables
  |--------------------------------------------------------------------------
  |
  | 'cookie_prefix'   = Set a cookie name prefix if you need to avoid collisions
  | 'cookie_domain'   = Set to .your-domain.com for site-wide cookies
  | 'cookie_path'     = Typically will be a forward slash
  | 'cookie_secure'   = Cookie will only be set if a secure HTTPS connection exists.
  | 'cookie_httponly' = Cookie will only be accessible via HTTP(S) (no javascript)
  |
  | Note: These settings (with the exception of 'cookie_prefix' and
  |       'cookie_httponly') will also affect sessions.
  |
 */
$config['cookie_prefix'] = 'ems_';
$config['cookie_domain'] = '';
///$config['cookie_domain'] = str_replace("http://","",str_replace("https://","", $config['base_url']));
$config['cookie_path'] = '/';
$config['cookie_secure'] = TRUE;
$config['cookie_httponly'] = TRUE;
$config['cookie_samesite'] = 'None';
/*
  |--------------------------------------------------------------------------
  | Standardize newlines
  |--------------------------------------------------------------------------
  |
  | Determines whether to standardize newline characters in input data,
  | meaning to replace \r\n, \r, \n occurrences with the PHP_EOL value.
  |
  | This is particularly useful for portability between UNIX-based OSes,
  | (usually \n) and Windows (\r\n).
  |
 */
$config['standardize_newlines'] = TRUE;

/*
  |--------------------------------------------------------------------------
  | Global XSS Filtering
  |--------------------------------------------------------------------------
  |
  | Determines whether the XSS filter is always active when GET, POST or
  | COOKIE data is encountered
  |
  | WARNING: This feature is DEPRECATED and currently available only
  |          for backwards compatibility purposes!
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
  | 'csrf_regenerate' = Regenerate token on every submission
  | 'csrf_exclude_uris' = Array of URIs which ignore CSRF checks
 */
$config['csrf_protection'] = FALSE;
$config['csrf_token_name'] = 'csrf_token';
$config['csrf_cookie_name'] = 'csrf_cookie';
$config['csrf_expire'] = 7200;
$config['csrf_regenerate'] = TRUE;
$config['csrf_exclude_uris'] = array();

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
  | Only used if zlib.output_compression is turned off in your php.ini.
  | Please do not use it together with httpd-level output compression.
  |
  | VERY IMPORTANT:  If you are getting a blank page when compression is enabled it
  | means you are prematurely outputting something to your browser. It could
  | even be a line of whitespace at the end of one of your scripts.  For
  | compression to work, nothing can be sent before the output buffer is called
  | by the output class.  Do not 'echo' any values with compression enabled.
  |
 */
$config['compress_output'] = FALSE;

/*
  |--------------------------------------------------------------------------
  | Master Time Reference
  |--------------------------------------------------------------------------
  |
  | Options are 'local' or any PHP supported timezone. This preference tells
  | the system whether to use your server's local time as the master 'now'
  | reference, or convert it to the configured one timezone. See the 'date
  | helper' page of the user guide for information regarding date handling.
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
  | Note: You need to have eval() enabled for this to work.
  |
 */
$config['rewrite_short_tags'] = FALSE;

/*
  |--------------------------------------------------------------------------
  | Reverse Proxy IPs
  |--------------------------------------------------------------------------
  |
  | If your server is behind a reverse proxy, you must whitelist the proxy
  | IP addresses from which CodeIgniter should trust headers such as
  | HTTP_X_FORWARDED_FOR and HTTP_CLIENT_IP in order to properly identify
  | the visitor's IP address.
  |
  | You can use both an array or a comma-separated list of proxy addresses,
  | as well as specifying whole subnets. Here are a few examples:
  |
  | Comma-separated:	'10.0.1.200,192.168.5.0/24'
  | Array:		array('10.0.1.200', '192.168.5.0/24')
 */
$config['proxy_ips'] = '';
$config['developer_profiling'] = FALSE;
$config['queries']          = TRUE;
/* Theme Setting */
$config['theme_path'] = 'themes';
$config['frontend_theme'] = 'backend';
$config['backend_theme'] = 'backend';
$config['backend_slug'] = '';

/* General Setting */

$config['pagination'] = array();
$config['upload_path'] = 'uploads';
$config['healthcards'] = 'uploads/healthcards';
$config['upload_image_types'] = 'jpg|jpeg|png';
$config['allow_zip'] = 'zip';
$config['upload_media_types'] = 'mp3|mp4|ogg|WebM';
$config['upload_image_size'] = 1024*5;    //Max upload image size
$config['upload_media_size'] = 5120;    //Max upload media size for audio and mp4
$config['user_lock_screen_time'] = 180; // in seconds
$config['user_single_login'] = TRUE;
$config['backup'] = 'backup';
$config['backup_full_path'] = '/home/speroems/public_html/SPERO_MEMS2020/backup/db_backup/';
$config['msql_path'] = '/usr/bin/mysqldump';
$config['pagination_limit'] = 50;
  $config['email_config']= array('protocol'=>'smtp',
  'smtp_host'=>'bvgmems.com',
  'smtp_port'=>'587',
  'smtp_timeout'=>'7',
  'smtp_user'=>'fleetdeskmems@bvgmems.com',
  'smtp_pass'=>'mems@1234',
      
  'wordwrap'=>TRUE,
  'mailtype'=>'html',
  'charset'=>'UTF-8',
  'newline'=> '\r\n');
//$config['email_config'] = array('protocol' => 'sendmail',
//
//    'wordwrap' => TRUE,
//
//    'mailtype' => 'html',
//
//    'useragent' => $_SERVER['HTTP_USER_AGENT'],
//
//    'charset' => 'UTF-8',
//
//    'crlf' => '\r\n',
//
//    'newline' => '\r\n'
//
//);

/* sms */
$config['sms_api_url'] = "http://www.unicel.in/SendSMS/sendmsg.php";
//$config['sms_api_url'] = "";
$config['sms_auth_user'] = "bvgmems";
$config['sms_auth_pass'] = "m2v5c2";

$config['rsm_path'] = FCPATH."uploads/colleague_profile/resumes";
$config['avaya_url']= "avaya_api/soft_dial_disconnect";
$config['avaya_from_no']="1011";

///////////// colleagues photo configuration ////////////

$config['clg_pic_resize'] = array(
    'image_library' => 'gd2',
    'create_thumb' => TRUE,
    'maintain_ratio' => TRUE,
    'overwrite' => TRUE,
    'width' => 75,
    'height' => 50
);

$config['clg_pic'] = array(
    'upload_path' => FCPATH . "uploads/colleague_profile/",
    'allowed_types' => 'jpg|jpeg|png|gif',
    'max_size' => 1024*5,
    'overwrite' => TRUE
);
$config['cq_pic'] = array(
  'upload_path' => FCPATH . "api/cq_images_video/",
  'allowed_types' => 'jpg|jpeg|png|gif|doc|docx|pdf|xlsx|mp4|mp3',
  'max_size' => 1024*5,
  'overwrite' => TRUE
);
$config['nozzle_slip'] = array(
  'upload_path' => FCPATH . "assets/images/nozzle_slip/",
  // 'allowed_types' => 'jpg|jpeg|png|gif|doc|docx|pdf|xlsx|mp4|mp3',
  'allowed_types' => 'jpg|jpeg|png',
  'max_size' => 1024*5,
  'overwrite' => TRUE
);
$config['ins_pic'] = array(
  'upload_path' => FCPATH . "inspection_api/insp_upload_file/",
  'allowed_types' => 'jpg|jpeg|png|gif|doc|docx|pdf|xlsx|mp4|mp3',
  'max_size' => 1024*5,
  'overwrite' => TRUE
);
$config['amb_pic'] = array(
    'upload_path' => FCPATH . "uploads/ambulance/",
    'allowed_types' => 'jpg|jpeg|png|gif|doc|docx|pdf|xlsx',
    'max_size' => 1024*5,
    'overwrite' => TRUE
);
////////////// colleague resume configuration //////////////
$config['clg_rsm'] = array(
    'upload_path' => FCPATH . "uploads/colleague_profile/resumes",
    'allowed_types' => 'jpg|doc|docx|pdf|png',
    'max_size' => 1024*5,
    'overwrite' => TRUE,
);
$config['gri_doc'] = array(
  'upload_path' => FCPATH . "uploads/grievance_files",
  'allowed_types' => 'doc|docx|pdf',
  'max_size' => 1024*5,
  'overwrite' => TRUE,
);
$config['gri_pic'] = array(
  'upload_path' => FCPATH . "uploads/grievance_files",
  'allowed_types' => 'jpg|jpeg|png|gif',
  'max_size' => 1024*5,
  'overwrite' => TRUE
);
////////////////// MI42 ( Total pcr steps ) ///////////////////
$config['pcr_steps'] = 10;
////////////////// MI42 ( Ambulance GPS  ) ///////////////////
//$config['amb_gps_url'] = 'http://restapi.heurogps.com/RESTFleetAPIs.svc/GetCurrentDataPointsOfDevices?partnerid={a_s_partnerid}&accountid=rubyhall&userid=rubyhall&apikey=da8dd34f1ee65a70a';
//$config['amb_gps_url'] ="https://www.nuevastech.com/API/API_Dashboard_all.aspx?username=TDDAMBULANCE&accesskey=342EA5D59EC2D64112E1";
//$config['amb_gps_url'] ="https://www.nuevastech.com/API/API_Dashboard_all.aspx?username=JKERC&accesskey=5682C1ED819E8B48FC3E";
//$config['amb_gps_url'] ="https://www.nuevastech.com/API/API_Dashboard_all.aspx?username=MEMSADMIN&accesskey=EC7206C53E1CEDA1D7B2";
$config['amb_gps_url'] ="https://Tracknovate.net/jsp/Service_vehicle.jsp?user=mpadmin&pass=asdf@108!";
$config['amb_gps_url_pcmc'] ="https://www.nuevastech.com/API/API_Dashboard_all.aspx?username=PCMCCovid&accesskey=273A94C65E37365B9FBE";
$config['amb_gps_url_pmc'] ="https://www.nuevastech.com/API/API_Dashboard_all.aspx?username=PuneCovid&accesskey=38308FB170E199B7A90E";
$config['amb_gps_url_Ahmednagar'] ="http://54.169.20.116/external_ec_apps/api/v3/vehiclesdata/civilnagar/25d55ad283aa400af464c76d713c07ad/0";
$config['amb_gps_url_bike'] = "https://www.nuevastech.com/API/API_Dashboard_all.aspx?username=MEMSBike&accesskey=BB46D16FD894C8868808";
//User: civilnagar
//Password: 12345678
$config['hospital_url'] ="https://divcommpunecovid.com/ccsws/apiList/services/getBedAvailability";

////////////////////////////////////////////////////////////////
$config['state_code'] = array("MadhyaPradesh" => "MP");
$config['default_state'] = "MP";
//$config['google_api_key'] = 'AIzaSyCcSwiJ9TapOs5uuGC5Hf_dqaGik-qFA5c';
//$config['google_api_key'] = 'AIzaSyDv9VS1rKXBfGTdDbZ5wB-sKAXambQjO8M';
$config['google_api_key'] = 'yrjPrIYd0xU9KJpe1xlaR1_K1wFrwc9U-_-99n040JQ';
//$config['google_api_key'] = 'EZZhs1ZBat_hbELCF-AJ-Q';
$config['bpcl_url'] = 'https://qa.api.cep.bpcl.in';
$config['bpcl_client_id']='ambey';
$config['bpcl_client_secret']='secret';
$config['bpcl_grant_type']='password';
$config['bpcl_username']='uat.reward86@test.com';
$config['bpcl_password']='Test@123';

$config['PAYTM_MID']='NtSytL60050758072697';
$config['PAYTM_MERCHANT_KEY']='iQPbr0NblkXoBkPK';
$config['PAYTM_WEBSITE']='WEBSTAGING';
$config['PAYTM_ENVIRONMENT']='https://securegw-stage.paytm.in';
//$config['PAYTM_ENVIRONMENT']='https://securegw.paytm.in';