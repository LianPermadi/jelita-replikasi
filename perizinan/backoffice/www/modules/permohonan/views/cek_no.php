<div style="padding: 5px; font-size: 12px;">
  <?php
  echo "<h3 align=center><p>Data Hasil Pencarian</p></h3>
        <hr/>
        <p style='margin-left:10px; font-size:12px;'>Berikut ini status terakhir permohonan izin yang Anda ajukan. Untuk keterangan lebih lengkap silakan datang ke Kantor Layanan Perizinan.</p>
        <br/><br/>
       ";
  $n = 1;
  $status_akhir = '';
  foreach($list as $row) {
    $id = $row['id'];
    $no_pendaftaran = $row['no_pendaftaran'];
    $sts_berkas = Strtoupper($row['sts_berkas']);
    $nama = $row['nama'];
    $permohonan = $row['permohonan'];
    $tracking = $row['tracking'];
    $n_kelompok_izin = $row['n_kelompok_izin'];
    if($no_pendaftaran == 0) {
      echo "<h3 align=center>Data Tidak Temukan</h3>";
    }else{
      if($n == 1){
        $status_akhir = $row['tracking'];
  	    echo "<table border=1 style='font-size:12px; margin-left:10px; margin-bottom:10px;' cellpadding='0' cellspacing='0' width=95%>";
        echo   "<tr>";
        echo     "<td>No Pendaftaran</td>";
        echo     "<td>:</td>";
        echo     "<td>$no_pendaftaran</td>";
        echo   "</tr>";
        
  	    echo   "<tr>";
        echo      "<td>Nama Pemohon</td>";
        echo      "<td>:</td>";
        echo      "<td>$nama</td>";
        echo   "</tr>";
         
        echo   "<tr  style='padding: 10px 5px; border-radius: 2px; margin-top:10px;'>";
        echo     "<td>Nama Perizinan</td>";
        echo     "<td>:</td>";
        echo     "<td>$permohonan</td>";
        echo   "</tr>";
        
  	    echo   "<tr  style='padding: 10px 5px; border-radius: 2px; margin-top:10px;'>";
        echo     "<td>Kelompok Perizinan</td>";
        echo     "<td>:</td>";
        echo     "<td>$n_kelompok_izin</td>";
        echo   "</tr>";
        
  	    echo   "<tr  style='padding: 10px 5px; border-radius: 2px; margin-top:10px;'>";
        echo     "<td>Status Permohonan</td>";
        echo     "<td>:</td>";
        echo     "<td>$sts_berkas</td>";
        echo   "</tr>";
  	    echo "</table>";
        $n++;
      }else{
  	    $no=$n-2;
  	    if( $n == 2){ // cetak judul Status Permohonan
  	      echo "<table border=1 style='font-size:17px; margin-left:10px; ' cellpadding='0' cellspacing='0' width=95%>";
          echo   "<tr  style='padding: 10px 15px; border-radius: 2px; margin-top:10px;'>";
  	      echo     "<td>$tracking</td>"; 
          echo   "</tr>";
          echo "</table>";
        }else{
  	      $kodetext = substr($tracking, 0, 1);
  	      if($status_akhir == $tracking ){
  		      if( $n < 12)
  		        echo "<table border=1 style='font-size:13px; color:#CC0000; margin-left:37px; ' cellpadding='0' cellspacing='0' width=95%>";
            else
              echo "<table border=1 style='font-size:13px; color:#CC0000; margin-left:30px; ' cellpadding='0' cellspacing='0' width=95%>";
  		      if( $kodetext == '-'){
  		        $n--;
  		        echo "<tr style='padding: 10px 15px; border-radius: 2px; margin-top:10px;'>";
  		        echo   "<td><b>&nbsp&nbsp&nbsp&nbsp&nbsp $tracking (Status Saat Ini)</b></td>"; 
              echo "</tr>";
  		      }else{
  		        echo "<tr style='padding: 10px 15px; border-radius: 2px; margin-top:10px;'>";
  		        echo   "<td><b>$no . $tracking (Status Saat Ini)</b></td>"; 
              echo "</tr>";
  		      }
            echo "</table>";
  	      }else{
  		      if( $n < 12)
  		        echo "<table border=1 style='font-size:12px; margin-left:37px; ' cellpadding='0' cellspacing='0' width=95%>";
            else
              echo "<table border=1 style='font-size:12px; margin-left:30px; ' cellpadding='0' cellspacing='0' width=95%>";
  		      if($kodetext == '-'){
  		        $n--;
              echo "<tr style='padding: 10px 15px; border-radius: 2px; margin-top:10px;'>";
  		        echo   "<td>&nbsp&nbsp&nbsp&nbsp&nbsp $tracking</td>"; 
              echo "</tr>";
  		      } else {
  		        echo "<tr style='padding: 10px 15px; border-radius: 2px; margin-top:10px;'>";
  		        echo   "<td>$no . $tracking</td>"; 
              echo "</tr>";
  		      }
            echo "</table>";
  	      }
        }
        $n++;
      }
    }
  }
  echo "<br/>";
  ?>
</div>