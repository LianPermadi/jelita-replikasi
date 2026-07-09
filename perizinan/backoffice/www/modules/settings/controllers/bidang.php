<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Bidang Perizinan class
 *
 * @author PBS
 * Created : 17 Feb 2014
 *
 */

class Bidang extends WRC_AdminCont {

    public function __construct() {
        parent::__construct();
        $this->sektor = new trsektor();

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
        $data['list'] = $this->sektor->order_by('urutan', 'ASC')->get();
        $this->load->vars($data);

        $js =  "
                function confirm_link(text){
                    if(confirm(text)){ return true;
                    }else{ return false; }
                }
                
                $(document).ready(function() {
                        oTable = $('#bidang').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );
                ";

        $this->template->set_metadata_javascript($js);
        
        $this->session_info['page_name'] = "Data Bidang Perizinan";
        $this->template->build('bidang_list', $this->session_info);
    }

    public function create() {
        $data['nama']  = "";
		$data['urutan']  = 0;
        $data['save_method'] = "save";
        $data['id'] = "";
		$petugas = new tmpegawai();
        $data['petugas'] = $petugas->where('status = 1 OR status = 2')->get();
		$data['tgs_id_sp'] = $this->sektor->ttd_sp;
		$data['tgs_id_tlk'] = $this->sektor->ttd_tolak;
		$data['tgs_id_nta'] = $this->sektor->ttd_nota;
		$data['no_pertek_awal'] = $this->sektor->no_pertek_awal;
		$data['no_pertek_akhir'] = $this->sektor->no_pertek_akhir;
		$data['no_sp_awal'] = $this->sektor->no_sp_awal;
		$data['no_sp_akhir'] = $this->sektor->no_sp_akhir;
        $js_date = "
                $(document).ready(function() {
                    $('#form').validate();
                    $(\"#tabs\").tabs();
                } );
            ";
        $this->template->set_metadata_javascript($js_date);

        $this->load->vars($data);
        $this->session_info['page_name'] = "Tambah Bidang Perizinan";
        $this->template->build('bidang_edit', $this->session_info);
    }

    public function edit($id_edit = NULL) {
        $this->sektor->get_by_id($id_edit);
        $js_date = "
                $(document).ready(function() {
                    $(\"#tabs\").tabs();
                    $('#form').validate();
                } );
            ";
        $this->template->set_metadata_javascript($js_date);

        $data['nama'] = $this->sektor->n_sektor;
		$data['urutan'] = $this->sektor->urutan;
        $data['save_method'] = "update";
        $data['id'] = $this->sektor->id;
		$petugas = new tmpegawai();
        $data['petugas'] = $petugas->where('status = 1 OR status = 2')->get();
		$data['tgs_id_sp'] = $this->sektor->ttd_sp;
		$data['tgs_id_tlk'] = $this->sektor->ttd_tolak;
		$data['tgs_id_nta'] = $this->sektor->ttd_nota;
		$data['no_pertek_awal'] = $this->sektor->no_pertek_awal;
		$data['no_pertek_akhir'] = $this->sektor->no_pertek_akhir;
		$data['no_sp_awal'] = $this->sektor->no_sp_awal;
		$data['no_sp_akhir'] = $this->sektor->no_sp_akhir;

        $this->load->vars($data);
        $this->session_info['page_name'] = "Edit Bidang Perizinan";
        $this->template->build('bidang_edit', $this->session_info);
    }

    public function save() {
        $this->sektor->n_sektor = $this->input->post('nama');
		$this->sektor->urutan = $this->input->post('urutan');
		$this->sektor->ttd_sp = $this->input->post('ttd_sp');
		$this->sektor->ttd_tolak = $this->input->post('ttd_tlk');
		$this->sektor->ttd_nota = $this->input->post('ttd_nta');
		$this->sektor->no_pertek_awal = $this->input->post('no_pertek_awal');
		$this->sektor->no_pertek_akhir = $this->input->post('no_pertek_akhir');
		$this->sektor->no_sp_awal = $this->input->post('no_sp_awal');
		$this->sektor->no_sp_akhir = $this->input->post('no_sp_akhir');

        if(! $this->sektor->save()) {
            echo '<p>' . $this->sektor->error->string . '</p>';
        } else {
            $u_ser = $this->session->userdata('username');
            $tgl = date("Y-m-d H:i:s");
            //$p = $this->db->query("call log ('Setting Umum','Insert Bidang Perizinan ".$this->input->post('nama')."','".$tgl."','".$u_ser."')");
            redirect('settings/bidang');
        }

    }

    public function update() {
        $update = $this->sektor
                ->where('id', $this->input->post('id'))
                ->update(array('n_sektor' => $this->input->post('nama'),
			                   'urutan' => $this->input->post('urutan'),
			                   'ttd_sp' => $this->input->post('ttd_sp'),
			                   'ttd_tolak' => $this->input->post('ttd_tlk'),
			                   'ttd_nota' => $this->input->post('ttd_nta'),
			                   'no_pertek_awal' => $this->input->post('no_pertek_awal'),
			                   'no_pertek_akhir' => $this->input->post('no_pertek_akhir'),
			                   'no_sp_awal' => $this->input->post('no_sp_awal'),
			                   'no_sp_akhir' => $this->input->post('no_sp_akhir')
			    ));
        if($update) {
            $u_ser = $this->session->userdata('username');
            $tgl = date("Y-m-d H:i:s");
            //$p = $this->db->query("call log ('Setting Umum','Update Bidang Perizinan ".$this->input->post('nama')."','".$tgl."','".$u_ser."')");

            redirect('settings/bidang');
        }
    }

    public function delete($id = NULL) {
        $this->sektor->where('id', $id)->get();
        $u_ser = $this->session->userdata('username');
        $tgl = date("Y-m-d H:i:s");
        //$p = $this->db->query("call log ('Setting Umum','Delete Bidang Perizinan ".$this->sektor->n_sektor."','".$tgl."','".$u_ser."')");

        if($this->sektor->delete()) {
            redirect('settings/bidang');
        }
    }

}

// This is the end of holiday class