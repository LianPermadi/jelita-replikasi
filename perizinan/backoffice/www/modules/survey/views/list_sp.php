<div id="content">
    <div class="post">
        <div class="title">
            <h2><?php echo $page_name; ?></h2>
        </div>
 <!--       <div class="entry">
            <fieldset id="half">
                <legend>Filter Data</legend>
                <?php echo form_open('survey'); ?>
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
                            'class' => 'input-wrc',
                            'readOnly'=>TRUE,
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
                            'class' => 'input-wrc',
                            'readOnly'=>TRUE,
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
                        ?>
                    </div>
                </div>
                <?php
                echo form_close();
                ?>
            </fieldset>
        </div>
 -->   
	    <div class="entry">
	        <div style="text-align:right">
	            <?php
                $ctk_list = array(
                    'name' => 'button',
                    'content' => 'Cetak Surat Perintah (Multi)',
                    'value' => 'Cetak Surat Perintah (Multi)',
                    'class' => 'button-wrc',
                    'onclick' => 'parent.location=\''.site_url('survey/cetak_multi_sp/'.$tgla.'/'.$tglb).'\''
                );
                //echo form_button($ctk_list);
		        ?>
            </div>
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="survey">
                <thead>
                    <tr>
                        <th width="3%">No</th>
                        <th width="13%">Nomor Surat<br>Tanggal Peninjauan<br>Tujuan</th>
	    				<th width="32%">Pelaksana Tugas</th>
                        <th width="22%">Nama Pemohon<br>Nama Perusahaan<br>Kontak Pemohon / Perus / Lain</th>
                        <th width="25%">Jenis Izin<br>Objek Ijin</th>
                        <th width="5%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $results = mysql_query($list);
                    while ($rows = mysql_fetch_assoc(@$results)){
						$b = ''; $be = '';
						//inisialisasi petugas peninjauan
                        $tgl_survey_id = $rows['trtanggal_survey_id'];
						$data = mysql_query("SELECT C.n_pegawai, C.golongan, C.n_jabatan FROM trtanggal_survey as A
				                             INNER JOIN tmpegawai_trtanggal_survey as B ON B.trtanggal_survey_id = A.id
                                             INNER JOIN tmpegawai as C ON C.ID = B.tmpegawai_id
                                             WHERE B.type = 2
											 AND B.trtanggal_survey_id = '" . $tgl_survey_id . "'
											 ");
						$nama = ''; 
						while ($nm = mysql_fetch_assoc(@$data)){
                            $nama .= '- '.$nm['n_pegawai'].' ( '.$nm['n_jabatan'].' - '.$nm['golongan'].' )'.'<br>';
						}
						//EOF() inisialisasi petugas peninjauan

						//inisialisasi Tanggal Peninjauan
						$tgl_sur = $rows['d_survey'];
                        $tgl_sur_sd = $rows['survey_sd'];
                        $tgl_survey = $this->lib_date->mysql_to_human($tgl_sur,2);
                        $tgl_survey_sd = $this->lib_date->mysql_to_human($tgl_sur_sd,2);
                        if ($tgl_survey == $tgl_survey_sd) {
                            $tgl_sp = $tgl_survey;
                        } else {
                            $bln_survey =  $this->lib_date->ambil_bulan($tgl_sur);
                            $bln_survey_sd = $this->lib_date->ambil_bulan($tgl_sur_sd);
                            if ($bln_survey == $bln_survey_sd) {
                                $tgl_sp = $this->lib_date->ambil_tanggal($tgl_sur).' - '.$this->lib_date->ambil_tanggal($tgl_sur_sd).
							    					' '.$this->lib_date->ambil_bulan($tgl_sur,2).' '.$this->lib_date->ambil_tahun($tgl_sur);
                            }else{
                                $tgl_sp = $tgl_survey . " s/d " . $tgl_survey_sd;
                            }
                        }
						//EOF() inisialisasi Tanggal Peninjauan

						//inisialisasi tujuan
						$kd_kel = $rows['trkelurahan_id'];
                        $m_kelurahan = new trkelurahan();
                        $m_kelurahan = $m_kelurahan->get_by_id($kd_kel);
						$m_kelurahan->trkecamatan->get();
                        $m_kelurahan->trkecamatan->trkabupaten->get();
						$tujuan = $m_kelurahan->trkecamatan->trkabupaten->n_kabupaten;
						//EOF() inisialisasi tujuan

						//inisialisasi perusahaan
						$permohonan_perusahaan = new tmpermohonan_tmperusahaan();
						$permohonan_perusahaan = $permohonan_perusahaan->where('tmpermohonan_id', $rows['permohonan_id'])->get();
                        $perusahaan = new tmperusahaan();
						$perusahaan = $perusahaan->where('id', $permohonan_perusahaan->tmperusahaan_id)->get();
						$n_perusahaan = $perusahaan->n_perusahaan;
						$kontak1 = $rows['kontak1'];
						$kontak2 = $perusahaan->i_telp_perusahaan;
						$kontak3 = $rows['kontak3'];
						if($kontak1 == '') $kontak1 = '-';
						if($kontak2 == '') $kontak2 = '-';
						if($kontak3 == '') $kontak3 = '-';
						$kontak = $kontak1.' / '.$kontak2.' / '.$kontak3;
                        if($n_perusahaan == '') $n_perusahaan = '-';
						//EOF() inisialisasi perusahaan
					?>
                                <tr>
                                    <td valign='top'><?php echo $i; ?></td>
                                    <td valign='top'><?php echo $b.$rows['no_surat'].'<br>'.$tgl_sp.$be.'<br>'.$tujuan;?> </td>
                                    <td valign='top'><?php echo $b.$nama.$be; ?></td>
                                    <td valign='top'><?php echo $b.$rows['n_pemohon'].'<br>'.$n_perusahaan.'<br>'.$kontak.$be; ?></td>
                                    <td valign='top'><?php echo $b.$rows['n_perizinan'].'<br>'.$rows['a_izin'].$be; ?></td>
                                    <td valign='top'>
                                        <!--<center>-->
                                        <?php
    								    $img_lihat = array(
                                            'src' => base_url().'assets/images/icon/information.png',
                                            'alt' => 'Data Detail',
                                            'title' => 'Data Detail',
                                            'border' => '0',
                                        );
                                        echo anchor(site_url('arsip/edit') .'/L/'.$rows['permohonan_id'].'/11', img($img_lihat))."&nbsp;";

										$img_print = array(
                                            'src' => 'assets/images/icon/clipboard.png',
                                            'alt' => 'Cetak Surat Perintah',
                                            'title' => 'Cetak Surat Perintah Tinjauan Lapangan',
                                            'border' => '0',
                                        );
										echo anchor(site_url('survey/cetak').'/'.$rows['permohonan_id']."/".$rows['idizin'], img($img_print))."&nbsp;";
                                        ?>
                                        <!--</center>-->
                                    </td>
                                </tr>
                                <?php
                                $i++;
                    }
                                ?>
                </tbody>
            </table>
    		<div style="text-align:right">
	            <?php
                $ctk_list = array(
                    'name' => 'button',
                    'content' => 'Cetak Surat Perintah (Multi)',
                    'value' => 'Cetak Surat Perintah (Multi)',
                    'class' => 'button-wrc',
                    'onclick' => 'parent.location=\''.site_url('survey/cetak_multi_sp/'.$tgla.'/'.$tglb).'\''
                );
                //echo form_button($ctk_list);
	    	    ?>
		    </div>
        </div>
    </div>
    <br style="clear: both;" />
</div>