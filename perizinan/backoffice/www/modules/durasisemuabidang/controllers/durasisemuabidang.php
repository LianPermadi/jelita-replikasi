
<?php

class Durasisemuabidang extends WRC_AdminCont {

    public function __construct() {
        parent::__construct();
        $this->permohonan = new tmpermohonan();
        $this->perizinan = new trperizinan();
        $this->status = new trstspermohonan();
        $this->sektor = new trsektor();

        $enabled = FALSE;
        $list_auths = $this->session_info['app_list_auth'];
        $this->durasisemuabidang = NULL;

        foreach ($list_auths as $list_auth) {
            if($list_auth->id_role === '10') {
                $enabled = TRUE;
                $this->durasisemuabidang = new user_auth();
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
                    $('a[rel*=durasisemuabidang_box]').facebox();
                    $('a[rel*=realisasi_box]').facebox();
                } );
                $(document).ready(function() {
                        oTable = $('#durasisemuabidang').dataTable({
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
        $this->session_info['page_name'] = "Tingkat Ketepatan Semua Bidang";
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
                    $('a[rel*=durasisemuabidang_box]').facebox();
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
        $this->session_info['page_name'] = "Tingkat Ketepatan Semua Bidang";
        $this->template->build('view_durasisemuabidang', $this->session_info);
    }

    public function Detail($id = null) {
        $data['page_name'] = "Detail Daftar Rekap Pendaftaran";
        $data['list'] = $this->perizinan->where('id', $id)->get();
        $this->load->vars($data);
        $this->load->view('list_detail_load', $data);
    }

    public function DetailTahun($id = null, $tgla = null, $tglb = null) { // per Nama Ijin
        $data['page_name'] = "Detail Daftar Rekap Pendaftaran";
        $this->permohonan->where("date(d_entry) between '$tgla' and '$tglb'")->get();
        $data['list'] = $this->perizinan->where('id',$id)->get();
        $data['tgla'] = $tgla;
        $data['tglb'] = $tglb;
        $data['izin_id'] = $id;
        $this->load->vars($data);
        $this->load->view('detailtahun_load', $data);
    }

	public function DetailSektorTahun($id = null, $tgla = null, $tglb = null, $sektor = null) {  // per Sektor Ijin
        $data['page_name'] = "Detail Daftar Rekap Pendaftaran Per Bidang";
		$this->permohonan->where_related("trstspermohonan", 'id <> 1')->where("trsektor_id = '$id' AND d_terima_berkas between '$tgla' and '$tglb'")->get();
        $data['list'] = $this->perizinan->where('id',$id)->get();
        $data['tgla'] = $tgla;
        $data['tglb'] = $tglb;
        $data['sektor_id'] = $id;
		$data['sektor'] = $sektor;
        $this->load->vars($data);
        $this->load->view('detailsektortahun_load', $data);
    }
	public function perbidang($id = null, $tgla = null, $tglb = null, $sektor = null) {  // per Sektor Ijin
        $d['page_name'] = "Rekap Tingkat Ketepatan dan Kecepatan Perjenis";
        $d['tgla'] = $tgla;
        $d['tglb'] = $tglb;
        $d['sektor_id'] = $id;
		$d['sektor'] = $sektor;
        $this->load->vars($d);
        $this->template->build('izin_rekap', $this->session_info);
    }
	public function lwview($id = null, $tgla = null, $tglb = null, $sektor = null) {  // per Sektor Ijin
        $d['page_name'] = "Tingkat Ketepatan Semua Bidang";
        $d['tgla'] = $tgla;
        $d['tglb'] = $tglb;
        $this->load->vars($d);
        $this->load->view('lwview_durasisemuabidang', $d);
    }
	public function leview($id = null, $tgla = null, $tglb = null, $sektor = null) {  // per Sektor Ijin
        $d['page_name'] = "Tingkat Ketepatan Semua Bidang";
        $d['tgla'] = $tgla;
        $d['tglb'] = $tglb;
        $this->load->vars($d);
        $this->load->view('leview_durasisemuabidang', $d);
    }
	public function lwperbidang($id = null, $tgla = null, $tglb = null, $sektor = null) {  // per Sektor Ijin
        $d['page_name'] = "Rekap Tingkat Ketepatan dan Kecepatan Perjenis";
        $d['tgla'] = $tgla;
        $d['tglb'] = $tglb;
        $d['sektor_id'] = $id;
		$d['sektor'] = $sektor;
        $this->load->vars($d);
        $this->load->view('lwizin_rekap', $d);
    }
	public function leperbidang($id = null, $tgla = null, $tglb = null, $sektor = null) {  // per Sektor Ijin
        $d['page_name'] = "Rekap Tingkat Ketepatan dan Kecepatan Perjenis";
        $d['tgla'] = $tgla;
        $d['tglb'] = $tglb;
        $d['sektor_id'] = $id;
		$d['sektor'] = $sektor;
        $this->load->vars($d);
        $this->load->view('leizin_rekap', $d);
    }
	public function perbidangtelat($id = null, $tgla = null, $tglb = null, $sektor = null) {  // per Sektor Ijin
        $d['page_name'] = "Daftar Ketepatan Izin Telat";
        $d['tgla'] = $tgla;
        $d['tglb'] = $tglb;
        $d['sektor_id'] = $id;
		$d['sektor'] = $sektor;
        $this->load->vars($d);
        $this->template->build('durasi_telat', $this->session_info);
    }
	public function lwdurasitelat($id = null, $tgla = null, $tglb = null, $sektor = null) {  // per Sektor Ijin
        $d['page_name'] = "Daftar Ketepatan Izin Telat";
        $d['tgla'] = $tgla;
        $d['tglb'] = $tglb;
        $d['sektor_id'] = $id;
		$d['sektor'] = $sektor;
        $this->load->vars($d);
        $this->load->view('lwdurasi_telat', $d);
    }
	public function ledurasitelat($id = null, $tgla = null, $tglb = null, $sektor = null) {  // per Sektor Ijin
        $d['page_name'] = "Daftar Ketepatan Izin Telat";
        $d['tgla'] = $tgla;
        $d['tglb'] = $tglb;
        $d['sektor_id'] = $id;
		$d['sektor'] = $sektor;
        $this->load->vars($d);
        $this->load->view('ledurasi_telat', $d);
    }	public function lwdurasisesuai($id = null, $tgla = null, $tglb = null, $sektor = null) {  // per Sektor Ijin
        $d['page_name'] = "Daftar Ketepatan Izin Sesuai";
        $d['tgla'] = $tgla;
        $d['tglb'] = $tglb;
        $d['sektor_id'] = $id;
		$d['sektor'] = $sektor;
        $this->load->vars($d);
        $this->load->view('lwdurasi_sesuai', $d);
    }
	public function ledurasisesuai($id = null, $tgla = null, $tglb = null, $sektor = null) {  // per Sektor Ijin
        $d['page_name'] = "Daftar Ketepatan Izin Sesuai";
        $d['tgla'] = $tgla;
        $d['tglb'] = $tglb;
        $d['sektor_id'] = $id;
		$d['sektor'] = $sektor;
        $this->load->vars($d);
        $this->load->view('ledurasi_sesuai', $d);
    }
	public function perbidangsesuai($id = null, $tgla = null, $tglb = null, $sektor = null) {  // per Sektor Ijin
        $d['page_name'] = "Daftar Ketepatan Izin Sesuai";
        $d['tgla'] = $tgla;
        $d['tglb'] = $tglb;
        $d['sektor_id'] = $id;
		$d['sektor'] = $sektor;
        $this->load->vars($d);
        $this->template->build('durasi_sesuai', $this->session_info);
    }
	public function perbidangselesai($id = null, $tgla = null, $tglb = null, $sektor = null) {  // per Sektor Ijin
        $d['page_name'] = "Daftar Ketepatan Izin Selesai";
        $d['tgla'] = $tgla;
        $d['tglb'] = $tglb;
        $d['sektor_id'] = $id;
		$d['sektor'] = $sektor;
        $this->load->vars($d);
        $this->template->build('durasi_selesai', $this->session_info);
    }
	public function lwperbidangselesai($id = null, $tgla = null, $tglb = null, $sektor = null) {  // per Sektor Ijin
        $d['page_name'] = "Daftar Ketepatan Izin Selesai";
        $d['tgla'] = $tgla;
        $d['tglb'] = $tglb;
        $d['sektor_id'] = $id;
		$d['sektor'] = $sektor;
        $this->load->vars($d);
        $this->load->view('lwdurasi_selesai', $d);
    }
	public function leperbidangselesai($id = null, $tgla = null, $tglb = null, $sektor = null) {  // per Sektor Ijin
        $d['page_name'] = "Daftar Ketepatan Izin Selesai";
        $d['tgla'] = $tgla;
        $d['tglb'] = $tglb;
        $d['sektor_id'] = $id;
		$d['sektor'] = $sektor;
        $this->load->vars($d);
        $this->load->view('ledurasi_selesai', $d);
    }

	
	//controller resume evaluasi
    public function indexresume() {

//        $data['list_tahun'] = $this->permohonan->group_by('d_tahun','ASC')->get();
        $data['list'] = $this->perizinan->limit(0)->get();

        $js =  "
                
                $(document).ready(function() {
                    $(\"#tabs\").tabs();

                    $('a[rel*=durasisemuabidang_box]').facebox();
                    $('a[rel*=realisasi_box]').facebox();
                } );
                $(document).ready(function() {
                        oTable = $('#durasisemuabidang').dataTable({
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

        $this->session_info['page_name'] = " Resume Evaluasi Perijinan ";
        $this->template->build('list_resume', $this->session_info);
    }	
	public function viewresume() {
        $tgla = $this->input->post('tgla');
        $tglb = $this->input->post('tglb');
        $now = $this->lib_date->get_date_now();
        $tgl_before = date("Y-m-d", mktime(0, 0, 0, date("m"), 1, date("Y")));
        $tgl_after = date("Y-m-d", mktime(0, 0, 0, date("m")+1, 0, date("Y")));

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

                    $('a[rel*=durasisemuabidang_box]').facebox();
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

        $this->session_info['page_name'] = "Resume Evaluasi Perijinan ";
        $this->template->build('view_durasisemuabidangseluruhdatatampil', $this->session_info);
    }

public function cekresume() {
        $tgla = $this->input->post('tgla');
        $tglb = $this->input->post('tglb');
        $now = $this->lib_date->get_date_now();
        $tgl_before = date("Y-m-d", mktime(0, 0, 0, date("m"), 1, date("Y")));
        $tgl_after = date("Y-m-d", mktime(0, 0, 0, date("m")+1, 0, date("Y")));

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

                    $('a[rel*=durasisemuabidang_box]').facebox();
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

        $this->session_info['page_name'] = "Ketepatan Waktu Penyelesaian Perizinan";
        $this->template->build('view_durasisemuabidangseluruhdatatampil', $this->session_info);
    }

}