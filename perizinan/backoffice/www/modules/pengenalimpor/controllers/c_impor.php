<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 *  @author  R; 
 */

class C_impor extends WRC_AdminCont {

    public function __construct() {
        parent::__construct();
       $this->load->model("m_import");
        $this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
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


//-----------------------------------------------tampil data ---------------------
    public function index() {
        //$data['content_view'] = 'izintrayek/v_izintrayek';
      //  $data['izintrayek_table'] = $this->create_izintrayek_table();
      // $this->load->vars($data);





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
        $this->session_info['page_name'] = "ANGKA PENGENAL IMPORT (API)";
        //$this->template->build('v_import', $this->session_info);
        $this->template->build('v_upload_api', $this->session_info);
    }

     function apip() {
        //$data['content_view'] = 'izintrayek/v_izintrayek';
       // $data['izintrayek_table'] = $this->create_izintrayek_table();
       // $this->load->vars($data);

        $js =  "function confirm_link(text){
                    if(confirm(text)){ return true;
                    }else{ return false; }
                }
                $(document).ready(function() {
                        oTable = $('#apip').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );
                ";

        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "ANGKA PENGENAL IMPORT PRODUSEN(API-P)";
        $this->template->build('v_import_apip', $this->session_info);
    }
      function apiu() {
        //$data['content_view'] = 'izintrayek/v_izintrayek';
       // $data['izintrayek_table'] = $this->create_izintrayek_table();
       // $this->load->vars($data);

        $js =  "function confirm_link(text){
                    if(confirm(text)){ return true;
                    }else{ return false; }
                }
                $(document).ready(function() {
                        oTable = $('#apip').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );
                ";

        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "ANGKA PENGENAL IMPORT UMUM(API-U)";
        $this->template->build('v_import_apiu', $this->session_info);
    }

     public function upload(){

  //$NO_API = $this->input->post('NO_API');

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
                                                 
                //Sesuaikan sama nama kolom tabel di database                                
             /*     $data = array(
                    "idimport"=> $rowData[0][0],
                  //  "nama" => $NO_API,
                   "nama"=> $rowData[0][1],
                    "alamat"=> $rowData[0][2],
                    "kontak"=> $rowData[0][3]
                );*/
                
               //tanggal sekarang  $date1 =date('Y-m-d',PHPExcel_Shared_Date::ExcelToPHP($sheet -> getCellByColumnAndRow(0,19)->getValue()));
                   $data = array(
                   // "id"=> $rowData[0][0],
                 //  "id"=> '',
                    "no_api"=> $rowData[0][0],
                    "jenis_api"=> $rowData[0][1],
                    "uraian_barang"=> $rowData[0][2],
                    "hs10digit"=> $rowData[0][3],
                    "volume"=> $rowData[0][4],
                    "satuan"=> $rowData[0][5],
                    "harga_satuan"=> $rowData[0][6],
                   "nilai_cif"=> $rowData[0][7],
                    "nilai_cnf"=> $rowData[0][8],
                    "nilai_fob"=> $rowData[0][9],
                    "nilai_impor"=> $rowData[0][10],
                    "currency"=> $rowData[0][11],
                    "kurs"=> $rowData[0][12],
                    "negara_asal"=> $rowData[0][13],
                    "pelabuhan_tujuan"=> $rowData[0][14],
                    "nomor_ls"=> $rowData[0][15],
                     "tgl_ls"=> date('Y-m-d',PHPExcel_Shared_Date::ExcelToPHP($rowData[0][16])),
                    "nomor_pib"=> $rowData[0][17],
                    "tgl_pib" => date('Y-m-d',PHPExcel_Shared_Date::ExcelToPHP($rowData[0][18])),
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
      //  redirect('pengenalimpor/c_impor/success');
          $this->session_info['page_name'] = "ANGKA PENGENAL IMPORT";
          $this->template->build('v_import', $this->session_info);

    }
public function approve()
    {
        //$iduser = $this->input->post('id');
       
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
      //  $this->load->view('v_import', $data);
    }

}