<?php
/*
 * Created By : Nirwan R / 08-04-2021
 * Develope : PBS 2024
 */

class Ruangan extends WRC_AdminCont {
  public function __construct() {
    parent::__construct();
    $this->load->model("m_ruangan");
    $this->load->library('fpdf');
    $base_url = base_url();
    $enabled = FALSE;
    $this->All = FALSE;
    $this->Arsiparis = FALSE;
    $this->Aspri = FALSE;
    $this->Saparapat = FALSE;
    $list_auths = $this->session_info['app_list_auth'];
    $this->id = $this->session->userdata('id_pegawai');
    $this->username = $this->session->userdata('username');  // jika 'Guest' = user SSO bukan
    if($this->username == 'Guest'){ $enabled = TRUE; }
    if($this->session->userdata('lokasi') == 'OPD Teknis'){
      $enabled = TRUE;
      $this->username = 'Guest';
    }
    foreach ($list_auths as $list_auth) {
      if($list_auth->id_role === '56') {  //Aspri Kadis
        $this->Aspri = TRUE;
      }
      if($list_auth->id_role === '35') {  //Ruangan
        $enabled = TRUE;
      }
      if($list_auth->id_role === '18') {  //Admin
        $this->All = TRUE;
      }
      if($list_auth->id_role === '21') {  // Arsiparis
        $this->Arsiparis = TRUE;
      }
      if($list_auth->id_role === '60') {  // Admin Saparapat
        $this->Saparapat = TRUE;
      }
    }
    
    if (!$enabled) {
        redirect('dashboard');
    }
  }

  public function index($tgla=null, $tglb=null) { 
    $now = $this->lib_date->get_date_now();
    if($tgla == null){
      $tgla = (!empty($this->input->post('tgla')) ? $this->input->post('tgla') : $this->lib_date->set_date($now, -7));;
      $tglb = (!empty($this->input->post('tglb')) ? $this->input->post('tglb') : $this->lib_date->set_date($now, 14));
    }
    
    $iduser = $this->session->userdata('id_auth');

    // if ($this->All || $iduser == 563 || $iduser == 561 || $iduser == 446) { //id ine, meli, ladia
    //     $admin = 1;
    //   } else {
    //     $admin = 0;
    //   }

    $ruangan = $this->m_ruangan->get_data($tgla, $tglb);

    $data['tgla'] = $tgla;
    $data['tglb'] = $tglb;
    $data['ruangan'] = $ruangan;
    $data['admin'] = $this->All;
    $data['user'] = $iduser;
    $this->load->vars($data);

    $js = "function confirm_link(text){
            if(confirm(text)){ return true;
            }else{ return false; }
          }
          
          $(document).ready(function() {
            oTable = $('#pendataan').dataTable({
              \"bJQueryUI\": true,
              \"sPaginationType\": \"full_numbers\"
            });
          });
          $(function() {
            $(\".monbulan\").datepicker({
              changeMonth: true,
              changeYear: true,
              dateFormat: 'yy-mm-dd',
              closeText: 'X'
            });
            $('#form').validate();
          });
          
          $(document).ready(function() {
    		     $( '#notif' ).click(function() {
			         $('#pageloader').fadeIn();
			       });
             oTable = $('#sk').dataTable({
                        \"bJQueryUI\": true,
                        \"sPaginationType\": \"full_numbers\"
                      });
           });";

    $this->template->set_metadata_javascript($js);
    $this->session_info['page_name'] = "Manajemen Ruangan";
    $this->template->build('ruangan_list', $this->session_info);
  }

  public function print_excel($tgla = 0, $tglb = 0){
      // $now = $this->lib_date->get_date_now();
      //   $tgla = (!empty($this->input->post('tgla')) ? $this->input->post('tgla') : $this->lib_date->set_date($now, -30));
      //   $tglb = (!empty($this->input->post('tglb')) ? $this->input->post('tglb') : $this->lib_date->set_date($now, 0));

      //   $iduser = $this->session->userdata('id_auth');
      // if ($this->All  || $iduser == 553 || $iduser == 114 || $iduser == 54 || $iduser == 64 ||  $iduser == 563 ||  $iduser == 266) {
      //   $admin = 1;
      // } else {
      //   $admin = 0;
      // }

        // $tgla = $this->lib_date->set_date($this->input->post('tgla'));
        // $tglb = $this->lib_date->set_date($this->input->post('tglb'));
        
        // $pakai = $this->m_ruangan->get_data_cetak_excel($tgla, $tglb, $iduser, $admin);
        $pakai = $this->m_ruangan->get_data_cetak_excel($tgla, $tglb);
        // var_dump($pakai);die;
        $data['tgla'] = $tgla;
        $data['tglb'] = $tglb;
        $data['pakai'] = $pakai;
        $data['title'] = 'Rekap Penggunaan Ruang Rapat';
        $data['jdl_laporan'] = 'Rekap Penggunaan Ruang Rapat';
        $this->load->vars($data);

     // $data = array( 
     //  'title' => 'Laporan Excel',
     //  'pakai' => $this->m_pengembangan->get_data($tgla, $tglb));
     $this->load->view('laporan_excel',$data);
     }

  public function master() { 
    $ruangan = $this->m_ruangan->get_master();

    $data['ruangan'] = $ruangan;
    $this->load->vars($data);

    $js = "function confirm_link(text){
            if(confirm(text)){ return true;
            }else{ return false; }
          }
          
          $(document).ready(function() {
            oTable = $('#pendataan').dataTable({
              \"bJQueryUI\": true,
              \"sPaginationType\": \"full_numbers\"
            });
          });
          $(function() {
            $(\".monbulan\").datepicker({
              changeMonth: true,
              changeYear: true,
              dateFormat: 'yy-mm-dd',
              closeText: 'X'
            });
            $('#form').validate();
          });";

    $this->template->set_metadata_javascript($js);
    $this->session_info['page_name'] = "Master Ruangan";
    $this->template->build('master_list', $this->session_info);
  }

  public function monitoring() { 
    $ruangan = $this->m_ruangan->get_master();
    $data['ruangan'] = $ruangan;
    $this->load->vars($data);

    $js = "function confirm_link(text){
            if(confirm(text)){ return true;
            }else{ return false; }
          }
          
          $(document).ready(function() {
            oTable = $('#pendataan').dataTable({
              \"bJQueryUI\": true,
              \"sPaginationType\": \"full_numbers\"
            });
          });
          $(function() {
            $(\".monbulan\").datepicker({
              changeMonth: true,
              changeYear: true,
              dateFormat: 'yy-mm-dd',
              closeText: 'X'
            });
            $('#form').validate();
          });";

    $this->template->set_metadata_javascript($js);
    $this->session_info['page_name'] = "Monitoring Kegiatan";
    $this->template->build('monitoring_list', $this->session_info);
  }

  public function detail_list($id_ruang=null, $tgla=null, $tglb=null) { 
    $now = $this->lib_date->get_date_now();
    if($tgla == null){
      $tgla = (!empty($this->input->post('tgla')) ? $this->input->post('tgla') : $this->lib_date->set_date($now, -7));;
      $tglb = (!empty($this->input->post('tglb')) ? $this->input->post('tglb') : $this->lib_date->set_date($now, 14));
    }
    if($id_ruang == null){
      $id_ruang = $this->input->post('id_ruang');
    }  
    $iduser = $this->session->userdata('id_auth');
    $ruangan = $this->m_ruangan->get_detail_ruangan($id_ruang,$tgla, $tglb);

    $data['tgla'] = $tgla;
    $data['tglb'] = $tglb;
    $data['ruangan'] = $ruangan;
    $data['admin'] = $this->All;
    $data['user'] = $iduser;
    $data['id_ruang'] = $id_ruang;
    $this->load->vars($data);

    $js = "function confirm_link(text){
            if(confirm(text)){ return true;
            }else{ return false; }
          }
          
          $(document).ready(function() {
            oTable = $('#detail_ruang').dataTable({
              \"bJQueryUI\": true,
              \"sPaginationType\": \"full_numbers\"
            });
          });
          
          $(function() {
            $(\".monbulan\").datepicker({
              changeMonth: true,
              changeYear: true,
              dateFormat: 'yy-mm-dd',
              closeText: 'X'
            });
            $('#form').validate();
          });";

    $this->template->set_metadata_javascript($js);
    $this->session_info['page_name'] = "Detail List Ruangan";
    $this->template->build('v_detail_list', $this->session_info);
  }

  public function add() {
    $data['pemakai'] = array();
    $data['ruangan'] = $this->m_ruangan->get_ruangan($this->Saparapat);
    $data['koor'] = $this->m_ruangan->get_set_koor();
    $petugas = new tmpegawai();
    $data['list'] = $petugas->order_by('golongan', "DESC")->get();
    // if($this->All){
    //   var_dump($data['list']);die();
    // }

    $data['step'] = "simpan";

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
                $('.pilihan').select2();
            });
    
            function finishAjax(id, response){
                $('#'+id).html(unescape(response));
                $('#'+id).fadeIn();
            }

             $(document).ready(
                     function() {
                       $('#listizin').multiselect({
                        buttonWidth: '75%'
                       }).multiselectfilter({
                         show:'blind',
                         hide:'blind',
                         selectedText:'# dari # terpilih'
                       }
                     );
                     $('#listizin .ui-multiselect').css('width', '75%');
                   });

        ";
  
    $this->template->set_metadata_javascript($js);
    $this->load->vars($data);
    $this->session_info['page_name'] = "Tambah Data Booking";
    //if($this->id == 64){
    //  $this->template->build('pakai_edit_OLD', $this->session_info);
    //}else{  
      $this->template->build('pakai_edit', $this->session_info);
    //}  
  }

  public function ubah($id) {
      $data['pakai'] = $this->m_ruangan->get_datapakai($id);
      $data['ruangan'] = $this->m_ruangan->get_ruangan();
      $data['koor'] = $this->m_ruangan->get_set_koor();
      $petugas = new tmpegawai();
      $data['list'] = $petugas->order_by('golongan', "DESC")->get();      
      // $data['id_dis'] = $this->m_ruangan->get_id_dis($id);
      // $data['idp'] = $this->m_ruangan->get_id_user_dis($id);
      // if($this->All){
      //  var_dump($data['idp']);die();
      // }


      $data['step'] = "update";

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
                  $('.pilihan').select2();
              });
      
              function finishAjax(id, response){
                  $('#'+id).html(unescape(response));
                  $('#'+id).fadeIn();
              }

               $(document).ready(
                     function() {
                       $('#listizin').multiselect({
                        buttonWidth: '75%'
                       }).multiselectfilter({
                         show:'blind',
                         hide:'blind',
                         selectedText:'# dari # terpilih'
                       }
                     );
                     $('#listizin .ui-multiselect').css('width', '75%');
                   });
          ";
    
      $this->template->set_metadata_javascript($js);
      $this->load->vars($data);
      $this->session_info['page_name'] = "Ubah Data Booking";
      $this->template->build('pakai_edit', $this->session_info);
  }

  public function notulen($id) {
      $data['pakai'] = $this->m_ruangan->get_datapakai($id);
      $data['ruangan'] = $this->m_ruangan->get_ruangan();
      $data['step'] = "updateNotulen";

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
                  $('.pilihan').select2();
              });
      
              function finishAjax(id, response){
                  $('#'+id).html(unescape(response));
                  $('#'+id).fadeIn();
              }
          ";
    
      $this->template->set_metadata_javascript($js);
      $this->load->vars($data);
      $this->session_info['page_name'] = "Upload Notulensi";
      $this->template->build('upload_notulen', $this->session_info);
  }
  
  public function master_add() {
    $data['ruangan'] = array();
    $data['koor'] = $this->m_ruangan->get_set_koor();
    $data['step'] = "master_simpan";
    
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
                $('.pilihan').select2();
            });
    
            function finishAjax(id, response){
                $('#'+id).html(unescape(response));
                $('#'+id).fadeIn();
            }
        ";
    
    $this->template->set_metadata_javascript($js);
    $this->load->vars($data);
    $this->session_info['page_name'] = "Tambah Data Ruangan";
    $this->template->build('master_edit', $this->session_info);
  }

  public function tambah_eviden($id) {
    $data_pegawai = $this->m_ruangan->get_data_pegawai();

    $data['data_pegawai'] = $data_pegawai;
    $data['id_kegiatan'] = $id;
    
    
    $data['step'] = "eviden_simpan";
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
                $('.pilihan').select2();
            });
    
            function finishAjax(id, response){
                $('#'+id).html(unescape(response));
                $('#'+id).fadeIn();
            }
        ";
    
    $this->template->set_metadata_javascript($js);
    $this->load->vars($data);
    $this->session_info['page_name'] = "Tambah Data Eviden";
    $this->template->build('tambah_eviden', $this->session_info);
  }

  public function eviden_simpan() {
    $pegawai = $this->input->post('pegawai');
    $id_kegiatan = $this->input->post('id_kegiatan');
    
    $simpan = $this->m_ruangan->save_eviden($pegawai, $id_kegiatan);

    if ($simpan) {
      $this->session->set_flashdata('sukses', "Berhasil Menyimpan Data.");
      redirect('ruangan/view_notulen/'.$id_kegiatan);
    } else {
      $this->session->set_flashdata('gagal', "Gagal Menyimpan Data.");
      redirect('ruangan/view_notulen/'.$id_kegiatan);
    }
  }

  public function master_ubah($id) {
    $data['ruangan'] = $this->m_ruangan->get_datamaster($id);
    $data['koor'] = $this->m_ruangan->get_set_koor();
    $data['step'] = "master_update";
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
                $('.pilihan').select2();
            });
    
            function finishAjax(id, response){
                $('#'+id).html(unescape(response));
                $('#'+id).fadeIn();
            }
        ";
  
    $this->template->set_metadata_javascript($js);
    $this->load->vars($data);
    $this->session_info['page_name'] = "Ubah Data Ruangan";
    $this->template->build('master_edit', $this->session_info);
  }

public function master_simpan() {
    $nama_ruangan = $this->input->post('nama_ruangan');
    $lantai       = $this->input->post('lantai');
    $kapasitas    = $this->input->post('kapasitas');
    $fasilitas    = $this->input->post('fasilitas');
    $status       = $this->input->post('status');
    $oldfoto      = $this->input->post('oldfoto');

    $file = $_FILES["gambar"]["name"];
    $file_name = basename($_FILES["gambar"]["name"]);
    $ext = pathinfo($file, PATHINFO_EXTENSION);

    $routees = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
    $root = rtrim($_SERVER['DOCUMENT_ROOT'], '/');
    $routees = ltrim($routees, '/');
    $target_dir = $root . '/' . $routees . "assets/ruangan/image/";

    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true); // Buat folder + izin tulis penuh sementara
    } else {
        chmod($target_dir, 0777); // Buka akses tulis sebelum upload
    }

    $nama_file = uniqid('RR') . date('YmdHis') . '.' . $ext;
    $new_file_path = $target_dir . $nama_file;
// var_dump(move_uploaded_file($_FILES['gambar']['tmp_name'], $new_file_path));die();
    if (!move_uploaded_file($_FILES['gambar']['tmp_name'], $new_file_path)) {
        chmod($target_dir, 0755); // Kembalikan permission walau gagal
        $this->session->set_flashdata('gagal', "Gagal upload file.");
        redirect('ruangan/master');
        return;
    }

    // Setelah upload sukses, ubah kembali ke 755
    chmod($target_dir, 0755);

    $simpan = $this->m_ruangan->save_master($nama_ruangan, $lantai, $kapasitas, $fasilitas, $status, $nama_file);

    if ($simpan) {
        $this->session->set_flashdata('sukses', "Berhasil Menyimpan Data.");
    } else {
        $this->session->set_flashdata('gagal', "Gagal Menyimpan Data.");
    }

    redirect('ruangan/master');
}

  public function master_update() {
    $id           = $this->input->post('id');
    $nama_ruangan = $this->input->post('nama_ruangan');
    $lantai       = $this->input->post('lantai');
    $kapasitas    = $this->input->post('kapasitas');
    $fasilitas    = $this->input->post('fasilitas');
    $status       = $this->input->post('status');
    $oldfoto      = $this->input->post('oldfoto');         // ambil nilai dari field foto yang tersimpan
    $foto_arr     = explode(";", $oldfoto);                // ubah nilai foto dalam bentuk array
    $Newfoto_arr  = $foto_arr;                             // beri nama menjadi var $Newfoto_arr
    $hapus_foto   = $this->input->post('selected_images'); // definisikan foto yang akan di hapus
    
    //new file
    $file = $_FILES["gambar"]["name"];
    $file_name = basename($_FILES["gambar"]["name"]);
    $ext = pathinfo($file, PATHINFO_EXTENSION);
    $routees = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
    $root = rtrim($_SERVER['DOCUMENT_ROOT'], '/'); // buang trailing slash
    $routees = ltrim($routees, '/');              // buang leading slash
    $target_dir = $root . '/' .$routess."assets/ruangan/image/";
    $target_file = $target_dir . $file_name;
    $nama_file = $nama_file_baru = $id.'RR'.date('YmdGis').'.'.$ext;       // nm_file 1
    $fileBaru = $target_dir.$nama_file;
    $file_path = $target_dir.$oldfoto;                   // tidak dipakai
    $new_file_path = $target_dir.$nama_file;
    if($file_name == ""){
      $nama_file = $oldfoto;                             // nm_file 2
    }else{
      if($oldfoto != ""){
        $nama_file = $oldfoto.';'.$nama_file;              // nm_file 2
      }  
    }
    echo ' $oldfoto : ';var_dump($oldfoto); echo '<br>';
    echo ' $foto_arr : ';var_dump($foto_arr); echo '<br>';
    echo ' $hapus_foto : ';var_dump($hapus_foto); echo '<br>';
    echo '<br>';
    echo ' xfile : ';var_dump($file); echo '<br>';
    echo ' xfile_name : ';var_dump($file_name); echo '<br>';
    echo ' $target_dir : ';var_dump($target_dir); echo '<br>';
    echo ' $target_file : ';var_dump($target_file); echo '<br>';
    echo ' nm_file 1 : ';var_dump($id.'RR'.date('YmdGis').'.'.$ext); echo '<br>';
    echo ' $fileBaru : ';var_dump($fileBaru); echo '<br>';
    echo ' $file_path : ';var_dump($file_path); echo '<br>';
    echo ' $new_file_path : ';var_dump($new_file_path); echo '<br>';
    echo ' nm_file 2 : ';var_dump($nama_file); echo '<br>';
    echo '<br>';
    //echo ' extension : ';var_dump($ext); echo '<br>';
    //echo ' extension : ';var_dump($ext); echo '<br>';
    //echo ' extension : ';var_dump($ext); echo '<br>';
    //echo ' extension : ';var_dump($ext); echo '<br>';
    //die();
    if($hapus_foto){
      foreach ($hapus_foto as $item) {
        $Newfoto_arr = array_values(array_diff($Newfoto_arr, [$item]));
        echo ' array sisa hapus in forace: ';var_dump($Newfoto_arr); echo '<br>';
        if(file_exists($target_dir.$item)){
          unlink($target_dir.$item);
          echo ' file dihapus : ';var_dump($target_dir.$item); echo '<br>';
        }
      }
      echo ' array sisa hapus out forace: ';var_dump($Newfoto_arr); echo '<br>';
      echo ' $nama_file ';var_dump($nama_file); echo '<br>';
      if($file_name != "") $Newfoto_arr[] = $nama_file_baru;
      $nama_file = implode(";", $Newfoto_arr);
    }
    echo '<br>';
    echo ' text foto simpan : ';var_dump($nama_file); echo '<br>';
    //die();    // Aktifkan jika ingin melihat hasil simulasinya
    $simpan = $this->m_ruangan->update_master($id, $nama_ruangan, $lantai, $kapasitas, $fasilitas, $status, $nama_file);
    
    // Menambah file dengan file baru
    if(move_uploaded_file($_FILES['gambar']['tmp_name'], $new_file_path)){
    	//echo ' Berhasil simpan file : '; echo '<br>';
      $this->session->set_flashdata('sukses', "Berhasil Menyimpan Foto Baru.");
      redirect('ruangan/master');
    }else{
    	//echo ' Gagal simpan file : '; echo '<br>';
      $this->session->set_flashdata('gagal', "Gagal Menyimpan Foto Baru.");
      redirect('ruangan/master');
    }
  }

  public function cancel($id) {
    // var_dump($id);die();
    $cancel = $this->m_ruangan->cancel_master($id);

    if ($cancel) {
      $ruangan_pemakai = new ruangan_pemakai();
      $row = $ruangan_pemakai->get_by_id($id);
      $id_user = $row->user_id;
      $acara = $row->acara;
      $val_sts_notif = $row->sts_notif + 1;
      $sender_notif = $row->sender_notif.$this->session->userdata('id_auth').',';
      $user = new user();
      $user = $user->get_by_id($id_user);
      $sendS = FALSE;
      //$n_hp = '08121314834';
      //$n_email = 'dhies1694@gmail.com';
      $n_hp = $user->no_hp;
      $n_pesan = 'Booking ruangan sudah di bekukan dengan acara : \n'.$acara. '\n ruangan yang anda booking sudah di bekukan \nterima kasih';
	    
	    if($row->sts_notif == 0){  // sementara hanya kirim 1 x saja, tidak boleh berulang
	      // Mengirim WA / SMS
	      $this->settings->where('name', 'smsGateway')->get();
	      if($this->settings->status == 1) {
          $campaign  = 'Penyerahan';
          $sendS = $this->lib_date->postWaSms($n_hp,$n_pesan,$campaign); // $sendS = TRUE;
        }
        // EOF() Mengirim WA / SMS
      }  
      $this->session->set_flashdata('sukses', "Berhasil cancel peminjaman Data.");
      redirect('ruangan');
    } else {
      $this->session->set_flashdata('gagal', "Gagal cancel peminjaman Data.");
      redirect('ruangan');
    }
  }

  public function balikin($id) {
    // var_dump($id);die();
    $cancel = $this->m_ruangan->pulihkan_master($id);

    if ($cancel) {
      $ruangan_pemakai = new ruangan_pemakai();
      $row = $ruangan_pemakai->get_by_id($id);
      $id_user = $row->user_id;
      $acara = $row->acara;
      $val_sts_notif = $row->sts_notif + 1;
      $sender_notif = $row->sender_notif.$this->session->userdata('id_auth').',';
      $user = new user();
      $user = $user->get_by_id($id_user);
      $sendS = FALSE;
      //$n_hp = '08121314834';
      //$n_email = 'dhies1694@gmail.com';
      $n_hp = $user->no_hp;
      $n_pesan = 'Booking ruangan sudah di pulihkan dengan acara : \n'.$acara. '\n ruangan yang anda booking sudah di pulihkan \nterima kasih';
	    
	    if($row->sts_notif == 0){  // sementara hanya kirim 1 x saja, tidak boleh berulang
	      // Mengirim WA / SMS
	      $this->settings->where('name', 'smsGateway')->get();
	      if($this->settings->status == 1) {
          $campaign  = 'Penyerahan';
          $sendS = $this->lib_date->postWaSms($n_hp,$n_pesan,$campaign); // $sendS = TRUE;
        }
        // EOF() Mengirim WA / SMS
      }  
      $this->session->set_flashdata('sukses', "Berhasil pulihkan peminjaman Data.");
      redirect('ruangan');
    } else {
      $this->session->set_flashdata('gagal', "Gagal pulihkan peminjaman Data Ruangan telah di gunakan oleh pengguna lain.");
      redirect('ruangan');
    }
  }

  public function hapus_master($id) {
    $hapus = $this->m_ruangan->hapus_master($id);

    if ($hapus) {
      $this->session->set_flashdata('sukses', "Berhasil Hapus Data.");
      redirect('ruangan/master');
    } else {
      $this->session->set_flashdata('gagal', "Gagal Hapus Data.");
      redirect('ruangan/master');
    }
  }

  public function hapus_eviden($id) {
    $hapus = $this->m_ruangan->hapus_eviden($id);

    if ($hapus) {
      $this->session->set_flashdata('sukses', "Berhasil Hapus Data.");
      redirect('ruangan');
    } else {
      $this->session->set_flashdata('gagal', "Gagal Hapus Data.");
      redirect('ruangan');
    }
  }

  public function hapus_absen($id, $id_kegiatan) {
    $hapus = $this->m_ruangan->hapus_absen($id);

    if ($hapus) {
      $this->session->set_flashdata('sukses', "Berhasil Hapus Data.");
      redirect('ruangan/view_absen/'.$id_kegiatan);
    } else {
      $this->session->set_flashdata('gagal', "Gagal Hapus Data.");
      redirect('ruangan/view_absen/'.$id_kegiatan);
    }
  }
  
  public function buat_token() {
    $token = str_pad(rand(0,999999),6,'0',STR_PAD_LEFT);
    //echo 'Token Anda : '.$token;
    $data['token'] = $token;
    $data['service'] = '';
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
                $('.pilihan').select2();
            });
    
            function finishAjax(id, response){
                $('#'+id).html(unescape(response));
                $('#'+id).fadeIn();
            }
        ";
    
    $this->template->set_metadata_javascript($js);
    $this->load->vars($data);
    $this->session_info['page_name'] = "Ambil Token";
    $this->template->build('view_token', $this->session_info);
    //die();
  }
  
  public function save_token() {    // Ambil token
    echo 'Dalam pengembangan'; 
    die();
  }

  public function simpan() {
    $iduser       = $this->session->userdata('id_auth');
    $id_ruangan   = $this->input->post('id_ruangan');
    $seksi        = $this->input->post('seksi');
    if($seksi == 'lainnya'){
      $seksi        = $this->input->post('seksi_lainnya');
    }
    $acara        = $this->input->post('acara');
    $kegiatan     = $this->input->post('kegiatan');
    $target_undangan = $this->input->post('target_undangan');
    $snack        = $this->input->post('snack');
    $mamin        = $this->input->post('mamin');
    $tanggal      = $this->input->post('tanggal');
    $awal1        = $this->input->post('awal1');
    $awal2        = $this->input->post('awal2');
    $akhir1       = $this->input->post('akhir1');
    $akhir2       = $this->input->post('akhir2');
    $ket          = $this->input->post('keterangan');
    $token        = $this->input->post('token'); 
    
    // $pagawai          = $this->input->post('pegawai');
    if($this->All){
      // var_dump($tanggal);
      // var_dump($id_ruangan);
      // var_dump($awal1);
      // var_dump($awal2);
      // var_dump($akhir1);
      // var_dump($akhir2);
      // die();
    }
    if($this->username == 'Guest'){  // jika Guest harus cek token
    	$token = str_pad(rand(0,999999),6,'0',STR_PAD_LEFT);
      echo 'acara ';var_dump($acara);
      echo '<br>token ';var_dump($token);
      die();    	
    }

    $waktu_awal   = array($awal1, $awal2, "00");
    $waktu_akhir  = array($akhir1, $akhir2, "00");

    $waktu_awal = implode(":", $waktu_awal);
    $waktu_akhir = implode(":", $waktu_akhir);

    $tanggalawal = array(date("Y-m-d"), $waktu_awal);
    $tanggalawal = implode(" ", $tanggalawal);
    if (strtotime($waktu_awal) && strtotime($waktu_akhir)) {
 	    $date1 = date_create(date("Y-m-d"));
      $date2 = date_create($tanggal);
      $diff = date_diff($date1,$date2);
      $diff = $diff->days;
      
      //Cek waktu beda jam
 	    $diff2 = (strtotime($tanggalawal)-strtotime(date("Y/m/d H:i:s")))/60;
      $adaBooking = $this->m_ruangan->status_booking($id_ruangan, $tanggal, $waktu_awal, $waktu_akhir);
        // if($this->All){
        //     var_dump($adaBooking);die();
        // }
      if(!$adaBooking) { //Jika tidak ada yang booking
        $simpan = $this->m_ruangan->save_pakai($id_ruangan, $iduser, $seksi, $kegiatan, $acara, $target_undangan, $snack, $mamin, $tanggal, $waktu_awal, $waktu_akhir, $ket);
          $pegawai   = $this->input->post('pegawai');
          if(!empty($pegawai)){
          foreach ($pegawai as $data) {
            // $pegawai = implode("^", $pegawai);
            $simpan_pegawai = $this->m_ruangan->simpan_pegawai($data, $simpan);
            // $simpan_pegawai = $this->m_ruangan->simpan_pegawai($pegawai);
            if(!$simpan_pegawai){
              $this->session->set_flashdata('gagal', "Pegawai tidak di temukan");
              redirect('ruangan');
            }
          }
        }

        if($simpan != 0) {

          if($this->All){

             $pkepada      = $this->input->post('listizin');
             // var_dump($pkepada, $simpan);die();
             $user_kepada   = ($pkepada ? $pkepada : Array());

               if (!empty($user_kepada)) {
                foreach ($user_kepada as $row) {
                  $save_kepada = $this->m_ruangan->save_tim($simpan, $row);

                  if(!$save_kepada) {
                    $this->session->set_flashdata('gagal', "Gagal Menyimpan Data 1");
                    redirect('/ruangan/add/'.$id);
                  }
                }
              }

          }

          $id = $simpan;
          //Create QRCode
          $routees = str_replace('backoffice/index.php', '', $_SERVER['SCRIPT_NAME']); 
          $url_link = $_SERVER['REQUEST_SCHEME'] .'://'. $_SERVER['HTTP_HOST'] . $routees;
		      include('./assets/qrcode/qrlib.php');
          $tempDir = 'uploads/data_qrcode_absen/';
		      $link = $url_link.'kehadiran/Absensi/index/';
          $codeContents = $id;
	        $codeContents = $link.$codeContents;
          
		      $fileName = 'Abs_'.$id.'.png';  // Create ID Absen 
          $pngAbsoluteFilePath = $tempDir.$fileName;
          $urlRelativeFilePath = base_url().$tempDir.$fileName;
          if(!file_exists($tempDir))    { mkdir($tempDir); }    #kalau folder belum ada, maka buat.
		      // if(!file_exists($pngAbsoluteFilePath)) {              # jika file qrcode tidak ada  
		      //   $quality = 'H'; //ada 4 pilihan, L (Low), M(Medium), Q(Good), H(High)
          //   $ukuran = 8;    //batasan 1 paling kecil, 10 paling besar
          //   $padding = 0;
          //   QRCode::png($codeContents,$tempDir.$fileName,$quality,$ukuran,$padding);
          //   //Add logo
          //   // $logopath = './uploads/logo/Logo_Jabar_Clr.png'; //direktori dan nama logo jabar
          //   // $logopath = './uploads/logo/logo_dpmptsp.png'; //direktori dan nama logo dpmptsp jabar
          //     $logopath = './uploads/logo/logo_dpmptsp_jabar2.png'; // direktori dan nama logo dpmptsp jabar
          //   $QR = imagecreatefrompng($pngAbsoluteFilePath); 
          //   $logo = imagecreatefromstring(file_get_contents($logopath)); 
          //   $QR_width = imagesx($QR); 
          //   $QR_height = imagesy($QR); 
          //   $logo_width = imagesx($logo); 
          //   $logo_height = imagesy($logo); //besar logo 
          //   $logo_qr_width = $QR_width/4.5; 
          //   $scale = $logo_width/$logo_qr_width; 
          //   $logo_qr_height = $logo_height/$scale; //posisi logo 
          //   imagecopyresampled($QR, $logo, $QR_width/2.7, $QR_height/2.7, 0, 0,$logo_qr_width, $logo_qr_height, $logo_width, $logo_height); 
          //   imagepng($QR,$pngAbsoluteFilePath);
          //   //EOF() Add logo
          // }

          // ...
if (!file_exists($pngAbsoluteFilePath)) { // jika file qrcode tidak ada
    $quality = 'H'; // ada 4 pilihan, L (Low), M(Medium), Q(Good), H(High)
    $ukuran = 8; // batasan 1 paling kecil, 10 paling besar
    $padding = 0;
    QRCode::png($codeContents, $tempDir . $fileName, $quality, $ukuran, $padding);
    // Add logo
    // $logopath = './uploads/logo/logo_dpmptsp_jabar2.png'; // direktori dan nama logo dpmptsp jabar
    $logopath = './uploads/logo/logo_dpmptsp.png'; //direktori dan nama logo dpmptsp jabar
    $QR = imagecreatefrompng($pngAbsoluteFilePath);
    $logo = imagecreatefrompng($logopath);
    $QR_width = imagesx($QR);
    $QR_height = imagesy($QR);
    $logo_width = imagesx($logo);
    $logo_height = imagesy($logo);

    // Tentukan faktor skala yang ingin Anda gunakan (misalnya, 2 untuk menggandakan ukuran logo)
    $scale_factor = 0.3;

    // Hitung ulang ukuran logo
    $new_logo_width = $logo_width * $scale_factor;
    $new_logo_height = $logo_height * $scale_factor;

    // posisi logo di tengah
    imagecopyresampled($QR, $logo, ($QR_width - $new_logo_width) / 2, ($QR_height - $new_logo_height) / 2, 0, 0, $new_logo_width, $new_logo_height, $logo_width, $logo_height);
    imagepng($QR, $pngAbsoluteFilePath);
    // EOF() Add logo
}
// ...

    $routees = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
    $root = rtrim($_SERVER['DOCUMENT_ROOT'], '/'); // buang trailing slash
    $routees = ltrim($routees, '/');              // buang leading slash
          $routees_portal = str_replace('backoffice/index.php', '', $_SERVER['SCRIPT_NAME']); 
          $master_url     = $_SERVER['REQUEST_SCHEME'] .'://'. $_SERVER['HTTP_HOST'];

          //EOF() Create QRCode
          $file = $_FILES["file_srt"]["name"];
          $file_name = basename($_FILES["file_srt"]["name"]);
          $ext = pathinfo($file, PATHINFO_EXTENSION);


          $target_dir = "assets/ruangan/notdin/";
          $target_file = $target_dir . $file_name;

          // 🔧 Cek dan buat folder jika belum ada
          if (!is_dir($target_dir)) {
              mkdir($target_dir, 0755, true); // recursive mkdir, izin 755
          }

          $fileBaru = $target_dir . 'NOTAMAMIN_' . $id . '.' . $ext;

          $upload = move_uploaded_file($_FILES["file_srt"]["tmp_name"], $target_file);

 
          if($upload) {
            $rnm = rename($target_file, $fileBaru);
            $this->session->set_flashdata('sukses', "Berhasil Menyimpan Data & Mengupload Dokumen .");
            redirect('ruangan');
          }else{
            $this->session->set_flashdata('gagal', "Berhasil Menyimpan Data Tetapi Gagal Menggunggah File Dokumen.");
            redirect('ruangan');
          }
        }
      }else{
        $this->session->set_flashdata('gagal', "Sudah ada data booking pada waktu dan ruangan yang dipilih.");
        redirect('ruangan/add');
      }
    }else{
      $this->session->set_flashdata('gagal', "Data waktu yang diinput salah.");
      redirect('ruangan/add');
    }
  }

  public function unduh_naskah($id){
    $surat = $this->m_ruangan->get_datapakai($id);

    $kepada = $surat->id;

    $routees = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
    $root = rtrim($_SERVER['DOCUMENT_ROOT'], '/'); // buang trailing slash
    $routees = ltrim($routees, '/');              // buang leading slash
    $file = "NOTAMAMIN_".$id;
    $data = file_get_contents($root . '/' .$routees .'assets/ruangan/notdin/'.$file.'.pdf');
    force_download('NOTAMAMIN_'.$kepada.'.pdf', $data);
    }

    public function unduh_notulen($id, $id_peg = NULL){
    $surat = $this->m_ruangan->get_datapakai($id);

    $kepada = $surat->id;
    $routees = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
    $root = rtrim($_SERVER['DOCUMENT_ROOT'], '/'); // buang trailing slash
    $routees = ltrim($routees, '/');              // buang leading slash
    $file = "NOTULEN_".$id.".pdf";
    $file2 = "NOTULEN_".$id."_".$id_peg.".pdf";
    // var_dump($file2);die();
    $dir = $root . '/' .$routees .'assets/ruangan/notulen/';
    $data = '';
    if(file_exists($dir.$file)){
      $data = file_get_contents($dir.$file);
    }

    if(file_exists($dir.$file2)){
      $data = file_get_contents($dir.$file2);
    }

    force_download('NOTULEN_'.$kepada.'.pdf', $data);
    
    // redirect('ruangan/notulen/'.$id,'refresh');
    
    }

    public function unduh_undangan($id){
    $surat = $this->m_ruangan->get_datapakai($id);

    $kepada = $surat->id;
    $routees = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
    $root = rtrim($_SERVER['DOCUMENT_ROOT'], '/'); // buang trailing slash
    $routees = ltrim($routees, '/');              // buang leading slash
    $file = "undangan_".$id;
    $data = file_get_contents($root . '/' .$routees .'assets/ruangan/undangan/'.$file.'.pdf');
    force_download('undangan_'.$kepada.'.pdf', $data);
    }

    public function unduh_dasar_surat($id){
    $surat = $this->m_ruangan->get_datapakai($id);

    $kepada = $surat->id;
    $routees = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
    $root = rtrim($_SERVER['DOCUMENT_ROOT'], '/'); // buang trailing slash
    $routees = ltrim($routees, '/');              // buang leading slash
    $file = "dasar_surat_".$id;
    $data = file_get_contents($root . '/' .$routees .'assets/ruangan/dasarsurat/'.$file.'.pdf');
    force_download('dasar_surat_'.$kepada.'.pdf', $data);
    }

  public function hapus_notdin($id) {
    $hapus = unlink('assets/ruangan/notdin/NOTAMAMIN_'.$id.'.pdf');
    //$hapus2 = unlink('assets/docx-surat-processed/SRT_'.$id.'.docx');

    if ($hapus) {
      $this->session->set_flashdata('sukses', "Berhasil Menghapus Berkas.");
      redirect('ruangan/ubah/'.$id);
    } else {
      $this->session->set_flashdata('gagal', "Gagal Menghapus Berkas.");
      redirect('ruangan/ubah/'.$id);
    }
  }

  public function hapus_notulen($id) {
    $iduser       = $this->session->userdata('id_auth');
    $id_pegawai       = $this->m_ruangan->get_id_pegawai($iduser);
    $pegawai = $this->m_ruangan->get_id_user_pic($id);
    // var_dump($pegawai[0]->id_pegawai);die();
    if(empty($pegawai)){
    $hapus = unlink('assets/ruangan/notulen/NOTULEN_'.$id.'.pdf');
    }else{
                        $user_aktif = FALSE;
                        foreach ($pegawai as $dd) {
                        // var_dump($id_peg == $dd->id_pegawai);
                        // echo $id_peg. ' == ' .$dd->id_pegawai.'<br>';
                          if($id_pegawai == $dd->id_pegawai){
    $hapus = unlink('assets/ruangan/notulen/NOTULEN_'.$id.'_'.$id_pegawai.'.pdf');
                          }
                        }
    }
    //$hapus2 = unlink('assets/docx-surat-processed/SRT_'.$id.'.docx');

    if ($hapus) {
      $this->session->set_flashdata('sukses', "Berhasil Menghapus Berkas.");
      redirect('ruangan/notulen/'.$id);
    } else {
      $this->session->set_flashdata('gagal', "Gagal Menghapus Berkas.");
      redirect('ruangan/notulen/'.$id);
    }
  }

  public function hapus_undangan($id) {
    $hapus = unlink('assets/ruangan/undangan/undangan_'.$id.'.pdf');
    //$hapus2 = unlink('assets/docx-surat-processed/SRT_'.$id.'.docx');

    if ($hapus) {
      $this->session->set_flashdata('sukses', "Berhasil Menghapus Berkas.");
      redirect('ruangan/notulen/'.$id);
    } else {
      $this->session->set_flashdata('gagal', "Gagal Menghapus Berkas.");
      redirect('ruangan/notulen/'.$id);
    }
  }

  public function hapus_dasar_surat($id) {
    $hapus = unlink('assets/ruangan/dasarsurat/dasar_surat_'.$id.'.pdf');
    //$hapus2 = unlink('assets/docx-surat-processed/SRT_'.$id.'.docx');

    if ($hapus) {
      $this->session->set_flashdata('sukses', "Berhasil Menghapus Berkas.");
      redirect('ruangan/notulen/'.$id);
    } else {
      $this->session->set_flashdata('gagal', "Gagal Menghapus Berkas.");
      redirect('ruangan/notulen/'.$id);
    }
  }

  public function update() {
    $id              = $this->input->post('id');
    $id_ruangan      = $this->input->post('id_ruangan');
    $seksi           = $this->input->post('seksi');
    if($seksi == 'lainnya'){
      $seksi        = $this->input->post('seksi_lainnya');
    }
    $kegiatan        = $this->input->post('kegiatan');
    $acara           = $this->input->post('acara');
    $target_undangan = $this->input->post('target_undangan');
    $snack           = $this->input->post('snack');
    $mamin           = $this->input->post('mamin');
    $tanggal         = $this->input->post('tanggal');
    $awal1           = $this->input->post('awal1');
    $awal2           = $this->input->post('awal2');
    $akhir1          = $this->input->post('akhir1');
    $akhir2          = $this->input->post('akhir2');
    $ket             = $this->input->post('keterangan');
    $pegawai             = $this->input->post('pegawai');
    // var_dump($pegawai);die();

    $waktu_awal   = array($awal1, $awal2, "00");
    $waktu_akhir  = array($akhir1, $akhir2, "00");

    $waktu_awal = implode(":", $waktu_awal);
    $waktu_akhir = implode(":", $waktu_akhir);

    $tanggalawal = array(date("Y-m-d"), $waktu_awal);
    $tanggalawal = implode(" ", $tanggalawal);


    if (strtotime($waktu_awal) && strtotime($waktu_akhir)) {

      $date1 = date_create(date("Y-m-d"));
      $date2 = date_create($tanggal);
      $diff = date_diff($date1,$date2);
      $diff = $diff->days;

      // if ($diff < 2) {
      //   $this->session->set_flashdata('gagal', "Waktu Booking kurang dari H -2.");
      //   redirect('ruangan/ubah/'.$id);
      // }
      if(!empty($pegawai)){
        $pic = $this->m_ruangan->ruangan_pic_edit($id, $pegawai);
      }
      // $input
      $adaBooking = $this->m_ruangan->update_booking($id, $id_ruangan, $tanggal, $waktu_awal, $waktu_akhir);

      if (!$adaBooking) {
        $simpan = $this->m_ruangan->update_pakai($id, $id_ruangan, $seksi, $kegiatan, $acara, $target_undangan, $snack, $mamin, $tanggal, $waktu_awal, $waktu_akhir, $ket);
          $pegawai   = $this->input->post('pegawai');
          // var_dump($pegawai);die();
          if(!empty($pegawai)){
          foreach ($pegawai as $data) {
            $simpan_pegawai = $this->m_ruangan->simpan_pegawai($data, $id);
            if(!$simpan_pegawai){
              $this->session->set_flashdata('gagal', "Pegawai tidak di temukan");
              redirect('ruangan');
            }
          }
        }
        if ($simpan != 0) {

           if($this->All){

            // $this->m_ruangan->del_tim($id);
             $pkepada      = $this->input->post('listizin');
             // var_dump($pkepada, $simpan);die();
             $user_kepada   = ($pkepada ? $pkepada : Array());

               if (!empty($user_kepada)) {
                foreach ($user_kepada as $row) {
                  $save_kepada = $this->m_ruangan->save_tim($id, $row);

                  if(!$save_kepada) {
                    $this->session->set_flashdata('gagal', "Gagal Menyimpan Data 1");
                    redirect('/ruangan/add/'.$id);
                  }
                }
              }

          }
         
          $file = $_FILES["file_srt"]["name"];
          $file_name = basename($_FILES["file_srt"]["name"]);
          $ext = pathinfo($file, PATHINFO_EXTENSION);
          
          $target_dir = "assets/ruangan/notdin/";
          $target_file = $target_dir . $file_name;
          if (!is_dir($target_dir)) {
              mkdir($target_dir, 0755, true); // recursive mkdir, izin 755
          }
  
          $fileBaru = $target_dir.'NOTAMAMIN_'.$id.'.'.$ext;
  
          $upload = move_uploaded_file($_FILES["file_srt"]["tmp_name"], $target_file);
  
          if($upload) {
            $rnm = rename($target_file, $fileBaru);
             $this->session->set_flashdata('sukses', "Berhasil Menyimpan Data & Mengupload Dokumen .");
              redirect('ruangan');
            }
            else {
            $this->session->set_flashdata('gagal', "Berhasil Menyimpan Data Tetapi Gagal Menggunggah File Dokumen.");
            redirect('ruangan');
          }
        }
      } else {
        $this->session->set_flashdata('gagal', "Sudah ada data booking pada waktu dan ruangan yang dipilih.");
        redirect('ruangan/ubah/'.$id);
      }
    } else {
      $this->session->set_flashdata('gagal', "Data waktu yang diinput salah.");
      redirect('ruangan/ubah/'.$id);
    }
  }

  public function updateNotulen() {

    $iduser = $this->session->userdata('id_auth');

    $id       = $this->input->post('id');
    $notulen  = $this->input->post('notulen');
    $id_peg   = $this->m_ruangan->get_id_pegawai($iduser);
    $ket_pic  = $this->m_ruangan->keterangan_pic($id_peg, $id, $notulen);
    
    $simpan = $this->m_ruangan->update_notulen($id, $notulen);

    if ($simpan != 0) {
         
          // dasar surat
          $file2 = $_FILES["file_dasar_surat"]["name"];
          $file_name2 = basename($_FILES["file_dasar_surat"]["name"]);
          $ext2 = pathinfo($file2, PATHINFO_EXTENSION);
          
          $target_dir2 = "assets/ruangan/dasarsurat/";
          $target_file2 = $target_dir2 . $file_name2;
          
          if (!is_dir($target_dir2)) {
              mkdir($target_dir2, 0755, true); // recursive mkdir, izin 755
          }
  
          $fileBaru2 = $target_dir2.'dasar_surat_'.$id.'.'.$ext2;
  
          $upload2 = move_uploaded_file($_FILES["file_dasar_surat"]["tmp_name"], $target_file2);
          // var_dump($upload2);die();

          // surat undangan
          $file1 = $_FILES["file_srt_udg"]["name"];
          $file_name1 = basename($_FILES["file_srt_udg"]["name"]);
          $ext1 = pathinfo($file1, PATHINFO_EXTENSION);
          
          $target_dir1 = "assets/ruangan/undangan/";
          $target_file1 = $target_dir1 . $file_name1;
          
          if (!is_dir($target_dir1)) {
              mkdir($target_dir1, 0755, true); // recursive mkdir, izin 755
          }
  
          $fileBaru1 = $target_dir1.'undangan_'.$id.'.'.$ext1;
  
          $upload1 = move_uploaded_file($_FILES["file_srt_udg"]["tmp_name"], $target_file1);
          // var_dump($upload1);die();

          // notulen
          $file = $_FILES["file_srt"]["name"];
          $file_name = basename($_FILES["file_srt"]["name"]);
          $ext = pathinfo($file, PATHINFO_EXTENSION);
          
          $target_dir = "assets/ruangan/notulen/";
          $target_file = $target_dir . $file_name;
  
          if (!is_dir($target_dir)) {
              mkdir($target_dir, 0755, true); // recursive mkdir, izin 755
          }
          $pegawai = $this->m_ruangan->get_id_user_pic($id);
          if(!empty($pegawai)){
          $fileBaru = $target_dir.'NOTULEN_'.$id.'_'.$id_peg.'.'.$ext;
          }else{
          $fileBaru = $target_dir.'NOTULEN_'.$id.'.'.$ext;
          }
  
          $upload = move_uploaded_file($_FILES["file_srt"]["tmp_name"], $target_file);
  
          if($upload || $upload1 || $upload2) {
            $rnm = rename($target_file, $fileBaru);
            $rnm1 = rename($target_file1, $fileBaru1);
            $rnm2 = rename($target_file2, $fileBaru2);
             $this->session->set_flashdata('sukses', "Berhasil Menyimpan Data & Mengupload Dokumen .");
              redirect('ruangan');
            }
            else {
            $this->session->set_flashdata('gagal', "Berhasil Menyimpan Data Tetapi Gagal Menggunggah File Dokumen.");
            redirect('ruangan');
          }
        }
  }

  public function hapus($id) {
    $iduser = $this->session->userdata('id_auth');
    $hapus = $this->m_ruangan->hapus_pakai($id, $iduser);

    if ($hapus) {
       $this->m_ruangan->del_tim($id);
      $this->session->set_flashdata('sukses', "Berhasil Hapus Data.");
      redirect('ruangan');
    } else {
      $this->session->set_flashdata('gagal', "Gagal Hapus Data.");
      redirect('ruangan');
    }
  }
  
  public function QRview($id=NULL) {
    $data['id'] = $id;
    $data['pakai'] = $this->m_ruangan->get_datapakai($id);
  	$data['page_name'] = "View";
    $this->load->vars($data);
    $this->load->view('pick_views', $data);
  }

  public function cetak_excel($id) { // cetak list per izin ke Excel
    $data_absen = $this->m_ruangan->get_absensi($id);
    $data_acara = $this->m_ruangan->get_datapakai($id);

    // header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
    // header("Content-Disposition: attachment; filename=Absen - ".$data_acara->acara.".xls");
    // header("Expires: 0");
    // header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    // header("Cache-Control: private",false);
        // var_dump($data_acara);die();
    $jdl_laporan = "<tr>ABSENSI KEGIATAN  : ".$data_acara->acara." di ".$this->m_ruangan->get_nama($data_acara->id_ruangan)." (".$this->lib_date->mysql_to_human($data_acara->tanggal)." ".$data_acara->waktu_awal." - ".$data_acara->waktu_akhir.")</tr>";
    
    $jdl = "<tr>
              <td>".'NO'."</td>
              <td>".'NAMA'."</td>
              <td>".'INSTANSI'."</td>
              <td>".'NO HANDPHONE'."</td>
              <td>".'TANDA TANGAN'."</td>";
    
    $jdl = $jdl . "</tr>";
    
    echo "<table width='100%' border='0' font-size:16px;'>";
    echo $jdl_laporan;
    echo "</table>";
    echo "<table width='100%' cellspacing='0' cellpadding='0' border='1' style='border-style:solid; border-width:thin;font-size:16px;'>";
    echo $jdl; 
    
    $i=0;
    foreach ($data_absen as $row){
        $i++;
        $isi = "<tr>
                  <td>".$i."</td>
                  <td>".$row->nama."</td>
                  <td>".$row->instansi."</td>
                  <td>".$row->handphone."</td>
                  <td style='text-align:center;width:auto !important;height:30px !important;'><img style='width:100px !important;height:50px !important;' src='https://dpmptsp.jabarprov.go.id/kehadiran/uploads/".$row->id.".png'></td>";
            
            $isi = $isi . "</tr>";
            echo $isi;
    }
    echo "</table>";
  }
  
  public function view_absen($id=NULL) { 
  	$data_absen = $this->m_ruangan->get_absensi($id);
    $data_acara = $this->m_ruangan->get_datapakai($id);

    $data['id_kegiatan'] = $id;
    $data['data_absen'] = $data_absen;
    $data['data_acara'] = $data_acara;
    $this->load->vars($data);

    $js = "function confirm_link(text){
            if(confirm(text)){ return true;
            }else{ return false; }
          }
          
          $(document).ready(function() {
            oTable = $('#pendataan').dataTable({
              \"bJQueryUI\": true,
              \"sPaginationType\": \"full_numbers\"
            });
          });
          $(function() {
            $(\".monbulan\").datepicker({
              changeMonth: true,
              changeYear: true,
              dateFormat: 'yy-mm-dd',
              closeText: 'X'
            });
            $('#form').validate();
          });";

    $this->template->set_metadata_javascript($js);
    $this->session_info['page_name'] = "Data Kehadiran (Absensi)";
    $this->template->build('absen_list', $this->session_info);
  }

  public function view_notulen($id=NULL) { 
    $id_auth = $this->session->userdata('id_auth');
    $iduser = $this->m_ruangan->get_id_pegawai($id_auth);
  	$data_notulen = $this->m_ruangan->get_id_user_pic($id);
  	$data_ruangan = $this->m_ruangan->get_data_id($id);
    // var_dump($data_ruangan[0]->user_id);die();
 
    $data['id_kegiatan'] = $id;
    $data['id_peg'] = $iduser;
    $data['id_auth'] = $id_auth;
    $data['data_notulen'] = $data_notulen;
    $data['data_ruangan'] = $data_ruangan;
    $this->load->vars($data);

    $js = "function confirm_link(text){
            if(confirm(text)){ return true;
            }else{ return false; }
          }
          
          $(document).ready(function() {
            oTable = $('#pendataan').dataTable({
              \"bJQueryUI\": true,
              \"sPaginationType\": \"full_numbers\"
            });
          });
          $(function() {
            $(\".monbulan\").datepicker({
              changeMonth: true,
              changeYear: true,
              dateFormat: 'yy-mm-dd',
              closeText: 'X'
            });
            $('#form').validate();
          });";

    $this->template->set_metadata_javascript($js);
    $this->session_info['page_name'] = "Data Kehadiran (Absensi)";
    $this->template->build('notulen_list', $this->session_info);
  }
  public function tes($id) { // cetak list per izin ke Excel
    $data_absen = $this->m_ruangan->get_absensi($id);
    $data_acara = $this->m_ruangan->get_datapakai($id);

    // $pakai = $this->m_ruangan->get_data_cetak_excel($tgla, $tglb, $iduser, $admin);

        $data['data_absen'] = $data_absen;
        $data['data_acara'] = $data_acara;
        // $data['title'] = 'Daftar Hadir';
        $data['jdl_laporan'] = 'Daftar Hadir';
        
    $this->load->vars($data);
    $this->load->view('cetak_dafhadir',$data);
  }

  public function print_pdf($id){
    
    $this->load->library('dompdf_gen');
    $data_absen = $this->m_ruangan->get_absensi($id);
    $data_acara = $this->m_ruangan->get_datapakai($id);
    $data['data_absen'] = $data_absen;
    $data['data_acara'] = $data_acara;
    $this->load->view('absen_pdf', $data);
    $paper_size = 'F4';
    $orientation = 'Potrait';
    $html = $this->output->get_output();
    $stream = true;
    $this->dompdf->load_html($html);
    $this->dompdf->set_paper($paper_size, $orientation);
    $this->dompdf->render();
    if($stream) {
      $this->dompdf->stream("absensi.pdf", array('Attachment' =>0));  
    }else{
      return $this->dompdf->output();
    }
  }
  
  public function cetak($id = null){ // cetak Daftar Hadir ke PDF
  	$data_absen = $this->m_ruangan->get_absensi($id);
    $data_acara = $this->m_ruangan->get_datapakai($id);
    $file = date('Ymd',strtotime($data_acara->tanggal))." ".date('Hi',strtotime($data_acara->waktu_awal))."-".date('Hi',strtotime($data_acara->waktu_akhir)).' Daftar Hadir.pdf';
    $ket = $data_acara->keterangan;
    if($ket == ''){
      $lantai = "Lantai ".$this->m_ruangan->get_lantai($data_acara->id_ruangan);
    }else{
      $lantai = $ket;
    }  
    // Ambil KOP Surat
    $kop = base_url() . 'uploads/logo/kop.png';

    $judul1  = 'DAFTAR HADIR';
    $judul2  = 'HARI / TANGGAL';
    $isi2    = $this->lib_date->get_day($data_acara->tanggal).' / '.$this->lib_date->mysql_to_human($data_acara->tanggal)."; ".$data_acara->waktu_awal." - ".$data_acara->waktu_akhir;
    $judul3  = 'ACARA';
    $isi3    = $data_acara->acara;
    $judul4  = 'TEMPAT';
    $isi4    = $this->m_ruangan->get_nama($data_acara->id_ruangan).", ".$lantai;
    
    //    $pdf = new FPDF({P/L},{pt/mm/cm/in},{A3/A4/A5/LETTER/LEGAL});
    $pdf = new FPDF('P', 'mm', 'A4'); //('a3'=>array(841.89,1190.55), 'a4'=>array(595.28,841.89), 'a5'=>array(420.94,595.28), 'letter'=>array(612,792), 'legal'=>array(612,1008));
    $pdf->SetMargins(1, 1);
    $pdf->SetFillColor(210,221,242);
    $pdf->AddPage();
    $pdf->Image($kop, -3, -2, 223);
    
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Ln(45);
    $pdf->Cell(0, 0.5, $judul1, 0, 1, 'C');
    $pdf->SetFont('Arial', '', 11);
    $pdf->Ln(7);
    $pdf->SetX(10); $pdf->Cell(0,  0.5, $judul2, 0, 1, 'L');
    $pdf->SetX(45); $pdf->Cell(0, -0.5, ':', 0, 1, 'L');
    $pdf->SetX(48); $pdf->Cell(0, -0.5, $isi2, 0, 1, 'L');
    $pdf->Ln(5);
    $pdf->SetX(10); $pdf->Cell(0, 0.5, $judul3, 0, 1, 'L');
    $pdf->SetX(45); $pdf->Cell(0, -0.5, ':', 0, 1, 'L');
    $pdf->SetXY(48, $pdf->GetY()-2); $pdf->MultiCell(155, 4.5, $isi3, 0, 'L'); // $pdf->Cell(0, -0.5, $isi3, 0, 1, 'L');
    $pdf->Ln(3);
    $pdf->SetX(10); $pdf->Cell(0, 0.5, $judul4, 0, 1, 'L');
    $pdf->SetX(45); $pdf->Cell(0, -0.5, ':', 0, 1, 'L');
    $pdf->SetX(48); $pdf->Cell(0, -0.5, $isi4, 0, 1, 'L');
    $pdf->SetMargins(1, 1);
    
    //cetak isi tabel ke pdf
    //Mencetak judul dengan tinggi bervariasi
    $judul = array('NO', 'NAMA', 'JABATAN', 'TANDATANGAN');
    $l_col = array(10, 67, 85, 30); // total 438 utk legal L; total 207 utk A4 P
    $align = array('C', 'C', 'C', 'C');
    $hit_judul = count($judul);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Ln(5);
    $space = 5;
    $nb = 0;
    for($i = 0; $i < count($judul); $i++)
    $nb = max($nb, $pdf->NbLines($l_col[$i], $judul[$i]));
    $h = $space * $nb;
    $pdf->CheckPageBreak($h);
    $pdf->SetX(10);
    for ($i = 0; $i < count($judul); $i++) {
      $w = $l_col[$i];
      $a = isset($align[$i]) ? $align[$i] : 'L';
      $x = $pdf->GetX();
      $y = $pdf->GetY();
      $pdf->Rect($x, $y, $w, $h);
      $pdf->MultiCell($w, $space, $judul[$i], 1, $a, true);
      $pdf->SetXY($x + $w, $y);
    }
    $pdf->Ln($h);
    //EOF(Mencetak judul dengan tinggi bervariasi)
    
    //Mencetak Isi Tabel
    $alignIsi = array('R', 'L', 'L', 'L');
    $brs = 0;
    foreach ($data_absen as $isi) {
    	$pdf->SetFont('Arial', '', 9);
      $brs++;
    	$IsiTab = array($brs, $isi->nama, $isi->instansi, '');
      $space = 3;
      $nb = 0;
      for($i = 0; $i < count($IsiTab); $i++)
      $nb = max($nb, $pdf->NbLines($l_col[$i], $IsiTab[$i]));
      $h = ($space * $nb) + 8;
      $pdf->SetX(10);
      for ($i = 0; $i < count($IsiTab); $i++) {
        $w = $l_col[$i];
        $a = isset($alignIsi[$i]) ? $alignIsi[$i] : 'L';
        $x = $pdf->GetX();
        $y = $pdf->GetY();
        $pdf->Rect($x, $y, $w, $h);
        $pdf->MultiCell($w, $space+2, $IsiTab[$i], 0, $a);
        if($i == 2){
        	$pdf->SetX($w+2);
          $pdf->MultiCell($w, $space, $isi->jabatan, 0, $a);
        }
        $pdf->SetXY($x + $w, $y);
      }
      
          $routees = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
          $root = rtrim($_SERVER['DOCUMENT_ROOT'], '/'); // buang trailing slash
          $routees = ltrim($routees, '/');              // buang leading slash
          $routees_portal = str_replace('backoffice/index.php', '', $_SERVER['SCRIPT_NAME']); 
          $master_url     = $_SERVER['REQUEST_SCHEME'] .'://'. $_SERVER['HTTP_HOST'];
          $n_ttd = $root . '/' .$routees_portal.'kehadiran/uploads/'.$isi->id.'.png';
      if(file_exists($n_ttd)){
        $n_ttd = $master_url.$routees_portal.'kehadiran/uploads/'.$isi->id.'.png';	
      }else{	
        if($isi->id_pegawai == '0'){
          $n_ttd = $master_url.$routees_portal.'kehadiran/uploads/blank.png';
        }else{
        	$ttd_kepeg = $master_url.$routees.'uploads/logo/' . $this->m_ruangan->get_nippegawai($isi->id_pegawai) . '.png';
          $headers = @get_headers($ttd_kepeg);
          if($headers && strpos($headers[0], '200') !== false) {
            $n_ttd = $master_url.$routees.'uploads/logo/'.$this->m_ruangan->get_nippegawai($isi->id_pegawai).'.png';
          }else{
            $n_ttd = $master_url.$routees_portal.'kehadiran/uploads/blank.png';
          }
        }
      }	
      $pdf->Image($n_ttd, $x+2.5, $y+0.5, 25, 10);
      
      $pdf->Ln($h);
      $pdf->CheckPageBreak($h);
      if($y >= 240){ // jika berhasil break page buat ulang cover 249
        $pdf->SetMargins(1, 1);
        $pdf->AddPage();
        $pdf->Image($kop, -3, -2, 223);
        
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Ln(45);
        $pdf->Cell(0, 0.5, $judul1, 0, 1, 'C');
        $pdf->SetFont('Arial', '', 11);
        $pdf->Ln(7);
        $pdf->SetX(10); $pdf->Cell(0, 0.5, $judul2, 0, 1, 'L');
        $pdf->SetX(45); $pdf->Cell(0, -0.5, ':', 0, 1, 'L');
        $pdf->SetX(48); $pdf->Cell(0, -0.5, $isi2, 0, 1, 'L');
        $pdf->Ln(5);
        $pdf->SetX(10); $pdf->Cell(0, 0.5, $judul3, 0, 1, 'L');
        $pdf->SetX(45); $pdf->Cell(0, -0.5, ':', 0, 1, 'L');
        $pdf->SetXY(48, $pdf->GetY()-2); $pdf->MultiCell(155, 4.5, $isi3, 0, 'L'); // $pdf->Cell(0, -0.5, $isi3, 0, 1, 'L');
        $pdf->Ln(3);
        $pdf->SetX(10); $pdf->Cell(0, 0.5, $judul4, 0, 1, 'L');
        $pdf->SetX(45); $pdf->Cell(0, -0.5, ':', 0, 1, 'L');
        $pdf->SetX(48); $pdf->Cell(0, -0.5, $isi4, 0, 1, 'L');
        $pdf->SetMargins(1, 1);
        
        //Mencetak judul dengan tinggi bervariasi
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Ln(5);
        $space = 5;
        $nb = 0;
        for($i = 0; $i < count($judul); $i++)
        $nb = max($nb, $pdf->NbLines($l_col[$i], $judul[$i]));
        $h = $space * $nb;
        $pdf->CheckPageBreak($h);
        $pdf->SetX(10);
        for ($i = 0; $i < count($judul); $i++) {
          $w = $l_col[$i];
          $a = isset($align[$i]) ? $align[$i] : 'L';
          $x = $pdf->GetX();
          $y = $pdf->GetY();
          $pdf->Rect($x, $y, $w, $h);
          $pdf->MultiCell($w, $space, $judul[$i], 1, $a, true);
          $pdf->SetXY($x + $w, $y);
        }
        $pdf->Ln($h);
        //EOF(Mencetak judul dengan tinggi bervariasi)
      }
    }
    //EOF() Mencetak Isi Tabel
    
    //$pdf->SetFont('Arial', '', 8);
    //$pdf->Ln(20);
    //$pdf->SetX(150);
    //$pdf->Cell(0, 0.5, $kota . ', ' . $this->lib_date->mysql_to_human($this->lib_date->get_date_now()), 0, 1, 'L');
    #output file PDF {I:ViewStd ;D:Download ;F:SaveLocalFile S:ReturnString}
    $pdf->Output($file, 'D');
    //EOF() cetak isi tabel ke pdf
  }
  
  public function notif($jml=null, $tgla=null, $tglb=null) {
  	echo $this->lib_date->view_title('Kirim Notifikasi Kelengkapan Notulen');
  	session_start();
    $ID_Notif = $_SESSION['Data_Notif']; // data array id agenda yang belum mengisi laporan  
    // var_dump($ID_Notif);
  	// die();
    $jumlah = 0;
    $kirim = 0;
    require_once("assets/plugins/phpmailer/class.phpmailer.php");
    require_once("assets/plugins/phpmailer/class.smtp.php");
    foreach ($ID_Notif as $id){
      $jumlah++;
      $ruangan_pemakai = new ruangan_pemakai();
      $ruangan_pic = new ruangan_pic();

      $row = $ruangan_pemakai->get_by_id($id);
      $row_ruangan_pic = $ruangan_pic->where('id_ruangan',$id)->get();
      // $row_ruangan_pic = $ruangan_pic->where('id_ruangan',$id)->get();
      
      $val_sts_notif = $row->sts_notif + 1;
      $sender_notif = $row->sender_notif.$this->session->userdata('id_auth').',';
      $id_user = $row->user_id;

      if($row_ruangan_pic->id_pegawai == null){
        $user = new user();
        $user = $user->get_by_id($id_user);
        
      }else{
        $pegawai = new tmpegawai();
        $pegawai = $pegawai->get_by_id($row_ruangan_pic->id_pegawai);

        $user = $pegawai->user->get();

      }
      // var_dump($user->no_hp);die();

      $sendS = FALSE;
      $n_hp = $user->no_hp;
      //$n_hp = '08121314834';
      //$n_email = 'dhies1694@gmail.com';
      $n_pesan = 'Agenda kegiatan *'.$row->acara.'* yang '.'bpk/ibu '.$user->oriname.' rencanakan untuk dilakasankan pada tanggal *'.$this->lib_date->mysql_to_human($row->tanggal).
                 '* pukul : *'.$row->waktu_awal.'* *s/d* *'.$row->waktu_akhir.'* belum dilengkapi eviden berupa laporan atau notulen,'.
                 ' untuk itu dimohon dapat mengunggah pada aplikasi Sijempol'.'<br><br>'.'*_Tim Penilaian Kinerja & Kearsipan_*';
	    
	    if($row->sts_notif == 0){  // sementara hanya kirim 1 x saja, tidak boleh berulang
	      // Mengirim WA / SMS
	      $this->settings->where('name', 'smsGateway')->get();
	      if($this->settings->status == 1) {
          $campaign  = 'Penyerahan';
          $sendS = $this->lib_date->postWaSms($n_hp,$n_pesan,$campaign); // $sendS = TRUE;
        }
        // EOF() Mengirim WA / SMS
      }  

	    if($sendS){
	    	$kirim++;
        $this->m_ruangan->update_send_Notif($id,$val_sts_notif,$sender_notif);
	    }
    }
    //echo 'kirim:'.$kirim; die();
    redirect('ruangan/index/'.$tgla.'/'.$tglb);
  }

  public function cetak_absen_excel($id = null) {
    $data_absen = $this->m_ruangan->get_absensi($id);
    $data_acara = $this->m_ruangan->get_datapakai($id);

    $data = [
        'data_absen' => $data_absen,
        'data_acara' => $data_acara,
        'kop' => base_url('uploads/logo/kop.png'), // Path ke gambar kop surat
    ];

    // Nama file output
    $file_name = date('Ymd', strtotime($data_acara->tanggal)) . " " . 
                 date('Hi', strtotime($data_acara->waktu_awal)) . "-" . 
                 date('Hi', strtotime($data_acara->waktu_akhir)) . ' Daftar Hadir.xls';

    // Set headers untuk file Excel
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=\"$file_name\"");
    header("Pragma: no-cache");
    header("Expires: 0");

    // Load view
    $this->load->view('absen_excel', $data);
  }
  
  public function deleteImage(){
    $filename = $this->input->post('filename');
    if($filename){
      $imagePath = FCPATH . 'uploads/' . $filename; // Sesuaikan path folder penyimpanan gambar
      if (file_exists($imagePath)) {
        unlink($imagePath); // Hapus file
        echo "success";
      }else{
        echo "error";
      }
    }else{
      echo "error";
    }
  }
}