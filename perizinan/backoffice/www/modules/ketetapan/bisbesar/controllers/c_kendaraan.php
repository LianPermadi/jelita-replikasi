<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 *  @author  R; 
 */

class C_kendaraan extends WRC_AdminCont {

    public function __construct() {
        parent::__construct();
       $this->load->model("m_kendaraan");

            $enabled = FALSE;
            $list_auths = $this->session_info['app_list_auth'];

            foreach ($list_auths as $list_auth) {
                if($list_auth->id_role === '30') {
                    $enabled = TRUE;
                }
            }

            if(!$enabled) {
                redirect('dashboard');
            }
    }


//-----------------------------------------------tampil data ---------------------
    public function index() {

        $data['content_view'] = 'kendaraan/v_kendaraan';
        $data['kendaraan_table'] = $this->create_kendaraan_table();
        $this->load->vars($data);

        $js =  "function confirm_link(text){
                    if(confirm(text)){ return true;
                    }else{ return false; }
                }
                $(document).ready(function() {
                        oTable = $('#kendaraan').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );
                ";

        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "DATA INDUK KENDARAAN";
        $this->template->build('kendaraan/v_kendaraan', $this->session_info);
        //$this->template->build('kendaraan/add_kendaraan', $this->session_info);
    }
    function create_kendaraan_table()
    {
        $kendaraan = $this->m_kendaraan->get_all_kendaraan();
        $kendaraan_table = "";
$counter = 0;
        if(count($kendaraan) > 0)
        {
            
            
            foreach ($kendaraan as $key => $value)
            {
                $counter = $counter+1;
                $kendaraan_table .="<tr>";
                $kendaraan_table .="<td align='center'>{$counter}</td>";
                $kendaraan_table .="<td align='center'>{$value->NO_IK}</td>";
                $kendaraan_table .="<td align='center'>{$value->NO_MOBIL}</td>";
                $kendaraan_table .="<td align='center'>{$value->NO_UJI}</td>";
                $kendaraan_table .="<td align='center'>{$value->DA_ORANG}</td>";
                $kendaraan_table .="<td align='center'>{$value->DA_BARANG}</td>";
                $kendaraan_table .="<td align='center'>{$value->JENIS}</td>";
                $kendaraan_table .="<td align='center'>{$value->MERK}</td>";
                $kendaraan_table .="<td align='center'>{$value->TAHUN_PEMB}</td>";
                $kendaraan_table .="<td align='center'>{$value->NOMOR_KP}</td>";
                $kendaraan_table .="<td ali gn='center'>{$value->NAMA_STNK}</td>";
                $kendaraan_table .="<td align='center'>{$value->ALAMAT_STN}</td>";
               /*$kendaraan_table .="<td align='center'>
                 <!--<a href='".base_url()."bisbesar/c_kendaraan/edit_kendaraan/{$value->NO_MOBIL}'>Edit</a>
            |
                <a href='".base_url()."bisbesar/c_kendaraan/delete_kendaraan/{$value->NO_MOBIL}'>delete</a>--></td>";*/
                $kendaraan_table .="</tr>";
            }
            return $kendaraan_table;
        }
    }

    //--------------------------------------------edit data

    function edit_kendaraan($id){
        $where = array('NO_MOBIL' => $id);
        $data['bb_kendaraan'] = $this->m_kendaraan->edit_data($where,'bb_mobil')->result();
        $data['bb_kp'] = $this->m_kendaraan->edit_data2($where,'bb_kp')->result();
       // $data['bb_traak'] = $this->m_kendaraan->edit_data3($where,'bb_traak')->result();
        $data['kendaraan_table'] = $this->create_kendaraan_table();
        $this->load->vars($data);
         $js =  "function confirm_link(text){
                    if(confirm(text)){ return true;
                    }else{ return false; }
                }
                $(document).ready(function() {
                        oTable = $('#kendaraan').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );
                ";

        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "UBAH KENDARAAN / LINTASAN";
        $this->template->build('kendaraan/edit_kendaraan', $this->session_info);
    }
   //-----------------end edit data

  /*  function addKendaraan()
    {
       // $data['kodya'] = $this->create_kodya_select();
        $data['pau_table'] = $this->create_pau_table();
        $this->load->vars($data);

        $js =  "function confirm_link(text){
                    if(confirm(text)){ return true;
                    }else{ return false; }
                }
                $(document).ready(function() {
                        oTable = $('#perizinan').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );
                ";
       $data['content_view'] = 'add_pengusaha';
       
       $this->load->vars($data);
        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "TAMBAH PENGUSAHA";
        $this->template->build('add_pengusaha', $this->session_info);
    }*/
} 