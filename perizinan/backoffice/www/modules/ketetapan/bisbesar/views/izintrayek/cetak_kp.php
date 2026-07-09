<style>
body{
  font-family: "Arial", Helvetica, sans-serif;
  font-size : 12px;
  
}
table {
  font-family: "Arial", Helvetica, sans-serif;
  font-size : 10px;
  
    border-collapse: collapse;

}
td,th{
   padding-left:5px;
   padding-right:5px;
}
.bold{
  font-weight: bold;
}
p {
    text-indent: 50px;
}
.lintasan{
	width:100%;
	overflow:hidden;
border : 1px solid black;
margin-top: 5px;
margin-bottom: 5px;
text-align: center;
}

@media print {
    #with_print {
        display: none;
    }
    @page { size: US-Legal landscape; margin: 0.4in }
}
.half-left{
	width:49%;
	margin:auto;
	float:left;
}
.half-right{
	width:49%;
	margin:auto;
	float:right;
}
</style>
<script>
  function close_window() {
  if (confirm("Keluar dari halaman ini ?")) {
    close();
  }
}
</script>


<button onclick="window.print()"  id="with_print" >Print</button>
<button onclick="close_window()"  id="with_print">Keluar</button>
<br>
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
  return $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
}

$NO_SK = "";
$TG_SK = "";
$NAMA_PERUS ="";
$ALAMAT_PER = "";
$JENIS = "";
$JENIS_KP = "";

$KODE_TRAYE = "";
$NAMA_TRAYE = "";


$NAMA_PEMIL = "";
$ALAMAT_PEM = "";
$CATATAN = "";
$HISTORI = "";
$NO_IK = "";
$MERK = "";
$TAHUN_PEMB = "";
$DA_ORANG = "";
$DA_BARANG = "";
$BBM = "";
$NO_UJI ="";
$NO_MOBIL = "";
$AC = "";
$TOILET ="";
$RCSET = "";
$SP = "";
$PELAYANAN = "";
$TG_KP ="";
$TG_KPSK="";
$TG_MULAI = "";
$TG_AKHIR = "";
$EX_NO_MOBI ="";
$EX_NO_UJI = "";
$TARIF_BAND = "";
$TELAT_TH = "";
$TELAT_BL = "";
$DENDA_BAND ="";
$SP = "";
$SP_KE = "";
$TARIF ="";
$NOMOR_KP ="";
$ALAMAT_STN = "";

foreach($bb_izintrayek as $u)
{
 $NO_SK =  $u->NO_SK;
 $TG_SK = $u->TG_SK;
 $NAMA_PERUS = $u->NAMA_PERUS;
 $ALAMAT_PER = $u->ALAMAT_PER;

$KODE_TRAYE = $u->KODE_TRAYE;
$NAMA_TRAYE = $u->NAMATRAYEK;
$NOMOR_KP = $u->NOMOR_KP;
$NO_IK = $u->NO_IK;
$MERK = $u->MERK;
$TAHUN_PEMB = $u->TAHUN_PEMB;
$JENIS = $u->JENIS;
$JENIS_KP = $u->JENIS_KP;

$NAMA_STNK = $u->NAMA_STNK;
$ALAMAT_PEM = $u->ALAMAT_STN;
$CATATAN = $u->CATATAN;
$HISTORI = $u->HISTORI;
$DA_ORANG = $u->DA_ORANG;
$DA_BARANG = $u->DA_BARANG;
$BBM = $u->BBM;
$NO_UJI = $u->NO_UJI;
$NO_MOBIL = $u->NO_MOBIL;

$AC = $u->AC;
$TOILET = $u->TOILET;
$RCSET = $u->RCSET;
$SP = $u->SP;
$SP_KE = $u->SP_KE;
$PELAYANAN = $u->PELAYANAN;
$TG_KP = $u->TG_KP;
$TG_KPSK = $u->TG_KPSK;
$TG_MULAI = $u->TG_MULAI;
$TG_AKHIR = $u->TG_AKHIR;
$EX_NO_MOBI = $u->EX_NO_MOBI;
$EX_NO_UJI = $u->EX_NO_UJI;
$TARIF_BAND = $u->TARIF_BAND;
$TELAT_TH = $u->TELAT_TH;
$TELAT_BL = $u->TELAT_BL;
$DENDA_BAND = $u->DENDA_BAND;
$TARIF = $u->TARIF;
$NAMA_PEMIL = $u->NAMA_PEMIL;
$ALAMAT_STN = $u->ALAMAT_STN;
}
 ?>
<br style="clear: both" />
<br style="clear: both" />
<br style="clear: both" />
<br style="clear: both" />
<br style="clear: both" />
<br style="clear: both" />
<br style="clear: both" />
<br style="clear: both" />
<br style="clear: both" />
<center class= "bold">KARTU PENGAWASAN</center>

<center>Nomor : <?php echo $NO_SK;?></center>
<p>Berdasarkan Keputusan Kadis Penanaman Modal dan Pelayanan terpadu Satu Pintu Kabupaten Tasikmalaya <br>Nomor: xxxxxx xxxxxxx xxxxx tanggal <?php echo tanggal_indo($TG_MULAI);?> tentang Izin Trayek Angkutan Penumpang Umum, diberikan Kartu Pengawasan kepada  <?php echo $NAMA_PERUS; ?> yang dipimpin oleh <?php echo $NAMA_PEMIL;?> alamat <?php echo $ALAMAT_PEM; ?> Dari Tanggal <?php echo tanggal_indo($TG_MULAI);?> sampai dengan tanggal <?php echo tanggal_indo($TG_AKHIR);?> <br>
Dengan menggunakan mobil bis/mobil penumpang dengan menggunakan Lintasan trayek :</p>
<div class="lintasan">
<br><?php echo $NAMA_TRAYE;?><br><br></div>
<p>Untuk keperluan tersebut dipergunakan kendaraan sebagai berikut :</p>

<div class="half-left">
<table border="0">
	<tr>
		<td>Nomor Kendaraan</td>
		<td> : </td>
		<td><?php echo $NO_MOBIL;?></td>
	</tr>
	<tr>
		<td>Nomor Uji</td>
		<td> : </td>
		<td><?php echo $NO_UJI; ?></td>
	</tr>
	<tr>
		<td>Daya Angkut Penumpang</td>
		<td> : </td>
		<td><?php echo $DA_ORANG;?></td>
	</tr>
	<tr>
		<td>Barang</td>
		<td> : </td>
		<td><?php echo $DA_BARANG;?></td>
	</tr>
	<tr>
		<td>Jenis Kendaraan</td>
		<td> : </td>
		<td><?php echo $JENIS;?></td>
	</tr>
	<tr>
		<td>Merk / Tahun Pembuatan</td>
		<td> : </td>
		<td><?php echo $MERK . ' / ' .$TAHUN_PEMB;?></td>
	</tr>
	<tr>
		<td>Bahan Bakar</td>
		<td> : </td>
		<td><?php 
		if($BBM == 1){
		echo 'BENSIN';
		}else if($BBM == 2){
		echo 'SOLAR';
		}else if($BBM == 3){
		echo 'GAS';
		}
		?></td>
	</tr>
	<tr>
		<td>Fasilitas Pelayanan</td>
		<td> : </td>
		<td>
		<?php
			  if($PELAYANAN == 1){ echo 'AKDP';} 
                else if($PELAYANAN == 2){ echo 'DALAM KOTA';}
                 else if($PELAYANAN == 3){ echo 'DOOR TO DOOR SERV';}
                 else if($PELAYANAN == 4){ echo 'ANGKUTAN KHUSUS';}
             ?>

		</td>
	</tr>
	<tr>
		<td>Kode Trayek</td>
		<td> : </td>
		<td><?php echo $KODE_TRAYE;?></td>
	</tr>
	<tr>
		<td>Jenis Pelayanan</td>
		<td> : </td>
		<td><?php if( $SP == '1'){ echo 'PATAS'; }else{ echo 'EKONOMI';} ?></td>
	</tr>
	<tr>
		<td>Nama Pemilik</td>
		<td> : </td>
		<td><?php echo $NAMA_STNK;?></td>
	</tr>
	<tr>
		<td>Alamat Pemilik</td>
		<td> : </td>
		<td><?php echo $ALAMAT_STN;?></td>
	</tr>
		
</table>
</div>
<div class="half-right">
Diberikan di Tasikmalaya 
<br > Tanggal : <?php echo tanggal_indo($TG_MULAI);?>


<br>
<div class="half-right" style="border-bottom: 1px solid black; float: left; width: 100%;"></div>
<br>
<center>KEPALA DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU PROVINSI TASIKMALAYA
<br>
<br>
<br>
<br>
<br>

<br>
Dr. Ir. H. DADANG MOHAMMAD, MSCE
<br>Pembina Utama Madya
<br>NIP. 19601217 198511 1 002
</center>

</div>
 <br style="clear: both" />
 <br>
 Kewajiban Pengusaha Angkutan tercantum dibalik Kartu Pengawasan Ini<br> 
 <br>
DAFTAR WAKTU PERJALANAN (DWP) NO. INDUK KEND : <?php echo $NO_IK;?>
<br>NAMA PO : <?php echo $NAMA_PERUS;?>
<table border="1" width="100%">
	<tr>
		<th>Lintasan / Kota / Terminal</th>
		<th>PP-1</th>
		<th>PP-1</th>
		<th>PP-2</th>
		<th>PP-2</th>
		<th>PP-3</th>
		<th>PP-3</th>
		<th>PP-4</th>
		<th>PP-4</th>
		<th>PP-5</th>
		<th>PP-5</th>
		<th>PP-6</th>
		<th>PP-6</th>
	</tr>
	<?php
	foreach($bb_tpdwp as $u2){
                  ?>
                  <tr>
<td><?php echo $u2->NAMA_TERM3; ?></td>
<td align="center"><?php echo $u2->PP1_1; ?></td>
<td nalign="center"><?php echo $u2->PP1_2; ?></td>
<td align="center"><?php echo $u2->PP2_1; ?></td>
<td align="center"><?php echo $u2->PP2_2; ?></td>
<td align="center"><?php echo $u2->PP3_1; ?></td>
<td align="center"><?php echo $u2->PP3_2; ?></td>
<td align="center"><?php echo $u2->PP4_1; ?></td>
<td align="center"><?php echo $u2->PP4_2; ?></td>
<td align="center"><?php echo $u2->PP5_1; ?></td>
<td align="center"><?php echo $u2->PP5_2; ?></td>
<td align="center"><?php echo $u2->PP6_1; ?></td>
<td align="center"><?php echo $u2->PP6_2; ?></td>

                  </tr>
  <?php
}
 ?>
</table>