<div id="content">
    <div class="post">
        <div class="title">
            <h2><?php echo $page_name; ?></h2>
        </div>
        <?php
        $attr = array('id' => 'form');
        echo form_open('settings/bidang/' . $save_method, $attr);
        echo form_hidden('id', $id);
        ?>
        <div class="entry">
            <div id="tabs">
                <ul>
                    <li><a href="#tabs-1">Data Bidang Perizinan</a></li>
                </ul>
                <div id="tabs-1">
                    <div id="contentleft">
						<tr>
                            <td><label class="label-wrc">Nama Bidang Perizinan</label></td>
                            <td>
                                <?php
                                    $nama_input = array(
                                        'name' => 'nama',
                                        'value' => $nama,
                                        'class' => 'input-wrc required'
                                    );
                                    echo form_input($nama_input);
                                ?>
                            </td>
                        </tr>
                        <br style="clear: both;" />

						<tr>
                            <td><label class="label-wrc">Urutan Bidang Perizinan</label></td>
                            <td>
                                <?php
                                    $urutan_input = array(
                                        'name' => 'urutan',
                                        'value' => $urutan,
                                        'class' => 'input-wrc required'
                                    );
                                    echo form_input($urutan_input);
                                ?>
                            </td>
                        </tr>
                        <br style="clear: both;" />

                        <tr>
                            <td><label class="label-wrc">Format Nomor PerTek</label></td>
							<td>
                                <?php
                                    $no_awal_pertek_input = array(
                                        'name' => 'no_pertek_awal',
                                        'value' => $no_pertek_awal,
                                        'style'=>'width:5%'
                                    );
                                    $no_akhir_pertek_input = array(
                                        'name' => 'no_pertek_akhir',
                                        'value' => $no_pertek_akhir,
                                        'style'=>'width:10%'
                                    );
                                    echo form_input($no_awal_pertek_input)." ";
                                    echo ' / xxxx / ';
                                    echo form_input($no_akhir_pertek_input)." ";
                                ?>
					        </td>
					    </tr>
					    <br style="clear: both" />
						<br/>

						<tr>
                            <td><label class="label-wrc">Format Nomor Surat Perintah</label></td>
							<td>
                                <?php
                                    $no_awal_sp_input = array(
                                        'name' => 'no_sp_awal',
                                        'value' => $no_sp_awal,
                                        'style'=>'width:5%'
                                    );
                                    $no_akhir_sp_input = array(
                                        'name' => 'no_sp_akhir',
                                        'value' => $no_sp_akhir,
                                        'style'=>'width:10%'
                                    );
                                    echo form_input($no_awal_sp_input)." ";
                                    echo ' / xxxx / ';
                                    echo form_input($no_akhir_sp_input)." ";
                                ?>
					        </td>
					    </tr>
					    <br style="clear: both" />

						<tr>
                            <td><label class="label-wrc">Penandatangan Surat Perintah</label></td>
                            <td>
                                <select name="ttd_sp" id="ttd_sp" class="input-wrc required">
                                    <?php
                                    $selected = NULL;
                                    foreach ($petugas as $petugas_data) {
                                        if ($petugas_data->id == $tgs_id_sp) {
                                            $selected = ' selected="selected" ';
                                        } else {
                                            $selected = NULL;
                                        }
                                        echo "<option value=\"" . $petugas_data->id . "\"" . $selected . ">" .
                                             $petugas_data->n_pegawai . " | " .
											 $petugas_data->n_jabatan . " | " .
                                             $petugas_data->nip . " | " .
                                             $petugas_data->pangkat_gol . "</option>\n" ;
                                    }
                                    ?>
                                </select>
                                <span id="erorPetugas" style=" clear: both; visibility: hidden;"></span>
                            </td>
                        </tr>
                        <br style="clear: both;" />

						<tr>
                            <td><label class="label-wrc">Penandatangan Surat Penolakan</label></td>
                            <td>
                                <select name="ttd_tlk" id="ttd_tlk" class="input-wrc required">
                                    <?php
                                    $selected = NULL;
                                    foreach ($petugas as $petugas_data) {
                                        if ($petugas_data->id == $tgs_id_tlk) {
                                            $selected = ' selected="selected" ';
                                        } else {
                                            $selected = NULL;
                                        }
                                        echo "<option value=\"" . $petugas_data->id . "\"" . $selected . ">" .
                                             $petugas_data->n_pegawai . " | " .
											 $petugas_data->n_jabatan . " | " .
                                             $petugas_data->nip . " | " .
                                             $petugas_data->pangkat_gol . "</option>\n" ;
                                    }
                                    ?>
                                </select>
                                <span id="erorPetugas" style=" clear: both; visibility: hidden;"></span>
                            </td>
                        </tr>
                        <br style="clear: both;" />

						<tr>
                            <td><label class="label-wrc">Penandatangan Nota Pengantar</label></td>
                            <td>
                                <select name="ttd_nta" id="ttd_nta" class="input-wrc required">
                                    <?php
                                    $selected = NULL;
                                    
                                    foreach ($petugas as $petugas_data) {
                                        if ($petugas_data->id == $tgs_id_nta) {
                                            $selected = ' selected="selected" ';
                                        } else {
                                            $selected = NULL;
                                        }
                                        echo "<option value=\"" . $petugas_data->id . "\"" . $selected . ">" .
                                             $petugas_data->n_pegawai . " | " .
											 $petugas_data->n_jabatan . " | " .
                                             $petugas_data->nip . " | " .
                                             $petugas_data->pangkat_gol . "</option>\n" ;
                                    }
                                    ?>
                                </select>
                                <span id="erorPetugas" style=" clear: both; visibility: hidden;"></span>
                            </td>
                        </tr>
                        <br style="clear: both;" />

						<div class="contentForm" style="padding-left: 145px">
                                       
                        </div>
                    </div>
                    <div id="contentright">
              
                    </div>
                    <br style="clear: both;" />
                </div>
            </div>
            <br>
            <?php
            $add_daftar = array(
                'name' => 'submit',
                'class' => 'submit-wrc',
                'content' => 'Simpan',
                'type' => 'submit',
                'value' => 'Simpan'
            );
            echo form_submit($add_daftar);
            echo "<span></span>";
            $cancel_daftar = array(
                'name' => 'button',
                'class' => 'button-wrc',
                'content' => 'Batal',
                'onclick' => 'parent.location=\''. site_url('settings/bidang') . '\''
            );
            echo form_button($cancel_daftar);
            echo form_close();
            ?>
        </div>
        <div class="entry" style="text-align: center;">
           
        </div>
    </div>
    <br style="clear: both;" />
</div>
