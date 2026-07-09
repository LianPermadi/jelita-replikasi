<?php 
  if (!empty($pakai)) {
    $id_ruangan = $pakai->id_ruangan;
    $seksi = $pakai->seksi;
    $kegiatan = $pakai->kegiatan;
    $acara = $pakai->acara;
    $snack = $pakai->snack;
    $mamin = $pakai->mamin;
    $tanggal = $pakai->tanggal;
    $waktu_awal = explode(":", $pakai->waktu_awal);
    $waktu_awal1 = $waktu_awal[0]; //Jam
    $waktu_awal2 = $waktu_awal[1]; //Menit
    $waktu_akhir = explode(":", $pakai->waktu_akhir);
    $waktu_akhir1 = $waktu_akhir[0];
    $waktu_akhir2 = $waktu_akhir[1];
    $keterangan = $pakai->keterangan;
    $id = $pakai->id;
  } else {
    $id_ruangan = "";
    $seksi = "";
    $kegiatan = "0";
    $acara = "";
    $snack = "";
    $mamin = "";
    $tanggal = "";
    $waktu_awal1 = "";
    $waktu_awal2 = "";
    $waktu_akhir1 = "";
    $waktu_akhir2 = "";
    $keterangan = "";
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
    <form method="post" action="<?php echo site_url().'pengembangan/'.$step; ?>" enctype="multipart/form-data">
    <div class="entry">
      <div id="tabs">
        <ul>
          <li><a href="#tabs-1">Booking Ruangan</a></li>
        </ul>
        <div id="tabs-1">
        <?php 
          if ($step == "update") { ?>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
          <?php } ?>
          <table cellpadding="0" cellspacing="0" border="0" class="display">
            <tbody>
              <tr>
                <td align="left" width="15%">
                  <b>Nama Ruangan</b>
                </td>
                <td>
                  <select class="pilihan" name="id_ruangan" style="width:100%">
                    <?php foreach ($ruangan as $rowRuangan) { ?>
                      <option value="<?php echo $rowRuangan->id; ?>" <?php echo ($id_ruangan == $rowRuangan->id ? "selected" : ""); ?>><?php echo $rowRuangan->nama_ruangan." - Kapasitas ".$rowRuangan->kapasitas." Orang"; ?></option>
                    <?php } ?>
                  </select>
                </td>
              </tr>
              <tr>
                <td align="left" width="15%" class="bg-grid">
                  <b>Seksi</b>
                </td>
                <td class="bg-grid">
                  <select class="pilihan" name="seksi" style="width:100%">
                      <option value="0" <?php echo ($seksi == "0" ? "selected" : ""); ?>> - </option>
                      <option value="1" <?php echo ($seksi == "1" ? "selected" : ""); ?>>Evaluasi dan Pelaporan</option>
                      <option value="2" <?php echo ($seksi == "2" ? "selected" : ""); ?>>Fasilitasi</option>
                      <option value="3" <?php echo ($seksi == "3" ? "selected" : ""); ?>>Pemantauan dan Pembinaan</option>
                      <option value="4" <?php echo ($seksi == "4" ? "selected" : ""); ?>>Pengawasan</option>
                      <option value="5" <?php echo ($seksi == "5" ? "selected" : ""); ?>>Pengaduan dan Advokasi</option>
                      <option value="6" <?php echo ($seksi == "6" ? "selected" : ""); ?>>Pengembangan Sistem Informasi</option>
                      <option value="7" <?php echo ($seksi == "7" ? "selected" : ""); ?>>Pengembangan dan Kebijakan</option>
                      <option value="8" <?php echo ($seksi == "8" ? "selected" : ""); ?>>Pengolahan data</option>
                      <option value="9" <?php echo ($seksi == "9" ? "selected" : ""); ?>>Promosi dan Kerjasama</option>
                      <option value="10" <?php echo ($seksi == "10" ? "selected" : ""); ?>>Sektor Ekonomi dan Parawisata</option>
                      <option value="11" <?php echo ($seksi == "11" ? "selected" : ""); ?>>Sektor Kehutanan lingkungan hidup energi dan sumber daya mineral</option>
                      <option value="12" <?php echo ($seksi == "12" ? "selected" : ""); ?>>Sektor Pendidikan, Kesehatan dan Sosial</option>
                      <option value="13" <?php echo ($seksi == "13" ? "selected" : ""); ?>>Sektor Perhubungan Komunikasi dan Informatika</option>
                      <option value="14" <?php echo ($seksi == "14" ? "selected" : ""); ?>>Sektor Pertanian, Perikanan dan Tenaga Kerja</option>
                      <option value="15" <?php echo ($seksi == "15" ? "selected" : ""); ?>>Sektor Pertanahan Pekerjaan Umum dan Penataan Ruang</option>
                      <option value="16" <?php echo ($seksi == "16" ? "selected" : ""); ?>>Keuangan dan Aset</option>
                      <option value="17" <?php echo ($seksi == "17" ? "selected" : ""); ?>>Kepegawaian dan Umum</option>
                      <option value="18" <?php echo ($seksi == "18" ? "selected" : ""); ?>>Perencanaan dan Pelaporan</option>
                      <option value="19" <?php echo ($seksi == "19" ? "selected" : ""); ?>>Kepala Dinas PMPTSP</option>
                  </select>
                </td>
              </tr>
              <tr>
                <td align="left" width="15%">
                  <b>Kegiatan</b>
                </td>
                <td>
                  <select class="pilihan" name="kegiatan" style="width:100%">
                      <option value="0" <?php echo ($kegiatan == "0" ? "selected" : ""); ?>>Internal</option>
                      <option value="1" <?php echo ($kegiatan == "1" ? "selected" : ""); ?>>Eksternal</option>
                  </select>
                </td>
              </tr>
              <tr>
                <td align="left" width="15%" class="bg-grid">
                  <b>Acara</b>
                </td>
                <td class="bg-grid">
                  <input type="text" name="acara" style="width:100%" class="input-wrc" value="<?php echo $acara; ?>" required="required">
                </td>
              </tr>
              <tr>
                <td align="left" width="15%">
                  <b>Snack</b>
                </td>
                <td>
                  <input type="text" name="snack" style="width:100%" class="input-wrc" value="<?php echo $snack; ?>" required="required">
                </td>
              </tr>
              <tr>
                <td align="left" width="15%" class="bg-grid">
                  <b>Mamin</b>
                </td>
                <td class="bg-grid">
                  <input type="text" name="mamin" style="width:100%" class="input-wrc" value="<?php echo $mamin; ?>" required="required">
                </td>
              </tr>
              <tr>
                <td align="left" width="15%">
                  <b>Tanggal Pakai</b>
                </td>
                <td>
                  <?php 
                    $tgl_input = array('name' => 'tanggal',
                            'value' => ((!empty($tanggal)) ? $tanggal : date('Y-m-d')),
                            'class' => 'input-wrc',
                            'readOnly'=>TRUE,
                            'style' => "width:100%",
                            'class' => 'monbulan'
                           );
                    echo form_input($tgl_input);
                  ?>
                </td>
              </tr>
              <tr>
                <td align="left" width="15%" class="bg-grid">
                  <b>Waktu Mulai</b>
                </td>
                <td class="bg-grid">
                  <input type="text" name="awal1" style="width:5%; text-align: center;" class="input-wrc" value="<?php echo $waktu_awal1; ?>" maxlength="2" required="required"> : <input type="text" name="awal2" style="width:5%; text-align: center;" class="input-wrc" value="<?php echo $waktu_awal2; ?>" maxlength="2" required="required">
                </td>
              </tr>
              <tr>
                <td align="left" width="15%">
                  <b>Waktu Akhir</b>
                </td>
                <td>
                  <input type="text" name="akhir1" style="width:5%; text-align: center;" class="input-wrc" value="<?php echo $waktu_akhir1; ?>" maxlength="2" required="required"> : <input type="text" name="akhir2" style="width:5%; text-align: center;" class="input-wrc" value="<?php echo $waktu_akhir2; ?>" maxlength="2" required="required">
                </td>
              </tr>
              <tr>
                <td align="left" width="15%" class="bg-grid">
                  <b>Keterangan</b>
                </td>
                <td class="bg-grid">
                  <textarea name="keterangan" style="width:100%" class="input-area-wrc"><?php echo $keterangan; ?></textarea>
                </td>
              </tr>
              <tr>
                        <td align="left" width="15%">
                          <b>Nota Dinas Pengajuan Snack/Mamin (.pdf)</b><br>(Upload jika snack/mamin dari Sub Bagian Umum)
                        </td>
                        <td>
                          <?php 
                        //  var_dump(file_exists('assets/ossrba/bap/BAP_'.$id.'.pdf'));die;
                            if (file_exists('assets/ruangan/notdin/NOTDIN_'.$id.'.pdf')) {
                              echo "<a href='".base_url()."pengembangan/unduh_naskah/".$id."' style='color:blue;' target='_blank' title='Unduh Berkas'>Berkas Siap</a>&nbsp;"; ?>
                              <button name="button" type="button" class="button-wrc" onclick="if (confirm('Yakin Hapus Berkas?')) parent.location='<?php echo base_url(). "pengembangan/hapus_notdin/".$id; ?>'">X</button>
                            <?php 
                            } else { ?>
                              <input type="file" name="file_srt" id="fileToUpload" class="submit-wrc" value="Pilih file" accept=".pdf">
                            <?php } ?>
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
      <button name="button" type="button" class="button-wrc" onclick="parent.location='<?php echo site_url('pengembangan'); ?>'">Batal</button>
    </div>
  </form>
  </div>
  <br style="clear: both;" />
</div>
