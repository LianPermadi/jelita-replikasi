<?php
// var_dump($tim);die();
  if (!empty($ketua)) {
    $id = $ketua->id;
    $id_koor = $ketua->id_koor;
    $nama_tim = $ketua->nama_tim;
    $kode_ketua = $ketua->id_ketua;
    $katim = $ketua->id_pegawai;
    $kode_tim = $ketua->kode_tim;
    $tahun = $ketua->thn_anggaran;
  } else {
    $id_koor = "";
    $nama_tim = "";
    $kode_ketua = "";
    $katim = "";
    $kode_tim = "";
    $id = "";
    $tahun = "";
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
          if ($step == "ketua_ubah") { ?>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
          <?php } ?>
          <table cellpadding="0" cellspacing="0" border="0" class="display">
            <tbody>
              <tr>
                <td align="left" width="15%" class="bg-grid">
                  <b>Nama tim</b>
                </td>
                <td class="bg-grid">
                  <input type="text" name="nama_tim" style="width:100%" class="input-wrc" value="<?php echo $nama_tim; ?>" required="required">
                </td>
              </tr>
              <tr>
                <td align="left" width="15%">
                  <b>Kode Ketua</b>
                </td>
                <td>
                  <input type="text" name="kode_ketua" style="width:100%" class="input-wrc" value="<?php echo $kode_ketua; ?>" required="required">
                </td>
              </tr>
              <tr>
                <td align="left" width="15%" class="bg-grid">
                  <b>POP/POK</b>
                </td>
                <td class="bg-grid">
                  <select class="pilihan" name="id_koor" style="width:100%">
                      <?php foreach ($get_koor as $koor): ?>
                        <option value="<?php echo $koor->id; ?>" <?php echo ($id_koor == $koor->id ? "selected" : ""); ?>><?php echo $this->m_renaksi->get_n_pegawai($koor->id_pegawai); ?></option>
                      <?php endforeach ?>
                      
                  </select>
                </td>
              </tr>
              <tr>
                <td align="left" width="15%" class="bg-grid">
                  <b>Ketua Tim</b>
                </td>
                <td class="bg-grid">
                  <select class="pilihan" name="id_pegawai" style="width:100%">
                      <?php foreach ($pegawai as $pegawai): ?>
                        <option value="<?php echo $pegawai->id; ?>" <?php echo ($katim == $pegawai->id ? "selected" : ""); ?>><?php echo $pegawai->n_pegawai; ?></option>
                      <?php endforeach ?>
                      
                  </select>
                </td>
              </tr>
              <tr>
                <td align="left" width="15%">
                  <b>Kode Tim</b>
                </td>
                <td>
                  <input type="text" name="kode_tim" style="width:100%" class="input-wrc" value="<?php echo $kode_tim; ?>" required="required">
                </td>
              </tr>
              <tr>
                <td align="left" width="15%" class="bg-grid">
                  <b>Tahun Anggaran</b>
                </td>
                <td class="bg-grid">
                  <input type="text" name="tahun" style="width:100%" class="input-wrc" value="<?php echo $tahun; ?>" required="required">
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
        if ($step == "ketua_simpan") { ?>
          <input type="submit" name="submit" value="Simpan" class="submit-wrc" content="Simpan">
        <?php } else { ?>
          <input type="submit" name="submit" value="Ubah" class="submit-wrc" content="Ubah">
        <?php } ?>
      
      <span></span>
      <button name="button" type="button" class="button-wrc" onclick="parent.location='<?php echo site_url('kegiatandpa/set_ketua'); ?>'">Batal</button>
    </div>
  </form>
  </div>
  <br style="clear: both;" />
</div>
