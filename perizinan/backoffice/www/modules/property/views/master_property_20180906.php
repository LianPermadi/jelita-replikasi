<div id="content">
    <div class="post">
        <div class="title">
            <h2><?php echo $page_name; ?></h2>
        </div>
        <div class="entry">
            <?php
                $add_role = array(
                    'name' => 'button',
                    'class' => 'button-wrc',
                    'content' => 'List Status Property',
                    'onclick' => 'parent.location=\''. site_url('property/master/propertieslist') . '\''
                );
                echo form_button($add_role);
            ?>
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="property">
                <thead>
                    <tr>
                        <th width="2%">No</th>
						<th width="7%">Kode Izin - ID</th>
                        <th width="60%">Jenis Perizinan</th>
                        <th width="10%">Kelompok Perizinan</th>
						<th width="6%">Data Pemohon</th>
                        <th width="8%">Jumlah Property</th>
                        <th width="10%">Template SK</th>
                        <th width="10%">Template Pertek</th>
                        <th width="4%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
					$ok=array();
                    if ($list_izin){
                        foreach ($list_izin as $dt_urg) {
                            $ok[]=$dt_urg->trperizinan_id;
                        }
                    }
                    $i = null;
                    foreach ($list as $data){
						$n_var = $this->lib_date->data_property($data->id,'1');  // ambil jumlah properti
                        $data->trkelompok_perizinan->get();
                        $data->tralur_perizinan->get();
                        $data->trproperty->get();
                        $i++;
						if (in_array($data->id, $ok)){
							$aktif = 'Ada';
							$cek = TRUE;
						} else {
							$aktif = 'Kosong';
							$cek = FALSE;
						}
						if($n_var !== 0){
                            $cek1 = FALSE;
						} else {
                            $cek1 = TRUE;
						}
						if($cek && $cek1) {
						    $b = '<span style="color: Red">';
						    $be = '</span>';
						} else {
                            $b = '';
	    				    $be = '';
						}
                    ?>
                        <tr>
                            <td><?php echo $i; ?></td>
		    				<td><?php echo $b . $data->kd_izin .' - '. $data->id . $be; ?></td>
                            <td><?php echo $b . $data->n_perizinan . $be; ?></td>
                            <td><?php echo $b . $data->trkelompok_perizinan->n_kelompok . $be; ?></td>
                            <td><?php echo $b . "<center>" . $aktif . "</center>" . $be; ?></td>
                            <td><?php
                            	if($n_var !== 0){
                                    echo $b . "<center>" . $n_var . "</center>" . $be;
                                    $title = 'Edit Property';
                                } else {
                                    echo $b . "<center> Belum ada property </center>" . $be;
									$title = 'Menambah Property';
                                }
                                ?>
                            </td>
                            <td>
                                <?php if($data->template!=""){ ?>
                                    <a href="<?php echo base_url()."/assets/template-baru/$data->template"?>">Sudah Diupload</a>
                                <?php }else{ ?>
                                    <span style="color:red">Belum Diupload</span>
                                <?php } ?>
                            </td>
                            <td>
                                <?php if($data->template_gub!=""){ ?>
                                    <a href="<?php echo base_url()."/assets/template-baru/$data->template_gub"?>">Sudah Diupload</a>
                                <?php }else{ ?>
                                    <span style="color:red">Belum Diupload</span>
                                <?php } ?>
                            </td>
                            <td width="50">
                                <center>
                                    <?php
                                    $img_edit = array(
                                        'src' => 'assets/images/icon/property.png',
                                        'alt' => 'Edit',
                                        'title' => $title,
                                        'border' => '0',
                                    );
						    	    if($n_var !== 0){
                                    ?>
                                        <a class="page-help" href="<?php echo site_url('property/master/detail'."/".$data->id) ?>">
								            <?php echo img($img_edit); ?>
								        </a>
                                        <?php
                                    } else {
                                        ?>
									    <a class="page-help" href="<?php echo site_url('property/master/add/' . $data->id); ?>">
                                            <?php echo img($img_edit); ?>
									    </a>
								        <?php
                                    }
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
                        <th width="2%">No</th>
						<th width="7%">Kode Izin - ID</th>
                        <th width="60%">Jenis Perizinan</th>
                        <th width="10%">Kelompok Perizinan</th>
						<th width="6%">Data Pemohon</th>
                        <th width="8%">Jumlah Property</th>
                        <th width="8%">Template SK</th>
                        <th width="8%">Template Pertek</th>
                        <th width="4%">Aksi</th>
					</tr>
                </tfoot>
            </table>
        </div>
    </div>
    <br style="clear: both;" />
</div>
