<?php  
 defined('BASEPATH') OR exit('No direct script access allowed');  
 class Cek extends WRC_AdminCont {  
 
  function index()
  {
      $data["title"] = "Check availibility using Ajax";  
           $this->load->view("v_cek_eksis", $data);  
  }

function check_eksis()  
      {  
       // $PP1_1 = $_POST["PP"];
      //  $TERMINAL_I = $_POST["T"];

        $V1 = $this->input->post('V1');
        $TERMINAL_I = $this->input->post('V2');
             
                $this->load->model("main_model");  
                if($this->main_model->check_eksis($V1,$TERMINAL_I))  
                {  
                     echo '<i style="color:red;">X</i>';  
                }  
                else  
                {  
                     echo '<i style="color:green;">OK</i>';  
                }  
           }  
           
       
 }  
 ?>  