<?php

/** Description of Entry Data
 * @author agusnur => Created : 23 Aug 2010
 * @edit PBS => 17 Aug 2015
*/

class Pendataan extends WRC_AdminCont {

  public function __construct() {
    parent::__construct();
    $this->permohonan = new tmpermohonan();
    $this->username = new user();
    $this->settings = new settings();
    $this->pegawai = new tmpegawai();
    $this->load->model('dbmodel_akdp');
    //$this->load->library('fpdf');
    
    $enabled = FALSE;
    $this->All = FALSE;
    $this->penghapusan = FALSE;
    $list_auths = $this->session_info['app_list_auth'];
    
    foreach ($list_auths as $list_auth) {
      if($list_auth->id_role === '11') {    // Pendataan
        $enabled = TRUE;
      }
      if($list_auth->id_role === '18') {   // Administrator
        $this->All = TRUE;
      }
      if($list_auth->id_role === '25') {   // Hapus Data
        $this->penghapusan = TRUE;
      }
      if($list_auth->id_role === '20') {    // Mencetak
        $enabled = TRUE;
      }
    }
    if(!$enabled) {
      redirect('dashboard');
    }
  }

  public function index($tgla=NULL, $tglb=NULL) {     // Awal masuk menu entry data
    $kd_filter = $this->input->post('kd_filter');
    $no_daftar = $this->input->post('kt_cari');
    $username = new user();
    $username->where('username', $this->session->userdata('username'))->get();
    $lokasi_user = $this->session->userdata('lokasi');
    $group = $username->group;
        
    $now = $this->lib_date->get_date_now();
    if($kd_filter == ''){
      $tgla = $this->lib_date->set_date($now, -7);
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
    
    $data['kd_filter'] = $kd_filter;
    $data['tgla'] = $tgla;
    $data['tglb'] = $tglb;
    if($kd_filter != ''){
      if($kd_filter == '1'){
        $query_filter = " AND A.pendaftaran_id LIKE '%".$no_daftar."%' ";
      }else{
        $query_filter = " AND A.d_terima_berkas between '$tgla' and '$tglb' ";
      }
    }else{
      $query_filter = " AND A.d_terima_berkas between '$tgla' and '$tglb' ";			
    }
    
    $data['kt_cari'] = $no_daftar;
    $data['list'] = $this->main_sql($username->id,$query_filter,$tglb,$lokasi_user,$group); // = $query;
    $data['group'] = $group;
    $data['penghapusan'] = $this->penghapusan;
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
           ";
    
    $this->template->set_metadata_javascript($js);
    $this->session_info['page_name'] = "Data Entry Perizinan ";
    $this->template->build('entrydata_list', $this->session_info);
  }

  public function index_next($syarat = NULL) {     // Masuk ke entry data selanjutnya
    $kd_filter = $this->input->post('kd_filter');
    $no_daftar = $this->input->post('kt_cari');
    $lokasi_user = $this->session->userdata('lokasi');
    $username = new user();
    $username->where('username', $this->session->userdata('username'))->get();
    $group = $username->group;
    $tgla = $username->gvar1;
    $tglb = $username->gvar2;
    $data['tgla'] = $tgla;
    $data['tglb'] = $tglb;
        
    $data['kd_filter'] = $kd_filter;
    $data['kt_cari'] = $no_daftar;
    //if($syarat == NULL){
      $query_filter = " AND A.d_terima_berkas between '$tgla' and '$tglb' ";
    //}else{
    //  $query_filter = " AND A.d_terima_berkas between '$tgla' and '$tglb' AND A.id = '$syarat'";
    //}
    $data['list'] = $this->main_sql($username->id,$query_filter,$tglb,$lokasi_user,$group); // = $query;
    $data['group'] = $group;
    $data['penghapusan'] = $this->penghapusan;
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
    $this->session_info['page_name'] = "Data Entry Perizinan ";
    $this->template->build('entrydata_list', $this->session_info);
  }

  public function acc_pertek() {     // Awal masuk menu approve Pertek
    $username = new user();
    $username->where('username', $this->session->userdata('username'))->get();
    $lokasi_user = $this->session->userdata('lokasi');
    $group = $username->group;
    
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
    
    $data['list'] = $this->main_sql($username->id,$tgla,$tglb,$lokasi_user,$group); // = $query;
    $data['group'] = $group;
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
    $this->session_info['page_name'] = "Approve Pertimbangan Teknis";
    $this->template->build('acc_pertek_list', $this->session_info);
  }

  public function acc_pertek_next() {     // Masuk ke approve Pertek selanjutnya
    $lokasi_user = $this->session->userdata('lokasi');
    $username = new user();
    $username->where('username', $this->session->userdata('username'))->get();
    $group = $username->group;
    $tgla = $username->gvar1;
    $tglb = $username->gvar2;
    $data['tgla'] = $tgla;
    $data['tglb'] = $tglb;
    
    $data['list'] = $this->main_sql($username->id,$tgla,$tglb,$lokasi_user,$group); // = $query;
    $data['group'] = $group;
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
    $this->session_info['page_name'] = "Approve Pertimbangan Teknis";
    $this->template->build('acc_pertek_list', $this->session_info);
  }

  public function approve_data($single = NULL, $id = NULL) {
    if($single == 'ALL'){
      echo 'ctk masuk ALL : ';
      if($this->input->post('jumlah') >= 1){
        foreach ($this->input->post('data1') as $dt) {
          echo $dt . " | "; 
        }
      }
    }else{
      echo 'ctk masuk '.$single.' : '.$id;
    }
    die;
    redirect('pendataan/acc_pertek_next');
  }

  public function index2() {
    $tgla = $this->input->post('tgla');
    $tglb = $this->input->post('tglb');
    $now = $this->lib_date->get_date_now();
    $tgl_before = $this->lib_date->set_date($now, -7);
    $tgl_now = $this->lib_date->set_date($now, 0);
    
    $data['warning'] = "Izin ini di-set Manual. Tambahkan Property 'Retribusi' dan 'Rumus Perhitungan' kemudian inputkan nilainya";
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
    $group = $username->group;
    
    $query = "SELECT distinct A.id, A.pendaftaran_id, A.id_lama, A.d_terima_berkas,
              A.d_perubahan, A.d_perpanjangan, A.d_daftarulang, A.keterangan,
              C.id idizin, C.n_perizinan, A.kd_gerai, E.n_pemohon,
              G.id idjenis, G.n_permohonan
              FROM tmpermohonan as A
              INNER JOIN tmpermohonan_trperizinan as B ON B.tmpermohonan_id = A.id
              INNER JOIN trperizinan as C ON B.trperizinan_id = C.id
              INNER JOIN tmpemohon_tmpermohonan as D ON D.tmpermohonan_id = A.id
              INNER JOIN tmpemohon as E ON D.tmpemohon_id = E.id
              INNER JOIN tmpermohonan_trjenis_permohonan as F ON F.tmpermohonan_id = A.id
              INNER JOIN trjenis_permohonan as G ON F.trjenis_permohonan_id = G.id
              INNER JOIN trperizinan_user AS H ON  H.trperizinan_id = C.id
              WHERE A.c_pendaftaran = 1
              AND A.c_izin_dicabut = 0
              AND A.c_izin_selesai = 0
              AND A.status_berkas = 'proses'
              AND H.user_id = '".$username->id."'
              AND A.d_terima_berkas between '$tgla' and '$tglb'
              order by A.id DESC";
    $data['list'] = $query;
    $data['group'] = $group;
    
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
              $('#form').validate();
            });
           ";
    
    $this->template->set_metadata_javascript($js);
    $this->session_info['page_name'] = "Data Entry Perizinan";
    $this->template->build('entrydata_list', $this->session_info);
  }

  public function edit($id_daftar = NULL, $look = NULL) {
    $username = new user();
    $username->where('username', $this->session->userdata('username'))->get();
    $tgla = $username->gvar1;
    $tglb = $username->gvar2;
    
    $p_daftar = $this->permohonan->get_by_id($id_daftar);
    $p_pemohon = $p_daftar->tmpemohon->get();
    $p_jenis = $p_daftar->trjenis_permohonan->get();
    $p_izin = $p_daftar->trperizinan->get();
    $p_usaha = $p_daftar->tmperusahaan->get();
    $p_kelompok = $p_daftar->trperizinan->trkelompok_perizinan->get();
    $p_kelurahan = $p_pemohon->trkelurahan->get();
    $p_kecamatan = $p_kelurahan->trkecamatan->get();
    $p_kabupaten = $p_kecamatan->trkabupaten->get();
    $p_prov = $p_kabupaten->trpropinsi->get();
    $p_sektor = $p_izin->trsektor->get();
     
    if($p_daftar->no_per_pertek == '')
      $look = FALSE;
    else
      $look = TRUE;
    
    $jml_property = $this->lib_date->data_property($p_izin->id,'1');
    
    $online=0;
    /*
    if($p_daftar->kd_gerai === 'OnLine'){
      $no_permohonan = $p_daftar->pendaftaran_id;
      $otherdb = $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
      $portal = $otherdb->get_where("tmpermohonan_portal",array("no_permohonan"=>$no_permohonan))->first_row();
      if(count($portal)==1){
        $online =1; 
        $persyaratan_portal = $otherdb->get_where("tmpermohonan_trsyarat_perizinan",array("tmpermohonan_id"=>$portal->id))->result();
        $username_portal = $otherdb->get_where("tm_pemohon",array("id"=>$portal->id_pemohon))->first_row();
        $data["persyaratan"] = $persyaratan_portal;
        $data["id_portal"] = $portal->id;
        $data["username_portal"] = $username_portal->username;
      }
    }
    */
    // if($p_daftar->kd_gerai === 'OnLine'){
    //   $id_portal = $p_daftar->id_pemohon_portal;
    //   $otherdb = $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
    //   //$portal = $otherdb->get_where("tmpermohonan_portal",array("no_permohonan"=>$no_permohonan))->first_row();
    //   $portal = $this->db->query("SELECT * FROM tmpemohon_portal where id = $id_portal")->row_array();
    //   if($portal['id_permohonan_portal']){
    //     $online =1; 
    //     $persyaratan_portal = $otherdb->get_where("tmpermohonan_trsyarat_perizinan",array("tmpermohonan_id"=>$portal['id_permohonan_portal']))->result();
    //     $username_portal = $otherdb->get_where("tm_pemohon",array("id"=>$portal['id_pemohon']))->first_row();
    //     $data["persyaratan"] = $persyaratan_portal;
    //     $data["id_portal"] = $portal['id_permohonan_portal'];
    //     $data["username_portal"] = $username_portal->username;
    //   }
    // }
    // $data["online"] = $online;

    //Start Data Berkas Nirwan
    $p_daftar = $this->permohonan->get_by_id($id_daftar);
    $data['daftaronline'] = $p_daftar->kd_gerai;
    $id_portal = $p_daftar->id_pemohon_portal;
    $data['peronline'] = 0;
    if ($p_daftar->kd_gerai === 'OnLine') {
      $otherdb = $this->load->database('otherdb', TRUE);
      $portal = $this->db->query("SELECT * FROM tmpemohon_portal where id = $id_portal")->row_array();
      
    $backoffice     = $this->load->database('default', TRUE);
    $portal_db         = $this->load->database('otherdb', TRUE);
    $db_portal      = $portal_db->database;
    $db_backoffice  = $backoffice->database;
      if($portal['id_permohonan_portal']){
        $online =1;
        $permohonan_portal_trperizinan = $otherdb->get_where("tmpermohonan_portal",array("id"=>$portal['id_permohonan_portal']))->first_row();

        $sql = "SELECT A.*, B.tmpermohonan_id, B.nomor_surat, B.tanggal_surat, B.masa_berlaku_surat FROM $db_backoffice.trsyarat_perizinan A 
          LEFT JOIN $db_portal.tmpermohonan_trsyarat_perizinan B ON A.id = B.trsyarat_perizinan_id
          WHERE A.id IN(select trsyarat_perizinan_id from trperizinan_trsyarat_perizinan where trperizinan_id=? and status='1')
          GROUP BY A.id
          ORDER BY (A.urutan * -1) DESC, A.status ASC, A.urutan = 0, A.urutan";

        $persyaratan_portal = $this->db->query($sql, $permohonan_portal_trperizinan->id_perizinan)->result();
        $username_portal = $otherdb->get_where("tm_pemohon",array("id"=>$portal['id_pemohon']))->first_row();
        $data["persyaratan"] = $persyaratan_portal;
        $data["id_portal"] = $portal['id_permohonan_portal'];
        $data["username_portal"] = $username_portal->username;
        $data['peronline'] = 1;
       // $data['online'] = 1;
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
    // EOF() CODE UNTUK TRACKING DATA WEB PENGENDALIAN
        
    $method = 'simpan';
    $data['tgla'] = $tgla;
    $data['tglb'] = $tglb;
    $data['waktu_awal'] = $this->lib_date->get_date_now();
    $data['save_method'] = $method;
    $data['id_daftar'] = $id_daftar;
    $data['permohonan'] = $p_daftar;
    $data['no_daftar'] = $p_daftar->pendaftaran_id;
    $data['tgl_permohonan'] = $p_daftar->d_terima_berkas;
    $data['nama_pemohon'] = $p_pemohon->n_pemohon;
    $data['nama_usaha'] = $p_usaha->n_perusahaan;
    $data['alamat_usaha'] = $p_usaha->a_perusahaan;
    $data['alamat_pemohon'] = $p_pemohon->a_pemohon.', '.$p_kelurahan->n_kelurahan.', '.$p_kecamatan->n_kecamatan.', '.
                              $p_kabupaten->n_kabupaten.', '.$p_prov->n_propinsi;
    $data['jenis_izin'] = $p_izin->n_perizinan;
    $data['id_izin'] = $p_izin->id;
    $data['bidang'] = $p_sektor->n_sektor;
    $data['look'] = $look;
    
    $a=array();
    $jml_property = $this->lib_date->data_property($p_izin->id,'1');
    
    if($jml_property == '0') {
    }else{
      $i = 1;
      $text = $this->lib_date->data_property($p_izin->id,'2');
      if($jml_property > 1) {
        $text = $this->lib_date->sort_property($p_izin->id, $text);
      }
      $list = explode (",",$text);
      
      foreach ($list as $data2) {
        $nm_var = 'vdt_teknis'.$this->lib_date->array_property('0',$data2);  // Nomor Variabel
        $property_aktif = $this->lib_date->array_property('11',$data2);      // Aktifasi Property
        $tek = "dt_teknis".$i;
        $prop = $p_daftar->$tek;
        if($p_daftar->$tek == null){
          $prop = "^";
        }else{
          $array = explode("^",$prop);
          $a[] = $array[0];
          $i++;
        }
      }
    }
    
    $data['array_properti'] = $a;
    $data['nama_jenis'] = $p_jenis->n_permohonan;
    $data['nama_kelompok'] = $p_kelompok->n_kelompok;
    $data['list'] = $p_izin->trproperty->order_by('c_parent_order asc, c_order asc')->get();
    $data['list_daftar'] = $p_daftar->tmproperty_jenisperizinan->get();
    $data['list_klasifikasi'] = $p_daftar->tmproperty_klasifikasi->get();
    $data['list_prasarana'] = $p_daftar->tmproperty_prasarana->get();
    
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
            });
    
            function finishAjax(id, response){
                $('#'+id).html(unescape(response));
                $('#'+id).fadeIn();
            }
        ";
    
    $this->template->set_metadata_javascript($js);
    $this->load->vars($data);
    $this->session_info['page_name'] = "Entry Data Teknis";
    $this->template->build('entrydata_edit', $this->session_info);
  }

  public function clear_entry($uid=NULL) {
    $dt_id = explode (" ", $uid);
    foreach ($dt_id as $id) {
      $p_daftar = $this->permohonan->get_by_id($id);
      $p_pemohon = $p_daftar->tmpemohon->get();
      $p_jenis = $p_daftar->trjenis_permohonan->get();
      $p_izin = $p_daftar->trperizinan->get();
      $p_usaha = $p_daftar->tmperusahaan->get();
      $p_kelompok = $p_daftar->trperizinan->trkelompok_perizinan->get();
      echo $izin . ' | ';
    }
    redirect('pendataan/index');
  }

    public function simpan($tgla = NULL, $tglb = NULL) {
	    // CODE UNTUK TRACKING DATA DI WEB PENGENDALIAN
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
	    // END OF CODE
        
		$id_izin = $this->input->post('id_izin');
    $jumlah = $this->lib_date->data_property($id_izin,'1');
		$i = 1;
      while ($i <= $jumlah) {
  			$id_daftar = $this->input->post('id_daftar');
  			$data_property = $this->lib_date->isi_property($id_daftar, $i, '1');
  			
  			$permohonan = new tmpermohonan();
              $permohonan->where('id', $id_daftar);
  			$permohonan->trperizinan->get();
              
  			$hitung = strlen($data_property);
              $cek_posisi = strpos($data_property,'^'); 
              $data_property = substr($data_property,$cek_posisi+1,$hitung-$cek_posisi);
              if($data_property == '') $data_property = '-';
  			
  			
  			$nama_fild = 'dt_teknis'.$i;
  			
  			$kelompok = new trkelompok_perizinan_trperizinan();
        $kelompok->where('trperizinan_id', $permohonan->trperizinan->id)->get();
        if($kelompok->trkelompok_perizinan_id != '1' && $kelompok->trkelompok_perizinan_id != '3' && $kelompok->trkelompok_perizinan_id != '5')
  			$isi_fild = $this->input->post('vdt_teknis'.$i).'^'.$this->input->post('vdt_teknis'.$i);
        else
  			$isi_fild = $this->input->post('vdt_teknis'.$i).'^'.$data_property;
  			$permohonan->update($nama_fild, $isi_fild);
  	    $i++;
  			$nama_fild = '';
  			$isi_fild = '';
      }		
        $this->simpan_lagi($tgla, $tglb);
    }

    public function simpan_lagi($tgla = NULL, $tglb = NULL) {
		//kondisi tracking ini digunakan juga persis di program /pelayanan/control/sementara.php untuk permohonan Online (harus sesuai)
		$u_ser = $this->session->userdata('username');
		$r_name = $this->lib_date->get_nama_ori($u_ser);
        $daftar_id = $this->input->post('id_daftar');

        $permohonan = new tmpermohonan();
        $permohonan->get_by_id($daftar_id);
		if($permohonan->kd_status < 2){ // ubah kd_status menjadi 2 (sudah di entry) untuk proses selanjutnya (Penjadualan Tinjauan)
		    $permohonan->kd_status = 2;
            $permohonan->save();
			$permohonan = new tmpermohonan();
            $permohonan->get_by_id($daftar_id);
        }
        
		$no_pendaftaran = $permohonan->pendaftaran_id;
		$id_portal = $permohonan->id_pemohon_portal;
        $izin = $permohonan->trperizinan->get();
        $kelompok = $izin->trkelompok_perizinan->get();
		$kel_izin = $kelompok->id;
        if($kel_izin == "1") $id_status = "4";     //Rekomendasi [Lihat Tabel trstspermohonan()]   -> kominfo old 5
        if($kel_izin == "2") $id_status = "4";     //Survey Lokasi [Lihat Tabel trstspermohonan()] -> kominfo old 4
        if($kel_izin == "3") $id_status = "4";     //Pembuatan BAP [Lihat Tabel trstspermohonan()] -> kominfo old 6
		if($kel_izin == "4") $id_status = "4";     //PBS create
		if($kel_izin == "5") $id_status = "4";     //PBS create
        $status_izin = $permohonan->trstspermohonan->get();

        $status_skr = "3";                         //Entry Data [Lihat Tabel trstspermohonan()]    -> kominfo old 3
        if($status_izin->id == $status_skr){
            /* Input Data Tracking Progress */
	        $tracking_izin = new tmtrackingperizinan();
            $tracking_izin->where('pendaftaran_id', $no_pendaftaran)
                          ->where('tr_activiti', 'Entry Data')->get();
		    if($tracking_izin->pendaftaran_id){
                $tracking_izin->status = 'Update';
                $tracking_izin->d_entry = $this->lib_date->get_date_now();
                $tracking_izin->tr_user = $u_ser;
                $tracking_izin->tr_name = $r_name;
			    $hit_ubah = $tracking_izin->hit_ubah + 1;
    			$his_ubah = $tracking_izin->his_ubah;
   	    		$tracking_izin->hit_ubah = $hit_ubah;
		    	$tracking_izin->his_ubah = $his_ubah.'PEL.ENTRY^'.$r_name.'^'.$this->lib_date->get_date_now().';';
                $tracking_izin->tr_activiti = 'Entry Data';
                $tracking_izin->save();
		    }

            /* [Lihat Tabel trstspermohonan()] */
			// Menyiapkan Slot untuk Pertimbangan Teknis
            $tracking_izin2 = new tmtrackingperizinan();
            $tracking_izin2->where('pendaftaran_id', $no_pendaftaran)
                           ->where('tr_activiti', 'Pertimbangan Teknis')->get();
            if(!$tracking_izin2->pendaftaran_id){  // jika tidak ditemukan
                $tracking_izin2->pendaftaran_id = $permohonan->pendaftaran_id;
                $tracking_izin2->status = 'Insert';
                $tracking_izin2->d_entry_awal = $this->lib_date->get_date_now();
                $tracking_izin2->d_entry = $this->lib_date->get_date_now();
	    		$tracking_izin2->tr_activiti = 'Pertimbangan Teknis';
                $sts_izin2 = new trstspermohonan();
                $sts_izin2->get_by_id($id_status); //[Lihat Tabel trstspermohonan()]
                $sts_izin2->save($permohonan);
                $tracking_izin2->save($permohonan);
                $tracking_izin2->save($sts_izin2);
            }

			if($id_status == "4"){             // Survai Lokasi [Lihat Tabel trstspermohonan()]
                $data_id = new tmbap();
                $data_id->select_max('id')->get();
                $data_id->get_by_id($data_id->id);
                $data_tahun = date("Y");
                //Per Tahun Auto Restart NoUrut
                if($permohonan->d_tahun == $data_tahun)
                $data_urut = $data_id->i_urut + 1;
                else $data_urut = 1;

                $i_urut = strlen($data_urut);
                for($i=4;$i>$i_urut;$i--){
                    $data_urut = "0".$data_urut;
                }

                $data_izin = $izin->id;
                $i_izin = strlen($data_izin);
                for($i=3;$i>$i_izin;$i--){
                    $data_izin = "0".$data_izin;
                }

                $data_bulan = $this->lib_date->set_month_roman(date("n"));

                $data_bap = "BAP";
                $no_bap = $data_urut."/"
                        .$data_bap."/".$data_izin."/"
                        .$data_bulan."/".$data_tahun;
                $data_skrd = "SKRD";
                $no_skrd = $data_urut."/"
                        .$data_skrd."/".$data_izin."/"
                        .$data_bulan."/".$data_tahun;
                
                $bap2 = new tmbap();
                $bap2->bap_id = $no_bap;
                $bap2->no_skrd = $no_skrd;
				$bap2->tgl_bap = $this->lib_date->get_date_now();
                $bap2->pendaftaran_id = $permohonan->pendaftaran_id;
                $bap2->i_urut = $data_urut;
				
				if($kel_izin == "5") {               // jika kelompok perijinan = Work Flow  (agar ditampilkan di penetapan izin)
					$bap2->c_pesan = 'Work Flow';
				}
				if($kel_izin == "1" || $kel_izin == "3") { // jika kelompok perijinan = Tanpa Tinjauan Lapangan  (agar ditampilkan di penetapan izin)
				    $bap2->c_pesan = 'Tanpa Tinjauan Lapangan';
    			}
				if($kel_izin == "2" || $kel_izin == "4") { // jika kelompok perijinan = Tanpa Tinjauan Lapangan  (agar ditampilkan di penetapan izin)
				    $bap2->c_pesan = 'Dengan Tinjauan Lapangan';
    			}
                $bap2->save($permohonan);
            }
        } else { // jika melakukan proses edit biasa
            $tracking_izin = new tmtrackingperizinan();
            $tracking_izin->where('pendaftaran_id', $no_pendaftaran)
                          ->where('tr_activiti', 'Entry Data')->get();
			if($tracking_izin->pendaftaran_id){
                $hit_ubah = $tracking_izin->hit_ubah + 1;
   				$his_ubah = $tracking_izin->his_ubah;
				$tracking_izin->tr_user = $u_ser;
                $tracking_izin->tr_name = $r_name;
    			$tracking_izin->hit_ubah = $hit_ubah;
				$tracking_izin->his_ubah = $his_ubah.'PEL.ENTRY^'.$r_name.'^'.$this->lib_date->get_date_now().';';
				$tracking_izin->save();
            }
		}
		
        //untuk pendaftaran OnLine
		$cek_portal = FALSE;
		if($id_portal > 0){
			$cek_portal = TRUE;
    		$pemohon_portal = new tmpemohon_portal();
	    	$pemohon_portal->get_by_id($id_portal);
            $telp = $pemohon_portal->telpPemohon;
		    $email = $pemohon_portal->emailPerusahaan;
		}

		$perusahaan_permohonan = $permohonan->tmperusahaan->get();
		$nama_perusahaan = $perusahaan_permohonan->n_perusahaan;
		
		$perizinan_permohonan = $permohonan->trperizinan->get();
		$perizinan = $perizinan_permohonan->n_perizinan;
		$perizinan_kelompok = $permohonan->trperizinan->trkelompok_perizinan->get();
		$kelompok = $perizinan_kelompok->n_kelompok;
		if($kelompok == 2 || $kelompok == 4){
            $isi = "Izin dg no pendaftaran: ".$no_pendaftaran." Dalam Proses Kajian Teknis dan Penjadwalan Tinjauan Lapangan";
		}else{
		    $isi = "Izin dg no pendaftaran: ".$no_pendaftaran." Dalam Proses Kajian Teknis";
		}
		
		$status	= $this->db->get_where('trstspermohonan',array("id"=>4))->first_row();
		
		// Kirim SMS utk pemohon online
        
		// Kirim E-Mail utk pemohon online
		$this->settings->where('name', 'send_mail')->get();
        if($this->settings->status == 1 && $cek_portal){
			$base_url         = 'assets/plugin/';
			$host			  = "smtp.gmail.com";
			$emailpengirim	  = "bpmpttasikmalaya@gmail.com";
			$namapengirim	  = "DPMPTSP tasikmalaya";
			$password		  = "~bpmpttasikmalayakabgoid#";
			$targetpengiriman = $email;
			require("assets/plugins/phpmailer/class.phpmailer.php");
		    require("assets/plugins/phpmailer/class.smtp.php");
			$mailer = new PHPMailer();
			$mailer->CharSet = "UTF-8";
			$mailer->IsSMTP();
			$mailer->SMTPSecure = 'tls';
			$mailer->Host =$host;
			$mailer->Port =587;
			$mailer->SMTPAuth = true;
			$mailer->Username = $emailpengirim;
			$mailer->Password = $password;
			$mailer->FromName = $namapengirim;
			$mailer->From = $emailpengirim;
			$mailer->AddAddress($targetpengiriman,$targetpengiriman);
			$mailer->Subject = 'DPMPTSP Kabupaten Tasikmalaya';
			$isi .= "<p>Terima kasih atas perhatiannya<br>DPMPTSP PROVINSI TASIKMALAYA</p>";
			$mailer->Body = $isi;
			$mailer->AltBody = $isi;
			$mailer->Send();
		}

		if($update) {
            $tgl = date("Y-m-d H:i:s");
            $u_ser = $this->session->userdata('username');
            $g = $this->sql($u_ser);
            //$p = $this->db->query("call log ('Entry Perizinan','Update ".$permohonan->pendaftaran_id."','".$tgl."','".$u_ser."')");
        }
		redirect('pendataan/pendataan/index_next');
    }

    public function save1() {
        $this->perizinan = new trperizinan();
        $perizinan = $this->perizinan->get_by_id($this->input->post('id_izin'));
        $property = $perizinan->trretribusi->get();
        if ($property->m_perhitungan=="1") {
            $list_prop = new trperizinan_trproperty();
            $list_prop->where('trperizinan_id', $this->input->post('id_izin'));
            $hasil = $list_prop->get();
            foreach ($hasil as $dt) {
                $a = $dt->trproperty_id;
                if ($a!=="45") {
                    $this->index2();
                } else if ($a=="45") {
                    $this->save_true();
                }
            }
        } else {
            $this->save_true();
        }
    }

    public function save_true1() {
		$u_ser = $this->session->userdata('username');
        $user = new user();
		$user->where('username', $u_ser)->get();
		$r_name = $user->oriname;
       
        //mengecek nilai property "retribusi" dari tabel trperizinan_trproperty
        $permohonan = new tmpermohonan();
        $daftar_id = $this->input->post('id_daftar');
        $permohonan->get_by_id($daftar_id);
        
        $entry_id      = $this->input->post('entry_id');
        $property_id   = $this->input->post('property_id');
        $entry         = $this->input->post('property_value');
        $koefisien_id  = $this->input->post('koefisien_id');
        $entry2        = $this->input->post('property_value2');
        $koefisien_id2 = $this->input->post('koefisien_id2');
        $entry_len     = count($property_id);

        $is_array = NULL;
        $updated = FALSE;
		$update = FALSE;    // PBS untuk menghindari gagal pada If ($update) dibawah
        $daftar_awal = new tmpermohonan_tmproperty_jenisperizinan();
        $daftar_awal->where('tmpermohonan_id', $daftar_id)->get();
        if($daftar_awal->id) $updated = TRUE;

        for($i=0;$i < $entry_len;$i++) {
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

        for($i=0;$i < $entry_len;$i++) {
            if($is_array !== $property_id[$i]) {             
                $relasi_entry = new trproperty();
                $relasi_entry->get_by_id($property_id[$i]);
                $entry_data = new tmproperty_jenisperizinan();
                $entry_data->pendaftaran_id = $permohonan->pendaftaran_id;
                $entry_data->v_property = $entry[$i];

                $izin = $permohonan->trperizinan->get();
                $kelompok = $izin->trkelompok_perizinan->get();
				$kel_izin = $kelompok->id;
                if($kel_izin == "1") $id_status = "4";     //Rekomendasi [Lihat Tabel trstspermohonan()]   -> kominfo old 5
                if($kel_izin == "2") $id_status = "4";     //Survey Lokasi [Lihat Tabel trstspermohonan()] -> kominfo old 4
                if($kel_izin == "3") $id_status = "4";     //Pembuatan BAP [Lihat Tabel trstspermohonan()] -> kominfo old 6
                if($kel_izin == "4") $id_status = "4";     //PBS create
				if($kel_izin == "5") $id_status = "4";     //PBS create
                $status_izin = $permohonan->trstspermohonan->get();

                if($updated){
                    if($status_izin->id == $id_status){
                        $entry_data->v_tinjauan = $entry[$i];
                        $entry_data->k_tinjauan = $koefisien_id[$i];
                    }else{
                        $entry_data->v_tinjauan = $entry2[$i];
                        $entry_data->k_tinjauan = $koefisien_id2[$i];
                    }
                }else{
                    $entry_data->v_tinjauan = $entry[$i];
                    $entry_data->k_tinjauan = $koefisien_id[$i];
                }
                $entry_data->k_property = $koefisien_id[$i];
                /* Save tmproperty_jenisperizinan() & tmproperty_jenisperizinan_trproperty() */
                $entry_data->save($relasi_entry);
                $entry_data_id = new tmproperty_jenisperizinan();
                $entry_data_id->select_max('id')->get();
                /* Save tmpermohonan_tmproperty_jenisperizinan() */
                $update = $entry_data_id->save($permohonan);

                if($relasi_entry->id == '12'){ //Hanya untuk KLASIFIKASI
                    $klasifikasi_id = $this->input->post('klasifikasi_id');
                    $retribusi_id = $this->input->post('retribusi_id');
                    $koef_value = $this->input->post('koef_value');
                    $koef_id = $this->input->post('koef_id');
                    $koef_value2 = $this->input->post('koef_value2');
                    $koef_id2 = $this->input->post('koef_id2');
                    $klasifikasi_len = count($retribusi_id);
                    $is_array_klasifikasi = NULL;

                    for($z=0;$z < $klasifikasi_len;$z++) {
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

                    for($z=0;$z < $klasifikasi_len;$z++) {
                        if($is_array_klasifikasi !== $retribusi_id[$z]) {
                            $relasi_klasifikasi = new trkoefesientarifretribusi();
                            $relasi_klasifikasi->get_by_id($retribusi_id[$z]);
                            $klasifikasi_data = new tmproperty_klasifikasi();
                            $klasifikasi_data->pendaftaran_id = $permohonan->pendaftaran_id;
                            $klasifikasi_data->v_klasifikasi = $koef_value[$z];
                            $klasifikasi_data->k_klasifikasi = $koef_id[$z];
                            if($updated){
                                $klasifikasi_data->v_tinjauan = $koef_value2[$z];
                                $klasifikasi_data->k_tinjauan = $koef_id2[$z];
                            }else{
                                $klasifikasi_data->v_tinjauan = $koef_value[$z];
                                $klasifikasi_data->k_tinjauan = $koef_id[$z];
                            }
                            /* Save tmproperty_klasifikasi() & tmproperty_klasifikasi_trkoefesientarifretribusi() */
                            $klasifikasi_data->save($relasi_klasifikasi);
                            $klasifikasi_data_id = new tmproperty_klasifikasi();
                            $klasifikasi_data_id->select_max('id')->get();
                            /* Save tmpermohonan_tmproperty_jenisperizinan() */
                            $klasifikasi_data_id->save($permohonan);
                        }
                        $is_array_klasifikasi = $retribusi_id[$z];
                    }
                }else if($relasi_entry->id == '29'){ //Hanya untuk PRASARANA
                    $prasarana_id = $this->input->post('prasarana_id');
                    $retribusi_id3 = $this->input->post('retribusi_id3');
                    $koef_value3 = $this->input->post('koef_value3');
                    $koef_id3 = $this->input->post('koef_id3');
                    $koef_value4 = $this->input->post('koef_value4');
                    $koef_id4 = $this->input->post('koef_id4');
                    $prasarana_len = count($retribusi_id3);
                    $is_array_prasarana = NULL;

                    for($x=0;$x < $prasarana_len;$x++) {
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

                    for($x=0;$x < $prasarana_len;$x++) {
                        if($is_array_prasarana !== $retribusi_id3[$x]) {
                            $relasi_prasarana = new trkoefesientarifretribusi();
                            $relasi_prasarana->get_by_id($retribusi_id3[$x]);
                            $prasarana_data = new tmproperty_prasarana();
                            $prasarana_data->pendaftaran_id = $permohonan->pendaftaran_id;
                            $prasarana_data->v_prasarana = $koef_value3[$x];
                            $prasarana_data->k_prasarana = $koef_id3[$x];
                            if($updated){
                                $prasarana_data->v_tinjauan = $koef_value4[$x];
                                $prasarana_data->k_tinjauan = $koef_id4[$x];
                            }else{
                                $prasarana_data->v_tinjauan = $koef_value3[$x];
                                $prasarana_data->k_tinjauan = $koef_id3[$x];
                            }
                            /* Save tmproperty_prasarana() & tmproperty_prasarana_trkoefesientarifretribusi() */
                            $prasarana_data->save($relasi_prasarana);
                            $prasarana_data_id = new tmproperty_prasarana();
                            $prasarana_data_id->select_max('id')->get();
                            /* Save tmpermohonan_tmproperty_jenisperizinan() */
                            $prasarana_data_id->save($permohonan);
                        }
                        $is_array_prasarana = $retribusi_id3[$x];
                    }
                }
                
            }  
            $is_array = $property_id[$i];
        }

        $izin = $permohonan->trperizinan->get();
        $kelompok = $izin->trkelompok_perizinan->get();
		$kel_izin = $kelompok->id;
        if($kel_izin == "1") $id_status = "4";     //Rekomendasi [Lihat Tabel trstspermohonan()]   -> kominfo old 5
        if($kel_izin == "2") $id_status = "4";     //Survey Lokasi [Lihat Tabel trstspermohonan()] -> kominfo old 4
        if($kel_izin == "3") $id_status = "4";     //Pembuatan BAP [Lihat Tabel trstspermohonan()] -> kominfo old 6
		if($kel_izin == "4") $id_status = "4";     //PBS create
		if($kel_izin == "5") $id_status = "4";     //PBS create
        $status_izin = $permohonan->trstspermohonan->get();

        $status_skr = "3";                             //Entry Data [Lihat Tabel trstspermohonan()]    -> kominfo old 3
        if($status_izin->id == $status_skr){
        /* Input Data Tracking Progress */
            $sts_izin = new trstspermohonan();
            $sts_izin->get_by_id($status_skr);
            $data_status = new tmtrackingperizinan_trstspermohonan();
            $list_tracking = $permohonan->tmtrackingperizinan->get();
            if($list_tracking){
                $tracking_id = 0;
                foreach ($list_tracking as $data_track){
                    $data_status = new tmtrackingperizinan_trstspermohonan();
                    $data_status->where('tmtrackingperizinan_id', $data_track->id)
                    ->where('trstspermohonan_id', $sts_izin->id)->get();
                    if($data_status->tmtrackingperizinan_id){
                        $tracking_id = $data_status->tmtrackingperizinan_id;
                    }
                }
            }
            $tracking_izin = new tmtrackingperizinan();
            $tracking_izin->get_by_id($tracking_id);
            //$tracking_izin->pendaftaran_id = $permohonan->pendaftaran_id;
            $tracking_izin->status = 'Update';
            $tracking_izin->d_entry = $this->lib_date->get_date_now();
			$tracking_izin->tr_user = $u_ser;
            $tracking_izin->tr_name = $r_name;
            $tracking_izin->tr_activiti = 'Entry Data.';
            $tracking_izin->save();

        /* [Lihat Tabel trstspermohonan()] */
            $tracking_izin2 = new tmtrackingperizinan();
            $tracking_izin2->pendaftaran_id = $permohonan->pendaftaran_id;
            $tracking_izin2->status = 'Insert';
            $tracking_izin2->d_entry_awal = $this->lib_date->get_date_now();
            $tracking_izin2->d_entry = $this->lib_date->get_date_now();
            $sts_izin2 = new trstspermohonan();
            $sts_izin2->get_by_id($id_status); //[Lihat Tabel trstspermohonan()]
            $sts_izin2->save($permohonan);
            $tracking_izin2->save($permohonan);
            $tracking_izin2->save($sts_izin2);

			if($id_status == "4"){             // Survai Lokasi [Lihat Tabel trstspermohonan()]
                $data_id = new tmbap();
                $data_id->select_max('id')->get();
                $data_id->get_by_id($data_id->id);
                $data_tahun = date("Y");
                //Per Tahun Auto Restart NoUrut
                if($permohonan->d_tahun == $data_tahun)
                $data_urut = $data_id->i_urut + 1;
                else $data_urut = 1;

                $i_urut = strlen($data_urut);
                for($i=4;$i>$i_urut;$i--){
                    $data_urut = "0".$data_urut;
                }

                $data_izin = $izin->id;
                $i_izin = strlen($data_izin);
                for($i=3;$i>$i_izin;$i--){
                    $data_izin = "0".$data_izin;
                }

                $data_bulan = $this->lib_date->set_month_roman(date("n"));

                $data_bap = "BAP";
                $no_bap = $data_urut."/"
                        .$data_bap."/".$data_izin."/"
                        .$data_bulan."/".$data_tahun;
                $data_skrd = "SKRD";
                $no_skrd = $data_urut."/"
                        .$data_skrd."/".$data_izin."/"
                        .$data_bulan."/".$data_tahun;
                
                $bap2 = new tmbap();
                $bap2->bap_id = $no_bap;
                $bap2->no_skrd = $no_skrd;
				$bap2->tgl_bap = $this->lib_date->get_date_now();
                $bap2->pendaftaran_id = $permohonan->pendaftaran_id;
                $bap2->i_urut = $data_urut;
				
				if($kel_izin == "5") {               // jika kelompok perijinan = Work Flow  (agar ditampilkan di penetapan izin)
					$bap2->c_pesan = 'Work Flow';
				}
                $bap2->save($permohonan);
            }
        }

        if($update) {
            $tgl = date("Y-m-d H:i:s");
            $u_ser = $this->session->userdata('username');
            $g = $this->sql($u_ser);
//          $jam = date("H:i:s A");
            //$p = $this->db->query("call log ('Entry Perizinan','Update ".$permohonan->pendaftaran_id."','".$tgl."','".$u_ser."')");
        }
            redirect('pendataan');
    }

    public function delete($uid = NULL, $asal = NULL) {
        $permohonan = new tmpermohonan();
        $permohonan->get_by_id($uid);
        $permohonan->tmpemohon->get();
        $permohonan->tmperusahaan->get();

        //Delete Relasi
        $relasi_pemohon = new tmpemohon_tmpermohonan();
        $relasi_pemohon->where('tmpermohonan_id', $permohonan->id);
        $relasi_pemohon->delete();

        $relasi_usaha = new tmpermohonan_tmperusahaan();
        $relasi_usaha->where('tmpermohonan_id', $permohonan->id);
        $relasi_usaha->delete();

        $relasi_usaha = new tmpermohonan_tmsurat_permohonan();
        $relasi_usaha->where('tmpermohonan_id', $permohonan->id);
        $relasi_usaha->delete();

        $relasi_usaha = new tmpermohonan_tmsurat_rekomendasi();
        $relasi_usaha->where('tmpermohonan_id', $permohonan->id);
        $relasi_usaha->delete();

        $tracking_izin = new tmpermohonan_tmtrackingperizinan();
        $tracking_izin->where('tmpermohonan_id', $permohonan->id)->get();
        $tracking_izin->delete();

        $jenis_izin = new tmpermohonan_trjenis_permohonan();
        $jenis_izin->where('tmpermohonan_id', $permohonan->id)->get();
        $jenis_izin->delete();

        $relasi_perizinan = new tmpermohonan_trperizinan();
        $relasi_perizinan->where('tmpermohonan_id', $permohonan->id);
        $relasi_perizinan->delete();

        $sts_izin = new tmpermohonan_trstspermohonan();
        $sts_izin->where('tmpermohonan_id', $permohonan->id)->get();
        $sts_izin->delete();

        $syarat_pendaftaran = new tmpermohonan_trsyarat_perizinan();
        $syarat_pendaftaran->where('tmpermohonan_id', $permohonan->id)->get();
        $syarat_pendaftaran->delete();

        $tgl = date("Y-m-d H:i:s");
        $u_ser = $this->session->userdata('username');
        $g = $this->sql($u_ser);
        $nomor = $permohonan->where('id', $permohonan->id)->get();
//      $jam = date("H:i:s A");
        //$p = $this->db->query("call log ('Entry Data','Delete " . $nomor->pendaftaran_id . "','" . $tgl . "','" . $u_ser . "')");

        //Delete Permohonan
        $permohonan->delete();

        //redirect('pendataan/index_next');
		switch ($asal) {
            case '1': $tujuan = 'monitoring/perketegori_tertentu'; break;
            default : $tujuan = 'pendataan/index'; break;
        }
		redirect($tujuan);
    }

  public function cetak_pertek($tgla=NULL,$tglb=NULL) {    // untuk multi print
    $lokasi_user = $this->session->userdata('lokasi');
    $username = new user();
    $username->where('username', $this->session->userdata('username'))->get();
    $group = $username->group;
    
    $data['lokasi'] = $username->lokasi;
    $data['group'] = $group;
    $data['tgla'] = $tgla;
    $data['tglb'] = $tglb;
    $data['checked'] = FALSE;
    $query_filter = " AND A.d_terima_berkas between '$tgla' and '$tglb' AND A.no_per_pertek = '' ";
    
    $qry = $this->main_sql($username->id,$query_filter,$tglb,$lokasi_user,$group);
    $data['list'] = $this->db->query($qry)->result();
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
    $this->session_info['page_name'] = "Approve Permohonan Pertimbangan Teknis";
    $this->template->build('cetak_pertek', $this->session_info);
  }

	public function ctk_np() {
		$this->load->library('fpdf');
        $syarat = $this->input->post('pilih_cetak');
        $syarat_len = count($syarat);
		$cek_len = count($syarat) - 1;
		$is_array = NULL;
		
        for ($i = 0; $i < $syarat_len; $i++) {
            $is_array = $syarat[$i];
        }

        $username = new user();
        $username->where('username', $this->session->userdata('username'))->get();
        $user = $username->realname;
		$tgla = $username->gvar1;
        $tglb = $username->gvar2;
		$gerai = $username->gvar3;
        if($gerai == '0') $c_asal = "Seluruhnya"; else $c_asal = $gerai;
		$list_state = $gerai;

        // Ambil Logo
		$this->tr_instansi = new Tr_instansi();
        $logo = $this->tr_instansi->get_by_id(23);
        $n_logo = base_url(). 'uploads/logo/ttd.png';

        // Ambil Penanda tangan
        $this->pegawai->where('status', '1')->get();
        $n_peg = $this->pegawai->n_pegawai;
		$n_pangkat = $this->pegawai->pangkat_gol;
		$cek_posisi = strpos($n_pangkat,'(');
		$n_pangkat = substr($n_pangkat,0,$cek_posisi);
		$n_nip = $this->pegawai->nip;

		// Ambil Pemerintah 
        $this->tr_instansi = new Tr_instansi();
        $nama_prov = $this->tr_instansi->get_by_id(17)->value;

        // Ambil Badan
        $this->tr_instansi = new Tr_instansi();
        $nama_badan = $this->tr_instansi->get_by_id(9)->value;

        // Ambil Alamat
        $this->tr_instansi = new Tr_instansi();
        $alamat = $this->tr_instansi->get_by_id(12)->value;

		// Ambil Telpon
        $this->tr_instansi = new Tr_instansi();
        $tlp = $this->tr_instansi->get_by_id(10)->value;

        // Ambil Fax
        $this->tr_instansi = new Tr_instansi();
        $fax = $this->tr_instansi->get_by_id(13)->value;

		// Ambil Kota
        $this->tr_instansi = new Tr_instansi();
        $kota = $this->tr_instansi->get_by_id(19)->value;

		// Ambil Kode Pos
        $this->tr_instansi = new Tr_instansi();
        $kdpos = $this->tr_instansi->get_by_id(20)->value;

		// Ambil web
        $this->tr_instansi = new Tr_instansi();
        $web = $this->tr_instansi->get_by_id(21)->value;

		// Ambil e-mail
        $this->tr_instansi = new Tr_instansi();
        $e_mail = $this->tr_instansi->get_by_id(22)->value;

		// Ambil tinggi_kop
        $this->tr_instansi = new Tr_instansi();
        $tinggi_kop = $this->tr_instansi->get_by_id(26)->value;
        
        $alamat = $alamat . ' Tlp. ' . $tlp . ', Fax. ' . $fax;
        $alamat2 = 'Website: ' . $web . '   e-mail: ' . $e_mail;
		$alamat3 = strtoupper($kota) . ' - ' . $kdpos;
        $judul1 = 'Rekapitulasi Perizinan Periode '. $this->lib_date->mysql_to_human($tgla).' - '.$this->lib_date->mysql_to_human($tglb);
		$judul2 = 'Asal Permohonan : ' . $c_asal;

        //$pdf = new FPDF({P/L},{pt/mm/cm/in},{A3/A4/A5/LETTER/LEGAL});
		//$pdf = new FPDF();
		$pdf = new FPDF('P','mm','LETTER'); //('a3'=>array(841.89,1190.55), 'a4'=>array(595.28,841.89), 'a5'=>array(420.94,595.28), 'letter'=>array(612,792), legal'=>array(612,1008));
		//$pdf->SetMargins(0,20,0); //$pdf->SetMargins(kiri,atas,kanan);
//		$pdf->AddPage();
/**		$pdf->Image($n_logo,2,5,22);
		$pdf->SetFont('Arial','B',15);
		$pdf->Ln(9); $pdf->Cell(0,0.5,$nama_prov,0,1,'C');
		$pdf->SetFont('Arial','B',16);
		$pdf->Ln(5); $pdf->Cell(0,0.5,$nama_badan,0,1,'C');
		$pdf->SetFont('Arial','B',11);
		$pdf->Ln(5); $pdf->Cell(0,0.5,$alamat,0,1,'C');
		$pdf->Ln(4); $pdf->Cell(0,0.5,$alamat2,0,1,'C');
		$pdf->Ln(4); $pdf->Cell(0,0.5,$alamat3,0,1,'C');
        $pdf->SetLineWidth(0.1); $pdf->Line(1,33,209,33);
		$pdf->SetLineWidth(0.5); $pdf->Line(1,34,209,34);

        $pdf->SetFont('Arial','',11);
		$pdf->Ln(13); $pdf->Cell(0,0.5,$judul1,0,1,'C');
		$pdf->Ln(5); $pdf->Cell(0,0.5,$judul2,0,1,'C');
**/
        $Wpaper = 262;
		$Hpaper = 450;
		$pdf->AddPage('P',array($Hpaper,$Wpaper));
		$pdf->SetMargins(0,0,0);  //$pdf->SetMargins(kiri,atas,kanan);
        $tinggikop = $tinggi_kop; //dapat diubah untuk menentukan tinggi kop surat yang ada
		$brs = $pdf->GetY();
		$pdf->Ln($tinggikop);
		//cek kesamaan jenis izin
		for ($is = 0; $is < $syarat_len; $is++) {
            $permohonan = new tmpermohonan();
            $permohonan = $permohonan->get_by_id($syarat[$is]);
            $perizinan = $permohonan->trperizinan->get();
			$n_izin = $perizinan->n_perizinan;
			if($is == 0){
				$id_izin = $perizinan->id;
				$id_sama = TRUE;
			}else{
			    if($id_izin != $perizinan->id){
                    $id_sama = FALSE;
					break;
				}
			}
		}

		$spc  = '          ';
		$sp = 0;
		$br1  = 'NOTA PENJELASAN';
		$br2  = '';
		$br3  = 'Kepada';
		$br3a = 'Kepala Badan Penanaman Modal dan Perijinan Terpadu Kabupaten Tasikmalaya';
		$br4  = 'Dari';
		$br4a = 'Kepala Bidang Pelayanan';
		$br5  = 'Perihal';
        if($id_sama)
		    $br5a = 'Permohonan Penandatanganan Surat '.ucwords(strtolower($n_izin));
		else
            $br5a = 'Permohonan Penandatanganan Surat Izin';
		if($syarat_len == 1)
			$br6  = 'Disampaikan dengan hormat, berkas Administrasi Izin dari : ';
		else
		    $br6  = 'Disampaikan dengan hormat, berkas Administrasi Izin sejumlah '.$syarat_len.' ('.$this->terbilang->terbilang($syarat_len).') berkas, terdiri dari : ';

		$pegawai = new tmpegawai();
		$pegawai = $pegawai->where('status', '2')->get();
		$br7  = 'Sehubungan dengan hal tersebut proses penelitian berkas telah sesuai dengan ketentuan yang berlaku sehingga dapat diterbitkan naskah perizinan untuk ditanda tangani Kepala Badan Penanaman Modal dan Perijinan Terpadu Kabupaten Tasikmalaya';
		$br9  = 'Untuk keperluan tersebut dipergunakan kendaraan sebagai berikut :';
		$br10 = 'Tasikmalaya, '.$this->lib_date->mysql_to_human(date('Y-m-d'));
		$br11 = $pegawai->n_jabatan;
		$br12 = $pegawai->n_pegawai;
		$br13 = $pegawai->pangkat_gol;
		$br14 = 'NIP. '.$pegawai->nip;
		$tab = 30;

        $pdf->SetFont('times','U',20);
		$pdf->Ln(15); $pdf->Cell(0,0,$br1,2,2,'C');
		$pdf->SetFont('times','',16);
		$pdf->Ln(7);  $pdf->Cell(0,0,$br2.$spc.$spc,0,1,'C');
		$pdf->Ln(15); $pdf->Cell(0,0,$br3,0,1,'L');
				      $pdf->SetXY($pdf->GetX()+23, $pdf->GetY()); $pdf->Cell(0,0,' : ',0,1,'L');
				      $pdf->SetXY($pdf->GetX()+$tab, $pdf->GetY()-2.5); $pdf->MultiCell(0,6,$br3a,0,'J');
		$pdf->Ln(5);  $pdf->Cell(0,0,$br4,0,1,'L');
				      $pdf->SetXY($pdf->GetX()+23, $pdf->GetY()); $pdf->Cell(0,0,' : ',0,1,'L');
				      $pdf->SetXY($pdf->GetX()+$tab, $pdf->GetY()-2.5); $pdf->MultiCell(0,6,$br4a,0,'J');
		$pdf->Ln(5);  $pdf->Cell(0,0,$br5,0,1,'L');
				      $pdf->SetXY($pdf->GetX()+23, $pdf->GetY()); $pdf->Cell(0,0,' : ',0,1,'L');
				      $pdf->SetXY($pdf->GetX()+$tab, $pdf->GetY()-2.5); $pdf->MultiCell(0,6,$br5a,0,'J');

        $pdf->Ln(5);  $pdf->SetLineWidth(0.2);
                      $pdf->Line(1,$pdf->GetY(),260,$pdf->GetY());
		$pdf->Ln(1);  $pdf->SetLineWidth(0.6);
                      $pdf->Line(1,$pdf->GetY(),260,$pdf->GetY());
        $pdf->Ln(5);  $pdf->SetXY($pdf->GetX()+$tab, $pdf->GetY()); $pdf->MultiCell(0,6,$spc.$br6,0,'J');
		//Mencetak judul dengan tinggi bervariasi
		$pdf->SetFont('times','',14);
		$jd1 = 'NO';
		$jd2 = ' NO PENDAFTARAN '.' TANGGAL DAFTAR ';
		$jd3 = 'NAMA PEMOHON';
		if($id_sama)
		    $jd4 = '         NOMOR SURAT         '.'         TANGGAL SURAT         ';
		else
			$jd4 = 'NAMA IZIN';
		$judul = array($jd1,$jd2,$jd3,$jd4);
		$l_col = array(10,55,75,90); 
		$align = array('C','C','C','C');
		$hit_judul = count($judul);

		$pdf->Ln(5);
        $space = 5;
		$nb=0;
		$pdf->SetXY($pdf->GetX()+$tab, $pdf->GetY());
		// Create box
        for($i=0;$i<count($judul);$i++){
            $nb=max($nb,$pdf->NbLines($l_col[$i],$judul[$i]));
		}
        $h=$space*$nb;
        //Issue a page break first if needed
        $pdf->CheckPageBreak($h);
        //Draw the cells of the row
        for($i=0;$i<count($judul);$i++) {
            $w=$l_col[$i];
            $a=isset($align[$i]) ? $align[$i] : 'L';
            //Save the current position
            $x=$pdf->GetX();
            $y=$pdf->GetY();
            //Draw the border

            $pdf->Rect($x,$y,$w,$h);
            //Print the text

            $pdf->MultiCell($w,$space,$judul[$i],0,$a);
            //Put the position to the right of the cell
            $pdf->SetXY($x+$w,$y);
        }
        //Go to the next line
        $pdf->Ln($h);
        //EOF(Mencetak judul dengan tinggi bervariasi)

		//cetak isi tabel ke pdf
		//$isi = array($no.'.',$data['n_sektor'],number_format($jumlah_masuk),number_format($jumlah_terbit),number_format($terbit_ambil),
		//       number_format($terbit_proses),number_format($jumlah_tolak),number_format($tolak_ambil),number_format($tolak_proses),
		//       number_format($jml_tolak_FO),number_format($jumlah_proses));
	    $no = 0;
		for($ai=0; $ai<$syarat_len; $ai++){
            $permohonan = new tmpermohonan();
            $permohonan = $permohonan->get_by_id($syarat[$ai]);
            $perizinan = $permohonan->trperizinan->get();
			$pemohon = $permohonan->tmpemohon->get();
			$perusahaan = $permohonan->tmperusahaan->get();
			$sk = $permohonan->tmsk->get();
        
			//OLD Create Barcode
			//$color_black = new BCGColor(0, 0, 0);
            //$color_white = new BCGColor(255, 255, 255);
            //$code = new BCGcode128();
            //$code->setThickness(25);
            //$code->setForegroundColor($color_black); // Color of bars
            //$code->setBackgroundColor($color_white); // Color of spaces
            //$code->parse($permohonan->pendaftaran_id); // Text
            //$drawing = new BCGDrawing('assets/barcode/' . $syarat[$ai] . '.png', $color_white);
            //$drawing->setBarcode($code);
            //$drawing->draw();
            //$drawing->finish(BCGDrawing::IMG_FORMAT_PNG);
			//$b_code = base_url(). 'assets/barcode/' . $syarat[$ai] . '.png';
			//$b_code = base_url(). 'assets/barcode/51.png';
			// EOF() OLD Barcode

            //NEW BARCODE
    		$font = new BCGFontFile('./www/libraries/font/Arial.ttf', 10);
            $text = isset($_GET['text']) ? $_GET['text'] : $permohonan->pendaftaran_id;
            // The arguments are R, G, B for color.
            $color_black = new BCGColor(0, 0, 0);
            $color_white = new BCGColor(255, 255, 255);
            $drawException = null;
            try {
                 $code = new BCGcode128();
                 $code->setScale(2); // Resolution
                 $code->setThickness(30); // Thickness
                 $code->setForegroundColor($color_black); // Color of bars
                 $code->setBackgroundColor($color_white); // Color of spaces
                 $code->setFont($font); // $font or 0
                 $code->parse($text); // Text
               } catch(Exception $exception) {
                 $drawException = $exception;
               }
           /* Here is the list of the arguments
           1 - Filename (empty : display on screen)
           2 - Background color */
           ///$drawing = new BCGDrawing('', $color_white);
           $drawing = new BCGDrawing('assets/barcode/' . $syarat[$ai] . '.png', $color_white);
           if($drawException) {
               $drawing->drawException($drawException);
           } else {
               $drawing->setBarcode($code);
               $drawing->draw();
           }
           //$drawing->setFilename('barcode.png');
           ///header('Content-Type: image/png');
           ///header('Content-Disposition: inline; filename="barcode.png"');
           // Draw (or save) the image into PNG format.
           $drawing->finish(BCGDrawing::IMG_FORMAT_PNG);
		   $b_code = base_url(). 'assets/barcode/' . $syarat[$ai] . '.png';
           //EOF() NEW BARCODE

			$no++;
			if($id_sama)
			    $isi = array($no.'.',
				         $permohonan->pendaftaran_id .'  '.'                                             '. $this->lib_date->mysql_to_human($permohonan->d_terima_berkas),
				         $pemohon->n_pemohon.' Alamat:'.$pemohon->a_pemohon,
				         $sk->no_surat.' Tanggal: '.$this->lib_date->mysql_to_human($sk->tgl_surat),
				         );
			else
				$isi = array($no.'.',
				         $permohonan->pendaftaran_id .'  '.'                                             '. $this->lib_date->mysql_to_human($permohonan->d_terima_berkas),
				         $pemohon->n_pemohon.' Alamat:'.$pemohon->a_pemohon,
				         ucwords(strtolower($perizinan->n_perizinan)),
				         );
    		$align = array('R','L','L','L');
            $space = 5;
   	    	$nb=0;
   
			$pdf->SetXY($pdf->GetX()+$tab, $pdf->GetY());
            // Create box
			for($i=0;$i<count($isi);$i++)
                $nb=max($nb,$pdf->NbLines($l_col[$i],$isi[$i]));
            $h=$space*$nb;
            //Issue a page break first if needed
            $pdf->CheckPageBreak($h);
            //Draw the cells of the row
            for($i=0; $i<count($isi); $i++) {
				$w=$l_col[$i];
                $a=isset($align[$i]) ? $align[$i] : 'L';
                //Save the current position
                $x=$pdf->GetX();
                $y=$pdf->GetY();
                //Draw the border
                $pdf->Rect($x,$y,$w,$h);
                //Print the text
                $pdf->MultiCell($w,$space,$isi[$i],0,$a);
				if($i==0){
					$ypos_bc = $pdf->GetY();
				    $pdf->Image($b_code,$x+$l_col[0]+2,$ypos_bc+1,25);
				}
                //Put the position to the right of the cell
                $pdf->SetXY($x+$w,$y);
            }

            //Inisialisasi ulang halaman baru
            if($y >= 370){
                $pdf->AddPage('P',array($Hpaper,$Wpaper)); // Ganti halaman dapat 74
                $pdf->SetMargins(0,0,0);                   //$pdf->SetMargins(kiri,atas,kanan);
                $pdf->SetY($brs);
    			$y=$pdf->GetY();
                //$pdf->Ln($tinggikop);
            }
    		// EOF() Cetak Full

            //Go to the next line
            $pdf->Ln($h);
	        unlink('assets/barcode/' . $syarat[$ai] . '.png');
		}
        // EOF(cetak isi tabel ke pdf)

        //ttd
		//$pdf->Ln(5); $pdf->Cell(0,0,$pdf->GetY(),0,1,'L');
		//$pdf->Ln(5); $pdf->Cell(0,0,$pdf->GetY(),0,1,'L');
		//$pdf->Ln(5); $pdf->Cell(0,0,$pdf->GetY(),0,1,'L');
		//$pdf->Ln(5); $pdf->Cell(0,0,$pdf->GetY(),0,1,'L');
		//$pdf->Ln(5); $pdf->Cell(0,0,$pdf->GetY(),0,1,'L');
		//$pdf->Ln(5); $pdf->Cell(0,0,$pdf->GetY(),0,1,'L');
		if($pdf->GetY() > 330){ // nilai sesuaikan dengan coba tampilan diatas
            $pdf->AddPage('P',array($Hpaper,$Wpaper)); // Ganti halaman dapat 74
            $pdf->SetMargins(0,0,0);                   //$pdf->SetMargins(kiri,atas,kanan);
            $pdf->SetY($brs);
    	    $y=$pdf->GetY();
            //$pdf->Ln($tinggikop);
        }
		$pdf->SetFont('times','',16);
		$pdf->Ln(5);  $pdf->SetXY($pdf->GetX()+$tab, $pdf->GetY()); $pdf->MultiCell(0,6,$spc.$br7,0,'J');
		$pdf->Ln(25); 
                     $pdf->Cell(160); $pdf->Cell(0,0,$br10,0,1,'C');
		$pdf->Ln(6); $pdf->Cell(160); $pdf->Cell(0,0,$br11,0,1,'C');
					 $a = $pdf->GetY();
        //			 $pdf->Image($n_logo,155,$pdf->GetX()+$a+2,35);
		$pdf->Ln(30);$pdf->Cell(160); $pdf->Cell(0,0,$br12,0,1,'C');
		$pdf->Ln(6); $pdf->Cell(160); $pdf->Cell(0,0,$br13,0,1,'C');
		$pdf->Ln(6); $pdf->Cell(160); $pdf->Cell(0,0,$br14,0,1,'C');
        // EOF() ttd

        $pdf->Output('CetakKP.pdf','D');
    }

  public function print_pertek($alur=NULL, $tg_pertek = NULL, $no_upertek = NULL, $cr_adm = NULL) {
  	if($no_upertek != NULL && $cr_adm == NULL){ // Jika Sudah Penomoran dan approve pengolah
  		$tg_pertek = str_replace('_',' ',$tg_pertek);
  		$this->Create_WaterMark(date("Y",strtotime($tg_pertek)), $no_upertek);
  	}else{                   // Jika Belum Penomoran dan approve pengolah
  		$this->load->library('fpdf');
      if($alur) { // jika langsung cetak (bukan multi) cetak satu
        if($no_upertek != ''){
          $alur = NULL;
          $tg_pertek = $this->lib_date->ambil_tahun($tg_pertek);
          $query = mysql_query("SELECT id FROM tmpermohonan WHERE no_per_pertek = '$no_upertek' AND tg_per_pertek LIKE '%$tg_pertek%'"); 
          $syarat = ' ';
          $syarat_len = mysql_num_rows($query);
          while ($rows = mysql_fetch_assoc(@$query)) $syarat .= $rows['id'].';';
          $syarat = explode(";",str_replace(' ','',$syarat));
        }else{
          $syarat = $alur;
          $syarat_len = 1;
        }
      }else{
        $syarat = $this->input->post('pilih_cetak');
        $syarat_len = count($syarat); //hitung jumlah array
      }
      $username = new user();
      $username->where('username', $this->session->userdata('username'))->get();
      $user = $username->realname;
      $tgla = $username->gvar1;
      $tglb = $username->gvar2;
      $gerai = $username->gvar3;
      if($gerai == '0') $c_asal = "Seluruhnya"; else $c_asal = $gerai;
      $list_state = $gerai;
      
      // Ambil Logo
      $this->tr_instansi = new Tr_instansi();
      $logo = $this->tr_instansi->get_by_id(14);
      $n_logo = base_url(). 'uploads/logo/'.$logo->value;
      
      // Ambil Penanda tangan
      $this->pegawai->where('status', '1')->get();
      $n_peg = $this->pegawai->n_pegawai;
      $n_pangkat = $this->pegawai->pangkat_gol;
      $cek_posisi = strpos($n_pangkat,'(');
      $n_pangkat = substr($n_pangkat,0,$cek_posisi);
      $n_nip = $this->pegawai->nip;
      
      // Ambil Pemerintah 
      $this->tr_instansi = new Tr_instansi();
      $nama_prov = $this->tr_instansi->get_by_id(17)->value;
      
      // Ambil Badan
      $this->tr_instansi = new Tr_instansi();
      $nama_badan = $this->tr_instansi->get_by_id(9)->value;
      
      // Ambil Alamat
      $this->tr_instansi = new Tr_instansi();
      $alamat = $this->tr_instansi->get_by_id(12)->value;
      
      // Ambil Telpon
      $this->tr_instansi = new Tr_instansi();
      $tlp = $this->tr_instansi->get_by_id(10)->value;
      
      // Ambil Fax
      $this->tr_instansi = new Tr_instansi();
      $fax = $this->tr_instansi->get_by_id(13)->value;
      
      // Ambil Kota
      $this->tr_instansi = new Tr_instansi();
      $kota = $this->tr_instansi->get_by_id(19)->value;
      
      // Ambil Kode Pos
      $this->tr_instansi = new Tr_instansi();
      $kdpos = $this->tr_instansi->get_by_id(20)->value;
      
      // Ambil web
      $this->tr_instansi = new Tr_instansi();
      $web = $this->tr_instansi->get_by_id(21)->value;
      
      // Ambil e-mail
      $this->tr_instansi = new Tr_instansi();
      $e_mail = $this->tr_instansi->get_by_id(22)->value;
      
      // Ambil tinggi_kop
      $this->tr_instansi = new Tr_instansi();
      $tinggi_kop = $this->tr_instansi->get_by_id(26)->value;
      
      $alamat = $alamat;
      $alamat2 = ucfirst($kota) . ' - Tasikmalaya Kode Pos ' . $kdpos;
      $alamat3 = ' Tlp. / Fax. ' . $tlp . ' e-mail: ' . $e_mail;
        
      //$pdf = new FPDF({P/L},{pt/mm/cm/in},{A3/A4/A5/LETTER/LEGAL});
      //$pdf = new FPDF();
      //for($kali = 1; $kali <= 2; $kali++) {   // 1:Naskah Full  2:Naskah Draft
      // 	if($kali == 1) echo $kali.' A'.'<br>';
      //	if($kali == 2) echo $kali.' B'.'<br>';
      //}
      //die;
      for($kali = 1; $kali <= 2; $kali++) {   // 1:Naskah Full  2:Naskah Draft	 
        $pdf = new FPDF('P','mm','LETTER'); //('a3'=>array(841.89,1190.55), 'a4'=>array(595.28,841.89), 'a5'=>array(420.94,595.28), 'letter'=>array(612,792), legal'=>array(612,1008));
        $Wpaper = 262;
        $Hpaper = 450;
        
        //$pdf->SetMargins(0,20,0); //$pdf->SetMargins(kiri,atas,kanan);
        //$pdf->AddPage();
        $pdf->AddPage('P',array($Hpaper,$Wpaper));
        $pdf->SetMargins(0,0,0);  //$pdf->SetMargins(kiri,atas,kanan);
        
        //Cetak Kop Surat
        $pdf->Image($n_logo,3,7,30);   //2,5,22
        $pdf->SetFont('Arial','B',16);
        $pdf->Ln(2); $pdf->SetXY($pdf->GetX()+40,  $pdf->GetY());
                     $pdf->Cell(0,0.5,$nama_prov,0,1,'C');
        $pdf->SetFont('Arial','B',17);
        $pdf->Ln(7); $pdf->SetXY($pdf->GetX()+40,  $pdf->GetY());
                     $pdf->Cell(0,0.5,"DINAS PENANAMAN MODAL, PELAYANAN TERPADU",0,1,'C');
        $pdf->Ln(7); $pdf->SetXY($pdf->GetX()+40,  $pdf->GetY());
                     $pdf->Cell(0,0.5," SATU PINTU DAN TENAGA KERJA",0,1,'C');
        $pdf->SetFont('Arial','B',13);
        $pdf->Ln(6); $pdf->SetXY($pdf->GetX()+40,  $pdf->GetY());
                     $pdf->Cell(0,0.5,$alamat,0,1,'C');
        $pdf->Ln(6); $pdf->SetXY($pdf->GetX()+40,  $pdf->GetY());
                     $pdf->Cell(0,0.5,$alamat2,0,1,'C');
        $pdf->Ln(6); $pdf->SetXY($pdf->GetX()+40,  $pdf->GetY());
                     $pdf->Cell(0,0.5,$alamat3,0,1,'C');
        $pdf->SetLineWidth(0.6); $pdf->Line(1,50,261,50);
        $pdf->SetLineWidth(0.4); $pdf->Line(1,51,261,51);
        $pdf->SetFont('Arial','',11);
        $tinggikop = 0; //$tinggi_kop; //dapat diubah untuk menentukan tinggi kop surat yang ada
        //EOF() Cetak Kop Surat
        
        $brs = 20;
        //$pdf->SetAutoPageBreak('ON', 60);  //63
        $pdf->SetTopMargin($brs);
        $pdf->SetLeftMargin(10);
        $pdf->SetRightMargin(10);
        $pdf->Ln($tinggikop);
        //cek kesamaan jenis izin
        for($is = 0; $is < $syarat_len; $is++) {
          $permohonan = new tmpermohonan();
          $permohonan = $permohonan->get_by_id($syarat[$is]);
          $perizinan = $permohonan->trperizinan->get();
          $n_izin = $perizinan->n_perizinan;
          if($is == 0){
            $id_izin = $perizinan->id;
            $id_sama = TRUE;
          }else{
            if($id_izin != $perizinan->id){
              $id_sama = FALSE;
              break;
            }
          }
        }
                
        $permohonan = new tmpermohonan();
        $no_urut_pertek = "        ";
        $tg_per_pertek = date('Y-m-d');
        if($alur){ //cetak satu
          $permohonan = $permohonan->get_by_id($syarat);
        }else{     //cetak multi
          $permohonan = $permohonan->get_by_id($syarat[0]);
        }
        $perizinan = $permohonan->trperizinan->get();
        $unitkerja = $perizinan->trunitkerja->get();
        $bidang    = $perizinan->bid_teknis;
        $perihal   = $perizinan->sartek_perihal;
        $alenia1   = $perizinan->sartek_alenia1;
        $alenia2   = $perizinan->sartek_alenia2;
        $alenia3   = $perizinan->sartek_alenia3;
        $alenia4   = $perizinan->sartek_alenia4;
        $durasi    = $perizinan->v_hari;
        $sektor    = $perizinan->trsektor->get();
        $unit      = $unitkerja->n_unitkerja;
        $posisi = strpos($bidang,'${');
        $bidang1 = '';
        if($posisi != ''){
          $bidang1 = trim(substr($bidang,$posisi+2,strlen($bidang)));
          $bidang  = trim(substr($bidang,0,$posisi));
        }
        if(!$bidang) $bidang = 'Belum diseting';
        if(!$durasi) $durasi = '(Belum diseting)';
        if(!$unit)   $unit   = 'Belum diseting';
        
        // penomoran permohonan pertek Otomatis Per Tahun Auto Restart No permohonan Pertek
        if($permohonan->no_per_pertek == '') { // belum ada no permohonan sartek
          $save_nomor = TRUE;
          $data_tahun = date('Y');
          $tg_per_pertek = date('Y-m-d H:i:s');
          $year = new year();
          $year = $year->where('tahun', $data_tahun)->get();
          if($year->tahun){ // ditemukan
            if($kali == 1){
              $no_urut_pertek = $year->no_urut_pertek + 1;
            }  
          }else{            // tidakditemukan
            $no_urut_pertek = 1;
            $year = new year();
            $year->tahun = $data_tahun;
          }
          $year->no_urut_pertek = $no_urut_pertek;
          if($kali == 1){
            $year->save();
          }  
          $npaw = $sektor->no_pertek_awal.' / ';
          $ns = $no_urut_pertek;
          $npak = ' / '.$sektor->no_pertek_akhir;
        }else{   // sudah ada no pertek
          $save_nomor = FALSE;
          $no_urut_pertek = $permohonan->no_per_pertek;
          $tg_per_pertek = $permohonan->tg_per_pertek;
          $suratkeluar = new tmsurat_keluar();
          $suratkeluar->where('tmpermohonan_id', $permohonan->id)->where('no_surat', $no_urut_pertek)->get();
          $npaw = $suratkeluar->no_pertek_awal;
          if($npaw == '') $npaw = '503/';
          $ns = $suratkeluar->no_surat;
          $npak = $suratkeluar->no_pertek_akhir;
          if($npak == '') $npak = '/PelPer';
        }
        $this->settings->where('name', 'no_pertek')->get();
        if($this->settings->status == 1){
          $no_pertek = $npaw.$ns.$npak;
        }else{
          $no_pertek = $npaw.'          '.$npak;
        }
            
        $i_urut = strlen($no_urut_pertek);
        $bcno_urut_pertek = $no_urut_pertek;
        for($i = 5; $i > $i_urut; $i--) {
          $bcno_urut_pertek = "0" . $bcno_urut_pertek;
        }
        $tgl = $tg_per_pertek;
        $jam_pertek = date("H",strtotime($tgl)).date("i",strtotime($tgl)).date("s",strtotime($tgl));
        $jam_pertek_ctk = ';'.date("H",strtotime($tgl)).':'.date("i",strtotime($tgl)).':'.date("s",strtotime($tgl));
        //$cod_bar = $bcno_urut_pertek.$this->lib_date->ambil_tahun($tg_per_pertek).$this->lib_date->ambil_bulan($tg_per_pertek,1).
        //$this->lib_date->ambil_tanggal($tg_per_pertek);   // gabungan no_urut dan tanggal pertek
        $cod_bar_thn = $bcno_urut_pertek.date("Y",strtotime($tgl));
        $cod_bar     = $cod_bar_thn.$jam_pertek;       // gabungan no_urut dan Jam Pertek utk barcode
        $cod_bar_ctk = $cod_bar_thn.$jam_pertek_ctk;   // gabungan no_urut dan Jam Pertek utk cetak
        
        //Create QRCode
		    if($kali == 1){
		      include('./assets/qrcode/qrlib.php');
		    }  
        $tempDir = 'uploads/data_qrcode_pt/';
		    $link = 'https://spekta.tasikmalayakab.go.id/spekta/main/cekpt/index/';
	      $codeContents = $link.$cod_bar_thn;
	      $codeContents = str_replace(' ', '_',$codeContents);
		    $fileName = 'PT_'.$cod_bar_thn.'.png';               // Create ID Permohonan Pertek
        $pngAbsoluteFilePath = $tempDir.$fileName;
        $urlRelativeFilePath = base_url().$tempDir.$fileName; //EXAMPLE_TMP_URLRELPATH.$fileName;
        if(!file_exists($tempDir))    { mkdir($tempDir); }    #kalau folder belum ada, maka buat.
          
		    if(!file_exists($pngAbsoluteFilePath)) {  # jika file qrcode id_izin tidak ada  
		      $quality = 'H'; //ada 4 pilihan, L (Low), M(Medium), Q(Good), H(High)
          $ukuran = 5;    //batasan 1 paling kecil, 10 paling besar
          $padding = 0;
          QRCode::png($codeContents,$tempDir.$fileName,$quality,$ukuran,$padding);
        }
        $b_code_no_pertek = base_url(). $tempDir . $fileName;
        $logo_bsre = base_url() . 'uploads/logo/bsre.jpg';
        //EOF() Create QRCode
        
        // EOF() penomoran pertemohonan pertek Otomatis
        
        $spc  = '          ';
        $sp = 0;
        $br0  = 'Singaparna, '.$this->lib_date->mysql_to_human($tg_per_pertek); //date('Y-m-d'));
        $br1  = 'Nomor';
        $br1a = $no_pertek; //'503/          /PelPer ';
        $br1b = 'Kepada';
        $br2  = 'Sifat';
        $br2a = 'Biasa';
        $br3  = 'Lampiran';
        $br3a = '-';
        $br3b = 'Yth.';
        $br3c = 'KEPALA '.strtoupper($bidang);
        $br3d = strtoupper($bidang1);
        $br4  = 'Hal';
        
        $br4a = $perihal;
        if($br4a == '')
          $br4a = 'Pertimbangan Teknis';
        
        $br4b = 'di-';
        $br5  = 'TEMPAT';
        
        $br6  = $alenia1;
        if($br6 == '')
          $br6 = "Bismillaahirrahmaanirrahiim.
        Assalamu'alaikum Wr. Wb.";
        
        $br6a = $alenia2;
        if($br6a == '')
          $br6a = 'Disampaikan dengan hormat, berkas permohonan Izin Apotek untuk dilakukan pemeriksaan lapangan oleh Tim Teknis Dinas Kesehatan dan Pengendalian Penduduk Kabupaten Tasikmalaya, sebagaimana daftar berikut :';
        
        $br7 = $alenia3;
        if($br7 == '')
          $br7 = 'Mengingat target waktu penerbitan izin disesuaikan dengan SOP (Standar Operasional Prosedur), hpenerbitan rekomendasi teknis kami harapkan secepatnya.';
            
        $br8 = $alenia4;
        if($br8 == '')
          $br8 = "Demikian, atas perhatian dan kerjasamanya kami ucapkan terima kasih.

Wassalamu'alaikum Wr. Wb.";
        
        // $br9 = 'Demikian disampaikan, atas kerjasamanya disampaikan terimakasih.';
        $br9 = '';
        $br10 = '';
        		
        $pegawai = new tmpegawai();
        $pegawai = $pegawai->where('id', $sektor->ttd_sp)->get();
        $ukerja = $pegawai->trunitkerja->get();
        $nm_cap    = $ukerja->nm_cap;
        $br11 = ''; $br11a = ''; $jbt = '';
        if($sektor->ttd_sp == '1'){     // utk kepala
          $br11 = 'KEPALA DINAS PENANAMAN MODAL, PELAYANAN';
          $br11a = 'TERPADU SATU PINTU DAN TENAGA KERJA';
        }else{
          $br11 = 'a.n. KEPALA DINAS PENANAMAN MODAL, PELAYANAN';
          $br11a = 'TERPADU SATU PINTU DAN TENAGA KERJA';
          $jbt = $pegawai->n_jabatan;
        }
        $br12 = 'KABUPATEN TASIKMALAYA';
        $br13 = $jbt;
        $br14 = $pegawai->n_pegawai;
        $br15 = $pegawai->pangkat_gol;
        $br16 = 'NIP. '.$pegawai->nip;
        // $br17 = 'Tembusan Kepada Yth:';
        // $br18 = '1. Kepala Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu Kabupaten Tasikmalaya;';
        // $br19 = ucwords(strtolower('2. Kepala '.$unit.'.'));
        $br17 = '';
        $br18 = '';
        $br19 = '';
        $br20 = '';
        $br21 = '';
        $br22 = '';
        $br23 = '';
        // $ttd  = base_url(). 'uploads/logo/'.(str_replace(' ','',$pegawai->nip)).'.png';
        $ttd  = base_url(). 'uploads/qrcode/'.(str_replace(' ','',$pegawai->nip)).'.png';
        // $cap_dinas = base_url(). 'uploads/logo/'.$nm_cap;
        // $cap_dinas = '';
        $br24 = '';
        $br25 = '';
        $br26 = '';
        $br27 = '';
        $br28 = '';
        $br29 = '';
        $br30 = '';
        $tab = 30;
        
        $pdf->SetFont('times','',16);
        $pdf->Ln(15); 
        if($kali == 1){
          $pdf->SetXY($pdf->GetX()+125,  $pdf->GetY());
          $pdf->Cell(0,0,$br0,2,2,'L');
        }else{
          $pdf->Cell(0,0,'Draft Rencana '.$br0.', No. '.$br1a,2,2,'L');
        }  
        $pdf->Ln(10); $pdf->Cell(0,0,$br1,0,1,'L');
                      $pdf->SetXY($pdf->GetX()+23,   $pdf->GetY()); $pdf->Cell(0,0,' : ',0,1,'L');
                      $pdf->SetXY($pdf->GetX()+$tab, $pdf->GetY()); 
                      if($kali == 1){
                        $pdf->Cell(0,0,$br1a,0,1,'L');
                      }else{
                        $pdf->Cell(0,0,'',0,1,'L');
                      }
                      $pdf->SetXY($pdf->GetX()+125,  $pdf->GetY()); $pdf->Cell(0,0,$br1b,0,1,'L');
        $pdf->Ln(6);  $pdf->Cell(0,0,$br2,0,1,'L');
                      $pdf->SetXY($pdf->GetX()+23,   $pdf->GetY()); $pdf->Cell(0,0,' : ',0,1,'L');
                      $pdf->SetXY($pdf->GetX()+$tab, $pdf->GetY()); $pdf->Cell(0,0,$br2a,0,1,'L');
        $pdf->Ln(6);  $pdf->Cell(0,0,$br3,0,1,'L');  $a = $pdf->GetY();
                      $pdf->SetXY($pdf->GetX()+23,   $pdf->GetY()); $pdf->Cell(0,0,' : ',0,1,'L');
                      $pdf->SetXY($pdf->GetX()+$tab, $pdf->GetY()); $pdf->Cell(0,0,$br3a,0,1,'L');
                      $pdf->SetXY($pdf->GetX()+125,  $pdf->GetY()); $pdf->Cell(0,0,$br3b,0,1,'L');
        if($bidang1 == ''){
          $pdf->SetXY($pdf->GetX()+140,  $pdf->GetY()-2.5); $pdf->MultiCell(0,5,$br3c,0,'J');
        }else{
          $pdf->SetXY($pdf->GetX()+135,  $pdf->GetY()-2.5); $pdf->MultiCell(0,5,'1.',0,'J');
          $pdf->SetXY($pdf->GetX()+140,  $pdf->GetY()-5); $pdf->MultiCell(0,5,$br3c,0,'J');
          $pdf->Ln(2.5);
          $pdf->SetXY($pdf->GetX()+135,  $pdf->GetY()-2.5); $pdf->MultiCell(0,5,'2.',0,'J');
          $pdf->SetXY($pdf->GetX()+140,  $pdf->GetY()-5); $pdf->MultiCell(0,5,$br3d,0,'J');
        }
        $b = $pdf->GetY();
        $pdf->SetXY($pdf->GetX(),$a);
        $pdf->Ln(6);  $pdf->Cell(0,0,$br4,0,1,'L');
                      $pdf->SetXY($pdf->GetX()+23,   $pdf->GetY()); $pdf->Cell(0,0,' : ',0,1,'L');
                      $pdf->SetXY($pdf->GetX()+$tab, $pdf->GetY()); $pdf->Cell(0,0,$br4a,0,1,'L');
                      $pdf->SetXY($pdf->GetX(),$b+4);
                      $pdf->SetXY($pdf->GetX()+140,  $pdf->GetY()); $pdf->Cell(0,0,$br4b,0,1,'L');
        $pdf->Ln(6);  $pdf->SetXY($pdf->GetX()+150,  $pdf->GetY()); $pdf->Cell(0,0,$br5,0,1,'L');
        
        //$pdf->Ln(5);  //$pdf->SetLineWidth(0.2);
        //$pdf->Line(1,$pdf->GetY(),260,$pdf->GetY());
        //$pdf->Ln(1);  //$pdf->SetLineWidth(0.6);
        //$pdf->Line(1,$pdf->GetY(),260,$pdf->GetY());
        if($br6 != ''){
          $pdf->Ln(10);  $pdf->SetXY($pdf->GetX()+$tab, $pdf->GetY()); $pdf->MultiCell(0,6,$br6,0,'J',0,15);
        }
        if($br6a != ''){
          $pdf->Ln(10);  $pdf->SetXY($pdf->GetX()+$tab, $pdf->GetY()); $pdf->MultiCell(0,6,$br6a,0,'J',0,15);
        }
        
        //Mencetak judul dengan tinggi bervariasi
        $pdf->SetFont('times','',12);
        $jd1 = 'NO';
        $jd2 = 'URAIAN IDENTITAS PEMOHON';
        $jd3 = 'SIFAT PERMOHONAN';
        $jd4 = ' NO PENDAFTARAN '.' TANGGAL DAFTAR ';
        $judul = array($jd1,$jd2,$jd3,$jd4);
        //$l_col = array(10,90,75,55); 
        $l_col = array(10,90,60,50); 
        $align = array('C','C','C','C');
        $hit_judul = count($judul);
        
        $pdf->Ln(5);
        $space = 5;
        $nb=0;
        $pdf->SetXY($pdf->GetX()+$tab, $pdf->GetY());
        
        // Mencetak judul dengan tinggi bervariasi
        for($i=0;$i<count($judul);$i++){
          $nb=max($nb,$pdf->NbLines($l_col[$i],$judul[$i]));
        }
        $h=$space*$nb;
        //Issue a page break first if needed
        $pdf->CheckPageBreak($h);
        //Draw the cells of the row
        for($i=0;$i<count($judul);$i++) {
          $w=$l_col[$i];
          $a=isset($align[$i]) ? $align[$i] : 'L';
          //Save the current position
          $x=$pdf->GetX();
          $y=$pdf->GetY();
          //Draw the border
          
          $pdf->Rect($x,$y,$w,$h);
          //Print the text
          
          $pdf->MultiCell($w,$space,$judul[$i],0,$a);
          //Put the position to the right of the cell
          $pdf->SetXY($x+$w,$y);
        }
        $pdf->Ln($h);
        //EOF(Mencetak judul dengan tinggi bervariasi)
        
        //Cetak Isi Tabel ke pdf
        $no = 0;
        $sts_notiv = FALSE;
        for($ai=0; $ai<$syarat_len; $ai++){
          $permohonan = new tmpermohonan();
          if($alur)
            $permohonan = $permohonan->get_by_id($syarat);
          else
            $permohonan = $permohonan->get_by_id($syarat[$ai]);
          $perizinan = $permohonan->trperizinan->get();
          $sektor = $permohonan->trperizinan->trsektor->get();
          $pemohon = $permohonan->tmpemohon->get();
          $perusahaan = $permohonan->tmperusahaan->get();
          $sk = $permohonan->tmsk->get();
          $permohonan_id = $permohonan->id;
          $online = '';
          if($permohonan->kd_gerai == 'OnLine') $online = $permohonan->kd_gerai;
          
          // Menyimpan nomor dan tanggal permohonan Sartek
          if($save_nomor) {
            //update ke tmpermohonan
            $permohonan->no_per_pertek = $no_urut_pertek;
            $permohonan->tg_per_pertek = $tg_per_pertek;
            if($kali == 1){
              $permohonan->save();
            }
          }
          
          //simpan ke tabel tmsurat_keluar
          $surat_keluar = new tmsurat_keluar();
          $surat_keluar = $surat_keluar->where('tmpermohonan_id', $permohonan_id)->where('no_surat', $no_urut_pertek)->get();
          			
          if(!$surat_keluar->tmpermohonan_id){ //jika tidak ditemukan
            $sts_notiv = TRUE;
            $surat_keluar = new tmsurat_keluar();
            $surat_keluar->tmpermohonan_id = $permohonan_id;
            $surat_keluar->tmsk_id = '';     // beri nilai kosong utk permohonan pertimbangan teknis
            $surat_keluar->user_id = $username->id;
            $surat_keluar->no_pertek_awal = $sektor->no_pertek_awal.' / ';
            $surat_keluar->no_surat = $no_urut_pertek;
            $surat_keluar->no_pertek_akhir = ' / '.$sektor->no_pertek_akhir;
            $surat_keluar->tgl_surat = $tg_per_pertek;
            $surat_keluar->perihal = 'Pertimbangan Teknis';
            $surat_keluar->keterangan = 'Pembuatan Surat';
            $surat_keluar->approve = 1;   // surat permohonan pertek siap di approve esl 4
          }
          $surat_keluar->kepada = $br3c;
          if($kali == 1){
            $surat_keluar->save();
          }  
          // EOF() Menyimpan nomor dan tanggal permohonan Sartek
        
          //NEW BARCODE
          $font = new BCGFontFile('./www/libraries/font/Arial.ttf', 10);
          $text = isset($_GET['text']) ? $_GET['text'] : $permohonan->pendaftaran_id;
          // The arguments are R, G, B for color.
          $color_black = new BCGColor(0, 0, 0);
          $color_white = new BCGColor(255, 255, 255);
          $drawException = null;
          try{
            $code = new BCGcode128();
            $code->setScale(2); // Resolution
            $code->setThickness(30); // Thickness
            $code->setForegroundColor($color_black); // Color of bars
            $code->setBackgroundColor($color_white); // Color of spaces
            $code->setFont(0); // $font or 0
            $code->parse($text); // Text
          }catch(Exception $exception) {
            $drawException = $exception;
          }
          /* Here is the list of the arguments
          1 - Filename (empty : display on screen)
          2 - Background color */
          ///$drawing = new BCGDrawing('', $color_white);
          $drawing = new BCGDrawing('assets/barcode/' . $syarat[$ai] . '.png', $color_white);
          if($drawException) {
            $drawing->drawException($drawException);
          }else{
            $drawing->setBarcode($code);
            $drawing->draw();
          }
          //$drawing->setFilename('barcode.png');
          ///header('Content-Type: image/png');
          ///header('Content-Disposition: inline; filename="barcode.png"');
          // Draw (or save) the image into PNG format.
          $drawing->finish(BCGDrawing::IMG_FORMAT_PNG);
          $b_code = base_url(). 'assets/barcode/' . $syarat[$ai] . '.png';
          //EOF() NEW BARCODE
          
          $no++;
          $n_perusahaan = $perusahaan->n_perusahaan;
          $a_perusahaan = $perusahaan->a_perusahaan;
          $o_izin = $permohonan->a_izin;
          if(!$a_perusahaan) $a_perusahaan = $pemohon->a_pemohon;
          if(!$n_perusahaan){
            $n_perusahaan = $pemohon->n_pemohon;
            $a_perusahaan = $pemohon->a_pemohon;
          }
          if(!$o_izin)
            $o_izin = '';
          else
            $o_izin = '. Objek Izin : '.$o_izin;
          
          $no_daftar = $permohonan->pendaftaran_id;
          $isi = array($no.'.',
                       $n_perusahaan.' Alamat: '.$a_perusahaan.$o_izin,
                       $perizinan->n_perizinan,
                       $no_daftar .'  '.'                                                   '. $this->lib_date->mysql_to_human($permohonan->d_terima_berkas),
          	          ); // + 15 space
          
          $align = array('R','L','L','L');
          $space = 5;
          $nb=0;
          
          $pdf->SetXY($pdf->GetX()+$tab, $pdf->GetY());
          // Create box
          for($i=0;$i<count($isi);$i++)
            $nb=max($nb,$pdf->NbLines($l_col[$i],$isi[$i]));
          $h=$space*$nb;
          //Issue a page break first if needed
          $pdf->CheckPageBreak($h);    //$h
          
          //Inisialisasi ulang halaman baru
          if($pdf->GetY()+$h >= 390){ //400,333
          	// Logo BSrE
            $pdf->Image($logo_bsre,10,385,225);        // Cetak Logo BSRE
            // EOF() BSrE
            $pdf->AddPage('P',array($Hpaper,$Wpaper)); // Ganti halaman dapat 74
            $pdf->SetMargins(0,0,0);                   //$pdf->SetMargins(kiri,atas,kanan);
            //$pdf->SetAutoPageBreak('ON', 63);
            $pdf->SetTopMargin($brs);
            $pdf->SetLeftMargin(10);
            $pdf->SetRightMargin(10);
            $pdf->SetFont('times','',12);
            $pdf->SetY($brs);
            $pdf->SetXY($pdf->GetX()+$tab, $pdf->GetY());
          }
          
          //Draw the cells of the row
          for($i=0; $i<count($isi); $i++) {
            $w=$l_col[$i];
            $a=isset($align[$i]) ? $align[$i] : 'L';
            //Save the current position
            $x=$pdf->GetX();
            $y=$pdf->GetY();
            //Draw the border
            $pdf->Rect($x,$y,$w,$h);
            //Print the text
            $pdf->MultiCell($w,$space,$isi[$i],0,$a);
            if($i==0){
              $ypos_bc = $pdf->GetY();
              $pdf->Image($b_code,$x+$l_col[0]+$l_col[1]+$l_col[2]+2,$ypos_bc,25);
              //$pdf->MultiCell($pdf->GetX(),5,$online.'       ',0,$a);   // Untuk cetak jika ada Online
              $pdf->MultiCell(0,5,$online.'   ',0,$a);   // Untuk cetak jika ada Online
            }
            //Put the position to the right of the cell
            $pdf->SetXY($x+$w,$y);
          }
          // EOF() Cetak Full
          
          //Go to the next line
          $pdf->Ln($h);
          unlink('assets/barcode/' . $syarat[$ai] . '.png');
        }
        // EOF(Cetak Isi Tabel ke pdf)
        
        // Mengirim Notifikasi ke TIM TEKNIS
        if($sts_notiv && $kali == 2){ // Jika TRUE kirim notivikasi ke tim teknis
          require("assets/plugins/phpmailer/class.phpmailer.php");
          require("assets/plugins/phpmailer/class.smtp.php");
        
          $query = "SELECT A.user_id, B.no_hp, B.email FROM trperizinan_user as A 
                    INNER JOIN user B ON B.id = A.user_id 
                    WHERE A.trperizinan_id = '" . $perizinan->id . "'
                    AND B.sektor <> 0";
          $results = mysql_query($query);
          while ($rows = mysql_fetch_assoc(@$results)){
            ///// KIRIM E-MAIL
            $email = $rows['email'];
            $telp_pemohon = $rows['no_hp'];
            $this->settings->where('name', 'send_mail')->get();
            if($this->settings->status == 1){
              $host             = "smtp.gmail.com";
              $emailpengirim    = "dpmptsptasikmalaya@gmail.com";
              $namapengirim     = "DPMPTSP tasikmalaya";
              $password         = "~dpmptsptasikmalayakabgoid#";
              $targetpengiriman = $email;
              $mailer = new PHPMailer();
              $mailer->CharSet = "UTF-8";
              $mailer->IsSMTP();
              $mailer->SMTPSecure = 'tls';
              $mailer->Host =$host;
              $mailer->Port =587;
              $mailer->SMTPAuth = true;
              $mailer->Username = $emailpengirim;
              $mailer->Password = $password;
              $mailer->FromName = $namapengirim;
              $mailer->From = $emailpengirim;
              $mailer->AddAddress($targetpengiriman,$targetpengiriman);
              $mailer->Subject = 'Surat Permohonan Pertimbangan Teknis';
              $isi  = "<p>Terdapat Surat Permohonan Pertimbangan Teknis Nomor : ".$br1a."</p>";
              $isi .= "<p> Tanggal : ".$this->lib_date->mysql_to_human($tg_per_pertek)."</p>";
              $isi .= "<p> Sebanyak : ".$no." Permohonan </p>";
              $isi .= "<p>Terima kasih atas perhatiannya<br>DPMPTSP PROVINSI TASIKMALAYA</p>";
              $mailer->Body = $isi;
              $mailer->AltBody = $isi;
              $mailer->Send();
            }
            ///// EOF() KIRIM E-MAIL
            
            ///// KIRIM SMS
            $this->settings->where('name', 'smsGateway')->get();
            if($this->settings->status == 1){
              $n_pesan = 'Srt permohonan Pertek No: '.$br1a.' Tgl: '.$tg_per_pertek.' Jmlah: '.$no.' Permohonan';
              $gammu = $this->load->database('gammu', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
              $data  = array('DestinationNumber' => $telp_pemohon,'TextDecoded' => "DPMPTSP Prov tasikmalaya \n". $n_pesan);
              $gammu->insert('outbox',$data);
            }
            ///// EOF() KIRIM SMS
          }
        }
        // EOF() Mengirim Notifikasi ke TIM TEKNIS
        
        $pdf->SetAutoPageBreak('ON', 50);
        $pdf->SetFont('times','',16);
        if($br7 != ''){
          $pdf->Ln(5); $pdf->SetXY($pdf->GetX()+$tab, $pdf->GetY()); $pdf->MultiCell(0,6,$br7,0,'J',0,15);
        }
        if($br8 != ''){
          $pdf->Ln(5); $pdf->SetXY($pdf->GetX()+$tab, $pdf->GetY()); $pdf->MultiCell(0,6,$br8,0,'J',0,15);
        }
            
        //ttd
        if($pdf->GetY() > 313){ // nilai sesuaikan dengan coba tampilan diatas
          $pdf->AddPage('P',array($Hpaper,$Wpaper)); // Ganti halaman dapat 74
          $pdf->SetMargins(0,0,0);                   //$pdf->SetMargins(kiri,atas,kanan);
          $pdf->SetTopMargin($brs);
          $pdf->SetLeftMargin(10);
          $pdf->SetRightMargin(10);
          //$pdf->SetY($brs);
          //$pdf->Ln($tinggikop);
        }
        		
        $pdf->Ln(5);  $pdf->SetXY($pdf->GetX()+$tab, $pdf->GetY()); $pdf->MultiCell(0,6,$spc.$br9,0,'J');
        $pdf->Ln(15); $pdf->Cell(75); $pdf->Cell(0,0,$br11,0,1,'C');
        $pdf->Ln(6);  $pdf->Cell(75); $pdf->Cell(0,0,$br11a,0,1,'C');
        $pdf->Ln(6);  $pdf->Cell(75); $pdf->Cell(0,0,$br12,0,1,'C');
        $pdf->Ln(6);  $pdf->Cell(75); $pdf->Cell(0,0,$br13,0,1,'C');
        $a = $pdf->GetY();
        if($kali == 1){
        	if($nm_cap != '') 
            // $pdf->Image($cap_dinas,110,$pdf->GetX()+$a-15,50);  // Cap Dinas Perizinan
          // $pdf->Image($ttd,150,$pdf->GetX()+$a-15,50);             // tttd elektronik
          $pdf->Image($ttd, 145, $pdf->GetY() + 2, 50);

        }  
        $pdf->Ln(6);  $pdf->Cell(75); $pdf->Cell(0,0,$br17,0,1,'C');
        $pdf->Ln(6);  $pdf->Cell(75); $pdf->Cell(0,0,$br17,0,1,'C');
        $pdf->Ln(6);  $pdf->Cell(75); $pdf->Cell(0,0,$br17,0,1,'C');
        $pdf->Ln(6);  $pdf->Cell(75); $pdf->Cell(0,0,$br17,0,1,'C');
        $pdf->Ln(6);  $pdf->Cell(75); $pdf->Cell(0,0,$br17,0,1,'C');
        $a = $pdf->GetY();
        if($kali == 1){
          $pdf->Image($b_code_no_pertek,11,$a+6,35);        // Cetak QRCode
        }  
        
        
        $pdf->Ln(30); $pdf->Cell(75); $pdf->Cell(0,0,$br14,0,1,'C'); 
        $pdf->Ln(6);  $pdf->Cell(75); $pdf->Cell(0,0,$br15,0,1,'C');
        $pdf->Ln(6);  $pdf->Cell(75); $pdf->Cell(0,0,$br16,0,1,'C');
        $pdf->SetFont('times','',10);
        $pdf->Ln(2);
        if($kali == 1){
          $pdf->Cell(0,0,'PT_'.$cod_bar_ctk,0,1,'L');
        }  
        
        //tembusan
        $pdf->SetFont('times','',12);
        $pdf->Ln(20); $pdf->Cell(0,0,$br17,0,1,'L');
        $pdf->Ln(5);  $pdf->Cell(0,0,$br18,0,1,'L');
        $pdf->Ln(5);  $pdf->Cell(0,0,$br19,0,1,'L');
        // EOF() ttd
        
        // Logo BSrE
        if($kali == 1){
          $pdf->Image($logo_bsre,10,385,225);        // Cetak Logo BSRE
        }
        // EOF() BSrE
        
        // Download dan menampilkan
        if($kali == 1){
          $n_file='PT_'. $cod_bar_thn.'.pdf';
        }else{
          $n_file='PTDRAFT_'. $cod_bar_thn.'.pdf';
        }
        //$pdf->Output($n_file,'D');
        $pdf->Output('assets/file_mohon_sartek/'.$n_file,'F');
      } 
      redirect('pendataan/index_next');
    }
  }
  
  public function Create_WaterMark($tg_pertek, $no_upertek) {
    $i_urut = strlen($no_upertek);
    $bcno_urut_pertek = $no_upertek;
    for($i = 5; $i > $i_urut; $i--) {
      $bcno_urut_pertek = "0" . $bcno_urut_pertek;
    }
$file = 'PT_' . $bcno_urut_pertek . $tg_pertek . '.pdf';
$file_draft = 'PTDRAFT_' . $bcno_urut_pertek . $tg_pertek . '.pdf';

$lok_fileDr = 'assets/file_mohon_sartek/';
$lok_fileWm = 'assets/file_mohon_sartekWM/';
$lok_fileSE = 'assets/file_mohon_sartekSE/';

$folders = [$lok_fileDr, $lok_fileWm, $lok_fileSE];

foreach ($folders as $folder) {
    if (!is_dir($folder)) {
        if (!mkdir($folder, 0775, true)) {
            die("❌ Gagal membuat folder: $folder. Cek permission server!");
        }
    }
}
    $this->load->helper('download');
    if(file_exists($lok_fileDr.$file_draft)){        // cek PDF Draft
      if(file_exists($lok_fileSE.$file)){        // cek PDF SE
    		$data = file_get_contents($lok_fileSE.$file);
        force_download($file, $data);
    	}else{	
        if(file_exists($lok_fileWm.$file)){        // cek PDF WaterMark	
          $data = file_get_contents($lok_fileWm.$file);
          force_download($file, $data);
        }else{
          //Create pdf watermark
          $this->load->library('cfpdf');
          $this->load->library('cfpdi');
          $pdf = new FPDI();
          $filename  = 'assets/file_mohon_sartek/'.$file_draft;   //Lokasi File Tanpa WaterMark
          $filenameW = 'assets/file_mohon_sartekWM/'.$file; //Lokasi File WaterMark
          try{
            $pageCount = $pdf->setSourceFile($filename);
            for($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
              $templateId = $pdf->importPage($pageNo);
              $size = $pdf->getTemplateSize($templateId);
              $Wpaper = 262;
              $Hpaper = 450;
              $pdf->AddPage('P',array($Hpaper,$Wpaper));
              $img = base_url().'uploads/logo/watermark.png';
              $pdf->Image($img,10,50,243,350);
              $pdf->useTemplate($templateId);
            }
            $pdf->Output($filenameW,'F');
          }
          catch (Exception $e) {
            var_dump($e);die;
          }
          //EOFCreate pdf watermark
          $data = file_get_contents($lok_fileWm.$file);
          force_download($file, $data);
        }  
      }
    }else{
    	echo 'File '.$file.' Tidak Didokumentasikan (Sebelum penggunaan e-Sign)';
    }
  }    

  public function del_no_pertek($alur=NULL, $tg_pertek = NULL, $no_upertek = NULL) {
    $username = new user();
    $username->where('username', $this->session->userdata('username'))->get();
    $tg_pertek = $this->lib_date->ambil_tahun($tg_pertek);
    if($alur) { // jika langsung cetak (bukan multi) cetak satu
      if($no_upertek){
        $alur = NULL;
        $query = mysql_query("SELECT id FROM tmpermohonan WHERE no_per_pertek = '$no_upertek' AND tg_per_pertek LIKE '%$tg_pertek%'"); 
        $syarat = ' ';
        $syarat_len = mysql_num_rows($query);
        while ($rows = mysql_fetch_assoc(@$query)) $syarat .= $rows['id'].';';
        $syarat = explode(";",str_replace(' ','',$syarat));
      }else{
        $syarat = $alur;
        $syarat_len = 1;
      }
    }else{
      $syarat = $this->input->post('pilih_cetak');
      $syarat_len = count($syarat); //hitung jumlah array
    }
    
    // hapus no dan tgl pertek
    $no = 0;
    for($ai=0; $ai<$syarat_len; $ai++){
      $permohonan = new tmpermohonan();
      $permohonan = $permohonan->get_by_id($syarat[$ai]);
      $no_per_pertek_lama = $permohonan->no_per_pertek;
      // Hapus dengan Menyimpan nomor dan tanggal permohonan Sartek menjadi NULL
      $permohonan->no_per_pertek = "";
      $permohonan->tg_per_pertek = '0000-00-00 00:00:00';
      $permohonan->save();
      
      //update ke tabel tmsurat_keluar
      $surat_keluar = new tmsurat_keluar();
      $surat_keluar = $surat_keluar->where('tmpermohonan_id', $syarat[$ai])->where('no_surat', $no_per_pertek_lama)->get();
      $surat_keluar->user_id = $username->id;
      $surat_keluar->keterangan = 'Penghapusan Nomor Surat';
      $surat_keluar->approve = 0;
      $surat_keluar->save();
      // EOF() Menyimpan nomor dan tanggal permohonan Sartek
    }
    //menyimpan no surat yang di batalkan
    $year = new year();
    $year = $year->where('tahun', $tg_pertek)->get();
    $year->no_urut_pertek_c = $year->no_urut_pertek_c . $no_per_pertek_lama . ';';
    $year->save();
    //EOF() menyimpan no surat yang di batalkan
    // EOF(hapus no dan tgl pertek)
    redirect('pendataan/index_next');
  }

  public function sql($u_ser) {
    $query = "select a.description
              from user_auth as a
              inner join user_user_auth as  x on a.id = x.user_auth_id
              inner join user as b on b.id = x.user_id
              where b.id = (select id from user where username='".$u_ser."')";
    $hasil = $this->db->query($query);
    return $hasil->row();
  }

  public function main_sql($u_ser,$query_filter,$tglb,$lokasi_user,$group) {
    if($this->All){ // utk Admin
      $query = "SELECT distinct A.id, A.pendaftaran_id, A.id_lama, A.d_terima_berkas, A.a_izin, A.kd_status, A.d_selesai_proses, A.d_perubahan,
                A.d_perpanjangan, A.d_daftarulang, B.trperizinan_id, C.kd_izin, A.keterangan, A.status_berkas, A.no_per_pertek, A.tg_per_pertek,
                C.id idizin, C.n_perizinan, C.bid_teknis, C.indeks, E.n_pemohon, E.a_pemohon, D.tmpermohonan_id, E.no_referensi,
                G.id idjenis, G.n_permohonan, A.kd_gerai, A.dt_teknis1
                FROM tmpermohonan as A
                INNER JOIN tmpermohonan_trperizinan as B ON B.tmpermohonan_id = A.id
                INNER JOIN trperizinan as C ON B.trperizinan_id = C.id
                INNER JOIN tmpemohon_tmpermohonan as D ON D.tmpermohonan_id = A.id
                INNER JOIN tmpemohon as E ON D.tmpemohon_id = E.id
                INNER JOIN tmpermohonan_trjenis_permohonan as F ON F.tmpermohonan_id = A.id
                INNER JOIN trjenis_permohonan as G ON F.trjenis_permohonan_id = G.id
                WHERE A.c_pendaftaran = 1".$query_filter."order by A.id DESC";
    }else{
      if($group == "4"){ // utk Evaluator
        $query = "SELECT distinct A.id, A.pendaftaran_id, A.id_lama, A.d_terima_berkas, A.a_izin, A.kd_status, A.d_selesai_proses, A.d_perubahan,
                  A.d_perpanjangan, A.d_daftarulang, B.trperizinan_id, C.kd_izin, A.keterangan, A.status_berkas, A.no_per_pertek, A.tg_per_pertek,
                  C.id idizin, C.n_perizinan, C.bid_teknis, C.indeks, E.n_pemohon, E.a_pemohon, D.tmpermohonan_id, E.no_referensi,
                  G.id idjenis, G.n_permohonan, A.kd_gerai, A.dt_teknis1
                  FROM tmpermohonan as A
                  INNER JOIN tmpermohonan_trperizinan as B ON B.tmpermohonan_id = A.id
                  INNER JOIN trperizinan as C ON B.trperizinan_id = C.id
                  INNER JOIN tmpemohon_tmpermohonan as D ON D.tmpermohonan_id = A.id
                  INNER JOIN tmpemohon as E ON D.tmpemohon_id = E.id
                  INNER JOIN tmpermohonan_trjenis_permohonan as F ON F.tmpermohonan_id = A.id
                  INNER JOIN trjenis_permohonan as G ON F.trjenis_permohonan_id = G.id
                  INNER JOIN trperizinan_user AS H ON  H.trperizinan_id = C.id
                  WHERE A.c_pendaftaran = 1
                  AND A.status_berkas = 'Izin Disetujui'
                  AND A.c_izin_dicabut = 0
                  AND A.c_izin_selesai = 0
                  AND H.user_id = '".$u_ser."'".$query_filter."order by A.id DESC";
      }else{
        if ($lokasi_user === 'Pusat') { // Untuk daerah lain
        //if($lokasi_user === 'DPMPTSP Prov. tasikmalaya' || $lokasi_user === 'BPMPT Prov. tasikmalaya' || $lokasi_user === 'BPPT Prov. tasikmalaya') {
          $query = "SELECT distinct A.id, A.pendaftaran_id, A.id_lama, A.d_terima_berkas, A.a_izin, A.kd_status, A.d_selesai_proses, A.d_perubahan,
                    A.d_perpanjangan, A.d_daftarulang, B.trperizinan_id, C.kd_izin, A.keterangan, A.status_berkas, A.no_per_pertek, A.tg_per_pertek,
                    C.id idizin, C.n_perizinan, C.bid_teknis, C.indeks, E.n_pemohon, E.a_pemohon, D.tmpermohonan_id, E.no_referensi,
                    G.id idjenis, G.n_permohonan, A.kd_gerai, A.dt_teknis1
                    FROM tmpermohonan as A
                    INNER JOIN tmpermohonan_trperizinan as B ON B.tmpermohonan_id = A.id
                    INNER JOIN trperizinan as C ON B.trperizinan_id = C.id
                    INNER JOIN tmpemohon_tmpermohonan as D ON D.tmpermohonan_id = A.id
                    INNER JOIN tmpemohon as E ON D.tmpemohon_id = E.id
                    INNER JOIN tmpermohonan_trjenis_permohonan as F ON F.tmpermohonan_id = A.id
                    INNER JOIN trjenis_permohonan as G ON F.trjenis_permohonan_id = G.id
                    INNER JOIN trperizinan_user AS H ON  H.trperizinan_id = C.id
                    WHERE A.c_pendaftaran = 1
                    AND A.status_berkas = 'proses'
                    AND A.c_izin_dicabut = 0
                    AND A.c_izin_selesai = 0
                    AND H.user_id = '".$u_ser."'".$query_filter."order by A.id DESC";
        }else{
          $query = "SELECT distinct A.id, A.pendaftaran_id, A.id_lama, A.d_terima_berkas, A.a_izin, A.kd_status, A.d_selesai_proses, A.d_perubahan,
                    A.d_perpanjangan, A.d_daftarulang, B.trperizinan_id, C.kd_izin, A.keterangan, A.status_berkas, A.no_per_pertek, A.tg_per_pertek,
                    C.id idizin, C.n_perizinan, C.bid_teknis, C.indeks, E.n_pemohon, E.a_pemohon, D.tmpermohonan_id, E.no_referensi,
                    G.id idjenis, G.n_permohonan, A.kd_gerai, A.dt_teknis1
                    FROM tmpermohonan as A
                    INNER JOIN tmpermohonan_trperizinan as B ON B.tmpermohonan_id = A.id
                    INNER JOIN trperizinan as C ON B.trperizinan_id = C.id
                    INNER JOIN tmpemohon_tmpermohonan as D ON D.tmpermohonan_id = A.id
                    INNER JOIN tmpemohon as E ON D.tmpemohon_id = E.id
                    INNER JOIN tmpermohonan_trjenis_permohonan as F ON F.tmpermohonan_id = A.id
                    INNER JOIN trjenis_permohonan as G ON F.trjenis_permohonan_id = G.id
                    INNER JOIN trperizinan_user AS H ON  H.trperizinan_id = C.id
                    WHERE A.c_pendaftaran = 1
                    AND A.status_berkas = 'proses'
                    AND A.c_izin_dicabut = 0
                    AND A.c_izin_selesai = 0
                    AND H.user_id = '".$u_ser."'".$query_filter."AND A.kd_gerai =  '$lokasi_user'
                    order by A.id DESC";
        }
      }
    }
    return $query;
  }
}