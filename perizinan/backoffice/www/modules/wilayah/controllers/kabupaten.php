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

class Kabupaten extends WRC_AdminCont {

    public function __construct() {
        parent::__construct();
        $this->kabupaten = new trkabupaten();
        $this->propinsi = new trpropinsi();
       
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

        $data['list_kabupaten']  = $this->sql();
//      $data['list_kabupaten'] = $this->kabupaten->order_by('id', 'ASC')->get();
        

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
        
        $this->session_info['page_name'] = "Data Kabupaten";
        $this->template->build('kabupaten_list', $this->session_info);
    }

    public function create() {

        $data['list_propinsi'] = $this->propinsi->order_by('n_propinsi', 'ASC')->get();
        $data['nama']  = "";
		$data['ibukota']  = "";
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
        $this->session_info['page_name'] = "Tambah Kabupaten";
        $this->template->build('kabupaten_edit', $this->session_info);
    }

    public function edit($id_edit = NULL) {

        $kabupaten = $this->kabupaten->get_by_id($id_edit);
        $data['list_propinsi'] = $this->propinsi->order_by('n_propinsi', 'ASC')->get();
        $js_date = "
                $(document).ready(function() {
                $('#form').validate();
                    $(\"#tabs\").tabs();
                } );
            ";
        $this->template->set_metadata_javascript($js_date);
        $propinsi = new trpropinsi();
        $propinsi->where_related('trkabupaten','id',$id_edit)->get();
        $data['nama'] = $kabupaten->n_kabupaten;
		$data['ibukota'] = $kabupaten->ibukota;
        $data['propinsi'] = $kabupaten->trpropinsi->id;
        $data['save_method'] = "update";
        $data['id'] = $kabupaten->id;
        $this->load->vars($data);
        $this->session_info['page_name'] = "Edit Kabupaten";
        $this->template->build('kabupaten_edit', $this->session_info);
    }

    public function save() {
//        $this->propinsi->id = $this->input->post('nama');
//      $this->kegiatan->keterangan = $this->input->post('keterangan');
//        if(! $this->propinsi->save()) {
//            echo '<p>' . $this->propinsi->error->string . '</p>';
//        } else {
//            redirect('wilayah');
//        }
        $propinsi = $this->input->post('propinsi_pemohon');
        $kabupaten = $this->input->post('nama_kabupaten');
		$f_ibukota = $this->input->post('nama_ibukota');
        $sql2 = "insert into trkabupaten(n_kabupaten,ibukota)
            values ('".$kabupaten."','".$f_ibukota."');";
        $query2 = $this->db->query($sql2);

        $coba = $this->kabupaten->where('n_kabupaten',$kabupaten)->get();
        $id = $coba->id;

        $sql = "insert into trkabupaten_trpropinsi(trkabupaten_id,trpropinsi_id)
                values ('".$id."','".$propinsi."');";
        $query = $this->db->query($sql);

        $tgl = date("Y-m-d H:i:s");
        $u_ser = $this->session->userdata('username');
        //$p = $this->db->query("call log ('Setting Wilayah','Insert kabupaten ".$kabupaten."','".$tgl."','".$u_ser."')");

        redirect('wilayah/kabupaten');
    }

    public function update() {
//        $update = $this->propinsi
//                ->where('id', $this->input->post('id'))
//                ->update(array('n_propinsi' => $this->input->post('nama'),
//
//                  ));
//        if($update) {
//            redirect('wilayah');
//        }
         $propinsi = $this->input->post('propinsi_pemohon');
        $kabupaten = $this->input->post('nama_kabupaten');
		$f_ibukota = $this->input->post('nama_ibukota');
        $id = $this->input->post('id');
        $sql ="update trkabupaten set n_kabupaten='".$kabupaten."', ibukota='".$f_ibukota."' where id='".$id."'";
        $query = $this->db->query($sql);

       
        $sql2="update trkabupaten_trpropinsi set trpropinsi_id = '".$propinsi."'
              where trkabupaten_id = '".$id."'";
        $query = $this->db->query($sql2);

        $tgl = date("Y-m-d H:i:s");
        $u_ser = $this->session->userdata('username');
        //$p = $this->db->query("call log ('Setting Wilayah','Update kabupaten ".$kabupaten."','".$tgl."','".$u_ser."')");


         redirect('wilayah/kabupaten');
    }

    public function delete($id = NULL) {
        $this->kabupaten->where('id',$id)->get();
        $tgl = date("Y-m-d H:i:s");
        $u_ser = $this->session->userdata('username');
        //$p = $this->db->query("call log ('Setting Wilayah','Delete kabupaten ".$this->kabupaten->n_kabupaten."','".$tgl."','".$u_ser."')");

        $sql = "delete from trkabupaten where id='".$id."'";
        $query = $this->db->query($sql);

        $sql2 = "delete from trkabupaten_trpropinsi where trkabupaten_id='".$id."'";
        $query2 = $this->db->query($sql2);

        if($query2)
        {
        
        redirect('wilayah/kabupaten');
        }

	

    }

    public function sql()
    {
        $query = "select c.id, a.n_kabupaten, b.n_propinsi, a.ibukota from trkabupaten as a
                  inner join trkabupaten_trpropinsi as c on c.trkabupaten_id = a.id
                  inner join trpropinsi as b on c.trpropinsi_id = b.id group by c.id ";
        $hasil = $this->db->query($query);
       return $hasil->result();


    }

}

// This is the end of holiday class
