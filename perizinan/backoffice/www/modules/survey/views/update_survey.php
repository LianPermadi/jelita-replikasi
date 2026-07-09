<div id="content">
  <div class="post">
    <div class="title">
      <h2><?php echo $page_name; ?></h2>
    </div>
    <div class="entry">
      <fieldset id="half">
        <legend>Data Permohonan</legend>
        
        <div id="statusRail">
          <div id="leftRail" class="bg-grid">
            <?php
            echo form_label('No Pendaftaran','no_daftar');
            ?>
          </div>
          <div id="rightRail" class="bg-grid">
            <?php
            echo $no_daftar;
            ?>
          </div>
        </div>
        
        <div id="statusRail">
          <div id="leftRail">
            <?php
            echo form_label('Tanggal Permohonan','tgl_prmohonan');
            ?>
          </div>
          <div id="rightRail">
            <?php
            echo $this->lib_date->mysql_to_human($tgl_permohonan);
            ?>
          </div>
        </div>
        <form id="uploadS" method="POST" enctype="multipart/form-data" action="<?=site_url('survey/uploadSaran1')?>"></form>         
        <div id="statusRail">
          <div id="leftRail" class="bg-grid">
            <?php
            echo form_label('Nama Pemohon','nama_pemohon');
            ?>
          </div>
          <div id="rightRail" class="bg-grid">
            <?php
            echo $nama_pemohon;
            ?>
          </div>
        </div>
                
        <div id="statusRail">
          <div id="leftRail">
            <?php
            echo form_label('Alamat','alamat');
            ?>
          </div>
          <div id="rightRail">
            <?php
            echo $alamat_pemohon;
            ?>
          </div>
        </div>
                
        <div id="statusRail">
          <div id="leftRail" class="bg-grid">
            <?php
            echo form_label('Jenis Izin','jenis_izin');
            ?>
          </div>
          <div id="rightRail" class="bg-grid">
            <?php
            echo $jenis_izin;
            ?>
          </div>
        </div>
                
        <div id="statusRail">
          <div id="leftRail">
            <?php
            echo form_label('Lokasi Izin');
            ?>
          </div>
          <div id="rightRail">
            <?php
            echo $permohonan->a_izin;
            ?>
          </div>
        </div>
      </fieldset>
    </div>
    <?php
    //echo $save_method;
    echo form_open('survey/' . $save_method);
    echo form_hidden('id_daftar', $id_daftar);
    echo form_hidden('id_izin', $id_izin);
    echo form_hidden('waktu_awal', $waktu_awal);
    if(isset($from)) {
      echo form_hidden('from', $from);
    }
    ?>
    <div class="entry">
      <div id="tabs">
        <ul>
          <li><a href="#tabs-1">Data Entry</a></li>
          <?php 
          if($online==1 && $username_portal != ''){ 
            ?>
            <li><a href="#tabs-2">Data Persyaratan</a></li>
            <?php
          }
          $izin_kelompok = $permohonan->trperizinan->trkelompok_perizinan->get();
          if($izin_kelompok->id == '1' || $izin_kelompok->id == '3'){
            ?>
            <li><a href="#tabs-3">Data Surat Rekomendasi</a></li>
            <?php
          }
          ?>
          <li><a href="#tabs-4">Penangguhan Permohonan</a></li>
          <!-- <li><a href="#tabs-5">Data Pertimbangan Teknis</a></li>  -->
          <li><a href="#tabs-6">Data Investasi</a></li>
          <script type="text/javascript">
            $(function(){
              $("#tabs-5").hide();
            })
          </script> 
        </ul>
      
        <div id="tabs-1">
          <table cellpadding="0" cellspacing="0" border="0" class="display">
            <tr>
              <td align="left" width="4%"></td>
              <td align="left" width="20%"></td>
              <td align="left" width="75%"></td>
            </tr>
            <?php
            $jml_property = $this->lib_date->data_property($id_izin,'1');
            if($jml_property == '0') {
              echo "Property Belum Diseting";
              $stat_property = FALSE;
            }else{
              $i = 1;
              $stat_property = TRUE;
              $text = $this->lib_date->data_property($id_izin,'2');
              if($jml_property > '1') {
                $text = $this->lib_date->sort_property($id_izin, $text);
              }
              $list1 = explode (",",$text);
              foreach ($list1 as $data) {
                $nm_var = 'vdt_teknis'.$this->lib_date->array_property('0',$data);
                $property_aktif = $this->lib_date->array_property('11',$data);   // Aktifasi Property
                $data_property = $this->lib_date->isi_property($id_daftar, $this->lib_date->array_property('0',$data), '1');
                $hitung = strlen($data_property);
                $cek_posisi = strpos($data_property,'^'); 
                $cek_data = substr($data_property,$cek_posisi+1,$hitung);
                if($i%2 == 0) $bg = ""; else $bg = "class='bg-grid'";
                if($property_aktif == 'Ya') {
                  echo "<tr>";
                  echo "<td align='left' width='4%'".$bg."><b>".$i.' . '."</b></td>"."";   // Nomor Property
                  echo "<td align='left' width='10%'".$bg."><b>".$this->lib_date->array_property('1',$data)."</b></td>"."";   // Nama Property
                  if($cek_data == '-')
                    $data_property = substr($data_property,0,$cek_posisi);
                  else
                    if($online == 1)
                      $data_property = substr($data_property,$cek_posisi,$hitung);
                    else  
                      $data_property = substr($data_property,$cek_posisi+1,$hitung);
                }else{
                  $data_property = substr($data_property,$cek_posisi+1,$hitung);
                }
                $data_property = str_replace('^','',$data_property);
                $property_type = $this->lib_date->array_property('9',$data);     // Type Property
                if($property_type == 'ComboBox'){
                  // Create PBS
                  $val_combo = $this->lib_date->array_property('10',$data);    // Isi Pilihan ComboBox
                  if($val_combo){
                    $hitung = strlen($val_combo);
                    $cek_posisi = strpos($val_combo,';');
                    $a = 1;
                    while ($a < 50) {
                      $item_combo = substr($val_combo,0,$cek_posisi);
                      $val_combo = substr($val_combo,$cek_posisi+1,$hitung);
                      $hitung = strlen($val_combo);
                      $cek_posisi = strpos($val_combo,';');
                      if($a == 1) {
                        $opsi_koefisien = array($item_combo => $item_combo);
                      }else{
                        $tempArray = array( $item_combo => $item_combo);
                        $opsi_koefisien = array_merge ($opsi_koefisien, $tempArray);
                      }
                      if($cek_posisi == "") {
                        $a = $a + 1;
                        $tempArray = array( $val_combo => $val_combo);
                        $opsi_koefisien = array_merge ($opsi_koefisien, $tempArray);
                        $a = 51;
                      }
                      $a = $a + 1;
                    }
                  }
                  if($property_aktif == 'Ya') {
                    if($kyStafOPD)
                      echo "<td width='20%'".$bg.">".form_dropdown($nm_var, $opsi_koefisien, $data_property, 'class =  "input-select-wrc"')."</td>";
                    else
                      echo "<td width='20%'".$bg.">".$data_property."</td>";
                  }
                  $opsi_koefisien = '';
                }

                if($property_type == 'Tanggal') {
                  $periode = array('name' => $nm_var,
                                   'style'=>'width:10%',
                                   'value' => $data_property,
                                   'class' => 'monbulan',
                                   'readOnly'=>TRUE,
                                  );
                  if($property_aktif == 'Ya') {
                    if($kyStafOPD)
                      echo "<td ".$bg.">".form_input($periode)."</td>"; 
                    else
                      echo "<td ".$bg.">".$data_property."</td>"; 
                  }
                }
                
                if($property_type == 'TextBox') {
                  $property_input = array('name' => $nm_var,
                                          'style'=>'width:100%',
                                          'value' => $data_property,
                                          'class' => 'input-wrc',
                                         );
                  if($property_aktif == 'Ya') {
                    if($kyStafOPD)
                      echo "<td ".$bg.">".form_input($property_input)."</td>";
                    else
                      echo "<td ".$bg.">".$data_property."</td>";
                  }
                }
                
                if($property_type == 'Integer') {
                  $cek_data = (int) $data_property;
                  $property_input = array('name' => $nm_var,
                                          'style'=>'width:10%',
                                          'value' => $data_property,
                                          'class' => 'input-wrc required digits',
                                         );
                  if($property_aktif == 'Ya') {
                    if($kyStafOPD)
                      echo "<td ".$bg.">".form_input($property_input).' Hanya diisi oleh angka. ( koma dengan . )'."</td>";
                    else
                      echo "<td ".$bg.">".$data_property."</td>";
                  }
                }

                if($property_type == 'Kapital') {
                  $property_input = array('name' => $nm_var,
                                          'style'=>'width:100%',
                                          'value' => $data_property,
                                          'class' => 'input-wrc',
                                          'onkeyup' => 'this.value = this.value.toUpperCase();'
                                         );
                  if($property_aktif == 'Ya') {
                    if($kyStafOPD)
                      echo "<td ".$bg.">".form_input($property_input)."</td>";
                    else
                      echo "<td ".$bg.">".$data_property."</td>";
                  }
                }
                                
                if($property_aktif == 'Ya') {
                  echo "<td width='80%'".$bg."><b></b></td>";
                  echo "</b></td>";
                  echo "</tr>";
                  $i++;
                }else{
                  echo form_hidden($nm_var, $data_property);
                }
              }
              if($i == '1') {
                $stat_property = FALSE;
                echo "Property Belum diseting";
              }
            }
            if($d_survey != '0000-00-00') { //jika online dan belum isi peninjauan lapangan
              if($kyStafOPD){
                ?>
                <tr>
                  <td></td>
                  <td><b>Upload File Saran</b></td>
                  <td>
                    <input required form="uploadS" accept="application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" type="file" class="input-wrc" name="saran">
                    <input form="uploadS" type="hidden" name="zzzz" value="<?=$id_daftar?>">
                    <input form="uploadS" type="submit" name="submittt" class="submit-wrc" value="Upload">
                    <?php 
                    $a = $this->db->query("SELECT saran_teknis,file_saran FROM tmpermohonan where id = $id_daftar")->row_array();
                    if($a['saran_teknis'] == ""){
                      ?>
                      Tidak ada file saran teknis yang diupload
                      <?php
                    }else{
                      ?>
                      &emsp;&emsp; [File Tersedia&emsp;
                      <a class="submit-wrc" href='<?=site_url("$a[file_saran]")?>' download="<?=$a['saran_teknis']?>"><?=$a['saran_teknis']?></a>
                      ]
                      <?php
                    }
                    ?>
                  </td>
                </tr>
                <?php 
              }
            }
            ?>
          </table>
        </div>
              
        <?php
        if($online==1 && $username_portal != ''){ 
          ?>
          <div id="tabs-2">
            <table cellpadding="0" cellspacing="0" border="1" class="display">
              <thead>
                <tr>
                  <th width="5%">No</th>
                  <th width="55%">Syarat</th>
                  <th width="10%">Berkas</th>
                  <th width="10%">Nomor Surat</th>
                  <th width="10%">Tanggal Surat</th>
                  <th width="10%">Masa Berlaku<br>Surat</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $no=1;
                $base_url = "../assets/userassets/pemohon/".$username_portal."/pengajuan/".$id_portal."/";
                foreach($persyaratan as $syarat){
                  ?>
                  <tr>
                    <td style="text-align:center"><?php echo $no; ?></td>
                    <td style="text-align:justify"><?php echo $syarat->v_syarat; ?></td>
                    <td style="text-align:center"><?php echo anchor($base_url.$syarat->id.".pdf", "Download",array("target"=>"_blank","style"=>"color:blue")); ?></td>
                    <td style="text-align:center"><?php echo ($syarat->tmpermohonan_id == $id_portal ? $syarat->nomor_surat : ''); ?></td>
                    <td style="text-align:center"><?php echo ($syarat->tmpermohonan_id == $id_portal ? $syarat->tanggal_surat : ''); ?></td>
                    <td style="text-align:center"><?php echo ($syarat->tmpermohonan_id == $id_portal ? $syarat->masa_berlaku_surat : ''); ?></td>
                  </tr>
                  <?php
                  $no++;
                } 
                ?>
              </tbody>
            </table>
          </div>
          <?php
        }
        if($izin_kelompok->id == '1' || $izin_kelompok->id == '3'){
          ?>
          <div id="tabs-3">
            <?php
            echo form_label('No Surat');
            $no_surat_input = array('name' => 'no_surat',
                                    'value' => $no_surat,
                                    'class' => 'input-wrc',
                                    'id' => 'no_surat'
                                   );
            echo form_input($no_surat_input);
            ?>
            
            <br style="clear: both;" />
            <?php
            echo form_label('Tanggal Surat');
            $tgl_surat_input = array('name' => 'tgl_surat',
                                     'value' => $tgl_surat,
                                     'class' => 'input-wrc',
                                     'id' => 'tgl_surat'
                                    );
            echo form_input($tgl_surat_input);
            ?>

            <br style="clear: both;" />
            <?php
            echo form_label('Deskripsi');
            $deskripsi_input = array('name' => 'deskripsi',
                                     'value' => $deskripsi,
                                     'class' => 'inputarea-wrc',
                                     'id' => 'deskripsi'
                                    );
            echo form_textarea($deskripsi_input);
            ?>
            <br style="clear: both;" />
          </div>
          <?php
        }
        ?>
          
        <!-- PBS CREATE -->
        <div id="tabs-4">
          <?php echo 'Dari hasil tinjauan lapangan yang telah dilakukan, ditemukan adanya beberapa kekurangan untuk segera dilengkapi oleh pemohonan, diantaranya :';?> 
          <fieldset id="half" style="width:500px"> 
            <?php //echo form_open('survey/resultUpdate');?>
            <div id="statusRail">
              <div id="leftRail" style="width:200px">
                <?php echo form_label('1.  ','kurang_1'); ?>
              </div>
              <div id="leftRail">
                <?php
                $k_1 = array('name'  => 'syarat1', 'value' => $syarat1, 'class' => 'input-wrc',);
                echo form_input($k_1);
                ?>
              </div>
            </div>

            <div id="statusRail">
              <div id="leftRail" style="width:200px">
                <?php echo form_label('2.  ','kurang_2'); ?>
              </div>
              <div id="leftRail">
                <?php
                $k_2 = array('name'  => 'syarat2', 'value' => $syarat2, 'class' => 'input-wrc',);
                echo form_input($k_2);
                ?>
              </div>
            </div>

            <div id="statusRail">
              <div id="leftRail" style="width:200px">
                <?php echo form_label('3.  ','kurang_3'); ?>
              </div>
              <div id="leftRail">
                  <?php
                  $k_3 = array('name'  => 'syarat3', 'value' => $syarat3, 'class' => 'input-wrc',);
                  echo form_input($k_3);
                  ?>
              </div>
            </div>

            <div id="statusRail">
              <div id="leftRail" style="width:200px">
                <?php echo form_label('4.  ','kurang_4'); ?>
              </div>
              <div id="leftRail">
                <?php
                $k_4 = array('name'  => 'syarat4', 'value' => $syarat4, 'class' => 'input-wrc',);
                echo form_input($k_4);
                ?>
              </div>
            </div>

            <div id="statusRail">
              <div id="leftRail" style="width:200px">
                <?php echo form_label('5.  ','kurang_5'); ?>
              </div>
              <div id="leftRail">
                <?php
                $k_5 = array('name'  => 'syarat5', 'value' => $syarat5, 'class' => 'input-wrc',);
                echo form_input($k_5);
                ?>
              </div>
            </div>
            <br/><br/>

            <div id="statusRail">
              <div id="leftRail">
                <?php echo form_label('Tgl Melengkapi :','kurang_5'); ?>
              </div>
              <div id="rightRail">
                <?php
                $tgl_s = array('name'  => 'tglsyarat', 'value' => $tglsyarat, 'class' => 'input-wrc', 'id' => 'tgl_surat',);
                echo form_input($tgl_s);
                ?>
              </div>
            </div>
          </fieldset>
        </div>
        <?php 
        $ddd = $this->db->query("SELECT *  FROM table_non_spipise where id_permohonan = $id_daftar")->row_array();
        if(count($ddd) > 0){
          $tenaga = "value = '$ddd[tenaga_kerja]'";
          $invest = "value = '$ddd[investasi]'";
        }else{
          $tenaga = '';
          $invest = '';
        }   
        ?>
        
        <div id="tabs-5">
          <table cellpadding="0" cellspacing="0" border="0" class="display">
            <tr>
              <td align="left" width="4%"></td>
              <td align="left" width="20%"></td>
              <td align="left" width="75%"></td>
            </tr>
            <tr>
              <td class="bg-grid">1.</td>
              <td class="bg-grid">Nomor</td>
              <td class="bg-grid"><input name="nomor_pertimbangan" type="text" class="input-wrc" style="width:100%" value="<?php echo $permohonan->nomor_pertimbangan; ?>"></td>
            </tr>
            <tr>
              <td >2.</td>
              <td >Tanggal</td>
              <td ><input type="text" name="tgl_pertimbangan" class="monbulan" style="width:10%" readOnly="True" value="<?php echo ($permohonan->tanggal_pertimbangan == null || $permohonan->tanggal_pertimbangan == "0000-00-00")?"0000-00-00":$permohonan->tanggal_pertimbangan ; ?>" required></td>
            </tr>
            <tr>
              <td class="bg-grid">3.</td>
              <td class="bg-grid">Perihal</td>
              <td class="bg-grid"><input type="text" name="perihal_pertimbangan" class="input-wrc" style="width:100%" value="<?php echo $permohonan->perihal; ?>"></td>
            </tr>
            <tr>
              <td >2.</td>
              <td >Bidang</td>
              <td ><input type="text" class="input-wrc" name="bidang_pertimbangan" style="width:100%" value="<?php echo $bidang; ?>" readOnly="True"></td>
            </tr>
          </table>
        </div>

        <div id="tabs-6">
          <table cellpadding="0" cellspacing="0" border="0" class="display">
            <tr>
              <td width="7%" class="bg-grid"><b>1.</b></td>
              <td width="15%"class="bg-grid"><b>
                Penyerapan Tenaga Kerja</b><br>
                <small>Input hanya angka</small>
              </td>
              <td class="bg-grid"><input type="text" name="tenaga" <?php echo $tenaga;?>  pattern="[0-9]+" class="input-wrc"> (Jiwa)</td>
            </tr>
            <tr>
              <td width="7%" ><b>2.</b></td>
              <td width="15%"><b>
                Nilai Investasi</b><br>
                <small>Input hanya angka</small>
              </td>
              <td><input type="text" name="invest" <?php echo $invest;?> pattern="[0-9]+" class="input-wrc"> (Rp)</td>
            </tr>
            <tr>
              <input type="hidden" value="<?php echo $kabupaten_id;?>" name="idkab" class="input-wrc">
              <input type="hidden" value="<?php echo $permohonan_id;?>" name="idpermo" class="input-wrc">
              <input type="hidden" value="<?php echo $perizinan_id;?>" name="idizin" class="input-wrc">
            </tr>
          </table>
        </div>
        <!-- EOF PBS CREATE -->
      </div>
    </div>
    <div class="entry" style="text-align: center;">
      <?php
      $add_daftar = array('name' => 'submit',
                          'class' => 'submit-wrc',
                          'content' => 'Simpan',
                          'type' => 'submit',
                          'value' => 'Simpan'
                         );
      $textbatal = 'Kembali';
      if($stat_property && $d_survey != '0000-00-00'){ 
        if($kyStafOPD){
          echo form_submit($add_daftar); 
          $textbatal = 'Batal';
        }
      }
      echo "<span></span>";
      $cancel_daftar = array('name' => 'button',
                             'class' => 'button-wrc',
                             'content' => $textbatal,
                             'onclick' => 'parent.location=\''. site_url('survey/result') . '\''
                            );
      echo form_button($cancel_daftar);
      echo "<span></span>";
      echo form_close();
      ?>
    </div>
  </div>
  <?php if (!empty($id_portal)) { ?>
                  <hr>
            <center><h1>Revisi Persyaratan</h1></center>
            <center><small>Harap Mengirim Pesan Kepada Pemohon Jika Ada Berkas Persyaratan Yang "Kurang Lengkap"/"Belum Sesuai" Saja.</small></center>
            <hr>
            <?php 
                $alert = $this->session->flashdata("sukses");
                if(!empty($alert)){
              ?>
                <br>
                <div style="color: green; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;"><center><?php echo $alert; ?></center></div>
                <br>
              <?php } ?>

              <?php 
                $alert = $this->session->flashdata("gagal");
                if(!empty($alert)){
              ?>
                <br>
                <div style="color: red; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;"><center><?php echo $alert; ?></center></div>
                <br>
              <?php } ?>
            <!-- Asistensi Tim Teknis -->
            <div class="entry">
              <div class="dataTables_wrapper" id="pendaftaran_wrapper">
                <div class="fg-toolbar ui-widget-header ui-corner-tl ui-corner-tr ui-helper-clearfix">
                  <div id="pendaftaran_length" class="dataTables_length"></div>
                  <div id="pendaftaran_filter" class="dataTables_filter"></div>
                </div>
                
                <style>
                  .baru{
                    border-width:0px 1px;
                    border-color:rgb(170, 170, 170);
                    border-style:solid;
                    padding:20px 0px 20px 100px;
                  }
                </style>
                
                <div class="baru">
                  <div class="contentForm">
                    <?php echo form_open('survey/asistensi'); ?>
                    <input type="hidden" name="id_portal" value="<?php echo $id_portal; ?>">
                    <input type="hidden" name="id_kembali" value="<?php echo $id; ?>">
                    <input type="hidden" name="oleh" value="<?php echo $this->session_info['realname']; ?>">
                    <b>
                      <label style="font-size:18px;text-align:right;margin-right:10px;width:80px;margin-top:5px;">Alasan Revisi</label>
                    </b>
                    <?php
                    //if($ncek){ // khusus ! TimTeknis
                    ?>
                    <input type="text" class="input-area" style="height:40px;font-size:18px;width:70%" placeholder="Pesan Revisi Persyaratan Untuk Pemohon" name="pesan" required>
                    <input type="submit" class="submit-wrc" value="Kirim" style="margin-left:35px;padding:7px">
                    <?php
                    //}
                    echo form_close();
                    ?>
                  </div>
                </div>
                <table cellpadding="0" cellspacing="0" border="1" class="display" id="pendaftaran" style="font-size:12px">
                  <thead>
                    <tr>
                      <th width="65%" class="ui-state-default" style="width: 65%;"><span class="css_right ui-icon ui-icon-carat-2-n-s"></span>Pesan</th>
                      <th width="10%" class="ui-state-default" style="width: 10%;"><span class="css_right ui-icon ui-icon-carat-2-n-s"></span>Tanggal</th>
                      <th width="5%" class="ui-state-default" style="width: 5%;"><span class="css_right ui-icon ui-icon-carat-2-n-s"></span>Pukul</th>
                      <th width="20%" class="ui-state-default" style="width: 20%;"><span class="css_right ui-icon ui-icon-carat-2-n-s"></span>Oleh</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $sho0 = 0; $sho = 0;
                    if (!empty($asistensi)) {
                    foreach($asistensi as $asisten){
                      $sho0 = 1; $sho++;
                      $oleh='Verifikatur';
                      //if($ncek) $oleh = str_replace('*', '', $asisten->oleh);
                      $oleh = str_replace('*', '', $asisten->oleh);
                      ?>
                      <tr class="odd">
                        <td valign="top"><?php echo $asisten->pesan; ?></td>
                        <td valign="top"><?php echo $this->lib_date->mysql_to_human($asisten->tanggal); ?></td>
                        <td valign="top"><?php echo date("H:i:s",strtotime($asisten->tanggal)); ?></td>
                        <td valign="top"><?php echo $oleh; ?></td>
                      </tr>
                      <?php 
                      } 
                    }
                    ?>
                  </tbody>
                </table>
                <div class="fg-toolbar ui-widget-header ui-corner-bl ui-corner-br ui-helper-clearfix">
                  <div class="dataTables_info" id="pendaftaran_info"> <?php echo 'Showing '.$sho0.' to '.$sho.' of '.$sho.' entries' ?></div>
                  <div class="dataTables_paginate fg-buttonset fg-buttonset-multi paging_full_numbers" id="pendaftaran_paginate"></div>
                </div>
              </div>
    </div>
    <div class="entry" style="text-align: right;">
    <?php
      if ($editable == 1) {
        $revisi = array('name' => 'button',
                      'class' => 'button-wrc',
                      'style' => "background: #00cc00;",
                      'content' => 'Kirim Notifikasi Ke Pemohon',
                      'onclick' => "if (confirm('Kirim Notifikasi Ke Pemohon?')) parent.location='" . site_url('survey/revisi/'.$id_portal. "/" .$id) . "'"
                     );
      } else {
        $revisi = array('name' => 'button',
                      'class' => 'button-wrc',
                      'content' => 'Kirim Notifikasi Ke Pemohon',
                      'onclick' => "if (confirm('Kirim Notifikasi Ke Pemohon?')) parent.location='" . site_url('survey/revisi/'.$id_portal. "/" .$id) . "'"
                     );
      }
      //if($ncek){ // khusus ! TimTeknis
      echo form_button($revisi);
      //}
      ?>
    </div>
      <div class="entry" style="text-align: right;">
    *Informasi Tombol :<br>
    <p style="color: #0054A5;">Biru - Tidak ada informasi revisi di pemohon / Informasi revisi belum dikirim ke pemohon</p>
    <p style="color: #00cc00;">Hijau - Ada revisi di pemohon / Informasi revisi sudah dikirim ke pemohon</p>
    </div>
  <?php } ?>
            
  <br style="clear: both;" />
</div>
