<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of petugas class
 *
 * @author  Dichi Al Faridi
 * @since   1.0
 *
 */

class Petugas extends WRC_AdminCont {

    public function __construct() {
        parent::__construct();
        $this->petugas = new tmpegawai();
        $this->unitkerja = new trunitkerja();
        $this->user = new user();
        $enabled = FALSE;
            $list_auths = $this->session_info['app_list_auth'];

            foreach ($list_auths as $list_auth) {
                if($list_auth->id_role === '4') {
                    $enabled = TRUE;
                }
            }

            if(!$enabled) {
                redirect('dashboard');
            }
    }

    public function index() {
        $data['list'] = $this->petugas->get();
        $data['ket_exist'] = NULL;
        $this->load->vars($data);

        $js =  "
             function confirm_link(text){
                    if(confirm(text)){ return true;
                    }else{ return false; }
                }
                $(document).ready(function() {
                        oTable = $('#petugas').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );
                ";

        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "Setting Pegawai";
        $this->template->build('list', $this->session_info);
    }

    public function index_list($exist = NULL) {
        $data['list'] = $this->petugas->get();
        $data['ket_exist'] = $exist;
        $this->load->vars($data);

        $js =  "
             function confirm_link(text){
                    if(confirm(text)){ return true;
                    }else{ return false; }
                }
                $(document).ready(function() {
                        oTable = $('#petugas').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );
                ";

        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "Setting Pegawai";
        $this->template->build('list', $this->session_info);
    }

    public function create() {
        $data['nip']  = "";
        $data['n_jabatan']  = "";
        $data['unit_kerja_id'] = "";
        $data['n_pegawai']  = "";
		$data['pangkat_gol']="";
        $data['status'] = "";
		$data['e_mail'] = "";
        $data['save_method'] = "save";
        $data['id'] = "";
        $data['status_cont'] = "1";
        $data['unit_kerja'] = $this->unitkerja->get();

        $js = "
                $(document).ready(function() {
                    $('#form').validate();
                    $(\"#tabs\").tabs();
                } );
            ";
        $this->template->set_metadata_javascript($js);

        $this->load->vars($data);
        $this->session_info['page_name'] = "Tambah Pegawai";
        $this->template->build('edit', $this->session_info);
    }

    public function save() {
        $nama = $this->input->post('n_pegawai');
        $status = $this->input->post('ststtd');
        $pegawai = new tmpegawai();
        $pegawai->where('n_pegawai', $nama)->get();
        if($pegawai->id){
            redirect('petugas/index_list/'.str_replace("-", "", strtolower(url_title($nama))));
        }else{
            $this->petugas->nip = $this->input->post('nip');
            $this->petugas->n_jabatan = intval($this->input->post('n_jabatan'));
            $this->petugas->n_pegawai = $nama;
            $this->petugas->n_jabatan = $this->input->post('n_jabatan');
			$this->petugas->pangkat_gol = $this->input->post('pangkat_gol');
            $this->petugas->status = $this->input->post('ststtd');
			$this->petugas->e_mail = $this->input->post('e_mail');
            $this->unitkerja->where('id', $this->input->post('unitkerja'))->get();
            $save = $this->petugas->save($this->unitkerja);

            if(! $save) {
                echo '<p>' . $this->petugas->error->string . '</p>';
            } else {
                $tgl = date("Y-m-d H:i:s");
                $u_ser = $this->session->userdata('username');
                $g = $this->sql($u_ser);
                //$p = $this->db->query("call log ('Setting User','Insert pegawai ".$nama."','".$tgl."','".$g->description."')");

                redirect('petugas');
            }
        }
    }

    public function edit($id_petugas = NULL) {
        $this->petugas->where('id', $id_petugas);
        $this->petugas->get();
        $this->petugas->trunitkerja->get();

        $data['unit_kerja'] = $this->unitkerja->get();
        $data['nip']  = $this->petugas->nip;
        $data['id'] = $this->petugas->id;
        $data['n_jabatan']  = $this->petugas->n_jabatan;
        $data['n_pegawai']  = $this->petugas->n_pegawai;
		$data['pangkat_gol'] = $this->petugas->pangkat_gol;
        $data['status_cont'] = $this->petugas->status;
		$data['e_mail'] = $this->petugas->e_mail;
        $data['unit_kerja_id'] = $this->petugas->trunitkerja->id;
        $data['save_method'] = "update";

        $js = "$(document).ready(function(){
                    $(\"#tabs\").tabs();
                     $('#form').validate();
              });";

        $this->template->set_metadata_javascript($js);
        $this->load->vars($data);
        $this->session_info['page_name'] = "Edit Pegawai";
        $this->template->build('edit', $this->session_info);
    }

    public function update() {
		$id_petugas = $this->input->post('id');
        $update = $this->petugas
                ->where('id', $id_petugas)
                ->update(array('nip' => $this->input->post('nip'),
                    'n_jabatan' => $this->input->post('n_jabatan'),
                    'status' => $this->input->post('ststtd'),
			        'e_mail' => $this->input->post('e_mail'),
			        'pangkat_gol' => $this->input->post('pangkat_gol'),
                    'n_pegawai' => $this->input->post('n_pegawai')));

        if($update) {
            $rel_unit_kerja = new tmpegawai_trunitkerja();           
            $pegawai_unitkerja = New tmpegawai_trunitkerja();
			$pegawai_unitkerja = $pegawai_unitkerja->where('tmpegawai_id', $id_petugas)->get();
			if($pegawai_unitkerja->trunitkerja_id == '') {
				$rel_unit_kerja->tmpegawai_id = $id_petugas;
				$rel_unit_kerja->trunitkerja_id = $this->input->post('unitkerja');
                $rel_unit_kerja->save();
		    } else {
			    $rel_unit_kerja
                    ->where('tmpegawai_id', $id_petugas)
                    ->update(array('trunitkerja_id' => $this->input->post('unitkerja')
                ));
			}
        }

        $tgl = date("Y-m-d H:i:s");
        $u_ser = $this->session->userdata('username');
        //$p = $this->db->query("call log ('Setting User','Update pegawai ".$this->input->post('n_pegawai')."','".$tgl."','".$g->description."')");

        redirect('petugas');
    }

    public function delete($id = NULL) {
        $this->petugas->where('id', $id)->get();
        $tgl = date("Y-m-d H:i:s");
        $u_ser = $this->session->userdata('username');
        //$p = $this->db->query("call log ('Setting User','Delete pegawai ".$this->petugas->n_pegawai."','".$tgl."','".$g->description."')");

        if($this->petugas->delete()) {
            redirect('petugas');
        }
    }

    public function insertAsUser($id = NULL) {
        $this->petugas->where('id', $id)->get();
        $username = url_title($this->petugas->n_pegawai, 'underscore', TRUE);
        //$password = md5($username);
		$password =  md5('123456');

        $this->user->username = $username;
        $this->user->realname = $this->petugas->n_pegawai;
		$this->user->oriname = $this->petugas->n_pegawai;
        $this->user->password = $password;

        $this->session_info['from'] = 'petugas';

        if($this->user->save()) {
            $this->user->where('username', $username)->get();
            $this->petugas->where('id', $id)->get();
            $this->petugas->save($this->user);

            //redirect('pengguna/roles/' . $this->user->id .'/yes');
            redirect('pengguna/edit/' . $this->user->id);
        }
    }

    public function sql($u_ser) {
        $query = "select a.description from user_auth as a
                  inner join user_user_auth as  x on a.id = x.user_auth_id
                  inner join user as b on b.id = x.user_id
                  where b.id = (select id from user where username='".$u_ser."')
				 ";
        $hasil = $this->db->query($query);
        return $hasil->row();
    }

}
// This is the end of petugas class