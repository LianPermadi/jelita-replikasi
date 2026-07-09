<?php
	header("Content-Type: application/vnd.ms-word");
    header("Expires: 0");
    header("Cache-Control:  must-revalidate, post-check=0, pre-check=0");
    header("Content-disposition: attachment; filename=Tingkat Penyelesaian Perjenis Perizinan Periode $tgla-$tglb.doc");	
	?>
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
<title>Persentase Izin</title>
</head>

<body>
    <div id="content"style="width: 950px;">
    <div class="post">
        <div class="title">
		

            <center>
			<table border="0">
			<tr  >
			<td align="center" >
			<?php 
			echo br();
			 $img_cetak = array(
                          'src' => base_url().'assets/images/icon/logo Jawa_Barat.png');
              echo img($img_cetak);
			?>
			</td ><td align="center">
			<?php
			
			echo 'BADAN PELAYANAN PERIZINAN TERPADU PROVINSI TASIKMALAYA';
			echo br();
			echo 'Jalan Phh Mustafa Nomor 22 - Telp. (022)7217744 Fax (022)7217755';
			echo br();
			echo 'TASIKMALAYA - TASIKMALAYA';
			?>
			</b></td></tr>
			
			<tr>
			<td width="30%"></td>
			<td align="center">
			<?php 
			
			echo '=======================================================================';
			?>
			</td></tr>
			
			</table>
			<?php
		$bidangizin=$sektor_id;
		$q = "Select * from trsektor where id='$bidangizin' ";
                    $exe = mysql_query($q);
                   
                    while($row = mysql_fetch_assoc($exe)){
					if($row >0){
         $a=$row['n_sektor'];
		 }
		?>
		
		
		<div align="center"><?php echo 'Bidang :  '; echo $a;?></div>
		<?php
		}
		?>
        </div>
<form name="form1" method="post">
   
     <fieldset>
         <legend style="color: #045000" align="center">
             <?php
			 echo br();
echo $page_name; 
echo br();
            echo 'Persentase Penyelesaian Perizinan Periode '. $this->lib_date->mysql_to_human($tgla)." - ".$this->lib_date->mysql_to_human($tglb);
             echo br(2);
			?>
          </legend></b>
 <table cellpadding="0" cellspacing="0" border="0" class="display"  id="repo">
        <tr>
            <td align="center">
           <?php
		$q="select n_sector from trsektor where id='$bidangizin'";
		$rq = mysql_query($q);
		?>
    </table>
    <table cellpadding="1" cellspacing="0" border="1" class="display" id="report">
	<thead>
        <tr bgcolor="#d5dffe">
           <th rowspan="2"><font  size="12px" color="#1A1A1A">No</font></th>
           <th rowspan="2"><font  size="12px" color="#1A1A1A">Jenis Perizinan</font></th>
           <th rowspan="2"><font  size="12px" color="#1A1A1A">Jumlah permohonan</font></th>
           <th colspan="2"><font  size="12px" color="#1A1A1A">Izin Selesai</font></th>
          
          <th rowspan="2"><font  size="12px" color="#1A1A1A">Izin Dalam Proses</font></th>
		   <th rowspan="2"><font  size="12px" color="#1A1A1A">Persen Penyelesaian</font></th>
     </tr>
     <tr bgcolor="#d5dffe">
           <th><font  size="12px" color="#1A1A1A">Diterima</font></th>
           <th><font  size="12px" color="#1A1A1A">Ditolak</font></th>
    </tr>
	</thead>
<!---------------------------------------------------------------------------------------------------.-->
               <?php
			   $bidangizin=$sektor_id;
                   
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
								inner join tmpermohonan_tmsk h on a.id = h.tmpermohonan_id
								inner join tmsk i on h.tmsk_id = i.id
                                LEFT JOIN tmpermohonan_trstspermohonan as t6 on a.id = t6.tmpermohonan_id
                                LEFT JOIN trstspermohonan as t7 on t7.id = t6.trstspermohonan_id
                               
                                where b.trperizinan_id = '".$data['id']."' and d.c_penetapan = 1

                                and t7.id <> 1 

                                and a.d_terima_berkas between '$tgla' and '$tglb'";
                        $hasil_data2 = mysql_query($query2);
                        while ($rows_data2 = mysql_fetch_assoc(@$hasil_data2)){
                            
							if($rows_data2['status_bap'] == "1"){
                                $jumlah_terbit++;
                            }else if($rows_data2['status_bap'] == "2"){
                                $jumlah_tolak++;
								
                            }
						}
                        $jumlah_proses = $jumlah_masuk - ($jumlah_terbit + $jumlah_tolak);
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
						if(array_sum($jum)==null){
												}
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
	 
	 <td align="center"><?php echo $i+1; ?></td>
	  <td align="center"><b>TOTAL </b></td>
	 
	  <td align="center"><b><?php echo $total_pemohon;?><b></td>
	  <td align="center"><b><?php echo $total_terima;?><b></td>
	  <td align="center"><b><?php echo $total_tolak;?><b></td>
	 <td align="center"><b><?php echo $total_proses;?><b></td>
	 <td align="center"><b><?php echo $total_persen;echo ' %';?><b></td>
	  </tr>
	  
<!---------------------------------------------------------------------------------------------------.-->
      
</table>

         </fieldset>  
</form>
<?php

 echo br();?>
        </div>
        </div>
<?php

?>


</body>
</html>
