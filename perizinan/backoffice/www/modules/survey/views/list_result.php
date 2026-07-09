<div id="content">
  <div class="post">
    <div class="title">
      <h2><?php echo $page_name; ?></h2>
    </div>
    <div class="entry">
      <fieldset id="half">
        <legend>Filter Nomor Pendaftaran</legend>
        <?php echo form_open('survey/result'); ?>
        <div id="statusRail">
          <div id="rightRail">
            <div id="leftRail">
              <?php echo form_label('Nomor Pendaftaran', 'kt_cari');?>
            </div>
            <input type="text" class="input-wrc required" name="kt_cari" id="kt_cari" value="<?php echo (!empty($kt_cari) ? $kt_cari : ''); ?>" />
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

      <fieldset id="half">
        <legend>Filter Data</legend>
        <?php
        echo form_open('survey/result');
        ?>
        <div id="statusRail">
          <div id="leftRail">
            <?php
            echo form_label('Tgl Permohonan Awal','d_tahun');
            ?>
          </div>
          <div id="rightRail">
            <?php
            $periodeawal_input = array('name'  => 'tgla',
                                       'value' => $tgla,
                                       'readOnly'=>TRUE,
                                       'class' => 'input-wrc',
                                       'class' => 'monbulan');
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
            $periodeakhir_input = array('name'  => 'tglb',
                                        'value' => $tglb,
                                        'readOnly'=>TRUE,
                                        'class' => 'input-wrc',
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
        <?php
        echo form_close();
        ?>
      </fieldset>
    </div>
    <div class="entry">
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="survey">
        <thead>
          <tr>
            <th width="3%">No</th>
            <th width="20%">No Pendaftaran<br>Nama Pemohon<br>Nama Perusahaan</th>
            <th width="9%">Asal Pendaftaran<br>Tanggal Daftar<br>Target Selesai</th>
            <th width="25%">Jenis Izin</th>
            <th width="20%">Objek Izin</th>
            <th width="9%">Tanggal Peninjauan</th>
            <th width="8%">Status</th>
            <th width="6">Aksi</th>
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
              
            $detail_gis = new dpmptsp_detail_data();
            //$detail_gis->where('id_data', $perusahaan_id)->get();  // ambil key perusahaan
            $detail_gis->where('id_data', $rows['pendaftaran_id'])->get();       // ambil key permohonan
              
            $showed = FALSE;
            $idkelompok = NULL;
            $query_data = "SELECT trkelompok_perizinan_id idkelompok
                          FROM trkelompok_perizinan_trperizinan
                          WHERE trperizinan_id = '".$rows['idizin']."'";
            $hasil_data = mysql_query($query_data);
            $rows_data = mysql_fetch_object(@$hasil_data);
            $idkelompok = $rows_data->idkelompok;
                          
            $surat_keluar = new tmsurat_keluar();
            $surat_keluar->where('tmpermohonan_id', $rows['id'])->where('no_surat', $rows['no_per_pertek'])->get();
            $no_pertek = $surat_keluar->no_pertek_awal . $surat_keluar->no_surat . $surat_keluar->no_pertek_akhir;
            $approve = $surat_keluar->approve;
            if($surat_keluar->no_pertek_awal == '') $no_pertek = '503 / ' . $surat_keluar->no_surat . ' / Pelper';
            if($surat_keluar->no_surat == '') $no_pertek = '-';
              
            $tampil = TRUE;
            if($opd_teknis){  
              $tampil = FALSE;
              if($rows['status_berkas'] == 'proses'&& $no_pertek != '-') $tampil = TRUE;
              if($approve != 3) $tampil = FALSE;
            }
              
            if($idkelompok == '2' || $idkelompok == '4'){ // Khusus tinjauan
              if($rows['status_berkas'] != 'Izin Ditolak FO' && $tampil){ // Khusus tidak ditolak di FO
                if($rows['c_tinjauan'] === "1") {
                  $cekUpdate = TRUE;
                      $b = '';
                      $be = '';
                }else{
                  $cekUpdate = FALSE;
                  $b = '<span style="color: Red">';
                  $be = '</span>';
                }
                ?>
                <tr>
                  <td valign='top'><?php echo $i; ?></td>
                  <td valign='top'><?php echo $b.$rows['pendaftaran_id'].'<br>'.$rows['n_pemohon'].'<br>'.$n_perusahaan.$be;?></td>
                  <td valign='top'>
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
                  <td valign='top'><?php echo $b.$rows['n_perizinan'].' <br><b>[ '.strtoupper($rows['n_permohonan']).' ]</b>'.$be;?></td>
                  <td valign='top'><?php echo $b.$rows['a_izin'].$be; ?></td>
                  <td valign='top'>
                    <?php
                    if($rows['d_survey']) {
                      echo $b."<center>" . $this->lib_date->mysql_to_human($rows['d_survey']) . "</center>".$be;
                    }else{
                      echo $b."<center>-- Belum Ditentukan --</center>".$be;
                    }
                    ?>
                  </td>
                  <td valign='top'>
                    <?php
                    if($cekUpdate) {
                      echo $b."<b>Sudah di-update</b>".$be;
                    }else{
                      echo $b."Belum Peninjauan".$be;
                    }
                    ?>
                  </td>
                  <td valign='top'>
                    <!--<center>-->
                    <?php
                    $img_lihat = array('src' => base_url().'assets/images/icon/information.png',
                                       'alt' => 'Lihat Detail',
                                       'title' => 'Lihat Detail',
                                       'border' => '0');
                    echo anchor(site_url('arsip/edit') .'/L/'.$rows['id'].'/8', img($img_lihat));
                    
                    $img_edit = array('src' => 'assets/images/icon/property.png',
                                      'alt' => 'Edit',
                                      'title' => 'Edit',
                                      'border' => '0');
                    if($rows['d_survey'] != '0000-00-00' || $rows['kd_gerai'] == 'OnLine') {
                      echo anchor(site_url('survey/resultUpdate') .'/'.$rows['id'], img($img_edit));
                    }
                    $ctk_penangguhan = array('src' => 'assets/images/icon/clipboard.png',
                                             'alt' => 'Cetak Surat Penangguhan',
                                             'title' => 'Cetak Surat Penangguhan',
                                             'border' => '0');
                    if($cekUpdate){
                      echo anchor(site_url('survey/cetakpenangguhan') .'/'.$rows['id'], img($ctk_penangguhan));
                    }
                    $ctk_gis = array('src' => 'assets/images/icon/look.png',
                                     'alt' => 'Lihat Lokasi Visitasi',
                                     'title' => 'Lihat Lokasi Visitasi',
                                     'border' => '0');
                    if($detail_gis->id_data){
                      echo anchor(site_url('survey/view_visit') .'/'.$detail_gis->id_data.'/1', img($ctk_gis)); // 1 menu survay
                    }
                    
                    $ky_staf1 = array('src' => 'assets/images/icon/pengolahmrh.png',
                                      'alt' => 'Kunci Data Sekarang',
                                      'title' => 'Kunci Data Sekarang',
                                      'border' => '0');
                    if($cekUpdate){
                      //echo anchor(site_url('arsip/edit') .'/L/'.$rows['id'].'/8', img($ky_staf1));
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
    </div>
  </div>
  <br style="clear: both;" />
</div>