<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Realisasidpa extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->model("realisasi_model");
    }

    public function maret()
    {
        $data["realisasidpa"] = $this->realisasi_model->getAll();
        $data["sekretariat"] = $this->realisasi_model->getSekre();
        $data["datin"] = $this->realisasi_model->getDatin();
        $data["esda"] = $this->realisasi_model->getEsda();
        $data["insos"] = $this->realisasi_model->getInsos();
        $data["bangprom"] = $this->realisasi_model->getBangprom();
        $data["pengendalian"] = $this->realisasi_model->getPengendalian();
            $data["sekretariatfeb"] = $this->realisasi_model->getSekreFeb();
            $data["datinfeb"] = $this->realisasi_model->getDatinFeb();
            $data["esdafeb"] = $this->realisasi_model->getEsdaFeb();
            $data["insosfeb"] = $this->realisasi_model->getInsosFeb();
            $data["bangpromfeb"] = $this->realisasi_model->getBangpromFeb();
            $data["pengendalianfeb"] = $this->realisasi_model->getPengendalianFeb();
         $data["dpa_sekre"] = $this->realisasi_model->getSumSekre();
         $data["dpa_datin"] = $this->realisasi_model->getSumDatin();
         $data["dpa_esda"] = $this->realisasi_model->getSumEsda();
         $data["dpa_insos"] = $this->realisasi_model->getSumInsos();
         $data["dpa_bangprom"] = $this->realisasi_model->getSumBangprom();
         $data["dpa_pengendalian"] = $this->realisasi_model->getSumPengendalian();
         $data["dpa_seluruh"] = $this->realisasi_model->getSumAll();
             $data["dpa_sekrefeb"] = $this->realisasi_model->getSumSekreFeb();
             $data["dpa_datinfeb"] = $this->realisasi_model->getSumDatinFeb();
             $data["dpa_esdafeb"] = $this->realisasi_model->getSumEsdaFeb();
             // $data["dpa_insosfeb"] = $this->realisasi_model->getSumInsos();
             $data["dpa_bangpromfeb"] = $this->realisasi_model->getSumBangpromFeb();
             $data["dpa_pengendalianfeb"] = $this->realisasi_model->getSumPengendalianFeb();
             $data["dpa_seluruhfeb"] = $this->realisasi_model->getSumAllFeb();
             $data["jumlah_gaji"] = 35301052750;
             $data["realisasi_gaji"] = 4977525652;
                $data["sekretariatmar"] = $this->realisasi_model->getSekreMar();
                $data["datinmar"] = $this->realisasi_model->getDatinMar();
                $data["esdamar"] = $this->realisasi_model->getEsdaMar();
                $data["insosmar"] = $this->realisasi_model->getInsosMar();
                $data["bangprommar"] = $this->realisasi_model->getBangpromMar();
                $data["pengendalianmar"] = $this->realisasi_model->getPengendalianMar();
        $data["dpa_sekremar"] = $this->realisasi_model->getSumSekreMar();
        $data["dpa_datinmar"] = $this->realisasi_model->getSumDatinMar();
        $data["dpa_esdamar"] = $this->realisasi_model->getSumEsdaMar();
        // $data["dpa_insosmar"] = $this->realisasi_model->getSumInsos();
        $data["dpa_bangprommar"] = $this->realisasi_model->getSumBangpromMar();
        $data["dpa_pengendalianmar"] = $this->realisasi_model->getSumPengendalianMar();
        $data["dpa_seluruhmar"] = $this->realisasi_model->getSumAllMar();
        $data["tanggal"] = $this->realisasi_model->getTgl();
        $data['bulan'] = ['JANUARI', 'FEBRUARI', 'MARET', 'APRIL', 'MEI', 'JUNI', 'JULI', 'AGUSTUS', 'SEPTEMBER', 'OKTOBER', 'NOVEMBER', 'DESEMBER'];
         // $data["sumif"] = $this->realisasi_model->getSum();
        $this->load->view("realisasi_dpa/index", $data);
    }

    public function get_subBulan(){
        $bulan=$this->input->post('bulan');
        $data=$this->realisasi_model->get_subBulan($bulan);
        echo json_encode($data);
    }

    public function januari()
    {   
        $data["jumlah_gaji"] = 35301052750;
        $data["realisasi_gaji"] = 0;
        $data["realisasidpa"] = $this->realisasi_model->getAll();
        $data["sekretariat"] = $this->realisasi_model->getSekreJan();
        $data["datin"] = $this->realisasi_model->getDatinJan();
        $data["esda"] = $this->realisasi_model->getEsdaJan();
        $data["insos"] = $this->realisasi_model->getInsosJan();
        $data["bangprom"] = $this->realisasi_model->getBangpromJan();
        $data["pengendalian"] = $this->realisasi_model->getPengendalianJan();
         $data["dpa_sekre"] = $this->realisasi_model->getSumSekreJan();
         $data["dpa_datin"] = $this->realisasi_model->getSumDatinJan();
         $data["dpa_esda"] = $this->realisasi_model->getSumEsdaJan();
         $data["dpa_insos"] = $this->realisasi_model->getSumInsosJan();
         $data["dpa_bangprom"] = $this->realisasi_model->getSumBangpromJan();
         $data["dpa_pengendalian"] = $this->realisasi_model->getSumPengendalianJan();
         $data["dpa_seluruh"] = $this->realisasi_model->getSumAllJan();
         $data["tanggal"] = $this->realisasi_model->getTgl();

        $this->load->view("realisasi_dpa/vjanuari", $data);
    }

    public function februari()
    {   
        $data["jumlah_gaji"] = 35301052750;
        $data["realisasi_gaji"] = 3307458931;
        $data["realisasidpa"] = $this->realisasi_model->getAll();
        $data["sekretariatfeb"] = $this->realisasi_model->getSekreFeb();
        $data["datinfeb"] = $this->realisasi_model->getDatinFeb();
        $data["esdafeb"] = $this->realisasi_model->getEsdaFeb();
        $data["insosfeb"] = $this->realisasi_model->getInsosFeb();
        $data["bangpromfeb"] = $this->realisasi_model->getBangpromFeb();
        $data["pengendalianfeb"] = $this->realisasi_model->getPengendalianFeb();
         $data["dpa_sekrefeb"] = $this->realisasi_model->getSumSekreFeb();
             $data["dpa_datinfeb"] = $this->realisasi_model->getSumDatinFeb();
             $data["dpa_esdafeb"] = $this->realisasi_model->getSumEsdaFeb();
             // $data["dpa_insosfeb"] = $this->realisasi_model->getSumInsos();
             $data["dpa_bangpromfeb"] = $this->realisasi_model->getSumBangpromFeb();
             $data["dpa_pengendalianfeb"] = $this->realisasi_model->getSumPengendalianFeb();
             $data["dpa_seluruhfeb"] = $this->realisasi_model->getSumAllFeb();
         $data["tanggal"] = $this->realisasi_model->getTgl();

        $this->load->view("realisasi_dpa/vfebruari", $data);
    }

    public function april()
    {   
        $data["jumlah_gaji"] = 35301052750;
        $data["realisasi_gaji"] = 6954222971;
        $data["realisasidpa"] = $this->realisasi_model->getAll();
        $data["sekretariatapr"] = $this->realisasi_model->getSekreApr();
        $data["datinapr"] = $this->realisasi_model->getDatinApr();
        $data["esdaapr"] = $this->realisasi_model->getEsdaApr();
        $data["insosapr"] = $this->realisasi_model->getInsosApr();
        $data["bangpromapr"] = $this->realisasi_model->getBangpromApr();
        $data["pengendalianapr"] = $this->realisasi_model->getPengendalianApr();
         $data["dpa_sekreapr"] = $this->realisasi_model->getSumSekreApr();
             $data["dpa_datinapr"] = $this->realisasi_model->getSumDatinApr();
             $data["dpa_esdaapr"] = $this->realisasi_model->getSumEsdaApr();
             // $data["dpa_insosfeb"] = $this->realisasi_model->getSumInsos();
             $data["dpa_bangpromapr"] = $this->realisasi_model->getSumBangpromApr();
             $data["dpa_pengendalianapr"] = $this->realisasi_model->getSumPengendalianApr();
             $data["dpa_seluruhapr"] = $this->realisasi_model->getSumAllApr();
         $data["tanggal"] = $this->realisasi_model->getTgl();

        $this->load->view("realisasi_dpa/vapril", $data);
    }

    public function mei()
    {   
        $data["jumlah_gaji"] = 35301052750;
        $data["realisasi_gaji"] = 9153905576;
        $data["realisasidpa"] = $this->realisasi_model->getAll();
        $data["sekretariatmei"] = $this->realisasi_model->getSekreMei();
        $data["datinmei"] = $this->realisasi_model->getDatinMei();
        $data["esdamei"] = $this->realisasi_model->getEsdaMei();
        $data["insosmei"] = $this->realisasi_model->getInsosMei();
        $data["bangprommei"] = $this->realisasi_model->getBangpromMei();
        $data["pengendalianmei"] = $this->realisasi_model->getPengendalianMei();
         $data["dpa_sekremei"] = $this->realisasi_model->getSumSekreMei();
             $data["dpa_datinmei"] = $this->realisasi_model->getSumDatinMei();
             $data["dpa_esdamei"] = $this->realisasi_model->getSumEsdaMei();
             // $data["dpa_insosfeb"] = $this->realisasi_model->getSumInsos();
             $data["dpa_bangprommei"] = $this->realisasi_model->getSumBangpromMei();
             $data["dpa_pengendalianmei"] = $this->realisasi_model->getSumPengendalianMei();
             $data["dpa_seluruhmei"] = $this->realisasi_model->getSumAllMei();
         $data["tanggal"] = $this->realisasi_model->getTgl();

        $this->load->view("realisasi_dpa/vmei", $data);
    }

    public function juni()
    {   
        $data["jumlah_gaji"] = 35301052750;
        $data["realisasi_gaji"] = 12673375555;
        $data["realisasidpa"] = $this->realisasi_model->getAll();
        $data["sekretariatjuni"] = $this->realisasi_model->getSekreJuni();
        $data["datinjuni"] = $this->realisasi_model->getDatinJuni();
        $data["esdajuni"] = $this->realisasi_model->getEsdaJuni();
        $data["insosjuni"] = $this->realisasi_model->getInsosJuni();
        $data["bangpromjuni"] = $this->realisasi_model->getBangpromJuni();
        $data["pengendalianjuni"] = $this->realisasi_model->getPengendalianJuni();
         $data["dpa_sekrejuni"] = $this->realisasi_model->getSumSekreJuni();
             $data["dpa_datinjuni"] = $this->realisasi_model->getSumDatinJuni();
             $data["dpa_esdajuni"] = $this->realisasi_model->getSumEsdaJuni();
             // $data["dpa_insosfeb"] = $this->realisasi_model->getSumInsos();
             $data["dpa_bangpromjuni"] = $this->realisasi_model->getSumBangpromJuni();
             $data["dpa_pengendalianjuni"] = $this->realisasi_model->getSumPengendalianJuni();
             $data["dpa_seluruhjuni"] = $this->realisasi_model->getSumAllJuni();
         $data["tanggal"] = $this->realisasi_model->getTgl();

        $this->load->view("realisasi_dpa/vjuni", $data);
    }

    public function juli()
    {   
        $data["jumlah_gaji"] = 35301052750;
        $data["realisasi_gaji"] = 14862434812;
        $data["realisasidpa"] = $this->realisasi_model->getAll();
        $data["sekretariatjuli"] = $this->realisasi_model->getSekreJuli();
        $data["datinjuli"] = $this->realisasi_model->getDatinJuli();
        $data["esdajuli"] = $this->realisasi_model->getEsdaJuli();
        $data["insosjuli"] = $this->realisasi_model->getInsosJuli();
        $data["bangpromjuli"] = $this->realisasi_model->getBangpromJuli();
        $data["pengendalianjuli"] = $this->realisasi_model->getPengendalianJuli();
         $data["dpa_sekrejuli"] = $this->realisasi_model->getSumSekreJuli();
             $data["dpa_datinjuli"] = $this->realisasi_model->getSumDatinJuli();
             $data["dpa_esdajuli"] = $this->realisasi_model->getSumEsdaJuli();
             // $data["dpa_insosfeb"] = $this->realisasi_model->getSumInsos();
             $data["dpa_bangpromjuli"] = $this->realisasi_model->getSumBangpromJuli();
             $data["dpa_pengendalianjuli"] = $this->realisasi_model->getSumPengendalianJuli();
             $data["dpa_seluruhjuli"] = $this->realisasi_model->getSumAllJuli();
         $data["tanggal"] = $this->realisasi_model->getTgl();

        $this->load->view("realisasi_dpa/vjuli", $data);
    }

    public function agustus()
    {   
        $data["jumlah_gaji"] = 35301052750;
        $data["realisasi_gaji"] = 16715634658;
        $data["realisasidpa"] = $this->realisasi_model->getAll();
        $data["sekretariatagustus"] = $this->realisasi_model->getSekreAgustus();
        $data["datinagustus"] = $this->realisasi_model->getDatinAgustus();
        $data["esdaagustus"] = $this->realisasi_model->getEsdaAgustus();
        $data["insosagustus"] = $this->realisasi_model->getInsosAgustus();
        $data["bangpromagustus"] = $this->realisasi_model->getBangpromAgustus();
        $data["pengendalianagustus"] = $this->realisasi_model->getPengendalianAgustus();
         $data["dpa_sekreagustus"] = $this->realisasi_model->getSumSekreAgustus();
             $data["dpa_datinagustus"] = $this->realisasi_model->getSumDatinAgustus();
             $data["dpa_esdaagustus"] = $this->realisasi_model->getSumEsdaAgustus();
             // $data["dpa_insosfeb"] = $this->realisasi_model->getSumInsos();
             $data["dpa_bangpromagustus"] = $this->realisasi_model->getSumBangpromAgustus();
             $data["dpa_pengendalianagustus"] = $this->realisasi_model->getSumPengendalianAgustus();
             $data["dpa_seluruhagustus"] = $this->realisasi_model->getSumAllAgustus();
         $data["tanggal"] = $this->realisasi_model->getTgl();

        $this->load->view("realisasi_dpa/vagustus", $data);
    }

    public function september()
    {   
        $data["jumlah_gaji"] = 25553527698;
        $data["realisasi_gaji"] = 18735588946;
        $data["realisasidpa"] = $this->realisasi_model->getAll();
        $data["sekretariatSeptember"] = $this->realisasi_model->getSekreSeptember();
        $data["datinSeptember"] = $this->realisasi_model->getDatinSeptember();
        $data["esdaSeptember"] = $this->realisasi_model->getEsdaSeptember();
        $data["insosSeptember"] = $this->realisasi_model->getInsosSeptember();
        $data["bangpromSeptember"] = $this->realisasi_model->getBangpromSeptember();
        $data["pengendalianSeptember"] = $this->realisasi_model->getPengendalianSeptember();
         $data["dpa_sekreSeptember"] = $this->realisasi_model->getSumSekreSeptember();
             $data["dpa_datinSeptember"] = $this->realisasi_model->getSumDatinSeptember();
             $data["dpa_esdaSeptember"] = $this->realisasi_model->getSumEsdaSeptember();
             // $data["dpa_insosfeb"] = $this->realisasi_model->getSumInsos();
             $data["dpa_bangpromSeptember"] = $this->realisasi_model->getSumBangpromSeptember();
             $data["dpa_pengendalianSeptember"] = $this->realisasi_model->getSumPengendalianSeptember();
             $data["dpa_seluruhSeptember"] = $this->realisasi_model->getSumAllSeptember();
         $data["tanggal"] = $this->realisasi_model->getTgl();

        $this->load->view("realisasi_dpa/vsept", $data);
    }
    
    public function index()
    {   
        $data["jumlah_gaji"] = 25553527698;
        $data["realisasi_gaji"] = 19524594912;
        $data["realisasidpa"] = $this->realisasi_model->getAll();
        $data["sekretariatOktober"] = $this->realisasi_model->getSekreOktober();
        $data["datinOktober"] = $this->realisasi_model->getDatinOktober();
        $data["esdaOktober"] = $this->realisasi_model->getEsdaOktober();
        $data["insosOktober"] = $this->realisasi_model->getInsosOktober();
        $data["bangpromOktober"] = $this->realisasi_model->getBangpromOktober();
        $data["pengendalianOktober"] = $this->realisasi_model->getPengendalianOktober();
         $data["dpa_sekreOktober"] = $this->realisasi_model->getSumSekreOktober();
             $data["dpa_datinOktober"] = $this->realisasi_model->getSumDatinOktober();
             $data["dpa_esdaOktober"] = $this->realisasi_model->getSumEsdaOktober();
             // $data["dpa_insosfeb"] = $this->realisasi_model->getSumInsos();
             $data["dpa_bangpromOktober"] = $this->realisasi_model->getSumBangpromOktober();
             $data["dpa_pengendalianOktober"] = $this->realisasi_model->getSumPengendalianOktober();
             $data["dpa_seluruhOktober"] = $this->realisasi_model->getSumAllOktober();
         $data["tanggal"] = $this->realisasi_model->getTgl();

        $this->load->view("realisasi_dpa/vokt", $data);
    }

    // public function januari()
    // {   
    //     $data["jumlah_gaji"] = 35301052750;
    //     $data["realisasi_gaji"] = 4977525652;
    //     $data["realisasidpa"] = $this->realisasi_model->getAll();
    //     $data["sekretariat"] = $this->realisasi_model->getSekreJan();
    //     $data["datin"] = $this->realisasi_model->getDatinJan();
    //     $data["esda"] = $this->realisasi_model->getEsdaJan();
    //     $data["insos"] = $this->realisasi_model->getInsosJan();
    //     $data["bangprom"] = $this->realisasi_model->getBangpromJan();
    //     $data["pengendalian"] = $this->realisasi_model->getPengendalianJan();
    //      $data["dpa_sekre"] = $this->realisasi_model->getSumSekreJan();
    //      $data["dpa_datin"] = $this->realisasi_model->getSumDatinJan();
    //      $data["dpa_esda"] = $this->realisasi_model->getSumEsdaJan();
    //      $data["dpa_insos"] = $this->realisasi_model->getSumInsosJan();
    //      $data["dpa_bangprom"] = $this->realisasi_model->getSumBangpromJan();
    //      $data["dpa_pengendalian"] = $this->realisasi_model->getSumPengendalianJan();
    //      $data["dpa_seluruh"] = $this->realisasi_model->getSumAll();
    //      $data["tanggal"] = $this->realisasi_model->getTgl();

    //     $this->load->view("realisasi_dpa/vjanuari", $data);
    // }
    
    public function add()
    {
        $product = $this->product_model;
        $validation = $this->form_validation;
        $validation->set_rules($product->rules());

        if ($validation->run()) {
            $product->save();
            $this->session->set_flashdata('success', 'Berhasil disimpan');
        }

        $this->load->view("admin/product/new_form");
    }

    public function edit($id = null)
    {
        if (!isset($id)) redirect('products');
       
        $product = $this->product_model;
        $validation = $this->form_validation;
        $validation->set_rules($product->rules());

        if ($validation->run()) {
            $product->update();
            $this->session->set_flashdata('success', 'Berhasil disimpan');
        }

        $data["product"] = $product->getById($id);
        if (!$data["product"]) show_404();
        
        $this->load->view("admin/product/edit_form", $data);
    }

    public function delete($id=null)
    {
        if (!isset($id)) show_404();
        
        if ($this->product_model->delete($id)) {
            redirect(site_url('products'));
        }
    }
     public function duplikat($id=null)
    {
        if (!isset($id)) show_404();
        
        if ($this->product_model->duplikat($id)) {
            redirect(site_url('products'));
        }
    }
}
