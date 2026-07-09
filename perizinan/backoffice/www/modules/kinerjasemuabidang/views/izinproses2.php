
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
</head>
<!--<body onLoad="window.print()">-->
<body>
    <div id="content">
    <div class="post">
        <div class="title" align="center">
            <h2><b><?php echo $page_name; ?></b></h2>
			<?php
		
		$bidangizin=$sektor_id;
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
                                                'onclick' => 'parent.location=\''. site_url('kinerjasemuabidang'). '\''
                                            );
                                            echo img($Back_data);
          $img_cetak = array(
                            'src' => base_url().'assets/images/icon/word.png',
                            'alt' => 'Cetak ke Ms Word',
                            'title' => 'Cetak ke Ms Word',
                           'onclick' => 'parent.location=\''. site_url('kinerjasemuabidang/lwizinproses').'/'.$bidangizin .'/'.$tgla.'/'.$tglb.'\''
                        );

                        echo img($img_cetak);
      
           $img_cetak = array(
                            'src' => base_url().'assets/images/icon/excel.png',
                            'alt' => 'Cetak ke Ms Excel',
                            'title' => 'Cetak Ke Ms Excel',
                            'onclick' => 'parent.location=\''. site_url('kinerjasemuabidang/leizinproses').'/'.$bidangizin .'/'.$tgla.'/'.$tglb.'\''
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
           <th rowspan="1"><font  size="2" color="#1A1A1A"><b>No</b></font></th>
           <th rowspan="1"><font  size="2" color="#1A1A1A"><b>Status Permohonan</b></font></th>
           <th rowspan="1"><font  size="2" color="#1A1A1A"><b>Jumlah</b></font></th>
          
    </tr></thead>
<!---------------------------------------------------------------------------------------------------.-->
               <?php
			    $query = "
					select  count(a.id) jumlah from tmpermohonan a
                                inner join tmpermohonan_trperizinan b on a.id = b.tmpermohonan_id
                                
				inner join trperizinan e on e.id = b.trperizinan_id
                                LEFT JOIN tmpermohonan_trstspermohonan as t6 on a.id = t6.tmpermohonan_id
                                LEFT JOIN trstspermohonan as t7 on t7.id = t6.trstspermohonan_id
where t7.id<>1 and t7.id <> 13 and t7.id <> 14 and t7.id <> 15 and t7.id<>16 and t7.id<>17 
and a.trsektor_id='$bidangizin' and a.d_terima_berkas between '$tgla' and '$tglb' " ;
                    $query_data="$query and t7.id=2  ";
                    $query_data2="$query and t7.id=3  ";
                    $query_data3="$query and t7.id=4  ";
                    $query_data4="$query and t7.id=8  ";
					
					$results = mysql_query($query_data);
                    while ($data = mysql_fetch_assoc(@$results)){
					?>
					<tr>
					<td align="center">1</td>
					<td ><?php echo 'Menerima dan Memeriksa Berkas' ?></td>
					<td align="center" >
					<?
					$jumlah=$data['jumlah'];
					echo $data['jumlah'];
					?>
					</td>
					</tr>
					<?php
					}
					$results2 = mysql_query($query_data2);
                    while ($data2 = mysql_fetch_assoc(@$results2)){
					?>
					<tr>
					<td align="center">2</td>
					<td ><?php echo 'Entri Data' ?></td>
					<td align="center" >
					<?
					$jumlah2=$data2['jumlah'];
					echo $data2['jumlah'];
					?>
					</td>
					</tr>
					<?php
					}
					$results3 = mysql_query($query_data3);
                    while ($data3 = mysql_fetch_assoc(@$results3)){
					?>
					<tr>
					<td align="center">3</td>
					<td ><?php echo 'Pertimbangan Teknis' ?></td>
					<td align="center" >
					<?
					$jumlah3=$data3['jumlah'];
					echo $data3['jumlah'];
					?>
					</td>
					</tr>
					<?php
					}
					$results4 = mysql_query($query_data4);
                    while ($data4 = mysql_fetch_assoc(@$results4)){
					?>
					<tr>
					<td align="center">4</td>
					<td ><?php echo 'Penyusunan / Pencetakan Naskah Perizinan' ?></td>
					<td align="center" >
					<?
					$jumlah4=$data4['jumlah'];
					echo $data4['jumlah'];
					?>
					</td>
					</tr>
					<?php
					}
					?>
					<tr>
					<td align="center">5</td>
					<td align="center"><b><?php echo 'TOTAL' ?></td>
					<td align="center" ><b>
					<?
					$total=$jumlah+$jumlah2+$jumlah3+$jumlah4;
					echo $total;
					?>
					</td>
					</tr>
					<?
			  
					?>
</table>
         </fieldset>
    
</form>
<?php echo br();?>
        </div>
        </div>
</body>
</html>
