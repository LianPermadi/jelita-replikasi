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
        <br>2. Tambahkan <span style="color:red;">${no_surat}</span> pada bagian Nomor Surat SP Perjalanan Dinas untuk menambahkan Nomor Surat secara otomatis
        <br>3. Upload file berupa .doc/docx
        <br>4. Fitur upload file SP muncul apabila pegawai yang berangkat lebih dari 4 Orang atau melaksanakan perjalanan dinas dengan OPD lain
        <h3>
      <!-- <span style="color:red;">*</span><h3>Tambahkan ${no_surat} pada SP Perjalanan Dinas untuk menambahkan Nomor Surat</h3> -->
        <div id="tabs">
          <ul>
            <li><a href="#tabs-1">Input Surat</a></li>
          </ul>
            <div id="tabs-1">
              <form method="post" action="<?php echo site_url().'perdin/'.$step; ?>" enctype="multipart/form-data">
                <?php 
                  if ($step == "update") { ?>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                  <?php } ?>
                <table cellpadding="0" cellspacing="0" border="0" class="display">
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
                        <b>Titik Lokasi Keberangkatan</b>
                      </td>
                      <td>
                        <select class="pilihan" name="titik_lokasi" id="titik_lokasi" onchange="jumlah_Tujuan_Pemberangkatan()" style="width: 100%;">
                          <option value="1">1</option>
                          <option value="2">2</option>
                          <option value="3">3</option>
                        </select>
                      </td>
                    </tr>
                    
                    <td align="left" width="15%">
                          <b>Tujuan Keberangkatan</b>
                      </td>
                      <td>
                        <select class="pilihan" name="kabupaten[]" style="width:100%" multiple size="3" id="kabupaten_select" onchange="tujuan_berangkat()">
                            <?php foreach ($kabupaten as $rowlist) { ?>
                                <option value="<?php echo $rowlist->id; ?>"><?php echo $rowlist->n_kabupaten; ?></option>
                            <?php } ?>
                        </select>
                        <ul id="selected-list" style="list-style-type: none; padding: 0;"></ul>
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
                                  'value' => '',
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
                                  $tgl_input = array(
                                    'name' => 'tglberangkat',
                                    'id' => 'tglberangkat', // Tambahkan ID
                                    'value' => ((!empty($tglkembali)) ? $tglkembali : '0000-00-00'),
                                    'class' => 'input-wrc',
                                    'readOnly' => TRUE,
                                    'style' => "width:100%",
                                    'class' => 'monbulan'
                                );
                                  echo form_input($tgl_input);
                                ?>
                          </td>
                      </tr>
                      <tr id="Tanggal_Kepulangan_1">

                        <td align="left" width="15%" class="bg-grid">
                          <b>Tanggal Kepulangan 1</b>
                        </td>
                        <td class="bg-grid">
                          <?php 
                            $tgl_input = array('name' => 'tglkembali',
                                    'value' => ((!empty($tglkembali)) ? $tglkembali : '0000-00-00'),
                                    'class' => 'input-wrc',
                                    'readOnly'=>TRUE,
                                    'style' => "width:100%",
                                    'class' => 'monbulan'
                                  );
                            echo form_input($tgl_input);
                          ?>
                        </td>
                      </tr>
                      <tr id="Detail_Tempat_Keberangkatan_2" style="display:none;">
                          <td align="left" width="15%" class="bg-grid">
                              <b>Detail Tempat tujuan 2</b>
                          </td>
                          <td class="bg-grid">
                              <?php 
                              $tempat_input = array(
                                  'name' => 'detail_tempat_2',
                                  'id' => 'tempatberangkat2',
                                  'value' => '',
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
                                  $tgl_input = array(
                                    'name' => 'tglberangkat2',
                                    'id' => 'tglberangkat2', // Tambahkan ID
                                    'value' => ((!empty($tglkembali)) ? $tglkembali : '0000-00-00'),
                                    'class' => 'input-wrc',
                                    'readOnly' => TRUE,
                                    'style' => "width:100%",
                                    'class' => 'monbulan'
                                );
                                  echo form_input($tgl_input);
                                ?>
                          </td>
                      </tr>
                      <tr id="Tanggal_Kepulangan_2" style="display:none;">

                        <td align="left" width="15%" class="bg-grid">
                          <b>Tanggal Kepulangan 2</b>
                        </td>
                        <td class="bg-grid">
                          <?php 
                            $tgl_input = array('name' => 'tglkembali2',
                                    'value' => ((!empty($tglkembali)) ? $tglkembali : '0000-00-00'),
                                    'class' => 'input-wrc',
                                    'readOnly'=>TRUE,
                                    'style' => "width:100%",
                                    'class' => 'monbulan'
                                  );
                            echo form_input($tgl_input);
                          ?>
                        </td>
                      </tr>
                      <tr id="Detail_Tempat_Keberangkatan_3" style="display:none;">
                          <td align="left" width="15%" class="bg-grid">
                              <b>Detail Tempat tujuan 3</b>
                          </td>
                          <td class="bg-grid">
                              <?php 
                              $tempat_input = array(
                                  'name' => 'detail_tempat_3',
                                  'id' => 'tempatberangkat3',
                                  'value' => '',
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
                                  $tgl_input = array(
                                    'name' => 'tglberangkat3',
                                    'id' => 'tglberangkat3', // Tambahkan ID
                                    'value' => ((!empty($tglkembali)) ? $tglkembali : '0000-00-00'),
                                    'class' => 'input-wrc',
                                    'readOnly' => TRUE,
                                    'style' => "width:100%",
                                    'class' => 'monbulan'
                                );
                                  echo form_input($tgl_input);
                                ?>
                          </td>
                      </tr>
                      <tr id="Tanggal_Kepulangan_3" style="display:none;">

                        <td align="left" width="15%" class="bg-grid">
                          <b>Tanggal Kepulangan 3</b>
                        </td>
                        <td class="bg-grid">
                          <?php 
                            $tgl_input = array('name' => 'tglkembali3',
                                    'value' => ((!empty($tglkembali)) ? $tglkembali : '0000-00-00'),
                                    'class' => 'input-wrc',
                                    'readOnly'=>TRUE,
                                    'style' => "width:100%",
                                    'class' => 'monbulan'
                                  );
                            echo form_input($tgl_input);
                          ?>
                        </td>
                      </tr>

                      <?php if ($iduser === "121") : ?>
                        <!-- Pilihan Tanggal Back Date -->
                                <tr>
                                    <td align="left" width="15%" class="bg-grid">
                                        <b>Tanggal Back Date</b>
                                    </td>
                                    <td class="bg-grid">
                                        <select class="pilihan select-wrc" name="pilihan_backdate" id="pilihan_backdate" style="width: 100%;" onchange="toggleTanggalSPBackdate()">
                                            <option value="-">-</option>
                                            <option value="ya">Ya</option>
                                            <option value="tidak">Tidak</option>
                                        </select>
                                    </td>
                                </tr>

                                <!-- Input Tanggal Surat Perintah -->
                                <tr id="tanggal_sp_backdate" style="display:none;">
                                    <td align="left" width="15%" class="bg-grid">
                                        <b>Tanggal Surat Perintah</b>
                                    </td>
                                    <td class="bg-grid">
                                        <?php 
                                            $tgl_input = array(
                                                'name' => 'tanggal_sp_backdate',
                                                'value' => (!empty($tanggal_sp_backdate) ? $tanggal_sp_backdate : '0000-00-00'),
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
                          <b>Kendaraan yang Digunakan</b>
                        </td>
                        <td class="bg-grid">
                          <select class="pilihan" name="kendaraan" id="kendaraan" class="select-wrc" style="width: 100%;">
                            <option value="-">-</option>
                            <option value="Kendaraan Dinas">Kendaraan Dinas</option>
                            <option value="Kendaraan Umum">Kendaraan Umum</option>
                            <option value="Kendaraan Pribadi">Kendaraan Pribadi</option>
                          </select>
                        </td>
                      </tr>
                    <tr>
                      <td align="left" width="15%">
                        <b>Pegawai yang Berangkat</b>
                      </td>
                      <td>
                        <select id="listizin" name="listizin[]" multiple="multiple" style="width: 85%;" required>
                            <?php
                            if ($step === "update") {
                                foreach ($list as $data) {
                                    // Pastikan pegawai dari DPMPTSP dan statusnya aktif
                                    if ($data->golongan != "PS") {
                                        $selected = '';
                                        foreach ($idp as $data_p) {
                                            if ($data_p->id == $data->id) {
                                                $selected = 'selected';
                                                break;
                                            }
                                        }
                                        echo "<option style='width:100%' value='" . $data->id . "' " . $selected . ">" . 
                                            $data->n_pegawai . " | " . $data->nip . " | " . $data->pangkat_gol . " | " . $data->n_jabatan . 
                                            "</option>";
                                    }
                                }
                            } else {
                                foreach ($list as $data) {
                                    // Pastikan pegawai dari DPMPTSP dan statusnya aktif
                                    if ($data->golongan != "PS") {
                                        echo "<option style='width:100%' value='" . $data->id . "'>" . 
                                            $data->n_pegawai . " | " . $data->nip . " | " . $data->pangkat_gol . " | " . $data->n_jabatan . 
                                            "</option>";
                                    }
                                }
                            }
                            ?>
                        </select>
                    </td>

                    </tr>
                    <tr>
                      <td align="left" width="15%" class="bg-grid">
                        <b>Dasar Perjalanan Dinas</b>
                      </td>
                      <td class="bg-grid">
                        <select class="pilihan" name="tipe_undangan" id="tipe_undangan" onchange="toggleFormFields()" style="width: 100%;">
                          <option value="-">-</option>
                          
                          <option value="1">Tanpa Undangan</option>

                          <option value="2">Berdasarkan Undangan</option>
                          <option value="3">Berdasarkan Arahan Pimpinan</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td align="left" width="15%">
                        <b>Berangkat Dengan OPD Lain ?</b>
                      </td>
                      <td>
                        <select  class="pilihan"  name="pegawai_dinas_lain" id="pegawai_dinas_lain" onchange="file_surat()" style="width: 100%;">
                          <option value="-">-</option>
                          
                          <option value="2">Tidak</option>
                          
                          <option value="1">Ya</option>
                        </select>
                      </td>
                    </tr>
                    <tr id="dasar_arahan_row" style="display:none;">
                      <td align="left" width="15%" class="bg-grid" >
                        <b>Dasar Arahan Pimpinan</b>
                      </td>
                      <td class="bg-grid">
                        <input type="text" name="dasar_arahan_pimpiman" style="width:100%" class="input-wrc" value="" >
                      </td>
                    </tr>
                    <tr id="srt_instansi_undangan_row" style="display:none;">
                      <td align="left" width="15%">
                        <b>surat undangan dari instansi
                      </td>
                      <td>
                        <input type="text" name="srt_instansi_undangan" style="width:100%" class="input-wrc" value="" >
                      </td>
                    </tr>
                    

                    <!-- Nomor Surat Undangan -->
                    <tr id="nmr_undangan_row" style="display:none;">
                      <td align="left" width="15%" class="bg-grid">
                        <b>Nomor Surat Undangan</b>
                      </td>
                      <td class="bg-grid">
                        <input type="text" name="nmr_srt_undangan" style="width:100%" class="input-wrc" value="" >
                      </td>
                    </tr>
                    <!-- Tanggal Surat Undangan -->
                    <tr id="tgl_undangan_row" style="display:none;">
                      <td align="left" width="15%" class="bg-grid">
                        <b>Tanggal Surat Undangan</b>
                      </td>
                      <td class="bg-grid">
                        <?php 
                          $tgl_input = array('name' => 'tgl_srt_undangan',
                                  'value' => ((!empty($tgl_srt_undangan)) ? $tgl_srt_undangan : date('Y-m-d')),
                                  'class' => 'input-wrc',
                                  'readOnly'=>TRUE,
                                  'style' => "width:100%",
                                  'class' => 'monbulan'
                          );
                          echo form_input($tgl_input);
                        ?>
                      </td>
                    </tr>
                    <!-- Perihal Surat Undangan -->
                    <tr id="perihal_undangan_row" style="display:none;">
                      <td align="left" width="15%" class="bg-grid">
                        <b>Perihal Surat Undangan</b>
                      </td>
                      <td class="bg-grid">
                        <input type="text" name="perihal_srt_undangan" style="width:100%" class="input-wrc" value="" >
                      </td>
                    </tr>

                    <!-- Kode Rek dan Sub Req -->
                    <tr>
                          <td align="left" width="15%" class="bg-grid">
                              <b>Kode Rekening Sub Kegiatan</b>
                          </td>
                          <td class="bg-grid">
                              <select  name="kode_rek_sub_req" id="kode_rek_sub_req">
                                 <option value="-" selected>
                                      -
                                  </option>
                              <?php foreach ($surat_kode_reg as $kode_reg) { ?>
                                  <option value="<?php echo $kode_reg->kode_sub_ring; ?> <?php echo $kode_reg->uraian_sub_kegiatan; ?>">
                                      <?php echo $kode_reg->kode_sub_ring; ?> <?php echo $kode_reg->uraian_sub_kegiatan; ?>
                                  </option>
                              <?php } ?>
                              </select>
                              <!-- Display the selected kode_ring in the input field -->
                              <input type="text" name="kode_rek" style="width:100%" class="input-wrc" value="" id="selected_value_2" hidden>

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
                        <td align="left" width="15%">
                          <b>Tim Berangkat</b>
                        </td>
                        <td>
                          <select name="id_tim" id="list_tim">
                          <option value="-" selected>
                                      -
                                  </option>
                          <?php foreach ($list_tims as $list_tim) {   ?>
                            <option value="<?php echo $list_tim->id; ?>"><?php echo $list_tim->nama_tim; ?></option>
                            <?php } ?>
                          </select>
                        </td>
                      </tr>
                    </tr>
                   
               
                    <tr>
                      <td align="left" width="15%" class="bg-grid">
                        <b>Maksud Perjalanan Dinas</b>
                      </td>
                      <td class="bg-grid">
                        <input type="text" name="mksd_pemberangkatan" style="width:100%" class="input-wrc" value="" required="required">
                      </td>
                    </tr>
                    <!-- <tr>
                      <td align="left" width="15%">
                        <b>Detail Tempat Perjalanan Dinas</b>
                      </td>
                      <td>
                        <input type="text" name="detail_tempat_pemberangkatan" style="width:100%" class="input-wrc" value="" required="required">
                      </td>
                    </tr> -->
                      <tr>
                        <td align="left" width="15%">
                          <b>Upload File Surat Perintah</b>
                        </td> 
                        <td>
                            <!-- Tambahkan elemen untuk input file -->
                              <div id="fileInputWrapper" style="display: none;">
                                <input type="file" name="file_srt" class="submit-wrc" value="Pilih file" accept=".docx, .DOCX">
                                <a href="<?php echo base_url() . 'assets/file_surat_perdin/template_surat_perdin/surat_perintah_template_4_orang_tipe1.docx'?>" style="color: red;">download template sp perdin</a>
                              </div>
                              <br>*<span style="color:red;"><i>upload file SP apabila pegawai yang berangkat lebih dari 4 Orang atau melaksanakan perjalanan dinas dengan OPD lain</i></span>

                        </td>
                      </tr>
                  </tbody>
                </table>
            </div>
        </div>
        <label>&nbsp;</label>
        <div class="spacer"></div>
    </div>
    <div class="entry" style="text-align: center;">
      <input type="submit" name="submit" value="Simpan" class="submit-wrc" content="Simpan">

      
      <span></span>
      <button name="button" type="button" class="button-wrc" onclick="parent.location='<?php echo site_url('perdin/suratperintah'); ?>'">Batal</button>
    </div>
  </form>
  </div>
  <br style="clear: both;" />
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function tujuan_berangkat() {
    // Ambil opsi yang dipilih dari listizin sebagai array
    var listIzin = document.getElementById("kabupaten_select");
    var selectedOptions = Array.from(listIzin.selectedOptions);
    var selectedCount = selectedOptions.length; // Hitung jumlah opsi yang dipilih

    // Ambil jumlah maksimum tujuan dari dropdown #titik_lokasi
    var maxTitik = document.getElementById("titik_lokasi").value;

    // Jika lebih dari jumlah maksimum tujuan yang dipilih, batalkan pilihan terakhir
    if (selectedCount > maxTitik) {
        alert("Anda hanya bisa memilih maksimal " + maxTitik + " tujuan keberangkatan.");
        
        // Batalkan pilihan terakhir
        var lastSelectedOption = selectedOptions[selectedOptions.length - 1];
        
        // Batalkan pemilihan pada elemen select
        lastSelectedOption.selected = false;
        
        // Hapus elemen <li> terakhir yang ada di dalam <ul class="select2-choices">
        var select2Choices = document.querySelector(".select2-search-choice");
        select2Choices.remove();

        if (select2Choices) {
            select2Choices.remove();
        }
    }
}



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
  $('#list_tim').select2({
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
  $('#listizin').multiselect({
    selectedText: '# dari # terpilih'
  }).multiselectfilter({
    show: 'blind',
    hide: 'blind'
  });

  $('#listizin').multiselect({
    click: function (event, ui) {
      // Get selected checkbox values
      let selectedValues = $(this).multiselect("getChecked").map(function () {
        return $(this).val();
      }).get();

      // Get departure date value
      const tglBerangkat = $('input[name="tglberangkat"]').val();

        // Get the input value for "pegawai dari dinas lain"
      const pegawaiDinasLain = $('select[name="pegawai_dinas_lain"]').val();  // Update with the correct selector for the "pegawai dari dinas lain" input
      console.log(pegawaiDinasLain);
      
      console.log(selectedValues.length);
      
      // Show or hide file input based on AND condition
      if (selectedValues.length > 4 || pegawaiDinasLain == 1) {
          $('#fileInputWrapper').show();

      } else {
          $('#fileInputWrapper').hide();
      }

      // If a checkbox is checked, check data
      if (ui.checked) {
        const selectedId = ui.value; // ID of the newly checked employee

        fetch("<?php echo site_url('perdin/check_data_pegawai_by_date'); ?>", {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded"
          },
          body: `id=${encodeURIComponent(selectedId)}&tglberangkat=${encodeURIComponent(tglBerangkat)}`
        })
          .then(response => response.json())
          .then(data => {
            if (data.exists === true) {
              Swal.fire({
                title: 'Perjalanan Dinas Terkait',
                text: `Pegawai dengan identitas ${ui.text} sudah memiliki jadwal Perjalanan dinas pada tanggal keberangkatan.`,
                icon: 'warning',
                confirmButtonText: 'OK'
              }).then(() => {
                // Reload the page after the alert
                window.location.reload();  // This will refresh the entire page
              });
            }
          })
          .catch(error => {
            console.error("Error:", error);
          });
      }
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

  

</script>
<script type="text/javascript">
  function file_surat() {
    // Get selected options from listizin as an array
    var listIzin = document.getElementById("listizin");
    var selectedOptions = Array.from(listIzin.selectedOptions);
    var selectedCount = selectedOptions.length; // Count selected options

    // Get the value of tipedenganDinas
    var tipeDenganDinas = document.querySelector('select[name="pegawai_dinas_lain"]').value;


    // Show or hide fileInputWrapper based on the conditions
    if (selectedCount > 4 || tipeDenganDinas == "1") {
      document.getElementById("fileInputWrapper").style.display = "table-row"; // Show
    } else {
      document.getElementById("fileInputWrapper").style.display = "none"; // Hide
    }
  }

  // Add an event listener to detect changes
  document.getElementById("listizin").addEventListener("change", file_surat);
  document.querySelector('select[name="pegawai_dinas_lain"]').addEventListener("change", file_surat);
</script>

<script type="text/javascript">
 
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