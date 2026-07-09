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
                                        <td align="center" ><font  size="2" color="#1A1A1A"><b>Jumlah <?echo br();?>Selesai</b></font></td>
										<td align="center" ><font  size="2" color="#1A1A1A"><b>Jumlah <?echo br();?>Selesai Sesuai Durasi</b></font></td>
										<td align="center" ><font  size="2" color="#1A1A1A"><b><?echo br();?> % Ketepatan</b></font></td>
									
                                    </tr>
                                    <tr>
                                       
										<?
                                        $i = NULL;
										//$obj = $this->permohonan;
										//$jumlah = $obj->where_related("trstspermohonan", 'id <> 1')->where("trsektor_id = '$list_sektor' AND d_terima_berkas >= '$first_date' AND //d_terima_berkas <= '$second_date'")->count();
$total_selesai=0;
$total_tepat=0;
                                        $query_data = "select id, n_sektor from trsektor order by id ASC";
                                        $hasil_data = mysql_query($query_data);
                                       
                                        while ($data = mysql_fetch_assoc(@$hasil_data)){
                                           $i++;
										?>
                                            <tr>
                                                <td  align="center"> <font  size="2" color="#1A1A1A"><?php echo $i; ?></font> </td>
                                                <td > <font  size="2" color="#1A1A1A"><?php echo $data['n_sektor']; ?></font> </td>
										
												<?
											$idsektor=$data['id'];
											 $query = "select  count(a.id) jumlah, a.c_izin_selesai, d.c_penetapan, d.status_bap, a.d_selesai_proses,a.d_terima_berkas from tmpermohonan a
                                inner join tmpermohonan_trperizinan b on a.id = b.tmpermohonan_id
                                inner join tmbap_tmpermohonan c on a.id = c.tmpermohonan_id
                                inner join tmbap d on d.id = c.tmbap_id
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
										?>
										<td align="center"> <font  size="2" color="#1A1A1A"><?php echo $dataselesai['jumlah']; ?></font> </td>
										<?
										}
										
										
										$q3 = "select  a.id, a.c_izin_selesai, e.n_perizinan,e.v_hari,AVG(DATEDIFF(a.d_selesai_proses,a.d_terima_berkas)) rata,
				   SUM(DATEDIFF(a.d_selesai_proses,a.d_terima_berkas)<=e.v_hari) tepat from tmpermohonan a
                                inner join tmpermohonan_trperizinan b on a.id = b.tmpermohonan_id
                                inner join tmbap_tmpermohonan c on a.id = c.tmpermohonan_id
                                inner join tmbap d on d.id = c.tmbap_id
				inner join trperizinan e on e.id = b.trperizinan_id
                                LEFT JOIN tmpermohonan_trstspermohonan as t6 on a.id = t6.tmpermohonan_id
                                LEFT JOIN trstspermohonan as t7 on t7.id = t6.trstspermohonan_id
where d.c_penetapan = 1 and a.trsektor_id='$idsektor'";
                    $exe3 = mysql_query($q3);
                   
                    while($row3 = mysql_fetch_assoc($exe3)){
					if($row3 >0){
					
         $t=$row3['tepat'];
		 $total_tepat=$total_tepat+$t;
		 ?>
		 <td align="center"> <font  size="2" color="#1A1A1A"><?php echo intval($t); ?></font> </td>
		 <?
	}}
										
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
										
										}
										?>
										
                                             </tr> 	
										 
                                        <tr bgcolor="#d5dffe">
                                            <td  align="center"><?php  echo ''; ?></td>
                                            <td  align="center"><font  size="2" color="#1A1A1A"><b>Total</b></font></td>
                                            <td  align="center"><font  size="2" color="#1A1A1A"><b><?php echo $total_selesai; ?></b></font></td>
											<td  align="center"><font  size="2" color="#1A1A1A"><b><?php echo $total_tepat; ?></b></font></td>
											
											<td  align="center"><font  size="2" color="#1A1A1A"><b><?php echo round($pstotal); echo ' %' ?></b></font></td>
											
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
