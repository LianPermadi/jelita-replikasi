<?php

class M_akdp_cetak extends CI_Model {

  function ambildata($userid) {
    $tg1 = date("Y-m-d");
    $tg2 = date("Y-m-d");
    if($userid == 175){
      //$sts = '1';
      $where = 'approve = 1';
    }else{
      if($userid == 176){
        //$sts = '4';
         $where = 'approve = 4';
      }else{
        if($userid == 178){
          //$sts = '3';
          $where = 'approve = 3';
        }else{
          //$where = '(approve = 1 or approve = 2 or approve = 3 or approve = 4)';
          $where = '(approve = 1 or approve = 3 or approve = 4)';
        }
      }
    }  
    $otherdb = $this->load->database('otherdb',TRUE);
    //$ambildata = $otherdb->get('akdp_cetak');
    $otherdb->select('*');
    $otherdb->from('akdp_cetak');
    //$otherdb->where('approve',$sts);
    $otherdb->where($where);
    //$otherdb->where('tgl_kp_awal <=',$tg2);
    //$otherdb->where('tgl_kp_awal >=',$tg1);
    $ambildata = $otherdb->get();
    if($ambildata->num_rows() > 0) {
      foreach($ambildata->result() as $data) {
        $hasilakdp_cetak[] = $data;
      }
      return $hasilakdp_cetak;
    }
  }

  function caridata($tg1,$tg2,$userid) {
    if($userid == 175){
      //$sts = '1';
      $where = 'approve = 1';
    }else{
      if($userid == 176){
        //$sts = '4';
        $where = 'approve = 4';
      }else{
        if($userid == 178){
          //$sts = '3';
          $where = 'approve = 3';
        }else{
          $where = '(approve = 1 or approve = 2 or approve = 3 or approve = 4)';
        }
      }
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
      foreach($ambildata->result() as $data) {
        $hasilakdp_cetak[] = $data;
      }
      return $hasilakdp_cetak;
    }
  }
	
  function update_akdp_cetak($iduser) {
    $otherdb = $this->load->database('otherdb',TRUE);
    $update = $this->input->post('msg');
    $passphrase = $this->input->post('passphrase');
    for($i=0; $i < count($update) ; $i++) { 
    	$akdpcetak = $otherdb->select('*');
      $akdpcetak = $otherdb->from('akdp_cetak');
    	$akdpcetak = $otherdb->where('id', $update[$i])->get();
    	foreach ($akdpcetak->result() as $data) {
    		$kypengolah = $data->kyStafPTSP;
    		$kyEsl4     = $data->kyEsl4PTSP;
    		$kyEsl3     = $data->kyEsl3PTSP;
    		$kyKa       = $data->kyKaPTSP;
        $dttek = $data->id_perusahaan.$data->jenis_kend.$data->no_kend.$data->no_uji.$data->merek.$data->tahun.$data->daya_angkut_org.
                 $data->daya_angkut_brg.$data->bahan_bakar.$data->jenis_pel.$data->kode_trayek.$data->masa_berlaku.$data->ket.
    				     $data->no_sartek.$data->tgl_sartek.$data->no_sk.$data->tgl_sk.$data->golongan.$data->nama_pemilik.$data->alamat_pemilik.
      			     $data->no_induk_kend.$data->tgl_penetepan.$data->keterangan_histori.$data->no_induk.$data->user_bo.$data->kp_id.
        		     $data->ex_no_kend.$data->ex_no_uji.$data->ex_nama_pemilik.$data->ex_alamat_pemilik.$data->ex_kode_trayek.$data->status.
    	    	     $data->no_kp.$data->tgl_kp_awal.$data->tgl_kp_akhir.$data->fasilitas.$data->sifat_pel.$data->nama_perusahaan.
    		         $data->alamat_perusahaan.$data->nama_pimpinan.$data->alamat_pimpinan.$data->info.$data->id_gol.$data->x.$data->tgl_penetapan_kp.
    		         $data->penetapan_oleh.$data->retribusi;
        $dttek = str_replace(' ','',$dttek);
        $kytek = md5($dttek);
        $nomor_kend = $data->no_kend;
      }
    	$simpan = FALSE;
    	if($iduser	== 175){  // id Oboy
        //$kytek = 2;
    		if($kypengolah == $kytek) {
    			$simpan = TRUE;
    			$data=array('approve'=>'4','kyEsl4PTSP'=>$kytek,'tg_kyEsl4PTSP'=>date("Y-m-d h:i:s"));
    		}else{
    			//echo 'Data Pengolah '.$kypengolah .' Data Approve '. $kytek.'<br>';
    			//echo ' Terdapat Perbedaan Data <br>';
    			//echo 'MOHON UNTUK DIREVISI KEMBALI ...!';
    			//die;
    		}
    	}else{
    	  if($iduser == 176){  // id bu Rina
    	    if($kypengolah == $kytek && $kyEsl4 == $kytek){ 
    	  		$simpan = TRUE;
    	    	$data=array('approve'=>'3','kyEsl3PTSP'=>$kytek,'tg_kyEsl3PTSP'=>date("Y-m-d h:i:s"));
    	  	}
    	  }else{
    	    if($iduser == 178){  // id pa Kadis
    	      //if($kypengolah == $kytek && $kyEsl4 == $kytek  && $kyEsl3 == $kytek) {
    	      $simpan = TRUE;
    	      $data=array('approve'=>'2','kyKaPTSP'=>$kytek,'tg_kyKaPTSP'=>date("Y-m-d h:i:s"));
    	      //}
          }
        }
      }    
    	$otherdb->where('id', $update[$i]);
    	if($simpan){ 
    	  $otherdb->update('akdp_cetak',$data);
    	}
    }
  }

  function update_akdp_cetak_revisi($iduser,$no_sk,$tgl_penetapan,$tgl_penetapan_kp,$no_kend,$akdpkendaraan_id) {
    if($akdpkendaraan_id == ''){
    }else{
      $akdp = $this->load->database('akdp',TRUE);
      $data=array('approve'=>'2');
      $akdp->where('no_kend',$no_kend);
      $akdp->where('id',$akdpkendaraan_id);
      $tes = $akdp->update('akdpkendaraan',$data);
      $otherdb = $this->load->database('otherdb',TRUE);
      $update = $this->input->post('msg');
      for($i=0; $i < count($update) ; $i++) { 
        $otherdb->where('id', $update[$i]);
        //$otherdb->delete('akdp_cetak');
        $data=array('approve'=>'0');
        $otherdb->update('akdp_cetak',$data);
      }
    }
  }
	
  function caridata_nokend($nokend,$userid) {
    if($userid == 175){
      //$sts = '1';
      $where = 'approve = 1';
    }else{
      if ($userid == 176){
        //$sts = '4';
        $where = 'approve = 4';
      }else{
        if($userid == 178){
    	    //$sts = '3';
    	    $where = 'approve = 3';
    	  }else{
    	    $where = '(approve = 1 or approve = 2 or approve = 3 or approve = 4)';
    	  }
    	}
    }	
    $otherdb = $this->load->database('otherdb',TRUE);
    //$ambildata = $otherdb->get('akdp_cetak');
    $otherdb->select('*');
    $otherdb->from('akdp_cetak');
    $otherdb->where($where);
    $otherdb->like('no_kend',$nokend);
    $ambildata = $otherdb->get();
    if($ambildata->num_rows() > 0) {
      foreach($ambildata->result() as $data) {
        $hasilakdp_cetak[] = $data;
      }
      return $hasilakdp_cetak;
    }
  }

  function update_revisi($id,$akdpkendaraan_id,$msg_revisi) {
    if($akdpkendaraan_id == ''){
    }else{
      $akdp = $this->load->database('akdp',TRUE);
      $data=array('approve'=>'2',
                  'msg_revisi'=>$msg_revisi
                 );
      //$akdp->where('no_kend',$no_kend);
      $akdp->where('id',$akdpkendaraan_id);
      $tes = $akdp->update('akdpkendaraan',$data);
      //}
      $otherdb = $this->load->database('otherdb',TRUE);
      $otherdb->where('id', $id);
      $otherdb->delete('akdp_cetak');
      redirect('akdp_cetak/index');
    }
  }
}
?>