<?php 
  if (!empty($program)) {
    $id_tim = $program->kd_tim;
    $id = $program->id;
    $sasaran = $program->sasaran_program;
    $indikator = $program->indikator_program;
    $target_tahun = $program->target_tahun;
    $satuan = $program->satuan;
    $t1 = $program->t1;
    $t2 = $program->t2;
    $t3 = $program->t3;
    $t4 = $program->t4;
    $t5 = $program->t5;
    $t6 = $program->t6;
    $t7 = $program->t7;
    $t8 = $program->t8;
    $t9 = $program->t9;
    $t10 = $program->t10;
    $t11 = $program->t11;
    $t12 = $program->t12;
    $r1 = $program->r1;
    $r2 = $program->r2;
    $r3 = $program->r3;
    $r4 = $program->r4;
    $r5 = $program->r5;
    $r6 = $program->r6;
    $r7 = $program->r7;
    $r8 = $program->r8;
    $r9 = $program->r9;
    $r10 = $program->r10;
    $r11 = $program->r11;
    $r12 = $program->r12;

  } else {
    $id_tim = "";
    $id = "";
    $sasaran = "";
    $indikator = "";
    $target_tahun = "";
    $satuan = "";
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
          <li><a href="#tabs-1">Input Program Tim Of Tim</a></li>
        </ul>
        <div id="tabs-1">
        <?php 
          if ($step == "program_update") { ?>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
          <?php } ?>
          <table cellpadding="0" cellspacing="0" border="0" class="display">
            <tbody>
              <tr>
                <td align="left" width="15%">
                  <b>Tim</b>
                </td>
                <td>
                  <select class="pilihan" name="id_tim" style="width:100%">
                    <?php foreach ($tim as $row) {
                    $ambil_ketua = $this->m_renaksi->get_ketua($row->ketua); ?>
                      <option value="<?php echo $row->id; ?>" <?php echo ($id_tim == $row->id ? "selected" : ""); ?>><?php echo $row->nama_tim." (Ketua Tim : ".$this->m_renaksi->get_ketua($row->ketua)." )"; ?></option>
                    <?php } ?>
                  </select>
                </td>
              </tr>
              <tr>
                <td align="left" width="15%" class="bg-grid">
                  <b>Sasaran Program/ Kegiatan/ <br>Sub Kegiatan (TOT)</b>
                </td>
                <td class="bg-grid">
                  <textarea name="sasaran" style="width:100%" class="input-area-wrc" required><?php echo $sasaran; ?></textarea>
                </td>
              </tr>
              <tr>
                <td align="left" width="15%">
                  <b>Indikator</b>
                </td>
                <td>
                  <textarea name="indikator" style="width:100%" class="input-area-wrc" required><?php echo $indikator; ?></textarea>
                </td>
              </tr>
              <tr>
                <td align="left" width="15%" class="bg-grid">
                  <b>Target Tahunan</b><br>*diisi angka
                </td>
                <td class="bg-grid">
                  <input type="number" name="target_tahun" style="width:10%" class="input-wrc" value="<?php echo $target_tahun; ?>" required="required">
                   <b>Satuan : </b><input type="text" name="satuan" style="width:20%" class="input-wrc" value="<?php echo $satuan; ?>" required="required">
                </td>
              </tr>
              <tr>
                <td align="left" width="15%">
                  <b>Target Kinerja Per Bulan</b>
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
                  <b>Realisasi Kinerja Per Bulan</b>
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
            </tbody>
          </table>
        </div>
      </div>
        <label>&nbsp;</label>
        <div class="spacer"></div>
    </div>
    <div class="entry" style="text-align: center;">
      <?php 
        if ($step == "program_simpan") { ?>
          <input type="submit" name="submit" value="Simpan" class="submit-wrc" content="Simpan">
        <?php } else { ?>
          <input type="submit" name="submit" value="Ubah" class="submit-wrc" content="Ubah">
        <?php } ?>
      
      <span></span>
      <button name="button" type="button" class="button-wrc" onclick="parent.location='<?php echo site_url('kegiatandpa/renaksi'); ?>'">Batal</button>
    </div>
  </form>
  </div>
  <br style="clear: both;" />
</div>
