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
    
    <?php
    
    echo form_open('property/master/preview_sk/' . $id_izin);
    echo form_hidden('waktu_awal', $waktu_awal);
    echo form_hidden('id_izin', $id_izin);
    ?>
    <div class="entry">
      <div id="tabs">
        <ul>
          <li><a href="#tabs-1">Data Entry</a></li>
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
                if($i%2 == 0) $bg = ""; else $bg = "class='bg-grid'";
                if($property_aktif == 'Ya') {
                  echo "<tr>";
                  echo "<td align='left' width='4%'".$bg."><b>".$i.' . '."</b></td>"."";   // Nomor Property
                  echo "<td align='left' width='10%'".$bg."><b>".$this->lib_date->array_property('1',$data)."</b></td>"."";   // Nama Property
                }
      	        // $xdata = $this->lib_date->isi_property($id_daftar, $this->lib_date->array_property('0',$data), '4');     //4 ambil data akhir
      	        // if($xdata == ''){
      	        //   $xdata = $this->lib_date->isi_property($id_daftar, $this->lib_date->array_property('0',$data), '3'); //4 ambil data akhir
      	        // }
               //  $data_property = $this->lib_date->isi_property($id_daftar, $this->lib_date->array_property('0',$data), '1');
               //  $hitung = strlen($data_property);
               //  $cek_posisi = strpos($data_property,'^'); 
               //  $data_property = substr($data_property,0,$cek_posisi);
                
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
                  if($property_aktif == 'Ya') {
                      echo "<td width='20%'".$bg.">".form_dropdown($nm_var, $opsi_koefisien, $value, 'class =  "input-select-wrc" required')."</td>";
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
                  if($property_aktif == 'Ya') {
                      echo "<td ".$bg.">".form_input($periode)."</td>"; 
                  }
                }
                  
                if($property_type == 'TextBox') {
                  $property_input = array(
                      'name' => $nm_var,
                      'style'=>'width:100%',
                      'value' => $value,
                      'class' => 'input-wrc',
                      'required' => 'required'
                  );
                  if($property_aktif == 'Ya') {
                      echo "<td ".$bg.">".form_input($property_input)."</td>";
                  }
                }
                    
                if($property_type == 'Integer') {
                  $property_input = array('name' => $nm_var,
                                          'class' => 'input-wrc required digits',
                                          'style'=>'width:10%',
                                          'value' => $value,
                                          'required' => 'required'
                                         );
                  if($property_aktif == 'Ya') {
                      echo "<td ".$bg.">".form_input($property_input).' Hanya diisi oleh angka. ( koma dengan . )'."</td>";
                  }
                }
                    
                if($property_aktif == 'Ya') {
                  echo "<td width='80%'".$bg."><b></b></td>";
                  echo "</b></td>";
                  echo "</tr>";
                  $i++;
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
      </div>
    </div>
    <div class="entry" style="text-align: center;">
      <?php
      $add_daftar = array('name' => 'submit',
                         'class' => 'submit-wrc',
                         'content' => 'Preview SK Docx',
                         'type' => 'submit',
                         'value' => 'Preview SK Docx'
                         );
      $batal = 'Kembali';
      if($stat_property){
        echo form_submit($add_daftar);
        $batal = 'Batal';
      }
      
      if ($e_sertifikat == 1) {
        echo "<span></span>";
        $preview = array('name' => 'button',
                               'class' => 'button-wrc',
                               'content' => 'Preview PDF',
                               'onclick' => 'parent.location=\''. site_url('property/master/preview_pdf/'.$id_izin) . '\''
                               );
        echo form_button($preview);
        echo "<span></span>";
      }
      
      $cancel_daftar = array('name' => 'button',
                             'class' => 'button-wrc',
                             'content' => $batal,
                             'onclick' => 'parent.location=\''. site_url('property/master') . '\''
                             );
      echo form_button($cancel_daftar);
      echo form_close();
      ?>
    </div>
  </div>
  <br style="clear: both;" />
</div>