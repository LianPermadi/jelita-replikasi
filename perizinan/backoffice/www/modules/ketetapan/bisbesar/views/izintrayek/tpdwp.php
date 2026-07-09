
<?php if(@$msg<>"") 
{
   if(@$msg == "sukses")
    {
    ?>
    <script>alert("Data Berhasil disimpan");window.location.href='../../bisbesar/c_pengusaha'</script>

    <?php
   
    }else if(@$msg == "gagal"){
    ?>
    <script>alert("Data gagal disimpan");window.location.href='../../bisbesar/c_pengusaha'</script>
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

<button onclick="goBack()" class="button-wrc">Kembali</button>

<script>
function goBack() {
    window.history.back();
}
</script>
 <br style="clear: both" />
  <br style="clear: both" />
<?php 
$NAMA_PERUS = "";
$ALAMAT_PER = "";
$NO_MOBIL = "";
$NO_UJI = "";
$NOMOR_KP = "";
$TG_MULAI = "";
$TG_AKHIR = "";
$KODE_TRAYE = "";
$NAMA_TRAYE = "";
$NO_SK = "";
$TG_SK = "";

$i=1;
foreach($bb_tpdwp as $u){
 $NAMA_PERUS =  $u->NAMA_PERUS;
 $ALAMAT_PER = $u->ALAMAT_PER;
 $NO_MOBIL = $u->NO_MOBIL;
 $NO_UJI = $u->NO_UJI;
 $NOMOR_KP = $u->NOMOR_KP;
 $TG_MULAI = $u->TG_MULAI;
 $TG_AKHIR = $u->TG_AKHIR;
 $KODE_TRAYE = $u->KODE_TRAYE;
 $NAMA_TRAYE = $u->NAMA_TRAYE;
 $NO_SK = $u->NO_SK;
 $TG_SK = $u->TG_SK;
}
 ?>
            <label>NO KENDARAAN / KONTROL </label>
             <input type="text" name ="NO_MOBIL" class="form-control" value="<?php echo $NO_MOBIL; ?>" readonly required>
             <br style="clear: both" />
              <label>NO KENDARAAN / KONTROL </label>
             <input type="text" name ="NO_MOBIL" class="form-control" value="<?php echo $NO_MOBIL; ?>" readonly required>
             <br style="clear: both" />
              <label>NO KENDARAAN / KONTROL </label>
             <input type="text" name ="NO_MOBIL" class="form-control" value="<?php echo $NO_MOBIL; ?>" readonly required>
             <br style="clear: both" />
              <label>NO KENDARAAN / KONTROL </label>
             <input type="text" name ="NO_MOBIL" class="form-control" value="<?php echo $NO_MOBIL; ?>" readonly required>
             <br style="clear: both" />
              <label>NO KENDARAAN / KONTROL </label>
             <input type="text" name ="NO_MOBIL" class="form-control" value="<?php echo $NO_MOBIL; ?>" readonly required>
             <br style="clear: both" />
              <label>NO KENDARAAN / KONTROL </label>
             <input type="text" name ="NO_MOBIL" class="form-control" value="<?php echo $NO_MOBIL; ?>" readonly required>
             <br style="clear: both" />
              <label>NO KENDARAAN / KONTROL </label>
             <input type="text" name ="NO_MOBIL" class="form-control" value="<?php echo $NO_MOBIL; ?>" readonly required>
             <br style="clear: both" />
              <label>NO KENDARAAN / KONTROL </label>
             <input type="text" name ="NO_MOBIL" class="form-control" value="<?php echo $NO_MOBIL; ?>" readonly required>
             <br style="clear: both" />
              <label>NO KENDARAAN / KONTROL </label>
             <input type="text" name ="NO_MOBIL" class="form-control" value="<?php echo $NO_MOBIL; ?>" readonly required>
             <br style="clear: both" />
              <label>NO KENDARAAN / KONTROL </label>
             <input type="text" name ="NO_MOBIL" class="form-control" value="<?php echo $NO_MOBIL; ?>" readonly required>
             <br style="clear: both" />
              <label>NO KENDARAAN / KONTROL </label>
             <input type="text" name ="NO_MOBIL" class="form-control" value="<?php echo $NO_MOBIL; ?>" readonly required>
             <br style="clear: both" />
              <label>NO KENDARAAN / KONTROL </label>
             <input type="text" name ="NO_MOBIL" class="form-control" value="<?php echo $NO_MOBIL; ?>" readonly required>
             <br style="clear: both" />
              <label>NO KENDARAAN / KONTROL </label>
             <input type="text" name ="NO_MOBIL" class="form-control" value="<?php echo $NO_MOBIL; ?>" readonly required>
             <br style="clear: both" />
              <label>NO KENDARAAN / KONTROL </label>
             <input type="text" name ="NO_MOBIL" class="form-control" value="<?php echo $NO_MOBIL; ?>" readonly required>
             <br style="clear: both" />
              <label>NO KENDARAAN / KONTROL </label>
             <input type="text" name ="NO_MOBIL" class="form-control" value="<?php echo $NO_MOBIL; ?>" readonly required>
             <br style="clear: both" />


             



 <label>NAMA PERUSAHAAN</label>: <?php echo $NAMA_PERUS; ?>
             <!--<input type="text" name ="NAMA_PERUS" class="form-control" value="<?php echo $NAMA_PERUS; ?>" readonly required>-->
             <br style="clear: both" />
              <label>ALAMAT</label> : <?php echo $ALAMAT_PER;?>
           <!--<textarea class="input-area-wrc" name = "ALAMAT_PER" readonly="true"><?php echo $ALAMAT_PER;?></textarea>-->
             <br style="clear: both" />

             <label>NO KENDARAAN / KONTROL </label> : <?php echo $NO_MOBIL; ?> / <?php echo $NO_UJI; ?>
             <!--<input type="text" name ="NO_MOBIL" class="form-control" value="<?php echo $NO_MOBIL; ?>" readonly required>
               <input type="text" name ="NO_UJI" class="form-control" value="<?php echo $NO_UJI; ?>" readonly required>-->
             <br style="clear: both" />

              <label>NO. KP / MASA BERLAKU</label> : <?php echo $NOMOR_KP; ?> / <?php echo $TG_MULAI; ?> s/d <?php echo $TG_AKHIR;?>
              <!--<input type="text" name ="NOMOR_KP" class="form-control" value="<?php echo $NOMOR_KP; ?>" readonly required>
             <input type="text" style="width:82px;" name ="TG_MULAI" class="form-control" value="<?php echo $TG_MULAI; ?>" readonly required>
              s/d 
             <input type="text" style="width:82px;" name ="TG_AKHIR" class="form-control" value="<?php echo $TG_AKHIR;?>" readonly required>-->
             <br style="clear: both" />

             <label>KODE TRAYEK </label> : <?php echo $KODE_TRAYE; ?> - <?php echo $NAMA_TRAYE;?>
             <!--<input type="text" name ="KODE_TRAYE" class="form-control" value="<?php echo $KODE_TRAYE; ?>" readonly required>-->
             <br style="clear: both" />

               <!--<label>TRAYEK </label>
             <textarea class="input-area-wrc" name = "NAMA_TRAYE" readonly="true"><?php echo $NAMA_TRAYE;?></textarea>

             <br style="clear: both" />-->
              
            <label>NO SK </label> : <?php echo  $NO_SK; ?>
             <!--<input type="text" name ="NO_SK" class="form-control" value="<?php echo  $NO_SK; ?>" readonly required>-->
             <br style="clear: both" />

             <label>TANGGAL SK </label> : <?php echo $TG_SK; ?>
             <!--<input type="text" name ="TG_SK" class="form-control" value="<?php echo $TG_SK; ?>" readonly required>-->
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
                        <th width="">KODE TERMINAL</th>
                        <th width="">LINTASAN / KOTA / TERMINAL</th>
                        <th width="">JARAK</th>
                        <th width="">PP - 1</th>
                        <th width="">PP - 1</th>
                        <th width="">PP - 2</th>
                        <th width="">PP - 2</th>
                        <th width="">PP - 3</th>
                        <th width="">PP - 3</th>
                        <th width="">PP - 4</th>
                        <th width="">PP - 4</th>
                        <th width="">PP - 5</th>
                        <th width="">PP - 5</th>
                        <th width="">PP - 6</th>
                        <th width="">PP - 6</th>
                        <th width="">AKSI</th>

                    </tr>
                </thead>
                <tbody>
                <?php
                foreach($bb_tpdwp as $u2){
                  ?>
                  <tr>
<td><?php echo $i++ ?></td>
<td><?php echo $u2->TERMINAL_I; ?></td>
<td><?php echo $u2->NAMA_TERM3; ?></td>
<td><?php echo $u2->JARAK; ?></td>
<td><?php echo $u2->PP1_1; ?></td>
<td><?php echo $u2->PP1_2; ?></td>
<td><?php echo $u2->PP2_1; ?></td>
<td><?php echo $u2->PP2_2; ?></td>
<td><?php echo $u2->PP3_1; ?></td>
<td><?php echo $u2->PP3_2; ?></td>
<td><?php echo $u2->PP4_1; ?></td>
<td><?php echo $u2->PP4_2; ?></td>
<td><?php echo $u2->PP5_1; ?></td>
<td><?php echo $u2->PP5_2; ?></td>
<td><?php echo $u2->PP6_1; ?></td>
<td><?php echo $u2->PP6_2; ?></td>
<td>Tambah || <a <a href=<?php echo base_url()."bisbesar/c_izintrayek/edittpdwp/".$u2->TPDWP_ID ; ?>>Edit tpdwp</a> || Hapus</td>

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


