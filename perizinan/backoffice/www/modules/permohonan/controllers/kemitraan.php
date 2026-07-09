<?php


class Kemitraan extends MY_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->model("m_kemitraan");
        $this->load->helper('download');
        $this->load->library('curl');
        $this->load->library('pagination');
        $otherdb = $this->load->database('otherdb', TRUE);
        $this->load->library('xml_parsing_win');
        $this->load->library('session');
        $sql = "select settings.status from settings where name='smsGateway'";
        $a = $otherdb->query($sql)->first_row();
        $this->kdsms = $a->status;
        $sql = "select settings.status from settings where name='send_mail'";
        $a = $otherdb->query($sql)->first_row();
        $this->kdmail = $a->status;
        $this->load->library('cfpdf');
        
        $this->konfig_izin = $otherdb->get_where("settings",array('name'=>'akses_izin'))->first_row();
    }

    public function index()
    {   
        $data["page_header"] = 'index';
        $kategori = $this->m_kemitraan->get_kategori_limit();
        $get = $this->m_kemitraan->get_data_index();
        $latest = $this->m_kemitraan->get_data_latest();
        $top = $this->m_kemitraan->get_data_toprate();
        $review = $this->m_kemitraan->get_data_review();
        $data["kategori"] = $kategori;
        $data["get"] = $get;
        $data["latest"] = $latest;
        $data["top"] = $top;
        $data["review"] = $review;
        $id_auth = $this->session->userdata('user_id');
        // $data["user"] = $user;
        $this->load->view("kemitraan/head", $data);
        $this->load->view("kemitraan/index", $data);
        $this->load->view("kemitraan/footer", $data);
    }

   
  public function register() {
    $data["page_header"] = 'register';
    $session = $this->session->userdata("user_id");
    $otherdb = $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
    
    if(!empty($session)){
      redirect('main/user', 'refresh');
    }
    
    $provinsi = $otherdb->query('select * from trpropinsi order by n_propinsi')->result();
    $kabupaten = $otherdb->query("select * from trkabupaten where kd_prov='12' order by n_kabupaten")->result();
    
    $data['menu'] = $this->load->view('parsing/menu_right', '', true);
    $data['menu1'] = $this->load->view('parsing/menu_right_2', '', true);
    $data['isi'] = "isi_pendaftaranbaru";
    $data['provinsi'] = $provinsi;
    $data['kabupaten'] = $kabupaten;
    $data['sms'] = $this->kdsms;
    $data['mail'] = $this->kdmail;
    $data['notif'] = "Mohon Maaf, Sedang Perbaikan Sistem<br>Proses Permohonan Izin Online melalui JELITA Jabar Kami Tutup<br>";
    $this->load->view("kemitraan/head", $data);
    $this->load->view('kemitraan/register', $data);
    $this->load->view("kemitraan/footer", $data);
  }

    public function login() {
        $data['page_header'] = 'Login';
        if($this->session->set_userdata('user_id')){
            redirect('https://dpmptsp.jabarprov.go.id/jelita/main/kemitraan'); // Ganti dengan URL halaman setelah login
        }
        $this->load->view("kemitraan/head", $data);
        $this->load->view('kemitraan/login', $data);
        $this->load->view("kemitraan/footer", $data);
    }

    public function dologin(){
            $username = $this->input->post('username');
            $password = md5($this->input->post('password')); // Anda dapat menggunakan hashing yang lebih kuat.
            $user = $this->m_kemitraan->loginUser($username, $password);
            // var_dump($user);die();
            if ($user == TRUE) {
                $user_login = $this->m_kemitraan->getsession($username, $password);
                $this->session->set_userdata('user_id', $user_login[0]->id);
                // var_dump($r);die();
                redirect('https://dpmptsp.jabarprov.go.id/jelita/main/kemitraan'); // Ganti dengan URL halaman setelah login
            } else {
                $this->session->set_flashdata('error', 'Username atau password salah.');
                redirect('main/kemitraan/login');
            }

    }
    
    public function logout() {
        // Hapus sesi yang berhubungan dengan login (misalnya, user_id)
		$this->session->unset_userdata('userlogin');
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('nama');
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('login');
        $this->session->unset_userdata('id');
        // var_dump($this->session->unset_userdata('user_id'));die();

        // Hapus semua sesi
        $this->session->sess_destroy();
        // var_dump($this->session->sess_destroy());die();

        $this->session->set_flashdata('success', 'Berhasil Keluar');
        // Redirect pengguna ke halaman login atau halaman lain yang sesuai
        redirect('main/kemitraan/login');
    }

    public function klaimakun() {
        $data["page_header"] = 'klaimakun';
        $session = $this->session->userdata("userlogin");
        $otherdb = $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
        
        if(!empty($session)){
        redirect('main/user', 'refresh');
        }
        
        $provinsi = $otherdb->query('select * from trpropinsi order by n_propinsi')->result();
        $kabupaten = $otherdb->query("select * from trkabupaten where kd_prov='12' order by n_kabupaten")->result();
        
        $data['menu'] = $this->load->view('parsing/menu_right', '', true);
        $data['menu1'] = $this->load->view('parsing/menu_right_2', '', true);
        $data['isi'] = "isi_pendaftaranbaru";
        $data['provinsi'] = $provinsi;
        $data['kabupaten'] = $kabupaten;
        $data['sms'] = $this->kdsms;
        $data['mail'] = $this->kdmail;
        $data['notif'] = "Mohon Maaf, Sedang Perbaikan Sistem<br>Proses Permohonan Izin Online melalui JELITA Jabar Kami Tutup<br>";
        $this->load->view("kemitraan/head", $data);
        $this->load->view('kemitraan/klaimakun', $data);
        $this->load->view("kemitraan/footer", $data);
    }

    public function nibget(){
        $data["page_header"] = 'profile';
        $nib = $this->input->post('nib');
        $carinib = $this->m_kemitraan->get_nib($nib);
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
            $this->load->view("kemitraan/head", $data);
            $this->load->view('kemitraan/profile', $data);
            $this->load->view("kemitraan/footer", $data);
        }else{
            $this->session->set_flashdata('error', 'NIB Tidak Ditemukan Atau cek kembali nomor induk berusaha anda.');
            redirect('https://dpmptsp.jabarprov.go.id/jelita/main/kemitraan/pengembangan','refresh');
        }
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
        $data["page_header"] = 'profile';
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
            $this->load->view("kemitraan/head", $data);
            $this->load->view('kemitraan/profile_akun', $data);
            $this->load->view("kemitraan/footer", $data);
        }else{
            $this->session->set_flashdata('error', 'NIB Tidak Ditemukan Atau cek kembali nomor induk berusaha anda.');
            redirect('https://dpmptsp.jabarprov.go.id/jelita/main/kemitraan/klaimakun','refresh');
        }
    }
    
    public function edit($id){
        $id = base64_decode($id);
        $session = $this->session->userdata("user_id");
        if(empty($session)){
        $this->session->set_flashdata('error', 'Login untuk melihat profil');
        redirect('main/kemitraan/login', 'refresh');
        }
        if($id == $session){
        $data["page_header"] = 'edit';
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
            $this->load->view("kemitraan/head", $data);
            $this->load->view('kemitraan/edit_profile', $data);
            $this->load->view("kemitraan/footer", $data);
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
                redirect('/main/cms/profile/'. base64_encode($id), 'refresh');
            }else{
                $this->session->set_flashdata('success', 'Ada Kesalahan saat menyimpan data');
                redirect('/main/cms/profile/'. base64_encode($id), 'refresh');
            }
        }else{
            // chmod($upload_path, 0755);
            $save = $this->m_kemitraan->put_profile($id, $n_perusahaan, $alamat_perusahaan, $maps_longitude, $maps_latitude, $deskripsi, $sosmed, $website, $skPembentukan, $telepon, $email);
        // var_dump($save);die();
            if($save){
                $this->session->set_flashdata('success', 'Edit Berhasil');
                redirect('/main/cms/profile/'. base64_encode($id), 'refresh');
            }else{
                $this->session->set_flashdata('success', 'Ada Kesalahan saat menyimpan data');
                redirect('/main/cms/profile/'. base64_encode($id), 'refresh');
            }
        }
    }

    public function cek_nib() {
        $nib = $this->input->post('nib');
        $carinib = $this->m_kemitraan->get_nib($nib);
        if (!empty($carinib)) {
            $id = $carinib[0]->id; // Mengambil alamat email
            $nib = $carinib[0]->nib; // Mengambil alamat email
            $email = $carinib[0]->email; // Mengambil alamat email
            $tgl_nib = $carinib[0]->tgl_nib; // Mengambil alamat email
            $n_perusahaan = $carinib[0]->n_perusahaan; // Mengambil alamat email
            $status_pm = $carinib[0]->status_pm; // Mengambil alamat email
            $flag = $carinib[0]->flag; // Mengambil alamat email
            $jenis_usaha = $carinib[0]->jenis_usaha; // Mengambil alamat email
            $alamat_perusahaan = $carinib[0]->alamat_perusahaan; // Mengambil alamat email
            $kabkota = $carinib[0]->kabkota; // Mengambil alamat email
            $telepon = $carinib[0]->telepon; // Mengambil alamat email
            $username = $carinib[0]->username; // Mengambil alamat email
            $password = $carinib[0]->password; // Mengambil alamat email
        if($username == NULL || $username == ''){
    
        $token = 'hesoyam';
        $telp_pemohon = $telepon;
        $telp_pemegang_kuasa = $telepon;
        $string  = $n_perusahaan;
        $search	 = array('CV.', 'PT.','CV','PT');
        $replace = "";
        $string  = str_replace($search, $replace, $string);
        $string  = str_replace(' ', '', $string);                 // Replaces all spaces with hyphens.
        $string  = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
        $string  = strtolower(preg_replace('/-+/', '', $string));
        
        function cekusername($string){
          $token = substr(str_shuffle("1234567890abcdefghijklmnopqrstuvwxyz"), 0, 3);
          $uname = $string."".$token;
          return $uname;
        }
        $string	= cekusername($string);
        $passworduser = substr(str_shuffle("1234567890abcdefghijklmnopqrstuvwxyz"), 0, 6);
        $password_akun = md5($passworduser); // Anda dapat menggunakan hashing yang lebih kuat.
        // $password_akun = md5($passworduser, PASSWORD_DEFAULT);
        $savee = $this->m_kemitraan->insert_akun($id, $string, $password_akun);
              
        ///// KIRIM E-MAIL
        $base_url         = 'assets/pendaftaran/';
        require_once("".$base_url."back/plugins/phpmailer/class.phpmailer.php");
        require_once("".$base_url."back/plugins/phpmailer/class.smtp.php");
        $send2 = 0;		   
        $targetpengiriman = urlencode($email);
        $tokens = "qffL4YFq8Q";
        $uuids = urlencode(base64_encode($string.'^'.$passworduser));

          $url = 'http://103.122.5.250/nrsmailer/web/mailer-api/index?mails='.$targetpengiriman.'&request=3&token='.$tokens.'&uuid='.$uuids;

          $data = @file_get_contents($url);
        // var_dump($url);die();
          if ($data) {
            $json = json_decode($data);
            if (isset($json->status)) {
              if ($json->status == 1) {
                $sendE = TRUE;
                $send2 = 1;
              } else {
                $sendE = FALSE;
                $send2 = 0;
              }
            }
          }
          
          if ($sendE == FALSE && $send2 == 0) {
          	$host             = "mail.jabarprov.go.id";
          	$emailpengirim    = "dpmptsp-online@jabarprov.go.id"; //sebelumnya dpmptspjabar@gmail.com
          	$namapengirim     = "DPMPTSP JABAR";
          	$password         = "~jabarjuara2019";
            $targetpengiriman = $query->emailPerusahaan;
            $mailer = new PHPMailer();
            $mailer->CharSet = "UTF-8";
            $mailer->IsSMTP();
            $mailer->SMTPSecure = 'tls';
            $mailer->Host =$host;
            $mailer->Port =587;
            $mailer->SMTPAuth = true;
            $mailer->Username = $emailpengirim;
            $mailer->Password = $password;
            $mailer->FromName = $namapengirim;
            $mailer->From = $emailpengirim;
            $mailer->AddAddress($targetpengiriman,$targetpengiriman);
            $mailer->Subject = 'Pendaftaran Akun SIKERTAS (Sitem Informasi Kemitraan Investasi)';
            $isi  = "<img src = '".base_url()."assets/2016/images/logo_bpmpt.png' style = 'max-width:35%; max-height:35%; line-height: 100%; outline: none; text-decoration: none; border: 0 none;'><br>";
            $isi .= "<h2>Data Pendaftaran Akun SIKERTAS (Sitem Informasi Kemitraan Investasi)</h2><hr>";
            $isi .= "<p>Terimakasih atas pendaftaran anda, berikut ini adalah username dan password anda : </p>";
            $isi .= "<p><table><tr><td>Username</td><td>: ".$string."</td></tr><tr><td>Password</td><td>: ".$passworduser."</td></tr></table></p>";
            $isi .= "<p>Silahkan Login Untuk Melengkapi Data anda, <a href='https://dpmptsp.jabarprov.go.id/jelita/main/kemitraan/login'>Login Disini</a></p>";
            $isi .= "<p>Jika link tidak bisa di klik, silahkan copy paste link berikut untuk menuju halaman login : https://dpmptsp.jabarprov.go.id/jelita/main/kemitraan/login</p>";
            $isi .= "<p>Terima kasih atas perhatiannya.<br>- DPMPTSP JAWA BARAT</p>";
            $isi .= "<br><hr>";
            $isi .= "<p><small>&copy; Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu Provinsi Jawa Barat - 2019<br>Jalan Windu Nomor 26<br>Bandung, Jawa Barat, Indonesia. 40263.</small></p>";
            $isi .= "<hr>";
            $isi .= "<center><p><small>Harap jangan membalas e-mail ini, karena e-mail ini dikirimkan secara otomatis oleh sistem.</small></p></center>";
            $mailer->Body = $isi;
            $mailer->AltBody = $isi;
              if($mailer->Send()) {
              $sendE = TRUE;
              }
          }
    
            $this->session->set_flashdata('success', 'Klaim akun berhasil, silahkan cek email anda');
            redirect('https://dpmptsp.jabarprov.go.id/jelita/main/kemitraan/login','refresh');
}else{
            $this->session->set_flashdata('success', 'Klaim akun berhasil, silahkan cek email anda');
            redirect('https://dpmptsp.jabarprov.go.id/jelita/main/kemitraan/klaimakun','refresh');

}
            // Gunakan variabel $email sesuai kebutuhan di sini
        } else {
            $this->session->set_flashdata('error', 'NIB Tidak Ditemukan Atau cek kembali nomor induk berusaha anda.');
            redirect('https://dpmptsp.jabarprov.go.id/jelita/main/kemitraan/klaimakun','refresh');
            
        
    }
}


    public function blogdetails()
    {   
        $data["page_header"] = 'blogdetails';
        $this->load->view("kemitraan/head", $data);
        $this->load->view("kemitraan/blog-details", $data);
        $this->load->view("kemitraan/footer", $data);
    }
    public function blog()
    {   
                $data["page_header"] = 'blog';
        $this->load->view("kemitraan/head", $data);
        $this->load->view("kemitraan/blog", $data);
        $this->load->view("kemitraan/footer", $data);
    }
    public function shopgrid()
    {   
        $data["page_header"] = 'shopgrid';
        $this->load->view("kemitraan/head", $data);
        $this->load->view("kemitraan/shop-grid", $data);
        $this->load->view("kemitraan/footer", $data);
    }

    public function search()
    {   
        // $search = $_GET['search'];
        $search = $this->input->get('search');
        var_dump($search);die();
        $data["page_header"] = 'search';
        $this->load->view("kemitraan/head", $data);
        $this->load->view("kemitraan/shop-grid", $data);
        $this->load->view("kemitraan/footer", $data);
    }

    public function shop_usaha($id)
    {   
        $review = $this->m_kemitraan->get_data_review_shop($id);
        $latest = $this->m_kemitraan->get_data_latest();

        $this->m_kemitraan->tambahklik_usaha($id);
        $data["id_shop"] = $id;

        // Retrieve data for pagination
        $data["show"] = $this->m_kemitraan->get_kategori_grid_shop($id);

        // // Pagination Configuration
        // $config['base_url'] = site_url("main/kemitraan/shop_usaha/$id");
        // $config['total_rows'] = $this->m_kemitraan->count_products($id);
        // $config['per_page'] = 9;

        // $this->pagination->initialize($config);

        // // Get the current page from the URL, e.g., /main/kemitraan/shop_usaha/1?page=2
        // $page = $this->uri->segment(3) ? $this->uri->segment(3) : 0;

        // // Calculate the offset based on the current page
        // $offset = $page == 0 ? 0 : ($page - 1) * $config['per_page'];

        // // Retrieve data for the current page
        // $data['itemsOnPage'] = $this->m_kemitraan->get_products($id, $config['per_page'], $offset);

        // // Create pagination links
        // $data['pagination'] = $this->pagination->create_links();

        $data["review"] = $review;
        $data["latest"] = $latest;
        $data["page_header"] = 'usaha';
        $this->load->view("kemitraan/head", $data);
        $this->load->view("kemitraan/shop-grid", $data);
        $this->load->view("kemitraan/footer", $data);
    }

    // Helper function to generate Bootstrap pagination
    // private function get_bootstrap_pagination($currentPage, $totalPages, $id, $itemsPerPage) {
    //     $config['base_url'] = site_url("main/kemitraan/shop_usaha/$id"); // Update "controller" with your actual controller name
    //     $config['total_rows'] = $totalPages * $itemsPerPage;
    //     $config['per_page'] = $itemsPerPage;

    //     $this->pagination->initialize($config);

    //     return $this->pagination->create_links();
    // }

    public function pengembangan()
    {   
        $data["page_header"] = 'monev';
        $this->load->view("kemitraan/404", $data);
    }
    public function shopdetails($id)
    {   
        $detail = $this->m_kemitraan->get_detail($id);
        $klik = $detail[0]->klik;
        $perusahaan = $detail[0]->id_perusahaan;
        $this->m_kemitraan->tambahklik($klik, $id);
        $rekomen = $this->m_kemitraan->get_rekomen();
        $review = $this->m_kemitraan->get_data_review_shop($perusahaan);
        $data["review"] = $review;
        $data["page_header"] = 'shopdetails';
        $data["detail"] = $detail;
        $data["rekomen"] = $rekomen;
        $this->load->view("kemitraan/head", $data);
        $this->load->view("kemitraan/shop-details", $data);
        $this->load->view("kemitraan/footer", $data);
    }

    public function create_mou()
    {   
        $data["page_header"] = 'checkout';
        $this->load->view("kemitraan/head", $data);
        $this->load->view("kemitraan/create_mou", $data);
        $this->load->view("kemitraan/footer", $data);
    }

    
    public function create_pks_docx() {
        $id_umk = 98;
        $session = $this->session->userdata("user_id");
        $first_name = $this->input->post('namadepan');
        $last_name = $this->input->post('namabelakang');
        $country = $this->input->post('country');
        $street_address1 = $this->input->post('address1'); // Opsional
        $street_address2 = $this->input->post('address2'); // Opsional
        $city = $this->input->post('kota');
        $state = $this->input->post('provinsi');
        $zipcode = $this->input->post('kodepos');
        $phone = $this->input->post('phone');
        $email = $this->input->post('email');
    require_once 'assets/mitrakasih/phpword/src/PhpWord/Autoloader.php';
    \PhpOffice\PhpWord\Autoloader::register();
    

    // var_dump($email);die();
    $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('assets/mitrakasih/kemitraan_template_surat/PKS_template_01.docx');

    $arrblnRomawi = array("I","II","III","IV","V","VI",'VII','VIII','IX','X','XI','XII');
    $blnRomawi = $arrblnRomawi[date("m")-1];

    // create PKS by lian
        $templateProcessor->setValue("nama",$first_name.' '.$last_name);
        $templateProcessor->setValue("country",$country);
        $templateProcessor->setValue("street_address",$street_address1.' '.$street_address2);
        $templateProcessor->setValue("city",$city);
        $templateProcessor->setValue("state",$state);
        $templateProcessor->setValue("zipcode",$zipcode);
        $templateProcessor->setValue("phone",$phone);
        $templateProcessor->setValue("email",$email);
    //Create File docx
    $datename = date('Ymdgis');
    $namafile = 'PKS_'.$session.'_'.$datename.'.docx';
    $this->m_kemitraan->input_surat($session, $id_umk, $first_name, $last_name, $country, $street_address1, $street_address2, $city, $state, $zipcode, $phone,$email, $namafile);
    $file_target = 'assets/mitrakasih/kemitraan_surat_pdf/word/PKS_'.$session.'_'.$datename.'.docx';
    $simpan = $templateProcessor->saveAs($file_target);
    $namafile = 'PKS_'.$session.'_'.$datename;
    
    redirect('/main/kemitraan/konversi_pdf/'.$namafile,'refresh');
    
    //EOF() Create File docx

  }

  public function konversi_pdf($id) {
    // $redirect = str_replace(' ', '','SRT_'.$id);
    $namafile = preg_replace('/\s/i', '%20', $id); //isi 'namafile' dengan value nama file
    $opts = array('http' => array('header' => "User-Agent:MyAgent/1.0\r\n"));
    $context = stream_context_create($opts);
    $data = file_get_contents('http://103.122.5.250/siapi/api/kemitraan?id='.$namafile.'&token=9wdxc7txiH', FALSE, $context);
    $json = json_decode($data);
    if($json->status && $json->status == 'success') {
      $dtpdf = 'http://103.122.5.250/siapi/web/assets/pdf/' .preg_replace('/\s/i', '%20', $namafile). '.pdf';
      $newfile = $_SERVER['DOCUMENT_ROOT']. '/jelita/assets/mitrakasih/kemitraan_surat_pdf/pdf/'.$namafile.'.pdf';
      if (copy($dtpdf, $newfile)) {
        //file_get_contents('http://103.111.57.226/nrspdf/web/index.php?r=site%2Fdelsurat&id='.$namafile.'&token=m1WOvGqS7G', FALSE, $context);

        //Create pdf watermark
        $this->load->library('cfpdf');
        $this->load->library('cfpdi');
        $pdf = new FPDI();
        $filename  = $_SERVER['DOCUMENT_ROOT'] .'/jelita/assets/mitrakasih/kemitraan_surat_pdf/pdf-surat/'.$namafile.'.pdf'; //Lokasi File Tanpa WaterMark
        $filenameW = $_SERVER['DOCUMENT_ROOT'] .'/jelita/assets/mitrakasih/kemitraan_surat_pdf/pdf-surat-wm/'.$namafile.'.pdf';    //Lokasi File WaterMark
        try{
          $pageCount = $pdf->setSourceFile($filename);
          for($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $templateId = $pdf->importPage($pageNo);
            $size = $pdf->getTemplateSize($templateId);
            // $Wpaper = 220;
            // $Hpaper = 450;
            // $pdf->AddPage('P',array($Hpaper,$Wpaper));
            // $img = base_url().'uploads/logo/draft.png';
            // $pdf->Image($img,10,10,220,310);
            if($size['w'] > $size['h']) {
              $pdf->AddPage('L', array($size['w'], $size['h']));
              $img = base_url().'uploads/logo/draft.png';
              $pdf->Image($img,5,10,300,200);
            }else{
              $pdf->AddPage('P', array($size['w'], $size['h']));
              $img = base_url().'uploads/logo/draft.png';
              $pdf->Image($img,10,10,220,310);
            }
            $pdf->useTemplate($templateId);
          }
          $pdf->Output($filenameW,'F');
        }
        catch (Exception $e) {
          return false;
        }
        //EOFCreate pdf watermark

        return true;
        
        redirect('/main/kemitraan/create_mou','refresh');
        
      }
    }else{
      return false;
        redirect('/main/kemitraan/create_mou','refresh');
    }
  }


    public function shopingcart()
    {   
                $data["page_header"] = 'shopingcart';
        $this->load->view("kemitraan/head", $data);
        $this->load->view("kemitraan/shopingcart", $data);
        $this->load->view("kemitraan/footer", $data);
    }
    
    public function kategori($id)
    {   
        $review = $this->m_kemitraan->get_data_review_kategori($id);
        $latest = $this->m_kemitraan->get_data_latest();
        $data["review"] = $review;
        $data["latest"] = $latest;
         $data["page_header"] = 'kategori';
         $data["id_shop"] = $id;
         $data["show"] = $this->m_kemitraan->get_kategori_grid($id);
        $this->load->view("kemitraan/head", $data);
        $this->load->view("kemitraan/shop-grid", $data);
        $this->load->view("kemitraan/footer", $data);
    }

    public function checkout()
    {   
                $data["page_header"] = 'checkout';
        $this->load->view("kemitraan/head", $data);
        $this->load->view("kemitraan/checkout", $data);
        $this->load->view("kemitraan/footer", $data);
    }
    public function contact()
    {   
        $data["page_header"] = 'contact';
        $this->load->view("kemitraan/head", $data);
        $this->load->view("kemitraan/contact", $data);
        $this->load->view("kemitraan/footer", $data);
    }
}
