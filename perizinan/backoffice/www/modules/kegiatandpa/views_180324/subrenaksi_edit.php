<?php 
// var_dump($anggota);die();
  if (!empty($renaksi)) {
    $id_tim = "";
    $aktivitas = "";
    $sub_renaksi = "";
    $target_tahun = "";
    $r_anggaran = "";
    $sub_t1 = "";
    $sub_t2 = "";
    $sub_t3 = "";
    $sub_t4 = "";
    $sub_t5 = "";
    $sub_t6 = "";
    $sub_t7 = "";
    $sub_t8 = "";
    $sub_t9 = "";
    $sub_t10 = "";
    $sub_t11 = "";
    $sub_t12 = "";
    $sub_r1 = "";
    $sub_r2 = "";
    $sub_r3 = "";
    $sub_r4 = "";
    $sub_r5 = "";
    $sub_r6 = "";
    $sub_r7 = "";
    $sub_r8 = "";
    $sub_r9 = "";
    $sub_r10 = "";
    $sub_r11 = "";
    $sub_r12 = "";
    $keterangan = "";
    $id_tim = $renaksi->kd_tim;
    // $id = $renaksi->id;
    $aktivitas = $renaksi->sasaran_renaksi;
    $anggaran = $renaksi->anggaran_tot;
  }
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
          <table cellpadding="0" cellspacing="0" border="0" class="display">
            <tbody>
              <tr>
                <td align="left" width="15%">
                  <b>Tim</b>
                </td>
                <td>
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
              <tr>
                <td align="left" width="15%">
                  <b>Rincian Aktivitas</b>
                </td>
                <td>
                  <textarea name="sub_renaksi" style="width:100%" class="input-area-wrc" required><?php echo $sub_renaksi; ?></textarea>
                </td>
              </tr>
              <tr>
                <td align="left" width="15%">
                  <b>PIC</b>
                </td>
                <td>
                  <select class="pilihan" name="pic" style="width:100%">
                      <?php foreach ($anggota as $row) { ?>
                      <option value="<?php echo $row->id_pegawai; ?>" <?php echo ($id_tim == $row->kd_tim ? "selected" : ""); ?>><?php echo $this->m_renaksi->get_anggota_tim($row->id_pegawai); ?></option>
                    <?php } ?>
                  </select>
                </td>
              </tr>
              <tr>
                <td align="left" width="15%" class="bg-grid">
                  <b>Anggaran</b><br>*diisi angka
                </td>
                <td class="bg-grid">
                  <input type="text" name="anggaran" style="width:20%" class="input-wrc" value="<?php echo number_format($anggaran,0,',','.');?>" required="required" readonly>
                   <b>Rencana Anggaran : </b><input type="number" name="r_anggaran" style="width:20%" class="input-wrc" value="<?php echo $r_anggaran; ?>" >
                </td>
              </tr>
              <tr>
                <td align="left" width="15%">
                  <b>Target Kinerja Per Bulan</b>
                </td>
                <td>
                  <b>TW 1</b>-<input type="text" name="sub_t1" style="width:6%" class="input-wrc" value="<?php echo $sub_t1; ?>" >
                  <input type="text" name="sub_t2" style="width:6%" class="input-wrc" value="<?php echo $sub_t2; ?>" >
                  <input type="text" name="sub_t3" style="width:6%" class="input-wrc" value="<?php echo $sub_t3; ?>" > - 
                  <b>TW 2</b>-<input type="text" name="sub_t4" style="width:6%" class="input-wrc" value="<?php echo $sub_t4; ?>" >
                  <input type="text" name="sub_t5" style="width:6%" class="input-wrc" value="<?php echo $sub_t5; ?>" >
                  <input type="text" name="sub_t6" style="width:6%" class="input-wrc" value="<?php echo $sub_t6; ?>" >
                  <b>TW 3</b>-<input type="text" name="sub_t7" style="width:6%" class="input-wrc" value="<?php echo $sub_t7; ?>" >
                  <input type="text" name="sub_t8" style="width:6%" class="input-wrc" value="<?php echo $sub_t8; ?>" >
                  <input type="text" name="sub_t9" style="width:6%" class="input-wrc" value="<?php echo $sub_t9; ?>" > - 
                  <b>TW 4</b>-<input type="text" name="sub_t10" style="width:6%" class="input-wrc" value="<?php echo $sub_t10; ?>" >
                  <input type="text" name="sub_t11" style="width:6%" class="input-wrc" value="<?php echo $sub_t11; ?>" >
                  <input type="text" name="sub_t12" style="width:6%" class="input-wrc" value="<?php echo $sub_t12; ?>" >
                </td>
              </tr>
              <tr>
                <td align="left" width="15%" class="bg-grid">
                  <b>Realisasi Kinerja Per Bulan</b>
                </td>
                <td class="bg-grid">
                  <b>TW 1</b>-<input type="text" name="sub_r1" style="width:6%" class="input-wrc" value="<?php echo $sub_r1; ?>" >
                  <input type="text" name="sub_r2" style="width:6%" class="input-wrc" value="<?php echo $sub_r2; ?>" >
                  <input type="text" name="sub_r3" style="width:6%" class="input-wrc" value="<?php echo $sub_r3; ?>" > - 
                  <b>TW 2</b>-<input type="text" name="sub_r4" style="width:6%" class="input-wrc" value="<?php echo $sub_r4; ?>" >
                  <input type="text" name="sub_r5" style="width:6%" class="input-wrc" value="<?php echo $sub_r5; ?>" >
                  <input type="text" name="sub_r6" style="width:6%" class="input-wrc" value="<?php echo $sub_r6; ?>" >
                  <b>TW 3</b>-<input type="text" name="sub_r7" style="width:6%" class="input-wrc" value="<?php echo $sub_r7; ?>" >
                  <input type="text" name="sub_r8" style="width:6%" class="input-wrc" value="<?php echo $sub_r8; ?>" >
                  <input type="text" name="sub_r9" style="width:6%" class="input-wrc" value="<?php echo $sub_r9; ?>" > - 
                  <b>TW 4</b>-<input type="text" name="sub_r10" style="width:6%" class="input-wrc" value="<?php echo $sub_r10; ?>" >
                  <input type="text" name="sub_r11" style="width:6%" class="input-wrc" value="<?php echo $sub_r11; ?>" >
                  <input type="text" name="sub_r12" style="width:6%" class="input-wrc" value="<?php echo $sub_r12; ?>" >
                </td>
              </tr>
              <tr>
                <td align="left" width="15%">
                  <b>Keterangan</b>
                </td>
                <td>
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
      <button name="button" type="button" class="button-wrc" onclick="parent.location='<?php echo site_url('kegiatandpa/'); ?>'">Batal</button>
    </div>
  </form>
        </div>
        <div id="tabs-2">
          <?php 
          $ambil_tim = $this->m_renaksi->get_kdtim($id);
          $ketua_tim = $this->m_renaksi->get_id_ketua($ambil_tim);
          $ketua = $this->m_renaksi->get_ketua($ketua_tim);
          $sasaran_renaksi = $this->m_renaksi->get_sasaran_renaksi($ambil_tim);
          ?>

          <h3>Kegiatan : <?php echo $sasaran_renaksi; ?></h3>
          <h3>Ketua Tim : <?php echo $ketua; ?></h3>
        <table cellpadding="0" cellspacing="0" border="0" class="display" id="pendataan">
        <thead>
          <tr>
            <th>No</th>
            <th>Kegiatan<br>Rincian Aktivitas</th>
            <th>PIC</th>
            <th>Rencana Anggaran</th>
            <th>Target Kinerja Bulanan<br>Realisasi Kinerja Bulanan</th>
            <th>Keterangan</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $i = 1; 
          foreach ($subrenaksi as $row) {
          ?>
          <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo "<b>".$sasaran_renaksi."</b><br>- ".$row->sub_renaksi;?></td>
            <td><?php echo $this->m_renaksi->get_anggota_tim($row->pic); ?></td>
            <td><?php echo number_format($row->r_anggaran,0,',','.');?></td>
            <td>
                        <center>
                        <table border='1'>
                          <tr>
                            <th>B1</th>
                            <th>B2</th>
                            <th>B3</th>
                            <th>B4</th>
                            <th>B5</th>
                            <th>B6</th>
                            <th>B7</th>
                            <th>B8</th>
                            <th>B9</th>
                            <th>B10</th>
                            <th>B11</th>
                            <th>B12</th>
                          </tr>
                           <tr span style="color: orange">
                             <td><?php echo $row->t1; ?></td>
                             <td><?php echo $row->t2; ?></td>
                             <td><?php echo $row->t3; ?></td>
                             <td><?php echo $row->t4; ?></td>
                             <td><?php echo $row->t5; ?></td>
                             <td><?php echo $row->t6; ?></td>
                             <td><?php echo $row->t7; ?></td>
                             <td><?php echo $row->t8; ?></td>
                             <td><?php echo $row->t9; ?></td>
                             <td><?php echo $row->t10; ?></td>
                             <td><?php echo $row->t11; ?></td>
                             <td><?php echo $row->t12; ?></td>
                           </tr>
                           <tr span style="color: green">
                             <td><?php echo $row->r1; ?></td>
                             <td><?php echo $row->r2; ?></td>
                             <td><?php echo $row->r3; ?></td>
                             <td><?php echo $row->r4; ?></td>
                             <td><?php echo $row->r5; ?></td>
                             <td><?php echo $row->r6; ?></td>
                             <td><?php echo $row->r7; ?></td>
                             <td><?php echo $row->r8; ?></td>
                             <td><?php echo $row->r9; ?></td>
                             <td><?php echo $row->r10; ?></td>
                             <td><?php echo $row->r11; ?></td>
                             <td><?php echo $row->r12; ?></td>
                           </tr>
                        </table>
                        </center>
                      </td>
            <td><?php echo $row->keterangan; ?></td>
            <td>
              <?php 
                echo '<a href="'.base_url().'kegiatandpa/edit_subrenaksi/'.$row->id.'"><img src="'.base_url().'assets/images/icon/property.png" alt="Edit Data" title="Edit Data" border="0"></a>&nbsp;';
              ?>
              <!-- <?php 
                echo '<a href="'.base_url().'kegiatandpa/subrenaksi/'.$row->id.'"><img src="'.base_url().'assets/images/icon/arrow_biru.png" alt="Teruskan ke Anggota" title="Teruskan ke Anggota" border="0" height="50%" width="50%"></a>&nbsp;';
              ?> -->
              <a href="#" onclick="if (confirm('Yakin Hapus Data?')) parent.location='<?php echo  site_url('kegiatandpa/hapus_sub_renaksi/'.$row->id); ?>'"><img src="<?php echo base_url().'assets/images/icon/cross.png'; ?>" alt="Hapus Data" title="Hapus Data" border="0"></a>&nbsp;
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
