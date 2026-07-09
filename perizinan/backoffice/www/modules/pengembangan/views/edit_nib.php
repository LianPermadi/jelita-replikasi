<div id="content">
  <div class="post">
    <div class="title">
      <?php echo $this->lib_date->view_title($page_name); ?>
    </div>

    <?php 
    $request_uri = $_SERVER['PHP_SELF'];
    $clean_uri  = $_SERVER['PHP_SELF'];
    // Periksa apakah 'index.php' ada dalam URL
    if (strpos($request_uri, 'index.php') !== false) {
        // Hapus 'index.php' dari URL
        $clean_uri = str_replace('index.php', '', $request_uri);
    }
$request_uri = $clean_uri;
$clean_uri_luar  = $_SERVER['PHP_SELF'];
// Periksa apakah 'index.php' ada dalam URL
if (strpos($request_uri, 'index.php') !== false) {
    // Hapus 'index.php' dari URL
    $clean_uri_luar = str_replace('index.php', '', $request_uri);
}
if (strpos($request_uri, 'backoffice/') !== false) {
    // Hapus 'index.php' dari URL
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
    <form method="post" action="<?php echo site_url().'pengembangan/nib/'.$step; ?>" enctype="multipart/form-data">
    <div class="entry">
      <div id="tabs">
        <ul>
          <li><a href="#tabs-1">Ubah Nib</a></li>
        </ul>
        <div id="tabs-1">
          <table cellpadding="0" cellspacing="0" border="0" class="display">
            <tbody>
            <?php foreach ($pakai as $row) { ?>
              <tr>
                <td align="left" width="15%" class="bg-grid">
                  <b>NIB</b>
                </td>
                <td class="bg-grid">
                  <input type="text" class="input-wrc" style="width:100%" name="nib_number" value="<?php echo $row->nib; ?>">
                  <input type="hidden" class="input-wrc" style="width:100%" name="id" value="<?php echo $row->id; ?>">
                </td>
              </tr>
              <tr>
                <td align="left" width="15%">
                  <b>kbli</b>
                </td>
                <td>
                  <input type="text" class="input-wrc" style="width:100%" name="kbli_number" value="<?php echo $row->kbli; ?>">
                </td>
              </tr>
              <tr>
                <td align="left" width="15%" class="bg-grid">
                  <b>Nomor Whatsapp</b>
                </td>
                <td class="bg-grid">
                  <input type="text" class="input-wrc" style="width:100%" name="phone_number" value="<?php echo $row->no_wa; ?>">
                </td>
              </tr>
              <tr>
                <td align="left" width="15%">
                  <b>nik</b>
                </td>
                <td>
                  <input type="text" class="input-wrc" style="width:100%" name="nik" value="<?php echo $row->nik; ?>">
                </td>
              </tr>
              <tr>
                <td align="left" width="15%" class="bg-grid">
                  <b>email</b>
                </td>
                <td class="bg-grid">
                  <input type="text" class="input-wrc" style="width:100%" name="email" value="<?php echo $row->email; ?>">
                </td>
              </tr>
              <tr>
                <td align="left" width="15%">
                  <b>nama</b>
                </td>
                <td>
                  <input type="text" class="input-wrc" style="width:100%" name="name_ktp" value="<?php echo $row->nama; ?>">
                </td>
              </tr>
              <tr>
                <td align="left" width="15%" class="bg-grid">
                  <b>tanggal lahir</b>
                </td>
                <td class="bg-grid">
                  <input type="date" class="input-wrc" style="width:100%" name="birthdate" value="<?php echo $row->tanggal_lahir; ?>">
                </td>
              </tr>
              <tr>
                <td align="left" width="15%">
                  <b>alamat</b>
                </td>
                <td>
                  <input type="text" class="input-wrc" style="width:100%" name="address_ktp" value="<?php echo $row->alamat; ?>">
                </td>
              </tr>
              <tr>
                <td align="left" width="15%" class="bg-grid">
                  <b>kecamatan</b>
                </td>
                <td class="bg-grid">
                  <input type="text" class="input-wrc" style="width:100%" name="district_ktp" value="<?php echo $row->kecamatan; ?>">
                </td>
              </tr>
              <tr>
                <td align="left" width="15%">
                  <b>kelurahan</b>
                </td>
                <td>
                  <input type="text" class="input-wrc" style="width:100%" name="subdistrict_ktp" value="<?php echo $row->kelurahan; ?>">
                </td>
              </tr>
              <tr>
                <td align="left" width="15%" class="bg-grid">
                  <b>jenis usaha</b>
                </td>
                <td class="bg-grid">
                <select class="pilihan"  style="width:100%" name="business_type" id="businessTypeSelect">
                    <option value="pendapatan_per_tahun" <?php if($row->j_usaha == "pendapatan_per_tahun"){ echo 'selected';} ?>>Pendapatan/Penghasilan Per-Tahun</option>
                    <option value="jasa" <?php if($row->j_usaha == "jasa"){ echo 'selected';} ?>>Jasa</option>
                    <option value="industri_rumahan" <?php if($row->j_usaha == "industri_rumahan"){ echo 'selected';} ?>>Industri Rumahan</option>
                    <option value="kedai" <?php if($row->j_usaha == "kedai"){ echo 'selected';} ?>>Kedai</option>
                    <?php if($row->j_usaha != "kedai" && $row->j_usaha != "industri_rumahan" && $row->j_usaha != "jasa" && $row->j_usaha != "pendapatan_per_tahun"){ ?>
                        <option value="<?php echo $row->j_usaha; ?>" <?php if($row->j_usaha != "kedai" && $row->j_usaha != "industri_rumahan" && $row->j_usaha != "jasa" && $row->j_usaha != "pendapatan_per_tahun"){ echo 'selected';} ?>><?php echo $row->j_usaha; ?></option>
                    <?php } ?>
                </select>
                </td>
              </tr>
              <tr>
                <td align="left" width="15%">
                  <b>Nama usaha</b>
                </td>
                <td>
                  <input type="text" class="input-wrc" style="width:100%" name="business_name" value="<?php echo $row->n_usaha; ?>">
                </td>
              </tr>
              <tr>
                <td align="left" width="15%" class="bg-grid">
                  <b>Luas Lahan</b>
                </td>
                <td class="bg-grid">
                  <input type="text" class="input-wrc" style="width:100%" name="land_area" value="<?php echo $row->luas_lahan; ?>">
                </td>
              </tr>
              <tr>
                <td align="left" width="15%">
                  <b>Alamat Usaha</b>
                </td>
                <td>
                  <input type="text" class="input-wrc" style="width:100%" name="business_address" value="<?php echo $row->alamat_usaha; ?>">
                </td>
              </tr>
              <tr>
                <td align="left" width="15%" class="bg-grid">
                  <b>Kecamatan Usaha</b>
                </td>
                <td class="bg-grid">
                  <input type="text" class="input-wrc" style="width:100%" name="district_business" value="<?php echo $row->kecamatan_usaha; ?>">
                </td>
              </tr>
              <!-- <tr>
                <td align="left" width="15%" class="bg-grid">
                  <b>Kelurahan Usaha</b>
                </td>
                <td class="bg-grid">
                  <input type="text" class="input-wrc" style="width:100%" name="subdistrict_business" value="<?php echo $row->kelurahan_usaha; ?>">
                </td>
              </tr> -->
              <tr>
                <td align="left" width="15%">
                  <b>Bulan Tahun Berdiri</b>
                </td>
                <td>
                  <input type="text" class="input-wrc" style="width:100%" name="start_date" value="<?php echo $row->bulan_tahun_berdiri; ?>">
                </td>
              </tr>
              <tr>
                <td align="left" width="15%" class="bg-grid">
                  <b>Modal Usaha</b>
                </td>
                <td class="bg-grid">
                  <input type="text" class="input-wrc" style="width:100%" name="business_capital" value="<?php echo $row->modal_usaha; ?>">
                </td>
              </tr>
              <tr>
                <td align="left" width="15%">
                  <b>Jumlah Tenaga Kerja</b>
                </td>
                <td>
                  <input type="text" class="input-wrc" style="width:100%" name="jumlah_tenaga_kerja" value="<?php echo $row->jumlah_tenaga_kerja; ?>">
                </td>
              </tr>
              <tr>
                <td align="left" width="15%" class="bg-grid">
                  <b>Pendapatan Pertahun</b>
                </td>
                <td class="bg-grid">
                  <input type="text" class="input-wrc" style="width:100%" name="annual_income" value="<?php echo $row->pndapatan; ?>">
                </td>
              </tr>

             <!--   <tr>
                <td align="left" width="15%">
                  <b>Pilih Layanan:</b>
                </td>
                <td>
                  
                    <select name="accompanying_officer" class="pilihan"  style="width:100%">
                        <option value="FO" <?php if($row->petugas_pendamping == "FO"){ echo 'selected'; } ?>>Petugas FO</option>
                        <option value="MPP" <?php if($row->petugas_pendamping == "MPP"){ echo 'selected'; } ?>>Petugas MPP</option>
                    </select>
                </td>
              </tr> -->
              
              <tr>
                <td align="left" width="15%">
                  <b>Petugas Pendamping</b>
                </td>
                <td>
                  
                    <select name="accompanying_officer" class="pilihan"  style="width:100%">
                        <option value="FO" <?php if($row->petugas_pendamping == "FO"){ echo 'selected'; } ?>>Petugas FO</option>
                        <option value="MPP" <?php if($row->petugas_pendamping == "MPP"){ echo 'selected'; } ?>>Petugas MPP</option>
                    </select>
                </td>
              </tr>
              <tr>
                <td align="left" width="15%" class="bg-grid">
                  <b>Lokasi</b>
                </td>
                <td class="bg-grid">
                  <input type="text" class="input-wrc" style="width:100%" name="lokasi" value="<?php echo $row->lokasi; ?>">
                </td>
              </tr>
              <tr>
                <td align="left" width="15%">
                  <b>Event</b>
                </td>
                <td>
                  <input type="text" class="input-wrc" style="width:100%" name="event_name" value="<?php echo $row->event; ?>">
                </td>
              </tr>
              <tr>
                <td align="left" width="15%" class="bg-grid">
                  <b>Lokasi Event</b>
                </td>
                <td class="bg-grid">
                  <input type="text" class="input-wrc" style="width:100%" name="event_location" value="<?php echo $row->lokasi_event; ?>">
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
      <button name="button" type="button" class="button-wrc" onclick="parent.location='<?php echo site_url('pengembangan/nib'); ?>'">Batal</button>
    </div>
  </form>
  </div>
  <br style="clear: both;" />
</div>
