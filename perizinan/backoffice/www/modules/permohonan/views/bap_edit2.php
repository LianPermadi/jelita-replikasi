<script>
function validasi() {
    var catatan = document.forms[0].pesankomentar.value;
    
    if (catatan.length=='0') {
        document.getElementById('erorCatatan').innerHTML = 'Field ini harus diisi';
        document.getElementById('erorCatatan').style.visibility = "visible"; 
        document.getElementById('erorCatatan').style.color = "#FF2F2F"; 
        return false;
    } 
}
</script>

<div id="content">
    <div class="post">
        <div class="title">
            <h2><?php echo $page_name; ?></h2>
        </div>
        <div class="entry">
            <?php 
            $attr = array('name' => 'form', 'id' => 'form','onsubmit' => 'return validasi()');
            echo form_open('permohonan/bap/save',$attr); 
            echo form_hidden('id_bap', $id_bap); 
            echo form_hidden('id', $id);
            echo form_hidden('waktu_awal', $waktu_awal);
            ?>

            <fieldset>
                <legend>Data Berita Acara Pemeriksaan</legend>
                <div id="statusMain">
                    <div id="leftMain">
                        <?php echo form_label('No pendaftaran'); ?>
                    </div>
                    <div id="rightMain">
                        <?php echo form_hidden('nopendaftaran', $nopendaftaran); ?>
                        <?php echo $nopendaftaran; ?>
                    </div>
                </div>
                <div id="statusMain">
                    <div id="leftMain" class="bg-grid">
                        <?php echo form_label('Jenis layanan'); ?>
                    </div>
                    <div id="rightMain" class="bg-grid">
                        <?php echo $jenislayanan; ?>
                    </div>
                </div>
                <div id="statusMain">
                    <div id="leftMain">
                        <?php echo form_label('Nama Pemohon'); ?>
                    </div>
                    <div id="rightMain">
                        <?php echo $namapemohon; ?>
                    </div>
                </div>
                <div id="statusMain">
                    <div id="leftMain" class="bg-grid">
                        <?php echo form_label('Alamat Pemohon'); ?>
                    </div>
                    <div id="rightMain" class="bg-grid">
                        <?php echo $alamatpemohon; ?>
                    </div>
                </div>
                <div id="statusMain">
                    <div id="leftMain" >
                        <?php echo form_label('Nama Perusahaan'); ?>
                    </div>
                    <div id="rightMain" >
                        <?php echo $namaperusahaan; ?>
                    </div>
                </div>
                <div id="statusMain">
                    <div id="leftMain" class="bg-grid">
                        <?php
                        echo form_label('Tanggal Peninjauan');
                        ?>
                    </div>
                    <div id="rightMain"class="bg-grid" >
                        <?php
                        $tanggalperiksa_input = array(
                            'name' => 'tglperiksa',
                            'value' => $tglperiksa,
                            'class' => 'input-wrc required',
                            'id' => 'bap'
                        );
                        echo form_input($tanggalperiksa_input);
                        ?>
                    </div>
                </div>
                <?php
                if ($id_bap) {
                ?>
                    <div id="statusMain">
                        <div id="leftMain" >
                            <?php
                            echo form_label('No BAP', 'jenis_permohonan');
                            ?><br><br>
                        </div>
                        <div id="rightMain" >
                            <?php echo $no_bap; ?>
                        </div>
                    </div>
                    <?php
                }
                    ?>
                <div id="statusMain">
                    <br><br>
                    <table border="1" width="auto" cellpadding="2px" cellspacing="0" align="center">
                        <?php $jml_property = $this->lib_date->data_property($id_izin,'1'); ?>
                        <tr>
						<td colspan="6" align="center" bgcolor="#CED9FE" height="33px"><b>PROPERTY</b></td>
                        <tr>
                        <tr>
                        <?php if($jml_property == '0'){ ?>
						    <td colspan="3" align="center" height="25"><b>Data Property Belum Diseting</b></td>
                        <?php } else { ?>
							<td colspan="3" align="center" height="25"><b>Data Berkas Permohonan</b></td>
							<td colspan="3" align="center" height="25"><b>Data Tinjauan</b></td>
                        <?php 
						}
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
                       //             if($kelompok->id == "2" || $kelompok->id == "4"){
                                    ?>
                                        <td><?php echo $nprop; ?></td>
                                        <?php
                       //             }
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
                    <div id="leftMain" class="bg-grid" style="font-size: 14px;">
                        <?php
                        echo form_label('Retribusi');
                        ?>
                    </div>
                    <div id="rightMain" class="bg-grid">
                        <?php
						if ($m_hitung=="0") { // Otomatis
                            $nilai_ret = $m_ret_auto + $m_denda;
		                }else{
                            switch ($idjenis) {
                                case '3': // Izin HO
                                    $v_lru = $this->lib_date->isi_property($id, 9, 5);
				                    $v_ig  = $this->lib_date->isi_property($id,18, 5);
                    				$v_ku  = $this->lib_date->isi_property($id,19, 5);
	    		                	$v_jk  = $this->lib_date->isi_property($id,20, 5);
                                    $v_il  = $this->lib_date->isi_property($id,21, 5);
                                    $v_td  = $this->lib_date->isi_property($id,22, 5);
                                    $v_jp  = $this->lib_date->isi_property($id,23, 5);
                                    $retribusi = ( $v_lru * $v_ig * $v_ku * $v_jk * $v_il * $v_td) * ($v_jp / 100);
                                   break;
                                default:
                                    $retribusi = 0;
                                    break;
                            }              
			                $nilai_ret = $retribusi + $m_denda;
		                }
                        echo form_label('Rp. '.$this->terbilang->nominal($nilai_ret).',-');
						echo form_hidden('nilai_ret', $nilai_ret);
                        ?>
                    </div>
					<br><br>
                </div>

                <div id="statusMain">
                    <div id="leftMain">
                        <?php
                        echo form_label('Catatan', 'nama_izin');
                        ?><br><br>
                    </div>
                    <div id="rightMain">
                        <?php
                        $pesan = array(
                            'name' => 'pesankomentar',
                            'value' => $pesan,
                            'class' => 'input-area-wrc',
                            'id'    => 'pesankomentar'
                        );
                        echo form_textarea($pesan);
                        ?>
                        <p id="erorCatatan" style="visibility: hidden;"></p>
                        <br><br>
                    </div>
                </div>
                        <div class="entry" style="text-align: center;">
                    <?php
                        $save = array(
                            'name' => 'submit',
                            'class' => 'submit-wrc',
                            'content' => 'Simpan',
                            'type' => 'submit',
                            'value' => 'Simpan'
                        );
                        echo form_submit($save);
                        echo form_close();
                        echo "<span></span>";
                        $cancel_daftar = array(
                            'name' => 'button',
                            'class' => 'button-wrc',
                            'content' => 'Batal',
                            'onclick' => 'parent.location=\'' . site_url('permohonan/bap') . '\''
                        );
                        echo form_button($cancel_daftar);
                    ?>
                </div>

            </fieldset>
        </div>

        <br style="clear: both;" />
    </div>
</div>