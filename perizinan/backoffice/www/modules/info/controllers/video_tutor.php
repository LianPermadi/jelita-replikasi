<?php

/**
   * Description of Informasi Perizinan
   * @author agusnur ; Created : 08 Okt 2010
   * @edit PBS       ; Created : 22 Ags 2023
*/

class video_tutor extends WRC_AdminCont {

  public function __construct() {
    parent::__construct();
    $enabled = FALSE;
    //$list_auths = $this->session_info['app_list_auth'];
    $this->load->model("m_video_tutor");
    $this->load->model("m_mobil");
    $this->load->library('upload'); // Load library upload
    
    //foreach ($list_auths as $list_auth) {
      //if($list_auth->id_role === '17') {
        $enabled = TRUE;
      //}
    //}
    
    if(!$enabled) {
      redirect('dashboard');
    }
  }

//   public function index() {
//     //$data['list'] = $this->perizinan->where('c_online',0)->order_by('kd_izin', 'ASC')->get();
//     //$data['list_izin'] = $this->perizinan->get_list();
//     //$this->load->vars($data);
//     $js =  "$(document).ready(function() {
//                oTable = $('#perizinaninfo').dataTable({
//                         \"bJQueryUI\": true,
//                         \"sPaginationType\": \"full_numbers\"
//                });
//             } );
//            ";
//     $this->template->set_metadata_javascript($js);
//     $this->session_info['page_name'] = "Fitur-Fitur Administrasi Perkantoran DPMPTSP";
//     $this->template->build('f_video_tutor/v_video_tutor', $this->session_info);
//   }
  
    public function index()
    {
        $this->peminjamanmobil = FALSE;
        $this->All = FALSE;
        $list_auths = $this->session_info['app_list_auth'];
        foreach ($list_auths as $list_auth) {
            if ($list_auth->id_role === '49') {
                $this->peminjamanmobil = TRUE;
            }
            if ($list_auth->id_role === '18') {
                $this->All = TRUE;
            }
        }

        // if (!$this->peminjamanmobil) {
        //     redirect('dashboard');
        // }
        $videos = $this->m_video_tutor->get_all_videos();
        $data['langkah'] = 1;
        $data['page'] = 1;
        $data['button'] = 'mobil';
        $data['videos'] = $videos;
        $data['role_admin'] = $this->All;

        // var_dump($data['videos']);die();
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
        $this->session_info['page_name'] = "Sitem Informasi Video Tutorial";
        $this->template->build('f_video_tutor/v_video_tutor', $this->session_info);
    }
    public function list_video()
    {
        $this->peminjamanmobil = FALSE;
        $this->All = FALSE;
        $list_auths = $this->session_info['app_list_auth'];
        foreach ($list_auths as $list_auth) {
            if ($list_auth->id_role === '49') {
                $this->peminjamanmobil = TRUE;
            }
            if ($list_auth->id_role === '18') {
                $this->All = TRUE;
            }
        }

        // if (!$this->peminjamanmobil) {
        //     redirect('dashboard');
        // }
        $videos = $this->m_video_tutor->get_all_videos_list();
        $data['langkah'] = 1;
        $data['page'] = 1;
        $data['button'] = 'mobil';
        $data['videos'] = $videos;
        $data['role_admin'] = $this->All;

        // var_dump($data['videos']);die();
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
        $this->session_info['page_name'] = "Sitem Informasi Video Tutorial";
        $this->template->build('f_video_tutor/v_list_table_video_tutorial', $this->session_info);
    }
    public function Form_Tambah_Data_Video()
    {
        $this->peminjamanmobil = FALSE;
        $this->All = FALSE;
        $list_auths = $this->session_info['app_list_auth'];
        foreach ($list_auths as $list_auth) {
            if ($list_auth->id_role === '49') {
                $this->peminjamanmobil = TRUE;
            }
            if ($list_auth->id_role === '18') {
                $this->All = TRUE;
            }
        }

        if (!$this->peminjamanmobil) {
            redirect('dashboard');
        }
        $id_user = $this->session->userdata('id_auth');
        $data['user'] = $this->m_mobil->get_pegawai_user($id_user);
        $data['barang'] = array();
        $data['step'] = "add_mobil";

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
        $this->session_info['page_name'] = "Tambah Data Video Tutorial";
        $this->template->build('f_video_tutor/v_form_tambah_data', $this->session_info);
    }

    public function upload() {
        // Konfigurasi upload file
        $upload_path = FCPATH . 'www/modules/info/assets/file_video_tutor/';
    
        // Pastikan folder sudah ada, jika tidak, buat folder
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0755, true); // Buat folder dengan permission 0755
        }
    
        // Pastikan folder dapat ditulisi
        if (!is_writable($upload_path)) {
            $this->session->set_flashdata('gagal', 'Folder upload tidak dapat diakses atau tidak dapat ditulisi.');
            redirect('info/video_tutor/Form_Tambah_Data_Video');
            return;
        }
    
        // Cek apakah ada file yang diupload
        if (isset($_FILES['file_video']) && $_FILES['file_video']['error'] == UPLOAD_ERR_OK) {
            $file_name = $_FILES['file_video']['name'];
            $file_tmp = $_FILES['file_video']['tmp_name'];
            $file_size = $_FILES['file_video']['size'];
            $file_type = pathinfo($file_name, PATHINFO_EXTENSION);
    
            // Cek tipe file yang diizinkan
            $allowed_types = ['mp4', 'avi', 'mov', 'wmv'];
            if (!in_array($file_type, $allowed_types)) {
                $this->session->set_flashdata('gagal', 'Tipe file tidak diizinkan.');
                redirect('info/video_tutor/Form_Tambah_Data_Video');
                return;
            }
    
            // Cek ukuran file (jika Anda ingin membatasi ukuran)
            // if ($file_size > 104857600) { // 100 MB
            //     $this->session->set_flashdata('gagal', 'Ukuran file terlalu besar.');
            //     redirect('info/video_tutor/Form_Tambah_Data_Video');
            //     return;
            // }
    
            // Pindahkan file ke folder upload
            if (move_uploaded_file($file_tmp, $upload_path . $file_name)) {
                // Jika upload berhasil, simpan informasi file dan data form ke database
                $data = array(
                    'video_title' => $this->input->post('video_title'),
                    'file_video' => $file_name,
                    'description' => $this->input->post('description'),
                    'status' => $this->input->post('status')
                );
    
                // Simpan ke database
                $insert_id = $this->m_video_tutor->insert_video($data);
                if ($insert_id) {
                    $this->session->set_flashdata('sukses', 'Video berhasil diunggah!');
                } else {
                    $this->session->set_flashdata('gagal', 'Gagal menyimpan video!');
                }
            } else {
                $this->session->set_flashdata('gagal', 'Gagal mengunggah file.');
            }
            
            redirect('info/video_tutor/Form_Tambah_Data_Video');
        } else {
            $this->session->set_flashdata('gagal', 'Tidak ada file yang diunggah.');
            redirect('info/video_tutor/Form_Tambah_Data_Video');
        }
    }
    public function edit_video($id) {
        // Memeriksa otorisasi pengguna
        $this->peminjamanmobil = FALSE;
        $this->All = FALSE;
        $list_auths = $this->session_info['app_list_auth'];
        foreach ($list_auths as $list_auth) {
            if ($list_auth->id_role === '49') {
                $this->peminjamanmobil = TRUE;
            }
            if ($list_auth->id_role === '18') {
                $this->All = TRUE;
            }
        }
    
        // Redirect jika tidak memiliki izin
        if (!$this->peminjamanmobil) {
            redirect('dashboard');
        }
        // $data['user'] = $this->m_mobil->get_pegawai_user($id_user);
    
        // Mengambil data pengguna
        // Mengambil data video berdasarkan ID
        $data['video'] = $this->m_video_tutor->get_video_by_id($id);
        // var_dump($data['video']);die();
        // Memeriksa apakah video ditemukan
        if (empty($data['video'])) {
            show_404(); // Tampilkan halaman 404 jika video tidak ditemukan
        }
    
        // Menyiapkan skrip JavaScript untuk halaman
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
        ";
    
        // Menyimpan metadata JavaScript
        $this->template->set_metadata_javascript($js);
        
        // Mengatur nama halaman
        $this->session_info['page_name'] = "Edit Data Video Tutorial";
    
        // Memuat view dengan data video
        $this->load->vars($data);
        $this->template->build('f_video_tutor/v_form_edit_data', $this->session_info);
    }
    public function update() {
        $id = $this->input->post('id');
        $data = array(
            'video_title' => $this->input->post('video_title'),
            'description' => $this->input->post('description'),
            'status' => $this->input->post('status')
        );
        // Tentukan path upload
        $upload_path = FCPATH . 'www/modules/info/assets/file_video_tutor/';
    
        // Cek apakah ada file video yang diunggah
        if (isset($_FILES['file_video']) && $_FILES['file_video']['error'] == UPLOAD_ERR_OK) {
            $file_name = $_FILES['file_video']['name'];
            $file_tmp = $_FILES['file_video']['tmp_name'];
            $file_size = $_FILES['file_video']['size'];
            $file_type = pathinfo($file_name, PATHINFO_EXTENSION);
    
            // Cek tipe file yang diizinkan
            $allowed_types = ['mp4', 'avi', 'mov', 'wmv'];
            if (!in_array($file_type, $allowed_types)) {
                $this->session->set_flashdata('gagal', 'Tipe file tidak diizinkan.');
                redirect('info/video_tutor/Form_Tambah_Data_Video');
                return;
            }
    
            // Pindahkan file ke folder upload
            if (move_uploaded_file($file_tmp, $upload_path . $file_name)) {
                // Jika upload berhasil, tambahkan file_video ke data
                $data['file_video'] = $file_name;
            } else {
                $this->session->set_flashdata('gagal', 'Gagal mengunggah file.');
                redirect('info/video_tutor/Form_Tambah_Data_Video');
                return;
            }
        }
        // var_dump($data);die();
    
        // Proses pembaruan data
        if ($this->m_video_tutor->update_video($id, $data)) {

            $this->session->set_flashdata('sukses', 'Video berhasil diperbarui!');
        } else {

            $this->session->set_flashdata('gagal', 'Gagal memperbarui video!');
        }
    
        redirect('info/video_tutor/');
    }
    
    
    
    
    public function delete($id) {
        // Hapus video berdasarkan ID
        $video = $this->m_video_tutor->get_video_by_id($id);
        if ($video) {
            // Hapus file video dari direktori
            unlink('./uploads/videos/' . $video['file_video']);
            // Hapus dari database
            $this->m_video_tutor->delete_video($id);
            $this->session->set_flashdata('sukses', 'Video berhasil dihapus!');
        } else {
            $this->session->set_flashdata('gagal', 'Video tidak ditemukan!');
        }
        redirect('video_tutorials');
    }

}