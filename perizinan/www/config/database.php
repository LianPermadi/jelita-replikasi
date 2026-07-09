<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$active_group = "default";
$active_record = TRUE;

$db['default']['hostname'] = "localhost";
$db['default']['username'] = "root";
$db['default']['password'] = "";
$db['default']['database'] = "portal";
$db['default']['dbdriver'] = "mysql";
$db['default']['dbprefix'] = "";
$db['default']['pconnect'] = FALSE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = "";
$db['default']['char_set'] = "utf8";
$db['default']['dbcollat'] = "utf8_general_ci";

// database backoffice
$db['otherdb']['hostname'] = "localhost";
$db['otherdb']['username'] = 'root'; 
$db['otherdb']['password'] = '';
$db['otherdb']['database'] = 'backoffice';
$db['otherdb']['dbdriver'] = "mysql";
$db['otherdb']['dbprefix'] = "";
$db['otherdb']['pconnect'] = FALSE;
$db['otherdb']['db_debug'] = TRUE;
$db['otherdb']['cache_on'] = FALSE;
$db['otherdb']['cachedir'] = "";
$db['otherdb']['char_set'] = "utf8";
$db['otherdb']['dbcollat'] = "utf8_general_ci";
// database backoffice