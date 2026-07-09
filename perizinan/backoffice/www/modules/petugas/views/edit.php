<script>
  function ceksumber(sumber) {
    if(sumber=='PASSPORT') {
      $("input[name=no_refer]").attr("class", 'input-wrc required');
    }else{
      $("input[name=no_refer]").attr("class", 'input-wrc required digits');
    }
  }
</script>

<div id="content">
  <div class="post">
    <div class="title">
      <h2><?php echo $page_name; ?></h2>
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
      <div id="tabs">
        <ul>
          <li><a href="#tabs-1">Data Pegawai</a></li>
          <?php if($save_method != 'save') { ?>
            <li><a href="#tabs-2">List Kabupaten</a></li>
          <?php } ?>
          
        </ul>
        <div id="tabs-1">
          <div id="contentleft">
            
            <?php
            $cek = "checked";
            $attr = array('id' => 'form');
            echo form_open('petugas/' . $save_method, $attr);
            echo form_hidden('id', $id);
            ?>

            <div class="contentForm">
          <table>
            <tr width="100%">
              <td width="50%">
              aaaa
              </td>
              <td width="50%">
                aaaa
              </td>
            </tr>
          </table>
              <label class="label-wrc">NIK</label>
              <?php
              $nik_input = array('name' => 'nik',
                                 'value' => $nik,
                                 'class' => 'input-wrc');
              echo form_input($nik_input);
              ?>
            </div>

            <?php if ($status_sign != "") { ?>
              <div class="contentForm">
              <label class="label-wrc">&nbsp;</label>
              <?php
              echo "<p class='wrc'>".$status_sign."</p><br>";
              ?>
            </div>
            <?php } ?>

            <div class="contentForm">
              <label class="label-wrc">Nama Pegawai</label>
              <?php
              $n_petugas_input = array('name' => 'n_pegawai',
                                       'value' => $n_pegawai,
                                       'class' => 'input-wrc required');
              echo form_input($n_petugas_input);
              ?>
            </div>
                        
            <div class="contentForm">
              <label class="label-wrc">NIP</label>
              <?php
              $nip_input = array('name' => 'nip',
                                 'value' => $nip,
                                 'class' => 'input-wrc required');
              echo form_input($nip_input);
              ?>
            </div>
                        
            <div class="contentForm">
              <label class="label-wrc">Jabatan</label>
              <?php
              $n_jabatan_input = array('name' => 'n_jabatan',
                                       'value' => $n_jabatan,
                                       'class' => 'input-wrc required');
              echo form_input($n_jabatan_input);
              ?>
            </div>

            <div class="contentForm">
              <label class="label-wrc">TMT Jabat</label>
              <?php
              $vtmt_jabat = array('name'  => 'tmt_jabat',
                                   'value' => $tmt_jabat,
                                   'class' => 'input-wrc',
                                   'readOnly'=>TRUE,
                                   'id' => 'inputTanggal1'
                                  );
              echo form_input($vtmt_jabat);
              ?>
            </div>

            <div class="contentForm">
              <label class="label-wrc">TMT Pensiun</label>
              <?php
              $vtmt_pensiun = array('name'  => 'tmt_pensiun',
                                   'value' => $tmt_pensiun,
                                   'class' => 'input-wrc',
                                   'readOnly'=>TRUE,
                                   'id' => 'inputTanggal2'
                                  );
              echo form_input($vtmt_pensiun);
              ?>
            </div>
            
            <div class="contentForm">
              <label class="label-wrc">Eselon</label>
              <?php
              $eseloning = array(''  => '-- pilih salah satu --',
                                 '1' => 'Eselon I',
                                 '2' => 'Eselon II',
                                 '5' => 'Sekdis',
                                 '3' => 'Eselon III',
                                 '4' => 'Eselon IV',
                                 '9' => 'Pelaksana');
              echo form_dropdown('eselon',$eseloning,$eselon,'class = "input-select-wrc" id="eselon"  onChange=" ceksumber(this.value);return false;"');
              ?>
            </div>
                        
            <div class="contentForm">
              <label class="label-wrc">Pangkat</label>
              <?php
              $pangkat = array(''     => '-- pilih salah satu --',
                               'IVe'  => 'Pembina Utama (IVe)',
                               'IVd'  => 'Pembina Utama Madya (IVd)',
                               'IVc'  => 'Pembina Utama Muda (IVc)',
                               'IVb'  => 'Pembina Tingkat I (IVb)',
                               'IVa'  => 'Pembina (IVa)',
                               'IIId' => 'Penata Tingkat I (IIId)',
                               'IIIc' => 'Penata (IIIc)',
                               'IIIb' => 'Penata Muda Tingkat I (IIIb)',
                               'IIIa' => 'Penata Muda (IIIa)',
                               'IId'  => 'Pengatur Tingkat I (IId)',
                               'IIc'  => 'Pengatur (IIc)',
                               'IIb'  => 'Pengatur Muda Tingkat I (IIb)',
                               'IIa'  => 'Pengatur Muda (IIa)',
                               'Id'   => 'Juru Tingkat I (Id)',
                               'Ic'   => 'Juru (Ic)',
                               'Ib'   => 'Juru Muda Tingkat I (Ib)',
                               'Ia'   => 'Juru Muda (Ia)',
                               'HL'  => 'Tenaga Kontrak');
              echo form_dropdown('pangkat_gol',$pangkat,$pangkat_gol,'class = "input-select-wrc" id="pangkat_gol"  onChange=" ceksumber(this.value);return false;"');
              ?>
            </div>
            
            <div class="contentForm">
              <label class="label-wrc">Satuan Kerja</label>
              <select name="unitkerja" class="input-select-wrc">
                <?php
                $selected = NULL;
                foreach($unit_kerja as $unit_kerja_data) {
                  if($unit_kerja_data->id === $unit_kerja_id) {
                    $selected = ' selected="selected" ';
                  }else{
                    $selected = 'ok';
                  }
                  
                  echo "<option value=\"" . $unit_kerja_data->id . "\"" . $selected . ">"
                       . $unit_kerja_data->n_unitkerja . "</option>\n";
                }
                ?>
              </select>
            </div>
            
            <div class="contentForm">
              <label class="label-wrc">Penandatangan SK</label>
              <input type="radio" name="ststtd" value="1" <?php if($status_cont=="1") echo "checked"; ?>/>Ya
              <input type="radio" name="ststtd" value="0" <?php if($status_cont=="0") echo "checked"; ?>/>Tidak
            </div>
            <br style="clear: both;"/>
            
            <div class="contentForm">
              <label class="label-wrc">Penandatangan Nota</label>
              <input type="radio" name="ststtd" value="2" <?php if($status_cont=="2") echo "checked"; ?>/>Ya
              <input type="radio" name="ststtd" value="0" <?php if($status_cont!="2" && $status_cont!="1") echo "checked"; ?>/>Tidak
            </div>
            <br style="clear: both;"/>

            <div class="contentForm">
              <label class="label-wrc">Penandatangan Surat</label>
              <input type="radio" name="stssrt" value="1" <?php echo ($status_cont4 == "1" ? "checked" : ""); ?> />Ya
              <input type="radio" name="stssrt" value="0" <?php echo ($status_cont4 == "0" ? "checked" : ""); ?> />Tidak
            </div>
            <br style="clear: both;"/>
                
            <div class="contentForm">
              <label class="label-wrc">Penandatangan Penolakan</label>
              <input type="radio" name="ttdpenolakan" value="1" <?php if($status_cont2=="1") echo "checked"; ?>/>Ya
              <input type="radio" name="ttdpenolakan" value="0" <?php if($status_cont2=="0") echo "checked"; ?>/>Tidak
            </div>
            <br style="clear: both;"/>
            
            <div class="contentForm">
              <label class="label-wrc">Penandatangan Sartek (OPD Teknis)</label>
              <input type="radio" name="ttdsartek" value="1" <?php if($status_cont3=="1") echo "checked"; ?>/>Ya
              <input type="radio" name="ttdsartek" value="0" <?php if($status_cont3=="0") echo "checked"; ?>/>Tidak
            </div>
            <br style="clear: both;"/>
                            
            <div class="contentForm">
              <label class="label-wrc">Alamat E-Mail</label>
              <?php
              $n_email_input = array('name' => 'e_mail',
                                     'value' => $e_mail,
                                     'class' => 'input-wrc');
              echo form_input($n_email_input);
              ?>
            </div>

            <?php
            if($status_cont=="1" || $status_cont=="2" || $status_cont2=="1" || $status_cont3=="1" || $status_cont4 == "1"){
              ?>
              <br style="clear: both;"/>
              <div class="contentForm">
                <label class="label-wrc">Upload File SE BSrE (.P12)</label>
                <?php
                $post_SE = str_replace(' ', '', $nip);
                if($nm_file_SE == ''){
                  echo anchor(site_url('petugas/showformSE/'.$post_SE), 'Upload File', 'class="link-wrc" rel="upload_box"')."&nbsp;";
                }else{
                  echo $nm_file_SE .' '. anchor(site_url('petugas/showformSE/'.$post_SE), 'Perbaiki File SE', 'class="link-wrc" rel="upload_box"')."&nbsp;";
                }
                ?>
              </div>
              <br style="clear: both;"/>
              <br style="clear: both;"/>
              <div class="contentForm">
                <label class="label-wrc">Upload File ttd (.PNG 500x250 px)</label>
                <?php
                $post_nip = str_replace(' ', '', $nip);
                if($nm_file == ''){
                  echo anchor(site_url('petugas/showform/'.$post_nip), 'Upload File', 'class="link-wrc" rel="upload_box"')."&nbsp;";
                }else{
                  echo $nm_file .' '. anchor(site_url('petugas/showform/'.$post_nip), 'Perbaiki File Ttd', 'class="link-wrc" rel="upload_box"')."&nbsp;";
                }
                ?>
              </div>
              <br style="clear: both;"/>
              <div class="contentForm">
                <label class="label-wrc">Bentuk File ttd</label>
                <?php
                $img_edit = array('src' => 'uploads/logo/'.$nm_file,
                                  'height' => '20%',
                                  'width' => '20%',
                                  'border' => '0');
                echo img($img_edit);               
                ?>
              </div>
              <?php
            }
            ?>
            <div class="contentForm">
            <label class="label-wrc">&nbsp;</label>
            <?php
            $add_petugas = array('name' => 'submit',
                                 'class' => 'submit-wrc',
                                 'content' => 'Simpan',
                                 'type' => 'submit',
                                 'value' => 'Simpan');
            echo form_submit($add_petugas);
            
            echo "<span></span>";
            $cancel_petugas = array('name' => 'button',
                                    'class' => 'button-wrc',
                                    'content' => 'Batal',
                                    'onclick' => 'parent.location=\'' . site_url('petugas') . '\'');
            echo form_button($cancel_petugas);
            echo form_close();
            ?>
            </div>
            <br>
            <br>
            <br>
            <br>
            <br>
              <div class="contentForm">
                <?php
                $post_nip = str_replace(' ', '', $nip);
                // Assuming you want to check for the existence of a file in a specific directory
                $file_path = FCPATH . 'uploads/qrcode/' . $post_nip . '.png';
                ?>
                <label class="label-wrc">Create File ttd QRCode</label>
                <?php

                if (file_exists($file_path)) {
                  ?>
                  <a href="/spekta/backoffice/petugas/create_qr_code/<?php echo $id; ?>"> <button class='button-wrc'>Generate QRCode</button></a><br>
                  
                  <label class="label-wrc">Ttd QRCode</label>
                  <?php 
                    // The file exists, you can proceed with further actions
                    // For example, you can display the file, delete it, or perform any other actions.
                    echo "<img src='https://spekta.tasikmalayakab.go.id/spekta/backoffice/uploads/qrcode/".$post_nip.".png' height='20%' width='20%'>";
                } else {
                    // The file does not exist, you can handle this case accordingly
                    ?>
                  <a href="/spekta/backoffice/petugas/create_qr_code/<?php echo $id; ?>"> <button class='button-wrc'>Generate QRCode</button></a><br>
                    <?php
                    echo "File does not exist!";
                }
                ?>
              </div>
          </div>
          <br/>
          <br style="clear: both;" />
          <!-- <div class="entry">
          
        </div> -->
        </div>

        <?php if($save_method != 'save') { ?>
        <div id="tabs-2">
          <?php
            echo form_open(site_url('petugas/kabupaten'));
            echo form_hidden('id', $id);
            $set_all = array('name' => 'cek_all',
                             'value' => 'yes',
                             'checked' => 'TRUE'
                            );
            echo form_submit('button','Tambah Kabupaten','class="button-wrc"');
            //echo form_checkbox($set_all)."&nbsp;Cek Semua Izin&nbsp;";
            echo form_close();
            ?>
            <br />
            
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="peran_list">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Kabupaten</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $i = 0;

                if (!empty($list_kab)) {
                 foreach ($list_kab as $kab) {
                  $tampil = FALSE;
                  if (in_array($kab->id, $kabupaten)) {
                    $tampil = TRUE;
                    $i++;
                  }

                  if ($tampil) {
                ?>
                  <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $kab->n_kabupaten; ?></td>
                    <td>
                      <center>
                        <?php
                        $img_delete = array('src' => 'assets/images/icon/cross.png',
                                            'alt' => 'Delete',
                                            'title' => 'Delete',
                                            'border' => '0'
                                           );
                        echo "<a href='". site_url('petugas/deletekab') .'/'. $id .'/'. $kab->id."' onClick='return confirm(\"Apakah Anda yakin akan menghapusnya?\");'>".img($img_delete)."</a>";
                        ?>
                      </center>
                    </td>
                  </tr>
                  <?php
                    }
                   }
                  }
                  ?>
              </tbody>
              <tfoot>
                <tr>
                  <th>No</th>
                  <th>Nama Kabupaten</th>
                  <th>Aksi</th>
                </tr>
              </tfoot>
            </table>
        </div>
      <?php } ?>
      </div>
    </div>
    
  </div>
  <br style="clear: both;" />
</div>