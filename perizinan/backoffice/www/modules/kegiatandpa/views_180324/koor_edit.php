<?php
// var_dump($tim);die();
  if (!empty($tim)) {
    $nama_tim = $tim->nama_tim;
    $pengampu = $tim->pengampu;
    $ketua = $tim->ketua;
  } else {
    $nama_tim = "";
    $pengampu = "";
    $ketua = "";
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
          if ($step == "master_update") { ?>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
          <?php } ?>
          <table cellpadding="0" cellspacing="0" border="0" class="display">
            <tbody>
              <tr>
                <td align="left" width="15%">
                  <b>Nama tim</b>
                </td>
                <td>
                  <input type="text" name="nama_tim" style="width:100%" class="input-wrc" value="<?php echo $nama_tim; ?>" required="required">
                </td>
              </tr>
              <tr>
                <td align="left" width="15%">
                  <b>Id Pengampu</b>
                </td>
                <td>
                  <input type="text" name="pengampu" style="width:100%" class="input-wrc" value="<?php echo $pengampu; ?>" required="required">
                </td>
              </tr>
              <tr>
                <td align="left" width="15%" class="bg-grid">
                  <b>Nama Pengampu</b>
                </td>
                <td class="bg-grid">
                  <select class="pilihan" name="id_pegawai" style="width:100%">
                      <option value="0" <?php // echo ($pengampu == "0" ? "selected" : ""); ?>> - </option>
                      <?php foreach ($pegawai as $pegawai): ?>
                        <option value="<?php echo $pegawai->id; ?>" <?php //echo ($pengampu == "1" ? "selected" : ""); ?>><?php echo $pegawai->n_pegawai; ?></option>
                      <?php endforeach ?>
                      
                  </select>
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
        if ($step == "koor_simpan") { ?>
          <input type="submit" name="submit" value="Simpan" class="submit-wrc" content="Simpan">
        <?php } else { ?>
          <input type="submit" name="submit" value="Ubah" class="submit-wrc" content="Ubah">
        <?php } ?>
      
      <span></span>
      <button name="button" type="button" class="button-wrc" onclick="parent.location='<?php echo site_url('kegiatandpa/set_koor'); ?>'">Batal</button>
    </div>
  </form>
  </div>
  <br style="clear: both;" />
</div>
