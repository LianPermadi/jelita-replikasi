<?php
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
        $this->sektor = new trsektor();

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
		$username = new user();
        $username->where('username', $this->session->userdata('username'))->get();
		$data['lokasi'] = $username->lokasi;
        $data['list_data'] = $this->sektor->order_by('urutan', 'ASC')->get();
        $this->load->vars($data);
        $this->periode();
	    $this->session_info['page_name'] = "Kinerja Perizinan";
        $this->template->build('izin_list', $this->session_info);
    }
	
	public function periode(){
        $data['range'] = '';
        $data['list'] = $this->perizinan->limit(0)->get();
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

    public function esdm() {
		$username = new user();
        $username->where('username', $this->session->userdata('username'))->get();
	    $data['cek_sektor'] = $username->sektor;
	    $data['lokasi'] = $username->lokasi;
        $data['range'] = '';
        $data['list'] = $this->perizinan->limit(0)->get();
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
  		$this->tanggal();
        $this->session_info['page_name'] = "Kinerja Per Bidang Perizinan";
        $this->template->build('izin_rekap', $this->session_info);
    }

	public function sosial() {
		$this->tanggal();
        $this->session_info['page_name'] = "Kinerja Bidang Perizinan Sosial";
        $this->template->build('sosial', $this->session_info);
    }

    public function perkebunan() {
		$this->tanggal();
        $this->session_info['page_name'] = "Kinerja Bidang Perizinan Perkebunan";
        $this->template->build('perkebunan', $this->session_info);
    }

    public function perikanan() {
		$this->tanggal();
        $this->session_info['page_name'] = "Kinerja Bidang Perizinan Perikanan";
        $this->template->build('perikanan', $this->session_info);
    }

    public function kehutanan() {
		$this->tanggal();
        $this->session_info['page_name'] = "Kinerja Bidang Perizinan Kehutanan";
        $this->template->build('kehutanan', $this->session_info);
    }

    public function kesehatan() {
		$this->tanggal();
        $this->session_info['page_name'] = "Kinerja Bidang Perizinan Kesehatan";
        $this->template->build('kesehatan', $this->session_info);
    }

    public function perhubungan() {
		$this->tanggal();
        $this->session_info['page_name'] = "Kinerja Bidang Perizinan Perhubungan";
        $this->template->build('perhubungan', $this->session_info);
    }

    public function pendidikan() {
		$this->tanggal();
        $this->session_info['page_name'] = "Kinerja Bidang Perizinan Pendidikan";
        $this->template->build('pendidikan', $this->session_info);
    }

    public function peternakan() {
		$this->tanggal();
        $this->session_info['page_name'] = "Kinerja Bidang Perizinan Peternakan";
        $this->template->build('peternakan', $this->session_info);
    }

    public function binamarga() {
		$this->tanggal();
        $this->session_info['page_name'] = "Kinerja Bidang Perizinan Kebinamargaan";
        $this->template->build('binamarga', $this->session_info);
    }

    public function tenagakerja() {
		$this->tanggal();
        $this->session_info['page_name'] = "Kinerja Bidang Perizinan Ketenagakerjaan";
        $this->template->build('tenagakerja', $this->session_info);
    }

    public function modal() {
		$this->tanggal();
        $this->session_info['page_name'] = "Kinerja Bidang Perizinan Penanaman Modal";
        $this->template->build('modal', $this->session_info);
    }

    public function ruang() {
		$this->tanggal();
        $this->session_info['page_name'] = "Kinerja Bidang Perizinan Renataan Ruang";
        $this->template->build('ruang', $this->session_info);
    }

    public function lingkungan() {
		$this->tanggal();
        $this->session_info['page_name'] = "Kinerja Bidang Perizinan Lingkungan Hidup";
        $this->template->build('lingkungan', $this->session_info);
    }

    public function industri() {
		$this->tanggal();
        $this->session_info['page_name'] = "Kinerja Bidang Perizinan Industri dan perdagangan";
        $this->template->build('industri', $this->session_info);
    }

    public function komunikasi() {
		$this->tanggal();
        $this->session_info['page_name'] = "Kinerja Bidang Perizinan Komunikasi dan Informasi";
        $this->template->build('komunikasi', $this->session_info);
    }

    public function pengairan() {
		$this->tanggal();
        $this->session_info['page_name'] = "Kinerja Bidang Perizinan Pengairan";
        $this->template->build('pengairan', $this->session_info);
    }
}