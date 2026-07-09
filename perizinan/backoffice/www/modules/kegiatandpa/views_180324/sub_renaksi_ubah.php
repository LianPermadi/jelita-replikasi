<?php 
// var_dump($anggota);die();
  if (!empty($subrenaksi)) {
    $id = $subrenaksi->id;
    $id_renaksi = $subrenaksi->renaksi_id;
    $sub_renaksi = $subrenaksi->sub_renaksi;
    $pic = $subrenaksi->pic;
    $r_anggaran = $subrenaksi->r_anggaran;
    $sub_t1 = $subrenaksi->t1;
    $sub_t2 = $subrenaksi->t2;
    $sub_t3 = $subrenaksi->t3;
    $sub_t4 = $subrenaksi->t4;
    $sub_t5 = $subrenaksi->t5;
    $sub_t6 = $subrenaksi->t6;
    $sub_t7 = $subrenaksi->t7;
    $sub_t8 = $subrenaksi->t8;
    $sub_t9 = $subrenaksi->t9;
    $sub_t10 = $subrenaksi->t10;
    $sub_t11 = $subrenaksi->t11;
    $sub_t12 = $subrenaksi->t12;
    $sub_r1 = $subrenaksi->r1;
    $sub_r2 = $subrenaksi->r2;
    $sub_r3 = $subrenaksi->r3;
    $sub_r4 = $subrenaksi->r4;
    $sub_r5 = $subrenaksi->r5;
    $sub_r6 = $subrenaksi->r6;
    $sub_r7 = $subrenaksi->r7;
    $sub_r8 = $subrenaksi->r8;
    $sub_r9 = $subrenaksi->r9;
    $sub_r10 = $subrenaksi->r10;
    $sub_r11 = $subrenaksi->r11;
    $sub_r12 = $subrenaksi->r12;
    $keterangan = $subrenaksi->keterangan;

          $sasaran_renaksi = $this->m_renaksi->get_sub_renaksi_id($id);
          // $ambil_kdtim = $sasaran_renaksi[0]->renaksi_id;
          $ambil_tim = $this->m_renaksi->get_kdtim($id_renaksi);
          $ketua_tim = $this->m_renaksi->get_id_ketua($ambil_tim);
          $ketua = $this->m_renaksi->get_ketua($ketua_tim);
          $anggaran = $this->m_renaksi->get_anggaran($ambil_tim);
          // $sasaran_renaksi = $sasaran_renaksi[0]->sub_renaksi;
          $sasaran_renaksi = $this->m_renaksi->get_sasaran_renaksi_sub($sasaran_renaksi[0]->renaksi_id);
           $anggota = $this->m_renaksi->get_anggota_tim2($ambil_tim);
           // var_dump($ketua_tim);die();



          
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
          <li><a href="#tabs-1">Edit Sub Renaksi</a></li>
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
                      <option value="<?php echo $row->id; ?>" <?php echo ($ambil_tim == $row->id ? "selected" : ""); ?>><?php echo $row->nama_tim." (Ketua Tim : ".$this->m_renaksi->get_ketua($row->ketua)." )"; ?></option>
                    <?php } ?>
                  </select>
                </td>
              </tr>
              <tr>
                <td align="left" width="15%" class="bg-grid">
                  <b>Kegiatan</b>
                </td>
                <td class="bg-grid">
                  <textarea name="aktivitas" style="width:100%" class="input-area-wrc" required readonly><?php echo $sasaran_renaksi; ?></textarea>
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
                      <option value="<?php echo $row->id_pegawai; ?>" <?php echo ($row->id_pegawai == $pic ? "selected" : ""); ?>><?php echo $this->m_renaksi->get_n_pegawai($row->id_pegawai); ?></option>
                    <?php } ?>
                  </select>
                </td>
              </tr>
              <tr>
                <td align="left" width="15%" class="bg-grid">
                  <b>Anggaran</b><br>*diisi angka
                </td>
                <td class="bg-grid">
                  <input type="text" name="r_anggaran" style="width:20%" class="input-wrc" value="<?php echo number_format($anggaran,0,',','.');?>" required="required" readonly>
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
      <button name="button" type="button" class="button-wrc" onclick="parent.location='<?php echo site_url('kegiatandpa/add_subrenaksi/'.$id_renaksi); ?>'">Batal</button>
    </div>
  </form>
        </div>
      </div>
        <label>&nbsp;</label>
        <div class="spacer"></div>
    </div>
  </div>
  <br style="clear: both;" />
</div>
