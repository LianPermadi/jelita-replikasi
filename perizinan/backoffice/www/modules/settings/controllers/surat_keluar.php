<?php

/** Description of Entry Data
 * @author PBS => 08 Des 2016
*/

class surat_keluar extends WRC_AdminCont {

  public function __construct() {
    parent::__construct();
    $this->sektor = new trsektor();
    $this->perizinan_user = new trperizinan_user();
    $this->load->model('dbmodel_akdp');
    $this->load->library('fpdf');
    
    $this->enabled = FALSE;
    $this->All = FALSE;
    $this->penghapusan = FALSE;
    $list_auths = $this->session_info['app_list_auth'];
    
    foreach ($list_auths as $list_auth) {
      if($list_auth->id_role === '29') {    // Administrasi Surat Keluar
        $this->enabled = TRUE;
      }
      if($list_auth->id_role === '18') {    // Administrator
        $this->All = TRUE;
      }
    }
  }

  public function index($tgla=NULL, $tglb=NULL) {
    $kd_filter = $this->input->post('kd_filter');
    $no_surat = $this->input->post('kt_cari');
    $username = new user();
    $username->where('username', $this->session->userdata('username'))->get();
    $lokasi_user = $this->session->userdata('lokasi');
    $group = $username->group;
    $izin_user = $this->perizinan_user->where("user_id",$username->id)->get();
    
    $now = $this->lib_date->get_date_now();
    if($kd_filter == ''){
      $tgla = $this->lib_date->set_date($now, 0); //-7
      $tglb = $this->lib_date->set_date($now, 0);
    }else{
      if($kd_filter == '1'){
        $tgla = $username->gvar1;
        $tglb = $username->gvar2;
      }else{
        $tgla = $this->input->post('tgla');
        $tglb = $this->input->post('tglb');
      }
    }
    $this->lib_date->post_variable($username->id, $tgla, $tglb, '', '', '', '', '', '', '', '');
    
    $data['group'] = $group;
    $data['kd_filter'] = $kd_filter;
    $data['tgla'] = $tgla;
    $data['tglb'] = $tglb;
    $time = strtotime($tgla.' 00:00:00'); $tgla = date('Y-m-d H:i:s',$time);
    $time = strtotime($tglb.' 23:59:59'); $tglb = date('Y-m-d H:i:s',$time);
    if($kd_filter != ''){
      if($kd_filter == '1'){
        $query_filter = " A.no_surat LIKE '%".$no_surat."%' ";
      }else{
        $query_filter = " A.tgl_surat between '$tgla' and '$tglb' ";
      }
    }else{
      $query_filter = " A.tgl_surat between '$tgla' and '$tglb' ";			
    }
    if($username->lokasi == 'OPD Teknis'){
    	$query_filter .= " AND A.approve =  3 ";
    }
    
    
    $data['kt_cari'] = $no_surat;
    $data['list'] = $this->main_sql($username->id,$query_filter,$tglb,$lokasi_user,$group); // = $query;
    $data['list_izin_user'] = $izin_user;
    $data['enabled'] = $this->enabled;
    $data['all_view'] = $this->All;
    $this->load->vars($data);
    
    $js =  "
            function confirm_link(text){
                if(confirm(text)){ return true;
                }else{ return false; }
            }
    
            $(document).ready(function() {
                    oTable = $('#pendataan').dataTable({
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
                $('#form').validate();
            });
            ";
    
    $this->template->set_metadata_javascript($js);
    if($username->lokasi == 'OPD Teknis')
      $this->session_info['page_name'] = "Surat Masuk ";
    else
      $this->session_info['page_name'] = "Administrasi Surat Keluar ";
    $this->template->build('suratkeluar_list', $this->session_info);
  }

  public function create() {
    $no_urut_pertek = 'XXXXX';
    $mark = $this->input->post('mark');
    $data['mark'] = $mark;
    $data['list_data'] = $this->sektor->order_by('urutan', 'ASC')->get();
    $data['save_method']     = 'save';
    $data['no_awal_pertek']  = 'xxx';
    $data['no_akhir_pertek'] = 'xxx';
    $data['id']              = "";
    $data['pemohon_id']      = "";
    $data['sk_id']           = "";
    $data['no_surat']        = $no_urut_pertek;
    $data['tg_surat']        = date('Y-m-d');
    $data['perihal']         = '';
    $data['kepada']          = '';
    $data['keterangan']      = '';
        
    $js_date = "
        $(document).ready(function(){
            $('#form').validate();
            $(\"#tabs\").tabs();
        });
        $(function() {
            $(\"#tg_surat\").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy-mm-dd',
                closeText: 'X'
            });
        });
        ";
    $this->template->set_metadata_javascript($js_date);
    $this->load->vars($data);
    $this->session_info['page_name'] = "Pesan Nomor Surat";
    $this->template->build('suratkeluar_edit', $this->session_info);
  }

  public function save() {
    $id_sektor = $this->input->post('list_sektor');
    $sektor = $this->sektor->where('id', $id_sektor)->get();
    $no_pertek_awal  = $this->sektor->no_pertek_awal;
    $no_pertek_akhir = $this->sektor->no_pertek_akhir;
    if($no_pertek_akhir == ''){
      echo 'Pesan Nomor Tidak Dapat Diproses'; die;
    }
    $username = new user();
    $username->where('username', $this->session->userdata('username'))->get();
    //simpan ke tabel year
    $year = new year();
    $year = $year->where('tahun', date('Y'))->get();
    if($year->tahun){ // ditemukan
      $no_urut_pertek = $year->no_urut_pertek + 1;
    }else{            // tidakditemukan
      $no_urut_pertek = 1;
      $year = new year();
      $year->tahun = $data_tahun;
    }
    $year->no_urut_pertek = $no_urut_pertek;
    $year->save();
    //EOF() simpan ke tabel year
    
    //simpan ke tabel tmsurat_keluar
    $time = strtotime($this->input->post('tg_surat').' '.date('H:i:s'));
    $newformat = date('Y-m-d H:i:s',$time);
    $surat_keluar = new tmsurat_keluar();
    $surat_keluar->tmpermohonan_id = $this->input->post('pemohon_id');
    $surat_keluar->tmsk_id         = $this->input->post('sk_id');
    $surat_keluar->user_id         = $username->id;
    $surat_keluar->no_pertek_awal  = $no_pertek_awal.' / ';
    $surat_keluar->no_surat        = $no_urut_pertek;
    $surat_keluar->no_pertek_akhir = ' / '.$no_pertek_akhir;
    $surat_keluar->tgl_surat       = $newformat;
    $surat_keluar->perihal         = $this->input->post('perihal');
    $surat_keluar->keterangan      = 'Booking Nomor';
    $surat_keluar->kepada          = $this->input->post('kepada');
    $surat_keluar->save();
    //EOF() simpan ke tabel tmsurat_keluar
    
    redirect('settings/surat_keluar');     
  }

  public function edit($surat_id = NULL) {
    $mark = $this->input->post('mark');
    $data['mark'] = $mark;
    $data['list_data'] = $this->sektor->order_by('urutan', 'ASC')->get();
    $surat_keluar = new tmsurat_keluar();
    $surat_keluar = $surat_keluar->where('id', $surat_id)->get();
    $data['save_method']     = 'update';
    $data['no_awal_pertek']  = $surat_keluar->no_pertek_awal;
    $data['no_akhir_pertek'] = $surat_keluar->no_pertek_akhir;
    $data['id']              = $surat_id;
    $data['pemohon_id']      = $surat_keluar->tmpermohonan_id;
    $data['sk_id']           = $surat_keluar->tmsk_id;
    $data['no_surat']        = $surat_keluar->no_surat;
    $data['tg_surat']        = $surat_keluar->tgl_surat;
    $data['perihal']         = $surat_keluar->perihal;
    $data['kepada']          = $surat_keluar->kepada;
    $data['keterangan']      = $surat_keluar->keterangan;
        
    $js_date = "
        $(document).ready(function(){
            $('#form').validate();
            $(\"#tabs\").tabs();
        });
        $(function() {
            $(\"#tg_surat\").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy-mm-dd',
                closeText: 'X'
            });
        });
        ";
    $this->template->set_metadata_javascript($js_date);
    $this->load->vars($data);
    $this->session_info['page_name'] = "Edit Nomor Surat";
    $this->template->build('suratkeluar_edit', $this->session_info);
  }

  public function update() {
    //simpan ke tabel tmsurat_keluar
    $surat_keluar = new tmsurat_keluar();
    $surat_keluar = $surat_keluar->where('id', $this->input->post('id'))->get();
    $surat_keluar->perihal = $this->input->post('perihal');
    $surat_keluar->kepada  = $this->input->post('kepada');
    $surat_keluar->save();
    //EOF() simpan ke tabel tmsurat_keluar
    redirect('settings/surat_keluar');     
  }

  public function print_kartu_kendali($id_kartu=NULL) {
    $surat_keluar = new tmsurat_keluar();
    $surat_keluar = $surat_keluar->where('id', $id_kartu)->get();
    $pemohon_id = $surat_keluar->tmpermohonan_id;
    $sk_id = $surat_keluar->tmsk_id;
    $user_id = $surat_keluar->user_id;
    $no_pertek_awal = substr($surat_keluar->no_pertek_awal,0,-2);
    $no_urut = $surat_keluar->no_surat;
    $tgl_surat = $surat_keluar->tgl_surat;
    $perihal = $surat_keluar->perihal;
    $ket = $surat_keluar->keterangan;
    $kepada = $surat_keluar->kepada;
    
    $username = new user();
    $username->where('id', $user_id)->get();
    
    $nama_surat = "cetak_kartukendali";
       
    //path of the template file
    $this->load->plugin('odf');
    $odf = new odf('assets/odt/' . $nama_surat . '.odt');
    
    $odf->setVars('indek', strtoupper(''));
    $odf->setVars('kode', strtoupper($no_pertek_awal));
    $odf->setVars('no_urut', strtoupper($no_urut));
    $odf->setVars('prihal', strtoupper($perihal));
    $odf->setVars('ringkasan', strtoupper(''));
    $odf->setVars('kepada', strtoupper($kepada));
    $odf->setVars('pengolah', strtoupper($username->oriname));
    $odf->setVars('tg_surat', $this->lib_date->mysql_to_human($tgl_surat));
    $odf->setVars('lampiran', strtoupper(''));
    $odf->setVars('catatan', strtoupper(''));
    
    //export the file
    $no_daftar = str_replace('/', '', $id_kartu);
    $odf->exportAsAttachedFile($nama_surat . '_' . $no_daftar . '.odt');
    
    //unlink('assets/barcode/' . $id_daftar . '.png');
  }

  public function main_sql($u_ser,$query_filter,$tglb,$lokasi_user,$group) {
    $query = "SELECT A.id, A.tmpermohonan_id, A.tmsk_id, A.user_id, A.no_pertek_awal,  A.no_surat,  A.no_pertek_akhir, A.tgl_surat, A.perihal, A.kepada,
              A.keterangan, A.approve FROM tmsurat_keluar as A WHERE ".$query_filter."order by A.tgl_surat DESC";
    return $query;
  }
}