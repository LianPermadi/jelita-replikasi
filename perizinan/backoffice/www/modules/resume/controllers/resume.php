
<?php

class Resume extends WRC_AdminCont {

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

  	
	//controller resume evaluasi
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

        $this->session_info['page_name'] = " Resume Evaluasi Perbidang ";
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

        $this->session_info['page_name'] = "Resume Evaluasi Perbidang ";
        $this->template->build('view_resume', $this->session_info);
    }
	public function lwview($id = null, $tgla = null, $tglb = null, $sektor = null) {  // per Sektor Ijin
        $d['page_name'] = "Resume Evaluasi Perbidang";
        //$this->permohonan->where("date(d_entry) between '$tgla' and '$tglb'")->get();
		//$this->permohonan->where_related("trstspermohonan", 'id <> 1')->where("trsektor_id = '$id' AND d_terima_berkas between '$tgla' and '$tglb'")->get();
        //$d['list'] = $this->perizinan->where('id',$id)->get();
        $d['tgla'] = $tgla;
        $d['tglb'] = $tglb;
        //$d['sektor_id'] = $id;
		//$d['sektor'] = $sektor;
        $this->load->vars($d);
        $this->load->view('lwview_resume', $d);
    }
	public function leview($id = null, $tgla = null, $tglb = null, $sektor = null) {  // per Sektor Ijin
        $d['page_name'] = "Resume Evaluasi Perbidang";
        //$this->permohonan->where("date(d_entry) between '$tgla' and '$tglb'")->get();
		//$this->permohonan->where_related("trstspermohonan", 'id <> 1')->where("trsektor_id = '$id' AND d_terima_berkas between '$tgla' and '$tglb'")->get();
        //$d['list'] = $this->perizinan->where('id',$id)->get();
        $d['tgla'] = $tgla;
        $d['tglb'] = $tglb;
        //$d['sektor_id'] = $id;
		//$d['sektor'] = $sektor;
        $this->load->vars($d);
        $this->load->view('leview_resume', $d);
    }
}