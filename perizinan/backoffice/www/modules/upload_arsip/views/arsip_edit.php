<style>
    #eror {
        color:#FF0000;
        font-weight:bold;
        text-align:center;
    }

	#eror1 {
        color:#FF0000;
        font-weight:bold;
    }

    .field_error {
        color:#FF0000;
        position:relative;
        font-size: 9px;
        margin: -4% 0 0 74%;
        padding: 0 0 2% 0 ;
    }
</style>
 

<div id="content">
<?php //echo base_url();
//echo $id_daftar;
//echo  $list_daftar->pendaftaran_id;
?>
    <div class="post">
        <div class="title">
            <h2><?php echo $page_name; ?></h2>
        </div>
        <div class="entry">
            <fieldset id="half">
                <legend>Data Perizinan</legend>
                <?php
                if ($paralel == "no") {
                    if ($jenis_izin->id) {
                        ?>
                        <div id="statusRail" style="font-weight: bold">
                            <div id="leftRail" class="bg-grid">
                                <?php echo form_label('Id Perusahaan', 'Id'); ?>
                            </div>
                            <div id="rightRail" class="bg-grid">
                                <?php echo $id_perusahaan; ?>
                                <!-- <input type="hidden" name="nopendaftaran" value = "<?php echo $list_daftar->pendaftaran_id; ?>">
                                <input type="hidden" name="id_perusahaan" value = "<?php echo $id_perusahaan; ?>">-->
                            </div>
                        </div>
						<div id="statusRail" style="font-weight: bold">
                            <div id="leftRail" class="">
                                <?php echo form_label('Nama Perusahaan', 'Nama Perusahaan'); ?>
                            </div>
                            <div id="rightRail" class="">
                                <?php echo $nama_perusahaan; ?>

                                <!--<input type="hidden" name="nama_perusahaan" value = "<?php echo $nama_perusahaan; ?>">-->
                            </div>
                        </div>
                        <div id="statusRail" style="font-weight: bold">
                            <div id="leftRail" class="bg-grid">
                                <?php echo form_label('Nama Izin', 'nama_izin'); ?>
                            </div>
                            <div id="rightRail" class="bg-grid">
                                <?php echo $jenis_izin->n_perizinan; ?>
                            </div>
                        </div>
						<?php
                    } 
                }
                ?>
            </fieldset>
        </div>
        <?php
        if ($eror) {
            echo (" <p id='eror'>$eror</p>");
        }
        ?>
        <p id='eror'><span id="test"></span></p>
        <div class="entry">
            <div id="tabs">
                <ul>
                	<li><a href="#tabs-3"><b>IZIN</b></a></li>      
                    <li><a href="#tabs-4"><b>ARSIP / PERSYARATAN</b></a></li>	
                </ul>
                <?php
                if ($paralel == "yes")
                    $real_id = $list_izin_paralel;
                else
                    $real_id = $jenis_izin->id;
                if ($real_id) {
                    ?>
                     <div id="tabs-3">
                      <table cellpadding="0" cellspacing="0" border="1" class="display">
                            <thead>
                                <tr>
                                    
                                    <th width="64%">Dokumen izin</th>
                                </tr>
                            </thead>
                            <tbody>
                            <td>
                            <?php 
                            $txt = $_SERVER['DOCUMENT_ROOT'].'/siap/assets/upload/syarat/'.$id_perusahaan.' '.$nama_perusahaan.'/'.$list_daftar->pendaftaran_id.' '.$jenis_izin->n_perizinan.'.pdf';
if(file_exists($txt)){
	echo '<center><b><br>Status : Naskah Izin Sudah diupload</b><br>
	</center>';
	?>
	<br>
	<embed src= "<?php echo base_url().'assets/upload/syarat/'.$id_perusahaan.' '.$nama_perusahaan.'/'.$list_daftar->pendaftaran_id.' '.$jenis_izin->n_perizinan.'.pdf';?>" type="application/pdf" width="100%" height="700px">
	<?php
}else{


	echo '<center><b><br>Status : Naskah Belum diupload</b><br>


	</center>';
	
}
?>
<center>
	<form action="<?php echo base_url().'upload_arsip/upload_izin'?>" enctype="multipart/form-data" method="post">
     <input type="hidden" name="id_daftar" value = "<?php echo $id_daftar; ?>">
	 <input type="hidden" name="id_perusahaan" value = "<?php echo $id_perusahaan; ?>">
                                <input type="hidden" name="nama_perusahaan" value = "<?php echo $nama_perusahaan; ?>">
	<input type="hidden" name="jenis_izin" value="<?php echo $jenis_izin->n_perizinan; ?>">
	<input type="hidden" name="nopendaftaran" value="<?php echo $list_daftar->pendaftaran_id;?>">
	<input type="file" name="nama_file" class="button-wrc" accept="application/pdf">
		<input type="submit" name="" value="UPLOAD" class="button-wrc">
<br><br>

	</form>
	</center>
	<?php
?>
                            </td>
                            </tbody>
                            </table>
                     </div>
                    <div id="tabs-4">

                    <form action="<?php echo base_url().'upload_arsip/upload_syarat'?>" method="post" enctype="multipart/form-data">
                        <table cellpadding="0" cellspacing="0" border="1" class="display">
                            <thead>
                                <tr>
                                    <th width="">No</th>
                                    <th width="">Syarat Terlampir Dalam Berkas Permohonan</th>
                                    <th width="">Status</th>
                                    <th width="">File</th>
                                    <th width="">Upload Dokumen</th>
                                </tr>
                            </thead>
                            <tbody>
                           
							    <?php
                                $i = 0;
                                    for($z=1;$z<=2;$z++) {
                                        foreach ($syarat_izin as $data) {
                                            $show_syarat = new trperizinan_syarat();
                                            $show_syarat
                                                ->where('trsyarat_perizinan_id', $data->id)
                                                ->where('trperizinan_id', $jenis_izin->id)->get();
                                            $var = $show_syarat->c_show_type;
		    								$stat_wajib = $show_syarat->status;
                                            if( (int)$stat_wajib == (int)$z ) {
                                                $rule = strval(decbin($var));
                                                if (strlen($rule) < 4) {
                                                    $len = 4 - strlen($rule);
                                                    $rule = str_repeat("0", $len) . $rule;
                                                }
                                                $arr_rule = str_split($rule);

                                                $c_daftar_ulang = $arr_rule[0];
                                                $c_baru = $arr_rule[1];
                                                $c_perpanjangan = $arr_rule[2];
                                                $c_ubah = $arr_rule[3];

                                                $syarat_status = $c_baru;
                                                if ($syarat_status == '1') {
                                                    $i++;
										            echo form_hidden('jumlah_syarat',$i);
                                ?>
                                                    <tr>
                                                        <td width="2%" align="center"><?php echo $i; ?>
                                                         <input type="hidden" name="id_daftar" value = "<?php echo $id_daftar; ?>">
                                                            <input type="hidden" name="nopendaftaran" value = "<?php echo $list_daftar->pendaftaran_id; ?>">
                                							<input type="hidden" name="id_perusahaan" value = "<?php echo $id_perusahaan; ?>">
                                							<input type="hidden" name="nama_perusahaan" value = "<?php echo $nama_perusahaan; ?>">
                                                             <input type="hidden" name="no[]" value = "<?php echo $i; ?>">
                                                        </td>                  <!-- List No Urut -->
                                                        <td width="64%"><?php echo $data->v_syarat; ?>
                                                            
                                                            <input type="hidden" name="syarat[]" value = "<?php echo $data->v_syarat; ?>">
                                                        </td>                   <!-- List nama persyaratan -->
                                                        <td width="4%" align="center">                                        <!-- List status wajib / tidak sebuah persyaratan -->
                                                            <?php
                                                            //if ($data->status == "1")
												         	if ($stat_wajib == "1")
                                                                $status_data = "Wajib";
                                                            else
                                                                $status_data = "Tidak Wajib";
                                                            echo form_label($status_data);
                                                            ?>
                                                        </td>
                                                        <td>
                                                        	<?php
                                                        //	$file = base_url().'assets/upload/syarat/'.$id_perusahaan.' '.$nama_perusahaan.'/'.$data->v_syarat.'.pdf';
							$r1 = str_replace('/',' ',$data->v_syarat);
            $r2 = str_replace(':',' ',$r1);
            $r3 = str_replace('*',' ',$r2);
            $r4 = str_replace('?',' ',$r3);
            $r5 = str_replace('"',' ',$r4);
            $r6 = str_replace('<',' ',$r5);
            $r7 = str_replace('>',' ',$r6);
            $r8 = str_replace('|',' ',$r7);
            $r9 = str_replace('.',' ',$r8);
            $namafile = str_replace('"\"',' ',$r9);					

$txt = $_SERVER['DOCUMENT_ROOT'].'/siap/assets/upload/syarat/'.$id_perusahaan.' '.$nama_perusahaan.'/'.$list_daftar->pendaftaran_id.' '.str_replace('/',' ',substr($namafile,0,150)).'.pdf';
if(file_exists($txt)){
	//echo date("F d Y H:i:s.",filemtime($txt));
	?>
	<a href ="<?php echo base_url().'assets/upload/syarat/'.$id_perusahaan.' '.$nama_perusahaan.'/'.$list_daftar->pendaftaran_id.' '.substr($namafile,0,150).'.pdf';?>" target="_blank"><img src="<?php echo base_url().'assets/images/icon/pdf.png';?>"></a>
	<?php

}else{
	//echo "File yang di cari tidak ada !";
}

                                                        	?>

                                                        </td>
                                                        <td><input type="file" name="nama_file[]" accept="application/pdf"></td>					     						 
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                        }
                                    }
                                ?>

                            </tbody>
                        </table> 
                        <br>
                       
                                       
                        <center><input type="submit" name="button" style="height:26px;" value="simpan" class="button-wrc">
                         </form>
                        <a href="javascript:history.go(-1)" class="button-wrc" style="text-decoration: none">Batal</a>
                        </center>
                <?php
                }
                ?>
            </div>
           
        </div>