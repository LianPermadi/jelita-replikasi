<?php
/*
 * To change this template, choose Tools | Templates and open the template in the editor.
 * Description of pendaftaran
 * @author Eva Edited PBS 2019
 */

class Pencabutan extends WRC_AdminCont {

	  public function __construct() {
	    parent::__construct();
	    $this->permohonan = new tmpermohonan();
	    $this->perizinan = new trperizinan();
	    $this->pemohon = new tmpemohon();
	    $this->perizinanproperty = new trperizinan_trproperty();
	    $this->jenispermohonan = new trjenis_permohonan();
	    $this->perusahaan = new tmperusahaan();
	    $this->propertyjenis = new tmproperty_jenisperizinan();
	    
	    $username = new user();
	    $username->where('username', $this->session->userdata('username'))->get();
			$this->group = $username->group;
	    $list_auths = $this->session_info['app_list_auth'];
	    $enabled = FALSE;
	    $this->revisi = FALSE;
			$this->All = FALSE;

	    foreach ($list_auths as $list_auth) {
	      if($this->group === '3') {          //Struktural
	        $enabled = TRUE;
	        $this->revisi = TRUE;
	      }
			  if ($list_auth->id_role === '18') { //Administrator
			  	$enabled = TRUE;
	        $this->All = TRUE;
	      }
	    }

	    if(!$enabled) {
	      redirect('dashboard');
	    }
	  }

	  public function index() {
	  	//$kd_filter = $this->input->post('kd_filter');
	    //$lokasi_user = $this->session->userdata('lokasi');
	    $tgla = $this->input->post('tgla');
	    $tglb = $this->input->post('tglb');
	    $now = $this->lib_date->get_datetime_now();
	    $tgl_before = $this->lib_date->set_date($now, -7);
	    $tgl_now = $this->lib_date->set_date($now, 0);
	    $no_daftar = $this->input->post('kt_cari');

	    $data['kt_cari'] = $no_daftar;

	    if ($tgla && $tglb) {
	      $data['tgla'] = $tgla;
	      $data['tglb'] = $tglb;
	    } else {
	      $tgla = $tgl_before;
	      $tglb = $tgl_now;
	      $data['tgla'] = $tgla;
	      $data['tglb'] = $tglb;
	    }
	    //$data['kd_filter'] = $kd_filter;

	    $username = new user();
	    $username->where('username', $this->session->userdata('username'))->get();
	    if ($this->All) { // Untuk Admin
	      $query = "SELECT A.id, A.pendaftaran_id, A.d_terima_berkas, A.c_status_bayar, A.d_perubahan, A.d_perpanjangan, A.d_daftarulang, A.kd_gerai,
	                C.id idizin, C.n_perizinan, C.c_keputusan,C.template_gub,C.template,A.status_berkas, E.n_pemohon, G.id idjenis, K.tgl_surat, K.no_surat, 
	                K.tgl_penetapan, K.c_cetak, M.trkelompok_perizinan_id, C.e_ttd
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
	                WHERE A.c_pendaftaran = 1
	                AND I.status_bap = 1
	                AND A.kd_status = 9";
	    }else{
	      if($this->revisi){ //Struktural
	        $query = "SELECT A.id, A.pendaftaran_id, A.d_terima_berkas, A.c_status_bayar, A.d_perubahan, A.d_perpanjangan, A.d_daftarulang, A.kd_gerai, C.id idizin, C.n_perizinan, C.c_keputusan,C.template_gub,C.template,A.status_berkas, E.n_pemohon, G.id idjenis, K.tgl_surat, K.tgl_surat_edit, K.no_surat, K.no_surat_edit, K.tgl_penetapan, K.c_cetak, M.trkelompok_perizinan_id, C.e_ttd
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
	                  WHERE A.c_pendaftaran = 1
	                  AND L.user_id = '".$username->id."'
	                  AND I.status_bap = 1
	                  AND A.kd_status = 9";
	      }
	    }

	    if (!empty($no_daftar)) {
	    	$query .= " AND A.pendaftaran_id LIKE '%".$no_daftar."%' order by A.id DESC";
	    }else{
	    	$query .= " AND A.d_terima_berkas between '$tgla' and '$tglb'";
	    	$query .= " order by A.id DESC";
	    }
	        
	    $data['list'] = $query;
	    $this->load->vars($data);
	    $property = new trproperty();
	    $lists = $property->get();

	    $str = NULL;
	    foreach ($lists as $list) {
	      $str .= "\nvar " . $list->short_name . " = " . "$('#" . $list->short_name . "').val();";
	    }
	    $str .= "\n";
	    $js =  "$(document).ready(function() {
	              oTable = $('#sk').dataTable({
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
	    $this->session_info['page_name'] = "Permohonan Pencabutan SK";
	    $this->template->build('pencabutan_list', $this->session_info);
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
	    
	    $jml_property = $this->lib_date->data_property($p_izin->id,'1');
	    
	    $online=0;

	    //Start Data Berkas Nirwan
	    $p_daftar = $this->permohonan->get_by_id($id_daftar);
	    $data['daftaronline'] = $p_daftar->kd_gerai;
	    $id_portal = $p_daftar->id_pemohon_portal;
	    $data['peronline'] = 0;
	    if ($p_daftar->kd_gerai === 'OnLine') {
	      $otherdb = $this->load->database('otherdb', TRUE);
	      $portal = $this->db->query("SELECT * FROM tmpemohon_portal where id = $id_portal")->row_array();
	      
	      if($portal['id_permohonan_portal']){
	        $online =1;
	        $permohonan_portal_trperizinan = $otherdb->get_where("tmpermohonan_portal",array("id"=>$portal['id_permohonan_portal']))->first_row();

	        $sql = "SELECT A.*, B.tmpermohonan_id, B.nomor_surat, B.tanggal_surat, B.masa_berlaku_surat FROM spekta_backoffice.trsyarat_perizinan A 
	          LEFT JOIN spekta_portal.tmpermohonan_trsyarat_perizinan B ON A.id = B.trsyarat_perizinan_id
	          WHERE A.id IN(select trsyarat_perizinan_id from trperizinan_trsyarat_perizinan where trperizinan_id=? and status='1')
	          GROUP BY A.id
	          ORDER BY (A.urutan * -1) DESC, A.status ASC, A.urutan = 0, A.urutan";

	        $persyaratan_portal = $this->db->query($sql, $permohonan_portal_trperizinan->id_perizinan)->result();
	        $username_portal = $otherdb->get_where("tm_pemohon",array("id"=>$portal['id_pemohon']))->first_row();
	        $data["persyaratan"] = $persyaratan_portal;
	        $data["id_portal"] = $portal['id_permohonan_portal'];
	        $data["username_portal"] = $username_portal->username;
	        $data['peronline'] = 1;
	        $data['online'] = 1;
	      }
	    }
	      
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
	    $this->session_info['page_name'] = "Entry Data Teknis Pencabutan";
	    $this->template->build('pencabutan_edit', $this->session_info);
	  }

	  }