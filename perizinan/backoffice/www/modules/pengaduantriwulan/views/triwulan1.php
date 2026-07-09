
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
<title>Pengaduan Pertriwulan</title>
</head>
<!--<body onLoad="window.print()">-->
<body>
    <div id="content" >
    <div class="post">
        <div class="title" align="center">
            <h2><b><?php echo $page_name; ?></b></h2>
			
		
		
        </div>
<form name="form1" method="post">
   
     <fieldset>
         <legend style="color: #045000" align="center"><b>
             <?php
			 echo br();
            echo 'Rekap Pengaduan Triwulan I Tahun'. $tgla;
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
                           'onclick' => 'parent.location=\''. site_url('pengaduantriwulan/lwrekaptriwulan1').'/'.$tgla.'\''
                        );

                        echo img($img_cetak);
      
           $img_cetak = array(
                            'src' => base_url().'assets/images/icon/excel.png',
                            'alt' => 'Cetak ke Ms Excel',
                            'title' => 'Cetak Ke Ms Excel',
                           'onclick' => 'parent.location=\''. site_url('pengaduantriwulan/lerekaptriwulan1').'/'.$tgla.'\'');

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
           <th rowspan="1"><font   color="#1A1A1A"><b>No</b></font></th>
           <th rowspan="1"><font   color="#1A1A1A"><b>Isi Pengaduan</b></font></th>
           <th rowspan="1"><font   color="#1A1A1A"><b>Nama Pengirim</b></font></th>
           <th rowspan="1"><font   color="#1A1A1A"><b>Telepon</b></font></th>
          
           
           <th rowspan="1"><font   color="#1A1A1A"><b>Alamat</b></font></th>
		   <!--<th rowspan="2"><font   color="#1A1A1A"><b>Jmlh Tidak Sesuai Durasi</b></font></th>-->
		   <th rowspan="1"><font   color="#1A1A1A"><b>Tanggal</b></font></th>
		    <th rowspan="1"><font   color="#1A1A1A"><b>Sumber </b></font></th>
			 <th rowspan="1"><font   color="#1A1A1A"><b>Tindakan</b></font></th>
			 <th rowspan="1"><font   color="#1A1A1A"><b>Status</b></font></th>
		   <!--<th rowspan="2"><font   color="#1A1A1A"><b>Persen Keterlambatan</b></font></th>-->
     </tr>
     </thead>
<!---------------------------------------------------------------------------------------------------.-->

<?php
//triwulan 1 

$i=1;
$thn = substr($tgla, 1,5);
//ECHO $thn;
$triwulan1 = "select e_pesan isi,nama, telp telepon,alamat alamat,d_entry tanggal,name sumber,c_tindak_lanjut tindakan,n_sts_pesan status from tmpesan a
inner join tmpesan_trstspesan b on a.id=b.tmpesan_id
inner join trstspesan c on c.sts_pesan_id=b.trstspesan_id
inner join tmpesan_trsumber_pesan d on d.tmpesan_id	= a.id
inner join trsumber_pesan e on e.id=d.trsumber_pesan_id where YEAR(d_entry) = '$thn' and MONTH(d_entry) between'01' and '03'";
                     $hasil_triwulan1 = mysql_query($triwulan1);
                        while ($data = mysql_fetch_assoc(@$hasil_triwulan1)){
						$isi=$data['isi'];
						$nama=$data['nama'];
						$telepon=$data['telepon'];
						$alamat=$data['alamat'];
						$tanggal=$data['tanggal'];
						$sumber=$data['sumber'];
						$tindakan=$data['tindakan'];
						$status=$data['status'];
					
?>
<tr>
<td align="center"><font ><?php echo $i++;?></td>
<td ><font ><?php echo $isi ;?></td>
<td align="center"><font ><?php echo $nama ;?></td>
<td align="center"><font ><?php echo $telepon ;?></td>
<td align="center"><font ><?php echo $alamat ;?></td>
<td align="center"><font ><?php echo $tanggal ;?></td>
<td align="center"><font ><?php echo $sumber ;?></td>
<td align="center"><font ><?php echo $tindakan ;?></td>
<td align="center"><font ><?php echo $status ;?></td>
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
