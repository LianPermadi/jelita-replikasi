<div id="content">
    <div class="post">
        <div class="title">
            <h2><?php echo $page_name; ?></h2>
        </div>

		<div class="entry">
	        <div style="text-align:right">
	            <?php
                switch ($menu) {
                    case 1:   // asal menu Data Entry Hasil Tinjauan
                        $go_menu = 'survey/result_next';
                        break;
                    case 2:   // asal menu Penetapan Izin
                        $go_menu = 'permohonan/penetapan/index';     // OLD index_next
                        break;
					case 3:   //monitoring/perketegori_tertentu
					    $go_menu = 'monitoring/perketegori_tertentu';
                        break;
                }
                $ctk_list = array(
                    'name' => 'button',
                    'content' => 'Kembali',
                    'value' => 'Kembali',
                    'class' => 'button-wrc',
                    'onclick' => 'parent.location=\''.site_url($go_menu).'\''
                );
                echo form_button($ctk_list);
		        ?>
            </div>
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="survey">
                <thead>
                    <tr>
                        <th width="50%">KETERANGAN </th>
	    				<th width="50%">FOTO</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $results = mysql_query($list);
                    while ($rows = mysql_fetch_assoc(@$results)){
						//coba dari perusahaan
						//$perusahaan = new tmperusahaan();
		    			//$perusahaan->where('id', $rows['id_data'])->get();
                        //$permohonan = $perusahaan->tmpermohonan->get();
                        //$survay = $perusahaan->tmpermohonan->trtanggal_survey->get();
						//$izin = $perusahaan->tmpermohonan->trperizinan->get();
						//$pemohon = $perusahaan->tmpermohonan->tmpemohon->get();
						//EOF() coba dari perusahaan

						$permohonan = new tmpermohonan();
                        $permohonan->where('id', $rows['id_data'])->get();
						$perusahaan = $permohonan->tmperusahaan->get();
                        $survay = $permohonan->trtanggal_survey->get();
						$izin = $permohonan->trperizinan->get();
						$pemohon = $permohonan->tmpemohon->get();

						$tgl_sur = $permohonan->d_survey;
                        $tgl_sur_sd = $permohonan->survey_sd;
                        $tgl_survey = $this->lib_date->mysql_to_human($tgl_sur,2);
                        $tgl_survey_sd = $this->lib_date->mysql_to_human($tgl_sur_sd,2);
						if ($tgl_survey != $tgl_survey_sd) {
                            $bln_survey =  $this->lib_date->ambil_bulan($tgl_sur);
                            $bln_survey_sd = $this->lib_date->ambil_bulan($tgl_sur_sd);
                            if ($bln_survey == $bln_survey_sd) {
                                $tgl_survey = $this->lib_date->ambil_tanggal($tgl_sur).' - '.$this->lib_date->ambil_tanggal($tgl_sur_sd).
                                              ' '.$this->lib_date->ambil_bulan($tgl_sur,2).' '.$this->lib_date->ambil_tahun($tgl_sur);
                            }else{
                                $tgl_survey = $tgl_survey . " s/d " . $tgl_survey_sd;
                            }
                        }
                        
						$tanggal_tinjauan = $survay->id;
						$pegawai_lists = new tmpegawai_trtanggal_survey();
                        $pegawai_survey = $pegawai_lists->where('trtanggal_survey_id', $tanggal_tinjauan)
                                         ->where('type', 2)->get();
						$pegawai = '';
                        foreach ($pegawai_survey as $list_pegawai) {
                            $pegawai_tinjauan_lapangan = new tmpegawai();
                            $pegawai_tinjauan_lapangan->where('id', $list_pegawai->tmpegawai_id)->get();
                            $pegawai = $pegawai . strtoupper($pegawai_tinjauan_lapangan->n_pegawai).', ';
                        }
                    ?>
                        <tr>
                            <td valign='top'>
							    <?php
						            echo 'Telah Dilakukan Peninjauan Lapangan Berdasarkan Surat Perintah No : '.$survay->no_surat_awal.' / '.$survay->no_surat.
						                 ' / '.$survay->no_surat_akhir.', Tanggal : '.$tgl_survey.
						                 '<br>'. 'Petugas Visitasi  : '.$pegawai.
						                 '<br>'. 'Nomor Pendaftaran : '.$permohonan->pendaftaran_id.
						                 '<br>'. 'Permohonan Izin   : '.$izin->n_perizinan.
                                         '<br>'. 'Nama Pemohon      : '.$pemohon->n_pemohon.
                                         '<br>'. 'Nama Perusahaan   : '.$perusahaan->n_perusahaan.
                                         '<br>'. 'Yang Berlokasi    : '.$permohonan->a_izin
					                ;
					            ?>
							</td>
                            <td valign='top'>
							    <center>
								    <?php
						                //$image_properties = array('src' => 'http://localhost/gis/uploads/attachements/'.$rows['nama_file'],
						                $image_properties = array('src' => 'http://spekta.tasikmalayakab.go.id/gis/uploads/attachements/'.$rows['nama_file'],
                                                                  'alt' => 'Dokumen Tidak Dapat Ditampilkan',
                                                                  'title' => 'Dokumen Izin',
			                                                      'width' => '100%',
                                                                  'height' => '100%',
                                                                 );
						                echo img($image_properties);
					                ?>
                                </center>
							</td>
                        </tr>
                        <?php
                    }
                        ?>
                </tbody>
            </table>
    		<div style="text-align:right">
	            <?php
                $ctk_list = array(
                    'name' => 'button',
                    'content' => 'Kembali',
                    'value' => 'Kembali',
                    'class' => 'button-wrc',
                    'onclick' => 'parent.location=\''.site_url($go_menu).'\''
                );
                echo form_button($ctk_list);
	    	    ?>
		    </div>
        </div>
    </div>
    <br style="clear: both;" />
</div>