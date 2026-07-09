<style>
    table tr td{padding-bottom: 5px; padding-left: 10px;}
    .ti_table{font-weight: bold; font-size: 14px; padding-bottom: 5px; padding-left: -10px;}
    em{font-weight: normal; font-size: 12px;}
</style>

<div class="isi">
  <div id="entry">
    <h2>Validasi Izin</h2>
    <div class="kiri">
      <h3 align=center style='font-size:12px;'><p>Data Hasil Pencarian</p></h3> <hr/>

      <?php
      $jumlah = count($list);
		  if($jumlah > 0){
        $n=1;
        
		    $status_akhir = '';
        foreach ($list as $row) {
          $tracking = $row['tracking'];
          
          if($n == 1){
			  		$id = $row['id'];
            $no_pendaftaran = $row['no_pendaftaran'];
            $no_pendaftaran_cabut = $row['no_pendaftaran_cabut'];
	  				$sts_berkas = Strtoupper($row['sts_berkas']);
            $nama = $row['nama'];
            $alamat = htmlspecialchars_decode($row['alamat']);
            $tlp = $row['tlp'];
            $permohonan = $row['permohonan'];
            $permohonan_cabut = $row['permohonan_cabut'];
            $c_izin_dicabut = $row['c_izin_dicabut'];
				    $status_akhir = $row['tracking'];
				  	$n_kelompok_izin = $row['n_kelompok_izin'];
  					$kd_status = $row['kd_status'];
  					$no_surat = $row['no_surat'];
					  $approve = $row['approve'];
					  $tgl_surat = $row['tgl_surat'];
					  if($row['no_surat'] == 'Tidak Ditinjau'){
  						$ditinjau = ' <b>('.strtoupper($row['no_surat']).')</b>';
					  }else{
	  					$ditinjau = '';
	  				}	
	  				
	  				if($no_pendaftaran != ''){
	  				  echo "<p style = 'margin-left:10px; font-size:12px;'>
		                  Berikut ini Data izin yang Anda Cari.
                    </p> <br/>";
                	
				      echo "<table border=0 style='font-size:13px; margin-left:10px; margin-bottom:10px;' cellpadding='0' cellspacing='0' width=95%>";
              echo     "<tr>";
              echo         "<td valign='top' width='15%'>No Pendaftaran</td>";
              echo         "<td valign='top' width='2%'>:</td>";
              echo         "<td valign='top' width='73%'>$no_pendaftaran</td>";
					    echo     "</tr>";
              echo     "<tr>";
              echo         "<td valign='top' width='15%'>Nama Pemohon</td>";
              echo         "<td valign='top' width='2%'>:</td>";
              echo         "<td valign='top' width='73%'>$nama</td>";
              echo     "</tr>";
                          
              echo     "<tr style='padding: 10px 5px; border-radius: 2px; margin-top:10px;'>";
              echo         "<td valign='top' width='15%'>Alamat</td>";
              echo         "<td valign='top' width='2%'>:</td>";
              echo         "<td valign='top' width='73%'>$alamat</td>";
              echo     "</tr>";
              
              echo     "<tr style='padding: 10px 5px; border-radius: 2px; margin-top:10px;'>";
              echo         "<td valign='top' width='15%'>Telpon</td>";
              echo         "<td valign='top' width='2%'>:</td>";
              echo         "<td valign='top' width='73%'>$tlp</td>";
              echo     "</tr>";
              
              echo     "<tr style='padding: 10px 5px; border-radius: 2px; margin-top:10px;'>";
              echo         "<td valign='top' width='15%'>Nama Izin</td>";
              echo         "<td valign='top' width='2%'>:</td>";
              echo         "<td valign='top' width='73%'>$permohonan</td>";
              echo     "</tr>";
              
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
              if($c_izin_dicabut == 0){
              	$download = TRUE;
                echo   "<tr style='padding: 10px 5px; border-radius: 2px; margin-top:10px;'>";
                echo     "<td valign='top' width='15%'>Status Izin</td>";
                echo     "<td valign='top' width='2%'>:</td>";
                echo     "<td valign='top' width='73%'><b><span style='color: green'>Izin Telah Terbit</span></b></td>";
                echo   "</tr>";
              }
              echo     "<tr style='padding: 10px 5px; border-radius: 2px; margin-top:10px;'>";
              echo         "<td valign='top' width='15%'>Nomor Izin</td>";
              echo         "<td valign='top' width='2%'>:</td>";
              echo         "<td valign='top' width='73%'>$no_surat</td>";
              echo     "</tr>";
              
              echo     "<tr style='padding: 10px 5px; border-radius: 2px; margin-top:10px;'>";
              echo         "<td valign='top' width='15%'>Tanggal </td>";
              echo         "<td valign='top' width='2%'>:</td>";
              echo         "<td valign='top' width='73%'>$tgl_surat</td>";
              echo     "</tr>";
              
					    echo "</table>";
					    echo "<p style = 'margin-left:10px; font-size:12px;'>
		                  Adalah Benar Tercatat di Dinas PMPTSP Prov. Jawa barat.
		                </p>";
              $n++;
            }else{
              echo "<p style = 'margin-left:10px; font-size:12px;'>
		            Permohonan tidak tercatat di Dinas PMPTSP Prov. Jawa barat.
		          </p>";
		          ?>
		          <img src="https://dpmptsp.jabarprov.go.id/jelita/images/false_izin.png" class="img-responsive hidden-xs hidden-sm" style="margin-bottom:15px;">
		          <?php  	
            }
					}
				}
		    
        $unduh_izin = array('name' => 'button',
              	            'class' => 'submit-wrc',
                            'content' => 'Download Naskah Izin',
                            'value' => 'Download  Naskah Izin',
			                      'onclick' => 'parent.location=\''. site_url('main/cekiz/download_pdf') . '/'.$no_pendaftaran.'\''
                           );
        $unduh_off  = array('name' => 'button',
                	            'class' => 'submit-wrc',
                              'content' => 'Tidak Dapat Download Naskah',
                              'value' => 'Tidak Dapat Download Naskah'
                             );                   
        $file = str_replace(' ', '','SK_'.$no_pendaftaran);
      	$lok_esign = 'backoffice/assets/esignfile/';
      	if($download){
  	      if(file_exists($lok_esign.$file.'.pdf') && $approve == 2){        // cek PDF yang sudah SE
  	        echo form_button($unduh_izin);
  	      }  
	      }else{
	        echo form_button($unduh_off);
	      }
      }else{
        echo "<div style='padding: 10px 5px; background: #f8f8f8; border-radius: 2px; border: 1px solid #CCC; width: 90%; margin: auto; font-size: 12px;'>
                Izin yang anda cari tidak ditemukan,,,
              </div>";
        ?>
		      <img src="https://dpmptsp.jabarprov.go.id/jelita/images/false_izin.png" class="img-responsive hidden-xs hidden-sm" style="margin-bottom:15px;">
		    <?php      
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