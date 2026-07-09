<?php if(@$msg<>"") 
{
   if(@$msg == "sukses")
    {
    ?>
    <script>alert("Data Berhasil disimpan");window.location.href='../../bisbesar/c_lintasan'</script>

    <?php
   
    }else{
    ?>
    <script>alert("Data gagal disimpan");window.location.href='../../bisbesar/c_lintasan'</script>
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


<div style="width: 40%; float:left;">

<form method = "POST" action = "<?php echo base_url();?>bisbesar/c_lintasan/tambah_aksi" enctype="multipart/form-data">
           

            <br style="clear: both" />
            <label>KODE TRAYEK</label>
             <input type="hidden" name ="TRA_ID" class="form-control" required>
            <input type="text" name ="KODE_TRAYE" class="form-control" required>

            <br style="clear: both" />
            <label>NAMA TRAYEK</label>
           <textarea name="NAMA_TRAYE" class="input-area-wrc" required></textarea>
           
            <br style="clear: both" />
            <label>VIA</label>
            <input type="text" name ="VIA"  class="form-control" min ="0" >
            
             <br style="clear: both" />
            <label>KAPASITAS</label>
            <input type="number" min="0" name ="KAPASITAS" class="form-control" min ="0" >
           
              <br style="clear: both" />
            <label>TARIF EKONOMI</label>
            <input type="number" min="0" name ="TARIF_EKON" class="form-control" min ="0" >
           
             <br style="clear: both" />
            <label>TARIF PATAS</label>
            <input type="number" min="0" name ="TARIF_PATA" class="form-control" min ="0" >
           
            <br style="clear: both" />
            <label>KETERANGAN</label>
            <textarea name="KETERANGAN" class="input-area-wrc" ></textarea>
        
            <br style="clear: both" />

            <button class="button-wrc" style="margin-left: 100px;">Simpan</button>
            <a href = <?php echo base_url().'bisbesar/c_lintasan';?> class= 'button-wrc' style="text-decoration: none;" >Batal</a>
           
    </form>
    </div>
     <div style="width:55%; float:left;">
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="lintasan2" >
                <thead>
                    <tr>
                      <th width="" >NO</th>
                       
                        <th width="">BERANGKAT DARI</th>
                        <th width="">TIBA DI</th>
                        <th width="">KM</th>
                    </tr>
                </thead>
                <?php
        if($lintasan2_table !== "")
        {
            ?>
<td></td>
<td></td>
<td></td>
<td></td>
<?php
            //echo $lintasan2_table;

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
                <br>
                <br>
    </div>

    <br style="clear: both" /><br style="clear: both" />
 <table cellpadding="0" cellspacing="0" border="0" class="display" id="lintasan" >
                <thead>
                    <tr>
                      <th width="" >NO</th>
                       
                        <th width="">KODE TRAYEK</th>
                        <th width="">NAMA TRAYEK</th>
                        <th width="">AKSI</th>
                    </tr>
                </thead>
                <?php
        if($lintasan_table !== "")
        {

            echo $lintasan_table;

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


