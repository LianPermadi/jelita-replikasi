<div id="content">
    <div class="post">
        <div class="title">
            <h2><?php echo $page_name; ?></h2>
        </div>

        <?php 
            $alert = $this->session->flashdata("sukses");
            if(!empty($alert)){
          ?>
            <br>
            <div style="color: green; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;"><center><?php echo $alert; ?></center></div>
          <?php } ?>

          <?php 
            $alert = $this->session->flashdata("gagal");
            if(!empty($alert)){
          ?>
            <br>
            <div style="color: red; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;"><center><?php echo $alert; ?></center></div>
          <?php } ?>

        <div class="entry">
            <?php
            $add_gis = array(
                'name' => 'button',
                'class' => 'button-wrc',
                'content' => 'Tambah Kategori',
                'onclick' => 'parent.location=\'' . site_url('wilayah/gis/create') . '\''
            );
            echo form_button($add_gis);
            ?>
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="kegiatan">
                <thead>
                    <tr>
                        <th width="10%">No</th>
                        <th>Nama</th>
                        <th>Warna</th>
                        <th width="18%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    foreach ($list as $data) {
                        $i++;
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $data->nama; ?></td>
                            <td><?php echo $data->warna; ?></td>
                            <td width="50">
                    <center>
                        <?php
                        $img_edit = array(
                            'src' => 'assets/images/icon/property.png',
                            'alt' => 'Edit',
                            'title' => 'Edit',
                            'border' => '0',
                        );
                        $img_delete = array(
                            'src' => 'assets/images/icon/cross.png',
                            'alt' => 'Delete',
                            'title' => 'Delete',
                            'border' => '0',
                        );
                        $img_look = array(
                            'src' => 'assets/images/icon/look.png',
                            'alt' => 'Setting Point',
                            'title' => 'Setting Point',
                            'border' => '0',
                        );

                        echo anchor(site_url('wilayah/gis/list_point') . '/' . $data->kode, img($img_look)) . '&nbsp;';

                        echo anchor(site_url('wilayah/gis/edit') . '/' . $data->kode, img($img_edit)) . '&nbsp;';
                        
                        $confirm_text = 'Apakah Anda yakin akan menghapusnya?';
                        echo anchor(site_url('wilayah/gis/delete') . '/' . $data->kode, img($img_delete), ' onClick="return confirm_link(\'' . $confirm_text . '\');"');
                        ?>
                    </center>
                    </td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Warna</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <br style="clear: both;" />
</div>
