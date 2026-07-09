
<script language="javascript" type="text/javascript">
    function popup_link(site, targetDiv){
        $.ajax({url: site,success: function(response){$(targetDiv).html(response);}, dataType: "html"});
    }

    $(document).ready(function() {
        oTable = $('#reportgrid').dataTable({
                "bJQueryUI": true,
                "bDestroy": true,
                "sPaginationType": "full_numbers"
        });

    } );
	</script>
<html>
<head>
<title>Daftar Ketepatan Izin Telat</title>
</head>
<!--<body onLoad="window.print()">-->
<body>
    <div id="content" >
    <div class="post">
        <div class="title" align="center">
          
			<?php
		
		$bidangizin=$sektor_id;
		$q = "Select * from trsektor where id='$bidangizin' ";
                    $exe = mysql_query($q);
                   
                    while($row = mysql_fetch_assoc($exe)){
					if($row >0){
         $a=$row['n_sektor'];
		 }
		?>
		
		
		<div align="center"><h2><b><?php echo $page_name; echo br();echo ' Bidang '; echo $a;?></h2></b></div>
		<?php
		}
		?>
        </div>
<form name="form1" method="post">
   
     <fieldset>
         <legend style="color: #045000" align="center"><b>
             <?php
			 echo br();
            echo 'Periode '. $this->lib_date->mysql_to_human($tgla)." - ".$this->lib_date->mysql_to_human($tglb);
             echo br(2);
			?>
          </legend></b>
 <table  width="100%">
        <tr align="left">
            <td align="left">
           <?php
		     $Back_data = array(
                                                'src' => base_url().'assets/images/icon/back_alt.png',
                                                'alt' => 'Lihat di HTML to Openoffice',
                                                'title' => 'Kembali',
                                                'onclick' => 'parent.location=\''. site_url('durasisemuabidang/durasisemuabidang'). '\''
                                            );
                                            
                                            echo img($Back_data);
          $img_cetak = array(
                            'src' => base_url().'assets/images/icon/word.png',
                            'alt' => 'Cetak ke Ms Word',
                            'title' => 'Cetak ke Ms Word',
                           'onclick' => 'parent.location=\''. site_url('durasisemuabidang/lwdurasitelat').'/'.$bidangizin .'/'.$tgla.'/'.$tglb.'\''
                        );

                        echo img($img_cetak);
      
           $img_cetak = array(
                            'src' => base_url().'assets/images/icon/excel.png',
                            'alt' => 'Cetak ke Ms Excel',
                            'title' => 'Cetak Ke Ms Excel',
                            'onclick' => 'parent.location=\''. site_url('durasisemuabidang/ledurasitelat').'/'.$bidangizin .'/'.$tgla.'/'.$tglb.'\''
                        );

                        echo img($img_cetak);
		 ?>
</td><td>
			 <?php
		
					?>
					</td><td>
					<?php
					
            ?>
            </td>
        </tr>
		
		
    </table>
	
	
     <table cellpadding="1" cellspacing="0" border="0" class="display" id="reportgrid">
        <thead>
		<tr class="title">
           <th rowspan="2"><font  size="1" color="#1A1A1A"><b>No</b></font></th>
           <th rowspan="2"><font  size="1" color="#1A1A1A"><b>No Pendaftaran</b></font></th>
           <th rowspan="2"><font  size="1" color="#1A1A1A"><b>Nama Pemohon</b></font></th>
           <th rowspan="2"><font  size="1" color="#1A1A1A"><b>Objek Izin</b></font></th>
           <th rowspan="2"><font  size="1" color="#1A1A1A"><b>Jenis Perizinan</b></font></th>
           <th colspan="2"><font  size="1" color="#1A1A1A"><b>Tanggal</b></font></th>
          
           
           <th rowspan="2"><font  size="1" color="#1A1A1A"><b>Target Waktu</b></font></th>
		   <!--<th rowspan="2"><font  size="1" color="#1A1A1A"><b>Jmlh Tidak Sesuai Durasi</b></font></th>-->
		   <th rowspan="2"><font  size="1" color="#1A1A1A"><b>Realisasi Target</b></font></th>
		   <!--<th rowspan="2"><font  size="1" color="#1A1A1A"><b>Persen Keterlambatan</b></font></th>-->
     </tr>
     <tr>
           <th><font  size="1" color="#1A1A1A"><b>Terima Berkas</b></font></th>
           <!-- <th><font  size="1" color="#1A1A1A"><b>Diambil</b></font></th>
           <th><font  size="1" color="#1A1A1A"><b>Belum Diambil</b></font></th>-->
           <th><font  size="1" color="#1A1A1A"><b>Selesai Izin</b></font></th>
           <!-- <th><font  size="1" color="#1A1A1A"><b>Diambil</b></font></th>
           <th><font  size="1" color="#1A1A1A"><b>Belum Diambil</b></font></th>
    </tr>-->
    </tr></thead>
<!---------------------------------------------------------------------------------------------------.-->
               <?php
			   //$bidangizin=$this->input->post('id');
                   $bidangizin=$sektor_id;
					$i = 1;
					$tt=0;
					/*
					
                    $query_data = "
					select  a.pendaftaran_id no,e.n_perizinan jenis,a.d_terima_berkas terima,a.d_selesai_proses selesai,i.tgl_surat,i.tgl_surat_edit,e.v_hari durasi,a.a_izin, a.keterangan,
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
where d.c_penetapan = 1 and a.trsektor_id='$bidangizin' and a.d_terima_berkas between '$tgla' and '$tglb'" ;
                    $results = mysql_query($query_data);
                    while ($data = mysql_fetch_assoc(@$results)){
                      
						$tg1=$data['tgl_surat'];
						$tg2=$data['tgl_surat_edit'];
						$tg3=$data['terima'];
						$hari=$data['durasi'];
                     //echo $tg1;
					 //echo $tg3;
					 if($tg2 == '0000-00-00'){
					  $tglselesaiizin =$tg1;
					  }else{
					   $tglselesaiizin = $tg2;
					  }
					  $tselesai=$tglselesaiizin;
					  echo $tselesai;
					  $qholiday="select count(date) holi from tmholiday where date between '$tselesai' and '$tg3'";
$exeholiday = mysql_query($qholiday);
                    while($rowholiday = mysql_fetch_assoc($exeholiday)){
				$holidayperizin = $rowholiday['holi'];
					//echo $holidayperizin;
					}
					  $date1 = $tglselesaiizin; 
					  $date2 = $tg3; 
					  $diff = abs(strtotime($date1) - strtotime($date2)); 
					  $years = floor($diff / (365*60*60*24)); 
					  $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24)); 
					  $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24)); 
					 // echo $days;
					  //echo br();
					 $realisaitarget = ($days + 1) - $holidayperizin;
                       if($realisaitarget > $hari){
					  
					  }else{
					    $i++;
		 ?>
 
                    <tr>
                        <td align="center"><?php echo $i; ?></td>
                        <td align="center"><?php echo $data['no']; ?></td>
                        <td align="center"><?php echo $data['nama']; ?></td>
                        <td align="left"><?php echo $data['jenis']; ?></td>
                        <td align="left"><?php if($data['keterangan'] == '')
						                        echo $data['a_izin'];
					                           else
					                             echo $data['a_izin'].' [ Ket : '.$data['keterangan'].' ]'; ?></td>
                        <td align="center"><?php echo $data['terima'];  ?></td>
                      
                        <td align="center"><?php echo $tglselesaiizin; ?></td>
                     
                        <td align="center"><?php echo $data['durasi']; echo ' Hari'; ?></td>
						<!--<td align="center"><?//php echo intval($k); ?></td>-->
                        <td align="center"><?php echo $realisaitarget; echo ' Hari'; ?></td>
						<!--<td align="center"><?//php echo round($ptr) ; echo ' %'; ?></td>-->
					
                    </tr>
					
                <?php
echo $i;

				}
					}
					$i=0;
					*/
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
					  $jenisijin=$rowizin['jenis'];
					  $nodaftar=$rowizin['no'];
					  $nama=$rowizin['nama'];
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
					$sesuai=$realisasi <= $waktu;
					//echo $sesuai;
					$tot=count($sesuai);
					$tt +=$tot;
					}else{
					$sesuai=$realisasi > $waktu;
					}
				
		 }
		
		 }
		

if($realisasi <=$waktu){
}else{
		 ?>
		 
				<tr>	
					
				<td align = "center"><?php echo $i++; ?></td>
				<td align = "center"> <?php echo $nodaftar; ?></td>
				<td align = "center"><?php echo $nama;?></td>
				<td>
				<?php
				if($rowizin['keterangan'] == '')
						                        echo $rowizin['a_izin'];
					                           else
					                             echo $rowizin['a_izin'].' [ Ket : '.$rowizin['keterangan'].' ]'; ?>
				</td>
				<td><? echo $jenisijin ?></td>
				<td align="center"><?php echo $rowizin['terima'];  ?></td>
				<td align="center"><?php echo $tanggalselesai; ?></td>
				<td align="center"><?php echo $rowizin['durasi']; echo ' Hari'; ?></td>
				<td align="center"><?php echo $realisasi ; echo ' Hari'; ?></td>
					
				</tr>
					<? 
		} 
		}
		 
		
	
	
					?>
					
</table>
         </fieldset>
    
</form>
<?php echo br();?>
        </div>
        </div>
</body>
</html>
