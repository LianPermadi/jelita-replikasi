<?php
// var_dump($tim);die();
  if (!empty($tim)) {
    $nama_tim = $tim->nama_tim;
    $pengampu = $tim->pengampu;
    $ketua = $tim->ketua;
    // $id = $tim->id;
    $anggota = $tim->id_pegawai;
    $anggaran = $tim->anggaran;
    $realisasi_anggaran = $tim->realisasi_anggaran;
    $kd_tim = $tim->kd_tim;
    $kode_ring = $tim->kode_ring;
    $tahun = $tim->thn_anggaran;
  } else {
    $nama_tim = "";
    $pengampu = "";
    $ketua = "";
    $id = "";
    $anggota = "";
    $anggaran = "";
    $realisasi_anggaran = "";
    $kd_tim = "";
    $kode_ring = "";
    $tahun = "";
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
          <li><a href="#tabs-1">Input Master tim</a></li>
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
                  <b>Nama tim</b>
                </td>
                <td>
                  <input type="text" name="nama_tim" style="width:100%" class="input-wrc" value="<?php echo $nama_tim; ?>" required="required">
                </td>
              </tr>
              <tr>
                <td align="left" width="15%" class="bg-grid">
                  <b>Nama Pengampu</b>
                </td>
                <td class="bg-grid">
                  <select class="pilihan" name="pengampu" style="width:100%">
                      <?php foreach ($koor as $koor): ?>
                        <option value="<?php echo $koor->id_pegawai; ?>" <?php echo ($pengampu == $koor->id_pegawai ? "selected" : ""); ?>><?php echo $this->m_renaksi->get_n_pegawai($koor->id_pegawai); ?></option>
                      <?php endforeach ?>
                  </select>
                </td>
              </tr>
              <tr>
                <td align="left" width="15%">
                  <b>Nama Ketua</b>
                </td>
                <td>
                  <select class="pilihan" name="ketua" style="width:100%">
                      <?php foreach ($katim as $katim): ?>
                        <option value="<?php echo $katim->id_pegawai; ?>" <?php echo ($ketua == $katim->id_pegawai ? "selected" : ""); ?>><?php echo $this->m_renaksi->get_n_pegawai($katim->id_pegawai); ?></option>
                      <?php endforeach ?>
                  </select>
                </td>
              </tr>
              <tr>
                <td class="bg-grid">
                  <?php if ($step == "master_simpan") { ?>
                        <tr>
                            <td valign='top' class="bg-grid"><label class="label-wrc">Nama Anggota</label></td>
                            <td class="bg-grid">        
                                <select id="anggota" name="anggota[]" multiple="multiple" style="width: 75%;">
                                    <?php
                                        if($step === "master_simpan") { 
                                          foreach ($list as $data) {
                                                echo "<option style='width:100%' value='".$data->id."'>".$data->n_pegawai." | ".$data->nip." |".
                                                     $data->pangkat_gol." | ".$data->n_jabatan." </option>";
                                            }
                                        } else {
                                            
                                        }
                                    ?>
                                </select>
                                <span id="erorPeriksa" style=" clear: both; visibility: hidden;"></span>
                            </td>
                        </tr>
                              <?php } ?>

                    <?php 
                    // var_dump($anggota[0]->id_pegawai); die();
                     if ($step == "master_update") { ?>
                            <tr>
                        <td valign='top' class="bg-grid"><label class="label-wrc">Nama Anggota</label></td>
                      <td class="bg-grid">
                        <select class="pilihan" id="u_anggota" name="u_anggota[]" multiple="multiple" style="width: 75%;">
                                    <?php foreach ($pegawai as $data) { 
                                      $ass = '';
                                      foreach ($anggota as $anggotas) {
                                        if ($anggotas->id_pegawai== $data->id) {
                                          $ass = 'selected';
                                        }
                                      }
                                            ?>
                                          <option style="width:100" value="<?php echo $data->id; ?>" <?php echo $ass; ?>>
                                              <?php echo $data->n_pegawai." | ".$data->nip;?></option> 
                                            
                                    <?php 
                                  $ass = '';
                                  } ?>
                        </select>
                      </td>
                    </tr>
                     <?php } ?>
                </td>
              </tr>
              <tr>
                <td align="left" width="15%">
                  <b>Anggaran</b><br>
                  *diisi tanpa titik/koma
                </td>
                <td>
                  <input type="number" name="anggaran" style="width:100%" class="input-wrc" value="<?php echo $anggaran; ?>" required="required">
                </td>
              </tr>
              <tr>
                <td align="left" width="15%" class="bg-grid">
                  <b>Realisasi Anggaran</b><br>
                  *diisi tanpa titik/koma
                </td>
                <td class="bg-grid">
                  <input type="number" name="realisasi_anggaran" style="width:100%" class="input-wrc" value="<?php echo $realisasi_anggaran; ?>" >
                </td>
              </tr>
              <tr>
                <td align="left" width="15%">
                  <b>Kode Rekening</b><br>
                </td>
                <td>
                  <select class="pilihan" name="kode_ring" style="width:100%">
                      <?php foreach ($kodering as $kodering): ?>
                        <option value="<?php echo $kodering->id; ?>" <?php echo ($kode_ring == $kodering->id ? "selected" : ""); ?>><?php echo $kodering->kode_ring.' '.$kodering->uraian_kegiatan; ?></option>
                      <?php endforeach ?>
                  </select>
                </td>
              </tr>
              <tr>
                <td align="left" width="15%" class="bg-grid">
                  <b>Tahun Anggaran</b><br>
                </td>
                <td class="bg-grid">
                  <input type="text" name="tahun" style="width:100%" class="input-wrc" value="<?php echo $tahun; ?>" >
                </td>
              </tr>
              <tr>
                <td align="left" width="15%">
                  <b>SP/SK Tim</b><br>
                  <span style="font-size: 10px; font-style: italic; color: red;">
                    * SP/SK Tim dalam bentuk .pdf
                  </span>
                </td>
                <td>
                  <?php 
                  //  var_dump(file_exists('assets/ossrba/bap/BAP_'.$id.'.pdf'));die;
                  if(file_exists('assets/tot/sk/SK_Tim_'.$nama_tim.'_'.$id.'.pdf')) {
                    echo "<a href='".base_url()."kegiatandpa/unduh_sk/".$id."' style='color:blue;' target='_blank' title='Unduh Berkas'>Berkas Siap</a>&nbsp;"; ?>
                    <button name="button" type="button" class="button-wrc" onclick="if (confirm('Yakin Hapus Berkas?')) parent.location='<?php echo base_url(). "kegiatandpa/hapus_sk/".$id; ?>'">X</button>
                    <?php 
                  }else{
                    ?>
                    <input type="file" name="file_srt" id="fileToUpload" class="submit-wrc" value="Pilih file" accept=".pdf">
                    <?php
                  }
                  ?>
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
        if ($step == "master_simpan") { ?>
          <input type="submit" name="submit" value="Simpan" class="submit-wrc" content="Simpan">
        <?php } else { ?>
          <input type="submit" name="submit" value="Ubah" class="submit-wrc" content="Ubah">
        <?php } ?>
      
      <span></span>
      <button name="button" type="button" class="button-wrc" onclick="parent.location='<?php echo site_url('kegiatandpa/tot'); ?>'">Batal</button>
    </div>
  </form>
  </div>
  <br style="clear: both;" />
</div>
