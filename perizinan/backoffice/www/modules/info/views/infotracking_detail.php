<div id="content">
    <div class="post">
        <div class="title">
            <?php echo $this->lib_date->view_title($page_name); ?>
        </div>
        <div class="entry">
            <fieldset id="half">
                <legend>Data Permohonan</legend>
                
				<div id="statusRail">
                    <div id="leftRail" class="bg-grid">
                        <?php
                        echo form_label('No Pendaftaran');
                        ?>
                    </div>
                    <div id="rightRail" class="bg-grid">
                        <?php
                        echo $daftar->pendaftaran_id;
                        ?>
                    </div>
                </div>

                <div id="statusRail">
                    <div id="leftRail">
                        <?php
                        echo form_label('Pemohon');
                        ?>
                    </div>
                    <div id="rightRail">
                        <?php
                        $pemohon = $daftar->tmpemohon->get();
                        echo $pemohon->n_pemohon;
                        ?>
                    </div>
                </div>

                <div id="statusRail">
                    <div id="leftRail" class="bg-grid">
                        <?php
                        echo form_label('Jenis Izin');
                        ?>
                    </div>
                    <div id="rightRail" class="bg-grid">
                        <?php
                        $data_izin = $daftar->trperizinan->get();
                        echo $data_izin->n_perizinan;
                        ?>
                    </div>
                </div>

                <div id="statusRail">
                    <div id="leftRail" >
                        <?php
                        echo form_label('Jenis Permohonan');
                        ?>
                    </div>
                    <div id="rightRail" >
                        <?php
                        $jenis = $daftar->trjenis_permohonan->get();
                        echo form_label($jenis->n_permohonan);
                        ?>
                    </div>
                </div>

                <div id="statusRail">
                    <div id="leftRail"  class="bg-grid">
                        <?php echo form_label('Tanggal Pendaftaran', 'no_daftar'); ?>
                    </div>
                    <div id="rightRail" class="bg-grid">
                        <?php echo $this->lib_date->mysql_to_human($daftar->d_terima_berkas). ',  Pukul : ' .substr($daftar->d_entry, 10); ?>
                    </div>
                </div>

                <div id="statusRail">
                    <div id="leftRail">
                        <?php
                        echo form_label('Target Durasi');
                        ?>
                    </div>
                    <div id="rightRail">
                        <?php
                        echo $data_izin->v_hari.' Hari';
                        ?>
                    </div>
                </div>

                <div style="text-align:right">
                    <?php
                        $img_back = array(
                            'src' => 'assets/images/icon/back_alt.png',
                            'alt' => 'Back',
                            'title' => 'Back',
                            'border' => '0',
                        );
                        if($asal_menu == 0){
                            echo anchor(site_url('info/infotracking'), img($img_back))."&nbsp;";
						} else {
                            echo anchor(site_url('arsip/arsip/list_index'), img($img_back))."&nbsp;";
						}
                    ?>
                </div>
            </fieldset>
        </div>
        
		<div class="entry">
            <div style="text-align:right">
                <?php
				if($group == 1) {
					$user = new user();
                    $user->get_by_id(substr($daftar->pendaftaran_id,-3));
					$petugas = $user->oriname;
					if($petugas == '') $petugas = '-';
                    echo 'Petugas Front Office : '.$petugas . ' ';
				}
                ?>
            </div>
            <table cellpadding="0" cellspacing="0" border="0" align="center" class="display" id="trackingdetail">
                <thead>
                    <tr>
                        <th width="3%">No</th>
                        <th width="25%">Menu</th>
                        <th width="17%">Durasi Pengerjaan</th>
                        <th width="10%">Waktu Awal</th>
                        <th width="10%">Waktu Akhir</th>
						<th width="20%">User / Nama</th>
						<th width="5%">Status</th>
                        <th width="10%">Aktifitas</th>
                    </tr>
                </thead>
                <tbody>
                    <?php                    
                    $i = 0;
                    $total_awal = NULL;
                    $total_akhir = NULL;
                    $total_hari = NULL;
					$ttl_awal = NULL;
					$ttl_akhir = NULL;
                    foreach ($list as $data){
                        $showed = FALSE;
                        if($list_tracking){
                            foreach ($list_tracking as $data_track){
                                $status = '';
                                $waktu_awal = '';
                                $waktu_akhir = '';
                                $data_status = new tmtrackingperizinan_trstspermohonan();
                                $data_status->where('tmtrackingperizinan_id', $data_track->id)
                                            ->where('trstspermohonan_id', $data->id)->get();

                                if($data_status->tmtrackingperizinan_id){
                                    $showed = TRUE;
                                    $status = $data_track->status;
                                    $waktu_awal = $data_track->d_entry_awal;
                                    $waktu_akhir = $data_track->d_entry;
                                    break;
                                }
                            }
                        } else {
                            $showed = FALSE;
                            $status = '';
                            $waktu_awal = '';
                            $waktu_akhir = '';
                            break;
                        }
                        //$sts_track = $data->trstspermohonan->get();
                        //$sts_name = $sts_track->n_sts_permohonan;
                        if($showed) {
                            $i++;
							if($group == 1 ) {
							    $n_user = $data_track->tr_user .' / '. $data_track->tr_name;
						    } else {
							    $n_user = '- err -';
                            }
                    ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $data->n_sts_permohonan; ?></td>
                                <td align="Right">
                                    <?php
                                    $hari = 0;
                                    if($waktu_awal && $waktu_akhir){
                                        if($waktu_awal != '0000-00-00 00:00:00' && $waktu_akhir != '0000-00-00 00:00:00'){
                                            $libur = new tmholiday();
                                            $libur->distinct('date')->where('date >=', $waktu_awal)->where('date <=', $waktu_akhir)->order_by('date', 'ASC')->get();
                                            if($libur){
                                                foreach($libur as $data_libur){
                                                    $hari = $hari + 86400;
                                                }
                                            }
                                            $time_akhir = strtotime($waktu_akhir);
                                            $time_awal = strtotime($waktu_awal);
                                            if($data->id == 1) 
												echo "Menunggu konfirmasi pemohon";
                                            else 
												if($data->id == 13 || $data->id == 15 || $data->id == 16 || $data->id == 17) 
												    echo "Selesai";
                                                else 
													if($data->id == 12) 
													    echo "Telah dicetak";
                                                    else {
                                                        if($time_akhir === $time_awal) 
															echo "Sedang Diproses";
                                                        else {
                                                            $time_awal = $time_awal + $hari;
                                                            $total_hari = $total_hari + $hari;
															if($i==1) $ttl_awal = $time_awal;
															$ttl_akhir = $time_akhir + $hari;
                                                            echo timespan($time_awal, $time_akhir);
                                                        }
                                                    }
                                        }
                                    }
                                    ?>
                                </td>
								<td>
                                    <?php
                                    if($waktu_awal){
                                        if($waktu_awal != '0000-00-00 00:00:00'){
                                            if($data->id == "1" || $data->id == "2"){
                                                $list_status = new trstspermohonan();
                                                $list_status->get();
                                                foreach ($list_status as $data_status){
                                                    if($data_status->id == $data->id){
                                                        $total_awal = $waktu_awal;
                                                        break;
                                                    } else 
														$total_awal = NULL;
                                                }
                                            }
                                            echo $this->lib_date->mysql_to_human($waktu_awal, 1).', '.  substr($waktu_awal, 10);
                                        }
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if($waktu_akhir){
                                        if($waktu_akhir != '0000-00-00'){
                                            echo $this->lib_date->mysql_to_human($waktu_akhir, 1).', '.  substr($waktu_akhir, 10);
                                            $total_akhir = $waktu_akhir;
                                        }
                                    }
                                    ?>
                                </td>
								<td><?php echo $n_user; ?></td>
								<td><?php echo $data_track->status; ?></td>
								<td><?php echo $data_track->tr_activiti; ?></td>
                            </tr>
                            <?php
                        }
                    }
                            ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                        <td><b>Total Pengerjaan</b></td>
						<td align="Right">
						    <b>
                                <?php
                                //echo $ttl_awal."<br>";
                                //echo $total_akhir."<br>";
								//echo $ttl_akhir."<br>";
                                //echo $total_hari."<br>";
                                if($total_awal && $total_akhir){
                                    $time_akhir2 = strtotime($total_akhir);
                                    $time_awal2 = strtotime($total_awal);
                                    $time_awal2 = $time_awal2 + $total_hari;
									//echo $time_awal2;
                                    //echo timespan($time_awal2, $time_akhir2)."<br>";
									echo timespan($ttl_awal, $ttl_akhir);
                                }
                                ?>
                            </b>
						</td>
						<td></td>
						<td></td>
						<td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <br style="clear: both;" />
</div>