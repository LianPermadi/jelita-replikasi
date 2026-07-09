
<script language="javascript" type="text/javascript">
    function popup_link(site, targetDiv){
        $.ajax({url: site,success: function(response){$(targetDiv).html(response);}, dataType: "html"});
    }

    $(document).ready(function() {
        oTable = $('#roygrid').dataTable({
                "bJQueryUI": true,
                "bDestroy": true,
                "sPaginationType": "full_numbers"
        });

    } );
	</script>
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
         
					</td><td>
					<?php
				
					$tgla=$this->input->post('tgla');
				
					  $word = array(
                                                'src' => base_url().'assets/images/icon/word.png',
                                                'alt' => 'Selesai',
                                                'title' => 'Cetak ke word',
                                                 'onclick' => 'parent.location=\''. site_url('pengaduantriwulan/lwpengaduantriwulan/lw').'/'.$tgla.'\''
                                            );
                                            echo img($word);
					$excel= array(
                                                'src' => base_url().'assets/images/icon/excel.png',
                                                'alt' => 'Selesai',
                                                'title' => 'Cetak ke excel',
                                                 'onclick' => 'parent.location=\''. site_url('pengaduantriwulan/lwpengaduantriwulan/le').'/'.$tgla.'\''
                                            );
                                            echo img($excel);

            ?>
            </td>
        </tr>
		
		<tr align="center"><?//php echo 'Bidang :'; echo $rq;?></tr>
    </table>
   <table align="center" width="800" border="0" class="display" cellpadding="1" cellspacing="0" id="roygrid">
        <thead><tr class="title">
           <th rowspan="1"><font  size="1" color="#1A1A1A"><b>No</b></font></th>
           <th rowspan="1"><font  size="1" color="#1A1A1A"><b>TRIWULAN</b></font></th>
           <th rowspan="1"><font  size="1" color="#1A1A1A"><b>PENGADUAN</b></font></th>
           <th rowspan="1"><font  size="1" color="#1A1A1A"><b>PENYELESAIAN</b></font></th>
		   <th rowspan="1"><font  size="1" color="#1A1A1A"><b>% PENYELESAIAN</b></font></th>
     </tr></thead>
     
<!---------------------------------------------------------------------------------------------------.-->
              
<?php
foreach($isi as $baris){
?>

					<tr align="center">
                        <td align="center"><?php echo '1'; ?></td>
                        <td align="center"><?php echo 'I'; ?></td>
						<td><?php 
						if(intval($baris->jumlah)==0){
										echo intval($baris->jumlah);
										}else{
										
										   echo anchor(site_url('pengaduantriwulan/rekaptriwulan1').'/'.$tgla, $baris->jumlah,  'class="link2-wrc" rel="pengaduantriwulan_box"'); 
										}
						//echo intval($baris->jumlah); 
						?></td>
						
<?php

}
?>
<?php
foreach($isi2 as $baris2){
?>

					
						<td><?php 
						
							if (intval($baris2->jumlah)==0){
										echo intval($baris2->jumlah);
										}else{
										
										   echo anchor(site_url('pengaduantriwulan/penyelesaian1').'/'.$tgla, intval($baris2->jumlah),  'class="link2-wrc" rel="pengaduantriwulan_box"'); 
										}
						//echo intval($baris2->jumlah); ?></td>

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
						<td><?php 
						if(intval($baris3->jumlah)==0){
										echo intval($baris3->jumlah);
										}else{
										
										   echo anchor(site_url('pengaduantriwulan/rekaptriwulan2').'/'.$tgla, $baris3->jumlah,  'class="link2-wrc" rel="pengaduantriwulan_box"'); 
										}
						//echo intval($baris3->jumlah); ?></td>
					
<?php

}
?>
<?php
foreach($isi4 as $baris4){
?>

					
						<td><?php 
							if (intval($baris4->jumlah)==0){
										echo intval($baris4->jumlah);
										}else{
										
										   echo anchor(site_url('pengaduantriwulan/penyelesaian2').'/'.$tgla, intval($baris4->jumlah),  'class="link2-wrc" rel="pengaduantriwulan_box"'); 
										}
						//echo intval($baris4->jumlah); ?></td>
						
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
						<td><?php 
						if(intval($baris5->jumlah)==0){
										echo intval($baris5->jumlah);
										}else{
										
										   echo anchor(site_url('pengaduantriwulan/rekaptriwulan3').'/'.$tgla, $baris5->jumlah,  'class="link2-wrc" rel="pengaduantriwulan_box"'); 
										}
						//echo intval($baris5->jumlah); ?></td>
					
<?php

}
?>
<?php
foreach($isi6 as $baris6){
?>

						<td><?php 
							if (intval($baris6->jumlah)==0){
										echo intval($baris6->jumlah);
										}else{
										
										   echo anchor(site_url('pengaduantriwulan/penyelesaian3').'/'.$tgla, intval($baris6->jumlah),  'class="link2-wrc" rel="pengaduantriwulan_box"'); 
										}
						//echo intval($baris6->jumlah); ?></td>
				
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
						<td><?php 
						if(intval($baris7->jumlah)==0){
										echo intval($baris7->jumlah);
										}else{
										
										   echo anchor(site_url('pengaduantriwulan/rekaptriwulan4').'/'.$tgla, $baris7->jumlah,  'class="link2-wrc" rel="pengaduantriwulan_box"'); 
										}
						//echo intval($baris7->jumlah); ?></td>
					
<?php

}
?>
<?php
foreach($isi8 as $baris8){
?>

						<td><?php 
							if (intval($baris8->jumlah)==0){
										echo intval($baris8->jumlah);
										}else{
										
										   echo anchor(site_url('pengaduantriwulan/penyelesaian4').'/'.$tgla, intval($baris8->jumlah),  'class="link2-wrc" rel="pengaduantriwulan_box"'); 
										}
						//echo intval($baris8->jumlah);  ?></td>
					
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
<td><b><?php echo  round($totpersen); echo ' %';?></b></td>
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
