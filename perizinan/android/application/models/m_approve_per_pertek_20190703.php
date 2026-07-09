<?php
class M_approve_per_pertek extends CI_Model {

  function ambildata($userid) {
    $otherdb = $this->load->database('otherdb',TRUE);
    $tg1 = date("Y-m-d");
    $tg2 = date("Y-m-d");
    $h= '9';
    
    $otherdb->select('(case when eselon = 4 then 1 
                      when eselon = 3 then 4 when eselon = 2 then 3 END )eselon');
    $otherdb->from('tmpegawai');
    $otherdb->join('tmpegawai_user','tmpegawai.id = tmpegawai_user.tmpegawai_id','left');
    $otherdb->where('tmpegawai_user.user_id',$userid);
    $ambileselon =  $otherdb->get();
    foreach ($ambileselon->result() as $data2) {
      $h = $data2->eselon;
    }
    
    $trperizinan_id = '';
    $otherdb->select('trperizinan_id');
    $otherdb->from('trperizinan_user');
    $otherdb->where('user_id',$userid);
    $ambilperizinanid =  $otherdb->get();
    foreach($ambilperizinanid->result() as $data3) {
      $trperizinan_id[] = $data3->trperizinan_id;
    }
    /*
    $otherdb->select('tmpermohonan.bidang,tmperusahaan.n_perusahaan,tmpermohonan.pendaftaran_id,tmpermohonan.id,
                      trperizinan.n_perizinan,tmpermohonan.d_terima_berkas,trperizinan.kordinatttd,trperizinan.kordinatqr,trperizinan.kertas');
    $otherdb->from('tmpermohonan');
    $otherdb->join('tmpermohonan_trperizinan', 'tmpermohonan.id = tmpermohonan_trperizinan.tmpermohonan_id', 'left');
    $otherdb->join('trperizinan', 'trperizinan.id = tmpermohonan_trperizinan.trperizinan_id', 'left');
    $otherdb->join('tmpermohonan_tmperusahaan', 'tmpermohonan.id = tmpermohonan_tmperusahaan.tmpermohonan_id', 'left');
    $otherdb->join('tmperusahaan', 'tmpermohonan_tmperusahaan.tmperusahaan_id = tmperusahaan.id', 'left');
    $otherdb->where('tmpermohonan.approve',$h);
    $otherdb->where('tmpermohonan.status_berkas','Izin Disetujui');
    $otherdb->where('trperizinan.e_sertifikat','1');
    $otherdb->where("(trperizinan.e_ttd='1' OR trperizinan.e_ttd='2')", NULL, FALSE);
    $otherdb->where_in('trperizinan.id',$trperizinan_id);
    */
    $otherdb->select('tmsurat_keluar.id,tmsurat_keluar.tmpermohonan_id,tmsurat_keluar.no_pertek_awal,tmsurat_keluar.no_surat,
                      tmsurat_keluar.no_pertek_akhir,tmsurat_keluar.tgl_surat,tmsurat_keluar.kepada,tmpermohonan.trsektor_id,
                      tmpermohonan.bidang,tmpermohonan.pendaftaran_id');
    $otherdb->from('tmsurat_keluar');
    $otherdb->join('tmpermohonan', 'tmpermohonan.id = tmsurat_keluar.tmpermohonan_id', 'left');
    $otherdb->join('tmpermohonan_trperizinan', 'tmpermohonan.id = tmpermohonan_trperizinan.tmpermohonan_id', 'left');
    $otherdb->join('trperizinan', 'trperizinan.id = tmpermohonan_trperizinan.trperizinan_id', 'left');
    $otherdb->where('tmsurat_keluar.approve',$h);
    $otherdb->where('tmsurat_keluar.perihal','Pertimbangan Teknis');
    $otherdb->where_in('trperizinan.id',$trperizinan_id);
    $ambildata = $otherdb->get();
    if($ambildata->num_rows() > 0) {
      foreach($ambildata->result() as $data) {
        $hasilakdp_cetak[] = $data;
      }
      return $hasilakdp_cetak;
    }
  }

  function caridata($tg1,$tg2,$userid) {
    if($userid == 48){
      //$sts = '1';
      $where = 'approve = 1';
    }else if ($userid == 257){
      //$sts = '4';
      $where = 'approve = 4';
    }
    else if ($userid == 178){
      //$sts = '3';
      $where = 'approve = 3';
    }else{
      $where = '(approve = 1 or approve = 2 or approve = 3 or approve = 4)';
    }
    $otherdb = $this->load->database('otherdb',TRUE);
    //$ambildata = $otherdb->get('akdp_cetak');
    
    $otherdb->select('*');
    $otherdb->from('akdp_cetak');
    $otherdb->where($where);
    $otherdb->where('tgl_kp_awal <=',$tg2);
    $otherdb->where('tgl_kp_awal >=',$tg1);
    
    $ambildata = $otherdb->get();
    
    if($ambildata->num_rows() > 0) {
      foreach ($ambildata->result() as $data) {
        $hasilakdp_cetak[] = $data;
      }
      return $hasilakdp_cetak;
    }
  }
  
  function update_permohonanemail($iduser) {
    $otherdb = $this->load->database('otherdb',TRUE);
    $otherdb->select(' n_pegawai,eselon ,trperizinan_user.trperizinan_id');
    $otherdb->from('tmpegawai');
    $otherdb->join('tmpegawai_user','tmpegawai.id = tmpegawai_user.tmpegawai_id','left');
    $otherdb->join('user','user.id = tmpegawai_user.user_id','left');
    $otherdb->join('trperizinan_user','trperizinan_user.user_id = user.id','left');
    $otherdb->join('tmpermohonan_trperizinan','trperizinan_user.trperizinan_id = tmpermohonan_trperizinan.trperizinan_id','left');
    $otherdb->join('tmpermohonan','tmpermohonan.id = tmpermohonan_trperizinan.tmpermohonan_id','left');
    $otherdb->where('tmpermohonan.id','94062');
    $otherdb->where('eselon','3');
    $otherdb->where('trperizinan_user.trperizinan_id','249');
    //$otherdb->where('user.email <>','');
    $ambileselon =  $otherdb->get();
    if($ambileselon->num_rows() > 0) {
      foreach($ambileselon->result() as $data) {
        $hasilemail[] = $data;
      }
      return $hasilemail;
    }
  }

  function update_permohonan($iduser) {
    date_default_timezone_set("Asia/Bangkok");
    $otherdb = $this->load->database('otherdb',TRUE);
    $otherdb->select('eselon,nip');
    $otherdb->from('tmpegawai');
    $otherdb->join('tmpegawai_user','tmpegawai.id = tmpegawai_user.tmpegawai_id','left');
    $otherdb->where('tmpegawai_user.user_id',$iduser);
    $ambileselon =  $otherdb->get();
    $h = '';
    $nip = '';
    foreach($ambileselon->result() as $data2) {
      $h = $data2->eselon;
      $nip = $data2->nip;
    }
    $update = $this->input->post('msg');
    //$n_file = $this->input->post('n_file'); 
    //$kordinatttd = $this->input->post('kordinatttd');
    //$kordinatqr = $this->input->post('kordinatqr');
    $passphrase = $this->input->post('passphrase');
    //$kertas = $this->input->post('kertas');
    $nilai = 0;
   	?>
     
     <script src="<?php echo base_url(); ?>assets/esign/jquery-latest.js"></script>

     <?php
    for($i=0; $i < count($update); $i++) {
    	$ambildata = $otherdb->select('no_surat,tgl_surat')
                           ->from('tmsurat_keluar')
                           ->where('id',$update[$i])
                           ->get();
      foreach($ambildata->result() as $row) {
      	$no_surat = $row->no_surat;
      	$tgl_surat = $row->tgl_surat;
      } 
      
      if($h	== 4){
        $data=array('approve'=>'4');
      }else if($h == 2){
        //$data=array('approve'=>'2');
      }else if($h == 3){
        $data=array('approve'=>'3');

        $this->load->library('cfpdf');
        $this->load->library('cfpdi');
        $pdf = new FPDI();
        
        $i_urut = strlen($no_surat);
        $bcno_urut_pertek = $no_surat;
        for($j = 5; $j > $i_urut; $j--) {
          $bcno_urut_pertek = "0" . $bcno_urut_pertek;
        }
        $cod_bar_thn = $bcno_urut_pertek.date("Y",strtotime($tgl_surat));
        $n_file = 'PT_'. $cod_bar_thn.'.pdf';
        
        $root = $_SERVER['DOCUMENT_ROOT'];
        $path_pdf    = $root.'/kaltara/backoffice/assets/file_mohon_sartek/'.$n_file;
        $output_path = $root.'/kaltara/backoffice/assets/file_mohon_sartekSE/'.$n_file;

        if(!copy($path_pdf, $output_path)){
         echo "gagal copy<br>";
         var_dump(copy($path_pdf, $output_path));die; // jika gagal
        }

        

        
        
        // $filepdf = $_SERVER['DOCUMENT_ROOT'].'/kaltara/backoffice/assets/file_mohon_sartek/'.$n_file;  // untuk Server
       
        // //ttd digital
        // $n_SE = (str_replace(' ','',$nip)).'.p12';
        // $root = $_SERVER['DOCUMENT_ROOT'];
        // $path_jar    = $root.'/kaltara/android/assets/esign/signer/JSignPdf.jar';
        // $path_pdf    = $root.'/kaltara/backoffice/assets/file_mohon_sartek/'.$n_file;
        // $path_p12    = $root.'/kaltara/android/assets/esign/signer/'.$n_SE;
        // $output_path = $root.'/kaltara/backoffice/assets/file_mohon_sartekSE/';
        // $tsa_url     = "http://tsa-bsre.bssn.go.id/";
        // $ocsp        = "http://cvs-osd.lemsaneg.go.id/ocsp";
        // $command = 'java -jar "'.$path_jar.'" "'.$path_pdf.'" -kst PKCS12 -ksf "'.$path_p12.'" -ksp "'.$passphrase.
        //            '" -l "Dinas PMPTSP Kalimantan Utara" -r "Pengesahan Surat Permohonan Pertek" -c "kontak yang bisa dihubungi" -tsh SHA256 -ha SHA256 -d "'.$output_path.
        //            '" -os "" -ts '.$tsa_url.' -ta PASSWORD -tsu "coba" -tsp "1234"';
        // $exe = exec($command, $val, $er);
        // if($er == 0 || $er == 3){
        // 	// jika berhasil
        //   $nilai++;
        // }else{
        //   redirect('approve_per_pertek/pesan_permohonanesign'); // jika gagal
        // }
        // EOF() ttd digital
        
        // Kirim Notifikasi ke tim teknis
        
        // EOF() Kirim Notifikasi ke tim teknis
      } 
      
      // Save Data
      $otherdb->where('no_surat', $no_surat);
      $otherdb->where('tgl_surat', $tgl_surat);
      $otherdb->update('tmsurat_keluar',$data);
      //EOF() Save Data
    }
    return $nilai;
  }

  function detail_data($id) {
    $otherdb = $this->load->database('otherdb',TRUE);
    $ambildata = $otherdb->select('akdp_cetak.*,akdptrayek.trayek')
                         ->from('akdp_cetak')
                         ->join('akdptrayek', 'akdp_cetak.kode_trayek = akdptrayek.kode_trayek', 'left')
                         ->where('akdp_cetak.id',$id)
                         ->get();
    
    if($ambildata->num_rows() > 0) {
      foreach($ambildata->result() as $data) {
        $hasilakdp_cetak[] = $data;
      }
      return $hasilakdp_cetak;
    }
  }

  function detail_datapermohonan($id) {
    $otherdb = $this->load->database('otherdb',TRUE);
    $otherdb->select('no_surat,tgl_surat');
    $otherdb->from('tmsurat_keluar');
    $otherdb->where('id',$id);
    $ambildata = $otherdb->get();
    foreach ($ambildata->result() as $data) {
      $no_surat = $data->no_surat;
      $tgl_surat = $data->tgl_surat;
    }
    
    $otherdb->select('tmsurat_keluar.id,tmsurat_keluar.tmpermohonan_id,tmsurat_keluar.no_pertek_awal,
                      tmsurat_keluar.no_pertek_akhir,tmsurat_keluar.kepada,tmpermohonan.trsektor_id,
                      tmpermohonan.pendaftaran_id');
    $otherdb->from('tmsurat_keluar');
    $otherdb->join('tmpermohonan', 'tmpermohonan.id = tmsurat_keluar.tmpermohonan_id', 'left');
    $otherdb->where('tmsurat_keluar.no_surat',$data->no_surat);
    $otherdb->where('tmsurat_keluar.tgl_surat',$data->tgl_surat);
    $ambildata = $otherdb->get();
    if($ambildata->num_rows() > 0) {
      foreach ($ambildata->result() as $data) {
        $hasil[] = $data;
      }
      return $hasil;
    }
  }

  function caridata_surat($no_surat,$userid) {
    $otherdb = $this->load->database('otherdb',TRUE);
    $h= '9';
    $otherdb->select('(case when eselon = 4 then 1 when eselon = 3 then 4 when eselon = 2 then 3 END )eselon');
    $otherdb->from('tmpegawai');
    $otherdb->join('tmpegawai_user','tmpegawai.id = tmpegawai_user.tmpegawai_id','left');
    $otherdb->where('tmpegawai_user.user_id',$userid);
    $ambileselon =  $otherdb->get();
    foreach($ambileselon->result() as $data2) {
      $h = $data2->eselon;
    }
    $otherdb->select('trperizinan_id');
    $otherdb->from('trperizinan_user');
    $otherdb->where('user_id',$userid);
    $ambilperizinanid =  $otherdb->get();
    foreach($ambilperizinanid->result() as $data3) {
      $trperizinan_id[] = $data3->trperizinan_id;
    }
    $otherdb->select('tmsurat_keluar.id,tmsurat_keluar.tmpermohonan_id,tmsurat_keluar.no_pertek_awal,tmsurat_keluar.no_surat,
                      tmsurat_keluar.no_pertek_akhir,tmsurat_keluar.tgl_surat,tmsurat_keluar.kepada,tmpermohonan.trsektor_id,
                      tmpermohonan.bidang,tmpermohonan.pendaftaran_id');
    $otherdb->from('tmsurat_keluar');
    $otherdb->join('tmpermohonan', 'tmpermohonan.id = tmsurat_keluar.tmpermohonan_id', 'left');
    $otherdb->join('tmpermohonan_trperizinan', 'tmpermohonan.id = tmpermohonan_trperizinan.tmpermohonan_id', 'left');
    $otherdb->join('trperizinan', 'trperizinan.id = tmpermohonan_trperizinan.trperizinan_id', 'left');
    $otherdb->where('tmsurat_keluar.no_surat',$no_surat);
    $otherdb->where('tmsurat_keluar.approve',$h);
    $otherdb->where('tmsurat_keluar.perihal','Pertimbangan Teknis');
    $otherdb->where_in('trperizinan.id',$trperizinan_id);
    $ambildata = $otherdb->get();
    
    if($ambildata->num_rows() > 0) {
      foreach($ambildata->result() as $data) {
        $hasilakdp_cetak[] = $data;
      }
      return $hasilakdp_cetak;
    }
  }

	function update_revisi($id,$msg_revisi,$kode){
    $otherdb = $this->load->database('otherdb',TRUE);
    $data=array('approve'=>'0');
    $otherdb->where('id',$id);
    $cek = $otherdb->update('tmpermohonan',$data);
    if($cek){
      $data=array('pesan_revisi'=>$msg_revisi);
      $otherdb->where('id',$kode);
      $otherdb->update('tmsk',$data);
      $data=array('tg_kyStafPTSP'=>'', 'tg_kyEsl4PTSP'=>'', 'tg_kyEsl3PTSP'=>'', 'tg_kyKaPTSP'=>'',
                  'kyStafPTSP'=>'', 'kyEsl4PTSP'=>'', 'kyEsl3PTSP'=>'', 'kyKaPTSP'=>'');
      $otherdb->where('tmpermohonan_id',$id);
      $otherdb->update('tmpermohonan_ky',$data);
    }
    redirect('approve_esign/index');
  }
  
  function ambil_tmsk($id_permohonan){
    $otherdb = $this->load->database('otherdb',TRUE);
    $ambildata = $otherdb->select('tmsk.id')
                         ->from('tmsk')
                         ->join('tmpermohonan_tmsk', 'tmpermohonan_tmsk.tmsk_id=tmsk.id', 'left')
                         ->where('tmpermohonan_tmsk.tmpermohonan_id',$id_permohonan)
                         ->get();
    if($ambildata->num_rows() > 0) {
      foreach($ambildata->result() as $data) {
        $kode_tmsk[] = $data;
      }
      return $kode_tmsk;
    }
  }

  function list_approve($userid) {
    $otherdb = $this->load->database('otherdb',TRUE);
    $otherdb->select('eselon');
    $otherdb->from('tmpegawai');
    $otherdb->join('tmpegawai_user','tmpegawai.id = tmpegawai_user.tmpegawai_id','left');
    $otherdb->where('tmpegawai_user.user_id',$userid);
    $ambileselon =  $otherdb->get();
       
    foreach($ambileselon->result() as $data2) {
      $h = $data2->eselon;
    }
    $tg1 = date('Y-m-d');
    $tg2 = date('Y-m-d');
    $trperizinan_id = '';
    $otherdb->select('trperizinan_id');
    $otherdb->from('trperizinan_user');
    $otherdb->where('user_id',$userid);
    $ambilperizinanid =  $otherdb->get();
    foreach($ambilperizinanid->result() as $data3) {
      $trperizinan_id[] = $data3->trperizinan_id;
    }
    
    $otherdb->select('tmpermohonan.pendaftaran_id,tmpermohonan.bidang,tmperusahaan.n_perusahaan,tmpermohonan.pendaftaran_id,tmpermohonan.id,
                      trperizinan.n_perizinan,tmpermohonan.d_terima_berkas,tmpermohonan_ky.kyStafPTSP,
                      tmpermohonan_ky.tg_kyEsl4PTSP,tmpermohonan_ky.tg_kyEsl3PTSP,tmpermohonan_ky.tg_kyKaPTSP,trperizinan.kordinatttd,trperizinan.kertas,trperizinan.kordinatqr');
    $otherdb->from('tmpermohonan');
    $otherdb->join('tmpermohonan_trperizinan', 'tmpermohonan.id = tmpermohonan_trperizinan.tmpermohonan_id', 'left');
    $otherdb->join('trperizinan', 'trperizinan.id = tmpermohonan_trperizinan.trperizinan_id', 'left');
    $otherdb->join('tmpermohonan_tmperusahaan', 'tmpermohonan.id = tmpermohonan_tmperusahaan.tmpermohonan_id', 'left');
    $otherdb->join('tmpermohonan_ky', 'tmpermohonan.id = tmpermohonan_ky.tmpermohonan_id', 'left');
    $otherdb->join('tmperusahaan', 'tmpermohonan_tmperusahaan.tmperusahaan_id = tmperusahaan.id', 'left');
    $otherdb->where('tmpermohonan.status_berkas','Izin Disetujui');
    $otherdb->where('trperizinan.e_sertifikat','1');
    $otherdb->where("(trperizinan.e_ttd='1' OR trperizinan.e_ttd='2')", NULL, FALSE);
    		
    if($h == '4'){
      $otherdb->where('DATE(tmpermohonan_ky.tg_kyEsl4PTSP) >=',$tg1);
      $otherdb->where('DATE(tmpermohonan_ky.tg_kyEsl4PTSP) <=',$tg2);
    }else if($h=='3'){
      $otherdb->where('DATE(tmpermohonan_ky.tg_kyEsl3PTSP) >=',$tg1);
      $otherdb->where('DATE(tmpermohonan_ky.tg_kyEsl3PTSP) <=',$tg2);
    }else if($h=='2'){
      $otherdb->where('DATE(tmpermohonan_ky.tg_kyKaPTSP) >=',$tg1);
      $otherdb->where('DATE(tmpermohonan_ky.tg_kyKaPTSP) <=',$tg2);				
    }else{}
    $otherdb->where('tmpermohonan.approve <>','0');
    $otherdb->where_in('trperizinan.id',$trperizinan_id);

    $ambildata = $otherdb->get();
    if($ambildata->num_rows() > 0) {
      foreach($ambildata->result() as $data) {
        $hasilakdp_cetak[] = $data;
      }
      return $hasilakdp_cetak;
    }
  }
  
  function cari_list_approve($userid,$tg1,$tg2) {
  	$otherdb = $this->load->database('otherdb',TRUE);
  	$otherdb->select('eselon');
    $otherdb->from('tmpegawai');
    $otherdb->join('tmpegawai_user','tmpegawai.id = tmpegawai_user.tmpegawai_id','left');
    $otherdb->where('tmpegawai_user.user_id',$userid);
    $ambileselon =  $otherdb->get();
    foreach($ambileselon->result() as $data2) {
  	  $h = $data2->eselon;
  	}
  	//$tg1 = date('Y-m-d');
  	//$tg2 = date('Y-m-d');
  	$trperizinan_id = '';
    $otherdb->select('trperizinan_id');
    $otherdb->from('trperizinan_user');
    $otherdb->where('user_id',$userid);
    $ambilperizinanid =  $otherdb->get();
    foreach($ambilperizinanid->result() as $data3) {
  	  $trperizinan_id[] = $data3->trperizinan_id;
  	}
  	$otherdb->select('tmpermohonan.pendaftaran_id,tmpermohonan.bidang,tmperusahaan.n_perusahaan,tmpermohonan.pendaftaran_id,tmpermohonan.id,
  	                  trperizinan.n_perizinan,tmpermohonan.d_terima_berkas,tmpermohonan_ky.kyStafPTSP,tmpermohonan_ky.tg_kyEsl4PTSP,
  	                  tmpermohonan_ky.tg_kyEsl3PTSP,tmpermohonan_ky.tg_kyKaPTSP,trperizinan.kordinatttd,trperizinan.kertas,trperizinan.kordinatqr');
  	$otherdb->from('tmpermohonan');
  	$otherdb->join('tmpermohonan_trperizinan', 'tmpermohonan.id = tmpermohonan_trperizinan.tmpermohonan_id', 'left');
  	$otherdb->join('trperizinan', 'trperizinan.id = tmpermohonan_trperizinan.trperizinan_id', 'left');
  	$otherdb->join('tmpermohonan_tmperusahaan', 'tmpermohonan.id = tmpermohonan_tmperusahaan.tmpermohonan_id', 'left');
  	$otherdb->join('tmpermohonan_ky', 'tmpermohonan.id = tmpermohonan_ky.tmpermohonan_id', 'left');
  	$otherdb->join('tmperusahaan', 'tmpermohonan_tmperusahaan.tmperusahaan_id = tmperusahaan.id', 'left');
  	$otherdb->where('tmpermohonan.status_berkas','Izin Disetujui');
  	$otherdb->where('trperizinan.e_sertifikat','1');
  	$otherdb->where("(trperizinan.e_ttd='1' OR trperizinan.e_ttd='2')", NULL, FALSE);
  	
  	if($h == '4'){
  	  $otherdb->where('DATE(tmpermohonan_ky.tg_kyEsl4PTSP) >=',$tg1);
  	  $otherdb->where('DATE(tmpermohonan_ky.tg_kyEsl4PTSP) <=',$tg2);
  	}else if($h=='3'){
  	  $otherdb->where('DATE(tmpermohonan_ky.tg_kyEsl3PTSP) >=',$tg1);
  	  $otherdb->where('DATE(tmpermohonan_ky.tg_kyEsl3PTSP) <=',$tg2);
  	}else if($h=='2'){
  	  $otherdb->where('DATE(tmpermohonan_ky.tg_kyKaPTSP) >=',$tg1);
  	  $otherdb->where('DATE(tmpermohonan_ky.tg_kyKaPTSP) <=',$tg2);				
  	}else{}
  	$otherdb->where('tmpermohonan.approve <>','0');
  	$otherdb->where_in('trperizinan.id',$trperizinan_id);
  	$ambildata = $otherdb->get();
  	if($ambildata->num_rows() > 0) {
  	  foreach($ambildata->result() as $data) {
  	    $hasilakdp_cetak[] = $data;
  	  }
  	  return $hasilakdp_cetak;
  	}
	}
}
?>