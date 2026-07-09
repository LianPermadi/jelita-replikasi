<?php
class M_approve_per_pertek extends CI_Model {

  function ambildata($userid) {
    $otherdb = $this->load->database('otherdb',TRUE);
    $tg1 = date("Y-m-d");
    $tg2 = date("Y-m-d");
    $h= '9';
    
    // $otherdb->select('(case when eselon = 4 then 1 
    //                   when eselon = 3 then 4 when eselon = 2 then 3 END )eselon');
    $otherdb->select('(case when eselon = 4 then 1 
                  when eselon = 3 then 4 when eselon = 2 then 3 when eselon = 5 then 4 END )eselon');
    $otherdb->from('tmpegawai');
    $otherdb->join('tmpegawai_user','tmpegawai.id = tmpegawai_user.tmpegawai_id','left');
    $otherdb->where('tmpegawai_user.user_id',$userid);
    $ambileselon =  $otherdb->get();
    foreach ($ambileselon->result() as $data2) {
      $h = $data2->eselon;
    }
    
    $trperizinan_id = '';
    $otherdb->select('trperizinan_id');
    $otherdb->from('trperizinan_user');
    $otherdb->where('user_id',$userid);
    $ambilperizinanid =  $otherdb->get();
    foreach($ambilperizinanid->result() as $data3) {
      $trperizinan_id[] = $data3->trperizinan_id;
    }
    /*
    $otherdb->select('tmpermohonan.bidang,tmperusahaan.n_perusahaan,tmpermohonan.pendaftaran_id,tmpermohonan.id,
                      trperizinan.n_perizinan,tmpermohonan.d_terima_berkas,trperizinan.kordinatttd,trperizinan.kordinatqr,trperizinan.kertas');
    $otherdb->from('tmpermohonan');
    $otherdb->join('tmpermohonan_trperizinan', 'tmpermohonan.id = tmpermohonan_trperizinan.tmpermohonan_id', 'left');
    $otherdb->join('trperizinan', 'trperizinan.id = tmpermohonan_trperizinan.trperizinan_id', 'left');
    $otherdb->join('tmpermohonan_tmperusahaan', 'tmpermohonan.id = tmpermohonan_tmperusahaan.tmpermohonan_id', 'left');
    $otherdb->join('tmperusahaan', 'tmpermohonan_tmperusahaan.tmperusahaan_id = tmperusahaan.id', 'left');
    $otherdb->where('tmpermohonan.approve',$h);
    $otherdb->where('tmpermohonan.status_berkas','Izin Disetujui');
    $otherdb->where('trperizinan.e_sertifikat','1');
    $otherdb->where("(trperizinan.e_ttd='1' OR trperizinan.e_ttd='2')", NULL, FALSE);
    $otherdb->where_in('trperizinan.id',$trperizinan_id);
    */
    $otherdb->select('tmsurat_keluar.id,tmsurat_keluar.tmpermohonan_id,tmsurat_keluar.no_pertek_awal,tmsurat_keluar.no_surat,
                      tmsurat_keluar.no_pertek_akhir,tmsurat_keluar.tgl_surat,tmsurat_keluar.kepada,tmpermohonan.trsektor_id,
                      tmpermohonan.bidang,tmpermohonan.pendaftaran_id');
    $otherdb->from('tmsurat_keluar');
    $otherdb->join('tmpermohonan', 'tmpermohonan.id = tmsurat_keluar.tmpermohonan_id', 'left');
    $otherdb->join('tmpermohonan_trperizinan', 'tmpermohonan.id = tmpermohonan_trperizinan.tmpermohonan_id', 'left');
    $otherdb->join('trperizinan', 'trperizinan.id = tmpermohonan_trperizinan.trperizinan_id', 'left');
    $otherdb->where('tmsurat_keluar.approve',$h);
    $otherdb->where('tmsurat_keluar.perihal','Pertimbangan Teknis');
    $otherdb->where_in('trperizinan.id',$trperizinan_id);
    $ambildata = $otherdb->get();
    if($ambildata->num_rows() > 0) {
      foreach($ambildata->result() as $data) {
        $hasilakdp_cetak[] = $data;
      }
      return $hasilakdp_cetak;
    }
  }

  function caridata($tg1,$tg2,$userid) {
    if($userid == 48){
      //$sts = '1';
      $where = 'approve = 1';
    }else if ($userid == 257){
      //$sts = '4';
      $where = 'approve = 4';
    }
    else if ($userid == 178){
      //$sts = '3';
      $where = 'approve = 3';
    }else{
      $where = '(approve = 1 or approve = 2 or approve = 3 or approve = 4)';
    }
    $otherdb = $this->load->database('otherdb',TRUE);
    //$ambildata = $otherdb->get('akdp_cetak');
    
    $otherdb->select('*');
    $otherdb->from('akdp_cetak');
    $otherdb->where($where);
    $otherdb->where('tgl_kp_awal <=',$tg2);
    $otherdb->where('tgl_kp_awal >=',$tg1);
    
    $ambildata = $otherdb->get();
    
    if($ambildata->num_rows() > 0) {
      foreach ($ambildata->result() as $data) {
        $hasilakdp_cetak[] = $data;
      }
      return $hasilakdp_cetak;
    }
  }
  
  function update_permohonanemail($iduser) {
    $otherdb = $this->load->database('otherdb',TRUE);
    $otherdb->select(' n_pegawai,eselon ,trperizinan_user.trperizinan_id');
    $otherdb->from('tmpegawai');
    $otherdb->join('tmpegawai_user','tmpegawai.id = tmpegawai_user.tmpegawai_id','left');
    $otherdb->join('user','user.id = tmpegawai_user.user_id','left');
    $otherdb->join('trperizinan_user','trperizinan_user.user_id = user.id','left');
    $otherdb->join('tmpermohonan_trperizinan','trperizinan_user.trperizinan_id = tmpermohonan_trperizinan.trperizinan_id','left');
    $otherdb->join('tmpermohonan','tmpermohonan.id = tmpermohonan_trperizinan.tmpermohonan_id','left');
    $otherdb->where('tmpermohonan.id','94062');
    $otherdb->where('eselon','3');
    $otherdb->where('trperizinan_user.trperizinan_id','249');
    //$otherdb->where('user.email <>','');
    $ambileselon =  $otherdb->get();
    if($ambileselon->num_rows() > 0) {
      foreach($ambileselon->result() as $data) {
        $hasilemail[] = $data;
      }
      return $hasilemail;
    }
  }

  function update_permohonan($iduser) {
    date_default_timezone_set("Asia/Bangkok");
    $otherdb = $this->load->database('otherdb',TRUE);
    $otherdb->select('eselon,nip,nik');
    $otherdb->from('tmpegawai');
    $otherdb->join('tmpegawai_user','tmpegawai.id = tmpegawai_user.tmpegawai_id','left');
    $otherdb->where('tmpegawai_user.user_id',$iduser);
    $ambileselon =  $otherdb->get();
    $h = '';
    $nip = '';
    $nik = '';
    foreach($ambileselon->result() as $data2) {
      $h = $data2->eselon;
      $nip = $data2->nip;
      $nik = $data2->nik;
    }
    $update = $this->input->post('msg');
    //$n_file = $this->input->post('n_file'); 
    //$kordinatttd = $this->input->post('kordinatttd');
    //$kordinatqr = $this->input->post('kordinatqr');
    $passphrase = $this->input->post('passphrase');
    //$kertas = $this->input->post('kertas');
    $nilai = 0;

    ?><script src="<?php echo base_url(); ?>assets/esign/jquery-latest.js"></script><?php
    
    for($i=0; $i < count($update); $i++) {
      $val = array();

      $ambildata = $otherdb->select('no_surat,tgl_surat')
                           ->from('tmsurat_keluar')
                           ->where('id',$update[$i])
                           ->get();
      foreach($ambildata->result() as $row) {
        $no_surat = $row->no_surat;
        $tgl_surat = $row->tgl_surat;
      } 
      
      if($h == 4){
        $nilai = 1;
        $data=array('approve'=>'4');
        // Save Data
        $otherdb->where('no_surat', $no_surat);
        $otherdb->where('tgl_surat', $tgl_surat);
        $otherdb->update('tmsurat_keluar',$data);
        //EOF() Save Data
      }else if($h == 2){
        
      }else if($h == 3 || $h == 5){
        $data=array('approve'=>'3');
        
        $i_urut = strlen($no_surat);
        $bcno_urut_pertek = $no_surat;
        for($j = 5; $j > $i_urut; $j--) {
          $bcno_urut_pertek = "0" . $bcno_urut_pertek;
        }
        $cod_bar_thn = $bcno_urut_pertek.date("Y",strtotime($tgl_surat));
        $n_file = 'PT_'. $cod_bar_thn.'.pdf';
        
        $local = $_SERVER['SCRIPT_FILENAME'];
        $url = $local;
        
        // Cari posisi kata "android" dalam URL
        $pos = strpos($url, "/android");
        if ($pos !== false) {
            // Ambil bagian URL sebelum "android"
            $local = substr($url, 0, $pos);
        } else {
            // Jika tidak ada kata "android", gunakan URL asli
            $local = $url;
        }
        
        $filepdf = "$local/backoffice/assets/file_mohon_sartek/$n_file";  // untuk Server

        $root = $_SERVER['DOCUMENT_ROOT'];
        $path_pdf = "$local/backoffice/assets/file_mohon_sartek/$n_file";
        $output_path = "$local/backoffice/assets/file_mohon_sartekSE/";
        // var_dump($filepdf);die();

        $nilai = 0; // default gagal
        // var_dump($path_pdf,$nik,$passphrase);die();
      if($nik != '') {  // TTE mekanisme Sign Cloud versi 2.1
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://esign-client.papuabaratprov.go.id/api/sign/pdf',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => array('file'=> new CURLFILE($path_pdf,  'application/pdf'),'nik' => $nik,'passphrase' => $passphrase,'tampilan' => 'invisible'),
          CURLOPT_HTTPHEADER => array( 'Authorization: Basic ZHBtcHRzcDpAVFRFZHBtcHRzcA=='),
        ));
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        $array_json = array();
        if($response){
          $json = json_decode($response);
        }
        $array = (array) $json;
        // var_dump($response);die();
        if($json == NULL && ($httpcode == 200 || $httpcode == 201)) { //berhasil tandatangan 
          $output_filename = $output_path.$n_file;
              if(file_exists($output_filename)){
                unlink($output_filename);
              }
          $fp = fopen($output_filename, 'w');
          fwrite($fp, $response);
          fclose($fp);
                        // Cek ukuran file
              $file_size = filesize($path_pdf); 
              // Mendapatkan ukuran file dalam byte

              if(file_exists($output_filename)){
                $file_size = filesize($output_filename); 
                // Mendapatkan ukuran file dalam byte
                if ($file_size <= 12400) { 
                  // Jika file kurang dari atau sama dengan 100 KB (102400 byte)
                        $dat_log = array('tgl_ttd'=>date("Y-m-d H:i:s"),
                        'nik' => $nik,
                        'status' => "1",
                        'info' =>  "Pertek file kurang dari 100kb",
                        'dokumen' => $n_file);
                        $otherdb->insert('log_esign',$dat_log);
                    $this->session->set_flashdata('gagal', 'TTE Gagal: File PDF dari BSRE rusak karena ukurannya kurang dari 100 KB. Mohon ulangi tanda tangan elektronik beberapa saat lagi.');
                    redirect('approve_per_pertek/pesan_permohonanesign', 'refresh');
                    
                    return FALSE;
                } else {
                    echo "File Berhasil";
                }
              }
          $nilai = 1;
          $otherdb->where('no_surat', $no_surat);
          $otherdb->where('tgl_surat', $tgl_surat);
          $otherdb->update('tmsurat_keluar',$data);
          
          $dat_log = array('tgl_ttd'=>date("Y-m-d H:i:s"),
                           'nik' => $nik,
                           'status' => "0",
                           'info' =>  "Sukses",
                           'dokumen' => "PT_". $cod_bar_thn);
          $otherdb->insert('log_esign',$dat_log);
          $approve_data = $this->update_data_approve($h, $update, $passphrase, $iduser);
        }else{  // gagal tandatangan
            $curl = curl_init();
            curl_setopt_array($curl, array(
              CURLOPT_URL => 'http://103.122.5.59/api/sign/pdf',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
              CURLOPT_POSTFIELDS => array('file'=> new CURLFILE($path_pdf,  'application/pdf'),'nik' => $nik,'passphrase' => $passphrase,'tampilan' => 'invisible'),
              CURLOPT_HTTPHEADER => array('Authorization: Basic ZXNpZ246cXdlcnR5','Cookie: JSESSIONID=98DE5E535E25B2BB670879451DE8ACBB'),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            $array_json = array();
            // var_dump($response);die();
            if($response){
              $json = json_decode($response);
            }
            $array = (array) $json;
            if($json == NULL) { //berhasil tandatangan 
              $output_filename = $output_path.$n_file;
              if(file_exists($output_filename)){
                unlink($output_filename);
              }
              $fp = fopen($output_filename, 'w');
              fwrite($fp, $response);
              fclose($fp);
                            // Cek ukuran file
                  $file_size = filesize($path_pdf); 
                  // Mendapatkan ukuran file dalam byte

                  if(file_exists($output_filename)){
                    $file_size = filesize($output_filename); 
                    // Mendapatkan ukuran file dalam byte
                    if ($file_size <= 12400) { 
                    //   // Jika file kurang dari atau sama dengan 100 KB (102400 byte)
                    //         $dat_log = array('tgl_ttd'=>date("Y-m-d H:i:s"),
                    //         'nik' => $nik,
                    //         'status' => "1",
                    //         'info' =>  "Pertek file kurang dari 100kb",
                    //         'dokumen' => $n_file);
                    //         $otherdb->insert('log_esign',$dat_log);
                    //     $this->session->set_flashdata('gagal', 'TTE Gagal: File PDF dari BSRE rusak karena ukurannya kurang dari 100 KB. Mohon ulangi tanda tangan elektronik beberapa saat lagi.');
                    //     redirect('approve_per_pertek/pesan_permohonanesign', 'refresh');
                        
                    //     return FALSE;
                    // } else {
                    //     echo "File Berhasil";
                    unlink($output_filename);
                    copy($path_pdf,$output_filename);
                    }
                  }
              $nilai = 1;
              $otherdb->where('no_surat', $no_surat);
              $otherdb->where('tgl_surat', $tgl_surat);
              $otherdb->update('tmsurat_keluar',$data);
              
              $dat_log = array('tgl_ttd'=>date("Y-m-d H:i:s"),
                              'nik' => $nik,
                              'status' => "0",
                              'info' =>  "Sukses",
                              'dokumen' => "PT_". $cod_bar_thn);
              $otherdb->insert('log_esign',$dat_log);
              $approve_data = $this->update_data_approve($h, $update, $passphrase, $iduser);
            }else{  // gagal tandatangan
              $nilai = 2;
              $kode_error =  $array['error'];
              $dat_log = array('tgl_ttd'=>date("Y-m-d H:i:s"),
                              'nik' => $nik,
                              'status' => "1",
                              'info' =>  $kode_error,
                              'dokumen' =>  "PT_". $cod_bar_thn);
              $otherdb->insert('log_esign',$dat_log);
            }
        }
      }else{
        $nilai = 2;
      } 

      } 
    }
    return $nilai;
  }

  function detail_data($id) {
    $otherdb = $this->load->database('otherdb',TRUE);
    $ambildata = $otherdb->select('akdp_cetak.*,akdptrayek.trayek')
                         ->from('akdp_cetak')
                         ->join('akdptrayek', 'akdp_cetak.kode_trayek = akdptrayek.kode_trayek', 'left')
                         ->where('akdp_cetak.id',$id)
                         ->get();
    
    if($ambildata->num_rows() > 0) {
      foreach($ambildata->result() as $data) {
        $hasilakdp_cetak[] = $data;
      }
      return $hasilakdp_cetak;
    }
  }

  function detail_datapermohonan($id) {
    $otherdb = $this->load->database('otherdb',TRUE);
    $otherdb->select('no_surat,tgl_surat');
    $otherdb->from('tmsurat_keluar');
    $otherdb->where('id',$id);
    $ambildata = $otherdb->get();
    foreach ($ambildata->result() as $data) {
      $no_surat = $data->no_surat;
      $tgl_surat = $data->tgl_surat;
    }
    
    $otherdb->select('tmsurat_keluar.id,tmsurat_keluar.tmpermohonan_id,tmsurat_keluar.no_pertek_awal,
                      tmsurat_keluar.no_pertek_akhir,tmsurat_keluar.kepada,tmpermohonan.trsektor_id,
                      tmpermohonan.pendaftaran_id');
    $otherdb->from('tmsurat_keluar');
    $otherdb->join('tmpermohonan', 'tmpermohonan.id = tmsurat_keluar.tmpermohonan_id', 'left');
    $otherdb->where('tmsurat_keluar.no_surat',$data->no_surat);
    $otherdb->where('tmsurat_keluar.tgl_surat',$data->tgl_surat);
    $ambildata = $otherdb->get();
    if($ambildata->num_rows() > 0) {
      foreach ($ambildata->result() as $data) {
        $hasil[] = $data;
      }
      return $hasil;
    }
  }

  function caridata_surat($no_surat,$userid) {
    $otherdb = $this->load->database('otherdb',TRUE);
    $h= '9';
    // $otherdb->select('(case when eselon = 4 then 1 when eselon = 3 then 4 when eselon = 2 then 3 END )eselon');
    $otherdb->select('(case when eselon = 4 then 1 when eselon = 3 then 4 when eselon = 2 then 3 when eselon = 5 then 4 END )eselon');
    $otherdb->from('tmpegawai');
    $otherdb->join('tmpegawai_user','tmpegawai.id = tmpegawai_user.tmpegawai_id','left');
    $otherdb->where('tmpegawai_user.user_id',$userid);
    $ambileselon =  $otherdb->get();
    foreach($ambileselon->result() as $data2) {
      $h = $data2->eselon;
    }
    $otherdb->select('trperizinan_id');
    $otherdb->from('trperizinan_user');
    $otherdb->where('user_id',$userid);
    $ambilperizinanid =  $otherdb->get();
    foreach($ambilperizinanid->result() as $data3) {
      $trperizinan_id[] = $data3->trperizinan_id;
    }
    $otherdb->select('tmsurat_keluar.id,tmsurat_keluar.tmpermohonan_id,tmsurat_keluar.no_pertek_awal,tmsurat_keluar.no_surat,
                      tmsurat_keluar.no_pertek_akhir,tmsurat_keluar.tgl_surat,tmsurat_keluar.kepada,tmpermohonan.trsektor_id,
                      tmpermohonan.bidang,tmpermohonan.pendaftaran_id');
    $otherdb->from('tmsurat_keluar');
    $otherdb->join('tmpermohonan', 'tmpermohonan.id = tmsurat_keluar.tmpermohonan_id', 'left');
    $otherdb->join('tmpermohonan_trperizinan', 'tmpermohonan.id = tmpermohonan_trperizinan.tmpermohonan_id', 'left');
    $otherdb->join('trperizinan', 'trperizinan.id = tmpermohonan_trperizinan.trperizinan_id', 'left');
    $otherdb->where('tmsurat_keluar.no_surat',$no_surat);
    $otherdb->where('tmsurat_keluar.approve',$h);
    $otherdb->where('tmsurat_keluar.perihal','Pertimbangan Teknis');
    $otherdb->where_in('trperizinan.id',$trperizinan_id);
    $ambildata = $otherdb->get();
    
    if($ambildata->num_rows() > 0) {
      foreach($ambildata->result() as $data) {
        $hasilakdp_cetak[] = $data;
      }
      return $hasilakdp_cetak;
    }
  }

	function update_revisi($id,$msg_revisi,$kode){
    $otherdb = $this->load->database('otherdb',TRUE);
    $data=array('approve'=>'0');
    $otherdb->where('id',$id);
    $cek = $otherdb->update('tmpermohonan',$data);
    if($cek){
      $data=array('pesan_revisi'=>$msg_revisi);
      $otherdb->where('id',$kode);
      $otherdb->update('tmsk',$data);
      $data=array('tg_kyStafPTSP'=>'', 'tg_kyEsl4PTSP'=>'', 'tg_kyEsl3PTSP'=>'', 'tg_kyKaPTSP'=>'',
                  'kyStafPTSP'=>'', 'kyEsl4PTSP'=>'', 'kyEsl3PTSP'=>'', 'kyKaPTSP'=>'');
      $otherdb->where('tmpermohonan_id',$id);
      $otherdb->update('tmpermohonan_ky',$data);
    }
    redirect('approve_esign/index');
  }
  
  function ambil_tmsk($id_permohonan){
    $otherdb = $this->load->database('otherdb',TRUE);
    $ambildata = $otherdb->select('tmsk.id')
                         ->from('tmsk')
                         ->join('tmpermohonan_tmsk', 'tmpermohonan_tmsk.tmsk_id=tmsk.id', 'left')
                         ->where('tmpermohonan_tmsk.tmpermohonan_id',$id_permohonan)
                         ->get();
    if($ambildata->num_rows() > 0) {
      foreach($ambildata->result() as $data) {
        $kode_tmsk[] = $data;
      }
      return $kode_tmsk;
    }
  }

  function update_data_approve($h, $nodaftar, $passphrase, $iduser){
    $nodaftar = implode('^',$nodaftar);
    $otherdb = $this->load->database('otherdb', TRUE);
    // var_dump($otherdb->database);die();
    $user_auth = $this->db->get_where("$otherdb->database.user", ['id' => $iduser])->row_array();
    if(!empty($user_auth)){
      $data = array(
          'auth_token' => base64_encode($passphrase)
      );

      // Mengupdate data di tabel 'api.test' berdasarkan 'id_daftar'
      $this->db->where('id', $iduser);
      $save = $this->db->update("$otherdb->database.user", $data);
    }
    $api = $this->load->database('api', TRUE);
    $ada_tidak = $this->db->get_where("$api->database.log_activity", ['id_daftar' => $nodaftar])->row_array();
    if(!empty($ada_tidak)){
      if($h == '2'){
        $data = array(
            't2'     => $iduser,
            'test_t2' => base64_encode($passphrase)
        );
      }
      if($h == '3'){
        $data = array(
            't3'     => $iduser,
            'test_t3' => base64_encode($passphrase)
        );
      }
      if($h == '4'){
        $data = array(
            't4'     => $iduser,
            'test_t4' => base64_encode($passphrase)
        );
      }

      // Mengupdate data di tabel 'api.test' berdasarkan 'id_daftar'
      $this->db->where('id_daftar', $nodaftar);
      $save = $this->db->update("$api->database.log_activity", $data);
    }else{
        $data = array(
            't4'        => $iduser,
            'test_t4'    => base64_encode($passphrase),
            'id_daftar' => $nodaftar
        );
        $save = $this->db->insert("$api->database.log_activity", $data);
    }
    return $save;
  }

  function list_approve($userid) {
    $otherdb = $this->load->database('otherdb',TRUE);
    $otherdb->select('eselon');
    $otherdb->from('tmpegawai');
    $otherdb->join('tmpegawai_user','tmpegawai.id = tmpegawai_user.tmpegawai_id','left');
    $otherdb->where('tmpegawai_user.user_id',$userid);
    $ambileselon =  $otherdb->get();
       
    foreach($ambileselon->result() as $data2) {
      $h = $data2->eselon;
    }
    $tg1 = date('Y-m-d');
    $tg2 = date('Y-m-d');
    $trperizinan_id = '';
    $otherdb->select('trperizinan_id');
    $otherdb->from('trperizinan_user');
    $otherdb->where('user_id',$userid);
    $ambilperizinanid =  $otherdb->get();
    foreach($ambilperizinanid->result() as $data3) {
      $trperizinan_id[] = $data3->trperizinan_id;
    }
    
    $otherdb->select('tmpermohonan.pendaftaran_id,tmpermohonan.bidang,tmperusahaan.n_perusahaan,tmpermohonan.pendaftaran_id,tmpermohonan.id,
                      trperizinan.n_perizinan,tmpermohonan.d_terima_berkas,tmpermohonan_ky.kyStafPTSP,
                      tmpermohonan_ky.tg_kyEsl4PTSP,tmpermohonan_ky.tg_kyEsl3PTSP,tmpermohonan_ky.tg_kyKaPTSP,trperizinan.kordinatttd,trperizinan.kertas,trperizinan.kordinatqr');
    $otherdb->from('tmpermohonan');
    $otherdb->join('tmpermohonan_trperizinan', 'tmpermohonan.id = tmpermohonan_trperizinan.tmpermohonan_id', 'left');
    $otherdb->join('trperizinan', 'trperizinan.id = tmpermohonan_trperizinan.trperizinan_id', 'left');
    $otherdb->join('tmpermohonan_tmperusahaan', 'tmpermohonan.id = tmpermohonan_tmperusahaan.tmpermohonan_id', 'left');
    $otherdb->join('tmpermohonan_ky', 'tmpermohonan.id = tmpermohonan_ky.tmpermohonan_id', 'left');
    $otherdb->join('tmperusahaan', 'tmpermohonan_tmperusahaan.tmperusahaan_id = tmperusahaan.id', 'left');
    $otherdb->where('tmpermohonan.status_berkas','Izin Disetujui');
    $otherdb->where('trperizinan.e_sertifikat','1');
    $otherdb->where("(trperizinan.e_ttd='1' OR trperizinan.e_ttd='2')", NULL, FALSE);
    		
    if($h == '4'){
      $otherdb->where('DATE(tmpermohonan_ky.tg_kyEsl4PTSP) >=',$tg1);
      $otherdb->where('DATE(tmpermohonan_ky.tg_kyEsl4PTSP) <=',$tg2);
    // }else if($h=='3'){ // data sebelumnya
    }else if($h=='3' || $h=='5'){
      $otherdb->where('DATE(tmpermohonan_ky.tg_kyEsl3PTSP) >=',$tg1);
      $otherdb->where('DATE(tmpermohonan_ky.tg_kyEsl3PTSP) <=',$tg2);
    }else if($h=='2'){
      $otherdb->where('DATE(tmpermohonan_ky.tg_kyKaPTSP) >=',$tg1);
      $otherdb->where('DATE(tmpermohonan_ky.tg_kyKaPTSP) <=',$tg2);				
    }else{}
    $otherdb->where('tmpermohonan.approve <>','0');
    $otherdb->where_in('trperizinan.id',$trperizinan_id);

    $ambildata = $otherdb->get();
    if($ambildata->num_rows() > 0) {
      foreach($ambildata->result() as $data) {
        $hasilakdp_cetak[] = $data;
      }
      return $hasilakdp_cetak;
    }
  }
  
  function cari_list_approve($userid,$tg1,$tg2) {
  	$otherdb = $this->load->database('otherdb',TRUE);
  	$otherdb->select('eselon');
    $otherdb->from('tmpegawai');
    $otherdb->join('tmpegawai_user','tmpegawai.id = tmpegawai_user.tmpegawai_id','left');
    $otherdb->where('tmpegawai_user.user_id',$userid);
    $ambileselon =  $otherdb->get();
    foreach($ambileselon->result() as $data2) {
  	  $h = $data2->eselon;
  	}
  	//$tg1 = date('Y-m-d');
  	//$tg2 = date('Y-m-d');
  	$trperizinan_id = '';
    $otherdb->select('trperizinan_id');
    $otherdb->from('trperizinan_user');
    $otherdb->where('user_id',$userid);
    $ambilperizinanid =  $otherdb->get();
    foreach($ambilperizinanid->result() as $data3) {
  	  $trperizinan_id[] = $data3->trperizinan_id;
  	}
  	$otherdb->select('tmpermohonan.pendaftaran_id,tmpermohonan.bidang,tmperusahaan.n_perusahaan,tmpermohonan.pendaftaran_id,tmpermohonan.id,
  	                  trperizinan.n_perizinan,tmpermohonan.d_terima_berkas,tmpermohonan_ky.kyStafPTSP,tmpermohonan_ky.tg_kyEsl4PTSP,
  	                  tmpermohonan_ky.tg_kyEsl3PTSP,tmpermohonan_ky.tg_kyKaPTSP,trperizinan.kordinatttd,trperizinan.kertas,trperizinan.kordinatqr');
  	$otherdb->from('tmpermohonan');
  	$otherdb->join('tmpermohonan_trperizinan', 'tmpermohonan.id = tmpermohonan_trperizinan.tmpermohonan_id', 'left');
  	$otherdb->join('trperizinan', 'trperizinan.id = tmpermohonan_trperizinan.trperizinan_id', 'left');
  	$otherdb->join('tmpermohonan_tmperusahaan', 'tmpermohonan.id = tmpermohonan_tmperusahaan.tmpermohonan_id', 'left');
  	$otherdb->join('tmpermohonan_ky', 'tmpermohonan.id = tmpermohonan_ky.tmpermohonan_id', 'left');
  	$otherdb->join('tmperusahaan', 'tmpermohonan_tmperusahaan.tmperusahaan_id = tmperusahaan.id', 'left');
  	$otherdb->where('tmpermohonan.status_berkas','Izin Disetujui');
  	$otherdb->where('trperizinan.e_sertifikat','1');
  	$otherdb->where("(trperizinan.e_ttd='1' OR trperizinan.e_ttd='2')", NULL, FALSE);
  	
  	if($h == '4'){
  	  $otherdb->where('DATE(tmpermohonan_ky.tg_kyEsl4PTSP) >=',$tg1);
  	  $otherdb->where('DATE(tmpermohonan_ky.tg_kyEsl4PTSP) <=',$tg2);
  	// }else if($h=='3'){ // data sebelumnya
    }else if($h=='3' || $h=='5'){
  	  $otherdb->where('DATE(tmpermohonan_ky.tg_kyEsl3PTSP) >=',$tg1);
  	  $otherdb->where('DATE(tmpermohonan_ky.tg_kyEsl3PTSP) <=',$tg2);
  	}else if($h=='2'){
  	  $otherdb->where('DATE(tmpermohonan_ky.tg_kyKaPTSP) >=',$tg1);
  	  $otherdb->where('DATE(tmpermohonan_ky.tg_kyKaPTSP) <=',$tg2);				
  	}else{}
  	$otherdb->where('tmpermohonan.approve <>','0');
  	$otherdb->where_in('trperizinan.id',$trperizinan_id);
  	$ambildata = $otherdb->get();
  	if($ambildata->num_rows() > 0) {
  	  foreach($ambildata->result() as $data) {
  	    $hasilakdp_cetak[] = $data;
  	  }
  	  return $hasilakdp_cetak;
  	}
	}
}
?>