
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
<title>Tingkat Penyelesaian Perjenis Perizinan</title>
</head>
<body>
    <div id="content">
    <div class="post">
	<?php

		$bidangizin=$sektor_id;
		$q = "Select * from trsektor where id='$bidangizin' ";
                    $exe = mysql_query($q);
                   
                    while($row = mysql_fetch_assoc($exe)){
					if($row >0){
         $a=$row['n_sektor'];
		 }
		?>
        <div class="title">
            <center><h2><b><?php echo $page_name; echo br(); echo 'Bidang :  '; echo $a;?></b></h2>
			
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
 <table cellpadding="0" cellspacing="0" border="0" class="display" id="repo">
        <tr>
            <td align="left">
           <?php
		   
                   $Back_data = array(
                   'src' => base_url().'assets/images/icon/back_alt.png',
                    'alt' => 'Lihat di HTML to Openoffice',
                    'title' => 'Kembali',
                    //'onclick' => 'parent.location=\''. site_url('kinerjasemuabidang/view'). '\''
                    'onclick' => 'parent.location=\''. site_url('kinerjasemuabidang').'\''
                    );
                    echo img($Back_data);
            
?>
             <?php
        $img_cetak = array(
                            'src' => base_url().'assets/images/icon/word.png',
                            'alt' => 'Selesai',
                            'title' => 'View Report with OpenOffice',
							'onclick' => 'parent.location=\''. site_url('kinerjasemuabidang/lwperbidang').'/'.$bidangizin .'/'.$tgla.'/'.$tglb.'\''
                        );

                        echo img($img_cetak);
		$img_cetak = array(
                            'src' => base_url().'assets/images/icon/excel.png',
                            'alt' => 'Selesai',
                            'title' => 'View Report with OpenOffice',
                            'onclick' => 'parent.location=\''. site_url('kinerjasemuabidang/leperbidang').'/'.$bidangizin .'/'.$tgla.'/'.$tglb.'\''
                        );

                        echo img($img_cetak);
		 ?>
            </td>
        </tr>
		<?php
		$q="select n_sector from trsektor where id='$bidangizin'";
		$rq = mysql_query($q);
		?>
    </table>
    <table cellpadding="1" cellspacing="0" border="0" class="display" id="reportgrid">
	<thead>
        <tr class="title">
           <th rowspan="2"><font  size="1" color="#1A1A1A"><b>No</b></font></th>
           <th rowspan="2"><font  size="1" color="#1A1A1A"><b>Jenis Perizinan</b></font></th>
           <th rowspan="2"><font  size="1" color="#1A1A1A"><b>Jumlah permohonan</b></font></th>
           <th colspan="2"><font  size="1" color="#1A1A1A"><b>Izin Selesai</b></font></th>
          
           
           <th rowspan="2"><font  size="1" color="#1A1A1A"><b>Izin Dalam Proses</b></font></th>
		   <th rowspan="2"><font  size="1" color="#1A1A1A"><b>Persen Penyelesaian</b></font></th>
     </tr>
     <tr>
           <th><font  size="1" color="#1A1A1A"><b></b>Diterima</font></th>
           <th><font  size="1" color="#1A1A1A"><b>Ditolak</b></font></th>
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
						
						$querytolakfo="select count(a.id) jumlah from tmpermohonan a
                                inner join tmpermohonan_trperizinan b on a.id = b.tmpermohonan_id
                               
								inner join trperizinan e on e.id = b.trperizinan_id
								
                                LEFT JOIN tmpermohonan_trstspermohonan as t6 on a.id = t6.tmpermohonan_id
                                LEFT JOIN trstspermohonan as t7 on t7.id = t6.trstspermohonan_id
                               
                                where b.trperizinan_id = '".$data['id']."' 
                                and t7.id <> 1 and
a.d_terima_berkas between '$tgla' and '$tglb' 
                                and a.status_berkas='Izin Ditolak FO'";
								
								$htolakfo = mysql_query($querytolakfo);
											
while ($dttolakfo = mysql_fetch_assoc(@$htolakfo)){
$tolakfo=$dttolakfo['jumlah'];
//echo $tolakfo;
?>

<?
}

                        while ($rows_data2 = mysql_fetch_assoc(@$hasil_data2)){
                            
							if($rows_data2['status_bap'] == "1"){
                                $jumlah_terbit++;
                            }else if($rows_data2['status_bap'] == "2"){
                                $jumlah_tolak++;
                             
                            }
						}
                        $jumlah_proses = $jumlah_masuk - ($jumlah_terbit + $jumlah_tolak+$tolakfo);
						if( $jumlah_terbit != 0  or $jumlah_tolak != 0 or $jumlah_masuk!=0){
						$persen=(( $jumlah_terbit + $jumlah_tolak+$tolakfo)/$jumlah_masuk)*100;
						}elseif( $jumlah_terbit == 0  && $jumlah_tolak == 0 ){
						$persen = 0;
						} ;

                ?>
                    <tr>
					
                        <td align="center"><?php echo $i; ?></td>
                        <td><?php echo $data['n_perizinan']; ?></td>
                        <td align="center"><?php echo $jumlah_masuk; ?></td>
                        <td align="center"><?php echo $jumlah_terbit; ?></td>
                        <td align="center"><?php echo $jumlah_tolak+$tolakfo; ?></td>
                        <td align="center"><?php echo $jumlah_proses; ?></td>
						<td align="center"><?php  echo number_format($persen,2) ; echo" %"; ?></td>
                    </tr>
                <?php
				$jum[]=$tt;
						$a=array_sum($jum);
						if(array_sum($jum)==null){
												}
						$total_pemohon = intval($a);
                        $totterima=$jumlah_terbit;
						$ttterima +=$totterima;
				$jum2[]=$ttterima;
						$b=array_sum($jum2);
						
						$total_terima = intval($b);
                        $tottolak=$jumlah_tolak;
						$tttolak +=($tottolak+$tolakfo);
				$jum3[]=$tttolak;
						$c=array_sum($jum3);
						
						$total_tolak = intval($c);
						
				//total proses
				
						$totproses=count($jumlah_proses);
						$ttproses +=$totproses;	
			
				$jum4[]=$jumlah_proses;
						$d=array_sum($jum4);
						
						$total_proses = intval($d);
				//persen
                        
						if($total_pemohon==0){
						$total_persen=0;
						
						}else{
						$total_persen =((($total_tolak+$total_terima)/$total_pemohon )*100);
						}
				}
				
				?>
				
	  <tr bgcolor="#d5dffe">
	<?php
	 ?>
	 
	<td align="center"><?php echo $i+1; ?></td>
	<td align="center"><b>TOTAL </b></td>
	<td align="center"><b><?php echo intval($total_pemohon);?><b></td>
	<td align="center"><b><?php echo intval($total_terima);?><b></td>
	<td align="center"><b><?php echo intval($total_tolak);?><b></td>
	<td align="center"><b><?php echo intval($total_proses);?><b></td>
	<td align="center"><b><?php echo number_format($total_persen,2);echo ' %';?><b></td>
	 </tr>
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
