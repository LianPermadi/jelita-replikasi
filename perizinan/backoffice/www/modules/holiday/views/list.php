<div id="content">
    <div class="post">
        <div class="title">
            <h2><?php echo $page_name; ?></h2>
        </div>
        <div class="entry">
            <?php
                $add_holiday = array(
                    'name' => 'button',
                    'class' => 'button-wrc',
                    'content' => 'Tambah Hari Libur Nasional',
                    'onclick' => 'parent.location=\''. site_url('holiday/create') . '\''
                );
                echo form_button($add_holiday);

				$add_holiday = array(
                    'name' => 'button',
                    'class' => 'button-wrc',
                    'content' => 'Tambah Hari Libur Sabtu dan Minggu',
                    'onclick' => 'parent.location=\''. site_url('holiday/create_sabtu_minggu') . '\''
                );
                echo form_button($add_holiday);
            ?>
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="holiday">
                <thead>
                    <tr>
                        <th width="30%">Tanggal</th>
                        <th width="30%">Keterangan</th>
                        <th width="30%">Tipe Hari Libur</th>
                        <th width="10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    foreach ($list as $data){
                        $kd_tg = $this->lib_date->ambil_tahun($data->date).
							     $this->lib_date->ambil_bulan($data->date,1).
							     $this->lib_date->ambil_tanggal($data->date);
                ?>
                    <tr>
                        <td><?php echo $kd_tg .';  '. $this->lib_date->mysql_to_human($data->date) ?></td>
                        <td><?php echo $data->description; ?></td>
                        <td><?php echo $data->holiday_type; ?></td>
                        <td>
                            <center>
                                <?php
                                $img_edit = array(
                                    'src' => 'assets/images/icon/property.png',
                                    'alt' => 'Edit',
                                    'title' => 'Edit',
                                    'border' => '0',
                                );
                                $confirm_text = 'Apakah Anda yakin akan menghapusnya?';
                                $img_delete = array(
                                    'src' => 'assets/images/icon/cross.png',
                                    'alt' => 'Delete',
                                    'title' => 'Delete',
                                    'border' => '0',
                                    'onClick' => 'return confirm_link(\''.$confirm_text.'\')',
                                );
                                ?>
                                <a class="page-help" href="<?php echo site_url('holiday/edit'."/".$data->id) ?>" ><?php echo img($img_edit); ?></a>
                                <a class="page-help" href="<?php echo site_url('holiday/delete'."/".$data->id) ?>" ><?php echo img($img_delete); ?></a>
                            </center>
                        </td>
                    </tr>
                <?php
                    }
                ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                        <th>Tipe Hari Libur</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <br style="clear: both;" />
</div>
