<?php //if (! defined('BASEPATH')) exit('No direct script access allowed!');
 
class dbmodel_bisbesar extends model {
 
 function __construct(){
     parent::__construct();
 }
 
 function get_dbbisbesar($table_name = NULL){
     $dbmysql = $this->load->database('dbbisbesar',TRUE);
     $q = $dbmysql->get($table_name);
     return $q->result();
 }

 function db_sql($sql = NULL){
     $dbmysql = $this->load->database('dbbisbesar',TRUE);
     return $dbmysql->query($sql)->result();
 }

 function db_sql_hit($sql = NULL){
     $dbmysql = $this->load->database('dbbisbesar',TRUE);
     return $dbmysql->query($sql)->num_rows();
 }

}
