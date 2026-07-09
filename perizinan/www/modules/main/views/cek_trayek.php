<style>
  table tr td{padding-bottom: 5px; padding-left: 10px;}
  .ti_table{font-weight: bold; font-size: 14px; padding-bottom: 5px; padding-left: -10px;}
  em{font-weight: normal; font-size: 12px;}
</style>

<div class="isi">
  <div id="entry">
    <h2>Cek Status Izin</h2>
    <div class="kiri">
      <!--<h3 align=center style='font-size:12px;'><p>Data Hasil Pencarian</p></h3> <hr/>-->
      <?php
      $jumlah = count($list);
      if($jumlah > 0) {
        $n=1;
        
        echo "<p style = 'margin-left:10px; font-size:12px;'>
              Berikut Informasi Data Perizinan yang Anda Miliki :
              </p> <br/>";
        foreach($list as $row) {
          //if($n == 1){
          //  if($isSK){
          ?>
          <hr>
          <table  align="top" border=0 style='font-size:13px; margin-left:10px; margin-bottom:10px;' cellpadding='0' cellspacing='0' width=100%>
          	<tr><td><b>SURAT KEPUTUSAN</b></td></tr>
            <tr><td>Nomor SK</td>            <td>:</td> <td><?php echo $row['no_sk']; ?></td></tr>
            <tr><td>Nama Perusahaan</td>     <td>:</td> <td><?php echo $row['nama_perusahaan']; ?></td></tr>
            <tr><td>Nama Pimpinan</td>       <td>:</td> <td><?php echo $row['nama_pimpinan']; ?></td></tr>
            <tr><td>Alamat Perusahaan</td>   <td>:</td> <td><?php echo $row['almt_perusahaan'] ?></td></tr>
            <tr><td>Alamat Pimpinan</td>     <td>:</td> <td><?php echo $row['almt_pimpinan']; ?></td></tr>
            <tr><td>No Induk Perusahaan</td> <td>:</td> <td><?php echo $row['no_induk']; ?></td></tr>
            <tr><td>Masa Berlaku</td>        <td>:</td> <td><?php echo $row['masa_berlaku']; ?></td></tr>
            <tr><td>Keterangan</td>          <td>:</td> <td><?php echo $row['ket']; ?></td></tr>
          <?php
          //}else{
          ?>
            <tr><td><br></td>
            <tr><td><b>KARTU PENGAWASAN</b></td></tr>
            <tr><td>Nomor KP</td>           <td>:</td> <td><?php echo $row['no_kp']; ?></td></tr>
            <tr><td>Masa Berlaku</td>       <td>:</td> <td><?php echo $row['berlaku_kp']; ?></td></tr>
            <tr><td>Nama Pemilik</td>       <td>:</td> <td><?php echo $row['nama_pemilik']; ?></td></tr>
            <tr><td>Nomor Kendaraan</td>    <td>:</td> <td><?php echo $row['no_kend']; ?></td></tr>
            <tr><td>Nomor Uji</td>          <td>:</td> <td><?php echo $row['no_uji']; ?></td></tr>
            <tr><td>Daya Angkut Orang</td>  <td>:</td> <td><?php echo $row['daya_angkut_org']; ?></td></tr>
            <tr><td>Daya Angkut Barang</td> <td>:</td> <td><?php echo $row['daya_angkut_brg'] ?></td></tr>
            <tr><td>Jenis Kendaraan</td>    <td>:</td> <td><?php echo $row['jenis_kend']; ?></td></tr>
            <tr><td>Merek / Tahun</td>      <td>:</td> <td><?php echo $row['merek']; ?></td></tr>
            <tr><td>Bahan Bakar</td>        <td>:</td> <td><?php echo $row['bahan_bakar']; ?></td></tr>
            <tr><td>Jenis Pelayanan</td>    <td>:</td> <td><?php echo $row['jenis_pel']; ?></td></tr>
            <tr><td>Kode Trayek</td>        <td>:</td> <td><?php echo $row['kode_trayek']; ?></td></tr>
            <tr><td>Trayek</td>             <td>:</td> <td><?php echo $row['trayek']; ?></td></tr>
            <tr><td>Sifat Pelayanan</td>    <td>:</td> <td><?php echo $row['sifat_pel']; ?></td></tr>
          </table>
          <hr>
          <?php
          //}
          $n++;
          $key = $row['kypengolah'].$row['kyEsl4'].$row['kyEsl3'].$row['kyKa'];
          $tampil = '';
          for($i=0; $i < strlen($key) ; $i++) {
            $pos = rand(0,strlen($key)-1);
            $tampil .= substr($key,$i,1).$key{$pos}.' '; 
          }
          echo "<div style='padding: 10px 5px; background: #f8f8f8; border-radius: 2px; border: 1px solid #CCC; width: 90%; margin: auto; font-size: 12px;'>".
                'Izin Saudara '.$row['valid'].' Kode Keamanan :<br>'.$row['kypengolah'].'<br>'.$tampil.
          	   "</div>"; 
          //}
          //Download Naskah SK dan KP
          $no_pendaftaran = $row['pendaftaran_id'];
          $unduh_sk = array('name' => 'button',
                	          'class' => 'submit-wrc',
                            'content' => 'Download SK',
                            'value' => 'Download  SK',
			                      'onclick' => 'parent.location=\''. site_url('main/cekhub/download_sk') . '/'.$no_pendaftaran.'\'');
          $file = str_replace(' ', '','SK_'.$no_pendaftaran);
      	  //$lok_esign = 'backoffice/assets/skpdf/';
      	  $lok_esign = 'backoffice/assets/esignfile/';
          $non_esign = 'backoffice/assets/skpdf/';
  	      if(file_exists($lok_esign.$file.'.pdf')){        // cek PDF yang sudah SE
  	      	echo '<br>';
  	        echo form_button($unduh_sk);
	        }else{
	          if(file_exists($non_esign.$file.'.pdf')){        // cek PDF yang belum SE
  	      	  echo '<br>';
  	          echo form_button($unduh_sk);
	          }
	        }

          $unduh_kp = array('name' => 'button',
                	          'class' => 'submit-wrc',
                            'content' => 'Download KP',
                            'value' => 'Download  KP',
			                      'onclick' => 'parent.location=\''. site_url('main/cekhub/download_kp') . '/'.$no_pendaftaran.'\'');
          $file = str_replace(' ', '','KP_'.$no_pendaftaran);
      	  //$lok_esign = 'backoffice/assets/skpdf/';
      	  $lok_esign = 'backoffice/assets/esignfile/';
          $non_esign = 'backoffice/assets/skpdf/';
  	      if(file_exists($lok_esign.$file.'.pdf')){        // cek PDF yang sudah SE
  	      	echo '&nbsp &nbsp';
  	        echo form_button($unduh_kp);
	        }else{
	          if(file_exists($non_esign.$file.'.pdf')){        // cek PDF yang belum SE
  	      	  echo '&nbsp &nbsp';
  	          echo form_button($unduh_kp);
	          }
	        }
          //EOF() Download Naskah SK dan KP
        }
      }else{
        echo "<div style='padding: 10px 5px; background: #f8f8f8; border-radius: 2px; border: 1px solid #CCC; width: 90%; margin: auto; font-size: 12px;'>
              Nomer pendaftaran yang anda masukan tidak diketahui.....
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