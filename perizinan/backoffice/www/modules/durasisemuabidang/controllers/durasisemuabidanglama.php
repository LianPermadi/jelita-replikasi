
<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of penjadwalan
 *
 * @author Yogi Cahyana
 *
 */
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

        $this->session_info['page_name'] = " Waktu Ketepatan Penyelesaian Perijinan ";
        $this->template->build('list', $this->session_info);
    }

    /*
     * create is a method to show page for creating data
     */

    
    public function view() {
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
//        $data['list_tahun'] = $this->permohonan->group_by('d_tahun','ASC')->get();
        $this->permohonan->where("date(d_entry) between '$tgla' and '$tglb'")->get();
        $data['list'] = $this->perizinan->where('id',$id)->get();
        $data['tgla'] = $tgla;
        $data['tglb'] = $tglb;
        $data['izin_id'] = $id;
//        $data['data_tahun'] = $this->input->post('d_tahun');
//        $data['list_tahun'] = $this->permohonan->group_by('d_tahun','ASC')->get();
//        $data['list'] = $this->perizinan->where('id', $id)->get();
//        $data['data_tahun'] = $this->permohonan->where('d_tahun', $tahun)->get();
//        $data['data_th'] = $tahun->get();
        $this->load->vars($data);
        $this->load->view('detailtahun_load', $data);
    }

	public function DetailSektorTahun($id = null, $tgla = null, $tglb = null, $sektor = null) {  // per Sektor Ijin
        $data['page_name'] = "Detail Daftar Rekap Pendaftaran Per Bidang";
        //$this->permohonan->where("date(d_entry) between '$tgla' and '$tglb'")->get();
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
        $d['page_name'] = "Ketepatan Waktu Penyelesaian Perizinan";
        //$this->permohonan->where("date(d_entry) between '$tgla' and '$tglb'")->get();
		//$this->permohonan->where_related("trstspermohonan", 'id <> 1')->where("trsektor_id = '$id' AND d_terima_berkas between '$tgla' and '$tglb'")->get();
        //$d['list'] = $this->perizinan->where('id',$id)->get();
        $d['tgla'] = $tgla;
        $d['tglb'] = $tglb;
        $d['sektor_id'] = $id;
		$d['sektor'] = $sektor;
        $this->load->vars($d);
        $this->load->view('izin_rekap', $d);
    }
	public function lwview($id = null, $tgla = null, $tglb = null, $sektor = null) {  // per Sektor Ijin
        $d['page_name'] = "Ketepatan Waktu Penyelesaian Perizinan";
        //$this->permohonan->where("date(d_entry) between '$tgla' and '$tglb'")->get();
		//$this->permohonan->where_related("trstspermohonan", 'id <> 1')->where("trsektor_id = '$id' AND d_terima_berkas between '$tgla' and '$tglb'")->get();
        //$d['list'] = $this->perizinan->where('id',$id)->get();
        $d['tgla'] = $tgla;
        $d['tglb'] = $tglb;
        //$d['sektor_id'] = $id;
		//$d['sektor'] = $sektor;
        $this->load->vars($d);
        $this->load->view('lwview_durasisemuabidang', $d);
    }
	public function leview($id = null, $tgla = null, $tglb = null, $sektor = null) {  // per Sektor Ijin
        $d['page_name'] = "Ketepatan Waktu Penyelesaian Perizinan";
        //$this->permohonan->where("date(d_entry) between '$tgla' and '$tglb'")->get();
		//$this->permohonan->where_related("trstspermohonan", 'id <> 1')->where("trsektor_id = '$id' AND d_terima_berkas between '$tgla' and '$tglb'")->get();
        //$d['list'] = $this->perizinan->where('id',$id)->get();
        $d['tgla'] = $tgla;
        $d['tglb'] = $tglb;
        //$d['sektor_id'] = $id;
		//$d['sektor'] = $sektor;
        $this->load->vars($d);
        $this->load->view('leview_durasisemuabidang', $d);
    }
	public function lwperbidang($id = null, $tgla = null, $tglb = null, $sektor = null) {  // per Sektor Ijin
        $d['page_name'] = "Ketepatan Waktu Penyelesaian Perizinan";
        //$this->permohonan->where("date(d_entry) between '$tgla' and '$tglb'")->get();
		//$this->permohonan->where_related("trstspermohonan", 'id <> 1')->where("trsektor_id = '$id' AND d_terima_berkas between '$tgla' and '$tglb'")->get();
        //$d['list'] = $this->perizinan->where('id',$id)->get();
        $d['tgla'] = $tgla;
        $d['tglb'] = $tglb;
        $d['sektor_id'] = $id;
		$d['sektor'] = $sektor;
        $this->load->vars($d);
        $this->load->view('lwizin_rekap', $d);
    }
	public function leperbidang($id = null, $tgla = null, $tglb = null, $sektor = null) {  // per Sektor Ijin
        $d['page_name'] = "Ketepatan Waktu Penyelesaian Perizinan";
        //$this->permohonan->where("date(d_entry) between '$tgla' and '$tglb'")->get();
		//$this->permohonan->where_related("trstspermohonan", 'id <> 1')->where("trsektor_id = '$id' AND d_terima_berkas between '$tgla' and '$tglb'")->get();
        //$d['list'] = $this->perizinan->where('id',$id)->get();
        $d['tgla'] = $tgla;
        $d['tglb'] = $tglb;
        $d['sektor_id'] = $id;
		$d['sektor'] = $sektor;
        $this->load->vars($d);
        $this->load->view('leizin_rekap', $d);
    }
	public function perbidangtelat($id = null, $tgla = null, $tglb = null, $sektor = null) {  // per Sektor Ijin
        $d['page_name'] = "Ketepatan Waktu Penyelesaian Perizinan";
        //$this->permohonan->where("date(d_entry) between '$tgla' and '$tglb'")->get();
		//$this->permohonan->where_related("trstspermohonan", 'id <> 1')->where("trsektor_id = '$id' AND d_terima_berkas between '$tgla' and '$tglb'")->get();
        //$d['list'] = $this->perizinan->where('id',$id)->get();
        $d['tgla'] = $tgla;
        $d['tglb'] = $tglb;
        $d['sektor_id'] = $id;
		$d['sektor'] = $sektor;
        $this->load->vars($d);
        $this->load->view('durasi_telat', $d);
    }
	public function lwdurasitelat($id = null, $tgla = null, $tglb = null, $sektor = null) {  // per Sektor Ijin
        $d['page_name'] = "Ketepatan Waktu Penyelesaian Perizinan";
        //$this->permohonan->where("date(d_entry) between '$tgla' and '$tglb'")->get();
		//$this->permohonan->where_related("trstspermohonan", 'id <> 1')->where("trsektor_id = '$id' AND d_terima_berkas between '$tgla' and '$tglb'")->get();
        //$d['list'] = $this->perizinan->where('id',$id)->get();
        $d['tgla'] = $tgla;
        $d['tglb'] = $tglb;
        $d['sektor_id'] = $id;
		$d['sektor'] = $sektor;
        $this->load->vars($d);
        $this->load->view('lwdurasi_telat', $d);
    }
	public function ledurasitelat($id = null, $tgla = null, $tglb = null, $sektor = null) {  // per Sektor Ijin
        $d['page_name'] = "Ketepatan Waktu Penyelesaian Perizinan";
        //$this->permohonan->where("date(d_entry) between '$tgla' and '$tglb'")->get();
		//$this->permohonan->where_related("trstspermohonan", 'id <> 1')->where("trsektor_id = '$id' AND d_terima_berkas between '$tgla' and '$tglb'")->get();
        //$d['list'] = $this->perizinan->where('id',$id)->get();
        $d['tgla'] = $tgla;
        $d['tglb'] = $tglb;
        $d['sektor_id'] = $id;
		$d['sektor'] = $sektor;
        $this->load->vars($d);
        $this->load->view('ledurasi_telat', $d);
    }	public function lwdurasisesuai($id = null, $tgla = null, $tglb = null, $sektor = null) {  // per Sektor Ijin
        $d['page_name'] = "Ketepatan Waktu Penyelesaian Perizinan";
        //$this->permohonan->where("date(d_entry) between '$tgla' and '$tglb'")->get();
		//$this->permohonan->where_related("trstspermohonan", 'id <> 1')->where("trsektor_id = '$id' AND d_terima_berkas between '$tgla' and '$tglb'")->get();
        //$d['list'] = $this->perizinan->where('id',$id)->get();
        $d['tgla'] = $tgla;
        $d['tglb'] = $tglb;
        $d['sektor_id'] = $id;
		$d['sektor'] = $sektor;
        $this->load->vars($d);
        $this->load->view('lwdurasi_sesuai', $d);
    }
	public function ledurasisesuai($id = null, $tgla = null, $tglb = null, $sektor = null) {  // per Sektor Ijin
        $d['page_name'] = "Ketepatan Waktu Penyelesaian Perizinan";
        //$this->permohonan->where("date(d_entry) between '$tgla' and '$tglb'")->get();
		//$this->permohonan->where_related("trstspermohonan", 'id <> 1')->where("trsektor_id = '$id' AND d_terima_berkas between '$tgla' and '$tglb'")->get();
        //$d['list'] = $this->perizinan->where('id',$id)->get();
        $d['tgla'] = $tgla;
        $d['tglb'] = $tglb;
        $d['sektor_id'] = $id;
		$d['sektor'] = $sektor;
        $this->load->vars($d);
        $this->load->view('ledurasi_sesuai', $d);
    }
	public function perbidangsesuai($id = null, $tgla = null, $tglb = null, $sektor = null) {  // per Sektor Ijin
        $d['page_name'] = "Ketepatan Waktu Penyelesaian Perizinan";
        //$this->permohonan->where("date(d_entry) between '$tgla' and '$tglb'")->get();
		//$this->permohonan->where_related("trstspermohonan", 'id <> 1')->where("trsektor_id = '$id' AND d_terima_berkas between '$tgla' and '$tglb'")->get();
        //$d['list'] = $this->perizinan->where('id',$id)->get();
        $d['tgla'] = $tgla;
        $d['tglb'] = $tglb;
        $d['sektor_id'] = $id;
		$d['sektor'] = $sektor;
        $this->load->vars($d);
        $this->load->view('durasi_sesuai', $d);
    }
}