<?php 
  if (!empty($pakai)) {

    $notulen = $pakai->notulen;
    $id = $pakai->id;
  } else {
    $notulen = "";
    $id = "";
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
    <form method="post" action="<?php echo site_url().'ruangan/'.$step; ?>" enctype="multipart/form-data">
    <div class="entry">
      <div id="tabs">
        <ul>
          <li><a href="#tabs-1">Booking Ruangan</a></li>
        </ul>
        <div id="tabs-1">
        <?php 
          if ($step == "updateNotulen") { ?>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
          <?php } ?>
          <table cellpadding="0" cellspacing="0" border="0" class="display">
            <tbody>
            
              <tr>
                <td align="left" width="15%" class="bg-grid">
                  <b>Rangkuman Notulensi/Laporan Kegiatan</b>
                </td>
                <td class="bg-grid">
                  <?php
                  
                    $pegawai = $this->m_ruangan->get_id_user_pic($id);
                    $iduser = $this->session->userdata('id_auth');
                    $all_data = $this->m_ruangan->get_data_id($id);
                    $id_peg = $this->m_ruangan->get_id_pegawai($iduser);
                    $id_pic = $this->m_ruangan->get_id_user_pic($id_peg, $id);
                    if($this->All){
                    } ?>
                  <textarea name="notulen" style="width:98%;background-color:white;border: 1px;" class="input-wrc" id="" cols="30" rows="10"><?php 
                    if(!empty($id_pic)){
                      if($id_pic[0]->ket != NULL){
                        echo $id_pic[0]->ket;
                      }
                    }else{
                      echo $notulen;
                    } ?></textarea>

                </td>
              </tr>
                        <td align="left" width="15%">
                          <b>Notulensi Rapat/ Laporan Kegiatan (.pdf)</b><br>
                        </td>
                        <td>
                          <?php 
                              $user_aktif = FALSE;
                            $id_pegawai = $this->m_ruangan->get_id_pegawai($all_data[0]->user_id);
                              $na_pegawai = $this->m_ruangan->get_n_pegawai($id_pegawai);
                          foreach ($pegawai as $dd) {
                        // var_dump($id_peg == $dd->id_pegawai);
                        // echo $id_peg. ' == ' .$dd->id_pegawai.'<br>';
                            if($id_peg == $dd->id_pegawai){
                              $user_aktif = TRUE;
                            }
                          }
                          if(!empty($pegawai)){

                            if($user_aktif || $this->All){
                              if (file_exists('assets/ruangan/notulen/NOTULEN_'.$id.'_'.$id_peg.'.pdf')) {
                                echo "<a href='".base_url()."ruangan/unduh_notulen/".$id."/".$id_peg."' style='color:blue;' target='_blank' title='Unduh Berkas'>Berkas Siap</a>&nbsp;"; ?>
                                <button name="button" type="button" class="button-wrc" onclick="if (confirm('Yakin Hapus Berkas?')) parent.location='<?php echo base_url(). "ruangan/hapus_notulen/".$id; ?>'">X</button>
                              <?php 
                              } else { ?>
                                <input type="file" name="file_srt" id="fileToUpload" class="submit-wrc" value="Pilih file" accept=".pdf">
                              <?php } 
                            }elseif($this->All){
                              if (file_exists('assets/ruangan/notulen/NOTULEN_'.$id.'_'.$id_peg.'.pdf')) {
                                echo "<a href='".base_url()."ruangan/unduh_notulen/".$id."/".$id_peg."' style='color:blue;' target='_blank' title='Unduh Berkas'>Berkas Siap</a>&nbsp;"; ?>
                                <button name="button" type="button" class="button-wrc" onclick="if (confirm('Yakin Hapus Berkas?')) parent.location='<?php echo base_url(). "ruangan/hapus_notulen/".$id; ?>'">X</button>
                              <?php 
                              } else { ?>
                                <input type="file" name="file_srt" id="fileToUpload" class="submit-wrc" value="Pilih file" accept=".pdf">
                              <?php } 


                                foreach ($pegawai as $ddd) {
                                  $n_pegawai = $this->m_ruangan->get_n_pegawai($ddd->id_pegawai);
                                    echo $n_pegawai.' : ';
                                  if (file_exists('assets/ruangan/notulen/NOTULEN_'.$id.'_'.$ddd->id_pegawai.'.pdf')) {
                                    echo "<a href='".base_url()."ruangan/unduh_notulen/".$id."/".$ddd->id_pegawai."' style='color:blue;' target='_blank' title='Unduh Berkas'>Berkas Siap</a>&nbsp;";
                                  }else{
                                    echo 'Belum Upload';
                                  }
                                  echo '<br>';
                                }
                            }else{
                                foreach ($pegawai as $ddd) {
                                  $n_pegawai = $this->m_ruangan->get_n_pegawai($ddd->id_pegawai);
                                    echo $n_pegawai.' : ';
                                  if (file_exists('assets/ruangan/notulen/NOTULEN_'.$id.'_'.$ddd->id_pegawai.'.pdf')) {
                                    echo "<a href='".base_url()."ruangan/unduh_notulen/".$id."/".$ddd->id_pegawai."' style='color:blue;' target='_blank' title='Unduh Berkas'>Berkas Siap</a>&nbsp;";
                                  }else{
                                    echo 'Belum Upload';
                                  }
                                  echo '<br>';
                                }

                            }
                          }else{
                            if (file_exists('assets/ruangan/notulen/NOTULEN_'.$id.'.pdf')) {
                                echo "<a href='".base_url()."ruangan/unduh_notulen/".$id."' style='color:blue;' target='_blank' title='Unduh Berkas'>Berkas Siap</a>&nbsp;"; 
                            } else {
                                ?>
                               <?php ?>
                                <input type="file" name="file_srt" id="fileToUpload" class="submit-wrc" value="Pilih file" accept=".pdf">
                              <?php } 
                          } ?>
                        </td>
                </tr>
              </tr>
                        <td align="left" width="15%" class="bg-grid">
                          <b>Surat undangan</b><br>
                        </td>
                        <td class="bg-grid">
                          <?php 
                            if (file_exists('assets/ruangan/undangan/undangan_'.$id.'.pdf')) {
                              echo "<a href='".base_url()."ruangan/unduh_undangan/".$id."' style='color:blue;' target='_blank' title='Unduh Berkas'>Berkas Siap</a>&nbsp;"; ?>
                              <button name="button" type="button" class="button-wrc" onclick="if (confirm('Yakin Hapus Berkas?')) parent.location='<?php echo base_url(). "ruangan/hapus_undangan/".$id; ?>'">X</button>
                            <?php 
                            } else { ?>
                              <input type="file" name="file_srt_udg" id="fileToUpload" class="submit-wrc" value="Pilih file" accept=".pdf">
                            <?php } ?>
                        </td>
                </tr>
              </tr>
                        <td align="left" width="15%">
                          <b>dasar surat</b><br>
                        </td>
                        <td>
                          <?php 
                            if (file_exists('assets/ruangan/dasarsurat/dasar_surat_'.$id.'.pdf')) {
                              echo "<a href='".base_url()."ruangan/unduh_dasar_surat/".$id."' style='color:blue;' target='_blank' title='Unduh Berkas'>Berkas Siap</a>&nbsp;"; ?>
                              <button name="button" type="button" class="button-wrc" onclick="if (confirm('Yakin Hapus Berkas?')) parent.location='<?php echo base_url(). "ruangan/hapus_dasar_surat/".$id; ?>'">X</button>
                            <?php 
                            } else { ?>
                              <input type="file" name="file_dasar_surat" id="fileToUpload" class="submit-wrc" value="Pilih file" accept=".pdf">
                            <?php } ?>
                        </td>
                </tr>
              </tr>
                        <td align="left" width="15%" class="bg-grid">
                          <b>Kerangan</b><br>
                        </td>
                        <td class="bg-grid">
                          <?php 
                            // var_dump($all_data[0]->user_id);die();
                              echo '<b><br> Pembuat Ruangan ' . $na_pegawai .'<br></b>';
                            foreach ($pegawai as $row) {
                              $n_pegawai = $this->m_ruangan->get_n_pegawai($row->id_pegawai);
                              echo '<br>' . $n_pegawai . ' : ' . $row->ket . '<br>';
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
        if ($step == "simpan") { ?>
          <input type="submit" name="submit" value="Simpan" class="submit-wrc" content="Simpan">
        <?php } else { ?>
          <input type="submit" name="submit" value="Ubah" class="submit-wrc" content="Ubah">
        <?php } ?>
      
      <span></span>
      <button name="button" type="button" class="button-wrc" onclick="parent.location='<?php echo site_url('ruangan'); ?>'">Batal</button>
    </div>
  </form>
  </div>
  <br style="clear: both;" />
</div>
