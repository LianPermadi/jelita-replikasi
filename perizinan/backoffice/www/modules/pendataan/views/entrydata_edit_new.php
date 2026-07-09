<style>
  <!--
    #formData {
    font-family: verdana;
    width: auto;
  }
  --> 
</style>

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
    
    echo form_open('pendataan/' . $save_method.'/'.$tgla.'/'.$tglb);
    echo form_hidden('id_daftar', $id_daftar);
    echo form_hidden('waktu_awal', $waktu_awal);
    echo form_hidden('id_izin', $id_izin);
    ?>
    <div class="entry">
      <div id="tabs">
        <ul>
          <li><a href="#tabs-1">Data Entry</a></li>
          <?php
          if($online==1 && $username_portal != ''){ ?>
          	<li><a href="#tabs-2">Data Persyaratan</a></li>
          <?php	} ?>
          <li><a href="#tabs-3">Data Investasi</a></li>
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
              $nomor_array = 0;
              $stat_property = TRUE;
              $text = $this->lib_date->data_property($id_izin,'2');
              if($jml_property > 1) {
                $text = $this->lib_date->sort_property($id_izin, $text);
              }
              $list = explode (",",$text);
              foreach ($list as $data) {
      	        $no_var = $this->lib_date->array_property('0',$data);          // Nomer Variabel
                $nm_var = 'vdt_teknis'.$no_var;                                // Nama Variabel
                $property_aktif = $this->lib_date->array_property('11',$data); // Aktifasi Property
                $cbt = $this->lib_date->array_property('7',$data); // Aktifasi Property
                if($i%2 == 0) $bg = ""; else $bg = "class='bg-grid'";
                if($property_aktif == 'Ya' && $cbt != 'Ya') {
                  echo "<tr>";
                  echo "<td align='left' width='4%'".$bg."><b>".$i.' . '."</b></td>"."";   // Nomor Property
                  echo "<td align='left' width='10%'".$bg."><b>".$this->lib_date->array_property('1',$data)."</b></td>"."";   // Nama Property
                }
      	        $xdata = $this->lib_date->isi_property($id_daftar, $this->lib_date->array_property('0',$data), '4');     //4 ambil data akhir
      	        if($xdata == ''){
      	          $xdata = $this->lib_date->isi_property($id_daftar, $this->lib_date->array_property('0',$data), '3'); //4 ambil data akhir
      	        }
                $data_property = $this->lib_date->isi_property($id_daftar, $this->lib_date->array_property('0',$data), '1');
                $hitung = strlen($data_property);
                $cek_posisi = strpos($data_property,'^'); 
                $data_property = substr($data_property,0,$cek_posisi);
                
                $property_type = $this->lib_date->array_property('9',$data);     // Type Property
                
                ///////////  edit iqbal
                $value=null;
                if(!empty($array_properti[$no_var-1])){    //$nomor_array
                  $value=$array_properti[$no_var-1];     //$nomor_array
                }
                ///////////  edit iqbal
                
                //if($property_aktif == 'Ya') {
                $nomor_array++;
                //}
                
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
                  if($property_aktif == 'Ya'  && $cbt != 'Ya') {
                    if($look)
                      echo "<td width='20%'".$bg.">". $xdata . "</td>";
                    else
                      echo "<td width='20%'".$bg.">".form_dropdown($nm_var, $opsi_koefisien, $value, 'class =  "input-select-wrc"')."</td>";
                  } 
                  $opsi_koefisien = '';
                }
                  
                if($property_type == 'Tanggal') {
                  if($value == '') $value = $this->lib_date->get_date_now();
                  $periode = array('name' => $nm_var,
                                   'style'=>'width:10%',
                                   'value' => date("Y-m-d",strtotime($value)),
                                   'class' => 'monbulan',
                                   'readOnly'=>TRUE
                                  );
                  if($property_aktif == 'Ya' && $cbt != 'Ya') {
                    if($look)
                      echo "<td ".$bg.">". $xdata."</td>"; 
                    else
                      echo "<td ".$bg.">".form_input($periode)."</td>"; 
                  }
                }
                  
                if($property_type == 'TextBox') {
                  $property_input = array(
                      'name' => $nm_var,
                      'style'=>'width:100%',
                      'value' => $value,
                      'class' => 'input-wrc'
                  );
                  if($property_aktif == 'Ya' && $cbt != 'Ya') {
                    if($look)
                      echo "<td ".$bg.">". $xdata ."</td>";
                    else
                      echo "<td ".$bg.">".form_input($property_input)."</td>";
                  }
                }
                    
                if($property_type == 'Integer') {
                  $data_property = (int) $data_property;
                  $property_input = array('name' => $nm_var,
                                          'class' => 'input-wrc required digits',
                                          'style'=>'width:10%',
                                          'value' => $value
                                         );
                  if($property_aktif == 'Ya' && $cbt != 'Ya') {
                    if($look)
                      echo "<td ".$bg.">". $xdata . "</td>";
                    else
                      echo "<td ".$bg.">".form_input($property_input).' Hanya diisi oleh angka. ( koma dengan . )'."</td>";
                  }
                }
                    
                if($property_aktif == 'Ya' && $cbt != 'Ya') {
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
        $ddd = $this->db->query("SELECT *  FROM table_non_spipise where id_permohonan = $id_daftar")->row_array();
        if(count($ddd) > 0){
          $tenaga = "value = '$ddd[tenaga_kerja]'";
          $invest = "value = '$ddd[investasi]'";
        }else{
          $tenaga = '';
          $invest = '';
        }   
        ?>
        <div id="tabs-3">
          <table cellpadding="0" cellspacing="0" border="0" class="display">
            <tr>
              <td width="7%" class="bg-grid"><b>1.</b>
              <td width="15%"class="bg-grid"><b>Penyerapan Tenaga Kerja</b><br><small>Input hanya angka</small>
              <td class="bg-grid"><input type="text" name="tenaga" <?=$tenaga?>  pattern="[0-9]+" class="input-wrc"> (Jiwa)
            <tr>
            <td width="7%" ><b>2.</b>
            <td width="15%"><b>Nilai Investasi</b><br><small>Input hanya angka</small>
            <td>
              <input type="text" name="invest" <?=$invest?> pattern="[0-9]+" class="input-wrc"> (Rp)
            <tr>
              <input type="hidden" value="<?=$kabupaten_id?>" name="idkab" class="input-wrc">
              <input type="hidden" value="<?=$permohonan_id?>" name="idpermo" class="input-wrc">
              <input type="hidden" value="<?=$perizinan_id?>" name="idizin" class="input-wrc">
          </table>
        </div>
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
      $batal = 'Kembali';
      if($stat_property && !$look){
        echo form_submit($add_daftar);
        $batal = 'Batal';
      }
      echo "<span></span>";
      $cancel_daftar = array('name' => 'button',
                             'class' => 'button-wrc',
                             'content' => $batal,
                             'onclick' => 'parent.location=\''. site_url('pendataan/pendataan/index_next') . '\''
                             );
      echo form_button($cancel_daftar);
      echo form_close();
      ?>
    </div>
  </div>
  <br style="clear: both;" />
</div>