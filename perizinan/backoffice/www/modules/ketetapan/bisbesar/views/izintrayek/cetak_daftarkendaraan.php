<style>
body{
  font-family: "Arial", Helvetica, sans-serif;
  font-size : 12px;
  margin-bottom: 100px;
}
.#logo{
  width: 100px;
  height: 100px;
  float:left;
  margin-left:30px;
}
table{
  font-family: "Arial", Helvetica, sans-serif;
  font-size : 10px;
  border-collapse: collapse;


}
td,th{
   padding-left:1px;
   padding-right:1px;
   word-wrap: true;
}


.bold{
  font-weight: bold;
}




@media print {
    #with_print {
        display: none;
    }
   
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
<table border="0" width="90%">
  <tr>
  <td width="30px"> </td>
    <td width="55px" height="55px" style="margin-left: 20px">
<!--<img src="<?php echo base_url().'assets/images/icon/Logo_tasikmalaya_Clr.png' ?>" width="80%" height="100%">-->
<!---->

<img src="<?php echo base_url().'assets/images/icon/Logo_tasikmalaya_Clr.png'; ?>" width="80%" height="100%">
    </td>
    <td width="30px"> </td>
    <td style=" vertical-align: top;" align="">
   <center style="font-size : 12px;"> <b>LAMPIRAN KEPUTUSAN DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU PROVINSI TASIKMALAYA</b></center><br><br>
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
$BERLAKU = "";
$NAMA_PERUS ="";
$ALAMAT_PER = "";

$i=1;
foreach($bb_izintrayek as $u){
 $NO_SK =  $u->NO_SK;
 $TG_SK = $u->TG_SK;
 $BERLAKU = $u->BERLAKU;
 $NAMA_PERUS = $u->NAMA_PERUS;
 $ALAMAT_PER = $u->ALAMAT_PER;
}
 ?>

             <label>Nomor &nbsp;&nbsp;&nbsp;</label> : &nbsp;&nbsp;&nbsp;<?php echo $NO_SK; ?>
             <br/>
              <label>Tanggal &nbsp;</label> : &nbsp;&nbsp;&nbsp;<?php echo tanggal_indo($TG_SK);?> <!--s/d <?php echo $BERLAKU;?>-->
               <br/>
            <label>Tentang &nbsp;</label> : &nbsp;&nbsp;&nbsp;Izin Trayek Angkutan Penumpang Umum di Wilayah Kabupaten Tasikmalaya
            </td>
      </tr>
</table>

<br>
             <br style="clear: both" />
             <center><b>DAFTAR KENDARAAN</b></center>
             <br style="clear: both" /><br>
              <label>Nama Perusahaan</label> : <?php echo $NAMA_PERUS; ?> / <?php echo $ALAMAT_PER;?>
             <br style="clear: both" />
<br style="clear: both" />

<table cellpadding="0" cellspacing="0" border="1" class="display" id="izintrayek" style="border-collapse: collapse;" >
                <thead>
                    <tr >
                         <th width="" align="center">NO</th>
                        <th width="" align="center">Nomor Induk Kendaraan</th>
                        <th width="" align="center">Nomor Kendaraan</th>
                        <th width="" align="center">Nomor Pemeriksaan</th>
                        <th width="" align="center">Merk Pabrik</th>
                        <th width="" align="center">Bahan Bakar</th>
                        <th width="" align="center">Tahun Pemb.</th>
                        <th width="" align="center">Daya Angkut</th>
                        <th width="" align="center">Kode Trayek</th>
                        <th width="" align="center">Masa Berlaku Izin / Trayek</th>
                       
                    </tr>
                </thead>
                <tbody>
                <?php
                foreach($bb_izintrayek as $u2){
                  ?>
                  <tr>
<td align="center"><?php echo $i++ ?></td>
<td align="center"><?php echo $u2->NO_IK; ?></td>
<td align="center"><?php echo $u2->NO_MOBIL; ?></td>
<td align="center"><?php echo $u2->NO_UJI; ?></td>
<td align="center"><?php echo $u2->MERK; ?></td>
<td align="center"><?php 
if ($u2->BBM == '1'){
echo 'BENSIN';
}else if($u2->BBM == '2'){
echo 'SOLAR';
}else if($u->BBM == '3'){
echo 'GAS';
}
  ?></td>

<td align="center"><?php echo $u2->TAHUN_PEMB; ?></td>

<td align="center"><?php echo $u2->DA_ORANG; ?></td>
<td align="center"><?php echo $u2->KODE_TRAYE; ?></td>
<td align="" style=""><?php echo $u2->TG_AKHIR;?> <br> <?php echo (ucwords($u2->NAMATRAYEK)); ?></td>

                  </tr>
  <?php
}
 ?>
                <?php
       /* if($izintrayek_table !== "")
        {

            echo $izintrayek_table;

        }
        else
        {
        ?>

            <tr>
            <td colspan="6"><center>Tidak ada data</center></td>
            </tr>
            <?php } */?>
        </tbody>
                </table>

<br style="clear: both" />
<br>

<table border="0" width="100%">
  <tr>
    <td width="300px"> </td>
     <td align="center" style="font-size : 12px;" >KEPALA BADAN PENANAMAN MODAL DAN PERIJINAN TERPADU <br> PROVINSI TASIKMALAYA

<br><br>
<img src="<?php echo base_url().'assets/images/icon/ttd.png' ?>" width="100px" height="40px">
<br>
  <u>Dr. Ir. H. DADANG MOHAMMAD, MSCE</u>
<br>Pembina Utama Madya
<br>NIP 19601217 196511 1 002</td>
  </tr>
</table>


