<?php
/*
 * Created By : Arif Ahmadi / 01-02-2023
 */

class Permintaanbarang extends WRC_AdminCont
{
    public function __construct()
    {
        parent::__construct();
        // $this->load->model("m_permintaan");
        $this->load->model("m_barang");
        $this->load->library('upload');
        $base_url = base_url();
        $this->penglola_barang = FALSE;
        $this->All = FALSE;
        $list_auths = $this->session_info['app_list_auth'];
        foreach ($list_auths as $list_auth) {
            if ($list_auth->id_role === '35') {
                $this->penglola_barang = TRUE;
            }
            if ($list_auth->id_role === '18') {
                $this->All = TRUE;
            }
            if ($list_auth->id_role === '45') {
                $this->penglola_barang = TRUE;
            }
            if ($list_auth->id_role === '44') {
                $this->penglola_barang = TRUE;
            }
            if ($list_auth->id_role === '47') {
                $this->penglola_barang = TRUE;
            }
        }

        if (!$this->penglola_barang) {
            redirect('dashboard');
        }
    }

    public function barang_index()
    {
        $barang = $this->m_barang->get_data();
        $logbarang = $this->m_barang->get_data_master();

        $data['logbarang'] = $logbarang;
        $data['barang'] = $barang;
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
              }";

        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "Sistem Informasi pengelOLAan BArang PERsediaan (SI OLA BAPER)";
        $this->template->build('barang_index', $this->session_info);
    }

    public function barang(){

        $list_auths = $this->session_info['app_list_auth'];
        $this->penglola_barang = FALSE;
        foreach ($list_auths as $list_auth) {
            if ($list_auth->id_role === '45') {
                $this->penglola_barang = TRUE;
            }
            if ($list_auth->id_role === '44') {
                $this->penglola_barang = TRUE;
            }
        }
        if (!$this->penglola_barang) {
            redirect('dashboard');
        }
        $now = $this->lib_date->get_date_now();
        $tgla = (!empty($this->input->post('tgla')) ? $this->input->post('tgla') : $this->lib_date->set_date($now, -730));
        $tglb = (!empty($this->input->post('tglb')) ? $this->input->post('tglb') : $this->lib_date->set_date($now, 0));
        // $list_auths = $this->session_info['app_list_auth'];
        $barang = $this->m_barang->get_data();
        $logbarang = $this->m_barang->get_data_master($tgla, $tglb);
        $data['logbarang'] = $logbarang;
        $data['barang'] = $barang;
        $data['ss'] = '0';
        $data['langkah'] = '1';
        $data['penglola_barang'] = $this->penglola_barang;
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
              }";

        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "Sistem Informasi pengelOLAan BArang PERsediaan (SI OLA BAPER) - List Persediaan";
        $this->template->build('barang_list', $this->session_info);
    }

    public function addbarang()
    {
        $list_auths = $this->session_info['app_list_auth'];
        $this->penglola_barang = FALSE;
        foreach ($list_auths as $list_auth) {
            if ($list_auth->id_role === '45') {
                $this->penglola_barang = TRUE;
            }
            if ($list_auth->id_role === '44') {
                $this->penglola_barang = TRUE;
            }
        }
        if (!$this->penglola_barang) {
            redirect('dashboard');
        }
        $id_user = $this->session->userdata('id_auth');
        $data['user'] = $this->m_barang->get_pegawai_user($id_user);
        $data['barang'] = array();
        $data['step'] = "simpan";

        $js = "
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
        $this->session_info['page_name'] = "Sistem Informasi pengelOLAan BArang PERsediaan (SI OLA BAPER) - Tambah Barang";
        $this->template->build('barang_add', $this->session_info);
        // $this->template->build('data_upload', $this->session_info);
    }

    public function simpan()
    {
        
        $routees        = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
        $root           = rtrim($_SERVER['DOCUMENT_ROOT'], '/'); // buang trailing slash
        $routees        = ltrim($routees, '/');              // buang leading slash
        $routees_portal = str_replace('backoffice/index.php', '', $_SERVER['SCRIPT_NAME']); 
        $id_user = $this->input->post('id_user');
        $nama_user = $this->input->post('nama');
        $barang = $this->input->post('nama_barang');
        if($barang == '-'){
            $this->session->set_flashdata('gagal', "Nama Barang BerhasHarusil DI input");
            redirect('/permintaanbarang/addbarang');
        }
        $jumlah = $this->input->post('jumlah');
        $satuan = $this->input->post('satuan');
        $kategori = $this->input->post('kategori');
        $merk = $this->input->post('merk');
        $simpan = $this->input->post('rak');
        $harga = $this->input->post('harga');
        
        $rupiah   = $harga;
        $harga    = preg_replace('/[^\d]/', '', $rupiah);

        $date = $this->input->post('date');
        $foto = $this->input->post('foto1');
        $nama = $this->m_barang->get_validation_double($barang, $merk, $satuan);
        if(!empty($nama)){
                $this->session->set_flashdata('gagal', $barang." Dengan Merk ".$merk." Sudah Ada di List Persediaan");
                redirect('/permintaanbarang/barang');
        }else{
            move_uploaded_file($_FILES['foto1']['tmp_name'], $root.'/'.$routees.'/www/modules/permintaanbarang/views/barang/' . date('YmdGis') . $_FILES['foto1']['name']);
            $file = date('YmdGis').$_FILES["foto1"]["name"];
            $simpan = $this->m_barang->save_data($id_user, $barang, $jumlah, $satuan, $kategori, $harga, $date, $merk, $simpan, $file);
            $log = $this->m_barang->save_log($id_user, $barang, $jumlah, $satuan, $kategori, $harga, $date, $merk, $simpan, $nama_user);
            $this->session->set_flashdata('sukses', "Barang Berhasil DI input");
            redirect('/permintaanbarang/barang');
        }
    }

    public function save()
    {
        
        $routees        = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
        $root           = rtrim($_SERVER['DOCUMENT_ROOT'], '/'); // buang trailing slash
        $routees        = ltrim($routees, '/');              // buang leading slash
        $routees_portal = str_replace('backoffice/index.php', '', $_SERVER['SCRIPT_NAME']); 
        $barang = $this->input->post('barang');
        $merk = $this->input->post('merk');
        $satuan = $this->input->post('satuan');
        $barang_log = $this->input->post('barang_log');
        $id = $this->input->post('id');
        $simpan = $this->input->post('rak');
        $harga = $this->input->post('harga');
        
        $rupiah   = $harga;
        $harga    = preg_replace('/[^\d]/', '', $rupiah);

        $file = $_FILES["foto1"]["name"];
        $kategori = $this->input->post('kategori');
        $barang_log_harga = $this->input->post('barang_log_harga');
        $jumlah = $this->input->post('jumlah');
        // var_dump($file);die();
        if($file == '' || $file == NULL){
        $oldfoto = $this->input->post('oldfoto');
            $this->m_barang->put_barang($barang, $merk, $satuan, $id, $simpan, $harga, $kategori, $oldfoto, $jumlah, $barang_log_harga);
            // foreach($barang_log as $log){
            //     $this->m_barang->put_barang_log($barang, $merk, $satuan, $simpan, $harga);
            // }
        }else{
            $old = trim($this->input->post('oldfoto'));
            $path = $root.'/'.$routees.'www/modules/permintaanbarang/views/barang/'.$old;
            chmod($path, 0777);
            unlink($path);
            $upload = move_uploaded_file($_FILES['foto1']['tmp_name'], $root.'/'.$routees.'www/modules/permintaanbarang/views/barang/' . date('YmdGis') . $_FILES['foto1']['name']);
            
            // var_dump($upload);die();
            $file = date('YmdGis').$_FILES["foto1"]["name"];
            $this->m_barang->put_barang($barang, $merk, $satuan, $id, $simpan, $harga, $kategori, $file, $jumlah, $barang_log_harga);
            // foreach($barang_log as $log){
            //     $this->m_barang->put_barang_log($barang, $merk, $satuan, $simpan, $harga);
            // }
        }
        $this->session->set_flashdata('sukses', "Barang Berhasil Di Edit");
        redirect('/permintaanbarang/barang');
    }

    public function pinjam($id)
    {
        $data['barang'] = $this->m_barang->get_barang_id($id);
        $id_user = $this->session->userdata('id_auth');
        $data['user'] = $this->m_barang->get_pegawai_user($id_user);
        $data['step'] = "order";

        $js = "
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
        $this->session_info['page_name'] = "Sistem Informasi pengelOLAan BArang PERsediaan (SI OLA BAPER)";
        $this->template->build('barang_pinjam', $this->session_info);
    }

    public function order()
    {
        $id_user = $this->session->userdata('id_auth');
        $id = $this->input->post('id');
        $jumlah = $this->input->post('jumlah');
        $saatini = $this->input->post('saatini');
        $hasil = $saatini - $jumlah;
        if ($jumlah > $saatini) {
            $data['salah'] = "Stok tidak cukup turunkan Jumlah barang";
            $this->load->vars($data);
            redirect('/permintaanbarang/pinjam/' . $id);
        } else {
            $simpan = $this->m_barang->save_order_pengolah($id_user, $id, $jumlah, $hasil);
            redirect('/permintaanbarang/barang');
        }
    }

    public function checkout() // utk pengelola barang
    {
        $list_auths = $this->session_info['app_list_auth'];
        $this->penglola_barang = FALSE;
        foreach ($list_auths as $list_auth) {
            if ($list_auth->id_role === '45') {
                $this->penglola_barang = TRUE;
            }
            if ($list_auth->id_role === '44') {
                $this->penglola_barang = TRUE;
            }
        }
        if (!$this->penglola_barang) {
            redirect('dashboard');
        }
        
        // $langkah = '1';
        $barang = $this->m_barang->get_checkout_pengolah();
        $permintaan = $this->m_barang->get_permintaan();
        $id_user = $this->session->userdata('id_auth');
        $pemberi = $this->m_barang->get_pegawai_user($id_user);

        $data['user'] = $this->m_barang->get_user();
        $data['pemberi'] = $pemberi;
        $data['id_user'] = $id_user;
        $data['permintaan'] = $permintaan;
        $data['barang'] = $barang;
        $data['langkah'] = '0';
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
              }";

        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "Sistem Informasi pengelOLAan BArang PERsediaan (SI OLA BAPER) - Informasi Checkout Barang";
        $this->template->build('checkout_list', $this->session_info);
    }

    public function test_notifikasi(){        // Assuming $n_hp and $n_pesan are defined elsewhere in your code
        $notificationSettings = $this->m_barang->getAllNotificationSettings_ex();
        foreach ($notificationSettings as $row) {
        $n_hp    = $this->m_barang->get_data_user_telepon($row->user_id);
        $n_pesan = "Hayu Ngabaso \n\n#Feba";
        // Assuming $this->lib_date->postWaSms() function works as intended
        $cek = $this->lib_date->postWaSms($n_hp, $n_pesan, 'Barang');
        // var_dump($cek);die();
            if(!$cek){
                $this->session->set_flashdata('gagal', "API Whatsapp tidak merespon");
            }
        }
        
        redirect('permintaanbarang/setting','refresh');
        
    }

    public function accept(){
      $barang = $this->input->post('nama_barang');
      $id_user = $this->session->userdata('id_auth');
      $pemberi = $this->input->post('pemberi');
      $user_id = $this->input->post('penerima');
      $data_barang = $this->input->post('data_barang');
      $penerima = $this->m_barang->get_pegawai_user2($user_id);
      $langkah = $this->input->post('langkah');
      $loop = $this->input->post('jumlah');
      $id_barang = $this->input->post('id_barang');
      $merk = $this->input->post('merkloop');
      $status = '1';   
      
      if ($penerima == NULL || $penerima == '-' || $penerima == '') {
        $this->session->set_flashdata('gagal', "Penerima belum di input");
        redirect('/permintaanbarang/checkout');
      }
        
      // Test Kirim SMS/WA
      $penerima_notif = $this->m_barang->get_pegawai_user_n_pegawai($penerima);
      $penerima_notif = $this->m_barang->get_data_user_n_pegawai($penerima_notif);
      $clean_string = strip_tags($barang);
      // Assuming $htmlText is supposed to contain the HTML text to be processed
      $htmlText = $barang;
      // Strip HTML tags from $htmlText
      $textWithoutTags = strip_tags($htmlText);
      // Decode HTML entities
      $textWithoutTags = html_entity_decode($textWithoutTags);
      // Split text into orders
      $orders = explode("<br>", $textWithoutTags);
      // Initialize WhatsApp message
      $whatsappMessage = "Halo! Saya ingin memesan:\n\n";
      // Iterate through each order
      foreach ($orders as $key => $order) {
        // Clean and format the order
        $order = trim($order);
        $order = str_replace(".", "", $order); // Remove dots
        $whatsappMessage .= $order . "\n";
      }
      // Add additional message
      $whatsappMessage .= "\nTerima kasih!";

      // Assuming $n_hp and $n_pesan are defined elsewhere in your code
      $notificationSettings = $this->m_barang->getAllNotificationSettings_ex();
      // foreach ($notificationSettings as $row) {
      //     $n_hp    = $this->m_barang->get_data_user_telepon($row->user_id);
      //     $n_pesan = "Pesanan Masuk : ".$whatsappMessage."\n untuk ".$penerima_notif;
      //     if($status == '1') { 
      //     // Assuming $this->lib_date->postWaSms() function works as intended
      //         $this->lib_date->postWaSms($n_hp, $n_pesan, 'Barang');
      //     }
      // }
      // EOF() Test Kirim SMS/WA

      // Test Kirim mail
	    if($status == '1'){ 
        $uuids = "coba";
        $data = @file_get_contents($url);
  	  }
  	  // EOF() Test Kirim mail
  	
      // var_dump($id_barang);die();
      if($barang == NULL) {
        $this->session->set_flashdata('gagal', "Input Barang Terlebih dahulu");
        redirect('/permintaanbarang/checkout');
      }
      if($user_id == '-'){
        $this->session->set_flashdata('gagal', "Input User Terlebih dahulu");
        redirect('/permintaanbarang/checkout');
      }else{
        $detail = $this->m_barang->get_data_jumlah();
        foreach($id_barang as $barang1){
          $namabarang = $this->m_barang->get_data_barang_nama_barang($barang1);
          $merkbarang = $this->m_barang->get_data_barang_merk_barang($barang1);
          $stokbarang = $this->m_barang->get_data_barang_stok_barang($barang1);
          $detbarang  = $this->m_barang->get_data_barang_log_barang($barang1, $id_user);
          // echo $barang1.' - '. $namabarang . ' - '.$merkbarang. ' - '.$stokbarang.' - '.$detbarang.'<br>' ;
          $brang = $merkbarang;

          $detailbarang = $this->m_barang->get_log_detail($namabarang);
          foreach($detailbarang as $row){
            // var_dump($merk);die();
            $id = $row->id;
            $jumlahpermintaan = $detbarang;
            $jumlah_asli = $row->jumlah_asli;
            if($row->nama_barang == $namabarang){
              if($row->merk == $brang && $jumlahpermintaan != 0){
                if($jumlah_asli <= $detbarang){
                  $detbarang = $detbarang - $jumlah_asli;
                  $jumlahpermintaan = $jumlahpermintaan - $jumlah_asli;
                  $jumlah_asli = 0;
                }else{
                  $jumlah_asli = $jumlah_asli - $detbarang;
                  $jumlahpermintaan = $detbarang - $jumlahpermintaan ;
                  if($jumlahpermintaan == 0){
                    $detbarang = 0;
                  }else{
                    $detbarang = $detbarang - $jumlahpermintaan;
                  }
                }
              }
              // var_dump($jumlah);die();
            }
            // echo '*'.$jumlah_asli.' - '. $jumlahpermintaan . ' - '.$detbarang. ' - '.$merkbarang.' - '.$detbarang.'<br>' ;
            $this->m_barang->save_checkout_barang_masuk($jumlah_asli, $id);
          }
        }
                        
        // echo 'Jumlah sisa permintaan '.$jumlah.'<br>';
        // echo 'Jumlah Akhir '.$jumlah_asli; 
        // $jumlah2 = $row->jumlah_barang - $row->jumlah_asli;
        // echo $row->jumlah_asli.'<br>';
        // echo 'JP '.$jumlahpermintaan; 

        if ($langkah == '0') {
          $this->session->set_flashdata('sukses', "Berhasil di ajukan");
          $simpan = $this->m_barang->save_checkout_barang_pengolah($pemberi, $barang, $penerima, $status, $langkah, $data_barang);
          redirect('/permintaanbarang');
        }else{
          $this->session->set_flashdata('sukses', "Berhasil di ajukan");
          $simpan = $this->m_barang->save_checkout($pemberi, $barang, $penerima, $status, $langkah, $data_barang);
          redirect('/permintaanbarang');
        }
      }
    }

    public function accept_selesai($id)
    {
        $barang = $this->input->post('nama_barang');
        $id_user = $this->input->post('id_user');
        $id_user1 = $this->session->userdata('id_auth');
        $pemberi = $this->input->post('pemberi');
        $penerima = $this->input->post('penerima');
        $langkah = $this->input->post('langkah');
        $data_barang = $this->input->post('data_barang');
        $id_barang = $this->input->post('id_barang');
        $status = '1';
        if ($barang == NULL) {
            $this->session->set_flashdata('gagal', "Input Barang Terlebih dahulu");
            redirect('/permintaanbarang');
        } else {
        foreach($id_barang as $barang1){
                $namabarang = $this->m_barang->get_data_barang_nama_barang($barang1);
                $merkbarang = $this->m_barang->get_data_barang_merk_barang($barang1);
                $stokbarang = $this->m_barang->get_data_barang_stok_barang($barang1);
                $detbarang  = $this->m_barang->get_data_barang_log_barang($barang1, $id_user);
            echo $barang1.' - '. $namabarang . ' - '.$merkbarang. ' - '.$stokbarang.' - '.$detbarang.'<br>' ;
            $brang = $merkbarang;

                    $detailbarang = $this->m_barang->get_log_detail($namabarang);
                            foreach($detailbarang as $row){
                                // var_dump($merk);die();
                            $id = $row->id;
                            $jumlahpermintaan = $detbarang;
                            $jumlah_asli = $row->jumlah_asli;
                                if($row->nama_barang == $namabarang){
                                    if($row->merk == $brang && $jumlahpermintaan != 0){
                                        if($jumlah_asli <= $detbarang){
                                            $detbarang = $detbarang - $jumlah_asli;
                                            $jumlahpermintaan = $jumlahpermintaan - $jumlah_asli;
                                            $jumlah_asli = 0;
                                        }else{
                                            $jumlah_asli = $jumlah_asli - $detbarang;
                                            $jumlahpermintaan = $detbarang - $jumlahpermintaan ;
                                            if($jumlahpermintaan == 0){
                                                    $detbarang = 0;
                                            }else{
                                                $detbarang = $detbarang - $jumlahpermintaan;
                                            }
                                        }
                                    }
                                // var_dump($detbarang);die();
                                }
            // $this->m_barang->save_checkout_barang_masuk($jumlah_asli, $id);
            }
            echo '*'.$jumlah_asli.' - '. $jumlahpermintaan . ' - '.$detbarang. ' - '.$merkbarang.' - '.$detbarang.'<br>' ;
        }
        // die();
                $this->session->set_flashdata('sukses', "Berhasil di ajukan");
                $simpan = $this->m_barang->save_checkout($pemberi, $barang, $penerima, $status, $langkah, $data_barang);
                redirect('/permintaanbarang');
        }
    }

    public function index()
    {
        $list_auths = $this->session_info['app_list_auth'];
        $this->penglola_barang = FALSE;
        foreach ($list_auths as $list_auth) {
            if ($list_auth->id_role === '45') {
                $this->penglola_barang = TRUE;
            }
            if ($list_auth->id_role === '44') {
                $this->penglola_barang = TRUE;
            }
        }
        if (!$this->penglola_barang) {
            redirect('dashboard');
        }
        $now = $this->lib_date->get_date_now();
        $tgla = (!empty($this->input->post('tgla')) ? $this->input->post('tgla') : $this->lib_date->set_date($now, -30));
        $tglb = (!empty($this->input->post('tglb')) ? $this->input->post('tglb') : $this->lib_date->set_date($now, 0));
        $data['tgla'] = $tgla;
        $data['tglb'] = $tglb;
        $barang = $this->m_barang->get_data_master($tgla, $tglb);

        $data['barang'] = $barang;
        $data['langkah'] = '0';
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
        $this->session_info['page_name'] = "Sistem Informasi pengelOLAan BArang PERsediaan (SI OLA BAPER) - Info Barang Keluar";
        $this->template->build('barang_master_list', $this->session_info);
    }

    public function redirect(){
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');
        var_dump($bulan);die();
        $this->load->vars($data);
        $this->session_info['page_name'] = "Sistem Informasi pengelOLAan BArang PERsediaan (SI OLA BAPER)";
        redirect('permintaanbarang/cetak_pengeluaran/'.$bulan.'/'.$tahun);
    }

    public function cetak_pengeluaran(){
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');
        // $barang = $this->m_barang->get_data_kategory($bulan, $tahun);
        $barang     = $this->m_barang->get_data_laporan($tahun);
        $data['barang'] = $barang;
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        $this->load->vars($data);
        $this->session_info['page_name'] = "Sistem Informasi pengelOLAan BArang PERsediaan (SI OLA BAPER)";
        $this->template->build('cetak_pengeluaran', $this->session_info);
    }

    public function cetak_excel_admin(){
        $tahun = 2025;
        $barang     = $this->m_barang->get_data_laporan($tahun);
        // var_dump($barang);die();
        $data['barang']     = $barang;
        $data['tahun']      = $tahun;
        $this->load->vars($data);
        $this->session_info['page_name'] = "Sistem Informasi pengelOLAan BArang PERsediaan (SI OLA BAPER)";
        $this->template->build('cetak_excel_admin', $this->session_info);
    }

    public function cetak_excel(){
        // $bulan = $this->input->post('bulan');
        // $tahun = $this->input->post('tahun');
        $tahun = 2024;
        $barang     = $this->m_barang->get_data_laporan($tahun);
        // var_dump($barang);die();
        $data['barang']     = $barang;
        $data['tahun']      = $tahun;
        $this->load->vars($data);
        $this->session_info['page_name'] = "Sistem Informasi pengelOLAan BArang PERsediaan (SI OLA BAPER)";
        $this->template->build('cetak_excel', $this->session_info);
    }

    public function cek_sql(){
        $data = '0';
        $nama_barang = ' Dispenser Tape Cutter TD-103';
        $tahun = 2025;
        $sql = "SELECT * FROM barang_master WHERE nama_barang LIKE '%$nama_barang%' AND YEAR(timestamp) < $tahun";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $data = $query->result();
        }
        // var_dump($data);die();
        $jumlah_data = 0;
        foreach ($data as $r) {
            // // Pisahkan berdasarkan "<br>"
            // $items = explode("<br>", $r->nama_barang);

            // // Inisialisasi array kosong
            // $data = array();

            // foreach ($items as $item) {
            //     if (trim($item) == "") continue; // Lewati jika kosong

            //     // Ambil teks tanpa tag HTML
            //     $cleanItem = strip_tags($item);

            //     // Pecah berdasarkan kata kunci
            //     preg_match('/^(.*?) Merk (.*?) Dengan Jumlah (.*?)$/', $cleanItem, $matches);
                
            //     if (strpos($matches[1], "Dispenser Tape Cutter TD-103") !== false) {
            //         if (count($matches) == 4) {
            //             $data[] = array(
            //                 "nama" => trim($matches[1]),
            //                 "merk" => trim($matches[2]),
            //                 "jumlah" => trim($matches[3])
            //             );
            //         }
            //     }
            // }
            // $totalJumlah = array_sum(array_column($data, 'jumlah'));
            // print_r($data);
            // echo "Total jumlah barang: " . $totalJumlah . "\n";
            // Pisahkan berdasarkan "<br>"

            $items = explode("<br>",$r->nama_barang);

            // Inisialisasi array kosong
            $data = array();

            foreach ($items as $item) {
                if (trim($item) == "") continue; // Lewati jika kosong

                // Ambil teks tanpa tag HTML
                $cleanItem = strip_tags($item);

                // Pecah berdasarkan pola regex
                preg_match('/^(.*?) Merk (.*?) Dengan Jumlah <b>(.*?)<\/b>$/', $item, $matches);

                if (strpos($matches[1], "$nama_barang") !== false) {
                    if (count($matches) == 4) {
                        // Ambil angka dari jumlah
                        preg_match('/(\d+)/', $matches[3], $jumlahMatches);
                        $jumlah = isset($jumlahMatches[1]) ? (int)$jumlahMatches[1] : 0;

                        // Masukkan ke array
                        $data[] = array(
                            "nama" => trim($matches[1]),
                            "merk" => trim($matches[2]),
                            "jumlah" => $jumlah
                        );
                    }
                }
            }

            // Fungsi untuk menjumlahkan jumlah barang
            $totalJumlah = array_sum(array_column($data, 'jumlah'));

            // Tampilkan hasil
            // print_r($data);
            echo "Total jumlah barang: " . $totalJumlah . "\n";
            $jumlah_data = $jumlah_data + $totalJumlah;
            
        }
            echo "Total jumlah barang: " . $jumlah_data . "\n";

    }


    public function log_permintaan()
    {
        
        $now = $this->lib_date->get_date_now();
        $tgla = (!empty($this->input->post('tgla')) ? $this->input->post('tgla') : $this->lib_date->set_date($now, -365));
        $tglb = (!empty($this->input->post('tglb')) ? $this->input->post('tglb') : $this->lib_date->set_date($now, 0));
        $data['tgla'] = $tgla;
        $data['tglb'] = $tglb;
        $id_user = $this->session->userdata('id_auth');
        $barang = $this->m_barang->get_data_master_permintaan($id_user, $tgla, $tglb);

        $data['barang'] = $barang;
        $data['langkah'] = '1';
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
        $this->session_info['page_name'] = "History Permintaan Barang Persediaan (SI OLA BAPER)";
        $this->template->build('barang_master_list', $this->session_info);
    }

    public function hapus_checkout($id, $jumlah, $id_barang, $langkah)
    {
        $awal = $this->m_barang->get_barang_id($id);
        $jumlah_awal = $this->m_barang->get_jumlah_awal($id_barang);
        $hasil = $jumlah_awal + $jumlah;
        $status = "10";

        $simpan = $this->m_barang->hapus_checkout($id, $id_barang, $hasil);
        if ($langkah == 0) {
            $this->m_barang->reject($status);
            redirect('/permintaanbarang/barang');
        } else {
            redirect('/permintaanbarang/pengajuan_barang');
        }
    }

    public function hapus($id){
        $this->m_barang->get_hapus_barang($id);
        redirect('permintaanbarang/barang');
    }

    public function hapus_checkout_permintaan($id, $jumlah, $id_barang, $langkah)
    {
        $awal = $this->m_barang->get_barang_id($id);
        $jumlah_awal = $this->m_barang->get_jumlah_awal($id_barang);
        $hasil = $jumlah_awal + $jumlah;

        $simpan = $this->m_barang->hapus_checkout($id, $id_barang, $hasil);
        if ($langkah == 0) {
            redirect('/permintaanbarang/barang');
        } else {
            redirect('/permintaanbarang/list_permintaan');
        }
    }



    // 20 feb 2023
    public function tambah($id)
    {
        $barang = $this->m_barang->get_barang_id($id);
        $id_user = $this->session->userdata('id_auth');
        $data['user'] = $this->m_barang->get_pegawai_user($id_user);
        $data['barang'] = $barang;
        $data['step'] = 'stok';
        $js = "
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
        $this->session_info['page_name'] = "Sistem Informasi pengelOLAan BArang PERsediaan (SI OLA BAPER)";
        $this->template->build('tambah_stok', $this->session_info);
    }

    public function edit_checkout($id, $jumlah, $id_barang, $langkah, $url)
    {
        $barang = $this->m_barang->get_barang_id($id_barang);
        $permintaan = $this->m_barang->get_checkout_per_barang($id);
        $data['permintaan'] = $permintaan;
        $data['barang'] = $barang;
        $data['jumlah'] = $jumlah;
        $data['idpermintaan'] = $id;
        $data['idbarang'] = $id_barang;
        $data['url'] = $url;
        $data['step'] = 'ubah';
        $js = "
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
        $this->session_info['page_name'] = "Sistem Informasi pengelOLAan BArang PERsediaan (SI OLA BAPER)";
        $this->template->build('edit_checkout', $this->session_info);
    }

    public function edit_ubah()
    {
        $id_user = $this->session->userdata('id_auth');
        $jumlah1 = $this->input->post('jumlahawal');
        $jumlah2 = $this->input->post('jumlahubah');
        $jumlahbarang = $this->input->post('jumlahbarang');
        $idpermintaan = $this->input->post('idpermintaan');
        $keterangan = $this->input->post('keterangan');
        $idbarang = $this->input->post('idbarang');
        $url = $this->input->post('url');

        if($jumlah1 >= $jumlah2){
            $hasil = $jumlah1 - $jumlah2;
            $akhir = $jumlahbarang + $hasil;
        }elseif($jumlah1 <= $jumlah2){
            $hasil = $jumlah2 - $jumlah1;
            $akhir = $jumlahbarang - $hasil;
        }
        $this->m_barang->get_ubah_permintaan($id_user, $jumlah1, $jumlah2, $idpermintaan, $idbarang, $hasil, $akhir, $keterangan, $url);

        redirect("/permintaanbarang/check/".$url."");
    }

    public function edit($id)
    {
        $barang = $this->m_barang->get_barang_id($id);
        $data['barang'] = $barang;
        $data['step'] = 'ubah';
        $js = "
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
        $this->session_info['page_name'] = "Sistem Informasi pengelOLAan BArang PERsediaan (SI OLA BAPER)";
        $this->template->build('edit', $this->session_info);
    }

    public function edit_fiks($id)
    {
        $id_user = $this->session->userdata('id_auth');
        $jumlah1 = $this->input->post('jumlahawal');
        $jumlah2 = $this->input->post('jumlahubah');
        $jumlahbarang = $this->input->post('jumlahbarang');
        $idpermintaan = $this->input->post('idpermintaan');
        $keterangan = $this->input->post('keterangan');
        $idbarang = $this->input->post('idbarang');
        $url = $this->input->post('url');

        if($jumlah1 >= $jumlah2){
            $hasil = $jumlah1 - $jumlah2;
            $akhir = $jumlahbarang + $hasil;
        }elseif($jumlah1 <= $jumlah2){
            $hasil = $jumlah2 - $jumlah1;
            $akhir = $jumlahbarang - $hasil;
        }
        $this->m_barang->get_ubah_permintaan($id_user, $jumlah1, $jumlah2, $idpermintaan, $idbarang, $hasil, $akhir, $keterangan, $url);

        redirect("/permintaanbarang/check/".$url."");
    }

    public function stok()
    {
        $id = $this->input->post('id');
        $id_user    = $this->session->userdata('id_auth');
        $jumlah1    = $this->input->post('jumlahawal');
        $jumlah2    = $this->input->post('jumlahmasuk');
        $penginput  = $this->input->post('nama');
        $barang     = $this->input->post('barang');
        $satuan     = $this->input->post('satuan');
        $harga      = $this->input->post('harga');
        $merk       = $this->input->post('merk');
        $date       = date('Y-m-d G:i:s');


        $rupiah   = $harga;
        $harga    = preg_replace('/[^\d]/', '', $rupiah);


        $text     = 'telah menambah barang dengan jumlah : <b>' . $jumlah2 . '</b><br>Penginput Barang : <b>' . $penginput . '<b>';
        $hasil    = $jumlah1 + $jumlah2;
        $this->m_barang->get_update_barang($id, $hasil, $text, $jumlah2, $barang, $merk, $harga, $penginput, $date, $satuan);

        redirect('/permintaanbarang/barang');
    }


    public function pengajuan(){
        $list_auths = $this->session_info['app_list_auth'];
        $this->penglola_barang = FALSE;
        foreach ($list_auths as $list_auth) {
            if ($list_auth->id_role === '45') {
                $this->penglola_barang = TRUE;
            }
            if ($list_auth->id_role === '44') {
                $this->penglola_barang = TRUE;
            }
        }
        if (!$this->penglola_barang) {
            redirect('dashboard');
        }

        $barang = $this->m_barang->get_data_pengajuan();
        $logbarang = $this->m_barang->get_data_user_master();

        $data['logbarang'] = $logbarang;
        $data['ss'] = '0';
        $data['barang'] = $barang;
        $data['barangcheckout'] = $this->m_barang->get_checkout_barang();
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
              }";

        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "Sistem Informasi pengelOLAan BArang PERsediaan (SI OLA BAPER) - List Permintaan Barang";
        $this->template->build('barang_list_user', $this->session_info);
    }

    public function pengajuan_barang()
    {
        $now = $this->lib_date->get_date_now();
        $tgla = (!empty($this->input->post('tgla')) ? $this->input->post('tgla') : $this->lib_date->set_date($now, -30));
        $tglb = (!empty($this->input->post('tglb')) ? $this->input->post('tglb') : $this->lib_date->set_date($now, 0));
        $data['tgla'] = $tgla;
        $data['tglb'] = $tglb;
        $barang = $this->m_barang->get_data();
        $logbarang = $this->m_barang->get_data_master($tgla,$tglb);
        $id_user = $this->session->userdata('id_auth');
        $checkout = $this->m_barang->get_permintaan();
        $data['check'] = $checkout;
        $data['logbarang'] = $logbarang;
        $data['barang'] = $barang;
        $data['ss'] = '0';
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
              }";

        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "Sistem Pengajuan Barang (SI OLA BAPER)";
        $this->template->build('barang_list_pengajuan_user', $this->session_info);
    }

    public function search($merk, $langkah)
    {
        $barang = $this->m_barang->get_data_search($merk);
        $logbarang = $this->m_barang->get_data_master();
        $id_user = $this->session->userdata('id_auth');
        $checkout = $this->m_barang->get_permintaan();
        $data['check'] = $checkout;
        $data['logbarang'] = $logbarang;
        $data['barang'] = $barang;
        $data['ss'] = '1';
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
              }";

        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "Sistem Informasi pengelOLAan BArang PERsediaan (SI OLA BAPER)";
        if($langkah == '0'){
        $this->template->build('barang_list', $this->session_info);
        }else{
        $this->template->build('barang_list_pengajuan_user', $this->session_info);
        }
    }

    public function search_barang($barang, $langkah)
    {
        $barang = $this->m_barang->get_data_search_barang($barang);
        $logbarang = $this->m_barang->get_data_master();
        $id_user = $this->session->userdata('id_auth');
        $checkout = $this->m_barang->get_permintaan();
        $data['check'] = $checkout;
        $data['logbarang'] = $logbarang;
        $data['barang'] = $barang;
        $data['ss'] = '2';
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
              }";

        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "Sistem Informasi pengelOLAan BArang PERsediaan (SI OLA BAPER)";
        if($langkah == '0'){
        $this->template->build('barang_list', $this->session_info);
        }else{
        $this->template->build('barang_list_pengajuan_user', $this->session_info);
        }
    }

    public function pinjam_user($id)
    {
        $data['barang'] = $this->m_barang->get_barang_id($id);
        $id_user = $this->session->userdata('id_auth');
        $data['user'] = $this->m_barang->get_pegawai_user($id_user);
        $data['step'] = "order_user";

        $js = "
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
        $this->session_info['page_name'] = "Sistem Informasi pengelOLAan BArang PERsediaan (SI OLA BAPER)";
        $this->template->build('pinjam_user', $this->session_info);
    }

    public function order_user()
    {
        $id_user = $this->session->userdata('id_auth');
        $id = $this->input->post('id');
        $jumlah = $this->input->post('jumlah');
        if($jumlah == NULL){
            $this->session->set_flashdata('gagal', "Masukan Jumlah barang");
            redirect('/permintaanbarang/pinjam_user/' . $id);
        }elseif($jumlah == '0'){
            $this->session->set_flashdata('gagal', "Stok Barang Habis");
            redirect('/permintaanbarang/pinjam_user/' . $id);
        }
        $saatini = $this->input->post('saatini');
        $hasil = $saatini - $jumlah;
        if ($jumlah > $saatini) {
            $this->session->set_flashdata('gagal', "Stok tidak cukup turunkan Jumlah barang");
            redirect('/permintaanbarang/pinjam_user/' . $id);
        } else {
            $this->session->set_flashdata('sukses', "Barang berhasil di input ke keranjang");
            $simpan = $this->m_barang->save_order($id_user, $id, $jumlah, $hasil);
            redirect('/permintaanbarang/pengajuan_barang');
        }
    }


    public function list_permintaan()
    {
        $barang = $this->m_barang->get_checkout();
        $permintaan = $this->m_barang->get_permintaan();
        $id_user = $this->session->userdata('id_auth');
        $permintaan_list = $this->m_barang->permintaan_list($id_user);
        $pemberi = $this->m_barang->get_pegawai_user($id_user);

        $data['user'] = $this->m_barang->get_user();
        $data['pemberi'] = $pemberi;
        $data['id_user'] = $id_user;
        $data['id'] = $permintaan_list;
        $data['permintaan'] = $permintaan;
        $data['barang'] = $barang;
        $data['langkah'] = '1';

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

            function confirm_link(text){
              if(confirm(text)){ return true;
              }else{ return false; }
            }
            
            $(document).ready(function() {
              oTable = $('#pendataan1').dataTable({
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
                  $(\"#tabs1\").tabs();
                  $('.monbulan').datepicker({
                      changeMonth: true,
                      changeYear: true,
                      dateFormat: 'yy-mm-dd',
                      closeText: 'X'
                  });
                  $('#form1').validate();
                  $('.pilihan').select2();
              });
      
              function finishAjax(id, response){
                  $('#'+id).html(unescape(response));
                  $('#'+id).fadeIn();
              }";

        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "List Permintaan Barang Persediaan (SI OLA BAPER)";
        $this->template->build('list_permintaan', $this->session_info);
    }

    public function checkout_barang() // untk pemohon barang
    {
        $langkah = '1';
        // $barang = $this->m_barang->get_checkout_pengolah();
        $barang = $this->m_barang->get_checkout();
        $permintaan = $this->m_barang->get_permintaan();
        $id_user = $this->session->userdata('id_auth');
        $permintaan_list = $this->m_barang->permintaan_list($id_user);
        $pemberi = $this->m_barang->get_pegawai_user($id_user);
        // var_dump($pemberi);die();

        $data['user'] = $this->m_barang->get_user();
        $data['pemberi'] = $pemberi;
        $data['id_user'] = $id_user;
        $data['id'] = $permintaan_list;
        $data['permintaan'] = $permintaan;
        $data['barang'] = $barang;
        $data['langkah'] = $langkah;

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

            function confirm_link(text){
              if(confirm(text)){ return true;
              }else{ return false; }
            }
            
            $(document).ready(function() {
              oTable = $('#pendataan1').dataTable({
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
                  $(\"#tabs1\").tabs();
                  $('.monbulan').datepicker({
                      changeMonth: true,
                      changeYear: true,
                      dateFormat: 'yy-mm-dd',
                      closeText: 'X'
                  });
                  $('#form1').validate();
                  $('.pilihan').select2();
              });
      
              function finishAjax(id, response){
                  $('#'+id).html(unescape(response));
                  $('#'+id).fadeIn();
              }";

        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "Checkout Barang Persediaan (SI OLA BAPER)";
        $this->template->build('checkout_list', $this->session_info);
    }

    public function order_barang()
    {
        $id_user = $this->session->userdata('id_auth');
        $id = $this->input->post('id');
        $jumlah = $this->input->post('jumlah');
        $saatini = $this->input->post('saatini');
        $hasil = $saatini - $jumlah;
        if ($jumlah > $saatini) {
            $this->session->set_flashdata('gagal', "Stok tidak cukup turunkan Jumlah barang");
            redirect('/permintaanbarang/pinjam/' . $id);
        } else {
            $this->session->set_flashdata('sukses', "Barang berhasil di input ke dalam keranjang");
            $simpan = $this->m_barang->save_order($id_user, $id, $jumlah, $hasil);
            redirect('/permintaanbarang/barang');
        }
    }

    public function update_data($tahun)
    {
        $cek_db         = $this->m_barang->cek_db($tahun);
        $tambah_table   = $this->m_barang->cek_table($tahun);
        $tahun_kemarin  = $tahun-1;

        $update_table = $this->m_barang->get_data_laporan($tahun_kemarin);
        $update_table_tahun_ini = $this->m_barang->get_data_laporan($tahun);

        if (empty($update_table)) {
            die("Data tidak ditemukan untuk tahun $tahun_kemarin");
        }

        if (!empty($update_table_tahun_ini)) {
            $this->db->query("TRUNCATE TABLE data_$tahun.laporan_permintaan_barang");
        }
        $nama_barang_aaaa = '';
        foreach ($update_table as $row) {
            $nama_barang = $row->nama_barang;
            $nama_barang_lower = strtolower($nama_barang);
            $harga      = $row->harga_satuan_sak;
            $satuan     = $row->satuan;
            $jan_keluar = $this->m_barang->get_jumlah_pengeluaran_perbulan($nama_barang_lower, $harga, $satuan, $tahun, '1');
            $feb_keluar = $this->m_barang->get_jumlah_pengeluaran_perbulan($nama_barang_lower, $harga, $satuan, $tahun, '2');
            $mar_keluar = $this->m_barang->get_jumlah_pengeluaran_perbulan($nama_barang_lower, $harga, $satuan, $tahun, '3');
            $apr_keluar = $this->m_barang->get_jumlah_pengeluaran_perbulan($nama_barang_lower, $harga, $satuan, $tahun, '4');
            $mei_keluar = $this->m_barang->get_jumlah_pengeluaran_perbulan($nama_barang_lower, $harga, $satuan, $tahun, '5');
            $jun_keluar = $this->m_barang->get_jumlah_pengeluaran_perbulan($nama_barang_lower, $harga, $satuan, $tahun, '6');
            $jul_keluar = $this->m_barang->get_jumlah_pengeluaran_perbulan($nama_barang_lower, $harga, $satuan, $tahun, '7');
            $ags_keluar = $this->m_barang->get_jumlah_pengeluaran_perbulan($nama_barang_lower, $harga, $satuan, $tahun, '8');
            $sep_keluar = $this->m_barang->get_jumlah_pengeluaran_perbulan($nama_barang_lower, $harga, $satuan, $tahun, '9');
            $okt_keluar = $this->m_barang->get_jumlah_pengeluaran_perbulan($nama_barang_lower, $harga, $satuan, $tahun, '10');
            $nov_keluar = $this->m_barang->get_jumlah_pengeluaran_perbulan($nama_barang_lower, $harga, $satuan, $tahun, '11');
            $des_keluar = $this->m_barang->get_jumlah_pengeluaran_perbulan($nama_barang_lower, $harga, $satuan, $tahun, '12');

            // Menghitung total jumlah pengeluaran untuk satu tahun
            $unit_keluar = $jan_keluar + $feb_keluar + $mar_keluar + $apr_keluar + $mei_keluar + $jun_keluar + $jul_keluar + $ags_keluar + $sep_keluar + $okt_keluar + $nov_keluar + $des_keluar;
            
            $jan_beli = $this->m_barang->get_jumlah_pembelian_perbulan($nama_barang_lower, $harga, $satuan, $tahun, '1');
            $feb_beli = $this->m_barang->get_jumlah_pembelian_perbulan($nama_barang_lower, $harga, $satuan, $tahun, '2');
            $mar_beli = $this->m_barang->get_jumlah_pembelian_perbulan($nama_barang_lower, $harga, $satuan, $tahun, '3');
            $apr_beli = $this->m_barang->get_jumlah_pembelian_perbulan($nama_barang_lower, $harga, $satuan, $tahun, '4');
            $mei_beli = $this->m_barang->get_jumlah_pembelian_perbulan($nama_barang_lower, $harga, $satuan, $tahun, '5');
            $jun_beli = $this->m_barang->get_jumlah_pembelian_perbulan($nama_barang_lower, $harga, $satuan, $tahun, '6');
            $jul_beli = $this->m_barang->get_jumlah_pembelian_perbulan($nama_barang_lower, $harga, $satuan, $tahun, '7');
            $ags_beli = $this->m_barang->get_jumlah_pembelian_perbulan($nama_barang_lower, $harga, $satuan, $tahun, '8');
            $sep_beli = $this->m_barang->get_jumlah_pembelian_perbulan($nama_barang_lower, $harga, $satuan, $tahun, '9');
            $okt_beli = $this->m_barang->get_jumlah_pembelian_perbulan($nama_barang_lower, $harga, $satuan, $tahun, '10');
            $nov_beli = $this->m_barang->get_jumlah_pembelian_perbulan($nama_barang_lower, $harga, $satuan, $tahun, '11');
            $des_beli = $this->m_barang->get_jumlah_pembelian_perbulan($nama_barang_lower, $harga, $satuan, $tahun, '12');

            // Menghitung total jumlah pembelian untuk satu tahun
            $unit_beli = $jan_beli + $feb_beli + $mar_beli + $apr_beli + $mei_beli + $jun_beli + $jul_beli + $ags_beli + $sep_beli + $okt_beli + $nov_beli + $des_beli;

            // Menampilkan total pembelian
            // echo "Total pembelian untuk tahun $tahun adalah: $unit_beli";

            // Menampilkan total pengeluaran
            // echo "Total pengeluaran untuk tahun $tahun adalah: $unit_keluar";
            $unit_sak = $row->unit_sak+$unit_beli-$unit_keluar;
            // Buat array data untuk insert
            $data = [
                'nama_barang'           => $row->nama_barang,
                'satuan'                => $row->satuan,
                'unit_sa'               => $row->unit_sak,
                'harga_satuan_sa'       => $row->harga_satuan_sak,
                'jumlah_sa'             => $row->jumlah_sak,   
                'jan_beli'              => $jan_beli,
                'feb_beli'              => $feb_beli,
                'mar_beli'              => $mar_beli,
                'apr_beli'              => $apr_beli,
                'mei_beli'              => $mei_beli,
                'jun_beli'              => $jun_beli,
                'jul_beli'              => $jul_beli,
                'ags_beli'              => $ags_beli,
                'sep_beli'              => $sep_beli,
                'okt_beli'              => $okt_beli,
                'nov_beli'              => $nov_beli,
                'des_beli'              => $des_beli,
                'unit_beli'             => $unit_beli,
                'harga_satuan_beli'     => $row->harga_satuan_beli,  // Harga satuan pembelian, sesuaikan dengan kebutuhan Anda
                'jumlah_beli'           => $unit_beli * $row->harga_satuan_beli,  // Total jumlah pembelian 
                'jan_keluar'            => $jan_keluar,
                'feb_keluar'            => $feb_keluar,
                'mar_keluar'            => $mar_keluar,
                'apr_keluar'            => $apr_keluar,
                'mei_keluar'            => $mei_keluar,
                'jun_keluar'            => $jun_keluar,
                'jul_keluar'            => $jul_keluar,
                'ags_keluar'            => $ags_keluar,
                'sep_keluar'            => $sep_keluar,
                'okt_keluar'            => $okt_keluar,
                'nov_keluar'            => $nov_keluar,
                'des_keluar'            => $des_keluar,
                'unit_keluar'           => $unit_keluar,
                'harga_satuan_keluar'   => $row->harga_satuan_keluar,
                'jumlah_keluar'         => $unit_keluar*$row->harga_satuan_keluar,
                'unit_sak'              => $unit_sak,
                'harga_satuan_sak'      => $row->harga_satuan_keluar,
                'jumlah_sak'            => $unit_sak*$row->harga_satuan_keluar,
                'tahun'                 => $tahun,
                'kategori'              => $row->kategori
            ];

            // $update = $this->m_barang->get_data_laporan_one($tahun,$row->nama_barang,$row->harga_satuan_sak,$row->satuan);
            // // Insert ke database
            // if($update != '0'){
            //     $this->db->where('id', $update);
                // $new_data = 'update';
                // $insert = $this->db->update("data_$tahun.laporan_permintaan_barang", $data);
            // }else{
            if($nama_barang_aaaa != $row->nama_barang){
                // var_dump($data);
                // echo 'masuk';
            }
            $nama_barang_aaaa = $row->nama_barang;
                $new_data = 'Insert';
                $insert = $this->db->insert("data_$tahun.laporan_permintaan_barang", $data);
            // }
            if ($insert) {
                echo "<br>Data berhasil untuk: " . $row->nama_barang . "<br>";
            } else {
                echo "Gagal $new_data data untuk: " . $row->nama_barang . "<br>";
            }

        }
        if($this->All){
        die();
        }else{
            
          $this->session->set_flashdata('sukses', "Berhasil Update Data");
          redirect('/permintaanbarang');
        }
    }

public function update_data_test($tahun)
{
    $cek_db         = $this->m_barang->cek_db($tahun);
    $tambah_table   = $this->m_barang->cek_table($tahun);
    $tahun_kemarin  = $tahun - 1;

    $update_table = $this->m_barang->get_data_laporan($tahun_kemarin);
    $update_table_tahun_ini = $this->m_barang->get_data_laporan($tahun);

    if (empty($update_table)) {
        echo json_encode(["error" => "Data tidak ditemukan untuk tahun $tahun_kemarin"]);
        return;
    }

    $output = [];
    $nama_barang_aaaa = '';

    foreach ($update_table as $row) {            
        $nama_barang = strtolower($row->nama_barang);
        $harga      = $row->harga_satuan_sak;
        $satuan     = $row->satuan;

        // Loop untuk bulan 1-12
        $pengeluaran = [];
        $pembelian = [];
        $unit_beli = 0;
        $unit_keluar = 0;

        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $bulan_str = str_pad($bulan, 2, "0", STR_PAD_LEFT);

            $pengeluaran[$bulan_str] = $this->m_barang->get_jumlah_pengeluaran_perbulan($nama_barang, $harga, $satuan, $tahun, $bulan);
            $pembelian[$bulan_str]   = $this->m_barang->get_jumlah_pembelian_perbulan($nama_barang, $harga, $satuan, $tahun, $bulan);
            
            $unit_beli += $pembelian[$bulan_str];
            $unit_keluar += $pengeluaran[$bulan_str];
        }

        $unit_sak = $row->unit_sak + $unit_beli - $unit_keluar;

        $output[] = [
            'nama_barang'           => $row->nama_barang,
            'satuan'                => $row->satuan,
            'unit_sa'               => $row->unit_sak,
            'harga_satuan_sa'       => $row->harga_satuan_sak,
            'jumlah_sa'             => $row->jumlah_sak,   
            'pembelian'             => $pembelian,
            'unit_beli'             => $unit_beli,
            'harga_satuan_beli'     => $row->harga_satuan_beli,
            'jumlah_beli'           => $unit_beli * $row->harga_satuan_beli,
            'pengeluaran'           => $pengeluaran,
            'unit_keluar'           => $unit_keluar,
            'harga_satuan_keluar'   => $row->harga_satuan_keluar,
            'jumlah_keluar'         => $unit_keluar * $row->harga_satuan_keluar,
            'unit_sak'              => $unit_sak,
            'harga_satuan_sak'      => $row->harga_satuan_keluar,
            'jumlah_sak'            => $unit_sak * $row->harga_satuan_keluar,
            'tahun'                 => $tahun,
            'kategori'              => $row->kategori
        ];
    }

    // Set response JSON
    header('Content-Type: application/json');
    echo json_encode($output, JSON_PRETTY_PRINT);
}


    public function activity(){
        $list_auths = $this->session_info['app_list_auth'];
        $this->penglola_barang = FALSE;
        foreach ($list_auths as $list_auth) {
            if ($list_auth->id_role === '45') {
                $this->penglola_barang = TRUE;
            }
            if ($list_auth->id_role === '44') {
                $this->penglola_barang = TRUE;
            }
        }
        if (!$this->penglola_barang) {
            redirect('dashboard');
        }
        $barang = $this->m_barang->get_log();
        $detail = $this->m_barang->get_data_jumlah();

        $data['barang'] = $barang;
        $data['detail'] = $detail;
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
        $this->session_info['page_name'] = "Sistem Informasi pengelOLAan BArang PERsediaan (SI OLA BAPER) - Info Barang Masuk";
        $this->template->build('barang_log', $this->session_info);
    }

    public function accept_barang(){ // checkout permohonan barang
      $barang = $this->input->post('nama_barang');
      $null = $this->input->post('null');
      $id_user = $this->session->userdata('id_auth');
      $pemberi = $this->input->post('pemberi');
      $penerima = $this->input->post('penerima');
      $status = '2';
      if($penerima == NULL || $penerima == '-' || $penerima == '') {
        $this->session->set_flashdata('gagal', "Penerima belum di input");
        redirect('/permintaanbarang/checkout');
      }
      
      //if($this->All){var_dump($penerima); die();}
      $pemohon_barang = $this->m_barang->get_data_user_n_pegawai($this->m_barang->get_pegawai_user_n_pegawai($id_user));
      $penerima_notif = $this->m_barang->get_pegawai_user_n_pegawai($penerima);
      $penerima_notif = $this->m_barang->get_data_user_n_pegawai($penerima_notif);
      $clean_string = strip_tags($barang);
      $htmlText = $barang;
      $textWithoutTags = strip_tags($htmlText);
      $textWithoutTags = html_entity_decode($textWithoutTags);
      $orders = explode("\n", $textWithoutTags);
      $whatsappMessage = "Halo! Saya ".$pemohon_barang." ingin memesan:\n";
      $n_pesan = "";
      foreach ($orders as $key => $order) {
        $order = trim($order);
        $order = str_replace(".", "", $order); // Remove dots
        $whatsappMessage .= $order . "\n";
      }
      $whatsappMessage .= "\n Terima kasih! Si-OlaBaPer";
      $notificationSettings = $this->m_barang->getAllNotificationSettings_ex();
      //if($this->All){var_dump($notificationSettings); die();}
      if($null == '0'){
        $this->session->set_flashdata('gagal', "Input Barang Terlebih dahulu");
        redirect('permintaanbarang/pengajuan_barang');
      }else{
      	// Kirim SMS
      	foreach ($notificationSettings as $row) {
          $n_hp    = $this->m_barang->get_data_user_telepon($row->user_id);
          //$n_pesan = "Pesanan Masuk : ".$whatsappMessage;
          $n_pesan = $whatsappMessage;
          $this->lib_date->postWaSms($n_hp, $n_pesan, 'Setting');
        }
        $this->lib_date->postWaSms('08121314834', $n_pesan, 'Setting'); // untuk testing memastikan sementara waktu PBS
        //if($this->All){var_dump($n_pesan); die();}
        // EOF() Kirim SMS
        $this->session->set_flashdata('sukses', "Berhasil di ajukan");
        $simpan = $this->m_barang->post_pengajuan($pemberi, $barang, $penerima, $status, $id_user);
        redirect('permintaanbarang/list_permintaan');
      }
    }

    public function setting() {
        // Load view for notification settings form
        $notificationSettings = $this->m_barang->getAllNotificationSettings();
        $data['notificationSettings'] = $notificationSettings;
        $this->session_info['page_name'] = "Setting pengelOLAan BArang PERsediaan (SI OLA BAPER)";
        $this->load->vars($data);
        $this->template->build('notification_settings', $this->session_info);
    }

    public function updateSettings() {
        // Update settings for each user
        $notificationSettings = $this->input->post('notification_settings');
        foreach ($notificationSettings as $userId => $settings) {
            $whatsappEnabled = isset($settings['whatsapp_enabled']) ? 1 : 0;
            $emailEnabled = isset($settings['email_enabled']) ? 1 : 0;
            $this->m_barang->updateNotificationSettings($userId, $whatsappEnabled, $emailEnabled);
        }
        redirect('permintaanbarang/setting'); // Redirect back to notification settings page
    }


    public function recipients() {
        $data['recipients'] = $this->m_barang->get_all_recipients();
        $this->load->vars($data);
        $this->session_info['page_name'] = "Sistem Informasi pengelOLAan BArang PERsediaan (SI OLA BAPER)";
        $this->template->build('whatsapp_notification_recipients', $this->session_info);
    }

    public function add_recipient() {
        $pegawai = $this->m_barang->get_user_dpmptsp();
        $data['users'] = $pegawai;
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
              }";
        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "Sistem Informasi pengelOLAan BArang PERsediaan (SI OLA BAPER)";
        $this->template->build('add_whatsapp_notification_recipient', $this->session_info);
    }

    public function save_recipient() {
        $data = array(
            'user_id' => $this->input->post('user_id'),
            'whatsapp_enabled' => $this->input->post('whatsapp_enabled'),
            'email_enabled' => $this->input->post('email_enabled')
        );
        // var_dump($data);die();
        $cek_data = $this->m_barang->cek_data_notifikasi($this->input->post('user_id'));
        if($cek_data == 0){
            $save = $this->m_barang->insert_recipient($data);
        }else{
            $save = $this->m_barang->update_recipient($data, $cek_data);
        }
        // var_dump($save);die();
        if($save){
        $this->session->set_flashdata('sukses', "Berhasil We dirit");
        redirect('permintaanbarang/setting');
        }else{
        $this->session->set_flashdata('gagal', "Gagal");
        redirect('permintaanbarang/setting');
        }
    }


    public function check($id)
    {
        $barang = $this->m_barang->get_check($id);
        if($barang == NULL){
        $this->m_barang->reject($id);
        redirect('permintaanbarang/pengajuan');
        }else{
        $permintaan = $this->m_barang->get_permintaan();
        $id_user = $this->session->userdata('id_auth');
        $pemberi = $this->m_barang->get_pegawai_user($id_user);

        $data['user'] = $this->m_barang->get_user();
        $data['id'] = $id;
        $data['pemberi'] = $pemberi;
        $data['id_user'] = $id_user;
        $data['permintaan'] = $permintaan;
        $data['barang'] = $barang;
        $data['langkah'] = '0';

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
              }";

        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "Sistem Informasi pengelOLAan BArang PERsediaan (SI OLA BAPER)";
        $this->template->build('checkout_list_approve', $this->session_info);
        }
    }

    public function approve($id, $url)
    {
        $status = '3';
        $date = date('Y-m-d G:i:s');
        $id_user = $this->session->userdata('id_auth');
        $approve = '1';
        $kirim = '0';
        if ($id == NULL) {
            $this->session->set_flashdata('gagal', "Gagal");
            redirect('permintaanbarang/check/' . $url);
        } else {
            $this->session->set_flashdata('sukses', "Berhasil di ajukan");
            $this->m_barang->terima_barang($id_user, $approve);
            $simpan = $this->m_barang->approved_barang($status, $id, $date, $approve, $kirim);
            redirect('permintaanbarang/check/' . $url);
        }
    }

    public function acc($id, $url)
    {
        $status = '4';
        $date = date('Y-m-d G:i:s');
        $approve = '3';
        $kirim = '0';
        if ($id == NULL) {
            $this->session->set_flashdata('gagal', "Gagal Approve");
            redirect('permintaanbarang/check/' . $url);
        } else {
            $this->session->set_flashdata('sukses', "Berhasil di Approve");
            $this->m_barang->terima_barang($approve, $date, $url);
            $simpan = $this->m_barang->approved_barang($status, $id, $date, $approve, $kirim);
            redirect('permintaanbarang/check/' . $url);
        }
    }

    public function kirim($id, $url)
    {
        $status = '5';
        $date = date('Y-m-d G:i:s');
        $approve = '5';
        $kirim = '1';
        if ($id == NULL) {
            $this->session->set_flashdata('gagal', "Gagal");
            redirect('permintaanbarang/check/' . $url);
        } else {
            $this->session->set_flashdata('sukses', "Berhasil di ajukan");
            $this->m_barang->terima_barang($approve, $date, $url);
            $simpan = $this->m_barang->approved_barang($status, $id, $date, $approve, $kirim);
            redirect('permintaanbarang/check/' . $url);
        }
    }

    public function terima($id)
    {
        $permintaan = $this->m_barang->get_permintaan();
        $id_user = $this->session->userdata('id_auth');
        $penerima1 = $this->m_barang->get_pegawai_user($id_user);
        $status1 = $this->input->post('status');
        $id_barang = $this->input->post('id_barang');
        $langkah = $this->input->post('langkah');
        $barang = $this->input->post('nama_barang');
        $pemberi = $this->input->post('id_user');
        $data_barang = $this->input->post('data_barang');
        $penerima = $this->input->post('id_user_permintaan');
        $keterangan = $this->input->post('Keterangan');
        $kirim = '2';
        $status = '6';


        if (array_sum($status1) == (count($status1) * 6)) {
        $date = $this->input->post('tanggal_barang');
        $approve = '0';    
        } else {
        $date = date('Y-m-d G:i:s');
        $approve = '5';
        }    


        if ($approve == NULL) :
            $this->session->set_flashdata('gagal', "Gagal");
            redirect('permintaanbarang/list_permintaan');
        elseif($approve == '0') :  
              
        foreach($id_barang as $barang1){
            // var_dump($penerima);die();
                $namabarang = $this->m_barang->get_data_barang_nama_barang($barang1);
                $merkbarang = $this->m_barang->get_data_barang_merk_barang($barang1);
                $stokbarang = $this->m_barang->get_data_barang_stok_barang($barang1);
                $detbarang  = $this->m_barang->get_data_barang_log_barang($barang1, $penerima);
            // echo $barang1.' - '. $namabarang . ' - '.$merkbarang. ' - '.$stokbarang.' - '.$detbarang.'<br>' ;
            $brang = $merkbarang;

                    $detailbarang = $this->m_barang->get_log_detail($namabarang);
                            foreach($detailbarang as $row){
                                // var_dump($merk);die();
                            $id = $row->id;
                            $jumlahpermintaan = $detbarang;
                            $jumlah_asli = $row->jumlah_asli;
                                if($row->nama_barang == $namabarang){
                                    if($row->merk == $brang && $jumlahpermintaan != 0){
                                        if($jumlah_asli <= $detbarang){
                                            $detbarang = $detbarang - $jumlah_asli;
                                            $jumlahpermintaan = $jumlahpermintaan - $jumlah_asli;
                                            $jumlah_asli = 0;
                                        }else{
                                            $jumlah_asli = $jumlah_asli - $detbarang;
                                            $jumlahpermintaan = $detbarang - $jumlahpermintaan ;
                                            if($jumlahpermintaan == 0){
                                                    $detbarang = 0;
                                            }else{
                                                $detbarang = $detbarang - $jumlahpermintaan;
                                            }
                                        }
                                    }
                                // var_dump($detbarang);die();
                                }
            $this->m_barang->save_checkout_barang_masuk($jumlah_asli, $id);
            // echo '*'.$jumlah_asli.'  '. $jumlahpermintaan . '  '.$detbarang. '  '.$merkbarang.'  '.$detbarang.'<br>' ;
            }
        }
        // die();

        $tgl = date('Y-m-d');
        $keluar1 = $this->m_barang->get_data_master2();
        $bulan1 = date("m", strtotime($tgl));
        foreach($keluar1 as $row){
           $no = $row->no_ba;
           $bulan2 = $row->bulan;
        }

        if($bulan1 == $bulan2){
            $no++;
        }else{
            $no = 1;
        }

        $simpan = $this->m_barang->save_checkout_barang_user2($pemberi, $barang, $penerima, $status, $id, $id_user, $date, $keterangan, $data_barang, $no);
            redirect('permintaanbarang/list_permintaan');
        else :
            $this->session->set_flashdata('sukses', "Permintaan barang berhasil");
            $this->m_barang->diterima_barang($approve, $date, $penerima);
            $this->m_barang->approved_barang($status, $id, $date, $approve, $kirim);
            redirect('permintaanbarang/list_permintaan');
        endif;
    }

    public function tidak_ada($id)
    {

        $status = '8';
        $date = date('Y-m-d G:i:s');
        $approve = '6';
        if ($id == NULL) {
            $this->session->set_flashdata('gagal', "Gagal");
            redirect('permintaanbarang/list_permintaan');
        } else {
            $this->session->set_flashdata('sukses', "Berhasil mengajukan pengembalian barang");
            $this->m_barang->terima_barang($approve, $date, $url);
            $simpan = $this->m_barang->approved_barang($status, $id, $date, $approve);
            redirect('permintaanbarang/list_permintaan');
        }
    }

    public function cetak()
    {
        $barang = $this->m_barang->barang_log();
        $data['log'] = $barang;
        $this->load->vars($data);
        $this->session_info['page_name'] = "Cetak History Barang Persediaan (SI OLA BAPER)";
        $this->template->build('cetak', $this->session_info);
    }

    public function reload_ba($id){ // berita acara
        $logbarang = $this->m_barang->get_barang_master($id);
        foreach ($logbarang as $row) {
            $no_ba = $row->no_ba;
            $tanggal = $row->tanggal;
            $bulan = $row->bulan;
            $nama_barang = $row->nama_barang;
            $data_barang = $row->data_barang;
            $jumlah = $row->jumlah;
            $pemberi_barang = $row->pemberi_barang;
            $status = $row->status;
            $keterangan = $row->keterangan;
            $date = $row->date;
            $tanggal_approve = $row->tanggal_approve;
            $timestamp = $row->timestamp;
            $loop = $row->loop;
        }
        $htmlString = $data_barang;

        // Buat objek DOMDocument
        $dom = new DOMDocument;
        $dom->loadHTML($htmlString);

        // Ambil semua elemen <tr>
        $rows = $dom->getElementsByTagName('tr');

        $dataArray = array();

        // Loop melalui setiap baris
        foreach ($rows as $row) {
            $rowData = array();
            
            // Ambil semua elemen <td>
            $cells = $row->getElementsByTagName('td');
            
            // Loop melalui setiap sel dalam baris
            foreach ($cells as $cell) {
                // Tambahkan teks dari sel ke array
                $rowData[] = $cell->textContent;
            }
            
            // Tambahkan data baris ke array utama
            $dataArray[] = $rowData;
        }

        // Hapus baris pertama (header) dari array
        array_shift($dataArray);

        // Tampilkan hasil
        // echo "<pre>";
        // print_r($dataArray);
        // echo "</pre>";
        // String HTML untuk tabel
        $tableHtml = "
        <table border='1' width='100%' style='border-collapse: collapse;'>
            <tr>
                <th>NO</th>
                <th>Nama Barang Spesifikasi</th>
                <th>Jumlah</th>
                <th>Satuan Barang</th>
                <th>Ket</th>
            </tr>";

        $no = 1;
        foreach ($dataArray as $row) {
            $tableHtml .= "
            <tr>
                <td><center>{$no}</center></td>
                <td><b>{$row[1]}</b></td>
                <td><center>{$row[2]}</center></td>
                <td><center>{$row[3]}</center></td>
                <td>{$row[4]}</td>
            </tr>";
            $no++;
        }

        $tableHtml .= "</table>";

        // Tampilkan hasil
        // echo $tableHtml;
        // var_dump($tableHtml);die();
        $edit = $this->m_barang->edit_nomor($id, $tableHtml);
        
        $list_auths = $this->session_info['app_list_auth'];
        $this->penglola_barang = FALSE;
        foreach ($list_auths as $list_auth) {
            if ($list_auth->id_role === '45') {
                $this->penglola_barang = TRUE;
            }
            if ($list_auth->id_role === '44') {
                $this->penglola_barang = TRUE;
            }
        }
        if($this->penglola_barang){
            if(!$edit){
            $this->session->set_flashdata('sukses', "Berhasil Melakukan Reload");
            redirect('/permintaanbarang','refresh');
            }else{
            $this->session->set_flashdata('gagal', "Gagal Melakukan Reload");
            redirect('/permintaanbarang','refresh');
            }
        }else{
            if(!$edit){
            $this->session->set_flashdata('sukses', "Berhasil Melakukan Reload");
            redirect('/permintaanbarang/log_permintaan','refresh');
            }else{
            $this->session->set_flashdata('gagal', "Gagal Melakukan Reload");
            redirect('/permintaanbarang/log_permintaan','refresh');
            }
        }
        
    }

    public function ba($id){ // berita acara
        $logbarang = $this->m_barang->get_barang_master($id);
        $id_user = $this->session->userdata('id_auth');
        $data['barang'] = $logbarang;
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
              }";

        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "Berita Acara Barang Persediaan (SI OLA BAPER)";
        $this->template->build('pdf_ba', $this->session_info);
    }

    public function do_upload()
{
  $config['upload_path'] = './uploads/'; // direktori tempat menyimpan file yang diupload
  $config['allowed_types'] = 'gif|jpg|png'; // tipe file yang diizinkan untuk diupload
  $config['max_size'] = 2048; // ukuran maksimum file yang diizinkan dalam kilobyte
  
  $this->load->library('upload', $config);
  
  if (!$this->upload->do_upload('gambar')) {
    $error = array('error' => $this->upload->display_errors());
    $this->load->view('upload_form', $error);
  } else {
    $data = array('upload_data' => $this->upload->data());
    $this->load->view('upload_success', $data);
  }
}
}