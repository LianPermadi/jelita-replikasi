<?php
/**
 * Description of Pendaftaran Izin Baru
 *
 * @author update yogi apl 05 Aug 2010
 *         Edit   PBS 03 Jan 2014
 */

class Pendaftaran extends WRC_AdminCont {
    var $obj;
    /* Variable for generating JSON. */
    var $iTotalRecords;
    var $iTotalDisplayRecords;

    /* Variable that taken form input. */
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
        $this->pemohon = new tmpemohon();
        $this->perusahaan = new tmperusahaan();
        $this->kegiatan = new trkegiatan();
        $this->investasi = new trinvestasi();
        $this->settings = new settings();
		$base_url = base_url();
        $enabled = FALSE;
		$this->arsip = FALSE;
		$this->All = FALSE;
		$this->penghapusan = FALSE;
        $list_auths = $this->session_info['app_list_auth'];

        foreach ($list_auths as $list_auth) {
			if ($list_auth->id_role === '9' or $list_auth->id_role === '11') {
                $enabled = TRUE;
            }
			if ($list_auth->id_role === '21') {
                $this->arsip = TRUE;
            }
			if ($list_auth->id_role === '25') {
                $this->penghapusan = TRUE;
            }
			if ($list_auth->id_role === '18') {
                $this->All = TRUE;
            }
        }

        if (!$enabled) {
            redirect('dashboard');
        }
        $this->jenis_id = "1"; // Izin Baru
    }

    public function index() {  // Permohonan Izin Baru (pertama masuk saat click menu Pendaftaran-Permohonan Izin Baru)
		$list_auths = $this->session_info['app_list_auth'];
        foreach ($list_auths as $list_auth) {
            $data['nulogin'] = $list_auth->description;
        }
        $this->username->where('username', $this->session->userdata('username'))->get();
		$lokasi_user = $this->session->userdata('lokasi');
        $group = $this->username->group;
        $tgla = $this->input->post('tgla');
        $tglb = $this->input->post('tglb');
        $now = $this->lib_date->get_date_now();
        $tgl_before = $this->lib_date->set_date($now, -2);
        $tgl_now = $this->lib_date->set_date($now, 0);
        if ($tgla && $tglb) {
            $data['tgla'] = $tgla;
            $data['tglb'] = $tglb;
        } else {
            $tgla = $tgl_before;
            $tglb = $tgl_now;
            $data['tgla'] = $tgla;
            $data['tglb'] = $tglb;
        }
		if($this->All){
			$query = "SELECT A.id, A.pendaftaran_id, A.c_paralel, A.d_terima_berkas, A.a_izin,
                      A.d_perubahan, A.d_perpanjangan, A.d_daftarulang, A.keterangan,
                      C.id idizin, C.n_perizinan, E.n_pemohon, E.no_referensi,
                      G.id idjenis, G.n_permohonan, A.kd_gerai, A.trsektor_id
                      FROM tmpermohonan as A
                      INNER JOIN tmpermohonan_trperizinan as B ON B.tmpermohonan_id = A.id
                      INNER JOIN trperizinan as C ON B.trperizinan_id = C.id
                      INNER JOIN tmpemohon_tmpermohonan as D ON D.tmpermohonan_id = A.id
                      INNER JOIN tmpemohon as E ON D.tmpemohon_id = E.id
                      INNER JOIN tmpermohonan_trjenis_permohonan as F ON F.tmpermohonan_id = A.id
                      INNER JOIN trjenis_permohonan as G ON F.trjenis_permohonan_id = G.id
                      WHERE G.id = " . $this->jenis_id . "
                      AND A.c_pendaftaran = 0
                      AND A.c_izin_dicabut = 0
                      AND A.c_izin_selesai = 0
                      order by A.id DESC
					  LIMIT 1000";
		}else{
			if ($lokasi_user === 'Pusat') { // Untuk daerah lain
		    //if ($lokasi_user === 'DPMPTSP Prov. tasikmalaya' || $lokasi_user === 'BPMPT Prov. tasikmalaya' || $lokasi_user === 'BPPT Prov. tasikmalaya') {
                $query = "SELECT A.id, A.pendaftaran_id, A.c_paralel, A.d_terima_berkas, A.a_izin,
                          A.d_perubahan, A.d_perpanjangan, A.d_daftarulang, A.keterangan,
                          C.id idizin, C.n_perizinan, E.n_pemohon, E.no_referensi,
                          G.id idjenis, G.n_permohonan, A.kd_gerai, A.trsektor_id
                          FROM tmpermohonan as A
                          INNER JOIN tmpermohonan_trperizinan as B ON B.tmpermohonan_id = A.id
                          INNER JOIN trperizinan as C ON B.trperizinan_id = C.id
                          INNER JOIN tmpemohon_tmpermohonan as D ON D.tmpermohonan_id = A.id
                          INNER JOIN tmpemohon as E ON D.tmpemohon_id = E.id
                          INNER JOIN tmpermohonan_trjenis_permohonan as F ON F.tmpermohonan_id = A.id
                          INNER JOIN trjenis_permohonan as G ON F.trjenis_permohonan_id = G.id
                          INNER JOIN trperizinan_user as H ON H.trperizinan_id = C.id
                          INNER JOIN user as I ON H.user_id = I.id
                          WHERE G.id = " . $this->jenis_id . "
                          AND I.id = " . $this->username->id . "
                          AND A.c_pendaftaran = 0
                          AND A.c_izin_dicabut = 0
                          AND A.c_izin_selesai = 0
                          order by A.id DESC
						  LIMIT 1000";
		    } else {
                $query = "SELECT A.id, A.pendaftaran_id, A.c_paralel, A.d_terima_berkas, A.a_izin,
                          A.d_perubahan, A.d_perpanjangan, A.d_daftarulang, A.keterangan,
                          C.id idizin, C.n_perizinan, E.n_pemohon, E.no_referensi,
                          G.id idjenis, G.n_permohonan, A.kd_gerai, A.trsektor_id
                          FROM tmpermohonan as A
                          INNER JOIN tmpermohonan_trperizinan as B ON B.tmpermohonan_id = A.id
                          INNER JOIN trperizinan as C ON B.trperizinan_id = C.id
                          INNER JOIN tmpemohon_tmpermohonan as D ON D.tmpermohonan_id = A.id
                          INNER JOIN tmpemohon as E ON D.tmpemohon_id = E.id
                          INNER JOIN tmpermohonan_trjenis_permohonan as F ON F.tmpermohonan_id = A.id
                          INNER JOIN trjenis_permohonan as G ON F.trjenis_permohonan_id = G.id
                          INNER JOIN trperizinan_user as H ON H.trperizinan_id = C.id
                          INNER JOIN user as I ON H.user_id = I.id
                          WHERE G.id = " . $this->jenis_id . "
                          AND I.id = " . $this->username->id . "
                          AND A.c_pendaftaran = 0
                          AND A.c_izin_dicabut = 0
                          AND A.c_izin_selesai = 0
        		       	  AND A.kd_gerai =  '" . $this->username->lokasi . "'
                          order by A.id DESC
						  LIMIT 1000";
		    }
		}

        if($this->arsip){
			$list_izin = $this->perizinan->where_related($this->username)->order_by('id', 'ASC')->get();  // untuk Arsiparis
		}else{
            $list_izin = $this->perizinan->where_related($this->username)->order_by('id', 'ASC')->where('c_aktif = 0')->get();  // untuk FO
		}
        $data['list'] = $query;
        $data['list_izin'] = $list_izin;
        $data['jenis_id'] = $this->jenis_id;
        $data['ket_syarat'] = NULL;
		$data['group'] = $group;
		$data['penghapusan'] = $this->penghapusan;
        $this->load->vars($data);

        $js = "
                function confirm_link(text){
                    if(confirm(text)){ return true;
                    }else{ return false; }
                }
                $(document).ready(function() {
                    $('#jenis_izin').multiselect({
                       show:'blind',
                       hide:'blind',
                       multiple: false,
                       header: 'Pilih salah satu',
                       noneSelectedText: 'Pilih salah satu',
                       selectedList: 1
                    }).multiselectfilter();
                    
                    oTable = $('#pendaftaran').dataTable({
                            \"bJQueryUI\": true,
                            \"sPaginationType\": \"full_numbers\"
                    });
                } );

                $(document).ready(function() {
                    $('#paralel_id').change(function(){
                            $('#show_jenis_izin').fadeOut();
                            $.post('" . base_url() . "pelayanan/pendaftaran/izin_paralel', {
                                jenis_paralel_id: $('#paralel_id').val()
                            }, function(response){
                                setTimeout(\"finishAjax('show_jenis_izin', '\"+escape(response)+\"')\", 400);
                            });
                            return false;
                    });
                });

                function finishAjax(id, response){
                  $('#'+id).html(unescape(response));
                  $('#'+id).fadeIn();
                }
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
        $this->session_info['page_name'] = "Permohonan Izin Baru";
        $this->template->build('pendaftaran_list', $this->session_info);
    }

    public function list_index($id_persyaratan = NULL) {
        $this->username->where('username', $this->session->userdata('username'))->get();
        $tgla = $this->input->post('tgla');
        $tglb = $this->input->post('tglb');
        $now = $this->lib_date->get_date_now();
        $tgl_before = $this->lib_date->set_date($now, -2);
        $tgl_now = $this->lib_date->set_date($now, 0);
        if ($tgla && $tglb) {
            $data['tgla'] = $tgla;
            $data['tglb'] = $tglb;
        } else {
            $tgla = $tgl_before;
            $tglb = $tgl_now;
            $data['tgla'] = $tgla;
            $data['tglb'] = $tglb;
        }
        $query = "SELECT A.id, A.pendaftaran_id, A.c_paralel, A.d_terima_berkas,
        A.d_perubahan, A.d_perpanjangan, A.d_daftarulang,
        C.id idizin, C.n_perizinan, E.n_pemohon,
        G.id idjenis, G.n_permohonan
        FROM tmpermohonan as A
        INNER JOIN tmpermohonan_trperizinan as B ON B.tmpermohonan_id = A.id
        INNER JOIN trperizinan as C ON B.trperizinan_id = C.id
        INNER JOIN tmpemohon_tmpermohonan as D ON D.tmpermohonan_id = A.id
        INNER JOIN tmpemohon as E ON D.tmpemohon_id = E.id
        INNER JOIN tmpermohonan_trjenis_permohonan as F ON F.tmpermohonan_id = A.id
        INNER JOIN trjenis_permohonan as G ON F.trjenis_permohonan_id = G.id
        WHERE G.id = " . $this->jenis_id . "
        AND A.c_pendaftaran = 0
        AND A.c_izin_dicabut = 0
        AND A.c_izin_selesai = 0
        order by A.id DESC";
        $data['list'] = $query;
        $data['list_izin'] = $this->perizinan->where_related($this->username)->order_by('id', 'ASC')->get();
        $data['jenis_id'] = $this->jenis_id;
        $data['ket_syarat'] = $id_persyaratan;
        $this->load->vars($data);

        $js = "
                function confirm_link(text){
                    if(confirm(text)){ return true;
                    }else{ return false; }
                }
                $(document).ready(function() {
                    oTable = $('#pendaftaran').dataTable({
                            \"bJQueryUI\": true,
                            \"sPaginationType\": \"full_numbers\"
                    });
                } );

                $(document).ready(function() {
                    $('#paralel_id').change(function(){
                            $('#show_jenis_izin').fadeOut();
                            $.post('" . base_url() . "pelayanan/pendaftaran/izin_paralel', {
                                jenis_paralel_id: $('#paralel_id').val()
                            }, function(response){
                                setTimeout(\"finishAjax('show_jenis_izin', '\"+escape(response)+\"')\", 400);
                            });
                            return false;
                    });
                });

                function finishAjax(id, response){
                  $('#'+id).html(unescape(response));
                  $('#'+id).fadeIn();
                }
                ";

        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "Data Permohonan Izin Baru";
        $this->template->build('pendaftaran_list', $this->session_info);
    }

    function get_perizinan_baru($id, $jenis) {
        if ($jenis == 'paralel') {
            $sql = "SELECT DISTINCT c_show_type FROM trperizinan_trsyarat_perizinan WHERE trperizinan_id IN ($id)";
        } else {
            $sql = "SELECT DISTINCT c_show_type FROM trperizinan_trsyarat_perizinan WHERE trperizinan_id = '$id'";
        }
        $hasil = $this->db->query($sql);
        $result = $hasil->result();
        $arr = array();
        foreach ($result as $row) {
            $var = $row->c_show_type;
            $rule = strval(decbin($var));
            if (strlen($rule) < 4) {
                $len = 4 - strlen($rule);
                $rule = str_repeat("0", $len) . $rule;
            }
            $arr_rule = str_split($rule);
            $c_baru = $arr_rule[1];
            if ($arr_rule[1] == '1') {
                $arr[] = $var;
            }
        }
        return $arr;
    }

    function get_jml_syarat($id, $jenis) {
        if ($id == NULL) {
            redirect('pelayanan/pendaftaran');
        } else {
            $dum = $this->get_perizinan_baru($id, $jenis);
            if ($jenis == 'paralel') {
                $query = "SELECT COUNT(DISTINCT trsyarat_perizinan.id) as jml FROM
                trperizinan_trsyarat_perizinan
                INNER JOIN
                trsyarat_perizinan ON trsyarat_perizinan.id = trperizinan_trsyarat_perizinan.trsyarat_perizinan_id
                INNER JOIN
                trperizinan ON trperizinan.id = trperizinan_trsyarat_perizinan.trperizinan_id
                WHERE trsyarat_perizinan.`status` = '1' and trperizinan.id IN ($id) and c_show_type IN ('" . implode("','", $dum) . "')";
            } else {
                $query = "SELECT COUNT(*) as jml FROM
                trperizinan_trsyarat_perizinan
                INNER JOIN
                trsyarat_perizinan ON trsyarat_perizinan.id = trperizinan_trsyarat_perizinan.trsyarat_perizinan_id
                INNER JOIN
                trperizinan ON trperizinan.id = trperizinan_trsyarat_perizinan.trperizinan_id
                WHERE trsyarat_perizinan.`status` = '1' and trperizinan.id = " . $id . " and c_show_type IN ('" . implode("','", $dum) . "')
                GROUP BY n_perizinan";
            }
            $hasil = $this->db->query($query);
            return $hasil->row();
        }
    }

    public function create() {    // Masuk saat click Plus atau pendaftaran permohonan baru
        $this->username->where('username', $this->session->userdata('username'))->get();
		$lokasi_user = $this->session->userdata('lokasi');
        $data = $this->_funcwilayah();

        // Check Izin Paralel
        $data_paralel = $this->input->post('paralel');
        $id = $this->input->post('jenis_izin');
        $data['paralel'] = $data_paralel;
        if ($data_paralel == "no")
            $simpan = "save";
        else
            $simpan = "save_paralel";

        $app_city = $this->settings->where('name', 'app_city')->get();
        $prop = $this->get_id($app_city->value);
        $idkab = NULL;
        $idkec = NULL;
        $idkel = NULL;
        foreach ($prop as $key) {
            $idkab = $key->trpropinsi_id;
        }
		
        $data['ambil_data'] = FALSE;
		$data['eror'] = "";
        $data['save_method'] = $simpan;
        $data['id_daftar'] = "";
        $data['id_link'] = "";
        $data['waktu_awal'] = $this->lib_date->get_date_now();
        $data['no_refer'] = "";
        $data['nama_pemohon'] = "";
        $data['no_telp'] = "";
        $data['check_ctr'] = 0;
        $data['cmbsource'] = NULL;
        $data['propinsi_pemohon'] = ' ';
        $data['kabupaten_pemohon'] = NULL;
        $data['kecamatan_pemohon'] = NULL;
        $data['kelurahan_pemohon'] = NULL;
		$data['propinsi_lok'] = '12';     // Untuk Tasikmalaya
        $data['kabupaten_lok'] = NULL;
        $data['kecamatan_lok'] = NULL;
        $data['kelurahan_lok'] = NULL;
        $data['jenis_kegiatan'] = "ok";
        $data['jenis_investasi'] = "ok";
        $data['propinsi_usaha'] = ' ';
        $data['kabupaten_usaha'] = NULL;
        $data['kecamatan_usaha'] = NULL;
        $data['kelurahan_usaha'] = NULL;

        $data['tgl_daftar'] = date("Y-m-d");
        $data['tgl_survey'] = "";
        $data['lokasi_izin'] = "";
		$data['rincian_lokasi'] = "";
        $data['keterangan'] = "";
		$data['cmbgerai'] = "";
		$data['no_antri'] = "";
		$data['kd_kontak']="";
        $data['alamat_pemohon'] = "";
        $data['alamat_pemohon_luar'] = "";
        $data['nama_perusahaan'] = "";
        $data['npwp'] = "";
        $data['nodaftar'] = "";
        $data['fax'] = "";
        $data['email'] = "";
        $data['nama_perusahaan'] = "";
        $data['telp_perusahaan'] = "";
        $data['alamat_usaha'] = "";
        $data['rt'] = "";
        $data['rw'] = "";
        $data['lokasi_user'] = $lokasi_user;
		
        //Izin Paralel
        $paralel_jenis = new trparalel();
        $data['jenis_paralel'] = $paralel_jenis->get_by_id($this->input->post('jenis_paralel'));

        if ($data_paralel == "no") {
            $data_izin = $this->perizinan->get_by_id($this->input->post('jenis_izin'));
            $jml = $this->get_jml_syarat($id, 'seri');
            if (!empty($jml->jml)) {
                $data['jml_syarat'] = $jml->jml;
            } else {
                $data['jml_syarat'] = "";
            }
        } else {
            $data_izin = $this->perizinan->where_related($paralel_jenis)->get();
            $id_paralel = implode(",", $this->input->post('list_izin_paralel'));
            $jml = $this->get_jml_syarat($id_paralel, 'paralel');
            if (!empty($jml->jml)) {
                $data['jml_syarat'] = $jml->jml;
            } else {
                $data['jml_syarat'] = "";
            }
        }
		$data['group'] = $this->username->group;
        $data['mohon'] = $this->input->post('jenis_permohonan');
        $data['izin'] = $this->input->post('jenis_izin');
        $data['jenis_izin'] = $data_izin;
        $data['list_izin_paralel'] = $this->input->post('list_izin_paralel');
        
		//Kelompok Izin
        $data['kelompok_izin'] = $this->kelompok_izin->get_by_id($this->input->post('jenis_izin'));
        
		//Jenis Permohonan
        $data['jenis_permohonan'] = $this->jenispermohonan->get_by_id($this->input->post('jenis_permohonan'));
        
		//Syarat Perizinan
        $syarat_perizinan = new trsyarat_perizinan();
        $data['syarat_izin'] = $syarat_perizinan->where_related($data_izin)->order_by('status', 'asc')->get();

        //cek Online pajak
        $this->settings->where('name', 'app_web_service')->get();
        $statusOnline = $this->settings->status;
        $data['statusOnline'] = $statusOnline;

        //cek Online penduduk
        $this->settings->where('name', 'web_service_penduduk')->get();
        $statusOnline2 = $this->settings->status;
        $data['statusOnline2'] = $statusOnline2;

        $js = "
                $(document).ready(function() {
                    $('#form').validate();
                    $(\"#tabs\").tabs();

                    $('a[rel*=pemohon_box]').facebox();
                    $('a[rel*=daftar_box]').facebox();
                    $('a[rel*=perusahaan_box]').facebox();
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
                });

                $(document).ready(function() {
                    $('#propinsi_pemohon_id').change(function(){
                        $.post('" . base_url() . "pelayanan/pendaftaran/kabupaten_pemohon', { propinsi_id: $('#propinsi_pemohon_id').val() },
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
                        $.post('" . base_url() . "pelayanan/pendaftaran/kabupaten_usaha', { propinsi_id: $('#propinsi_usaha_id').val() },
                            function(data) {
                                $('#show_kabupaten_usaha').html(data);
                                $('#show_kecamatan_usaha').html('Data Tidak tersedia');
                                $('#show_kelurahan_usaha').html('Data Tidak tersedia');
                            }
						);
                    });
                });

				$(document).ready(function() {
                    $('#kabupaten_lok_id').change(function(){
                        $.post('" . base_url() . "pelayanan/pendaftaran/kecamatan_lok', { kabupaten_id: $('#kabupaten_lok_id').val() },
                            function(data) {
                                $('#show_kecamatan_lok').html(data);
                                $('#show_kelurahan_lok').html('Data Tidak tersedia');
                            }
						);
                    });
                });

                function show_npwp(form) {
                    var reg = form.nodaftar.value;
                    var npwp = form.npwp_id.value;
                    if (npwp.length==0) {
                        alert('Npwp harus diisi');
                        return false;
                    } else 
					    if (reg.length==0) {
                            alert('No daftar Harus diisi');
                            return false;
                        } else {
                            $.post('" . base_url() . "pelayanan/pendaftaran/pick_perusahaan_data/'+reg, 
							    { data_npwp_id: $('#npwp_id').val() }, 
								function(response){
                                    setTimeout(\"finishAjax('tabs-2', '\"+escape(response)+\"')\", 400);
                                }
							);
                            return false;
                        }
                }

                function show_ktp(form) {
                    var reg = form.no_refer.value;
                    if (reg.length==0) {
                        $('#error_id').html('Id tidak Boleh Kosong');
                        return false;
                    } else {
                        $('#error_id').html('');
                        $.post('" . base_url() . "pelayanan/pendaftaran/pick_penduduk_data', 
						    { data_no_refer: $('#no_refer').val() }, 
							function(response){
                                setTimeout(\"finishAjax('tabs-1', '\"+escape(response)+\"')\", 400);
                            }
						);
                        return false;
                    }
                }

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
				function Check(){
                    if(document.form.Check_ctr.checked == true){
                        document.form.propinsi_lok.disabled = false ;
                        document.form.kabupaten_lok.disabled = false ;
                        document.form.kecamatan_lok.disabled = false ;
                        document.form.kelurahan_lok.disabled = false ;
                    }else{
                        document.form.propinsi_lok.disabled = true ;
                        document.form.kabupaten_lok.disabled = true ;
                        document.form.kecamatan_lok.disabled = true ;
                        document.form.kelurahan_lok.disabled = true ;
                    }
                }
            ";

        $this->template->set_metadata_javascript($js);
        $this->load->vars($data);
        $this->session_info['page_name'] = "Entry Data Permohonan Izin Baru";
        $this->template->build('pendaftaran_edit', $this->session_info);
    }

    public function create2($id_jenis) {
        $this->username->where('username', $this->session->userdata('username'))->get();
		$lokasi_user = $this->session->userdata('lokasi');
        $data = $this->_funcwilayah();

        // Check Izin Paralel
        $data_paralel = $this->input->post('paralel');
        $data['paralel'] = $data_paralel;
        if ($data_paralel == "no")
            $simpan = "save/" . $id_jenis;
        else
            $simpan = "save_paralel/" . $id_jenis;

        $data['check'] = $this->input->post('pemohon_syarat');
        $app_city = $this->settings->where('name', 'app_city')->get();
        $prop = $this->get_id($app_city->value);
        $idkab = NULL;
        $idkec = NULL;
        $idkel = NULL;
        foreach ($prop as $key) {
            $idkab = $key->trpropinsi_id;
        }

        //validasi pemohon
        $tgl_daftar = $this->input->post('tgl_daftar');
        $nama_pemohon = $this->input->post('nama_pemohon');
        $propinsi_p = $this->input->post('propinsi_pemohon');
        $kabupaten_p = $this->input->post('kabupaten_pemohon');
        $kecamatan_p = $this->input->post('kecamatan_pemohon');
        $kelurahan_p = $this->input->post('kelurahan_pemohon');
        $tlp = $this->input->post('no_telp');
        $ktp = $this->input->post('no_refer');
        $alamat = $this->input->post('alamat_pemohon');

        //validasi perusahaan
        $npwp = $this->input->post('npwp');
        $no_daftar = $this->input->post('nodaftar');
        $nama_perusahaan = $this->input->post('nama_perusahaan');
        $tlp_perusahaan = $this->input->post('telp_perusahaan');
        $propinsi_u = $this->input->post('propinsi_usaha');
        $kabupaten_u = $this->input->post('kabupaten_usaha');
        $kecamatan_u = $this->input->post('kecamatan_usaha');
        $kelurahan_u = $this->input->post('kelurahan_usaha');
        $alamat_u = $this->input->post('alamat_usaha');
        $j_kegiatan = $this->input->post('jenis_kegiatan');
        $j_investasi = $this->input->post('jenis_investasi');

        if ($nama_pemohon == "" || $tgl_daftar == "" || $tlp == "" || $ktp == "" || $alamat == "" || $propinsi_p == " " || $kabupaten_p == " " || $kecamatan_p == " " || $kelurahan_p == " ") {
            $data['eror'] = "Data pemohon belum lengkap";
        } elseif ($npwp == "" || $no_daftar == "" || $nama_perusahaan == "" || $tlp_perusahaan == "" ||
                $propinsi_u == " " || $kabupaten_u == " " || $kecamatan_u == " " || $kelurahan_u == " " || $alamat_u == " " ||
                $j_kegiatan == " " || $j_investasi == " ") {
            $data['eror'] = "Data perusahaan belum lengkap";
        } else {
            $data['eror'] = "Data persyaratan wajib belum lengkap";
        }

        //$id = $this->input->post('jenis_izin');
		$data['ambil_data'] = FALSE;
        $data['mohon'] = $this->input->post('jenis_permohonan');
        $data['save_method'] = $simpan;
        $data['id_daftar'] = "";
        $data['id_link'] = "";
        $data['waktu_awal'] = $this->lib_date->get_date_now();
        $data['no_refer'] = $this->input->post('no_refer');
        $data['nama_pemohon'] = $nama_pemohon;
        $data['no_telp'] = $this->input->post('no_telp');
        $data['propinsi_pemohon'] = $this->input->post('propinsi_pemohon');
        $data['check_ctr'] = 0;
        $data['kabupaten_pemohon'] = $this->input->post('kabupaten_pemohon');
        $data['kecamatan_pemohon'] = $this->input->post('kecamatan_pemohon');
        $data['kelurahan_pemohon'] = $this->input->post('kelurahan_pemohon');

        $data['propinsi_usaha'] = $this->input->post('propinsi_usaha');
        $data['kabupaten_usaha'] = $this->input->post('kabupaten_usaha');
        $data['kecamatan_usaha'] = $this->input->post('kecamatan_usaha');
        $data['kelurahan_usaha'] = $this->input->post('kelurahan_usaha');
        $data['jenis_kegiatan'] = $this->input->post('jenis_kegiatan');
        $data['jenis_investasi'] = $this->input->post('jenis_investasi');
        $data['tgl_daftar'] = $tgl_daftar;
        $data['tgl_survey'] = $this->input->post('tgl_survey');
        $data['lokasi_izin'] = $this->input->post('lokasi_izin');
		$data['rincian_lokasi'] = "";
        $data['keterangan'] = $this->input->post('keterangan');
		$data['cmbgerai'] = $this->input->post('cmbgerai');
		$data['no_antri'] = $this->input->post('no_antri');
		$data['kd_kontak']=$this->input->post('kd_kontak');
        $data['alamat_pemohon'] = $this->input->post('alamat_pemohon');
        $data['alamat_pemohon_luar'] = $this->input->post('alamat_pemohon_luar');
        $data['nama_perusahaan'] = $this->input->post('nama_perusahaan');
        $data['npwp'] = $npwp;
        $data['nodaftar'] = $this->input->post('nodaftar');
        $data['fax'] = $this->input->post('fax');
        $data['email'] = $this->input->post('email');
        $data['nama_perusahaan'] = $this->input->post('nama_perusahaan');
        $data['telp_perusahaan'] = $this->input->post('telp_perusahaan');
        $data['alamat_usaha'] = $this->input->post('alamat_usaha');
        $data['rt'] = $this->input->post('rt');
        $data['rw'] = $this->input->post('rw');
		$data['lokasi_user'] = $lokasi_user;

        //Izin Paralel
        $paralel_jenis = new trparalel();
        $data['jenis_paralel'] = $paralel_jenis->get_by_id($this->input->post('jenis_paralel'));

        if ($data_paralel == "no") {
            $data_izin = $this->perizinan->get_by_id($this->input->post('jenis_izin'));
            $jml = $this->get_jml_syarat($id, 'seri');
            $data['jml_syarat'] = $jml->jml;
        } else {
            $data_izin = $this->perizinan->where_related($paralel_jenis)->get();
            $id_paralel = implode(",", $this->input->post('list_izin_paralel'));
            $jml = $this->get_jml_syarat($id_paralel, 'paralel');
            $data['jml_syarat'] = $jml->jml;
        }

        $data['group'] = $this->username->group;
        $data['izin'] = $this->input->post('jenis_izin');
        $data['jenis_izin'] = $data_izin;
        $data['list_izin_paralel'] = $this->input->post('list_izin_paralel');

        //Kelompok Izin
        $data['kelompok_izin'] = $this->kelompok_izin->get_by_id($this->input->post('jenis_izin'));

        //Jenis Permohonan
        $data['jenis_permohonan'] = $this->jenispermohonan->get_by_id($this->input->post('jenis_permohonan'));

        //Syarat Perizinan
        $syarat_perizinan = new trsyarat_perizinan();
        $data['syarat_izin'] = $syarat_perizinan->where_related($data_izin)->order_by('status', 'asc')->get();

        //cek Online
        $this->settings->where('name', 'app_web_service')->get();
        $statusOnline = $this->settings->status;
        $data['statusOnline'] = $statusOnline;
        
		//cek Online penduduk
        $this->settings->where('name', 'web_service_penduduk')->get();
        $statusOnline2 = $this->settings->status;
        $data['statusOnline2'] = $statusOnline2;

        $js = "
                $(document).ready(function() {
                    $('#form').validate();
                    $(\"#tabs\").tabs();

                    $('a[rel*=pemohon_box]').facebox();
                    $('a[rel*=daftar_box]').facebox();
                    $('a[rel*=perusahaan_box]').facebox();
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
                });

                $(document).ready(function() {
                    $('#propinsi_pemohon_id').change(function(){
                        $.post('" . base_url() . "pelayanan/pendaftaran/kabupaten_pemohon', { propinsi_id: $('#propinsi_pemohon_id').val() },
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
                        $.post('" . base_url() . "pelayanan/pendaftaran/kabupaten_usaha', { propinsi_id: $('#propinsi_usaha_id').val() },
                            function(data) {
                                $('#show_kabupaten_usaha').html(data);
                                $('#show_kecamatan_usaha').html('Data Tidak tersedia');
                                $('#show_kelurahan_usaha').html('Data Tidak tersedia');
                            }
						);
                    });
                });

                function show_npwp() {
                    $.post('" . base_url() . "pelayanan/pendaftaran/pick_perusahaan_data', 
					    { data_npwp_id: $('#npwp_id').val() }, 
						function(response){
                            setTimeout(\"finishAjax('tabs-2', '\"+escape(response)+\"')\", 400);
                        }
					);
                    return false;
                }

                function show_ktp() {
                    $.post('" . base_url() . "pelayanan/pendaftaran/pick_penduduk_data', 
					    { data_no_refer: $('#no_refer').val() }, 
						function(response){
                            setTimeout(\"finishAjax('tabs-1', '\"+escape(response)+\"')\", 400);
                        }
					);
                    return false;
                }

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
                    } else {
                        document.form.propinsi_pemohon.disabled = true ;
                        document.form.kabupaten_pemohon.disabled = true ;
                        document.form.kecamatan_pemohon.disabled = true ;
                        document.form.kelurahan_pemohon.disabled = true ;
                    }
                }
            ";

        $this->template->set_metadata_javascript($js);

        $this->load->vars($data);
        $this->session_info['page_name'] = "Entry Data Permohonan Izin Baru";
        $this->template->build('pendaftaran_edit', $this->session_info);
    }

    /*
     * edit is a method to show page for updating data
     */

    public function edit($id_daftar = NULL, $id_link = NULL) {
        $this->username->where('username', $this->session->userdata('username'))->get();
		$lokasi_user = $this->session->userdata('lokasi');

		$u_daftar = $this->pendaftaran->get_by_id($id_daftar);
        $p_pemohon = $u_daftar->tmpemohon->get();
        $p_kelurahan = $p_pemohon->trkelurahan->get();
        $p_kecamatan = $p_pemohon->trkelurahan->trkecamatan->get();
        $p_kabupaten = $p_pemohon->trkelurahan->trkecamatan->trkabupaten->get();
        $p_propinsi = $p_pemohon->trkelurahan->trkecamatan->trkabupaten->trpropinsi->get();

		$kelurahan_lok = $u_daftar->trkelurahan_id;
		$dkelurahan = $this->kelurahan->get_by_id($kelurahan_lok);
		$lok_kecamatan = $dkelurahan->trkecamatan->get();
        $lok_kabupaten = $dkelurahan->trkecamatan->trkabupaten->get();
		$kecamatan_lok = $lok_kecamatan->id;
		$kabupaten_lok = $lok_kabupaten->id;
        
        $u_perusahaan = $u_daftar->tmperusahaan->get();
        $u_kelurahan = $u_perusahaan->trkelurahan->get();
        $u_kecamatan = $u_perusahaan->trkelurahan->trkecamatan->get();
        $u_kabupaten = $u_perusahaan->trkelurahan->trkecamatan->trkabupaten->get();
        $u_propinsi = $u_perusahaan->trkelurahan->trkecamatan->trkabupaten->trpropinsi->get();
        $u_kegiatan = $u_daftar->tmperusahaan->trkegiatan->get();
        $u_investasi = $u_daftar->tmperusahaan->trinvestasi->get();

        $d_izin = $u_daftar->trperizinan->get();
        $d_kelompok = $d_izin->trkelompok_perizinan->get();
        $d_jenis = $u_daftar->trjenis_permohonan->get();

        $data = $this->_funcwilayah();

        $jml = $this->get_jml_syarat($d_izin->id, 'seri');
		$data['ambil_data'] = TRUE;
        $data['jml_syarat'] = $jml->jml;
        $data['group'] = $this->username->group;
        $data['izin'] = "";
        $data['eror'] = "";
        $data['save_method'] = "update";
        $data['id_daftar'] = $id_daftar;
        $data['paralel'] = "no";
        $paralel_jenis = new trparalel();
        $data['mohon'] = "";
        $data['jenis_paralel'] = $paralel_jenis->get_by_id($u_daftar->c_paralel);
        $data['id_link'] = $id_link;
        $data['waktu_awal'] = $this->lib_date->get_date_now();
        $data['no_refer'] = $p_pemohon->no_referensi;
        $data['nama_pemohon'] = $p_pemohon->n_pemohon;
        $data['no_telp'] = $p_pemohon->telp_pemohon;
        $data['cmbsource'] = $p_pemohon->source;
        $data['check_ctr'] = $p_pemohon->cek_prop;
        $data['propinsi_pemohon'] = $p_propinsi->id;
        $data['kabupaten_pemohon'] = $p_kabupaten->id;
        $data['kecamatan_pemohon'] = $p_kecamatan->id;
        $data['kelurahan_pemohon'] = $p_kelurahan->id;
		$data['nkab_pemohon'] = $p_kabupaten->n_kabupaten;
        $data['nkec_pemohon'] = $p_kecamatan->n_kecamatan;
        $data['nkel_pemohon'] = $p_kelurahan->n_kelurahan;

		$data['kabupaten_lok'] = $kabupaten_lok;
        $data['kecamatan_lok'] = $kecamatan_lok;
        $data['kelurahan_lok'] = $kelurahan_lok;
		$data['nkab_lok'] = $lok_kabupaten->n_kabupaten;
        $data['nkec_lok'] = $lok_kecamatan->n_kecamatan;
        $data['nkel_lok'] = $dkelurahan->n_kelurahan;

        $data['jenis_kegiatan'] = $u_kegiatan->id;
        $data['jenis_investasi'] = $u_investasi->id;
        $data['propinsi_usaha'] = $u_propinsi->id;
        $data['kabupaten_usaha'] = $u_kabupaten->id;
        $data['kecamatan_usaha'] = $u_kecamatan->id;
        $data['kelurahan_usaha'] = $u_kelurahan->id;
		$data['nkab_usaha'] = $u_kabupaten->n_kabupaten;
        $data['nkec_usaha'] = $u_kecamatan->n_kecamatan;
        $data['nkel_usaha'] = $u_kelurahan->n_kelurahan;

        $data['tgl_daftar'] = $u_daftar->d_terima_berkas;
        $data['tgl_survey'] = $u_daftar->d_survey;
        $data['lokasi_izin'] = $u_daftar->a_izin;
		$data['rincian_lokasi'] = "";
        $data['keterangan'] = $u_daftar->keterangan;
		$data['cmbgerai'] = $u_daftar->kd_gerai;
		$data['no_antri'] = $u_daftar->no_antri;
		$data['kd_kontak']=$u_daftar->kontak_person;
        $data['alamat_pemohon'] = $p_pemohon->a_pemohon;
        $data['alamat_pemohon_luar'] = $p_pemohon->a_pemohon_luar;

        $data['id_perusahaan'] = $u_perusahaan->id;
        $data['nama_perusahaan'] = $u_perusahaan->n_perusahaan;
        $data['npwp'] = $u_perusahaan->npwp;
        $data['telp_perusahaan'] = $u_perusahaan->i_telp_perusahaan;
        $data['alamat_usaha'] = $u_perusahaan->a_perusahaan;
        $data['nodaftar'] = $u_perusahaan->no_reg_perusahaan;
        $data['fax'] = $u_perusahaan->fax;
        $data['email'] = $u_perusahaan->email;
        $data['rt'] = $u_perusahaan->rt;
        $data['rw'] = $u_perusahaan->rw;
        $data['jenis_izin'] = $this->perizinan->get_by_id($d_izin->id);
        $data['kelompok_izin'] = $this->kelompok_izin->get_by_id($d_kelompok->id);
        $data['jenis_permohonan'] = $this->jenispermohonan->get_by_id($d_jenis->id);
		$data['lokasi_user'] = $lokasi_user;

        $syarat_perizinan = new trsyarat_perizinan();
		$data['syarat_izin'] = $syarat_perizinan->where_related($this->perizinan)->order_by('status', 'asc')->get();

		$data['list_daftar'] = $u_daftar;
        
		//cek Online
//        $this->settings->where('name', 'app_web_service')->get();
//        $statusOnline = $this->settings->status;
        $data['statusOnline'] = 0;

        //cek Online penduduk
//        $this->settings->where('name', 'web_service_penduduk')->get();
//        $statusOnline2 = $this->settings->status;
        $data['statusOnline2'] = 0;

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
                });

                $(document).ready(function() {
                    $('#propinsi_pemohon_id').change(function(){
                        $.post('" . base_url() . "pelayanan/pendaftaran/kabupaten_pemohon', { propinsi_id: $('#propinsi_pemohon_id').val() },
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
                        $.post('" . base_url() . "pelayanan/pendaftaran/kabupaten_usaha', { propinsi_id: $('#propinsi_usaha_id').val() },
                            function(data) {
                                $('#show_kabupaten_usaha').html(data);
                                $('#show_kecamatan_usaha').html('Data Tidak tersedia');
                                $('#show_kelurahan_usaha').html('Data Tidak tersedia');
                            }
						);
                    });
                });

				$(document).ready(function() {
                    $('#kabupaten_lok_id').change(function(){
                        $.post('" . base_url() . "pelayanan/pendaftaran/kecamatan_lok', { kabupaten_id: $('#kabupaten_lok_id').val() },
                            function(data) {
                                $('#show_kecamatan_lok').html(data);
                                $('#show_kelurahan_lok').html('Data Tidak tersedia');
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
                    } else {
                        document.form.propinsi_pemohon.disabled = true ;
                        document.form.kabupaten_pemohon.disabled = true ;
                        document.form.kecamatan_pemohon.disabled = true ;
                        document.form.kelurahan_pemohon.disabled = true ;
                    }
                }
            ";

        $this->template->set_metadata_javascript($js);

        $this->load->vars($data);
        if ($id_link == "1") {
            $this->session_info['page_name'] = "Entry data edit";
        } else {
            $this->session_info['page_name'] = "Edit Permohonan Izin Baru";
        }
        $this->template->build('pendaftaran_edit', $this->session_info);
    }

    public function edit2($id_daftar = NULL, $id_link = NULL) {

		$this->username->where('username', $this->session->userdata('username'))->get();
		$lokasi_user = $this->session->userdata('lokasi');

        $u_daftar = $this->pendaftaran->get_by_id($id_daftar);

        $p_pemohon = $u_daftar->tmpemohon->get();
        $p_kelurahan = $p_pemohon->trkelurahan->get();
        $p_kecamatan = $p_pemohon->trkelurahan->trkecamatan->get();
        $p_kabupaten = $p_pemohon->trkelurahan->trkecamatan->trkabupaten->get();
        $p_propinsi = $p_pemohon->trkelurahan->trkecamatan->trkabupaten->trpropinsi->get();
        $id_link = $this->input->post('id_link');
        $u_perusahaan = $u_daftar->tmperusahaan->get();
        $u_kelurahan = $u_perusahaan->trkelurahan->get();
        $u_kecamatan = $u_perusahaan->trkelurahan->trkecamatan->get();
        $u_kabupaten = $u_perusahaan->trkelurahan->trkecamatan->trkabupaten->get();
        $u_propinsi = $u_perusahaan->trkelurahan->trkecamatan->trkabupaten->trpropinsi->get();
        $u_kegiatan = $u_daftar->tmperusahaan->trkegiatan->get();
        $u_investasi = $u_daftar->tmperusahaan->trinvestasi->get();

        $d_izin = $u_daftar->trperizinan->get();
        $d_kelompok = $d_izin->trkelompok_perizinan->get();
        $d_jenis = $u_daftar->trjenis_permohonan->get();

        $data = $this->_funcwilayah();
        $jml = $this->get_jml_syarat($d_izin->id, 'seri');
        $data['jml_syarat'] = $jml->jml;
		$data['group'] = $this->username->group;
        //validasi pemohon
        $tgl_daftar = $this->input->post('tgl_daftar');
        $nama_pemohon = $this->input->post('nama_pemohon');
        $propinsi_p = $this->input->post('propinsi_pemohon');
        $kabupaten_p = $this->input->post('kabupaten_pemohon');
        $kecamatan_p = $this->input->post('kecamatan_pemohon');
        $kelurahan_p = $this->input->post('kelurahan_pemohon');
        $tlp = $this->input->post('no_telp');
        $ktp = $this->input->post('no_refer');
        $alamat = $this->input->post('alamat_pemohon');

        //validasi perusahaan
        $npwp = $this->input->post('npwp');
        $no_daftar = $this->input->post('nodaftar');
        $nama_perusahaan = $this->input->post('nama_perusahaan');
        $tlp_perusahaan = $this->input->post('telp_perusahaan');
        $propinsi_u = $this->input->post('propinsi_usaha');
        $kabupaten_u = $this->input->post('kabupaten_usaha');
        $kecamatan_u = $this->input->post('kecamatan_usaha');
        $kelurahan_u = $this->input->post('kelurahan_usaha');
        $alamat_u = $this->input->post('alamat_usaha');
        $j_kegiatan = $this->input->post('jenis_kegiatan');
        $j_investasi = $this->input->post('jenis_investasi');

        if ($nama_pemohon == "" || $tgl_daftar == "" || $tlp == "" || $ktp == "" || $alamat == "" || $propinsi_p == " " || $kabupaten_p == " " || $kecamatan_p == " " || $kelurahan_p == " ") {
            $data['eror'] = "Data pemohon belum lengkap";
        } elseif ($npwp == "" || $no_daftar == "" || $nama_perusahaan == "" || $tlp_perusahaan == "" ||
                $propinsi_u == " " || $kabupaten_u == " " || $kecamatan_u == " " || $kelurahan_u == " " || $alamat_u == " " ||
                $j_kegiatan == " " || $j_investasi == " ") {
            $data['eror'] = "Data perusahaan belum lengkap";
        } else {
            $data['eror'] = "Data persyaratan wajib belum lengkap";
        }

        $data['ambil_data'] = FALSE;
		$data['check'] = $this->input->post('pemohon_syarat');
        $data['izin'] = "";
        $data['mohon'] = "";
        $data['save_method'] = "update";
        $data['id_daftar'] = $id_daftar;
        $data['paralel'] = "no";
        $paralel_jenis = new trparalel();
        $data['jenis_paralel'] = $paralel_jenis->get_by_id($u_daftar->c_paralel);
        $data['id_link'] = $id_link;
        $data['waktu_awal'] = $this->lib_date->get_date_now();
        $data['no_refer'] = $this->input->post('no_refer');
        $data['nama_pemohon'] = $nama_pemohon;
        $data['no_telp'] = $this->input->post('no_telp');
        $data['check_ctr'] = $p_pemohon->cek_prop;
        $data['propinsi_pemohon'] = $this->input->post('propinsi_pemohon');
        $data['kabupaten_pemohon'] = $this->input->post('kabupaten_pemohon');
        $data['kecamatan_pemohon'] = $this->input->post('kecamatan_pemohon');
        $data['kelurahan_pemohon'] = $this->input->post('kelurahan_pemohon');
        $data['jenis_kegiatan'] = $this->input->post('jenis_kegiatan');
        ;
        $data['jenis_investasi'] = $this->input->post('jenis_investasi');
        ;
        $data['propinsi_usaha'] = $this->input->post('propinsi_usaha');
        $data['kabupaten_usaha'] = $this->input->post('kabupaten_usaha');
        $data['kecamatan_usaha'] = $this->input->post('kecamatan_usaha');
        $data['kelurahan_usaha'] = $this->input->post('kelurahan_usaha');
        $data['tgl_daftar'] = $tgl_daftar;
        $data['tgl_survey'] = $this->input->post('tgl_survey');
        $data['lokasi_izin'] = $this->input->post('lokasi_izin');
		$data['rincian_lokasi'] = "";
        $data['keterangan'] = $this->input->post('keterangan');
		$data['cmbgerai'] = $this->input->post('cmbgerai');
		$data['no_antri'] = $this->input->post('no_antri');
		$data['kd_kontak']=$this->input->post('kd_kontak');
        $data['alamat_pemohon'] = $this->input->post('alamat_pemohon');
        $data['alamat_pemohon_luar'] = $this->input->post('alamat_pemohon_luar');

        $data['id_perusahaan'] = $u_perusahaan->id;
        $data['nama_perusahaan'] = $this->input->post('nama_perusahaan');
        $data['npwp'] = $npwp;
        $data['telp_perusahaan'] = $this->input->post('telp_perusahaan');
        $data['alamat_usaha'] = $this->input->post('alamat_usaha');
        $data['nodaftar'] = $this->input->post('nodaftar');
        $data['fax'] = $this->input->post('fax');
        $data['email'] = $this->input->post('email');
        $data['rt'] = $this->input->post('rt');
        $data['rw'] = $this->input->post('rw');
        $data['jenis_izin'] = $this->perizinan->get_by_id($d_izin->id);
        $data['kelompok_izin'] = $this->kelompok_izin->get_by_id($d_kelompok->id);
        $data['jenis_permohonan'] = $this->jenispermohonan->get_by_id($d_jenis->id);
		$data['lokasi_user'] = $lokasi_user;

        $syarat_perizinan = new trsyarat_perizinan();
        $data['syarat_izin'] = $syarat_perizinan->where_related($this->perizinan)->order_by('status', 'asc')->get();
        $data['list_daftar'] = $u_daftar;
        //cek Online
//        $this->settings->where('name', 'app_web_service')->get();
//        $statusOnline = $this->settings->status;
        $data['statusOnline'] = 0;

        //cek Online penduduk
//        $this->settings->where('name', 'web_service_penduduk')->get();
//        $statusOnline2 = $this->settings->status;
        $data['statusOnline2'] = 0;

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
                });

                $(document).ready(function() {
                    $('#propinsi_pemohon_id').change(function(){
                        $.post('" . base_url() . "pelayanan/pendaftaran/kabupaten_pemohon', { propinsi_id: $('#propinsi_pemohon_id').val() },
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
                        $.post('" . base_url() . "pelayanan/pendaftaran/kabupaten_usaha', { propinsi_id: $('#propinsi_usaha_id').val() },
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
                    } else {
                        document.form.propinsi_pemohon.disabled = true ;
                        document.form.kabupaten_pemohon.disabled = true ;
                        document.form.kecamatan_pemohon.disabled = true ;
                        document.form.kelurahan_pemohon.disabled = true ;
                    }
                }
            ";

        $this->template->set_metadata_javascript($js);

        $this->load->vars($data);
        if ($id_link == "1") {
            $this->session_info['page_name'] = "Entry data edit";
        } else {
            $this->session_info['page_name'] = "Edit Permohonan Izin Baru";
        }
        $this->template->build('pendaftaran_edit', $this->session_info);
    }

    /*
     * Save and update for manipulating data.
     */

    public function edit_kembali($id_daftar = NULL) {
        $this->username->where('username', $this->session->userdata('username'))->get();
		$lokasi_user = $this->session->userdata('lokasi');

		$u_daftar = $this->pendaftaran->get_by_id($id_daftar);
        $p_pemohon = $u_daftar->tmpemohon->get();
        $p_kelurahan = $p_pemohon->trkelurahan->get();
        $p_kecamatan = $p_pemohon->trkelurahan->trkecamatan->get();
        $p_kabupaten = $p_pemohon->trkelurahan->trkecamatan->trkabupaten->get();
        $p_propinsi = $p_pemohon->trkelurahan->trkecamatan->trkabupaten->trpropinsi->get();

        $kelurahan_lok = $u_daftar->trkelurahan_id;
		$dkelurahan = $this->kelurahan->get_by_id($kelurahan_lok);
		$lok_kecamatan = $dkelurahan->trkecamatan->get();
        $lok_kabupaten = $dkelurahan->trkecamatan->trkabupaten->get();
		$kecamatan_lok = $lok_kecamatan->id;
		$kabupaten_lok = $lok_kabupaten->id;

        $u_perusahaan = $u_daftar->tmperusahaan->get();
        $u_kelurahan = $u_perusahaan->trkelurahan->get();
        $u_kecamatan = $u_perusahaan->trkelurahan->trkecamatan->get();
        $u_kabupaten = $u_perusahaan->trkelurahan->trkecamatan->trkabupaten->get();
        $u_propinsi = $u_perusahaan->trkelurahan->trkecamatan->trkabupaten->trpropinsi->get();
        $u_kegiatan = $u_daftar->tmperusahaan->trkegiatan->get();
        $u_investasi = $u_daftar->tmperusahaan->trinvestasi->get();

        $d_izin = $u_daftar->trperizinan->get();
        $d_kelompok = $d_izin->trkelompok_perizinan->get();
        $d_jenis = $u_daftar->trjenis_permohonan->get();

        $data = $this->_funcwilayah();

        $jml = $this->get_jml_syarat($d_izin->id, 'seri');
		$data['ambil_data'] = FALSE;
        $data['jml_syarat'] = $jml->jml;
        $data['group'] = $this->username->group;
        $data['izin'] = "";
        $data['eror'] = "";
        $data['save_method'] = "update";
        $data['id_daftar'] = $id_daftar;
        $data['paralel'] = "no";
        $paralel_jenis = new trparalel();
        $data['mohon'] = "";
        $data['jenis_paralel'] = $paralel_jenis->get_by_id($u_daftar->c_paralel);
//        $data['id_link'] = $id_link;
        $data['id_link'] = "Pengembalian";
        $data['waktu_awal'] = $this->lib_date->get_date_now();
        $data['no_refer'] = $p_pemohon->no_referensi;
        $data['nama_pemohon'] = $p_pemohon->n_pemohon;
        $data['no_telp'] = $p_pemohon->telp_pemohon;
        $data['cmbsource'] = $p_pemohon->source;
        $data['check_ctr'] = $p_pemohon->cek_prop;
        $data['propinsi_pemohon'] = $p_propinsi->id;
        $data['kabupaten_pemohon'] = $p_kabupaten->id;
        $data['kecamatan_pemohon'] = $p_kecamatan->id;
        $data['kelurahan_pemohon'] = $p_kelurahan->id;

        $data['kabupaten_lok'] = $kabupaten_lok;
        $data['kecamatan_lok'] = $kecamatan_lok;
        $data['kelurahan_lok'] = $kelurahan_lok;
		$data['nkab_lok'] = $lok_kabupaten->n_kabupaten;
        $data['nkec_lok'] = $lok_kecamatan->n_kecamatan;
        $data['nkel_lok'] = $dkelurahan->n_kelurahan;

        $data['jenis_kegiatan'] = $u_kegiatan->id;
        $data['jenis_investasi'] = $u_investasi->id;
        $data['propinsi_usaha'] = $u_propinsi->id;
        $data['kabupaten_usaha'] = $u_kabupaten->id;
        $data['kecamatan_usaha'] = $u_kecamatan->id;
        $data['kelurahan_usaha'] = $u_kelurahan->id;

        $data['tgl_daftar'] = $u_daftar->d_terima_berkas;
        $data['tgl_survey'] = $u_daftar->d_survey;
        $data['lokasi_izin'] = $u_daftar->a_izin;
		$data['rincian_lokasi'] = "";
        $data['keterangan'] = $u_daftar->keterangan;
		$data['cmbgerai'] = $u_daftar->kd_gerai;
		$data['no_antri'] = $u_daftar->no_antri;
		$data['kd_kontak']=$u_daftar->kontak_person;
        $data['alamat_pemohon'] = $p_pemohon->a_pemohon;
        $data['alamat_pemohon_luar'] = $p_pemohon->a_pemohon_luar;

        $data['id_perusahaan'] = $u_perusahaan->id;
        $data['nama_perusahaan'] = $u_perusahaan->n_perusahaan;
        $data['npwp'] = $u_perusahaan->npwp;
        $data['telp_perusahaan'] = $u_perusahaan->i_telp_perusahaan;
        $data['alamat_usaha'] = $u_perusahaan->a_perusahaan;
        $data['nodaftar'] = $u_perusahaan->no_reg_perusahaan;
        $data['fax'] = $u_perusahaan->fax;
        $data['email'] = $u_perusahaan->email;
        $data['rt'] = $u_perusahaan->rt;
        $data['rw'] = $u_perusahaan->rw;
        $data['jenis_izin'] = $this->perizinan->get_by_id($d_izin->id);
        $data['kelompok_izin'] = $this->kelompok_izin->get_by_id($d_kelompok->id);
        $data['jenis_permohonan'] = $this->jenispermohonan->get_by_id($d_jenis->id);
		$data['lokasi_user'] = $lokasi_user;

        $syarat_perizinan = new trsyarat_perizinan();
        $data['syarat_izin'] = $syarat_perizinan->where_related($this->perizinan)->order_by('status', 'asc')->get();
        $data['list_daftar'] = $u_daftar;
        //cek Online
//        $this->settings->where('name', 'app_web_service')->get();
//        $statusOnline = $this->settings->status;
        $data['statusOnline'] = 0;

        //cek Online penduduk
//        $this->settings->where('name', 'web_service_penduduk')->get();
//        $statusOnline2 = $this->settings->status;
        $data['statusOnline2'] = 0;

        $js = "
		        function confirm_link(text){
                    if(confirm(text)){ return true;
                    }else{ return false; }
                }

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
                });

                $(document).ready(function() {
                    $('#propinsi_pemohon_id').change(function(){
                        $.post('" . base_url() . "pelayanan/pendaftaran/kabupaten_pemohon', { propinsi_id: $('#propinsi_pemohon_id').val() },
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
                        $.post('" . base_url() . "pelayanan/pendaftaran/kabupaten_usaha', { propinsi_id: $('#propinsi_usaha_id').val() },
                            function(data) {
                                $('#show_kabupaten_usaha').html(data);
                                $('#show_kecamatan_usaha').html('Data Tidak tersedia');
                                $('#show_kelurahan_usaha').html('Data Tidak tersedia');
                            }
						);
                    });
                });

				$(document).ready(function() {
                    $('#kabupaten_lok_id').change(function(){
                        $.post('" . base_url() . "pelayanan/pendaftaran/kecamatan_lok', { kabupaten_id: $('#kabupaten_lok_id').val() },
                            function(data) {
                                $('#show_kecamatan_lok').html(data);
                                $('#show_kelurahan_lok').html('Data Tidak tersedia');
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

        $this->template->set_metadata_javascript($js);

        $this->load->vars($data);
        $this->session_info['page_name'] = "Pengembalian Berkas Permohonan";
        $this->template->build('pendaftaran_edit', $this->session_info);
    }

    public function save() {   // Simpan Pendaftaran Baru
	    $perizinan = new trperizinan();
        $perizinan->get_by_id($this->input->post('jenis_izin_id'));
        $perizinan_sektor = new trperizinan_trsektor();
		$perizinan_sektor->where('trperizinan_id', $this->input->post('jenis_izin_id'))->get();
        $kd_sektor = $perizinan_sektor->trsektor_id;
        
        $jenis_permohonan = new trjenis_permohonan();
        $jenis_permohonan->get_by_id($this->input->post('jenis_permohonan_id'));

//        var_dump($_POST);
        /*
         * Cek Persyaratan Izin
         */
        $syarat_perizinan = new trsyarat_perizinan();
        $izin_len = $syarat_perizinan->where_related($perizinan)->where('status', 1)->count();
        $syarat_izin = new trsyarat_perizinan();
        $list_syarat = $syarat_izin->where_related($perizinan)->where('status', 1)->get();

        $syarat = $this->input->post('pemohon_syarat');
        $syarat_len = count($syarat);

        // *********** improvement 15 sep *************
        $izin_len = 0;
        $wajib_len = 0;
        foreach ($list_syarat as $data) {
            $show_syarat = new trperizinan_syarat();
            $show_syarat
                    ->where('trsyarat_perizinan_id', $data->id)
                    ->where('trperizinan_id', $perizinan->id)->get();
            $var = $show_syarat->c_show_type;

            $rule = strval(decbin($var));
            if (strlen($rule) < 4) {
                $len = 4 - strlen($rule);
                $rule = str_repeat("0", $len) . $rule;
            }
            $arr_rule = str_split($rule);

            $c_daftar_ulang = $arr_rule[0];
            $c_baru = $arr_rule[1];
            $c_perpanjangan = $arr_rule[2];
            $c_ubah = $arr_rule[3];

            $syarat_status = $c_baru;
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

        //$this->load->library('form_validation');
//
//   //validasi pemohon
//        $this->form_validation->set_rules('nama_pemohon','Nama', 'required');
//        
//        $this->form_validation->set_rules('no_telp','Nomor', 'required');
//        $this->form_validation->set_rules('alamat_pemohon','Alamat', 'required');
//        $this->form_validation->set_rules('propinsi_pemohon','propinsi', 'required');
//        $this->form_validation->set_rules('kabupaten_pemohon','kabupaten', 'required');
//        $this->form_validation->set_rules('kecamatan_pemohon','kecamatan', 'required');
//        $this->form_validation->set_rules('kelurahan_pemohon','kelurahan', 'required');
//        $this->form_validation->set_rules('no_refer','peninjauan', 'required');
//        $this->form_validation->set_rules('tgl_daftar','Tanggal', 'required');
//       
//
//   //validasi perusahaan
//        $this->form_validation->set_rules('npwp','Npwp', 'required');
//        $this->form_validation->set_rules('nodaftar','No Daftar', 'required');
//        $this->form_validation->set_rules('nama_perusahaan','Nama Perusahaan', 'required');
//        $this->form_validation->set_rules('telp_perusahaan','Telp', 'required');
//        $this->form_validation->set_rules('propinsi_usaha','propinsi', 'required');
//        $this->form_validation->set_rules('kabupaten_usaha','kabupaten', 'required');
//        $this->form_validation->set_rules('kecamatan_usaha','kecamatan', 'required');
//        $this->form_validation->set_rules('kelurahan_usaha','kelurahan', 'required');
//        $this->form_validation->set_rules('alamat_usaha','a_usaha', 'required');
//        $this->form_validation->set_rules('jenis_kegiatan','j_kegiatan', 'required');
//        $this->form_validation->set_rules('jenis_investasi','j_investasi', 'required');
        //if ( $izin_len == $wajib_len)
        //{



        /*         * ****** improvement last year **********
          $wajib_len = 0;
          foreach ($list_syarat as $data) {
          $is_array = NULL;
          for ($i = 0; $i < $syarat_len; $i++) {
          if ($is_array !== $syarat[$i]) {
          if ($data->id == $syarat[$i])
          $wajib_len++;
          }
          $is_array = $syarat[$i];
          }
          }
          if ($izin_len !== $wajib_len)
          redirect('pelayanan/pendaftaran/list_index/1');
         */


        /* Penomoran Pendaftaran Awal */
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
				$trperizinan = new trperizinan();
				$trperizinan->update('no_sk_tengah', 0);
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

//        $data_bulan = date("n");
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
//            $nomor_pendaftaran = $data_urut . $data_izin . $data_jenis . $data_bulan . $data_tahun;
//          $data_urut : XXXXX ;$data_izin : XXX ;$data_jenis : XX ;$data_bulan : XX ;$data_tahun : XXXX ;$user_id : XXX;
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
		$permohonan->trkelurahan_id = $this->input->post('kelurahan_lok');
        $permohonan->d_terima_berkas = $this->input->post('tgl_daftar');
		$permohonan->d_terima_berkas_asli = date('Y-m-d');
        $permohonan->d_survey = $this->input->post('tgl_survey');
        $permohonan->a_izin = $this->input->post('lokasi_izin');
        $permohonan->keterangan = $this->input->post('keterangan');
        $permohonan->kd_gerai = $this->input->post('cmbgerai');
		$permohonan->trsektor_id = $kd_sektor;
		$permohonan->no_antri = $this->input->post('no_antri');
		$permohonan->kontak_person = $this->input->post('kd_kontak');

        $tgl_skr = $this->lib_date->get_date_now();
        $permohonan->d_entry = $tgl_skr;

		$tgl_entry = $this->input->post('tgl_daftar');
        $vdurasi_cek = $this->lib_date->hit_durasi($tgl_entry, $perizinan->v_hari);           // Create PBS
		$permohonan->d_selesai_proses = $this->lib_date->set_date($tgl_entry, $vdurasi_cek);  // Create PBS

        $permohonan->save($perizinan);
        /* EOF() Penomoran Pendaftaran Awal */

        $permohonan_akhir = new tmpermohonan();
        $permohonan_akhir->select_max('id')->get();
        //$permohonan_akhir->where('i_urut', $data_urut)->where('d_tahun', $data_tahun)->get();

        /* Input Data Pemohon */
        $pemohon = new tmpemohon();
        if ($this->input->post('id_pemohon')) 
			$pemohon->get_by_id($this->input->post('id_pemohon'));   // jika ditemukan pemohon 
        $pemohon->source = $this->input->post('cmbsource');
        $pemohon->no_referensi = $this->input->post('no_refer');

        $pemohon->n_pemohon = $this->input->post('nama_pemohon');
        $pemohon->telp_pemohon = $this->input->post('no_telp');
        $pemohon->a_pemohon = $this->input->post('alamat_pemohon');
        $pemohon->a_pemohon_luar = $this->input->post('alamat_pemohon_luar');
        $pemohon->cek_prop = "0";
        $kelurahan_p = new trkelurahan();
        $kelurahan_p->get_by_id($this->input->post('kelurahan_pemohon'));

        $pemohon->save(array($permohonan_akhir, $kelurahan_p));


        /* Input Data Index Dokumen */
        if (!$this->input->post('id_pemohon')) {
            $pemohon_akhir = new tmpemohon();
            $pemohon_akhir->select_max('id')->get();
            $inisial = strtoupper(substr($this->input->post('nama_pemohon'), 0, 1));
            $archive_lama = new tmarchive();
            $archive_lama
                    ->where('i_inisial', $inisial)
                    ->order_by('id DESC')
                    ->get();
            if ($archive_lama->id) {
                $archive_lama->get_by_id($archive_lama->id);
                $data_urut_index = $archive_lama->i_urut + 1;
            }else
                $data_urut_index = 1;

            //Nomor Urut Index
            $i_urut_index = strlen($data_urut_index);
            for ($i = 3; $i > $i_urut_index; $i--) {
                $data_urut_index = "0" . $data_urut_index;
            }
            $grup = substr($data_urut_index, 0, 1) + 1;
            $archive = new tmarchive();
            $archive->i_archive = $inisial . $grup . "-" . $data_urut_index;
            $archive->i_inisial = $inisial;
            $archive->i_urut = $data_urut_index;
            $archive->save($pemohon_akhir);
        }

        /* Input Data Perusahaan */
		$nama_perusahaan = $this->input->post('nama_perusahaan');
        if ($this->input->post('nama_perusahaan')) {
            $perusahaan = new tmperusahaan();
            if ($this->input->post('id_perusahaan'))
                $perusahaan->get_by_id($this->input->post('id_perusahaan'));
            $perusahaan->n_perusahaan = $this->input->post('nama_perusahaan');
            $perusahaan->npwp = $this->input->post('npwp');
            $perusahaan->no_reg_perusahaan = $this->input->post('nodaftar');
            $perusahaan->rt = $this->input->post('rt');
            $perusahaan->rw = $this->input->post('rw');
            $perusahaan->fax = $this->input->post('fax');
            $perusahaan->email = $this->input->post('email');
            $perusahaan->i_telp_perusahaan = $this->input->post('telp_perusahaan');
            $perusahaan->a_perusahaan = $this->input->post('alamat_usaha');
            $kelurahan_u = new trkelurahan();
            $kelurahan_u->get_by_id($this->input->post('kelurahan_usaha'));
            $kegiatan = new trkegiatan();
            $kegiatan->get_by_id($this->input->post('jenis_kegiatan'));
            $investasi = new trinvestasi();
            $investasi->get_by_id($this->input->post('jenis_investasi'));
            $perusahaan->save(array($permohonan_akhir, $kelurahan_u, $kegiatan, $investasi));
        }

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
        $g = $this->sql2($u_ser);
//      $jam = date("H:i:s A");
        //$p = $this->db->query("call log ('Pendaftaran','Insert " . $nomor_pendaftaran . "','" . $tgl . "','" . $u_ser . "')");

        redirect('pelayanan/pendaftaran');
    }

    public function save_fo() {   // Simpan Pendaftaran Baru dari FO/CS    (belum digunakan)
        $perizinan = new trperizinan();
        $perizinan->get_by_id($this->input->post('jenis_izin_id'));
        $perizinan_sektor = new trperizinan_trsektor();
		$perizinan_sektor->where('trperizinan_id', $this->input->post('jenis_izin_id'))->get();
        $kd_sektor = $perizinan_sektor->trsektor_id;
        
        $jenis_permohonan = new trjenis_permohonan();
        $jenis_permohonan->get_by_id($this->input->post('jenis_permohonan_id'));

//        var_dump($_POST);
        /*
         * Cek Persyaratan Izin
         */
        $syarat_perizinan = new trsyarat_perizinan();
        $izin_len = $syarat_perizinan->where_related($perizinan)->where('status', 1)->count();
        $syarat_izin = new trsyarat_perizinan();
        $list_syarat = $syarat_izin->where_related($perizinan)->where('status', 1)->get();

        $syarat = $this->input->post('pemohon_syarat');
        $syarat_len = count($syarat);

        // *********** improvement 15 sep *************
        $izin_len = 0;
        $wajib_len = 0;
        foreach ($list_syarat as $data) {
            $show_syarat = new trperizinan_syarat();
            $show_syarat
                    ->where('trsyarat_perizinan_id', $data->id)
                    ->where('trperizinan_id', $perizinan->id)->get();
            $var = $show_syarat->c_show_type;

            $rule = strval(decbin($var));
            if (strlen($rule) < 4) {
                $len = 4 - strlen($rule);
                $rule = str_repeat("0", $len) . $rule;
            }
            $arr_rule = str_split($rule);

            $c_daftar_ulang = $arr_rule[0];
            $c_baru = $arr_rule[1];
            $c_perpanjangan = $arr_rule[2];
            $c_ubah = $arr_rule[3];

            $syarat_status = $c_baru;
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
				$trperizinan = new trperizinan();
				$trperizinan->update('no_sk_tengah', 0);
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

//        $data_bulan = date("n");
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
//            $nomor_pendaftaran = $data_urut . $data_izin . $data_jenis . $data_bulan . $data_tahun;
//          $data_urut : XXXXX ;$data_izin : XXX ;$data_jenis : XX ;$data_bulan : XX ;$data_tahun : XXXX ;$user_id : XXX;
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
        $permohonan->d_terima_berkas = $this->input->post('tgl_daftar');
		$permohonan->d_terima_berkas_asli = date('Y-m-d');
        $permohonan->d_survey = $this->input->post('tgl_survey');
        $permohonan->a_izin = $this->input->post('lokasi_izin');
        $permohonan->keterangan = $this->input->post('keterangan');
        $permohonan->kd_gerai = $this->input->post('cmbgerai');
		$permohonan->trsektor_id = $kd_sektor;
		$permohonan->no_antri = $this->input->post('no_antri');
		$permohonan->kontak_person = $this->input->post('kd_kontak');

        $tgl_skr = $this->lib_date->get_date_now();
        $permohonan->d_entry = $tgl_skr;

		$tgl_entry = $this->input->post('tgl_daftar');
        $vdurasi_cek = $this->lib_date->hit_durasi($tgl_entry, $perizinan->v_hari);           // Create PBS
		$permohonan->d_selesai_proses = $this->lib_date->set_date($tgl_entry, $vdurasi_cek);  // Create PBS

        $permohonan->save($perizinan);
        /* Penomoran Pendaftaran
         * Akhir
         */

        $permohonan_akhir = new tmpermohonan();
        $permohonan_akhir->select_max('id')->get();
        //$permohonan_akhir->where('i_urut', $data_urut)->where('d_tahun', $data_tahun)->get();

        /* Input Data Pemohon */
        $pemohon = new tmpemohon();
        if ($this->input->post('id_pemohon'))
            $pemohon->get_by_id($this->input->post('id_pemohon'));
        $pemohon->source = $this->input->post('cmbsource');
        $pemohon->no_referensi = $this->input->post('no_refer');

        $pemohon->n_pemohon = $this->input->post('nama_pemohon');
        $pemohon->telp_pemohon = $this->input->post('no_telp');
        $pemohon->a_pemohon = $this->input->post('alamat_pemohon');
        $pemohon->a_pemohon_luar = $this->input->post('alamat_pemohon_luar');
//        if ($this->input->post('Check_ctr')) {
        $pemohon->cek_prop = "0";
        $kelurahan_p = new trkelurahan();
        $kelurahan_p->get_by_id($this->input->post('kelurahan_pemohon'));

        $pemohon->save(array($permohonan_akhir, $kelurahan_p));

//        } else {
//            $pemohon->cek_prop = "1";
//            $pemohon->save(array($permohonan_akhir));
//        }

        /* Input Data Index Dokumen */
        if (!$this->input->post('id_pemohon')) {
            $pemohon_akhir = new tmpemohon();
            $pemohon_akhir->select_max('id')->get();
            $inisial = strtoupper(substr($this->input->post('nama_pemohon'), 0, 1));
            $archive_lama = new tmarchive();
            $archive_lama
                    ->where('i_inisial', $inisial)
                    ->order_by('id DESC')
                    ->get();
            if ($archive_lama->id) {
                $archive_lama->get_by_id($archive_lama->id);
                $data_urut_index = $archive_lama->i_urut + 1;
            }else
                $data_urut_index = 1;

            //Nomor Urut Index
            $i_urut_index = strlen($data_urut_index);
            for ($i = 3; $i > $i_urut_index; $i--) {
                $data_urut_index = "0" . $data_urut_index;
            }
            $grup = substr($data_urut_index, 0, 1) + 1;
            $archive = new tmarchive();
            $archive->i_archive = $inisial . $grup . "-" . $data_urut_index;
            $archive->i_inisial = $inisial;
            $archive->i_urut = $data_urut_index;
            $archive->save($pemohon_akhir);
        }

        /* Input Data Perusahaan */
        if ($this->input->post('nama_perusahaan')) {
            $perusahaan = new tmperusahaan();
            if ($this->input->post('id_perusahaan'))
                $perusahaan->get_by_id($this->input->post('id_perusahaan'));
            $perusahaan->n_perusahaan = $this->input->post('nama_perusahaan');
            $perusahaan->npwp = $this->input->post('npwp');
            $perusahaan->no_reg_perusahaan = $this->input->post('nodaftar');
            $perusahaan->rt = $this->input->post('rt');
            $perusahaan->rw = $this->input->post('rw');
            $perusahaan->fax = $this->input->post('fax');
            $perusahaan->email = $this->input->post('email');
            $perusahaan->i_telp_perusahaan = $this->input->post('telp_perusahaan');
            $perusahaan->a_perusahaan = $this->input->post('alamat_usaha');
            $kelurahan_u = new trkelurahan();
            $kelurahan_u->get_by_id($this->input->post('kelurahan_usaha'));
            $kegiatan = new trkegiatan();
            $kegiatan->get_by_id($this->input->post('jenis_kegiatan'));
            $investasi = new trinvestasi();
            $investasi->get_by_id($this->input->post('jenis_investasi'));
            $perusahaan->save(array($permohonan_akhir, $kelurahan_u, $kegiatan, $investasi));
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
        $g = $this->sql2($u_ser);
//      $jam = date("H:i:s A");
        //$p = $this->db->query("call log ('Pendaftaran','Insert " . $nomor_pendaftaran . "','" . $tgl . "','" . $u_ser . "')");

        redirect('pelayanan/pendaftaran');
    }

    public function save_paralel() { // Paralel tidak digunakan di tasikmalaya

        $list_izin_paralel = $this->input->post('list_izin_paralel');

        $paralel_jenis = new trparalel();
        $paralel_id = $this->input->post('jenis_paralel');
//        $paralel_jenis->get_by_id($paralel_id);
//        $perizinan = new trperizinan();
//        $jenis_izin = $perizinan->where_related($paralel_jenis)->get();

        $jenis_permohonan = new trjenis_permohonan();
        $jenis_permohonan->get_by_id($this->input->post('jenis_permohonan_id'));

        /*
         * Cek Persyaratan Izin
         */
        $x = 1;
        $data_izin = 0;
        foreach ($list_izin_paralel as $row) {
            $row_izin = new trperizinan();
            $row_izin->get_by_id($row);
            if ($x == 1)
                $data_izin = $row_izin->id;
            else
                $data_izin = $data_izin . ", " . $row_izin->id;
            $x++;
        }
//        $query = "select distinct(trsyarat_perizinan_id)
//            from trperizinan_trsyarat_perizinan
//            where trperizinan_id IN(".$data_izin.") ";
        $query = "select distinct(A.trsyarat_perizinan_id), B.v_syarat, B.status
        from trperizinan_trsyarat_perizinan as A,
        trsyarat_perizinan as B
        where A.trperizinan_id IN(" . $data_izin . ")
        and A.trsyarat_perizinan_id = B.id
        order by B.status, B.v_syarat ";
        $results = mysql_query($query);
        $izin_len = 0;
        $wajib_len = 0;

        $syarat = $this->input->post('pemohon_syarat');
        $syarat_len = count($syarat);
        while ($rows = mysql_fetch_assoc(@$results)) {
            $syarat_daftar = new trsyarat_perizinan();
            $syarat_daftar->get_by_id($rows['trsyarat_perizinan_id']);
            $var = $show_syarat->c_show_type;

            $rule = strval(decbin($var));
            if (strlen($rule) < 4) {
                $len = 4 - strlen($rule);
                $rule = str_repeat("0", $len) . $rule;
            }
            $arr_rule = str_split($rule);

            $c_daftar_ulang = $arr_rule[0];
            $c_baru = $arr_rule[1];
            $c_perpanjangan = $arr_rule[2];
            $c_ubah = $arr_rule[3];

            $syarat_status = $c_baru;
            if ($syarat_status == '1') {
                $izin_len++;
                $is_array = NULL;
                for ($i = 0; $i < $syarat_len; $i++) {
                    if ($is_array !== $syarat[$i]) {
                        if ($syarat_daftar->id == $syarat[$i])
                            $wajib_len++;
                    }
                    $is_array = $syarat[$i];
                }
            }
        }
        if ($izin_len !== $wajib_len)
            redirect('pelayanan/pendaftaran/list_index/1');

        $data_id = new tmpermohonan();

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

        $data_bulan = date("n");
        $i_bulan = strlen($data_bulan);
        for ($i = 2; $i > $i_bulan; $i--) {
            $data_bulan = "0" . $data_bulan;
        }

        /* Input Data Pemohon */
        $pemohon = new tmpemohon();
        if ($this->input->post('id_pemohon'))
            $pemohon->get_by_id($this->input->post('id_pemohon'));
        $pemohon->no_referensi = $this->input->post('no_refer');
        $pemohon->n_pemohon = $this->input->post('nama_pemohon');
        $pemohon->telp_pemohon = $this->input->post('no_telp');
        $pemohon->a_pemohon = $this->input->post('alamat_pemohon');
        $pemohon->a_pemohon_luar = $this->input->post('alamat_pemohon_luar');
//        if ($this->input->post('Check_ctr')) {
        $pemohon->cek_prop = "0";
        $kelurahan_p = new trkelurahan();
        $kelurahan_p->get_by_id($this->input->post('kelurahan_pemohon'));
        $pemohon->save(array($kelurahan_p));
//        }else
//            $pemohon->cek_prop = "1";

        /* Input Data Perusahaan */
        if ($this->input->post('nama_perusahaan')) {
            $perusahaan = new tmperusahaan();
            if ($this->input->post('id_perusahaan'))
                $perusahaan->get_by_id($this->input->post('id_perusahaan'));
            $perusahaan->n_perusahaan = $this->input->post('nama_perusahaan');
            $perusahaan->npwp = $this->input->post('npwp');
            $perusahaan->no_reg_perusahaan = $this->input->post('nodaftar');
            $perusahaan->rt = $this->input->post('rt');
            $perusahaan->rw = $this->input->post('rw');
			$perusahaan->fax = $this->input->post('fax');
            $perusahaan->email = $this->input->post('email');
            $perusahaan->i_telp_perusahaan = $this->input->post('telp_perusahaan');
            $perusahaan->a_perusahaan = $this->input->post('alamat_usaha');
            $kelurahan_u = new trkelurahan();
            $kelurahan_u->get_by_id($this->input->post('kelurahan_usaha'));
            $kegiatan = new trkegiatan();
            $kegiatan->get_by_id($this->input->post('jenis_kegiatan'));
            $investasi = new trinvestasi();
            $investasi->get_by_id($this->input->post('jenis_investasi'));
        }

        foreach ($list_izin_paralel as $row_paralel) {
            $izin_data = new trperizinan();
            $izin_data->get_by_id($row_paralel);

            /*
              $data_izin = $izin_data->id;
              $i_izin = strlen($data_izin);
              for($i=3;$i>$i_izin;$i--){
              $data_izin = "0".$data_izin;
              }
             *
             */
            $data_izin = "000"; //No Izin Paralel

            $data_jenis = $jenis_permohonan->id;
            $i_izin = strlen($data_jenis);
            for ($i = 2; $i > $i_izin; $i--) {
                $data_jenis = "0" . $data_jenis;
            }

            /* Penomoran Pendaftaran
             */
            $app_folder = new settings();
            $app_folder->where('name', 'app_folder')->get();
            $app_folder = $app_folder->value;
            if ($app_folder === "Bantul") {
                $nomor_pendaftaran = $data_urut . "/"
                        . $data_izin . "/" . $data_jenis . "/"
                        . $data_bulan . "/" . $data_tahun;
            } else {
                $nomor_pendaftaran = $data_urut
                        . $data_izin . $data_jenis
                        . $data_bulan . $data_tahun;
            }

            $permohonan = new tmpermohonan();
            $permohonan->i_urut = $data_urut;
            $permohonan->d_tahun = $data_tahun;
            $permohonan->pendaftaran_id = $nomor_pendaftaran;
            $permohonan->d_terima_berkas = $this->input->post('tgl_daftar');
            $permohonan->d_survey = $this->input->post('tgl_survey');
            $permohonan->a_izin = $this->input->post('lokasi_izin');
            $permohonan->keterangan = $this->input->post('keterangan');
			$permohonan->kd_gerai = $this->input->post('cmbgerai');
			$permohonan->no_antri = $this->input->post('no_antri');
			$permohonan->kontak_person = $this->input->post('kd_kontak');
            $permohonan->c_paralel = $paralel_id; //Status Paralel

            $tgl_skr = $this->lib_date->get_date_now();
            $permohonan->d_entry = $tgl_skr;
            
			$tgl_entry = $this->input->post('tgl_daftar');
            $vdurasi_cek = $this->lib_date->hit_durasi($tgl_entry, $perizinan->v_hari);           // Create PBS
    		$permohonan->d_selesai_proses = $this->lib_date->set_date($tgl_entry, $vdurasi_cek);  // Create PBS

            $permohonan->save($izin_data);

            $permohonan_akhir = new tmpermohonan();
            $permohonan_akhir->select_max('id')->get();
            $permohonan_akhir->save($jenis_permohonan);

            $pemohon->save(array($permohonan_akhir));
            if ($this->input->post('nama_perusahaan'))
                $perusahaan->save(array($permohonan_akhir));

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

            /* Input Data Tracking Progress */
            $tracking_izin = new tmtrackingperizinan();
            $tracking_izin->pendaftaran_id = $nomor_pendaftaran;
            $tracking_izin->status = 'Insert';
            $tracking_izin->d_entry_awal = $this->input->post('waktu_awal');
            $tracking_izin->d_entry = $tgl_skr;
            $sts_izin = new trstspermohonan();
            $sts_izin->get_by_id('2');                //Menerima dan Memeriksa Berkas [Lihat Tabel trstspermohonan()]
            $sts_izin->save($permohonan_akhir);
            $tracking_izin->save($sts_izin);
            $simpan = $tracking_izin->save($permohonan_akhir);
        }

        if ($this->input->post('nama_perusahaan'))
            $perusahaan->save(array($kelurahan_u, $kegiatan, $investasi));

        /* Input Data Index Dokumen */
        if (!$this->input->post('id_pemohon')) {
            $pemohon_akhir = new tmpemohon();
            $pemohon_akhir->select_max('id')->get();
            $inisial = strtoupper(substr($this->input->post('nama_pemohon'), 0, 1));
            $archive_lama = new tmarchive();
            $archive_lama
                    ->where('i_inisial', $inisial)
                    ->order_by('id DESC')
                    ->get();
            if ($archive_lama->id) {
                $archive_lama->get_by_id($archive_lama->id);
                $data_urut_index = $archive_lama->i_urut + 1;
            }else
                $data_urut_index = 1;

            //Nomor Urut Index
            $i_urut_index = strlen($data_urut_index);
            for ($i = 3; $i > $i_urut_index; $i--) {
                $data_urut_index = "0" . $data_urut_index;
            }
            $grup = substr($data_urut_index, 0, 1) + 1;
            $archive = new tmarchive();
            $archive->i_archive = $inisial . $grup . "-" . $data_urut_index;
            $archive->i_inisial = $inisial;
            $archive->i_urut = $data_urut_index;
            $archive->save($pemohon_akhir);
        }

        if (!$simpan) {
            echo '<p>' . $permohonan_akhir->error->string . '</p>';
            $data['eror'] = "Data Anda Belum ";
            redirect('pelayanan/pendaftaran/create');
        } else {
            redirect('pelayanan/pendaftaran');
        }
    }

	public function update() {   // untuk Editing data
	    $r_name = $this->lib_date->get_nama_ori($this->session->userdata('username'));
        $id_link = $this->input->post('id_link');
		$perizinan = new trperizinan();
        $perizinan->get_by_id($this->input->post('jenis_izin_id'));
        $perizinan_sektor = new trperizinan_trsektor();
		$perizinan_sektor->where('trperizinan_id', $this->input->post('jenis_izin_id'))->get();
        $kd_sektor = $perizinan_sektor->trsektor_id;

        /* Cek Persyaratan Izin */
        $syarat_perizinan = new trsyarat_perizinan();
        $izin_len = $syarat_perizinan->where_related($perizinan)->where('status', 1)->count();
        $syarat_izin = new trsyarat_perizinan();
        $list_syarat = $syarat_izin->where_related($perizinan)->where('status', 1)->get();

        $syarat = $this->input->post('pemohon_syarat');
        $syarat_len = count($syarat);

        $wajib_len = 0;
        foreach ($list_syarat as $data) {
            $is_array = NULL;
            for ($i = 0; $i < $syarat_len; $i++) {
                if ($is_array !== $syarat[$i]) {
                    if ($data->id == $syarat[$i])
                        $wajib_len++;
                }
                $is_array = $syarat[$i];
            }
        }
         
        $lampiran_array = NULL;
        $kd_lampiran = '';
        for ($i = 0; $i < $syarat_len; $i++) {
            if ($lampiran_array !== $syarat[$i]) {
                if($i == 0)
            	    $kd_lampiran = $syarat[$i];
  		        else
 			        $kd_lampiran = $kd_lampiran . '^' . $syarat[$i];
            }
            $lampiran_array = $syarat[$i];
        }

        $permohonan = new tmpermohonan();
        $permohonan->get_by_id($this->input->post('id_daftar'));
		$no_pendaftaran = $permohonan->pendaftaran_id;
		$permohonan->trkelurahan_id = $this->input->post('kelurahan_lok');
        $permohonan->d_terima_berkas = $this->input->post('tgl_daftar');
        $permohonan->d_survey = $this->input->post('tgl_survey');
        $permohonan->a_izin = $this->input->post('lokasi_izin');
        $permohonan->keterangan = $this->input->post('keterangan');
        $permohonan->kd_gerai = $this->input->post('cmbgerai');
		$permohonan->trsektor_id = $kd_sektor;
		$permohonan->no_antri = $this->input->post('no_antri');
		$permohonan->kontak_person = $this->input->post('kd_kontak');

		If($id_link == "Pengembalian") {
		    $permohonan->syarat_arsip = $kd_lampiran;                          // simpan u/ persyaratan izin wajib dan tidak wajib (dlm syarat perizinan) ada atau tidak
		}

		// menghitung Durasi 
        $tgl_entry = $this->input->post('tgl_daftar');
        $vdurasi_cek = $this->lib_date->hit_durasi($tgl_entry, $perizinan->v_hari);           // Create PBS
		$permohonan->d_selesai_proses = $this->lib_date->set_date($tgl_entry, $vdurasi_cek);  // Create PBS
		$permohonan->tmpemohon->get();
        $permohonan->tmperusahaan->get();

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
//        if ($this->input->post('Check_ctr')) {
        $pemohon->cek_prop = "0";
        $kelurahan_p = new trkelurahan();
        $kelurahan_p->get_by_id($this->input->post('kelurahan_pemohon'));
        $pemohon->save(array($kelurahan_p));
//        } else {
//            $pemohon->cek_prop = "1";
//            $pemohon->save();
//        }

        /* Input Data Perusahaan */
        if ($permohonan->tmperusahaan->id) { // jika ada Update
            $perusahaan = new tmperusahaan();
            $perusahaan->get_by_id($permohonan->tmperusahaan->id);
            $perusahaan->n_perusahaan = $this->input->post('nama_perusahaan');
            $perusahaan->npwp = $this->input->post('npwp');
            $perusahaan->no_reg_perusahaan = $this->input->post('nodaftar');
            $perusahaan->rt = $this->input->post('rt');
            $perusahaan->rw = $this->input->post('rw');
            $perusahaan->fax = $this->input->post('fax');
            $perusahaan->email = $this->input->post('email');
            $perusahaan->i_telp_perusahaan = $this->input->post('telp_perusahaan');
            $perusahaan->a_perusahaan = $this->input->post('alamat_usaha');
            $perusahaan->trkelurahan->get();
            //$perusahaan->save();

   			$perusahaan_lurah = new tmperusahaan_trkelurahan();
			$perusahaan_lurah->where('tmperusahaan_id', $permohonan->tmperusahaan->id)->get();
            $perusahaan_lurah->delete();
            $kelurahan_u = new trkelurahan();
            $kelurahan_u->get_by_id($this->input->post('kelurahan_usaha'));

			$perusahaan_kegiatan = new tmperusahaan_trkegiatan();
            $perusahaan_kegiatan->where('tmperusahaan_id', $this->input->post('id_perusahaan'))->get();
            $perusahaan_kegiatan->delete();
            $kegiatan = new trkegiatan();
            $kegiatan->get_by_id($this->input->post('jenis_kegiatan'));

			$perusahaan_investasi = new tmperusahaan_trinvestasi();
            $perusahaan_investasi->where('tmperusahaan_id', $this->input->post('id_perusahaan'))->get();
            $perusahaan_investasi->delete();
            $investasi = new trinvestasi();
            $investasi->get_by_id($this->input->post('jenis_investasi'));
            $perusahaan->save(array($permohonan, $kelurahan_u, $kegiatan, $investasi));

//			$perusahaan_lurah = new tmperusahaan_trkelurahan();
//            $perusahaan_lurah->where('tmperusahaan_id', $permohonan->tmperusahaan->id)
//                             ->update(array('trkelurahan_id' => $this->input->post('kelurahan_usaha')));

//			$perusahaan_kegiatan = new tmperusahaan_trkegiatan();
//            $perusahaan_kegiatan->where('tmperusahaan_id', $this->input->post('id_perusahaan'))
//                                ->update(array('trkegiatan_id' => $this->input->post('jenis_kegiatan')));
            
//			$perusahaan_investasi = new tmperusahaan_trinvestasi();
//            $perusahaan_investasi->where('tmperusahaan_id', $this->input->post('id_perusahaan'))
//                                 ->update(array('trinvestasi_id' => $this->input->post('jenis_investasi')));

        } else { // jika tidak ada buat baru
            if ($this->input->post('nama_perusahaan')) {
                $perusahaan = new tmperusahaan();
                $perusahaan->n_perusahaan = $this->input->post('nama_perusahaan');
                $perusahaan->npwp = $this->input->post('npwp');
                $perusahaan->no_reg_perusahaan = $this->input->post('nodaftar');
                $perusahaan->rt = $this->input->post('rt');
                $perusahaan->rw = $this->input->post('rw');
				$perusahaan->fax = $this->input->post('fax');
                $perusahaan->email = $this->input->post('email');
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
        if($id_link == "Pengembalian") {
		    $kd_lampiran = 'Pengembalian';
		} else {
			$kd_lampiran = 'Editing';

            /* Hapus Data Syarat Perizinan Lama */
			$syarat_old = new tmpermohonan_trsyarat_perizinan();
            $list_syarat = $syarat_old->where('tmpermohonan_id', $this->input->post('id_daftar'))->get();
            foreach ($list_syarat as $row){
                $syarat_old->where('id', $row->id)->get();
    			if($row->tmpermohonan_id == $this->input->post('id_daftar')) {
                    $syarat_old->delete();
		    	}
            }

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
		}

        /* Input Data Tracking Progress */
        $id_link = $this->input->post('id_link');
//        if (!$id_link == '1' || $id_link == "Pengembalian") {
            $status_izin = $permohonan->trstspermohonan->get();
            if (!$id_link == '1') 
			    $status_skr = "2";                                         //Menerima dan Memeriksa Berkas [Lihat Tabel trstspermohonan()]
            else                                                        
			    $status_skr = "3";                                         //Edit di Pelayanan / Entri Data [Lihat Tabel trstspermohonan()]

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
                //$tracking_izin->status = 'Update';
                //$tracking_izin->d_entry = $this->lib_date->get_date_now();
				// PBS merekam history yang pernah mengubah data 
				$hit_ubah = $tracking_izin->hit_ubah + 1;
   				$his_ubah = $tracking_izin->his_ubah;
    			$tracking_izin->hit_ubah = $hit_ubah;
				if($id_link == "Pengembalian") {
    				$tracking_izin->his_ubah = $his_ubah.'Ditolak FO^'.$r_name.'^'.$this->lib_date->get_date_now().';';
					$tracking_izin->d_entry = $this->lib_date->get_date_now();
                } else {
                    if (!$id_link == '1')
                        $tracking_izin->his_ubah = $his_ubah.'ADM^'.$r_name.'^'.$this->lib_date->get_date_now().';';
					else
					    $tracking_izin->his_ubah = $his_ubah.'PEL.EDIT^'.$r_name.'^'.$this->lib_date->get_date_now().';';
				}
                $tracking_izin->save();
            } else {                                                       //Edit di Pelayanan / Entri Data [Lihat Tabel trstspermohonan()]
			    if($id_link == "Pengembalian") {
                    $tr_activiti = 'Front Office';
					$n_sts = 'Ditolak FO';
				} else {
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
//        }

//        if ($update) {
//            if ($id_link == '1')
//                redirect('pendataan');
//            else
//                redirect('pelayanan/pendaftaran');
//        }
//$this->load->library('form_validation');
//         //validasi pemohon
//        $this->form_validation->set_rules('nama_pemohon','Nama', 'required');
//        
//        $this->form_validation->set_rules('no_telp','Nomor', 'required');
//        $this->form_validation->set_rules('alamat_pemohon','Alamat', 'required');
//        $this->form_validation->set_rules('propinsi_pemohon','propinsi', 'required');
//        $this->form_validation->set_rules('kabupaten_pemohon','kabupaten', 'required');
//        $this->form_validation->set_rules('kecamatan_pemohon','kecamatan', 'required');
//        $this->form_validation->set_rules('kelurahan_pemohon','kelurahan', 'required');
//        $this->form_validation->set_rules('no_refer','peninjauan', 'required');
//        $this->form_validation->set_rules('tgl_daftar','Tanggal', 'required');
//       
//
//   //validasi perusahaan
//        $this->form_validation->set_rules('npwp','Npwp', 'required');
//        $this->form_validation->set_rules('nodaftar','No Daftar', 'required');
//        $this->form_validation->set_rules('nama_perusahaan','Nama Perusahaan', 'required');
//        $this->form_validation->set_rules('telp_perusahaan','Telp', 'required');
//        $this->form_validation->set_rules('propinsi_usaha','propinsi', 'required');
//        $this->form_validation->set_rules('kabupaten_usaha','kabupaten', 'required');
//        $this->form_validation->set_rules('kecamatan_usaha','kecamatan', 'required');
//        $this->form_validation->set_rules('kelurahan_usaha','kelurahan', 'required');
//        $this->form_validation->set_rules('alamat_usaha','a_usaha', 'required');
//        $this->form_validation->set_rules('jenis_kegiatan','j_kegiatan', 'required');
//        $this->form_validation->set_rules('jenis_investasi','j_investasi', 'required');
//
        //if ($izin_len == $wajib_len)
        //{
        $update = $permohonan->save();
        $tgl = date("Y-m-d H:i:s");
        $u_ser = $this->session->userdata('username');
        $g = $this->sql2($u_ser);
//      $jam = date("H:i:s A");
        //$p = $this->db->query("call log ('Pendaftaran','Update " . $permohonan->pendaftaran_id . "','" . $tgl . "','" . $u_ser . "')");

        if ($id_link == '1') {
            redirect('pendataan/index_next');
        } else {
			If($id_link == "Pengembalian") {
                redirect('pelayanan/pendaftaran/pengembalian/'.$this->input->post('id_daftar'));
			} else {
                redirect('pelayanan/pendaftaran');
			}
        }

        // }
//             else
//        {
//
//           $this->edit2();
//        }
    }

    public function selesai($id_daftar = NULL) {
	
    #
    #   CODE UNTUK TRACKING DATA DI WEB PENGENDALIAN
    #
    $text_query = "INSERT INTO table_non_spipise values('','$_POST[idpermo]','$_POST[idizin]','$_POST[idkab]',null,null,'0')";
    $this->db->query($text_query);
      #
      #    END OF NEW CODE
      #

	
	//kondisi tracking ini digunakan juga persis di program /pelayanan/control/sementara.php untuk permohonan Online (harus sesuai)
        $u_ser = $this->session->userdata('username');
		$r_name = $this->lib_date->get_nama_ori($u_ser);
		
        $permohonan = new tmpermohonan();
        $permohonan->get_by_id($id_daftar);
        $permohonan->c_pendaftaran = 1;
		$permohonan->kd_status = 1;    // status: Kirim ke pelayanan dan belum di entry
		
		$data_permohonan = $this->db->get_where("tmpermohonan",array("id"=>$id_daftar))->first_row();
		$no_pendaftaran = $permohonan->pendaftaran_id;
		$kd_gerai = $permohonan->kd_gerai;
		$kd_sektor = $permohonan->trsektor_id;

        //$sts_izin = new trstspermohonan();
        //$sts_izin->get_by_id('2');      //Menerima dan Memeriksa Berkas [Lihat Tabel trstspermohonan()]
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
        $tracking_izin = new tmtrackingperizinan();
//        $tracking_izin->get_by_id($tracking_id);
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

//      $tracking_izin->save($sts_izin);
//      $tracking_izin->save($permohonan);
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
		
		//BKPM Integrasi	
		if($kd_sektor == 12){ // khusus izin bidang bkpm sementara off karena proses lama
    		//$this->load->library('SendData');          
	    	//$this->senddata->SendData($id_daftar,"1");
		}
		//BKPM Integrasi
		//EOF() kondisi tracking ini digunakan juga persis di program /pelayanan/control/sementara.php untuk permohonan Online (harus sesuai)

		// Pengiriman Notifikasi ke Pengolah / Koordinator Layanan 
		//$this->perizinan->
//        $telp = '';
//        $email = '';
//        $n_izin = '';

//        $this->settings->where('name', 'smsGateway')->get();
//        $isi = "BPMPT:Info Izin dg no: ".$no_pendaftaran." Tgl:".$permohonan->d_terima_berkas." Izin:".$n_izin  ;
//        if($this->settings->status == 1){
			//Kirim SMS
//    		$gammu	= $this->load->database('gammu', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
//	    	$data = array(
//		       'DestinationNumber'	=> $telp,
//		       'TextDecoded'		=> "BPMPT: ".$isi,
		       // 'CreatorID' 			=> "Gammu",
//		    );
//		    $gammu->insert('outbox',$data);
	    
		    //Kirim E-Mail
//		    $this->settings->where('name', 'send_mail')->get();
//			$host			  =	"smtp.gmail.com";
//			$emailpengirim	  =	"bpmpttasikmalaya@gmail.com";
//			$namapengirim	  =	"BPMPT tasikmalaya";
//			$password		  =	"bpmpttasikmalayakabgoid";
//			$targetpengiriman =	$email;
			
//			require("".$base_url."assets/plugins/phpmailer/class.phpmailer.php");
//			require("".$base_url."assets/plugins/phpmailer/class.smtp.php");
//			$mailer = new PHPMailer();
//			$mailer->CharSet = "UTF-8";
//			$mailer->IsSMTP();
			
//			$mailer->SMTPSecure = 'tls';
//			$mailer->Host =$host;
//			$mailer->Port =587;
//			$mailer->SMTPAuth = true;

//			$mailer->Username = $emailpengirim;
//			$mailer->Password = $password;
//			$mailer->FromName = $namapengirim;
//			$mailer->From = $emailpengirim;
//			$mailer->AddAddress($targetpengiriman,$targetpengiriman);

//			$mailer->Subject = 'Token Pendaftaran Akun BPMPT Tasikmalaya';
			
//			$isi .= "<p>Terima kasih atas perhatiannya<br>BPMPT TASIKMALAYA</p>";
			
//			$mailer->Body = $isi;
//			$mailer->AltBody = $isi;
			
//			$mailer->Send();
//		}
		//EOF() Pengiriman Notifikasi ke Pengolah / Koordinator Layanan

        redirect('pelayanan/pendaftaran');
    }

    public function coba_kirim($uid = NULL) {
		$this->load->library('SendData');
    	$this->senddata->SendData($uid,"2");
		//redirect('monitoring/perketegori_tertentu');
    }    

    public function delete($uid = NULL) {
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
        $g = $this->sql2($u_ser);
        $nomor = $permohonan->where('id', $permohonan->id)->get();
//      $jam = date("H:i:s A");
        //$p = $this->db->query("call log ('Pendaftaran','Delete " . $nomor->pendaftaran_id . "','" . $tgl . "','" . $u_ser . "')");

        //Delete Permohonan
        $permohonan->delete();

        redirect('pelayanan/pendaftaran');
    }

	public function pengembalian($uid = NULL) {

        $tgl = date("Y-m-d H:i:s");
		$u_ser = $this->session->userdata('username');
		$r_name = $this->lib_date->get_nama_ori($u_ser);

        $permohonan = new tmpermohonan();
        $permohonan->get_by_id($uid);
        $id_status = "14";

        // Ubah menjadi penolakan izin
        $permohonan_stspermohonan = new tmpermohonan_trstspermohonan();
        $permohonan_stspermohonan->where('tmpermohonan_id',$uid)->get();
        if($permohonan_stspermohonan->where('tmpermohonan_id',$uid) >= '1'){
            $permohonan_stspermohonan->trstspermohonan_id = $id_status;
            $permohonan_stspermohonan->save();
		}

		// penyimpanan tracking ada pada proses update

        $data_tahun = date("Y");

   		$permohonan->status_berkas = 'Izin Ditolak FO';
		$permohonan->c_pendaftaran = '1';
        $permohonan->save();

        $g = $this->sql($u_ser);
        //$p = $this->db->query("call log ('Penolakan Izin FO','Penolakan Izin FO ".$permohonan->pendaftaran_id."','".$tgl."','".$u_ser."')");

        redirect('pelayanan/pendaftaran');
    }

    public function cetak_bukti($id_daftar = NULL) {
		$r_name = $this->lib_date->get_nama_ori($this->session->userdata('username'));
        $nama_surat = "cetak_bukti";
        $this->settings = new settings();
        $this->settings->where('name', 'app_folder')->get();
        $app_folder = $this->settings->value . "/";
        $app_city = $this->settings->where('name', 'app_city')->get();

        $pegawai = new tmpegawai();
        $pegawai->get_by_id('2');
        $nama = $pegawai->n_pegawai;
		$jabatan = $pegawai->n_jabatan ;
		$nip = $pegawai->nip;

        $permohonan = new tmpermohonan();
        $permohonan->get_by_id($id_daftar);
		$no_pendaftaran = $permohonan->pendaftaran_id;
        $pemohon = $permohonan->tmpemohon->get();
        $pendaftaran_id = $permohonan->pendaftaran_id;
        $p_kelurahan = $pemohon->trkelurahan->get();
        $p_kecamatan = $pemohon->trkelurahan->trkecamatan->get();
        $p_kabupaten = $pemohon->trkelurahan->trkecamatan->trkabupaten->get();
        $usaha = $permohonan->tmperusahaan->get();
        
		$lok_kel = new trkelurahan();
		$lok_kel = $lok_kel->get_by_id($permohonan->trkelurahan_id);
        $lok_kec = $lok_kel->trkecamatan->get();
        $lok_kab = $lok_kel->trkecamatan->trkabupaten->get();
        
		/* Input Data Tracking Progress */
        $status_izin = $permohonan->trstspermohonan->get();
        $status_skr = "2";                     //Menerima dan Memeriksa Berkas [Lihat Tabel trstspermohonan()]
        if ($status_izin->id == $status_skr) {
            $tracking_izin = new tmtrackingperizinan();
            $tracking_izin->where('pendaftaran_id', $no_pendaftaran)
                          ->where('tr_activiti', 'Front Office')->get();
            // PBS merekam history yang pernah mengubah data 
			if($tracking_izin->pendaftaran_id){
			    $hit_cetak = $tracking_izin->hit_cetak + 1;
			    $his_cetak = $tracking_izin->his_cetak;
			    $tracking_izin->hit_cetak = $hit_cetak;
			    $tracking_izin->his_cetak = $his_cetak.'ADM^'.$r_name.'^'.$this->lib_date->get_date_now().';';
                $tracking_izin->save();
			}
        }

        //Tampilkan Jenis Izin
        $paralel_jenis = new trparalel();
        $paralel_id = $permohonan->c_paralel;
        $paralel_jenis->get_by_id($paralel_id);
        $perizinan = new trperizinan();
        $x = 1;
        if ($paralel_id == 0) {
            $jenis_izin = $perizinan->where_related($permohonan)->get();
            foreach ($jenis_izin as $row) {
                if ($x == 1)
                    $data_izin = $row->n_perizinan;
                else
                    $data_izin = $data_izin . ", " . $row->n_perizinan;
                $x++;
            }
        }else {
            $data_tahun = date("Y");
            $permohonan_paralel = new tmpermohonan();
            $permohonan_paralel->where('pendaftaran_id', $permohonan->pendaftaran_id)->get();
            foreach ($permohonan_paralel as $row) {
                $jenis_izin = $perizinan->where_related($row)->get();
                if ($x == 1)
                    $data_izin = $jenis_izin->n_perizinan;
                else
                    $data_izin = $data_izin . ", " . $jenis_izin->n_perizinan;
                $x++;
            }
        }

        //Tampilkan Kode Gerai
		$tampil_gerai = $permohonan->kd_gerai;
		$cekkota = $permohonan->kd_gerai;
		$nkota = "";
		if ($permohonan->kd_gerai == 'Pusat')$nkota = "SUMEDANG";
		if ($permohonan->kd_gerai === 'DPMPTSP Prov. tasikmalaya' || $permohonan->kd_gerai === 'BPMPT Prov. tasikmalaya' || $permohonan->kd_gerai === 'BPPT Prov. tasikmalaya') $nkota = "TASIKMALAYA";
		if ($permohonan->kd_gerai == 'OnLine')$nkota = "TASIKMALAYA";
		if ($permohonan->kd_gerai === 'Gerai Cirebon')$nkota = "CIREBON";
		if ($permohonan->kd_gerai === 'Gerai Garut')$nkota = "GARUT";
		if ($permohonan->kd_gerai === 'Gerai Purwakarta')$nkota = "PURWAKARTA";
		if ($permohonan->kd_gerai === 'Gerai Bogor')$nkota = "BOGOR";

        //Tampilkan Kontak Person
		$tampil_kontakperson = $permohonan->kontak_person;

		//Tampilkan Tgl Daftar
        if ($permohonan->d_terima_berkas) {
            if ($permohonan->d_terima_berkas != '0000-00-00')
                $tgl_daftar = $this->lib_date->mysql_to_human($permohonan->d_terima_berkas);
            else 
                $tgl_daftar = "";
        }else
            $tgl_daftar = "";

        //Tampilkan Tgl Selesai
        if ($permohonan->d_selesai_proses) {
            if ($permohonan->d_selesai_proses != '0000-00-00')
                $tgl_selesai = $this->lib_date->mysql_to_human($permohonan->d_selesai_proses);
            else
                $tgl_selesai = "";
        }else
            $tgl_selesai = "";

		//NEW BARCODE
		//$font = new BCGFontFile('./www/libraries/font/Arial.ttf', 10);
        //$text = isset($_GET['text']) ? $_GET['text'] : $pendaftaran_id;
        //// The arguments are R, G, B for color.
        //$color_black = new BCGColor(0, 0, 0);
        //$color_white = new BCGColor(255, 255, 255);
        //$drawException = null;
        //try {$code = new BCGcode128();
        //     $code->setScale(2); // Resolution
        //     $code->setThickness(30); // Thickness
        //     $code->setForegroundColor($color_black); // Color of bars
        //     $code->setBackgroundColor($color_white); // Color of spaces
        //     $code->setFont(0); // $font or 0
        //     $code->parse($text); // Text
        //    }
		//catch(Exception $exception) {$drawException = $exception;}
        /* Here is the list of the arguments 1-Filename (empty : display on screen) 2 - Background color */
        //$drawing = new BCGDrawing('assets/barcode/' . $id_daftar . '.png', $color_white);
        //if($drawException) {
        //    $drawing->drawException($drawException);
        //} else {
        //    $drawing->setBarcode($code);
        //    $drawing->draw();
        //}
        //$drawing->finish(BCGDrawing::IMG_FORMAT_PNG);
        //EOF() NEW BARCODE

		//Create QRCode
		$nama = $pemohon->n_pemohon;
		if($usaha->n_perusahaan != '') $nama = $pemohon->n_pemohon.' / '.$usaha->n_perusahaan;
		
		$kontak = $pemohon->telp_pemohon;
		if($permohonan->kontak_person >= 1) $kontak = $pemohon->telp_pemohon.' / '.$permohonan->kontak_person;
		
		include('./assets/qrcode/qrlib.php');
        $tempDir = 'uploads/data_qrcode/';//EXAMPLE_TMP_SERVERPATH;
        $codeContents = 'ID. '.$permohonan->pendaftaran_id.
			            ' Nama: '.$nama.
			            ' Kontak: '.$kontak.
			            ' Permohonan: '.$data_izin.
			            ' Tgl Daftar: '.$tgl_daftar;
        $fileName = 'resi_'.md5($codeContents).'.png';
        $pngAbsoluteFilePath = $tempDir.$fileName;
        $urlRelativeFilePath = base_url().$tempDir.$fileName; //EXAMPLE_TMP_URLRELPATH.$fileName;
        
        if (!file_exists($tempDir)) { #kalau folder belum ada, maka buat.
            mkdir($tempDir);
        } 

		$create_file = FALSE;
		if (!file_exists($pngAbsoluteFilePath)) {  # jika file tidak ada
		    $create_file = TRUE;
		    //QRcode::png($codeContents, $pngAbsoluteFilePath);
            $quality = 'H'; //ada 4 pilihan, L (Low), M(Medium), Q(Good), H(High)
            $ukuran = 5;    //batasan 1 paling kecil, 10 paling besar
            $padding = 0;
            QRCode::png($codeContents,$tempDir.$fileName,$quality,$ukuran,$padding);
		}
		//EOF() Create QRCode

        //path of the template file
        $this->load->plugin('odf');
        $odf = new odf('assets/odt/' . $nama_surat . '.odt');

        //logo
        $this->tr_instansi = new Tr_instansi();
        $logo = $this->tr_instansi->get_by_id(23);
        if($logo->value!=="") {
            $odf->setImage('logo', 'uploads/logo/' . $logo->value, '3', '2');
        } else {
            $odf->setVars('logo', ' ');
        } 
        
		$sektor = $permohonan->trsektor_id;
		$odf->setImage('bebas_biaya', 'uploads/logo/BebasBiaya.png', '4', '1.2');
		if($sektor == '10' || $sektor == '11'){   // jika perhubungan dan perikanan
		    $odf->setVars('bebas_biaya', '');
        }

		//pemerintah 
        $this->tr_instansi = new Tr_instansi();
        $nama_prov = $this->tr_instansi->get_by_id(17);
        $odf->setVars('provinsi', strtoupper($nama_prov->value));

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

		//e-mail
        $this->tr_instansi = new Tr_instansi();
        $web = $this->tr_instansi->get_by_id(21);
        $odf->setVars('web', $web->value);

		//e-mail
        $this->tr_instansi = new Tr_instansi();
        $e_mail = $this->tr_instansi->get_by_id(22);
        $odf->setVars('email', $e_mail->value);

        //Kop Kota
        $this->tr_instansi = new Tr_instansi();
        $kop_kota = $this->tr_instansi->get_by_id(19);
        $odf->setVars('k_kota', $kop_kota->value);

        //Kode Pos
        $this->tr_instansi = new Tr_instansi();
        $kode_pos = $this->tr_instansi->get_by_id(20);
        $odf->setVars('kd_pos', $kode_pos->value);
        //$odf->setImage('barcode', 'assets/barcode/' . $id_daftar . '.png', '5.0', '1.0');
        $odf->setImage('barcode', $pngAbsoluteFilePath, '2.0', '2.0');       //qrcode
        $odf->setVars('gerai', $tampil_gerai);

        switch(date("n")) {
            case "1" : $kd_bulan = 'I';    break;
            case "2" : $kd_bulan = 'II';   break;
			case "3" : $kd_bulan = 'III';  break;
			case "4" : $kd_bulan = 'IV';   break;
			case "5" : $kd_bulan = 'V';    break;
			case "6" : $kd_bulan = 'VI';   break;
			case "7" : $kd_bulan = 'VII';  break;
			case "8" : $kd_bulan = 'VIII'; break;
			case "9" : $kd_bulan = 'IX';   break;
			case "10": $kd_bulan = 'X';    break;
			case "11": $kd_bulan = 'XI';   break;
			case "12": $kd_bulan = 'XII';  break;
        }

		//=================================================
        $username = new user();
        $username->where('username', $this->session->userdata('username'))->get();
        if ($username->id)
            $user = $username->realname;
        else
            $user = "................................";

        $odf->setVars('user', $user);
        $wilayah = new trkabupaten();
        if ($app_city->value !== '0') {
            if ($pemohon->cek_prop == "1")
                $alamat = $pemohon->a_pemohon;
            else
                $alamat = $pemohon->a_pemohon . ' ' . $p_kelurahan->n_kelurahan . ', ' . $p_kecamatan->n_kecamatan . ', ' . ucwords(strtolower($p_kabupaten->n_kabupaten));
            $wilayah->get_by_id($app_city->value);
            //$odf->setVars('kabupaten', ucwords(strtolower($wilayah->n_kabupaten)));
            $odf->setVars('kota', ucwords(strtolower($wilayah->ibukota)));
        }else {
            $alamat = $pemohon->a_pemohon;
            //$odf->setVars('kabupaten', 'setempat');
            $odf->setVars('kota', $nkota);
        }

        //kota4
        $gede_kota = strtoupper($wilayah->n_kabupaten);
        $kecil_kota = ucwords(strtolower($wilayah->n_kabupaten));
        $odf->setVars('kota4', 'Tasikmalaya');

        //alamat
        $this->tr_instansi = new Tr_instansi();
        $alamat = $this->tr_instansi->get_by_id(12);
        $odf->setVars('alamat', ucwords(strtolower($alamat->value)) . ' - ' . $kecil_kota);

        $tgl_skr = $this->lib_date->get_date_now();
        $odf->setVars('tglskr', $this->lib_date->mysql_to_human($tgl_skr));
        $daftar = new tmpermohonan();
        $daftar->get_by_id($id_daftar);
        $daftar->d_bukti = $tgl_skr;
		if($create_file) $daftar->file_pendaftaran = $daftar->file_pendaftaran.'^'.$fileName;
        $daftar->save();
		
        if($lok_kel->n_kelurahan == '-') $lok_kel = ''; else $lok_kel = 'Kel/Ds. '.ucwords(strtolower($lok_kel->n_kelurahan));
		if($lok_kec->n_kecamatan == '-') $lok_kec = ''; else $lok_kec = '; Kec. '.ucwords(strtolower($lok_kec->n_kecamatan));
		if($lok_kab->n_kabupaten == '-') $lok_kab = ''; else $lok_kab = '; '.ucwords(strtolower($lok_kab->n_kabupaten));
		$lokasi = $lok_kel . $lok_kec . $lok_kab;
        $lokasi = ltrim($lokasi,'; ');
        $listeArticles = array(
            array('property' => 'Nomor', 'content' => $permohonan->pendaftaran_id,),
            array('property' => 'Nama/Perusahaan', 'content' => $nama,),
            array('property' => 'Alamat Pemohon', 'content' => $pemohon->a_pemohon,),
            array('property' => 'No. Telp/HP', 'content' => $pemohon->telp_pemohon, ),
			array('property' => 'Kontak Person', 'content' => $permohonan->kontak_person, ),
            array('property' => 'Jenis Izin', 'content' => $data_izin, ),
            array('property' => 'Objek Izin', 'content' => $permohonan->a_izin,),
            array('property' => 'Lokasi', 'content' => $lokasi,),
            array('property' => 'Tgl Daftar', 'content' => $tgl_daftar, ),
            array('property' => 'Tgl Selesai', 'content' => $tgl_selesai . ' *)', ),
            array('property' => 'Keterangan', 'content' => $permohonan->keterangan, ),
        );
		if($lokasi == '') unset($listeArticles[7]);
        $article = $odf->setSegment('articles');
        foreach ($listeArticles AS $element) {
            $article->titreArticle($element['property']);
            $article->texteArticle($element['content']);
            $article->merge();
        }
        $odf->mergeSegment($article);

        $tgl = date("Y-m-d H:i:s");
        $u_ser = $this->session->userdata('username');
        $g = $this->sql2($u_ser);
//      $jam = date("H:i:s A");
        //$p = $this->db->query("call log ('Pendaftaran','Cetak " . $permohonan->pendaftaran_id . "','" . $tgl . "','" . $u_ser . "')");

        //export the file
        $no_daftar = str_replace('/', '', $permohonan->pendaftaran_id);
        $odf->exportAsAttachedFile($nama_surat . '_' . $no_daftar . '.odt');

        //unlink('assets/barcode/' . $id_daftar . '.png');
    }

    function _funcwilayah() {
		$data['list_propinsi'] = $this->propinsi->order_by('n_propinsi', 'ASC')->get();
        $data['list_kabupaten'] = $this->kabupaten->order_by('n_kabupaten', 'ASC')->get();
        $data['list_kabupaten_lok'] = $this->kabupaten->where('kd_prov', '12')->order_by('n_kabupaten', 'ASC')->get();   // 12 untuk Tasikmalaya
        $data['list_kecamatan'] = $this->kecamatan->order_by('n_kecamatan', 'ASC')->get();
        $data['list_kelurahan'] = $this->kelurahan->order_by('n_kelurahan', 'ASC')->get();
        $data['list_kegiatan'] = $this->kegiatan->order_by('n_kegiatan', 'ASC')->get();
        $data['list_investasi'] = $this->investasi->order_by('n_investasi', 'ASC')->get();
        return $data;
    }

    function get_id($idkab) {
        $sql = "select a.n_kabupaten, trpropinsi_id  from trkabupaten as a 
                inner join trkabupaten_trpropinsi as b ON b.trkabupaten_id = a.id
                where a.id  = '" . $idkab . "' ";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function kabupaten_pemohon() {    // masuk setelah pilih Provinsi => data pemohon
        $data['kabupaten_id'] = 'kabupaten_pemohon';
        $data['kecamatan_id'] = 'kecamatan_pemohon';
        $data['kelurahan_id'] = 'kelurahan_pemohon';
        $data['kelurahan_link'] = 'kelurahan_pemohon_idKab';
        $this->load->vars($data);
        $this->load->view('kabupaten_load', $data);
    }

	public function kecamatan_pemohon() {    // Masuk setelah pilih Kabupaten => data pemohon
        $data['kecamatan_id'] = 'kecamatan_pemohon';
        $data['kelurahan_id'] = 'kelurahan_pemohon';
        $this->load->vars($data);
        $this->load->view('kecamatan_load', $data);
    }

    public function kelurahan_pemohon() {    // Masuk Setelah pilih Kecamatan => data pemohon
        $data['kelurahan_id'] = 'kelurahan_pemohon';
        $this->load->vars($data);
        $this->load->view('kelurahan_load', $data);
    }

    public function kabupaten_usaha() {     // masuk setelah pilih Provinsi => data perusahaan
        $data['kabupaten_id'] = 'kabupaten_usaha';
        $data['kecamatan_id'] = 'kecamatan_usaha';
        $data['kelurahan_id'] = 'kelurahan_usaha';
        $data['kelurahan_link'] = 'kelurahan_usaha_idKab';
        $this->load->vars($data);
        $this->load->view('kabupaten_load_perusahaan', $data);
    }

    public function kecamatan_usaha() {      // masuk setelah pilih Kabupaten => data perusahaan
        $data['kecamatan_id'] = 'kecamatan_usaha';
        $data['kelurahan_id'] = 'kelurahan_usaha';
        $this->load->vars($data);
        $this->load->view('kecamatan_load_perusahaan', $data);
    }

    public function kelurahan_usaha() {     // masuk setelah pilih Kecamatan => data perusahaan
        $data['kelurahan_id'] = 'kelurahan_usaha';
        $this->load->vars($data);
        $this->load->view('kelurahan_load_perusahaan', $data);
    }

    public function kecamatan_lok() {      // masuk setelah pilih Kabupaten => data permohonan
        $data['kecamatan_id'] = 'kecamatan_lok';
        $data['kelurahan_id'] = 'kelurahan_lok';
        $data['kelurahan_link'] = 'kelurahan_lok_idKab';
        $this->load->vars($data);
        $this->load->view('kecamatan_load_lokasi', $data);
    }
	
	public function kelurahan_lok() {      // masuk setelah pilih Kecamatan => data permohonan
        $data['kelurahan_id'] = 'kelurahan_lok';
        $this->load->vars($data);
        $this->load->view('kelurahan_load_lokasi', $data);
    }

    public function kabupaten_perusahaan() {
        $data['kabupaten_id'] = 'kabupaten_perusahaan';
        $data['kecamatan_id'] = 'kecamatan_perusahaan';
        $this->load->vars($data);
        $this->load->view('kabupaten_load_perusahaan', $data);
    }

    public function kecamatan_pemohon_idProp() {
        $data['kecamatan_id'] = 'kecamatan_pemohon';
        $data['kelurahan_id'] = 'kelurahan_pemohon';
        $this->load->vars($data);
        $this->load->view('kecamatan_load_idProp', $data);
    }

    public function kelurahan_pemohon_idKab() {
        $data['kelurahan_id'] = 'kelurahan_pemohon';
        $this->load->vars($data);
        $this->load->view('kelurahan_load_idKab', $data);
    }

    public function kelurahan_pemohon_idProp() {
        $data['kelurahan_id'] = 'kelurahan_pemohon';
        $this->load->vars($data);
        $this->load->view('kelurahan_load_idProp', $data);
    }

    public function kecamatan_usaha_idProp() {
        $data['kecamatan_id'] = 'kecamatan_usaha';
        $data['kelurahan_id'] = 'kelurahan_usaha';
        $this->load->vars($data);
        $this->load->view('kecamatan_load_perusahaan', $data);
    }

    public function kelurahan_usaha_idKab() {
        $data['kelurahan_id'] = 'kelurahan_usaha';
        $this->load->vars($data);
        $this->load->view('kelurahan_load_idKab', $data);
    }

    public function kelurahan_usaha_idProp() {
        $data['kelurahan_id'] = 'kelurahan_usaha';
        $this->load->vars($data);
        $this->load->view('kelurahan_load_idProp', $data);
    }
	
    public function izin_paralel() {
        $paralel = new trparalel();
        $data['list_paralel'] = $paralel->order_by('id', 'ASC')->get();
        $data['list_izin'] = $this->perizinan->where_related($this->username)->order_by('id', 'ASC')->get();
        $data['list_jenispermohonan'] = $this->jenispermohonan->get_by_id($this->jenis_id);
        $data['jenis_id'] = $this->jenis_id;
        $this->load->vars($data);
        $this->load->view('izin_paralel_load', $data);
    }

    public function list_paralel_izin() {
        $data['jenis_id'] = $this->jenis_id;
        $this->load->vars($data);
        $this->load->view('list_paralel_load', $data);
    }

    public function pick_pemohon_list() {
        $data['page_name'] = "Ambil Data Pemohon";
        $data['list'] = $this->pemohon->order_by('id', 'DESC')
                             ->limit(1500)
                             ->get();
        $this->load->vars($data);
        $this->load->view('pemohon_load', $data);
    }

    public function pick_pemohon_data() {
        $data = $this->_funcwilayah();
        $_POST['id_pemohon'] = $this->uri->segment(4);
        $p_pemohon = $this->pemohon->get_by_id($_POST['id_pemohon']);
        $p_kelurahan = $p_pemohon->trkelurahan->get();
        $p_kecamatan = $p_pemohon->trkelurahan->trkecamatan->get();
        $p_kabupaten = $p_pemohon->trkelurahan->trkecamatan->trkabupaten->get();
        $p_propinsi = $p_pemohon->trkelurahan->trkecamatan->trkabupaten->trpropinsi->get();
        $data['status'] = "pemohon";
        $data['id_pemohon'] = $p_pemohon->id;
        $data['no_refer'] = $p_pemohon->no_referensi;

        $data['nama_pemohon'] = $p_pemohon->n_pemohon;
        $data['no_telp'] = $p_pemohon->telp_pemohon;
        $data['check_ctr'] = $p_pemohon->cek_prop;
        $data['propinsi_pemohon'] = $p_propinsi->id;
        $data['kabupaten_pemohon'] = $p_kabupaten->id;
        $data['kecamatan_pemohon'] = $p_kecamatan->id;
        $data['kelurahan_pemohon'] = $p_kelurahan->id;
        $data['tgl_daftar'] = "";
        $data['tgl_survey'] = "";
        $data['lokasi_izin'] = "";
        $data['keterangan'] = "";
		$data['cmbgerai'] = "";
		$data['no_antri'] = "";
		$data['kd_kontak']="";
        $data['alamat_pemohon'] = $p_pemohon->a_pemohon;
        $data['alamat_pemohon_luar'] = $p_pemohon->a_pemohon_luar;

        $this->load->vars($data);
        $this->load->view('pemohon_tab', $data);
        echo "<script>$.facebox.close();</script>";
    }

    public function pick_daftar_list() {
        $jenis_p = $this->jenispermohonan->get_by_id($this->jenis_id);
        $data['page_name'] = "Ambil Data Pemohon";
        $query = "SELECT A.id, A.pendaftaran_id, A.d_terima_berkas,
                  C.id idizin, C.n_perizinan, E.n_pemohon
                  FROM tmpermohonan as A
                  INNER JOIN tmpermohonan_trperizinan as B ON B.tmpermohonan_id = A.id
                  INNER JOIN trperizinan as C ON B.trperizinan_id = C.id
                  INNER JOIN tmpemohon_tmpermohonan as D ON D.tmpermohonan_id = A.id
                  INNER JOIN tmpemohon as E ON D.tmpemohon_id = E.id
                  WHERE A.c_pendaftaran = 1
                  AND A.c_izin_dicabut = 0
                  AND A.c_izin_selesai = 0
                  order by A.id DESC";
        $data['list'] = $query;

        $this->load->vars($data);
        $this->load->view('daftar_load', $data);
    }

    public function daftar_perusahaan_list() {
        $data['page_name'] = "Ambil Data Perusahaan";

        $this->load->vars($data);
        $this->load->view('pick_list_perusahaan', $data);
    }

    public function daftar_izin_list() {    // Ambil data pemohon izin
        $data['page_name'] = "Ambil Data Pemohon";

        $this->load->vars($data);
        $this->load->view('pick_list_data_izin', $data);
    }

    public function pick_daftar_data() { // Akan Muncul jika ada proses Ambil Data Pemohon yang telah terdaftar
        $data = $this->_funcwilayah();

        $_POST['id_daftar'] = $this->uri->segment(4);
        $p_pemohon = $this->pemohon->get_by_id($_POST['id_daftar']);

        $p_kelurahan = $p_pemohon->trkelurahan->get();
        $p_kecamatan = $p_pemohon->trkelurahan->trkecamatan->get();
        $p_kabupaten = $p_pemohon->trkelurahan->trkecamatan->trkabupaten->get();
        $p_propinsi = $p_pemohon->trkelurahan->trkecamatan->trkabupaten->trpropinsi->get();

        $data['ambil_data'] = TRUE;
		$data['id_pemohon'] = $p_pemohon->id; //data id pemohon
		$data['no_refer'] = $p_pemohon->no_referensi;

        $data['nama_pemohon'] = $p_pemohon->n_pemohon;
		$data['no_telp'] = $p_pemohon->telp_pemohon;
        $data['check_ctr'] = $p_pemohon->cek_prop;
        $data['propinsi_pemohon'] = $p_propinsi->id;
		$data['kabupaten_pemohon'] = $p_kabupaten->id;
        $data['kecamatan_pemohon'] = $p_kecamatan->id;
		$data['kelurahan_pemohon'] = $p_kelurahan->id;
		$data['kabupaten_lok'] = '';
        $data['kecamatan_lok'] = '';
        $data['kelurahan_lok'] = '';
        $data['tgl_daftar'] = date('Y-m-d');       
        $data['tgl_survey'] = "";
        $data['lokasi_izin'] = "";
        $data['keterangan'] = "";
        $data['cmbgerai'] = "";
		$data['no_antri'] = "";
        $data['kd_kontak'] = '';
        $data['alamat_pemohon'] = $p_pemohon->a_pemohon;
        $data['alamat_pemohon_luar'] = $p_pemohon->a_pemohon_luar;

        $data['status'] = "pemohon"; //data pemohon diambil

        $data['cmbsource'] = $p_pemohon->source;
        
        //cek Online penduduk
        $this->settings->where('name', 'web_service_penduduk')->get();
        $statusOnline2 = $this->settings->status;
        $data['statusOnline2'] = $statusOnline2;

        $this->load->vars($data);
        $this->load->view('pemohon_tab', $data);  
        echo "<script>$.facebox.close();</script>";
    }

    public function pick_perusahaan_list() {
        $data['page_name'] = "Ambil Data Perusahaan";
        $data['list'] = $this->perusahaan->order_by('id', 'DESC')
                             ->limit(1500)
                             ->get();
        $this->load->vars($data);
        $this->load->view('perusahaan_load', $data);
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

	public function pick_perusahaan_data2($reg) {
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
        $this->load->view('perusahaan_tab_clear', $data);
        echo "<script>$.facebox.close();</script>";
    }
	
    public function pick_penduduk_data() {
        $data = $this->_funcwilayah();

		$data['propinsi_pemohon'] = NULL;
        $data['check_ctr'] = 0;
        $data['kabupaten_pemohon'] = NULL;
        $data['kecamatan_pemohon'] = NULL;
        $data['kelurahan_pemohon'] = NULL;
        //cek Online penduduk
        $this->settings->where('name', 'web_service_penduduk')->get();
        $statusOnline2 = $this->settings->status;
        $data['statusOnline2'] = $statusOnline2;

        $_POST['id_perusahaan'] = $this->uri->segment(4);
        $u_perusahaan = $this->perusahaan->get_by_id($_POST['id_perusahaan']);
        $data['data_npwp_id'] = " ";
        $data['cmbsource'] = "KTP";
        $data['id_perusahaan'] = $u_perusahaan->id;
        $data['nama_perusahaan'] = $u_perusahaan->n_perusahaan;
        $data['npwp'] = $u_perusahaan->npwp;
        $data['telp_perusahaan'] = $u_perusahaan->i_telp_perusahaan;
        $data['alamat_usaha'] = $u_perusahaan->a_perusahaan;
        $data['nodaftar'] = $u_perusahaan->no_daftar;
        $data['fax'] = $u_perusahaan->fax;
        $data['email'] = $u_perusahaan->email;
        $data['rt'] = $u_perusahaan->rt;
        $data['rw'] = $u_perusahaan->rw;
        $data['mantra'] = $this->mantraSakti('NIK='.$_REQUEST['data_no_refer'],'web_service_penduduk');
		$data['no_antri'] = "";
		
        //cek Online
        $this->settings->where('name', 'web_service_penduduk')->get();
        $statusOnline = $this->settings->status;
        $data['statusOnline'] = $statusOnline;

        $this->load->vars($data);
        $this->load->view('penduduk_tab', $data);
        echo "<script>$.facebox.close();</script>";
    }

    //----------------------- SCRIPT MANTRA -----------------------//

    public function mantraSakti($id,$wsname='web_service_penduduk'){
        $settings = new settings();
        $app_web_service = $settings->where('name', $wsname)->get();
        $url = $app_web_service->value . $id;
        //$url = "http://10.31.2.9/mantra/api/4f55d6b5/mantrakemkominfo/ws-kepegawaian/datapegawai/nik=3175071602730009";
        //$url = "http://10.31.2.9/mantra/api/4f474071/ditjendukcapil/ws-penduduk/data-penduduk-nasional-pernik/NIK=3471040408820002";		
        $ch = curl_init();                              // PHP_CURL in php.ini must be enabled 
        // (extension=[php_curl.dll|php_curl.so]) 
        curl_setopt($ch, CURLOPT_URL, $url);            // Set URL 
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPGET, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);  // Return result
		curl_setopt($ch, CURLOPT_USERAGENT, "MANTRA");

        $result = curl_exec($ch);                         // Connect to URL and get result

        if ($result):
            if (substr($result, 0, 5) == "REST:"):                  //Replace REST:
                $result = substr_replace($result, "", 0, 5);
            endif;
            if ($result):
                if (strtolower(substr($result, 0, 5)) == "<?xml"): //Detect XML format
                    $xmle = new SimpleXMLElement($result);     //Parsing XML into Array
                    $rootName = strtolower($xmle->getName());
                    if ($rootName == "invalid_response"):
                        $result = (string) $xmle;
                    elseif ($rootName == "valid_response"):
                        $xmli = new SimpleXMLIterator($result);
                        $result = $this->parseIterator($xmli);

                    else:
                        $result = false;
                        $messageAPI = "No result from API Webservice";
                    endif;
                endif;
            endif;
        endif;
        return $result;
        //print_r($result)."<br><br>";
        //echo $result['nilaiBiodataWNI']['nilaiKab'];
    }

    public function parseIterator($xmli) {
        foreach ($xmli as $key => $val):
            $child[$key] = $xmli->hasChildren() ? $this->parseIterator($val) : strval($val);
        endforeach;
        return $child;
    }
//------------------------------EOF() SCRIPT MANTRA------------------------------//

    public function pick_list($id_jenis) {
        $data['page_name'] = "Pilih";
        $data['id_jenis'] = $id_jenis;
        $this->load->vars($data);
        $this->load->view('pick_list', $data);
    }

    public function pick_list_other($id_jenis) {
        $data['page_name'] = "Pilih";
        $data['id_jenis'] = $id_jenis;
        $this->load->vars($data);
        $this->load->view('pick_list_other', $data);
    }

    public function get_data_perusahaan() {
        $obj = new tmperusahaan();
        $columns = array('n_perusahaan','a_perusahaan','npwp');
        $obj->start_cache();
        $this->iTotalRecords = $obj->count();
        $this->sEcho = $this->input->post('sEcho');
        for ($i = 0; $i < 2; $i++) {
            if ($this->input->post('sSearch')) {
                foreach ($columns as $position => $column) {
                    if ($position == 0 && $position == 2) {
                        $obj->like($column, $this->input->post('sSearch'));
                    } else {
                        $obj->or_like($column, $this->input->post('sSearch'));
                    }
                }
            }

            if ($i === 0) {
                $this->iTotalDisplayRecords = $obj->count();
            } else if ($i === 1) {
                if ($this->input->post("iDisplayStart") && $this->input->post("iDisplayLength") != "-1") {
                    $this->iDisplayStart = $this->input->post("iDisplayStart");
                    $this->iDisplayLength = $this->input->post("iDisplayLength");

                    $obj->limit($this->iDisplayLength, $this->iDisplayStart);
                } else {
                    $this->iDisplayLength = $this->input->post("iDisplayLength");

                    if (empty($this->iDisplayLength)) {
                        $this->iDisplayLength = 10;
                        $obj->limit($this->iDisplayLength);
                    }
                    else
                        $obj->limit($this->iDisplayLength);
                }
            }
        }

        $peru = new tmperusahaan;
        $a = $obj->get();
        $obj->stop_cache();
        echo $this->get_data_perusahaan_output($a);
    }

    private function get_data_perusahaan_output($obj) {
        $aaData = array();
        $i = $this->iDisplayStart;
        foreach ($obj as $list) {
            $i++;
            $action = NULL;
            $action = NULL;
            $action .= '<a href="javascript:popup_link(\'' . base_url() . 'pelayanan/pendaftaran/pick_perusahaan_data/' . $list->id . '\',\'#tabs-2\')">';
            $action .= '<img src="' . base_url() . 'assets/images/icon/navigation-down.png" border="0" alt="Pilih Pemohon"/>';
            $action .= '</a>';

            $aaData[] = array($i,
                              $list->n_perusahaan,
                              $list->npwp,
                              $list->a_perusahaan,
                              $action
                             );
        }
        $sOutput = array("sEcho" => intval($this->sEcho),
                         "iTotalRecords" => $this->iTotalRecords,
                         "iTotalDisplayRecords" => $this->iTotalDisplayRecords,
                         "aaData" => $aaData
                        );
        return json_encode($sOutput);
    }

    public function get_data_izin() {
        $obj = new tmpemohon();
        $columns = array('n_pemohon','no_referensi','a_pemohon',);
        $obj->start_cache();
        $this->iTotalRecords = $obj->count();
        $this->sEcho = $this->input->post('sEcho');
        for ($i = 0; $i < 2; $i++) {
            /* Filtering */
            if ($this->input->post('sSearch')) {
                foreach ($columns as $position => $column) {
                    if ($position == 0 && $position == 1) {
                        $obj->like($column, $this->input->post('sSearch'));
                    } else {
                        $obj->or_like($column, $this->input->post('sSearch'));
                    }
                }
            }

            if ($i === 0) {
                $this->iTotalDisplayRecords = $obj->count();
            } else if ($i === 1) {
                if ($this->input->post("iDisplayStart") && $this->input->post("iDisplayLength") != "-1") {
                    $this->iDisplayStart = $this->input->post("iDisplayStart");
                    $this->iDisplayLength = $this->input->post("iDisplayLength");
                    $obj->limit($this->iDisplayLength, $this->iDisplayStart);
                } else {
                    $this->iDisplayLength = $this->input->post("iDisplayLength");
                    if (empty($this->iDisplayLength)) {
                        $this->iDisplayLength = 10;
                        $obj->limit($this->iDisplayLength);
                    }else{
                        $obj->limit($this->iDisplayLength);
					}
                }
            }
        }

        $peru = new tmpemohon;
        $a = $obj->get();
        $obj->stop_cache();
        echo $this->get_data_izin_output($a);
    }

    public function get_data_izin_output($obj) {
        $aaData = array();
        $i = $this->iDisplayStart;

        foreach ($obj as $list) {
            $i++;
            $action = NULL;
            $action = NULL;
            $action .= '<a href="javascript:popup_link(\'' . base_url() . 'pelayanan/pendaftaran/pick_daftar_data/' . $list->id . '\',\'#tabs-1\')">';
            $action .= '<img src="' . base_url() . 'assets/images/icon/navigation-down.png" border="0" alt="Pilih Pemohon" class="klik_saya"/>';
            $action .= '</a>';
            
            $aaData[] = array($i,
                              $list->no_referensi,
                              $list->n_pemohon,
                              $list->a_pemohon,
                              $action
                             );
        }

        $sOutput = array("sEcho" => intval($this->sEcho),
                         "iTotalRecords" => $this->iTotalRecords,
                         "iTotalDisplayRecords" => $this->iTotalDisplayRecords,
                         "aaData" => $aaData
                        );
        return json_encode($sOutput);
    }

    public function get_data_no_surat_lama($id_jenis) {
        $obj = new tmpermohonan();
        $obj->start_cache();
        $obj->where('c_pendaftaran', '1')
            ->where('c_izin_selesai', '1')
            ->where('c_izin_dicabut', '0')
            ->order_by('id', 'DESC');
        $obj->where_related('tmbap', 'status_bap', '1');
        $this->iTotalRecords = $obj->count();
        $this->sEcho = $this->input->post('sEcho');
        for ($i = 0; $i < 2; $i++) {
            /* Filtering */
            if ($this->input->post('sSearch')) {
                $obj->like('pendaftaran_id', $this->input->post('sSearch'));
            }
            if ($i === 0) {
                $this->iTotalDisplayRecords = $obj->count();
            } else if ($i === 1) {
                if ($this->input->post("iDisplayStart") && $this->input->post("iDisplayLength") != "-1") {
                    $this->iDisplayStart = $this->input->post("iDisplayStart");
                    $this->iDisplayLength = $this->input->post("iDisplayLength");

                    $obj->limit($this->iDisplayLength, $this->iDisplayStart);
                } else {
                    $this->iDisplayLength = $this->input->post("iDisplayLength");

                    if (empty($this->iDisplayLength)) {
                        $this->iDisplayLength = 10;
                        $obj->limit($this->iDisplayLength);
                    }
                    else
                        $obj->limit($this->iDisplayLength);
                }
                $obj->stop_cache();
                echo $this->get_data_no_surat_lama_output($obj->get(), $id_jenis);
            }
        }
    }

    private function get_data_no_surat_lama_output($obj, $id_jenis) {
        $aaData = array();
        $i = $this->iDisplayStart;

        foreach ($obj as $list) {
            $i++;
            $action = NULL;

            $img_edit = array(
                'src' => base_url() . 'assets/images/icon/tick.png',
                'alt' => 'Pilih',
                'title' => 'Pilih',
                'border' => '0',
            );
            $action .= anchor(site_url('pendaftaran/create') . '/' . $id_jenis . '/' . $list->id, img($img_edit));

            $list->tmpemohon->get();
            $list->trperizinan->get();
            $aaData[] = array(
                $i,
                $list->pendaftaran_id,
                $list->tmpemohon->n_pemohon,
                $list->tmpemohon->n_perusahaan,
                $list->trperizinan->n_perizinan,
                $action
            );
        }

        $sOutput = array("sEcho" => intval($this->sEcho),
                         "iTotalRecords" => $this->iTotalRecords,
                         "iTotalDisplayRecords" => $this->iTotalDisplayRecords,
                         "aaData" => $aaData
                        );

        return json_encode($sOutput);
    }

    public function get_data_no_surat_lama_other($id_jenis) {
        $obj = new tmsk();
        $obj->start_cache();
        $obj->where_related('tmpermohonan', 'c_izin_selesai', '1');
        $this->iTotalRecords = $obj->count();
        $this->sEcho = $this->input->post('sEcho');
        for ($i = 0; $i < 2; $i++) {
            /**
             * Filtering
             */
            if ($this->input->post('sSearch')) {
                $obj->like('no_surat', $this->input->post('sSearch'));
            }

            /**
             * Ordering
             */
            if ($i === 0) {
                $this->iTotalDisplayRecords = $obj->count();
            } else if ($i === 1) {
                if ($this->input->post("iDisplayStart") && $this->input->post("iDisplayLength") != "-1") {
                    $this->iDisplayStart = $this->input->post("iDisplayStart");
                    $this->iDisplayLength = $this->input->post("iDisplayLength");

                    $obj->limit($this->iDisplayLength, $this->iDisplayStart);
                } else {
                    $this->iDisplayLength = $this->input->post("iDisplayLength");

                    if (empty($this->iDisplayLength)) {
                        $this->iDisplayLength = 10;
                        $obj->limit($this->iDisplayLength);
                    }
                    else
                        $obj->limit($this->iDisplayLength);
                }

                // Dichi Al Faridi Mark

                $obj->stop_cache();
                echo $this->get_data_no_surat_lama_other_output($obj->get(), $id_jenis);
            }
        }
    }

    private function get_data_no_surat_lama_other_output($obj, $id_jenis) {

        $aaData = array();

        $i = $this->iDisplayStart;

        foreach ($obj as $list) {
            $i++;
            $action = NULL;
            $img_edit = array(
                'src' => base_url() . 'assets/images/icon/tick.png',
                'alt' => 'Pilih',
                'title' => 'Pilih',
                'border' => '0',
            );
            $action .= anchor(site_url('pendaftaran/create') . '/' . $id_jenis . '/' . $list->tmpermohonan->tmpemohon->id, img($img_edit));

            $list->tmpermohonan->get();
            $list->tmpermohonan->trperizinan->get();
            $list->tmpermohonan->tmpemohon->get();
            $aaData[] = array(
                $i,
                $list->no_surat,
                $list->tmpermohonan->tmpemohon->n_pemohon,
                $list->tmpermohonan->trperizinan->n_perizinan,
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

    public function tambah_lokasi($input = NULL, $rincian = NULL) {
        $rincian=$rincian . $input;
        return $rincian;
		redirect('monitoring/cetak_izin_baru/1/' . $tgla .'/'. $tglb);
    }

    public function sql() {
        $query = "SELECT DISTINCT npwp,n_perusahaan,a_perusahaan
                  FROM tmperusahaan";

        $sql = $this->db->query($query);
        return $sql->result();
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

}