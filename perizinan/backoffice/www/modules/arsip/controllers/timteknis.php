<?php

/**
 * Description of Info Izin diterbitkan untuk Tim Teknis SK
 * Update  : PBS, 27 Juli 2020
 */

class TimTeknis extends WRC_AdminCont {

  public function __construct() {
    parent::__construct();
    $this->load->library('dompdf_gen');
    
    $enabled = FALSE;
    $list_auths = $this->session_info['app_list_auth'];
    $this->All = FALSE;
    $this->tembusan_arsip_ins_lain = FALSE;
    $this->mencetak = FALSE;
    //if($this->session->userdata('username') == 'budi') $enabled = TRUE;   // Hanya utk test awal
    foreach ($list_auths as $list_auth) {
      if($list_auth->id_role === '12' || $list_auth->id_role === '21' || $list_auth->id_role === '7') {   // (12)timteknis or (21)Pengarsipan or (7)tembusan arsip instansi lain
        $enabled = TRUE;
      }
      if($list_auth->id_role === '20') { //Mencetak
        $this->mencetak = TRUE;
      }
      if($list_auth->id_role === '18') { //Administrator
        $this->All = TRUE;
      }
      if($list_auth->id_role === '7') {  //Tembusa Arsip lain
        $this->tembusan_arsip_ins_lain = TRUE;
      }
    }
    
    $this->kab = '';
    $sql  = "select tmpegawai.val_kab from tmpegawai INNER JOIN tmpegawai_user ON tmpegawai.id = tmpegawai_user.tmpegawai_id WHERE tmpegawai_user.user_id = ?";
    $a    = $this->db->query($sql, array($this->session->userdata('id_auth')))->first_row();
    if(!empty($a)) { $this->kab = $a->val_kab; }
    
    if(!$enabled) {
      redirect('dashboard');
    }
  }
  
  public function index() {
    $no_daftar = $this->input->post('kt_cari');
    $tgla = $this->input->post('tgla');
    $tglb = $this->input->post('tglb');
    $now = $this->lib_date->get_date_now();
    $tgl_before = $this->lib_date->set_date($now, -40);
    $tgl_now = $this->lib_date->set_date($now, 0);

    if($tgla && $tglb){
      $data['tgla'] = $tgla;
      $data['tglb'] = $tglb;
    }else{
      $tgla = $tgl_before;
      $tglb = $tgl_now;
      $data['tgla'] = $tgla;
      $data['tglb'] = $tglb;
    }
    
    $username = new user();
    $username->where('username', $this->session->userdata('username'))->get();
    $this->lib_date->post_variable($username->id, $tgla, $tglb, '', '', '', '', '', '', '', '');   // post variable
    if($this->All){
      $query = "SELECT A.id, A.pendaftaran_id, A.d_terima_berkas, A.c_status_bayar, A.d_perubahan, A.d_perpanjangan, 
                       A.d_daftarulang, A.kd_gerai, A.approve, A.a_izin, A.status_berkas, O.trkelurahan_id,
                       C.indeks, C.id idizin, C.n_perizinan, C.c_keputusan, C.template_gub, C.template, C.e_ttd, 
                       C.e_sertifikat, E.n_pemohon, G.id idjenis, K.tgl_penetapan, K.tgl_surat, K.no_surat, K.c_cetak,
                       K.no_surat_edit, K.tgl_surat_edit, M.trkelompok_perizinan_id
                FROM tmpermohonan as A
                INNER JOIN tmpermohonan_trperizinan as B ON B.tmpermohonan_id = A.id
                INNER JOIN trperizinan as C ON B.trperizinan_id = C.id
                INNER JOIN tmpemohon_tmpermohonan as D ON D.tmpermohonan_id = A.id
                INNER JOIN tmpemohon as E ON D.tmpemohon_id = E.id
                INNER JOIN tmpermohonan_trjenis_permohonan as F ON F.tmpermohonan_id = A.id
                INNER JOIN trjenis_permohonan as G ON F.trjenis_permohonan_id = G.id
                INNER JOIN tmbap_tmpermohonan H ON A.id = H.tmpermohonan_id
                INNER JOIN tmbap I ON H.tmbap_id = I.id
                INNER JOIN tmpermohonan_tmsk J ON A.id = J.tmpermohonan_id
                INNER JOIN tmsk K ON J.tmsk_id = K.id
                INNER JOIN trkelompok_perizinan_trperizinan AS M ON M.trperizinan_id = C.id
                LEFT JOIN tmpermohonan_ky AS N ON A.id = N.tmpermohonan_id
                LEFT JOIN tmpemohon_portal AS O ON A.id_pemohon_portal = O.id
                WHERE A.c_pendaftaran = 1
                AND A.c_izin_dicabut = 0
                AND A.c_izin_selesai = 0
                AND A.approve = 2";
    }else{
      $query = "SELECT A.id, A.pendaftaran_id, A.d_terima_berkas, A.c_status_bayar, A.d_perubahan, A.d_perpanjangan, 
                       A.d_daftarulang, A.kd_gerai, A.approve, A.a_izin, A.status_berkas, O.trkelurahan_id,
                       C.indeks, C.id idizin, C.n_perizinan, C.c_keputusan, C.template_gub, C.template, C.e_ttd, 
                       C.e_sertifikat, E.n_pemohon, G.id idjenis, K.tgl_penetapan, K.tgl_surat, K.no_surat, K.c_cetak,
                       K.no_surat_edit, K.tgl_surat_edit, M.trkelompok_perizinan_id
                FROM tmpermohonan as A
                INNER JOIN tmpermohonan_trperizinan as B ON B.tmpermohonan_id = A.id
                INNER JOIN trperizinan as C ON B.trperizinan_id = C.id
                INNER JOIN tmpemohon_tmpermohonan as D ON D.tmpermohonan_id = A.id
                INNER JOIN tmpemohon as E ON D.tmpemohon_id = E.id
                INNER JOIN tmpermohonan_trjenis_permohonan as F ON F.tmpermohonan_id = A.id
                INNER JOIN trjenis_permohonan as G ON F.trjenis_permohonan_id = G.id
                INNER JOIN tmbap_tmpermohonan H ON A.id = H.tmpermohonan_id
                INNER JOIN tmbap I ON H.tmbap_id = I.id
                INNER JOIN tmpermohonan_tmsk J ON A.id = J.tmpermohonan_id
                INNER JOIN tmsk K ON J.tmsk_id = K.id
                INNER JOIN trperizinan_user AS L ON  L.trperizinan_id = C.id
                INNER JOIN trkelompok_perizinan_trperizinan AS M ON M.trperizinan_id = C.id
                LEFT JOIN tmpermohonan_ky AS N ON A.id = N.tmpermohonan_id
                LEFT JOIN tmpemohon_portal AS O ON A.id_pemohon_portal = O.id
                WHERE A.c_pendaftaran = 1
                AND A.c_izin_dicabut = 0
                AND A.c_izin_selesai = 0
                AND A.approve = 2
                AND L.user_id = '".$username->id."'";
    }
    if(!empty($no_daftar)) {
      $query .= " AND I.status_bap = 1 AND A.pendaftaran_id LIKE '%$no_daftar%' order by A.id DESC";
    }else{
      $query .= " AND A.d_terima_berkas between '$tgla' and '$tglb'  AND I.status_bap = 1 order by A.id DESC";
    }
    // var_dump($query);die();

    $data['list'] = $query; 
    $data['c_bap'] = "1";
    $data['level'] = "0";
    $data['kt_cari'] = $no_daftar;
    $data['tembusan_arsip_ins_lain'] = $this->tembusan_arsip_ins_lain;
    $data['mencetak'] = $this->mencetak;
    
    $this->load->vars($data);
    
    $js = "$(document).ready(function() {
             $( '#notif' ).click(function() {
               $('#pageloader').fadeIn();
             });

             oTable = $('#sk').dataTable({
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
           });
          ";
    $this->template->set_metadata_javascript($js);
    $this->session_info['page_name'] = "Arsip dan Data Perizinan";
    $this->template->build('arsip_opd_list', $this->session_info);
  }

  public function cetak_excel_2($tgla, $tglb) {
    $no_daftar = $this->input->post('kt_cari');
    if(!empty($tgla && $tglb)){

    }else{
    $tgla = $this->input->post('tgla');
    $tglb = $this->input->post('tglb');
  }
    $now = $this->lib_date->get_date_now();
    $tgl_before = $this->lib_date->set_date($now, -40);
    $tgl_now = $this->lib_date->set_date($now, 0);

    if($tgla && $tglb){
      $data['tgla'] = $tgla;
      $data['tglb'] = $tglb;
    }else{
      $tgla = $tgl_before;
      $tglb = $tgl_now;
      $data['tgla'] = $tgla;
      $data['tglb'] = $tglb;
    }
    
    $username = new user();
    $username->where('username', $this->session->userdata('username'))->get();
    $this->lib_date->post_variable($username->id, $tgla, $tglb, '', '', '', '', '', '', '', '');   // post variable
    if($this->All){
      $query = "SELECT A.id, A.pendaftaran_id, A.d_terima_berkas, A.c_status_bayar, A.d_perubahan, A.d_perpanjangan, 
                       A.d_daftarulang, A.kd_gerai, A.approve, A.a_izin, A.status_berkas, O.trkelurahan_id,
                       C.indeks, C.id idizin, C.n_perizinan, C.c_keputusan, C.template_gub, C.template, C.e_ttd, 
                       C.e_sertifikat, E.n_pemohon, G.id idjenis, K.tgl_penetapan, K.tgl_surat, K.no_surat, K.c_cetak,
                       K.no_surat_edit, K.tgl_surat_edit, M.trkelompok_perizinan_id
                FROM tmpermohonan as A
                INNER JOIN tmpermohonan_trperizinan as B ON B.tmpermohonan_id = A.id
                INNER JOIN trperizinan as C ON B.trperizinan_id = C.id
                INNER JOIN tmpemohon_tmpermohonan as D ON D.tmpermohonan_id = A.id
                INNER JOIN tmpemohon as E ON D.tmpemohon_id = E.id
                INNER JOIN tmpermohonan_trjenis_permohonan as F ON F.tmpermohonan_id = A.id
                INNER JOIN trjenis_permohonan as G ON F.trjenis_permohonan_id = G.id
                INNER JOIN tmbap_tmpermohonan H ON A.id = H.tmpermohonan_id
                INNER JOIN tmbap I ON H.tmbap_id = I.id
                INNER JOIN tmpermohonan_tmsk J ON A.id = J.tmpermohonan_id
                INNER JOIN tmsk K ON J.tmsk_id = K.id
                INNER JOIN trkelompok_perizinan_trperizinan AS M ON M.trperizinan_id = C.id
                LEFT JOIN tmpermohonan_ky AS N ON A.id = N.tmpermohonan_id
                LEFT JOIN tmpemohon_portal AS O ON A.id_pemohon_portal = O.id
                WHERE A.c_pendaftaran = 1
                AND A.c_izin_dicabut = 0
                AND A.c_izin_selesai = 0
                AND A.approve = 2";
    }else{
      $query = "SELECT A.id, A.pendaftaran_id, A.d_terima_berkas, A.c_status_bayar, A.d_perubahan, A.d_perpanjangan, 
                       A.d_daftarulang, A.kd_gerai, A.approve, A.a_izin, A.status_berkas, O.trkelurahan_id,
                       C.indeks, C.id idizin, C.n_perizinan, C.c_keputusan, C.template_gub, C.template, C.e_ttd, 
                       C.e_sertifikat, E.n_pemohon, G.id idjenis, K.tgl_penetapan, K.tgl_surat, K.no_surat, K.c_cetak,
                       K.no_surat_edit, K.tgl_surat_edit, M.trkelompok_perizinan_id
                FROM tmpermohonan as A
                INNER JOIN tmpermohonan_trperizinan as B ON B.tmpermohonan_id = A.id
                INNER JOIN trperizinan as C ON B.trperizinan_id = C.id
                INNER JOIN tmpemohon_tmpermohonan as D ON D.tmpermohonan_id = A.id
                INNER JOIN tmpemohon as E ON D.tmpemohon_id = E.id
                INNER JOIN tmpermohonan_trjenis_permohonan as F ON F.tmpermohonan_id = A.id
                INNER JOIN trjenis_permohonan as G ON F.trjenis_permohonan_id = G.id
                INNER JOIN tmbap_tmpermohonan H ON A.id = H.tmpermohonan_id
                INNER JOIN tmbap I ON H.tmbap_id = I.id
                INNER JOIN tmpermohonan_tmsk J ON A.id = J.tmpermohonan_id
                INNER JOIN tmsk K ON J.tmsk_id = K.id
                INNER JOIN trperizinan_user AS L ON  L.trperizinan_id = C.id
                INNER JOIN trkelompok_perizinan_trperizinan AS M ON M.trperizinan_id = C.id
                LEFT JOIN tmpermohonan_ky AS N ON A.id = N.tmpermohonan_id
                LEFT JOIN tmpemohon_portal AS O ON A.id_pemohon_portal = O.id
                WHERE A.c_pendaftaran = 1
                AND A.c_izin_dicabut = 0
                AND A.c_izin_selesai = 0
                AND A.approve = 2
                AND L.user_id = '".$username->id."'";
    }
    if(!empty($no_daftar)) {
      $query .= " AND I.status_bap = 1 AND A.pendaftaran_id LIKE '%$no_daftar%' order by A.id DESC";
    }else{
      $query .= " AND A.d_terima_berkas between '$tgla' and '$tglb'  AND I.status_bap = 1 order by A.id DESC";
    }
    $data['list'] = $query; 
    $data['c_bap'] = "1";
    $data['level'] = "1";
    $data['kt_cari'] = $no_daftar;
    $data['tembusan_arsip_ins_lain'] = $this->tembusan_arsip_ins_lain;
    $data['mencetak'] = $this->mencetak;
    
    $this->load->vars($data);
    
    $js = "$(document).ready(function() {
             $( '#notif' ).click(function() {
               $('#pageloader').fadeIn();
             });

             oTable = $('#sk').dataTable({
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
           });
          ";
    $this->template->set_metadata_javascript($js);
    $this->session_info['page_name'] = "Arsip dan Data Perizinan";
    $this->template->build('cetak_excel_list', $this->session_info);
  }
  
  public function cetak($id_daftar=NULL, $jenis=NULL) {
  	$permohonan = new tmpermohonan();
  	$permohonan->get_by_id($id_daftar);
  	$nodaftar = $permohonan->pendaftaran_id;
  	$lok_esign = 'assets/esignfile/';
  	$lok_nonSE = 'assets/skpdf/';
    $this->load->helper('download');
    $fileSK = str_replace(' ', '','SK_'.$nodaftar);
    $fileKP = str_replace(' ', '','KP_'.$nodaftar);
    switch($jenis) {
		  case 'se':   // SK/izin(SE)
        if(file_exists($lok_esign.$fileSK.'.pdf')){             // cek PDF SK atau Izin yang sudah SE
          $data = file_get_contents($lok_esign.$fileSK.'.pdf');
          force_download($fileSK.'.pdf', $data);
        }
        break;
      case 'sn':   // SK/izin(NonSE)
        if(file_exists($lok_nonSE.$fileSK.'.pdf')){             // cek PDF SK atau Izin yang non SE
          $data = file_get_contents($lok_nonSE.$fileSK.'.pdf');
          force_download($fileSK.'.pdf', $data);
        }
        break;
      case 'ke':   // KP(SE)
        if(file_exists($lok_esign.$fileKP.'.pdf')){             // cek PDF KP yang sudah SE
          $data = file_get_contents($lok_esign.$fileKP.'.pdf');
          force_download($fileKP.'.pdf', $data);
        }  
        break;
      case 'kn':   // KP(NonSE)
        if(file_exists($lok_nonSE.$fileKP.'.pdf')){             // cek PDF KP yang non SE
          $data = file_get_contents($lok_nonSE.$fileKP.'.pdf');
          force_download($fileKP.'.pdf', $data);
        }
        break;  
    }
  }

  public function cetak_excel($id = null) {  // Cetak per izin
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=dataxl.xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    
    $permohonan = new tmpermohonan();
    $data_pendaftaran = $permohonan->where("id = '$id'")->get();
    $permohonan_perizinan = new tmpermohonan_trperizinan();
    $dt_link = $permohonan_perizinan->where("tmpermohonan_id = '$id'")->get();
    $dt_link = $dt_link->trperizinan_id;
    $izin = new trperizinan();
    $izin->get_by_id($dt_link);
        
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
    for($i = 0; $i <= 100; $i++) {
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
    //echo "<tr>LAPORAN PERIZINAN : ".$n_izin."</tr>";
    //echo "<tr>PERIODE : ".$this->lib_date->mysql_to_human($tgla)." - ".$this->lib_date->mysql_to_human($tglb)."</tr>";
    //echo "<tr>ASAL PERMOHONAN : ".$ngerai."</tr>";
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
      foreach($no_field as $cek_syarat) {
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
