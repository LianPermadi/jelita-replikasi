<div id="content">
  <div class="post">
    <div class="title">
      <h2><?php 
      // var_dump($user);die();
      foreach ($user as $row) {
        $id_user = $row->id;
        $nama = $row->n_pegawai;
      }
      // var_dump($id_user);die();
      echo $page_name; 
    ?></h2>
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
    
    <div class="entry">
        <div id="tabs">
          <ul>
            <li><a href="#tabs-1">Input Barang</a></li>
          </ul>
            <div id="tabs-1">
              <form method="post" action="/spekta/backoffice/permintaanbarang/simpan" enctype="multipart/form-data">
                <?php 
                  if ($step == "update") { ?>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                  <?php } ?>
                <table cellpadding="0" cellspacing="0" border="0" class="display">
                  <tbody>
                    <tr>
                      <td align="left" width="15%" class="bg-grid">
                        <b>Nama Barang</b>
                      </td>
                      <td class="bg-grid">
                        <input type="text" name="nama_barang" style="width:100%" class="input-wrc" >
                      </td>
                    </tr>
                    <tr>
                      <td align="left" width="15%">
                        <b>Merk</b>
                      </td>
                      <td>
                        <input type="text" name="merk" style="width:100%" class="input-wrc" >
                      </td>
                    </tr>
                    <tr>
                      <td align="left" width="15%" class="bg-grid">
                        <b>Jumlah</b>
                      </td>
                      <td class="bg-grid">
                        <input type="text" name="jumlah" style="width:100%" class="input-wrc" >
                      </td>
                    </tr>
                    <tr>
                      <td align="left" width="15%">
                        <b>Satuan</b>
                      </td>
                      <td>
                        <select class="pilihan" name="satuan" style="width:100%" class="input-wrc" >
                          <option value="-">-</option>
                          <option value="Box">Box</option>
                          <option value="Buah">Buah</option>
                          <option value="Bungkus">Bungkus</option>
                          <option value="Dus">Dus</option>
                          <option value="Kecil">Kecil</option>
                          <option value="Lusin">Lusin</option>
                          <option value="Pak">Pak</option>
                          <option value="PCS">PCS</option>
                          <option value="Rim">Rim</option>
                          <option value="Roll">Roll</option>
                          <option value="Unit">Unit</option>
                        </select>
                        <input type="hidden" name="date" value="<?php echo date('Y-m-d G:i:s') ?>">
                      </td>
                    </tr>
                    <tr>
                      <td align="left" width="15%" class="bg-grid">
                        <b>Tempat Penyimpanan(RAK)</b>
                      </td>
                      <td class="bg-grid">
                        <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
                        <input type="hidden" name="nama" value="<?php echo $nama; ?>">
                        <input type="text" name="rak" style="width:100%" class="input-wrc" >
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
        if ($step == "simpan") { ?>
          <input type="submit" name="submit" value="Simpan" class="submit-wrc" content="Simpan">
        <?php } else { ?>
          <input type="submit" name="submit" value="Ubah" class="submit-wrc" content="Ubah">
        <?php } ?>
      
      <span></span>
      <button name="button" type="button" class="button-wrc" onclick="parent.location='<?php echo site_url('permintaanbarang/barang'); ?>'">Batal</button>
    </div>
  </form>
  </div>
  <br style="clear: both;" />
</div>
