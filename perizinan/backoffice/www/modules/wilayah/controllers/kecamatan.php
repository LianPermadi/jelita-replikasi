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
class Kecamatan extends WRC_AdminCont {

    public function __construct() {
        parent::__construct();
        $this->kecamatan = new trkecamatan();
        $this->propinsi = new trpropinsi();
        $this->kabupaten = new trkabupaten();

        $enabled = FALSE;
        $list_auths = $this->session_info['app_list_auth'];

        foreach ($list_auths as $list_auth) {
            if ($list_auth->id_role === '5') {
                $enabled = TRUE;
            }
        }

        if (!$enabled) {
            redirect('dashboard');
        }
    }

    public function index() {
        $data['list_kecamatan'] = $this->sql();
        $this->load->vars($data);

        $js = "
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

        $this->session_info['page_name'] = "Data Kecamatan";
        $this->template->build('kecamatan_list', $this->session_info);
    }

    public function create() {

        $data['list_propinsi'] = $this->propinsi->order_by('n_propinsi', 'ASC')->get();
        $data['list_kabupaten'] = $this->kabupaten->order_by('n_kabupaten', 'ASC')->get();

        $data['nama'] = "";
        $data['keterangan'] = "";
        $data['save_method'] = "save";
        $data['id'] = "";
        
        //edited 12-14-2013
        //by mucktar
        $js = "
                $(document).ready(function() {
                    $('#form').validate();
                    $(\"#tabs\").tabs();

                } );
     
                $(document).ready(function() {
                    $('#propinsi_pemohon_id').change(function(){
                        $.post('" . base_url() . "wilayah/kecamatan/kabupaten_pemohon', {
                            propinsi_id: $('#propinsi_pemohon_id').val()
                        },function(data) {
                            $('#show_kabupaten').html(data);
                        },
                        function(response){
                            setTimeout(\"finishAjax('show_kabupaten_pemohon', '\"+escape(response)+\"')\", 400);
                        });
                            return false;
                        });      
                });

                function finishAjax(id, response){
                  $('#'+id).html(unescape(response));
                  $('#'+id).fadeIn();
                }

          
           ";

        $this->template->set_metadata_javascript($js);

        $this->load->vars($data);
        $this->session_info['page_name'] = "Tambah Kecamatan";
        $this->template->build('kecamatan_edit', $this->session_info);
    }

    public function kabupaten_pemohon() {
        $data['kabupaten_id'] = 'kabupaten_pemohon';
        $data['kecamatan_id'] = 'kecamatan_pemohon';

        $this->load->vars($data);
        $this->load->view('kabupaten_load', $data);
    }

    public function edit($id_edit = NULL) {

        $data['list_propinsi'] = $this->propinsi->order_by('n_propinsi', 'ASC')->get();
        $data['list_kabupaten'] = $this->kabupaten->order_by('n_kabupaten', 'ASC')->get();

        $kecamatan = $this->kecamatan->get_by_id($id_edit);

        $kabupaten = $kecamatan->trkabupaten->id;
        $propinsi = $kecamatan->trkabupaten->trpropinsi->get();
        $js = "
                $(document).ready(function() {
                    $('#form').validate();
                    $(\"#tabs\").tabs();
      
                } );


                $(document).ready(function() {
                        $('#propinsi_pemohon_id').change(function(){

                                $.post('" . base_url() . "pelayanan/pendaftaran/kabupaten_pemohon', {
                                propinsi_id: $('#propinsi_pemohon_id').val()
                                },function(response){
                                    setTimeout(\"finishAjax('show_kabupaten_pemohon', '\"+escape(response)+\"')\", 400);

                                });
                         return false;

                        });
                       
                       
                });

                function finishAjax(id, response){
                  $('#'+id).html(unescape(response));
                  $('#'+id).fadeIn();
                }

             
 
            ";
        $this->template->set_metadata_javascript($js);

        $data['nama'] = $kecamatan->n_kecamatan;
        $data['save_method'] = "update";
        $data['id'] = $kecamatan->id;
        $data['kabupaten'] = $kabupaten;
        $data['propinsi'] = $propinsi->id;

        $this->load->vars($data);
        $this->session_info['page_name'] = "Edit Kecamatan";
        $this->template->build('kecamatan_edit', $this->session_info);
    }

    public function save() {

//        $this->propinsi->n_propinsi = $this->input->post('nama');
//      $this->kegiatan->keterangan = $this->input->post('keterangan');
//        if(! $this->propinsi->save()) {
//            echo '<p>' . $this->propinsi->error->string . '</p>';
//        } else {
//            redirect('wilayah');
//        }


        $propinsi = $this->input->post('propinsi');
        $kabupaten = $this->input->post('kabupaten');
        $kecamatan = $this->input->post('nama');
        // editedd 12-04-2013
        //by mucktar
        if (!empty($propinsi) && !empty($kabupaten)) {
            $sql1 = "insert into trkecamatan (n_kecamatan) values ('" . $kecamatan . "')";
            $query1 = $this->db->query($sql1);

            $coba = $this->kecamatan->where('n_kecamatan', $kecamatan)->get();
            $id = $coba->id;
            $sql2 = "insert into trkabupaten_trkecamatan (trkabupaten_id,trkecamatan_id)
                values ('" . $kabupaten . "','" . $id . "')";
            $query2 = $this->db->query($sql2);

            $tgl = date("Y-m-d H:i:s");
            $u_ser = $this->session->userdata('username');
            //$p = $this->db->query("call log ('Setting Wilayah','Insert Kecamatan " . $kecamatan . "','" . $tgl . "','" . $u_ser . "')");
        }

        redirect('wilayah/kecamatan');
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
        $propinsi = $this->input->post('propinsi');
        $kabupaten = $this->input->post('kabupaten');
        $kecamatan = $this->input->post('nama');
        $id = $this->input->post('id');

        $sql = "update trkecamatan set n_kecamatan='" . $kecamatan . "' where id='" . $id . "'";
        $query = $this->db->query($sql);

        $sql2 = "update trkabupaten_trkecamatan set trkabupaten_id = '" . $kabupaten . "'
            where trkecamatan_id = '" . $id . "'";
        $query = $this->db->query($sql2);

        $tgl = date("Y-m-d H:i:s");
        $u_ser = $this->session->userdata('username');
        //$p = $this->db->query("call log ('Setting Wilayah','Update Kecamatan " . $kecamatan . "','" . $tgl . "','" . $u_ser . "')");
        redirect('wilayah/kecamatan');
    }

    public function delete($id = NULL) {
        $this->kecamatan->where('id', $id)->get();
        $tgl = date("Y-m-d H:i:s");
        $u_ser = $this->session->userdata('username');
        //$p = $this->db->query("call log ('Setting Wilayah','Delete kecamatan " . $this->kecamatan->n_kecamatan . "','" . $tgl . "','" . $u_ser . "')");

        $sql = "delete from trkecamatan where id='" . $id . "'";
        $query = $this->db->query($sql);

        $sql2 = "delete from trkabupaten_trkecamatan where trkecamatan_id='" . $id . "'";
        $query2 = $this->db->query($sql2);

        if ($query) {
            redirect('wilayah/kecamatan');
        }
    }

    public function sql() {
        $query = "select a.id,a.n_kecamatan,b.n_kabupaten, d.n_propinsi from trkecamatan as a
                  inner join trkabupaten_trkecamatan as c on c.trkecamatan_id = a.id
                  inner join trkabupaten as b on c.trkabupaten_id=b.id
                  inner join trkabupaten_trpropinsi as e on e.trkabupaten_id = b.id
                  inner join trpropinsi as d on e.trpropinsi_id=d.id";
        $hasil = $this->db->query($query);
        return $hasil->result();
    }

}

// This is the end of holiday class
