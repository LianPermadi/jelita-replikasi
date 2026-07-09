<?php 
  if (!empty($jdih)) {
    $id = $jdih->id;
    $tentang = $jdih->tentang;
    $status = $jdih->status;
    $nomor = $jdih->nomor;
    $tahun = $jdih->tahun;
    $kategori2 = $jdih->kategori;
    $tgl_penetapan = $jdih->tgl_penetapan;
    $tgl_pengundangan = $jdih->tgl_pengundangan;
    $mencabut = $jdih->mencabut;
    $mengubah = $jdih->mengubah;
    $dirubah = $jdih->dirubah;
    $dicabut = $jdih->dicabut;
    $institusi2 = $jdih->institusi;
    // $j_keterangan = $jdih->j_keterangan;
    // $j_id = $jdih->j_id;
   
  } else {  
    $id="";      
    $tentang = "";
    $status = "";
    $nomor = "";
    $tahun = "";
    $kategori2 = "";
    $tgl_penetapan = "";
    $tgl_pengundangan = "";
    $mencabut = "";
    $mengubah = "";
    $dirubah = "";
    $dicabut = "";
     $institusi2 = "";
    // $j_kategori = "";
    // $j_keterangan = "";
    // $j_id = "";

  } //var_dump($dicabut);die();
 ?>
<style>
{
 margin:0 auto;
 padding:0px;
 text-align:center;
 width:100%;
 font-family: "Myriad Pro","Helvetica Neue",Helvetica,Arial,Sans-Serif;
 background-color:#F9E79F;
}
#wrapper
{
 margin:0 auto;
 padding:0px;
 text-align:center;
 width:995px;
}
#wrapper h1
{
 margin-top:50px;
 font-size:45px;
 color:#9A7D0A;
}
#wrapper h1 p
{
 font-size:18px;
}
#employee_table input[type="text"]
{
 width:120px;
 height:35px;
 padding-left:10px;
}
#form_div input[type="button"]
{
 width:110px;
 height:35px;
 background-color:#D4AC0D;
 border:none;
 border-bottom:3px solid #B7950B;
 border-radius:3px;
 color:white;
}
#form_div input[type="submit"]
{
 margin-top:10px;
 width:110px;
 height:35px;
 background-color:#D4AC0D;
 border:none;
 border-bottom:3px solid #B7950B;
 border-radius:3px;
 color:white;
} </style>

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
            <li><a href="#tabs-1">Input JDIH</a></li>
           <!--  <li><a href="#tabs-2">Daftar Value</a></li> -->
          </ul>
            <div id="tabs-1">
              <form method="post" action="<?php echo site_url().'jdih/'.$step; ?>" enctype="multipart/form-data">
                <?php 
                  if ($step == "update") { ?>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                  <?php } ?>
                <table cellpadding="0" cellspacing="0" border="0" class="display">
                  <tbody>

                       <tr  class="bg-grid">
                      <td align="left" width="15%"  class="bg-grid">
                        <b>Nama Institusi</b>
                      </td>

                
                       <td>
                        <select class="pilihan" name="institusi" style="width:100%">
                          <?php foreach ($jdih_institusi as $rowinstitusi) { ?>
                            <option value="<?php echo $rowinstitusi->id; ?>" <?php echo ($institusi2 == $rowinstitusi->id ? "selected" : ""); ?>><?php echo $rowinstitusi->institusi; ?></option>
                          <?php } ?>
                        </select>
                      </td>


                    </tr>
                    
  <tr  class="bg-grid">
                      <td align="left" width="15%"  class="bg-grid">
                        <b>Kategori</b>
                      </td>

                  <!--  <td>
                        <select class="pilihan" name="kategori" style="width:100%"  required="required">
                          <option>PILIH JENIS KELAMIN</option> 
                          <?php foreach ($jdih_kategori as $rowlist) { ?>
                          <option value="<?php echo $rowlist->id; ?>" <?php echo ($kategori2 == $rowlist->id ? "selected" : ""); ?>><?php echo $rowlist->kategori; ?></option>
                          <?php } ?>
                        </select>
                      </td>
 -->
                       <td>
                        <select class="pilihan" name="kategori" style="width:100%">
                          <?php foreach ($jdih_kategori as $rowkategori) { ?>
                            <option value="<?php echo $rowkategori->id; ?>" <?php echo ($kategori2 == $rowkategori->id ? "selected" : ""); ?>><?php echo $rowkategori->kategori; ?></option>
                          <?php } ?>
                        </select>
                      </td>

                    </tr>

                      <tr  class="bg-grid">
                      <td align="left" width="15%" >
                        <b>tentang</b>
                      </td>
                      <td>
                        <input type="text" name="tentang" style="width:100%" class="input-wrc" value="<?php echo $tentang; ?>" required="required">
                      </td>
                    </tr>
                    <tr>

                    <tr>
                      <td align="left" width="15%">
                        <b>status</b>
                      </td>
                     

                        <td >
                        <!-- <input type="text" name="jeniskelamin" style="width:100%" class="input-wrc" value="<?php echo $jeniskelamin; ?>" required="required"> -->
                  <select class="pilihan" name="status" style="width:100%" required>
                      <!-- <option>PILIH JENIS KELAMIN</option> -->
                      <option value="0" <?php echo ($status == "0" ? "selected" : ""); ?>>BERLAKU</option>
                      <option value="1" <?php echo ($status == "1" ? "selected" : ""); ?>>TIDAK BERLAKU</option>
                  </select>
                      </td>

                    </tr>
                    <tr>
                      <td align="left" width="15%" class="bg-grid">
                        <b>nomor</b>
                      </td>
                      <td class="bg-grid">
                        <input type="text" name="nomor" style="width:100%" class="input-wrc" value="<?php echo $nomor; ?>" required="required">
                      </td>
                    </tr>

                     <tr>
                      <td align="left" width="25%" >
                        <b>tahun</b>
                      </td>
                      <td >
                        <input type="text" name="tahun" style="width:100%" class="input-wrc" value="<?php echo $tahun; ?>" required="required">
                      </td>
                    </tr>

                  



               <tr>
                <td align="left" width="15%">
                  <b>Tanggal Penetapan</b>
                </td>
                <td>
                  <?php 
                    $tgl_input = array('name' => 'tgl_penetapan',
                            'value' => ((!empty($tgl_penetapan)) ? $tgl_penetapan : date('Y-m-d')),
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
                  <b>Tanggal Pengundangan </b>
                </td>
                <td>
                  <?php 
                    $tgl_input = array('name' => 'tgl_pengundangan',
                            'value' => ((!empty($tgl_pengundangan)) ? $tgl_pengundangan : date('Y-m-d')),
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
                          <b>Upload PDF Hukum (PDF ONLY)</b>
                        </td>
                        <td class="bg-grid">
                          <?php 
                        //  var_dump(file_exists('assets/ossrba/bap/BAP_'.$id.'.pdf'));die;
                            if (file_exists('assets/jdih/hukum/HUKUM_'.$id.'.pdf')) {
                              echo "<a href='".base_url()."jdih/unduh_pdf/".$id."' style='color:blue;' target='_blank' title='Unduh Berkas'>Berkas Siap</a>&nbsp;"; ?>
                              <button name="button" type="button" class="button-wrc" onclick="if (confirm('Yakin Hapus Berkas?')) parent.location='<?php echo base_url(). "jdih/hapus_pdf/".$id; ?>'">X</button>
                            <?php 
                            } else { ?>
                              <input type="file" name="file_srt" id="fileToUpload" class="submit-wrc" value="Pilih file" accept=".pdf">
                            <?php } ?>
                        </td>
                      </tr>

                      <tr>
                        <td align="left" width="15%" class="bg-grid">
                          <b>Upload Abstrak(PDF ONLY)</b>
                        </td>
                        <td class="bg-grid">
                          <?php 
                        //  var_dump(file_exists('assets/ossrba/bap/BAP_'.$id.'.pdf'));die;
                            if (file_exists('assets/jdih/abstrak/ABSTRAK_'.$id.'.pdf')) {
                              echo "<a href='".base_url()."jdih/unduh_abstrak/".$id."' style='color:blue;' target='_blank' title='Unduh Berkas'>Berkas Siap</a>&nbsp;"; ?>
                              <button name="button" type="button" class="button-wrc" onclick="if (confirm('Yakin Hapus Berkas?')) parent.location='<?php echo base_url(). "jdih/hapus_abstrak/".$id; ?>'">X</button>
                            <?php 
                            } else { ?>
                              <input type="file" name="file_abstrak" id="fileToUpload" class="submit-wrc" value="Pilih file" accept=".pdf">
                            <?php } ?>
                        </td>
                      </tr>

                      <tr>
                        <td align="left" width="15%" class="bg-grid">
                          <b>Upload Lampiran</b>
                        </td>
                        <td class="bg-grid">
                          <?php 
                        //  var_dump(file_exists('assets/ossrba/bap/BAP_'.$id.'.pdf'));die;
                            if (file_exists('assets/jdih/lampiran/ABSTRAK_'.$id.'.pdf')) {
                              echo "<a href='".base_url()."jdih/unduh_lampiran/".$id."' style='color:blue;' target='_blank' title='Unduh Berkas'>Berkas Siap</a>&nbsp;"; ?>
                              <button name="button" type="button" class="button-wrc" onclick="if (confirm('Yakin Hapus Berkas?')) parent.location='<?php echo base_url(). "jdih/hapus_abstrak/".$id; ?>'">X</button>
                            <?php     } ?>
                              <input type="file" name="listlampiran[]" accept=".pdf" multiple>
                              
                              <?php 
                              // $it = new FilesystemIterator(dirname('assets/jdih/lampiran/'.$id."/"));
                              // echo iterator_count($it);
                              // if(iterator_count($it)>0){
                              //  $folderUpload  =  "assets/jdih/lampiran/".$id."/";
                              //     foreach ($it as $fileinfo) {
                              //         $lokasi =  $fileinfo->getFilename() . "";
                              //         $lokasi2 = $id."/".$lokasi;
                              //         // var_dump($lokasi);die();
                              //         // echo ($_SERVER['DOCUMENT_ROOT'].'/jelita/backoffice/assets/jdih/lampiran/'.$id.'/'.$lokasi);
                              //         echo base_url().'assets/jdih/lampiran/'.$id.'/'.$lokasi;
                              //           // echo "<a href='".base_url()."jdih/unduh_lampiran2/".$id."/".$lokasi."' style='color:blue;' target='_blank' title='Unduh Berkas'>Berkas Siap</a>&nbsp;"; 
                              //         echo "<a href='".base_url()."assets/jdih/lampiran/".$id."/".$lokasi."' style='color:blue;' target='_blank' title='Unduh Berkas'>Berkas Siap</a>&nbsp;"; 

                                     
                              //        <?php }
                              // }

                              // $fileItr = new FilesystemIterator(dirname('assets/jdih/lampiran/'.$id."/"), 
                              //               FilesystemIterator::KEY_AS_FILENAME);
                                      
                              //       // Loop runs while file iterator is valid
                              //       while ($fileItr->valid()) {
                                      
                              //           // Check for non directory files
                              //           if (!$fileItr->isDir()) {
                                      
                              //               // Display the key
                              //               echo $fileItr->key() . "<br>"; 
                              //           }
                                      
                              //           // Move to the next element
                              //           $fileItr->next();
                              //       }

                                    $directory = 'assets/jdih/lampiran/'.$id."/";
                                    $filecount = 0;
                                    $files = glob($directory . "*.pdf");
                                    if ($files){
                                     $filecount = count($files);
                                    }
                                    if ($files){
                                      // $filecount = count($files);
                                      // echo "<a href='".base_url()."jdih/unduh_lampiran2/".$files."' style='color:blue;' target='_blank' title='Unduh Berkas'>Berkas Siap</a>&nbsp;"; 
                                    }
                                    foreach ($files as $value) {
                                      // echo "$value <br>";
                                     echo "<br><a href='".base_url().$value."' style='color:blue;' target='_blank' title='Unduh Berkas'>".$value."</a>&nbsp;"; 
                                     $test = base64_encode($value);
                                     ?>

                                   <!--   <button name="button" type="button" class="button-wrc" onclick="if (confirm('Yakin Hapus Berkas?')) parent.location='<?php // unlink('/var/www/html/jelita/backoffice/'.$value); ?> '">X</button>\ -->
                                   <button name="button" type="button" class="button-wrc" onclick="if (confirm('Yakin Hapus Berkas?')) parent.location='<?php echo base_url(). "jdih/hapus_lampiran/".$id."/".$test; ?>'">X</button>
                                     <?php

                                    }
                                    // echo "There were $filecount files";
                                    // print_r($files);


                              ?>
                               <!-- <button name="button" type="button" class="button-wrc" onclick="if (confirm('Yakin Hapus Berkas?')) parent.location='<?php //unlink('/var/www/html/jelita/backoffice/assets/jdih/lampiran/'.$lokasi2); ?> '">X</button> -->

                            </td>
                        </td>
                      </tr>

                  <tr>
                      <td align="left" width="15%" class="bg-grid">
                        <b>Mencabut</b>
                      </td>
                         <td class="bg-grid">
                           <div   class="contentForm">
                                <?php
                                $mencabut_input = array('name' => 'mencabut',
                                                      'value' => $mencabut,
                                                      'style' => 'width:100%',
                                                      'class' => 'input-area-wrc'
                                                     );
                                echo form_textarea($mencabut_input);
                                ?>
                             </div>
                           </td>
                    </tr>

                     <tr>
                      <td align="left" width="15%" class="bg-grid">
                        <b>mengubah</b>
                      </td>
                         <td class="bg-grid">
                           <div   class="contentForm">
                                <?php
                                $mengubah_input = array('name' => 'mengubah',
                                                      'value' => $mengubah,
                                                      'style' => 'width:100%',
                                                      'class' => 'input-area-wrc'
                                                     );
                                echo form_textarea($mengubah_input);
                                ?>
                             </div>
                           </td>
                    </tr>

                     <tr>
                      <td align="left" width="15%" class="bg-grid">
                        <b>dirubah</b>
                      </td>
                         <td class="bg-grid">
                           <div   class="contentForm">
                                <?php
                                $dirubah_input = array('name' => 'dirubah',
                                                      'value' => $dirubah,
                                                      'style' => 'width:100%',
                                                      'class' => 'input-area-wrc'
                                                     );
                                echo form_textarea($dirubah_input);
                                ?>
                             </div>
                           </td>
                    </tr>

                     <tr>
                      <td align="left" width="15%" class="bg-grid">
                        <b>dicabut</b>
                      </td>
                         <td class="bg-grid">
                           <div   class="contentForm">
                                <?php
                                $dicabut_input = array('name' => 'dicabut',
                                                      'value' => $dicabut,
                                                      'style' => 'width:100%',
                                                      'class' => 'input-area-wrc'
                                                     );
                                echo form_textarea($dicabut_input);
                                ?>
                             </div>
                           </td>
                    </tr>
               
               <!-- <tr>
                      <td align="left" width="15%" class="bg-grid">
                        <b>Mencabut</b>
                      </td>
                      <td class="contentForm">
                        <textarea type="text" name="mencabut" style="width:100%" value="<?php echo $mencabut; ?>" ></textarea> 
                      </td>
                    </tr>

                  <tr>
                      <td align="left" width="15%" class="bg-grid">
                        <b>Mengubah</b>
                      </td>
                      <td class="bg-grid">
                        <textarea type="text" name="mengubah" style="width:100%" value="<?php echo $mengubah; ?>" ></textarea>
                      </td>
                    </tr>

                    <tr>
                      <td align="left" width="15%" class="bg-grid">
                        <b>Dicabut</b>
                      </td>
                      <td class="bg-grid">
                        <textarea type="text" name="dicabut" style="width:100%" value="<?php echo $dicabut; ?>" ></textarea>
                      </td>
                    </tr>

                    <tr>
                      <td align="left" width="15%" class="bg-grid">
                        <b>Dirubah</b>
                      </td>
                      <td class="bg-grid">
                        <textarea type="text" name="dirubah" style="width:100%" value="<?php echo $dirubah; ?>" ></textarea>
                      </td>
                    </tr> -->

                  </tbody>
                </table>
            </div>

          <!--   <div id="tabs-2">
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
      <button name="button" type="button" class="button-wrc" onclick="parent.location='<?php echo site_url('jdih'); ?>'">Batal</button>
    </div>
  </form>
  </div>
  <br style="clear: both;" />
</div>
