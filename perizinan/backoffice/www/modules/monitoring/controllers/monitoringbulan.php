<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of monitoring class
 *
 * @author  Yogi Cahyana & zulfah
 * @since   1.0
 *
 */
class Monitoringbulan extends WRC_AdminCont {

    public function __construct() {
        parent::__construct();

        $this->pemohon = new tmpemohon();
        $this->permohonan = new tmpermohonan();
        $this->perijinan = new trperizinan();

        $enabled = FALSE;
        $list_auths = $this->session_info['app_list_auth'];
        $this->monitoringbulan = NULL;

        foreach ($list_auths as $list_auth) {
            if ($list_auth->id_role === '20') {     // khusus Mencetak old 2
                $enabled = TRUE;
                $this->monitoringbulan = new user_auth();
            }
        }

        if (!$enabled) {
            redirect('dashboard');
        }
    }

    public function index() {

        $data['listpemohon'] = $this->pemohon->limit(0)->get();
        $data['listpermohonan'] = $this->permohonan->limit(0)->get();
        $data['list_ijin'] = $this->perijinan->order_by('id', 'ASC')->get();

        $this->load->vars($data);

        $js = "
                $(document).ready(function() {
                        oTable = $('#monitoring').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );

                $(function() {
                $(\".monbulan\").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: 'yy-mm-dd',
                    closeText: 'X'
                });
            });
                ";

        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "Monitoring Per Bulan Masuk";
        $this->template->build('listbulan', $this->session_info);
    }

    public function cetak_monitoring_bulan($gerai = null, $tgla = null, $tglb = null) {
		$username = new user();
        $username->where('username', $this->session->userdata('username'))->get();
		$gerai1 = str_replace('_', ' ', $gerai);
		
        $this->settings = new settings();
        $this->settings->where('name', 'app_folder')->get();
        $app_folder = $this->settings->value . "/";
        $app_city = $this->settings->where('name', 'app_city')->get();

        $permohonan = new tmpermohonan();
        
        $p_kelurahan = $permohonan->tmpemohon->trkelurahan->get();
        $p_kecamatan = $permohonan->tmpemohon->trkelurahan->trkecamatan->get();
        $p_kabupaten = $permohonan->tmpemohon->trkelurahan->trkecamatan->trkabupaten->get();

        //path of the template file
        $nama_surat = "cetak_monitoring_bulan_generic";
		$nama_file = "monitoring_bulan";
        $this->load->plugin('odf');
        $odf = new odf('assets/odt/' . $nama_surat . '.odt');
//        $odf->setImage('header', 'assets/css/' . $app_folder . '/images/dinas_1.jpg', '17.5', '3.5');

        //logo
        $this->tr_instansi = new Tr_instansi();
        $logo = $this->tr_instansi->get_by_id(23);
        if($logo->value!=="")
            {
			  $odf->setImage('logo', 'uploads/logo/' . $logo->value, '2.1', '2.5');
		    }
         else
            {
              $odf->setVars('logo', ' ');
            }

		//pemerintah 
        $this->tr_instansi = new Tr_instansi();
        $nama_prov = $this->tr_instansi->get_by_id(17);
		$odf->setVars('provinsi', strtoupper($nama_prov->value));

        //badan
        $this->tr_instansi = new Tr_instansi();
        $nama_bdan = $this->tr_instansi->get_by_id(9);
        $odf->setVars('badan', strtoupper($nama_bdan->value));

        //telpon
        $this->tr_instansi = new Tr_instansi();
        $n_tlp = $this->tr_instansi->get_by_id(10);
        $odf->setVars('tlp', $n_tlp->value);

        //fax
        $this->tr_instansi = new Tr_instansi();
        $n_fax = $this->tr_instansi->get_by_id(13);
        $odf->setVars('fax', $n_fax->value);

        //alamat
        $this->tr_instansi = new Tr_instansi();
        $n_alamat = $this->tr_instansi->get_by_id(12);
        $odf->setVars('alamat', $n_alamat->value);

        //web
        $this->tr_instansi = new Tr_instansi();
        $web = $this->tr_instansi->get_by_id(21);
        $odf->setVars('website', $web->value);

		//e-mail
        $this->tr_instansi = new Tr_instansi();
        $e_mail = $this->tr_instansi->get_by_id(22);
        $odf->setVars('email', $e_mail->value);

        //Kop Kota
        $this->tr_instansi = new Tr_instansi();
        $kop_kota = $this->tr_instansi->get_by_id(19);
//        $odf->setVars('k_kota', $kop_kota->value);
		$odf->setVars('k_kota_besar', strtoupper($kop_kota->value));

        //Kode Pos
        $this->tr_instansi = new Tr_instansi();
        $kode_pos = $this->tr_instansi->get_by_id(20);
        $odf->setVars('kd_pos', $kode_pos->value);
        //membuat kota
        $wilayah = new trkabupaten();
        if ($app_city->value !== '0') {
            $alamat = $permohonan->tmpemohon->a_pemohon . ' ' . $p_kelurahan->n_kelurahan . ', ' .
                    $p_kecamatan->n_kecamatan . ', ' . ucwords(strtolower($p_kabupaten->n_kabupaten));
            $wilayah->get_by_id($app_city->value);
            //$odf->setVars('kabupaten', ucwords(strtolower($wilayah->n_kabupaten)));
           // $odf->setVars('kota', ucwords(strtolower($wilayah->ibukota)));
        } else {
            $alamat = $permohonan->tmpemohon->a_pemohon;
            //$odf->setVars('kabupaten', 'setempat');
           // $odf->setVars('kota', '...........');
        }
//
         $gede_kota=strtoupper($wilayah->n_kabupaten);
        $kecil_kota=ucwords(strtolower($wilayah->n_kabupaten));
       // $odf->setVars('kota4', $gede_kota);

        //alamat
       // $this->tr_instansi = new Tr_instansi();
       // $alamat = $this->tr_instansi->get_by_id(12);
       // $odf->setVars('alamat', ucwords(strtolower($alamat->value)).' - '.$kecil_kota);
        
        $nkota = "TASIKMALAYA";
		$cek_cetak = "0";
        //	Khusus Untuk linux 
        if ($gerai == 'Pusat') { $gerai = 'Pusat';} // Untuk daerah lain
		if ($gerai == 'BPPT_Prov__tasikmalaya'){ $gerai = 'BPPT Prov. tasikmalaya';}
		if ($gerai == 'BPMPT_Prov__tasikmalaya'){ $gerai = 'BPMPT Prov. tasikmalaya';}
		if ($gerai == 'DPMPTSP_Prov__tasikmalaya'){ $gerai = 'DPMPTSP Prov. tasikmalaya';}
		if ($gerai == 'Gerai_Bogor'){ $gerai = "Gerai Bogor";}
		if ($gerai == 'Gerai_Purwakarta'){ $gerai = 'Gerai Purwakarta';}
		if ($gerai == 'Gerai_Garut'){ $gerai = "Gerai Garut";}
		if ($gerai == 'Gerai_Cirebon'){ $gerai = "Gerai Cirebon";}
		if ($gerai == 'SMS'){ $gerai = "SMS";}
		if ($gerai == 'Surat'){ $gerai = "Surat";}
		if ($gerai == 'OnLine'){ $gerai = "OnLine";}
		//	Khusus Untuk linux EOF()

		if ($gerai == 'Pusat')             { $cek_cetak = "1"; $nkota = "SUMEDANG";}
		if ($gerai == 'BPPT Prov. tasikmalaya')  { $cek_cetak = "1"; $nkota = "TASIKMALAYA";}
		if ($gerai == 'BPMPT Prov. tasikmalaya') { $cek_cetak = "1"; $nkota = "TASIKMALAYA";}
		if ($gerai == 'DPMPTSP Prov. tasikmalaya') { $cek_cetak = "1"; $nkota = "TASIKMALAYA";}
		if ($gerai == 'Gerai Bogor')       { $cek_cetak = "1"; $nkota = "BOGOR";}
		if ($gerai == 'Gerai Purwakarta')  { $cek_cetak = "1"; $nkota = "PURWAKARTA";}
		if ($gerai == 'Gerai Garut')       { $cek_cetak = "1"; $nkota = "GARUT";}
		if ($gerai == 'Gerai Cirebon')     { $cek_cetak = "1"; $nkota = "CIREBON";}
		if ($gerai == 'SMS')               { $cek_cetak = "1"; $nkota = "TASIKMALAYA";}
		if ($gerai == 'Surat')             { $cek_cetak = "1"; $nkota = "TASIKMALAYA";}
		if ($gerai == 'OnLine')            { $cek_cetak = "1"; $nkota = "OnLine";}

        $odf->setVars('tanggal', $this->lib_date->mysql_to_human(date('Y/m/d')));
        $odf->setVars('title', 'Monitoring per Jangka Waktu');
        $odf->setVars('periode_awal',$this->lib_date->mysql_to_human($tgla));
        $odf->setVars('periode_akhir',$this->lib_date->mysql_to_human($tglb));
		$odf->setVars('k_kota_cetak',$nkota);

        $i = 1;
//echo 'Masuk'; die;        
//        $data['listpemohon'] = $this->pemohon->get();  // salah di posisi in
		if ($cek_cetak === "0") {
			$listpermohonan = $this->permohonan->where_related("trstspermohonan",'id <> 1')->where("d_terima_berkas >= '$tgla' AND d_terima_berkas <= '$tglb'")->get();
        } else {
			$listpermohonan = $this->permohonan->where_related("trstspermohonan",'id <> 1')->where("kd_gerai = '$gerai' AND d_terima_berkas >= '$tgla' AND d_terima_berkas <= '$tglb'")->get();
		}

        $odf->setVars('judul2', "");
		if ($this->permohonan->id) {
            foreach ($listpermohonan as $data) {
                $data->tmpemohon->get();
                $data->trperizinan->get();
                $data->trstspermohonan->get();
                $data->tmpemohon->trkelurahan->get();
				$data->tmperusahaan->get();

                if($data->tmperusahaan->n_perusahaan == '')
	                $ntext = $data->tmpemohon->n_pemohon;
                else
                    $ntext = $data->tmpemohon->n_pemohon.' / '.$data->tmperusahaan->n_perusahaan;
                $listeArticles3 = array(
                    array('property' => $i,
                        'content1' => $data->pendaftaran_id, //$data->n_perizinan,
                        'content2' => $data->trperizinan->n_perizinan,
                        'content3' => $this->lib_date->mysql_to_human($data->d_terima_berkas),
                        'content4' => $ntext,
                        'content5' => $data->trstspermohonan->n_sts_permohonan,
                        'content6' => $data->a_izin,
                        'content7' => $data->kd_gerai,
                   //     'content7' => $data->tmpemohon->trkelurahan->n_kelurahan,
                    ),
                );

                $article3 = $odf->setSegment('articles3');
                foreach ($listeArticles3 AS $element) {

                    $article3->titreArticle3($element['property']);
                    $article3->texteArticle3($element['content1']);
                    $article3->texteArticle4($element['content2']);
                    $article3->texteArticle5($element['content3']);
                    $article3->texteArticle6($element['content4']);
                    $article3->texteArticle7($element['content5']);
                    $article3->texteArticle8($element['content6']);
                    $article3->texteArticle9($element['content7']);
                    $article3->merge();
                }

                $i++;
            }
        } else {
            $listeArticles3 = array(
                array('property' => '',
                    'content1' => '', //$data->n_perizinan,
                    'content2' => '',
                    'content3' => '',
                    'content4' => '',
                    'content5' => '',
                    'content6' => '',
                    'content7' => '',
                ),
            );

            $article3 = $odf->setSegment('articles3');
            foreach ($listeArticles3 AS $element) {

                $article3->titreArticle3($element['property']);
                $article3->texteArticle3($element['content1']);
                $article3->texteArticle4($element['content2']);
                $article3->texteArticle5($element['content3']);
                $article3->texteArticle6($element['content4']);
                $article3->texteArticle7($element['content5']);
                $article3->texteArticle8($element['content6']);
                $article3->texteArticle9($element['content7']);
                $article3->merge();
            }
        }
        $odf->mergeSegment($article3);

        //export the file
        $no_daftar = str_replace('/', '', $permohonan->pendaftaran_id);
        $odf->exportAsAttachedFile($nama_file . '_' . $no_daftar . '.odt');
    }

	public function cetak_monitoring_sektor($sektor = null, $tgla = null, $tglb = null) {
		$username = new user();
        $username->where('username', $this->session->userdata('username'))->get();
		
        $this->settings = new settings();
        $this->settings->where('name', 'app_folder')->get();
        $app_folder = $this->settings->value . "/";
        $app_city = $this->settings->where('name', 'app_city')->get();

        $trsektor = new trsektor();
		$trsektor->where('id', $sektor)->get();
		
		$permohonan = new tmpermohonan();
        $p_kelurahan = $permohonan->tmpemohon->trkelurahan->get();
        $p_kecamatan = $permohonan->tmpemohon->trkelurahan->trkecamatan->get();
        $p_kabupaten = $permohonan->tmpemohon->trkelurahan->trkecamatan->trkabupaten->get();

        //path of the template file
        $nama_surat = "cetak_monitoring_sektor";
		$nama_file = "monitoring_sektor";
        $this->load->plugin('odf');
        $odf = new odf('assets/odt/' . $nama_surat . '.odt');
//        $odf->setImage('header', 'assets/css/' . $app_folder . '/images/dinas_1.jpg', '17.5', '3.5');

        //logo
        $this->tr_instansi = new Tr_instansi();
        $logo = $this->tr_instansi->get_by_id(23);
        if($logo->value!=="") {
			$odf->setImage('logo', 'uploads/logo/' . $logo->value, '2.1', '2.5');
		}else{
            $odf->setVars('logo', ' ');
        }

		//pemerintah 
        $this->tr_instansi = new Tr_instansi();
        $nama_prov = $this->tr_instansi->get_by_id(17);
		$odf->setVars('provinsi', strtoupper($nama_prov->value));

        //badan
        $this->tr_instansi = new Tr_instansi();
        $nama_bdan = $this->tr_instansi->get_by_id(9);
        $odf->setVars('badan', strtoupper($nama_bdan->value));

        //telpon
        $this->tr_instansi = new Tr_instansi();
        $n_tlp = $this->tr_instansi->get_by_id(10);
        $odf->setVars('tlp', $n_tlp->value);

        //fax
        $this->tr_instansi = new Tr_instansi();
        $n_fax = $this->tr_instansi->get_by_id(13);
        $odf->setVars('fax', $n_fax->value);

        //alamat
        $this->tr_instansi = new Tr_instansi();
        $n_alamat = $this->tr_instansi->get_by_id(12);
        $odf->setVars('alamat', $n_alamat->value);

        //web
        $this->tr_instansi = new Tr_instansi();
        $web = $this->tr_instansi->get_by_id(21);
        $odf->setVars('website', $web->value);

		//e-mail
        $this->tr_instansi = new Tr_instansi();
        $e_mail = $this->tr_instansi->get_by_id(22);
        $odf->setVars('email', $e_mail->value);

        //Kop Kota
        $this->tr_instansi = new Tr_instansi();
        $kop_kota = $this->tr_instansi->get_by_id(19);
		$odf->setVars('k_kota_besar', strtoupper($kop_kota->value));

        //Kode Pos
        $this->tr_instansi = new Tr_instansi();
        $kode_pos = $this->tr_instansi->get_by_id(20);
        $odf->setVars('kd_pos', $kode_pos->value);

        //membuat kota
        $wilayah = new trkabupaten();
        if ($app_city->value !== '0') {
            $alamat = $permohonan->tmpemohon->a_pemohon . ' ' . $p_kelurahan->n_kelurahan . ', ' .
                    $p_kecamatan->n_kecamatan . ', ' . ucwords(strtolower($p_kabupaten->n_kabupaten));
            $wilayah->get_by_id($app_city->value);
        } else {
            $alamat = $permohonan->tmpemohon->a_pemohon;
        }

         $gede_kota=strtoupper($wilayah->n_kabupaten);
        $kecil_kota=ucwords(strtolower($wilayah->n_kabupaten));
        
        $nkota = "SUMEDANG";
//		$cek_cetak = "0";
        //	Khusus Untuk linux 
//        if ($gerai == 'Gerai_Bogor')     { $gerai = 'Gerai Bogor';}
//		if ($gerai == 'Gerai_Purwakarta'){ $gerai = 'Gerai Purwakarta';}
//		if ($gerai == 'Gerai_Garut')     { $gerai = 'Gerai Garut';}
//        if ($gerai == 'Gerai_Cirebon')   { $gerai = 'Gerai Cirebon';}
        //	Khusus Untuk linux EOF()

//        if ($gerai == 'Gerai Bogor')     { $cek_cetak = "1"; $nkota = "BOGOR";}
//		if ($gerai == 'Gerai Purwakarta'){ $cek_cetak = "1"; $nkota = "PURWAKARTA";}
//		if ($gerai == 'Gerai Garut')     { $cek_cetak = "1"; $nkota = "GARUT";}
//        if ($gerai == 'Gerai Cirebon')   { $cek_cetak = "1"; $nkota = "CIREBON";}
//		if ($gerai == 'SMS')             { $cek_cetak = "1"; $nkota = "TASIKMALAYA";}

        $odf->setVars('tanggal', $this->lib_date->mysql_to_human(date('Y/m/d')));
        $odf->setVars('title', 'Monitoring Perizinan per Sektor');
        $odf->setVars('periode_awal',$this->lib_date->mysql_to_human($tgla));
        $odf->setVars('periode_akhir',$this->lib_date->mysql_to_human($tglb));
		$odf->setVars('k_kota_cetak',$nkota);

        $i = 1;
        
        //$data['listpemohon'] = $this->pemohon->get();
        if($sektor == 0){
            $listpermohonan = $this->permohonan->where_related("trstspermohonan", 'id <> 1')->where("d_terima_berkas >= '$tgla' AND d_terima_berkas <= '$tglb'")->get();
			$judul2 = "Sektor : Seluruhnya";
		} else {
			$listpermohonan = $this->permohonan->where_related("trstspermohonan", 'id <> 1')->where("trsektor_id = '$sektor' AND d_terima_berkas >= '$tgla' AND d_terima_berkas <= '$tglb'")->get();
			$judul2 = "Sektor : ".$trsektor->n_sektor;
        }
		
		$odf->setVars('judul2', $judul2);
        if ($this->permohonan->id) {
            foreach ($listpermohonan as $data) {
                $data->tmpemohon->get();
                $data->trperizinan->get();
                $data->trstspermohonan->get();
                $data->tmpemohon->trkelurahan->get();
				$data->tmperusahaan->get();

                $listeArticles3 = array(
                    array('property' => $i,
                        'content1' => $data->pendaftaran_id, //$data->n_perizinan,
                        'content2' => $data->trperizinan->n_perizinan,
                        'content3' => $this->lib_date->mysql_to_human($data->d_terima_berkas),
                        'content4' => $data->tmpemohon->n_pemohon ." / ". $data->tmperusahaan->n_perusahaan,
                        'content5' => $data->trstspermohonan->n_sts_permohonan,
                        'content6' => $data->a_izin,
                        'content7' => $data->kd_gerai,
                   //     'content7' => $data->tmpemohon->trkelurahan->n_kelurahan,
                    ),
                );

                $article3 = $odf->setSegment('articles3');
                foreach ($listeArticles3 AS $element) {

                    $article3->titreArticle3($element['property']);
                    $article3->texteArticle3($element['content1']);
                    $article3->texteArticle4($element['content2']);
                    $article3->texteArticle5($element['content3']);
                    $article3->texteArticle6($element['content4']);
                    $article3->texteArticle7($element['content5']);
                    $article3->texteArticle8($element['content6']);
                    $article3->texteArticle9($element['content7']);
                    $article3->merge();
                }

                $i++;
            }
        } else {
            $listeArticles3 = array(
                array('property' => '',
                    'content1' => '', //$data->n_perizinan,
                    'content2' => '',
                    'content3' => '',
                    'content4' => '',
                    'content5' => '',
                    'content6' => '',
                    'content7' => '',
                ),
            );

            $article3 = $odf->setSegment('articles3');
            foreach ($listeArticles3 AS $element) {

                $article3->titreArticle3($element['property']);
                $article3->texteArticle3($element['content1']);
                $article3->texteArticle4($element['content2']);
                $article3->texteArticle5($element['content3']);
                $article3->texteArticle6($element['content4']);
                $article3->texteArticle7($element['content5']);
                $article3->texteArticle8($element['content6']);
                $article3->texteArticle9($element['content7']);
                $article3->merge();
            }
        }
        $odf->mergeSegment($article3);

        //export the file
        $no_daftar = str_replace('/', '', $permohonan->pendaftaran_id);
        $odf->exportAsAttachedFile($nama_file . '_' . $no_daftar . '.odt');
    }

    public function getPerbulan() {
        $tgla = $this->input->post('tgla');
        $tglb = $this->input->post('tglb');

        $data['listpemohon'] = $this->pemohon->get();
        $data['listpermohonan'] = $this->permohonan->where("d_entry BETWEEN '$tgla' AND '$tglb'")->get();

        $this->load->vars($data);

        $js = "
                $(document).ready(function() {
                        oTable = $('#monitoring').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );
                ";

        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "Monitoring Per Bulan masuk";
        $this->template->build('view_bulan', $this->session_info);
    }

    public function getBetween() {
        $tgla = $this->input->post('tgla');
        $tglb = $this->input->post('tglb');
        $this->load->database();
        $this->db->select('a.*, c.n_pemohon, c.a_pemohon, e.n_perizinan');
        $this->db->from('tmpermohonan as a');
        $this->db->join('tmpemohon_tmpermohonan as b', 'a.id=tmpermohonan_id');
        $this->db->join('tmpemohon as c', 'b.tmpemohon_id=c.id');
        $this->db->join('tmpemohon_trperizinan as d', 'c.id=d.tmpemohon_id');
        $this->db->join('trperizinan as e', 'e.id=d.trperizinan_id');
        $this->db->where("a.d_terima_berkas BETWEEN '$tgla' AND '$tglb'");
        $this->db->groupby('a.id');
        $query = $this->db->get('');
        return $query->result();

        $this->load->vars($data);

        $js = "
                $(document).ready(function() {
                        oTable = $('#monitoring').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );
                ";

        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "Monitoring Per Bulan Masuk";
        $this->template->build('view_bulan', $this->session_info);
    }

	public function cetak_izin_baru($gerai = '', $tgla = null, $tglb = null, $realname = null, $control = NULL) {
		$syarat = $this->input->post('pemohon_syarat');
		$syarat = count($syarat);
        $username = new user();
        $username->where('username', $this->session->userdata('username'))->get();
        $gerai = $this->session->userdata('lokasi');
        $kd_user = $username->id;

        $this->settings = new settings();
        $this->settings->where('name', 'app_folder')->get();
        $app_folder = $this->settings->value . "/";
        $app_city = $this->settings->where('name', 'app_city')->get();

        $permohonan = new tmpermohonan();
        
        $p_kelurahan = $permohonan->tmpemohon->trkelurahan->get();
        $p_kecamatan = $permohonan->tmpemohon->trkelurahan->trkecamatan->get();
        $p_kabupaten = $permohonan->tmpemohon->trkelurahan->trkecamatan->trkabupaten->get();

        //path of the template file
        $nama_surat = "cetak_izin_baru";
        $this->load->plugin('odf');
        $odf = new odf('assets/odt/' . $nama_surat . '.odt');

        //logo
        $this->tr_instansi = new Tr_instansi();
        $logo = $this->tr_instansi->get_by_id(23);
        if($logo->value!=="") {
            $odf->setImage('logo', 'uploads/logo/' . $logo->value, '2.1', '2.5');
		} else {
            $odf->setVars('logo', ' ');
        }

		//pemerintah 
        $this->tr_instansi = new Tr_instansi();
        $nama_prov = $this->tr_instansi->get_by_id(17);
        $odf->setVars('provinsi', strtoupper($nama_prov->value));

        //badan
        $this->tr_instansi = new Tr_instansi();
        $nama_bdan = $this->tr_instansi->get_by_id(9);
        $odf->setVars('badan', strtoupper($nama_bdan->value));

        //telpon
        $this->tr_instansi = new Tr_instansi();
        $n_tlp = $this->tr_instansi->get_by_id(10);
        $odf->setVars('tlp', $n_tlp->value);

        //fax
        $this->tr_instansi = new Tr_instansi();
        $n_fax = $this->tr_instansi->get_by_id(13);
        $odf->setVars('fax', $n_fax->value);

        //alamat
        $this->tr_instansi = new Tr_instansi();
        $n_alamat = $this->tr_instansi->get_by_id(12);
        $odf->setVars('alamat', $n_alamat->value);

        //web
        $this->tr_instansi = new Tr_instansi();
        $web = $this->tr_instansi->get_by_id(21);
        $odf->setVars('website', $web->value);

		//e-mail
        $this->tr_instansi = new Tr_instansi();
        $e_mail = $this->tr_instansi->get_by_id(22);
        $odf->setVars('email', $e_mail->value);

        //Kop Kota
        $this->tr_instansi = new Tr_instansi();
        $kop_kota = $this->tr_instansi->get_by_id(19);
		$odf->setVars('k_kota_besar', strtoupper($kop_kota->value));

        //Kode Pos
        $this->tr_instansi = new Tr_instansi();
        $kode_pos = $this->tr_instansi->get_by_id(20);
        $odf->setVars('kd_pos', $kode_pos->value);

        //membuat kota
        $wilayah = new trkabupaten();
        if ($app_city->value !== '0') {
            $alamat = $permohonan->tmpemohon->a_pemohon . ' ' . $p_kelurahan->n_kelurahan . ', ' .
                    $p_kecamatan->n_kecamatan . ', ' . ucwords(strtolower($p_kabupaten->n_kabupaten));
            $wilayah->get_by_id($app_city->value);
        } else {
            $alamat = $permohonan->tmpemohon->a_pemohon;
        }

        $gede_kota=strtoupper($wilayah->n_kabupaten);
        $kecil_kota=ucwords(strtolower($wilayah->n_kabupaten));
        
        $nkota = "SUMEDANG";
//        $gerai = str_replace('_',' ', $gerai);
		if ($gerai == 'Pusat')             { $nkota = "SUMEDANG"; }
		if ($gerai == 'BPPT Prov. tasikmalaya')  { $nkota = "TASIKMALAYA"; }
		if ($gerai == 'BPMPT Prov. tasikmalaya') { $nkota = "TASIKMALAYA"; }
		if ($gerai == 'DPMPTSP Prov. tasikmalaya') { $nkota = "TASIKMALAYA"; }
		if ($gerai == 'Gerai Bogor')       { $nkota = "BOGOR"; }
		if ($gerai == 'Gerai Purwakarta')  { $nkota = "PURWAKARTA"; }
		if ($gerai == 'Gerai Garut')       { $nkota = "GARUT"; }
		if ($gerai == 'Gerai Cirebon')     { $nkota = "CIREBON"; }
		if ($gerai == 'SMS')               { $nkota = "TASIKMALAYA"; }
		if ($gerai == 'Surat')             { $nkota = "TASIKMALAYA"; }
		if ($gerai == 'OnLine')            { $nkota = "OnLine"; }
		
        $odf->setVars('tanggal', $this->lib_date->mysql_to_human(date('Y/m/d')));
//        $odf->setVars('title', 'Lampiran Berita Acara Penyerahan Berkas');
		$odf->setVars('title', $syarat);
        $odf->setVars('periode_awal',$this->lib_date->mysql_to_human($tgla));
        $odf->setVars('periode_akhir',$this->lib_date->mysql_to_human($tglb));
		$odf->setVars('k_kota_cetak',$nkota);
		$odf->setVars('nama',str_replace('_',' ', $realname));

        $i = 1;
        
        $data['listpemohon'] = $this->pemohon->get();
		//if ($gerai !== 'Pusat') {// untuk daerah lain
		if ($gerai !== 'BPPT Prov. tasikmalaya' || $gerai !== 'BPMPT Prov. tasikmalaya' || $gerai !== 'DPMPTSP Prov. tasikmalaya') {
			if($control == "1") {
    			$listpermohonan = $this->permohonan->where_related("trstspermohonan",'id = 3')->where("c_cetak = '$kd_user' AND kd_gerai = '$gerai' AND d_terima_berkas >= '$tgla' AND d_terima_berkas <= '$tglb'")->get();
	    		$hit = $this->permohonan->where_related("trstspermohonan",'id = 3')->where("c_cetak = '$kd_user' AND kd_gerai = '$gerai' AND d_terima_berkas >= '$tgla' AND d_terima_berkas <= '$tglb'")->count();
			}
			if($control == "2") {
                $listpermohonan = $this->permohonan->where_related("trstspermohonan",'id = 8')->where("c_cetak = '$kd_user' AND status_berkas <> 'proses' AND kd_gerai = '$gerai' AND d_terima_berkas >= '$tgla' AND d_terima_berkas <= '$tglb'")->get();
	    		$hit = $this->permohonan->where_related("trstspermohonan",'id = 8')->where("c_cetak = '$kd_user' AND status_berkas <> 'proses' AND kd_gerai = '$gerai' AND d_terima_berkas >= '$tgla' AND d_terima_berkas <= '$tglb'")->count();
			}
        } else {
			if($control == "1") {
			    $listpermohonan = $this->permohonan->where_related("trstspermohonan",'id = 3')->where("c_cetak = '$kd_user' AND d_terima_berkas >= '$tgla' AND d_terima_berkas <= '$tglb'")->get();
			    $hit = $this->permohonan->where_related("trstspermohonan",'id = 3')->where("c_cetak = '$kd_user' AND d_terima_berkas >= '$tgla' AND d_terima_berkas <= '$tglb'")->count();
			}
			if($control == "2") {
				$listpermohonan = $this->permohonan->where_related("trstspermohonan",'id = 8')->where("c_cetak = '$kd_user' AND status_berkas <> 'proses' AND d_terima_berkas >= '$tgla' AND d_terima_berkas <= '$tglb'")->get();
			    $hit = $this->permohonan->where_related("trstspermohonan",'id = 8')->where("c_cetak = '$kd_user' AND status_berkas <> 'proses' AND d_terima_berkas >= '$tgla' AND d_terima_berkas <= '$tglb'")->count();
			}
		}
        
//		if ($this->permohonan->id) {
	    if ( $hit > 0 ) {
            foreach ($listpermohonan as $data) {
                $data->tmpemohon->get();
                $data->trperizinan->get();
                $data->trstspermohonan->get();
                $data->tmpemohon->trkelurahan->get();
				$data->tmperusahaan->get();
                
				if($data->tmperusahaan->n_perusahaan == '')
				    $dt_pemohon = $data->tmpemohon->n_pemohon;
				else
                    $dt_pemohon = $data->tmpemohon->n_pemohon.' / '.$data->tmperusahaan->n_perusahaan;

				if($data->keterangan == '')
					$obj_ijin = $data->a_izin;
				else
				    $obj_ijin = $data->a_izin.' [ Ket : '.$data->keterangan.' ]';

                $listeArticles3 = array(
                    array('property' => $i,
                        'content1' => $data->pendaftaran_id, //$data->n_perizinan,
                        'content2' => $data->trperizinan->n_perizinan,
                        'content3' => $this->lib_date->mysql_to_human($data->d_terima_berkas),
                        'content4' => $dt_pemohon,
                        'content5' => $data->trstspermohonan->n_sts_permohonan,
                        'content6' => $obj_ijin,
                        'content7' => $data->kd_gerai,
                    ),
                );

                $article3 = $odf->setSegment('articles3');
                foreach ($listeArticles3 AS $element) {
                    $article3->titreArticle3($element['property']);
                    $article3->texteArticle3($element['content1']);
                    $article3->texteArticle4($element['content2']);
                    $article3->texteArticle5($element['content3']);
                    $article3->texteArticle6($element['content4']);
                    $article3->texteArticle7($element['content5']);
                    $article3->texteArticle8($element['content6']);
                    $article3->texteArticle9($element['content7']);
                    $article3->merge();
                }

                $i++;
            }
        } else {
            $listeArticles3 = array(
                array('property' => '',
                    'content1' => '', //$data->n_perizinan,
                    'content2' => '',
                    'content3' => '',
                    'content4' => '',
                    'content5' => '',
                    'content6' => '',
                    'content7' => '',
                ),
            );

            $article3 = $odf->setSegment('articles3');
            foreach ($listeArticles3 AS $element) {
                $article3->titreArticle3($element['property']);
                $article3->texteArticle3($element['content1']);
                $article3->texteArticle4($element['content2']);
                $article3->texteArticle5($element['content3']);
                $article3->texteArticle6($element['content4']);
                $article3->texteArticle7($element['content5']);
                $article3->texteArticle8($element['content6']);
                $article3->texteArticle9($element['content7']);
                $article3->merge();
            }
        }
        
        $odf->mergeSegment($article3);

        //export the file
        $no_daftar = str_replace('/', '', $permohonan->pendaftaran_id);
        $odf->exportAsAttachedFile($nama_surat . '_' . $no_daftar . '.odt');
    }

}
// This is the end of monitoring class