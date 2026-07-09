
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
                                    echo 'Resume Evaluasi Penyelesaian Perizinan ';echo br(2); echo 'Periode '. $this->lib_date->mysql_to_human($tgla)." - ".$this->lib_date->mysql_to_human($tglb);
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
                                                'onclick' => 'parent.location=\''. site_url('resume'). '\''
                                            );
                                            
                                            echo img($Back_data);
                                            $word = array(
                                                'src' => base_url().'assets/images/icon/word.png',
                                                'alt' => 'Selesai',
                                                'title' => 'Cetak ke word',
                                               'onclick' => 'parent.location=\''. site_url('resume/lwview').'/'.$tgla.'/'.$tgla.'/'.$tglb.'\''
                                            );
                                            echo img($word);

 						
                                            $excel = array(
                                                'src' => base_url().'assets/images/icon/excel.png',
                                                'alt' => 'Selesai',
                                                'title' => 'Cetak ke excel',
                                                'onclick' => 'parent.location=\''. site_url('resume/leview').'/'.$tgla.'/'.$tgla.'/'.$tglb.'\''
                                            );
                                            echo img($excel);                                            ?>
                                        </td>
                                    </tr>
                                </table>



								<table align="center" width="90%" border="1" class="display" cellpadding="1" cellspacing="0" id="roygridx">
                                    <thead><tr class="title">
                                        <th align="center" ><font  size="2" color="#1A1A1A"><b>No</b></font></th>
                                        <th width="35%" align="center" ><font  size="2" color="#1A1A1A"><b>Bidang Perizinan</b></font></th>
										 <th width="17%" align="center" ><font  size="2" color="#1A1A1A"><b>Tingkat <?php echo br(); ?> Penyelesaian</b></font></th>
										<th width="17%"align="center" ><font  size="2" color="#1A1A1A"><b><? echo 'Tingkat';echo br(); echo 'Ketepatan' ?></b></font></th>
									<th width="17%" align="center" ><font  size="2" color="#1A1A1A"><b><? echo 'Tingkat';echo br();echo 'Kecepatan'; ?></b></font></th>
										 <th width="17%" align="center" ><font  size="2" color="#1A1A1A"><b><? echo 'Nilai IKM';?></b></font></th>
                                    </tr></thead>
                                    
                                       
										<?
                                       $i = 0;
										$i++;
										//$obj = $this->permohonan;
										//$jumlah = $obj->where_related("trstspermohonan", 'id <> 1')->where("trsektor_id = '$list_sektor' AND d_terima_berkas >= '$first_date' AND //d_terima_berkas <= '$second_date'")->count();
$total_selesai=0;
$total_tepat=0;
$total_telat=0;
$total=0;
$tidaksesuai=0;
$totaltolak=0;
$totaltolak2=0;
$totalterima=0;
 $jumlah_masuk = 0;
 $jumlahtotalpersenkecepatan=0;
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
$f_total2=0;
$tt2=0;
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
                                                <td  align="center"> <font  size="2" color="#1A1A1A"><?php 
												// $i = 1;
										//$i++;
												echo $i; ?></font> </td>
                                                <td > <font  size="2" color="#1A1A1A"><?php echo $data['n_sektor']; ?></font> </td>
<?php												
	//------------------------------------awal resume
	
	
	$permohonan = new tmpermohonan();
										    $jumlah = $permohonan->where_related("trstspermohonan", 'id <>1' )->where("trsektor_id = '$list_sektor' AND d_terima_berkas between '$tgla' and '$tglb'")->count();
                                            $total = $total + $jumlah;
                                            $f_jumlah = intval($jumlah);
                                            $f_total = intval($total);
										$f_total2 +=$f_total;
                                      
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
<!--<td><? echo $dta['jumlahizin']?></td>-->
<?
}
$querytolakfo="select count(a.id) jumlah from tmpermohonan a
                                inner join tmpermohonan_trperizinan b on a.id = b.tmpermohonan_id
                               
								inner join trperizinan e on e.id = b.trperizinan_id
								
                                LEFT JOIN tmpermohonan_trstspermohonan as t6 on a.id = t6.tmpermohonan_id
                                LEFT JOIN trstspermohonan as t7 on t7.id = t6.trstspermohonan_id
                               
                                where a.trsektor_id = '$idsektor' 
                                and t7.id <> 1 and
a.d_terima_berkas between '$tgla' and '$tglb' and a.trsektor_id='$idsektor'
                                and status_berkas='Izin Ditolak FO'";
								
								$htolakfo = mysql_query($querytolakfo);
											
while ($dttolakfo = mysql_fetch_assoc(@$htolakfo)){
$tolakfo=$dttolakfo['jumlah'];
?>

<?
}
//echo $tolakfo;
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
											 $totaltolak2=$totaltolak2+$data5['jumlahizin'];
											 $tolak5=$data5['jumlahizin']+$tolakfo;
											$totaltolak=$totaltolak+$data5['jumlahizin']+$tolakfo;
											
										
											}
											?>	
											
                                         
                                            <?php
											if ( $jumlah==0)
											{
											$persentase=0;
											?>
											<td align="center"><font  size="2" color="#1A1A1A"><?php echo '0.00 %'; ?></font></td>
											<?
											}else{
										$persentase=($terima4 + $tolak5)/intval($f_jumlah)*100;
										
										?>
										
										<td  align="center"><?php echo number_format($persentase,2);echo ' %'; ?></b></td>
										<?
                                        }
										if($f_total2==0){
										$totalpersen=0;
										}else{
										$totalpersen=($totalterima +$totaltolak)/$f_total2*100;
										}
										//echo round($totalterima + $totaltolak );
										//echo $totalpersen;
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
										
										<!--<td align="center"><b> <font  size="2" color="grey">
										
										<?php 
										//if(intval($dataselesai['jumlah']==0)){
										//echo $dataselesai['jumlah'];
										//}else{
										
										  // echo anchor(site_url('durasisemuabidang/perbidang').'/'.$data['id'] .'/'.$tgla.'/'.$tglb.'/'.$data['n_sektor'] , $dataselesai['jumlah'],  'class="link2-wrc" rel="durasisemuabidang_box"'); 
										//}
										//echo $dataselesai['jumlah']; ?></font></b> </td>-->
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
		  <!--<td align="center"> <b><font  size="2" color="grey">
		 <?php
		 //if(intval($t)==0){
			//							echo intval($t);
				//						}else{
										
					//					   echo anchor(site_url('durasisemuabidang/perbidangsesuai').'/'.$data['id'] .'/'.$tgla.'/'.$tglb.'/'.$data['n_sektor'] ,intval($t),  'class="link2-wrc" rel="durasisemuabidang_box"'); 
		//}
		 ?>
		 
		</font> </b></td>-->
		 
		
		 		 
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
		  <!--<td align="center"> <b><font  size="2" color="grey">
		 <?php
		 //if($tidaksesuai==0){
			//							echo intval($tidaksesuai);
				//						}else{
										
					//					   echo anchor(site_url('durasisemuabidang/perbidangtelat').'/'.$data['id'] .'/'.$tgla.'/'.$tglb.'/'.$data['n_sektor'] ,intval($tidaksesuai),  'class="link2-wrc" rel="durasisemuabidang_box"'); 
		//}
		 ?>
		 
		</font> </b></td>-->
		
		 <?
	}
										
		 if($jumlah_selesai !=0 && $t !=0){
		 $ps= $t/$jumlah_selesai*100 ;
		 }else if($jumlah_selesai ==0 || $t ==0){
		 $ps=0;
		 }								
										
		 ?>
		 <td align="center"> <font  size="2" color="#1A1A1A"><?php echo round($ps); echo ' %'; ?></font> </td>
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
						<td align="center"><font color="red"><b><?php echo $tottingkatkecepatan; echo ' %'; ?></b></font></td>
						 
						<?
						}else{
						?>
						<td align="center"><font color="green"><b><?php echo $tottingkatkecepatan; echo ' %'; ?></b></font></td>
						 
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
                                            <td  align="center"><font  size="2" color="#1A1A1A"><b>Total</b></font></td>
										<td  align="center"><font  size="2" color="#1A1A1A"><b><?php // echo round($totalpersen); ?></b></font></td>
                                    <!--        <td  align="center"><font  size="2" color="#1A1A1A"><b><?php //echo $total_selesai; ?></b></font></td>
											<td  align="center"><font  size="2" color="#1A1A1A"><b><?php //echo $total_tepat; ?></b></font></td>
											<td  align="center"><font  size="2" color="#1A1A1A"><b><?php // echo $total_telat; ?></b></font></td>
											
											<td  align="center"><font  size="2" color="#1A1A1A"><b><?php //echo round($pstotal); echo ' %' ?></b></font></td>
											<td  align="center"><font  size="2" color="#1A1A1A"><b><?php //echo ' %' ?></b></font></td>
											<td  align="center"><font  size="2" color="#1A1A1A"><b><?php //echo ' %' ?></b></font></td>
											
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
                                                <td  align="center"> <font  size="2" color="#1A1A1A"><?php echo $i++; ?></font> </td>
												 <td > <font  size="2" color="grey"><b><?php //echo $data['n_sektor']; ?>
												<?php 
												
										  // echo anchor(site_url('durasisemuabidang/perbidang').'/'.$data['id'] .'/'.$tgla.'/'.$tglb.'/'.$data['n_sektor'] , $data['n_sektor'],  'class="link2-wrc" rel="durasisemuabidang_box"'); 
										
												?>
                                               </font></b> </td>
										 <td  align="center" width="20%"><font  size="2" color="grey">
												
												  
										                <b>
                                                            <?php 
															//if(intval($f_jumlah==0)){
//echo $f_jumlah;
//}else{
  //                                                          echo anchor(site_url('kinerjasemuabidang/DetailSektorTahun').'/'.$data['id'] .'/'.$tgla.'/'.$tglb.'/'.$data['n_sektor'] , $f_jumlah,  'class="link2-wrc" rel="durasisemuabidang_box"'); 
                                                           // echo $f_jumlah;
	//													   }
															?>
                                                        </b>
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
										
										<!--<td align="center"><b> <font  size="2" color="grey">
										
										<?php 
									//	if(intval($dataselesai['jumlah']==0)){
										//echo $dataselesai['jumlah'];
										//}else{
										//echo $dataselesai['jumlah'];
										 //  echo anchor(site_url('durasisemuabidang/perbidangselesai').'/'.$data['id'] .'/'.$tgla.'/'.$tglb.'/'.$data['n_sektor'] , $dataselesai['jumlah'],  'class="link2-wrc" rel="durasisemuabidang_box"'); 
										//}
										//echo $dataselesai['jumlah']; ?></font></b> </td>-->
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
					
					
					<!--<td align="center"><b> <font  size="2" color="grey"><?php 
					
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
					
			<td align="center"><b> <font  size="2" color="grey">
				<? 
				if($telat==0){
				echo $telat;
				}else{
				echo anchor(site_url('durasisemuabidang/perbidangtelat').'/'.$data['id'] .'/'.$tgla.'/'.$tglb.'/'.$data['n_sektor'] ,intval($telat),  'class="link2-wrc" rel="durasisemuabidang_box"'); 
				}

				?>
				</td>-->
					<td align="center"><font  size="2" color="">
				<? 
				
				if(substr($tgla,0,4)=='2013' and substr($tglb,0,4)=='2013' and $persen < 87){
				?><font  size="2" color="red">
				<?
				}else if(substr($tgla,0,4)=='2013' and substr($tglb,0,4)=='2013' and $persen >= 87){
				?>
				<font  size="2" color="green">
				<?
				}else if(substr($tgla,0,4)=='2014' and substr($tglb,0,4)=='2014' and $persen < 87){
				?>
				<font  size="2" color="red">
				<?
				}else if(substr($tgla,0,4)=='2014' and substr($tglb,0,4)=='2014' and $persen >= 87){
				?>
				<font  size="2" color="green">
				<?
				}else if(substr($tgla,0,4)=='2015' and substr($tglb,0,4)=='2015' and $persen < 91){
				?>
				<font  size="2" color="red">
				<?
				}else if(substr($tgla,0,4)=='2015' and substr($tglb,0,4)=='2015' and $persen >= 91){
				?>
				<font  size="2" color="green">
				<?
				}else if(substr($tgla,0,4)=='2016' and substr($tglb,0,4)=='2016' and $persen < 92){
				?>
				<font  size="2" color="red">
				<?
				}else if(substr($tgla,0,4)=='2016' and substr($tglb,0,4)=='2016' and $persen >= 92){
				?>
				<font  size="2" color="green">
				<?
				}else if(substr($tgla,0,4)=='2017' and substr($tglb,0,4)=='2017' and $persen < 93){
				?>
				<font  size="2" color="red">
				<?
				}else if(substr($tgla,0,4)=='2017' and substr($tglb,0,4)=='2017' and $persen >= 93){
				?>
				<font  size="2" color="green">
				<?
				}else if(substr($tgla,0,4)=='2018' and substr($tglb,0,4)=='2018' and $persen < 94){
				?>
				<font  size="2" color="red">
				<?
				}else if(substr($tgla,0,4)=='2018' and substr($tglb,0,4)=='2018' and $persen >= 94){
				?>
				<font  size="2" color="green">
				<?
				}else{
				?>
				<font  size="2" color="grey">
				<?
				}
				echo number_format($persen,2);echo ' %'; ?>
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
				//echo $tt;echo br();
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
					$tot2=count($sesuai);
					
						$tt2 +=$tot2;
					}else{
					$sesuai=$realisasi > $waktu;
					}
					//echo $tt2;
$tot=count($realisasi);
						$tt +=$tot;
						
//---------------------------------------------------persen kecepatan
$perkec=($waktu - $realisasi)/$waktu * 100;

//echo round($perkec);echo ' %';					
					
						$ttperkec +=$perkec;
			
		 }
		
		 }
		 
		
}
//echo $ttperkec;echo br();


//------------------------------------------------jumlah total Sesuai
		 $persenkecepatan = 0;
if($ttperkec==0 or $tt==0){
$persenkecepatan=0;
}else{
$persenkecepatan =$ttperkec/$tt;

}
//echo $ttperkec;echo br();
$totpersenkecepatan=$ttperkec;
						$jumlahtotalpersenkecepatan +=$totpersenkecepatan;
						
						

if($persenkecepatan < 0){
		 ?>
		
				<td align="center"><font color="red">
					<?php

echo number_format($persenkecepatan,2);echo ' %';

					?>
					</td>
					<?
					}else{
					?>
						<td align="center"><font color="green">
					<?php

echo number_format($persenkecepatan,2);echo ' %';

					?>
					</td>
					<?
					
					}
					
					//echo $ttperkec;
					$ttperkec=0;
					$tt=0;
										 //-----------AKHIR KECEPATAN
										 //--------------awal ikm
										 $s1 = 0;
					$totratanilais1=0;
					$totratanilais2=0;
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
					/*	if($ratanilais1 > 0 and $ratanilais1<=1.75){
						$mutu1= 'D (TIDAK BAIK)';
						}else if ($ratanilais1 >=1.76 and $ratanilais1 <=2.50) {
						$mutu1= 'C (KURANG BAIK)';
						}else if ($ratanilais1 >=2.51 and $ratanilais1 <=3.25) {
						$mutu1= 'B (BAIK)';
						}else if ($ratanilais1 >=3.26) {
						$mutu1= 'A (SANGAT BAIK)';
						}else if($ratanilais1 == 0){
						$mutu1=' - ';
						}
						
						if($ratanilais2 > 0 and $ratanilais2<=1.75){
						$mutu2= 'D (TIDAK BAIK)';
						}else if ($ratanilais2 >=1.76 and $ratanilais2 <=2.50) {
						$mutu2= 'C (KURANG BAIK)';
						}else if ($ratanilais2 >=2.51 and $ratanilais2 <=3.25) {
						$mutu2= 'B (BAIK)';
						}else if ($ratanilais2 >=3.26) {
						$mutu2= 'A (SANGAT BAIK)';
						}else if($ratanilais2 == 0){
						$mutu2=' - ';
						}
						*/
						?>
						<td align="center">
						<?
						if($tanggalikm <=06){
						echo number_format($ratanilais1,2);
						//echo ' '.$mutu1;
						
						
						}else{
						echo number_format($ratanilais2,2);
						//echo ' '.$mutu2;
						}
						?>
						</td>	
						<?
						//echo $ratanilais2;
						if($ratanilais1!=0){
						$tota=count($ratanilais1);
						$tota=count($ratanilais1);
						//echo $totb;
						$atota[]=$tota;
						$jmlatota=array_sum($atota);
						$totjmlatota=$jmlatota;
						}
						if($ratanilais2>0){
						$totb=count($ratanilais2);
						//echo $totb;
						$atotb[]=$totb;
						$jmlatotb=array_sum($atotb);
						$totjmlatotb=$jmlatotb;
						//echo $totjmlatotb;
						}
						//echo $tota;
						
						if($tanggalikm <=06){
						$totratanilai1=+$ratanilais1;
						//echo $totratanilai1;
						$aikm[]=$totratanilai1;
						$jmlikm=array_sum($aikm);
						$totjmlikm=$jmlikm;
						//echo $totjmlikm;
						if($totjmlikm==0 or $totjmlatota==0){
						$ikmtotal=0;
						}else{
						$ikmtotal=$totjmlikm/$totjmlatota;
						//echo $ikmtotal;
						}
						
						}else{
						$totratanilai2=+$ratanilais2;
						$aikm2[]=$totratanilai2;
						$jmlikm2=array_sum($aikm2);
						$totjmlikm2=$jmlikm2;
						//echo $totjmlikm2;
						if($totjmlikm2==0 or $totjmlatotb==0){
						$ikmtotal2=0;
						}else{
						$ikmtotal2=$totjmlikm2/$totjmlatotb;
						
						}
						}
						
						
						
										 //---------------akhir ikm
										 }
										 
							
                                ?>
								
							  
	 </tr>
	 <tr>
	 <td></td>
	 <td align="center"><b>TOTAL</b></td>
	 <td align="center"><b><?php echo number_format($totalpersen,2); echo ' %';?></td>
	 <td align="center"><b><?php 
	 if(($totalterima+$totaltolak2)==0 or $tt2==0){
	 $totalpersenketepatan=0;
	 }else{
	 $totalpersenketepatan=$tt2/($totalterima+$totaltolak2)*100;
	 }
	 if(substr($tgla,0,4)=='2013' and substr($tglb,0,4)=='2013' and $totalpersenketepatan < 87){
				?><font  size="2" color="red">
				<?
				}else if(substr($tgla,0,4)=='2013' and substr($tglb,0,4)=='2013' and $totalpersenketepatan >= 87){
				?>
				<font  size="2" color="green">
				<?
				}else if(substr($tgla,0,4)=='2014' and substr($tglb,0,4)=='2014' and $totalpersenketepatan < 87){
				?>
				<font  size="2" color="red">
				<?
				}else if(substr($tgla,0,4)=='2014' and substr($tglb,0,4)=='2014' and $totalpersenketepatan >= 87){
				?>
				<font  size="2" color="green">
				<?
				}else if(substr($tgla,0,4)=='2015' and substr($tglb,0,4)=='2015' and $totalpersenketepatan < 91){
				?>
				<font  size="2" color="red">
				<?
				}else if(substr($tgla,0,4)=='2015' and substr($tglb,0,4)=='2015' and $totalpersenketepatan >= 91){
				?>
				<font  size="2" color="green">
				<?
				}else if(substr($tgla,0,4)=='2016' and substr($tglb,0,4)=='2016' and $totalpersenketepatan < 92){
				?>
				<font  size="2" color="red">
				<?
				}else if(substr($tgla,0,4)=='2016' and substr($tglb,0,4)=='2016' and $totalpersenketepatan >= 92){
				?>
				<font  size="2" color="green">
				<?
				}else if(substr($tgla,0,4)=='2017' and substr($tglb,0,4)=='2017' and $totalpersenketepatan < 93){
				?>
				<font  size="2" color="red">
				<?
				}else if(substr($tgla,0,4)=='2017' and substr($tglb,0,4)=='2017' and $totalpersenketepatan >= 93){
				?>
				<font  size="2" color="green">
				<?
				}else if(substr($tgla,0,4)=='2018' and substr($tglb,0,4)=='2018' and $totalpersenketepatan < 94){
				?>
				<font  size="2" color="red">
				<?
				}else if(substr($tgla,0,4)=='2018' and substr($tglb,0,4)=='2018' and $totalpersenketepatan >= 94){
				?>
				<font  size="2" color="green">
				<?
				}else{
				?>
				<font  size="2" color="grey">
				<?
				}
	echo number_format($totalpersenketepatan,2); echo ' %';?></td>
	
	 <td align="center"><b>
	 <?php
	
	$jumpersenkecepatan[]=$jumlahtotalpersenkecepatan;
	$jmlpersenkecepatan=array_sum($jumpersenkecepatan);
	
	 $selesait=0;
	 $selesait=$totalterima+$totaltolak;
	  if(($totalterima+$totaltolak)==0 or $jmlpersenkecepatan==0){
	 $totalpersenkecepatan=0;
	  
	 }else{
	 
	 $totalpersenkecepatan = $jmlpersenkecepatan/$selesait;
 	
	}
	if($totalpersenkecepatan<0){
	?>
	<font color="red">
	<?
	}else{
	?>
	<font color="green">
	<?
	}
	
	echo number_format($totalpersenkecepatan,2); echo ' %';
	 ?>
	 
	 </td>
	 <td align="center"><b><?
	 
	echo number_format($ikmtotal2,2);
	 ?></td>
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
