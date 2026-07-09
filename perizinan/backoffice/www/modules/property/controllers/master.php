<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of master class
 * @author  Dichi Al Faridi @since   1.0
 * Edited PBS 12-2018
 */
class Master extends WRC_AdminCont {

  public function __construct() {
    parent::__construct();
    $this->perizinan_template = new template();
    $this->property = new trproperty();
    $this->perizinan = new trperizinan();
    $this->perizinan_poperty = new trperizinan_trproperty();
    $enabled = FALSE;
    $list_auths = $this->session_info['app_list_auth'];
    foreach($list_auths as $list_auth) {
      if($list_auth->id_role === '1') {
        $enabled = TRUE;
      }
    }
    if(!$enabled) {
      redirect('dashboard');
    }
  }

  public function index() {
    $data['list'] = $this->perizinan->where('c_aktif = 0 or c_online = 0')->order_by('id','ASC')->get();
    $data['list_izin'] = $this->perizinan->get_list();
    $this->load->vars($data);
    
    $js = "
            $(document).ready(function() {
                    oTable = $('#property').dataTable({
                            \"bJQueryUI\": true,
                            \"sPaginationType\": \"full_numbers\"
                    });
            } );
            ";
    
    $this->template->set_metadata_javascript($js);
    $this->session_info['page_name'] = "Setting Property Pendataan";
    $this->template->build('master_property', $this->session_info);
  }

  public function detail($id = NULL, $exist = NULL) {
    $list_prop = new trperizinan_trproperty();
    $list_prop->where('trperizinan_id', $id);
    $data['id_jenis'] = $id;
    $list_prop->order_by('c_parent_order', 'asc');
    $list_prop->order_by('c_order', 'asc');
    $data['list'] = $list_prop->get();
    
    $this->perizinan->where('id', $id)->get();
    $data['id'] = $this->perizinan->id;
    $data['nama_izin'] = $this->perizinan->n_perizinan;
    $data['ket_exist'] = $exist;
    
    $this->load->vars($data);
    $js = "
            function confirm_link(text){
                if(confirm(text)){ return true;
                }else{ return false; }
            }
            $(document).ready(function() {
                    oTable = $('#property_list').dataTable({
                            \"bJQueryUI\": true,
                            \"sPaginationType\": \"full_numbers\"
                    });
            } );
            ";
    
    $this->template->set_metadata_javascript($js);
    $this->session_info['page_name'] = "Setting Property";
    $this->template->build('master_property_edit', $this->session_info);
  }

  public function Upload($id = NULL, $exist = NULL){
    $this->perizinan->where('id', $id)->get();
    $data['id'] = $this->perizinan->id;
    $data['nama_izin'] = $this->perizinan->n_perizinan;
    $this->load->vars($data);
    $this->session_info['page_name'] = "Setting Property";
    $this->template->build('master_upload1', $this->session_info);
  }

  public function Upload2($id = NULL, $exist = NULL){        
    require_once 'assets/phpword/src/PhpWord/Autoloader.php';
    /////------------------------------------------------------------------------
    // var_dump($_POST);
    // var_dump($_FILES);
    // die;
    $target_dir = "assets/template/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    if(isset($_POST["submit"])) {
      $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
      if($check !== false) {
        $uploadOk = 1;
      }else{
        // die;
        $uploadOk = 0;
      }
    }
    if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    }else{
    }
    $old_name = $target_file;
    $new_name = $target_dir.$id.'.'.$imageFileType;

    if (rename($old_name, $new_name)) {
        // echo "File berhasil diubah menjadi: $new_name";
    } else {
        // echo "Gagal mengganti nama file.";
    }

    $target_dir = "assets/template-baru/";
    $asal = $new_name;
    $tujuan = $target_dir.$id.'.'.$imageFileType;

    if (copy($asal, $tujuan)) {
        // echo "File berhasil disalin ke: $tujuan";
    } else {
        // echo "Gagal menyalin file.";
    }
    /////------------------------------------------------------------------------
    function docx2text($filename) {
      return readZippedXML($filename, "word/document.xml");
    }
    $tulis_nama = array();
    $tulis_variable = array();
    function readZippedXML($archiveFile, $dataFile) {
      $zip = new ZipArchive;
      if(true === $zip->open($archiveFile)) {
        if(($index = $zip->locateName($dataFile)) !== false) {
          $data = $zip->getFromIndex($index);
          $zip->close();
          $xml = new DOMDocument();
          $xml->loadXML($data, LIBXML_NOENT | LIBXML_XINCLUDE | LIBXML_NOERROR | LIBXML_NOWARNING);
          return strip_tags($xml->saveXML());
        }
        $zip->close();
      }
      return "";
    }
    $target_dir = "assets/template/";
    $text = docx2text($target_dir.$id.'.'.$imageFileType);
    $texts = explode(" ", $text);
    $output = array();
    
    foreach($texts as $t){
      if(strpos($t, '${') !== false ){
        if(!in_array($t,$output)){
          $output[] = $t;
        }
      }
    }
    foreach($output as $o){
      $a = explode('${', $o);
      foreach($a as $hahaha){
        if(strpos($hahaha, 'n_') !== false) {
          $buang = explode('}',$hahaha);
          // print_r($buang);
          $tulis_nama[] = $buang[0];
        }
        if(strpos($hahaha, 'v_') !== false) {
          $buang = explode('}',$hahaha);
          // print_r($buang);
    	    if(!in_array($buang[0],$tulis_variable)){
            $tulis_variable[] = $buang[0];
    	  	}
        }
      }
    }
    /////------------------------------------------------------------------------
    $sql   = "select * from trperizinan where id='".$id."'";
    $query = $this->db->query($sql)->row_array();
    $data['properti'] = $query;
    $this->perizinan->where('id', $id)->get();
    $data['id'] = $this->perizinan->id;
    $data['nama_izin'] = $this->perizinan->n_perizinan;
    $data['ket_exist'] = $exist;
    
    $pilihan = "<option value='0'>-</option>";
    foreach($tulis_nama as $nama){
      $pilihan .= "<option value='".$nama."'>".$nama."</option>";
    }
    
    $pilihan2 = "<option value='0'>-</option>";
    foreach($tulis_variable as $nama2){
      $pilihan2 .= "<option value='".$nama2."'>".$nama2."</option>";
    }
    
    $data['pilihan'] = $pilihan;
    $data['pilihan2'] = $pilihan2;
    $data['jenis'] = htmlspecialchars($_POST['jenis'],ENT_QUOTES);
    $this->load->vars($data);
    $js = "
            function confirm_link(text){
                if(confirm(text)){ return true;
                }else{ return false; }
            }
            $(document).ready(function() {
                    oTable = $('#property_list').dataTable({
                            \"bJQueryUI\": true,
                            \"sPaginationType\": \"full_numbers\",
                            \"iDisplayLength\": \"500\",
                            \"aLengthMenu\": \"-\"                           
                    });
            } );
    
            ";
    
    $this->template->set_metadata_javascript($js);
    $this->session_info['page_name'] = "Setting Property";
    $this->template->build('master_upload2', $this->session_info);
  }

  public function purge($id_izin = NULL) {
    $this->property->where('id', $id_izin)->get();
    $this->property->delete();
    redirect('property/master/propertieslist');
  }

  public function delete($id_izin = NULL, $id_property = NULL) {
    $delete = new trperizinan_trproperty();
    $delete->where(array('trperizinan_id' => $id_izin,'trproperty_id' => $id_property))->get();
    $parent = $delete->c_parent;
    $delete->delete();
    
    $count = $delete->where(array('trperizinan_id' => $id_izin,'c_parent' => $parent))->count();
    
    if ($count < 2) {
      $delete->where(array('trperizinan_id' => $id_izin,'trproperty_id' => $parent))->get();
      $delete->delete();
    }
            
    $this->perizinan->where('id', $id_izin)->get();
    $tgl = date("Y-m-d H:i:s");
    $u_ser = $this->session->userdata('username');
    //$p = $this->db->query("call log ('Setting Perizinan','Delete property " . $this->perizinan->n_perizinan . "','" . $tgl . "','" . $u_ser . "')");
    redirect('property/master/detail' . "/" . $id_izin);
  }

  public function template($id = NULL, $exist = NULL, $id_izin = NULL, $id_property = NULL){
    $this->perizinan->where('id', $id)->get();
    $data['id'] = $this->perizinan->id;
    $data['nama_izin'] = $this->perizinan->n_perizinan;
    $files = $_POST['file'];
    $ids = $_POST['id'];
    $jenis = htmlspecialchars($_POST["jenis"],ENT_QUOTES);
    //echo 'post.'.$this->input->post('id').' id.'.$id.' tabel.'.$this->perizinan->id.' ids.'.$ids; die;
    switch ($jenis) {
      case 'kadis':
      	$rename =  $this->perizinan->id.".docx";
      	break;
      case 'pertek':
      	$rename =  $this->perizinan->id."_gub.docx";
      	break;
      case 'cabut':
      	$rename =  $this->perizinan->id."_cabut.docx";
      	break;
    }
    $target_a = "assets/template/". $files;
    $target_dir = "assets/template-baru/" . $rename;
    $target_files = $target_dir; 
    $uploadOk = 1;
    
    $imageFileType = pathinfo($target_files,PATHINFO_EXTENSION);
    
    if(isset($_POST["submit"])) {
      $check = getimagesize($files);
      if($check !== false) {
        $uploadOk = 1;
      }else{
        $uploadOk = 0;
      }
    }
    
    if(copy($target_a, $target_files)) {
      unset($target_a);
    }else{
      // die;
    }
    
    switch ($jenis) {
      case 'kadis':
      	$update = $this->perizinan->where('id', $this->input->post('id'))->update(array('template' => $rename));
      	break;
      case 'pertek':
      	$update = $this->perizinan->where('id', $this->input->post('id'))->update(array('template_gub' => $rename));
      	break;
      case 'cabut':
      	$update = $this->perizinan->where('id', $this->input->post('id'))->update(array('template_cabut' => $rename));
      	break;
    }

    $this->perizinan->where('id', $id)->get();
    switch ($jenis) {
      case 'kadis':
      	$this->db->delete('trperizinan_template', array('perizinan_id' => $ids));
      	break;
      case 'pertek':
      	$this->db->delete('trperizinan_template_gub', array('perizinan_id' => $ids));
      	break;
      case 'cabut':
      	$this->db->delete('trperizinan_template_cabut', array('perizinan_id' => $ids));
      	break;
    }
    
    $no = $_POST["nomor"];   
    for($q =1;$q<=$no;$q++){
      $checxbox = "cek_".$q;
      if(!empty($_POST[$checxbox])){
        $n = 'judul_'.$q;
        $v = 'value_'.$q;
        $u = 'property_id_'.$q;
        $t_nama = $_POST[$n];
        $t_value = $_POST[$v];
        $urutan_vars = $_POST[$u];  
        
        $data = array('perizinan_id' => $id,
                      'urutan_vars_teknis' => $urutan_vars,
                      't_nama' => $t_nama,
                      't_value' => $t_value);
        
        switch ($jenis) {
          case 'kadis':
            $this->db->Insert('trperizinan_template', $data);
            break;
          case 'pertek':
            $this->db->Insert('trperizinan_template_gub', $data);
            break;
          case 'cabut':
            $this->db->Insert('trperizinan_template_cabut', $data);
            break;
        }
      }
    }
    redirect('property/master/detail/' .$id);
  }

  public function dataproperty() {
    $x = 0;
    $lists = $this->property->get();
    $arr_res = array();
    foreach ($lists as $list){
      $data['id'] = $list->id;
      $data['value'] = $list->n_property;
      array_push($arr_res, $data);
    }
    $response = json_encode($arr_res);
    echo $response;
  }

  public function add($id_izin = NULL) {
    $end_var = $this->lib_date->data_property($id_izin,'1'); // ambil jumlah property
    $js = "
            $(document).ready(function() {
              $('#form').validate();
              $(\"#tabs\").tabs();
              oTable = $('#property').dataTable({
                       \"bJQueryUI\": true,
                       \"aoColumnDefs\": [
                                          { \"bSearchable\": false,\"aTargets\": [2] },
                                          { \"bSearchable\": false,\"aTargets\": [3] },
                                          { \"bSearchable\": false,\"aTargets\": [4] },
                                          { \"bSearchable\": false,\"aTargets\": [5] },
                                          { \"bSearchable\": false,\"aTargets\": [6] },
                                          { \"bSearchable\": false,\"aTargets\": [7] },
                                          { \"bSearchable\": false,\"aTargets\": [8] }
                                         ],
                       \"sPaginationType\": \"full_numbers\"
              });

              $('#uc').keyup(function() {
				    var cp_value= ucwords($(this).val(),true) ;
				    $(this).val(cp_value );
				});

				function ucwords(str,force){
				    str=force ? str.toLowerCase() : str;  
				    return str.replace(/(\b)([a-zA-Z])/g,
				    function(firstLetter){
				        return firstLetter.toUpperCase();
				    });
				}
            });
          ";
    
    $this->perizinan->get_by_id($id_izin);
    $this->template->set_metadata_javascript($js);
    $this->property->order_by('n_property', 'asc');
    $data['property_list'] = $this->property->where('c_type != ', 2)->get();
    $property = new trproperty();
    $property->order_by("n_property", "asc");
    $data['property_list2'] = $property->where('c_type', 2)->get();
    $data['perizinan_property'] = $this->perizinan->trproperty->get();
    
    $data['n_property']     = "";
    $data['c_parent']	      = "";
    $data['c_parent_order']	= "";
    $data['c_order']        = "";
    $data['c_tmp_sk']	      = "";
    $data['c_tmp_ol']       = "";
    $data['c_skrd_id']      = "";
    $data['c_tl_id']        = "";
    $data['c_type']         = "";
    $data['combo_item']     = "-";
    $data['c_aktif']        = "Ya";
    
    $data['save_method'] = "save";
    $data['id_izin'] = $id_izin;
    $data['method'] = "adding";
    $data['id_property'] = $end_var;
    
    $settings = new settings();
    $settings->where('name', 'app_enum_satuan')->get();
    $satuan = $settings->value;
    $data['satuan'] = unserialize($satuan);
        
    $this->load->vars($data);
    $this->session_info['page_name'] = "Tambah Property Baru";
    $this->template->build('master_edit', $this->session_info);
  }

  public function save() {
    $id_izin = $this->input->post('id_izin');
    $n_property = $this->input->post('n_property');
    
    $property = new trproperty();
    $property->where('n_property', $n_property)->get();
    if($property->id) {
      redirect('property/master/detail/' . $id_izin . '/' . str_replace("-", "", strtolower(url_title($n_property))));
    }else{
      $this->property->n_property = $n_property;
      $this->property->short_name = str_replace("-", "", strtolower(url_title($n_property)));
      $this->property->c_type = $this->input->post('c_type');
      $this->perizinan->where('id', $id_izin)->get();
      
      if(!$this->property->save($this->perizinan)) {
        echo '<p>' . $this->user->error->string . '</p>';
      }else{
        $this->perizinan->where('id', $id_izin)->get();
        $tgl = date("Y-m-d H:i:s");
        $u_ser = $this->session->userdata('username');
        //$p = $this->db->query("call log ('Setting Perizinan','Insert property " . $this->perizinan->n_perizinan . "','" . $tgl . "','" . $u_ser . "')");
        $this->property->where('n_property', $this->input->post('n_property'));
        $id_property = $this->property->get();
        $retribusi = new trperizinan_trproperty();
        $retribusi->where('trperizinan_id', $id_izin);
        $retribusi->where('trproperty_id', $id_property->id);
        $retribusi->update(array('c_retribusi_id' => $this->input->post('c_retribusi'),
                                 'c_sk_id' => $this->input->post('c_sk_id'),
                                 'c_skrd_id' => $this->input->post('c_skrd_id'),
                                 'c_tl_id' => $this->input->post('c_tl_id'),
                                 'c_order' => $this->input->post('c_order'),
                                 'c_parent_order' => $this->input->post('c_parent_order'),
                                 'c_parent' => $this->input->post('c_parent'),
                                 'satuan' => $this->input->post('satuan')));
        
        $this->property->where('id',  $id_property->id);
        $this->property->update(array('property_length' => $this->input->post('property_length')==''?0:$this->input->post('property_length'),
                                      'n_property' => $this->input->post('n_property'),
                                      'c_type' => $this->input->post('c_type')));
        
        redirect('property/master/detail/' . $id_izin);
      }
    }
  }

  public function savelist() {
    $id_izin = $this->input->post('id_izin');
    $property_list = $this->input->post('property');
    $property_list_len = count($property_list);
    $retribution_list = $this->input->post('retribution');
    $retribution_list_len = count($retribution_list);
    $sk_status_list = $this->input->post('sk_status');
    $sk_status_list_len = count($sk_status_list);
    $sk_tl_list = $this->input->post('tl_status');
    $sk_tl_list_len = count($sk_tl_list);
    $skrd_tl_list = $this->input->post('skrd_status');
    $skrd_tl_list_len = count($skrd_tl_list);
    
    for($i = 0; $i < $property_list_len; $i++) {
      $this->perizinan->get_by_id($id_izin);
      $this->property->get_by_id($property_list[$i]);
      $this->property->save($this->perizinan);
      $par = new trperizinan_trproperty();
      $par->where(array('trperizinan_id' => $id_izin,'trproperty_id' => $property_list[$i]))
          ->update(array('c_order' => $this->input->post('c_order_new-' . $property_list[$i]),
                         'c_parent' => $this->input->post('c_parent-' . $property_list[$i]),
                         'c_parent_order' => $this->input->post('parent-' . $property_list[$i]),
                         'satuan' => $this->input->post('c_satuan-' . $property_list[$i])));
      
      // Check if parent property already snap on perizinan
      $trproperty_id = $this->input->post('c_parent-' . $property_list[$i]);
      $c_parent = $trproperty_id;
      $trperizinan_id = $id_izin;
      
      $check = new trperizinan_trproperty();
      $count = $check->where(array('c_parent' => $c_parent,
                                   'trperizinan_id' => $trperizinan_id,
                                   'trproperty_id' => $trproperty_id))->count();
      
      if($count < 1) {
        $check->c_parent = $c_parent;
        $check->trperizinan_id = $trperizinan_id;
        $check->trproperty_id = $trproperty_id;
        $check->save_as_new();    
      }
      // End of checking
      
      if($retribution_list[$i] === $property_list[$i]) {
        $retribusi = new trperizinan_trproperty();
        $retribusi->where('trperizinan_id', $id_izin);
        $retribusi->where('trproperty_id', $property_list[$i]);
        $retribusi->update('c_retribusi_id', '1');
      }
      
      if($sk_status_list[$i] === $property_list[$i]) {
        $retribusi2 = new trperizinan_trproperty();
        $retribusi2->where('trperizinan_id', $id_izin);
        $retribusi2->where('trproperty_id', $property_list[$i]);
        $retribusi2->update('c_sk_id', '1');
      }
      
      if($sk_tl_list[$i] === $property_list[$i]) {
        $retribusi3 = new trperizinan_trproperty();
        $retribusi3->where('trperizinan_id', $id_izin);
        $retribusi3->where('trproperty_id', $property_list[$i]);
        $retribusi3->update('c_tl_id', '1');
      }
      
      if($skrd_tl_list[$i] === $property_list[$i]) {
        $retribusi4 = new trperizinan_trproperty();
        $retribusi4->where('trperizinan_id', $id_izin);
        $retribusi4->where('trproperty_id', $property_list[$i]);
        $retribusi4->update('c_skrd_id', '1');
      }
    }
    redirect('property/master/detail/' . $id_izin);
  }

  public function property($id_izin = NULL, $id_property = NULL, $no_field = NULL) {
    $this->perizinan->where('id', $id_izin)->get();
    $text = $this->lib_date->field_property($id_izin,$id_property, '1');
    
    $data['n_property']     = $this->lib_date->array_property('1',$text);
    $data['c_parent']	      = $this->lib_date->array_property('2',$text);
    $data['c_parent_order']	= $this->lib_date->array_property('3',$text);
    $data['c_order']	      = $this->lib_date->array_property('4',$text);
    $data['c_tmp_sk']	      = $this->lib_date->array_property('5',$text);
    $data['c_tmp_ol']	      = $this->lib_date->array_property('6',$text);
    $data['c_skrd_id']      = $this->lib_date->array_property('7',$text);
    $data['c_tl_id']	      = $this->lib_date->array_property('8',$text);
    $data['c_type']         = $this->lib_date->array_property('9',$text);
    $data['combo_item']     = $this->lib_date->array_property('10',$text);
    $data['c_aktif']        = $this->lib_date->array_property('11',$text);
    
    $data['id_izin'] = $id_izin;
    $data['id_property'] = $id_property;
    $data['method'] = "editing";
            $disable_field = true;
    $data['disable_field'] = $disable_field;
    $data['length'] = "100"; //$this->property->property_length;
    
    $settings = new settings();
    $settings->where('name', 'app_enum_satuan')->get();
    $satuan = $settings->value;
    $data['satuan'] = unserialize($satuan);
    $js = "$(document).ready(function(){
              $('#form').validate();
          });";
    
    $this->template->set_metadata_javascript($js);
    $this->load->vars($data);
    $this->session_info['page_name'] = "Edit Property";
    $this->template->build('master_edit', $this->session_info);
  }

  public function save_property() {
    $id_izin = $this->input->post('id_izin');
    $stat_in = $this->input->post('stat_in');
    if($stat_in === 'Edit') {
      $id_property = $this->input->post('id_property');
    }else{
      $id_property = $this->lib_date->data_property($id_izin, '1');
      $id_property++;
    }
    
    $this->perizinan->where('id', $id_izin)->get();
    $tgl = date("Y-m-d H:i:s");
    $u_ser = $this->session->userdata('username');
    //$p = $this->db->query("call log ('Setting Perizinan','Update property " . $this->perizinan->n_perizinan . "','" . $tgl . "','" . $u_ser . "')");
        
    if($this->input->post('c_type') === 'ComboBox') $combo_item = $this->input->post('combo_item'); else $combo_item = '-'; 
    $c_baru = $id_property ."^".
              $this->input->post('n_property') ."^".
              $this->input->post('c_parent') ."^".
              $this->input->post('c_parent_order') ."^".
              $this->input->post('c_order') ."^".
              $this->input->post('c_tmp_sk') ."^".
              $this->input->post('c_tmp_ol') ."^".
              $this->input->post('c_skrd_id') ."^".
              $this->input->post('c_tl_id') ."^".
              $this->input->post('c_type') ."^".
              $combo_item ."^".
              $this->input->post('c_aktif');
    
    $perizinan = new trperizinan();
    $perizinan->where('id', $id_izin);
    $perizinan->update($this->lib_date->field_property($id_izin,$id_property, '2'), $c_baru);
    redirect('property/master/detail/' . $id_izin);
  }

  public function savetampil() {
    $view = $this->input->post('view_ol');
    //$urutan = $this->input->post('urutan');
    //$id = $this->input->post('idurutan');
    //$idkembali = $this->input->post('idizin');
    //$jumlah = count($this->input->post('idurutan'));
    $hitungquery = 0;
    $i = 0;
    
    foreach($view as $urut) {
      echo $urut.' || '; 
    }
    die;
    //foreach($urutan as $urut) {
    //  $data = array('urutan' => $urut);
    //  $this->db->where('id', $id[$i]);
    //  if($this->db->update('trsyarat_perizinan', $data)) {
    //    $hitungquery++;
    //  }
    //  $i++;
    //}
    //if($hitungquery == $jumlah) {
    //  $this->session->set_flashdata('sukses', "Berhasil Edit Urutan.");
    //  redirect('perizinan/persyaratanizin/detail/'.$idkembali);
    //}else{
    //  $this->session->set_flashdata('gagal', "Gagal Edit Urutan.");
    //  redirect('perizinan/persyaratanizin/detail/'.$idkembali);
    //}
  }

  public function update() {
    $id_izin = $this->input->post('id_izin');
    $update = $this->property
                   ->where('id', $this->input->post('id_property'))
                   ->update(array('property_length' => $this->input->post('length'),
                                  'n_property' => $this->input->post('n_property'),
                                  'c_type' => $this->input->post('c_type')));
    
    $this->perizinan->where('id', $id_izin)->get();
    $tgl = date("Y-m-d H:i:s");
    $u_ser = $this->session->userdata('username');
    //$p = $this->db->query("call log ('Setting Perizinan','Update property " . $this->perizinan->n_perizinan . "','" . $tgl . "','" . $u_ser . "')");
    
    $this->property->where('n_property', $this->input->post('n_property'));
    $id_property = $this->property->get();
    
    $c_baru = $this->input->post('c_baru');
    $c_perpanjangan = $this->input->post('c_perpanjangan');
    $c_ubah = $this->input->post('c_lama');
    
    //simpan data old parent sebelum row di update
    $retribusi = new trperizinan_trproperty();
    $retribusi->where('trperizinan_id', $id_izin);
    $old_parent = $retribusi->where('trproperty_id', $id_property->id)->get();
    
    $retribusi->where('trperizinan_id', $id_izin);
    $retribusi->where('trproperty_id', $id_property->id);
    $retribusi->update(array('c_retribusi_id' => $this->input->post('c_retribusi'),
                             'c_order' => $this->input->post('c_order'),
                             'c_parent' => $this->input->post('c_parent'),
                             'c_sk_id' => $this->input->post('c_sk_id'),
                             'c_skrd_id' => $this->input->post('c_skrd_id'),
                             'c_tl_id' => $this->input->post('c_tl_id'),
                             'satuan' => $this->input->post('satuan')));
    
    $retribusi->where('trperizinan_id', $id_izin);
    $retribusi->where('c_parent', $this->input->post('c_parent'));
    $retribusi->update(array('c_parent_order' => $this->input->post('c_parent_order')));
    
    // Check if parent property already snap on perizinan
    $trproperty_id = $this->input->post('c_parent');
    $c_parent = $trproperty_id;
    $trperizinan_id = $id_izin;
    
    $check = new trperizinan_trproperty();
    $count = $check->where(array('c_parent' => $c_parent,
                                 'trperizinan_id' => $trperizinan_id,
                                 'trproperty_id' => $trproperty_id))->count();
    
    if($count < 1) {
      $this->load->model('m_rel_trperizinan_trproperty');
      $data_parent = array('c_parent' => (int)$c_parent,
                           'trperizinan_id' => (int)$trperizinan_id,
                           'trproperty_id'=> (int)$trproperty_id);
      $this->m_rel_trperizinan_trproperty->add_parent_perizinan_property($data_parent);
    }
    
    //cek apakah old parent masih mempunyai child
    //jika tidak memiliki child, old_parent di hapus
    $old_parent_child_count = $check->where(array('c_parent' => $old_parent->c_parent,
                                                  'trperizinan_id' => $trperizinan_id,
                                                  'trproperty_id !=' => $old_parent->c_parent))->count();
    
    if(empty($old_parent_child_count)){
      $old_parent_data = array('c_parent' => (int)$old_parent->c_parent,
                               'trperizinan_id' => (int)$trperizinan_id,
                               'trproperty_id' => (int)$old_parent->c_parent);
      $this->m_rel_trperizinan_trproperty->delete_parent_perizinan_property($old_parent_data);
    }
    // End of checking
    redirect('property/master/detail/' . $this->input->post('id_izin'));
  }

  public function propertieslist() {
    $js = "
            $(document).ready(function() {
                    oTable = $('#property').dataTable({
                            \"bJQueryUI\": true,
                            \"sPaginationType\": \"full_numbers\"
                    });
            } );
            ";
    
    $this->template->set_metadata_javascript($js);
    $data['list'] = $this->property->get();
    $this->load->vars($data);
    $this->session_info['page_name'] = "List Status Property";
    $this->template->build('properties_list', $this->session_info);
  }

  public function propertydetail($id = NULL) {
    $this->property->where('id', $id);
    $this->property->get();
    
    $data['id'] = $this->property->id;
    $data['n_property'] = $this->property->n_property;
    $data['status_cont'] = $this->property->c_type;
    $data['save_method'] = "update";
    
    $js = "$(document).ready(function(){
                $('#form').validate();
                $(\"#tabs\").tabs();
          });";
    
    $this->template->set_metadata_javascript($js);
    
    $this->load->vars($data);
    $this->session_info['page_name'] = "Detail Property";
    $this->template->build('property_detail', $this->session_info);
  }

  public function addmoredetail($id_izin = NULL, $id_property = NULL) {
    $this->property->where('id', $id_property)->get();
    $data['nama_property'] = $this->property->n_property;
    $data['id_izin'] = $id_izin;
    $data['id_property'] = $id_property;
    
    $rel_perizinan = new trperizinan();
    $rel_perizinan->where('id', $id_izin)->get();
    $rel_perizinan->trproperty->include_join_fields()->get();
    
    $this->load->vars($data);
    $this->session_info['page_name'] = $rel_perizinan->trproperty->join_id;
    $this->template->build('master_property_detail_list', $this->session_info);
  }

  public function addpropertydetail() {
    $data['id'] = "";
    $data['n_property'] = "";
    $data['status_cont'] = "";
    $data['save_method'] = "save";
    
    $js = "
            $(document).ready(function() {
                $('#form').validate();
                $(\"#tabs\").tabs();
            } );
        ";
    $this->template->set_metadata_javascript($js);
    
    $this->load->vars($data);
    $this->session_info['page_name'] = "Detail Property";
    $this->template->build('property_detail', $this->session_info);
  }

  public function propertyedit($save_method = NULL) {
    if($save_method === 'update') {
      $tgl = date("Y-m-d H:i:s");
      $u_ser = $this->session->userdata('username');
      //$p = $this->db->query("call log ('Setting Perizinan','Update property " . $this->input->post('n_property') . "','" . $tgl . "','" . $u_ser . "')");
      
      $id = $this->input->post('id');
      $n_property = $this->input->post('n_property');
      $c_type = $this->input->post('c_type');
      $short_name = str_replace("-", "", strtolower(url_title($n_property)));
      $update = $this->property
                     ->where('id', $id)
                     ->update(array('n_property' => $n_property,
                                    'short_name' => $short_name,
                                    'c_type' => $c_type));
      
      if($update) {
        redirect('property/master/propertieslist');
      }
    }else{
      if($save_method === 'save') {
         $this->property->n_property = $this->input->post('n_property');
         $this->property->c_type = $this->input->post('c_type');
         $short_name = str_replace("-", "", strtolower(url_title($this->input->post('n_property'))));
         $this->property->save();
         $tgl = date("Y-m-d H:i:s");
         $u_ser = $this->session->userdata('username');
         //$p = $this->db->query("call log ('Setting Perizinan','Tambah jenis property " . $this->input->post('n_property') . "','" . $tgl . "','" . $u_ser . "')");
         redirect('property/master/propertieslist');
      }
    }  
  }

  public function preview_sk($id_perizinan = NULL){
    $nodaftar = 'PREVIEW_'.$id_perizinan;
    $menu = 1;

    $id_izin = $this->input->post('id_izin');
    $jumlah = $this->lib_date->data_property($id_izin,'1');
    $i = 1;
    $datpermohonan = array();
      while ($i <= $jumlah) {
        //$id_daftar = $this->input->post('id_daftar');
        //$data_property = $this->lib_date->isi_property($id_daftar, $i, '1');
        
        // $permohonan = new tmpermohonan();
        //       $permohonan->where('id', $id_daftar);
        // $permohonan->trperizinan->get();
              
        // $hitung = strlen($data_property);
        //       $cek_posisi = strpos($data_property,'^'); 
        //       $data_property = substr($data_property,$cek_posisi+1,$hitung-$cek_posisi);
        //       if($data_property == '') $data_property = '-';
        
        
        $nama_fild = 'dt_teknis'.$i;
        
        $kelompok = new trkelompok_perizinan_trperizinan();
        $kelompok->where('trperizinan_id', $id_perizinan)->get();
        if($kelompok->trkelompok_perizinan_id != '1' && $kelompok->trkelompok_perizinan_id != '3' && $kelompok->trkelompok_perizinan_id != '5')
        $isi_fild = $this->input->post('vdt_teknis'.$i).'^'.$this->input->post('vdt_teknis'.$i);
        else
        $isi_fild = $this->input->post('vdt_teknis'.$i).'^'.$data_property;
        $datpermohonan[$nama_fild] = $isi_fild;
        $i++;
        $nama_fild = '';
        $isi_fild = '';
      }

    // $datizin = $this->db->order_by('id', 'DESC')->get_where('tmpermohonan_trperizinan', array('trperizinan_id' => $id_perizinan))->first_row();

    // $datmohon = $this->db->order_by('id', 'DESC')->get_where('tmpermohonan', array('id' => $datizin->tmpermohonan_id))->first_row();

    // $id_daftar = $datmohon->pendaftaran_id;

    $a = "select * from tmpegawai where status = '1'";
    $hasil = $this->db->query($a)->row_array();
    //$a22 = "select * from tmpermohonan where id ='".$id_daftar."'";
    //$hasil22 = $this->db->query($a22)->row_array();
    //$nodaftar = $hasil22['pendaftaran_id'];
    
    $b = "select * from trperizinan where id = '".$id_izin."'";
    //var_dump($b);die;
    $hasil2 = $this->db->query($b)->row_array();
    $e_sertifikat = $hasil2['e_sertifikat'];
    
    $d = "select * from trmengingat 
          where id in(select trmengingat_id from trmengingat_trperizinan where trperizinan_id ='".$hasil2['id']."') order by jenis,nomor,tahun asc";
    $hasil4 = $this->db->query($d)->result();
    $e = "select * from trmenimbang where id in(select trmenimbang_id from trmenimbang_trperizinan where trperizinan_id ='".$hasil2['id']."')";
    $hasil5 = $this->db->query($e)->result();
    $f = "select * from trmemperhatikan where id in(select trmemperhatikan_id from trmemperhatikan_trperizinan where trperizinan_id ='".$hasil2['id']."')";
    $hasil6 = $this->db->query($f)->result();        
    // $g = "select * from tmsk where id in(select tmsk_id from tmpermohonan_tmsk where tmpermohonan_id ='".$id_daftar."')";
    // $hasil7 = $this->db->query($g)->row_array(); 

    // $kota = "select * from trkabupaten 
    //          where id in(select trkabupaten_id from trkabupaten_trkecamatan 
    //          where trkecamatan_id in(select id from trkecamatan 
    //          where id in(select trkecamatan_id from trkecamatan_trkelurahan 
    //          where trkelurahan_id in(select id from trkelurahan 
    //          where id in(select trkelurahan_id from tmpemohon_trkelurahan 
    //          where tmpemohon_id in(select tmpemohon_id from tmpemohon_tmpermohonan 
    //          where tmpermohonan_id = (select id from tmpermohonan where id = '".$id_daftar."'))))))) ";
    // $sqlkota = $this->db->query($kota)->row_array();
         
    // $pemohon_portal = new tmpemohon_portal();                      
    // $pemohon_portal->where('id', $hasil22['id_pemohon_portal'])->get();
    $nib = '123456';
    if($nib == '') $nib='-';                    
         
    // $surat_keluar = new tmsurat_keluar();
    // $surat_keluar->where('tmpermohonan_id', $id_daftar)->get();
    // $tgl_surat = $surat_keluar->tgl_surat;
    // $no_pertek = $surat_keluar->no_pertek_awal . $surat_keluar->no_surat . $surat_keluar->no_pertek_akhir;
    // if($surat_keluar->no_pertek_awal == '') $no_pertek = '503 / ' . $surat_keluar->no_surat . ' / Pelper';
    // if($surat_keluar->no_surat == '') $no_pertek = '-';
    
    require_once 'assets/phpword/src/PhpWord/Autoloader.php';
    \PhpOffice\PhpWord\Autoloader::register();

    switch($menu){
      case 1 :  // SK
        $isSK = TRUE;
        $redirect = str_replace(' ', '','SK_'.$nodaftar);
        $string3 = "select * from trperizinan_template 
                    where perizinan_id = '".$id_perizinan."' ";
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('assets/template-baru/'.$hasil2['template']);
        break;
      case 2 :  // Sartek
        $isSK = FALSE;
        $redirect = str_replace(' ', '','PT_'.$nodaftar);
        $string3 = "select * from trperizinan_template_gub 
                    where perizinan_id = '".$id_perizinan."' ";
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('assets/template-baru/'.$hasil2['template_gub']);
        break;
      // case 3 : // Upload
      //   $isSK = TRUE;
      //   $redirect = str_replace(' ', '','SK_'.$nodaftar);
      //   $string3 = "select * from trperizinan_template 
      //               where perizinan_id = (select trperizinan_id from tmpermohonan_trperizinan where tmpermohonan_id ='".$id_daftar."') ";
      //   $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('naskah_izin/'.$hasil22['pendaftaran_id'].'.docx');
      //   break;
    }
    $c = $string3;
    $hasil3 = $this->db->query($c)->result();

    $arrblnRomawi = array("I","II","III","IV","V","VI",'VII','VIII','IX','X','XI','XII');
    $blnRomawi = $arrblnRomawi[date("m")-1];

    ############################################
    #                                          #
    #   NEW QUERY PEMOHON DAN PERUSAHAAN       #
    #                                          #
    ############################################
    // $qqq = "select * from tmpemohon where id = (select tmpemohon_id from tmpemohon_tmpermohonan where tmpermohonan_id = '".$id_daftar."')";
    // $dt_pemohon = $this->db->query($qqq)->row_array();
    // $qqq2 = "select * from tmperusahaan where id = (select tmperusahaan_id from tmpermohonan_tmperusahaan where tmpermohonan_id = '".$id_daftar."')";
    // $dt_pemohon2 = $this->db->query($qqq2)->row_array();
    $bulanArr = array("Januari",'Februari',"Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
    $expl = explode("-",date('Y-m-d'));
    $blnIndo = "$expl[2] ".$bulanArr[$expl[1]-1]." $expl[0]";
      $nperusahaan = 'PT TESTING';
      $alamatperusahaan = 'Rancaekek Permai Buah Dua Blok D No 28';
      $npwpperusahaan = '123.567';
      // $perusahaan = new tmperusahaan();
      // $perusahaan->get_by_id($dt_pemohon2['id']);
      // $kelurahan = $perusahaan->trkelurahan->get();
      // $kecamatan = $perusahaan->trkelurahan->trkecamatan->get();
      // $kabupaten = $perusahaan->trkelurahan->trkecamatan->trkabupaten->get();
      // $provinsi = $perusahaan->trkelurahan->trkecamatan->trkabupaten->trpropinsi->get();
      $desaperusahaan = 'Rancaekek Wetan';
      $kecperusahaan  = 'Rancaekek';
      $kabperusahaan  = 'Kab.Tasikmalaya';
      $provperusahaan = 'Tasikmalaya';

    if($menu == 2){
      $nosk     = '';
      $tgl_sk   = '0000-00-00';
    }else{  
      $nosk     = '123/1/CONTOHSK/'.$blnRomawi;
      $tgl_sk   = date('Y-m-d');
    }
    $namaizin = $hasil2['n_perizinan'];
    $id_izin  = $hasil2['id'];
    
    // Ttd SK

    // if ((strtotime($tgl_sk) >= strtotime('2019-04-04') && strtotime($tgl_sk) <= strtotime('2019-04-12')) || (strtotime($hasil7['tgl_penetapan']) >= strtotime('2019-04-04') && strtotime($hasil7['tgl_penetapan']) <= strtotime('2019-04-12'))) {
    //   $pegawai = new tmpegawai();
    //   $pegawai = $pegawai->where('id', '831')->get(); //ID PLH/PLT Kadis di tmpegawai
    // } else {
      $pegawai = new tmpegawai();
      $pegawai = $pegawai->where('status', '1')->get();
    //}
    
    $jbt     = $pegawai->n_jabatan;

    $nmjbt  = explode(" ", $jbt); 

    //update jabatan kadis kalau ada Plh
    if (strtolower($nmjbt[0]) == 'plh.' || strtolower($nmjbt[0]) == 'plt.') {
      $nmjbt = array_map('strtoupper', $nmjbt);

      if (strtolower($nmjbt[0]) == 'plh.') {
        $jab = 'Plh.';
      } else {
        $jab = 'Plt.';
      }

      $arr = array($jab, $nmjbt[1], $nmjbt[2], $nmjbt[3], $nmjbt[4], $nmjbt[5], $nmjbt[6], $nmjbt[7], $nmjbt[8], $nmjbt[9]);
      $jbt = implode(" ", $arr);
    } else {
      $jbt = strtoupper($jbt);
    }
    //end update jabatan

    // $ttd     = base_url().'uploads/logo/pantas.jpg' ;
    // http://spekta.tasikmalayakab.go.id/spekta/backoffice/uploads/logo/ttdblue.png
    // echo $ttd; die;
    $ttd_kepala  = $pegawai->n_pegawai;
    $ttd_pangkat = $pegawai->pangkat_gol;
    $ttd_nip     = $pegawai->nip;
    // EOF() Ttd SK
           
    //Create Konten Izin untuk di kunci
    $konten = $this->lib_date->all_property($id_izin, '123');
    $kontenizin = 'ID. '.$nodaftar.$konten;
    $kontenizin = trim($kontenizin);
    //EOF() Create Konten Izin untuk di kunci

    //Create QRCode
    include('./assets/qrcode/qrlib.php');
    $tempDir = 'uploads/data_qrcode_preview/';
    //$link = 'http://spekta.tasikmalayakab.go.id/spekta/main/cekiz/index/';
    $link = 'https://spekta.tasikmalayakab.go.id';
    $key = 'ky_'.md5('123'); // Create Content Key
    //$codeContents = 'ID._'.$nodaftar.'_NoSurat:_'.$nosk.'_TglSurat:_'.$tgl_sk;
    $codeContents = '123';
    //if($isSK){ // jika SK Izin
      //$codeContents = $link.$codeContents.'_idkeySK.'.$key;
    //}else{     // jika Sartek
      $codeContents = $link.$codeContents;//.'_idkeyST.'.$key;
    //}
    //$codeContents = str_replace(' ', '_',$codeContents);
    $fileName = 'iz_'.md5($codeContents).'.png';  // Create ID Naskah Key
    $pngAbsoluteFilePath = $tempDir.$fileName;
    $urlRelativeFilePath = base_url().$tempDir.$fileName; //EXAMPLE_TMP_URLRELPATH.$fileName;
    if(!file_exists($tempDir))    { mkdir($tempDir); }    #kalau folder belum ada, maka buat.
      
    if(!file_exists($pngAbsoluteFilePath)) {  # jika file qrcode id_izin tidak ada  
      $quality = 'H'; //ada 4 pilihan, L (Low), M(Medium), Q(Good), H(High)
      $ukuran = 5;    //batasan 1 paling kecil, 10 paling besar
      $padding = 0;
      QRCode::png($codeContents,$tempDir.$fileName,$quality,$ukuran,$padding);
      // $s_izin = new tmpermohonan();
      // $s_izin->where('id', $id_daftar)->update('file_naskah', $fileName);
      // $s_izin->where('id', $id_daftar)->update('file_konten', $key); 
    }
    //EOF() Create QRCode
    
    //Create Variabel => transfer variabel pencetakan All
    // hindari input data menggunakan karakter & < >
    $templateProcessor->setValue("provinsi",'PROVINSI TASIKMALAYA');                               // Nama Provinsi Penandatangan
    $templateProcessor->setValue("jabatan",$jbt);                                     // Jabatan Penandatangan
    $templateProcessor->setValue("kepala",$ttd_kepala);                                           // Nama Kepala Penandatangan
    $templateProcessor->setValue("pangkat",$ttd_pangkat);                                         // Pangkat Penandatangan
    $templateProcessor->setValue("nip",$ttd_nip);                                                 // NIP Penandatangan
    $templateProcessor->setValue("nopendaftaran",$nodaftar." (nodaftar)");                                      // Nomor Pendaftaran
    $templateProcessor->setValue("tgl_daftar",$blnIndo." (tgl_daftar)");                                          // Tanggal Pendaftaran
    $templateProcessor->setValue("npemohon","Asep Testing (npemohon)");                            // Nama Pemohon
    $templateProcessor->setValue("nperusahaan",$nperusahaan." (nperusahaan)");                                     // Nama Perusahaan
    $templateProcessor->setValue("alamatperusahaan",$alamatperusahaan." (alamatperusahaan)");                           // Alamat Perusahaan
    $templateProcessor->setValue("perusahaan_npwp",$npwpperusahaan." (perusahaan_npwp)");                              // NPWP Perusahaan
    $templateProcessor->setValue("perusahaan_prov",$provperusahaan." (perusahaan_prov)");                              // Alamat Perusahaan Provinsi
    $templateProcessor->setValue("perusahaan_kab",$kabperusahaan." (perusahaan_kab)");                                // Alamat Perusahaan Kab/Kota
    $templateProcessor->setValue("perusahaan_kec",$kecperusahaan." (perusahaan_kec)");                                // Alamat Perusahaan Kecamatan
    $templateProcessor->setValue("perusahaan_desa",$desaperusahaan." (perusahaan_desa)");                              // Alamat Perusahaan Desa/Kelurahan
    $templateProcessor->setValue("namaizin",$namaizin);                                           // Nama Izin
    $templateProcessor->setValue("nosk",$nosk);                                                   // Nomor SK
    $templateProcessor->setValue("tglsk",$this->lib_date->mysql_to_human($tgl_sk));               // Tanggal SK
    $templateProcessor->setValue("bulanromawi",$blnRomawi);                                       // Bulan Romawi Sekarang
    $templateProcessor->setValue("tahunini",date("Y"));                                           // Tahun Sekarang
    $templateProcessor->setValue("tgl_sekarang",$this->lib_date->mysql_to_human(date("Y-m-d")));  // tanggal Sekarang
    $templateProcessor->setValue("no_mohon_sartek","123/SARTEK/X/2019 (no_mohon_sartek)");                                   // nomor permohonan pertek ke tim teknis
    $templateProcessor->setValue("tgl_mohon_sartek",$this->lib_date->mysql_to_human(date("Y-m-d"))); // tanggal permohonan pertek ke tim teknis
    $templateProcessor->setValue("nib",$nib);                                                     // Nomor Induk Berusaha
    
      
    //Ambil dan Tampilkan QrCode
    $image_path = 'uploads/data_qrcode_naskah/qr.png';
    $templateProcessor->setImg('qrcode', array('src' => $image_path,'size' => array( 110, 110 )));// QrCode
    
    //Ambil dan Tampilkan TTD Kadis        
    $image_path = 'uploads/logo/'.str_replace(' ', '', $ttd_nip).'.png';
    $templateProcessor->setImg('ttd', array('src' => $image_path,'size' => array( 140, 87 )));    // ttd kadis

    //Ambil dan Tampilkan Kop Surat
    $image_path = 'uploads/logo/kop.png';
    $templateProcessor->setImg('kopsurat', array('src' => $image_path,'size' => array( 810, 150 ))); // ttd Kop Surat
    
    //Ambil dan Tampilkan BSrE
    // if($e_sertifikat == 1){
    //   $image_path = 'uploads/logo/bsre.png';
    //   $templateProcessor->setImg('bsre', array('src' => $image_path,'size' => array( 795, 80 ))); // Logo Bsre
    // }else{
    //   $image_path = 'uploads/logo/nonbsre.jpg';
    //   $templateProcessor->setImg('bsre', array('src' => $image_path,'size' => array( 600, 80 ))); // Logo Bsre
    // }
    
    //Ambil dan Tampilkan Cap Dinas
    $image_path = 'uploads/logo/CapDinas.png';
    $templateProcessor->setImg('CapDinas', array('src' => $image_path,'size' => array( 150, 150 ))); // ttd Cap Dinas
    
    //Create Variabel => transfer variabel pencetakan All EOF()
    ############################################
    #                                          #
    # END OF NEW QUERY PEMOHON DAN PERUSAHAAN  #
    #                                          #
    ############################################
           
    //menimbang--------------
    
    function docx2text($filename) {
      return readZippedXML($filename, "word/document.xml");
    }
    $tulis_nama = array();
    $tulis_variable = array();

    function readZippedXML($archiveFile, $dataFile) {
      $zip = new ZipArchive;
      if(true === $zip->open($archiveFile)) {
        if(($index = $zip->locateName($dataFile)) !== false) {
          $data = $zip->getFromIndex($index);
          $zip->close();
          $xml = new DOMDocument();
          $xml->loadXML($data, LIBXML_NOENT | LIBXML_XINCLUDE | LIBXML_NOERROR | LIBXML_NOWARNING);
          return strip_tags($xml->saveXML());
        }
        $zip->close();
      }
      return "";
    }
        
    if($menu==1) $text = docx2text('assets/template-baru/'.$hasil2['template']);
    if($menu==2) $text = docx2text('assets/template-baru/'.$hasil2['template_gub']);
    //if($menu==3) $text = docx2text('naskah_izin/'.$hasil22['pendaftaran_id'].'.docx');
        
    $texts = explode(" ", $text);
    $output = array();
    $output2 = array();
    $output3 = array();
    foreach($texts as $t) {
      if(strpos($t, '${menimbang}') !== false)     $output[] = $t;
      if(strpos($t, '${mengingat}') !== false)     $output2[] = $t;
      if(strpos($t, '${memperhatikan}') !== false) $output3[] = $t;
    }
          
    //menimbang--------------
    if(count($output) > 0){
      $no = 1;
      if(count($hasil5) > 0){
        $templateProcessor->cloneRow('menimbang', count($hasil5));
        foreach($hasil5 as $ha5){
          $templateProcessor->setValue("menimbang#".$no,$ha5->deskripsi);
          $no++;
        }
        $no = 1;
        foreach($hasil5 as $ha5){
          $templateProcessor->setValue("No1#".$no,$no);
          $no++;
        }
      }else{
        $templateProcessor->setValue("menimbang","");
        $templateProcessor->setValue("No1","");
      }
    }
    //EOF() menimbang---------

    //mengingat---------------
    if(count($output2) > 0){
      $no = 1;
      if(count($hasil4) > 0){
        $templateProcessor->cloneRow('mengingat', count($hasil4));
        foreach($hasil4 as $ha4){
          $templateProcessor->setValue("mengingat#".$no,$ha4->deskripsi);
          $no++;
        }
        $no = 1;
        foreach($hasil4 as $ha4){
          $templateProcessor->setValue("No2#".$no,$no);
          $no++;
        }
      }else{
        $templateProcessor->setValue("mengingat","");
        $templateProcessor->setValue("No2","");
      }
    }
    //EOF() mengingat---------   
  
    //memperhatikan-----------
    if(count($output3) > 0){ 
      $no = 1;
      if(count($hasil6) > 0){
        $templateProcessor->cloneRow('memperhatikan', count($hasil6));
        foreach($hasil6 as $ha6){
          $templateProcessor->setValue("memperhatikan#".$no,$ha6->deskripsi);
          $no++;
        }
        $no = 1;
        foreach($hasil6 as $ha6){
          $templateProcessor->setValue("No3#".$no,$no);
          $no++;
        }
      }else{
        $templateProcessor->setValue("memperhatikan","");
        $templateProcessor->setValue("No3","");
      }
    }
    //EOF() memperhatikan-----

    // $cx = $this->db->query("SELECT * from revisi where id_permohonan = $id_daftar order by tgl_revisi desc limit 1")->row_array();
    // $cxv = $this->db->query("SELECT * from revisi where id_permohonan = $id_daftar order by tgl_revisi desc")->result();
    // $cx3 = count($cxv);
    // $blnID = array("Januari","Februari","Maret",'April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'); 
    // if($cx3 == 0){
      $templateProcessor->setValue("text_atas","Text Atas");
      $templateProcessor->setValue("text_alasan1","Text Alasan 1");
      $templateProcessor->setValue("text_alasan2","Text Alasan 2");
      $templateProcessor->setValue("No4","Value No4");
      $templateProcessor->setValue("t1","Value T1");
      $templateProcessor->setValue("t2","Value T2");
      $templateProcessor->setValue("t3","Value T3");
      $templateProcessor->setValue("t4","Value T4");
      $templateProcessor->setValue("t5","Value T5");
      $templateProcessor->setValue("No5","Value No5");
      $templateProcessor->setValue("prop","Value Prop");
      $templateProcessor->setValue("dari", "Value Dari");
      $templateProcessor->setValue("menjadi","Value Menjadi");
      $templateProcessor->setValue("tgl_berubah","Tanggal Perubahan");
    // }else{
    //   $arr1 = array();
    //   $arr2 = array();
    //   foreach ($cxv as $key) {
    //     $arr1[] = $key->id;
    //     $arr2[$key->id] = $key->tgl_revisi; 
    //   }
    //   $many1 = implode(",", $arr1);
    //   $cx2 = $this->db->query("SELECT * FROM detail_revisi where id_revisi in($many1) order by data asc,id asc");
    //   $cx4 = $cx2->result();
        
    //   $templateProcessor->setValue("text_atas"," ");
    //   $templateProcessor->setValue("text_alasan1","(Catatan perubahan) : ");
    //   $templateProcessor->setValue("text_alasan2","");
    //   $templateProcessor->setValue("No4"," ");
    //   $templateProcessor->setValue("t1","No.");
    //   $templateProcessor->setValue("t2","Properti");
    //   $templateProcessor->setValue("t3","Semula");
    //   $templateProcessor->setValue("t4","Menjadi");
    //   $templateProcessor->setValue("t5","Tanggal Berubah");
    //   $templateProcessor->cloneRow('No5', count($cx4));
    //   $u = 1;
    //   foreach($cx4 as $cc){
    //     $wa = explode(" ",$arr2[$cc->id_revisi]);
    //     $templateProcessor->setValue("No5#".$u,"$u");
    //     $templateProcessor->setValue("prop#".$u,$cc->data);
    //     $templateProcessor->setValue("dari#".$u, $cc->asal);
    //     $templateProcessor->setValue("menjadi#".$u,$cc->jadi);
    //     $templateProcessor->setValue("tgl_berubah#".$u,$wa[0]);
    //     $u++;
    //   }
    // }

    foreach ($hasil3 as $data) {
      $tek = "var_teknis".$data->urutan_vars_teknis;
      $prop = $hasil2[$tek];
      if(empty($prop)){
        break;
      }
      $array = explode("^",$prop);   
      $tek2 = "dt_teknis".$data->urutan_vars_teknis;
      $prop2 = $datpermohonan[$tek2];
      $prop2 = str_replace("&","-",$prop2);  // tanda & mengakibatkan error
      if(empty($prop)){ break; }
    
      $array2 = explode("^",$prop2);   
      if($data->t_value == "v_pokja"){
        $data->t_value = "v_tanggalpertek2";
      }
      if(strtotime($array2[1])){
        $bulanArr = array("Januari",'Februari',"Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
        $expl = explode("-",$array2[1]);
        $array2[1] = "$expl[2] ".$bulanArr[$expl[1]-1]." $expl[0]";
      }
      $templateProcessor->setValue($data->t_nama,$array[1]);
      $templateProcessor->setValue($data->t_value,$array2[1]);
    }
            
    $kota = explode(' ', 'Tasikmalaya');
    if($kota[0] == 'KOTA') {
      $templateProcessor->setValue('wal/bup','Walikota '.ucfirst(strtolower($kota[1])));
    }else{
      $templateProcessor->setValue('wal/bup','Bupati '.ucfirst(strtolower($kota[1])));      
    }
 
    if($kota[0] == 'KOTA'){
      $templateProcessor->setValue('ket','Kota'); 
      $templateProcessor->setValue('kota',ucfirst(strtolower($kota[1]))); 
    }else{
      $templateProcessor->setValue('ket','Kab.'); 
      $templateProcessor->setValue('kota',ucfirst(strtolower($kota[1]))); 
    }

    //Create File docx
    $file_target = 'assets/docx-preview/'.$redirect.'.docx';
    $simpan = $templateProcessor->saveAs($file_target);
    //EOF() Create File docx

      // Konfersi docx ke pdf di folder backoffice/assets/skpdf
      $draft = FALSE;
      if($menu != 2){ // jika bukan Sartek
        if($e_sertifikat == 1) {   //penggunaan SE 
          if(file_exists('assets/sktest/'.$redirect.'.pdf')){
            unlink('assets/sktest/'.$redirect.'.pdf');
          }
          $namafile = preg_replace('/\s/i', '%20', $redirect); //isi 'namafile' dengan value nama file
          $opts = array('http' => array('header' => "User-Agent:MyAgent/1.0\r\n"));
          $context = stream_context_create($opts);
          $data = file_get_contents('http://10.18.1.2/nrspdf/web/index.php?r=site%2Fpreview&id='.$namafile, FALSE, $context);
          if($data && $data == 'OK') {
            $dtpdf = 'http://10.18.1.2/nrspdf/web/assets/skpdfpreview/' .preg_replace('/\s/i', '%20', $namafile). '.pdf';
            $newfile = $_SERVER['DOCUMENT_ROOT']. '/spekta/backoffice/assets/sktest/'.$namafile.'.pdf';
            if (copy($dtpdf, $newfile)) {
              $draft = TRUE;
              file_get_contents('http://10.18.1.2/nrspdf/web/index.php?r=site%2Fdelpreview&id='.$namafile.'&token=m1WOvGqS7G', FALSE, $context);
              echo 'Sukses';
            }
          }else{
            echo "Gagal";die;
          }
        }
      }
      
      if($menu == 2){ // jika Sartek
        if(file_exists('assets/sktest/'.$redirect.'.pdf')){
          unlink('assets/sktest/'.$redirect.'.pdf');
        }
        $namafile = preg_replace('/\s/i', '%20', $redirect); //isi 'namafile' dengan value nama file
        $opts = array('http' => array('header' => "User-Agent:MyAgent/1.0\r\n"));
        $context = stream_context_create($opts);
        $data = file_get_contents('http://10.18.1.2/nrspdf/web/index.php?r=site%2Fpreview&id='.$namafile, FALSE, $context);
        if($data && $data == 'OK') {
            $dtpdf = 'http://10.18.1.2/nrspdf/web/assets/skpdfpreview/' .preg_replace('/\s/i', '%20', $namafile). '.pdf';
            $newfile = $_SERVER['DOCUMENT_ROOT']. '/spekta/backoffice/assets/sktest/'.$namafile.'.pdf';
            if (copy($dtpdf, $newfile)) {
              $draft = TRUE;
              file_get_contents('http://10.18.1.2/nrspdf/web/index.php?r=site%2Fdelpreview&id='.$namafile.'&token=m1WOvGqS7G', FALSE, $context);
              echo 'Sukses';
            }
        }else{
          echo "Gagal";die;
        }
      }
      // EOF() Konfersi docx ke pdf di folder backoffice/assets/skpdf
      
      //Create Draft Naskah
      if($draft){
        $file = $redirect.'.pdf';
        $file_draft = 'DRAFT'.$redirect.'.pdf';
        $lok_fileDr = 'assets/sktest/';
        $lok_fileWm = 'assets/sktestWM/';
        $lok_fileSE = 'assets/esigntest/';
        $this->load->helper('download');
        if(file_exists($lok_fileDr.$file)){              // cek PDF Draft
          if(file_exists($lok_fileSE.$file)){            // cek PDF SE
            $data = file_get_contents($lok_fileSE.$file);
            //force_download($file, $data);
          }else{  
            if(file_exists($lok_fileWm.$file)){          // cek PDF WaterMark 
              $data = file_get_contents($lok_fileWm.$file);
              //force_download($file, $data);
            }else{
              //Create pdf watermark
              $this->load->library('cfpdf');
              $this->load->library('cfpdi');
              $pdf = new FPDI();
              $filename  = $_SERVER['DOCUMENT_ROOT'] .'/spekta/backoffice/assets/sktest/'.$file; //Lokasi File Tanpa WaterMark
              $filenameW = $_SERVER['DOCUMENT_ROOT'] .'/spekta/backoffice/assets/sktestWM/'.$file;    //Lokasi File WaterMark
              try{
                $pageCount = $pdf->setSourceFile($filename);
                for($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                  $templateId = $pdf->importPage($pageNo);
                  $size = $pdf->getTemplateSize($templateId);
                  $Wpaper = 220;
                  $Hpaper = 450;
                  $pdf->AddPage('P',array($Hpaper,$Wpaper));
                  $img = base_url().'uploads/logo/draft.png';
                  $pdf->Image($img,10,10,220,310);
                  $pdf->useTemplate($templateId);
                }
                $pdf->Output($filenameW,'F');
              }
              catch (Exception $e) {}
              //EOFCreate pdf watermark
              $data = file_get_contents($lok_fileWm.$file);
              //force_download($file, $data);
            }  
          }
        }else{
          echo 'File '.$file.' Tidak Didokumentasikan (Sebelum penggunaan e-Sign)';
        }
      }
      
      //EOF() Create Draft Naskah
          redirect('assets/docx-preview/'.$redirect.'.docx');
  }

  public function input_preview($id_perizinan = NULL) {

    $namafile = 'SK_PREVIEW_'.$id_perizinan;

    if (file_exists('assets/docx-preview/'.$namafile.'.docx')) {
      unlink('assets/docx-preview/'.$namafile.'.docx');
    }

    if (file_exists('assets/sktest/'.$namafile.'.pdf')) {
      unlink('assets/sktest/'.$namafile.'.pdf');
    }

    $username = new user();
    $username->where('username', $this->session->userdata('username'))->get();
    $tgla = $username->gvar1;
    $tglb = $username->gvar2;
    
    $p_izin = $this->perizinan->get_by_id($id_perizinan);
    $p_sektor = $p_izin->trsektor->get();
    
    $jml_property = $this->lib_date->data_property($p_izin->id,'1');
        
    $method = 'simpan';
    $data['tgla'] = $tgla;
    $data['tglb'] = $tglb;
    $data['waktu_awal'] = $this->lib_date->get_date_now();
    $data['save_method'] = $method;
    $data['jenis_izin'] = $p_izin->n_perizinan;
    $data['id_izin'] = $p_izin->id;
    $data['bidang'] = $p_sektor->n_sektor;
    $data['e_sertifikat'] = $p_izin->e_sertifikat;
    
    $a=array();
    $jml_property = $this->lib_date->data_property($p_izin->id,'1');
    
    if($jml_property == '0') {
    }else{
      $i = 1;
      $text = $this->lib_date->data_property($p_izin->id,'2');
      if($jml_property > 1) {
        $text = $this->lib_date->sort_property($p_izin->id, $text);
      }
      $list = explode (",",$text);
      
      foreach ($list as $data2) {
        $nm_var = 'vdt_teknis'.$this->lib_date->array_property('0',$data2);  // Nomor Variabel
        $property_aktif = $this->lib_date->array_property('11',$data2);      // Aktifasi Property
        // $tek = "dt_teknis".$i;
        // $prop = $p_daftar->$tek;
        // if($p_daftar->$tek == null){
           $prop = "^";
        // }else{
        //   $array = explode("^",$prop);
        //   $a[] = $array[0];
        //   $i++;
        // }
      }
    }
    
    $data['array_properti'] = $a;
    $data['list'] = $p_izin->trproperty->order_by('c_parent_order asc, c_order asc')->get();
    
    $js =  "
            $(document).ready(function() {
                $(\"#tabs\").tabs();
                $('.monbulan').datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: 'yy-mm-dd',
                    closeText: 'X'
                });
                $('#form').validate();
            });
    
            function finishAjax(id, response){
                $('#'+id).html(unescape(response));
                $('#'+id).fadeIn();
            }
        ";
    
    $this->template->set_metadata_javascript($js);
    $this->load->vars($data);
    $this->session_info['page_name'] = "Preview Dokumen SK";
    $this->template->build('input_preview', $this->session_info);
  }

  public function preview_pdf($id_perizinan = NULL) {
    $namafile = 'SK_PREVIEW_'.$id_perizinan;
    $this->db->select('trperizinan.kertas,trperizinan.kordinatttd,trperizinan.kordinatqr');
    $this->db->from('tmpermohonan');
    $this->db->join('tmpermohonan_trperizinan', 'tmpermohonan.id = tmpermohonan_trperizinan.tmpermohonan_id', 'left');
    $this->db->join('trperizinan', 'trperizinan.id = tmpermohonan_trperizinan.trperizinan_id', 'left');
    $this->db->where('trperizinan.id',$id_perizinan);
    $ambilperizinanid =  $this->db->get();
    foreach($ambilperizinanid->result() as $data3) {
      $kordinatqr = $data3->kordinatqr;
      $kordinatttd = $data3->kordinatttd;
      $kertas = $data3->kertas;
    }

    if (file_exists('assets/sktest/'.$namafile.'.pdf')) {
      $this->load->library('cfpdf');
      $this->load->library('cfpdi');
      $pdf = new FPDI();
      $filepdf = $_SERVER['DOCUMENT_ROOT'].'/spekta/backoffice/assets/sktest/'.$namafile.'.pdf';
      try{
        $pageCount = $pdf->setSourceFile($filepdf);
        for($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
          $templateId = $pdf->importPage($pageNo);
          $size = $pdf->getTemplateSize($templateId);
          if($kertas == 1){
            if($size['w'] > $size['h']) {
              $pdf->AddPage('L', array($size['w'], $size['h']));
              $img = base_url().'uploads/logo/bsre_prev.jpg';
              $pdf->Image($img,17,190,185,12);
            }else{
              $pdf->AddPage('P', array($size['w'], $size['h']));
              $img = base_url().'uploads/logo/bsre_prev.jpg';
              $pdf->Image($img,17,283,180,12);
            }
          }else{
            if($size['w'] > $size['h']) {
              $pdf->AddPage('L', array($size['w'], $size['h']));
              $img = base_url().'uploads/logo/bsre_prev.jpg';
              $pdf->Image($img,17,190,185,12);
            }else{
              $pdf->AddPage('P', array($size['w'], $size['h']));
              $img = base_url().'uploads/logo/bsre_prev.jpg';
              $pdf->Image($img,17,310,180,12);
            }
          }
          $pdf->useTemplate($templateId);   
        }
        //$pdf->Output($filepdf,'F');
        $pdf->Output($filepdf,'F');
        redirect('assets/sktest/'.$namafile.'.pdf');
      }
      catch (Exception $e) {
        echo $e;die;
      }
    } else {
      $this->session->set_flashdata('gagal', "File PDF Tidak ditemukan/belum dibuat, silahkan lakukan Preview SK Docx terlebih dahulu.");
      redirect('property/master/input_preview/'.$id_perizinan);
    }
    //redirect('assets/docx-preview/'.$redirect.'.docx');
  }
}