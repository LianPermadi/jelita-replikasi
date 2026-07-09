<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 *  @author  R; 
 */

class C_laporan extends WRC_AdminCont {

    public function __construct() {
        parent::__construct();
        $this->load->model('mlaporan');
        $this->load->library('dompdf_gen');
       
            $enabled = FALSE;
            $list_auths = $this->session_info['app_list_auth'];

            foreach ($list_auths as $list_auth) {
                if($list_auth->id_role === '30') {
                    $enabled = TRUE;
                }
            }

            if(!$enabled) {
                redirect('dashboard');
            }
    }
 
   
 
    public function index()
    {
        $data['title'] = 'Laporan PDF CodeIgniter dengan DOMPdf'; //judul title
        $data['qbarang'] = $this->mlaporan->getAllItem(); //query model semua barang
         $this->load->vars($data);
         $js =  "function confirm_link(text){
                    if(confirm(text)){ return true;
                    }else{ return false; }
                }
                $(document).ready(function() {
                        oTable = $('#laporan').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );

                function confirm_link(text){
                    if(confirm(text)){ return true;
                    }else{ return false; }
                }
                $(document).ready(function() {
                        oTable = $('#l2').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );";
        //$this->load->view('vlaporan',$data);
         $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "CETAK SK";
        $this->template->build('laporan/vlaporan', $this->session_info);
    }
 
    // fungsi cetak pdf
    public function cetakpdf(){
        $data['title'] = 'Cetak PDF Barang'; //judul title
        $data['qbarang'] = $this->mlaporan->getAllItem(); //query model semua barang
 
        $this->load->view('vcetaklaporan', $data);
 
        $paper_size  = 'A4'; //paper size
        $orientation = 'landscape'; //tipe format kertas
        $html = $this->output->get_output();
 
        $this->dompdf->set_paper($paper_size, $orientation);
        //Convert to PDF
        $this->dompdf->load_html($html);
        $this->dompdf->render();
        $this->dompdf->stream("laporan.pdf", array('Attachment'=>0));
    }
}