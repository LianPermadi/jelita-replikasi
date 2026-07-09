<div id="content">
    <div class="post">
        <div class="title">
            <h2><center><?php echo $page_name; ?></center></h2>
        </div>
<div class="entry">

 <br style="clear: both" />
<table cellpadding="0" cellspacing="0" border="0" class="display" id="dataapi" >
                <thead>
                    <tr>
                      <th width="" >No</th>
                      <th width="">No API</th>
                      <th width="" >Nama Perusahaan</th>
                      <th width="" >Alamat</th>
                       
                       <!--<th width="">NPWP Perusahaan</th>-->
                        <th width="">Kabupaten/Kota</th>
                        <th width="">Telepon</th>
                       <!-- <th width="">Fax</th>
                        <th width="">Email</th>-->
                        <th width="">Aksi</th>
                       
                    </tr>
                </thead>
                <tbody>
                	 <?php
        if($api_table !== "")
        {

            echo $api_table;

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