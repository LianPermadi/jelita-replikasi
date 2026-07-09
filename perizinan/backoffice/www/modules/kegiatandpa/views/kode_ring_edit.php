<?php
// var_dump($kodering);die();
  if (!empty($kodering)) {
    $id = $kodering->id;
    $kode_ring = $kodering->kode_ring;
    $uraian_kegiatan = $kodering->uraian_kegiatan;
    $anggaran = $kodering->anggaran;
    $tahun = $kodering->tahun;
    $t1 = $kodering->t1;
    $t2 = $kodering->t2;
    $t3 = $kodering->t3;
    $t4 = $kodering->t4;
    $t5 = $kodering->t5;
    $t6 = $kodering->t6;
    $t7 = $kodering->t7;
    $t8 = $kodering->t8;
    $t9 = $kodering->t9;
    $t10 = $kodering->t10;
    $t11 = $kodering->t11;
    $t12 = $kodering->t12;
    $r1 = $kodering->r1;
    $r2 = $kodering->r2;
    $r3 = $kodering->r3;
    $r4 = $kodering->r4;
    $r5 = $kodering->r5;
    $r6 = $kodering->r6;
    $r7 = $kodering->r7;
    $r8 = $kodering->r8;
    $r9 = $kodering->r9;
    $r10 = $kodering->r10;
    $r11 = $kodering->r11;
    $r12 = $kodering->r12;
  } else {
    $kode_ring = "";
    $uraian_kegiatan = "";
    $anggaran = "";
    $tahun = "";
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
    $id = "";
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
          <li><a href="#tabs-1">Input Master tim</a></li>
        </ul>
        <div id="tabs-1">
        <?php 
          if ($step == "kode_ring_ubah") { ?>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
          <?php } ?>
          <table cellpadding="0" cellspacing="0" border="0" class="display">
            <tbody>
              <tr>
                <td align="left" width="15%" class="bg-grid">
                  <b>Kode Ring</b>
                </td>
                <td class="bg-grid">
                  <input type="text" name="kode_ring" style="width:100%" class="input-wrc" value="<?php echo $kode_ring; ?>" required="required">
                </td>
              </tr>
              <tr>
                <td align="left" width="15%">
                  <b>Uraian Kegiatan</b>
                </td>
                <td>
                  <input type="text" name="uraian_kegiatan" style="width:100%" class="input-wrc" value="<?php echo $uraian_kegiatan; ?>" required="required">
                </td>
              </tr>
              <tr>
                <td align="left" width="15%" class="bg-grid">
                  <b>Anggaran</b>
                </td>
                <td class="bg-grid">
                  <input type="number" name="anggaran" style="width:100%" class="input-wrc" value="<?php echo $anggaran; ?>" required="required">
                </td>
              </tr>
              <tr>
                <td align="left" width="15%">
                  <b>Tahun</b>
                </td>
                <td>
                  <input type="number" name="tahun" style="width:100%" class="input-wrc" value="<?php echo $tahun; ?>" required="required">
                </td>
              </tr>
              <tr>
                <td align="left" width="15%"  class="bg-grid">
                  <b>Target Anggaran/Bulan</b><br>*isi dengan angka
                </td>
                <td class="bg-grid">
                  <b>TW 1</b>-<input type="text" name="t1" style="width:10%" class="input-wrc" value="<?php echo $t1; ?>" >
                  <input type="text" name="t2" style="width:10%" class="input-wrc" value="<?php echo $t2; ?>" >
                  <input type="text" name="t3" style="width:10%" class="input-wrc" value="<?php echo $t3; ?>" > - 
                  <b>TW 2</b>-<input type="text" name="t4" style="width:10%" class="input-wrc" value="<?php echo $t4; ?>" >
                  <input type="text" name="t5" style="width:10%" class="input-wrc" value="<?php echo $t5; ?>" >
                  <input type="text" name="t6" style="width:10%" class="input-wrc" value="<?php echo $t6; ?>" ><br>
                  <b>TW 3</b>-<input type="text" name="t7" style="width:10%" class="input-wrc" value="<?php echo $t7; ?>" >
                  <input type="text" name="t8" style="width:10%" class="input-wrc" value="<?php echo $t8; ?>" >
                  <input type="text" name="t9" style="width:10%" class="input-wrc" value="<?php echo $t9; ?>" > - 
                  <b>TW 4</b>-<input type="text" name="t10" style="width:10%" class="input-wrc" value="<?php echo $t10; ?>" >
                  <input type="text" name="t11" style="width:10%" class="input-wrc" value="<?php echo $t11; ?>" >
                  <input type="text" name="t12" style="width:10%" class="input-wrc" value="<?php echo $t12; ?>" >
                </td>
              </tr>
              <tr>
                <td align="left" width="15%">
                  <b>Realisasi Anggaran/Bulan</b><br>*isi dengan angka
                </td>
                <td>
                  <b>TW 1</b>-<input type="text" name="r1" style="width:10%" class="input-wrc" value="<?php echo $r1; ?>" >
                  <input type="text" name="r2" style="width:10%" class="input-wrc" value="<?php echo $r2; ?>" >
                  <input type="text" name="r3" style="width:10%" class="input-wrc" value="<?php echo $r3; ?>" > - 
                  <b>TW 2</b>-<input type="text" name="r4" style="width:10%" class="input-wrc" value="<?php echo $r4; ?>" >
                  <input type="text" name="r5" style="width:10%" class="input-wrc" value="<?php echo $r5; ?>" >
                  <input type="text" name="r6" style="width:10%" class="input-wrc" value="<?php echo $r6; ?>" ><br>
                  <b>TW 3</b>-<input type="text" name="r7" style="width:10%" class="input-wrc" value="<?php echo $r7; ?>" >
                  <input type="text" name="r8" style="width:10%" class="input-wrc" value="<?php echo $r8; ?>" >
                  <input type="text" name="r9" style="width:10%" class="input-wrc" value="<?php echo $r9; ?>" > - 
                  <b>TW 4</b>-<input type="text" name="r10" style="width:10%" class="input-wrc" value="<?php echo $r10; ?>" >
                  <input type="text" name="r11" style="width:10%" class="input-wrc" value="<?php echo $r11; ?>" >
                  <input type="text" name="r12" style="width:10%" class="input-wrc" value="<?php echo $r12; ?>" >
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
        if ($step == "kode_ring_simpan") { ?>
          <input type="submit" name="submit" value="Simpan" class="submit-wrc" content="Simpan">
        <?php } else { ?>
          <input type="submit" name="submit" value="Ubah" class="submit-wrc" content="Ubah">
        <?php } ?>
      
      <span></span>
      <button name="button" type="button" class="button-wrc" onclick="parent.location='<?php echo site_url('kegiatandpa/kode_ring'); ?>'">Batal</button>
    </div>
  </form>
  </div>
  <br style="clear: both;" />
</div>
