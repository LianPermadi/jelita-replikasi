<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 *  @author  R; 
 */

class C_crud extends WRC_AdminCont {

    public function __construct() {
        parent::__construct();
        $this->load->model("crud_model");
                $this->load->helper('url');

            $enabled = FALSE;
            $list_auths = $this->session_info['app_list_auth'];

            foreach ($list_auths as $list_auth) {
                if($list_auth->id_role === '30') {
                    $enabled = TRUE;
                }
            }

            if(!$enabled) {
                redirect('dashboard');
            }
    }


//-----------------------------------------------tampil data ---------------------
    public function index() {

     $data["people"]=$this->crud_model->read();
        $this->load->vars($data);

         $js =  "function confirm_link(text){
                    if(confirm(text)){ return true;
                    }else{ return false; }
                }
                var z =jQuery.noConflict();
                z(document).ready(function() {
                        oTable = z('#izintrayek').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );
                ";
?>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>-->
<?php
       // $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "INFORMASI LINTASAN TRAYEK ANTAR KOTA";
     
        $this->template->build('crud/crud_view', $this->session_info);
    }
    


  

  function create(){
    echo json_encode(array("id"=>$this->crud_model->create()));
  }

public function user_exists()
{   
    $id= $this->input->post("id");
     $value= $this->input->post("value");
    $this->db->select('*');
    $this->db->where('nama', $value);
    $query = $this->db->get('member');

    if($query->num_rows == 0)
    {
 $this->delete();
   // $this->update();
        //if query finds one row relating to this user then execute code accordingly here
    }else{
  
    }
}
function message(){

}
  function update(){
    $id= $this->input->post("id");
    $value= $this->input->post("value");
    $modul= $this->input->post("modul");

    $this->crud_model->update($id,$value,$modul);
    echo "{}";

  }

  function delete(){
    $id= $this->input->post("id");
    $this->crud_model->delete($id);
    echo "{}";
  }


}