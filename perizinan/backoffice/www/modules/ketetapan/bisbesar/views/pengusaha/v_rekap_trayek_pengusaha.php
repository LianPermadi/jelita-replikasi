
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

$NAMA_PERUS = "";
$NAMA_PEMIL = "";
$ALAMAT_PER = "";

foreach($rekap as $u){

$NAMA_PERUS =$u->NAMA_PERUS;
$NAMA_PEMIL = $u->NAMA_PEMIL;
$ALAMAT_PER = $u->ALAMAT_PER;

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
                        <th width="center">KODE</th>
                        <th width="center">TRAYEK</th>
                        <th width="center">JUMLAH BIS</th>
                        <th width="center">KP HABIS</th>
                        <th width="center">KP BERLAKU</th>
                    </tr>
                </thead>
                <?php
                $i=1;
       $TOTBIS = 0;
       $TOTHABIS = 0;
       $TOTBERLAKU = 0;
           foreach($rekap as $u){
?>
<tr>

<td align="center"><?php echo  $i++;?></td>
<td align="center"><?php echo  $u->KODE_TRAYE;?></td>
<td align="" width="50%"><?php echo  $u->NAMA_TRAYE;?></td>
<td align="center"><?php echo  $u->BIS;?></td>
<td align="center"><?php echo  $u->KP_HABIS;?></td>
<td align="center"><?php echo  $u->KP_BERLAKU;?></td>
</tr>
<?php
$TOTBIS = $TOTBIS + $u->BIS;
$TOTHABIS = $TOTHABIS + $u->KP_HABIS;
$TOTBERLAKU = $TOTBERLAKU + $u->KP_BERLAKU;
 } 
  ?>
        </tbody>
        <tfoot>
                    <tr>
                        <th width="center"></th>
                        <th width="center">TOTAL </th>
                        <th width="center"><?php echo $i-1;?> LINTASAN</th>
                        <th width="center"><?php echo $TOTBIS;?> BIS</th>
                        <th width="center"><?php echo $TOTHABIS;?> BIS</th>
                        <th width="center"><?php echo $TOTBERLAKU;?> BIS</th>
                    </tr>
                </tfoot>
                </table>


       </div>
       </div>
       </div>
