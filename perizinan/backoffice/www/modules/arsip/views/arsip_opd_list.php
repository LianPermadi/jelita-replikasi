<div id="content">
  <div class="post">
    <div class="title">
      <?php echo $this->lib_date->view_title($page_name); ?>
    </div>
    <div class="entry">
      <fieldset id="half">
        <legend> Filter Data Tanggal Permohonan </legend>
        <?php
  	    echo form_open('arsip/timteknis');
        ?>
        <div id="statusRail">  
          <div id="leftRail">
            <?php
            echo form_label('Tanggal Awal','d_tahun');
            ?>
          </div>
          <div id="rightRail">
            <?php
            $periodeawal_input = array('name'  => 'tgla',
                                       'value' => $tgla,
                                       'class' => 'input-wrc',
                                       'readOnly'=>TRUE,
                                       'class' => 'monbulan');
            echo form_input($periodeawal_input);
            ?>
          </div>
        </div>
        <div id="statusRail">
          <div id="leftRail">
            <?php
            echo form_label('Tanggal Akhir','d_tahun');
            ?>
          </div>
          <div id="rightRail">
            <?php
            $periodeakhir_input = array('name'  => 'tglb',
                                        'value' => $tglb,
                                        'class' => 'input-wrc',
                                        'readOnly'=>TRUE,
                                        'class' => 'monbulan');
            echo form_input($periodeakhir_input);
            ?>
          </div>
        </div>
        <div id="statusRail">
          <div id="leftRail"></div>
          <div id="rightRail">
            <?php
            $filter_data = array('name' => 'button',
                                 'class' => 'button-wrc',
                                 'content' => 'Filter',
                                 'value' => 'Filter');
            echo form_submit($filter_data);
            ?>
          </div>
        </div>
        <?php
        echo form_close();
        ?>
      </fieldset>
          <a href="timteknis/cetak_excel_2/<?php echo $tgla.'/'.$tglb; ?>">
            <button class="button-wrc">Cetak Excel</button>
          </a>
    </div>
<?php
if($level == 1){
header("Content-type: application/vnd-ms-excel");
// header("Content-Disposition: attachment; filename=Data MUTASI PERSEDIAAN.xls");
// header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=ARSIP PERIZINAN.xls");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);
ob_start();
} 
?>
    <div class="entry">
      <?php
      if($level == 1){
      ?>
      <table width='100%' cellspacing='0' cellpadding='0' border='1' style='border-style:solid; border-width:thin;font-size:10px;font-weight:bold;'>
      <?php 
    }else{
      ?>
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="sk">
        <?php
}
        ?>
        <thead>
          <tr>
            <th width="2%">No</th>
            <th width="9%">No Pendaftaran<br>Tanggal Permohonan<br>Asal Permohonan</th>
            <th width="20%">Pemohon</th>
            <th width="43%">Jenis Izin<br>Objek Izin/Lokasi Izin</th>
            <th width="20%">No Surat Keputusan<br>Tanggal Surat Keputusan</th>
            <?php
if($level == 0){
            ?>
	          <th width="6%">Aksi</th>
            <?php
}
            ?>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 1;
          $results = mysql_query($list);
          while ($rows = mysql_fetch_assoc(@$results)){
          	//cek Mengisi SKM
	          $isi_skm = new skm_data_skm();
	          $isi_skm->where('permohonan_id', $rows['id'])->get();
	          $skm = FALSE;
	          $file_skm =  'skm_merah.png';
            $ket_skm = 'Perusahaan Belum Mengisi Survay';
	          if($isi_skm->permohonan_id &&  $isi_skm->total != 0){ //jika ditemukan No id
	            $skm = TRUE;
	            $file_skm =  'skm_ijo.png';
              $ket_skm = 'Perusahaan Sudah Mengisi Survay';
	          }
	          //EOF() cek Mengisi SKM   	
            $no_surat = $rows['no_surat'];
			      if($rows['no_surat_edit'] == '') {
              $tgl_surat = $rows['tgl_surat'];
		      	} else {
              $no_surat = $rows['no_surat_edit'];
              $tgl_surat = $rows['tgl_surat_edit'];
		      	}

            //$c_cetak = $rows['c_cetak'];
		      	//if($c_cetak == "0") {
      		  //  $b = '<span style="color: Red">';
			      //  $be = '</span>';
            //} else {
			        $b = '';
			        $be = '';
		      	//}

			      //switch($rows['approve']){
            //  case 1 : $cetakOK = FALSE; $approve = 'Menunggu Approve ESL IV' ; $ky_esl = 'esl4mrh.png';  break;
            //  case 4 : $cetakOK = FALSE; $approve = 'Menunggu Approve ESL III'; $ky_esl = 'esl3mrh.png';  break;
			      //  case 3 : $cetakOK = FALSE; $approve = 'Menunggu Approve Kepala' ; $ky_esl = 'kepalamrh.png';break;
			      //  case 2 : $cetakOK = TRUE ; $approve = ''                        ; $ky_esl = 'kepalaijo.png';break;
			      //  default: $cetakOK = FALSE; $approve = 'Menunggu Penguncian Data'; $ky_esl = 'pengolahmrh.png';break;
            //}
            
			      //if($cetakOK && $c_cetak == '0') {
			      //  $b = '<span style="color: Blue">';
			      //  $be = '</span>';
            //}
            
            // Cek tampil berdasar peran Kab/Kota masing2
            $tampil = TRUE;
            if($tembusan_arsip_ins_lain){  
              $tampil = FALSE;
              $val_kab = Array();
              if (!empty($this->kab) && !empty($rows['trkelurahan_id'])) {
                $kelurahan = $rows['trkelurahan_id'];
                $val_kab = explode("^", $this->kab);
                $trkel = $this->db->query("select kd_kab from trkelurahan where id = ".$kelurahan)->row_array();
                $kd_kab = $trkel['kd_kab'];
                if(in_array($kd_kab, $val_kab)) {
                  $tampil = TRUE;
                }
              }else{
                $tampil = TRUE;
              }
            }
              // var_dump($this->session->userdata('id_auth'));
              // if($this->session->userdata('id_auth') == '338'){
              //   $tampil = TRUE;
              // }
            // EOF() Cek tampil berdasar peran Kab/Kota masing2
            
            if($tampil){
              ?>
              <tr>
                <td valign='top'><?php echo $i; ?></td>
                <td valign='top'>
                	<?php 
			            echo $b.$rows['pendaftaran_id'].$be."<br>";
		              if($rows['idjenis'] == '1') $b.$tgl_permohonan = $rows['d_terima_berkas']; 
                    else if($rows['idjenis'] == '2') $tgl_permohonan = $rows['d_perubahan'];
                    else if($rows['idjenis'] == '3') $tgl_permohonan = $rows['d_perpanjangan'];
                    else if($rows['idjenis'] == '4') $tgl_permohonan = $rows['d_daftarulang'];
                    if($tgl_permohonan){
                      if($tgl_permohonan != '0000-00-00') echo $b.$this->lib_date->mysql_to_human($tgl_permohonan).$be."<br>";
                    }
                    echo $b.$rows['kd_gerai'].$be;
		              ?>
			          </td>
                <td valign='top'><?php echo $b.$rows['n_pemohon'].$be; ?></td>
                <td valign='top'><?php echo $b.$rows['n_perizinan']."<br>".$rows['a_izin'].$be;?></td>
                <td valign='top'>
                	<?php
                	if($no_surat=='Belum Penomoran') $no_surat = 'Penomoran Manual (Non System)';
				          $posisi=strpos($no_surat,"No.KP");
                  $ctk_no_surat = $no_surat;
                  $ctk_no_surat1 = '';
                  if($posisi > 0){
                    $ctk_no_surat = substr($no_surat,0,$posisi);
                    $ctk_no_surat1 = substr($no_surat,$posisi,strlen($no_surat));
                  }
                  if($ctk_no_surat1 == ''){
                    echo $b.$no_surat.$be."<br>";
                  }else{
                    echo $b.$ctk_no_surat.'<br>'.$ctk_no_surat1.$be.'<br>';
                  }
				          if($tgl_surat){
                    if($tgl_surat != '0000-00-00') 
						  	      echo $b.$this->lib_date->mysql_to_human($tgl_surat).$be;
						        else
						  	      echo $b.'-'.$be;
                  }else{
						        echo $b.'-'.$be;
                  }
     			        ?>
			        	</td>
                <?php
if($level == 0){
  ?>
                <td valign='top'>
                  <?php
				          $img_lihat = array('src' => base_url().'assets/images/icon/information.png',
                                     'alt' => 'Lihat Detail',
                                     'title' => 'Lihat Detail',
                                     'border' => '0');
                  $img_excel = array('src' => base_url().'assets/images/icon/navigation-down.png',
                                    'alt' => 'Download Data Excel',
                                    'title' => 'Download Data Excel',
                                    'border' => '0');
                  $vskm = array('src' => base_url().'assets/images/icon/'.$file_skm,
                                'title' => $ket_skm,
                                'border' => '0');
                  if(!$tembusan_arsip_ins_lain){                  
                    echo anchor(site_url('arsip/edit') .'/L/'.$rows['id'].'/13', img($img_lihat))."&nbsp;";
				            echo anchor(site_url('arsip/timteknis/cetak_excel') .'/'. $rows['id'], img($img_excel))."&nbsp;";
				          }
				          // echo img($vskm);
				          // kondisi jika berbayar maka sk bisa di cetak jika sudah di bayar
                  if($rows['c_status_bayar'] === '1' && $rows['trkelompok_perizinan_id'] === '4' || $rows['trkelompok_perizinan_id'] != '4'  ){
                    if($rows['indeks'] == 'AKDP'){ // Jika AKDP
                      //$akdp_cetak = new akdp_cetak();
	                    //$akdp_cetak->where('pendaftaran_id', $rows['pendaftaran_id'])->get();
	                    //if($akdp_cetak->approve == 2){
	                    //	if($retribusi){
						  		    //    //echo anchor(site_url('cetakizin/cetak_skkp').'/'.$akdp_cetak->id, img($img_cetak))."&nbsp;";
						  		    //    $n_file_sk='SK_'.$rows['pendaftaran_id'].'.pdf';
					      		  //    $n_file_kp='KP_'.$rows['pendaftaran_id'].'.pdf';
                      //    $lok_fileDr = 'assets/skpdf/';
                      //    $lok_fileSE = 'assets/esignfile/';
                      //    $stat_sk = TRUE;
                      //    if(file_exists($lok_fileSE.$n_file_sk)){            // cek PDF SE
                      //      $stat_sk = FALSE;
                      //    }else{
                      //      if(file_exists($lok_fileDr.$n_file_sk)){          // cek PDF Non SE
                      //        $stat_sk = FALSE;
                      //      }
                      //    }
                      //    $stat_kp = TRUE;
                      //    if(file_exists($lok_fileSE.$n_file_kp)){            // cek PDF SE
                      //      $stat_kp = FALSE;
                      //    }else{
                      //      if(file_exists($lok_fileDr.$n_file_kp)){          // cek PDF Non SE
                      //        $stat_kp = FALSE;
                      //      }
                      //    }
						  		    //    $cetak_sk = array('src' => base_url().'assets/images/icon/print1.png',
                      //                      'alt' => 'Cetak Surat Keputusan',
                      //                      'title' => 'Cetak Surat Keputusan',
                      //                      'border' => '0');
                      //    $cetak_kp = array('src' => base_url().'assets/images/icon/print1.png',
                      //                      'alt' => 'Cetak Kartu Pengawasan',
                      //                      'title' => 'Cetak Kartu Pengawasan',
                      //                      'border' => '0');
						  		    //    if(!$stat_sk){
						  		    //    	echo '<br>';
						  	      //      echo anchor(site_url('cetakizin/download_sk').'/'.$rows['pendaftaran_id'], img($cetak_sk))."&nbsp;";
						  	      //      echo 'SK';
						  	      //    }
						  	      //    if(!$stat_kp){
						  	      //      echo '<br>';
						  	      //      echo anchor(site_url('cetakizin/download_kp').'/'.$rows['pendaftaran_id'], img($cetak_kp))."&nbsp;";
						  	      //      echo 'KP';
						  	      //    }
						  		    //  }
						      	  //}else{
						  		      //$ky_esl4 = array('src' => 'assets/images/icon/esl4mrh.png',
                        //                 'title' => 'Menunggu Approve ESL IV',
                        //                 'border' => '0');
		  			  			    //$ky_esl3 = array('src' => 'assets/images/icon/esl3mrh.png',
                        //                 'title' => 'Menunggu Approve ESL III',
                        //                 'border' => '0');
    				  	    	  //$ky_kepala = array('src' => 'assets/images/icon/kepalamrh.png',
                        //                 'title' => 'Menunggu Approve KEPALA',
                        //                 'border' => '0');
						  		      //switch($akdp_cetak->approve) {
						  			    //  case 1: 
                        //    echo img($ky_esl4);
                        //    break;
                        //  case 4: 
                        //    echo img($ky_esl3);
                        //    break;
                        //  case 3:
                        //    echo img($ky_kepala);
                        //    break;
                        //} 
						          //}
                    }else{ // Jika Bukan AKDP
                    	//if(file_exists('assets/esignfile/SK_'.$rows['pendaftaran_id'].'.pdf')) {
                      //  echo anchor(site_url('arsip/timteknis/cetak').'/'.$rows['id'], img($img_cetak))."&nbsp;"; // ada templet '/1/x'
                      //}
	  			          }
                  }
                  echo '<br>';
                  $dsign = array('src' => base_url().'assets/images/icon/dsign.png',
                                 'title' => 'Digital Signature BSrE',
                                 'border' => '0');
                  $img_cetakSK = array('src' => base_url().'assets/images/icon/print1.png',
                                       'alt' => 'Download Surat Keputusan',
                                       'title' => 'Download Surat Keputusan',
                                       'border' => '0');
                  $img_cetakOff = array('src' => base_url().'assets/images/icon/print_off.png',
                                       'alt' => 'Download Surat Keputusan menunggu SKM',
                                       'title' => 'Download Surat Keputusan menunggu SKM',
                                       'border' => '0');
                  $img_cetakKP = array('src' => base_url().'assets/images/icon/print1.png',
                                       'alt' => 'Download Kartu Pengawasan',
                                       'title' => 'Download Kartu Pengawasan',
                                       'border' => '0');
                  if($mencetak){                     
                    if(file_exists('assets/esignfile/SK_'.$rows['pendaftaran_id'].'.pdf')) {
                      // if($skm){
                        echo anchor(site_url('arsip/timteknis/cetak').'/'.$rows['id'].'/se', img($img_cetakSK))."&nbsp;"; // ada templet '/1/x'
                      // }else{
                      //   echo img($img_cetakOff);
                      // }	  
                      echo img($dsign);
                      echo '<br>';
                    }else{
                      if(file_exists('assets/skpdf/SK_'.$rows['pendaftaran_id'].'.pdf')) {
                        if($skm){
                          echo anchor(site_url('arsip/timteknis/cetak').'/'.$rows['id'].'/sn', img($img_cetakSK))."&nbsp;"; // ada templet '/1/x'	
                        }else{
                          echo img($img_cetakOff);
                        }
                      }
                    }  
                    if(file_exists('assets/esignfile/KP_'.$rows['pendaftaran_id'].'.pdf')) {
                    	if($skm){
                        echo anchor(site_url('arsip/timteknis/cetak').'/'.$rows['id'].'/ke', img($img_cetakKP))."&nbsp;"; // ada templet '/1/x'
                      }else{
                        echo img($img_cetakOff);
                      }
                      echo img($dsign);
                    }else{
                      if(file_exists('assets/skpdf/KP_'.$rows['pendaftaran_id'].'.pdf')) {
                      	if($skm){
                          echo anchor(site_url('arsip/timteknis/cetak').'/'.$rows['id'].'/kn', img($img_cetakKP))."&nbsp;"; // ada templet '/1/x'
                        }else{
                          echo img($img_cetakOff);
                        }  
                      }	
                    }
                  }
                  ?>
                </td>
                <?php
                } 
                ?>
              </tr>
              <?php
              $i++;
            }
          }
	        ?>
        </tbody>
      </table>
<?php
if($level == 1){
ob_end_flush();
exit;
}
?>
    </div>
  </div>
  <br style="clear: both;" />
</div>

<script>
  $(document).ready(function(){
    window.open(url, "_blank"); // will open new tab on document ready
    location.reload();
  });
</script>