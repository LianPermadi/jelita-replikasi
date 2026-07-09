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
            echo 'Tambah Data Index Kepuasan Masyarakat ';
			
            // echo br();
			?>
          </legend></b>
<?php
echo form_open('ikm/tambahdata');
echo br();
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

<tr>
<td><strong>Bidang <span style="color:red;">*</strong></td>
<td>:</td>
<td><select name="sektor_id" >
			 <?php
					
$idsektor = $this->form_data->sektor_id;
 
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
<td><strong>Tahun <span style="color:red;">*</strong></td>
<td>:</td>
<td><?php $data = array(
'name'=>'tahun',
'id'=>'tahun',
'maxlength'=>'4',
'onkeypress'=>'return isnumeric(event)',
);
echo form_input($data); ?>
<?php //echo form_error('tahun'); ?>
</td>
</tr>
<tr>
<td><strong>Semester <span style="color:red;">*</strong></td>
<td>:</td>
<td>
<?php 
echo form_radio('semester','1','checked="checked"'); echo 'Semester 1';
echo form_radio('semester','2'); echo 'Semester 2';
 //echo form_error('semester'); 
 ?>
</td>
</tr>
<tr>
<td></td>
<td></td>
<td><strong><span style="color:red;">** Isikan angka ( 0-9 ) untuk pecahan gunakan titik ( . ) ex : 64.6</strong></td>
</tr>
<tr>
<td><strong>Prosedur Pelayanan</strong> <strong><span style="color:red;"> **</strong></td>
<td>:</td>
<td><?php $data = array(
'name'=>'u1',
'id'=>'u1',
'maxlength'=>'5',
'onkeypress'=>'return isnumeric(event)',
);
echo form_input($data); ?></td>
</tr>
<tr>
<td><strong>Persyaratan Pelayanan</strong> <strong><span style="color:red;"> **</strong></td>
<td>:</td>
<td><?php $data = array(
'name'=>'u2',
'id'=>'u2',
'maxlength'=>'5',
'onkeypress'=>'return isnumeric(event)',
);
echo form_input($data); ?></td>
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
echo form_input($data); ?></td>
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
echo form_input($data); ?></td>
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
echo form_input($data); ?></td>
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
echo form_input($data); ?></td>
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
echo form_input($data); ?></td>
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
echo form_input($data); ?></td>
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
echo form_input($data); ?></td>
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
echo form_input($data); ?></td>
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
echo form_input($data); ?></td>
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
echo form_input($data); ?></td>
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
echo form_input($data); ?></td>
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
echo form_input($data); ?></td>
</tr>
<tr>
<td></td>
<td></br></td>
<td><?php echo form_submit('submit','Simpan','id="Submit", class = "button-wrc"'); echo form_submit('reset','Reset','id="reset" class = "button-wrc"'); ?></td>
</tr>
</table>
<?php echo form_close(); ?>
</fieldset>
    
</form>
<?php echo br();?>
        </div>
        </div>
</body>
</html>