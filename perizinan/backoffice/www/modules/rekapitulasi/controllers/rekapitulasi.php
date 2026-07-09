<?php
/* To change this template, choose Tools | Templates and open the template in the editor. 
 * Description of Rekapitulasi
 * @author PBS
 */

class Rekapitulasi extends WRC_AdminCont {

  public function __construct() {
    parent::__construct();
    $this->permohonan = new tmpermohonan();
    $this->perizinan = new trperizinan();
    $this->status = new trstspermohonan();
    $this->sektor = new trsektor();
    
    $enabled = FALSE;
    $list_auths = $this->session_info['app_list_auth'];
    $this->rekapitulasi = NULL;
    
    foreach ($list_auths as $list_auth) {
      if($list_auth->id_role === '10') {
        $enabled = TRUE;
        $this->rekapitulasi = new user_auth();
      }
    }
    
    if(!$enabled) {
      redirect('dashboard');
    }
  }

  public function index() {
    $data['list'] = $this->perizinan->limit(0)->get();
    $mark = $this->input->post('mark');
    $list_state = $this->input->post('list_state');
    $data['mark'] = $mark;
    $data['list_state'] = $list_state;
    $js = "$(document).ready(function() {
             $(\"#tabs\").tabs();
             $('a[rel*=rekapitulasi_box]').facebox();
             $('a[rel*=realisasi_box]').facebox();
           } );
           $(document).ready(function() {
             oTable = $('#rekapitulasi').dataTable({
               \"bJQueryUI\": true,
               \"sPaginationType\": \"full_numbers\"
             });
           } );
           $(function() {
             $(\".monbulan\").datepicker({
               changeMonth: true,
               changeYear: true,
               dateFormat: 'yy-mm-dd',
               closeText: 'X'
             });
           });
          ";
    $this->load->vars($data);
    $this->template->set_metadata_javascript($js);
    $this->session_info['page_name'] = "Daftar Rekap PendaftaranX";
    $this->template->build('list', $this->session_info);
  }

  public function view() {
    $tgla = $this->input->post('tgla');
    $tglb = $this->input->post('tglb');
	  $list_state = $this->input->post('list_state');
    $now = $this->lib_date->get_date_now();
    $tgl_before = date("Y-m-d", mktime(0, 0, 0, date("m"), 1, date("Y")));
    $tgl_after = date("Y-m-d", mktime(0, 0, 0, date("m")+1, 0, date("Y")));
    
    if($tgla && $tglb) {
      $data['tgla'] = $tgla;
      $data['tglb'] = $tglb;
    }else{
      $tgla = $tgl_before;
      $tglb = $tgl_after;
      $data['tgla'] = $tgla;
      $data['tglb'] = $tglb;
    }
    
    $data['list_state'] = $list_state;
	  $username = new user();
    $username->where('username', $this->session->userdata('username'))->get();
	  $data['lokasi'] = $username->lokasi;
	  $data['cek_sektor'] = $username->sektor;
	  $this->lib_date->post_variable($username->id, $tgla, $tglb, $list_state, '', '', '', '', '', '', '');   // post variable
    $this->load->vars($data);
    $js =  "$(document).ready(function() {
	            $(\"#tabs\").tabs();
	            $('a[rel*=rekapitulasi_box]').facebox();
              $('a[rel*=realisasi_box]').facebox();
              oTable = $('#realisasi').dataTable({
                \"bJQueryUI\": true,
                \"sPaginationType\": \"full_numbers\"
              });
            });
           ";
    $this->template->set_metadata_javascript($js);
    $this->session_info['page_name'] = "Daftar Rekap Pendaftaran";
    $this->template->build('view_rekapitulasi', $this->session_info);
  }

  public function view_next() {
    $username = new user();
    $username->where('username', $this->session->userdata('username'))->get();
    $tgla = $username->gvar1;
    $tglb = $username->gvar2;
    $gerai = $username->gvar3;
    $data['lokasi'] = $username->lokasi;
    $data['cek_sektor'] = $username->sektor;
    $data['tgla'] = $tgla;
    $data['tglb'] = $tglb;
    $data['list_state'] = $gerai;
    $this->load->vars($data);
    $js =  "$(document).ready(function() {
              $(\"#tabs\").tabs();
              $('a[rel*=rekapitulasi_box]').facebox();
              $('a[rel*=realisasi_box]').facebox();
              oTable = $('#realisasi').dataTable({
                \"bJQueryUI\": true,
                \"sPaginationType\": \"full_numbers\"
              });
            });
           ";
    $this->template->set_metadata_javascript($js);
    $this->session_info['page_name'] = "Daftar Rekap Pendaftaran";
    $this->template->build('view_rekapitulasi', $this->session_info);
  }

  public function Detail($id = null) {
    $data['page_name'] = "Detail Daftar Rekap Pendaftaran";
    $data['list'] = $this->perizinan->where('id', $id)->get();
    $this->load->vars($data);
    $this->load->view('list_detail_load', $data);
  }

  public function DetailTahun($id = null) { // per Nama Ijin
    $username = new user();
    $username->where('username', $this->session->userdata('username'))->get();
    $tgla = $username->gvar1;
    $tglb = $username->gvar2;
    $gerai = $username->gvar3;
    $data['page_name'] = "Detail Daftar Rekap Pendaftaran";
    if($gerai === '0') {
      $this->permohonan->where_related("trstspermohonan", 'id <> 1')->where("d_terima_berkas between '$tgla' and '$tglb'")->get();
    }else{
      $this->permohonan->where_related("trstspermohonan", 'id <> 1')->where("kd_gerai = '$gerai'AND d_terima_berkas between '$tgla' and '$tglb'")->get();
    }
    $data['list'] = $this->perizinan->where('id',$id)->get();
    $data['tgla'] = $tgla;
    $data['tglb'] = $tglb;
    $data['izin_id'] = $id;
    $data['gerai'] = $gerai;
    $this->load->vars($data);
    $this->session_info['page_name'] = "Daftar Permohonan Perizinan";
    $this->template->build('detailtahun_load', $this->session_info);
  }

  public function DetailSektorTahun($id = null) {  // per Sektor Ijin
    $sektor = new trsektor();
    $sektor->get_by_id($id);
    $sektor = $sektor->n_sektor;
    $username = new user();
    $username->where('username', $this->session->userdata('username'))->get();
    $tgla = $username->gvar1;
    $tglb = $username->gvar2;
    $gerai = $username->gvar3;
    $data['page_name'] = "Detail Daftar Rekap Pendaftaran Per Bidang";
    if($gerai === '0') {
    	$this->permohonan->where_related("trstspermohonan", 'id <> 1')->where("trsektor_id = '$id' AND d_terima_berkas between '$tgla' and '$tglb'")->get();
    }else{
      $this->permohonan->where_related("trstspermohonan", 'id <> 1')->where("kd_gerai = '$gerai' AND trsektor_id = '$id' AND d_terima_berkas between '$tgla' and '$tglb'")->get();
    }
    $data['list'] = $this->perizinan->where('id',$id)->get();
    $data['tgla'] = $tgla;
    $data['tglb'] = $tglb;
    $data['sektor_id'] = $id;
    $data['sektor'] = $sektor;
    $data['gerai'] = $gerai;
    $this->load->vars($data);
    $this->session_info['page_name'] = "Daftar Permohonan Perizinan";
    $this->template->build('detailsektortahun_load', $this->session_info);
  }

  public function cetak_excel($id = null) {  // Cetak per sektor
    $sektor = new trsektor();
    $sektor->get_by_id($id);
    $sektor = $sektor->n_sektor; 
    $username = new user();
    $username->where('username', $this->session->userdata('username'))->get();
    $tgla = $username->gvar1;
    $tglb = $username->gvar2;
    $gerai = $username->gvar3;
    $ngerai = $gerai;
    if($gerai === '0') $ngerai = 'SELURUHNYA';
    if($gerai === '0') {
      $data_pendaftaran = $this->permohonan->where_related("trstspermohonan", 'id <> 1')->where("trsektor_id = '$id' AND d_terima_berkas between '$tgla' and '$tglb'")->get();
    }else{
      $data_pendaftaran = $this->permohonan->where_related("trstspermohonan", 'id <> 1')->where("kd_gerai = '$gerai' AND trsektor_id = '$id' AND d_terima_berkas between '$tgla' and '$tglb'")->get();
    }
        
    $i=0;
    $jumlah = 0;
    $hal = 1;
    $gt_hal = TRUE;
    foreach ($data_pendaftaran as $row){
      $jumlah++;
      if($gt_hal) {
        $gt_hal = FALSE;
        $file = 'datax'.$hal.'.xls';
        $hal++;
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=".$file);
        header("Pragma: no-cache");
        header("Expires: 0");
        echo "<table width='100%' border='0' font-size:16px;'>";
        echo "<tr>LAPORAN PERIZINAN BIDANG : ".$sektor."</tr>";
        echo "<tr>PERIODE : ".$this->lib_date->mysql_to_human($tgla)." - ".$this->lib_date->mysql_to_human($tglb)."</tr>";
        echo "<tr>ASAL PERMOHONAN : ".$ngerai."</tr>";
        echo "</table>";
        echo "<table width='100%' cellspacing='0' cellpadding='0' border='1' style='border-style:solid; border-width:thin;font-size:10px;'>";
        echo "<tr>
                <td>".'NOMOR'."</td>
                <td>".'NOMOR PENDAFTARAN'."</td>
                <td>".'ASAL PERMOHONAN'."</td>
                <td>".'TANGGAL DAFTAR'."</td>
                <td>".'JAM DAFTAR'."</td>
                <td>".'NAMA PEMOHON'."</td>
                <td>".'TELPON PEMOHON'."</td>
                <td>".'ALAMAT PEMOHON'."</td>
                <td>".'PROVINSI'."</td>
                <td>".'KABUPATEN/KOTA'."</td>
                <td>".'KECAMATAN'."</td>
                <td>".'DESA/KELURAHAN'."</td>
                <td>".'NAMA PERUSAHAAN'."</td>
                <td>".'NAMA PIMPINAN'."</td>
                <td>".'ALAMAT PERUSAHAAN'."</td>
                
                <td>".'PERMOHONAN IZIN'."</td>
                <td>".'KODE IZIN'."</td>
                <td>".'STATUS BERKAS'."</td>
                <td>".'TANGGAL SELESAI'."</td>
                <td>".'DURASI'."</td>
                <td>".'NOMOR SURAT'."</td>
                <td>".'OBJEK IZIN'."</td>
                <td>".'KETERANGAN'."</td>
                <td>".'KONTAK PERSON'."</td>
              </tr>";
      }
      
      $row->tmpemohon->get();
      $row->trstspermohonan->get();
      $row->tmperusahaan->get();
      $row->trperizinan->get();
      $row->tmsk->get();
      $row->tmpemohon->trkelurahan->get();
      $row->tmpemohon->trkelurahan->trkecamatan->get();
      $row->tmpemohon->trkelurahan->trkecamatan->trkabupaten->get();
      $row->tmpemohon->trkelurahan->trkecamatan->trkabupaten->trpropinsi->get();
      
      if($row->status_berkas == "proses")
        $n_status = $row->trstspermohonan->n_sts_permohonan;
      else
        $n_status = $row->status_berkas;
            
      $tgl_selesai = $row->tmsk->tgl_surat_edit;
      $no_surat = $row->tmsk->no_surat_edit;
      if($no_surat == '') {
        $tgl_selesai = $row->tmsk->tgl_surat;
        $no_surat = $row->tmsk->no_surat;
      }
            
      if($tgl_selesai == '') {
        $durasi = '-';
      }else{
        $durasi = $this->lib_date->lama_durasi($row->d_terima_berkas, $tgl_selesai);
      }
      
      $i++;
      $jumlah++;
      echo "<tr>
              <td>".$i."</td>
              <td>'".$row->pendaftaran_id."</td>
              <td>".$row->kd_gerai."</td>
              <td>".$row->d_terima_berkas."</td>
              <td>".substr($row->d_entry,11,8)."</td>
              <td>".$row->tmpemohon->n_pemohon."</td>
              <td>".$row->tmpemohon->telp_pemohon."</td>
              <td>".$row->tmpemohon->a_pemohon."</td>
              <td>".$row->tmpemohon->trkelurahan->trkecamatan->trkabupaten->trpropinsi->n_propinsi."</td>
              <td>".$row->tmpemohon->trkelurahan->trkecamatan->trkabupaten->n_kabupaten."</td>
              <td>".$row->tmpemohon->trkelurahan->trkecamatan->n_kecamatan."</td>
              <td>".$row->tmpemohon->trkelurahan->n_kelurahan."</td>
              <td>".$row->tmperusahaan->n_perusahaan."</td>
              <td>".$row->tmperusahaan->nama_pimpinan."</td>
              <td>".$row->tmperusahaan->a_perusahaan."</td>
              
              <td>".$row->trperizinan->n_perizinan."</td>
              <td>".$row->trperizinan->kd_izin."</td>
              <td>".$n_status."</td>
              <td>".$tgl_selesai."</td>
              <td>".$durasi."</td>
              <td>".$no_surat."</td>
              <td>".$row->a_izin."</td>
              <td>".$row->keterangan."</td>
              <td>".$row->kontak_person."</td>
            </tr>";
      //diperlukan jika ingin memecah per halaman 
      //if($jumlah == 50) {
      //	$gt_hal = TRUE;
      //	$jumlah = 0;
      //  echo "</table>"; 
      //}
    }
    echo "</table>";
  }

  public function cetak_excel_perizin($id = null) {  // Cetak per izin
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=dataxl.xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    $izin = new trperizinan();
    $izin->get_by_id($id);
    $n_izin = $izin->n_perizinan;
    $username = new user();
    $username->where('username', $this->session->userdata('username'))->get();
    $tgla = $username->gvar1;
    $tglb = $username->gvar2;
    $gerai = $username->gvar3;
    $ngerai = $gerai;
    if($gerai === '0') $ngerai = 'SELURUHNYA';
    if($gerai === '0') {
      $data_pendaftaran = $this->permohonan->where_related("trstspermohonan", 'id <> 1')->where("d_terima_berkas between '$tgla' and '$tglb'")->where_related($izin)->get();
    }else{
      $data_pendaftaran = $this->permohonan->where_related("trstspermohonan", 'id <> 1')->where("kd_gerai = '$gerai' AND d_terima_berkas between '$tgla' and '$tglb'")->where_related($izin)->get();
    }
        
    $jdl = "<tr>
              <td>".'NOMOR'."</td>
              <td>".'NOMOR PENDAFTARAN'."</td>
              <td>".'ASAL PERMOHONAN'."</td>
              <td>".'TANGGAL DAFTAR'."</td>
              <td>".'JAM DAFTAR'."</td>
              <td>".'NAMA PEMOHON'."</td>
              <td>".'TELPON PEMOHON'."</td>
              <td>".'ALAMAT PEMOHON'."</td>
              <td>".'PROVINSI'."</td>
              <td>".'KABUPATEN/KOTA'."</td>
              <td>".'KECAMATAN'."</td>
              <td>".'DESA/KELURAHAN'."</td>
              <td>".'NAMA PERUSAHAAN'."</td>
              <td>".'NAMA PIMPINAN'."</td>
              <td>".'ALAMAT PERUSAHAAN'."</td>
              
              <td>".'PERMOHONAN IZIN'."</td>
              <td>".'KODE IZIN'."</td>
              <td>".'STATUS BERKAS'."</td>
              <td>".'TANGGAL SELESAI'."</td>
              <td>".'DURASI'."</td>
              <td>".'NOMOR SURAT'."</td>
              <td>".'OBJEK IZIN'."</td>
              <td>".'KETERANGAN'."</td>
              <td>".'KONTAK PERSON'."</td>";
              
    //Menambahkan judul property
    $hitproperty = 0;
    $no_field = array('');
    for ($i = 0; $i <= 100; $i++) {
      $var = "var_teknis".$i;
      if($izin->$var <> '' ){
        $aktif = $this->lib_date->array_property('11',$izin->$var);      // Aktifasi Property
        if($aktif == 'Ya') {
          $hitproperty++;
          $nfield = $this->lib_date->array_property('0',$izin->$var);// ambil no Data Field property 
          if($hitproperty == 1) {
            $no_field = array($nfield);
          }else{
            $tempArray = array($nfield);
            $no_field = array_merge ($no_field, $tempArray);
          }
        	$njdl = $this->lib_date->array_property('1',$izin->$var);// ambil judul property 
          $jdl = $jdl."<td>".$njdl."</td>";
        }
      }
    }
    
    $jdl = $jdl . "</tr>";
    
    echo "<table width='100%' border='0' font-size:16px;'>";
    echo "<tr>LAPORAN PERIZINAN : ".$n_izin."</tr>";
    echo "<tr>PERIODE : ".$this->lib_date->mysql_to_human($tgla)." - ".$this->lib_date->mysql_to_human($tglb)."</tr>";
    echo "<tr>ASAL PERMOHONAN : ".$ngerai."</tr>";
    echo "</table>";
    echo "<table width='100%' cellspacing='0' cellpadding='0' border='1' style='border-style:solid; border-width:thin;font-size:10px;'>";
    echo $jdl; 
    
    $i=0;
    foreach ($data_pendaftaran as $row){
      $row->tmpemohon->get();
      $row->trstspermohonan->get();
      $row->tmperusahaan->get();
      $row->trperizinan->get();
      $row->tmsk->get();
      $row->tmpemohon->trkelurahan->get();
      $row->tmpemohon->trkelurahan->trkecamatan->get();
      $row->tmpemohon->trkelurahan->trkecamatan->trkabupaten->get();
      $row->tmpemohon->trkelurahan->trkecamatan->trkabupaten->trpropinsi->get();
      
      if($row->status_berkas == "proses")
        $n_status = $row->trstspermohonan->n_sts_permohonan;
      else
        $n_status = $row->status_berkas;
            
      $tgl_selesai = $row->tmsk->tgl_surat_edit;
      $no_surat = $row->tmsk->no_surat_edit;
      if($no_surat === '') {
        $tgl_selesai = $row->tmsk->tgl_surat;
        $no_surat = $row->tmsk->no_surat;
      }
      
      if($tgl_selesai == '') {
        $durasi = '-';
      }else{
        $durasi = $this->lib_date->lama_durasi($row->d_terima_berkas, $tgl_selesai);
      }
      
      $i++;
      $isi = "<tr>
                <td>".$i."</td>
                <td>'".$row->pendaftaran_id."</td>
                <td>".$row->kd_gerai."</td>
                <td>".$row->d_terima_berkas."</td>
                <td>".substr($row->d_entry,11,8)."</td>
                <td>".$row->tmpemohon->n_pemohon."</td>
                <td>".$row->tmpemohon->telp_pemohon."</td>
                <td>".$row->tmpemohon->a_pemohon."</td>
                <td>".$row->tmpemohon->trkelurahan->trkecamatan->trkabupaten->trpropinsi->n_propinsi."</td>
                <td>".$row->tmpemohon->trkelurahan->trkecamatan->trkabupaten->n_kabupaten."</td>
                <td>".$row->tmpemohon->trkelurahan->trkecamatan->n_kecamatan."</td>
                <td>".$row->tmpemohon->trkelurahan->n_kelurahan."</td>
                <td>".$row->tmperusahaan->n_perusahaan."</td>
                <td>".$row->tmperusahaan->nama_pimpinan."</td>
                <td>".$row->tmperusahaan->a_perusahaan."</td>
                
                <td>".$row->trperizinan->n_perizinan."</td>
                <td>".$row->trperizinan->kd_izin."</td>
                <td>".$n_status."</td>
                <td>".$tgl_selesai."</td>
                <td>".$durasi."</td>
                <td>".$no_surat."</td>
                <td>".$row->a_izin."</td>
                <td>".$row->keterangan."</td>
                <td>".$row->kontak_person."</td>";
      
      //Menambahkan judul property
      foreach ($no_field as $cek_syarat) {
        $var = "dt_teknis".$cek_syarat;
        $nisi = '-';
        if($row->$var <> '') {
          $nisi = $row->$var;    // ambil nilai data property
          $hitung = strlen($nisi);
          $cek_posisi = strpos($nisi,'^'); 
          $cekisi = substr($nisi,$cek_posisi+1,$hitung);
          if($cekisi == '' || $cekisi == '-') {
            $nisi = substr($nisi,0,$cek_posisi);
            if($nisi == '' || $nisi == '-') $nisi = '-';
          }else{
            $nisi = $cekisi;
          }
        }
        $isi = $isi."<td>".$nisi."</td>";
      }
      $isi = $isi . "</tr>";
      echo $isi;
    }
    echo "</table>";
  }
}