<div id="content">
  <div class="post">
    <div class="title">
      <h2><?php echo $page_name ?></h2>
    </div>
    <div class="entry">
      <div id="tabs">
        <ul>
          <li><a href="#tabs-1"><b>Data Jenis Perizinan</b></a></li>
        </ul>
        <div id="tabs-1">
          <?php
          $attr = array('id' => 'form');
          echo form_open('perizinan/' . $save_method, $attr);
          echo form_hidden('id', $id);
          ?>
          <label>Kode Indeks Klasifikasi</label>
          <?php
          $kd_indeks_input = array('name' => 'kd_indeks',
                                   'value' => $kd_indeks,
                                   'class' => 'input-wrc'
                                  );
          echo form_input($kd_indeks_input); 
          echo ' ';
          echo 'Lihat Buku Klasifikasi Arsip';
          ?>
          <br style="clear: both" />

          <label>Nama Indeks Klasifikasi</label>
          <?php
          $indeks_input = array('name' => 'indeks',
                                'value' => $indeks,
                                'style'=>'width:40%',
                                'class' => 'input-wrc '
                               );
          echo form_input($indeks_input);
          echo ' ';
          echo 'Lihat Buku Klasifikasi Arsip';
          ?>
          <br style="clear: both" />
  
          <label>Kode Izin</label>
          <?php
          $kd_izin_input = array('name' => 'kd_izin',
                                 'value' => $kd_izin,
                                 'class' => 'input-wrc'
                                );
          echo form_input($kd_izin_input);
          echo ' ';
          echo substr($kd_izin,0,2).'.'.substr($kd_izin,2,1).'.'.substr($kd_izin,3,2).'.'.substr($kd_izin,5);
          ?>
          <br style="clear: both" />

          <label>Jenis perizinan</label>
          <?php
          $n_ijin_input = array('name' => 'n_perizinan',
                                'value' => $n_perizinan,
                                'style'=>'width:65%',
                                'class' => 'input-wrc required'
                               );
          echo form_input($n_ijin_input);
          ?>
          <br style="clear: both" />

          <label>Jenis perizinan (Cetak)</label>
          <?php
          $n_ijin_ctk_input = array('name' => 'n_perizinan_cetak',
                                    'value' => $n_perizinan_cetak,
                                    'style'=>'width:65%',
                                    'class' => 'input-wrc required'
                                   );
          echo form_input($n_ijin_ctk_input);
          ?>
          <br style="clear: both" />

          <label>Durasi Pengerjaan (Hari)</label>
          <?php
          $v_hari_input = array('name' => 'v_hari',
                                'value' => $v_hari,
                                'class' => 'input-wrc required digits'
                               );
          echo form_input($v_hari_input);
          ?>
          <br style="clear: both" />

          <label>Lama Berlaku Izin (Bulan)</label>
          <?php
          $v_berlaku_tahun_input = array('name' => 'v_berlaku_tahun',
                                         'value' => $v_berlaku_tahun,
                                         'class' => 'input-wrc required digits'
                                        );
          echo form_input($v_berlaku_tahun_input);
          echo " 1000 untuk 'TAK TERBATAS SELAMA PERUSAHAAN BERDIRI'";
          ?>
          <br style="clear: both" />

          <label>Target Anggaran</label>
          <?php
          $v_perizinan_input = array('name' => 'v_perizinan',
                                     'value' => $v_perizinan,
                                     'class' => 'input-wrc required digits'
                                    );
          echo form_input($v_perizinan_input);
          ?>
          <br style="clear: both" />
        
          <label>Unit Kerja</label>
          <select name="opsi_uk" class="input-select-wrc" style="width:40%">
            <!--option value="xx" selected="selected"> ------Pilih salah satu------ </option-->
            <?php
            $selected = NULL;
            foreach ($list_uk as $dtunitkerja) {
              if ($dtunitkerja->id === $unitkerja_id) {
                $selected = ' selected="selected" ';
              } else {
                $selected = null;
              }
              echo "<option value=\"" . $dtunitkerja->id . "\"" . $selected . ">"
                   . $dtunitkerja->n_unitkerja . "</option>\n" ;
            }
            ?>
          </select>
          <br style="clear: both" />

          <label>Bidang Pengelola Teknis</label>
          <?php
          $bid_teknis_input = array('name' => 'bid_teknis',
                                    'value' => $bid_teknis,
                                    'style'=>'width:65%',
                                    'class' => 'input-wrc'
                                   );
          echo form_input($bid_teknis_input);
          ?>
          <br style="clear: both" />

          <label>Sektor Perizinan</label>
          <select name="opsi_sektor" class="input-select-wrc" style="width:20%">
            <!--option value="xx" selected="selected"> ------Pilih salah satu------ </option-->
            <?php
            $selected = NULL;
            foreach ($list_sektor as $data) {
              if ($data->id === $sektor_id) {
                $selected = ' selected="selected" ';
              } else {
                $selected = NULL;
              }
              echo "<option value=\"" . $data->id . "\"" . $selected . ">". $data->n_sektor . "</option>\n" ;
            }
            ?>
          </select>
          <br style="clear: both" />

          <?php
          if($is_open == 1){
            $select = "";
            $selectx = "selected='selected'";
            $selecty = "";
          } else 
            if ($is_open == 0){
              $select = "";
              $selectx = "";
              $selecty = "selected='selected'";
            } else 
              if ($is_open == 2) {
                $select = "selected='selected'";
                $selectx = "";
                $selecty = "";
              }
          ?>
          <label>Jenis Izin Terbuka</label>
          <select name="is_open" class="input-select-wrc">
            <!--option value="xx" <?php echo $select; ?>> ------Pilih salah satu------ </option-->
            <option value="1" <?php echo $selectx; ?>>Ya</option>
            <option value="0" <?php echo $selecty; ?>>Tidak</option>
          </select>
          <br style="clear: both" />

          <?php
          if($c_foto == 1){
            $select = "";
            $select1 = "selected='selected'";
            $select2 = "";
          } else 
            if ($c_foto == 0){
              $select = "";
              $select1 = "";
              $select2 = "selected='selected'";
            } else 
              if($c_foto == 2) {
                $select = "selected='selected'";
                $select1 = "";
                $select2 = "";
              }
          ?>
          <label>Tampilkan Foto Pemohon</label>
          <select name="c_foto" class="input-select-wrc">
            <!--option value="xx" <?php echo $select; ?>> ------Pilih salah satu------ </option-->
            <option value="1" <?php echo $select1; ?>>Ya</option>
            <option value="0" <?php echo $select2; ?>>Tidak</option>
          </select>
          <br style="clear: both" />

          <?php
          if($c_keputusan == 1){
            $select = "";
            $selecta = "selected='selected'";
            $selectb = "";
          } else 
            if ($c_keputusan == 0){
              $select = "";
              $selecta = "";
              $selectb = "selected='selected'";
            } else 
              if ($c_keputusan == 2) {
                $select = "selected='selected'";
                $selecta = "";
                $selectb = "";
              }
          ?>
          <label>Izin / Non Izin</label>
          <select name="c_keputusan" class="input-select-wrc">
            <!--option value="xx"  <?php echo $select; ?>> ------Pilih salah satu------ </option-->
            <option value="1" <?php echo $selecta; ?>>Izin</option>
            <option value="0" <?php echo $selectb; ?>>Non Izin</option>
          </select>
          <br style="clear: both" />

          <?php
          if($c_aktif == 1){
            $select = "";
            $selecte = "selected='selected'";
            $selectf = "";
          } else 
            if ($c_aktif == 0) {
              $select = "";
              $selecte = "";
              $selectf = "selected='selected'";
            } else  
              if ($c_aktif == 2) {
                $select = "selected='selected'";
                $selecte = "";
                $selectf = "";
              }
          ?>
          <label>Status Aktifasi Izin di FO</label>
          <select name="c_aktif" class="input-select-wrc">
            <option value="0" <?php echo $selectf; ?>>Aktif</option>
            <option value="1" <?php echo $selecte; ?>>Tidak Aktif</option>
          </select>
          <br style="clear: both" />

          <?php
          if($c_online == 1){
            $select = "";
            $selecte = "selected='selected'";
            $selectf = "";
          } else 
            if ($c_online == 0) {
              $select = "";
              $selecte = "";
              $selectf = "selected='selected'";
            } else  
              if ($c_online == 2) {
                $select = "selected='selected'";
                $selecte = "";
                $selectf = "";
              }
          ?>
          <label>Status Izin Online</label>
          <select name="c_online" class="input-select-wrc">
            <option value="0" <?php echo $selectf; ?>>OnLine</option>
            <option value="1" <?php echo $selecte; ?>>OffLine</option>
          </select>
          <br style="clear: both" />

          <label>Kelompok</label>
          <select name="opsi_klp" class="input-select-wrc" style="width:20%">
            <!--option value="xx" selected="selected"> ------Pilih salah satu------ </option-->
            <?php
            $selected = NULL;
            foreach ($list_klp as $data) {
              if ($data->id === $kelompok_id) {
                $selected = ' selected="selected" ';
              } else {
                $selected = NULL;
              }
              echo "<option value=\"" . $data->id . "\"" . $selected . ">". $data->n_kelompok . "</option>\n" ;
            }
            ?>
          </select>
          <br style="clear: both" />
           
          <?php
          if($c_berlaku == 1){
            $select = "";
            $selectc = "selected='selected'";
            $selectd = "";
          } else 
            if ($c_berlaku == 0) {
              $select = "";
              $selectc = "";
              $selectd = "selected='selected'";
            } else  
              if ($c_berlaku == 2) {
                $select = "selected='selected'";
                $selectc = "";
                $selectd = "";
              }
          ?>
          <label>Tampilkan Masa Berlaku</label>
          <select name="c_berlaku" class="input-select-wrc">
            <!--option value="xx" <?php echo $select; ?>> ------Pilih salah satu------ </option-->
            <option value="1" <?php echo $selectc; ?>>Ya</option>
            <option value="0" <?php echo $selectd; ?>>Tidak</option>
          </select>
          <br style="clear: both" />

          <label>Format Nomor Izin</label>
          <?php
          $no_awal_input = array('name' => 'no_sk_awal',
                                 'value' => $no_sk_awal,
                                 'style'=>'width:5%'
                                );
          echo form_input($no_awal_input)." ";
                
          $no_tengah_input = array('name' => 'no_sk_tengah',
                                   'value' => $no_sk_tengah,
                                   'class' => 'input-wrc required digits',
                                   'style'=>'width:3%'
                                   //,
                                   //'readOnly'=>TRUE
                                  );
          echo form_input($no_tengah_input)." ";
                    
          $no_akhir_input = array('name' => 'no_sk_akhir',
                                  'value' => $no_sk_akhir,
                                  'style'=>'width:10%'
                                 );
          echo form_input($no_akhir_input)." ";
                    
          $no_akhir_tahun = array('name' => 'no_sk_tahun',
                                  'value' => date("Y"),
                                  'style'=>'width:3%',
                                  'readOnly'=>TRUE
                                 );
          echo form_input($no_akhir_tahun);
          echo ' ketik kd_bln untuk Kode Bulan dalam Romawi';
          ?>
          <br style="clear: both" />

          <?php
          switch ($c_in_nomor) {
            case 0: 
              $sel_in_nomor0 = "selected='selected'";
              $sel_in_nomor1 = "";
              $sel_in_nomor2 = "";
              $sel_in_nomor3 = "";
              break;
            case 1: 
              $sel_in_nomor0 = "";
              $sel_in_nomor1 = "selected='selected'";
              $sel_in_nomor2 = "";
              $sel_in_nomor3 = "";
              break;
            case 2: 
              $sel_in_nomor0 = "";
              $sel_in_nomor1 = "";
              $sel_in_nomor2 = "selected='selected'";
              $sel_in_nomor3 = "";
              break;
            case 3: 
              $sel_in_nomor0 = "";
              $sel_in_nomor1 = "";
              $sel_in_nomor2 = "";
              $sel_in_nomor3 = "selected='selected'";
              break;  
          }
          ?>
          <label>Metoda Penomoran</label>
          <select name="c_in_nomor" class="input-select-wrc">
            <!--option value="xx" <?php echo $sel_in_nomor; ?>> ------Pilih salah satu------ </option-->
            <option value="0" <?php echo $sel_in_nomor0; ?>>System Ke Berkas (Mandiri)</option>
            <option value="1" <?php echo $sel_in_nomor1; ?>>Berkas Ke System</option>
            <option value="2" <?php echo $sel_in_nomor2; ?>>System Ke Berkas (Master)</option>
            <option value="3" <?php echo $sel_in_nomor3; ?>>System Ke Berkas (Mengikuti)</option>
          </select>
          <br style="clear: both" />

          <?php
          switch ($e_ttd) {
            case 0: 
              $sel_ttd0 = "selected='selected'";
              $sel_ttd1 = "";
              $sel_ttd2 = "";
              break;
            case 1: 
              $sel_ttd0 = "";
              $sel_ttd1 = "selected='selected'";
              $sel_ttd2 = "";
              break;
            case 2: 
              $sel_ttd0 = "";
              $sel_ttd1 = "";
              $sel_ttd2 = "selected='selected'";
            break;
          }
          ?>
          <label>Metoda Tandatangan SK</label>
          <select name="e_ttd" class="input-select-wrc">
            <option value="1" <?php echo $sel_ttd1; ?>>Elektronik</option>
            <option value="0" <?php echo $sel_ttd0; ?>>Manual</option>
            <option value="2" <?php echo $sel_ttd2; ?>>Upload</option>
          </select>
          <br style="clear: both" />
          
          <?php
          switch ($e_sertifikat) {
            case 0: 
              $e_serti0 = "selected='selected'";
              $e_serti1 = "";
              break;
            case 1: 
              $e_serti0 = "";
              $e_serti1 = "selected='selected'";
              break;
          }
          ?>
          <label>TTD Tersertifikasi (SE)</label>
          <select name="e_sertifikat" class="input-select-wrc">
            <option value="0" <?php echo $e_serti0; ?>>Tidak</option>
            <option value="1" <?php echo $e_serti1; ?>>Ya</option>
          </select>
          <br style="clear: both" />

          <?php
          switch ($pt_ttd) {
            case 0: 
              $pt_ttd0 = "selected='selected'";
              $pt_ttd1 = "";
              break;
            case 1: 
              $pt_ttd0 = "";
              $pt_ttd1 = "selected='selected'";
              break;
          }
          ?>
          <label>Metoda Tanda Tangan Pertek</label>
          <select name="pt_ttd" class="input-select-wrc">
            <option value="0" <?php echo $pt_ttd0; ?>>Upload</option>
            <option value="1" <?php echo $pt_ttd1; ?>>Elektronik</option>
          </select>
          <br style="clear: both" />

          <?php
          switch ($pt_sertifikat) {
            case 0: 
              $pt_serti0 = "selected='selected'";
              $pt_serti1 = "";
              break;
            case 1: 
              $pt_serti0 = "";
              $pt_serti1 = "selected='selected'";
              break;
          }
          ?>
          <label>TTD Tersertifikasi Pertek (SE Pertek)</label>
          <select name="pt_sertifikat" class="input-select-wrc">
            <option value="0" <?php echo $pt_serti0; ?>>Tidak</option>
            <option value="1" <?php echo $pt_serti1; ?>>Ya</option>
          </select>
          <br style="clear: both" />

        </div>
      </div>
      <br>
      <?php
      $add_ijin = array('name' => 'submit',
                        'class' => 'submit-wrc',
                        'content' => 'Simpan',
                        'type' => 'submit',
                        'value' => 'Simpan'
                       );
      echo form_submit($add_ijin);
      echo "<span></span>";

      $cancel_ijin = array('name' => 'button',
          'class' => 'button-wrc',
          'content' => 'Batal',
          'onclick' => 'parent.location=\''. site_url('perizinan') . '\''
      );
      echo form_button($cancel_ijin);
      echo form_close();
      ?>
    </div>
  </div>
  <br style="clear: both;" />
</div>