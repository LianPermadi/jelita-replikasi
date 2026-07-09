<div id="content">
  <div class="post">
    <div class="title">
      <?php echo 'Testing Ambil Token';//echo $this->lib_date->view_title($page_name); ?> 
    </div>
    
    <div class="entry">
      <?php
      $cek = "checked";
      echo form_open('ruangan/save_token/' . $save_method);
      $service_input = array('name' => 'service',
                             'value' => $service,
                             'class' => 'input-wrc required',
                             'id' => 'service'
                            );
      $cancel = array('name' => 'button',
                      'class' => 'button-wrc',
                      'content' => 'Batal',
                      'onclick' => 'parent.location=\'' . site_url('ruangan/master') . '\''
                     );
      ?>
      <table>
        <tr>
          <td style="width: 150px;"><label class="label-wrc">TOKEN </label></td>
          <td style="width: 250px;"><?php echo $token; ?></td>
        </tr>
      </table>
    
      <table>
        <tr>
          <td style="width: 150px;"><label class="label-wrc">No WA (PIC)</label></td>
          <td style="width: 250px;"><?php echo form_input($service_input); ?></td>
        </tr>
      </table>
      
      <!--
      <table>
        <tr>
          <td style="width: 150px;"><label class="label-wrc">Send SMS/WA</label></td>
          <td style="width: 100px;"><input type="radio" name="smsgateway"  id="smsgateway" value="1" <?php if($statsms=="1") echo "$cek"; ?> />ON</td>
          <td style="width: 100px;"><input type="radio" name="smsgateway"  id="smsgateway" value="0" <?php if($statsms=="0") echo "$cek"; ?> />OFF</td>
          <td style="width: 250px;"><input type="checkbox" name="cek_sms" value="1">Cek Pengiriman SMS/WA<br/></td>
        </tr>
      </table>
      
      <table>
        <tr>
          <td style="width: 150px;"><label class="label-wrc">Notif e-Perdin</label></td> 
          <td style="width: 100px;"><input type="radio" name="e_perdin"  id="e_perdin" value="1" <?php if($n_e_perdin=="1") echo "$cek"; ?> />ON</td>
          <td style="width: 100px;"><input type="radio" name="e_perdin"  id="e_perdin" value="0" <?php if($n_e_perdin=="0") echo "$cek"; ?> />OFF</td>
        </tr>
      </table>
      
      <table>
        <tr>
          <td style="width: 150px;"><label class="label-wrc">Send Mail</label></td>
          <td style="width: 100px;"><input type="radio" name="send_mail"  id="send_mail" value="1" <?php if($statmail=="1") echo "$cek"; ?> />ON</td>
          <td style="width: 100px;"><input type="radio" name="send_mail"  id="send_mail" value="0" <?php if($statmail=="0") echo "$cek"; ?> />OFF</td>
          <td style="width: 250px;"><input type="checkbox" name="cek_mail" value="1">Cek Pengiriman e-Mail<br/></td>
        </tr>
      </table>
      
      <table>
        <tr>
          <td style="width: 150px;"><label class="label-wrc">Aplikasi/Login SSO</label></td>
          <td style="width: 100px;"><input type="radio" name="status_sso" value="1" <?php if($sts_sso=="1") echo "$cek"; ?> />Aktif</td>
          <td style="width: 100px;"><input type="radio" name="status_sso" value="0" <?php if($sts_sso=="0") echo "$cek"; ?> />Tidak Aktif</td>
        </tr>
      </table>
      
      <table>
        <tr>
          <td><label class="label-wrc">Tinggi Kop Surat</label></td>
          <td><?php echo form_input($piksel_input); ?></td>
          <td width="5"></td>
          <td> <label  class="label-wrc">Piksel</label> </td>
        </tr>
      </table>
      
      <table>
        <tr>
          <td style="width: 150px;"><label class="label-wrc">Approve SK (Pergantian Esl II)</label></td>
          <td style="width: 100px;"><input type="radio" name="stop_esl2"  id="stop_esl2" value="1" <?php if($stat_stop_esl2=="1") echo "$cek"; ?> />ON</td>
          <td style="width: 100px;"><input type="radio" name="stop_esl2"  id="stop_esl2" value="0" <?php if($stat_stop_esl2=="0") echo "$cek"; ?> />OFF</td>
        </tr>
      </table>

      <table>
        <tr>
          <td><label class="label-wrc">Tanggal Jabat Esl II</label></td>
          <td><?php $tglsk_input = array('name' => 'tgl_jabat',
                          'value' => $tgl_jabat,
                          'class' => 'input-wrc',
                          'readOnly'=>TRUE,
                          'class' => 'monbulan'
                         );
                echo form_input($tglsk_input); ?></td>
        </tr>
      </table>
      
      <table>
        <tr>
          <td style="width: 150px;"><label class="label-wrc">Approve Permohonan Sartek (Pergantian Esl III)</label></td>
          <td style="width: 100px;"><input type="radio" name="stop_esl3"  id="stop_esl3" value="1" <?php if($stat_stop_esl3=="1") echo "$cek"; ?> />ON</td>
          <td style="width: 100px;"><input type="radio" name="stop_esl3"  id="stop_esl3" value="0" <?php if($stat_stop_esl3=="0") echo "$cek"; ?> />OFF</td>
        </tr>
      </table>
      
      <table>
        <tr>
          <td style="width: 150px;"><label class="label-wrc">Penomoran Pertimbangan Teknis</label></td>
          <td style="width: 100px;"><input type="radio" name="no_pertek"  id="no_pertek" value="1" <?php if($stat_nopertek=="1") echo "$cek"; ?> />System</td>
          <td style="width: 100px;"><input type="radio" name="no_pertek"  id="no_pertek" value="0" <?php if($stat_nopertek=="0") echo "$cek"; ?> />Manual</td>
        </tr>
      </table>
      
      <table>
        <tr>
          <td style="width: 150px;"><label class="label-wrc">Penomoran Surat Penolakan</label></td>
          <td style="width: 100px;"><input type="radio" name="no_srt_tolak"  id="no_srt_tolak" value="1" <?php if($stat_nostolak=="1") echo "$cek"; ?> />System</td>
          <td style="width: 100px;"><input type="radio" name="no_srt_tolak"  id="no_srt_tolak" value="0" <?php if($stat_nostolak=="0") echo "$cek"; ?> />Manual</td>
        </tr>
      </table>

      <table>
        <tr>
          <td style="width: 150px;"><label class="label-wrc">Sistem E-Sign</label></td>
          <td style="width: 100px;"><input type="radio" name="stat_ttd" value="0" <?php if($stat_ttd=="0") echo "$cek"; ?> />Standar</td>
          <td style="width: 100px;"><input type="radio" name="stat_ttd" value="1" <?php if($stat_ttd=="1") echo "$cek"; ?> />Terbaru</td>
        </tr>
      </table>

      <table>
        <tr>
          <td style="width: 150px;"><label class="label-wrc">Status Notice</label></td>
          <td style="width: 100px;"><input type="radio" name="stat_notice" value="1" <?php if($stat_notice=="1") echo "$cek"; ?> />ON</td>
          <td style="width: 100px;"><input type="radio" name="stat_notice" value="0" <?php if($stat_notice=="0") echo "$cek"; ?> />OFF</td>
        </tr>
      </table>

      <table>
        <tr>
          <td><label class="label-wrc">Versi Aplikasi</label></td>
          <td><input type="text" name="app_versi" value="<?php echo $app_versi; ?>"> </td>
          <td width="120"> <p>Version <?= $app_versi ?></p></td>
        </tr>
      </table>
      
      <table>
        <tr>
          <td><label class="label-wrc">Isi Notice</label></td>
          <td>
            <?php if (!empty($val_notice)) {
                $arrnotice = explode("^", $val_notice);
                $notice = $arrnotice[0];
             ?>
              <textarea name="val_notice" style="width: 100%;" cols="90" rows="12" class="input-area-wrc" <?php echo ($stat_notice == "1" ? "required" : "readonly"); ?>><?php echo $notice; ?></textarea>
            <?php } else { ?>
              <textarea name="val_notice" style="width: 100%;" cols="90" rows="12" class="input-area-wrc" <?php echo ($stat_notice == "1" ? "required" : "readonly"); ?>></textarea>
            <?php } ?>
            
        </td>
        </tr>
      </table>

      <!--
      <table>
        <tr>
          <td><label class="label-wrc">Notif Pemohon</label></td>
          
        </tr>
      </table>


      <table>
        <tr>
          <td><label class="label-wrc">File Notice</label></td>
          <td>
            <?php 
            if ($stat_notice == "1") {
              $arrnotice = explode("^", $val_notice);
              if (isset($arrnotice[1]) && !empty($arrnotice[1])) {
                $file_notice = $arrnotice[1];
               ?>
                <input type="hidden" name="path_notice" value="<?php echo $file_notice; ?>">
                <a href="<?php echo base_url().$file_notice; ?>">Cek File Notice</a>&nbsp;<a href="<?php echo base_url().'settings/webservice/delfilenotice/1' ?>" class="submit-wrc" title="Hapus File Notice">X</a>
              <?php } else { ?>
                <input type="file" name="file_notice" class="submit-wrc">
              <?php }
            } else { 
              if (isset($arrnotice[1]) && !empty($arrnotice[1])) { ?>
                <input type="hidden" name="path_notice" value="<?php echo $arrnotice[1]; ?>">
              <?php } ?>
                <label class="label-wrc">Sistem Notice Nonaktif</label>
            <?php } ?>
            
        </td>
        </tr>
      </table>

      <table>
        <tr>
          <td style="width: 150px;"><label class="label-wrc">Akses Izin Pemohon</label></td>
          <td style="width: 100px;"><input type="radio" name="stat_akses" value="0" <?php if($stat_akses=="0") echo "$cek"; ?> />ON</td>
          <td style="width: 100px;"><input type="radio" name="stat_akses" value="1" <?php if($stat_akses=="1") echo "$cek"; ?> />OFF</td>
        </tr>
      </table>

      <table>
        <tr>
          <td style="width: 150px;"><label class="label-wrc">Bentuk Tanda Tangan Elektronik</label></td>
          <td style="width: 100px;"><input type="radio" name="tte_spesimen" value="1" <?php if($tte_spesimen=="1") echo "$cek"; ?> />ON</td>
          <td style="width: 100px;"><input type="radio" name="tte_spesimen" value="0" <?php if($tte_spesimen=="0") echo "$cek"; ?> />OFF</td>
        </tr>
      </table>
      -->      
      <br><br>
      <table>
        <tr>
          <td style="width: 150px;"></td>
          <td style="width: 250px;">
            <INPUT TYPE="submit" name="submit" class="submit-wrc" value="Kirim Token" > 
            <?php 
            echo form_button($cancel); echo form_close();
            ?>
          </td>
        </tr>
      </table>
    </div>
  </div>
  <br style="clear: both;" />
</div>