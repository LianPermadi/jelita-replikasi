<?php
/*
 * Created By : Nirwan R / 23-07-2020
 */

class Jdih extends WRC_AdminCont {
    public function __construct() {
      parent::__construct();
      $this->load->model("m_jdih");
		  $base_url = base_url();
      $enabled = FALSE;
  		$this->All = FALSE;
      $this->adminpajak = FALSE;
      $list_auths = $this->session_info['app_list_auth'];
//var_dump($list_auths->id_role);die;
      foreach ($list_auths as $list_auth) {
  			if ($list_auth->id_role === '39') {
          $enabled = TRUE;
        }
  			if ($list_auth->id_role === '18') {
          $this->All = TRUE;
        }
      
        //echo $list_auth->id_role."<br> ";
      }

      

      if (!$enabled) {
          redirect('dashboard');
      }
    }

    public function index() { 
      $now = $this->lib_date->get_date_now();
      $tgla = (!empty($this->input->post('tgla')) ? $this->input->post('tgla') : $this->lib_date->set_date($now, -7));;
      $tglb = (!empty($this->input->post('tglb')) ? $this->input->post('tglb') : $this->lib_date->set_date($now, 0));

      $iduser = $this->session->userdata('id_auth');
      if ($this->All) {
        $admin = 1;
      } else {
        $admin = 0;
      }//var_dump($iduser);die;

      $jdih = $this->m_jdih->get_data($tgla, $tglb, $iduser, $admin);
// var_dump($jdih);die;
      $data['tgla'] = $tgla;
      $data['tglb'] = $tglb;
      $data['jdih'] = $jdih;
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
            });";

      $this->template->set_metadata_javascript($js);
      $this->session_info['page_name'] = "JARINGAN DOKUMENTASI DAN INFORMASI HUKUM (JDIH)";
      $this->template->build('v_jdih_list', $this->session_info);
    }

    public function unduh_pdf($id){
        $jdih = $this->m_jdih->getdetail_jdih2($id);
    //var_dump($pajak);die();
  //  $nip = $jdih->nip;
    // $file = echo $this->jdih_model->get_kategori($jdih->kategori)." Nomor ".$jdih->nomor. " Tahun ".$jdih->tahun;
    $file = "HUKUM_".$id;
    // $data = file_get_contents(base_url('assets/pdf_hukum/'.$file.'.pdf'));
    $data = file_get_contents('https://dpmptsp.jabarprov.go.id/jelita/backoffice/assets/jdih/hukum/'.$file.'.pdf');
    
    force_download($this->m_jdih->get_kategori($jdih->kategori)." Nomor ".$jdih->nomor. " Tahun ".$jdih->tahun.".pdf", $data);
    }

     public function unduh_abstrak($id){
        $jdih = $this->m_jdih->getdetail_jdih2($id);
    //var_dump($pajak);die();
  //  $nip = $jdih->nip;
    // $file = echo $this->jdih_model->get_kategori($jdih->kategori)." Nomor ".$jdih->nomor. " Tahun ".$jdih->tahun;
    $file = "ABSTRAK_".$id;
    // $data = file_get_contents(base_url('assets/pdf_hukum/'.$file.'.pdf'));
    $data = file_get_contents('https://dpmptsp.jabarprov.go.id/jelita/backoffice/assets/jdih/abstrak/'.$file.'.pdf');
    
    force_download($this->m_jdih->get_kategori($jdih->kategori)." Nomor ".$jdih->nomor. " Tahun ".$jdih->tahun.".pdf", $data);
    }

     public function unduh_lampiran($id){
        $jdih = $this->m_jdih->getdetail_jdih2($id);
    //var_dump($pajak);die();
  //  $nip = $jdih->nip;
    // $file = echo $this->jdih_model->get_kategori($jdih->kategori)." Nomor ".$jdih->nomor. " Tahun ".$jdih->tahun;
    $file = "ABSTRAK_".$id;
    // $data = file_get_contents(base_url('assets/pdf_hukum/'.$file.'.pdf'));
    $data = file_get_contents('https://dpmptsp.jabarprov.go.id/jelita/backoffice/assets/jdih/abstrak/'.$file.'.pdf');
    
    force_download($this->m_jdih->get_kategori($jdih->kategori)." Nomor ".$jdih->nomor. " Tahun ".$jdih->tahun.".pdf", $data);
    }


    public function penomoran() { 
      $now = $this->lib_date->get_date_now();
      $tgla = (!empty($this->input->post('tgla')) ? $this->input->post('tgla') : $this->lib_date->set_date($now, -7));;
      $tglb = (!empty($this->input->post('tglb')) ? $this->input->post('tglb') : $this->lib_date->set_date($now, 0));

      $surat = $this->m_persuratan->get_data_nomor($tgla, $tglb);

      $data['tgla'] = $tgla;
      $data['tglb'] = $tglb;
      $data['surat'] = $surat;
      $this->load->vars($data);

      $js = "
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
            });";

      $this->template->set_metadata_javascript($js);
      $this->session_info['page_name'] = "Penomoran Surat";
      $this->template->build('persuratan_penomoran_list', $this->session_info);
    }

    public function cetak_surat() { 
      $now = $this->lib_date->get_date_now();
      $tgla = (!empty($this->input->post('tgla')) ? $this->input->post('tgla') : $this->lib_date->set_date($now, -7));;
      $tglb = (!empty($this->input->post('tglb')) ? $this->input->post('tglb') : $this->lib_date->set_date($now, 0));

      $iduser = $this->session->userdata('id_auth');
      if ($this->All || $this->Penomoran_surat) {
        $admin = 1;
      } else {
        $admin = 0;
      }

      $surat = $this->m_persuratan->get_data_cetak($tgla, $tglb, $iduser, $admin);

      $data['tgla'] = $tgla;
      $data['tglb'] = $tglb;
      $data['surat'] = $surat;
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
            });";

      $this->template->set_metadata_javascript($js);
      $this->session_info['page_name'] = "Cetak Surat";
      $this->template->build('persuratan_cetak_list', $this->session_info);
    }

    public function surat_masuk() {
      $now = $this->lib_date->get_date_now();
      $tgla = (!empty($this->input->post('tgla')) ? $this->input->post('tgla') : $this->lib_date->set_date($now, -7));;
      $tglb = (!empty($this->input->post('tglb')) ? $this->input->post('tglb') : $this->lib_date->set_date($now, 0));

      $iduser = $this->session->userdata('id_auth');
      if ($this->All) {
        $admin = 1;
      } else {
        $admin = 0;
      }

      $surat = $this->m_persuratan->get_data_masuk($tgla, $tglb, $iduser, $admin);

      $data['tgla'] = $tgla;
      $data['tglb'] = $tglb;
      $data['surat'] = $surat;
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
            });";

      $this->template->set_metadata_javascript($js);
      $this->session_info['page_name'] = "Surat Masuk";
      $this->template->build('surat_masuk_list', $this->session_info);
    }

    public function add() {
      $data['jdih'] = array();
        $data['jdih_kategori'] = $this->m_jdih->get_kategori2();
       
         $data['jdih_institusi'] = $this->m_jdih->get_institusi2();
          //var_dump( $data['jdih_institusi']);die();
   /*   $data['ess4'] = $this->m_pajak->get_ess4();
      $data['ess3'] = $this->m_pajak->get_ess3();
      $data['sekdis'] = $this->m_pajak->get_sekdis();
      $data['ess2'] = $this->m_pajak->get_ess2();*/
      $data['step'] = "simpan";

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
      $this->session_info['page_name'] = "Tambah Data JDIH";
      $this->template->build('v_jdih_edit', $this->session_info);
  }


  public function ubah($id) {
  	  $data['jdih'] = $this->m_jdih->get_datajdih($id);
       $data['jdih_kategori'] = $this->m_jdih->get_kategori2();
         $data['jdih_institusi'] = $this->m_jdih->get_institusi2();
      // $data['ess4'] = $this->m_persuratan->get_ess4();
      // $data['ess3'] = $this->m_persuratan->get_ess3();
      // $data['sekdis'] = $this->m_persuratan->get_sekdis();
      // $data['ess2'] = $this->m_persuratan->get_ess2();
      $data['step'] = "update";
      //var_dump($data['jdih']);die();
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
      $this->session_info['page_name'] = "Ubah Data JDIH";
      $this->template->build('v_jdih_edit', $this->session_info);
  }

 

  public function simpan() {
      $id_user    = $this->session->userdata('id_auth');
      //$id = $this->input->post('id ');
      $tentang = $this->input->post('tentang');
      $status = $this->input->post('status');
      $nomor = $this->input->post('nomor');
      $tahun = $this->input->post('tahun');
      $kategori = $this->input->post('kategori');
      $institusi = $this->input->post('institusi');
      $tgl_penetapan = $this->input->post('tgl_penetapan');
      $tgl_pengundangan = $this->input->post('tgl_pengundangan');
      $mencabut = $this->input->post('mencabut');
      $mengubah = $this->input->post('mengubah');
      $dirubah = $this->input->post('dirubah');
      $dicabut = $this->input->post('dicabut');

      //$path = $this->input->post('path');
     
      //var_dump($tahun);die;
      $simpan = $this->m_jdih->save_data($tentang, $status, $nomor, $tahun, $kategori, $tgl_penetapan, $tgl_pengundangan, $mencabut, $mengubah, $dirubah, $dicabut, $institusi);
      //var_dump($nip);die;
     // / $id = $simpan;
        $id = $simpan;

       if ($simpan != 0) {

       	 $folderUpload  =  "assets/jdih/lampiran/".$id;
        # periksa apakah folder tersedia
        if (!is_dir($folderUpload)) {
            # jika tidak maka folder harus dibuat terlebih dahulu
            mkdir($folderUpload, 0777, $rekursif = true);
        }
        // $files = $_FILES['listlampiran']['name'];
        // 
        $jumlahFile = count($_FILES['listlampiran']['name']);
        // var_dump($jumlahFile);die();
      $ext = 'pdf';
        for ($i = 0; $i < $jumlahFile; $i++) {
            $namaFile = $_FILES['listlampiran']['name'][$i];
            $lokasiTmp = $_FILES['listlampiran']['tmp_name'][$i];
            // var_dump($lokasiTmp);die();
               # kita tambahkan uniqid() agar nama gambar bersifat unik
            $namaBaru = 'LAMPIRAN_'.$id.'_'.$i.'.'.$ext;
            $lokasiBaru = "{$folderUpload}/{$namaBaru}";
            $prosesUpload = move_uploaded_file($lokasiTmp, $lokasiBaru);

             # jika proses berhasil
            // if ($prosesUpload) {
            //     echo "Upload file <a href='{$lokasiBaru}' target='_blank'>{$namaBaru}</a> berhasil. <br>";
            // } else {
            //     echo "<span style='color: red'>Upload file {$namaFile} gagal</span> <br>";
            // }
        }
        

         $file = $_FILES["file_srt"]["name"];
        $file_name = basename($_FILES["file_srt"]["name"]);
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        
        $target_dir = "assets/jdih/hukum/";
        $target_file = $target_dir . $file_name;

        $fileBaru = $target_dir.'HUKUM_'.$id.'.'.$ext;

        $upload = move_uploaded_file($_FILES["file_srt"]["tmp_name"], $target_file);
       
        $file2 = $_FILES["file_abstrak"]["name"];
        $file_name2 = basename($_FILES["file_abstrak"]["name"]);
        $ext2= pathinfo($file2, PATHINFO_EXTENSION);
        
        $target_dir2 = "assets/jdih/abstrak/";
        $target_file2 = $target_dir2 . $file_name2;

        $fileBaru2 = $target_dir2.'ABSTRAK_'.$id.'.'.$ext2;

        $upload2 = move_uploaded_file($_FILES["file_abstrak"]["tmp_name"], $target_file2);
        $rnm2 = rename($target_file2, $fileBaru2);

//var_dump($upload);die;
        //redirect('jdih');
        if($upload) {
          $rnm = rename($target_file, $fileBaru);
           $this->session->set_flashdata('sukses', "Berhasil Menyimpan Data & Membuat Dokumen Surat.");
            
            redirect('jdih');
          
        }
          else {
          $this->session->set_flashdata('gagal', "Berhasil Menyimpan Data Namun tidak merubah dokumen.");
          redirect('jdih');
        }
      }
   
    
/*
      $simpan = $this->m_pajak->save_data($nip,$npwp, $gaji_pokok );
      if ($simpan != 0) {
        $id = $simpan;

        $file = $_FILES["file_srt"]["name"];
        $file_name = basename($_FILES["file_srt"]["name"]);
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        
        $target_dir = "assets/pajak/";
        $target_file = $target_dir . $file_name;

        $fileBaru = $target_dir.'SRT_'.$id.'.'.$ext;

        $upload = move_uploaded_file($_FILES["file_srt"]["tmp_name"], $target_file);

        if($upload) {
          $rnm = rename($target_file, $fileBaru);

          $this->m_persuratan->update_path($id, $fileBaru);

          $dok = $this->olah_word($id);

          if ($dok) {
            $convert = $this->konversi_pdf($id);

            if ($convert) {
              $this->session->set_flashdata('sukses', "Berhasil Menyimpan Data & Membuat Dokumen Surat.");
              redirect('/pajak');
            } else {
              $this->session->set_flashdata('gagal', "Gagal Membuat Dokumen Surat. (PDF)");
              redirect('/pajak');
            }
            
            $this->session->set_flashdata('sukses', "Berhasil Menyimpan Data & Membuat Dokumen Surat.");
            redirect('/pajak');
          } else {
            $this->session->set_flashdata('gagal', "Gagal Membuat Dokumen Surat. (Docx)");
            redirect('/pajak');
          }
        } else {
          $this->session->set_flashdata('gagal', "Gagal Menggunggah File Dokumen.");
          redirect('/pajak');
        }
      } else {
        $this->session->set_flashdata('gagal', "Gagal Meyimpan Data Surat.");
        redirect('/pajak');
      }*/
  }

  public function olah_word2($id) {
   
     require_once 'assets/phpword/src/PhpWord/Autoloader.php';
      \PhpOffice\PhpWord\Autoloader::register();
  
    $datapajak = $this->m_pajak->get_datapajak($id);
	//var_dump($datapajak);die;
    if ($datapajak) {
      $nip = $datapajak->nip;
      $npwp = $datapajak->npwp;
      $alamat = $datapajak->alamat;
      $tunjanganistri = $datapajak->tunjanganistri;
      $pangkat = $datapajak->pangkat;
      $nama = $datapajak->nama;
      $gaji_pokok = $datapajak->gaji_pokok;
      
      $gol =  $datapajak->gol;
      $alamat =  $datapajak->alamat;
      $jeniskelamin =  $datapajak->jeniskelamin;
      if ($jeniskelamin=="0") {
        $jkp="";
        $jkl="X";
      }else{
        $jkp="X";
        $jkl="";
      }
      $nik =  $datapajak->nik;
      $ptkp_k =  $datapajak->ptkp_k;
      $ptkp_tk =  $datapajak->ptkp_tk;
      $ptkp_hb =  $datapajak->ptkp_hb;
      $jabatan =  $datapajak->jabatan;
      $gaji_pokok =  $datapajak->gaji_pokok;
      $nomorpajak =  $datapajak->nomorpajak;
      $tunjanganistri =  $datapajak->tunjanganistri;
      $tunjangananak =  $datapajak->tunjangananak;
      $jumlah1_3 =  $datapajak->jumlah1_3;
      $tpp =  $datapajak->tpp;
      $tunjanganstruktural =  $datapajak->tunjanganstruktural;
      $tunjanganberas =  $datapajak->tunjanganberas;
      $tunjangankhusus =  $datapajak->tunjangankhusus;
      $tunjanganlain =  $datapajak->tunjanganlain;
      $penghasilantetaplain =  $datapajak->penghasilantetaplain;
      $jlhbruto4_10 =  $datapajak->jlhbruto4_10;
      $biayajabatan =  $datapajak->biayajabatan;
      $iuranpensiun =  $datapajak->iuranpensiun;
      $jlhpengurangan12_14 =  $datapajak->jlhpengurangan12_14;
      $jlhpenghasilan11_14 =  $datapajak->jlhpenghasilan11_14;
      $jlhpenghasilansblm =  $datapajak->jlhpenghasilansblm;
      $jlhpenghasilanpph21 =  $datapajak->jlhpenghasilanpph21;
      $jlhptkp =  $datapajak->jlhptkp;
      $pkpsetahun =  $datapajak->pkpsetahun;
      $pph21pajaksetahun =  $datapajak->pph21pajaksetahun;
      $pph21potongsblm =  $datapajak->pph21potongsblm;
      $pph21terutang =  $datapajak->pph21terutang;
      $pph21potonggaji =  $datapajak->pph21potonggaji;
      $pph21potonglain =  $datapajak->pph21potonglain;
      $pph21potonglunas =  $datapajak->pph21potonglunas;
      $mp1 =  $datapajak->mp1;
      $mp2 =  $datapajak->mp2;
      $tahun =  $datapajak->tahun;
      $statuspegawai =  $datapajak->statuspegawai;
      if ($statuspegawai=="0") {
        $s1="";$s2="";$s3="";$s4="";
      }else if ($statuspegawai=="1") {
        $s1="X";$s2="";$s3="";$s4="";
      }else if ($statuspegawai=="2") {
        $s1="";$s2="X";$s3="";$s4="";
      }else if ($statuspegawai=="3") {
        $s1="";$s2="";$s3="X";$s4="";
      }else if ($statuspegawai=="4") {
        $s1="";$s2="";$s3="";$s4="X";
      }

    } else {
      return false;
    }

     $datapajakbendahara = $this->m_pajak->get_datapajakbendahara();
  //var_dump($datapajak);die;
    if ($datapajakbendahara) {
        $nama_ben =  $datapajakbendahara->nama_ben;
        $nip_ben =  $datapajakbendahara->nip_ben;
        $npwp_ben =  $datapajakbendahara->npwp_ben;
        $npwp_dinas =  $datapajakbendahara->npwp_dinas;
        $instansi_ben =  $datapajakbendahara->instansi_ben;
        $bendaharainstansi =  $datapajakbendahara->bendaharainstansi;
    }
    else{
      return false;
    }

   // $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('assets/docx-surat/SRT_'.$id.'.docx');
 	$templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('assets/pajak/PPH_21A2i.docx');

    //Create Variabel => transfer variabel pencetakan All
    // hindari input data menggunakan karakter & < > || sudah fixed by Nirwan
    $templateProcessor->setValue("nip",htmlspecialchars($nip));
    $templateProcessor->setValue("npwp",htmlspecialchars(substr($npwp,0,12)));
    $templateProcessor->setValue("np1",htmlspecialchars(substr($npwp,13,3)));
    $templateProcessor->setValue("np2",htmlspecialchars(substr($npwp,17,3)));
    $templateProcessor->setValue("nama",htmlspecialchars($nama));
    $templateProcessor->setValue("pangkat",htmlspecialchars($pangkat));
    $templateProcessor->setValue("tunjanganistri",number_format($tunjanganistri,0,',','.'));
    $templateProcessor->setValue("gajipokok",number_format($gaji_pokok,0,',','.'));
    $templateProcessor->setValue("gol",htmlspecialchars($gol));
    $templateProcessor->setValue("no1",htmlspecialchars(substr($nomorpajak,0,2)));
    $templateProcessor->setValue("no2",htmlspecialchars(substr($nomorpajak,2,2)));
    $templateProcessor->setValue("no3",htmlspecialchars(substr($nomorpajak,4)));
    $templateProcessor->setValue("alamat",htmlspecialchars(substr($alamat,0,50)));
    $templateProcessor->setValue("alamat2",htmlspecialchars(substr($alamat,50)));
    $templateProcessor->setValue("jkp",htmlspecialchars($jkp));
    $templateProcessor->setValue("jkl",htmlspecialchars($jkl));
    $templateProcessor->setValue("nik",htmlspecialchars($nik));
    $templateProcessor->setValue("p_k",htmlspecialchars($ptkp_k));
    $templateProcessor->setValue("p_tk",htmlspecialchars($ptkp_tk));
    $templateProcessor->setValue("p_hb",htmlspecialchars($ptkp_hb));
    $templateProcessor->setValue("jabatan",htmlspecialchars($jabatan));
    $templateProcessor->setValue("gaji_pokok",number_format($gaji_pokok,0,',','.'));
    $templateProcessor->setValue("tunjanganistri",number_format($tunjanganistri,0,',','.'));
    $templateProcessor->setValue("tunjangananak",number_format($tunjangananak,0,',','.'));
    $templateProcessor->setValue("jumlah1_3",number_format($jumlah1_3,0,',','.'));
    $templateProcessor->setValue("tpp",number_format($tpp,0,',','.'));
    $templateProcessor->setValue("tunjanganstruktural",number_format($tunjanganstruktural,0,',','.'));
    $templateProcessor->setValue("tunjanganberas",number_format($tunjanganberas,0,',','.'));
    $templateProcessor->setValue("tunjangankhusus",number_format($tunjangankhusus,0,',','.'));
    $templateProcessor->setValue("tunjanganlain",number_format($tunjanganlain,0,',','.'));
    $templateProcessor->setValue("penghasilantetaplain",number_format($penghasilantetaplain,0,',','.'));
    $templateProcessor->setValue("jlhbruto4_10",number_format($jlhbruto4_10,0,',','.'));
    $templateProcessor->setValue("biayajabatan",number_format($biayajabatan,0,',','.'));
    $templateProcessor->setValue("iuranpensiun",number_format($iuranpensiun,0,',','.'));
    $templateProcessor->setValue("jlhpengurangan12_14",number_format($jlhpengurangan12_14,0,',','.'));
    $templateProcessor->setValue("jlhpenghasilan11_14",number_format($jlhpenghasilan11_14,0,',','.'));
    $templateProcessor->setValue("jlhpenghasilansblm",number_format($jlhpenghasilansblm,0,',','.'));
    $templateProcessor->setValue("jlhpenghasilanpph21",number_format($jlhpenghasilanpph21,0,',','.'));
    $templateProcessor->setValue("jlhptkp",number_format($jlhptkp,0,',','.'));
    $templateProcessor->setValue("pkpsetahun",number_format($pkpsetahun,0,',','.'));
    $templateProcessor->setValue("pph21pajaksetahun",number_format($pph21pajaksetahun,0,',','.'));
    $templateProcessor->setValue("pph21potongsblm",number_format($pph21potongsblm,0,',','.'));
    $templateProcessor->setValue("pph21terutang",number_format($pph21terutang,0,',','.'));
    $templateProcessor->setValue("pph21potonglunas",number_format($pph21potonglunas,0,',','.'));
    $templateProcessor->setValue("pph21potonggaji",number_format($pph21potonggaji,0,',','.'));
    $templateProcessor->setValue("pph21potonglain",number_format($pph21potonglain,0,',','.'));
    $templateProcessor->setValue("s1",htmlspecialchars($s1));
    $templateProcessor->setValue("s2",htmlspecialchars($s2));
    $templateProcessor->setValue("s3",htmlspecialchars($s3));
    $templateProcessor->setValue("s4",htmlspecialchars($s4));
    //$p1 = "01"; $p2 = "12";
    $templateProcessor->setValue("p1",htmlspecialchars($mp1));
    $templateProcessor->setValue("p2",htmlspecialchars($mp2));
    $templateProcessor->setValue("tahun",htmlspecialchars($tahun));

    $templateProcessor->setValue("nama_ben",htmlspecialchars($nama_ben));
    $templateProcessor->setValue("nip_ben",htmlspecialchars($nip_ben));
   // $templateProcessor->setValue("npwp_ben",htmlspecialchars($npwp_ben));
    $templateProcessor->setValue("npwp_ben",htmlspecialchars(substr($npwp_ben,0,12)));
    $templateProcessor->setValue("b1",htmlspecialchars(substr($npwp_ben,13,3)));
    $templateProcessor->setValue("b2",htmlspecialchars(substr($npwp_ben,17,3)));
    $templateProcessor->setValue("npwp_dinas",htmlspecialchars(substr($npwp_dinas,0,12)));
    $templateProcessor->setValue("n1",htmlspecialchars(substr($npwp_dinas,13,3)));
    $templateProcessor->setValue("n2",htmlspecialchars(substr($npwp_dinas,17,3)));
    $templateProcessor->setValue("instansi_ben",htmlspecialchars($instansi_ben));
    $templateProcessor->setValue("bendaharainstansi",htmlspecialchars($bendaharainstansi));


  //   //Ambil dan Tampilkan QrCode
  //   $image_path = 'uploads/data_qrcode_naskah/'.$fileName;
  //   $templateProcessor->setImg('qrcode', array('src' => $image_path,'size' => array( 80, 80 )));// QrCode
    
  //   //Ambil dan Tampilkan TTD Penandatangan        
  //   $image_path = 'uploads/logo/TtdEKadis.png';
  //   $file_ttd = str_replace(" ", "", $ttd_nip);

  //   if (file_exists('uploads/logo/SRT_'.$ttd_idfile.'.png')) {
  //     $image_path = 'uploads/logo/SRT_'.$ttd_idfile.'.png';
  //   }

  //   $templateProcessor->setImg('ttd', array('src' => $image_path,'size' => array( 270, 80 ))); //default = 100, 47 | Pak Daud Plt = 140, 87    // ttd kadis

  //   //Ambil dan Tampilkan Kop Surat
  //   $image_path = 'uploads/logo/kop.png';
  //   $templateProcessor->setImg('kopsurat', array('src' => $image_path,'size' => array( 810, 150 ))); // ttd Kop Surat
    
  //   //Ambil dan Tampilkan Cap Dinas
  //   $image_path = 'uploads/logo/CapDinas.png';
  //   $templateProcessor->setImg('CapDinas', array('src' => $image_path,'size' => array( 150, 150 ))); // ttd Cap Dinas

  //   //Create File docx
  // //  $file_target = 'assets/docx-surat-processed/SRT_'.$id.'.docx';
  // //  $simpan = $templateProcessor->saveAs($file_target);

      $file_target = 'assets/pajak/docx-processed/PAJAK_'.$id.'.docx';
      $simpan = $templateProcessor->saveAs($file_target);
    //EOF() Create File docx
    
    return true;
  }


  public function olah_word($id) {
    require_once 'assets/phpword/src/PhpWord/Autoloader.php';
    \PhpOffice\PhpWord\Autoloader::register();

    $datasurat = $this->m_persuratan->get_datasurat($id);

    if ($datasurat) {
      $id_ess4 = $datasurat->ess4;
      $id_ess3 = $datasurat->ess3;
      $id_ess2 = $datasurat->ess2;
      $id_sekdis = $datasurat->sekdis;
      $tgl_surat = $datasurat->tgl_surat;
      $nomor_surat = $datasurat->nomor_surat;
      $sifat_surat = $datasurat->sifat_surat;
      $lampiran = $datasurat->lampiran;
      $hal = $datasurat->hal;
      $kepada = $datasurat->kepada;
    } else {
      return false;
    }

    $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('assets/docx-surat/SRT_'.$id.'.docx');

    $arrblnRomawi = array("I","II","III","IV","V","VI",'VII','VIII','IX','X','XI','XII');
    $blnRomawi = $arrblnRomawi[date("m")-1];
    
    // Ttd SK
    $idttd = $id_ess2;

    if ($id_ess2 == "0") {
      if ($id_sekdis != "0") {
        $idttd = $id_sekdis;
      } else {
        if ($id_ess3 == "0") {
          $idttd = $id_ess4;
        } else {
          $idttd = $id_ess3;
        }
      }
    }

    $pegawai = new tmpegawai();
    $pegawai = $pegawai->where('id', $idttd)->get();
    $jbt     = $pegawai->n_jabatan;
    $nmjbt  = explode(" ", $jbt); 

    //update jabatan kadis kalau ada Plh
    if (strtolower($nmjbt[0]) == 'plh.' || strtolower($nmjbt[0]) == 'plt.') {
      $nmjbt = array_map('strtoupper', $nmjbt);

      if (strtolower($nmjbt[0]) == 'plh.') {
        $jab = 'Plh.';
      } else {
        $jab = 'Plt.';
      }

      $arr = array($jab, $nmjbt[1], $nmjbt[2], $nmjbt[3], $nmjbt[4], $nmjbt[5], $nmjbt[6], $nmjbt[7], $nmjbt[8], $nmjbt[9], $nmjbt[10], $nmjbt[11], $nmjbt[12]);
      $jbt = implode(" ", $arr);
    } else {
      $jbt = strtoupper($jbt);
    }
    //end update jabatan

    $ttd_kepala  = $pegawai->n_pegawai;
    $ttd_pangkat = $pegawai->pangkat_gol;
    $ttd_nip     = $pegawai->nip;
    $ttd_idfile  = $pegawai->id;
    // EOF() Ttd SK

    //Create QRCode
    include('./assets/qrcode/qrlib.php');
    $tempDir = 'uploads/data_qrcode_naskah/';
    $link = 'https://dpmptsp.jabarprov.go.id/jelita/main/cekiz/unduh_surat/';
    $codeContents = $id.'/'.base64_encode($kepada);
    $codeContents = $link.$codeContents;//.'_idkeyST.'.$key;
    $fileName = 'iz_'.md5($codeContents).'.png';  // Create ID Naskah Key
    $pngAbsoluteFilePath = $tempDir.$fileName;
    $urlRelativeFilePath = base_url().$tempDir.$fileName; //EXAMPLE_TMP_URLRELPATH.$fileName;
    if(!file_exists($tempDir))    { mkdir($tempDir); }    #kalau folder belum ada, maka buat.
      
    if(!file_exists($pngAbsoluteFilePath)) {  # jika file qrcode id_izin tidak ada  
      $quality = 'H'; //ada 4 pilihan, L (Low), M(Medium), Q(Good), H(High)
      $ukuran = 5;    //batasan 1 paling kecil, 10 paling besar
      $padding = 0;
      QRCode::png($codeContents,$tempDir.$fileName,$quality,$ukuran,$padding);
    }
    //EOF() Create QRCode

    //Create Variabel => transfer variabel pencetakan All
    // hindari input data menggunakan karakter & < > || sudah fixed by Nirwan
    $templateProcessor->setValue("provinsi",'PROVINSI JAWA BARAT');
    
    $templateProcessor->setValue("jabatan",htmlspecialchars($jbt));
    $templateProcessor->setValue("kepala",$ttd_kepala);
    $templateProcessor->setValue("pangkat",$ttd_pangkat);
    $templateProcessor->setValue("nip",$ttd_nip);

    $templateProcessor->setValue("no_surat",$nomor_surat);
    $templateProcessor->setValue("tgl_surat",$this->lib_date->mysql_to_human($tgl_surat));
    $templateProcessor->setValue("sifat_surat",htmlspecialchars($sifat_surat));
    $templateProcessor->setValue("lampiran",htmlspecialchars($lampiran));
    $templateProcessor->setValue("hal",htmlspecialchars($hal));
    $templateProcessor->setValue("kepada",htmlspecialchars($kepada));

    $templateProcessor->setValue("bulanromawi",$blnRomawi);
    $templateProcessor->setValue("tahunini",date("Y"));
    $templateProcessor->setValue("tgl_sekarang",$this->lib_date->mysql_to_human(date("Y-m-d")));
      
    //Ambil dan Tampilkan QrCode
    $image_path = 'uploads/data_qrcode_naskah/'.$fileName;
    $templateProcessor->setImg('qrcode', array('src' => $image_path,'size' => array( 80, 80 )));// QrCode
    
    //Ambil dan Tampilkan TTD Penandatangan        
    $image_path = 'uploads/logo/TtdEKadis.png';
    $file_ttd = str_replace(" ", "", $ttd_nip);

    if (file_exists('uploads/logo/SRT_'.$ttd_idfile.'.png')) {
      $image_path = 'uploads/logo/SRT_'.$ttd_idfile.'.png';
    }

    $templateProcessor->setImg('ttd', array('src' => $image_path,'size' => array( 270, 80 ))); //default = 100, 47 | Pak Daud Plt = 140, 87    // ttd kadis

    //Ambil dan Tampilkan Kop Surat
    $image_path = 'uploads/logo/kop.png';
    $templateProcessor->setImg('kopsurat', array('src' => $image_path,'size' => array( 810, 150 ))); // ttd Kop Surat
    
    //Ambil dan Tampilkan Cap Dinas
    $image_path = 'uploads/logo/CapDinas.png';
    $templateProcessor->setImg('CapDinas', array('src' => $image_path,'size' => array( 150, 150 ))); // ttd Cap Dinas

    //Create File docx
    $file_target = 'assets/docx-surat-processed/SRT_'.$id.'.docx';
    $simpan = $templateProcessor->saveAs($file_target);
    //EOF() Create File docx
    
    return true;
  }

  public function konversi_pdf($id) {
    $redirect = str_replace(' ', '','PAJAK_'.$id);
    $namafile = preg_replace('/\s/i', '%20', $redirect); //isi 'namafile' dengan value nama file
    $opts = array('http' => array('header' => "User-Agent:MyAgent/1.0\r\n"));
    $context = stream_context_create($opts);
    $data = file_get_contents('http://103.122.5.250/siapi/api/pajak?id='.$namafile.'&token=9wdxc7txiH', FALSE, $context);
    
    $json = json_decode($data);
    // var_dump($data);die;
    if($json->status && $json->status == 'success') {
      $dtpdf = 'http://103.122.5.250/siapi/web/assets/pdf/' .preg_replace('/\s/i', '%20', $namafile). '.pdf';
      $newfile = $_SERVER['DOCUMENT_ROOT']. '/jelita/backoffice/assets/pajak/pdfpajak/'.$namafile.'.pdf';
        
      if (copy($dtpdf, $newfile)) {
        //file_get_contents('http://103.111.57.226/nrspdf/web/index.php?r=site%2Fdelsurat&id='.$namafile.'&token=m1WOvGqS7G', FALSE, $context);

        //Create pdf watermark
        // $this->load->library('cfpdf');
        // $this->load->library('cfpdi');
        // $pdf = new FPDI();
        // $filename  = $_SERVER['DOCUMENT_ROOT'] .'/jelita/backoffice/assets/pdf-surat/'.$namafile.'.pdf'; //Lokasi File Tanpa WaterMark
        // $filenameW = $_SERVER['DOCUMENT_ROOT'] .'/jelita/backoffice/assets/pdf-surat-wm/'.$namafile.'.pdf';    //Lokasi File WaterMark
        // try{
        //   $pageCount = $pdf->setSourceFile($filename);
        //   for($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
        //     $templateId = $pdf->importPage($pageNo);
        //     $size = $pdf->getTemplateSize($templateId);
        //     // $Wpaper = 220;
        //     // $Hpaper = 450;
        //     // $pdf->AddPage('P',array($Hpaper,$Wpaper));
        //     // $img = base_url().'uploads/logo/draft.png';
        //     // $pdf->Image($img,10,10,220,310);
        //     if($size['w'] > $size['h']) {
        //       $pdf->AddPage('L', array($size['w'], $size['h']));
        //       $img = base_url().'uploads/logo/draft.png';
        //       $pdf->Image($img,5,10,300,200);
        //     }else{
        //       $pdf->AddPage('P', array($size['w'], $size['h']));
        //       $img = base_url().'uploads/logo/draft.png';
        //       $pdf->Image($img,10,10,220,310);
        //     }
        //     $pdf->useTemplate($templateId);
        //   }
        //   $pdf->Output($filenameW,'F');
        // }
        // catch (Exception $e) {
        //   return false;
        // }
        //EOFCreate pdf watermark

        return true;
      }
    }else{
      return false;
    }
  }

  public function konversi_pdf123($id) {
    $redirect = str_replace(' ', '','SRT_'.$id);
    $namafile = preg_replace('/\s/i', '%20', $redirect); //isi 'namafile' dengan value nama file
    $opts = array('http' => array('header' => "User-Agent:MyAgent/1.0\r\n"));
    $context = stream_context_create($opts);
    $data = file_get_contents('http://103.122.5.250/siapi/api/surat?id='.$namafile.'&token=9wdxc7txiH', FALSE, $context);
    $json = json_decode($data);
    if($json->status && $json->status == 'success') {
      $dtpdf = 'http://103.122.5.250/siapi/web/assets/pdf/' .preg_replace('/\s/i', '%20', $namafile). '.pdf';
      $newfile = $_SERVER['DOCUMENT_ROOT']. '/jelita/backoffice/assets/pdf-surat/'.$namafile.'.pdf';
      if (copy($dtpdf, $newfile)) {
        //file_get_contents('http://103.111.57.226/nrspdf/web/index.php?r=site%2Fdelsurat&id='.$namafile.'&token=m1WOvGqS7G', FALSE, $context);

        //Create pdf watermark
        $this->load->library('cfpdf');
        $this->load->library('cfpdi');
        $pdf = new FPDI();
        $filename  = $_SERVER['DOCUMENT_ROOT'] .'/jelita/backoffice/assets/pdf-surat/'.$namafile.'.pdf'; //Lokasi File Tanpa WaterMark
        $filenameW = $_SERVER['DOCUMENT_ROOT'] .'/jelita/backoffice/assets/pdf-surat-wm/'.$namafile.'.pdf';    //Lokasi File WaterMark
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
      }
    }else{
      return false;
    }
  }

  public function refresh_docx($id) {
    if ($this->olah_word2($id) && $this->konversi_pdf($id)) {
      $this->session->set_flashdata('sukses', "Berhasil Refresh Berkas Docx.");
      redirect('pajak');
    } else {
      $this->session->set_flashdata('gagal', "Gagal Refresh Berkas Docx.");
      redirect('pajak');
    }
  }

  public function refresh_pdf($id) {
    if ($this->konversi_pdf2($id)) {
      $this->session->set_flashdata('sukses', "Berhasil Refresh Berkas PDF.");
      redirect('pajak/cetak_pajak');
    } else {
      $this->session->set_flashdata('gagal', "Gagal Refresh Berkas PDF.");
      redirect('pajak/cetak_pajak');
    }
  }
public function unduh_lampiran2($id, $lokasi) {
    $hukum = $this->m_jdih->get_datajdih($id);
     var_dump($lokasi);die();
    $tentang = $hukum->tentang;
    $file = $id."/".$lokasi;
    $data = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/jelita/backoffice/assets/jdih/lampiran/'.$file);
    force_download('Lampiran '.$tentang.' - E-Sign.pdf', $data);
  }

  public function update() {
      $id           = $this->input->post('id');
       
      //$id = $this->input->post('id ');
      $tentang = $this->input->post('tentang');
      $status = $this->input->post('status');
      $nomor = $this->input->post('nomor');
      $tahun = $this->input->post('tahun');
      $kategori = $this->input->post('kategori');
      $institusi = $this->input->post('institusi');
      $tgl_penetapan = $this->input->post('tgl_penetapan');
      $tgl_pengundangan = $this->input->post('tgl_pengundangan');
      $mencabut = $this->input->post('mencabut');
      $mengubah = $this->input->post('mengubah');
      $dirubah = $this->input->post('dirubah');
      $dicabut = $this->input->post('dicabut');

      //$path = $this->input->post('path');
     
      //var_dump($tahun);die;
      $simpan = $this->m_jdih->update_data($id, $tentang, $status, $nomor, $tahun, $kategori, $tgl_penetapan, $tgl_pengundangan, $mencabut, $mengubah, $dirubah, $dicabut, $institusi);
//var_dump($simpan);die;
       if ($simpan) {

        $folderUpload  =  "assets/jdih/lampiran/".$id;
        # periksa apakah folder tersedia
        if (!is_dir($folderUpload)) {
            # jika tidak maka folder harus dibuat terlebih dahulu
            mkdir($folderUpload, 0777, $rekursif = true);
        }
        // $files = $_FILES['listlampiran']['name'];
        // 
        $jumlahFile = count($_FILES['listlampiran']['name']);
        // var_dump($jumlahFile);die();
      $ext = 'pdf';
        for ($i = 0; $i < $jumlahFile; $i++) {
            $namaFile = $_FILES['listlampiran']['name'][$i];
            $lokasiTmp = $_FILES['listlampiran']['tmp_name'][$i];
            // var_dump($lokasiTmp);die();
               # kita tambahkan uniqid() agar nama gambar bersifat unik
            $namaBaru = 'LAMPIRAN_'.$id.'_'.$i.'.'.$ext;
            $lokasiBaru = "{$folderUpload}/{$namaBaru}";
            $prosesUpload = move_uploaded_file($lokasiTmp, $lokasiBaru);

             # jika proses berhasil
            // if ($prosesUpload) {
            //     echo "Upload file <a href='{$lokasiBaru}' target='_blank'>{$namaBaru}</a> berhasil. <br>";
            // } else {
            //     echo "<span style='color: red'>Upload file {$namaFile} gagal</span> <br>";
            // }
        }


         $file = $_FILES["file_srt"]["name"];
        $file_name = basename($_FILES["file_srt"]["name"]);
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        
        $target_dir = "assets/jdih/hukum/";
        $target_file = $target_dir . $file_name;

        $fileBaru = $target_dir.'HUKUM_'.$id.'.'.$ext;

        $upload = move_uploaded_file($_FILES["file_srt"]["tmp_name"], $target_file);
       
        $file2 = $_FILES["file_abstrak"]["name"];
        $file_name2 = basename($_FILES["file_abstrak"]["name"]);
        $ext2= pathinfo($file2, PATHINFO_EXTENSION);
        
        $target_dir2 = "assets/jdih/abstrak/";
        $target_file2 = $target_dir2 . $file_name2;

        $fileBaru2 = $target_dir2.'ABSTRAK_'.$id.'.'.$ext2;

        $upload2 = move_uploaded_file($_FILES["file_abstrak"]["tmp_name"], $target_file2);
        $rnm2 = rename($target_file2, $fileBaru2);

//var_dump($upload);die;
        //redirect('jdih');
        if($upload || $upload2) {
          $rnm = rename($target_file, $fileBaru);
          
           $this->session->set_flashdata('sukses', "Berhasil Menyimpan Data & Membuat Dokumen Surat.");
            
            redirect('jdih');
          
        }
          else {
          $this->session->set_flashdata('gagal', "Berhasil Menyimpan Data Namun tidak merubah dokumen");
          redirect('jdih');
        }
      }
  }

  public function uploadhukum($id){
        $file = $_FILES["file_srt"]["name"];
        $file_name = basename($_FILES["file_srt"]["name"]);
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        
        $target_dir = "assets/jdih/hukum/";
        $target_file = $target_dir . $file_name;

        $fileBaru = $target_dir.'HUKUM_'.$id.'.'.$ext;

        $upload = move_uploaded_file($_FILES["file_srt"]["tmp_name"], $target_file);
        $rnm = rename($target_file, $fileBaru);

        // $file2 = $_FILES["file_abstrak"]["name"];
        // $file_name2 = basename($_FILES["file_abstrak"]["name"]);
        // $ext2= pathinfo($file2, PATHINFO_EXTENSION);
        
        // $target_dir2 = "assets/jdih/abstrak";
        // $target_file2 = $target_dir2 . $file_name2;

        // $fileBaru2 = $target_dir2.'ABSTRAK_'.$id.'.'.$ext2;

        // $upload2 = move_uploaded_file($_FILES["file_abstrak"]["tmp_name"], $target_file2);
        // $rnm2 = rename($target_file, $fileBaru2);

//var_dump($upload);die;
        //redirect('jdih');
        if($upload) {
          
           $this->session->set_flashdata('sukses', "Berhasil Menyimpan Data & Membuat Dokumen Surat.");
            redirect('jdih');
          
        }
          else {
          $this->session->set_flashdata('gagal', "Gagal Menggunggah File Dokumen.");
          redirect('jdih');
        }
  }

  public function update_penomoran() {
      $id_user = $this->session->userdata('id_auth');

      $nomor_surat  = $this->input->post('no_surat');
      $tgl_surat    = $this->input->post('tgl_surat');
      $id           = $this->input->post('id');

      $simpan = $this->m_persuratan->update_penomoran($id, $nomor_surat, $tgl_surat);
      if ($simpan) {
        $dok = $this->olah_word($id);

            if ($dok) {
              $convert = $this->konversi_pdf($id);

              if ($convert) {
                $this->session->set_flashdata('sukses', "Berhasil Menyimpan Data & Membuat Dokumen Surat.");
                redirect('persuratan/penomoran');
              } else {
                $this->session->set_flashdata('gagal', "Gagal Membuat Dokumen Surat. (PDF)");
                redirect('persuratan/penomoran');
              }

              $this->session->set_flashdata('sukses', "Berhasil Menyimpan Data & Membuat Dokumen Surat.");
              redirect('persuratan/penomoran');
            } else {
              $this->session->set_flashdata('gagal', "Gagal Membuat Dokumen Surat. (Docx)");
              redirect('persuratan/penomoran');
            }
      } else {
        $this->session->set_flashdata('gagal', "Gagal Meyimpan Data Surat");
        redirect('persuratan/penomoran');
      }
  }

  public function unduh($id) {
    $pajak = $this->m_pajak->get_datapajak($id);
    //var_dump($pajak);die();
    $nip = $pajak->nip;
    $file = "PAJAK_".$id;
    $data = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/jelita/backoffice/assets/pajak/pdfpajak/'.$file.'.pdf');
    force_download('PAJAK '.$nip.' - E-Sign.pdf', $data);
  }

  public function unduh_preview2($id) {
    $surat = $this->m_persuratan->get_datasurat($id);
    $kepada = $surat->kepada;

    $file = "SRT_".$id;
    // if (file_exists($_SERVER['DOCUMENT_ROOT'].'/jelita/backoffice/assets/pdf-surat-wm/'.$file.'.pdf')) {
    //   $data = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/jelita/backoffice/assets/pdf-surat-wm/'.$file.'.pdf');
    //   force_download('Surat '.$kepada.' - Preview.pdf', $data);
    // } else {
      //Create pdf watermark
        $this->load->library('cfpdf');
        $this->load->library('cfpdi');
        $pdf = new FPDI();
        $filename  = $_SERVER['DOCUMENT_ROOT'] .'/jelita/backoffice/assets/pdf-surat/'.$file.'.pdf'; //Lokasi File Tanpa WaterMark
        $filenameW = $_SERVER['DOCUMENT_ROOT'] .'/jelita/backoffice/assets/pdf-surat-wm/'.$file.'.pdf';    //Lokasi File WaterMark
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
        
      $data = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/jelita/backoffice/assets/pdf-surat-wm/'.$file.'.pdf');
      force_download('Surat '.$kepada.' - Preview.pdf', $data);
    //}
    
  }

  public function unduh_preview($id) {
    $surat = $this->m_persuratan->get_datasurat($id);
    $kepada = $surat->kepada;

    $file = "SRT_".$id;
    // if (file_exists($_SERVER['DOCUMENT_ROOT'].'/jelita/backoffice/assets/pdf-surat-wm/'.$file.'.pdf')) {
    //   $data = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/jelita/backoffice/assets/pdf-surat-wm/'.$file.'.pdf');
    //   force_download('Surat '.$kepada.' - Preview.pdf', $data);
    // } else {
      //Create pdf watermark
        $this->load->library('cfpdf');
        $this->load->library('cfpdi');
        $pdf = new FPDI();
        $filename  = $_SERVER['DOCUMENT_ROOT'] .'/jelita/backoffice/assets/pdf-surat/'.$file.'.pdf'; //Lokasi File Tanpa WaterMark
        $filenameW = $_SERVER['DOCUMENT_ROOT'] .'/jelita/backoffice/assets/pdf-surat-wm/'.$file.'.pdf';    //Lokasi File WaterMark
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
        
      $data = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/jelita/backoffice/assets/pdf-surat-wm/'.$file.'.pdf');
      force_download('Surat '.$kepada.' - Preview.pdf', $data);
    //}
    
  }

  public function unduh_docx($id) {
    $surat = $this->m_persuratan->get_datasurat($id);
    $kepada = $surat->kepada;

    $file = "SRT_".$id;
    $data = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/jelita/backoffice/assets/docx-surat-processed/'.$file.'.docx');
    force_download('Surat '.$kepada.' - Non E-Sign.docx', $data);
  }

  public function hapus_pdf($id) {
    $hapus = unlink('assets/jdih/hukum/HUKUM_'.$id.'.pdf');
    if ($hapus) {
      $this->session->set_flashdata('sukses', "Berhasil Menghapus Berkas.");
      redirect('jdih/ubah/'.$id);
    } else {
      $this->session->set_flashdata('gagal', "Gagal Menghapus Berkas.");
      redirect('jdih/ubah/'.$id);
    }
  }
  public function hapus_lampiran($id, $test) {
  	$test = base64_decode($test);
  	// var_dump($id);die();
    $hapus = unlink($test);
    if ($hapus) {
      $this->session->set_flashdata('sukses', "Berhasil Menghapus Berkas.");
      redirect('jdih/ubah/'.$id);
    } else {
      $this->session->set_flashdata('gagal', "Gagal Menghapus Berkas.");
      redirect('jdih/ubah/'.$id);
    }
  }
public function hapus_abstrak($id) {
    $hapus = unlink('assets/jdih/abstrak/ABSTRAK_'.$id.'.pdf');
    if ($hapus) {
      $this->session->set_flashdata('sukses', "Berhasil Menghapus Berkas.");
      redirect('jdih/ubah/'.$id);
    } else {
      $this->session->set_flashdata('gagal', "Gagal Menghapus Berkas.");
      redirect('jdih/ubah/'.$id);
    }
  }

  public function refresh_all($id) {
    if ($this->olah_word($id) && $this->konversi_pdf($id)) {
      $this->session->set_flashdata('sukses', "Berhasil Membuat Ulang Seluruh Berkas.");
      redirect('persuratan');
    } else {
      $this->session->set_flashdata('gagal', "Gagal Membuat Ulang Seluruh Berkas.");
      redirect('persuratan');
    }
  }

  public function ajukan_delete($id) {
  	if ($this->m_persuratan->ajukan_delete($id)) {
  	//	$this->session->set_flashdata('sukses', "Berhasil Hapus Data.");
      	redirect('persuratan');
  	} else {
  	//	$this->session->set_flashdata('gagal', "Gagal Hapus Data.");
      	redirect('persuratan');
  	}
  }
  
  public function hapus($id) {
     $hapus = unlink('assets/jdih/hukum/HUKUM_'.$id.'.pdf');
     $hapus2 = unlink('assets/jdih/abstrak/ABSTRAK_'.$id.'.pdf');
  	if ($this->m_jdih->delete_jdih($id) ) { // && $this->hapus_docx($id)
  		$this->session->set_flashdata('sukses', "Berhasil Hapus Data.");
      	redirect('jdih');
  	} else {
  		$this->session->set_flashdata('gagal', "Gagal Hapus Data.");
      	redirect('jdih');
  	}
  }

  public function hapus_penomoran($id) {
  	if ($this->m_persuratan->delete_surat($id)) {
  		$this->session->set_flashdata('sukses', "Berhasil Hapus Data.");
      	redirect('persuratan/penomoran');
  	} else {
  		$this->session->set_flashdata('gagal', "Gagal Hapus Data.");
      	redirect('persuratan/penomoran');
  	}
  }
}