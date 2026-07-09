<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of unitkerja class
 * @author  Dichi Al Faridi
 * @since   1.0
 * Edit PBS 2019
 */

class Unitkerja extends WRC_AdminCont {
  
  public function __construct() {
    parent::__construct();
    $enabled = FALSE;
    $list_auths = $this->session_info['app_list_auth'];
    $this->unitkerja = NULL;
    foreach ($list_auths as $list_auth) {
      if($list_auth->id_role === '4') {
        $enabled = TRUE;
        $this->unitkerja = new trunitkerja();
      }
    }
    
    if(!$enabled) {
      redirect('dashboard');
    }
  }
  
  public function index() {
    $data['list'] = $this->unitkerja->get();
    $this->load->vars($data);
    
    $js =  "
            function confirm_link(text){
              if(confirm(text)){
                return true;
              }else{
                return false; 
              }
            }
            
            $(document).ready(function() {
              oTable = $('#unitkerja').dataTable({
                      \"bJQueryUI\": true,
                      \"sPaginationType\": \"full_numbers\"
              });
            });
           ";
    
    $this->template->set_metadata_javascript($js);
    $this->session_info['page_name'] = "Setting Unit Kerja";
    $this->template->build('list', $this->session_info);
  }
  
  public function create() {
    $data['n_unitkerja']  = "";
    $data['save_method'] = "save";
    $data['id'] = "";
    $data['nm_cap'] = '';
    $js =  "
            $(document).ready(function() {
              $('#form').validate();                     
            });
           ";
    $this->template->set_metadata_javascript($js);
    $this->load->vars($data);
    $this->session_info['page_name'] = "Tambah Unit Kerja";
    $this->template->build('edit', $this->session_info);
  }
  
  public function edit($id = NULL) {
    $this->unitkerja->where('id', $id)->get();
    $data['n_unitkerja']  = $this->unitkerja->n_unitkerja;
    $data['save_method'] = "update";
    $data['id'] = $this->unitkerja->id;
    $data['nm_cap'] = $this->unitkerja->nm_cap;
    $js =  "
            $(document).ready(function() {
              $('#form').validate();                     
            });
            $(document).ready(function() {
               $('#form').validate();
               $(\"#tabs\").tabs();
					     $('a[rel*=upload_box]').facebox();
            } );
           ";
    $this->template->set_metadata_javascript($js);
    $this->load->vars($data);
    $this->session_info['page_name'] = "Edit Unit Kerja";
    $this->template->build('edit', $this->session_info);
  }
  
  public function delete($id = NULL) {
    $this->unitkerja->where('id', $id)->get();
    $tgl = date("Y-m-d H:i:s");
    $u_ser = $this->session->userdata('username');
    //$p = $this->db->query("call log ('Setting User','Delete unit kerja ".$this->unitkerja->n_unitkerja."','".$tgl."','".$u_ser."')");
    if($this->unitkerja->delete()) {
      redirect('unitkerja');
    }
  }
  
  public function save() {
    $this->unitkerja->n_unitkerja = $this->input->post('n_unitkerja');
    $tgl = date("Y-m-d H:i:s");
    $u_ser = $this->session->userdata('username');
    //$p = $this->db->query("call log ('Setting User','Insert unit kerja ".$this->input->post('n_unitkerja')."','".$tgl."','".$u_ser."')");
    
    if($this->unitkerja->save()) {
      redirect('unitkerja');
    }
  }
  
  public function update() {
    $update = $this->unitkerja->where('id', $this->input->post('id'))
                              ->update(array('n_unitkerja' => $this->input->post('n_unitkerja'),
                                             'nm_cap' => $this->input->post('nm_cap')
                                            ));
    if($update) {
      $tgl = date("Y-m-d H:i:s");
      $u_ser = $this->session->userdata('username');
      //$p = $this->db->query("call log ('Setting User','Update unit kerja ".$this->input->post('n_unitkerja')."','".$tgl."','".$u_ser."')");
      redirect('unitkerja');
    }
  }
  
  function showform($id = Null){
    $judul = "Upload File Cap Dinas (.png)";
		$data["judulapp"]=$judul;
		$data["id"]=$id;
		$viewfile="v_capload_form";
		$this->load->view($viewfile,$data);
  }
  
  function uploadfile(){   // Upload File TTD
	  $id = $this->input->post('id');  // nama file
	  $file_name = basename($_FILES["fileToUpload"]["name"]);
  	$ext = '.png';
  	$target_dir = "uploads/logo/";
    $target_file = $target_dir . $file_name;
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    if(isset($_POST["submit"])) {
      $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
      if($check !== false) {
        $uploadOk = 1;
      }else{
        $uploadOk = 0;
      }
    }
    if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    }else{
    }
		$fileBaru = $target_dir.'cap_'.$id.$ext;
    rename($target_file, $fileBaru); // mengubah nama file
    $update = $this->unitkerja->where('id', $id)
                              ->update(array('nm_cap' => 'cap_'.$id.$ext));
		redirect('unitkerja');
  }
}
// This is the end of unitkerja class