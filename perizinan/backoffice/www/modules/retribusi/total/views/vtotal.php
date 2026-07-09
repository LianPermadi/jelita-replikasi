
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
									echo $page_name;
                                    echo ' tahun ';echo $tgla;
//                                    echo 'Realisasi Penerimaan Tahun '.$list_tahun->d_tahun;
                                    ?>
                                </legend>
                                <table align="left" >
                                    <tr>
                                        <td align="center" >
                                            <?php
                                            $Back_data = array(
                                                'src' => base_url().'assets/images/icon/back_alt.png',
                                                'alt' => 'Lihat di HTML to Openoffice',
                                                'title' => 'Kembali',
                                                'onclick' => 'parent.location=\''. site_url('total/index'). '\''
                                            );
                                            
                                            echo img($Back_data);
                                            $word = array(
                                                'src' => base_url().'assets/images/icon/word.png',
                                                'alt' => 'Selesai',
                                                'title' => 'Cetak ke word',
                                               'onclick' => 'parent.location=\''. site_url('total/lwvtotal').'/'.$tgla.'/'.$tgla.'/'.$tgla.'\''
                                            );
                                            echo img($word);

 						
                                            $excel = array(
                                                'src' => base_url().'assets/images/icon/excel.png',
                                                'alt' => 'Selesai',
                                                'title' => 'Cetak ke excel',
                                               'onclick' => 'parent.location=\''. site_url('total/levtotal').'/'.$tgla.'/'.$tgla.'/'.$tgla.'\''
                                            );
                                            echo img($excel);                                            ?>
                                        </td>
                                    </tr>
                                </table>



								<table align="center" border="1" class="display" cellpadding="1" cellspacing="0" id="roygridx">
                                    <thead><tr class="title">
                                        <th align="center" rowspan="2" width="5%"><font  size="2" color="#1A1A1A"><b>No</b></font></th>
                                        <th align="center" rowspan="2" width="25%"><font  size="2" color="#1A1A1A"><b>Parameter Penilaian</b></font></th>
										 <th align="center" colspan="12" width="60%"><font  size="2" color="#1A1A1A"><b>Bulan</b></font></th>
										 <th align="center" rowspan="2" width="10%"><font  size="2" color="#1A1A1A"><b>Tahun <?php echo br(); echo $tgla; ?></b></font></th>
										
                                    </tr>
									<tr class="title">
									<th width="5%"><font  size="2" color="#1A1A1A"><b> 01 </th>
									<th width="5%"><font  size="2" color="#1A1A1A"><b> 02 </th>
									<th width="5%"><font  size="2" color="#1A1A1A"><b> 03 </th>
									<th width="5%"><font  size="2" color="#1A1A1A"><b> 04 </th>
									<th width="5%"><font  size="2" color="#1A1A1A"><b> 05 </th>
									<th width="5%"><font  size="2" color="#1A1A1A"><b> 06 </th>
									<th width="5%"><font  size="2" color="#1A1A1A"><b> 07 </th>
									<th width="5%"><font  size="2" color="#1A1A1A"><b> 08 </th>
									<th width="5%"><font  size="2" color="#1A1A1A"><b> 09 </th>
									<th width="5%"><font  size="2" color="#1A1A1A"><b> 10 </th>
									<th width="5%"><font  size="2" color="#1A1A1A"><b> 11 </th>
									<th width="5%"><font  size="2" color="#1A1A1A"><b> 12 </th>
									</tr>
									</thead>
									<?php 
			//-----------------------------------------------------------------------awal jumlah permohonan	
									$sqlpermohonan="SELECT count(b.id) jumlah FROM tmpermohonan a
													inner join tmpermohonan_trstspermohonan b on a.id=b.tmpermohonan_id
													inner join trstspermohonan c on c.id=b.trstspermohonan_id
											where c.id<>1 and a.trsektor_id<>0 and YEAR(a.d_terima_berkas) = '$tgla' and MONTH(a.d_terima_berkas) =";	
											
									$sqlpermohonan1="$sqlpermohonan '01'";
									$sqlpermohonan2="$sqlpermohonan '02'";
									$sqlpermohonan3="$sqlpermohonan '03'";
									$sqlpermohonan4="$sqlpermohonan '04'";
									$sqlpermohonan5="$sqlpermohonan '05'";
									$sqlpermohonan6="$sqlpermohonan '06'";
									$sqlpermohonan7="$sqlpermohonan '07'";
									$sqlpermohonan8="$sqlpermohonan '08'";
									$sqlpermohonan9="$sqlpermohonan '09'";
									$sqlpermohonan10="$sqlpermohonan '10'";
									$sqlpermohonan11="$sqlpermohonan '11'";
									$sqlpermohonan12="$sqlpermohonan '12'";
									
									$hasilsqlpermohonan1 = mysql_query($sqlpermohonan1);
									while ($datapermohonan1 = mysql_fetch_assoc(@$hasilsqlpermohonan1)){
									$permohonan1 = $datapermohonan1['jumlah'];
									}
									$hasilsqlpermohonan2 = mysql_query($sqlpermohonan2);
									while ($datapermohonan2 = mysql_fetch_assoc(@$hasilsqlpermohonan2)){
									$permohonan2 = $datapermohonan2['jumlah'];
									}
									$hasilsqlpermohonan3 = mysql_query($sqlpermohonan3);
									while ($datapermohonan3 = mysql_fetch_assoc(@$hasilsqlpermohonan3)){
									$permohonan3 = $datapermohonan3['jumlah'];
									}
									$hasilsqlpermohonan4 = mysql_query($sqlpermohonan4);
									while ($datapermohonan4 = mysql_fetch_assoc(@$hasilsqlpermohonan4)){
									$permohonan4 = $datapermohonan4['jumlah'];
									}
									$hasilsqlpermohonan5 = mysql_query($sqlpermohonan5);
									while ($datapermohonan5 = mysql_fetch_assoc(@$hasilsqlpermohonan5)){
									$permohonan5 = $datapermohonan5['jumlah'];
									}
									$hasilsqlpermohonan6 = mysql_query($sqlpermohonan6);
									while ($datapermohonan6 = mysql_fetch_assoc(@$hasilsqlpermohonan6)){
									$permohonan6 = $datapermohonan6['jumlah'];
									}
									$hasilsqlpermohonan7 = mysql_query($sqlpermohonan7);
									while ($datapermohonan7 = mysql_fetch_assoc(@$hasilsqlpermohonan7)){
									$permohonan7 = $datapermohonan7['jumlah'];
									}
									$hasilsqlpermohonan8 = mysql_query($sqlpermohonan8);
									while ($datapermohonan8 = mysql_fetch_assoc(@$hasilsqlpermohonan8)){
									$permohonan8 = $datapermohonan8['jumlah'];
									}
									$hasilsqlpermohonan9 = mysql_query($sqlpermohonan9);
									while ($datapermohonan9 = mysql_fetch_assoc(@$hasilsqlpermohonan9)){
									$permohonan9 = $datapermohonan9['jumlah'];
									}
									$hasilsqlpermohonan10 = mysql_query($sqlpermohonan10);
									while ($datapermohonan10 = mysql_fetch_assoc(@$hasilsqlpermohonan10)){
									$permohonan10 = $datapermohonan10['jumlah'];
									}
									$hasilsqlpermohonan11 = mysql_query($sqlpermohonan11);
									while ($datapermohonan11 = mysql_fetch_assoc(@$hasilsqlpermohonan11)){
									$permohonan11 = $datapermohonan11['jumlah'];
									}
									$hasilsqlpermohonan12 = mysql_query($sqlpermohonan12);
									while ($datapermohonan12 = mysql_fetch_assoc(@$hasilsqlpermohonan12)){
									$permohonan12 = $datapermohonan12['jumlah'];
									}
									$totalpermohonan=$permohonan1+$permohonan2+$permohonan3+$permohonan4+$permohonan5
									+$permohonan6+$permohonan7+$permohonan8+$permohonan9+$permohonan10+$permohonan11+$permohonan12;
									
									?>
                                    <tr>
									<td align="center">1</td>
									<td align="left">JUMLAH PERMOHONAN</td>
									<td align="center"><?php echo $permohonan1 ;?></td>
									<td align="center"><?php echo $permohonan2 ;?></td>
									<td align="center"><?php echo $permohonan3 ;?></td>
									<td align="center"><?php echo $permohonan4 ;?></td>
									<td align="center"><?php echo $permohonan5 ;?></td>
									<td align="center"><?php echo $permohonan6 ;?></td>
									<td align="center"><?php echo $permohonan7 ;?></td>
									<td align="center"><?php echo $permohonan8 ;?></td>
									<td align="center"><?php echo $permohonan9 ;?></td>
									<td align="center"><?php echo $permohonan10 ;?></td>
									<td align="center"><?php echo $permohonan11 ;?></td>
									<td align="center"><?php echo $permohonan12 ;?></td>
									<td align="center"><?php echo $totalpermohonan ;?></td>
									
									</tr>
			<?php 
			//------------------------------------------------------------akhir jumlah permohonan
			//------------------------------------------------------------awal jumlah selesai
			
			
			$sqlselesai="select  count(a.id) jumlah from tmpermohonan a
                                inner join tmpermohonan_trperizinan b on a.id = b.tmpermohonan_id
                                inner join tmbap_tmpermohonan c on a.id = c.tmpermohonan_id
                                inner join tmbap d on d.id = c.tmbap_id
								inner join trperizinan e on e.id = b.trperizinan_id
								inner join tmpermohonan_tmsk h on a.id = h.tmpermohonan_id
								inner join tmsk i on h.tmsk_id = i.id
                                LEFT JOIN tmpermohonan_trstspermohonan as t6 on a.id = t6.tmpermohonan_id
                                LEFT JOIN trstspermohonan as t7 on t7.id = t6.trstspermohonan_id
                                where  d.c_penetapan = 1
                                and t7.id <> 1 

                                and year(a.d_terima_berkas)='$tgla' and month(a.d_terima_berkas)=";
								
								$sqlselesai1="$sqlselesai '01'";
								$sqlselesai2="$sqlselesai '02'";
								$sqlselesai3="$sqlselesai '03'";
								$sqlselesai4="$sqlselesai '04'";
								$sqlselesai5="$sqlselesai '05'";
								$sqlselesai6="$sqlselesai '06'";
								$sqlselesai7="$sqlselesai '07'";
								$sqlselesai8="$sqlselesai '08'";
								$sqlselesai9="$sqlselesai '09'";
								$sqlselesai10="$sqlselesai '010'";
								$sqlselesai11="$sqlselesai '011'";
								$sqlselesai12="$sqlselesai '012'";
								
								$hasilsqlselesai1 = mysql_query($sqlselesai1);
								while ($dataselesai1 = mysql_fetch_assoc(@$hasilsqlselesai1)){
								$selesai1 = $dataselesai1['jumlah'];
								}
								$hasilsqlselesai2 = mysql_query($sqlselesai2);
									while ($dataselesai2 = mysql_fetch_assoc(@$hasilsqlselesai2)){
									$selesai2 = $dataselesai2['jumlah'];
									}
									$hasilsqlselesai3 = mysql_query($sqlselesai3);
									while ($dataselesai3 = mysql_fetch_assoc(@$hasilsqlselesai3)){
									$selesai3 = $dataselesai3['jumlah'];
									}
									$hasilsqlselesai4 = mysql_query($sqlselesai4);
									while ($dataselesai4 = mysql_fetch_assoc(@$hasilsqlselesai4)){
									$selesai4 = $dataselesai4['jumlah'];
									}
									$hasilsqlselesai5 = mysql_query($sqlselesai5);
									while ($dataselesai5 = mysql_fetch_assoc(@$hasilsqlselesai5)){
									$selesai5 = $dataselesai5['jumlah'];
									}
									$hasilsqlselesai6 = mysql_query($sqlselesai6);
									while ($dataselesai6 = mysql_fetch_assoc(@$hasilsqlselesai6)){
									$selesai6 = $dataselesai6['jumlah'];
									}
									$hasilsqlselesai7 = mysql_query($sqlselesai7);
									while ($dataselesai7 = mysql_fetch_assoc(@$hasilsqlselesai7)){
									$selesai7 = $dataselesai7['jumlah'];
									}
									$hasilsqlselesai8 = mysql_query($sqlselesai8);
									while ($dataselesai8 = mysql_fetch_assoc(@$hasilsqlselesai8)){
									$selesai8 = $dataselesai8['jumlah'];
									}
									$hasilsqlselesai9 = mysql_query($sqlselesai9);
									while ($dataselesai9 = mysql_fetch_assoc(@$hasilsqlselesai9)){
									$selesai9 = $dataselesai9['jumlah'];
									}
									$hasilsqlselesai10 = mysql_query($sqlselesai10);
									while ($dataselesai10 = mysql_fetch_assoc(@$hasilsqlselesai10)){
									$selesai10 = $dataselesai10['jumlah'];
									}
									$hasilsqlselesai11 = mysql_query($sqlselesai11);
									while ($dataselesai11 = mysql_fetch_assoc(@$hasilsqlselesai11)){
									$selesai11 = $dataselesai11['jumlah'];
									}
									$hasilsqlselesai12 = mysql_query($sqlselesai12);
									while ($dataselesai12 = mysql_fetch_assoc(@$hasilsqlselesai12)){
									$selesai12 = $dataselesai12['jumlah'];
									}
									
									$totalselesai=$selesai1+$selesai2+$selesai3+$selesai4+$selesai5+$selesai6+
												  $selesai7+$selesai8+$selesai9+$selesai10+$selesai11+$selesai12;
									
			?>
									    <tr>
									<td align="center">2</td>
									<td align="left">JUMLAH SELESAI</td>
									<td align="center"><?php echo $selesai1; ?></td>
									<td align="center"><?php echo $selesai2; ?></td>
									<td align="center"><?php echo $selesai3; ?></td>
									<td align="center"><?php echo $selesai4; ?></td>
									<td align="center"><?php echo $selesai5; ?></td>
									<td align="center"><?php echo $selesai6; ?></td>
									<td align="center"><?php echo $selesai7; ?></td>
									<td align="center"><?php echo $selesai8; ?></td>
									<td align="center"><?php echo $selesai9; ?></td>
									<td align="center"><?php echo $selesai10; ?></td>
									<td align="center"><?php echo $selesai11; ?></td>
									<td align="center"><?php echo $selesai12; ?></td>
									<td align="center"><?php echo $totalselesai; ?></td>
									
									</tr>
			<?php
			//-------------------------------------------------------------akhir jumlah selesai
			//------------------------------------------------------------- awal selesai sesuai durasi
			$ttt1=0;
			$ttt2=0;
			$ttt3=0;
			$ttt4=0;
			$ttt5=0;
			$ttt6=0;
			$ttt7=0;
			$ttt8=0;
			$ttt9=0;
			$ttt10=0;
			$ttt11=0;
			$ttt12=0;
			
			$totalsesuai1=0;
			$totalsesuai2=0;
			$totalsesuai3=0;
			$totalsesuai4=0;
			$totalsesuai5=0;
			$totalsesuai6=0;
			$totalsesuai7=0;
			$totalsesuai8=0;
			$totalsesuai9=0;
			$totalsesuai10=0;
			$totalsesuai11=0;
			$totalsesuai12=0;
			
			
			$qizin = "select  a.pendaftaran_id no,e.n_perizinan jenis,a.trsektor_id,a.d_terima_berkas terima,a.d_selesai_proses selesai,i.tgl_surat,i.tgl_surat_edit,e.v_hari durasi,a.a_izin, a.keterangan,
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
where d.c_penetapan = 1 and year(a.d_terima_berkas)='$tgla'";

					$sqlsesuai1="$qizin  and month(a.d_terima_berkas)='01'";
					$sqlsesuai2="$qizin  and month(a.d_terima_berkas)='02'";
					$sqlsesuai3="$qizin  and month(a.d_terima_berkas)='03'";
					$sqlsesuai4="$qizin  and month(a.d_terima_berkas)='04'";
					$sqlsesuai5="$qizin  and month(a.d_terima_berkas)='05'";
					$sqlsesuai6="$qizin  and month(a.d_terima_berkas)='06'";
					$sqlsesuai7="$qizin  and month(a.d_terima_berkas)='07'";
					$sqlsesuai8="$qizin  and month(a.d_terima_berkas)='08'";
					$sqlsesuai9="$qizin  and month(a.d_terima_berkas)='09'";
					$sqlsesuai10="$qizin  and month(a.d_terima_berkas)='10'";
					$sqlsesuai11="$qizin  and month(a.d_terima_berkas)='11'";
					$sqlsesuai12="$qizin  and month(a.d_terima_berkas)='12'";
					
					//------------------awal bulan1
                    $exeizin1 = mysql_query($sqlsesuai1);
                   
                    while($rowizin1 = mysql_fetch_assoc($exeizin1)){
					if($rowizin1 >0){
					//$trsektorid1=$rowizin1['trsektor_id'];
					$tanggalterima1=$rowizin1['terima'];
					$surat1=$rowizin1['tgl_surat'];
					$suratedit1=$rowizin1['tgl_surat_edit'];
					$waktu1=$rowizin1['durasi'];
					?>
			
		 <?
		 if ($suratedit1=='0000-00-00'){
		 $tanggalselesai1=$surat1;
		 }else{
		  $tanggalselesai1=$suratedit1;
		 }
		 $qholiday1="select count(date) libur from tmholiday where date between '$tanggalterima1' and '$tanggalselesai1'";
			$exeholiday1 = mysql_query($qholiday1);
                    while($rowholiday1 = mysql_fetch_assoc($exeholiday1)){
				$holidayperizin1 = $rowholiday1['libur'];
				$date1 = new DateTime($tanggalselesai1); 
					  $date2 = new DateTime($tanggalterima1); 
					 
					$interval = $date2->diff($date1);

					$selisihhari1 = $interval->format('%R%a');

$shari1 = substr($selisihhari1, 1,5);
					 
					
					$realisasi1 = $shari1 - $holidayperizin1;
					if($realisasi1 <= $waktu1 ){
					$sesuai1 = $realisasi1 <= $waktu1;
					//echo $sesuai1;
					$tot1=count($sesuai1);
					$tt1=0;
					$tt1 +=$tot1;
					$ttt1+=$tt1;
					$totalsesuai1=$ttt1;
				
					}else{
					$sesuai1 = $realisasi1 > $waktu1;
					
					}
				
		 }
		
		 }
		
}

				

//-----------------------------------akhir bulan 1
//------------------awal bulan2
                    $exeizin2 = mysql_query($sqlsesuai2);
                   
                    while($rowizin2 = mysql_fetch_assoc($exeizin2)){
					if($rowizin2 >0){
					//$trsektorid2=$rowizin2['trsektor_id'];
					$tanggalterima2=$rowizin2['terima'];
					$surat2=$rowizin2['tgl_surat'];
					$suratedit2=$rowizin2['tgl_surat_edit'];
					$waktu2=$rowizin2['durasi'];
					?>
			
		 <?
		 if ($suratedit2=='0000-00-00'){
		 $tanggalselesai2=$surat2;
		 }else{
		  $tanggalselesai2=$suratedit2;
		 }
		 $qholiday2="select count(date) libur from tmholiday where date between '$tanggalterima2' and '$tanggalselesai2'";
			$exeholiday2 = mysql_query($qholiday2);
                    while($rowholiday2 = mysql_fetch_assoc($exeholiday2)){
				$holidayperizin2 = $rowholiday2['libur'];
				$date1 = new DateTime($tanggalselesai2); 
					  $date2 = new DateTime($tanggalterima2); 
					 
					$interval = $date2->diff($date1);

					$selisihhari2 = $interval->format('%R%a');

$shari2 = substr($selisihhari2, 1,5);
					 
					
					$realisasi2 = $shari2 - $holidayperizin2;
					if($realisasi2 <= $waktu2 ){
					$sesuai2 = $realisasi2 <= $waktu2;
					//echo $sesuai2;
					$tot2=count($sesuai2);
					$tt2=0;
					$tt2 +=$tot2;
					$ttt2+=$tt2;
					$totalsesuai2=$ttt2;
				
					}else{
					
					$sesuai2 = $realisasi2 > $waktu2;
					
					}
				
		 }
		
		 }
		
}

				

//-----------------------------------akhir bulan 2

					
//------------------awal bulan3
                    $exeizin3 = mysql_query($sqlsesuai3);
                   
                    while($rowizin3 = mysql_fetch_assoc($exeizin3)){
					if($rowizin3 >0){
					//$trsektorid3=$rowizin3['trsektor_id'];
					$tanggalterima3=$rowizin3['terima'];
					$surat3=$rowizin3['tgl_surat'];
					$suratedit3=$rowizin3['tgl_surat_edit'];
					$waktu3=$rowizin3['durasi'];
					?>
			
		 <?
		 if ($suratedit3=='0000-00-00'){
		 $tanggalselesai3=$surat3;
		 }else{
		  $tanggalselesai3=$suratedit3;
		 }
		 $qholiday3="select count(date) libur from tmholiday where date between '$tanggalterima3' and '$tanggalselesai3'";
			$exeholiday3 = mysql_query($qholiday3);
                    while($rowholiday3 = mysql_fetch_assoc($exeholiday3)){
				$holidayperizin3 = $rowholiday3['libur'];
				$date1 = new DateTime($tanggalselesai3); 
					  $date2 = new DateTime($tanggalterima3); 
					 
					$interval = $date2->diff($date1);

					$selisihhari3 = $interval->format('%R%a');

$shari3 = substr($selisihhari3, 1,5);
					 
					
					$realisasi3 = $shari3 - $holidayperizin3;
					if($realisasi3 <= $waktu3 ){
					$sesuai3 = $realisasi3 <= $waktu3;
					//echo $sesuai3;
					$tot3=count($sesuai3);
					$tt3=0;
					$tt3 +=$tot3;
					$ttt3+=$tt3;
					$totalsesuai3=$ttt3;
				
					}else{
					$sesuai3 = $realisasi3 > $waktu3;
					}
				
		 }
		
		 }
		
}

				

//-----------------------------------akhir bulan 3
//------------------awal bulan4
                    $exeizin4 = mysql_query($sqlsesuai4);
                   
                    while($rowizin4 = mysql_fetch_assoc($exeizin4)){
					if($rowizin4 >0){
					//$trsektorid4=$rowizin4['trsektor_id'];
					$tanggalterima4=$rowizin4['terima'];
					$surat4=$rowizin4['tgl_surat'];
					$suratedit4=$rowizin4['tgl_surat_edit'];
					$waktu4=$rowizin4['durasi'];
					?>
			
		 <?
		 if ($suratedit4=='0000-00-00'){
		 $tanggalselesai4=$surat4;
		 }else{
		  $tanggalselesai4=$suratedit4;
		 }
		 $qholiday4="select count(date) libur from tmholiday where date between '$tanggalterima4' and '$tanggalselesai4'";
			$exeholiday4 = mysql_query($qholiday4);
                    while($rowholiday4 = mysql_fetch_assoc($exeholiday4)){
				$holidayperizin4 = $rowholiday4['libur'];
				$date1 = new DateTime($tanggalselesai4); 
					  $date2 = new DateTime($tanggalterima4); 
					 
					$interval = $date2->diff($date1);

					$selisihhari4 = $interval->format('%R%a');

$shari4 = substr($selisihhari4, 1,5);
					 
					
					$realisasi4 = $shari4 - $holidayperizin4;
					if($realisasi4 <= $waktu4 ){
					$sesuai4 = $realisasi4 <= $waktu4;
					//echo $sesuai4;
					$tot4=count($sesuai4);
					$tt4=0;
					$tt4 +=$tot4;
					$ttt4+=$tt4;
					$totalsesuai4=$ttt4;
				
					}else{
					$sesuai4 = $realisasi4 > $waktu4;
					}
				
		 }
		
		 }
		
}

				

//-----------------------------------akhir bulan 4
//------------------awal bulan5
                    $exeizin5 = mysql_query($sqlsesuai5);
                   
                    while($rowizin5 = mysql_fetch_assoc($exeizin5)){
					if($rowizin5 >0){
					//$trsektorid5=$rowizin5['trsektor_id'];
					$tanggalterima5=$rowizin5['terima'];
					$surat5=$rowizin5['tgl_surat'];
					$suratedit5=$rowizin5['tgl_surat_edit'];
					$waktu5=$rowizin5['durasi'];
					?>
			
		 <?
		 if ($suratedit5=='0000-00-00'){
		 $tanggalselesai5=$surat5;
		 }else{
		  $tanggalselesai5=$suratedit5;
		 }
		 $qholiday5="select count(date) libur from tmholiday where date between '$tanggalterima5' and '$tanggalselesai5'";
			$exeholiday5 = mysql_query($qholiday5);
                    while($rowholiday5 = mysql_fetch_assoc($exeholiday5)){
				$holidayperizin5 = $rowholiday5['libur'];
				$date1 = new DateTime($tanggalselesai5); 
					  $date2 = new DateTime($tanggalterima5); 
					 
					$interval = $date2->diff($date1);

					$selisihhari5 = $interval->format('%R%a');

$shari5 = substr($selisihhari5, 1,5);
					 
					
					$realisasi5 = $shari5 - $holidayperizin5;
					
					if($realisasi5 <= $waktu5 ){
					$sesuai5 = $realisasi5 <= $waktu5;
					//echo $sesuai5;
					$tot5=count($sesuai5);
					$tt5=0;
					$tt5 +=$tot5;
					$ttt5+=$tt5;
					$totalsesuai5=$ttt5;
				
					}else{
					$sesuai5 = $realisasi5 > $waktu5;
					}
				
		 }
		
		 }
		
}

				

//-----------------------------------akhir bulan 5
//------------------awal bulan6
                    $exeizin6 = mysql_query($sqlsesuai6);
                   
                    while($rowizin6 = mysql_fetch_assoc($exeizin6)){
					if($rowizin6 >0){
					//$trsektorid6=$rowizin6['trsektor_id'];
					$tanggalterima6=$rowizin6['terima'];
					$surat6=$rowizin6['tgl_surat'];
					$suratedit6=$rowizin6['tgl_surat_edit'];
					$waktu6=$rowizin6['durasi'];
					?>
			
		 <?
		 if ($suratedit6=='0000-00-00'){
		 $tanggalselesai6=$surat6;
		 }else{
		  $tanggalselesai6=$suratedit6;
		 }
		 $qholiday6="select count(date) libur from tmholiday where date between '$tanggalterima6' and '$tanggalselesai6'";
			$exeholiday6 = mysql_query($qholiday6);
                    while($rowholiday6 = mysql_fetch_assoc($exeholiday6)){
				$holidayperizin6 = $rowholiday6['libur'];
				$date1 = new DateTime($tanggalselesai6); 
					  $date2 = new DateTime($tanggalterima6); 
					 
					$interval = $date2->diff($date1);

					$selisihhari6 = $interval->format('%R%a');

$shari6 = substr($selisihhari6, 1,5);
					 
					
					$realisasi6 = $shari6 - $holidayperizin6;
					if($realisasi6 <= $waktu6 ){
					$sesuai6 = $realisasi6 <= $waktu6;
					//echo $sesuai6;
					$tot6=count($sesuai6);
					$tt6=0;
					$tt6 +=$tot6;
					$ttt6+=$tt6;
					$totalsesuai6=$ttt6;
				
					}else{
					$sesuai6 = $realisasi6 > $waktu6;
					}
				
		 }
		
		 }
		
}

				

//-----------------------------------akhir bulan 6
//------------------awal bulan7
                    $exeizin7 = mysql_query($sqlsesuai7);
                   
                    while($rowizin7 = mysql_fetch_assoc($exeizin7)){
					if($rowizin7 >0){
					//$trsektorid7=$rowizin7['trsektor_id'];
					$tanggalterima7=$rowizin7['terima'];
					$surat7=$rowizin7['tgl_surat'];
					$suratedit7=$rowizin7['tgl_surat_edit'];
					$waktu7=$rowizin7['durasi'];
					?>
			
		 <?
		 if ($suratedit7=='0000-00-00'){
		 $tanggalselesai7=$surat7;
		 }else{
		  $tanggalselesai7=$suratedit7;
		 }
		 $qholiday7="select count(date) libur from tmholiday where date between '$tanggalterima7' and '$tanggalselesai7'";
			$exeholiday7 = mysql_query($qholiday7);
                    while($rowholiday7 = mysql_fetch_assoc($exeholiday7)){
				$holidayperizin7 = $rowholiday7['libur'];
				$date1 = new DateTime($tanggalselesai7); 
					  $date2 = new DateTime($tanggalterima7); 
					 
					$interval = $date2->diff($date1);

					$selisihhari7 = $interval->format('%R%a');

$shari7 = substr($selisihhari7, 1,5);
					 
					
					$realisasi7 = $shari7 - $holidayperizin7;
					if($realisasi7 <= $waktu7 ){
					$sesuai7 = $realisasi7 <= $waktu7;
					//echo $sesuai7;
					$tot7=count($sesuai7);
					$tt7=0;
					$tt7 +=$tot7;
					$ttt7+=$tt7;
					$totalsesuai7=$ttt7;
				
					}else{
					$sesuai7 = $realisasi7 > $waktu7;
					}
				
		 }
		
		 }
		
}

				

//-----------------------------------akhir bulan 7
//------------------awal bulan8
                    $exeizin8 = mysql_query($sqlsesuai8);
                   
                    while($rowizin8 = mysql_fetch_assoc($exeizin8)){
					if($rowizin8 >0){
					//$trsektorid8=$rowizin8['trsektor_id'];
					$tanggalterima8=$rowizin8['terima'];
					$surat8=$rowizin8['tgl_surat'];
					$suratedit8=$rowizin8['tgl_surat_edit'];
					$waktu8=$rowizin8['durasi'];
					?>
			
		 <?
		 if ($suratedit8=='0000-00-00'){
		 $tanggalselesai8=$surat8;
		 }else{
		  $tanggalselesai8=$suratedit8;
		 }
		 $qholiday8="select count(date) libur from tmholiday where date between '$tanggalterima8' and '$tanggalselesai8'";
			$exeholiday8 = mysql_query($qholiday8);
                    while($rowholiday8 = mysql_fetch_assoc($exeholiday8)){
				$holidayperizin8 = $rowholiday8['libur'];
				$date1 = new DateTime($tanggalselesai8); 
					  $date2 = new DateTime($tanggalterima8); 
					 
					$interval = $date2->diff($date1);

					$selisihhari8 = $interval->format('%R%a');

$shari8 = substr($selisihhari8, 1,5);
					 
					
					$realisasi8 = $shari8 - $holidayperizin8;
					if($realisasi8 <= $waktu8 ){
					$sesuai8 = $realisasi8 <= $waktu8;
					//echo $sesuai8;
					$tot8=count($sesuai8);
					$tt8=0;
					$tt8 +=$tot8;
					$ttt8+=$tt8;
					$totalsesuai8=$ttt8;
				
					}else{
					$sesuai8 = $realisasi8 > $waktu8;
					}
				
		 }
		
		 }
		
}

				

//-----------------------------------akhir bulan 8
//------------------awal bulan9
                    $exeizin9 = mysql_query($sqlsesuai9);
                   
                    while($rowizin9 = mysql_fetch_assoc($exeizin9)){
					if($rowizin9 >0){
					//$trsektorid9=$rowizin9['trsektor_id'];
					$tanggalterima9=$rowizin9['terima'];
					$surat9=$rowizin9['tgl_surat'];
					$suratedit9=$rowizin9['tgl_surat_edit'];
					$waktu9=$rowizin9['durasi'];
					?>
			
		 <?
		 if ($suratedit9=='0000-00-00'){
		 $tanggalselesai9=$surat9;
		 }else{
		  $tanggalselesai9=$suratedit9;
		 }
		 $qholiday9="select count(date) libur from tmholiday where date between '$tanggalterima9' and '$tanggalselesai9'";
			$exeholiday9 = mysql_query($qholiday9);
                    while($rowholiday9 = mysql_fetch_assoc($exeholiday9)){
				$holidayperizin9 = $rowholiday9['libur'];
				$date1 = new DateTime($tanggalselesai9); 
					  $date2 = new DateTime($tanggalterima9); 
					 
					$interval = $date2->diff($date1);

					$selisihhari9 = $interval->format('%R%a');

$shari9 = substr($selisihhari9, 1,5);
					 
					
					$realisasi9 = $shari9 - $holidayperizin9;
					if($realisasi9 <= $waktu9 ){
					$sesuai9 = $realisasi9 <= $waktu9;
					//echo $sesuai9;
					$tot9=count($sesuai9);
					$tt9=0;
					$tt9 +=$tot9;
					$ttt9+=$tt9;
					$totalsesuai9=$ttt9;
				
					}else{
					$sesuai9 = $realisasi9 > $waktu9;
					}
				
		 }
		
		 }
		
}

				

//-----------------------------------akhir bulan 9
//------------------awal bulan10
                    $exeizin10 = mysql_query($sqlsesuai10);
                   
                    while($rowizin10 = mysql_fetch_assoc($exeizin10)){
					if($rowizin10 >0){
					//$trsektorid10=$rowizin10['trsektor_id'];
					$tanggalterima10=$rowizin10['terima'];
					$surat10=$rowizin10['tgl_surat'];
					$suratedit10=$rowizin10['tgl_surat_edit'];
					$waktu10=$rowizin10['durasi'];
					?>
			
		 <?
		 if ($suratedit10=='0000-00-00'){
		 $tanggalselesai10=$surat10;
		 }else{
		  $tanggalselesai10=$suratedit10;
		 }
		 $qholiday10="select count(date) libur from tmholiday where date between '$tanggalterima10' and '$tanggalselesai10'";
			$exeholiday10 = mysql_query($qholiday10);
                    while($rowholiday10 = mysql_fetch_assoc($exeholiday10)){
				$holidayperizin10 = $rowholiday10['libur'];
				$date1 = new DateTime($tanggalselesai10); 
					  $date2 = new DateTime($tanggalterima10); 
					 
					$interval = $date2->diff($date1);

					$selisihhari10 = $interval->format('%R%a');

$shari10 = substr($selisihhari10, 1,5);
					 
					
					$realisasi10 = $shari10 - $holidayperizin10;
					if($realisasi10 <= $waktu10 ){
					$sesuai10 = $realisasi10 <= $waktu10;
					//echo $sesuai10;
					$tot10=count($sesuai10);
					$tt10=0;
					$tt10 +=$tot10;
					$ttt10+=$tt10;
					$totalsesuai10=$ttt10;
				
					}else{
					$sesuai10 = $realisasi10 > $waktu10;
					}
				
		 }
		
		 }
		
}

				

//-----------------------------------akhir bulan 10
//------------------awal bulan11
                    $exeizin11 = mysql_query($sqlsesuai11);
                   
                    while($rowizin11 = mysql_fetch_assoc($exeizin11)){
					if($rowizin11 >0){
					//$trsektorid11=$rowizin11['trsektor_id'];
					$tanggalterima11=$rowizin11['terima'];
					$surat11=$rowizin11['tgl_surat'];
					$suratedit11=$rowizin11['tgl_surat_edit'];
					$waktu11=$rowizin11['durasi'];
					?>
			
		 <?
		 if ($suratedit11=='0000-00-00'){
		 $tanggalselesai11=$surat11;
		 }else{
		  $tanggalselesai11=$suratedit11;
		 }
		 $qholiday11="select count(date) libur from tmholiday where date between '$tanggalterima11' and '$tanggalselesai11'";
			$exeholiday11 = mysql_query($qholiday11);
                    while($rowholiday11 = mysql_fetch_assoc($exeholiday11)){
				$holidayperizin11 = $rowholiday11['libur'];
				$date1 = new DateTime($tanggalselesai11); 
					  $date2 = new DateTime($tanggalterima11); 
					 
					$interval = $date2->diff($date1);

					$selisihhari11 = $interval->format('%R%a');

$shari11 = substr($selisihhari11, 1,5);
					 
					
					$realisasi11 = $shari11 - $holidayperizin11;
					if($realisasi11 <= $waktu11 ){
					$sesuai11 = $realisasi11 <= $waktu11;
					//echo $sesuai11;
					$tot11=count($sesuai11);
					$tt11=0;
					$tt11 +=$tot11;
					$ttt11+=$tt11;
					$totalsesuai11=$ttt11;
				//echo $realisasi11;echo br();
					//echo $waktu11;
					}else{
					$sesuai11 = $realisasi11 > $waktu11;
					}
				
		 }
		
		 }
		
}

				

//-----------------------------------akhir bulan 11
//------------------awal bulan12
                    $exeizin12 = mysql_query($sqlsesuai12);
                   
                    while($rowizin12 = mysql_fetch_assoc($exeizin12)){
					if($rowizin12 >0){
					//$trsektorid12=$rowizin12['trsektor_id'];
					$tanggalterima12=$rowizin12['terima'];
					$surat12=$rowizin12['tgl_surat'];
					$suratedit12=$rowizin12['tgl_surat_edit'];
					$waktu12=$rowizin12['durasi'];
					?>
			
		 <?
		 if ($suratedit12=='0000-00-00'){
		 $tanggalselesai12=$surat12;
		 }else{
		  $tanggalselesai12=$suratedit12;
		 }
		 $qholiday12="select count(date) libur from tmholiday where date between '$tanggalterima12' and '$tanggalselesai12'";
			$exeholiday12 = mysql_query($qholiday12);
                    while($rowholiday12 = mysql_fetch_assoc($exeholiday12)){
				$holidayperizin12 = $rowholiday12['libur'];
				$date1 = new DateTime($tanggalselesai12); 
					  $date2 = new DateTime($tanggalterima12); 
					 
					$interval = $date2->diff($date1);

					$selisihhari12 = $interval->format('%R%a');

$shari12 = substr($selisihhari12, 1,5);
					 
					
					$realisasi12 = $shari12 - $holidayperizin12;
					//echo $realisasi12;
					if($realisasi12 <= $waktu12 ){
					$sesuai12 = $realisasi12 <= $waktu12;
					//echo $sesuai12;
					$tot12=count($sesuai12);
					$tt12=0;
					$tt12 +=$tot12;
					$ttt12+=$tt12;
					$totalsesuai12=$ttt12;
				//echo $totalsesuai12;
					}else{
					$sesuai12 = $realisasi12 > $waktu12;
				
					}
				
		 }
		
		 }
		
}
$totalsesuaitahun=$totalsesuai1+$totalsesuai2+$totalsesuai3+$totalsesuai4+$totalsesuai5+$totalsesuai6+$totalsesuai7+
					$totalsesuai8+$totalsesuai9+$totalsesuai10+$totalsesuai11+$totalsesuai12;

				

//-----------------------------------akhir bulan 12
			?>
									    <tr>
									<td align="center">3</td>
									<td align="left">JUMLAH SELESAI SESUAI DURASI</td>
									<td align="center"><?php echo $totalsesuai1; ?></td>
									<td align="center"><?php echo $totalsesuai2; ?></td>
									<td align="center"><?php echo $totalsesuai3; ?></td>
									<td align="center"><?php echo $totalsesuai4; ?></td>
									<td align="center"><?php echo $totalsesuai5; ?></td>
									<td align="center"><?php echo $totalsesuai6; ?></td>
									<td align="center"><?php echo $totalsesuai7; ?></td>
									<td align="center"><?php echo $totalsesuai8; ?></td>
									<td align="center"><?php echo $totalsesuai9; ?></td>
									<td align="center"><?php echo $totalsesuai10; ?></td>
									<td align="center"><?php echo $totalsesuai11; ?></td>
									<td align="center"><?php echo $totalsesuai12; ?></td>
									<td align="center"><?php echo $totalsesuaitahun; ?></td>
									</tr>
			<?php 
			//----------------------------------------------------------akhir selesai sesuai durasi
			//----------------------------------------------------------awal tingkat penyelesaian
		if($selesai1==0 or $permohonan1==0){
		$tingkatpenyelesaian1=0;
		}else{
		$tingkatpenyelesaian1=$selesai1/$permohonan1*100;
		}
		if($selesai2==0 or $permohonan2==0){
		$tingkatpenyelesaian2=0;
		}else{
		$tingkatpenyelesaian2=$selesai2/$permohonan2*100;
		}
		if($selesai3==0 or $permohonan3==0){
		$tingkatpenyelesaian3=0;
		}else{
		$tingkatpenyelesaian3=$selesai3/$permohonan3*100;
		}
		if($selesai4==0 or $permohonan4==0){
		$tingkatpenyelesaian4=0;
		}else{
		$tingkatpenyelesaian4=$selesai4/$permohonan4*100;
		}
		if($selesai5==0 or $permohonan5==0){
		$tingkatpenyelesaian5=0;
		}else{
		$tingkatpenyelesaian5=$selesai5/$permohonan5*100;
		}
		if($selesai6==0 or $permohonan6==0){
		$tingkatpenyelesaian6=0;
		}else{
		$tingkatpenyelesaian6=$selesai6/$permohonan6*100;
		}
		if($selesai7==0 or $permohonan7==0){
		$tingkatpenyelesaian7=0;
		}else{
		$tingkatpenyelesaian7=$selesai7/$permohonan7*100;
		}
		if($selesai8==0 or $permohonan8==0){
		$tingkatpenyelesaian8=0;
		}else{
		$tingkatpenyelesaian8=$selesai8/$permohonan8*100;
		}
		if($selesai9==0 or $permohonan9==0){
		$tingkatpenyelesaian9=0;
		}else{
		$tingkatpenyelesaian9=$selesai9/$permohonan9*100;
		}
		if($selesai10==0 or $permohonan10==0){
		$tingkatpenyelesaian10=0;
		}else{
		$tingkatpenyelesaian10=$selesai10/$permohonan10*100;
		}
		if($selesai11==0 or $permohonan11==0){
		$tingkatpenyelesaian11=0;
		}else{
		$tingkatpenyelesaian11=$selesai11/$permohonan11*100;
		}
		if($selesai12==0 or $permohonan12==0){
		$tingkatpenyelesaian12=0;
		}else{
		$tingkatpenyelesaian12=$selesai12/$permohonan12*100;
		}
		if($totalselesai==0 or $totalpermohonan==0){
		$totaltingkatpenyelesaian=0;
		}else{
		$totaltingkatpenyelesaian=$totalselesai/$totalpermohonan*100;
		}
			?>
									    <tr>
									<td align="center">4</td>
									<td align="left">TINGKAT PENYELESAIAN</td>
									<td align="center"><? echo round($tingkatpenyelesaian1); echo ' %';?></td>
									<td align="center"><? echo round($tingkatpenyelesaian2); echo ' %';?></td>
									<td align="center"><? echo round($tingkatpenyelesaian3); echo ' %';?></td>
									<td align="center"><? echo round($tingkatpenyelesaian4); echo ' %';?></td>
									<td align="center"><? echo round($tingkatpenyelesaian5); echo ' %';?></td>
									<td align="center"><? echo round($tingkatpenyelesaian6); echo ' %';?></td>
									<td align="center"><? echo round($tingkatpenyelesaian7); echo ' %';?></td>
									<td align="center"><? echo round($tingkatpenyelesaian8); echo ' %';?></td>
									<td align="center"><? echo round($tingkatpenyelesaian9); echo ' %';?></td>
									<td align="center"><? echo round($tingkatpenyelesaian10); echo ' %';?></td>
									<td align="center"><? echo round($tingkatpenyelesaian11); echo ' %';?></td>
									<td align="center"><? echo round($tingkatpenyelesaian12); echo ' %';?></td>
									<td align="center"><? echo round($totaltingkatpenyelesaian); echo ' %';?></td>
									</tr>
			<?php 
			//-----------------------------------------------------akhir penyelesaian
			//------------------------------------------------------awal ketepatan
			
			if($totalsesuai1==0 or $selesai1==0){
			$ketepatan1=0;
			}else{
			$ketepatan1=$totalsesuai1/$selesai1*100;
			}
			
			if($totalsesuai2==0 or $selesai2==0){
			$ketepatan2=0;
			}else{
			$ketepatan2=$totalsesuai2/$selesai2*100;
			}
			
			if($totalsesuai3==0 or $selesai3==0){
			$ketepatan3=0;
			}else{
			$ketepatan3=$totalsesuai3/$selesai3*100;
			}
			
			if($totalsesuai4==0 or $selesai4==0){
			$ketepatan4=0;
			}else{
			$ketepatan4=$totalsesuai4/$selesai4*100;
			}
			
			if($totalsesuai5==0 or $selesai5==0){
			$ketepatan5=0;
			}else{
			$ketepatan5=$totalsesuai5/$selesai5*100;
			}
			
			if($totalsesuai6==0 or $selesai6==0){
			$ketepatan6=0;
			}else{
			$ketepatan6=$totalsesuai6/$selesai6*100;
			}
			
			if($totalsesuai7==0 or $selesai7==0){
			$ketepatan7=0;
			}else{
			$ketepatan7=$totalsesuai7/$selesai7*100;
			}
			
			if($totalsesuai8==0 or $selesai8==0){
			$ketepatan8=0;
			}else{
			$ketepatan8=$totalsesuai8/$selesai8*100;
			}
			
			if($totalsesuai9==0 or $selesai9==0){
			$ketepatan9=0;
			}else{
			$ketepatan9=$totalsesuai9/$selesai9*100;
			}
			
			if($totalsesuai10==0 or $selesai10==0){
			$ketepatan10=0;
			}else{
			$ketepatan10=$totalsesuai10/$selesai10*100;
			}
			
			if($totalsesuai11==0 or $selesai11==0){
			$ketepatan11=0;
			}else{
			$ketepatan11=$totalsesuai11/$selesai11*100;
			}
			
			if($totalsesuai12==0 or $selesai12==0){
			$ketepatan12=0;
			}else{
			$ketepatan12=$totalsesuai12/$selesai12*100;
			}
			if($totalsesuaitahun==0 or $totalselesai==0){
			$ketepatantahun=0;
			}else{
			$ketepatantahun=$totalsesuaitahun/$totalselesai*100;
			}
			?>
									    <tr>
									<td align="center">5</td>
									<td align="left">TINGAKAT KETEPATAN</td>
									<td align="center"><?php echo round($ketepatan1); echo ' %';  ?></td>
									<td align="center"><?php echo round($ketepatan2); echo ' %';  ?></td>
									<td align="center"><?php echo round($ketepatan3); echo ' %';  ?></td>
									<td align="center"><?php echo round($ketepatan4); echo ' %';  ?></td>
									<td align="center"><?php echo round($ketepatan5); echo ' %';  ?></td>
									<td align="center"><?php echo round($ketepatan6); echo ' %';  ?></td>
									<td align="center"><?php echo round($ketepatan7); echo ' %';  ?></td>
									<td align="center"><?php echo round($ketepatan8); echo ' %';  ?></td>
									<td align="center"><?php echo round($ketepatan9); echo ' %';  ?></td>
									<td align="center"><?php echo round($ketepatan10); echo ' %';  ?></td>
									<td align="center"><?php echo round($ketepatan11); echo ' %';  ?></td>
									<td align="center"><?php echo round($ketepatan12); echo ' %';  ?></td>
									<td align="center"><?php echo round($ketepatantahun); echo ' %'; ?></td>
									</tr>
			<?
			//-----------------------------------------------------akhir ketepatan
			//----------------------------------------------------awal kecepatan
			$ttperkec=0;
			$totalrealisasi=0;
			$tt=0;
			
			$ttperkec2=0;
			$totalrealisasi2=0;
			$tt2=0;
			
			$ttperkec3=0;
			$totalrealisasi3=0;
			$tt3=0;
			
			$ttperkec4=0;
			$totalrealisasi4=0;
			$tt4=0;
			
			$ttperkec5=0;
			$totalrealisasi5=0;
			$tt5=0;
			
			$ttperkec6=0;
			$totalrealisasi6=0;
			$tt6=0;
			
			$ttperkec7=0;
			$totalrealisasi7=0;
			$tt7=0;
			
			$ttperkec8=0;
			$totalrealisasi8=0;
			$tt8=0;
			
			$ttperkec9=0;
			$totalrealisasi9=0;
			$tt9=0;
			
			$ttperkec10=0;
			$totalrealisasi10=0;
			$tt10=0;
			
			$ttperkec11=0;
			$totalrealisasi11=0;
			$tt11=0;
			
			$ttperkec12=0;
			$totalrealisasi12=0;
			$tt12=0;
			
			$ttperkec13=0;
			$totalrealisasi13=0;
			$tt13=0;
			
			$sqlkecepatan = "select  a.pendaftaran_id no,e.n_perizinan jenis,b.trperizinan_id idizin,a.trsektor_id,a.d_terima_berkas terima,a.d_selesai_proses selesai,i.tgl_surat,i.tgl_surat_edit,e.v_hari durasi,a.a_izin, a.keterangan,
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
where d.c_penetapan = 1 and year(a.d_terima_berkas)='$tgla' and month(a.d_terima_berkas)=";

$sqlkecepatan1="$sqlkecepatan '01'";
$sqlkecepatan2="$sqlkecepatan '02'";
$sqlkecepatan3="$sqlkecepatan '03'";
$sqlkecepatan4="$sqlkecepatan '04'";
$sqlkecepatan5="$sqlkecepatan '05'";
$sqlkecepatan6="$sqlkecepatan '06'";
$sqlkecepatan7="$sqlkecepatan '07'";
$sqlkecepatan8="$sqlkecepatan '08'";
$sqlkecepatan9="$sqlkecepatan '09'";
$sqlkecepatan10="$sqlkecepatan '10'";
$sqlkecepatan11="$sqlkecepatan '11'";
$sqlkecepatan12="$sqlkecepatan '12'";


			?>
			
			<tr>
									<td align="center">6</td>
									<td align="left">TINGKAT KECEPATAN</td>
			<?
			
			//-------------------------------------------awal kecepatan 1
			?>
			<?
			 $exeizin = mysql_query($sqlkecepatan1);
                   
                    while($rowizin = mysql_fetch_assoc($exeizin)){
					if($rowizin >0){
					$trsektorid=$rowizin['trsektor_id'];
					
					
	
		 
		 //------------------------------------------------------------------------tanggal terima
		 $tanggalterima=$rowizin['terima'];

		 //------------------------------------------------------------------------tanggal surat
		 $surat=$rowizin['tgl_surat'];
		//  echo $rowizin['tgl_surat'];
		
		 //--------------------------------------------------------------------------tanggal surat edit
		  $suratedit=$rowizin['tgl_surat_edit'];
		  //echo $rowizin['tgl_surat_edit'];
		
		 //---------------------------------------------------------------------------- durasi
		 $waktu=$rowizin['durasi'];
		  //echo $rowizin['durasi'];
		
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
					
					//--------------------------------------------------------hari libur
					//echo $holidayperizin;  
					
					//-------------------------------------sektor id
					//echo $trsektorid; 
					// realisasi target
				
					
					$date1 = new DateTime($tanggalselesai); 
					  $date2 = new DateTime($tanggalterima); 
					 
					$interval = $date2->diff($date1);

					$selisihhari = $interval->format('%R%a');
//-------------------------------------------------------------------selisih hari
$shari = substr($selisihhari, 1,5);
					 
					//echo $shari;
					
					$realisasi = $shari - $holidayperizin;
					$totalrealisasi+=$realisasi;
					
					//-----------------------------------------------------------------realisasi
					//echo $realisasi;
					//------------------------------------------------------------jumlahsesuai
					// echo $idperizinan; 
					//if($realisasi <= $waktu ){
					//$sesuai=$realisasi <= $waktu;
					//echo $sesuai;
					//$tot=count($sesuai);
					$tot=count($realisasi);
					$tt +=$tot;
					//echo $tt;
					//}else{
					//$sesuai=$realisasi > $waktu;
					//}
					
//---------------------------------------------------persen kecepatan
$perkec=($waktu - $realisasi)/$waktu * 100;

//echo round($perkec);echo ' %';		


$ratatotalrealisasi=$totalrealisasi/$tt;
		
					
						$ttperkec +=$perkec;
				//$jumperkec[]=$ttperkec;
					//	$aperkec=array_sum($jumperkec);
						
						//$total_perkec = number_format($aperkec);
						//echo $total_perkec;
									
						
					
								
					
		  // echo $rowizin['idizin'];echo br();
		
					

					
					
		 }
		
		 }
		
}
//------------------------------------------------jumlah total Sesuai
		
				// echo round($totalrealisasi); 
				//echo round($ratatotalrealisasi);	
			//echo round($ttperkec); echo ' %'; 
					
					
				
$persenkecepatan1 = 0;
if($ttperkec==0 or $tt==0){
$persenkecepatan1=0;
}else{
$persenkecepatan1 =$ttperkec/$tt;

}
?>
<td align="center">

<?php echo round($persenkecepatan1);echo ' %';?>
</td>
	<?	

					
					$ttperkec=0;
$tt=0;
$totalrealisasi=0;
$ratatotalrealisasi=0;	
					
			?>
			<?php 
			//---------------------------------------------akhir kecepatan 1
			//----------------------------------------------awal kecepatan 2
			?>
			<?
			
			 $exeizin2 = mysql_query($sqlkecepatan2);
                   
                    while($rowizin2 = mysql_fetch_assoc($exeizin2)){
					if($rowizin2 >0){
		 $tanggalterima2=$rowizin2['terima'];
		$surat2=$rowizin2['tgl_surat'];
		$suratedit2=$rowizin2['tgl_surat_edit'];
		$waktu2=$rowizin2['durasi'];
		 if ($suratedit2=='0000-00-00'){
		 $tanggalselesai2=$surat2;
		 }else{
		  $tanggalselesai2=$suratedit2;
		 }
		  $qholiday2="select count(date) libur from tmholiday where date between '$tanggalterima2' and '$tanggalselesai2'";
$exeholiday2 = mysql_query($qholiday2);
                    while($rowholiday2 = mysql_fetch_assoc($exeholiday2)){
				$holidayperizin2 = $rowholiday2['libur'];
				
					$date1 = new DateTime($tanggalselesai2); 
					  $date2 = new DateTime($tanggalterima2); 
					 
					$interval = $date2->diff($date1);

					$selisihhari2 = $interval->format('%R%a');
//-------------------------------------------------------------------selisih hari
$shari2 = substr($selisihhari2, 1,5);
					
					$realisasi2 = $shari2 - $holidayperizin2;
					$totalrealisasi2+=$realisasi2;
					
					$tot2=count($realisasi2);
					$tt2 +=$tot2;
				
$perkec2=($waktu2 - $realisasi2)/$waktu2 * 100;

$ratatotalrealisasi2=$totalrealisasi2/$tt2;
		
					
						$ttperkec2 +=$perkec2;
					
		 }
		
		 }
		
}
		
$persenkecepatan2 = 0;
if($ttperkec2==0 or $tt2==0){
$persenkecepatan2=0;
}else{
$persenkecepatan2 =$ttperkec2/$tt2;

}
?>
<td align="center">

<?php echo round($persenkecepatan2);echo ' %';?>
</td>
	<?	

					
					$ttperkec2=0;
$tt2=0;
$totalrealisasi2=0;
$ratatotalrealisasi2=0;	
					
			?>
			<?php 
			//---------------------------------------------akhir kecepatan 2
			//-----------------------------------------------awal kecepatan 3
			
			?>
			<?
		
 $exeizin3 = mysql_query($sqlkecepatan3);
                   
                    while($rowizin3 = mysql_fetch_assoc($exeizin3)){
					if($rowizin3 >0){
		 $tanggalterima3=$rowizin3['terima'];
		$surat3=$rowizin3['tgl_surat'];
		$suratedit3=$rowizin3['tgl_surat_edit'];
		$waktu3=$rowizin3['durasi'];
		 if ($suratedit3=='0000-00-00'){
		 $tanggalselesai3=$surat3;
		 }else{
		  $tanggalselesai3=$suratedit3;
		 }
		  $qholiday3="select count(date) libur from tmholiday where date between '$tanggalterima3' and '$tanggalselesai3'";
$exeholiday3 = mysql_query($qholiday3);
                    while($rowholiday3 = mysql_fetch_assoc($exeholiday3)){
				$holidayperizin3 = $rowholiday3['libur'];
				
					$date1 = new DateTime($tanggalselesai3); 
					  $date3 = new DateTime($tanggalterima3); 
					 
					$interval = $date3->diff($date1);

					$selisihhari3 = $interval->format('%R%a');
//-------------------------------------------------------------------selisih hari
$shari3 = substr($selisihhari3, 1,5);
					
					$realisasi3 = $shari3 - $holidayperizin3;
					$totalrealisasi3+=$realisasi3;
					
					$tot3=count($realisasi3);
					$tt3 +=$tot3;
				
$perkec3=($waktu3 - $realisasi3)/$waktu3 * 100;

$ratatotalrealisasi3=$totalrealisasi3/$tt3;
		
					
						$ttperkec3 +=$perkec3;
					
		 }
		
		 }
		
}
		
$persenkecepatan3 = 0;
if($ttperkec3==0 or $tt3==0){
$persenkecepatan3=0;
}else{
$persenkecepatan3 =$ttperkec3/$tt3;

}
?>
<td align="center">

<?php echo round($persenkecepatan3);echo ' %';?>
</td>
	<?	

					
					$ttperkec3=0;
$tt3=0;
$totalrealisasi3=0;
$ratatotalrealisasi3=0;	
					
			?>
			<?php 
			//---------------------------------------------akhir kecepatan 3
			?>
			<?
			//-------------------------------------------awalkecepatan 4
			?>
			<?
 $exeizin4 = mysql_query($sqlkecepatan4);
                   
                    while($rowizin4 = mysql_fetch_assoc($exeizin4)){
					if($rowizin4 >0){
		 $tanggalterima4=$rowizin4['terima'];
		$surat4=$rowizin4['tgl_surat'];
		$suratedit4=$rowizin4['tgl_surat_edit'];
		$waktu4=$rowizin4['durasi'];
		 if ($suratedit4=='0000-00-00'){
		 $tanggalselesai4=$surat4;
		 }else{
		  $tanggalselesai4=$suratedit4;
		 }
		  $qholiday4="select count(date) libur from tmholiday where date between '$tanggalterima4' and '$tanggalselesai4'";
$exeholiday4 = mysql_query($qholiday4);
                    while($rowholiday4 = mysql_fetch_assoc($exeholiday4)){
				$holidayperizin4 = $rowholiday4['libur'];
				
					$date1 = new DateTime($tanggalselesai4); 
					  $date4 = new DateTime($tanggalterima4); 
					 
					$interval = $date4->diff($date1);

					$selisihhari4 = $interval->format('%R%a');
//-------------------------------------------------------------------selisih hari
$shari4 = substr($selisihhari4, 1,5);
					
					$realisasi4 = $shari4 - $holidayperizin4;
					$totalrealisasi4+=$realisasi4;
					
					$tot4=count($realisasi4);
					$tt4 +=$tot4;
				
$perkec4=($waktu4 - $realisasi4)/$waktu4 * 100;

$ratatotalrealisasi4=$totalrealisasi4/$tt4;
		
					
						$ttperkec4 +=$perkec4;
					
		 }
		
		 }
		
}
		
$persenkecepatan4 = 0;
if($ttperkec4==0 or $tt4==0){
$persenkecepatan4=0;
}else{
$persenkecepatan4 =$ttperkec4/$tt4;

}
?>
<td align="center">

<?php echo round($persenkecepatan4);echo ' %';?>
</td>
	<?	

					
					$ttperkec4=0;
$tt4=0;
$totalrealisasi4=0;
$ratatotalrealisasi4=0;	
					
			?>
			<?php 
			//---------------------------------------------akhir kecepatan 4
			//--------------------------------------------awal kecepatan 5
			?>
			<?
 $exeizin5 = mysql_query($sqlkecepatan5);
                   
                    while($rowizin5 = mysql_fetch_assoc($exeizin5)){
					if($rowizin5 >0){
		 $tanggalterima5=$rowizin5['terima'];
		$surat5=$rowizin5['tgl_surat'];
		$suratedit5=$rowizin5['tgl_surat_edit'];
		$waktu5=$rowizin5['durasi'];
		 if ($suratedit5=='0000-00-00'){
		 $tanggalselesai5=$surat5;
		 }else{
		  $tanggalselesai5=$suratedit5;
		 }
		  $qholiday5="select count(date) libur from tmholiday where date between '$tanggalterima5' and '$tanggalselesai5'";
$exeholiday5 = mysql_query($qholiday5);
                    while($rowholiday5 = mysql_fetch_assoc($exeholiday5)){
				$holidayperizin5 = $rowholiday5['libur'];
				
					$date1 = new DateTime($tanggalselesai5); 
					  $date5 = new DateTime($tanggalterima5); 
					 
					$interval = $date5->diff($date1);

					$selisihhari5 = $interval->format('%R%a');
//-------------------------------------------------------------------selisih hari
$shari5 = substr($selisihhari5, 1,5);
					
					$realisasi5 = $shari5 - $holidayperizin5;
					$totalrealisasi5+=$realisasi5;
					
					$tot5=count($realisasi5);
					$tt5 +=$tot5;
				
$perkec5=($waktu5 - $realisasi5)/$waktu5 * 100;

$ratatotalrealisasi5=$totalrealisasi5/$tt5;
		
					
						$ttperkec5 +=$perkec5;
					
		 }
		
		 }
		
}
		
$persenkecepatan5 = 0;
if($ttperkec5==0 or $tt5==0){
$persenkecepatan5=0;
}else{
$persenkecepatan5 =$ttperkec5/$tt5;

}
?>
<td align="center">

<?php echo round($persenkecepatan5);echo ' %';?>
</td>
	<?	

					
					$ttperkec5=0;
$tt5=0;
$totalrealisasi5=0;
$ratatotalrealisasi5=0;	
					
			?>
			<?php 
			//---------------------------------------------akhir kecepatan 5
			//---------------------------------------------awal kecepatan 6
			?>
			<?
 $exeizin6 = mysql_query($sqlkecepatan6);
                   
                    while($rowizin6 = mysql_fetch_assoc($exeizin6)){
					if($rowizin6 >0){
		 $tanggalterima6=$rowizin6['terima'];
		$surat6=$rowizin6['tgl_surat'];
		$suratedit6=$rowizin6['tgl_surat_edit'];
		$waktu6=$rowizin6['durasi'];
		 if ($suratedit6=='0000-00-00'){
		 $tanggalselesai6=$surat6;
		 }else{
		  $tanggalselesai6=$suratedit6;
		 }
		  $qholiday6="select count(date) libur from tmholiday where date between '$tanggalterima6' and '$tanggalselesai6'";
$exeholiday6 = mysql_query($qholiday6);
                    while($rowholiday6 = mysql_fetch_assoc($exeholiday6)){
				$holidayperizin6 = $rowholiday6['libur'];
				
					$date1 = new DateTime($tanggalselesai6); 
					  $date6 = new DateTime($tanggalterima6); 
					 
					$interval = $date6->diff($date1);

					$selisihhari6 = $interval->format('%R%a');
//-------------------------------------------------------------------selisih hari
$shari6 = substr($selisihhari6, 1,6);
					
					$realisasi6 = $shari6 - $holidayperizin6;
					$totalrealisasi6+=$realisasi6;
					
					$tot6=count($realisasi6);
					$tt6 +=$tot6;
				
$perkec6=($waktu6 - $realisasi6)/$waktu6 * 100;

$ratatotalrealisasi6=$totalrealisasi6/$tt6;
		
					
						$ttperkec6 +=$perkec6;
					
		 }
		
		 }
		
}
		
$persenkecepatan6 = 0;
if($ttperkec6==0 or $tt6==0){
$persenkecepatan6=0;
}else{
$persenkecepatan6 =$ttperkec6/$tt6;

}
?>
<td align="center">

<?php echo round($persenkecepatan6);echo ' %';?>
</td>
	<?	

					
					$ttperkec6=0;
$tt6=0;
$totalrealisasi6=0;
$ratatotalrealisasi6=0;	
					
			?>
			<?php 
			//---------------------------------------------akhir kecepatan 6
			//-----------------------------------------------awal kecepatan 7						 
?>		
<?
 $exeizin7 = mysql_query($sqlkecepatan7);
                   
                    while($rowizin7 = mysql_fetch_assoc($exeizin7)){
					if($rowizin7 >0){
		 $tanggalterima7=$rowizin7['terima'];
		$surat7=$rowizin7['tgl_surat'];
		$suratedit7=$rowizin7['tgl_surat_edit'];
		$waktu7=$rowizin7['durasi'];
		 if ($suratedit7=='0000-00-00'){
		 $tanggalselesai7=$surat7;
		 }else{
		  $tanggalselesai7=$suratedit7;
		 }
		  $qholiday7="select count(date) libur from tmholiday where date between '$tanggalterima7' and '$tanggalselesai7'";
$exeholiday7 = mysql_query($qholiday7);
                    while($rowholiday7 = mysql_fetch_assoc($exeholiday7)){
				$holidayperizin7 = $rowholiday7['libur'];
				
					$date1 = new DateTime($tanggalselesai7); 
					  $date7 = new DateTime($tanggalterima7); 
					 
					$interval = $date7->diff($date1);

					$selisihhari7 = $interval->format('%R%a');
//-------------------------------------------------------------------selisih hari
$shari7 = substr($selisihhari7, 1,7);
					
					$realisasi7 = $shari7 - $holidayperizin7;
					$totalrealisasi7+=$realisasi7;
					
					$tot7=count($realisasi7);
					$tt7 +=$tot7;
				
$perkec7=($waktu7 - $realisasi7)/$waktu7 * 100;

$ratatotalrealisasi7=$totalrealisasi7/$tt7;
		
					
						$ttperkec7 +=$perkec7;
					
		 }
		
		 }
		
}
		
$persenkecepatan7 = 0;
if($ttperkec7==0 or $tt7==0){
$persenkecepatan7=0;
}else{
$persenkecepatan7 =$ttperkec7/$tt7;

}
?>
<td align="center">

<?php echo round($persenkecepatan7);echo ' %';?>
</td>
	<?	

					
					$ttperkec7=0;
$tt7=0;
$totalrealisasi7=0;
$ratatotalrealisasi7=0;	
					
			?>
			<?php 
			//---------------------------------------------akhir kecepatan 7
			//---------------------------------------------awalkecepatan 8
?>	
<?
 $exeizin8 = mysql_query($sqlkecepatan8);
                   
                    while($rowizin8 = mysql_fetch_assoc($exeizin8)){
					if($rowizin8 >0){
		 $tanggalterima8=$rowizin8['terima'];
		$surat8=$rowizin8['tgl_surat'];
		$suratedit8=$rowizin8['tgl_surat_edit'];
		$waktu8=$rowizin8['durasi'];
		 if ($suratedit8=='0000-00-00'){
		 $tanggalselesai8=$surat8;
		 }else{
		  $tanggalselesai8=$suratedit8;
		 }
		  $qholiday8="select count(date) libur from tmholiday where date between '$tanggalterima8' and '$tanggalselesai8'";
$exeholiday8 = mysql_query($qholiday8);
                    while($rowholiday8 = mysql_fetch_assoc($exeholiday8)){
				$holidayperizin8 = $rowholiday8['libur'];
				
					$date1 = new DateTime($tanggalselesai8); 
					  $date8 = new DateTime($tanggalterima8); 
					 
					$interval = $date8->diff($date1);

					$selisihhari8 = $interval->format('%R%a');
//-------------------------------------------------------------------selisih hari
$shari8 = substr($selisihhari8, 1,8);
					
					$realisasi8 = $shari8 - $holidayperizin8;
					$totalrealisasi8+=$realisasi8;
					
					$tot8=count($realisasi8);
					$tt8 +=$tot8;
				
$perkec8=($waktu8 - $realisasi8)/$waktu8 * 100;

$ratatotalrealisasi8=$totalrealisasi8/$tt8;
		
					
						$ttperkec8 +=$perkec8;
					
		 }
		
		 }
		
}
		
$persenkecepatan8 = 0;
if($ttperkec8==0 or $tt8==0){
$persenkecepatan8=0;
}else{
$persenkecepatan8 =$ttperkec8/$tt8;

}
?>
<td align="center">

<?php echo round($persenkecepatan8);echo ' %';?>
</td>
	<?	

					
					$ttperkec8=0;
$tt8=0;
$totalrealisasi8=0;
$ratatotalrealisasi8=0;	
					
			?>
			<?php 
			//---------------------------------------------akhir kecepatan 8
			//----------------------------------------------awal kecepatan 9
			
?>
<?
 $exeizin9 = mysql_query($sqlkecepatan9);
                   
                    while($rowizin9 = mysql_fetch_assoc($exeizin9)){
					if($rowizin9 >0){
		 $tanggalterima9=$rowizin9['terima'];
		$surat9=$rowizin9['tgl_surat'];
		$suratedit9=$rowizin9['tgl_surat_edit'];
		$waktu9=$rowizin9['durasi'];
		 if ($suratedit9=='0000-00-00'){
		 $tanggalselesai9=$surat9;
		 }else{
		  $tanggalselesai9=$suratedit9;
		 }
		  $qholiday9="select count(date) libur from tmholiday where date between '$tanggalterima9' and '$tanggalselesai9'";
$exeholiday9 = mysql_query($qholiday9);
                    while($rowholiday9 = mysql_fetch_assoc($exeholiday9)){
				$holidayperizin9 = $rowholiday9['libur'];
				
					$date1 = new DateTime($tanggalselesai9); 
					  $date9 = new DateTime($tanggalterima9); 
					 
					$interval = $date9->diff($date1);

					$selisihhari9 = $interval->format('%R%a');
//-------------------------------------------------------------------selisih hari
$shari9 = substr($selisihhari9, 1,9);
					
					$realisasi9 = $shari9 - $holidayperizin9;
					$totalrealisasi9+=$realisasi9;
					
					$tot9=count($realisasi9);
					$tt9 +=$tot9;
				
$perkec9=($waktu9 - $realisasi9)/$waktu9 * 100;

$ratatotalrealisasi9=$totalrealisasi9/$tt9;
		
					
						$ttperkec9 +=$perkec9;
					
		 }
		
		 }
		
}
		
$persenkecepatan9 = 0;
if($ttperkec9==0 or $tt9==0){
$persenkecepatan9=0;
}else{
$persenkecepatan9 =$ttperkec9/$tt9;

}
?>
<td align="center">

<?php echo round($persenkecepatan9);echo ' %';?>
</td>
	<?	

					
					$ttperkec9=0;
$tt9=0;
$totalrealisasi9=0;
$ratatotalrealisasi9=0;	
					
			?>
			<?php 
			//---------------------------------------------akhir kecepatan 9
			//--------------------------------------------awal kecepatan 10
?>
<?
 $exeizin10 = mysql_query($sqlkecepatan10);
                   
                    while($rowizin10 = mysql_fetch_assoc($exeizin10)){
					if($rowizin10 >0){
		 $tanggalterima10=$rowizin10['terima'];
		$surat10=$rowizin10['tgl_surat'];
		$suratedit10=$rowizin10['tgl_surat_edit'];
		$waktu10=$rowizin10['durasi'];
		 if ($suratedit10=='0000-00-00'){
		 $tanggalselesai10=$surat10;
		 }else{
		  $tanggalselesai10=$suratedit10;
		 }
		  $qholiday10="select count(date) libur from tmholiday where date between '$tanggalterima10' and '$tanggalselesai10'";
$exeholiday10 = mysql_query($qholiday10);
                    while($rowholiday10 = mysql_fetch_assoc($exeholiday10)){
				$holidayperizin10 = $rowholiday10['libur'];
				
					$date1 = new DateTime($tanggalselesai10); 
					  $date10 = new DateTime($tanggalterima10); 
					 
					$interval = $date10->diff($date1);

					$selisihhari10 = $interval->format('%R%a');
//-------------------------------------------------------------------selisih hari
$shari10 = substr($selisihhari10, 1,10);
					
					$realisasi10 = $shari10 - $holidayperizin10;
					$totalrealisasi10+=$realisasi10;
					
					$tot10=count($realisasi10);
					$tt10 +=$tot10;
				
$perkec10=($waktu10 - $realisasi10)/$waktu10 * 100;

$ratatotalrealisasi10=$totalrealisasi10/$tt10;
		
					
						$ttperkec10 +=$perkec10;
					
		 }
		
		 }
		
}
		
$persenkecepatan10 = 0;
if($ttperkec10==0 or $tt10==0){
$persenkecepatan10=0;
}else{
$persenkecepatan10 =$ttperkec10/$tt10;

}
?>
<td align="center">

<?php echo round($persenkecepatan10);echo ' %';?>
</td>
	<?	

					
					$ttperkec10=0;
$tt10=0;
$totalrealisasi10=0;
$ratatotalrealisasi10=0;	
					
			?>
			<?php 
			//---------------------------------------------akhir kecepatan 10
			//--------------------------------------------- awal kecepatan 11
?>
<?
 $exeizin11 = mysql_query($sqlkecepatan11);
                   
                    while($rowizin11 = mysql_fetch_assoc($exeizin11)){
					if($rowizin11 >0){
		 $tanggalterima11=$rowizin11['terima'];
		$surat11=$rowizin11['tgl_surat'];
		$suratedit11=$rowizin11['tgl_surat_edit'];
		$waktu11=$rowizin11['durasi'];
		 if ($suratedit11=='0000-00-00'){
		 $tanggalselesai11=$surat11;
		 }else{
		  $tanggalselesai11=$suratedit11;
		 }
		  $qholiday11="select count(date) libur from tmholiday where date between '$tanggalterima11' and '$tanggalselesai11'";
$exeholiday11 = mysql_query($qholiday11);
                    while($rowholiday11 = mysql_fetch_assoc($exeholiday11)){
				$holidayperizin11 = $rowholiday11['libur'];
				
					$date1 = new DateTime($tanggalselesai11); 
					  $date11 = new DateTime($tanggalterima11); 
					 
					$interval = $date11->diff($date1);

					$selisihhari11 = $interval->format('%R%a');
//-------------------------------------------------------------------selisih hari
$shari11 = substr($selisihhari11, 1,11);
					
					$realisasi11 = $shari11 - $holidayperizin11;
					$totalrealisasi11+=$realisasi11;
					
					$tot11=count($realisasi11);
					$tt11 +=$tot11;
				
$perkec11=($waktu11 - $realisasi11)/$waktu11 * 110;

$ratatotalrealisasi11=$totalrealisasi11/$tt11;
		
					
						$ttperkec11 +=$perkec11;
					
		 }
		
		 }
		
}
		
$persenkecepatan11 = 0;
if($ttperkec11==0 or $tt11==0){
$persenkecepatan11=0;
}else{
$persenkecepatan11 =$ttperkec11/$tt11;

}
?>
<td align="center">

<?php echo round($persenkecepatan11);echo ' %';?>
</td>
	<?	

					
					$ttperkec11=0;
$tt11=0;
$totalrealisasi11=0;
$ratatotalrealisasi11=0;	
					
			?>
			<?php 
			//---------------------------------------------akhir kecepatan 11
			//---------------------------------------------awal kecepatan 12
?>
<?
 $exeizin12 = mysql_query($sqlkecepatan12);
                   
                    while($rowizin12 = mysql_fetch_assoc($exeizin12)){
					if($rowizin12 >0){
		 $tanggalterima12=$rowizin12['terima'];
		$surat12=$rowizin12['tgl_surat'];
		$suratedit12=$rowizin12['tgl_surat_edit'];
		$waktu12=$rowizin12['durasi'];
		 if ($suratedit12=='0000-00-00'){
		 $tanggalselesai12=$surat12;
		 }else{
		  $tanggalselesai12=$suratedit12;
		 }
		  $qholiday12="select count(date) libur from tmholiday where date between '$tanggalterima12' and '$tanggalselesai12'";
$exeholiday12 = mysql_query($qholiday12);
                    while($rowholiday12 = mysql_fetch_assoc($exeholiday12)){
				$holidayperizin12 = $rowholiday12['libur'];
				
					$date1 = new DateTime($tanggalselesai12); 
					  $date12 = new DateTime($tanggalterima12); 
					 
					$interval = $date12->diff($date1);

					$selisihhari12 = $interval->format('%R%a');
//-------------------------------------------------------------------selisih hari
$shari12 = substr($selisihhari12, 1,12);
					
					$realisasi12 = $shari12 - $holidayperizin12;
					$totalrealisasi12+=$realisasi12;
					
					$tot12=count($realisasi12);
					$tt12 +=$tot12;
				
$perkec12=($waktu12 - $realisasi12)/$waktu12 * 100;

$ratatotalrealisasi12=$totalrealisasi12/$tt12;
		
					
						$ttperkec12 +=$perkec12;
					
		 }
		
		 }
		
}
		
$persenkecepatan12 = 0;
if($ttperkec12==0 or $tt12==0){
$persenkecepatan12=0;
}else{
$persenkecepatan12 =$ttperkec12/$tt12;

}
?>
<td align="center">

<?php echo round($persenkecepatan12);echo ' %';?>
</td>
	<?				
					$ttperkec12=0;
$tt12=0;
$totalrealisasi12=0;
$ratatotalrealisasi12=0;	
					
			?>
			<?php 
			//---------------------------------------------akhir kecepatan 12
			//------------------------------------------awal total kecepatan
			
	?>
	<?
 $exeizin13 = mysql_query($qizin);
                   
                    while($rowizin13 = mysql_fetch_assoc($exeizin13)){
					if($rowizin13 >0){
		 $tanggalterima13=$rowizin13['terima'];
		$surat13=$rowizin13['tgl_surat'];
		$suratedit13=$rowizin13['tgl_surat_edit'];
		$waktu13=$rowizin13['durasi'];
		 if ($suratedit13=='0000-00-00'){
		 $tanggalselesai13=$surat13;
		 }else{
		  $tanggalselesai13=$suratedit13;
		 }
		  $qholiday13="select count(date) libur from tmholiday where date between '$tanggalterima13' and '$tanggalselesai13'";
$exeholiday13 = mysql_query($qholiday13);
                    while($rowholiday13 = mysql_fetch_assoc($exeholiday13)){
				$holidayperizin13 = $rowholiday13['libur'];
				
					$date1 = new DateTime($tanggalselesai13); 
					  $date13 = new DateTime($tanggalterima13); 
					 
					$interval = $date13->diff($date1);

					$selisihhari13 = $interval->format('%R%a');
//-------------------------------------------------------------------selisih hari
$shari13 = substr($selisihhari13, 1,13);
					
					$realisasi13 = $shari13 - $holidayperizin13;
					$totalrealisasi13+=$realisasi13;
					
					$tot13=count($realisasi13);
					$tt13 +=$tot13;
				
$perkec13=($waktu13 - $realisasi13)/$waktu13 * 100;

$ratatotalrealisasi13=$totalrealisasi13/$tt13;
		
					
						$ttperkec13 +=$perkec13;
					
		 }
		
		 }
		
}
		
$persenkecepatan13 = 0;
if($ttperkec13==0 or $tt13==0){
$persenkecepatan13=0;
}else{
$persenkecepatan13 =$ttperkec13/$tt13;

}
?>
<td align="center">

<?php echo round($persenkecepatan13);echo ' %';?>
</td>
		<?			
					$ttperkec13=0;
$tt13=0;
$totalrealisasi13=0;
$ratatotalrealisasi13=0;	
$totalpenyelesaianpengaduan=0;
					
			?>
			<?php 
			//---------------------------------------------akhir kecepatan 13
	?>
		<?
									
			//-------------------------------------------------------------------akhir tingkat kecepatan
			
			//----------------------------------------------------awal pengaduan
			
			?>
									    <tr>
									<td align="center">7</td>
									<td align="left">TINGKAT PENYELESAIAN PENGADUAN</td>
									<?php 
	
									$sql1="SELECT count(id) jumlah FROM tmpesan 
											where YEAR(d_entry) = '$tgla' and MONTH(d_entry) =";
									$sql2="SELECT count(id) jumlah FROM tmpesan 
											where c_tindak_lanjut='Ya' and YEAR(d_entry) = '$tgla' and MONTH(d_entry) =";
											
									$sqlpengaduan1="$sql1 '01'";
									$sqlpengaduan2="$sql1 '02'";
									$sqlpengaduan3="$sql1 '03'";
									$sqlpengaduan4="$sql1 '04'";
									$sqlpengaduan5="$sql1 '05'";
									$sqlpengaduan6="$sql1 '06'";
									$sqlpengaduan7="$sql1 '07'";
									$sqlpengaduan8="$sql1 '08'";
									$sqlpengaduan9="$sql1 '09'";
									$sqlpengaduan10="$sql1 '10'";
									$sqlpengaduan11="$sql1 '11'";
									$sqlpengaduan12="$sql1 '12'";
									
									$sqlpenyelesaianpengaduan1="$sql2 '01'";
									$sqlpenyelesaianpengaduan2="$sql2 '02'";
									$sqlpenyelesaianpengaduan3="$sql2 '03'";
									$sqlpenyelesaianpengaduan4="$sql2 '04'";
									$sqlpenyelesaianpengaduan5="$sql2 '05'";
									$sqlpenyelesaianpengaduan6="$sql2 '06'";
									$sqlpenyelesaianpengaduan7="$sql2 '07'";
									$sqlpenyelesaianpengaduan8="$sql2 '08'";
									$sqlpenyelesaianpengaduan9="$sql2 '09'";
									$sqlpenyelesaianpengaduan10="$sql2 '10'";
									$sqlpenyelesaianpengaduan11="$sql2 '11'";
									$sqlpenyelesaianpengaduan12="$sql2 '12'";
									
									$hasilsqlpengaduan1 = mysql_query($sqlpengaduan1);
									while ($datapengaduan1 = mysql_fetch_assoc(@$hasilsqlpengaduan1)){
									$p1 = $datapengaduan1['jumlah'];
									}
									$hasilsqlpengaduan2 = mysql_query($sqlpengaduan2);
									while ($datapengaduan2 = mysql_fetch_assoc(@$hasilsqlpengaduan2)){
									$p2 = $datapengaduan2['jumlah'];
									}
									$hasilsqlpengaduan3 = mysql_query($sqlpengaduan3);
									while ($datapengaduan3 = mysql_fetch_assoc(@$hasilsqlpengaduan3)){
									$p3 = $datapengaduan3['jumlah'];
									}
									$hasilsqlpengaduan4 = mysql_query($sqlpengaduan4);
									while ($datapengaduan4 = mysql_fetch_assoc(@$hasilsqlpengaduan4)){
									$p4 = $datapengaduan4['jumlah'];
									}
									$hasilsqlpengaduan5 = mysql_query($sqlpengaduan5);
									while ($datapengaduan5 = mysql_fetch_assoc(@$hasilsqlpengaduan5)){
									$p5 = $datapengaduan5['jumlah'];
									}
									$hasilsqlpengaduan6 = mysql_query($sqlpengaduan6);
									while ($datapengaduan6 = mysql_fetch_assoc(@$hasilsqlpengaduan6)){
									$p6 = $datapengaduan6['jumlah'];
									}
									$hasilsqlpengaduan7 = mysql_query($sqlpengaduan7);
									while ($datapengaduan7 = mysql_fetch_assoc(@$hasilsqlpengaduan7)){
									$p7 = $datapengaduan7['jumlah'];
									}
									$hasilsqlpengaduan8 = mysql_query($sqlpengaduan8);
									while ($datapengaduan8 = mysql_fetch_assoc(@$hasilsqlpengaduan8)){
									$p8 = $datapengaduan8['jumlah'];
									}
									$hasilsqlpengaduan9 = mysql_query($sqlpengaduan9);
									while ($datapengaduan9 = mysql_fetch_assoc(@$hasilsqlpengaduan9)){
									$p9 = $datapengaduan9['jumlah'];
									}
									$hasilsqlpengaduan10 = mysql_query($sqlpengaduan10);
									while ($datapengaduan10 = mysql_fetch_assoc(@$hasilsqlpengaduan10)){
									$p10 = $datapengaduan10['jumlah'];
									}
									$hasilsqlpengaduan11 = mysql_query($sqlpengaduan11);
									while ($datapengaduan11 = mysql_fetch_assoc(@$hasilsqlpengaduan11)){
									$p11 = $datapengaduan11['jumlah'];
									}
									$hasilsqlpengaduan12 = mysql_query($sqlpengaduan12);
									while ($datapengaduan12 = mysql_fetch_assoc(@$hasilsqlpengaduan12)){
									$p12 = $datapengaduan12['jumlah'];
									}
									
																		$hasilpenyelesaiansqlpenyelesaianpengaduan1 = mysql_query($sqlpenyelesaianpengaduan1);
									while ($datapenyelesaian1 = mysql_fetch_assoc(@$hasilpenyelesaiansqlpenyelesaianpengaduan1)){
									$pp1 = $datapenyelesaian1['jumlah'];
									}
									$hasilpenyelesaiansqlpenyelesaianpengaduan2 = mysql_query($sqlpenyelesaianpengaduan2);
									while ($datapenyelesaian2 = mysql_fetch_assoc(@$hasilpenyelesaiansqlpenyelesaianpengaduan2)){
									$pp2 = $datapenyelesaian2['jumlah'];
									}
									$hasilpenyelesaiansqlpenyelesaianpengaduan3 = mysql_query($sqlpenyelesaianpengaduan3);
									while ($datapenyelesaian3 = mysql_fetch_assoc(@$hasilpenyelesaiansqlpenyelesaianpengaduan3)){
									$pp3 = $datapenyelesaian3['jumlah'];
									}
									$hasilpenyelesaiansqlpenyelesaianpengaduan4 = mysql_query($sqlpenyelesaianpengaduan4);
									while ($datapenyelesaian4 = mysql_fetch_assoc(@$hasilpenyelesaiansqlpenyelesaianpengaduan4)){
									$pp4 = $datapenyelesaian4['jumlah'];
									}
									$hasilpenyelesaiansqlpenyelesaianpengaduan5 = mysql_query($sqlpenyelesaianpengaduan5);
									while ($datapenyelesaian5 = mysql_fetch_assoc(@$hasilpenyelesaiansqlpenyelesaianpengaduan5)){
									$pp5 = $datapenyelesaian5['jumlah'];
									}
									$hasilpenyelesaiansqlpenyelesaianpengaduan6 = mysql_query($sqlpenyelesaianpengaduan6);
									while ($datapenyelesaian6 = mysql_fetch_assoc(@$hasilpenyelesaiansqlpenyelesaianpengaduan6)){
									$pp6 = $datapenyelesaian6['jumlah'];
									}
									$hasilpenyelesaiansqlpenyelesaianpengaduan7 = mysql_query($sqlpenyelesaianpengaduan7);
									while ($datapenyelesaian7 = mysql_fetch_assoc(@$hasilpenyelesaiansqlpenyelesaianpengaduan7)){
									$pp7 = $datapenyelesaian7['jumlah'];
									}
									$hasilpenyelesaiansqlpenyelesaianpengaduan8 = mysql_query($sqlpenyelesaianpengaduan8);
									while ($datapenyelesaian8 = mysql_fetch_assoc(@$hasilpenyelesaiansqlpenyelesaianpengaduan8)){
									$pp8 = $datapenyelesaian8['jumlah'];
									}
									$hasilpenyelesaiansqlpenyelesaianpengaduan9 = mysql_query($sqlpenyelesaianpengaduan9);
									while ($datapenyelesaian9 = mysql_fetch_assoc(@$hasilpenyelesaiansqlpenyelesaianpengaduan9)){
									$pp9 = $datapenyelesaian9['jumlah'];
									}
									$hasilpenyelesaiansqlpenyelesaianpengaduan10 = mysql_query($sqlpenyelesaianpengaduan10);
									while ($datapenyelesaian10 = mysql_fetch_assoc(@$hasilpenyelesaiansqlpenyelesaianpengaduan10)){
									$pp10 = $datapenyelesaian10['jumlah'];
									}
									$hasilpenyelesaiansqlpenyelesaianpengaduan11 = mysql_query($sqlpenyelesaianpengaduan11);
									while ($datapenyelesaian11 = mysql_fetch_assoc(@$hasilpenyelesaiansqlpenyelesaianpengaduan11)){
									$pp11 = $datapenyelesaian11['jumlah'];
									}
									$hasilpenyelesaiansqlpenyelesaianpengaduan12 = mysql_query($sqlpenyelesaianpengaduan12);
									while ($datapenyelesaian12 = mysql_fetch_assoc(@$hasilpenyelesaiansqlpenyelesaianpengaduan12)){
									$pp12 = $datapenyelesaian12['jumlah'];
									}
									
									
									if($pp1==0 or $p1==0){
									$totpenyelesaian=0;
									}else{
									$totpenyelesaian=$pp1/$p1*100;
									}
									if($pp2==0 or $p2==0){
									$totpenyelesaian2=0;
									}else{
									$totpenyelesaian2=$pp2/$p2*100;
									}
									if($pp3==0 or $p3==0){
									$totpenyelesaian3=0;
									}else{
									$totpenyelesaian3=$pp3/$p3*100;
									}
									if($pp4==0 or $p4==0){
									$totpenyelesaian4=0;
									}else{
									$totpenyelesaian4=$pp4/$p4*100;
									}
									if($pp5==0 or $p5==0){
									$totpenyelesaian5=0;
									}else{
									$totpenyelesaian5=$pp5/$p5*100;
									}
									if($pp6==0 or $p6==0){
									$totpenyelesaian6=0;
									}else{
									$totpenyelesaian6=$pp6/$p6*100;
									}
									if($pp7==0 or $p7==0){
									$totpenyelesaian7=0;
									}else{
									$totpenyelesaian7=$pp7/$p7*100;
									}
									if($pp8==0 or $p8==0){
									$totpenyelesaian8=0;
									}else{
									$totpenyelesaian8=$pp8/$p8*100;
									}
									if($pp9==0 or $p9==0){
									$totpenyelesaian9=0;
									}else{
									$totpenyelesaian9=$pp9/$p9*100;
									}
									if($pp10==0 or $p10==0){
									$totpenyelesaian10=0;
									}else{
									$totpenyelesaian10=$pp10/$p10*100;
									}
									if($pp11==0 or $p11==0){
									$totpenyelesaian11=0;
									}else{
									$totpenyelesaian11=$pp11/$p11*100;
									}
									if($pp12==0 or $p12==0){
									$totpenyelesaian12=0;
									}else{
									$totpenyelesaian12=$pp12/$p12*100;
									}
if(($pp1+$pp2+$pp3+$pp4+$pp5+$pp6+$pp7+$pp8+$pp9+$pp10+$pp11+$pp12)==0 or ($p1+$p2+$p3+$p4+$p5+$p6+$p7+$p8+$p9+$p10+$p11+$p12)==0){
$totalpenyelesaianpengaduan=0;
}else{								
$totalpenyelesaianpengaduan=($pp1+$pp2+$pp3+$pp4+$pp5+$pp6+$pp7+$pp8+$pp9+$pp10+$pp11+$pp12)/($p1+$p2+$p3+$p4+$p5+$p6+$p7+$p8+$p9+$p10+$p11+$p12)*100;
									}
?>
									<td align="center"><?php echo round($totpenyelesaian); echo ' %';?></td>
									<td align="center"><?php echo round($totpenyelesaian2); echo ' %';?></td>
									<td align="center"><?php echo round($totpenyelesaian3); echo ' %';?></td>
									<td align="center"><?php echo round($totpenyelesaian4); echo ' %';?></td>
									<td align="center"><?php echo round($totpenyelesaian5); echo ' %';?></td>
									<td align="center"><?php echo round($totpenyelesaian6); echo ' %';?></td>
									<td align="center"><?php echo round($totpenyelesaian7); echo ' %';?></td>
									<td align="center"><?php echo round($totpenyelesaian8); echo ' %';?></td>
									<td align="center"><?php echo round($totpenyelesaian9); echo ' %';?></td>
									<td align="center"><?php echo round($totpenyelesaian10); echo ' %';?></td>
									<td align="center"><?php echo round($totpenyelesaian11); echo ' %';?></td>
									<td align="center"><?php echo round($totpenyelesaian12); echo ' %';?></td>
									<td align="center"><?php echo round($totalpenyelesaianpengaduan); echo ' %';?></td>
									</tr>
					<!---------------------------------------------------- akhir pengaduan-------------------------------------->
					<!---------------------------------------------------- awal IKM-------------------------------------->
									      <?php
			 $totalnilaiikm=0;
					//-------------------------------------------variable tahun 1 semester 1
					$s1 = 0;
					$totals1=0;
					$totals1=0;
					$pembagis1=0;
					$jumlahpembagis1=0;
					$rata2s1=0;
					
					$s2 = 0;
					$totals2=0;
					$totals2=0;
					$pembagis2=0;
					$jumlahpembagis2=0;
					$rata2s2=0;
					
					$s3 = 0;
					$totals3=0;
					$totals3=0;
					$pembagis3=0;
					$jumlahpembagis3=0;
					$rata2s3=0;
					
					$s4 = 0;
					$totals4=0;
					$totals4=0;
					$pembagis4=0;
					$jumlahpembagis4=0;
					$rata2s4=0;
					
					$s5 = 0;
					$totals5=0;
					$totals5=0;
					$pembagis5=0;
					$jumlahpembagis5=0;
					$rata2s5=0;
					
					$s6 = 0;
					$totals6=0;
					$totals6=0;
					$pembagis6=0;
					$jumlahpembagis6=0;
					$rata2s6=0;
					
					$s7 = 0;
					$totals7=0;
					$totals7=0;
					$pembagis7=0;
					$jumlahpembagis7=0;
					$rata2s7=0;
					
					$s8 = 0;
					$totals8=0;
					$totals8=0;
					$pembagis8=0;
					$jumlahpembagis8=0;
					$rata2s8=0;
					
					$s9 = 0;
					$totals9=0;
					$totals9=0;
					$pembagis9=0;
					$jumlahpembagis9=0;
					$rata2s9=0;
					
					$s10 = 0;
					$totals10=0;
					$totals10=0;
					$pembagis10=0;
					$jumlahpembagis10=0;
					$rata2s10=0;
					
					$s11 = 0;
					$totals11=0;
					$totals11=0;
					$pembagis11=0;
					$jumlahpembagis11=0;
					$rata2s11=0;
					
					$s12 = 0;
					$totals12=0;
					$totals12=0;
					$pembagis12=0;
					$jumlahpembagis12=0;
					$rata2s12=0;
					
					$s13 = 0;
					$totals13=0;
					$totals13=0;
					$pembagis13=0;
					$jumlahpembagis13=0;
					$rata2s13=0;
					
					$s14 = 0;
					$totals14=0;
					$totals14=0;
					$pembagis14=0;
					$jumlahpembagis14=0;
					$rata2s14=0;
					
					//-------------------------------------------variable tahun 1 semester 2
					
						$ss1 = 0;
					$totalss1=0;
					$totalss1=0;
					$pembagiss1=0;
					$jumlahpembagiss1=0;
					$rata2ss1=0;
					
					$ss2 = 0;
					$totalss2=0;
					$totalss2=0;
					$pembagiss2=0;
					$jumlahpembagiss2=0;
					$rata2ss2=0;
					
					$ss3 = 0;
					$totalss3=0;
					$totalss3=0;
					$pembagiss3=0;
					$jumlahpembagiss3=0;
					$rata2ss3=0;
					
					$ss4 = 0;
					$totalss4=0;
					$totalss4=0;
					$pembagiss4=0;
					$jumlahpembagiss4=0;
					$rata2ss4=0;
					
					$ss5 = 0;
					$totalss5=0;
					$totalss5=0;
					$pembagiss5=0;
					$jumlahpembagiss5=0;
					$rata2ss5=0;
					
					$ss6 = 0;
					$totalss6=0;
					$totalss6=0;
					$pembagiss6=0;
					$jumlahpembagiss6=0;
					$rata2ss6=0;
					
					$ss7 = 0;
					$totalss7=0;
					$totalss7=0;
					$pembagiss7=0;
					$jumlahpembagiss7=0;
					$rata2ss7=0;
					
					$ss8 = 0;
					$totalss8=0;
					$totalss8=0;
					$pembagiss8=0;
					$jumlahpembagiss8=0;
					$rata2ss8=0;
					
					$ss9 = 0;
					$totalss9=0;
					$totalss9=0;
					$pembagiss9=0;
					$jumlahpembagiss9=0;
					$rata2ss9=0;
					
					$ss10 = 0;
					$totalss10=0;
					$totalss10=0;
					$pembagiss10=0;
					$jumlahpembagiss10=0;
					$rata2ss10=0;
					
					$ss11 = 0;
					$totalss11=0;
					$totalss11=0;
					$pembagiss11=0;
					$jumlahpembagiss11=0;
					$rata2ss11=0;
					
					$ss12 = 0;
					$totalss12=0;
					$totalss12=0;
					$pembagiss12=0;
					$jumlahpembagiss12=0;
					$rata2ss12=0;
					
					$ss13 = 0;
					$totalss13=0;
					$totalss13=0;
					$pembagiss13=0;
					$jumlahpembagiss13=0;
					$rata2ss13=0;
					
					$ss14 = 0;
					$totalss14=0;
					$totalss14=0;
					$pembagiss14=0;
					$jumlahpembagiss14=0;
					$rata2ss14=0;
					
					
					
					$query_sektor = "select * from trsektor order by id asc";
                    $resultssektor = mysql_query($query_sektor);
                    while ($datasektor = mysql_fetch_assoc(@$resultssektor)){
					$bidangizin=$datasektor['id'];
					//echo $bidangizin;
                    
					$query_data = "
					select * from tmikmnilai a 
					inner join trsektor b on b.id=a.sektor_id where a.sektor_id=$bidangizin and a.semester=1 and a.tahun=$tgla";
                    $results = mysql_query($query_data);
                    while ($data = mysql_fetch_assoc(@$results)){
					
					$s1 = $data['u1'];
					$totals1+=$s1;
					$pembagis1=count($s1);
					$jumlahpembagis1+=$pembagis1;
					
					$s2 = $data['u2'];
					$totals2+=$s2;
					$pembagis2=count($s2);
					$jumlahpembagis2+=$pembagis2;
					
					$s3 = $data['u3'];
					$totals3+=$s3;
					$pembagis3=count($s3);
					$jumlahpembagis3+=$pembagis3;
					
					$s4 = $data['u4'];
					$totals4+=$s4;
					$pembagis4=count($s4);
					$jumlahpembagis4+=$pembagis4;
					
					$s5 = $data['u5'];
					$totals5+=$s5;
					$pembagis5=count($s5);
					$jumlahpembagis5+=$pembagis5;
					
					$s6 = $data['u6'];
					$totals6+=$s6;
					$pembagis6=count($s6);
					$jumlahpembagis6+=$pembagis6;
					
					$s7 = $data['u7'];
					$totals7+=$s7;
					$pembagis7=count($s7);
					$jumlahpembagis7+=$pembagis7;
					
					$s8 = $data['u8'];
					$totals8+=$s8;
					$pembagis8=count($s8);
					$jumlahpembagis8+=$pembagis8;
					
					$s9 = $data['u9'];
					$totals9+=$s9;
					$pembagis9=count($s9);
					$jumlahpembagis9+=$pembagis9;
					
					$s10 = $data['u10'];
					$totals10+=$s10;
					$pembagis10=count($s10);
					$jumlahpembagis10+=$pembagis10;
					
					$s11 = $data['u11'];
					$totals11+=$s11;
					$pembagis11=count($s11);
					$jumlahpembagis11+=$pembagis11;
					
					$s12 = $data['u12'];
					$totals12+=$s12;
					$pembagis12=count($s12);
					$jumlahpembagis12+=$pembagis12;
					
					$s13 = $data['u13'];
					$totals13+=$s13;
					$pembagis13=count($s13);
					$jumlahpembagis13+=$pembagis13;
					
					$s14 = $data['u14'];
					$totals14+=$s14;
					$pembagis14=count($s14);
					$jumlahpembagis14+=$pembagis14;
		
	
		 }
		 
		 $query_data2 = "
					select * from tmikmnilai a 
					inner join trsektor b on b.id=a.sektor_id where a.sektor_id=$bidangizin and a.semester=2 and a.tahun=$tgla";
                    $results2 = mysql_query($query_data2);
                    while ($data2 = mysql_fetch_assoc(@$results2)){
					
					$ss1 = $data2['u1'];
					$totalss1+=$ss1;
					$pembagiss1=count($ss1);
					$jumlahpembagiss1+=$pembagiss1;
					
					$ss2 = $data2['u2'];
					$totalss2+=$ss2;
					$pembagiss2=count($ss2);
					$jumlahpembagiss2+=$pembagiss2;
					
					$ss3 = $data2['u3'];
					$totalss3+=$ss3;
					$pembagiss3=count($ss3);
					$jumlahpembagiss3+=$pembagiss3;
					
					$ss4 = $data2['u4'];
					$totalss4+=$ss4;
					$pembagiss4=count($ss4);
					$jumlahpembagiss4+=$pembagiss4;
					
					$ss5 = $data2['u5'];
					$totalss5+=$ss5;
					$pembagiss5=count($ss5);
					$jumlahpembagiss5+=$pembagiss5;
					
					$ss6 = $data2['u6'];
					$totalss6+=$ss6;
					$pembagiss6=count($ss6);
					$jumlahpembagiss6+=$pembagiss6;
					
					$ss7 = $data2['u7'];
					$totalss7+=$ss7;
					$pembagiss7=count($ss7);
					$jumlahpembagiss7+=$pembagiss7;
					
					$ss8 = $data2['u8'];
					$totalss8+=$ss8;
					$pembagiss8=count($ss8);
					$jumlahpembagiss8+=$pembagiss8;
					
					$ss9 = $data2['u9'];
					$totalss9+=$ss9;
					$pembagiss9=count($ss9);
					$jumlahpembagiss9+=$pembagiss9;
					
					$ss10 = $data2['u10'];
					$totalss10+=$ss10;
					$pembagiss10=count($ss10);
					$jumlahpembagiss10+=$pembagiss10;
					
					$ss11 = $data2['u11'];
					$totalss11+=$ss11;
					$pembagiss11=count($ss11);
					$jumlahpembagiss11+=$pembagiss11;
					
					$ss12 = $data2['u12'];
					$totalss12+=$ss12;
					$pembagiss12=count($ss12);
					$jumlahpembagiss12+=$pembagiss12;
					
					$ss13 = $data2['u13'];
					$totalss13+=$ss13;
					$pembagiss13=count($ss13);
					$jumlahpembagiss13+=$pembagiss13;
					
					$ss14 = $data2['u14'];
					$totalss14+=$ss14;
					$pembagiss14=count($ss14);
					$jumlahpembagiss14+=$pembagiss14;
					
		 }
		
		 }
		//-------------------------------------------------tahun pertama semester1
		$pembagis1=$jumlahpembagis1;
		if($totals1==0 || $pembagis1==0){
		$rata2s1=0;
		}else{
		$rata2s1=$totals1/$pembagis1;
		}
		
		$pembagis2=$jumlahpembagis2;
		if($totals2==0 || $pembagis2==0){
		$rata2s2=0;
		}else{
		$rata2s2=$totals2/$pembagis2;
		}
		
		$pembagis3=$jumlahpembagis3;
		if($totals3==0 || $pembagis3==0){
		$rata2s3=0;
		}else{
		$rata2s3=$totals3/$pembagis3;
		}
		
		$pembagis4=$jumlahpembagis4;
		if($totals4==0 || $pembagis4==0){
		$rata2s4=0;
		}else{
		$rata2s4=$totals4/$pembagis4;
		}
		
		$pembagis5=$jumlahpembagis5;
		if($totals5==0 || $pembagis5==0){
		$rata2s5=0;
		}else{
		$rata2s5=$totals5/$pembagis5;
		}
		
		$pembagis6=$jumlahpembagis6;
		if($totals6 == 0 || $pembagis6==0){
		$rata2s6=0;
		}else{
		$rata2s6=$totals6/$pembagis6;
		}
		
		$pembagis7=$jumlahpembagis7;
		if($totals7==0 || $pembagis7==0){
		$rata2s7=0;
		}else{
		$rata2s7=$totals7/$pembagis7;
		}
		
		$pembagis8=$jumlahpembagis8;
		if($totals8==0 || $pembagis8==0){
		$rata2s8=0;
		}else{
		$rata2s8=$totals8/$pembagis8;
		}
		
		$pembagis9=$jumlahpembagis9;
		if($totals9==0 || $pembagis9==0){
		$rata2s9=0;
		}else{
		$rata2s9=$totals9/$pembagis9;
		}
		
		$pembagis10=$jumlahpembagis10;
		if($totals10==0 || $pembagis10==0){
		$rata2s10=0;
		}else{
		$rata2s10=$totals10/$pembagis10;
		}
		
		$pembagis11=$jumlahpembagis11;
		if($totals11==0 || $pembagis11==0){
		$rata2s11=0;
		}else{
		$rata2s11=$totals11/$pembagis11;
		}
		
		$pembagis12=$jumlahpembagis12;
		if($totals12==0 || $pembagis12==0){
		$rata2s12=0;
		}else{
		$rata2s12=$totals12/$pembagis12;
		}
		
		$pembagis13=$jumlahpembagis13;
		if($totals13==0 || $pembagis13==0){
		$rata2s13=0;
		}else{
		$rata2s13=$totals13/$pembagis13;
		}
		
		$pembagis14=$jumlahpembagis14;
		if($totals14==0 || $pembagis14==0){
		$rata2s14=0;
		}else{
		$rata2s14=$totals14/$pembagis14;
		}
		//------------------------------------------------akhir tahun kategori 1 semester 1
		//-------------------------------------------------tahun pertama semester 2
		$pembagiss1=$jumlahpembagiss1;
		if($totalss1==0 || $pembagiss1==0){
		$rata2ss1=0;
		}else{
		$rata2ss1=$totalss1/$pembagiss1;
		}
		
		$pembagiss2=$jumlahpembagiss2;
		if($totalss2==0 || $pembagiss2==0){
		$rata2ss2=0;
		}else{
		$rata2ss2=$totalss2/$pembagiss2;
		}
		
		$pembagiss3=$jumlahpembagiss3;
		if($totalss3==0 || $pembagiss3==0){
		$rata2ss3=0;
		}else{
		$rata2ss3=$totalss3/$pembagiss3;
		}
		
		$pembagiss4=$jumlahpembagiss4;
		if($totalss4==0 || $pembagiss4==0){
		$rata2ss4=0;
		}else{
		$rata2ss4=$totalss4/$pembagiss4;
		}
		
		$pembagiss5=$jumlahpembagiss5;
		if($totalss5==0 || $pembagiss5==0){
		$rata2ss5=0;
		}else{
		$rata2ss5=$totalss5/$pembagiss5;
		}
		
		$pembagiss6=$jumlahpembagiss6;
		if($totalss6==0 || $pembagiss6==0){
		$rata2ss6=0;
		}else{
		$rata2ss6=$totalss6/$pembagiss6;
		}
		
		$pembagiss7=$jumlahpembagiss7;
		if($totalss7==0 || $pembagiss7==0){
		$rata2ss7=0;
		}else{
		$rata2ss7=$totalss7/$pembagiss7;
		}
		
		$pembagiss8=$jumlahpembagiss8;
		if($totalss8==0 || $pembagiss8==0){
		$rata2ss8=0;
		}else{
		$rata2ss8=$totalss8/$pembagiss8;
		}
		
		$pembagiss9=$jumlahpembagiss9;
		if($totalss9==0 || $pembagiss9==0){
		$rata2ss9=0;
		}else{
		$rata2ss9=$totalss9/$pembagiss9;
		}
		
		$pembagiss10=$jumlahpembagiss10;
		if($totalss10==0 || $pembagiss10==0){
		$rata2ss10=0;
		}else{
		$rata2ss10=$totalss10/$pembagiss10;
		}
		
		$pembagiss11=$jumlahpembagiss11;
		if($totalss11==0 || $pembagiss11==0){
		$rata2ss11=0;
		}else{
		$rata2ss11=$totalss11/$pembagiss11;
		}
		
		$pembagiss12=$jumlahpembagiss12;
		if($totalss12==0 || $pembagiss12==0){
		$rata2ss12=0;
		}else{
		$rata2ss12=$totalss12/$pembagiss12;
		}
		
		$pembagiss13=$jumlahpembagiss13;
		if($totalss13==0 || $pembagiss13==0){
		$rata2ss13=0;
		}else{
		$rata2ss13=$totalss13/$pembagiss13;
		}
		
		$pembagiss14=$jumlahpembagiss14;
		if($totalss14==0 || $pembagiss14==0){
		$rata2ss14=0;
		}else{
		$rata2ss14=$totalss14/$pembagiss14;
		}
		//------------------------------------------------akhir tahun kategori 1 semester 2
		
					
		 ?>
		
					
						
						
						<?php 
						$ratanilais1= ($rata2s1+$rata2s2+$rata2s3+$rata2s4+$rata2s5+$rata2s6+$rata2s7+$rata2s8+$rata2s9+$rata2s10+$rata2s11+$rata2s12+$rata2s13+$rata2s14)/14;
						//echo substr($ratanilais1,0,5);  ?></b></td>
						<b>
						<?php 
					
						$ratanilais2= ($rata2ss1+$rata2ss2+$rata2ss3+$rata2ss4+$rata2ss5+$rata2ss6+$rata2ss7+$rata2ss8+$rata2ss9+$rata2ss10+$rata2ss11+$rata2ss12+$rata2ss13+$rata2ss14)/14;
						//echo substr($ratanilais2,0,5); 
						?>
						<?php 
						if($ratanilais1 > 0 and $ratanilais1<=43.75){
						$mutu1= ' (D)';
						}else if ($ratanilais1 >=43.76 and $ratanilais1 <=62.50) {
						$mutu1= ' (C)';
						}else if ($ratanilais1 >=62.51 and $ratanilais1 <=81.25) {
						$mutu1= ' (B)';
						}else if ($ratanilais1 >=81.26) {
						$mutu1= ' (A)';
						}else if($ratanilais1 == 0){
						$mutu1=' - ';
						}
						//echo $mutu1;  ?></b>
						
						<?php 
					if($ratanilais2 > 0 and $ratanilais2<=43.75){
						$mutu2= ' (D)';
						}else if ($ratanilais2 >=43.76 and $ratanilais2 <=62.50) {
						$mutu2= ' (C)';
						}else if ($ratanilais2 >=62.51 and $ratanilais2 <=81.25) {
						$mutu2= ' (B)';
						}else if ($ratanilais2 >=81.26) {
						$mutu2= ' (A)';
						}else if($ratanilais2 == 0){
						$mutu2=' - ';
						}
						
						if($ratanilais1 !=0 and $ratanilais2!=0){
						$totalnilaiikm= ($ratanilais1 + $ratanilais2)/2;
						}else if($ratanilais1 !=0 and $ratanilais2 ==0){
						$totalnilaiikm=$ratanilais1;
						}else if($ratanilais1 ==0 and $ratanilais2 !=0){
						$totalnilaiikm=$ratanilais2;
						}else if ($ratanilais1 ==0 and $ratanilais2 ==0){
						$totalnilaiikm=0;
						}
						
						//echo $mutu2;  ?></b>
					
										<tr>
									<td align="center">8</td>
									<td align="left">INDEKS KEPUASAN MASYARAKAT</td>
									<td align="center">-</td>
									<td align="center">-</td>
									<td align="center">-</td>
									<td align="center">-</td>
									<td align="center">-</td>
									<td align="center">
									<?php 
									echo number_format($ratanilais1,2);
									//echo $mutu1;?>
									</td>
									<td align="center">-</td>
									<td align="center">-</td>
									<td align="center">-</td>
									<td align="center">-</td>
									<td align="center">-</td>
									<td align="center">
									<?php 
									echo number_format($ratanilais2,2);
									//echo $mutu2; 
									
									?> 
									</td>
									<td align="center"><?php echo number_format($totalnilaiikm,2); ?></td>
									</tr>
					<!--------------------------------------------------- akhir IKM --------------------------------------->				
								</table>


                            </fieldset>

		              
                </div>

            </form>
        </div>
    </div>
</body>
</html>
