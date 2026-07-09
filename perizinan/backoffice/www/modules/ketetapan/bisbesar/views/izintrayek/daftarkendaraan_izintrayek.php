
<?php if(@$msg<>"") 
{
   if(@$msg == "sukses")
    {
    ?>
    <script>alert("Data Berhasil disimpan");//window.location.href='../../bisbesar/c_pengusaha'</script>

    <?php
   
    }else if(@$msg == "gagal"){
    ?>
    <script>alert("Data gagal disimpan");//window.location.href='../../bisbesar/c_pengusaha'</script>
    <?php

}else{
    
}

}
?>

<div id="content">
    <div class="post">
        <div class="title">
            <h2><?php echo $page_name; ?></h2>
        </div>
<div class="entry">


<?php 
$tgl_sekarang = date("Y-m-d");

$NO_SK = "";
$TG_SK = "";
$BERLAKU = "";
$NAMA_PERUS ="";
$ALAMAT_PER = "";
$PIT_ID = "";
$KP_ID ="";

$i=1;
foreach($bb_izintrayek2 as $u){
 $NO_SK =  $u->NO_SK;
 $TG_SK = $u->TG_SK;
 $BERLAKU = $u->BERLAKU;
 $NAMA_PERUS = $u->NAMA_PERUS;
 $ALAMAT_PER = $u->ALAMAT_PER;
 $PIT_ID = $u->PIT_ID;
 
}

 
foreach($bb_izintrayek as $u){
// $NO_SK =  $u->NO_SK;
// $TG_SK = $u->TG_SK;
 //$BERLAKU = $u->BERLAKU;
 //$NAMA_PERUS = $u->NAMA_PERUS;
// $ALAMAT_PER = $u->ALAMAT_PER;
// $PIT_ID = $u->PIT_ID;
 $KP_ID = $u->KP_ID;
}

 ?> 


 <!--<a style="text-decoration: none;" class= 'button-wrc' href='<?php echo base_url(); ?>bisbesar/c_izintrayek/cetak_izintrayek/<?php echo $PIT_ID;?>' target="_blank"><!--<img src='<?php echo base_url();?>assets/images/icon/sk.png'>--> <!--Cetak SK</a>
 <a style="text-decoration: none;" class= 'button-wrc' href='<?php echo base_url(); ?>bisbesar/c_izintrayek/cetak_daftarkendaraan/<?php echo $PIT_ID;?>' target="_blank">Cetak Daftar Kendaraan</a>-->
 <?php
 if ($KP_ID == "")
 {
?>
<a style="text-decoration: none;" class= 'button-wrc' href='<?php echo base_url(); ?>bisbesar/c_izintrayek/add_kp2/<?php echo $PIT_ID;?>'>Tambah KP kosong</a>
<?php
 }else{
  ?>
  <a style="text-decoration: none;" class= 'button-wrc' href='<?php echo base_url(); ?>bisbesar/c_izintrayek/add_kp/<?php echo $KP_ID;?>'>Tambah KP</a>
  <?php
 }
 ?>
  
 <br>
 <br>
             <label>NOMOR SK</label>
             <input type="text" name ="NO_IP" class="form-control" value="<?php echo $NO_SK; ?>" readonly required>
             <br style="clear: both" />
              <label>MASA BERLAKU IZIN</label>
             <input type="text" style="width:82px;" name ="" class="form-control" value="<?php echo $TG_SK; ?>" readonly required>
              s/d 
             <input type="text" style="width:82px;" name ="" class="form-control" value="<?php echo $BERLAKU;?>" readonly required>
             <br style="clear: both" />
              <label>NAMA PERUSAHAAN</label>
             <input type="text" name ="" class="form-control" value="<?php echo $NAMA_PERUS; ?>" readonly required>
             <br style="clear: both" />
              <label>ALAMAT</label>
            <textarea class="input-area-wrc" readonly="true"><?php echo $ALAMAT_PER;?></textarea>
             <br style="clear: both" />

<!--<form method = "POST" action = "<?php echo base_url();?>bisbesar/c_pengusaha/update_aksi" enctype="multipart/form-data">
 <input type="hidden" name ="PAU_ID" class="form-control" value="<?php echo $PAU_ID; ?>" readonly 
            <br style="clear: both" />
            <label>NOMOR IP</label>
             <input type="text" name ="NO_IP" class="form-control" value="<?php echo $NO_IP; ?>" readonly required>

            <br style="clear: both" />
            <label>NAMA PERUSAHAAN</label>
            <input type="text" name ="NAMA_PERUS" class="form-control" value="<?php echo $NAMA_PERUS;?>" required>

           <br style="clear: both" />
            <label>NAMA PEMILIK</label>
            <input type="text" name ="NAMA_PEMIL" class="form-control" value="<?php echo $NAMA_PEMIL;?>" required>

            <br style="clear: both" />
            <label>ALAMAT PERUSAHAAN</label>
            <!--<input type="text" name ="ALAMAT_PER" class="form-control" value="<?php echo $ALAMAT_PER;?>" required>-->
           <!-- <textarea name ="ALAMAT_PER" class="input-area-wrc" ><?php echo $ALAMAT_PER;?></textarea>

            <br style="clear: both" />
            <label>TELEPON PERUSAHAAN</label>
            <input type="text" name ="TELPON_PER" class="form-control" value="<?php echo $TELPON_PER;?>" required>

            <br style="clear: both" />
            <label>ALAMAT PEMILIK</label>
            <!--<input type="text" name ="ALAMAT_PEM" class="form-control" value="<?php echo $ALAMAT_PEM;?>" required>-->
          <!--  <textarea name ="ALAMAT_PEM" class="input-area-wrc" ><?php echo $ALAMAT_PEM;?></textarea>

            <br style="clear: both" />
            <label>TELEPON PEMILIK</label>
            <input type="text" name ="TELPON_PEM" class="form-control" value="<?php echo $TELPON_PEM;?>" required>

            <br style="clear: both" />
             <label>KODYA / KAB</label>
            <select name ="KODYA_ID_P" class="form-control select" required>
            
            <option selected value = '<?php echo $KODYA_ID;?>' ><?php echo $NAMA_KODYA;?></option>
            <?php echo $kodya; ?>
            </select> 

            <br style="clear: both" />
            <button class="button-wrc" style="margin-left: 100px;">Update</button>
            <a href = <?php echo base_url().'bisbesar/c_pengusaha';?> class= 'button-wrc' style="text-decoration: none;" >Batal</a>
           
    </form>-->

<table cellpadding="0" cellspacing="0" border="0" class="display" id="izintrayek" >
                <thead>
                    <tr>
                         <th width="">No</th>
                        <th width="">NIK</th>
                        <th width="">NOPOL</th>
                        <th width="">NO UJI</th>
                        <th width="">TAHUN</th>
                        <th width="">MERK</th>
                        <th width="">DA</th>
                        <th width="">NAMA TRAYEK</th>
                        <th width="">AKSI</th>
                    </tr>
                </thead>
                <tbody>

                <?php
                foreach($bb_izintrayek as $u2){
                  if($tgl_sekarang >= $u2->TG_AKHIR){
                    ?>
                     <tr>
<td style="color:red"><?php echo $i++ ?></td>
<td style="color:red"><?php echo $u2->NO_IK; ?></td>
<td style="color:red"><?php echo $u2->NO_MOBIL; ?></td>
<td style="color:red"><?php echo $u2->NO_UJI; ?></td>
<td style="color:red"><?php echo $u2->TAHUN_PEMB; ?></td>
<td style="color:red"><?php echo $u2->MERK; ?></td>
<td style="color:red"><?php echo $u2->DA_ORANG; ?></td>
<td style="color:red"><?php echo $u2->NAMATRAYEK; ?></td>
<?php
                  }else{
                    ?>
<td><?php echo $i++ ?></td>
<td><?php echo $u2->NO_IK; ?></td>
<td><?php echo $u2->NO_MOBIL; ?></td>
<td><?php echo $u2->NO_UJI; ?></td>
<td><?php echo $u2->TAHUN_PEMB; ?></td>
<td><?php echo $u2->MERK; ?></td>
<td><?php echo $u2->DA_ORANG; ?></td>
<td><?php echo $u2->NAMATRAYEK; ?></td>
<?php
                  }
                  ?>
                 

<td width="200px"> <a href=<?php echo base_url()."bisbesar/c_izintrayek/editkp_izintrayek/".$u2->NO_IK; ?> class= 'button-wrc' style="text-decoration: none;">Edit KP</a>
<!--<a href=<?php echo base_url()."bisbesar/c_izintrayek/tpdwp/".$u2->KP_ID; ?> class= 'button-wrc' style="text-decoration: none;">TPDWP</a>-->
<a href=<?php echo base_url()."bisbesar/c_izintrayek/edittpdwp/".$u2->KP_ID; ?> class= 'button-wrc' style="text-decoration: none;">TPDWP</a>
 <a style="text-decoration: none;" class= 'button-wrc' href='<?php echo base_url(); ?>bisbesar/c_izintrayek/cetak_kp/<?php echo $u2->NO_IK; ?>' target="_blank">Cetak KP</a>
 <a style="text-decoration: none;" class= 'button-wrc' href='<?php echo base_url(); ?>bisbesar/c_izintrayek/cetak_kp_template/<?php echo $u2->NO_IK; ?>' target="_blank">Cetak KP Template</a>

</td>
                  </tr>
  <?php
}
 ?>
                <?php
       /* if($izintrayek_table !== "")
        {

            echo $izintrayek_table;

        }
        else
        {
        ?>

            <tr>
            <td colspan="6"><center>Tidak ada data</center></td>
            </tr>
            <?php } */?>
        </tbody>
                </table>


       </div>
       </div>
       </div>


