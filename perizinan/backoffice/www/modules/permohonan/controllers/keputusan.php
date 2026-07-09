<?php

/**
 * Description of Pembuatan Surat Keputusan
 *
 * @author agusnur
 * Dated : 19 Dec 2010
 */

class Keputusan extends WRC_AdminCont {

    public function __construct() {
        parent::__construct();

        $enabled = FALSE;
        $list_auths = $this->session_info['app_list_auth'];
        $this->keputusan = NULL;

        foreach ($list_auths as $list_auth) {
            if($list_auth->id_role === '9' or $list_auth->id_role === '13') {
                $enabled = TRUE;
                $this->keputusan = new tmsurat_keputusan();
            }
        }

        if(!$enabled) {
            redirect('dashboard');
        }
    }

    public function edit($id_daftar = NULL) {
        $permohonan = new tmpermohonan();
        $permohonan = $permohonan->get_by_id($id_daftar);

        $petugas = 1; //1 -> Jabatan Penandatangan
        $perizinan = $permohonan->trperizinan->get();
        $surat_awal = $permohonan->tmsurat_keputusan->get();
        $sts_cetak = 1;
        
        $app_folder = new settings();
        $app_folder->where('name','app_folder')->get();
        $app_folder = $app_folder->value . "/";
        $app_city = new settings();
        $app_city->where('name','app_city')->get();
        $app_city = $app_city->value;
        $app_kan =  $this->settings->where('name', 'app_kantor')->get();
        
        if($surat_awal->id){
        }else{
            /* Input Data */
            $data_id = new tmsurat_keputusan();

            $data_id->select_max('id')->get();
            $data_id->get_by_id($data_id->id);

            $data_tahun = date("Y");
            //Per Tahun Auto Restart NoUrut
            if($permohonan->d_tahun === $data_tahun)
            $data_urut = $data_id->i_urut + 1;
            else $data_urut = 1;

            $data_izin = $perizinan->id;
            $i_izin = strlen($data_izin);
            for($i=3;$i>$i_izin;$i--){
                $data_izin = "0".$data_izin;
            }

            $data_bulan = $this->lib_date->set_month_roman(date("n"));

            $data_sk = "DP";
            $no_surat = $data_urut."/"
                    .$data_sk."/".$data_izin."/"
                    .$data_bulan."/".$data_tahun;
            $surat_sk = new tmsurat_keputusan();
            $surat_sk->c_status = $sts_cetak;
            $surat_sk->i_urut = $data_urut;
            $surat_sk->no_surat = $no_surat;
            $tgl_skr = $this->lib_date->get_date_now();
            $surat_sk->tgl_surat = $tgl_skr;
            $surat_sk->c_cetak = 1;

            $pemohon = $permohonan->tmpemohon->get();
            $perusahaan = $permohonan->tmperusahaan->get();
            $surat_sk->ket1 = "Pemohon";
            $surat_sk->nama1 = $pemohon->n_pemohon;
            $surat_sk->alamat1 = $pemohon->a_pemohon;
            $surat_sk->ket2 = "Perusahaan";
            $surat_sk->nama2 = $perusahaan->n_perusahaan;
            $surat_sk->alamat2 = $perusahaan->a_perusahaan;
            $nama_izin = $perizinan->n_perizinan;
            $badan = strtolower($app_kan->value);
            $surat_sk->content1 = $nama_izin.' ini berlaku sejak ditetapkan sampai dengan tanggal '.$this->lib_date->mysql_to_human($this->lib_date->set_date($tgl_skr, (365*$perizinan->v_berlaku_tahun))).' dan izin pembaharuan diajukan kepada Kepala '.ucwords($badan).' selambat-lambatnya 3 (tiga) bulan sebelum habis masa berlakunya keputusan ini.';
            $surat_sk->content2 = $nama_izin.' ini dapat dicabut untuk selama-lamanya bila pelaksanaannya tidak sesuai dengan ketentuan peraturan perundang-undangan yang berlaku;';
            $surat_sk->content3 = 'Keputusan ini berlaku sejak tanggal ditetapkan.';

            /* Input Relasi Tabel*/
            $pegawai = new tmpegawai();
            $pegawai->where('status', $petugas)->get();
            $perizinan = $permohonan->trperizinan->get();
            $permohonan->d_berlaku_keputusan = $this->lib_date->set_date($tgl_skr, 365); //per tahun
            $permohonan->save();

            $surat_sk->save(array($permohonan, $pegawai));
        }

        $surat = $permohonan->tmsurat_keputusan->get();
        $save = "update";
        $data['save_method'] = $save;
        $data['daftar'] = $permohonan;
        $data['id_daftar'] = $permohonan->id;
        $data['id_surat'] = $surat->id;
        $data['no_surat'] = $surat->no_surat;
        $data['sts_surat'] = $surat->c_status;
        $data['tgl_surat'] = $surat->tgl_surat;
        $data['ket1'] = $surat->ket1;
        $data['nama1'] = $surat->nama1;
        $data['alamat1'] = $surat->alamat1;
        $data['ket2'] = $surat->ket2;
        $data['nama2'] = $surat->nama2;
        $data['alamat2'] = $surat->alamat2;
		$data['memperhatikan1'] = $surat->memperhatikan1;
		$data['memperhatikan2'] = $surat->memperhatikan2;
		$data['memperhatikan3'] = $surat->memperhatikan3;
        $data['content1'] = $surat->content1;
        $data['content2'] = $surat->content2;
        $data['content3'] = $surat->content3;
        $data['content4'] = $surat->content4;
        $data['content5'] = $surat->content5;
        $data['content6'] = $surat->content6;
        $data['content7'] = $surat->content7;
        $data['content8'] = $surat->content8;
		$data['content9'] = $surat->content9;
        $data['content10'] = $surat->content10;
        $data['salinan1'] = $surat->salinan1;
        $data['salinan2'] = $surat->salinan2;
        $data['salinan3'] = $surat->salinan3;
        $data['salinan4'] = $surat->salinan4;
        $data['salinan5'] = $surat->salinan5;
		$data['salinan6'] = $surat->salinan6;
        $data['salinan7'] = $surat->salinan7;
        $data['salinan8'] = $surat->salinan8;
        $data['salinan9'] = $surat->salinan9;
        $data['salinan10'] = $surat->salinan10;

        $js =  "$(function() {
                    $(\"#inputTanggal\").datepicker({
                        changeMonth: true,
                        changeYear: true,
                        dateFormat: 'yy-mm-dd',
                        closeText: 'X'
                    });
                });
                var base_url = '". base_url() ."';
                $(document).ready(function() {
                    $('#form').validate();
                    $(\"#tabs\").tabs();
                } );
            ";

        $this->template->set_metadata_javascript($js);

        $this->load->vars($data);
        $this->session_info['page_name'] = "Data Pembuatan SK";
        $this->template->build('keputusan_edit', $this->session_info);
    }

    public function update() {
        $surat_awal = new tmsurat_keputusan();
        $surat_awal->get_by_id($this->input->post('id_surat'));
        $permohonan = new tmpermohonan();
        $permohonan->get_by_id($this->input->post('id_daftar'));
        $perizinan = $permohonan->trperizinan->get();
        $nama_izin = $perizinan->n_perizinan;
        
        $app_folder = new settings();
        $app_folder->where('name','app_folder')->get();
        $app_folder = $app_folder->value . "/";
        $app_city = new settings();
        $app_city->where('name','app_city')->get();
        $app_city = $app_city->value;
        $app_kan =  $this->settings->where('name', 'app_kantor')->get();
        
        $surat = new tmsurat_keputusan();
        $surat->get_by_id($this->input->post('id_surat'));
        $surat->no_surat = $this->input->post('no_surat');
        $surat->tgl_surat = $this->input->post('tgl_surat');
        $surat->ket1 = $this->input->post('ket1');
        $surat->nama1 = $this->input->post('nama1');
        $surat->alamat1 = $this->input->post('alamat1');
        $surat->ket2 = $this->input->post('ket2');
        $surat->nama2 = $this->input->post('nama2');
        $surat->alamat2 = $this->input->post('alamat2');
		$surat->memperhatikan1 = $this->input->post('memperhatikan1');
		$surat->memperhatikan2 = $this->input->post('memperhatikan2');
		$surat->memperhatikan3 = $this->input->post('memperhatikan3');

        $badan = strtolower($app_kan->value);
        if($surat_awal->tgl_surat == $this->input->post('tgl_surat'))
        $surat->content1 = $this->input->post('content1');
        else
        $surat->content1 = $nama_izin.' ini berlaku sejak ditetapkan sampai dengan tanggal '.$this->lib_date->mysql_to_human($this->lib_date->set_date($this->input->post('tgl_surat'), (365*$perizinan->v_berlaku_tahun))).' dan izin pembaharuan diajukan kepada Kepala '.ucwords($badan).' selambat-lambatnya 3 (tiga) bulan sebelum habis masa berlakunya keputusan ini.';
        $surat->content2 = $this->input->post('content2');
        $surat->content3 = $this->input->post('content3');
		$surat->content4 = $this->input->post('content4');
        $surat->content5 = $this->input->post('content5');
		$surat->content6 = $this->input->post('content6');
        $surat->content7 = $this->input->post('content7');
		$surat->content8 = $this->input->post('content8');
        $surat->content9 = $this->input->post('content9');
		$surat->content10 = $this->input->post('content10');
        $surat->salinan1 = $this->input->post('salinan1');
        $surat->salinan2 = $this->input->post('salinan2');
        $surat->salinan3 = $this->input->post('salinan3');
        $surat->salinan4 = $this->input->post('salinan4');
        $surat->salinan5 = $this->input->post('salinan5');
   	    $surat->salinan6 = $this->input->post('salinan6');
        $surat->salinan7 = $this->input->post('salinan7');
        $surat->salinan8 = $this->input->post('salinan8');
        $surat->salinan9 = $this->input->post('salinan9');
        $surat->salinan10 = $this->input->post('salinan10');

        $permohonan->d_berlaku_keputusan = $this->lib_date->set_date($this->input->post('tgl_surat'), 365); //per tahun
        $permohonan->save();

       $tgl = date("Y-m-d H:i:s");
       $u_ser = $this->session->userdata('username');
       $g = $this->sql($u_ser);
//     $jam = date("H:i:s A");
       //$p = $this->db->query("call log ('Pembuatan Izin','Update ".$permohonan->pendaftaran_id."','".$tgl."','".$u_ser."')");

        $update = $surat->save();
        if($update) {
            redirect('permohonan/sk');
        }
    }

	public function cetak($id_daftar = NULL,$template = NULL) {
	
        $app_folder = new settings();
        $app_folder->where('name','app_folder')->get();
        $app_folder = $app_folder->value . "/";
        $app_city = new settings();
        $app_city->where('name','app_city')->get();
        $app_city = $app_city->value;
        $app_kan =  $this->settings->where('name', 'app_kantor')->get();

        $petugas = 1; //1 -> Jabatan Penandatangan
        $permohonan = new tmpermohonan();
        $permohonan->get_by_id($id_daftar);
		$pendaftaran_id = $permohonan->pendaftaran_id;
        $perizinan = $permohonan->trperizinan->get();
        $surat_awal = $permohonan->tmsurat_keputusan->get();

		$ambil_kode_tmsk = new tmpermohonan_tmsk();
        $ambil_kode_tmsk->where('tmpermohonan_id',$permohonan->id)->get();
		$ambil_kode_tmsk = $ambil_kode_tmsk->tmsk_id;

        $this->tr_instansi = new Tr_instansi();
        $nama_bdan = $this->tr_instansi->get_by_id(9);
        $badan = strtolower($app_kan->value);
        if($surat_awal->id){ // jika sudah ada 
            $surat_sk = new tmsurat_keputusan();
            $surat_sk->get_by_id($surat_awal->id);
            $surat_sk->c_status = $sts_cetak;
            $tgl_skr = $this->lib_date->get_date_now();
            $surat_sk->tgl_surat = $tgl_skr;
            $surat_sk->save();
            $pegawai = new tmpegawai();
            $pegawai->where('status', $petugas)->get();

            /* Input Relasi Tabel*/
            $perizinan = $permohonan->trperizinan->get();
            $permohonan->d_berlaku_keputusan = $this->lib_date->set_date($tgl_skr, 365);
			$permohonan->kd_status = 7; // ubah kd_status menjadi 7 untuk proses selanjutnya (izin siap diserahkan)
            $permohonan->save();
        }else{   // jika pertama kali Mencetak 
			$data_id = new tmsurat_keputusan();
            $data_id->select_max('id')->get();
            $data_id->get_by_id($data_id->id);

            $data_tahun = date("Y");

			//Per Tahun Auto Restart NoUrut
            if($permohonan->d_tahun === $data_tahun)
                $data_urut = $data_id->i_urut + 1;
            else 
				$data_urut = 1;

            $i_urut = strlen($data_urut);
            for($i=4;$i>$i_urut;$i--){
                $data_urut = "0".$data_urut;
            }

            $data_izin = $perizinan->id;
            $i_izin = strlen($data_izin);
            for($i=3;$i>$i_izin;$i--){
                $data_izin = "0".$data_izin;
            }

            $data_bulan = $this->lib_date->set_month_roman(date("n"));

            $data_sk = "DP";
            $no_surat = $data_urut."/".$data_sk."/".$data_izin."/".$data_bulan."/".$data_tahun;
            $surat_sk = new tmsurat_keputusan();
            $surat_sk->c_status = $sts_cetak;
            $surat_sk->i_urut = $data_urut;
            $surat_sk->no_surat = $no_surat;
            $tgl_skr = $this->lib_date->get_date_now();
            $surat_sk->tgl_surat = $tgl_skr;
            $surat_sk->c_cetak = 1;

            $pemohon = $permohonan->tmpemohon->get();
            $perusahaan = $permohonan->tmperusahaan->get();
            $surat_sk->ket1 = "Pemohon";
            $surat_sk->nama1 = $pemohon->n_pemohon;
            $surat_sk->alamat1 = $pemohon->a_pemohon;
            $surat_sk->ket2 = "Perusahaan";
            $surat_sk->nama2 = $perusahaan->n_perusahaan;
            $surat_sk->alamat2 = $perusahaan->a_perusahaan;
            $nama_izin = $perizinan->n_perizinan;
            $surat_sk->content1 = $nama_izin.' ini berlaku sejak ditetapkan sampai dengan tanggal '.$this->lib_date->mysql_to_human($this->lib_date->set_date($tgl_skr, (365*$perizinan->v_berlaku_tahun))).' dan izin pembaharuan diajukan kepada Kepala '.ucwords($badan).' selambat-lambatnya 3 (tiga) bulan sebelum habis masa berlakunya keputusan ini.';
            $surat_sk->content2 = $nama_izin.' ini dapat dicabut untuk selama-lamanya bila pelaksanaannya tidak sesuai dengan ketentuan peraturan perundang-undangan yang berlaku;';
            $surat_sk->content3 = 'Keputusan ini berlaku sejak tanggal ditetapkan.';

            /* Input Relasi Tabel*/
            $pegawai = new tmpegawai();
            $pegawai->where('status', $petugas)->get();
            $perizinan = $permohonan->trperizinan->get();
            $permohonan->d_berlaku_keputusan = $this->lib_date->set_date($tgl_skr, 365); //per tahun
			$permohonan->kd_status = 7; // ubah kd_status menjadi 7 untuk proses selanjutnya (izin siap diserahkan)
            $permohonan->save();
            
            $surat_sk->save(array($permohonan, $pegawai));
        }

        //Status cetak SK
		$sk = new tmsk();
		$sk->get_by_id($ambil_kode_tmsk);
        $sk->c_cetak = $surat_awal->c_cetak + 1;
        $sk->save();

        $sk = new tmsurat_keputusan();
        $sk->get_by_id($surat_awal->id);
        $sk->c_cetak = $surat_awal->c_cetak + 1;
        $sk->save();
		// EOF() Status cetak SK

        
		// Area Pencetakan

		// EOF() Area Pencetakan

		$tgl = date("Y-m-d H:i:s");
        $u_ser = $this->session->userdata('username');
        $g = $this->sql($u_ser);
//      $jam = date("H:i:s A");
        //$p = $this->db->query("call log ('Pembuatan Izin','Cetak SK ".$permohonan->pendaftaran_id."','".$tgl."','".$u_ser."')");

		// redirect('assets/download/'.$redirect.'.docx');
		if($template==0){
			redirect('permohonan/sk/');
		}
		
		if($template == 1 || $template == 2){
			$this->cetak_sk($id_daftar,$template);
		}
}
	
    public function cetak_sk($id_daftar = NULL, $jenis = NULL) {
       if($id_daftar != null){
        $a = "select * from tmpegawai where status = '1'";
        $hasil = $this->db->query($a)->row_array();
         $a22 = "select * from tmpermohonan where id ='".$id_daftar."'";
        
        $hasil22 = $this->db->query($a22)->row_array();
        $b = "select * from trperizinan where id = (select trperizinan_id from tmpermohonan_trperizinan where tmpermohonan_id ='".$id_daftar."')";
        $hasil2 = $this->db->query($b)->row_array();
		
		$string3 = "select * from trperizinan_template where perizinan_id = (select trperizinan_id from tmpermohonan_trperizinan where tmpermohonan_id ='".$id_daftar."') ";
		if($jenis == 2){
			$string3 = "select * from trperizinan_template_gub where perizinan_id = (select trperizinan_id from tmpermohonan_trperizinan where tmpermohonan_id ='".$id_daftar."') ";
		}
		
        $c = $string3;
        $hasil3 = $this->db->query($c)->result();
        
		$d = "select * from trmengingat where id in(select trmengingat_id from trmengingat_trperizinan where trperizinan_id ='".$hasil2['id']."') order by jenis,nomor,tahun asc";
        $hasil4 = $this->db->query($d)->result();
        $e = "select * from trmenimbang where id in(select trmenimbang_id from trmenimbang_trperizinan where trperizinan_id ='".$hasil2['id']."')";
        $hasil5 = $this->db->query($e)->result();
        $f = "select * from trmemperhatikan where id in(select trmemperhatikan_id from trmemperhatikan_trperizinan where trperizinan_id ='".$hasil2['id']."')";
        $hasil6 = $this->db->query($f)->result();        
        $g = "select * from tmsk where id in(select tmsk_id from tmpermohonan_tmsk where tmpermohonan_id ='".$id_daftar."')";
        $hasil7 = $this->db->query($g)->row_array(); 

        $kota = "select * from trkabupaten where id in(select trkabupaten_id from trkabupaten_trkecamatan where trkecamatan_id in(select id from trkecamatan where id in(select trkecamatan_id from trkecamatan_trkelurahan where trkelurahan_id in(select id from trkelurahan where id in(select trkelurahan_id from tmpemohon_trkelurahan where tmpemohon_id in(select tmpemohon_id from tmpemohon_tmpermohonan where tmpermohonan_id = (select id from tmpermohonan where id = '".$id_daftar."'))))))) ";
        $sqlkota = $this->db->query($kota)->row_array();
//--    
        // Including all required classes
        require_once('assets/barcode_file/class/BCGFontFile.php');
        require_once('assets/barcode_file/class/BCGColor.php');
        require_once('assets/barcode_file/class/BCGDrawing.php');

        // Including the barcode technology
        require_once('assets/barcode_file/class/BCGcode39.barcode.php');

        // Loading Font
        $font = new BCGFontFile('assets/barcode_file/font/Arial.ttf', 10);
        //die;
        // Don't forget to sanitize user inputs
        $text = $hasil7['no_surat'];

        // The arguments are R, G, B for color.
        $color_black = new BCGColor(0, 0, 0);
        $color_white = new BCGColor(255, 255, 255);

        $drawException = null;
        try {
            $code = new BCGcode39();
            $code->setScale(1); 
            $code->setThickness(50); 
            $code->setForegroundColor($color_black); 
            $code->setBackgroundColor($color_white);
            $code->setFont(0); // Font (or 0)
            $code->parse($text); 
        } catch(Exception $exception) {
            $drawException = $exception;
        }

        $drawing = new BCGDrawing('assets/barcode/'.$hasil22['pendaftaran_id'].'.png', $color_white);
        if($drawException) {
            $drawing->drawException($drawException);
        } else {
            $drawing->setBarcode($code);
            $drawing->draw();
        }

        // Draw (or save) the image into PNG format.
        $drawing->finish(BCGDrawing::IMG_FORMAT_PNG);
//--            

        require_once 'assets/phpword/src/PhpWord/Autoloader.php';
        \PhpOffice\PhpWord\Autoloader::register();
        if($jenis==1){
			$templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('assets/template-baru/'.$hasil2['template']);
		}
		if($jenis==2){
			$templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('assets/template-baru/'.$hasil2['template_gub']);
		}
        // $replace = base_url()."assets/barcode/".$hasil['pendaftaran_id'].".png";
        // $templateProcessor->setValue('barcode',base_url().'assets/barcode/'.$hasil['pendaftaran_id'].'.png');
        $templateProcessor->setImageValue($templateProcessor->getImgFileName($templateProcessor->seachImagerId("image1.png")),''.base_url().'assets/barcode/0005807801062015001.png');
        $templateProcessor->setImageValue('image1.png','assets/barcode/'.$hasil22['pendaftaran_id'].'.png');
        $templateProcessor->setValue("namaizin",$hasil2['n_perizinan']);
        $templateProcessor->setValue("nomor",$hasil7['no_surat']);
	$arrblnRomawi = array("I","II","III","IV","V","VI",'VII','VIII','IX','X','XI','XII');
	$blnRomawi = $arrblnRomawi[date("m")-1];
	$templateProcessor->setValue("bulanromawi",$blnRomawi);
       	$templateProcessor->setValue("tahunini",date("Y"));
        ############################################
        #                                          #
        #   NEW QUERY PEMOHON DAN PERUSAHAAN       #
        #                                          #
        ############################################
        $qqq = "select * from tmpemohon where id = (select tmpemohon_id from tmpemohon_tmpermohonan where tmpermohonan_id = '".$id_daftar."')";
        $dt_pemohon = $this->db->query($qqq)->row_array();
        $qqq2 = "select * from tmperusahaan where id = (select tmperusahaan_id from tmpermohonan_tmperusahaan where tmpermohonan_id = '".$id_daftar."')";
        $dt_pemohon2 = $this->db->query($qqq2)->row_array();
        $bulanArr = array("Januari",'Februari',"Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
        $expl = explode("-",$hasil22["d_terima_berkas"]);
        $blnIndo = "$expl[2] ".$bulanArr[$expl[1]-1]." $expl[0]";
        if(count($dt_pemohon2) > 0){
            $templateProcessor->setValue("nperusahaan",$dt_pemohon2['n_perusahaan']);
        }
        else{
            $templateProcessor->setValue("nperusahaan",$dt_pemohon['n_pemohon']);
        }

       
        $templateProcessor->setValue("nopendaftaran",$hasil22['pendaftaran_id']);
        $templateProcessor->setValue("npemohon",$dt_pemohon['n_pemohon']);
        $templateProcessor->setValue("tgl_daftar",$blnIndo);
	    
		
		$no_sk = $hasil7['no_surat_edit'];
        $tgl_sk = $hasil7['tgl_surat_edit'];
		if($no_sk == "") {
            $no_sk = $p_sk->no_surat;
			$tgl_sk = $p_sk->tgl_surat;
        }
		$templateProcessor->setValue("nosk",$no_sk);
		$templateProcessor->setValue("tglsk",$this->lib_date->mysql_to_human($tgl_sk));

        ############################################
        #                                          #
        # END OF NEW QUERY PEMOHON DAN PERUSAHAAN  #
        #                                          #
        ############################################
//menimbang--------------
  function docx2text($filename) {
      
            return readZippedXML($filename, "word/document.xml");
            }
        $tulis_nama = array();
        $tulis_variable = array();
        function readZippedXML($archiveFile, $dataFile) {
                    $zip = new ZipArchive;
                    if (true === $zip->open($archiveFile)) {
                    if (($index = $zip->locateName($dataFile)) !== false) {
                    $data = $zip->getFromIndex($index);
                    $zip->close();
                    $xml = new DOMDocument();
                    $xml->loadXML($data, LIBXML_NOENT | LIBXML_XINCLUDE | LIBXML_NOERROR | LIBXML_NOWARNING);
                    return strip_tags($xml->saveXML());
                            }
                    $zip->close();
                        }
                    return "";
                    }
      if($jenis==1){
        $text = docx2text('assets/template-baru/'.$hasil2['template']);
      }
      if($jenis==2){
        $text = docx2text('assets/template-baru/'.$hasil2['template_gub']);
      }

                    $texts = explode(" ", $text);
                    $output = array();
                  $output2 = array();
        $output3 = array();
                    foreach($texts as $t) {
                    if(strpos($t, '${menimbang}') !== false) {
                      $output[] = $t;
                    }
        if(strpos($t, '${mengingat}') !== false) {
                      $output2[] = $t;
                    }
      if(strpos($t, '${memperhatikan}') !== false) {
                        $output3[] = $t;
                        }

                    }
          
//menimbang--------------
  if(count($output) > 0){
      
  $no = 1;
        if(count($hasil5) > 0){
        $templateProcessor->cloneRow('menimbang', count($hasil5));
  
        // while($no<=count($hasil4)){
        foreach($hasil5 as $ha5){

            // $templateProcessor->setValue('N'.$no,$no);
            $templateProcessor->setValue("menimbang#".$no,$ha5->deskripsi);
        
            $no++;
        }
        $no = 1;
        foreach($hasil5 as $ha5){

            // $templateProcessor->setValue('N'.$no,$no);
            $templateProcessor->setValue("No1#".$no,$no);
        
            $no++;
        }
        }else{
            $templateProcessor->setValue("menimbang","");
            $templateProcessor->setValue("No1","");
        }
}

//end---------------------

//mengingat---------------
  if(count($output2) > 0){
        $no = 1;
        if(count($hasil4) > 0){
        $templateProcessor->cloneRow('mengingat', count($hasil4));

        // while($no<=count($hasil4)){
        foreach($hasil4 as $ha4){

            // $templateProcessor->setValue('N'.$no,$no);
            $templateProcessor->setValue("mengingat#".$no,$ha4->deskripsi);
        
            $no++;
        }
        $no = 1;
        foreach($hasil4 as $ha4){

            // $templateProcessor->setValue('N'.$no,$no);
            $templateProcessor->setValue("No2#".$no,$no);
        
            $no++;
        }
        }
        else{
            $templateProcessor->setValue("mengingat","");
            $templateProcessor->setValue("No2","");
        }
}
//end-------------------     
  
//memperhatikan---------------
if(count($output3) > 0){ 
       $no = 1;

        if(count($hasil6) > 0){
        $templateProcessor->cloneRow('memperhatikan', count($hasil6));
    

        // while($no<=count($hasil4)){
        foreach($hasil6 as $ha6){

            // $templateProcessor->setValue('N'.$no,$no);
            $templateProcessor->setValue("memperhatikan#".$no,$ha6->deskripsi);
        
            $no++;
        }

        $no = 1;
        foreach($hasil6 as $ha6){

            // $templateProcessor->setValue('N'.$no,$no);
            $templateProcessor->setValue("No3#".$no,$no);
        
            $no++;
        }
        }else{
             $templateProcessor->setValue("memperhatikan","");
              $templateProcessor->setValue("No3","");
        }
        }
        $cx = $this->db->query("SELECT * from revisi where id_permohonan = $id_daftar order by tgl_revisi desc limit 1")->row_array();
        $cxv = $this->db->query("SELECT * from revisi where id_permohonan = $id_daftar order by tgl_revisi desc")->result();
        $cx3 = count($cxv);
        $blnID = array("Januari","Februari","Maret",'April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'); 
        if($cx3 == 0){
            $templateProcessor->setValue("text_atas"," ");
            $templateProcessor->setValue("text_alasan1"," ");
            $templateProcessor->setValue("text_alasan2"," ");
            $templateProcessor->setValue("No4"," ");
            $templateProcessor->setValue("t1"," ");
            $templateProcessor->setValue("t2"," ");
            $templateProcessor->setValue("t3"," ");
            $templateProcessor->setValue("t4"," ");
            $templateProcessor->setValue("t5"," ");
            // $templateProcessor->cloneRow('No5', " ");
            $templateProcessor->setValue("No5"," ");
                    $templateProcessor->setValue("prop"," ");
                    $templateProcessor->setValue("dari", " ");
                    $templateProcessor->setValue("menjadi"," ");
                    $templateProcessor->setValue("tgl_berubah"," ");
        }else{
            $arr1 = array();
            $arr2 = array();
        foreach ($cxv as $key) {
            $arr1[] = $key->id;
            $arr2[$key->id] = $key->tgl_revisi; 
            // var_dump($key);
            // echo "<br>";
        }
        // die;
        $many1 = implode(",", $arr1);
        $cx2 = $this->db->query("SELECT * FROM detail_revisi where id_revisi in($many1) order by data asc,id asc");
        $cx4 = $cx2->result();
        
        // $ttg = explode(" ", $cxv['tgl_revisi']);
        // $ttg2 = explode("-",$ttg[0]);
        // $bulan11 = $blnID[$ttg2[1]-1];
            $templateProcessor->setValue("text_atas"," ");
            $templateProcessor->setValue("text_alasan1","(Catatan perubahan) : ");
            $templateProcessor->setValue("text_alasan2","");
            $templateProcessor->setValue("No4"," ");
            $templateProcessor->setValue("t1","No.");
            $templateProcessor->setValue("t2","Properti");
            $templateProcessor->setValue("t3","Semula");
            $templateProcessor->setValue("t4","Menjadi");
            $templateProcessor->setValue("t5","Tanggal Berubah");
            $templateProcessor->cloneRow('No5', count($cx4));
            $u = 1;

                foreach($cx4 as $cc){
                    $wa = explode(" ",$arr2[$cc->id_revisi]);
                    
                    $templateProcessor->setValue("No5#".$u,"$u");
                    $templateProcessor->setValue("prop#".$u,$cc->data);
                    $templateProcessor->setValue("dari#".$u, $cc->asal);
                    $templateProcessor->setValue("menjadi#".$u,$cc->jadi);
                    $templateProcessor->setValue("tgl_berubah#".$u,$wa[0]);

                    $u++;
                }
            //var_dump($cx3);
        }
        
        //exit();
//end-------------------       
        foreach ($hasil3 as $data) {



        $tek = "var_teknis".$data->urutan_vars_teknis;
	$prop = $hasil2[$tek];
        if(empty($prop)){
                break;
                }
        $array = explode("^",$prop);   

        //echo $array[1];
        //echo " : ";
        $tek2 = "dt_teknis".$data->urutan_vars_teknis;
        $prop2 = $hasil22[$tek2];
        if(empty($prop)){
                break;
                }
        $array2 = explode("^",$prop2);   
        //echo $array2[1];
        if($data->t_value == "v_pokja"){
            $data->t_value = "v_tanggalpertek2";
        }
	if(strtotime($array2[1])){
		$bulanArr = array("Jaruari",'Februari',"Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
       		$expl = explode("-",$array2[1]);
        	$array2[1] = "$expl[2] ".$bulanArr[$expl[1]-1]." $expl[0]";
	  }
        //echo "-> $data->t_value <br>";
	//echo "$data->t_value : $array2[1]";
        $templateProcessor->setValue($data->t_nama,$array[1]);
        $templateProcessor->setValue($data->t_value,$array2[1]);

        }
        $templateProcessor->setValue('ttd',$hasil['n_pegawai']);
        $templateProcessor->setValue('nip',$hasil['nip']);
        $templateProcessor->setValue('jabatan',$hasil['n_jabatan']);
	
        $kota = explode(' ', $sqlkota['n_kabupaten']);

        if ($kota[0] == 'KOTA') {
        $templateProcessor->setValue('wal/bup','Walikota '.ucfirst(strtolower($kota[1])));
        }else{
        $templateProcessor->setValue('wal/bup','Bupati '.ucfirst(strtolower($kota[1])));      
        }

        if ($kota[0] == 'KOTA'){
            $templateProcessor->setValue('ket','Kota'); 
            $templateProcessor->setValue('kota',ucfirst(strtolower($kota[1]))); 
        }else{
            $templateProcessor->setValue('ket','Kab.'); 
            $templateProcessor->setValue('kota',ucfirst(strtolower($kota[1]))); 
        }

		$redirect = $hasil2['n_perizinan'].' '.time();
		$templateProcessor->saveAs('assets/download/'.$redirect.'.docx');

        // redirect('assets/download/'.$hasil2['n_perizinan'].' '.time().'.docx');        
        
		redirect('assets/download/'.$redirect.'.docx');

        }
}
   
   public function cetak_OLD($id_daftar = NULL) {
        $app_folder = new settings();
        $app_folder->where('name','app_folder')->get();
        $app_folder = $app_folder->value . "/";
        $app_city = new settings();
        $app_city->where('name','app_city')->get();
        $app_city = $app_city->value;
        $app_kan =  $this->settings->where('name', 'app_kantor')->get();

        $petugas = 1; //1 -> Jabatan Penandatangan
        $permohonan = new tmpermohonan();
        $permohonan->get_by_id($id_daftar);
		$pendaftaran_id = $permohonan->pendaftaran_id;
        $perizinan = $permohonan->trperizinan->get();
        $surat_awal = $permohonan->tmsurat_keputusan->get();
        // PBS Create
		$ambil_kode_tmsk = new tmpermohonan_tmsk();
        $ambil_kode_tmsk->where('tmpermohonan_id',$permohonan->id)->get();
		$ambil_kode_tmsk = $ambil_kode_tmsk->tmsk_id;
        // EOF
        $sts_cetak = 1;
        
        $kode_izin = $pendaftaran_id;
   	    $kode_izin = substr($kode_izin, 5, 3);
		$nama_surat = "cetak_keputusan";
		switch ($kode_izin) {
            case  71; $nama_surat = "cetak_keputusan_ispt";  break; // untuk ISPT Didalam Rumija
		    case 145; $nama_surat = "cetak_keputusan_ispt2";  break; // untuk ISPT Diluar Rumija
            case 91; $nama_surat = "cetak_keputusan_kartupengawasan";
			case 89; $nama_surat = "cetak_keputusan_izintrayek";
		}
        $this->tr_instansi = new Tr_instansi();
        $nama_bdan = $this->tr_instansi->get_by_id(9);
        $badan = strtolower($app_kan->value);
        if($surat_awal->id){
            $surat_sk = new tmsurat_keputusan();
            $surat_sk->get_by_id($surat_awal->id);
            $surat_sk->c_status = $sts_cetak;
            $tgl_skr = $this->lib_date->get_date_now();
            $surat_sk->tgl_surat = $tgl_skr;
            $surat_sk->save();
            $pegawai = new tmpegawai();
            $pegawai->where('status', $petugas)->get();

            /* Input Relasi Tabel*/
            $perizinan = $permohonan->trperizinan->get();
            $permohonan->d_berlaku_keputusan = $this->lib_date->set_date($tgl_skr, 365);
            $permohonan->save();
			$coba = 'True';
        }else{
			$coba = 'False';
            /* Input Data */
            $data_id = new tmsurat_keputusan();

            $data_id->select_max('id')->get();
            $data_id->get_by_id($data_id->id);

            $data_tahun = date("Y");
            //Per Tahun Auto Restart NoUrut
            if($permohonan->d_tahun === $data_tahun)
            $data_urut = $data_id->i_urut + 1;
            else $data_urut = 1;

            $i_urut = strlen($data_urut);
            for($i=4;$i>$i_urut;$i--){
                $data_urut = "0".$data_urut;
            }

            $data_izin = $perizinan->id;
            $i_izin = strlen($data_izin);
            for($i=3;$i>$i_izin;$i--){
                $data_izin = "0".$data_izin;
            }

            $data_bulan = $this->lib_date->set_month_roman(date("n"));

            $data_sk = "DP";
            $no_surat = $data_urut."/"
                    .$data_sk."/".$data_izin."/"
                    .$data_bulan."/".$data_tahun;
            $surat_sk = new tmsurat_keputusan();
            $surat_sk->c_status = $sts_cetak;
            $surat_sk->i_urut = $data_urut;
            $surat_sk->no_surat = $no_surat;
            $tgl_skr = $this->lib_date->get_date_now();
            $surat_sk->tgl_surat = $tgl_skr;
            $surat_sk->c_cetak = 1;

            $pemohon = $permohonan->tmpemohon->get();
            $perusahaan = $permohonan->tmperusahaan->get();
            $surat_sk->ket1 = "Pemohon";
            $surat_sk->nama1 = $pemohon->n_pemohon;
            $surat_sk->alamat1 = $pemohon->a_pemohon;
            $surat_sk->ket2 = "Perusahaan";
            $surat_sk->nama2 = $perusahaan->n_perusahaan;
            $surat_sk->alamat2 = $perusahaan->a_perusahaan;
            $nama_izin = $perizinan->n_perizinan;
            $surat_sk->content1 = $nama_izin.' ini berlaku sejak ditetapkan sampai dengan tanggal '.$this->lib_date->mysql_to_human($this->lib_date->set_date($tgl_skr, (365*$perizinan->v_berlaku_tahun))).' dan izin pembaharuan diajukan kepada Kepala '.ucwords($badan).' selambat-lambatnya 3 (tiga) bulan sebelum habis masa berlakunya keputusan ini.';
            $surat_sk->content2 = $nama_izin.' ini dapat dicabut untuk selama-lamanya bila pelaksanaannya tidak sesuai dengan ketentuan peraturan perundang-undangan yang berlaku;';
            $surat_sk->content3 = 'Keputusan ini berlaku sejak tanggal ditetapkan.';

            /* Input Relasi Tabel*/
            $pegawai = new tmpegawai();
            $pegawai->where('status', $petugas)->get();
            $perizinan = $permohonan->trperizinan->get();
            $permohonan->d_berlaku_keputusan = $this->lib_date->set_date($tgl_skr, 365); //per tahun
            $permohonan->save();
            
            $surat_sk->save(array($permohonan, $pegawai));
        }

        //Status cetak SK
		$sk = new tmsk();
//        $sk->get_by_id($surat_awal->id);           OLD KOMINFO
		$sk->get_by_id($ambil_kode_tmsk);
        $sk->c_cetak = $surat_awal->c_cetak + 1;
        $sk->save();

        $sk = new tmsurat_keputusan();
        $sk->get_by_id($surat_awal->id);
        $sk->c_cetak = $surat_awal->c_cetak + 1;
        $sk->save();

        $surat = $permohonan->tmsurat_keputusan->get();
        $pemohon = $permohonan->tmpemohon->get();
        $jenis_izin = $permohonan->trperizinan->get();
        //$petugas = $surat->tmpegawai->get();

//sahal
//        $this->_barcode('00060/94/01/09/2010', '105');

        $color_black = new BCGColor(0, 0, 0);
        $color_white = new BCGColor(255, 255, 255);
        $code = new BCGcode128();
        $code->setThickness(25);
        $code->setForegroundColor($color_black); // Color of bars
        $code->setBackgroundColor($color_white); // Color of spaces
        $code->parse($pendaftaran_id); // Text
        $drawing = new BCGDrawing('assets/barcode/' . $id_daftar . '.png', $color_white);
        $drawing->setBarcode($code);
        $drawing->draw();
        $drawing->finish(BCGDrawing::IMG_FORMAT_PNG);
//sahal	

        //path of the template file
        $this->load->plugin('odf');
        $odf = new odf('assets/odt/'.$nama_surat.'.odt');
//        $odf->setImage('header', 'assets/css/'.$app_folder.'/images/dinas_1.jpg', '17.5', '3.5');
        $odf->setVars ('ttd', '');

        //logo
        $this->tr_instansi = new Tr_instansi();
        $logo = $this->tr_instansi->get_by_id(23);
        if ($logo->value !== "") {
            $odf->setImage('logo', 'uploads/logo/' . $logo->value, '2.1', '2.5');
        } else {
            $odf->setVars('logo', ' ');
        }

        //pemerintah 
        $this->tr_instansi = new Tr_instansi();
        $nama_prov = $this->tr_instansi->get_by_id(17);
        $odf->setVars('provinsi', strtoupper($nama_prov->value));

		//provinsi 
        $this->tr_instansi = new Tr_instansi();
        $nama_prov1 = $this->tr_instansi->get_by_id(18);
        $odf->setVars('provinsi1', strtoupper($nama_prov1->value));

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

//sahal
 $odf->setImage('barcode', 'assets/barcode/' . $id_daftar . '.png', '5.0', '1.0');
//sahal

        //fill the template with the variables
        $nama_izin = $jenis_izin->n_perizinan;
        $odf->setVars('nama_izin', strtoupper($nama_izin));
 //       $odf->setVars('nama_izin2', $nama_izin);
        $odf->setVars('no_surat', $surat->no_surat);
        $odf->setVars('tanggal', $this->lib_date->mysql_to_human($surat->tgl_surat));
        $odf->setVars('jabatan', $pegawai->n_jabatan);
        $odf->setVars('nama_pejabat', strtoupper($pegawai->n_pegawai));
        $odf->setVars('nip_pejabat', $pegawai->nip);
//        $odf->setVars('kantor', $app_kan->value);
        $odf->setVars('salinan', "");

//sahal
 //       $odf->setVars('memperhatikan', "");
//sahal
        //$wilayah = new trkabupaten();
        //if($app_city !== '0'){
        //    $wilayah->get_by_id($app_city);
        //    $kota = $wilayah->ibukota;
        //    //$kota = $wilayah->n_kabupaten;
        //    $odf->setVars('kota', $kota);
        //}else{
        //    $kota = "..............";
        //    $odf->setVars('kota', $kota);
       // }

       //  $gede_kota=strtoupper($wilayah->n_kabupaten);
       // $kecil_kota=ucwords(strtolower($wilayah->n_kabupaten));
       // $odf->setVars('kota4', $gede_kota);

        //alamat
        //$this->tr_instansi = new Tr_instansi();
        //$alamat = $this->tr_instansi->get_by_id(12);
        //$odf->setVars('alamat', ucwords(strtolower($alamat->value)).' - '.$kecil_kota);
        

        //Content Menimbang
        $list_menimbang = $permohonan->trperizinan->trmenimbang->get();
        $i = 1;
        $abjad = array('', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k',
            'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y','z');
        foreach($list_menimbang as $data){
            if($i == 1){
                $listeArticles = array(
                        array(  'property' => 'Menimbang',
                                'content' => ':',
                                'content1' => $abjad[$i].'.',
                                'content2' => $data->deskripsi,
                        ),
                );
            }else{
                $listeArticles = array(
                        array(  'property' => '',
                                'content' => '',
                                'content1' => $abjad[$i].'.',
                                'content2' => $data->deskripsi,
                        ),
                );
            }
            $article = $odf->setSegment('articles1');
            foreach($listeArticles AS $element) {
                    $article->titreArticle($element['property']);
                    $article->texteArticle($element['content']);
                    $article->texteArticle1($element['content1']);
                    $article->texteArticle2($element['content2']);
                    $article->merge();
            }
            $i++;
        }
        if($i == '1'){
            $listeArticles = array(
                    array(  'property' => 'Menimbang',
                            'content' => ':',
                            'content1' => '',
                            'content2' => '',
                    ),
            );
            $article = $odf->setSegment('articles1');
            foreach($listeArticles AS $element) {
                    $article->titreArticle($element['property']);
                    $article->texteArticle($element['content']);
                    $article->texteArticle1($element['content1']);
                    $article->texteArticle2($element['content2']);
                    $article->merge();
            }
        }
        $odf->mergeSegment($article);

        //Content Mengingat
        $list_mengingat = $permohonan->trperizinan->trmengingat->where('type', '0')->get();
        $i = 1;
        foreach($list_mengingat as $data){
            if($i == 1){
                $listeArticles = array(
                        array(  'property' => 'Mengingat',
                                'content' => ':',
                                'content1' => $i.'.',
                                'content2' => $data->deskripsi,
                        ),
                );
            }else{
                $listeArticles = array(
                        array(  'property' => '',
                                'content' => '',
                                'content1' => $i.'.',
                                'content2' => $data->deskripsi,
                        ),
                );
            }
            $article = $odf->setSegment('articles2');
            foreach($listeArticles AS $element) {
                    $article->titreArticle($element['property']);
                    $article->texteArticle($element['content']);
                    $article->texteArticle1($element['content1']);
                    $article->texteArticle2($element['content2']);
                    $article->merge();
            }
            $i++;
        }
        if($i == '1'){
            $listeArticles = array(
                    array(  'property' => 'Mengingat',
                            'content' => ':',
                            'content1' => '',
                            'content2' => '',
                    ),
            );
            $article = $odf->setSegment('articles2');
            foreach($listeArticles AS $element) {
                    $article->titreArticle($element['property']);
                    $article->texteArticle($element['content']);
                    $article->texteArticle1($element['content1']);
                    $article->texteArticle2($element['content2']);
                    $article->merge();
            }
        }
        $odf->mergeSegment($article);

        //Content Surat Keputusan
//        $list_keputusan = $surat;
//        $i = 1;
//        foreach($list_keputusan as $data){
//            $listeArticles = array(
//                    array(  'property' => 'Nama '.$data->ket1,
//                            'content' => ':',
//                            'content1' => $data->nama1,
//                    ),
//                    array(  'property' => 'Alamat',
//                            'content' => ':',
//                            'content1' => $data->alamat1,
//                    ),
//                    array(  'property' => 'Nama '.$data->ket2,
//                            'content' => ':',
//                            'content1' => $data->nama2,
//                    ),
//                    array(  'property' => 'Alamat',
//                            'content' => ':',
//                            'content1' => $data->alamat2,
//                    ),
//            );
//            $article = $odf->setSegment('articles3');
//            foreach($listeArticles AS $element) {
//                    $article->titreArticle($element['property']);
//                    $article->texteArticle($element['content']);
//                    $article->texteArticle1($element['content1']);
//                    $article->merge();
//            }
//            $i++;
//        }
//        if($i == '1'){
//            $listeArticles = array(
//                    array(  'property' => '',
//                            'content' => '',
//                            'content1' => '',
//                    ),
//            );
//            $article = $odf->setSegment('articles3');
//            foreach($listeArticles AS $element) {
//                    $article->titreArticle($element['property']);
//                    $article->texteArticle($element['content']);
//                    $article->texteArticle1($element['content1']);
//                    $article->merge();
//            }
//        }
//        $odf->mergeSegment($article);
        
        // created by Budi .....................................
        for($i=1;$i<=10;$i++){
			$nomor = $i + 1;
            if($i == "1") $ketetapan = $surat->content1;
            else if($i == "2") $ketetapan = $surat->content2;
            else if($i == "3") $ketetapan = $surat->content3;
            else if($i == "4") $ketetapan = $surat->content4;
            else if($i == "5") $ketetapan = $surat->content5;
			else if($i == "6") $ketetapan = $surat->content6;
            else if($i == "7") $ketetapan = $surat->content7;
            else if($i == "8") $ketetapan = $surat->content8;
            else if($i == "9") $ketetapan = $surat->content9;
            else if($i == "10") $ketetapan = $surat->content10;

  		    if($ketetapan <> ""){
  			    $listeArticles = array(
                    array(  'property' => '',
                            'content' => '',
                            'content1' => $nomor.'. ',
                            'content2' => $ketetapan,
				    ),array(  'property' => '', 'content' => '', 'content1' => '', 'content2' => '',),
                );
//                $article = $odf->setSegment('articles4');
//                foreach($listeArticles AS $element) {
//                       $article->titreArticle($element['property']);
//                       $article->texteArticle($element['content']);
//                       $article->texteArticle1($element['content1']);
//                       $article->texteArticle2($element['content2']);
//                       $article->merge();
//                }
		    }
	    }
        $odf->mergeSegment($article);
        
        //Content Salinan
		$statussalinan=FALSE;
        for($i=1;$i<=10;$i++){
            if($i == "1") $salinan = $surat->salinan1;
            else if($i == "2") $salinan = $surat->salinan2;
            else if($i == "3") $salinan = $surat->salinan3;
            else if($i == "4") $salinan = $surat->salinan4;
            else if($i == "5") $salinan = $surat->salinan5;
			else if($i == "6") $salinan = $surat->salinan6;
            else if($i == "7") $salinan = $surat->salinan7;
            else if($i == "8") $salinan = $surat->salinan8;
            else if($i == "9") $salinan = $surat->salinan9;
            else if($i == "10") $salinan = $surat->salinan10;
            if($salinan){
                $statussalinan=TRUE;
                $listeArticles = array(
                        array(  'property' => $i.'. ',
                                'content' => $salinan,
                        ),
                );
            }else{
                $listeArticles = array(
                        array(  'property' => '',
                                'content' => '',
                        ),
                );
            }
            $article = $odf->setSegment('articles5');
            foreach($listeArticles AS $element) {
                    $article->titreArticle($element['property']);
                    $article->texteArticle($element['content']);
                    $article->merge();
                    
            }
        }
        if($statussalinan)
            {
                $odf->setVars('salinan', "Tembusan Kepada Yth: ");
            }
        $odf->mergeSegment($article);


//sahal content memperhatikan 
        for($i=1;$i<=6;$i++){
            if($i == "1") $memperhatikan = $surat->memperhatikan1;
            else if($i == "2") $memperhatikan = $surat->memperhatikan2;
            else if($i == "3") $memperhatikan = $surat->memperhatikan3;
            if($memperhatikan <> '') { $stat = TRUE; } else { $stat = FALSE; $i = 15;}
            if($stat) {
			    if($i=="1"){
                    $listeArticles = array(
                        array(  'judul' => 'Memperhatikan ',
					            'titikdua' => ': ',
					            'nomor' => $i.'. ',
                                'content' => $memperhatikan ,
                        ),
                    );
                } else {
                    $listeArticles = array(
					    array(  'judul' => ' ',
					            'titikdua' => ' ',
					            'nomor' => $i.'. ',
                                'content' => $memperhatikan ,
					    ),
				    );
                } 
		    } else {
				$listeArticles = array(
					    array(  'judul' => '',
					            'titikdua' => '',
					            'nomor' => '',
                                'content' => '',
					    ),
				    );
            } 
        
            $article = $odf->setSegment('articles6');
            foreach($listeArticles AS $element) {
                    $article->titreArticle($element['judul']);
                    $article->texteArticle($element['titikdua']);
					$article->titreArticle1($element['nomor']);
                    $article->texteArticle2($element['content']);
                    $article->merge();
                    
            }
	    }
        $odf->mergeSegment($article);


//sahal


          $tgl = date("Y-m-d H:i:s");
        $u_ser = $this->session->userdata('username');
        $g = $this->sql($u_ser);
//      $jam = date("H:i:s A");
        //$p = $this->db->query("call log ('Pembuatan Izin','Cetak SK ".$permohonan->pendaftaran_id."','".$tgl."','".$u_ser."')");

        //Content Property
        $perizinan = new trperizinan();
        $perizinan->get_by_id($jenis_izin->id);
        $list_daftar = $permohonan->tmproperty_jenisperizinan->get();
        $lists = $perizinan->trproperty->include_join_fields()->where('c_type', 2)->order_by('c_parent_order', "asc")->get();

        $property = $odf->setSegment('property');
        foreach ($lists as $list) {
     //       $property->nama($list->n_property);
            $children = $perizinan->trproperty->where('c_sk_id', 1)->where_join_field($perizinan, 'c_parent', $list->id)->include_join_fields()->order_by('c_order', "asc")->get();
            foreach ($children as $child_) {
                if ($list->id !== $child_->id) {
                    $property->child->child($child_->n_property);
// ................................ Isi ...........................
                    if ($list_daftar->id) {
                        foreach ($list_daftar as $data_daftar) {
                            $entry_property = new tmproperty_jenisperizinan_trproperty();
                            $entry_property->where('tmproperty_jenisperizinan_id', $data_daftar->id)
                                    ->where('trproperty_id', $child_->id)->get();
                            $izin_property = new trperizinan_trproperty();
                            $izin_property->where('trperizinan_id', $jenis_izin->id)
                                    ->where('trproperty_id', $child_->id)->get();
                            if ($entry_property->tmproperty_jenisperizinan_id) {
                                $entry_daftar = new tmproperty_jenisperizinan();
                                $koefret = new trkoefesientarifretribusi();
                                $entry_daftar->get_by_id($entry_property->tmproperty_jenisperizinan_id);
                                $pil = $koefret->get_by_id($entry_daftar->k_tinjauan);
                                $data_koefisient = $entry_daftar->v_tinjauan;
                                $isilow = strtolower($pil->kategori . " " . $data_koefisient . " " . $izin_property->satuan);
                                $isi = ucwords($isilow);
                                $property->child->isi($isi);
                            }
                        }
                    }

                    if ($child_->join_c_retribusi_id === '1') {
                        $property->child->indeks("");
                    } else {
                        $property->child->indeks("");
                    }
                    $property->child->merge();
                }
            }
            $property->merge();
        }
        $odf->mergeSegment($property);
        
        //export the file
        $no_daftar = str_replace('/', '', $permohonan->pendaftaran_id);
        $odf->exportAsAttachedFile($nama_surat.'_'.$no_daftar.'.odt');

 //SAHAL
		unlink('assets/barcode/' . $id_daftar . '.png');
//SAHAL
        
//		redirect('permohonan/sk');
    }

    public function cetak_siup($id_daftar = NULL) {
        $nama_surat = "cetak_siup";
        $app_folder = new settings();
        $app_folder->where('name','app_folder')->get();
        $app_folder = $app_folder->value . "/";
        $app_city = new settings();
        $app_city->where('name','app_city')->get();
        $app_city = $app_city->value;
        $app_kan =  $this->settings->where('name', 'app_kantor')->get();

		$petugas = 1; //1 -> Jabatan Penandatangan kepala kantor
        $permohonan = new tmpermohonan();
        $permohonan->get_by_id($id_daftar);
		$no_pendaftaran = $permohonan->pendaftaran_id;
        $perizinan = $permohonan->trperizinan->get();
        $surat_awal = $permohonan->tmsk->get();
		$perusahaan = $permohonan->tmperusahaan->get();
        $sts_cetak = 1;
        if($surat_awal->id){
            $surat_sk = new tmsk();
            $surat_sk->get_by_id($surat_awal->id);
            $surat_sk->c_status = $sts_cetak;
            $tgl_skr = $this->lib_date->get_date_now();
            $surat_sk->save();
            $pegawai = new tmpegawai();
            $pegawai->where('status', $petugas)->get();

            /* Input Relasi Tabel*/
            $perizinan = $permohonan->trperizinan->get();
//            $permohonan->d_berlaku_izin = $this->lib_date->set_date($tgl_skr, $perizinan->v_berlaku_tahun * 365);
            $permohonan->nip_ttd = $pegawai->nip;
            $permohonan->nama_ttd = strtoupper($pegawai->n_pegawai);
            $permohonan->save();
        }else{
            /* Input Data */
            $data_id = new tmsk();

            $data_id->select_max('id')->get();
            $data_id->get_by_id($data_id->id);

            $data_tahun = date("Y");
            //Per Tahun Auto Restart NoUrut
            if($permohonan->d_tahun === $data_tahun)
            $data_urut = $data_id->i_urut + 1;
            else $data_urut = 1;

            $i_urut = strlen($data_urut);
            for($i=4;$i>$i_urut;$i--){
                $data_urut = "0".$data_urut;
            }

            $data_izin = $perizinan->id;
            $i_izin = strlen($data_izin);
            for($i=3;$i>$i_izin;$i--){
                $data_izin = "0".$data_izin;
            }

            $data_bulan = $this->lib_date->set_month_roman(date("n"));

            $data_sk = "DP";
            $no_surat = $data_urut."/"
                    .$data_sk."/".$data_izin."/"
                    .$data_bulan."/".$data_tahun;
            $surat_sk = new tmsk();
            $surat_sk->c_status = $sts_cetak;
            $surat_sk->i_urut = $data_urut;
            $surat_sk->no_surat = $no_surat;
            $tgl_skr = $this->lib_date->get_date_now();
//            $surat_sk->tgl_surat = $tgl_skr;
            $surat_sk->c_cetak = 1;

            /* Input Relasi Tabel*/
            $pegawai = new tmpegawai();
            $pegawai->where('status', $petugas)->get();
            $perizinan = $permohonan->trperizinan->get();
//            $permohonan->d_berlaku_izin = $this->lib_date->set_date($tgl_skr, $perizinan->v_berlaku_tahun * 365); //per tahun
            $permohonan->nip_ttd = $pegawai->nip;
            $permohonan->nama_ttd = strtoupper($pegawai->n_pegawai);
            $permohonan->save();
            
            $surat_sk->save(array($permohonan, $pegawai));
        }

        $status_izin = $permohonan->trstspermohonan->get();
        
        //edited 2-12-2014
        //by pbs
        
		$status_skr  = "8" ; // Diizinkan [Lihat Tabel trstspermohonan()]
        $status_skrd = "10"; // SKRD [Lihat Tabel trstspermohonan()]
        $id_status   = "14"; // Mencetak Surat [Lihat Tabel trstspermohonan()]
        $id_status2  = "13"; // Kasir [Lihat Tabel trstspermohonan()]
        $id_status3  = "14"; // Penyerahan Izin [Lihat Tabel trstspermohonan()]

        $kelompok    = $permohonan->trperizinan->trkelompok_perizinan->get();
		$kd_kelompok = $kelompok->id;  // mengambil kelompok id

        $u_ser = $this->session->userdata('username');
		$r_name = $this->lib_date->get_nama_ori($u_ser);
        $tanggal_ctk = $this->lib_date->get_date_now();
		$tracking_izin = new tmtrackingperizinan();
        $tracking_izin->where('pendaftaran_id', $no_pendaftaran)
                      ->where('tr_activiti', 'Penyerahan Izin')->get();
		if($tracking_izin->pendaftaran_id){
            $tracking_izin->status = 'Update';
            $tracking_izin->d_entry = $tanggal_ctk;
            $tracking_izin->tr_user = $u_ser;
            $tracking_izin->tr_name = $r_name;
			$hit_cetak = $tracking_izin->hit_cetak + 1;
    		$his_cetak = $tracking_izin->his_cetak;
   	    	$tracking_izin->hit_cetak = $hit_cetak;
		    $tracking_izin->his_cetak = $his_cetak.'CETAK SK^'.$r_name.'^'.$this->lib_date->get_date_now().';';
            $tracking_izin->save();
		}
		
		$tracking_izin = new tmtrackingperizinan();
        $tracking_izin->where('pendaftaran_id', $no_pendaftaran)
                      ->where('tr_activiti', 'Arsip')->get();
		if($tracking_izin->pendaftaran_id){
            $tracking_izin->d_entry_awal = $tanggal_ctk;
			$tracking_izin->d_entry = $tanggal_ctk;
            $tracking_izin->save();
		}

        //Status cetak SK
        $sk = new tmsk();
        $sk->get_by_id($surat_awal->id);
        $sk->c_cetak = $surat_awal->c_cetak + 1;
        $his_cetak = $sk->his_cetak;
	    $sk->his_cetak = $his_cetak.$r_name.'^'.$this->lib_date->get_date_now().';';
        $sk->save();

        $surat = $permohonan->tmsk->get();
        $pemohon = $permohonan->tmpemohon->get();
        $jenis_izin = $permohonan->trperizinan->get();
        
        //path of the template file
        $this->load->plugin('odf');
        $odf = new odf('assets/odt/'.$nama_surat.'.odt');

		//logo
        $this->tr_instansi = new Tr_instansi();
        $logo = $this->tr_instansi->get_by_id(23);
        if($logo->value!=="") {
            $odf->setImage('logo', 'uploads/logo/' . $logo->value, '3', '2.5');
        } else {
            $odf->setVars('logo', ' ');
        } 
        
		$sektor = $permohonan->trsektor_id;
		//$odf->setImage('bebas_biaya', 'uploads/logo/BebasBiaya.png', '4', '1.2');
		if($sektor == '10' || $sektor == '11'){   // jika perhubungan dan perikanan
		    $odf->setVars('bebas_biaya', '');
        }

		//pemerintah 
        $this->tr_instansi = new Tr_instansi();
        $nama_prov = $this->tr_instansi->get_by_id(17);
        $odf->setVars('daerah', strtoupper($nama_prov->value));

        //badan
        $this->tr_instansi = new Tr_instansi();
        $nama_bdan = $this->tr_instansi->get_by_id(9);
        $odf->setVars('badan', strtoupper($nama_bdan->value));

        //alamat
        $this->tr_instansi = new Tr_instansi();
        $alamat = $this->tr_instansi->get_by_id(12);
        $odf->setVars('alamat', $alamat->value);

		//telpon
        $this->tr_instansi = new Tr_instansi();
        $tlp = $this->tr_instansi->get_by_id(10);
        $odf->setVars('tlp', $tlp->value);

        //fax
        $this->tr_instansi = new Tr_instansi();
        $tlp = $this->tr_instansi->get_by_id(13);
        $odf->setVars('fax', $tlp->value);

		//e-mail
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
        $odf->setVars('k_kota_besar', $kop_kota->value);

        //Kode Pos
        $this->tr_instansi = new Tr_instansi();
        $kode_pos = $this->tr_instansi->get_by_id(20);
        $odf->setVars('kd_pos', $kode_pos->value);

        $color_black = new BCGColor(0, 0, 0);
        $color_white = new BCGColor(255, 255, 255);
        $code = new BCGcode128();
        $code->setThickness(200);  // 25
        $code->setForegroundColor($color_black); // Color of bars
        $code->setBackgroundColor($color_white); // Color of spaces
        $code->parse($no_pendaftaran); // Text
        $drawing = new BCGDrawing('assets/barcode/' . $id_daftar . '.png', $color_white);
        $drawing->setBarcode($code);
        $drawing->draw();
        $drawing->finish(BCGDrawing::IMG_FORMAT_PNG);
		$odf->setImage('no_barcode', 'assets/barcode/' . $id_daftar . '.png', '5.0', '1.0');

		$no_siup = $sk->no_surat_edit;
		if($no_siup == '') $no_siup = $sk->no_surat;
        $odf->setVars('no_siup', $no_siup);
		$odf->setVars('nm_perusahaan', $perusahaan->n_perusahaan);
		$odf->setVars('alamat_perusahaan', $perusahaan->a_perusahaan);
		$odf->setVars('no_telp', $perusahaan->i_telp_perusahaan);
		$odf->setVars('no_fax', $perusahaan->fax);

		$odf->setVars('nm_pengurus', $this->lib_date->isi_property($id_daftar, 1, 5));
		$odf->setVars('jabatan', $this->lib_date->isi_property($id_daftar, 2, 5));
		$odf->setVars('modal', $this->lib_date->isi_property($id_daftar, 3, 5));
		$odf->setVars('kelembagaan', $this->lib_date->isi_property($id_daftar, 4, 5));
		$odf->setVars('no_kbli', $this->lib_date->isi_property($id_daftar, 5, 5));
		$odf->setVars('dagangan', $this->lib_date->isi_property($id_daftar, 6, 5));

		$tgl_ctk = date("j");
		$bln_ctk = $this->lib_date->set_month_name(date("n"), 'id');
		$thn_ctk = date("Y");
        $thn_ctkplus = $thn_ctk + 5;  // masa berlaku + 5
		$odf->setVars('tgl_daftarulang', $tgl_ctk.' '.$bln_ctk.' '.$thn_ctkplus);
		$odf->setVars('tgl_terbit', $bln_ctk.' '.$thn_ctk);

        $odf->setVars('nama_pejabat', strtoupper($pegawai->n_pegawai));
		$odf->setVars('pangkat_pejabat', $pegawai->pangkat_gol);
		$odf->setVars('nip_pejabat', $pegawai->nip);

		//fill the template with the variables
        $nama_izin = $jenis_izin->n_perizinan;
        $data_judul = $jenis_izin->c_judul;

       // $odf->setVars('masaberlaku', $masa_berlaku);

        $tgl = date("Y-m-d H:i:s");
        $u_ser = $this->session->userdata('username');
        $g = $this->sql($u_ser);
//      $jam = date("H:i:s A");
        //$p = $this->db->query("call log ('Pembuatan Izin','Cetak Surat Izin ".$permohonan->pendaftaran_id."','".$tgl."','".$u_ser."')");

        //export the file
        $no_daftar = str_replace('/', '', $permohonan->pendaftaran_id);
        $odf->exportAsAttachedFile('surat_izin_'.$no_daftar.'.odt');
    }
	//EOF() cetak_siup

    public function cetak_tdp($id_daftar = NULL) {
        $nama_surat = "cetak_tdp";
        $app_folder = new settings();
        $app_folder->where('name','app_folder')->get();
        $app_folder = $app_folder->value . "/";
        $app_city = new settings();
        $app_city->where('name','app_city')->get();
        $app_city = $app_city->value;
        $app_kan =  $this->settings->where('name', 'app_kantor')->get();

		$petugas = 1; //1 -> Jabatan Penandatangan kepala kantor
        $permohonan = new tmpermohonan();
        $permohonan->get_by_id($id_daftar);
		$no_pendaftaran = $permohonan->pendaftaran_id;
        $perizinan = $permohonan->trperizinan->get();
        $surat_awal = $permohonan->tmsk->get();
		$perusahaan = $permohonan->tmperusahaan->get();
        $sts_cetak = 1;
        if($surat_awal->id){
            $surat_sk = new tmsk();
            $surat_sk->get_by_id($surat_awal->id);
            $surat_sk->c_status = $sts_cetak;
            $tgl_skr = $this->lib_date->get_date_now();
            $surat_sk->save();
            $pegawai = new tmpegawai();
            $pegawai->where('status', $petugas)->get();

            /* Input Relasi Tabel*/
            $perizinan = $permohonan->trperizinan->get();
//            $permohonan->d_berlaku_izin = $this->lib_date->set_date($tgl_skr, $perizinan->v_berlaku_tahun * 365);
            $permohonan->nip_ttd = $pegawai->nip;
            $permohonan->nama_ttd = strtoupper($pegawai->n_pegawai);
            $permohonan->save();
        }else{
            /* Input Data */
            $data_id = new tmsk();

            $data_id->select_max('id')->get();
            $data_id->get_by_id($data_id->id);

            $data_tahun = date("Y");
            //Per Tahun Auto Restart NoUrut
            if($permohonan->d_tahun === $data_tahun)
            $data_urut = $data_id->i_urut + 1;
            else $data_urut = 1;

            $i_urut = strlen($data_urut);
            for($i=4;$i>$i_urut;$i--){
                $data_urut = "0".$data_urut;
            }

            $data_izin = $perizinan->id;
            $i_izin = strlen($data_izin);
            for($i=3;$i>$i_izin;$i--){
                $data_izin = "0".$data_izin;
            }

            $data_bulan = $this->lib_date->set_month_roman(date("n"));

            $data_sk = "DP";
            $no_surat = $data_urut."/"
                    .$data_sk."/".$data_izin."/"
                    .$data_bulan."/".$data_tahun;
            $surat_sk = new tmsk();
            $surat_sk->c_status = $sts_cetak;
            $surat_sk->i_urut = $data_urut;
            $surat_sk->no_surat = $no_surat;
            $tgl_skr = $this->lib_date->get_date_now();
//            $surat_sk->tgl_surat = $tgl_skr;
            $surat_sk->c_cetak = 1;

            /* Input Relasi Tabel*/
            $pegawai = new tmpegawai();
            $pegawai->where('status', $petugas)->get();
            $perizinan = $permohonan->trperizinan->get();
//            $permohonan->d_berlaku_izin = $this->lib_date->set_date($tgl_skr, $perizinan->v_berlaku_tahun * 365); //per tahun
            $permohonan->nip_ttd = $pegawai->nip;
            $permohonan->nama_ttd = strtoupper($pegawai->n_pegawai);
            $permohonan->save();
            
            $surat_sk->save(array($permohonan, $pegawai));
        }

        $status_izin = $permohonan->trstspermohonan->get();
        
        //edited 2-12-2014
        //by pbs
        
		$status_skr  = "8" ; // Diizinkan [Lihat Tabel trstspermohonan()]
        $status_skrd = "10"; // SKRD [Lihat Tabel trstspermohonan()]
        $id_status   = "14"; // Mencetak Surat [Lihat Tabel trstspermohonan()]
        $id_status2  = "13"; // Kasir [Lihat Tabel trstspermohonan()]
        $id_status3  = "14"; // Penyerahan Izin [Lihat Tabel trstspermohonan()]

        $kelompok    = $permohonan->trperizinan->trkelompok_perizinan->get();
		$kd_kelompok = $kelompok->id;  // mengambil kelompok id

        $u_ser = $this->session->userdata('username');
		$r_name = $this->lib_date->get_nama_ori($u_ser);
        $tanggal_ctk = $this->lib_date->get_date_now();
		$tracking_izin = new tmtrackingperizinan();
        $tracking_izin->where('pendaftaran_id', $no_pendaftaran)
                      ->where('tr_activiti', 'Penyerahan Izin')->get();
		if($tracking_izin->pendaftaran_id){
            $tracking_izin->status = 'Update';
            $tracking_izin->d_entry = $tanggal_ctk;
            $tracking_izin->tr_user = $u_ser;
            $tracking_izin->tr_name = $r_name;
			$hit_cetak = $tracking_izin->hit_cetak + 1;
    		$his_cetak = $tracking_izin->his_cetak;
   	    	$tracking_izin->hit_cetak = $hit_cetak;
		    $tracking_izin->his_cetak = $his_cetak.'CETAK SK^'.$r_name.'^'.$this->lib_date->get_date_now().';';
            $tracking_izin->save();
		}
		
		$tracking_izin = new tmtrackingperizinan();
        $tracking_izin->where('pendaftaran_id', $no_pendaftaran)
                      ->where('tr_activiti', 'Arsip')->get();
		if($tracking_izin->pendaftaran_id){
            $tracking_izin->d_entry_awal = $tanggal_ctk;
			$tracking_izin->d_entry = $tanggal_ctk;
            $tracking_izin->save();
		}

        //Status cetak SK
        $sk = new tmsk();
        $sk->get_by_id($surat_awal->id);
        $sk->c_cetak = $surat_awal->c_cetak + 1;
        $his_cetak = $sk->his_cetak;
	    $sk->his_cetak = $his_cetak.$r_name.'^'.$this->lib_date->get_date_now().';';
        $sk->save();

        $surat = $permohonan->tmsk->get();
        $pemohon = $permohonan->tmpemohon->get();
        $jenis_izin = $permohonan->trperizinan->get();
        
        //path of the template file
        $this->load->plugin('odf');
        $odf = new odf('assets/odt/'.$nama_surat.'.odt');

		//logo
        $this->tr_instansi = new Tr_instansi();
        $logo = $this->tr_instansi->get_by_id(23);
        if($logo->value!=="") {
            $odf->setImage('logo', 'uploads/logo/' . $logo->value, '3', '2.5');
        } else {
            $odf->setVars('logo', ' ');
        } 
        
		$sektor = $permohonan->trsektor_id;
		//$odf->setImage('bebas_biaya', 'uploads/logo/BebasBiaya.png', '4', '1.2');
		if($sektor == '10' || $sektor == '11'){   // jika perhubungan dan perikanan
		    $odf->setVars('bebas_biaya', '');
        }

		//pemerintah 
        $this->tr_instansi = new Tr_instansi();
        $nama_prov = $this->tr_instansi->get_by_id(17);
        $odf->setVars('daerah', strtoupper($nama_prov->value));

        //badan
        $this->tr_instansi = new Tr_instansi();
        $nama_bdan = $this->tr_instansi->get_by_id(9);
        $odf->setVars('badan', strtoupper($nama_bdan->value));

        //alamat
        $this->tr_instansi = new Tr_instansi();
        $alamat = $this->tr_instansi->get_by_id(12);
        $odf->setVars('alamat', $alamat->value);

		//telpon
        $this->tr_instansi = new Tr_instansi();
        $tlp = $this->tr_instansi->get_by_id(10);
        $odf->setVars('tlp', $tlp->value);

        //fax
        $this->tr_instansi = new Tr_instansi();
        $tlp = $this->tr_instansi->get_by_id(13);
        $odf->setVars('fax', $tlp->value);

		//e-mail
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
        $odf->setVars('k_kota_besar', $kop_kota->value);

        //Kode Pos
        $this->tr_instansi = new Tr_instansi();
        $kode_pos = $this->tr_instansi->get_by_id(20);
        $odf->setVars('kd_pos', $kode_pos->value);

        $color_black = new BCGColor(0, 0, 0);
        $color_white = new BCGColor(255, 255, 255);
        $code = new BCGcode128();
        $code->setThickness(200);  // 25
        $code->setForegroundColor($color_black); // Color of bars
        $code->setBackgroundColor($color_white); // Color of spaces
        $code->parse($no_pendaftaran); // Text
        $drawing = new BCGDrawing('assets/barcode/' . $id_daftar . '.png', $color_white);
        $drawing->setBarcode($code);
        $drawing->draw();
        $drawing->finish(BCGDrawing::IMG_FORMAT_PNG);
		$odf->setImage('no_barcode', 'assets/barcode/' . $id_daftar . '.png', '5.0', '1.0');

		$no_siup = $sk->no_surat_edit;
		if($no_siup == '') $no_siup = $sk->no_surat;
        $odf->setVars('no_tdp', $no_siup);
		$odf->setVars('nm_perusahaan', $perusahaan->n_perusahaan);
		$odf->setVars('alamat_perusahaan', $perusahaan->a_perusahaan);
		$odf->setVars('no_telp', $perusahaan->i_telp_perusahaan);
		$odf->setVars('no_fax', $perusahaan->fax);
		$odf->setVars('no_npwp', $perusahaan->npwp);

        $odf->setVars('jns_perusahaan', $this->lib_date->isi_property($id_daftar, 1, 5));
		$odf->setVars('jns_daftar', $this->lib_date->isi_property($id_daftar, 3, 5));
		$odf->setVars('pembaharuan', $this->lib_date->isi_property($id_daftar, 4, 5));
        $odf->setVars('status', $this->lib_date->isi_property($id_daftar, 5, 5));
		$odf->setVars('nm_pengurus', $this->lib_date->isi_property($id_daftar, 6, 5));
		$odf->setVars('n_kbli', $this->lib_date->isi_property($id_daftar, 7, 5));
		$odf->setVars('keg_usaha', $this->lib_date->isi_property($id_daftar, 8, 5));

		$tgl_ctk = date("j");
		$bln_ctk = $this->lib_date->set_month_name(date("n"), 'id');
		$thn_ctk = date("Y");
        $thn_ctkplus = $thn_ctk + 5;  // masa berlaku + 5
		$odf->setVars('tgl_berlaku', $tgl_ctk.' '.$bln_ctk.' '.$thn_ctkplus);
		$odf->setVars('tgl_terbit', $bln_ctk.' '.$thn_ctk);

        $odf->setVars('jabatan', 'KEPALA KANTOR PENDAFTARAN PERUSAHAAN');
		$odf->setVars('nama_pejabat', strtoupper($pegawai->n_pegawai));
		$odf->setVars('pangkat_pejabat', $pegawai->pangkat_gol);
		$odf->setVars('nip_pejabat', $pegawai->nip);

		//fill the template with the variables
        $nama_izin = $jenis_izin->n_perizinan;
        $data_judul = $jenis_izin->c_judul;

       // $odf->setVars('masaberlaku', $masa_berlaku);

        $tgl = date("Y-m-d H:i:s");
        $u_ser = $this->session->userdata('username');
        $g = $this->sql($u_ser);
//      $jam = date("H:i:s A");
        //$p = $this->db->query("call log ('Pembuatan Izin','Cetak Surat Izin ".$permohonan->pendaftaran_id."','".$tgl."','".$u_ser."')");

        //export the file
        $no_daftar = str_replace('/', '', $permohonan->pendaftaran_id);
        $odf->exportAsAttachedFile('surat_izin_'.$no_daftar.'.odt');
    }
    //EOF() cetak_tdp

    public function cetak_ho($id_daftar = NULL) {
        $nama_surat = "cetak_ho";
        $app_folder = new settings();
        $app_folder->where('name','app_folder')->get();
        $app_folder = $app_folder->value . "/";
        $app_city = new settings();
        $app_city->where('name','app_city')->get();
        $app_city = $app_city->value;
        $app_kan =  $this->settings->where('name', 'app_kantor')->get();

		$petugas = 1; //1 -> Jabatan Penandatangan kepala kantor
        $permohonan = new tmpermohonan();
        $permohonan->get_by_id($id_daftar);
		$no_pendaftaran = $permohonan->pendaftaran_id;
        $perizinan = $permohonan->trperizinan->get();
        $surat_awal = $permohonan->tmsk->get();
		$bap = $permohonan->tmbap->get();
		$perusahaan = $permohonan->tmperusahaan->get();
		$pemohon = $permohonan->tmpemohon->get();

        $p_kelurahan = $pemohon->trkelurahan->get();
        $p_kecamatan = $pemohon->trkelurahan->trkecamatan->get();
        $p_kabupaten = $pemohon->trkelurahan->trkecamatan->trkabupaten->get();
        
        $u_kelurahan = $perusahaan->trkelurahan->get();
        $u_kecamatan = $perusahaan->trkelurahan->trkecamatan->get();
        $u_kabupaten = $perusahaan->trkelurahan->trkecamatan->trkabupaten->get();
		
        $sts_cetak = 1;
        if($surat_awal->id){
            $surat_sk = new tmsk();
            $surat_sk->get_by_id($surat_awal->id);
            $surat_sk->c_status = $sts_cetak;
            $tgl_skr = $this->lib_date->get_date_now();
            $surat_sk->save();
            $pegawai = new tmpegawai();
            $pegawai->where('status', $petugas)->get();

            /* Input Relasi Tabel*/
            $perizinan = $permohonan->trperizinan->get();
//            $permohonan->d_berlaku_izin = $this->lib_date->set_date($tgl_skr, $perizinan->v_berlaku_tahun * 365);
            $permohonan->nip_ttd = $pegawai->nip;
            $permohonan->nama_ttd = strtoupper($pegawai->n_pegawai);
            $permohonan->save();
        }else{
            /* Input Data */
            $data_id = new tmsk();

            $data_id->select_max('id')->get();
            $data_id->get_by_id($data_id->id);

            $data_tahun = date("Y");
            //Per Tahun Auto Restart NoUrut
            if($permohonan->d_tahun === $data_tahun)
            $data_urut = $data_id->i_urut + 1;
            else $data_urut = 1;

            $i_urut = strlen($data_urut);
            for($i=4;$i>$i_urut;$i--){
                $data_urut = "0".$data_urut;
            }

            $data_izin = $perizinan->id;
            $i_izin = strlen($data_izin);
            for($i=3;$i>$i_izin;$i--){
                $data_izin = "0".$data_izin;
            }

            $data_bulan = $this->lib_date->set_month_roman(date("n"));

            $data_sk = "DP";
            $no_surat = $data_urut."/"
                    .$data_sk."/".$data_izin."/"
                    .$data_bulan."/".$data_tahun;
            $surat_sk = new tmsk();
            $surat_sk->c_status = $sts_cetak;
            $surat_sk->i_urut = $data_urut;
            $surat_sk->no_surat = $no_surat;
            $tgl_skr = $this->lib_date->get_date_now();
//            $surat_sk->tgl_surat = $tgl_skr;
            $surat_sk->c_cetak = 1;

            /* Input Relasi Tabel*/
            $pegawai = new tmpegawai();
            $pegawai->where('status', $petugas)->get();
            $perizinan = $permohonan->trperizinan->get();
//            $permohonan->d_berlaku_izin = $this->lib_date->set_date($tgl_skr, $perizinan->v_berlaku_tahun * 365); //per tahun
            $permohonan->nip_ttd = $pegawai->nip;
            $permohonan->nama_ttd = strtoupper($pegawai->n_pegawai);
            $permohonan->save();
            
            $surat_sk->save(array($permohonan, $pegawai));
        }

        $status_izin = $permohonan->trstspermohonan->get();
        
        //edited 2-12-2014
        //by pbs
        
		$status_skr  = "8" ; // Diizinkan [Lihat Tabel trstspermohonan()]
        $status_skrd = "10"; // SKRD [Lihat Tabel trstspermohonan()]
        $id_status   = "14"; // Mencetak Surat [Lihat Tabel trstspermohonan()]
        $id_status2  = "13"; // Kasir [Lihat Tabel trstspermohonan()]
        $id_status3  = "14"; // Penyerahan Izin [Lihat Tabel trstspermohonan()]

        $kelompok    = $permohonan->trperizinan->trkelompok_perizinan->get();
		$kd_kelompok = $kelompok->id;  // mengambil kelompok id

        $u_ser = $this->session->userdata('username');
		$r_name = $this->lib_date->get_nama_ori($u_ser);
        $tanggal_ctk = $this->lib_date->get_date_now();
		$tracking_izin = new tmtrackingperizinan();
        $tracking_izin->where('pendaftaran_id', $no_pendaftaran)
                      ->where('tr_activiti', 'Penyerahan Izin')->get();
		if($tracking_izin->pendaftaran_id){
            $tracking_izin->status = 'Update';
            $tracking_izin->d_entry = $tanggal_ctk;
            $tracking_izin->tr_user = $u_ser;
            $tracking_izin->tr_name = $r_name;
			$hit_cetak = $tracking_izin->hit_cetak + 1;
    		$his_cetak = $tracking_izin->his_cetak;
   	    	$tracking_izin->hit_cetak = $hit_cetak;
		    $tracking_izin->his_cetak = $his_cetak.'CETAK SK^'.$r_name.'^'.$this->lib_date->get_date_now().';';
            $tracking_izin->save();
		}
		
		$tracking_izin = new tmtrackingperizinan();
        $tracking_izin->where('pendaftaran_id', $no_pendaftaran)
                      ->where('tr_activiti', 'Arsip')->get();
		if($tracking_izin->pendaftaran_id){
            $tracking_izin->d_entry_awal = $tanggal_ctk;
			$tracking_izin->d_entry = $tanggal_ctk;
            $tracking_izin->save();
		}

        //Status cetak SK
        $sk = new tmsk();
        $sk->get_by_id($surat_awal->id);
        $sk->c_cetak = $surat_awal->c_cetak + 1;
        $his_cetak = $sk->his_cetak;
	    $sk->his_cetak = $his_cetak.$r_name.'^'.$this->lib_date->get_date_now().';';
        $sk->save();

        $surat = $permohonan->tmsk->get();
        $pemohon = $permohonan->tmpemohon->get();
        $jenis_izin = $permohonan->trperizinan->get();

		//path of the template file
        $this->load->plugin('odf');
        $odf = new odf('assets/odt/'.$nama_surat.'.odt');

		//logo
        $this->tr_instansi = new Tr_instansi();
        $logo = $this->tr_instansi->get_by_id(23);
        if($logo->value!=="") {
            $odf->setImage('logo', 'uploads/logo/' . $logo->value, '3', '2.5');
        } else {
            $odf->setVars('logo', ' ');
        } 
        
		$sektor = $permohonan->trsektor_id;
		//$odf->setImage('bebas_biaya', 'uploads/logo/BebasBiaya.png', '4', '1.2');
		if($sektor == '10' || $sektor == '11'){   // jika perhubungan dan perikanan
		    $odf->setVars('bebas_biaya', '');
        }

		//pemerintah 
        $this->tr_instansi = new Tr_instansi();
        $nama_prov = $this->tr_instansi->get_by_id(17);
        $odf->setVars('daerah', strtoupper($nama_prov->value));

        //badan
        $this->tr_instansi = new Tr_instansi();
        $nama_bdan = $this->tr_instansi->get_by_id(9);
        $odf->setVars('badan', strtoupper($nama_bdan->value));

        //alamat
        $this->tr_instansi = new Tr_instansi();
        $alamat = $this->tr_instansi->get_by_id(12);
        $odf->setVars('alamat', $alamat->value);

		//telpon
        $this->tr_instansi = new Tr_instansi();
        $tlp = $this->tr_instansi->get_by_id(10);
        $odf->setVars('tlp', $tlp->value);

        //fax
        $this->tr_instansi = new Tr_instansi();
        $tlp = $this->tr_instansi->get_by_id(13);
        $odf->setVars('fax', $tlp->value);

		//e-mail
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
        $odf->setVars('k_kota_besar', $kop_kota->value);

        //Kode Pos
        $this->tr_instansi = new Tr_instansi();
        $kode_pos = $this->tr_instansi->get_by_id(20);
        $odf->setVars('kd_pos', $kode_pos->value);

        $kab_pemohon = $p_kabupaten->n_kabupaten; 
        $kec_pemohon = $p_kecamatan->n_kecamatan;
        $kel_pemohon = $p_kelurahan->n_kelurahan;

		$kab_usaha = $u_kabupaten->n_kabupaten;
        $kec_usaha = $u_kecamatan->n_kecamatan;
        $kel_usaha = $u_kelurahan->n_kelurahan;

		$odf->setVars('kab_usaha1', $kab_usaha);
        $odf->setVars('kec_usaha1', $kec_usaha);
        
        if($kab_pemohon == '-') $kab_pemohon = '';
		if($kec_pemohon == '-') $kec_pemohon = ''; else $kec_pemohon = 'Kec. '.$kec_pemohon;
        if($kel_pemohon == '-') $kel_pemohon = ''; else $kel_pemohon = 'Kec. '.$kel_pemohon;

        if($kab_usaha == '-') $kab_usaha = '';
		if($kec_usaha == '-') $kec_usaha = ''; else $kec_usaha = 'Kec. '.$kec_usaha;
        if($kel_usaha == '-') $kel_usaha = ''; else $kel_usaha = 'Kel. '.$kel_usaha;

        $odf->setVars('kab_pemohon', $kab_pemohon);
        $odf->setVars('kec_pemohon', $kec_pemohon);
        $odf->setVars('kel_pemohon', $kel_pemohon);

		$odf->setVars('kab_usaha', $kab_usaha);
        $odf->setVars('kec_usaha', $kec_usaha);
        $odf->setVars('kel_usaha', $kel_usaha);

        $color_black = new BCGColor(0, 0, 0);
        $color_white = new BCGColor(255, 255, 255);
        $code = new BCGcode128();
        $code->setThickness(200);  // 25
        $code->setForegroundColor($color_black); // Color of bars
        $code->setBackgroundColor($color_white); // Color of spaces
        $code->parse($no_pendaftaran); // Text
        $drawing = new BCGDrawing('assets/barcode/' . $id_daftar . '.png', $color_white);
        $drawing->setBarcode($code);
        $drawing->draw();
        $drawing->finish(BCGDrawing::IMG_FORMAT_PNG);
		$odf->setImage('no_barcode', 'assets/barcode/' . $id_daftar . '.png', '5.0', '1.0');

		$no_siup = $sk->no_surat_edit;
		if($no_siup == '') $no_siup = $sk->no_surat;
        $odf->setVars('no_ho', $no_siup);

        $odf->setVars('nama_pemohon', $pemohon->n_pemohon);
		$odf->setVars('tgl_permohonan', $this->lib_date->mysql_to_human($permohonan->d_terima_berkas));
		$odf->setVars('alamat_permohonan', $permohonan->a_izin);
        
		$odf->setVars('no_bap', $bap->bap_id);
		$odf->setVars('tgl_bap', $this->lib_date->mysql_to_human($bap->tgl_bap));

		$odf->setVars('nama_tujuan', $pemohon->n_pemohon);
		$odf->setVars('alamat_tujuan', $pemohon->a_pemohon);

        $odf->setVars('nama_pengusaha', $pemohon->n_pemohon);
		$odf->setVars('nama_perusahaan', $perusahaan->n_perusahaan);
		$odf->setVars('alamat_perusahaan', $perusahaan->a_perusahaan);

		$odf->setVars('no_rekom', $this->lib_date->isi_property($id_daftar, 1, 5));
		$odf->setVars('tgl_rekom', $this->lib_date->mysql_to_human($this->lib_date->isi_property($id_daftar, 2, 5)));
		$odf->setVars('no_retribusi', $this->lib_date->isi_property($id_daftar, 3, 5));
        $odf->setVars('tgl_retribusi', $this->lib_date->mysql_to_human($this->lib_date->isi_property($id_daftar, 4, 5)));
		$odf->setVars('jenis_usaha', $this->lib_date->isi_property($id_daftar, 5, 5));
		$odf->setVars('nm_retribusi', $pemohon->n_pemohon .' ('. $this->lib_date->isi_property($id_daftar, 6, 5) .' '. $perusahaan->n_perusahaan.')');
		$odf->setVars('bentuk_usaha', $this->lib_date->isi_property($id_daftar, 6, 5));
		$odf->setVars('status_tanah', $this->lib_date->isi_property($id_daftar, 7, 5));
		$odf->setVars('ls_tnh_pk', $this->lib_date->isi_property($id_daftar, 8, 5));
		$odf->setVars('ls_tnh_us', $this->lib_date->isi_property($id_daftar, 9, 5));
		$odf->setVars('ls_tnh_all', $this->lib_date->isi_property($id_daftar, 8, 5) + $this->lib_date->isi_property($id_daftar, 9, 5));
		$odf->setVars('bts_utara', $this->lib_date->isi_property($id_daftar, 10, 5));
		$odf->setVars('bts_selatan', $this->lib_date->isi_property($id_daftar, 11, 5));
		$odf->setVars('bts_barat', $this->lib_date->isi_property($id_daftar, 12, 5));
		$odf->setVars('bts_timur', $this->lib_date->isi_property($id_daftar, 13, 5));
		$odf->setVars('jml_pekerja', $this->lib_date->isi_property($id_daftar, 14, 5));
		$odf->setVars('jml_jam', $this->lib_date->isi_property($id_daftar, 15, 5));
		$odf->setVars('jml_sift', $this->lib_date->isi_property($id_daftar, 16, 5));
		$odf->setVars('brg_dagang', $this->lib_date->isi_property($id_daftar, 17, 5));

		$tgl_ctk = date("j");
		$bln_ctk = $this->lib_date->set_month_name(date("n"), 'id');
		$thn_ctk = date("Y");
        $thn_ctkplus = $thn_ctk + 5;  // masa berlaku + 5
		//$odf->setVars('tgl_berlaku', $tgl_ctk.' '.$bln_ctk.' '.$thn_ctkplus);
		$odf->setVars('tgl_terbit', $bln_ctk.' '.$thn_ctk);

        //$odf->setVars('jabatan', 'KEPALA KANTOR PENDAFTARAN PERUSAHAAN');
		$odf->setVars('nama_pejabat', strtoupper($pegawai->n_pegawai));
		$odf->setVars('pangkat_pejabat', $pegawai->pangkat_gol);
		$odf->setVars('nip_pejabat', $pegawai->nip);

		//fill the template with the variables
        $nama_izin = $jenis_izin->n_perizinan;
        $data_judul = $jenis_izin->c_judul;

       // $odf->setVars('masaberlaku', $masa_berlaku);

        $tgl = date("Y-m-d H:i:s");
        $u_ser = $this->session->userdata('username');
        $g = $this->sql($u_ser);
//      $jam = date("H:i:s A");
        //$p = $this->db->query("call log ('Pembuatan Izin','Cetak Surat Izin ".$permohonan->pendaftaran_id."','".$tgl."','".$u_ser."')");

        //export the file
        $no_daftar = str_replace('/', '', $permohonan->pendaftaran_id);
        $odf->exportAsAttachedFile('surat_izin_'.$no_daftar.'.odt');
    }
	//EOF() cetak_ho

    public function sql($u_ser) {
        $query = "select a.description from user_auth as a
                  inner join user_user_auth as  x on a.id = x.user_auth_id
                  inner join user as b on b.id = x.user_id
                  where b.id = (select id from user where username='".$u_ser."')";
        $hasil = $this->db->query($query);
        return $hasil->row();
    }
}