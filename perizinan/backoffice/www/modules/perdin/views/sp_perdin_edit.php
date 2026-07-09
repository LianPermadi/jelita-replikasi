<?php 
 
  //   if(!empty($lokasi)){
  //    $lokasi       = print_r($lokasi[0]);
  //     // var_dump($lokasi);die();
  // }else{
  //     $lokasi       = "";
  // }
    // $iduser = $this->session->userdata('id_auth');
    // if($iduser == 680){
    // var_dump($analis_hukum);die();
    // }
 ?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
      <?php } ?>

      <?php 
        $alert = $this->session->flashdata("gagal");
        if(!empty($alert)){
      ?>
        <br>
        <div style="color: red; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;"><center><?php echo $alert; ?></center></div>
      <?php } ?>
   
    <div class="entry">
      <h3>Keterangan <br>1. Silahkan Menggunakan Kertas F4 (21 cm x 33 cm atau 8.27 inci x 12.99 inci)
        <br>2. Tambahkan <span style="color:red;">${no_surat}</span> pada bagian Nomor Surat SP Perjalanan Dinas untuk menambahkan Nomor Surat
        <br>3. Upload file berupa .doc/docx
        <br>note : 
        <h3>
      <!-- <span style="color:red;">*</span><h3>Tambahkan ${no_surat} pada SP Perjalanan Dinas untuk menambahkan Nomor Surat</h3> -->
        <div id="tabs">
          <ul>
              <li><a href="#tabs-<?php echo $perdin_grup->id_pegawai?>">  ubah data </a></li>
              <li><a href="#tabs-2">list-pemberangkatan</a></li>
          </ul>
                
                    <div id="tabs-<?php echo $perdin_grup->id_pegawai?>">
                        <form method="post" action="<?php echo site_url().'perdin/update/'.$perdin_grup->no_grup_perdin.'/'.$perdin_grup->id_tim; ?>" enctype="multipart/form-data">

                            <table cellpadding="0" cellspacing="0" border="0" class="display">
                            <input type="text" name="no_grup_perdin" style="display:none;" class="input-wrc" value="<?php echo $perdin_grup->no_grup_perdin ?>">

                            <input type="text" name="id_perdin"  class="input-wrc" value="<?php echo $perdin_grup->id ?>" hidden>
                            <tbody>
                                <!-- <tr>
                                <td align="left" width="15%" class="bg-grid">
                                    <b>Tanda Tangan Sendiri?</b>
                                </td>
                                <td class="bg-grid">
                                    <div class="contentForm">
                                    <input type="radio" name="ttd_sendiri" value="1" />Ya
                                    <input type="radio" name="ttd_sendiri" value="0" checked/>Tidak
                                    </div>
                                </td>
                                </tr> -->
                                <tr>
                                    <td align="left" width="15%" class="bg-grid">
                                        <b>Tujuan Pemberangkatan Ke Berapa Titik Lokasi?</b>
                                    </td>
                                    <td>
                                        <?php if ($user_id == 182) { ?>
                                            <select class="pilihan" id="titik_lokasi" style="width: 100%;" disabled>
                                                <option value="1" <?= ($perdin_grup->titik_lokasi == 1) ? 'selected' : ''; ?>>1</option>
                                                <option value="2" <?= ($perdin_grup->titik_lokasi == 2) ? 'selected' : ''; ?>>2</option>
                                                <option value="3" <?= ($perdin_grup->titik_lokasi == 3) ? 'selected' : ''; ?>>3</option>
                                            </select>
                                            <!-- Menyimpan nilai titik_lokasi dalam input hidden agar tetap dikirim -->
                                            <input type="hidden" name="titik_lokasi" value="<?= $perdin_grup->titik_lokasi; ?>">
                                        <?php } else { ?>
                                            <select class="pilihan" name="titik_lokasi" id="titik_lokasi" style="width: 100%;" onchange="jumlah_Tujuan_Pemberangkatan()">
                                                <option value="1" <?= ($perdin_grup->titik_lokasi == 1) ? 'selected' : ''; ?>>1</option>
                                                <option value="2" <?= ($perdin_grup->titik_lokasi == 2) ? 'selected' : ''; ?>>2</option>
                                                <option value="3" <?= ($perdin_grup->titik_lokasi == 3) ? 'selected' : ''; ?>>3</option>
                                            </select>
                                        <?php } ?>
                                    </td>
                                </tr>


                                <tr>
                                <td align="left" width="15%">
                                    <b>Tujuan Keberangkatan</b>
                                    
                                </td>
                                <td>
                                      <?php if ($user_id == 182) { ?>
                                          <select style="width: 100%;" class="nama_kabupaten_kota" name="kabupaten[]" multiple id="kabupaten_select" onchange="tujuan_berangkat()" disabled>
                                              <?php foreach ($kabupaten as $rowlist) { ?>
                                                  <?php 
                                                      $kabupaten_array = isset($tujuan_keberangkatan_perdin[0]->kab_kota) ? json_decode($tujuan_keberangkatan_perdin[0]->kab_kota) : [];
                                                      if (is_array($kabupaten_array)) {
                                                          $kabupaten_array = array_map('strtoupper', $kabupaten_array);
                                                      } else {
                                                          $kabupaten_array = [];
                                                      }
                                                  ?>
                                                  <option value="<?php echo $rowlist->id; ?>" 
                                                      <?php echo (in_array(strtoupper($rowlist->n_kabupaten), $kabupaten_array)) ? 'selected' : ''; ?>>
                                                      <?php echo $rowlist->n_kabupaten; ?>
                                                  </option>
                                              <?php } ?>
                                          </select>

                                          <!-- Input hidden untuk mengirimkan nilai yang dipilih -->
                                          <?php foreach ($kabupaten_array as $selected_value) { ?>
                                              <?php
                                              // Cari ID kabupaten berdasarkan nama
                                              $kabupaten_id = null;
                                              foreach ($kabupaten as $rowlist) {
                                                  if (strtoupper($rowlist->n_kabupaten) === strtoupper($selected_value)) {
                                                      $kabupaten_id = $rowlist->id;
                                                      break;
                                                  }
                                              }
                                              ?>
                                              <!-- Gunakan ID kabupaten pada value -->
                                              <input type="hidden" name="kabupaten[]" value="<?php echo $kabupaten_id; ?>" id="hidden_kabupaten_<?php echo $kabupaten_id; ?>">
                                          <?php } ?>


                                          <?php } else { ?>
                                            <select style="width: 100%;" class="nama_kabupaten_kota " name="kabupaten[]" multiple  id="kabupaten_select" onchange="tujuan_berangkat()" >
                                                <?php foreach ($kabupaten as $rowlist) { ?>
                                                    
                                                  <?php 
                                                      // Cek apakah kab_kota ada dan dalam format yang benar
                                                      $kabupaten_array = isset($tujuan_keberangkatan_perdin[0]->kab_kota) ? json_decode($tujuan_keberangkatan_perdin[0]->kab_kota) : [];
                                                      // var_dump($kabupaten_array);die();
                                                      if (is_array($kabupaten_array)) {
                                                          // Mengubah semua elemen array menjadi huruf besar
                                                          $kabupaten_array = array_map('strtoupper', $kabupaten_array);
                                                      } else {
                                                          $kabupaten_array = []; // Jika kab_kota tidak valid, set array kosong
                                                      }
                                                      ?>

                                                      <option value="<?php echo $rowlist->id; ?>" 
                                                          <?php echo (in_array(strtoupper($rowlist->n_kabupaten), $kabupaten_array)) ? 'selected' : ''; ?>>
                                                          <?php echo $rowlist->n_kabupaten; ?>
                                                      </option>

                                          <?php } ?>
                                        <?php } ?>

                                  </td>
                                  <tr id="Detail_Tempat_Keberangkatan_1">
                                        <td align="left" width="15%" class="bg-grid">
                                            <b>Detail Tempat tujuan 1</b>
                                        </td>
                                        <td class="bg-grid">
                                            <?php 
                                            $tempat_input = array(
                                                'name' => 'detail_tempat_1',
                                                'id' => 'tempatberangkat1',
                                                'value' => $detail_tempat_1,
                                                'class' => 'input-wrc',
                                                'style' => "width:100%"
                                            );
                                            echo form_input($tempat_input);
                                            ?>
                                        </td>
                                    </tr>
                                  <tr id="Tanggal_Keberangkatan_1">
                                      <td align="left" width="15%" class="bg-grid">
                                          <b>Tanggal Keberangkatan 1</b>
                                      </td>
                                        <td class="bg-grid">
                                        <?php 
                                          // Jika user_id == 182, tampilkan input disabled dan hidden input
                                          if ($user_id == 182) {
                                              // Input disabled untuk tanggal kepulangan
                                              echo '<input type="text" name="tglberangkat" value="' . ($tanggal_berangkat_1 !== '0000-00-00' && !empty($tanggal_berangkat_1) ? $tanggal_berangkat_1 : '0000-00-00') . '" class="input-wrc monbulan" style="width:100%" disabled>';
                                              
                                              // Input hidden untuk mengirimkan nilai yang dipilih
                                              echo '<input type="hidden" name="tglberangkat" value="' . $tanggal_berangkat_1 . '">';
                                          } else {
                                              // Jika bukan user_id 182, gunakan input biasa
                                              $tgl_input = array(
                                                  'name' => 'tglberangkat',
                                                  'value' => ($tanggal_berangkat_1 !== '0000-00-00' && !empty($tanggal_berangkat_1)) ? $tanggal_berangkat_1 : '0000-00-00',
                                                  'class' => 'input-wrc monbulan',
                                                  'style' => "width:100%",
                                              );
                                              echo form_input($tgl_input);
                                          }
                                          ?>
                                        </td>

                                  </tr>
                                  <tr id="Tanggal_Kepulangan_1">
                                      <td align="left" width="15%">
                                          <b>Tanggal Kepulangan 1</b>
                                      </td>
                                      <td>
                                          <?php 
                                          // Jika user_id == 182, tampilkan input disabled dan hidden input
                                          if ($user_id == 182) {
                                              // Input disabled untuk tanggal kepulangan
                                              echo '<input type="text" name="tglkembali" value="' . ($tanggal_pulang_1 !== '0000-00-00' && !empty($tanggal_pulang_1) ? $tanggal_pulang_1 : '0000-00-00') . '" class="input-wrc monbulan" style="width:100%" disabled>';
                                              
                                              // Input hidden untuk mengirimkan nilai yang dipilih
                                              echo '<input type="hidden" name="tglkembali" value="' . $tanggal_pulang_1 . '">';
                                          } else {
                                              // Jika bukan user_id 182, gunakan input biasa
                                              $tgl_input = array(
                                                  'name' => 'tglkembali',
                                                  'value' => ($tanggal_pulang_1 !== '0000-00-00' && !empty($tanggal_pulang_1)) ? $tanggal_pulang_1 : '0000-00-00',
                                                  'class' => 'input-wrc monbulan',
                                                  'style' => "width:100%",
                                              );
                                              echo form_input($tgl_input);
                                          }
                                          ?>
                                      </td>

                                  </tr>
                                  <tr id="Detail_Tempat_Keberangkatan_2"  style="display:none;">
                                        <td align="left" width="15%" class="bg-grid">
                                            <b>Detail Tempat tujuan 2</b>
                                        </td>
                                        <td class="bg-grid">
                                            <?php 
                                            $tempat_input = array(
                                                'name' => 'detail_tempat_2',
                                                'id' => 'tempatberangkat2',
                                                'value' => $detail_tempat_2,
                                                'class' => 'input-wrc',
                                                'style' => "width:100%"
                                            );
                                            echo form_input($tempat_input);
                                            ?>
                                        </td>
                                    </tr>
                                  <tr id="Tanggal_Keberangkatan_2" style="display:none;">
                                      <td align="left" width="15%" class="bg-grid">
                                          <b>Tanggal Keberangkatan 2</b>
                                      </td>
                                      <td class="bg-grid">
                                          <?php 
                                          // Jika user_id == 182, tampilkan input disabled dan hidden input
                                          if ($user_id == 182) {
                                              // Input disabled untuk tanggal keberangkatan 2
                                              echo '<input type="text" name="tglberangkat2" value="' . ($tanggal_berangkat_2 !== '0000-00-00' && !empty($tanggal_berangkat_2) ? $tanggal_berangkat_2 : '0000-00-00') . '" id="tglberangkat2" class="input-wrc monbulan" style="width:100%" disabled>';
                                              
                                              // Input hidden untuk mengirimkan nilai yang dipilih
                                              echo '<input type="hidden" name="tglberangkat2" value="' . $tanggal_berangkat_2 . '">';
                                          } else {
                                              // Jika bukan user_id 182, gunakan input biasa
                                              $tgl_input = array(
                                                  'name' => 'tglberangkat2',
                                                  'id' => 'tglberangkat2',
                                                  'value' => ($tanggal_berangkat_2 !== '0000-00-00' && !empty($tanggal_berangkat_2)) ? $tanggal_berangkat_2 : '0000-00-00',
                                                  'class' => 'input-wrc monbulan',
                                                  'style' => "width:100%",
                                              );
                                              echo form_input($tgl_input);
                                          }
                                          ?>
                                      </td>
                                  </tr>
                                  <tr id="Tanggal_Kepulangan_2" style="display:none;">
                                      <td align="left" width="15%">
                                          <b>Tanggal Kepulangan 2</b>
                                      </td>
                                      <td>
                                          <?php 
                                          // Jika user_id == 182, tampilkan input disabled dan hidden input
                                          if ($user_id == 182) {
                                              // Input disabled untuk tanggal kepulangan 2
                                              echo '<input type="text" name="tglkembali2" value="' . ($tanggal_pulang_2 !== '0000-00-00' && !empty($tanggal_pulang_2) ? $tanggal_pulang_2 : '0000-00-00') . '" class="input-wrc monbulan" style="width:100%" disabled>';
                                              
                                              // Input hidden untuk mengirimkan nilai yang dipilih
                                              echo '<input type="hidden" name="tglkembali2" value="' . $tanggal_pulang_2 . '">';
                                          } else {
                                              // Jika bukan user_id 182, gunakan input biasa
                                              $tgl_input = array(
                                                  'name' => 'tglkembali2',
                                                  'value' => ($tanggal_pulang_2 !== '0000-00-00' && !empty($tanggal_pulang_2)) ? $tanggal_pulang_2 : '0000-00-00',
                                                  'class' => 'input-wrc monbulan',
                                                  'style' => "width:100%",
                                              );
                                              echo form_input($tgl_input);
                                          }
                                          ?>
                                      </td>
                                  </tr>
                                  <tr id="Detail_Tempat_Keberangkatan_3"  style="display:none;">
                                        <td align="left" width="15%" class="bg-grid">
                                            <b>Detail Tempat tujuan 3</b>
                                        </td>
                                        <td class="bg-grid">
                                            <?php 
                                            $tempat_input = array(
                                                'name' => 'detail_tempat_3',
                                                'id' => 'tempatberangkat2',
                                                'value' => $detail_tempat_3,
                                                'class' => 'input-wrc',
                                                'style' => "width:100%"
                                            );
                                            echo form_input($tempat_input);
                                            ?>
                                        </td>
                                    </tr>
                                  <tr id="Tanggal_Keberangkatan_3" style="display:none;">
                                      <td align="left" width="15%" class="bg-grid">
                                          <b>Tanggal Keberangkatan 3</b>
                                      </td>
                                      <td class="bg-grid">
                                          <?php 
                                          // Jika user_id == 182, tampilkan input disabled dan hidden input
                                          if ($user_id == 182) {
                                              // Input disabled untuk tanggal keberangkatan 3
                                              echo '<input type="text" name="tglberangkat3" value="' . ($tanggal_berangkat_3 !== '0000-00-00' && !empty($tanggal_berangkat_3) ? $tanggal_berangkat_3 : '0000-00-00') . '" id="tglberangkat3" class="input-wrc monbulan" style="width:100%" disabled>';
                                              
                                              // Input hidden untuk mengirimkan nilai yang dipilih
                                              echo '<input type="hidden" name="tglberangkat3" value="' . $tanggal_berangkat_3 . '">';
                                          } else {
                                              // Jika bukan user_id 182, gunakan input biasa
                                              $tgl_input = array(
                                                  'name' => 'tglberangkat3',
                                                  'id' => 'tglberangkat3',
                                                  'value' => ($tanggal_berangkat_3 !== '0000-00-00' && !empty($tanggal_berangkat_3)) ? $tanggal_berangkat_3 : '0000-00-00',
                                                  'class' => 'input-wrc monbulan',
                                                  'style' => "width:100%",
                                              );
                                              echo form_input($tgl_input);
                                          }
                                          ?>
                                      </td>
                                  </tr>
                                  <tr id="Tanggal_Kepulangan_3" style="display:none;">
                                      <td align="left" width="15%">
                                          <b>Tanggal Kepulangan 3</b>
                                      </td>
                                      <td>
                                          <?php 
                                          // Jika user_id == 182, tampilkan input disabled dan hidden input
                                          if ($user_id == 182) {
                                              // Input disabled untuk tanggal kepulangan 3
                                              echo '<input type="text" name="tglkembali3" value="' . ($tanggal_pulang_3 !== '0000-00-00' && !empty($tanggal_pulang_3) ? $tanggal_pulang_3 : '0000-00-00') . '" class="input-wrc monbulan" style="width:100%" disabled>';
                                              
                                              // Input hidden untuk mengirimkan nilai yang dipilih
                                              echo '<input type="hidden" name="tglkembali3" value="' . $tanggal_pulang_3 . '">';
                                          } else {
                                              // Jika bukan user_id 182, gunakan input biasa
                                              $tgl_input = array(
                                                  'name' => 'tglkembali3',
                                                  'value' => ($tanggal_pulang_3 !== '0000-00-00' && !empty($tanggal_pulang_3)) ? $tanggal_pulang_3 : '0000-00-00',
                                                  'class' => 'input-wrc monbulan',
                                                  'style' => "width:100%",
                                              );
                                              echo form_input($tgl_input);
                                          }
                                          ?>
                                      </td>
                                  </tr>




                      <script>
                           function jumlah_Tujuan_Pemberangkatan() {
                                    var jumlah_tujuan = document.getElementById("titik_lokasi").value;
                                    console.log(jumlah_tujuan);

                                    // Show or hide fields based on selection
                                    if (jumlah_tujuan == 2) { // Ganti = dengan == untuk perbandingan

                                    document.getElementById("Tanggal_Keberangkatan_2").style.display = "table-row";
                                    document.getElementById("Tanggal_Kepulangan_2").style.display = "table-row";
                                    document.getElementById("Detail_Tempat_Keberangkatan_2").style.display = "table-row";


                                    
                                    } else if (jumlah_tujuan == 3) {
                                    document.getElementById("Tanggal_Keberangkatan_1").style.display = "table-row";
                                    document.getElementById("Tanggal_Kepulangan_1").style.display = "table-row";
                                    document.getElementById("Tanggal_Keberangkatan_2").style.display = "table-row";
                                    document.getElementById("Tanggal_Kepulangan_2").style.display = "table-row";

                                    document.getElementById("Tanggal_Keberangkatan_3").style.display = "table-row";
                                    document.getElementById("Tanggal_Kepulangan_3").style.display = "table-row";

                                    document.getElementById("Detail_Tempat_Keberangkatan_1").style.display = "table-row";
                                    document.getElementById("Detail_Tempat_Keberangkatan_2").style.display = "table-row";
                                    document.getElementById("Detail_Tempat_Keberangkatan_3").style.display = "table-row";

                                    } else if (jumlah_tujuan == "1") {

                                    document.getElementById("Tanggal_Keberangkatan_2").style.display = "none";
                                    document.getElementById("Tanggal_Kepulangan_2").style.display = "none";
                                    document.getElementById("Tanggal_Keberangkatan_3").style.display = "none";
                                    document.getElementById("Tanggal_Kepulangan_3").style.display = "none";

                                    document.getElementById("Detail_Tempat_Keberangkatan_2").style.display = "none";
                                    document.getElementById("Detail_Tempat_Keberangkatan_3").style.display = "none";
                                    }
                                }

                                // Pastikan fungsi ini dipanggil saat halaman selesai dimuat
                                document.addEventListener("DOMContentLoaded", function() {
                                    jumlah_Tujuan_Pemberangkatan();
                                });

                          </script>
                                     <?php if ($user_id === "121" || $user_id === "705") : ?>

                                                    <!-- Pilihan Tanggal Back Date -->
                                                            <tr>
                                                                <td align="left" width="15%" class="bg-grid">
                                                                    <b>Tanggal Back Date</b>
                                                                </td>
                                                                <td class="bg-grid">
                                                                    <select class="pilihan select-wrc" name="pilihan_backdate" id="pilihan_backdate" style="width: 100%;" onchange="toggleTanggalSPBackdate()">
                                                                        <option value="-">-</option>
                                                                        <option value="ya" <?= ($perdin_grup->pilihan_backdate == "ya") ? 'selected' : ''; ?>>ya</option>
                                                                        <option value="tidak" <?= ($perdin_grup->pilihan_backdate == "tidak") ? 'selected' : ''; ?>>tidak</option>
                                          
                                                                    </select>
                                                                </td>
                                                            </tr>

                                                            <!-- Input Tanggal Surat Perintah -->
                                                            <tr id="tanggal_sp_backdate">
                                                                <td align="left" width="15%" class="bg-grid">
                                                                    <b>Tanggal Surat Perintah</b>
                                                                </td>
                                                                <td class="bg-grid">
                                                                    <?php 
                                                                        $tgl_input = array(
                                                                            'name' => 'tanggal_sp_backdate',
                                                                            'value' => (!empty($perdin_grup->tanggal_sp_backdate) ? $perdin_grup->tanggal_sp_backdate : '0000-00-00'),
                                                                            'class' => 'input-wrc monbulan',
                                                                            'readOnly' => TRUE,
                                                                            'style' => 'width:100%',
                                                                        );
                                                                        echo form_input($tgl_input);
                                                                    ?>
                                                                </td>
                                                            </tr>

                                                            <!-- JavaScript untuk Mengontrol Tampilan Input -->
                                                            <script>
                                                            function toggleTanggalSPBackdate() {
                                                                var selectElement = document.getElementById('pilihan_backdate');
                                                                var spBackdateRow = document.getElementById('tanggal_sp_backdate');
                                                                
                                                                if (selectElement.value === 'ya') {
                                                                    spBackdateRow.style.display = '';
                                                                } else {
                                                                    spBackdateRow.style.display = 'none';
                                                                }
                                                            }
                                                            </script>

                                                <?php endif; ?>
                                <tr>
                                    <td align="left" width="15%" class="bg-grid">
                                        <b>surat undangan</b>
                                    </td>
                                    <td>
                                        <?php 
                                        // Jika user_id == 182, tampilkan select disabled dan hidden input
                                        if ($user_id == 182) {
                                            // Select disabled untuk tipe undangan
                                            echo '<select class="pilihan" name="tipe_undangan" id="tipe_undangan" style="width: 100%;" disabled>';
                                            // Menentukan nilai selected berdasarkan tipe undangan
                                            echo '<option value="1" ' . ($perdin_grup->tipe_undangan == 1 ? 'selected' : '') . '>tanpa undangan instansi</option>';
                                            echo '<option value="2" ' . ($perdin_grup->tipe_undangan == 2 ? 'selected' : '') . '>ada undangan instansi</option>';
                                            echo '<option value="3" ' . ($perdin_grup->tipe_undangan == 3 ? 'selected' : '') . '>Dasar Arahan Pimpinan</option>';
                                            echo '</select>';
                                            
                                            // Input hidden untuk mengirimkan nilai yang dipilih
                                            echo '<input type="hidden" name="tipe_undangan" value="' . $perdin_grup->tipe_undangan . '">';
                                        } else {
                                            // Jika bukan user_id 182, gunakan select biasa
                                            echo '<select class="pilihan" name="tipe_undangan" id="tipe_undangan" onchange="toggleFormFields()" style="width: 100%">';
                                            echo '<option value="1" ' . ($perdin_grup->tipe_undangan == 1 ? 'selected' : '') . '>tanpa undangan instansi</option>';
                                            echo '<option value="2" ' . ($perdin_grup->tipe_undangan == 2 ? 'selected' : '') . '>ada undangan instansi</option>';
                                            echo '<option value="3" ' . ($perdin_grup->tipe_undangan == 3 ? 'selected' : '') . '>Dasar Arahan Pimpinan</option>';
                                            echo '</select>';
                                        }
                                        ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td align="left" width="15%" class="bg-grid">
                                        <b>Dengan dinas lain ?</b>
                                    </td>
                                    <td>
                                        <?php 
                                        // Jika user_id == 182, tampilkan select disabled dan hidden input
                                        if ($user_id == 182) {
                                            // Select disabled untuk dinas lain
                                            echo '<select class="pilihan" name="pegawai_dinas_lain" id="pegawai_dinas_lain" style="width: 100%;" disabled>';
                                            // Menentukan nilai selected berdasarkan kondisi
                                            echo '<option value="2" ' . ($perdin_grup->pegawai_dinas_lain == 2 ? 'selected' : '') . '>Tidak</option>';
                                            echo '<option value="1" ' . ($perdin_grup->pegawai_dinas_lain == 1 ? 'selected' : '') . '>Ya</option>';
                                            echo '</select>';
                                            
                                            // Input hidden untuk mengirimkan nilai yang dipilih
                                            echo '<input type="hidden" name="pegawai_dinas_lain" value="' . $perdin_grup->pegawai_dinas_lain . '">';
                                        } else {
                                            // Jika bukan user_id 182, gunakan select biasa
                                            echo '<select class="pilihan" name="pegawai_dinas_lain" id="pegawai_dinas_lain" onchange="file_surat()" style="width: 100%">';
                                            echo '<option value="2" ' . ($perdin_grup->pegawai_dinas_lain == 2 ? 'selected' : '') . '>Tidak</option>';
                                            echo '<option value="1" ' . ($perdin_grup->pegawai_dinas_lain == 1 ? 'selected' : '') . '>Ya</option>';
                                            echo '</select>';
                                        }
                                        ?>
                                    </td>
                                </tr>

                                <!-- Dasar SP Arahan Pimpinan -->
                                <tr id="dasar_arahan_row" style="display:none;">
                                    <td align="left" width="15%" class="bg-grid">
                                        <b>Dasar SP Arahan Pimpinan</b>
                                    </td>
                                    <td>
                                        <?php 
                                        if ($user_id == 182) {
                                            // Jika user_id == 182, buat input text menjadi readonly dan masukkan hidden input
                                            echo '<input type="text" name="dasar_arahan_pimpiman" style="width:100%" class="input-wrc" value="' . (isset($perdin_grup->dasar_arahan_pimpiman) ? $perdin_grup->dasar_arahan_pimpiman : '') . '" readonly>';
                                            echo '<input type="hidden" name="dasar_arahan_pimpiman" value="' . (isset($perdin_grup->dasar_arahan_pimpiman) ? $perdin_grup->dasar_arahan_pimpiman : '') . '">';
                                        } else {
                                            // Jika bukan user_id 182, input bisa diedit
                                            echo '<input type="text" name="dasar_arahan_pimpiman" style="width:100%" class="input-wrc" value="' . (isset($perdin_grup->dasar_arahan_pimpiman) ? $perdin_grup->dasar_arahan_pimpiman : '') . '">';
                                        }
                                        ?>
                                    </td>
                                </tr>

                                <!-- Surat Undangan dari Instansi -->
                                <tr id="srt_instansi_undangan_row" style="display:none;">
                                    <td align="left" width="15%" class="bg-grid">
                                        <b>surat undangan dari instansi</b>
                                    </td>
                                    <td class="bg-grid">
                                        <?php 
                                        if ($user_id == 182) {
                                            // Jika user_id == 182, buat input text menjadi readonly dan masukkan hidden input
                                            echo '<input type="text" name="srt_instansi_undangan" style="width:100%" class="input-wrc" value="' . (isset($perdin_grup->srt_instansi_undangan) ? $perdin_grup->srt_instansi_undangan : '') . '" readonly>';
                                            echo '<input type="hidden" name="srt_instansi_undangan" value="' . (isset($perdin_grup->srt_instansi_undangan) ? $perdin_grup->srt_instansi_undangan : '') . '">';
                                        } else {
                                            // Jika bukan user_id 182, input bisa diedit
                                            echo '<input type="text" name="srt_instansi_undangan" style="width:100%" class="input-wrc" value="' . (isset($perdin_grup->srt_instansi_undangan) ? $perdin_grup->srt_instansi_undangan : '') . '">';
                                        }
                                        ?>
                                    </td>
                                </tr>

                              <!-- Nomor Surat Undangan -->
                                <tr id="nmr_undangan_row" style="display:none;">
                                    <td align="left" width="15%" class="bg-grid">
                                        <b>Nomor Surat Undangan</b>
                                    </td>
                                    <td class="bg-grid">
                                        <?php 
                                        if ($user_id == 182) {
                                            // Jika user_id == 182, buat input text menjadi readonly dan masukkan hidden input
                                            echo '<input type="text" name="nmr_srt_undangan" style="width:100%" class="input-wrc" value="' . (isset($perdin_grup->nmr_srt_undangan) ? $perdin_grup->nmr_srt_undangan : '') . '" readonly>';
                                            echo '<input type="hidden" name="nmr_srt_undangan" value="' . (isset($perdin_grup->nmr_srt_undangan) ? $perdin_grup->nmr_srt_undangan : '') . '">';
                                        } else {
                                            // Jika bukan user_id 182, input bisa diedit
                                            echo '<input type="text" name="nmr_srt_undangan" style="width:100%" class="input-wrc" value="' . (isset($perdin_grup->nmr_srt_undangan) ? $perdin_grup->nmr_srt_undangan : '') . '">';
                                        }
                                        ?>
                                    </td>
                                </tr>

                                <!-- Tanggal Surat Undangan -->
                                <tr id="tgl_undangan_row" style="display:none;">
                                    <td align="left" width="15%" class="bg-grid">
                                        <b>Tanggal Surat Undangan</b>
                                    </td>
                                    <td class="bg-grid">
                                        <?php 
                                        $tgl_input = array(
                                            'name' => 'tgl_srt_undangan',
                                            'value' => (!empty($perdin_grup->tgl_srt_undangan)) ? $perdin_grup->tgl_srt_undangan : date('Y-m-d'), // Use $perdin_grup['tgl_srt_undangan']
                                            'class' => 'input-wrc',
                                            'readOnly' => TRUE,
                                            'style' => "width:100%",
                                            'class' => 'monbulan'
                                        );
                                        
                                        if ($user_id == 182) {
                                            // Jika user_id == 182, buat input menjadi readonly
                                            $tgl_input['readonly'] = TRUE;
                                            echo form_input($tgl_input);
                                            echo '<input type="hidden" name="tgl_srt_undangan" value="' . (isset($perdin_grup->tgl_srt_undangan) ? $perdin_grup->tgl_srt_undangan : date('Y-m-d')) . '">';
                                        } else {
                                            // Jika bukan user_id 182, input bisa diedit
                                            echo form_input($tgl_input);
                                        }
                                        ?>
                                    </td>
                                </tr>

                               <!-- Perihal Surat Undangan -->
                              <tr id="perihal_undangan_row" style="display:none;">
                                  <td align="left" width="15%" class="bg-grid">
                                      <b>Perihal Surat Undangan</b>
                                  </td>
                                  <td class="bg-grid">
                                      <?php 
                                      if ($user_id == 182) {
                                          // Jika user_id == 182, buat input text menjadi readonly
                                          echo '<input type="text" name="perihal_srt_undangan" style="width:100%" class="input-wrc" value="' . (isset($perdin_grup->perihal_srt_undangan) ? $perdin_grup->perihal_srt_undangan : '') . '" readonly>';
                                      } else {
                                          // Jika bukan user_id 182, input bisa diedit
                                          echo '<input type="text" name="perihal_srt_undangan" style="width:100%" class="input-wrc" value="' . (isset($perdin_grup->perihal_srt_undangan) ? $perdin_grup->perihal_srt_undangan : '') . '">';
                                      }
                                      ?>
                                  </td>
                              </tr>

                              <!-- Kode Rek dan Sub Req -->
                              <tr>
                                  <td align="left" width="15%" class="bg-grid">
                                      <b>Kode Rek dan Sub Req</b>
                                  </td>
                                  <td>
                                      <?php 
                                      if ($user_id == 182) {
                                          // Jika user_id == 182, buat select dan input menjadi readonly dan hidden
                                          echo '<select name="kode_rek_sub_req" id="kode_rek_sub_req" disabled>';
                                          echo '<option value="-" selected>-</option>';
                                          foreach ($surat_kode_reg as $kode_reg) {
                                              echo '<option value="' . $kode_reg->kode_sub_ring . ' ' . $kode_reg->uraian_sub_kegiatan . '"';
                                              echo (($kode_reg->kode_sub_ring . ' ' . $kode_reg->uraian_sub_kegiatan) == $perdin_grup->kode_rek_sub_req) ? 'selected' : '';
                                              echo '>' . $kode_reg->kode_sub_ring . ' ' . $kode_reg->uraian_sub_kegiatan . '</option>';
                                          }
                                          echo '</select>';
                                          // Input hidden untuk mengirimkan nilai
                                          echo '<input type="text" name="kode_rek_sub_req" style="width:100%" class="input-wrc" value="' . (isset($perdin_grup->kode_rek_sub_req) ? $perdin_grup->kode_rek_sub_req : '') . '" id="selected_value_2" hidden>';

                                          echo '<input type="text" name="kode_rek" style="width:100%" class="input-wrc" value="' . (isset($perdin_grup->kode_rek) ? $perdin_grup->kode_rek : '') . '" id="selected_value_2" hidden>';
                                      } else {
                                          // Jika bukan user_id 182, select bisa diedit
                                          echo '<select name="kode_rek_sub_req" id="kode_rek_sub_req">';
                                          echo '<option value="-" selected>-</option>';
                                          foreach ($surat_kode_reg as $kode_reg) {
                                              echo '<option value="' . $kode_reg->kode_sub_ring . ' ' . $kode_reg->uraian_sub_kegiatan . '"';
                                              echo (($kode_reg->kode_sub_ring . ' ' . $kode_reg->uraian_sub_kegiatan) == $perdin_grup->kode_rek_sub_req) ? 'selected' : '';
                                              echo '>' . $kode_reg->kode_sub_ring . ' ' . $kode_reg->uraian_sub_kegiatan . '</option>';
                                          }
                                          echo '</select>';
                                          // Input text yang bisa diedit, hidden tetap ada untuk mengirimkan nilai
                                          echo '<input type="text" name="kode_rek" style="width:100%" class="input-wrc" value="' . (isset($perdin_grup->kode_rek) ? $perdin_grup->kode_rek : '') . '" id="selected_value_2" hidden>';
                                      }
                                      ?>
                                  </td>
                              </tr>


                      <script>
                          // When the user selects an option from the dropdown
                          $('#kode_rek_sub_req').change(function() {
                              var selectedValue = $(this).val();  // Get the full value (kode_ring + uraian_kegiatan)
                              var kodeRing = selectedValue.split(' ')[0];  // Extract only the kode_ring (first part)
                              $('#selected_value_2').val(kodeRing);  // Insert the kode_ring into the input field
                          });
                      </script>


                    <script>
                        // Display the selected kode_ring for the select dropdown
                        $('#kode_rek_sub_req').change(function() {
                            var selectedValue = $(this).val();  // Get the full value (kode_ring + uraian_kegiatan)
                            var kodeRing = selectedValue.split(' ')[0];  // Extract only the kode_ring (first part)
                            $('#selected_value_2').text(kodeRing);  // Display the kode_ring
                        });
                    </script>
                              <tr>
                                  <td align="left" width="15%" class="bg-grid">
                                      <b>Kendaraan yang digunakan</b>
                                  </td>
                                  <td>
                                      <?php 
                                      if ($user_id == 182) {
                                          // Jika user_id == 182, buat select menjadi readonly (disabled)
                                          echo '<select  name="kendaraan" id="kendaraan" class="pilihan" style="width: 100%;" disabled>';
                                          echo '<option value="-">-</option>';
                                          echo '<option value="Kendaraan Dinas" ' . (($perdin_grup->kendaraan == 'Kendaraan Dinas') ? 'selected' : '') . '>Kendaraan Dinas</option>';
                                          echo '<option value="Kendaraan Umum" ' . (($perdin_grup->kendaraan == 'Kendaraan Umum') ? 'selected' : '') . '>Kendaraan Umum</option>';
                                          echo '<option value="Kendaraan Pribadi" ' . (($perdin_grup->kendaraan == 'Kendaraan Pribadi') ? 'selected' : '') . '>Kendaraan Pribadi</option>';
                                          echo '</select>';
                                      } else {
                                          // Jika bukan user_id == 182, select bisa diedit
                                          echo '<select name="kendaraan" id="kendaraan" class="select-wrc" style="width: 100%;">';
                                          echo '<option value="-">-</option>';
                                          echo '<option value="Kendaraan Dinas" ' . (($perdin_grup->kendaraan == 'Kendaraan Dinas') ? 'selected' : '') . '>Kendaraan Dinas</option>';
                                          echo '<option value="Kendaraan Umum" ' . (($perdin_grup->kendaraan == 'Kendaraan Umum') ? 'selected' : '') . '>Kendaraan Umum</option>';
                                          echo '<option value="Kendaraan Pribadi" ' . (($perdin_grup->kendaraan == 'Kendaraan Pribadi') ? 'selected' : '') . '>Kendaraan Pribadi</option>';
                                          echo '</select>';
                                      }
                                      ?>
                                  </td>
                              </tr>

                              <tr>
                                  <td align="left" width="15%" class="bg-grid">
                                      <b>Pegawai yang berangkat</b>
                                  </td>
                                  <td>
                                      <?php 
                                      // Jika user_id == 182, buat select menjadi readonly (disabled)
                                      if ($user_id == 182) {
                                          echo '<select id="listizin" name="listizin[]" multiple="multiple" size="5" style="width: 85%;" >';

                                          // Jika sedang dalam mode update (edit data)
                                          if ($step === "update") {
                                              $selectedIds = [];
                                              foreach ($perdin_no_grup as $rowlist) {
                                                  $selectedIds[] = $rowlist->id_pegawai;
                                              }

                                              foreach ($list as $data) {
                                                  $selected = in_array($data->id, $selectedIds) ? 'selected' : '';
                                                  echo "<option style='width:100%' value='" . $data->id . "' $selected>" 
                                                      . $data->n_pegawai . " | " . $data->nip . " | " . $data->pangkat_gol . " | " . $data->n_jabatan 
                                                      . "</option>";
                                              }
                                          } else {
                                              foreach ($list as $data) {
                                                  echo "<option style='width:100%' value='" . $data->id . "'>" 
                                                      . $data->n_pegawai . " | " . $data->nip . " | " . $data->pangkat_gol . " | " . $data->n_jabatan 
                                                      . "</option>";
                                              }
                                          }

                                          echo '</select>';
                                      } else {
                                          echo '<select id="listizin" name="listizin[]" multiple="multiple" size="5" style="width: 85%;">';

                                          // Jika sedang dalam mode update (edit data)
                                          if ($step === "update") {
                                              $selectedIds = [];
                                              foreach ($perdin_no_grup as $rowlist) {
                                                  $selectedIds[] = $rowlist->id_pegawai;
                                              }

                                              foreach ($list as $data) {
                                                  $selected = in_array($data->id, $selectedIds) ? 'selected' : '';
                                                  echo "<option style='width:100%' value='" . $data->id . "' $selected>" 
                                                      . $data->n_pegawai . " | " . $data->nip . " | " . $data->pangkat_gol . " | " . $data->n_jabatan 
                                                      . "</option>";
                                              }
                                          } else {
                                              foreach ($list as $data) {
                                                  echo "<option style='width:100%' value='" . $data->id . "'>" 
                                                      . $data->n_pegawai . " | " . $data->nip . " | " . $data->pangkat_gol . " | " . $data->n_jabatan 
                                                      . "</option>";
                                              }
                                          }

                                          echo '</select>';
                                      }
                                      ?>
                                  </td>
                              </tr>

                                <tr>
                                    <td align="left" width="15%" class="bg-grid">
                                        <b>Tim Pemberangkatan</b>
                                    </td>
                                    <td>
                                        <?php 
                                        // Jika user_id == 182, buat select menjadi readonly (disabled)
                                        if ($user_id == 182) {
                                            echo '<select class="pilihan" name="id_tim" id="list_tim" disabled>';
                                            echo '<option value="-" selected>-</option>';

                                            foreach ($list_tims as $list_tim) {
                                                $selected = ($list_tim->id == $perdin_grup->id_tim) ? 'selected' : '';
                                                echo "<option value='" . $list_tim->id . "' $selected>" . $list_tim->nama_tim . "</option>";
                                            }

                                            echo '</select>';
                                        } else {
                                            echo '<select class="pilihan" name="id_tim" id="list_tim">';
                                            echo '<option value="-" selected>-</option>';

                                            foreach ($list_tims as $list_tim) {
                                                $selected = ($list_tim->id == $perdin_grup->id_tim) ? 'selected' : '';
                                                echo "<option value='" . $list_tim->id . "' $selected>" . $list_tim->nama_tim . "</option>";
                                            }

                                            echo '</select>';
                                        }
                                        ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td align="left" width="15%" class="bg-grid">
                                        <b>Maksud Pemberangkatan</b>
                                    </td>
                                    <td class="bg-grid">
                                        <?php 
                                        if ($user_id == 182) {
                                            // Jika user_id == 182, buat input readonly dan masukkan hidden input
                                            echo '<input type="text" name="mksd_pemberangkatan" style="width:100%" class="input-wrc" value="' . (isset($perdin_grup->mksd_pemberangkatan) ? $perdin_grup->mksd_pemberangkatan : '') . '" readonly>';
                                            echo '<input type="hidden" name="mksd_pemberangkatan" value="' . (isset($perdin_grup->mksd_pemberangkatan) ? $perdin_grup->mksd_pemberangkatan : '') . '">';
                                        } else {
                                            // Jika bukan user_id 182, input dapat diedit
                                            echo '<input type="text" name="mksd_pemberangkatan" style="width:100%" class="input-wrc" value="' . (isset($perdin_grup->mksd_pemberangkatan) ? $perdin_grup->mksd_pemberangkatan : '') . '" required="required">';
                                        }
                                        ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td align="left" width="15%" class="bg-grid">
                                        <b>Detail Tempat Pemberangkatan</b>
                                    </td>
                                    <td class="bg-grid">
                                        <?php 
                                        if ($user_id == 182) {
                                            // Jika user_id == 182, buat input readonly dan masukkan hidden input
                                            echo '<input type="text" name="detail_tempat_pemberangkatan" style="width:100%" class="input-wrc" value="' . (isset($perdin_grup->detail_tempat_pemberangkatan) ? $perdin_grup->detail_tempat_pemberangkatan : '') . '" readonly>';
                                            echo '<input type="hidden" name="detail_tempat_pemberangkatan" value="' . (isset($perdin_grup->detail_tempat_pemberangkatan) ? $perdin_grup->detail_tempat_pemberangkatan : '') . '">';
                                        } else {
                                            // Jika bukan user_id 182, input dapat diedit
                                            echo '<input type="text" name="detail_tempat_pemberangkatan" style="width:100%" class="input-wrc" value="' . (isset($perdin_grup->detail_tempat_pemberangkatan) ? $perdin_grup->detail_tempat_pemberangkatan : '') . '" required="required">';
                                        }
                                        ?>
                                    </td>
                                </tr>

                                <?php if ($perdin_grup->file_srt ) {
                                  # code...
                                }?>
                                <tr>
                                    <td align="left" width="15%">
                                    <b>File Surat perintah untuk pegawai <?php echo $perdin_grup->file_srt ?></b>
                                    </td> 
                                    <td>
                                        <div id="fileInputWrapper">
                                            <?php
                                            // Tentukan path awal
                                            $file_path = 'assets/file_surat_perdin/' . $perdin_grup->file_srt;

                                            // Jika nama file mengandung "upload", ubah path ke folder upload
                                            if (!empty($perdin_grup->file_srt) && strpos($perdin_grup->file_srt, 'upload') !== false) {
                                                $file_path = 'assets/file_surat_perdin/upload/' . $perdin_grup->file_srt;
                                            }

                                            $file_url = base_url() . $file_path;

                                            // Cek apakah file ada
                                            if (!empty($perdin_grup->file_srt) && file_exists($file_path)) { 
                                            ?>
                                                <a href="<?= $file_url; ?>" style="color:blue;" target="_blank" title="Unduh Berkas">Berkas Siap</a>&nbsp;
                                                <button name="button" type="button" class="button-wrc" 
                                                    onclick="if (confirm('Yakin Hapus Berkas?')) parent.location='<?= base_url() . "perdin/hapus_sp/" . $perdin_grup->id; ?>'">
                                                    X
                                                </button>
                                                <input type="text" name="file_srt" value="<?php echo $perdin_grup->file_srt; ?>" hidden>

                                            <?php 
                                            } else { 
                                            ?>
                                                <input type="file" name="file_srt" id="fileToUpload" class="submit-wrc" accept=".docx">
                                            <?php 
                                            } 
                                            ?>
                                        </div>

                                </tr>
                            </tbody>
                            </table>
                            <div class="entry" style="text-align: center;">
                              <div style="margin-bottom: 30px;">
                                  <h2>Nomor Surat Perintah Perdin</h2>
                                  <?php 
                                  if ($user_id == 182) {
                                      echo '<input type="text" name="no__sppd" class="input-wrc" value="' . (isset($perdin_grup->no__sppd) ? $perdin_grup->no__sppd : '') . '" style="height: 55px;width: 280px;font-size: 18px;">';

                                      // Jika user_id == 182, buat input readonly dan masukkan hidden input
                                  } else {
                                      echo '<input type="text" name="no__sppd" class="input-wrc" value="' . (isset($perdin_grup->no__sppd) ? $perdin_grup->no__sppd : '') . '" style="height: 55px;width: 280px;font-size: 18px;" readonly>';
                                      echo '<input type="hidden" name="no__sppd" value="' . (isset($perdin_grup->no__sppd) ? $perdin_grup->no__sppd : '') . '">';
                               
                                      // Jika bukan user_id 182, input dapat diedit
                                  }
                                  ?>
                              </div>

                            
                              <input type="submit" name="submit" value="ubah" class="submit-wrc" content="ubah">

                              
                              <span></span>
                              <button name="button" type="button" class="button-wrc" onclick="parent.location='<?php echo site_url('perdin/suratperintah'); ?>'">Batal</button>
                            </div>
                    </div>
                    <div id="tabs-2">
                    </div>

             
           
            
        </div>
        <label>&nbsp;</label>
        <div class="spacer"></div>
    </div>
    
      
  </form>
  </div>
  <br style="clear: both;" />
</div>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
  $(document).ready(function() {
    $('.nama_kabupaten_kota').select2();
});
</script>

<script>
  $(document).ready(function () {
    $('#kode_rek_sub_req').select2({
      placeholder: "Pilih opsi", // Placeholder untuk dropdown
      allowClear: true,         // Menambahkan tombol untuk menghapus pilihan
      width: '100%',            // Lebar dropdown
      language: {
        noResults: function () {
          return "Tidak ada hasil ditemukan";
        }
      }
    });
  });

  $(document).ready(function () {
    // Inisialisasi Multiselect dengan Filter
    $('#listizin').multiselect({
        selectedText: '# dari # terpilih',
        noneSelectedText: 'Pilih pegawai',
        checkAllText: 'Pilih Semua',
        uncheckAllText: 'Hapus Semua',
        height: 'auto'
    }).multiselectfilter({
        show: 'blind',
        hide: 'blind'
    });

    // Event ketika pilihan diubah
    $('#listizin').on('multiselectclick', function (event, ui) {
        let selectedValues = $(this).multiselect("getChecked").map(function () {
            return $(this).val();
        }).get();

        // Ambil nilai tanggal keberangkatan
        const tglBerangkat = $('input[name="tglberangkat"]').val();

        // Tampilkan atau sembunyikan file input jika lebih dari 4 pegawai dipilih
        if (selectedValues.length > 4 || typeof pegawaiDinasLain !== "undefined" && pegawaiDinasLain == 1) {
            $('#fileInputWrapper').show();
        } else {
            $('#fileInputWrapper').hide();
        }

        // Jika checkbox baru dicentang, lakukan pengecekan data
        if (ui.checked) {
            const selectedId = ui.value; // Ambil ID pegawai yang baru dipilih

            fetch("<?php echo site_url('perdin/check_data_pegawai_by_date'); ?>", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: `id=${encodeURIComponent(selectedId)}&tglberangkat=${encodeURIComponent(tglBerangkat)}`
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Gagal mengambil data!');
                }
                return response.json();
            })
            .then(data => {
                if (data.exists === true) {
                    Swal.fire({
                        title: 'Perjalanan Dinas Terkait',
                        text: `Pegawai dengan identitas ${ui.text} sudah memiliki jadwal Perjalanan dinas pada tanggal keberangkatan.`,
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        // Reload halaman setelah notifikasi ditutup
                        window.location.reload();
                    });
                }
            })
            .catch(error => {
                console.error("Terjadi kesalahan:", error);
            });
        }
    });
});



  


</script>

<script> 
$(document).ready(function(){
  $("#flip").click(function(){
    $("#panel").slideToggle("slow");
  });
});
</script>


<script type="text/javascript">
 function toggleFormFields() {
    var tipeUndangan = document.getElementById("tipe_undangan").value;
    console.log(tipeUndangan);
    
    // Sembunyikan semua elemen terlebih dahulu
    document.getElementById("tgl_undangan_row").style.display = "none";
    document.getElementById("nmr_undangan_row").style.display = "none";
    document.getElementById("perihal_undangan_row").style.display = "none";
    document.getElementById("srt_instansi_undangan_row").style.display = "none";
    document.getElementById("dasar_arahan_row").style.display = "none";

    // Tampilkan elemen berdasarkan tipeUndangan
    if (tipeUndangan == "2") {
        document.getElementById("tgl_undangan_row").style.display = "table-row";
        document.getElementById("nmr_undangan_row").style.display = "table-row";
        document.getElementById("perihal_undangan_row").style.display = "table-row";
        document.getElementById("srt_instansi_undangan_row").style.display = "table-row";
    } else if (tipeUndangan == "3") {  // Perbaikan dari `elseif` ke `else if`
        document.getElementById("dasar_arahan_row").style.display = "table-row";
    }
}

  // Call the function on page load
  document.addEventListener("DOMContentLoaded", function () {
    toggleFormFields(); // Set initial visibility
  });
</script>


<style> 
#panel, #flip {
  padding: 5px;
  text-align: center;
  background-color: #e5eecc;
  border: solid 1px #c3c3c3;
}

#panel {
  padding: 50px;
  display: none;
}
</style>