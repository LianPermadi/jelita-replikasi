<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Backup dan restore database
 *
 * @author Muhammad Rizky 
 * 
 */
class Log_backup extends WRC_AdminCont {

    public function __construct() {
        parent::__construct();
        $this->permohonan = new tmpermohonan();
        $this->perizinan = new trperizinan();
		$this->load->model('dbmodel_bisbesar');

        $enabled = FALSE;
        $list_auths = $this->session_info['app_list_auth'];
        $this->realisasi = NULL;

        foreach ($list_auths as $list_auth) {
            if($list_auth->id_role === '6') {
                $enabled = TRUE;
                $this->realisasi = new user_auth();
            }
        }

        if(!$enabled) {
            redirect('dashboard');
        }
        }

    public function index()
    {
         $data['save_method'] = "save";
         $js = "
                $(document).ready(function() {
                    $('#form').validate();
                    $(\"#tabs\").tabs();
                    $('a[rel*=detail]').facebox();
                } );
            ";
        $this->template->set_metadata_javascript($js);
        $this->load->vars($data);
        $this->session_info['page_name'] = "Restore Database";
        $this->template->build('edit_restore', $this->session_info);
    }

    public function save(){
/*		$a = intval($this->input->post('mulai'));
		$a1 = $a-100;
		for ($i = $a; $i <= 101879; $i++) {    // 110000
            $d_list_data = "select pendaftaran_id, dt_teknis1, dt_teknis2, dt_teknis3, dt_teknis4, dt_teknis5, dt_teknis6, dt_teknis7, dt_teknis8, dt_teknis9, dt_teknis10,                       dt_teknis11, dt_teknis12, dt_teknis13, dt_teknis14, dt_teknis15, dt_teknis16, dt_teknis17, dt_teknis18, dt_teknis19, dt_teknis20, 
			                dt_teknis21, dt_teknis22, dt_teknis23, dt_teknis24, dt_teknis25, dt_teknis26, dt_teknis27, dt_teknis28, dt_teknis29, dt_teknis30,
							dt_teknis31, dt_teknis32, dt_teknis33, dt_teknis34, dt_teknis35, dt_teknis36, dt_teknis37, dt_teknis38, dt_teknis39, dt_teknis40, 
							dt_teknis41, dt_teknis42, dt_teknis43, dt_teknis44, dt_teknis45, dt_teknis46, dt_teknis47, dt_teknis48, dt_teknis49, dt_teknis50, 
							dt_teknis51, dt_teknis52, dt_teknis53, dt_teknis54, dt_teknis55, dt_teknis56, dt_teknis57, dt_teknis58, dt_teknis59, dt_teknis60, 
							dt_teknis61, dt_teknis62, dt_teknis63, dt_teknis64, dt_teknis65, dt_teknis66, dt_teknis67, dt_teknis68, dt_teknis69, dt_teknis70, 
							dt_teknis71, dt_teknis72, dt_teknis73, dt_teknis74, dt_teknis75, dt_teknis76, dt_teknis77, dt_teknis78, dt_teknis79, dt_teknis80, 
							dt_teknis81, dt_teknis82, dt_teknis83, dt_teknis84, dt_teknis85, dt_teknis86, dt_teknis87, dt_teknis88, dt_teknis89, dt_teknis90, 
							dt_teknis91, dt_teknis92, dt_teknis93, dt_teknis94, dt_teknis95, dt_teknis96, dt_teknis97, dt_teknis98, dt_teknis99, dt_teknis100
			                from tmpermohonan where id = ".$i;
            $list_data = $this->dbmodel_bisbesar->db_sql($d_list_data);
    		foreach ($list_data as $data) {
			    $permohonan = new tmpermohonan();
                $permohonan->where('pendaftaran_id', $data->pendaftaran_id)->where('id', $i)->get();
        		if($permohonan->pendaftaran_id){
					if($permohonan->id == $i && str_replace(' ','',$permohonan->dt_teknis1) == str_replace(' ','','B7048UN^2017-01-16')){
						echo' masuk lalu '.str_replace(' ','',$permohonan->dt_teknis1).' = '.str_replace(' ','','B7048UN^2017-01-16'); 
                            $permohonan->dt_teknis1  = $data->dt_teknis1;
							$permohonan->dt_teknis2  = $data->dt_teknis2;
							$permohonan->dt_teknis3  = $data->dt_teknis3;
							$permohonan->dt_teknis4  = $data->dt_teknis4;
							$permohonan->dt_teknis5  = $data->dt_teknis5;
							$permohonan->dt_teknis6  = $data->dt_teknis6;
							$permohonan->dt_teknis7  = $data->dt_teknis7;
							$permohonan->dt_teknis8  = $data->dt_teknis8;
							$permohonan->dt_teknis9  = $data->dt_teknis9;
							$permohonan->dt_teknis10 = $data->dt_teknis10;
							$permohonan->dt_teknis11 = $data->dt_teknis11;
							$permohonan->dt_teknis12 = $data->dt_teknis12;
							$permohonan->dt_teknis13 = $data->dt_teknis13;
							$permohonan->dt_teknis14 = $data->dt_teknis14;
							$permohonan->dt_teknis15 = $data->dt_teknis15;
							$permohonan->dt_teknis16 = $data->dt_teknis16;
							$permohonan->dt_teknis17 = $data->dt_teknis17;
							$permohonan->dt_teknis18 = $data->dt_teknis18;
							$permohonan->dt_teknis19 = $data->dt_teknis19;
							$permohonan->dt_teknis20 = $data->dt_teknis20;
							$permohonan->dt_teknis21 = $data->dt_teknis21;
							$permohonan->dt_teknis22 = $data->dt_teknis22;
							$permohonan->dt_teknis23 = $data->dt_teknis23;
							$permohonan->dt_teknis24 = $data->dt_teknis24;
							$permohonan->dt_teknis25 = $data->dt_teknis25;
							$permohonan->dt_teknis26 = $data->dt_teknis26;
							$permohonan->dt_teknis27 = $data->dt_teknis27;
							$permohonan->dt_teknis28 = $data->dt_teknis28;
							$permohonan->dt_teknis29 = $data->dt_teknis29;
							$permohonan->dt_teknis30 = $data->dt_teknis30;
							$permohonan->dt_teknis31 = $data->dt_teknis31;
							$permohonan->dt_teknis32 = $data->dt_teknis32;
							$permohonan->dt_teknis33 = $data->dt_teknis33;
							$permohonan->dt_teknis34 = $data->dt_teknis34;
							$permohonan->dt_teknis35 = $data->dt_teknis35;
							$permohonan->dt_teknis36 = $data->dt_teknis36;
							$permohonan->dt_teknis37 = $data->dt_teknis37;
							$permohonan->dt_teknis38 = $data->dt_teknis38;
							$permohonan->dt_teknis39 = $data->dt_teknis39;
							$permohonan->dt_teknis40 = $data->dt_teknis40;
							$permohonan->dt_teknis41 = $data->dt_teknis41;
							$permohonan->dt_teknis42 = $data->dt_teknis42;
							$permohonan->dt_teknis43 = $data->dt_teknis43;
							$permohonan->dt_teknis44 = $data->dt_teknis44;
							$permohonan->dt_teknis45 = $data->dt_teknis45;
							$permohonan->dt_teknis46 = $data->dt_teknis46;
							$permohonan->dt_teknis47 = $data->dt_teknis47;
							$permohonan->dt_teknis48 = $data->dt_teknis48;
							$permohonan->dt_teknis49 = $data->dt_teknis49;
							$permohonan->dt_teknis50 = $data->dt_teknis50;
							$permohonan->dt_teknis51 = $data->dt_teknis51;
							$permohonan->dt_teknis52 = $data->dt_teknis52;
							$permohonan->dt_teknis53 = $data->dt_teknis53;
							$permohonan->dt_teknis54 = $data->dt_teknis54;
							$permohonan->dt_teknis55 = $data->dt_teknis55;
							$permohonan->dt_teknis56 = $data->dt_teknis56;
							$permohonan->dt_teknis57 = $data->dt_teknis57;
							$permohonan->dt_teknis58 = $data->dt_teknis58;
							$permohonan->dt_teknis59 = $data->dt_teknis59;
							$permohonan->dt_teknis60 = $data->dt_teknis60;
							$permohonan->dt_teknis61 = $data->dt_teknis61;
							$permohonan->dt_teknis62 = $data->dt_teknis62;
							$permohonan->dt_teknis63 = $data->dt_teknis63;
							$permohonan->dt_teknis64 = $data->dt_teknis64;
							$permohonan->dt_teknis65 = $data->dt_teknis65;
							$permohonan->dt_teknis66 = $data->dt_teknis66;
							$permohonan->dt_teknis67 = $data->dt_teknis67;
							$permohonan->dt_teknis68 = $data->dt_teknis68;
							$permohonan->dt_teknis69 = $data->dt_teknis69;
							$permohonan->dt_teknis70 = $data->dt_teknis70;
							$permohonan->dt_teknis71 = $data->dt_teknis71;
							$permohonan->dt_teknis72 = $data->dt_teknis72;
							$permohonan->dt_teknis73 = $data->dt_teknis73;
							$permohonan->dt_teknis74 = $data->dt_teknis74;
							$permohonan->dt_teknis75 = $data->dt_teknis75;
							$permohonan->dt_teknis76 = $data->dt_teknis76;
							$permohonan->dt_teknis77 = $data->dt_teknis77;
							$permohonan->dt_teknis78 = $data->dt_teknis78;
							$permohonan->dt_teknis79 = $data->dt_teknis79;
							$permohonan->dt_teknis80 = $data->dt_teknis80;
							$permohonan->dt_teknis81 = $data->dt_teknis81;
							$permohonan->dt_teknis82 = $data->dt_teknis82;
							$permohonan->dt_teknis83 = $data->dt_teknis83;
							$permohonan->dt_teknis84 = $data->dt_teknis84;
							$permohonan->dt_teknis85 = $data->dt_teknis85;
							$permohonan->dt_teknis86 = $data->dt_teknis86;
							$permohonan->dt_teknis87 = $data->dt_teknis87;
							$permohonan->dt_teknis88 = $data->dt_teknis88;
							$permohonan->dt_teknis89 = $data->dt_teknis89;
							$permohonan->dt_teknis90 = $data->dt_teknis90;
							$permohonan->dt_teknis91 = $data->dt_teknis91;
							$permohonan->dt_teknis92 = $data->dt_teknis92;
							$permohonan->dt_teknis93 = $data->dt_teknis93;
							$permohonan->dt_teknis94 = $data->dt_teknis94;
							$permohonan->dt_teknis95 = $data->dt_teknis95;
							$permohonan->dt_teknis96 = $data->dt_teknis96;
							$permohonan->dt_teknis97 = $data->dt_teknis97;
							$permohonan->dt_teknis98 = $data->dt_teknis98;
							$permohonan->dt_teknis99 = $data->dt_teknis99;
							$permohonan->dt_teknis100 = $data->dt_teknis100;
							$permohonan->save();
						}
		            }
			}
		}
		//echo 'OKE';die;
*/
        $this->load->helper('file');
          if (!empty($_FILES['file']['name'])) {
            $config['upload_path'] = './uploads/database/';
            $config['allowed_types'] = 'zip';
            $config['max_size'] = '1000';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $field = 'file';
            if (!$this->upload->do_upload($field)) {
                $this->session->set_flashdata('pesan', $this->upload->display_errors());
                redirect('log/log_backup');
            } else {
                $filename = $_FILES['file']['name'];
                $this->restore($filename);
                delete_files('uploads/database/',$filename);
                $this->session->set_flashdata('pesan', 'Database Berhasil Disimpan!');
                redirect('log/log_backup');
            }
        }
    }


    public function backup() {

        $tanggal = date("Y-m-d");
        $nama = $_SESSION['my_db'].'.zip';
        $this->load->dbutil();
        $this->load->helper('download');
        $tabel = array( 'ignore'      => array('inbox','outbox','phones','sentitems'),   
                        'add_drop'    => TRUE,
                        'add_insert'  => TRUE
                        );
        $backup=& $this->dbutil->backup($tabel);
        force_download($nama,$backup);
        
    }
    
  
    public function restore($filename)
    {

        
//      $filename = $_FILES['file']['name'];
//        $query3 = "drop database something";
//        $sql3 = $this->db->query($query3);
//
//        $query1 = "create database something_2";
//        $sql1 = $this->db->query($query1);
//
//        $query2 = "use something_2";
//        $sql2 = $this->db->query($query2);
       
    $dosya ="uploads/database/".$filename;
    $veri = gzfile($dosya);
        foreach($veri as $i => $v)
        {
            if(substr($v, 0 ,1) == '#' || trim($v) == '') unset($veri[$i]);
        }
    $yeni = explode(";\n", implode("\n", $veri));

    foreach($yeni as $sql)
    {
    if(trim($sql) != '')
        {
        $s = $this->db->query(trim($sql));
        delete_files('uploads/database/',$filename);
         //echo "<script>window.location = '".base_url()."log/log_backup';</script>";
        }
               
    }
        
//        redirect('log/log_backup');
       

    }


}
