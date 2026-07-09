
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
<title>Ketepatan Penyelesaian perizinan</title>
</head>
<!--<body onLoad="window.print()">-->
<body>
    <div id="content" style="width: 800px;">
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
        <tr align="center">
            <td align="center">
           <?php
          $img_cetak = array(
                            'src' => base_url().'assets/images/icon/word.png',
                            'alt' => 'Cetak ke Ms Word',
                            'title' => 'Cetak ke Ms Word',
                           'onclick' => 'parent.location=\''. site_url('durasisemuabidang/lwdurasisesuai').'/'.$bidangizin .'/'.$tgla.'/'.$tglb.'\''
                        );

                        //echo img($img_cetak);
      
           $img_cetak = array(
                            'src' => base_url().'assets/images/icon/excel.png',
                            'alt' => 'Cetak ke Ms Excel',
                            'title' => 'Cetak Ke Ms Excel',
                            'onclick' => 'parent.location=\''. site_url('durasisemuabidang/ledurasisesuai').'/'.$bidangizin .'/'.$tgla.'/'.$tglb.'\''
                        );

                        //echo img($img_cetak);
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
           <th rowspan="2"><font  size="1" color="#1A1A1A"><b>Jenis Perizinan</b></font></th>
           <th colspan="2"><font  size="1" color="#1A1A1A"><b>Tanggal</b></font></th>
          
           
           <th rowspan="2"><font  size="1" color="#1A1A1A"><b>Stastus</b></font></th>
		   <!--<th rowspan="2"><font  size="1" color="#1A1A1A"><b>Jmlh Tidak Sesuai Durasi</b></font></th>
		   <th rowspan="2"><font  size="1" color="#1A1A1A"><b>Realisasi Target</b></font></th>-->
		   <!--<th rowspan="2"><font  size="1" color="#1A1A1A"><b>Persen Keterlambatan</b></font></th>-->
     </tr>
     <tr>
           <th><font  size="1" color="#1A1A1A"><b>Terima Berkas</b></font></th>
           <!-- <th><font  size="1" color="#1A1A1A"><b>Diambil</b></font></th>
           <th><font  size="1" color="#1A1A1A"><b>Belum Diambil</b></font></th>-->
           <th><font  size="1" color="#1A1A1A"><b>Selesai Proses</b></font></th>
           <!-- <th><font  size="1" color="#1A1A1A"><b>Diambil</b></font></th>
           <th><font  size="1" color="#1A1A1A"><b>Belum Diambil</b></font></th>
    </tr>-->
    </tr></thead>
<!---------------------------------------------------------------------------------------------------.-->
               <?php
			   //$bidangizin=$this->input->post('id');
                   $bidangizin=$sektor_id;
					$i = NULL;
                    $query_data = "
					select  a.pendaftaran_id no,e.n_perizinan jenis,a.d_terima_berkas terima,a.d_selesai_proses selesai,t7.n_sts_permohonan status from tmpermohonan a
                                inner join tmpermohonan_trperizinan b on a.id = b.tmpermohonan_id
                                
				inner join trperizinan e on e.id = b.trperizinan_id
                                LEFT JOIN tmpermohonan_trstspermohonan as t6 on a.id = t6.tmpermohonan_id
                                LEFT JOIN trstspermohonan as t7 on t7.id = t6.trstspermohonan_id
where t7.id<>1 and t7.id <> 13 and t7.id <> 14 and t7.id <> 15 and t7.id<>16 and t7.id<>17 and a.trsektor_id='$bidangizin' and a.d_terima_berkas between '$tgla' and '$tglb'" ;
                    $results = mysql_query($query_data);
                    while ($data = mysql_fetch_assoc(@$results)){
                        $i++;
                      
		 ?>
 
                    <tr>
                        <td align="center"><?php echo $i; ?></td>
                        <td><?php echo $data['no']; ?></td>
                        <td align="center"><?php echo $data['jenis']; ?></td>
                        <td align="center"><?php echo $data['terima'];  ?></td>
                      
                        <td align="center"><?php echo $data['selesai']; ?></td>
                     
                       <td align="center"><?php echo $data['status']; ?></td>
						 <!--<td align="center"><?//php echo intval($k); ?></td>
                        <td align="center"><?php echo $data['x']; echo ' Hari'; ?></td>-->
						<!--<td align="center"><?//php echo round($ptr) ; echo ' %'; ?></td>-->
					
                    </tr>
					
                <?php 
				
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
