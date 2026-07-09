<div id="content">
    <div class="post">
        <div class="title">
            <h2><center><?php echo $page_name; ?></center></h2>
        </div>
<div class="entry">
<form action="<?php echo site_url('pengenalimpor/c_pengenalimpor/simpan_pesan'); ?>" method="post">
<!--<fieldset>-->
<!--<legend><center>Isi Pesan</center></legend>-->

<center> <textarea name="pesan" cols="100" rows="4" required="true"></textarea></center>
<input type="hidden" name="id_tmpemohon" value="<?php echo $id_tmpemohon;?>">
<input type="hidden" name="oleh" value="<?php echo $this->session->userdata('username');?>">

</center>

<center><button type="submit" class="button-wrc" style="width:150px;">Kirim</button>

</center>
<!--</fieldset>-->
</form>

<a href="<?php echo site_url('pengenalimpor/c_pengenalimpor/perusahaan'); ?>" class="button-wrc" style="text-decoration: none;">Kembali</a>
 <br style="clear: both" /><br style="clear: both" />
<table cellpadding="0" cellspacing="0" border="0" class="display" id="dataapi" >
                <thead>
                    <tr>
                      <th width="" >No</th>
                      <th width="" >Pengirim</th>
                       <th width="">Pesan</th>
                      
                    </tr>
                </thead>
                <tbody>
                	 <?php
        if($pesan_table !== "")
        {

            echo $pesan_table;

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

<br style="clear: both" />
       </div>
       </div>
       </div>