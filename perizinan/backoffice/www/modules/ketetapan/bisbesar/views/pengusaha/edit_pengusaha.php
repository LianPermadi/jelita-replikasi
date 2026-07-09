
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


<?php 
$PAU_ID = "";
$NAMA_PERUS = "";
$NAMA_PEMIL = "";
$ALAMAT_PER = "";
$TELPON_PER = "";
$ALAMAT_PEM = "";
$TELPON_PEM = "";
$KODYA_ID = "";
$NAMA_KODYA = "";
$NO_IP ="";


foreach($bb_pau as $u){
$PAU_ID =  $u->PAU_ID;
$NO_IP = $u->NO_IP;
$NAMA_PERUS =$u->NAMA_PERUS;
$NAMA_PEMIL = $u->NAMA_PEMIL;
$ALAMAT_PER = $u->ALAMAT_PER;
$TELPON_PER = $u->TELPON_PER;
$ALAMAT_PEM = $u->ALAMAT_PEM;
$TELPON_PEM = $u->TELPON_PEM;
$KODYA_ID = $u->KODYA_ID;
$NAMA_KODYA = $u->NAMA_KODYA;
 } 

 ?>

<form method = "POST" action = "<?php echo base_url();?>bisbesar/c_pengusaha/update_aksi" enctype="multipart/form-data">
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
            <textarea name ="ALAMAT_PER" class="input-area-wrc" ><?php echo $ALAMAT_PER;?></textarea>

            <br style="clear: both" />
            <label>TELEPON PERUSAHAAN</label>
            <input type="text" name ="TELPON_PER" class="form-control" value="<?php echo $TELPON_PER;?>" required>

            <br style="clear: both" />
            <label>ALAMAT PEMILIK</label>
            <!--<input type="text" name ="ALAMAT_PEM" class="form-control" value="<?php echo $ALAMAT_PEM;?>" required>-->
            <textarea name ="ALAMAT_PEM" class="input-area-wrc" ><?php echo $ALAMAT_PEM;?></textarea>

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
            <button class="button-wrc" style="margin-left: 100px;" onclick="return confirm('Apakah benar data pengusaha ini akan diupdate?');">Update</button>
            <a href = <?php echo base_url().'bisbesar/c_pengusaha';?> class= 'button-wrc' style="text-decoration: none;" >Batal</a>
           
    </form>

 <table cellpadding="0" cellspacing="0" border="0" class="display" id="pau" >
                <thead>
                    <tr>
                         <th width="">No</th>
                        <th width="">NO. IP</th>
                        <th width="">NAMA PERUSAHAAN</th>
                        <th width="">NAMA PEMILIK</th>
                        <th width="">ALAMAT PERUSAHAAN</th>
                        <th width="">TELEPON</th>
                        <th width="">Aksi</th>
                    </tr>
                </thead>
                <?php
        if($pau_table !== "")
        {

            echo $pau_table;

        }
        else
        {
        ?>

            <tr>
            <td colspan="6"><center>Tidak ada data</center></td>
            </tr>
            <?php } ?>
        </tbody>
                </table>


       </div>
       </div>
       </div>


