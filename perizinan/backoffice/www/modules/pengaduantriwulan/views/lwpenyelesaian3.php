<?php
		header("Content-Type: application/vnd.ms-word");
       header("Expires: 0");
        header("Cache-Control:  must-revalidate, post-check=0, pre-check=0");
       // header("Content-disposition: attachment; filename=Perngaduan Pertriwulan Tahun '.  $this->input->post('tgla').doc");
        header("Content-disposition: attachment; filename=Pengaduan triwulan3 tahun $tgla.doc");
		
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
<title>Pengaduan Pertriwulan</title>
</head>

<body>
    <div id="content" style="width: 800px;">
    <div class="post">
        <div class="title" align="center">
				
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
			
			<tr>
			<td width="30%"></td>
			<td align="center">
			<?php 
			
			echo '===================================================================';
			?>
			</td></tr>
			
			</table>
           <font size="12px"><?php echo $page_name; ?></font>
	
            <h2><b><?php //echo $page_name; ?></b></h2>
			
		
		
        </div>
<form name="form1" method="post">
   
     <div align="center">
<font size="12px">            
			<?php
			 echo br();
            echo 'Rekap Penyelesaian Pegaduan Triwulan III Tahun '. $tgla;
             echo br(2);
			?>
			</font>
         </div>

	
	
     <table cellpadding="1" cellspacing="0" border="1" class="display" id="rerid">
        <thead>
		<tr class="title">
           <th rowspan="1"><font  size="12px" color="#1A1A1A"><b>No</b></font></th>
           <th rowspan="1"><font  size="12px" color="#1A1A1A"><b>Isi Pengaduan</b></font></th>
           <th rowspan="1"><font  size="12px" color="#1A1A1A"><b>Nama Pengirim</b></font></th>
           <th rowspan="1"><font  size="12px" color="#1A1A1A"><b>Telepon</b></font></th>
          
           
           <th rowspan="1"><font  size="12px" color="#1A1A1A"><b>Alamat</b></font></th>
		   <!--<th rowspan="2"><font  size="12px" color="#1A1A1A"><b>Jmlh Tidak Sesuai Durasi</b></font></th>-->
		   <th rowspan="1"><font  size="12px" color="#1A1A1A"><b>Tanggal</b></font></th>
		    <th rowspan="1"><font  size="12px" color="#1A1A1A"><b>Sumber </b></font></th>
			 <th rowspan="1"><font  size="12px" color="#1A1A1A"><b>Tindakan</b></font></th>
			 <th rowspan="1"><font  size="12px" color="#1A1A1A"><b>Status</b></font></th>
		   <!--<th rowspan="2"><font  size="12px" color="#1A1A1A"><b>Persen Keterlambatan</b></font></th>-->
     </tr>
     </thead>
<!---------------------------------------------------------------------------------------------------.-->

<?php
//triwulan 1 

$i=1;
$thn = substr($tgla, 1,5);
$triwulan1 = "select e_pesan isi,nama, telp telepon,alamat alamat,d_entry tanggal,name sumber,c_tindak_lanjut tindakan,n_sts_pesan status from tmpesan a
inner join tmpesan_trstspesan b on a.id=b.tmpesan_id
inner join trstspesan c on c.sts_pesan_id=b.trstspesan_id
inner join tmpesan_trsumber_pesan d on d.tmpesan_id	= a.id
inner join trsumber_pesan e on e.id=d.trsumber_pesan_id where YEAR(d_entry) = '$thn' and MONTH(d_entry) between'07' and '09' and c_tindak_lanjut='Ya'";
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
<td align="center"><font size="12px"><?php echo $i++;?></td>
<td ><font size="12px"><?php echo $isi ;?></td>
<td align="center"><font size="12px"><?php echo $nama ;?></td>
<td align="center"><font size="12px"><?php echo $telepon ;?></td>
<td align="center"><font size="12px"><?php echo $alamat ;?></td>
<td align="center"><font size="12px"><?php echo $tanggal ;?></td>
<td align="center"><font size="12px"><?php echo $sumber ;?></td>
<td align="center"><font size="12px"><?php echo $tindakan ;?></td>
<td align="center"><font size="12px"><?php echo $status ;?></td>
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
