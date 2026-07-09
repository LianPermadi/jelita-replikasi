<?php 
  if (!empty($bukutamu)) {
   $nama       = $bukutamu->nama;
   $email       = $bukutamu->email;
   $instansi       = $bukutamu->instansi;
   $keperluan       = $bukutamu->keperluan;
   $waktu       = $bukutamu->waktu;
   $esselon       = $bukutamu->esselon;
   $lokasi       = $bukutamu->lokasi;
   $sektor  = $bukutamu->bidang;
   $solusi = $bukutamu->solusi;
   $telepon = $bukutamu->telepon;
   $id = $bukutamu->id;
   $nib = $bukutamu->nib;
   $jenis_izin = $bukutamu->jenis_izin;
   $nama_petugas = $bukutamu->nama_petugas;
   $Keterangan = $bukutamu->Keterangan;
   $tujuan = $bukutamu->tujuan;

   
   // var_dump($bukutamu);die();
   
  } else {
     $nama       = "";
     $email       = "";
     $instansi       = "";
     $keperluan       = "";
     $waktu       = "";
     $esselon       = "";
     $lokasi       = "";
     $sektor  = "";
     $solusi = "";
     $telepon = "";
     $id = "";
     $nib = "";
     $jenis_izin = "";
     $nama_petugas = "";
     $Keterangan = "";
        $tujuan = "";


   
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
            <li><a href="#tabs-1">Edit BukuTamu</a></li>
         <!--    <li><a href="#tabs-2">Daftar Value</a></li> -->
          </ul>
            <div id="tabs-1">
              <form method="post" action="<?php echo site_url().'bukutamu/'.$step; ?>" enctype="multipart/form-data">
                <?php 
                  if ($step == "update") { ?>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                  <?php } ?>
                <table cellpadding="0" cellspacing="0" border="0" class="display">
                  <tbody>
                    <tr>
                      <td align="left" width="15%">
                        <b>Nama</b>
                      </td>
                      <td>
                        <input type="text" name="nama" style="width:100%" class="input-wrc" value="<?php echo $nama; ?>" required="required">
                      </td>
                    </tr>
                    <tr>
                      <td align="left" width="15%" class="bg-grid">
                        <b>Email</b>
                      </td>
                      <td class="bg-grid">
                        <input type="text" name="email" style="width:100%" class="input-wrc" value="<?php echo $email; ?>" required="required">
                      </td>
                    </tr>
                    <tr>
                      <td align="left" width="15%" >
                        <b>NIB</b>
                      </td>
                      <td >
                        <input type="text" name="nib" style="width:100%" class="input-wrc" value="<?php echo $nib; ?>" required="required">
                      </td>
                    </tr>
                    
                    <!-- <tr>
                      <td align="left" width="15%" class="bg-grid">
                        <b>Nama Petugas</b>
                      </td>
                      <td class="bg-grid">
                        <input type="text" name="nama_petugas" style="width:100%" class="input-wrc" value="<?php echo $nama_petugas; ?>" required="required" disabled>
                      </td>
                    </tr> -->

                      <tr>
                      <td align="left" width="15%" >
                        <b>Telepon</b>
                      </td>
                      <td >
                        <input type="text" name="telepon" style="width:100%" class="input-wrc" value="<?php echo $telepon; ?>" required="required">
                      </td>
                    </tr>

                     <tr>
                      <td align="left" width="15%" class="bg-grid">
                        <b>Instansi</b>
                      </td>
                      <td class="bg-grid">
                        <input type="text" name="instansi" style="width:100%" class="input-wrc" value="<?php echo $instansi; ?>" required="required">
                      </td>
                    </tr>

                     <tr>
                      <td align="left" width="15%">
                        <b>Informasi / Permasalahan</b>
                      </td>
                      <td>
                        <input type="text" name="keperluan" style="width:100%" class="input-wrc" value="<?php echo $keperluan; ?>" required="required">
                      </td>
                    </tr>

                     <tr>
                      <td align="left" width="15%" class="bg-grid">
                        <b>Jabatan</b>
                      </td>
                      <td class="bg-grid">
                        <input type="text" name="esselon" style="width:100%" class="input-wrc" value="<?php echo $esselon; ?>" required="required">
                      </td>
                    </tr>

                     <tr>
                      <td align="left" width="15%">
                        <b>Lokasi</b>
                      </td>
                      <td>
                        <!-- <input type="text" name="lokasi" style="width:100%" class="input-wrc" value="<?php echo $lokasi; ?>" disabled required="required"> -->
                        <select class="pilihan" name="namampp" style="width:100%"  required="required">
                          <!-- <option>PILIH JENIS KELAMIN</option>  -->
                          <?php  foreach ($namampp as $rowlist) {  ?>
                          <option value="<?php echo $rowlist->id; ?>" <?php echo ($lokasi == $rowlist->id ? "selected" : ""); ?>><?php echo $rowlist->n_kabupaten; ?></option>
                          <?php } ?>
                        </select>
                      </td>
                    </tr>

                    <tr>
                      <td align="left" width="15%">
                        <b>Bidang / Sektor Perizinan</b>
                      </td>
                    <td>
                        <select class="pilihan" name="list2" style="width:100%"  required="required">
                          <!-- <option>PILIH JENIS KELAMIN</option>  -->
                          <?php foreach ($list2 as $rowlist) { ?>
                          <option value="<?php echo $rowlist->id; ?>" <?php echo ($sektor == $rowlist->id ? "selected" : ""); ?>><?php echo $rowlist->n_sektor; ?></option>
                          <?php } ?>
                        </select>
                      </td>
</tr>
 <tr>
                      <td align="left" width="15%">
                        <b>Tujuan Kedatangan</b>
                      </td>
                      <td >                        
                          <select class="pilihan" name="tujuan" style="width:100%" required>      
                       <option value="1" <?php echo ($tujuan == "1" ? "selected" : ""); ?>>Informasi</option>                     
                            <option value="2" <?php echo ($tujuan == "2" ? "selected" : ""); ?>>OSS</option>       
                            <option value="3" <?php echo ($tujuan == "3" ? "selected" : ""); ?>>LKPM</option>       
                             <option value="4" <?php echo ($tujuan == "4" ? "selected" : ""); ?>>Pengaduan</option>      
                                 <option value="5" <?php echo ($tujuan == "5" ? "selected" : ""); ?>>HAKI</option>      
                                     <option value="6" <?php echo ($tujuan == "6" ? "selected" : ""); ?>>SNI</option>      
                                         <option value="7" <?php echo ($tujuan == "7" ? "selected" : ""); ?>>BPOM</option>      
                                             <option value="8" <?php echo ($tujuan == "8" ? "selected" : ""); ?>>HALAL</option>      

                          </select>
                      </td>
                    </tr>
                    <tr>
                      <td align="left" width="15%">
                        <b>Jenis Izin</b>
                      </td>
                      <td>
                        <input type="text" name="jenis_izin" style="width:100%" class="input-wrc" value="<?php echo $jenis_izin; ?>" required="required">
                      </td>
                    </tr>
                    
                     <tr  class="bg-grid">
                      <td align="left" width="15%">
                        <b>Solusi</b>
                      </td>
                      <td>
                        <input type="text" name="solusi" style="width:100%" class="input-wrc" value="<?php echo $solusi; ?>" required="required">
                      </td>
                    </tr>
                    <tr>
                      <td align="left" width="15%">
                        <b>Keterangan</b>
                      </td>
                      <td>
                        <input type="text" name="Keterangan" style="width:100%" class="input-wrc" value="<?php echo $Keterangan; ?>" required="required">
                      </td>
                    </tr>

                      <tr>
                      <td align="left" width="15%">
                        <b>Upload Evidence</b>
                      </td>
                     <td>
                        <?php 
                     //var_dump(glob('assets/assets/calen/evidence/evidence_'.$event['id'].'.*'));die();
                   /// $files_image = glob('assets/assets/calen/evidence/evidence_'.$event['id'].'.*');
                  
                    foreach(glob('assets/assets/calen/ereport/evidence_'.$id.'.*', GLOB_NOSORT) as $image)   
                        {  
                            //echo "Filename: " . $image . "<br />";      
                            $files_image = $image ; 
                        }  
                              
                              //var_dump($files_image);die();
                            if (!empty($files_image)) {
                              
                              echo '<img src="'.base_url().$files_image.'" height="100" >';
                                ?>
                               <button name="button" type="button" class="button-wrc" onclick="if (confirm('Yakin Hapus Berkas?')) parent.location='<?php echo base_url(). "bukutamu/hapus_evidence/".$id; ?>'">X</button>
                               <?php 
                                } else { ?>
                    <input type="file" name="file_evidence" id="fileToUpload" class="submit-wrc" value="Pilih file" accept=".jpg,.jpeg,.png,.JPG,.JPEG,.PNG,.pdf">
                
                    <?php } ?>
                    </td>
                    </tr>
                   
                  </tbody>
                </table>
            </div>

           <!--  <div id="tabs-2">
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
      <button name="button" type="button" class="button-wrc" onclick="parent.location='<?php echo site_url('bukutamu'); ?>'">Batal</button>
    </div>
  </form>
  </div>
  <br style="clear: both;" />
</div>
