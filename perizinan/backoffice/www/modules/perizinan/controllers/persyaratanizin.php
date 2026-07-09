<?php

if(!defined('BASEPATH'))
  exit('No direct script access allowed');

/**
 * Description of persyaratanizin class
 * @author  Yana Supriatna Created : 07 Aug 2010
 * Updated : 14 Aug 2010 (Agus N)
 * Update  : 2017 PBS
 */

class Persyaratanizin extends WRC_AdminCont {

  public function __construct() {
    parent::__construct();
    $this->perizinan = new trperizinan();
    $this->persyaratanizin = new trsyarat_perizinan();
    $enabled = FALSE;
    $list_auths = $this->session_info['app_list_auth'];

    foreach ($list_auths as $list_auth) {
      if($list_auth->id_role === '1') {
        $enabled = TRUE;
      }
    }

    if(!$enabled) {
      redirect('dashboard');
    }
  }

  public function index() {
    $data['list'] = $this->perizinan->where('c_aktif', '0')->order_by('id','ASC')->get();
    //$data['list'] = $this->perizinan->where('c_aktif = 0 or c_online = 0')->order_by('id','ASC')->get();
    $data['list_izin'] = $this->perizinan->get_list();
    $this->load->vars($data);

	  $js =  "
			      $(document).ready(function() {
              oTable = $('#syaratizin').dataTable({
                       \"bJQueryUI\": true,
                       \"sPaginationType\": \"full_numbers\"
              });
            } );
           ";

    $this->template->set_metadata_javascript($js);
    $this->session_info['page_name'] = "Setting Persyaratan Izin";
    $this->template->build('syarat_list', $this->session_info);
  }

  public function detail($id = NULL) {
    $data['list'] = $this->perizinan->where('id', $id)->get();
    $data['id'] = $this->perizinan->id;
    $this->load->vars($data);
    $js =  "
            function confirm_link(text){
              if(confirm(text)){ return true;
              }else{ return false; }
            }
            
            $(document).ready(function() {
              oTable = $('#syaratizin_detail').dataTable({
                       \"bJQueryUI\": true,
                       \"sPaginationType\": \"full_numbers\"
              });
            } );
           ";
    $this->template->set_metadata_javascript($js);
    $this->session_info['page_name'] = "Data Persyaratan Izin";
    $this->template->build('syarat_detail', $this->session_info);
  }

  public function create($id_izin = NULL) {
    $this->perizinan->get_by_id($id_izin);
    $data['syarat_list'] = $this->persyaratanizin->order_by('v_syarat ASC')->get();
    $data['perizinan_syarat'] = $this->perizinan->trsyarat_perizinan->get();
    
    $data['save_method'] = "save";
    $data['id'] = "";
    $data['perizinan_id'] = $id_izin;
    $data['v_syarat']  = "";
    $data['i_urut']  = "";
    $data['status']  = "ok";
    $data['si'] = "";
    $data['si2'] = "";
    //$data['c_daftar_ulang'] = "";
    //$data['c_baru'] = "ok";
    //$data['c_perpanjangan'] = "ok";
    //$data['c_ubah'] = "ok";

	  $data['c_baru']         = '';
    $data['c_daftar_ulang'] = '';
    $data['c_perpanjangan'] = '';
    $data['c_ubah']         = '';
	  $data['c_pencabutan']   = '';
    $data['c_penutupan']    = '';
  	$data['s_link'] = 1;

    $js =  "
	          function confirm_link(text){
              if(confirm(text)){ return true;
              }else{ return false; }
            }

            $(document).ready(function() {
              $(\"#tabs\").tabs();
              $('#form').validate();
              oTable = $('#syarat').dataTable({
                       \"bJQueryUI\": true,
                       \"sPaginationType\": \"full_numbers\"
              });
            } );
           ";

    $this->template->set_metadata_javascript($js);
    $this->load->vars($data);
    $this->session_info['page_name'] = "Tambah Persyaratan Izin";
    $this->template->build('syarat_edit', $this->session_info);
  }

  // edit is a method to show page for updating data
  public function edit($id_izin = NULL, $id_syarat = NULL, $s_link = NULL) {
    $username = new user();
    $username->where('username', $this->session->userdata('username'))->get();
    $data['user_id'] = $username->id;

    $this->persyaratanizin->get_by_id($id_syarat);
    $this->persyaratanizin->trperizinan->include_join_fields()->get();

    $data['id'] = $this->persyaratanizin->id;
    $data['v_syarat'] = $this->persyaratanizin->v_syarat;
    $data['i_urut'] = $this->persyaratanizin->i_urut;
    $data['s_link'] = $s_link;

    /*
     * Baca beberapa status yang di-parse menjadi biner dan dikonvert jadi
     * desimal
     */
    $show_syarat = new trperizinan_syarat();
    $show_syarat->where('trsyarat_perizinan_id', $id_syarat)
                ->where('trperizinan_id', $id_izin)->get();
    $var = $show_syarat->c_show_type;
	  $data['status'] = $show_syarat->status;

    $rule = strval(decbin($var));
	  if($show_syarat->status_new == 1) $plv = 6; else $plv = 4; // penambahan pencabutan dan penutupan ditambah 00
    if(strlen($rule) < $plv) {
      $len = $plv - strlen($rule);
      $rule = str_repeat("0",$len) . $rule;
    }
	  if($plv == 4) $rule = $rule.'00';                          // penambahan pencabutan dan penutupan ditambah 00
    $arr_rule = str_split($rule);
    $data['si'] = $var;
    $data['si2'] = $rule;
    if($plv == 4){
  		$data['c_baru']         = $arr_rule[1];
      $data['c_daftar_ulang'] = $arr_rule[0];
    }else{
		  $data['c_baru']         = $arr_rule[0];
      $data['c_daftar_ulang'] = $arr_rule[1];
    }
    $data['c_perpanjangan'] = $arr_rule[2];
    $data['c_ubah']         = $arr_rule[3];
	  $data['c_pencabutan']   = $arr_rule[4];
    $data['c_penutupan']    = $arr_rule[5];

    $data['perizinan_id']  = $id_izin;
    $data['save_method'] = "update";

    $js =  "
            $(document).ready(function() {
             $('#form').validate();
             $(\"#tabs\").tabs();
             $('a[rel*=upload_box]').facebox();   
            } );
           ";

    $this->template->set_metadata_javascript($js);
    $this->load->vars($data);
    $this->session_info['page_name'] = "Edit Persyaratan Izin";
    $this->template->build('syarat_edit', $this->session_info);
  }

  function showform($id_izin=NULL, $id=NULL){
		$judul = "Upload Contoh Formulir Persyaratan ";
		$data["judulapp"]=$judul;
		$data["id_izin"]=$id_izin; // id perizinan
		$data["id"]=$id;           // id syarat
		$viewfile="v_cupload_form";
		$this->load->view($viewfile,$data);
  }
  
  function upfile(){
		$id_izin = $this->input->post('id_izin'); // id perizinan
		$id = $this->input->post('id');           // id syarat
	  $file_name = basename($_FILES["fileToUpload"]["name"]);
  	$target_dir = "../assets/userassets/formulir/";
    $target_file = $target_dir . $file_name;
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    if(isset($_POST["submit"])) {
      $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    }
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    	$trsyarat_perizinan = new trsyarat_perizinan();
      $trsyarat_perizinan->get_by_id($id);
      $trsyarat_perizinan->nama_formulir = $file_name;
      $trsyarat_perizinan->save();
    } else {
    }
		redirect('perizinan/persyaratanizin/detail/'.$id_izin);
	}

  // Save and insert for manipulating data. untuk tambah data syarat TAB 2
	public function save() {     
    $data_id = new trsyarat_perizinan();
    
    $data_id->select_max('id')->get();
    $data_urut = $data_id->i_urut + 1;
    $this->persyaratanizin->v_syarat = $this->input->post('v_syarat');
    $this->persyaratanizin->status = $this->input->post('status');
    $this->persyaratanizin->i_urut = $data_urut;

    $perizinan = new trperizinan();
    $id_izin = $this->input->post('perizinan_id');
    $perizinan->get_by_id($id_izin);

    if(! $this->persyaratanizin->save($perizinan)) {
      echo '<p>' . $this->persyaratanizin->error->string . '</p>';
    } else {
      $tgl = date("Y-m-d H:i:s");
      $u_ser = $this->session->userdata('username');
      //$p = $this->db->query("call log ('Setting Perizinan','Insert persyaratan izin','".$tgl."','".$u_ser."')");
       
			//jika yes=1 No=0
      $rule = $this->input->post('c_baru') .
			        $this->input->post('c_daftar_ulang') .
              $this->input->post('c_perpanjangan') .
              $this->input->post('c_ubah') .
              $this->input->post('c_pencabutan') .
			        $this->input->post('c_penutupan');

      $c_show_type = bindec($rule);

      $perizinan = new trperizinan();
      $perizinan->get_by_id($id_izin);

      $syarat = new trsyarat_perizinan();
      $syarat->select_max('id')->get();
      $syarat->get_by_id($syarat->id);

      $syarat->set_join_field($perizinan, 'c_show_type', $c_show_type);
			$syarat->set_join_field($perizinan, 'status', $this->input->post('status'));
			$syarat->set_join_field($perizinan, 'status_new', 1);
      redirect('perizinan/persyaratanizin/detail/'. $id_izin);
    }
  }
    
  private function updateperizinan($data, $id) {
    $this->db->where('id', $id);
    $this->db->update('trsyarat_perizinan', $data);
  }

  // Save and insert for manipulating data. untuk insert data syarat TAB 1
	public function save_list() { 
    $id_izin = $this->input->post('perizinan_id');
    $syarat_list = $this->input->post('syarat');
    $status = $this->input->post('status');
		$c_baru         = $this->input->post('c_baru');
    $c_daftar_ulang = $this->input->post('c_daftar_ulang');
    $c_perpanjangan = $this->input->post('c_perpanjangan');
    $c_ubah         = $this->input->post('c_ubah');
    $c_pencabutan   = $this->input->post('c_pencabutan');
    $c_penutupan    = $this->input->post('c_penutupan');

    $syarat_list_len = count($syarat_list);

    for($i=0;$i<$syarat_list_len;$i++) {
      $izin_syarat = new trperizinan_syarat();
      
      $dt_update=array('status'=>$status[$i]);
      $this->updateperizinan($dt_update,$syarat_list[$i]);
      
      $izin_syarat->trperizinan_id = $id_izin;
      $izin_syarat->trsyarat_perizinan_id = $syarat_list[$i];
      if($c_baru[$i]         === $syarat_list[$i]) $nilai_baru = 1; else $nilai_baru = 0;
			if($c_daftar_ulang[$i] === $syarat_list[$i]) $nilai_daftar_ulang = 1; else $nilai_daftar_ulang = 0;
      if($c_perpanjangan[$i] === $syarat_list[$i]) $nilai_perpanjangan = 1; else $nilai_perpanjangan = 0;
      if($c_ubah[$i]         === $syarat_list[$i]) $nilai_ubah = 1; else $nilai_ubah = 0;
			if($c_pencabutan[$i]   === $syarat_list[$i]) $nilai_pencabutan = 1; else $nilai_pencabutan = 0;
			if($c_penutupan[$i]    === $syarat_list[$i]) $nilai_penutupan = 1; else $nilai_penutupan = 0;
      
      $rule = $nilai_baru.$nilai_daftar_ulang.$nilai_perpanjangan.$nilai_ubah.$nilai_pencabutan.$nilai_penutupan;
      $c_show_type = bindec($rule);
      $izin_syarat->c_show_type = $c_show_type;
      $izin_syarat->status = $status[$i];
			$izin_syarat->status_new = 1;
      $izin_syarat->save();
    }
    redirect('perizinan/persyaratanizin/detail/'. $id_izin);
  }

  // Save and update for manipulating data. untuk Update data 
  public function update() {
    $id_izin = $this->input->post('perizinan_id');
    $update = $this->persyaratanizin
                   ->where('id', $this->input->post('id'))
                   ->update(array('v_syarat' => $this->input->post('v_syarat'),'status' => $this->input->post('status')) );
    if(! $update) {
      echo '<p>' . $this->persyaratanizin->error->string . '</p>';
    } else {
      $tgl = date("Y-m-d H:i:s");
      $u_ser = $this->session->userdata('username');
      //$p = $this->db->query("call log ('Setting Perizinan','Update persyaratan izin','".$tgl."','".$u_ser."')");

      $rule = $this->input->post('c_baru') .
		  $this->input->post('c_daftar_ulang') .
              $this->input->post('c_perpanjangan') .
              $this->input->post('c_ubah') .
              $this->input->post('c_pencabutan') .
		  $this->input->post('c_penutupan');

      $c_show_type = bindec($rule);

      $perizinan = new trperizinan();
      $perizinan->get_by_id($id_izin);

      $syarat = new trsyarat_perizinan();
      $syarat->get_by_id($this->input->post('id'));

      $syarat->set_join_field($perizinan, 'c_show_type', $c_show_type);
		  $syarat->set_join_field($perizinan, 'status', $this->input->post('status'));
		  $syarat->set_join_field($perizinan, 'status_new', 1);
      redirect('perizinan/persyaratanizin/detail/'. $id_izin);
    }
  }

  public function dsp_izin($id_izin = NULL, $id_syarat = NULL) {
    $izin_syarat = new trperizinan_syarat();
	  $data['list'] = $izin_syarat->where('trsyarat_perizinan_id', $id_syarat)->get();
    $data['id_izin'] = $id_izin;
	  $data['id_syarat'] = $id_syarat;
    $this->load->vars($data);

	  $js =  "
            $(document).ready(function() {
		    		  $(\"#tabs\").tabs();
				      $('a[rel*=rekapitulasi_box]').facebox();
              $('a[rel*=realisasi_box]').facebox();
              oTable = $('#realisasi').dataTable({
                       \"bJQueryUI\": true,
                       \"sPaginationType\": \"full_numbers\"
              });
            } );

			      $(document).ready(function() {
              oTable = $('#syaratizin').dataTable({
                       \"bJQueryUI\": true,
                       \"sPaginationType\": \"full_numbers\"
              });
            } );
           ";

    $this->template->set_metadata_javascript($js);
    $this->session_info['page_name'] = "Daftar Perizinan";
    $this->template->build('view_izin', $this->session_info);
  }

	public function delete_link($id_izin = NULL, $id_syarat = NULL) {
    $izin_syarat = new trperizinan_syarat();
    $where_all = array('trperizinan_id' => $id_izin, 'trsyarat_perizinan_id' => $id_syarat);
    $izin_syarat->where($where_all)->get();
    $izin_syarat->delete();

    $tgl = date("Y-m-d H:i:s");
    $u_ser = $this->session->userdata('username');
    //$p = $this->db->query("call log ('Setting Perizinan','Hilangkan Link syarat izin','".$tgl."','".$u_ser."')");
    redirect('perizinan/persyaratanizin/detail/'. $id_izin);
  }

	public function delete($id_izin = NULL, $id_syarat = NULL) {
    $syarat_izin = new trsyarat_perizinan();
    $syarat_izin->where('id', $id_syarat)->get();
    $syarat_izin->delete();

    $tgl = date("Y-m-d H:i:s");
    $u_ser = $this->session->userdata('username');
    //$p = $this->db->query("call log ('Setting Perizinan','Delete persyaratan','".$tgl."','".$u_ser."')");

    redirect('perizinan/persyaratanizin/create/'. $id_izin);
  }

  public function saveurut() {
        $urutan = $this->input->post('urutan');
        $id = $this->input->post('idurutan');
        $idkembali = $this->input->post('idizin');
        $jumlah = count($this->input->post('idurutan'));
        $hitungquery = 0;
        $i = 0;

        foreach ($urutan as $urut) {
                $data = array('urutan' => $urut);

                $this->db->where('id', $id[$i]);
                if ($this->db->update('trsyarat_perizinan', $data)) {
                    $hitungquery++;
                }
                
                $i++;
         }

         if ($hitungquery == $jumlah) {
            $this->session->set_flashdata('sukses', "Berhasil Edit Urutan.");
             redirect('perizinan/persyaratanizin/detail/'.$idkembali);
         } else {
             $this->session->set_flashdata('gagal', "Gagal Edit Urutan.");
             redirect('perizinan/persyaratanizin/detail/'.$idkembali);
         }
    }
}