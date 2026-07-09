<?php

/**
  * Description of Informasi Perizinan
  * @author agusnur ; Created : 08 Okt 2010
  * @edit PBS       ; Created : 08 Apr 2015
*/

class invesment extends WRC_AdminCont {

  public function __construct() {
    parent::__construct();
    $this->load->model("m_invesment");
    $this->perizinan = new trperizinan();
    $this->syarat_izin = new trsyarat_perizinan();
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
    $data['data'] = $this->m_invesment->get_data();
    $data['data_setting'] = $this->m_invesment->get_data_setting();
    $data['data_attedance'] = $this->m_invesment->get_attedance();
    $data['data_rundown'] = $this->m_invesment->all_data_rundown();
   
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
            oTable = $('#setting').dataTable({
              \"bJQueryUI\": true,
              \"sPaginationType\": \"full_numbers\"
            });
          });
          $(document).ready(function() {
            oTable = $('#get_attedance').dataTable({
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
    $this->session_info['page_name'] = "Back Office Invesment";
    $this->session_info['page_name_setting'] = "Setting Event";
    $this->session_info['page_name_attedance'] = "attedance List";



    // Build the view
    $this->template->build('v_invesment', $this->session_info);
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

  public function landing_page() {
    $data['homepage_id'] = $this->m_invesment->get_by_id_homepage(0);
    $data['homepage_en'] = $this->m_invesment->get_by_id_homepage(1);
    $data['homepage_v2'] = $this->m_invesment->get_homepage_v2();
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
    $this->session_info['page_name'] = "Landing Page";

    // Build the view
    // var_dump($data['homepage_id']);die();
    $this->template->build('v_landing_page', $this->session_info);
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

        $routees        = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
        $root           = rtrim($_SERVER['DOCUMENT_ROOT'], '/'); // buang trailing slash
        $routees        = ltrim($routees, '/');              // buang leading slash
        $routees_portal = str_replace('backoffice/index.php', '', $_SERVER['SCRIPT_NAME']); 
        $master_url     = $_SERVER['REQUEST_SCHEME'] .'://'. $_SERVER['HTTP_HOST'];

    // Handle the file upload for 'image'
    if (!empty($_FILES['image']['name'])) {
        $upload_dir = $_SERVER['DOCUMENT_ROOT'] . $routees_portal . "investasi-jabar/src/assets/invest/thumbnail/";
        $image_name = time() . '_' . $_FILES['image']['name'];
        $upload_file = $upload_dir . $image_name;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_file)) {
            $data['image'] = $image_name;

        } else {
            var_dump('error else image 1');die();
            $this->session->set_flashdata('error', 'Gagal mengunggah gambar investasi.');
            redirect('info/invesment'); // Adjust the redirection as necessary
        }
    }
    if (!empty($_FILES['author_image']['name'])) {
        $upload_dir = $_SERVER['DOCUMENT_ROOT'] . $routees_portal  . "investasi-jabar/src/assets/invest/file/";
        $image_name = time() . '_' . $_FILES['author_image']['name'];
        $upload_file = $upload_dir . $image_name;

        if (move_uploaded_file($_FILES['author_image']['tmp_name'], $upload_file)) {
            $data['author_image'] = $image_name;

        } else {
            var_dump('error else author_image 2');die();
            $this->session->set_flashdata('error', 'Gagal mengunggah gambar investasi.');
            redirect('info/invesment'); // Adjust the redirection as necessary
        }
    }
    if (!empty($_FILES['support_file']['name'])) {
      $upload_dir = $_SERVER['DOCUMENT_ROOT'] . $routees_portal . "investasi-jabar/src/assets/invest/file/";
      $image_name = time() . '_' . $_FILES['support_file']['name'];
      $upload_file = $upload_dir . $image_name;

      if (move_uploaded_file($_FILES['support_file']['tmp_name'], $upload_file)) {
          $data['support_file'] = $image_name;

      } else {
          var_dump('error else support_file 3');die();
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
  }

  public function create_event_setting() {
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
    $this->session_info['page_name'] = "Tambah Event Setting";

    // Build the view
    $this->template->build('v_create_invesment_event_setting', $this->session_info);
  }
  public function store_event_setting() {
      
    $iduser = $this->session->userdata('id_auth');

    $data['iduser'] = $iduser;
    // var_dump($data['iduser']);die();
    $data = array(
        'nama_event' => $this->input->post('nama_event'),
        'jumlah' => $this->input->post('jumlah'),
        'status_setting_event' => $this->input->post('status_setting_event'),
    );
    // Insert data into the database
    $insert_id = $this->m_invesment->store_event_setting_with_query($data);

    if ($insert_id) {
        $this->session->set_flashdata('success', 'Data investasi berhasil disimpan.');
        redirect('info/invesment'); // Adjust the redirection as necessary
    } else {
        $this->session->set_flashdata('error', 'Gagal menyimpan data investasi.');
        redirect('info/invesment'); // Adjust the redirection as necessary
    }
  }
  public function edit_event_setting($id) {
    $sectors = $this->m_invesment->get_sectors();
    $data['sectors'] = $sectors;
    $data['data_setting'] = $this->m_invesment->get_data_setting_by_id($id);
    // var_dump($data['data_setting']);die();
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
    $this->session_info['page_name'] = "Edit Event Setting";

    // Build the view
    $this->template->build('v_edit_invesment_event_setting', $this->session_info);
  }
  public function Update_event_setting($id) {
      
    $iduser = $this->session->userdata('id_auth');

    $data['iduser'] = $iduser;
    // var_dump($data['iduser']);die();
    $data = array(
        'nama_event' => $this->input->post('nama_event'),
        'jumlah' => $this->input->post('jumlah'),
        'status_setting_event' => $this->input->post('status_setting_event'),
    );
    // Insert data into the database
    $insert_id = $this->m_invesment->Update_event_setting_with_query($id, $data);
    if ($insert_id) {
        $this->session->set_flashdata('success', 'Data investasi berhasil disimpan.');
        redirect('info/invesment'); // Adjust the redirection as necessary
    } else {
        $this->session->set_flashdata('error', 'Gagal menyimpan data investasi.');
        redirect('info/invesment'); // Adjust the redirection as necessary
    }
  }
  

 public function edit($id) {
    $data['data'] = $this->m_invesment->get_data_guest_byId($id);
    // var_dump($data['data']);die();
     $js = "$(document).ready(function(){
                $(\"#tabs\").tabs();
                 $('#form').validate();

                 oTable = $('#peran_list').dataTable({
                       \"bJQueryUI\": true,
                       \"sPaginationType\": \"full_numbers\"
              });
           });
           $(document).ready(function() {
               $('#form').validate();
               $(\"#tabs\").tabs();
               $('a[rel*=upload_box]').facebox();
             } );

             $(function() {
                    $(\"#inputTanggal1\").datepicker({
                        changeMonth: true,
                        changeYear: true,
                        dateFormat: 'yy-mm-dd',
                        closeText: 'X'
                    });
                    $(\"#inputTanggal2\").datepicker({
                        changeMonth: true,
                        changeYear: true,
                        dateFormat: 'yy-mm-dd',
                        closeText: 'X'
                    });
                    $(\"#inputTanggal3\").datepicker({
                        changeMonth: true,
                        changeYear: true,
                        dateFormat: 'yy-mm-dd',
                        closeText: 'X'
                    });
                });";
    
    $this->template->set_metadata_javascript($js);
    $this->load->vars($data);
    // Set session information
    $this->session_info['page_name'] = "Edit Guest/Tamu Wjis";
    // Build the view
    $this->template->build('v_invesment_edit', $this->session_info);
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

  public function update_status_content($invest_id, $status_content) {
    // Pastikan Anda memperoleh iduser dari session atau sesuai kebutuhan aplikasi Anda
    $iduser = $this->session->userdata('id_auth');
    $data['iduser'] = $iduser;

    // Buat array $data berdasarkan parameter yang diterima dari URL
    $data = array(
        'invest_id' => $invest_id,
        'status_content' => $status_content,
    );
    $update_status = $this->m_invesment->q_update_status_content($data);
    // var_dump($update_status);die();   

    if ($update_status) {
        echo 'success';
    } else {
        echo 'error';
    }
  }


  public function mppdigital() { 
  	//$this->load->vars($data);
    $js =  "$(document).ready(function() {
               oTable = $('#perizinaninfo').dataTable({
                        \"bJQueryUI\": true,
                        \"sPaginationType\": \"full_numbers\"
               });
            } );
           ";
    $this->template->set_metadata_javascript($js);
    $this->session_info['page_name'] = "Mal Pelayanan Publik Digital Jabar (MPP Digital)";
    $this->template->build('mppdigital', $this->session_info);
  }

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
}