<?php
/*
 * Created By : Arif Ahmadi / 05-01-2022
 */

class Nib extends WRC_AdminCont {
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
    $tgla = (!empty($this->input->post('tgla')) ? $this->input->post('tgla') : $this->lib_date->set_date($now, 0));
    $tglb = (!empty($this->input->post('tglb')) ? $this->input->post('tglb') : $this->lib_date->set_date($now, 0));
    $layanan_gpt = (!empty($this->input->post('layanan_gpt')) ? $this->input->post('layanan_gpt') : NULL);
    // $tglc = (!empty($this->input->post('tglc')) ? $this->input->post('tglc') : $this->lib_date->set_date($now, 0));
    // $tgld = (!empty($this->input->post('tgld')) ? $this->input->post('tgld') : $this->lib_date->set_date($now, 0));
    
    $iduser         = $this->session->userdata('id_auth');
    
  	$ruangan = $this->m_pengembangan->get_data_nib($tgla, $tglb);
  	$data_event_gpt = $this->m_pengembangan->query_get_data_gpt($tgla, $tglb, $layanan_gpt);

  	$grapik_petugas = $this->m_pengembangan->grapik_petugas($tgla, $tglb);
  	$grapik_lokasi_event = $this->m_pengembangan->grapik_lokasi_event($tgla, $tglb);
  	$grapik_petugas2 = $this->m_pengembangan->grapik_petugas2($tgla, $tglb);
  	$grapik_lokasi_event2 = $this->m_pengembangan->grapik_lokasi_event2($tgla, $tglb);
  	$grapik_petugas3 = $this->m_pengembangan->grapik_petugas3($tgla, $tglb);
  	$grapik_petugas4 = $this->m_pengembangan->grapik_petugas4($tgla, $tglb);
  	$nib_langsung = $this->m_nib->nib_langsung($tgla, $tglb);
    // var_dump($data_event_gpt);die();


    $data['tgla'] = $tgla;
    $data['tglb'] = $tglb;
    $data['layanan_gpt'] = $layanan_gpt;
    $data['nib_langsung'] = $nib_langsung;
    $data['data_event_gpt'] = $data_event_gpt;

    // $data['tgld'] = $tglb;
    $data['iduser'] = $iduser;
    $data['list_pengembangan'] = $ruangan;
    $data['grapik_petugas'] = $grapik_petugas;
    $data['grapik_lokasi_event'] = $grapik_lokasi_event;
    $data['grapik_petugas2'] = $grapik_petugas2;
    $data['grapik_lokasi_event2'] = $grapik_lokasi_event2;
    $data['grapik_petugas3'] = $grapik_petugas3;
    $data['grapik_petugas4'] = $grapik_petugas4;
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
    // $this->session_info['page_name'] = "Sistem Informasi Pengajuan Pengembangan Aplikasi";
    $this->session_info['page_name'] = "Inisiasi NIB";
    $this->template->build('list_nib', $this->session_info);
  }


  public function test_nib(){
    
    $now = $this->lib_date->get_date_now();
    $tgla = (!empty($this->input->post('tgla')) ? $this->input->post('tgla') : $this->lib_date->set_date($now, 0));
    $tglb = (!empty($this->input->post('tglb')) ? $this->input->post('tglb') : $this->lib_date->set_date($now, 0));
    // $tglc = (!empty($this->input->post('tglc')) ? $this->input->post('tglc') : $this->lib_date->set_date($now, 0));
    // $tgld = (!empty($this->input->post('tgld')) ? $this->input->post('tgld') : $this->lib_date->set_date($now, 0));
    
    $iduser         = $this->session->userdata('id_auth');
    
  	$ruangan = $this->m_pengembangan->get_data_nib($tgla, $tglb);
  	$grapik_petugas = $this->m_pengembangan->grapik_petugas($tgla, $tglb);
  	$grapik_lokasi_event = $this->m_pengembangan->grapik_lokasi_event($tgla, $tglb);
  	$grapik_petugas2 = $this->m_pengembangan->grapik_petugas2($tgla, $tglb);
  	$grapik_lokasi_event2 = $this->m_pengembangan->grapik_lokasi_event2($tgla, $tglb);
  	$grapik_petugas3 = $this->m_pengembangan->grapik_petugas3($tgla, $tglb);
  	$grapik_petugas4 = $this->m_pengembangan->grapik_petugas4($tgla, $tglb);
  	$nib_langsung = $this->m_nib->nib_langsung($tgla, $tglb);
    // var_dump($nib_langsung);die();


    $data['tgla'] = $tgla;
    $data['tglb'] = $tglb;
    $data['nib_langsung'] = $nib_langsung;
    // $data['tgld'] = $tglb;
    $data['iduser'] = $iduser;
    $data['list_pengembangan'] = $ruangan;
    $data['grapik_petugas'] = $grapik_petugas;
    $data['grapik_lokasi_event'] = $grapik_lokasi_event;
    $data['grapik_petugas2'] = $grapik_petugas2;
    $data['grapik_lokasi_event2'] = $grapik_lokasi_event2;
    $data['grapik_petugas3'] = $grapik_petugas3;
    $data['grapik_petugas4'] = $grapik_petugas4;
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
    // $this->session_info['page_name'] = "Sistem Informasi Pengajuan Pengembangan Aplikasi";
    $this->session_info['page_name'] = "Inisiasi NIB";
    $this->template->build('list_nib_test', $this->session_info);
  }

  public function nib_tidak_langsung(){
    
    $now = $this->lib_date->get_date_now();
    $tgla = (!empty($this->input->post('tgla')) ? $this->input->post('tgla') : $this->lib_date->set_date($now, 0));
    $tglb = (!empty($this->input->post('tglb')) ? $this->input->post('tglb') : $this->lib_date->set_date($now, 0));
    
    $iduser  = $this->session->userdata('id_auth');
    
  	$ruangan = $this->m_pengembangan->get_data_nib_tidak_langsung($tgla, $tglb);
    
    $data['tgla'] = $tgla;
    $data['tglb'] = $tglb;
    $data['iduser'] = $iduser;
    $data['list_pengembangan'] = $ruangan;
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
    // $this->session_info['page_name'] = "Sistem Informasi Pengajuan Pengembangan Aplikasi";
    $this->session_info['page_name'] = "Inisiasi NIB";
    $this->template->build('nib_tidak_langsung', $this->session_info);
  }

  public function test_suara(){
    
      $this->load->library('espeak');
      $this->espeak->say('nomor test suara');
    $this->session_info['page_name'] = "Inisiasi NIB";
    $this->template->build('index', $this->session_info);

  }

  public function status_mic($id, $antri, $menu = NULL) {
    $iduser  = $this->session->userdata('id_auth');
    $panggil = $this->m_nib->cek_status($id, $iduser);
    $no_antri = $antri;
    if($panggil == NULL){
      $simpan = $this->m_nib->status_panggil($id);
      if($menu == NULL){
        $loket = $this->m_nib->get_user_loket($iduser);
        $keterangan = "Nomor Antrian, " . $antri . ", menuju loket, " . $loket;
      }else{
        $loket = $this->m_nib->get_gpt_id($id);
        $layanan_gpt = $this->m_nib->layanan_gpt($loket->layanan_gpt);
        $keterangan = "Nomor Antrian, " . $antri . ", menuju loket, " . $layanan_gpt->layanan;
        $lokasi = $loket->lokasi_nib;
      }
    // $loket = '2';

    $tgla = (!empty($this->input->post('tgla')) ? $this->input->post('tgla') : $this->lib_date->set_date($now, 0));
    $tglb = (!empty($this->input->post('tglb')) ? $this->input->post('tglb') : $this->lib_date->set_date($now, 0));
    $data['tgla'] = $tgla;
    $data['tglb'] = $tgla;
        if($menu == NULL){
          $cek_suara = $this->m_nib->cek_suara($id,$iduser);
        }else{
          $id = $loket->nik;
          $cek_suara = $this->m_nib->cek_suara_gpt($id,$iduser);
        }
        if($cek_suara == NULL){
        if($menu == NULL){
          $insert_list = $this->m_nib->insert_panggil($id, $keterangan,$iduser, $antri, $loket);
        }else{
          $insert_list = $this->m_nib->insert_panggil_gpt($id, $keterangan,$iduser, $antri, $layanan_gpt->layanan, $lokasi);
        }
          // Generate the JavaScript code
          $output = '
          <script src="https://code.responsivevoice.org/responsivevoice.js?key=jQZ2zcdq"></script>
          <script>
          
                  var loket = "' . $loket . '";
                  function speakText(no_antri) {
                      responsiveVoice.speak("Nomor Antrian, " + no_antri + " , menuju, loket, " + loket, "Indonesian Female");
                  }
                  speakText(' . $no_antri . ');
                  </script>';

          // Output the JavaScript code
          // $this->template->set_metadata_javascript($output);
            echo $output;
            redirect('pengembangan/nib', $data);
          }else{
            $npegawai = $this->m_pengembangan->get_user_id($panggil);
            $npegawai = $this->m_nib->get_n_pegawai($npegawai);
            $this->session->set_flashdata('gagal', "Peserta Sudah di panggil oleh 1".$npegawai);
            redirect('pengembangan/nib','refresh');
          }
    }else{
      $npegawai = $this->m_pengembangan->get_user_id($panggil);
      $npegawai = $this->m_nib->get_n_pegawai($npegawai);
      $this->session->set_flashdata('gagal', "Peserta Sudah di panggil oleh 2".$npegawai);
      redirect('pengembangan/nib','refresh');
    }
  }

  public function qrcode_views($id) {
      // Generate QR Code dengan memanggil fungsi qrcode
      $this->qrcode($id); // Panggil fungsi qrcode
          $root_local = $_SERVER['SCRIPT_FILENAME'];
    $root_fo = str_replace("backoffice/index.php", "", $root_local);
    $root_backoffice = str_replace("index.php", "", $root_local);

      $nfile_foto = str_replace(' ', '', 'foto_'.$id).'.png';
      if (!file_exists('uploads/logo/'.$nfile_foto)) {
          $nfile_foto = '';
      }

      $tamu = $this->m_nib->get_gpt_id($id);
      $data_gpt_by_nik = $this->m_nib->data_gpt_by_nik($tamu->nik);

      $data['tamu'] = $tamu;
      $data['data_gpt_by_nik'] = $data_gpt_by_nik;

      $data['nfile_foto'] = $nfile_foto;

      // Path ke QR Code yang telah dihasilkan
      $data['qrcode_path'] = $root_fo.'assets/qrcode_gpt/qrcode_'.$id.'.png';

      $this->load->vars($data);
      $this->session_info['page_name'] = 'ID Card ';
      $this->template->build('qrcode_views', $this->session_info);
  }

  public function qrcode($id){
              $root_local = $_SERVER['SCRIPT_FILENAME'];
    $root_fo = str_replace("backoffice/index.php", "", $root_local);
    $root_backoffice = str_replace("index.php", "", $root_local);
        $request_uri = $_SERVER['PHP_SELF'];
        $clean_uri_dalam  = $request_uri;
        // Periksa apakah 'index.php' ada dalam URL
        if (strpos($request_uri, 'index.php') !== false) {
            // Hapus 'index.php' dari URL
            $clean_uri_dalam = str_replace('index.php', '', $request_uri);
        }
        $request_uri = $clean_uri_dalam;
        $clean_uri_luar  = $request_uri;
        // Periksa apakah 'index.php' ada dalam URL
        if (strpos($request_uri, 'index.php') !== false) {
            // Hapus 'index.php' dari URL
            $clean_uri_luar = str_replace('index.php', '', $request_uri);
        }
        if (strpos($request_uri, 'backoffice/') !== false) {
            // Hapus 'index.php' dari URL
            $clean_uri_luar = str_replace('backoffice/', '', $request_uri);
        }
            // // Ubah karakter "_" menjadi "."
        $newFileName = str_replace('_', '.', $fileToRename);
        $filename = $newFileName;
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $domain = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$clean_uri_luar;
    include('./assets/qrcode/qrlib.php');
    $tempdir = $root_fo."assets/qrcode_gpt/"; //Nama folder tempat menyimpan file qrcode

    if(!file_exists($tempdir)) //Buat folder bername temp
      mkdir($tempdir);
    
    //ambil logo
    $logopath= $domain."assets/Coat_of_arms_of_West_Java.svg.png";
    
    //isi qrcode jika di scan
    $codeContents = $domain.'main/gpt/'.base64_encode($id); 
    // var_dump($codeContents);die();
    //simpan file qrcode
    QRcode::png($codeContents, $tempdir.date("Y").'WJIS_'.$id.'.png', QR_ECLEVEL_H, 6.9);  // Sesuaikan nilai ini
    
    // ambil file qrcode
    $QR = imagecreatefrompng($tempdir.date("Y").'WJIS_'.$id.'.png');
    
    // memulai menggambar logo dalam file qrcode
    $logo = imagecreatefromstring(file_get_contents($logopath));
    
    imagecolortransparent($logo , imagecolorallocatealpha($logo , 0, 0, 0, 127));
    imagealphablending($logo , false);
    imagesavealpha($logo , true);
    
    $QR_width = imagesx($QR);
    $QR_height = imagesy($QR);
    
    $logo_width = imagesx($logo);
    $logo_height = imagesy($logo);
    
    
    // Scale logo to fit in the QR Code (Anda bisa mengubah nilai 8 sesuai kebutuhan)
    $logo_qr_width = $QR_width / 4;
    // var_dump($logo);die();
    
    $scale = $logo_width / $logo_qr_width;
    $logo_qr_height = $logo_height / $scale;
    
    // Posisi logo diatur ke tengah dan sedikit ke bawah (Anda bisa mengubah nilai sesuai kebutuhan)
    $logo_x = ($QR_width - $logo_qr_width) / 2;
    $logo_y = ($QR_height - $logo_qr_height) / 2.5 + 10;
    
    imagecopyresampled($QR, $logo, $logo_x, $logo_y, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);
    
    // Simpan kode QR lagi, dengan logo di atasnya
    imagepng($QR,$tempdir.'qrcode_'.$id.'.png');
    // var_dump($tempdir);die();
    return true;

    }
  public function get_jumlah_antrian(){
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {

  // ambil tanggal sekarang
  $tanggal = gmdate("Y-m-d", time() + 60 * 60 * 7);

  // sql statement untuk menampilkan jumlah data dari tabel "tbl_antrian" berdasarkan "tanggal"
  $query = mysqli_query($mysqli, "SELECT count(id) as jumlah FROM tbl_antrian 
                                  WHERE tanggal='$tanggal'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
  // ambil data hasil query
  $data = mysqli_fetch_assoc($query);
  // buat variabel untuk menampilkan data
  $jumlah_antrian = $data['jumlah'];

  // tampilkan data
  echo number_format($jumlah_antrian, 0, '', '.');
}
  }

  public function download_pdf($file_nib_pdf, $nama_file = NULL) {
    
        $fileToRename = $file_nib_pdf;
        $request_uri = $_SERVER['PHP_SELF'];
        $clean_uri_dalam  = $request_uri;
        // Periksa apakah 'index.php' ada dalam URL
        if (strpos($request_uri, 'index.php') !== false) {
            // Hapus 'index.php' dari URL
            $clean_uri_dalam = str_replace('index.php', '', $request_uri);
        }
        $request_uri = $clean_uri_dalam;
        $clean_uri_luar  = $request_uri;
        // Periksa apakah 'index.php' ada dalam URL
        if (strpos($request_uri, 'index.php') !== false) {
            // Hapus 'index.php' dari URL
            $clean_uri_luar = str_replace('index.php', '', $request_uri);
        }
        if (strpos($request_uri, 'backoffice/') !== false) {
            // Hapus 'index.php' dari URL
            $clean_uri_luar = str_replace('backoffice/', '', $request_uri);
        }
            // // Ubah karakter "_" menjadi "."
        $newFileName = str_replace('_', '.', $fileToRename);
        $filename = $newFileName;
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $domain = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$clean_uri_luar;
    $data['pdf'] = $domain.'nib/uploads/pdf/'. $newFileName;
    // var_dump($data);die();
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
    $this->session_info['page_name'] = "view pdf";
    $this->template->build('pdf_view', $this->session_info);



    // $file_nib_pdf = base64_decode($file_nib_pdf);
    // $nama_file = base64_decode($nama_file);
    // $email = $nama_file;
    // $username = strstr($email, '@', true);

    // echo $username;die(); // Output: user
        // Lakukan validasi, misalnya login user, sebelum mengizinkan unduh file
        // Lokasi file yang ingin diubah namanya


        // $fileToRename = $file_nib_pdf;

        // // Ubah karakter "_" menjadi "."
        // $newFileName = str_replace('_', '.', $fileToRename);
        // $filename = $newFileName;
        // $extension = pathinfo($filename, PATHINFO_EXTENSION);
        // // $file_path = '/path/to/your/pdf/file.pdf'; // Sesuaikan dengan path file PDF Anda
        // $file_path = $_SERVER['DOCUMENT_ROOT']. '/nib/uploads/pdf/'. $newFileName;

        // if (file_exists($file_path)) {
        //     force_download($file_path, NULL);
        // } else {
        //     show_error('File not found.');
        // }

            // Ubah nama file
            // if ($newFileName) {
            //     echo "Nama file berhasil diubah.";
            //     // Lokasi file yang ingin diunduh
                

            //     // Pastikan file yang akan diunduh ada
            //     if (file_exists($filePath)) {
                  
            //       // // Nama file yang ingin digunakan ketika diunduh
            //       // $newFileName = $username.'.'.$extension;
            //       // // var_dump($newFileName);die();

            //       // // Atur header untuk membuat browser mengenali file sebagai attachment yang bisa diunduh
            //       // header("Content-Type: application/octet-stream");
            //       // header("Content-Disposition: attachment; filename=" . $newFileName);
            //       // header("Content-Length: " . filesize($filePath));

            //       // // Buka file untuk dibaca dan kirimkan ke output
            //       // readfile($filePath);

            //       // // Berhenti setelah pengiriman file selesai
            //       // exit;
            //                   // Atur header untuk tipe konten
            //         header('Content-type: application/pdf');
            //         header('Content-Disposition: inline; filename="' . $filename . '"');
            //         header('Content-Transfer-Encoding: binary');
            //         header('Content-Length: ' . filesize($filePath));
            //         header('Accept-Ranges: bytes');

            //         // Buka file untuk dibaca dan kirimkan ke output
            //         readfile($filePath);
            //     } else {
            //         // Jika file tidak ditemukan, tampilkan pesan kesalahan
            //         echo "File tidak ditemukan.";die();
            //     }
            // } else {
            //     echo "Gagal mengubah nama file.";
            //         die();
            // }

    }

  public function edit_nib($id) {
    $iduser         = $this->session->userdata('id_auth');
    $data['pakai']  = $this->m_nib->edit_nib($id);
    $data['pegawai']  = $this->m_nib->get_pegawai();
    $data['step']   = "update"; 
    $data['iduser']   = $iduser;
    $data['id']   = $id;
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
      // if($this->All){
      $this->template->build('edit_nib_new', $this->session_info);
      // }else{
      // $this->template->build('edit_nib', $this->session_info);
      // }
  }

  public function edit_nib_tidak_langsung($id) {
    $iduser         = $this->session->userdata('id_auth');
    $data['pakai']  = $this->m_nib->edit_nib($id);
    $data['pegawai']  = $this->m_nib->get_pegawai();
    $data['step']   = "update_nib_tidak_langsung";
    $data['iduser']   = $iduser;
    $data['id']   = $id;
    // var_dump($data['pegawai']  = $this->m_nib->get_pegawai());die();
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
      // if($this->All){
      $this->template->build('edit_nib_new_tidak_langsung', $this->session_info);
      // }else{
      // $this->template->build('edit_nib_new_tidak_langsung', $this->session_info);
      // }
  }
  
  public function edit_loket(){
    $id 	= $this->input->post('id');
    $loket 	= $this->input->post('loket');
    // var_dump($loket);die();
    $simpan = $this->m_nib->update_loket($id, $loket);
    if($simpan){
              $this->session->set_flashdata('sukses', "Berhasil Masuk");
              redirect('/pengembangan/nib');
    }else{
              $this->session->set_flashdata('error', "Gagal Masuk");
              redirect('/pengembangan/nib');

    }
  }

  public function update(){
    $this->load->library('form_validation');
    $id 	= $this->input->post('id');
    $nib_number 	= $this->input->post('nib_number');
    $kbli_number 	= $this->input->post('kbli_number');
    if($kbli_number == NULL || $kbli_number == ''){

    $kbli_number 	= $this->input->post('kbli');
    }
    $nik 	= $this->input->post('nik');
    $layanan 	= $this->input->post('layanan');
    $phone_number 	= $this->input->post('phone_number');
    $email 	= $this->input->post('email');
    $name_ktp 	= $this->input->post('name_ktp');
    $birthdate 	= $this->input->post('birthdate');
    $address_ktp 	= $this->input->post('alamat_ktp');
    $district_ktp 	= $this->input->post('kecamatan_ktp');
    $subdistrict_ktp 	= $this->input->post('kelurahan_ktp');
    $business_type 	= $this->input->post('jenis_usaha');
    $business_name 	= $this->input->post('nama_usaha');
    $start_date 	= $this->input->post('start_date');
    $accompanying_officer 	= $this->input->post('accompanying_officer');
    $accompanying_officer 	= $this->input->post('accompanying_officer');
    $location 	= $this->input->post('lokasi');
    $event_name 	= $this->input->post('event_name');
    $event_location 	= $this->input->post('event_location');
    $pdf_nib = $this->input->post('pdf_nib');
    $petugas_kbli = $this->input->post('petugas_kbli');
    $petugas_nib = $this->input->post('petugas_nib');
    $pdf_nib_hidden = $this->input->post('pdf_nib_hidden');
    

    $land_area 	= $this->input->post('luas_lahan_usaha');
    $business_capital 	= $this->input->post('modal_usaha');
    $employees_number 	= $this->input->post('jumlah_tenaga_kerja');
    $business_address 	= $this->input->post('alamat_tempat_usaha');
    $district_business 	= $this->input->post('kecamatan_tempat_usaha');
    $subdistrict_business 	= $this->input->post('kelurahan_tempat_usaha');
    $employees_number = $this->input->post('jumlah_tenaga_kerja');
    $annual_income 	= $this->input->post('pendapatan_per_tahun');

    // $subdistrict_business 	= $this->input->post('kelurahan_tempat_usaha');
    // $kode_pos_usaha 	= $this->input->post('kode_pos_tempat_usaha');
    $tahun_mulai 	= $this->input->post('tahun_bulan_memulai_usaha');
    $kapasitas_produksi 	= $this->input->post('kapasitas_produksi');

    $lama_usaha 	= $this->input->post('lama_usaha');
    $kegiatan 	= $this->input->post('kegiatan');
    // }
    $root_local = $_SERVER['SCRIPT_FILENAME'];
    $root_fo = str_replace("backoffice/index.php", "", $root_local);
    $root_backoffice = str_replace("index.php", "", $root_local);

    // echo $root_fo;
    $uploadDirectory = $root_fo . "/nib/uploads/ktp/";
    $targetFile = $uploadDirectory . basename($_FILES["file"]["name"]);

    // Directory where you want to store uploaded files
    $targetDirectory = $uploadDirectory;

    // Check if file has been uploaded
    if(isset($_FILES["file"])) {
        // Generate a unique ID for the filename
        $uniqueID = uniqid(); // Generate a unique ID
        $fileExtension = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION); // Get the file extension
        
        $file_hidden = $this->input->post('file_hidden');
        if($_FILES["file"]["name"] != NULL || $_FILES["file"]["name"] != ''){
        $newFileName = $file_hidden; // Construct the new filename
        }else{
          $newFileName = $file_hidden;
        }

      if(file_exists($uploadDirectory)){
          if($_FILES["file"]["name"] != NULL || $_FILES["file"]["name"] != ''){
              $jenisFile = strtolower(pathinfo($newFileName, PATHINFO_EXTENSION));
              if ($jenisFile != 'jpg' && $jenisFile != 'jpeg' && $jenisFile != 'png') {
                  echo "Maaf, hanya file JPG, JPEG, atau PNG yang diizinkan. 1";
                  $this->session->set_flashdata('error', "Maaf, hanya file JPG, JPEG, atau PNG yang diizinkan. 1");
                  redirect('/pengembangan/nib/edit_nib/'.$id);
                  exit();
              }
              if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetDirectory . $newFileName)) {
                  echo "The file ". basename($_FILES["file"]["name"]). " has been uploaded and renamed to $newFileName.";
              } else {
              // echo "Sorry, there was an error uploading your file.";die();
                $this->session->set_flashdata('error', "Sorry, there was an error uploading your file. Image");
                redirect('/pengembangan/nib/edit_nib/'.$id);
              }
          }
      }else{
          $jenisFile = strtolower(pathinfo($newFileName, PATHINFO_EXTENSION));
          if ($jenisFile != 'jpg' && $jenisFile != 'jpeg' && $jenisFile != 'png') {
              echo "Maaf, hanya file JPG, JPEG, atau PNG yang diizinkan. 2";
              $this->session->set_flashdata('error', "Maaf, hanya file JPG, JPEG, atau PNG yang diizinkan. 2");
              redirect('/pengembangan/nib/edit_nib/'.$id);
              exit();
          }
          if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetDirectory . $newFileName)) {
              echo "The file ". basename($_FILES["file"]["name"]). " has been uploaded and renamed to $newFileName.";
          } else {
              // echo "Sorry, there was an error uploading your file.";die();
              $this->session->set_flashdata('error', "Sorry, there was an error uploading your file. Image");
              redirect('/pengembangan/nib/edit_nib/'.$id);
          }
      }
    }

    $uploadDirectorypdf = $root_fo . "/nib/uploads/pdf/";
    $targetFilepdf = $uploadDirectorypdf . basename($_FILES["file"]["name"]);

    // Directory where you want to store uploaded files
    $targetDirectorypdf = $uploadDirectorypdf;


    // Check if file has been uploaded
    if(isset($_FILES["pdf_nib"])) {
        // Generate a unique ID for the filename
        $uniqueIDpdf = uniqid(); // Generate a unique ID
        $fileExtensionpdf = pathinfo($_FILES["pdf_nib"]["name"], PATHINFO_EXTENSION); // Get the file extension
        $newFileNamepdf = $uniqueIDpdf . "." . $fileExtensionpdf; // Construct the new filename
    if($pdf_nib_hidden == '' || $pdf_nib_hidden == NULL){
      $newFileNamepdf = $newFileNamepdf;
    }else{
      $newFileNamepdf = $pdf_nib_hidden;
    }

    $jenisFilepdf = strtolower(pathinfo($newFileNamepdf, PATHINFO_EXTENSION));
    if ($jenisFilepdf != 'pdf') {
        echo "Maaf, hanya file pdf, pdf, atau pdf yang diizinkan.";
        $this->session->set_flashdata('error', "Maaf, hanya file pdf, pdf, atau pdf yang diizinkan.");
        redirect('/pengembangan/nib/edit_nib/'.$id);
        exit();
    }
        // Attempt to move the uploaded file to the target directory with the new filename
        
    if($pdf_nib_hidden == '' || $pdf_nib_hidden == NULL){
        if(move_uploaded_file($_FILES["pdf_nib"]["tmp_name"], $targetDirectorypdf . $newFileNamepdf)) {
            echo "The file ". basename($_FILES["pdf_nib"]["name"]). " has been uploaded and renamed to $newFileNamepdf.";
        } else {
            // echo "Sorry, there was an error uploading your file.";die();
            $this->session->set_flashdata('error', "Sorry, there was an error uploading your file. PDF");
            redirect('/pengembangan/nib/edit_nib/'.$id);
        }
      }
    }

    // $kapasitas_produksi 	= $this->input->post('kapasitas_produksi');
    // $lama_usaha 	= $this->input->post('lama_usaha');
    // $kegiatan 	= $this->input->post('kegiatan');
    $simpan = $this->m_nib->save_data_update($id, 
    $nib_number, 
    $kbli_number, 
    $nik, 
    $phone_number, 
    $email, 
    $name_ktp, 
    $birthdate, 
    $address_ktp, 
    $district_ktp, $subdistrict_ktp, $business_type, 
    $business_name, $business_address, $district_business, $start_date, 
    $business_capital, $annual_income, $accompanying_officer, $location, 
    $event_name, $event_location, $land_area, $employees_number, $newFileName, 
    $newFileNamepdf, $petugas_kbli, $petugas_nib,$kapasitas_produksi,$lama_usaha,$kegiatan, $tahun_mulai, $layanan);
        if(!empty($simpan)) {
            $this->session->set_flashdata('success', "Data Berhasil Tersimpan, Terima Kasih.");
            redirect('/pengembangan/nib/');
          }else{
            $this->session->set_flashdata('error', "Terjadi kesalahan, server tidak merespon, silahkan mengulangi pengisian data.");
            redirect('/pengembangan/nib/');
          }
  }
  public function update_nib_tidak_langsung(){
    $this->load->library('form_validation');
    $id 	= $this->input->post('id');
    $nib_number 	= $this->input->post('nib_number');
    $kbli_number 	= $this->input->post('kbli_number');

    if($kbli_number == NULL || $kbli_number == ''){

    $kbli_number 	= $this->input->post('kbli');
    }

    $nik 	= $this->input->post('nik');
    $phone_number 	= $this->input->post('phone_number');
    $layanan 	= $this->input->post('layanan');
    $email 	= $this->input->post('email');
    $name_ktp 	= $this->input->post('name_ktp');
    $birthdate 	= $this->input->post('birthdate');
    $address_ktp 	= $this->input->post('address_ktp');
    $district_ktp 	= $this->input->post('district_ktp');
    $subdistrict_ktp 	= $this->input->post('subdistrict_ktp');
    $business_type 	= $this->input->post('business_type');
    $business_name 	= $this->input->post('business_name');
    // $business_address 	= $this->input->post('business_address');
    $district_business 	= $this->input->post('district_business');
    $start_date 	= $this->input->post('start_date');
    // $business_capital 	= $this->input->post('business_capital');
    $annual_income 	= $this->input->post('annual_income');
    $accompanying_officer 	= $this->input->post('accompanying_officer');
    $accompanying_officer 	= $this->input->post('accompanying_officer');
    $location 	= $this->input->post('lokasi');
    $event_name 	= $this->input->post('event_name');
    $event_location 	= $this->input->post('event_location');
    // $land_area = $this->input->post('land_area');
    // $employees_number = $this->input->post('jumlah_tenaga_kerja');
    $pdf_nib = $this->input->post('pdf_nib');
    $petugas_kbli = $this->input->post('petugas_kbli');
    $petugas_nib = $this->input->post('petugas_nib');
    $pdf_nib_hidden = $this->input->post('pdf_nib_hidden');
    

    $land_area 	= $this->input->post('luas_lahan');
    $business_capital 	= $this->input->post('modal_usaha');
    $employees_number 	= $this->input->post('jumlah_tenaga_kerja');
    $business_address 	= $this->input->post('alamat_usaha');
    $kapasitas_produksi 	= $this->input->post('kapasitas_produksi');
    $lama_usaha 	= $this->input->post('lama_usaha');
    $kegiatan 	= $this->input->post('kegiatan');

    // }

    $uploadDirectory = $_SERVER['DOCUMENT_ROOT'] . "/nib/uploads/ktp/";
    $targetFile = $uploadDirectory . basename($_FILES["file"]["name"]);

    // Directory where you want to store uploaded files
    $targetDirectory = $uploadDirectory;


    // Check if file has been uploaded
    if(isset($_FILES["file"])) {
        // Generate a unique ID for the filename
        $uniqueID = uniqid(); // Generate a unique ID
        $fileExtension = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION); // Get the file extension
        
        $file_hidden = $this->input->post('file_hidden');
        if($_FILES["file"]["name"] != NULL || $_FILES["file"]["name"] != ''){
        $newFileName = $file_hidden; // Construct the new filename
        }else{
          $newFileName = $file_hidden;
        }
        // var_dump($newFileName);die();

      if(file_exists($uploadDirectory)){
          if($_FILES["file"]["name"] != NULL || $_FILES["file"]["name"] != ''){
              $jenisFile = strtolower(pathinfo($newFileName, PATHINFO_EXTENSION));
              if ($jenisFile != 'jpg' && $jenisFile != 'jpeg' && $jenisFile != 'png') {
                  echo "Maaf, hanya file JPG, JPEG, atau PNG yang diizinkan.";
                  $this->session->set_flashdata('error', "Maaf, hanya file JPG, JPEG, atau PNG yang diizinkan.");
                  redirect('/pengembangan/nib/edit_nib_tidak_langsung/'.$id);
                  exit();
              }
              if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetDirectory . $newFileName)) {
                  echo "The file ". basename($_FILES["file"]["name"]). " has been uploaded and renamed to $newFileName.";
              } else {
              // echo "Sorry, there was an error uploading your file.";die();
                $this->session->set_flashdata('error', "Sorry, there was an error uploading your file. Image");
                redirect('/pengembangan/nib/edit_nib_tidak_langsung/'.$id);
              }
          }
      }else{
          $jenisFile = strtolower(pathinfo($newFileName, PATHINFO_EXTENSION));
          if ($jenisFile != 'jpg' && $jenisFile != 'jpeg' && $jenisFile != 'png') {
              echo "Maaf, hanya file JPG, JPEG, atau PNG yang diizinkan.";
              $this->session->set_flashdata('error', "Maaf, hanya file JPG, JPEG, atau PNG yang diizinkan.");
              redirect('/pengembangan/nib/edit_nib_tidak_langsung/'.$id);
              exit();
          }
          if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetDirectory . $newFileName)) {
              echo "The file ". basename($_FILES["file"]["name"]). " has been uploaded and renamed to $newFileName.";
          } else {
              // echo "Sorry, there was an error uploading your file.";die();
              $this->session->set_flashdata('error', "Sorry, there was an error uploading your file. Image");
              redirect('/pengembangan/nib/edit_nib_tidak_langsung/'.$id);
          }
      }
    }

    $uploadDirectorypdf = $_SERVER['DOCUMENT_ROOT'] . "/nib/uploads/pdf/";
    $targetFilepdf = $uploadDirectorypdf . basename($_FILES["file"]["name"]);

    // Directory where you want to store uploaded files
    $targetDirectorypdf = $uploadDirectorypdf;


    // Check if file has been uploaded
    if(isset($_FILES["pdf_nib"])) {
        // Generate a unique ID for the filename
        $uniqueIDpdf = uniqid(); // Generate a unique ID
        $fileExtensionpdf = pathinfo($_FILES["pdf_nib"]["name"], PATHINFO_EXTENSION); // Get the file extension
        $newFileNamepdf = $uniqueIDpdf . "." . $fileExtensionpdf; // Construct the new filename
    if($pdf_nib_hidden == '' || $pdf_nib_hidden == NULL){
      $newFileNamepdf = $newFileNamepdf;
    }else{
      $newFileNamepdf = $pdf_nib_hidden;
    }

    $jenisFilepdf = strtolower(pathinfo($newFileNamepdf, PATHINFO_EXTENSION));
    if ($jenisFilepdf != 'pdf') {
        echo "Maaf, hanya file pdf, pdf, atau pdf yang diizinkan.";
        $this->session->set_flashdata('error', "Maaf, hanya file pdf, pdf, atau pdf yang diizinkan.");
        redirect('/pengembangan/nib/edit_nib_tidak_langsung/'.$id);
        exit();
    }
        // Attempt to move the uploaded file to the target directory with the new filename
        
    if($pdf_nib_hidden == '' || $pdf_nib_hidden == NULL){
        if(move_uploaded_file($_FILES["pdf_nib"]["tmp_name"], $targetDirectorypdf . $newFileNamepdf)) {
            echo "The file ". basename($_FILES["pdf_nib"]["name"]). " has been uploaded and renamed to $newFileNamepdf.";
        } else {
            // echo "Sorry, there was an error uploading your file.";die();
            $this->session->set_flashdata('error', "Sorry, there was an error uploading your file. PDF");
            redirect('/pengembangan/nib/edit_nib_tidak_langsung/'.$id);
        }
      }
    }
    $district_business 	= $this->input->post('kecamatan_tempat_usaha');
    $subdistrict_business 	= $this->input->post('kelurahan_tempat_usaha');
    $postal_code_business 	= $this->input->post('kode_pos_tempat_usaha');
    $business_type 	= $this->input->post('j_usaha');

    $birthdate 	= $this->input->post('tanggal_lahir');
    $address_ktp 	= $this->input->post('alamat');
    $district_ktp 	= $this->input->post('kecamatan');
    $subdistrict_ktp 	= $this->input->post('kelurahan');

    // $kapasitas_produksi 	= $this->input->post('kapasitas_produksi');
    // $lama_usaha 	= $this->input->post('lama_usaha');
    // $kegiatan 	= $this->input->post('kegiatan');

    $user_nib_pemohon 	= $this->input->post('user_nib_pemohon');
    $password_nib_pemohon 	= $this->input->post('password_nib_pemohon');
    $simpan = $this->m_nib->save_data_update($id, 
    $nib_number, 
    $kbli_number, 
    $nik, 
    $phone_number, 
    $email, 
    $name_ktp, 
    $birthdate, 
    $address_ktp, 
    $district_ktp, $subdistrict_ktp, $business_type, 
    $business_name, $business_address, $district_business, $start_date, 
    $business_capital, $annual_income, $accompanying_officer, $location, 
    $event_name, $event_location, $land_area, $employees_number, $newFileName, 
    $newFileNamepdf, $petugas_kbli, $petugas_nib,$kapasitas_produksi,$lama_usaha,$kegiatan,
    $user_nib_pemohon,$password_nib_pemohon, $layanan,$subdistrict_business,$postal_code_business);
        if(!empty($simpan)) {
            $this->session->set_flashdata('success', "Data Berhasil Tersimpan, Terima Kasih.");
            redirect('/pengembangan/nib/nib_tidak_langsung ');
            
          }else{
            $this->session->set_flashdata('error', "Terjadi kesalahan, server tidak merespon, silahkan mengulangi pengisian data.");
            redirect('/pengembangan/nib/nib_tidak_langsung ');
          }
  }
  
  public function ubah_status_nib() {
    $status = $this->m_nib->nib_langsung();
    if($status == 1){
    $ubah = $this->m_nib->ubah_switch_off();
    }else{
    $ubah = $this->m_nib->ubah_switch_on();
    }

    if ($ubah) {
      $this->session->set_flashdata('sukses', "Berhasil ubah Data.");
      redirect('/pengembangan/nib/');
    } else {
      $this->session->set_flashdata('gagal', "Gagal ubah Data.");
      redirect('/pengembangan/nib/');
    }
  }

  public function hapus_nib($id) {
    $hapus = $this->m_nib->hapus_nib($id);

    if ($hapus) {
      $this->session->set_flashdata('sukses', "Berhasil Hapus Data.");
      redirect('/pengembangan/nib/');
    } else {
      $this->session->set_flashdata('gagal', "Gagal Hapus Data.");
      redirect('/pengembangan/nib/');
    }
  }

  public function mute_mic($id) {
    $hapus = $this->m_nib->mute_hapus_mic($id);

    if ($hapus) {
      $this->session->set_flashdata('sukses', "Berhasil Hapus Data.");
      redirect('/pengembangan/nib/');
    } else {
      $this->session->set_flashdata('gagal', "Gagal Hapus Data.");
      redirect('/pengembangan/nib/');
    }
  }

//   public function cetak_excel($tgla = 0, $tglb = 0){
//     // Mendapatkan data NIB dari model
//     // $data_nib = $this->m_nib->get_data_nib($tgla, $tglb);
//   	$data_nib = $this->m_pengembangan->get_data_nib($tgla, $tglb);
    
//     // Header untuk file Excel
//     header("Content-Type: application/vnd.ms-excel; charset=utf-8");
//     header("Content-Disposition: attachment; filename=REKAP_E-REPORT_NIB_DPMPTSP_JABAR.xls");
//     header("Expires: 0");
//     header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
//     header("Cache-Control: private",false);

//     // Output judul dan periode
//     echo "<table width='100%' border='0'>";
//     echo "<tr><td colspan='18' style='font-size:16px;'>DAFTAR TAMU / E-REPORT DPMPTSP JAWA BARAT</td></tr>";
//     echo "<tr><td colspan='18'>PERIODE : ".$this->lib_date->mysql_to_human($tgla)." - ".$this->lib_date->mysql_to_human($tglb)."</td></tr>";
//     echo "</table>";

//     // Judul kolom
//     $jdl= "
//         <tr>
//             <td>NO.</td>
//             <td>KBLI<br>No. WhatsApp<br>Tanggal Input</td>
//             <td>Nama<br>NIK<br>Email</td>
//             <td>Petugas KBLI<br>Petugas NIB<br>Lokasi Event</td>
//             <td>Petugas Pengubah Data<br>Tanggal<br>Layanan</td>
//             <td>No Antri</td>
//             <td>Foto KTP</td>
//         </tr>";
//     echo "<table width='100%' border='1' style='border-collapse: collapse; font-size: 10px;'>"; 
//     echo $jdl; 

//     // Isi tabel
//     $i = 1;

//     foreach ($data_nib as $row){
//         echo "<tr>
//                 <td>".$i."</td>
//                 <td>".$row->kbli."<br>".$row->no_wa."<br>".date("d F Y", strtotime($row->tanggal))."</td>
//                 <td>".$row->nama."<br>".$row->nik."<br>".$row->email."</td>
//                 <td>".$this->m_nib->get_n_pegawai($row->petugas_kbli)."<br>".$this->m_nib->get_n_pegawai($row->petugas_nib)."<br>".$row->lokasi_event."</td>
//                 <td>".$this->m_pengembangan->get_n_user($row->user)."<br>".date("d F Y H:i", strtotime($row->tanggal))."<br>".$row->layanan."</td>
//                 <td>".$row->no_antri."</td>
//                 <td>";
//         // Output foto KTP jika ada
//         $foto_path = $_SERVER['DOCUMENT_ROOT'] . "/nib/uploads/ktp/" . $row->file;
//         var_dump($foto_path);die();
//         if(file_exists($foto_path)){
//             echo "<img src=\"https://dpmptsp.jabarprov.go.id/nib/uploads/ktp/" . $row->file ."\" width=\"100px\">";
//         } else {
//             echo "Foto KTP tidak ditemukan";
//         }
//         echo "</td>
//             </tr>";
//         $i++;
//     }

//     echo "</table>";
// }
  public function cetak_excel($tgla = 0, $tglb = 0){
    // Mendapatkan data NIB dari model
    $data_nib = $this->m_pengembangan->get_data_nib($tgla, $tglb);
    
    // Header untuk file Excel
    header("Content-Type: application/vnd.ms-excel; charset=utf-8");
    header("Content-Disposition: attachment; filename=REKAP_E-REPORT_NIB_DPMPTSP_JABAR.xls");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: private",false);

    // Output judul dan periode
    echo "<table width='100%' border='0' font-size:16px;'>";
    echo "<tr><td colspan='18' style='font-size:16px;'>DAFTAR TAMU / E-REPORT DPMPTSP JAWA BARAT</td></tr>";
    echo "<tr><td colspan='18'>PERIODE : ".$this->lib_date->mysql_to_human($tgla)." - ".$this->lib_date->mysql_to_human($tglb)."</td></tr>";
    echo "</table>";

    // Judul kolom
    $jdl= "
    <tr>
        <td>NO.</td>
        <td>KBLI</td>
        <td>No. WhatsApp</td>
        <td>Tanggal Input</td>
        <td>Nama</td>
        <td>NIK</td>
        <td>Email</td>
        <td>Petugas KBLI</td>
        <td>Petugas NIB</td>
        <td>Lokasi Event</td>
        <td>Petugas Pengubah Data</td>
        <td>Tanggal</td>
        <td>Layanan</td>
        <td>No Antri</td>
    </tr>";
    echo "<table border='1' style='border-collapse: collapse; font-size: 15px;'>"; 
    echo $jdl; 

    // Isi tabel
    $i = 1;
    $belum = 1;
    foreach($data_nib as $row){
        if($row->status_panggil == '0') {
            $b = '<span style="color: Red">';
            $be = '</span>';
            $belum++; 
            //$c = '<br>Revisi : '.$row->revisi;
        } elseif($row->status_panggil == '1'){
            $b = '<span style="color: Blue">';
            $be = '</span>';
            // $c = '<br>'.$row->revisi; 
        } else {
            $b = '<span>';
            $be = '</span>';
            // $c = '<br>'.$row->revisi; 
        }

        // Tambahkan baris baru untuk cetak data dalam tabel
        echo "<tr>
                <td style='text-align: center; vertical-align: middle;'>".$b.$i."</td>
                <td style='text-align: center; vertical-align: middle;'>".$b.$row->kbli."</td>
                <td style='text-align: center;vertical-align: middle;'>$b=\"$row->no_wa\" $be</td>
                <td style='text-align: center;vertical-align: middle;'>".$b.date("d F Y", strtotime($row->tanggal))."</td>
                <td style='text-align: center;vertical-align: middle;'>".$b.$row->nama."</td>
                <td style='text-align: center;vertical-align: middle;'>$b=\"$row->nik\" $be</td>
                <td style='text-align: center;vertical-align: middle;'>".$b.$row->email."</td>
                <td style='text-align: center;vertical-align: middle;'>".$b.$this->m_nib->get_n_pegawai($row->petugas_kbli)."</td>
                <td style='text-align: center;vertical-align: middle;'>".$b.$this->m_nib->get_n_pegawai($row->petugas_nib)."</td>
                <td style='text-align: center;vertical-align: middle;'>".$b.$row->lokasi_event."</td>
                <td style='text-align: center;vertical-align: middle;'>".$b.$this->m_pengembangan->get_n_user($row->user)."</td>
                <td style='text-align: center;vertical-align: middle;'>".$b.date("d F Y H:i", strtotime($row->tanggal))."</td>
                <td style='text-align: center;vertical-align: middle;'>".$b.$row->layanan."</td>
                <td style='text-align: center;vertical-align: middle;'>".$b.$row->no_antri."</td>
            </tr>";

        $i++;
    }

  }

  public function cetak_excel_nib_tidak_langsung($tgla = 0, $tglb = 0){
    // Mendapatkan data NIB dari model
    $data_nib = $this->m_pengembangan->get_data_nib_tidak_langsung($tgla, $tglb);
    
    // Header untuk file Excel
    header("Content-Type: application/vnd.ms-excel; charset=utf-8");
    header("Content-Disposition: attachment; filename=REKAP_E-REPORT_NIB_TIDAK_LANGSUNG_ATAU_ONLINE_DPMPTSP_JABAR.xls");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: private",false);

    // Output judul dan periode
    echo "<table width='100%' border='0' font-size:16px;'>";
    echo "<tr><td colspan='18' style='font-size:16px;'>DATA REKAP PELAYANAN NIB TIDAK LANGSUNG / ONLINE DPMPTSP JAWA BARAT</td></tr>";
    echo "<tr><td colspan='18'>PERIODE : ".$this->lib_date->mysql_to_human($tgla)." - ".$this->lib_date->mysql_to_human($tglb)."</td></tr>";
    echo "</table>";

    // Judul kolom
    $jdl= "
    <tr>
        <td>NO.</td>
        <td>KBLI</td>
        <td>No. WhatsApp</td>
        <td>Tanggal Input</td>
        <td>Nama</td>
        <td>NIK</td>
        <td>Email</td>
        <td>Petugas KBLI</td>
        <td>Agen NIB</td>
        <td>Lokasi Event</td>
        <td>Petugas Pengubah Data</td>
        <td>Tanggal</td>
        <td>Layanan</td>
        <td>No Antri</td>
    </tr>";
    echo "<table border='1' style='border-collapse: collapse; font-size: 15px;'>"; 
    echo $jdl; 

    // Isi tabel
    $i = 1;
    $belum = 1;
    foreach($data_nib as $row){
        if($row->status_panggil == '0') {
            $b = '<span style="color: Red">';
            $be = '</span>';
            $belum++; 
            //$c = '<br>Revisi : '.$row->revisi;
        } elseif($row->status_panggil == '1'){
            $b = '<span style="color: Blue">';
            $be = '</span>';
            // $c = '<br>'.$row->revisi; 
        } else {
            $b = '<span>';
            $be = '</span>';
            // $c = '<br>'.$row->revisi; 
        }

        // Tambahkan baris baru untuk cetak data dalam tabel
        echo "<tr>
                <td style='text-align: center; vertical-align: middle;'>".$b.$i."</td>
                <td style='text-align: center; vertical-align: middle;'>".$b.$row->kbli."</td>
                <td style='text-align: center;vertical-align: middle;'>$b=\"$row->no_wa\" $be</td>
                <td style='text-align: center;vertical-align: middle;'>".$b.date("d F Y", strtotime($row->tanggal))."</td>
                <td style='text-align: center;vertical-align: middle;'>".$b.$row->nama."</td>
                <td style='text-align: center;vertical-align: middle;'>$b=\"$row->nik\" $be</td>
                <td style='text-align: center;vertical-align: middle;'>".$b.$row->email."</td>
                <td style='text-align: center;vertical-align: middle;'>".$b.$this->m_nib->get_n_pegawai($row->petugas_kbli)."</td>
                <td style='text-align: center;vertical-align: middle;'>".$b.$row->Agen_Nib."</td>
                <td style='text-align: center;vertical-align: middle;'>".$b.$row->lokasi_event."</td>
                <td style='text-align: center;vertical-align: middle;'>".$b.$this->m_pengembangan->get_n_user($row->user)."</td>
                <td style='text-align: center;vertical-align: middle;'>".$b.date("d F Y H:i", strtotime($row->tanggal))."</td>
                <td style='text-align: center;vertical-align: middle;'>".$b.$row->layanan."</td>
                <td style='text-align: center;vertical-align: middle;'>".$b.$row->no_antri."</td>
            </tr>";

        $i++;
    }

  }
  public function kirim($id) {
    $iduser         = $this->session->userdata('id_auth');
    $data['pakai']  = $this->m_nib->edit_nib($id);
    $data['pegawai']  = $this->m_nib->get_pegawai();
    $data['step']   = "update_nib_tidak_langsung";
    $data['iduser']   = $iduser;
    $data['id']   = $id;

    $nomor = $data['pakai'][0]->no_wa;
    $n_pesan = "Terima kasih telah melakukan registrasi form pendaftaran NIB (Nomor Induk Berusaha) di Program SAkiceup Bos Dinas PMPTSP Prov. Jabar\n
    No Antrian Anda : ".$data['pakai'][0]->no_antri_tidak_langsung."  
    Silahkan menunggu panggilan sesuai nomor antrian anda\n
    Mohon menunggu dengan tertib\n
    Terima kasih \n
    Tanggal Tanggal ".$data['pakai'][0]->tanggal_baru;

    $kirim = $this->m_nib->postWaSms($nomor, $n_pesan, 'NIB');
    // var_dump($kirim);die();

    $this->session->set_flashdata('success', "Data Berhasil Tersimpan, Terima Kasih.");
    redirect('/pengembangan/nib/nib_tidak_langsung ');
  }
}