<div id="content">
    <div class="post">
        <div class="title">
            <?php echo $this->lib_date->view_title($page_name); ?>
        </div>
        <div class="entry">
            <?php
            echo form_open(site_url('pelayanan/pendaftaran/create'));
            ?>
            <fieldset id="half">
                <legend>Data Permohonan</legend>
                <div class="contentForm bg-grid">
                    <?php
                        $opsi_paralel = array(
                            'no'  => 'Tidak',
//                            'yes' => 'Ya',
                        );

                        echo form_label('Paralel','name_paralel');
                        echo form_dropdown('jenis_paralel', $opsi_paralel, '', 'class = "input-select-wrc" id="paralel_id"');
                    ?>
                </div>
                <div class="contentForm" id="show_jenis_izin">
                    <?php
                        if($list_izin->id){
                            foreach ($list_izin as $row){
								if($row->c_aktif == 0)
                                    $opsi_izin[$row->id] = $row->n_perizinan;
                            }
                        }else{
                            $opsi_izin[0] = "";
                        }

                        echo form_hidden('paralel', 'no');
                        echo form_hidden('jenis_permohonan', $jenis_id);
                        echo form_label('Jenis Izin','name_jenis_izin');
					    echo form_dropdown('jenis_izin', $opsi_izin, '','class = "input-select-wrc" id="jenis_izin" multiple="multiple"');
                    ?>
                </div>
                <div id="statusRail">
                    <div id="leftRail"></div>
                    <div id="rightRail" style="text-align: right">
                        <input type="image" src="<?php echo base_url().'assets/images/icon/plus.png'; ?>" value="Submit" alt="Submit">
                    </div>
                </div>
                <?php
                echo form_close();
                ?>
            </fieldset>
        </div>
        <?php
        if($ket_syarat){
            echo "<div class='entry' align=center><b style='color: #FF0000;'>Persyaratan tidak lengkap !!</b></div>";
        }
        ?>
        <div class="entry">
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="pendaftaran">
                <thead>
                    <tr>
                        <th width="2%">No</th>
                        <th width="9%">Nomor Pendaftaran<br>Tanggal Daftar</th>
                        <th width="9%">Id Pemohon<br>Asal Permohonan</th>
                        <th width="20%">Nama Pemohon<br>Nama Perusahaan</th>
                        <th width="23%">Jenis Izin</th>
						<th width="24%">Objek Izin</th>
                        <!--<th width="8%">Asal Permohonan</th>-->
                        <th width="5%">Status</th>
                        <th width="8%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    $results = mysql_query($list);
                    while ($rows = mysql_fetch_assoc(@$results)){
                        $i++;
						$permohonan_perusahaan = new tmpermohonan_tmperusahaan();
                        $permohonan_perusahaan->where('tmpermohonan_id', $rows['id'])->get();
					    $perusahaan_id = $permohonan_perusahaan->tmperusahaan_id;
						$perusahaan = new tmperusahaan();
						$perusahaan->where('id', $perusahaan_id)->get();
     					$n_perusahaan = $perusahaan->n_perusahaan;

						/*cek persyaratan tiap permohonan*/
						$permohonan = new tmpermohonan();
						$syarat_perizinan = new trsyarat_perizinan();
						$perizinan = new trperizinan();
                        $list_daftar = $permohonan->get_by_id($rows['id']);
						$syarat_izin = $syarat_perizinan->where_related("trperizinan", 'id =',$rows['idizin'])->get();

						$hit_wajib = 0;
						$hit_tidak = 0;
						$hitdata = 0;
						$hit_isi = 0;
						$hit_tdk = 0;
                        foreach ($syarat_izin as $data) {
                            $show_syarat = new trperizinan_syarat();
                            $show_syarat->where('trsyarat_perizinan_id', $data->id)
                                        ->where('trperizinan_id', $rows['idizin'])->get();
							$var = $show_syarat->c_show_type;
                            $stat_wajib = $show_syarat->status;
                               
                            $rule = strval(decbin($var));
                            if (strlen($rule) < 4) {
                                $len = 4 - strlen($rule);
                                $rule = str_repeat("0", $len) . $rule;
                            }
                            $arr_rule = str_split($rule);

                            $c_daftar_ulang = $arr_rule[0];
                            $c_baru = $arr_rule[1];
                            $c_perpanjangan = $arr_rule[2];
                            $c_ubah = $arr_rule[3];

                            $syarat_status = $c_baru;
                            if ($syarat_status == '1') {
                                $hitdata++;  // jumlah syarat tampil
							    if ($stat_wajib == "1") {
									$hit_wajib++;    // jumlah syarat wajib
                                    $data_syarat = new tmpermohonan_trsyarat_perizinan();
								    $data_syarat->where('tmpermohonan_id', $rows['id'])
                                                ->where('trsyarat_perizinan_id', $data->id)->get();
									if ($data_syarat->trsyarat_perizinan_id) {
										$hit_isi++;
									} else {
										$hit_tdk++;
                                    }
                                } else {
								    $hit_tidak++;    // jumlah syarat tidak wajib
								}
                            }
						}
						if($hit_wajib == $hit_isi) {
							$cek_kirim = TRUE;
						    $b = '';
						    $be = '';
						} else {
							$cek_kirim = FALSE;
						    $b = '<span style="color: Red">';
						    $be = '</span>';
						}
						/*EOF()cek syarat*/

						$kd_sektor = " ";
						if($rows['trsektor_id'] == 0){
                            $kd_sektor = ".";
						}
                    ?>
                        <tr>
                            <td valign='top' width="2%"><?php echo $i; ?></td>
                            <td valign='top' width="9%">
							    <?php 
						        echo $b. $rows['pendaftaran_id'].'<br>' .$be;
					            if($rows['d_terima_berkas']){
                                    if($rows['d_terima_berkas'] != '0000-00-00')echo $b. $this->lib_date->mysql_to_human($rows['d_terima_berkas']) .$be;
                                }
					            ?>
							</td>
                            <td valign='top' width="9%">
							    <?php 
								echo $b. $rows['no_referensi'].'<br>' .$be;
								echo $b. $rows['kd_gerai'] .$be;
								?>
							</td>
                            <td valign='top' width="20%"><?php echo $b. $rows['n_pemohon'].'<br>'.$n_perusahaan.$be; ?></td>
                            <td valign='top' width="23%"><?php echo $b. $rows['n_perizinan'] .$be;?></td>
							<td valign='top' width="24%">
							    <?php 
						        if($rows['keterangan'] == '')
						            echo $b. $rows['a_izin'] .$be;
					            else
					                echo $b. $rows['a_izin'].'<br> [ Ket : '.$rows['keterangan'].' ]' .$be;
					            ?>
							</td>
                            <td valign='top' width="5%"><?php
                                    if($rows['c_paralel'] == 0) $status = "Satu Izin";
                                    else $status = "Izin Paralel";
                                    echo $b. $status .$be;
                                ?>
                            </td>
                            <td valign='top' width="8%"><?php
                                    $img_bukti = array(
                                        'src' => base_url().'assets/images/icon/print1.png', 
                                        'alt' => 'Cetak Bukti Pendaftaran',
                                        'title' => 'Cetak Bukti Pendaftaran',
                                        'border' => '0',
                                    );
                                    
									$img_recom = array(
                                        'src' => base_url().'assets/images/icon/clipboard-doc.png',
                                        'alt' => 'Buat Permohonan Rekomendasi',
                                        'title' => 'Buat Permohonan Rekomendasi',
                                        'border' => '0',
                                    );
                                    
									$img_edit = array(
                                        'src' => base_url().'assets/images/icon/property.png',
                                        'alt' => 'Edit',
                                        'title' => 'Edit',
                                        'border' => '0',
                                    );
                                    
									$confirm_text = 'Apakah Anda yakin permohonan izin telah selesai ?';
                                    $img_ok = array(
                                        'src' => base_url().'assets/images/icon/tick.png',
                                        'alt' => 'Daftar Selesai',
                                        'title' => 'Daftar Selesai',
                                        'border' => '0',
                                        'onClick' => 'return confirm_link(\''.$confirm_text.'\')',
                                    );
									$confirm_text = 'Tidak dapat melanjutkan ke Proses berikutnya, Yakin Untuk Edit Data ?';
									$img_no = array(
                                        'src' => base_url().'assets/images/icon/tick.png',
                                        'alt' => 'Persyaratan Kurang '.$hit_isi.'/'.$hit_wajib,
                                        'title' => 'Persyaratan Kurang '.$hit_isi.'/'.$hit_wajib,
                                        'border' => '0',
										'onClick' => 'return confirm_link(\''.$confirm_text.'\')',
                                    );

									$confirm_text = 'Apakah Anda yakin permohonan izin akan dikembalikan ?';
									$img_kembali = array(
                                        'src' => base_url().'assets/images/icon/navigation.png',
                                        'alt' => 'Pengembalian Permohonan',
                                        'title' => 'Pengembalian Permohonan',
                                        'border' => '0',
                                        //'onClick' => 'return confirm_link(\''.$confirm_text.'\')',
                                    );
                                    
									$confirm_text = 'Apakah Anda yakin akan menghapusnya ?';
                                    $img_delete = array(
                                        'src' => base_url().'assets/images/icon/cross.png',
                                        'alt' => 'Delete',
                                        'title' => 'Delete',
                                        'border' => '0',
                                        'onClick' => 'return confirm_link(\''.$confirm_text.'\')',
                                    );
                                    
									echo anchor(site_url('pelayanan/pendaftaran/edit') .'/'. $rows['id'], img($img_edit))."&nbsp;";
      					       	    
                                    if($group == "0" || $group == "1" || $group == "2"){ // utk User, Admin, supervisor
										echo anchor(site_url('pelayanan/pendaftaran/cetak_bukti') .'/'. $rows['id'], img($img_bukti))."&nbsp;";
										if($cek_kirim)
										    echo anchor(site_url('pelayanan/pendaftaran/selesai') .'/'. $rows['id'], img($img_ok))."&nbsp;";
										else
											echo anchor(site_url('pelayanan/pendaftaran/edit') .'/'. $rows['id'], img($img_no))."&nbsp;";
									}
                                    //if($group == "1" || $group == "2"){ // utk Admin, koordinator
										echo anchor(site_url('pelayanan/pendaftaran/edit_kembali') .'/'. $rows['id'], img($img_kembali));
									//}
                                    if($penghapusan == "25" || $group == "1"){ // utk Fasilitas Hapus Data atau Administrator
                                        echo anchor(site_url('pelayanan/pendaftaran/delete') .'/'. $rows['id'], img($img_delete));
                                    }
						        ?>
                            </td>
                        </tr>
		            <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
<!-- Create PBS -->
     <!-- sementara ditutup
        <div class="post">
		    <div class="title" style="width:100%;text-align:center;">
			<h3><a class="page-help" href="<?php echo site_url('monitoring/cetak_izin_baru/0/0/0') ?>"><?php echo 'CETAK DATA PERMOHONAN IZIN BARU'; ?></a></h3>
            </div>
        </div>
	-->
<!-- EOF PBS -->
    </div>
    <br style="clear: both;" />
</div>