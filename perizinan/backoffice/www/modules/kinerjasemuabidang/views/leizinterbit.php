<?php
		header("Content-Type: application/vnd.ms-word");
    header("Expires: 0");
       header("Cache-Control:  must-revalidate, post-check=0, pre-check=0");
       //header("Content-disposition: attachment; filename=Perngaduan Pertriwulan Tahun '.  $this->input->post('tgla').doc");
        header("Content-disposition: attachment; filename=Daftar Izin terbit Periode $tgla-$tglb.xls");
		
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
           <?php echo $page_name; echo ' '. $this->lib_date->mysql_to_human($tgla)." - ".$this->lib_date->mysql_to_human($tglb); ?>
			<?php
		
		
		?>
		
	
		
        </div>
<form name="form1" method="post">
   
     <fieldset>
         <legend style="color: #045000" align="center"><center>
             <?php
			 $q = "Select * from trsektor where id='$sektor_id' ";
                    $exe = mysql_query($q);
                   
                    while($row = mysql_fetch_assoc($exe)){
					if($row >0){
         $a=$row['n_sektor'];
		 }
		 }
			 echo 'Bidang : '; echo $a; 
			 echo br();
            echo 'Periode '. $this->lib_date->mysql_to_human($tgla)." - ".$this->lib_date->mysql_to_human($tglb);
             echo br(2);
			?></center>
          </legend>

	
	
     <table cellpadding="1" cellspacing="0" border="1" class="display" id="reportgrid">
        <thead>
		<tr class="title">
           <th rowspan="2"><font  size="12px" color="#1A1A1A"><b>No</b></font></th>
           <th rowspan="2"><font  size="12px" color="#1A1A1A"><b>No Pendaftaran</b></font></th>
           <th rowspan="2"><font  size="12px" color="#1A1A1A"><b>Nama Pemohon</b></font></th>
           <th rowspan="2"><font  size="12px" color="#1A1A1A"><b>Jenis Perizinan</b></font></th>
           <th rowspan="2"><font  size="12px" color="#1A1A1A"><b>Objek Izin</b></font></th>
           <th colspan="2"><font  size="12px" color="#1A1A1A"><b>Tanggal</b></font></th>
          
           
           <th rowspan="2"><font  size="12px" color="#1A1A1A"><b>Stastus</b></font></th>
		   <!--<th rowspan="2"><font  size="12px" color="#1A1A1A"><b>Jmlh Tidak Sesuai Durasi</b></font></th>
		   <th rowspan="2"><font  size="12px" color="#1A1A1A"><b>Realisasi Target</b></font></th>-->
		   <!--<th rowspan="2"><font  size="12px" color="#1A1A1A"><b>Persen Keterlambatan</b></font></th>-->
     </tr>
     <tr>
           <th><font  size="12px" color="#1A1A1A"><b>Terima Berkas</b></font></th>
           <!-- <th><font  size="12px" color="#1A1A1A"><b>Diambil</b></font></th>
           <th><font  size="12px" color="#1A1A1A"><b>Belum Diambil</b></font></th>-->
           <th><font  size="12px" color="#1A1A1A"><b>Selesai Proses</b></font></th>
           <!-- <th><font  size="12px" color="#1A1A1A"><b>Diambil</b></font></th>
           <th><font  size="12px" color="#1A1A1A"><b>Belum Diambil</b></font></th>
    </tr>-->
    </tr></thead>
<!---------------------------------------------------------------------------------------------------.-->
               <?php
			   //$bidangizin=$this->input->post('id');
                   $bidangizin=$sektor_id;
						$i = NULL;
                    $query_data = "
					select  a.a_izin,a.keterangan,g.n_pemohon,a.pendaftaran_id no,i.tgl_surat_edit,i.tgl_surat,e.n_perizinan jenis,a.d_terima_berkas terima,a.d_selesai_proses selesai,a.status_berkas status from tmpermohonan a
                                inner join tmpermohonan_trperizinan b on a.id = b.tmpermohonan_id
                                inner join tmbap_tmpermohonan c on a.id = c.tmpermohonan_id
                                inner join tmbap d on d.id = c.tmbap_id
				inner join trperizinan e on e.id = b.trperizinan_id
				inner join tmpemohon_tmpermohonan f on f.tmpermohonan_id = a.id
				inner join tmpemohon g on f.tmpemohon_id=g.id
				inner join tmpermohonan_tmsk h on a.id = h.tmpermohonan_id
inner join tmsk i on h.tmsk_id = i.id
                                LEFT JOIN tmpermohonan_trstspermohonan as t6 on a.id = t6.tmpermohonan_id
                                LEFT JOIN trstspermohonan as t7 on t7.id = t6.trstspermohonan_id
where d.c_penetapan = 1 and d.status_bap='1' and a.trsektor_id='$bidangizin' and a.d_terima_berkas between '$tgla' and '$tglb'" ;
                    $results = mysql_query($query_data);
                    while ($data = mysql_fetch_assoc(@$results)){
                        $i++;
                      
		 ?>
 
                    <tr>
                        <td align="center"><?php echo $i; ?></td>
                        <td><?php echo $data['no']; ?></td>
                        <td><?php echo $data['n_pemohon']; ?></td>
                        <td align="center"><?php echo $data['jenis']; ?></td>
                        
                       <td align="left"><?php if($data['keterangan'] == '')
						                        echo $data['a_izin'];
					                           else
					                             echo $data['a_izin'].' [ Ket : '.$data['keterangan'].' ]'; ?></td>
												 <td align="center"><?php echo $data['terima'];  ?></td>
                        <td align="center"><?php 
						if ($data['tgl_surat_edit']=='0000-00-00'){
						echo $data['tgl_surat'];
						}else{
						echo $data['tgl_surat_edit']; 
						}
						?></td>
                     
                       <td align="center"><?php echo $data['status']; ?></td>
						 <!--<td align="center"><?//php echo intval($k); ?></td>
                        <td align="center"><?php echo $data['x']; echo ' Hari'; ?></td>-->
						<!--<td align="center"><?//php echo round($ptr) ; echo ' %'; ?></td>-->
					
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
