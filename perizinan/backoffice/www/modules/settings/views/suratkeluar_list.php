<div id="content">
  <div class="post">
    <div class="title">
      <h2><?php echo $page_name; ?></h2>
    </div>
    <?php //if($kd_auth != 2){ ?>
    <div class="entry">
      <fieldset id="half">
        <legend>Filter Nomor Surat</legend>
        <?php echo form_open('settings/surat_keluar'); ?>
        <div id="statusRail">
          <div id="rightRail">
            <div id="leftRail">
              <?php echo form_label('Nomor Surat', 'kt_cari');?>
            </div>
            <input type="text" class="input-wrc required" name="kt_cari" id="kt_cari" value="<?php echo $kt_cari; ?>" />
            
            <?php
            $cari_data = array('name' => 'button',
                               'class' => 'button-wrc',
                               'content' => 'Cari Data',
                               'value' => 'Cari Data');
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
        <legend>Filter Data Tanggal Surat</legend>
        <?php echo form_open('settings/surat_keluar'); ?>
        <div id="statusRail">
          <div id="leftRail">
            <?php echo form_label('Tgl Surat Awal','d_tahun'); ?>
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
            <?php echo form_label('Tgl Surat Akhir','d_tahun'); ?>
          </div>
          <div id="rightRail">
            <?php
            $periodeakhir_input = array('name'  => 'tglb',
                                        'value' => $tglb,
                                        'class' => 'input-wrc',
                                        'readOnly'=>TRUE,
                                        'class' => 'monbulan');
            echo form_input($periodeakhir_input);
            echo ' ';
            
            $filter_data = array('name' => 'button',
                                 'class' => 'button-wrc',
                                 'content' => 'Cari Data',
                                 'value' => 'Cari Data');
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
      <?php
      $user = new user();
      $user->where('username', $this->session->userdata('username'))->get();
      $id_user = $user->id;
      if(isset($warning)) {
        ?>
        <p align="center" style="font-weight: bold; color: red"><?php echo $warning; ?></p>
        <br>
        <?php 
      }   
      ?>
      <div style="text-align:right">
        <?php
        $psn_nomor = array('name' => 'button',
                           'content' => 'Pesan Nomor',
                           'value' => 'Pesan Nomor',
                           'class' => 'button-wrc',
                           'onclick' => 'parent.location=\''.site_url('settings/surat_keluar/create').'\'');
        if($enabled){
          echo form_button($psn_nomor);
        }
        ?>
      </div>
      
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="pendataan">
        <thead>
          <tr>
            <th width="2%">No</th>
            <th width="20%">Nomor Surat<br>Jam; Tanggal Surat<br>Penyusun Surat</th>
            <th width="36%">Perihal<br>Kepada</th>
            <th width="36%">Status Surat<br>Nomor Pendaftaran<br>Tanggal Daftar</th>
            <th width="6%">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 1;
          $dtclear = '';
          $results = mysql_query($list);
          while($rows = mysql_fetch_assoc(@$results)){
            $permohonan = new tmpermohonan();
            $permohonan = $permohonan->where('id', $rows['tmpermohonan_id'])->get();
            $no_daftar = $permohonan->pendaftaran_id; if($no_daftar == '') $no_daftar = '-';
            $tg_daftar = $permohonan->d_terima_berkas;
            $perizinan = $permohonan->trperizinan->get();
                                  
            if($all_view){
              $cek_auth = TRUE;
            }else{
              $cek_auth = FALSE;
              foreach ($list_izin_user as $izin_user) {
                if($perizinan->id == $izin_user->trperizinan_id) {
                  $cek_auth = TRUE;
              	  break;
                }
              }
            }
            if($no_daftar == '-'){
              $cek_auth = TRUE;
            }
              
            $red = FALSE;
            $b = '';
            $be = '';
            
            $tgl = $rows['tgl_surat'];
            $tgl_surat = date("H:i:s",strtotime($tgl)).'; '.$this->lib_date->mysql_to_human(date("Y-m-d",strtotime($tgl)));
            $username = new user();
            $username->where('id', $rows['user_id'])->get();
            $pembuat = $username->oriname;
            
            if($cek_auth){
              ?>
              <tr>
                <td valign='top'><?php echo $i; ?></td>
                <td valign='top'>
                  <?php
                  $no_pertek_awal = $rows['no_pertek_awal'];
                  if($no_pertek_awal == '') $no_pertek_awal = '503/';
                  $no_pertek_akhir = $rows['no_pertek_akhir'];
                  if($no_pertek_akhir== '') $no_pertek_akhir = '/PelPer';
                  echo $b.$no_pertek_awal.$rows['no_surat'].$no_pertek_akhir.'<br>'.$tgl_surat.'<br>'.$pembuat.$be;
                  ?>
                </td>
                <td valign='top'><?php echo $b.'Perihal: '.$rows['perihal'].'<br>'.'KEPADA '.$rows['kepada'].$be; ?></td>
                <td valign='top'><?php echo $b.$rows['keterangan'].'<br>'.$no_daftar.'<br>'.$this->lib_date->mysql_to_human($tg_daftar).$be; ?></td>
                <td valign='top'>
                  <?php
                  $img_lihat = array('src' => base_url().'assets/images/icon/information.png',
                                     'alt' => 'Lihat Detail',
                                     'title' => 'Lihat Detail',
                                     'border' => '0');
                  
                  $img_ctk = array('src' => base_url().'assets/images/icon/print1.png',
                                   'alt' => 'Lihat Surat',
                                   'title' => 'Lihat Surat',
                                   'border' => '0');
                  
                  $edit_nomor = array('src' => base_url().'assets/images/icon/clipboard-doc.png',
                                      'alt' => 'Edit Data',
                                      'title' => 'Edit Data',
                                      'border' => '0');
                  
                  if($no_daftar != '-'){
                    echo anchor(site_url('arsip/edit') .'/L/'.$rows['tmpermohonan_id'].'/12', img($img_lihat))."&nbsp;";
                    if($rows['keterangan'] !== 'Penghapusan Nomor Surat'){
                      if($rows['perihal'] == 'Pertimbangan Teknis'){
                        echo anchor(site_url('pendataan/print_pertek').'/'.$rows['id'].'/'.$tgl.'/'.
                        $rows['no_surat'], img($img_ctk))."&nbsp;";  //utk permohonan pertek
                      }else{
                        echo anchor(site_url('permohonan/penetapan/ctk_pengembalian').'/'.$rows['tmpermohonan_id'].'/'.
                        $perizinan->id, img($img_ctk))."&nbsp;";    //utk pengembalian
                      }
                    }
                  }else{
                    if($enabled){
                      echo anchor(site_url('settings/surat_keluar/edit').'/'.$rows['id'], img($edit_nomor))."&nbsp;";
                    }
                  }
                  
                  $img_bukti = array('src' => base_url().'assets/images/icon/clipboard.png', 
                                     'alt' => 'Cetak Kartu Kendali',
                                     'title' => 'Cetak Kartu Kendali',
                                     'border' => '0');
                  if($rows['keterangan'] !== 'Penghapusan Nomor Surat'){
                    echo anchor(site_url('settings/surat_keluar/print_kartu_kendali') .'/'. $rows['id'], img($img_bukti))."&nbsp;";
                  }
                  if($group == 1){
                    $img_create = array('src' => base_url().'assets/images/icon/r_information.png',
                                     'alt' => 'Create Dokumentasi Surat (ADMIN)',
                                     'title' => 'Create Dokumentasi Surat (ADMIN)',
                                     'border' => '0');
                    echo anchor(site_url('pendataan/print_pertek').'/'.$rows['id'].'/'.$tgl.'/'.
                                          $rows['no_surat'].'/1', img($img_create))."&nbsp;";  //Create File permohonan pertek (ADMIN)
                  } else {
                    if (!file_exists('assets/file_mohon_sartekSE')) {
                      $img_create = array('src' => base_url().'assets/images/icon/r_information.png',
                                     'alt' => 'Create Dokumentasi Surat (ADMIN)',
                                     'title' => 'Create Dokumentasi Surat (ADMIN)',
                                     'border' => '0');
                    echo anchor(site_url('pendataan/print_pertek').'/'.$rows['id'].'/'.$tgl.'/'.
                                          $rows['no_surat'].'/1', img($img_create))."&nbsp;";
                    }
                  }
                  ?>
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