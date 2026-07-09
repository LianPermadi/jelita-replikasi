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
                                <table align="left" >
                                    <tr>
                                        <td align="center" >
                                            <?php
                                            $Back_data = array(
                                                'src' => base_url().'assets/images/icon/back_alt.png',
                                                'alt' => 'Lihat di HTML to Openoffice',
                                                'title' => 'Kembali',
                                                'onclick' => 'parent.location=\''. site_url('durasisemuabidang/durasisemuabidang'). '\''
                                            );
                                            
                                            echo img($Back_data);
                                            $word = array(
                                                'src' => base_url().'assets/images/icon/word.png',
                                                'alt' => 'Selesai',
                                                'title' => 'Cetak ke word',
                                                 'onclick' => 'parent.location=\''. site_url('durasisemuabidang/lwview').'/'.$tgla.'/'.$tgla.'/'.$tglb.'\''
                                            );
                                            echo img($word);

 						
                                            $excel = array(
                                                'src' => base_url().'assets/images/icon/excel.png',
                                                'alt' => 'Selesai',
                                                'title' => 'Cetak ke excel',
                                                'onclick' => 'parent.location=\''. site_url('durasisemuabidang/leview').'/'.$tgla.'/'.$tgla.'/'.$tglb.'\''
                                            );
                                            echo img($excel);                                            ?>
                                        </td>
                                    </tr>
                                </table>



								<table align="center" width="90%" border="1" class="display" cellpadding="1" cellspacing="0" id="rev">
                                    <tr class="title">
                                        <td align="center" ><font  size="2" color="#1A1A1A"><b>No</b></font></td>
                                        <td width="35%" align="center" ><font  size="2" color="#1A1A1A"><b>Sektor Perizinan</b></font></td>
										  <td width="17%" align="center" ><font  size="2" color="#1A1A1A"><b>Permohonan</b></font></td>
                                        <td width="17%" align="center" ><font  size="2" color="#1A1A1A"><b>Jumlah <?echo br();?>Selesai</b></font></td>
										<td width="17%" align="center" ><font  size="2" color="#1A1A1A"><b>Jumlah <?echo br();?>Selesai Sesuai Durasi</b></font></td>
										 <td width="17%" align="center" ><font  size="2" color="#1A1A1A"><b>Jumlah <?echo br();?>Tidak Sesuai Durasi</b></font></td>
										<td width="17%"align="center" ><font  size="2" color="#1A1A1A"><b><?echo br();?> % Ketepatan</b></font></td>
									
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
                                                <td  align="center"> <font  size="2" color="#1A1A1A"><?php echo $i; ?></font> </td>
												 <td > <font  size="2" color="grey"><b><?php //echo $data['n_sektor']; ?>
												<?php 
												
										   echo anchor(site_url('durasisemuabidang/perbidang').'/'.$data['id'] .'/'.$tgla.'/'.$tglb.'/'.$data['n_sektor'] , $data['n_sektor'],  'class="link2-wrc" rel="durasisemuabidang_box"'); 
										
												?>
                                               </font></b> </td>
										 <td  align="center" width="20%"><font  size="2" color="grey">
												
												  
										                <b>
                                                            <?php 
															if(intval($f_jumlah==0)){
echo $f_jumlah;
}else{
                                                            echo anchor(site_url('kinerjasemuabidang/DetailSektorTahun').'/'.$data['id'] .'/'.$tgla.'/'.$tglb.'/'.$data['n_sektor'] , $f_jumlah,  'class="link2-wrc" rel="durasisemuabidang_box"'); 
                                                           // echo $f_jumlah;
														   }
															?>
                                                        </b>
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
										
										<td align="center"><b> <font  size="2" color="grey">
										
										<?php 
										if(intval($dataselesai['jumlah']==0)){
										echo $dataselesai['jumlah'];
										}else{
										//echo $dataselesai['jumlah'];
										   echo anchor(site_url('durasisemuabidang/perbidangselesai').'/'.$data['id'] .'/'.$tgla.'/'.$tglb.'/'.$data['n_sektor'] , $dataselesai['jumlah'],  'class="link2-wrc" rel="durasisemuabidang_box"'); 
										}
										//echo $dataselesai['jumlah']; ?></font></b> </td>
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
		  <td align="center"> <b><font  size="2" color="grey">
		 <?php
		 if(intval($t)==0){
										echo intval($t);
										}else{
										
										   echo anchor(site_url('durasisemuabidang/perbidangsesuai').'/'.$data['id'] .'/'.$tgla.'/'.$tglb.'/'.$data['n_sektor'] ,intval($t),  'class="link2-wrc" rel="durasisemuabidang_box"'); 
		}
		 ?>
		 
		</font> </b></td>
		 
		
		 		 
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
		  <td align="center"> <b><font  size="2" color="grey">
		 <?php
		 if($tidaksesuai==0){
										echo intval($tidaksesuai);
										}else{
										
										   echo anchor(site_url('durasisemuabidang/perbidangtelat').'/'.$data['id'] .'/'.$tgla.'/'.$tglb.'/'.$data['n_sektor'] ,intval($tidaksesuai),  'class="link2-wrc" rel="durasisemuabidang_box"'); 
		}
		 ?>
		 
		</font> </b></td>
		
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
										
										}
										?>
										
                                             </tr> 	
										 
                                        <tr bgcolor="#d5dffe">
                                            <td  align="center"><?php  echo ''; ?></td>
                                            <td  align="center"><font  size="2" color="#1A1A1A"><b>Total</b></font></td>
										<td  align="center"><font  size="2" color="#1A1A1A"><b><?php echo $f_total; ?></b></font></td>
                                            <td  align="center"><font  size="2" color="#1A1A1A"><b><?php echo $total_selesai; ?></b></font></td>
											<td  align="center"><font  size="2" color="#1A1A1A"><b><?php echo $total_tepat; ?></b></font></td>
											<td  align="center"><font  size="2" color="#1A1A1A"><b><?php echo $total_telat; ?></b></font></td>
											
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
