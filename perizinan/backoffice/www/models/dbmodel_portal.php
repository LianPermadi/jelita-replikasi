<?php //if (! defined('BASEPATH')) exit('No direct script access allowed!');
 
class dbmodel_portal extends model {
 
 function __construct(){
     parent::__construct();
 }
 
 function get_dbaportal($table_name = NULL){
     $dbmysql = $this->load->database('otherdb',TRUE);
     $q = $dbmysql->get($table_name);
     return $q->result();
 }

 function dbportal_sql($sql = NULL){
     $dbmysql = $this->load->database('otherdb',TRUE);
     return $dbmysql->query($sql)->result();
 }

 function dbportal_sql_hit($sql = NULL){
     $dbmysql = $this->load->database('otherdb',TRUE);
     return $dbmysql->query($sql)->num_rows();
 }

}
