<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the "Database Connection"
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database type. ie: mysql.  Currently supported:
				 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Active Record class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the "default" group).
|
| The $active_record variables lets you determine whether or not to load
| the active record class
*/

$active_group = "default";
$active_record = TRUE;

$db['default']['hostname'] = "localhost";
$db['default']['username'] = "root";
$db['default']['password'] = "";
$db['default']['database'] = "spekta_backoffice";

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
$db['otherdb']['username'] = "root";
$db['otherdb']['password'] = "";
$db['otherdb']['database'] = "spekta_portal";

$db['otherdb']['dbdriver'] = "mysql";
$db['otherdb']['dbprefix'] = "";
$db['otherdb']['pconnect'] = FALSE;
$db['otherdb']['db_debug'] = TRUE;
$db['otherdb']['cache_on'] = FALSE;
$db['otherdb']['cachedir'] = "";
$db['otherdb']['char_set'] = "utf8";
$db['otherdb']['dbcollat'] = "utf8_general_ci";
// database backoffice

// database gammu di server bpmpt
// $db['gammu']['hostname'] = "localhost"; //"10.18.1.2";
// // $db['gammu']['hostname'] = $hostname;
// $db['gammu']['username'] = "root";
// $db['gammu']['password'] = "d1n4sPTSP;";
// $db['gammu']['database'] = "smsd";

//$db['gammu']['dbdriver'] = "mysql";
//$db['gammu']['dbprefix'] = "";
//$db['gammu']['pconnect'] = TRUE;
//$db['gammu']['db_debug'] = TRUE;
//$db['gammu']['cache_on'] = FALSE;
//$db['gammu']['cachedir'] = "";
//$db['gammu']['char_set'] = "utf8";
//$db['gammu']['dbcollat'] = "utf8_general_ci";
// database gammu di server bpmpt

/* End of file database.php */
/* Location: ./system/application/config/database.php */
