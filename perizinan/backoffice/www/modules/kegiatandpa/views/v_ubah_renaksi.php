<?php 
// var_dump($renaksi->pic);die();
  if (!empty($renaksi)) {
    $id = $renaksi->id;
    $program_id = $renaksi->program_id;
    $rencana_aksi = $renaksi->sasaran_renaksi;
    $picbanyak = $renaksi->pic;
    $pic       = explode('^', $picbanyak);
    $r_anggaran = $renaksi->r_anggaran;
    $target_aktivitas = $renaksi->target_aktivitas;
    $satuan = $renaksi->satuan;
    $tgl_rencana = $renaksi->tgl_rencana;
    $tgl_realisasi = $renaksi->tgl_realisasi;
    $keterangan = $renaksi->keterangan;
    // $id_tim = $program->kd_tim;
    // $aktivitas = $program->sasaran_program;
    // $anggaran = $program->anggaran_tot;
  }
          $sasaran_renaksi = $this->m_renaksi->get_renaksi_ubah($id);
          $ambil_tim = $this->m_renaksi->get_kdtim_prog($program_id);
          $ketua_tim = $this->m_renaksi->get_id_ketua($ambil_tim);
          $ketua = $this->m_renaksi->get_ketua($ketua_tim);
          $program = $this->m_renaksi->get_dataprogram_id($program_id);
          $anggaran = $this->m_renaksi->get_anggaran($ambil_tim);
          $anggaran_float = (float)$anggaran;
          // var_dump($anggaran); die();
          // $sasaran_renaksi = $sasaran_renaksi[0]->sub_renaksi;
          // $aktivitas = $this->m_renaksi->get_dataprogram_id($id);
          $aktivitas = $this->m_renaksi->get_sasaran_program_id($program_id);
           $anggota = $this->m_renaksi->get_anggota_tim2($ambil_tim);
           // var_dump($anggota);die();
           // var_dump($anggota[0]->id_pegawai);die();
 ?>


 <style>
        #myInput {
            display: none;
        }
    </style>

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
          <li><a href="#tabs-1">Input Rincian Aktivitas</a></li>
        </ul>
        <div id="tabs-1">
        <?php 
          if ($step == "subrenaksi_update") { ?>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="hidden" name="program_id" value="<?php echo $program_id; ?>">
          <?php } else { ?>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
          <?php } ?>
          <table cellpadding="0" cellspacing="0" border="0" class="display">
            <tbody>
              <tr>
                <td align="left" width="15%">
                  <b>Tim</b>
                </td>
                <td>
                  <select class="pilihan" name="id_tim" style="width:100%" disabled>
                    <?php foreach ($tim as $row) {
                    $ambil_ketua = $this->m_renaksi->get_ketua($row->ketua); ?>
                      <option value="<?php echo $row->id; ?>" <?php echo ($ambil_tim == $row->id ? "selected" : ""); ?>><?php echo $row->nama_tim." (Ketua Tim : ".$this->m_renaksi->get_ketua($row->ketua)." )"; ?></option>
                    <?php } ?>
                  </select>
                </td>
              </tr>
              <tr>
                <td align="left" width="15%" class="bg-grid">
                  <b>Kegiatan</b>
                </td>
                <td class="bg-grid">
                  <textarea name="aktivitas" style="width:100%" class="input-area-wrc" required readonly><?php echo $aktivitas; ?></textarea>
                </td>
              </tr>
              <tr>
                <td align="left" width="15%">
                  <b>Rencana Aksi</b>
                </td>
                <td>
                  <textarea name="renaksi" style="width:100%" class="input-area-wrc" required><?php echo $rencana_aksi; ?></textarea>
                </td>
              </tr>
              <tr>
                <td align="left" width="15%"  class="bg-grid">
                  <b>Pelaksana Tugas</b>
                </td>
                <td  class="bg-grid">
                  <!-- <select class="pilihan" name="pic" style="width:100%">
                      <?php foreach ($anggota as $row) { 
                        // var_dump($ambil_tim == $row->kd_tim);die();
                        ?>
                      <option value="<?php echo $row->id_pegawai; ?>" <?php echo ($pic == $row->id_pegawai) ? "selected" : ""; ?>><?php echo $this->m_renaksi->get_anggota_tim($row->id_pegawai); ?></option>
                    <?php } ?>
                  </select> -->

                  <select class="pilihan" id="u_anggota" name="u_anggota[]" multiple="multiple" style="width: 100%;">
                      <!-- <?php foreach ($anggota as $row) { 
                        ?>
                      <option value="<?php echo $row->id_pegawai; ?>" <?php echo ($pic == $row->id_pegawai) ? "selected" : ""; ?>><?php echo $this->m_renaksi->get_anggota_tim($row->id_pegawai); ?></option>
                    <?php } ?> -->
                    <?php foreach ($anggota as $data) { 
                                      $ass = '';
                                      foreach ($pic as $anggotas) {
                                        if ($anggotas== $data->id_pegawai) {
                                          $ass = 'selected';
                                        }
                                      }
                                            ?>
                                          <option style="width:100" value="<?php echo $data->id_pegawai; ?>" <?php echo $ass; ?>>
                                              <?php echo  $this->m_renaksi->get_anggota_tim ($data->id_pegawai);?></option> 
                                            
                                    <?php 
                                  $ass = '';
                                  } ?>
                  </select>
                </td>
              </tr>
              <tr>
                <td align="left" width="15%">
                  <b>Anggaran</b><br>*diisi angka
                </td>
                <td>
                  <input type="text" name="anggaran" style="width:20%" class="input-wrc" value="<?php echo number_format($anggaran_float,0,',','.');?>" required="required" readonly>
                   <b>Realisasi Anggaran : </b><input type="number" name="r_anggaran" style="width:20%" class="input-wrc" value="<?php echo $r_anggaran; ?>" >
                </td>
              </tr>
              <tr>
                <td align="left" width="15%">
                  <b>Target Aktivitas</b><br>*diisi angka
                </td>
                <td>
                  <input type="number" name="target_aktivitas" style="width:20%" class="input-wrc" value="<?php echo $target_aktivitas; ?>" required="required">
                   <b>Satuan : </b><input type="text" name="satuan" style="width:20%" class="input-wrc" value="<?php echo $satuan; ?>" required="required">
                </td>
              </tr>
              <tr>
                <td align="left" width="15%">
                  <b>Tanggal Rencana</b>
                </td>
                <td>
                  <?php 
                    $tgl_input = array('name' => 'tgl_rencana',
                            'value' => ((!empty($tgl_rencana)) ? $tgl_rencana : date('Y-m-d')),
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
                <td align="left" width="15%">
                  <b>Tanggal Realisasi</b>
                </td>
                <td>
                  <label>
                    <input type="checkbox" id="toggleField"> Sudah Realisasi
                </label>

                <?php
                $tgl_input = array(
                    'name' => 'tgl_realisasi',
                    'id' => 'myInput',
                    'value' => $tgl_realisasi,
                    'class' => 'input-wrc',
                    'style' => "width:80%",
                    'class' => 'monbulan',
                    'readonly' => TRUE
                );
                echo form_input($tgl_input);
                ?>
                </td>
              </tr>
  
              <tr>
                <td align="left" width="15%"  class="bg-grid">
                  <b>Keterangan</b>
                </td>
                <td  class="bg-grid"> 
                  <textarea name="keterangan" style="width:100%" class="input-area-wrc"><?php echo $keterangan; ?></textarea>
                </td>
              </tr>
            </tbody>
          </table>
          <div class="entry" style="text-align: center;">
      <?php 
        if ($step == "subrenaksi_simpan") { ?>
          <input type="submit" name="submit" value="Simpan" class="submit-wrc" content="Simpan">
        <?php } else { ?>
          <input type="submit" name="submit" value="Ubah" class="submit-wrc" content="Ubah">
        <?php } ?>
      
      <span></span>
      <button name="button" type="button" class="button-wrc" onclick="parent.location='<?php echo site_url('kegiatandpa/buat_renaksi/'.$program_id); ?>'">Batal</button>
    </div>
  </form>
        </div>
      </div>
        <label>&nbsp;</label>
        <div class="spacer"></div>
    </div>
  </div>
  <br style="clear: both;" />
</div>
