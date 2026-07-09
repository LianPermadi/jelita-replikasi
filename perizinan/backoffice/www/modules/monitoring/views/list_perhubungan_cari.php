<div id="content">
    <div class="post">
        <div class="title">
            <h2><?php echo $page_name; ?></h2>
        </div>
		<div class="entry">
		    <font size="2">
                <fieldset>
                    <legend>Filter Data</legend>
                    <?php
                    $attr = array('class' => 'searchForm',
                                  'id'    => 'searchForm'
                    );
                    echo form_open("monitoring/perhubungan_all", $attr);
                    ?>

                    <div id="statusRail">
                        <div id="leftRail">
                            <?php
                                echo form_label('JENIS KENDARAAN ');
                            ?>
						</div>
                        <div id="rightRail">
                            <?php
							$jdl = "";
							If ($xgroup == '0') $jdl = " KENDARAAN KECIL "; else $jdl = " KENDARAAN BESAR ";
							if(!$refresh) {
                                $kat_xgroup = array('0' => 'KENDARAAN KECIL', '1' => 'KENDARAAN BESAR');
								echo form_dropdown('xgroup', $kat_xgroup, $xgroup, 'class = "input-select-wrc" id="xgroup_id"');
							}else{
                                echo ': '.$jdl;
							}
                        ?>
                      </div>
                    </div>

                    <div style="clear: both" ></div>
				    <div id="statusRail">
                        <div id="leftRail">
                            <?php
							if(!$refresh) {
                                echo form_label('PILIH KATAGORI');
					        }else{
								echo form_label('KATAGORI');
					        }
                            ?>
                        </div>
                        <div id="rightRail">
                            <?php
							if(!$refresh) {
				                echo form_dropdown('list_state', $kat_cari, $list_state, 'class = "input-select-wrc" id="katagori_id"');
							}else{
								echo ': '.$kat_cari[$list_state];
							}
                            ?>
                        </div>
                    </div>

                    <?php 
					if(!$refresh) { 
					?>
					    <div style="clear: both" ></div>
    				    <div id="statusRail">
	    			        <div id='show_katagori_1'>
                                <div id="leftRail">
                                    <?php echo form_label($kat_cari[$list_state]); ?>
                                </div>
                                <div id="rightRail">
                                    <input type="text" class="input-wrc required" name="kt_cari" id="kt_cari" value="<?php echo $kt_cari; ?>" />
                                </div>
                            </div>
                        </div>
                    <?php 
					} else { 
                        if($list_state == '6' || $list_state == '7') { // untuk tanggal
					?>      
					        <div style="clear: both" ></div>
                            <div id="statusRail">
                                <div id="leftRail">
                                    <?php echo form_label('Periode Awal', 'd_tahun'); ?>
                                </div>
                                <div id="rightRail">
                                    <?php echo ': '.$this->lib_date->mysql_to_human($first_date); ?>
                                </div>
                            </div>

                            <div style="clear: both" ></div>
                            <div id="statusRail">
                                <div style="clear: both" ></div>
                                <div id="leftRail">
                                    <?php echo form_label('Periode Akhir', 'd_tahun'); ?>
                                </div>
                                <div id="rightRail">
                                    <?php echo ': '.$this->lib_date->mysql_to_human($second_date); ?>
                                </div>
                            </div>
	                    <?php 
						} else { 
						?>
						    <div style="clear: both" ></div>
                            <div id="statusRail">
                                <div id="leftRail">
								    <?php echo form_label('KATA PENCARIAN', 'd_tahun'); ?>
                                </div>
                                <div id="rightRail">
                                    <?php 
							            if($list_state == '8')
							                echo ': '.$kt_cari.' '.$n_ket;
						                else
							                echo ': '.$kt_cari; 
						            ?>
                                </div>
                            </div>
					    <?php 
						} 
					}   
					    ?>

                    <div style="clear: both" ></div>
			        <div id="statusRail">
                        <div id="rightRail">
                            <?php
                            $cari = array('name'    => 'submit',
                                          'class'   => 'button-wrc',
                                          'content' => 'Cari Data',
                                          'value'   => 'Cari Data',
                                          'type'    => 'submit',
                                          'onclick' => 'return validasi()'
                            );

                            $cetak = array('name'    => 'cetak',
                                           'content' => 'Cetak Excel',
                                           'value' => 'Cetak Excel',
                                           'class' => 'button-wrc',
                                           'onclick' => 'parent.location=\''. site_url('monitoring/cetak_perhubungan') . '\''
                            );

							$i_refresh = array('name'=> 'refresh',
                                           'content' => 'Kembali',
                                           'value' => 'Kembali',
                                           'class' => 'button-wrc',
                                           'onclick' => 'parent.location=\''. site_url('monitoring/perhubungan_all') . '\''
                            );

                            echo form_hidden('refresh', TRUE);
							if(!$refresh){
                                echo form_button($cari);
							}else{
								echo form_hidden('refresh', FALSE);
							    echo form_button($i_refresh);
							}
							if ($jumlah > 0) {
                                echo form_button($cetak);
                            }
                            echo form_close();
                            ?>
                        </div>
                    </div>
                </fieldset>
		    </font>
		</div>
        
        <div class="entry">
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="monitoring">
                <thead>
                    <tr>
                        <th width="3%">No</th>
                        <th width="9%">No Kendaraan<br>Nomor Uji</th>
						<th width="19%">Nama Pemilik<br>Nama Perusahaan</th>
						<th width="13%">Tahun Pembuatan : Merek<br>Jenis Kendaraan</th>
						<th width="20%">Nomor SK<br>Nomor KP</th>
						<th width="10%">Tanggal Penetapan SK<br>Tanggal Penetapan KP</th>
						<th width="10%">Tanggal SK<br>Tanggal KP</th>
                        <th width="10%">Masa Berlaku SK<br>Masa Berlaku KP</th>
						<th width="5%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    if($lokasi == 'OPD Teknis') {
                        if($cek_sektor == '10') // khususu Perhubungan
						    $lihat = TRUE;
						else
						    $lihat = FALSE;
					}else{
                            $lihat = TRUE;
					}
					if($lihat) {
                        foreach ($list_data as $data) {
                            $i++;
							if($xgroup == '0'){  // Untuk Kendaraan Kecil
							    $masa_berlaku = $data->masa_berlaku;  // SK
								$tgl_kp_akhir = $data->tgl_kp_akhir;  // KP
							}else{
								$masa_berlaku = $data->TG_KPSK;       // SK
								$tgl_kp_akhir = $data->TG_AKHIR;      // KP
							}
                            if($masa_berlaku < $sekarang){
                                $cek = TRUE;
                            } else {
                                $cek = FALSE;
	                        }
                            if($tgl_kp_akhir < $sekarang){
                                $cek1 = TRUE;
                            } else {
                                $cek1 = FALSE;
                            }
                            
							$b = ''; $be = ''; $bSK = ''; $beSK = ''; $bKP = ''; $beKP = '';
							if($cek || $cek1) {$b  = '<span style="color: Red">'; $be  = '</span>'; }
                            if($cek)  { $bSK = '<span style="color: Red"><b>'; $beSK = '</b></span>'; }
							if($cek1) { $bKP = '<span style="color: Red"><b>'; $beKP = '</b></span>'; }
       						
							if($xgroup == '0'){  // Untuk Kendaraan Kecil
							    $no_kend = $data->no_kend;
    							$no_uji = $data->no_uji;
	    						$nama_pemilik = $data->nama_pemilik;
		    					$nama_perusahaan = $data->nama_perusahaan;
								$tg_tetap_sk = $this->lib_date->mysql_to_human($data->tgl_penetepan);
								$tg_tetap_kp = $this->lib_date->mysql_to_human($data->tgl_penetapan_kp);
			    				$no_sk = $data->no_sk;
				    			$no_kp = $data->no_kp;
					    		$tgl_sk = $this->lib_date->mysql_to_human($data->tgl_sk);
						    	$masa_berlaku = $this->lib_date->mysql_to_human($data->masa_berlaku);
    							$jenis_kend = $data->jenis_kend;
	    						$tgl_kp_awal = $this->lib_date->mysql_to_human($data->tgl_kp_awal);
		    					$tgl_kp_akhir = $this->lib_date->mysql_to_human($data->tgl_kp_akhir);
			    				$tahun = $data->tahun;
				    			$merek = $data->merek;
							}else{ // Untuk Kendaraan Besar
                                $no_kend = $data->NO_MOBIL;
    							$no_uji = $data->NO_UJI;
	    						$nama_pemilik = $data->NAMA_PEMIL;
		    					$nama_perusahaan = $data->NAMA_PERUS;
			    				$no_sk = $data->NO_SK;
				    			$no_kp = $data->NOMOR_KP;
								$tg_tetap_sk = ''; //$data->tg_penetapan;
								$tg_tetap_kp = ''; //$data->tg_penetapan_kp;
					    		$tgl_sk = $this->lib_date->mysql_to_human($data->TG_SK);
						    	$masa_berlaku = $this->lib_date->mysql_to_human($data->TG_KPSK);
    							$jenis_kend = $data->JENIS;
	    						$tgl_kp_awal = $this->lib_date->mysql_to_human($data->TG_MULAI);
		    					$tgl_kp_akhir = $this->lib_date->mysql_to_human($data->TG_AKHIR);
			    				$tahun = $data->TAHUN_PEMB;
				    			$merek = $data->MERK;
							}
							if($no_kend == '') $no_kend = '-';
   							if($no_uji == '') $no_uji = '-';
    						if($nama_pemilik == '') $nama_pemilik = '-';
	    					if($nama_perusahaan == '') $nama_perusahaan = '-';
		    				if($no_sk == '') $no_sk = '-';
			    			if($no_kp == '') $no_kp = '-';
							if($tg_tetap_sk == '') $tg_tetap_sk == '-';
							if($tg_tetap_kp == '') $tg_tetap_kp == '-';
				    		if($tgl_sk == '') $tgl_sk = '-';
					    	if($masa_berlaku == '') $masa_berlaku = '-';
						    if($jenis_kend == '') $jenis_kend = '-';
   							if($tgl_kp_awal == '') $tgl_kp_awal = '-';
    						if($tgl_kp_akhir == '') $tgl_kp_akhir = '-';
	    					if($tahun == '') $tahun = '-';
		    				if($merek == '') $Merek = '-';
                    ?>
                            <tr>
								<td><?php echo $i; ?></td>
       							<td><?php echo $b . $no_kend .'<br>'. $no_uji . $be; ?></td>
								<td><?php echo $b . $nama_pemilik .'<br>'. $nama_perusahaan . $be; ?></td>
			        			<td><?php echo $b . $tahun .' : '. $merek .'<br>'. $jenis_kend . $be; ?></td>
			        			<td><?php echo $b . $no_sk .'<br>'. $no_kp . $be; ?></td>
								<td><?php echo $b . $tg_tetap_sk .'<br>'. $tg_tetap_kp . $be; ?></td>
       							<td><?php echo $b . $bSK . $tgl_sk .'<br>'. $bKP . $tgl_kp_awal . $be; ?></td>
					        	<td><?php echo $b . $masa_berlaku . $beSK.'<br>'.$tgl_kp_akhir . $beKP . $be; ?></td>
								<td><?php echo ''; ?></td>
                            </tr>
                            <?php
                        }
					}
                            ?>
                </tbody>
            </table>
        </div>
    </div>
    <br style="clear: both;" />
</div>