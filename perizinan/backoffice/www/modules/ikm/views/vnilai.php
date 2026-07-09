
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
<script>
function confirmDialog() {
    return confirm("Apakah anda yakin akan menghapus data ini?")
}
</script>
<html>

<head>
<title></title>
</head>
<!--<body onLoad="window.print()">-->
<body>
    <div id="content">
    <div class="post">
        <div class="title" align="center">
            <h2><b><?php echo $page_name; ?></b></h2>
		
        </div>
<form name="form1" method="post">

   <table  border="0" width="100%">
   
        <tr>
            <td >
           <?php
		   //echo br();
                    $Back_data = array(
                   'src' => base_url().'assets/images/icon/back_alt.png',
                    'alt' => 'Lihat di HTML to Openoffice',
                    'title' => 'Kembali',
                    'onclick' => 'parent.location=\''. site_url('indexkepuasan/person/viewlistikm'). '\''
                    );
                   // echo img($Back_data);
					$tambah = array(
                   'src' => base_url().'assets/images/icon/plus.png',
                    'alt' => 'Lihat di HTML to Openoffice',
                    'title' => 'Tambah Data',
                    'onclick' => 'parent.location=\''. site_url('ikm/tambahdata'). '\''
                    );
                    echo img($tambah);
            ?>
           
</td>
        </tr>
		
		
    </table>
     <fieldset>
         <legend style="color: #045000" align="center"><b>
             <?php
			 echo br();
            echo 'Data Index Kepuasan Masyarakat ';
			
             echo br(2);
			?>
          </legend></b>


<?php 
if(empty($hasilikm)){
echo 'Data Kosong';
}else{
?>

   <table cellpadding="0" cellspacing="0" border="0" class="display" id="reportgrid">
<thead><tr>
<th>No</th>
<th>Tahun</th>
<th>Smstr</th>
<th>Bidang</th>
<th>Prosedur</th>
<th>Persyaratan</th>
<th>Kejelasan</th>
<th>Kedisiplinan</th>
<th>Tanggung Jawab</th>
<th>Kemampuan</th>
<th>Kecepatan</th>
<th>Keadilan</th>
<th>Kesopanan</th>
<th>Kewajaran</th>
<th>Kepastian Biaya</th>
<th>Kepastian Jadwal</th>
<th>Kenyamanan</th>
<th>Keamanan</th>
<th>Action</th>
</tr></thead>

<?php
$no=1;
foreach($hasilikm as $data):
?>
<tr>
<td><?php echo $no; ?></td>
<td><?php echo $data->tahun; ?></td>
<td><?php echo $data->semester; ?></td>
<td><?php $idsektor=$data->sektor_id; 
 $query2 = "SELECT * FROM trsektor where id=$idsektor";
                                $result2 = mysql_query($query2);
 
                                while ($rows2 = mysql_fetch_array($result2)) {
								echo $rows2['n_sektor'];
								}
?></td>
<td><?php echo $data->u1; ?></td>
<td><?php echo $data->u2; ?></td>
<td><?php echo $data->u3; ?></td>
<td><?php echo $data->u4; ?></td>
<td><?php echo $data->u5; ?></td>
<td><?php echo $data->u6; ?></td>
<td><?php echo $data->u7; ?></td>
<td><?php echo $data->u8; ?></td>
<td><?php echo $data->u9; ?></td>
<td><?php echo $data->u10; ?></td>
<td><?php echo $data->u11; ?></td>
<td><?php echo $data->u12; ?></td>
<td><?php echo $data->u13; ?></td>
<td><?php echo $data->u14; ?></td>
<td>
<?php
$edit = array(
                   'src' => base_url().'assets/images/icon/clipboard-doc.png',
                    'title'=>'edit'
					);
echo anchor(site_url('ikm/updatedata/').'/'.$data->id , img($edit)); 

$hapus = array(
                   'src' => base_url().'assets/images/icon/cross.png',
                    'title'=>'hapus'
					);
//echo anchor(site_url('ikm/hapusdata/').'/'.$data->id , img($hapus)); 

				 echo anchor(site_url('ikm/hapusdata/').'/'.$data->id , img($hapus), array('class'=>'delete', 'onclick'=>"return confirmDialog();")); 
				?>
		




</tr>
<?php
$no++;
endforeach;
?>
</table>
<?php
}
?>
 </fieldset>
    
</form>
<?php echo br();?>
        </div>
        </div>
</body>
</html>
