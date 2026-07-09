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
                    <!--<li><a href="#tabs-4"><b>ARSIP / PERSYARATAN</b></a></li>	-->
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

	<?php
?>
                            </td>
                            </tbody>
                            </table>
                     </div>
                   
           <?php
       }
       ?>
        </div>