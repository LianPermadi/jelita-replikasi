<style>
body{
  font-family: "Arial", Helvetica, sans-serif;
  font-size : 12px;
  margin-top: 165px;
  
}
table {
  font-family: "Arial", Helvetica, sans-serif;
  font-size : 12px;
  
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
	height:70px;
	overflow:hidden;
border : 0px solid black;
margin-top: 5px;
margin-bottom: 5px;
text-align: center;
}
#line{
  width:100%;
  float:left;
  border:1px solid black;
  margin-top: 10px;
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
.Kadis{
	border:1px solid red;
	margin-left: 200px;
	width:50%;
}
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
$NO_IP = "";

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
$NO_IP = $u->NO_IP;
}
 ?>


<center> <?php echo $NOMOR_KP;?></center>
<?php echo br(2);?>
<label style="margin-left: 230px;">Kadis Penanaman Modal dan Pelayanan terpadu Satu Pintu</label>
<br> 
<table border="0" width="100%">
	<tr>
		<td width="280px" align="center"><?php echo $NO_SK;?></td>
		<td width="50px" align="center"> </td>
		<td width="150px" align="center"><?php echo tanggal_indo($TG_MULAI);?></td>
		<td width="50px"> </td>
		<td align="center">Trayek</td>
	</tr>
</table>
<label style="margin-left:440px;"><?php echo $NAMA_PERUS; ?></label>
<table border="0" width="100%" style="font-size:10px;">
	<tr>
		<td width="130px" align="center"> </td>
		<td width="200px" align=""><?php echo $NAMA_PEMIL;?></td>
		<td align="" style="font-size:9px;" ><?php echo substr($ALAMAT_PEM,0,65); ?></td>
	</tr>
</table>
<!--<div style="margin-left: 20px; border:1px solid red; width: 280px; float: left;"><?php echo $NO_SK;?></div>  
<div style=" margin:auto;border:1px solid red; width: 300px; float:right;"> <?php echo tanggal_indo($TG_MULAI);?></div>-->
    <label style="margin-left:110px"><?php echo tanggal_indo($TG_MULAI);?> 
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;
    <?php echo tanggal_indo($TG_AKHIR);?> </label><br>
    <label style="margin-left:400px">
    	Lintasan trayek :
    </label>

<div class="lintasan">
<br>
<?php echo $NAMA_TRAYE;?></div>
<br>
<?php echo br(4);?>


<table border="0" style="font-size:12px; ">
<tr>
<td width="150px;">  </td>
		<td width="300px;">
<label > <?php echo $NO_MOBIL;?></label><br>
<label> <?php echo $NO_UJI; ?></label><br>
<label > <?php echo $DA_ORANG; ?></label><br>
<label> <?php echo $DA_BARANG; ?></label><br>
<label> <?php echo $JENIS; ?></label><br>
<label> <?php echo $MERK . ' / ' .$TAHUN_PEMB; ?></label><br>
<label> <?php 
		if($BBM == 1){
		echo 'BENSIN';
		}else if($BBM == 2){
		echo 'SOLAR';
		}else if($BBM == 3){
		echo 'GAS';
		}
		?></label><br>
<label> <?php
			  if($PELAYANAN == 1){ echo 'AKDP';} 
                else if($PELAYANAN == 2){ echo 'DALAM KOTA';}
                 else if($PELAYANAN == 3){ echo 'DOOR TO DOOR SERV';}
                 else if($PELAYANAN == 4){ echo 'ANGKUTAN KHUSUS';}
             ?></label><br>
<label> <?php echo $KODE_TRAYE; ?></label><br>
<label> <?php if( $SP == '1'){ echo 'PATAS'; }else{ echo 'EKONOMI';} ?></label><br>
<label> <?php echo $NAMA_STNK; ?></label><br>
<label> <?php echo $ALAMAT_STN; ?></label><br>

		 </td>
	
	<td style=" vertical-align: top;">

<br ><br >
<?php echo tanggal_indo($TG_MULAI);?>
<br>
<br>
<center>
<?php echo br(3);?>
<img src="<?php echo base_url().'assets/images/icon/ttd.png' ?>" width="100px" height="40px">
<br>
Dr. Ir. H. DADANG MOHAMMAD, MSCE
<br>Pembina Utama Madya
<br>NIP. 19601217 198511 1 002
</center>
		</td>
	</tr>
</tr>
</table>

<br>
<!--<table border="1" style="font-size:11px; ">
	<tr style = "height: 100px;">
		<td width="120px;">  </td>
		<td width="20px;"> </td>
		<td><?php echo $NO_MOBIL;?></td>
		<td rowspan="11" style=" vertical-align: top;">

<br >
<br >
<center><?php echo tanggal_indo($TG_MULAI);?></center>
<br>
<br>
<center>
<?php echo br(3);?>
<img src="<?php echo base_url().'assets/images/icon/ttd.png' ?>" width="100px" height="40px">
<br>
Dr. Ir. H. DADANG MOHAMMAD, MSCE
<br>Pembina Utama Madya
<br>NIP. 19601217 198511 1 002
</center>
		</td>
	</tr>
	<tr>
		<td></td>
		<td>  </td>
		<td><?php echo $NO_UJI; ?></td>
	</tr>
	<tr>
		<td></td>
		<td>  </td>
		<td><?php echo $DA_ORANG;?></td>
	</tr>
	<tr>
		<td></td>
		<td> </td>
		<td><?php echo $DA_BARANG;?></td>
	</tr>
	<tr>
		<td></td>
		<td>  </td>
		<td><?php echo $JENIS;?></td>
	</tr>
	<tr>
		<td></td>
		<td>  </td>
		<td><?php echo $MERK . ' / ' .$TAHUN_PEMB;?></td>
	</tr>
	<tr>
		<td></td>
		<td>  </td>
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
		<td></td>
		<td> </td>
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
		<td></td>
		<td>  </td>
		<td><?php echo $KODE_TRAYE;?></td>
	</tr>
	<tr>
		<td></td>
		<td>  </td>
		<td><?php if( $SP == '1'){ echo 'PATAS'; }else{ echo 'EKONOMI';} ?></td>
	</tr>
	<tr>
		<td></td>
		<td> </td>
		<td><?php echo $NAMA_STNK;?></td>
	</tr>
	<tr>
		<td></td>
		<td>  </td>
		<td colspan="2"><?php echo $ALAMAT_STN;?></td>
	</tr>
		
</table>-->

 <br style="clear: both" />

 <label style="margin-left:370px;">
  <?php echo $NO_IK;?>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 

 <?php echo $NO_IP;?></label>
<br><br>
 <label style="margin-left:100px;"><?php echo $NAMA_PERUS;?></label>
 <?php echo br(4);?>
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
<td align="center"><?php echo $u2->PP1_2; ?></td>
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
