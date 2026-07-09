<?php
/** Description of survey class
  * @author Dichi Al Faridi @since   1.0
  * @edited PBS 28-09-2015 
*/

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Survey extends WRC_AdminCont {

  public function __construct() {
    parent::__construct();
		$this->username = new user();
		$this->tmky = new tmpermohonan_ky();
    $this->permohonan = NULL;
    $this->pegawai = new tmpegawai;
    $this->load->model("m_barang");
    $this->survey = NULL;
    $enabled = FALSE;
		$this->All = FALSE;
    $list_auths = $this->session_info['app_list_auth'];

    foreach ($list_auths as $list_auth) {
      if($list_auth->id_role === '11' || $list_auth->id_role === '12' || $list_auth->id_role === '28') {
        $enabled = TRUE;
        $this->permohonan = new tmpermohonan();
        $this->pegawai = new tmpegawai();
        $this->survey = new trtanggal_survey();
      }
			if($list_auth->id_role === '18') {
        $this->All = TRUE;
      }
    }
         
		$this->username->where('username', $this->session->userdata('username'))->get();
		$this->id_user = $this->username->id;
		$this->opd_teknis = FALSE;
		$this->eselon = $this->username->tmpegawai->get()->eselon;
		if($this->username->lokasi == 'OPD Teknis') $this->opd_teknis = TRUE;
    if(!$enabled) {
      redirect('dashboard');
    }
  }

  public function index() {  //  Untuk Penjadualan Tinjauan Lapangan pertama
    $list_state = $this->input->post('list_state');//echo $list_state; die;
    $username = new user();
    $username->where('username', $this->session->userdata('username'))->get();
    $lokasi_user = $this->session->userdata('lokasi');

    $no_daftar = $this->input->post('kt_cari');
		$tgla = $this->input->post('tgla');
    $tglb = $this->input->post('tglb');
    $now = $this->lib_date->get_date_now();
    $tgl_before = $this->lib_date->set_date($now, -7);
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
    $this->lib_date->post_variable($username->id, $tgla, $tglb, $no_daftar, $list_state, '', '', '', '', '', '');   // post variable
        
    $data['kt_cari'] = $no_daftar;
		$data['list_state'] = $list_state;
		$data['checked'] = FALSE;
		$data['opd_teknis'] = $this->opd_teknis;
		$data['list'] = $this->main_sql($username->id,$tgla,$tglb,$lokasi_user, $no_daftar, $list_state); // = $query;
    $this->load->vars($data);

    $js = $this->index_js();
    $this->template->set_metadata_javascript($js);
    $this->session_info['page_name'] = "Penjadwalan Tinjauan Lapangan ";
    $this->template->build('list', $this->session_info);
  }

	public function index_next() {  //  Untuk Penjadualan Tinjauan Lapangan Selanjutnya
	  $list_state = $this->input->post('list_state');//echo $list_state; die;
    $lokasi_user = $this->session->userdata('lokasi');
    $username = new user();
    $username->where('username', $this->session->userdata('username'))->get();
    $group = $username->group;
    $tgla = $username->gvar1;
    $tglb = $username->gvar2;
    $no_daftar = $username->gvar3;
    $data['tgla'] = $tgla;
    $data['tglb'] = $tglb;
    $data['kt_cari'] = $no_daftar;
    $data['list_state'] = $list_state;
    $data['checked'] = FALSE;
    $data['opd_teknis'] = $this->opd_teknis;
    $data['list'] = $this->main_sql($username->id,$tgla,$tglb,$lokasi_user); // = $query;
    $this->load->vars($data);

    $js = $this->index_js();
    $this->template->set_metadata_javascript($js);
    $this->session_info['page_name'] = "Penjadwalan Tinjauan Lapangan ";
    $this->template->build('list', $this->session_info);
  }

  public function result() {  // Entry Data Hasil Tinjauan
    $kd_filter = $this->input->post('kd_filter');
    $no_daftar = $this->input->post('kt_cari');
    $username = new user();
    $username->where('username', $this->session->userdata('username'))->get();
    $lokasi_user = $this->session->userdata('lokasi');
    
    $tgla = $this->input->post('tgla');
    $tglb = $this->input->post('tglb');
    $now = $this->lib_date->get_date_now();
    $tgl_before = $this->lib_date->set_date($now, -7);
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
    $this->lib_date->post_variable($username->id, $tgla, $tglb, '', '', '', '', '', '', '', '');   // post variable

    $data['kd_filter'] = $kd_filter;

    $data['kt_cari'] = $no_daftar;
    $data['list'] = $this->main_sql($username->id,$tgla,$tglb,$lokasi_user, $no_daftar); // = $query;
    $data['opd_teknis'] = $this->opd_teknis;
    $data['eselon'] = $this->eselon;
    $this->load->vars($data);

    $js = $this->index_js();
    $this->template->set_metadata_javascript($js);
    $this->session_info['page_name'] = "Data Entry Hasil Tinjauan ".$this->session->userdata('aku');
    $this->template->build('list_result', $this->session_info);
  }

  public function result_next() {  //  Untuk Entry Data Hasil Tinjauan Selanjutnya
    $lokasi_user = $this->session->userdata('lokasi');
    $username = new user();
    $username->where('username', $this->session->userdata('username'))->get();
    $group = $username->group;
    $tgla = $username->gvar1;
    $tglb = $username->gvar2;
    $data['tgla'] = $tgla;
    $data['tglb'] = $tglb;

    $data['list'] = $this->main_sql($username->id,$tgla,$tglb,$lokasi_user); // = $query;
    $data['opd_teknis'] = $this->opd_teknis;
    $data['eselon'] = $this->eselon;
    $this->load->vars($data);

    $js = $this->index_js();
    $this->template->set_metadata_javascript($js);
    $this->session_info['page_name'] = "Data Entry Hasil Tinjauan";
    $this->template->build('list_result', $this->session_info);
  }

  public function result_OLD() {  // Entry Data Hasil Tinjauan
    $lokasi_user = $this->session->userdata('lokasi');
    $tgla = $this->input->post('tgla');
    $tglb = $this->input->post('tglb');
    $now = $this->lib_date->get_datetime_now();
    $tgl_before = $this->lib_date->set_date($now, -7);
    $tgl_now = $this->lib_date->set_date($now, 0);

    if($tgla && $tglb) {
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
		if($this->All){
      $query = "SELECT A.id, A.pendaftaran_id, A.c_tinjauan, A.d_terima_berkas, A.d_survey, A.survey_sd, A.keterangan, A.status_berkas,
                A.d_perubahan, A.d_perpanjangan, A.d_daftarulang, A.kd_gerai, A.d_selesai_proses, A.a_izin,
                C.id idizin, C.n_perizinan, E.n_pemohon,
                G.id idjenis, G.n_permohonan
                FROM tmpermohonan as A
                INNER JOIN tmpermohonan_trperizinan as B ON B.tmpermohonan_id = A.id
                INNER JOIN trperizinan as C ON B.trperizinan_id = C.id
                INNER JOIN tmpemohon_tmpermohonan as D ON D.tmpermohonan_id = A.id
                INNER JOIN tmpemohon as E ON D.tmpemohon_id = E.id
                INNER JOIN tmpermohonan_trjenis_permohonan as F ON F.tmpermohonan_id = A.id
                INNER JOIN trjenis_permohonan as G ON F.trjenis_permohonan_id = G.id
                WHERE A.c_pendaftaran = 1
                AND A.c_izin_dicabut = 0
                AND A.c_izin_selesai = 0
                AND A.d_terima_berkas between '$tgla' and '$tglb'
                order by A.id DESC";
		}else{
      if($lokasi_user === 'Pusat' || $lokasi_user === 'OPD Teknis') {
        $query = "SELECT A.id, A.pendaftaran_id, A.c_tinjauan, A.d_terima_berkas, A.d_survey, A.survey_sd, A.keterangan, A.status_berkas,
                  A.d_perubahan, A.d_perpanjangan, A.d_daftarulang, A.kd_gerai, A.d_selesai_proses, A.a_izin,
                  C.id idizin, C.n_perizinan, E.n_pemohon,
                  G.id idjenis, G.n_permohonan
                  FROM tmpermohonan as A
                  INNER JOIN tmpermohonan_trperizinan as B ON B.tmpermohonan_id = A.id
                  INNER JOIN trperizinan as C ON B.trperizinan_id = C.id
                  INNER JOIN tmpemohon_tmpermohonan as D ON D.tmpermohonan_id = A.id
                  INNER JOIN tmpemohon as E ON D.tmpemohon_id = E.id
                  INNER JOIN tmpermohonan_trjenis_permohonan as F ON F.tmpermohonan_id = A.id
                  INNER JOIN trjenis_permohonan as G ON F.trjenis_permohonan_id = G.id
                  INNER JOIN trperizinan_user AS J ON J.trperizinan_id = C.id
                  WHERE A.c_pendaftaran = 1
                  AND A.c_izin_dicabut = 0
                  AND A.c_izin_selesai = 0
                  AND J.user_id = '" . $username->id . "'
                  AND A.d_terima_berkas between '$tgla' and '$tglb'
                  order by A.id DESC";
		  }else{
        $query = "SELECT A.id, A.pendaftaran_id, A.c_tinjauan, A.d_terima_berkas, A.d_survey, A.survey_sd, A.keterangan, A.status_berkas,
                  A.d_perubahan, A.d_perpanjangan, A.d_daftarulang, A.kd_gerai, A.d_selesai_proses, A.a_izin,
                  C.id idizin, C.n_perizinan, E.n_pemohon,
                  G.id idjenis, G.n_permohonan
                  FROM tmpermohonan as A
                  INNER JOIN tmpermohonan_trperizinan as B ON B.tmpermohonan_id = A.id
                  INNER JOIN trperizinan as C ON B.trperizinan_id = C.id
                  INNER JOIN tmpemohon_tmpermohonan as D ON D.tmpermohonan_id = A.id
                  INNER JOIN tmpemohon as E ON D.tmpemohon_id = E.id
                  INNER JOIN tmpermohonan_trjenis_permohonan as F ON F.tmpermohonan_id = A.id
                  INNER JOIN trjenis_permohonan as G ON F.trjenis_permohonan_id = G.id
                  INNER JOIN trperizinan_user AS J ON J.trperizinan_id = C.id
                  WHERE A.c_pendaftaran = 1
                  AND A.c_izin_dicabut = 0
                  AND A.c_izin_selesai = 0
                  AND J.user_id = '" . $username->id . "'
                  AND A.d_terima_berkas between '$tgla' and '$tglb'
                  AND A.kd_gerai =  '$lokasi_user'
                  order by A.id DESC";
      }
		}
    $data['list'] = $query;
    $data['opd_teknis'] = $this->opd_teknis;
    $this->load->vars($data);

    $js = $this->index_js();
    $this->template->set_metadata_javascript($js);
    $this->session_info['page_name'] = "Data Entry Hasil Tinjauan";
    $this->template->build('list_result', $this->session_info);
  }

  public function index_js() {
    $js = " 
	         $(document).ready(function() {
             oTable = $('#survey').dataTable({
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
		       $(document).ready(function() {
             $('#form').validate();
             $(\"#tabs\").tabs();
             $('a[rel*=view_data_visit]').facebox();
           } );
          ";
    return $js;
	}

  public function resultUpdate($id_daftar = NULL) {
    $p_daftar = $this->permohonan->get_by_id($id_daftar);
    $p_pemohon = $p_daftar->tmpemohon->get();
    $p_jenis = $p_daftar->trjenis_permohonan->get();
    $p_izin = $p_daftar->trperizinan->get();
    $p_kelompok = $p_daftar->trperizinan->trkelompok_perizinan->get();
    $p_kelurahan = $p_pemohon->trkelurahan->get();
    $p_kecamatan = $p_kelurahan->trkecamatan->get();
    $p_kabupaten = $p_kecamatan->trkabupaten->get();
    $p_prov = $p_kabupaten->trpropinsi->get();
    $p_sektor = $p_izin->trsektor->get();

    $this->permohonan->tmsurat_rekomendasi->get();

    $online=0;
    $asistensi = '';
    //Start Data Berkas Nirwan
    $p_daftar = $this->permohonan->get_by_id($id_daftar);
    $data['daftaronline'] = $p_daftar->kd_gerai;
    $id_portal = $p_daftar->id_pemohon_portal;
    $data['peronline'] = 0;
	$editable = 0;
    if ($p_daftar->kd_gerai === 'OnLine') {
      $otherdb = $this->load->database('otherdb', TRUE);
      $portal = $this->db->query("SELECT * FROM tmpemohon_portal where id = $id_portal")->row_array();
      //$editable = 0;
      if($portal['id_permohonan_portal']){
        $online =1;
        $permohonan_portal_trperizinan = $otherdb->get_where("tmpermohonan_portal",array("id"=>$portal['id_permohonan_portal']))->first_row();

        if (!empty($permohonan_portal_trperizinan)) {
          $editable = $permohonan_portal_trperizinan->editable;
        }
        $backoffice_db  = $this->load->database('default', TRUE);
        $portal_db      = $this->load->database('otherdb', TRUE);
        $db_portal      = $portal_db->database;
        $db_backoffice  = $backoffice_db->database;
        $sql = "SELECT A.*, B.tmpermohonan_id, B.nomor_surat, B.tanggal_surat, B.masa_berlaku_surat FROM $db_backoffice.trsyarat_perizinan A 
          LEFT JOIN $db_portal.tmpermohonan_trsyarat_perizinan B ON A.id = B.trsyarat_perizinan_id
          WHERE A.id IN(select trsyarat_perizinan_id from trperizinan_trsyarat_perizinan where trperizinan_id=? and status='1')
          GROUP BY A.id
          ORDER BY (A.urutan * -1) DESC, A.status ASC, A.urutan = 0, A.urutan";

        $persyaratan_portal = $this->db->query($sql, $permohonan_portal_trperizinan->id_perizinan)->result();
        $username_portal = $otherdb->get_where("tm_pemohon",array("id"=>$portal['id_pemohon']))->first_row();

        //Asistensi
        $otherdb->order_by("id","asc");
    	$asistensi = $otherdb->get_where("asistensi",array("id_permohonan"=>$portal['id_permohonan_portal']))->result();

    	$data["asistensi"] = $asistensi;

        $data["persyaratan"] = $persyaratan_portal;
        $data["id_portal"] = $portal['id_permohonan_portal'];
        $data["username_portal"] = $username_portal->username;
        $data['peronline'] = 1;
        //$data['online'] = 1;
      }
    }
      $data['online'] = $online;
      //End Data Berkas Nirwan
        
    // CODE UNTUK TRACKING DATA WEB PENGENDALIAN 
    $prid = $this->db->query("SELECT * FROM tmpermohonan_trperizinan where tmpermohonan_id = $id_daftar")->row_array();
    $data['perizinan_id'] = $prid['trperizinan_id'];
    $data['permohonan_id'] = $id_daftar;
    $querysql2 = "select f.id,f.n_kabupaten, count(a.n_pemohon) as jumlah
                  from tmpemohon as a
                  left join tmpemohon_trkelurahan as b on a.id = b.tmpemohon_id
                  left join trkelurahan as c on b.trkelurahan_id = c.id
                  left join trkecamatan_trkelurahan as d on c.id = d.trkelurahan_id
                  left join trkabupaten_trkecamatan as e on d.trkecamatan_id = e.trkecamatan_id
                  left join trkabupaten as f on e.trkabupaten_id = f.id
                  where a.id = (select tmpemohon_id from tmpemohon_tmpermohonan where tmpermohonan_id = $id_daftar)
                  group by f.n_kabupaten ";
    $hasix = $this->db->query($querysql2)->row_array();
    $data['kabupaten_id'] = $hasix['id'];

    $data['editable'] = $editable;
    $data['id_daftar'] = $id_daftar;
    $data['permohonan'] = $p_daftar;
    $data['tgl_permohonan'] = $p_daftar->d_terima_berkas;
    $data['waktu_awal'] = $this->lib_date->get_datetime_now();
    $data['no_daftar'] = $p_daftar->pendaftaran_id;
    $data['d_survey'] = $p_daftar->d_survey;
    $data['nama_pemohon'] = $p_pemohon->n_pemohon;
    $data['alamat_pemohon'] = $p_pemohon->a_pemohon . ', ' . $p_kelurahan->n_kelurahan . ', ' . $p_kecamatan->n_kecamatan . ', ' .
                              $p_kabupaten->n_kabupaten . ', ' . $p_prov->n_propinsi;
    $data['jenis_izin'] = $p_izin->n_perizinan;
    $data['nama_jenis'] = $p_jenis->n_permohonan;
    $data['nama_kelompok'] = $p_kelompok->n_kelompok;
    $data['list'] = $p_izin->trproperty->order_by('c_parent_order asc, c_order asc')->get();
    $data['list_daftar'] = $p_daftar->tmproperty_jenisperizinan->get();
    $data['list_klasifikasi'] = $p_daftar->tmproperty_klasifikasi->get();
    $data['list_prasarana'] = $p_daftar->tmproperty_prasarana->get();
    $data['id_izin'] = $p_izin->id;

    $data['no_surat'] = $this->permohonan->tmsurat_rekomendasi->no_surat;
    $data['tgl_surat'] = $this->permohonan->tmsurat_rekomendasi->tgl_surat;
    $data['deskripsi'] = $this->permohonan->tmsurat_rekomendasi->deskripsi;
    $data['syarat1'] = $this->permohonan->k_syarat1;
    $data['syarat2'] = $this->permohonan->k_syarat2;
    $data['syarat3'] = $this->permohonan->k_syarat3;
    $data['syarat4'] = $this->permohonan->k_syarat4;
    $data['syarat5'] = $this->permohonan->k_syarat5;
    $data['tglsyarat'] = $this->permohonan->tgl_syarat;
    $data['bidang'] = $p_sektor->n_sektor;

		$this->tmky->where('tmpermohonan_id', $id_daftar)->get();
		if($this->tmky->kyStafOPD == '')
			$data['kyStafOPD'] = TRUE;
		else
			$data['kyStafOPD'] = FALSE;
	
	  #
    # NEW CODE UNTUK TRACKING DATA DI WEB PENGENDALIAN
	  #
    $prid = $this->db->query("SELECT * FROM tmpermohonan_trperizinan where tmpermohonan_id = $id_daftar")->row_array();
    $data['perizinan_id'] = $prid['trperizinan_id'];
    $data['permohonan_id'] = $id_daftar;
    $querysql2 = "select f.id,f.n_kabupaten, count(a.n_pemohon) as jumlah
                  from tmpemohon as a
                 left join tmpemohon_trkelurahan as b on a.id = b.tmpemohon_id
                 left join trkelurahan as c on b.trkelurahan_id = c.id
                 left join trkecamatan_trkelurahan as d on c.id = d.trkelurahan_id
                 left join trkabupaten_trkecamatan as e on d.trkecamatan_id = e.trkecamatan_id
                 left join trkabupaten as f on e.trkabupaten_id = f.id
                 where a.id = (select tmpemohon_id from tmpemohon_tmpermohonan where tmpermohonan_id = $id_daftar)
                 group by f.n_kabupaten ";
    $hasix = $this->db->query($querysql2)->row_array();
    $data['kabupaten_id'] = $hasix['id'];
	  #
	  #  END OF CODE
	  #

    //   $js = "
    //           $(document).ready(function() {
    //               $(\"#tabs\").tabs();
    //               $(\"#tgl_surat\").datepicker({
    //                   changeMonth: true,
    //                   changeYear: true,
    //                   dateFormat: 'yy-mm-dd',
    //                   closeText: 'X'
    //               });
    //           } );
    //       ";
        
    $js =  "
		        $(document).ready(function() {
              $(\"#tabs\").tabs();
              $(\"#tgl_surat\").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy-mm-dd',
                closeText: 'X'
              });
              $('.monbulan').datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy-mm-dd',
                closeText: 'X'
              });
              $('#form').validate();
            } );

            function finishAjax(id, response){
              $('#'+id).html(unescape(response));
              $('#'+id).fadeIn();
            }
           ";

    $this->template->set_metadata_javascript($js);
    $data['from'] = 'survey/result_next';
    $data['id'] = $id_daftar;
    $entry = new tmproperty_jenisperizinan();
    $entry->where_related($p_daftar)->get();
    //if($entry->id) $save = 'updateresult';
    $save = 'editproperty';
    $data['save_method'] = $save;
    $this->load->vars($data);

    $this->session_info['page_name'] = "Data Entry Hasil Tinjauan";
    
    /*foreach($data['list'] as $list){
    echo $list->n_property.'-'.$list->c_type.'<br>';
    }*/
    $this->template->build('update_survey', $this->session_info);
  }

  public function editproperty() {
    ##
    # NEW CODE UNTUK WEB PENGENDALIAN
    ##
    $ddd = $this->db->query("SELECT *  FROM table_non_spipise where id_permohonan = $_POST[id_daftar]")->row_array();
    if(count($ddd) > 0){
      $tenaga = ($_POST['tenaga'] == '')?NULL:"$_POST[tenaga]";
      $invest = ($_POST['invest'] == '')?NULL:"$_POST[invest]";
      $text_query = "UPDATE table_non_spipise set tenaga_kerja = ";
      if($tenaga == null){
        $text_query .= " null";
      }else{
        $text_query .= " '$tenaga'";
      }
      $text_query .= " ,investasi = ";
    
      if($invest == null){
    	  $text_query .= " null";
      }else{
    	  $text_query .= " '$invest'";
      }			
      $text_query .= " where id_permohonan = $_POST[id_daftar]";
      $this->db->query($text_query);
    }else{
      $tenaga = ($_POST['tenaga'] == '')?NULL:"$_POST[tenaga]";
      $invest = ($_POST['invest'] == '')?NULL:"$_POST[invest]";
      $text_query = "INSERT INTO table_non_spipise values('','$_POST[idpermo]','$_POST[idizin]','$_POST[idkab]'";
      if($tenaga == null){
        $text_query .= ",null";
      }else{
        $text_query .= ",'$tenaga'";
      }
      if($invest == null){
        $text_query .= ",null";
      }else{
        $text_query .= ",'$invest'";
      }			
      $text_query .= ",'0')";
      $this->db->query($text_query);
    }   
    ##
    # END OF NEW CODE
    ##
    
    $id_izin = $this->input->post('id_izin');
    $jumlah = $this->lib_date->data_property($id_izin,'1');
    $i = 1;
    while ($i <= $jumlah) {
      $id_daftar = $this->input->post('id_daftar');
      $data_property = $this->lib_date->isi_property($id_daftar, $i, '1');
      $permohonan = new tmpermohonan();
      $permohonan->where('id', $id_daftar);
      
      $hitung = strlen($data_property);
      $cek_posisi = strpos($data_property,'^'); 
      $data_property = substr($data_property,0,$cek_posisi);
      
      $nama_fild = 'dt_teknis'.$i;
      $isi_fild = str_replace('^','',$data_property) .'^'. str_replace('^','',$this->input->post('vdt_teknis'.$i));
      $permohonan->update($nama_fild, $isi_fild);
      $i++;
      $nama_fild = '';
      $isi_fild = '';
    }
    $permohonan = new tmpermohonan();
    $daftar_id = $this->input->post('id_daftar');
    $permohonan->get_by_id($daftar_id);
    $perizinan = $permohonan->trperizinan->get();
    $no_pendaftaran = $permohonan->pendaftaran_id;
    
    //   $entry_id = $this->input->post('entry_id');
    //   $property_id = $this->input->post('property_id');
    //   $entry = $this->input->post('property_value');
    //   $koefisien_id = $this->input->post('koefisien_id');
    //   $entry2 = $this->input->post('property_value2');
    //   $koefisien_id2 = $this->input->post('koefisien_id2');
    //   $entry_len = count($property_id);
    
    // PBS Create
    $nomor = $this->input->post('nomor_pertimbangan');
    $tgl = $this->input->post('tgl_pertimbangan');
    $perihal = $this->input->post('perihal_pertimbangan');
    $bidang = $this->input->post('bidang_pertimbangan');
    
    $permohonan->where('id',$daftar_id)->update('nomor_pertimbangan', $nomor);
    $permohonan->where('id',$daftar_id)->update('tanggal_pertimbangan', $tgl);
    $permohonan->where('id',$daftar_id)->update('perihal', $perihal);
    $permohonan->where('id',$daftar_id)->update('bidang', $bidang);
    
    $permohonan->k_syarat1 = $this->input->post('syarat1');
    $permohonan->k_syarat2 = $this->input->post('syarat2');
    $permohonan->k_syarat3 = $this->input->post('syarat3');
    $permohonan->k_syarat4 = $this->input->post('syarat4');
    $permohonan->k_syarat5 = $this->input->post('syarat5');
    $permohonan->tgl_syarat = $this->input->post('tglsyarat');
    $permohonan->save();
    // EOF PBS
    
    //   $is_array = NULL;
    //   for ($i = 0; $i < $entry_len; $i++) {
    //       if ($is_array !== $property_id[$i]) {
    //           $entry_awal = new tmproperty_jenisperizinan();
    //           $entry_awal->where_related($permohonan)->get();
    //           $entry_awal->delete();
    //           $property_awal = new tmproperty_jenisperizinan_trproperty();
    //           $property_awal->where('tmproperty_jenisperizinan_id', $entry_id[$i])->get();
    //           $property_awal->delete();
    //       }
    //       $is_array = $property_id[$i];
    //   }
    //   $daftar_awal = new tmpermohonan_tmproperty_jenisperizinan();
    //   $daftar_awal->where('tmpermohonan_id', $daftar_id)->get();
    //   $daftar_awal->delete();
    //   $indeks_koefisien = 1;
    //   for ($i = 0; $i < $entry_len; $i++) {
    //       if ($is_array !== $property_id[$i]) {
    //           $relasi_entry = new trproperty();
    //           $relasi_entry->get_by_id($property_id[$i]);
    //           $entry_data = new tmproperty_jenisperizinan();
    //           $entry_data->pendaftaran_id = $permohonan->pendaftaran_id;
    //           $entry_data->v_property = $entry2[$i];
    //           $entry_data->k_property = $koefisien_id2[$i];
    //           $entry_data->v_tinjauan = $entry[$i];
    //           $entry_data->k_tinjauan = $koefisien_id[$i];
    //           if ($koefisien_id[$i]) {
    //               $koef = new trkoefesientarifretribusi();
    //               $koef->get_by_id($koefisien_id[$i]);
    //               $indeks_koefisien = $indeks_koefisien * $koef->index_kategori;
    //           }
    //           /* Save tmproperty_jenisperizinan() & tmproperty_jenisperizinan_trproperty() */
    //           $entry_data->save($relasi_entry);
    //           $entry_data_id = new tmproperty_jenisperizinan();
    //           $entry_data_id->select_max('id')->get();
    //           /* Save tmpermohonan_tmproperty_jenisperizinan() */
    //           $entry_data_id->save($permohonan);
    
    //           //Luas Bangunan
    //           if ($relasi_entry->id == '10')
    //               $luas = $entry[$i];
    //           if (empty($luas))
    //               $luas = 1;
    
    //           ## Awal Index Terintegrasi Bangunan Gedung
    //           //Fungsi
    //           if ($relasi_entry->id == '11') {
    //               $koef_fungsi = new trkoefesientarifretribusi();
    //               $koef_fungsi->get_by_id($koefisien_id[$i]);
    //               $fungsi = $koef_fungsi->index_kategori;
    //           }
    //           if (empty($fungsi))
    //               $fungsi = 1;
    
    //           //Lingkup Pembangunan
    //           if ($relasi_entry->id == '14') {
    //               $koef_lingkup = new trkoefesientarifretribusi();
    //               $koef_lingkup->get_by_id($koefisien_id[$i]);
    //               $lingkup = $koef_lingkup->index_kategori;
    //           }
    //           if (empty($lingkup))
    //               $lingkup = 1;
    
    //           //Waktu Penggunaan
    //           if ($relasi_entry->id == '13') {
    //               $koef_waktu = new trkoefesientarifretribusi();
    //               $koef_waktu->get_by_id($koefisien_id[$i]);
    //               $waktu = $koef_waktu->index_kategori;
    //           }
    //           if (empty($waktu))
    //               $waktu = 1;
    
    //           $retribusi_imb_awal = new tmretribusi_rinci_imb();
    //           $retribusi_imb_awal->where_related($permohonan)->get();
    //           $retribusi_imb_awal->delete();
    
    //           if ($relasi_entry->id == '12') { //Hanya untuk KLASIFIKASI
    //               $klasifikasi_id = $this->input->post('klasifikasi_id');
    //               $retribusi_id = $this->input->post('retribusi_id');
    //               $koef_value = $this->input->post('koef_value');
    //               $koef_id = $this->input->post('koef_id');
    //               $koef_value2 = $this->input->post('koef_value2');
    //               $koef_id2 = $this->input->post('koef_id2');
    //               $klasifikasi_len = count($retribusi_id);
    //               $is_array_klasifikasi = NULL;
    
    //               for ($z = 0; $z < $klasifikasi_len; $z++) {
    //                   if ($is_array_klasifikasi !== $retribusi_id[$z]) {
    //                       $klasifikasi_awal = new tmproperty_klasifikasi();
    //                       $klasifikasi_awal->where_related($permohonan)->get();
    //                       $klasifikasi_awal->delete();
    //                       $retribusi_awal = new tmproperty_klasifikasi_trkoefesientarifretribusi();
    //                       $retribusi_awal->where('tmproperty_klasifikasi_id', $klasifikasi_id[$z])->get();
    //                       $retribusi_awal->delete();
    //                   }
    //                   $is_array_klasifikasi = $retribusi_id[$z];
    //               }
    //               $daftar_klasifikasi = new tmpermohonan_tmproperty_klasifikasi();
    //               $daftar_klasifikasi->where('tmpermohonan_id', $daftar_id)->get();
    //               $daftar_klasifikasi->delete();
    
    //               $indeks = 0;
    //               for ($z = 0; $z < $klasifikasi_len; $z++) {
    //                   if ($is_array_klasifikasi !== $retribusi_id[$z]) {
    //                       $relasi_klasifikasi = new trkoefesientarifretribusi();
    //                       $relasi_klasifikasi->get_by_id($retribusi_id[$z]);
    //                       $koef_parent = $relasi_klasifikasi->index_kategori;
    //                       $koef_child = new trkoefisienretribusilev1();
    //                       $koef_child->get_by_id($koef_id[$z]);
    //                       $koef_child = $koef_child->index_kategori;
    //                       $klasifikasi_data = new tmproperty_klasifikasi();
    //                       $klasifikasi_data->pendaftaran_id = $permohonan->pendaftaran_id;
    //                       $klasifikasi_data->v_klasifikasi = $koef_value2[$z];
    //                       $klasifikasi_data->k_klasifikasi = $koef_id2[$z];
    //                       $klasifikasi_data->v_tinjauan = $koef_value[$z];
    //                       $klasifikasi_data->k_tinjauan = $koef_id[$z];
    //                       /* Save tmproperty_klasifikasi() & tmproperty_klasifikasi_trkoefesientarifretribusi() */
    //                       $klasifikasi_data->save($relasi_klasifikasi);
    //                       $klasifikasi_data_id = new tmproperty_klasifikasi();
    //                       $klasifikasi_data_id->select_max('id')->get();
    //                       /* Save tmpermohonan_tmproperty_jenisperizinan() */
    //                       $klasifikasi_data_id->save($permohonan);
    //                       $indeks = $indeks + ($koef_parent * $koef_child);
    //                         if($relasi_klasifikasi->id == '104') $indeks = $koef_parent * $koef_child;
    //                   }
    //                   $is_array_klasifikasi = $retribusi_id[$z];
    //               }
    //           } else if ($relasi_entry->id == '29') { //Hanya untuk PRASARANA
    //               $prasarana_id = $this->input->post('prasarana_id');
    //               $retribusi_id3 = $this->input->post('retribusi_id3');
    //               $koef_value3 = $this->input->post('koef_value3');
    //               $koef_id3 = $this->input->post('koef_id3');
    //               $koef_value4 = $this->input->post('koef_value4');
    //               $koef_id4 = $this->input->post('koef_id4');
    //               $prasarana_len = count($retribusi_id3);
    //               $is_array_prasarana = NULL;
    
    //               for ($x = 0; $x < $prasarana_len; $x++) {
    //                   if ($is_array_prasarana !== $retribusi_id3[$x]) {
    //                       $prasarana_awal = new tmproperty_prasarana();
    //                       $prasarana_awal->where_related($permohonan)->get();
    //                       $prasarana_awal->delete();
    //                       $retribusi_awal = new tmproperty_prasarana_trkoefesientarifretribusi();
    //                       $retribusi_awal->where('tmproperty_prasarana_id', $prasarana_id[$x])->get();
    //                       $retribusi_awal->delete();
    //                   }
    //                   $is_array_prasarana = $retribusi_id3[$x];
    //               }
    //               $daftar_prasarana = new tmpermohonan_tmproperty_prasarana();
    //               $daftar_prasarana->where('tmpermohonan_id', $daftar_id)->get();
    //               $daftar_prasarana->delete();
    
    //               $nilai_prasarana = 0;
    //               for ($x = 0; $x < $prasarana_len; $x++) {
    //                   if ($is_array_prasarana !== $retribusi_id3[$x]) {
    //                       $relasi_prasarana = new trkoefesientarifretribusi();
    //                       $relasi_prasarana->get_by_id($retribusi_id3[$x]);
    //                       $koef_child2 = new trkoefisienretribusilev1();
    //                       $koef_child2->get_by_id($koef_id3[$x]);
    //                       $prasarana_data = new tmproperty_prasarana();
    //                       $prasarana_data->pendaftaran_id = $permohonan->pendaftaran_id;
    //                       $prasarana_data->v_prasarana = $koef_value4[$x];
    //                       $prasarana_data->k_prasarana = $koef_id4[$x];
    //                       $prasarana_data->v_tinjauan = $koef_value3[$x];
    //                       $prasarana_data->k_tinjauan = $koef_id3[$x];
    //                       /* Save tmproperty_prasarana() & tmproperty_prasarana_trkoefesientarifretribusi() */
    //                       $prasarana_data->save($relasi_prasarana);
    //                       $prasarana_data_id = new tmproperty_prasarana();
    //                       $prasarana_data_id->select_max('id')->get();
    //                       /* Save tmpermohonan_tmproperty_jenisperizinan() */
    //                       $prasarana_data_id->save($permohonan);
    
    //                       if ($koef_value3[$x]) {
    //                           $imb_prasarana = $koef_value3[$x] * $koef_child2->index_kategori * $koef_child2->v_index_kategori;
    //                           $retribusi_prasarana = new tmretribusi_rinci_imb();
    //                           $retribusi_prasarana->e_parameter = $koef_value3[$x] . " x " . $koef_child2->index_kategori . " x Rp. " . //$this->terbilang->nominal($koef_child2->v_index_kategori, 2);
    //                           $retribusi_prasarana->e_parameter_parent = $koef_child2->kategori;
    //                           $retribusi_prasarana->v_retribusi = $imb_prasarana;
    //                           $retribusi_prasarana->c_imb = 2;
    //                           $retribusi_prasarana->save($permohonan);
    //                           $nilai_prasarana = $nilai_prasarana + $imb_prasarana;
    //                       }
    //                   }
    //                   $is_array_prasarana = $retribusi_id3[$x];
    //               }
    //           }
    //       }
    //       $is_array = $property_id[$i];
    //   }
    $retribusi_parent = new trretribusi();
    $retribusi_parent->where_related($perizinan)->get();
    $nilai_retribusi = $retribusi_parent->v_retribusi;
    if($perizinan->id == '2' || $perizinan->id == '3') {
      $nilai_imb = $nilai_retribusi;
      $nilai_formulir = $retribusi_parent->v_denda;
      $nama_parameter = "BANGUNAN GEDUNG";
      $it = $fungsi * $lingkup * $indeks * $waktu;
      $nilai_retribusi = $luas * $it * 1.00 * $nilai_imb;
      $retribusi_imb = new tmretribusi_rinci_imb();
      $retribusi_imb->e_parameter = $luas . " m2 x " . $it . " x 1.00 x Rp. " . $this->terbilang->nominal($nilai_imb, 2);
      $retribusi_imb->e_parameter_parent = $nama_parameter;
      $retribusi_imb->v_retribusi = $nilai_retribusi;
      $retribusi_imb->c_imb = 1;
      $retribusi_imb->save($permohonan);
      $nilai_total = $nilai_retribusi + $nilai_prasarana + $nilai_formulir;
    }else{
      $nilai_total = $nilai_retribusi * $indeks_koefisien;
    }
    
    $bap_awal = $permohonan->tmbap->get();
    if($bap_awal->id) {
      $bap = new tmbap();
      $bap->get_by_id($bap_awal->id);
      $bap->nilai_retribusi = $nilai_total;
      $update = $bap->save($permohonan);
    }else{
      /* Input Data */
      $data_id = new tmbap();
      
      $data_id->select_max('id')->get();
      $data_id->get_by_id($data_id->id);
      
      $data_tahun = date("Y");
      //Per Tahun Auto Restart NoUrut
      if($permohonan->d_tahun === $data_tahun)
        $data_urut = $data_id->i_urut + 1;
      else
        $data_urut = 1;
      
      $i_urut = strlen($data_urut);
      for($i = 4; $i > $i_urut; $i--) {
        $data_urut = "0" . $data_urut;
      }
      
      $data_izin = $perizinan->id;
      $i_izin = strlen($data_izin);
      for($i = 3; $i > $i_izin; $i--) {
        $data_izin = "0" . $data_izin;
      }
      
      $data_bulan = $this->lib_date->set_month_roman(date("n"));
      
      $data_bap = "BAP";
      $no_bap = $data_urut . "/". $data_bap . "/" . $data_izin . "/". $data_bulan . "/" . $data_tahun;
      $data_skrd = "SKRD";
      $no_skrd = $data_urut . "/". $data_skrd . "/" . $data_izin . "/". $data_bulan . "/" . $data_tahun;
      $bap2 = new tmbap();
      $bap2->pendaftaran_id = $permohonan->pendaftaran_id;
      $bap2->nilai_retribusi = $nilai_total;
      $bap2->bap_id = $no_bap;
    	$bap2->tgl_bap = $this->lib_date->get_date_now();
      $bap2->no_skrd = $no_skrd;
      $bap2->i_urut = $data_urut;
      $update = $bap2->save($permohonan);
    }
    
    $updated = FALSE;
    if($permohonan->c_tinjauan === "1")
      $updated = TRUE;
    
    $status_izin = $permohonan->trstspermohonan->get();
    $status_skr = "4"; //Survey Lokasi [Lihat Tabel trstspermohonan()] -> kominfo old 4
    $id_status = "4";  //BAP Lapangan [Lihat Tabel trstspermohonan()]  -> kominfo old 6
    if($status_izin->id == $status_skr) {
      /* Input Data Tracking Progress */
      
      /* EOF() Input Data Tracking Progress */
      //$sts_izin = new trstspermohonan();
      //$sts_izin->get_by_id($status_skr);
      //$data_status = new tmtrackingperizinan_trstspermohonan();
      //$list_tracking = $permohonan->tmtrackingperizinan->get();
      //if ($list_tracking) {
      //    $tracking_id = 0;
      //    foreach ($list_tracking as $data_track) {
      //        $data_status = new tmtrackingperizinan_trstspermohonan();
      //        $data_status->where('tmtrackingperizinan_id', $data_track->id)
      //                ->where('trstspermohonan_id', $sts_izin->id)->get();
      //        if ($data_status->tmtrackingperizinan_id) {
      //            $tracking_id = $data_status->tmtrackingperizinan_id;
      //        }
      //    }
      //}
      //$tracking_izin = new tmtrackingperizinan();
      //$tracking_izin->get_by_id($tracking_id);
      //$tracking_izin->pendaftaran_id = $permohonan->pendaftaran_id;
      //$tracking_izin->status = 'Update';
      //$tracking_izin->d_entry = $this->lib_date->get_datetime_now();
      //$tracking_izin->save();
      
      /* [Lihat Tabel trstspermohonan()] */
      //$tracking_izin2 = new tmtrackingperizinan();
      //$tracking_izin2->pendaftaran_id = $permohonan->pendaftaran_id;
      //$tracking_izin2->status = 'Insert';
      //$tracking_izin2->d_entry_awal = $this->lib_date->get_datetime_now();
      //$tracking_izin2->d_entry = $this->lib_date->get_datetime_now();
      //$sts_izin2 = new trstspermohonan();
      //$sts_izin2->get_by_id($id_status); //[Lihat Tabel trstspermohonan()]
      //$sts_izin2->save($permohonan);
      //$tracking_izin2->save($permohonan);
      //$tracking_izin2->save($sts_izin2);
    }
    
    $from = $this->input->post('from');
    
    $permohonan->tmsurat_rekomendasi->get();
    $surat_rekomendasi = new tmsurat_rekomendasi();
    if($permohonan->tmsurat_rekomendasi->count() > 0) {
      $id = $permohonan->tmsurat_rekomendasi->id;
      $surat_rekomendasi->where('id', $id)
                        ->update(array('no_surat' => $this->input->post('no_surat'),
                                       'tgl_surat' => $this->input->post('tgl_surat'),
                                       'deskripsi' => $this->input->post('deskripsi')
                        ));
    }else{
      $surat_rekomendasi->no_surat = $this->input->post('no_surat');
      $surat_rekomendasi->tgl_surat = $this->input->post('tgl_surat');
      $surat_rekomendasi->deskripsi = $this->input->post('deskripsi');
      $permohonan->where('id', $this->input->post('id_daftar'))->get();
      $surat_rekomendasi->save($permohonan);
    }
    
    if($permohonan->kd_status < 4){ // ubah kd_status menjadi 4 (entry hasil tinjauan) untuk proses selanjutnya (Pembuatan BAP)
      $permohonan->kd_status = 4;
      $permohonan->save();
    }
    
    /* Input Data Tracking Progress */
    $u_ser = $this->session->userdata('username');
    $r_name = $this->lib_date->get_nama_ori($u_ser);
    $tracking_izin2 = new tmtrackingperizinan();
    $tracking_izin2->where('pendaftaran_id', $no_pendaftaran)
                   ->where('tr_activiti', 'Pertimbangan Teknis')->get();
    if($tracking_izin2->pendaftaran_id){
      $tracking_izin2->status = 'Update';
      $tracking_izin2->d_entry = $this->lib_date->get_date_now();
      $tracking_izin2->tr_user = $u_ser;
      $tracking_izin2->tr_name = $r_name;
      $hit_ubah = $tracking_izin2->hit_ubah + 1;
      $his_ubah = $tracking_izin2->his_ubah;
      $tracking_izin2->hit_ubah = $hit_ubah;
      $tracking_izin2->his_ubah = $his_ubah.'Entry Tinjauan Lapangan^'.$r_name.'^'.$this->lib_date->get_date_now().';';
      $tracking_izin2->save();
    }
    /* EOF() Input Data Tracking Progress */
    
    $tgl = date("Y-m-d H:i:s");
    $u_ser = $this->session->userdata('username');
    $g = $this->sql2($u_ser);
    //$jam = date("H:i:s A");
    //$p = $this->db->query("call log ('Entry Tinjauan','Update " . $permohonan->pendaftaran_id . "','" . $tgl . "','" . $u_ser . "')");
    
    $permohonan->where('id', $daftar_id)
               ->update(array('c_tinjauan' => 1));
    
    if($update) {
      if($from !== NULL && $from !== "")
        redirect($from);
      else
        redirect('pendataan');
    }
  }

  public function saveresult() {
    $permohonan = new tmpermohonan();
    $daftar_id = $this->input->post('id_daftar');
    $permohonan->get_by_id($daftar_id);
    $perizinan = $permohonan->trperizinan->get();
    
    $entry_id = $this->input->post('entry_id');
    $property_id = $this->input->post('property_id');
    $entry = $this->input->post('property_value');
    $koefisien_id = $this->input->post('koefisien_id');
    $entry2 = $this->input->post('property_value2');
    $koefisien_id2 = $this->input->post('koefisien_id2');
    $entry_len = count($property_id);
    
    // PBS Create
    $permohonan->k_syarat1 = $this->input->post('syarat1');
    $permohonan->k_syarat2 = $this->input->post('syarat2');
    $permohonan->k_syarat3 = $this->input->post('syarat3');
    $permohonan->k_syarat4 = $this->input->post('syarat4');
    $permohonan->k_syarat5 = $this->input->post('syarat5');
    $permohonan->tgl_syarat = $this->input->post('tglsyarat');
    $permohonan->save();
    // EOF PBS
  
    $is_array = NULL;
    for($i = 0; $i < $entry_len; $i++) {
      if($is_array !== $property_id[$i]) {
        $entry_awal = new tmproperty_jenisperizinan();
        $entry_awal->where_related($permohonan)->get();
        $entry_awal->delete();
        $property_awal = new tmproperty_jenisperizinan_trproperty();
        $property_awal->where('tmproperty_jenisperizinan_id', $entry_id[$i])->get();
        $property_awal->delete();
      }
      $is_array = $property_id[$i];
    }
    $daftar_awal = new tmpermohonan_tmproperty_jenisperizinan();
    $daftar_awal->where('tmpermohonan_id', $daftar_id)->get();
    $daftar_awal->delete();
    $indeks_koefisien = 1;
    for($i = 0; $i < $entry_len; $i++) {
      if($is_array !== $property_id[$i]) {
        $relasi_entry = new trproperty();
        $relasi_entry->get_by_id($property_id[$i]);
        $entry_data = new tmproperty_jenisperizinan();
        $entry_data->pendaftaran_id = $permohonan->pendaftaran_id;
        $entry_data->v_property = $entry2[$i];
        $entry_data->k_property = $koefisien_id2[$i];
        $entry_data->v_tinjauan = $entry[$i];
        $entry_data->k_tinjauan = $koefisien_id[$i];
        if($koefisien_id[$i]) {
          $koef = new trkoefesientarifretribusi();
          $koef->get_by_id($koefisien_id[$i]);
          $indeks_koefisien = $indeks_koefisien * $koef->index_kategori;
        }
        /* Save tmproperty_jenisperizinan() & tmproperty_jenisperizinan_trproperty() */
        $entry_data->save($relasi_entry);
        $entry_data_id = new tmproperty_jenisperizinan();
        $entry_data_id->select_max('id')->get();
        /* Save tmpermohonan_tmproperty_jenisperizinan() */
        $entry_data_id->save($permohonan);
        
        //Luas Bangunan
        if($relasi_entry->id == '10')
          $luas = $entry[$i];
        if(empty($luas))
          $luas = 1;
        
        ## Awal Index Terintegrasi Bangunan Gedung
        //Fungsi
        if($relasi_entry->id == '11') {
          $koef_fungsi = new trkoefesientarifretribusi();
          $koef_fungsi->get_by_id($koefisien_id[$i]);
          $fungsi = $koef_fungsi->index_kategori;
        }
        if(empty($fungsi))
          $fungsi = 1;
        
        //Lingkup Pembangunan
        if($relasi_entry->id == '14') {
          $koef_lingkup = new trkoefesientarifretribusi();
          $koef_lingkup->get_by_id($koefisien_id[$i]);
          $lingkup = $koef_lingkup->index_kategori;
        }
        if(empty($lingkup))
          $lingkup = 1;
        
        //Waktu Penggunaan
        if($relasi_entry->id == '13') {
          $koef_waktu = new trkoefesientarifretribusi();
          $koef_waktu->get_by_id($koefisien_id[$i]);
          $waktu = $koef_waktu->index_kategori;
        }
        if(empty($waktu))
          $waktu = 1;
        
        $retribusi_imb_awal = new tmretribusi_rinci_imb();
        $retribusi_imb_awal->where_related($permohonan)->get();
        $retribusi_imb_awal->delete();
        
        if($relasi_entry->id == '12') { //Hanya untuk KLASIFIKASI
          $klasifikasi_id = $this->input->post('klasifikasi_id');
          $retribusi_id = $this->input->post('retribusi_id');
          $koef_value = $this->input->post('koef_value');
          $koef_id = $this->input->post('koef_id');
          $koef_value2 = $this->input->post('koef_value2');
          $koef_id2 = $this->input->post('koef_id2');
          $klasifikasi_len = count($retribusi_id);
          $is_array_klasifikasi = NULL;
          
          for($z = 0; $z < $klasifikasi_len; $z++) {
            if($is_array_klasifikasi !== $retribusi_id[$z]) {
              $klasifikasi_awal = new tmproperty_klasifikasi();
              $klasifikasi_awal->where_related($permohonan)->get();
              $klasifikasi_awal->delete();
              $retribusi_awal = new tmproperty_klasifikasi_trkoefesientarifretribusi();
              $retribusi_awal->where('tmproperty_klasifikasi_id', $klasifikasi_id[$z])->get();
              $retribusi_awal->delete();
            }
            $is_array_klasifikasi = $retribusi_id[$z];
          }
          $daftar_klasifikasi = new tmpermohonan_tmproperty_klasifikasi();
          $daftar_klasifikasi->where('tmpermohonan_id', $daftar_id)->get();
          $daftar_klasifikasi->delete();
          
          $indeks = 0;
          for($z = 0; $z < $klasifikasi_len; $z++) {
            if($is_array_klasifikasi !== $retribusi_id[$z]) {
              $relasi_klasifikasi = new trkoefesientarifretribusi();
              $relasi_klasifikasi->get_by_id($retribusi_id[$z]);
              $koef_parent = $relasi_klasifikasi->index_kategori;
              $koef_child = new trkoefisienretribusilev1();
              $koef_child->get_by_id($koef_id[$z]);
              $koef_child = $koef_child->index_kategori;
              $klasifikasi_data = new tmproperty_klasifikasi();
              $klasifikasi_data->pendaftaran_id = $permohonan->pendaftaran_id;
              $klasifikasi_data->v_klasifikasi = $koef_value2[$z];
              $klasifikasi_data->k_klasifikasi = $koef_id2[$z];
              $klasifikasi_data->v_tinjauan = $koef_value[$z];
              $klasifikasi_data->k_tinjauan = $koef_id[$z];
              /* Save tmproperty_klasifikasi() & tmproperty_klasifikasi_trkoefesientarifretribusi() */
              $klasifikasi_data->save($relasi_klasifikasi);
              $klasifikasi_data_id = new tmproperty_klasifikasi();
              $klasifikasi_data_id->select_max('id')->get();
              /* Save tmpermohonan_tmproperty_jenisperizinan() */
              $klasifikasi_data_id->save($permohonan);
              $indeks = $indeks + ($koef_parent * $koef_child);
              //if($relasi_klasifikasi->id == '104') $indeks = $koef_parent * $koef_child;
            }
            $is_array_klasifikasi = $retribusi_id[$z];
          }
        }else if ($relasi_entry->id == '29') { //Hanya untuk PRASARANA
          $prasarana_id = $this->input->post('prasarana_id');
          $retribusi_id3 = $this->input->post('retribusi_id3');
          $koef_value3 = $this->input->post('koef_value3');
          $koef_id3 = $this->input->post('koef_id3');
          $koef_value4 = $this->input->post('koef_value4');
          $koef_id4 = $this->input->post('koef_id4');
          $prasarana_len = count($retribusi_id3);
          $is_array_prasarana = NULL;
          
          for($x = 0; $x < $prasarana_len; $x++) {
            if($is_array_prasarana !== $retribusi_id3[$x]) {
              $prasarana_awal = new tmproperty_prasarana();
              $prasarana_awal->where_related($permohonan)->get();
              $prasarana_awal->delete();
              $retribusi_awal = new tmproperty_prasarana_trkoefesientarifretribusi();
              $retribusi_awal->where('tmproperty_prasarana_id', $prasarana_id[$x])->get();
              $retribusi_awal->delete();
            }
            $is_array_prasarana = $retribusi_id3[$x];
          }
          $daftar_prasarana = new tmpermohonan_tmproperty_prasarana();
          $daftar_prasarana->where('tmpermohonan_id', $daftar_id)->get();
          $daftar_prasarana->delete();
          
          $nilai_prasarana = 0;
          for($x = 0; $x < $prasarana_len; $x++) {
            if($is_array_prasarana !== $retribusi_id3[$x]) {
              $relasi_prasarana = new trkoefesientarifretribusi();
              $relasi_prasarana->get_by_id($retribusi_id3[$x]);
              $koef_child2 = new trkoefisienretribusilev1();
              $koef_child2->get_by_id($koef_id3[$x]);
              $prasarana_data = new tmproperty_prasarana();
              $prasarana_data->pendaftaran_id = $permohonan->pendaftaran_id;
              $prasarana_data->v_prasarana = $koef_value4[$x];
              $prasarana_data->k_prasarana = $koef_id4[$x];
              $prasarana_data->v_tinjauan = $koef_value3[$x];
              $prasarana_data->k_tinjauan = $koef_id3[$x];
              /* Save tmproperty_prasarana() & tmproperty_prasarana_trkoefesientarifretribusi() */
              $prasarana_data->save($relasi_prasarana);
              $prasarana_data_id = new tmproperty_prasarana();
              $prasarana_data_id->select_max('id')->get();
              /* Save tmpermohonan_tmproperty_jenisperizinan() */
              $prasarana_data_id->save($permohonan);
              
              if($koef_value3[$x]) {
                $imb_prasarana = $koef_value3[$x] * $koef_child2->index_kategori * $koef_child2->v_index_kategori;
                $retribusi_prasarana = new tmretribusi_rinci_imb();
                $retribusi_prasarana->e_parameter = $koef_value3[$x] . " x " . $koef_child2->index_kategori . " x Rp. " . $this->terbilang->nominal($koef_child2->v_index_kategori, 2);
                $retribusi_prasarana->e_parameter_parent = $koef_child2->kategori;
                $retribusi_prasarana->v_retribusi = $imb_prasarana;
                $retribusi_prasarana->c_imb = 2;
                $retribusi_prasarana->save($permohonan);
                $nilai_prasarana = $nilai_prasarana + $imb_prasarana;
              }
            }
            $is_array_prasarana = $retribusi_id3[$x];
          }
        }
      }
      $is_array = $property_id[$i];
    }
    $retribusi_parent = new trretribusi();
    $retribusi_parent->where_related($perizinan)->get();
    $nilai_retribusi = $retribusi_parent->v_retribusi;
    if($perizinan->id == '2' || $perizinan->id == '3') {
      $nilai_imb = $nilai_retribusi;
      $nilai_formulir = $retribusi_parent->v_denda;
      
      $nama_parameter = "BANGUNAN GEDUNG";
      $it = $fungsi * $lingkup * $indeks * $waktu;
      $nilai_retribusi = $luas * $it * 1.00 * $nilai_imb;
      $retribusi_imb = new tmretribusi_rinci_imb();
      $retribusi_imb->e_parameter = $luas . " m2 x " . $it . " x 1.00 x Rp. " . $this->terbilang->nominal($nilai_imb, 2);
      $retribusi_imb->e_parameter_parent = $nama_parameter;
      $retribusi_imb->v_retribusi = $nilai_retribusi;
      $retribusi_imb->c_imb = 1;
      $retribusi_imb->save($permohonan);
      
      $nilai_total = $nilai_retribusi + $nilai_prasarana + $nilai_formulir;
    }else{
      $nilai_total = $nilai_retribusi * $indeks_koefisien;
    }
    
    $bap_awal = $permohonan->tmbap->get();
    if($bap_awal->id) {
      $bap = new tmbap();
      $bap->get_by_id($bap_awal->id);
      $bap->nilai_retribusi = $nilai_total;
      $update = $bap->save($permohonan);
    }else{
      /* Input Data */
      $data_id = new tmbap();
      
      $data_id->select_max('id')->get();
      $data_id->get_by_id($data_id->id);
      
      $data_tahun = date("Y");
      //Per Tahun Auto Restart NoUrut
      if($permohonan->d_tahun === $data_tahun)
        $data_urut = $data_id->i_urut + 1;
      else
        $data_urut = 1;
      
      $i_urut = strlen($data_urut);
      for($i = 4; $i > $i_urut; $i--) {
        $data_urut = "0" . $data_urut;
      }
      
      $data_izin = $perizinan->id;
      $i_izin = strlen($data_izin);
      for($i = 3; $i > $i_izin; $i--) {
        $data_izin = "0" . $data_izin;
      }
      
      $data_bulan = $this->lib_date->set_month_roman(date("n"));
      
      $data_bap = "BAP";
      $no_bap = $data_urut . "/". $data_bap . "/" . $data_izin . "/". $data_bulan . "/" . $data_tahun;
      $data_skrd = "SKRD";
      $no_skrd = $data_urut . "/". $data_skrd . "/" . $data_izin . "/". $data_bulan . "/" . $data_tahun;
      $bap2 = new tmbap();
      $bap2->pendaftaran_id = $permohonan->pendaftaran_id;
      $bap2->nilai_retribusi = $nilai_total;
      $bap2->bap_id = $no_bap;
      $bap2->tgl_bap = $this->lib_date->get_date_now();
      $bap2->no_skrd = $no_skrd;
      $bap2->i_urut = $data_urut;
      $update = $bap2->save($permohonan);
    }
  
    $updated = FALSE;
    if($permohonan->c_tinjauan === "1")
      $updated = TRUE;
  
    $status_izin = $permohonan->trstspermohonan->get();
  
    $status_skr = "4"; //Survey Lokasi [Lihat Tabel trstspermohonan()] -> kominfo old 4
    $id_status = "4";  //BAP Lapangan [Lihat Tabel trstspermohonan()]  -> kominfo old 6
    if($status_izin->id == $status_skr) {
      /* Input Data Tracking Progress */
      //$sts_izin = new trstspermohonan();
      //$sts_izin->get_by_id($status_skr);
      //$data_status = new tmtrackingperizinan_trstspermohonan();
      //$list_tracking = $permohonan->tmtrackingperizinan->get();
      //if ($list_tracking) {
      //    $tracking_id = 0;
      //    foreach ($list_tracking as $data_track) {
      //        $data_status = new tmtrackingperizinan_trstspermohonan();
      //        $data_status->where('tmtrackingperizinan_id', $data_track->id)
      //                ->where('trstspermohonan_id', $sts_izin->id)->get();
      //        if ($data_status->tmtrackingperizinan_id) {
      //            $tracking_id = $data_status->tmtrackingperizinan_id;
      //        }
      //    }
      //}
      //$tracking_izin = new tmtrackingperizinan();
      //$tracking_izin->get_by_id($tracking_id);
      //$tracking_izin->pendaftaran_id = $permohonan->pendaftaran_id;
      //$tracking_izin->status = 'Update';
      //$tracking_izin->d_entry = $this->lib_date->get_datetime_now();
      //$tracking_izin->save();
      
      /* [Lihat Tabel trstspermohonan()] */
      //$tracking_izin2 = new tmtrackingperizinan();
      //$tracking_izin2->pendaftaran_id = $permohonan->pendaftaran_id;
      //$tracking_izin2->status = 'Insert';
      //$tracking_izin2->d_entry_awal = $this->lib_date->get_datetime_now();
      //$tracking_izin2->d_entry = $this->lib_date->get_datetime_now();
      //$sts_izin2 = new trstspermohonan();
      //$sts_izin2->get_by_id($id_status); //[Lihat Tabel trstspermohonan()]
      //$sts_izin2->save($permohonan);
      //$tracking_izin2->save($permohonan);
      //$tracking_izin2->save($sts_izin2);
    }
  
    $from = $this->input->post('from');
  
    $permohonan->tmsurat_rekomendasi->get();
    $surat_rekomendasi = new tmsurat_rekomendasi();
    if($permohonan->tmsurat_rekomendasi->count() > 0) {
      $id = $permohonan->tmsurat_rekomendasi->id;
      $surat_rekomendasi->where('id', $id)
                        ->update(array('no_surat' => $this->input->post('no_surat'),
                                       'tgl_surat' => $this->input->post('tgl_surat'),
                                       'deskripsi' => $this->input->post('deskripsi')
                        ));
    }else{
      $surat_rekomendasi->no_surat = $this->input->post('no_surat');
      $surat_rekomendasi->tgl_surat = $this->input->post('tgl_surat');
      $surat_rekomendasi->deskripsi = $this->input->post('deskripsi');
      $permohonan->where('id', $this->input->post('id_daftar'))->get();
      $surat_rekomendasi->save($permohonan);
    }
  
    $tgl = date("Y-m-d H:i:s");
    $u_ser = $this->session->userdata('username');
    $g = $this->sql2($u_ser);
    //$jam = date("H:i:s A");
    //$p = $this->db->query("call log ('Entry Tinjauan','Update " . $permohonan->pendaftaran_id . "','" . $tgl . "','" . $u_ser . "')");
  
    $permohonan->where('id', $daftar_id)
               ->update(array('c_tinjauan' => 1));
  
    if($update){
      if($from !== NULL &&
        $from !== "")
        redirect($from);
      else
        redirect('pendataan');
    }
  }

  public function delete() {
    redirect('survey/index_next');
  }

  public function edit($id = NULL, $method = 'save', $visitasi = NULL, $in_awal = NULL) {
    $pendaftaran = new tmpermohonan();
    $pendaftaran->where('id', $id)->get();
    $pendaftaran->tmpemohon->get();
    $pendaftaran->trperizinan->get();
    $pendaftaran->trtanggal_survey->get();
    
    $js_date = " $(function() {
                   $(\".survey\").datepicker({
                     changeMonth: true,
                     changeYear: true,
                     dateFormat: 'yy-mm-dd',
                     closeText: 'X'
                   });
                 });
               ";
    
    $js_date .= "$(document).ready(
                   function() {
                     $('#listizin').multiselect().multiselectfilter({
                       show:'blind',
                       hide:'blind',
                       selectedText:'# dari # terpilih'
                     }
                   );
                 });
                ";
    
    $permohonan = new tmpermohonan();
    $permohonan->where('id', $id)->get();
    $permohonan->tmpemohon->get();
    $permohonan->trperizinan->get();
    $permohonan->trperizinan->trsektor->get();
    $no_sp_awal = $permohonan->trperizinan->trsektor->no_sp_awal;
    $no_sp_akhir = $permohonan->trperizinan->trsektor->no_sp_akhir;
    
    $tanggal_tinjauan = $permohonan->trtanggal_survey->id;
    $pegawai_lists = new tmpegawai_trtanggal_survey();
    $pegawai_survey = $pegawai_lists->where('trtanggal_survey_id', $tanggal_tinjauan)
                                    ->where('type', 2)->get();
    $data['idp'] = $this->ambilPegawai($tanggal_tinjauan);
    
    if($pegawai_survey->id) {
      foreach($pegawai_survey as $list_pegawai) {
        $pegawai_tinjauan_lapangan = new tmpegawai();
        $pegawai_tinjauan_lapangan->where('id', $list_pegawai->tmpegawai_id)->get();
        $pegawai_tinjauan_lapangan->trunitkerja->get();
        $data['nama'] = $pegawai_tinjauan_lapangan->n_pegawai;
        $data['idpa'] = $pegawai_tinjauan_lapangan->id;
        
        $list_tim_pegawai[] = array('nama' => $pegawai_tinjauan_lapangan->n_pegawai,
                                    'nip' => $pegawai_tinjauan_lapangan->nip,
                                    'dinas' => $pegawai_tinjauan_lapangan->trunitkerja->n_unitkerja
                                    );
      }
    }else{
      $list_tim_pegawai[] = array('nama' => '','nip' => '','dinas' => '');
    }
    
    $this->template->set_metadata_javascript($js_date);
    
    $data['id_survey'] = $pendaftaran->trtanggal_survey->id;
    $data['save_method'] = $method;
    $data['pendaftaran_id'] = $pendaftaran->pendaftaran_id;
    $data['nama_pendaftar'] = $pendaftaran->tmpemohon->n_pemohon;
    $data['nama_perizinan'] = $pendaftaran->trperizinan->n_perizinan;
    $data['survey'] = $pendaftaran->d_survey;
    $data['survey_h'] = $pendaftaran->survey_sd;
    $data['berkas'] = $pendaftaran->d_terima_berkas;
    $data['id'] = $pendaftaran->id;
    $data['kirimID'] = $id;
    $data['method'] = $method;
    
    if($pendaftaran->trtanggal_survey->no_surat == 'Tidak Ditinjau') {
      if($in_awal == '1') {
        $data['visitasi'] = $visitasi; 
      }else{
        $data['visitasi'] = '1';
      }
    	$data['ctt_alasan'] = $pendaftaran->trtanggal_survey->keterangan;
    }else{
      $data['visitasi'] = $visitasi;
      $data['ctt_alasan'] = '';
    }
    //penomoran by system dimatikan
    //$no_surat = new LibNoSurat();                            //sementara matikan
    //$no = $no_surat->getNumber('survey', $pendaftaran->id);  //sementara matikan
    //if ($pendaftaran->trtanggal_survey->no_surat === NULL || $pendaftaran->trtanggal_survey->no_surat === "-") {
    //    $data['no_surat'] = $no;
    //} else {
    //    $data['no_surat'] = $pendaftaran->trtanggal_survey->no_surat;
    //    if($pendaftaran->trtanggal_survey->no_surat == 'Tidak Ditinjau'){
    //        $data['no_surat'] = $no;
    //	}
    //}
    //EOF() penomoran by system dimatikan
        
    //penomoran manual by bidang
    $no = '';
    $data['no_sp_awal'] = $no_sp_awal;
    $data['no_sp_akhir'] = $no_sp_akhir;
    if($method == 'save') $data['no_surat'] = ''; else $data['no_surat'] = $pendaftaran->trtanggal_survey->no_surat;
    //EOF() penomoran manual by bidang
        
    $survey_date = new trtanggal_survey();
    $survey_date->where('id', $pendaftaran->trtanggal_survey->id)->get();
    $survey_date->tmpegawai->get();
    
    $petugas = new tmpegawai();
    $data['petugas'] = $petugas->where('status = 1 OR status = 2')->get();
    $data['petugas_id'] = $survey_date->tmpegawai->id;
    
    $petugas = new tmpegawai();
    $data['list'] = $petugas->order_by('golongan', "DESC")->get();
    
    $this->load->vars($data);
    if($method == 'save') $xmethod = 'entry'; else $xmethod = 'update';
    $this->session_info['page_name'] = "Tinjauan Lapangan ( ". $xmethod . " data )";
    $this->template->build('edit', $this->session_info);
  }
  
  public function save() {
    $visitasi = $this->input->post('visitasi');  // jika '1' => tanpa peninjauan jika ' ' => dengan peninjauan
    $id_permohonan = $this->input->post('id_permohonan');
    $n_petugas = $this->input->post('petugas');
    if($visitasi == '1'){ // tidak ditinjau
      $ctt_alasan = $this->input->post('ctt_alasan');
      $n_surat = 'Tidak Ditinjau';	    
      $n_survey = date("Y-m-d");
      $n_survey_h = date("Y-m-d");
      $txt_aksi = 'Tidak Ditinjau';
    }else{   // ditinjau
      $ctt_alasan = 'Dilakukan Peninjauan';
      $n_surat = $this->input->post('no_surat');	    
      $n_survey = $this->input->post('survey');
      $n_survey_h = $this->input->post('survey_h');
      $txt_aksi = 'Penjadualan Tinjauan';
    }
    if($n_surat == '') $n_surat = 'xxx';
    $no_urut = intval(substr($n_surat, 0, 4));
    $permohonan = new tmpermohonan();
    $permohonan->where('id', $id_permohonan)->get();
    $no_pendaftaran = $permohonan->pendaftaran_id;
    
    $survey = new trtanggal_survey();
    $survey->no_surat_awal = $this->input->post('no_sp_awal');
    $survey->no_surat = $n_surat;
    $survey->no_surat_akhir = $this->input->post('no_sp_akhir');
    $survey->ttdpegawai_id = $n_petugas;
    $survey->i_urut = $no_urut;
    $survey->keterangan = $ctt_alasan;
    if($this->opd_teknis)
      $survey->userid_opdteknis = $this->id_user;
    else
      $survey->userid_ptsp = $this->id_user;
    $petugas_data = new tmpegawai();
    $petugas_data->where('id', $n_petugas)->get();
    
    if($survey->save(array($permohonan, $petugas_data))) {
      if($permohonan->kd_status < 3){ // ubah kd_status menjadi 3 untuk proses selanjutnya (Entry Hasil Tinjauan) dan sudah di jadualkan
        $permohonan->kd_status = 3;
        $permohonan->save();
      }
        
      $id = $survey->id;
      $this->permohonan->where('id', $id_permohonan)
           ->update(array('d_survey' => $survey->date = $n_survey,'survey_sd' => $survey_sd->date = $n_survey_h));
      
      $rel = new tmpegawai_trtanggal_survey();
      $rel->where('tmpegawai_id', $n_petugas);
      $rel->where('trtanggal_survey_id', $id)->get();
      $rel->type = intval(1); // Untuk Penandatangan SP
      $rel->save();
      
      $listpegawai = $this->input->post('listizin');
      foreach ($listpegawai as $list) {
        $rel = new tmpegawai_trtanggal_survey();
        $rel->tmpegawai_id = $list;
        $rel->trtanggal_survey_id = $id;
        $rel->type = intval(2);  // untuk pelaksana SP
        $rel->save();
      }
      
      /* Input Data Tracking Progress */
      $u_ser = $this->session->userdata('username');
      $r_name = $this->lib_date->get_nama_ori($u_ser);
      $tracking_izin2 = new tmtrackingperizinan();
      $tracking_izin2->where('pendaftaran_id', $no_pendaftaran)
                         ->where('tr_activiti', 'Pertimbangan Teknis')->get();
      if($tracking_izin2->pendaftaran_id){
        $tracking_izin2->status = 'Update';
        $tracking_izin2->d_entry = $this->lib_date->get_date_now();
        $tracking_izin2->tr_user = $u_ser;
        $tracking_izin2->tr_name = $r_name;
        $hit_ubah = $tracking_izin2->hit_ubah + 1;
        $his_ubah = $tracking_izin2->his_ubah;
        $tracking_izin2->hit_ubah = $hit_ubah;
        $tracking_izin2->his_ubah = $his_ubah.$txt_aksi.'^'.$r_name.'^'.$this->lib_date->get_date_now().';';
        $tracking_izin2->save();
      }
      /* EOF() Input Data Tracking Progress */
      
      $tgl = date("Y-m-d H:i:s");
      $u_ser = $this->session->userdata('username');
      $g = $this->sql2($u_ser);
      //$p = $this->db->query("call log ('Penjadwalan Tinjauan','Update " . $permohonan->pendaftaran_id . "','" . $tgl . "','" . $u_ser . "')");
      redirect('survey/index_next');
    }
  }

    public function update() {
        $visitasi = $this->input->post('visitasi');  // jika '1' => tanpa peninjauan jika ' ' => dengan peninjauan
		$id_permohonan = $this->input->post('id_permohonan');
		$n_petugas = $this->input->post('petugas');
		$listpegawai = $this->input->post('listizin');
		if($visitasi == '1'){ // tidak ditinjau
            $ctt_alasan = $this->input->post('ctt_alasan');
            $n_surat = 'Tidak Ditinjau';	    
			$n_survey = date("Y-m-d");
			$n_survey_h = date("Y-m-d");
			$txt_aksi = 'Tidak Ditinjau';
		}else{   // ditinjau
		    $ctt_alasan = 'Dilakukan Peninjauan';
			$n_surat = $this->input->post('no_surat');	    
			$n_survey = $this->input->post('survey');
			$n_survey_h = $this->input->post('survey_h');
			$txt_aksi = 'PenJadualan Tinjauan';
		}
		if($n_surat == '') $n_surat = 'xxx';
		$permohonan = new tmpermohonan();
        $permohonan->where('id', $id_permohonan)->get();
		$no_pendaftaran = $permohonan->pendaftaran_id;

		$survey = new trtanggal_survey();
        if($this->opd_teknis){
            $update = $survey->where('id', $this->input->post('id_survey'))
                             ->update(array('no_surat' => $survey->no_surat = $n_surat,
			                                'ttdpegawai_id' => $survey->ttdpegawai_id = $n_petugas,
			                                'keterangan' => $survey->keterangan = $ctt_alasan,
			                                'userid_opdteknis' => $survey->userid_opdteknis = $this->id_user
                         ));
        }else{
			$update = $survey->where('id', $this->input->post('id_survey'))
                             ->update(array('no_surat' => $survey->no_surat = $n_surat,
			                                'ttdpegawai_id' => $survey->ttdpegawai_id = $n_petugas,
			                                'keterangan' => $survey->keterangan = $ctt_alasan,
			                                'userid_ptsp' => $survey->userid_ptsp = $this->id_user
                         ));
        }

        $query = "DELETE FROM tmpegawai_trtanggal_survey
                  where trtanggal_survey_id = " . $this->input->post('id_survey');
        $results = mysql_query($query);

        $rel = new tmpegawai_trtanggal_survey();
        $rel->tmpegawai_id = $n_petugas;
        $rel->trtanggal_survey_id = $this->input->post('id_survey');
        $rel->type = intval(1);
        $rel->save();

        foreach ($listpegawai as $list) {
            $rel = new tmpegawai_trtanggal_survey();
            $rel->tmpegawai_id = $list;
            $rel->trtanggal_survey_id = $this->input->post('id_survey');
            $rel->type = intval(2);
            $rel->save();
        }

        if ($update)
            $this->permohonan->where('id', $id_permohonan)
                 ->update(array('d_survey' => $survey->date = $n_survey,'survey_sd' => $survey->date = $n_survey_h));

        /* Input Data Tracking Progress */
		$u_ser = $this->session->userdata('username');
    	$r_name = $this->lib_date->get_nama_ori($u_ser);
        $tracking_izin2 = new tmtrackingperizinan();
        $tracking_izin2->where('pendaftaran_id', $no_pendaftaran)
                       ->where('tr_activiti', 'Pertimbangan Teknis')->get();
		if($tracking_izin2->pendaftaran_id){
            $tracking_izin2->status = 'Update';
            $tracking_izin2->d_entry = $this->lib_date->get_date_now();
            $tracking_izin2->tr_user = $u_ser;
            $tracking_izin2->tr_name = $r_name;
    	    $hit_ubah = $tracking_izin2->hit_ubah + 1;
            $his_ubah = $tracking_izin2->his_ubah;
   	     	$tracking_izin2->hit_ubah = $hit_ubah;
	        $tracking_izin2->his_ubah = $his_ubah.'Edit PenJadualan Tinjauan^'.$r_name.'^'.$this->lib_date->get_date_now().';';
            $tracking_izin2->save();
        }
        /* EOF() Input Data Tracking Progress */

        $tgl = date("Y-m-d H:i:s");
        $u_ser = $this->session->userdata('username');
        $g = $this->sql2($u_ser);
        $nomor = $this->permohonan->get_by_id($this->input->post('id_permohonan'));
        //$p = $this->db->query("call log ('Penjadwalan Tinjauan','Update " . $nomor->pendaftaran_id . "','" . $tgl . "','" . $u_ser . "')");
        redirect('survey/index_next');
    }

    public function update_old() {
		$permohonan = new tmpermohonan();
        $permohonan->where('id', $this->input->post('id_permohonan'))->get();
		$no_pendaftaran = $permohonan->pendaftaran_id;
        $survey = new trtanggal_survey();
        /**
         * Just use trtanggal_survey, because we just need it.
         * so it simple to update record
         */
        $update = $survey->where('id', $this->input->post('id_survey'))
                         ->update(array('no_surat' => $survey->no_surat = $this->input->post('no_surat'),
			                            'ttdpegawai_id' => $survey->ttdpegawai_id =  $this->input->post('petugas')
                         ));
        $query = "DELETE FROM tmpegawai_trtanggal_survey
                  where trtanggal_survey_id = " . $this->input->post('id_survey');
        $results = mysql_query($query);

        $rel = new tmpegawai_trtanggal_survey();
        $rel->tmpegawai_id = $this->input->post('petugas');
        $rel->trtanggal_survey_id = $this->input->post('id_survey');
        $rel->type = intval(1);
        $rel->save();

        $listpegawai = $this->input->post('listizin');
        foreach ($listpegawai as $list) {
            $rel = new tmpegawai_trtanggal_survey();
            $rel->tmpegawai_id = $list;
            $rel->trtanggal_survey_id = $this->input->post('id_survey');
            $rel->type = intval(2);
            $rel->save();
        }

        if ($update)
            $this->permohonan->where('id', $this->input->post('id_permohonan'))
                 ->update(array('d_survey' => $survey->date = $this->input->post('survey'),
                                'survey_sd' => $survey->date = $this->input->post('survey_h')
                 ));

        /* Input Data Tracking Progress */
		$u_ser = $this->session->userdata('username');
    	$r_name = $this->lib_date->get_nama_ori($u_ser);
        $tracking_izin2 = new tmtrackingperizinan();
        $tracking_izin2->where('pendaftaran_id', $no_pendaftaran)
                       ->where('tr_activiti', 'Pertimbangan Teknis')->get();
		if($tracking_izin2->pendaftaran_id){
            $tracking_izin2->status = 'Update';
            $tracking_izin2->d_entry = $this->lib_date->get_date_now();
            $tracking_izin2->tr_user = $u_ser;
            $tracking_izin2->tr_name = $r_name;
    	    $hit_ubah = $tracking_izin2->hit_ubah + 1;
            $his_ubah = $tracking_izin2->his_ubah;
   	     	$tracking_izin2->hit_ubah = $hit_ubah;
	        $tracking_izin2->his_ubah = $his_ubah.'Edit PenJadualan Tinjauan^'.$r_name.'^'.$this->lib_date->get_date_now().';';
            $tracking_izin2->save();
        }
        /* EOF() Input Data Tracking Progress */

        $tgl = date("Y-m-d H:i:s");
        $u_ser = $this->session->userdata('username');
        $g = $this->sql2($u_ser);
        $nomor = $this->permohonan->get_by_id($this->input->post('id_permohonan'));
        //$p = $this->db->query("call log ('Penjadwalan Tinjauan','Update " . $nomor->pendaftaran_id . "','" . $tgl . "','" . $u_ser . "')");
        redirect('survey/index_next');
    }

    public function kyResult($id=NULL, $kyLv=NULL, $menu=NULL) {
		$permohonan = new tmpermohonan();
        $permohonan->where('id', $id)->get();
		$izin = $permohonan->trperizinan->get();
        $tmky = new tmpermohonan_ky();
		$tmky = $tmky->where('tmpermohonan_id', $id)->get();
        if(!$tmky->id){
			$tmky = new tmpermohonan_ky();
			$tmky->tmpermohonan_id = $id;
		}
	    $tgl_cek = date("Y-m-d h:i:s");
	    $dt_text = $this->lib_date->all_property($izin->id, $id);
		$kyData  = 'ky_'.md5($dt_text);
        switch ($kyLv){
            case 1:      // stafOPD
			    $tmky->resultDT      = $dt_text;
                $tmky->kyStafOPD     = $kyData;
                $tmky->tg_kyStafOPD  = $tgl_cek;
				$permohonan->approve = 9;  // approve staf PD
				$tmky->save();
        		$permohonan->save();
                break;
            case 2:      // esl4OPD
                //$tmky->kyEsl4OPD     = $kyData;
                //$tmky->tg_kyEsl4OPD  = $tgl_cek;
                break;
            case 3:      // esl3OPD
                //$tmky->kyEsl3OPD     = $kyData;
                //$tmky->TG_kyEsl3OPD  = $tgl_cek;
                break;
            case 4:      // KaOPD
                //$tmky->kyKaOPD       = $kyData;
                //$tmky->tg_kyKaOPD    = $tgl_cek;		 
                break;
            case 5:      // stafPTSP
                //$tmky->kyStafPTSP    = $kyData;
                //$tmky->tg_kyStafPTSP = $tgl_cek;
                break;
            case 6:      // esl4PTSP
                //$tmky->kyEsl4PTSP    = $kyData;
                //$tmky->tg_kyEsl4PTSP = $tgl_cek;
                break;
            case 7:      // esl3PTSP
                //$tmky->kyEsl3PTSP    = $kyData;
                //$tmky->tg_kyEsl3PTSP = $tgl_cek;
                break;
            case 8:      // KaPTSP
                //$tmky->kyKaPTSP      = $kyData;
                //$tmky->tg_kyKaPTSP   = $tgl_cek;
                break;
        }
		if($menu=='1'){
            redirect('survey/result_next');
		}else{
			redirect('survey/result_next');
		}
	}

    public function cetakBAP($id = NULL, $pointer = NULL) {
        $nama_surat = NULL;
        $this->settings = new settings();
        $this->settings->where('name', 'app_folder')->get();
        $app_folder = $this->settings->value . "/";
//        $app_city = $this->settings->where('name', 'app_city')->get();
        $app_city = $this->sql();
        $app_kan = $this->settings->where('name', 'app_kantor')->get();

//        if ($pointer !== '2') {
            $nama_surat = "cetak_bap_survey";
//        } else {
//            $nama_surat = "cetak_bap_survey_imb";
//        }

        $this->load->plugin('odf');
        $odf = new odf('assets/odt/' . $nama_surat . '.odt');

        //logo
        $this->tr_instansi = new Tr_instansi();
        $logo = $this->tr_instansi->get_by_id(23);
        if ($logo->value !== "") {
            $odf->setImage('logo', 'uploads/logo/' . $logo->value, '2.1', '2.5');
        } else {
            $odf->setVars('logo', ' ');
        }

        //pemerintah 
        $this->tr_instansi = new Tr_instansi();
        $nama_prov = $this->tr_instansi->get_by_id(17);
        $odf->setVars('provinsi', strtoupper($nama_prov->value));

		//provinsi 
        $this->tr_instansi = new Tr_instansi();
        $nama_prov1 = $this->tr_instansi->get_by_id(18);
        $odf->setVars('provinsi1', strtoupper($nama_prov1->value));

        //badan
        $this->tr_instansi = new Tr_instansi();
        $nama_bdan = $this->tr_instansi->get_by_id(9);
        $odf->setVars('badan', strtoupper($nama_bdan->value));

        //telpon
        $this->tr_instansi = new Tr_instansi();
        $tlp = $this->tr_instansi->get_by_id(10);
        $odf->setVars('tlp', $tlp->value);

        //fax
        $this->tr_instansi = new Tr_instansi();
        $tlp = $this->tr_instansi->get_by_id(13);
        $odf->setVars('fax', $tlp->value);

        //alamat
        $this->tr_instansi = new Tr_instansi();
        $n_alamat = $this->tr_instansi->get_by_id(12);
        $odf->setVars('alamat', $n_alamat->value);

        //web
        $this->tr_instansi = new Tr_instansi();
        $web = $this->tr_instansi->get_by_id(21);
        $odf->setVars('website', $web->value);

		//e-mail
        $this->tr_instansi = new Tr_instansi();
        $e_mail = $this->tr_instansi->get_by_id(22);
        $odf->setVars('email', $e_mail->value);

        //Kop Kota
        $this->tr_instansi = new Tr_instansi();
        $kop_kota = $this->tr_instansi->get_by_id(19);
//        $odf->setVars('k_kota', $kop_kota->value);
		$odf->setVars('k_kota_besar', strtoupper($kop_kota->value));

        //Kode Pos
        $this->tr_instansi = new Tr_instansi();
        $kode_pos = $this->tr_instansi->get_by_id(20);
        $odf->setVars('kd_pos', $kode_pos->value);

        $permohonan = new tmpermohonan();
        $permohonan->where('id', $id)->get();
        $permohonan->tmpemohon->get();
        $permohonan->trtanggal_survey->get();
        $tanggal_tinjauan = $permohonan->trtanggal_survey->id;
        $permohonan->trperizinan->get();
        $permohonan->tmperusahaan->get();
        $pegawai = new tmpegawai();
        $pegawai->where('status', 1)->get();
        $odf->setVars('nama_izin', $permohonan->trperizinan->n_perizinan);
        $odf->setVars('nomor_bap', $permohonan->trtanggal_survey->no_surat);
        $odf->setVars('no_pendaftaran', $permohonan->pendaftaran_id);
        $odf->setVars('nama_pemohon', $permohonan->tmpemohon->n_pemohon);
        $odf->setVars('no_telp', $permohonan->tmpemohon->telp_pemohon);
        $odf->setVars('lokasi_usaha', $permohonan->a_izin);
        $date = new Lib_date();
        $odf->setVars('tanggal_bap', "\t\t\t" . $date->mysql_to_human($permohonan->d_survey));
        $odf->setVars('hari', $date->get_day($permohonan->d_survey));
        $odf->setVars('tanggal', $this->lib_date->mysql_to_human($this->lib_date->get_datetime_now()));
        $pegawai = new tmpegawai();
        $pegawai->where('status', 1)->get();
        $odf->setVars('jabatan', $pegawai->n_jabatan);
        $odf->setVars('nama_pejabat', $pegawai->n_pegawai);
        $odf->setVars('nip_pejabat', $pegawai->nip);
        $odf->setVars('kantor', $app_kan->value);

        $this->tr_instansi = new Tr_instansi();
        $alamat = $this->tr_instansi->get_by_id(12);
        if (isset($app_city->n_kabupaten)) {
            $gede_kota = strtoupper($app_city->n_kabupaten);
            $kecil_kota = ucwords(strtolower($app_city->n_kabupaten));
//            $odf->setVars('kota4', $gede_kota);
            $odf->setVars('kota', $app_city->ibukota);
//            if (isset($alamat->value)) {
//                $odf->setVars('alamat', ucwords(strtolower($alamat->value)) . ' - ' . $kecil_kota);
//            } else {
//                $odf->setVars('alamat', '--------');
//            }
//        } else {
//            $odf->setVars('kota4', '---------');
//            $odf->setVars('kota', '--------');
//            $odf->setVars('alamat', '--------');
        }
        //alamat




        $wilayah = new trkabupaten();
        $kelurahan = $permohonan->tmpemohon->trkelurahan->get();
        $kelurahan->trkecamatan->get();
        $kelurahan->trkecamatan->trkabupaten->get();
        $alamat = NULL;
//        if ($app_city->value !== '0') {
//            $alamat = $permohonan->tmpemohon->a_pemohon . ' ' . $kelurahan->n_kelurahan . ', ' .
//                    $kelurahan->trkecamatan->n_kecamatan . ', ' . ucwords(strtolower($kelurahan->trkecamatan->trkabupaten->n_kabupaten));
//            $wilayah->get_by_id($app_city->value);
//            $odf->setVars('kota', strtoupper($wilayah->n_kabupaten));
//        } else {
//            $alamat = $pemohon->a_pemohon;
//            $odf->setVars('kota', '...........');
//        }

        $odf->setVars('alamat_pemohon', $permohonan->tmpemohon->a_pemohon);
        $pegawai_lists = new tmpegawai_trtanggal_survey();
        $pegawai_survey = $pegawai_lists
                        ->where('trtanggal_survey_id', $tanggal_tinjauan)
                        ->where('type', 2)->get();

        foreach ($pegawai_survey as $list_pegawai) {
            $pegawai_tinjauan_lapangan = new tmpegawai();
            $pegawai_tinjauan_lapangan->where('id', $list_pegawai->tmpegawai_id)->get();

            $pegawai_tinjauan_lapangan->trunitkerja->get();
            $list_tim_pegawai[] = array(
                'nama' => $pegawai_tinjauan_lapangan->n_pegawai,
                'nip' => $pegawai_tinjauan_lapangan->nip,
                'dinas' => $pegawai_tinjauan_lapangan->trunitkerja->n_unitkerja
            );
        }

        $i = 0;
        $articles3 = $odf->setSegment('petugas');
        foreach ($list_tim_pegawai as $element3) {
            $i++;
            $articles3->no($i . ".");
            $articles3->nama($element3['nama']);
            $articles3->dinas($element3['dinas']);
            $articles3->merge();
        }
        $odf->mergeSegment($articles3);

//        if ($pointer !== '2') {
            $perizinan = new trperizinan();
            $perizinan->get_by_id($pointer);

            $lists = $perizinan->trproperty->include_join_fields()->where('c_type', 2)->order_by('c_parent_order', "asc")->get();
 //sahal           
 //           $property = $odf->setSegment('property');
 //           foreach ($lists as $list) {
            
 //               $property->nama($list->n_property);
 //               $children = $perizinan->trproperty->where_join_field($perizinan, 'c_parent', $list->id)->include_join_fields()->order_by('c_order', "asc")->get();
                
 //               foreach ($children as $child_) {
 //                   if ($list->id !== $child_->id) {
 //                       $property->child->child($child_->n_property);
 //                       if ($child_->join_c_retribusi_id === '1') {
 //                           $property->child->indeks(" ");
 //                       } else {
 //                           $property->child->indeks(" ");
 //                       }
 //                       $property->child->merge();
 //                   }
 //               }
 //               $property->merge();
//            }
 //           $odf->mergeSegment($property);
//        }
//sahal

        $tgl = date("Y-m-d H:i:s");
        $u_ser = $this->session->userdata('username');
        $g = $this->sql2($u_ser);
//      $jam = date("H:i:s A");
        //$p = $this->db->query("call log ('Penjadwalan Tinjauan','Cetak Berita Acara Pemeriksaan " . $permohonan->pendaftaran_id . "','" . $tgl . "','" . $u_ser . "')");
        
		//export the file
        $no_daftar = str_replace('/', '', $permohonan->pendaftaran_id);
        $odf->exportAsAttachedFile($nama_surat . '_' . $no_daftar . '.odt');
    }

   public function create_multi_sp($tgla=NULL,$tglb=NULL) {
		$lokasi_user = $this->session->userdata('lokasi');
		$username = new user();
        $username->where('username', $this->session->userdata('username'))->get();
		$group = $username->group;

		$data['lokasi'] = $username->lokasi;
        $data['group'] = $group;
		$data['tgla'] = $tgla;
        $data['tglb'] = $tglb;
		$data['checked'] = FALSE;

//        $data['list'] = $this->main_sql($username->id,$tgla,$tglb,$lokasi_user,$group)->result();
        //$qry = $this->main_sql($username->id,$tgla,$tglb,$lokasi_user,$group);
		//$data['list'] = $this->db->query($qry)->result();
		$data['list'] = $this->main_sql($username->id,$tgla,$tglb,$lokasi_user); // = $query;
        $data['c_bap'] = "1";

        $this->load->vars($data);

        $js = "
               $(document).ready(function() {
                   oTable = $('#cetakizin').dataTable({
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

			   function check_uncheckAll(field,nilai){
					for(i=0; i< field.length; i++){
						field[i].checked=nilai;
					}
				}

               function finishAjax(id, response){
                   $('#'+id).html(unescape(response));
                   $('#'+id).fadeIn();
               }

              ";

        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "Create Surat Perintah Peninjauan Lapangan (Multi)";
        $this->template->build('create_multi_sp', $this->session_info);
	}

	public function cetak_multi_sp($tgla=NULL,$tglb=NULL) {
		$lokasi_user = $this->session->userdata('lokasi');
		$username = new user();
        $username->where('username', $this->session->userdata('username'))->get();
		$group = $username->group;

		$data['lokasi'] = $username->lokasi;
        $data['group'] = $group;
		$data['tgla'] = $tgla;
        $data['tglb'] = $tglb;
		$data['checked'] = FALSE;

//        $data['list'] = $this->main_sql($username->id,$tgla,$tglb,$lokasi_user,$group)->result();
        //$qry = $this->main_sql($username->id,$tgla,$tglb,$lokasi_user,$group);
		//$data['list'] = $this->db->query($qry)->result();
		$data['list'] = $this->main_sql($username->id,$tgla,$tglb,$lokasi_user); // = $query;
        $data['c_bap'] = "1";

        $this->load->vars($data);

        $js = "
               $(document).ready(function() {
                   oTable = $('#cetakizin').dataTable({
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

			   function check_uncheckAll(field,nilai){
					for(i=0; i< field.length; i++){
						field[i].checked=nilai;
					}
				}

               function finishAjax(id, response){
                   $('#'+id).html(unescape(response));
                   $('#'+id).fadeIn();
               }

              ";

        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "Cetak Surat Perintah Peninjauan Lapangan (Multi)";
        $this->template->build('cetak_multi_sp', $this->session_info);
	}

	public function sp_multi() {
		$lokasi_user = $this->session->userdata('lokasi');

		$tgla = $this->input->post('tgla');
        $tglb = $this->input->post('tglb');
        $now = $this->lib_date->get_date_now();
        $tgl_before = $this->lib_date->set_date($now, -7);
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
        
		$query = "SELECT A.id, A.no_surat, B.tmpegawai_id, B.trtanggal_survey_id, C.n_pegawai, E.d_survey, E.survey_sd, E.trkelurahan_id, E.id permohonan_id,
		          E.kontak_person kontak3, E.a_izin, G.n_pemohon, G.telp_pemohon kontak1, I.id idizin, I.n_perizinan
				  FROM trtanggal_survey as A
				  INNER JOIN tmpegawai_trtanggal_survey as B ON B.trtanggal_survey_id = A.id
				  INNER JOIN tmpegawai as C ON C.ID = B.tmpegawai_id
				  INNER JOIN tmpermohonan_trtanggal_survey as D ON D.trtanggal_survey_id = A.id
				  INNER JOIN tmpermohonan as E ON E.id = D.tmpermohonan_id
				  INNER JOIN tmpemohon_tmpermohonan as F ON F.tmpermohonan_id = E.id
                  INNER JOIN tmpemohon as G ON G.id = F.tmpemohon_id
				  INNER JOIN tmpermohonan_trperizinan as H ON H.tmpermohonan_id = E.id
                  INNER JOIN trperizinan as I ON I.id = H.trperizinan_id
				 ";
		$data['list'] = $query;
        $this->load->vars($data);

        $js = $this->index_js();
		$this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "Create Surat Perintah Visitasi Multi";
        $this->template->build('list_sp_multi', $this->session_info);
    }

	public function create_multi($create = NULL, $no_srt = NULL) {
// Input penjadwalan ........
        $id_permohonan = $this->input->post('pilih_cetak');
		$data['id_permohonan'] = $id_permohonan;
        
		// cek saja 
		$id = 0; $id_per = 0; $method = ''; $visitasi = '';
		// cek saja 
		
        $pendaftaran = new tmpermohonan();
        $pendaftaran->where('id', $id)->get();
        $pendaftaran->tmpemohon->get();
        $pendaftaran->trperizinan->get();
        $pendaftaran->trtanggal_survey->get();

        $js_date = " 
		             $(function() {
                         $(\".survey\").datepicker({
                             changeMonth: true,
                             changeYear: true,
                             dateFormat: 'yy-mm-dd',
                             closeText: 'X'
                         });
                     });
                   ";

		$js_date .= "
                      $(document).ready(
                      function() {
                          $('#listizin').multiselect().multiselectfilter({
                              show:'blind',
                              hide:'blind',
                              selectedText:'# dari # terpilih'
                          });
                      });
					";

        $permohonan = new tmpermohonan();
        $permohonan->where('id', $id)->get();
        $permohonan->tmpemohon->get();
        $tanggal_tinjauan = $permohonan->trtanggal_survey->id;
        $pegawai_lists = new tmpegawai_trtanggal_survey();
        $pegawai_survey = $pegawai_lists->where('trtanggal_survey_id', $tanggal_tinjauan)
                                        ->where('type', 2)->get();

        $data['idp'] = $this->ambilPegawai($tanggal_tinjauan);

		if ($pegawai_survey->id) {
            foreach ($pegawai_survey as $list_pegawai) {
                $pegawai_tinjauan_lapangan = new tmpegawai();
                $pegawai_tinjauan_lapangan->where('id', $list_pegawai->tmpegawai_id)->get();


                $pegawai_tinjauan_lapangan->trunitkerja->get();
                $data['nama'] = $pegawai_tinjauan_lapangan->n_pegawai;
                $data['idpa'] = $pegawai_tinjauan_lapangan->id;

                $list_tim_pegawai[] = array(
                    'nama' => $pegawai_tinjauan_lapangan->n_pegawai,
                    'nip' => $pegawai_tinjauan_lapangan->nip,
                    'dinas' => $pegawai_tinjauan_lapangan->trunitkerja->n_unitkerja
                );
            }
        } else {
            $list_tim_pegawai[] = array(
                'nama' => '',
                'nip' => '',
                'dinas' => ''
            );
        }

//        $data['list_tim_pegawai']=$list_tim_pegawai;

        $this->template->set_metadata_javascript($js_date);

        $data['id_survey'] = $pendaftaran->trtanggal_survey->id;
        $data['save_method'] = $method;
        $data['pendaftaran_id'] = $pendaftaran->pendaftaran_id;
        $data['nama_pendaftar'] = $pendaftaran->tmpemohon->n_pemohon;
        $data['nama_perizinan'] = $pendaftaran->trperizinan->n_perizinan;
        $data['survey'] = $pendaftaran->d_survey;
		$data['survey_h'] = $pendaftaran->survey_sd;
        $data['berkas'] = $pendaftaran->d_terima_berkas;
        $data['id'] = $pendaftaran->id;
		$data['kirimID'] = $id;
		$data['method'] = $method;

		if($pendaftaran->trtanggal_survey->no_surat == 'Tidak Ditinjau') {
		    if($in_awal == '1') {
			    $data['visitasi'] = $visitasi; 
		    }else{
			    $data['visitasi'] = '1';
		    }
			$data['ctt_alasan'] = $pendaftaran->trtanggal_survey->keterangan;
	    }else{
		    $data['visitasi'] = $visitasi;
		    $data['ctt_alasan'] = '';
		}
        $no_surat = new LibNoSurat();
        $no = $no_surat->getNumber('survey', $pendaftaran->id);
        if ($pendaftaran->trtanggal_survey->no_surat === NULL || $pendaftaran->trtanggal_survey->no_surat === "-") {
            $data['no_surat'] = $no;
        } else {
            $data['no_surat'] = $pendaftaran->trtanggal_survey->no_surat;
            if($pendaftaran->trtanggal_survey->no_surat == 'Tidak Ditinjau'){
                $data['no_surat'] = $no;
			}
        }

        $survey_date = new trtanggal_survey();
        $survey_date->where('id', $pendaftaran->trtanggal_survey->id)->get();
        $survey_date->tmpegawai->get();

        $petugas = new tmpegawai();
        $data['petugas'] = $petugas->where('status = 1 OR status = 2')->get();
        $data['petugas_id'] = $survey_date->tmpegawai->id;

        $petugas = new tmpegawai();
//        $data['list'] = $petugas->where('status', 0)->order_by('golongan', "DESC")->get();
        $data['list'] = $petugas->order_by('golongan', "DESC")->get();

        $this->load->vars($data);
		if($method == 'save') $xmethod = 'entry'; else $xmethod = 'update';
        $this->session_info['page_name'] = "Create SP Visitasi ( Multi )";
        $this->template->build('edit_multi', $this->session_info);
// EOF Input penjadwalan ........


//		echo $create; die;
		// Area Save .....
		if($create == '0'){  // create SP Multi
    		$syarat = $this->input->post('pilih_cetak');
            $syarat_len = count($syarat);
	    	$cek_len = count($syarat) - 1;
    		$is_array = NULL;
	    	$txt_perusahaan = '';
            for ($is = 0; $is < $syarat_len; $is++) {
                $m_permohonan = new tmpermohonan();
                $m_permohonan = $m_permohonan->get_by_id($syarat[$is]);
	    		$tanggal_survey = $m_permohonan->trtanggal_survey->get();
    			//$tanggal_survey->multi = '1';
				//$tanggal_survey->surat_multi = 1;
	    		//$tanggal_survey->save();
    		}
		}else{
            $tanggal_survey = new trtanggal_survey();
            //$tanggal_survey->where('multi', '1')->where('surat_multi', $no_srt)
            //               ->update(array('multi' => '0', 'surat_multi' => '0'));
		}
		// EOF() Area Save .....
    }

    public function cetak($id = NULL) {    // Cetak Surat Perintah
		$syarat = $this->input->post('pilih_cetak');
        $syarat_len = count($syarat);
		$cek_len = count($syarat) - 1;
		$is_array = NULL;
		$multi = FALSE;
		if($id == ''){ //dari pilihan multi
		    $multi = TRUE;
		} else {
            $cek_len = 1;
			$syarat = $id;
		}

        for ($i = 0; $i < $syarat_len; $i++) {
            $is_array = $syarat[$i];
        }

		$this->settings = new settings();
        $this->settings->where('name', 'app_folder')->get();
        $app_folder = $this->settings->value . "/";

        $app_kan = $this->settings->where('name', 'app_kantor')->get();

        $nama_surat = "cetak_tinjauan_lapangan";
        $this->load->plugin('odf');
        $odf = new odf('assets/odt/' . $nama_surat . '.odt');

        //logo
        $this->tr_instansi = new Tr_instansi();
        $logo = $this->tr_instansi->get_by_id(23);
        //if ($logo->value !== "") {
        //    $odf->setImage('logo', 'uploads/logo/' . $logo->value, '2.1', '2.5');
        //} else {
            $odf->setVars('logo', ' ');
        //}

        //pemerintah provinsi
        $this->tr_instansi = new Tr_instansi();
        $nama_prov = $this->tr_instansi->get_by_id(17);
        $odf->setVars('provinsi', strtoupper($nama_prov->value));

        //provinsi 
        $this->tr_instansi = new Tr_instansi();
        $nama_prov1 = $this->tr_instansi->get_by_id(18);
        $odf->setVars('provinsi1', strtoupper($nama_prov1->value));

        //badan
        $this->tr_instansi = new Tr_instansi();
        $nama_bdan = $this->tr_instansi->get_by_id(9);
        $odf->setVars('badan', 'a.n KEPALA '.strtoupper($nama_bdan->value));

        //telpon
        $this->tr_instansi = new Tr_instansi();
        $tlp = $this->tr_instansi->get_by_id(10);
        $odf->setVars('tlp', $tlp->value);

        //fax
        $this->tr_instansi = new Tr_instansi();
        $tlp = $this->tr_instansi->get_by_id(13);
        $odf->setVars('fax', $tlp->value);

        //alamat
        $this->tr_instansi = new Tr_instansi();
        $n_alamat = $this->tr_instansi->get_by_id(12);
        $odf->setVars('alamat', $n_alamat->value);

		//web
        $this->tr_instansi = new Tr_instansi();
        $web = $this->tr_instansi->get_by_id(21);
        $odf->setVars('website', $web->value);

		//e-mail
        $this->tr_instansi = new Tr_instansi();
        $e_mail = $this->tr_instansi->get_by_id(22);
        $odf->setVars('email', $e_mail->value);

		//Kop Kota
        $this->tr_instansi = new Tr_instansi();
        $kop_kota = $this->tr_instansi->get_by_id(19);
		$odf->setVars('k_kota_besar', strtoupper($kop_kota->value));

        //Kode Pos
        $this->tr_instansi = new Tr_instansi();
        $kode_pos = $this->tr_instansi->get_by_id(20);
        $odf->setVars('kd_pos', $kode_pos->value);

		$txt_perusahaan = '';
	    $txt_tujuan     = ''; 


        $permohonan = new tmpermohonan();
		if($multi){ //cetak multi
			$permohonan = $permohonan->get_by_id($syarat[0]);
		}else{      //cetak satu
            $permohonan = $permohonan->get_by_id($syarat);
		}
		$no_pendaftaran = $permohonan->pendaftaran_id;
		$kd_kel_objek = $permohonan->trkelurahan_id;
        $permohonan->tmpemohon->get();
		$permohonan->tmpemohon->trkelurahan->get();
		$permohonan->tmpemohon->trkelurahan->trkecamatan->get();
		$permohonan->tmpemohon->trkelurahan->trkecamatan->trkabupaten->get();
        $permohonan->trtanggal_survey->get();
        $tanggal_tinjauan = $permohonan->trtanggal_survey->id;

        $permohonan->trperizinan->get();
		$permohonan->trperizinan->trsektor->get();
        $permohonan->tmperusahaan->get();
		$permohonan->tmperusahaan->trkelurahan->get();
		$permohonan->tmperusahaan->trkelurahan->trkecamatan->get();
		$permohonan->tmperusahaan->trkelurahan->trkecamatan->trkabupaten->get();
		$ttdpegawai_id = $permohonan->trtanggal_survey->ttdpegawai_id;
        $pegawai = new tmpegawai();
        $pegawai->where('id', $ttdpegawai_id)->get();
        $odf->setVars('nama_pejabat', $pegawai->n_pegawai);
        $odf->setVars('nip_pejabat', $pegawai->nip);
		$odf->setVars('n_jabatan', strtoupper($pegawai->n_jabatan));
		$odf->setVars('pangkat_pejabat', $pegawai->pangkat_gol);
        if($pegawai->status == 1){
            $odf->setVars('badan', 'KEPALA '.strtoupper($nama_bdan->value));
			$odf->setVars('n_jabatan', '');
		}

        //$odf->setVars('title', strtoupper('S U R A T   P E R I N T A H'));
		//$odf->setVars('nomor', $permohonan->trtanggal_survey->no_surat);
        $this->tr_instansi = new Tr_instansi();
        $alamat = $this->tr_instansi->get_by_id(12);
        $app_city = $this->sql();
        if (isset($app_city->n_kabupaten)) {
            $gede_kota = strtoupper($app_city->n_kabupaten);
            $kecil_kota = ucwords(strtolower($app_city->n_kabupaten));
            //$odf->setVars('kota', $app_city->ibukota);
        }

        $wilayah = new trkabupaten();
        $kelurahan = $permohonan->tmpemohon->trkelurahan->get();
        $kelurahan->trkecamatan->get();
        $kelurahan->trkecamatan->trkabupaten->get();
        $alamat = NULL;
        $date = new Lib_date();

		$id_perusahaan = $permohonan->tmperusahaan->id;
        $relasi_kel = new tmperusahaan_trkelurahan();
		$relasi_kel->get_by_id($id_perusahaan);
		$kd_kel = $relasi_kel->trkelurahan_id;
        $nama_kel = new trkelurahan();
		$nama_kel->get_by_id($kd_kel);

		// Kecamatan perusahaan
        $relasi_kec = new trkecamatan_trkelurahan();
		$relasi_kec->get_by_id($kd_kel);
		$kd_kec = $relasi_kec->trkecamatan_id;
        $nama_kec = new trkecamatan();
		$nama_kec->get_by_id($kd_kec);

		// Kab/Kota Perusahaan
        $relasi_kab = new trkabupaten_trkecamatan();
		$relasi_kab->get_by_id($kd_kec);
		$kd_kab = $relasi_kab->trkabupaten_id;
        $nama_kab = new trkabupaten();
		$nama_kab->get_by_id($kd_kab);

        $odf->setVars('asal', 'KOTA TASIKMALAYA');
		$tgl_sur = $permohonan->d_survey;
        $tgl_sur_sd = $permohonan->survey_sd;
		$tgl_survey = $date->mysql_to_human($tgl_sur);
        $tgl_survey_sd = $date->mysql_to_human($tgl_sur_sd);
        if ($tgl_survey == $tgl_survey_sd) {
            $odf->setVars('tgl_perjalanan',$date->mysql_to_human($permohonan->d_survey));
        } else {
			$bln_survey =  $date->ambil_bulan($tgl_sur);
            $bln_survey_sd = $date->ambil_bulan($tgl_sur_sd);
			if ($bln_survey == $bln_survey_sd) {
                $odf->setVars('tgl_perjalanan',$date->ambil_tanggal($tgl_sur).' s/d '.$date->ambil_tanggal($tgl_sur_sd).' '.$bln_survey.
					                           ' '.$date->ambil_tahun($tgl_sur));
			}else{
                $odf->setVars('tgl_perjalanan',$date->mysql_to_human($permohonan->d_survey) . " s/d " . $date->mysql_to_human($permohonan->survey_sd));
			}
        }
		$odf->setVars('bidang', $permohonan->trperizinan->trsektor->n_sektor);
		$odf->setVars('izin', $permohonan->trperizinan->n_perizinan_cetak);
        
		if($multi){
            for ($is = 0; $is < $syarat_len; $is++) {
                $m_permohonan = new tmpermohonan();
                $m_permohonan = $m_permohonan->get_by_id($syarat[$is]);
				$kd_kel_obj = $m_permohonan->trkelurahan_id; 
//                $m_permohonan->tmpemohon->get();
//                $m_permohonan->tmpemohon->trkelurahan->get();
//                $m_permohonan->tmpemohon->trkelurahan->trkecamatan->get();
//                $m_permohonan->tmpemohon->trkelurahan->trkecamatan->trkabupaten->get();

                if($m_permohonan->tmperusahaan->n_perusahaan == ''){
                    $txt_perusahaan .= ' '.$m_permohonan->tmpemohon->n_pemohon.',';
                    //$txt_tujuan     = $m_permohonan->tmpemohon->trkelurahan->trkecamatan->trkabupaten->n_kabupaten;
                }else{
                    $txt_perusahaan .= ' '.$m_permohonan->tmperusahaan->n_perusahaan.',';
                    //$txt_tujuan     = $m_permohonan->tmperusahaan->trkelurahan->trkecamatan->trkabupaten->n_kabupaten;
                }
				$txt_tujuan = '-';
			    if($kd_kel_obj){
					$m_kelurahan = new trkelurahan();
                    $m_kelurahan = $m_kelurahan->get_by_id($kd_kel_obj);
                    $m_kelurahan->trkecamatan->get();
                    $m_kelurahan->trkecamatan->trkabupaten->get();
				    $txt_tujuan = $m_kelurahan->trkecamatan->trkabupaten->n_kabupaten;
                }
			}
            $txt_perusahaan = rtrim($txt_perusahaan,',');
		}else{
		    if($permohonan->tmperusahaan->n_perusahaan == ''){
                $txt_perusahaan = $permohonan->tmpemohon->n_pemohon;
			    //$txt_tujuan     = $permohonan->tmpemohon->trkelurahan->trkecamatan->trkabupaten->n_kabupaten;
		    }else{
			    $txt_perusahaan = $permohonan->tmperusahaan->n_perusahaan;
			    //$txt_tujuan     = $permohonan->tmperusahaan->trkelurahan->trkecamatan->trkabupaten->n_kabupaten;
		    }
			$txt_tujuan = '-';
			if($kd_kel_objek){
				$m_kelurahan = new trkelurahan();
                $m_kelurahan = $m_kelurahan->get_by_id($kd_kel_objek);
                $m_kelurahan->trkecamatan->get();
                $m_kelurahan->trkecamatan->trkabupaten->get();
                $txt_tujuan = $m_kelurahan->trkecamatan->trkabupaten->n_kabupaten;
			}
	    }
		$odf->setVars('perusahaan', $txt_perusahaan.';');
	    $odf->setVars('tujuan', $txt_tujuan);

		$tgl_ctk = $this->lib_date->get_datetime_now();
        //$odf->setVars('tanggal', $date->ambil_bulan($tgl_ctk).' '.$date->ambil_tahun($tgl_ctk));
		$odf->setVars('tanggal', '');
        //$odf->setVars('Alamat_Perusahaan', $permohonan->tmperusahaan->a_perusahaan);
        
		$pegawai_lists = new tmpegawai_trtanggal_survey();
        $pegawai_survey = $pegawai_lists->where('trtanggal_survey_id', $tanggal_tinjauan)
                                        ->where('type', 2)->get();

        $article3 = NULL;
        if ($pegawai_survey->id) {
			$ar_data=array();

			//foreach ($pegawai_survey as $list_pegawai) {
            //    $pegawai_tinjauan_lapangan = new tmpegawai();
            //    $pegawai_tinjauan_lapangan->where('id', $list_pegawai->tmpegawai_id)->get();
			//	$temp = array($pegawai_tinjauan_lapangan->id => $pegawai_tinjauan_lapangan->golongan);
			//	$ar_data = array_merge ($ar_data, $temp);
			//}

			$i=0;
            foreach ($pegawai_survey as $list_pegawai) {
				$i++;
                $pegawai_tinjauan_lapangan = new tmpegawai();
                $pegawai_tinjauan_lapangan->where('id', $list_pegawai->tmpegawai_id)->get();

                $pegawai_tinjauan_lapangan->trunitkerja->get();
                $list_tim_pegawai[] = array(
                    'kepada' => 'Kepada ',
					'kepada1' => '',
					'nomor' => $i,
				    'nama' => strtoupper($pegawai_tinjauan_lapangan->n_pegawai),
                    'nip' => $pegawai_tinjauan_lapangan->nip,
					'pangkat' => $pegawai_tinjauan_lapangan->pangkat_gol.' / '.$pegawai_tinjauan_lapangan->golongan,
					'jabatan' => strtoupper($pegawai_tinjauan_lapangan->n_jabatan)
                );
            }
        } else {
            $list_tim_pegawai[] = array(
				'kepada' => '',
				'kepada1' => '',
				'nomor' => '',
			    'nama' => '',
                'nip' => '',
				'pangkat' => '',
				'jabatan' => ''
            );
        }

        /* Seting Data Dasar Hukum SP */
		$dasar1 = 'Keputusan Gubernur Tasikmalaya Nomor 503.5/Kep.49-DPMPTSP/2017 Tanggal 13 Januari 2017 Tentang Tim Teknis Penyelenggaraan Pelayanan Perizinan Terpadu;';
		$dasar2 = 'Keputusan Gubernur Tasikmalaya Nomor 1.18.01.62.20.5.2 Tanggal 12 Januari 2017 Tentang Pengesahan Dokumen Penggunaan Anggaran APBD Kabupaten Tasikmalaya Tahun Anggaran 2017 pada Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu Kabupaten Tasikmalaya;';
		$dasar3 = 'Keputusan Kepala Badan Penanaman Modal dan Perijinan Terpadu Kabupaten Tasikmalaya tentang Pendelegasian Penandatanganan Surat Perintah di lingkungan BPMPT Kabupaten Tasikmalaya Nomor 875.1/01/Sekrt Tanggal 04 Januari 2016. Kepala Badan Penanaman Modal dan Perijinan Terpadu Kabupaten Tasikmalaya.';
        $article2 = $odf->setSegment('articles2');
        $i=1;
		//foreach ($list_tim_pegawai as $element2) {
		//	if ($i == 1){
		//	   $article2->kepada($element2['kepada']);
		//	   $article2->ttk2(':');
		//	   $i++;
		//	}else{
		//	   $article2->kepada($element2['kepada1']);
		//	   $article2->ttk2('');
		//	}
		//	$article2->no($element2['nomor']);
		//	$article2->jabatan($element2['jabatan']);
        //    $article2->merge();
        //}
		for($j=1;$j<=2;$j++){
			switch ($j) {
                case 1: $dsr = $dasar1; break;
				case 2: $dsr = $dasar2; break;
				case 3: $dsr = $dasar3; break;
				case 4: $dsr = $dasar4; break;
				case 5: $dsr = $dasar5; break;
				case 6: $dsr = $dasar6; break;
				case 7: $dsr = $dasar7; break;
            }
			if ($j == 1){
			    $article2->kepada('Dasar');
			    $article2->ttk2(':');
			}else{
			    $article2->kepada('');
			    $article2->ttk2('');
			}
			$article2->no($j);
			$article2->jabatan($dsr);
            $article2->merge();
        }
        $odf->mergeSegment($article2);
        /* EOF() Seting Data Dasar Hukum SP */

        /* Seting Data Petugas SP */
        $article3 = $odf->setSegment('articles3');
        $i=1;
		foreach ($list_tim_pegawai as $element3) {
			if ($i == 1){
			   $article3->kepada($element3['kepada']);
			   $article3->ttk2(':');
			   $i++;
			}else{
			   $article3->kepada($element3['kepada1']);
			   $article3->ttk2('');
			}
			$article3->no($element3['nomor']);
		    $article3->nama($element3['nama']);
            $article3->nip($element3['nip']);
			$article3->pangkat($element3['pangkat']);
			$article3->jabatan($element3['jabatan']);
            $article3->merge();
        }
        $odf->mergeSegment($article3);
        /* EOF() Seting Data Petugas SP */

		/* Input Data Tracking Progress */
		$u_ser = $this->session->userdata('username');
    	$r_name = $this->lib_date->get_nama_ori($u_ser);
        $tracking_izin2 = new tmtrackingperizinan();
        $tracking_izin2->where('pendaftaran_id', $no_pendaftaran)
                       ->where('tr_activiti', 'Pertimbangan Teknis')->get();
		if($tracking_izin2->pendaftaran_id){
            $tracking_izin2->status = 'Update';
            $tracking_izin2->d_entry = $this->lib_date->get_date_now();
            $tracking_izin2->tr_user = $u_ser;
            $tracking_izin2->tr_name = $r_name;
    	    $hit_cetak = $tracking_izin2->hit_cetak + 1;
            $his_cetak = $tracking_izin2->his_cetak;
   	     	$tracking_izin2->hit_cetak = $hit_cetak;
	        $tracking_izin2->his_cetak = $his_cetak.'Cetak SP Peninjauan^'.$r_name.'^'.$this->lib_date->get_date_now().';';
            $tracking_izin2->save();
        }
        /* EOF() Input Data Tracking Progress */

		$tgl = date("Y-m-d H:i:s");
        $u_ser = $this->session->userdata('username');
        $g = $this->sql2($u_ser);
//      $jam = date("H:i:s A");
        //$p = $this->db->query("call log ('Penjadwalan Tinjauan','Cetak tl " . $permohonan->pendaftaran_id . "','" . $tgl . "','" . $u_ser . "')");

		//export the file
        $no_daftar = str_replace('/', '', $permohonan->pendaftaran_id);
        $odf->exportAsAttachedFile($nama_surat . '_' . $no_daftar . '.odt');
    }

    // PBS Creat
    public function cetakPenangguhan($id = NULL) {
		$date = new Lib_date();
        $nama_surat = NULL;
        $this->settings = new settings();
        $this->settings->where('name', 'app_folder')->get();
        $app_folder = $this->settings->value . "/";
        $app_city = $this->sql();
        $app_kan = $this->settings->where('name', 'app_kantor')->get();

        $nama_surat = "cetak_penangguhan";
        $this->load->plugin('odf');
        $odf = new odf('assets/odt/' . $nama_surat . '.odt');

        //logo
        $this->tr_instansi = new Tr_instansi();
        $logo = $this->tr_instansi->get_by_id(23);
        if ($logo->value !== "") {
            $odf->setImage('logo', 'uploads/logo/' . $logo->value, '2.1', '2.5');
        } else {
            $odf->setVars('logo', ' ');
        }

        //pemerintah 
        $this->tr_instansi = new Tr_instansi();
        $nama_prov = $this->tr_instansi->get_by_id(17);
        $odf->setVars('provinsi', strtoupper($nama_prov->value));

		//provinsi 
        $this->tr_instansi = new Tr_instansi();
        $nama_prov1 = $this->tr_instansi->get_by_id(18);
        $odf->setVars('provinsi1', strtoupper($nama_prov1->value));

        //badan
        $this->tr_instansi = new Tr_instansi();
        $nama_bdan = $this->tr_instansi->get_by_id(9);
        $odf->setVars('badan', strtoupper($nama_bdan->value));

        //telpon
        $this->tr_instansi = new Tr_instansi();
        $tlp = $this->tr_instansi->get_by_id(10);
        $odf->setVars('tlp', $tlp->value);

        //fax
        $this->tr_instansi = new Tr_instansi();
        $tlp = $this->tr_instansi->get_by_id(13);
        $odf->setVars('fax', $tlp->value);

        //alamat
        $this->tr_instansi = new Tr_instansi();
        $n_alamat = $this->tr_instansi->get_by_id(12);
        $odf->setVars('alamat', $n_alamat->value);

        //web
        $this->tr_instansi = new Tr_instansi();
        $web = $this->tr_instansi->get_by_id(21);
        $odf->setVars('website', $web->value);

        //e-mail
        $this->tr_instansi = new Tr_instansi();
        $e_mail = $this->tr_instansi->get_by_id(22);
        $odf->setVars('email', $e_mail->value);

        //Kop Kota
        $this->tr_instansi = new Tr_instansi();
        $kop_kota = $this->tr_instansi->get_by_id(19);
        $odf->setVars('k_kota_besar', strtoupper($kop_kota->value));

        //Kode Pos
        $this->tr_instansi = new Tr_instansi();
        $kode_pos = $this->tr_instansi->get_by_id(20);
        $odf->setVars('kd_pos', $kode_pos->value);

        // tanggal Pencetakan
        $odf->setVars('tanggal_cetak', $date->mysql_to_human(Date('Y-m-d')));

        $permohonan = new tmpermohonan();
        $permohonan->where('id', $id)->get();
        $no_pendaftaran = $permohonan->pendaftaran_id;
        $permohonan->tmpemohon->get();
        $permohonan->trtanggal_survey->get();
        $odf->setVars('tanggal', $date->mysql_to_human($permohonan->tgl_syarat)); 
        $tanggal_tinjauan = $permohonan->trtanggal_survey->id;
        $permohonan->trperizinan->get();
        $permohonan->tmperusahaan->get();
        $pegawai = new tmpegawai();
        $pegawai->where('status', 1)->get();
        //$odf->setVars('nama_izin', $permohonan->trperizinan->n_perizinan);
        //$odf->setVars('nomor_bap', $permohonan->trtanggal_survey->no_surat);
        //$odf->setVars('no_pendaftaran', $permohonan->pendaftaran_id);
        $odf->setVars('nama_pemohon', $permohonan->tmpemohon->n_pemohon);
        $odf->setVars('alamat_pemohon', $permohonan->tmpemohon->a_pemohon);
        //$odf->setVars('no_telp', $permohonan->tmpemohon->telp_pemohon);
        //$odf->setVars('lokasi_usaha', $permohonan->a_izin);
        //$odf->setVars('tanggal_bap', "\t\t\t" . $date->mysql_to_human($permohonan->d_survey));
        //$odf->setVars('hari', $date->get_day($permohonan->d_survey));
        //$odf->setVars('tanggal', $this->lib_date->mysql_to_human($this->lib_date->get_datetime_now()));
        $pegawai = new tmpegawai();
        $pegawai->where('status', 1)->get();
        //$odf->setVars('jabatan', $pegawai->n_jabatan);
        $odf->setVars('nama_pejabat', $pegawai->n_pegawai);
        $odf->setVars('pangkat', $pegawai->pangkat_gol);
        $odf->setVars('nip_pejabat', $pegawai->nip);
        //$odf->setVars('kantor', $app_kan->value);

        $this->tr_instansi = new Tr_instansi();
        $alamat = $this->tr_instansi->get_by_id(12);
        if (isset($app_city->n_kabupaten)) {
            $gede_kota = strtoupper($app_city->n_kabupaten);
            $kecil_kota = ucwords(strtolower($app_city->n_kabupaten));
            //$odf->setVars('kota4', $gede_kota);
            $odf->setVars('kota', $app_city->ibukota);
        }
        $wilayah = new trkabupaten();
        $kelurahan = $permohonan->tmpemohon->trkelurahan->get();
        $kelurahan->trkecamatan->get();
        $kelurahan->trkecamatan->trkabupaten->get();
        $alamat = NULL;
        //$odf->setVars('alamat_pemohon', $permohonan->tmpemohon->a_pemohon);
        $pegawai_lists = new tmpegawai_trtanggal_survey();
        $pegawai_survey = $pegawai_lists
                        ->where('trtanggal_survey_id', $tanggal_tinjauan)
                        ->where('type', 2)->get();

		for($i=1;$i<=5;$i++){
            if($i == "1")      $syarat = $permohonan->k_syarat1;
            else if($i == "2") $syarat = $permohonan->k_syarat2;
            else if($i == "3") $syarat = $permohonan->k_syarat3;
            else if($i == "4") $syarat = $permohonan->k_syarat4;
            else if($i == "5") $syarat = $permohonan->k_syarat5;

  		    if($syarat <> ""){
  			    $listeArticles = array(
                    array(  'property' => $i.'. ',
                            'content'  => $syarat,
				    )
                );
			} else {
                $listeArticles = array(
                    array(  'property' => $i.'. ',
                            'content'  => '',
				    )
                );
			}
            $article = $odf->setSegment('articles');
            foreach($listeArticles AS $element) {
                   $article->NoArticle($element['property']);
                   $article->txtArticle($element['content']);
                   $article->merge();
            }
	    }
        $odf->mergeSegment($article);

        foreach ($pegawai_survey as $list_pegawai) {
            $pegawai_tinjauan_lapangan = new tmpegawai();
            $pegawai_tinjauan_lapangan->where('id', $list_pegawai->tmpegawai_id)->get();

            $pegawai_tinjauan_lapangan->trunitkerja->get();
            $list_tim_pegawai[] = array(
                'nama' => $pegawai_tinjauan_lapangan->n_pegawai,
                'nip' => $pegawai_tinjauan_lapangan->nip,
                'dinas' => $pegawai_tinjauan_lapangan->trunitkerja->n_unitkerja
            );
        }

        $i = 0;
        //$articles3 = $odf->setSegment('petugas');
	    $pointer = 2;
        $perizinan = new trperizinan();
        $perizinan->get_by_id($pointer);

        $lists = $perizinan->trproperty->include_join_fields()->where('c_type', 2)->order_by('c_parent_order', "asc")->get();

        /* Input Data Tracking Progress */
		$u_ser = $this->session->userdata('username');
    	$r_name = $this->lib_date->get_nama_ori($u_ser);
        $tracking_izin2 = new tmtrackingperizinan();
        $tracking_izin2->where('pendaftaran_id', $no_pendaftaran)
                       ->where('tr_activiti', 'Pertimbangan Teknis')->get();
		if($tracking_izin2->pendaftaran_id){
            $tracking_izin2->status = 'Update';
            $tracking_izin2->d_entry = $this->lib_date->get_date_now();
            $tracking_izin2->tr_user = $u_ser;
            $tracking_izin2->tr_name = $r_name;
    	    $hit_cetak = $tracking_izin2->hit_cetak + 1;
            $his_cetak = $tracking_izin2->his_cetak;
   	     	$tracking_izin2->hit_cetak = $hit_cetak;
	        $tracking_izin2->his_cetak = $his_cetak.'Cetak Penangguhan^'.$r_name.'^'.$this->lib_date->get_date_now().';';
            $tracking_izin2->save();
        }
        /* EOF() Input Data Tracking Progress */

        $tgl = date("Y-m-d H:i:s");
        $u_ser = $this->session->userdata('username');
        $g = $this->sql2($u_ser);
       //$jam = date("H:i:s A");
        //$p = $this->db->query("call log ('Penjadwalan Tinjauan','Cetak Berita Acara Pemeriksaan " . $permohonan->pendaftaran_id . "','" . $tgl . "','" . $u_ser . "')");


        //export the file
        $no_daftar = str_replace('/', '', $permohonan->pendaftaran_id);
        $odf->exportAsAttachedFile($nama_surat . '_' . $no_daftar . '.odt');
    }

	public function view_visit($id_permohonan=NULL, $menu=NULL) {
    $query = "SELECT A.id_data, A.nama_file FROM dpmptsp_detail_data as A
              WHERE A.id_data = ".$id_permohonan."
              order by A.id_data DESC";
    $data['list'] = $query;
    $data['menu'] = $menu;
    $this->load->vars($data);
    $js = $this->index_js();
    $this->template->set_metadata_javascript($js);
    $this->session_info['page_name'] = "HASIL VISITASI";
    $this->template->build('view_visitor', $this->session_info);
	}

	public function main_sql($u_ser,$tgla,$tglb,$lokasi_user,$no_daftar=NULL,$list_state=1) {
		if($no_daftar == ''){
      		$query_filter = " AND A.d_terima_berkas between '$tgla' and '$tglb' ";
	  } else {
			if($list_state=='1')
        		$query_filter = " AND A.pendaftaran_id LIKE '%".$no_daftar."%' ";
			else
				$query_filter = " AND A.no_per_pertek = '".$no_daftar."' ";
	  }
    if($this->All){
      $query = "SELECT A.id, A.pendaftaran_id, A.d_terima_berkas, A.d_survey, A.survey_sd, A.keterangan, A.d_selesai_proses, A.status_berkas, A.c_tinjauan,
                A.d_perubahan, A.d_perpanjangan, A.d_daftarulang, A.a_izin, A.kd_status, A.kd_gerai, A.trkelurahan_id, A.no_per_pertek,
                C.id idizin, C.n_perizinan, E.n_pemohon, E.a_pemohon, E.telp_pemohon,
                G.id idjenis, G.n_permohonan, K.revisi
                FROM tmpermohonan as A
                INNER JOIN tmpermohonan_trperizinan as B ON B.tmpermohonan_id = A.id
                INNER JOIN trperizinan as C ON B.trperizinan_id = C.id
                INNER JOIN tmpemohon_tmpermohonan as D ON D.tmpermohonan_id = A.id
                INNER JOIN tmpemohon as E ON D.tmpemohon_id = E.id
                INNER JOIN tmpermohonan_trjenis_permohonan as F ON F.tmpermohonan_id = A.id
                INNER JOIN trjenis_permohonan as G ON F.trjenis_permohonan_id = G.id
                LEFT JOIN tmpemohon_portal AS K ON A.id_pemohon_portal = K.id
                WHERE A.c_pendaftaran = 1
                AND A.c_izin_dicabut = 0
                AND A.c_izin_selesai = 0 ".$query_filter."order by A.id DESC";
    }else{
      //if ($lokasi_user === 'Pusat' || $lokasi_user === 'OPD Teknis') {    // Untuk Daerah Lain
    	if($lokasi_user === 'DPMPTSP Prov. tasikmalaya' || $lokasi_user === 'BPMPT Prov. tasikmalaya' || $lokasi_user === 'BPPT Prov. tasikmalaya' || $lokasi_user === 'OPD Teknis') {
        $query = "SELECT A.id, A.pendaftaran_id, A.d_terima_berkas, A.d_survey, A.survey_sd, A.keterangan, A.d_selesai_proses, A.status_berkas, A.c_tinjauan,
                  A.d_perubahan, A.d_perpanjangan, A.d_daftarulang, A.a_izin, A.kd_status, A.kd_gerai, A.trkelurahan_id, A.no_per_pertek,
                  C.id idizin, C.n_perizinan, E.n_pemohon, E.a_pemohon, E.telp_pemohon,
                  G.id idjenis, G.n_permohonan, K.revisi
                  FROM tmpermohonan as A
                  INNER JOIN tmpermohonan_trperizinan as B ON B.tmpermohonan_id = A.id
                  INNER JOIN trperizinan as C ON B.trperizinan_id = C.id
                  INNER JOIN tmpemohon_tmpermohonan as D ON D.tmpermohonan_id = A.id
                  INNER JOIN tmpemohon as E ON D.tmpemohon_id = E.id
                  INNER JOIN tmpermohonan_trjenis_permohonan as F ON F.tmpermohonan_id = A.id
                  INNER JOIN trjenis_permohonan as G ON F.trjenis_permohonan_id = G.id
                  INNER JOIN trperizinan_user AS J ON J.trperizinan_id = C.id
                  LEFT JOIN tmpemohon_portal AS K ON A.id_pemohon_portal = K.id
                  WHERE A.c_pendaftaran = 1
                  AND A.c_izin_dicabut = 0
                  AND A.c_izin_selesai = 0
                  AND J.user_id = '" . $u_ser . "'".$query_filter."order by A.id DESC";
	    }else{
        $query = "SELECT A.id, A.pendaftaran_id, A.d_terima_berkas, A.d_survey, A.survey_sd, A.keterangan, A.d_selesai_proses, A.status_berkas, A.c_tinjauan,
                  A.d_perubahan, A.d_perpanjangan, A.d_daftarulang, A.a_izin, A.kd_status, A.kd_gerai, A.trkelurahan_id, A.no_per_pertek,
                  C.id idizin, C.n_perizinan, E.n_pemohon, E.a_pemohon, E.telp_pemohon,
                  G.id idjenis, G.n_permohonan, K.revisi
                  FROM tmpermohonan as A
                  INNER JOIN tmpermohonan_trperizinan as B ON B.tmpermohonan_id = A.id
                  INNER JOIN trperizinan as C ON B.trperizinan_id = C.id
                  INNER JOIN tmpemohon_tmpermohonan as D ON D.tmpermohonan_id = A.id
                  INNER JOIN tmpemohon as E ON D.tmpemohon_id = E.id
                  INNER JOIN tmpermohonan_trjenis_permohonan as F ON F.tmpermohonan_id = A.id
                  INNER JOIN trjenis_permohonan as G ON F.trjenis_permohonan_id = G.id
                  INNER JOIN trperizinan_user AS J ON J.trperizinan_id = C.id
                  LEFT JOIN tmpemohon_portal AS K ON A.id_pemohon_portal = K.id
                  WHERE A.c_pendaftaran = 1
                  AND A.c_izin_dicabut = 0
                  AND A.c_izin_selesai = 0
                  AND J.user_id = '" . $u_ser . "'
                  AND A.kd_gerai =  '$lokasi_user'".$query_filter."order by A.id DESC";
      }
    }
    return $query;
  }
  // EOF PBS

  public function sql() {
    $query = "select a.n_kabupaten, a.ibukota from trkabupaten a where
              a.id = (select value from settings where name='app_city')";
    $sql = $this->db->query($query);
    return $sql->row();
  }

  public function sql2($u_ser) {
    $query = "select a.description
              from user_auth as a
              inner join user_user_auth as  x on a.id = x.user_auth_id
              inner join user as b on b.id = x.user_id
              where b.id = (select id from user where username='" . $u_ser . "')";
    $hasil = $this->db->query($query);
    return $hasil->row();
  }

  public function ambilPegawai($tanggal) {
    $query = "select a.id from tmpegawai as a
              inner join tmpegawai_trtanggal_survey as b on b.tmpegawai_id = a.id
              where b.trtanggal_survey_id = '" . $tanggal . "' and b.type = '2'";
    $sql = $this->db->query($query);
    return $sql->result();
  }

  public function uploadSaran1() {
    $b = explode(".", $_FILES['saran']['name']);
    $az = $b[count($b)-1];
    //$newName = md5(uniqid(rand(), true)).".".$az;
    $name = $_FILES['saran']['name'];
    $newName = $_POST['zzzz']."-".$_FILES['saran']['name'];
    
    if(move_uploaded_file($_FILES["saran"]["tmp_name"], 'assets/file_saran/'.$newName)) {
      $f = $this->db->query("SELECT * from tmpermohonan where id = $_POST[zzzz]")->row_array();
	    if(file_exists(base_url()."assets/file_saran/".$f['file_saran'])){	
	      unlink(base_url()."assets/file_saran/".$f['file_saran']);
	    }
	    $this->db->query("UPDATE tmpermohonan set saran_teknis = '$name',file_saran = 'assets/file_saran/$newName' where id = $_POST[zzzz]") ;
	  }else{
    }
	  redirect(site_url('survey/resultUpdate/'.$_POST['zzzz']));    
  }

  public function asistensi(){
    $pesan = htmlspecialchars($_POST['pesan'],ENT_QUOTES);
    $oleh = '*'.htmlspecialchars($_POST['oleh'],ENT_QUOTES);
    $id_kembali = htmlspecialchars($_POST['id_kembali'],ENT_QUOTES);
    $id_portal = htmlspecialchars($_POST['id_portal'],ENT_QUOTES);
    
    $otherdb  = $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
    
    $data = array('id_permohonan'   => $id_portal,
                      'pesan'   => $pesan,
                      'oleh'  => $oleh
    );

    if($otherdb->insert('asistensi', $data)) {
      redirect('/survey/resultUpdate/'.$id_kembali);  
    } else {
      echo "Error";
    }
  
    
  }

  public function revisi($id_permohonan,$id_kembali){
    $otherdb  = $this->load->database('otherdb', TRUE);
    $permohonan_portal = $otherdb->get_where("tmpermohonan_portal",array("id"=>$id_permohonan))->first_row();
    $user = $otherdb->get_where("tm_pemohon",array("id"=>$permohonan_portal->id_pemohon))->first_row();
    $perizinan = $this->db->get_where("trperizinan",array("id"=>$permohonan_portal->id_perizinan))->first_row();

    $sendE = FALSE;
    $sendS = FALSE;

    $idboportal = $id_kembali;
    $datarevisi = array("revisi" => "0");
    $this->db->where('id', $idboportal);

    $data = array("editable" => "1");
    $otherdb->where('id', $id_permohonan);
    if ($this->db->update('tmpemohon_portal', $datarevisi) && $otherdb->update('tmpermohonan_portal', $data)) {
      ///// KIRIM E-MAIL
      $email = $user->emailPerusahaan;

      $targetpengiriman = urlencode($email);
      $tokens = "LbToSBFWG9";
      $uuids = urlencode(base64_encode($perizinan->n_perizinan.'^'.$user->namaPerusahaan));

      $url = 'http://103.122.5.250/nrsmailer/web/mailer-api/pabar?mails='.$targetpengiriman.'&request=6&token='.$tokens.'&uuid='.$uuids;

      $data = @file_get_contents($url);
        if ($data) {
          $json = json_decode($data);
          if (isset($json->status)) {
            if ($json->status == 1) {
              $sendE = TRUE;
            } else {
              $sendE = FALSE;
            }
          }
        }
        
      ///// EOF() KIRIM E-MAIL

        //Kirim SMS
        $this->settings->where('name', 'smsGateway')->get();
            if($this->settings->status == 1 && !empty($user->telpPemohon)){
                // $gammu  = $this->load->database('gammu', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
                // $data = array('DestinationNumber' => $user->telpPemohon,
                //               'TextDecoded' => "Pengajuan ".$perizinan->n_perizinan." atas nama ".$user->namaPerusahaan." membutuhkan revisi persyaratan, silahkan buka akun anda.\n Dinas PMPTSP Papua Barat."
                //          );
                // if($gammu->insert('outbox',$data)) {
                //   $sendS = TRUE;
                // }
          }
        //EOF Kirim SMS

          if ($sendE == TRUE || $sendS == TRUE) {
            $this->session->set_flashdata('sukses', "Berhasil mengirim E-Mail/SMS Notifikasi ke Pemohon.");
          redirect('/survey/resultUpdate/'.$id_kembali);
          } else {
            $this->session->set_flashdata('gagal', "Gagal mengirim E-Mail/SMS Notifikasi ke Pemohon.");
            redirect('/survey/resultUpdate/'.$id_kembali);
          }
    } else {
      $this->session->set_flashdata('gagal', "Gagal mengirim notifikasi silahkan ulangi proses.");
      redirect('/survey/resultUpdate/'.$id_kembali);
    }
  }






















// Permintaan Barang ---------------------------------------------------------------------------------------------------------------------------------------

  public function barang_index() { 
      $barang = $this->m_barang->get_data();
      $logbarang = $this->m_barang->get_data_master();

      $data['logbarang'] = $logbarang;
      $data['barang'] = $barang;
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
            });

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
              }";

      $this->template->set_metadata_javascript($js);
      $this->session_info['page_name'] = "Sistem Informasi pengelOLAan BArang PERsediaan (SI OLA BAPER)";
      $this->template->build('barang_index', $this->session_info);
    }

  public function barang() { 
      $barang = $this->m_barang->get_data();
      $logbarang = $this->m_barang->get_data_master();

      $data['logbarang'] = $logbarang;
      $data['barang'] = $barang;
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
            });

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
              }";

      $this->template->set_metadata_javascript($js);
      $this->session_info['page_name'] = "Sistem Informasi pengelOLAan BArang PERsediaan (SI OLA BAPER)";
      $this->template->build('barang_list', $this->session_info);
    }

    public function addbarang(){
      $id_user      = $this->session->userdata('id_auth');
      $data['user'] = $this->m_barang->get_pegawai_user($id_user);
      $data['barang'] = array();
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
      $this->session_info['page_name'] = "Tambah Data Barang";
      $this->template->build('barang_add', $this->session_info);
    }

    public function simpan(){
      $id_user      = $this->input->post('id_user');
      $nama_user      = $this->input->post('nama');
      $barang       = $this->input->post('nama_barang');
      $jumlah       = $this->input->post('jumlah');
      $satuan       = $this->input->post('satuan');
      $merk         = $this->input->post('merk');
      $simpan       = $this->input->post('rak');
      $date         = $this->input->post('date');

      // var_dump($id_user);die();

      $simpan = $this->m_barang->save_data($id_user, $barang, $jumlah, $satuan, $date, $merk, $simpan);
      $log = $this->m_barang->save_log($id_user, $barang, $jumlah, $satuan, $date, $merk, $simpan, $nama_user);
      redirect('/survey/barang');
    }

    public function pinjam($id){
      $data['barang'] = $this->m_barang->get_barang_id($id);
      $id_user      = $this->session->userdata('id_auth');
      $data['user'] = $this->m_barang->get_pegawai_user($id_user);
      $data['step'] = "order";

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
      $this->session_info['page_name'] = "Pinjam";
      $this->template->build('barang_pinjam', $this->session_info);
    }

    public function order(){
      $id_user      = $this->session->userdata('id_auth');
      $id           = $this->input->post('id');
      $jumlah       = $this->input->post('jumlah');
      $saatini      = $this->input->post('saatini');
      $hasil        = $saatini - $jumlah;
      // var_dump($hasil);die();
      if($jumlah > $saatini){
      $data['salah'] = "Stok tidak cukup turunkan Jumlah barang";
      $this->load->vars($data);
      redirect('/survey/pinjam/'.$id);
      }else{
      $simpan = $this->m_barang->save_order($id_user, $id, $jumlah ,$hasil);
      redirect('/survey/barang');
      }
    }

    public function checkout() { 
      $barang       = $this->m_barang->get_checkout();
      $permintaan   = $this->m_barang->get_permintaan();
      $id_user      = $this->session->userdata('id_auth');
      $pemberi      = $this->m_barang->get_pegawai_user($id_user);

      $data['user'] = $this->m_barang->get_user();
      $data['pemberi'] = $pemberi;
      $data['id_user']  = $id_user;
      $data['permintaan'] = $permintaan;
      $data['barang']   = $barang;
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
            });


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
              }";

      $this->template->set_metadata_javascript($js);
      $this->session_info['page_name'] = "Checkout";
      $this->template->build('checkout_list', $this->session_info);
    }

    public function accept(){
      $barang       = $this->input->post('nama_barang');
      $id_user      = $this->session->userdata('id_auth');
      $pemberi      = $this->input->post('pemberi');
      $penerima     = $this->input->post('penerima');
      $status       = '1';
      // var_dump($pemberi);die();

      $simpan = $this->m_barang->save_checkout($pemberi, $barang, $penerima, $status);
      redirect('/survey/logbarang');
    }

    public function logbarang() { 
      $barang = $this->m_barang->get_data_master();

      $data['barang'] = $barang;
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
      $this->session_info['page_name'] = "LOG Barang ";
      $this->template->build('barang_master_list', $this->session_info);
    }

    public function hapus_checkout($id, $jumlah, $id_barang){
      $awal        = $this->m_barang->get_barang_id($id);
      $jumlah_awal = $this->m_barang->get_jumlah_awal($id_barang);
      $hasil = $jumlah_awal + $jumlah;
      // var_dump($hasil);die();

      $simpan       = $this->m_barang->hapus_checkout($id, $id_barang, $hasil);
      redirect('/survey/barang');
    }

    public function activity(){
      $barang = $this->m_barang->get_log();

      $data['barang'] = $barang;
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
      $this->session_info['page_name'] = "LOG Activity";
      $this->template->build('barang_log', $this->session_info);
    }


// 20 feb 2023
    public function tambah($id){
      $barang = $this->m_barang->get_barang_id($id);
      $id_user      = $this->session->userdata('id_auth');
      $data['user'] = $this->m_barang->get_pegawai_user($id_user);
      $data['barang'] = $barang;
      $data['step'] = 'stok';
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
      $this->session_info['page_name'] = "Tambah Data Barang";
      $this->template->build('tambah_stok', $this->session_info);
    }
    public function stok(){
      $id             = $this->input->post('id');
      $id_user      = $this->session->userdata('id_auth');
      $jumlah1        = $this->input->post('jumlahawal');
      $jumlah2        = $this->input->post('jumlahmasuk');
      $penginput      = $this->input->post('nama');
      $barang         = $this->input->post('barang');
      $merk           = $this->input->post('merk');


      $text           = 'telah menambah barang dengan jumlah : <b>'.$jumlah2.'</b><br>Penginput Barang : <b>'.$penginput.'<b>';
      // var_dump($penginput);die();
      $hasil = $jumlah1 + $jumlah2;
      $this->m_barang->get_update_barang($id, $hasil, $text, $jumlah2, $barang, $merk, $penginput);

      redirect('/survey/barang');
    }

    public function pengajuan() {

    }
  }
// This is the end of survey class