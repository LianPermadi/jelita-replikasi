<?php

/** Description of SK Ditolak
  * @author agusnur Created : 17 Sep 2010
  * @edt PBS 27 May 2015
 */

class SkDitolak extends WRC_AdminCont {

    public function __construct() {
        parent::__construct();
        $this->sk = new tmpermohonan();
        $this->propertyizin = new tmproperty_jenisperizinan();
        $this->perizinan = new trperizinan();
        $this->pemohon = new tmpemohon();
        $this->surat = new tmsk();

        $enabled = FALSE;
        $list_auths = $this->session_info['app_list_auth'];

        foreach ($list_auths as $list_auth) {
            if($list_auth->id_role === '13') {
                $enabled = TRUE;
            }
        }

        if(!$enabled) {
            redirect('dashboard');
        }
    }

    public function index() {
        $user = new user();
        $user_user_auth = new user_user_auth();
        $stat = "19";                              // lihat tabel user_auth untuk Penomoran
        $kd_auth = FALSE;
        $user->where('username', $this->session->userdata('username'))->get();
        $user_user_auth->where('user_id', $user->id)->where('user_auth_id', $stat)->get();
        if($user_user_auth->user_auth_id === $stat) {
           $kd_auth = TRUE;
        }
        
        if($kd_auth!=1) { 
          redirect('dashboard');
        }

        $tgla = $this->input->post('tgla');
        $tglb = $this->input->post('tglb');
        $now = $this->lib_date->get_date_now();
        $tgl_before = $this->lib_date->set_date($now, -40);
        $tgl_now = $this->lib_date->set_date($now, 0);

        if($tgla && $tglb){
            $data['tgla'] = $tgla;
            $data['tglb'] = $tglb;
        }else{
            $tgla = $tgl_before;
            $tglb = $tgl_now;
            $data['tgla'] = $tgla;
            $data['tglb'] = $tglb;
        }
        $username = new user();
        $username->where('username', $this->session->userdata('username'))->get();
        $query = "SELECT A.id, A.pendaftaran_id, A.d_terima_berkas, A.d_survey, A.d_perubahan, A.d_perpanjangan, A.d_daftarulang,
                  C.id idizin, C.n_perizinan, C.c_keputusan, E.n_pemohon, E.a_pemohon, G.id idjenis, G.n_permohonan
                  FROM tmpermohonan as A
                  INNER JOIN tmpermohonan_trperizinan as B ON B.tmpermohonan_id = A.id
                  INNER JOIN trperizinan as C ON B.trperizinan_id = C.id
                  INNER JOIN tmpemohon_tmpermohonan as D ON D.tmpermohonan_id = A.id
                  INNER JOIN tmpemohon as E ON D.tmpemohon_id = E.id
                  INNER JOIN tmpermohonan_trjenis_permohonan as F ON F.tmpermohonan_id = A.id
                  INNER JOIN trjenis_permohonan as G ON F.trjenis_permohonan_id = G.id
                  INNER JOIN trperizinan_user AS H ON  H.trperizinan_id = C.id
                  WHERE A.c_pendaftaran = 1
                  AND A.c_izin_dicabut = 0
                  AND A.c_izin_selesai = 0
                  AND A.status_berkas = 'Izin Ditolak'
                  AND H.user_id = '".$username->id."'
                  AND A.d_terima_berkas between '$tgla' and '$tglb'
                  order by A.id DESC";
        $data['list'] = $query;
        $data['c_bap'] = "2";
        $this->load->vars($data);

        $js =  "$(document).ready(function() {
                    oTable = $('#sk').dataTable({
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
        $this->session_info['page_name'] = "Data Izin Ditolak";
        $this->template->build('sk_tolak_list', $this->session_info);
    }

    public function cetak($id_daftar = NULL) {
        $nama_surat = "cetak_sk_ditolak";
        $app_folder = new settings();
        $app_folder->where('name','app_folder')->get();
        $app_folder = $app_folder->value . "/";
        $app_city = new settings();
        $app_city->where('name','app_city')->get();
        $app_city = $app_city->value;

        $permohonan = new tmpermohonan();
        $permohonan->get_by_id($id_daftar);
        $pemohon = $permohonan->tmpemohon->get();
        $kelurahan = $permohonan->tmpemohon->trkelurahan->get();
        $kecamatan = $kelurahan->trkecamatan->get();
        $kabupaten = $kecamatan->trkabupaten->get();
        $propinsi = $kabupaten->trpropinsi->get();
        $surat = $permohonan->tmsk->get();
        $bap = $permohonan->tmbap->get();
        $jenis_izin = $permohonan->trperizinan->get();
        $jenis_daftar = $permohonan->trjenis_permohonan->get();

        $status_izin = $permohonan->trstspermohonan->get();

        $status_skr = "9"; //Izin Ditolak [Lihat Tabel trstspermohonan()]
        $id_status = "14"; //Penyerahan Izin [Lihat Tabel trstspermohonan()]
        if($status_izin->id == $status_skr){
        /* Input Data Tracking Progress */
            $sts_izin = new trstspermohonan();
            $sts_izin->get_by_id($status_skr);
            $data_status = new tmtrackingperizinan_trstspermohonan();
            $list_tracking = $permohonan->tmtrackingperizinan->get();
            if($list_tracking){
                $tracking_id = 0;
                foreach ($list_tracking as $data_track){
                    $data_status = new tmtrackingperizinan_trstspermohonan();
                    $data_status->where('tmtrackingperizinan_id', $data_track->id)
                    ->where('trstspermohonan_id', $sts_izin->id)->get();
                    if($data_status->tmtrackingperizinan_id){
                        $tracking_id = $data_status->tmtrackingperizinan_id;
                    }
                }
            }
            $tracking_izin = new tmtrackingperizinan();
            $tracking_izin->get_by_id($tracking_id);
            //$tracking_izin->pendaftaran_id = $permohonan->pendaftaran_id;
            $tracking_izin->status = 'Update';
            $tracking_izin->d_entry = $this->lib_date->get_date_now();
            $tracking_izin->save();

        /* [Lihat Tabel trstspermohonan()] */
            $tracking_izin2 = new tmtrackingperizinan();
            $tracking_izin2->pendaftaran_id = $permohonan->pendaftaran_id;
            $tracking_izin2->status = 'Insert';
            $tracking_izin2->d_entry_awal = $this->lib_date->get_date_now();
            $tracking_izin2->d_entry = $this->lib_date->get_date_now();
            $sts_izin2 = new trstspermohonan();
            $sts_izin2->get_by_id($id_status); //[Lihat Tabel trstspermohonan()]
            $sts_izin2->save($permohonan);
            $tracking_izin2->save($permohonan);
            $tracking_izin2->save($sts_izin2);
        }
        
        $surat_sk = new tmsk();
        $petugas = 1;
        $pegawai = new tmpegawai();
        $pegawai->where('status', $petugas)->get();
        if($surat->id){
            $surat_sk->where('id', $surat->id)
                     ->update(array('c_status' => 1, 'c_cetak' => $surat->c_cetak + 1));
        }else{
            $this->surat->no_surat = "Ditolak";
            $this->surat->c_status = 1;
            $tgl_skr = $this->lib_date->get_date_now();
            $this->surat->tgl_surat = $tgl_skr;
            $this->surat->c_cetak = $surat->c_cetak + 1;

            $this->surat->save(array($permohonan, $pegawai));
        }

        //path of the template file
        $this->load->plugin('odf');
        $odf = new odf('assets/odt/'.$nama_surat.'.odt');
       // $odf->setImage('header', 'assets/css/'.$app_folder.'/images/dinas_1.jpg', '17.5', '3.5');

          //logo
        $this->tr_instansi = new Tr_instansi();
        $logo = $this->tr_instansi->get_by_id(14);
        if($logo->value!=="") {
           $odf->setImage('logo', 'uploads/logo/' . $logo->value, '1.7', '1.7');
        } else {
          $odf->setVars('logo', ' ');
        }

        //badan
        $this->tr_instansi = new Tr_instansi();
        $nama_bdan = $this->tr_instansi->get_by_id(9);
        $odf->setVars('badan', strtoupper($nama_bdan->value));

        //telpon
        $this->tr_instansi = new Tr_instansi();
        $tlp = $this->tr_instansi->get_by_id(10);
        $odf->setVars('tlp', $tlp->value);

        //fax
        $this->tr_instansi = new Tr_instansi();
        $tlp = $this->tr_instansi->get_by_id(13);
        $odf->setVars('fax', $tlp->value);
        
        //Content
        $kelompok = $jenis_izin->trkelompok_perizinan->get();
        if($kelompok->id == 1)
            $status = "Berdasarkan Rekomendasi dari Instansi Teknis, maka permohonan izin Saudara belum dapat dikabulkan  karena :";
        else if($kelompok->id == 3)
            $status = "Setelah dilakukan koordinasi dengan tim teknis berdasarkan kajian teknis, maka permohonan izin Saudara belum dapat dikabulkan  karena :";
        else if($kelompok->id == 2 || $kelompok->id == 4)
            $status = "Setelah dilakukan koordinasi dengan tim teknis berdasarkan kajian teknis dan peninjauan lapangan, maka permohonan izin Saudara belum dapat dikabulkan  karena :";
        else $status = '';
        $odf->setVars('status', $status);
        $odf->setVars('keterangan', $bap->c_pesan);
        $tgl_skr = $this->lib_date->get_date_now();
        $odf->setVars('tanggal',$this->lib_date->mysql_to_human($tgl_skr));
        $odf->setVars('jabatan', $pegawai->n_jabatan);
        $odf->setVars('nama_pejabat', $pegawai->n_pegawai);
        $odf->setVars('nip_pejabat', $pegawai->nip);
        $wilayah = new trkabupaten();
        if($app_city !== '0'){
            $wilayah->get_by_id($app_city);
            $kota = ucwords(strtolower($wilayah->ibukota));
            //$kota = strtoupper($wilayah->ibukota);
            $odf->setVars('kota', $kota);
        }else{
            $kota = "..............";
            $odf->setVars('kota', $kota);
        }
             
        $gede_kota=strtoupper($wilayah->n_kabupaten);
        $kecil_kota=ucwords(strtolower($wilayah->n_kabupaten));
        $odf->setVars('kota4', $gede_kota);

        //alamat
        $this->tr_instansi = new Tr_instansi();
        $alamat = $this->tr_instansi->get_by_id(12);
        $odf->setVars('alamat', ucwords(strtolower($alamat->value)).' - '.$kecil_kota);

        $listeArticles = array(
                array(  'property' => 'Kepada Yth. :',
                        'content' => '',
                ),
                array(  'property' => 'Sdr.',
                        'content' => $pemohon->n_pemohon,
                ),
                array(  'property' => '',
                        'content' => $pemohon->a_pemohon,
                ),
                array(  'property' => $kabupaten->n_kabupaten,
                        'content' => $propinsi->n_propinsi,
                ),
        );
        $article = $odf->setSegment('articles1');
        foreach($listeArticles AS $element) {
                $article->titreArticle($element['property']);
                $article->texteArticle($element['content']);
                $article->merge();
        }
        $odf->mergeSegment($article);
        
        $listeArticles = array(
                array(  'property' => 'No Pendaftaran',
                        'titik' => ':',
                        'content' => $permohonan->pendaftaran_id,
                ),
                array(  'property' => 'Jenis Izin',
                        'titik' => ':',
                        'content' => $jenis_izin->n_perizinan,
                ),
                array(  'property' => 'Jenis Permohonan',
                        'titik' => ':',
                        'content' => $jenis_daftar->n_permohonan,
                ),
        );
        $article = $odf->setSegment('articles2');
        foreach($listeArticles AS $element) {
                $article->titreArticle($element['property']);
                $article->texteArticle($element['titik']);
                $article->texteArticle2($element['content']);
                $article->merge();
        }
        $odf->mergeSegment($article);

        //export the file
        $no_daftar = str_replace('/', '', $permohonan->pendaftaran_id);
        $odf->exportAsAttachedFile($nama_surat.'_'.$no_daftar.'.odt');
    }
    
    public function cetak_penolakan($id_daftar = NULL) {
        
        // echo "1&nbsp;1&nbsp1";
        // die;
        
        // die;
//------------------------------------------------------------------------------------//ALI
        $aa = "select * from tmpermohonan_tmperusahaan where tmpermohonan_id ='".$id_daftar."'";
        $hasilz = $this->db->query($aa);
       if($hasilz->num_rows() ==  1){
            $perusahaan = $hasilz->row_array();
            $que = "select * from tmperusahaan where id = '$perusahaan[tmperusahaan_id]'";
            $per = $this->db->query($que)->row_array();
            $que3 = "select * from tmpemohon_tmpermohonan where tmpermohonan_id = '$perusahaan[tmpermohonan_id]'";
            $per3 = $this->db->query($que3)->row_array();
            $que2 = "select * from tmpemohon where id = '$per3[tmpemohon_id]'";
            $per2 = $this->db->query($que2)->row_array();
            $que4 = "select * from tmpermohonan where id = '$perusahaan[tmpermohonan_id]'";
            $per4 = $this->db->query($que4)->row_array();
            
            
            $dataPer1 = "Direktur ".$per['n_perusahaan'];
            $dataPer2 = $per['a_perusahaan'];
            $dataPer3 = "XVII/221/003";
            $dataPer4 = $per4['d_terima_berkas'];
            $dataPer5 = $per4['tanggal_pertimbangan'];
            
            
        }else{
            
            $aa = "select * from tmpemohon_tmpermohonan where tmpermohonan_id ='".$id_daftar."'";
            $hasilz = $this->db->query($aa);
            $perusahaan = $hasilz->row_array();
            $que2 = "select * from tmpemohon where id = '$perusahaan[tmpemohon_id]'";
            $per2 = $this->db->query($que2)->row_array();
            
            $que3 = "select * from tmpermohonan where id = '$perusahaan[tmpermohonan_id]'";
            $per3 = $this->db->query($que3)->row_array();
             $que4 = "select * from tmpermohonan where id = '$perusahaan[tmpermohonan_id]'";
            $per4 = $this->db->query($que4)->row_array();
            
            $dataPer1 = "Bp/Ibu  ".$per2['n_pemohon'];
            $dataPer2 = $per2['a_pemohon'];
            $dataPer3 = "XVII/221/003";
            $dataPer4 = $per4['d_terima_berkas'];
            $dataPer5 = $per4['tanggal_pertimbangan'];
            
             
        }


        $a = "select * from tmpermohonan where id ='".$id_daftar."'";
        $hasil = $this->db->query($a)->row_array();
        $b = "select * from trperizinan where id = (select trperizinan_id from tmpermohonan_trperizinan where tmpermohonan_id ='".$id_daftar."')";
        $hasil2 = $this->db->query($b)->row_array();
        $c = "select * from trperizinan_template where perizinan_id = (select trperizinan_id from tmpermohonan_trperizinan where tmpermohonan_id ='".$id_daftar."') ";
        $hasil3 = $this->db->query($c)->result();
        $g = "select * from tmsk where id in(select tmsk_id from tmpermohonan_tmsk where tmpermohonan_id ='".$id_daftar."')";
        $hasil7 = $this->db->query($g)->row_array(); 
        $q_alasan = "select * from alasan_penolakan where id_permohonan = '".$id_daftar."'";
        
        $alasan = $this->db->query($q_alasan)->result(); 
        
        $kota = "select * from trkabupaten where id in(select trkabupaten_id from trkabupaten_trkecamatan where trkecamatan_id in(select id from trkecamatan where id in(select trkecamatan_id from trkecamatan_trkelurahan where trkelurahan_id in(select id from trkelurahan where id in(select trkelurahan_id from tmpemohon_trkelurahan where tmpemohon_id in(select tmpemohon_id from tmpemohon_tmpermohonan where tmpermohonan_id = (select id from tmpermohonan where id = '".$id_daftar."_Asdasd'))))))) ";
        $sqlkota = $this->db->query($kota)->row_array();        
        // var_dump($hasilz->row_array());
  //       exit();
        require_once 'assets/phpword/src/PhpWord/Autoloader.php';
        \PhpOffice\PhpWord\Autoloader::register();
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('assets/template-baru/penolakan.docx');

        $templateProcessor->setValue("nomor","                 /                     /".$hasil['bidang']);
        
        $templateProcessor->setValue("nama_izin",$hasil2['n_perizinan']);
        $arrBln = array("Januari",'Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
        $tanggal = date("d");
        $bulan = $arrBln[date("n")-1];
        $tahun = date("Y");
        
        $templateProcessor->setValue('tanggal',$tanggal);
        $templateProcessor->setValue('bulan',$bulan);
        $templateProcessor->setValue('tahun',$tahun);
        $templateProcessor->setValue('nama_pemohon',$dataPer1);
        $templateProcessor->setValue('alamat',$dataPer2);
        
        $templateProcessor->setValue('pemohon',$dataPer1);
        $templateProcessor->setValue("nomor1",'      /       /        ');
        $d4 = explode("-", $dataPer4);
        $k = $arrBln[intval($d4[1]-1)];
        //echo "$d4[2] $k $d4[0]<br>";
        $templateProcessor->setValue("tanggal1","$d4[2] $k $d4[0]");
        $templateProcessor->setValue("nomor2"," VII/445/002 ");
        $d5 = explode("-", $dataPer5);
        $k = (intval($d5[1]-1) == -1)?'00':$arrBln[intval($d5[1]-1)];
        //echo "$k";die;
        $templateProcessor->setValue("tanggal2","$d5[2] $k $d5[0]");
        $templateProcessor->setValue("bidang",$hasil['bidang']);

// //alasan---------------
        $no = 1;
        $templateProcessor->cloneRow('alasan', count($alasan));

        // while($no<=count($hasil4)){
        foreach($alasan as $ha4){

            // $templateProcessor->setValue('N'.$no,$no);
            $templateProcessor->setValue("alasan#".$no,$ha4->alasan);
        
            $no++;
        }
        $no = 1;
        foreach($alasan as $ha4){

            // $templateProcessor->setValue('N'.$no,$no);
            $templateProcessor->setValue("No#".$no,$no);
            
            $no++;
        }
// //end-------------------     

        $ttdq = "select * from tmpegawai where ttd_penolakan = 1";
        $ttd = $this->db->query($ttdq)->row_array();
            
        $templateProcessor->setValue('ttd',$ttd['n_pegawai']);
        $templateProcessor->setValue('nip',$ttd['nip']);
        $templateProcessor->setValue('pangkat',$ttd['n_jabatan']);

//         // $kota = explode(' ', $sqlkota['n_kabupaten']);

        // if ($kota[0] == 'KOTA') {
        // $templateProcessor->setValue('wal/bup','Walikota '.ucfirst(strtolower($kota[1])));
        // }else{
        // $templateProcessor->setValue('wal/bup','Bupati '.ucfirst(strtolower($kota[1])));      
        // }

        // if ($kota[0] == 'KOTA'){
            // $templateProcessor->setValue('ket','Kota'); 
            // $templateProcessor->setValue('kota',ucfirst(strtolower($kota[1]))); 
        // }else{
            // $templateProcessor->setValue('ket','Kab.'); 
            // $templateProcessor->setValue('kota',ucfirst(strtolower($kota[1]))); 
        // }
        $asdd = $this->db->query("SELECT c_cetak from tmpermohonan where id = $id_daftar")->row_array();
        $asd = $asdd['c_cetak']+1; 

        $this->db->query("UPDATE tmpermohonan set c_cetak = $asd where id = $id_daftar");

        
       $templateProcessor->saveAs('assets/download/Penolakan '.$hasil2['n_perizinan'].' '.time().'.docx');
        redirect('assets/download/Penolakan '.$hasil2['n_perizinan'].' '.time().'.docx');        
       // var_dump($templateProcessor->setValue('ket','Kota'));
        
        //die;
//------------------------------------------------------------------------------------//ALI
    }
    public function cetak_penolakan2($id_daftar = NULL) {
        
        // echo "1&nbsp;1&nbsp1";
        // die;
        
        // die;
//------------------------------------------------------------------------------------//ALI
        $aa = "select * from tmpermohonan_tmperusahaan where tmpermohonan_id ='".$id_daftar."'";
        $hasilz = $this->db->query($aa);
       if($hasilz->num_rows() ==  1){
            $perusahaan = $hasilz->row_array();
            $que = "select * from tmperusahaan where id = '$perusahaan[tmperusahaan_id]'";
            $per = $this->db->query($que)->row_array();
            $que3 = "select * from tmpemohon_tmpermohonan where tmpermohonan_id = '$perusahaan[tmpermohonan_id]'";
            $per3 = $this->db->query($que3)->row_array();
            $que2 = "select * from tmpemohon where id = '$per3[tmpemohon_id]'";
            $per2 = $this->db->query($que2)->row_array();
            $que4 = "select * from tmpermohonan where id = '$perusahaan[tmpermohonan_id]'";
            $per4 = $this->db->query($que4)->row_array();
            
            
            $dataPer1 = "Direktur ".$per['n_perusahaan'];
            $dataPer2 = $per['a_perusahaan'];
            $dataPer3 = "XVII/221/003";
            $dataPer4 = $per4['d_terima_berkas'];
            $dataPer5 = $per4['tanggal_pertimbangan'];
            
            
        }else{
            
            $aa = "select * from tmpemohon_tmpermohonan where tmpermohonan_id ='".$id_daftar."'";
            $hasilz = $this->db->query($aa);
            $perusahaan = $hasilz->row_array();
            $que2 = "select * from tmpemohon where id = '$perusahaan[tmpemohon_id]'";
            $per2 = $this->db->query($que2)->row_array();
            
            $que3 = "select * from tmpermohonan where id = '$perusahaan[tmpermohonan_id]'";
            $per3 = $this->db->query($que3)->row_array();
              $que4 = "select * from tmpermohonan where id = '$perusahaan[tmpermohonan_id]'";
            $per4 = $this->db->query($que4)->row_array();
            
            $dataPer1 = "Bp/Ibu  ".$per2['n_pemohon'];
            $dataPer2 = $per2['a_pemohon'];
            $dataPer3 = "XVII/221/003";
            $dataPer4 = $per4['d_terima_berkas'];
            $dataPer5 = $per4['tanggal_pertimbangan'];
             
          
             
        }

        for ($i=1; $i < 6; $i++) { 
            echo ${"dataPer".$i}."<br>";
        }

        $a = "select * from tmpermohonan where id ='".$id_daftar."'";
        $hasil = $this->db->query($a)->row_array();
        $b = "select * from trperizinan where id = (select trperizinan_id from tmpermohonan_trperizinan where tmpermohonan_id ='".$id_daftar."')";
        $hasil2 = $this->db->query($b)->row_array();
        $c = "select * from trperizinan_template where perizinan_id = (select trperizinan_id from tmpermohonan_trperizinan where tmpermohonan_id ='".$id_daftar."') ";
        $hasil3 = $this->db->query($c)->result();
        $g = "select * from tmsk where id in(select tmsk_id from tmpermohonan_tmsk where tmpermohonan_id ='".$id_daftar."')";
        $hasil7 = $this->db->query($g)->row_array(); 
        $q_alasan = "select * from alasan_penolakan where id_permohonan = '".$id_daftar."'";
        $alasan = $this->db->query($q_alasan)->result(); 
        $kota = "select * from trkabupaten where id in(select trkabupaten_id from trkabupaten_trkecamatan where trkecamatan_id in(select id from trkecamatan where id in(select trkecamatan_id from trkecamatan_trkelurahan where trkelurahan_id in(select id from trkelurahan where id in(select trkelurahan_id from tmpemohon_trkelurahan where tmpemohon_id in(select tmpemohon_id from tmpemohon_tmpermohonan where tmpermohonan_id = (select id from tmpermohonan where id = '".$id_daftar."_Asdasd'))))))) ";
        $sqlkota = $this->db->query($kota)->row_array();        
        // var_dump($hasilz->row_array());
  //       exit();
        require_once 'assets/phpword/src/PhpWord/Autoloader.php';
        \PhpOffice\PhpWord\Autoloader::register();
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('assets/template-baru/penolakan.docx');

        $templateProcessor->setValue("nomor","                 /                     /".$hasil['bidang']);
        
        $templateProcessor->setValue("nama_izin",$hasil2['n_perizinan']);
        $arrBln = array("Januari",'Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
        $tanggal = date("d");
        $bulan = $arrBln[date("n")-1];
        $tahun = date("Y");
        
        $templateProcessor->setValue('tanggal',$tanggal);
        $templateProcessor->setValue('bulan',$bulan);
        $templateProcessor->setValue('tahun',$tahun);
        $templateProcessor->setValue('nama_pemohon',$dataPer1);
        $templateProcessor->setValue('alamat',$dataPer2);
        
        $templateProcessor->setValue('pemohon',$dataPer1);
        $templateProcessor->setValue("nomor1",'      /       /        ');
        $d4 = explode("-", $dataPer4);
        $k = $arrBln[intval($d4[1]-1)];
        $templateProcessor->setValue("tanggal1","$d4[2] $k $d4[0]");
        $templateProcessor->setValue("nomor2"," VII/445/002 ");
        $d5 = explode("-", $dataPer5);
         $k = (intval($d5[1]-1) == -1)?'00':$arrBln[intval($d5[1]-1)];
        $templateProcessor->setValue("tanggal2","$d5[2] $k $d5[0]");
        $templateProcessor->setValue("bidang",$hasil['bidang']);

// //alasan---------------
        $no = 1;
        $templateProcessor->cloneRow('alasan', count($alasan));

        // while($no<=count($hasil4)){
        foreach($alasan as $ha4){

            // $templateProcessor->setValue('N'.$no,$no);
            $templateProcessor->setValue("alasan#".$no,$ha4->alasan);
        
            $no++;
        }
        $no = 1;
        foreach($alasan as $ha4){

            // $templateProcessor->setValue('N'.$no,$no);
            $templateProcessor->setValue("No#".$no,$no);
            
            $no++;
        }
// //end-------------------     

        $asdd = $this->db->query("SELECT c_cetak from tmpermohonan where id = $id_daftar")->row_array();
        $asd = $asdd['c_cetak']+1; 
        $this->db->query("UPDATE tmpermohonan set c_cetak = $asd where id = $id_daftar");
        $templateProcessor->setValue('ttd',$hasil['nama_ttd']);
        $templateProcessor->setValue('nip',$hasil['nip_ttd']);
        $templateProcessor->setValue('pangkat',"Kepala Kepada Bidang");

//         // $kota = explode(' ', $sqlkota['n_kabupaten']);

        // if ($kota[0] == 'KOTA') {
        // $templateProcessor->setValue('wal/bup','Walikota '.ucfirst(strtolower($kota[1])));
        // }else{
        // $templateProcessor->setValue('wal/bup','Bupati '.ucfirst(strtolower($kota[1])));      
        // }

        // if ($kota[0] == 'KOTA'){
            // $templateProcessor->setValue('ket','Kota'); 
            // $templateProcessor->setValue('kota',ucfirst(strtolower($kota[1]))); 
        // }else{
            // $templateProcessor->setValue('ket','Kab.'); 
            // $templateProcessor->setValue('kota',ucfirst(strtolower($kota[1]))); 
        // }

       $templateProcessor->saveAs('assets/download/Penolakan '.$hasil2['n_perizinan'].' '.time().'.docx');
        redirect('assets/download/Penolakan '.$hasil2['n_perizinan'].' '.time().'.docx');        
       // var_dump($templateProcessor->setValue('ket','Kota'));
        
        die;
//------------------------------------------------------------------------------------//ALI
    }
    
}