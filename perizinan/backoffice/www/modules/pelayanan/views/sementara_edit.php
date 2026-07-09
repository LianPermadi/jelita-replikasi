<style type="text/css">
  table {
    font-family: Verdana,Arial,sans-serif;
    font-size: 11px;
  }
</style>
<script>
  $(document).ready(function() {
  });
  
  // function validasi() {
  //   var tgl1 = document.getElementById('inputTanggal1').value;
  //   var tgl2 = document.getElementById('inputTanggal2').value;
  //   //if(tgl2 < tgl1 && tgl2!==''){
  //   //  //alert('Tanggal Peninjauan tidak boleh lebih kecil dari\ntanggal terima berkas');
  //   //  $('#coba').html("<p id='eror'>Tanggal Peninjauan tidakan boleh lebih kecil dari tanggal terima berkas</p>");
  //   //  return false;
  //   //}else{
  //      return true;
  //   //}
  // }

  function ceksumber(sumber) {
    if(sumber=='PASSPORT') {
      $("input[name=no_refer]").attr("class", 'input-wrc required');
    }else{
      $("input[name=no_refer]").attr("class", 'input-wrc required digits');
    }
  }

  // function cheker() { 
  //   $('#form').validate();
  //   var a = document.getElementsByName("pemohon_syarat[]");
  //   var jml ='<?php echo $jml_syarat; ?>';
  //   var group ='<?php echo $group; ?>';
  //   var kembali ='<?php echo $id_link; ?>';
  //   var total=0;
  //   for(var i=0; i < jml; i++){
  //     if(a[i].checked){
  //       total++;
  //     }
  //   }
  //   if(validasi()==false) {
  //     document.forms[0].submit.disabled=true;
  //   }else
  //     if(total == jml || group == 3 || kembali == 'Pengembalian') {
  //       document.forms[0].submit.disabled=false;
  //       $('#coba').html('');
  //       //$('#test').html('');
  //     }else{
  //       document.forms[0].submit.disabled=true;
  //       $('#coba').html("<p id='eror'>* Lengkapi Persyaratan Untuk Mengaktifkan Tombol Simpan</p>");
  //     }        
  //   document.forms[0].submit.disabled=false;
  // }

  // window.onload = cheker;
  // $(function() {
  //   var validator = $('#form').validate();
  //   var tabs = $( "#tabs" ).tabs({
  //       select: function(event, ui){
  //         var valid = true;
  //         var current = $(this).tabs("option","selected");
  //         $('#form').find(':input.required, select.notSelect').each(function(){
  //           console.log(valid);
  //           if(!validator.element(this) && valid){
  //             valid = false;     
  //           }
  //         });
  //         if(valid == false){
  //           $('#test').html('Data Belum Lengkap, Silahkah Diisi');
  //         }else{
  //           $('#test').html('');
  //         }               
  //       }
  //   });
  // });

</script>

<style>
  #eror {color:#FF0000;
         font-weight:bold;
         text-align:center;
        }
  #eror1 {color:#FF0000;
          font-weight:bold;
         }
  
  .field_error {color:#FF0000;
                position:relative;
                font-size: 9px;
                margin: -4% 0 0 74%;
                padding: 0 0 2% 0 ;
               }
</style>

<div id="content">
  <div class="post">
    <div class="title">
      <?php echo $this->lib_date->view_title($page_name); ?>
    </div>
    <div class="entry">
      <fieldset id="half">
        <legend>Data Perizinan</legend>
        <?php
        if($paralel == "no") {
          if($jenis_izin->id) {
            ?>
            <div id="statusRail">
              <div id="leftRail" class="bg-grid">
                <?php echo form_label('Nama Izin', 'nama_izin'); ?>
              </div>
              <div id="rightRail" class="bg-grid">
                <?php echo $jenis_izin->n_perizinan; ?>
              </div>
            </div>
          
            <div id="statusRail">
              <div id="leftRail">
                <?php echo form_label('Kelompok Izin', 'kelompok_izin'); ?> 
              </div>
              <div id="rightRail">
                <?php
                $jenis_izin->trkelompok_perizinan->get();
                echo $jenis_izin->trkelompok_perizinan->n_kelompok;
                ?>
              </div>
            </div>
                
            <div id="statusRail">
              <div id="leftRail" class="bg-grid">
                <?php echo form_label('Jenis Permohonan', 'jenis_permohonan'); ?>
              </div>
              <div id="rightRail" class="bg-grid">
                <?php echo $jenis_permohonan->n_permohonan; ?>
              </div>
            </div>
            <?php
            if ($save_method == "update") {
              ?>
              <div id="statusRail" style="font-weight: bold">
                <div id="leftRail">
                  <?php echo form_label('No Pendaftaran', 'no_daftar'); ?>
                </div>
                <div id="rightRail">
                  <?php echo $list_daftar->pendaftaran_id; ?>
                </div>
              </div>
              <?php
              if($list_daftar->c_paralel !== '0') {
                ?>
                <div id="statusRail">
                  <div id="leftRail" class="bg-grid">
                    <?php echo form_label('Jenis Paralel', 'name_paralel'); ?>
                  </div>
                  <div id="rightRail" class="bg-grid">
                    <?php echo $jenis_paralel->n_paralel; ?>
                  </div>
                </div>
                <?php
              }
            }
          }else{
            ?>
            <div class="ContentForm" style="font-weight: bold;text-align: center"> Jenis Izin belum dipilih
              <div style="float: right">
                <?php
                $kembali = array('name' => 'button',
                                 'class' => 'button-wrc',
                                 'content' => '&laquo; back',
                                 'onclick' => 'parent.location=\'' . site_url('pelayanan/pendaftaran') . '\''
                                );
                echo form_button($kembali);
                ?>
              </div>
            </div>
            <?php
          }
        }else{
          if($list_izin_paralel) {
            ?>
            <div id="statusRail">
              <div id="leftRail" class="bg-grid">
                <?php echo form_label('Jenis Paralel', 'name_paralel'); ?>
              </div>
              <div id="rightRail" class="bg-grid">
                <?php echo $jenis_paralel->n_paralel; ?>
              </div>
            </div>
            <br style="clear: both">
            <div id="statusRail">
              <div id="leftRail">
                <?php echo form_label('Jenis Izin yang dipilih', 'name_izin'); ?>
              </div>
              <div id="rightRail">
                <?php
                foreach ($list_izin_paralel as $row) {
                  $row_izin = new trperizinan();
                  $row_izin->get_by_id($row);
                  echo $row_izin->n_perizinan . "<br />";
                }
                ?>
              </div>
            </div>
            <div id="statusRail">
              <div id="leftRail" class="bg-grid">
                <?php echo form_label('Jenis Permohonan', 'jenis_permohonan'); ?>
              </div>
              <div id="rightRail" class="bg-grid">
                <?php echo $jenis_permohonan->n_permohonan; ?>
              </div>
            </div>
            <?php
          }else{
            ?>
            <div class="ContentForm" style="font-weight: bold;text-align: center">
              Izin Paralel belum dipilih
              <div style="float: right">
                <?php
                $kembali = array('name' => 'button',
                                 'class' => 'button-wrc',
                                 'content' => '&laquo; back',
                                 'onclick' => 'parent.location=\'' . site_url('pelayanan/pendaftaran') . '\''
                                );
                echo form_button($kembali);
                ?>
              </div>
            </div>
            <?php
          }
        }
        ?>
      </fieldset>
    </div>

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

    <?php
    if($eror) {
      echo (" <p id='eror'>$eror</p>");
    }
    ?>
    <p id='eror'><span id="test"></span></p>
    <?php
    $attr = array('name' => 'form', 'id' => 'form');
    //echo form_open('pelayanan/pendaftaran/' . $save_method, $attr);
    echo form_open('pelayanan/sementara/' . $save_method, $attr);
    if($paralel == "yes") {
      if($list_izin_paralel) {
        foreach($list_izin_paralel as $row) {
          $row_izin = new trperizinan();
          $row_izin->get_by_id($row);
          echo form_hidden('list_izin_paralel[]', $row_izin->id);
        }
      }
    }
    
    echo form_hidden('jenis_permohonan', $mohon);
    echo form_hidden('paralel', $paralel);
    echo form_hidden('jenis_izin', $izin);
    echo form_hidden('jenis_izin_id', $jenis_izin->id);
    echo form_hidden('jenis_permohonan_id', $jenis_permohonan->id);
    echo form_hidden('tgl_daftar', date("Y-m-d"));
    echo form_hidden('id_daftar_ol', $id_daftar_ol);
    // echo form_hidden('no_antri', $nodaftar);
    echo form_hidden('no_antri', 0);
    echo form_hidden('id_link', $id_link);
    echo form_hidden('waktu_awal', $waktu_awal);
    echo form_hidden('syarat_izin', $syarat_izin);
    echo form_hidden('group', $group);
    echo form_hidden('eror', 'halo');
    echo form_hidden('trkelurahan_id', $kel_id);
    
    echo form_hidden('jumlah_properti', $jumlah_properti);
    $no=0;
    while($no<$jumlah_properti){
      $ke = $no+1;
      echo form_hidden("properti_".$ke."",$input_properti[$no]);
      $no++;
    }
    
    if($paralel == "yes")
      echo form_hidden('jenis_paralel', $jenis_paralel->id);
    
    //khusus T=BPMPT F=TimTeknis
    $ncek = TRUE;
    if($lokasi_user == 'OPD Teknis') {
      $ncek = FALSE;
      
      if ($unitkerjauser == $jenis_izin->dinas_pengelola) {
        $ncek = TRUE;
      }
    }
    ?>
    <div class="entry">
      <div id="tabs">
        <ul>
          <li><a href="#tabs-1">Data Pemohon & Permohonan</a></li>
          <li><a href="#tabs-2">Data Perusahaan</a></li>
          <li><a href="#tabs-3">Data Teknis</a></li>
          <li><a href="#tabs-4">Persyaratan</a></li>
        </ul>
        <?php
        if($paralel == "yes")
          $real_id = $list_izin_paralel;
        else
          $real_id = $jenis_izin->id;
        if($real_id) {
          ?>
          <!-- ---------- TABS 1 ( Data Pemohon ) ----------- -->
          <div id="tabs-1">
            <div id="contentleft">
              <div class="contentForm">
                <?php
                echo '<b><H2>' . form_label('DATA PEMOHON ') . '</H2></b>';
                ?>
              </div>
              <div style="clear: both" ></div>

              <div class="contentForm">
                <?php
                echo '<b>' . form_label('Nomor Antrian ') . '</b>';
    	          echo "0";
                            ?>
              </div>
              <div style="clear: both" ></div>

              <div class="contentForm">
                <?php
                echo '<b>'.form_label('Nomor Induk Berusaha').'</b>';
                echo ((!empty($nib)) ? form_label($nib) : form_label('-'));
                echo "<input type='hidden' name='nib' value='".$nib."'><br>";
                ?>
                &nbsp;
              </div>
              <div style="clear: both" ></div>
              
              <div class="contentForm"> 
                <?php
                $data = array('KTP' => 'KTP','SIM' => "SIM",'PASSPORT' => 'PASSPORT');
                echo '<b>'.form_label('Sumber Identitas').'</b>';
                echo form_label('KTP');
    	          echo "<input type='hidden' name='cmbsource' value='KTP'>";
    	          echo "<input type='hidden' name='id_permohonan_portal' value='".$id_permohonan_portal."'>";
                ?>
              </div>
              <div style="clear: both" ></div>
                        
              <div class="contentForm">
                <?php
                echo '<b>'.form_label('NO ID').'</b>';
                echo $no_refer;
    	          echo "<input type='hidden' name='no_refer' value='".$no_refer."'>";
                ?>
              </div>
              <div style="clear: both" ></div>
              
              <?php
              if($save_method == "update") {
                echo ("<br>");
              }
              ?>
              <div class="contentForm">
                <?php
                echo '<b>'.form_label('Nama Pemohon ').'</b>';
                echo $nama_pemohon;
                echo "<input type='hidden' name='nama_pemohon' value='".$nama_pemohon."'>";
                ?>
              </div>
              <div style="clear: both" ></div>
              
              <div class="contentForm">
                <?php
                echo '<b>'.form_label('No Telp/HP','No Telp/HP ').'</b>';
                echo form_label($no_telp);
                echo "<input type='hidden' name='no_telp' value='".$no_telp."'>";
                ?>
              </div>
              <div style="clear: both" ></div>
              
              <div class="contentForm">
                <?php
                echo '<b>'.form_label('Alamat Pemohon ').'</b>';
                echo form_label($alamat_pemohon,'Alamat Pemohon ');
                echo "<input type='hidden' name='alamat_pemohon' value='".$alamat_pemohon."'><br>";
                ?>
              </div>
              <div style="clear: both" ></div>

              <div class="contentForm">
                <?php 
                echo '<b>'.form_label('Provinsi ').'</b>';
                $opsi_propinsi = array('0' => '-------Pilih data-------');
                foreach($list_propinsi as $row) {
                  $opsi_propinsi[$row->id] = $row->n_propinsi;
                }
                echo form_label($opsi_propinsi[$propinsi_pemohon]);
                echo "<input type='hidden' name='propinsi_pemohon' value='".$propinsi_pemohon."'>";
                ?>
              </div>
              <div style="clear: both" ></div>

              <div class="contentForm">
                <?php
                echo '<b>'.form_label('Kabupaten/Kota ').'</b>';
                $opsi_kabupaten = array('0' => '-------Pilih data-------');
                foreach($list_kabupaten as $row) {
                  $opsi_kabupaten[$row->id] = $row->n_kabupaten;
                }
                if($kabupaten_pemohon == NULL) {
                  echo "<div id='show_kabupaten_pemohon'>Data Tidak Tersedia</div>";
                }else{
                  echo "<div id='show_kabupaten_pemohon'><input type='hidden' value='" . $kabupaten_pemohon . "' name='kabupaten_pemohon' />" . $opsi_kabupaten[$kabupaten_pemohon] . "</div>";
                }
                ?>
              </div>
              <div style="clear: both" ></div>
              
              <div class="contentForm">
                <?php
                echo '<b>'.form_label('Kecamatan ').'</b>';
                $opsi_kecamatan = array('0' => '-------Pilih data-------');
                foreach ($list_kecamatan as $row) {
                  $opsi_kecamatan[$row->id] = $row->n_kecamatan;
                }
                if($kecamatan_pemohon == NULL) {
                  echo "<div id='show_kecamatan_pemohon'>Data Tidak Tersedia</div>";
                }else{
                  echo "<div id='show_kecamatan_pemohon'><input type='hidden' value='" . $kecamatan_pemohon . "' name='kecamatan_pemohon' />" .  $opsi_kecamatan[$kecamatan_pemohon] . "</div>";
                }
                ?>
              </div>
              <div style="clear: both" ></div>
              
              <div class="contentForm">
                <?php
                echo '<b>'.form_label('Kelurahan ').'</b>';
                $opsi_kelurahan = array('0' => '-------Pilih data-------');
                foreach ($list_kelurahan as $row) {
                  $opsi_kelurahan[$row->id] = $row->n_kelurahan;
                }
                if($kelurahan_pemohon == NULL) {
                  echo "<div id='show_kelurahan_pemohon'>Data Tidak Tersedia</div>";
                }else{
                  echo "<div id='show_kelurahan_pemohon'><input type='hidden' value='" . $kelurahan_pemohon . "' name='kelurahan_pemohon' />" . $opsi_kelurahan[$kelurahan_pemohon] . "</div>";
                }
                ?>
              </div>
              <div style="clear: both" ></div>
                            
              <div class="contentForm">
                <?php
                $alamatdataluar_input = array('name' => 'alamat_pemohon_luar',
                                              'value' => $alamat_pemohon_luar,
                                              'class' => 'input-area-wrc'
                                             );
                echo '<b>'.form_label('Alamat Pemohon<br />di Luar Negeri<br />(isikan jika ada)').'</b>';
                echo form_textarea($alamatdataluar_input);
                ?>
              </div>
              <div style="clear: both" ></div>
              
              <div class="contentForm">
                <?php
                echo '<b>'.form_label('Nomor Kontak Perantara').'</b>';
                echo form_label($kd_kontak);
                echo "<input type='hidden' name='kd_kontak' value='".$kd_kontak."'><br>";
                ?>
              </div>
              <div style="clear: both" ></div>
            </div>
                
            <div id="contentright">
              <div class="contentForm">
                <?php
                echo '<b><H2>' . form_label('DATA PERMOHONAN ') . '</H2></b>';
                ?>
              </div>
              <div style="clear: both" ></div>

              <div class="contentForm">
                <?php
                echo '<b>'.form_label('Tempat Pendaftaran').'</b>';
                echo form_label('OnLine');
                echo "<input type='hidden' name='cmbgerai' value='OnLine'><br>";
                ?>
              </div>
              <div style="clear: both" ></div>

              <div class="contentForm" >
                <?php
                echo '<b>'.form_label('Tgl Daftar OnLine').'</b>';
                echo form_label($this->lib_date->mysql_to_human($tgl_daftar_ol));
            	  echo "<input type='hidden' name='tgl_daftar_ol' value='".$tgl_daftar_ol."'><br>";
                ?>
              </div>
              <div style="clear: both" ></div>

              <div class="contentForm">
                <?php 
                echo '<b>'.form_label('Provinsi ').'</b>';
                $opsi_propinsi = array('0' => '-------Pilih data-------');
                foreach($list_propinsi as $row) {
                  $opsi_propinsi[$row->id] = $row->n_propinsi;
                }
                echo form_label($opsi_propinsi[$propinsi_pemohon]);
                ?>
              </div>
              <div style="clear: both" ></div>

              <div class="contentForm">
                <?php
                echo '<b>'.form_label('Kabupaten/Kota ').'</b>';
                echo form_label($n_kab_izin);
                ?>
              </div>
              <div style="clear: both" ></div>
              
              <div class="contentForm">
                <?php
                echo '<b>'.form_label('Kecamatan ').'</b>';
                echo form_label($n_kec_izin);
                ?>
              </div>
              <div style="clear: both" ></div>
              
              <div class="contentForm">
                <?php
                echo '<b>'.form_label('Kelurahan ').'</b>';
                echo form_label($n_kel_izin);
                ?>
              </div>
              <div style="clear: both" ></div>

              <div class="contentForm" >
                <?php
                echo '<b>'.form_label('Long / Lat Izin').'</b>';
                echo form_label($lon." / ".$lat);
                echo "<input type='hidden' name='lon' value='".$lon."'>";
                echo "<input type='hidden' name='lat' value='".$lat."'><br>";
                ?>
              </div>
              <div style="clear: both" ></div>
              
              <div class="contentForm">
                <?php
                $lokasi_input = array('name' => 'lokasi_izin',
                                      'value' => $lokasi_izin,
                                      'class' => 'input-area-wrc',
                                      'id' => 'lok_izin'
                                     );
                echo '<b>'.form_label('Lokasi / Objek Izin').'</b>';
                echo form_textarea($lokasi_input);
                ?>
              </div>
              
              <?php 
              if($this->All || !$this->cs){
                ?>  
                <div class="contentForm">
                  <?php echo form_label('&nbsp;'); ?>
                  <button type="button" onclick="upObjek()" class="button-wrc">Update Objek Izin</button>
                </div>
                <?php 
              }
              ?>
              <div style="clear: both" ></div>

              <div class="contentForm">
                <?php
                $ket_input = array('name' => 'keterangan',
                                  'value' => $keterangan,
                                  'class' => 'input-area-wrc'
                                 );
                echo '<b>'.form_label('Keterangan').'</b>';
                echo form_textarea($ket_input);
                ?>
              </div>
              <div style="clear: both" ></div>
              
              <div class="contentForm">
                <?php
                $tglsurvey_input = array('name' => 'tgl_survey',
                                         'value' => $tgl_survey,
                                         'class' => 'input-wrc',
                                         'readOnly' => TRUE,
                                         'id' => 'inputTanggal2'
                                        );
                echo '<b>'.form_label('Tgl Peninjauan').'</b>';
                echo form_input($tglsurvey_input);
                ?>
              </div>
              <div style="clear: both" ></div>

            </div>
            <br style="clear: both;" />
          </div>
              
          <!-- ----------- TABS 2 ( Data Perusahaan ) ----------- -->
          <div id="tabs-2">
            <div id="contentleft">

              <div class="contentForm">
                <?php
                echo '<b>'.form_label('NPWP').'</b>';
                echo form_label($npwp);
                echo "<input type='hidden' name='npwp' value='".$npwp."'><br>";
                ?>
                &nbsp;
              </div>
              <div style="clear: both" ></div>
              
              <div class="contentForm">
                <?php
                echo '<b>'.form_label('No Register ').'</b>';
                echo form_label($nodaftar);
                echo "<input type='hidden' name='nodaftar' value='".$nodaftar."'><br>";
                ?>
                <?php if ($statusOnline == "1") { ?>
                <br>
                <?php } ?>
              </div>
              <div style="clear: both" ></div>
              
              <div class="contentForm">
                <?php
                echo '<b>'.form_label('Nama Perusahaan ').'</b>';
                echo form_label($nama_perusahaan);
                echo "<input type='hidden' name='nama_perusahaan' value='".$nama_perusahaan."'><br>";
                ?>
              </div>
              <div style="clear: both" ></div>
              
              <div class="contentForm">
                <?php
                echo '<b>'.form_label('Telp Perusahaan ').'</b>';
                echo form_label($telp_perusahaan);
                echo "<input type='hidden' name='telp_perusahaan' value='".$telp_perusahaan."'><br>";
                ?>
              </div>
              <div style="clear: both" ></div>
              
              <div class="contentForm">
                <?php
                echo '<b>'.form_label('Fax').'</b>';
                echo form_label($fax_perusahaan);
                echo "<input type='hidden' name='fax' value='".$fax_perusahaan."'><br>";
                ?>
              </div>
              <div style="clear: both" ></div>
              
              <div class="contentForm">
                <?php
                echo '<b>'.form_label('Email').'</b>';
                echo form_label($email);
                echo "<input type='hidden' name='email' value='".$email."'><br>";
                ?>
              </div>
            </div>
            <div id="contentright">
              <div class="contentForm">
                <?php
                echo '<b>'.form_label('Provinsi ').'</b>';
                $opsi_propinsi = array('0' => '-------Pilih data-------');
                foreach($list_propinsi as $row) {
                  $opsi_propinsi[$row->id] = $row->n_propinsi;
                }
                echo form_label($opsi_propinsi[$propinsi_usaha]);
                echo "<input type='hidden' name='propinsi_usaha' value='".$propinsi_usaha."'>";
                ?>
              </div>
              <div style="clear: both" ></div>
                            
              <div class="contentForm">
                <?php
                echo '<b>'.form_label('Kabupaten/Kota ').'</b>';
                $opsi_kabupaten = array('0' => '-------Pilih data-------');
                foreach ($list_kabupaten as $row) {
                  $opsi_kabupaten[$row->id] = $row->n_kabupaten;
                }
                if($kabupaten_usaha == NULL) {
                  echo "<div id='show_kabupaten_usaha'>Data Tidak Tersedia</div>";
                }else{
                  echo "<div id='show_kabupaten_usaha'><input type='hidden' value='" . $kabupaten_usaha . "' name='kabupaten_usaha' />" . $opsi_kabupaten[$kabupaten_usaha] . "</div>";
                }
                ?>
              </div>
              <div style="clear: both" ></div>
              
              <div class="contentForm">
                <?php
                echo '<b>'.form_label('Kecamatan ').'</b>';
                $opsi_kecamatan = array('0' => '-------Pilih data-------');
                foreach ($list_kecamatan as $row) {
                  $opsi_kecamatan[$row->id] = $row->n_kecamatan;
                }
                if($kecamatan_usaha == NULL) {
                  echo "<div id='show_kecamatan_usaha'>Data Tidak Tersedia</div>";
                }else{
                  echo "<div id='show_kecamatan_usaha'><input type='hidden' value='" . $kecamatan_usaha . "' name='kecamatan_usaha' />" . $opsi_kecamatan[$kecamatan_usaha] . "</div>";
                }
                ?>
              </div>
              <div style="clear: both" ></div>
              
              <div class="contentForm">
                <?php
                echo '<b>'.form_label('Kelurahan ').'</b>';
                $opsi_kelurahan = array('0' => '-------Pilih data-------');
                foreach ($list_kelurahan as $row) {
                  $opsi_kelurahan[$row->id] = $row->n_kelurahan;
                }
                if($kelurahan_usaha == NULL) {
                  echo "<div id='show_kelurahan_usaha'>Data Tidak Tersedia</div>";
                }else{
                  echo "<div id='show_kelurahan_usaha'><input type='hidden' value='" . $kelurahan_usaha . "' name='kelurahan_usaha' />" . $opsi_kelurahan[$kelurahan_usaha] . "</div>";
                }
                ?>
              </div>
              <div style="clear: both" ></div>
              
              <div class="contentForm">
                <?php
                echo '<b>'.form_label('Alamat Perusahaan ').'</b>';
                echo form_label($alamat_usaha);
                echo "<input type='hidden' name='alamat_usaha' value='".$alamat_usaha."'>";
                ?>
              </div>
              <div style="clear: both" ></div>
              
              <div class="contentForm">
                <?php
                foreach ($list_kegiatan as $row) {
                  $opsi_kegiatan[' '] = "------Pilih salah satu------";
                  $opsi_kegiatan[$row->id] = $row->n_kegiatan;
                }
                echo '<b>'.form_label('Jenis Kegiatan').'</b>';
                if($jenis_kegiatan == "ok") {
                  echo form_dropdown('jenis_kegiatan', $opsi_kegiatan, ' ', 'class = "input-select-wrc" id="jenis_kegiatan"');
                }else{
                  echo form_dropdown('jenis_kegiatan', $opsi_kegiatan, $jenis_kegiatan, 'class = "input-select-wrc" id="jenis_kegiatan"');
                }
                echo form_error('jenis_kegiatan', '<div class="field_error">', '</div>');
                ?>
                <p id="erorJ_kegiatan" align="right" style="visibility: hidden;"></p>
              </div>
              <div style="clear: both" ></div>
              
              <div class="contentForm">
                <?php
                foreach ($list_investasi as $row) {
                  $opsi_investasi[' '] = "------Pilih salah satu------";
                  $opsi_investasi[$row->id] = $row->n_investasi;
                }
                echo '<b>'.form_label('Jenis Investasi ').'</b>';
                if($jenis_investasi == "ok") {
                  echo form_dropdown('jenis_investasi', $opsi_investasi, ' ', 'class = "input-select-wrc" id="jenis_investasi"');
                }else{
                  echo form_dropdown('jenis_investasi', $opsi_investasi, $jenis_investasi, 'class = "input-select-wrc" id="jenis_investasi"');
                }
                echo form_error('jenis_investasi', '<div class="field_error">', '</div>');
                ?>
                <p id="erorJ_investasi" align="right" style="visibility: hidden;"></p>
              </div>
            </div>
            <br style="clear: both;" />
          </div>
      
          <!-- ---------- TAB 3 ( Data Teknis ) ---------- -->
          <div id="tabs-3">
            <table cellpadding="0" cellspacing="0" border="0" class="display">
              <tr>
                <td align="left" width="4%"></td>
                <td align="left" width="20%"></td>
                <td align="left" width="1%"></td>
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
                if($jml_property > 1) {
                  $text = $this->lib_date->sort_property($id_izin, $text);
                }
                $list = explode (",",$text);
                foreach ($list as $data) {
                  $no_property = $this->lib_date->array_property('0',$data);  // Nomor Variabel
                  $nm_var = 'vdt_teknis'.$no_property;
                  $property_aktif = $this->lib_date->array_property('11',$data);      // Aktifasi Property
                  if($i%2 == 0) $bg = ""; else $bg = "class='bg-grid'";
                  if($property_aktif == 'Ya') {
                    echo "<tr>";
                    echo "<td align='left' width='4%'".$bg."><b>".$i.' . '."</b></td>"."";   // Nomor Property
                    echo "<td align='left' width='20%'".$bg."><b>".$this->lib_date->array_property('1',$data)."</b></td>"."";   // Nama Property
                    echo "<td align='left' width='1%'".$bg."><b>:</b></td>"."";              // Sparator
                  }
                                  
                  // Ambil data online
                  $data_property = $input_properti[$no_property-1]; // $no_property-1 sbb $input_properti sdh menjadi array
                
                  // Menampilkan isi property 
                  if($property_aktif == 'Ya') {
                    echo "<td align='left' width='75%'".$bg.">".$data_property."</b></td>";
                  }
                                  
                  // Cek Posisi
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
              ?>
            </table>
          </div>

          <!-- ---------- TAB 4 ( Persyaratan ) ---------- -->
          <div id="tabs-4">
            <table cellpadding="0" cellspacing="0" border="1" class="display">
              <thead>
                <tr>
                  <th width="5%">No</th>
                  <th width="40%">Syarat</th>
                  <th width="10%">Berkas</th>
                  <th width="5%">Status</th>
                  <th width="10%">Nomor Surat</th>
                  <th width="10%">Tanggal Surat</th>
                  <th width="10%">Masa Berlaku<br>Surat</th>
                  <th width="10%">Terpenuhi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $i = 0;
                // mestinya =>   /assets/userassets/pemohon/pamudi1694/pengajuan/117/
                $base_url	= "../assets/userassets/pemohon/".$username_portal."/pengajuan/".$id_portal."/";
                echo form_hidden('url', $base_url);
                
                if($paralel == "no") {
                  for($z=1;$z<=2;$z++) {
                    foreach ($syarat_izin as $data) {
                      $show_syarat = new trperizinan_syarat();
                      $show_syarat->where('trsyarat_perizinan_id', $data->id)
                                  ->where('trperizinan_id', $jenis_izin->id)->get();
                      $var = $show_syarat->c_show_type;
                      $stat_wajib = $show_syarat->status;
                      if( (int)$stat_wajib == (int)$z ) {
                        /* Baca beberapa status yang di-parse menjadi biner dan dikonvert jadi desimal */
                        //$rule = strval(decbin($var));
                        //if (strlen($rule) < 4) {
                        //    $len = 4 - strlen($rule);
                        //    $rule = str_repeat("0", $len) . $rule;
                        //}
                        //$arr_rule = str_split($rule);
                        //$c_daftar_ulang = $arr_rule[0];
                        //$c_baru = $arr_rule[1];
                        //$c_perpanjangan = $arr_rule[2];
                        //$c_ubah = $arr_rule[3];
                        
                        $rule = strval(decbin($var));
                        if($show_syarat->status_new == 1) $plv = 6; else $plv = 4; // penambahan pencabutan dan penutupan ditambah 00
                        if(strlen($rule) < $plv) {
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
                        
                        $syarat_status = $c_baru;
                        if($syarat_status == '1') {
                          $i++;
                          ?>
                          <tr>
                            <td align="center"><?php echo $i; ?></td>
                            <td><?php echo $data->v_syarat; ?>
                            </td>
                            <td>
                              <?php 
                              if(file_exists($base_url.$data->id.".pdf")){
                          	    echo anchor($base_url.$data->id.".pdf?q=".microtime(true), "Download",array("target"=>"_blank","style"=>"color:blue")); //die('file tersedia');
                              } elseif (file_exists($base_url.$data->id.".jpg")) {
                                echo anchor($base_url.$data->id.".jpg?q=".microtime(true), "Download",array("target"=>"_blank","style"=>"color:blue"));
                              } elseif (file_exists($base_url.$data->id.".jpeg")) {
                                echo anchor($base_url.$data->id.".jpeg?q=".microtime(true), "Download",array("target"=>"_blank","style"=>"color:blue"));
                              } elseif (file_exists($base_url.$data->id.".rar")) {
                                echo anchor($base_url.$data->id.".rar?q=".microtime(true), "Download",array("target"=>"_blank","style"=>"color:blue"));
                              } else {
                          	    echo 'Download';   //die(' file yang di cari tidak tersedia ');
                              }
                              ?>
                              <!--<td><?php echo anchor($base_url.$data->id.".pdf", "Download",array("style"=>"color:blue"));?>-->
                              <?php 
                              if($user == '5') {
                                echo anchor(site_url('pelayanan/sementara/tampil_pdf').'/'.$username_portal.'/'.$id_portal.'/'.$data->id.'/'.
                                $data->v_syarat, "Lihat",array("rel"=>"daftar_box","style"=>"color:blue"));
                              }
                              ?>
                                                     
                            </td>
                            <td align="center">
                              <?php
                              //if ($data->status == "1")
                              if($stat_wajib == "1")	
                                $status_data = "Wajib";
                              else
                                $status_data = "Tidak Wajib";
                              echo form_label($status_data);
                              ?>
                            </td>
                            <?php
                            $otherdb = $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
                            $detail_surat = $otherdb->query("select * from tmpermohonan_trsyarat_perizinan where tmpermohonan_id=".$id_portal." and trsyarat_perizinan_id=".$data->id."")->first_row();
                            if($detail_surat){
                              $alig1=''; $alig2=''; $alig3='';
                              $no_srt = $detail_surat->nomor_surat;
                              $tg_srt = $detail_surat->tanggal_surat;
                              $berlaku = $detail_surat->masa_berlaku_surat;
                              if(!$no_srt) {$alig1='align="center"'; $no_srt = '-'; }
                              if(!$tg_srt) {$alig2='align="center"'; $tg_srt = '-'; }
                              if(!$berlaku){$alig3='align="center"'; $berlaku = '-'; }
                            }else{
                              $alig1='align="center"'; $alig2='align="center"'; $alig3='align="center"';
                              $no_srt = '-'; $tg_srt = '-'; $berlaku = '-';
                            }
                            echo '<td '.$alig1.'>'.$no_srt.'</td>';
                            echo '<td '.$alig2.'>'.$tg_srt.'</td>';
                            echo '<td '.$alig3.'>'.$berlaku.'</td>';
                            ?>
                            <td align="center">
                              <?php
                              if($save_method === 'update') {
                                if(isset($check)) {
                                  foreach ($check as $dt) {
                                    if($dt == $data->id) {
                                      $checked = TRUE;
                                      break;
                                    }else{
                                      $checked = FALSE;
                                    }
                                  }
                                }else{
                                  $checked = FALSE;
                                  if($list_daftar) {
                                    foreach ($list_daftar as $data_daftar) {
                                      $data_syarat = new tmpermohonan_trsyarat_perizinan();
                                      $data_syarat->where('tmpermohonan_id', $data_daftar->id)
                                                  ->where('trsyarat_perizinan_id', $data->id)->get();
                                      if($data_syarat->trsyarat_perizinan_id) {
                                        $checked = TRUE;
                                        break;
                                      }
                                    }
                                  }else{
                                    $checked = FALSE;
                                    break;
                                  }
                                }
                                $set = array('name' => 'pemohon_syarat[]',
                                             'id' => 'chek',
                                             'value' => $data->id,
                                             'checked' => $checked,
                                             'onClick' => 'cekSyarat()',
                                             'required' => 'required'
                                             );
                                echo form_checkbox($set);
                              }else{
                                if(isset($check) && !empty($check)) {
                                  foreach ($check as $dt) {
                                    if($dt == $data->id) {
                                      $checked = TRUE;
                                      break;
                                    }else{
                                      $checked = FALSE;
                                    }
                                  }
                                }else{
                                  $checked = FALSE;
                                }
                                $set = array('name' => 'pemohon_syarat[]',
                                             'value' => $data->id,
                                             'checked' => $checked,
                                             'onClick' => 'cekSyarat()',
                                             'id' => 'chek',
                                             'required' => 'required'
                                             );
                                echo form_checkbox($set);
                              }
                              ?>
                            </td>
                          </tr>
                          <?php
                        }
                      }
                    }
                  }
                }else{
                  $x = 1;
                  $data_izin = 0;
                  if($list_izin_paralel) {
                    foreach ($list_izin_paralel as $row) {
                      $row_izin = new trperizinan();
                      $row_izin->get_by_id($row);
                      if($x == 1)
                        $data_izin = $row_izin->id;
                      else
                        $data_izin = $data_izin . ", " . $row_izin->id;
                      $x++;
                    }
                    $query = "select distinct(A.trsyarat_perizinan_id), B.v_syarat, B.status from trperizinan_trsyarat_perizinan as A,
                              trsyarat_perizinan as B
                              where A.trperizinan_id IN(" . $data_izin . ") and A.trsyarat_perizinan_id = B.id
                              order by B.status, B.v_syarat ";
                    $results = mysql_query($query);
                    while($rows = mysql_fetch_assoc(@$results)) {
                      $syarat_daftar = new trsyarat_perizinan();
                      $syarat_daftar->get_by_id($rows['trsyarat_perizinan_id']);
                      /* Baca beberapa status yang di-parse menjadi biner dan dikonvert jadi desimal */
                      $show_syarat = new trperizinan_syarat();
                      $show_syarat->where('trsyarat_perizinan_id', $rows['trsyarat_perizinan_id'])->get();
                      $var = $show_syarat->c_show_type;
                      $stat_wajib = $show_syarat->status;
                  
                      //$rule = strval(decbin($var));
                      //if (strlen($rule) < 4) {
                      //    $len = 4 - strlen($rule);
                      //    $rule = str_repeat("0", $len) . $rule;
                      //}
                      //$arr_rule = str_split($rule);
                      //$c_daftar_ulang = $arr_rule[0];
                      //$c_baru = $arr_rule[1];
                      //$c_perpanjangan = $arr_rule[2];
                      //$c_ubah = $arr_rule[3];
                  
                      $rule = strval(decbin($var));
                      if($show_syarat->status_new == 1) $plv = 6; else $plv = 4; // penambahan pencabutan dan penutupan ditambah 00
                      if(strlen($rule) < $plv) {
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
                      
                      $syarat_status = $c_baru;
                      if($syarat_status == '1') {
                        $i++;
                        ?>
                        <tr>
                          <td align="center"><?php echo $i; ?></td>
                          <td><?php echo $syarat_daftar->v_syarat; ?></td>
                          <td align="center">
                            <?php
                            $set = array('name' => 'pemohon_syarat[]',
                                         'value' => $syarat_daftar->id,
                                         'onClick' => 'cekSyarat()',
                                         'required' => 'required'
                                         );
                            echo form_checkbox($set);
                            ?>
                          </td>
                          <td align="center">
                            <?php
                            //if ($syarat_daftar->status == "1")
                            if ($stat_wajib == "1")
                              $status_data = "Wajib";
                            else
                              $status_data = "Tidak Wajib";
                            echo form_label($status_data);
                            ?>
                          </td>
                        </tr>
                        <?php
                      }
                    }
                  }
                }
                ?>
                              <?php
                            
              $SCRIPT_FILENAME = $_SERVER['SCRIPT_FILENAME'];
              $SCRIPT_NAME = $_SERVER['SCRIPT_NAME'];
              if (strpos($SCRIPT_FILENAME, 'backoffice/index.php') !== false) {
                  // Kalau mengandung 'index.php', kita hapus semua 'index.php'-nya
                  $portal_path = str_replace('backoffice/index.php', '', $SCRIPT_FILENAME);
              } else {
                  // Kalau nggak ada, tetapin aja
                  $portal_path = $SCRIPT_FILENAME;
              }

              if (strpos($SCRIPT_FILENAME, 'index.php') !== false) {
                  // Kalau mengandung 'index.php', kita hapus semua 'index.php'-nya
                  $backoffice_path = str_replace('index.php', '', $SCRIPT_FILENAME);
              } else {
                  // Kalau nggak ada, tetapin aja
                  $backoffice_path = $SCRIPT_FILENAME;
              }

              if (strpos($SCRIPT_NAME, 'index.php') !== false) {
                  // Kalau mengandung 'index.php', kita hapus semua 'index.php'-nya
                  $route_backoffice = str_replace('index.php', '', $SCRIPT_NAME);
              } else {
                  // Kalau nggak ada, tetapin aja
                  $route_backoffice = $SCRIPT_NAME;
              }
              
              $folder_path = $portal_path."assets/userassets/pemohon/".$username_portal."/pengajuan/".$id_portal."/"; // Ganti dengan path ke folder yang kamu inginkan


              // Ambil semua file dalam folder
              $files = scandir($folder_path);

              // var_dump($_SERVER);die();
              // Loop melalui setiap file
              foreach ($files as $file) {
                  // Mengabaikan '.' dan '..' (special folder)
                  if ($file != "." && $file != "..") {
                      // // Dapatkan format file (ekstensi)
                      $file_extension = pathinfo($file, PATHINFO_EXTENSION);
                      $file_name = pathinfo($file, PATHINFO_FILENAME);

                      // // Tampilkan nama file beserta formatnya
                      // echo "Nama file: $file, Format: $file_extension<br>";
                      if($file_extension == 'jpg'){
                        $i++; ?>
                                <td align="center"><?php echo $i; ?></td>
                                <td>Pas Foto yang Dimohonkan</td>
                                <td><a href="<?php echo 'https://'.$_SERVER['HTTP_HOST'].$route_backoffice.'assets/userassets/pemohon/'.$username_portal.'/pengajuan/'.$id_portal.'/'.$file; ?>" target="_BLANK" style="color:blue">Download</a></td>
                                <td align="center">Wajib</td>
                                <td align="center">-</td>
                                <td align="center">-</td>
                                <td align="center">-</td>
                                <td align="center">                              
                                <?php
                                  if($save_method === 'update') {
                                    if(isset($check)) {
                                      foreach ($check as $dt) {
                                        if($dt == $data->id) {
                                          $checked = TRUE;
                                          break;
                                        }else{
                                          $checked = FALSE;
                                        }
                                      }
                                    }else{
                                      $checked = FALSE;
                                      if($list_daftar) {
                                        foreach ($list_daftar as $data_daftar) {
                                          $data_syarat = new tmpermohonan_trsyarat_perizinan();
                                          $data_syarat->where('tmpermohonan_id', $data_daftar->id)
                                                      ->where('trsyarat_perizinan_id', $file_name)->get();
                                          if($data_syarat->trsyarat_perizinan_id) {
                                            $checked = TRUE;
                                            break;
                                          }
                                        }
                                      }else{
                                        $checked = FALSE;
                                        break;
                                      }
                                    }
                                    $set = array('name' => 'pemohon_syarat[]',
                                                'id' => 'chek',
                                                'value' => $file_name,
                                                'checked' => $checked,
                                                'onClick' => 'cekSyarat()',
                                                'required' => 'required'
                                                );
                                    echo form_checkbox($set);
                                  }else{
                                    if(isset($check) && !empty($check)) {
                                      foreach ($check as $dt) {
                                        if($dt == $data->id) {
                                          $checked = TRUE;
                                          break;
                                        }else{
                                          $checked = FALSE;
                                        }
                                      }
                                    }else{
                                      $checked = FALSE;
                                    }
                                    $set = array('name' => 'pemohon_syarat[]',
                                                'value' => $file_name,
                                                'checked' => $checked,
                                                'onClick' => 'cekSyarat()',
                                                'id' => 'chek',
                                                'required' => 'required'
                                                );
                                    echo form_checkbox($set);
                                  }
                              ?></td>
                      <?php     
                      }
                  }
              }
              ?>
              </tbody>
            </table>
            <!-- Create PBS -->
            <div class="post"  style="color:#0000FF;">
              <div class="title" style="width:100%;text-align:center;color:#0000FF;">
                <?php
                $img_cetak = array('src' => base_url().'assets/images/icon/print.png',
                                   'alt' => 'Cetak Persyaratan Izin',
                                   'title' => 'Cetak Persyaratan Izin',
                                   'onclick' => 'parent.location=\'' . site_url('info/infoperizinan/cetak_syarat') .'/'. $jenis_izin->id. '\''
                                  );
                echo img($img_cetak);
                ?>
              </div>
            </div>
            <!-- EOF PBS -->
            <?php if (isset($jenis_izin->integrasi) && $jenis_izin->integrasi == 1) { ?>
              <br>
              <center><h2>Data Integrasi Sireon DKP Jabar</h2></center>
            <table cellpadding="0" cellspacing="0" border="1" class="display">
              <thead>
                <tr>
                  <th>No</th>
                  <th>No Pendaftaran</th>
                  <th>Nama Pemohon</th>
                  <th>Jenis</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($integrasi)) { ?>
                  <?php $nomor = 1; foreach ($integrasi as $row) { 
                    $sireon_url = base_url()."assets/sireonfile/SK_".$row->no_pendaftaran.".docx";
                    ?>
                    <td><?php echo $nomor; ?></td>
                    <td><?php echo $row->no_pendaftaran; ?></td>
                    <td><?php echo $row->pemohon; ?></td>
                    <td><?php echo $row->jenis; ?></td>
                    <td><?php echo '<a href="'.$sireon_url.'" target="_blank" style="color:blue">Download</a>'; ?></td>
                  <?php } ?>
                <?php } ?>
              </tbody>
            </table>
            <?php } ?>
          </div>
  			  <?php
        }else{
          ?>
          <div id="tabs-1" ></div>
          <div id="tabs-2" ></div>
          <div id="tabs-3" ></div>
          <?php
        }
        ?>
      </div>			
    </div>
        
    <div class="entry" style="text-align: Right;">
      <?php
      $tombol = 'Kembali';
      if($ncek) $tombol = 'Batal';
      $add_daftar = array('name' => 'submit',
                          'class' => 'submit-wrc',
                          //'content' => 'Proses Selanjutnya',
                          'type' => 'submit',
                          'value' => 'Proses Selanjutnya',
                          //'onClick' => "confirm('Menuju Proses Selanjutnya?')"
                         );
      
      $cancel_daftar = array('name' => 'button',
                             'class' => 'button-wrc',
                             'content' => $tombol,
                             'onclick' => 'parent.location=\'' . site_url('pelayanan/sementara') . '\''
                            );
      
      $opd_pengelola = $this->lib_date->opd_pengelola($jenis_izin->dinas_pengelola);
      //echo $opd_pengelola;
      if($ncek){
        if ($indeks_izin == "AKDP") {
          if ($stat_kend) { //Pajak Mati
            echo '<button type="button" class="submit-wrc" alt="Klik Untuk Informasi Lebih Lanjut" title="Klik Untuk Informasi Lebih Lanjut" onClick="cekKend()">Informasi IWKBU Kendaraan</button>';
            if($this->All || !$this->cs || $opd_pengelola){
              echo form_submit($add_daftar);
            }
          } else {
            echo '<button type="button" class="submit-wrc" style="background:red;" alt="Klik Untuk Informasi Lebih Lanjut" title="Klik Untuk Informasi Lebih Lanjut" onClick="cekKend()">Izin Belum Dapat Diproses</button>';
          }
        } else {
        	if($this->All || !$this->cs || $opd_pengelola){
            echo form_submit($add_daftar);
          }  
        }
      }
      echo form_button($cancel_daftar);
      echo form_close();
      ?>
      </br>
      <span id="coba"></span>
    </div>
        
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
            <?php echo form_open('pelayanan/sementara/asistensi'); ?>
            <input type="hidden" name="id_permohonan_portal" value="<?php echo $id_permohonan_portal; ?>">
            <input type="hidden" name="id_kembali" value="<?php echo $id_kembali; ?>">
            <input type="hidden" name="oleh" value="<?php echo $this->session_info['realname']; ?>">
            <b>
              <label style="font-size:18px;text-align:right;margin-right:10px;width:80px;margin-top:5px;">Asistensi</label>
            </b>
            <?php
            if($this->All || !$this->cs){ // selain CS
            ?>
            <input type="text" class="input-area" style="height:40px;font-size:18px;width:70%" placeholder="Pesan Anda" name="pesan" required>
            <input type="submit" class="submit-wrc" value="Kirim" style="margin-left:35px;padding:7px">
            <?php
            }
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
            ?>
          </tbody>
        </table>
        <div class="fg-toolbar ui-widget-header ui-corner-bl ui-corner-br ui-helper-clearfix">
          <div class="dataTables_info" id="pendaftaran_info"> <?php echo 'Showing '.$sho0.' to '.$sho.' of '.$sho.' entries' ?></div>
          <div class="dataTables_paginate fg-buttonset fg-buttonset-multi paging_full_numbers" id="pendaftaran_paginate"></div>
        </div>
      </div>
    </div>
      
    <div class="entry" style="text-align: Right;">
      <?php
      if ($editable == 1) {
        $revisi = array('name' => 'button',
                      'class' => 'button-wrc',
                      'style' => "background: #00cc00;",
                      'content' => 'Kirim Notifikasi Ke Pemohon',
                      'onclick' => "if (confirm('Kirim Notifikasi Ke Pemohon?')) parent.location='" . site_url('pelayanan/sementara/revisi/'.$id_permohonan_portal. "/" .$id_kembali) . "'"
                     );
      } else {
        $revisi = array('name' => 'button',
                      'class' => 'button-wrc',
                      'content' => 'Kirim Notifikasi Ke Pemohon',
                      'onclick' => "if (confirm('Kirim Notifikasi Ke Pemohon?')) parent.location='" . site_url('pelayanan/sementara/revisi/'.$id_permohonan_portal. "/" .$id_kembali) . "'"
                     );
      }
      //if($ncek){ // khusus ! TimTeknis
      if($this->All || !$this->cs){
    	  echo form_button($revisi);
      }
      ?>
      </br>
      <span id="coba"></span>
    </div>

    <div class="entry" style="text-align: right;">
    *Informasi Tombol :<br>
    <p style="color: #0054A5;">Biru - Tidak ada informasi revisi di pemohon / Informasi revisi belum dikirim ke pemohon</p>
    <p style="color: #00cc00;">Hijau - Ada revisi di pemohon / Informasi revisi sudah dikirim ke pemohon</p>
    </div>
    
  </div>
  <br style="clear: both;" />
</div>

<script type="text/javascript">
    function upObjek() {
      var objek = $('#lok_izin').val();
      var id_ol = '<?php echo $id_daftar_ol; ?>';
      var site = '<?php echo base_url()?>pelayanan/sementara/edit_objek';

      $.ajax({
              url:site,
              type: 'post',
              data: {objek : objek, id_ol : id_ol},
              success: function(data) {
                  const eR = $.parseJSON(data);

                  if (eR.status == 1) {
                    $('#lok_izin').val(eR.objek);
                    alert('Berhasil Ubah Data Objek!');
                    location.reload();
                  } else {
                    alert('Gagal Ubah Data Objek!');
                  }
              },
              error: function(xhr, textStatus, errorThrown){
                 console.log(errorThrown);
              }
          });
    }
  </script>

<?php if ($indeks_izin == "AKDP") { 
  $arrno = explode(" / ", $lokasi_izin);
  $nokend = $arrno[0];
  echo $nokend;

  ?>
  <script type="text/javascript">
    function cekKend() {
      var nokend = "<?php echo $nokend; ?>";
      var site = '<?php echo base_url()?>pelayanan/sementara/cek_detail_kend';
      var cat = "DISHUB_IWKBU";
      var key = "02145dKrW";

      $.ajax({
              url:site,
              type: 'post',
              data: {nokend : nokend, cat : cat, ApiKey : key},
              success: function(data) {
                  const eR = $.parseJSON(data);

                  //console.log(eR);
                  if (eR.ketemu == 1) {
                    if (eR.status == 1) {
                      alert(
                          'IWKBU '+nokend+' sudah Kedaluarsa ! '+'\n\n'+
                          'Nama PO : '+eR.nama_po+'\n'+
                          'Tarif Per Bulan : '+eR.tarif_per_bulan+'\n'+
                          'Tanggal Transaksi : '+eR.tgl_transaksi+'\n'+
                          'Tanggal Mati Akhir : '+eR.tgl_mati_akhir+'\n'+
                          'Nominal Penlunasan : '+eR.nominal_pelunasan+'\n'+
                          'Deskripsi : '+eR.deskripsi
                          );
                    } else {
                      alert(
                          'Informasi IWKBU ! '+nokend+'\n\n'+
                          'Nama PO : '+eR.nama_po+'\n'+
                          'Tarif Per Bulan : '+eR.tarif_per_bulan+'\n'+
                          'Tanggal Transaksi : '+eR.tgl_transaksi+'\n'+
                          'Tanggal Mati Akhir : '+eR.tgl_mati_akhir+'\n'+
                          'Nominal Pelunasan : '+eR.nominal_pelunasan+'\n'+
                          'Deskripsi : '+eR.deskripsi
                          );
                    }
                  } else {
                    alert('Data Kendaraan Tidak Ditemukan!');
                  }
              },
              error: function(xhr, textStatus, errorThrown){
                 console.log(errorThrown);
              }
          });
    }
  </script>
<?php } ?>


<!--validasi-->
<script type="text/javascript">

  // function beforeSubmit() {
  //   if(confirm("Apakah anda yakin untuk melanjutkan ke proses Selanjutnya?")) {
  //     return true;
  //   } 
  //   return false;
  // }

  <?php $no = $i; ?>

  $(function() {
    var tabs = $( "#tabs" ).tabs({
        select: function(event, ui){
          var a = document.getElementsByName("pemohon_syarat[]");
          var jml ='<?php echo $no; ?>';
          var group ='<?php echo $group; ?>';
          var kembali ='<?php echo $id_link; ?>';
          var total=0;
          for(var i=0; i < jml; i++){
            if(a[i].checked){
              total++;
            }
          }
          if (total != jml) {
            $('#test').html('Data Persyaratan Belum Tercentang Seluruhnya!');
          } else {
            $('#test').html('');
          }          
        }
    });
  });

  function cekSyarat() {
    var a = document.getElementsByName("pemohon_syarat[]");
    var jml ='<?php echo $no; ?>';

    var total=0;
          for(var i=0; i < jml; i++){
            if(a[i].checked){
              total++;
            }
          }

    if (total == jml) {
      $('#test').html('');
    }
  }

  // $.validator.addMethod('notSelect', function(value, element){
  //   return (value !=0);
  // },'Pilih Opsi Yang Tersedia');
  
  var site = '<?php echo base_url(); ?>';
  <?php
  //if($save_method == "save") {
    ?>
    // $("#form").validate({
    //   onkeyup: false,        
    //   rules:{
    //     no_refer:{
    //       remote:{
    //         url: site + "pemohon/register_id_exist",
    //         type:"post",
    //         data:{
    //           no_refer: function(){
    //             return $("#no_refer").val();
    //           }
    //         }
    //       }
    //     },
    //     npwp:{
    //       remote:{
    //         url: site + "perusahaan/register_npwp_exist",
    //         type:"post",
    //         data:{
    //           npwp: function(){
    //             return $("#npwp").val();
    //           }
    //         }
    //       }
    //     }
    //   },
    //   messages:{
    //     no_refer:{
    //       remote:'No referensi sudah digunakan!'
    //     }
    //     //,
    //     //npwp:{
    //     //    remote:'No NPWP sudah digunakan!'
    //     //}
    //   }
    // });
    <?php 
  //} 
  ?>
</script>