<?php

/**
 * Description of Pendaftaran Selain Izin Baru
 *
 * @author agusnur
 * Created : 30 Okt 2010
 */
class Pendaftaran extends WRC_AdminCont {
    var $obj;
    /*
     * Variable for generating JSON.
     */
    var $iTotalRecords;
    var $iTotalDisplayRecords;

    /*
     * Variable that taken form input.
     */
    var $iDisplayStart;
    var $iDisplayLength;
    var $iSortingCols;
    var $sSearch;
    var $sEcho;

    public function __construct() {
        parent::__construct();
		$this->username = new user();
        $this->pendaftaran = new tmpermohonan();
        $this->perizinan = new trperizinan();
        $this->kelompok_izin = new trkelompok_perizinan();
        $this->jenispermohonan = new trjenis_permohonan();
        $this->propinsi = new trpropinsi();
        $this->kabupaten = new trkabupaten();
        $this->kecamatan = new trkecamatan();
        $this->kelurahan = new trkelurahan();
        $this->kegiatan = new trkegiatan();
        $this->investasi = new trinvestasi();
        $this->settings = new settings();

        $enabled = FALSE;
        $list_auths = $this->session_info['app_list_auth'];

        foreach ($list_auths as $list_auth) {
            if ($list_auth->id_role === '9') {
                $enabled = TRUE;
            }
        }

        if (!$enabled) {
            redirect('dashboard');
        }
    }

    /*
     * Function
     */

    function _funcwilayah() {
        $data['list_propinsi'] = $this->propinsi->order_by('n_propinsi', 'ASC')->get();
        $data['list_kabupaten'] = $this->kabupaten->order_by('n_kabupaten', 'ASC')->get();
        $data['list_kecamatan'] = $this->kecamatan->order_by('n_kecamatan', 'ASC')->get();
        $data['list_kelurahan'] = $this->kelurahan->order_by('n_kelurahan', 'ASC')->get();
        //Data Pendukung Perusahaan
        $data['list_kegiatan'] = $this->kegiatan->order_by('n_kegiatan', 'ASC')->get();
        $data['list_investasi'] = $this->investasi->order_by('n_investasi', 'ASC')->get();
        return $data;
    }

    public function daftar_izin() {
        $data['jenis_id'] = '';

        $this->load->vars($data);
        $this->load->view('daftar_izin_load', $data);
    }

    public function daftar_ulang_izin() {
        $data['jenis_id'] = '';

        $this->load->vars($data);
        $this->load->view('daftar_ulang_izin_load', $data);
    }

    public function daftar_izin2($jenis_id = NULL) {
        $data['jenis_id'] = $jenis_id;

        $this->load->vars($data);
        $this->load->view('daftar_izin_load2', $data);
    }

    public function daftar_ulang_izin2($jenis_id = NULL) {
        $data['jenis_id'] = $jenis_id;

        $this->load->vars($data);
        $this->load->view('daftar_ulang_izin_load2', $data);
    }

    public function index($id_jenis = NULL, $id_syarat = NULL) {
		$username = new user();
        $username->where('username', $this->session->userdata('username'))->get();
		if($id_jenis == 0){
	    	$id_jenis = $username->gvar1;
            $id_syarat = $username->gvar2;
		}else{
		    $this->lib_date->post_variable($username->id, $id_jenis, $id_syarat, '', '', '', '', '', '', '', '');   // post variable
		}

        $jenis_p = $this->jenispermohonan->get_by_id($id_jenis);
        $data['list'] = $this->pendaftaran
                        ->where('c_pendaftaran', 0)  //Pendaftaran Belum selesai
                        ->where('c_izin_selesai', 0) //SK Belum diserahkan
                        ->where('c_izin_dicabut', 0) //Permohonan tidak dicabut
                        ->where_related($jenis_p)->order_by('id', 'DESC')->get();
        $data['list_izin'] = $this->perizinan->order_by('id', 'ASC')->get();
        $data['jenis_izin_id'] = $this->perizinan->id;
        $data['id_jenis'] = $id_jenis;
        $data['ket_syarat'] = $id_syarat;
		$label_text = "";
		$page_name = "";
        switch (strval($id_jenis)) {
            case "2" :
                $label_text = "No Pendaftaran ";
			    $page_name = "Permohonan Perubahan Izin";
				break;
            case "3" :
                $label_text = "No Pendaftaran ";
			    $page_name = "Permohonan Perpanjangan Izin";
                break;
            case "4":
                $label_text = "No Surat Lama ";
			    $page_name = "Permohonan Daftar Ulang Izin";
                break;
        }
		$data['label_text'] = $label_text;
        $data['id_jenis'] = $id_jenis;
        $this->load->vars($data);

        $js = "
                function confirm_link(text){
                    if(confirm(text)){ return true;
                    }else{ return false; }
                }
                $(document).ready(function() {

                    $('a[rel*=pick_list]').facebox();
                    
                    function finishAjax(id, response){
                      $('#'+id).html(unescape(response));
                      $('#'+id).fadeIn();
                    }

                    oTable = $('#pendaftaran').dataTable({
                            \"bJQueryUI\": true,
                            \"sPaginationType\": \"full_numbers\"
                    });
                } );
                ";

        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = $page_name;
        $this->template->build('pendaftaran_list', $this->session_info);
    }

    /*
     * edit is a method to show page for updating data
     */

    public function create($id_jenis = NULL, $id = NULL) { // untuk Perubahan, Perpanjangan dan Daftar Ulang Izin
        
        $this->username->where('username', $this->session->userdata('username'))->get();
		$lokasi_user = $this->session->userdata('lokasi');

		$this->pendaftaran = new tmpermohonan();
//        $id_jenis = $this->input->post('id_jenis');
//        $u_daftar = $this->pendaftaran->get_by_id($this->input->post('no_daftar'));
        $u_daftar = $this->pendaftaran->get_by_id($id);

        $p_pemohon = $u_daftar->tmpemohon->get();
        $p_kelurahan = $p_pemohon->trkelurahan->get();
        $p_kecamatan = $p_pemohon->trkelurahan->trkecamatan->get();
        $p_kabupaten = $p_pemohon->trkelurahan->trkecamatan->trkabupaten->get();
        $p_propinsi = $p_pemohon->trkelurahan->trkecamatan->trkabupaten->trpropinsi->get();
        $u_perusahaan = $u_daftar->tmperusahaan->get();
        $u_kelurahan = $u_perusahaan->trkelurahan->get();
        $u_kecamatan = $u_perusahaan->trkelurahan->trkecamatan->get();
        $u_kabupaten = $u_perusahaan->trkelurahan->trkecamatan->trkabupaten->get();
        $u_propinsi = $u_perusahaan->trkelurahan->trkecamatan->trkabupaten->trpropinsi->get();
        $u_kegiatan = $u_daftar->tmperusahaan->trkegiatan->get();
        $u_investasi = $u_daftar->tmperusahaan->trinvestasi->get();
        $d_izin = $u_daftar->trperizinan->get();
        $d_sk = $u_daftar->tmsk->get();
		$jns_permohonan = $this->jenispermohonan->get_by_id($id_jenis);

        $data = $this->_funcwilayah();
        
        $jml = $this->get_jml_syarat($d_izin->id,'seri',$id_jenis);
        if (!empty($jml)) {
            $data['jml_syarat'] = $jml->jml;
        } else {
            $data['jml_syarat'] = "";
        }
                
        $data['save_method'] = "save";
        $data['id_jenis'] = $id_jenis;
        $data['id_daftar'] = $u_daftar->id;
        $data['id_link'] = '';
        $data['tgl_daftar_baru'] = '';
        $data['tglsurvey']=$u_daftar->d_selesai_proses;
        $data['tglambil_izin']=$u_daftar->d_ambil_izin;
        $paralel_jenis = new trparalel();
        $data['jenis_paralel'] = $paralel_jenis->get_by_id($u_daftar->c_paralel);
        $data['no_refer'] = $p_pemohon->no_referensi;
        $data['cmbsource'] = $p_pemohon->source;
        $data['nama_pemohon'] = $p_pemohon->n_pemohon;
        $data['no_telp'] = $p_pemohon->telp_pemohon;
        $data['check_ctr'] = $p_pemohon->cek_prop;
        $data['propinsi_pemohon'] = $p_propinsi->id;
        $data['kabupaten_pemohon'] = $p_kabupaten->id;
        $data['kecamatan_pemohon'] = $p_kecamatan->id;
        $data['kelurahan_pemohon'] = $p_kelurahan->id;
        $data['tgl_daftar'] = date("Y-m-d"); //$u_daftar->d_terima_berkas;
        $data['tgl_survey'] = $u_daftar->d_survey;
        $data['lokasi_izin'] = $u_daftar->a_izin;
        $data['keterangan'] = $u_daftar->keterangan;
		$data['cmbgerai'] = $u_daftar->kd_gerai;
		$data['kd_kontak'] = $u_daftar->kontak_person;
        $data['alamat_pemohon'] = $p_pemohon->a_pemohon;
        $data['alamat_pemohon_luar'] = $p_pemohon->a_pemohon_luar;
        $data['nama_perusahaan'] = $u_perusahaan->n_perusahaan;
        $data['npwp'] = $u_perusahaan->npwp;
        $data['telp_perusahaan'] = $u_perusahaan->i_telp_perusahaan;
        $data['alamat_usaha'] = $u_perusahaan->a_perusahaan;
        $data['propinsi_usaha'] = $u_propinsi->id;
        $data['kabupaten_usaha'] = $u_kabupaten->id;
        $data['kecamatan_usaha'] = $u_kecamatan->id;
        $data['kelurahan_usaha'] = $u_kelurahan->id;
        $data['jenis_kegiatan'] = $u_kegiatan->id;
        $data['jenis_investasi'] = $u_investasi->id;
        $data['jenis_izin'] = $this->perizinan->get_by_id($d_izin->id);
        $data['jenis_permohonan'] = $this->jenispermohonan->get_by_id($id_jenis);
		$data['waktu_awal'] = $this->lib_date->get_date_now();

        $syarat_perizinan = new trsyarat_perizinan();
        $data['syarat_izin'] = $syarat_perizinan->where_related($this->perizinan)->order_by('status', 'asc')->get();
        $data['list_daftar'] = $u_daftar;
        $data['no_pendaftaran'] = $u_daftar->pendaftaran_id;
		$data['lokasi_user'] = $lokasi_user;
        $data['no_sk'] = $d_sk->no_surat;
        $data['no_pendaftaran_baru'] = '';
		$data['no_antri'] = "";
		$data['nodaftar'] = $u_perusahaan->no_reg_perusahaan;
		$data['fax'] = $u_perusahaan->fax;
        $data['email'] = $u_perusahaan->email;

		//cek Online pajak
        $this->settings->where('name', 'app_web_service')->get();
        $statusOnline = $this->settings->status;
        $data['statusOnline'] = $statusOnline;

        $js = "
                $(document).ready(function() {
                    $('#form').validate();
                    $(\"#tabs\").tabs();
                } );

                $(function() {
                    $(\"#inputTanggal1\").datepicker({
                        changeMonth: true,
                        changeYear: true,
                        dateFormat: 'yy-mm-dd',
                        closeText: 'X'
                    });
                    $(\"#inputTanggal2\").datepicker({
                        changeMonth: true,
                        changeYear: true,
                        dateFormat: 'yy-mm-dd',
                        closeText: 'X'
                    });
					$(\"#inputTanggal3\").datepicker({
                        changeMonth: true,
                        changeYear: true,
                        dateFormat: 'yy-mm-dd',
                        closeText: 'X'
                    });
                });
				
				$(document).ready(function() {
                    $('#form').validate();
                    $(\"#tabs\").tabs();
                    $('a[rel*=pemohon_box]').facebox();
                    $('a[rel*=daftar_box]').facebox();
                    $('a[rel*=perusahaan_box]').facebox();
                } );
				
                $(document).ready(function() {
                    $('#propinsi_pemohon_id').change(function(){
                        $.post('".base_url()."pendaftaran/kabupaten_pemohon', { propinsi_id: $('#propinsi_pemohon_id').val() },
                               function(data) {
                                   $('#show_kabupaten_pemohon').html(data);
                                   $('#show_kecamatan_pemohon').html('Data Tidak tersedia');
                                   $('#show_kelurahan_pemohon').html('Data Tidak tersedia');
                               }
						);
                    }); 
                });


                $(document).ready(function() {
                    $('#propinsi_usaha_id').change(function(){
                        $.post('".base_url()."pendaftaran/kabupaten_usaha', { propinsi_id: $('#propinsi_usaha_id').val() },
                                function(data) {
                                    $('#show_kabupaten_usaha').html(data);
                                    $('#show_kecamatan_usaha').html('Data Tidak tersedia');
                                    $('#show_kelurahan_usaha').html('Data Tidak tersedia');
                                }
						);
                    });
                });

                function finishAjax(id, response){
                    $('#'+id).html(unescape(response));
                    $('#'+id).fadeIn();
                }

                function Check(){
                    if(document.form.Check_ctr.checked == true){
                        document.form.propinsi_pemohon.disabled = false ;
                        document.form.kabupaten_pemohon.disabled = false ;
                        document.form.kecamatan_pemohon.disabled = false ;
                        document.form.kelurahan_pemohon.disabled = false ;
                    }else{
                        document.form.propinsi_pemohon.disabled = true ;
                        document.form.kabupaten_pemohon.disabled = true ;
                        document.form.kecamatan_pemohon.disabled = true ;
                        document.form.kelurahan_pemohon.disabled = true ;
                    }
                }
        ";

        /*if ($id_jenis == 2){
            $page_name = "Entry Data Permohonan Perubahan Izin";
        }else{ 
			if ($id_jenis == 3){
                $page_name = "Entry Data Permohonan Perpanjangan Izin";
            }else{ 
				if ($id_jenis == 4){
                    $page_name = "Entry Data Permohonan Daftar Ulang Izin";
                }else{
                    $page_name = "";
				}
			}
        }
		*/
		$page_name = "Edit Permohonan Untuk " . $jns_permohonan->n_permohonan;
        $this->template->set_metadata_javascript($js);

        $this->load->vars($data);
        $this->session_info['page_name'] = $page_name;
        $this->template->build('pendaftaran_edit', $this->session_info); 
    }

    function get_perizinan_baru($id,$jenis,$id_jenis){
        if ($jenis == 'paralel'){
            $sql = "SELECT c_show_type FROM trperizinan_trsyarat_perizinan WHERE trperizinan_id IN ($id)";
        }else{
            $sql = "SELECT c_show_type FROM trperizinan_trsyarat_perizinan WHERE trperizinan_id = '$id'";
        }
        $hasil = $this->db->query($sql);
        $result = $hasil->result();
        $arr = array();
        foreach ($result as $row){
            $var = $row->c_show_type;
            //$rule = strval(decbin($var));
            //if(strlen($rule) < 4) {
            //    $len = 4 - strlen($rule);
            //    $rule = str_repeat("0",$len) . $rule;
            //}
            //$arr_rule = str_split($rule);

			$rule = strval(decbin($var));
			if($row->status_new == 1) $plv = 6; else $plv = 4; // penambahan pencabutan dan penutupan ditambah 00
            if (strlen($rule) < $plv) {
                $len = $plv - strlen($rule);
                $rule = str_repeat("0", $len) . $rule;
            }
            if($plv == 4) $rule = $rule.'00';                         // penambahan pencabutan dan penutupan ditambah 00
			$arr_rule = str_split($rule);
                            
            if($id_jenis == 2){
                if($arr_rule[3] == '1'){
                    $arr[] = $var;
                }
            }else{
				if($id_jenis == 3){
                    if($arr_rule[2] == '1'){
                        $arr[] = $var;
                    }
                }else{
					if($id_jenis == 4){
                        if($arr_rule[1] == '1'){
                            $arr[] = $var;
                        }
                    }
                }
		    }  
        }
        return $arr;
    }
    
    function get_jml_syarat($id,$jenis,$id_jenis){
        if ($id == NULL){
            redirect('pendaftaran/index/2');
        }else{
            $dum = $this->get_perizinan_baru($id,$jenis,$id_jenis);
            if ($jenis == 'paralel'){
                $query = "SELECT COUNT(*) as jml FROM trperizinan_trsyarat_perizinan
                          INNER JOIN trsyarat_perizinan ON trsyarat_perizinan.id = trperizinan_trsyarat_perizinan.trsyarat_perizinan_id
                          INNER JOIN trperizinan ON trperizinan.id = trperizinan_trsyarat_perizinan.trperizinan_id
                          WHERE trsyarat_perizinan.`status` = '1' 
						        and trperizinan.id IN ($id) 
								and c_show_type IN ('".implode("','", $dum)."')";
            }else{ 
                $query = "SELECT COUNT(*) as jml FROM trperizinan_trsyarat_perizinan
                          INNER JOIN trsyarat_perizinan ON trsyarat_perizinan.id = trperizinan_trsyarat_perizinan.trsyarat_perizinan_id
                          INNER JOIN trperizinan ON trperizinan.id = trperizinan_trsyarat_perizinan.trperizinan_id
                          WHERE trsyarat_perizinan.`status` = '1' 
						        and trperizinan.id = ".$id." 
								and c_show_type IN ('".implode("','", $dum)."')
                          GROUP BY n_perizinan";
            }
            $hasil = $this->db->query($query);
            return $hasil->row();
        }
    }

    /* edit is a method to show page for updating data */
    public function edit($id_jenis = NULL, $no_daftar = NULL, $id_link = NULL) {
		$this->username->where('username', $this->session->userdata('username'))->get();
		$lokasi_user = $this->session->userdata('lokasi');

        $u_daftar = $this->pendaftaran->get_by_id($no_daftar);
        $p_pemohon = $u_daftar->tmpemohon->get();
        $p_kelurahan = $p_pemohon->trkelurahan->get();
        $p_kecamatan = $p_pemohon->trkelurahan->trkecamatan->get();
        $p_kabupaten = $p_pemohon->trkelurahan->trkecamatan->trkabupaten->get();
        $p_propinsi = $p_pemohon->trkelurahan->trkecamatan->trkabupaten->trpropinsi->get();
        $u_perusahaan = $u_daftar->tmperusahaan->get();
        $u_kelurahan = $u_perusahaan->trkelurahan->get();
        $u_kecamatan = $u_perusahaan->trkelurahan->trkecamatan->get();
        $u_kabupaten = $u_perusahaan->trkelurahan->trkecamatan->trkabupaten->get();
        $u_propinsi = $u_perusahaan->trkelurahan->trkecamatan->trkabupaten->trpropinsi->get();
        $u_kegiatan = $u_daftar->tmperusahaan->trkegiatan->get();
        $u_investasi = $u_daftar->tmperusahaan->trinvestasi->get();
        $d_izin = $u_daftar->trperizinan->get();
		$jns_permohonan = $this->jenispermohonan->get_by_id($id_jenis);

        $data = $this->_funcwilayah();
        
        $jml = $this->get_jml_syarat($d_izin->id,'seri',$id_jenis);
        if(!empty($jml)) {
            $data['jml_syarat'] = $jml->jml;
        }else{
            $data['jml_syarat'] = "";
        }
        
        $data['save_method'] = "update";
        $data['id_jenis'] = $id_jenis;
        $data['list_daftar'] = $u_daftar;
        $data['id_daftar'] = $u_daftar->id;
        $data['id_link'] = $id_link;

        if ($id_jenis == 2){
            $tgl_daftar_baru = $u_daftar->d_perubahan;            //2 -> Perubahan Izin
        }else{ 
			if ($id_jenis == 3){
                $tgl_daftar_baru = $u_daftar->d_perpanjangan;     //3 -> Perpanjangan Izin
            }else{ 
				if ($id_jenis == 4){
                    $tgl_daftar_baru = $u_daftar->d_daftarulang;  //4 -> Daftar Ulang
				}
			}
		}
        
        $data['tgl_daftar_baru'] = $tgl_daftar_baru;
		$data['tglsurvey']=$u_daftar->d_selesai_proses;
		$data['tglambil_izin']=$u_daftar->d_ambil_izin;
        $paralel_jenis = new trparalel();
        $data['jenis_paralel'] = $paralel_jenis->get_by_id($u_daftar->c_paralel);
        $data['no_refer'] = $p_pemohon->no_referensi;
        $data['cmbsource'] = $p_pemohon->source;
        $data['nama_pemohon'] = $p_pemohon->n_pemohon;
        $data['no_telp'] = $p_pemohon->telp_pemohon;
        $data['check_ctr'] = $p_pemohon->cek_prop;
        $data['propinsi_pemohon'] = $p_propinsi->id;
        $data['kabupaten_pemohon'] = $p_kabupaten->id;
        $data['kecamatan_pemohon'] = $p_kecamatan->id;
        $data['kelurahan_pemohon'] = $p_kelurahan->id;
        $data['tgl_daftar'] = $u_daftar->d_terima_berkas;
        $data['tgl_survey'] = $u_daftar->d_survey;
        $data['lokasi_izin'] = $u_daftar->a_izin;
        $data['keterangan'] = $u_daftar->keterangan;
		$data['cmbgerai'] = $u_daftar->kd_gerai;
		$data['kd_kontak'] = $u_daftar->kontak_person;
        $data['alamat_pemohon'] = $p_pemohon->a_pemohon;
        $data['alamat_pemohon_luar'] = $p_pemohon->a_pemohon_luar;
        $data['nama_perusahaan'] = $u_perusahaan->n_perusahaan;
        $data['npwp'] = $u_perusahaan->npwp;
        $data['telp_perusahaan'] = $u_perusahaan->i_telp_perusahaan;
        $data['alamat_usaha'] = $u_perusahaan->a_perusahaan;
        $data['propinsi_usaha'] = $u_propinsi->id;
        $data['kabupaten_usaha'] = $u_kabupaten->id;
        $data['kecamatan_usaha'] = $u_kecamatan->id;
        $data['kelurahan_usaha'] = $u_kelurahan->id;
        $data['jenis_kegiatan'] = $u_kegiatan->id;
        $data['jenis_investasi'] = $u_investasi->id;
        $data['jenis_izin'] = $this->perizinan->get_by_id($d_izin->id);
        $data['jenis_permohonan'] = $this->jenispermohonan->get_by_id($id_jenis);
        $data['lokasi_user'] = $lokasi_user;
		$data['waktu_awal'] = $this->lib_date->get_date_now();
		$data['no_antri'] = $u_daftar->no_antri;
		$data['nodaftar'] = $u_perusahaan->no_reg_perusahaan;
		$data['fax'] = $u_perusahaan->fax;
        $data['email'] = $u_perusahaan->email;

        //cek Online pajak
        $this->settings->where('name', 'app_web_service')->get();
        $statusOnline = $this->settings->status;
        $data['statusOnline'] = $statusOnline;

        $syarat_perizinan = new trsyarat_perizinan();
        $data['syarat_izin'] = $syarat_perizinan->where_related($this->perizinan)->order_by('status', 'asc')->get();
        $data['no_pendaftaran_baru'] = $u_daftar->pendaftaran_id;
        $daftar_lama = new tmpermohonan();
        if ($u_daftar->id_lama) {
            $daftar_lama->get_by_id($u_daftar->id_lama);
            $data['no_pendaftaran'] = $daftar_lama->pendaftaran_id;
            $d_sk = $daftar_lama->tmsk->get();
            $data['no_sk'] = $d_sk->no_surat;
        } else {
            $data['no_pendaftaran'] = '-';
            $data['no_sk'] = '-';
        }

        $js = "
                $(document).ready(function() {
                    $('#form').validate();
                    $(\"#tabs\").tabs();
                } );

                $(function() {
                    $(\"#inputTanggal_\").datepicker({
                        changeMonth: true,
                        changeYear: true,
                        dateFormat: 'yy-mm-dd',
                        closeText: 'X'
                    });
                    $(\"#inputTanggal1\").datepicker({
                        changeMonth: true,
                        changeYear: true,
                        dateFormat: 'yy-mm-dd',
                        closeText: 'X'
                    });
                    $(\"#inputTanggal2\").datepicker({
                        changeMonth: true,
                        changeYear: true,
                        dateFormat: 'yy-mm-dd',
                        closeText: 'X'
                    });
					$(\"#inputTanggal3\").datepicker({
                        changeMonth: true,
                        changeYear: true,
                        dateFormat: 'yy-mm-dd',
                        closeText: 'X'
                    });
                });

                $(document).ready(function() {
                    $('#propinsi_pemohon_id').change(function(){
                        $.post('".base_url()."pelayanan/pendaftaran/kabupaten_pemohon', { propinsi_id: $('#propinsi_pemohon_id').val() },
                            function(data) {
                                $('#show_kabupaten_pemohon').html(data);
                                $('#show_kecamatan_pemohon').html('Data Tidak tersedia');
                                $('#show_kelurahan_pemohon').html('Data Tidak tersedia');
                            }
						);
                    }); 
                });

                $(document).ready(function() {
                    $('#propinsi_usaha_id').change(function(){
                        $.post('".base_url()."pelayanan/pendaftaran/kabupaten_usaha', { propinsi_id: $('#propinsi_usaha_id').val() },
                            function(data) {
                                $('#show_kabupaten_usaha').html(data);
                                $('#show_kecamatan_usaha').html('Data Tidak tersedia');
                                $('#show_kelurahan_usaha').html('Data Tidak tersedia');
                            }
						);
                    });
                });

                function finishAjax(id, response){
                  $('#'+id).html(unescape(response));
                  $('#'+id).fadeIn();
                }

                function Check(){
                    if(document.form.Check_ctr.checked == true){
                        document.form.propinsi_pemohon.disabled = false ;
                        document.form.kabupaten_pemohon.disabled = false ;
                        document.form.kecamatan_pemohon.disabled = false ;
                        document.form.kelurahan_pemohon.disabled = false ;
                    }else{
                        document.form.propinsi_pemohon.disabled = true ;
                        document.form.kabupaten_pemohon.disabled = true ;
                        document.form.kecamatan_pemohon.disabled = true ;
                        document.form.kelurahan_pemohon.disabled = true ;
                    }
                }
            ";

        /*if ($id_jenis == 2){
            $page_name = "Edit Permohonan Perubahan Izin";
        }else{ 
			if ($id_jenis == 3){
                $page_name = "Edit Permohonan Perpanjangan Izin";
            }else{ 
				if ($id_jenis == 4){
                    $page_name = "Edit Permohonan Daftar Ulang Izin";
                }else{
                    $page_name = "";
				}
			}
		}
		*/
		$page_name = "Edit Permohonan Untuk " . $jns_permohonan->n_permohonan;
       
        $this->template->set_metadata_javascript($js);
        $this->load->vars($data);
        $this->session_info['page_name'] = $page_name;
        $this->template->build('pendaftaran_edit', $this->session_info);
    }

    /* Save and update for manipulating data. */
    public function save() {
        $id_jenis = $this->input->post('jenis_permohonan_id');
        $perizinan = new trperizinan();
        $perizinan->get_by_id($this->input->post('jenis_izin_id'));
        $perizinan_sektor = new trperizinan_trsektor();
		$perizinan_sektor->where('trperizinan_id', $this->input->post('jenis_izin_id'))->get();
        $kd_sektor = $perizinan_sektor->trsektor_id;

        $jenis_permohonan = new trjenis_permohonan();
        $jenis_permohonan->get_by_id($id_jenis);

        /* Cek Persyaratan Izin */
        $syarat_perizinan = new trsyarat_perizinan();
        $izin_len = $syarat_perizinan->where_related($perizinan)->where('status', 1)->count();
        $syarat_izin = new trsyarat_perizinan();
        $list_syarat = $syarat_izin->where_related($perizinan)->where('status', 1)->get();

        $syarat = $this->input->post('pemohon_syarat');
        $syarat_len = count($syarat);

        $izin_len = 0;
        $wajib_len = 0;
        foreach ($list_syarat as $data) {
            $show_syarat = new trperizinan_syarat();
            $show_syarat->where('trsyarat_perizinan_id', $data->id)
                        ->where('trperizinan_id', $perizinan->id)->get();
            $var = $show_syarat->c_show_type;

            //$rule = strval(decbin($var));
            //if (strlen($rule) < 4) {
            //    $len = 4 - strlen($rule);
            //    $rule = str_repeat("0", $len) . $rule;
            //}
            //$arr_rule = str_split($rule);
            //$c_daftar_ulang = $arr_rule[0];
            //$c_baru = $arr_rule[1];
            //$c_perpanjangan = $arr_rule[2];
            //$c_ubah = $arr_rule[3];
            
			$rule = strval(decbin($var));
			if($show_syarat->status_new == 1) $plv = 6; else $plv = 4; // penambahan pencabutan dan penutupan ditambah 00
            if (strlen($rule) < $plv) {
                $len = $plv - strlen($rule);
                $rule = str_repeat("0", $len) . $rule;
            }
            if($plv == 4) $rule = $rule.'00';                         // penambahan pencabutan dan penutupan ditambah 00
			$arr_rule = str_split($rule);
                            
			if($plv == 4){
			    $c_baru         = $arr_rule[1];
                $c_daftar_ulang = $arr_rule[0];
			}else{
		        $c_baru         = $arr_rule[0];
                $c_daftar_ulang = $arr_rule[1];
			}
            $c_perpanjangan = $arr_rule[2];
            $c_ubah         = $arr_rule[3];
            $c_pencabutan   = $arr_rule[4];
            $c_penutupan    = $arr_rule[5];

            if ($id_jenis == 2){
                $syarat_status = $c_ubah;
            }else{
				if ($id_jenis == 3){
                    $syarat_status = $c_perpanjangan;
                }else{
                    $syarat_status = $c_baru;
				}
			}
            if ($syarat_status == '1') {
                $izin_len++;
                $is_array = NULL;
                for ($i = 0; $i < $syarat_len; $i++) {
                    if ($is_array !== $syarat[$i]) {
                        if ($show_syarat->trsyarat_perizinan_id == $syarat[$i])
                            $wajib_len++;
                    }
                    $is_array = $syarat[$i];
                }
            }
        }
        if ($izin_len !== $wajib_len)
            redirect('pendaftaran/index/' . $id_jenis . '/1');

        /* Penomoran Pendaftaran 
         * Awal ORI
         */
/*        $data_id = new tmpermohonan();

        $data_id->select_max('id')->get();
        $data_id->get_by_id($data_id->id);

        $data_tahun = date("Y");
        //Per Tahun Auto Restart NoUrut
        if ($data_id->d_tahun === $data_tahun)
            $data_urut = $data_id->i_urut + 1;
        else
            $data_urut = 1;

        $i_urut = strlen($data_urut);
        for ($i = 5; $i > $i_urut; $i--) {
            $data_urut = "0" . $data_urut;
        }

        $data_izin = $perizinan->id;
        $i_izin = strlen($data_izin);
        for ($i = 3; $i > $i_izin; $i--) {
            $data_izin = "0" . $data_izin;
        }

        $data_jenis = $jenis_permohonan->id;
        $i_izin = strlen($data_jenis);
        for ($i = 2; $i > $i_izin; $i--) {
            $data_jenis = "0" . $data_jenis;
        }

        $data_bulan = date("n");
        $i_bulan = strlen($data_bulan);
        for ($i = 2; $i > $i_bulan; $i--) {
            $data_bulan = "0" . $data_bulan;
        }

        $data_lama = new tmpermohonan();
        $data_lama->get_by_id($this->input->post('id_daftar'));
        $permohonan = new tmpermohonan();
        $permohonan->i_urut = $data_urut;
        $permohonan->d_tahun = $data_tahun;
        $nomor_pendaftaran = $data_urut . 
                $data_izin . $data_jenis 
                . $data_bulan . $data_tahun;
*/

        /* Penomoran Pendaftaran
         * Awal
         */
        $data_id = new tmpermohonan();

        $data_id->select_max('id')->get();
        $data_id->get_by_id($data_id->id);

//        $data_tahun = date("Y");
		$data_tahun = substr($this->input->post('tgl_daftar'), 0, 4);
        //Per Tahun Auto Restart NoUrut
        if ($data_id->d_tahun === $data_tahun) {
            $data_urut = $data_id->i_urut + 1;
		    $year = new year();                            // PBS
			$year->where('tahun', $data_tahun);            // PBS
			$year->update('no_urut', $data_urut);          // PBS
        } else {
			$year = new year();                            // PBS
			$year->where('tahun', $data_tahun)->get();     // PBS
			$data_urut = $year->no_urut;
            if ($year->tahun === $data_tahun) {            // PBS
	    		$year = new year();                        // PBS
    			$year->where('tahun', $data_tahun);
                $data_urut++;                              // PBS
				$year->update('no_urut', $data_urut);      // PBS
			} else {
                $data_urut = 1;
                $year = new year();
                $year->tahun = $data_tahun;
				$year->no_urut = $data_urut;
                $year->save();
			}                                              // PBS
        }

        $i_urut = strlen($data_urut);
        for ($i = 5; $i > $i_urut; $i--) {
            $data_urut = "0" . $data_urut;
        }

        $data_izin = $perizinan->id;
        $i_izin = strlen($data_izin);
        for ($i = 3; $i > $i_izin; $i--) {
            $data_izin = "0" . $data_izin;
        }

        $data_jenis = $jenis_permohonan->id;
        $i_izin = strlen($data_jenis);
        for ($i = 2; $i > $i_izin; $i--) {
            $data_jenis = "0" . $data_jenis;
        }

		$data_bulan = substr($this->input->post('tgl_daftar'), 5, 2); // PBS
        $i_bulan = strlen($data_bulan);
        for ($i = 2; $i > $i_bulan; $i--) {
            $data_bulan = "0" . $data_bulan;
        }
        
		$username = new user();
        $username->where('username', $this->session->userdata('username'))->get();
        $user_id = $username->id;
        $u_id = strlen($user_id);
        for ($i = 3; $i > $u_id; $i--) {
            $user_id = "0" . $user_id;
        }

        $data_lama = new tmpermohonan();
        $data_lama->get_by_id($this->input->post('id_daftar'));
        $permohonan = new tmpermohonan();
        $permohonan->i_urut = $data_urut;
        $permohonan->d_tahun = $data_tahun;

        $app_folder = new settings();
        $app_folder->where('name', 'app_folder')->get();
        $app_folder = $app_folder->value;
		// menyusun nomor pendaftaran
        if ($app_folder === "Bantul") {   // untuk bantul
            $nomor_pendaftaran = $data_urut . "/" . $data_izin . "/" . $data_jenis . "/" . $data_bulan . "/" . $data_tahun;
        } else {
          //$nomor_pendaftaran = $data_urut . $data_izin . $data_jenis . $data_bulan . $data_tahun;
          //$data_urut : XXXXX ;$data_izin : XXX ;$data_jenis : XX ;$data_bulan : XX ;$data_tahun : XXXX ;$user_id : XXX;
            $nomor_pendaftaran = $data_urut . $data_izin . $data_jenis . $data_bulan . $data_tahun . $user_id;
        }

        $username = new user();
        $username->where('username', $this->session->userdata('username'))->get();
        if ($username->id) {
            $userid = $username->username;
		    $user = $username->realname;
        } else {
			$userid = "................................";
            $user = "................................";
		}

        $permohonan->i_entry = $user;

        $permohonan->pendaftaran_id = $nomor_pendaftaran;
        //$permohonan->d_terima_berkas = $this->input->post('tgl_daftar_baru');
		$permohonan->d_terima_berkas = $this->input->post('tgl_daftar');
		$permohonan->d_terima_berkas_asli = date('Y-m-d');
        $permohonan->d_survey = $this->input->post('tgl_survey');
        $permohonan->a_izin = $this->input->post('lokasi_izin');
        $permohonan->keterangan = $this->input->post('keterangan');
		$permohonan->kd_gerai = $this->input->post('cmbgerai');
		$permohonan->trsektor_id = $kd_sektor;
		$permohonan->no_antri = $this->input->post('no_antri');
		$permohonan->kontak_person = $this->input->post('kd_kontak');
        $permohonan->id_lama = $data_lama->id;

        if ($id_jenis == 2)
            $permohonan->d_perubahan = $this->input->post('tgl_daftar');      //tgl_daftar_baru ORI
        else if ($id_jenis == 3)
            $permohonan->d_perpanjangan = $this->input->post('tgl_daftar');   //tgl_daftar_baru ORI
        else if ($id_jenis == 4)
            $permohonan->d_daftarulang = $this->input->post('tgl_daftar');    //tgl_daftar_baru ORI

        $tgl_skr = $this->lib_date->get_date_now();
        $permohonan->d_entry = $tgl_skr;
		$permohonan->trsektor_id = $kd_sektor;

        $tgl_entry = $this->input->post('tgl_daftar');
        $vdurasi_cek = $this->lib_date->hit_durasi($tgl_entry, $perizinan->v_hari);           // Create PBS
		$permohonan->d_selesai_proses = $this->lib_date->set_date($tgl_entry, $vdurasi_cek);  // Create PBS
        //$permohonan->d_selesai_proses = $this->lib_date->set_date($tgl_skr, $perizinan->v_hari);

        $permohonan->save($perizinan);
        /* EOF() Penomoran Pendaftaran Awal */

        $permohonan_akhir = new tmpermohonan();
        $permohonan_akhir->select_max('id')->get();

        /* Input Data Pemohon */
        $pemohon = new tmpemohon();
//        $data_lama->tmpemohon->get();
//        $pemohon->get_by_id($data_lama->tmpemohon->id);
        $pemohon->no_referensi = $this->input->post('no_refer');
        $pemohon->source = $this->input->post('cmbsource');
        $pemohon->n_pemohon = $this->input->post('nama_pemohon');
        $pemohon->telp_pemohon = $this->input->post('no_telp');
        $pemohon->a_pemohon = $this->input->post('alamat_pemohon');
        $pemohon->a_pemohon_luar = $this->input->post('alamat_pemohon_luar');
        $kelurahan_p = new trkelurahan();
        if ($this->input->post('Check_ctr')) {
            $pemohon->cek_prop = "0";
            $kelurahan_p->get_by_id($this->input->post('kelurahan_pemohon'));
            $pemohon->save(array($permohonan_akhir, $kelurahan_p));
        } else {
            $pemohon->cek_prop = "1";
            $kelurahan_p->get_by_id($this->input->post('kelurahan_pemohon'));
            $pemohon->save(array($permohonan_akhir,$kelurahan_p));
        }

        /* Input Data Perusahaan */
        if ($this->input->post('nama_perusahaan')) {
            $perusahaan = new tmperusahaan();
//            $data_lama->tmperusahaan->get();
//            $perusahaan->get_by_id($data_lama->tmperusahaan->id);
            $perusahaan->n_perusahaan = $this->input->post('nama_perusahaan');
            $perusahaan->npwp = $this->input->post('npwp');
            $perusahaan->i_telp_perusahaan = $this->input->post('telp_perusahaan');
            $perusahaan->a_perusahaan = $this->input->post('alamat_usaha');
			$perusahaan->no_reg_perusahaan = $this->input->post('nodaftar');
            $perusahaan->fax = $this->input->post('fax');
            $perusahaan->email = $this->input->post('email');
            $kegiatan = new trkegiatan();
            $kegiatan->get_by_id($this->input->post('jenis_kegiatan'));
            $investasi = new trinvestasi();
            $investasi->get_by_id($this->input->post('jenis_investasi'));
            $kelurahan_u = new trkelurahan();
            $kelurahan_u->get_by_id($this->input->post('kelurahan_usaha'));
            
            $perusahaan->save(array($permohonan_akhir, $kelurahan_u,$kegiatan, $investasi));
        }

        /* Input Data Syarat Perizinan */
        //$syarat_pendaftaran = new tmpermohonan_trsyarat_perizinan();
        //$syarat_pendaftaran->where('tmpermohonan_id', $permohonan_akhir->id)->get();
        //$syarat_pendaftaran->delete();

		/* Hapus Data Syarat Perizinan Lama */
		$syarat_old = new tmpermohonan_trsyarat_perizinan();
        $list_syarat = $syarat_old->where('tmpermohonan_id', $permohonan_akhir->id)->get();
        foreach ($list_syarat as $row){
            $syarat_old->where('id', $row->id)->get();
    		if($row->tmpermohonan_id == $permohonan_akhir->id) {
                $syarat_old->delete();
		  	}
        }

        $syarat = $this->input->post('pemohon_syarat');
        $syarat_len = count($syarat);

        $is_array = NULL;
        for ($i = 0; $i < $syarat_len; $i++) {
            if ($is_array !== $syarat[$i]) {
                $syarat_daftar = new tmpermohonan_trsyarat_perizinan();
                $syarat_daftar->tmpermohonan_id = $permohonan_akhir->id;
                $syarat_daftar->trsyarat_perizinan_id = $syarat[$i];
                $syarat_daftar->save();
            }
            $is_array = $syarat[$i];
        }

        /* Input Data BAP */
        $data_id_bap = new tmbap();
        $data_id_bap->select_max('id')->get();
        $data_id_bap->get_by_id($data_id_bap->id);

        $data_tahun = date("Y");
        //Per Tahun Auto Restart NoUrut
        if ($permohonan_akhir->d_tahun === $data_tahun)
            $data_urut_bap = $data_id_bap->i_urut + 1;
        else
            $data_urut_bap = 1;

        $i_urut_bap = strlen($data_urut_bap);
        for ($i = 4; $i > $i_urut_bap; $i--) {
            $data_urut_bap = "0" . $data_urut_bap;
        }

        $data_izin = $perizinan->id;
        $i_izin = strlen($data_izin);
        for ($i = 3; $i > $i_izin; $i--) {
            $data_izin = "0" . $data_izin;
        }

        $data_bulan = $this->lib_date->set_month_roman(date("n"));

        $data_bap = "BAP";
        $no_bap = $data_urut_bap . "/"
                . $data_bap . "/" . $data_izin . "/"
                . $data_bulan . "/" . $data_tahun;
        $data_skrd = "SKRD";
        $no_skrd = $data_urut_bap . "/"
                . $data_skrd . "/" . $data_izin . "/"
                . $data_bulan . "/" . $data_tahun;

        $bap_lama = $data_lama->tmbap->get();
        $bap = new tmbap();
        $bap->pendaftaran_id = $nomor_pendaftaran;
        $bap->bap_id = $no_bap;
		$bap->tgl_bap = $this->lib_date->get_date_now();
        $bap->no_skrd = $no_skrd;
        $bap->i_urut = $data_urut_bap;
//        $bap->c_pesan = $bap_lama->c_pesan;
//        $bap->status_bap = $bap_lama->status_bap;
//        $bap->nilai_retribusi = $bap_lama->nilai_retribusi;
//        $bap->c_penetapan = $bap_lama->c_penetapan;
        $bap->save(array($permohonan_akhir));

        /* Input Data SK */
//        $data_id_sk = new tmsk();
//        $data_id_sk->select_max('id')->get();
//        $data_id_sk->get_by_id($data_id_sk->id);
//
//        $data_tahun = date("Y");
//        //Per Tahun Auto Restart NoUrut
//        if ($permohonan_akhir->d_tahun === $data_tahun)
//            $data_urut_sk = $data_id_sk->i_urut + 1;
//        else
//            $data_urut_sk = 1;
//
//        $i_urut_sk = strlen($data_urut_sk);
//        for ($i = 4; $i > $i_urut_sk; $i--) {
//            $data_urut_sk = "0" . $data_urut_sk;
//        }
//
//        $data_izin = $perizinan->id;
//        $i_izin = strlen($data_izin);
//        for ($i = 3; $i > $i_izin; $i--) {
//            $data_izin = "0" . $data_izin;
//        }
//
//        $data_bulan = $this->lib_date->set_month_roman(date("n"));
//
//        $data_sk = "DP";
//        $no_sk = $data_urut_sk . "/"
//                . $data_sk . "/" . $data_izin . "/"
//                . $data_bulan . "/" . $data_tahun;
//
//        $sk_lama = $data_lama->tmsk->get();
//        $sk = new tmsk();
//        $sk->no_surat = $no_sk;
//        $sk->tgl_surat = $this->lib_date->get_date_now();
//        $sk->i_urut = $data_urut_sk;
//
//        $permohonan_akhir->d_berlaku_izin = $this->lib_date->set_date($tgl_skr, $perizinan->v_berlaku_tahun * 365); //per tahun
//        $permohonan_akhir->save();
//        $pegawai = new tmpegawai();
//        $petugas = 1; //1 -> Jabatan Penandatangan
//        $pegawai->where('status', $petugas)->get();
//
//        $sk->save(array($permohonan_akhir, $pegawai));

        /* Input Data Tracking Progress saat di Front Office*/
        $tracking_izin = new tmtrackingperizinan();
        $tracking_izin->pendaftaran_id = $nomor_pendaftaran;
        $tracking_izin->status = 'Insert';
        $tracking_izin->d_entry_awal = $this->input->post('waktu_awal');
        $tracking_izin->d_entry = $this->lib_date->get_date_now();
		$tracking_izin->tr_user = $userid;
        $tracking_izin->tr_name = $user;
		$tracking_izin->tr_activiti = 'Front Office'; // hati-hati mengganti kata 'Front Office'
        $sts_izin = new trstspermohonan();
        $sts_izin->get_by_id('2');                    //Menerima dan Memeriksa Berkas [Lihat Tabel trstspermohonan()]
        $sts_izin->save($permohonan_akhir);
        $tracking_izin->save($sts_izin);
        $tracking_izin->save($permohonan_akhir);

        $permohonan_akhir->save($jenis_permohonan);

        $tgl = date("Y-m-d H:i:s");
        $u_ser = $this->session->userdata('username');
        $g = $this->sql($u_ser);
//        $jam = date("H:i:s A");
        $id_jenis= $this->input->post('id_jenis');
        if ($id_jenis=="2"){
            //$p = $this->db->query("call log ('Perubahan Izin','Perubahan Izin ".$data_lama->pendaftaran_id."','".$tgl."','".$u_ser."')");
        }else{
			if($id_jenis=="3"){
                //$p = $this->db->query("call log ('Perpanjangan Izin','Perpanjangan Izin ".$data_lama->pendaftaran_id."','".$tgl."','".$u_ser."')");
            }else{
                //$p = $this->db->query("call log ('Daftar Ulang','Daftar Ulang ".$data_lama->pendaftaran_id."','".$tgl."','".$u_ser."')");
            }
	    }
        redirect('pendaftaran/index/' . $id_jenis);
    }

    public function update() {
       
        $id_jenis = $this->input->post('jenis_permohonan_id');
        $permohonan = new tmpermohonan();
        $permohonan->get_by_id($this->input->post('id_daftar'));
        $permohonan->d_terima_berkas = $this->input->post('tgl_daftar');
        $permohonan->d_survey = $this->input->post('tgl_survey');
        $permohonan->a_izin = $this->input->post('lokasi_izin');
        $permohonan->keterangan = $this->input->post('keterangan');
		$permohonan->kd_gerai = $this->input->post('cmbgerai');
		$permohonan->kontak_person = $this->input->post('kd_kontak');
        if ($id_jenis == 2){
            $permohonan->d_perubahan = $this->input->post('tgl_daftar');
        }else{
			if ($id_jenis == 3){
                $permohonan->d_perpanjangan = $this->input->post('tgl_daftar');
            }else{
				if ($id_jenis == 4){
                    $permohonan->d_daftarulang = $this->input->post('tgl_daftar');
				}
			}
		}
        $permohonan->tmpemohon->get();
        $permohonan->tmperusahaan->get();
        $jenis = $permohonan->trjenis_permohonan->get();
        $id_jenis = $jenis->id;
		$no_pendaftaran = $permohonan->pendaftaran_id;

        /* Cek Persyaratan Izin */
        $perizinan = $permohonan->trperizinan->get();
        $syarat_perizinan = new trsyarat_perizinan();
        $izin_len = $syarat_perizinan->where_related($perizinan)->where('status', 1)->count();
        $syarat_izin = new trsyarat_perizinan();
        $list_syarat = $syarat_izin->where_related($perizinan)->where('status', 1)->get();

        $syarat = $this->input->post('pemohon_syarat');
        $syarat_len = count($syarat);

        $izin_len = 0;
        $wajib_len = 0;
        foreach ($list_syarat as $data) {
            $show_syarat = new trperizinan_syarat();
            $show_syarat->where('trsyarat_perizinan_id', $data->id)
                        ->where('trperizinan_id', $perizinan->id)->get();
            $var = $show_syarat->c_show_type;

            //$rule = strval(decbin($var));
            //if (strlen($rule) < 4) {
            //    $len = 4 - strlen($rule);
            //    $rule = str_repeat("0", $len) . $rule;
            //}
            //$arr_rule = str_split($rule);
            //$c_daftar_ulang = $arr_rule[0];
            //$c_baru = $arr_rule[1];
            //$c_perpanjangan = $arr_rule[2];
            //$c_ubah = $arr_rule[3];

            $rule = strval(decbin($var));
			if($show_syarat->status_new == 1) $plv = 6; else $plv = 4; // penambahan pencabutan dan penutupan ditambah 00
            if (strlen($rule) < $plv) {
                $len = $plv - strlen($rule);
                $rule = str_repeat("0", $len) . $rule;
            }
            if($plv == 4) $rule = $rule.'00';                         // penambahan pencabutan dan penutupan ditambah 00
			$arr_rule = str_split($rule);
                            
			if($plv == 4){
			    $c_baru         = $arr_rule[1];
                $c_daftar_ulang = $arr_rule[0];
			}else{
		        $c_baru         = $arr_rule[0];
                $c_daftar_ulang = $arr_rule[1];
			}
            $c_perpanjangan = $arr_rule[2];
            $c_ubah         = $arr_rule[3];
            $c_pencabutan   = $arr_rule[4];
            $c_penutupan    = $arr_rule[5];

            if ($id_jenis == 2){
                $syarat_status = $c_ubah;
            }else{
				if ($id_jenis == 3){
                    $syarat_status = $c_perpanjangan;
                }else{
                    $syarat_status = $c_baru;
				}
			}

            if ($syarat_status == '1') {
                $izin_len++;
                $is_array = NULL;
                for ($i = 0; $i < $syarat_len; $i++) {
                    if ($is_array !== $syarat[$i]) {
                        if ($show_syarat->trsyarat_perizinan_id == $syarat[$i])
                            $wajib_len++;
                    }
                    $is_array = $syarat[$i];
                }
            }
        }
        if ($izin_len !== $wajib_len)
            redirect('pendaftaran/index/' . $id_jenis . '/1');

        /* Input Data Pemohon */
        $pemohon = new tmpemohon();
        $pemohon->get_by_id($permohonan->tmpemohon->id);
        $pemohon->no_referensi = $this->input->post('no_refer');
        $pemohon->source = $this->input->post('cmbsource');
        $pemohon->n_pemohon = $this->input->post('nama_pemohon');
        $pemohon->telp_pemohon = $this->input->post('no_telp');
        $pemohon->a_pemohon = $this->input->post('alamat_pemohon');
        $pemohon->a_pemohon_luar = $this->input->post('alamat_pemohon_luar');
        $pemohon->trkelurahan->get();
        $pemohon_lurah = new tmpemohon_trkelurahan();
        $pemohon_lurah->where('tmpemohon_id', $permohonan->tmpemohon->id)->get();
        $pemohon_lurah->delete();
        $kelurahan_p = new trkelurahan();
        $kelurahan_p->get_by_id($this->input->post('kelurahan_pemohon'));
       
        if ($this->input->post('Check_ctr')) {
            $pemohon->cek_prop = "0";
            $pemohon->save(array($kelurahan_p));
        } else {
            $pemohon->cek_prop = "1";
            $pemohon->save(array($kelurahan_p));
        }

        /* Input Data Perusahaan */
        if ($permohonan->tmperusahaan->id) {
            $perusahaan = new tmperusahaan();
            $perusahaan->get_by_id($permohonan->tmperusahaan->id);
            $perusahaan->n_perusahaan = $this->input->post('nama_perusahaan');
            $perusahaan->npwp = $this->input->post('npwp');
            $perusahaan->i_telp_perusahaan = $this->input->post('telp_perusahaan');
            $perusahaan->a_perusahaan = $this->input->post('alamat_usaha');
            $perusahaan->trkelurahan->get();
            $perusahaan->save();
            $perusahaan_lurah = new tmperusahaan_trkelurahan();
            $perusahaan_lurah->where('tmperusahaan_id', $permohonan->tmperusahaan->id)
                             ->update(array('trkelurahan_id' => $this->input->post('kelurahan_usaha')));
            $perusahaan_kegiatan = new tmperusahaan_trkegiatan();
            $perusahaan_kegiatan->where('tmperusahaan_id', $this->input->post('id_perusahaan'))
                                ->update(array('trkegiatan_id' => $this->input->post('jenis_kegiatan')));
            $perusahaan_investasi = new tmperusahaan_trinvestasi();
            $perusahaan_investasi->where('tmperusahaan_id', $this->input->post('id_perusahaan'))
                                 ->update(array('trinvestasi_id' => $this->input->post('jenis_investasi')));
        } else {
            if ($this->input->post('nama_perusahaan')) {
                $perusahaan = new tmperusahaan();
                $perusahaan->n_perusahaan = $this->input->post('nama_perusahaan');
                $perusahaan->npwp = $this->input->post('npwp');
                $perusahaan->i_telp_perusahaan = $this->input->post('telp_perusahaan');
                $perusahaan->a_perusahaan = $this->input->post('alamat_usaha');
                $kelurahan_u = new trkelurahan();
                $kelurahan_u->get_by_id($this->input->post('kelurahan_usaha'));
                $kegiatan = new trkegiatan();
                $kegiatan->get_by_id($this->input->post('jenis_kegiatan'));
                $investasi = new trinvestasi();
                $investasi->get_by_id($this->input->post('jenis_investasi'));
                $perusahaan->save(array($permohonan, $kelurahan_u, $kegiatan, $investasi));
            }
        }

        /* Input Data Syarat Perizinan */
        $syarat_pendaftaran = new tmpermohonan_trsyarat_perizinan();
        $syarat_pendaftaran->where('tmpermohonan_id', $this->input->post('id_daftar'))->get();
        $syarat_pendaftaran->delete();

        $syarat = $this->input->post('pemohon_syarat');
        $syarat_len = count($syarat);

        $is_array = NULL;
        for ($i = 0; $i < $syarat_len; $i++) {
            if ($is_array !== $syarat[$i]) {
                $syarat_daftar = new tmpermohonan_trsyarat_perizinan();
                $syarat_daftar->tmpermohonan_id = $this->input->post('id_daftar');
                $syarat_daftar->trsyarat_perizinan_id = $syarat[$i];
                $syarat_daftar->save();
            }
            $is_array = $syarat[$i];
        }

        /* Input Data Tracking Progress */
		/*
        $status_izin = $permohonan->trstspermohonan->get();
        $status_skr = "2"; //Menerima dan Memeriksa Berkas [Lihat Tabel trstspermohonan()]
        if ($status_izin->id == $status_skr) {
            $sts_izin = new trstspermohonan();
            $sts_izin->get_by_id($status_skr);
            $data_status = new tmtrackingperizinan_trstspermohonan();
            $list_tracking = $permohonan->tmtrackingperizinan->get();
            if ($list_tracking) {
                $tracking_id = 0;
                foreach ($list_tracking as $data_track) {
                    $data_status = new tmtrackingperizinan_trstspermohonan();
                    $data_status->where('tmtrackingperizinan_id', $data_track->id)
                                ->where('trstspermohonan_id', $sts_izin->id)->get();
                    if ($data_status->tmtrackingperizinan_id) {
                        $tracking_id = $data_status->tmtrackingperizinan_id;
                    }
                }
            }
            $tracking_izin = new tmtrackingperizinan();
            $tracking_izin->get_by_id($tracking_id);
            $tracking_izin->status = 'Update';
            //$tracking_izin->d_entry = $this->lib_date->get_date_now();
            $tracking_izin->save();
        }
		*/
		$id_link = $this->input->post('id_link');
        $status_izin = $permohonan->trstspermohonan->get();
        if(!$id_link == '1') 
		    $status_skr = "2";                                         //Menerima dan Memeriksa Berkas [Lihat Tabel trstspermohonan()]
        else                                                        
		    $status_skr = "3";                                         //Edit di Pelayanan / Entri Data [Lihat Tabel trstspermohonan()]

        if($status_izin->id == $status_skr){
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
                    if ($data_status->tmtrackingperizinan_id) {
                        $tracking_id = $data_status->tmtrackingperizinan_id;
                    }
                }
            }
            $tracking_izin = new tmtrackingperizinan();
            $tracking_izin->get_by_id($tracking_id);
            //$tracking_izin->status = 'Update';
            //$tracking_izin->d_entry = $this->lib_date->get_date_now();
			// PBS merekam history yang pernah mengubah data 
			$hit_ubah = $tracking_izin->hit_ubah + 1;
   			$his_ubah = $tracking_izin->his_ubah;
    		$tracking_izin->hit_ubah = $hit_ubah;
			if($id_link == "Pengembalian"){
                $tracking_izin->his_ubah = $his_ubah.'Ditolak FO^'.$r_name.'^'.$this->lib_date->get_date_now().';';
				$tracking_izin->d_entry = $this->lib_date->get_date_now();
            }else{
                if(!$id_link == '1')
                    $tracking_izin->his_ubah = $his_ubah.'ADM^'.$r_name.'^'.$this->lib_date->get_date_now().';';
				else
				    $tracking_izin->his_ubah = $his_ubah.'PEL.EDIT^'.$r_name.'^'.$this->lib_date->get_date_now().';';
			}
            $tracking_izin->save();
        }else{                                                       //Edit di Pelayanan / Entri Data [Lihat Tabel trstspermohonan()]
			if($id_link == "Pengembalian"){
                $tr_activiti = 'Front Office';
				$n_sts = 'Ditolak FO';
			}else{
                $tr_activiti = 'Entry Data';
				$n_sts = 'PEL.EDIT';
            }    
			$tracking_izin = new tmtrackingperizinan();
            $tracking_izin->where('pendaftaran_id', $no_pendaftaran)
                          ->where('tr_activiti', $tr_activiti)->get();
	    	if($tracking_izin->pendaftaran_id){
				if($id_link == "Pengembalian") {
    				$tracking_izin->d_entry = $this->lib_date->get_date_now();
				}
                $hit_ubah = $tracking_izin->hit_ubah + 1;
   			    $his_ubah = $tracking_izin->his_ubah;
    	    	$tracking_izin->hit_ubah = $hit_ubah;
	    		$tracking_izin->his_ubah = $his_ubah.$n_sts.'^'.$r_name.'^'.$this->lib_date->get_date_now().';';
    			$tracking_izin->save();
            }
		}
		/* EOF() Input Data Tracking Progress */
		
        $update = $permohonan->save();
        if ($update) {
            $tgl = date("Y-m-d H:i:s");
            $u_ser = $this->session->userdata('username');
            $g = $this->sql($u_ser);
            $id_jenis= $this->input->post('id_jenis');
            if($id_jenis=="2"){
                //$p = $this->db->query("call log ('Perubahan Izin','Edit Perubahan Izin ".$permohonan->pendaftaran_id."','".$tgl."','".$u_ser."')");
            }else{
			    if($id_jenis=="3"){
                    //$p = $this->db->query("call log ('Perpanjangan Izin','Edit Perpanjangan Izin ".$permohonan->pendaftaran_id."','".$tgl."','".$u_ser."')");
                }else{
                    //$p = $this->db->query("call log ('Daftar Ulang','Edit Daftar Ulang ".$permohonan->pendaftaran_id."','".$tgl."','".$u_ser."')");
			    }
            }
            $id_link = $this->input->post('id_link');
            if ($id_link == '1')
                redirect('pendataan');
            else
                redirect('pendaftaran/index/' . $id_jenis);
        }
    }

    public function selesai($id_daftar = NULL) {
		/* OLD
        $permohonan = new tmpermohonan();
        $permohonan->get_by_id($id_daftar);
        $permohonan->c_pendaftaran = 1;
        $jenis = $permohonan->trjenis_permohonan->get();
        $id_jenis = $jenis->id;

        $sts_izin = new trstspermohonan();
        $sts_izin->get_by_id('2'); //Menerima dan Memeriksa Berkas [Lihat Tabel trstspermohonan()]
        $data_status = new tmtrackingperizinan_trstspermohonan();
        $list_tracking = $permohonan->tmtrackingperizinan->get();
        if ($list_tracking) {
            $tracking_id = 0;
            foreach ($list_tracking as $data_track) {
                $data_status = new tmtrackingperizinan_trstspermohonan();
                $data_status->where('tmtrackingperizinan_id', $data_track->id)
                        ->where('trstspermohonan_id', $sts_izin->id)->get();
                if ($data_status->tmtrackingperizinan_id) {
                    $tracking_id = $data_status->tmtrackingperizinan_id;
                }
            }
        }
        $tracking_izin = new tmtrackingperizinan();
        $tracking_izin->get_by_id($tracking_id);
        //$tracking_izin->pendaftaran_id = $permohonan->pendaftaran_id;
        $tracking_izin->status = 'Update';
        $tracking_izin->d_entry = $this->lib_date->get_date_now();
        $tracking_izin->save();
//      $tracking_izin->save($sts_izin);
//      $tracking_izin->save($permohonan);
        //Entri Data Tracking
        $tracking_izin2 = new tmtrackingperizinan();
        $tracking_izin2->pendaftaran_id = $permohonan->pendaftaran_id;
        $tracking_izin2->status = 'Insert';
        $tracking_izin2->d_entry_awal = $this->lib_date->get_date_now();
        $tracking_izin2->d_entry = $this->lib_date->get_date_now();
        $sts_izin2 = new trstspermohonan();
        $sts_izin2->get_by_id('3'); //Entry Data [Lihat Tabel trstspermohonan()]
        $sts_izin2->save($permohonan);
        $tracking_izin2->save($permohonan);
        $tracking_izin2->save($sts_izin2);
        $permohonan->save();
        */

		$u_ser = $this->session->userdata('username');
		$r_name = $this->lib_date->get_nama_ori($u_ser);

        $permohonan = new tmpermohonan();
        $permohonan->get_by_id($id_daftar);
        $permohonan->c_pendaftaran = 1;
		$no_pendaftaran = $permohonan->pendaftaran_id;
		$id_lama = $permohonan->id_lama;

		/* Ambil isi properti lama */
        $permohonan_old = new tmpermohonan();
        $permohonan_old->get_by_id($id_lama);
		/* EOF() Ambil isi properti lama */

		/* Simpan property lama ke property baru */
        for ($vi = 1; $vi <= 100; $vi++) {
			$nm_file = 'dt_teknis'.$vi;
			$permohonan->$nm_file = $permohonan_old->$nm_file;
        }
		/* EOF() Simpan property lama ke property baru */

        $tracking_izin = new tmtrackingperizinan();
        $tracking_izin->where('pendaftaran_id', $no_pendaftaran)
                      ->where('tr_activiti', 'Kirim Ke Pelayanan')->get();
        if($tracking_izin->pendaftaran_id){
            $tracking_izin->status = 'Update';
            $tracking_izin->d_entry = $this->lib_date->get_date_now();
	    	$tracking_izin->tr_user = $u_ser;
		    $tracking_izin->tr_name = $r_name;
    		$tracking_izin->tr_activiti = 'Kirim Ke Pelayanan';
            $tracking_izin->save();
	    } else {
            $tracking_izin->where('pendaftaran_id', $no_pendaftaran)
                          ->where('tr_activiti', 'Front Office')->get();
            if($tracking_izin->pendaftaran_id){
	            $tracking_izin->status = 'Update';
                $tracking_izin->d_entry = $this->lib_date->get_date_now();
		        $tracking_izin->tr_user = $u_ser;
        		$tracking_izin->tr_name = $r_name;
		        $tracking_izin->tr_activiti = 'Kirim Ke Pelayanan';
                $tracking_izin->save();
            }
	    }

        // Menyiapkan slot untuk tracking Entry Data
        $tracking_izin2 = new tmtrackingperizinan();
        $tracking_izin2->where('pendaftaran_id', $no_pendaftaran)
                       ->where('tr_activiti', 'Entry Data')->get();
        if(!$tracking_izin2->pendaftaran_id){
            $tracking_izin2->pendaftaran_id = $permohonan->pendaftaran_id;
            $tracking_izin2->status = 'Insert';
            $tracking_izin2->d_entry_awal = $this->lib_date->get_date_now();
            $tracking_izin2->d_entry = $this->lib_date->get_date_now();
	    	$tracking_izin2->tr_activiti = 'Entry Data';
    
            $sts_izin2 = new trstspermohonan();
            $sts_izin2->get_by_id('3');     //Entry Data [Lihat Tabel trstspermohonan()]
            $sts_izin2->save($permohonan);
            $tracking_izin2->save($permohonan);
            $tracking_izin2->save($sts_izin2);
        }

        $permohonan->save();

        redirect('pendaftaran/index/0/0'); // diberi nilai 0
    }

//    public function cetak_bukti($id_daftar = NULL) {
//        $nama_surat = "cetak_bukti";
//        $this->settings = new settings();
//        $this->settings->where('name', 'app_folder')->get();
//        $app_folder = $this->settings->value . "/";
//        $app_city = $this->settings->where('name', 'app_city')->get();
//
//        $permohonan = new tmpermohonan();
//        $permohonan->get_by_id($id_daftar);
//        $pemohon = $permohonan->tmpemohon->get();
//        $pendaftaran_id = $permohonan->pendaftaran_id;
//        $p_kelurahan = $pemohon->trkelurahan->get();
//        $p_kecamatan = $pemohon->trkelurahan->trkecamatan->get();
//        $p_kabupaten = $pemohon->trkelurahan->trkecamatan->trkabupaten->get();
//        $usaha = $permohonan->tmperusahaan->get();
//
//        /* Input Data Tracking Progress */
//        $status_izin = $permohonan->trstspermohonan->get();
//        $status_skr = "2"; //Menerima dan Memeriksa Berkas [Lihat Tabel trstspermohonan()]
//        if ($status_izin->id == $status_skr) {
//            $sts_izin = new trstspermohonan();
//            $sts_izin->get_by_id($status_skr); //Menerima dan Memeriksa Berkas [Lihat Tabel trstspermohonan()]
//            $data_status = new tmtrackingperizinan_trstspermohonan();
//            $list_tracking = $permohonan->tmtrackingperizinan->get();
//            if ($list_tracking) {
//                foreach ($list_tracking as $data_track) {
//                    $tracking_id = 0;
//                    $data_status = new tmtrackingperizinan_trstspermohonan();
//                    $data_status->where('tmtrackingperizinan_id', $data_track->id)
//                            ->where('trstspermohonan_id', $sts_izin->id)->get();
//                    if ($data_status->tmtrackingperizinan_id) {
//                        $tracking_id = $data_status->tmtrackingperizinan_id;
//                    }
//                }
//            }
//            $tracking_izin = new tmtrackingperizinan();
//            $tracking_izin->get_by_id($tracking_id);
//            //$tracking_izin->pendaftaran_id = $permohonan->pendaftaran_id;
//            $tracking_izin->status = 'Update';
//            $tracking_izin->d_entry = $this->lib_date->get_date_now();
//            $tracking_izin->save();
//        }
//
//        //Tampilkan Jenis Izin
//        $paralel_jenis = new trparalel();
//        $paralel_id = $permohonan->c_paralel;
//        $paralel_jenis->get_by_id($paralel_id);
//        $perizinan = new trperizinan();
//        $x = 1;
//        if ($paralel_id == 0) {
//            $jenis_izin = $perizinan->where_related($permohonan)->get();
//            foreach ($jenis_izin as $row) {
//                if ($x == 1)
//                    $data_izin = $row->n_perizinan;
//                else
//                    $data_izin = $data_izin . ", " . $row->n_perizinan;
//                $x++;
//            }
//        }else {
//            $permohonan_paralel = new tmpermohonan();
//            $permohonan_paralel->where('i_urut', $permohonan->i_urut)->get();
//            foreach ($permohonan_paralel as $row) {
//                $jenis_izin = $perizinan->where_related($row)->get();
//                if ($x == 1)
//                    $data_izin = $jenis_izin->n_perizinan;
//                else
//                    $data_izin = $data_izin . ", " . $jenis_izin->n_perizinan;
//                $x++;
//            }
//        }
//
//
//        //Tampilkan Tgl Daftar
//        if ($permohonan->d_entry) {
//            if ($permohonan->d_entry != '0000-00-00')
//                $tgl_daftar = $this->lib_date->mysql_to_human($permohonan->d_entry);
//            else
//                $tgl_daftar = "";
//        }else
//            $tgl_daftar = "";
//
//        //Tampilkan Tgl Peninjauan
//        if ($permohonan->d_survey) {
//            if ($permohonan->d_survey != '0000-00-00')
//                $tgl_survey = $this->lib_date->mysql_to_human($permohonan->d_survey);
//            else
//                $tgl_survey = "";
//        }else
//            $tgl_survey = "";
//
//        //Tampilkan Tgl Selesai
//        if ($permohonan->d_selesai_proses) {
//            if ($permohonan->d_selesai_proses != '0000-00-00')
//                $tgl_selesai = $this->lib_date->mysql_to_human($permohonan->d_selesai_proses);
//            else
//                $tgl_selesai = "";
//        }else
//            $tgl_selesai = "";
//
////        $this->_barcode('00060/94/01/09/2010', '105');
//
//        $color_black = new BCGColor(0, 0, 0);
//        $color_white = new BCGColor(255, 255, 255);
//
//        $code = new BCGcode128();
//        $code->setThickness(25);
//        $code->setForegroundColor($color_black); // Color of bars
//        $code->setBackgroundColor($color_white); // Color of spaces
//        $code->parse($pendaftaran_id); // Text
//        $drawing = new BCGDrawing('assets/barcode/' . $id_daftar . '.png', $color_white);
//        $drawing->setBarcode($code);
//        $drawing->draw();
//        $drawing->finish(BCGDrawing::IMG_FORMAT_PNG);
//
//        //path of the template file
//        $this->load->plugin('odf');
//        $odf = new odf('assets/odt/' . $nama_surat . '.odt');
//        $odf->setImage('header', 'assets/css/' . $app_folder . '/images/dinas_1.jpg', '17.5', '3.5');
//        $odf->setImage('barcode', 'assets/barcode/' . $id_daftar . '.png');
//
//        //fill the template with the variables
//        $username = new user();
//        $username->where('username', $this->session->userdata('username'))->get();
//        if ($username->id)
//            $user = $username->realname;
//        else
//            $user = "................................";
//        $odf->setVars('user', $user);
//        $wilayah = new trkabupaten();
//        if ($app_city->value !== '0') {
//            if ($pemohon->cek_prop == "1")
//                $alamat = $pemohon->a_pemohon;
//            else
//                $alamat = $pemohon->a_pemohon . ' ' . $p_kelurahan->n_kelurahan . ', ' . $p_kecamatan->n_kecamatan . ', ' . ucwords(strtolower($p_kabupaten->n_kabupaten));
//            $wilayah->get_by_id($app_city->value);
//            $odf->setVars('kabupaten', ucwords(strtolower($wilayah->n_kabupaten)));
//            $odf->setVars('kota', ucwords(strtolower($wilayah->n_kabupaten)));
//        }else {
//            $alamat = $pemohon->a_pemohon;
//            $odf->setVars('kabupaten', 'setempat');
//            $odf->setVars('kota', '...........');
//        }
//        $tgl_skr = $this->lib_date->get_date_now();
//        $odf->setVars('tglskr', $this->lib_date->mysql_to_human($tgl_skr, 1));
//        $daftar = new tmpermohonan();
//        $daftar->get_by_id($id_daftar);
//        $daftar->d_bukti = $tgl_skr;
//        $daftar->save();
//
//        $listeArticles = array(
//            array('property' => 'Nomor',
//                'content' => $permohonan->pendaftaran_id,
//            ),
//            array('property' => 'Nama',
//                'content' => $pemohon->n_pemohon . ' / ' . $usaha->n_perusahaan,
//            ),
//            array('property' => 'Alamat',
//                'content' => $alamat,
//            ),
//            array('property' => 'No. Telp/HP',
//                'content' => $pemohon->telp_pemohon,
//            ),
//            array('property' => 'Jenis Izin',
//                'content' => $data_izin,
//            ),
//            array('property' => 'Lokasi',
//                'content' => $permohonan->a_izin,
//            ),
//            array('property' => 'Tgl Daftar',
//                'content' => $tgl_daftar,
//            ),
//            array('property' => 'Tgl Peninjauan',
//                'content' => $tgl_survey,
//            ),
//            array('property' => 'Tgl Selesai',
//                'content' => $tgl_selesai . ' *)',
//            ),
//            array('property' => 'Keterangan',
//                'content' => $permohonan->keterangan,
//            ),
//        );
//        $article = $odf->setSegment('articles');
//        foreach ($listeArticles AS $element) {
//            $article->titreArticle($element['property']);
//            $article->texteArticle($element['content']);
//            $article->merge();
//        }
//        $odf->mergeSegment($article);
//
//        //export the file
//        $no_daftar = str_replace('/', '', $permohonan->pendaftaran_id);
//        $odf->exportAsAttachedFile($nama_surat . '_' . $no_daftar . '.odt');
//
//        unlink('assets/barcode/' . $id_daftar . '.png');
//    }

    public function delete($uid = NULL, $id_jns = NULL) {
        $permohonan = new tmpermohonan();
        $permohonan->get_by_id($uid);
        $permohonan->tmpemohon->get();
        $permohonan->tmperusahaan->get();
        $jenis = $permohonan->trjenis_permohonan->get();
        $id_jenis = $jenis->id;

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

        //Delete Permohonan

        $tgl = date("Y-m-d H:i:s");
        $u_ser = $this->session->userdata('username');
        $g = $this->sql($u_ser);
        $id_jenis= $this->input->post('id_jenis');
        if ($id_jns=="2"){
            //$p = $this->db->query("call log ('Perubahan Izin','Delete Perubahan Izin ".$permohonan->pendaftaran_id."','".$tgl."','".$u_ser."')");
        }else{
			if($id_jns=="3"){
                //$p = $this->db->query("call log ('Perpanjangan Izin','Delete Perpanjangan Izin ".$permohonan->pendaftaran_id."','".$tgl."','".$u_ser."')");
            }else{
                //$p = $this->db->query("call log ('Daftar Ulang','Delete Daftar Ulang ".$permohonan->pendaftaran_id."','".$tgl."','".$u_ser."')");
            }
	    }
        $permohonan->delete();

        redirect('pendaftaran/index/' . $id_jns);
    }

   public function sql($u_ser) {
        $query = "select a.description from user_auth as a
                  inner join user_user_auth as  x on a.id = x.user_auth_id
                  inner join user as b on b.id = x.user_id
                  where b.id = (select id from user where username='".$u_ser."')";
        $hasil = $this->db->query($query);
        return $hasil->row();
    }

    public function daftar_perusahaan_list() {
        $data['page_name'] = "Ambil Data Perusahaan";
        $this->load->vars($data);
        $this->load->view('pick_list_perusahaan', $data);
    }
	
	public function get_data_perusahaan() {
        $obj = new tmperusahaan();
//        $obj = $this->sql();
//        $columns = $this->sql();
        $columns = array('n_perusahaan', 'a_perusahaan', 'npwp');
        $obj->start_cache();
        $this->iTotalRecords = $obj->count();
        $this->sEcho = $this->input->post('sEcho');
        for ($i = 0; $i < 2; $i++) {
            /* Filtering */
            if ($this->input->post('sSearch')) {
                foreach ($columns as $position => $column) {
                    if ($position == 0 && $position == 2) {
                        $obj->like($column, $this->input->post('sSearch'));
                    } else {
                        $obj->or_like($column, $this->input->post('sSearch'));
                    }
                }
            }

            /* Ordering */
//            if ($this->input->post("iSortCol_0") != null && $this->input->post("iSortCol_0") != "") {
//                for ($i = 0; $i < intval($this->input->post("iSortingCols")); $i++) {
//                    $obj->order_by($columns[intval($this->input->post("iSortCol_" . $i))], $this->input->post("sSortDir_" . $i));
//                }
//            }

            if($i === 0){
                $this->iTotalDisplayRecords = $obj->count();
            }else{ 
				if($i === 1) {
                    if($this->input->post("iDisplayStart") && $this->input->post("iDisplayLength") != "-1"){
                        $this->iDisplayStart = $this->input->post("iDisplayStart");
                        $this->iDisplayLength = $this->input->post("iDisplayLength");
                        $obj->limit($this->iDisplayLength, $this->iDisplayStart);
                    }else{
                        $this->iDisplayLength = $this->input->post("iDisplayLength");
                        if(empty($this->iDisplayLength)){
                            $this->iDisplayLength = 10;
                            $obj->limit($this->iDisplayLength);
                        }else{
                            $obj->limit($this->iDisplayLength);
						}
                    }
				}
			}
        }

        $peru = new tmperusahaan;
        //$a = $peru->group_by('npwp')->get();
        $a = $obj->get();
        $obj->stop_cache();
        echo $this->get_data_perusahaan_output($a);
    }

    private function get_data_perusahaan_output($obj){
        $aaData = array();
        $i = $this->iDisplayStart;
        foreach ($obj as $list){
            $i++;

            //echo "<script> function conf() { alert('ok'); return false; } </script>";

            $action = NULL;
            $action = NULL;
            $action .= '<a href="javascript:popup_link(\'' . base_url() . 'pelayanan/pendaftaran/pick_perusahaan_data/' . $list->id . '\',\'#tabs-2\')">';
            $action .= '<img src="' . base_url() . 'assets/images/icon/navigation-down.png" border="0" alt="Pilih Pemohon"/>';
            $action .= '</a>';

            $aaData[] = array(
                $i,
                $list->n_perusahaan,
                $list->npwp,
                $list->a_perusahaan,
                $action
            );
        }
        $sOutput = array(
            "sEcho" => intval($this->sEcho),
            "iTotalRecords" => $this->iTotalRecords,
            "iTotalDisplayRecords" => $this->iTotalDisplayRecords,
            "aaData" => $aaData
        );

        return json_encode($sOutput);
    }
	
	public function pick_perusahaan_data($reg) {
        $data = $this->_funcwilayah();

        $_POST['id_perusahaan'] = $this->uri->segment(4);
        $u_perusahaan = $this->perusahaan->get_by_id($_POST['id_perusahaan']);

        $u_kegiatan = $u_perusahaan->trkegiatan->get();
        $u_investasi = $u_perusahaan->trinvestasi->get();

        $p_kelurahan = $u_perusahaan->trkelurahan->get();
        $p_kecamatan = $u_perusahaan->trkelurahan->trkecamatan->get();
        $p_kabupaten = $u_perusahaan->trkelurahan->trkecamatan->trkabupaten->get();
        $p_propinsi = $u_perusahaan->trkelurahan->trkecamatan->trkabupaten->trpropinsi->get();

        $data['kelurahan_usaha'] = $p_kelurahan->id;
        $data['kecamatan_usaha'] = $p_kecamatan->id;
        $data['kabupaten_usaha'] = $p_kabupaten->id;
        $data['propinsi_usaha'] = $p_propinsi->id;
        $data['status'] = "perusahaan";
        $data['data_npwp_id'] = "";
        $data['id_perusahaan'] = $u_perusahaan->id;
        $data['nama_perusahaan'] = $u_perusahaan->n_perusahaan;
        $data['npwp'] = $u_perusahaan->npwp;
        //$perusahaan->no_reg_perusahaan = $this->input->post('nodaftar');
        //$perusahaan->rt = $this->input->post('rt');
        //$perusahaan->rw = $this->input->post('rw');
        $data['telp_perusahaan'] = $u_perusahaan->i_telp_perusahaan;
        $data['alamat_usaha'] = $u_perusahaan->a_perusahaan;
        $data['nodaftar'] = $u_perusahaan->no_reg_perusahaan;
        $data['fax'] = $u_perusahaan->fax;
        $data['email'] = $u_perusahaan->email;
        $data['jenis_kegiatan'] = $u_kegiatan->id;
        $data['jenis_investasi'] = $u_investasi->id;
        $data['rt'] = $u_perusahaan->rt;
        $data['rw'] = $u_perusahaan->rw;

        //cek Online
        $this->settings->where('name', 'app_web_service')->get();
        $statusOnline = $this->settings->status;
        $data['statusOnline'] = $statusOnline;
        $data['registrasi'] = $reg;
        $this->load->vars($data);
        $this->load->view('perusahaan_tab', $data);
        echo "<script>$.facebox.close();</script>";
    }
}