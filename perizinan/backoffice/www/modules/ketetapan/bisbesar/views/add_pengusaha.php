<div id="content">
    <div class="post">
        <div class="title">
            <h2><?php echo $page_name; ?></h2>
        </div>
        <div class="entry">



    <form method = "POST" action = "<?php echo base_url();?>bisbesar/c_pengusaha/tambah_aksi" enctype="multipart/form-data">
            <br style="clear: both" />
            <label>Nomor IP </label>
            : <input type="text" name ="NO_IP" class="form-control" required>

            <br style="clear: both" />
            <label>Nama Perusahaan</label>
            : <input type="text" name ="NAMA_PERUS" class="form-control" required>

            <br style="clear: both" />
            <label>Nama Pemilik</label>
            : <input type="text" name ="NAMA_PEMIL" class="form-control" required>
       
            <br style="clear: both" />
            <label>Alamat Perusahaan</label>
            : <textarea name="ALAMAT_PER" class="input-area-wrc required" required></textarea>
        
            <br style="clear: both" />
            <label>Telepon Perusahaan</label>
            : <input type="text" name ="TELPON_PER" class="form-control" required>
           
          
            <br style="clear: both" />
            <label>Alamat Pemilik</label>
            : <input type="text" name ="ALAMAT_PEM" class="form-control" required>
       
            <br style="clear: both" />
            <label>Telepon Pemilik</label>
            : <input type="text" name ="TELPON_PEM" class="form-control" required>
       
            <br style="clear: both" />
            <label>Kodya / Kabupaten</label>
            : <select name ="KODYA_ID_P" class="form-control select2" required>
            <?php echo $kodya; ?>
            </select> 

            <br style="clear: both" />
  


<!--- hidden input-->
<input type="text" name ="KODYA_ID_2" class="form-control">
<input type="text" name ="PAU_ID" class="form-control">
<input type="hidden" name ="BARU_26" class="form-control">
<input type="hidden" name ="BARU26_" class="form-control">
<input type="hidden" name ="PRPJ_26" class="form-control">
<input type="hidden" name ="PRPJ26_" class="form-control">
<input type="hidden" name ="PRMJ_26" class="form-control">
<input type="hidden" name ="PRMJ26_" class="form-control">
<input type="hidden" name ="PPTRA_26" class="form-control">
<input type="hidden" name ="PPTRA26_" class="form-control">
<input type="hidden" name ="DUPLIKAT_2" class="form-control">
<input type="hidden" name ="DUPLIKAT26" class="form-control">
<input type="hidden" name ="PIJIN_26" class="form-control">
<input type="hidden" name ="PIJIN26_" class="form-control">
<input type="hidden" name ="RUBAHTRA_2" class="form-control">
<input type="hidden" name ="RUBAHTRA26" class="form-control">
<input type="hidden" name ="TPOSISI_26" class="form-control">
<input type="hidden" name ="TPOSISI26_" class="form-control">
<input type="hidden" name ="RUBAHDWP_2" class="form-control">
<input type="hidden" name ="RUBAHDWP26" class="form-control">
<input type="hidden" name ="BBN_26" class="form-control">
<input type="hidden" name ="BBN26_" class="form-control">
<!--- akhir hidden input-->




            <button class="button-wrc">Simpan</button>
           
    </form>

<table cellpadding="0" cellspacing="0" border="0" class="display" id="perizinan" >
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


