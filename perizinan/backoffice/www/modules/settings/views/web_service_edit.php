<div id="content">
  <div class="post">
    <div class="title">
      <h2><?php echo $page_name; ?></h2>
    </div>
    <script>
      function cekNilai() {
        var nilai = document.form.online[0].checked;
        var nilai2 = document.form.online2[0].checked;
        if(nilai == true) {
          if(document.getElementById('service').value=='') {
            document.getElementById('service').focus();
            alert('Isi Alamat web service Pajak');
            return false;
          }
        }
        if(nilai2 == true) {
          if(document.getElementById('penduduk').value=='') {
            document.getElementById('penduduk').focus();
            alert('Isi Alamat web service Penduduk');
            return false;
          }
        }
        return true;
      }
    </script>
    
    <div class="entry">
      <?php
      $cek = "checked";
      $attr = array('id' => 'form','name'=>'form','onSubmit'=>'return cekNilai();');
      echo form_open('settings/webservice/' . $save_method, $attr);
      $service_input = array('name' => 'service',
                             'value' => $service,
                             'class' => 'input-wrc required',
                             'id' => 'service'
                            );
      $service_input2 = array('name' => 'penduduk',
                              'value' => $service2,
                              'class' => 'input-wrc required',
                              'id' => 'penduduk'
                             );
      $service_input3 = array('name' => 'bkpm',
                              'value' => $service3,
                              'class' => 'input-wrc required',
                              'id' => 'bkpm'
                             );
      $cancel = array('name' => 'button',
                      'class' => 'button-wrc',
                      'content' => 'Batal',
                      'onclick' => 'parent.location=\'' . site_url('') . '\''
                     );
      $piksel_input = array('name' => 'piksel',
                            'value' => $piksel,
                            'class' => 'input-wrc required',
                            'id' => 'piksel'
                           );
      ?>
      <table>
        <tr>
          <td><label class="label-wrc">Web Service Pajak</label></td>
          <td><?php echo form_input($service_input); ?></td>
          <td width="120"></td>
          <td> <label  class="label-wrc">Status :</label> </td>
          <td><input type="radio" name="online" id="online" value="1" <?php if($status=="1") echo "$cek"; ?> />Online</td>
          <td><input type="radio" name="online" id="online" value="0" <?php if($status=="0") echo "$cek"; ?> />Offline</td>
        </tr>
      </table>
      
      <table>
        <tr>
          <td><label class="label-wrc">Web Service Kependudukan</label></td>
          <td><?php echo form_input($service_input2); ?></td>
          <td width="120"></td>
          <td> <label  class="label-wrc">Status :</label> </td>
          <td><input type="radio" name="online2"  id="online2" value="1" <?php if($status2=="1") echo "$cek"; ?> />Online</td>
          <td><input type="radio" name="online2"  id="online2" value="0" <?php if($status2=="0") echo "$cek"; ?> />Offline</td>
        </tr>
      </table>
      
      <table>
        <tr>
          <td><label class="label-wrc">Web Service BKPM</label></td>
          <!--<td><?php echo form_input($service_input3); ?></td>
          		<td width="120"></td>
          		<td> <label  class="label-wrc">Status :</label> </td>
              <td><input type="radio" name="online3"  id="online3" value="1" <?php if($status3=="1") echo "$cek"; ?> />Online</td>
              <td><input type="radio" name="online3"  id="online3" value="0" <?php if($status3=="0") echo "$cek"; ?> />Offline</td>
          -->
        </tr>
      </table>
      
      <table>
        <tr>
          <td><label class="label-wrc">Send SMS</label></td>
          <td><input type="radio" name="smsgateway"  id="smsgateway" value="1" <?php if($statsms=="1") echo "$cek"; ?> />ON</td>
          <td><input type="radio" name="smsgateway"  id="smsgateway" value="0" <?php if($statsms=="0") echo "$cek"; ?> />OFF</td>
          <td width="120"></td>
          <td><input type="checkbox" name="cek_sms" value="1">Cek Pengiriman SMS<br/></td>
        </tr>
      </table>
      
      <table>
        <tr>
          <td><label class="label-wrc">Send Mail</label></td>
          <td><input type="radio" name="send_mail"  id="send_mail" value="1" <?php if($statmail=="1") echo "$cek"; ?> />ON</td>
          <td><input type="radio" name="send_mail"  id="send_mail" value="0" <?php if($statmail=="0") echo "$cek"; ?> />OFF</td>
          <td width="120"></td>
          <td><input type="checkbox" name="cek_mail" value="1">Cek Pengiriman e-Mail<br/></td>
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
          <td><label class="label-wrc">Approve SK (Pergantian Esl II)</label></td>
          <td><input type="radio" name="stop_esl2"  id="stop_esl2" value="1" <?php if($stat_stop_esl2=="1") echo "$cek"; ?> />ON</td>
          <td><input type="radio" name="stop_esl2"  id="stop_esl2" value="0" <?php if($stat_stop_esl2=="0") echo "$cek"; ?> />OFF</td>
        </tr>
      </table>
      
      <table>
        <tr>
          <td><label class="label-wrc">Approve Permohonan Sartek (Pergantian Esl III)</label></td>
          <td><input type="radio" name="stop_esl3"  id="stop_esl3" value="1" <?php if($stat_stop_esl3=="1") echo "$cek"; ?> />ON</td>
          <td><input type="radio" name="stop_esl3"  id="stop_esl3" value="0" <?php if($stat_stop_esl3=="0") echo "$cek"; ?> />OFF</td>
        </tr>
      </table>
      
      <table>
        <tr>
          <td><label class="label-wrc">Penomoran Pertimbangan Teknis</label></td>
          <td><input type="radio" name="no_pertek"  id="no_pertek" value="1" <?php if($stat_nopertek=="1") echo "$cek"; ?> />System</td>
          <td><input type="radio" name="no_pertek"  id="no_pertek" value="0" <?php if($stat_nopertek=="0") echo "$cek"; ?> />Manual</td>
        </tr>
      </table>
      
      <table>
        <tr>
          <td><label class="label-wrc">Penomoran Surat Penolakan</label></td>
          <td><input type="radio" name="no_srt_tolak"  id="no_srt_tolak" value="1" <?php if($stat_nostolak=="1") echo "$cek"; ?> />System</td>
          <td><input type="radio" name="no_srt_tolak"  id="no_srt_tolak" value="0" <?php if($stat_nostolak=="0") echo "$cek"; ?> />Manual</td>
        </tr>
      </table>
            
      <br><br>
      <INPUT TYPE="submit" name="submit" class="submit-wrc" value="Simpan" > 
      <?php 
      echo form_button($cancel); echo form_close();
      ?>
    </div>
  </div>
  <br style="clear: both;" />
</div>