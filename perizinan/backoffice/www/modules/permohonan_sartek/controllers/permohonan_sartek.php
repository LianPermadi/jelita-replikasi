<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of ketetapan class
 * @author  PBS
 * @since   4 Maret 2014
 */

class Permohonan_Sartek extends WRC_AdminCont {

    public function __construct() {
        parent::__construct();
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
		$username = new user();
        $username->where('username', $this->session->userdata('username'))->get();
        //$query = "SELECT distinct A.id, A.kd_izin, A.n_perizinan, A.sartek_alenia1, A.sartek_alenia2, A.sartek_alenia3, A.sartek_alenia4 
        //         FROM trperizinan as A
        //         INNER JOIN trperizinan_user AS B ON  B.trperizinan_id = A.id
        //         WHERE B.user_id = '".$username->id."'
        //         order by A.id DESC";
		$query = "SELECT distinct A.id, A.kd_izin, A.n_perizinan, A.sartek_alenia1, A.sartek_alenia2, A.sartek_alenia3, A.sartek_alenia4 
                 FROM trperizinan as A order by A.id DESC";
        $data['list'] = $query;
        $this->load->vars($data);
        $js =  "
                $(document).ready(function() {
                        oTable = $('#permohonan_sartek').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });

                });";

        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "Setting Ketentuan Surat Permohonan Pertimbangan/Saran Teknis";
        $this->template->build('list', $this->session_info);
    }

	public function edit($id_ket = NULL, $id_izin = NULL) {
        $u_daftar = $this->trperizinan->get_by_id($id_izin);
        $data['id_izin'] = $id_izin;
		$data['id_ket'] = $id_ket;
        $data['save_method'] = "update";
        $data['perihal']  = $u_daftar->sartek_perihal;
		$data['alenia_1'] = $u_daftar->sartek_alenia1;
		$data['alenia_2'] = $u_daftar->sartek_alenia2;
		$data['alenia_3'] = $u_daftar->sartek_alenia3;
		$data['alenia_4'] = $u_daftar->sartek_alenia4;

        $js_date = "
            $(function() {
                $(\"#tabs\").tabs();
                $('#form').validate();
            });
            ";
        $this->template->set_metadata_javascript($js_date);

        $this->load->vars($data);
		if($id_ket == 1)
		    $this->session_info['tab_name'] = "Setting Tamplate Izin";
		else
		    $this->session_info['tab_name'] = "Setting Relasi Database";
        $this->session_info['page_name'] = "Setting Ketentuan Surat Permohonan Pertimbangan/Saran Teknis";
        $this->template->build('edit', $this->session_info);
    }

     public function update() {
        $surat = $this->trperizinan->get_by_id($this->input->post('id_izin'));
		$surat->sartek_perihal = $this->input->post('perihal');
		$surat->sartek_alenia1 = $this->input->post('alenia_1');
        $surat->sartek_alenia2 = $this->input->post('alenia_2');
        $surat->sartek_alenia3 = $this->input->post('alenia_3');
        $surat->sartek_alenia4 = $this->input->post('alenia_4');
        $update = $surat->save();
		if($update) {
            redirect('permohonan_sartek/');
        }
    }

    public function detail_OLD($id_izin = NULL) {
        $data['list'] = $this->trperizinan->where('id', $id_izin)->get();
        $data['id'] = $this->trperizinan->id;
        $this->load->vars($data);
        $js =  "
                function confirm_link(text){
                    if(confirm(text)){ return true;
                    }else{ return false; }
                }
                $(document).ready(function() {
                        oTable = $('#ketetapan').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );
                ";

        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "Setting Permohonan Saran Teknis";
        $this->template->build('detail', $this->session_info);
    }

    public function add_OLD($id_izin = NULL) {
        $data['id_izin'] = $id_izin;
        $data['n_ketetapan'] = "";
        $data['save_method'] = "save";
        $data['method'] = "chaining";

        $data['list'] = $this->ketetapan->get();
        $data['list_izin'] = $this->trperizinan->where('id', $id_izin)->get();

        $js_date = "
            $(function() {
             $('#form').validate();
                $(\"#tabs\").tabs();
            });
            ";
        $this->template->set_metadata_javascript($js_date);

        $this->load->vars($data);
        $this->session_info['page_name'] = "Tambah Ketentuan Surat";
        $this->template->build('edit', $this->session_info);
    }

    public function save_OLD() {
        $id_izin = $this->input->post('id_izin');
        $this->ketetapan->n_ketetapan = $this->input->post('n_ketetapan');

        if($this->ketetapan->save()) {
            $this->trperizinan->get_by_id($id_izin);
            $tgl = date("Y-m-d H:i:s");
            $u_ser = $this->session->userdata('username');
            //$p = $this->db->query("call log ('Setting Surat Keputusan','Insert ketentuan surat ".$this->trperizinan->n_perizinan."','".$tgl."','".$u_ser."')");

            $this->trperizinan->where('id', $id_izin)->get();
            $this->ketetapan->where('n_ketetapan', $this->input->post('n_ketetapan'))->get();
            $this->trperizinan->save($this->ketetapan);

            redirect('ketetapan/detail'."/".$this->input->post('id_izin'));
        }
    }

    public function savelist_OLD() {

        $id_izin = $this->input->post('id_izin');
        $dasarhukum_list = $this->input->post('dasarhukum');
        $dasarhukum_list_len = count($dasarhukum_list);

        for($i=0;$i<$dasarhukum_list_len;$i++) {
            $this->trperizinan->get_by_id($id_izin);
            $this->ketetapan->get_by_id($dasarhukum_list[$i]);
            $this->ketetapan->save($this->trperizinan);
        }

        redirect('ketetapan/detail'."/".$this->input->post('id_izin'));

    }

    public function delete_OLD($id_izin = NULL, $ketetapan = NULL) {
        $this->trperizinan->where('id', $id_izin)->get();
        $this->ketetapan->where('id', $ketetapan)->get();
        $this->ketetapan->delete($this->trperizinan);

        $tgl = date("Y-m-d H:i:s");
        $u_ser = $this->session->userdata('username');
        //$p = $this->db->query("call log ('Setting Surat Keputusan','Delete ketentuan surat ".$this->trperizinan->n_perizinan."','".$tgl."','".$u_ser."')");


        redirect('ketetapan/detail'."/".$id_izin);
    }

       
}

// This is the end of ketetapan class
