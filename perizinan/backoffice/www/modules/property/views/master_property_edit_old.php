<div id="content">
    <div class="post">
        <div class="title">
            <h2><?php echo $page_name; ?></h2>
        </div>
        <div class="entry">
            <fieldset id="half">
                <legend>Jenis Perizinan</legend>
                <div id="statusRail">
                    <div id="leftRail" class="bg-grid">
                        <?php
                        echo 'Nama Perizinan ';
                        ?>
                    </div>
                    <div id="rightRail" class="bg-grid">
                        <?php
                        echo $nama_izin;
                        ?>
                    </div>
                </div>
                <p style="text-align: right">
                    <?php
                    $img_plus = array(
                        'src' => 'assets/images/icon/plus.png',
                        'alt' => 'Tambah Property',
                        'title' => 'Tambah Property',
                        'border' => '0',
                    );
                    ?>
                    <a class="page-help" href="<?php echo site_url('property/master/add/' . $id); ?>">
                        <?php echo img($img_plus); ?></a>
                    <?php
                    $img_back = array(
                        'src' => 'assets/images/icon/back_alt.png',
                        'alt' => 'Back',
                        'title' => 'Back',
                        'border' => '0',
                    );
                    ?>
                    <a class="page-help" href="<?php echo site_url('property/master/'); ?>">
                        <?php echo img($img_back); ?></a>
                </p>
            </fieldset>
        </div>
        <?php
        if ($ket_exist) {
            echo "<div class='entry' title='Silahkan cari di tab Tambah Property Database' align=center><b style='color: #FF0000;'>Nama property \"" . $ket_exist . "\" sudah ada di Database !!</b></div>";
        }
        ?>
        <div class="entry">
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="property_list">
                <thead>
                    <tr>
                        <th width="2%">No</th>
						<th width="4%">No Fild</th>
                        <th width="20%">Nama Property</th>
                        <th width="10%">Kategori</th>
                        <th width="5%">Parent</th>
                        <th width="5%">Urutan</th>
                        <th width="7%">Kode Retribusi</th>
                        <th width="5%">Surat Izin</th>
                        <th width="5%">SKRD</th>
                        <th width="10%">Tinjauan Lapangan / BAP</th>
                        <th width="7%">Type</th>
						<th width="9%">Combo Item</th>
						<th width="5%">Aktif</th>
                        <th width="4%">Aksi</th>
                    </tr>
                </thead>    
                <tbody>
                    <?php
                    $i = 1;
					$text = $this->lib_date->data_property($id,'2');
					$list = explode (",",$text);
                    foreach ($list as $data) {
					?>
                        <tr>
                            <td>        <?php echo $i; ?></td>
						    <td>        <?php echo $this->lib_date->array_property('0' ,$data); ?></td>
							<td>        <?php echo $this->lib_date->array_property('1' ,$data); ?></td>
							<td>        <?php echo $this->lib_date->array_property('2' ,$data); ?></td>
							<td>        <?php echo $this->lib_date->array_property('3' ,$data); ?></td>
							<td><center><?php echo $this->lib_date->array_property('4' ,$data); ?></center></td>
							<td><center><?php echo $this->lib_date->array_property('5' ,$data); ?></center></td>
							<td><center><?php echo $this->lib_date->array_property('6' ,$data); ?></center></td>
							<td><center><?php echo $this->lib_date->array_property('7' ,$data); ?></center></td>
							<td><center><?php echo $this->lib_date->array_property('8' ,$data); ?></center></td>
							<td><center><?php echo $this->lib_date->array_property('9' ,$data); ?></center></td>
							<td>        <?php echo $this->lib_date->array_property('10',$data); ?></td>
							<td><center><?php echo $this->lib_date->array_property('11',$data); ?></center></td>
                            <td>
							    <center>
                                <?php
                                $img_edit = array(
                                    'src' => 'assets/images/icon/property.png',
                                    'alt' => 'Edit',
                                    'title' => 'Edit',
                                    'border' => '0',
                                );
                                ?>
                                <a class="page-help" href="<?php echo site_url('property/master/property' . "/" . $id . "/" . $i) ?>">
                                    <?php echo img($img_edit); ?>
                                </a>
                                <?php
                                $confirm_text = 'Apakah Anda yakin akan menghapusnya?';
                                $img_cancel = array(
                                    'src' => 'assets/images/icon/cross.png',
                                    'alt' => 'Hapus',
                                    'title' => 'Delete',
                                    'border' => '0',
                                    'onClick' => 'return confirm_link(\'' . $confirm_text . '\')',
                                );
                                ?>

<!--                                    <a class="page-help" href="<?php echo site_url('property/master/delete' . "/" . $data->trperizinan_id . '/' . $data->trproperty_id) ?>">
                                        <?php
                                            if (!$gt_dt) {
                                                echo img($img_cancel);
                                            }
                                        
                                        ?>
                                    </a>

                                    <!-- end edit -->
								</center>
                            </td>
                        </tr>
                       <?php
					   echo form_hidden('end_property', $i);
                       $i++;
                    }
                       ?>
                </tbody>
            </table>
        </div>
    </div>
    <br style="clear: both;" />
</div>
