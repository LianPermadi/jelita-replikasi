<?php
	header("Content-Type: application/vnd.ms-word");
	header("Expires: 0");
    header("Cache-Control:  must-revalidate, post-check=0, pre-check=0");
	header("Content-disposition: attachment; filename=Daftar Rekap Pendaftaran Per Bidang $tgla-$tglb.xls");
		
	?>

<html>
<head>
<title>Daftar Rekap Pendaftaran Per Bidang</title>
</head>

<body>
    <div id="content"style="width: 950px;">
    <div class="post">
        <div class="title">
		

            <center>
			
			<?php

		$bidangizin=$sektor_id;
		$q = "Select * from trsektor where id='$bidangizin' ";
                    $exe = mysql_query($q);
                   
                    while($row = mysql_fetch_assoc($exe)){
					if($row >0){
         $a=$row['n_sektor'];
		 }
		?>
		<div align="center"><font size="12px">
		<?php echo br();?>
		</div>
		<div align="center"><center><font size="12px"><b>
		<?php 
		echo br();
		 $img_cetak = array(
                          'src' => base_url().'assets/images/icon/logo Jawa_Barat.png');
              echo img($img_cetak);
			echo 'BADAN PELAYANAN PERIZINAN TERPADU PROVINSI TASIKMALAYA';echo br();
			?></b>
			
		<?php 
			echo 'Jalan Phh Mustafa Nomor 22 - Telp. (022)7217744 Fax (022)7217755';
			?>
		</div>
		<div align="center">
		<?php 
			echo br();
			echo '=======================================================================';
			?>
		</div>
		<div align="center">
		<?php
			echo br();
			//echo $page_name; ?>
		</div>
		</div>
		<?php
		}
		?>
        
         
    <div class="post">
        <div class="title" align="center">
           <font size="12px" color="#1A1A1A"><?php //echo $page_name; ?>
			<?php
		
		$bidangizin=$sektor_id;
		$q = "Select * from trsektor where id='$bidangizin' ";
                    $exe = mysql_query($q);
                   
                    while($row = mysql_fetch_assoc($exe)){
					if($row >0){
         $a=$row['n_sektor'];
		 }
		?>
		
		
		<div align="center"><center><?php echo 'Bidang :  '; echo $a;?></center></div>
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
			</center>
          </legend>
 
	
	
     <table width="100%" cellpadding="1" align="center" cellspacing="0" border="1" class="display" id="reportgrid">
        <thead>
		<tr class="title">
           <th rowspan="1"><font size="12px" color="#1A1A1A"><b>No</b></font></th>
           <th rowspan="1"><font size="12px" color="#1A1A1A"><b>No Pendaftaran</b></font></th>
           <th rowspan="1"><font size="12px" color="#1A1A1A"><b>Nama Pemohon</b></font></th>
           <th rowspan="1"><font size="12px" color="#1A1A1A"><b>Tanggal Daftar</b></font></th>
          
           
           <th rowspan="1"><font size="12px" color="#1A1A1A"><b>Stastus</b></font></th>
    </thead>  </tr>
<!---------------------------------------------------------------------------------------------------.-->
               <?php
			   //$bidangizin=$this->input->post('id');
                   //$idsektor=$sektor_id;
					$i = NULL;
                    $query_data = "
					select  a.a_izin,a.keterangan,g.n_pemohon,a.pendaftaran_id no,e.n_perizinan jenis,a.d_terima_berkas terima,a.d_selesai_proses selesai,a.status_berkas status from tmpermohonan a
                                inner join tmpermohonan_trperizinan b on a.id = b.tmpermohonan_id
								inner join trperizinan_trsektor c on b.trperizinan_id=c.trperizinan_id
								inner join trperizinan e on e.id = b.trperizinan_id
								inner join tmpemohon_tmpermohonan f on f.tmpermohonan_id = a.id
								inner join tmpemohon g on f.tmpemohon_id=g.id
                                LEFT JOIN tmpermohonan_trstspermohonan as t6 on a.id = t6.tmpermohonan_id
                                LEFT JOIN trstspermohonan as t7 on t7.id = t6.trstspermohonan_id
					where c.trsektor_id='$bidangizin' and a.d_terima_berkas between '$tgla' and '$tglb'" ;
                    $results = mysql_query($query_data);
                    while ($data = mysql_fetch_assoc(@$results)){
                        $i++;
                      
		 ?>
 
                    <tr>
                        <td align="center"><font size="12px" color="#1A1A1A"><?php echo $i; ?></td>
                        <td><font size="12px" color="#1A1A1A"><?php echo $data['no']; ?></td>
                        <td><font size="12px" color="#1A1A1A"><?php echo $data['n_pemohon']; ?></td>
                        <td><font size="12px" color="#1A1A1A"><?php echo $data['terima']; ?></td>
                       <td align="center"><font size="12px" color="#1A1A1A"><?php echo $data['status']; ?></td>
                    </tr>
					
                <?php 
				
					}
					?>
</table>
         </fieldset>
    
</form>
<?php echo br();?>
        </div>
        </div>
</body>
</html>
