<style>
  /* Gaya untuk memperbesar textarea dan menambahkan border */
  textarea.input-wrc {
      width: 100%;
      height: 150px; /* Ubah tinggi sesuai kebutuhan */
      border: 1px solid #ccc; /* Warna dan ketebalan border */
      padding: 5px; /* Ruang di dalam textarea */
      box-sizing: border-box; /* Menyertakan padding dan border dalam kalkulasi lebar */
      background-color:white;
  }
</style>
<div id="content">
  <div class="post">
    <div class="title">
      <?php echo $page_name; ?>
    </div>

    <?php 
        $clean_uri  = $_SERVER['PHP_SELF'];
    if (strpos($clean_uri, 'index.php') !== false) {
        $clean_uri = str_replace('index.php', '', $clean_uri);
    }
    $request_uri = $clean_uri;
    $clean_uri_luar  = $_SERVER['PHP_SELF'];
    if (strpos($request_uri, 'index.php') !== false) {
        $clean_uri_luar = str_replace('index.php', '', $request_uri);
    }
    if (strpos($request_uri, 'backoffice/') !== false) {
        $clean_uri_luar = str_replace('backoffice/', '', $request_uri);
    }
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
            <li><a href="#tabs-1">Input keterangan</a></li>
           <!--  <li><a href="#tabs-2">Daftar Value</a></li> -->
          </ul>
            <div id="tabs-1">
              <form method="post" action="<?php echo $clean_uri; ?>pelayanan/komitmen_oss/kirim/<?php echo $id; ?>" enctype="multipart/form-data">
                <?php 
                  if ($step == "update") { ?>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                  <?php } ?>
                <table cellpadding="0" cellspacing="0" border="0" class="display">
                  <tbody>

                      <tr>
                      <td align="left" width="15%" >
                        <b>Pernyataan Keterangan</b>
                      </td>
                      <td>
                        <textarea name="keterangan_ky" style="width:100%" class="input-wrc" required="required"></textarea>
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
      <button name="button" type="button" class="button-wrc" onclick="parent.location='<?php echo site_url('pelayanan/komitmen_oss'); ?>'">Batal</button>
    </div>
  </form>
  </div>
  <br style="clear: both;" />
</div>
