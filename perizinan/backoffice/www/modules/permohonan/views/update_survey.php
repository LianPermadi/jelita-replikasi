<div id="content">
    <div class="post">
        <div class="title">
            <h2><?php echo $page_name; ?></h2>
        </div>
        <div class="entry">
            <fieldset id="half">
                <legend>Data Permohonan</legend>
                
				<div id="statusRail">
                    <div id="leftRail" class="bg-grid">
                        <?php
                        echo form_label('No Pendaftaran','no_daftar');
                        ?>
                    </div>
                    <div id="rightRail" class="bg-grid">
                        <?php
                        echo $no_daftar;
                        ?>
                    </div>
                </div>

                <div id="statusRail">
                    <div id="leftRail">
                        <?php
                        echo form_label('Tanggal Permohonan','tgl_prmohonan');
                        ?>
                    </div>
                    <div id="rightRail">
                        <?php
                        echo $this->lib_date->mysql_to_human($tgl_permohonan);
                        ?>
                    </div>
                </div>

                <div id="statusRail">
                    <div id="leftRail" class="bg-grid">
                        <?php
                        echo form_label('Nama Pemohon','nama_pemohon');
                        ?>
                    </div>
                    <div id="rightRail" class="bg-grid">
                        <?php
                        echo $nama_pemohon;
                        ?>
                    </div>
                </div>
                
				<div id="statusRail">
                    <div id="leftRail">
                        <?php
                        echo form_label('Alamat','alamat');
                        ?>
                    </div>
                    <div id="rightRail">
                        <?php
                        echo $alamat_pemohon;
                        ?>
                    </div>
                </div>
                
				<div id="statusRail">
                    <div id="leftRail" class="bg-grid">
                        <?php
                        echo form_label('Jenis Izin','jenis_izin');
                        ?>
                    </div>
                    <div id="rightRail" class="bg-grid">
                        <?php
                        echo $jenis_izin;
                        ?>
                    </div>
                </div>
                
				<div id="statusRail">
                    <div id="leftRail">
                        <?php
                        echo form_label('Lokasi Izin');
                        ?>
                    </div>
                    <div id="rightRail">
                        <?php
                        echo $permohonan->a_izin;
                        ?>
                    </div>
                </div>
            </fieldset>
        </div>
        <?php
        //echo $save_method;
        echo form_open('permohonan/' . $save_method);
        echo form_hidden('id_daftar', $id_daftar);
		echo form_hidden('id_izin', $id_izin);
        echo form_hidden('waktu_awal', $waktu_awal);
        if (isset($from)) {
            echo form_hidden('from', $from);
        }
        ?>
        <div class="entry">
            <div id="tabs">
                <ul>
                    <li><a href="#tabs-1">Data Entry</a></li>
                    <?php
                    $izin_kelompok = $permohonan->trperizinan->trkelompok_perizinan->get();
                    if($izin_kelompok->id == '1' || $izin_kelompok->id == '3'){
                        ?>
                        <li><a href="#tabs-2">Data Surat Rekomendasi</a></li>
                        <?php
                    }
                        ?>
					<li><a href="#tabs-3">Penangguhan Permohonan</a></li>
                     <!-- <li><a href="#tabs-4">Data Pertimbangan Teknis</a></li>  -->
                      <script type="text/javascript">
                        $(function(){
                            $("#tabs-4").hide();
                        })
                    </script> 
                </ul>
                <div id="tabs-1">
                    <table cellpadding="0" cellspacing="0" border="0" class="display">
                        <tr>
                            <td align="left" width="4%"></td>
                            <td align="left" width="20%"></td>
                            <td align="left" width="75%"></td>
                        </tr>
                        <?php
						$jml_property = $this->lib_date->data_property($id_izin,'1');
						if($jml_property == '0') {
							echo "Property Belum Diseting";
                            $stat_property = FALSE;
		                }else {
                            $i = 1;
							$stat_property = TRUE;
	                        $text = $this->lib_date->data_property($id_izin,'2');
							if($jml_property > '1') {
							    $text = $this->lib_date->sort_property($id_izin, $text);
							}
                            $list1 = explode (",",$text);
                            foreach ($list1 as $data) {
								$nm_var = 'vdt_teknis'.$this->lib_date->array_property('0',$data);
								$property_aktif = $this->lib_date->array_property('11',$data);   // Aktifasi Property
								$data_property = $this->lib_date->isi_property($id_daftar, $this->lib_date->array_property('0',$data), '1');
							    $hitung = strlen($data_property);
                                $cek_posisi = strpos($data_property,'^'); 
                                $cek_data = substr($data_property,$cek_posisi+1,$hitung);
								if($i%2 == 0) $bg = ""; else $bg = "class='bg-grid'";
								if($property_aktif == 'Ya') {
                                    echo "<tr>";
//                                    echo "<td width='20%'".$bg."><b>".$i.' . '. $this->lib_date->array_property('1',$data)."</b></td>"."";   // Nama Property
									echo "<td align='left' width='4%'".$bg."><b>".$i.' . '."</b></td>"."";   // Nomor Property
									echo "<td align='left' width='10%'".$bg."><b>".$this->lib_date->array_property('1',$data)."</b></td>"."";   // Nama Property

                                    if($cek_data == '-')
								        $data_property = substr($data_property,0,$cek_posisi);
								    else
								        $data_property = substr($data_property,$cek_posisi+1,$hitung);
								} else {
                                    $data_property = substr($data_property,$cek_posisi+1,$hitung);
							    }
                                                                         
						        $property_type = $this->lib_date->array_property('9',$data);     // Type Property
                                if($property_type == 'ComboBox'){
								    // Create PBS
                                    $val_combo = $this->lib_date->array_property('10',$data);    // Isi Pilihan ComboBox
                                    if($val_combo){
									    $hitung = strlen($val_combo);
                                        $cek_posisi = strpos($val_combo,';');
                                        $a = 1;
                                        while ($a < 50) {
                                            $item_combo = substr($val_combo,0,$cek_posisi);
                                            $val_combo = substr($val_combo,$cek_posisi+1,$hitung);
                                            $hitung = strlen($val_combo);
                                            $cek_posisi = strpos($val_combo,';');
                                            if($a == 1) {
											    $opsi_koefisien = array($item_combo => $item_combo);
                                            } else {
											    $tempArray = array( $item_combo => $item_combo);
                                                $opsi_koefisien = array_merge ($opsi_koefisien, $tempArray);
                                            }
                                            if($cek_posisi == "") {
                                                $a = $a + 1;
											    $tempArray = array( $val_combo => $val_combo);
                                                $opsi_koefisien = array_merge ($opsi_koefisien, $tempArray);
                                                $a = 51;
                                            }
                                            $a = $a + 1;
                                        }
                                    }
									if($property_aktif == 'Ya') {
                                        echo "<td width='20%'".$bg.">".form_dropdown($nm_var, $opsi_koefisien, $data_property, 'class =  "input-select-wrc"')."</td>";
									}
                                    $opsi_koefisien = '';
                                }

								if($property_type == 'Tanggal') {
								    $periode = array(
                                        'name' => $nm_var,
										'style'=>'width:10%',
                                        'value' => $data_property,
                                        'class' => 'monbulan',
										'readOnly'=>TRUE,
                                    );
									if($property_aktif == 'Ya') {
									    echo "<td ".$bg.">".form_input($periode)."</td>"; 
									}
								}

                                if($property_type == 'TextBox') {
								    $property_input = array(
                                        'name' => $nm_var,
									    'style'=>'width:100%',
                                        'value' => $data_property,
                                        'class' => 'input-wrc',
                                    );
									if($property_aktif == 'Ya') {
									    echo "<td ".$bg.">".form_input($property_input)."</td>";
									}
								}

								if($property_type == 'Integer') {
									$cek_data = (int) $data_property;
									$property_input = array(
                                        'name' => $nm_var,
									    'style'=>'width:10%',
                                        'value' => $data_property,
                                        'class' => 'input-wrc required digits',
                                    );
									if($property_aktif == 'Ya') {
                                        echo "<td ".$bg.">".form_input($property_input).' Hanya diisi oleh angka. ( koma dengan . )'."</td>";
									}
								}
                                
								if($property_aktif == 'Ya') {
								    echo "<td width='80%'".$bg."><b></b></td>";
                                    echo "</b></td>";
                                    echo "</tr>";
						            $i++;
								} else {
									echo form_hidden($nm_var, $data_property);
							    }
                            }
						    if($i == '1') {
							    $stat_property = FALSE;
							    echo "Property Belum diseting";
							}
						}
                        ?>
                    </table>
                </div>
            
                <?php
                if($izin_kelompok->id == '1' || $izin_kelompok->id == '3'){
                ?>
                    <div id="tabs-2">
                        <?php
                        echo form_label('No Surat');
                        $no_surat_input = array(
                            'name' => 'no_surat',
                            'value' => $no_surat,
                            'class' => 'input-wrc',
                            'id' => 'no_surat'
                        );
                        echo form_input($no_surat_input);
                        ?>
                    
				    	<br style="clear: both;" />
                        <?php
                        echo form_label('Tanggal Surat');
                        $tgl_surat_input = array(
                            'name' => 'tgl_surat',
                            'value' => $tgl_surat,
                            'class' => 'input-wrc',
                            'id' => 'tgl_surat'
                        );
                        echo form_input($tgl_surat_input);
                        ?>
                    
			    		<br style="clear: both;" />
                        <?php
                        echo form_label('Deskripsi');
                        $deskripsi_input = array(
                            'name' => 'deskripsi',
                            'value' => $deskripsi,
                            'class' => 'inputarea-wrc',
                            'id' => 'deskripsi'
                        );
                        echo form_textarea($deskripsi_input);
                        ?>
                        <br style="clear: both;" />
                    </div>
                <?php
                }
                ?>
                <div id="tabs-4">
                    <table cellpadding="0" cellspacing="0" border="0" class="display">
                        <tr>
                            <td align="left" width="4%"></td>
                            <td align="left" width="20%"></td>
                            <td align="left" width="75%"></td>
                        </tr>
                        <tr>
                            <td class="bg-grid">1.</td>
                            <td class="bg-grid">Nomor Pertimbangan</td>
                            <td class="bg-grid"><input name="nomor_pertimbangan" type="text" class="input-wrc" style="width:100%" value="<?php echo $permohonan->nomor_pertimbangan; ?>" ></td>
                        </tr>
                        <tr>
                            <td >2.</td>
                            <td >Tanggal Pertimbangan</td>
                            <td ><input type="text" name="tgl_pertimbangan" class="monbulan" style="width:10%" readOnly="True" value="<?php echo ($permohonan->tanggal_pertimbangan == null)?date('Y-m-d'):$permohonan->tanggal_pertimbangan ; ?>" required></td>
                        </tr>
                        <tr>
                            <td class="bg-grid">3.</td>
                            <td class="bg-grid">Perihal</td>
                            <td class="bg-grid"><input type="text" name="perihal_pertimbangan" class="input-wrc" style="width:100%" value="<?php echo $permohonan->perihal; ?>" ></td>
                        </tr>
                        <tr>
                            <td >4.</td>
                            <td >Bidang</td>
                            <td ><input type="text" class="input-wrc" name="bidang_pertimbangan" style="width:100%" value="<?php echo $bidang; ?>" readOnly="True" ></td>
                        </tr>
                         <tr>
                            <td >5.</td>
                            <td >Alasan</td>
                            <td ><textarea class="input-wrc" name="alasann" style="width:100%;background:white;border:1px solid blue;" ></textarea></td>
                        </tr>

                    </table>
                </div>
                <!-- PBS CREATE -->
		        <div id="tabs-3">
				    <?php echo 'Dari hasil tinjauan lapangan yang telah dilakukan, ditemukan adanya beberapa kekurangan untuk segera dilengkapi oleh pemohonan, diantaranya :';?> 
                    <fieldset id="half" style="width:500px"> 
		                <?php //echo form_open('survey/resultUpdate');?>
				        <div id="statusRail">
                            <div id="leftRail" style="width:200px">
                                <?php echo form_label('1.  ','kurang_1'); ?>
                            </div>
                            <div id="leftRail">
                               <input type="text" name="syarat1" <?=$syarat1?> class="input-wrc">
                            
                            </div>
                        </div>

                        <div id="statusRail">
                            <div id="leftRail" style="width:200px">
                                <?php echo form_label('2.  ','kurang_2'); ?>
                            </div>
                            <div id="leftRail">
                                 <input type="text" name="syarat2" <?=$syarat2?> class="input-wrc">
                            
                            </div>
                        </div>
				
                        <div id="statusRail">
                            <div id="leftRail" style="width:200px">
                                <?php echo form_label('3.  ','kurang_3'); ?>
                            </div>
                            <div id="leftRail">
                                <input type="text" name="syarat3" <?=$syarat3?> class="input-wrc">
                            </div>
                        </div>

                        <div id="statusRail">
                            <div id="leftRail" style="width:200px">
                                <?php echo form_label('4.  ','kurang_4'); ?>
                            </div>
                            <div id="leftRail">
                                 <input type="text" name="syarat4" <?=$syarat4?> class="input-wrc">
                            </div>
                        </div>
				
				        <div id="statusRail">
                            <div id="leftRail" style="width:200px">
                                <?php echo form_label('5.  ','kurang_5'); ?>
                            </div>
                            <div id="leftRail">
                                <input type="text" name="syarat5" <?=$syarat5?> class="input-wrc">
                            </div>
                        </div>
		         		<br/><br/>
				
				        <div id="statusRail">
                            <div id="leftRail">
                                <?php echo form_label('Tgl Melengkapi :','kurang_5'); ?>
                            </div>
                            <div id="rightRail">
                                <?php
                                $tgl_s = array('name'  => 'tglsyarat', 'value' => $tglsyarat, 'class' => 'input-wrc', 'id' => 'tgl_surat',);
                                echo form_input($tgl_s);
                                ?>
                            </div>
                        </div>
                    </fieldset>
                </div>
				     
                
                <!-- EOF PBS CREATE -->
            </div>

        </div>

        <div class="entry" style="text-align: center;">
            <?php
	        $add_daftar = array(
                'name' => 'submit',
                'class' => 'submit-wrc',
                'content' => 'Simpan',
                'type' => 'submit',
                'value' => 'Simpan'
            );
            if($stat_property) echo form_submit($add_daftar);
            echo "<span></span>";
            $cancel_daftar = array(
                'name' => 'button',
                'class' => 'button-wrc',
                'content' => 'Batal',
                'onclick' => 'parent.location=\''. site_url('permohonan/revisisk') . '\''
            );
            echo form_button($cancel_daftar);
            echo "<span></span>";
//                $cancel = array(
//                    'name' => 'button',
//                    'class' => 'button-wrc',
//                    'content' => 'Hapus Entry Data',
//                    'onclick' => 'parent.location=\''. site_url('survey/cancel') . "/" . $id_daftar . '\''
//                );
//                echo form_button($cancel);
            echo form_close();
            ?>
        </div>
    </div>
    <br style="clear: both;" />
</div>
