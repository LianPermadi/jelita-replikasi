<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Pendaftaran class
 *
 * @author DPMPTSP
 * Created : 22 Jul 2023
 *
 */

class M_approve_surat extends Model {

  function ambildata($userid) {
    $otherdb = $this->load->database('otherdb',TRUE);
    $data = array();

    $ess = $this->get_eselon($userid);
    $idpeg = $this->get_pegawai_id($userid);
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
        $eselon = "ess2";
        $app = 6;
        break;
      case 9:
        $eselon = "ess4";
        $app = 1;
        break;
      default:
        return $data;
        break;
    }

    $otherdb->select("*");
    $otherdb->from("persuratan");
    if ($ess != 5) {
      $otherdb->where($eselon, $idpeg);
    }
    $otherdb->where("approve", $app);
    // if ($idpeg == "83") { //Pak Dindin sementara
    // if ($idpeg == "852") { //Pak Iyan sementara
    if ($idpeg == "808") { //Pak Iyan sementara
      $otherdb->or_where("approve", "6");
    }
    if ($ess == "1") {
      //$otherdb->or_where("(ess3 = '3' AND approve = '4')", NULL, FALSE);
    $otherdb->or_where("(ess3 = '31' AND approve = '4')", NULL, FALSE);
	  // $otherdb->or_where("(ess3 = '1035' OR '31' AND approve = '4')", NULL, FALSE);
    }
    $otherdb->where("revisi !=", "1");
    if ($app == 2) {
      $otherdb->not_like("hal", "Draf pencabutan izin");
    }
    $otherdb->order_by("urgent desc");
    $surat = $otherdb->get()->result();

    return $surat;
  }

  function ambilcabut($userid) {
    $otherdb = $this->load->database('otherdb',TRUE);
    $data = array();

    $ess = $this->get_eselon($userid);
    $idpeg = $this->get_pegawai_id($userid);
    switch ($ess) {
      case 1:
        $eselon = "persuratan.sekdis";
        $app = 3;
        break;
      case 2:
        $eselon = "persuratan.ess2";
        $app = 2;
        break;
      case 3:
        $eselon = "persuratan.ess3";
        $app = 4;
        break;
      case 4:
        $eselon = "persuratan.ess4";
        $app = 1;
        break;
      case 5:
        $eselon = "persuratan.ess2";
        $app = 6;
        break;
      default:
        return $data;
        break;
    }

    $otherdb->select("persuratan.*, persuratan_tmpermohonan.tipe as tipesurat");
    $otherdb->from("persuratan");
    $otherdb->join('persuratan_tmpermohonan','persuratan.id = persuratan_tmpermohonan.persuratan_id', 'left');
    if ($ess != 5) {
      $otherdb->where($eselon, $idpeg);
    }
    $otherdb->where("persuratan.approve", $app);
    if ($ess == "1") {
      //$otherdb->or_where("(ess3 = '3' AND approve = '4')", NULL, FALSE);
    $otherdb->or_where("(persuratan.ess3 = '31' AND persuratan.approve = '4')", NULL, FALSE);
    // $otherdb->or_where("(persuratan.ess3 = '1035' OR '31' AND persuratan.approve = '4')", NULL, FALSE);
    }
    $otherdb->where("(persuratan.revisi != '1')", NULL, FALSE);
    $otherdb->where("(persuratan_tmpermohonan.tipe = '1' OR persuratan.hal LIKE '%Draf pencabutan izin%')", NULL, FALSE);
    $otherdb->order_by("persuratan.urgent desc");
    $surat = $otherdb->get()->result();

    return $surat;
  }

  function ambiltolak($userid) {
    $otherdb = $this->load->database('otherdb',TRUE);
    $data = array();

    $ess = $this->get_eselon($userid);
    $idpeg = $this->get_pegawai_id($userid);
    switch ($ess) {
      case 1:
        $eselon = "persuratan.sekdis";
        $app = 3;
        break;
      case 2:
        $eselon = "persuratan.ess2";
        $app = 2;
        break;
      case 3:
        $eselon = "persuratan.ess3";
        $app = 4;
        break;
      case 4:
        $eselon = "persuratan.ess4";
        $app = 1;
        break;
      case 5:
        $eselon = "persuratan.ess2";
        $app = 6;
        break;
      default:
        return $data;
        break;
    }

    $otherdb->select("persuratan.*, persuratan_tmpermohonan.tipe as tipesurat");
    $otherdb->from("persuratan");
    $otherdb->join('persuratan_tmpermohonan','persuratan.id = persuratan_tmpermohonan.persuratan_id', 'left');
    if ($ess != 5) {
      $otherdb->where($eselon, $idpeg);
    }
    $otherdb->where("persuratan.approve", $app);
    if ($ess == "1") {
      //$otherdb->or_where("(ess3 = '3' AND approve = '4')", NULL, FALSE);
    $otherdb->or_where("(persuratan.ess3 = '31' AND persuratan.approve = '4')", NULL, FALSE);
    // $otherdb->or_where("(persuratan.ess3 = '1035' OR '31' AND persuratan.approve = '4')", NULL, FALSE);
    }
    $otherdb->where("(persuratan.revisi != '1')", NULL, FALSE);
    $otherdb->where("(persuratan_tmpermohonan.tipe = '0' OR persuratan.hal LIKE '%Draf pencabutan izin%')", NULL, FALSE);
    $otherdb->order_by("persuratan.urgent desc");
    $surat = $otherdb->get()->result();

    return $surat;
  }

  function update_data_approve($h, $nodaftar, $passphrase, $iduser){
    
    $user_auth = $this->db->get_where('db_sicantik_backoffice.user', ['id' => $iduser])->row_array();
    if(!empty($user_auth)){
      $data = array(
          'auth_token' => base64_encode($passphrase)
      );

      // Mengupdate data di tabel 'api.test' berdasarkan 'id_daftar'
      $this->db->where('id', $iduser);
      $save = $this->db->update('db_sicantik_backoffice.user', $data);
    }
    $ada_tidak = $this->db->get_where('api.test', ['id_daftar' => $nodaftar])->row_array();
    if(!empty($ada_tidak)){
      if($h == '2'){
        $data = array(
            't2'     => $iduser,
            'test' => base64_encode($passphrase)
        );
      }
      if($h == '3'){
        $data = array(
            't3'     => $iduser,
            'testt' => base64_encode($passphrase)
        );
      }
      if($h == '4'){
        $data = array(
            't4'     => $iduser,
            'testtt' => base64_encode($passphrase)
        );
      }

      // Mengupdate data di tabel 'api.test' berdasarkan 'id_daftar'
      $this->db->where('id_daftar', $nodaftar);
      $save = $this->db->update('api.test', $data);
    }else{
        $data = array(
            't4'        => $iduser,
            'testtt'    => base64_encode($passphrase),
            'id_daftar' => $nodaftar
        );
        $save = $this->db->insert('api.test', $data);
    }
    return $save;
  }

  function caridata_surat($no_surat, $userid) {
    $otherdb = $this->load->database('otherdb',TRUE);
    $data = array();

    $ess = $this->get_eselon($userid);
    $idpeg = $this->get_pegawai_id($userid);
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
        $eselon = "ess2";
        $app = 6;
        break;
      default:
        return $data;
        break;
    }

    $otherdb->select("*");
    $otherdb->from("persuratan");
    if ($ess != 5) {
      $otherdb->where($eselon, $idpeg);
    }
    $otherdb->where("approve", $app);
    if ($ess == "1") {
      //$otherdb->or_where("(ess3 = '3' AND approve = '4')", NULL, FALSE);
    $otherdb->or_where("(ess3 = '31' AND approve = '4')", NULL, FALSE);
    // $otherdb->or_where("(ess3 = '1035' OR '31' AND approve = '4')", NULL, FALSE);
    }
    $otherdb->where("nomor_surat", $no_surat);
    $otherdb->where("revisi", "0");
    $otherdb->or_where("revisi", "2");
    $otherdb->order_by("urgent desc");
    $surat = $otherdb->get()->result();

    return $surat;
  }

  function data_surat($id) {
    // $otherdb = $this->load->database('otherdb',TRUE);
    // $otherdb->select("*");
    // $otherdb->from("persuratan");
    // $otherdb->where("id", $id);
    // $surat = $otherdb->get()->row();

    $surat = '-';

    $query = $this->db->select("*")
        ->from("persuratan")
        ->where("id", $id)
        ->get()->row();

    if (!empty($query)) {
      $surat = $query;
    }
    // var_dump($surat);die();
    return $surat;
  }

  function data_log($id_surat, $idpegawai) {
    // $otherdb = $this->load->database('otherdb',TRUE);
    // $otherdb->select("*");
    // $otherdb->from("persuratan_log");
    // $otherdb->where("persuratan_id", $id_surat);
    // $otherdb->where("tmpegawai_id", $idpegawai);
    // $datlog = $otherdb->get()->row();
    $datlog = '-';

    $query = $this->db->select("*")
        ->from("db_sicantik_backoffice.persuratan_log")
        ->where("persuratan_id", $id_surat)
        ->where("tmpegawai_id", $idpegawai)
        ->get()->row();

    if (!empty($query)) {
      $datlog = $query;
    }
    // var_dump($surat);die();
    // return $surat;

    return $datlog;
  }

  function get_eselon($iduser) {
    // $otherdb = $this->load->database('otherdb',TRUE);
    // $otherdb->select('tmpegawai.id,eselon,nip');
    // $otherdb->from('tmpegawai');
    // $otherdb->join('tmpegawai_user','tmpegawai.id = tmpegawai_user.tmpegawai_id','left');
    // $otherdb->where('tmpegawai_user.user_id',$iduser);
    // $ambileselon =  $otherdb->get()->row();
        $ambileselon = " - ";
        $pegawai = $this->db->select('tmpegawai.id,eselon,nip')
            ->from('tmpegawai')
            ->join('tmpegawai_user','tmpegawai.id = tmpegawai_user.tmpegawai_id','left')
            ->where('tmpegawai_user.user_id',$iduser)
            ->get()->row();

        if (!empty($pegawai)) {
            $ambileselon = $pegawai;
        }
        // return $ambileselon;

    // if ($ambileselon->id == 1035) { //1035 = ID Pegawai pak Eka
    if ($ambileselon->id == 31) { 
      return "1";
    } else if ($ambileselon->id == 808) {
    // } else if ($ambileselon->id == 852) {
    // } else if ($ambileselon->id == 83) {
      return "5";
    } else {
      return $ambileselon->eselon;
    }
    
  }

  function get_pegawai_id($iduser) {
    $otherdb = $this->load->database('otherdb',TRUE);
    $otherdb->select('tmpegawai.id, eselon, nip');
    $otherdb->from('tmpegawai');
    $otherdb->join('tmpegawai_user','tmpegawai.id = tmpegawai_user.tmpegawai_id','left');
    $otherdb->where('tmpegawai_user.user_id',$iduser);
    $ambileselon =  $otherdb->get()->row();

    return $ambileselon->id;
  }

  function get_pegawai($iduser) {
    // $otherdb = $this->load->database('otherdb',TRUE);
    // $otherdb->select('tmpegawai.id, tmpegawai.eselon, tmpegawai.nip, tmpegawai.nik');
    // $otherdb->from('tmpegawai');
    // $otherdb->join('tmpegawai_user','tmpegawai.id = tmpegawai_user.tmpegawai_id','left');
    // $otherdb->where('tmpegawai_user.user_id',$iduser);
    // $ambileselon =  $otherdb->get()->row();
    $ambileselon = '-';

    $query = $this->db->select('tmpegawai.id, tmpegawai.eselon, tmpegawai.nip, tmpegawai.nik')
        ->from('tmpegawai')
        ->join('tmpegawai_user', 'tmpegawai.id = tmpegawai_user.tmpegawai_id', 'left')
        ->where('tmpegawai_user.user_id', $iduser)
        ->get()->row();

    if (!empty($query)) {
      $ambileselon = $query;
    }

    // var_dump($ambileselon);
    return $ambileselon;

  }

  function id_peminjaman_mobil($update) {
    // $otherdb = $this->load->database('otherdb',TRUE);
    // $otherdb->select('tmpegawai.id, tmpegawai.eselon, tmpegawai.nip, tmpegawai.nik');
    // $otherdb->from('tmpegawai');
    // $otherdb->join('tmpegawai_user','tmpegawai.id = tmpegawai_user.tmpegawai_id','left');
    // $otherdb->where('tmpegawai_user.user_id',$iduser);
    // $ambileselon =  $otherdb->get()->row();
    $ambileselon = '-';

    $query = $this->db->select('id_mobil')
        ->from('persuratan')
        ->where('id', $update)
        ->get()->row();

    if (!empty($query->id_mobil)) {
      $ambileselon = $query->id_mobil;
    }

    // var_dump($ambileselon);
    return $ambileselon;

  }

  function get_approve($id) {
    // $otherdb = $this->load->database('otherdb',TRUE);
    // $otherdb->select('*');
    // $otherdb->from('persuratan');
    // $otherdb->where('id',$id);
    // $ambileselon = $otherdb->get()->row();
    $ambileselon = " - ";
        $pegawai = $this->db->select('*')
            ->from('persuratan')
            ->where('id',$id)
            ->get()->row();

        if (!empty($pegawai)) {
            $ambileselon = $pegawai;
        }

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
        } else {
          $data['ess'] = $ambileselon->ess3;
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
    <script src="https://dpmptsp.jabarprov.go.id/android/assets/esign/jquery-latest.js"></script>
     <?php 
    if ($idpegawai == "31") {
        $data=array('approve'=>'2');
    // } else if ($idpegawai == "83" || $idpegawai == "852") { //ID analis hukum
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
    // var_dump($n_file);die();
    if ($surat->logo_bsre == "1") {
      $id = $surat->id;
      $kepada = $surat->kepada;

      $link = 'https://dpmptsp.jabarprov.go.id/jelita/main/cekiz/unduh_surat/';
      $codeContents = $id.'/'.base64_encode($kepada);
      $codeContents = $link.$codeContents;//.'_idkeyST.'.$key;
      $fileName = 'iz_'.md5($codeContents).'.png';  // Create ID Naskah Key

      if ($this->cek_ttd($n_file) == 0) {
        //Tempel Logo BSRE (Rekomendasi kertas ukuran F4 atau Legal)
        $this->load->library('cfpdf');
        $this->load->library('cfpdi');
        $pdf = new FPDI();
      
        $filepdf = $_SERVER['DOCUMENT_ROOT'].'/jelita/backoffice/assets/pdf-surat/'.$n_file;
           
        try{
          $pageCount = $pdf->setSourceFile($filepdf);
            
          for($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $size = array();
            $templateId = $pdf->importPage($pageNo);
            $size = $pdf->getTemplateSize($templateId);
              if($size['w'] > $size['h']) {
                $pdf->AddPage('L', array($size['w'], $size['h']));
                //$img = base_url('assets/img/bsre.jpg');
                // $img = base_url('assets/img/bsre.png');
                // $pdf->Image($img,17,190,185,12);

                $img = base_url('assets/img/footer_bsre.png');
                $pdf->Image($img,30,190,165,12);

                $img2 = $_SERVER['DOCUMENT_ROOT'].'/jelita/backoffice/uploads/data_qrcode_naskah/'.$fileName;
                $pdf->Image($img2,15,190,12);
              }else{
                $pdf->AddPage('P', array($size['w'], $size['h']));
                //$img = base_url('assets/img/bsre.jpg');
                // $img = base_url('assets/img/bsre.png');
                // $pdf->Image($img,17,310,180,12);

                $img = base_url('assets/img/footer_bsre.png');
                $pdf->Image($img,30,310,165,12);

                $img2 = $_SERVER['DOCUMENT_ROOT'].'/jelita/backoffice/uploads/data_qrcode_naskah/'.$fileName;
                $pdf->Image($img2,15,310,12);
              }
            $pdf->useTemplate($templateId);
          }
          $pdf->Output($filepdf,'F');
        }
        catch (Exception $e) {
          //exception?
        }
        //end Tempel Logo BSRE
      }
    }
    

    $n_SE = (str_replace(' ','',$nip)).'.p12';
    //$n_SE = 'lucky_new.p12';
    $root           = $_SERVER['DOCUMENT_ROOT'];
    $path_jar       = $root.'/android/assets/esign/signer/JSignPdf.jar';
    $path_jar_new   = $_SERVER['DOCUMENT_ROOT'].'/android/assets/esign/signer/esign_client.jar';
    $path_pdf       = $root.'/jelita/backoffice/assets/pdf-surat/'.$n_file;
    $path_p12       = $root.'/android/assets/esign/signer/'.$n_SE;

    $output_path = $root.'/jelita/backoffice/assets/esign-surat/';
    $tsa_url     = "http://tsa-bsre.bssn.go.id/";
    $ocsp        = "http://cvs-bsre.bssn.go.id/ocsp";
      
    // var_dump($dataapp['ess'].' = '.$idpegawai);die();
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
             
                // die();
                  // var_dump($json);die();
              if($json == NULL) {// TTE Berhasil 

                $output_filename = $output_path."SRT_".$update.".pdf";
                // var_dump($output_filename);die();
                $fp = fopen($output_filename, 'w');

                fwrite($fp, $response);

                fclose($fp);

              }

              else{ //TTE Tidak berhasil

              }

        //Start esign baru
        // $command = "java -jar ".$path_jar_new." -m sign -f ".$path_pdf." -d ".$output_path." -p '".$passphrase."' -nik ".$nik." -t invisible -l Bandung -r Dokumen_di-TTE";
        // exec($command, $val, $er);
          // var_dump($command);die();





        // var_dump($response);die();


        if($er == 0 || $er == 3){
          $hasilesign = str_replace('"', "", $val[0]);
          $cop = copy($hasilesign, $output_path."SRT_".$update.".pdf");
          if (!$cop) {
            //Simpan Log Gagal
            $dat_log = array( 'tgl_ttd'=>date("Y-m-d H:i:s"),
                              'nik' => $nik,
                              'status' => "1",
                              'info' => implode(" ", $val),
                              'dokumen' => $n_file);
            $otherdb->insert('log_esign',$dat_log);
            //End Simpan Log Gagal

            $nilai = 0;
          } else {
            if (unlink($hasilesign)) {
              // Save Data
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
                                'info' => implode(" ", $val),
                                'dokumen' => $n_file);
                $otherdb->insert('log_esign',$dat_log);
                $approve_data = $this->update_data_approve($h, $update, $passphrase, $iduser);
                //End Simpan Log Sukses

                $nilai = 1;
              }
              //EOF() Save Data
            } else {
              //Simpan Log Gagal
              $dat_log = array( 'tgl_ttd'=>date("Y-m-d H:i:s"),
                                'nik' => $nik,
                                'status' => "1",
                                'info' => implode(" ", $val),
                                'dokumen' => $n_file);
              $otherdb->insert('log_esign',$dat_log);
              //End Simpan Log Gagal

              $nilai = 0;
            }
          }
        } else {
          //Simpan Log Gagal
          $dat_log = array( 'tgl_ttd'=>date("Y-m-d H:i:s"),
                            'nik' => $nik,
                            'status' => "1",
                            'info' => implode(" ", $val),
                            'dokumen' => $n_file);
          $otherdb->insert('log_esign',$dat_log);
          //End Simpan Log Gagal

          $nilai = 0;
        }
        //end esign baru

      } else {
        //ttd digital manual
        $command     = 'java -jar "'.$path_jar.'" "'.$path_pdf.'" -kst PKCS12 -ksf "'.$path_p12.'" -ksp "'.$passphrase.'" -l "Dinas PMPTSP Jawa Barat" -r "Pengesahan Surat Permohonan Pertek" -c "dpmptsp-online@jabarprov.go.id" -tsh SHA256 -ha SHA256 -d "'.$output_path.'" -os "" -ts '.$tsa_url.' -ta PASSWORD -tsu "coba" -tsp "1234" --ocsp --ocsp-server-url "'.$ocsp.'"';
        
        exec($command, $val, $er);
        if($er == 0 || $er == 3){
          // jika berhasil

          // Save Data
          // var_dum
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

        //Start esign baru
        $output_path = $root.'/jelita/backoffice/assets/pdf-surat/';

        $command = "java -jar ".$path_jar_new." -m sign -f ".$path_pdf." -d ".$output_path." -p '".$passphrase."' -nik ".$nik." -t invisible -l Bandung -r Dokumen_di-TTE";
        exec($command, $val, $er);
        if($er == 0 || $er == 3){
          $hasilesign = str_replace('"', "", $val[0]);
          $cop = @copy($hasilesign, $output_path."SRT_".$update.".pdf");
          if (!$cop) {
            //Simpan Log Gagal
            $dat_log = array( 'tgl_ttd'=>date("Y-m-d H:i:s"),
                              'nik' => $nik,
                              'status' => "1",
                              'info' => implode(" ", $val),
                              'dokumen' => $n_file);
            $otherdb->insert('log_esign',$dat_log);
            //End Simpan Log Gagal

            $nilai = 0;
          } else {
            if (unlink($hasilesign)) {
              // Save Data
              // var_dump($data);die();
              if(empty($data)){
                  $data=array('approve'=>'3');
              }
              $otherdb->where('id', $surat->id);
              $updt = $otherdb->update('db_sicantik_backoffice.persuratan',$data);
              if ($updt) {
                $log_surat = $this->data_log($surat->id, $idpegawai);

                $data_log = array('persuratan_id' => $surat->id,
                                  'tmpegawai_id' => $idpegawai,
                                  'waktu' => date('Y-m-d H:i:s'),
                                  'ess' => $ess
                                  );
                
                if (empty($log_surat)) {
                  $save = $otherdb->insert('db_sicantik_backoffice.persuratan_log', $data_log);
                } else {
                  $otherdb->where('persuratan_id', $surat->id);
                  $otherdb->where('tmpegawai_id', $idpegawai);
                  $otherdb->update('db_sicantik_backoffice.persuratan_log',$data_log);
                }

                $nilai = 1;

                //Simpan Log Sukses
                $dat_log = array( 'tgl_ttd'=>date("Y-m-d H:i:s"),
                                'nik' => $nik,
                                'status' => "0",
                                'info' => implode(" ", $val),
                                'dokumen' => $n_file);
                $otherdb->insert('log_esign',$dat_log);
                //End Simpan Log Sukses
              }
              //EOF() Save Data
            } else {
              //Simpan Log Gagal
              $dat_log = array( 'tgl_ttd'=>date("Y-m-d H:i:s"),
                                'nik' => $nik,
                                'status' => "1",
                                'info' => implode(" ", $val),
                                'dokumen' => $n_file);
              $otherdb->insert('log_esign',$dat_log);
              //End Simpan Log Gagal

              $nilai = 0;
            }
          }
        } else {
          //Simpan Log Gagal
          $dat_log = array( 'tgl_ttd'=>date("Y-m-d H:i:s"),
                            'nik' => $nik,
                            'status' => "1",
                            'info' => implode(" ", $val),
                            'dokumen' => $n_file);
          $otherdb->insert('log_esign',$dat_log);
          //End Simpan Log Gagal
            
          $nilai = 0;
        }
        //End esign baru

      } else {
        // Save Data
        $otherdb->where('id', $surat->id);
        $updt = $otherdb->update('db_sicantik_backoffice.persuratan',$data);
        if ($updt) {
          $nilai = 1;
          $log_surat = $this->data_log($surat->id, $idpegawai);

          $data_log = array('persuratan_id' => $surat->id,
                            'tmpegawai_id' => $idpegawai,
                            'waktu' => date('Y-m-d H:i:s'),
                            'ess' => $ess
                            );

          if (empty($log_surat)) {
            $save = $otherdb->insert('db_sicantik_backoffice.persuratan_log', $data_log);
          } else {
            $otherdb->where('persuratan_id', $surat->id);
            $otherdb->where('tmpegawai_id', $idpegawai);
            $otherdb->update('db_sicantik_backoffice.persuratan_log',$data_log);
          }
        } else {
          $nilai = 0;
        }
        //EOF() Save Data
      }
    }
    return $nilai;
  }



  function update_permohonan1($iduser, $update, $passphrase) {
    $routees        = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
    $root           = rtrim($_SERVER['DOCUMENT_ROOT'], '/'); // buang trailing slash
    $routees        = ltrim($routees, '/');              // buang leading slash
    $routees_portal = str_replace('backoffice/index.php', '', $_SERVER['SCRIPT_NAME']); 
    $master_url     = $_SERVER['REQUEST_SCHEME'] .'://'. $_SERVER['HTTP_HOST'];
    date_default_timezone_set("Asia/Bangkok");
    $otherdb = $this->load->database('otherdb',TRUE);
    $passphrase = base64_decode($passphrase);
    $datapegawai = $this->get_pegawai($iduser);
    $surat = $this->data_surat($update);

    $dataapp = $this->get_approve($update);
    // var_dump($dataapp['ess']);die();

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
    <script src="<?php echo $master_url.'/'; ?>android/assets/esign/jquery-latest.js"></script>
     <?php 

    // if ($idpegawai == "1035") { //ID Sekdis Pak Eka
    if ($idpegawai == "31") {
        $data=array('approve'=>'2');
    // } else if ($idpegawai == "83" || $idpegawai == "852") { //ID analis hukum
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

      $link = $master_url.$routees_portal.'main/cekiz/unduh_surat/';
      $codeContents = $id.'/'.base64_encode($kepada);
      $codeContents = $link.$codeContents;//.'_idkeyST.'.$key;
      $fileName = 'iz_'.md5($codeContents).'.png';  // Create ID Naskah Key

      if ($this->cek_ttd($n_file) == 0) {
    $kertas = 1;
    $pageNo = 1;
              $this->load->library('cfpdf');
          $this->load->library('cfpdi');
          $pdf = new FPDI();
          $filepdf = $_SERVER['DOCUMENT_ROOT'].'/'.$routees.'/assets/pdf-surat/'.$n_file;
          try{
            $pageCount = $pdf->setSourceFile($filepdf);
              $templateId = $pdf->importPage($pageNo);
              $size = $pdf->getTemplateSize($templateId);
              if($kertas == 1){
                if($size['w'] > $size['h']) {
                  $pdf->AddPage('L', array($size['w'], $size['h']));
                  // $img = base_url('assets/img/bsre.jpg');
                  $img = $_SERVER['DOCUMENT_ROOT'].'/'.$routees.'/uploads/data_qrcode_naskah/'.$fileName;
                  $pdf->Image($img,97,170,23,23);
                  $img2 = $_SERVER['DOCUMENT_ROOT'].'/android/assets/img/bsre.png';
                  $pdf->Image($img2,17,330,180,12);
                }else{
                  $pdf->AddPage('P', array($size['w'], $size['h']));
                  // $img = base_url('assets/img/bsre.jpg');
                  // $img = '/var/www/html/jelita/backoffice/uploads/logo/bsre.png';
                  $img = $_SERVER['DOCUMENT_ROOT'].'/'.$routees.'/uploads/data_qrcode_naskah/'.$fileName;
                  $pdf->Image($img,97,170,23,23);
                  $img2 = $_SERVER['DOCUMENT_ROOT'].'/android/assets/img/bsre.png';
                  $pdf->Image($img2,17,330,180,12);
                }
              }
              $pdf->useTemplate($templateId);
            $pdf->Output($filepdf,'F');
          }
          catch (Exception $e) {
            //exception?
          }
      } 
    }
    // var_dump('https://dpmptsp.jabarprov.go.id/jelita/backoffice/assets/pdf-surat/'.$n_file);die();
    

    $n_SE = (str_replace(' ','',$nip)).'.p12';
    //$n_SE = 'lucky_new.p12';
    $root           = $_SERVER['DOCUMENT_ROOT'];
    $path_jar       = $root.'/android/assets/esign/signer/JSignPdf.jar';
    $path_jar_new   = $_SERVER['DOCUMENT_ROOT'].'/android/assets/esign/signer/esign_client.jar';
    $path_pdf       = $root.'/'.$routees.'/assets/pdf-surat/'.$n_file;
    $path_p12       = $root.'/android/assets/esign/signer/'.$n_SE;

    $output_path = $root.'/'.$routees.'/assets/esign-surat/';
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
             
                // die();
                  // var_dump($json);die();
              if($json == NULL) {// TTE Berhasil 

                $output_filename = $output_path."SRT_".$update.".pdf";
                // var_dump($output_filename);die();
                $fp = fopen($output_filename, 'w');

                fwrite($fp, $response);

                fclose($fp);

                $approve = "-";
                $pegawai = $this->db->select('approve')
                    ->from('persuratan')
                    ->where('id',$update)
                    ->get()->row();


                if (!empty($pegawai)) {
                    $approve = $pegawai->approve;
                }

                if($approve != '-'){
                // var_dump($approve);die();
                  if($approve == 1){
                      $nomor = 4;
                    }elseif($approve == 4){
                      $nomor = 3;
                    }

                    $data = array(
                      'approve' => $nomor
                    );
                  $this->db->where('id', $update);
                  $save = $this->db->update('persuratan', $data);
                  $nilai = 1;
                }else{ //TTE Tidak berhasil
                    $data = array(
                      'approve' => $approve
                    );
                  $this->db->where('id', $update);
                  $save = $this->db->update('persuratan', $data);
                  $nilai = 0;
                }

              }

              else{ //TTE Tidak berhasil
                $er = 1;
                $nilai = 0;

              }

        //Start esign baru
        // $command = "java -jar ".$path_jar_new." -m sign -f ".$path_pdf." -d ".$output_path." -p '".$passphrase."' -nik ".$nik." -t invisible -l Bandung -r Dokumen_di-TTE";
        // exec($command, $val, $er);
        // var_dump($command);die();
        //end esign baru

      } else {
        //ttd digital manual
        $command     = 'java -jar "'.$path_jar.'" "'.$path_pdf.'" -kst PKCS12 -ksf "'.$path_p12.'" -ksp "'.$passphrase.'" -l "Dinas PMPTSP Jawa Barat" -r "Pengesahan Surat Permohonan Pertek" -c "dpmptsp-online@jabarprov.go.id" -tsh SHA256 -ha SHA256 -d "'.$output_path.'" -os "" -ts '.$tsa_url.' -ta PASSWORD -tsu "coba" -tsp "1234" --ocsp --ocsp-server-url "'.$ocsp.'"';
        
        exec($command, $val, $er);
        if($er == 0 || $er == 3){
          // jika berhasil

          // Save Data
          // var_dum
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

        //Start esign baru
        $output_path = $root.'/'.$routees.'assets/pdf-surat/';
        $output_path_esign = $root.'/'.$routees.'assets/esign-surat/';


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
             
                // die();
                  // var_dump($json);die();
              if($json == NULL) {// TTE Berhasil 

                $output_filename = $output_path."SRT_".$update.".pdf";
                $output_filename_esign = $output_path_esign."SRT_".$update.".pdf";
                // var_dump($output_filename);die();
                $fp = fopen($output_filename, 'w');

                fwrite($fp, $response);

                fclose($fp);
                $fp1 = fopen($output_filename_esign, 'w');

                fwrite($fp1, $response);

                fclose($fp1);
                $approve = "-";
                $pegawai = $this->db->select('approve')
                    ->from('persuratan')
                    ->where('id',$update)
                    ->get()->row();

                if (!empty($pegawai)) {
                    $approve = $pegawai->approve;
                }
                if($approve != '-'){
                  if($approve == 1){
                      $nomor = 4;
                    }elseif($approve == 4){
                      $nomor = 3;
                    }

                    $data = array(
                      'approve' => $nomor
                    );
                  $this->db->where('id', $update);
                  $save = $this->db->update('persuratan', $data);
                  $nilai = 1;
                }else{ //TTE Tidak berhasil
                    $data = array(
                      'approve' => $approve
                    );
                  $this->db->where('id', $update);
                  $save = $this->db->update('persuratan', $data);
                  $nilai = 0;
                }
                

              }else{ //TTE Tidak berhasil
                $nilai = 0;
                $er = 0;
              }
        //End esign baru

      } else {
        // Save Data
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
    }
    // var_dump($nilai);die();
    return $nilai;
  }

  function update_permohonan2($iduser, $update, $passphrase) {
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
    <!-- sftp://root@172.10.10.32:2232/var/www/html/android/assets/esign/jquery-latest.js -->
    <script src="https://dpmptsp.jabarprov.go.id/android/assets/esign/jquery-latest.js"></script>
    <?php 

    // if ($idpegawai == "1035") { //ID Sekdis Pak Eka
    if ($idpegawai == "31") {
        $data=array('approve'=>'2');
    // } else if ($idpegawai == "83" || $idpegawai == "852") { //ID analis hukum
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

      $link = 'https://dpmptsp.jabarprov.go.id/jelita/main/cekiz/unduh_surat/';
      $codeContents = $id.'/'.base64_encode($kepada);
      $codeContents = $link.$codeContents;//.'_idkeyST.'.$key;
      $fileName = 'iz_'.md5($codeContents).'.png';  // Create ID Naskah Key

      if ($this->cek_ttd($n_file) == 0) {
        //Tempel Logo BSRE (Rekomendasi kertas ukuran F4 atau Legal)
        $this->load->library('cfpdf');
        $this->load->library('cfpdi');
        $pdf = new FPDI();
      
        $filepdf = $_SERVER['DOCUMENT_ROOT'].'/jelita/backoffice/assets/pdf-surat/'.$n_file;
        
        try{
          $pageCount = $pdf->setSourceFile($filepdf);
          for($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $size = array();
            $templateId = $pdf->importPage($pageNo);
            $size = $pdf->getTemplateSize($templateId);
              if($size['w'] > $size['h']) {
                $pdf->AddPage('L', array($size['w'], $size['h']));
                //$img = base_url('assets/img/bsre.jpg');
                // $img = base_url('assets/img/bsre.png');
                // $pdf->Image($img,17,190,185,12);

                $img = base_url('assets/img/footer_bsre.png');
                $pdf->Image($img,30,190,165,12);

                $img2 = $_SERVER['DOCUMENT_ROOT'].'/jelita/backoffice/uploads/data_qrcode_naskah/'.$fileName;
                // var_dump($img2);die();
                $pdf->Image($img2,15,190,12);
              }else{
                $pdf->AddPage('P', array($size['w'], $size['h']));
                //$img = base_url('assets/img/bsre.jpg');
                // $img = base_url('assets/img/bsre.png');
                // $pdf->Image($img,17,310,180,12);

                $img = base_url('assets/img/footer_bsre.png');
                $pdf->Image($img,30,310,165,12);

                $img2 = $_SERVER['DOCUMENT_ROOT'].'/jelita/backoffice/uploads/data_qrcode_naskah/'.$fileName;
                $pdf->Image($img2,15,310,12);
              }
            $pdf->useTemplate($templateId);
          }
          $pdf->Output($filepdf,'F');
        }
        catch (Exception $e) {
          //exception?
        }
        //end Tempel Logo BSRE
      }
    }
    

    $n_SE = (str_replace(' ','',$nip)).'.p12';
    //$n_SE = 'lucky_new.p12';
    $root           = $_SERVER['DOCUMENT_ROOT'];
    $path_jar       = $root.'/android/assets/esign/signer/JSignPdf.jar';
    $path_jar_new   = $_SERVER['DOCUMENT_ROOT'].'/android/assets/esign/signer/esign_client.jar';
    $path_pdf       = $root.'/jelita/backoffice/assets/pdf-surat/'.$n_file;
    $path_p12       = $root.'/android/assets/esign/signer/'.$n_SE;

    $output_path = $root.'/jelita/backoffice/assets/esign-surat/';
    $tsa_url     = "http://tsa-bsre.bssn.go.id/";
    $ocsp        = "http://cvs-bsre.bssn.go.id/ocsp";
      
    if ($dataapp['ess'] == $idpegawai) {
      $data=array('approve'=>'0');

      if (!empty($nik)) { //approval baru jika terdapat NIK pada akun pegawai

        //Start esign baru
        $command = "java -jar ".$path_jar_new." -m sign -f ".$path_pdf." -d ".$output_path." -p '".$passphrase."' -nik ".$nik." -t invisible -l Bandung -r Dokumen_di-TTE";
        exec($command, $val, $er);
        // var_dump($command);die();
        if($er == 0 || $er == 3){
          $hasilesign = str_replace('"', "", $val[0]);
          $cop = copy($hasilesign, $output_path."SRT_".$update.".pdf");
          if (!$cop) {
            //Simpan Log Gagal
            $dat_log = array( 'tgl_ttd'=>date("Y-m-d H:i:s"),
                              'nik' => $nik,
                              'status' => "1",
                              'info' => implode(" ", $val),
                              'dokumen' => $n_file);
            $otherdb->insert('log_esign',$dat_log);
            //End Simpan Log Gagal

            $nilai = 0;
          } else {
            if (unlink($hasilesign)) {
              // Save Data
              $otherdb->where('id', $surat->id);
              $updt = $otherdb->update('db_sicantik_backoffice.persuratan',$data);
              if ($updt) {
                $log_surat = $this->data_log($surat->id, $idpegawai);

                $data_log = array('persuratan_id' => $surat->id,
                                  'tmpegawai_id' => $idpegawai,
                                  'waktu' => date('Y-m-d H:i:s'),
                                  'ess' => $ess
                                  );

                if (empty($log_surat)) {
                  $save = $otherdb->insert('db_sicantik_backoffice.persuratan_log', $data_log);
                } else {
                  $otherdb->where('persuratan_id', $surat->id);
                  $otherdb->where('tmpegawai_id', $idpegawai);
                  $otherdb->update('db_sicantik_backoffice.persuratan_log',$data_log);
                }

                //Simpan Log Sukses
                $dat_log = array( 'tgl_ttd'=>date("Y-m-d H:i:s"),
                                'nik' => $nik,
                                'status' => "0",
                                'info' => implode(" ", $val),
                                'dokumen' => $n_file);
                $otherdb->insert('log_esign',$dat_log);
                //End Simpan Log Sukses

                $nilai = 1;
              }
              //EOF() Save Data
            } else {
              //Simpan Log Gagal
              $dat_log = array( 'tgl_ttd'=>date("Y-m-d H:i:s"),
                                'nik' => $nik,
                                'status' => "1",
                                'info' => implode(" ", $val),
                                'dokumen' => $n_file);
              $otherdb->insert('log_esign',$dat_log);
              //End Simpan Log Gagal

              $nilai = 0;
            }
          }
        } else {
          //Simpan Log Gagal
          $dat_log = array( 'tgl_ttd'=>date("Y-m-d H:i:s"),
                            'nik' => $nik,
                            'status' => "1",
                            'info' => implode(" ", $val),
                            'dokumen' => $n_file);
          $otherdb->insert('log_esign',$dat_log);
          //End Simpan Log Gagal

          $nilai = 0;
        }
        //end esign baru

      } else {
        //ttd digital manual
        $command     = 'java -jar "'.$path_jar.'" "'.$path_pdf.'" -kst PKCS12 -ksf "'.$path_p12.'" -ksp "'.$passphrase.'" -l "Dinas PMPTSP Jawa Barat" -r "Pengesahan Surat Permohonan Pertek" -c "dpmptsp-online@jabarprov.go.id" -tsh SHA256 -ha SHA256 -d "'.$output_path.'" -os "" -ts '.$tsa_url.' -ta PASSWORD -tsu "coba" -tsp "1234" --ocsp --ocsp-server-url "'.$ocsp.'"';
        
        exec($command, $val, $er);
        if($er == 0 || $er == 3){
          // jika berhasil

          // Save Data
          $otherdb->where('id', $surat->id);
          $updt = $otherdb->update('db_sicantik_backoffice.persuratan',$data);
          if ($updt) {
            $nilai = 1;
            $log_surat = $this->data_log($surat->id, $idpegawai);

            $data_log = array('persuratan_id' => $surat->id,
                              'tmpegawai_id' => $idpegawai,
                              'waktu' => date('Y-m-d H:i:s'),
                              'ess' => $ess
                              );

            if (empty($log_surat)) {
              $save = $otherdb->insert('db_sicantik_backoffice.persuratan_log', $data_log);
            } else {
              $otherdb->where('persuratan_id', $surat->id);
              $otherdb->where('tmpegawai_id', $idpegawai);
              $otherdb->update('db_sicantik_backoffice.persuratan_log',$data_log);
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

        //Start esign baru
        $output_path = $root.'/jelita/backoffice/assets/pdf-surat/';

        $command = "java -jar ".$path_jar_new." -m sign -f ".$path_pdf." -d ".$output_path." -p '".$passphrase."' -nik ".$nik." -t invisible -l Bandung -r Dokumen_di-TTE";
        exec($command, $val, $er);
        if($er == 0 || $er == 3){
          $hasilesign = str_replace('"', "", $val[0]);
          $cop = @copy($hasilesign, $output_path."SRT_".$update.".pdf");
          if (!$cop) {
            //Simpan Log Gagal
            $dat_log = array( 'tgl_ttd'=>date("Y-m-d H:i:s"),
                              'nik' => $nik,
                              'status' => "1",
                              'info' => implode(" ", $val),
                              'dokumen' => $n_file);
            $otherdb->insert('log_esign',$dat_log);
            //End Simpan Log Gagal

            $nilai = 0;
          } else {
            if (unlink($hasilesign)) {
              // Save Data
              $otherdb->where('id', $surat->id);
              $updt = $otherdb->update('db_sicantik_backoffice.persuratan',$data);
              if ($updt) {
                $log_surat = $this->data_log($surat->id, $idpegawai);

                $data_log = array('persuratan_id' => $surat->id,
                                  'tmpegawai_id' => $idpegawai,
                                  'waktu' => date('Y-m-d H:i:s'),
                                  'ess' => $ess
                                  );

                if (empty($log_surat)) {
                  $save = $otherdb->insert('db_sicantik_backoffice.persuratan_log', $data_log);
                } else {
                  $otherdb->where('persuratan_id', $surat->id);
                  $otherdb->where('tmpegawai_id', $idpegawai);
                  $otherdb->update('db_sicantik_backoffice.persuratan_log',$data_log);
                }

                $nilai = 1;

                //Simpan Log Sukses
                $dat_log = array( 'tgl_ttd'=>date("Y-m-d H:i:s"),
                                'nik' => $nik,
                                'status' => "0",
                                'info' => implode(" ", $val),
                                'dokumen' => $n_file);
                $otherdb->insert('log_esign',$dat_log);
                //End Simpan Log Sukses
              }
              //EOF() Save Data
            } else {
              //Simpan Log Gagal
              $dat_log = array( 'tgl_ttd'=>date("Y-m-d H:i:s"),
                                'nik' => $nik,
                                'status' => "1",
                                'info' => implode(" ", $val),
                                'dokumen' => $n_file);
              $otherdb->insert('log_esign',$dat_log);
              //End Simpan Log Gagal

              $nilai = 0;
            }
          }
        } else {
          //Simpan Log Gagal
          $dat_log = array( 'tgl_ttd'=>date("Y-m-d H:i:s"),
                            'nik' => $nik,
                            'status' => "1",
                            'info' => implode(" ", $val),
                            'dokumen' => $n_file);
          $otherdb->insert('log_esign',$dat_log);
          //End Simpan Log Gagal
            
          $nilai = 0;
        }
        //End esign baru

      } else {
        // Save Data
        $otherdb->where('id', $surat->id);
        $updt = $otherdb->update('db_sicantik_backoffice.persuratan',$data);
        if ($updt) {
          $nilai = 1;
          $log_surat = $this->data_log($surat->id, $idpegawai);

          $data_log = array('persuratan_id' => $surat->id,
                            'tmpegawai_id' => $idpegawai,
                            'waktu' => date('Y-m-d H:i:s'),
                            'ess' => $ess
                            );

          if (empty($log_surat)) {
            $save = $otherdb->insert('db_sicantik_backoffice.persuratan_log', $data_log);
          } else {
            $otherdb->where('persuratan_id', $surat->id);
            $otherdb->where('tmpegawai_id', $idpegawai);
            $otherdb->update('db_sicantik_backoffice.persuratan_log',$data_log);
          }
        } else {
          $nilai = 0;
        }
        //EOF() Save Data
      }
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
    $updt = $otherdb->update('db_sicantik_backoffice.persuratan',$data);
    if ($updt) {
      return true;
    } else {
      return false;
    }
  }

  public function cek_ttd($n_file) {
    $root           = $_SERVER['DOCUMENT_ROOT'];
    $path_jar_new   = $_SERVER['DOCUMENT_ROOT'].'/android/assets/esign/signer/esign_client.jar';
    $path_pdf       = $root.'/jelita/backoffice/assets/pdf-surat/'.$n_file;

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