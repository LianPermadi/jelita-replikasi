<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Claporanpdf extends WRC_AdminCont {
    /*****
     | Laporan PDF dengan DOMPDF
     | controller claporanpdf
     | by gtech
    *****/
 
    public function __construct() {
        parent::__construct();
        $this->load->model('mlaporan');
        $this->load->library('dompdf_gen');
    }
 
    public function index()
    {
        $data['title'] = 'Laporan PDF CodeIgniter dengan DOMPdf'; //judul title
        $data['qbarang'] = $this->mlaporan->getAllItem(); //query model semua barang
        $this->load->view('vlaporan',$data);
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