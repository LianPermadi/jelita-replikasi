<html>
<head>
<title>Realisasi Penerimaan</title>
</head>
<!--<body onLoad="window.print()">-->
<body>
    <div id="content">
        <div class="post">
            <div class="title">
                <h2><?php echo $page_name; ?></h2>
            </div>
            <form name="form1" method="post">

				<div class="entry">
                  

                            <fieldset>
                                <legend style="color: #045000" align="center">
                                    <?php
                                    echo 'Ketepatan Waktu Penyelesaian Perizinan ';echo br(2); echo 'Periode '. $this->lib_date->mysql_to_human($tgla)." - ".$this->lib_date->mysql_to_human($tglb);
//                                    echo 'Realisasi Penerimaan Tahun '.$list_tahun->d_tahun;
                                    ?>
                                </legend>
                              
								<table border='1'>
								<th>No</th>
								<th>Jenis Ijin</th>
								<th>Tanggal Terima</th>
								<th>Tanggal Surat</th>
								<th>Tanggal Surat Edit</th>
								<th>Target Hari</th>
								<th>Jumlah Libur</th>
								<th>Sektor ID</th>
								<th>Selisih Hari</th>
								<th>Realisasi Target</th>
								<th>Jumlah Sesuai</th>
								
								<th>Persen Kecepatan</th>
								<th>Tot Persen Kecepatan</th>
								<th>Jumlah Selesai</th>
								<th>persen Ketepatan</th>
								<th>id</th>
<?php
$i=1;
$jumlah=0;
$tt=0;
$totalrealisasi=0;
$ttperkec=0;
$ratatotalrealisasi=0;	
$ttsesuai=0;
$qbidang = "Select a.id,c.id idperizin from trsektor a
inner join  trperizinan_trsektor b on b.trsektor_id=a.id
inner join  trperizinan c on c.id=b.trperizinan_id

 ";
                    $exebidang = mysql_query($qbidang);
                   
                    while($rowbidang = mysql_fetch_assoc($exebidang)){
					if($rowbidang >0){
         $a=$rowbidang['id'];
		 $bidangizin=$a;
		 $idperizinan=$rowbidang['idperizin'];
		
		 }
		 
//echo $bidang;

$qizin = "select  a.pendaftaran_id no,e.n_perizinan jenis,b.trperizinan_id idizin,a.trsektor_id,a.d_terima_berkas terima,a.d_selesai_proses selesai,i.tgl_surat,i.tgl_surat_edit,e.v_hari durasi,a.a_izin, a.keterangan,
				   g.n_pemohon nama from tmpermohonan a
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
where d.c_penetapan = 1 and a.trsektor_id='$bidangizin' and e.id=$idperizinan and a.d_terima_berkas between '$tgla' and '$tglb' order by idizin asc";
                    $exeizin = mysql_query($qizin);
                   
                    while($rowizin = mysql_fetch_assoc($exeizin)){
					if($rowizin >0){
					$trsektorid=$rowizin['trsektor_id'];
					
					?>
					
					<tr>
					<td>
					<? echo $i++; ?>
					</td>
					<td>
					<?
					
						
						//echo $tt;
						//jenis ijin
         echo $rowizin['jenis'];echo br();
		 ?>
		 </td>
		 
		 <td>
		 <?php
		 
		 //------------------------------------------------------------------------tanggal terima
		 $tanggalterima=$rowizin['terima'];
		  echo $rowizin['terima'];
		 ?>
		 </td>
		 <td>
		 <?php
		 //------------------------------------------------------------------------tanggal surat
		 $surat=$rowizin['tgl_surat'];
		  echo $rowizin['tgl_surat'];
		 ?>
		 </td>
		 <td>
		 <?php
		 //--------------------------------------------------------------------------tanggal surat edit
		  $suratedit=$rowizin['tgl_surat_edit'];
		  echo $rowizin['tgl_surat_edit'];
		 ?>
		 </td>
		 <td>
		 <?php
		 //---------------------------------------------------------------------------- durasi
		 $waktu=$rowizin['durasi'];
		  echo $rowizin['durasi'];
		 ?>
		 </td>
		 
		 
		 <?
		 if ($suratedit=='0000-00-00'){
		 $tanggalselesai=$surat;
		 }else{
		  $tanggalselesai=$suratedit;
		 }
		  $qholiday="select count(date) libur from tmholiday where date between '$tanggalterima' and '$tanggalselesai'";
$exeholiday = mysql_query($qholiday);
                    while($rowholiday = mysql_fetch_assoc($exeholiday)){
				$holidayperizin = $rowholiday['libur'];
					//echo $holidayperizin;
					?>
					<td>
					<? 
					
					//--------------------------------------------------------hari libur
					echo $holidayperizin;  ?>
					</td>
					<td>
					
					<? 
					//-------------------------------------sektor id
					echo $trsektorid; ?>
					
					</td>
					<!-- realisasi target -->
					<td>
					<? 
					$date1 = new DateTime($tanggalselesai); 
					  $date2 = new DateTime($tanggalterima); 
					 
					$interval = $date2->diff($date1);

					$selisihhari = $interval->format('%R%a');
//-------------------------------------------------------------------selisih hari
$shari = substr($selisihhari, 1,5);
					 
					echo $shari;
					
					$realisasi = $shari - $holidayperizin;
					$totalrealisasi+=$realisasi;
					?>
					</td>
					<td>
					<? 
					//-----------------------------------------------------------------realisasi
					echo $realisasi;?>
					</td>
					
					<td>
					<? 
					//------------------------------------------------------------jumlahsesuai
					
					//jumlah selesai sesuai
					// echo $idperizinan; 
				if($realisasi <= $waktu ){
					$sesuai=$realisasi <= $waktu;
					//echo $sesuai;
					$totsesuai=count($sesuai);
					//$tot=count($realisasi);
					$ttsesuai +=$totsesuai;
					//echo $ttsesuai;
					}else{
					$sesuai=$realisasi > $waktu;
					}
					
					
					//jumlah selesai perizin
					$tot=count($realisasi);
					$tt +=$tot;
				
					?>
					
					</td>
					
					<td>
					
					<?php
//---------------------------------------------------persen kecepatan
$perkec=($waktu - $realisasi)/$waktu * 100;

echo round($perkec);echo ' %';		


$ratatotalrealisasi=$totalrealisasi/$tt;
		
					?>
					</td>
					
					<?
					
						$ttperkec +=$perkec;
				//$jumperkec[]=$ttperkec;
					//	$aperkec=array_sum($jumperkec);
						
						//$total_perkec = number_format($aperkec);
						//echo $total_perkec;
									
						
					
								
					?>
					<td></td>
					<td></td>
					<td></td>
					<td>
		 <?php 
		   echo $rowizin['idizin'];echo br();
		 ?>
		 </td>
					</tr>
					
					
					<?
					

					
					
		 }
		
		 }
		
}
//------------------------------------------------jumlah total Sesuai
		 ?>
		 
				<tr>
				
				
				
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td><?php echo round($totalrealisasi); ?></td>
				<td><?php echo round($ratatotalrealisasi);	?></td>
				<td><?php echo round($ttsesuai);	?></td>
				
				<td><?php echo round($ttperkec); echo ' %'; 
					
					
					?>
					</td>
					
					<td>
					<?php
$persenkecepatan = 0;
if($ttperkec==0 or $tt==0){
$persenkecepatan=0;
}else{
$persenkecepatan =$ttperkec/$tt;

}
//echo round($persenkecepatan);echo ' %';

					?>
					</td>
					<td><?php echo $tt; 
					
					
					?>
					</td>
					<td>
					<?
					//$totalselesaiperbidang+=$tt;
					//echo $totalselesaiperbidang;
					//$persenketepatan = $ttsesuai/
					?>
					
					
					</td>
			
				<td></td>
					</tr>
					<? 
		 
		$ttperkec=0;
$tt=0;
$ttsesuai=0;
$totalrealisasi=0;
$ratatotalrealisasi=0;	
$totalselesaiperbidang=0;
		 }
		


	?>	
	
</table>
                            </fieldset>

		              
                </div>

            </form>
        </div>
    </div>
</body>
</html>
