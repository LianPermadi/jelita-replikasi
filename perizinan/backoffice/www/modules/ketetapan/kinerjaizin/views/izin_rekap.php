

<html>
<head>
<title>Realisasi Penerimaan</title>
</head>
<!--<body onLoad="window.print()">-->
<body>
    <div id="content">
    <div class="post">
        <div class="title">
            <center><h2><b><?php echo $page_name; ?></b></h2>
			<?php
		
		$bidangizin=$this->input->post('id');
		$q = "Select * from trsektor where id='$bidangizin' ";
                    $exe = mysql_query($q);
                   
                    while($row = mysql_fetch_assoc($exe)){
					if($row >0){
         $a=$row['n_sektor'];
		 }
		?>
		
		
		<div align="center"><h3><b><?php echo 'Bidang :  '; echo $a;?></h3></b></div>
		<?php
		}
		?>
        </div>
<form name="form1" method="post">
   
     <fieldset>
         <legend style="color: #045000" align="center"><b>
             <?php
			 echo br();
            echo 'Rekapitulasi Perizinan Periode '. $this->lib_date->mysql_to_human($tgla)." - ".$this->lib_date->mysql_to_human($tglb);
             echo br(2);
			?>
          </legend></b>
 <table align=left>
        <tr>
            <td align="center">
           <?php
                    $Back_data = array(
                   'src' => base_url().'assets/images/icon/back_alt.png',
                    'alt' => 'Lihat di HTML to Openoffice',
                    'title' => 'Kembali',
                    'onclick' => 'parent.location=\''. site_url('kinerjaizin/izin'). '\''
                    );
                    echo img($Back_data);
            ?>
             <?php
          $img_cetak = array(
                          /*  'src' => base_url().'assets/images/icon/print.png',
                            'alt' => 'Selesai',
                            'title' => 'View Report with OpenOffice',
                            'onclick' => 'parent.location=\''. site_url('kinerjaizin/izin/cetak').'/'.$tgla.'/'.$tglb. '\''
                        */);

                        echo img($img_cetak);
         //    echo anchor(site_url('rekapitulasi/realisasi/cetak_reporting') .'/'. $list_tahun->d_tahun, img($img_cetak))."&nbsp;";
         ?>
            </td>
        </tr>
		<?php
		$bidangizin=$this->input->post('id');
		$q="select n_sector from trsektor where id='$bidangizin'";
		$rq = mysql_query($q);
		?>
		<tr align="center"><?//php echo 'Bidang :'; echo $rq;?></tr>
    </table>
   <table align="center" width="800" border="1" class="display" cellpadding="1" cellspacing="0" id="rev">
        <tr class="title">
           <th rowspan="2"><font  size="1" color="#1A1A1A"><b>No</b></font></th>
           <th rowspan="2"><font  size="1" color="#1A1A1A"><b>Jenis Izin</b></font></th>
           <th rowspan="2"><font  size="1" color="#1A1A1A"><b>Jumlah permohonan</b></font></th>
           <th colspan="2"><font  size="1" color="#1A1A1A"><b>Izin Selesai</b></font></th>
          
           
           <th rowspan="2"><font  size="1" color="#1A1A1A"><b>Izin Dalam Proses</b></font></th>
		   <th rowspan="2"><font  size="1" color="#1A1A1A"><b>Persen Penyelesaian</b></font></th>
     </tr>
     <tr>
           <th><font  size="1" color="#1A1A1A"><b></b>Izin Diterima</font></th>
           <!-- <th><font  size="1" color="#1A1A1A"><b>Diambil</b></font></th>
           <th><font  size="1" color="#1A1A1A"><b>Belum Diambil</b></font></th>-->
           <th><font  size="1" color="#1A1A1A"><b>Izin Ditolak</b></font></th>
           <!-- <th><font  size="1" color="#1A1A1A"><b>Diambil</b></font></th>
           <th><font  size="1" color="#1A1A1A"><b>Belum Diambil</b></font></th>
    </tr>-->
    <tr>
<!---------------------------------------------------------------------------------------------------.-->
               <?php
			   $bidangizin=$this->input->post('id');
                   
					$i = NULL;
                    $query_data = "
					select a.id,a.n_perizinan, a.v_perizinan jumlah from trperizinan a
                                 inner join trperizinan_trsektor b on a.id = b.trperizinan_id where b.trsektor_id='$bidangizin'";
                    $results = mysql_query($query_data);
                    while ($data = mysql_fetch_assoc(@$results)){
                        $i++;
                        $jumlah_masuk = 0;
                        $jumlah_terbit = 0;
                        $terbit_ambil = 0;
                        $terbit_proses = 0;
                        $jumlah_tolak = 0;
                        $tolak_ambil = 0;
                        $tolak_proses = 0;
$tt=0;
$ttterima=0;
$tttolak=0;
$ttproses=0;
$ttpersen=0;
                        $jumlah_proses = 0;
						
                        //jumlah pemohon
                        $query = "select a.id jumlah from tmpermohonan a
                                 inner join tmpermohonan_trperizinan b on a.id = b.tmpermohonan_id
                                 LEFT JOIN tmpermohonan_trstspermohonan as t6 on a.id = t6.tmpermohonan_id
                                 LEFT JOIN trstspermohonan as t7 on t7.id = t6.trstspermohonan_id
								 
                                 where b.trperizinan_id = '".$data['id']."'
                                 and t7.id <> 1 
                                 and a.d_terima_berkas between '$tgla' and '$tglb'";
                        $hasil_data = mysql_query($query);
						$jumlah_masuk=array();
                        $jumlah_masuk = mysql_num_rows(@$hasil_data);
						while ($r2 = mysql_fetch_assoc(@$hasil_data)){
						
						$tot=count($r2['jumlah']);
						$tt +=$tot;
						
						
						}
					
						
						//izin selesai + proses
                        $query2 = "select a.id, a.c_izin_selesai, d.c_penetapan, d.status_bap from tmpermohonan a
                                inner join tmpermohonan_trperizinan b on a.id = b.tmpermohonan_id
                                inner join tmbap_tmpermohonan c on a.id = c.tmpermohonan_id
                                inner join tmbap d on d.id = c.tmbap_id
								inner join trperizinan e on e.id = b.trperizinan_id
                                LEFT JOIN tmpermohonan_trstspermohonan as t6 on a.id = t6.tmpermohonan_id
                                LEFT JOIN trstspermohonan as t7 on t7.id = t6.trstspermohonan_id
                               
                                where b.trperizinan_id = '".$data['id']."' and d.c_penetapan = 1

                                and t7.id <> 1 

                                and a.d_terima_berkas between '$tgla' and '$tglb'";
                        $hasil_data2 = mysql_query($query2);
                        while ($rows_data2 = mysql_fetch_assoc(@$hasil_data2)){
                            
							if($rows_data2['status_bap'] == "1"){
                                $jumlah_terbit++;
								
                                //if($rows_data2['c_izin_selesai'] == "1") $terbit_ambil++;
                                //else $terbit_proses++;
                            }else if($rows_data2['status_bap'] == "2"){
                                $jumlah_tolak++;
                                //if($rows_data2['c_izin_selesai'] == "1") $tolak_ambil++;
                                //else $tolak_proses++;
								
                            }

							
						
						
							
						
						}
                        $jumlah_proses = $jumlah_masuk - ($jumlah_terbit + $jumlah_tolak);
						
						
						
						//$persen= 100*($jumlah_terbit / $jumlah_tolak);
						if( $jumlah_terbit != 0  or $jumlah_tolak != 0 or $jumlah_masuk!=0){
							$persen=(( $jumlah_terbit + $jumlah_tolak)/$jumlah_masuk)*100;
						}elseif( $jumlah_terbit == 0  && $jumlah_tolak == 0 ){
							$persen = 0;
	
						} ;
                ?>
                    <tr>
                        <td align="center"><?php echo $i; ?></td>
                        <td><?php echo $data['n_perizinan']; ?></td>
                        <td align="center"><?php echo $jumlah_masuk; ?></td>
                        <td align="center"><?php echo $jumlah_terbit; ?></td>
                        <td align="center"><?php echo $jumlah_tolak; ?></td>
                        <td align="center"><?php echo $jumlah_proses; ?></td>
						<td align="center"><?php  echo round($persen) ; echo" %"; ?></td>
                    </tr>
                <?php
				
			 			
						
						
						
						
				
				//total jumlah pemohon
				$jum[]=$tt;
						$a=array_sum($jum);
						
						$total_pemohon = number_format($a);
				
				//diterima
                        $totterima=$jumlah_terbit;
						$ttterima +=$totterima;
				$jum2[]=$ttterima;
						$b=array_sum($jum2);
						
						$total_terima = number_format($b);
				//ditolak
                        $tottolak=$jumlah_tolak;
						$tttolak +=$tottolak;
				$jum3[]=$tttolak;
						$c=array_sum($jum3);
						
						$total_tolak = number_format($c);
						
				//total proses
				
						$totproses=count($jumlah_proses);
						$ttproses +=$totproses;	
			
				$jum4[]=$jumlah_proses;
						$d=array_sum($jum4);
						
						$total_proses = number_format($d);
				//persen
                        
						if($total_pemohon==0){
						$total_persen=0;
						
						}else{
						$total_persen =round((($total_tolak+$total_terima)/$total_pemohon )*100); 
						//echo $e;
						
						}
				}
				
				?>
				
	  <tr bgcolor="#d5dffe">
	  <td></td>
	  <td align="center"><b>TOTAL </b></td>
	  <?
	  if (!empty($hasil_data) and !empty($hasil_data2)){
	  ?>
	  <td align="center"><b><?php echo $total_pemohon;?><b></td>
	  <td align="center"><b><?php echo $total_terima;?><b></td>
	  <td align="center"><b><?php echo $total_tolak;?><b></td>
	 <td align="center"><b><?php echo $total_proses;?><b></td>
	 <td align="center"><b><?php echo $total_persen;echo ' %';?><b></td>
	  <?}
	  else
	  {
	  ?>
	  <td align="center"><b><?php // echo $total_pemohon;?><b></td>
	  <td align="center"><b><?php //echo $total_terima;?><b></td>
	  <td align="center"><b><?php //echo $total_tolak;?><b></td>
	 <td align="center"><b><?php //echo $total_proses;?><b></td>
	 <td align="center"><b><?php //echo $total_persen;echo ' %';?><b></td>
	 <?}?>
	  </tr>
	  
<!---------------------------------------------------------------------------------------------------.-->
      
</table>

<?//php echo $rowdatat['jumlahizin'];echo 'xxxxxxx'; echo br(3);?>
         </fieldset>
    
</form>
<?php

 echo br();?>
        </div>
        </div>
</body>
</html>
