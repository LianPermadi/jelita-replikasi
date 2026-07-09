<?php
		header("Content-Type: application/vnd.ms-word");
       header("Expires: 0");
        header("Cache-Control:  must-revalidate, post-check=0, pre-check=0");
       // header("Content-disposition: attachment; filename=Perngaduan Pertriwulan Tahun '.  $this->input->post('tgla').doc");
        header("Content-disposition: attachment; filename=Resume Evaluasi Izin $tgla-$tglb.xls");
		
	?>
<html>
<head>
<title>Realisasi Penerimaan</title>
</head>

<body>
    <div id="content">
    <div class="post">
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
			<div>
            <h2><b><font  size="12px" color="#1A1A1A"><?php echo $page_name; ?></b></h2>
			</div>
			
            <form name="form1" method="post">

				<div class="entry">
                  

                            <fieldset>
                                <legend style="color: #045000" align="center"><font size="12px" color="#1A1A1A"><center>
                                    <?php
                                     echo 'Periode '. $this->lib_date->mysql_to_human($tgla)." - ".$this->lib_date->mysql_to_human($tglb);
//                                    echo 'Realisasi Penerimaan Tahun '.$list_tahun->d_tahun;
                                    ?>
                                </legend>
                               



								<table align="center" width="90%" border="1" class="display" cellpadding="0" cellspacing="0" id="roygrid">
                                    <thead><tr class="title">
                                        <th align="center" ><font size="12px" color="#1A1A1A">No</font></th>
                                        <th width="35%" align="center" ><font size="12px" color="#1A1A1A">Sektor Perizinan</font></th>
										 <th width="17%" align="center" ><font size="12px" color="#1A1A1A">Tingkat Penyelesaian</font></th>
										<th width="17%"align="center" ><font size="12px" color="#1A1A1A"><? echo 'Tingkat Ketepatan Durasi' ?></font></th>
									<th width="17%" align="center" ><font size="12px" color="#1A1A1A"><? echo 'Tingkat Kecepatan'; ?></font></th>
										 <th width="17%" align="center" ><font size="12px" color="#1A1A1A"><? echo 'Nilai IKM';?></font></th>
                                    </tr></thead>
                                    
                                       
										<?
                                       
										//$obj = $this->permohonan;
										//$jumlah = $obj->where_related("trstspermohonan", 'id <> 1')->where("trsektor_id = '$list_sektor' AND d_terima_berkas >= '$first_date' AND //d_terima_berkas <= '$second_date'")->count();
$total_selesai=0;
$total_tepat=0;
$total_telat=0;
$total=0;
$tidaksesuai=0;
$totaltolak=0;
$totalterima=0;
 $jumlah_masuk = 0;
                        $jumlah_terbit = 0;
                        $terbit_ambil = 0;
                        $terbit_proses = 0;
                        $jumlah_tolak = 0;
                        $tolak_ambil = 0;
                        $tolak_proses = 0;
						$totals=0;
$totk=0;
$tingkatkecepatan=0;
$tottingkatkecepatan=0;
$totpembagi=0;
                        $jumlah_proses = 0;
						$ttselesai=0;
						$ttjumlahdurasi=0;
                        $jumlahtotalkecepatan=0;
						$jumlahpembagikecepatan=0;
						$jumpembagi=null;
						$i=1;
$jumlah=0;
$tt=0;
$ttperkec=0;
$waktu=0;
$realisasi=0;
$i = 0;
										$i++;
                                        $query_data = "select id, n_sektor from trsektor order by id ASC";
                                        $hasil_data = mysql_query($query_data);
                                       
                                        while ($data = mysql_fetch_assoc(@$hasil_data)){
                                         //  $i++;
										   $jumlah = 0;
                                            $izin = new trperizinan();
                                            $izin->get_by_id($data['id']);
											$kd_sektor = $izin->id;
                                            $sektor = new trsektor();
                                            $sektor->get_by_id($data['id']);
                                            $list_sektor = $sektor->id;

                                            //$permohonan = new tmpermohonan();
										    //$jumlah = $permohonan->where_related("trstspermohonan", 'id <>1' )->where("trsektor_id = '$list_sektor' AND d_terima_berkas between '$tgla' and '$tglb'")->count();
                                            //$total = $total + $jumlah;
                                            //$f_jumlah = intval($jumlah);
											//$f_total = intval($total);
											
?>
											<tr>
                                                <td  align="center"> <font size="12px" color="#1A1A1A"><?php 
												
												echo $i; ?></font> </td>
                                                <td > <font size="12px" color="#1A1A1A"><?php echo $data['n_sektor']; ?></font> </td>
<?php												
	//------------------------------------awal resume
	
	
	$permohonan = new tmpermohonan();
										    $jumlah = $permohonan->where_related("trstspermohonan", 'id <>1' )->where("trsektor_id = '$list_sektor' AND d_terima_berkas between '$tgla' and '$tglb'")->count();
                                            $total = $total + $jumlah;
                                            $f_jumlah = intval($jumlah);
                                            $f_total = intval($total);
										
                                      
										?>
                                    
                                             
                                              
												<?
											$idsektor=$data['id'];
											$bidangizin=$idsektor;
							
$query_datastatus="select count(a.id) jumlahizin, a.c_izin_selesai, d.c_penetapan, d.status_bap from tmpermohonan a
                                inner join tmpermohonan_trperizinan b on a.id = b.tmpermohonan_id
                                inner join tmbap_tmpermohonan c on a.id = c.tmpermohonan_id
                                inner join tmbap d on d.id = c.tmbap_id
								
								inner join trperizinan e on e.id = b.trperizinan_id
								inner join tmpermohonan_tmsk h on a.id = h.tmpermohonan_id
inner join tmsk i on h.tmsk_id = i.id
                                LEFT JOIN tmpermohonan_trstspermohonan as t6 on a.id = t6.tmpermohonan_id
                                LEFT JOIN trstspermohonan as t7 on t7.id = t6.trstspermohonan_id
                               
                                where a.trsektor_id = '$idsektor' and d.c_penetapan = 1

                                and t7.id <> 1 and
a.d_terima_berkas between '$tgla' and '$tglb' and a.trsektor_id='$idsektor'
";
$h = mysql_query($query_datastatus);
											
while ($dta = mysql_fetch_assoc(@$h)){

?>
<!--<td align="center"><font size="12px"><? echo $dta['jumlahizin']?></td>-->
<?
}

$query_data4="$query_datastatus and d.status_bap='1'";
											$hasil_data4 = mysql_query($query_data4);
											
											 while ($data4 = mysql_fetch_assoc(@$hasil_data4)){
											 $terima4=$data4['jumlahizin'];
											 $totalterima=$totalterima+$data4['jumlahizin'];
											
										?>
										
										<?
											}
											?>	
											<?
											//$qtolak=" and b.status_berkas='$hasilditolak'";
											$query_data5="$query_datastatus and d.status_bap='2'";
											$hasil_data5 = mysql_query($query_data5);
											
											 while ($data5 = mysql_fetch_assoc(@$hasil_data5)){
											 $tolak5=$data5['jumlahizin'];
											$totaltolak=$totaltolak+$data5['jumlahizin'];
										
											}
											?>	
											
                                         
                                            <?php
											if ( $jumlah==0)
											{
											$persentase=0;
											?>
											<td align="center"><font size="12px" color="#1A1A1A"><?php echo '0 %'; ?></font></td>
											<?
											}else{
										$persentase=($terima4 + $tolak5)/intval($f_jumlah)*100;
										
										?>
										
										<td  align="center"><font size="12px" color="#1A1A1A"><?php echo round($persentase);echo ' %'; ?></td>
										<?
                                        }
										if($f_total==0){
										$totalpersen=0;
										}else{
										$totalpersen=($totalterima +$totaltolak)/$f_total*100;
										}
										
	//--------------------akhir resume tingkat penyelesaian
										?>
                                           
										 		<?
		
										
											/*$idsektor=$data['id'];
											 $query = "select  count(a.id) jumlah, a.c_izin_selesai, d.c_penetapan, d.status_bap, 
											 a.d_selesai_proses,a.d_terima_berkas from tmpermohonan a
                                inner join tmpermohonan_trperizinan b on a.id = b.tmpermohonan_id
                                inner join tmbap_tmpermohonan c on a.id = c.tmpermohonan_id
                                inner join tmbap d on d.id = c.tmbap_id
								inner join tmpermohonan_tmsk h on a.id = h.tmpermohonan_id
inner join tmsk i on h.tmsk_id = i.id
								inner join trperizinan e on e.id = b.trperizinan_id
                                LEFT JOIN tmpermohonan_trstspermohonan as t6 on a.id = t6.tmpermohonan_id
                                LEFT JOIN trstspermohonan as t7 on t7.id = t6.trstspermohonan_id
                               
                                where a.trsektor_id='$idsektor' and d.c_penetapan = 1

                                and t7.id <> 1 

                                and a.d_terima_berkas between '$tgla' and '$tglb'";
											$hasil_dataselesai = mysql_query($query);
                                       
                                        while ($dataselesai = mysql_fetch_assoc(@$hasil_dataselesai)){
										$jumlah_selesai=$dataselesai['jumlah'];
										
											$total_selesai=$total_selesai+$jumlah_selesai;
										//jumlah selesai
										?>
										
										<!--<td align="center"> <font size="12px" color="grey">
										
										<?php 
										//if(intval($dataselesai['jumlah']==0)){
										//echo $dataselesai['jumlah'];
										//}else{
										
										  // echo anchor(site_url('durasisemuabidang/perbidang').'/'.$data['id'] .'/'.$tgla.'/'.$tglb.'/'.$data['n_sektor'] , $dataselesai['jumlah'],  'class="link2-wrc" rel="durasisemuabidang_box"'); 
										//}
										//echo $dataselesai['jumlah']; ?></font> </td>-->
										<?
										}
										
										
										$q3 = "select  a.id, a.c_izin_selesai, e.n_perizinan,e.v_hari,AVG(DATEDIFF(a.d_selesai_proses,a.d_terima_berkas)) rata,
				   SUM(DATEDIFF(a.d_selesai_proses,a.d_terima_berkas)<=e.v_hari) tepat from tmpermohonan a
                                inner join tmpermohonan_trperizinan b on a.id = b.tmpermohonan_id
                                inner join tmbap_tmpermohonan c on a.id = c.tmpermohonan_id
                                inner join tmbap d on d.id = c.tmbap_id
								inner join tmpermohonan_tmsk h on a.id = h.tmpermohonan_id
inner join tmsk i on h.tmsk_id = i.id
				inner join trperizinan e on e.id = b.trperizinan_id
                                LEFT JOIN tmpermohonan_trstspermohonan as t6 on a.id = t6.tmpermohonan_id
                                LEFT JOIN trstspermohonan as t7 on t7.id = t6.trstspermohonan_id
where d.c_penetapan = 1 and a.trsektor_id='$idsektor' and a.d_terima_berkas between '$tgla' and '$tglb'";
                    $exe3 = mysql_query($q3);
                   
                    while($row3 = mysql_fetch_assoc($exe3)){
					if($row3 >0){
					
         $t=$row3['tepat'];
		 $total_tepat=$total_tepat+$t;
		 //jumlah sesuai durasi
		 ?>
		  <!--<td align="center"> <font size="12px" color="grey">
		 <?php
		 //if(intval($t)==0){
			//							echo intval($t);
				//						}else{
										
					//					   echo anchor(site_url('durasisemuabidang/perbidangsesuai').'/'.$data['id'] .'/'.$tgla.'/'.$tglb.'/'.$data['n_sektor'] ,intval($t),  'class="link2-wrc" rel="durasisemuabidang_box"'); 
		//}
		 ?>
		 
		</font> </td>-->
		 
		
		 		 
		 <?php
	}
	 
		 //jumlah tidak sesuai durasi
		 //$tidaksesuai=$jumlah_selesai - $t;
		//if($jumlah_selesai==0){
		 //$tidaksesuai=0;
		 //}else{
		 //$tidaksesuai = $jumlah_selesai - $t;
		//}
		 //$total_telat=$total_telat+$tidaksesuai;
		 ?>
		  <!--<td align="center"> <font size="12px" color="grey">
		 <?php
		 //if($tidaksesuai==0){
			//							echo intval($tidaksesuai);
				//						}else{
										
					//					   echo anchor(site_url('durasisemuabidang/perbidangtelat').'/'.$data['id'] .'/'.$tgla.'/'.$tglb.'/'.$data['n_sektor'] ,intval($tidaksesuai),  'class="link2-wrc" rel="durasisemuabidang_box"'); 
		//}
		 ?>
		 
		</font> </td>-->
		
		 <?
	}
										
		 if($jumlah_selesai !=0 && $t !=0){
		 $ps= $t/$jumlah_selesai*100 ;
		 }else if($jumlah_selesai ==0 || $t ==0){
		 $ps=0;
		 }								
										
		 ?>
		 <td align="center"> <font size="12px" color="#1A1A1A"><?php echo round($ps); echo ' %'; ?></font> </td>
		 <?								
										
				 if($total_selesai !=0 && $total_tepat !=0){
		 $pstotal= $total_tepat/$total_selesai*100 ;
		 }else if($jumlah_selesai ==0 || $t ==0){
		 $pstotal=0;
		 }								
		?>							



<?php 
//}
*/


//-----------------------------awal kinerja kecepatan

				
		/*$q = "Select * from trsektor order by id ASC";
                    $exe = mysql_query($q);
                   
                    while($row = mysql_fetch_assoc($exe)){
					if($row >0){
         $bidangizin=$row['id'];
		 }*/
		?>
            
 
        

               <?php
			   /*
			   $bidangizin=$data['id'];
                   
					//$i = NULL;
                    $query_datakecepatan = "
					select a.id,a.v_hari,a.n_perizinan, a.v_perizinan jumlah from trperizinan a
                                 inner join trperizinan_trsektor b on a.id = b.trperizinan_id where b.trsektor_id='$bidangizin'";
                    $resultskecepatan = mysql_query($query_datakecepatan);
                    while ($datakecepatan = mysql_fetch_assoc(@$resultskecepatan)){
					
                        //$i++;
                        $jumlah_masuk = 0;
                        $jumlah_terbit = 0;
                        $terbit_ambil = 0;
                        $terbit_proses = 0;
                        $jumlah_tolak = 0;
                        $tolak_ambil = 0;
                        $tolak_proses = 0;
						$totals=0;
$totk=0;
$tingkatkecepatan=0;
$tottingkatkecepatan=0;
$totpembagi=0;

                        $jumlah_proses = 0;
						$ttselesai=0;
						$ttjumlahdurasi=0;
                        $jumlahtotalkecepatan=0;
						//$jumpembagi=null;
                        $querykecepatan = "select  a.id jumlah from tmpermohonan a
                                 inner join tmpermohonan_trperizinan b on a.id = b.tmpermohonan_id
                                 LEFT JOIN tmpermohonan_trstspermohonan as t6 on a.id = t6.tmpermohonan_id
                                 LEFT JOIN trstspermohonan as t7 on t7.id = t6.trstspermohonan_id
								 
                                 where b.trperizinan_id = '".$datakecepatan['id']."'
                                 and t7.id <> 1 
                                 and a.d_terima_berkas between '$tgla' and '$tglb'";
                        $hasil_datakecepatan = mysql_query($querykecepatan);
                        $jumlah_masuk = mysql_num_rows(@$hasil_datakecepatan);
                        $query2kecepatan = "select  a.id, a.c_izin_selesai, d.c_penetapan, d.status_bap, a.d_selesai_proses,a.d_terima_berkas from tmpermohonan a
                                inner join tmpermohonan_trperizinan b on a.id = b.tmpermohonan_id
                                inner join tmbap_tmpermohonan c on a.id = c.tmpermohonan_id
                                inner join tmbap d on d.id = c.tmbap_id
								inner join trperizinan e on e.id = b.trperizinan_id
								inner join tmpermohonan_tmsk h on a.id = h.tmpermohonan_id
inner join tmsk i on h.tmsk_id = i.id
                                LEFT JOIN tmpermohonan_trstspermohonan as t6 on a.id = t6.tmpermohonan_id
                                LEFT JOIN trstspermohonan as t7 on t7.id = t6.trstspermohonan_id
                               
                                where b.trperizinan_id = '".$datakecepatan['id']."' and d.c_penetapan = 1

                                and t7.id <> 1 

                          
						  and a.d_terima_berkas between '$tgla' and '$tglb'";
                        $hasil_data2kecepatan = mysql_query($query2kecepatan);
                        while ($rows_data2kecepatan = mysql_fetch_assoc(@$hasil_data2kecepatan)){
						
                            if($rows_data2kecepatan['status_bap'] == "1"){
                                $jumlah_terbit++;
                                if($rows_data2kecepatan['c_izin_selesai'] == "1") $terbit_ambil++;
                                else $terbit_proses++;
                            }else if($rows_data2kecepatan['status_bap'] == "2"){
                                $jumlah_tolak++;
                                if($rows_data2kecepatan['c_izin_selesai'] == "1") $tolak_ambil++;
                                else $tolak_proses++;
                            }
                        }
						
                        $jumlah_proses = $jumlah_masuk - ($jumlah_terbit + $jumlah_tolak);
						//$persen= 100*($jumlah_terbit / $jumlah_tolak);
						if( $jumlah_terbit != 0  or $jumlah_tolak != 0 or $jumlah_masuk!=0 ){
 $persen=(( $jumlah_terbit + $jumlah_tolak)/$jumlah_masuk)*100;
					}elseif( $jumlah_terbit == 0  && $jumlah_tolak == 0 ){
    $persen = 0;
} ;
$jumlah_selesai = $jumlah_terbit + $jumlah_tolak;

$hari = $datakecepatan['v_hari'];
$tanggal1=$rows_data2kecepatan['d_terima_berkas'];
$tanggal2=$rows_data2kecepatan['d_selesai_proses,'];?>
<?php 
//echo $tanggal1; 


//rata2 tanggal

$id2=$datakecepatan['id'];

				   $q3kecepatan = "select  a.id, a.c_izin_selesai, e.n_perizinan,e.v_hari,
				   AVG(DATEDIFF(a.d_selesai_proses,a.d_terima_berkas)) rata,
				   SUM(DATEDIFF(a.d_selesai_proses,a.d_terima_berkas)<=e.v_hari) tepat from tmpermohonan a
                                inner join tmpermohonan_trperizinan b on a.id = b.tmpermohonan_id
                                inner join tmbap_tmpermohonan c on a.id = c.tmpermohonan_id
                                inner join tmbap d on d.id = c.tmbap_id
								inner join tmpermohonan_tmsk h on a.id = h.tmpermohonan_id
inner join tmsk i on h.tmsk_id = i.id
				inner join trperizinan e on e.id = b.trperizinan_id
                                LEFT JOIN tmpermohonan_trstspermohonan as t6 on a.id = t6.tmpermohonan_id
                                LEFT JOIN trstspermohonan as t7 on t7.id = t6.trstspermohonan_id
where d.c_penetapan = 1 and e.id='$id2' and a.d_terima_berkas between '$tgla' and '$tglb'";
                    $exe3kecepatan = mysql_query($q3kecepatan);
                   
                    while($row3kecepatan = mysql_fetch_assoc($exe3kecepatan)){
					if($row3kecepatan >0){
					
         $t=$row3kecepatan['tepat'];
		 $rt=$row3kecepatan['rata'];
		 
		
	
		 }}
		
//perhitungan persen kecepatan
		
		if($jumlah_selesai==0){
		 $tingkatkecepatan=0;
		 
		 }else{
		  $tingkatkecepatan = ($hari - round($rt))/$hari*100;

				$pembagi=count($jumlah_selesai);
				
						$totpembagi +=$pembagi;
				$jumpembagi[]=$totpembagi;
				
		 }
	
		 ?>
  
                <?php
				
					// total tingkat kecepatan
					
					
					
					
					
					$totkecepatan=$tingkatkecepatan;
						$jumlahtotalkecepatan +=$totkecepatan;
						$jumkecepatan[]=number_format($jumlahtotalkecepatan);
						
						
				
				//akhir total tingkat kecepatan
                    }
					if($jumpembagi == null){
					$jumlahpembagikecepatan = 0;
					}else{
					$jumlahpembagikecepatan=array_sum($jumpembagi);
					}
					if($jumkecepatan == null){
					
					}else{
						$jmlkecepatan=array_sum($jumkecepatan);
						}

					if($jumlahpembagikecepatan != 0 and $jmlkecepatan !=0){
					
					$tottingkatkecepatan = number_format($jmlkecepatan/$jumlahpembagikecepatan);
					}else{
					$tottingkatkecepatan = 0;
					}
					
					$jumkecepatan=null;
					$jumpembagi=null;
					
					
						if ($tottingkatkecepatan < 0){
						?>
						<td align="center"><font color="red"><?php echo $tottingkatkecepatan; echo ' %'; ?></font></td>
						 
						<?
						}else{
						?>
						<td align="center"><font color="green"><?php echo $tottingkatkecepatan; echo ' %'; ?></font></td>
						 
						<?
						}
						*/
						?>
					
    
<?php 

        //}
?>
     
<!--------------------------------akhir kinerja kecepatan--

							
										
										
										/*?>
										
                                             </tr> 	
										 
                                        <tr bgcolor="#d5dffe">
                                            <td  align="center"><?php//  echo ''; ?></td>
                                            <td  align="center"><font size="12px" color="#1A1A1A">Total</font></td>
										<td  align="center"><font size="12px" color="#1A1A1A"><?php // echo round($totalpersen); ?></font></td>
                                    <!--        <td  align="center"><font size="12px" color="#1A1A1A"><?php //echo $total_selesai; ?></font></td>
											<td  align="center"><font size="12px" color="#1A1A1A"><?php //echo $total_tepat; ?></font></td>
											<td  align="center"><font size="12px" color="#1A1A1A"><?php // echo $total_telat; ?></font></td>
											
											<td  align="center"><font size="12px" color="#1A1A1A"><?php //echo round($pstotal); echo ' %' ?></font></td>
											<td  align="center"><font size="12px" color="#1A1A1A"><?php //echo ' %' ?></font></td>
											<td  align="center"><font size="12px" color="#1A1A1A"><?php //echo ' %' ?></font></td>
											
									   </tr>
                                    </tr>-->
																		<?php	
	//-----------------------awal ketepatan -----------------------------------
	$bidangizin=$data['id'];
	//$i=1;

$total_selesai=0;
$totalselesai=0;
$total_tepat=0;
$total_telat=0;
$total=0;
$tidaksesuai=0;
$tingkatkecepatan=0;
$tottingkatkecepatan=0;
$totpembagi=0;
$totrealisasi=0;


                                        /*$query_data = "select id, n_sektor from trsektor order by id ASC";
                                        $hasil_data = mysql_query($query_data);
                                       
                                        while ($data = mysql_fetch_assoc(@$hasil_data)){
                                           //$i++;
										   $jumlah = 0;
                                            $izin = new trperizinan();
                                            $izin->get_by_id($data['id']);
											$kd_sektor = $izin->id;
                                            $sektor = new trsektor();
                                            $sektor->get_by_id($data['id']);
                                            $list_sektor = $sektor->id;

                                            $permohonan = new tmpermohonan();
										    $jumlah = $permohonan->where_related("trstspermohonan", 'id <>1' )->where("trsektor_id = '$list_sektor' AND d_terima_berkas between '$tgla' and '$tglb'")->count();
                                            $total = $total + $jumlah;
                                            $f_jumlah = intval($jumlah);
											$f_total = intval($total);*/
										?>
                                           <!--<tr>
                                                <td  align="center"> <font size="12px" color="#1A1A1A"><?php echo $i++; ?></font> </td>
												 <td > <font size="12px" color="grey"><?php //echo $data['n_sektor']; ?>
												<?php 
												
										  // echo anchor(site_url('durasisemuabidang/perbidang').'/'.$data['id'] .'/'.$tgla.'/'.$tglb.'/'.$data['n_sektor'] , $data['n_sektor'],  'class="link2-wrc" rel="durasisemuabidang_box"'); 
										
												?>
                                               </font> </td>
										 <td  align="center" width="20%"><font size="12px" color="grey">
												
												  
										                
                                                            <?php 
															//if(intval($f_jumlah==0)){
//echo $f_jumlah;
//}else{
  //                                                          echo anchor(site_url('kinerjasemuabidang/DetailSektorTahun').'/'.$data['id'] .'/'.$tgla.'/'.$tglb.'/'.$data['n_sektor'] , $f_jumlah,  'class="link2-wrc" rel="durasisemuabidang_box"'); 
                                                           // echo $f_jumlah;
	//													   }
															?>
                                                        
                                                    </font>
                                                </td>-->
												<?
												
											$idsektor=$data['id'];
											 $query = "select  count(a.id) jumlah, a.c_izin_selesai, d.c_penetapan, d.status_bap, a.d_selesai_proses,a.d_terima_berkas from tmpermohonan a
                                inner join tmpermohonan_trperizinan b on a.id = b.tmpermohonan_id
                                inner join tmbap_tmpermohonan c on a.id = c.tmpermohonan_id
                                inner join tmbap d on d.id = c.tmbap_id
								inner join trperizinan e on e.id = b.trperizinan_id
								inner join tmpermohonan_tmsk h on a.id = h.tmpermohonan_id
inner join tmsk i on h.tmsk_id = i.id
                                LEFT JOIN tmpermohonan_trstspermohonan as t6 on a.id = t6.tmpermohonan_id
                                LEFT JOIN trstspermohonan as t7 on t7.id = t6.trstspermohonan_id
                               
                                where a.trsektor_id='$idsektor' and d.c_penetapan = 1

                                and t7.id <> 1 

                                and a.d_terima_berkas between '$tgla' and '$tglb'";
											$hasil_dataselesai = mysql_query($query);
                                       
                                        while ($dataselesai = mysql_fetch_assoc(@$hasil_dataselesai)){
										$jumlah_selesai=$dataselesai['jumlah'];
										
											$total_selesai=$total_selesai+$jumlah_selesai;
											
										//jumlah selesai
										?>
										
										<!--<td align="center"> <font size="12px" color="grey">
										
										<?php 
									//	if(intval($dataselesai['jumlah']==0)){
										//echo $dataselesai['jumlah'];
										//}else{
										//echo $dataselesai['jumlah'];
										 //  echo anchor(site_url('durasisemuabidang/perbidangselesai').'/'.$data['id'] .'/'.$tgla.'/'.$tglb.'/'.$data['n_sektor'] , $dataselesai['jumlah'],  'class="link2-wrc" rel="durasisemuabidang_box"'); 
										//}
										//echo $dataselesai['jumlah']; ?></font> </td>-->
										<?
										}
										
									
										
									

$jumlah=0;
$tt=0;
$totalselesaitepat=0;
$jumkecepatan=null;
$bidangizin=$idsektor;

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
where d.c_penetapan = 1 and a.trsektor_id='$bidangizin' and a.d_terima_berkas between '$tgla' and '$tglb'";
                    $exeizin = mysql_query($qizin);
                   
                    while($rowizin = mysql_fetch_assoc($exeizin)){
					if($rowizin >0){
					$trsektorid=$rowizin['trsektor_id'];
					 $tanggalterima=$rowizin['terima'];
					 $surat=$rowizin['tgl_surat'];
					 $suratedit=$rowizin['tgl_surat_edit'];
					 $waktu=$rowizin['durasi'];
					  
					?>
					
			
		 
		 
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
				$date1 = new DateTime($tanggalselesai); 
					  $date2 = new DateTime($tanggalterima); 
					 
					$interval = $date2->diff($date1);

					$selisihhari = $interval->format('%R%a');

$shari = substr($selisihhari, 1,5);
					 
					
					$realisasi = $shari - $holidayperizin;
					if($realisasi <= $waktu ){
					$sesuai = $realisasi <= $waktu;
					//echo $sesuai;
					$tot=count($sesuai);
						$tt +=$tot;
					}else{
					$sesuai = $realisasi > $waktu;
					}
				
		 }
		
		 }
		
		
}

		 ?>
					
					
					<!--<td align="center"> <font size="12px" color="grey"><?php 
					
					if($tt==0){
					echo $tt;
					}else{
					echo anchor(site_url('durasisemuabidang/perbidangsesuai').'/'.$data['id'] .'/'.$tgla.'/'.$tglb.'/'.$data['n_sektor'] ,intval($tt),  'class="link2-wrc" rel="durasisemuabidang_box"');
					}
					//echo $tt;
$telat=$jumlah_selesai - $tt;	
if ($tt == 0 or $jumlah_selesai==0){
$persen=0;
}else{
$persen = $tt / $jumlah_selesai *100;		
}		


					
					?></td>
					
			<td align="center"> <font size="12px" color="grey">
				<? 
				if($telat==0){
				echo $telat;
				}else{
				echo anchor(site_url('durasisemuabidang/perbidangtelat').'/'.$data['id'] .'/'.$tgla.'/'.$tglb.'/'.$data['n_sektor'] ,intval($telat),  'class="link2-wrc" rel="durasisemuabidang_box"'); 
				}

				?>
				</td>-->
					<td align="center"><font size="12px" color="">
				<? echo round($persen);echo ' %'; ?>
				</td>
				
					<? 
		//echo round($persen);echo ' %';
		//kecepatan
		if($realisasi <= $waktu ){
					$sesuai=$realisasi <= $waktu;
					//echo $sesuai;
					$tot=count($sesuai);
						$tt +=$tot;
					}else{
					$sesuai=$realisasi > $waktu;
					}
					//echo $tt;
					$tt=0;
		?>
		
	
								
								<?
									//----------------------------------akhir ketepatan	
						
					
										 //--------------------AWAL KECEPATAN
										


		 
//echo $bidang;

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
where d.c_penetapan = 1 and a.trsektor_id='$bidangizin' and a.d_terima_berkas between '$tgla' and '$tglb'";
                    $exeizin = mysql_query($qizin);
                   
                    while($rowizin = mysql_fetch_assoc($exeizin)){
					if($rowizin >0){
					$trsektorid=$rowizin['trsektor_id'];
					?>
					
					
					<?
					
		
		 //------------------------------------------------------------------------tanggal terima
		 $tanggalterima=$rowizin['terima'];
		
		 //------------------------------------------------------------------------tanggal surat
		 $surat=$rowizin['tgl_surat'];
		
		 //--------------------------------------------------------------------------tanggal surat edit
		  $suratedit=$rowizin['tgl_surat_edit'];
		
		 //---------------------------------------------------------------------------- durasi
		 $waktu=$rowizin['durasi'];
		
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
				
					//-------------------------------------sektor id
				
					
					
					$date1 = new DateTime($tanggalselesai); 
					  $date2 = new DateTime($tanggalterima); 
					 
					$interval = $date2->diff($date1);

					$selisihhari = $interval->format('%R%a');
//-------------------------------------------------------------------selisih hari
$shari = substr($selisihhari, 1,5);
					 
					//echo $shari;
					
					$realisasi = $shari - $holidayperizin;
					
					
					//------------------------------------------------------------jumlahsesuai
					if($realisasi <= $waktu ){
					$sesuai=$realisasi <= $waktu;
					//echo $sesuai;
					$tot=count($sesuai);
						$tt +=$tot;
					}else{
					$sesuai=$realisasi > $waktu;
					}
					
//---------------------------------------------------persen kecepatan
$perkec=($waktu - $realisasi)/$waktu * 100;

//echo round($perkec);echo ' %';					
					
						$ttperkec +=$perkec;
			
		 }
		
		 }
		
}
//------------------------------------------------jumlah total Sesuai
		 $persenkecepatan = 0;
if($ttperkec==0 or $tt==0){
$persenkecepatan=0;
}else{
$persenkecepatan =$ttperkec/$tt;

}
if($persenkecepatan < 0){
		 ?>
		
				<td align="center"><font color="red"><font size="12px">
					<?php

echo round($persenkecepatan);echo ' %';

					?>
					</td>
					<?
					}else{
					?>
						<td align="center"><font color="green"><font size="12px">
					<?php

echo round($persenkecepatan);echo ' %';

					?>
					</td>
					<?
					}
					$ttperkec=0;
					$tt=0;
										 //-----------AKHIR KECEPATAN
										 //--------------awal ikm
										 $s1 = 0;
					$s2 = 0;
					$s3 = 0;
					$s4 = 0;
					$s5 = 0;
					$s6 = 0;
					$s7 = 0;
					$s8 = 0;
					$s9 = 0;
					$s10 = 0;
					$s11 = 0;
					$s12 = 0;
					$s13 = 0;
					$s14 = 0;
					
					$ss1 = 0;
					$ss2 = 0;
					$ss3 = 0;
					$ss4 = 0;
					$ss5 = 0;
					$ss6 = 0;
					$ss7 = 0;
					$ss8 = 0;
					$ss9 = 0;
					$ss10 = 0;
					$ss11 = 0;
					$ss12 = 0;
					$ss13 = 0;
					$ss14 = 0;
					
					
					$tanggal=explode('-',$tglb);
  
//echo $tanggal[0]; //tahun
//echo $tanggal[1]; //bulan
//echo $tanggal[2]; //hari

$tahunikm = $tanggal[0];
$tanggalikm =$tanggal[1];
					
                    $query_dataikm = "
					select * from tmikmnilai a 
					inner join trsektor b on b.id=a.sektor_id where a.sektor_id=$bidangizin and a.semester=1 and a.tahun=$tahunikm";
                    $resultsikm = mysql_query($query_dataikm);
                    while ($dataikm = mysql_fetch_assoc(@$resultsikm)){
					$s1 = $dataikm['u1'];
					$s2 = $dataikm['u2'];
					$s3 = $dataikm['u3'];
					$s4 = $dataikm['u4'];
					$s5 = $dataikm['u5'];
					$s6 = $dataikm['u6'];
					$s7 = $dataikm['u7'];
					$s8 = $dataikm['u8'];
					$s9 = $dataikm['u9'];
					$s10 = $dataikm['u10'];
					$s11 = $dataikm['u11'];
					$s12 = $dataikm['u12'];
					$s13 = $dataikm['u13'];
					$s14 = $dataikm['u14'];
					
		 }
		 
		 $query_data2 = "
					select * from tmikmnilai a 
					inner join trsektor b on b.id=a.sektor_id where a.sektor_id=$bidangizin and a.semester=2 and a.tahun=$tahunikm";
                    $results2 = mysql_query($query_data2);
                    while ($data2 = mysql_fetch_assoc(@$results2)){
					
					$ss1 = $data2['u1'];
					$ss2 = $data2['u2'];
					$ss3 = $data2['u3'];
					$ss4 = $data2['u4'];
					$ss5 = $data2['u5'];
					$ss6 = $data2['u6'];
					$ss7 = $data2['u7'];
					$ss8 = $data2['u8'];
					$ss9 = $data2['u9'];
					$ss10 = $data2['u10'];
					$ss11 = $data2['u11'];
					$ss12 = $data2['u12'];
					$ss13 = $data2['u13'];
					$ss14 = $data2['u14'];
					
		 }
		 

						$nilais1= ($s1+$s2+$s3+$s4+$s5+$s6+$s7+$s8+$s9+$s10+$s11+$s12+$s13+$s14);
						//echo substr($nilais1,0,4);  
					
						$nilais2= ($ss1+$ss2+$ss3+$ss4+$ss5+$ss6+$ss7+$ss8+$ss9+$ss10+$ss11+$ss12+$ss13+$ss14);
						//echo substr($nilais2,0,4); 
						
						$ratanilais1= $nilais1/14;
						//echo substr($ratanilais1,0,4);  
						
						$ratanilais2= $nilais2/14;
						//echo substr($ratanilais2,0,4); 
						if($ratanilais1 > 0 and $ratanilais1<=43.75){
						$mutu1= 'D (Tidak Baik)';
						}else if ($ratanilais1 >=43.76 and $ratanilais1 <=62.50) {
						$mutu1= 'C (Kurang Baik)';
						}else if ($ratanilais1 >=62.51 and $ratanilais1 <=81.25) {
						$mutu1= 'B (Baik)';
						}else if ($ratanilais1 >=81.26) {
						$mutu1= 'A (Sangat Baik)';
						}else if($ratanilais1 == 0){
						$mutu1=' - ';
						}
						
						if($ratanilais2 > 0 and $ratanilais2<=43.75){
						$mutu2= 'D (Tidak Baik)';
						}else if ($ratanilais2 >=43.76 and $ratanilais2 <=62.50) {
						$mutu2= 'C (Kurang Baik)';
						}else if ($ratanilais2 >=62.51 and $ratanilais2 <=81.25) {
						$mutu2= 'B (Baik)';
						}else if ($ratanilais2 >=81.26) {
						$mutu2= 'A (Sangat Baik)';
						}else if($ratanilais2 == 0){
						$mutu2=' - ';
						}
						
						?>
						<td align="center"><font size="12px">
						<?
						if($tanggalikm <=06){
						//echo round($ratanilais1);
						echo ' '.$mutu1;
						}else{
						//echo round($ratanilais2);
						echo ' '.$mutu2;
						}
						?>
						</td>	
						<?
										 //---------------akhir ikm
										 }
										 
							
                                ?>
								
							  
	 </tr>
	 <?php

?>
								</table>


                            </fieldset>

		              
                </div>

            </form>
        </div>
    </div>
</body>
</html>
