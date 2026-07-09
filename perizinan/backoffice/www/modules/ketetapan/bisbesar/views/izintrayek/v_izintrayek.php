<?php if(@$msg<>"") 
{
   if(@$msg == "sukses")
    {
    ?>
    <script>alert("Data Berhasil disimpan");window.location.href='../../bisbesar/c_izintrayek'</script>

    <?php
   
    }else{
    ?>
    <script>alert("Data gagal disimpan");window.location.href='../../bisbesar/c_izintrayek'</script>
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
<!--<form method = "POST" action = "<?php echo base_url();?>bisbesar/c_izintrayek/update_aksi" enctype="multipart/form-data">
              <input type="hidden" name ="NO_MOBIL" class="form-control"  required>

            <br style="clear: both" />
            <label>TANGGAL BAND</label>
            <input type="text" name ="NO_MOBIL" class="form-control" v required  >

            <br style="clear: both" />
            <label>JENIS SK</label>
            <input type="text" name ="NO_MOBIL" class="form-control" v required>

            <br style="clear: both" />
            <label>JENIS ANGKUTAN</label>
            <input type="text" name ="NO_MOBIL" class="form-control" v required>

            <br style="clear: both" />
            <label>TARIF BAND</label>
            <input type="text" name ="NO_MOBIL" class="form-control" v required>

            <br style="clear: both" />
            <label>NOMOR INDUK</label>
            <input type="text" name ="NO_MOBIL" class="form-control" v required>

            <br style="clear: both" />
            <label>NAMA PERUSAHAAN</label>
            <input type="text" name ="NO_MOBIL" class="form-control" v required>

            <br style="clear: both" />
            <label>ALAMAT PERUSAHAAN</label>
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
            <a href = <?php echo base_url().'bisbesar/c_izintrayek';?> class= 'button-wrc' style="text-decoration: none;" >Batal</a>
           
    </form>-->
<!--<div id="" style="width:100%"">
<div id="" style="width:50%;float:left;margin-left: 5%; ">-->
 <a href = <?php echo base_url().'bisbesar/c_izintrayek/addsk_izintrayek';?> class= 'button-wrc' style="text-decoration: none;" >Tambah</a>

 <br style="clear: both" />
 <br style="clear: both" />
<table cellpadding="0" cellspacing="0" border="0" class="display" id="izintrayek" >
                <thead>
                    <tr>
                      <th width="" >NO</th>
                       <th width="">TGL BAND</th>
                       <th width="">JENIS SK</th>
                        <th width="">JENIS ANGKUTAN</th>
                       <!-- <th width="">TARIF BAND</th>
                        <th width="">TLT THN</th>
                        <th width="">TLT BLN</th>-->

                        <th width="">NIK</th>
                        <th width="">NAMA PERUSAHAAN</th>
                        <th width="">ALAMAT PERUSAHAAN</th>
                        <th width="">KAB / KOTA</th>
                       <!-- <th width="">NAMA PIMPINAN</th>
                        <th width="">ALAMAT PIMPINAN</th>-->

                        <th width="">NOMOR SK</th>
                        <th width="">TANGGAL</th>
                        <th width="">MASA BERLAKU</th>
                        <th width="">SK LAMA</th>
                        <th width="">TGL SK LAMA</th>

                        <th width="">AKSI</th>
                    </tr>
                </thead>
                <?php
        if($izintrayek_table !== "")
        {

            echo $izintrayek_table;

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
