<?php
/*
 * Created By : Arif Ahmadi / 05-01-2022
 */

class Gpt extends WRC_AdminCont {
  public function __construct() {
    parent::__construct();
    $this->load->model("m_pengembangan");
    $this->load->model("m_nib");
    $base_url = base_url();
    $this->enabled = FALSE;
    $this->All = FALSE;
    $list_auths = $this->session_info['app_list_auth'];
    foreach ($list_auths as $list_auth) {
      if($list_auth->id_role === '18') {
        $this->All = TRUE;
      }
      if($list_auth->id_role === '54') {
        $this->enabled = TRUE;
      }
    }
  }

  public function index(){
    $now = $this->lib_date->get_date_now();
    // $tgla = (!empty($this->input->post('tgla')) ? $this->input->post('tgla') : $this->lib_date->set_date($now, 0));
    $tgla = (!empty($this->input->post('tgla')) ? $this->input->post('tgla') : $this->lib_date->set_date($now, -180));
    $tglb = (!empty($this->input->post('tglb')) ? $this->input->post('tglb') : $this->lib_date->set_date($now, 1));
    $layanan_gpt = (!empty($this->input->post('layanan_gpt')) ? $this->input->post('layanan_gpt') : NULL);
    $iduser         = $this->session->userdata('id_auth');
  	$ruangan = $this->m_pengembangan->get_data_nib($tgla, $tglb);
  	$data_event_gpt = $this->m_pengembangan->query_get_data_gpt($tgla, $tglb, $layanan_gpt);
    $data['tgla'] = $tgla;
    $data['tglb'] = $tglb;
    $data['layanan_gpt'] = $layanan_gpt;
    $data['data_event_gpt'] = $data_event_gpt;
    $data['iduser'] = $iduser;
    $this->load->vars($data);

    // $js = "function confirm_link(text){
    //         if(confirm(text)){ return true;
    //         }else{ return false; }
    //       }
          
    //       $(document).ready(function() {
    //         oTable = $('#pendataan').dataTable({
    //           \"bJQueryUI\": true,
    //           \"sPaginationType\": \"full_numbers\"
    //         });
    //       });
    //       $(document).ready(function() {
    //         oTable = $('#GPT').dataTable({
    //           \"bJQueryUI\": true,
    //           \"sPaginationType\": \"full_numbers\"
    //         });
    //       });
    //       $(function() {
    //         $(\".monbulan\").datepicker({
    //           changeMonth: true,
    //           changeYear: true,
    //           dateFormat: 'yy-mm-dd',
    //           closeText: 'X'
    //         });
    //         $('#form').validate();
    //       });
          
    //         $(function() {
    //            $(\"#tabs\").tabs();
    //           $(\".monbulan\").datepicker({
    //             changeMonth: true,
    //             changeYear: true,
    //             dateFormat: 'yy-mm-dd',
    //             closeText: 'X'
    //           });
    //           $('#form').validate();
    //         });";

    // $this->template->set_metadata_javascript($js);
    $this->session_info['page_name'] = "Inisiasi GPT";
    $this->template->build('layanan_gpt', $this->session_info);
  }

  public function akun_antrian(){
    $id_user = $this->session->userdata('id_auth');
    if ($id_user != 680) {
        redirect('dashboard');
    }
    $akun_antrian = $this->m_nib->akun_antrian();
    $data['akun_antrian'] = $akun_antrian;
    $data['id_user'] = $id_user;
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
          $(document).ready(function() {
            oTable = $('#GPT').dataTable({
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
          
            $(function() {
               $(\"#tabs\").tabs();
              $(\".monbulan\").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy-mm-dd',
                closeText: 'X'
              });
              $('#form').validate();
            });";

    $this->template->set_metadata_javascript($js);
    $this->session_info['page_name'] = "Inisiasi GPT";
    $this->template->build('akun_antrian_gpt', $this->session_info);
  }

  public function refresh_akun($id = NULL){
    if($id != NULL){
      $sql = "SELECT * FROM public.event WHERE id = $id";
    }else{
      $sql = "SELECT * FROM public.event";
    }
  	$data = $this->db->query($sql)->result();
    foreach ($data as $value) {
      if(!empty($value->session_token)){
          $this->db->set('session_token', '');
          $this->db->where('id', $value->id);
          $this->db->update('public.event');
      }
    }
    if($id != NULL){
      $this->session->set_flashdata('sukses', "Akun Berhasil Di refresh");
      redirect('/pengembangan/gpt');
    }else{
      $this->session->set_flashdata('sukses', "Akun Berhasil Di refresh");
      redirect('/pengembangan/gpt/akun_antrian');
    }
  }

  public function cek_antrian($id = NULL){
    if($id == NULL){
    $layanan_gpt = "3";
    }else{
      $layanan_gpt = $id;
    }
    $leveling = 'admin';
  	// $data_event_gpt = $this->m_pengembangan->query_get_data_gpt($tgla, $tglb, $layanan_gpt, $leveling);
    $sql = "SELECT * FROM public.pelayanan_gpt WHERE layanan_gpt = $layanan_gpt AND status_checkin = 1 ORDER BY `tanggal_checkin` ASC";
  	$data_event_gpt = $this->db->query($sql)->result();
    $no = 1;
    foreach ($data_event_gpt as $value) {
      echo $value->no_antri.'<br>';
      if ($value->no_antri != $no) {
          $this->db->set('no_antri', $no);
          $this->db->where('id', $value->id);
          $this->db->update('public.pelayanan_gpt');
      }
      $no++;
    }
    $this->session->set_flashdata('sukses', "antrian berhasil di refresh");
    return TRUE;
  }
  
    public function fetch_data($tgla = NULL, $tglb = NULL , $layanan_gpt = NULL, $pagea = NULL , $pageb = NULL) {
        $now = $this->lib_date->get_date_now();
        header('Content-Type: application/json');

        // Format data untuk response JSON
        if($layanan_gpt == '0'){
          $layanan_gpt = 0;
          if($this->All){
            $layanan_gpt = NULL;
          }
        }
        // var_dump($layanan_gpt);die();
        if ($tgla != NULL) {
            $tgla = $tgla;
        } else {
            $tgla = $this->lib_date->set_date($now, 0);
        }

        if ($tglb != NULL) {
            $tglb = $tglb;
        } else {
            $tglb = $this->lib_date->set_date($now, 0);
        }
  	    $result = $this->m_pengembangan->query_get_data_gpt_fetch($tgla, $tglb, $layanan_gpt);
        if(empty($result)){
  	      $result = $this->m_pengembangan->query_get_data_gpt_fetch_kab_kota($tgla, $tglb, $layanan_gpt);
        }
        $data = [];
        foreach ($result as $row) {
            if($row->file == NULL){ 
              $file = '-'; 
            }else{ 
              $file = $row->file; 
            }
            $dateString = $row->tanggal;
            $newFormat = '-';//date("d F Y H:i", strtotime($dateString));
            if($this->session->userdata('id_auth') == '680'){
              $hasDeletePermission = '1';
            }else{
              $hasDeletePermission = '0';
            }
            $data[] = [
                'id' => $row->id,
                'kbli' => $row->kbli,
                'whatsapp' => $row->no_wa,
                'tanggal_input' => date("d F Y", strtotime($row->tanggal)),
                'nama' => $row->nama,
                'nik' => $row->nik,
                'email' => $row->email,
                'petugas_kbli' => $this->m_nib->get_n_pegawai($row->petugas_kbli),
                'petugas_nib' => $this->m_nib->get_n_pegawai($row->petugas_nib),
                'lokasi_event' => $row->lokasi_event,
                'pengubah_data' => $this->m_pengembangan->get_n_user($row->user),
                'tanggal' => $row->tanggal,
                'status_panggil' => $row->status_panggil,
                'no_antri_tidak_langsung' => $row->no_antri_tidak_langsung,
                'layanan' => $this->m_pengembangan->get_layanan_gpt($row->layanan_gpt),
                'no_antri' => $row->no_antri,
                'hasDeletePermission' => $hasDeletePermission,
                'foto_ktp' => (!empty($row->file) ? "https://dpmptsp.jabarprov.go.id/nib/uploads/ktp/" . $row->file : NULL), // URL foto KTP atau NULL jika tidak ada file
            ];
        }
        // Kembalikan data dalam format JSON
        echo json_encode($data);
    }


  public function status_mic($id, $antri, $nik, $menu = NULL) {
    $iduser  = $this->session->userdata('id_auth');
    $data_antrian = $this->m_nib->layanan_gpt_byid($id);
    $nik = $data_antrian->nik;
    $panggil = $this->m_nib->cek_status_gpt($id, $iduser, $nik);
    $no_antri = $antri;
    if($panggil == NULL){
      if($nik == '' || $nik == NULL){

      }else{
        $data_nik = $this->m_nib->ubah_status_bynik($nik);
      }
        $simpan = $this->m_nib->status_panggil_gpt($id); // sudah benar
        $loket = $this->m_nib->get_gpt_id($id);
        if($loket->status_gpt_prov == 0){
          $layanan_gpt = $this->m_nib->layanan_gpt($loket->layanan_gpt);
          $keterangan = "Nomor Antrian, " . $antri . ", atas nama, " . strtolower($loket->nama) . ", menuju loket, " . $layanan_gpt->instansi_lembaga;

          $lokasi = $loket->lokasi_nib;
          $status_prov = 0;
          $tgla = (!empty($this->input->post('tgla')) ? $this->input->post('tgla') : $this->lib_date->set_date($now, 0));
          $tglb = (!empty($this->input->post('tglb')) ? $this->input->post('tglb') : $this->lib_date->set_date($now, 0));
          $data['tgla'] = $tgla;
          $data['tglb'] = $tglb;
          if($menu == NULL){
            $cek_suara = $this->m_nib->cek_suara($id,$iduser);
          }else{
            $id = $loket->nik;
            $cek_suara = $this->m_nib->cek_suara_gpt($id,$iduser);
                if($data_antrian->status_panggil != 0){
                  return "Peserta Sudah di panggil oleh 1";
                  $cek_suara = 'Ada Suara';
                  exit;
                }
                // if($data_antrian->status_panggil != 0){
                //   return "Peserta Sudah di panggil";
                //   $cek_suara = 'Ada Suara';
                //   exit;
                // }else{
                //   $cek_status_panggil = $this->m_nib->cek_status_panggil($id);
                // }
          }
          if($cek_suara == NULL){
            $insert_list = $this->m_nib->insert_panggil_gpt($id, $keterangan,$iduser, $antri, $layanan_gpt->id, $lokasi,$loket->id,$status_prov);
            $insert_list_all = $this->m_nib->insert_panggil_gpt_all($id, $keterangan,$iduser, $antri, $layanan_gpt->id, $lokasi, $loket->id,$status_prov);
              return 'berhasil dipanggil';
              // redirect('pengembangan/gpt', $data);
          }else{
              $npegawai = $this->m_pengembangan->get_user_id($panggil);
              $npegawai = $this->m_nib->get_n_pegawai($npegawai);
              return "Peserta Sudah di panggil oleh 1".$npegawai;
          }
        }else{
          $layanan_gpt = $this->m_nib->layanan_gpt($loket->layanan_gpt);
          $layanan_status_gpt_prov = $this->m_nib->layanan_status_gpt_prov($loket->status_gpt_prov);
          $keterangan = "Nomor Antrian, " . $antri . ", atas nama, " . strtolower($loket->nama) . ", menuju loket, " . $layanan_gpt->instansi_lembaga." ".$layanan_status_gpt_prov->instansi_lembaga ;
          
          $lokasi = $loket->lokasi_nib;
          $status_prov = $layanan_status_gpt_prov->kode_kab;
          $tgla = (!empty($this->input->post('tgla')) ? $this->input->post('tgla') : $this->lib_date->set_date($now, 0));
          $tglb = (!empty($this->input->post('tglb')) ? $this->input->post('tglb') : $this->lib_date->set_date($now, 0));
          $data['tgla'] = $tgla;
          $data['tglb'] = $tglb;
          if($menu == NULL){
            $cek_suara = $this->m_nib->cek_suara($id,$iduser);
          }else{
            $id = $loket->nik;
            $cek_suara = $this->m_nib->cek_suara_gpt($id,$iduser);
                if($data_antrian->status_panggil != 0){
                  return "Peserta Sudah di panggil oleh 1";
                  $cek_suara = 'Ada Suara';
                  exit;
                }
          }
          if($cek_suara == NULL){
            $insert_list = $this->m_nib->insert_panggil_gpt($id, $keterangan,$iduser, $antri, $layanan_gpt->id, $lokasi,$loket->id,$status_prov);
            // $insert_list_all = $this->m_nib->insert_panggil_gpt_all($id, $keterangan,$iduser, $antri, $layanan_gpt->id, $lokasi, $loket->id,$status_prov);
              return 'berhasil dipanggil';
              // redirect('pengembangan/gpt', $data);
          }else{
              $npegawai = $this->m_pengembangan->get_user_id($panggil);
              $npegawai = $this->m_nib->get_n_pegawai($npegawai);
              return "Peserta Sudah di panggil oleh 1".$npegawai;
          }
        }

    }else{
      $npegawai = $this->m_pengembangan->get_user_id($panggil);
      $npegawai = $this->m_nib->get_n_pegawai($npegawai);
      return "Peserta Sudah di panggil oleh 2".$npegawai;
    }
  }

//   public function status_mic($id, $antri, $nik, $menu = NULL) {
//     $iduser  = $this->session->userdata('id_auth');
//     $data_antrian = $this->m_nib->layanan_gpt_byid($id);

//     if (empty($data_antrian)) {
//         return "Data antrian tidak ditemukan.";
//     }

//     $nik = $data_antrian->nik;
//     $panggil = $this->m_nib->cek_status_gpt($id, $iduser, $nik);

//     if ($panggil == NULL) {
//         if (!empty($nik)) {
//             $this->m_nib->ubah_status_bynik($nik);
//         }

//         $simpan = $this->m_nib->status_panggil_gpt($id);

//         $loket = $this->m_nib->get_gpt_id($id);
//         $layanan_gpt = $this->m_nib->layanan_gpt($loket->layanan_gpt);
//         $keterangan = "Nomor Antrian, " . $antri . ", atas nama, " . $loket->nama . ", menuju loket, " . $layanan_gpt->instansi_lembaga;
//         $lokasi = $loket->lokasi_nib;

//         if ($menu == NULL) {
//             $cek_suara = $this->m_nib->cek_suara($id, $iduser);
//         } else {
//             $id = $loket->nik;
//             $cek_suara = $this->m_nib->cek_suara_gpt($id, $iduser);
//         }

//         if ($cek_suara == NULL) {
//             $this->m_nib->insert_panggil_gpt($id, $keterangan, $iduser, $antri, $layanan_gpt->id, $lokasi, $loket->id);
//             $this->m_nib->insert_panggil_gpt_all($id, $keterangan, $iduser, $antri, $layanan_gpt->id, $lokasi, $loket->id);
//             return 'Berhasil dipanggil';
//         } else {
//             $npegawai = $this->m_pengembangan->get_user_id($panggil);
//             $npegawai = $this->m_nib->get_n_pegawai($npegawai);
//             return "Peserta sudah dipanggil oleh " . $npegawai;
//         }
//     } else {
//         $npegawai = $this->m_pengembangan->get_user_id($panggil);
//         $npegawai = $this->m_nib->get_n_pegawai($npegawai);
//         return "Peserta sudah dipanggil oleh " . $npegawai;
//     }
// }

  public function batal_mic($id, $antri, $nik, $menu = NULL) {
    // var_dump($id, $antri, $nik, $menu);die();
      $simpan = $this->m_nib->batal_panggil_gpt($id); // sudah benar
      $data_antrian = $this->m_nib->layanan_gpt_byid($id);
      $nik = $data_antrian->nik;
      $batal = $this->m_nib->batal_antri_bynik($nik);
      redirect('pengembangan/gpt','refresh');
  }

  public function redirect_with_post() {
      $url = site_url('pengembangan/gpt');
      $postData = [
          'key1' => 'value1',
          'key2' => 'value2'
      ];

      echo "<form id='post_redirect' action='{$url}' method='post'>";
      foreach ($postData as $key => $value) {
          echo "<input type='hidden' name='{$key}' value='{$value}'>";
      }
      echo "</form>";
      echo "<script>document.getElementById('post_redirect').submit();</script>";
  }

  // Fungsi untuk mengubah status NIB
  public function selesai_panggil() {
      // Ambil data dari request POST
      $id = $this->input->post('id');
      $status = $this->input->post('status');
      
      // Validasi input
      if (!$id || !isset($status)) {
          echo json_encode(['success' => false, 'message' => 'Data tidak valid']);
          return;
      }

      // Coba update status di model
      try {
          // Memanggil model untuk mengupdate status berdasarkan ID
          $result = $this->m_nib->status_panggil_gpt_selesai($id, $status);

          // Mengambil data antrian untuk proses lebih lanjut
          $data_antrian = $this->m_nib->layanan_gpt_byid($id);
          if ($data_antrian) {
              $nik = $data_antrian->nik;

              // Jika NIK tidak kosong, lanjutkan dengan membatalkan antrian berdasarkan NIK
              if ($nik) {
                  $this->m_nib->batal_antri_bynik($nik);
              }
          }

          // Mengirimkan response ke frontend
          if ($result) {
              return json_encode(['success' => true, 'message' => 'Status berhasil diperbarui']);
          } else {
              return json_encode(['success' => false, 'message' => 'Gagal memperbarui status']);
          }
      } catch (Exception $e) {
          // Menangani error dan memberikan respons yang sesuai
          return json_encode(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
      }
  }

  public function edit_akun_gpt($id){
    $iduser           = $this->session->userdata('id_auth');
    $data['akun']     = $this->m_nib->edit_akun($id);
    $data['tb_layanan_gpt']       = $this->m_nib->tb_layanan_gpt();
    // var_dump($data['tb_layanan_gpt']);die();
    // $data['pegawai']  = $this->m_nib->get_pegawai();
    $data['step']     = "update"; 
    $data['iduser']   = $iduser;
    $data['id']       = $id;
    // var_dump($data['pakai']);die();
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
      $this->session_info['page_name'] = "Ubah Data Booking";
      $this->template->build('edit_akun_gpt', $this->session_info);
  }

  public function update_akun_gpt(){
    
    $id_user = $this->session->userdata('id_auth');
    if ($id_user != 680) {
        redirect('dashboard');
    }
    $id 	= $this->input->post('id');
    $n_event 	= $this->input->post('n_event');
    $lokasi 	= $this->input->post('lokasi');
    $username 	= $this->input->post('username');
    $password 	= $this->input->post('password');
    $level 	= $this->input->post('level');
    $session_token 	= $this->input->post('session_token');
    $update = $this->m_nib->update_akun_gpt($id, $n_event, $lokasi, $username, $password, $level, $session_token);
    if($update){
      $this->session->set_flashdata('sukses', "Akun Berhasil di ubah");
      redirect('/pengembangan/gpt/akun_antrian');
    }else{
      $this->session->set_flashdata('gagal', "Periksa Kembali koneksi anda");
      redirect('/pengembangan/gpt/akun_antrian');
    }
  }

  public function sinkronisasi_wilayah(){
    $sql_kabkota = "SELECT * FROM db_sicantik_backoffice.trkabupaten WHERE kd_prov = 12";
    $kabkota = $this->db->query($sql_kabkota)->result();
    foreach ($kabkota as $row) {
      $sql_layanan = "SELECT * FROM public.tb_layanan_gpt WHERE kode_kab = $row->id";
      $layanan_gpt = $this->db->query($sql_layanan)->first_row();
        if(empty($layanan_gpt)){
          $insert = array(
              'instansi_lembaga' => $row->n_kabupaten,
              'layanan' => '',
              'pic_nama' => 'Lian Permadi',
              'pic_no_telp' => '',
              'kode_kab' => $row->id
          );
          $save = $this->db->insert('public.tb_layanan_gpt', $insert);
        }
      
    }
  }

  public function sinkronisasi_akun(){
    $sql_tb_layanan_gpt = "SELECT * FROM public.tb_layanan_gpt";
    $tb_layanan_gpt = $this->db->query($sql_tb_layanan_gpt)->result();
    foreach ($tb_layanan_gpt as $row) {
      $save = false;
      $sql_event = "SELECT * FROM public.event WHERE level = $row->id";
      $event_gpt = $this->db->query($sql_event)->first_row();
      $original = $row->instansi_lembaga;
      // Mengubah ke huruf kecil
      $lowercase = strtolower($original);
      // Menghapus simbol dan spasi
      $cleaned = preg_replace('/[^a-z]/', '', $lowercase);
        if(empty($event_gpt)){
          $insert = array(
              'n_event' => $row->instansi_lembaga,
              'lokasi' => $row->instansi_lembaga,
              'username' => $cleaned,
              'password' => 'lian123!@#',
              'level' => $row->id
          );
          $save = $this->db->insert('public.event', $insert);
        }
      
    var_dump($save);
    }die();
  }

}