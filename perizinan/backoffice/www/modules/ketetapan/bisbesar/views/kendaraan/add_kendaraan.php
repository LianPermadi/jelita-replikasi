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
<form method = "POST" action = "<?php echo base_url();?>bisbesar/c_kendaraan/update_aksi" enctype="multipart/form-data">
              <input type="hidden" name ="NO_MOBIL" class="form-control"  required>

            <br style="clear: both" />
            <label>NAMA PEMILIK</label>
            <input type="text" name ="NO_MOBIL" class="form-control" v required  >

            <br style="clear: both" />
            <label>ALAMAT PEMILIK</label>
            <input type="text" name ="NO_MOBIL" class="form-control" v required>

            <br style="clear: both" />
            <label>NOMOR INDUK</label>
            <input type="text" name ="NO_MOBIL" class="form-control" v required>

            <br style="clear: both" />
            <label>NOMOR UJI</label>
            <input type="text" name ="NO_MOBIL" class="form-control" v required>

            <br style="clear: both" />
            <label>MERK / TAHUN</label>
            <input type="text" name ="NO_MOBIL" class="form-control" v required>

            <br style="clear: both" />
            <label>JENIS KENDARAAN</label>
            <input type="text" name ="NO_MOBIL" class="form-control" v required>

            <br style="clear: both" />
            <label>DAYA ANGKUT</label>
            <input type="text" name ="NO_MOBIL" class="form-control" style="width: 50px;" v required> ORANG
            <input type="text" name ="NO_MOBIL" class="form-control" style="width: 50px;" v required> KG

            <br style="clear: both" />
            <label>NAMA PERUSAHAAN</label>
            <input type="text" name ="NO_MOBIL" class="form-control" v required>

            <br style="clear: both" />
            <label>ALAMAT PERUSAHAAN</label>
            <input type="text" name ="NO_MOBIL" class="form-control" v required>

            <br style="clear: both" />
            <label>NO KP</label>
            <input type="text" name ="NO_MOBIL" class="form-control" v required>

            <br style="clear: both" />
            <label>BERLAKU DARI</label>
             <input type="text" name ="NO_MOBIL" class="form-control" style="width: 80px;" v required> s/d
            <input type="text" name ="NO_MOBIL" class="form-control" style="width: 80px;" v required>

            <br style="clear: both" />
            <label>NO SK</label>
            <input type="text" name ="NO_MOBIL" class="form-control" v required>

            <br style="clear: both" />
            <label>TANGGAL BERLAKU SAMPAI</label>
           <input type="text" name ="NO_MOBIL" class="form-control" style="width: 80px;" v required> s/d
            <input type="text" name ="NO_MOBIL" class="form-control" style="width: 80px;" v required>

            <br style="clear: both" />
            <label>KODE TRAYEK</label>
            <input type="number" name ="DA_ORANG" class="form-control" min ="0" value =  required>
           
           <br style="clear: both" />
            <label>TRAYEK</label>
            <input type="text" name ="NO_MOBIL" class="form-control"  required>
          
            <br style="clear: both" />

            <button class="button-wrc" style="margin-left: 100px;">Update</button>
            <a href = <?php echo base_url().'bisbesar/c_kendaraan';?> class= 'button-wrc' style="text-decoration: none;" >Batal</a>
           
    </form>
<!--<div id="" style="width:100%"">
<div id="" style="width:50%;float:left;margin-left: 5%; ">-->
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
