<div id="content">
  <div class="post">
    <div class="title">
      <h2><?php echo $page_name; ?></h2>
    </div>
    <div class="entry">
      <fieldset id="half">
        <legend>Filter Nomor Pendaftaran</legend>
        <?php echo form_open('survey'); ?>
        <div id="statusRail">
          <div id="rightRail">
            <div id="leftRail">
              <?php 
			        echo form_label('Katagori Pencarian');
				      ?>
		        </div>
            <?php 
			      $kat_cari = array('1' => 'NOMOR PENDAFTARAN',
                              '2' => 'NOMOR SURAT PERMOHONAN PERTEK ');
				    echo form_dropdown('list_state', $kat_cari, $list_state, 'class = "input-select-wrc" id="selector"');
            ?>
          </div>
        </div>
		    <div id="statusRail">
          <div id="rightRail">
            <div id="leftRail">
              <?php 
					    echo form_label('Kata Pencarian', 'kt_cari');
					    ?>
		    		</div>
            <input type="text" class="input-wrc required" name="kt_cari" id="kt_cari" value="<?php echo $kt_cari; ?>" />
            <?php
            $cari_data = array('name' => 'button',
                               'class' => 'button-wrc',
                               'content' => 'Cari Data',
                               'value' => 'Cari Data'
                              );
            echo form_submit($cari_data);
            ?>
          </div>
        </div>
        <?php
		    echo form_hidden('kd_filter', '1');
        echo form_close();
        ?>
      </fieldset>
    </div>

    <div class="entry">
      <fieldset>
        <legend>Filter Data Berdasarkan Tanggal</legend>
        <?php echo form_open('survey'); ?>
        <div id="statusRail">
          <div id="leftRail">
            <?php echo form_label('Tgl Permohonan Awal','d_tahun'); ?>
          </div>
          <div id="rightRail">
            <?php
            $periodeawal_input = array('name'  => 'tgla',
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
            <?php echo form_label('Tgl Permohonan Akhir','d_tahun'); ?>
          </div>
          <div id="rightRail">
            <?php
            $periodeakhir_input = array('name'  => 'tglb',
                                        'value' => $tglb,
                                        'class' => 'input-wrc',
                                        'readOnly'=>TRUE,
                                        'class' => 'monbulan'
                                       );
            echo form_input($periodeakhir_input);
				    echo ' ';

				    $filter_data = array('name' => 'button',
                                 'class' => 'button-wrc',
                                 'content' => 'Filter',
                                 'value' => 'Filter'
                                );
            echo form_submit($filter_data);
            ?>
          </div>
        </div>
        <?php
		    echo form_hidden('kd_filter', '2');
        echo form_close();
        ?>
      </fieldset>
    </div>

  	<div class="entry">
	    <div style="text-align:right">
	      <?php 
        $ctk_list = array('name' => 'button',
                          'content' => 'Cetak Surat Perintah (Multi)',
                          'value' => 'Cetak Surat Perintah (Multi)',
                          'class' => 'button-wrc',
                          'onclick' => 'parent.location=\''.site_url('survey/cetak_multi_sp/'.$tgla.'/'.$tglb).'\''
                         );
	    	if(!$opd_teknis) echo form_button($ctk_list);
	      ?>
      </div>
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="survey">
        <thead>
          <tr>
            <th>No</th>
            <th>No Pendaftaran<br>Nama Pemohon<br>Nama Perusahaan</th>
				  	<th>Asal Pendaftaran<br>Tanggal Daftar<br>Target Selesai</th>
            <th>Jenis Izin</th>
            <th>Objek Izin</th>
            <th>No Permohonan Sartek<br>No Surat Perintah<br>Tanggal Peninjauan</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $i = 1;
          $results = mysql_query($list); 
          while ($rows = mysql_fetch_assoc(@$results)){
	    		  $permohonan_perusahaan = new tmpermohonan_tmperusahaan();
            $permohonan_perusahaan->where('tmpermohonan_id', $rows['id'])->get();
  				  $perusahaan_id = $permohonan_perusahaan->tmperusahaan_id;

					  $perusahaan = new tmperusahaan();
	  			  $perusahaan->where('id', $perusahaan_id)->get();
  	    		$n_perusahaan = $perusahaan->n_perusahaan;
		    	  $a_perusahaan = $perusahaan->a_perusahaan;

            $surat_keluar = new tmsurat_keluar();
	  			  $surat_keluar->where('tmpermohonan_id', $rows['id'])->where('no_surat', $rows['no_per_pertek'])->get();
				    $tgl_surat = $surat_keluar->tgl_surat;
				    $no_pertek = $surat_keluar->no_pertek_awal . $surat_keluar->no_surat . $surat_keluar->no_pertek_akhir;
				    $approve = $surat_keluar->approve;
				    if($surat_keluar->no_pertek_awal == '') $no_pertek = '503 / ' . $surat_keluar->no_surat . ' / Pelper';
				    if($surat_keluar->no_surat == '') $no_pertek = '-';
            $showed = FALSE;
            $idkelompok = NULL;
            $query_data = "SELECT trkelompok_perizinan_id idkelompok FROM trkelompok_perizinan_trperizinan WHERE trperizinan_id = '".$rows['idizin']."'";
            $hasil_data = mysql_query($query_data);
            $rows_data = mysql_fetch_object(@$hasil_data);
            $idkelompok = $rows_data->idkelompok;
			
	    	    $b = '<span style="color: Red">';
		        $be = '</span>';
				    $ket_sp = '';
			      $url = NULL;
            $survey_id = NULL;
            $query_survey = "SELECT b.no_surat_awal, b.no_surat, b.no_surat_akhir, b.multi, b.surat_multi, b.id 
				                     FROM tmpermohonan_trtanggal_survey a, trtanggal_survey b
                             WHERE a.tmpermohonan_id = '".$rows['id']."' AND a.trtanggal_survey_id = b.id";
            $hsl_survey = mysql_query($query_survey);
            $url = site_url('survey/edit/' . $rows['id']);
	  			  $no_surat = '-';
            while ($rows_data = mysql_fetch_assoc(@$hsl_survey)){
              if($rows_data['no_surat']) {
                $survey_id = $rows_data['id'];
                $url = site_url('survey/edit/' . $rows['id'] . "/update");
                $showed = TRUE;
						    $ket_sp = 'SP Tunggal';
                $b = ''; $be = '';
							  $no_surat = $rows_data['no_surat_awal'].' / '.$rows_data['no_surat'].' / '.$rows_data['no_surat_akhir'];
	  					  if($rows_data['no_surat'] == 'Tidak Ditinjau'){
							    $no_surat = $rows_data['no_surat'];
							    $ket_sp = '';
	    					  $showed = FALSE;
		    				  $b = '<span style="color: Blue">';
        		    	$be = '</span>';
				    	  }
                if($rows_data['multi'] == '1') { $ket_sp = 'SP Multi'; $showed = FALSE; }
              }
            }

				    $tampil = TRUE;
            if($opd_teknis){  
					    $tampil = FALSE;
              if($rows['status_berkas'] == 'proses' && $no_pertek != '-') $tampil = TRUE;
              if($approve <> 3) $tampil = FALSE;
			    	}
            if($idkelompok == '2' || $idkelompok == '4'){ // Khusus tinjauan
  	    			if($rows['status_berkas'] != 'Izin Ditolak FO' && $tampil){ // Khusus tidak ditolak di FO
                ?>
                <tr>
                  <td width="3%" valign='top'><?php echo $i; ?></td>
                  <td width="20%" valign='top'><?php echo $b.$rows['pendaftaran_id'].'<br>'.$rows['n_pemohon'].'<br>'.$n_perusahaan.$be;?></td>
				          <td width="10%" valign='top'>
                    <?php
  	        			  echo $b.$rows['kd_gerai'].'<br>'.$be;
				            if($rows['idjenis'] == '1') $tgl_permohonan = $rows['d_terima_berkas'];
                    else if($rows['idjenis'] == '2') $tgl_permohonan = $rows['d_perubahan'];
                    else if($rows['idjenis'] == '3') $tgl_permohonan = $rows['d_perpanjangan'];
                    else if($rows['idjenis'] == '4') $tgl_permohonan = $rows['d_daftarulang'];
                    if($tgl_permohonan){
                        if($tgl_permohonan != '0000-00-00') echo $b.$this->lib_date->mysql_to_human($tgl_permohonan).'<br>'.$this->lib_date->mysql_to_human($rows['d_selesai_proses']).$be;
                    }
                    ?>
                  </td>
                  <td width="22%" valign='top'><?php echo $b.$rows['n_perizinan'].' <br><b>[ '.strtoupper($rows['n_permohonan']).' ]</b>'.$be;?></td>
                  <td width="27%" valign='top'><?php echo $b.$rows['a_izin'].$be; ?></td>
                  <td width="12%" valign='top'>
                    <?php
		    					  //echo $b . $no_pertek . ' ' . date("d-m-Y",strtotime($tgl_surat)) . '<br>'. $no_surat .'<br>'. $be;
								    echo $b . $no_pertek . '<br>'. $no_surat .'<br>'. $be;
                    if ($rows['d_survey']) {
                      //echo $b."<center>" . $this->lib_date->mysql_to_human($rows['d_survey']) . "</center>".$be;
                      $tgl_sur = $rows['d_survey'];
                      $tgl_sur_sd = $rows['survey_sd'];
                      $tgl_survey = $this->lib_date->mysql_to_human($tgl_sur,2);
                      $tgl_survey_sd = $this->lib_date->mysql_to_human($tgl_sur_sd,2);
                      if($no_surat == 'Tidak Ditinjau'){
                        echo $b . '-' . $be;
                      }else{
                        if ($tgl_survey == $tgl_survey_sd) {
                          echo $b . $tgl_survey . $be;
                        }else{
                          $bln_survey =  $this->lib_date->ambil_bulan($tgl_sur);
                          $bln_survey_sd = $this->lib_date->ambil_bulan($tgl_sur_sd);
                          if($bln_survey == $bln_survey_sd) {
                            echo $b . $this->lib_date->ambil_tanggal($tgl_sur).' - '.$this->lib_date->ambil_tanggal($tgl_sur_sd).
			    		    			              ' '.$this->lib_date->ambil_bulan($tgl_sur,2).' '.$this->lib_date->ambil_tahun($tgl_sur) .$be;
                          }else{
                            echo $b. $tgl_survey . " s/d " . $tgl_survey_sd .$be;
                          }
                        }
								      }
                    }else{
                      echo $b."<center>-- Belum Ditentukan --</center>".$be;
                    }
								    //echo $b.'<br>'. $ket_sp .$be;    // keterangan SP dimatikan
                    ?>
                  </td>
                  <td width="6%" valign='top'>
                    <!--<center>-->
                    <?php
  							    $img_lihat = array('src' => base_url().'assets/images/icon/information.png',
                                       'alt' => 'Lihat Detail',
                                       'title' => 'Lihat Detail',
                                       'border' => '0',
                                      );
                    echo anchor(site_url('arsip/edit') .'/L/'.$rows['id'].'/7', img($img_lihat))."&nbsp;";
                    $img_edit = array('src' => 'assets/images/icon/property.png',
                                      'alt' => 'Edit',
                                      'title' => 'Edit',
                                      'border' => '0',
                                      );
                    $img_print = array('src' => 'assets/images/icon/clipboard.png',
                                       'alt' => 'Cetak Surat Perintah',
                                       'title' => 'Cetak Surat Perintah Tinjauan Lapangan',
                                       'border' => '0',
                                      );
                    $img_print_bap = array('src' => 'assets/images/icon/clipboard-doc.png',
                                           'alt' => 'Cetak Surat BAP',
                                           'title' => 'Cetak Berita Acara Tinjauan Lapangan',
                                           'border' => '0',
                                          );
	    	    				if($rows['kd_status'] >= 1) {
									    echo anchor($url, img($img_edit))."&nbsp;";
  							    }
                    if($showed) {
									    echo anchor(site_url('survey/cetak').'/'.$rows['id']."/".$rows['idizin'], img($img_print))."&nbsp;";
                    }
								    ?>
                    <!--</center>-->
                  </td>
                </tr>
                <?php
                $i++;
              }
			      }
          }
                ?>
        </tbody>
      </table>
    	<div style="text-align:right">
	      <?php
        $ctk_list = array('name' => 'button',
                          'content' => 'Cetak Surat Perintah (Multi)',
                          'value' => 'Cetak Surat Perintah (Multi)',
                          'class' => 'button-wrc',
                          'onclick' => 'parent.location=\''.site_url('survey/cetak_multi_sp/'.$tgla.'/'.$tglb).'\''
                         );
        if(!$opd_teknis) echo form_button($ctk_list);
		    //$ctk_list = array('name' => 'button',
        //    'content' => 'Create Surat Perintah (Multi)',
        //    'value' => 'Create Surat Perintah (Multi)',
        //    'class' => 'button-wrc',
        //    'onclick' => 'parent.location=\''.site_url('survey/create_multi_sp/'.$tgla.'/'.$tglb).'\''
        //);
        //echo form_button($ctk_list);
		    ?>
	    </div>
    </div>
  </div>
</div>