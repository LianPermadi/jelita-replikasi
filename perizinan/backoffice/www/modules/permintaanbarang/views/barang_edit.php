<?php 
  if (!empty($surat)) {
    $ess4d = $surat->ess4;
    $ess3d = $surat->ess3;
    $sekdisd = $surat->sekdis;
    $ess2d = $surat->ess2;
    $sifat_surat = $surat->sifat_surat;
    $lampiran = $surat->lampiran;
    $hal = $surat->hal;
    $kepada = $surat->kepada;
    $id = $surat->id;
    $stat_tolak = $this->m_persuratan->get_data_tolak($id);
    $logo_bsre = $surat->logo_bsre;
  } else {
    $ess4d = "";
    $ess3d = "";
    $sekdisd = "823";
    // $sekdisd = "";
    $ess2d = "";
    $sifat_surat = "";
    $lampiran = "";
    $hal = "";
    $kepada = "";
    $id = "";
    $stat_tolak = false;
    $logo_bsre = "1";
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
    
    <div class="entry">
        <div id="tabs">
          <ul>
            <li><a href="#tabs-1">Input Surat</a></li>
            <li><a href="#tabs-2">Daftar Value</a></li>
          </ul>
            <div id="tabs-1">
              <form method="post" action="<?php echo site_url().'persuratan/'.$step; ?>" enctype="multipart/form-data">
                <?php 
                  if ($step == "update") { ?>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                  <?php } ?>
                <table cellpadding="0" cellspacing="0" border="0" class="display"> 
                  <tbody>
                    <tr>
                      <td align="left" width="15%">
                        <b>Eselon 4</b>
                      </td>
                      <td>
                        <select class="pilihan" name="ess4" style="width:100%">
                          <?php foreach ($ess4 as $rowess4) { ?>
                            <option value="<?php echo $rowess4->id; ?>" <?php echo ($ess4d == $rowess4->id ? "selected" : ""); ?>><?php echo $rowess4->n_pegawai." - ".$rowess4->n_jabatan; ?></option>
                          <?php } ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td align="left" width="15%" class="bg-grid">
                        <b>Eselon 3</b>
                      </td>
                      <td class="bg-grid">
                        <select class="pilihan" name="ess3" style="width:100%">
                          <option value="0" <?php echo ($ess3d == 0 ? "selected" : ""); ?>> - </option>
                          <?php foreach ($ess3 as $rowess3) { ?>
                            <option value="<?php echo $rowess3->id; ?>"<?php echo ($ess3d == $rowess3->id ? "selected" : ""); ?>><?php echo $rowess3->n_pegawai." - ".$rowess3->n_jabatan; ?></option>
                          <?php } ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td align="left" width="15%">
                        <b>Sekdis</b>
                      </td>
                      <td>
                        <select class="pilihan" name="sekdis" style="width:100%">
                          <option value="0" <?php echo ($sekdis == 0 ? "selected" : ""); ?>> - </option>
                          <?php foreach ($sekdis as $rowsekdis) { ?>
                            <option value="<?php echo $rowsekdis->id; ?>"<?php echo ($rowsekdis->id == $sekdisd  ? "selected" : ""); ?>><?php echo $rowsekdis->n_pegawai." - ".$rowsekdis->n_jabatan; ?></option>
                          <?php } ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td align="left" width="15%" class="bg-grid">
                        <b>Eselon 2</b>
                      </td>
                      <td class="bg-grid">
                        <select class="pilihan" name="ess2" style="width:100%">
                          <option value="0" <?php echo ($ess2d == 0 ? "selected" : ""); ?>> - </option>
                          <?php foreach ($ess2 as $rowess2) { ?>
                            <option value="<?php echo $rowess2->id; ?>"<?php echo ($ess2d == $rowess2->id ? "selected" : ""); ?>><?php echo $rowess2->n_pegawai." - ".$rowess2->n_jabatan; ?></option>
                          <?php } ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td align="left" width="15%">
                        <b>Sifat Surat</b>
                      </td>
                      <td>
                        <input type="text" name="sifat_surat" style="width:100%" class="input-wrc" value="<?php echo $sifat_surat; ?>" required="required">
                      </td>
                    </tr>
                    <tr>
                      <td align="left" width="15%" class="bg-grid">
                        <b>Lampiran</b>
                      </td>
                      <td class="bg-grid">
                        <input type="text" name="lampiran" style="width:100%" class="input-wrc" value="<?php echo $lampiran; ?>" required="required">
                      </td>
                    </tr>
                    <tr>
                      <td align="left" width="15%">
                        <b>Hal</b>
                      </td>
                      <td>
                        <input type="text" name="hal" style="width:100%" class="input-wrc" value="<?php echo $hal; ?>" required="required">
                      </td>
                    </tr>
                    <tr>
                      <td align="left" width="15%" class="bg-grid">
                        <b>Kepada</b>
                      </td>
                      <td class="bg-grid">
                        <input type="text" name="kepada" style="width:100%" class="input-wrc" value="<?php echo $kepada; ?>" required="required">
                      </td>
                    </tr>
                    <tr>
                      <td align="left" width="15%">
                        <b>Pemasangan Logo BSRE</b>
                      </td>
                      <td>
                        <select class="pilihan" name="logo" style="width:100%">
                          <option value="0" <?php echo ($logo_bsre == "0" ? "selected" : ""); ?>>Manual</option>
                          <option value="1" <?php echo ($logo_bsre == "1" ? "selected" : ""); ?>>Otomatis</option>
                        </select>
                      </td>
                    </tr>
                    <?php if (!$stat_tolak) { ?>
                      <tr>
                        <td align="left" width="15%" class="bg-grid">
                          <b>File Surat</b>
                        </td>
                        <td class="bg-grid">
                          <?php 
                            if (file_exists('assets/docx-surat/SRT_'.$id.'.docx')) {
                              echo "<a href='".base_url()."persuratan/unduh_docx/".$id."' style='color:blue;' target='_blank' title='Unduh Berkas'>Berkas Siap</a>&nbsp;"; ?>
                              <button name="button" type="button" class="button-wrc" onclick="if (confirm('Yakin Hapus Berkas Docx?')) parent.location='<?php echo base_url(). "persuratan/hapus_docx/".$id; ?>'">X</button>
                            <?php 
                            } else { ?>
                              <input type="file" name="file_srt" id="fileToUpload" class="submit-wrc" value="Pilih file" accept=".docx" required>
                            <?php } ?>
                        </td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
            </div>

            <div id="tabs-2">
              <table cellpadding="0" cellspacing="0" border="0" class="display">
                <tbody>
                  <tr>
                    <td width="5%">${jabatan}</td>
                    <td width="2%" align="center"> = </td>
                    <td>Jabatan Kepala Dinas</td>
                  </tr>
                  <tr>
                    <td width="5%">${kepala}</td>
                    <td width="2%" align="center"> = </td>
                    <td>Nama Kepala Dinas</td>
                  </tr>
                  <tr>
                    <td width="5%">${pangkat}</td>
                    <td width="2%" align="center"> = </td>
                    <td>Pangkat Kepala Dinas</td>
                  </tr>
                  <tr>
                    <td width="5%">${nip}</td>
                    <td width="2%" align="center"> = </td>
                    <td>NIP Kepala Dinas</td>
                  </tr>
                  <tr>
                    <td width="5%">${no_surat}</td>
                    <td width="2%" align="center"> = </td>
                    <td>Nomor Surat</td>
                  </tr>
                  <tr>
                    <td width="5%">${tgl_surat}</td>
                    <td width="2%" align="center"> = </td>
                    <td>Tanggal Surat</td>
                  </tr>
                  <tr>
                    <td width="5%">${sifat_surat}</td>
                    <td width="2%" align="center"> = </td>
                    <td>Sifat Surat</td>
                  </tr>
                  <tr>
                    <td width="5%">${lampiran}</td>
                    <td width="2%" align="center"> = </td>
                    <td>Lampiran Surat</td>
                  </tr>
                  <tr>
                    <td width="5%">${hal}</td>
                    <td width="2%" align="center"> = </td>
                    <td>Perihal Surat</td>
                  </tr>
                  <tr>
                    <td width="5%">${kepada}</td>
                    <td width="2%" align="center"> = </td>
                    <td>Kepada Surat</td>
                  </tr>
                  <tr>
                    <td width="5%">${bulanromawi}</td>
                    <td width="2%" align="center"> = </td>
                    <td>Angka Bulan Dalam Romawi (I, II, III, dst.)</td>
                  </tr>
                  <tr>
                    <td width="5%">${tahunini}</td>
                    <td width="2%" align="center"> = </td>
                    <td>Tahun ini</td>
                  </tr>
                  <tr>
                    <td width="5%">${tgl_sekarang}</td>
                    <td width="2%" align="center"> = </td>
                    <td>Tanggal Sekarang (<?php echo $this->lib_date->mysql_to_human(date("Y-m-d")); ?>)</td>
                  </tr>
                  <tr>
                    <td width="5%">${qrcode}</td>
                    <td width="2%" align="center"> = </td>
                    <td>Gambar QRCode</td>
                  </tr>
                  <tr>
                    <td width="5%">${ttd}</td>
                    <td width="2%" align="center"> = </td>
                    <td>Gambar TTD Penandatangan</td>
                  </tr>
                  <tr>
                    <td width="5%">${cap}</td>
                    <td width="2%" align="center"> = </td>
                    <td>Gambar Cap Dinas</td>
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
      <button name="button" type="button" class="button-wrc" onclick="parent.location='<?php echo site_url('persuratan'); ?>'">Batal</button>
    </div>
  </form>
  </div>
  <br style="clear: both;" />
</div>
