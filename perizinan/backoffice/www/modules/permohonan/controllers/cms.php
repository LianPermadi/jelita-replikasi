<?php

class Cms extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("m_kemitraan");
        $this->load->library('form_validation');
        $this->load->library('upload');
        $this->load->library('pagination');
        $id_auth = $this->session->userdata('user_id');
        if(!$id_auth){
            
            redirect('https://dpmptsp.jabarprov.go.id/jelita/main/kemitraan/login','refresh');
            
        }
        // var_dump($id);die();
        // $this->output->enable_profiler(TRUE);
    }

    public function home()
    {   
        $id_auth = $this->session->userdata('user_id');
        // if ($this->input->post()) {
        //     if ($this->user_model->doLogin()) redirect(site_url('admin'));
        // }
        // $this->load->view("admin/login_page.php");
        $data['id'] = $id_auth;
        $data['page'] = 'index';
        // var_dump('ada');die();
        $this->load->view("admin2/header.php", $data);
        $this->load->view("admin2/index.php", $data);
        $this->load->view("admin2/footer.php", $data);
    }

    public function profile(){
        // $id = base64_decode($id);
        $id = $this->session->userdata("user_id");
        $session = $this->session->userdata("user_id");
        if(empty($session)){
        $this->session->set_flashdata('error', 'Login untuk melihat profil');
        redirect('main/kemitraan/login', 'refresh');
        }
        // if($id == $session){
        $data["page"] = 'profile';
        $carinib = $this->m_kemitraan->get_profile($id);
        if (!empty($carinib)) {
            $data['id'] = $carinib[0]->id; // Mengambil alamat email
            $data['nib'] = $carinib[0]->nib; // Mengambil alamat email
            $data['email'] = $carinib[0]->email; // Mengambil alamat email
            $data['tgl_nib'] = $carinib[0]->tgl_nib; // Mengambil alamat email
            $data['n_perusahaan'] = $carinib[0]->n_perusahaan; // Mengambil alamat email
            $data['status_pm'] = $carinib[0]->status_pm; // Mengambil alamat email
            $data['flag'] = $carinib[0]->flag; // Mengambil alamat email
            $data['jenis_usaha'] = $carinib[0]->jenis_usaha; // Mengambil alamat email
            $data['alamat_perusahaan'] = $carinib[0]->alamat_perusahaan; // Mengambil alamat email
            $data['kabkota'] = $carinib[0]->kabkota; // Mengambil alamat email
            $data['telepon'] = $carinib[0]->telepon; // Mengambil alamat email
            $data['username'] = $carinib[0]->username; // Mengambil alamat email
            $data['password'] = $carinib[0]->password; // Mengambil alamat email
            $data['maps_longitude'] = $carinib[0]->maps_longitude; // Mengambil alamat email
            $data['maps_latitude'] = $carinib[0]->maps_latitude; // Mengambil alamat email
            $data['foto'] = $carinib[0]->foto; // Mengambil alamat email
            $data['sosmed'] = $carinib[0]->sosmed; // Mengambil alamat email
            $data['website'] = $carinib[0]->website; // Mengambil alamat email
            $data['deskripsi'] = $carinib[0]->deskripsi; // Mengambil alamat email
            // var_dump($carinib[0]->nib);die();
            $this->load->view("admin2/header.php", $data);
            $this->load->view('kemitraan/profile_akun', $data);
            $this->load->view("admin2/footer.php", $data);
        }else{
            $this->session->set_flashdata('error', 'NIB Tidak Ditemukan Atau cek kembali nomor induk berusaha anda.');
            redirect('https://dpmptsp.jabarprov.go.id/jelita/main/kemitraan/klaimakun','refresh');
        }
    }
    
    public function edit($id){
        $id = NULL;
        $session = $this->session->userdata("user_id");
        $id = $this->session->userdata("user_id");
        if(empty($session)){
        $this->session->set_flashdata('error', 'Login untuk melihat profil');
        redirect('main/kemitraan/login', 'refresh');
        }
        if($id == $session){
        $data["page"] = 'edit';
        $carinib = $this->m_kemitraan->get_profile($id);
        if (!empty($carinib)) {
            $data['id'] = $carinib[0]->id; // Mengambil alamat email
            $data['nib'] = $carinib[0]->nib; // Mengambil alamat email
            $data['email'] = $carinib[0]->email; // Mengambil alamat email
            $data['tgl_nib'] = $carinib[0]->tgl_nib; // Mengambil alamat email
            $data['n_perusahaan'] = $carinib[0]->n_perusahaan; // Mengambil alamat email
            $data['status_pm'] = $carinib[0]->status_pm; // Mengambil alamat email
            $data['flag'] = $carinib[0]->flag; // Mengambil alamat email
            $data['jenis_usaha'] = $carinib[0]->jenis_usaha; // Mengambil alamat email
            $data['alamat_perusahaan'] = $carinib[0]->alamat_perusahaan; // Mengambil alamat email
            $data['kabkota'] = $carinib[0]->kabkota; // Mengambil alamat email
            $data['telepon'] = $carinib[0]->telepon; // Mengambil alamat email
            $data['username'] = $carinib[0]->username; // Mengambil alamat email
            $data['password'] = $carinib[0]->password; // Mengambil alamat email
            $data['maps_longitude'] = $carinib[0]->maps_longitude; // Mengambil alamat email
            $data['maps_latitude'] = $carinib[0]->maps_latitude; // Mengambil alamat email
            $data['website'] = $carinib[0]->website; // Mengambil alamat email
            $data['deskripsi'] = $carinib[0]->deskripsi; // Mengambil alamat email
            $data['sosmed'] = $carinib[0]->sosmed; // Mengambil alamat email
            $data['foto'] = $carinib[0]->foto; // Mengambil alamat email
            $data['kategori'] = $carinib[0]->kategori; // Mengambil alamat email
            // var_dump($carinib[0]->nib);die();
            $this->load->view("admin2/header.php", $data);
            $this->load->view('kemitraan/edit_profile', $data);
            $this->load->view("admin2/footer", $data);
        }else{
            $this->session->set_flashdata('error', 'NIB Tidak Ditemukan Atau cek kembali nomor induk berusaha anda.');
            redirect('https://dpmptsp.jabarprov.go.id/jelita/main/kemitraan/klaimakun','refresh');
        }
        }else{
            $this->session->set_flashdata('error', 'tidak bisa ');
            redirect('https://dpmptsp.jabarprov.go.id/jelita/main/kemitraan','refresh');
        }
    }

    public function edit_proses(){
        $id = $this->input->post('id');
        $id = $this->session->userdata("user_id");
        $n_perusahaan = $this->input->post('namaPerusahaan');
        $alamat_perusahaan = $this->input->post('alamat');
        $maps_longitude = $this->input->post('maps_longitude');
        $maps_latitude = $this->input->post('maps_latitude');
        $deskripsi = $this->input->post('deskripsi');
        $sosmed = $this->input->post('sosmed');
        $website = $this->input->post('website');
        $skPembentukan = $this->input->post('skPembentukan');
        // $telepon = $this->input->post('telpon');
        $telepon = $this->input->post('telpon');

        // Ekspresi reguler untuk nomor handphone dengan format yang diharapkan
        $pattern = '/^(0|\\+62|62|0)8[0-9]{8,13}$/';
        if (preg_match($pattern, $telepon)) {
            // Nomor handphone sesuai dengan format yang diharapkan
            // Lakukan sesuatu dengan nomor handphone
        } else {
            // Nomor handphone tidak sesuai dengan format yang diharapkan
            $this->session->set_flashdata('error', 'Nomor handphone tidak valid. Silakan masukkan nomor yang benar.');
            redirect('/jelita/main/kemitraan/edit/'. base64_encode($id), 'refresh');
        }
        $email = $this->input->post('email');
        
    // Pastikan folder penyimpanan sudah ada dan memiliki izin yang sesuai
    $upload_path = '/var/www/html/jelita/assets/mitrakasih/img/logo_company/';

    // Periksa apakah folder penyimpanan ada, jika tidak, buat folder tersebut
    // chmod($upload_path, 0777);

    // Mendapatkan informasi file yang diunggah
    $uploaded_file = $_FILES['userfile']['tmp_name'];
    $file_name = $_FILES['userfile']['name'];
    // var_dump($file_name);die();
        if($file_name != NULL || $file_name != ''){
        $file_info = pathinfo($file_name);
        $file_extension = $file_info['extension'];
        $destination = $upload_path . $id.'.'.$file_extension;
        // Pindahkan file yang diunggah ke folder penyimpanan
            if (move_uploaded_file($uploaded_file, $destination)) {
                // File berhasil diunggah
                echo "File berhasil diunggah.";
            } else {
                // Handle jika unggahan gagal
                echo "Gagal mengunggah file.";
            }
        // var_dump($destination);die();
            // chmod($upload_path, 0755);
            $save = $this->m_kemitraan->put_profile_foto($id, $n_perusahaan, $alamat_perusahaan, $maps_longitude, $maps_latitude, $deskripsi, $sosmed, $website, $skPembentukan, $telepon, $email, $file_extension);
        // var_dump($save);die();
            if($save){
                $this->session->set_flashdata('success', 'Edit Berhasil');
                redirect('/main/kemitraan/profile/'. base64_encode($id), 'refresh');
            }else{
                $this->session->set_flashdata('success', 'Ada Kesalahan saat menyimpan data');
                redirect('/main/kemitraan/profile/'. base64_encode($id), 'refresh');
            }
        }else{
            // chmod($upload_path, 0755);
            $save = $this->m_kemitraan->put_profile($id, $n_perusahaan, $alamat_perusahaan, $maps_longitude, $maps_latitude, $deskripsi, $sosmed, $website, $skPembentukan, $telepon, $email);
        // var_dump($save);die();
            if($save){
                $this->session->set_flashdata('success', 'Edit Berhasil');
                redirect('/main/kemitraan/profile/'. base64_encode($id), 'refresh');
            }else{
                $this->session->set_flashdata('success', 'Ada Kesalahan saat menyimpan data');
                redirect('/main/kemitraan/profile/'. base64_encode($id), 'refresh');
            }
        }
    }

    public function test1()
    {   
        // 
        $id_auth = $this->session->userdata('user_id');
        // if ($this->input->post()) {
        //     if ($this->user_model->doLogin()) redirect(site_url('admin'));
        // }
        // $this->load->viewtestadmin/login_page.php");
        $data['id'] = $id_auth;
        $data['page'] = 'index';
        $this->load->view("admin2/header.php", $data);
        $this->load->view("admin2/index.php", $data);
        $this->load->view("admin2/footer.php", $data);
    }

    public function pages_account_settings_account($id)
    {   
        // 
        $id_auth = $this->session->userdata('user_id');
        // if ($this->input->post()) {
        //     if ($this->user_model->doLogin()) redirect(site_url('admin'));
        // }
        // $this->load->view("admin/login_page.php");
        $data['id'] = $id_auth;
        $data['page'] = 'pages_account_settings_account';
        $this->load->view("admin2/header.php", $data);
        $this->load->view("admin2/pages_account_settings_account.php", $data);
        $this->load->view("admin2/footer.php", $data);
    }

    public function pages_account_settings_notifications()
    {   
        // 
        $id_auth = $this->session->userdata('user_id');
        // if ($this->input->post()) {
        //     if ($this->user_model->doLogin()) redirect(site_url('admin'));
        // }
        // $this->load->view("admin/login_page.php");
        $data['id'] = $id_auth;
        $data['page'] = 'pages_account_settings_notifications';
        $this->load->view("admin2/header.php", $data);
        $this->load->view("admin2/pages_account_settings_notifications.php", $data);
        $this->load->view("admin2/footer.php", $data);
    }

    public function pages_account_settings_connections($id)
    {   
        // 
        $id_auth = $this->session->userdata('user_id');
        // if ($this->input->post()) {
        //     if ($this->user_model->doLogin()) redirect(site_url('admin'));
        // }
        // $this->load->view("admin/login_page.php");
        $data['id'] = $id_auth;
        $data['page'] = 'pages_account_settings_connections';
        $this->load->view("admin2/header.php", $data);
        $this->load->view("admin2/pages_account_settings_connections.php", $data);
        $this->load->view("admin2/footer.php", $data);
    }

    public function produk()
    {   
        
        $id_auth = $this->session->userdata('user_id');
        $produk = $this->m_kemitraan->get_data_produk($id_auth);      
        $json = json_encode($produk);
        $kategori = $this->m_kemitraan->get_kategori(); 
        // $kategori = json_encode($kategorikategori);
        $data['kategori'] = $kategori;
        // var_dump($json);die();
        
        $data['id'] = $id_auth;
        $data['page'] = 'banner';
        $data['page_header'] = 'produk';
        $data['produk'] = $produk;
        $this->load->view("admin2/header.php", $data);
        $this->load->view("admin2/produk.php", $data);
        $this->load->view("admin2/footer.php", $data);

            // $id_auth = $this->session->userdata('user_id');
            // $config = array();
            // $config["base_url"] = base_url() . "main/cms/produk";
            // $config["total_rows"] = $this->m_kemitraan->count_data_produk($id_auth);
            // $config["per_page"] = 10; // Jumlah item per halaman
            // $config["uri_segment"] = 3; // Ubah ini sesuai dengan segmen URI Anda
            // $config['use_page_numbers'] = TRUE;

            // $this->pagination->initialize($config);

            // $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            // $data["produk"] = $this->m_kemitraan->get_data_produk_paginated($id_auth, $config["per_page"], $page);

            // $data['id'] = $id_auth;
            // $data['page'] = 'banner';

            // $data['links'] = $this->pagination->create_links();

            // $this->load->view("admin2/header.php", $data);
            // $this->load->view("admin2/produk.php", $data);
            // $this->load->view("admin2/footer.php", $data);
    }

    public function detail_produk($id) {
        $data['page_header'] = 'Detail Produk';
        $data['page'] = 'Detail Produk';
        $id_auth = $this->session->userdata('user_id');
        if(!$id_auth){
            
            redirect('https://dpmptpsp.jabarprov.go.id/jelita/main/kemitraan/login','refresh');
            
        }
        $data['id'] = $id_auth;
        $produk = $this->m_kemitraan->get_data_produk_id($id);
        $data['detail_produk'] = $produk;
        $kategori = $this->m_kemitraan->get_kategori();    
        $data['kategori'] = $kategori;
        
        $this->load->view("admin2/header.php", $data);
        $this->load->view("admin2/edit_produk.php", $data);
        $this->load->view("admin2/footer.php", $data);
    }

    public function tambah_produk()
    {   
        
        $id_auth = $this->session->userdata('user_id');
        $kategori = $this->m_kemitraan->get_kategori();
        $data['id'] = $id_auth;
        $data['page'] = 'edit_produk';
        $data['detail_produk'] = '';
        $data['kategori'] = $kategori;
        $this->load->view("admin2/header.php", $data);
        $this->load->view("admin2/new_produk.php", $data);
        $this->load->view("admin2/footer.php", $data);
    }

    public function save()
    {   
        
        $id_auth = $this->session->userdata('user_id');
        // input post
        $id = $this->input->post('id');
        $nama = $this->input->post('nama');
        $harga = $this->input->post('harga');
        $reviews = $this->input->post('reviews');
        $keterangan = $this->input->post('keterangan');
        $availability = $this->input->post('availability');
        $shipping = $this->input->post('shipping');
        $weight = $this->input->post('weight');
        $foto = $this->input->post('foto');
        $deskripsi = $this->input->post('deskripsi');
        $informasi = $this->input->post('informasi');
        $kategori = $this->input->post('kategori');
        // end post

        // Olah data Array
        
        // end olah data

        // upload foto
        // foreach ($foto as $row) {

            $file = $_FILES["foto"]["name"];
            $foto_string = implode("^", $file);
            // var_dump($file);die();
            $foto_text = '';
            $no = 1;
            foreach ($file as $row => $name) {
            // String asal
            $originalString = $nama.'_'.$kategori.'_'.$no;
            // Karakter atau string yang ingin Anda cari untuk menggantinya
            $search = ' ';
            // Karakter atau string yang akan menggantikan karakter atau string yang ditemukan
            $replace = '';
            // Menggunakan str_replace() untuk mengganti karakter atau string
            $modifiedString = str_replace($search, $replace, $originalString);
            
            $file = $name;
            $ext = pathinfo($name, PATHINFO_EXTENSION);
            $file_tmp = $_FILES['foto']['tmp_name'][$row];
            $file_name = basename($name);
            $target_dir = "/var/www/html/jelita/assets/mitrakasih/img/product/details/";
            // chmod($target_dir, 0777);
            $target_file = $target_dir . $file_name;
            $nama_file = $modifiedString.'_'.date('YmdGis').'.'.$ext;
            $fileBaru = $target_dir.$nama_file;
            $upload = move_uploaded_file($file_tmp, $fileBaru);
            // var_dump($upload);die();
            // chmod($target_dir, 0755);
            $foto_text = $foto_text.$nama_file.'^';
            var_dump($no);
            $no = $no + 1;
            }
            // echo $foto_text.' - '.$no;die();

        // }
        // end upload foto

        // finishing to database
        $save = $this->m_kemitraan->tambah_produk($nama, $harga, $reviews, $keterangan, $availability, $shipping, $weight, $deskripsi, $informasi, $kategori, $foto_text, $id_auth);
        if($save){
            $this->session->set_flashdata('sukses', "Barang Berhasil Di Edit");
            redirect('/main/cms/produk');
        }else{
            $this->session->set_flashdata('gagal', "Barang Gagal Di Edit");
            redirect('/main/cms/produk');
        }
        // ending
    }

    public function edit_produk($id)
    {   
        // 
        $id_auth = $this->session->userdata('user_id');
        // if ($this->input->post()) {
        //     if ($this->user_model->doLogin()) redirect(site_url('admin'));
        // }
        $detail_produk = $this->m_kemitraan->get_data_by_id($id);
        $kategori = $this->m_kemitraan->get_kategori();
        $data['id'] = $id_auth;
        $data['page'] = 'edit_produk';
        $data['detail_produk'] = $detail_produk;
        $data['kategori'] = $kategori;
        // $this->load->view("admin/login_page.php");
        $this->load->view("admin2/header.php", $data);
        $this->load->view("admin2/edit_produk.php", $data);
        $this->load->view("admin2/footer.php", $data);
    }

    public function update($id)
    {   
        // 
        $id_auth = $this->session->userdata('user_id');
        // input post
        $nama = $this->input->post('nama');
        $harga = $this->input->post('harga');
        $reviews = $this->input->post('reviews');
        $keterangan = $this->input->post('keterangan');
        $availability = $this->input->post('availability');
        $shipping = $this->input->post('shipping');
        $weight = $this->input->post('weight');
        $foto = $this->input->post('foto');
        $deskripsi = $this->input->post('deskripsi');
        $informasi = $this->input->post('informasi');
        $kategori = $this->input->post('kategori');

        // Olah data Array
        $data = $this->m_kemitraan->get_data_by_id($id);
        $foto_string = implode("^", $foto);
        $data1 = $data[0]->foto;
        // end data array

        // eksekusi data
        $update = $this->m_kemitraan->update_produk($id, $nama, $harga, $reviews, $keterangan, $availability, $shipping, $weight, $deskripsi, $informasi, $kategori, $foto_string);
        if($update){
        $this->session->set_flashdata('sukses', "Barang Berhasil Di Edit");
        redirect('/main/cms/produk');
        }else{
        $this->session->set_flashdata('gagal', "Barang Gagal Di Edit");
        redirect('/main/cms/produk');
        }
        // ending
    }

    public function hapus_produk($id)
    {   
        // 
        $id_auth = $this->session->userdata('user_id');
        $hapus_data = $this->m_kemitraan->hapus_produk($id);
        if($hapus_data){
            $this->session->set_flashdata('sukses', "Barang Berhasil Di Hapus");
            redirect('/main/cms/produk');
        }else{
            $this->session->set_flashdata('gagal', "Barang Gagal Di Hapus");
            redirect('/main/cms/produk');
        }
    }

    public function auth_login_basic()
    {   
        // 
        $id_auth = $this->session->userdata('user_id');
        // if ($this->input->post()) {
        //     if ($this->user_model->doLogin()) redirect(site_url('admin'));
        // }
        // $this->load->view("admin/login_page.php");
        $data['page'] = 'auth_login_basic';
        $data['id'] = $id_auth;
        // $this->load->view("admin2/header.php", $data);
        $this->load->view("admin2/auth-login-basic.php", $data);
        // $this->load->view("admin2/footer.php", $data);
    }

    public function auth_register_basic($id)
    {   
        // 
        $id_auth = $this->session->userdata('user_id');
        // if ($this->input->post()) {
        //     if ($this->user_model->doLogin()) redirect(site_url('admin'));
        // }
        // $this->load->view("admin/login_page.php");
        $data['page'] = 'auth_register_basic';
        $data['id'] = $id_auth;
        // $this->load->view("admin2/header.php", $data);
        $this->load->view("admin2/auth_register_basic.php", $data);
        // $this->load->view("admin2/footer.php", $data);
    }

    public function pages_misc_error($id)
    {   
        // 
        $id_auth = $this->session->userdata('user_id');
        // if ($this->input->post()) {
        //     if ($this->user_model->doLogin()) redirect(site_url('admin'));
        // }
        // $this->load->view("admin/login_page.php");
        $data['page'] = 'pages_misc_error';
        $data['id'] = $id_auth;
        // $this->load->view("admin2/header.php", $data);
        $this->load->view("admin2/pages_misc_error.php", $data);
        // $this->load->view("admin2/footer.php", $data);
    }

    public function pages_misc_under_maintenance()
    {   
        // 
        $id_auth = $this->session->userdata('user_id');
        // if ($this->input->post()) {
        //     if ($this->user_model->doLogin()) redirect(site_url('admin'));
        // }
        // $this->load->view("admin/login_page.php");
        $data['page'] = 'pages_misc_error';
        $data['id'] = $id_auth;
        // $this->load->view("admin2/header.php", $data);
        $this->load->view("admin2/pages_misc_under_maintenance.php", $data);
        // $this->load->view("admin2/footer.php", $data);
    }

    public function cards_basic()
    {   
        // 
        $id_auth = $this->session->userdata('user_id');
        // if ($this->input->post()) {
        //     if ($this->user_model->doLogin()) redirect(site_url('admin'));
        // }
        // $this->load->view("admin/login_page.php");
        $data['page'] = 'cards_basic';
        $data['id'] = $id_auth;
        $this->load->view("admin2/header.php", $data);
        $this->load->view("admin2/cards_basic.php", $data);
        $this->load->view("admin2/footer.php", $data);
    }

    public function ui_accordion()
    {   
        // 
        $id_auth = $this->session->userdata('user_id');
        // if ($this->input->post()) {
        //     if ($this->user_model->doLogin()) redirect(site_url('admin'));
        // }
        // $this->load->view("admin/login_page.php");
        $data['page'] = 'ui_accordion';
        $data['id'] = $id_auth;
        $this->load->view("admin2/header.php", $data);
        $this->load->view("admin2/ui_accordion.php", $data);
        $this->load->view("admin2/footer.php", $data);
    }

    public function ui_alerts()
    {   
        // 
        $id_auth = $this->session->userdata('user_id');
        // if ($this->input->post()) {
        //     if ($this->user_model->doLogin()) redirect(site_url('admin'));
        // }
        // $this->load->view("admin/login_page.php");
        $data['page'] = 'ui_alerts';
        $data['id'] = $id_auth;
        $this->load->view("admin2/header.php", $data);
        $this->load->view("admin2/ui_alerts.php", $data);
        $this->load->view("admin2/footer.php", $data);
    }

    public function ui_badges()
    {   
        // 
        $id_auth = $this->session->userdata('user_id');
        // if ($this->input->post()) {
        //     if ($this->user_model->doLogin()) redirect(site_url('admin'));
        // }
        // $this->load->view("admin/login_page.php");
        $data['page'] = 'ui_badges';
        $data['id'] = $id_auth;
        $this->load->view("admin2/header.php", $data);
        $this->load->view("admin2/ui_badges.php", $data);
        $this->load->view("admin2/footer.php", $data);
    }

    public function auth_forgot_password_basic()
    {   
        // 
        $id_auth = $this->session->userdata('user_id');
        // if ($this->input->post()) {
        //     if ($this->user_model->doLogin()) redirect(site_url('admin'));
        // }
        // $this->load->view("admin/login_page.php");
        $data['page'] = 'auth_forgot_password_basic';
        $data['id'] = $id_auth;
        // $this->load->view("admin2/header.php", $data);
        $this->load->view("admin2/auth_forgot_password_basic.php", $data);
        // $this->load->view("admin2/footer.php", $data);
    }

    public function layoutswithoutmenu()
    {   
        // 
        $id_auth = $this->session->userdata('user_id');
        // if ($this->input->post()) {
        //     if ($this->user_model->doLogin()) redirect(site_url('admin'));
        // }
        // $this->load->view("admin/login_page.php");
        $data['page'] = 'without-menu';
        $data['id'] = $id_auth;
        $this->load->view("admin2/header.php", $data);
        $this->load->view("admin2/layouts-without-menu.php", $data);
        $this->load->view("admin2/footer.php", $data);
    }

    public function logout()
    {
        // 
        $id_auth = $this->session->userdata('user_id');
        $this->session->sess_destroy();
        redirect(site_url('admin/login'));
    }

    public function test()
    {
        // 
        $id_auth = $this->session->userdata('user_id');
        $this->output->set_content_type('application/json')->set_output(json_encode(array('foo' => 'bar')));
    }
}
