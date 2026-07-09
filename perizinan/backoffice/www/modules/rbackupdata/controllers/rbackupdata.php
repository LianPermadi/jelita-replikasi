<?php
class Rbackupdata extends WRC_AdminCont {

    public function __construct() {
        parent::__construct();
        $this->load->library('zip');

        $enabled = FALSE;
        $list_auths = $this->session_info['app_list_auth'];
       // $this->rekapitulasi = NULL;

        foreach ($list_auths as $list_auth) {
            if($list_auth->id_role === '6') {
                $enabled = TRUE;
               // $this->rekapitulasi = new user_auth();
            }
        }

        if(!$enabled) {
            redirect('dashboard');
        }
    }

    public function index() {
        $this->session_info['page_name'] = "Daftar Backup Folder";
        $this->template->build('daftarbackup', $this->session_info);
    }
     public function esignfile(){
        $lokasi = FCPATH.'assets/esignfile/';
        $path = $lokasi; // folder yang ingin kita download
        $folder_in_zip = 'esignfile'.date("Ymd").'/';  // tujuan sementara folder zip
        $this->zip->get_files_from_folder($path, $folder_in_zip);
        $this->zip->download('esignfile'.date("Ymd").'.zip');
        }

        public function template(){
        $lokasi = FCPATH.'assets/template/';
        $path = $lokasi; // folder yang ingin kita download
        $folder_in_zip = 'template'.date("Ymd").'/';  // tujuan sementara folder zip
        $this->zip->get_files_from_folder($path, $folder_in_zip);
        $this->zip->download('template'.date("Ymd").'.zip');
        }

        /* public function template(){
        $lokasi = FCPATH.'assets/template/';
        $path = $lokasi; // folder yang ingin kita download
        $folder_in_zip = 'template'.date("Ymd").'/';  // tujuan sementara folder zip
        $this->zip->get_files_from_folder($path, $folder_in_zip);
        $this->zip->download('template'.date("Ymd").'.zip');
        }*/
}