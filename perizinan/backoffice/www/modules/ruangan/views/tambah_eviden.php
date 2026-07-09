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
    <form method="post" action="<?php echo site_url().'ruangan/'.$step; ?>" enctype="multipart/form-data">
    <div class="entry">
      <div id="tabs">
        <ul>
          <li><a href="#tabs-1">Input Eviden Ruangan</a></li>
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
                                        <b>Pilih Pegawai</b>
                                    </td>
                                    <td>
                                        <select class="pilihan" name="pegawai" style="width:100%" class="input-wrc" required>
                                            <option value="-">-</option>
                                            <?php foreach ($data_pegawai as $row) { ?>
                                            <option value="<?php echo $row->id; ?>"><?php echo $row->n_pegawai; ?></option>
                                            <?php } ?>
                                            <?php ?>
                                        </select>
                                        <input type="hidden" name="id_kegiatan" value="<?php echo $id_kegiatan; ?>">
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
      <button name="button" type="button" class="button-wrc" onclick="parent.location='<?php echo site_url('ruangan/master'); ?>'">Batal</button>
    </div>
  </form>
  </div>
  <br style="clear: both;" />
</div>
