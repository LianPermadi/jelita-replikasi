<div id="content">
    <div class="post">
        <div class="title">
            <h2><?php echo $page_name; ?></h2>
        </div>
        <div class="entry">
            <?php echo form_open('permohonan/penetapan/edit_alasan'); ?>
            <?php echo form_hidden('id_bap', $id_bap); ?>
            <?php echo form_hidden('id', $id); ?>
            <?php echo form_hidden('jenislayanan', $jenislayanan);
            echo form_hidden('waktu_awal', $waktu_awal);?>

            <fieldset>
                <legend>Daftar Berita acara</legend>
                <div id="statusMain">
                    <div id="leftMain" class="bg-grid">
                        <?php
                        echo form_label('No pendaftaran', 'nama_izin');
                        ?>
                    </div>
                    <div id="rightMain" class="bg-grid">

                        <?php echo $nopendaftaran; ?>
                        <?php echo form_hidden('nopendaftaran', $nopendaftaran); ?>
                    </div>
                </div>
                <div id="statusMain">
                    <div id="leftMain">
                        <?php
                        echo form_label('Jenis layanan', 'kelompok_izin');
                        ?>
                    </div>
                    <div id="rightMain">
                        <?php
                        echo $jenislayanan;
                        ?>
                    </div>
                </div>
                <div id="statusMain">
                    <div id="leftMain" class="bg-grid">
                        <?php
                        echo form_label('Nama Pemohon', 'keterangan');
                        ?>
                    </div>
                    <div id="rightMain" class="bg-grid">
                        <?php
                        echo $namapemohon;
                        ?>
                    </div>
                </div>
                <div id="statusMain">
                    <div id="leftMain">
                        <?php
                        echo form_label('Alamat Pemohon', 'jenis_permohonan');
                        ?>
                    </div>
                    <div id="rightMain">
                        <?php
                        echo $alamatpemohon;
                        ?>
                    </div>
                </div>

                <div id="statusMain">
                    <div id="leftMain" class="bg-grid">
                        <?php
                        echo form_label('Nama Perusahaan', 'jenis_permohonan');
                        ?>
                    </div>
                    <div id="rightMain" class="bg-grid">
                        <?php echo $namaperusahaan; ?>
                    </div>
                </div>
                <div id="statusMain">
                    <div id="leftMain">
                        <?php
                        echo form_label('Tanggal Peninjauan', 'jenis_permohonan');
                        ?>
                    </div>
                    <div id="rightMain">

                        <?php echo $this->lib_date->mysql_to_human($tglperiksa); ?>
                    </div>
                </div>
                <div id="statusMain">
                    <div id="leftMain" class="bg-grid">
                        <?php
                        echo form_label('No BAP', 'jenis_permohonan');
                        ?>
                    </div>
                    <div id="rightMain" class="bg-grid">
                        <?php echo $nosk; ?>
                        <?php echo form_hidden('nobap', $nosk); ?>
                    </div>
                </div>

                <div id="statusMain">
                    <div id="leftMain">
                        <?php
                        echo form_label('Catatan');
                        ?><br><br>
                    </div>
                    <div id="rightMain">
                        <?php echo $pesan; ?>
                        <?php echo form_hidden('pesankomentar', $pesan); ?>
                        <br><br>
                    </div>
                </div>

                <div id="statusMain">
                    <br>
                        <table border="1" width="900" cellpadding="2px" cellspacing="0" align="center">
					    <?php $jml_property = $this->lib_date->data_property($id_izin,'1'); ?>
                        <tr>
						<td colspan="6" align="center" bgcolor="#CED9FE" height="33px"><b>PROPERTY</b></td>
                        <tr>
                        <tr>
                        <?php if($jml_property == '0'){ ?>
						    <td colspan="3" align="center" height="25"><b>Data Property Belum Diseting</b></td>
                        <?php } else { ?>
							<td colspan="3" align="center" height="25"><b>Data Berkas Permohonan</b></td>
                        <?php 
						}
            //            if($kelompok->id == "2" || $kelompok->id == "4"){
                        ?>
                            <td colspan="3" align="center" height="25"><b>Data Tinjauan</b></td>
                        <?php
			//	        }
						?>
                        <tr>
                        <?php
						if($jml_property == '0') {
                            $stat_property = FALSE;
		                }else {
                            $i = 1;
							$stat_property = TRUE;
	                        $text = $this->lib_date->data_property($id_izin,'2');
                            if($jml_property > '1') {
							    $text = $this->lib_date->sort_property($id_izin, $text);
							}
                            $list = explode (",",$text);
                            foreach ($list as $data) {
         						$nprop = $this->lib_date->array_property('1',$data);             // Nama Property
								$property_aktif = $this->lib_date->array_property('11',$data);   // Aktifasi Property
								$data_property = $this->lib_date->isi_property($id_daftar, $this->lib_date->array_property('0',$data), '1');
								$hitung = strlen($data_property);
                        		$cek_posisi = strpos($data_property,'^'); 
							    $hasil = substr($data_property,0,$cek_posisi);
							    $hasil2 = substr($data_property,$cek_posisi+1,$hitung);
                                if($property_aktif == 'Ya') {
								    if ($i % 2 == 0) {
                                        $color = "#FFFFFF";
                                    } else {
                                        $color = "#CED9FE";
                                    }

								    echo "<tr bgcolor='" . $color . "'>";
                        ?>
						            <td><?php echo $nprop; ?></td>  
                                    <td colspan="2"><?php echo $hasil; ?></td>
                                    <?php
                        //            if($kelompok->id == "2" || $kelompok->id == "4"){
                                    ?>
                                        <td><?php echo $nprop; ?></td>
                                        <?php
                        //            }
							    	    ?>
								    <td colspan="2"><?php echo $hasil2; ?></td>
                                    <?php
								    echo "</tr>";
						            $i++;
                                }
                            }
						}
                                    ?>
                    </table>
                    <br>
                </div>
				
                <div id="statusMain">
                    <div id="leftMain">
                        <?php
                        echo form_label('Nilai Retribusi', 'nama_izin');
                        ?>
                    </div>

                    <div id="rightMain">
                        <?php
                        if($m_hitung=="1") {
                            if (!empty($hitManualRet->v_tinjauan)) {
                                echo "Rp. ".$this->terbilang->nominal($hitManualRet->v_tinjauan, 2);
                                echo form_hidden('nilai_retribusi', $hitManualRet->v_tinjauan); 
                            } else {
                                echo "Rp. ".$this->terbilang->nominal('0', 2);
                                echo form_hidden('nilai_retribusi', '0'); 
                            }
                        } else {
                            if(empty($retribusi)) $retribusi = 0;
                            echo "Rp. ".$this->terbilang->nominal($retribusi, 2);
                        ////$z; ?>
                            <?php 
						    echo form_hidden('nilai_retribusi', $retribusi); 
                        }
                            ?>
                        <br>
                    </div>
                </div>


                <div id="statusMain">
                    <div id="leftMain">
                        <?php
                        echo form_label('Permohonan perizinan ', 'nama_izin');
                        ?>
                    </div>

                    <div id="rightMain">
                        <?php
                        if ($status == '1') {
                            $cek = TRUE;
                        } else {
                            $cek = FALSE;
                        }
                        $status1 = array(
                            'name' => "status",
                            'value' => "1",
                            'checked' => $cek
                        );
                        if ($status == '1') {
                            $checked = FALSE;
                        } else {
                            $checked = TRUE;
                        }
                        $status2 = array(
                            'name' => "status",
                            'value' => "2",
                            'checked' => $checked
                        );
                        if($ditetapkan === "1"){
                            echo "<b>";
                            if($status === "1") echo "Diizinkan"; else echo "Ditolak";
                            echo "</b>";
                        } else {
                            echo form_radio($status1) . " Diizinkan";
                            echo form_radio($status2) . " Ditolak";
                        }
                        ?>
                        <br>
                    </div>
                </div>
                <br>

				<div id="statusMain">
				    <div id="rightMain">
                        <h2>Alasan Penolakan</h2>
						<h4>Gunakan Tanda $1{ utk tab lv.1, $2{ utk tab lv.2, $3{ utk tab lv.3 </h4>
                    </div>
					<div id="rightMain">
						<div id="alasan">
                        <?php
						echo $alenia1;
				        $list = "SELECT * FROM alasan_penolakan WHERE id_permohonan = '$id_daftar'";
						$results = mysql_query($list);
						$no=0;
                        while ($rows = mysql_fetch_assoc(@$results)){
							$no++; 
                            echo "<p>";
                            echo "<textarea name='alasan[]' class='input-wrc required alasan' style='width:80%;height:60px;margin-top:10px'>".$rows['alasan']. "</textarea>
							<a href='#' id='remove'>Remove</a></p>";
                            echo "</p>";
						}
						if($no == 0){
                            echo "<tr>";
							echo "<td align='right'   valign='top' width='2%'>".'-'."</td>"."";
							echo "<td align='Justify' valign='top' width='50%'>".'Tidak diberi alasan yang jelas'."</td>"."";
							echo "<td align='Justify' valign='top' width='48%'>".''."</td>"."";
							echo "</tr>";
						}
					    ?>
						</div>
						<p><br><a class="submit-wrc" id="addAlasan" style="margin-left:20px;">Tambah Alasan</a></p>
					</div>
                </div>

				<?php
				$stat_adm = FALSE;
				$list_auths = $this->session_info['app_list_auth'];
				foreach ($list_auths as $list_auth) {
                    if($list_auth->id_role === '18') {      //jika administrator
                        //$stat_adm = TRUE;
						$stat_adm = FALSE;
                    }
                }
                if($stat_adm) {
                ?>
				    <!--<fieldset>
                        <legend>Edit Penetapan (Khusus ADMIN)</legend>
	    			    <div id="statusMain">
                            <div id="leftMain">
                                <?php
                                echo "<b>". form_label('Status Permohonan perizinan', 'permohonan_izin') . "</b>";
                                ?>
                            </div>
                            <div id="rightMain">
                                <?php
								//if($status === "1") {
									// "Diizinkan";
                                    $cek = TRUE;
                                    $checked = FALSE;
                                //} else {
									// "Ditolak";
                                //    $cek = FALSE;
                                //    $checked = TRUE;
                                //}
                                $stat_back1 = array(
                                    'name' => "stat_back",
                                    'value' => "1",
                                    'id'=>'stat_back',
                                    'checked' => $cek
                                );
                                $stat_back2 = array(
                                    'name' => "stat_back",
                                    'value' => "2",
                                    'id'=>'stat_back',
                                    'checked' => $checked
                                );
                                echo form_radio($stat_back1) . " Tetap";
                                echo form_radio($stat_back2) . " Dikembalikan ke status belum ditetapkan";
                                ?>
                                <br>
                            </div>
                        </div>
                    </fieldset> -->
                    <?php
				}
                    ?>
                <br>

				<div class="entry" style="text-align: center;">
                    <?php
                    $save = array(
                        'name' => 'submit',
                        'class' => 'submit-wrc',
                        'content' => 'Simpan',
                        'type' => 'submit',
                        'value' => 'Simpan'
                    );
                    //if($ditetapkan !== "1") {
					    echo form_submit($save);
					//} else {
					//	if($stat_adm) {
					//        echo form_submit($save);
					//	}
					//}
                    echo "<span></span>";
                    $cancel_daftar = array(
                        'name' => 'button',
                        'class' => 'button-wrc',
                        'content' => 'Batal',
                        'onclick' => 'parent.location=\''. site_url('permohonan/penetapan/index') . '\''     // OLD index_next
                    );
                    echo form_button($cancel_daftar);
					echo form_close();
                    ?>
                </div>

            </fieldset>
        </div>
        <br style="clear: both;" />
    </div>
</div>

<script>
	function gantiStatus(val){
        if(val=="1"){
            $('#diizinkan').show();
            $('#ditolak').hide();
            $(".alasan").attr('disabled', 'true');
        }else{
            $('#diizinkan').hide();
            $('#ditolak').show();
            $(".alasan").removeAttr('disabled');
        }
    }
    
	$(function() {
        var target = $('#alasan');
        var i = $('#alasan p').size() + 1;
        
        $('#addAlasan').live('click', function() {
//                $('<p><a class="text">' + i + '. </a><input type="text" name="alasan[]" class="input-wrc required alasan" style="width:80%;height:20px;margin-top:10px" required> <a href="#" id="remove">Remove</a></p>').appendTo(target);
				$('<p><textarea name="alasan[]" class="input-wrc required alasan" style="width:80%;height:60px;margin-top:10px" required></textarea> <a href="#" id="remove">Remove</a></p>').appendTo(target);
                i++;
                return false;
        });
        
        $('#remove').live('click', function() { 
                if( i > 2 ) {
                        $(this).parents('p').remove();
                        i--;
                }
                return false;
        });
});

	
</script>