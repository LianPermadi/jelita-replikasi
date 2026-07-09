<!DOCTYPE html>
<?php
  include "royqrcode/qrlib.php";    
    $NO_SK = "";
$TG_SK = "";
$BERLAKU = "";
$NAMA_PERUS ="";
$ALAMAT_PER = "";
$PIT_ID = "";
$i=1;
$loop =1;
foreach($bb_izintrayek as $u){
 $NO_SK =  $u->NO_SK;
 $TG_SK = $u->TG_SK;
 $BERLAKU = $u->BERLAKU;
 $NAMA_PERUS = $u->NAMA_PERUS;
 $ALAMAT_PER = $u->ALAMAT_PER;
 $PIT_ID = $u->PIT_ID;
$loop++;
}
    //ofcourse we need rights to create temp dir
    //if (!file_exists($PNG_TEMP_DIR))
      //  mkdir($PNG_TEMP_DIR);
    //$filename = $PNG_TEMP_DIR.'test.png';
    $filename = 'qrcode_dkendaraan.png';
    $errorCorrectionLevel = 'L';
    if (isset($_REQUEST['level']) && in_array($_REQUEST['level'], array('L','M','Q','H')))
        $errorCorrectionLevel = $_REQUEST['level'];    

    $matrixPointSize = 4;
    if (isset($_REQUEST['size']))
        $matrixPointSize = min(max((int)$_REQUEST['size'], 1), 10);

    //display generated file
   QRcode::png(base_url()."bisbesar/c_izintrayek/cetak_daftarkendaraan_template/".$PIT_ID, $filename, $errorCorrectionLevel, $matrixPointSize, 2); 
   ?>
<style>
body{
  font-family: "Arial", Helvetica, sans-serif;
  font-size : 12px;
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
td{
   padding-left:1px;
   padding-right:1px;
   word-wrap: true;
   border-bottom: 1px solid black;
   height:100px;
}
th{
   padding-left:1px;
   padding-right:1px;
   word-wrap: true;
}

.bold{
  font-weight: bold;
}

.label-ats{
  margin-bottom: 5px;
    font-size : 12px;
}
.tbl{
  margin-left: 0px;
  
  border:1px solid red;

}
.ttd{
  width: 300px;
  height: 100px;
  border:0px solid red;
  margin-left: 350px;

 
}
.footer {
  position: fixed;
   /*  left: 0;*/
    bottom: 0;
    width: 100%;
    height:150px;
    background-color: transparent;
    color: black;
    text-align: center;
    margin-left: 60px;
    border:0px solid red;
}


@page { margin: 40px 25px;}
    header { position: fixed; top: -60px; left: 0px; right: 0px; background-color: lightblue; height: 50px; }
    footer { position: fixed; bottom: 0px;  border:1px solid red;}
    p { page-break-after: always; }
    p:last-child { page-break-after: never; }
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
<table border="0" width="100%">
  <tr>
  <td width="30px"> </td>
    <td width="55px" height="55px" style="margin-left: 20px">
<!--<img src="<?php echo base_url().'assets/images/icon/Logo_tasikmalaya_Clr.png' ?>" width="80%" height="100%">-->
<!---->

<img src="<?php //echo base_url().'assets/images/icon/Logo_tasikmalaya_Clr.png'; ?>" width="80%" height="100%">
    </td>
    <td width="30px"> </td>
    <td style=" vertical-align: top;" align="">
   <center style="font-size : 12px;"> <b><br><br></b></center><br><br>
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


 ?>
<br>
             <div class="label-ats">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            
             <?php echo $NO_SK; ?> </div>
            <div class="label-ats">
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

              
              <?php echo tanggal_indo($TG_SK);?> <!--s/d <?php echo $BERLAKU;?>-->
            </div>
               <br/>
                
            <label>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Trayek
             </label>
            </td>
      </tr>
</table>

<br>
             <br style="clear: both" />
             <center><b></b></center>
             <br style="clear: both" /><br>
              <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label> 
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
             
               <?php echo $NAMA_PERUS; ?> / <?php echo $ALAMAT_PER;?>
             <br style="clear: both" />
<br style="clear: both" />

<!--<div class="tbl">-->
<table cellpadding="0" cellspacing="0"  style="border-collapse: collapse;" height="200px">
                <thead style="border:none;">
                    <tr >

                        <th width="" align="center"> <br><br></th>
                        <th width="" align="center"></th>
                        <th width="" align="center"></th>
                        <th width="" align="center"></th>
                        <th width="" align="center"></th>
                        <th width="" align="center"></th>
                        <th width="" align="center"></th>
                        <th width="" align="center"></th>
                        <th width="" align="center"></th>
                        <th width="" align="center"></th>
                    </tr>
                </thead> 
                

                <tbody>

                <?php
                foreach($bb_izintrayek as $u2){
             
                   if ($i % 5 != 0 ) {
                  ?>

                  <tr>
<td width="30px" align="center"><?php echo $i++ ?></td>
<td width="87px" align="center"><?php echo $u2->NO_IK; ?></td>
<td width="80px" align="center"><?php echo $u2->NO_MOBIL; ?></td>
<td width="80px" align="center"><?php echo $u2->NO_UJI; ?></td>
<td width="70px" align="center"><?php echo $u2->MERK; ?></td>
<td width="55px" align="center"><?php 
if ($u2->BBM == '1'){
echo 'BENSIN';
}else if($u2->BBM == '2'){
echo 'SOLAR';
}else if($u->BBM == '3'){
echo 'GAS';
}
  ?></td>

<td width="66px" align="center"><?php echo $u2->TAHUN_PEMB; ?></td>

<td width="50px" align="center"><?php echo $u2->DA_ORANG; ?></td>
<td width="80px" align="center"><?php echo $u2->KODE_TRAYE; ?></td>
<td align="" style=""><?php echo $u2->TG_AKHIR;?> <br> <?php echo (ucwords($u2->NAMATRAYEK)); ?></td>

                  </tr>

  <?php
}
  
      else if($i % 5 == 0 && $i<$loop-1){
    ?>
      <tr>
<td width="30px" align="center"><?php echo $i++ ?></td>
<td width="87px" align="center"><?php echo $u2->NO_IK; ?></td>
<td width="80px" align="center"><?php echo $u2->NO_MOBIL; ?></td>
<td width="80px" align="center"><?php echo $u2->NO_UJI; ?></td>
<td width="70px" align="center"><?php echo $u2->MERK; ?></td>
<td width="55px" align="center"><?php 
if ($u2->BBM == '1'){
echo 'BENSIN';
}else if($u2->BBM == '2'){
echo 'SOLAR';
}else if($u->BBM == '3'){
echo 'GAS';
}
  ?></td>

<td width="66px" align="center"><?php echo $u2->TAHUN_PEMB; ?></td>

<td width="50px" align="center"><?php echo $u2->DA_ORANG; ?></td>
<td width="80px" align="center"><?php echo $u2->KODE_TRAYE; ?></td>
<td align="" style=""><?php echo $u2->TG_AKHIR;?> <br> <?php echo (ucwords($u2->NAMATRAYEK)); ?></td>

                  </tr>

    <tr>
      <td height ="120" style="border:0px solid red;"> </td>
      <td style="border:0px solid red;"><br><br><br><br><br><br><img src="<?php echo base_url().'qrcode_dkendaraan.png' ?>" width="88px" height="88px"></td>
      <td style="border:0px solid red;"></td>
      <td style="border:0px solid red;"></td>
      <td style="border:0px solid red;"></td>
      <td style="border:0px solid red;"></td>
  
      <td colspan="5" style="border:0px solid red; font-size: 12px;">
      
 <?php echo br(5);?>
       <center><img src="<?php echo base_url().'assets/images/icon/ttd.png' ?>" width="100px" height="40px">
<br>
  <u>Dr. Ir. H. DADANG MOHAMMAD, MSCE</u>
<br>Pembina Utama Madya
<br>NIP 19601217 196511 1 002
        </center>
      </td>
    </tr>
     <tr>
      <td height ="70" style="border:0px solid red;"> </td>
      <td style="border:0px solid red;"></td>
      <td style="border:0px solid red;"></td>
      <td style="border:0px solid red;"></td>
  
      <td colspan="7" style="border:0px solid red;vertical-align: top; font-size: 12px;">

<?php
echo br(3);
 echo $NO_SK; ?><br>
 <?php echo tanggal_indo($TG_SK).'<br>  &nbsp; &nbsp; &nbsp; Trayek';?>
      </td>
    </tr>

     <tr>
      <td height ="70" style="border:0px solid red;"> </td>
      <td style="border:0px solid red;"></td>
       
      <td colspan="8" style="border:0px solid red;vertical-align: top; font-size: 12px;">
      <br><br>&nbsp; &nbsp; 
       <?php echo $NAMA_PERUS; ?> / <?php echo $ALAMAT_PER;?>

</td>

</tr>
  <?php
  } 

}

 ?>

            
        
<?php 

if (($i-1)%5 != 0){
  if(substr($i-1,-1) == 1 || substr($i-1,-1)==6)
  {
    ?>
<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
    <?php
  }else if(substr($i-1,-1) == 2 || substr($i-1,-1)==7)
  {
    ?>
<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
    <?php
  }else if(substr($i-1,-1) == 3 || substr($i-1,-1)==8)
  {
    ?>
<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
    <?php
  }else if(substr($i-1,-1) == 4 || substr($i-1,-1)==9)
  {
    ?>
<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
    <?php
  }
  ?>
  <tr>      <td height ="120" style="border:0px solid red;"> </td>
      <td style="border:0px solid red;"><br><br><br><br><br><br><img src="<?php echo base_url().'qrcode_dkendaraan.png' ?>" width="88px" height="88px"></td>
      <td style="border:0px solid red;"></td>
      <td style="border:0px solid red;"></td>
      <td style="border:0px solid red;"></td>
      <td style="border:0px solid red;"></td>
  
      <td colspan="5" style="border:0px solid red; font-size: 12px;">
      
 <?php echo br(5);?>
       <center><img src="<?php echo base_url().'assets/images/icon/ttd.png' ?>" width="100px" height="40px">
<br>
  <u>Dr. Ir. H. DADANG MOHAMMAD, MSCE</u>
<br>Pembina Utama Madya
<br>NIP 19601217 196511 1 002 
        </center>
      </td></tr>
  <?php
}

?>
</tbody>
                </table>
<!--</div>-->
<br style="clear: both" />
<br style="clear: both" />
