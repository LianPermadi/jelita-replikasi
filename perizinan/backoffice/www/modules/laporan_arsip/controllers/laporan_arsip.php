<?php

class Laporan_arsip extends WRC_AdminCont {
    
    public function __construct() {
        parent::__construct();
        $this->sektor = new trsektor();
		$this->load->helper(array("html","form","url","text"));
		/* EOF() Untuk Upload */

        $enabled = TRUE;
        $this->admin = FALSE;
        $list_auths = $this->session_info['app_list_auth'];
        
        foreach ($list_auths as $list_auth) {
            if ($list_auth->id_role === '18') {
                $this->admin = TRUE;
            }
        }
        
        if (!$enabled) {
            redirect('dashboard');
        }
    }

    public function index() {

       $bidang = $this->input->post('bidang');
       $tahun = $this->input->post('tgla');
       $jenisizin = $this->input->post('jenisizin');
       if($bidang == ""){$bidang = 'BINA MARGA';} 
       if($tahun == ''){$tahun=date('Y');};
       $this->load->model('m_laporanarsip');
       $data['jenisizin'] = $jenisizin;
       $data['tgla'] = $tahun;
       $data['bidang'] = $bidang;
       $data['list_bidang'] =$this->m_laporanarsip->databidang();
       $data['list_arsip'] =$this->m_laporanarsip->dataarsip($bidang,$tahun,$jenisizin);
       $this->load->vars($data);


        $js = "
                function confirm_link(text){
                    if(confirm(text)){ return true;
                    }else{ return false; }
                }

                $(document).ready(function() {
                        oTable = $('#penyerahan').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );
                $(function() {
                    $(\".monbulan\").datepicker({
                        changeMonth: true,
                        changeYear: true,
                        dateFormat: 'yy',
                        closeText: 'X'
                    });
                });
                ";

        $this->template->set_metadata_javascript($js);        
        $this->session_info['page_name'] = "Daftar Arsip Simpan";
        $this->template->build('daftar_arsip', $this->session_info);
    }
 public function cetak() {

       $bidang = $this->input->post('bidang');
       $tahun = $this->input->post('tgla');
       $jenisizin = $this->input->post('jenisizin');
       if($bidang == ""){$bidang = 'BINA MARGA';} 
       if($tahun == ''){$tahun=date('Y');};
       $this->load->model('m_laporanarsip');
       $data['jenisizin'] = $jenisizin;
       $data['tgla'] = $tahun;
       $data['bidang'] = $bidang;
       $data['list_bidang'] =$this->m_laporanarsip->databidang();
       $data['list_arsip'] =$this->m_laporanarsip->dataarsip($bidang,$tahun,$jenisizin);
       $this->load->vars($data);


        /*$js = "
                function confirm_link(text){
                    if(confirm(text)){ return true;
                    }else{ return false; }
                }

                $(document).ready(function() {
                        oTable = $('#penyerahan').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );
                $(function() {
                    $(\".monbulan\").datepicker({
                        changeMonth: true,
                        changeYear: true,
                        dateFormat: 'yy',
                        closeText: 'X'
                    });
                });
                ";

        $this->template->set_metadata_javascript($js); */       
       // $this->session_info['page_name'] = "Daftar Arsip Simpan";
        $this->load->view('cetakdaftar_arsip');
    }
}