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
.kepalaright {
  width:400px;
  overflow:hidden;
  text-align: center;
  float:right;

}

.logo{
  width: 100px;
  height: 100px;
  float:left;
  margin-left:30px;
}
.judul{
  width:650px;
  overflow:hidden;
  float:left;
  margin:10px;
}
@media print {
    #with_print {
        display: none;
    }
    @page { size: US-Legal landscape; margin: 0.4in }
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
<br><div class="judul">
<div class="logo"><img src="<?php echo base_url().'assets/images/icon/Logo_tasikmalaya_Clr.png' ?>" width="80%" height="90%"></div>

<br>
<center class= "bold">LAMPIRAN KEPUTUSAN DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU<br> SATU PINTU PROVINSI TASIKMALAYA </center> 
<br>


<?php 
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
              <label>Tanggal &nbsp;</label> : &nbsp;&nbsp;&nbsp;<?php echo $TG_SK;?> <!--s/d <?php echo $BERLAKU;?>-->
               <br/>
            <label>Tentang &nbsp;</label> : &nbsp;&nbsp;&nbsp;Izin Trayek Angkutan Penumpang Umum di Wilayah Kabupaten Tasikmalaya
</div>
             <br style="clear: both" />
             <center class= "bold">DAFTAR KENDARAAN</center>
             <br style="clear: both" />
              <label>Nama Perusahaan</label> : <?php echo $NAMA_PERUS; ?> / <?php echo $ALAMAT_PER;?>
             <br style="clear: both" />
<br style="clear: both" />

<table cellpadding="0" cellspacing="0" border="1" class="display" id="izintrayek" >
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
<td align=""><?php echo $u2->BERLAKU;?> <br> <?php echo (ucwords($u2->NAMATRAYEK)); ?></td>

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
  <div class="kepalaright bold">KEPALA BADAN PENANAMAN MODAL DAN PERIJINAN TERPADU <br> PROVINSI TASIKMALAYA

<br>
<br>
<br>
<br>
<br>
<br>
<br>
  Dr. Ir. H. DADANG MOHAMMAD, MSCE
<br>Pembina Utama Madya
<br>NIP 19601217 196511 1 002
  </div>

