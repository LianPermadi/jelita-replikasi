<script>
function validasi() {
  var catatan = document.forms[0].pesankomentar.value;
  
  if(catatan.length=='0') {
    document.getElementById('erorCatatan').innerHTML = 'Field ini harus diisi';
    document.getElementById('erorCatatan').style.visibility = "visible"; 
    document.getElementById('erorCatatan').style.color = "#FF2F2F";
    return false; 
  }
}
</script>

<div id="content">
  <div class="post">
    <div class="title">
      <h2><?php echo $page_name; ?></h2>
    </div>
    <div class="entry">
      <?php 
      $attr = array('name' => 'form', 'id' => 'form','onsubmit' => 'return validasi()');
      echo form_open('permohonan/bap/save',$attr);
      echo form_hidden('id_bap', $id_bap); 
      echo form_hidden('id', $id);
      echo form_hidden('waktu_awal', $waktu_awal);
      $izin = new trperizinan();
      $izin->get_by_id($idjenis);
      $c_tarif = $izin->c_tarif;
      $kelompok = $izin->trkelompok_perizinan->get();
      ?>
      <fieldset>
        <legend>Data Berita Acara Pemeriksaan</legend>
        <div id="statusMain">
          <div id="leftMain">
            <?php echo form_label('No pendaftaran'); ?>
          </div>
          <div id="rightMain">
            <?php echo form_hidden('nopendaftaran', $nopendaftaran); ?>
            <?php echo $nopendaftaran; ?>
          </div>
        </div>
        
        <div id="statusMain">
          <div id="leftMain" class="bg-grid">
            <?php echo form_label('Jenis layanan'); ?>
          </div>
          <div id="rightMain" class="bg-grid">
            <?php echo $jenislayanan; ?>
          </div>
        </div>
        
        <div id="statusMain">
            <div id="leftMain">
                <?php echo form_label('Nama Pemohon'); ?>
            </div>
            <div id="rightMain">
                <?php echo $namapemohon; ?>
            </div>
        </div>
        
        <div id="statusMain">
          <div id="leftMain" class="bg-grid">
            <?php echo form_label('Alamat Pemohon'); ?>
          </div>
          <div id="rightMain" class="bg-grid">
            <?php echo $alamatpemohon; ?>
          </div>
        </div>
        
        <div id="statusMain">
          <div id="leftMain" >
            <?php echo form_label('Nama Perusahaan'); ?>
          </div>
          <div id="rightMain" >
            <?php echo $namaperusahaan; ?>
          </div>
        </div>
        
        <?php
        if($kelompok->id == "2" || $kelompok->id == "4"){   // jika peninjauan
          ?>
          <div id="statusMain">
            <div id="leftMain" class="bg-grid">
              <?php echo form_label('Tanggal Peninjauan'); ?>
            </div>
            <div id="rightMain"class="bg-grid" >
              <?php
              $tanggalperiksa_input = array('name' => 'tglperiksa',
                                            'value' => $tglperiksa,
                                            'readOnly'=>TRUE,
                                            'class' => 'input-wrc required',
                                            'id' => 'bap'
                                           );
              echo form_input($tanggalperiksa_input);
              ?>
            </div>
          </div>
          <?php
        }
        
        if($id_bap) {
          ?>
          <div id="statusMain">
            <div id="leftMain" >
              <?php
              echo form_label('No BAP', 'jenis_permohonan');
              ?><br><br>
            </div>
            <div id="rightMain" >
              <?php
              echo $no_bap;
              ?>
            </div>
          </div>
          <?php
        }
        
        ?>
        <div id="statusMain">
          <br><br>
          <table border="1" width="900" cellpadding="2px" cellspacing="0" align="center">
            <?php $jml_property = $this->lib_date->data_property($id_izin,'1'); ?>
            <tr>
            <td colspan="6" align="center" bgcolor="#CED9FE" height="33px"><b>PROPERTY</b></td>
            <tr>
            <tr>
            <?php
              if($jml_property == '0'){ ?>
                <td colspan="3" align="center" height="25"><b>Data Property Belum Diseting</b></td>
                <?php
              }else{
                ?>
              	<td colspan="3" align="center" height="25"><b>Data Berkas Permohonan</b></td>
                <?php 
              }
              if($kelompok->id == "2" || $kelompok->id == "4"){
                ?>
                <td colspan="3" align="center" height="25"><b>Data Tinjauan</b></td>
                <?php
              }
            ?>
            <tr>
            <?php
            if($jml_property == '0') {
              $stat_property = FALSE;
            }else{
              $i = 1;
              $stat_property = TRUE;
              $text = $this->lib_date->data_property($id_izin,'2');
              if($jml_property > '1') {
                $text = $this->lib_date->sort_property($id_izin, $text);
              }
              $list = explode (",",$text);
              foreach ($list as $data) {
                $nprop = $this->lib_date->array_property('1',$data);             // Nama Property
                $property_aktif = $this->lib_date->array_property('11',$data);   // Aktifasi Property
                $cbt = $this->lib_date->array_property('7',$data);   // Aktifasi Property
                $data_property = $this->lib_date->isi_property($id_daftar, $this->lib_date->array_property('0',$data), '1');
                $hitung = strlen($data_property);
                $cek_posisi = strpos($data_property,'^'); 
                $hasil = substr($data_property,0,$cek_posisi);
                $hasil2 = substr($data_property,$cek_posisi+1,$hitung);
                if($property_aktif == 'Ya' && $cbt != 'Ya') {
                  if($i % 2 == 0){
                    $color = "#FFFFFF";
                  }else{
                    $color = "#CED9FE";
                  }
                  
                  echo "<tr bgcolor='" . $color . "'>";
                  ?>
                  <td><?php echo $nprop; ?></td>  
                  <td colspan="2"><?php echo $hasil; ?></td>
                  <?php
                  if($kelompok->id == "2" || $kelompok->id == "4"){
                    ?>
                    <td><?php echo $nprop; ?></td>
                    <?php
                  }
                  ?>
                  <td colspan="2"><?php echo $hasil2; ?></td>
                  <?php
                  echo "</tr>";
                  $i++;
                }
              }
            }
            ?>
          </table>
          <br>
        </div>
        
        <?php 
        if($c_tarif == '1'){  // jika berretribusi
          ?>	
          <div id="statusMain">
            <div id="leftMain" class="bg-grid">
            	<?php
              //$total = $retribusi;
              echo form_label('Retribusi', 'retribusi');
              ?>
            </div>
            <div id="rightMain" style="font-size: 14px;" class="bg-grid">
              <?php 
              //  if($m_hitung=="1") {
                    //echo $n_manual->v_tinjauan;
              //      echo form_hidden('nilai_retribusi', $n_manual->v_tinjauan);
              //  } else {
              //      echo form_hidden('nilai_retribusi', $total); 
              //  }
              ?>
              <br>
            </div>
          </div>
          <?php
        }
        ?>
        
        <div id="statusMain">
          <div id="leftMain">
            <?php
            echo form_label('Catatan', 'nama_izin');
            ?><br><br>
          </div>
          <div id="rightMain">
            <?php
            $pesan = array('name' => 'pesankomentar',
                           'value' => $pesan,
                           'class' => 'input-area-wrc',
                           'id'    => 'pesankomentar',
                           'style' => 'min-width:500pt'
                          );
            echo form_textarea($pesan);
            ?>
            <p id="erorCatatan" style="visibility: hidden;"></p>
            <br><br>
          </div>
        </div>
        
        <div class="entry" style="text-align: center;">
          <?php
          if($eselon == 3) $txt = 'Approve'; else $txt = 'Simpan';
          $save = array('name' => 'submit',
                        'class' => 'submit-wrc',
                        'content' => $txt,
                        'type' => 'submit',
                        'value' => $txt
                       );
          echo form_submit($save);
          echo form_close();
          echo "<span></span>";
          $cancel_daftar = array('name' => 'button',
                                 'class' => 'button-wrc',
                                 'content' => 'Batal',
                                 'onclick' => 'parent.location=\'' . site_url('permohonan/bap') . '\''
                                );
                                echo form_button($cancel_daftar);
          ?>
        </div>
      </fieldset>
    </div>
    <br style="clear: both;" />
  </div>
</div>