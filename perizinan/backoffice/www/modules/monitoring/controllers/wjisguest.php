<?php

/**
  * Description of Monitorin data Peserta WJIS
  * @PBS Created : 23 Juli 2024
*/

class wjisguest extends WRC_AdminCont {

  public function __construct() {
    parent::__construct();
    $this->load->model("m_invesment");
    $this->load->library('fpdf');
    $enabled = FALSE;
    $list_auths = $this->session_info['app_list_auth'];
    foreach ($list_auths as $list_auth) {
      if($list_auth->id_role === '58') {
        $enabled = TRUE;
        break;
      }
    }
    $this->All = false;
    $list_auths = $this->session_info['app_list_auth'];
    foreach($list_auths as $list_auth) {
      if($list_auth->id_role === '18') {
        $this->All = TRUE;
        $enabled = TRUE;
        break;
      }
    }
    if(!$enabled) {
      redirect('dashboard');
    }
  }

  public function index() {
    
    // var_dump($this->All);die();
    // var_dump($id_user);die();
    $data['data'] = $this->m_invesment->get_data();
    $data['data_attedance'] = $this->m_invesment->get_attedance();
    $data['data_rundown'] = $this->m_invesment->all_data_rundown();
    $data['data_rowndown'] = $this->m_invesment->get_data_rowndown();
    $data['data_event_setting'] = $this->m_invesment->get_data_event_setting_ceremony_selection();
    $data['data_event_setting_dpmptsp'] = $this->m_invesment->get_data_event_setting_souvenir_dpmptsp_selection();
    $data['data_event_setting_indonesia'] = $this->m_invesment->get_data_event_setting_souvenir_bank_indonesi_selection();
    // $data['jml_souvenir'] = $this->m_invesment->get_souvenir_data();
    $data['jml_souvenir'] = $this->m_invesment->get_souvenir_data();

    // var_dump($data['data_attedance']);die();

    $data['data_admin'] = $this->All;
    // var_dump($data['data_admin']);die();
    // var_dump($data['data_attedance']);die();
    $this->load->vars($data);
    // var_dump(site_url('assets/qrcode_views'));die();

    $js = "function confirm_link(text){
             if(confirm(text)){ return true;
             }else{ return false; }
           }
          
           $(document).ready(function() {
             oTable = $('#Project').dataTable({
               \"bJQueryUI\": true,
               \"sPaginationType\": \"full_numbers\"
             });
           });
           
           $(document).ready(function() {
             oTable = $('#Rundown').dataTable({
               \"bJQueryUI\": true,
               \"sPaginationType\": \"full_numbers\"
             });
           });
           
           $(document).ready(function() {
             oTable = $('#Registrants').dataTable({
               \"bJQueryUI\": true,
               \"sPaginationType\": \"full_numbers\"
             });
           });
           
           $(document).ready(function() {
             oTable = $('#Unconfirm').dataTable({
               \"bJQueryUI\": true,
               \"sPaginationType\": \"full_numbers\"
             });
           });
           
           $(document).ready(function() {
             oTable = $('#Process').dataTable({
               \"bJQueryUI\": true,
               \"sPaginationType\": \"full_numbers\"
             });
           });
           
           $(document).ready(function() {
             oTable = $('#Present').dataTable({
               \"bJQueryUI\": true,
               \"sPaginationType\": \"full_numbers\"
             });
           });
           
           $(document).ready(function() {
             oTable = $('#notPresent').dataTable({
               \"bJQueryUI\": true,
               \"sPaginationType\": \"full_numbers\"
             });
           });
           
           $(document).ready(function() {
             oTable = $('#Ceremony').dataTable({
               \"bJQueryUI\": true,
               \"sPaginationType\": \"full_numbers\"
             });
           });
           
           $(document).ready(function() {
             oTable = $('#Exhibition').dataTable({
               \"bJQueryUI\": true,
               \"sPaginationType\": \"full_numbers\"
             });
           });
           
           $(document).ready(function() {
             oTable = $('#Talkshow').dataTable({
               \"bJQueryUI\": true,
               \"sPaginationType\": \"full_numbers\"
             });
           });

            $(document).ready(function() {
             oTable = $('#one_on_one_meeting').dataTable({
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

    // Set session information
    $this->session_info['page_name'] = "WJIS Event";
    $this->session_info['page_name_attedance'] = "Data Tamu";

    // Build the view
    $this->template->build('v_wjisguest', $this->session_info);
  }

  public function qrcode($id){
    include('./assets/qrcode/qrlib.php');
    $tempdir = "/var/www/html/jelita/assets/qrcode_gpt/"; //Nama folder tempat menyimpan file qrcode

    if(!file_exists($tempdir)) //Buat folder bername temp
      mkdir($tempdir);
    
    //ambil logo
    $logopath="https://dpmptsp.jabarprov.go.id/jelita/assets/Coat_of_arms_of_West_Java.svg.png";
    
    //isi qrcode jika di scan
    $codeContents = 'https://dpmptsp.jabarprov.go.id/jelita/main/wjisgues/'.base64_encode($id); 
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
    
    redirect('https://dpmptsp.jabarprov.go.id/jelita/backoffice/monitoring/wjisguest/','refresh');
  }

  public function qrcode_views($id) {

  	$nfile_foto = str_replace(' ', '', 'foto_'.$id).'.png';
    if(!file_exists('uploads/logo/'.$nfile_foto)){
      $nfile_foto = '';
    }
    // $id = base64_decode($id);
    $tamu = $this->m_invesment->tamu_detail($id);
    // var_dump($tamu);die();

    $data['tamu'] = $tamu;
    $data['nfile_foto'] = $nfile_foto;
    $this->load->vars($data);
    $this->session_info['page_name'] = 'ID Card ';
    $this->template->build('qrcode_views', $this->session_info);
  }

  public function edit($id) {
  	$data_tamu = $this->m_invesment->get_row_attedance($id);
  	$id_user = $this->session->userdata('id_auth');
  	$data_user = $this->m_invesment->get_user($data_tamu->id_pegawai);
  	if($data_tamu->id_pegawai == 0){
  	  $save_proses = $this->m_invesment->update_proses($id,$id_user);
  	}  
    $data['data_tamu'] = $data_tamu;
    $data['data_user'] = $data_user;
    $data['id_user'] = $id_user;
    $data['data_rowndown'] = $this->m_invesment->get_data_rowndown();

    $data['data_event_selection'] = $this->m_invesment->get_data_event_selection($id);
    $data['data_event_selection_one_on_meeting'] = $this->m_invesment->get_data_event_selection_one_on_meeting($id);

    // var_dump($data['data_event_selection_one_on_meeting']);die();  

    $data['step']   = "update_guest_information"; 
 
    // var_dump($data['data_rowndown']);die();
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
      $this->session_info['page_name'] = "Konfirmasi Kehadiran";
      // if($this->All){
      $this->template->build('edit_tamu', $this->session_info);
      // }else{
      // $this->template->build('edit_nib', $this->session_info);
      // }
  }
  
  public function create() {
    $sectors = $this->m_invesment->get_sectors();
    $data['sectors'] = $sectors;
    $this->load->vars($data);
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

    // Set session information
    $this->session_info['page_name'] = "Tambah Data Invesment";

    // Build the view
    $this->template->build('v_create_invesment', $this->session_info);
  }


    public function store() {
        
            $iduser = $this->session->userdata('id_auth');
    
            $data['iduser'] = $iduser;
            // var_dump($data['iduser']);die();
            $data = array(
                'judul_investasi' => $this->input->post('judul_investasi'),
                'users_id' => $iduser,
                'isBahasa' => $this->input->post('isBahasa'),
                'fk_sector' => $this->input->post('fk_sector'),
                'mini_deskripsi' => $this->input->post('mini_deskripsi'),
                'project_value' => $this->input->post('project_value'),
                'kategori' => $this->input->post('kategori'),
                'investment_type' => $this->input->post('investment_type'),
                'author' => $this->input->post('author'),
                'job_title' => $this->input->post('job_title'),
                'lokasi' => $this->input->post('lokasi'),
                'lat' => $this->input->post('lat'),
                'long' => $this->input->post('long'),
                'project_desc' => $this->input->post('project_desc'),
                'invest_scheme' => $this->input->post('invest_scheme'),
                'irr' => $this->input->post('irr'),
                'npv' => $this->input->post('npv'),
                'payback_period' => $this->input->post('payback_period')
            );

            // Handle the file upload for 'image'
            if (!empty($_FILES['image']['name'])) {
                $upload_dir = $_SERVER['DOCUMENT_ROOT'] . "/investasi-provjabar/src/assets/invest/thumbnail/";
                $image_name = time() . '_' . $_FILES['image']['name'];
                $upload_file = $upload_dir . $image_name;

                if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_file)) {
                    $data['image'] = $image_name;

                } else {
                    var_dump('error else image');die();
                    $this->session->set_flashdata('error', 'Gagal mengunggah gambar investasi.');
                    redirect('info/invesment'); // Adjust the redirection as necessary
                }
            }
            if (!empty($_FILES['author_image']['name'])) {
                $upload_dir = $_SERVER['DOCUMENT_ROOT'] . "/investasi-provjabar/src/assets/invest/file/";
                $image_name = time() . '_' . $_FILES['author_image']['name'];
                $upload_file = $upload_dir . $image_name;

                if (move_uploaded_file($_FILES['author_image']['tmp_name'], $upload_file)) {
                    $data['author_image'] = $image_name;

                } else {
                    var_dump('error else author_image');die();
                    $this->session->set_flashdata('error', 'Gagal mengunggah gambar investasi.');
                    redirect('info/invesment'); // Adjust the redirection as necessary
                }
            }
            if (!empty($_FILES['support_file']['name'])) {
              $upload_dir = $_SERVER['DOCUMENT_ROOT'] . "/investasi-provjabar/src/assets/invest/file/";
              $image_name = time() . '_' . $_FILES['support_file']['name'];
              $upload_file = $upload_dir . $image_name;

              if (move_uploaded_file($_FILES['support_file']['tmp_name'], $upload_file)) {
                  $data['support_file'] = $image_name;

              } else {
                  var_dump('error else support_file');die();
                  $this->session->set_flashdata('error', 'Gagal mengunggah gambar investasi.');
                  redirect('info/invesment'); // Adjust the redirection as necessary
              }
          }

            // Insert data into the database
            $insert_id = $this->m_invesment->store_with_query($data);

            if ($insert_id) {
                $this->session->set_flashdata('success', 'Data investasi berhasil disimpan.');
                redirect('info/invesment'); // Adjust the redirection as necessary
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan data investasi.');
                redirect('info/invesment'); // Adjust the redirection as necessary
            }
        // }
    }


  
  public function SendEmailApprove($id) {
    // Pastikan Anda memperoleh iduser dari session atau sesuai kebutuhan aplikasi Anda
  	$data_tamu = $this->m_invesment->get_row_attedance($id);
    // var_dump();die();
    $iduser = $this->session->userdata('id_auth');
    $data['iduser'] = $iduser;
    $jum_send = $data_tamu->sum_notif;

    // Buat array $data berdasarkan parameter yang diterima dari URL
   
    // var_dump($data);die();
    if (isset($data_tamu->email) && $data_tamu->email !== '') {

      $uuids = "coba";
      $qrcode = 'https://dpmptsp.jabarprov.go.id/jelita/assets/qrcode_tamu_wjis/qrcode_'.$id.'.png';
      $url = 'http://103.122.5.250/nrsmailer/web/mailer-api/wjis-approve?mails='.$data_tamu->email.'&request=1&token=qffL4YFq8Q&uuid='.$uuids.'&name='.urlencode($data_tamu->full_name).'&id='.$id;
      // $url = 'http://103.122.5.250/nrsmailer/web/mailer-api/wjis-approve?mails='.$data_tamu->email.'&request=1&token=qffL4YFq8Q&uuid='.$uuids;
      // var_dump($url);die();
      $encode = base64_encode($id);
      $data = @file_get_contents($url);
      
      $n_pesan = "Dear $data_tamu->full_name. \n
      We are delighted to welcome you to the 6th West Java Investment Summit which will take place on Thursday, September 19, 2024 at the Trans Convention Center, Trans Luxury Hotel, Bandung.\n
      Your registration has been successfully confirmed, and you can attend the event by using the following link to generate QR code:\n
      https://dpmptsp.jabarprov.go.id/jelita/main/wjisgues/$encode\n
      Please use the generated QR code to confirm your attendance on the day of the event.\n
      We look forward to welcoming you to the 6th West Java Investment Summit 2024!\n
      Warm regards,\n
      West Java Investment Summit Team\n

      West Java Investment Summit Team
      West Java Provincial Investment and One Stop Integrated Service Office and Bank of Indonesia West Java Representative Office
      https://investasi.jabarprov.go.id/";

      $kirim = $this->m_invesment->postWaSms($data_tamu->phone_number, $n_pesan, 'wjis');

      // var_dump($data_tamu->phone_number);die();
      if ($data) {
        $json = json_decode($data);
        if(isset($json->status)) {
        	$jum_send++;
          $data_send_wa_email = array('id' => $id,
                                      'status_send_wa_email' => 1,
                                      'sum_notif' =>$jum_send
                                     );
          $update_status = $this->m_invesment->update_status_terkirim_whatsapp($data_send_wa_email);
          // var_dump($update_status);die();
          if($json->status == 1) {
            redirect('monitoring/wjisguest');
          }else{
            echo "Ada Yang Error Kirim E-Mail Gan: " . $json->error;die;
          }
        }
      }
  	}
    // if ($update_status) {
    //     echo 'success';
    // } else {
    //     echo 'error';
    // }
  }
  public function update_setting_event($id, $status_setting_event) {
    // Pastikan Anda memperoleh iduser dari session atau sesuai kebutuhan aplikasi Anda
    
    $iduser = $this->session->userdata('id_auth');
    $data['iduser'] = $iduser;

    // Buat array $data berdasarkan parameter yang diterima dari URL
    $data = array(
        'id' => $id,
        'status_setting_event' => $status_setting_event,
    );

    $update_status = $this->m_invesment->update_setting($data);
    if ($update_status) {
        echo 'success';
    } else {
        echo 'error';
    }
  }
  public function update_guest_information($id) {
    // Ambil data dari input (misalnya, menggunakan POST)

    $iduser = $this->session->userdata('id_auth');
    
    $data = array(
        'id' => $id,
        'full_name' => $this->input->post('full_name'),
        'phone_number' => $this->input->post('phone_number'),
        'date_of_birth' => $this->input->post('date_of_birth'),
        'address' => $this->input->post('address'),
        'email' => $this->input->post('email'),
        'status' => $this->input->post('status'),
        'keterangan' => $this->input->post('Keterangan'),
        'countries' => $this->input->post('countries'),
        'investation' => $this->input->post('investation'),
        'position' => $this->input->post('position'),
        'company' => $this->input->post('company'),
        'id_pegawai' => $iduser,
        'souvenir' => $this->input->post('souvenir'),
        'souvenir_bank_indonesia' => $this->input->post('souvenir_bank_indonesia'),
        'no_kursi' => strtoupper($this->input->post('no_kursi')), // Mengubah ke huruf besar
        'RSVP_Information' => implode(', ', $this->input->post('RSVP_Information'))
    );
  

    // Panggil metode update_setting dari model
    $result = $this->m_invesment->q_update_guest_information($data);
   // Mengambil data dari input POST
    $event_id = $this->input->post('project_presentasion_event_id');

    // Memastikan bahwa $event_id adalah array
    if (is_array($event_id)) {
        // Mengonversi setiap elemen dalam array menjadi integer
        $event_id_integers = array_map('intval', $event_id);
    } else {
        // Jika $event_id bukan array, inisialisasi sebagai array kosong
        $event_id_integers = array();
    }

    // Debug: Menampilkan hasil konversi

    // var_dump($event_id_integers);die();

    // $project_presentasion_event_id = $this->input->post('project_presentasion_event_id');
    // $project_presentasion_event_id_integers = Array();
    // if($project_presentasion_event_id){
    //   $project_presentasion_event_id_string = implode(", ", $project_presentasion_event_id);
    //   $project_presentasion_event_id_integers = array_map('intval', $project_presentasion_event_id);
    //   $project_presentasion_event_id_integers_string = implode(", ", $project_presentasion_event_id_integers);
    // }
    $this->m_invesment->update_guest_event_selection($id, $event_id_integers);
    
    // Panggil metode update_setting dari model
    $result = $this->m_invesment->q_update_guest_information($data);

    // Update data di tabel guest_event_selection
    $one_on_one_meeting_event_id = $this->input->post('one_on_one_meeting_event_id');
    $one_on_one_meeting_event_id_integers = Array();
    if($one_on_one_meeting_event_id){
      $one_on_one_meeting_event_id_string = implode(", ", $one_on_one_meeting_event_id);
      $one_on_one_meeting_event_id_integers = array_map('intval', $one_on_one_meeting_event_id);
      $one_on_one_meeting_event_id_integers_string = implode(", ", $one_on_one_meeting_event_id_integers);
    }
  
  

    $this->m_invesment->update_guest_event_selection_one_on_one_meeting($id, $one_on_one_meeting_event_id_integers);
    // var_dump($one_on_one_meeting_event_id_integers);die();
    // var_dump($event_id);die();
    
    if ($this->input->post('status') === '2') {

      $this->qrcode($id);
    }
    // Tanggapi hasil update
    if ($result) {
        $this->session->set_flashdata('success', 'Informasi berhasil diperbarui.');

        // Panggil metode qrcode jika status adalah 'hadir'
      
    } else { 
        $this->session->set_flashdata('error', 'Gagal memperbarui informasi.');
    }

    // Redirect atau tampilkan pesan
    redirect('monitoring/wjisguest'); // Kembali ke halaman pengaturan atau halaman lain
  }

  //public function mppdigital() { 
  //	//$this->load->vars($data);
  //  $js =  "$(document).ready(function() {
  //             oTable = $('#perizinaninfo').dataTable({
  //                      \"bJQueryUI\": true,
  //                      \"sPaginationType\": \"full_numbers\"
  //             });
  //          } );
  //         ";
  //  $this->template->set_metadata_javascript($js);
  //  $this->session_info['page_name'] = "Mal Pelayanan Publik Digital Jabar (MPP Digital)";
  //  $this->template->build('mppdigital', $this->session_info);
  //}

  public function redirect($id) {
    $id_user = $this->session->userdata('id_auth');
    $link = $this->m_super_apps->get_link($id);
    $ipaddress = $_SERVER['REMOTE_ADDR']."";
    date_default_timezone_set('Asia/Jakarta');
    $tanggal = date('Y-m-d G:j:s');
    $kunjungan = 1;
    $counter = $this->m_super_apps->counterdb($id, $kunjungan, $tanggal, $ipaddress, $id_user);
    // var_dump($counter);die();
		header("Location: ".$link);
  }
  
  public function create_rundown() {
  	$data['save_method'] = "save_rundown";
  	$data['id'] = '';
    $data['waktu_start1']  = null;
    $data['waktu_start2']  = null;
	  $data['waktu_end1']  = null;
	  $data['waktu_end2']  = null;
    $data['durasi'] = '';
    $data['kegiatan'] = '';
    $data['pembicara'] = null;
    $data['status'] = 0;
    $js_date = "
                $(document).ready(function() {
                  $('#form').validate();
                  $(\"#tabs\").tabs();
                } );
               ";
    $this->template->set_metadata_javascript($js_date);
    
    $this->load->vars($data);
    $this->session_info['page_name'] = "Tambah Rundown";
    $this->template->build('edit_rundown', $this->session_info);
  }

  public function edit_rundown($id_edit = NULL) {
    $this->sektor->get_by_id($id_edit);
    $js_date = "
                 $(document).ready(function() {
                   $(\"#tabs\").tabs();
                   $('#form').validate();
                 } );
               ";
    $this->template->set_metadata_javascript($js_date);
    
    $data['nama'] = $this->sektor->n_sektor;
    $data['urutan'] = $this->sektor->urutan;
    $data['save_method'] = "update_rundown";
    $data['id'] = $this->sektor->id;
    $petugas = new tmpegawai();
    $data['petugas'] = $petugas->where('status = 1 OR status = 2')->get();
    $petugas2 = new tmpegawai();
    $data['tgs_esl4'] = $petugas2->where('eselon = 4 AND ttd_surat = 1')->get();
    $data['tgs_id_sp'] = $this->sektor->ttd_sp;
    $data['tgs_id_tlk'] = $this->sektor->ttd_tolak;
    $data['tgs_id_nta'] = $this->sektor->ttd_nota;
    $data['tgs_id_esl4'] = $this->sektor->esl4_tolak;
    $data['no_pertek_awal'] = $this->sektor->no_pertek_awal;
    $data['no_pertek_akhir'] = $this->sektor->no_pertek_akhir;
    $data['no_sp_awal'] = $this->sektor->no_sp_awal;
    $data['no_sp_akhir'] = $this->sektor->no_sp_akhir;
    
    $this->load->vars($data);
    $this->session_info['page_name'] = "Edit Bidang Perizinan";
    $this->template->build('bidang_edit', $this->session_info);
  }

  public function save_rundown() {
    $this->sektor->n_sektor = $this->input->post('nama');
    $this->sektor->urutan = $this->input->post('urutan');
    $this->sektor->ttd_sp = $this->input->post('ttd_sp');
    $this->sektor->ttd_tolak = $this->input->post('ttd_tlk');
    $this->sektor->ttd_nota = $this->input->post('ttd_nta');
    $this->sektor->esl4_tolak = $this->input->post('ttd_esl4');
    $this->sektor->no_pertek_awal = $this->input->post('no_pertek_awal');
    $this->sektor->no_pertek_akhir = $this->input->post('no_pertek_akhir');
    $this->sektor->no_sp_awal = $this->input->post('no_sp_awal');
    $this->sektor->no_sp_akhir = $this->input->post('no_sp_akhir');
    
    //if(! $this->sektor->save()){
    //  echo '<p>' . $this->sektor->error->string . '</p>';
    //}else{
    //  $u_ser = $this->session->userdata('username');
    //  $tgl = date("Y-m-d H:i:s");
    //  $p = $this->db->query("call log ('Setting Umum','Insert Bidang Perizinan ".$this->input->post('nama')."','".$tgl."','".$u_ser."')");
      redirect('monitoring/wjisguest');
    //}
  }
  
  public function update_rundown() {
    //$update = $this->sektor
    //        ->where('id', $this->input->post('id'))
    //        ->update(array('n_sektor' => $this->input->post('nama'),
    //                 'urutan' => $this->input->post('urutan'),
    //                 'ttd_sp' => $this->input->post('ttd_sp'),
    //                 'ttd_tolak' => $this->input->post('ttd_tlk'),
    //                 'ttd_nota' => $this->input->post('ttd_nta'),
    //                 'esl4_tolak' => $this->input->post('ttd_esl4'),
    //                 'no_pertek_awal' => $this->input->post('no_pertek_awal'),
    //                 'no_pertek_akhir' => $this->input->post('no_pertek_akhir'),
    //                 'no_sp_awal' => $this->input->post('no_sp_awal'),
    //                 'no_sp_akhir' => $this->input->post('no_sp_akhir')
    //                ));
    //if($update){
    //  $u_ser = $this->session->userdata('username');
    //  $tgl = date("Y-m-d H:i:s");
    //  $p = $this->db->query("call log ('Setting Umum','Update Bidang Perizinan ".$this->input->post('nama')."','".$tgl."','".$u_ser."')");
    //  redirect('settings/bidang');
    //}
  }
  public function delete_kehadiran($id) {
      // Memanggil metode di model untuk menghapus data
      $result = $this->m_invesment->q_delete_kehadiran($id);

      if ($result) {
          // Jika berhasil, set flashdata sukses
          $this->session->set_flashdata('success', 'Informasi berhasil dihapus.');

          // Anda dapat memanggil metode lain di sini jika diperlukan,
          // misalnya jika Anda ingin melakukan sesuatu setelah penghapusan berhasil.

      } else {
          // Jika gagal, set flashdata error
          $this->session->set_flashdata('error', 'Gagal menghapus informasi.');
      }

      // Redirect ke halaman monitoring
      redirect('monitoring/wjisguest');
  }
  public function cetak_excel($status) {
    // Mendapatkan data NIB dari model dengan parameter status
    $data_nib = $this->m_invesment->get_data_unconfirm($status);

    // Menentukan nama file dan judul berdasarkan status konfirmasi
    switch ($status) {
        case '0':
            $judul = 'Daftar Data Tamu West Java Investment Summit Belum Dikonfirmasi';
            $nama_file = 'Daftar_Data_Tamu_West_Java_Investment_Summit_Belum_Dikonfirmasi.xls';
            break;
        case '1':
            $judul = 'Daftar Data Tamu West Java Investment Summit Dalam Proses';
            $nama_file = 'Daftar_Data_Tamu_West_Java_Investment_Summit_Dalam_Proses.xls';
            break;
        case '2':
            $judul = 'Daftar Data Tamu West Java Investment Summit Hadir';
            $nama_file = 'Daftar_Data_Tamu_West_Java_Investment_Summit_Hadir.xls';
            break;
        case '3':
            $judul = 'Daftar Data Tamu West Java Investment Summit Tidak Hadir';
            $nama_file = 'Daftar_Data_Tamu_West_Java_Investment_Summit_Tidak_Hadir.xls';
            break;
        default:
            $judul = 'Daftar Data Tamu West Java Investment Summit';
            $nama_file = 'Daftar_Data_Tamu_West_Java_Investment_Summit.xls';
            break;
    }

    // Header untuk file Excel
    header("Content-Type: application/vnd.ms-excel; charset=utf-8");
    header("Content-Disposition: attachment; filename=".$nama_file);
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: private", false);

    // Output judul dan periode
    echo "<table width='100%' border='0' style='font-size:16px;'>";
    echo "<tr><td colspan='11'>".$judul."</td></tr>";
    // Note: Tanggal periode tidak tersedia di kode ini, sesuaikan jika perlu
    // echo "<tr><td colspan='11'>PERIODE : ".$this->lib_date->mysql_to_human($tgla)." - ".$this->lib_date->mysql_to_human($tglb)."</td></tr>";
    echo "</table>";

    // Judul kolom
    $jdl = "
    <tr>
        <td>NO.</td>
        <td>Full Name</td>
        <td>Email</td>
        <td>Phone Number</td>
        <td>Address</td>
        <td>RSVP Information</td>
        <td>Status</td>
        <td>Country</td>
        <td>Company</td>
        <td>Position</td>
        <td>Souvenir</td>
    </tr>";
    echo "<table border='1' style='border-collapse: collapse; font-size: 15px;'>"; 
    echo $jdl; 

    // Isi tabel
    $i = 1;
    foreach ($data_nib as $row) {
        // Status label
        $status_label = $row->status == '0' ? '<span style="color: Red">Unconfirmed</span>' :
                         ($row->status == '1' ? '<span style="color: Blue">In Process</span>' :
                         ($row->status == '2' ? '<span style="color: Green">Attended</span>' :
                         '<span style="color: Gray">Not Attended</span>'));

        // Souvenir label
        $souvenir_label = $row->souvenir == '1' ? 'Yes' : 'No';

        // Tambahkan baris baru untuk cetak data dalam tabel
        echo "<tr>
                <td style='text-align: center; vertical-align: middle;'>".$i."</td>
                <td style='text-align: center; vertical-align: middle;'>".$row->full_name."</td>
                <td style='text-align: center; vertical-align: middle;'>".$row->email."</td>
                <td style='text-align: center; vertical-align: middle;'>".$row->phone_number."</td>
                <td style='text-align: center; vertical-align: middle;'>".$row->address."</td>
                <td style='text-align: center; vertical-align: middle;'>".$row->RSVP_Information."</td>
                <td style='text-align: center; vertical-align: middle;'>".$status_label."</td>
                <td style='text-align: center; vertical-align: middle;'>".$row->countries."</td>
                <td style='text-align: center; vertical-align: middle;'>".$row->company."</td>
                <td style='text-align: center; vertical-align: middle;'>".$row->position."</td>
                <td style='text-align: center; vertical-align: middle;'>".$souvenir_label."</td>
            </tr>";

        $i++;
    }

    echo "</table>";
  }

  public function export_to_excel() {
    // Mendapatkan data dari database
    $data_attedance = $this->m_invesment->get_attedance();
    $data_rowndown = $this->m_invesment->get_data_rowndown();

    // Cek apakah ada data one on one meeting
    $has_data = false;
    foreach ($data_attedance as $investasi) {
        $data_event_selection_one_on_meeting = $this->m_invesment->get_data_event_selection_one_on_meeting($investasi->id);
        if (!empty($data_event_selection_one_on_meeting)) {
            $has_data = true;
            break;
        }
    }

    if (!$has_data) {
        echo "Tidak ada data One On One Meeting yang tersedia.";
        return;
    }

    // Header untuk file Excel
    header("Content-Type: application/vnd.ms-excel; charset=utf-8");
    header("Content-Disposition: attachment; filename=data_one_on_one_meeting.xls");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: private", false);

    // Buat judul tabel Excel
    echo "<table border='1' cellpadding='0' cellspacing='0' style='border-collapse: collapse; width: 100%; font-size: 15px;'>";
    echo "<thead>
        <tr>
            <th width='3%'>No</th>
            <th width='30%'>Nama<br>Alamat<br>No Telpon / e-mail<br>Status Konfirmasi</th>
            <th width='10%'>RSVP Information</th>
            <th width='27%'>Purpose Of Visit<br>Project Presentation</th>
            <th width='23%'>Purpose Of Visit<br>One On One Meeting<br>Pertanyaan<br>Jawaban</th> 
        </tr>
    </thead>";
    echo "<tbody>";

    $no = 1;
    $has_data_to_display = false;

    foreach ($data_attedance as $investasi) {
        $data_user = $this->m_invesment->get_user($investasi->id_pegawai);
        $data_event_selection = $this->m_invesment->get_data_event_selection($investasi->id);

        $data_event_selection_one_on_meeting = $this->m_invesment->get_data_event_selection_one_on_meeting($investasi->id);
        $rsvp_data = explode(", ", $investasi->RSVP_Information);
        $no_mm = 0;

        // Inisialisasi variabel agar tidak ada warning jika tidak ada data
        $purpose_visit = "";
        $purpose_visit_project_presentasion = "";

        $info = ($investasi->status == 2) ? 'AKAN HADIR, Dikonfirmasi oleh : ' . $data_user->oriname : 'Belum Dikonfirmasi';
        $status_konfirmasi = "<b>" . $info . "</b>";

        // RSVP Information
        $rsvp_info = "";
        foreach ($rsvp_data as $index => $label) {
            $rsvp_info .= ($index + 1) . '. ' . $label . '<br>';
        }

        // Process project presentation events
        foreach ($data_rowndown as $acara) {
            foreach ($data_event_selection as $event) {
                if ($event->project_presentasion_event_id == $acara->id) {
                    $no_mm++;
                    $purpose_visit_project_presentasion .= "
                        <table style='border-collapse: collapse; border: none;' width='100%' cellpadding='0' cellspacing='0'>
                            <tbody>
                                <tr>
                                    <td valign='top' width='10%'>" . $no_mm . ".</td>
                                    <td valign='top' width='25%'>" . $acara->oom_start . " - " . $acara->oom_end . "</td>
                                    <td valign='top' width='65%'>" . $acara->kegiatan . "</td>
                                </tr>
                            </tbody>
                        </table>";
                    $has_data_to_display = true;
                    break;
                }
            }
        }

        // Process one-on-one meeting events
        foreach ($data_rowndown as $acara) {
            foreach ($data_event_selection_one_on_meeting as $event) {
                if ($event->one_on_one_meeting_id == $acara->id) {
                    $no_mm++;
                    $purpose_visit .= "
                        <table style='border-collapse: collapse; border: none;' width='100%' cellpadding='0' cellspacing='0'>
                            <tbody>
                                <tr>
                                    <td valign='top' width='10%'>" . $no_mm . ".</td>
                                    <td valign='top' width='25%'>" . $acara->oom_start . " - " . $acara->oom_end . "</td>
                                    <td valign='top' width='65%'>" . $acara->kegiatan . "</td>
                                    <td valign='top' width='10%'>Pertanyaan: " . $event->pertanyaan_checkout . " - Jawaban: " . $event->jawaban_checkout . "</td>
                                </tr>
                            </tbody>
                        </table>";
                    $has_data_to_display = true;
                    break;
                }
            }
        }

        // Hanya tampilkan baris jika ada data one on one meeting
        if ($has_data_to_display) {
            echo "<tr>
                    <td valign='top'>$no</td>
                    <td valign='top'>
                      <b>{$investasi->full_name}</b><br>
                        {$investasi->address}<br>
                        {$investasi->phone_number} / {$investasi->email}<br>
                        Position : {$investasi->position}<br>
                        Company : {$investasi->company}, {$investasi->countries}<br>
                        $status_konfirmasi
                    </td>
                    <td valign='top'>$rsvp_info</td>
                    <td valign='top'>$purpose_visit_project_presentasion</td>
                    <td valign='top'>$purpose_visit</td>
                </tr>";
            $no++;
        }

        // Reset flag untuk data berikutnya
        $has_data_to_display = false;
    }

    echo "</tbody></table>";
}


  public function export_to_excel_one_on_one_meeting() {
    // Mendapatkan data dari database
    $data_attedance = $this->m_invesment->get_attedance(); // Sesuaikan dengan cara Anda mengambil data
    $data_rowndown = $this->m_invesment->get_data_rowndown();

    // Cek apakah ada data one on one meeting
    $has_data = false;
    foreach ($data_attedance as $investasi) {
        $data_event_selection_one_on_meeting = $this->m_invesment->get_data_event_selection_one_on_meeting($investasi->id);
        if (!empty($data_event_selection_one_on_meeting)) {
            $has_data = true;
            break;
        }
    }

    if (!$has_data) {
        // Jika tidak ada data one on one meeting, tampilkan pesan atau hentikan eksekusi
        echo "Tidak ada data One On One Meeting yang tersedia.";
        return;
    }

    // Header untuk file Excel
    header("Content-Type: application/vnd.ms-excel; charset=utf-8");
    header("Content-Disposition: attachment; filename=data_one_on_one_meeting.xls");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: private", false);

    // Buat judul tabel Excel
    echo "<table border='1' cellpadding='0' cellspacing='0' style='border-collapse: collapse; width: 100%; font-size: 15px;'>";
    echo "<thead>
        <tr>
            <th width='3%'>No</th>
            <th width='30%'>Nama<br>Alamat<br>No Telpon / e-mail<br>Status Konfirmasi</th>
            <th width='10%'>RSVP Information</th>
            <th width='23%'>Purpose Of Visit<br>One On One Meeting<br>Pertanyaan<br>Jawaban</th> 
        </tr>
    </thead>";
    echo "<tbody>";

    $no = 1;
    $has_data_to_display = false; // Flag untuk cek apakah ada baris yang ditampilkan

    foreach ($data_attedance as $investasi) {
        $data_user = $this->m_invesment->get_user($investasi->id_pegawai);
        $data_event_selection_one_on_meeting = $this->m_invesment->get_data_event_selection_one_on_meeting($investasi->id);
        $rsvp_data = explode(", ", $investasi->RSVP_Information);
        $no_mm = 0;

        // Status konfirmasi
        $info = ($investasi->status == 2) ? 'AKAN HADIR, Dikonfirmasi oleh : ' . $data_user->oriname : 'Belum Dikonfirmasi';
        $status_konfirmasi = "<b>" . $info . "</b>";

        // RSVP Information
        $rsvp_info = "";
        $num = 0;
        foreach ($rsvp_data as $label) {
            $num++;
            $rsvp_info .= $num . '. ' . $label . '<br>';
        }

        // Souvenir
        $souvenir_info = '';
        if ($investasi->souvenir == 1) {
            $souvenir_info .= 'Souvenir DPMPTSP <br>';
        }
        if ($investasi->souvenir_bank_indonesia == 1) {
            $souvenir_info .= 'Souvenir Bank Indonesia <br>';
        }

        // Purpose of Visit / One On One Meeting
        $purpose_visit = "";
        foreach ($data_rowndown as $acara) {
            foreach ($data_event_selection_one_on_meeting as $event) {
                if ($event->one_on_one_meeting_id == $acara->id) {
                    $no_mm++;
                    // Menambahkan data one on one meeting ke dalam tabel
                    $purpose_visit .= "
                        <table style='border-collapse: collapse; border: none;' width='100%' cellpadding='0' cellspacing='0'>
                            <tbody>
                                <tr>
                                    <td valign='top' width='10%'>" . $no_mm . ".</td>
                                    <td valign='top' width='25%'>" . $acara->oom_start . " - " . $acara->oom_end . "</td>
                                    <td valign='top' width='65%'>" . $acara->kegiatan . "</td>
                                    <td valign='top' width='10%'>Pertanyaan: " . $event->pertanyaan_checkout . " - " . "Jawaban: " . $event->jawaban_checkout . "</td>

                                </tr>
                            </tbody>
                        </table>";
                    $has_data_to_display = true;
                    break;
                }
            }
        }

        // Hanya tampilkan baris jika ada data one on one meeting
        if ($has_data_to_display) {
            // Aksi (QR Code dan Edit)
            
            // Output data ke dalam tabel Excel
            echo "<tr>
                    <td valign='top'>$no</td>
                    <td valign='top'><b>{$investasi->full_name}</b><br>
                        {$investasi->address}<br>
                        {$investasi->phone_number} / {$investasi->email}<br>
                        Position : {$investasi->position}<br>
                        Company : {$investasi->company}, {$investasi->countries}<br>
                        $status_konfirmasi
                    </td>
                    <td valign='top'>$rsvp_info</td>
                    <td valign='top'>$purpose_visit</td>
                </tr>";
            $no++;
        }

        // Reset flag untuk data berikutnya
        $has_data_to_display = false;
    }

    echo "</tbody></table>";
  }




  public function cetak_excel_project($status) {
    // Mendapatkan data proyek dari model dengan parameter status
    $data_projects = $this->m_invesment->get_data_project_excel($status);

    // Menentukan nama file dan judul berdasarkan status
    switch ($status) {
        case '0':
            $judul = 'Daftar Data Proyek Belum Dikonfirmasi';
            $nama_file = 'Daftar_Data_Proyek_Belum_Dikonfirmasi.xls';
            break;
        case '1':
            $judul = 'Daftar Data Proyek Dalam tampil';
            $nama_file = 'Daftar_Data_Proyek_Dalam_tampil.xls';
            break;
        case '2':
            $judul = 'Daftar Data Proyek Hadir';
            $nama_file = 'Daftar_Data_Proyek_Hadir.xls';
            break;
        case '3':
            $judul = 'Daftar Data Proyek Tidak Hadir';
            $nama_file = 'Daftar_Data_Proyek_Tidak_Hadir.xls';
            break;
        default:
            $judul = 'Daftar Data Proyek';
            $nama_file = 'Daftar_Data_Proyek.xls';
            break;
    }

    // Header untuk file Excel
    header("Content-Type: application/vnd.ms-excel; charset=utf-8");
    header("Content-Disposition: attachment; filename=".$nama_file);
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: private", false);

    // Output judul dan periode
    echo "<table width='100%' border='0' style='font-size:16px;'>";
    echo "<tr><td colspan='12'>".$judul."</td></tr>";
    echo "</table>";

    // Judul kolom
    $jdl = "
    <tr>
        <td>NO.</td>
        <td>judul_investasi</td>
        <td>mini_deskripsi</td>
        <td>project_value</td>
        <td>kategori</td>
        <td>total_contact</td>
        <td>lokasi</td>
        <td>long</td>
        <td>lat</td>
        <td>project_desc</td>
        <td>invest_scheme</td>
        <td>author</td>
    </tr>";
    echo "<table border='1' style='border-collapse: collapse; font-size: 15px;'>"; 
    echo $jdl; 

    // Isi tabel
    $i = 1;
    foreach ($data_projects as $row) {
        // Status label (asumsikan status_content di sini, sesuaikan jika perlu)
        $status_label = $row->status_content == '0' ? '<span style="color: Red">Unconfirmed</span>' :
                         ($row->status_content == '1' ? '<span style="color: Blue">In Process</span>' :
                         ($row->status_content == '2' ? '<span style="color: Green">Attended</span>' :
                         '<span style="color: Gray">Not Attended</span>'));

        // Tambahkan baris baru untuk cetak data dalam tabel
        echo "<tr>
                <td style='text-align: center; vertical-align: middle;'>".$i."</td>
                <td style='text-align: center; vertical-align: middle;'>".$row->judul_investasi."</td>
                <td style='text-align: center; vertical-align: middle;'>".$row->mini_deskripsi."</td>
                <td style='text-align: center; vertical-align: middle;'>".$row->project_value."</td>
                <td style='text-align: center; vertical-align: middle;'>".$row->kategori."</td>
                <td style='text-align: center; vertical-align: middle;'>".$row->total_contact."</td>
                <td style='text-align: center; vertical-align: middle;'>".$row->lokasi."</td>
                <td style='text-align: center; vertical-align: middle;'>".$row->long."</td>
                <td style='text-align: center; vertical-align: middle;'>".$row->lat."</td>
                <td style='text-align: center; vertical-align: middle;'>".$row->project_desc."</td>
                <td style='text-align: center; vertical-align: middle;'>".$row->invest_scheme."</td>
                <td style='text-align: center; vertical-align: middle;'>".$row->author."</td>
            </tr>";

        $i++;
    }

    echo "</table>";
}




}