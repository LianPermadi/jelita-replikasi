<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of welcome
 *
 * @author R
 */
class Laporanapiuser extends MY_Controller {

    function __construct() {
        parent::__construct();

        $this->tm_pemohon = new Tm_pemohon();
        $this->tmwcm = new Tmwcm();
        $this->load->library('curl');
        $this->load->library('xml_parsing_win');
        $this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
        $detect = $this->load->library('Mobile_Detect');
        if ($detect->isMobile()) {
            $link = "http" . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "s" : "") . "://";
            $server = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'];


            $base_url = base_url();
            $xx = explode('/', $base_url);
            $x = 0;
            $jumlah_url_1 = count($xx) - 1;
            $jumlah_url = count($xx);
            $url_mobile = NULL;
            foreach ($xx as $apl_mobile_url) {
                $x++;

                if ($jumlah_url_1 == $x) {
                    
                } elseif ($jumlah_url == $x) {
                    
                } else {
                    if ($x == 1) {
                        $url_mobile.= $apl_mobile_url;
                        $url_mobile.= '//';
                    } elseif ($x == 2) {
                        
                    } else {
                        $url_mobile.= $apl_mobile_url;
                        $url_mobile.= '/';
                    }
                }
            }

            redirect($url_mobile."alp_mobile");
        }
    }
	
	function index(){
		redirect('main/laporanapiuser/step1', 'refresh');
       
	}
    function step1(){
    
        $username   = $this->session->userdata("username");
        $session        = $this->session->userdata("userlogin");
        
        if(empty($session)){
            redirect('main/login', 'refresh');
            die;
        }
        
        $otherdb    = $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
        
        $otherdb->order_by("urutan","asc");
      //  $query  = $otherdb->query("select * from trsektor")->result();
        $query2 = $this->db->get_where('tm_pemohon', array('username' => $username,'status'=>'1'))->first_row();

         $sql = "select * from api_no_api where id_tmpemohon = (select id from tm_pemohon where username = ?)";
         $query3 = $this->db->query($sql,$username)->result();

        $data['title']              = "Laporan Api";
        $data['load']           = "laporanapi/inputnoapi";
      //  $data['perizinan']  = $query;
        $data['data']           = $query2;
        $data['data_noapi'] = $query3;
        $this->load->view('template_user',$data);
    
    }
     function inputnoapi(){
    
        $username   = $this->session->userdata("username");
        $session        = $this->session->userdata("userlogin");
        
        if(empty($session)){
            redirect('main/login', 'refresh');
            die;
        }
        
        $otherdb    = $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
        
        $otherdb->order_by("urutan","asc");
        $query  = $otherdb->query("select * from trsektor")->result();
        
        $query2 = $this->db->get_where('tm_pemohon', array('username' => $username,'status'=>'1'))->first_row();
       
        
        $data['title']              = "Laporan Api";
        $data['load']           = "laporanapi/inputnoapi";
        $data['perizinan']  = $query;
        $data['data']           = $query2;
      
        $this->load->view('template_user',$data);
    
    }

    function dataapi(){
     $this->load->model('mnotifikasi');
        $data['tgl1'] = '';
        $data['tgl2'] = '';

        $username   = $this->session->userdata("username");
        $session        = $this->session->userdata("userlogin");
        
        if(empty($session)){
            redirect('main/login', 'refresh');
            die;
        }
        
       // $otherdb    = $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
        
        //$otherdb->order_by("urutan","asc");
      //  $query  = $otherdb->query("select * from trsektor")->result();
        $query2 = $this->db->get_where('tm_pemohon', array('username' => $username,'status'=>'1'))->first_row();

         $sql = "select * from api_no_api where id_tmpemohon = (select id from tm_pemohon where username = ?)";
         $query3 = $this->db->query($sql,$username)->result();

foreach ($query3 as $key => $value) {
    $nomor = $value->no_api;
    $id_tmpemohon = $value->id_tmpemohon;
}
if($nomor == null){
$noapi = '';
}else{
$noapi = $nomor;    
}

        // $sqldataapi = "select * from api_realisasi_import where no_api = ? order by tgl_pib desc";
       //  $query4 = $this->db->query($sqldataapi,$noapi)->result();

        $data['title']              = "Laporan Api";
        $data['load']           = "laporanapi/dataapi";
      //  $data['perizinan']  = $query;
        $data['data']           = $query2;
        $data['data_noapi'] = $query3;
       // $data['data_api'] = $query4;


        $data['jlhnotif'] =$this->mnotifikasi->notif_count($id_tmpemohon);  //menghitung jumlah post
        $data['notifikasi'] =$this->mnotifikasi->getnotifikasi($id_tmpemohon);


        $this->load->view('template_user',$data);
    
    }

function cari_dataapi(){
      $this->load->model('mnotifikasi');
        $username   = $this->session->userdata("username");
        $session    = $this->session->userdata("userlogin");
        $tgl1 = $this->input->post('tgl1');
        $tgl2 = $this->input->post('tgl2');
        
        if(empty($session)){
            redirect('main/login', 'refresh');
            die;
        }
        
       // $otherdb    = $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
        
        //$otherdb->order_by("urutan","asc");
      //  $query  = $otherdb->query("select * from trsektor")->result();
        $query2 = $this->db->get_where('tm_pemohon', array('username' => $username,'status'=>'1'))->first_row();

         $sql = "select * from api_no_api where id_tmpemohon = (select id from tm_pemohon where username = ?) ";
         $query3 = $this->db->query($sql,$username)->result();

foreach ($query3 as $key => $value) {
    $nomor = $value->no_api;
    $id_tmpemohon = $value->id_tmpemohon;
}
if($nomor == null){
$noapi = '';
}else{
$noapi = $nomor;    
}
      //   $sqldataapi = "select * from api_realisasi_import where no_api = ? order by tgl_pib desc";
      //   $query4 = $this->db->query($sqldataapi,$noapi)->result();



  $this->db->where('no_api', $noapi);
 $this->db->where('tgl_pib >=', $tgl1);
 $this->db->where('tgl_pib <=', $tgl2);
 $this->db->where('flag','ok');
$query4 = $this->db->get('api_realisasi_import')->result();

        $data['title']              = "Laporan Api";
        $data['load']           = "laporanapi/dataapi_ok";
      //  $data['perizinan']  = $query;
        $data['data']           = $query2;
        $data['data_noapi'] = $query3;
        $data['data_api'] = $query4;
        $data['tgl1'] = $tgl1;
        $data['tgl2'] = $tgl2;

          $data['jlhnotif'] =$this->mnotifikasi->notif_count($id_tmpemohon);  //menghitung jumlah post
        $data['notifikasi'] =$this->mnotifikasi->getnotifikasi($id_tmpemohon);

        $this->load->view('template_user',$data);
     
    }
function tambah_api(){
    

        $username   = $this->session->userdata("username");
        $session        = $this->session->userdata("userlogin");
        
        if(empty($session)){
            redirect('main/login', 'refresh');
            die;
        }
        
    
        $query2 = $this->db->get_where('tm_pemohon', array('username' => $username,'status'=>'1'))->first_row();

         $sql = "select * from api_no_api where id_tmpemohon = (select id from tm_pemohon where username = ?)";
         $query3 = $this->db->query($sql,$username)->result();

foreach ($query3 as $key => $value) {
    $nomor = $value->no_api;
}
if($nomor == null){
$noapi = '';
}else{
$noapi = $nomor;    
}

         $sqldataapi = "select * from api_realisasi_import where no_api = ? order by tgl_pib desc";
         $query4 = $this->db->query($sqldataapi,$noapi)->result();

        $data['title']              = "Laporan Api";
        $data['load']           = "laporanapi/tambah_api";
      //  $data['perizinan']  = $query;
        $data['data']           = $query2;
        $data['data_noapi'] = $query3;
        $data['data_api'] = $query4;

        $this->load->view('template_user',$data);
}

function upload_api(){
    
/*
        $username   = $this->session->userdata("username");
        $session        = $this->session->userdata("userlogin");
        
        if(empty($session)){
            redirect('main/login', 'refresh');
            die;
        }
        
    
        $query2 = $this->db->get_where('tm_pemohon', array('username' => $username,'status'=>'1'))->first_row();

         $sql = "select * from api_no_api where id_tmpemohon = (select id from tm_pemohon where username = ?)";
         $query3 = $this->db->query($sql,$username)->result();

foreach ($query3 as $key => $value) {
    $nomor = $value->no_api;
}
if($nomor == null){
$noapi = '';
}else{
$noapi = $nomor;    
}

         $sqldataapi = "select * from api_realisasi_import where no_api = ? order by tgl_pib desc";
         $query4 = $this->db->query($sqldataapi,$noapi)->result();

        $data['title']              = "Laporan Api";
        
      //  $data['perizinan']  = $query;
        $data['data']           = $query2;
        $data['data_noapi'] = $query3;
        $data['data_api'] = $query4;
*/
$no_api = $this->input->post('nomorapi');
$jenis = $this->input->post('jenis');

         $fileName = time().$_FILES['file']['name'];
         
        $config['upload_path'] = './assets/excel_api/'; //buat folder dengan nama assets di root folder
        $config['file_name'] = $fileName;
        $config['allowed_types'] = 'xls|xlsx|csv';
        $config['max_size'] = 10000;
         
        $this->load->library('upload');
        $this->upload->initialize($config);
         
        if(! $this->upload->do_upload('file') )
        $this->upload->display_errors();
             
        $media = $this->upload->data('file');
        $inputFileName = './assets/excel_api/'.$media['file_name'];
         
        try {
                $inputFileType = IOFactory::identify($inputFileName);
                $objReader = IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch(Exception $e) {
                die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
            }
 
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
             
            for ($row = 2; $row <= $highestRow; $row++){                  //  Read a row of data into an array                 
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                                NULL,
                                                TRUE,
                                                FALSE);
        if($rowData[0][13] == null){$tgl_ls = '';}else{ $tgl_ls = date('Y-m-d',PHPExcel_Shared_Date::ExcelToPHP($rowData[0][13]));}
        if($rowData[0][15] == null){$tgl_pib = '';}else{ $tgl_pib =  date('Y-m-d',PHPExcel_Shared_Date::ExcelToPHP($rowData[0][15]));}                     
               
                   $data = array(
              
                    "no_api"=> $no_api,
                    "jenis_api"=> $jenis,
                    "uraian_barang"=> $rowData[0][0],
                    "hs10digit"=> $rowData[0][1],
                    "volume"=> $rowData[0][2],
                    "satuan"=> $rowData[0][3],
                    "harga_satuan"=> $rowData[0][4],
                   "nilai_cif"=> $rowData[0][5],
                    "nilai_cnf"=> $rowData[0][6],
                    "nilai_fob"=> $rowData[0][7],
                    "currency"=> $rowData[0][8],
                    "negara_asal"=> $rowData[0][9],
                    "pelabuhan_asal"=> $rowData[0][10],
                    "pelabuhan_tujuan"=> $rowData[0][11],
                    "nomor_ls"=> $rowData[0][12],
                     "tgl_ls"=>   $tgl_ls,
                    "nomor_pib"=> $rowData[0][14],
                    "tgl_pib" =>$tgl_pib,
                   // "flag"=> $rowData[0][19]
                    "flag"=> 'not'

                );
                 
                //sesuaikan nama dengan nama tabel
             $insert = $this->db->insert("api_realisasi_import",$data);
              //  delete_files($media['file_path']);

                     
            }
               $result = $insert;
           if($result=='0'){
            $data["msg"]="gagal";

        }else{
            $data["msg"]="sukses";
        }
          $this->load->vars($data);

           $username   = $this->session->userdata("username");
        $session        = $this->session->userdata("userlogin");
        
        if(empty($session)){
            redirect('main/login', 'refresh');
            die;
        }
        
    
        $query2 = $this->db->get_where('tm_pemohon', array('username' => $username,'status'=>'1'))->first_row();

         $sql = "select * from api_no_api where id_tmpemohon = (select id from tm_pemohon where username = ?)";
         $query3 = $this->db->query($sql,$username)->result();

foreach ($query3 as $key => $value) {
    $nomor = $value->no_api;
}
if($nomor == null){
$noapi = '';
}else{
$noapi = $nomor;    
}

         $sqldataapi = "select * from api_realisasi_import where no_api = ? order by tgl_pib desc";
         $query4 = $this->db->query($sqldataapi,$noapi)->result();

        $data['title']              = "Laporan Api";
         $data['load']           = "main/laporanapi/upload_api";
      //  $data['perizinan']  = $query;
        $data['data']           = $query2;
        $data['data_noapi'] = $query3;
        $data['data_api'] = $query4;
 $this->load->view('template_user',$data);
}

function saveapi(){
    $id = $this->input->post('id');
    $noapi = $this->input->post('no_api');
$data = array(
    'no_api' => $noapi, 
    'id_tmpemohon' =>  $id
    );
$hasil = $this->db->insert('api_no_api',$data);
if($hasil){
    redirect('main/laporanapiuser/dataapi');
}else{
     redirect('main/laporanapiuser/step1');
}
}
       

       function tambah_api_form(){
    

        $username   = $this->session->userdata("username");
        $session        = $this->session->userdata("userlogin");
        
        if(empty($session)){
            redirect('main/login', 'refresh');
            die;
        }
        
    
        $query2 = $this->db->get_where('tm_pemohon', array('username' => $username,'status'=>'1'))->first_row();

         $sql = "select * from api_no_api where id_tmpemohon = (select id from tm_pemohon where username = ?)";
         $query3 = $this->db->query($sql,$username)->result();

foreach ($query3 as $key => $value) {
    $nomor = $value->no_api;
}
if($nomor == null){
$noapi = '';
}else{
$noapi = $nomor;    
}

//$query_matauang  = $this->db->query("select * from api_mata_uang order by negara asc")->result();
$query_satuan  = $this->db->query("select * from api_satuan order by kode_satuan asc")->result();
$query_currency  = $this->db->query("select * from api_currency")->result();
$query_negara  = $this->db->query("select * from api_negara")->result();
$query_pelabuhan_asal  = $this->db->query("select * from api_pelabuhan_asal")->result();
$query_pelabuhan_tujuan  = $this->db->query("select * from api_pelabuhan_tujuan")->result();
         $sqldataapi = "select * from api_realisasi_import where no_api = ? order by tgl_pib desc";
         $query4 = $this->db->query($sqldataapi,$noapi)->result();

        $data['title']              = "Laporan Api";
        $data['load']           = "laporanapi/tambah_api_form";
        $data['matauang']  = $query_currency;
        $data['satuan'] = $query_satuan;
        $data['negara'] = $query_negara;
        $data['pelabuhan_asal'] = $query_pelabuhan_asal;
        $data['pelabuhan_tujuan'] = $query_pelabuhan_tujuan;
        $data['data']     = $query2;
        $data['data_noapi'] = $query3;
        $data['data_api'] = $query4;

        $this->load->view('template_user',$data);
} 
function save_dataapi(){
    
    $id = '';
    $no_api = $this->input->post('no_api');
    $jenis_api = $this->input->post('jenis_api');
    $uraian_barang = $this->input->post('uraian_barang');
    $hs10digit = $this->input->post('hs10digit');
    $volume = $this->input->post('volume');
    $satuan = $this->input->post('satuan');
    $harga_satuan = $this->input->post('harga_satuan');
    $nilai_cif = $this->input->post('nilai_cif');
    $nilai_cnf = $this->input->post('nilai_cnf');
    $nilai_fob = $this->input->post('nilai_fob');
   // $nilai_impor = $this->input->post('nilai_impor');
    $currency = $this->input->post('currency');
    //$kurs = $this->input->post('kurs');
    $negara_asal = $this->input->post('negara_asal');
    $pelabuhan_asal = $this->input->post('pelabuhan_asal');
    $pelabuhan_tujuan = $this->input->post('pelabuhan_tujuan');
    $nomor_ls = $this->input->post('nomor_ls');
    $tgl_ls = $this->input->post('tgl_ls');
    $nomor_pib = $this->input->post('nomor_pib');
    $tgl_pib = $this->input->post('tgl_pib');
    $flag = 'not';


$data = array(
    'id' => $id, 
    'no_api' => $no_api, 
    'jenis_api' => $jenis_api, 
    'uraian_barang' => $uraian_barang, 
    'hs10digit' => $hs10digit, 
    'volume' => $volume, 
    'satuan' => $satuan, 
    'harga_satuan' => $harga_satuan, 
    'nilai_cif' => $nilai_cif, 
    'nilai_cnf' => $nilai_cnf, 
    'nilai_fob' => $nilai_fob, 
    //'nilai_impor' => $nilai_impor, 
    'currency' => $currency, 
   // 'kurs' => $kurs, 
    'negara_asal' => $negara_asal,
    'pelabuhan_asal' => $pelabuhan_asal, 
    'pelabuhan_tujuan' => $pelabuhan_tujuan, 
    'nomor_ls' => $nomor_ls, 
    'tgl_ls' => $tgl_ls, 
    'nomor_pib' => $nomor_pib, 
    'tgl_pib' => $tgl_pib, 
    'flag' =>  $flag
    );


$hasil = $this->db->insert('api_realisasi_import',$data);

/*if($hasil){
    redirect('main/laporanapiuser/upload_api');
}else{
    // redirect('main/laporanapiuser/step1');
}*/
$result = $hasil;
           if($result=='0'){
            $data["msg"]="gagal api";

        }else{
            $data["msg"]="sukses api";
        }
          $this->load->vars($data);
          $data['load']           = "main/laporanapi/upload_api";
$this->load->view('template_user',$data);
}
function download_dataapi(){
    
        $username   = $this->session->userdata("username");
        $session    = $this->session->userdata("userlogin");
        $tgl1 = $this->input->post('tgl11');
        $tgl2 = $this->input->post('tgl22');
        
        if(empty($session)){
            redirect('main/login', 'refresh');
            die;
        }
        
       // $otherdb    = $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
        
        //$otherdb->order_by("urutan","asc");
      //  $query  = $otherdb->query("select * from trsektor")->result();
        $query2 = $this->db->get_where('tm_pemohon', array('username' => $username,'status'=>'1'))->first_row();

         $sql = "select * from api_no_api where id_tmpemohon = (select id from tm_pemohon where username = ?)";
         $query3 = $this->db->query($sql,$username)->result();

foreach ($query3 as $key => $value) {
    $nomor = $value->no_api;
}
if($nomor == null){
$noapi = '';
}else{
$noapi = $nomor;    
}
      //   $sqldataapi = "select * from api_realisasi_import where no_api = ? order by tgl_pib desc";
      //   $query4 = $this->db->query($sqldataapi,$noapi)->result();



 $this->db->where('no_api', $noapi);
 $this->db->where('tgl_pib >=', $tgl1);
 $this->db->where('tgl_pib <=', $tgl2);
 $this->db->where('flag', 'ok');
$query4 = $this->db->get('api_realisasi_import')->result();

        $data['title']              = "Laporan Api";
        $data['load']           = "laporanapi/download_dataapi";
      //  $data['perizinan']  = $query;
        $data['data']           = $query2;
        $data['data_noapi'] = $query3;
        $data['data_api'] = $query4;
        $data['tgl1'] = $tgl1;
        $data['tgl2'] = $tgl2;
        $this->load->view('laporanapi/download_dataapi',$data);
    
    }
    function download_dataapirevisi(){
    
        $username   = $this->session->userdata("username");
        $session    = $this->session->userdata("userlogin");
       // $tgl1 = $this->input->post('tgl11');
       // $tgl2 = $this->input->post('tgl22');
        
        if(empty($session)){
            redirect('main/login', 'refresh');
            die;
        }
        
       // $otherdb    = $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
        
        //$otherdb->order_by("urutan","asc");
      //  $query  = $otherdb->query("select * from trsektor")->result();
        $query2 = $this->db->get_where('tm_pemohon', array('username' => $username,'status'=>'1'))->first_row();

         $sql = "select * from api_no_api where id_tmpemohon = (select id from tm_pemohon where username = ?)";
         $query3 = $this->db->query($sql,$username)->result();

foreach ($query3 as $key => $value) {
    $nomor = $value->no_api;
}
if($nomor == null){
$noapi = '';
}else{
$noapi = $nomor;    
}
      //   $sqldataapi = "select * from api_realisasi_import where no_api = ? order by tgl_pib desc";
      //   $query4 = $this->db->query($sqldataapi,$noapi)->result();



 $this->db->where('no_api', $noapi);
// $this->db->where('tgl_pib >=', $tgl1);
// $this->db->where('tgl_pib <=', $tgl2);
 $this->db->where('flag', 'delete');
$query4 = $this->db->get('api_realisasi_import')->result();

        $data['title']              = "Laporan Api";
        $data['load']           = "laporanapi/download_dataapirevisi";
      //  $data['perizinan']  = $query;
        $data['data']           = $query2;
        $data['data_noapi'] = $query3;
        $data['data_api'] = $query4;
        //$data['tgl1'] = $tgl1;
       // $data['tgl2'] = $tgl2;
        $this->load->view('laporanapi/download_dataapirevisi',$data);
    
    }
    function download_dataapiall(){
    $data['tgl1'] = '';
        $data['tgl2'] = '';

        $username   = $this->session->userdata("username");
        $session        = $this->session->userdata("userlogin");
        
        if(empty($session)){
            redirect('main/login', 'refresh');
            die;
        }
        
       // $otherdb    = $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
        
        //$otherdb->order_by("urutan","asc");
      //  $query  = $otherdb->query("select * from trsektor")->result();
        $query2 = $this->db->get_where('tm_pemohon', array('username' => $username,'status'=>'1'))->first_row();

         $sql = "select * from api_no_api where id_tmpemohon = (select id from tm_pemohon where username = ?)";
         $query3 = $this->db->query($sql,$username)->result();

foreach ($query3 as $key => $value) {
    $nomor = $value->no_api;
}
if($nomor == null){
$noapi = '';
}else{
$noapi = $nomor;    
}

         $sqldataapi = "select * from api_realisasi_import where no_api = ? and flag = 'ok' order by tgl_pib desc";
         $query4 = $this->db->query($sqldataapi,$noapi)->result();

        $data['title']              = "Pesan Laporan API";
        $data['load']           = "laporanapi/download_dataapifull";
      //  $data['perizinan']  = $query;
        $data['data']           = $query2;
        $data['data_noapi'] = $query3;
        $data['data_api'] = $query4;

        $this->load->view('laporanapi/download_dataapifull',$data);          
    }
 function pesan(){
    
        $username   = $this->session->userdata("username");
        $session        = $this->session->userdata("userlogin");
        
        if(empty($session)){
            redirect('main/login', 'refresh');
            die;
        }
        
        $otherdb    = $this->load->database('otherdb', TRUE); 
        
        $otherdb->order_by("urutan","asc");
        $query2 = $this->db->get_where('tm_pemohon', array('username' => $username,'status'=>'1'))->first_row();

         $sql = "select * from api_no_api where id_tmpemohon = (select id from tm_pemohon where username = ?)";
         $query3 = $this->db->query($sql,$username)->result();

foreach ($query3 as $key => $value) {
    $nomor = $value->no_api;
    $id_tmpemohon = $value->id_tmpemohon;
}

         $sql2 = "select * from api_pesan where id_tmpemohon = ? order by id desc";
         $query4= $this->db->query($sql2,$id_tmpemohon)->result();
        
  $data = array (
            'status' => 'ok'
        );
        $this->db->where('id_tmpemohon', $id_tmpemohon);
        $this->db->where('status','belum');
        $this->db->update('api_pesan', $data);

        $data['title']              = "Pesan";
        $data['load']           = "laporanapi/pesan_api";
      //  $data['perizinan']  = $query;
        $data['data']           = $query2;
        $data['username'] = $username;
        $data['data_noapi'] = $query3;
        $data['data_pesan'] = $query4;
        $this->load->view('template_user',$data);
    
    }

     public function load_row($id_tmpemohon){     //fungsi load_row untuk menampilkan jlh data pada navbar secara realtime
        $this->load->model('mnotifikasi');
        echo $this->mnotifikasi->notif_count($id_tmpemohon); //jumlah data akan langsung di tampilkan
    }

    public function load_data($id_tmpemohon){    //fungsi load_data untuk menampilkan isi data pada navbar secara realtime
$this->load->model('mnotifikasi');
        $datas=$this->mnotifikasi->getnotifikasi($id_tmpemohon);
        $no=0;
        foreach($datas as $rdata){ $no++;
            if($no % 2==0){$cl='strip1';}
                    else{$cl='strip2';}
            echo"<li><a href=\"#\" class=\"".$cl."\">".$rdata->pesan."<br>
            <small>".$rdata->oleh." ".timeAgo($rdata->tanggal)."</small>
            </a><li>";
        }
    }

    function save_pesan(){
    
    
    $pesan = $this->input->post('pesan');
    $username = $this->input->post('username');
    $tanggal = date("Y-m-d H:i:s");
   $id_tmpemohon = $this->input->post('id_tmpemohon');


$data = array(
    'id' => '', 
    'tgl_pesan' => $tanggal, 
    'pesan' => $pesan, 
    'tanggal' => time(), 
    'oleh' => $username, 
    'id_tmpemohon' => $id_tmpemohon, 
    'status' => 'ok',
    'status_admin' => 'belum'
    );


$hasil = $this->db->insert('api_pesan',$data);
/*$result = $hasil;
           if($result=='0'){
            $data["msg"]="gagal api";

        }else{
            $data["msg"]="sukses api";
        }
          $this->load->vars($data);*/
     //     $data['load']           = "main/laporanapi/pesan_api";
 redirect('main/laporanapiuser/pesan', 'refresh');
}


function dataapi_ok(){
     $this->load->model('mnotifikasi');
        $data['tgl1'] = '';
        $data['tgl2'] = '';

        $username   = $this->session->userdata("username");
        $session        = $this->session->userdata("userlogin");
        
        if(empty($session)){
            redirect('main/login', 'refresh');
            die;
        }
        
       // $otherdb    = $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
        
        //$otherdb->order_by("urutan","asc");
      //  $query  = $otherdb->query("select * from trsektor")->result();
        $query2 = $this->db->get_where('tm_pemohon', array('username' => $username,'status'=>'1'))->first_row();

         $sql = "select * from api_no_api where id_tmpemohon = (select id from tm_pemohon where username = ?)";
         $query3 = $this->db->query($sql,$username)->result();

foreach ($query3 as $key => $value) {
    $nomor = $value->no_api;
    $id_tmpemohon = $value->id_tmpemohon;
}
if($nomor == null){
$noapi = '';
}else{
$noapi = $nomor;    
}

         $sqldataapi = "select * from api_realisasi_import where no_api = ? and flag='ok' order by tgl_pib desc";
        $query4 = $this->db->query($sqldataapi,$noapi)->result();

        $data['title']              = "Laporan Api";
        $data['load']           = "laporanapi/dataapi_ok";
      //  $data['perizinan']  = $query;
        $data['data']           = $query2;
        $data['data_noapi'] = $query3;
       $data['data_api'] = $query4;


        $data['jlhnotif'] =$this->mnotifikasi->notif_count($id_tmpemohon);  //menghitung jumlah post
        $data['notifikasi'] =$this->mnotifikasi->getnotifikasi($id_tmpemohon);


        $this->load->view('template_user',$data);
    
    }
function dataapi_not(){
     $this->load->model('mnotifikasi');
        $data['tgl1'] = '';
        $data['tgl2'] = '';

        $username   = $this->session->userdata("username");
        $session        = $this->session->userdata("userlogin");
        
        if(empty($session)){
            redirect('main/login', 'refresh');
            die;
        }
        
       // $otherdb    = $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
        
        //$otherdb->order_by("urutan","asc");
      //  $query  = $otherdb->query("select * from trsektor")->result();
        $query2 = $this->db->get_where('tm_pemohon', array('username' => $username,'status'=>'1'))->first_row();

         $sql = "select * from api_no_api where id_tmpemohon = (select id from tm_pemohon where username = ?)";
         $query3 = $this->db->query($sql,$username)->result();

foreach ($query3 as $key => $value) {
    $nomor = $value->no_api;
    $id_tmpemohon = $value->id_tmpemohon;
}
if($nomor == null){
$noapi = '';
}else{
$noapi = $nomor;    
}

         $sqldataapi = "select * from api_realisasi_import where no_api = ? and flag='not' order by tgl_pib desc";
        $query4 = $this->db->query($sqldataapi,$noapi)->result();

        $data['title']              = "Laporan Api";
        $data['load']           = "laporanapi/dataapi_not";
      //  $data['perizinan']  = $query;
        $data['data']           = $query2;
        $data['data_noapi'] = $query3;
       $data['data_api'] = $query4;


        $data['jlhnotif'] =$this->mnotifikasi->notif_count($id_tmpemohon);  //menghitung jumlah post
        $data['notifikasi'] =$this->mnotifikasi->getnotifikasi($id_tmpemohon);


        $this->load->view('template_user',$data);
    
    }
function dataapi_revisi(){

     $this->load->model('mnotifikasi');
        $data['tgl1'] = '';
        $data['tgl2'] = '';

        $username   = $this->session->userdata("username");
        $session        = $this->session->userdata("userlogin");
        
        if(empty($session)){
            redirect('main/login', 'refresh');
            die;
        }
        
       // $otherdb    = $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
        
        //$otherdb->order_by("urutan","asc");
      //  $query  = $otherdb->query("select * from trsektor")->result();
        $query2 = $this->db->get_where('tm_pemohon', array('username' => $username,'status'=>'1'))->first_row();

         $sql = "select * from api_no_api where id_tmpemohon = (select id from tm_pemohon where username = ?)";
         $query3 = $this->db->query($sql,$username)->result();

foreach ($query3 as $key => $value) {
    $nomor = $value->no_api;
    $id_tmpemohon = $value->id_tmpemohon;
}
if($nomor == null){
$noapi = '';
}else{
$noapi = $nomor;    
}

         $sqldataapi = "select * from api_realisasi_import where no_api = ? and flag='revisi' order by tgl_pib desc";
        $query4 = $this->db->query($sqldataapi,$noapi)->result();

        $data['title']              = "Laporan Api";
        $data['load']           = "laporanapi/dataapi_revisi";
      //  $data['perizinan']  = $query;
        $data['data']           = $query2;
        $data['data_noapi'] = $query3;
       $data['data_api'] = $query4;


        $data['jlhnotif'] =$this->mnotifikasi->notif_count($id_tmpemohon);  //menghitung jumlah post
        $data['notifikasi'] =$this->mnotifikasi->getnotifikasi($id_tmpemohon);


        $this->load->view('template_user',$data);
    
    }


function dataapi_revisi2(){

     $this->load->model('mnotifikasi');
        $data['tgl1'] = '';
        $data['tgl2'] = '';

        $username   = $this->session->userdata("username");
        $session        = $this->session->userdata("userlogin");
        
        if(empty($session)){
            redirect('main/login', 'refresh');
            die;
        }
        
       // $otherdb    = $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
        
        //$otherdb->order_by("urutan","asc");
      //  $query  = $otherdb->query("select * from trsektor")->result();
        $query2 = $this->db->get_where('tm_pemohon', array('username' => $username,'status'=>'1'))->first_row();

         $sql = "select * from api_no_api where id_tmpemohon = (select id from tm_pemohon where username = ?)";
         $query3 = $this->db->query($sql,$username)->result();

foreach ($query3 as $key => $value) {
    $nomor = $value->no_api;
    $id_tmpemohon = $value->id_tmpemohon;
}
if($nomor == null){
$noapi = '';
}else{
$noapi = $nomor;    
}
$query_satuan  = $this->db->query("select * from api_satuan order by kode_satuan asc")->result();
         $sqldataapi = "select * from api_realisasi_import where no_api = ? and flag='revisi' order by tgl_pib desc limit 200";
        $query4 = $this->db->query($sqldataapi,$noapi)->result();

        $query_negara  = $this->db->query("select * from api_negara")->result();
        $query_pelabuhan_asal  = $this->db->query("select * from api_pelabuhan_asal")->result();
        $query_pelabuhan_tujuan  = $this->db->query("select * from api_pelabuhan_tujuan")->result();
        $query_currency  = $this->db->query("select * from api_currency")->result();

        $data['title']              = "Laporan Api";
        $data['load']           = "laporanapi/dataapi_revisi2";
      //  $data['perizinan']  = $query;
        $data['data']           = $query2;
        $data['data_noapi'] = $query3;
        $data['data_api'] = $query4;
        $data['data_negara'] = $query_negara;
        $data['matauang'] = $query_currency;
        $data['data_pelabuhan_asal'] = $query_pelabuhan_asal;
        $data['data_pelabuhan_tujuan'] = $query_pelabuhan_tujuan;
        $data['data_satuan'] = $query_satuan;
        $data['jlhnotif'] =$this->mnotifikasi->notif_count($id_tmpemohon);  //menghitung jumlah post
        $data['notifikasi'] =$this->mnotifikasi->getnotifikasi($id_tmpemohon);


        $this->load->view('template_user',$data);
    
    }

    function update_multiple() {
/*
$update = $this->input->post('msg');
$jenis_api = $this->input->post('jenis_api');
$uraian_barang = $this->input->post('uraian_barang');
$hs10digit = $this->input->post('hs10digit');
$volume = $this->input->post('volume');
$satuan = $this->input->post('satuan');
$harga_satuan = $this->input->post('harga_satuan');
$nilai_cif = $this->input->post('nilai_cif');
$nilai_cnf = $this->input->post('nilai_cnf');
$nilai_fob = $this->input->post('nilai_fob');
$currency = $this->input->post('currency');
$negara_asal = $this->input->post('negara_asal');
$pelabuhan_asal = $this->input->post('pelabuhan_asal');
$pelabuhan_tujuan = $this->input->post('pelabuhan_tujuan');
$nomor_ls = $this->input->post('nomor_ls');
$tgl_ls = $this->input->post('tgl_ls');
$nomor_pib = $this->input->post('nomor_pib');
$tgl_pib = $this->input->post('tgl_pib');

        for ($i=0; $i < count($update) ; $i++) { 
                     
                    $data = array(
                        'jenis_api'=>$jenis_api[$i],
                        'uraian_barang'=>$uraian_barang[$i],
                        'hs10digit'=>$hs10digit[$i],
                        'volume'=>$volume[$i],
                        'satuan'=>$satuan[$i],
                        'harga_satuan'=>$harga_satuan[$i],
                        'nilai_cif'=>$nilai_cif[$i],
                        'nilai_cnf'=>$nilai_cnf[$i],
                        'nilai_fob'=>$nilai_fob[$i],
                        'currency'=>$currency[$i],
                        'negara_asal'=>$negara_asal[$i],
                        'pelabuhan_asal'=>$pelabuhan_asal[$i],
                        'pelabuhan_tujuan'=>$pelabuhan_tujuan[$i],
                        'nomor_ls'=>$nomor_ls[$i],
                        'tgl_ls'=>$tgl_ls[$i],
                        'nomor_pib'=>$nomor_pib[$i],
                        'tgl_pib'=>$tgl_pib[$i]//,
                       // 'flag'=>'not'
                    ); 
               
                $this->db->where('id', $update[$i]);
                $this->db->update('api_realisasi_import',$data);

        }*/

            $this->load->model('mrevisi');
            $this->mrevisi->update_revisi();

            redirect('main/laporanapiuser/dataapi_revisi2');
    }

}