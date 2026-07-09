<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Jenis Investasi class
 *
 * @author agusnur
 * Created : 08 Okt 2010
 *
 */

class Investasi extends WRC_AdminCont {

    public function __construct() {
        parent::__construct();
        $this->investasi = new trinvestasi();

            $enabled = FALSE;
            $list_auths = $this->session_info['app_list_auth'];

            foreach ($list_auths as $list_auth) {
                if($list_auth->id_role === '3') {
                    $enabled = TRUE;
                }
            }

            if(!$enabled) {
                redirect('dashboard');
            }
    }

    public function index() {
        $data['list'] = $this->investasi->order_by('id', 'ASC')->get();
        $this->load->vars($data);

        $js =  "
                function confirm_link(text){
                    if(confirm(text)){ return true;
                    }else{ return false; }
                }
                
                $(document).ready(function() {
                        oTable = $('#investasi').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );
                ";

        $this->template->set_metadata_javascript($js);
        
        $this->session_info['page_name'] = "Data Jenis Investasi";
        $this->template->build('investasi_list', $this->session_info);
    }

    public function create() {
        $data['nama']  = "";
        $data['keterangan']  = "";
        $data['save_method'] = "save";
        $data['id'] = "";
        $js_date = "
                $(document).ready(function() {
                    $('#form').validate();
                    $(\"#tabs\").tabs();
                } );
            ";
        $this->template->set_metadata_javascript($js_date);

        $this->load->vars($data);
        $this->session_info['page_name'] = "Tambah Investasi";
        $this->template->build('investasi_edit', $this->session_info);
    }

    public function edit($id_edit = NULL) {
        $this->investasi->get_by_id($id_edit);
        $js_date = "
                $(document).ready(function() {
                    $(\"#tabs\").tabs();
                    $('#form').validate();
                } );
            ";
        $this->template->set_metadata_javascript($js_date);

        $data['nama'] = $this->investasi->n_investasi;
        $data['keterangan'] = $this->investasi->keterangan;
        $data['save_method'] = "update";
        $data['id'] = $this->investasi->id;

        $this->load->vars($data);
        $this->session_info['page_name'] = "Edit Investasi";
        $this->template->build('investasi_edit', $this->session_info);
    }

    public function save() {
        $this->investasi->n_investasi = $this->input->post('nama');
        $this->investasi->keterangan = $this->input->post('keterangan');

        if(! $this->investasi->save()) {
            echo '<p>' . $this->investasi->error->string . '</p>';
        } else {
            $u_ser = $this->session->userdata('username');
            $tgl = date("Y-m-d H:i:s");
            //$p = $this->db->query("call log ('Setting Umum','Insert jenis Investasi ".$this->input->post('nama')."','".$tgl."','".$u_ser."')");

            redirect('perusahaan/investasi');
        }

    }

    public function update() {
        $update = $this->investasi
                ->where('id', $this->input->post('id'))
                ->update(array('n_investasi' => $this->input->post('nama'),
                    'keterangan' => $this->input->post('keterangan')
                  ));
        if($update) {
            $u_ser = $this->session->userdata('username');
            $tgl = date("Y-m-d H:i:s");
            //$p = $this->db->query("call log ('Setting Umum','Update jenis Investasi ".$this->input->post('nama')."','".$tgl."','".$u_ser."')");

            redirect('perusahaan/investasi');
        }
    }

    public function delete($id = NULL) {
        $this->investasi->where('id', $id)->get();
        $u_ser = $this->session->userdata('username');
        $tgl = date("Y-m-d H:i:s");
        //$p = $this->db->query("call log ('Setting Umum','Delete jenis Investasi ".$this->investasi->n_investasi."','".$tgl."','".$u_ser."')");

        if($this->investasi->delete()) {
            redirect('perusahaan/investasi');
        }
    }

}

// This is the end of holiday class
