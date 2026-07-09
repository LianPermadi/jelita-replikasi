<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/** Description of monitoring class
  * @author  Yogi Cahyana & zulfah  * @since   1988
  * @edit PBS 13-03-2015
*/
class Monitoring extends WRC_AdminCont {

  public function __construct() {
    parent::__construct();
    $this->username = new user();
    $this->monitoring_bi= new monitoring_bi();
    $this->pemohon = new tmpemohon();
    $this->permohonan = new tmpermohonan();
    $this->perizinan = new trperizinan();
    $this->propinsi = new trpropinsi();
    $this->kabupaten = new trkabupaten();
    $this->kecamatan = new trkecamatan();
    $this->kelurahan = new trkelurahan();
    $this->list_wilayah = new list_wilayah();
    $this->sektor = new trsektor();
    $this->load->model('dbmodel_akdp');
    $this->load->model('dbmodel_bisbesar');
    
    $enabled = FALSE;
    $this->All = TRUE;
    $this->admin = FALSE;
    $list_auths = $this->session_info['app_list_auth'];
    $this->monitoring = NULL;
    $this->username->where('username', $this->session->userdata('username'))->get();
    
    //$kat_cari Khusus Perhubungan
    $this->kat_cari = array('0' => 'NOMOR KENDARAAN',
                            '1' => 'NOMOR UJI',
                            '2' => 'NOMOR SK',
                            '3' => 'NOMOR KP',
                            '4' => 'NAMA PEMILIK',
                            '5' => 'NAMA PERUSAHAAN',
                            '6' => 'TANGGAL PENETAPAN SK',
                            '7' => 'TANGGAL PENETAPAN KP',
                            '8' => 'LINTASAN TRAYEK');
    //EOF() kat_cari Khusus Perhubungan
    
    if($this->username->lokasi == 'OPD Teknis') $this->All = FALSE;
    foreach($list_auths as $list_auth) {
      if($list_auth->id_role === '8') {
        $enabled = TRUE;
        $this->monitoring = new user_auth();
      }
      if($list_auth->id_role === '18') {
        $this->admin = TRUE;
      }
    }
    if(!$enabled) {
      redirect('dashboard');
    }
  }

	// Fungsi Monitoring Per Jenis Perizinan
  public function index() { 
    $username = new user();
    $username->where('username', $this->session->userdata('username'))->get();
    $kd_sektor = $username->sektor;
    $lokasi = $username->lokasi;
    
    $jenis_izin = $this->input->post('jenis_izin');
    $first_date = $this->input->post('first_date') == null ? $this->lib_date->set_date(date('Y-m-d'), -2) : $this->input->post('first_date');
    $second_date = $this->input->post('second_date') == null ? $this->lib_date->set_date(date('Y-m-d'), 0) : $this->input->post('second_date');
    
    $mark = $this->input->post('mark');
    $data['jumlah']=$this->monitoring_bi->get_total_perizinan($cari=NULL,$first_date, $second_date, $jenis_izin, $lokasi, $kd_sektor);
           
    $stspermohonan = new trstspermohonan();
    $data['submit'] = $this->input->post('submit');
    $data['jenis'] = $jenis_izin;
    $data['first'] = $first_date;
    $data['second'] = $second_date;
    $data['mark'] = $mark;
    //$data['list_ijin'] = $this->perizinan->order_by('id', 'ASC')->get();
    if($lokasi == 'OPD Teknis')
      $data['list_ijin'] = $this->perizinan->where_related("trsektor", 'id = '.$kd_sektor)->order_by('kd_izin', 'ASC')->get();
    else
      $data['list_ijin'] = $this->perizinan->order_by('kd_izin', 'ASC')->get();
    $this->load->vars($data);
    
    $js = "
           $(document).ready(function() {
             oTable= $('#monitoring').dataTable ({
               'bJQueryUI'      : true,
               'sPaginationType': 'full_numbers',
               'bServerSide'    : true,
               'bAutoWidth'     : false,
               'bSort'          : false,
               'sAjaxSource'    : '" . base_url() . "monitoring/datatables/list_Monitoring_Per_Perizinan',
               'aoColumns'      : [
                                    null,
                                    null,
                                    null,
                                    null,
                                    null,
                                    null,
                                    null,
                                    null
                                   ],
               'fnServerData': function(sSource, aoData, fnCallback) {
                 aoData.push({ 'name': 'jenis_izin', 'value': $('#selector option:selected').val() });
                 aoData.push({ 'name': 'first_date', 'value': $('#firstDateInput').val() });
                 aoData.push({ 'name': 'second_date', 'value': $('#secondDateInput').val() });
                 //aoData.push({ 'name': 'n_pemohon', 'value': $('#monitoring_filter input').val() });
                 $.ajax
                 ({
                   'dataType': 'json',
                   'type'    : 'POST',
                   'url'     : sSource,
                   'data'    : aoData,
                   'success' : fnCallback
                 });
               }
             });
           });
           $(document).ready(function() {
             $('.monbulan').datepicker({
               changeMonth: true,
               changeYear: true,
               dateFormat: 'yy-mm-dd',
               closeText: 'X'
             });
           });
           function finishAjax(id, response){
             $('#'+id).html(unescape(response));
             $('#'+id).fadeIn();
           }
          ";
    
    $this->template->set_metadata_javascript($js);
    $this->session_info['page_name'] = "Monitoring Per Perizinan";
    $this->template->build('list', $this->session_info);
  }

  public function persektor() {
    // Sementara untuk koreksi sektor Perbaiki Sektor
    // Digunakan jika diperlukan karena ada perubahan sektor
       //     $permohonan = new tmpermohonan();
       //     $i = 1;
       //     $a = TRUE;
       //     while ($a) {
       //         $permohonan->get_by_id($i);
       //         $kd_permohonan = $permohonan->id;
       //         $permohonan_perizinan = new tmpermohonan_trperizinan();
       //         $permohonan_perizinan->where('tmpermohonan_id', $kd_permohonan)->get();
       //         $kd_izin = $permohonan_perizinan->trperizinan_id;
       //         $perizinan_sektor = new trperizinan_trsektor();
       //         $perizinan_sektor->where('trperizinan_id', $kd_izin)->get();
       //         $kd_sektor = $perizinan_sektor->trsektor_id;
       //         $permohonan->trsektor_id = $kd_sektor;
       //         $permohonan->save();
       //         $i = $i+1;
       //         if($i == 15424) $a=FALSE; // jumlah record yang ada
       //     }
    // Koreksi sektor EOF()

    $today = date('Y-m-d');
    $first_date = $this->input->post('first_date') == null ? $this->lib_date->set_date(date('Y-m-d'), -2) : $this->input->post('first_date');
    $second_date = $this->input->post('second_date') == null ? $this->lib_date->set_date(date('Y-m-d'), 0) : $this->input->post('second_date');
        
    $username = new user();
    $username->where('username', $this->session->userdata('username'))->get();
    $data['lokasi'] = $username->lokasi;
    $data['cek_sektor'] = $username->sektor;
    if($username->lokasi == 'OPD Teknis')
      $list_sektor = $username->sektor;
    else
      $list_sektor = $this->input->post('list_sektor');
    
    $mark = $this->input->post('mark');
    $stspermohonan = new trstspermohonan();
    $data['sektor'] = $list_sektor;
    $data['first_date'] = $first_date;
    $data['second_date'] = $second_date;
    $data['mark'] = $mark;
    
    $obj = $this->permohonan; 
    $data['list_data'] = $this->sektor->order_by('urutan', 'ASC')->get();
    
    if($list_sektor == 0){
      $data['listpermohonan'] = $obj->where_related("trstspermohonan", 'id <> 1')->where("d_terima_berkas >= '$first_date' AND d_terima_berkas <= '$second_date'")->get();
      $data['jumlah'] = $obj->where_related("trstspermohonan", 'id <> 1')->where("d_terima_berkas >= '$first_date' AND d_terima_berkas <= '$second_date'")->count();
    }else{
      $data['listpermohonan'] = $obj->where_related("trstspermohonan", 'id <> 1')->where("trsektor_id = '$list_sektor' AND d_terima_berkas >= '$first_date' AND d_terima_berkas <= '$second_date'")->get();
      $data['jumlah'] = $obj->where_related("trstspermohonan", 'id <> 1')->where("trsektor_id = '$list_sektor' AND d_terima_berkas >= '$first_date' AND d_terima_berkas <= '$second_date'")->count();
    }
    
    $this->load->vars($data);
    
    $js = "
           $(document).ready(function() {
             oTable = $('#monitoring').dataTable({
                      \"bJQueryUI\": true,
                      \"sPaginationType\": \"full_numbers\"
             });
           });
           
           $(document).ready(function() {
             $('.monbulan').datepicker({
               changeMonth: true,
               changeYear: true,
               dateFormat: 'yy-mm-dd',
               closeText: 'X'
             });
           });
           
           function finishAjax(id, response){
             $('#'+id).html(unescape(response));
             $('#'+id).fadeIn();
           }
          ";
    $this->template->set_metadata_javascript($js);
    $this->session_info['page_name'] = "Monitoring Perizinan Per Bidang";
    $this->template->build('list_persektor', $this->session_info);
  }

  // Monitoring per Asal Permohonan
  public function perwaktu() {
    $today = date('Y-m-d');
    $first_date = $this->input->post('first_date') == null ? $this->lib_date->set_date(date('Y-m-d'), -2) : $this->input->post('first_date');
    $second_date = $this->input->post('second_date') == null ? $this->lib_date->set_date(date('Y-m-d'), 0) : $this->input->post('second_date');
    $list_state = $this->input->post('list_state');
    $mark = $this->input->post('mark');
    
    $username = new user();
    $username->where('username', $this->session->userdata('username'))->get();
    $lokasi = $username->lokasi;
    $cek_sektor = $username->sektor;
    
    $stspermohonan = new trstspermohonan();
    $data['list_state'] = $list_state;
    $data['first_date'] = $first_date;
    $data['second_date'] = $second_date;
    $data['mark'] = $mark;
    $obj = $this->permohonan;
         
    if($username->lokasi == 'OPD Teknis'){
      if($list_state === '0' || $list_state == NULL) {
        $data['listpermohonan'] = $obj->where_related("trstspermohonan", 'id <> 1')->where("trsektor_id = '$cek_sektor' AND d_terima_berkas >= '$first_date' AND d_terima_berkas <= '$second_date'")->get();
        $data['jumlah'] = $obj->where_related("trstspermohonan", 'id <> 1')->where("trsektor_id = '$cek_sektor' AND d_terima_berkas >= '$first_date' AND d_terima_berkas <= '$second_date'")->count();
      }else{
        $data['listpermohonan'] = $obj->where_related("trstspermohonan", 'id <> 1')->where("trsektor_id = '$cek_sektor' AND kd_gerai = '$list_state' AND d_terima_berkas >= '$first_date' AND d_terima_berkas <= '$second_date'")->get();
        $data['jumlah'] = $obj->where_related("trstspermohonan", 'id <> 1')->where("trsektor_id = '$cek_sektor' AND kd_gerai = '$list_state' AND d_terima_berkas >= '$first_date' AND d_terima_berkas <= '$second_date'")->count();
      }
    }else{
      if($list_state === '0' || $list_state == NULL) {
        $data['listpermohonan'] = $obj->where_related("trstspermohonan", 'id <> 1')->where("d_terima_berkas >= '$first_date' AND d_terima_berkas <= '$second_date'")->get();
        $data['jumlah'] = $obj->where_related("trstspermohonan", 'id <> 1')->where("d_terima_berkas >= '$first_date' AND d_terima_berkas <= '$second_date'")->count();
      }else{
        $data['listpermohonan'] = $obj->where_related("trstspermohonan", 'id <> 1')->where("kd_gerai = '$list_state' AND d_terima_berkas >= '$first_date' AND d_terima_berkas <= '$second_date'")->get();
        $data['jumlah'] = $obj->where_related("trstspermohonan", 'id <> 1')->where("kd_gerai = '$list_state' AND d_terima_berkas >= '$first_date' AND d_terima_berkas <= '$second_date'")->count();
      }
    }
         
    $this->load->vars($data);
    $js = "
           $(document).ready(function() {
             oTable = $('#monitoring').dataTable({
               \"bJQueryUI\": true,
               \"sPaginationType\": \"full_numbers\"
             });
           });
           
           $(document).ready(function() {
             $('.monbulan').datepicker({
               changeMonth: true,
               changeYear: true,
               dateFormat: 'yy-mm-dd',
               closeText: 'X'
             });
           });
           
           function finishAjax(id, response){
             $('#'+id).html(unescape(response));
             $('#'+id).fadeIn();
           }
          ";
    $this->template->set_metadata_javascript($js);
    $this->session_info['page_name'] = "Monitoring Per Asal Permohonan";
    $this->template->build('list_perbulan', $this->session_info);
  }

    public function kecamatan() {
        $propinsi_id = $this->input->post('propinsi_pemohon');
        $kabupaten_id = $this->input->post('kabupaten_pemohon');
        $kecamatan_id = $this->input->post('kecamatan_pemohon');
        $kelurahan_id = $this->input->post('kelurahan_pemohon');

        $submit = $this->input->post('submit');

        if ($propinsi_id == NULL)  { $propinsi_id = 0; }
        if ($kabupaten_id == NULL) { $kabupaten_id = 0; }
        if ($kecamatan_id == NULL) { $kecamatan_id = 0; }
        if ($kelurahan_id == NULL) { $kelurahan_id = 0; }

        $data['propinsi_id'] = $propinsi_id;
        $data['kabupaten_id'] = $kabupaten_id;
        $data['kecamatan_id'] = $kecamatan_id;
        $data['kelurahan_id'] = $kelurahan_id;
        $data['submit'] = $submit;

        $first_date = $this->input->post('first_date') == null ? $this->lib_date->set_date(date('Y-m-d'), -2) : $this->input->post('first_date');
        $second_date = $this->input->post('second_date') == null ? $this->lib_date->set_date(date('Y-m-d'), 0) : $this->input->post('second_date');
        $stspermohonan = new trstspermohonan();

        $data['first_date'] = $first_date;
        $data['second_date'] = $second_date;
        $this->load->vars($data);

        $data['propinsi_id'] = $propinsi_id;
        $data['kabupaten_id'] = $kabupaten_id;
        $data['kecamatan_id'] = $kecamatan_id;
        $data['kelurahan_id'] = $kelurahan_id;
        $list_kabupaten = NULL;
        $list_kelurahan = NULL;
        $list_kecamatan = NULL;
        if ($submit) {
            $list_kabupaten = $this->list_wilayah->get_result_kabupaten($propinsi_id);
            $list_kecamatan = $this->list_wilayah->get_result_kecamatan($kabupaten_id);
            $list_kelurahan = $this->list_wilayah->get_result_kelurahan($kecamatan_id);
        }

        $data['list_propinsi'] = $this->propinsi->order_by('n_propinsi', 'ASC')->get();

        $data['list_kabupaten'] = $list_kabupaten; //$this->kabupaten->order_by('n_kabupaten', 'ASC')->get();
        $data['list_kecamatan'] = $list_kecamatan; //$this->kecamatan->order_by('n_kecamatan', 'ASC')->get();
        $data['list_kelurahan'] = $list_kelurahan; //$this->kelurahan->order_by('n_kelurahan', 'ASC')->get();

		$username = new user();
        $username->where('username', $this->session->userdata('username'))->get();
		$lokasi = $username->lokasi;
		$cek_sektor = $username->sektor;
        
		$data['jumlah']=$this->monitoring_bi->get_total_kecamatan($cari=NULL, $first_date, $second_date, $kelurahan_id, $lokasi, $cek_sektor);
        $this->load->vars($data);
        
		$js = " $(document).ready(function() {
                    $('#listdata').dataTable ({
                        'bJQueryUI'      : true,
                        'sPaginationType': 'full_numbers',
                        'bServerSide'    : true,
                        'bSort'          : false,
                        'bAutoWidth'     : false,
                        'sAjaxSource'    : '" . base_url() . "monitoring/datatables/list_kecamatan',
                        'aoColumns'      : [
                                            null,
                                            null,
                                            null,
                                            null,
                                            null,
                                            null,
                                            null,
                                            null
                                           ],
                        'fnServerData'   : function(sSource, aoData, fnCallback) {
                            aoData.push({ 'name': 'kelurahan_id', 'value': '" . $data['kelurahan_id'] . "' });
                            aoData.push({ 'name': 'first_date', 'value': '" . $first_date . "' });
                            aoData.push({ 'name': 'second_date', 'value': '" . $second_date . "' });
							aoData.push({ 'name': 'lokasi', 'value': '" . $lokasi . "' });
							aoData.push({ 'name': 'cek_sektor', 'value': '" . $cek_sektor . "' });
                            $.ajax ({
                                'dataType': 'json',
                                'type'    : 'POST',
                                'url'     : sSource,
                                'data'    : aoData,
                                'success' : fnCallback
                            });
                        }
                    });        
                
                    $('.monbulan').datepicker({
                        changeMonth: true,
                        changeYear: true,
                        dateFormat: 'yy-mm-dd',
                        closeText: 'X'
                    });                   
                    
					$('#propinsi_pemohon_id').change(function(){
                        $.post('" . base_url() . "monitoring/monitoring/kabupaten_pemohon', { propinsi_id: $('#propinsi_pemohon_id').val() },
                            function(data) {
                                            $('#show_kabupaten_pemohon').html(data);
                                            $('#show_kecamatan_pemohon').html('Data Tidak tersedia');
                                            $('#show_kelurahan_pemohon').html('Data Tidak tersedia');
                            }
						);
                    }); 
                }); 
			  ";
        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "Monitoring Per Wilayah";
        $this->template->build('list_kecamatan', $this->session_info);
    }

    public function kabupaten_pemohon() {
        $data['kabupaten_id'] = 'kabupaten_pemohon';
        $data['kecamatan_id'] = 'kecamatan_pemohon';
        $this->load->vars($data);
        $this->load->view('kabupaten_load_lagi', $data);
    }

    public function kecamatan_pemohon() {
        $data['kecamatan_id'] = 'kecamatan_pemohon';
        $data['kelurahan_id'] = 'kelurahan_pemohon';
        $this->load->vars($data);
        $this->load->view('kecamatan_load_lagi', $data);
    }

    public function kelurahan_pemohon() {
        $data['kelurahan_id'] = 'kelurahan_pemohon';
        $this->load->vars($data);
        $this->load->view('kelurahan_load_lagi', $data);
    }

    public function stateOLD() {
        $today = date('Y-m-d');
        $first_date = $this->input->post('first_date') == null ? $this->lib_date->set_date(date('Y-m-d'), -2) : $this->input->post('first_date');
        $second_date = $this->input->post('second_date') == null ? $this->lib_date->set_date(date('Y-m-d'), 0) : $this->input->post('second_date');
        $list_state = $this->input->post('list_state');
		$list_kirim = $this->input->post('list_kirim');
		$list_asal = $this->input->post('list_asal');
        $mark = $this->input->post('mark');
		$mark1 = $this->input->post('mark1');
		$mark2 = $this->input->post('mark2');
        $stspermohonan = new trstspermohonan();
        $data['list_state'] = $list_state;
		$data['list_kirim'] = $list_kirim;
		$data['list_asal'] = $list_asal;
        $data['first_date'] = $first_date;
        $data['second_date'] = $second_date;
        $data['mark'] = $mark;
		$data['mark1'] = $mark1;
		$data['mark2'] = $mark2;
        $obj = $this->permohonan;
        //$obj->where_related('trstspermohonan', 'id', "NOT IN 1");
        $data['listpermohonan'] = $obj->where_related("trstspermohonan", 'id <> 1')->where("d_terima_berkas >= '$first_date' AND d_terima_berkas <= '$second_date'")->get();
        
        if ($list_state === '1') {  // izin disetujui
            $data['listpermohonan'] = $obj->where_related("trstspermohonan", 'id <> 1')->where('c_izin_selesai', 1)->where("d_terima_berkas >= '$first_date' AND d_terima_berkas <= '$second_date'")->get();
            $obj = $this->permohonan;
            $data['jumlah'] = $obj->where_related("trstspermohonan", 'id <> 1')->where('c_izin_selesai', 1)->where("d_terima_berkas >= '$first_date' AND d_terima_berkas <= '$second_date'")->count();
        } elseif ($list_state === '0') { // izin belum jadi
            $data['listpermohonan'] = $obj->where_related("trstspermohonan", 'id <> 1')->where('c_izin_selesai', 0)->where("d_terima_berkas >= '$first_date' AND d_terima_berkas <= '$second_date'")->get();
            $obj = $this->permohonan;
            $data['jumlah'] = $obj->where_related("trstspermohonan", 'id <> 1')->where('c_izin_selesai', 0)->where("d_terima_berkas >= '$first_date' AND d_terima_berkas <= '$second_date'")->count();
        } else {  // izin kedaluarsa
            $data['listpermohonan'] = $obj->where_related("trstspermohonan", 'id <> 1')->where("d_berlaku_izin < $today")->get();
            $obj = $this->permohonan;
            $data['jumlah'] = $obj->where_related("trstspermohonan", 'id <> 1')->where("d_berlaku_izin < $today")->count();
        }

// Create BPS
//        if ($list_state === '1') {  // izin disetujui
//			$data['listpermohonan'] = $obj->where_related("trstspermohonan", 'id <> 1')->where('status_berkas', 'Izin Disetujui')->where("d_terima_berkas >= '$first_date' AND d_terima_berkas <= '$second_date'")->get();
//            $obj = $this->permohonan;
//            $data['jumlah'] = $obj->where_related("trstspermohonan", 'id <> 1')->where('status_berkas', 'Izin Disetujui')->where("d_terima_berkas >= '$first_date' AND d_terima_berkas <= '$second_date'")->count();
//        } elseif ($list_state === '0') { // izin belum jadi
//            $data['listpermohonan'] = $obj->where_related("trstspermohonan", 'id <> 1')->where('c_izin_selesai', 0)->where("d_terima_berkas >= '$first_date' AND d_terima_berkas <= '$second_date'")->get();
//            $obj = $this->permohonan;
//            $data['jumlah'] = $obj->where_related("trstspermohonan", 'id <> 1')->where('c_izin_selesai', 0)->where("d_terima_berkas >= '$first_date' AND d_terima_berkas <= '$second_date'")->count();
//        } else {  // izin kedaluarsa
           
//            $list = $obj->where_related("trstspermohonan", 'id <> 1')->where("d_berlaku_izin < $today")->get();
//            $jumlah = $obj->where_related("trstspermohonan", 'id <> 1')->where("d_berlaku_izin < $today")->count();
//        }

//		$data['listpermohonan'] = $list;
//		$obj = $this->permohonan;
//		$data['jumlah'] =
// EOF PBS
        		 
        $this->load->vars($data);

        $js = "
            $(document).ready(function() {
                oTable = $('#monitoring').dataTable({
                                \"bJQueryUI\": true,
                                    \"sPaginationType\": \"full_numbers\"
                        });
            });

            $(document).ready(function() {
                $('.monbulan').datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: 'yy-mm-dd',
                    closeText: 'X'
                });

            });

            function finishAjax(id, response){
                $('#'+id).html(unescape(response));
                $('#'+id).fadeIn();
            }

        ";
        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "Monitoring Per Perizinan Belum/Sudah Jadi dan Kadaluarsa";
        $this->template->build('list_state', $this->session_info);
    }

  public function stateOLD2023() {
        $username = new user();
        $username->where('username', $this->session->userdata('username'))->get();
		$lokasi = $username->lokasi;
		$cek_sektor = $username->sektor;
		
		$list_status = $this->input->post('list_status');
		$list_asal = $this->input->post('list_asal'); //PBS
		$list_kirim = $this->input->post('list_kirim'); //PBS
        $first_date = $this->input->post('first_date') == null ? $this->lib_date->set_date(date('Y-m-d'), -2) : $this->input->post('first_date');
        $second_date = $this->input->post('second_date') == null ? $this->lib_date->set_date(date('Y-m-d'), 0) : $this->input->post('second_date');
        $mark = $this->input->post('mark');
		$mark1 = $this->input->post('mark1'); //PBS
		$mark2 = $this->input->post('mark2'); //PBS
        $stspermohonan = new trstspermohonan();
        $data['list_status2'] = $list_status;
        $data['first_date'] = $first_date;
        $data['second_date'] = $second_date;
        $data['mark'] = $mark;
		$data['mark1'] = $mark1; //PBS
		$data['mark2'] = $mark2; //PBS

        $data['jumlah']=$this->monitoring_bi->get_total_perstatus($cari=NULL, $first_date, $second_date, $list_status, $lokasi, $cek_sektor);
        $data['list_status'] = $stspermohonan->order_by('id', 'ASC')->get();
        $data['list_asal'] = $list_asal; //PBS
		$data['list_kirim'] = $list_kirim; //PBS

        $this->load->vars($data);

        $js = "
               $(document).ready(function() {
                   $('#listdata').dataTable ({
                       'bJQueryUI'      : true,
                       'sPaginationType': 'full_numbers',
                       'bServerSide'    : true,
                       'bSort'          : false,
                       'bAutoWidth'     : false,
                       'sAjaxSource'    : '" . base_url() . "monitoring/datatables/list_Monitoring_Per_Status',
                       'aoColumns'      : [
                                           null,
                                           null,
                                           null,
                                           null,
                                           null,
                                           null,
                                           null,
                                           null
                                          ],

                       'fnServerData': function(sSource, aoData, fnCallback) {
                            aoData.push({ 'name': 'list_status', 'value': $('#selecStatus option:selected').val() });
						    aoData.push({ 'name': 'list_asal', 'value': $('#selecAsal option:selected').val() });
                            aoData.push({ 'name': 'first_date', 'value': $('#firstDateInput').val() });
                            aoData.push({ 'name': 'second_date', 'value': $('#secondDateInput').val() });
							aoData.push({ 'name': 'lokasi', 'value': '" . $lokasi . "' });
							aoData.push({ 'name': 'cek_sektor', 'value': '" . $cek_sektor . "' });
                            $.ajax ({
                                'dataType': 'json',
                                'type'    : 'POST',
                                'url'     : sSource,
                                'data'    : aoData,
                                'success' : fnCallback
                            });
                       }
                   });
               });

               $(document).ready(function() {
                   $('.monbulan').datepicker({
                       changeMonth: true,
                       changeYear: true,
                       dateFormat: 'yy-mm-dd',
                       closeText: 'X'
                   });
               });

               function finishAjax(id, response){
                   $('#'+id).html(unescape(response));
                   $('#'+id).fadeIn();
               }
              ";
        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "Monitoring Per Perizinan Belum/Sudah Jadi dan Kadaluarsa";
        $this->template->build('list_statusJBK', $this->session_info);
    }
    
  public function state() { // Monitoring Perizinan Melebihi Masa Durasi
    $set_kriteria = 15; // set kriteria masa kedaluarsa kedepan
    $username = new user();
    $username->where('username', $this->session->userdata('username'))->get();
    $lokasi = $username->lokasi;
    $cek_sektor = $username->sektor;
    
    $list_status = $this->input->post('list_status');
    $first_date = $this->input->post('first_date') == null ? $this->lib_date->set_date(date('Y-m-d'), -2) : $this->input->post('first_date');
    $second_date = $this->input->post('second_date') == null ? $this->lib_date->set_date(date('Y-m-d'), 0) : $this->input->post('second_date');
    $mark = $this->input->post('mark');
    $ket_status = 'Data Izin Dalam Proses Melebihi Masa Durasi';
    $list_izin = array();
    
    if(!empty($this->input->post('first_date')) && !empty($this->input->post('second_date'))) {
      $user = new user();
      $user->where('username', $this->session->userdata('username'))->get();
      $lokasi_user = $this->session->userdata('lokasi'); 
      if($this->admin){
        $query_add = "";
        $query_add1 = "";
      }else{
        if($lokasi_user === 'DPMPTSP Prov. Jabar' || $lokasi_user === 'BPMPT Prov. Jabar' || $lokasi_user === 'BPPT Prov. Jabar') {
          $query_add = " INNER JOIN trperizinan_user AS L ON L.trperizinan_id = C.id ";
          $query_add1 = " AND L.user_id = '".$user->id."'";
        }else{
        	$query_add = " INNER JOIN trperizinan_user AS L ON L.trperizinan_id = C.id ";
          $query_add1 = " AND L.user_id = '".$user->id."'";//."AND A.kd_gerai =  '".$lokasi_user."'";
        }
      }
      switch($list_status) {
        case '0': $ket_status = 'Data Izin Dalam Proses Melebihi Masa Durasi';
                  $sql = "SELECT A.*, E.n_pemohon, C.n_perizinan, K.tgl_surat, C.v_berlaku_tahun, C.v_hari 
                          FROM tmpermohonan as A 
                          LEFT JOIN tmpermohonan_trperizinan as B ON B.tmpermohonan_id = A.id 
                          LEFT JOIN trperizinan as C ON B.trperizinan_id = C.id 
                          LEFT JOIN tmpemohon_tmpermohonan as D ON D.tmpermohonan_id = A.id 
                          LEFT JOIN tmpemohon as E ON D.tmpemohon_id = E.id 
                          LEFT JOIN tmpermohonan_trjenis_permohonan as F ON F.tmpermohonan_id = A.id 
                          LEFT JOIN trjenis_permohonan as G ON F.trjenis_permohonan_id = G.id 
                          LEFT JOIN tmbap_tmpermohonan H ON A.id = H.tmpermohonan_id 
                          LEFT JOIN tmbap I ON H.tmbap_id = I.id 
                          LEFT JOIN tmpermohonan_tmsk J ON A.id = J.tmpermohonan_id 
                          LEFT JOIN tmsk K ON J.tmsk_id = K.id ".$query_add. 
                          "WHERE A.kd_status < 7 
                          AND A.approve != 2 
                          AND A.status_berkas != 'Izin Ditolak'
                          AND DATE(d_selesai_proses) < ? 
                          AND datediff(CURDATE(), DATE(A.d_terima_berkas)) > C.v_hari
                          AND (DATE(K.tgl_surat) BETWEEN ? AND ?) ".$query_add1;
                          //AND (DATE(A.d_terima_berkas) BETWEEN ? AND ?) ".$query_add1;
                  $list_izin = $this->db->query($sql, array(date('Y-m-d'), $first_date, $second_date))->result();
                  break;
        case '1': $ket_status = 'Data Masa Berlaku Izin Segera Berakhir'; // dalam '.$set_kriteria.' Hari Kedepan';
                  $sql = "SELECT A.*, E.n_pemohon, C.n_perizinan, K.tgl_surat, C.v_berlaku_tahun, C.v_hari 
                          FROM tmpermohonan as A 
                          LEFT JOIN tmpermohonan_trperizinan as B ON B.tmpermohonan_id = A.id 
                          LEFT JOIN trperizinan as C ON B.trperizinan_id = C.id 
                          LEFT JOIN tmpemohon_tmpermohonan as D ON D.tmpermohonan_id = A.id 
                          LEFT JOIN tmpemohon as E ON D.tmpemohon_id = E.id 
                          LEFT JOIN tmpermohonan_trjenis_permohonan as F ON F.tmpermohonan_id = A.id 
                          LEFT JOIN trjenis_permohonan as G ON F.trjenis_permohonan_id = G.id 
                          LEFT JOIN tmbap_tmpermohonan H ON A.id = H.tmpermohonan_id 
                          LEFT JOIN tmbap I ON H.tmbap_id = I.id 
                          LEFT JOIN tmpermohonan_tmsk J ON A.id = J.tmpermohonan_id 
                          LEFT JOIN tmsk K ON J.tmsk_id = K.id ".$query_add. 
                          "WHERE A.approve = 2 
                          AND A.status_berkas = 'Izin Disetujui' 
                          AND C.v_berlaku_tahun != 1000 ".$query_add1;
                          //AND (DATE(K.tgl_surat) BETWEEN ? AND ?) ".$query_add1;
                          //AND (DATE(A.d_terima_berkas) BETWEEN ? AND ?) ".$query_add1;
                  $list_izin = $this->db->query($sql, array($first_date, $second_date))->result();
                  //AND datediff(CURDATE(), DATE(A.d_selesai_proses)) > C.v_hari
                  break;
        case '2': $ket_status = 'Data Masa Berlaku Izin Telah Berakhir';
                  $sql = "SELECT A.*, E.n_pemohon, C.n_perizinan, K.tgl_surat, C.v_berlaku_tahun, C.v_hari 
                          FROM tmpermohonan as A 
                          LEFT JOIN tmpermohonan_trperizinan as B ON B.tmpermohonan_id = A.id 
                          LEFT JOIN trperizinan as C ON B.trperizinan_id = C.id 
                          LEFT JOIN tmpemohon_tmpermohonan as D ON D.tmpermohonan_id = A.id 
                          LEFT JOIN tmpemohon as E ON D.tmpemohon_id = E.id 
                          LEFT JOIN tmpermohonan_trjenis_permohonan as F ON F.tmpermohonan_id = A.id 
                          LEFT JOIN trjenis_permohonan as G ON F.trjenis_permohonan_id = G.id 
                          LEFT JOIN tmbap_tmpermohonan H ON A.id = H.tmpermohonan_id 
                          LEFT JOIN tmbap I ON H.tmbap_id = I.id 
                          LEFT JOIN tmpermohonan_tmsk J ON A.id = J.tmpermohonan_id 
                          LEFT JOIN tmsk K ON J.tmsk_id = K.id ".$query_add. 
                          "WHERE A.approve = 2 
                          AND A.status_berkas = 'Izin Disetujui' 
                          AND C.v_berlaku_tahun != 1000  ".$query_add1;
                          //AND (DATE(K.tgl_surat) BETWEEN ? AND ?) ".$query_add1;
                          //AND (DATE(A.d_terima_berkas) BETWEEN ? AND ?) ".$query_add1;
                  $list_izin = $this->db->query($sql, array($first_date, $second_date))->result();  
                  break;
      }
      //var_dump($list_izin);die;
    }
    
    $stspermohonan = new trstspermohonan();
    $data['set_kriteria'] = $set_kriteria;
    $data['list_status2'] = $list_status;
    $data['first_date'] = $first_date;
    $data['second_date'] = $second_date;
    $data['mark'] = $mark;
    $data['list_izin'] = $list_izin;
    $refresh = $this->input->post('refresh');
    
    $this->load->vars($data);
    
    $js = "
           $(document).ready(function() {
             oTable = $('#listdata').dataTable({
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
    
           function finishAjax(id, response){
               $('#'+id).html(unescape(response));
               $('#'+id).fadeIn();
           }
           
           $('#selecStatus_id').change(function(){
             $.post('" . base_url() . "monitoring/monitoring/cek_status', { selecStatus: $('#selecStatus_id').val()},
                     function(data) {
                       $('#show_selecStatus_1').html(data);
                       $('#show_selecStatus_2').html(data);
                       $('#show_selecStatus_3').html('');
                     }
    			   );
           });
                     
          ";
    $this->template->set_metadata_javascript($js);
    $this->session_info['page_name'] = $ket_status;
    $this->template->build('list_statusJBK', $this->session_info);
  }

    public function status() {
        $list_status = $this->input->post('list_status');
		$list_asal = $this->input->post('list_asal'); //PBS
        $first_date = $this->input->post('first_date') == null ? $this->lib_date->set_date(date('Y-m-d'), -2) : $this->input->post('first_date');
        $second_date = $this->input->post('second_date') == null ? $this->lib_date->set_date(date('Y-m-d'), 0) : $this->input->post('second_date');
        $mark = $this->input->post('mark');
		$mark1 = $this->input->post('mark1'); //PBS
        $stspermohonan = new trstspermohonan();
        $data['list_status2'] = $list_status;
        $data['first_date'] = $first_date;
        $data['second_date'] = $second_date;
        $data['mark'] = $mark;
		$data['mark1'] = $mark1; //PBS

		$username = new user();
        $username->where('username', $this->session->userdata('username'))->get();
		$lokasi = $username->lokasi;
		$cek_sektor = $username->sektor;

        $data['jumlah']=$this->monitoring_bi->get_total_perstatus($cari=NULL, $first_date, $second_date, $list_status, $lokasi, $cek_sektor);
        $data['list_status'] = $stspermohonan->order_by('id', 'ASC')->get();
        $data['list_asal'] = $list_asal; //PBS
        $this->load->vars($data);

        $js = "
               $(document).ready(function() {
                   $('#listdata').dataTable ({
                       'bJQueryUI'      : true,
                       'sPaginationType': 'full_numbers',
                       'bServerSide'    : true,
                       'bSort'          : false,
                       'bAutoWidth'     : false,
                       'sAjaxSource'    : '" . base_url() . "monitoring/datatables/list_Monitoring_Per_Status',
                       'aoColumns'      : [
                                           null,
                                           null,
                                           null,
                                           null,
                                           null,
                                           null,
                                           null,
                                           null
                                          ],
                       'fnServerData': function(sSource, aoData, fnCallback) {
                            aoData.push({ 'name': 'list_status', 'value': $('#selecStatus option:selected').val() });
	    					aoData.push({ 'name': 'list_asal', 'value': $('#selecAsal option:selected').val() });
                            aoData.push({ 'name': 'first_date', 'value': $('#firstDateInput').val() });
                            aoData.push({ 'name': 'second_date', 'value': $('#secondDateInput').val() });
							aoData.push({ 'name': 'lokasi', 'value': '" . $lokasi . "' });
							aoData.push({ 'name': 'cek_sektor', 'value': '" . $cek_sektor . "' });
                            $.ajax ({
                                'dataType': 'json',
                                'type'    : 'POST',
                                'url'     : sSource,
                                'data'    : aoData,
                                'success' : fnCallback
                            });
                       }
                   });
               });

               $(document).ready(function() {
                   $('.monbulan').datepicker({
                       changeMonth: true,
                       changeYear: true,
                       dateFormat: 'yy-mm-dd',
                       closeText: 'X'
                   });
               });

               function finishAjax(id, response){
                   $('#'+id).html(unescape(response));
                   $('#'+id).fadeIn();
               }
              ";
        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "Monitoring Per Status ";
        $this->template->build('list_status', $this->session_info);
    }

    public function pemohon() {
        $username = new user();
        $username->where('username', $this->session->userdata('username'))->get();
		$lokasi = $username->lokasi;
		$cek_sektor = $username->sektor;
		
		$nama = $this->input->post('nama');
        $first_date = $this->input->post('first_date') == null ? $this->lib_date->set_date(date('Y-m-d'), -2) : $this->input->post('first_date');
        $second_date = $this->input->post('second_date') == null ? $this->lib_date->set_date(date('Y-m-d'), 0) : $this->input->post('second_date');
        $stspermohonan = new trstspermohonan();
        $data['nama'] = $nama;
        $data['first_date'] = $first_date;
        $data['second_date'] = $second_date;
        $data['jumlah']=$this->monitoring_bi->get_total_pemohon($cari=NULL, $first_date, $second_date, $nama, $lokasi, $cek_sektor);

        $this->load->vars($data);

        $js = "
               $(document).ready(function() {
                   $('#monitoring').dataTable ({
                       'bJQueryUI'      : true,
                       'sPaginationType': 'full_numbers',
                       'bServerSide'    : true,
                       'bSort'          : false,
                       'bAutoWidth'     : false,
                       'sAjaxSource'    : '" . base_url() . "monitoring/datatables/list_Monitoring_Per_Nama_Pemohon',
                       'aoColumns'      : [
                                           null,
                                           null,
                                           null,
                                           null,
                                           null,
                                           null,
                                           null,
                                           null
                                          ],
                       'fnServerData': function(sSource, aoData, fnCallback) {
                            aoData.push({ 'name': 'nama', 'value': $('#nama').val() });
                            aoData.push({ 'name': 'first_date', 'value': $('#firstDateInput').val() });
                            aoData.push({ 'name': 'second_date', 'value': $('#secondDateInput').val() });
							aoData.push({ 'name': 'lokasi', 'value': '" . $lokasi . "' });
							aoData.push({ 'name': 'cek_sektor', 'value': '" . $cek_sektor . "' });
                            $.ajax ({
                                'dataType': 'json',
                                'type'    : 'POST',
                                'url'     : sSource,
                                'data'    : aoData,
                                'success' : fnCallback
                            });
                       }
                   });
               });

               $(document).ready(function() {
                   $('.monbulan').datepicker({
                       changeMonth: true,
                       changeYear: true,
                       dateFormat: 'yy-mm-dd',
                       closeText: 'X'
                   });
               });

               function finishAjax(id, response){
                   $('#'+id).html(unescape(response));
                   $('#'+id).fadeIn();
               }
              ";
        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "Monitoring Per Nama Pemohon";
        $this->template->build('list_pemohon', $this->session_info);
    }

    public function perusahaan() {
        $username = new user();
        $username->where('username', $this->session->userdata('username'))->get();
		$lokasi = $username->lokasi;
		$cek_sektor = $username->sektor;
		
		$nama_perusahaan = $this->input->post('nama_perusahaan');
        $first_date = $this->input->post('first_date') == null ? $this->lib_date->set_date(date('Y-m-d'), -2) : $this->input->post('first_date');
        $second_date = $this->input->post('second_date') == null ? $this->lib_date->set_date(date('Y-m-d'), 0) : $this->input->post('second_date');
        $stspermohonan = new trstspermohonan();
        $data['nama_perusahaan'] = $nama_perusahaan;
        $data['first_date'] = $first_date;
        $data['second_date'] = $second_date;
        $data['jumlah']=$this->monitoring_bi->get_total_perusahaan($cari=NULL, $first_date, $second_date, $nama_perusahaan, $lokasi, $cek_sektor);
		
        $this->load->vars($data);

        $js = "
               $(document).ready(function() {
                   $('#monitoring').dataTable ({
                       'bJQueryUI'      : true,
                       'sPaginationType': 'full_numbers',
                       'bServerSide'    : true,
                       'bSort'          : false,
                       'bAutoWidth'     : false,
                       'sAjaxSource'    : '" . base_url() . "monitoring/datatables/list_Monitoring_Per_Nama_Perusahaan',
                       'aoColumns'      : [
                                           null,
                                           null,
                                           null,
                                           null,
                                           null,
                                           null,
                                           null,
                                           null
                                          ],
                       'fnServerData': function(sSource, aoData, fnCallback) {
                            aoData.push({ 'name': 'nama_perusahaan', 'value': $('#nama_perusahaan').val() });
                            aoData.push({ 'name': 'first_date', 'value': $('#firstDateInput').val() });
                            aoData.push({ 'name': 'second_date', 'value': $('#secondDateInput').val() });
							aoData.push({ 'name': 'lokasi', 'value': '" . $lokasi . "' });
							aoData.push({ 'name': 'cek_sektor', 'value': '" . $cek_sektor . "' });
                            $.ajax ({
                                'dataType': 'json',
                                'type'    : 'POST',
                                'url'     : sSource,
                                'data'    : aoData,
                                'success' : fnCallback
                            });
                       }
                   });
               });

               $(document).ready(function() {
                   $('.monbulan').datepicker({
                       changeMonth: true,
                       changeYear: true,
                       dateFormat: 'yy-mm-dd',
                       closeText: 'X'
                   });
               });

               function finishAjax(id, response){
                   $('#'+id).html(unescape(response));
                   $('#'+id).fadeIn();
               }
              ";
        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "Monitoring Per Nama Perusahaan";
        $this->template->build('list_perusahaan', $this->session_info);
    }

    public function pengambilan() {
        $jenis_izin = $this->input->post('jenis_izin');
        $first_date_taken = $this->input->post('first_date_taken') == null ? $this->lib_date->set_date(date('Y-m-d'), -2) : $this->input->post('first_date_taken');
        $second_date_taken = $this->input->post('second_date_taken') == null ? $this->lib_date->set_date(date('Y-m-d'), 0) : $this->input->post('second_date_taken');
        $mark = $this->input->post('mark');
        $stspermohonan = new trstspermohonan();
        $data['jenis_izin'] = $jenis_izin;
        $data['first_date_taken'] = $first_date_taken;
        $data['second_date_taken'] = $second_date_taken;
        $data['mark'] = $mark;
				
		$username = new user();
        $username->where('username', $this->session->userdata('username'))->get();
		$lokasi = $username->lokasi;
		$cek_sektor = $username->sektor;
        
		if($lokasi == 'OPD Teknis')
		    $data['list_ijin'] = $this->perizinan->where_related("trsektor", 'id = '.$cek_sektor)->order_by('kd_izin', 'ASC')->get();
		else
            $data['list_ijin'] = $this->perizinan->order_by('kd_izin', 'ASC')->get();
        
		$data['jumlah']=$this->monitoring_bi->get_total_Per_Bulan_Pengambilan_Izin($cari=NULL, $first_date_taken, $second_date_taken, $jenis_izin, $lokasi, $cek_sektor);
        
        $this->load->vars($data);

        $js = "
               $(document).ready(function() {
                   $('#listdata').dataTable ({
                       'bJQueryUI'      : true,
                       'sPaginationType': 'full_numbers',
                       'bServerSide'    : true,
                       'bAutoWidth'     : false,
                       'bSort'          : false,
                       'sAjaxSource'    : '" . base_url() . "monitoring/datatables/list_Monitoring_Per_Bulan_Pengambilan_Izin',
                       'aoColumns'      : [
                                           null,
                                           null,
                                           null,
                                           null,
                                           null,
                                           null,
                                           null,
                                           null,
                                           null
                                          ],
                       'fnServerData': function(sSource, aoData, fnCallback) {
                            aoData.push({ 'name': 'jenis_izin', 'value': $('#selector option:selected').val() });
                            aoData.push({ 'name': 'first_date_taken', 'value': $('#firstDateInput').val() });
                            aoData.push({ 'name': 'second_date_taken', 'value': $('#secondDateInput').val() });
			    			aoData.push({ 'name': 'lokasi', 'value': '" . $lokasi . "' });
				 			aoData.push({ 'name': 'cek_sektor', 'value': '" . $cek_sektor . "' });
                            $.ajax ({
                                'dataType': 'json',
                                'type'    : 'POST',
                                'url'     : sSource,
                                'data'    : aoData,
                                'success' : fnCallback
                            });
                        }
                   });
               });

               $(document).ready(function() {
                   $('.monbulan').datepicker({
                       changeMonth: true,
                       changeYear: true,
                       dateFormat: 'yy-mm-dd',
                       closeText: 'X'
                   });
               });

               function finishAjax(id, response){
                   $('#'+id).html(unescape(response));
                   $('#'+id).fadeIn();
               }
              ";
        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "Monitoring Per Bulan Pengambilan Izin";
        $this->template->build('list_ambilizin', $this->session_info);
    }

    public function cetak_penyerahan_izin($cek_status = NULL, $tgla = NULL, $tglb = NULL) {
        if($cek_status == 0) {
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
        } else {
            $data['tgla'] = $tgla;
            $data['tglb'] = $tglb;
	    }
		$username = new user();
        $username->where('username', $this->session->userdata('username'))->get();
        $lokasi_user = $this->session->userdata('lokasi');
        $realname = $this->session->userdata('realname');
        $data['kd_user'] = $username->id;

		if ($lokasi_user === 'Pusat') { // Untuk daerah lain
		//if ($lokasi_user === 'DPMPTSP Prov. tasikmalaya' || $lokasi_user === 'BPMPT Prov. tasikmalaya' || $lokasi_user === 'BPPT Prov. tasikmalaya') {
            $query = "SELECT  A.id, A.pendaftaran_id, A.c_status_bayar, A.d_terima_berkas,
            A.d_perubahan, A.d_perpanjangan, A.d_daftarulang, A.siap_serah, A.status_berkas,
            C.id idizin, C.n_perizinan, E.n_pemohon,
            G.id idjenis, G.n_permohonan,
            I.status_bap, K.tgl_surat, K.no_surat, A.c_cetak, N.n_sts_permohonan,
            L.trkelompok_perizinan_id idkelompok,
            E.telp_pemohon, A.kd_gerai
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
            INNER JOIN trkelompok_perizinan_trperizinan L ON L.trperizinan_id = C.id
            INNER JOIN tmpermohonan_trstspermohonan M ON A.id = M.tmpermohonan_id
            INNER JOIN trstspermohonan N ON M.trstspermohonan_id = N.id
            /* INNER JOIN trperizinan_user AS M ON M.trperizinan_id = C.id */
            WHERE A.c_pendaftaran = 1
            AND A.c_izin_dicabut = 0
            AND A.c_izin_selesai = 0
			AND N.id = 8
            /* AND M.user_id = '" . $username->id . "' */
            AND A.d_terima_berkas between '$tgla' and '$tglb'
            order by A.id DESC";
		} else {
            $query = "SELECT  A.id, A.pendaftaran_id, A.c_status_bayar, A.d_terima_berkas,
            A.d_perubahan, A.d_perpanjangan, A.d_daftarulang, A.siap_serah, A.status_berkas,
            C.id idizin, C.n_perizinan, E.n_pemohon,
            G.id idjenis, G.n_permohonan,
            I.status_bap, K.tgl_surat, K.no_surat, A.c_cetak, N.n_sts_permohonan,
            L.trkelompok_perizinan_id idkelompok,
            E.telp_pemohon, A.kd_gerai
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
            INNER JOIN trkelompok_perizinan_trperizinan L ON L.trperizinan_id = C.id
            INNER JOIN tmpermohonan_trstspermohonan M ON A.id = M.tmpermohonan_id
            INNER JOIN trstspermohonan N ON M.trstspermohonan_id = N.id
            /* INNER JOIN trperizinan_user AS M ON M.trperizinan_id = C.id */
            WHERE A.c_pendaftaran = 1
            AND A.c_izin_dicabut = 0
            AND A.c_izin_selesai = 0
			AND N.id = 8
			AND A.kd_gerai = '" . $username->lokasi . "'
            /* AND M.user_id = '" . $username->id . "' */
            AND A.d_terima_berkas between '$tgla' and '$tglb'
            order by A.id DESC";
		}

        $data['list'] = $query;
		$data['lokasi_user'] = $lokasi_user;
		$data['realname'] = $realname;

        $this->load->vars($data);

        $js =  "
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
                });
                ";

        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "Pencetakan Lampiran Berita Acara Penyerahan Berkas Permohonan";
        $this->template->build('list_penyerahan_berkas', $this->session_info);
    }

	public function cetak_izin_baru($cek_status = NULL, $tgla = NULL, $tglb = NULL) {
        if($cek_status == 0) {
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
        } else {
            $data['tgla'] = $tgla;
            $data['tglb'] = $tglb;
	    }
        $username = new user();
        $username->where('username', $this->session->userdata('username'))->get();
        $lokasi_user = $this->session->userdata('lokasi');
        $realname = $this->session->userdata('realname');
        $data['kd_user'] = $username->id;

		if ($lokasi_user === 'Pusat') { // Untuk daerah lain
		//if ($lokasi_user === 'DPMPTSP Prov. tasikmalaya' || $lokasi_user === 'BPMPT Prov. tasikmalaya' || $lokasi_user === 'BPPT Prov. tasikmalaya') {
            $query = "SELECT distinct A.id, A.pendaftaran_id, A.id_lama, A.d_terima_berkas,
                  A.d_perubahan, A.d_perpanjangan, A.d_daftarulang,
                  C.id idizin, C.n_perizinan, E.n_pemohon, E.no_referensi,
                  G.id idjenis, G.n_permohonan, A.kd_gerai, A.a_izin, A.c_cetak, A.keterangan
                  FROM tmpermohonan as A
                  INNER JOIN tmpermohonan_trperizinan as B ON B.tmpermohonan_id = A.id
                  INNER JOIN trperizinan as C ON B.trperizinan_id = C.id
                  INNER JOIN tmpemohon_tmpermohonan as D ON D.tmpermohonan_id = A.id
                  INNER JOIN tmpemohon as E ON D.tmpemohon_id = E.id
                  INNER JOIN tmpermohonan_trjenis_permohonan as F ON F.tmpermohonan_id = A.id
                  INNER JOIN trjenis_permohonan as G ON F.trjenis_permohonan_id = G.id
                  INNER JOIN trperizinan_user AS H ON  H.trperizinan_id = C.id
				  INNER JOIN tmpermohonan_trstspermohonan as I ON I.tmpermohonan_id = A.id
                  WHERE A.c_pendaftaran = 1
                  AND A.c_izin_dicabut = 0
                  AND A.c_izin_selesai = 0
				  AND H.user_id = '".$username->id."'
                  AND A.d_terima_berkas between '$tgla' and '$tglb'
				  AND I.trstspermohonan_id = 3
                  order by A.id DESC";
        } else {
            $query = "SELECT distinct A.id, A.pendaftaran_id, A.id_lama, A.d_terima_berkas,
                  A.d_perubahan, A.d_perpanjangan, A.d_daftarulang,
                  C.id idizin, C.n_perizinan, E.n_pemohon, E.no_referensi,
                  G.id idjenis, G.n_permohonan, A.kd_gerai, A.a_izin, A.c_cetak, A.keterangan
                  FROM tmpermohonan as A
                  INNER JOIN tmpermohonan_trperizinan as B ON B.tmpermohonan_id = A.id
                  INNER JOIN trperizinan as C ON B.trperizinan_id = C.id
                  INNER JOIN tmpemohon_tmpermohonan as D ON D.tmpermohonan_id = A.id
                  INNER JOIN tmpemohon as E ON D.tmpemohon_id = E.id
                  INNER JOIN tmpermohonan_trjenis_permohonan as F ON F.tmpermohonan_id = A.id
                  INNER JOIN trjenis_permohonan as G ON F.trjenis_permohonan_id = G.id
                  INNER JOIN trperizinan_user AS H ON  H.trperizinan_id = C.id
				  INNER JOIN tmpermohonan_trstspermohonan as I ON I.tmpermohonan_id = A.id
                  WHERE A.c_pendaftaran = 1
                  AND A.c_izin_dicabut = 0
                  AND A.c_izin_selesai = 0
                  AND A.kd_gerai = '$lokasi_user'
                  AND H.user_id = '".$username->id."'
                  AND A.d_terima_berkas between '$tgla' and '$tglb'
				  AND I.trstspermohonan_id = 3
                  order by A.id DESC";
        }

        $data['list'] = $query;
		$data['lokasi_user'] = $lokasi_user;
		$data['realname'] = $realname;

        $this->load->vars($data);

        $js =  "
		        $(document).ready(function() {
					    $('#form').validate();
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
                });

                function check_uncheckAll(field,nilai) {
					for(i=0; i< field.length; i++) {
						field[i].checked=nilai;
					}
				}

                ";

        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "Pencetakan Data Permohonan Izin Baru";
        $this->template->build('list_permohonan_izin_baru', $this->session_info);
    }

	public function cetak_On($id_daftar = NULL, $tgla = NULL, $tglb = NULL, $control = NULL) {
		//  Dapat digunakan untuk cek pencetakan
		$username = new user();
        $username->where('username', $this->session->userdata('username'))->get();
        $daftar = new tmpermohonan();
        $daftar->get_by_id($id_daftar);
        $daftar->c_cetak = $username->id;
        $daftar->save();
		if($control == "1") redirect('monitoring/cetak_izin_baru/1/' . $tgla .'/'. $tglb);
		if($control == "2") redirect('monitoring/cetak_penyerahan_izin/1/' . $tgla .'/'. $tglb);
	}

	public function cetak_of($id_daftar = NULL, $tgla = NULL, $tglb = NULL, $control = NULL) {
		$daftar = new tmpermohonan();
        $daftar->get_by_id($id_daftar);
        $daftar->c_cetak = 0;
        $daftar->save();
		if($control == "1") redirect('monitoring/cetak_izin_baru/1/' . $tgla .'/'. $tglb);
		if($control == "2") redirect('monitoring/cetak_penyerahan_izin/1/' . $tgla .'/'. $tglb);
	}

    public function perhubungan() {
		$username = new user();
        $username->where('username', $this->session->userdata('username'))->get();
		$data['lokasi'] = $username->lokasi;
		$data['cek_sektor'] = $username->sektor;
		//$data['list_data'] = $this->dbmodel_akdp->dbakdp_sql("select * from wilayah");
        $today = date('Y-m-d');
        $first_date = $this->input->post('first_date') == null ? $this->lib_date->set_date(date('Y-m-d'), -2) : $this->input->post('first_date');
        $second_date = $this->input->post('second_date') == null ? $this->lib_date->set_date(date('Y-m-d'), 0) : $this->input->post('second_date');
        $list_state = $this->input->post('list_state');
        $mark = $this->input->post('mark');
        $stspermohonan = new trstspermohonan();
        $data['list_state'] = $list_state;
        $data['first_date'] = $first_date;
        $data['second_date'] = $second_date;
        $data['mark'] = $mark;
        $data['sekarang'] = $today;
        $obj = $this->permohonan;
		if ($list_state == '0') {  // jika SK
			//$data['list_data'] = $this->dbmodel_akdp->dbakdp_sql("select * from akdpkendaraan where tgl_penetepan >= '".$first_date."' AND tgl_penetepan <= '".$second_date."'");
    		//$data['jumlah'] = $this->dbmodel_akdp->dbakdp_sql_hit("select * from akdpkendaraan where tgl_penetepan >= '".$first_date."' AND tgl_penetepan <= '".$second_date."'");
			$data['list_data'] = $this->dbmodel_akdp->dbakdp_sql("select * from akdpkendaraan where tgl_sk >= '".$first_date."' AND tgl_sk <= '".$second_date."'");
    		$data['jumlah'] = $this->dbmodel_akdp->dbakdp_sql_hit("select * from akdpkendaraan where tgl_sk >= '".$first_date."' AND tgl_sk <= '".$second_date."'");
		}else{                     // jika KP
            //$data['list_data'] = $this->dbmodel_akdp->dbakdp_sql("select * from akdpkendaraan where tgl_penetapan_kp >= '".$first_date."' AND tgl_penetapan_kp <= '".$second_date."'");
		    //$data['jumlah'] = $this->dbmodel_akdp->dbakdp_sql_hit("select * from akdpkendaraan where tgl_penetapan_kp >= '".$first_date."' AND tgl_penetapan_kp <= '".$second_date."'");
			$data['list_data'] = $this->dbmodel_akdp->dbakdp_sql("select * from akdpkendaraan where tgl_kp_awal >= '".$first_date."' AND tgl_kp_awal <= '".$second_date."'");
		    $data['jumlah'] = $this->dbmodel_akdp->dbakdp_sql_hit("select * from akdpkendaraan where tgl_kp_awal >= '".$first_date."' AND tgl_kp_awal <= '".$second_date."'");
        }
        
        $this->load->vars($data);

        $js = "
               $(document).ready(function() {
                   oTable = $('#monitoring').dataTable({
                       \"bJQueryUI\": true,
                       \"sPaginationType\": \"full_numbers\"
                   });
               });

               $(document).ready(function() {
                   $('.monbulan').datepicker({
                       changeMonth: true,
                       changeYear: true,
                       dateFormat: 'yy-mm-dd',
                       closeText: 'X'
                   });

               });

               function finishAjax(id, response){
                   $('#'+id).html(unescape(response));
                   $('#'+id).fadeIn();
               }

              ";
        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "Monitoring Perizinan Bidang Perhubungan ";
		$this->template->build('list_perhubungan', $this->session_info);
    }

	public function perhubungan_all_old() {
		$sql = $this->sql_info_viewdata();
        //$data = $this->db->query($sql)->result();
		$data = $this->dbmodel_akdp->dbakdp_sql($sql);
        $data['list_data'] = $data;

        $this->load->vars($data);

        $js = "$(document).ready(function() {
                   oTable = $('#listdataakdp').dataTable({
                            \"bJQueryUI\": true,
                            \"sPaginationType\": \"full_numbers\"
                   });
                } );
                ";
        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "Monitoring Perizinan Bidang Perhubungan";
        $this->template->build('list_perhubungan_all', $this->session_info);
    }

	public function perhubungan_allOLD() {
		$username = new user();
        $username->where('username', $this->session->userdata('username'))->get();
        $kt_cari = $this->input->post('kt_cari');
        $data['kt_cari'] = $kt_cari;
		$data['lokasi'] = $username->lokasi;
		$data['cek_sektor'] = $username->sektor;
        $today = date('Y-m-d');
        $first_date = $this->input->post('first_date') == null ? $this->lib_date->set_date(date('Y-m-d'), -2) : $this->input->post('first_date');
        $second_date = $this->input->post('second_date') == null ? $this->lib_date->set_date(date('Y-m-d'), 0) : $this->input->post('second_date');
        $list_state = $this->input->post('list_state');
        $mark = $this->input->post('mark');
        $stspermohonan = new trstspermohonan();
        $data['list_state'] = $list_state;
        $data['first_date'] = $first_date;
        $data['second_date'] = $second_date;
        $data['mark'] = $mark;
        $data['sekarang'] = $today;
        $obj = $this->permohonan;

		if($kt_cari != ''){
            switch ($list_state) {
                case 0:    // untuk nomor kendaraan
                    $data['list_data'] = $this->dbmodel_akdp->dbakdp_sql("select * from akdpkendaraan where no_kend LIKE '%".$kt_cari."%'");
                    $data['jumlah'] = $this->dbmodel_akdp->dbakdp_sql_hit("select * from akdpkendaraan where no_kend LIKE '%".$kt_cari."%'");
                    break;
                case 1:    // untuk nomor uji
                    $data['list_data'] = $this->dbmodel_akdp->dbakdp_sql("select * from akdpkendaraan where no_uji LIKE '%".$kt_cari."%'");
                    $data['jumlah'] = $this->dbmodel_akdp->dbakdp_sql_hit("select * from akdpkendaraan where no_uji LIKE '%".$kt_cari."%'");
					break;
				case 2:    // untuk nomor SK
                    $data['list_data'] = $this->dbmodel_akdp->dbakdp_sql("select * from akdpkendaraan where no_sk LIKE '%".$kt_cari."%'");
                    $data['jumlah'] = $this->dbmodel_akdp->dbakdp_sql_hit("select * from akdpkendaraan where no_sk LIKE '%".$kt_cari."%'");
					break;
				case 3:    // untuk nomor KP
                    $data['list_data'] = $this->dbmodel_akdp->dbakdp_sql("select * from akdpkendaraan where no_kp LIKE '%".$kt_cari."%'");
                    $data['jumlah'] = $this->dbmodel_akdp->dbakdp_sql_hit("select * from akdpkendaraan where no_kp LIKE '%".$kt_cari."%'");
					break;
				case 4:    // untuk nama pemilik
                    $data['list_data'] = $this->dbmodel_akdp->dbakdp_sql("select * from akdpkendaraan where nama_pemilik LIKE '%".$kt_cari."%'");
                    $data['jumlah'] = $this->dbmodel_akdp->dbakdp_sql_hit("select * from akdpkendaraan where nama_pemilik LIKE '%".$kt_cari."%'");
					break;
				case 5:    // untuk nama perusahaan
                    $data['list_data'] = $this->dbmodel_akdp->dbakdp_sql("select * from akdpkendaraan where nama_perusahaan LIKE '%".$kt_cari."%'");
                    $data['jumlah'] = $this->dbmodel_akdp->dbakdp_sql_hit("select * from akdpkendaraan where nama_perusahaan LIKE '%".$kt_cari."%'");
					break; 
           }
		}else{
			$data['list_data'] = $this->dbmodel_akdp->dbakdp_sql("select * from akdpkendaraan where no_kend = '".$kt_cari."'");
        	$data['jumlah'] = $this->dbmodel_akdp->dbakdp_sql_hit("select * from akdpkendaraan where no_kend = '".$kt_cari."'");
		}
        
        $this->load->vars($data);

        $js = "
               $(document).ready(function() {
                   oTable = $('#monitoring').dataTable({
                       \"bJQueryUI\": true,
                       \"sPaginationType\": \"full_numbers\"
                   });
               });

               $(document).ready(function() {
                   $('.monbulan').datepicker({
                       changeMonth: true,
                       changeYear: true,
                       dateFormat: 'yy-mm-dd',
                       closeText: 'X'
                   });

               });

			   $('#xpropinsi_pemohon_id').change(function(){
                   $.post('" . base_url() . "monitoring/monitoring/xcek_katagori', { list_state: $('#xpropinsi_pemohon_id').val() },
                       function(data) {
                           $('#show_kabupaten_pemohon').html('Data Tidak tersedia');
                           $('#show_kecamatan_pemohon').html('Data Tidak tersedia');
                           $('#show_kelurahan_pemohon').html('Data Tidak tersedia');
                       }
				   );
               });

               function finishAjax(id, response){
                   $('#'+id).html(unescape(response));
                   $('#'+id).fadeIn();
               }

              ";
        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "Monitoring Perhubungan per Kategori";
		$this->template->build('list_perhubungan_cari', $this->session_info);
    }

	public function perhubungan_all() {
		//$_SESSION['coba'] = "INI PERCOBAAN"; // cara memanggil $_SESSION['coba']
		//$katagori = $this->input->post('katagori');
        $username = new user();
        $username->where('username', $this->session->userdata('username'))->get();
        $kt_cari = $this->input->post('kt_cari');
		$refresh = $this->input->post('refresh');
		$kd_trayek = $this->input->post('jenis_trayek');
		$xgroup = $this->input->post('xgroup');
		if($refresh == NULL) $data['refresh'] = FALSE; else $data['refresh'] = $refresh;
		$data['kt_cari'] = $kt_cari;
		$data['kat_cari']   = $this->kat_cari;
		$data['lokasi'] = $username->lokasi;
		$data['cek_sektor'] = $username->sektor;
        $today = date('Y-m-d');
        $first_date = $this->input->post('first_date') == null ? $this->lib_date->set_date(date('Y-m-d'), -2) : $this->input->post('first_date');
        $second_date = $this->input->post('second_date') == null ? $this->lib_date->set_date(date('Y-m-d'), 0) : $this->input->post('second_date');
        $list_state = $this->input->post('list_state');
        $mark = $this->input->post('mark');
        $stspermohonan = new trstspermohonan();
        $data['list_state'] = $list_state;
        $data['first_date'] = $first_date;
        $data['second_date'] = $second_date;
        $data['mark'] = $mark;
        $data['sekarang'] = $today;
		$data['xgroup'] = $xgroup;
        $obj = $this->permohonan;

        $n_ket = '';
		if($kt_cari != '' || $list_state == '6' || $list_state == '7') $pilih = TRUE; else $pilih = FALSE;
		if($xgroup == '0'){  // Untuk Kendaraan Kecil
            if($pilih){
                switch ($list_state) {
                case 0:    // untuk nomor kendaraan
                    $d_list_data = "select * from akdpkendaraan where no_kend LIKE '%".$kt_cari."%'";
                    break;
                case 1:    // untuk nomor uji
                    $d_list_data = "select * from akdpkendaraan where no_uji LIKE '%".$kt_cari."%'";
					break;
				case 2:    // untuk nomor SK
                    $d_list_data = "select * from akdpkendaraan where no_sk LIKE '%".$kt_cari."%'";
					break;
				case 3:    // untuk nomor KP
                    $d_list_data = "select * from akdpkendaraan where no_kp LIKE '%".$kt_cari."%'";
					break;
				case 4:    // untuk nama pemilik
                    $d_list_data = "select * from akdpkendaraan where nama_pemilik LIKE '%".$kt_cari."%'";
					break;
				case 5:    // untuk nama perusahaan
                    $d_list_data = "select * from akdpkendaraan where nama_perusahaan LIKE '%".$kt_cari."%'";
					break; 
				case 6:    // untuk Tanggal Cetak SK
                    $d_list_data = "select * from akdpkendaraan where tgl_penetapan >= '".$first_date."' AND tgl_penetapan <= '".$second_date."'";
					break;
				case 7:    // untuk Tanggal Cetak KP
                    $d_list_data = "select * from akdpkendaraan where tgl_penetapan_kp >= '".$first_date."' AND tgl_penetapan_kp <= '".$second_date."'";
					break;
				case 8:    // untuk Lintasan Trayek
				    foreach ($this->dbmodel_akdp->dbakdp_sql("select * from akdptrayek where kode_trayek = '".$kt_cari."'") as $row){
                        if($row->kode_trayek == $kt_cari) $n_ket = $row->trayek;
					}
                    $d_list_data = "select * from akdpkendaraan where kode_trayek = '".$kt_cari."'";
					break;
                }
		    }else{
			    $d_list_data = "select * from akdpkendaraan where no_kend = '".$kt_cari."'";
		    }
			$list_data = $this->dbmodel_akdp->dbakdp_sql($d_list_data);
            $jumlah    = $this->dbmodel_akdp->dbakdp_sql_hit($d_list_data);
		}else{ // Untuk Kendaraan Besar
            if($pilih){
				$d_list_data = "select A.NO_MOBIL, A.NO_UJI, A.NO_SK, A.NOMOR_KP, A.TG_MULAI, A.TG_AKHIR, A.TG_SK, A.TG_KPSK,
					            B.NAMA_PEMIL, B.NAMA_PERUS, C.TAHUN_PEMB, C.MERK, C.JENIS
								from kp as A 
					            JOIN pau as B on A.PAU_ID = B.PAU_ID 
								JOIN mobil as C on A.NO_MOBIL = C.NO_MOBIL ";
                switch ($list_state) {
                case 0:    // untuk nomor kendaraan
					$d_list_data .= "where A.NO_MOBIL LIKE '%".$kt_cari."%'";
                    break;
                case 1:    // untuk nomor uji
                    $d_list_data .= "where A.NO_UJI LIKE '%".$kt_cari."%'";
					break;
				case 2:    // untuk nomor SK
                    $d_list_data .= "where A.NO_SK LIKE '%".$kt_cari."%'";
					break;
				case 3:    // untuk nomor KP
                    $d_list_data .= "where A.NOMOR_KP LIKE '%".$kt_cari."%'";
					break;
				case 4:    // untuk nama pemilik
                    $d_list_data .= "where B.NAMA_PEMIL LIKE '%".$kt_cari."%'";   
					break;
				case 5:    // untuk nama perusahaan
                    $d_list_data .= "where B.NAMA_PERUS LIKE '%".$kt_cari."%'";
					break; 
				case 6:    // untuk Tanggal Cetak SK
                    $d_list_data .= "where A.TG_SK >= '".$first_date."' AND A.TG_SK <= '".$second_date."'";
					break;
				case 7:    // untuk Tanggal Cetak KP
                    $d_list_data .= "where A.TG_MULAI >= '".$first_date."' AND A.TG_MULAI <= '".$second_date."'";
					break;
				case 8:    // untuk Lintasan Trayek
				    foreach ($this->dbmodel_bisbesar->db_sql("select * from traak where KODE_TRAYE = '".$kt_cari."'") as $row){
                        if($row->KODE_TRAYE == $kt_cari) $n_ket = $row->NAMA_TRAYE;
					}
                    $d_list_data .= "where A.KODE_TRAYE = '".$kt_cari."'";
					break;
                }
		    }else{
			    $d_list_data = "select * from kp where NO_MOBIL = '".$kt_cari."'";
		    }
            $list_data = $this->dbmodel_bisbesar->db_sql($d_list_data);
            $jumlah    = $this->dbmodel_bisbesar->db_sql_hit($d_list_data);
		}

        $data['n_ket'] = $n_ket;        
		$data['list_data'] = $list_data;
        $data['jumlah']    = $jumlah;
        
		$username = new user();
        $username->where('username', $this->session->userdata('username'))->get();
		$this->lib_date->post_variable($username->id, '', '', '', '', '', '', $first_date, $second_date, $d_list_data, $d_list_data);   // post variable
        
		$this->load->vars($data);

		$js = "
		       $(document).ready(function() {
				   oTable = $('#monitoring').dataTable({
                       \"bJQueryUI\": true,
                       \"sPaginationType\": \"full_numbers\"
                   });

                    $('.monbulan').datepicker({
                        changeMonth: true,
                        changeYear: true,
                        dateFormat: 'yy-mm-dd',
                        closeText: 'X'
                    });                   
                    
					$('#katagori_id').change(function(){
                        $.post('" . base_url() . "monitoring/monitoring/cek_katagori', { katagori: $('#katagori_id').val(), xgroup: $('#xgroup_id').val() },
                            function(data) {
                                            $('#show_katagori_1').html(data);
                                            $('#show_katagori_2').html('');
                                            $('#show_katagori_3').html('');
                            }
						);
                    });
					
					$('#xgroup_id').change(function(){
                        $.post('" . base_url() . "monitoring/monitoring/cek_katagori', { katagori: $('#katagori_id').val(), xgroup: $('#xgroup_id').val() },
                            function(data) {
                                            $('#show_katagori_1').html(data);
                                            $('#show_katagori_2').html('');
                                            $('#show_katagori_3').html('');
                            }
						);
                    });

                }); 
			  ";
        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "Monitoring Perhubungan per Kategori ";
        $this->template->build('list_perhubungan_cari', $this->session_info);
    }

	public function cek_katagori() {    // masuk setelah pilih kategori
	    //$list_izin = $this->dbmodel_akdp->dbakdp_sql("select * from akdptrayek");
		$katagori = $_REQUEST['katagori'];
		$xgroup = $_REQUEST['xgroup'];
		if($xgroup == 0) {
		    $list_trayek = $this->dbmodel_akdp->dbakdp_sql("select * from akdptrayek");
	    }else{
			$list_trayek = $this->dbmodel_bisbesar->db_sql("select * from traak");
		}
		$first_date = $this->input->post('first_date') == null ? $this->lib_date->set_date(date('Y-m-d'), -2) : $this->input->post('first_date');
		$second_date = $this->input->post('second_date') == null ? $this->lib_date->set_date(date('Y-m-d'), 0) : $this->input->post('second_date');
	    $kt_cari = $this->input->post('kt_cari');
		
		$data['xgroup'] = $xgroup;
		$data['katagori'] = $katagori;
		$data['first_date'] = $first_date;
		$data['second_date'] = $second_date;
        $data['kt_cari'] = $kt_cari;
	    $data['kat_cari'] = $this->kat_cari;
		$data['katagori_1'] = 'katagori_1';
		$data['list_trayek'] = $list_trayek;
		$this->load->view('kategori_load', $data);
    }
    
	public function cetak_perhubungan() { // cetak list perhubungan ke Excel
	    header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=dataxl.xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        
		$username = new user();
        $username->where('username', $this->session->userdata('username'))->get();
		$first_date = $username->gvar7;
		$second_date = $username->gvar8;
		$d_list_data = $username->gvar9;
		$d_jumlah = $username->gvar10;
		$list_data = $this->dbmodel_akdp->dbakdp_sql($d_list_data);
        $jumlah    = $this->dbmodel_akdp->dbakdp_sql_hit($d_jumlah);

		$jdl_laporan = 'DAFTAR IZIN PERHUBUNGAN';
        
		$jdl = "<tr>
		         <td>".'NO.'."</td>
                 <td>".'NAMA PERUSAHAAN/PEMILIK KENDARAAN'."</td>
			     <td>".'NOMOR KENDARAAN'."</td>
    			 <td>".'NOMOR UJI'."</td>
				 <td>".'TANGGAL CETAK'."</td>
                 <td>".'SK/KP'."</td>
			     <td>".'KETERANGAN'."</td>
				</tr>";

        echo "<table width='100%' border='0' font-size:16px;'>";
		echo $jdl_laporan;
		echo "<tr>PERIODE : ".$this->lib_date->mysql_to_human($first_date)." - ".$this->lib_date->mysql_to_human($second_date)."</tr>";
		//echo "<tr>ASAL PERMOHONAN : ".'$ngerai'."</tr>";
		echo "</table>";
		echo "<table width='100%' cellspacing='0' cellpadding='0' border='1' style='border-style:solid; border-width:thin;font-size:10px;'>";
	    echo $jdl; 

	    $i=0;
		foreach ($list_data as $row){
			$i++;
			$skkp = 'SK / KP';
			if($row->tgl_sk == $row->tgl_kp_awal){
				$skkp = 'KP';
			}
			$isi = "<tr>
                      <td>".$i."</td>
			          <td>".$row->nama_pemilik."</td>
					  <td>".$row->no_kend."</td>
            		  <td>".$row->no_uji."</td>
                      <td>".$row->tgl_kp_awal."</td>
					  <td>".$skkp."</td>
					  <td>".''."</td>
				    </tr>";
            echo $isi;
        }
        echo "</table>";
	}

	public function perhubungan_kdtrayek() {
		$username = new user();
        $username->where('username', $this->session->userdata('username'))->get();
		$data['lokasi'] = $username->lokasi;
		$data['cek_sektor'] = $username->sektor;
        $today = date('Y-m-d');
        $first_date = $this->input->post('first_date') == null ? $this->lib_date->set_date(date('Y-m-d'), -2) : $this->input->post('first_date');
        $second_date = $this->input->post('second_date') == null ? $this->lib_date->set_date(date('Y-m-d'), 0) : $this->input->post('second_date');
        $list_state = $this->input->post('list_state');
        $mark = $this->input->post('mark');
        $stspermohonan = new trstspermohonan();
        $data['list_state'] = $list_state;
        $data['first_date'] = $first_date;
        $data['second_date'] = $second_date;
        $data['mark'] = $mark;
        $data['sekarang'] = $today;
        $obj = $this->permohonan;
		if ($list_state == '0') {  // jika SK
			//$data['list_data'] = $this->dbmodel_akdp->dbakdp_sql("select * from akdpkendaraan where tgl_penetepan >= '".$first_date."' AND tgl_penetepan <= '".$second_date."'");
    		//$data['jumlah'] = $this->dbmodel_akdp->dbakdp_sql_hit("select * from akdpkendaraan where tgl_penetepan >= '".$first_date."' AND tgl_penetepan <= '".$second_date."'");
			$data['list_data'] = $this->dbmodel_akdp->dbakdp_sql("select * from akdpkendaraan where tgl_sk >= '".$first_date."' AND tgl_sk <= '".$second_date."'");
    		$data['jumlah'] = $this->dbmodel_akdp->dbakdp_sql_hit("select * from akdpkendaraan where tgl_sk >= '".$first_date."' AND tgl_sk <= '".$second_date."'");
		}else{                     // jika KP
            //$data['list_data'] = $this->dbmodel_akdp->dbakdp_sql("select * from akdpkendaraan where tgl_penetapan_kp >= '".$first_date."' AND tgl_penetapan_kp <= '".$second_date."'");
		    //$data['jumlah'] = $this->dbmodel_akdp->dbakdp_sql_hit("select * from akdpkendaraan where tgl_penetapan_kp >= '".$first_date."' AND tgl_penetapan_kp <= '".$second_date."'");
			$data['list_data'] = $this->dbmodel_akdp->dbakdp_sql("select * from akdpkendaraan where tgl_kp_awal >= '".$first_date."' AND tgl_kp_awal <= '".$second_date."'");
		    $data['jumlah'] = $this->dbmodel_akdp->dbakdp_sql_hit("select * from akdpkendaraan where tgl_kp_awal >= '".$first_date."' AND tgl_kp_awal <= '".$second_date."'");
        }
        
        $this->load->vars($data);

        $js = "
               $(document).ready(function() {
                   oTable = $('#monitoring').dataTable({
                       \"bJQueryUI\": true,
                       \"sPaginationType\": \"full_numbers\"
                   });
               });

               $(document).ready(function() {
                   $('.monbulan').datepicker({
                       changeMonth: true,
                       changeYear: true,
                       dateFormat: 'yy-mm-dd',
                       closeText: 'X'
                   });

               });

               function finishAjax(id, response){
                   $('#'+id).html(unescape(response));
                   $('#'+id).fadeIn();
               }

              ";
        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "Monitoring Perhubungan per Trayek";
		$this->template->build('list_perhubungan_kdtrayek', $this->session_info);
    }

    public function perhubungan_terminaltrayek() {
      $db_akdp = $this->load->database('dbakdp',true);
      $username = new user();
      $username->where('username', $this->session->userdata('username'))->get();
      $data['lokasi'] = $username->lokasi;
      $data['cek_sektor'] = $username->sektor;
      $today = date('Y-m-d');
      $first_date = $this->input->post('first_date');
      $second_date = $this->input->post('second_date');
      $mark = $this->input->post('mark');
      $stspermohonan = new trstspermohonan();
      $data['first_date'] = $first_date;
      $data['second_date'] = $second_date;
      $data['mark'] = $mark;
      $data['sekarang'] = $today;
      $obj = $this->permohonan;

      if ((!empty($first_date) || $first_date != 0) && (!empty($second_date) || $second_date != 0)) {
        $sql = "SELECT A.id, A.kode_trayek, A.trayek, SUM(CASE WHEN (B.tgl_penetepan BETWEEN ? AND ?) AND B.kode_trayek IS NOT NULL THEN 1 ELSE 0 END) as jml FROM akdptrayek A
        LEFT OUTER JOIN akdpkendaraan B ON B.kode_trayek = A.kode_trayek
        GROUP BY A.id, B.kode_trayek
        ORDER BY A.kode_trayek";

        $data['list_data'] = $db_akdp->query($sql, array($first_date, $second_date))->result();

        //var_dump($this->db->last_query());die;
      } else {
        $sql = "SELECT A.id, A.kode_trayek, A.trayek, COUNT(B.kode_trayek) as jml FROM akdptrayek A
        LEFT JOIN akdpkendaraan B ON B.kode_trayek = A.kode_trayek
        GROUP BY A.id, B.kode_trayek
        ORDER BY A.kode_trayek";

        $data['list_data'] = $db_akdp->query($sql)->result();
      }
      
        
      $this->load->vars($data);

      $js = "
               $(document).ready(function() {
                   oTable = $('#monitoring').dataTable({
                       \"bJQueryUI\": true,
                       \"sPaginationType\": \"full_numbers\"
                   });
               });

               $(document).ready(function() {
                   $('.monbulan').datepicker({
                       changeMonth: true,
                       changeYear: true,
                       dateFormat: 'yy-mm-dd',
                       closeText: 'X'
                   });

               });

               function finishAjax(id, response){
                   $('#'+id).html(unescape(response));
                   $('#'+id).fadeIn();
               }

              ";
      $this->template->set_metadata_javascript($js);
      $this->session_info['page_name'] = "Monitoring Perhubungan Per Terminal/Trayek";
      $this->template->build('list_perhubungan_terminaltrayek', $this->session_info);
    }

    public function terminaltrayek_detail($id, $first_date, $second_date) {
      $db_akdp = $this->load->database('dbakdp',true);
      $username = new user();
      $username->where('username', $this->session->userdata('username'))->get();
      $data['lokasi'] = $username->lokasi;
      $data['cek_sektor'] = $username->sektor;
      $today = date('Y-m-d');
      $mark = $this->input->post('mark');
      $stspermohonan = new trstspermohonan();
      $data['first_date'] = $first_date;
      $data['second_date'] = $second_date;
      $data['mark'] = $mark;
      $data['sekarang'] = $today;
      $obj = $this->permohonan;

      if ((!empty($first_date) || $first_date != 0) && (!empty($second_date) || $second_date != 0)) {
        $sql = "SELECT A.id, A.kode_trayek, A.trayek, B.* FROM akdptrayek A
        RIGHT JOIN akdpkendaraan B ON B.kode_trayek = A.kode_trayek
        WHERE A.id = ? AND B.tgl_penetepan BETWEEN ? AND ?
        ORDER BY B.no_induk";

        $data['list_data'] = $db_akdp->query($sql, array($id, $first_date, $second_date))->result();

      } else {
        $sql = "SELECT A.id, A.kode_trayek, A.trayek, B.* FROM akdptrayek A
        RIGHT JOIN akdpkendaraan B ON B.kode_trayek = A.kode_trayek
        WHERE A.id = ?
        ORDER BY B.no_induk";

        $data['list_data'] = $db_akdp->query($sql, $id)->result();
      }


      
        
      $this->load->vars($data);

      $js = "
               $(document).ready(function() {
                   oTable = $('#monitoring').dataTable({
                       \"bJQueryUI\": true,
                       \"sPaginationType\": \"full_numbers\"
                   });
               });

               $(document).ready(function() {
                   $('.monbulan').datepicker({
                       changeMonth: true,
                       changeYear: true,
                       dateFormat: 'yy-mm-dd',
                       closeText: 'X'
                   });

               });

               function finishAjax(id, response){
                   $('#'+id).html(unescape(response));
                   $('#'+id).fadeIn();
               }

              ";
      $this->template->set_metadata_javascript($js);
      $this->session_info['page_name'] = "Detail Monitoring Perhubungan Per Terminal/Trayek";
      $this->template->build('list_perhubungan_detailtrayek', $this->session_info);
    }

  public function perketegori_tertentu() {
    $username = new user();
    $username->where('username', $this->session->userdata('username'))->get();
    $id_user = $username->id;
    $lokasi_user = $this->session->userdata('lokasi');
    $group = $username->group;
    
    $list_state = $this->input->post('list_state');//echo $list_state; die;
    $kt_cari = $this->input->post('kt_cari');
    
    $mark = $this->input->post('mark');
    if($list_state) {
      $this->lib_date->post_variable($username->id, '', '', '', '', '', '', '', $list_state, $kt_cari, '');   // post variable
    }else{
      $list_state = 1; //$username->gvar8;
      if($list_state == '') $list_state = 1;
      $kt_cari = '';   //$username->gvar9;
    }
    $data['kt_cari'] = $kt_cari;
    $data['list_state'] = $list_state;
    
    switch($list_state) {
      case 1:    // untuk Nomor Pendaftaran
        If(!$kt_cari)
          $where = "WHERE A.pendaftaran_id LIKE '%xxxxxx%'";
        else
          $where = "WHERE A.pendaftaran_id LIKE '%".$kt_cari."%'";
        break;
      case 2:    // untuk Nomor SK
        If(!$kt_cari)
          $where = "INNER JOIN tmpermohonan_tmsk as H on H.tmpermohonan_id = A.id
                    INNER JOIN tmsk as I on I.id = H.tmsk_id 
                    WHERE I.no_surat_edit = 'xxxxxx'";
        else
          $where = "INNER JOIN tmpermohonan_tmsk as H on H.tmpermohonan_id = A.id
                    INNER JOIN tmsk as I on I.id = H.tmsk_id 
                    WHERE I.no_surat_edit LIKE '%".$kt_cari."%' OR I.no_surat LIKE '%".$kt_cari."%'";
        break;  
      case 3:    // untuk Nama Pemohon
        If(!$kt_cari)
          $where = "INNER JOIN tmpemohon_tmpermohonan as H on H.tmpermohonan_id = A.id
                    INNER JOIN tmpemohon as I on I.id = H.tmpemohon_id 
                    WHERE I.n_pemohon = 'xxxxxx'";
        else
          $where = "INNER JOIN tmpemohon_tmpermohonan as H on H.tmpermohonan_id = A.id
                    INNER JOIN tmpemohon as I on I.id = H.tmpemohon_id 
                    WHERE I.n_pemohon LIKE '%".$kt_cari."%'";
        break;
      case 4:    // untuk Nama Perusahaan
        If(!$kt_cari)
          $where = "INNER JOIN tmpermohonan_tmperusahaan as H on H.tmpermohonan_id = A.id
                    INNER JOIN tmperusahaan as I on I.id = H.tmperusahaan_id 
                    WHERE I.n_perusahaan = 'xxxxxx'";
        else
          $where = "INNER JOIN tmpermohonan_tmperusahaan as H on H.tmpermohonan_id = A.id
                    INNER JOIN tmperusahaan as I on I.id = H.tmperusahaan_id 
                    WHERE I.n_perusahaan LIKE '%".$kt_cari."%'";
        break;
      case 5:    // untuk Objek Izin
        If(!$kt_cari)
          $where = "WHERE A.a_izin = 'xxxxxxx'";
        else
          $where = "WHERE A.a_izin LIKE '%".$kt_cari."%'";
        break;
    }
        
    if($this->All) {
      $query = "SELECT distinct A.id, A.pendaftaran_id, A.id_lama, A.d_terima_berkas, A.d_terima_berkas_asli, A.a_izin, A.kd_status, A.d_selesai_proses,
    	          A.c_izin_selesai, A.d_perubahan, A.d_perpanjangan, A.d_daftarulang, B.trperizinan_id, A.keterangan, A.status_berkas, A.desc_arsip, A.nama_file,
                C.id idizin, C.n_perizinan, C.bid_teknis, E.n_pemohon, E.a_pemohon, D.tmpermohonan_id, E.no_referensi,
                G.id idjenis, G.n_permohonan, A.kd_gerai, A.dt_teknis1
                FROM tmpermohonan as A
                INNER JOIN tmpermohonan_trperizinan as B ON B.tmpermohonan_id = A.id
                INNER JOIN trperizinan as C ON B.trperizinan_id = C.id
                INNER JOIN tmpemohon_tmpermohonan as D ON D.tmpermohonan_id = A.id
                INNER JOIN tmpemohon as E ON D.tmpemohon_id = E.id
                INNER JOIN tmpermohonan_trjenis_permohonan as F ON F.tmpermohonan_id = A.id
                INNER JOIN trjenis_permohonan as G ON F.trjenis_permohonan_id = G.id "
                . $where . " order by A.id DESC";
    }else{
      $query = "SELECT distinct A.id, A.pendaftaran_id, A.id_lama, A.d_terima_berkas, A.d_terima_berkas_asli, A.a_izin, A.kd_status, A.d_selesai_proses,
    	          A.c_izin_selesai, A.d_perubahan, A.d_perpanjangan, A.d_daftarulang, B.trperizinan_id, A.keterangan, A.status_berkas, A.desc_arsip, A.nama_file,
                C.id idizin, C.n_perizinan, C.bid_teknis, E.n_pemohon, E.a_pemohon, D.tmpermohonan_id, E.no_referensi,
                G.id idjenis, G.n_permohonan, A.kd_gerai, A.dt_teknis1
                FROM tmpermohonan as A
                INNER JOIN tmpermohonan_trperizinan as B ON B.tmpermohonan_id = A.id
                INNER JOIN trperizinan as C ON B.trperizinan_id = C.id
                INNER JOIN tmpemohon_tmpermohonan as D ON D.tmpermohonan_id = A.id
                INNER JOIN tmpemohon as E ON D.tmpemohon_id = E.id
                INNER JOIN tmpermohonan_trjenis_permohonan as F ON F.tmpermohonan_id = A.id
                INNER JOIN trjenis_permohonan as G ON F.trjenis_permohonan_id = G.id
    		        INNER JOIN trperizinan_user AS Z ON  Z.trperizinan_id = C.id "
                . $where . " AND Z.user_id = ".$id_user."" . " order by A.id DESC";
    }
    
    $data['list'] = $query;
    $data['group'] = $group;
    $data['id_user'] = $id_user;
    $data['mark'] = $mark;
    $data['admin'] = $this->admin;
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
    $this->session_info['page_name'] = "Monitoring Perizinan per Kategori ";
    $this->template->build('list_kategori_cari', $this->session_info);
  }

	function datatables_viewdata(){
        $iDisplayStart=$this->input->post('iDisplayStart');
        $obj=$this->get_list_viewdata();
        $total=$this->get_total_viewdata();
        if ($obj){
            $i=$iDisplayStart;
            foreach ($obj as $list) {
                //$action = anchor(site_url('info/infotracking/detail') .'/'. $list->id, img($img_info));
				$logo = 'assets/images/icon/information.png';
			    $title = 'Lihat Detail';
				if($list->masa_berlaku < $this->lib_date->get_date_now()){
	    			$logo = 'assets/images/icon/r_information.png';
				    $title = 'Masa Berlaku SK Telah Habis, Lihat Detail?';
				}
				if($list->tgl_kp_akhir < $this->lib_date->get_date_now()){
	    			$logo = 'assets/images/icon/r_information.png';
				    $title = 'Masa Berlaku KP Telah Habis, Lihat Detail?';
				}
				if($list->tgl_kp_akhir < $this->lib_date->get_date_now() && $list->masa_berlaku < $this->lib_date->get_date_now()){
	    			$logo = 'assets/images/icon/r_information.png';
				    $title = 'Masa Berlaku SK dan KP Telah Habis, Lihat Detail?';
				}
				$img_info = array(
                    'src' => base_url().$logo,
                    'alt' => $title,//'Lihat Detail',
                    'title' => $title,
                    'border' => '0',
                );
				$action = '';//anchor(site_url('arsip/edit') .'/L/'. $list->id.'/3', img($img_info))."&nbsp;";
                $i++;
				$aaData[] = array(
                    $i,
                    $list->no_kend .'<br>'. $list->no_uji,
					$list->no_sk,
					$this->lib_date->mysql_to_human($list->tgl_sk) .'<br>'.  $this->lib_date->mysql_to_human($list->masa_berlaku),
					$list->no_kp,
					$this->lib_date->mysql_to_human($list->tgl_kp_awal) .'<br>'. $this->lib_date->mysql_to_human($list->tgl_kp_akhir),
					$list->nama_pemilik,
                    $action
                );
            }
        } else {
            $aaData=array();
        }
        $sOutput = array (
            "sEcho" => $this->input->post('sEcho'),
            "iTotalRecords" => $total,
            "iTotalDisplayRecords" => $total,
            "aaData" => $aaData
        );
		
        echo json_encode($sOutput);
    }

	function get_list_viewdata(){
		//$db_akdp = $this->load->database('dbakdp',true);        // untuk membuka tabel pada database lain
        $sSearch = $this->input->post('sSearch');
        $iDisplayLength = $this->input->post('iDisplayLength');
        $iDisplayStart = $this->input->post('iDisplayStart');
        $sql = $this->sql_info_viewdata();
		// Untuk di filter
		//if ($gerai === '0') {
		//    $sql .= " WHERE t7.id <> 1 AND t1.trsektor_id = '$id_key' AND t1.d_terima_berkas between '$tgla' and '$tglb' ";
		//} else {
		//    $sql .= " WHERE t7.id <> 1 AND t1.kd_gerai = '$gerai' AND t1.trsektor_id = '$id_key' AND t1.d_terima_berkas between '$tgla' and '$tglb' ";
		//}

		//$sql .= $this->menu_filter('1', $menu);
        //$sql .= " WHERE t1.c_izin_dicabut = 0 and t1.c_izin_selesai = 0 ";
//		$sql .= " WHERE no_induk LIKE '%03.%' ";
		$sql .= " WHERE no_kend != ''";
        if($sSearch != NULL){
			$colum = array("no_kend","no_uji","no_sk","tgl_sk","masa_berlaku","no_kp","tgl_kp_awal","tgl_kp_akhir","nama_pemilik");
            $sql .= $this->lib_query->add_searching($colum, 'AND', $sSearch);
        }
        //$sql .=" ORDER BY t1.id DESC ";
        $sql .=" LIMIT  $iDisplayStart,$iDisplayLength";

        //return $this->db->query($sql)->result();
		return $this->dbmodel_akdp->dbakdp_sql($sql);
    }

	function get_total_viewdata(){
        //$db_akdp = $this->load->database('dbakdp',true);        // untuk membuka tabel pada database lain
		$sSearch = $this->input->post('sSearch');
        $sql = $this->sql_info_viewdata();
        //if ($gerai === '0') {
		//    $sql .= " WHERE t7.id <> 1 AND t1.trsektor_id = '$id_key' AND t1.d_terima_berkas between '$tgla' and '$tglb' ";
		//} else {
		//    $sql .= " WHERE t7.id <> 1 AND t1.kd_gerai = '$gerai' AND t1.trsektor_id = '$id_key' AND t1.d_terima_berkas between '$tgla' and '$tglb' ";
		//}
        
		//$sql .= $this->menu_filter('1', $menu);
        //$sql .= " WHERE t1.c_izin_dicabut = 0 and t1.c_izin_selesai = 0 ";
		//$sql .= " WHERE t1.c_pendaftaran = 1 ";
//		$sql .= " WHERE no_induk LIKE '%03.%' ";
        $sql .= " WHERE no_kend != ''";
        if($sSearch != NULL){
			$colum = array("no_kend","no_uji","no_sk","tgl_sk","masa_berlaku","no_kp","tgl_kp_awal","tgl_kp_akhir","nama_pemilik");
            $sql .= $this->lib_query->add_searching($colum, 'AND', $sSearch);
        }
        //$sql .= " ORDER BY t1.id DESC ";

		//return $this->db->query($sql)->num_rows();
		return $this->dbmodel_akdp->dbakdp_sql_hit($sql);
    }

	function sql_info_viewdata(){ // ambil semua data
//        $sql1="
//            SELECT t1.pendaftaran_id, t3.n_perizinan, t1.a_izin, t1.trsektor_id, t1.d_terima_berkas, t1.kd_gerai, 
//			       if(t5.n_pemohon IS NULL, b.n_pemohon, t5.n_pemohon) AS n_pemohon, t13.n_permohonan ,t7.n_sts_permohonan, t1.id FROM tmpermohonan as t1
//                   LEFT JOIN tmpermohonan_trperizinan as t2 on t1.id = t2.tmpermohonan_id
//                   LEFT JOIN trperizinan as t3 on t3.id = t2.trperizinan_id
//                   LEFT JOIN tmpemohon_tmpermohonan as t4 on t4.tmpermohonan_id = t1.id
//                   LEFT JOIN tmpemohon as t5 on t5.id = t4.tmpemohon_id
//                   LEFT JOIN tmpermohonan_trstspermohonan as t6 on t1.id = t6.tmpermohonan_id
//                   LEFT JOIN trstspermohonan as t7 on t7.id = t6.trstspermohonan_id
//                   LEFT JOIN tmpemohon_trkelurahan as t8 ON t8.tmpemohon_id= t5.id
//                   LEFT JOIN trkelurahan as t9 on t9.id = t8.trkelurahan_id
//                   LEFT JOIN tmpermohonan_tmperusahaan as t10 on t10.tmpermohonan_id = t1.id
//                   LEFT JOIN tmperusahaan as t11 on t11.id=t10.tmperusahaan_id
//                   LEFT JOIN tmpermohonan_trjenis_permohonan as t12 on t1.id = t12.tmpermohonan_id
//                   LEFT JOIN trjenis_permohonan as t13 on t12.trjenis_permohonan_id = t13.id
//                   LEFT JOIN tmpemohon_sementara_tmpermohonan AS a ON a.tmpermohonan_id = t1.id
//                   LEFT JOIN tmpemohon_sementara AS b ON b.id = a.tmpemohon_sementara_id
//                   LEFT JOIN tmpermohonan_tmperusahaan_sementara AS c ON t1.id = c.tmpermohonan_id
//                   LEFT JOIN tmperusahaan_sementara AS d ON d.id = c.tmperusahaan_sementara_id
//             ";
        
        $sql="select id, no_induk, no_kend, no_uji, no_sk, tgl_sk, masa_berlaku, no_kp, tgl_kp_awal, tgl_kp_akhir,	nama_pemilik from akdpkendaraan";
        return $sql;
    }

  public function integrasi() {
    //$tgla = $this->input->post('tgla');
    //$tglb = $this->input->post('tglb');
    //$now = $this->lib_date->get_date_now();
    //$tgl_before = $this->lib_date->set_date($now, -40);
    //$tgl_now = $this->lib_date->set_date($now, 0);
    
    //if($tgla && $tglb){
    //  $data['tgla'] = $tgla;
    //  $data['tglb'] = $tglb;
    //}else{
    //  $tgla = $tgl_before;
    //  $tglb = $tgl_now;
    //  $data['tgla'] = $tgla;
    //  $data['tglb'] = $tglb;
    //}
    $username = new user();
    $username->where('username', $this->session->userdata('username'))->get();
    //$this->lib_date->post_variable($username->id, $tgla, $tglb, '', '', '', '', '', '', '', '');
    $integrasi = new integrasi();
		$data['list'] = $integrasi->get();
    
    $this->load->vars($data);
    $js =  "
            function confirm_link(text){
              if(confirm(text)){ return true;
              }else{ return false; }
              }
              $(document).ready(function() {
                oTable = $('#holiday').dataTable({
                         \"bJQueryUI\": true,
                         \"sPaginationType\": \"full_numbers\"
                });
              } );
             ";

    $this->template->set_metadata_javascript($js);
    $this->session_info['page_name'] = "Integrasi TIM Teknis";
    $this->template->build('list_integrasi', $this->session_info);
  }
  
	//public function ctk_perhubungan() {
	//	$u_ser = $this->session->userdata('username');
	//	$r_name = $this->lib_date->get_nama_ori($u_ser);
    //    $syarat = $this->input->post('pemohon_syarat');
    //    $syarat_len = count($syarat);
	//	$is_array = NULL;
		
	//	echo $u_ser .' || ';
	//	echo $syarat_len .' || ';

    //    for ($i = 0; $i < $syarat_len; $i++) {
    //        echo $syarat[$i] .' || ';
    //        $is_array = $syarat[$i];
    //    }
		
    //}
}