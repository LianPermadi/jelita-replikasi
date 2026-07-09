<?php
	header("Content-Type: application/vnd.ms-word");
    header("Expires: 0");
    header("Cache-Control:  must-revalidate, post-check=0, pre-check=0");
    header("Content-disposition: attachment; filename=Tingkat Penyelesaian Semua Bidang $tgla-$tglb.doc");
?>
<html>
<head>
<title>Tingkat Penyelesaian Semua Bidang</title>
</head>

<body>
    <div id="content">
        <div class="post">
            <div class="title">
                <table border="0">
			<tr  >
			<td align="center" width="10%">
			<?php 
			echo br();
			
			 $img_cetak = array(
                          'src' => base_url().'assets/images/icon/logo Jawa_Barat.png');
              echo img($img_cetak);
			?>
			</td ><td align="center">
			<font size="12px">
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
			
			
			
			</table>
		<?php
?>		 
		 <div align="center"><font size="12px">
		  <?php 
		  echo '=============================================================';
		  echo br(2);
		  echo $page_name;
		  
		  echo br(2); echo 'Periode '. $this->lib_date->mysql_to_human($tgla)." - ".$this->lib_date->mysql_to_human($tglb);
		  echo br(2);
		  ?> </font>
		  
		  </div>
	
            </div>
            <form name="form1" method="post">

				<div class="entry">
                  

                            <fieldset>
                            

								<table align="center" width="" border="1" class="display" cellpadding="0" cellspacing="0" id="roygridx">
                                    <thead><tr class="title">
                                        <th rowspan="2" align="center" ><font  size="12px" color="#1A1A1A">No</b></font></th>
                                        <th rowspan="2" width="35%" align="center" ><font  size="12px" color="#1A1A1A">Sektor Perizinan</b></font></th>
                                        <th rowspan="2" align="center" ><font  size="12px" color="#1A1A1A">Jumlah <?echo br();?>Jenis Perizinan</b></font></th>
										<th rowspan="2" align="center" ><font  size="12px" color="#1A1A1A">Jumlah <?echo br();?> Pemohon</b></font></th>

										<th colspan="2" align="center" ><font  size="12px" color="#1A1A1A">Izin Selesai</b></font></th>

										<th rowspan="2" align="center" ><font  size="12px" color="#1A1A1A">Izin Proses</b></font></th>
										<th rowspan="2" align="center" ><font  size="12px" color="#1A1A1A">Persen <?echo br();?>Selesai</b></font></th>
                                    </tr>
									<tr>
										<th align="center" ><font  size="12px" color="#1A1A1A">Izin Terbit</b></font></th>
										<th align="center" ><font  size="12px" color="#1A1A1A">Izin Ditolak</font></th>

										</tr></thead>
                                  
                                        <?php
										$qstatus="select n_sts_permohonan from trstspermohonan";
										$qditerima="where id=13";
										$querystatus="$qstatus $qditerima";
										$hasilstatus=mysql_query($querystatus);
										while($status = mysql_fetch_assoc(@$hasilstatus)){
										
										$hasilditerima = $status['n_sts_permohonan'];
										}
										$qditolak="where id=14";
										$querystatus2="$qstatus $qditolak";
										$hasilstatus2=mysql_query($querystatus2);
										while($status2 = mysql_fetch_assoc(@$hasilstatus2)){
										
										$hasilditolak= $status2['n_sts_permohonan'];
										}
										$qdiproses="where id=13";
										$querystatus3="$qstatus $qdiproses";
										$hasilstatus3=mysql_query($querystatus3);
										while($status3 = mysql_fetch_assoc(@$hasilstatus3)){
										
										$hasilproses1= $status3['n_sts_permohonan'];
										
										}
										$qdiproses2="where id=14";
										$querystatus4="$qstatus $qdiproses2";
										$hasilstatus4=mysql_query($querystatus4);
										while($status4 = mysql_fetch_assoc(@$hasilstatus4)){
										
										$hasilproses2= $status3['n_sts_permohonan'];
										
										}
                                        $i = NULL;
										
                                        $query_data = "select id, n_sektor from trsektor order by id ASC";
                                        $hasil_data = mysql_query($query_data);
                                        $total = 0;
										$total10 = 0;
										$totalterima=0;
										$totaltolak=0;
										$totalproses=0;
										$totjml=0;
                                        while ($data = mysql_fetch_assoc(@$hasil_data)){
                                            $i++;
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
                                            $f_total = intval($total);
										
										?>
                                            <tr>
                                                <td  align="center"> <font  size="12px" color="#1A1A1A"><?php echo $i; ?></font> </td>
                                                <td > <font  size="12px" color="#1A1A1A"><?php echo $data['n_sektor']; ?></font> </td>
												<?
											$idsektor=$data['id'];
											$query_data3 = "select count(a.id) hitung from trperizinan a
												inner join trperizinan_trsektor b on a.id= b.trperizinan_id
												where b.trsektor_id='$idsektor'";
											$hasil_data3 = mysql_query($query_data3);
											
											 while ($data3 = mysql_fetch_assoc(@$hasil_data3)){
											$jumlah2=$data3['hitung'];
											$total10 = $total10 + $jumlah2;
                                            $f_jumlah2 = intval($jumlah2);
                                            $f_total2 = intval($total10);
										
										?>
										<td align="center" ><font  size="12px" ="#1A1A1A" color="grey">
										
										<?php 
										
										echo intval($data3['hitung']);
										
										?></font> 
										</b>
										</td>
										
										<?
											}
											
											
											?>
											
											
                                               <td  align="center"><font  size="12px" ="#1A1A1A" color="grey">
												
												  
										                
                                                            <?php 
															
															echo $f_jumlah;
															
															?>
                                                        </b>
                                                    </font>
                                                </td>
												
											<?	
											
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
$h = mysql_query($query_datastatus);
											
while ($dta = mysql_fetch_assoc(@$h)){

?>

<?
}

$query_data4="$query_datastatus and d.status_bap='1'";
											$hasil_data4 = mysql_query($query_data4);
											
											 while ($data4 = mysql_fetch_assoc(@$hasil_data4)){
											 $terima4=$data4['jumlahizin'];
											 $totalterima=$totalterima+$data4['jumlahizin'];
											
										?>
										<td  align="center"> <font  size="12px" color="grey">
										
										
										<?php 
										
echo intval( $data4['jumlahizin']);

										?>
										
										</b></font> </td>
										<?
											}
											
											$query_data5="$query_datastatus and d.status_bap='2'";
											$hasil_data5 = mysql_query($query_data5);
											
											 while ($data5 = mysql_fetch_assoc(@$hasil_data5)){
											 $tolak5=$data5['jumlahizin'];
											$totaltolak=$totaltolak+($data5['jumlahizin']+$tolakfo);
										?>
										<td  align="center"> <font  size="12px" color="grey">
										
										<?php 
										
											echo intval(( $data5['jumlahizin'])+$tolakfo);
										
										?>
										
									</b></font></td>
										<?
										$jumlah_proses = intval($f_jumlah) - ($terima4 + $tolak5+$tolakfo);
										$totjml=$totjml + $jumlah_proses;	
										?>
										<td  align="center"> <font  size="12px" color="grey">
										
										<?php 
									
										echo intval($jumlah_proses);
									
										?></b></font> </td>
										<?
										}
										if ( $jumlah==0)
										{
										$persentase=0;
										?>
										<td align="center"><font  size="12px" color="#1A1A1A"><?php echo '0.00 %'; ?></font></td>
										<?
										}else{
										$persentase=($terima4 + $tolak5+$tolakfo)/intval($f_jumlah)*100;
										?>
										<td  align="center"><font  size="12px" color="#1A1A1A"><?php echo number_format($persentase,2);echo ' %'; ?></font></td>
										<?
                                        }
										if($f_total==0){
										$totalpersen=0.00;
										}else{
										$totalpersen=($totalterima +$totaltolak)/$f_total*100;
										}
										}?>
										
                                             </tr> 	
										<tr bgcolor="#d5dffe">
											<td><??></td>
											<td><??></td>
											<td><??></td>
											<td><??></td>
											<td><??></td>
											<td><??></td>
											<td><??></td>
											<td><??></td>
										</tr>											 
                                        <tr>
                                            <td  align="center"><?php  //echo $i+1; ?></td>
                                            <td  align="center"><font  size="12px" color="#1A1A1A">Total</b></font></td>
                                            <td  align="center"><font  size="12px" color="#1A1A1A"><?php echo $f_total2; ?></b></font></td>
											<td  align="center"><font  size="12px" color="#1A1A1A"><?php echo $f_total; ?></b></font></td>
											<td  align="center"><font  size="12px" color="#1A1A1A"><?php echo $totalterima; ?></b></font></td>
											<td  align="center"><font  size="12px" color="#1A1A1A"><?php echo $totaltolak; ?></b></font></td>
											<td  align="center"><font  size="12px" color="#1A1A1A"><?php echo $totjml; ?></b></font></td>
											<td  align="center"><font  size="12px" color="#1A1A1A"><?php echo number_format($totalpersen,2); echo ' %' ?></b></font></td>
											
									   </tr>
                                    </tr>
                                </table>
                            </fieldset>
                </div>

            </form>
        </div>
    </div>
	<?
	
?>

</body>
</html>