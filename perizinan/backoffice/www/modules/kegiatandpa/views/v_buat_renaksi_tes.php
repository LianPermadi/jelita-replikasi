<?php 
// var_dump($anggota);die();
  if (!empty($program)) {
    $id_tim = "";
    $kegiatan = "";
    $renaksi = "";
    $target_aktivitas = "";
    $r_anggaran = "";
    $satuan = "";
    $keterangan = "";
    $tgl_rencana = "";
    $tgl_realisasi = "";
    $t1 = "";
    $t2 = "";
    $t3 = "";
    $t4 = "";
    $t5 = "";
    $t6 = "";
    $t7 = "";
    $t8 = "";
    $t9 = "";
    $t10 = "";
    $t11 = "";
    $t12 = "";
    $r1 = "";
    $r2 = "";
    $r3 = "";
    $r4 = "";
    $r5 = "";
    $r6 = "";
    $r7 = "";
    $r8 = "";
    $r9 = "";
    $r10 = "";
    $r11 = "";
    $r12 = "";
    $id_tim = $program->kd_tim;
    // var_dump($id_tim);
    // $id = $program->id;
    $aktivitas = $program->sasaran_program;
    $anggaran = $program->anggaran_tot;
  }
 ?>
<style>
        #myInput {
            display: none;
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
      <?php } ?>

      <?php 
        $alert = $this->session->flashdata("gagal");
        if(!empty($alert)){
      ?>
        <br>
        <div style="color: red; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;"><center><?php echo $alert; ?></center></div>
      <?php } ?>
    <form method="post" action="<?php echo site_url().'kegiatandpa/'.$step; ?>" enctype="multipart/form-data">
    <div class="entry">
      <div id="tabs">
        <ul>
          <li><a href="#tabs-1">Input Rincian Aktivitas</a></li>
          <li><a href="#tabs-2">Rincian Aktivitas Tim Of Tim</a></li>
        </ul>
        <div id="tabs-1">
        <?php 
          if ($step == "subrenaksi_update") { ?>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
          <?php } else { ?>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
          <?php } ?>
          <table id="tabelAktivitas" cellpadding="0" cellspacing="0" border="0" class="display">
            <tbody>
              <tr>
                <td align="left" width="15%" class="bg-grid">
                  <b>Tim</b>
                </td>
                <td class="bg-grid">
                  <select class="pilihan" name="id_tim" style="width:100%" disabled>
                    <?php foreach ($tim as $row) {
                    $ambil_ketua = $this->m_renaksi->get_ketua($row->ketua); ?>
                      <option value="<?php echo $row->id; ?>" <?php echo ($id_tim == $row->id ? "selected" : ""); ?>><?php echo $row->nama_tim." (Ketua Tim : ".$this->m_renaksi->get_ketua($row->ketua)." )"; ?></option>
                    <?php } ?>
                  </select>
                </td>
              </tr>
              <tr>
                <td align="left" width="15%" class="bg-grid">
                  <b>Kegiatan</b>
                </td>
                <td class="bg-grid">
                  <textarea name="aktivitas" style="width:100%" class="input-area-wrc" required readonly><?php echo $aktivitas; ?></textarea>
                </td>
              </tr>
              <button type="button" onclick="tambahBaris()">Tambah Baris</button>
              <tr>
                <td align="left" width="15%" class="bg-grid">
                  <b>Aktivitas</b>
                </td>
                <td class="bg-grid">
                  <textarea name="renaksi" style="width:100%" class="input-area-wrc" required><?php echo $renaksi; ?></textarea>
                </td>
              </tr>
              <tr>
                <td align="left" width="15%"  class="bg-grid">
                  <b>Pelaksana Tugas</b>
                </td>
                <td class="bg-grid">
                  <select class="pilihan" id="u_anggota" name="u_anggota[]" multiple="multiple" style="width: 100%;">
                      <?php foreach ($anggota as $row) { ?>
                      <option value="<?php echo $row->id_pegawai; ?>" <?php echo ($id_tim == $row->kd_tim); ?>><?php echo $this->m_renaksi->get_anggota_tim($row->id_pegawai); ?></option>
                    <?php } ?>
                  </select>
                  <span id="erorPeriksa" style=" clear: both; visibility: hidden;"></span>
                </td>
              </tr>
              <tr>
                <td align="left" width="15%" class="bg-grid">
                  <b>Anggaran</b><br>*diisi angka
                </td>
                <td class="bg-grid">
                  <input type="text" name="anggaran" style="width:20%" class="input-wrc" value="<?php echo number_format($anggaran,0,',','.');?>" required="required" readonly>
                   <b>Realisasi Anggaran : </b><input type="number" name="r_anggaran" style="width:20%" class="input-wrc" value="<?php echo $r_anggaran; ?>" >
                </td>
              </tr>
              <!-- <tr>
                <td align="left" width="15%" class="bg-grid">
                  <b>Target Aktivitas</b><br>*diisi angka
                </td>
                <td class="bg-grid">
                  <input type="number" name="target_aktivitas" style="width:20%" class="input-wrc" value="<?php echo $target_aktivitas; ?>" required="required">
                   <b>Satuan : </b><input type="text" name="satuan" style="width:20%" class="input-wrc" value="<?php echo $satuan; ?>" required="required">
                </td>
              </tr>
              <tr>
                <td align="left" width="15%" class="bg-grid">
                  <b>Tanggal Rencana</b>
                </td>
                <td class="bg-grid">
                  <?php 
                    $tgl_input = array('name' => 'tgl_rencana',
                            'value' => ((!empty($tgl_rencana)) ? $tgl_rencana : date('Y-m-d')),
                            'class' => 'input-wrc',
                            'readOnly'=>TRUE,
                            'style' => "width:100%",
                            'class' => 'monbulan'
                           );
                    echo form_input($tgl_input);
                  ?>
                </td>
              </tr>
              <tr>
                <td align="left" width="15%" class="bg-grid">
                  <b>Tanggal Realisasi</b>
                </td>
                <td class="bg-grid">
                  <label>
                    <input type="checkbox" id="toggleField"> Sudah Realisasi
                </label>

                <?php
                $tgl_input = array(
                    'name' => 'tgl_realisasi',
                    'id' => 'myInput',
                    'value' => $tgl_realisasi,
                    'class' => 'input-wrc',
                    'style' => "width:80%",
                    'class' => 'monbulan',
                    'readonly' => TRUE
                );
                echo form_input($tgl_input);
                ?>
                </td>
              </tr> -->

              <tr>
                <td align="left" width="15%">
                  <b>Target Aktivitas Per Bulan</b>
                </td>
                <td>
                  <b>TW 1</b>-<input type="text" name="t1" style="width:6%" class="input-wrc" value="<?php echo $t1; ?>" >
                  <input type="text" name="t2" style="width:6%" class="input-wrc" value="<?php echo $t2; ?>" >
                  <input type="text" name="t3" style="width:6%" class="input-wrc" value="<?php echo $t3; ?>" > - 
                  <b>TW 2</b>-<input type="text" name="t4" style="width:6%" class="input-wrc" value="<?php echo $t4; ?>" >
                  <input type="text" name="t5" style="width:6%" class="input-wrc" value="<?php echo $t5; ?>" >
                  <input type="text" name="t6" style="width:6%" class="input-wrc" value="<?php echo $t6; ?>" >
                  <b>TW 3</b>-<input type="text" name="t7" style="width:6%" class="input-wrc" value="<?php echo $t7; ?>" >
                  <input type="text" name="t8" style="width:6%" class="input-wrc" value="<?php echo $t8; ?>" >
                  <input type="text" name="t9" style="width:6%" class="input-wrc" value="<?php echo $t9; ?>" > - 
                  <b>TW 4</b>-<input type="text" name="t10" style="width:6%" class="input-wrc" value="<?php echo $t10; ?>" >
                  <input type="text" name="t11" style="width:6%" class="input-wrc" value="<?php echo $t11; ?>" >
                  <input type="text" name="t12" style="width:6%" class="input-wrc" value="<?php echo $t12; ?>" >
                </td>
              </tr>
              <tr>
                <td align="left" width="15%" class="bg-grid">
                  <b>Realisasi Aktivitas Per Bulan</b>
                </td>
                <td class="bg-grid">
                  <b>TW 1</b>-<input type="text" name="r1" style="width:6%" class="input-wrc" value="<?php echo $r1; ?>" >
                  <input type="text" name="r2" style="width:6%" class="input-wrc" value="<?php echo $r2; ?>" >
                  <input type="text" name="r3" style="width:6%" class="input-wrc" value="<?php echo $r3; ?>" > - 
                  <b>TW 2</b>-<input type="text" name="r4" style="width:6%" class="input-wrc" value="<?php echo $r4; ?>" >
                  <input type="text" name="r5" style="width:6%" class="input-wrc" value="<?php echo $r5; ?>" >
                  <input type="text" name="r6" style="width:6%" class="input-wrc" value="<?php echo $r6; ?>" >
                  <b>TW 3</b>-<input type="text" name="r7" style="width:6%" class="input-wrc" value="<?php echo $r7; ?>" >
                  <input type="text" name="r8" style="width:6%" class="input-wrc" value="<?php echo $r8; ?>" >
                  <input type="text" name="r9" style="width:6%" class="input-wrc" value="<?php echo $r9; ?>" > - 
                  <b>TW 4</b>-<input type="text" name="r10" style="width:6%" class="input-wrc" value="<?php echo $r10; ?>" >
                  <input type="text" name="r11" style="width:6%" class="input-wrc" value="<?php echo $r11; ?>" >
                  <input type="text" name="r12" style="width:6%" class="input-wrc" value="<?php echo $r12; ?>" >
                </td>
              </tr>
  
              <tr>
                <td align="left" width="15%"  class="bg-grid">
                  <b>Keterangan</b>
                </td>
                <td  class="bg-grid"> 
                  <textarea name="keterangan" style="width:100%" class="input-area-wrc"><?php echo $keterangan; ?></textarea>
                </td>
              </tr>
            </tbody>
          </table>
          <div class="entry" style="text-align: center;">
      <?php 
        if ($step == "subrenaksi_simpan") { ?>
          <input type="submit" name="submit" value="Simpan" class="submit-wrc" content="Simpan">
        <?php } else { ?>
          <input type="submit" name="submit" value="Ubah" class="submit-wrc" content="Ubah">
        <?php } ?>
      
      <span></span>
      <button name="button" type="button" class="button-wrc" onclick="parent.location='<?php echo site_url('kegiatandpa/renaksi'); ?>'">Batal</button>
    </div>
  </form>
        </div>
        <div id="tabs-2">
          <?php 
          $ambil_id = $this->m_renaksi->get_program_id($id);
          $ambil_tim = $this->m_renaksi->get_kdtim_prog($id);
          $ketua_tim = $this->m_renaksi->get_id_ketua($ambil_tim);
          $ketua = $this->m_renaksi->get_ketua($ketua_tim);
          $program = $this->m_renaksi->get_sasaran($ambil_id);
          ?>

          <h3>Kegiatan : <?php echo $program; ?></h3>
          <h3>Ketua Tim : <?php echo $ketua; ?></h3>
        <table cellpadding="0" cellspacing="0" border="0" class="display" id="pendataan">
        <thead>
          <tr>
            <th>No</th>
            <th>Aktivitas</th>
            <th>Pelaksana Tugas</th>
            <th>Realisasi Anggaran</th>
            <th>Target Aktivitas</th>
            <th>Tgl Rencana</th>
            <th>Tgl Realisasi</th>
            <th>Keterangan</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $i = 1; 
          foreach ($rencana_aksi as $row) {
          ?>
          <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $row->sasaran_renaksi;?></td>
              <td><?php
            $no = 1;
            $nono = 1;
            $anggota1 = explode('^', $row->pic);
            // var_dump($anggota1); die();
                foreach ($anggota1 as $data){
                  echo $no.'. '.$this->m_renaksi->get_n_pegawai($data).'<br>';
                  $no++; 
                }
              ?>
            </td>
            <td><?php echo number_format($row->r_anggaran,0,',','.');?></td>
            <td><?php echo $row->target_aktivitas.' '.$row->satuan; ?></td>
            <td><?php echo $this->lib_date->mysql_to_human($row->tgl_rencana); ?></td>
            <td><?php echo $this->lib_date->mysql_to_human($row->tgl_realisasi); ?></td>
            <td><?php echo $row->keterangan; ?></td>
            <td>
              <?php 
                echo '<a href="'.base_url().'kegiatandpa/edit_rencana_aksi/'.$row->id.'/'.base64_encode($row->pic).'"><img src="'.base_url().'assets/images/icon/property.png" alt="Edit Data" title="Edit Data" border="0"></a>&nbsp;';
              ?>
              <!-- <?php 
                echo '<a href="'.base_url().'kegiatandpa/subrenaksi/'.$row->id.'"><img src="'.base_url().'assets/images/icon/arrow_biru.png" alt="Teruskan ke Anggota" title="Teruskan ke Anggota" border="0" height="50%" width="50%"></a>&nbsp;';
              ?> -->
              <a href="#" onclick="if (confirm('Yakin Hapus Data?')) parent.location='<?php echo  site_url('kegiatandpa/hapus_renaksi/'.$row->id.'/'.$id); ?>'"><img src="<?php echo base_url().'assets/images/icon/cross.png'; ?>" alt="Hapus Data" title="Hapus Data" border="0"></a>&nbsp;
            </td>
          </tr>
          <?php $i++; } ?>
        </tbody>
      </table>
            </div>
      </div>
        <label>&nbsp;</label>
        <div class="spacer"></div>
    </div>
  </div>
  <br style="clear: both;" />
</div>

<script>
  function tambahBaris() {
    var table = document.getElementById("tabelAktivitas").getElementsByTagName('tbody')[0];

    // Baris untuk aktivitas
    var newRow1 = table.insertRow(table.rows.length);
    var cell1_1 = newRow1.insertCell(0);
    var cell1_2 = newRow1.insertCell(1);
    cell1_1.innerHTML = '<td align="left" width="15%"><b>Aktivitas</b></td>';
    cell1_2.innerHTML = '<td><textarea name="aktivitas[]" style="width:100%" class="input-area-wrc" required></textarea></td>';

    // Baris untuk pelaksana tugas (select box)
    var newRow2 = table.insertRow(table.rows.length);
    var cell2_1 = newRow2.insertCell(0);
    var cell2_2 = newRow2.insertCell(1);
    cell2_1.innerHTML = '<td align="left" width="15%"><b>Pelaksana Tugas</b></td>';
    cell2_2.innerHTML = '<td class="bg-grid"><select class="pilihan" id="u_anggota" name="u_anggota[]" multiple="multiple" style="width: 100%;"><?php foreach ($anggota as $row) { ?><option value="<?php echo $row->id_pegawai; ?>" <?php echo ($id_tim == $row->kd_tim); ?>><?php echo $this->m_renaksi->get_anggota_tim($row->id_pegawai); ?></option><?php } ?></select><span id="erorPeriksa" style=" clear: both; visibility: hidden;"></span></td>';

    // Baris untuk Anggaran
    var newRow3 = table.insertRow(table.rows.length);
    var cell3_1 = newRow3.insertCell(0);
    var cell3_2 = newRow3.insertCell(1);
    cell3_1.innerHTML = '<td align="left" width="15%"><b>Realisasi Anggaran</b></td>';
    cell3_2.innerHTML = '<td><input type="text" name="anggaran" style="width:20%" class="input-wrc" value="<?php echo number_format($anggaran,0,',','.');?>" required="required" readonly> <b>Realisasi Anggaran</b> <input type="number" name="r_anggaran" style="width:20%" class="input-wrc"></td>';

    // Baris untuk renaksi
    var newRow4= table.insertRow(table.rows.length);
    var cell4_1 = newRow4.insertCell(0);
    var cell4_2 = newRow4.insertCell(1);
    cell4_1.innerHTML = '<td align="left" width="15%"><b>Keterangan</b></td>';
    cell4_2.innerHTML = '<td><textarea name="renaksi[]" style="width:100%" class="input-area-wrc"></textarea></td>';

    // Baris untuk renaksi
    var newRow = table.insertRow(table.rows.length);
    var cell5_1 = newRow5.insertCell(0);
    var cell5_2 = newRow5.insertCell(1);
    cell5_1.innerHTML = '<b>Target Aktivitas Per Bulan</b>';
    cell5_2.innerHTML = `
      <b>TW 1</b>-<input type="text" name="r1" style="width:6%" class="input-wrc" value="${r1 || ''}" >
      <input type="text" name="r2" style="width:6%" class="input-wrc" value="${r2 || ''}" >
      <input type="text" name="r3" style="width:6%" class="input-wrc" value="${r3 || ''}" > - 
      <b>TW 2</b>-<input type="text" name="r4" style="width:6%" class="input-wrc" value="${r4 || ''}" >
      <input type="text" name="r5" style="width:6%" class="input-wrc" value="${r5 || ''}" >
      <input type="text" name="r6" style="width:6%" class="input-wrc" value="${r6 || ''}" > - 
      <b>TW 3</b>-<input type="text" name="r7" style="width:6%" class="input-wrc" value="${r7 || ''}" >
      <input type="text" name="r8" style="width:6%" class="input-wrc" value="${r8 || ''}" >
      <input type="text" name="r9" style="width:6%" class="input-wrc" value="${r9 || ''}" > - 
      <b>TW 4</b>-<input type="text" name="r10" style="width:6%" class="input-wrc" value="${r10 || ''}" >
      <input type="text" name="r11" style="width:6%" class="input-wrc" value="${r11 || ''}" >
      <input type="text" name="r12" style="width:6%" class="input-wrc" value="${r12 || ''}" >
    `;

  }
</script>

<input type="text" name="t2" style="width:6%" class="input-wrc" value="<?php echo $t2; ?>" >
              <tr>
                <td align="left" width="15%">
                  <b>Target Aktivitas</b><br>*diisi angka
                </td>
                <td>
                  <input type="number" name="target_aktivitas" style="width:20%" class="input-wrc" value="<?php echo $target_aktivitas; ?>" required="required">
                   <b>Satuan : </b><input type="text" name="satuan" style="width:20%" class="input-wrc" value="<?php echo $satuan; ?>" required="required">
                </td>
              </tr>
              <tr>
                <td align="left" width="15%">
                  <b>Tanggal Rencana</b>
                </td>
                <td>
                  <?php 
                    $tgl_input = array('name' => 'tgl_rencana',
                            'value' => ((!empty($tgl_rencana)) ? $tgl_rencana : date('Y-m-d')),
                            'class' => 'input-wrc',
                            'readOnly'=>TRUE,
                            'style' => "width:100%",
                            'class' => 'monbulan'
                           );
                    echo form_input($tgl_input);
                  ?>
                </td>
              </tr>
              <tr>
                <td align="left" width="15%">
                  <b>Tanggal Realisasi</b>
                </td>
                <td>
                  <label>
                    <input type="checkbox" id="toggleField"> Sudah Realisasi
                </label>

                <?php
                $tgl_input = array(
                    'name' => 'tgl_realisasi',
                    'id' => 'myInput',
                    'value' => $tgl_realisasi,
                    'class' => 'input-wrc',
                    'style' => "width:80%",
                    'class' => 'monbulan',
                    'readonly' => TRUE
                );
                echo form_input($tgl_input);
                ?>
                </td>
              </tr>
  
              <tr>
                <td align="left" width="15%"  class="bg-grid">
                  <b>Keterangan</b>
                </td>
                <td  class="bg-grid"> 
                  <textarea name="keterangan" style="width:100%" class="input-area-wrc"><?php echo $keterangan; ?></textarea>
                </td>
              </tr>