
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
class Lwpengaduantriwulan extends WRC_AdminCont {

    public function __construct() {
        parent::__construct();
        
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

    
   
	public function lw($tgla = null) {  // per Sektor Ijin
        $d['page_name'] = "Pengaduan Pertriwulan";
        //$this->permohonan->where("date(d_entry) between '$tgla' and '$tglb'")->get();
		//$this->permohonan->where_related("trstspermohonan", 'id <> 1')->where("trsektor_id = '$id' AND d_terima_berkas between '$tgla' and '$tglb'")->get();
        //$d['list'] = $this->perizinan->where('id',$id)->get();
        $d['tgla'] = $tgla;
        //$d['tglb'] = $tglb;
        //$d['sektor_id'] = $id;
		//$d['sektor'] = $sektor;
        $this->load->vars($d);
        $this->load->view('lwtriwulan', $d);
    }
	public function le($tgla = null) {  // per Sektor Ijin
        $d['page_name'] = "Pengaduan Pertriwulan";
        //$this->permohonan->where("date(d_entry) between '$tgla' and '$tglb'")->get();
		//$this->permohonan->where_related("trstspermohonan", 'id <> 1')->where("trsektor_id = '$id' AND d_terima_berkas between '$tgla' and '$tglb'")->get();
        //$d['list'] = $this->perizinan->where('id',$id)->get();
        $d['tgla'] = $tgla;
        //$d['tglb'] = $tglb;
        //$d['sektor_id'] = $id;
		//$d['sektor'] = $sektor;
        $this->load->vars($d);
        $this->load->view('letriwulan', $d);
    }

}