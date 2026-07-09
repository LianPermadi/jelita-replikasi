<script type="text/javascript">
  function myfunction() {
    var nilai="";
    if(document.form1.status[0].checked==true) {
      nilai="apakah anda yakin akan melakukan penetapan izin.?";
    }else{
      nilai="apakah anda yakin akan melakukan penolakan izin.?";
    }
    
    if(confirm(nilai)==true) {
      return true;
    }else{
      return false;
    }
  }
</script>

<style type="text/css">
  #token_input { 
    text-transform: uppercase;
  }
</style>

<div id="content">
  <div class="post">
    <div class="title">
      <?php echo $this->lib_date->view_title($page_name); ?>
    </div>
    
    <?php 
    $alert = $this->session->flashdata("sukses");
    if(!empty($alert)){
      ?>
      <br>
      <div style="color: green; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;"><center><?php echo $alert; ?></center></div>
      <?php
    }
    ?>
    
    <?php 
    $alert = $this->session->flashdata("gagal");
    if(!empty($alert)){
      ?>
      <br>
      <div style="color: red; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;"><center><?php echo $alert; ?></center></div>
      <?php
    }
    ?>
    
    <?php 
    $alert = $info;
    if($alert == 'sukses'){
      ?>
      <br>
      <div style="color: green; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;"><center><?php echo $isi_info; ?></center></div>
      <?php
    }
    ?>
    
    <?php 
    $alert = $info;
    if($alert == 'gagal'){
      ?>
      <br>
      <div style="color: red; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;"><center><?php echo $isi_info; ?></center></div>
      <?php
    }
    ?>
    
    <div class="entry">
      <?php 
      $attr = array('id' => 'form','name'=>'form1','onsubmit'=>'return myfunction()');
      echo form_open('pelayanan/ambilsk/diserahkan',$attr); 
      ?>
      <?php echo form_hidden('id_sk', $id_sk); ?>
      <?php echo form_hidden('id', $id); ?>
      <?php 
      echo form_hidden('jenislayanan', $jenislayanan);
      echo form_hidden('waktu_awal', $waktu_awal);
      echo form_hidden('idpermohonan', $zz);
      echo form_hidden('idizin', $xx);
      echo form_hidden('token', $token);
      $izin = new trperizinan();
      $izin->get_by_id($idjenis);
      $kelompok = $izin->trkelompok_perizinan->get();
      if($noantri == "") $noantri = "-";
      ?>
      <fieldset>
        <legend>Data-Data Perizinan</legend>
        <div id="statusMain">
          <div id="leftMain" class="bg-grid">
            <?php echo "<b>". 'No pendaftaran / No Antrian' . "</b>"; ?>
          </div>
          <div id="rightMain" class="bg-grid">
            <?php echo $nopendaftaran ." / ". $noantri; ?>
            <?php //echo form_hidden('nopendaftaran', $nopendaftaran); ?>
          </div>
        </div>
        
        <div id="statusMain">
          <div id="leftMain">
            <?php echo "<b>". form_label('Tanggal / Asal Permohonan', 'asal_permohonan') . "</b>"; ?>
          </div>
          <div id="rightMain">
            <?php echo $this->lib_date->mysql_to_human($tgl_permohonan)  ." / ". $gerai; ?>
          </div>
        </div>
        
        <div id="statusMain">
          <div id="leftMain" class="bg-grid">
            <?php echo "<b>". form_label('Jenis layanan', 'jenis_layanan') . "</b>"; ?>
          </div>
          <div id="rightMain" class="bg-grid">
            <?php echo $jenislayanan; ?>
          </div>
        </div>
        
        <div id="statusMain">
          <div id="leftMain">
            <?php echo "<b>". form_label('Ojek Izin', 'objek_izin') . "</b>"; ?>
          </div>
          <div id="rightMain">
            <?php echo $objekizin; ?>
          </div>
        </div>
                  
        <div id="statusMain">
          <div id="leftMain" class="bg-grid">
            <?php echo "<b>". form_label('Nama Pemohon', 'nama_pemohon') . "</b>"; ?>
          </div>
          <div id="rightMain" class="bg-grid">
            <?php echo $namapemohon; ?>
          </div>
        </div>
                  
        <div id="statusMain">
          <div id="leftMain">
            <?php echo "<b>". form_label('Alamat Pemohon', 'alamat_pemohon') . "</b>"; ?>
          </div>
          <div id="rightMain">
            <?php echo $alamatpemohon; ?>
          </div>
        </div>
        
        <div id="statusMain">
          <div id="leftMain" class="bg-grid">
            <?php echo "<b>". form_label('Nomor HP Pemohon', 'n_hp') . "</b>"; ?>
          </div>
          <div id="rightMain" class="bg-grid">
            <?php echo $n_hp; ?>
          </div>
        </div>
        
        <div id="statusMain">
          <div id="leftMain">
            <?php echo "<b>". form_label('E-Mail Pemohon', 'n_email') . "</b>"; ?>
          </div>
          <div id="rightMain">
            <?php echo $n_email; ?>
          </div>
        </div>
        
        <div id="statusMain">
          <div id="leftMain" class="bg-grid">
            <?php echo "<b>". form_label('Nama Perusahaan', 'nama_perusahaan') . "</b>"; ?>
          </div>
          <div id="rightMain" class="bg-grid">
            <?php echo $namaperusahaan; ?>
          </div>
        </div>
                  
        <div id="statusMain">
          <div id="leftMain">
            <?php echo "<b>". form_label('Nomor BAP', 'no_bap') . "</b>"; ?>
          </div>
          <div id="rightMain">
            <?php echo $nobap; ?>
            <?php //echo form_hidden('nobap', $nobap); ?>
          </div>
        </div>
                  
        <div id="statusMain">
          <div id="leftMain" class="bg-grid">
            <?php echo "<b>". form_label('Nomor SK', 'noskedit') . "</b>"; ?>
          </div>
          <div id="rightMain" class="bg-grid">
            <?php echo $noskedit; ?>
          </div>
        </div>
        
        <div id="statusMain">
          <div id="leftMain">
            <?php
            echo "<b>". form_label('Tanggal Terbit SK', 'tglterbit') . "</b>";
            ?>
          </div>
          <div id="rightMain">
            <?php echo $this->lib_date->mysql_to_human($tglterbit);?>
          </div>
        </div>
        
        <div id="statusMain">
          <div id="leftMain" class="bg-grid">
            <?php echo "<b>". form_label('Nilai Retribusi', 'nilai_retribusi') . "</b>"; ?>
          </div>
          <div id="rightMain" class="bg-grid">
            <?php
            if($m_hitung=="1") {
              if(!empty($hitManualRet->v_tinjauan)) {
                echo "Rp. ".$this->terbilang->nominal($hitManualRet->v_tinjauan, 2);
                echo form_hidden('nilai_retribusi', $hitManualRet->v_tinjauan); 
              }else{
                echo "Rp. ".$this->terbilang->nominal('0', 2);
                echo form_hidden('nilai_retribusi', '0'); 
              }                        
            }else{
              if(empty($retribusi)) { $retribusi = 0; }
              $total = $retribusi;
              echo "Rp. ".$this->terbilang->nominal($total, 2); //.
              //	 "<span style='color:red;'><p><b>( &nbsp; Nilai retribusi belum di konfigurasi &nbsp; )</b></p></span>";
              echo form_hidden('nilai_retribusi', $total);  
            }
            ?>
            <br>
          </div>
        </div>
                  
        <div id="statusMain">
          <div id="leftMain">
            <?php
            echo "<b>". form_label('Permohonan perizinan', 'permohonan_izin') . "</b>";
            ?>
          </div>
          <div id="rightMain">
            <?php
            if($ditetapkan === "1") {
              echo "<b>";
              if($status === "1") echo "Diizinkan";
              else echo "Ditolak";
              echo "</b>";
            }else{
              echo "-";
            }
            ?>
            <br>
          </div>
        </div>
        
        <?php
        if($tampil == 1 && $token != "0"){
          ?>
          <div id="statusMain">
            <div id="leftMain" class="bg-grid">
              <?php
              echo "<b>". form_label('Tanggal Ambil SK', 'tgl_ambil') . "</b>";
              ?>
            </div>
            <div id="rightMain" class="bg-grid">
              <?php
              $tglambil_input = array('name' => 'tglambil',
                                      'value' => $tglambil,
                                      'class' => 'input-wrc',
                                      'readOnly'=>TRUE,
                                      'class' => 'monbulan'
                                     );
              echo form_input($tglambil_input);
              ?>
            </div>
          </div>
          
          <div id="statusMain">
            <div id="leftMain">
              <?php
              echo "<b>". form_label('Contact Person', 'kontak') . "</b>" ;
              ?>
            </div>
            <div id="rightMain">
              <?php
              $kontak_input = array('name' => 'kontak',
                                    'id' => 'kontak',
                                    'value' => $kontak,
                                    'class' => 'input-wrc required',
                                    'required' => 'required'
                                   );
              echo form_input($kontak_input);
              ?>
            </div>
          </div>
          
          <div id="statusMain">
            <div id="leftMain">
              <?php
              echo "<b>". form_label('Token OTP', 'token_input') . "</b>" ;
              ?>
            </div>
            <div id="rightMain">
              <?php
              $kontak_input = array('name' => 'token_input',
                                    'id' => 'token_input',
                                    'class' => 'input-wrc required',
                                    'required' => 'required'
                                   );
              echo form_input($kontak_input);
              ?>
            </div>
          </div>
          <?php
        }else if($serah == 1){
          ?>
          <div id="statusMain">
            <div id="leftMain" class="bg-grid">
              <?php
              echo "<b>". form_label('Tanggal Ambil SK', 'tgl_ambil') . "</b>";
              ?>
            </div>
            <div id="rightMain" class="bg-grid">
              <?php
              echo form_label(date('d-m-Y', strtotime($tglambil)), 'tgl_ambil');
              ?>
            </div>
          </div>
          
          <div id="statusMain">
            <div id="leftMain">
              <?php
              echo "<b>". form_label('Contact Person', 'kontak') . "</b>" ;
              ?>
            </div>
            <div id="rightMain">
              <?php
              echo form_label($kontak, 'kontak');
              ?>
            </div>
          </div>
          <?php
        }
        ?>
          
        <br>
        <div class="entry" style="text-align: center;">
          <a href="https://dpmptsp.jabarprov.go.id/skm/skm_form.php?resi=<?php echo $nopendaftaran; ?>"  target="_blank"><button type="button" class="button-wrc">Isi Survey SKM</button></a>
          <?php
          
          if($serah == 1) {
            $cancel_daftar = array('name' => 'button',
                                   'class' => 'button-wrc',
                                   'content' => 'Selesai',
                                   'onclick' => 'parent.location=\''. site_url('pelayanan/ambilsk') . '\''
                                  );
            echo form_button($cancel_daftar);
          }else{
            $teks_token = "Kirim Token";
            if($tampil == 1 && $token != "0"){
              $teks_token = "Kirim Ulang Token";
            }
          
            $btn_token = array('name' => 'button',
                               'class' => 'button-wrc',
                               'content' => $teks_token,
                               'onclick' => 'parent.location=\''. site_url('pelayanan/ambilsk/otp_serah/'.$zz.'/'.$xx) . '\''
                              );
            echo form_button($btn_token);
          
            $savenosk = array('name' => 'submit',
                              'class' => 'submit-wrc',
                              'content' => 'Diserahkan',
                              'type' => 'submit',
                              'value' => 'Diserahkan'
                             );
            if($tampil == 1 && $token != "0") 
               echo form_submit($savenosk);
          
            echo form_close();
            echo "<span></span>";
            $cancel_daftar = array('name' => 'button',
                                   'class' => 'button-wrc',
                                   'content' => 'Batal',
                                   'onclick' => 'parent.location=\''. site_url('pelayanan/ambilsk') . '\''
                                  );
            echo form_button($cancel_daftar);
          }                    
          ?>
        </div>
      </fieldset>
    </div>
    <br style="clear: both;" />
  </div>
</div>