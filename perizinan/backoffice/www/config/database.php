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

$username = 'root';
$password = 'm4nokw4r1';

$db['default']['hostname'] = "localhost";
$db['default']['username'] = $username;
$db['default']['password'] = $password;
$db['default']['database'] = "manokwari_backoffice";

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
$db['otherdb']['username'] = $username;
$db['otherdb']['password'] = $password;
$db['otherdb']['database'] = "manokwari_portal";

$db['otherdb']['dbdriver'] = "mysql";
$db['otherdb']['dbprefix'] = "";
$db['otherdb']['pconnect'] = FALSE;
$db['otherdb']['db_debug'] = TRUE;
$db['otherdb']['cache_on'] = FALSE;
$db['otherdb']['cachedir'] = "";
$db['otherdb']['char_set'] = "utf8";
$db['otherdb']['dbcollat'] = "utf8_general_ci";
// database backoffice


// Data OSS
$db['ossdb']['hostname'] = "localhost";
$db['ossdb']['username'] = $username;
$db['ossdb']['password'] = $password;
$db['ossdb']['database'] = "data_oss";
$db['ossdb']['dbdriver'] = "mysql";
$db['ossdb']['dbprefix'] = "";
$db['ossdb']['pconnect'] = FALSE;
$db['ossdb']['db_debug'] = FALSE;
$db['ossdb']['cache_on'] = FALSE;
$db['ossdb']['cachedir'] = "";
$db['ossdb']['char_set'] = "utf8";
$db['ossdb']['dbcollat'] = "utf8_general_ci";



// $active_group = 'db_bb';
// $active_record = TRUE;
$db['db_bb']['hostname'] = 'localhost';
$db['db_bb']['username'] = $username;
$db['db_bb']['password'] = $password;
$db['db_bb']['database'] = 'manokwari_dbakdp';
$_SESSION['my_db']=$db['db_bb']['database'];
$db['db_bb']['dbdriver'] = 'mysql';
$db['db_bb']['dbprefix'] = '';
$db['db_bb']['pconnect'] = FALSE;
$db['db_bb']['db_debug'] = FALSE;
$db['db_bb']['cache_on'] = FALSE;
$db['db_bb']['cachedir'] = '';
$db['db_bb']['char_set'] = 'utf8';
$db['db_bb']['dbcollat'] = 'utf8_general_ci';



$db['invest']['hostname'] = 'localhost';
$db['invest']['username'] = $username;
$db['invest']['password'] = $password;
$db['invest']['database'] = 'investasiptsp_v2_db';
$_SESSION['my_db']=$db['db_bb']['database'];
$db['invest']['dbdriver'] = 'mysql';
$db['invest']['dbprefix'] = '';
$db['invest']['pconnect'] = FALSE;
$db['invest']['db_debug'] = FALSE;
$db['invest']['cache_on'] = FALSE;
$db['invest']['cachedir'] = '';
$db['invest']['char_set'] = 'utf8';
$db['invest']['dbcollat'] = 'utf8_general_ci';
// database gammu di server bpmpt

/* End of file database.php */
/* Location: ./system/application/config/database.php */
