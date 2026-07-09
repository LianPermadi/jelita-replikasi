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
	    $this->session_info['page_name'] = "Ketepatan Perizinan";
        $this->template->build('izin_list', $this->session_info);
    }
	
	public function periode(){
        $data['range'] = '';
        $data['list_tahun'] = $this->permohonan->limit(0)->group_by('d_tahun','ASC')->get();
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
       $this->session_info['page_name'] = "KETEPATAN PERIZINAN SEKTOR ";
       $this->template->build('izin_rekap', $this->session_info);
   }

   public function lwizin($id = null, $tgla = null, $tglb = null, $sektor = null) {  // per Sektor Ijin
       $d['page_name'] = "Ketepatan Perizinan Per Bidang";
       $d['tgla'] = $tgla;
       $d['tglb'] = $tglb;
       $d['sektor_id'] = $id;
	   $this->load->vars($d);
       $this->load->view('lwizin_rekap', $d);
   }
   
   public function leizin($id = null, $tgla = null, $tglb = null, $sektor = null) {  // per Sektor Ijin
       $d['page_name'] = "Ketepatan Perizinan Per Bidang";
       $d['tgla'] = $tgla;
       $d['tglb'] = $tglb;
       $d['sektor_id'] = $id;
	   $this->load->vars($d);
       $this->load->view('leizin_rekap', $d);
   }
}