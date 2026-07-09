<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Jenis Kegiatan class
 *
 * @author Muhammad Rizky
 * Created : 08 Okt 2010
 *
 */

class Wilayah extends WRC_AdminCont {

    public function __construct() {
        parent::__construct();
        $this->propinsi = new propinsi();

            $enabled = FALSE;
            $list_auths = $this->session_info['app_list_auth'];

            foreach ($list_auths as $list_auth) {
                if($list_auth->id_role === '5') {
                    $enabled = TRUE;
                }
            }

            if(!$enabled) {
                redirect('dashboard');
            }
    }

    public function index() {
        $data['list'] = $this->propinsi->order_by('id', 'ASC')->get();
        $this->load->vars($data);

        $js =  "
                function confirm_link(text){
                    if(confirm(text)){ return true;
                    }else{ return false; }
                }
                
                $(document).ready(function() {
                        oTable = $('#kegiatan').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );
                ";

        $this->template->set_metadata_javascript($js);
        
        $this->session_info['page_name'] = "Data Provinsi";
        $this->template->build('provinsi_list', $this->session_info);
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
        $this->session_info['page_name'] = "Tambah Provinsi";
        $this->template->build('provinsi_edit', $this->session_info);
    }

    public function edit($id_edit = NULL) {
        $this->propinsi->get_by_id($id_edit);
        $js_date = "
                $(document).ready(function() {
                $('#form').validate();
                    $(\"#tabs\").tabs();
                } );
            ";
        $this->template->set_metadata_javascript($js_date);

        $data['nama'] = $this->propinsi->n_propinsi;
        $data['save_method'] = "update";
        $data['id'] = $this->propinsi->id;

        $this->load->vars($data);
        $this->session_info['page_name'] = "Edit Propinsi";
        $this->template->build('provinsi_edit', $this->session_info);
    }

    public function save() {
        $this->propinsi->n_propinsi = $this->input->post('nama');
//      $this->kegiatan->keterangan = $this->input->post('keterangan');

        if(! $this->propinsi->save()) {
            echo '<p>' . $this->propinsi->error->string . '</p>';
        } else {
           $tgl = date("Y-m-d H:i:s");
           $u_ser = $this->session->userdata('username');
           //$p = $this->db->query("call log ('Setting Wilayah','Insert Propinsi ".$this->input->post('nama')."','".$tgl."','".$u_ser."')");

            redirect('wilayah');
        }

    }

    public function update() {
        $update = $this->propinsi
                ->where('id', $this->input->post('id'))
                ->update(array('n_propinsi' => $this->input->post('nama'),
                    
                  ));
        if($update) {
           $tgl = date("Y-m-d H:i:s");
           $u_ser = $this->session->userdata('username');
           //$p = $this->db->query("call log ('Setting Wilayah','Update Propinsi ".$this->input->post('nama')."','".$tgl."','".$u_ser."')");

            redirect('wilayah');
        }
    }

    public function delete($id = NULL) {
       
        $this->propinsi->where('id',$id)->get();
        $tgl = date("Y-m-d H:i:s");
        $u_ser = $this->session->userdata('username');
        //$p = $this->db->query("call log ('Setting User','Delete pengguna ".$this->propinsi->n_propinsi."','".$tgl."','".$u_ser."')");
        $this->propinsi->delete();
                
        //added 12-04-2013
        //by mucktar
        
        $kabupaten = new trkabupaten_trpropinsi();
        $kecamatan = new trkabupaten_trkecamatan();
        $kelurahan = new trkecamatan_trkelurahan();
        
        //data kabupaten dengan current propinsi
        $data_kabupaten = $kabupaten->where('trpropinsi_id',$id)->get();
        $kabupaten->delete();
        
        //loop setiap kabupaten untuk mendapat data kecamatan
        foreach($data_kabupaten as $s_kabupaten){
            
            $data_kecamatan = $kecamatan->where('trkabupaten_id',$s_kabupaten->trkabupaten_id)->get();
            $kecamatan->delete();
            
            foreach($data_kecamatan as $s_kecamatan){
                
                $kelurahan->where('trkecamatan_id',$s_kecamatan->trkecamatan_id)->get();
                $kelurahan->delete();
            }
        }
        redirect('wilayah');
        //end added
    }

}

// This is the end of holiday class
