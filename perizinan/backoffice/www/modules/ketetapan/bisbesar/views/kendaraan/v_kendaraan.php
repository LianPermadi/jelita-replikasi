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

<table cellpadding="0" cellspacing="0" border="0" class="display" id="kendaraan" >
                <thead>
                    <tr>
                      <th width="" >No</th>
                        <th width="">NOMOR INDUK</th>
                        <th width="">NOMOR KENDARAAN</th>
                        <th width="">NOMOR UJI</th>
                        <th width="">DA ORANG</th>
                        <th width="">DA BARANG</th>
                        <th width="">JENIS</th>
                        <th width="">MERK</th>
                        <th width="">THN PEMB</th>
                        <th width="">NOMOR KP</th>
                        <th width="">NAMA STNK</th>
                        <th width="">ALAMAT STNK</th>
                       <!-- <th width="">AKSI</th>-->
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

<br style="clear: both" />
       </div>
       </div>
       </div>
