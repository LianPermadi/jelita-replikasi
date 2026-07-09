<?php
		header("Content-Type: application/vnd.ms-word");
    header("Expires: 0");
       header("Cache-Control:  must-revalidate, post-check=0, pre-check=0");
       // header("Content-disposition: attachment; filename=Perngaduan Pertriwulan Tahun '.  $this->input->post('tgla').doc");
        header("Content-disposition: attachment; filename=Ketepatan Waktu Penyelesaian Semua Bidang Periode $tgla-$tglb.doc");
		
	?>
<html>
<head>
<title>Realisasi Penerimaan</title>
</head>

<body>
    <div id="content">
        <div class="post">
            <div class="title">
                <table border="0">
			<tr  >
			<td align="left" width="10%">
			<?php 
			echo br();
			
			 $img_cetak = array(
                          'src' => base_url().'assets/images/icon/logo Jawa_Barat.png');
              echo img($img_cetak);
			?>
			</td ><td align="center">
			<font size="12px"><b>
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
                                <legend style="color: #045000" align="center">
                                    <?php
                                   
//                                    echo 'Realisasi Penerimaan Tahun '.$list_tahun->d_tahun;
                                    ?>
                                </legend>
                                



								<table align="center" width="90%" border="1" class="display" cellpadding="1" cellspacing="0" id="rev">
                                    <tr class="title">
                                        <td align="center" ><font  size="12px" color="#1A1A1A">No</font></td>
                                        <td width="35%" align="center" ><font  size="12px" color="#1A1A1A">Sektor Perizinan</font></td>
										  <td width="17%" align="center" ><font  size="12px" color="#1A1A1A">Permohonan</font></td>
                                        <td width="17%" align="center" ><font  size="12px" color="#1A1A1A">Jumlah <?echo br();?>Selesai</font></td>
										<td width="17%" align="center" ><font  size="12px" color="#1A1A1A">Jumlah <?echo br();?>Selesai Sesuai Durasi</font></td>
										 <td width="17%" align="center" ><font  size="12px" color="#1A1A1A">Jumlah <?echo br();?>Tidak Sesuai Durasi</font></td>
										<td width="17%"align="center" ><font  size="12px" color="#1A1A1A"><?echo br();?> % Ketepatan</font></td>
									
                                    </tr>
                                    <tr>
                                       
										<?
                                        $i = NULL;
										//$obj = $this->permohonan;
										//$jumlah = $obj->where_related("trstspermohonan", 'id <> 1')->where("trsektor_id = '$list_sektor' AND d_terima_berkas >= '$first_date' AND //d_terima_berkas <= '$second_date'")->count();
$total_selesai=0;
$total_tepat=0;
$total_telat=0;
$total=0;
$tidaksesuai=0;
                                        $query_data = "select id, n_sektor from trsektor order by id ASC";
                                        $hasil_data = mysql_query($query_data);
                                       
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
										 <td  align="center" width="20%"><font  size="12px" ="#1A1A1A" color="black">
												
												  
										                
                                                            <?php 
															if(intval($f_jumlah==0)){
echo $f_jumlah;
}else{
                                                            echo $f_jumlah; 
                                                           // echo $f_jumlah;
														   }
															?>
                                                        
                                                    </font>
                                                </td>
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
										//jumlah selesai
										?>
										
										<td align="center"> <font  size="12px" color="black">
										
										<?php 
										if(intval($dataselesai['jumlah']==0)){
										echo $dataselesai['jumlah'];
										}else{
										echo $dataselesai['jumlah'];}
										//echo $dataselesai['jumlah']; ?></font> </td>
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
where d.c_penetapan = 1 and a.trsektor_id='$idsektor' and a.d_terima_berkas between '$tgla' and '$tglb'";
                    $exe3 = mysql_query($q3);
                   
                    while($row3 = mysql_fetch_assoc($exe3)){
					if($row3 >0){
					
         $t=$row3['tepat'];
		 $total_tepat=$total_tepat+$t;
		 //jumlah sesuai durasi
		 ?>
		  <td align="center"> <font  size="12px" color="black">
		 <?php
		 if(intval($t)==0){
										echo intval($t);
										}else{
										
										   echo intval($t); 
		}
		 ?>
		 
		</font> </td>
		 
		
		 		 
		 <?php
	}
	 
		 //jumlah tidak sesuai durasi
		 //$tidaksesuai=$jumlah_selesai - $t;
		if($jumlah_selesai==0){
		 $tidaksesuai=0;
		 }else{
		 $tidaksesuai = $jumlah_selesai - $t;
		}
		 $total_telat=$total_telat+$tidaksesuai;
		 ?>
		  <td align="center"> <font  size="12px" color="black">
		 <?php
		 if($tidaksesuai==0){
										echo intval($tidaksesuai);
										}else{
										
										   echo intval($tidaksesuai); 
		}
		 ?>
		 
		</font> </td>
		
		 <?
	}
										
		 if($jumlah_selesai !=0 && $t !=0){
		 $ps= $t/$jumlah_selesai*100 ;
		 }else if($jumlah_selesai ==0 || $t ==0){
		 $ps=0;
		 }								
										
		 ?>
		 <td align="center"> <font  size="12px" color="#1A1A1A"><?php echo number_format($ps,2); echo ' %'; ?></font> </td>
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
                                            <td  align="center"><font  size="12px" color="#1A1A1A">Total</font></td>
										<td  align="center"><font  size="12px" color="#1A1A1A"><?php echo $f_total; ?></font></td>
                                            <td  align="center"><font  size="12px" color="#1A1A1A"><?php echo $total_selesai; ?></font></td>
											<td  align="center"><font  size="12px" color="#1A1A1A"><?php echo $total_tepat; ?></font></td>
											<td  align="center"><font  size="12px" color="#1A1A1A"><?php echo $total_telat; ?></font></td>
											
											<td  align="center"><font  size="12px" color="#1A1A1A"><?php echo number_format($pstotal,2); echo ' %' ?></font></td>
											
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
