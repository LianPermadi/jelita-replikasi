<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of welcome
 *
 * @author Obi
 */
class Main extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->tminfopublic = new tminfopublic();
        $this->tmdownload = new tmdownload();
        $this->tmgaleri = new Tmgaleri();
        $this->tm_client_jajak = new Tm_client_jajak();
        $this->tm_konter = new Tm_konter();
    }

    function index() {

        $this->pengunjung();
        $data['data_download'] = $this->tmdownload->where("C_STATUS_LINK = 1 order by D_DOWNLOAD desc  limit 8")->get();
        $data['data_galeri'] = $this->tmgaleri->where("C_STATUS_LINK = 1 order by D_GALLERY desc limit 9")->get();
        $data['data_berita'] = $this->tminfopublic->where("C_STATUS_BERITA = 1 order by D_BERITA desc limit 8")->get();


        $data['isi'] = 'isi_data';
        $this->load->view('template', $data);
    }

    function view_jajak() {
        $jumlahdata = 0;
        $pilihan = $this->input->post('pilihan');
        $pertanyaan_jajak = $this->input->post('pertayaan');

        $ip = $this->getIP();

        if ($pilihan != "") {
            $query = "SELECT *
                            FROM tmpiljajak
                            LEFT JOIN tm_client_jajak
                            ON  tm_client_jajak.C_JAJAK = tmpiljajak.C_PILJAJAK
                            WHERE ip_client = '" . $ip . "' and  tmpiljajak.C_JAJAK = '" . $pertanyaan_jajak . "' ";
            $jumlahdata = $this->db->query($query)->num_rows();


            $data_jajak = array(
                'C_JAJAK' => $pilihan,
                'ip_client' => $ip
            );

            if ($jumlahdata == 0 || $jumlahdata == NULL)
                $this->tm_client_jajak->insert($data_jajak);
        }

        $data['isi'] = 'isi_view_jajak';
        $this->load->view('template', $data);
    }

    function pengunjung() {
        $ip = $this->getIP();
        $get_jumlah = $this->tm_konter->where("ip_adrees = '$ip' ")->count();


        if ($get_jumlah < 1) {

            $data_konter = array(
                'ip_adrees' => $ip,
                'date_konter' => date('Y-m-d H:i:s')
            );

            echo $this->tm_konter->insert($data_konter);
        }
    }

    function getIP() {
        $ip;
        if (getenv("HTTP_CLIENT_IP"))
            $ip = getenv("HTTP_CLIENT_IP");
        else if (getenv("HTTP_X_FORWARDED_FOR"))
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        else if (getenv("REMOTE_ADDR"))
            $ip = getenv("REMOTE_ADDR");
        else
            $ip = "UNKNOWN";
        return $ip;
    }

    function upload() {
        $data['judul'] = 'Test Upload';
        $this->load->view('isi_upload', $data);
    }

    function save_upload($file = NULL) {
        //var_dump($_FILES);
        if (!empty($_FILES)) {
//            $tempFile = $_FILES['Filedata']['tmp_name'];
//            $targetPath = $_SERVER['DOCUMENT_ROOT'] . $_REQUEST['folder'] . '/';
//            $targetFile =  str_replace('//','/',$targetPath) . $_FILES['Filedata']['name'];
//            move_uploaded_file($tempFile,$targetFile);
//            echo str_replace($_SERVER['DOCUMENT_ROOT'],'',$targetFile);
//
//            echo "<script>alert('engga_kosong');</script>";
//
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'gif|jpg|png';

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $field_name = "Filedata";

            if (!$this->upload->do_upload($field_name)) {
                $error = $this->upload->display_errors();
            } else {
                
            }
        } else {

            //echo "<script>alert('kosong');</script>";
        }
        //            echo str_replace($_SERVER['DOCUMENT_ROOT'],'',$targetFile);
        // redirect('main');
//        
    }

    function ok() {
        
    }

}

?>
