<style>
  table th tr td{padding-bottom: 5px; padding-left: 10px;}
  .ti_table{font-weight: bold; font-size: 14px; padding-bottom: 5px; padding-left: -10px;}
  em{font-weight: normal; font-size: 12px;}
</style>

<div class="isi">
  <div id="entry">
    <h2>Informasi Data Kendaraan</h2>
    <div class="kiri">
    	<hr>
      <h3 align=left style='font-size:14px;'><b><p>Data Kendaraan</p></b></h3>
      <?php
      if(empty($list)){
        //echo "Data AKDP di Jawa Barat Tidak Ditemukan"; 
        ?>
        <table border=0 style='font-size:12px; margin-left:10px; margin-bottom:10px;' cellpadding='0' cellspacing='0' width=95%>
          <tr><td width="20%">No Kendaraan</td>           <td width="3%"> : </td> <td width="72%"><b><?php echo $no_mobil; ?><b></td></tr>                             
          <tr><td width="20%">Nomor Uji</td>              <td width="3%"> : </td> <td width="72%"><?php echo '-'; ?></td></tr>                             
          <tr><td width="20%">Nama Pemilik</td>           <td width="3%"> : </td> <td width="72%"><?php echo '-'; ?></td></tr>                             
          <tr><td width="20%">Nama Perusahaan</td>        <td width="3%"> : </td> <td width="72%"><?php echo '-'; ?></td></tr>
          <tr><td width="20%">Tahun Pembuatan - Merk</td> <td width="3%"> : </td> <td width="72%"><?php echo '-'; ?></td></tr>
          <tr><td width="20%">Jenis Kendaraan</td>        <td width="3%"> : </td> <td width="72%"><?php echo '-'; ?></td></tr>
          <tr><td width="20%">Nomor SK</td>               <td width="3%"> : </td> <td width="72%"><?php echo '-'; ?></td></tr>
          <tr><td width="20%">Nomor KP</td>               <td width="3%"> : </td> <td width="72%"><?php echo '-'; ?></td></tr>
          <tr><td width="20%">Tanggal Penetapan SK</td>   <td width="3%"> : </td> <td width="72%"><?php echo '-'; ?></td></tr>
          <tr><td width="20%">Tanggal Penetapan KP</td>   <td width="3%"> : </td> <td width="72%"><?php echo '-'; ?></td></tr>
          <tr><td width="20%">Tanggal SK</td>             <td width="3%"> : </td> <td width="72%"><?php echo '-'; ?></td></tr>
          <tr><td width="20%">Tanggal KP</td>             <td width="3%"> : </td> <td width="72%"><?php echo '-'; ?></td></tr>
          <tr><td width="20%">Masa Berlaku SK</td>        <td width="3%"> : </td> <td width="72%"><?php echo '-'; ?></td></tr>
          <tr><td width="20%">Masa Berlaku KP</td>        <td width="3%"> : </td> <td width="72%"><?php echo '-'; ?></td></tr>
        </table>
        <?php
      }else{
        foreach($list as $kend) {
        	if($kend['masa_berlaku_sk'] < date('Y-m-d')){
        	  $sk_Lk = '<span style="color: Red">'; $sk_Lk1 = ' - SK Mati </span>';
          }else{
            $sk_Lk = ''; $sk_Lk1 = '';
          }
          if($kend['masa_berlaku_kp'] < date('Y-m-d')){
        	  $kp_Lk = '<span style="color: Red">'; $kp_Lk1 = ' - KP Mati </span>';
          }else{
            $kp_Lk = ''; $kp_Lk1 = '';
          }
          ?>
          <table border=0 style='font-size:12px; margin-left:10px; margin-bottom:10px;' cellpadding='0' cellspacing='0' width=95%>
            <tr>
              <td width="20%">No Kendaraan</td> 
              <td width="3%"> : </td>
              <td width="72%"><b><?php echo $kend['no_kend']; ?><b></td>
            </tr>
            <tr>
              <td width="20%">Nomor Uji</td>
              <td width="3%"> : </td>
              <td width="72%"><?php echo $kend['no_uji']; ?></td>
            </tr>
            <tr>
              <td width="20%">Nama Pemilik</td>
              <td width="3%"> : </td>
              <td width="72%"><?php echo $kend['nama_pemilik']; ?></td>
            </tr>
            <tr>
              <td width="20%">Nama Perusahaan</td>
              <td width="3%"> : </td>
              <td width="72%"><?php echo $kend['nama_perusahaan']; ?></td>
            </tr>
            <tr>
              <td width="20%">Tahun Pembuatan - Merk</td>
              <td width="3%"> : </td>
              <td width="72%"><?php echo $kend['tahun_pembuatan'] . " - " . $kend['merk']; ?></td>
            </tr>
            <tr>
              <td width="20%">Jenis Kendaraan</td>
              <td width="3%"> : </td>
              <td width="72%"><?php echo $kend['jenis_kendaraan']; ?></td>
            </tr>
            <tr>
              <td width="20%">Nomor SK</td>
              <td width="3%"> : </td>
              <td width="72%"><?php echo $kend['no_sk']; ?></td>
            </tr>
            <tr>
              <td width="20%">Nomor KP</td>
              <td width="3%"> : </td>
              <td width="72%"><?php echo $kend['no_kp']; ?></td>
            </tr>
            <tr>
              <td width="20%">Tanggal Penetapan SK</td>
              <td width="3%"> : </td>
              <td width="72%"><?php echo date('d F Y', strtotime($kend['tgl_penetapan_sk'])); ?></td>
            </tr>
            <tr>
              <td width="20%">Tanggal Penetapan KP</td>
              <td width="3%"> : </td>
              <td width="72%"><?php echo date('d F Y', strtotime($kend['tgl_penetapan_kp'])); ?></td>
            </tr>
            <tr>
              <td width="20%">Tanggal SK</td>
              <td width="3%"> : </td>
              <td width="72%"><?php echo date('d F Y', strtotime($kend['tgl_sk'])); ?></td>
            </tr>
            <tr>
              <td width="20%">Tanggal KP</td>
              <td width="3%"> : </td>
              <td width="72%"><?php echo date('d F Y', strtotime($kend['tgl_kp'])); ?></td>
            </tr>
            <tr>
              <td width="20%">Masa Berlaku SK</td>
              <td width="3%"> : </td>
              <td width="72%"><?php echo $sk_Lk.date('d F Y', strtotime($kend['masa_berlaku_sk'])).$sk_Lk1; ?></td>
            </tr>
            <tr>
              <td width="20%">Masa Berlaku KP</td>
              <td width="3%"> : </td>
              <td width="72%"><?php echo $kp_Lk.date('d F Y', strtotime($kend['masa_berlaku_kp'])).$kp_Lk1; ?></td>
            </tr>
          </table>
          <?php
        }
      }
      ?>
      <hr>
      <h3 align=left style='font-size:14px;'><b><p>Informasi Masa Laku Sumbangan Wajib Dana Kecelakaan Lalu Lintas Jalan (SWDKLLJ)</p></b></h3>
      <?php
      if(empty($swdkllj)) {
        //echo "Data SWDKLLJ tidak ditemukan";
        ?>
        <table border=0 style='font-size:12px; margin-left:10px; margin-bottom:10px;' cellpadding='0' cellspacing='0' width=95%>
          <tr><td width="20%">Tanggal Transaksi</td>  <td width="3%"> : </td> <td width="72%"><?php echo '-'; ?></td></tr>
          <tr><td width="20%">Masa Berlaku Akhir</td> <td width="3%"> : </td> <td width="72%"><?php echo '-'; ?></td></tr>
          <tr><td width="20%">Nomor Rangka</td>       <td width="3%"> : </td> <td width="72%"><?php echo '-'; ?></td></tr>
          <tr><td width="20%">Nomor Mesin</td>        <td width="3%"> : </td> <td width="72%"><?php echo '-'; ?></td></tr>
        </table>
        <?php
      }else{
        foreach($swdkllj as $dishub) {
        	$tgl_transaksi = explode('/', $dishub['tgl_transaksi']);
        	$tgl_transaksi = $tgl_transaksi[2].'-'.$tgl_transaksi[1].'-'.$tgl_transaksi[0];
        	$tgl_mati_yad = explode('/', $dishub['tgl_mati_yad']);
        	$tgl_mati_yad = $tgl_mati_yad[2].'-'.$tgl_mati_yad[1].'-'.$tgl_mati_yad[0];
        	if(strtotime($tgl_mati_yad) < strtotime(date('Y-m-d'))){
        		$swd_Lk = '<span style="color: Red">'; $swd_Lk1 = ' - SWDKLLJ Mati </span>';
          }else{
            $swd_Lk = ''; $swd_Lk1 = '';
          }
        	$hit_no_rangka = strlen($dishub['no_rangka']);
        	$no_rangka_x = ''; for($x=1;$x<=$hit_no_rangka-5;$x++) {$no_rangka_x = $no_rangka_x.'x';}
        	$hit_no_mesin = strlen($dishub['no_mesin']);
        	$no_mesin_x = ''; for($x=1;$x<=$hit_no_mesin-3;$x++) {$no_mesin_x = $no_mesin_x.'x';}
          ?>
          <table border=0 style='font-size:12px; margin-left:10px; margin-bottom:10px;' cellpadding='0' cellspacing='0' width=95%>
            <tr>
              <td width="20%">Tanggal Transaksi</td>
              <td width="3%"> : </td>
              <td width="72%"><?php echo date('d F Y', strtotime($tgl_transaksi)); ?></td>
            </tr>
            <tr>
              <td width="20%">Masa Berlaku Akhir</td>
              <td width="3%"> : </td>
              <td width="72%"><?php echo $swd_Lk.date('d F Y', strtotime($tgl_mati_yad)).$swd_Lk1; ?></td>
            </tr>
            <tr>
              <td width="20%">Nomor Rangka</td>
              <td width="3%"> : </td>
              <td width="72%"><?php echo substr($dishub['no_rangka'],0,5).$no_rangka_x; ?></td>
            </tr>
            <tr>
              <td width="20%">Nomor Mesin</td>
              <td width="3%"> : </td>
              <td width="72%"><?php echo substr($dishub['no_mesin'],0,3).$no_mesin_x; ?></td>
            </tr>
          </table>
          <?php
        }	
      }
      ?>
      
      <hr>
      <h3 align=left style='font-size:14px;'><b><p>Informasi Iuran Wajib Kendaraan Bermotor Umum (IWKBU)</p></b></h3>
      <?php
      if(empty($iwkbu)) {
        //echo "Data IWKBU tidak ditemukan";
        ?>
        <table border=0 style='font-size:12px; margin-left:10px; margin-bottom:10px;' cellpadding='0' cellspacing='0' width=95%>
          <tr><td width="20%">Nama PO</td>                <td width="3%"> : </td> <td width="72%"><?php echo '-'; ?></td></tr>
          <tr><td width="20%">Tarif per Bulan</td>        <td width="3%"> : </td> <td width="72%"><?php echo '-'; ?></td></tr>
          <tr><td width="20%">Tanggal Transaksi</td>      <td width="3%"> : </td> <td width="72%"><?php echo '-'; ?></td></tr>
          <tr><td width="20%">Tanggal Berlaku Hingga</td> <td width="3%"> : </td> <td width="72%"><?php echo '-'; ?></td></tr>
          <tr><td width="20%">Nominal Pelunasan</td>      <td width="3%"> : </td> <td width="72%"><?php echo '-'; ?></td></tr>
          <tr><td width="20%">Deskripsi</td>              <td width="3%"> : </td> <td width="72%"><?php echo '-'; ?></td></tr>
        </table>
        <?php
      }else{
        foreach($iwkbu as $dishub1) {
        	$string_replace = array(" ","m","M","o","O","u","U","s","S","i","I","a","A","e","E");
        	//$tgl_transaksi = date('d/m/Y',strtotime(substr($dishub1['tgl_tansaksi'],0,10)));
        	//$tgl_transaksi = explode('/', $tgl_transaksi);
        	//$tgl_transaksi = $tgl_transaksi[2].'-'.$tgl_transaksi[1].'-'.$tgl_transaksi[0];
        	//$tgl_mati_iw = date('d/m/Y',strtotime(substr($dishub1['tgl_mati_akhir'],0,10)));
        	//$tgl_mati_iw = explode('/', $tgl_mati_iw);
        	//$tgl_mati_iw = $tgl_mati_iw[2].'-'.$tgl_mati_iw[1].'-'.$tgl_mati_iw[0];
        	//if(strtotime($tgl_mati_iw) < strtotime(date('Y-m-d'))){
        	//	$iwd_Lk = '<span style="color: Red">'; $iwd_Lk1 = ' - IWKBU Mati </span>';
          //}else{
          //  $iwd_Lk = ''; $iwd_Lk1 = '';
          //}
          ?>
          <table border=0 style='font-size:12px; margin-left:10px; margin-bottom:10px;' cellpadding='0' cellspacing='0' width=95%>
            <tr>
              <td width="20%">Nama PO</td>
              <td width="3%"> : </td>
              <td width="72%"><?php echo str_replace($string_replace, 'x',$dishub1['nama_po']); ?></td>
            </tr>
            <tr>
              <td width="20%">Tarif per Bulan</td>
              <td width="3%"> : </td>
              <td width="72%"><?php echo number_format($dishub1['tarif_per_bulan'],2); ?></td>
            </tr>
            <tr>
              <td width="20%">Tanggal Transaksi</td>
              <td width="3%"> : </td>
              <!-- <td width="72%"><?php echo date('d F Y', strtotime($tgl_transaksi)).' - '.$dishub1['tgl_tansaksi']; ?></td> -->
              <td width="72%"><?php echo $dishub1['tgl_tansaksi']; ?></td>
            </tr>
            <tr>
              <td width="20%">Tanggal Berlaku Hingga</td>
              <td width="3%"> : </td>
              <!--<td width="72%"><?php echo $iwd_Lk.date('d F Y', strtotime($tgl_mati_iw)).$iwd_Lk1; ?></td>-->
              <td width="72%"><?php echo $dishub1['tgl_mati_akhir']; ?></td>
            </tr>
            <tr>
              <td width="20%">Nominal Pelunasan</td>
              <td width="3%"> : </td>
              <td width="72%"><?php echo number_format($dishub1['nominal_pelunasan'],2); ?></td>
            </tr>
            <tr>
              <td width="20%">Deskripsi</td>
              <td width="3%"> : </td>
              <td width="72%"><?php echo $dishub1['deskripsi']; ?></td>
            </tr>
          </table>
          <?php
        }	
      }
      if(empty($kresh)) {
        ?>
        <hr>
        <h3 align=left style='font-size:14px;'><b><p>Informasi History Kecelakaan (Tidak Pernah Mengalami Kecelakaan)</p></b></h3>
        <table border=0 style='font-size:12px; margin-left:10px; margin-bottom:10px;' cellpadding='0' cellspacing='0' width=95%>
          <tr><td width="20%">Tanggal Kejadian</td> <td width="3%"> : </td> <td width="72%"><?php echo '-'; ?></td></tr>
          <tr><td width="20%">Deskripsi Lokasi</td> <td width="3%"> : </td> <td width="72%"><?php echo '-'; ?></td></tr>
          <tr><td width="20%">Deskripsi</td>        <td width="3%"> : </td> <td width="72%"><?php echo '-'; ?></td></tr>
        </table>
        <?php
      }else{
        foreach($kresh as $dishub2) {
        	//$tgl_kres = explode('/', $dishub2['tgl_kejadian']);
        	//$tgl_kres = $tgl_kres[2].'-'.$tgl_kres[1].'-'.$tgl_kres[0];
          ?>
          <hr>
          <h3 align=center style='font-size:14px;'><b><p>Informasi History Kecelakaan</p></b></h3>
          <table border=0 style='font-size:12px; margin-left:10px; margin-bottom:10px;' cellpadding='0' cellspacing='0' width=95%>
            <tr>
              <td width="20%">Tanggal Kejadian</td>
              <td width="3%"> : </td>
              <!--<td width="72%"><?php echo date('d F Y', strtotime($tgl_kres)); ?></td>-->
              <td width="72%"><?php echo $dishub2['tgl_kejadian']; ?></td>
            </tr>
            <tr>
              <td width="20%">Deskripsi Lokasi</td>
              <td width="3%"> : </td>
              <td width="72%"><?php echo $dishub2['des_lokasi']; ?></td>
            </tr>
            <tr>
              <td width="20%">Deskripsi</td>
              <td width="3%"> : </td>
              <td width="72%"><?php echo $dishub2['deskripsi']; ?></td>
            </tr>
          </table>
          <?php
        }	
      }
      ?>
    </div>
    <hr>
    <div class="kanan">
      <?php echo "$menu" ?>
      <?php echo "$menu1" ?>
    </div>
    <div class="clear"></div>
  </div>
</div>