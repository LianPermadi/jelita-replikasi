<?php 

  if (!empty($program)) {
    $id = $program->id_prog;
    $programm = $program->sasaran_program;
    $kegiatan = "";
    $tanggal = "";
    $anggaran = $program->anggaran_tot;
    $r_anggaran = "";
    $keterangan = "";

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
    <form method="post" action="<?php echo site_url().'kegiatandpa/'.$step; ?>" enctype="multipart/form-data">
    <div class="entry">
      <div id="tabs">
        <ul>
          <li><a href="#tabs-1">Input Rincian Kegiatan</a></li>
          <li><a href="#tabs-2">Rincian Kegiatan</a></li>
        </ul>
        <div id="tabs-1">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
          <table cellpadding="0" cellspacing="0" border="0" class="display">
            <tbody>
              <tr>
                <td align="left" width="15%" class="bg-grid">
                  <b>Sasaran Program/ Kegiatan/ <br>Sub Kegiatan (TOT)</b>
                </td>
                <td class="bg-grid">
                  <input name="program" style="width:100%" class="input-area-wrc" value="<?php echo $programm; ?>" readonly>
                </td>
              </tr>
              <tr>
                <td align="left" width="15%">
                  <b>Rincian Kegiatan</b>
                </td>
                <td>
                  <textarea name="kegiatan" style="width:100%" class="input-area-wrc" required><?php echo $kegiatan; ?></textarea>
                </td>
              </tr>
              <tr>
                <td align="left" width="15%" class="bg-grid">
                  <b>Tanggal Kegiatan</b>
                </td>
                <td class="bg-grid">
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
                <td align="left" width="15%">
                  <b>Anggaran Program</b><br>*diisi angka
                </td>
                <td>
                  <input type="number" name="anggaran" style="width:20%" class="input-wrc" value="<?php echo $program->anggaran_tot; ?>" readonly>
                   <b>Realisasi Anggaran : </b><input type="number" name="r_anggaran" style="width:20%" class="input-wrc" value="<?php echo $r_anggaran; ?>" required="required">
                </td>
              </tr>
              <tr>
                <td align="left" width="15%" class="bg-grid">
                  <b>Keterangan</b>
                </td>
                <td class="bg-grid">
                  <textarea name="keterangan" style="width:100%" class="input-area-wrc" required><?php echo $keterangan; ?></textarea>
                </td>
              </tr>
            </tbody>
          </table>
          <div class="entry" style="text-align: center;">
          <input type="submit" name="submit" value="Simpan" class="submit-wrc" content="Simpan">
      <span></span>
      <button name="button" type="button" class="button-wrc" onclick="parent.location='<?php echo site_url('kegiatandpa/renaksi'); ?>'">Batal</button>
    </div>
  </form>
        </div>
        <div id="tabs-2">
          <?php 
          $ambil_id_program = $this->m_renaksi->get_program_id($id);
          $ambil_tim = $this->m_renaksi->get_kdtim_prog($id);
          $anggaran = $this->m_renaksi->get_anggaran($ambil_tim);
          // $total_realisasi = $this->m_renaksi->get_total_anggaran_program($ambil_id_program);
          $get_sasaran_program = $this->m_renaksi->get_sasaran_program_id($ambil_id_program);
          // var_dump($total_realisasi); die();
          if (isset($total_realisasii) && is_object($total_realisasii) && property_exists($total_realisasii, 'total_realisasi')) {
            $total_realisasi_value = $total_realisasii->total_realisasi;
            $sisa_anggaran = $anggaran - $total_realisasii->total_realisasi;
          
            
          // ?>
          <table style="font-size: 15px;">
            <tr>
              <td><b>Kegiatan</b></td>
              <td><b>:</b></td>
              <td><b><?php echo $get_sasaran_program;?></b></td>
            </tr>
            <tr>
              <td>Anggaran</td>
              <td>:</td>
              <td><?php echo number_format($anggaran,0,',','.');?></td>
            </tr>
            <tr>
              <td>Realisasi Anggaran</td>
              <td>:</td>
              <td><?php echo number_format($total_realisasi_value, 0, ',', '.');?></td>
            </tr>
            <tr>
              <td>Sisa Anggaran</td>
              <td>:</td>
              <td><?php echo number_format($sisa_anggaran,0,',','.');?></td>
            </tr>
          </table>
        <?php } ?>
        <table cellpadding="0" cellspacing="0" border="0" class="display" id="pendataan">
        <thead>
          <tr>
            <th width="2%">No</th>
            <th width="35%">Rincian Aktivitas</th>
            <th width="13%">Tanggal</th>
            <th width="10%">Realisasi Anggaran</th>
            <th width="30%">Keterangan</th>
            <th width="10%">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $i = 1; 
          foreach ($anggaran_program as $row) {
          ?>
          <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $row->kegiatan;?></td>
            <td><?php echo $row->tanggal; ?></td>
            <td><?php echo number_format($row->realisasi_anggaran,0,',','.');?></td>
            <td><?php echo $row->keterangan; ?></td>
            <td>
              <?php 
                echo '<a href="'.base_url().'kegiatandpa/edit_r_anggaran/'.$row->id.'"><img src="'.base_url().'assets/images/icon/property.png" alt="Edit Data" title="Edit Data" border="0"></a>&nbsp;';
              ?>
              <a href="#" onclick="if (confirm('Yakin Hapus Data?')) parent.location='<?php echo  site_url('kegiatandpa/hapus_r_anggaran/'.$row->id); ?>'"><img src="<?php echo base_url().'assets/images/icon/cross.png'; ?>" alt="Hapus Data" title="Hapus Data" border="0"></a>&nbsp;
            </td>
          </tr>
          <?php $i++; } ?>
        </tbody>
      </table>
            </div>
      </div>
        <label>&nbsp;</label>
        <div class="spacer"></div>
    </div>
  </div>
  <br style="clear: both;" />
</div>
