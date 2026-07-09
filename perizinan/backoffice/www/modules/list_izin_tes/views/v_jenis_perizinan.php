<div id="content">
    <div class="post">
        <div class="title">
            <h2><?php echo $page_name; ?></h2>
        </div>
<div class="entry">
<div id="" style="width:100%"">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="jenis_perizinan" >
                <thead>
                    <tr>
                      <th width="" >No</th>
                       
                        <th width="">NOMOR jenis_perizinan</th>
                        <th width="">NOMOR UJI</th>
                        <th width="">AKSI</th>
                    </tr>
                </thead>
                <?php
        if($jenis_perizinan_table !== "")
        {

            echo $jenis_perizinan_table;

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
<br style="clear: both" />
       </div>
       </div>
       </div>
