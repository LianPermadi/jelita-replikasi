<style>
  table tr td{padding-bottom: 5px; padding-left: 10px;}
  .ti_table{font-weight: bold; font-size: 14px; padding-bottom: 5px; padding-left: -10px;}
  em{font-weight: normal; font-size: 12px;}
</style>
<?php
  function tanggal_indo($tanggal)
  {
    $bulan = array (1 =>   'Januari',
          'Februari',
          'Maret',
          'April',
          'Mei',
          'Juni',
          'Juli',
          'Agustus',
          'September',
          'Oktober',
          'November',
          'Desember'
        );
    $split = explode('-', $tanggal);
    // return $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
  }

  $NO_SK = "";
  $TG_SK = "";
  $BERLAKU = "";
  $NAMA_PERUS ="";
  $PEMILIK = "";
  $ALAMAT_PEM ="";
  $ALAMAT_PER = "";
  $NO_IP = "";
  $BERLAKU = "";
  $KETERANGAN ="";
  $PIT_ID = "";
  
  $i=1;
  foreach($list as $u){
    $NO_SK =  $u->NO_SK;
    $TG_SK = $u->TG_SK;
    $BERLAKU = $u->BERLAKU;
    $NAMA_PERUS = $u->NAMA_PERUS;
    $PEMILIK = $u->PEMILIK;
    $ALAMAT_PEM = $u->ALAMAT_PEM;
    $ALAMAT_PER = $u->ALAMAT_PER;
    $NO_IP = $u->NO_IP;
    $BERLAKU =$u->BERLAKU;
    $KETERANGAN = $u->KETERANGAN;
    $PIT_ID = $u->PIT_ID;
  }
?>

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
          ?>
          <hr>
          <table  align="top" border=0 style='font-size:13px; margin-left:10px; margin-bottom:10px;' cellpadding='0' cellspacing='0' width=100%>
          	<tr><td><b>SURAT KEPUTUSAN</b></td></tr>
            <tr><td>Nomor SK</td>            <td>:</td> <td><?php echo $NO_SK; ?></td></tr>
            <tr><td>Nama Perusahaan</td>     <td>:</td> <td><?php echo $NAMA_PERUS; ?></td></tr>
            <tr><td>Nama Pimpinan</td>       <td>:</td> <td><?php echo $PEMILIK; ?></td></tr>
            <tr><td>Alamat Perusahaan</td>   <td>:</td> <td><?php echo $ALAMAT_PER; ?></td></tr>
            <tr><td>Alamat Pimpinan</td>     <td>:</td> <td><?php echo $ALAMAT_PEM; ?></td></tr>
            <tr><td>No Induk Perusahaan</td> <td>:</td> <td><?php echo $NO_IP; ?></td></tr>
            <tr><td>Masa Berlaku</td>        <td>:</td> <td><?php echo tanggal_indo($BERLAKU); ?></td></tr>
            <tr><td>Keterangan</td>          <td>:</td> <td><?php echo $KETERANGAN; ?></td></tr>
          </table>
          <hr>
          <?php
          //}
          //Download Naskah SK dan KP
          $unduh_sk = array('name' => 'button',
                	          'class' => 'submit-wrc',
                            'content' => 'Download KP',
                            'value' => 'Download  KP',
			                      'onclick' => 'parent.location=\''. site_url('main/cekbbsk/download_sk') . '/'.$resi.'\'');

          $unduh_lamp = array('name' => 'button',
                            'class' => 'submit-wrc',
                            'content' => 'Download Lampiran SK',
                            'value' => 'Download  Lampiran SK',
                            'onclick' => 'parent.location=\''. site_url('main/cekbbsk/download_lamp') . '/'.$resi.'\'');

          $file_lamp = str_replace(' ', '','DAFTAR_KENDARAAN_'.$resi);
          $file = str_replace(' ', '','SK_'.$resi);
      	  $lok = 'backoffice/assets/esignfile/';
          // var_dump(file_exists($lok.$file.'.pdf'));die();
  	      if(file_exists($lok.$file.'.pdf')){        // cek PDF yang sudah SE
  	      	// echo '<br>';
  	        // echo form_button($unduh_sk);
            echo 'Untuk Download KP bisa melalui Portal <a href="https://dpmptsp.jabarprov.go.id/jelita/main/login" class="button-wrc">Klik Disini</a>';
	        }
          if(file_exists($lok.$file_lamp.'.pdf')){        // cek PDF yang sudah SE
            // echo "&nbsp;".form_button($unduh_lamp);
          }
          //EOF() Download Naskah SK dan KP
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