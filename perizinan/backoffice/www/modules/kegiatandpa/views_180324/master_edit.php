<?php
// var_dump($tim);die();
  if (!empty($tim)) {
    $nama_tim = $tim->nama_tim;
    $pengampu = $tim->pengampu;
    $ketua = $tim->ketua;
    // $id = $tim->id;
    // $anggota = $tim->id_pegawai;
    $anggaran = $tim->anggaran;
    $realisasi_anggaran = $tim->realisasi_anggaran;
    $kd_tim = $tim->kd_tim;
  } else {
    $nama_tim = "";
    $pengampu = "";
    $ketua = "";
    $id = "";
    $anggota = "";
    $anggaran = "";
    $realisasi_anggaran = "";
    $kd_tim = "";
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
                      <option value="0" <?php echo ($pengampu == "0" ? "selected" : ""); ?>> - </option>
                      <option value="1" <?php echo ($pengampu == "1" ? "selected" : ""); ?>>DENI RUSYANA, A.Md.LLAJ., S.A.P., M.S.E</option>
                      <option value="2" <?php echo ($pengampu == "2" ? "selected" : ""); ?>>Dr. H. DODIN RUSMIN NURYADIN, Drs., M.Si.</option>
                      <option value="3" <?php echo ($pengampu == "3" ? "selected" : ""); ?>>Drs. H. DIDING ABIDIN, M.Si.</option>
                      <option value="4" <?php echo ($pengampu == "4" ? "selected" : ""); ?>>DINDIN JAMALUDIN, S.H., M.H.</option>
                      <option value="5" <?php echo ($pengampu == "5" ? "selected" : ""); ?>>HENY RAHMAWATI, A.K.S., M.P.</option>
                      <option value="6" <?php echo ($pengampu == "6" ? "selected" : ""); ?>>PIQHI RIZQI, S.T., M.T.</option>
                      <option value="7" <?php echo ($pengampu == "7" ? "selected" : ""); ?>>PAMUDI BUDI SUHARSONO, S.Si.</option>
                      <option value="8" <?php echo ($pengampu == "8" ? "selected" : ""); ?>>ANNY MIRNA APRIANY, S.T.</option>
                      <option value="9" <?php echo ($pengampu == "9" ? "selected" : ""); ?>>KARINA RACHMADIANI HENDRAWAN, S.E.</option>
                      <option value="10" <?php echo ($pengampu == "10" ? "selected" : ""); ?>>ARINAL LEGIA SUHERMAN, S.A.B.</option>
                  </select>
                </td>
              </tr>
              <tr>
                <td align="left" width="15%">
                  <b>Nama Ketua</b>
                </td>
                <td>
                  <select class="pilihan" name="ketua" style="width:100%">
                      <option value="0" <?php echo ($ketua == "0" ? "selected" : ""); ?>> - </option>
                      <option value="1" <?php echo ($ketua == "1" ? "selected" : ""); ?>>AEP SAEPULOH, S.T</option>
                      <option value="2" <?php echo ($ketua == "2" ? "selected" : ""); ?>>AHMAD FAUZAN NURUL ILMI, S.E.</option>
                      <option value="3" <?php echo ($ketua == "3" ? "selected" : ""); ?>>ARINAL LEGIA SUHERMAN, S.A.B.</option>
                      <option value="4" <?php echo ($ketua == "4" ? "selected" : ""); ?>>BOYKE TRISTIADI, S.E., M.M.</option>
                      <option value="5" <?php echo ($ketua == "5" ? "selected" : ""); ?>>DESKA YUDA AMELLIA, S.E.</option>
                      <option value="6" <?php echo ($ketua == "6" ? "selected" : ""); ?>>DIAN PRAMANITA, S.H.</option>
                      <option value="7" <?php echo ($ketua == "7" ? "selected" : ""); ?>>Dra. TETI RACHMAWATI, M.A.B</option>
                      <option value="8" <?php echo ($ketua == "8" ? "selected" : ""); ?>>FARIDHA DWI ASTUTI, S.I.P.</option>
                      <option value="9" <?php echo ($ketua == "9" ? "selected" : ""); ?>>FIKRI AZMI ARIF S, S.I.Kom.</option>
                      <option value="10" <?php echo ($ketua == "10" ? "selected" : ""); ?>>GEMA ADES SUBEKTI, ST.,M.K.P</option>
                      <option value="11" <?php echo ($ketua == "11" ? "selected" : ""); ?>>GITA WIRANTIKA, S.E.,M.M.</option>
                      <option value="12" <?php echo ($ketua == "12" ? "selected" : ""); ?>>GUGUN GUNAWAN, S.T.</option>
                      <option value="13" <?php echo ($ketua == "13" ? "selected" : ""); ?>>IRWANSYAH, S.I.P.</option>
                      <option value="14" <?php echo ($ketua == "14" ? "selected" : ""); ?>>IYAN DARMANSYAH BIMANTARA, SH</option>
                      <option value="15" <?php echo ($ketua == "15" ? "selected" : ""); ?>>JONAS MEYLAN FREDDY BANUREA, S.ST</option>
                      <option value="16" <?php echo ($ketua == "16" ? "selected" : ""); ?>>MUSTIKA LADIA PUTRI, S.Si.</option>
                      <option value="17" <?php echo ($ketua == "17" ? "selected" : ""); ?>>RADEN MUHAMMAD DARAJAT, SE. MPP., M.S.E</option>
                      <option value="18" <?php echo ($ketua == "18" ? "selected" : ""); ?>>SAHAL FAUZI, S.KOM., M.KOM.</option>
                      <option value="19" <?php echo ($ketua == "19" ? "selected" : ""); ?>>SUBAGYO, S.Sos., M.M.</option>
                      <option value="20" <?php echo ($ketua == "20" ? "selected" : ""); ?>>THONGKU HAMONANGAN SIREGAR, S.E., M.M.</option>
                      <option value="21" <?php echo ($ketua == "21" ? "selected" : ""); ?>>WAWAN RUSTIYAN, S.Si., M.Si.</option>
                      <option value="22" <?php echo ($ketua == "22" ? "selected" : ""); ?>>WIWIN WIDIANTINI, S.Pd.</option>
                      <option value="23" <?php echo ($ketua == "23" ? "selected" : ""); ?>>YUNAN FELDY LESNUSA, ST, M.M</option>
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
                  <input type="text" name="anggaran" style="width:100%" class="input-wrc" value="<?php echo $anggaran; ?>" required="required">
                </td>
              </tr>
              <tr>
                <td align="left" width="15%">
                  <b>Realisasi Anggaran</b><br>
                  *diisi tanpa titik/koma
                </td>
                <td>
                  <input type="text" name="realisasi_anggaran" style="width:100%" class="input-wrc" value="<?php echo $realisasi_anggaran; ?>" >
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
