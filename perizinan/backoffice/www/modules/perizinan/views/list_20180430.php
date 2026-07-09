<div id="content">
    <div class="post">
        <div class="title">
            <h2><?php echo $page_name; ?></h2>
        </div>
        <div class="entry">
              <center><?php echo $this->session->flashdata('pesan'); ?></center>
            <?php
                $add_syaratijin = array(
                    'name' => 'button',
                    'class' => 'button-wrc',
                    'content' => 'Tambah Jenis Perizinan',
                    'onclick' => 'parent.location=\''. site_url('perizinan/create') . '\''
                );
                echo form_button($add_syaratijin);
            ?>
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="perizinan">
                <thead>
                    <tr>
                        <th width="2%">No</th>
						<th width="5%">ID<br>Klasifikasi<br>Kode Izin</th>
                        <th width="40%">Sektor Perizinan<br>Nama Izin</th>
						<th width="20%">Kelompok Perizinan<br>Masa Berlaku<br>Jenis Tandatangan</th>
                        <th width="22%">Durasi Adm || Teknis || Penerbitan (Hr)<br>Format Nomor Perizinan</th>
                        <th width="6%">Status Online<br>Status Izin<br>Permohonan</th>
						<th width="5%">Aksi</th>
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
                
                    $i = NULL;
                    foreach ($list as $data){
                        $i++;

                        $data->trkelompok_perizinan->get();
                        $data->trunitkerja->get();
		    			$data->trsektor->get();
                        $berlaku = $data->v_berlaku_tahun;

						$hit_izin = new trperizinan();
						$hit_izin = $hit_izin->where('n_perizinan', $data->n_perizinan)->count();
                        if($hit_izin == 1){  // cek Duplikasi Izin
                            $b = ''; $be = '';
						}else{
                            $b = '<span style="color: Red">'; $be = '</span>';
						}

						if($berlaku <> '1000') {
							if($berlaku >= 12) {
							    $berlaku = number_format($data->v_berlaku_tahun/12, 1, ',', '.') . ' Thn';
							}else{
                                $berlaku = $data->v_berlaku_tahun . ' Bln';
							}
						}else{
							$berlaku = 'Tidak Terbatas';
						}
						$ttd_elektonik = $data->e_ttd;
		                switch($ttd_elektonik){
			                case 0 : $metode = ' Tandatangan Manual'; break;
                            case 1 : $metode = ' Tandatangan Elektronik'; break;
                            case 2 : $metode = ' Upload Dokumen'; break;
                        }
                    ?>
                        <tr>
                            <td width="2%"  valign='top'><?php echo $i; ?></td>
							<td width="5%"  valign='top'>
							    <?php
						            if($data->kd_indeks == '') $kd_indekx = '...'; else $kd_indekx = $data->kd_indeks;
						            echo $b. $data->id.'<br>'.$kd_indekx.'<br>'.
						                 substr($data->kd_izin,0,2).'.'.substr($data->kd_izin,2,1).'.'.substr($data->kd_izin,3,2).'.'.substr($data->kd_izin,5) .$be;
					            ?>
							</td>
                            <td width="40%" valign='top'><?php echo $b. 'SEKTOR '.$data->trsektor->n_sektor.'<br>'.$data->n_perizinan .$be; ?></td>
		    				<td width="20%" valign='top'><?php echo $b. $data->trkelompok_perizinan->n_kelompok.'<br>'.$berlaku.'<br>'.$metode .$be; ?></td>
                            <td width="22%"  valign="top" align="center">
							    <?php
						            if($data->no_sk_awal == '') $no_sk_awal = '- '; else $no_sk_awal = $data->no_sk_awal;
					                if($data->no_sk_akhir == '') $no_sk_akhir = ' -'; else $no_sk_akhir = $data->no_sk_akhir;
						            echo $b. '0'.'  ||  '.'0'.'  ||  '.$data->v_hari .'<br>'. $no_sk_awal.
						                 '<span style="color: Red">'.$data->no_sk_tengah.'</span>'.$no_sk_akhir.'<span style="color: Red">Tahun</span>' .$be;
					            ?>
							</td>
<!--                            <td width="7%"  valign="top" align="center"><?php echo $berlaku; ?></td>-->
<!--                          <td>
                                <?php
                                    if($data->is_open === '0') {
                                        echo "Izin Tertutup";
                                    } else {
                                        echo "Izin Terbuka";
                                    }
                                ?>
                            </td>-->
                            <!--<td width="5%" valign="top" align="center"><?php if($data->c_keputusan == 1) echo "Izin"; else echo "Non Izin"; ?></td>-->
                            <td width="6%" valign="top" align="center">
                                <center>
                                    <?php
                                    if($data->c_online == 0) echo 'OnLine '; else echo 'Manual ';
							        if($data->c_aktif == 0) echo '<br>'.'Aktif '; else echo '<br>'.'Tidak Aktif ';
                                    if (in_array($data->id, $ok)){
										$stat_ok = TRUE;
                                        echo $b. '<br>'.'Isi ' .$be;
                                    } else {
										$stat_ok = FALSE;
										echo $b. '<br>'.'Kosong ' .$be;
                                    ?>
                                        <?php
                                    }
                                        ?>
                                </center>
                            </td>
							<td width="5%" valign="top" align="center">
                                <center>
                                    <?php
                                    $img_edit = array(
                                        'src' => 'assets/images/icon/property.png',
                                        'alt' => 'Edit',
                                        'title' => 'Edit',
                                        'border' => '0',
                                    );
                                    $confirm_text = 'Apakah Anda yakin akan menghapusnya?';
                                    $img_delete = array(
                                        'src' => 'assets/images/icon/cross.png',
                                        'alt' => 'Delete',
                                        'title' => 'Delete',
                                        'border' => '0',
                                        'onClick' => 'return confirm_link(\''.$confirm_text.'\')',
                                    );
                                    ?>
                                    <a class="page-help" href="<?php echo site_url('perizinan/edit'."/".$data->id) ?>"><?php echo img($img_edit); ?></a>
                                    <?php if(!$stat_ok){?>
    									<a class="page-help" href="<?php echo site_url('perizinan/delete'."/".$data->id) ?>"><?php echo img($img_delete); ?></a>
									<?php } ?>
                                </center>
                            </td>
                        </tr>
                <?php
                    }
                ?>
                </tbody>
            </table>
        </div>
    </div>
    <br style="clear: both;" />
</div>