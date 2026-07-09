<div id="content">
  <div class="post">
    <div class="title">
      <h2><?php echo $page_name; ?></h2>
    </div>
    <div class="entry">
      <fieldset id="half">
        <legend>Filter Data</legend>
        <?php echo form_open('kasir'); ?>
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
                                       'class' => 'monbulan');
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
                                        'class' => 'monbulan');
            echo form_input($periodeakhir_input);
            ?>
          </div>
        </div>
          
        <div id="statusRail">
          <div id="leftRail"></div>
          <div id="rightRail">
            <?php
            $filter_data = array('name' => 'button',
                                 'class' => 'button-wrc',
                                 'content' => 'Filter',
                                 'value' => 'Filter');
            echo form_submit($filter_data);
            ?>
          </div>
        </div>
        <?php echo form_close(); ?>
      </fieldset>
    </div>
  
    <div class="entry">
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="permohonan">
        <thead>
          <tr>
            <th width="2%">No</th>
            <th width="20%">No Pendaftaran<br>Nama Pemohon<br>Nama Perusahaan</th>
            <th width="9%">Asal Pendaftaran<br>Tanggal Daftar<br>Target Selesai</th>
            <th width="35%">Nama Perizinan<br>Objek Ijin</th>
            <th width="20%">No Surat<br>Tanggal Surat dan Masa Berlaku</th>
            <th width="9%">Status<br>Nilai Retribusi</th>
            <th width="5%">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 1;
          $results = mysql_query($list);
          while ($rows = mysql_fetch_assoc(@$results)){
            $showed = FALSE;
            $idkelompok = NULL;
  	        $idiz = $rows['idizin'];
            $query_data2 = "SELECT trkelompok_perizinan_id idkelompok FROM trkelompok_perizinan_trperizinan
                            WHERE trperizinan_id = '".$idiz."'";
            $hasil_data2 = mysql_query($query_data2);
            $rows_data2 = mysql_fetch_object(@$hasil_data2);
            $idkelompok = $rows_data2->idkelompok;
            if($idkelompok == '3' || $idkelompok == '4'){    
              $query_data = "SELECT b.c_skrd, b.status_bap, b.bap_id, b.c_pesan, d.no_surat, d.c_cetak, d.id idsk
                             FROM tmbap_tmpermohonan a, tmbap b, tmpermohonan_tmsk c, tmsk d
                             WHERE a.tmpermohonan_id = '".$rows['id']."'
                             AND a.tmbap_id = b.id
                             AND c.tmpermohonan_id = a.tmpermohonan_id
                             AND c.tmsk_id = d.id";
              $hasil_data = mysql_query($query_data);
              while($rows_data = mysql_fetch_assoc(@$hasil_data)){
                if($rows_data['status_bap'] === $c_bap && $rows_data['idsk']) {
                  $showed = TRUE;
                }else{
                  $showed = FALSE;
                }
              }
              if($showed){
                $no_surat = $rows['no_surat_edit'];
  	            $tgl_surat = $rows['tgl_surat_edit'];
                if($no_surat == ''){
                  $no_surat = $rows['no_surat'];
  	              $tgl_surat = $rows['tgl_surat'];
                }
                $posisi=strpos($no_surat,"No.KP");
                $ctk_no_surat = $no_surat;
                $ctk_no_surat1 = '';
                if($posisi > 0){
                  $ctk_no_surat = substr($no_surat,0,$posisi);
                  $ctk_no_surat1 = substr($no_surat,$posisi,strlen($no_surat));
                }
  	            $permohonan_perusahaan = new tmpermohonan_tmperusahaan();
                $permohonan_perusahaan->where('tmpermohonan_id', $rows['id'])->get();
                $perusahaan_id = $permohonan_perusahaan->tmperusahaan_id;
                $perusahaan = new tmperusahaan();
                $perusahaan->where('id', $perusahaan_id)->get();
                $n_perusahaan = $perusahaan->n_perusahaan;
                $a_perusahaan = $perusahaan->a_perusahaan;
                
  	            if($rows['c_status_bayar'] == 1){
  	            	$nret = $rows['nret'];
  	            	if($nret == NULL) $nret = 0;
  	              $nret = 'Rp. '.number_format($nret,2);
  	              $masa_berlaku = ''; //$this->lib_date->mysql_to_human($rows['d_berlaku_izin']);
  	              $bayar = TRUE;
  	              $b = ''; $be = '';
  	            }else{
  	              $nret = '';
  	              $masa_berlaku = '';
  	              $bayar = FALSE;
  	              $b = '<span style="color: Red">';
                  $be = '</span>';
  	            }
                ?>
                <tr>
                  <td valign='top'><?php echo $i; ?></td>
  	              <td valign='top'><?php echo $b.$rows['pendaftaran_id'].'<br>'.$rows['n_pemohon'].'<br>'.$n_perusahaan.$be; ?></td>
                  <td valign='top'>
  	                <?php 
  	                //echo $b.$rows['pendaftaran_id'].'<br>'.$be;
  	                echo $b.$rows['kd_gerai'].'<br>'.$be;
                    if($rows['idjenis'] == '1') $tgl_permohonan = $rows['d_terima_berkas'];
                    if($rows['idjenis'] == '2') $tgl_permohonan = $rows['d_perubahan'];
                    if($rows['idjenis'] == '3') $tgl_permohonan = $rows['d_perpanjangan'];
                    if($rows['idjenis'] == '4') $tgl_permohonan = $rows['d_daftarulang'];
                    if($tgl_permohonan){
                      if($tgl_permohonan != '0000-00-00') 
                        echo $b.$this->lib_date->mysql_to_human($tgl_permohonan).'<br>'.$this->lib_date->mysql_to_human($rows['d_selesai_proses']).$be;
                    }
  	                ?>
  	              </td>
                  <td valign='top'><?php echo $b.$rows['n_perizinan'].'<br>'.$rows['a_izin'].$be;?></td>
                  <td valign='top'>
                    <?php
                      if($ctk_no_surat1 == ''){
                        echo $b.$ctk_no_surat.'<br>'.$this->lib_date->mysql_to_human($tgl_surat).'<br>'.$masa_berlaku.$be;
                      }else{
                        echo $b.$ctk_no_surat.'<br>'.$ctk_no_surat1.'<br>'.$this->lib_date->mysql_to_human($tgl_surat).'<br>'.$masa_berlaku.$be;
                      }  
                    ?>
                  </td>
                  <td valign='top'>
                    <?php if($bayar) echo $b."<b>Sudah Membayar</b>".'<br>'.$nret.$be; else echo $b."Belum Membayar".'<br>'.$nret.$be; ?>
                  </td>
                  <td valign='top'>
                    <?php
                    $img_edit = array('src' => 'assets/images/icon/property.png',
                                      'alt' => 'Edit',
                                      'title' => 'Edit',
                                      'border' => '0');
  	                echo anchor(site_url('kasir/edit') .'/'. $rows['id'] .'/'. $rows['retribusi_id'], img($img_edit))."&nbsp;";
                    
                    $img_print = array('src' => 'assets/images/icon/print1.png',
                                       'alt' => 'Cetak',
                                       'title' => 'Cetak',
                                       'border' => '0');
                    if($bayar) echo anchor(site_url('kasir/cetak') .'/'. $rows['id'], img($img_print));
                    
                    $n_file_sk='SK_'.$rows['pendaftaran_id'].'.pdf';
					    		  $n_file_kp='KP_'.$rows['pendaftaran_id'].'.pdf';
                    $lok_fileDr = 'assets/skpdf/';
                    $lok_fileSE = 'assets/esignfile/';
                    $stat_sk = TRUE;
                    if(file_exists($lok_fileSE.$n_file_sk)){            // cek PDF SE
                      $stat_sk = FALSE;
                    }else{
                      if(file_exists($lok_fileDr.$n_file_sk)){          // cek PDF Non SE
                        $stat_sk = FALSE; 
                      }
                    }
                    $stat_kp = TRUE;
                    if(file_exists($lok_fileSE.$n_file_kp)){            // cek PDF SE
                      $stat_kp = FALSE;
                    }else{
                      if(file_exists($lok_fileDr.$n_file_kp)){          // cek PDF Non SE
                        $stat_kp = FALSE;
                      }
                    }
                    if(!$stat_sk){
							        //echo anchor(site_url('cetakizin/download_sk').'/'.$pendaftaran_id, img($cetak_sk))."&nbsp;";
							        echo '<br> SK ';
							      }
							      if(!$stat_kp){
							        //echo '<br>';
							        //echo anchor(site_url('cetakizin/download_kp').'/'.$pendaftaran_id, img($cetak_kp))."&nbsp;";
							        echo ' KP ';
							      }
                    ?>
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
    </div>
  </div>
  <br style="clear: both;" />
</div>