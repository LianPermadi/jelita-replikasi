<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 *  @author  Royan; 
 */
class C_pengenalimpor extends WRC_AdminCont {

    public function __construct() {
        parent::__construct();
       $this->load->model("m_api");
            $enabled = FALSE;
            $list_auths = $this->session_info['app_list_auth'];

            foreach ($list_auths as $list_auth) {
                if($list_auth->id_role === '31') {
                    $enabled = TRUE;
                }
            }

            if(!$enabled) {
                redirect('dashboard');
            }
    }

    public function index() {

        $data['api_table'] =$this->create_api_table();
        $this->load->vars($data);
            $js =  "function confirm_link(text){
                    if(confirm(text)){ return true;
                    }else{ return false; }
                }
                $(document).ready(function() {
                        oTable = $('#dataapi').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );
                ";

        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "ANGKA PENGENAL IMPORT (API)";
        //$this->template->build('v_import', $this->session_info);
        $this->template->build('v_data_api', $this->session_info);
    }
    function create_api_table(){
        $no_api = "";
        $api = $this->m_api->get_data_api($no_api);
        $api_table = "";
        $counter = 0;
        $api_table .="<tr>";
        if(count($api) > 0)
        {
            foreach ($api as $key => $value)
            {
                $counter = $counter+1;
                $api_table .="<td align='center' >$counter</td>";
                $api_table .="<td align='center' >{$value->no_api}</td>";
                $api_table .="<td align='center' >{$value->jenis_api}</td>";
                $api_table .="<td align='center' >{$value->uraian_barang}</td>";
                $api_table .="<td align='center' >{$value->hs10digit}</td>";
                $api_table .="<td align='center' >{$value->volume}</td>";
                $api_table .="<td align='center' >{$value->satuan}</td>";
                $api_table .="<td align='center' >{$value->harga_satuan}</td>";
                $api_table .="<td align='center' >{$value->nilai_cif}</td>";
                $api_table .="<td align='center' >{$value->nilai_cnf}</td>";
                $api_table .="<td align='center' >{$value->nilai_fob}</td>";
                $api_table .="<td align='center' >{$value->currency}</td>";
                $api_table .="<td align='center' >{$value->negara_asal}</td>";
                $api_table .="<td align='center' >{$value->pelabuhan_asal}</td>";
                $api_table .="<td align='center' >{$value->pelabuhan_tujuan}</td>";
                $api_table .="<td align='center' >{$value->nomor_ls}</td>";
                $api_table .="<td align='center' >{$value->tgl_ls}</td>";
                $api_table .="<td align='center' >{$value->nomor_pib}</td>";
                $api_table .="<td align='center' >{$value->tgl_pib}</td>";
                $api_table .="<td align='center' >{$value->flag}</td>";
            }
        }
        $api_table .="</tr>";
        return $api_table;
    }

    function perusahaan() {
        $this->load->model('mnotifikasi');
        $data['jlhnotif'] =$this->mnotifikasi->notif_count();
        $data['notifikasi'] =$this->mnotifikasi->getnotifikasi();
        $data['api_table'] =$this->create_perusahaanapi_table();
        $this->load->vars($data);
        $js =  "function confirm_link(text){
                    if(confirm(text)){ return true;
                    }else{ return false; }
                }
                $(document).ready(function() {
                        oTable = $('#dataapi').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );
                ";

        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "ANGKA PENGENAL IMPORT (API)";
        //$this->template->build('v_import', $this->session_info);
        $this->template->build('v_data_perusahaanapi', $this->session_info);
    }

    function create_perusahaanapi_table(){
        $no_api = "";
        $api = $this->m_api->get_data_perusahaanapi($no_api);
        $api_table = "";
        $counter = 0;
         
        if(count($api) > 0)
        {
            foreach ($api as $key => $value)
            {
                $counter = $counter+1;
                $api_table .="<tr>";
                $api_table .="<td align='center' >$counter</td>";
                $api_table .="<td align='center' >{$value->namaPerusahaan}</td>";
                $api_table .="<td align='' >{$value->almtPerusahaan}</td>";
                $api_table .="<td align='center' >{$value->no_api}</td>";
                $api_table .="<td align='center' >{$value->npwpPerusahaan}</td>";
                $api_table .="<td align='center' >{$value->namaKabupaten}</td>";
                $api_table .="<td align='center' >{$value->telpPerusahaan}</td>";
                $api_table .="<td align='center' >{$value->faxPerusahaan}</td>";
                $api_table .="<td align='center' >{$value->emailPerusahaan}</td>";
                $api_table .="<td align='center' > 
               <a href='".base_url()."pengenalimpor/c_pengenalimpor/detail_api_perusahaan/{$value->no_api}'  title='data api Perusahaan'><img src=".base_url()."assets/images/icon/sk.png style='width:20px;height:20px;'></a>
                <a href='".base_url()."pengenalimpor/c_pengenalimpor/pesan/{$value->id_tmpemohon}'  title='Pesan Perusahaan'><img src=".base_url()."assets/images/icon/pesan.png style='width:20px;height:20px;'></a>
               </td>";
                $api_table .="</tr>";
            }
        }  
            return $api_table;
    }

    function detail_api_perusahaan($noapi) {
        $tgl1 = $this->input->post('tgl1');
        $tgl2 = $this->input->post('tgl2');
        $data['tgl1'] = $tgl1;
        $data['tgl2'] = $tgl2;
        $data['perusahaan'] = $this->m_api->get_data_perusahaanapi($noapi);
        $data['api_table'] = $this->create_detailapi_table($noapi,$tgl1,$tgl2);
        $this->load->vars($data);
        $js =  "function confirm_link(text){
                    if(confirm(text)){ return true;
                    }else{ return false; }
                }
                $(document).ready(function() {
                        oTable = $('#dataapi').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );
                ";

        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "ANGKA PENGENAL IMPORT (API)";
        //$this->template->build('v_import', $this->session_info);
        $this->template->build('v_data_detailapi', $this->session_info);
    }

    function create_detailapi_table($no_api,$tgl1,$tgl2){
        $noapi = $no_api;
        $api = $this->m_api->get_datadetail_api($noapi,$tgl1,$tgl2);
        $api_table = "";
        $counter = 0;
         
        if(count($api) > 0)
        {
            foreach ($api as $key => $value)
            {
                $counter = $counter+1;
                $api_table .="<tr>";
                $api_table .="<td align='center' >$counter</td>";
                $api_table .="<td align='center' >{$value->no_api}</td>";
                $api_table .="<td align='center' >{$value->jenis_api}</td>";
                $api_table .="<td align='center' >{$value->uraian_barang}</td>";
                $api_table .="<td align='center' >{$value->hs10digit}</td>";
                $api_table .="<td align='center' >{$value->volume}</td>";
                $api_table .="<td align='center' >{$value->satuan}</td>";
                $api_table .="<td align='center' >{$value->harga_satuan}</td>";
                $api_table .="<td align='center' >{$value->nilai_cif}</td>";
                $api_table .="<td align='center' >{$value->nilai_cnf}</td>";
                $api_table .="<td align='center' >{$value->nilai_fob}</td>";
                $api_table .="<td align='center' >{$value->currency}</td>";
                $api_table .="<td align='center' >{$value->negara_asal}</td>";
                $api_table .="<td align='center' >{$value->pelabuhan_asal}</td>";
                $api_table .="<td align='center' >{$value->pelabuhan_tujuan}</td>";
                $api_table .="<td align='center' >{$value->nomor_ls}</td>";
            if($value->tgl_ls == '0000-00-00'){
                $api_table .="<td align='center' ></td>";
            }else{
                $api_table .="<td align='center' >{$value->tgl_ls}</td>";
            }
                $api_table .="<td align='center' >{$value->nomor_pib}</td>";
                $api_table .="<td align='center' >{$value->tgl_pib}</td>";
                if($value->flag == 'not'){
                $api_table .="<td align='center' >Belum Di Validasi</td>";
            }else if($value->flag == 'revisi'){
                $api_table .="<td align='center' >Proses Revisi</td>";
            }else if($value->flag == 'ok'){
                $api_table .="<td align='center' >OK</td>";
            }      
                $api_table .="</tr>";
            }
        }else{
            $api_table .="<td align='center' ></td>";
            $api_table .="<td align='center' ></td>";
            $api_table .="<td align='center' ></td>";
            $api_table .="<td align='center' ></td>";
            $api_table .="<td align='center' ></td>";
            $api_table .="<td align='center' ></td>";
            $api_table .="<td align='center' ></td>";
            $api_table .="<td align='center' ></td>";
            $api_table .="<td align='center' ></td>";
            $api_table .="<td align='center' ></td>";
            $api_table .="<td align='center' ></td>";
            $api_table .="<td align='center' ></td>";
            $api_table .="<td align='center' ></td>";
            $api_table .="<td align='center' ></td>";
            $api_table .="<td align='center' ></td>";
            $api_table .="<td align='center' ></td>";
            $api_table .="<td align='center' ></td>";
            $api_table .="<td align='center' ></td>";
            $api_table .="<td align='center' ></td>";
            $api_table .="<td align='center' ></td>";
            $api_table .="</tr>";
        }
      
        return $api_table;
    }
    
    function exceldetail_api_perusahaan($noapi) {
        $tgl1 = $this->input->post('tgl11');
        $tgl2 = $this->input->post('tgl22');
        $data['tgl1'] = $tgl1;
        $data['tgl2'] = $tgl2;
        $data['perusahaan'] = $this->m_api->get_data_perusahaanapi($noapi);
        $data['api_table'] = $this->create_detailapi_table($noapi,$tgl1,$tgl2);
        $this->load->vars($data);
        $this->load->view('v_exceldata_detailapi', $this->session_info);
    }

    function approve()
    {
        $post1 = str_replace(',', '', ($this->input->post('tgl1')));
        $post2 = str_replace(',', '', ($this->input->post('tgl2')));
        $perusahaan = $this->input->post('perusahaan');
        $tg1 = date("Y-m-d",strtotime($post1));
        $tg2 = date("Y-m-d",strtotime($post2));
        $data['tgl1'] = $tg1;
        $data['tgl2'] = $tg2;
        $this->load->model('m_import');
        $data['tabel_api'] = $this->m_import->approve($tg1,$tg2);
        $data['tbl_perusahaan_approve'] = $this->m_import->perusahaan_approve($tg1,$tg2);
        $this->load->vars($data);
        $this->session_info['page_name'] = "ANGKA PENGENAL IMPORT";
        $this->template->build('v_import', $this->session_info);
    }

    function perusahaan_approve()
    {
        $data['api_table'] =$this->create_perusahaanapiapprove_table();
        $this->load->vars($data);
        $js =  "function confirm_link(text){
                    if(confirm(text)){ return true;
                    }else{ return false; }
                }
                $(document).ready(function() {
                        oTable = $('#dataapi').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );
                ";

        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "DAFTAR PERUSAHAAN DENGAN LAPORAN API YANG BELUM DI VALIDASI";
        $this->template->build('v_data_perusahaanapiapprove', $this->session_info);
    }

    function create_perusahaanapiapprove_table(){
        $no_api = "";
        $api = $this->m_api->get_data_perusahaanapiapprove($no_api);
        $api_table = "";
        $counter = 0;
        
        if(count($api) > 0)
        {
            foreach ($api as $key => $value)
            { 
                
                $counter = $counter+1;
                $api_table .="<tr>";
                $api_table .="<td align='center' >{$counter}</td>";
                $api_table .="<td align='center' >{$value->no_api}</td>";
                $api_table .="<td align='center' >{$value->namaPerusahaan}</td>";
                $api_table .="<td align='' >{$value->almtPerusahaan}</td>";
                /*$api_table .="<td align='center' >{$value->npwpPerusahaan}</td>";*/
                $api_table .="<td align='center' >{$value->namaKabupaten}</td>";
                $api_table .="<td align='center' >{$value->telpPerusahaan}</td>";
                /*$api_table .="<td align='center' >{$value->faxPerusahaan}</td>";
                $api_table .="<td align='center' >{$value->emailPerusahaan}</td>";*/
                $api_table .="<td align='center' > 
               <a href='".base_url()."pengenalimpor/c_pengenalimpor/approve_apiperusahaan/{$value->no_api}'  title='approve API'><img src=".base_url()."assets/images/icon/sk.png style='width:20px;height:20px;'></a>
               </td>";
                $api_table .="</tr>";
            }
            return $api_table;
        }
    }

    function approve_apiperusahaan($noapi)
    {
        $this->load->model('m_api');
        $data['tabel_api'] = $this->m_api->approve($noapi);
        $data['tbl_perusahaan_approve'] = $this->m_api->perusahaan_approve($noapi);
        $this->load->vars($data);
        $this->session_info['page_name'] = "ANGKA PENGENAL IMPORT";
        $this->template->build('v_approve_api', $this->session_info);
    }

    function update_multiple() {
        $this->load->model('m_api');
        $this->m_api->update_approve();
        redirect('pengenalimpor/c_pengenalimpor/perusahaan_approve');
        
    }

    public function load_row(){     //fungsi load_row untuk menampilkan jlh data pada navbar secara realtime
        $this->load->model('mnotifikasi');
        echo $this->mnotifikasi->notif_count(); //jumlah data akan langsung di tampilkan
    }

    public function load_data(){    //fungsi load_data untuk menampilkan isi data pada navbar secara realtime
        $this->load->model('mnotifikasi');
        $datas=$this->mnotifikasi->getnotifikasi();
        $no=0;
        foreach($datas as $rdata){ $no++;
            if($no % 2==0){$cl='strip1';}
                    else{$cl='strip2';}
            echo"<li><a href=\"#\" class=\"".$cl."\">".$rdata->pesan."<br>
            <small>".$rdata->oleh." ".timeAgo($rdata->tanggal)."</small>
            </a><li>";
        }
    }

    public function pesan($id_tmpemohon) {
        $dbmysql2 = $this->load->database('otherdb',TRUE);
         $data = array (
            'status_admin' => 'ok'
        );
        $dbmysql2->where('id_tmpemohon', $id_tmpemohon);
        $dbmysql2->where('status_admin','belum');
        $dbmysql2->update('api_pesan', $data);
        $data['pesan_table'] =$this->create_pesan_table($id_tmpemohon);
        $data['id_tmpemohon'] = $id_tmpemohon ;
        $this->load->vars($data);
        $js =  "function confirm_link(text){
                    if(confirm(text)){ return true;
                    }else{ return false; }
                }
                $(document).ready(function() {
                        oTable = $('#dataapi').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );
                ";

        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "PESAN";
        //$this->template->build('v_import', $this->session_info);
        $this->template->build('v_data_pesan', $this->session_info);
    }

    function create_pesan_table($id_tmpemohon){
        $pesan = $this->m_api->get_data_pesan($id_tmpemohon);
        $counter = 0;
        $pesan_table = "";
        
        if(count($pesan) > 0)
        {
            foreach ($pesan as $key => $value)
            {
                $counter = $counter+1;
                $pesan_table .="<tr>";
                $pesan_table .="<td align='center' style='width:10px;' >$counter</td>";
                $pesan_table .="<td align='' style='width:150px;' >{$value->oleh}<br><small>{$value->tgl_pesan}</smal></td>";
                $pesan_table .="<td align='' >{$value->pesan}</td>";
                $pesan_table .="</tr>";
            }
        }
        return $pesan_table;
    }

    function simpan_pesan(){
        
        $pesan = $this->input->post('pesan');
        $oleh = $this->input->post('oleh');
        $tanggal = date("Y-m-d H:i:s");
        $id_tmpemohon = $this->input->post('id_tmpemohon');

        $data = array(
        'id' => '', 
        'tgl_pesan' => $tanggal, 
        'pesan' => $pesan, 
        'tanggal' => time(), 
        'oleh' => $oleh, 
        'id_tmpemohon' => $id_tmpemohon, 
        'status' => 'belum',
        'status_admin' => 'ok'
        );
        $dbmysql2 = $this->load->database('otherdb',TRUE);
        $hasil = $dbmysql2->insert('api_pesan',$data);
        redirect('pengenalimpor/c_pengenalimpor/pesan/'.$id_tmpemohon, 'refresh');
    }  
}