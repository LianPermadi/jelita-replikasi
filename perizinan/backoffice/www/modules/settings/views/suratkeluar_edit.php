<div id="content">
    <div class="post">
        <div class="title">
            <h2><?php echo $page_name; ?></h2>
        </div>

        <div class="entry">
            <div id="tabs">
                <ul>
                    <li><a href="#tabs-1">Data Peruntukan Nomor Surat</a></li>
                </ul>
                <div id="tabs-1">
                    <div id="contentleft">
                        <?php
                        $attr = array('id' => 'form','name'=>'form1');
                        echo form_open('settings/surat_keluar/' . $save_method, $attr);
                        echo form_hidden('pemohon_id', $pemohon_id);
						echo form_hidden('sk_id', $sk_id);
						echo form_hidden('id', $id);
                        ?>
                        
						<div class="contentForm">
                            <label class="label-wrc">Nomor Surat</label>
                            <?php
                            $no_surat_input = array(
                                'name' => 'no_surat',
                                'value' => $no_surat,
                                'class' => 'input-wrc digits'
                            );
							$no_pertek = $no_awal_pertek.$no_surat.$no_akhir_pertek;
                            echo $no_pertek;
                            ?>
                        </div>
                        <br>

						<div class="contentForm">
                            <label class="label-wrc">Tanggal Surat</label>
                            <?php
                            $tg_surat_input = array(
                                'name' => 'tg_surat',
                                'id' => 'tg_surat',
                                'value' => $tg_surat,
                                'readOnly'=>TRUE,
                                'class' => 'input-wrc required date'
                            );
							if($save_method == 'save'){
                                echo form_input($tg_surat_input);
							}else{
								echo $tg_surat;
							}
                        ?>
                        </div>
						<br>

                        <?php if($save_method == 'save'){ ?>
                        <div class="contentForm">
                            <label class="label-wrc">Sektor Izin</label>
                            <?php
                            if ($list_data) {
                                foreach ($list_data as $row) {
                                    $opsi_sektor['0'] = "------Pilih salah satu------";
                                    $opsi_sektor[$row->id] = $row->n_sektor;
                                }
                            } else {
                                $opsi_sektor[0] = "";
                            }
                            ?>
		                    <tr>
                                <td> <?php echo form_hidden('mark', 'tanda'); ?> </td>
                                <td> <?php
                                    if ($mark == "tanda") {
                                        echo form_dropdown('list_sektor', $opsi_sektor, $sektor, 'class = "input-select-wrc" id="selector"');
                                    } else {
                                        echo form_dropdown('list_sektor', $opsi_sektor, '0', 'class = "input-select-wrc" id="selector"');
                                    }
                                    ?>
                                </td>
                            </tr>
                        </div>
						<?php } ?>

						<div class="contentForm">
                            <label class="label-wrc">Perihal</label>
                            <?php
                            $hal_input = array(
                                'name' => 'perihal',
                                'value' => $perihal,
                                'class' => 'input-area-wrc required'
                            );
                            echo form_textarea($hal_input);
                        ?>
                        </div>

                        <div class="contentForm">
                            <label class="label-wrc">Kepada</label>
                            <?php
                            $kepada_input = array(
                                'name' => 'kepada',
                                'value' => $kepada,
                                'class' => 'input-area-wrc required'
                            );
                            echo form_textarea($kepada_input);
                            ?>
                        </div>

                        <!--<div class="contentForm">
                            <label class="label-wrc">Keterangan</label>
                            <?php
                            $ket_input = array(
                                'name' => 'keterangan',
                                'value' => $keterangan,
                                'class' => 'input-area-wrc'
                            );
                            echo form_textarea($ket_input);
                            ?>
                        </div>-->
                    </div>
                    
                    <br style="clear: both;" />
                </div>
            </div>
            <br>
            <?php
            $add_role = array(
                'name' => 'submit',
                'class' => 'submit-wrc',
                'content' => 'Simpan',
                'type' => 'submit',
                'value' => 'Simpan'
            );
            echo form_submit($add_role);
            echo "<span></span>";
            $cancel_role = array(
                'name' => 'button',
                'class' => 'button-wrc',
                'content' => 'Batal',
                'onclick' => 'parent.location=\''. site_url('settings/surat_keluar') . '\''
            );
            echo form_button($cancel_role);
            echo form_close();
            ?>
        </div>
    </div>
    <br style="clear: both;" />
</div>