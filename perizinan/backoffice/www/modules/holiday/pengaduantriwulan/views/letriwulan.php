<?php
		header("Content-Type: application/vnd.ms-word");
       header("Expires: 0");
        header("Cache-Control:  must-revalidate, post-check=0, pre-check=0");
        header("Content-disposition: attachment; filename=Perngaduan Pertriwulan Tahun '.  $this->input->post('tgla').xls");
	?>
<html>
<head>
<title>Pengaduan Pertriwulan</title>
</head>

<body>
  
      
                  
<form name="form1" method="post">
 

       
   <table align="center" width="80%" border="0" class="display" cellpadding="1" cellspacing="0" id="rev">
   <tr align="center">
   <td></td>
   <td ><?php
   $Back_data = array(
               'src' => base_url().'assets/images/icon/logo Jawa_Barat.png',
                   //'alt' => 'Lihat di HTML to Openoffice',
                    'title' => 'Kembali',
                    //'onclick' => 'parent.location=\''. site_url('pengaduantriwulan/triwulan'). '\''
                   );
					echo br();
                  echo img($Back_data);
				//echo br();
					
					?>
					</td>
					<td></td>
					<td ><b>BADAN PELAYANAN PERIZINAN TERPADU PROVINSI TASIKMALAYA</b><?php echo br();?>
					Jalan Phh Mustafa Nomor 22 - Telp. (022)7217744 Fax (022)7217755
					
</td>
					</tr>
					<tr align="center">
					<td></td>
					<td><b> <?php
			
           // echo '================================================================';
             //echo br(2);
			?></b></td>
					</tr>
					
					<tr align="center">
					<td></td>
					<td></td>
					<td></td>
					<td><b> <?php
			
            echo 'Perngaduan Pertriwulan Tahun '.  $this->input->post('tgla');
             
			?></b></td>
			<td><?php echo br(2);?></td>
					</tr>
					<tr>
					<td></td><td></td><td></td><td></td><td></td>
					</tr>
					</table>
					 <table align="center" width="100%" border="1" class="display" cellpadding="1" cellspacing="0" id="rev">
        <tr class="title" bgcolor="#d5dffe">
           <th rowspan="1"><font  size="1" color="#1A1A1A"><b>No</b></font></th>
           <th rowspan="1"><font  size="1" color="#1A1A1A"><b>TRIWULAN</b></font></th>
           <th rowspan="1"><font  size="1" color="#1A1A1A"><b>PENGADUAN</b></font></th>
           <th rowspan="1"><font  size="1" color="#1A1A1A"><b>PENYELESAIAN</b></font></th>
		   <th rowspan="1"><font  size="1" color="#1A1A1A"><b>% PENYELESAIAN</b></font></th>
     </tr>
     
<!---------------------------------------------------------------------------------------------------.-->
              
<?php
foreach($isi as $baris){
?>

					<tr align="center">
                        <td align="center"><?php echo '1'; ?></td>
                        <td align="center"><?php echo 'I'; ?></td>
						<td><?php echo intval($baris->jumlah); ?></td>
						
<?php

}
?>
<?php
foreach($isi2 as $baris2){
?>

					
						<td><?php echo intval($baris2->jumlah); ?></td>

<?php

}
?>
<?php
$a=intval($baris->jumlah);
$b=intval($baris2->jumlah);
if($a==0 or $b==0){
$persen=0;
}else{
$persen=$b/$a * 100;
}
?>
<td><?php echo round($persen);echo ' %'; ?></td>
						</tr>

<?php
foreach($isi3 as $baris3){
?>
<tr align="center">
					 <td align="center"><?php echo '2'; ?></td>
                        <td align="center"><?php echo 'II'; ?></td>
						<td><?php echo intval($baris3->jumlah); ?></td>
					
<?php

}
?>
<?php
foreach($isi4 as $baris4){
?>

					
						<td><?php echo intval($baris4->jumlah); ?></td>
						
<?php

}
?>
<?php
$c=intval($baris3->jumlah);
$d=intval($baris4->jumlah);
if($c==0 or $d==0){
$persen2=0;
}else{
$persen2=$d/$c * 100;
}
?>
<td><?php echo round($persen2);echo ' %'; ?></td>
						</tr>

<?php
foreach($isi5 as $baris5){
?>
<tr align="center">
					 <td align="center"><?php echo '3'; ?></td>
                        <td align="center"><?php echo 'III'; ?></td>
						<td><?php echo intval($baris5->jumlah); ?></td>
					
<?php

}
?>
<?php
foreach($isi6 as $baris6){
?>

						<td><?php echo intval($baris6->jumlah); ?></td>
				
<?php

}

?>
<?php
$e=intval($baris5->jumlah);
$f=intval($baris6->jumlah);
if($e==0 or $f==0){
$persen3=0;
}else{
$persen3=$f/$e * 100;
}
?>
<td><?php echo round($persen3); echo ' %';?></td>
						</tr>
<?php
foreach($isi7 as $baris7){
?>
<tr align="center">
					 <td align="center"><?php echo '4'; ?></td>
                        <td align="center"><?php echo 'IV'; ?></td>
						<td><?php echo intval($baris7->jumlah); ?></td>
					
<?php

}
?>
<?php
foreach($isi8 as $baris8){
?>

						<td><?php echo intval($baris8->jumlah);  ?></td>
					
<?php

}
?>
<?php
$g=intval($baris7->jumlah);
$h=intval($baris8->jumlah);
if($g==0 or $h==0){
$persen4=0;
}else{
$persen4=$h/$g * 100;
}
?>
<td><?php echo round($persen4);echo ' %'; ?></td>
						</tr>

<tr align="center" bgcolor="#d5dffe">

<td></td>
<td><b>TOTAL</b></td>
<?php 
$tot1=$a+$c+$e+$g ;
$tot2=$b+$d+$f+$h;
if ($tot1==0 or $tot2==0){
$totpersen=0;
}else{
$totpersen=$tot2/$tot1*100;
}
?>
<td><b><?php echo $tot1; ?></b></td>
<td><b><?php echo  $tot2;?></b></td>
<td><b><?php echo  $totpersen; echo ' %';?></b></td>
</tr>


<!---------------------------------------------------------------------------------------------------.-->
      
</table>

<?//php echo $rowdatat['jumlahizin'];echo 'xxxxxxx'; echo br(3);?>
         </fieldset>
    
</form>
<?php

 echo br();?>
        </div>
        </div>
</body>
</html>
