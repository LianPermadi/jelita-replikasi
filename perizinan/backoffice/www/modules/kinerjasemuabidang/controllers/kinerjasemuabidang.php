<?php

class Kinerjasemuabidang extends WRC_AdminCont {

    public function __construct() {
        parent::__construct();
        $this->permohonan = new tmpermohonan();
        $this->perizinan = new trperizinan();
        $this->status = new trstspermohonan();
        $this->sektor = new trsektor();

        $enabled = FALSE;
        $list_auths = $this->session_info['app_list_auth'];
        $this->kinerjasemuabidang = NULL;

        foreach ($list_auths as $list_auth) {
            if($list_auth->id_role === '10') {
                $enabled = TRUE;
                $this->kinerjasemuabidang = new user_auth();
            }
        }

        if(!$enabled) {
            redirect('dashboard');
        }
    }

    public function index() {
        $data['list'] = $this->perizinan->limit(0)->get();
        $js =  "
                $(document).ready(function() {
                    $(\"#tabs\").tabs();
                    $('a[rel*=kinerjasemuabidang_box]').facebox();
                    $('a[rel*=realisasi_box]').facebox();
                } );
                $(document).ready(function() {
                    oTable = $('#kinerjasemuabidang').dataTable({
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
        $this->session_info['page_name'] = "Tingkat Penyelesaian Semua Bidang";
        $this->template->build('list', $this->session_info);
    }
    
    public function view() {
        $tgla = $this->input->post('tgla');
        $tglb = $this->input->post('tglb');
        $now = $this->lib_date->get_date_now();
        $tgl_before = date("Y-m-d", mktime(0, 0, 0, date("m"), 1, date("Y")));
        $tgl_after = date("Y-m-d", mktime(0, 0, 0, date("m")+1, 0, date("Y")));
        $username = new user();
        $username->where('username', $this->session->userdata('username'))->get();
        $data['cek_sektor'] = $username->sektor;
	    $data['lokasi'] = $username->lokasi;
        if($tgla && $tglb) {
            $data['tgla'] = $tgla;
            $data['tglb'] = $tglb;
        } else {
            $tgla = $tgl_before;
            $tglb = $tgl_after;
            $data['tgla'] = $tgla;
            $data['tglb'] = $tglb;
        }

        $this->load->vars($data);
        $js =  "
            $(document).ready(function() {
                    $(\"#tabs\").tabs();

                    $('a[rel*=kinerjasemuabidang_box]').facebox();
                    $('a[rel*=realisasi_box]').facebox();
                } );
                $(document).ready(function() {
                        oTable = $('#realisasi').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );
                ";

        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "Tingkat Penyelesaian Semua Bidang";
        $this->template->build('view_kinerjasemuabidang', $this->session_info);
    }

    public function lwview($id = null, $tgla = null, $tglb = null, $sektor = null) {  // per Sektor Ijin
        $d['page_name'] = "Tingkat Penyelesaian Semua Bidang";
        $d['tgla'] = $tgla;
        $d['tglb'] = $tglb;
        $this->load->vars($d);
        $this->load->view('lwview_kinerjasemuabidang', $d);
    }

	public function leview($id = null, $tgla = null, $tglb = null, $sektor = null) {  // per Sektor Ijin
        $d['page_name'] = "Tingkat Penyelesaian Semua Bidang";
        $d['tgla'] = $tgla;
        $d['tglb'] = $tglb;
        $this->load->vars($d);
        $this->load->view('leview_kinerjasemuabidang', $d);
    }

    public function Detail($id = null) {
        $data['page_name'] = "Detail Kinerja Penyelesaian";
        $data['list'] = $this->perizinan->where('id', $id)->get();
        $this->load->vars($data);
		$this->template->build('list_detail_load', $this->session_info);
    }

    public function DetailTahun($id = null, $tgla = null, $tglb = null) { // per Nama Ijin
        $data['page_name'] = "Daftar Rekap Pendaftaran Perbidang";
        $this->permohonan->where("date(d_entry) between '$tgla' and '$tglb'")->get();
        $data['list'] = $this->perizinan->where('id',$id)->get();
        $data['tgla'] = $tgla;
        $data['tglb'] = $tglb;
        $data['izin_id'] = $id;
        $this->load->vars($data);
        $this->template->build('detailtahun_load', $this->session_info);
    }

	public function perbidang($id = null, $tgla = null, $tglb = null, $sektor = null) {  // per Sektor Ijin
        $d['page_name'] = "Tingkat Penyelesaian Perjenis Perizinan";
        $d['tgla'] = $tgla;
        $d['tglb'] = $tglb;
        $d['sektor_id'] = $id;
		$d['sektor'] = $sektor;
        $this->load->vars($d);
		$this->template->build('izin_rekap', $this->session_info);
    }

	public function lwperbidang($id = null, $tgla = null, $tglb = null, $sektor = null) {  // per Sektor Ijin
        $d['page_name'] = "Daftar Rekap Pendaftaran Per Bidang";
        $d['tgla'] = $tgla;
        $d['tglb'] = $tglb;
        $d['sektor_id'] = $id;
		$d['sektor'] = $sektor;
        $this->load->vars($d);
        $this->load->view('lwizin_rekap', $d);
    }
	
	public function leperbidang($id = null, $tgla = null, $tglb = null, $sektor = null) {  // per Sektor Ijin
        $d['page_name'] = "Daftar Rekap Pendaftaran Per Bidang";
        $d['tgla'] = $tgla;
        $d['tglb'] = $tglb;
        $d['sektor_id'] = $id;
		$d['sektor'] = $sektor;
        $this->load->vars($d);
        $this->load->view('leizin_rekap', $d);
    }
	
	public function DetailSektorTahun($id = null, $tgla = null, $tglb = null, $sektor = null) {  // per Sektor Ijin
        $d['page_name'] = "Daftar Rekap Pendaftaran Perbidang";
        $d['tgla'] = $tgla;
        $d['tglb'] = $tglb;
        $d['sektor_id'] = $id;
		$d['sektor'] = $sektor;
        $this->load->vars($d);
        $this->template->build('detailsektortahun_load', $this->session_info);
    }
	
	public function izinterbit($id = null, $tgla = null, $tglb = null, $sektor = null) {  // per Sektor Ijin
        $d['page_name'] = "Daftar Rekap Izin Terbit";
        $d['tgla'] = $tgla;
        $d['tglb'] = $tglb;
        $d['sektor_id'] = $id;
		$d['sektor'] = $sektor;
        $this->load->vars($d);
        $this->template->build('izinterbit', $this->session_info);
    }
	
	public function lwizinterbit($id = null, $tgla = null, $tglb = null, $sektor = null) {  // per Sektor Ijin
        $d['page_name'] = "Daftar Rekap Izin Terbit";
        $d['tgla'] = $tgla;
        $d['tglb'] = $tglb;
        $d['sektor_id'] = $id;
		$d['sektor'] = $sektor;
        $this->load->vars($d);
        $this->load->view('lwizinterbit', $d);
    }
	
	public function leizinterbit($id = null, $tgla = null, $tglb = null, $sektor = null) {  // per Sektor Ijin
        $d['page_name'] = "Daftar Rekap Izin Terbit";
        $d['tgla'] = $tgla;
        $d['tglb'] = $tglb;
        $d['sektor_id'] = $id;
		$d['sektor'] = $sektor;
        $this->load->vars($d);
        $this->load->view('leizinterbit', $d);
    }
	
	public function izintolak($id = null, $tgla = null, $tglb = null, $sektor = null) {  // per Sektor Ijin
        $d['page_name'] = "Daftar Rekap Izin Ditolak";
        $d['tgla'] = $tgla;
        $d['tglb'] = $tglb;
        $d['sektor_id'] = $id;
		$d['sektor'] = $sektor;
        $this->load->vars($d);
        $this->template->build('izintolak',$this->session_info);
    }
	
	public function lwizintolak($id = null, $tgla = null, $tglb = null, $sektor = null) {  // per Sektor Ijin
        $d['page_name'] = "Daftar Rekap Izin Ditolak";
        $d['tgla'] = $tgla;
        $d['tglb'] = $tglb;
        $d['sektor_id'] = $id;
		$d['sektor'] = $sektor;
        $this->load->vars($d);
        $this->load->view('lwizintolak', $d);
    }
	
	public function leizintolak($id = null, $tgla = null, $tglb = null, $sektor = null) {  // per Sektor Ijin
        $d['page_name'] = "Daftar Rekap Izin Ditolak";
        $d['tgla'] = $tgla;
        $d['tglb'] = $tglb;
        $d['sektor_id'] = $id;
		$d['sektor'] = $sektor;
        $this->load->vars($d);
        $this->load->view('leizintolak', $d);
    }
	
	public function izinproses($id = null, $tgla = null, $tglb = null, $sektor = null) {  // per Sektor Ijin
        $d['page_name'] = "Daftar Rekap Izin Proses";
        $d['tgla'] = $tgla;
        $d['tglb'] = $tglb;
        $d['sektor_id'] = $id;
		$d['sektor'] = $sektor;
        $this->load->vars($d);
        $this->template->build('izinproses2', $this->session_info);
    }
	
	public function lwizinproses($id = null, $tgla = null, $tglb = null, $sektor = null) {  // per Sektor Ijin
        $d['page_name'] = "Daftar Rekap Izin Proses";
        $d['tgla'] = $tgla;
        $d['tglb'] = $tglb;
        $d['sektor_id'] = $id;
		$d['sektor'] = $sektor;
        $this->load->vars($d);
        $this->load->view('lwizinproses2', $d);
    }
	
	public function leizinproses($id = null, $tgla = null, $tglb = null, $sektor = null) {  // per Sektor Ijin
        $d['page_name'] = "Daftar Rekap Izin Ditolak";
        $d['tgla'] = $tgla;
        $d['tglb'] = $tglb;
        $d['sektor_id'] = $id;
		$d['sektor'] = $sektor;
        $this->load->vars($d);
        $this->load->view('leizinproses2', $d);
    }
	
	public function lwpemohon($id = null, $tgla = null, $tglb = null, $sektor = null) {  // per Sektor Ijin
        $d['page_name'] = "Daftar Rekap Pendaftaran Per Bidang";
        $d['tgla'] = $tgla;
        $d['tglb'] = $tglb;
        $d['sektor_id'] = $id;
		$d['sektor'] = $sektor;
        $this->load->vars($d);
        $this->load->view('lwpemohon', $d);
    }
	
	public function lepemohon($id = null, $tgla = null, $tglb = null, $sektor = null) {  // per Sektor Ijin
        $d['page_name'] = "Daftar Rekap Pendaftaran Per Bidang";
        $d['tgla'] = $tgla;
        $d['tglb'] = $tglb;
        $d['sektor_id'] = $id;
		$d['sektor'] = $sektor;
        $this->load->vars($d);
        $this->load->view('lepemohon', $d);
    }
	
}