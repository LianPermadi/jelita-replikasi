<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of penjadwalan
 *
 * @author Eva
 */
class Izin extends WRC_AdminCont {

    public function __construct() {
        parent::__construct();
        $this->permohonan      = new tmpermohonan();
        $this->status    = new trstspermohonan2();
        $this->perizinan = new trperizinan();
        $this->mohonstatus = new tmpermohonan_trstspermohonan2();


        $enabled = FALSE;
        $list_auths = $this->session_info['app_list_auth'];
        $this->izin = NULL;

        foreach ($list_auths as $list_auth) {
            if($list_auth->id_role === '10') {
                $enabled = TRUE;
                $this->izin = new user_auth();
            }
        }

        if(!$enabled) {
            redirect('dashboard');
        }

    }

    public function index() {


     $this->periode();
	$this->session_info['page_name'] = "Durasi Perizinan";
        $this->template->build('izin_list', $this->session_info);
       
    }
	
	public function periode(){
	$data['range'] = '';

//        $data['list_tahun'] = $this->permohonan->limit(0)->group_by('d_tahun','ASC')->get();
        $data['list'] = $this->perizinan->limit(0)->get();
//        $data['jum1'] = $this->mohonstatus->where('trstspermohonan_id',13)->count();
//        $data['jum3'] = $this->mohonstatus->where('trstspermohonan_id',14)->count();


        $this->load->vars($data);

        $js =  "
                 $(document).ready(function() {
                    $(\"#tabs\").tabs();

                    $('a[rel*=pendaftar_box]').facebox();
                    $('a[rel*=perusahaan_box]').facebox();
                } );

                $(document).ready(function() {
                        oTable = $('#izin').dataTable({
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
	}
	
public function tanggal(){

        $tgla = $this->input->post('tgla');
        $tglb = $this->input->post('tglb');
        $now = $this->lib_date->get_date_now();
        $tgl_before = date("Y-m-d", mktime(0, 0, 0, date("m"), 1, date("Y")));
        $tgl_after = date("Y-m-d", mktime(0, 0, 0, date("m")+1, 0, date("Y")));

        if($tgla && $tglb){
            $data['tgla'] = $tgla;
            $data['tglb'] = $tglb;
        }else{
            $tgla = $tgl_before;
            $tglb = $tgl_after;
            $data['tgla'] = $tgla;
            $data['tglb'] = $tglb;
        }
//        $query = $this->perizinan->get();
//        $data['list'] = $query;

        $this->load->vars($data);
        $js =  "
                $(document).ready(function() {
                        oTable = $('#realisasi').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );

                ";

        $this->template->set_metadata_javascript($js);

}

//esdm   
   public function esdm() {
   $data['range'] = '';

//        $data['list_tahun'] = $this->permohonan->limit(0)->group_by('d_tahun','ASC')->get();
        $data['list'] = $this->perizinan->limit(0)->get();
//        $data['jum1'] = $this->mohonstatus->where('trstspermohonan_id',13)->count();
//        $data['jum3'] = $this->mohonstatus->where('trstspermohonan_id',14)->count();


        $this->load->vars($data);

        $js =  "
                 $(document).ready(function() {
                    $(\"#tabs\").tabs();

                    $('a[rel*=pendaftar_box]').facebox();
                    $('a[rel*=perusahaan_box]').facebox();
                } );

                $(document).ready(function() {
                        oTable = $('#izin').dataTable({
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
			$this->session_info['page_name'] = "Durasi Perizinan";
        $this->template->build('izin_list', $this->session_info);
  
		$this->tanggal();
		//$this->load->model('mDurasiesdm');
		
		//$s= $this->mDurasiesdm->sql();
		//$this->load->view('izin_rekap',$s);
		
        $this->session_info['page_name'] = "Durasi Per Bidang Perizinan";
        $this->template->build('izin_rekap', $this->session_info);
        }
//sosial
	public function sosial() {
		$this->tanggal();
        $this->session_info['page_name'] = "Durasi Bidang Perizinan Sosial";
        $this->template->build('sosial', $this->session_info);
        }
//perkebunan
public function perkebunan() {
		$this->tanggal();
        $this->session_info['page_name'] = "Durasi Bidang Perizinan Perkebunan";
        $this->template->build('perkebunan', $this->session_info);
        }
//perikanan
public function perikanan() {
		$this->tanggal();
        $this->session_info['page_name'] = "Durasi Bidang Perizinan Perikanan";
        $this->template->build('perikanan', $this->session_info);
        }
//kehutanan
public function kehutanan() {
		$this->tanggal();
        $this->session_info['page_name'] = "Durasi Bidang Perizinan Kehutanan";
        $this->template->build('kehutanan', $this->session_info);
        }
//kesehatan
public function kesehatan() {
		$this->tanggal();
        $this->session_info['page_name'] = "Durasi Bidang Perizinan Kesehatan";
        $this->template->build('kesehatan', $this->session_info);
        }
//perhubungan
public function perhubungan() {
		$this->tanggal();
        $this->session_info['page_name'] = "Durasi Bidang Perizinan Perhubungan";
        $this->template->build('perhubungan', $this->session_info);
        }
//pendidikan
public function pendidikan() {
		$this->tanggal();
        $this->session_info['page_name'] = "Durasi Bidang Perizinan Pendidikan";
        $this->template->build('pendidikan', $this->session_info);
        }
//peternakan
public function peternakan() {
		$this->tanggal();
        $this->session_info['page_name'] = "Durasi Bidang Perizinan Peternakan";
        $this->template->build('peternakan', $this->session_info);
        }
//kebinamargaan
public function binamarga() {
		$this->tanggal();
        $this->session_info['page_name'] = "Durasi Bidang Perizinan Kebinamargaan";
        $this->template->build('binamarga', $this->session_info);
        }
//ketenagakerjaan
public function tenagakerja() {
		$this->tanggal();
        $this->session_info['page_name'] = "Durasi Bidang Perizinan Ketenagakerjaan";
        $this->template->build('tenagakerja', $this->session_info);
        }
//penanaman modal
public function modal() {
		$this->tanggal();
        $this->session_info['page_name'] = "Durasi Bidang Perizinan Penanaman Modal";
        $this->template->build('modal', $this->session_info);
        }
//Penataan Ruang
public function ruang() {
		$this->tanggal();
        $this->session_info['page_name'] = "Durasi Bidang Perizinan Renataan Ruang";
        $this->template->build('ruang', $this->session_info);
        }
//Lingkungan Hidup
public function lingkungan() {
		$this->tanggal();
        $this->session_info['page_name'] = "Durasi Bidang Perizinan Lingkungan Hidup";
        $this->template->build('lingkungan', $this->session_info);
        }
//Industri dan Perdagangan
public function industri() {
		$this->tanggal();
        $this->session_info['page_name'] = "Durasi Bidang Perizinan Industri dan perdagangan";
        $this->template->build('industri', $this->session_info);
        }
//Komunikasi dan Informasi
public function komunikasi() {
		$this->tanggal();
        $this->session_info['page_name'] = "Durasi Bidang Perizinan Komunikasi dan Informasi";
        $this->template->build('komunikasi', $this->session_info);
        }
//Pengairan/PSDA
    public function pengairan() {
		$this->tanggal();
        $this->session_info['page_name'] = "Durasi Bidang Perizinan Pengairan";
        $this->template->build('pengairan', $this->session_info);
        }
}
