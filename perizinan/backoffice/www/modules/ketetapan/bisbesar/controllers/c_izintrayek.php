<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 *  @author  R; 
 */

class C_izintrayek extends WRC_AdminCont {

    public function __construct() {
        parent::__construct();
       $this->load->model("m_izintrayek");
$this->load->library('dompdf_gen');
$this->load->library('fpdf');

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

        $data['content_view'] = 'izintrayek/v_izintrayek';
        $data['izintrayek_table'] = $this->create_izintrayek_table();
        $this->load->vars($data);

        $js =  "function confirm_link(text){
                    if(confirm(text)){ return true;
                    }else{ return false; }
                }
                $(document).ready(function() {
                        oTable = $('#izintrayek').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );
                ";

        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "IZIN TRAYEK / OPERASI ANGKUTAN PENUMPANG UMUM";
       $this->template->build('izintrayek/v_izintrayek', $this->session_info);
       // $this->template->build('izintrayek/add_izintrayek', $this->session_info);
    }
    function create_izintrayek_table()
    {
        $tgl_sekarang = date("Y-m-d");
        $izintrayek = $this->m_izintrayek->get_all_izintrayek();
        $izintrayek_table = "";
$counter = 0;
        if(count($izintrayek) > 0)
        {
            foreach ($izintrayek as $key => $value)
            {
                $counter = $counter+1;
                $izintrayek_table .="<tr>";
if($tgl_sekarang >= $value->BERLAKU){
                $izintrayek_table .="<td align='center' style='color:red;'>{$counter}</td>";
               $izintrayek_table .="<td align='center' style='color:red;'>{$value->TGL_BAND}</td>";
               if($value->JENIS_SK == 1){
                    $JENIS_SK = "BIS BESAR";
                }else  if($value->JENIS_SK == 2){
                    $JENIS_SK = "BIS SEDANG";
                } if($value->JENIS_SK == 3){
                      $JENIS_SK = "BIS KECIL";
                }if($value->JENIS_SK == 4){
                      $JENIS_SK = "ANGKOT";
                }if($value->JENIS_SK == 5){
                      $JENIS_SK = "TAKSI";
                }if($value->JENIS_SK == 6){
                      $JENIS_SK = "ANGK. KHUSUS";
                }
               $izintrayek_table .="<td align='' style='color:red;'>$JENIS_SK</td>";
                
                 if($value->JENIS_ANGK == 1){
                    $JENIS_ANGK = "DAFTAR ULANG";
                }else  if($value->JENIS_ANGK == 2){
                    $JENIS_ANGK = "PENGGANTIAN";
                } if($value->JENIS_ANGK == 3){
                      $JENIS_ANGK = "PERLUASAN";
                }if($value->JENIS_ANGK == 4){
                      $JENIS_ANGK = "PENAMBAHAN";
                }if($value->JENIS_ANGK == 5){
                      $JENIS_ANGK = "PELIMPAHAN";
                }if($value->JENIS_ANGK == 6){
                      $JENIS_ANGK = "DUPLIKAT";
                }
                $izintrayek_table .="<td align='center' style='color:red;'>$JENIS_ANGK</td>";
               /* $izintrayek_table .="<td align='center'>{$value->TARIF_BAND}</td>";
                $izintrayek_table .="<td align='center'>{$value->TELAT_TH}</td>";
                $izintrayek_table .="<td align='center'>{$value->TELAT_BL}</td>";
                $izintrayek_table .="<td align=''>{$value->DENDA_BAND}</td>";*/

                $izintrayek_table .="<td align='center' style='color:red;'>{$value->NO_IP}</td>";
                $izintrayek_table .="<td align='center' style='color:red;'>{$value->NAMA_PERUS}</td>";
                $izintrayek_table .="<td align='center' style='color:red;'>{$value->ALAMAT_PER}</td>";
                $izintrayek_table .="<td align='center' style='color:red;'>{$value->KODYA_ID}</td>";
                
               // $izintrayek_table .="<td align='center'>{$value->PEMILIK}</td>";
                //$izintrayek_table .="<td align='center'>{$value->ALAMAT_PEM}</td>";
                $izintrayek_table .="<td align='' style='color:red;'>{$value->NO_SK}</td>";
                $izintrayek_table .="<td align='center' style='color:red;'>{$value->TG_SK}</td>";

                //$izintrayek_table .="<td align='center'>{$value->BERLAKU}</td>";
                $izintrayek_table .="<td align='center' style='color:red;'>{$value->BERLAKU}</td>";
                $izintrayek_table .="<td align='center' style='color:red;'>{$value->NO_SK_LAMA}</td>";
                $izintrayek_table .="<td align='center' style='color:red;'>{$value->TG_SK_LAMA}</td>";
}else{
        $izintrayek_table .="<td align='center' >{$counter}</td>";
               $izintrayek_table .="<td align='center'>{$value->TGL_BAND}</td>";
               if($value->JENIS_SK == 1){
                    $JENIS_SK = "BIS BESAR";
                }else  if($value->JENIS_SK == 2){
                    $JENIS_SK = "BIS SEDANG";
                } if($value->JENIS_SK == 3){
                      $JENIS_SK = "BIS KECIL";
                }if($value->JENIS_SK == 4){
                      $JENIS_SK = "ANGKOT";
                }if($value->JENIS_SK == 5){
                      $JENIS_SK = "TAKSI";
                }if($value->JENIS_SK == 6){
                      $JENIS_SK = "ANGK. KHUSUS";
                }
               $izintrayek_table .="<td align=''>$JENIS_SK</td>";
                
                 if($value->JENIS_ANGK == 1){
                    $JENIS_ANGK = "DAFTAR ULANG";
                }else  if($value->JENIS_ANGK == 2){
                    $JENIS_ANGK = "PENGGANTIAN";
                } if($value->JENIS_ANGK == 3){
                      $JENIS_ANGK = "PERLUASAN";
                }if($value->JENIS_ANGK == 4){
                      $JENIS_ANGK = "PENAMBAHAN";
                }if($value->JENIS_ANGK == 5){
                      $JENIS_ANGK = "PELIMPAHAN";
                }if($value->JENIS_ANGK == 6){
                      $JENIS_ANGK = "DUPLIKAT";
                }
                $izintrayek_table .="<td align='center'>$JENIS_ANGK</td>";
               /* $izintrayek_table .="<td align='center'>{$value->TARIF_BAND}</td>";
                $izintrayek_table .="<td align='center'>{$value->TELAT_TH}</td>";
                $izintrayek_table .="<td align='center'>{$value->TELAT_BL}</td>";
                $izintrayek_table .="<td align=''>{$value->DENDA_BAND}</td>";*/

                $izintrayek_table .="<td align='center'>{$value->NO_IP}</td>";
                $izintrayek_table .="<td align='center'>{$value->NAMA_PERUS}</td>";
                $izintrayek_table .="<td align='center'>{$value->ALAMAT_PER}</td>";
                $izintrayek_table .="<td align='center'>{$value->KODYA_ID}</td>";
                
               // $izintrayek_table .="<td align='center'>{$value->PEMILIK}</td>";
                //$izintrayek_table .="<td align='center'>{$value->ALAMAT_PEM}</td>";
                $izintrayek_table .="<td align=''>{$value->NO_SK}</td>";
                $izintrayek_table .="<td align='center'>{$value->TG_SK}</td>";

                //$izintrayek_table .="<td align='center'>{$value->BERLAKU}</td>";
                $izintrayek_table .="<td align='center'>{$value->BERLAKU}</td>";
                $izintrayek_table .="<td align='center'>{$value->NO_SK_LAMA}</td>";
                $izintrayek_table .="<td align='center'>{$value->TG_SK_LAMA}</td>"; 
}
  
               $izintrayek_table .="<td align='center'>

                <a href='".base_url()."bisbesar/c_izintrayek/daftar_izintrayek/{$value->PIT_ID}' title='Daftar Kendaraan' target='_blank'><img src=".base_url()."assets/images/icon/bus.png></a> 

                <a href='".base_url()."bisbesar/c_izintrayek/cetak_izintrayek/{$value->PIT_ID}' target='_blank' title='Cetak SK'><img src=".base_url()."assets/images/icon/prinsk.ico style='width:20px;height:20px;'></a>
                 <a href='".base_url()."bisbesar/c_izintrayek/cetak_izintrayek_template/{$value->PIT_ID}' target='_blank' title='Cetak SK template'><img src=".base_url()."assets/images/icon/prinsk.ico style='width:20px;height:20px;'></a>
                <a href='".base_url()."bisbesar/c_izintrayek/cetak_daftarkendaraan/{$value->PIT_ID}' target='_blank' title='Cetak Daftar Kendaraan'><img src=".base_url()."assets/images/icon/print1.png style='width:20px;height:20px;'></a>
<a href='".base_url()."bisbesar/c_izintrayek/cetak_daftarkendaraan_template/{$value->PIT_ID}' target='_blank' title='Cetak Daftar Kendaraan Template'><img src=".base_url()."assets/images/icon/print1.png style='width:20px;height:20px;'></a>
            
                <a href='".base_url()."bisbesar/c_izintrayek/editsk_izintrayek/{$value->PIT_ID}' title='Edit SK'><img src=".base_url()."assets/images/icon/sk.png></a>
               
               </td>";
                $izintrayek_table .="</tr>";
            }
            return $izintrayek_table;
        }
    }

    function daftar_izintrayek($id){

    $where = array('PIT_ID' => $id);
       // $where = "551.21/15755/BPPT/KD-T.DAT/BB/BU";
       $data['bb_izintrayek2'] = $this->m_izintrayek->daftar_kendaraan2($where)->result();
       $data['bb_izintrayek'] = $this->m_izintrayek->kendaraan($where)->result();
       // $data['pau_table'] = $this->create_izintrayek_table();
        //$data['kodya'] = $this->create_kodya_select();
        $this->load->vars($data);
         $js =  "function confirm_link(text){
                    if(confirm(text)){ return true;
                    }else{ return false; }
                }
                $(document).ready(function() {
                        oTable = $('#izintrayek').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );
                ";

        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "DAFTAR KENDARAAN (LAMPIRAN SK)";
        $this->template->build('izintrayek/daftarkendaraan_izintrayek.php', $this->session_info);
    }


   /*--- edit kp -----------*/
   function add_kp($id){
$KP_ID =  $id;
$data['bb_tarif'] = $this->m_izintrayek->daftar_tarif()->result();
$data['bb_nosk'] = $this->m_izintrayek->no_sk($KP_ID)->result();
$this->load->vars($data);
   /* $where = array('NO_IK' => $id);
       $data['bb_izintrayek'] = $this->m_izintrayek->editkp_izintrayek($where)->result();
       // $data['pau_table'] = $this->create_izintrayek_table();
        //$data['kodya'] = $this->create_kodya_select();
        $this->load->vars($data);
         $js =  "function confirm_link(text){
                    if(confirm(text)){ return true;
                    }else{ return false; }
                }
                $(document).ready(function() {
                        oTable = $('#izintrayek').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );
                ";
*/
        //$this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "TAMBAH KP";
        $this->template->build('izintrayek/add_kp.php', $this->session_info);
    }
 function add_kp2($id){
$PIT_ID =  $id;
$data['bb_tarif'] = $this->m_izintrayek->daftar_tarif()->result();
$data['bb_nosk'] = $this->m_izintrayek->no_sk2($PIT_ID)->result();
$this->load->vars($data);
   /* $where = array('NO_IK' => $id);
       $data['bb_izintrayek'] = $this->m_izintrayek->editkp_izintrayek($where)->result();
       // $data['pau_table'] = $this->create_izintrayek_table();
        //$data['kodya'] = $this->create_kodya_select();
        $this->load->vars($data);
         $js =  "function confirm_link(text){
                    if(confirm(text)){ return true;
                    }else{ return false; }
                }
                $(document).ready(function() {
                        oTable = $('#izintrayek').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );
                ";
*/
        //$this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "TAMBAH KP";
        $this->template->build('izintrayek/add_kp2.php', $this->session_info);
    }

    function add_kp_aksi(){

        $NO_IK_KEY = $this->input->post('NO_IK_KEY');
        $PIT_ID = $this->input->post('PIT_ID');
        $TG_KP = $this->input->post('TG_KP');
        $TGL_BAND = $this->input->post('TG_KP');
        $JENIS_KP = $this->input->post('JENIS_KP');
        $JENIS = $this->input->post('JENIS');
       

        if($JENIS == "BIS BESAR" ){
            $JENIS_ANGK = '1';
        }else if($JENIS == "BIS SEDANG" ){
            $JENIS_ANGK = '2';
        }else if($JENIS == "BIS KECIL" ){
            $JENIS_ANGK = '3';
        }else if($JENIS == "ANGKOT" ){
            $JENIS_ANGK = '4';
        }else if($JENIS == "TAKSI" ){
            $JENIS_ANGK = '5';
        }else if($JENIS == "ANGKUTAN KHUSUS" ){
            $JENIS_ANGK = '6';
        }
        
        $TARIF = $this->input->post('TARIF');
        $TELAT_TH = $this->input->post('TELAT_TH');
        $TARIF_BAND = $this->input->post('TARIF_BAND');
        $SP_KE = $this->input->post('SP_KE');
        $DENDA_BAND = $this->input->post('DENDA_BAND');
        $TELAT_BL = $this->input->post('TELAT_BL');
        $NO_IK = $this->input->post('NO_IK');
        $NOMOR_KP = $this->input->post('NOMOR_KP');
        $NO_MOBIL = $this->input->post('NO_MOBIL');
        $EX_NO_MOBI = $this->input->post('EX_NO_MOBI');
        $NO_UJI = $this->input->post('NO_UJI');
        $EX_NO_UJI = $this->input->post('EX_NO_UJI');
        $MERK = $this->input->post('MERK');
        $TAHUN_PEMB = $this->input->post('TAHUN_PEMB');
        $BBM = $this->input->post('BBM');
        $DA_ORANG = $this->input->post('DA_ORANG');
        $DA_BARANG = $this->input->post('DA_BARANG');
        $PELAYANAN = $this->input->post('PELAYANAN');  
        $AC = $this->input->post('AC');
        $TOILET = $this->input->post('TOILET');
        $RCSET = $this->input->post('RCSET');
        $SP = $this->input->post('SP');
        $TG_KP = $this->input->post('TG_KP');
        $TG_KPSK = $this->input->post('TG_KPSK');
        $TG_MULAI = $this->input->post('TG_MULAI');
        $TG_AKHIR = $this->input->post('TG_AKHIR');
        $KODE_TRAYE = $this->input->post('KODE_TRAYE');
        $NAMA_STNK = $this->input->post('NAMA_STNK');
        $ALAMAT_STN = $this->input->post('ALAMAT_STN');
        $CATATAN = $this->input->post('CATATAN');
        $HISTORI = $this->input->post('HISTORI');
        $NO_SK = $this->input->post('NO_SK');
        $PAU_ID = $this->input->post('PAU_ID');
        $TRA_ID = $this->input->post('TRA_ID');
        $TG_SK = $this->input->post('TG_SK');

       $data = array(
        
        'PIT_ID' => $PIT_ID,
        'KP_ID' => '(select a.KP_ID + 1 from (SELECT KP_ID  FROM bb_kp order by KP_ID DESC LIMIT 1)a)',
        'MOBIL_ID' => '(select a.MOBIL_ID + 1 from (SELECT MOBIL_ID  FROM bb_kp order by KP_ID DESC LIMIT 1)a)',
        'EX_NO_MOBI' => $EX_NO_MOBI,
        'EX_NO_UJI' => $EX_NO_UJI,
        'NO_MOBIL' => $NO_MOBIL,
        'TG_STNK' => '',
        'NO_UJI' => $NO_UJI,
        'TGL_LAKU_U' => '',
        'NO_IK' => $NOMOR_KP,
        'NOMOR_KP' => $NOMOR_KP,
        'TG_KP' => $TG_KP,
        'TG_KPSK' => $TG_KPSK,
        'TG_MULAI' => $TG_MULAI,
        'TG_AKHIR' => $TG_AKHIR,
        'NO_SK' => $NO_SK,
        'TG_SK' => $TG_SK,
        'PAU_ID' => $PAU_ID,
        'TRA_ID' => $TRA_ID,
        'KODE_TRAYE' => $KODE_TRAYE,
        'PELAYANAN' => $PELAYANAN,
        'SIFAT' => '-',
        'FASILITAS' => '-',

        'STATUS' => 'AKTIF',
        'JUMLAH' => '1',
        'SP' => $SP,
        'AC' => $AC,
        'TOILET' => $TOILET,
        'RCSET' => $RCSET,
        'SP_KE' => $SP_KE,
        'ANTRI_CETA' => 'false',
        'JUM_PO' => '1',
        'JENIS_KP' => $JENIS_KP,
        'CATATAN' => $CATATAN,
        'HISTORI' => $HISTORI,
        'TG_HISTORI' => '-',
        'REGISTRASI' => '-',
        'KETERANGAN' => '-',
        'NO_SURAT' => '-', 
        'TGL_BAND' => $TGL_BAND,
        'TARIF_BAND' => $TARIF_BAND,
        'DENDA_BAND' => $DENDA_BAND,
        'TELAT_TH' => $TELAT_TH,
        'TELAT_BL' => $TELAT_BL,
        'TARIF' => $TARIF,
        'SK_BPPT' => '-',
        'TGL_SRT_DI' => '',
        'KET_LAMP_S' => '-',
        'NO_SURAT_B' => '-',
        'TANGGAL_BP' => '',
        'PERIHAL_BP' => '-',
        'PERTIMBANG' => '-',
        'NOTE_BPPT' => '-',
        'KELENGKAPA' => '-',
        'PT_TEKNIS1' => '-',
        'PT_TEKNIS2' => '-',
        'PT_TEKNIS3' => '-',
        'REKOM_IJIN' => '-',
        'NOTE_BPPT2' => '-'

           /*'TG_KP' => $TG_KP,
            'TGL_BAND ' => $TGL_BAND,
            'JENIS_KP'  => $JENIS_KP,
            'TARIF'  => $TARIF,
            'TELAT_TH' => $TELAT_TH,
            'TARIF_BAND' => $TARIF_BAND,
            'SP_KE' => $SP_KE,
            'DENDA_BAND' => $DENDA_BAND,
            'TELAT_BL' => $TELAT_BL ,
            'NO_IK' => $NOMOR_KP,
            'NOMOR_KP' => $NOMOR_KP,
            'NO_MOBIL' => $NO_MOBIL, 
            'EX_NO_MOBI' => $EX_NO_MOBI,
            'NO_UJI' => $NO_UJI,
            'EX_NO_UJI' => $EX_NO_UJI,
            'PELAYANAN' => $PELAYANAN,
            'AC' => $AC,
            'TOILET' => $TOILET,
            'RCSET' => $RCSET,
            'SP' => $SP,
            'TG_KP' => $TG_KP,
            'TG_KPSK' => $TG_KPSK,
            'TG_MULAI' => $TG_MULAI,
            'TG_AKHIR' => $TG_AKHIR,
            'KODE_TRAYE' => $KODE_TRAYE,
            'CATATAN' => $CATATAN,
            'HISTORI' => $HISTORI*/
        );
     
       /* $where = array(
            'NO_IK' => $NO_IK_KEY
        );*/

     
      $result = $this->m_izintrayek->add_kp_datamobil($data,'bb_kp');

        $data = array(
            'PIT_ID' => $PIT_ID,
            'KP_ID' => '(select a.KP_ID + 1 from (SELECT KP_ID  FROM bb_mobil order by KP_ID DESC LIMIT 1)a)',
            'MOBIL_ID' => '(select a.MOBIL_ID + 1 from (SELECT MOBIL_ID  FROM bb_mobil order by KP_ID DESC LIMIT 1)a)',
            'NO_IK' => $NOMOR_KP,
            'NO_MOBIL' => $NO_MOBIL,
            'TG_STNK' => '',
            'NO_UJI' => $NO_UJI,
            'DA_ORANG' => $DA_ORANG,
            'DA_BARANG' => $DA_BARANG,
            'JENIS'  => $JENIS,
            'JENIS_ANGK'  => $JENIS_ANGK,
            'MERK' => $MERK,
            'TAHUN_PEMB' => $TAHUN_PEMB,
            'NO_MESIN' => '',
            'NO_RANGKA' => '',
            'KP' =>'',
            'NOMOR_KP' => $NOMOR_KP,
            'AC' => $AC,
            'TOILET' => $TOILET,
            'RCSET' => $RCSET,
            'BBM' => $BBM,
            'NAMA_STNK' => $NAMA_STNK,
            'ALAMAT_STN' => $ALAMAT_STN
        );
     
        /*$where = array(
            'NO_IK' => $NO_IK_KEY
        );*/
        $result = $this->m_izintrayek->add_kp_datamobil($data,'bb_mobil');

        if($result=='0'){
            $data["msg"]="gagal";

        }else{
            $data["msg"]="sukses";
        }
          $this->load->vars($data);
        //$this->index();
          $this->daftar_izintrayek($PIT_ID);
       // redirect('crud/index');
}
     function editkp_izintrayek($id){

    $where = array('NO_IK' => $id);
       $data['bb_izintrayek'] = $this->m_izintrayek->editkp_izintrayek($where)->result();
        $data['bb_tarif'] = $this->m_izintrayek->daftar_tarif()->result();
       // $data['pau_table'] = $this->create_izintrayek_table();
        //$data['kodya'] = $this->create_kodya_select();
        $this->load->vars($data);
         $js =  "function confirm_link(text){
                    if(confirm(text)){ return true;
                    }else{ return false; }
                }
                $(document).ready(function() {
                        oTable = $('#izintrayek').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );
                ";

        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "EDIT";
        $this->template->build('izintrayek/editkp_izintrayek.php', $this->session_info);
    }
    function update_kp_aksi(){

        $NO_IK_KEY = $this->input->post('NO_IK_KEY');
        $PIT_ID = $this->input->post('PIT_ID');
        $TG_KP = $this->input->post('TG_KP');
        $TGL_BAND = $this->input->post('TG_KP');
        $JENIS_KP = $this->input->post('JENIS_KP');
        $JENIS = $this->input->post('JENIS');
       

        if($JENIS == "BIS BESAR" ){
            $JENIS_ANGK = '1';
        }else if($JENIS == "BIS SEDANG" ){
            $JENIS_ANGK = '2';
        }else if($JENIS == "BIS KECIL" ){
            $JENIS_ANGK = '3';
        }else if($JENIS == "ANGKOT" ){
            $JENIS_ANGK = '4';
        }else if($JENIS == "TAKSI" ){
            $JENIS_ANGK = '5';
        }else if($JENIS == "ANGKUTAN KHUSUS" ){
            $JENIS_ANGK = '6';
        }
        
        $TARIF = $this->input->post('TARIF');
        $TELAT_TH = $this->input->post('TELAT_TH');
        $TARIF_BAND = $this->input->post('TARIF_BAND');
        $SP_KE = $this->input->post('SP_KE');
        $DENDA_BAND = $this->input->post('DENDA_BAND');
        $TELAT_BL = $this->input->post('TELAT_BL');
        $NO_IK = $this->input->post('NO_IK');
        $NOMOR_KP = $this->input->post('NOMOR_KP');
        $NO_MOBIL = $this->input->post('NO_MOBIL');
        $EX_NO_MOBI = $this->input->post('EX_NO_MOBI');
        $NO_UJI = $this->input->post('NO_UJI');
        $EX_NO_UJI = $this->input->post('EX_NO_UJI');
        $MERK = $this->input->post('MERK');
        $TAHUN_PEMB = $this->input->post('TAHUN_PEMB');
        $BBM = $this->input->post('BBM');
        $DA_ORANG = $this->input->post('DA_ORANG');
        $DA_BARANG = $this->input->post('DA_BARANG');
        $PELAYANAN = $this->input->post('PELAYANAN');  
        $AC = $this->input->post('AC');
        $TOILET = $this->input->post('TOILET');
        $RCSET = $this->input->post('RCSET');
        $SP = $this->input->post('SP');
        $TG_KP = $this->input->post('TG_KP');
        $TG_KPSK = $this->input->post('TG_KPSK');
        $TG_MULAI = $this->input->post('TG_MULAI');
        $TG_AKHIR = $this->input->post('TG_AKHIR');
        $KODE_TRAYE = $this->input->post('KODE_TRAYE');
        $NAMA_STNK = $this->input->post('NAMA_STNK');
        $ALAMAT_STN = $this->input->post('ALAMAT_STN');
        $CATATAN = $this->input->post('CATATAN');
        $HISTORI = $this->input->post('HISTORI');
        $TRA_ID = $this->input->post('TRA_ID');

        $data = array(
           'TG_KP' => $TG_KP,
            'TGL_BAND ' => $TGL_BAND,
            'JENIS_KP'  => $JENIS_KP,
            'TARIF'  => $TARIF,
            'TELAT_TH' => $TELAT_TH,
            'TARIF_BAND' => $TARIF_BAND,
            'SP_KE' => $SP_KE,
            'DENDA_BAND' => $DENDA_BAND,
            'TELAT_BL' => $TELAT_BL ,
            'NO_IK' => $NOMOR_KP,
            'NOMOR_KP' => $NOMOR_KP,
            'NO_MOBIL' => $NO_MOBIL, 
            'EX_NO_MOBI' => $EX_NO_MOBI,
            'NO_UJI' => $NO_UJI,
            'EX_NO_UJI' => $EX_NO_UJI,
            'PELAYANAN' => $PELAYANAN,
            'AC' => $AC,
            'TOILET' => $TOILET,
            'RCSET' => $RCSET,
            'SP' => $SP,
            'TG_KP' => $TG_KP,
            'TG_KPSK' => $TG_KPSK,
            'TG_MULAI' => $TG_MULAI,
            'TG_AKHIR' => $TG_AKHIR,
            'KODE_TRAYE' => $KODE_TRAYE,
            'CATATAN' => $CATATAN,
            'HISTORI' => $HISTORI,
            'TRA_ID' => $TRA_ID
        );
     
        $where = array(
            'NO_IK' => $NO_IK_KEY
        );

     
        $result = $this->m_izintrayek->update_kp_data($where,$data,'bb_kp');

        $data = array(
            'JENIS_ANGK'  => $JENIS_ANGK,
            'JENIS'  => $JENIS,
            'NO_IK' => $NOMOR_KP,
            'NOMOR_KP' => $NOMOR_KP,
            'NO_MOBIL' => $NO_MOBIL,
            'NO_UJI' => $NO_UJI,
            'MERK' => $MERK,
            'TAHUN_PEMB' => $TAHUN_PEMB,
            'BBM' => $BBM,
            'DA_ORANG' => $DA_ORANG,
            'DA_BARANG' => $DA_BARANG,
            'AC' => $AC,
            'TOILET' => $TOILET,
            'RCSET' => $RCSET,
            'NAMA_STNK' => $NAMA_STNK,
            'ALAMAT_STN' => $ALAMAT_STN
        );
     
        $where = array(
            'NO_IK' => $NO_IK_KEY
        );
        $result = $this->m_izintrayek->update_kp_data($where,$data,'bb_mobil');

        if($result=='0'){
            $data["msg"]="gagal";

        }else{
            $data["msg"]="sukses";
        }
          $this->load->vars($data);
        //$this->index();
          $this->daftar_izintrayek($PIT_ID);
       // redirect('crud/index');
}
    /*--end edit kp -------------------*/

    /*-----------edit sk------*/

function editsk_izintrayek($id){

    $where = array('NO_IK' => $id);
       $data['bb_izintrayek'] = $this->m_izintrayek->editsp_izintrayek($where)->result();
        $data['bb_tarif'] = $this->m_izintrayek->daftar_tarif()->result();
       // $data['pau_table'] = $this->create_izintrayek_table();
        //$data['kodya'] = $this->create_kodya_select();
        $this->load->vars($data);
      /*   $js =  "function confirm_link(text){
                    if(confirm(text)){ return true;
                    }else{ return false; }
                }
                $(document).ready(function() {
                        oTable = $('#izintrayek').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );
                ";
        $this->template->set_metadata_javascript($js);*/

        $this->session_info['page_name'] = "EDIT SK";
        $this->template->build('izintrayek/editsk_izintrayek.php', $this->session_info);
    }

    function update_sk_aksi(){

        $PIT_ID = $this->input->post('PIT_ID');
        $TGL_BAND = $this->input->post('TGL_BAND');
        $JENIS_SK = $this->input->post('JENIS_SK');
        $JENIS_ANGK = $this->input->post('JENIS_ANGK');
        $TARIF_BAND = $this->input->post('TARIF_BAND');
        $TELAT_TH = $this->input->post('TELAT_TH');
        $TELAT_BL = $this->input->post('TELAT_BL');
        $DENDA_BAND = $this->input->post('DENDA_BAND');
        $NO_IP = $this->input->post('NO_IP');
        $NAMA_PERUS = $this->input->post('NAMA_PERUS');
        $ALAMAT_PER = $this->input->post('ALAMAT_PER');
        $KODYA_ID = $this->input->post('KODYA_ID');
        $PEMILIK = $this->input->post('PEMILIK');
        $ALAMAT_PEM = $this->input->post('ALAMAT_PEM');
        $NO_SK = $this->input->post('NO_SK');
        $TG_SK = $this->input->post('TG_SK');
        $BERLAKU = $this->input->post('BERLAKU');
        $NO_SK_LAMA = $this->input->post('NO_SK_LAMA');
        $TG_SK_LAMA = $this->input->post('TG_SK_LAMA');

        $data = array(
            //'PIT_ID'  => $PIT_ID,
            'TGL_BAND'  => $TGL_BAND,
            'JENIS_SK' => $JENIS_SK,
            'JENIS_ANGK' => $JENIS_ANGK,
            'TARIF_BAND' => $TARIF_BAND,
            'TELAT_TH' => $TELAT_TH,
            'TELAT_BL' => $TELAT_BL,
            'DENDA_BAND' => $DENDA_BAND,
            'NO_IP' => $NO_IP,
            'NAMA_PERUS' => $NAMA_PERUS,
            'ALAMAT_PER' => $ALAMAT_PER,
            'KODYA_ID' => $KODYA_ID,
            'PEMILIK' => $PEMILIK,
            'ALAMAT_PEM' => $ALAMAT_PEM,
            'NO_SK' => $NO_SK,
            'TG_SK' => $TG_SK,
            'BERLAKU' => $BERLAKU,
            'NO_SK_LAMA' => $NO_SK_LAMA,
            'TG_SK_LAMA' => $TG_SK_LAMA
        );
     
        $where = array(
            'PIT_ID' => $PIT_ID
        );
        $result = $this->m_izintrayek->update_sk_data($where,$data,'bb_pit');

        if($result=='0'){
            $data["msg"]="gagal";
        }else{
            $data["msg"]="sukses";
        }
          $this->load->vars($data);
        $this->index();
       // redirect('crud/index');
}

    /*------------akhir edit sk -------------------*/
    public function addsk_izintrayek() {
        $data['content_view'] = 'izintrayek/v_izintrayek';
        $data['izintrayek_table'] = $this->create_izintrayek_table();
        $data['bb_tarif'] = $this->m_izintrayek->daftar_tarif()->result();
        $this->load->vars($data);

        /*$js =  "function confirm_link(text){
                    if(confirm(text)){ return true;
                    }else{ return false; }
                }
                $(document).ready(function() {
                        oTable = $('#izintrayek').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );
                ";

        $this->template->set_metadata_javascript($js);*/

        $js = "

                $(document).ready(function() {
                    $('#form').validate();
                    $(\"#tabs\").tabs();

                    $('a[rel*=pemohon_box]').facebox();
                    $('a[rel*=daftar_box]').facebox();
                    $('a[rel*=perusahaan_box]').facebox();
                } );
/*
                $(function() {
                    $(\"#inputTanggal1\").datepicker({
                        changeMonth: true,
                        changeYear: true,
                        dateFormat: 'yy-mm-dd',
                        closeText: 'X'
                    });
                    $(\"#inputTanggal2\").datepicker({
                        changeMonth: true,
                        changeYear: true,
                        dateFormat: 'yy-mm-dd',
                        closeText: 'X'
                    });
                });

                $(document).ready(function() {
                    $('#propinsi_pemohon_id').change(function(){
                        $.post('" . base_url() . "pelayanan/pendaftaran/kabupaten_pemohon', { propinsi_id: $('#propinsi_pemohon_id').val() },
                            function(data) {
                                $('#show_kabupaten_pemohon').html(data);
                                $('#show_kecamatan_pemohon').html('Data Tidak tersedia');
                                $('#show_kelurahan_pemohon').html('Data Tidak tersedia');
                            }
                        );
                    }); 
                });

                $(document).ready(function() {
                    $('#propinsi_usaha_id').change(function(){
                        $.post('" . base_url() . "pelayanan/pendaftaran/kabupaten_usaha', { propinsi_id: $('#propinsi_usaha_id').val() },
                            function(data) {
                                $('#show_kabupaten_usaha').html(data);
                                $('#show_kecamatan_usaha').html('Data Tidak tersedia');
                                $('#show_kelurahan_usaha').html('Data Tidak tersedia');
                            }
                        );
                    });
                });

                function show_npwp(form) {
                    var reg = form.nodaftar.value;
                    var npwp = form.npwp_id.value;
                    if (npwp.length==0) {
                        alert('Npwp harus diisi');
                        return false;
                    } else 
                        if (reg.length==0) {
                            alert('No daftar Harus diisi');
                            return false;
                        } else {
                            $.post('" . base_url() . "pelayanan/pendaftaran/pick_perusahaan_data/'+reg, 
                                { data_npwp_id: $('#npwp_id').val() }, 
                                function(response){
                                    setTimeout(\"finishAjax('tabs-2', '\"+escape(response)+\"')\", 400);
                                }
                            );
                            return false;
                        }
                }

                function show_ktp(form) {
                    var reg = form.no_refer.value;
                    if (reg.length==0) {
                        $('#error_id').html('Id tidak Boleh Kosong');
                        return false;
                    } else {
                        $('#error_id').html('');
                        $.post('" . base_url() . "pelayanan/pendaftaran/pick_penduduk_data', 
                            { data_no_refer: $('#no_refer').val() }, 
                            function(response){
                                setTimeout(\"finishAjax('tabs-1', '\"+escape(response)+\"')\", 400);
                            }
                        );
                        return false;
                    }
                }

                function finishAjax(id, response){
                  $('#'+id).html(unescape(response));
                  $('#'+id).fadeIn();
                }

                function Check(){
                    if(document.form.Check_ctr.checked == true){
                        document.form.propinsi_pemohon.disabled = false ;
                        document.form.kabupaten_pemohon.disabled = false ;
                        document.form.kecamatan_pemohon.disabled = false ;
                        document.form.kelurahan_pemohon.disabled = false ;
                    }else{
                        document.form.propinsi_pemohon.disabled = true ;
                        document.form.kabupaten_pemohon.disabled = true ;
                        document.form.kecamatan_pemohon.disabled = true ;
                        document.form.kelurahan_pemohon.disabled = true ;
                    }
                }*/
            ";

        $this->template->set_metadata_javascript($js);

        $this->session_info['page_name'] = "IZIN TRAYEK / OPERASI ANGKUTAN PENUMPANG UMUM";
       $this->template->build('izintrayek/addsk_izintrayek', $this->session_info);
    }

    public function addsk2_izintrayek($id) {
        $PAU_ID = $id;
        $data['content_view'] = 'izintrayek/v_izintrayek';
        $data['izintrayek_table'] = $this->create_izintrayek_table();
        $data['bb_tarif'] = $this->m_izintrayek->daftar_tarif()->result();
        $data['bb_pengusaha'] = $this->m_izintrayek->daftar_pengusaha($PAU_ID)->result();
        $this->load->vars($data);

        /*$js =  "function confirm_link(text){
                    if(confirm(text)){ return true;
                    }else{ return false; }
                }
                $(document).ready(function() {
                        oTable = $('#izintrayek').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );
                ";

        $this->template->set_metadata_javascript($js);*/

        $js = "

                $(document).ready(function() {
                    $('#form').validate();
                    $(\"#tabs\").tabs();

                    $('a[rel*=pemohon_box]').facebox();
                    $('a[rel*=daftar_box]').facebox();
                    $('a[rel*=perusahaan_box]').facebox();
                } );

            ";

        $this->template->set_metadata_javascript($js);

        $this->session_info['page_name'] = "IZIN TRAYEK / OPERASI ANGKUTAN PENUMPANG UMUM";
       $this->template->build('izintrayek/addsk_izintrayek2', $this->session_info);
    }
function tambahSK_aksi(){
   
    //$PIT_ID = $this->input->post('PIT_ID');
    $PIT_ID = "";
   // $PERMOHONAN = $this->input->post('PERMOHONAN');
    $PERMOHONAN ="";
    //$NOMOR_PIT = $this->input->post('NOMOR_PIT');
    $NOMOR_PIT ="";
    //$TANGGAL = $this->input->post('TANGGAL');
    $TANGGAL = "";
    //$PERMOHONA2 = $this->input->post('PERMOHONA2');
    $PERMOHONA2 = "";
    $PAU_ID = $this->input->post('PAU_ID');

    $NO_SK_LAMA = $this->input->post('NO_SK_LAMA');
    $TG_SK_LAMA = $this->input->post('TG_SK_LAMA');
    //$PIT_ID_LAM = $this->input->post('PIT_ID_LAM');
    $PIT_ID_LAM ="";
    $NO_IP = $this->input->post('NO_IP');
    $NAMA_PERUS = $this->input->post('NAMA_PERUS');
    $ALAMAT_PER = $this->input->post('ALAMAT_PER');

    $KODYA_ID = $this->input->post('KODYA_ID');
    $PEMILIK = $this->input->post('PEMILIK');
     $ALAMAT_PEM = $this->input->post('ALAMAT_PEM');
    //$KETERANGAN = $this->input->post('KETERANGAN');
     $KETERANGAN = "(Memo)";
    $SK_LAMA = $this->input->post('SK_LAMA');
    $NO_SK = $this->input->post('NO_SK');
    $TG_SK = $this->input->post('TG_SK');
    $BERLAKU = $this->input->post('BERLAKU');
    $BAGIAN = $this->input->post('BAGIAN');
    //$STATUS = $this->input->post('STATUS');
     $STATUS = "AKTIF";
    //$JUMLAH = $this->input->post('JUMLAH');
     $JUMLAH = "1";
    //$JML_LAMP = $this->input->post('JML_LAMP');
    $JML_LAMP = "";
    $TGL_BAND = $this->input->post('TGL_BAND');
    $TARIF_BAND = $this->input->post('TARIF_BAND');
    $DENDA_BAND = $this->input->post('DENDA_BAND');
    $TELAT_TH = $this->input->post('TELAT_TH');
    $TELAT_BL = $this->input->post('TELAT_BL');
    $JENIS_ANGK = $this->input->post('JENIS_ANGK');
    $JENIS_SK = $this->input->post('JENIS_SK');

    $data = array(
            'PIT_ID' => $PIT_ID,
            'PERMOHONAN' => $PERMOHONAN,
            'NOMOR_PIT' => $NOMOR_PIT,
            'TANGGAL' => $TANGGAL,
            'PERMOHONA2' => $PERMOHONA2,
            'PAU_ID' => $PAU_ID,
            'NO_SK_LAMA' => $NO_SK_LAMA,
            'TG_SK_LAMA' => $TG_SK_LAMA,
            'PIT_ID_LAM' => $PIT_ID_LAM,
            'NO_IP' => $NO_IP,
            'NAMA_PERUS' => $NAMA_PERUS,
            'ALAMAT_PER' => $ALAMAT_PER,
            'KODYA_ID' => $KODYA_ID,
            'PEMILIK' => $PEMILIK,
            'ALAMAT_PEM' => $ALAMAT_PEM,
            'KETERANGAN' => $KETERANGAN,
            'SK_LAMA' => $SK_LAMA,
            'NO_SK' => $NO_SK,
            'TG_SK' => $TG_SK,
            'BERLAKU' => $BERLAKU,
            'BAGIAN' => $BAGIAN,
            'STATUS' => $STATUS,
            'JUMLAH' => $JUMLAH,
            'JML_LAMP' => $JML_LAMP,
            'TGL_BAND' => $TGL_BAND,
            'TARIF_BAND' => $TARIF_BAND,
            'DENDA_BAND' => $DENDA_BAND,
            'TELAT_TH' => $TELAT_TH,
            'TELAT_BL' => $TELAT_BL,
            'JENIS_ANGK' => $JENIS_ANGK,
            'JENIS_SK' => $JENIS_SK


            );
     $result=$this->m_izintrayek->input_data($data,'bb_pit');

        if($result=='0'){
            $data["msg"]="gagal";

        }else{
            $data["msg"]="sukses";
        }
          $this->load->vars($data);
        $this->index();
    }

    //-----------------------------------------------akhir tambah data ---------------------



    //----------------------------TP & DWP
    function tpdwp($id){

    $where = array('KP_ID' => $id);
       $data['bb_tpdwp'] = $this->m_izintrayek->daftar_twdp($where)->result();
       // $data['pau_table'] = $this->create_izintrayek_table();
        //$data['kodya'] = $this->create_kodya_select();
        $this->load->vars($data);
         $js =  "function confirm_link(text){
                    if(confirm(text)){ return true;
                    }else{ return false; }
                }
                $(document).ready(function() {
                        oTable = $('#izintrayek').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );
                ";

        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "TARIF PENGANGKUTAN DAN DAFTAR WAKTU PERJALANAN";
        $this->template->build('izintrayek/tpdwp.php', $this->session_info);
    }

    function edittpdwp($id){

    //$where = array('TPDWP_ID' => $id);
    $where = array('KP_ID' => $id);
       $data['bb_tpdwp'] = $this->m_izintrayek->list_twdp($where)->result();

        $data['bb_tpdwp_perus'] = $this->m_izintrayek->list_twdp_perus($where)->result();
       
       //$data['bb_tpdwp2'] = $this->m_izintrayek->edit_twdp($where)->result();
        // $data['bb_tpdwp2'] = $this->m_izintrayek->daftar_twdp($where)->result();
       // $data['pau_table'] = $this->create_izintrayek_table();
        //$data['kodya'] = $this->create_kodya_select();
        $this->load->vars($data);
         $js =  "function confirm_link(text){
                    if(confirm(text)){ return true;
                    }else{ return false; }
                }
                $(document).ready(function() {
                        oTable = $('#izintrayek').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );
                ";

        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "TARIF PENGANGKUTAN DAN DAFTAR WAKTU PERJALANAN";
        $this->template->build('izintrayek/edit_tpdwp.php', $this->session_info);
    }

     function cetak_daftarkendaraan($id){

    $where = array('PIT_ID' => $id);
       // $where = "551.21/15755/BPPT/KD-T.DAT/BB/BU";
       $data['bb_izintrayek'] = $this->m_izintrayek->daftar_kendaraan($where)->result();
       // $data['pau_table'] = $this->create_izintrayek_table();
        //$data['kodya'] = $this->create_kodya_select();
        $this->load->vars($data);
         $js =  "function confirm_link(text){
                    if(confirm(text)){ return true;
                    }else{ return false; }
                }
                $(document).ready(function() {
                        oTable = $('#izintrayek').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );
                ";

       // $this->template->set_metadata_javascript($js);
       // $this->session_info['page_name'] = "DAFTAR KENDARAAN (LAMPIRAN SK)";
    // $this->template->build('izintrayek/cetak_daftarkendaraan.php', $this->session_info);
 $this->load->view('izintrayek/cetak_daftarkendaraan.php',$this->session_info);

        $paper_size  = 'Continuous'; //paper size
        $orientation = 'potrait'; //tipe format kertas
        $html = $this->output->get_output();
 
        $this->dompdf->set_paper($paper_size, $orientation);
        //Convert to PDF
        $this->dompdf->load_html($html);
        $this->dompdf->render();
        $this->dompdf->stream("cetak daftar kendaraaan id $id.pdf", array('Attachment'=>0));
               
    }
function cetak_daftarkendaraan_template($id){

    $where = array('PIT_ID' => $id);
       // $where = "551.21/15755/BPPT/KD-T.DAT/BB/BU";
       $data['bb_izintrayek'] = $this->m_izintrayek->daftar_kendaraan($where)->result();
       // $data['pau_table'] = $this->create_izintrayek_table();
        //$data['kodya'] = $this->create_kodya_select();
        $this->load->vars($data);
         $js =  "function confirm_link(text){
                    if(confirm(text)){ return true;
                    }else{ return false; }
                }
                $(document).ready(function() {
                        oTable = $('#izintrayek').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );
                ";

       // $this->template->set_metadata_javascript($js);
       // $this->session_info['page_name'] = "DAFTAR KENDARAAN (LAMPIRAN SK)";
    // $this->template->build('izintrayek/cetak_daftarkendaraan.php', $this->session_info);
 $this->load->view('izintrayek/cetak_daftarkendaraan_template.php',$this->session_info);

        //$paper_size  = array(0,0,311.88,311.88);//'A4'; //paper size
        $orientation = 'potrait'; //tipe format kertas
        $html = $this->output->get_output();
 


        $this->dompdf->set_paper('Continuous', $orientation);


        //Convert to PDF
        $this->dompdf->load_html($html);
        $this->dompdf->render();
        $this->dompdf->stream("cetak daftar kendaraaan id $id.pdf", array('Attachment'=>0));
               



    }
/*function cetak_daftarkendaraan_template($id){
      
//define('FPDF_FONTPATH',$this->config->item('fonts_path'));
    $where = array('PIT_ID' => $id);
       $data['bb_izintrayek'] = $this->m_izintrayek->daftar_kendaraan($where)->result();
       // $data['pau_table'] = $this->create_izintrayek_table();
        //$data['kodya'] = $this->create_kodya_select();
        $this->load->vars($data);
         $js =  "function confirm_link(text){
                    if(confirm(text)){ return true;
                    }else{ return false; }
                }
                $(document).ready(function() {
                        oTable = $('#izintrayek').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );
                ";

       // $this->template->set_metadata_javascript($js);
       // $this->session_info['page_name'] = "DAFTAR KENDARAAN (LAMPIRAN SK)";
    // $this->template->build('izintrayek/cetak_daftarkendaraan.php', $this->session_info);
 $this->load->view('izintrayek/cetak_daftarkendaraan_template.php',$this->session_info);

    }*/
     function cetak_kp($id){

    $where = array('NO_IK' => $id);
        $data['bb_tpdwp'] = $this->m_izintrayek->daftar_twdp_cetakkp($where)->result();
       $data['bb_izintrayek'] = $this->m_izintrayek->editkp_izintrayek($where)->result();
       $this->load->vars($data);
        $this->load->view('izintrayek/cetak_kp2.php', $this->session_info);

        $paper_size  = 'A4'; //paper size
        $orientation = 'potrait'; //tipe format kertas
        $html = $this->output->get_output();
 
        $this->dompdf->set_paper($paper_size, $orientation);
        //Convert to PDF
        $this->dompdf->load_html($html);
        $this->dompdf->render();
        $this->dompdf->stream("Kartu Pengawasan Nomor Induk $id.pdf", array('Attachment'=>0));
          
    }
  function cetak_kp_template($id){

    $where = array('NO_IK' => $id);
        $data['bb_tpdwp'] = $this->m_izintrayek->daftar_twdp_cetakkp($where)->result();
       $data['bb_izintrayek'] = $this->m_izintrayek->editkp_izintrayek($where)->result();
       $this->load->vars($data);
        $this->load->view('izintrayek/cetak_kp_template.php', $this->session_info);

        $paper_size  = 'A4'; //paper size
        $orientation = 'potrait'; //tipe format kertas
        $html = $this->output->get_output();
 
       // $this->dompdf->set_paper($paper_size, $orientation);
         $this->dompdf->set_paper('Continuous', $orientation);
        //Convert to PDF
        $this->dompdf->load_html($html);
        $this->dompdf->render();
        $this->dompdf->stream("Kartu Pengawasan Nomor Induk $id.pdf", array('Attachment'=>0));
          
    }
     function cetak_izintrayek($id){

    $where = array('PIT_ID' => $id);
       // $where = "551.21/15755/BPPT/KD-T.DAT/BB/BU";
       $data['bb_izintrayek'] = $this->m_izintrayek->daftar_kendaraan($where)->result();
        $this->load->vars($data);
     


        $this->load->view('izintrayek/cetak_izintrayek2.php', $this->session_info);
        $paper_size  = 'A4'; //paper size
        $orientation = 'potrait'; //tipe format kertas
        $html = $this->output->get_output();
 
        $this->dompdf->set_paper($paper_size, $orientation);
        //Convert to PDF
        $this->dompdf->load_html($html);
        $this->dompdf->render();
        $this->dompdf->stream("Izin Trayek $id.pdf", array('Attachment'=>0));
    }
    function cetak_izintrayek_template($id){

    $where = array('PIT_ID' => $id);
       // $where = "551.21/15755/BPPT/KD-T.DAT/BB/BU";
       $data['bb_izintrayek'] = $this->m_izintrayek->daftar_kendaraan($where)->result();
        $this->load->vars($data);
     


        $this->load->view('izintrayek/cetak_izintrayek_template.php', $this->session_info);
        $paper_size  = 'A4'; //paper size
        $orientation = 'potrait'; //tipe format kertas
        $html = $this->output->get_output();
 
        $this->dompdf->set_paper('Continuous', $orientation);
        //Convert to PDF
        $this->dompdf->load_html($html);
        $this->dompdf->render();
        $this->dompdf->stream("Izin Trayek $id.pdf", array('Attachment'=>0));
    }


     function update_tpdwp(){

        $TPDWP_ID = $this->input->post('TPDWP_ID');
        $KP_ID = $this->input->post('KP_ID');
        $JARAK = $this->input->post('JARAK');
        $TERMINAL_I = $this->input->post('TERMINAL_I');
        $NAMA_KOTA = $this->input->post('NAMA_TERM3');
        $PP1_1 = $this->input->post('PP1_1');
        $PP1_2 = $this->input->post('PP1_2');
        $PP2_1 = $this->input->post('PP2_1');
        $PP2_2 = $this->input->post('PP2_2');
        $PP3_1 = $this->input->post('PP3_1');
        $PP3_2 = $this->input->post('PP3_2');
        $PP4_1 = $this->input->post('PP4_1'); 
        $PP4_2 = $this->input->post('PP4_2');
        $PP5_1 = $this->input->post('PP5_1');
        $PP5_2 = $this->input->post('PP5_2');
        $PP6_1 = $this->input->post('PP6_1');
        $PP6_2 = $this->input->post('PP6_2');
     

      $where2 =$TPDWP_ID;

        $data = array(
            'TERMINAL_I' => $TERMINAL_I,
            'NAMA_TERM3' => $NAMA_KOTA,
            'JARAK' => $JARAK,
            'PP1_1' => $PP1_1,
            'PP1_2' => $PP1_2,
            'PP2_1' => $PP2_1,
            'PP2_2' => $PP2_2,
            'PP3_1' => $PP3_1,
            'PP3_2' => $PP3_2,
            'PP4_1' => $PP4_1,
            'PP4_2' => $PP4_2,
            'PP5_1' => $PP5_1,
            'PP5_2' => $PP5_2,
            'PP6_1' => $PP6_1,
            'PP6_2' => $PP6_2
        );
   
    $where3 = $NAMA_KOTA;
$this->load->vars($where3);
        $where = array(
            'TPDWP_ID' => $TPDWP_ID
        );

      

        $result = $this->m_izintrayek->update_tpdwp($where,$data,'bb_tp_dwp',$where2,$where3);



        if($result=='0'){
            $data["msg"]="gagal";
        }else{
            $data["msg"]="sukses";
        }
          $this->load->vars($data);
      $this->edittpdwp($KP_ID);
       // redirect('crud/index');
}

function tambah_tpdwp_aksi($KP_ID){
   $KP_ID = $KP_ID;
  
    
        //$TPDWP_ID = $this->input->post('xTPDWP_ID');
        $PIT_ID = $this->input->post('xPIT_ID');
        $NO_SK = $this->input->post('xNO_SK');
        $TG_SK = $this->input->post('xTG_SK');
        $KP_ID = $this->input->post('xKP_ID');
        $NOMOR_KP = $this->input->post('xNOMOR_KP');
        $NO_MOBIL = $this->input->post('xNO_MOBIL');
        $NO_UJI = $this->input->post('xNO_UJI');
        $PAU_ID = $this->input->post('xPAU_ID');
        $TRA_ID = $this->input->post('xTRA_ID');
        $KODE_TRAYE = $this->input->post('xKODE_TRAYE');
        $NAMA_TRAYE = $this->input->post('xNAMA_TRAYE');
        /*$TERMINAL1_ = $this->input->post('xTERMINAL1_');
        $NAMA_TERMI = $this->input->post('xNAMA_TERMI');
        $TERMINAL2_ = $this->input->post('xTERMINAL2_');
        $NAMA_TERM2 = $this->input->post('xNAMA_TERM2');*/
        $JARAK = $this->input->post('xJARAK');
       /* $TARIF = $this->input->post('xTARIF');
        $JUMLAH = $this->input->post('xJUMLAH');
        $BERANGKAT = $this->input->post('xBERANGKAT');
        $TIBA = $this->input->post('xTIBA');*/
        $TERMINAL_I = $this->input->post('xTERMINAL_I');
        $NAMA_TERM3 = $this->input->post('xNAMA_TERM3');
        $PP1_1 = $this->input->post('xPP1_1');
        $PP1_2 = $this->input->post('xPP1_2');
        $PP2_1 = $this->input->post('xPP2_1');
        $PP2_2 = $this->input->post('xPP2_2');
        $PP3_1 = $this->input->post('xPP3_1');
        $PP3_2 = $this->input->post('xPP3_2');
        $PP4_1 = $this->input->post('xPP4_1');
        $PP4_2 = $this->input->post('xPP4_2');
        $PP5_1 = $this->input->post('xPP5_1');
        $PP5_2 = $this->input->post('xPP5_2');
        $PP6_1 = $this->input->post('xPP6_1');
        $PP6_2 = $this->input->post('xPP6_2');


    $data = array(
            'TPDWP_ID' => '',
            'PIT_ID' => $PIT_ID,
            'NO_SK' => $NO_SK,
            'TG_SK' => $TG_SK,
            'KP_ID' => $KP_ID,
            'NOMOR_KP' => $NOMOR_KP,
            'NO_MOBIL' => $NO_MOBIL,
            'NO_UJI' => $NO_UJI,
            'PAU_ID' => $PAU_ID,
            'TRA_ID' => $TRA_ID,
            'KODE_TRAYE' => $KODE_TRAYE,
            'NAMA_TRAYE' => $NAMA_TRAYE,
            'TERMINAL1_' => ' ',
            'NAMA_TERMI' => ' ',
            'TERMINAL2_' => ' ',
            'NAMA_TERM2' => ' ',
            'JARAK' => $JARAK,
            'TARIF' => ' ',
            'JUMLAH' => ' ',
            'BERANGKAT' => ' ',
            'TIBA' => ' ',
            'TERMINAL_I' => $TERMINAL_I,
            'NAMA_TERM3' => $NAMA_TERM3,
            'PP1_1' => $PP1_1,
            'PP1_2' => $PP1_2,
            'PP2_1' => $PP2_1,
            'PP2_2' => $PP2_2,
            'PP3_1' => $PP3_1,
            'PP3_2' => $PP3_2,
            'PP4_1' => $PP4_1,
            'PP4_2' => $PP4_2,
            'PP5_1' => $PP5_1,
            'PP5_2' => $PP5_2,

            'PP6_1' => $PP6_1,
            'PP6_2' => $PP6_2

            );
     $result=$this->m_izintrayek->input_data($data,'bb_tp_dwp');

        if($result=='0'){
            $data["msg"]="gagal";

        }else{
            $data["msg"]="sukses";
        }
          $this->load->vars($data);
        $this->edittpdwp($KP_ID);
    }

      function hapus_tpdwp($id,$KP_ID){

    $where = $id;
    $KP_ID = $KP_ID;
     $result=$this->m_izintrayek->hapus_datatpdwp($where);

        if($result=='0'){
            $data["msg"]="gagal";

        }else{
            $data["msg"]="sukses";
        }
          $this->load->vars($data);
        $this->edittpdwp($KP_ID);
}

function tes(){
 $this->load->view('izintrayek/welcome_message.php', $this->session_info);
   $paper_size  = 'A4'; //paper size
        $orientation = 'potrait'; //tipe format kertas
        $html = $this->output->get_output();
 
        $this->dompdf->set_paper($paper_size, $orientation);
        //Convert to PDF
        $this->dompdf->load_html($html);
        $this->dompdf->render();
        $this->dompdf->stream("Izin Trayek $id.pdf", array('Attachment'=>0));
}

}