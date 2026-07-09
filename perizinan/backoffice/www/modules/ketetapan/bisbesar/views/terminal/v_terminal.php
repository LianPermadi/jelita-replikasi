<?php if(@$msg<>"") 
{
   if(@$msg == "sukses")
    {
    ?>
    <script>alert("Data Berhasil disimpan");window.location.href='../../bisbesar/c_terminal'</script>

    <?php
   
    }else{
    ?>
    <script>alert("Data gagal disimpan");window.location.href='../../bisbesar/c_terminal'</script>
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
<a href = <?php echo base_url().'bisbesar/c_terminal/addTerminal';?> class= 'button-wrc' style="text-decoration: none;" >Tambah Terminal</a>
 <br style="clear: both" />
<br style="clear: both" />

 <table cellpadding="0" cellspacing="0" border="0" class="display" id="terminal" >
                <thead>
                    <tr>
                        <th width="" >No</th>
                       <!-- <th width="">KODE TERMINAL</th>-->
                        <th width="">NAMA TERMINAL</th>
                       <!-- <th width="">ALAMAT TERMINAL</th>
                        <th width="">KABUPATEN / KOTA</th>-->
                        <th width="">KAPASITAS</th>
                        <th width="">TYPE</th>
                        <th width="">Aksi</th>
                    </tr>
                </thead>
                <?php
        if($terminal_table !== "")
        {

            echo $terminal_table;

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


