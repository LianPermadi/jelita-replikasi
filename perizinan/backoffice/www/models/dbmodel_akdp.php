<?php //if (! defined('BASEPATH')) exit('No direct script access allowed!');
 
class dbmodel_akdp extends model {
 
 function __construct(){
     parent::__construct();
 }
 
 function get_dbakdp($table_name = NULL){
     $dbmysql = $this->load->database('dbakdp',TRUE);
     $q = $dbmysql->get($table_name);
     return $q->result();
 }

 function dbakdp_sql($sql = NULL){
     $dbmysql = $this->load->database('dbakdp',TRUE);
     return $dbmysql->query($sql)->result();
 }

 function dbakdp_sql_hit($sql = NULL){
     $dbmysql = $this->load->database('dbakdp',TRUE);
     return $dbmysql->query($sql)->num_rows();
 }

}
