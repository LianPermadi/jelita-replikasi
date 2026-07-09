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
								<table border='1'>
<?php
$i=1;
$jumlah=0;
$tt=0;
$qbidang = "Select * from trsektor ";
                    $exebidang = mysql_query($qbidang);
                   
                    while($rowbidang = mysql_fetch_assoc($exebidang)){
					if($rowbidang >0){
         $a=$rowbidang['id'];
		 $bidangizin=$a;
		 }
		 
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
					$sesuai=$realisasi <= $waktu;
					//echo $sesuai;
					$tot=count($sesuai);
						$tt +=$tot;
					}else{
					$sesuai=$realisasi > $waktu;
					}
				
		 }
		
		 }
		
}

		 ?>
					<tr>
					
					<td><?php echo $tt; 
					$tt=0;
					?></td>
					
					</tr>
					<? 
		 
		
		 }
		
	
	?>	
	
</table>
                            </fieldset>

		              
                </div>

            </form>
        </div>
    </div>
</body>
</html>
