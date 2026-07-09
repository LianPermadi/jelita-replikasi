<?php
/*
 * Created By : Arif Ahmadi / 01-02-2023
 */

class peminjaman extends WRC_AdminCont
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("m_barang");
        $this->load->model("m_peminjaman");
        $this->load->library('upload');
        $base_url = base_url();
        $this->penglola_barang = FALSE;
        $this->All = FALSE;
        $list_auths = $this->session_info['app_list_auth'];
        foreach ($list_auths as $list_auth) {
            if ($list_auth->id_role === '35') {
                $this->penglola_barang = TRUE;
            }
            if ($list_auth->id_role === '18') {
                $this->All = TRUE;
            }
            if ($list_auth->id_role === '45') {
                $this->penglola_barang = TRUE;
            }
            if ($list_auth->id_role === '44') {
                $this->penglola_barang = TRUE;
            }
            if ($list_auth->id_role === '47') {
                $this->penglola_barang = TRUE;
            }
        }

        if (!$this->penglola_barang) {
            redirect('dashboard');
        }
    }