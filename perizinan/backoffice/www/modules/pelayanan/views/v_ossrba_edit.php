<?php 
  if (!empty($ossrba)) {
    $id = $ossrba->id;
    $nomorpermohonan = $ossrba->nomorpermohonan;
    $tanggalpermohonan = $ossrba->tanggalpermohonan;
    $nib = $ossrba->nib;
    $tgl_nib = $ossrba->tgl_nib;
    $kbli = $ossrba->kbli;
    $sektor = $ossrba->sektor;
    $jenis_perusahaan = $ossrba->jenis_perusahaan;
    $modal_usaha = $ossrba->modal_usaha;
    $alamat = $ossrba->alamat;
    $jenis_proyek = $ossrba->jenis_proyek;
    $nama_perizinan = $ossrba->nama_perizinan;
    $skala_usaha = $ossrba->skala_usaha;
    $esselon = $ossrba->esselon;
    $created = $ossrba->created;
    $risiko = $ossrba->risiko;
    $nama_perusahaan = $ossrba->nama_perusahaan;
    $turunan_kbli = $ossrba->turunan_kbli;
    $no_dokumen=$ossrba->no_dokumen;
    $tgl_dokumen=$ossrba->tgl_dokumen;
    $npwp=$ossrba->npwp;
    $no_telp=$ossrba->no_telp;
    $alamat_usaha=$ossrba->alamat_usaha;
    $kab_usaha=$ossrba->kab_usaha;
    $fiktif_positif=$ossrba->fiktif_positif;
    $status=$ossrba->status;
    $masaberlakuizin=$ossrba->masaberlakuizin;
    $tipe_aplikasi=$ossrba->tipe_aplikasi;
    $metode_cari=$ossrba->metode_cari;


  } else {
    $id = "";
    $tipe_aplikasi = "";
    $nomorpermohonan = "";
    $tanggalpermohonan = "";
    $nib = "";
    $tgl_nib = "";
    $kbli = "";
    $sektor = "";
    $jenis_perusahaan = "";
    $modal_usaha = "";
    $alamat = "";
    $jenis_proyek = "";
    $nama_perizinan = "";
    $skala_usaha = "";
    $risiko = "";
    $esselon = "";
    $created = "";
    $nama_perusahaan = "";
    $turunan_kbli = "";
    $no_dokumen = "";
    $tgl_dokumen = "";
    $npwp = "";
    $no_telp = "";
    $alamat_usaha = "";
    $kab_usaha = "";
    $fiktif_positif = "";
    $status = "";
    $masaberlakuizin = "";
     $metode_cari = "";


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
            <li><a href="#tabs-1">Input Pemenuhan Komitmen oss-rba</a></li>
           <!--  <li><a href="#tabs-2">Daftar Value</a></li> -->
          </ul>
            <div id="tabs-1">
              <form method="post" action="<?php echo site_url().'pelayanan/komitmen_oss/'.$step; ?>" enctype="multipart/form-data">
                <?php 
                  if ($step == "update") { ?>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                  <?php } ?>
                <table cellpadding="0" cellspacing="0" border="0" class="display">
                  <tbody>

                     <tr  class="bg-grid">
                      <td align="left" width="15%"  class="bg-grid">
                        <b>METODE PENCARIAN</b>
                      </td>
                      <td >                        
                          <select class="pilihan" name="metode_cari" style="width:100%" required>                      
                            <option value="0" <?php echo ($metode_cari == "0" ? "selected" : ""); ?>>DASHBOARD</option>
                            <option value="1" <?php echo ($metode_cari == "1" ? "selected" : ""); ?>>SEARCH</option>      
                            <!-- <option value="2" <?php echo ($metode_cari == "2" ? "selected" : ""); ?>>NKV</option>                  -->
                          </select>
                      </td>
                    </tr>

                     <tr  class="bg-grid">
                      <td align="left" width="15%"  class="bg-grid">
                        <b>FIKTIF POSITIF</b>
                      </td>
                      <td >                        
                          <select class="pilihan" name="fiktif_positif" style="width:100%" required>                      
                            <option value="0" <?php echo ($fiktif_positif == "0" ? "selected" : ""); ?>>TIDAK</option>
                            <option value="1" <?php echo ($fiktif_positif == "1" ? "selected" : ""); ?>>YA</option>                     
                          </select>
                      </td>
                    </tr>

                     <tr>
                      <td align="left" width="15%">
                        <b>Status Permohonan</b>
                      </td>
                      <td >                        
                          <select class="pilihan" name="status" style="width:100%" required>                      
                            <option value="0" <?php echo ($status == "0" ? "selected" : ""); ?>>Disetujui</option>
                            <option value="1" <?php echo ($status == "1" ? "selected" : ""); ?>>Perbaikan</option>                     
                            <option value="2" <?php echo ($status == "2" ? "selected" : ""); ?>>Penolakan</option>                     
                          </select>
                      </td>
                    </tr>

                      <tr  class="bg-grid">
                      <td align="left" width="15%" >
                        <b>Nomor Permohonan *</b>
                      </td>
                      <td>
                        <input type="text" name="nomorpermohonan" style="width:100%" class="input-wrc" value="<?php echo $nomorpermohonan; ?>" required="required">
                      </td>
                    </tr>
                    <tr>

              <tr>
                <td align="left" width="15%">
                  <b>Tanggal Permohonan *</b>
                </td>
                <td>
                  <?php 
                    $tgl_input = array('name' => 'tanggalpermohonan',
                            'value' => ((!empty($tanggalpermohonan)) ? $tanggalpermohonan : date('Y-m-d')),
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
                        <b>NIB *</b>
                      </td>
                      <td class="bg-grid">
                        <input type="text" name="nib" style="width:100%" class="input-wrc" value="<?php echo $nib; ?>" required="required">
                      </td>
                    </tr>

                    <tr>
                <td align="left" width="15%">
                  <b>Tanggal NIB</b>
                </td>
                <td>
                  <?php 
                    $tgl_input = array('name' => 'tgl_nib',
                            'value' => ((!empty($tgl_nib)) ? $tgl_nib : date('Y-m-d')),
                            'class' => 'input-wrc',
                            'readOnly'=>TRUE,
                            'style' => "width:100%",
                            'class' => 'monbulan'
                           );
                    echo form_input($tgl_input);
                  ?>
                </td>
              </tr>

                     <tr  class="bg-grid">
                      <td align="left" width="25%" >
                        <b>Kode KBLI *</b>
                      </td>
                      <td >
                        <input type="text" name="kbli" style="width:100%" class="input-wrc" value="<?php echo $kbli; ?>" required="required">
                      </td>
                    </tr>

                     <tr>
                      <td align="left" width="25%" >
                        <b>Nama KBLI *</b>
                      </td>
                      <td >
                        <input type="text" name="turunan_kbli" style="width:100%" class="input-wrc" value="<?php echo $turunan_kbli; ?>" required="required">
                      </td>
                    </tr>

                       <tr  class="bg-grid">
                      <td align="left" width="15%"  class="bg-grid">
                        <b>Tipe Aplikasi *</b>
                      </td>


                       <td>
                        <select class="pilihan" name="tipeapp" style="width:100%"  required="required">
                          <!-- <option>PILIH JENIS KELAMIN</option>  -->
                          <?php foreach ($tipeapp as $rowlist) { ?>
                          <option value="<?php echo $rowlist->id; ?>" <?php echo ($tipe_aplikasi == $rowlist->id ? "selected" : ""); ?>><?php echo $rowlist->nama_aplikasi; ?></option>
                          <?php } ?>
                        </select>
                      </td>


                         <tr  class="bg-grid">
                      <td align="left" width="15%"  class="bg-grid">
                        <b>Sektor *</b>
                      </td>


                       <td>
                        <select class="pilihan" name="list2" style="width:100%"  required="required">
                          <!-- <option>PILIH JENIS KELAMIN</option>  -->
                          <?php foreach ($list2 as $rowlist) { ?>
                          <option value="<?php echo $rowlist->id; ?>" <?php echo ($sektor == $rowlist->id ? "selected" : ""); ?>><?php echo $rowlist->n_sektor; ?></option>
                          <?php } ?>
                        </select>
                      </td>

                    <!--   <td>
                        <select class="pilihan" name="ess4" style="width:100%">
                          <?php foreach ($ess4 as $rowess4) { ?>
                            <option value="<?php echo $rowess4->id; ?>" <?php echo ($ess4d == $rowess4->id ? "selected" : ""); ?>><?php echo $rowess4->n_pegawai." - ".$rowess4->n_jabatan; ?></option>
                          <?php } ?>
                        </select>
                      </td>
                    </tr>
 -->
                     <tr>
                      <td align="left" width="15%" >
                        <b>Jenis Perusahaan *</b>
                      </td>
                      <td >
                        <!-- <input type="text" name="jeniskelamin" style="width:100%" class="input-wrc" value="<?php echo $jeniskelamin; ?>" required="required"> -->
                  <select class="pilihan" name="jenis_perusahaan" style="width:100%" required>
                      <!-- <option>PILIH JENIS KELAMIN</option> -->
                      <option value="0" <?php echo ($jenis_perusahaan == "0" ? "selected" : ""); ?>>Badan Usaha</option>
                      <option value="1" <?php echo ($jenis_perusahaan == "1" ? "selected" : ""); ?>>Perorangan</option>
                  </select>
                      </td>
                    </tr>

                     <tr  class="bg-grid">
                      <td align="left" width="15%"  class="bg-grid">
                        <b>Nama Perusahaan *</b>
                      </td>
                      <td >
                        <input type="text" name="nama_perusahaan" style="width:100%" class="input-wrc" value="<?php echo $nama_perusahaan; ?>"  required="required">
                      </td>
                    </tr>

                     <tr>
                      <td align="left" width="15%" >
                        <b>Modal Usaha *</b>
                      </td>
                      <td>
                        <input type="text" name="modal_usaha" style="width:100%" class="input-wrc" value="<?php echo $modal_usaha; ?>" required="required">
                      </td>
                    </tr>

                   
                    
                    <tr  class="bg-grid">
                      <td align="left" width="15%"  class="bg-grid">
                        <b>Alamat Perusahaan *</b>
                      </td>
                      <td >
                        <input type="text" name="alamat" style="width:100%" class="input-wrc" value="<?php echo $alamat; ?>" required="required" >
                      </td>
                    </tr>

                    <tr>
                      <td align="left" width="15%" >
                        <b>Jenis Proyek *</b>
                      </td>
                      <td>
                        <input type="text" name="jenis_proyek" style="width:100%" class="input-wrc" value="<?php echo $jenis_proyek; ?>"  required="required">
                      </td>
                    </tr>

                    <tr  class="bg-grid">
                      <td align="left" width="15%"  class="bg-grid">
                        <b>Nama Perizinan *</b>
                      </td>
                      <td >
                        
                    <select class="pilihan" name="nama_perizinan" style="width:100%" required>
                      
                      <option value="0" <?php echo ($nama_perizinan == "0" ? "selected" : ""); ?>>NIB</option>
                      <option value="1" <?php echo ($nama_perizinan == "1" ? "selected" : ""); ?>>Sertifikat Standar</option>
                      <option value="2" <?php echo ($nama_perizinan == "2" ? "selected" : ""); ?>>Izin</option>
                      <option value="3" <?php echo ($nama_perizinan == "3" ? "selected" : ""); ?>>PB-UMKU</option>
                  </select>

                      </td>
                    </tr>

                    <tr>
                      <td align="left" width="15%" >
                        <b>Skala Usaha *</b>
                      </td>
                      <td>
                        <input type="text" name="skala_usaha" style="width:100%" class="input-wrc" value="<?php echo $skala_usaha; ?>" required="required">
                      </td>
                    </tr>
                  
                     <tr class="bg-grid">
                      <td align="left" width="15%" >
                        <b>Risiko *</b>
                      </td>
                      <td >
                        <!-- <input type="text" name="jeniskelamin" style="width:100%" class="input-wrc" value="<?php echo $jeniskelamin; ?>" required="required"> -->
                  <select class="pilihan" name="risiko" style="width:100%" required>
                      <!-- <option>PILIH JENIS KELAMIN</option> -->
                      <option value="0" <?php echo ($risiko == "0" ? "selected" : ""); ?>>Rendah</option>
                      <option value="1" <?php echo ($risiko == "1" ? "selected" : ""); ?>>Menengah Rendah</option>
                      <option value="2" <?php echo ($risiko == "2" ? "selected" : ""); ?>>Menengah Tinggi</option>
                      <option value="3" <?php echo ($risiko == "3" ? "selected" : ""); ?>>Tinggi</option>
                  </select>
                      </td>
                    </tr>


                    <tr>
                      <td align="left" width="15%" >
                        
                      </td>
                      <td>
                       
                      </td>
                    </tr>

                    <tr  class="bg-grid">
                      <td align="left" width="15%" >
                        <b> Tanda * Wajib Di isi <br><br>INPUTAN OPTIONAL : </b>
                      </td>
                      <td>
                       
                      </td>
                    </tr>

                    <tr>
                      <td align="left" width="15%" >
                        <b>Nomor Izin / Sertifikat</b>
                      </td>
                      <td>
                        <input type="text" name="no_dokumen" style="width:100%" class="input-wrc" value="<?php echo $no_dokumen; ?>">
                      </td>
                    </tr>

              <tr  class="bg-grid">
                <td align="left" width="15%">
                  <b>Tanggal Izin / Sertifikat</b>
                </td>
                <td>
                  <?php 
                    $tgl_input = array('name' => 'tgl_dokumen',
                            'value' => ((!empty($tgl_dokumen)) ? $tgl_dokumen : date('Y-m-d')),
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
                      <td align="left" width="15%" >
                        <b>NPWP</b>
                      </td>
                      <td>
                        <input type="text" name="npwp" style="width:100%" class="input-wrc" value="<?php echo $npwp; ?>">
                      </td>
                    </tr>

                     <tr>
                      <td align="left" width="15%" >
                        <b>Masa Berlaku Izin (Bulan)</b>
                      </td>
                      <td>
                        <input type="text" name="masaberlakuizin" style="width:100%" class="input-wrc" value="<?php echo $masaberlakuizin; ?>">
                      </td>
                    </tr>


                     <tr  class="bg-grid">
                      <td align="left" width="15%" >
                        <b>Nomor Handphone Contact Person*</b>
                      </td>
                      <td>
                        <input type="text" name="no_telp" style="width:100%" class="input-wrc" required="required" value="<?php echo $no_telp; ?>">
                      </td>
                    </tr>

                     <tr>
                      <td align="left" width="15%" >
                        <b>Alamat Lokasi Usaha/Izin</b>
                      </td>
                      <td>
                        <input type="text" name="alamat_usaha" style="width:100%" class="input-wrc" required="required" value="<?php echo $alamat_usaha; ?>">
                      </td>
                    </tr>

                     <tr  class="bg-grid">
                      <td align="left" width="15%" >
                        <b>Kab/Kota Lokasi Usaha</b>
                      </td>
                      <td>
                     

                      
                        <select class="pilihan" name="kabupaten2" style="width:100%"  required="required">
                          <!-- <option>PILIH JENIS KELAMIN</option>  -->
                          <?php foreach ($kabupaten2 as $rowlist) { ?>
                          <option value="<?php echo $rowlist->id; ?>" <?php echo ($kab_usaha == $rowlist->id ? "selected" : ""); ?>><?php echo $rowlist->n_kabupaten; ?></option>
                          <?php } ?>
                        </select>
                      </td>             
                    </tr>
                    <tr>
                        <td align="left" width="15%">
                          <b>Upload Naskah Izin / Sertifikat</b>
                        </td>
                        <td>
                          <?php 
                        //  var_dump(file_exists('assets/ossrba/bap/BAP_'.$id.'.pdf'));die;
                            if (file_exists('assets/ossrba/naskah/NASKAH_'.$id.'.pdf')) {
                              echo "<a href='".base_url()."pelayanan/komitmen_oss/unduh_naskah/".$id."' style='color:blue;' target='_blank' title='Unduh Berkas'>Berkas Siap</a>&nbsp;"; ?>
                              <button name="button" type="button" class="button-wrc" onclick="if (confirm('Yakin Hapus Berkas?')) parent.location='<?php echo base_url(). "pelayanan/komitmen_oss/hapus_naskah/".$id; ?>'">X</button>
                            <?php 
                            } else { ?>
                              <input type="file" name="file_srt" id="fileToUpload" class="submit-wrc" value="Pilih file" accept=".pdf">
                            <?php } ?>
                        </td>
                      </tr>



                  </tbody>
                </table>
            </div>

            <!-- <div id="tabs-2">
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
                </tbody>
              </table>
            </div> -->
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
