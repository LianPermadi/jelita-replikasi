<?php
class M_approve_esign extends CI_Model {

  function ambildata($userid) {
    $otherdb = $this->load->database('otherdb',TRUE);
    $tg1 = date("Y-m-d");
    $tg2 = date("Y-m-d");
    $h= '9';
    
    $otherdb->select('(case when eselon = 4 then 1 
                      when eselon = 3 then 4 when eselon = 2 then 3 END )eselon');
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
    
    $otherdb->select('tmpermohonan.bidang,tmperusahaan.n_perusahaan,tmpermohonan.pendaftaran_id,tmpermohonan.id,
                      trperizinan.n_perizinan,tmpermohonan.d_terima_berkas,trperizinan.kordinatttd,trperizinan.kordinatqr,trperizinan.kertas');
    $otherdb->from('tmpermohonan');
    $otherdb->join('tmpermohonan_trperizinan', 'tmpermohonan.id = tmpermohonan_trperizinan.tmpermohonan_id', 'left');
    $otherdb->join('trperizinan', 'trperizinan.id = tmpermohonan_trperizinan.trperizinan_id', 'left');
    $otherdb->join('tmpermohonan_tmperusahaan', 'tmpermohonan.id = tmpermohonan_tmperusahaan.tmpermohonan_id', 'left');
    $otherdb->join('tmperusahaan', 'tmpermohonan_tmperusahaan.tmperusahaan_id = tmperusahaan.id', 'left');
    $otherdb->where('tmpermohonan.approve',$h);
    $otherdb->where('tmpermohonan.status_berkas','Izin Disetujui');
    $otherdb->where("tmpermohonan.kd_status < '8'");
    //$otherdb->where('trperizinan.e_sertifikat','1'); //disable sementara untuk file SE Upload
    //$otherdb->where('trperizinan.e_ttd = "1");
    $otherdb->where("(trperizinan.e_ttd='1' OR trperizinan.e_ttd='2')", NULL, FALSE);
    $otherdb->where_in('trperizinan.id',$trperizinan_id);
    //$otherdb->or_where('trperizinan.e_ttd','2');
    $ambildata = $otherdb->get();

    $hasilakdp_cetak = array();
    if($ambildata->num_rows() > 0) {
      foreach($ambildata->result() as $data) {
        $hasilakdp_cetak[] = $data; //disable
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
    // else if ($userid == 178){
    else if ($userid == 435){
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
    //$nodaftar = $this->input->post('nodaftar'); 
    $kordinatttd = $this->input->post('kordinatttd');
    $kordinatqr = $this->input->post('kordinatqr');
    $passphrase = $this->input->post('passphrase');
    $kertas = $this->input->post('kertas');

    ?>
    <script src="<?php echo base_url(); ?>assets/esign/jquery-latest.js"></script>
    <?php
    
    for($i=0; $i < count($update) ; $i++) {
      $nodaftar = $this->ambil_nodaftar($update[$i]);

      $otherdb->select('kd_status');
      $otherdb->from('tmpermohonan');
      $otherdb->where('id',$update[$i]);
      $ambilkd =  $otherdb->get();

      if($ambilkd->num_rows() > 0) {
        foreach($ambilkd->result() as $datakd) {
          $kd_status = $datakd->kd_status;
        }
      }

      //var_dump($kd_status);die;

      if($h == 4){
        $data=array('approve'=>'4');
      }else if($h == 3){
        $data=array('approve'=>'3');
      }else if($h == 2){
        if ($kd_status < 6) {
          $data=array('approve' => '2',
                      'kd_status' => '6');
        } else {
          $data=array('approve'=>'2');
        }

        //cek bis besar
        $indeks = $this->ambil_indeks($nodaftar);

        if ($indeks == "AKDP") {
            $kp = "KP_".$nodaftar;
            $sk = "SK_".$nodaftar;
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
            $filesk = "$local/backoffice/assets/skpdf/$sk.pdf";
            $filekp = "$local/backoffice/assets/skpdf/$kp.pdf";
            $this->pasang_bsre($filesk, $nodaftar);
            $this->pasang_bsre($filekp, $nodaftar);
            
            //ttd digital
            //$nip = $this->get_nip($iduser);
            
            // $esign_kp = $this->do_ttd($nip, $kp, $passphrase);
            // $esign_sk = $this->do_ttd($nip, $sk, $passphrase);
            
            $esign_kp = $this->do_ttd($nip, $nik, $kp, $passphrase);
            $esign_sk = $this->do_ttd($nip, $nik, $sk, $passphrase);

            if (!$esign_kp && !$esign_sk) {
              $this->session->set_flashdata('gagal', "Gagal AKDP");
              redirect('approve_esign/pesan_permohonanesign');
            }
        } else {
          $this->load->library('cfpdf');
          $this->load->library('cfpdi');
          $pdf = new FPDI();
          $kp = "KP_".$nodaftar;
          $sk = "SK_".$nodaftar;
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
          $filepdf = "$local/backoffice/assets/skpdf/SK_$nodaftar.pdf";
          try{
            $pageCount = $pdf->setSourceFile($filepdf);
            for($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $size = $pdf->getTemplateSize($templateId);
              if($kertas[$i] == 1){
                if($size['w'] > $size['h']) {
                  $pdf->AddPage('L', array($size['w'], $size['h']));
                  // $img = base_url('assets/img/bsre.jpg');
                  $img = base_url('assets/img/bsre.png');
                  $pdf->Image($img,17,190,185,12);
                }else{
                  $pdf->AddPage('P', array($size['w'], $size['h']));
                  // $img = base_url('assets/img/bsre.jpg');
                  $img = base_url('assets/img/bsre.png');
                  $pdf->Image($img,17,283,180,12);
                }
              }else{
                if($size['w'] > $size['h']) {
                  $pdf->AddPage('L', array($size['w'], $size['h']));
                  // $img = base_url('assets/img/bsre.jpg');
                  $img = base_url('assets/img/bsre.png');
                  $pdf->Image($img,17,190,185,12);
                }else{
                  $pdf->AddPage('P', array($size['w'], $size['h']));
                  // $img = base_url('assets/img/bsre.jpg');
                  $img = base_url('assets/img/bsre.png');
                  $pdf->Image($img,17,310,180,12);
                }
              }
              $pdf->useTemplate($templateId);
              if($pageNo == 1){
                if($kordinatttd[$i] != ""){
                  $kordinattandatangan =explode(",", $kordinatttd[$i]);
                  $kx = $kordinattandatangan[0];
                  $ky = $kordinattandatangan[1];
                  $klx = $kordinattandatangan[2];
                  $kly = $kordinattandatangan[3];
                  $kop = base_url('assets/img/ttd.png');
                  $pdf->Image($kop,$kx,$ky,$klx,$kly);
                }
                if($kordinatqr[$i] != ""){
                  $kordinatqrcode = explode(",", $kordinatqr[$i]);
                  $kx1 = $kordinatqrcode[0];
                  $ky1 = $kordinatqrcode[1];
                  $klx1 = $kordinatqrcode[2];
                  $kly1 = $kordinatqrcode[3];
                  $qr = base_url('assets/img/Capture.png');
                  $pdf->Image($qr,$kx1,$ky1,$klx1,$kly1);
                }
              }   
            }
            $pdf->Output($filepdf,'F');
          }
          catch (Exception $e) {
            //exception?
          }
          
          //ttd digital                
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
			    $n_file = 'SK_'.$nodaftar.'.pdf';
          $path_pdf     = "$local/backoffice/assets/skpdf/SK_$nodaftar.pdf"; 
          $output_path  = $local.'/backoffice/assets/esignfile/';
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
            $json = 0;
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
              // $approve_data = $this->update_data_approve($h, $update, $passphrase, $iduser);
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
                  // $approve_data = $this->update_data_approve($h, $update, $passphrase, $iduser);
                }else{  // gagal tandatangan
                  $nilai = 2;
                  $kode_error =  $array['error'];
                  $dat_log = array('tgl_ttd'=>date("Y-m-d H:i:s"),
                                  'nik' => $nik,
                                  'status' => "1",
                                  'info' =>  $kode_error,
                                  'dokumen' =>  $n_file);
                  $otherdb->insert('log_esign',$dat_log);
                  $this->session->set_flashdata('gagal', 'TTE Gagal: NIK tidak terdaftar');
                  redirect('approve_per_pertek/pesan_permohonanesign', 'refresh');
                }
            }
          }else{
            $nilai = 2;
                    $this->session->set_flashdata('gagal', 'TTE Gagal: NIK tidak terdaftar');
                    redirect('approve_per_pertek/pesan_permohonanesign', 'refresh');
          }      
          // EOF() ttd digital
        }
      }
      if($nilai == 2){
          $this->session->set_flashdata('gagal', 'TTE Gagal: Coba ulangi lagi');
          redirect('approve_per_pertek/pesan_permohonanesign', 'refresh');
      }
      // $approve_data = $this->update_data_approve($h, $nodaftar, $passphrase, $iduser);

      //update permohonan & approval
      $otherdb->where('id', $update[$i]);
      $otherdb->update('tmpermohonan',$data);
      $ambildata = $otherdb->select('*')
                           ->from('tmpermohonan_ky')
                           ->where('tmpermohonan_id',$update[$i])
                           ->get();

      if($ambildata->num_rows() > 0) {
        if($h == 4){
          $data=array('tg_kyEsl4PTSP'=>date("Y-m-d H:i:s"));
        }else if($h == 3){
          $data=array('tg_kyEsl3PTSP'=>date("Y-m-d H:i:s"));
        }else if($h == 2){
          $data=array('tg_kyKaPTSP'=>date("Y-m-d H:i:s"));  
        }
        $otherdb->where('tmpermohonan_id', $update[$i]);
        $otherdb->update('tmpermohonan_ky',$data);
      }else{
        if($h == 4){
          $data=array('tmpermohonan_id'=>$update[$i],
                      'tg_kyEsl4PTSP'=>date("Y-m-d H:i:s"));
        }else if($h == 3){
          $data=array('tmpermohonan_id'=>$update[$i],
                      'tg_kyEsl3PTSP'=>date("Y-m-d H:i:s"));
        }else if($h == 2){
          $data=array('tmpermohonan_id'=>$update[$i],
                      'tg_kyKaPTSP'=>date("Y-m-d H:i:s"));  
        }
        $otherdb->insert('tmpermohonan_ky',$data);  
      }
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

  function update_permohonan_test($iduser, $update, $kertas, $kordinatttd, $kordinatqr, $passphrase) {
    date_default_timezone_set("Asia/Bangkok");
    $otherdb = $this->load->database('otherdb',TRUE);
    $otherdb->select('eselon,nip');
    $otherdb->from('tmpegawai');
    $otherdb->join('tmpegawai_user','tmpegawai.id = tmpegawai_user.tmpegawai_id','left');
    $otherdb->where('tmpegawai_user.user_id',$iduser);
    $ambileselon =  $otherdb->get();
    $h = '';
    $nip = '';
    foreach($ambileselon->result() as $data2) {
      $h = $data2->eselon;
      $nip = $data2->nip;
    }

    $nilai = 0;

    $this->load->library('cfpdf');
    $this->load->library('cfpdi');
    $pdf = new FPDI();
    $filepdf = $_SERVER['DOCUMENT_ROOT'].'/spekta/backoffice/assets/sktest/SK_'.$update.'.pdf';
    try{
      $pageCount = $pdf->setSourceFile($filepdf);
      for($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
        $templateId = $pdf->importPage($pageNo);
        $size = $pdf->getTemplateSize($templateId);
        if($kertas == 1){
          if($size['w'] > $size['h']) {
            $pdf->AddPage('L', array($size['w'], $size['h']));
            // $img = base_url('assets/img/bsre.jpg');
            $img = base_url('assets/img/bsre.png');
            $pdf->Image($img,17,190,185,12);
          }else{
            $pdf->AddPage('P', array($size['w'], $size['h']));
            // $img = base_url('assets/img/bsre.jpg');
            $img = base_url('assets/img/bsre.png');
            $pdf->Image($img,17,283,180,12);
          }
        }else{
          if($size['w'] > $size['h']) {
            $pdf->AddPage('L', array($size['w'], $size['h']));
            // $img = base_url('assets/img/bsre.jpg');
            $img = base_url('assets/img/bsre.png');
            $pdf->Image($img,17,190,185,12);
          }else{
            $pdf->AddPage('P', array($size['w'], $size['h']));
            // $img = base_url('assets/img/bsre.jpg');
            $img = base_url('assets/img/bsre.png');
            $pdf->Image($img,17,310,180,12);
          }
        }
        $pdf->useTemplate($templateId);
        if($pageNo == 1){
          //$kop = base_url('assets/img/kop.jpg');
          //$pdf->Image($kop,15,12,185,28);
          //$pdf->Image($kop,5,5,205,40);
          //$kordinatttd = '130,210,33,20';
          if($kordinatttd != ""){
            $kordinattandatangan =explode(",", $kordinatttd);
            $kx = $kordinattandatangan[0];
            $ky = $kordinattandatangan[1];
            $klx = $kordinattandatangan[2];
            $kly = $kordinattandatangan[3];
            $kop = base_url('assets/img/ttd.png');
            $pdf->Image($kop,$kx,$ky,$klx,$kly);
          }
          if($kordinatqr != ""){
            $kordinatqrcode = explode(",", $kordinatqr);
            $kx1 = $kordinatqrcode[0];
            $ky1 = $kordinatqrcode[1];
            $klx1 = $kordinatqrcode[2];
            $kly1 = $kordinatqrcode[3];
            $qr = base_url('assets/img/Capture.png');
            $pdf->Image($qr,$kx1,$ky1,$klx1,$kly1);
          }
        }   
      }
      //$pdf->Output($filepdf,'F');
      $pdf->Output($filepdf,'F');
      //die;
      //echo base_url('assets/img/bsre.png');
      //$img =  base_url('assets/img/bsre.jpg');
    }
    catch (Exception $e) {}
    
    //ttd digital
    $n_SE = 'lucky.p12';
    $path_jar = $_SERVER['DOCUMENT_ROOT'].'/spekta/android/assets/esign/signer/esign_client.jar';
    $path_pdf = $_SERVER['DOCUMENT_ROOT'].'/spekta/backoffice/assets/sktest/SK_'.$update.'.pdf'; 
    $path_p12 = $_SERVER['DOCUMENT_ROOT'].'/spekta/android/assets/esign/signer/'.$n_SE;  
    $output_path = $_SERVER['DOCUMENT_ROOT'].'/spekta/backoffice/assets/esigntest/';
    // $tsa_url = "http://tsa-bsre.bssn.go.id/";
    // $ocsp = "http://cvs-bsre.bssn.go.id/ocsp";
    //$command = 'java -jar "'.$path_jar.'" "'.$path_pdf.'" -kst PKCS12 -ksf "'.$path_p12.'" -ksp "'.$passphrase.'" -l "Tasikmalaya" -r "Pengesahan Naskah Perizinan" -c "kontak yang bisa dihubungi" -tsh SHA256 -ha SHA256 -d "'.$output_path.'" -os "" -ts '.$tsa_url.' -ta PASSWORD -tsu "coba" -tsp "1234" --ocsp --ocsp-server-url "'.$ocsp.'"';

    $command = "java -jar ".$path_jar." -m sign -f ".$path_pdf." -d ".$output_path." -p '#1234qwer*' -nik 30122019 -t invisible";
    exec($command, $val, $er);
    if($er == 0 || $er == 3){
      $hasilesign = str_replace('"', "", $val[0]);
      $cop = copy($hasilesign, $output_path."SK_".$update.".pdf");
      if (!$cop) {
        echo "Gagal copy ".$hasilesign;die;
      } else {
        echo "Berhasil copy ".$output_path."SK_".$update.".pdf";
        if (unlink($hasilesign)) {
          echo "<br>Berhasil hapus file temporary.";
        }
        die;
      }
    } else {
      $nilai = 2;
      //redirect('approve_esign/pesan_permohonanesign');
    }
    // EOF() ttd digital
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
    $ambildata = $otherdb->select('tmperusahaan.n_perusahaan, tmperusahaan.a_perusahaan, tmpermohonan.pendaftaran_id, tmpermohonan.id,
                                   trperizinan.n_perizinan, tmpermohonan.d_terima_berkas, tmpermohonan.no_per_pertek,
                                   tmpermohonan.tg_per_pertek, tmpermohonan.d_survey, tmpermohonan.survey_sd, tmpermohonan.d_selesai_proses,
                                   tmpermohonan.status_berkas, trperizinan.n_perizinan, tmpermohonan.bidang, trperizinan.bid_teknis,
                                   tmpemohon.n_pemohon, tmpemohon.a_pemohon,trperizinan.kordinatttd,trperizinan.kertas,trperizinan.kordinatqr')
                         ->from('tmpermohonan')
                         ->join('tmpermohonan_trperizinan', 'tmpermohonan_trperizinan.tmpermohonan_id = tmpermohonan.id', 'left')
                         ->join('trperizinan', 'trperizinan.id = tmpermohonan_trperizinan.trperizinan_id', 'left')
                         ->join('tmpermohonan_tmperusahaan', 'tmpermohonan.id = tmpermohonan_tmperusahaan.tmpermohonan_id', 'left')
                         ->join('tmperusahaan', 'tmpermohonan_tmperusahaan.tmperusahaan_id = tmperusahaan.id', 'left')
                         ->join('tmpemohon_tmpermohonan', 'tmpermohonan.id = tmpemohon_tmpermohonan.tmpermohonan_id', 'left')
                         ->join('tmpemohon', ' tmpemohon_tmpermohonan.tmpemohon_id = tmpemohon.id', 'left')
                         ->where('tmpermohonan.id',$id)
                         //->where('trperizinan.e_sertifikat','1')
                         ->get();
    if($ambildata->num_rows() > 0) {
      foreach ($ambildata->result() as $data) {
        $hasilakdp_cetak[] = $data;
      }
      return $hasilakdp_cetak;
    }
    //return $otherdb->last_query();
  }

  function caridata_no_pendaftaran($no_pendaftaran,$userid) {
    $otherdb = $this->load->database('otherdb',TRUE);
    $h= '9';
    $otherdb->select('(case when eselon = 4 then 1 when eselon = 3 then 4 when eselon = 2 then 3 END )eselon');
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
    $otherdb->select('tmpermohonan.bidang,tmpermohonan.pendaftaran_id,tmpermohonan.id,tmperusahaan.n_perusahaan,
                      trperizinan.n_perizinan,tmpermohonan.d_terima_berkas,trperizinan.kordinatttd,trperizinan.kertas,trperizinan.kordinatqr');
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
    //$otherdb->like('tmpermohonan.pendaftaran_id',$no_pendaftaran);
    $otherdb->where("(tmpermohonan.pendaftaran_id like '%$no_pendaftaran%' OR tmperusahaan.n_perusahaan like '%$no_pendaftaran%' OR trperizinan.n_perizinan like '%$no_pendaftaran%')", NULL, FALSE);
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
    }else if($h=='3'){
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
    }else if($h=='3'){
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

  public function ambil_indeks($pendaftaran_id) {
    $otherdb = $this->load->database('otherdb',TRUE);
    $otherdb->select('trperizinan.indeks');
    $otherdb->from('trperizinan');
    $otherdb->join('tmpermohonan_trperizinan', 'trperizinan.id = tmpermohonan_trperizinan.trperizinan_id', 'left');
    $otherdb->join('tmpermohonan', 'tmpermohonan.id = tmpermohonan_trperizinan.tmpermohonan_id', 'left');
    $otherdb->where('tmpermohonan.pendaftaran_id',$pendaftaran_id);
    $ambil =  $otherdb->get()->row();

    $data = '';
    if (!empty($ambil->indeks)) {
      $data = $ambil->indeks;
    }

    return $data;
  }

  public function ambil_thn_bb($pendaftaran_id) {
    $otherdb = $this->load->database('db_bb',TRUE);
    $otherdb->select('YEAR(bb_pit.TGL_BAND) as TGL');
    $otherdb->from('bb_pit');
    $otherdb->join('bb_kp', 'bb_pit.PIT_ID = bb_kp.PIT_ID', 'left');
    $otherdb->where('bb_kp.NO_RESI',$pendaftaran_id);
    $ambil =  $otherdb->get()->row();

    $data = '';
    if (!empty($ambil->TGL)) {
      $data = $ambil->TGL;
    }

    return $data;
  }

  public function ambil_thn_resi($pendaftaran_id) {
    $otherdb = $this->load->database('otherdb',TRUE);
    $otherdb->select('YEAR(d_terima_berkas) as TGL');
    $otherdb->from('tmpermohonan');
    $otherdb->where('pendaftaran_id',$pendaftaran_id);
    $ambil =  $otherdb->get()->row();

    $data = '';
    if (!empty($ambil->TGL)) {
      $data = $ambil->TGL;
    }

    return $data;
  }

  public function ambil_nodaftar($id) {
    $otherdb = $this->load->database('otherdb',TRUE);
    $otherdb->select('pendaftaran_id');
    $otherdb->from('tmpermohonan');
    $otherdb->where('id',$id);
    $ambil =  $otherdb->get()->row();

    $data = '';
    if (!empty($ambil->pendaftaran_id)) {
      $data = $ambil->pendaftaran_id;
    }

    return $data;
  }

  function pasang_bsre($filepdf, $pendaftaran_id) {
    $otherdb = $this->load->database('otherdb',TRUE);
    $otherdb->select('trperizinan.kertas,trperizinan.kordinatttd,trperizinan.kordinatqr');
    $otherdb->from('tmpermohonan');
    $otherdb->join('tmpermohonan_trperizinan', 'tmpermohonan.id = tmpermohonan_trperizinan.tmpermohonan_id', 'left');
    $otherdb->join('trperizinan', 'trperizinan.id = tmpermohonan_trperizinan.trperizinan_id', 'left');
    $otherdb->where('tmpermohonan.pendaftaran_id',$pendaftaran_id);
    $ambilperizinanid =  $otherdb->get()->row();

    $kertas = $ambilperizinanid->kertas;
    $kordinatttd = $ambilperizinanid->kordinatttd;
    $kordinatqr = $ambilperizinanid->kordinatqr;

    $this->load->library('cfpdf');
    $this->load->library('cfpdi');
    $pdf = new FPDI();
    try{
      $pageCount = $pdf->setSourceFile($filepdf);
      for($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
        $templateId = $pdf->importPage($pageNo);
        $size = $pdf->getTemplateSize($templateId);
        if($kertas == 1){
          if($size['w'] > $size['h']) {
            $pdf->AddPage('L', array($size['w'], $size['h']));
            // $img = base_url('assets/img/bsre.jpg');
            $img = base_url('assets/img/bsre.png');
            $pdf->Image($img,17,190,185,12);
          }else{
            $pdf->AddPage('P', array($size['w'], $size['h']));
            // $img = base_url('assets/img/bsre.jpg');
            $img = base_url('assets/img/bsre.png');
            $pdf->Image($img,17,283,180,12);
          }
        }else{
          if($size['w'] > $size['h']) {
            $pdf->AddPage('L', array($size['w'], $size['h']));
            // $img = base_url('assets/img/bsre.jpg');
            $img = base_url('assets/img/bsre.png');
            $pdf->Image($img,17,190,185,12);
          }else{
            $pdf->AddPage('P', array($size['w'], $size['h']));
            // $img = base_url('assets/img/bsre.jpg');
            $img = base_url('assets/img/bsre.png');
            $pdf->Image($img,17,320,185,12);
          }
        }
        $pdf->useTemplate($templateId);
        if($pageNo == 1){
          if($kordinatttd != ""){
            $kordinattandatangan =explode(",", $kordinatttd);
            $kx = $kordinattandatangan[0];
            $ky = $kordinattandatangan[1];
            $klx = $kordinattandatangan[2];
            $kly = $kordinattandatangan[3];
            $kop = base_url('assets/img/ttd.png');
            $pdf->Image($kop,$kx,$ky,$klx,$kly);
          }
          if($kordinatqr != ""){
            $kordinatqrcode = explode(",", $kordinatqr);
            $kx1 = $kordinatqrcode[0];
            $ky1 = $kordinatqrcode[1];
            $klx1 = $kordinatqrcode[2];
            $kly1 = $kordinatqrcode[3];
            $qr = base_url('assets/img/Capture.png');
            $pdf->Image($qr,$kx1,$ky1,$klx1,$kly1);
          }
        }   
      }
      $pdf->Output($filepdf,'F');
      return true;
    }
    catch (Exception $e) {
      return false;
    }
  }

  // function do_ttd($nip, $namafile, $passphrase) {
  //   $n_SE = (str_replace(' ','',$nip)).'.p12'; //$nip = NIP Kadis penandatangan

  //   $path_jar     = $_SERVER['DOCUMENT_ROOT'].'/spekta/android/assets/esign/signer/JSignPdf.jar';
  //   $path_pdf     = $_SERVER['DOCUMENT_ROOT'].'/spekta/backoffice/assets/skpdf/'.$namafile.'.pdf'; 
  //   $path_p12     = $_SERVER['DOCUMENT_ROOT'].'/spekta/android/assets/esign/signer/'.$n_SE;  
  //   $output_path  = $_SERVER['DOCUMENT_ROOT'].'/spekta/backoffice/assets/esignfile/';
  //   $tsa_url      = "http://tsa-bsre.bssn.go.id/";
  //   $ocsp         = "http://cvs-bsre.bssn.go.id/ocsp";

  //   $command = 'java -jar "'.$path_jar.'" "'.$path_pdf.'" -kst PKCS12 -ksf "'.$path_p12.'" -ksp "'.$passphrase.'" -l "Tasikmalaya" -r "Pengesahan Naskah Perizinan" -c "kontak yang bisa dihubungi" -tsh SHA256 -ha SHA256 -d "'.$output_path.'" -os "" -ts '.$tsa_url.' -ta PASSWORD -tsu "coba" -tsp "1234" --ocsp --ocsp-server-url "'.$ocsp.'"';
  //   exec($command, $val, $er);
    
  //   if($er == 0 || $er == 3){
  //     return true;
  //   }else{
  //     return false;
  //   }
  // }
  
  function do_ttd($nip, $nik, $namafile, $passphrase) {
    $otherdb = $this->load->database('otherdb',TRUE);

    $n_SE = (str_replace(' ','',$nip)).'.p12';

    // $path_jar     = $_SERVER['DOCUMENT_ROOT'].'/android/assets/esign/signer/JSignPdf.jar';
    // $path_jar_new = $_SERVER['DOCUMENT_ROOT'].'/android/assets/esign/signer/esign_client.jar';
    // $path_pdf     = $_SERVER['DOCUMENT_ROOT'].'/jelita/backoffice/assets/skpdf/'.$namafile.'.pdf'; 
    // $path_p12     = $_SERVER['DOCUMENT_ROOT'].'/android/assets/esign/signer/'.$n_SE;  
    // $output_path  = $_SERVER['DOCUMENT_ROOT'].'/jelita/backoffice/assets/esignfile/';
    // $tsa_url      = "http://tsa-bsre.bssn.go.id/";
    // $ocsp         = "http://cvs-bsre.bssn.go.id/ocsp";

    $path_jar     = $_SERVER['DOCUMENT_ROOT'].'/spekta/android/assets/esign/signer/JSignPdf.jar';
    $path_jar_new = $_SERVER['DOCUMENT_ROOT'].'/android/assets/esign/signer/esign_client.jar';
    $path_pdf     = $_SERVER['DOCUMENT_ROOT'].'/spekta/backoffice/assets/skpdf/'.$namafile.'.pdf'; 
    $path_p12     = $_SERVER['DOCUMENT_ROOT'].'/spekta/android/assets/esign/signer/'.$n_SE;  
    $output_path  = $_SERVER['DOCUMENT_ROOT'].'/spekta/backoffice/assets/esignfile/';
    $tsa_url      = "http://tsa-bsre.bssn.go.id/";
    $ocsp         = "http://cvs-bsre.bssn.go.id/ocsp";

    $hasilesign = "";
    $val = array();

      $command = "java -jar ".$path_jar_new." -m sign -f ".$path_pdf." -d ".$output_path." -p '".$passphrase."' -nik ".$nik." -t invisible -l Bandung -r Dokumen_di-TTE";

      exec($command, $val, $er);

      if($er == 0 || $er == 3){ //berhasil
        $hasilesign = str_replace('"', "", $val[0]);

        $cop = @copy($hasilesign, $output_path.$namafile.".pdf");
        if (!$cop) {
          //Simpan Log Gagal
          $dat_log = array( 'tgl_ttd'=>date("Y-m-d H:i:s"),
                            'nik' => $nik,
                            'status' => "1",
                            'info' => implode(" ", $val),
                            'dokumen' => $namafile);
          $otherdb->insert('log_esign',$dat_log);
          //End Simpan Log Gagal

          return false; //gagal copy
        } else {
          if (!unlink($hasilesign)) {
            //Simpan Log Gagal
            $dat_log = array( 'tgl_ttd'=>date("Y-m-d H:i:s"),
                              'nik' => $nik,
                              'status' => "1",
                              'info' => implode(" ", $val),
                              'dokumen' => $namafile);
            $otherdb->insert('log_esign',$dat_log);
            //End Simpan Log Gagal

            return false; //gagal hapus
          }
          //Simpan Log Sukses
          $dat_log = array( 'tgl_ttd'=>date("Y-m-d H:i:s"),
                          'nik' => $nik,
                          'status' => "0",
                          'info' => implode(" ", $val),
                          'dokumen' => $namafile);
          $otherdb->insert('log_esign',$dat_log);
          //End Simpan Log Sukses

          return true; //berhasil
        }
      } else {
        //Simpan Log Gagal
        $dat_log = array( 'tgl_ttd'=>date("Y-m-d H:i:s"),
                          'nik' => $nik,
                          'status' => "1",
                          'info' => implode(" ", $val),
                          'dokumen' => $namafile);
        $otherdb->insert('log_esign',$dat_log);
        //End Simpan Log Gagal

        return false; //gagal execute ttd
      }
  }

}
?>