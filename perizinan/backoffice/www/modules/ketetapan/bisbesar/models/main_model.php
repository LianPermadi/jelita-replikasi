<?php  
 class Main_model extends Model  
 {  
      

         function check_eksis($where,$terminal_i)  
      {  
    $dbmysql2 = $this->load->database('dbakdp',TRUE);
    $dbmysql2->select('*'); 
    $dbmysql2->from('bb_tp_dwp');
    //$this->db->where('PP1_1', $where);
    $dbmysql2->where('TERMINAL_I', $terminal_i);
      $w = "(PP1_1='$where' 
      or PP1_2 = '$where'
      or PP2_1 = '$where'
      or PP2_2 = '$where'
      or PP3_1 = '$where'
      or PP3_2 = '$where'
      or PP4_1 = '$where'
      or PP4_2 = '$where'
      or PP5_1 = '$where'
      or PP5_2 = '$where'
      or PP6_1 = '$where'
      or PP6_2 = '$where'
      )";
       $dbmysql2->where($w);
   $query = $dbmysql2->get();
  
           if($query->num_rows() > 0)  
           {  
                return true;  
           }  
           else  
           {  
                return false;  
           }  
      }   
   }
 ?>  