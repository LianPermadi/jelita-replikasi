<?php
/*
 * Created By : Nirwan R / 23-07-2020
 */

class Persuratan extends WRC_AdminCont {
    public function __construct() {
      parent::__construct();
      $this->load->model("m_persuratan");
		  $base_url = base_url();
      $enabled = FALSE;
  		$this->All = FALSE;
      $this->Penomoran_surat = FALSE;
      $list_auths = $this->session_info['app_list_auth'];

      foreach ($list_auths as $list_auth) {
  			if ($list_auth->id_role === '32') {
          $enabled = TRUE;
        }
  			if ($list_auth->id_role === '18') {
          $this->All = TRUE;
        }
        if ($list_auth->id_role === '33') {
          $this->Penomoran_surat = TRUE;
        }
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
      }

      $surat = $this->m_persuratan->get_data($tgla, $tglb, $iduser, $admin);

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
      $this->session_info['page_name'] = "Persuratan";
      $this->template->build('persuratan_list', $this->session_info);
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

    public function add() {
      $data['surat'] = array();
      $data['ess4'] = $this->m_persuratan->get_ess4();
      $data['ess3'] = $this->m_persuratan->get_ess3();
      $data['sekdis'] = $this->m_persuratan->get_sekdis();
      $data['ess2'] = $this->m_persuratan->get_ess2();
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
      $this->session_info['page_name'] = "Tambah Data Surat";
      $this->template->build('persuratan_edit', $this->session_info);
  }

  public function ubah($id) {
  	  $data['surat'] = $this->m_persuratan->get_datasurat($id);
      $data['ess4'] = $this->m_persuratan->get_ess4();
      // var_dump($data['ess4'] );die();
      $data['ess3'] = $this->m_persuratan->get_ess3();
      $data['sekdis'] = $this->m_persuratan->get_sekdis();
      $data['ess2'] = $this->m_persuratan->get_ess2();
      $data['step'] = "update";

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
      $this->session_info['page_name'] = "Ubah Data Surat";
      $this->template->build('persuratan_edit', $this->session_info);
  }

  public function ubah_penomoran($id) {
      $data['surat'] = $this->m_persuratan->get_datasurat($id);
      $data['ess4'] = $this->m_persuratan->get_ess4();
      $data['sekdis'] = $this->m_persuratan->get_sekdis();
      $data['ess3'] = $this->m_persuratan->get_ess3();
      $data['ess2'] = $this->m_persuratan->get_ess2();
      $data['step'] = "update";

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
      $this->session_info['page_name'] = "Ubah Penomoran Surat";
      $this->template->build('persuratan_penomoran_edit', $this->session_info);
  }

  public function simpan() {
      $id_user = $this->session->userdata('id_auth');

      $ess4         = $this->input->post('ess4');
      $ess3         = $this->input->post('ess3');
      $sekdis       = $this->input->post('sekdis');
      $ess2         = $this->input->post('ess2');
      $sifat_surat  = $this->input->post('sifat_surat');
      $lampiran     = $this->input->post('lampiran');
      $hal          = $this->input->post('hal');
      $kepada       = $this->input->post('kepada');
      $logo         = $this->input->post('logo');

      $simpan = $this->m_persuratan->save_data($id_user, $ess4, $ess3, $sekdis, $ess2, $sifat_surat, $lampiran, $hal, $kepada, $logo);
      if ($simpan != 0) {
        $id = $simpan;

        $file = $_FILES["file_srt"]["name"];
        $file_name = basename($_FILES["file_srt"]["name"]);
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        
        $target_dir = "assets/docx-surat/";
        $target_file = $target_dir . $file_name;

        $fileBaru = $target_dir.'SRT_'.$id.'.'.$ext;

        $upload = move_uploaded_file($_FILES["file_srt"]["tmp_name"], $target_file);
        // var_dump($upload);die();

        if($upload) {
          $rnm = rename($target_file, $fileBaru);

          $this->m_persuratan->update_path($id, $fileBaru);

          $dok = $this->olah_word($id);

          if ($dok) {
            $convert = $this->konversi_pdf($id);

            if ($convert) {
              $this->session->set_flashdata('sukses', "Berhasil Menyimpan Data & Membuat Dokumen Surat.");
              redirect('/persuratan');
            } else {
              $this->session->set_flashdata('gagal', "Gagal Membuat Dokumen Surat. (PDF)1");
              redirect('/persuratan');
            }
            
            $this->session->set_flashdata('sukses', "Berhasil Menyimpan Data & Membuat Dokumen Surat.");
            redirect('/persuratan');
          } else {
            $this->session->set_flashdata('gagal', "Gagal Membuat Dokumen Surat. (Docx)");
            redirect('/persuratan');
          }
        } else {
          $this->session->set_flashdata('gagal', "Gagal Menggunggah File Dokumen.2s");
          redirect('/persuratan');
        }
      } else {
        $this->session->set_flashdata('gagal', "Gagal Meyimpan Data Surat.");
        redirect('/persuratan');
      }
  }

  public function update() {
      $id_user = $this->session->userdata('id_auth');

      $ess4         = $this->input->post('ess4');
      $ess3         = $this->input->post('ess3');
      $sekdis       = $this->input->post('sekdis');
      $ess2         = $this->input->post('ess2');
      $sifat_surat  = $this->input->post('sifat_surat');
      $lampiran     = $this->input->post('lampiran');
      $hal          = $this->input->post('hal');
      $kepada       = $this->input->post('kepada');
      $logo         = $this->input->post('logo');
      $id 			    = $this->input->post('id');

      $stat_tolak   = $this->m_persuratan->get_data_tolak($id);

      $simpan = $this->m_persuratan->update_data($id, $id_user, $ess4, $ess3, $sekdis, $ess2, $sifat_surat, $lampiran, $hal, $kepada, $logo);
      if ($simpan) {
        if (isset($_FILES["file_srt"]["name"])) {
        	$file = $_FILES["file_srt"]["name"];
        	$file_name = basename($_FILES["file_srt"]["name"]);
	        $ext = pathinfo($file, PATHINFO_EXTENSION);
	        
	        $target_dir = "assets/docx-surat/";
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
	              redirect('/persuratan');
	            } else {
	              $this->session->set_flashdata('gagal', "Gagal Membuat Dokumen Surat. (PDF)2");
	              redirect('/persuratan');
	            }

              $this->session->set_flashdata('sukses', "Berhasil Menyimpan Data & Membuat Dokumen Surat.");
              redirect('/persuratan');
	          } else {
	            $this->session->set_flashdata('gagal', "Gagal Membuat Dokumen Surat. (Docx)");
	            redirect('/persuratan');
	          }
	        } else {
	          $this->session->set_flashdata('gagal', "Gagal Menggunggah File Dokumen.1");
	          redirect('/persuratan');
	        }
        } else {
          if (!$stat_tolak) {
            $dok = $this->olah_word($id);

            if ($dok) {
              $convert = $this->konversi_pdf($id);

              if ($convert) {
                $this->session->set_flashdata('sukses', "Berhasil Menyimpan Data & Membuat Dokumen Surat.");
                redirect('persuratan');
              } else {
                $this->session->set_flashdata('gagal', "Gagal Membuat Dokumen Surat. (PDF)3");
                redirect('persuratan');
              }
            } else {
              $this->session->set_flashdata('gagal', "Gagal Membuat Dokumen Surat. (Docx)");
              redirect('persuratan');
            }
          } else {
            $this->session->set_flashdata('sukses', "Berhasil Merubah Data.");
            redirect('persuratan');
          }
        }
      } else {
        $this->session->set_flashdata('gagal', "Gagal Meyimpan Data Surat");
        redirect('persuratan');
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
                $this->session->set_flashdata('gagal', "Gagal Membuat Dokumen Surat. (PDF)4");
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
    
    $surat = $this->m_persuratan->get_datasurat($id);

    if (!$surat) {
        show_error("Data surat tidak ditemukan.", 404);
    }

    $kepada = $surat->kepada;
    $file = "SRT_".$id.".pdf";
    $file_path = FCPATH . 'assets/esign-surat/' . $file;

    if (file_exists($file_path)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="Surat '.$kepada.' - E-Sign.pdf"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file_path));

        ob_clean();
        flush();
        readfile($file_path);
        exit;
    } else {
        show_error("File tidak ditemukan.", 404);
    }

  }

  public function unduh_preview($id) {
    $surat = $this->m_persuratan->get_datasurat($id);
    $kepada = $surat->kepada;

    $file = "SRT_".$id;
    // if (file_exists($_SERVER['DOCUMENT_ROOT'].'/sicantik/backoffice/assets/pdf-surat-wm/'.$file.'.pdf')) {
    //   $data = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/sicantik/backoffice/assets/pdf-surat-wm/'.$file.'.pdf');
    //   force_download('Surat '.$kepada.' - Preview.pdf', $data);
    // } else {
      //Create pdf watermark
      
    $php_self = $_SERVER['SCRIPT_NAME'];
    $url_self = str_replace("/index.php", "", $php_self);
    $url_domain = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$url_self;
        $this->load->library('cfpdf');
        $this->load->library('cfpdi');
        $pdf = new FPDI();
        $filename  = $_SERVER['DOCUMENT_ROOT'] .$url_self.'/assets/pdf-surat/'.$file.'.pdf'; //Lokasi File Tanpa WaterMark
        $filenameW = $_SERVER['DOCUMENT_ROOT'] .$url_self.'/assets/pdf-surat-wm/'.$file.'.pdf';    //Lokasi File WaterMark
        try{
          $pageCount = $pdf->setSourceFile($filename);
          for($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $templateId = $pdf->importPage($pageNo);
            $size = $pdf->getTemplateSize($templateId);
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
        
      $data = file_get_contents($_SERVER['DOCUMENT_ROOT'] .$url_self.'/assets/pdf-surat-wm/'.$file.'.pdf');
      force_download('Surat '.$kepada.' - Preview.pdf', $data);
    //}
    
  }

  public function unduh_docx($id) {
    
    $php_self = $_SERVER['SCRIPT_NAME'];
    $url_self = str_replace("/index.php", "", $php_self);
    $url_domain = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$url_self;
    $surat = $this->m_persuratan->get_datasurat($id);
    $kepada = $surat->kepada;

    $file = "SRT_".$id;
    $data = file_get_contents($_SERVER['DOCUMENT_ROOT'] .$url_self.'/assets/docx-surat-processed/'.$file.'.docx');
    force_download('Surat '.$kepada.' - Non E-Sign.docx', $data);
  }

  public function hapus_docx($id) {
    $hapus = unlink('assets/docx-surat/SRT_'.$id.'.docx');
    $hapus2 = unlink('assets/docx-surat-processed/SRT_'.$id.'.docx');

    if ($hapus && $hapus2) {
      $this->session->set_flashdata('sukses', "Berhasil Menghapus Berkas Docx.");
      redirect('persuratan/ubah/'.$id);
    } else {
      $this->session->set_flashdata('gagal', "Gagal Menghapus Berkas Docx.");
      redirect('persuratan/ubah/'.$id);
    }
  }

  public function olah_word($id) {
    $routees        = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
    $root           = rtrim($_SERVER['DOCUMENT_ROOT'], '/'); // buang trailing slash
    $routees        = ltrim($routees, '/');              // buang leading slash
    $routees_portal = str_replace('backoffice/index.php', '', $_SERVER['SCRIPT_NAME']); 
    $routees_portal = ltrim($routees_portal, '/');              // buang leading slash
    $master_url     = $_SERVER['REQUEST_SCHEME'] .'://'. $_SERVER['HTTP_HOST'];
    // var_dump($routees, $root,$routees_portal,$master_url);
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

    if(file_exists('assets/docx-surat/SRT_'.$id.'.docx')){
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


    // create peminjaman mobil by lian
    $idmobil = $this->m_persuratan->get_idmobil($id);
      if($idmobil != NULL){

            //Create QRCode
    include_once('./assets/qrcode/qrlib.php');

    $tempDir = 'uploads/data_qrcode_naskah/';
    $link = $master_url.'/'.$routees_portal.'/main/cekiz/unduh_surat/';
    $codeContents = $id . '/' . base64_encode($kepada);
    $codeContents = $link . $codeContents;
    $fileName = 'iz_' . md5($codeContents) . '.png'; // Create ID Naskah Key
    $pngAbsoluteFilePath = $tempDir . $fileName;
    $urlRelativeFilePath = base_url() . $tempDir . $fileName;

    // Pastikan folder ada
    if (!file_exists($tempDir)) {
        mkdir($tempDir, 0755, true);
    }

    $logopath = "$master_url/$routees/uploads/logo/logo_ttd.jpg";

    try {
        // Buat QR code jika belum ada
        if (!file_exists($pngAbsoluteFilePath)) {
            $quality = 'H'; // ada 4 pilihan, L (Low), M (Medium), Q (Good), H (High)
            $ukuran = 5;    // batasan 1 paling kecil, 10 paling besar
            $padding = 0;
            QRCode::png($codeContents, $pngAbsoluteFilePath, $quality, $ukuran, $padding);
        }

        $QR = imagecreatefrompng($pngAbsoluteFilePath);

        // Mulai menggambar logo dalam file QR Code
        $logo = @imagecreatefromstring(file_get_contents($logopath));
        if ($logo) {
            imagecolortransparent($logo, imagecolorallocatealpha($logo, 0, 0, 0, 127));
            imagealphablending($logo, false);
            imagesavealpha($logo, true);

            $QR_width = imagesx($QR);
            $QR_height = imagesy($QR);

            $logo_width = imagesx($logo);
            $logo_height = imagesy($logo);

            // Skala logo agar sesuai dalam QR Code
            $logo_qr_width = $QR_width / 2.4;
            $scale = $logo_width / $logo_qr_width;
            $logo_qr_height = $logo_height / $scale;

            imagecopyresampled(
                $QR, $logo,
                $QR_width / 3.2, $QR_height / 3.2, 0, 0,
                $logo_qr_width, $logo_qr_height, $logo_width, $logo_height
            );
        }

        // Simpan kode QR lagi, dengan logo di atasnya
        imagepng($QR, $pngAbsoluteFilePath);

    } catch (Exception $e) {
        // Tangkap error dan tampilkan pesan jika perlu
        error_log("Error: " . $e->getMessage());
        // Lanjutkan tanpa menghentikan eksekusi
    }

    // Lanjutkan ke proses berikutnya
    //EOF() Create QRCode

        $idpeminjam = $this->m_persuratan->get_idpeminjam_mobil($idmobil);
        $nama_peminjam = $this->m_persuratan->get_peminjam_mobil($idpeminjam);
        $templateProcessor->setValue("nama",$nama_peminjam);                                          // Nama Peminjam Mobil
        $jabatan_peminjam = $this->m_persuratan->get_jabatan_mobil($idpeminjam);
        $templateProcessor->setValue("jabatan_peminjam",$jabatan_peminjam);                           // Jabatan Peminjam

        $nip_kedua = $this->m_persuratan->get_nip_mobil($idpeminjam);
        $templateProcessor->setValue("nip_kedua",$nip_kedua);                           // nip Peminjam
        $unit = $this->m_persuratan->get_nama_unit($idpeminjam);
        $trunit = $this->m_persuratan->get_trunitkerja($unit); 
        $templateProcessor->setValue("unit",$trunit);                           // unit Peminjam
        $mobil = $this->m_persuratan->get_mobil_id($idmobil);                 // unit Peminjam
        $driver = $this->m_persuratan->get_driver_id($idmobil);
        $nopol = $this->m_persuratan->get_platnomor_id($mobil);
        $templateProcessor->setValue("nopol",$nopol);                           // nopol Peminjam
        $templateProcessor->setValue("driver",$driver);                           // nopol Peminjam
        $templateProcessor->setValue("qr_",$nopol);                           // nopol Peminjam

        setlocale(LC_TIME, 'id_ID');
        $startDate = date('Y-m-d', strtotime($this->m_persuratan->tanggal_pinjam($idmobil)));
        $endDate = date('Y-m-d', strtotime($this->m_persuratan->tanggal_kembali($idmobil)));
        $startTime = strtotime($startDate);
        $endTime = strtotime($endDate);

        $daysDiff = ($endTime - $startTime) / (60 * 60 * 24);
        $start = date('d F Y', strtotime($this->m_persuratan->tanggal_pinjam($idmobil)));
        $end = date('d F Y', strtotime($this->m_persuratan->tanggal_kembali($idmobil)));
        $haristart = strftime('%A', strtotime($this->m_persuratan->tanggal_pinjam($idmobil)));
        $daysDiff = $daysDiff + 1;
        $templateProcessor->setValue("durasi",$daysDiff);                           // durasi Peminjam
        $templateProcessor->setValue("tgl_awal",$start);                           // tgl_awal Peminjam
        $templateProcessor->setValue("tgl_akhir",$end);                           // tgl_akhir Peminjam
        $templateProcessor->setValue("hari",$haristart);                           // hari Peminjam
        $tujuan = $this->m_persuratan->tujuan($idmobil);
        $templateProcessor->setValue("tujuan",$tujuan);                           // tujuan Peminjam
        $templateProcessor->setValue("tgl_sekarang",$this->lib_date->mysql_to_human(date("Y-m-d")));
        $id_satu       = $this->m_persuratan->struktural(4);
        $templateProcessor->setValue("nama_satu",$this->m_persuratan->get_peminjam_mobil($id_satu));                           // hari Peminjam
        $nama_kesatu = $this->m_persuratan->get_peminjam_mobil($id_satu);
        $id_dua = $this->m_persuratan->id_pihak_dua($id);

        // var_dump($id_satu);die();
        // $id_satu = $this->m_persuratan->id_pihak_satu($id);
        // $id_satu = '453';
        // $nip_satu = $this->m_persuratan->nip_pihak_satu($id_satu);
        $nip_satu = $this->m_persuratan->get_nip_mobil($id_satu);
        $ttd_id_peminjam = $root.'/'.$routees.'/uploads/logo/SRT_'.$id_satu.'.png';
        $ttd_nip_peminjam = $root.'/'.$routees.'/uploads/logo/'.$nip_satu.'.png';
        if(file_exists($ttd_id_peminjam)){
            $templateProcessor->setImg('ttd_satu', array('src' => $ttd_id_peminjam, 'size' => array(270, 93)));
        } elseif(file_exists($ttd_nip_peminjam)){
            $templateProcessor->setImg('ttd_satu', array('src' => $ttd_nip_peminjam, 'size' => array(270, 93), 'text' => '('.$nama_kesatu.')<br> NIP. '.$nip_satu));
        }
        $ttd_id_peminjam_kedua = $root.'/'.$routees.'/uploads/logo/SRT_'.$id_dua.'.png';
        $ttd_nip_peminjam_kedua = $root.'/'.$routees.'/uploads/logo/'.$nip_kedua.'.png';
        // Periksa apakah file $ttd_id_peminjam_kedua ada
        if (file_exists($ttd_id_peminjam_kedua)) {
            // File $ttd_id_peminjam_kedua ada, gunakan itu
            $path_ttd_kedua = $ttd_id_peminjam_kedua;
            $templateProcessor->setImg('ttd_dua', array('src' => $path_ttd_kedua,'size' => array( 270, 93 )));
        } else {
            // File $ttd_id_peminjam_kedua tidak ada, gunakan $ttd_nip_peminjam_kedua
            $path_ttd_kedua = $ttd_nip_peminjam_kedua;
            $templateProcessor->setImg('ttd_dua', array('src' => $path_ttd_kedua,'size' => array( 270, 93 ).'<br>('.$nama_peminjam.')<br>'.'NIP. '.$nip_kedua));
        }
        $id_tiga        = $this->m_persuratan->struktural(5);
        // $id_tiga = '911'; // 911 id pak cucun
        $nip_tiga = $this->m_persuratan->get_nip_mobil($id_tiga); // 198109082008011002 id pak cucun
        $ttd_id_ketiga = $root.'/'.$routees.'/uploads/logo/SRT_'.$id_tiga.'.png';
        $ttd_nip_ketiga = $root.'/'.$routees.'/uploads/logo/'.$nip_tiga.'.png';
        // var_dump($id_satu);die();
        if(file_exists($ttd_id_peminjam)){
            $templateProcessor->setImg('ttd_tiga', array('src' => $ttd_id_ketiga, 'size' => array(270, 93)));
        } elseif(file_exists($ttd_nip_peminjam)){
            $templateProcessor->setImg('ttd_tiga', array('src' => $ttd_nip_ketiga, 'size' => array(270, 93), 'text' => '(Cucun Suherman)<br> NIP. '.$nip_satu));
        }
        $id_dua = $this->m_persuratan->id_pihak_dua($id);
        $templateProcessor->setImg('bsre', array('src' => $root.'/'.$routees.'/uploads/logo/bsre.png', 'size' => array(710,63)));
        
        //Ambil dan Tampilkan QrCode
        $image_path = 'uploads/data_qrcode_naskah/'.$fileName;
        //$image_path = 'uploads/logo/blank_qr.png';
        $templateProcessor->setImg('qrcode', array('src' => $image_path,'size' => array( 80, 80 )));// QrCode
    // end peminjaman mobil
      }else{

    
    //Create QRCode
    include('./assets/qrcode/qrlib.php');
    $tempDir = 'uploads/data_qrcode_naskah/';
    $link = $master_url.'/'.$routees_portal.'/main/cekiz/unduh_surat/';
    $codeContents = $id.'/'.base64_encode($kepada);
    $codeContents = $link.$codeContents;//.'_idkeyST.'.$key;
    $fileName = 'iz_'.md5($codeContents).'.png';  // Create ID Naskah Key
    $pngAbsoluteFilePath = $tempDir.$fileName;
    $urlRelativeFilePath = base_url().$tempDir.$fileName; //EXAMPLE_TMP_URLRELPATH.$fileName;
    if(!file_exists($tempDir))    { mkdir($tempDir); }    #kalau folder belum ada, maka buat.

    $logopath = "$master_url/$routees/uploads/logo/logo_ttd.jpg";
      
    if(!file_exists($pngAbsoluteFilePath)) {  # jika file qrcode id_izin tidak ada  
      $quality = 'H'; //ada 4 pilihan, L (Low), M(Medium), Q(Good), H(High)
      $ukuran = 5;    //batasan 1 paling kecil, 10 paling besar
      $padding = 0;
      QRCode::png($codeContents,$tempDir.$fileName,$quality,$ukuran,$padding);
    }

    $QR = imagecreatefrompng($tempDir.$fileName);

    // memulai menggambar logo dalam file qrcode
    $logo = imagecreatefromstring(file_get_contents($logopath));
     
    imagecolortransparent($logo , imagecolorallocatealpha($logo , 0, 0, 0, 127));
    imagealphablending($logo , false);
    imagesavealpha($logo , true);

    $QR_width = imagesx($QR);
    $QR_height = imagesy($QR);

    $logo_width = imagesx($logo);
    $logo_height = imagesy($logo);

    // Scale logo to fit in the QR Code
    $logo_qr_width = $QR_width/2.4;
    $scale = $logo_width/$logo_qr_width;
    $logo_qr_height = $logo_height/$scale;

    imagecopyresampled($QR, $logo, $QR_width/3.2, $QR_height/3.2, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);

    // Simpan kode QR lagi, dengan logo di atasnya
    imagepng($QR,$tempDir.$fileName);
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
    //$image_path = 'uploads/logo/blank_qr.png';
    $templateProcessor->setImg('qrcode', array('src' => $image_path,'size' => array( 80, 80 )));// QrCode
    
    //Ambil dan Tampilkan TTD Penandatangan        
    $image_path = 'uploads/logo/TtdEKadis.png';
    $file_ttd = str_replace(" ", "", $ttd_nip);

    if (file_exists('uploads/logo/SRT_'.$ttd_idfile.'.png')) {
      $image_path = 'uploads/logo/SRT_'.$ttd_idfile.'.png';
    }

    $templateProcessor->setImg('ttd', array('src' => $image_path,'size' => array( 270, 93 ))); //default = 100, 47 | Pak Daud Plt = 140, 87    // ttd kadis

    //Ambil dan Tampilkan Kop Surat
    $image_path = 'uploads/logo/kop.png';
    $templateProcessor->setImg('kopsurat', array('src' => $image_path,'size' => array( 810, 150 ))); // ttd Kop Surat
    
    //Ambil dan Tampilkan Cap Dinas
    $image_path = 'uploads/logo/CapDinas.png';
    $templateProcessor->setImg('CapDinas', array('src' => $image_path,'size' => array( 150, 150 ))); // ttd Cap Dinas
    }
    //Create File docx
    $file_target = 'assets/docx-surat-processed/SRT_'.$id.'.docx';
    $simpan = $templateProcessor->saveAs($file_target);
    //EOF() Create File docx
    
    return true;    
    }else{
      return FALSE;
    }
  }

  public function konversi_pdf($id) {
    $redirect = str_replace(' ', '','SRT_'.$id);
    $namafile = preg_replace('/\s/i', '%20', $redirect); //isi 'namafile' dengan value nama file
    $opts = array('http' => array('header' => "User-Agent:MyAgent/1.0\r\n"));
    $php_self = $_SERVER['SCRIPT_NAME'];
    $url_self = str_replace("/index.php", "", $php_self);
    $url_domain = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$url_self;
    $context = stream_context_create($opts);
    // local
    $root = $_SERVER['DOCUMENT_ROOT'];
    $libre = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST']."/libreoffice/index.php?nama=$namafile&token=9wdxc7txiH&url=$url_domain";
    $data = file_get_contents($libre, FALSE, $context);
    // end local

    // prod
    // $data = file_get_contents('http://103.122.5.250/siapi/api/default?id='.$namafile.'&token=9wdxc7txiH&url='.$url_domain, FALSE, $context);
    // endprod

    $json = json_decode($data);
    if($json->status && $json->status == 'success') {
      // prod
      // $dtpdf = 'http://103.122.5.250/siapi/web/assets/pdf/' .preg_replace('/\s/i', '%20', $namafile). '.pdf';
      //endprod

      //local
      $dtpdf = $_SERVER['DOCUMENT_ROOT']."/libreoffice/pdf/$namafile.pdf";
      //endlocal

      $newfile = $_SERVER['DOCUMENT_ROOT'].$url_self .'/assets/pdf-surat/'.$namafile.'.pdf';
      if (copy($dtpdf, $newfile)) {
        //file_get_contents('http://103.111.57.226/nrspdf/web/index.php?r=site%2Fdelsurat&id='.$namafile.'&token=m1WOvGqS7G', FALSE, $context);

        //Create pdf watermark
        $this->load->library('cfpdf');
        $this->load->library('cfpdi');
        $pdf = new FPDI();
        $filename  = $_SERVER['DOCUMENT_ROOT'] .$url_self.'/assets/pdf-surat/'.$namafile.'.pdf'; //Lokasi File Tanpa WaterMark
        $filenameW = $_SERVER['DOCUMENT_ROOT'] .$url_self.'/assets/pdf-surat-wm/'.$namafile.'.pdf';    //Lokasi File WaterMark
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
    if ($this->olah_word($id)) {
      $this->session->set_flashdata('sukses', "Berhasil Refresh Berkas Docx.");
      redirect('persuratan');
    } else {
      $this->session->set_flashdata('gagal', "Gagal Refresh Berkas Docx.");
      redirect('persuratan');
    }
  }

  public function refresh_pdf($id) {
    if ($this->konversi_pdf($id)) {
      $this->session->set_flashdata('sukses', "Berhasil Refresh Berkas PDF.");
      redirect('persuratan/cetak_surat');
    } else {
      $this->session->set_flashdata('gagal', "Gagal Refresh Berkas PDF.");
      redirect('persuratan/cetak_surat');
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
  	if ($this->m_persuratan->delete_surat($id)) {
  		$this->session->set_flashdata('sukses', "Berhasil Hapus Data.");
      	redirect('persuratan');
  	} else {
  		$this->session->set_flashdata('gagal', "Gagal Hapus Data.");
      	redirect('persuratan');
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


  // mobil
    public function mobil($idmobil, $idpegawai) {
      $id_user      = $this->session->userdata('id_auth');
      $ess4         = $this->m_persuratan->get_id_peminjam($idmobil);
      // $ess3         = 911; // 453 id user bu gita // 851 pak luki // 1058 lian // 911 pak cucun
      // $sekdis       = 453;
      $ess3         = $this->m_persuratan->struktural(5);
      $sekdis       = $this->m_persuratan->struktural(4);
      $ess2         = '0';
      $analis_hukum = '0';
      $sifat_surat  = 'Biasa';
      $lampiran     = '1 (satu) berkas';
      $hal          = 'Berita Acara Peminjaman Kendaraan Dinas';
      $kepada       = 'Kepala Sub Bagian Tata Usaha';
      $logo         = '1';
      $simpan = $this->m_persuratan->save_data_mobil($id_user, $ess4, $ess3, $sekdis, $ess2, $sifat_surat, $lampiran, $hal, $kepada, "5", $logo, "1", $analis_hukum, $idmobil);
      if ($simpan != 0) {
        $id = $simpan;


        //Penyimpanan data Keu Perdin
        if ($this->All) {
           $lokasi     = $this->input->post('kabupaten');
	        $pkepada      = $this->input->post('listizin');
           $tglberangkat     = $this->input->post('tglberangkat');
          $tglkembali     = $this->input->post('tglkembali');
	        
	        if($pkepada){
		      	$user_kepada 	= ($pkepada ? $pkepada : Array());
		      	$tglberangkat     = $this->input->post('tglberangkat');
            $tglkembali     = $this->input->post('tglkembali');
            $beda =  round(abs(strtotime($tglberangkat) - strtotime($tglkembali))/86400)+1;
		        // $id_tim = $this->m_persuratan->save_tim($id);

			      // if($id_tim != 0) {
		          if (!empty($user_kepada)) {
		            foreach ($user_kepada as $row) {
		              $save_kepada = $this->m_persuratan->save_tim($id, $row, $lokasi,  $tglberangkat, $tglkembali, $beda);

		              if(!$save_kepada) {
		                $this->session->set_flashdata('gagal', "Gagal Menyimpan Data 1");
		                redirect('/peminjamanmobil/peminjam/'.$id);
		              }
		            }
		          }

		      }
	  	}
        //End of Penyimpanan data Keu Perdin


        $php_self = $_SERVER['SCRIPT_NAME'];
        $url_self = str_replace("/index.php", "", $php_self);
        $url_domain = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$url_self;
        $file = "$url_domain/assets/docx-surat/SRT_mobil.docx";
        $file_name = basename('SRT_mobil.docx');
        // $file_name = file_get_contents($sourceFilePath);        
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        
        $target_dir = "assets/docx-surat/";
        $target_docx = "assets/docx-surat-processed/";
        $target_file = $target_dir . $file_name;
        $fileBaru = $target_dir.'SRT_'.$id.'.'.$ext;
        
        $sourceFilePath = "assets/template/SRT_mobil.docx"; // Ganti dengan path file sumber yang ingin disalin
        $destinationFilePath = "assets/docx-surat/SRT_mobil.docx"; // Ganti dengan path tempat Anda ingin menyalin file
        $destinationFilePathdocx = "assets/docx-surat-processed/SRT_mobil.docx"; // Ganti dengan path tempat Anda ingin menyalin file
        chmod($target_dir, 0777);
        chmod($target_docx, 0777);
            // var_dump(copy($sourceFilePath, $destinationFilePath));die();
        if (copy($sourceFilePath, $destinationFilePath)) {
          $oldFilePath = "assets/docx-surat/SRT_mobil.docx"; // Ganti dengan path file yang ingin diubah namanya
          $newFilePath = "assets/docx-surat/SRT_".$id.".docx"; // Ganti dengan path dan nama baru yang diinginkan
          $newFilePath2 = "assets/docx-surat-processed/SRT_".$id.".docx"; // Ganti dengan path dan nama baru yang diinginkan
        // var_dump(copy($sourceFilePath, $destinationFilePath));die();
          if (rename($oldFilePath, $newFilePath)) {
            // var_dump(copy($newFilePath, $newFilePath2));die();
            if (copy($newFilePath, $newFilePath2)) {
              
            } else {
              chmod($target_dir, 0755);
              chmod($target_docx, 0755);
                $this->session->set_flashdata('gagal', "Gagal Membuat Dokumen Surat. (PDF)");
                redirect('/peminjamanmobil/peminjaman');
            }
              echo "File berhasil diubah namanya.";
              chmod($target_docx, 0755);
              chmod($target_dir, 0755);
          } else {
            chmod($target_dir, 0755);
            chmod($target_docx, 0755);
            $this->session->set_flashdata('gagal', "Gagal mengubah nama file.");
            redirect('/peminjamanmobil/peminjaman');
          }
          chmod($target_dir, 0755);
          chmod($target_docx, 0755);
            echo "File berhasil disalin.";
        } else {
          chmod($target_dir, 0755);
          chmod($target_docx, 0755);
            $this->session->set_flashdata('gagal', "Gagal Membuat Dokumen Surat. (PDF)");
            redirect('/peminjamanmobil/peminjaman');
        }
        // $upload = rename($oldFilePath, $newFilePath);
        // $upload = file_get_contents($file);  
        // var_dump($upload);die();

        // if($upload) {
          // $rnm = rename($target_file, $fileBaru);

          $this->m_persuratan->update_path($id, $newFilePath);

          $dok = $this->olah_word($id);

          if ($dok) {
            $convert = $this->konversi_pdf($id);

            if ($convert) {
              $this->session->set_flashdata('sukses', "Berhasil Menyimpan Data & Membuat Dokumen Surat.");
              redirect('/persuratan/update_penomoran_ba_mobil/'.$id.'/'.$idmobil);
            } else {
              $this->session->set_flashdata('gagal', "Gagal Membuat Dokumen Surat. (PDF)");
              redirect('/peminjamanmobil/peminjaman');
            }
            
            $this->session->set_flashdata('sukses', "Berhasil Menyimpan Data & Membuat Dokumen Surat.");
            redirect('/peminjamanmobil/peminjaman');
          } else {
            $this->session->set_flashdata('gagal', "Gagal Membuat Dokumen Surat. (Docx)");
            redirect('/peminjamanmobil/peminjaman');
          }
        // } else {
        //   // $this->session->set_flashdata('sukses', "Berhasil membuat Berita acara");
        //   // redirect('/persuratan/update_penomoran_ba_mobil/'.$id.'/'.$idmobil);
          
        //   $this->session->set_flashdata('gagal', "Gagal Menggunggah File Dokumen.");
        //   redirect('/persuratan');
        // }
      } else {
        $this->session->set_flashdata('gagal', "Gagal Meyimpan Data Surat.");
        redirect('/peminjamanmobil/peminjaman');
      }
  }

    public function reload_mobil($idmobil, $idpegawai, $id_surat) {
      $id_user      = $this->session->userdata('id_auth');
      $ess4         = $this->m_persuratan->get_id_peminjam($idmobil);
      $ess3         = 911; // 453 id user bu gita // 851 pak luki // 1058 lian // 911 pak cucun
      $sekdis       = 453;
      $ess2         = '0';
      $analis_hukum = '0';
      $sifat_surat  = 'Biasa';
      $lampiran     = '1 (satu) berkas';
      $hal          = 'Berita Acara Peminjaman Kendaraan Dinas';
      $kepada       = 'Kepala Sub Bagian Tata Usaha';
      $logo         = '1';
      // var_dump($this->All);die();
      $simpan = $this->m_persuratan->update_data_mobil($id_user, $ess4, $ess3, $sekdis, $ess2, $sifat_surat, $lampiran, $hal, $kepada, "5", $logo, "1", $analis_hukum, $idmobil, $id_surat);
      if($simpan){
        $simpan = $id_surat;
      }else{
        echo 'Error koneksi';die();
      }
      if ($simpan != 0) {
        $id = $simpan;


        //Penyimpanan data Keu Perdin
        if ($this->All) {
           $lokasi     = $this->input->post('kabupaten');
	        $pkepada      = $this->input->post('listizin');
           $tglberangkat     = $this->input->post('tglberangkat');
          $tglkembali     = $this->input->post('tglkembali');
	        
	        if($pkepada){
		      	$user_kepada 	= ($pkepada ? $pkepada : Array());
		      	$tglberangkat     = $this->input->post('tglberangkat');
            $tglkembali     = $this->input->post('tglkembali');
            $beda =  round(abs(strtotime($tglberangkat) - strtotime($tglkembali))/86400)+1;
		        // $id_tim = $this->m_persuratan->save_tim($id);

			      // if($id_tim != 0) {
		          if (!empty($user_kepada)) {
		            foreach ($user_kepada as $row) {
		              $save_kepada = $this->m_persuratan->save_tim($id, $row, $lokasi,  $tglberangkat, $tglkembali, $beda);

		              if(!$save_kepada) {
		                $this->session->set_flashdata('gagal', "Gagal Menyimpan Data 1");
		                redirect('/peminjamanmobil/peminjam/'.$id);
		              }
		            }
		          }

		      }
	  	}
        //End of Penyimpanan data Keu Perdin


        $url_self = str_replace("/index.php", "", $php_self);
        $url_domain = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$url_self;
        $file = "$url_domain/assets/docx-surat/SRT_mobil.docx";
        $file_name = basename('SRT_mobil.docx');
        // $file_name = file_get_contents($sourceFilePath);        
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        
        $target_dir = "assets/docx-surat/";
        $target_docx = "assets/docx-surat-processed/";
        $target_file = $target_dir . $file_name;
        $fileBaru = $target_dir.'SRT_'.$id.'.'.$ext;
        
        $sourceFilePath = "assets/template/SRT_mobil.docx"; // Ganti dengan path file sumber yang ingin disalin
        $destinationFilePath = "assets/docx-surat/SRT_mobil.docx"; // Ganti dengan path tempat Anda ingin menyalin file
        $destinationFilePathdocx = "assets/docx-surat-processed/SRT_mobil.docx"; // Ganti dengan path tempat Anda ingin menyalin file
        chmod($target_dir, 0777);
        chmod($target_docx, 0777);
        if (copy($sourceFilePath, $destinationFilePath)) {
          $oldFilePath = "assets/docx-surat/SRT_mobil.docx"; // Ganti dengan path file yang ingin diubah namanya
          $newFilePath = "assets/docx-surat/SRT_".$id.".docx"; // Ganti dengan path dan nama baru yang diinginkan
          $newFilePath2 = "assets/docx-surat-processed/SRT_".$id.".docx"; // Ganti dengan path dan nama baru yang diinginkan
          if (rename($oldFilePath, $newFilePath)) {
            if (copy($newFilePath, $newFilePath2)) {
              
            } else {
              chmod($target_dir, 0755);
              chmod($target_docx, 0755);
                $this->session->set_flashdata('gagal', "Gagal Membuat Dokumen Surat. (PDF)");
                if($this->All){
                  $message = copy($newFilePath, $newFilePath2);
                  error_reporting(E_ALL | E_STRICT);
                  display_error($message);die();
                }
                redirect('/peminjamanmobil/peminjaman');
            }
              echo "File berhasil diubah namanya.";
              chmod($target_docx, 0755);
              chmod($target_dir, 0755);
          } else {
            chmod($target_dir, 0755);
            chmod($target_docx, 0755);
            $this->session->set_flashdata('gagal', "Gagal mengubah nama file.");
                if($this->All){
                  $message = copy($newFilePath, $newFilePath2);
                  error_reporting(E_ALL | E_STRICT);
                  display_error($message);die();
                }
            redirect('/peminjamanmobil/peminjaman');
          }
          chmod($target_dir, 0755);
          chmod($target_docx, 0755);
            echo "File berhasil disalin.";
        } else {
          chmod($target_dir, 0755);
          chmod($target_docx, 0755);
                if($this->All){
                  $message = copy($sourceFilePath, $destinationFilePath);
                  error_reporting(E_ALL | E_STRICT);
                  display_error($message);die();
                }
            $this->session->set_flashdata('gagal', "Gagal Membuat Dokumen Surat. (PDF)");
            redirect('/peminjamanmobil/peminjaman');
        }
        // $upload = rename($oldFilePath, $newFilePath);
        // $upload = file_get_contents($file);  

        // if($upload) {
          // $rnm = rename($target_file, $fileBaru);

          $this->m_persuratan->update_path($id, $newFilePath);

          $dok = $this->olah_word($id);

          if ($dok) {
            $convert = $this->konversi_pdf($id);

            if ($convert) {
              $this->session->set_flashdata('sukses', "Berhasil Menyimpan Data & Membuat Dokumen Surat.");
              redirect('/persuratan/update_penomoran_ba_mobil/'.$id.'/'.$idmobil);
            } else {
              $this->session->set_flashdata('gagal', "Gagal Membuat Dokumen Surat. (PDF)");
                if($this->All){
                  $message = $convert;
                  error_reporting(E_ALL | E_STRICT);
                  display_error($message);die();
                }
              redirect('/peminjamanmobil/peminjaman');
            }
            
            $this->session->set_flashdata('sukses', "Berhasil Menyimpan Data & Membuat Dokumen Surat.");
            redirect('/peminjamanmobil/peminjaman');
          } else {
                if($this->All){
                  $message = $dok;
                  error_reporting(E_ALL | E_STRICT);
                  display_error($message);die();
                }
            $this->session->set_flashdata('gagal', "Gagal Membuat Dokumen Surat. (Docx)");
            redirect('/peminjamanmobil/peminjaman');
          }
        // } else {
        //   // $this->session->set_flashdata('sukses', "Berhasil membuat Berita acara");
        //   // redirect('/persuratan/update_penomoran_ba_mobil/'.$id.'/'.$idmobil);
          
        //   $this->session->set_flashdata('gagal', "Gagal Menggunggah File Dokumen.");
        //   redirect('/persuratan');
        // }
      } else {
        $this->session->set_flashdata('gagal', "Gagal Meyimpan Data Surat.");
                if($this->All){
                  error_reporting(E_ALL | E_STRICT);
                  display_error($simpan != 0);die();
                }
        redirect('/peminjamanmobil/peminjaman');
      }
  }

   public function update_penomoran_ba_mobil($id, $idmobil) {
    $id_user = $this->session->userdata('id_auth');

    $nomor_surat  = date('Ymdgis');
    $tgl_surat    = date('Y-m-d');
    // $id           = $this->input->post('id');

    $simpan = $this->m_persuratan->update_penomoran($id, $nomor_surat, $tgl_surat);
    if ($simpan) {
      $dok = $this->olah_word($id);

          if ($dok) {
            $convert = $this->konversi_pdf($id);

            if ($convert) {
              $this->session->set_flashdata('sukses', "Berhasil Menyimpan Data & Membuat Dokumen Surat.");
              redirect('peminjamanmobil/approve_old/'.$idmobil);
            } else {
              $this->session->set_flashdata('gagal', "Gagal Membuat Dokumen Surat. (PDF)");
              redirect('persuratan/penomoran');
            }

            $this->session->set_flashdata('sukses', "Berhasil Menyimpan Data & Membuat Dokumen Surat.");
            redirect('peminjamanmobil/approve_old/'.$idmobil);
          } else {
            $this->session->set_flashdata('gagal', "Gagal Membuat Dokumen Surat. (Docx)");
            redirect('persuratan/penomoran');
          }
    } else {
      $this->session->set_flashdata('gagal', "Gagal Meyimpan Data Surat");
      redirect('persuratan/penomoran');
    }
  }
    public function hapus_mobil($id, $kategori) {
    $id_surat = $this->m_persuratan->get_id_surat_mobil($id);
    // var_dump($id_surat);die();
  	if ($this->m_persuratan->delete_surat($id_surat)) {
      // $id_tim = $this->m_persuratan->del_tim($id_surat);        
        $php_self = $_SERVER['SCRIPT_NAME'];
        $url_self = str_replace("/index.php", "", $php_self);
        $url_domain = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$url_self;
  		  $this->session->set_flashdata('sukses', "Berhasil Hapus Data.");
        $target_dir = $_SERVER['DOCUMENT_ROOT']."/".$url_self."/assets/pdf-surat/SRT_".$id_surat.".pdf";
        $target_dir_word = $_SERVER['DOCUMENT_ROOT']."/".$url_self."/assets/docx-surat/SRT_".$id_surat.".pdf";
        $processed = $_SERVER['DOCUMENT_ROOT']."/".$url_self."/assets/docx-surat-processed/SRT_".$id_surat.".pdf";
        $pdfsuratwm = $_SERVER['DOCUMENT_ROOT']."/".$url_self."/assets/pdf-surat-wm/SRT_".$id_surat.".pdf";
        $file_path = $target_dir;
        $file_path_word = $target_dir_word;
      // $file_path = 'path/to/your/SRT_'.$id_surat.'.txt';

      if (file_exists($file_path_word)) {
          if (unlink($file_path_word)) {
              echo "File berhasil dihapus.";
          } else {
              echo "Gagal menghapus file.";
          }
      } else {
          echo "File tidak ditemukan.";
      }
      if (file_exists($processed)) {
          if (unlink($processed)) {
              echo "File berhasil dihapus.";
          } else {
              echo "Gagal menghapus file.";
          }
      } else {
          echo "File tidak ditemukan.";
      }
      if (file_exists($pdfsuratwm)) {
          if (unlink($pdfsuratwm)) {
              echo "File berhasil dihapus.";
          } else {
              echo "Gagal menghapus file.";
          }
      } else {
          echo "File tidak ditemukan.";
      }
      if (file_exists($file_path)) {
          if (unlink($file_path)) {
              echo "File berhasil dihapus.";
          } else {
              echo "Gagal menghapus file.";
          }
      } else {
          echo "File tidak ditemukan.";
      }
      if($kategori == 'mobil'){
        redirect($url_domain.'/persuratan/mobil/'.$id);
      }else{
        redirect($url_domain.'/persuratan/laptop/'.$id);
      }
  	} else {
  		$this->session->set_flashdata('gagal', "Gagal Hapus Data.");
      if($kategori == 'mobil'){
        redirect($url_domain.'/persuratan/mobil/'.$id);
      }else{
        redirect($url_domain.'/persuratan/laptop/'.$id);
      }
  	}
  }

    public function laptop($idmobil) {
      $id_user      = $this->session->userdata('id_auth');
      $ess4         = $this->m_persuratan->get_id_peminjam($idmobil);
      // $ess4         = $idpegawai;
      $ess3         = $this->m_persuratan->struktural(7);
      // $ess3         = $this->m_persuratan->get_id_peminjam($idmobil);;
      $sekdis       = $this->m_persuratan->struktural(4);
      $ess2         = '0';
      $analis_hukum = '0';
      $sifat_surat  = 'Biasa';
      $lampiran     = '1 (satu) berkas';
      $hal          = 'Berita Acara Peminjaman Laptop Dinas';
      $kepada       = 'Kepala Sub Bagian Tata Usaha';
      $logo         = '1';
      $simpan = $this->m_persuratan->save_data_mobil($id_user, $ess4, $ess3, $sekdis, $ess2, $sifat_surat, $lampiran, $hal, $kepada, "5", $logo, "1", $analis_hukum, $idmobil);
      if ($simpan != 0) {
        $id = $simpan;


        //Penyimpanan data Keu Perdin
        if ($this->All) {
           $lokasi     = $this->input->post('kabupaten');
	        $pkepada      = $this->input->post('listizin');
           $tglberangkat     = $this->input->post('tglberangkat');
          $tglkembali     = $this->input->post('tglkembali');
	        
	        if($pkepada){
		      	$user_kepada 	= ($pkepada ? $pkepada : Array());
		      	$tglberangkat     = $this->input->post('tglberangkat');
            $tglkembali     = $this->input->post('tglkembali');
            $beda =  round(abs(strtotime($tglberangkat) - strtotime($tglkembali))/86400)+1;
		          if (!empty($user_kepada)) {
		            foreach ($user_kepada as $row) {
		              $save_kepada = $this->m_persuratan->save_tim($id, $row, $lokasi,  $tglberangkat, $tglkembali, $beda);

		              if(!$save_kepada) {
		                $this->session->set_flashdata('gagal', "Gagal Menyimpan Data 1");
		                // redirect('/peminjamanmobil/peminjam/'.$id);
                    return FALSE;
		              }
		            }
		          }

		      }
	  	  }
        //End of Penyimpanan data Keu Perdin

        $routees        = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
        $root           = rtrim($_SERVER['DOCUMENT_ROOT'], '/'); // buang trailing slash
        $routees        = ltrim($routees, '/');              // buang leading slash
        $routees_portal = str_replace('backoffice/index.php', '', $_SERVER['SCRIPT_NAME']); 
        $master_url     = $_SERVER['REQUEST_SCHEME'] .'://'. $_SERVER['HTTP_HOST'];
        $file = "$master_url/$routees"."assets/docx-surat/SRT_laptop.docx";
        $file_name = basename('SRT_laptop.docx');      
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        $array_hasil = []; 
        
        $target_dir = "assets/docx-surat/";
        $target_docx = "assets/docx-surat-processed/";
        $target_file = $target_dir . $file_name;
        $fileBaru = $target_dir.'SRT_'.$id.'.'.$ext;
        
        $sourceFilePath = "assets/template/SRT_laptop.docx"; // Ganti dengan path file sumber yang ingin disalin
        $destinationFilePath = "assets/docx-surat/SRT_laptop.docx"; // Ganti dengan path tempat Anda ingin menyalin file
        $destinationFilePathdocx = "assets/docx-surat-processed/SRT_laptop.docx"; // Ganti dengan path tempat Anda ingin menyalin file
        chmod($target_dir, 0777);
        chmod($target_docx, 0777);
        if (copy($sourceFilePath, $destinationFilePath)) {
          $oldFilePath = "assets/docx-surat/SRT_laptop.docx"; // Ganti dengan path file yang ingin diubah namanya
          $newFilePath = "assets/docx-surat/SRT_".$id.".docx"; // Ganti dengan path dan nama baru yang diinginkan
          $newFilePath2 = "assets/docx-surat-processed/SRT_".$id.".docx"; // Ganti dengan path dan nama baru yang diinginkan
          if (rename($oldFilePath, $newFilePath)) {
            if (copy($newFilePath, $newFilePath2)) {
              
            } else {
              chmod($target_dir, 0755);
              chmod($target_docx, 0755);
                $this->session->set_flashdata('gagal', "Gagal Membuat Dokumen Surat. (PDF)");
                redirect('/peminjamanmobil/peminjaman');
            }
              echo "File berhasil diubah namanya.";
              chmod($target_docx, 0755);
              chmod($target_dir, 0755);
          } else {
            chmod($target_dir, 0755);
            chmod($target_docx, 0755);
            $this->session->set_flashdata('gagal', "Gagal mengubah nama file.");
            redirect('/peminjamanmobil/peminjaman');
          }
          chmod($target_dir, 0755);
          chmod($target_docx, 0755);
            echo "File berhasil disalin.";
        } else {
          chmod($target_dir, 0755);
          chmod($target_docx, 0755);
            $this->session->set_flashdata('gagal', "Gagal Membuat Dokumen Surat. (PDF)");
            $status = 'false';
            $array_hasil[] = 'Gagal Membuat Dokumen Surat. (PDF)';
            $array_hasil[] = $status;
            return $array_hasil;
        }

          $this->m_persuratan->update_path($id, $newFilePath);

          $dok = $this->olah_word($id);

          if ($dok) {
            $convert = $this->konversi_pdf($id);

            if ($convert) {
              $this->session->set_flashdata('sukses', "Berhasil Menyimpan Data & Membuat Dokumen Surat.");
              $nomor = $this->update_penomoran_ba_laptop($id,$idmobil);
              if($nomor){
                return TRUE;
              }else{
                return FALSE;
              }
            } else {
              $this->session->set_flashdata('gagal', "Gagal Membuat Dokumen Surat. (PDF)");
              $status = 'false';
              $array_hasil[] = 'Gagal Membuat Dokumen Surat. (PDF)';
              $array_hasil[] = $status;
              return $array_hasil;
            }
          } else {
            $this->session->set_flashdata('gagal', "Gagal Membuat Dokumen Surat. (Docx)");
              $status = 'false';
              $array_hasil[] = 'Gagal Membuat Dokumen Surat. (Docx)';
              $array_hasil[] = $status;
              return $array_hasil;
          }
      } else {
        $this->session->set_flashdata('gagal', "Gagal Meyimpan Data Surat.");
              $status = 'false';
              $array_hasil[] = 'Gagal Meyimpan Data Surat.';
              $array_hasil[] = $status;
              return $array_hasil;
      }
  }

    public function reload_laptop($idmobil, $idpegawai, $id_surat) {
      $id_user      = $this->session->userdata('id_auth');
      $surat = $this->m_persuratan->get_data_persuratan_byid($id_surat);
      $ess4         = $surat->ess4;
      // $ess3         = 911; // 453 id user bu gita // 851 pak luki // 1058 lian // 911 pak cucun
      $ess3         = $surat->ess3;
      // $ess3         = $this->m_persuratan->get_id_peminjam($idmobil);;
      $sekdis       = $surat->sekdis;
      $ess2         = $surat->ess2;
      $analis_hukum = $surat->analis_hukum;
      $sifat_surat  = $surat->sifat_surat;
      $lampiran     = $surat->lampiran;
      $hal          = $surat->hal;
      $kepada       = $surat->kepada;
      $logo         = $surat->logo_bsre;
      // var_dump($this->All);die();
      $simpan = $this->m_persuratan->update_data_mobil($id_user, $ess4, $ess3, $sekdis, $ess2, $sifat_surat, $lampiran, $hal, $kepada, "5", $logo, "1", $analis_hukum, $idmobil, $id_surat);
      if($simpan){
        $simpan = $id_surat;
      }else{
        echo 'Error koneksi';die();
      }
      if ($simpan != 0) {
        $id = $simpan;


        //Penyimpanan data Keu Perdin
        if ($this->All) {
           $lokasi     = $this->input->post('kabupaten');
	        $pkepada      = $this->input->post('listizin');
           $tglberangkat     = $this->input->post('tglberangkat');
          $tglkembali     = $this->input->post('tglkembali');
	        
	        if($pkepada){
		      	$user_kepada 	= ($pkepada ? $pkepada : Array());
		      	$tglberangkat     = $this->input->post('tglberangkat');
            $tglkembali     = $this->input->post('tglkembali');
            $beda =  round(abs(strtotime($tglberangkat) - strtotime($tglkembali))/86400)+1;
		        // $id_tim = $this->m_persuratan->save_tim($id);

			      // if($id_tim != 0) {
		          if (!empty($user_kepada)) {
		            foreach ($user_kepada as $row) {
		              $save_kepada = $this->m_persuratan->save_tim($id, $row, $lokasi,  $tglberangkat, $tglkembali, $beda);

		              if(!$save_kepada) {
		                $this->session->set_flashdata('gagal', "Gagal Menyimpan Data 1");
		                redirect('/peminjamanmobil/peminjam/'.$id);
		              }
		            }
		          }

		      }
	  	}
        //End of Penyimpanan data Keu Perdin
        $routees        = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
        $root           = rtrim($_SERVER['DOCUMENT_ROOT'], '/'); // buang trailing slash
        $routees        = ltrim($routees, '/');              // buang leading slash
        $routees_portal = str_replace('backoffice/index.php', '', $_SERVER['SCRIPT_NAME']); 
        $master_url     = $_SERVER['REQUEST_SCHEME'] .'://'. $_SERVER['HTTP_HOST'];

        $file = "$master_url/$routees"."assets/docx-surat/SRT_mobil.docx";
        $file_name = basename('SRT_mobil.docx');
        // $file_name = file_get_contents($sourceFilePath);        
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        
        $target_dir = "assets/docx-surat/";
        $target_docx = "assets/docx-surat-processed/";
        $target_file = $target_dir . $file_name;
        $fileBaru = $target_dir.'SRT_'.$id.'.'.$ext;
        
        $sourceFilePath = "assets/template/SRT_mobil.docx"; // Ganti dengan path file sumber yang ingin disalin
        $destinationFilePath = "assets/docx-surat/SRT_mobil.docx"; // Ganti dengan path tempat Anda ingin menyalin file
        $destinationFilePathdocx = "assets/docx-surat-processed/SRT_mobil.docx"; // Ganti dengan path tempat Anda ingin menyalin file
        chmod($target_dir, 0777);
        chmod($target_docx, 0777);
        if (copy($sourceFilePath, $destinationFilePath)) {
          $oldFilePath = "assets/docx-surat/SRT_mobil.docx"; // Ganti dengan path file yang ingin diubah namanya
          $newFilePath = "assets/docx-surat/SRT_".$id.".docx"; // Ganti dengan path dan nama baru yang diinginkan
          $newFilePath2 = "assets/docx-surat-processed/SRT_".$id.".docx"; // Ganti dengan path dan nama baru yang diinginkan
          if (rename($oldFilePath, $newFilePath)) {
            if (copy($newFilePath, $newFilePath2)) {
              
            } else {
              chmod($target_dir, 0755);
              chmod($target_docx, 0755);
                $this->session->set_flashdata('gagal', "Gagal Membuat Dokumen Surat. (PDF)");
                if($this->All){
                  $message = copy($newFilePath, $newFilePath2);
                  error_reporting(E_ALL | E_STRICT);
                  display_error($message);die();
                }
                redirect('/peminjamanmobil/peminjaman_laptop');
            }
              echo "File berhasil diubah namanya.";
              chmod($target_docx, 0755);
              chmod($target_dir, 0755);
          } else {
            chmod($target_dir, 0755);
            chmod($target_docx, 0755);
            $this->session->set_flashdata('gagal', "Gagal mengubah nama file.");
                if($this->All){
                  $message = copy($newFilePath, $newFilePath2);
                  error_reporting(E_ALL | E_STRICT);
                  display_error($message);die();
                }
            redirect('/peminjamanmobil/peminjaman_laptop');
          }
          chmod($target_dir, 0755);
          chmod($target_docx, 0755);
            echo "File berhasil disalin.";
        } else {
          chmod($target_dir, 0755);
          chmod($target_docx, 0755);
                if($this->All){
                  $message = copy($sourceFilePath, $destinationFilePath);
                  error_reporting(E_ALL | E_STRICT);
                  display_error($message);die();
                }
            $this->session->set_flashdata('gagal', "Gagal Membuat Dokumen Surat. (PDF)");
            redirect('/peminjamanmobil/peminjaman_laptop');
        }
        // $upload = rename($oldFilePath, $newFilePath);
        // $upload = file_get_contents($file);  

        // if($upload) {
          // $rnm = rename($target_file, $fileBaru);

          $this->m_persuratan->update_path($id, $newFilePath);

          $dok = $this->olah_word($id);

          if ($dok) {
            $convert = $this->konversi_pdf($id);

            if ($convert) {
              $this->session->set_flashdata('sukses', "Berhasil Menyimpan Data & Membuat Dokumen Surat.");
              redirect('/persuratan/update_penomoran_ba_laptop/'.$id.'/'.$idmobil);
            } else {
              $this->session->set_flashdata('gagal', "Gagal Membuat Dokumen Surat. (PDF)");
                if($this->All){
                  $message = $convert;
                  error_reporting(E_ALL | E_STRICT);
                  display_error($message);die();
                }
              redirect('/peminjamanmobil/peminjaman_laptop');
            }
            
            $this->session->set_flashdata('sukses', "Berhasil Menyimpan Data & Membuat Dokumen Surat.");
            redirect('/peminjamanmobil/peminjaman');
          } else {
                if($this->All){
                  $message = $dok;
                  error_reporting(E_ALL | E_STRICT);
                  display_error($message);die();
                }
            $this->session->set_flashdata('gagal', "Gagal Membuat Dokumen Surat. (Docx)");
            redirect('/peminjamanmobil/peminjaman_laptop');
          }
        // } else {
        //   // $this->session->set_flashdata('sukses', "Berhasil membuat Berita acara");
        //   // redirect('/persuratan/update_penomoran_ba_mobil/'.$id.'/'.$idmobil);
          
        //   $this->session->set_flashdata('gagal', "Gagal Menggunggah File Dokumen.");
        //   redirect('/persuratan');
        // }
      } else {
        $this->session->set_flashdata('gagal', "Gagal Meyimpan Data Surat.");
                if($this->All){
                  error_reporting(E_ALL | E_STRICT);
                  display_error($simpan != 0);die();
                }
        redirect('/peminjamanmobil/peminjaman_laptop');
      }
  }
    public function update_penomoran_ba_laptop($id, $idmobil) {
    $id_user = $this->session->userdata('id_auth');

    $nomor_surat  = date('Ymdgis');
    $tgl_surat    = date('Y-m-d');
    // $id           = $this->input->post('id');

    $simpan = $this->m_persuratan->update_penomoran($id, $nomor_surat, $tgl_surat);
    if ($simpan) {
      $dok = $this->olah_word($id);

          if ($dok) {
            $convert = $this->konversi_pdf($id);

            if ($convert) {
              $this->session->set_flashdata('sukses', "Berhasil Menyimpan Data & Membuat Dokumen Surat.");
              redirect('peminjamanmobil/approve_old_laptop/'.$idmobil);
              // return TRUE;
            } else {
              $this->session->set_flashdata('gagal', "Gagal Membuat Dokumen Surat. (PDF)");
              // return FALSE;
              redirect('persuratan/penomoran');
            }

            $this->session->set_flashdata('sukses', "Berhasil Menyimpan Data & Membuat Dokumen Surat.");
            redirect('peminjamanmobil/approve_old_laptop/'.$idmobil);
          } else {
            $this->session->set_flashdata('gagal', "Gagal Membuat Dokumen Surat. (Docx)");
              // return FALSE;
            redirect('persuratan/penomoran');
          }
    } else {
      $this->session->set_flashdata('gagal', "Gagal Meyimpan Data Surat");
      // return FALSE;
      redirect('persuratan/penomoran');
    }
}
}