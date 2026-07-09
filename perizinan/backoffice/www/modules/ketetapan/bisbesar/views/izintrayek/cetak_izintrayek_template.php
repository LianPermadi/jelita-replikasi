<?php
  include "royqrcode/qrlib.php";    
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
foreach($bb_izintrayek as $u){
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
    //ofcourse we need rights to create temp dir
    //if (!file_exists($PNG_TEMP_DIR))
      //  mkdir($PNG_TEMP_DIR);
    //$filename = $PNG_TEMP_DIR.'test.png';
    $filename = 'qrcode_sk.png';
    $errorCorrectionLevel = 'L';
    if (isset($_REQUEST['level']) && in_array($_REQUEST['level'], array('L','M','Q','H')))
        $errorCorrectionLevel = $_REQUEST['level'];    

    $matrixPointSize = 4;
    if (isset($_REQUEST['size']))
        $matrixPointSize = min(max((int)$_REQUEST['size'], 1), 10);

    //display generated file
   QRcode::png(base_url()."bisbesar/c_izintrayek/cetak_izintrayek/".$PIT_ID, $filename, $errorCorrectionLevel, $matrixPointSize, 2); 
   ?>

<style>

body{
  font-family: "Arial", Helvetica, sans-serif;
  font-size : 12px;
  margin-top: 150px;

}
table {
  font-family: "Arial", Helvetica, sans-serif;
  font-size : 11px;
  
    border-collapse: collapse;


}
td{
   padding-left:5px;
   padding-right:5px;

}
th{
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
#line{
  width:100%;
  float:left;
  border:1px solid black;
  margin-top: 10px;
}
.underline{
  text-decoration: underline;;
}
#tbl{
  width:100%;
  border:0px solid red;
margin-left: 5%;
}
#tbl2{
  width:50%;
  border:1px solid red;
margin-left: 48%;
margin-top: 20px;
}


</style>

<script>
  function close_window() {
  if (confirm("Keluar dari halaman ini ?")) {
    close();
  }
}
</script>


<!--<button onclick="window.print()"  id="with_print" >Print</button>
<button onclick="close_window()"  id="with_print">Keluar</button>
<br><div class="judul">
<div class="logo"><img src="<?php echo base_url().'assets/images/icon/Logo_tasikmalaya_Clr.png' ?>" width="65%" height="65%"></div>


PEMERINTAH PROVINSI TASIKMALAYA<br> 
DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU
<br>
Jalan Sumatera Nomor 50 Telepon (022) 4237369 Faksimile (022) 4237081
<br>
Website : www.spekta.tasikmalayakab.go.id email : dpmptsp@tasikmalayakab.go.id
TASIKMALAYA - 40115-->



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

//echo tanggal_indo('2016-03-20');


 ?>

 <?php echo br(4);echo '<center>'.$NO_SK.'</center>'; ?>
             </center>
             <br>   <br>
            

<?php echo br(21);?>
 <br style="clear: both" />
<div id="tbl">

 <table border=""  >
 <tr>
 <th></th>
 <th ></th>
 </tr>
 <tr>
    <td></td>
    <td><?php echo $NAMA_PERUS;?> </td>
 </tr>

<tr>
<td></td>
    <td><?php echo $PEMILIK;?> </td>
 </tr>

 <tr>
 <td></td>
    <td><?php echo $ALAMAT_PER;?> </td>
 </tr>
 <tr>
 <td></td>
    <td><?php echo $ALAMAT_PEM;?> </td>
 </tr>
 <tr>
 <td></td>
    <td><?php echo $NO_IP;?> </td>
 </tr>
 <tr>
 <td></td>
    <td><?php echo tanggal_indo($BERLAKU);?> </td>
 </tr>
 <tr>
 <td></td>
    <td><?php echo $KETERANGAN;?> </td>
 </tr>
 
 
  <tr>
<td ></td>
    <td width=""  align=""> 
    <?php echo br(5);?>
    <center>Tasikmalaya</center>
 </td>
 </tr>
 <tr >
 <td></td>
 <td><center>
<?php echo tanggal_indo($TG_SK);?></center>
 <?php echo br(8);?>

  </td>
  </tr>
  <tr>

  <td width="300px"><img src="<?php echo base_url().'qrcode_sk.png' ?>" width="100px" height="100px"></td>
<td>


<center>

<img src="<?php echo base_url().'assets/images/icon/ttd.png' ?>" width="100px" height="40px">
<br>
  <u><b>Dr. Ir. H. DADANG MOHAMMAD, MSCE</b></u><br>
Pembina Utama Madya
<br>NIP 19601217 196511 1 002</center>
    </td>
   
 </tr>
 </table>

</div>
 <br style="clear: both" />

<!--<div id="tbl2">
<center><img src="<?php echo base_url().'assets/images/icon/ttd.png' ?>" width="100px" height="30px"></center>
<center><u><b>Dr. Ir. H. DADANG MOHAMMAD, MSCE</b></u></center><br>
<center>Pembina Utama Madya</center>
<center>NIP 19601217 196511 1 002</center>

</div>-->


           
