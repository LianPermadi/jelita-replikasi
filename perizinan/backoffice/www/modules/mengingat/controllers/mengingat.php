<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of mengingat class
 *
 * @author  agusnur
 * Created : 19 Dec 2010
 *
 */

class Mengingat extends WRC_AdminCont {

    public function __construct() {
        parent::__construct();

        $this->trmengingat = new trmengingat();
        $this->trperizinan = new trperizinan();
        $this->load->helper('text');

            $enabled = FALSE;
            $list_auths = $this->session_info['app_list_auth'];

            foreach ($list_auths as $list_auth) {
                if($list_auth->id_role === '2') {
                    $enabled = TRUE;
                }
            }

            if(!$enabled) {
                redirect('dashboard');
            }
    }

    public function index() {
        $data['list'] = $this->trperizinan->where('c_keputusan', 1)->get();
        $this->load->vars($data);
        $js =  "
                $(document).ready(function() {
                        oTable = $('#dasarhukum').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });

                });";

        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "Setting Mengingat SK";
        $this->template->build('list', $this->session_info);
    }

    public function detail($id_izin = NULL) {
        $data['list'] = $this->trperizinan->where('id', $id_izin)->get();
        $data['id'] = $this->trperizinan->id;
        $this->load->vars($data);
        $js =  "
                function confirm_link(text){
                    if(confirm(text)){ return true;
                    }else{ return false; }
                }
                $(document).ready(function() {
                        oTable = $('#dasar_hukum').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );
                ";

        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "Setting Mengingat SK Untuk " . $this->trperizinan->n_perizinan;
        $this->template->build('detail', $this->session_info);
    }

    public function add($id_izin = NULL) {
        $data['id_izin'] = $id_izin;
        $data['nama'] = "";
        $data['deskripsi'] = "";
        $data['tgl_berlaku'] = "";
        $data['tgl_berakhir'] = "";
        $data['save_method'] = "save";
        $data['method'] = "chaining";

        $data['list'] = $this->trmengingat->get();
        $data['list_izin'] = $this->trperizinan->where('id', $id_izin)->get();

        $data['status_cont'] = "";
        $js_date = "
            $(function() {
                $(\"#tabs\").tabs();
                 $('#form').validate();
                $(\"#tgl_berakhir\").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: 'yy-mm-dd',
                    closeText: 'X'
                });
                
                $(\"#tgl_berlaku\").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: 'yy-mm-dd',
                    closeText: 'X'
                });

            });
            ";
        $this->template->set_metadata_javascript($js_date);

        $this->load->vars($data);
        $this->session_info['page_name'] = "Tambah Mengingat SK";
        $this->template->build('edit', $this->session_info);
    }

    public function save() {
      $id_izin = $this->input->post('id_izin');
        $this->trperizinan->get_by_id($id_izin);
        $tgl = date("Y-m-d H:i:s");
        $u_ser = $this->session->userdata('username');
        //$p = $this->db->query("call log ('Setting Surat Keputusan','Insert mengingat SK ".$this->trperizinan->n_perizinan."','".$tgl."','".$u_ser."')");
//-----------START-------ALI
        $a = explode("*", $this->trmengingat->jenis = $this->input->post('jenis'));

        $rename =  $a[1]." Nomor ".$this->input->post('nomor')." Tahun ".$this->input->post('tahun').".pdf";

        $dir = "assets/file_upload/".$id_izin;
       
        if (!file_exists($dir)) {
            mkdir($dir);
        }
       
        $target_dir = "assets/file_upload/".$id_izin."/";
        $target_file = $target_dir . $rename;
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                echo "ber";
                } else {
        $rename  = "No File";
        }
        
        $deskripsi2 = $a[1]." Nomor ".$this->input->post('nomor')." Tahun ".$this->input->post('tahun')." tentang ".$this->input->post('tentang')." ".$this->input->post('tambahan');
        $this->trmengingat->deskripsi = $deskripsi2;
        $this->trmengingat->jenis = $this->input->post('jenis');
        $this->trmengingat->nomor = $this->input->post('nomor');
        $this->trmengingat->tahun = $this->input->post('tahun');
        $this->trmengingat->tentang = $this->input->post('tentang');
        $this->trmengingat->tambahan = $this->input->post('tambahan');
        $this->trmengingat->file = $rename;
        $this->trmengingat->type = $this->input->post('status');
        $perizinan = new trperizinan();
        $perizinan->get_by_id($id_izin);
        $this->trmengingat->save($perizinan);
    
        redirect('mengingat/detail'."/".$this->input->post('id_izin'));
        //$this->trmengingat->deskripsi = $this->input->post('deskripsi');
        // $this->trmengingat->type = $this->input->post('status');
        // $perizinan = new trperizinan();
        // $perizinan->get_by_id($id_izin);
        // $this->trmengingat->save($perizinan);
        // redirect('mengingat/detail'."/".$this->input->post('id_izin'));
    }
    //---------START-------ALI
    public function download($id_izin = NULL, $id_dasar_hukum = NULL) {
        $berkas1 = "select * from trmengingat where id = '".$id_dasar_hukum."'";
        $berkas = $this->db->query($berkas1)->row_array();

        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename='".$berkas['file']."'");
        header("Content-Transfer-Encoding: binary");
    }

    public function delete($id_izin = NULL, $id_dasar_hukum = NULL) {
        $this->trperizinan->where('id', $id_izin)->get();
        $this->trmengingat->where('id', $id_dasar_hukum)->get();
        $this->trmengingat->delete($this->trperizinan);

        $tgl = date("Y-m-d H:i:s");
        $u_ser = $this->session->userdata('username');
        //$p = $this->db->query("call log ('Setting Surat Keputusan','Delete mengingat SK ".$this->trperizinan->n_perizinan."','".$tgl."','".$u_ser."')");
        redirect('mengingat/detail'."/".$id_izin);
    }

    public function edit($id_izin = NULL, $id_dasar_hukum = NULL) {
        $data['id_izin'] = $id_izin;
        $data['id_dasar_hukum'] = $id_dasar_hukum;

        $this->trperizinan->where('id', $id_izin)->get();
        $this->trmengingat->where('id', $id_dasar_hukum);
        $this->trmengingat->get($this->trperizinan);
        $data['nama'] = $this->trmengingat->nama;
        $data['jenis'] = $this->trmengingat->jenis;
        $data['nomor'] = $this->trmengingat->nomor;
        $data['tahun'] = $this->trmengingat->tahun;
        $data['tentang'] = $this->trmengingat->tentang; 
        $data['tambahan'] = $this->trmengingat->tambahan;
        $data['file'] = $this->trmengingat->file;                       
        $data['tgl_berlaku'] = $this->trmengingat->tgl_berlaku;
        $data['tgl_berakhir'] = $this->trmengingat->tgl_berakhir;
        $data['save_method'] = "update";
        $data['method'] = "editing";
        $data['nama'] = $this->trmengingat->nama;
        $data['deskripsi'] = $this->trmengingat->deskripsi;
        $data['tgl_berlaku'] = $this->trmengingat->tgl_berlaku;
        $data['tgl_berakhir'] = $this->trmengingat->tgl_berakhir;
        $data['save_method'] = "update";
        $data['method'] = "editing";

        $rel = new trmengingat();
        $rel->get_by_id($id_dasar_hukum);

        $data['status_cont'] = $rel->type;

        $data['list'] = $this->trmengingat->get();
        $data['list_izin'] = $this->trperizinan->where('id', $id_izin)->get();

        $js_date = "
            $(function() {
                $(\"#tabs\").tabs();
                 $('#form').validate();
                $(\"#tgl_berakhir\").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: 'yy-mm-dd',
                    closeText: 'X'
                });

                $(\"#tgl_berlaku\").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: 'yy-mm-dd',
                    closeText: 'X'
                });

            });
            ";
        $this->template->set_metadata_javascript($js_date);

        $this->load->vars($data);
        $this->session_info['page_name'] = "Edit Mengingat SK";
        $this->template->build('edit', $this->session_info);
    }

    public function update() {
                $id_izin = $this->input->post('id_izin');
        $id_dasar_hukum = $this->input->post('id_dasar_hukum');

        $this->trperizinan->get_by_id($id_izin);
        $tgl = date("Y-m-d H:i:s");
        $u_ser = $this->session->userdata('username');
        //$p = $this->db->query("call log ('Setting Surat Keputusan','Update mengingat SK ".$this->trperizinan->n_perizinan."','".$tgl."','".$u_ser."')");
//-----------START-------ALI
        $a = explode("*", $this->trmengingat->jenis = $this->input->post('jenis'));

        if (empty($_FILES["fileToUpload"]["tmp_name"])) {

        $this->trmengingat
                ->where('id', $id_dasar_hukum)
                ->update(array(
                    'deskripsi' => $a[1]." Nomor ".$this->input->post('nomor')." Tahun ".$this->input->post('tahun')." tentang ".$this->input->post('tentang')." ".$this->input->post('tambahan'),
                    'jenis' => $this->input->post('jenis'),
                    'nomor' => $this->input->post('nomor'),
                    'tahun' => $this->input->post('tahun'),
                    'tentang' => $this->input->post('tentang'),
                    'tambahan' => $this->input->post('tambahan'),
                    'file' => "No File",
                    'type' => $this->input->post('status')
                ));
        }else{

        // $rename = "[UPDATE] ".$a[1]." Nomor ".$this->input->post('nomor')." Tahun ".$this->input->post('tahun').".pdf";
        $rename = $a[1]." Nomor ".$this->input->post('nomor')." Tahun ".$this->input->post('tahun').".pdf";

        $target_dir = "assets/file_upload/";
        $target_file = $target_dir . $rename;
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
         $dir = "assets/file_upload/".$id_izin;
       
        if (!file_exists($dir)) {
            mkdir($dir);
        }
            
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                } else {
        $rename = "No File";
        }

        $this->trmengingat
                ->where('id', $id_dasar_hukum)
                ->update(array(
                    'deskripsi' => $a[1]." Nomor ".$this->input->post('nomor')." Tahun ".$this->input->post('tahun')." tentang ".$this->input->post('tentang')." ".$this->input->post('tambahan'),
                    'jenis' => $this->input->post('jenis'),
                    'nomor' => $this->input->post('nomor'),
                    'tahun' => $this->input->post('tahun'),
                    'tentang' => $this->input->post('tentang'),
                    'tambahan' => $this->input->post('tambahan'),
                    'file' => $rename,
                    'type' => $this->input->post('status')
                ));
        }        
//-----------FINISH-------ALI
        redirect('mengingat/detail'."/".$this->input->post('id_izin'));
        #
        #
        # END OF UPDATE CHANGES
        #
        #

        // $id_izin = $this->input->post('id_izin');
        // $id_dasar_hukum = $this->input->post('id_dasar_hukum');

        // $this->trperizinan->get_by_id($id_izin);
        // $tgl = date("Y-m-d H:i:s");
        // $u_ser = $this->session->userdata('username');
        // //$p = $this->db->query("call log ('Setting Surat Keputusan','Update mengingat SK ".$this->trperizinan->n_perizinan."','".$tgl."','".$u_ser."')");


        // $this->trmengingat
        //         ->where('id', $id_dasar_hukum)
        //         ->update(array(
        //             'deskripsi' => $this->input->post('deskripsi'),
        //             'type' => $this->input->post('status')
        //         ));

        // redirect('mengingat/detail'."/".$this->input->post('id_izin'));
    }
    
}