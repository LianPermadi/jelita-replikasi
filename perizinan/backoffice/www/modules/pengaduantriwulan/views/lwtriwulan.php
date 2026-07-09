<?php
		header("Content-Type: application/vnd.ms-word");
       header("Expires: 0");
       header("Cache-Control:  must-revalidate, post-check=0, pre-check=0");
        //header("Content-disposition: attachment; filename=Perngaduan Pertriwulan Tahun '.  $this->input->post('tgla').doc");
        header("Content-disposition: attachment; filename=Pengaduan Periode $tgla .doc");
		
	?>
<script language="javascript" type="text/javascript">
    function popup_link(site, targetDiv){
        $.ajax({url: site,success: function(response){$(targetDiv).html(response);}, dataType: "html"});
    }

    $(document).ready(function() {
        oTable = $('#reportgrid').dataTable({
                "bJQueryUI": true,
                "bDestroy": true,
                "sPaginationType": "full_numbers"
        });

    } );
	</script>
<html>
<head>
<title>Pengaduan </title>
</head>

<body>
    <div id="content" style="width: 800px;">
    <div class="post">
        <div class="title" align="center">
				
				<table border="0">
			<tr  >
			<td align="center" >
			<?php 
			echo br();
			
			 $img_cetak = array(
                          'src' => base_url().'assets/images/icon/logo Jawa_Barat.png');
              echo img($img_cetak);
			?>
			</td ><td align="center">
			<font size="12px"><b>
			<?php
			
			echo 'BADAN PELAYANAN PERIZINAN TERPADU PROVINSI TASIKMALAYA';
			echo br();
			?>
			</b>
			<?php
			echo 'Jalan Phh Mustafa Nomor 22 - Telp. (022)7217744 Fax (022)7217755';
			echo br();
			echo 'TASIKMALAYA - TASIKMALAYA';
			?>
			</b></td></font></tr>
			
			<tr>
			<td width="30%"></td>
			<td align="center">
			<?php 
			
			echo '===================================================================';
			?>
			</td></tr>
			
			</table>
           
			
        </div>
<form name="form1" method="post">
   
     <fieldset>
         <legend style="color: #045000" align="center">
            <div align="center"> <font  size="12px"><?php
			 
			 echo br();
            echo 'Pengaduan Pertriwulan Tahun '. $tgla;
             echo br(2);
			?>
			</font>
			</div>
          </legend>

	
	
     <table cellpadding="1" cellspacing="0" border="1" class="display" id="reportgri" width="100%">
        <thead>
		
        <tr class="title">
           <th rowspan="1"><font  size="12px" color="#1A1A1A"><b>No</b></font></th>
           <th rowspan="1"><font  size="12px" color="#1A1A1A"><b>TRIWULAN</b></font></th>
           <th rowspan="1"><font  size="12px" color="#1A1A1A"><b>PENGADUAN</b></font></th>
           <th rowspan="1"><font  size="12px" color="#1A1A1A"><b>PENYELESAIAN</b></font></th>
		   <th rowspan="1"><font  size="12px" color="#1A1A1A"><b>% PENYELESAIAN</b></font></th>
     </tr></thead>
<!---------------------------------------------------------------------------------------------------.-->
               <?php
			   //$bidangizin=$this->input->post('id');
                  $thn = substr($tgla, 1,5);
					$i = NULL;
                    $query_data = "SELECT count(id) jumlah FROM tmpesan where YEAR(d_entry) = '$thn' and MONTH(d_entry) between'01' and '03' ";
					$results = mysql_query($query_data);
                    while ($data = mysql_fetch_assoc(@$results)){
                        $a=$data['jumlah'];
                      
		 ?>
 
                    <tr>
                        <td align="center"><font  size="12px"><?php echo '1'; ?></font></td>
                        <td align="center"><font  size="12px"><?php echo 'I'; ?></td>
                        <td align="center"><font  size="12px"><?php echo $data['jumlah'];  ?></font></td>
               
					
                <?php 
				
					}
					$sql1="SELECT count(id) jumlah FROM tmpesan where YEAR(d_entry) = '$thn' and MONTH(d_entry) between'01' and '03' and c_tindak_lanjut='Ya'";
					$results = mysql_query($sql1);
                    while ($datasql1 = mysql_fetch_assoc(@$results)){
					$a2=$datasql1['jumlah'];
					?>
					<td align="center"><font  size="12px"><?php echo $datasql1['jumlah'];  ?></font></td>
					<?php
					}
					if($a==0 or $a2==0){
					$persena=0;
					}else{
					$persena=$a2/$a*100;
					}
					?>
					<td align="center"><font  size="12px"><?php echo round($persena); echo ' %'; ?></font></td>
					</font>
                    </tr>
					<?php
					
					 $query_data2 = "SELECT count(id) jumlah FROM tmpesan where YEAR(d_entry) = '$thn' and MONTH(d_entry) between'04' and '06' ";
					$results = mysql_query($query_data2);
                    while ($data2 = mysql_fetch_assoc(@$results)){
                        $b=$data2['jumlah'];
                      
		 ?>
 
                    <tr>
                        <td align="center"><font  size="12px"><?php echo '2'; ?></font></td>
                        <td align="center"><font  size="12px"><?php echo 'II'; ?></td>
                        <td align="center"><font  size="12px"><?php echo $data2['jumlah'];  ?></font></td>
                    
                <?php 
				
					}
					$sql2="SELECT count(id) jumlah FROM tmpesan where YEAR(d_entry) = '$thn' and MONTH(d_entry) between'04' and '06' and c_tindak_lanjut='Ya'";
					$results = mysql_query($sql2);
                    while ($datasql2 = mysql_fetch_assoc(@$results)){
					$b2=$datasql2['jumlah'];
					?>
					<td align="center"><font  size="12px"><?php echo $datasql2['jumlah'];  ?></font></td>
					<?php
					}
					if($b==0 or $b2==0){
					$persenb=0;
					}else{
					$persenb=$b2/$b*100;
					}
					?>
					<td align="center"><font  size="12px"><?php echo round($persenb); echo ' %'; ?>
					</font></td>
					<?php
					 $query_data3 = "SELECT count(id) jumlah FROM tmpesan where YEAR(d_entry) = '$thn' and MONTH(d_entry) between'07' and '09' ";
					$results = mysql_query($query_data3);
                    while ($data3 = mysql_fetch_assoc(@$results)){
                        $c=$data3['jumlah'];
                      
		 ?>
 
                    <tr>
                        <td align="center"><font  size="12px"><?php echo '3'; ?></font></td>
                        <td align="center"><font  size="12px"><?php echo 'III'; ?></td>
                        <td align="center"><font  size="12px"><?php echo $data3['jumlah'];  ?></font></td>
					
                <?php 
				
					}
					$sql3="SELECT count(id) jumlah FROM tmpesan where YEAR(d_entry) = '$thn' and MONTH(d_entry) between'07' and '09' and c_tindak_lanjut='Ya'";
					$results = mysql_query($sql3);
                    while ($datasql3 = mysql_fetch_assoc(@$results)){
					$c2=$datasql3['jumlah'];
					?>
					<td align="center"><font  size="12px"><?php echo $datasql3['jumlah'];  ?></font></td>
					<?php
					}
					if($c==0 or $c2==0){
					$persenc=0;
					}else{
					$persenc=$c2/$c*100;
					}
					?>
					<td align="center"><font  size="12px"><?php echo round($persenc); echo ' %'; ?>
					</font></td>
					<?php
					$query_data4 = "SELECT count(id) jumlah FROM tmpesan where YEAR(d_entry) = '$thn' and MONTH(d_entry) between'10' and '12' ";
					$results = mysql_query($query_data4);
                    while ($data4 = mysql_fetch_assoc(@$results)){
                        
                      $d=$data4['jumlah'];
		 ?>
 
                    <tr>
                        <td align="center"><font  size="12px"><?php echo '4'; ?></font></td>
                        <td align="center"><font  size="12px"><?php echo 'IV'; ?></td>
                        <td align="center"><font  size="12px"><?php echo $data4['jumlah'];  ?></font></td>
                      
                <?php 
				
					}
					$sql4="SELECT count(id) jumlah FROM tmpesan where YEAR(d_entry) = '$thn' and MONTH(d_entry) between'10' and '12' and c_tindak_lanjut='Ya'";
					$results = mysql_query($sql4);
                    while ($datasql4 = mysql_fetch_assoc(@$results)){
					$d2=$datasql4['jumlah'];
					?>
					<td align="center"><font  size="12px"><?php echo $datasql4['jumlah'];  ?></font></td>
					<?php
					}
					if($d==0 or $d2==0){
					$persend=0;
					}else{
					$persend=$d2/$d*100;
					}
					?>
					<td align="center"><font  size="12px"><?php echo round($persend); echo ' %'; ?>
					</font></td>
				
					<tr>
					<td></td>
						<td align="center"><b><font  size="12px">TOTAL</b></font></td>
					    <td align="center"><b><font  size="12px"><?php echo $a+$b+$c+$d;?></b></font></td>
						 <td align="center"><b><font  size="12px"><?php echo $a2+$b2+$c2+$d2;?></b></font></td>
					<?php
					if($a+$b+$c+$d==0 or $a2+$b2+$c2+$d2==0){
					$totpersen=0;
					}else{
					$totpersen=(($a2+$b2+$c2+$d2)/($a+$b+$c+$d))*100;
					}
					?>
					 <td align="center"><b><font  size="12px"><?php echo round($totpersen); echo ' %'?></b></font></td>
					</tr>
					
</table>
         </fieldset>
    
</form>
<?php echo br();?>
        </div>
        </div>
</body>
</html>
