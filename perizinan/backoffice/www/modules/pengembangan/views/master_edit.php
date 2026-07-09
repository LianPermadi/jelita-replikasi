<?php 
  if (!empty($ruangan)) {
    $nama_ruangan = $ruangan->nama_ruangan;
    $lantai = $ruangan->lantai;
    $kapasitas = $ruangan->kapasitas;
    $fasilitas = $ruangan->fasilitas;
    $id = $ruangan->id;
  } else {
    $nama_ruangan = "";
    $lantai = "";
    $kapasitas = "";
    $fasilitas = "";
    $id = "";
  }
 ?>

<div id="content">
  <div class="post">
    <div class="title">
      <h2><?php echo $page_name; ?></h2>
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
    <form method="post" action="<?php echo site_url().'ruangan/'.$step; ?>" enctype="multipart/form-data">
    <div class="entry">
      <div id="tabs">
        <ul>
          <li><a href="#tabs-1">Input Master Ruangan</a></li>
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
                  <b>Nama Ruangan</b>
                </td>
                <td>
                  <input type="text" name="nama_ruangan" style="width:100%" class="input-wrc" value="<?php echo $nama_ruangan; ?>" required="required">
                </td>
              </tr>
              <tr>
                <td align="left" width="15%" class="bg-grid">
                  <b>Lantai</b>
                </td>
                <td class="bg-grid">
                  <input type="text" name="lantai" style="width:100%" class="input-wrc" value="<?php echo $lantai; ?>" required="required">
                </td>
              </tr>
              <tr>
                <td align="left" width="15%">
                  <b>Kapasitas</b>
                </td>
                <td>
                  <input type="text" name="kapasitas" style="width:100%" class="input-wrc" value="<?php echo $kapasitas; ?>" required="required">
                </td>
              </tr>
              <tr>
                <td align="left" width="15%" class="bg-grid">
                  <b>Fasilitas</b>
                </td>
                <td class="bg-grid">
                  <textarea name="fasilitas" style="width:100%" class="input-area-wrc"><?php echo $fasilitas; ?></textarea>
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
        if ($step == "master_simpan") { ?>
          <input type="submit" name="submit" value="Simpan" class="submit-wrc" content="Simpan">
        <?php } else { ?>
          <input type="submit" name="submit" value="Ubah" class="submit-wrc" content="Ubah">
        <?php } ?>
      
      <span></span>
      <button name="button" type="button" class="button-wrc" onclick="parent.location='<?php echo site_url('ruangan/master'); ?>'">Batal</button>
    </div>
  </form>
  </div>
  <br style="clear: both;" />
</div>
