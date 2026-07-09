<script type="text/javascript">
  function myfunction() {
    /*var total=""
    for(var i=0; i < document.form1.status.length; i++){
    if(document.form1.status[i].checked)
    total +=document.form1.status[i].value + "\n"
    }
    alert(total);*/
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

<div id="content">
  <div class="post">
    <div class="title">
      <h2><?php echo $page_name; ?></h2>
    </div>
    <div class="entry">
      <?php 
      $attr = array('id' => 'form','name'=>'form1','onsubmit'=>'return myfunction()');
      echo form_open('permohonan/penetapan/savenosk',$attr); 
      ?>
      <?php echo form_hidden('id_sk', $id_sk); ?>
      <?php echo form_hidden('id_surkep', $id_surkep); ?>
      <?php echo form_hidden('id', $id); ?>
      <?php 
      echo form_hidden('jenislayanan', $jenislayanan);
      echo form_hidden('waktu_awal', $waktu_awal);
      $izin = new trperizinan();
      $izin->get_by_id($idjenis);
      $kelompok = $izin->trkelompok_perizinan->get();
      if($noantri == "") $noantri = "-";
      ?>
      <fieldset>
        <legend>Data-Data Perizinan</legend>
        <div id="statusMain">
          <div id="leftMain" class="bg-grid">
            <?php echo "<b>". form_label('No pendaftaran / No Antrian', 'nama_izin') . "</b>"; ?>
          </div>
          <div id="rightMain" class="bg-grid">
            <?php echo $nopendaftaran ." / ". $noantri; ?>
            <?php echo form_hidden('nopendaftaran', $nopendaftaran); ?>
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
            <?php echo form_hidden('nobap', $nobap); ?>
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
          <h2>
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
            </div>
          </h2>
        </div>
                
        <div id="statusMain">
          <h2>
            <div id="leftMain">
              <!--<?php echo "<b>". form_label('Nomor SK', 'noskedit') . "</b>" ."Lama => ". $nosk; ?>-->
              <?php echo "<b>". form_label('Nomor SK ', 'noskedit') . "</b>"; ?>
            </div>
            <div id="rightMain">
              <?php
              if($user_group == 4) $no_sk_berkas = ''; // untuk Penomoran Manual;
              $nosk_input = array('name' => 'noskedit',
                                  'id' => 'noskedit',
                                  'value' => $no_sk_berkas,
                                  'class' => 'input-wrc required'
                                 );
              if($user_group == 4){ // untuk Penomoran Manual Admin; 
                echo form_input($nosk_input);
              	$simpan = 'Simpan';
              }else{
                $sparator = '';
              	if($no_sk_akhir == '') $sparator = ' / ';
              	echo $no_sk_awal;
              	if($c_in_nomor == 1){  // jika berkas ke sistem
                  $simpan = 'Simpan';
              		if($no_sk_berkas == '!!!!!'){
                    echo form_input($nosk_input);
                	}else{
              	  	echo '<span style="color: Red">'.$i_urut.'</span>';     // menampilkan jika setelah ambil penomoran berkas ke sistem
                  }
              	}else{                // jika sistem ke berkas
              	  echo '<span style="color: Red">'.$no_sk_tengah.'</span>';         // menampilkan jika setelah ambil penomoran system ke berkas
              		$simpan = 'Ambil Nomor';
              	}
                echo $sparator.$no_sk_akhir;
                echo $no_sk_tahun;
              }
              echo form_hidden('user_group', $user_group);
              echo form_hidden('no_sk_awal', $no_sk_awal);
              echo form_hidden('no_sk_tengah', $no_sk_tengah);
              echo form_hidden('no_sk_akhir', $no_sk_akhir);
              echo form_hidden('no_sk_tahun', $no_sk_tahun);
              echo form_hidden('c_in_nomor', $c_in_nomor);
              ?>
            </div>
          </h2>
        </div>
          
        <div id="statusMain">
          <h2>
            <div id="leftMain">
              <?php
              //echo "<b>". form_label('Tanggal Terbit SK', 'tglterbit') . "</b>" ."Lama => ". $this->lib_date->mysql_to_human($tglsk);
              echo "<b>". form_label('Tanggal Terbit SK', 'tglterbit') . "</b>";
              ?>
            </div>
            <div id="rightMain">
              <?php
              $tglsk_input = array('name' => 'tglterbit',
                          'value' => $tglterbit,
                          'class' => 'input-wrc',
                          'readOnly'=>TRUE,
                          'class' => 'monbulan'
                         );
              if($user_group == 4){ // untuk Evaluator;
                echo form_input($tglsk_input);
              }else{
                echo $this->lib_date->mysql_to_human($tglterbit);//echo form_input($tglsk_input);
              	echo form_hidden('tglterbit', $tglterbit);
              }
              ?>
            </div>
          </h2>
        </div>
        <!--
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
                                  'class' => 'input-wrc required'
                                 );
            echo form_input($kontak_input);
            ?>
          </div>
        </div>
        -->
        <?php
        //if($kelompok->id == "2" || $kelompok->id == "4"){
        ?>
        <!--
        <div id="statusMain">
          <div id="leftMain" class="bg-grid">
            <?php
            echo form_label('Tanggal Peninjauan', 'tgl_tinjau');
            ?>
          </div>
          <div id="rightMain" class="bg-grid">
            <?php echo $this->lib_date->mysql_to_human($tglperiksa); ?>
          </div>
          </div>
        <?php
        //}
        ?>
        -->                
              
        <div class="entry" style="text-align: center;">
          <?php
  			  $batal = 'Batal';
  			  if($ambil_nomor == 1) $batal = 'Selesai';
  			  $set_no_izin = array('name' => 'button',
                               'class' => 'button-wrc',
                               'content' => 'Seting Nomor Izin',
                               'onclick' => 'parent.location=\''. site_url('permohonan/penetapan/sn_izin') .'/'.$id.'/'.$idjenis. '\''
                               );
          echo "<span></span>";
  
          $savenosk = array('name' => 'submit',
                            'class' => 'submit-wrc',
                            'content' => $simpan,
                            'type' => 'submit',
                            'value' => $simpan,
                            'onclick' => "$('#pageloader').fadeIn();"
                           );
          echo "<span></span>";
  
          $cancel_daftar = array('name' => 'button',
                                 'class' => 'button-wrc',
                                 'content' => $batal,
                                 'onclick' => 'parent.location=\''. site_url('permohonan/penetapan/index') . '\''     // OLD index_next
                                );
          if($no_sk_tengah == 99999 && $user_group != 4)
            echo form_button($set_no_izin);  //khusus admin
          else
            if($ambil_nomor != 1)
              echo form_submit($savenosk);
          echo form_button($cancel_daftar);
          echo form_close();
          ?>
        </div>
      </fieldset>
    </div>
    <br style="clear: both;" />
  </div>
</div>