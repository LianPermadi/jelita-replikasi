<div class="isi">
    <div id="entry">
        <h2><?php echo "$title" ?></h2>

        <div class="kiri">
                <div class="izin">
                <p>Dokumen-dokumen prosedur layanan perizinan yang bisa didownload :</p>
                
                
                <table width="100%" cellpadding="0" cellspacing="0" class="blue styled-table">
                    <thead>
                        <tr>
                            <th style="width:80%">Data File Download  </th>
                            <th style="width:20%">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($download as $data) {
                            
                            echo "
                                  <tr>
                                  <td>$data->N_KETERANGAN_DOWNLOAD</td>
                                  <td><a target='_blank' href='".base_url()."uploads/admin_upload/".$data->N_ALAMAT_DOWNLOAD."''>download</a></td>
                                  </tr>
                                 ";
                        }
                        ?>


                    </tbody>
                </table>                
                </div>
        </div>

        <div class="kanan">
            <?php echo "$menu" ?>
            <?php echo "$menu1" ?>
        </div>

    </div>

    <div class="clear"></div>

</div>
