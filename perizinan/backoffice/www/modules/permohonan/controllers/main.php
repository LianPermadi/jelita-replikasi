<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of welcome
 *
 * @author Obi
 */
class Main extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->tminfopublic = new tminfopublic();
        $this->tmdownload = new tmdownload();
        $this->tmgaleri = new Tmgaleri();
        $this->tm_client_jajak = new Tm_client_jajak();
        $this->tm_konter = new Tm_konter();
        $this->load->model('m_kemitraan');
    }

    function index() {
        $this->pengunjung();
        $data['data_download'] = $this->tmdownload->where("C_STATUS_LINK = 1 order by D_DOWNLOAD desc  limit 8")->get();
        $data['data_galeri'] = $this->tmgaleri->where("C_STATUS_LINK = 1 order by D_GALLERY desc limit 9")->get();
        $data['data_berita'] = $this->tminfopublic->where("C_STATUS_BERITA = 1 order by D_BERITA desc limit 8")->get();
        $data['isi'] = 'isi_data';
        $this->load->view('template', $data);
    }

    function view_jajak() {
        $jumlahdata = 0;
        $pilihan = $this->input->post('pilihan');
        $pertanyaan_jajak = $this->input->post('pertayaan');

        $ip = $this->getIP();

        if ($pilihan != "") {
            $query = "SELECT *
                            FROM tmpiljajak
                            LEFT JOIN tm_client_jajak
                            ON  tm_client_jajak.C_JAJAK = tmpiljajak.C_PILJAJAK
                            WHERE ip_client = '" . $ip . "' and  tmpiljajak.C_JAJAK = '" . $pertanyaan_jajak . "' ";
            $jumlahdata = $this->db->query($query)->num_rows();


            $data_jajak = array(
                'C_JAJAK' => $pilihan,
                'ip_client' => $ip
            );

            if ($jumlahdata == 0 || $jumlahdata == NULL)
                $this->tm_client_jajak->insert($data_jajak);
        }

        $data['isi'] = 'isi_view_jajak';
        $this->load->view('template', $data);
    }

    function ttd_person($id){
        $id = base64_decode($id);
        $data['id'] = $id;
        $data['isi'] = 'isi_view_jajak';
        $this->load->view('template', $data);
    }

    function cekpegawai($id=null){
      $pra = $this->session->userdata('status');
      $this->session->unset_userdata('status');
      $id_acara = $this->session->userdata('id_acara');
      $this->session->unset_userdata('id_acara');
      $id = base64_decode($id);
      if($pra != null){
        $peringkat = $this->m_kemitraan->update_akses($id);
      }  
      $pegawai = $this->m_kemitraan->pegawai_detail($id);
      foreach ($pegawai as $row) {
        $peringkat = $row->no_akses;
      }
      
      //Area Setting
      $simulasi = '1';          // isikan nilai '1':simulasi, '':real ubah data di jml_card di year -> 0 ubah no_akses di tmpegawai jadi 0 semua
      $text_hadiah = 'Anda Berhak Mendapat <br> 1 X Makan Siang Gratis di <br> Cafe Sedap Makmur';
      $text_hadiah = '<b style="color:blue;">Nomor Urut '.$peringkat.'<br> '.$text_hadiah.'</b>';
      $text_partisipan = ''; //'<b style="color:red;">Nomor Urut Anda '.$peringkat.'<br> Terimakasih atas partisipasinya'.'</b>';
      $juara = array(); // array(30,9,24) tentukan no urutan absen ke berapa yang akan dapat hadiah pada array juara  
      //EOF() Area Setting
      
      $agenda_dinas = $this->m_kemitraan->kegiatan_dinas("I");
      $data["simulasi"] = $simulasi;
      $data["text_hadiah"] = $text_hadiah;
      $data["text_partisipan"] = $text_partisipan;
      $data["juara"] = $juara;
      $data["agenda_dinas"] = $agenda_dinas;
      $data['pegawai'] = $pegawai;
      $data['peringkat'] = $peringkat;
      $data['isi'] = 'validasi_pegawai';
      $data['pra'] = $pra;
      $data['id_acara'] = $id_acara;
      $this->load->view('template', $data);
    }
    
    function absen(){
    	$id_peg = $this->input->post('id_peg');
    	$id_acara = $this->input->post('list_opd');
    	$pin = $this->input->post('password');
    	$simulasi = $this->input->post('simulasi');
      if ($this->input->post('pin') == base64_encode($pin) || $simulasi == '1') {
        $msg = 'PIN Benar';
        $update = $this->m_kemitraan->save_absen($id_peg,$id_acara);
      }else{
      	$msg = 'Gagal Absen, PIN Salah';
      	$update = $msg;
      }
      $encoded_id_peg = base64_encode($id_peg); 
      $this->session->set_userdata('status', $update);
      $this->session->set_userdata('id_acara', $id_acara);  
      redirect('main/cekpegawai/'.$encoded_id_peg);
    }
    
    public function wjisgues($id = null) {
        $this->load->model('m_wjis_guest_information');
        $username	= $this->session->userdata("username");

        // var_dump($username);die();
        // Decode ID
        $id = base64_decode($id);
        
        // Dapatkan detail tamu
        $pegawai = $this->m_wjis_guest_information->tamu_detail($id);
        // var_dump($pegawai);die();
        // Cek ji4ka $pegawai tidak kosong
        if (!empty($pegawai)) {
            // Ambil event_id dari objek tamu
            // Dapatkan detail acara berdasarkan event_id tamu
            
            // Siapkan data untuk dikirim ke view
            $data['pegawai'] = $pegawai; // Ambil objek pertama dari array
            $data['guest_event_details'] = $this->m_wjis_guest_information->get_guest_event_selection_details($id);
            $data['guest_event_one_on_one_meeting_details'] = $this->m_wjis_guest_information->get_guest_event_one_on_one_meeting_selection_details($id);
            // var_dump($data['guest_event_one_on_one_meeting_details']);die();
            $data['username'] = $username;
            $jadwal_acara = $this->m_wjis_guest_information->jadwal_acara($id);
            $data['jadwal_acara'] = $jadwal_acara;

            // var_dump($data['jadwal_acara']);die();
        } else {
            // Jika tidak ada data tamu, siapkan data kosong atau sesuai kebutuhan
            $data['pegawai'] = null;
            $data['event_details'] = [];
            $data['username'] = '';
        }
    
        $data['isi'] = 'v_tamu_wjis';
        $data['pra'] = ''; // Sesuaikan jika ada data tambahan
        $data['id_acara'] = ''; // Sesuaikan jika ada data tambahan
        
        // Load view dengan template
        $this->load->view('template', $data);
    }
    
    
    
    function pengunjung() {
        $ip = $this->getIP();
        $get_jumlah = $this->tm_konter->where("ip_adrees = '$ip' ")->count();


        if ($get_jumlah < 1) {

            $data_konter = array(
                'ip_adrees' => $ip,
                'date_konter' => date('Y-m-d H:i:s')
            );

            echo $this->tm_konter->insert($data_konter);
        }
    }

    function getIP() {
        $ip;
        if (getenv("HTTP_CLIENT_IP"))
            $ip = getenv("HTTP_CLIENT_IP");
        else if (getenv("HTTP_X_FORWARDED_FOR"))
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        else if (getenv("REMOTE_ADDR"))
            $ip = getenv("REMOTE_ADDR");
        else
            $ip = "UNKNOWN";
        return $ip;
    }

    function upload() {
        $data['judul'] = 'Test Upload';
        $this->load->view('isi_upload', $data);
    }

    function save_upload($file = NULL) {
        //var_dump($_FILES);
        if (!empty($_FILES)) {
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'gif|jpg|png';

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $field_name = "Filedata";

            if (!$this->upload->do_upload($field_name)) {
                $error = $this->upload->display_errors();
            } else {
                
            }
        } else {

            //echo "<script>alert('kosong');</script>";
        }      
    }
 
    public function update($id) {
        $this->load->model('m_wjis_guest_information');

        $status_kehadiran = $this->input->post('kehadiran');
        // Data yang akan diperbarui
        $data = [
            'status_checkin' => $status_kehadiran,
            // 'id' => $id,

            'tanggal' => date('Y-m-d H:i:s')
        ];
        // var_dump($id);die();
        // Perbarui data di database
        if ($this->m_wjis_guest_information->update_absensi($id, $data)) {
            echo json_encode(['status' => 'success', 'message' => 'Data berhasil diperbarui!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui data!']);
        }
    }
    public function update_souvenir_recipient($id) {
        $this->load->model('m_wjis_guest_information');

        $status_kehadiran = $this->input->post('kehadiran');
        // Data yang akan diperbarui
        $data = [
            'souvenir_recipient' => date('Y-m-d H:i:s')
        ];

        // Perbarui data di database
        if ($this->m_wjis_guest_information->update_absensi_ceremony($id, $data)) {
            echo json_encode(['status' => 'success', 'message' => 'Data berhasil diperbarui!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui data!']);
        }
    }
    public function update_souvenir_bank_indonesia($id) {
        $this->load->model('m_wjis_guest_information');

        // $status_kehadiran = $this->input->post('kehadiran');
        // Data yang akan diperbarui
        $data = [
            'souvenir_recipient_bank_indonesia' => date('Y-m-d H:i:s')
        ];

        // Perbarui data di database
        if ($this->m_wjis_guest_information->update_absensi_ceremony($id, $data)) {
            echo json_encode(['status' => 'success', 'message' => 'Data berhasil diperbarui!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui data!']);
        }
    }
    
    public function update_one_on_one_meeting($id) {
        $this->load->model('m_wjis_guest_information');

        $status_kehadiran = $this->input->post('kehadiran');
        // Data yang akan diperbarui
        $data = [
            'status_checkin' => $status_kehadiran,
            // 'id' => $id,

            'tanggal' => date('Y-m-d H:i:s')
        ];
        // var_dump($id);die();
        // Perbarui data di database
        if ($this->m_wjis_guest_information->update_absensi_one_on_one_meeting($id, $data)) {
            echo json_encode(['status' => 'success', 'message' => 'Data berhasil diperbarui!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui data!']);
        }
    }
    public function update_one_on_one_meeting_checkout($id) {
        $this->load->model('m_wjis_guest_information');
    
        // Capture all POST data
        $status_kehadiran = $this->input->post('kehadiran');
        $questions = $this->input->post('questions');
        $answers = $this->input->post('answers');
    
        // Data yang akan diperbarui
        $data = [
            'status_checkout' => $status_kehadiran,
            'pertanyaan_checkout' => $questions, // Tambahkan field questions
            'jawaban_checkout' => $answers,     // Tambahkan field answers
            'tanggal_chekout' => date('Y-m-d H:i:s')
        ];
        // var_dump($data);die();
        // Perbarui data di database
        if ($this->m_wjis_guest_information->update_absensi_one_on_one_meeting($id, $data)) {
            echo json_encode(['status' => 'success', 'message' => 'Data berhasil diperbarui!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui data!']);
        }
    }
    
    public function update_ceremony($id) {
        $this->load->model('m_wjis_guest_information');

        $status_kehadiran = $this->input->post('kehadiran');
        // Data yang akan diperbarui
        $data = [
            'absen_ceremony' => date('Y-m-d H:i:s')
        ];

        // Perbarui data di database
        if ($this->m_wjis_guest_information->update_absensi_ceremony($id, $data)) {
            echo json_encode(['status' => 'success', 'message' => 'Data berhasil diperbarui!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui data!']);
        }
    }
    public function update_Talkshow($id) {
        $this->load->model('m_wjis_guest_information');

        $status_kehadiran = $this->input->post('kehadiran');
        // Data yang akan diperbarui
        $data = [
            'absen_talkshow' => date('Y-m-d H:i:s')
        ];

        // Perbarui data di database
        if ($this->m_wjis_guest_information->update_absensi_ceremony($id, $data)) {
            echo json_encode(['status' => 'success', 'message' => 'Data berhasil diperbarui!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui data!']);
        }
    }
    public function update_exhibition($id) {
        $this->load->model('m_wjis_guest_information');

        $status_kehadiran = $this->input->post('kehadiran');
        // Data yang akan diperbarui
        $data = [
            'absen_exhibition' => date('Y-m-d H:i:s')
        ];

        // Perbarui data di database
        if ($this->m_wjis_guest_information->update_absensi_ceremony($id, $data)) {
            echo json_encode(['status' => 'success', 'message' => 'Data berhasil diperbarui!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui data!']);
        }
    }
    public function create_one_on_one_meeting($id) {
        $this->load->model('m_wjis_guest_information');
        $guest_id = base64_decode($id);

        // var_dump($this->input->post('kehadiran'));
        // Dapatkan data dari POST request (dari form yang di-submit)
        $data = array(
            'guest_event_selection_id' => $this->input->post('guest_event_selection_id'),
            'guest_id' => $guest_id,
            'one_on_one_meeting_id' => $this->input->post('one_on_one_meeting_id'),
            'status_checkin' => $this->input->post('kehadiran'),
            'tanggal' => date('Y-m-d H:i:s'), // Atau sesuaikan sesuai input tanggal dari form
            'status_checkout' => 0,
            'tanggal_chekout' => null, // Atau sesuai input form
            'pertanyaan_checkout' => null,
            'jawaban_checkout' => null
        );

        // Simpan data ke database menggunakan model

        if ($this->m_wjis_guest_information->createMeetingData($data)) {
            echo json_encode(['status' => 'success', 'message' => 'Data berhasil Di tambahkan!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui data!']);
        }
    }
    public function tambah_data_oom_by_user($id) {
        $this->load->model('m_wjis_guest_information');

        $status_kehadiran = $this->input->post('kehadiran');
        // Data yang akan diperbarui
        $data = [
            'absen_exhibition' => date('Y-m-d H:i:s')
        ];

        // Perbarui data di database
        if ($this->m_wjis_guest_information->query_tambah_data_oom_by_user($id, $data)) {
            echo json_encode(['status' => 'success', 'message' => 'Data berhasil diperbarui!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui data!']);
        }
    }
    function ok() {
        
    }
}

?>
