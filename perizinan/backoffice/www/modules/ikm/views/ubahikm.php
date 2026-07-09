<script type="application/javascript">

  function isnumeric(evt)
      {
      var charCode = (evt.which) ? evt.which : event.keyCode
          if (charCode != 46 && charCode > 31
            && (charCode < 48 || charCode > 57))
             return false;

          return true;
      }

</script>
<script>
function confirmDialog() {
    return confirm("Apakah anda yakin akan mengubah data ini?")
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

   <table  border="0" width="">
   
        <tr>
            <td >
           <?php
	
                    $Back_data = array(
                   'src' => base_url().'assets/images/icon/back_alt.png',
                    'alt' => 'Lihat di HTML to Openoffice',
                    'title' => 'Kembali',
                    'onclick' => 'parent.location=\''. site_url('ikm/'). '\''
                    );
                  echo img($Back_data);
				
            ?>
           
</td>
        </tr>
		
		
    </table>
     <fieldset>
         <legend style="color: #045000" align="center"><b>
             <?php
			 echo br();
            echo 'Ubah Data Index Kepuasan Masyarakat ';
			
             echo br(2);
			?>
          </legend></b>
<?php
echo form_open('ikm/updatedata/'.$hasilikm->id);
?>
<table align="center">
<!--<tr>
<td><strong>id</strong></td>
<td>:</td>
<td><?php 
$data = array(
'name'=>'id',
'id'=>'id',
'maxlength'=>'',
'onkeypress'=>'return isnumeric(event)',
);
echo form_input($data); ?></td>
</tr>-->
</tr>
<tr>
<td><strong>Bidang</strong><strong><span style="color:red;"> *</strong></td>
<td>:</td>
<td><select name="sektor_id" >
			 <?php
					
$idsektor = $hasilikm->sektor_id;
 
							  $query2 = "SELECT * FROM trsektor where id=$idsektor";
                                $result2 = mysql_query($query2);
 
                                while ($rows2 = mysql_fetch_array($result2)) {
                                //echo "<option value=$rows2[id] selected>$rows2[n_sektor]</option>";
                                //$ids=$rows2['id'];
                                //$ns=$rows2['n_sektor'];
								  echo "<option value=$rows2[id]>$rows2[n_sektor]</option>";
								//echo $ids;
							//	echo $ns;
								}
								?>
                       
                               
                                <?php

 
                                $query = "SELECT * FROM trsektor";
                                $result = mysql_query($query);
 
                                while ($rows = mysql_fetch_array($result)) {
                                echo "<option value=$rows[id]>$rows[n_sektor]</option>";
                                }
                                ?>
                        </select>
			
			
			</td>
</tr>
<tr>
<td><strong>Tahun</strong><strong><span style="color:red;"> *</strong></td>
<td>:</td>
<td><?php $data = array(
'name'=>'tahun',
'id'=>'tahun',
'maxlength'=>'4',
'onkeypress'=>'return isnumeric(event)',
);
echo form_input($data,$hasilikm->tahun); ?>
<?php echo form_error('tahun'); ?>
</td>
</tr>
<tr>
<td><strong>Semester</strong><strong><span style="color:red;"> *</strong></td>
<td>:</td>
<td>

<input type="radio" name="semester" value="1" <?php echo set_radio('semester', '1', $hasilikm->semester == '1'); ?>/> Semester 1
<input type="radio" name="semester" value="2" <?php echo set_radio('semester', '2', $hasilikm->semester == '2'); ?>/> Semester 2
<?php echo form_error('semester'); ?>
</td>


<tr>
<tr>
<td></td>
<td></td>
<td><strong><span style="color:red;">** Isikan angka ( 0-9 ) untuk pecahan gunakan titik ( . ) ex : 64.6</strong></td>
</tr>
<td><strong>Prosedur Pelayanan</strong><strong><span style="color:red;"> **</strong></td>
<td>:</td>
<td><?php $data = array(
'name'=>'u1',
'id'=>'u1',
'maxlength'=>'5',
'onkeypress'=>'return isnumeric(event)',
);
echo form_input($data,$hasilikm->u1); ?></td>
</tr>
<tr>
<td><strong>Persyaratan Pelayanan</strong><strong><span style="color:red;"> **</strong></td>
<td>:</td>
<td><?php $data = array(
'name'=>'u2',
'id'=>'u2',
'maxlength'=>'5',
'onkeypress'=>'return isnumeric(event)',
);
echo form_input($data,$hasilikm->u2); ?></td>
</tr>
<tr>
<td><strong>Kejelasan Petugas Pelayanan</strong><strong><span style="color:red;"> **</strong></td>
<td>:</td>
<td><?php $data = array(
'name'=>'u3',
'id'=>'u3',
'maxlength'=>'5',
'onkeypress'=>'return isnumeric(event)',
);
echo form_input($data,$hasilikm->u3); ?></td>
</tr>
<tr>
<td><strong>Kedisiplinan Petugas Pelayanan</strong><strong><span style="color:red;"> **</strong></td>
<td>:</td>
<td><?php $data = array(
'name'=>'u4',
'id'=>'u4',
'maxlength'=>'5',
'onkeypress'=>'return isnumeric(event)',
);
echo form_input($data,$hasilikm->u4); ?></td>
</tr>
<tr>
<td><strong>Tanggung Jawab Petugas Pelayanan</strong><strong><span style="color:red;"> **</strong></td>
<td>:</td>
<td><?php $data = array(
'name'=>'u5',
'id'=>'u5',
'maxlength'=>'5',
'onkeypress'=>'return isnumeric(event)',
);
echo form_input($data,$hasilikm->u5); ?></td>
</tr>
<tr>
<td><strong>Kemampuan Petugas Pelayanan</strong><strong><span style="color:red;"> **</strong></td>
<td>:</td>
<td><?php $data = array(
'name'=>'u6',
'id'=>'u6',
'maxlength'=>'5',
'onkeypress'=>'return isnumeric(event)',
);
echo form_input($data,$hasilikm->u6); ?></td>
</tr>
<tr>
<td><strong>Kecepatan Pelayanan</strong><strong><span style="color:red;"> **</strong></td>
<td>:</td>
<td><?php $data = array(
'name'=>'u7',
'id'=>'u7',
'maxlength'=>'5',
'onkeypress'=>'return isnumeric(event)',
);
echo form_input($data,$hasilikm->u7); ?></td>
</tr>
<tr>
<td><strong>Keadilan Mendapat Pelayanan</strong><strong><span style="color:red;"> **</strong></td>
<td>:</td>
<td><?php $data = array(
'name'=>'u8',
'id'=>'u8',
'maxlength'=>'5',
'onkeypress'=>'return isnumeric(event)',
);
echo form_input($data,$hasilikm->u8); ?></td>
</tr>
<tr>
<td><strong>Kesopanan dan Keramahan Petugas</strong><strong><span style="color:red;"> **</strong></td>
<td>:</td>
<td><?php $data = array(
'name'=>'u9',
'id'=>'u9',
'maxlength'=>'5',
'onkeypress'=>'return isnumeric(event)',
);
echo form_input($data,$hasilikm->u9); ?></td>
</tr>
<tr>
<td><strong>Kewajaran Biaya Pelayanan</strong><strong><span style="color:red;"> **</strong></td>
<td>:</td>
<td><?php $data = array(
'name'=>'u10',
'id'=>'u10',
'maxlength'=>'5',
'onkeypress'=>'return isnumeric(event)',
);
echo form_input($data,$hasilikm->u10); ?></td>
</tr>
<tr>
<td><strong>Kepastian Biaya Pelayanan</strong><strong><span style="color:red;"> **</strong></td>
<td>:</td>
<td><?php $data = array(
'name'=>'u11',
'id'=>'u11',
'maxlength'=>'5',
'onkeypress'=>'return isnumeric(event)',
);
echo form_input($data,$hasilikm->u11); ?></td>
</tr>
<tr>
<td><strong>Kepastian Jadwal Pelayanan</strong><strong><span style="color:red;"> **</strong></td>
<td>:</td>
<td><?php $data = array(
'name'=>'u12',
'id'=>'u12',
'maxlength'=>'5',
'onkeypress'=>'return isnumeric(event)',
);
echo form_input($data,$hasilikm->u12); ?></td>
</tr>
<tr>
<td><strong>Kenyamanan Lingkungan</strong><strong><span style="color:red;"> **</strong></td>
<td>:</td>
<td><?php $data = array(
'name'=>'u13',
'id'=>'u13',
'maxlength'=>'5',
'onkeypress'=>'return isnumeric(event)',
);
echo form_input($data,$hasilikm->u13); ?></td>
</tr>
<tr>
<td><strong>Keamanan Pelayanan</strong><strong><span style="color:red;"> **</strong></td>
<td>:</td>
<td><?php $data = array(
'name'=>'u14',
'id'=>'u14',
'maxlength'=>'5',
'onkeypress'=>'return isnumeric(event)',
);
echo form_input($data,$hasilikm->u14); ?></td>
</tr>
<tr>
<td></td>
<td></br></td>
<td><?php

 echo form_submit('submit','Ubah', 'id="Submit" class = "button-wrc", onclick = "return confirmDialog();"'); 
 //echo anchor(site_url('ikm/hapusdata/').'/'.$data->id , img($hapus), array('class'=>'delete', 'onclick'=>"return confirmDialog();")); 
				
 ?>
</td>
</tr>
</table>
<?php echo form_close(); ?>
<?php echo br(3);?>
         </fieldset>
    
</form>
<?php echo br();?>
        </div>
        </div>
</body>
</html>
