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
                                    echo 'Rekap Permohonan izin Semua Bidang ';echo br(2); echo 'Periode '. $this->lib_date->mysql_to_human($tgla)." - ".$this->lib_date->mysql_to_human($tglb);
//                                    echo 'Realisasi Penerimaan Tahun '.$list_tahun->d_tahun;
                                    ?>
                                </legend>
                                <table align="left">
                                    <tr>
                                        <td align="center">
                                            <?php
                                            $Back_data = array(
                                                'src' => base_url().'assets/images/icon/back_alt.png',
                                                'alt' => 'Lihat di HTML to Openoffice',
                                                'title' => 'Kembali',
                                                'onclick' => 'parent.location=\''. site_url('rekapitulasi/rekapitulasi'). '\''
                                            );
                                            echo img($Back_data);
                                            $img_cetak = array(
                                                'src' => base_url().'assets/images/icon/print.png',
                                                'alt' => 'Selesai',
                                                'title' => 'View Report with OpenOffice',
                                                'onclick' => 'parent.location=\''.site_url('rekapitulasi/realisasi/cetak_report').'/'.$tgla.'/'.$tglb.'\''
                                            );
                                            echo img($img_cetak);
                                            //echo anchor(site_url('rekapitulasi/realisasi/cetak_report') .'/'. $list_tahun->d_tahun, img($img_cetak))."&nbsp;";
                                            ?>
                                        </td>
                                    </tr>
                                </table>



								<table align="center" width="90%" border="1" class="display" cellpadding="1" cellspacing="0" id="rev">
                                    <tr class="title">
                                        <td align="center" ><font  size="2" color="#1A1A1A"><b>No</b></font></td>
                                        <td width="35%" align="center" ><font  size="2" color="#1A1A1A"><b>Sektor Perizinan</b></font></td>
                                        <td align="center" ><font  size="2" color="#1A1A1A"><b>Jumlah <?echo br();?>Jenis Perizinan</b></font></td>
										<td align="center" ><font  size="2" color="#1A1A1A"><b>Jumlah <?echo br();?> Pemohon</b></font></td>
										<td align="center" ><font  size="2" color="#1A1A1A"><b>Jumlah <?echo br();?> diterima</b></font></td>
										<td align="center" ><font  size="2" color="#1A1A1A"><b>Jumlah <?echo br();?>ditolak</b></font></td>
										<td align="center" ><font  size="2" color="#1A1A1A"><b>Jumlah <?echo br();?>proses</b></font></td>
										<td align="center" ><font  size="2" color="#1A1A1A"><b>Persen <?echo br();?>Selesai</b></font></td>
                                    </tr>
                                    <tr>
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
										$hasilstatus4=mysql_query($querystatus3);
										while($status4 = mysql_fetch_assoc(@$hasilstatus4)){
										
										$hasilproses2= $status3['n_sts_permohonan'];
										
										}
                                        $i = NULL;
										//$obj = $this->permohonan;
										//$jumlah = $obj->where_related("trstspermohonan", 'id <> 1')->where("trsektor_id = '$list_sektor' AND d_terima_berkas >= '$first_date' AND //d_terima_berkas <= '$second_date'")->count();

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
                                            $f_jumlah = number_format($jumlah);
                                            $f_total = number_format($total);
										
                                        
										?>
                                            <tr>
                                                <td  align="center"> <font  size="2" color="#1A1A1A"><?php echo $i; ?></font> </td>
                                                <td > <font  size="2" color="#1A1A1A"><?php echo $data['n_sektor']; ?></font> </td>
												<?
											$idsektor=$data['id'];
											
											$query_data3 = "select count(distinct  a.trperizinan_id) hitung,
											 count(b.status_berkas ) diterima
											 from tmpermohonan_trperizinan  a
											inner join tmpermohonan b on a.tmpermohonan_id=b.id
											left join tmpermohonan_trstspermohonan c on c.tmpermohonan_id=a.id
											where b.d_terima_berkas between '$tgla' and '$tglb' and b.trsektor_id='$idsektor' and c.trstspermohonan_id<>1";
											$hasil_data3 = mysql_query($query_data3);
											
											 while ($data3 = mysql_fetch_assoc(@$hasil_data3)){
											$jumlah2=$data3['hitung'];
											$total10 = $total10 + $jumlah2;
                                            $f_jumlah2 = number_format($jumlah2);
                                            $f_total2 = number_format($total10);
											
											
											
											//echo $data3['diterima']
											//echo br();
										?>
										<td align="center"> <font  size="2" color="#1A1A1A"><?php echo $data3['hitung']; ?></font> </td>
										<?
											}
											
											
											?>
											
											
                                               <td  align="center"> 
												
												    <font  size="2" color="#1A1A1A"> 
										                <b>
                                                            <?php 
                                                            echo anchor(site_url('rekapitulasi/DetailSektorTahun').'/'.$data['id'] .'/'.$tgla.'/'.$tglb.'/'.$data['n_sektor'] , $f_jumlah,  'class="link2-wrc" rel="rekapitulasi_box"'); 
                                                            ?>
                                                        </b>
                                                    </font>
                                                </td>
												
												
											<?	
												
											//$statusditerima=$status['n_sts_permohonan'];
											//echo $hasilditerima;
											
											/*$query_datastatus = "select count(d.trperizinan_id) as jumlahizin from tmpermohonan_trstspermohonan a
inner join tmpermohonan b on a.tmpermohonan_id=b.id
left join trstspermohonan c on c.id=a.trstspermohonan_id
left join tmpermohonan_trperizinan d on d.tmpermohonan_id=b.id 
left join trperizinan_trsektor e on d.trperizinan_id=e.trperizinan_id

where b.d_terima_berkas between '$tgla' and '$tglb' and e.trsektor_id='$idsektor' ";*/
$query_datastatus="select count(a.id) jumlahizin, a.c_izin_selesai, d.c_penetapan, d.status_bap from tmpermohonan a
                                inner join tmpermohonan_trperizinan b on a.id = b.tmpermohonan_id
                                inner join tmbap_tmpermohonan c on a.id = c.tmpermohonan_id
                                inner join tmbap d on d.id = c.tmbap_id
								inner join trperizinan e on e.id = b.trperizinan_id
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

$query_data4="$query_datastatus and d.status_bap='1'";
											$hasil_data4 = mysql_query($query_data4);
											
											 while ($data4 = mysql_fetch_assoc(@$hasil_data4)){
											 $terima4=$data4['jumlahizin'];
											 $totalterima=$totalterima+$data4['jumlahizin'];
											
										?>
										<td  align="center"> <font  size="2" color="#1A1A1A"><?php echo $data4['jumlahizin'] ?></font> </td>
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
										?>
										<td  align="center"> <font  size="2" color="#1A1A1A"><?php echo $data5['jumlahizin']; ?></font> </td>
										<?
										 $jumlah_proses = $f_jumlah - ($terima4 + $tolak5);
										 $totjml=$totjml + $jumlah_proses;
											//}
											?>	
											
											
											
											<?
											//$qproses=" and b.status_berkas<>'$hasilproses1' and  b.status_berkas<>'$hasilproses2' ";
											
											//$query_data6="$query_datastatus and d.status_bap='0'";
											//$hasil_data6 = mysql_query($query_data6);
											
											 //while ($data6 = mysql_fetch_assoc(@$hasil_data6)){
											
										?>
										<td  align="center"> <font  size="2" color="#1A1A1A"><?php echo $jumlah_proses ?></font> </td>
										<?
											}
											?>	
											
                                         
                                            <?php
											if ( $jumlah2==0)
											{
											$persentase=0;
											?>
											<td align="center"><font  size="2" color="#1A1A1A"><?php echo '0 %'; ?></font></td>
											<?
											}else{
										$persentase=($terima4 + $tolak5)/$f_jumlah*100;
										//echo $persentase;
										?>
										<td  align="center"><font  size="2" color="#1A1A1A"><?php echo round($persentase);echo ' %'; ?></font></td>
										<?
                                        }
										if($f_total==0){
										$totalpersen=0;
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
                                            <td  align="center"><?php  echo ''; ?></td>
                                            <td  align="center"><font  size="2" color="#1A1A1A"><b>Total</b></font></td>
                                            <td  align="center"><font  size="2" color="#1A1A1A"><b><?php echo $f_total2; ?></b></font></td>
											<td  align="center"><font  size="2" color="#1A1A1A"><b><?php echo $f_total; ?></b></font></td>
											<td  align="center"><font  size="2" color="#1A1A1A"><b><?php echo $totalterima; ?></b></font></td>
											<td  align="center"><font  size="2" color="#1A1A1A"><b><?php echo $totaltolak; ?></b></font></td>
											<td  align="center"><font  size="2" color="#1A1A1A"><b><?php echo $totjml; ?></b></font></td>
											<td  align="center"><font  size="2" color="#1A1A1A"><b><?php echo round($totalpersen); echo ' %' ?></b></font></td>
											
									   </tr>
                                    </tr>
                                </table>



                            </fieldset>

		              
                </div>

            </form>
        </div>
    </div>
</body>
</html>
