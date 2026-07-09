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
    <form method="post" action="<?php echo site_url().'pengembangan/gpt/update_akun_gpt'; ?>" enctype="multipart/form-data">
    <div class="entry">
      <div id="tabs">
        <ul>
          <li><a href="#tabs-1">Ubah Nib</a></li>
        </ul>
        <div id="tabs-1">
          <table cellpadding="0" cellspacing="0" border="0" class="display">
            <tbody>
            <?php foreach ($akun as $row) { ?>
              <tr>
                <td align="left" width="15%" class="bg-grid">
                  <b>NIB</b>
                </td>
                <td class="bg-grid">
                  <input type="hidden" class="input-wrc" style="width:100%" name="id" value="<?php echo $row->id; ?>">
                </td>
              </tr>
              <tr>
                <td align="left" width="15%">
                  <b>Event</b>
                </td>
                <td>
                  <input type="text" class="input-wrc" style="width:100%" name="n_event" value="<?php echo $row->n_event; ?>">
                </td>
              </tr>
              <tr>
                <td align="left" width="15%">
                  <b>Lokasi</b>
                </td>
                <td>
                  <input type="text" class="input-wrc" style="width:100%" name="lokasi" value="<?php echo $row->lokasi; ?>">
                </td>
              </tr>
              <tr>
                <td align="left" width="15%">
                  <b>Username</b>
                </td>
                <td>
                  <input type="text" class="input-wrc" style="width:100%" name="username" value="<?php echo $row->username; ?>">
                </td>
              </tr>
              <tr>
                <td align="left" width="15%">
                  <b>Password</b>
                </td>
                <td>
                  <input type="text" class="input-wrc" style="width:100%" name="password" value="<?php echo $row->password; ?>">
                </td>
              </tr>
              <tr>
                <td align="left" width="15%" class="bg-grid">
                  <b>jenis usaha</b>
                </td>
                <td class="bg-grid">
                <select class="pilihan"  style="width:100%" name="level" id="businessTypeSelect">
                    <option value="0" <?php if($row->level == '0'){ echo 'selected';} ?>>Admin</option>
                    <?php foreach($tb_layanan_gpt as $data){ ?>
                    <option value="<?php echo $data->id; ?>" <?php if($row->level == $data->id){ echo 'selected';} ?>><?php echo $data->instansi_lembaga; ?></option>
                    <?php } ?>
                </select>
                </td>
              </tr>
              <tr>
                <td align="left" width="15%">
                  <b>Session Token</b>
                </td>
                <td>
                  <input type="text" class="input-wrc" style="width:100%" name="session_token" value="<?php echo $row->session_token; ?>" readonly>
                </td>
              </tr>
            <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
        <label>&nbsp;</label>
        <div class="spacer"></div>
    </div>
    <div class="entry" style="text-align: center;">
      <?php 
        if ($step == "simpan") { ?>
          <input type="submit" name="submit" value="Simpan" class="submit-wrc" content="Simpan">
        <?php } else { ?>
          <input type="submit" name="submit" value="Ubah" class="submit-wrc" content="Ubah">
        <?php } ?>
      
      <span></span>
      <button name="button" type="button" class="button-wrc" onclick="parent.location='<?php echo site_url('pengembangan/gpt/akun_antrian'); ?>'">Batal</button>
    </div>
  </form>
  </div>
  <br style="clear: both;" />
</div>
