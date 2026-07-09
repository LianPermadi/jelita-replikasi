<div id="content">
  <div class="post">
    <div class="title">
      <?php echo $this->lib_date->view_title($page_name); ?>
    </div>
    <div class="entry">
      <fieldset id="half">
        <legend>Data Permohonan</legend>
        <div id="statusRail">
          <div id="leftRail">
            <?php
            echo form_label('Nama Layanan');
            ?>
          </div>
          <div id="rightRail">
            <?php
            echo $data_izin->n_perizinan;
            ?>
          </div>
        </div>
                
        <div id="statusRail">
          <div id="leftRail"  class="bg-grid">
            <?php
            echo form_label('Kelompok Layanan');
            ?>
          </div>
          <div id="rightRail"  class="bg-grid">
            <?php
            $data_izin->trkelompok_perizinan->get();
            echo $data_izin->trkelompok_perizinan->n_kelompok;
            ?>
          </div>
        </div>
                
        <div id="statusRail">
          <div id="leftRail">
            <?php
            echo form_label('Durasi Pengerjaan');
            ?>
          </div>
          <div id="rightRail">
            <?php
            echo $data_izin->v_hari.' hari';
            ?>
          </div>
        </div>
            
        <div id="statusRail">
          <div id="leftRail" class="bg-grid">
            <?php
            echo form_label('Masa Berlaku');
            ?>
          </div>
          <div id="rightRail" class="bg-grid">
            <?php
            echo $data_izin->v_berlaku_tahun.' tahun';
            ?>
          </div>
        </div>
        
        <div id="statusRail">
          <div id="leftRail">
            <?php
            echo form_label('Dinas Pengelola Layanan');
            ?>
          </div>
          <div id="rightRail">
            <?php
            echo $dinas_pengelola;
            ?>
          </div>
        </div>
      </fieldset>
    </div>
        
    <div class="entry">
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="perizinandetail">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Syarat Izin</th>
            <th>Status</th>
            <th>Izin Baru</th>
            <th>Perpanjangan</th>
            <th>Perubahan</th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach ($list as $data){
            $i = null;
            $data->trsyarat_perizinan->order_by('status', 'asc');
            $data->trsyarat_perizinan->get();
            foreach ($data->trsyarat_perizinan as $list_syarat) {
              $i++;
              ?>
              <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $list_syarat->v_syarat; ?></td>
                <td><?php
                  if($list_syarat->status == "1") $status_data = "Wajib";
                  else $status_data = "Tidak Wajib";
                  echo form_label($status_data);
                  ?>
                </td>
                <td>
                  <?php
                  $show_syarat = new trperizinan_syarat();
                  $show_syarat->where('trsyarat_perizinan_id', $list_syarat->id)
                              ->where('trperizinan_id', $data->id)->get();
                  $var = $show_syarat->c_show_type;
                  $rule = strval(decbin($var));
                  if($show_syarat->status_new == 1) $plv = 6; else $plv = 4; // penambahan pencabutan dan penutupan ditambah 00
                  if (strlen($rule) < $plv) {
                    $len = $plv - strlen($rule);
                    $rule = str_repeat("0", $len) . $rule;
                  }
                  if($plv == 4) $rule = $rule.'00';                         // penambahan pencabutan dan penutupan ditambah 00
                  $arr_rule = str_split($rule);
                  if($plv == 4){
                    $c_baru         = $arr_rule[1];
                    $c_daftar_ulang = $arr_rule[0];
                  }else{
                  	$c_baru         = $arr_rule[0];
                    $c_daftar_ulang = $arr_rule[1];
                  }
                  $c_perpanjangan = $arr_rule[2];
                  $c_ubah         = $arr_rule[3];
                  $c_pencabutan   = $arr_rule[4];
                  $c_penutupan    = $arr_rule[5];
                  
                  $opsi_ya = "Ya";
                  $opsi_tidak = "Tidak";
                  if($c_baru == "1") 
                    echo $opsi_ya;
                  else 
                    echo $opsi_tidak;
                  ?>
                </td>
                <td>
                  <?php
                  if($c_perpanjangan == "1") echo $opsi_ya;
                  else echo $opsi_tidak;
                  ?>
                </td>
                <td>
                  <?php
                  if($c_ubah == "1") echo $opsi_ya;
                  else echo $opsi_tidak;
                  ?>
                </td>
              </tr>
              <?php
            }
          }
          ?>
        </tbody>
        <tfoot>
          <tr>
            <th>No</th>
            <th>Nama Syarat Izin</th>
            <th>Status</th>
            <th>Izin Baru</th>
            <th>Perpanjangan</th>
            <th>Perubahan</th>
          </tr>
        </tfoot>
      </table>
    </div>
    
    <div class="entry" style="text-align: right;">
      <b>
        <?php
        $img_cetak = array('alt' => 'Cetak Persyaratan',
                           'title' => 'Cetak Persyaratan',
                           'content' => 'Cetak Persyaratan',
                           'onclick' => 'parent.location=\'' . site_url('info/infoperizinan/cetak_syarat') .'/'. $data_izin->id. '\''
                          );
        echo form_button($img_cetak);
        
        $img_back = array('alt' => 'Kembali',
                          'title' => 'Kembali',
                          'content' => 'Kembali',
                          'onclick' => 'parent.location=\'' . site_url('info/infoperizinan') . '\''
                         );
        echo form_button($img_back);
        // echo anchor(site_url('info/infoperizinan'), img($img_back))."&nbsp;";
        ?>
      </b>
    </div>
  </div>
  <br style="clear: both;" />
</div>
