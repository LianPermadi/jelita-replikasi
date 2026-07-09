<style>
    table tr td{padding-bottom: 5px; padding-left: 10px;}
    .ti_table{font-weight: bold; font-size: 14px; padding-bottom: 5px; padding-left: -10px;}
    em{font-weight: normal; font-size: 12px;}
</style>

<div class="isi">
  <div id="entry">
    <h2>Cek Status Izin</h2>
    <div class="kiri">
      <h3 align=center style='font-size:12px;'><p>Data Hasil Pencarian</p></h3> <hr/>
      <?php
      $jumlah = count($list);
      if($xvalid) { //$jumlah > 0
        $n=1;
        echo "<p style = 'margin-left:10px; font-size:12px;'>
                Berikut ini status terakhir permohonan izin yang Anda ajukan. Untuk keterangan lebih lengkap silakan datang ke Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu Provinsi Jawa Barat.
              </p> <br/>";
        $status_akhir = '';
        foreach ($list as $row) {
          $tracking = $row['tracking'];
    	     
          echo "<table border=0 style='font-size:13px; margin-left:10px; margin-bottom:10px;' cellpadding='0' cellspacing='0' width=95%>";
          if($n == 1){
          	$download = TRUE;
    	      $id = $row['id'];
            $no_pendaftaran = $row['no_pendaftaran'];
            $no_pendaftaran_cabut = $row['no_pendaftaran_cabut'];
    	      $sts_berkas = Strtoupper($row['sts_berkas']);
            $nama = $row['nama'];
            $permohonan = $row['permohonan'];
            $permohonan_cabut = $row['permohonan_cabut'];
            $indeks = $row['indeks'];
            $c_izin_dicabut = $row['c_izin_dicabut'];
    	      $status_akhir = $row['tracking'];
            $n_kelompok_izin = $row['n_kelompok_izin'];
            $kd_status = intval($row['kd_status']);
            $approve = intval($row['approve']);
            $skm = $row['skm'];
            if($row['no_surat'] == 'Tidak Ditinjau')
              $ditinjau = ' <b>('.strtoupper($row['no_surat']).')</b>';
            else
              $ditinjau = '';
            echo "<table border=0 style='font-size:13px; margin-left:10px; margin-bottom:10px;' cellpadding='0' cellspacing='0' width=95%>";
            echo   "<tr>";
            echo     "<td valign='top' width='15%'>No Pendaftaran</td>";
            echo     "<td valign='top' width='2%'>:</td>";
            echo     "<td valign='top' width='73%'>$no_pendaftaran</td>";
            echo   "</tr>";
            
            echo   "<tr>";
            echo     "<td valign='top' width='15%'>Nama Pemohon</td>";
            echo     "<td valign='top' width='2%'>:</td>";
            echo     "<td valign='top' width='73%'>$nama</td>";
            echo   "</tr>";
            
            echo   "<tr style='padding: 10px 5px; border-radius: 2px; margin-top:10px;'>";
            echo     "<td valign='top' width='15%'>Nama Perizinan</td>";
            echo     "<td valign='top' width='2%'>:</td>";
            echo     "<td valign='top' width='73%'>$permohonan</td>";
            echo   "</tr>";
            
            if($c_izin_dicabut == 3){
              echo   "<tr style='padding: 10px 5px; border-radius: 2px; margin-top:10px;'>";
              echo     "<td valign='top' width='15%'></td>";
              echo     "<td valign='top' width='2%'></td>";
              echo     "<td valign='top' width='73%'>Mencabut Izin $permohonan_cabut <br> Nomor Resi $no_pendaftaran_cabut</td>";
              echo   "</tr>";
            }
            
            if($c_izin_dicabut == 2){
            	$download = FALSE;
              echo   "<tr style='padding: 10px 5px; border-radius: 2px; margin-top:10px;'>";
              echo     "<td valign='top' width='15%'>Status Izin</td>";
              echo     "<td valign='top' width='2%'>:</td>";
              echo     "<td valign='top' width='73%'><b><span style='color: Red'>Izin Telah Dicabut</span></b></td>";
              echo   "</tr>";
            }
            
            if($c_izin_dicabut == 1){
            	$download = FALSE;
              echo   "<tr style='padding: 10px 5px; border-radius: 2px; margin-top:10px;'>";
              echo     "<td valign='top' width='15%'>Status Izin</td>";
              echo     "<td valign='top' width='2%'>:</td>";
              echo     "<td valign='top' width='73%'><b><span style='color: Red'>Dalam Proses Pencabutan</span></b></td>";
              echo   "</tr>";
            }
          
    	      echo "</table>";
            $n++;
          }else{
            $no=$n-2;
            if( $n == 2){ // cetak judul Status Permohonan
              echo "<table border=0 style='font-size:17px; margin-left:10px; ' cellpadding='0' cellspacing='0' width=95%>";
              echo   "<tr  style='padding: 10px 15px; border-radius: 2px; margin-top:10px;'>";
              echo     "<td>$tracking</td>"; 
              echo   "</tr>";
              echo "</table>";
            } 

            $test='';  // matikan jika ingin test tampil di posisi SELESAI
    	      ?>
            <div style="padding: 10px 15px;">
              <ul class="progress-tracker progress-tracker--vertical">
                <?php if ($kd_status == 0) {
                  echo '<li class="progress-step is-active" aria-current="step">';
                } elseif ($kd_status > 0) {
                  echo '<li class="progress-step is-complete">';
                } else {
                  echo '<li class="progress-step">';
                } ?>
                  <div class="progress-marker"></div>
                  <div class="progress-text">
                    <span class="progress-title">PENDAFTARAN ONLINE</span>
                    &nbsp;
                  </div>
                </li>

                <?php if ($kd_status == 1) {
                  echo '<li class="progress-step is-active" aria-current="step">';
                } elseif ($kd_status > 1) {
                  echo '<li class="progress-step is-complete">';
                } else {
                  echo '<li class="progress-step">';
                } ?>
                  <div class="progress-marker"></div>
                  <div class="progress-text">
                    <span class="progress-title">EVALUASI ADMINISTRASI</span>
                    &nbsp;
                  </div>
                </li>

                <?php if ($kd_status == 2) {
                  echo '<li class="progress-step is-active" aria-current="step">';
                } elseif ($kd_status > 2) {
                  echo '<li class="progress-step is-complete">';
                } else {
                  echo '<li class="progress-step">';
                } ?>
                  <div class="progress-marker"></div>
                  <div class="progress-text">
                    <span class="progress-title">PENJADWALAN TINJAUAN LAPANGAN</span>
                    &nbsp;
                  </div>
                </li>

                <?php if ($kd_status == 3) {
                  echo '<li class="progress-step is-active" aria-current="step">';
                } elseif ($kd_status > 3) {
                  echo '<li class="progress-step is-complete">';
                } else {
                  echo '<li class="progress-step">';
                } ?>
                  <div class="progress-marker"></div>
                  <div class="progress-text">
                    <span class="progress-title">EVALUASI DATA HASIL PENINJAUAN LAPANGAN (TIM TEKNIS)</span>
                    &nbsp;
                  </div>
                </li>

                <?php if ($kd_status == 4) {
                  echo '<li class="progress-step is-active" aria-current="step">';
                } elseif ($kd_status > 4) {
                  echo '<li class="progress-step is-complete">';
                } else {
                  echo '<li class="progress-step">';
                } ?>
                  <div class="progress-marker"></div>
                  <div class="progress-text">
                    <span class="progress-title">PENYUSUNAN PERTIMBANGAN TEKNIS (TIM TEKNIS)</span>
                    &nbsp;
                  </div>
                </li>

                <?php if ($kd_status == 5) {
                  echo '<li class="progress-step is-active" aria-current="step">';
                } elseif ($kd_status > 5) {
                  echo '<li class="progress-step is-complete">';
                } else {
                  echo '<li class="progress-step">';
                } ?>
                  <div class="progress-marker"></div>
                  <div class="progress-text">
                    <span class="progress-title">PENYUSUNAN NASKAH IZIN</span>
                    &nbsp;
                  </div>
                </li>

                <?php if ($kd_status == 6 && $approve != 2) {
                  echo '<li class="progress-step is-active" aria-current="step">';
                } elseif ($kd_status >= 6) {
                  echo '<li class="progress-step is-complete">';
                } else {
                  echo '<li class="progress-step">';
                } ?>
                  <div class="progress-marker"></div>
                  <div class="progress-text">
                    <span class="progress-title">APPROVAL NASKAH IZIN
                      <?php 
                      // echo $kd_status;
                        if ($kd_status >= 6) {
                          if($sts_berkas == 'IZIN DISETUJUI') {
                            if ($indeks != "AKDP") {
                              switch ($approve) {
                                case 1:
                                  echo " - MENUNGGU APPROVAL ESELON 4 ";
                                  break;
                                case 2:
                                  echo " - IZIN DISETUJUI";
                                  break;
                                case 3:
                                  echo " - MENUNGGU APPROVAL ESELON 2";
                                  break;
                                case 4:
                                  echo " - MENUNGGU APPROVAL ESELON 3";
                                  break;
                                default:
                                  echo " - MENUNGGU PEMBUATAN BERKAS OLEH PENGOLAH";
                                  break;
                              }
                            }
                            
                            // if ($approve == 2) {
                            //   echo " - IZIN DISETUJUI";
                            // } elseif ($approve == 3) {
                            //   echo " - MENUNGGU APPROVAL ESELON 2";
                            // } elseif ($approve == 4) {
                            //   echo " - MENUNGGU APPROVAL ESELON 3";
                            // } elseif ($approve == 1) {
                            //   echo " - MENUNGGU APPROVAL ESELON 4 ";
                            // } else {
                            //   echo "- MENUNGGU PEMBUATAN BERKAS OLEH PENGOLAH";
                            // }
                          } else {
                            echo " - IZIN DITOLAK";
                          }
                        }
                       ?>
                    </span>
                    <span style="color:green">d</span>|<span style="color:blue">Sign</span>
                    &nbsp;
                  </div>
                </li>

                <?php if ($kd_status >= 6 && $skm == 2 && $approve == 2) {
                  echo '<li class="progress-step is-active" aria-current="step">';
                } elseif ($kd_status >= 6 && $skm == 1 && $approve == 2) {
                  echo '<li class="progress-step is-complete">';
                } else {
                  echo '<li class="progress-step">';
                } ?>
                  <div class="progress-marker"></div>
                  <div class="progress-text">
                    <span class="progress-title">PENGISIAN SKM (SILAHKAN LOGIN UNTUK MENGISI SKM)</span>
                    &nbsp;
                  </div>
                </li>

                <?php if ($kd_status == 8 || ($kd_status >= 6 && $skm == 1 && $approve == 2)) {
                  echo '<li class="progress-step is-active" aria-current="step">';
                } elseif ($kd_status > 8) {
                  echo '<li class="progress-step is-complete">';
                } else {
                  echo '<li class="progress-step">';
                } ?>
                  <div class="progress-marker"></div>
                  <div class="progress-text">
                    <span class="progress-title">SIAP SERAH / CETAK MANDIRI</span>
                    <span style="color:green">s</span>|<span style="color:blue">Print</span>
                    &nbsp;
                  </div>
                </li>

                <?php if ($kd_status == 9) {
                  echo '<li class="progress-step is-active" aria-current="step">';
                } elseif ($kd_status > 9) {
                  echo '<li class="progress-step is-complete">';
                } else {
                  echo '<li class="progress-step">';
                } ?>
                  <div class="progress-marker"></div>
                  <div class="progress-text">
                    <span class="progress-title">SELESAI</span>
                    &nbsp;
                  </div>
                </li>
              </ul>
            </div>
            
        <?php }
        }

        //echo $kd_status;
        if($sts_berkas == 'IZIN DISETUJUI' && $approve == 2){
          $unduh_izin = array('name' => 'button',
                	            'class' => 'submit-wrc',
                              'content' => 'Download Naskah Izin',
                              'value' => 'Download  Naskah Izin',
			                        'onclick' => 'parent.location=\''. site_url('main/login') . '\''
                             );
          $unduh_off  = array('name' => 'button',
                	            'class' => 'submit-wrc',
                              'content' => 'Tidak Dapat Download Naskah',
                              'value' => 'Tidak Dapat Download Naskah'
                             );                   
          $file = str_replace(' ', '','SK_'.$no_pendaftaran);
      	  $lok_esign = 'backoffice/assets/esignfile/';
      	  if($download){
  	        if(file_exists($lok_esign.$file.'.pdf')){        // cek PDF yang sudah SE
  	        	echo form_button($unduh_izin);
	          }else{
	            if($indeks == 'AKDP'){ // Jika AKDP
	            	$lok_skpdf = 'backoffice/assets/skpdf/';
  	            if(file_exists($lok_esign.$file.'.pdf')){    // cek PDF yang sudah SE
  	        	    echo form_button($unduh_izin);
  	            }
	            }
	          } 
	        }else{
	          echo form_button($unduh_off);
	        }  
	      }
      }else{
        echo "<div style='padding: 10px 5px; background: #f8f8f8; border-radius: 2px; border: 1px solid #CCC; width: 90%; margin: auto; font-size: 12px;'>
                Status Pendaftaran yang anda cari tidak Valid,,,
              </div>";
      }
     	echo "<br/>";
      ?>           
    </div>
    <div class="kanan">
      <?php echo "$menu" ?>
      <?php echo "$menu1" ?>
    </div>
    <div class="clear"></div>
  </div>
</div>