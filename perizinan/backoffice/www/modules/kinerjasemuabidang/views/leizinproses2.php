<?php
		header("Content-Type: application/vnd.ms-word");
    header("Expires: 0");
       header("Cache-Control:  must-revalidate, post-check=0, pre-check=0");
       //header("Content-disposition: attachment; filename=Perngaduan Pertriwulan Tahun '.  $this->input->post('tgla').doc");
        header("Content-disposition: attachment; filename=Daftar Izin Proses Periode $tgla-$tglb.xls");
		
	?>
<html>
<head>
<title>Realisasi Penerimaan</title>
</head>

<body>
    <div id="content">
         <div class="title" align="center">
				<div>
			<?php 
			echo br();
			
			 $img_cetak = array(
                          'src' => base_url().'assets/images/icon/logo Jawa_Barat.png');
              echo img($img_cetak);
			?>
			
			<font size="12px"><b>
			<?php
			
			echo 'BADAN PELAYANAN PERIZINAN TERPADU PROVINSI TASIKMALAYA';
			echo br();
			?>
			</b>
			</div>
			<div>
			<?php
			echo 'Jalan Phh Mustafa Nomor 22 - Telp. (022)7217744 Fax (022)7217755';
			echo br();
			echo 'TASIKMALAYA - TASIKMALAYA';
			?>
			</b></td></font>
			</div><div>
			<?php 
			
			echo '=======================================================================';
			echo br();
			?>
			<div><font size="12px">
           <?php echo $page_name;?>
			<?php
		
		
			
	
		
        
		
		$bidangizin=$sektor_id;
		$q = "Select * from trsektor where id='$bidangizin' ";
                    $exe = mysql_query($q);
                   
                    while($row = mysql_fetch_assoc($exe)){
					if($row >0){
         $a=$row['n_sektor'];
		 }
		?>
		
		
		<div align="center"><font  size="12px"><?php echo 'Bidang :  '; echo $a;?></div>
		<?php
		}
		?>
        </div>
<form name="form1" method="post">
   
     <fieldset>
         <legend style="color: #045000" align="center"><center>
             <?php
			 echo br();
            echo 'Periode '. $this->lib_date->mysql_to_human($tgla)." - ".$this->lib_date->mysql_to_human($tglb);
             echo br(2);
			?>
          </legend></center>
 
	
	
    <table cellpadding="1" cellspacing="0" border="1" class="display" id="reportgrid" width="100%">
        <thead>
		<tr class="title">
           <th rowspan="1"><font  size="2" color="#1A1A1A"><b>No</b></font></th>
           <th rowspan="1"><font  size="2" color="#1A1A1A"><b>Status Permohonan</b></font></th>
           <th rowspan="1"><font  size="2" color="#1A1A1A"><b>Jumlah</b></font></th>
          
    </tr></thead>
<!---------------------------------------------------------------------------------------------------.-->
               <?php
			    $query = "
					select  count(a.id) jumlah from tmpermohonan a
                                inner join tmpermohonan_trperizinan b on a.id = b.tmpermohonan_id
                                
				inner join trperizinan e on e.id = b.trperizinan_id
                                LEFT JOIN tmpermohonan_trstspermohonan as t6 on a.id = t6.tmpermohonan_id
                                LEFT JOIN trstspermohonan as t7 on t7.id = t6.trstspermohonan_id
where t7.id<>1 and t7.id <> 13 and t7.id <> 14 and t7.id <> 15 and t7.id<>16 and t7.id<>17 
and a.trsektor_id='$bidangizin' and a.d_terima_berkas between '$tgla' and '$tglb' " ;
                    $query_data="$query and t7.id=2  ";
                    $query_data2="$query and t7.id=3  ";
                    $query_data3="$query and t7.id=4  ";
                    $query_data4="$query and t7.id=8  ";
					
					$results = mysql_query($query_data);
                    while ($data = mysql_fetch_assoc(@$results)){
					?>
					<tr>
					<td align="center">1</td>
					<td ><?php echo 'Menerima dan Memeriksa Berkas' ?></td>
					<td align="center" >
					<?
					$jumlah=$data['jumlah'];
					echo $data['jumlah'];
					?>
					</td>
					</tr>
					<?php
					}
					$results2 = mysql_query($query_data2);
                    while ($data2 = mysql_fetch_assoc(@$results2)){
					?>
					<tr>
					<td align="center">2</td>
					<td ><?php echo 'Entri Data' ?></td>
					<td align="center" >
					<?
					$jumlah2=$data2['jumlah'];
					echo $data2['jumlah'];
					?>
					</td>
					</tr>
					<?php
					}
					$results3 = mysql_query($query_data3);
                    while ($data3 = mysql_fetch_assoc(@$results3)){
					?>
					<tr>
					<td align="center">3</td>
					<td ><?php echo 'Pertimbangan Teknis' ?></td>
					<td align="center" >
					<?
					$jumlah3=$data3['jumlah'];
					echo $data3['jumlah'];
					?>
					</td>
					</tr>
					<?php
					}
					$results4 = mysql_query($query_data4);
                    while ($data4 = mysql_fetch_assoc(@$results4)){
					?>
					<tr>
					<td align="center">4</td>
					<td ><?php echo 'Penyusunan / Pencetakan Naskah Perizinan' ?></td>
					<td align="center" >
					<?
					$jumlah4=$data4['jumlah'];
					echo $data4['jumlah'];
					?>
					</td>
					</tr>
					<?php
					}
					?>
					<tr>
					<td align="center"></td>
					<td align="center"><b><?php echo 'TOTAL' ?></td>
					<td align="center" ><b>
					<?
					$total=$jumlah+$jumlah2+$jumlah3+$jumlah4;
					echo $total;
					?>
					</td>
					</tr>
					<?
			  
					?>
</table>
         </fieldset>
    
</form>
<?php echo br();?>
        </div>
        </div>
</body>
</html>
