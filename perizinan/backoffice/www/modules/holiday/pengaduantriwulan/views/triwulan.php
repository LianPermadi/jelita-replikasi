

<html>
<head>
<title>Pengaduan Pertriwulan</title>
</head>
<!--<body onLoad="window.print()">-->
<body>
  <div id="content">
    <div class="post">
        <div class="title">
            <h2><center><b><?php echo $page_name; echo br();echo 'Tahun'. $this->input->post('tgla');?><b></center></h2>
        </div>

        <div class="entry">
        <fieldset id="half">
            <legend>Periode</legend>
           <?php
			   echo form_open('pengaduantriwulan/triwulan');
			  
            ?>
			

     
<div id="statusRail">
              <div id="leftRail">
            <?php

                    echo form_label('Tahun','d_tahun');
           ?>
		   </div>
		   <div id="rightRail">
		   <?php
$now=date('Y');
echo "<select name='tgla' style='width: 150px' ><option selected>";
for ($a=$now;$a>=$now-20;$a--)
{
     echo "<option value=' ".$a." '>".$a."</option>";
	 
}
echo "</select>";

?>
              </div>
      </div>

      
                   <div id="statusRail">
              <div id="leftRail"></div>
              <div id="rightRail">
                <?php
				
                    $filter_data = array(
                        'name' => 'button',
                        'class' => 'button-wrc',
                        'content' => 'Filter',
                        'value' => 'Filter'
						
                    );

                    // $reset_data = array(
                      //              'name' => 'button',
                        //            'content' => 'Reset Filter',
                          //          'value' => 'Reset Filter',
                            //        'class' => 'button-wrc',
                              //      'onclick' => 'parent.location=\''. site_url('pengaduantriwulan/triwulan') . '\''
                //    );

                    echo form_submit($filter_data); 
					 echo form_close();
					$b= $this->input->post('tgla');
		   echo form_open('pengaduantriwulan/lwpengaduantriwulan/triwulan');
		   echo form_hidden('tgla',$b);
		  
                   // echo form_button($reset_data);
                    ?>
              </div>
            </div>
            
        </fieldset>
       <br>
<form name="form1" method="post">
   
     <fieldset>
         <legend style="color: #045000"  align="right"><b>
             <?php
			 //echo br();
           echo 'Perngaduan Pertriwulan  ';echo 'Tahun'. $this->input->post('tgla');
             //echo br(2);
			?>
          </legend></b>
 <table align=left>
        <tr>
            <td align="center">
           <?php
		  
                  //  $Back_data = array(
                   //'src' => base_url().'assets/images/icon/back_alt.png',
                    //'alt' => 'Lihat di HTML to Openoffice',
                    //'title' => 'Kembali',
                    //'onclick' => 'parent.location=\''. site_url('pengaduantriwulan/triwulan'). '\''
                    //);
					
                //    echo img($Back_data);
            ?>
             <?php
         // $img_cetak = array(
           //                 'src' => base_url().'assets/images/icon/print.png',
             //               'alt' => 'Selesai',
               //             'title' => 'View Report with OpenOffice',
                            //'onclick' => 'parent.location=\''. site_url('kinerjaizin/izin/cetak').'/'.$tgla.'/'.$tglb. '\''
               //         );

                 //       echo img($img_cetak);
         //    echo anchor(site_url('rekapitulasi/realisasi/cetak_reporting') .'/'. $list_tahun->d_tahun, img($img_cetak))."&nbsp;";
         ?>
		 
		  <?php
		    //echo form_open('pengaduantriwulan/lwpengaduantriwulan/triwulan');
                   // $word = array(
                   //'src' => base_url().'assets/images/icon/word.png',
                    //'alt' => 'cetak ke word',
                    //'title' => 'cetak ke word',
                    //'onclick' => 'parent.location=\''. site_url('pengaduantriwulan/lwpengaduantriwulan/triwulan'). '\''
                    //);
                   // echo img($word);
				   
                    
            ?>
			<?php
                    $excel = array(
                   'src' => base_url().'assets/images/icon/excel.png',
                    //'alt' => 'cetak ke excel',
                    //'title' => 'cetak ke excel',
					'class' => 'button-wrc',
					'type'=>'submit',
					'value'=>'cetak to word'
                    //'onclick' => 'parent.location=\''. site_url('pengaduantriwulan/lwpengaduantriwulan/triwulan'). '\''
                    );
					
                    echo form_submit($excel);
					echo form_close();
					?>
					</td><td>
					<?php
					 echo form_open('pengaduantriwulan/lwpengaduantriwulan/triwulan2');
		   echo form_hidden('tgla',$b);
					$word = array(
                   'src' => base_url().'assets/images/icon/excel.png',
                    //'alt' => 'cetak ke excel',
                    //'title' => 'cetak ke excel',
					'class' => 'button-wrc',
					'type'=>'submit',
					'value'=>'cetak to excel'
                    //'onclick' => 'parent.location=\''. site_url('pengaduantriwulan/lwpengaduantriwulan/triwulan'). '\''
                    );
                    echo form_submit($word);
            ?>
            </td>
        </tr>
		
		<tr align="center"><?//php echo 'Bidang :'; echo $rq;?></tr>
    </table>
   <table align="center" width="800" border="1" class="display" cellpadding="1" cellspacing="0" id="rev">
        <tr class="title">
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
<tr></tr>
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
