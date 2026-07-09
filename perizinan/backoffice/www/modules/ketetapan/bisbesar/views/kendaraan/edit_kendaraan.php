<?php if(@$msg<>"") 
{
   if(@$msg == "sukses")
    {
    ?>
    <script>alert("Data Berhasil disimpan");window.location.href='../../bisbesar/c_kendaraan'</script>

    <?php
   
    }else{
    ?>
    <script>alert("Data gagal disimpan");window.location.href='../../bisbesar/c_kendaraan'</script>
    <?php

}

}
?>
<div id="content">
    <div class="post">
        <div class="title">
            <h2><?php echo $page_name; ?></h2>
        </div>
<div class="entry">


<a href = <?php echo base_url().'bisbesar/c_kendaraan/addkendaraan';?> class= 'button-wrc' style="text-decoration: none;" >Tambah kendaraan</a>
 <br style="clear: both" />
<br style="clear: both" />
<?php 
$NO_MOBIL= "";
$NO_MOBIL = "";
$NAMA_STNK ="";
$NO_IK = "";
$NO_UJI = "";
$MERK = "";
$JENIS = "";
$DA_ORANG = "";
$DA_BARANG=  "";
$ALAMAT_STN = "";
$NOMOR_KP = "";
$NAMA_TRAYE="";
$NAMA_PERUS = "";
$ALAMAT_PER = "";
$TG_MULAI = "";
$TG_AKHIR ="";
$NO_SK ="";
$KODE_TRAYE ="";
$TG_SK = "";
foreach($bb_kendaraan as $u){ 
$NO_MOBIL = $u->NO_MOBIL;
$NAMA_STNK =$u->NAMA_STNK;
$NO_IK =$u->NO_IK;
$NO_UJI = $u->NO_UJI;
$MERK = $u->MERK;
$JENIS = $u->JENIS;
$DA_ORANG =$u->DA_ORANG;
$DA_BARANG= $u->DA_BARANG;
$ALAMAT_STN = $u->ALAMAT_STN;
 } 

 foreach($bb_kp as $kp){ 
$NOMOR_KP = $kp->NOMOR_KP;
$TG_MULAI =$kp->TG_MULAI;
$TG_AKHIR =$kp->TG_AKHIR;
$NO_UJI = $kp->NO_UJI;
$NO_SK = $kp->NO_SK;
$KODE_TRAYE = $kp->KODE_TRAYE;
$NAMA_TRAYE = $kp->NAMA_TRAYE;

$NAMA_PERUS = $kp->NAMA_PERUS;
$ALAMAT_PER = $kp->ALAMAT_PER;

$TG_SK = $kp->TG_SK; 
// } 
 // foreach($bb_traak as $traak){ 
//$NAMA_TRAYE = $traak->NAMA_TRAYE;
 } 

if($TG_SK != "")
{
$date = $TG_SK ;//"2012-02-16";
$newdate = strtotime ( '-1 day' , strtotime ( $date ) ) ; 
$min1day = date ( 'Y-m-j' , $newdate ); 
$newdate2 = strtotime ( '+1 year' , strtotime ( $min1day ) ) ;
$plus1year = date ( 'Y-m-j' , $newdate2 );
//echo $TG_SK ;
//echo br();
//echo $min1day;
//echo br();
//echo $plus1year;
}else{
   $plus1year = ""; 
}


 ?>
<!--<div id="" style="width:100%"">
<div id="" style="width:50%;float:left;margin-left: 5%; ">-->
<form method = "POST" action = "<?php echo base_url();?>bisbesar/c_kendaraan/update_aksi" enctype="multipart/form-data">
            <br style="clear: both" />
            <label>NOMOR MOBIL</label>
            <input type="text" name ="NO_MOBIL"  value = "<?php echo $NO_MOBIL ; ?> ">


            <br style="clear: both" />
            <label>NAMA PEMILIK</label>
            <input type="text" name ="NAMA_STNK"  value = "<?php echo $NAMA_STNK ; ?> ">

            <br style="clear: both" />
            <label>ALAMAT PEMILIK</label>
            <!--<input type="text" name ="" class="form-control" value = "<?php echo $ALAMAT_STN ; ?>" required>-->
            <textarea name="ALAMAT_STN" class="input-area-wrc" ><?php echo $ALAMAT_STN ; ?></textarea>

            <br style="clear: both" />
            <label>NOMOR INDUK</label>
            <input type="text" name ="" class="form-control" value = "<?php echo $NO_IK ; ?>" required>

            <br style="clear: both" />
            <label>NOMOR UJI</label>
            <input type="text" name ="" class="form-control" value = "<?php echo $NO_UJI ; ?>" required>

            <br style="clear: both" />
            <label>MERK / TAHUN</label>
            <input type="text" name ="" class="form-control" value = "<?php echo $MERK ; ?>" required>

            <br style="clear: both" />
            <label>JENIS KENDARAAN</label>
            <input type="text" name ="" class="form-control" value = "<?php echo $JENIS ; ?>" required>

            <br style="clear: both" />
            <label>DAYA ANGKUT</label>
            <input type="number" name ="" class="form-control" style="width: 50px;" value = "<?php echo $DA_ORANG ; ?>" required> ORANG
            <input type="number" name ="" class="form-control" style="width: 50px;" value = "<?php echo $DA_BARANG; ?>" required> KG

            <br style="clear: both" />
            <label>NAMA PERUSAHAAN</label>
            <input type="text" name ="NAMA_PERUS" class="form-control" value ="<?php echo $NAMA_PERUS;?>" required>

            <br style="clear: both" />
            <label>ALAMAT PERUSAHAAN</label>
             <textarea name="ALAMAT_PER" class="input-area-wrc" ><?php echo $ALAMAT_PER; ?></textarea>

            <br style="clear: both" />
            <label>NO KP</label>
            <input type="text" name ="" class="form-control" value = "<?php echo $NOMOR_KP; ?>" required>

            <br style="clear: both" />
            <label>BERLAKU DARI</label>
             <input type="text" name ="" class="form-control" style="width: 80px;" value="<?php echo $TG_MULAI ; ?>" required> s/d
            <input type="text" name ="" class="form-control" style="width: 80px;" value="<?php echo $TG_AKHIR ; ?> " required>

            <br style="clear: both" />
            <label>NO SK</label>
            <input type="text" name ="" class="form-control" value = "<?php echo $NO_SK; ?>" required>

            <br style="clear: both" />
            <label>TANGGAL BERLAKU SAMPAI</label>
           <input type="text" name ="" class="form-control" style="width: 80px;" value="<?php echo $TG_SK;?>" required> s/d
            <input type="text" name ="" class="form-control" style="width: 80px;" value="<?php echo $plus1year;?>" required>

            <br style="clear: both" />
            <label>KODE TRAYEK</label>
            <input type="text" name ="" class="form-control" min ="0" value = "<?php echo $KODE_TRAYE; ?>"  required>
           
           <br style="clear: both" />
            <label>TRAYEK</label>
            
           <textarea name="" class="input-area-wrc" ><?php echo $NAMA_TRAYE; ?></textarea>

            <br style="clear: both" />

            <button class="button-wrc" style="margin-left: 100px;" onclick="return confirm('Apakah benar data kendaraan ini akan diupdate?');">Update</button>
            <a href = <?php echo base_url().'bisbesar/c_kendaraan';?> class= 'button-wrc' style="text-decoration: none;" >Batal</a>
           
    </form>

<table cellpadding="0" cellspacing="0" border="0" class="display" id="kendaraan" >
                <thead>
                    <tr>
                      <th width="" >No</th>
                       
                        <th width="">NOMOR KENDARAAN</th>
                        <th width="">NOMOR UJI</th>
                        <th width="">AKSI</th>
                    </tr>
                </thead>
                <?php
        if($kendaraan_table !== "")
        {

            echo $kendaraan_table;

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
<!--</div>
<div id="" style="width:30%; float:left; margin-left: 5%;border : 0px solid gray;">
-->

  <!-- </div>
   </div>-->
<br style="clear: both" />
       </div>
       </div>
       </div>


