<?php if(@$msg<>"") 
{
   if(@$msg == "sukses")
    {
    ?>
    <script>alert("Data Berhasil disimpan");window.location.href='../../bisbesar/c_pengusaha'</script>

    <?php
   
    }else{
    ?>
    <script>alert("Data gagal disimpan");window.location.href='../../bisbesar/c_pengusaha'</script>
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
<a href = <?php echo base_url().'bisbesar/c_pengusaha/addPengusaha';?> class= 'button-wrc' style="text-decoration: none;" >Tambah Pengusaha</a>
 <br style="clear: both" />
<br style="clear: both" />

 <table cellpadding="0" cellspacing="0" border="0" class="display" id="perizinan" >
                <thead>
                    <tr>
                        <th width="">No</th>
                        <th width="">NO. IP</th>
                        <th width="">NAMA PERUSAHAAN</th>
                        <th width="">NAMA PEMILIK</th>
                        <th width="">ALAMAT PERUSAHAAN</th>
                        <th width="">KOTA / KAB</th>
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


