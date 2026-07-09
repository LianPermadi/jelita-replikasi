<?php
class M_approve_surat extends CI_Model {

  function ambildata($userid) {
    $otherdb = $this->load->database('otherdb',TRUE);
    $data = array();

    $ess = $this->get_eselon($userid);
            // var_dump($ess);die();
    $idpeg = $this->get_pegawai_id($userid);
// var_dump($idpeg, $ess, $data);die();
    // var_dump($idpeg);die();
    switch ($ess) {
      case 1:
        $eselon = "sekdis";
        $app = 3;
        break;
      case 2:
        $eselon = "ess2";
        $app = 2;
        break;
      case 3:
        $eselon = "ess3";
        $app = 4;
        break;
      case 4:
        $eselon = "ess4";
        $app = 1;
        break;
      case 5:
        $eselon = "sekdis";
        $app = 3;
        break;
      default:
        return $data;
        break;
    }
// var_dump($eselon);die();
    $otherdb->select("*");
    $otherdb->from("persuratan");
    $otherdb->where($eselon, $idpeg);
    $otherdb->where("approve", $app);
// var_dump($otherdb);die();sekdi
    if ($ess == "1") {
      //$otherdb->or_where("(ess3 = '3' AND approve = '4')", NULL, FALSE);
	  $otherdb->or_where("(ess3 = '823' AND approve = '4')", NULL, FALSE);
    // $otherdb->or_where("(ess3 = '833' AND approve = '4')", NULL, FALSE);
    // var_dump($ess);die();
    // $otherdb->or_where("(sekdis = '023' AND approve = '4')", NULL, FALSE);
    }
    $otherdb->where("revisi", "0");
    $otherdb->or_where("revisi", "2");
    $surat = $otherdb->get()->result();
    return $surat;
  }

  function data_surat($id) {
    $otherdb = $this->load->database('otherdb',TRUE);
    $otherdb->select("*");
    $otherdb->from("persuratan");
    $otherdb->where("id", $id);
    $surat = $otherdb->get()->row();

    return $surat;
  }

  function data_log($id_surat, $idpegawai) {
    $otherdb = $this->load->database('otherdb',TRUE);
    $otherdb->select("*");
    $otherdb->from("persuratan_log");
    $otherdb->where("persuratan_id", $id_surat);
    $otherdb->where("tmpegawai_id", $idpegawai);
    $datlog = $otherdb->get()->row();

    return $datlog;
  }

  function get_eselon($iduser) {
    $otherdb = $this->load->database('otherdb',TRUE);
    $otherdb->select('tmpegawai.id,eselon,nip');
    $otherdb->from('tmpegawai');
    $otherdb->join('tmpegawai_user','tmpegawai.id = tmpegawai_user.tmpegawai_id','left');
    $otherdb->where('tmpegawai_user.user_id',$iduser);
    $ambileselon =  $otherdb->get()->row();

    if (!empty($ambileselon) && $ambileselon->id == 823) { //023 = ID Pegawai sekdis
      return "1";
    } else {
      if (isset($ambileselon->eselon)) {
        $balik = $ambileselon->eselon;
      } else {
        $balik = "0";
      }

      return $balik;
    }
    
  }

  function get_pegawai_id($iduser) {
    $otherdb = $this->load->database('otherdb',TRUE);
    $otherdb->select('tmpegawai.id, eselon, nip');
    $otherdb->from('tmpegawai');
    $otherdb->join('tmpegawai_user','tmpegawai.id = tmpegawai_user.tmpegawai_id','left');
    $otherdb->where('tmpegawai_user.user_id',$iduser);
    $ambileselon =  $otherdb->get()->row();

    if (isset($ambileselon->id)) {
      $balik = $ambileselon->id;
    } else {
      $balik = "0";
    }

    return $balik;
  }

  function get_pegawai($iduser) {
    $otherdb = $this->load->database('otherdb',TRUE);
    $otherdb->select('tmpegawai.id, tmpegawai.eselon, tmpegawai.nip, tmpegawai.nik');
    $otherdb->from('tmpegawai');
    $otherdb->join('tmpegawai_user','tmpegawai.id = tmpegawai_user.tmpegawai_id','left');
    $otherdb->where('tmpegawai_user.user_id',$iduser);
    $ambileselon =  $otherdb->get()->row();

    return $ambileselon;
  }

  function get_approve($id) {
    $otherdb = $this->load->database('otherdb',TRUE);
    $otherdb->select('*');
    $otherdb->from('persuratan');
    $otherdb->where('id',$id);
    $ambileselon = $otherdb->get()->row();

    $data = array();

    $data['ess'] = $ambileselon->ess2;
    $data['approve'] = 0;

    if ($ambileselon->ess2 == 0) {
      if ($ambileselon->sekdis != 0) {
        $data['ess'] = $ambileselon->sekdis;
        $data['approve'] = 2;
      } else {
        if ($ambileselon->ess3 == 0) {
          $data['ess'] = $ambileselon->ess4;
          $data['approve'] = 4;
        } else if ($ambileselon->sekdis == 0) {
          $data['ess'] = $ambileselon->ess4;
          $data['approve'] = 4;
        } else {
          $data['ess'] = $ambileselon->ess3;
          // $data['ess'] = $ambileselon->sekdis;
          $data['approve'] = 3;
        } 
      }
    }

    return $data;
  }

  function update_permohonan($iduser, $update, $passphrase) {
    date_default_timezone_set("Asia/Bangkok");
    $otherdb = $this->load->database('otherdb',TRUE);
    $passphrase = base64_decode($passphrase);
    $datapegawai = $this->get_pegawai($iduser);
    $surat = $this->data_surat($update);

    $dataapp = $this->get_approve($update);

    $nilai = 0;

    if(!empty($datapegawai)) {
      $idpegawai  = $datapegawai->id;
      $h          = $datapegawai->eselon;
      $nik        = $datapegawai->nik;
      $nip        = $datapegawai->nip;
      $ess        = $datapegawai->eselon;
    } else {
      return $nilai; 
    }

   	?>
    <script src="<?php echo base_url(); ?>assets/esign/jquery-latest.js"></script>
    <?php 
    if ($h == 5) {
        $data=array('approve'=>'2');
    } else if ($idpegawai == "808") { //ID analis hukum
      $data=array('approve' => '3',
                  'jfah'    => $idpegawai);
    } else {
      if($h == 4) {
        $data=array('approve'=>'4');
      } else if($h == 3) {
        if ($surat->analis_hukum == 1) {
          $data=array('approve'=>'6');
        } else {
          $data=array('approve'=>'3');
        }
      } else if($h == 2) {
        $data=array('approve'=>'0');
      }
    }

    $n_file = 'SRT_'. $surat->id.'.pdf';

    if ($surat->logo_bsre == "1") {
      $id = $surat->id;
      $kepada = $surat->kepada;

      $php_self = $_SERVER['SCRIPT_NAME'];
      $url_self = str_replace("/android/index.php", "", $php_self);
      $url_domain = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$url_self;
      $link = $url_domain.'/main/cekiz/unduh_surat/';
      $codeContents = $id.'/'.base64_encode($kepada);
      $codeContents = $link.$codeContents;//.'_idkeyST.'.$key;
      $fileName = 'iz_'.md5($codeContents).'.png';  // Create ID Naskah Key
      $cekfile = $_SERVER['DOCUMENT_ROOT'].$url_self.'/backoffice/uploads/data_qrcode_naskah/'.$fileName;

      if ($this->cek_ttd($n_file) == 0 || $surat->format_file == '1') {
          $this->load->library('cfpdf');
          $this->load->library('cfpdi');
          $pdf = new FPDI();
          $kertas = 1; // 0 legal 1 A4
          
          $filepdf = $_SERVER['DOCUMENT_ROOT'].$url_self.'/backoffice/assets/esign-surat/'.$n_file;
          if(file_exists($filepdf)){
            $filepdf = $_SERVER['DOCUMENT_ROOT'].$url_self.'/backoffice/assets/esign-surat/'.$n_file;
          }else{
            $filepdf = $_SERVER['DOCUMENT_ROOT'].$url_self.'/backoffice/assets/pdf-surat/'.$n_file;
          }
          try{
            $pageCount = $pdf->setSourceFile($filepdf);
            for($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $size = $pdf->getTemplateSize($templateId);
              $pdf->useTemplate($templateId);
              if($kertas == 1){
                if($size['w'] > $size['h']) {
                  $pdf->AddPage('L', array($size['w'], $size['h'])); 
                  $img = base_url('assets/img/bsre.png');
                  $pdf->Image($img,10,10,165,12);
                }else{
                  $pdf->AddPage('P', array($size['w'], $size['h']));
                  $img = base_url('assets/img/bsre.png');
                  $pdf->Image($img,10,10,165,12);
                }
              }else{
                if($size['w'] > $size['h']) {
                  $pdf->AddPage('L', array($size['w'], $size['h']));
                  $img = base_url('assets/img/bsre.png');
                  $pdf->Image($img,10,10,165,12);
                }else{
                  $pdf->AddPage('P', array($size['w'], $size['h']));
                  $img = base_url('assets/img/bsre.png');
                  $pdf->Image($img,10,10,165,12);
                }
              }
              if($pageNo == 1){
                  $qr = $_SERVER['DOCUMENT_ROOT'].$url_self.'/backoffice/uploads/data_qrcode_naskah/'.$fileName;
                  $pdf->Image($qr,1,3,12,12);
              }   
            }
            $pdf->Output($filepdf,'F');
          }


        catch (Exception $e) {
          $test = 'catch';
          $cek = log_message('error', 'PDF Modification Error: ' . $e->getMessage());
          //exception?
        }
      }
    }
    

    $n_SE = (str_replace(' ','',$nip)).'.p12';
    //$n_SE = 'lucky_new.p12';
    $root           = $_SERVER['DOCUMENT_ROOT'];
    $path_jar       = $root.$url_self.'/android/assets/esign/signer/JSignPdf.jar';
    $path_jar_new   = $_SERVER['DOCUMENT_ROOT'].$url_self.'/android/assets/esign/signer/esign_client.jar';
    // $path_pdf       = $root.'/jelita/backoffice/assets/pdf-surat/'.$n_file;
    $path_pdf       = $root.$url_self.'/backoffice/assets/esign-surat/'.$n_file;
    if (file_exists($path_pdf)) {
        // Tampilkan gambar di posisi tertentu pada halaman PDF
        $path_pdf   = $root.$url_self.'/backoffice/assets/pdf-surat/'.$n_file;
    } else {
        // File PDF Code tidak ada, gunakan file pengganti
        $path_pdf   = $root.$url_self.'/backoffice/assets/pdf-surat/'.$n_file;
    }
    $path_p12       = $root.$url_self.'/android/assets/esign/signer/'.$n_SE;

    $output_path = $root.$url_self.'/backoffice/assets/esign-surat/';
    $tsa_url     = "http://tsa-bsre.bssn.go.id/";
    $ocsp        = "http://cvs-bsre.bssn.go.id/ocsp";
      
    if ($dataapp['ess'] == $idpegawai) {
      $data=array('approve'=>'0');

      if (!empty($nik)) { //approval baru jika terdapat NIK pada akun pegawai

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
                CURLOPT_HTTPHEADER => array(
                  'Authorization: Basic ZXNpZ246cXdlcnR5',
                  'Cookie: JSESSIONID=98DE5E535E25B2BB670879451DE8ACBB'
                ),
              ));

              $response = curl_exec($curl);
              curl_close($curl);
              $array_json = array();
              if($response) {
                $json = json_decode($response);
              }
              $array = (array) $json;
              if($json == NULL) {// TTE Berhasil 

                $output_filename = $output_path."SRT_".$update.".pdf";
                $fp = fopen($output_filename, 'w');

                fwrite($fp, $response);

                fclose($fp);
                    $nilai = 1;
              $otherdb->where('id', $surat->id);
              $updt = $otherdb->update('persuratan',$data);

              if ($updt) {
                $log_surat = $this->data_log($surat->id, $idpegawai);

                $data_log = array('persuratan_id' => $surat->id,
                                  'tmpegawai_id' => $idpegawai,
                                  'waktu' => date('Y-m-d H:i:s'),
                                  'ess' => $ess
                                  );

                if (empty($log_surat)) {
                  $save = $otherdb->insert('persuratan_log', $data_log);
                } else {
                  $otherdb->where('persuratan_id', $surat->id);
                  $otherdb->where('tmpegawai_id', $idpegawai);
                  $otherdb->update('persuratan_log',$data_log);
                }

                //Simpan Log Sukses
                $dat_log = array( 'tgl_ttd'=>date("Y-m-d H:i:s"),
                                'nik' => $nik,
                                'status' => "0",
                                // 'info' => implode(" ", $val),
                                'dokumen' => $n_file);
                $otherdb->insert('log_esign',$dat_log);
                //End Simpan Log Sukses

              }
                //EOF() Save Data
                $nilai = 1;

              }

              else{ //TTE Tidak berhasil
                  //Simpan Log Gagal
                  $dat_log = array( 'tgl_ttd'=>date("Y-m-d H:i:s"),
                                    'nik' => $nik,
                                    'status' => "1",
                                    // 'info' => implode(" ", $val),
                                    'dokumen' => $n_file);

                  $otherdb->insert('log_esign',$dat_log);
                  //End Simpan Log Gagal

                  $nilai = 0;

              }
      } else {
        //ttd digital manual
        $command     = 'java -jar "'.$path_jar.'" "'.$path_pdf.'" -kst PKCS12 -ksf "'.$path_p12.'" -ksp "'.$passphrase.'" -l "Dinas PMPTSP Jawa Barat" -r "Pengesahan Surat Permohonan Pertek" -c "dpmptsp-online@jabarprov.go.id" -tsh SHA256 -ha SHA256 -d "'.$output_path.'" -os "" -ts '.$tsa_url.' -ta PASSWORD -tsu "coba" -tsp "1234" --ocsp --ocsp-server-url "'.$ocsp.'"';
                var_dump($dat_log );die();
        
        exec($command, $val, $er);
        if($er == 0 || $er == 3){
          $otherdb->where('id', $surat->id);
          $updt = $otherdb->update('persuratan',$data);

          if ($updt) {
            $nilai = 1;
            $log_surat = $this->data_log($surat->id, $idpegawai);

            $data_log = array('persuratan_id' => $surat->id,
                              'tmpegawai_id' => $idpegawai,
                              'waktu' => date('Y-m-d H:i:s'),
                              'ess' => $ess
                              );

            if (empty($log_surat)) {
              $save = $otherdb->insert('persuratan_log', $data_log);
            } else {
              $otherdb->where('persuratan_id', $surat->id);
              $otherdb->where('tmpegawai_id', $idpegawai);
              $otherdb->update('persuratan_log',$data_log);
            }
          }
          //EOF() Save Data
        } else {
          $nilai = 0;
        }
        // EOF() ttd digital manual
      }

    } else {

      if (!empty($nik)) { //TTD esign bertingkat untuk approval eselon dibawah penanda tangan terakhir

        $output_path = $root.$url_self.'/backoffice/assets/esign-surat/';

       
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
                CURLOPT_HTTPHEADER => array(
                  'Authorization: Basic ZXNpZ246cXdlcnR5',
                  'Cookie: JSESSIONID=98DE5E535E25B2BB670879451DE8ACBB'
                ),
              ));

              $response = curl_exec($curl);
              curl_close($curl);
              $array_json = array();
              if($response) {
                $json = json_decode($response);
              }else{
                $json = array();
              }
              $array = (array) $json;
              // if($json == NULL) {// TTE Berhasil 
              $output_filename = $output_path."SRT_".$update.".pdf";
              if(copy($path_pdf,$output_filename)) {// TTE Berhasil  // development

                $fp = fopen($output_filename, 'w');

                fwrite($fp, $response);        
                //     //Simpan Log Gagal

                fclose($fp);
                $nilai = 1;

              }

              else{ //TTE Tidak berhasil
              //Simpan Log Gagal
              $dat_log = array( 'tgl_ttd'=>date("Y-m-d H:i:s"),
                                'nik' => $nik,
                                'status' => "1",
                                'info' => implode(" ", $val),
                                'dokumen' => $n_file);
              $otherdb->insert('log_esign',$dat_log);
              // var_dump($dat_log );die();

              //End Simpan Log Gagal

              $nilai = 0;

              }

        } else {
          //Simpan Log Gagal
          $dat_log = array( 'tgl_ttd'=>date("Y-m-d H:i:s"),
                            'nik' => $nik,
                            'status' => "1",
                            'info' => implode(" ", $val),
                            'dokumen' => $n_file);
          // var_dump($dat_log );die();

          $otherdb->insert('log_esign',$dat_log);
          //End Simpan Log Gagal
            
          $nilai = 0;
        }
        //End esign baru

      } 
      
      $ess4 = 0;
      $otherdb = $this->load->database('otherdb', TRUE); // TRUE untuk mode objek
      
      $query = $this->db->select('ess4')
          ->from("$otherdb->database.persuratan")
          ->where('id', $surat->id)
          ->get()->row();

      if (!empty($query->ess4)) {
        $ess4 = $query->ess4;
      }

      $ess3 = 0;
      $query = $this->db->select('ess3')
          ->from("$otherdb->database.persuratan")
          ->where('id', $surat->id)
          ->get()->row();

      if (!empty($query->ess3)) {
        $ess3 = $query->ess3;
      }

      $sekdis = 0;
      $query = $this->db->select('sekdis')
          ->from("$otherdb->database.persuratan")
          ->where('id', $surat->id)
          ->get()->row();

      if (!empty($query->sekdis)) {
        $sekdis = $query->sekdis;
      }

      $ess2 = 0;
      $query = $this->db->select('ess2')
          ->from("$otherdb->database.persuratan")
          ->where('id', $surat->id)
          ->get()->row();

      if (!empty($query->ess2)) {
        $ess2 = $query->ess2;
      }

      $approve = 0;
      $query = $this->db->select('approve')
          ->from("$otherdb->database.persuratan")
          ->where('id', $surat->id)
          ->get()->row();

      if (!empty($query->approve)) {
        $approve = $query->approve;
      }

      if($ess4 == 0 && $approve == 5){
        if($ess3 != 0){
          $data = array('approve'=>'4');
        }elseif($sekdis != 0){
          $data = array('approve'=>'3');
        }elseif($ess2){
          $data = array('approve'=>'2');
        }else{
          $data = array('approve'=>'0');
        }
      }    
      if($ess3 == 0 && $approve == 1){
        
        if($sekdis != 0){
          $data = array('approve'=>'3');
        }elseif($ess2){
          $data = array('approve'=>'2');
        }else{
          $data = array('approve'=>'0');
        }
      }     
      if($sekdis == 0 && $approve == 4){
        if($ess2){
          $data = array('approve'=>'2');
        }else{
          $data = array('approve'=>'0');
        }
      }     
      if($ess2 == 0 && $approve == 3){
        $data = array('approve'=>'0');
      }
        if($dataapp['ess'] != $idpegawai){
        $otherdb->where('id', $surat->id);
        $updt = $otherdb->update('persuratan',$data);
        if ($updt) {
          $nilai = 1;
          $log_surat = $this->data_log($surat->id, $idpegawai);

          $data_log = array('persuratan_id' => $surat->id,
                            'tmpegawai_id' => $idpegawai,
                            'waktu' => date('Y-m-d H:i:s'),
                            'ess' => $ess
                            );

          if (empty($log_surat)) {
            $save = $otherdb->insert('persuratan_log', $data_log);
          } else {
            $otherdb->where('persuratan_id', $surat->id);
            $otherdb->where('tmpegawai_id', $idpegawai);
            $otherdb->update('persuratan_log',$data_log);
          }
        } else {
          $nilai = 0;
        }
        //EOF() Save Data
        }
    return $nilai;
      
    }
      


  public function update_revisi($id, $pesan) {
    $otherdb = $this->load->database('otherdb',TRUE);
    $data=array('pesan_revisi' => $pesan,
                'revisi' => "1",
                'approve' => "5"
                );

    $otherdb->where('id', $id);
    $updt = $otherdb->update('persuratan',$data);
    if ($updt) {
      return true;
    } else {
      return false;
    }
  }

  public function cek_ttd($n_file) {
    $root           = $_SERVER['DOCUMENT_ROOT'];
    $path_jar_new   = $_SERVER['DOCUMENT_ROOT'].'/spekta/android/assets/esign/signer/esign_client.jar';
    $path_pdf       = $root.'/spekta/backoffice/assets/pdf-surat/'.$n_file;

    $command = "java -jar ".$path_jar_new." -m verifikasi -f ".$path_pdf." -ot RAW";
    exec($command, $val, $er);
    if($er == 0 || $er == 3) {
      if (isset($val[0])) {
        if (strpos($val[0], 'DOCUMENT VALID !!!') !== false) {
          return 1;
        } else {
          return 0;
        }
      } else {
        return 0;
      }
    } else {
      return 0;
    }
  }

}
?>