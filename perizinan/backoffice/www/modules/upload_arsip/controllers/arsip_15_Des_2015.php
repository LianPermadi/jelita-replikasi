<?php

/**
 * Description of Pengarsipan Berkas
 *
 * @author PBS
 * Created : 4 Maret 2012
 */
class Arsip extends WRC_AdminCont {
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
        $this->sk = new tmsk();
		
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
        $this->sk = new tmsk();
		$this->status = new trstspermohonan();
		$this->sektor = new trsektor();
        
		$this->file_upload = 'nUpload';
		/* Untuk Upload */
		$this->load->helper(array("html","form","url","text"));
		/* EOF() Untuk Upload */

        $enabled = FALSE;
        $list_auths = $this->session_info['app_list_auth'];
        
//        foreach ($list_auths as $list_auth) {
//            if ($list_auth->id_role === '21') {
                $enabled = TRUE;
//            }
//        }
        
        if (!$enabled) {
            redirect('dashboard');
        }
    }

    public function index() {  // Masuk Pertama Kali saat klok menu Pengarsipan
	    $file_upload = $this->file_upload;
	    $query = $this->view_query();
        $mark = $this->input->post('mark');
		$list_sektor = $this->input->post('list_sektor');
		$tgla = $this->input->post('tgla');
        $tglb = $this->input->post('tglb');
        $now = $this->lib_date->get_date_now();
        $tgl_before = $this->lib_date->set_date($now, -40);
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
        $username = new user();
        $username->where('username', $this->session->userdata('username'))->get();
		$this->lib_date->post_variable($username->id, $tgla, $tglb, $list_sektor, $mark, $file_upload, '', '', '', '', '');   // post variable
		if($list_sektor == '') $list_sektor = '0';
		$lokasi_user = $this->session->userdata('lokasi');
		$data['lokasi_user'] = $lokasi_user;
		$data['list_data'] = $this->sektor->order_by('urutan', 'ASC')->get();
		$data['mark'] = $mark;
		$data['file_upload'] = $file_upload;
		$data['sektor'] = $list_sektor;
        
		//if ($lokasi_user === 'Pusat') // Untuk daerah lain
		if ($lokasi_user === 'BPMPT Prov. tasikmalaya' || $lokasi_user === 'BPPT Prov. tasikmalaya')
			$query .= "";
        else
		    $query .= " AND A.kd_gerai = '" . $username->lokasi . "'";
		
		
        if($list_sektor != '0')  // Semua Sektor
            $query .= " AND A.trsektor_id = '" . $list_sektor . "'";

		$query .= " AND A.d_terima_berkas between '$tgla' and '$tglb'";
		$jum_ijin = $this->db->query($query)->num_rows();
		$jum_arsip = $this->db->query($query." AND A.desc_arsip != ' '")->num_rows();
		$query .= " order by A.id DESC";

        $data['list'] = $query;
		$data['jum_ijin'] = $jum_ijin;
		$data['jum_arsip'] = $jum_arsip;
        $this->load->vars($data);
        $js = "
                function confirm_link(text){
                    if(confirm(text)){ return true;
                    }else{ return false; }
                }

                $(document).ready(function() {
                        oTable = $('#penyerahan').dataTable({
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
                $('.kirimsms').click(function(){               
                    $('#smsdialog').dialog({modal: true,title:'Konfirmasi SMS',autoOpen: false,height: 150,width:250,draggable:false,resizable:false});
                    $('#smsdialog').dialog('open');
                    return false;
                });    
				$('#tblreset').click(function(){
					$('#smsdialog').dialog('close');
				});

                });
                
                function isino(data,isisms) {
                    $('#txtno').val(data.toString());
	                $('#spanno').text(data.toString());
                    $('#txtisi').val(isisms.toString());
                    //var url=$(this).attr('href'); 
                }
                ";
        $this->template->set_metadata_javascript($js);        
        $this->session_info['page_name'] = "Administrasi Pengarsipan Berkas Izin";
        $this->template->build('arsip_list', $this->session_info);
    }
	
	public function list_index() { // Kembali dari proses pengarsipan
	    $query = $this->view_query();
        $username = new user();
        $username->where('username', $this->session->userdata('username'))->get();
		$tgla = $username->gvar1;
        $tglb = $username->gvar2;
		$list_sektor = $username->gvar3;
		$mark = $username->gvar4;
		$file_upload = $username->gvar5; 
        $data['tgla'] = $tgla;
        $data['tglb'] = $tglb;

		$lokasi_user = $this->session->userdata('lokasi');
        $data['lokasi_user'] = $lokasi_user;
		$data['list_data'] = $this->sektor->order_by('urutan', 'ASC')->get();
		$data['mark'] = $mark;
		$data['file_upload'] = $file_upload;
		$data['sektor'] = $list_sektor;

        //if ($lokasi_user === 'Pusat')  // Untuk daerah lain
		if ($lokasi_user === 'BPMPT Prov. tasikmalaya' || $lokasi_user === 'BPPT Prov. tasikmalaya')
			$query .= "";
        else
		    $query .= " AND A.kd_gerai = '" . $username->lokasi . "'";
		
		
        if($list_sektor != '0')  // Semua Sektor
            $query .= " AND A.trsektor_id = '" . $list_sektor . "'";

		$query .= " AND A.d_terima_berkas between '$tgla' and '$tglb'";
		$jum_ijin = $this->db->query($query)->num_rows();
		$jum_arsip = $this->db->query($query." AND A.desc_arsip != ' '")->num_rows();
		$query .= " order by A.id DESC";

		$data['list'] = $query;
		$data['jum_ijin'] = $jum_ijin;
		$data['jum_arsip'] = $jum_arsip;
        $this->load->vars($data);

        $js = "
                function confirm_link(text){
                    if(confirm(text)){ return true;
                    }else{ return false; }
                }

                $(document).ready(function() {
                        oTable = $('#penyerahan').dataTable({
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
        $this->session_info['page_name'] = "Administrasi Pengarsipan Berkas Izin ";
        $this->template->build('arsip_list', $this->session_info);
    }

    //function edit($edt:{E.Edit, L.Lihat}, $id_daftar:{id pendaftaran}, $asal_menu:{isi dengan angka})
    public function edit($edt = NULL, $id_daftar = NULL, $asal_menu = NULL) {
		$username = new user();
        $username->where('username', $this->session->userdata('username'))->get();
		$tgla = $username->gvar1;
        $tglb = $username->gvar2;
	    $list_sektor = $username->gvar3;
		$mark = $username->gvar4;
		$menu = $username->gvar10;
	    $this->lib_date->post_variable($username->id, $tgla, $tglb, $list_sektor, $mark, $id_daftar, $username->gvar6, $username->gvar7, $username->gvar8, $username->gvar9, $menu);   // post variable

        $this->username->where('username', $this->session->userdata('username'))->get();
		$lokasi_user = $this->session->userdata('lokasi');

		$u_daftar = $this->pendaftaran->get_by_id($id_daftar);
        $p_pemohon = $u_daftar->tmpemohon->get();
		$p_status = $u_daftar->trstspermohonan->get();
		$p_sk = $u_daftar->tmsk->get();
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
        $d_kelompok = $d_izin->trkelompok_perizinan->get();
        $d_jenis = $u_daftar->trjenis_permohonan->get();
        
		$no_sk = $p_sk->no_surat_edit;
        $tgl_sk = $p_sk->tgl_surat_edit;
		if($no_sk == "") {
            $no_sk = $p_sk->no_surat;
			$tgl_sk = $p_sk->tgl_surat;
        }

        $data = $this->_funcwilayah();
		
        $jml = $this->get_jml_syarat($d_izin->id, 'seri');
		if($edt == 'E')
            $data['edit'] = TRUE;
		else
		    $data['edit'] = FALSE;

		if($u_daftar->status_berkas == "proses")
			$n_status = $p_status->n_sts_permohonan;
        else
            $n_status = $u_daftar->status_berkas;

		$data['asal_menu'] = $asal_menu;
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
        $data['waktu_awal'] = $this->lib_date->get_date_now();
        $data['no_refer'] = $p_pemohon->no_referensi;
        $data['nama_pemohon'] = $p_pemohon->n_pemohon;
        $data['no_telp'] = $p_pemohon->telp_pemohon;
        $data['cmbsource'] = $p_pemohon->source;
        $data['check_ctr'] = $p_pemohon->cek_prop;
        $data['propinsi_pemohon'] = $p_propinsi->n_propinsi;
        $data['kabupaten_pemohon'] = $p_kabupaten->n_kabupaten;
        $data['kecamatan_pemohon'] = $p_kecamatan->n_kecamatan;
        $data['kelurahan_pemohon'] = $p_kelurahan->n_kelurahan;

		$data['n_status'] = $n_status;

        $data['jenis_kegiatan'] = $u_kegiatan->n_kegiatan;
        $data['jenis_investasi'] = $u_investasi->n_investasi;
        $data['propinsi_usaha'] = $u_propinsi->n_propinsi;
        $data['kabupaten_usaha'] = $u_kabupaten->n_kabupaten;
        $data['kecamatan_usaha'] = $u_kecamatan->n_kecamatan;
        $data['kelurahan_usaha'] = $u_kelurahan->n_kelurahan;

        $data['tgl_daftar'] = $u_daftar->d_terima_berkas;
        $data['tgl_survey'] = $u_daftar->d_survey;
        $data['lokasi_izin'] = $u_daftar->a_izin;
		$data['rincian_lokasi'] = "";
        $data['keterangan'] = $u_daftar->keterangan;
		$data['cmbgerai'] = $u_daftar->kd_gerai;
		$data['no_antri'] = $u_daftar->no_antri;
		$data['kd_kontak']=$u_daftar->kontak_person;
		$data['val_combo_syarat'] = $u_daftar->syarat_arsip;
		$data['val_combo_asli'] = $u_daftar->arsip_asli;
		$data['val_combo_asli_lain'] = $u_daftar->arsip_asli_lain;
		$data['syarat_arsip_lain'] = $u_daftar->syarat_arsip_lain;
        $data['ket_syarat_arsip'] = $u_daftar->ket_syarat_arsip;
		$data['ket_syarat_arsip_lain'] = $u_daftar->ket_syarat_arsip_lain;
		$data['desc_arsip'] = $u_daftar->desc_arsip;
		$data['nama_file'] = $u_daftar->nama_file;
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
		$data['no_sk'] = $no_sk;
		$data['tgl_sk'] = $tgl_sk;

        $syarat_perizinan = new trsyarat_perizinan();
        $data['syarat_izin'] = $syarat_perizinan->where_related($this->perizinan)->order_by('status', 'asc')->get();
        $data['list_daftar'] = $u_daftar;
        $data['statusOnline'] = 0;

        $data['statusOnline2'] = 0;

		//$data['daftar'] = $u_daftar;    -> list_daftar
        $data['list_tr'] = $this->status->get();
        $data['list_tracking'] = $u_daftar->tmtrackingperizinan->order_by('id', 'DESC')->get();
        
		//<!-- Upload Area -->
		//$data["judulapp"]="Upload Dokumen Izin";
		//$data["scriptaksi"]="arsip/arsip/uploadfile";
		//$data["aksi"]="Upload";
		//$data["error"]=(isset($data["error"]))?$data["error"]:"";
		//$viewfile="v_cupload_form";
		//$this->load->view($viewfile,$data);
        //<!-- Upload Area -->


        $js = "
		        function confirm_link(text){
                    if(confirm(text)){ return true;
                    }else{ return false; }
                }

                $(document).ready(function() {
                        oTable = $('#trackingdetail').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );

				$(document).ready(function() {
                    $('#form').validate();
                    $(\"#tabs\").tabs();

					$('a[rel*=upload_box]').facebox();
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
                                                       });
                                         }); 
                });


                $(document).ready(function() {
                         $('#propinsi_usaha_id').change(function(){
                            $.post('" . base_url() . "pelayanan/pendaftaran/kabupaten_usaha', { propinsi_id: $('#propinsi_usaha_id').val() },
                                function(data) {
                                    $('#show_kabupaten_usaha').html(data);
                                    $('#show_kecamatan_usaha').html('Data Tidak tersedia');
                                    $('#show_kelurahan_usaha').html('Data Tidak tersedia');
                                });
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
		if($edt == 'E')
            $this->session_info['page_name'] = "Edit Data Arsip";
		else
            $this->session_info['page_name'] = "Informasi Data Detail";
        $this->template->build('arsip_edit', $this->session_info);
    }

	public function info_detail($id_daftar = NULL) {
        $this->username->where('username', $this->session->userdata('username'))->get();
		$lokasi_user = $this->session->userdata('lokasi');

		$u_daftar = $this->pendaftaran->get_by_id($id_daftar);
        $p_pemohon = $u_daftar->tmpemohon->get();
		$p_sk = $u_daftar->tmsk->get();
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
        $d_kelompok = $d_izin->trkelompok_perizinan->get();
        $d_jenis = $u_daftar->trjenis_permohonan->get();
        
		$no_sk = $p_sk->no_surat_edit;
        $tgl_sk = $p_sk->tgl_surat_edit;
		if($no_sk == "") {
            $no_sk = $p_sk->no_surat;
			$tgl_sk = $p_sk->tgl_surat;
        }

        $data = $this->_funcwilayah();
		
        $jml = $this->get_jml_syarat($d_izin->id, 'seri');
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
		$data['val_combo_syarat'] = $u_daftar->syarat_arsip;
		$data['val_combo_asli'] = $u_daftar->arsip_asli;
		$data['val_combo_asli_lain'] = $u_daftar->arsip_asli_lain;
		$data['syarat_arsip_lain'] = $u_daftar->syarat_arsip_lain;
        $data['ket_syarat_arsip'] = $u_daftar->ket_syarat_arsip;
		$data['ket_syarat_arsip_lain'] = $u_daftar->ket_syarat_arsip_lain;
		$data['desc_arsip'] = $u_daftar->desc_arsip;
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
		$data['no_sk'] = $no_sk;
		$data['tgl_sk'] = $tgl_sk;

        $syarat_perizinan = new trsyarat_perizinan();
        $data['syarat_izin'] = $syarat_perizinan->where_related($this->perizinan)->order_by('status', 'asc')->get();
        $data['list_daftar'] = $u_daftar;
        $data['statusOnline'] = 0;

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
                                                       });
                                         }); 
                });


                $(document).ready(function() {
                         $('#propinsi_usaha_id').change(function(){
                            $.post('" . base_url() . "pelayanan/pendaftaran/kabupaten_usaha', { propinsi_id: $('#propinsi_usaha_id').val() },
                                function(data) {
                                    $('#show_kabupaten_usaha').html(data);
                                    $('#show_kecamatan_usaha').html('Data Tidak tersedia');
                                    $('#show_kelurahan_usaha').html('Data Tidak tersedia');
                                });
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
        $this->session_info['page_name'] = "Detail Data Permohonan";
        $this->template->build('arsip_detail', $this->session_info);
    }

    function _funcwilayah() {
        $data['list_propinsi'] = $this->propinsi->order_by('n_propinsi', 'ASC')->get();
        $data['list_kabupaten'] = $this->kabupaten->order_by('n_kabupaten', 'ASC')->get();
        $data['list_kecamatan'] = $this->kecamatan->order_by('n_kecamatan', 'ASC')->get();
        $data['list_kelurahan'] = $this->kelurahan->order_by('n_kelurahan', 'ASC')->get();
        $data['list_kegiatan'] = $this->kegiatan->order_by('n_kegiatan', 'ASC')->get();
        $data['list_investasi'] = $this->investasi->order_by('n_investasi', 'ASC')->get();
        return $data;
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
        //var_dump($arr);
    }

    public function save() {
		$u_ser = $this->session->userdata('username');
		$r_name = $this->lib_date->get_nama_ori($u_ser);
        $syarat = $this->input->post('pemohon_syarat');
        $syarat_len = count($syarat);
		$is_array = NULL;
		$kd_lampiran = '';
        for ($i = 0; $i < $syarat_len; $i++) {
            if ($is_array !== $syarat[$i]) {
				if($i == 0)
				    $kd_lampiran = $syarat[$i];
				else
				    $kd_lampiran = $kd_lampiran . '^' . $syarat[$i];
            }
            $is_array = $syarat[$i];
        }

		$syarat = $this->input->post('keaslian_syarat_wajib');
        $syarat_len = count($syarat);
		$is_array = NULL;
		$kd_asli_wajib = '';
        for ($i = 0; $i < $syarat_len; $i++) {
            if ($is_array !== $syarat[$i]) {
				if($i == 0)
				    $kd_asli_wajib = $syarat[$i];
				else
				    $kd_asli_wajib = $kd_asli_wajib . '^' . $syarat[$i];
            }
            $is_array = $syarat[$i];
        }

        $syarat = $this->input->post('keaslian_syarat_lainnya');
        $syarat_len = count($syarat);
		$is_array = NULL;
		$kd_asli_lain = '';
        for ($i = 0; $i < $syarat_len; $i++) {
            if ($is_array !== $syarat[$i]) {
				if($i == 0)
				    $kd_asli_lain = $syarat[$i];
				else
				    $kd_asli_lain = $kd_asli_lain . '^' . $syarat[$i];
            }
            $is_array = $syarat[$i];
        }

		$syarat_len = $this->input->post('jumlah_syarat');
		$kd_ket_wajib = '';
        for ($i = 0; $i < $syarat_len; $i++) {
			$ket_wajib = 'ket_wajib'.strval($i+1);
			$isi_ket_wajib = $this->input->post($ket_wajib);
			if($isi_ket_wajib == '') $isi_ket_wajib = '-';
			$ket_id = 'id_wajib'.strval($i+1);
			if($i == 0)
			    $kd_ket_wajib = $this->input->post($ket_id).';'.$isi_ket_wajib;
			else
			    $kd_ket_wajib = $kd_ket_wajib . '^' . $this->input->post($ket_id).';'.$isi_ket_wajib;
        }
        
		$syarat1 = $this->input->post('syarat1'); if($syarat1 == '') $syarat1 = '-';
		$syarat2 = $this->input->post('syarat2'); if($syarat2 == '') $syarat2 = '-';
		$syarat3 = $this->input->post('syarat3'); if($syarat3 == '') $syarat3 = '-';
		$syarat4 = $this->input->post('syarat4'); if($syarat4 == '') $syarat4 = '-';
		$syarat5 = $this->input->post('syarat5'); if($syarat5 == '') $syarat5 = '-';
		$syarat_lain = $syarat1.'^'.$syarat2.'^'.$syarat3.'^'.$syarat4.'^'.$syarat5;

        $ket_lain1 = $this->input->post('ket_lain1'); if($ket_lain1 == '') $ket_lain1 = '-';
		$ket_lain2 = $this->input->post('ket_lain2'); if($ket_lain2 == '') $ket_lain2 = '-';
		$ket_lain3 = $this->input->post('ket_lain3'); if($ket_lain3 == '') $ket_lain3 = '-';
		$ket_lain4 = $this->input->post('ket_lain4'); if($ket_lain4 == '') $ket_lain4 = '-';
		$ket_lain5 = $this->input->post('ket_lain5'); if($ket_lain5 == '') $ket_lain5 = '-';
		$ket_lain = $ket_lain1.'^'.$ket_lain2.'^'.$ket_lain3.'^'.$ket_lain4.'^'.$ket_lain5;
		
		$tahun  = $this->input->post('tahun') ; if($tahun  == '') $tahun  = '-';
		$jumlah = $this->input->post('jumlah'); if($jumlah == '') $jumlah = '-';
		$sampul = $this->input->post('sampul'); if($sampul == '') $sampul = '-';
		$box    = $this->input->post('box')   ; if($box    == '') $box    = '-';
		$rak    = $this->input->post('rak')   ; if($rak    == '') $rak    = '-';
		$desc_arsip = $tahun.'^'.$jumlah.'^'.$sampul.'^'.$box.'^'.$rak;
		
        $id_daftar = $this->input->post('id_daftar');
		$permohonan = new tmpermohonan();
		$permohonan->get_by_id($id_daftar);
		$no_pendaftaran = $permohonan->pendaftaran_id;
		$permohonan->syarat_arsip = $kd_lampiran;        // simpan u/ persyaratan izin wajib dan tidak wajib (dlm syarat perizinan) ada atau tidak
        $permohonan->arsip_asli = $kd_asli_wajib;        // simpan u/ keaslian persyaratan izin wajib dan tidak wajib (dlm syarat perizinan) ada atau tidak
		$permohonan->syarat_arsip_lain = $syarat_lain;   // simpan u/ persyaratan lainnya
        $permohonan->arsip_asli_lain = $kd_asli_lain;    // simpan u/ keaslian persyaratan izin lainnya ada atau tidak
		$permohonan->ket_syarat_arsip = $kd_ket_wajib;   // simpan u/ keterangan persyaratan wajib
		$permohonan->ket_syarat_arsip_lain = $ket_lain;  // simpan u/ keterangan persyaratan lainnya
		$permohonan->desc_arsip = $desc_arsip;           // simpan u/ identitas arsip tahun^jumlah^sampul^box^rak
        $permohonan->save();

        /* Input Data Tracking Progress */
        $tracking_izin = new tmtrackingperizinan();
		$tracking_izin->where('pendaftaran_id', $no_pendaftaran)
		              ->where('tr_activiti', 'Arsip')->get();
   		if($tracking_izin->pendaftaran_id){
			$tracking_izin->status = 'Update';
            $tracking_izin->d_entry = $this->lib_date->get_date_now();
            $tracking_izin->tr_user = $u_ser;
            $tracking_izin->tr_name = $r_name;
  			$hit_ubah = $tracking_izin->hit_ubah + 1;
            $his_ubah = $tracking_izin->his_ubah;
            $tracking_izin->hit_ubah = $hit_ubah;
            $tracking_izin->his_ubah = $his_ubah.'ARSIP^'.$r_name.'^'.$this->lib_date->get_date_now().';';
            $tracking_izin->save();             // hanya edit di tracking_izin
        }

        $tgl = date("Y-m-d H:i:s");
        $u_ser = $this->session->userdata('username');
        $g = $this->sql($u_ser);
        //$p = $this->db->query("call log ('Pengarsipan','Update " . $no_pendaftaran . "','" . $tgl . "','" . $u_ser . "')");
        redirect('arsip/arsip/list_index');
//        $this->uploadfile();
    }

    public function proses_upload() {
		echo "Masuk ke fungsi";
		$uploads = $_FILES['file_upload']['name'];
        if (!empty($uploads)) {
			$configs['overwrite'] = FALSE;
            $config['upload_path'] = './uploads/lampiran/';
            $config['allowed_types'] = 'pdf|png|jpg|jpeg';
            $config['max_size'] = '1000';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $field = 'file_upload';
            if (!$this->upload->do_upload($field)) {
				$uploaded = $this->upload->data();
                $file = $uploaded['file_name'];
//				$data2['lampiran'] = base_url() . 'uploads/lampiran/' . $file;  //untuk menyimpan nama file
			}
		}
//        if(isset($_POST[submit])){
//            $direktori = 'D:/coba/';                    //Folder penyimpanan file
//            $max_size  = 1000000*10;                  //Ukuran file maximal 10mb
//            $nama_file = $_FILES['file']['name'];     //Nama file yang akan di Upload
//            $file_size = $_FILES['file']['size'];     //Ukuran file yang akan di Upload
//            $nama_tmp  = $_FILES['file']['tmp_name']; //Nama file sementara
//            $upload = $direktori . $nama_file;        //Memposisikan direktori penyimpanan dan file
//            //Proses akan dimulai apabila File telah dipilih sebelumnya 
//			echo "File Gagal di Upload karena anda tidak memilih file apapun!";
//            if($nama_file == ""){
//	    		echo "File Gagal di Upload karena anda tidak memilih file apapun!";
//		    } else {
//                //Proses upload file jika ukuran lebih kecil dari yang di tentukan
//                if($file_size <= $max_size) {
//                    if(move_uploaded_file($nama_tmp, $upload)){
//				        echo "File Berhasil diupload ke Direktori: ".$direktori.$nama_file."";
//            		} else {
//	    				echo "File ".$nama_file." Gagal diupload, karena berbagai macam alasan!";}
//                    }
//		        else {
//                    //Jika ukuran file lebih besar dari yang ditentukan
//                    echo "File ".$nama_file." Gagal di Upload, karena terlalu besar, batas yang ditentukan adalah : ".$max_size." bait.";
//                }
//		    }
//	    } else {
//            echo "Harus melalui Form Upload sebelum ke halaman ini!";
//        }
    }

    public function cetak_arsip() {
		$query = $this->view_query();
        $username = new user();
        $username->where('username', $this->session->userdata('username'))->get();
		$tgla = $username->gvar1;
        $tglb = $username->gvar2;
		$list_sektor = $username->gvar3;
		$mark = $username->gvar4;
		$lokasi_user = $this->session->userdata('lokasi');
        
        //if ($lokasi_user === 'Pusat')  // Untuk daerah lain
		if ($lokasi_user === 'BPMPT Prov. tasikmalaya' || $lokasi_user === 'BPPT Prov. tasikmalaya')
			$query .= "";
        else
		    $query .= " AND A.kd_gerai = '" . $username->lokasi . "'";
		
        if($list_sektor == '0'){  // Semua Sektor
            $bidang = "SEMUA SEKTOR";
		} else {
			$query .= " AND A.trsektor_id = '" . $list_sektor . "'";
			$sektor = new trsektor();
            $bidang = $sektor->get_by_id($list_sektor)->n_sektor;
		}
		$query .= " AND A.d_terima_berkas between '$tgla' and '$tglb'";
		$query .= " order by A.id DESC";

		$obj=$this->db->query($query)->result();

        $i=0;
		$jumlah = 0;
		$hal = 1;
		$gt_hal = TRUE;
		foreach ($obj as $row){
            $jumlah++;
            if($gt_hal) {
				$gt_hal = FALSE;
                $file = 'data_arsip'.$hal.'.xls';
				$hal++;
                header("Content-Type: application/vnd.ms-excel");
                header("Content-Disposition: attachment; filename=".$file);
                header("Pragma: no-cache");
                header("Expires: 0");
		        echo "<table width='100%' border='0' font-size:16px;'>";
		        echo "<tr>DAFTAR ARSIP PERIZINAN BIDANG : ".$bidang."</tr>";
                echo "<tr>PERIODE : ".$this->lib_date->mysql_to_human($tgla)." - ".$this->lib_date->mysql_to_human($tglb)."</tr>";
                echo "</table>";
                echo "<table width='100%' cellspacing='0' cellpadding='0' border='1' style='border-style:solid; border-width:thin;font-size:10px;'>";
                echo "<tr>
                          <td>".'NOMOR'."</td>
                          <td>".'NOMOR PENDAFTARAN'."</td>
						  <td>".'JENIS PERMOHONAN'."</td>
                          <td>".'TANGGAL DAFTAR'."</td>
                          <td>".'NAMA PEMOHON'."</td>
                          <td>".'TANGGAL SELESAI'."</td>
						  <td>".'NOMOR SK'."</td>
                          <td>".'KELENGKAPAN PERSYARATAN'."</td>
                          <td>".'TAHUN'."</td>
                          <td>".'JUMLAH'."</td>
						  <td>".'SAMPUL'."</td>
                          <td>".'BOX'."</td>
						  <td>".'RAK'."</td>
						  <td>".'KETERANGAN'."</td>
                      </tr>";
			    echo "</table>";
            }

            if($row->desc_arsip != '') {
    			$i++;
	    		$jumlah++;
                $tgl_selesai = $row->tgl_surat_edit;
                if($tgl_selesai == "0000-00-00") $tgl_selesai = $row->tgl_surat;
    			$no_surat = $row->no_surat_edit;
                if($no_surat == "") $no_surat = $row->no_surat;
                
				$dt_izin = new trperizinan();
				$id_izin = $dt_izin->get_by_id($row->idizin);
			    $syarat_perizinan = new trsyarat_perizinan();
                $syarat_izin = $syarat_perizinan->where_related($dt_izin)->order_by('status', 'asc')->get();
                
				// Ambil Nilai Keterangan Arsip (tahun,jumlah,sampul,box,rak)
	            $val_ket_arsip = $row->desc_arsip;
				$tahun = '-';
        		$jumlah = '-';
  				$sampul = '-';
    	        $box = '-';
				$rak = '-';
				if($val_ket_arsip){
            	    $hitung = strlen($val_ket_arsip);
                    $cek_posisi = strpos($val_ket_arsip,'^');
                    $a = 1;
                    while ($a < 50) {
                        $item_arsip = substr($val_ket_arsip,0,$cek_posisi);
                        $val_ket_arsip = substr($val_ket_arsip,$cek_posisi+1,$hitung);
                        $hitung = strlen($val_ket_arsip);
                        $cek_posisi = strpos($val_ket_arsip,'^');
                        if($a == 1) {
		        		    $opsi_koefisien = array($item_arsip => $item_arsip);
                        } else {
						    $tempArray = array( $item_arsip => $item_arsip);
                            $opsi_koefisien = array_merge ($opsi_koefisien, $tempArray);
                        }
                        if($cek_posisi == "") {
                            $a = $a + 1;
			    		    $tempArray = array( $val_ket_arsip => $val_ket_arsip);
                            $opsi_koefisien = array_merge ($opsi_koefisien, $tempArray);
                            $a = 51;
                        }
                        $a = $a + 1;
                    }
					$a = 1;
					foreach ($opsi_koefisien as $cek_ket_arsip) {
        			   if($a == 1 ) $tahun = $cek_ket_arsip;
		               if($a == 2 ) $jumlah = $cek_ket_arsip;
	    		       if($a == 3 ) $sampul = $cek_ket_arsip;
    				   if($a == 4 ) $box = $cek_ket_arsip;
					   if($a == 5 ) $rak = $cek_ket_arsip;
                       $a++;
		        	}
                }
                
				// merubah data menjadi array keaslian syarat wajib
				$val_combo_asli = $row->arsip_asli;
				if($val_combo_asli){
					$cek_val_combo_asli = TRUE;
    				$hitung = strlen($val_combo_asli);
                    $cek_posisi = strpos($val_combo_asli,'^');
                    if($cek_posisi == 0) $cek_posisi = $hitung+1;
                    $a = 1;
                    while ($a < 50) {
                        $item_combo = substr($val_combo_asli,0,$cek_posisi);
                        $val_combo_asli = substr($val_combo_asli,$cek_posisi+1,$hitung);
                        $hitung = strlen($val_combo_asli);
                        $cek_posisi = strpos($val_combo_asli,'^');
                        if($a == 1) {
						    $opsi_koefisien_asli = array($item_combo => $item_combo);
                        } else {
						    $tempArray = array( $item_combo => $item_combo);
                            $opsi_koefisien_asli = array_merge ($opsi_koefisien_asli, $tempArray);
                        }
                        if($cek_posisi == "") {
                            $a = $a + 1;
			    		    $tempArray = array( $val_combo_asli => $val_combo_asli);
                            $opsi_koefisien_asli = array_merge ($opsi_koefisien_asli, $tempArray);
                            $a = 51;
                        }
                        $a = $a + 1;
                    }
                } else {
					$cek_val_combo_asli = FALSE;
				}

				// merubah data menjadi array keberadaan syarat wajib
				$val_combo_syarat = $row->syarat_arsip;
				if($val_combo_syarat){
					$cek_val_combo = TRUE;
    				$hitung = strlen($val_combo_syarat);
                    $cek_posisi = strpos($val_combo_syarat,'^');
					if($cek_posisi == 0) $cek_posisi = $hitung+1;
                    $a = 1;
                    while ($a < 50) {
                        $item_combo = substr($val_combo_syarat,0,$cek_posisi);
                        $val_combo_syarat = substr($val_combo_syarat,$cek_posisi+1,$hitung);
                        $hitung = strlen($val_combo_syarat);
                        $cek_posisi = strpos($val_combo_syarat,'^');
                        if($a == 1) {
					        $opsi_koefisien_syarat = array($item_combo => $item_combo);
                        } else {
							$tempArray = array( $item_combo => $item_combo);
                            $opsi_koefisien_syarat = array_merge ($opsi_koefisien_syarat, $tempArray);
                        }
                        if($cek_posisi == "") {
                            $a = $a + 1;
			    		    $tempArray = array( $val_combo_syarat => $val_combo_syarat);
                            $opsi_koefisien_syarat = array_merge ($opsi_koefisien_syarat, $tempArray);
                            $a = 51;
                        }
                        $a = $a + 1;
                    }
                } else {
					$cek_val_combo = FALSE;
				}
			    
                $ln = 0;
				echo "<table width='100%' cellspacing='0' cellpadding='0' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>";
				foreach ($syarat_izin as $srt){
                    $show_syarat = new trperizinan_syarat();
                    $show_syarat->where('trsyarat_perizinan_id', $srt->id)->where('trperizinan_id', $row->idizin)->get();
                    $var = $show_syarat->c_show_type;
                    $rule = strval(decbin($var));
                    if (strlen($rule) < 4) {
                        $len = 4 - strlen($rule);
                        $rule = str_repeat("0", $len) . $rule;
                    }
                    $arr_rule = str_split($rule);
                    $c_baru = $arr_rule[1];
                    $syarat_status = $c_baru;
                    if ($syarat_status == '1') {
					    $srt_asli = '';
                        if($cek_val_combo_asli) {
	    					foreach ($opsi_koefisien_asli as $cek_syarat_asli) {
		    				    if($srt->id == $cek_syarat_asli ) {
			    					$srt_asli = 'ASLI';
							    }
						    }
                        }
                        if($srt_asli == ''){
						    if($cek_val_combo) { 
								$srt_asli = '-';
     					        foreach ($opsi_koefisien_syarat as $cek_syarat) {
							        if($srt->id == $cek_syarat ) $srt_asli = 'V';
								}
							}
						}
					    $ln++;
    					if($ln == 1) {
	    				    echo "<tr>
                                      <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>" .$i."</td>
                			          <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>'".$row->pendaftaran_id."</td>
                                      <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>".$row->n_perizinan."</td>
    		                	      <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>".$this->lib_date->mysql_to_human($row->d_terima_berkas)."</td>
	    				              <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>".$row->n_pemohon."</td>
                                      <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>".$this->lib_date->mysql_to_human($tgl_selesai)."</td>
                                      <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>".$no_surat."</td>
						              <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>".$ln.'. '.$srt->v_syarat."</td>
						              <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>".$tahun."</td>
						              <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>".$jumlah."</td>
						              <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>".$sampul."</td>
						              <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>".$box."</td>
						              <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>".$rak."</td>
						              <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>".$srt_asli."</td>
            	                  </tr>";
					  
					    } else {
                            echo "<tr>
                                      <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>".''."</td>
			                          <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>".''."</td>
                                      <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>".''."</td>
    		                          <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>".''."</td>
                                      <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>".''."</td>
                                      <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>".''."</td>
                                      <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>".''."</td>
                                      <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>".$ln.'. '.$srt->v_syarat."</td>
                                      <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>".''."</td>
                                      <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>".''."</td>
                                      <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>".''."</td>
                                      <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>".''."</td>
                                      <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>".''."</td>
                                      <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>".$srt_asli."</td>
                                  </tr>";
					    }
                    }
				}
                echo "</table>";
				echo "<table width='100%' cellspacing='0' cellpadding='0' border='0' style='border-bottom-style:solid; border-width:thin;font-size:10px;'>";
                echo "<tr>
                          <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>".''."</td>
			              <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>".''."</td>
                          <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>".''."</td>
            	    	  <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>".''."</td>
	    			      <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>".''."</td>
		    		      <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>".''."</td>
			    	      <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>".''."</td>
					      <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>".''."</td>
						  <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>".''."</td>
						  <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>".''."</td>
						  <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>".''."</td>
						  <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>".''."</td>
						  <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>".''."</td>
						  <td valign='top' style='border-left-style:solid; border-right-style:solid; border-width:thin;font-size:10px;'>".''."</td>
            	      </tr>";
				echo "</table>";
		        // diperlukan jika ingin memecah per halaman 
    		    if($jumlah == 50) {
	    			$gt_hal = TRUE;
		    		$jumlah = 0;
                    //echo "</table>"; 
    			}
			}
        }
        echo "</table>";    
    }

    public function sql($u_ser) {
        $query = "select a.description from user_auth as a
	              inner join user_user_auth as  x on a.id = x.user_auth_id
	              inner join user as b on b.id = x.user_id
                  where b.id = (select id from user where username='".$u_ser."')";
        $hasil = $this->db->query($query);
        return $hasil->row();
    }

	public function view_query() {
        $query = "SELECT  A.id, A.pendaftaran_id, A.c_status_bayar, A.d_terima_berkas, A.desc_arsip, A.arsip_asli, A.syarat_arsip,
                  A.keterangan, A.a_izin, A.d_perubahan, A.d_perpanjangan, A.d_daftarulang, A.siap_serah, A.status_berkas, A.kd_gerai, A.nama_file,
                  C.id idizin, C.n_perizinan, 
				  E.n_pemohon, E.telp_pemohon,
                  G.id idjenis, G.n_permohonan,
                  I.status_bap, 
				  K.tgl_surat, K.no_surat, K.c_cetak, K.no_surat_edit, K.tgl_surat_edit, 
				  N.n_sts_permohonan,
                  L.trkelompok_perizinan_id idkelompok
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
                  WHERE A.status_berkas = 'Izin Disetujui'
				 ";
        return $query;
    }

//    function showform($data=array()){
	function showform($hit = Null){
		$username = new user();
        $username->where('username', $this->session->userdata('username'))->get();
		$tgla = $username->gvar1;
        $tglb = $username->gvar2;
	    $list_sektor = $username->gvar3;
		$mark = $username->gvar4;
		$id_daftar = $username->gvar5;
		$menu = $username->gvar10;
    	$this->lib_date->post_variable($username->id, $tgla, $tglb, $list_sektor, $mark, $id_daftar, $hit, '', '', '', $menu);   // post variable
        if($hit == '0'){
            $jdl = "Upload Dokumen Izin Baru";
        } else {
	    	if($hit == '999'){
		   		$jdl = "Upload Penambahan Dokumen Izin";
		    } else {
			    $jdl = "Upload Perubahan Dokumen Izin Lama";
		    }
		}
		$data["judulapp"]=$jdl;
		$data["scriptaksi"]="arsip/uploadfile";
		$data["aksi"]="Upload";
		$data["error"]=(isset($data["error"]))?$data["error"]:"";
		$viewfile="v_cupload_form";
		$this->load->view($viewfile,$data);
	}

    function deleteform($hit = Null){
		$username = new user();
        $username->where('username', $this->session->userdata('username'))->get();
		$tgla = $username->gvar1;
        $tglb = $username->gvar2;
	    $list_sektor = $username->gvar3;
		$mark = $username->gvar4;
		$id_daftar = $username->gvar5;
		$menu = $username->gvar10;
    	$this->lib_date->post_variable($username->id, $tgla, $tglb, $list_sektor, $mark, $id_daftar, $hit, '', '', '', $menu);   // post variable

		$permohonan = new tmpermohonan();
        $permohonan->get_by_id($id_daftar);
        $isi = $permohonan->nama_file;
        $val_combo_name =  $isi;
        $hitung = strlen($val_combo_name);
        $cek_posisi = strpos($val_combo_name,'^');
    	if($cek_posisi == 0) $cek_posisi = $hitung+1;
        $a = 1;
		$name='';
        while ($a < 50) {
            if($a == $hit) 
                $item_combo='dihapus';
			else
                $item_combo = substr($val_combo_name,0,$cek_posisi);

            if($item_combo != 'dihapus') {
				if($a == 1)
                $name = $item_combo;
			else
                $name = $name .'^'. $item_combo;
			}

            $val_combo_name = substr($val_combo_name,$cek_posisi+1,$hitung);
            $hitung = strlen($val_combo_name);
            $cek_posisi = strpos($val_combo_name,'^');
            if($cek_posisi == "") { // jika item terakhir
                $a++;
				if($a == $hit) {
					$val_combo_name='dihapus';
				}
                if($a != $hit) {
    				$name = $name .'^'. $val_combo_name;
				}
                $a = 51;
            }
            $a++;
           } 
		   if(substr($name,-1) == '^') $name=substr($name,1,strlen($name)-1);
		   if(substr($name,0,1)  == '^') $name=substr($name,1,strlen($name));
		   if($name == null) 
			   $permohonan->nama_file = null;                     // simpan u/ nama file upload baru
		   else
		       $permohonan->nama_file = $name;                     // simpan u/ nama file upload baru
           $permohonan->save();
           redirect('arsip/edit'.'/E/'.$id_daftar.'/0/');   // E:edit; L:List, 0:Menu Asal 
	}

	function uploadfile(){
		$config['upload_path'] = './doc-izin';
//        $config['allowed_types'] = 'csv|txt|gif|jpg|png|pdf|doc|docx|xls|xlsx|ppt|pptx|ini';
        $config['allowed_types'] = 'gif|jpg';
        $config['overwrite']= true;
        $config['max_size']	= '20000000';
        $config['max_width']  = '2600';
        $config['max_height']  = '4000';
        $this->load->library('upload', $config);
		$username = new user();
        $username->where('username', $this->session->userdata('username'))->get();
		$tgla = $username->gvar1;
        $tglb = $username->gvar2;
	    $list_sektor = $username->gvar3;
		$mark = $username->gvar4;
		$id_daftar = $username->gvar5;
		$hit = $username->gvar6;
		$name = $username->gvar7;
		$menu = $username->gvar10;
		if ( ! $this->upload->do_upload()){
			//$error = array('error' => $this->upload->display_errors());
			//$this->showform($error);
	    	$this->lib_date->post_variable($username->id, $tgla, $tglb, $list_sektor, $mark, '', '', '', '', '', $menu);   // post variable
		} else{
			//$data = array('upload_data' => $this->upload->data());
            //$data["judulapp"]="Upload Dokumen Izin";
			//$this->load->view('v_cupload_hasil', $data);
	        $array = $this->upload->data();
			$nama_file = $array['file_name'];
			$permohonan = new tmpermohonan();
    		$permohonan->get_by_id($id_daftar);
            $isi = $permohonan->nama_file;

			if($isi == '') {
                $permohonan->nama_file = $nama_file;                     // simpan u/ nama file upload baru
                $permohonan->save();
            } else {
                if($hit == '999') {
                    $permohonan->nama_file = $isi.'^'.$nama_file;        // simpan u/ nama file upload tambah baru
                    $permohonan->save();
				} else {                                                 // simpan u/ nama file upload Edit
                    $val_combo_name =  $isi;
        			$hitung = strlen($val_combo_name);
                    $cek_posisi = strpos($val_combo_name,'^');
    				if($cek_posisi == 0) $cek_posisi = $hitung+1;
                    $a = 1;
					$name = "";
                    while ($a < 50) {
						if($a == $hit)
							$item_combo = $nama_file;
						else
                            $item_combo = substr($val_combo_name,0,$cek_posisi);
						$name = $name . $item_combo . '^';
                        $val_combo_name = substr($val_combo_name,$cek_posisi+1,$hitung);
                        $hitung = strlen($val_combo_name);
                        $cek_posisi = strpos($val_combo_name,'^');
                        if($cek_posisi == "") { // jika item terakhir
						    $a++;
                            if($a == $hit)
                                $name = $name . $nama_file;
							else
								$name = $name . $val_combo_name;
                            $a = 51;
                        }
                        $a++;
                    } 
					$permohonan->nama_file = $name;        // simpan u/ nama file upload
                    $permohonan->save();
			    }
			}

	    	$this->lib_date->post_variable($username->id, $tgla, $tglb, $list_sektor, $mark, $name_file, '', '', '', '', $menu);   // post variable
		}
		redirect('arsip/edit'.'/E/'.$id_daftar.'/0/');   // E:edit; L:List, 0:Menu Asal
	}

}

// This is the end of role class