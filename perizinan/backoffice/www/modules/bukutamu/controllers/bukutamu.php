<?php
/*
 * Created By : Jonas Banurea / 25-02-2022
 */

class Bukutamu extends WRC_AdminCont {
    public function __construct() {
      parent::__construct();
      $this->load->model("m_bukutamu");
	    $base_url = base_url();
      $enabled = FALSE;
  	  $this->All = FALSE;
      $list_auths = $this->session_info['app_list_auth'];

      foreach ($list_auths as $list_auth) {
  			if ($list_auth->id_role === '36') {
          $enabled = TRUE;
        }
  			if ($list_auth->id_role === '18') {
          $this->All = TRUE;
        }
      }

      if (!$enabled) {
          redirect('dashboard');
      }
    }

    public function index_old() {
       $now = $this->lib_date->get_date_now();
      $tgla = (!empty($this->input->post('tgla')) ? $this->input->post('tgla') : $this->lib_date->set_date($now, 0));;
      $tglb = (!empty($this->input->post('tglb')) ? $this->input->post('tglb') : $this->lib_date->set_date($now, 0));
      $mark = $this->input->post('mark');
      $statusizin = $this->input->post('statusizin');

       $data['tgla'] = $tgla;
      $data['tglb'] = $tglb;
      $search  = $this->m_bukutamu->get_data($tgla, $tglb);
        $data['search'] = $search;
      $admin = "";
      if ($this->All) { //feba =560, ladia = 446, tya = 434, 39=sahal, 338: priana
        $admin = 1;
      } else {
        $admin = 0;
      }
      $data['admin'] = $admin;
      

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
      $this->session_info['page_name'] = "Bukutamu & E-Report";
      $this->template->build('bukutamu_list', $this->session_info); 
    }

    public function index() {
      $now = $this->lib_date->get_date_now();
      $tgla = (!empty($this->input->post('tgla')) ? $this->input->post('tgla') : $this->lib_date->set_date($now, 0));
      $tglb = (!empty($this->input->post('tglb')) ? $this->input->post('tglb') : $this->lib_date->set_date($now, 0));

      $tglc = $tgla; //(!empty($this->input->post('tglc')) ? $this->input->post('tglc') : $this->lib_date->set_date($now, -30));
      $tgld = $tglb; //(!empty($this->input->post('tgld')) ? $this->input->post('tgld') : $this->lib_date->set_date($now, 0)); 

      $mark = $this->input->post('mark');
      $statusizin = $this->input->post('statusizin');

      $data['tgla'] = $tgla;
      $data['tglb'] = $tglb;

      $data['tglc'] = $tglc;
      $data['tgld'] = $tgld;

      $search  = $this->m_bukutamu->get_data($tgla, $tglb);
      $data['search'] = $search;
      $admin = "";
      if ($this->All) { 
        $admin = 1;
      } else {
        $admin = 0;
      }
      $data['admin'] = $admin;
      $peringkat = $this->m_bukutamu->getperingkatnegara();
      $data['peringkat'] = $peringkat;
      $data['mpp'] = $this->m_bukutamu->getmpp();
      $data['sektor'] = $this->m_bukutamu->getsektor($tglc, $tgld);
      $data['tujuandatang'] = $this->m_bukutamu->gettujuandatang($tglc, $tgld);
      $data['lokasimpp'] = $this->m_bukutamu->getlokasimpp($tglc, $tgld);
      $data['namalokasimpp'] = $this->m_bukutamu->getnamalokasimpp();
      $data['petugas'] = $this->m_bukutamu->getpetugas($tglc, $tgld);
      $data['sum19tw1'] = $this->m_bukutamu->getSum2019TW1();
      $data['sum21pma'] = $this->m_bukutamu->getSum2021PMA();
      // var_dump(count($data['sektor']));die;
      //var_dump($data);die;

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
               $(\"#tabs\").tabs();
              $(\".monbulan\").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy-mm-dd',
                closeText: 'X'
              });
              $('#form').validate();
            });";

      $this->template->set_metadata_javascript($js);
      $this->session_info['page_name'] = "Bukutamu & E-Report";
      $this->template->build('bukutamu_list_test', $this->session_info);
    }

    public function cetak_excel($tgla = 0, $tglb = 0){
           $sql = "SELECT * 
                    FROM euis_bukutamu 
                    WHERE DATE(waktu) BETWEEN ? AND ?
                    
                    ORDER BY  waktu  DESC";
    
            $list_tamu = $this->db->query($sql, array($tgla, $tglb))->result();
            
            header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
            header("Content-Disposition: attachment; filename=REKAP_E-REPORT_BUKUTAMU_DPMPTSP_JABAR.xls");
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Cache-Control: private",false);

            echo "<table width='100%' border='0' font-size:16px;'>";
            echo "DAFTAR TAMU / E-REPORT DPMPTSP JAWA BARAT";
            echo "<tr>PERIODE : ".$this->lib_date->mysql_to_human($tgla)." - ".$this->lib_date->mysql_to_human($tglb)."</tr>";
            echo "</table>";
           
 
            $jdl= " <tr>
                      <td>".'NO.'."</td>
                      <td>".'Tanggal'."</td>
                      <td>".'Nama Tamu'."</td>
                      <td>".'Nomor Induk Kependudukan (NIK)'."</td>
                      <td>".'Email'."</td>
                      <td>".'Nomor Telepon '."</td>
                      <td>".'Sektor'."</td>
                      <td>".'Jenis Izin'."</td>
                      <td>".'Jabatan'."</td>
                      <td>".'Nama Perusahaan/Instansi'."</td>
                      <td>".'Nomor Induk Berusaha (NIB)'."</td>
                      <td>".'Informasi/Permasalahan'."</td>
                      <td>".'Lokasi MPP/GPP'."</td>
                      <td>".'Tujuan Kedatangan'."</td>
                      <td>".'Nama Petugas'."</td>
                      <td>".'Solusi'."</td>
                      <td>".'Keterangan'."</td>                    
                    </tr>";
                      echo "<table width='100%' border='0' font-size:16px;'>";
                       echo "</table>";
             echo "<table width='100%' cellspacing='0' cellpadding='0' border='1' style='border-style:solid; border-width:thin;font-size:10px;'>";
             echo $jdl; 

            $i=1;
            foreach ($list_tamu as $row){
                  $isi = "<tr>
                        <td>".$i."</td>                        
                        <td>".$row->waktu."</td>
                        <td>".$row->nama."</td>
                           <td>=\"$row->nik\"</td>
                        <td>".$row->email."</td>
                        <td>=\"$row->telepon\"</td>
                        <td>".$this->m_bukutamu->get_n_sektor($row->bidang)."</td>
                        <td>".$row->jenis_izin."</td>
                        <td>".$row->esselon."</td>
                        <td>".$row->instansi."</td>
                        <td>=\"$row->nib\"</td>
                        <td>".$row->keperluan."</td>
                        <td>".$this->m_bukutamu->get_n_mpp($row->lokasi)."</td>
                        <td>".$this->m_bukutamu->get_tujuan($row->tujuan)."</td>
                        <td>".$this->m_bukutamu->get_n_user($row->nama_petugas)."</td>
                        <td>".$row->solusi."</td>
                        <td>".$row->Keterangan."</td>

                  </tr>";
            echo $isi; 
             $i++;
          }

             echo "</table>";
    }

  //   public function add() {
  //     $data['kegiatan'] = array();
  //     $data['namabidang'] = $this->m_timeline->get_namabidang();
  //     $data['step'] = "simpan";
     
  //     $js =  "
  //             $(document).ready(function() {
  //                 $(\"#tabs\").tabs();
  //                 $('.monbulan').datepicker({
  //                     changeMonth: true,
  //                     changeYear: true,
  //                     dateFormat: 'yy-mm-dd',
  //                     closeText: 'X'
  //                 });
  //                 $('#form').validate();
  //                 $('.pilihan').select2();
  //             });
      
  //             function finishAjax(id, response){
  //                 $('#'+id).html(unescape(response));
  //                 $('#'+id).fadeIn();
  //             }
  //         ";
    
  //     $this->template->set_metadata_javascript($js);
  //     $this->load->vars($data);
  //     $this->session_info['page_name'] = "Tambah Data Kegiatan";
  //     $this->template->build('timeline_edit', $this->session_info);
  //   }

    public function ubah($id) {
  	  $data['bukutamu'] = $this->m_bukutamu->get_bukutamu($id);
     // var_dump($id);die();
      $data['step'] = "update";
 $data['list2'] = $this->m_bukutamu->get_sektor2();
 $data['namampp'] = $this->m_bukutamu->get_namampp();
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
      $this->session_info['page_name'] = "Ubah Data Buku Tamu / E-Report";
      $this->template->build('bukutamu_edit', $this->session_info);
  }

  public function update() {
      $id   = $this->input->post('id');
      $nama     = $this->input->post('nama');
      $email     = $this->input->post('email');
      $instansi     = $this->input->post('instansi');
      $keperluan     = $this->input->post('keperluan');
      //$waktu     = $this->input->post('waktu');
      $esselon     = $this->input->post('esselon');
      $lokasi     = $this->input->post('namampp');
      $bidang     = $this->input->post('list2');
      $solusi     = $this->input->post('solusi');
    //  
      $telepon     = $this->input->post('telepon');
      $Keterangan     = $this->input->post('Keterangan');
      $nama_petugas     = $this->session->userdata('id_auth');
      $jenis_izin     = $this->input->post('jenis_izin');
      $nib     = $this->input->post('nib');
      $tujuan     = $this->input->post('tujuan');



      $simpan = $this->m_bukutamu->update_data($id, $nama,   $email,   $instansi,   $keperluan,      $esselon,   $lokasi,   $bidang,   $solusi,   $telepon, $nib, $jenis_izin, $nama_petugas, $Keterangan, $tujuan);

      $file = $_FILES["file_evidence"]["name"];
        $file_name = basename($_FILES["file_evidence"]["name"]);
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        
        $target_dir = "assets/assets/calen/ereport/";
        $target_file = $target_dir . $file_name;

        $fileBaru = $target_dir.'evidence_'.$id.'.'.$ext;

        $upload = move_uploaded_file($_FILES["file_evidence"]["tmp_name"], $target_file);

        if($upload) {
          $rnm = rename($target_file, $fileBaru);
           $this->session->set_flashdata('sukses', "Berhasil Menyimpan Data & Mengupload Dokumen .");
            redirect('bukutamu');
          }
          else {
          $this->session->set_flashdata('gagal', "Berhasil Menyimpan Data dan tidak merubah File Dokumen.");
          redirect('bukutamu');
        }
    
  }

  // public function simpan() {
  //    // $id_user = $this->session->userdata('id_auth');
  //     $title     = $this->input->post('title');
  //     $description= $this->input->post('description');
  //     $namabidang    = $this->input->post('namabidang');
  //     $start_date= $this->input->post('start_date');
  //      $startdate= $this->input->post('startdate');
  //     $end_date  = $this->input->post('end_date');
  //     $id        = $this->input->post('id');
  //       $iduser = $this->session->userdata('username');

  //     $simpan = $this->m_timeline->save_data($id, $iduser, $title, $description, $bidang,$namabidang, $start_date, $end_date, $startdate);
  //     if ($simpan != 0) {
  //       $id = $simpan;
  //       $this->session->set_flashdata('sukses', "Berhasil Menyimpan Data");
  //       redirect('/timeline');            
  //     } else {
  //       $this->session->set_flashdata('gagal', "Gagal Meyimpan Data Surat.");
  //       redirect('/timeline');
  //     }
  // }
  public function hapus_evidence($id) {
    $files_image = "";
    foreach(glob('assets/assets/calen/ereport/evidence_'.$id.'.*', GLOB_NOSORT) as $image){  
                  //echo "Filename: " . $image . "<br />";      
                  $files_image = $image ; 
              }  
             // var_dump($files_image);die();
    $hapus = unlink($files_image);

   // $hapus = unlink('assets/assets/calen/ereport/evidence_'.$id.'.pdf');
    //$hapus2 = unlink('assets/docx-surat-processed/SRT_'.$id.'.docx');

    if ($hapus) {
      $this->session->set_flashdata('sukses', "Berhasil Menghapus Berkas.");
      redirect('bukutamu/ubah/'.$id);
    } else {
      $this->session->set_flashdata('gagal', "Gagal Menghapus Berkas.");
      redirect('bukutamu/ubah/'.$id);
    }
  }

  public function hapus($id) {
    if ($this->m_bukutamu->delete_bukutamu($id)) {
         $files_image = "";
    foreach(glob('assets/assets/calen/ereport/evidence_'.$id.'.*', GLOB_NOSORT) as $image){  
                  //echo "Filename: " . $image . "<br />";      
                  $files_image = $image ; 
              }  
             // var_dump($files_image);die();
    $hapus = unlink($files_image);
      $this->session->set_flashdata('sukses', "Berhasil Hapus Data.");
        redirect('bukutamu');
    } else {
      $this->session->set_flashdata('gagal', "Gagal Hapus Data.");
        redirect('bukutamu');
    }
  }

}