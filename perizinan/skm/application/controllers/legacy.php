<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Legacy extends CI_Controller
{
    public function redirect_survei()
    {
        $this->load->helper('url');

        // DEBUG: bukti route kepanggil
        // echo 'ROUTE KEPAKE'; exit;

        // Ambil query lama (kalau nanti mau dinamis)
        $qry  = $this->input->get('qry', TRUE);
        $code = $this->input->get('CODE', TRUE);
        $url  = $this->input->get('url', TRUE);

        // Redirect ke URL baru (sesuai permintaan; param tetap dibawa)
        $dest = site_url('survei/question') . '?CODE=' . rawurlencode($code ?: 'frontoffice')
                                            . '&url='  . rawurlencode($url ?: '3');
        redirect($dest, 'location', 301);
    }
}
