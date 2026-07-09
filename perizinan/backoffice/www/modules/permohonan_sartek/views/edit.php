<div id="content">
    <div class="post">
        <div class="title">
            <h2><?php echo $page_name; ?></h2>
        </div>
        <div class="entry">
            <div id="tabs">
                <ul>
                    <!--<li><a href="#tabs-1">Pilih Ketetapan dari Database</a></li>-->
                    <li><a href="#tabs-2"><?php echo $tab_name; ?></a></li>
                </ul>
                <!--<div id="tabs-1">
                    <?php
                    $attr = array('id' => 'form');
                        echo form_open('ketetapan/savelist',$attr);
                        echo form_hidden('id_izin', $id_izin);
                        
                        foreach ($list_izin as $listizin) {
                            $listizin->trketetapan->get();
                            foreach ($list as $list_ketetapan) {
                                $showed = TRUE;
                                if ($list_ketetapan->id === $listizin->trketetapan->id) {
                                    $showed = FALSE;
                                    break;
                                }

                                if ($showed) {
                                    $set = array(
                                        'name' => 'dasarhukum[]',
                                        'value' => $list_ketetapan->id
                                    );
                                    echo form_checkbox($set);
                                    echo word_wrap($list_ketetapan->n_ketetapan);
                                    echo "<br />";
                                }
                            }
                        }
                        $add_dasar_hukum = array(
                            'name' => 'submit',
                            'class' => 'submit-wrc',
                            'content' => 'Simpan',
                            'type' => 'submit',
                            'value' => 'Simpan'
                        );
                        echo form_submit($add_dasar_hukum);
                        echo "<span></span>";
                        $cancel_list = array(
                            'name' => 'button',
                            'class' => 'button-wrc',
                            'content' => 'Batal',
                            'onclick' => 'parent.location=\''. site_url('ketetapan/detail') . "/" . $id_izin . '\''
                        );
                        echo form_button($cancel_list);
                        echo form_close();
                    ?>
                </div>-->

                <div id="tabs-2">
                    <?php
                    $attr = array('id' => 'form');
                    echo form_open('permohonan_sartek/' . $save_method,$attr);
                    echo form_hidden('id_izin', $id_izin);
					echo form_hidden('id_ket', $id_ket);
                    ?>

					<label class="label-wrc">Kop Surat</label>
					<?php echo 'Area Kop Surat'; ?>
                    <br style="clear: both" />

					<label class="label-wrc">Kepala Surat</label>
					<?php echo ''; ?>
                    <br style="clear: both" />

					<label class="label-wrc">Perihal</label>
					<?php
                    $in_perihal = array(
                        'name' => 'perihal',
                        'value' => $perihal,
                        'class' => 'input-wrc',
                        'style' => 'min-width:600pt'
                    );
                    echo form_input($in_perihal);
                    ?>
                    <br style="clear: both" />

					<label class="label-wrc">Kepala Isi</label>
					<?php echo ''; ?>
                    <br style="clear: both" />

					<label class="label-wrc">Alenia 1</label>
					<?php
                    if($id_ket == 1){
						$deskripsi_1 = array(
                            'name' => 'alenia_1',
                            'value' => $alenia_1,
                            'class' => 'input-area-wrc',
                            'style' => 'min-width:600pt'
                        );
						echo form_textarea($deskripsi_1); 
					}else{
                        $cmvariable = '';
                        $tempat_daftar = array();
                        $user = mysql_query("SELECT * FROM tmpermohonan");
                        $tempat_daftar = array();
                        for($i = 0; $i < mysql_num_fields($user); $i++){
                            $col = mysql_field_name($user, $i);
                        	$tempArray = array( $col => $col);
                            $tempat_daftar = array_merge ($tempat_daftar, $tempArray);
                        }
						//$tempat_daftar = array('BPMPT Prov. tasikmalaya' => 'BPMPT Prov. tasikmalaya';
                        $kalimat = $alenia_1;
		                $loop = 100;
                  		for ($a = 1; $a <= $loop; $a++) {
                            $br6 = strpos($kalimat,"#$");
                            $br6_akhir = strpos($kalimat,"$#");
                	    	if($br6){ // jika ada
		                        $kata_kunci = substr($kalimat,$br6,$br6_akhir - $br6 + 2);
//              			    isi_property($uid, $var = NULL, 5) // untuk ambil isi variabel properti
//                              field_property($v_id, $var, $pil) { // mengambil data properti per field {v_id=no_id_izin, var=nomor filed, pil = pilihan output}
		                        $br6 = str_replace($kata_kunci, form_dropdown('cmvariable'.$a,$tempat_daftar,$cmvariable,'class = "input-select-wrc" id="cmvariable"'), $kalimat); 
								echo form_hidden('kata_kunci'.$a, $kata_kunci);
								// ubah kata
    		                }else{
	    		                $br6 = $kalimat;
                                $a = $loop;
    		                }
                            $kalimat = $br6;
		                }

						echo '<br><br>'; echo $br6; echo '<br>';
					}
                    ?>
                    <br style="clear: both" />

					<label class="label-wrc">Alenia 2</label>
					<?php
                    $deskripsi_2 = array(
                        'name' => 'alenia_2',
                        'value' => $alenia_2,
                        'class' => 'input-area-wrc',
                        'style' => 'min-width:600pt'
                    );
                    echo form_textarea($deskripsi_2);
                    ?>
                    <br style="clear: both" />

					<label class="label-wrc">Tabel Identitas Pemohon</label>
					<?php echo 'Area Tabel Data Pemohon'; ?>
                    <br style="clear: both" />

					<label class="label-wrc">Alenia 3</label>
					<?php
                    $deskripsi_3 = array(
                        'name' => 'alenia_3',
                        'value' => $alenia_3,
                        'class' => 'input-area-wrc',
                        'style' => 'min-width:600pt'
                    );
                    echo form_textarea($deskripsi_3);
                    ?>
                    <br style="clear: both" />

					<label class="label-wrc">Alenia 4</label>
					<?php
                    $deskripsi_4 = array(
                        'name' => 'alenia_4',
                        'value' => $alenia_4,
                        'class' => 'input-area-wrc',
                        'style' => 'min-width:600pt'
                    );
                    echo form_textarea($deskripsi_4);
                    ?>
                    <br style="clear: both" />
                    
					<label class="label-wrc">Ttd Surat</label>
					<?php echo 'Area Penandatanganan Surat'; ?>
                    <br style="clear: both" />

					<?php
                    $add = array(
                        'name' => 'submit',
                        'class' => 'submit-wrc',
                        'content' => 'Simpan',
                        'type' => 'submit',
                        'value' => 'Simpan'
                    );
                    echo form_submit($add);
                    echo "<span></span>";
                    
                    $cancel_role = array(
                        'name' => 'button',
                        'class' => 'button-wrc',
                        'content' => 'Batal',
                        'onclick' => 'parent.location=\''. site_url('permohonan_sartek') . '\''
                    );
                    echo form_button($cancel_role);
                    echo form_close();
                    echo form_close();
                    ?>
                </div>
            </div>
        </div>
    </div>
    <br style="clear: both;" />
</div>