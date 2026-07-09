<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/addSMSGateway/jquery.ui.dialog.js"></script>
<form id="smsdialog" action="<?php echo base_url(); ?>pelayanan/ambilsk/sendSMSGateway" method="post" style="display:none">
Apa anda yakin akan mengirim SMS ke no ini ?<br />
    <b>No Telp :</b><span id="spanno"></span><input type="hidden" size="15" maxlength="15" id="txtno" name="txtno" value=""  />
    <input type="hidden" name="txtisi" id="txtisi" value=""  /><br />
    <input type="submit" value="Kirim" name="tblkirim" id="tblkirim"  />&nbsp;&nbsp;
	<input type="reset" value="Batal" name="tblreset" id="tblreset"  />
    <span id="warning"></span>
</form>
<div id="content">
    <div class="post">
        <div class="title">
            <h2><?php echo $page_name; ?></h2>
        </div>
        <div class="entry">
            <fieldset id="half">
                <legend>Filter Data</legend>
                <?php 
					$attr = array(
                        'class' => 'searchForm',
                        'id' => 'searchForm'
                    );
                    echo form_open("upload_arsip/report_arsip", $attr);
				?>
                
				<div id="statusRail">
                    <div id="leftRail">
                        <?php
                        echo form_label('Sektor Perizinan', 'label_permohonan');
                        echo form_hidden('mark', 'tanda');
                        ?>
                    </div>
                    <div id="rightRail">
                        <?php
                        if ($list_data) {
                            foreach ($list_data as $row) {
                                $opsi_sektor['0'] = "------ Semua Sektor ------";
                                $opsi_sektor[$row->id] = $row->n_sektor;
                            }
                        } else {
                            $opsi_sektor[0] = "";
                        }
						if ($mark == "tanda") {
                            echo form_dropdown('list_sektor', $opsi_sektor, $sektor, 'class = "input-select-wrc" id="selector"');
                        } else {
                            echo form_dropdown('list_sektor', $opsi_sektor, '0', 'class = "input-select-wrc" id="selector"');
                        }
                        ?>
                    </div>
                </div>

                <div id="statusRail">
                    <div id="leftRail">
                        <?php
                        echo form_label('Tgl Permohonan Awal','d_tahun');
                        ?>
                    </div>
                    <div id="rightRail">
                        <?php
                        $periodeawal_input = array(
                            'name'  => 'tgla',
                            'value' => $tgla,
                            'readOnly'=>TRUE,
                            'class' => 'input-wrc',
                            'class' => 'monbulan'
                        );
                        echo form_input($periodeawal_input);
                        ?>
                    </div>
                </div>
                
				<div id="statusRail">
                    <div id="leftRail">
                        <?php
                        echo form_label('Tgl Permohonan Akhir','d_tahun');
                        ?>
                    </div>
                    <div id="rightRail">
                        <?php
                        $periodeakhir_input = array(
                            'name'  => 'tglb',
                            'value' => $tglb,
                            'readOnly'=>TRUE,
                            'class' => 'input-wrc',
                            'class' => 'monbulan'
                        );
                        echo form_input($periodeakhir_input);
                        ?>
                    </div>
                </div>
                
				<div id="statusRail">
                    <div id="leftRail"></div>
                    <div id="rightRail">
                        <?php
                        $filter_data = array(
                            'name' => 'button',
                            'class' => 'button-wrc',
                            'content' => 'Filter',
                            'value' => 'Filter'
                        );
                        echo form_submit($filter_data);
						$ctk_arsip = array(
                            'name' => 'button',
                            'content' => 'Cetak Arsip',
                            'value' => 'Cetak Arsip',
                            'class' => 'button-wrc',
                            'onclick' => 'parent.location=\''. site_url('upload_arsip/upload_arsip/cetak_arsip') . '\''
                        );
						echo form_button($ctk_arsip);
                        ?>
                    </div>
                </div>

                <?php
                echo form_close();
                ?>
				
            </fieldset>
        </div>
		
        <div class="entry">
		    <div style="text-align:right">
                <?php
                    echo 'JUMLAH IZIN : '.number_format($jum_ijin).'; DIARSIPKAN : '.number_format($jum_arsip);
                ?>
            </div>
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="penyerahan">
                <thead>
                    <tr>
                        <th width="3%">No</th>
                        <th width="10%">Nomor Pendaftaran<br>Tanggal Daftar<br>Asal Permohonan</th>
                        <th width="20%">Nama Pemohon<br>Nama Perusahaan</th>
                        <th width="23%">Jenis Izin</th>
                        <th width="23%">Objek Izin</th>
                        <th width="18%">Nomor Surat Keputusan<br>Tanggal Surat Keputusan<br>Keterangan Arsip</th>
                        <!--<th width="%">Tanggal Surat</th>-->
						<!--<th width="0%">Status Permohonan</th>-->
                        <!--<th width="%">Asal Permohonan</th>-->
                        <th width="3%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $results = mysql_query($list);
                    while ($rows = mysql_fetch_assoc(@$results)){
                        $status_bap = $rows['status_bap'];
                        $no_surat = $rows['no_surat_edit'];
						$tgl_surat = $rows['tgl_surat_edit'];
						if($no_surat == '') {
                            $no_surat = $rows['no_surat'];
                            $tgl_surat = $rows['tgl_surat'];
						}
						
                        $c_cetak = $rows['c_cetak'];
                        $idkelompok = $rows['idkelompok'];
						$s_serah = $rows['siap_serah'];
                        $permohonan_perusahaan = new tmpermohonan_tmperusahaan();
                        $permohonan_perusahaan->where('tmpermohonan_id', $rows['id'])->get();
					    $perusahaan_id = $permohonan_perusahaan->tmperusahaan_id;
						$perusahaan = new tmperusahaan();
						$perusahaan->where('id', $perusahaan_id)->get();
     					$n_perusahaan = $perusahaan->n_perusahaan;
                        if($rows['desc_arsip'] == '') {
							$stat_edit = 'Mengarsipkan';
                            $cek_kirim = FALSE;
						    $b = '<span style="color: Red">';
						    $be = '</span>';
                        } else {
							$stat_edit = 'Edit Arsip';
   							$cek_kirim = TRUE;
                            if($rows['nama_file'] == '') {
								$stat_edit = 'Edit Arsip Naskah Izin';
                                $b = '<span style="color: Blue">';
    						    $be = '</span>';
							} else {
							    $b = '';
		    				    $be = '';
							}
						}
                    ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td>
							    <?php 
						            echo $b.$rows['pendaftaran_id'].'<br>'.$be;
					                if($rows['idjenis'] == '1') $tgl_permohonan = $rows['d_terima_berkas'];
                                    else if($rows['idjenis'] == '2') $tgl_permohonan = $rows['d_perubahan'];
                                    else if($rows['idjenis'] == '3') $tgl_permohonan = $rows['d_perpanjangan'];
                                    else if($rows['idjenis'] == '4') $tgl_permohonan = $rows['d_daftarulang'];
                                    if($tgl_permohonan){
                                        if($tgl_permohonan != '0000-00-00') echo $b.$this->lib_date->mysql_to_human($tgl_permohonan).'<br>'.$be;
									}
                                    echo $b.$rows['kd_gerai'].$be;
					            ?>
							</td>
                            <td><?php echo $b.$rows['n_pemohon'] .'<br>'.$n_perusahaan.$be;?></td>
                            <td><?php echo $b.$rows['n_perizinan'].$be;?></td>
                            <td>
								<?php 
						            if($rows['keterangan'] == '')
						                echo $b.$rows['a_izin'].$be;
					                else
					                    echo $b.$rows['a_izin'].'<br>[ Ket : '.$rows['keterangan'].' ]'.$be;
					            ?>
                            </td>
                            <td>
							    <?php
								    echo $b.$no_surat.'<br>'.$be;
							        if($tgl_surat){
                                        //if($tgl_surat != '0000-00-00') 
										echo $b.$this->lib_date->mysql_to_human($tgl_surat).'<br>'.$be;
                                    }
                                    if($cek_kirim){
                                        $ket_arsip = $rows['desc_arsip'];
									} else {
										$ket_arsip = '-_^-_^-_^-_^-_';
									}
                                    $arr_kalimat = explode("^",$ket_arsip);
                                    echo $b.'Arsip Sampul : '.str_replace('-','',$arr_kalimat[2]).'; Box : '.str_replace('-','',$arr_kalimat[3]).
										    '; Rak : '.str_replace('-','',$arr_kalimat[4]).$be;
							    ?>
							</td>
			                <!--<td><?php
                                if($tgl_surat){
                                    if($tgl_surat != '0000-00-00') echo $b.$this->lib_date->mysql_to_human($tgl_surat).$be;
                                }
                                ?>-->
                            <!--<td><?php echo $b.$rows['status_berkas'].$be; //echo $rows['n_sts_permohonan'];?></td>-->
							<!--<td><?php echo $b.$rows['kd_gerai'].$be;?></td>-->
							
                            <td nowrap="nowrap">
                                <?php
                                $img_edit = array(
                                    'src' => base_url().'assets/images/icon/property.png',
                                    'alt' => $stat_edit,
                                    'title' => $stat_edit,
                                    'border' => '0',
//                                    'onClick' => 'return confirm_link(\''.$confirm_text.'\')',
                                );
								$img_info = array(
                                    'src' => base_url().'assets/images/icon/information.png',
                                    'alt' => 'Info Tracking',
                                    'title' => 'Info Tracking',
                                    'border' => '0',
                                );
                               echo anchor(site_url('upload_arsip/report_timteknis') .'/E/'. $rows['id'].'/0/', img($img_info))."&nbsp;";
								//echo anchor(site_url('upload_arsip/report_timteknis') .'/'. $rows['id'].'/1', img($img_info));    // 1 = Asal Menu
                                ?>
                            </td>
                        </tr>
                        <?php
                        $i++;
                    }
                        ?>
                </tbody>
            </table>
        </div>
<!-- Create PBS -->
        <?php
        $username = new user();
        $username->where('username', $this->session->userdata('username'))->get();
        $lokasi_user = $this->session->userdata('lokasi');
        ?>
        <div class="post">
		    <div class="title" style="width:100%;text-align:center;">
			<h3><a class="page-help" href="<?php //echo site_url('monitoring/cetak_penyerahan_izin/1/'.$tgla.'/'.$tglb)?>">
			       <?php
				   if ($lokasi_user === 'Pusat') { // Untuk daerah lain
			       //if ($lokasi_user === 'DPMPTSP Prov. tasikmalaya' || $lokasi_user === 'BPMPT Prov. tasikmalaya' || $lokasi_user === 'BPPT Prov. tasikmalaya') {
				       //echo 'CETAK BERITA ACARA PENYERAHAN BERKAS PERMOHONAN ';
                   }
				   ?>
				</a>
			</h3>
            </div>
        </div>
<!-- EOF PBS -->
    </div>
    <br style="clear: both;" />
</div>
