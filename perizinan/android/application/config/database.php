<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
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
|				 NOTE: For MySQL and MySQLi databases, this setting is only used
| 				 as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
|				 (and in table creation queries made with DB Forge).
| 				 There is an incompatibility in PHP with mysql_real_escape_string() which
| 				 can make your site vulnerable to SQL injection if you are using a
| 				 multi-byte character set and are running versions lower than these.
| 				 Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
|	['swap_pre'] A default table prefix that should be swapped with the dbprefix
|	['autoinit'] Whether or not to automatically initialize the database.
|	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|							- good for ensuring strict SQL while developing
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The $active_record variables lets you determine whether or not to load
| the active record class
*/

$active_group = 'default';
$active_record = TRUE;

$db['default']['hostname'] = "localhost";
$db['default']['username'] = "root";
$db['default']['password'] = "m4nokw4r1";
$db['default']['database'] = "manokwari_portal";

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
$db['otherdb']['password'] = "m4nokw4r1";
$db['otherdb']['database'] = "manokwari_backoffice";

$db['otherdb']['dbdriver'] = "mysql";
$db['otherdb']['dbprefix'] = "";
$db['otherdb']['pconnect'] = FALSE;
$db['otherdb']['db_debug'] = TRUE;
$db['otherdb']['cache_on'] = FALSE;
$db['otherdb']['cachedir'] = "";
$db['otherdb']['char_set'] = "utf8";
$db['otherdb']['dbcollat'] = "utf8_general_ci";

$db['api']['hostname'] = "localhost";
$db['api']['username'] = "root";
$db['api']['password'] = "m4nokw4r1";
$db['api']['database'] = "api";
$db['api']['dbdriver'] = "mysql";
$db['api']['dbprefix'] = "";
$db['api']['pconnect'] = FALSE;
$db['api']['db_debug'] = TRUE;
$db['api']['cache_on'] = FALSE;
$db['api']['cachedir'] = "";
$db['api']['char_set'] = "utf8";
$db['api']['dbcollat'] = "utf8_general_ci";

$active_group = 'db_bb';
$active_record = TRUE;
$db['db_bb']['hostname'] = 'localhost';
$db['db_bb']['username'] = 'root';
$db['db_bb']['password'] = 'm4nokw4r1';
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

/* End of file database.php */
/* Location: ./application/config/database.php */