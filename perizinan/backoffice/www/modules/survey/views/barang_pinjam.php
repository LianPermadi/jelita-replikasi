<?php 
foreach ($barang as $row) { 
  $id = $row->id;
  $jumlah = $row->jumlah;
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
    
    <div class="entry">
        <div id="tabs">
            <div id="tabs-1">
              <form method="post" action="<?php echo site_url().'permintaanbarang/'.$step; ?>" enctype="multipart/form-data">
                <?php 
                  if ($step == "update") { ?>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                  <?php } ?>
                <table cellpadding="0" cellspacing="0" border="0" class="display">
                  <tbody>
                    <tr>
                      <td align="left" width="15%">
                        <b>Jumlah Saat ini</b>
                      </td>
                      <td>
<!--                         <select class="pilihan" name="peminjam" style="width:100%">
                          <option value="-">-</option>
                          <?php foreach ($user as $row) { ?>
                            <option value="<?php echo $row->id; ?>">
                              <?php echo $row->n_pegawai." - ".$row->n_jabatan; ?>
                            </option>
                          <?php } ?>
                        </select> -->
                        <?php echo $jumlah; ?>
                        <input type="hidden" name="saatini" value="<?php echo $jumlah; ?>">
                      </td>
                    </tr>
                    <tr>
                      <td align="left" width="15%" class="bg-grid">Jumlah</td>
                      <td class="bg-grid">
                        <input type="number" name="jumlah" style="width:100%" class="pilihan">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
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
          <input type="submit" name="submit" value="Add to cart" class="submit-wrc" content="Add to cart">
        <?php } ?>
      
      <span></span>
      <button name="button" type="button" class="button-wrc" onclick="parent.location='<?php echo site_url('permintaanbarang/barang'); ?>'">Batal</button>
    </div>
  </form>
  </div>
  <br style="clear: both;" />
</div>
