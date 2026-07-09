<div id="content">
  <div class="post">
    <div class="title">
      <h2><?php echo $page_name; ?></h2>
    </div>
    <div class="entry">
      <fieldset id="half">
        <legend>Filter Nomor Pendaftaran</legend>
        <?php echo form_open('permohonan/bap'); ?>
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
        <?php echo form_open('permohonan/bap');?>
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
                                       'class' => 'input-wrc',
                                       'readOnly'=>TRUE,
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

    <?php 
        $alert = $this->session->flashdata("sukses");
        if(!empty($alert)){
      ?>
        <br>
        <div style="color: green; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;"><center><?php echo $alert; ?></center></div>
      <?php } ?>

      <?php 
        $alert = $this->session->flashdata("gagal");
        if(!empty($alert)){
      ?>
        <br>
        <div style="color: red; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;"><center><?php echo $alert; ?></center></div>
      <?php } ?>

    <div class="entry">
      <div class="spacer"></div>
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="sk">
        <thead>
          <tr>
            <th width="3%">No</th>
            <th width="20%">No Pendaftaran<br>Nama Pemohon<br>Nama Perusahaan</th>
            <th width="9%">Asal Pendaftaran<br>Tanggal Daftar<br>Target Selesai</th>
            <th width="25%">Jenis Izin</th>
            <th width="21%">Objek Izin</th>
            <th width="9%">Tanggal Peninjauan<br>Status BAP</th>
            <th width="5%">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php

          $img_lihat = array('src' => base_url().'assets/images/icon/information.png',
                                     'alt' => 'Lihat Detail',
                                     'title' => 'Lihat Detail',
                                     'border' => '0');
          $img_edit = array('src' => base_url().'assets/images/icon/property.png',
                                    'alt' => 'Detail Pertimbangan Teknis',
                                    'title' => 'Detail Pertimbangan Teknis',
                                    'border' => '0');
          $img_bukti = array('src' => base_url().'assets/images/icon/print1.png',
                             'alt' => 'Cetak Pertimbangan Teknis',
                             'title' => 'Cetak Pertimbangan Teknis',
                             'border' => '0');
          $img_lamp = array('src' => base_url().'assets/images/icon/prinsk.ico',
                             'alt' => 'Cetak Lampiran Pertimbangan Teknis',
                             'title' => 'Cetak Lampiran Pertimbangan Teknis',
                             'border' => '0',
                             'style'=> 'width:16px;height:16px;');
          $img_up = array('src' => base_url().'assets/images/icon/navigation.png',
                             'alt' => 'Upload Pertimbangan Teknis',
                             'title' => 'Upload Pertimbangan Teknis',
                             'border' => '0');
          $img_up2 = array('src' => base_url().'assets/images/icon/clipboard-doc.png',
                             'alt' => 'Ubah Dokumen Pertimbangan Teknis',
                             'title' => 'Ubah Dokumen Pertimbangan Teknis',
                             'border' => '0');
          $img_ptup = array('src' => base_url().'assets/images/icon/print.png',
                             'alt' => 'Download Pertimbangan Teknis',
                             'title' => 'Download Pertimbangan Teknis',
                             'border' => '0',
                             'style'=> 'width:16px;height:16px;');

          $i = 1;
          $results = mysql_query($list);
          while($rows = mysql_fetch_assoc(@$results)){
            $permohonan_perusahaan = new tmpermohonan_tmperusahaan();
            $permohonan_perusahaan->where('tmpermohonan_id', $rows['id'])->get();
            $perusahaan_id = $permohonan_perusahaan->tmperusahaan_id;
            $perusahaan = new tmperusahaan();
            $perusahaan->where('id', $perusahaan_id)->get();
            $n_perusahaan = $perusahaan->n_perusahaan;
            $a_perusahaan = $perusahaan->a_perusahaan;
            
            $showed = FALSE;
            $idkelompok = NULL;
            $query_data = "SELECT trkelompok_perizinan_id idkelompok
                           FROM trkelompok_perizinan_trperizinan
                           WHERE trperizinan_id = '".$rows['idizin']."'";
            $hasil_data = mysql_query($query_data);
            $rows_data = mysql_fetch_object(@$hasil_data);
                        
            $surat_keluar = new tmsurat_keluar();
            $surat_keluar->where('tmpermohonan_id', $rows['id'])->where('no_surat', $rows['no_per_pertek'])->get();
            $no_pertek = $surat_keluar->no_pertek_awal . $surat_keluar->no_surat . $surat_keluar->no_pertek_akhir;
            $approve = $surat_keluar->approve;
            if($surat_keluar->no_pertek_awal == '') $no_pertek = '503 / ' . $surat_keluar->no_surat . ' / Pelper';
            if($surat_keluar->no_surat == '') $no_pertek = '-';
            
            $tampil = TRUE;
            if($opd_teknis){  
              //$tampil = FALSE;
              if($approve != 3) $tampil = FALSE;
            }
            $idkelompok = $rows_data->idkelompok;
            if($idkelompok == '2' || $idkelompok == '4'){
              if($rows['c_tinjauan'] === "1"){ 
                $showed = TRUE;
              }else{ 
                $showed = FALSE;
              }
            }else{ 
              $showed = FALSE;
            }
            
            if($showed && $tampil){
              if($rows['kd_status'] < 5){
                $red = TRUE;
                $b = '<span style="color: Red">';
                $be = '</span>';
              } 
              // elseif($rows['n_sts_permohonan'] == 'Arsip') {
              //   $red = FALSE;
              //   $b = '<span style="color: Green">';
              //   $be = '</span>';
              // }
               else {
                $red = FALSE;
                $b = '';
                $be = '';
              }
              //if($idkelompok == '2' || $idkelompok == '4'){
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
                
                <td valign='top'><?php
                  //if($survey_id == NULL) echo "Belum di-entry";
                  if($rows['d_survey']) {
                    echo $b.$this->lib_date->mysql_to_human($rows['d_survey']) .$be;
                  }else{
                    echo "-- Belum Ditentukan --";
                  }
                  echo "<br>";
                  if($red)
                    echo $b."<b>Belum entry BAP</b>".$be;
                  else
                    echo $b."Sudah entry BAP".$be;
                  ?>
                </td>
                <td valign='top'>
                  <!--<center>-->
                  <?php
                  echo anchor(site_url('arsip/edit') .'/L/'.$rows['id'].'/9', img($img_lihat))."&nbsp;";
                  echo anchor(site_url('permohonan/bap/viewBAP') .'/'. $rows['id'].'/'.$rows['idizin'], img($img_edit))."&nbsp;";

                  if($red == FALSE && $rows['template_gub'] != ""){
                    if(file_exists('assets/esignfile/PT_'.$rows['pendaftaran_id'].'.pdf')){
                      echo anchor(site_url('permohonan/sk/cetak').'/'.$rows['id'].'/2/2', img($img_bukti))."&nbsp;";
                    }
                    //if ($this->All) {
                      //echo anchor(site_url('permohonan/sk/cetak_lampiran').'/'.$rows['id'].'/'.$rows['idizin'], img($img_lamp))."&nbsp;";
                    //}
                  }

                  if ($red == FALSE && $rows['pt_ttd'] == "0") {
                    if (file_exists('assets/pertek/PT_'.$rows['pendaftaran_id'].'.pdf')) {
                      echo anchor(site_url('permohonan/bap/showform').'/'.$rows['id'], img($img_up2),'rel="upload_box"')."&nbsp;";
                      echo anchor(site_url('permohonan/bap/downloadpertek').'/'.$rows['pendaftaran_id'], img($img_ptup))."&nbsp;";
                    } else {
                      echo anchor(site_url('permohonan/bap/showform').'/'.$rows['id'], img($img_up),'rel="upload_box"')."&nbsp;";
                    }
                  }
                  
                  ?>
                  <!--</center>-->
                </td>
              </tr>
              <?php
              $i++;
            }
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
  <br style="clear: both;" />
</div>