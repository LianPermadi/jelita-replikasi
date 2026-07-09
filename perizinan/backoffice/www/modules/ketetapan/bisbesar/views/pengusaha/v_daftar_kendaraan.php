
<div id="content">
    <div class="post">
        <div class="title">
            <h2><?php echo $page_name; ?></h2>
        </div>
<div class="entry">
<!--<a href = <?php echo base_url().'bisbesar/c_pengusaha/cetak_daftar_kendaraan';?> class= 'button-wrc' style="text-decoration: none;" >Cetak</a>-->
<a href = <?php echo base_url().'bisbesar/c_pengusaha';?> class= 'button-wrc' style="text-decoration: none;" >Kembali</a>

<br>
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
foreach($bb_pau as $u){
$PAU_ID =  $u->PAU_ID;
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

 <br style="clear: both" />
            <label>NAMA PERUSAHAAN</label>
            <input type="text" name ="NAMA_PERUS" class="form-control" value="<?php echo $NAMA_PERUS;?>" readonly>

            <br style="clear: both" />
            <label>NAMA PEMILIK</label>
            <input type="text" name ="NAMA_PEMIL" class="form-control" value="<?php echo $NAMA_PEMIL;?>" readonly>

            <br style="clear: both" />
            <label>ALAMAT PERUSAHAAN</label>
            <!--<input type="text" name ="ALAMAT_PER" class="form-control" value="<?php echo $ALAMAT_PER;?>" required>-->
            <textarea name ="ALAMAT_PER" class="input-area-wrc" readonly><?php echo $ALAMAT_PER;?></textarea>


 <table cellpadding="0" cellspacing="0" border="0" class="display" id="daftar_kendaraan" >
                <thead>
                    <tr>
                        <th width="center">NO</th>
                        <th width="center">NOMOR KP</th>
                        <th width="center">TGL AKHIR</th>
                        <th width="center">NO.POL</th>
                        <th width="center">NO.UJI</th>
                        <th width="center">THN</th>
                        <th width="center">DA</th>
                        <th width="center">STATUS</th>
                        <th width="center">KODE</th>
                        <th width="center">NAMA TRAYEK</th>
                    </tr>
                </thead>
                <?php
                $i=1;
       
           foreach($kendaraan as $u){
?>
<tr>

<td align="center"><?php echo  $i++;?></td>
<td align="center"><?php echo  $u->NOMOR_KP;?></td>
<td align="center"><?php echo  $u->TG_AKHIR;?></td>
<td align="center"><?php echo  $u->NO_MOBIL;?></td>
<td align="center"><?php echo  $u->NO_UJI;?></td>
<td align="center"><?php echo  $u->TAHUN_PEMB;?></td>
<td align="center"><?php echo  $u->DA_ORANG;?></td>
<td align="center"><?php echo  $u->STATUS;?></td>
<td align="center"><?php echo  $u->KODE_TRAYE;?></td>
<td width="30%"><?php echo  $u->NAMA_TRAYE;?></td>
</tr>
<?php
 } 
  ?>
        </tbody>
                </table>


       </div>
       </div>
       </div>
