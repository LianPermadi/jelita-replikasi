<div id="content">
  <div class="post">
    <div class="title">
      <?php echo $this->lib_date->view_title($page_name); ?>
    </div>

    <?php 
        $request_uri = $_SERVER['PHP_SELF'];
    $clean_uri  = $_SERVER['PHP_SELF'];
    // Periksa apakah 'index.php' ada dalam URL
    if (strpos($request_uri, 'index.php') !== false) {
        // Hapus 'index.php' dari URL
        $clean_uri = str_replace('index.php', '', $request_uri);
    }
$request_uri = $clean_uri;
$clean_uri_luar  = $_SERVER['PHP_SELF'];
// Periksa apakah 'index.php' ada dalam URL
if (strpos($request_uri, 'index.php') !== false) {
    // Hapus 'index.php' dari URL
    $clean_uri_luar = str_replace('index.php', '', $request_uri);
}
if (strpos($request_uri, 'backoffice/') !== false) {
    // Hapus 'index.php' dari URL
    $clean_uri_luar = str_replace('backoffice/', '', $request_uri);
}
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
    <?php
    }
    ?>
    <?php
    if ($this->session->flashdata('error')) {
    ?>
        <div class="alert alert-danger" role="alert" style="text-align:center;">
            <?php echo $this->session->flashdata('error'); ?>
        </div>
        <br>
        <div style="color: red; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;"><center><?php echo $alert; ?></center></div>
      <?php } ?>
    <?php
    if ($this->session->flashdata('success')) {
    ?>
        <div class="alert alert-danger" role="alert" style="text-align:center;">
            <?php echo $this->session->flashdata('success'); ?>
        </div>
    <?php
    }
    ?>
    <form method="post" action="<?php echo site_url().'pengembangan/nib/'.$step; ?>" enctype="multipart/form-data">
    <div class="entry">
      <div id="tabs">
        <ul>
          <li><a href="#tabs-1">Ubah Nib</a></li>
        </ul>
        <div id="tabs-1">
          <table cellpadding="0" cellspacing="0" border="0" class="display">
            <tbody>
            <?php foreach ($pakai as $row) { ?>
              <tr>
                  <td align="left" width="15%" class="bg-grid"><b>Pilih Layanan:</b></td>
                  <td class="bg-grid">
                    <select style="width:100%" name="layanan" id="layanan" class="pilihan" onchange="toggleNibInput()">
                          <option value="">Pilih Layanan:</option>
                          <option value="Pelayanan Pembuatan Nomor Induk Berusaha(NIB)(Langsung)" <?php if($row->layanan == 'Pelayanan Pembuatan Nomor Induk Berusaha(NIB)(Langsung)'){ echo 'selected'; } ?>>Pelayanan Pembuatan Nomor Induk Berusaha(NIB)(Langsung)</option>
                          <option value="Pelayanan Pembuatan Nomor Induk Berusaha(NIB)(Tidak Langsung)" <?php if($row->layanan == 'Pelayanan Pembuatan Nomor Induk Berusaha(NIB)(Tidak Langsung)'){ echo 'selected'; } ?>>Pelayanan Pembuatan Nomor Induk Berusaha(NIB)(Tidak Langsung)</option>
                          <option value="Konsultasi dan Pelayanan Standar Nasional Indonesia(SNI)" <?php if($row->layanan == 'Konsultasi dan Pelayanan Standar Nasional Indonesia(SNI)'){ echo 'selected'; } ?>>Konsultasi dan Pelayanan Standar Nasional Indonesia(SNI)</option>
                          <option value="Konsultasi dan Pelayanan Sertifikasi Halal" <?php if($row->layanan == 'Konsultasi dan Pelayanan Sertifikasi Halal'){ echo 'selected'; } ?>>Konsultasi dan Pelayanan Sertifikasi Halal</option>
                          <option value="Konsultasi dan Pelayanan Hak Kekayaan Intelektual(HaKi)" <?php if($row->layanan == 'Konsultasi dan Pelayanan Hak Kekayaan Intelektual(HaKi)'){ echo 'selected'; } ?>>Konsultasi dan Pelayanan Hak Kekayaan Intelektual(HaKi)</option>
                          <option value="Konsultasi dan Pelayanan Badan Pengawas Obat dan Makanan(BPOM)" <?php if($row->layanan == 'Konsultasi dan Pelayanan Badan Pengawas Obat dan Makanan(BPOM)'){ echo 'selected'; } ?>>Konsultasi dan Pelayanan Badan Pengawas Obat dan Makanan(BPOM)</option>
                      </select>
                  </td>
              </tr>
              <tr>
                    <td align="left" width="15%"><b>Nama Petugas Input NIB</b></td>
                    <td>
                        <!-- <input type="text" class="input-wrc" style="width:100%" name="petugas_nib" value="<?php if(!empty($row->input_nib)){ echo $row->input_nib; } ?>"> -->
                        <select class="pilihan" style="width:100%" name="petugas_nib">
                            <option value="-" selected disabled>-</option>
                            <?php foreach ($pegawai as $rows) { ?>
                            <option value="<?php echo $rows->id; ?>" <?php if($rows->id == $row->petugas_nib){ echo 'selected'; } ?>><?= $rows->n_pegawai ?></option>
                           <?php } ?>

                        </select>
                    </td>
                </tr> 
              <tr>
                <td align="left" width="15%" class="bg-grid">
                  <b>Lokasi Event</b>
                </td>
                <td class="bg-grid">
                  <input type="text" class="input-wrc" style="width:100%" name="event_location" value="<?php echo $row->lokasi_event; ?>">
                </td>
              </tr>
              <tr>
                <td align="left" width="15%">
                  <b>Nama Pemohon</b>
                </td>
                <td>
                  <input type="text" class="input-wrc" style="width:100%" name="name_ktp" value="<?php echo $row->nama; ?>">
                </td>
              </tr>
              <tr>
                    <td align="left" width="15%"><b>NIK (Nomor Induk Kependudukan)</b></td>
                    <td>
                        <?php if ($this->session->flashdata('nik')) { ?>
                            <div class="alert alert-danger" role="alert" style="text-align:center;">
                                <?php echo $this->session->flashdata('nik'); ?>
                            </div>
                        <?php } ?>
                        <input type="text" class="input-wrc" style="width:100%" name="nik" value="<?= $row->nik ?>">
                    </td>
                </tr>
                <tr>
                    <td align="left" width="15%"><b>Nomor WA (Whatsapp)</b></td>
                    <td>
                        <input type="text" class="input-wrc" style="width:100%" name="phone_number" value="<?= $row->no_wa ?>">
                    </td>
                </tr>
                <tr>
                    <td align="left" width="15%"><b>Alamat Email</b></td>
                    <td>
                        <input type="email" class="input-wrc" style="width:100%" name="email" value="<?= $row->email ?>">
                    </td>
                </tr>
                <tr>
                    <td align="left" width="15%"><b>Upload KTP</b></td>
                    <td>
                  <?php 
                        $root_local = $_SERVER['SCRIPT_FILENAME'];
                        $root_fo = str_replace("backoffice/index.php", "", $root_local);
                        $root_backoffice = str_replace("index.php", "", $root_local);
                  if(file_exists($root_fo . "/nib/uploads/ktp/" . $row->file)){ ?>
                                        <img 
                                        src="<?php echo $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$clean_uri_luar; ?>nib/uploads/ktp/<?= $row->file ?>"
                                        class="img-preview img-fluid mb-3 col-sm-5"  
                                        style="max-height: 250px; max-width: 250px;"
                                        >
                                        <input type="hidden" name="file_hidden" value="<?= $row->file ?>">
                        <input type="file" id="foto" onchange="previewImage()" name="file" class="button-wrc" style="width:100%" accept=".jpg, .png, .jpeg">
                                      <?php }else{ ?>
                                        <img 
                                        class="img-preview img-fluid mb-3 col-sm-5" 
                                        style="max-height: 250px; max-width: 250px;"
                                        >
                                        <input type="hidden" name="file_hidden" value="">
                        <input type="file" id="foto" onchange="previewImage()" name="file" class="button-wrc" style="width:100%" accept=".jpg, .png, .jpeg">
                                      <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td align="left" width="15%"><b>Upload pdf NIB</b></td>
                    <td>
                      <?php 
                      if(!file_exists($root_fo. '/nib/uploads/pdf/'. $row->file_nib_pdf) || $row->file_nib_pdf != NULL || $row->file_nib_pdf != ''){ ?>
                            <!-- Link untuk melihat PDF -->
                            <a href="<?php echo $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'] .$clean_uri; ?>pengembangan/nib/download_pdf/<?= $row->file_nib_pdf ?>" target="_blank" style="border: 1px;"><button type="button" class="btn btn-primary">Lihat PDF</button></a>
                            <br>

                            <!-- Input hidden untuk menyimpan nama file PDF -->
                            <input type="hidden" class="button-wrc" style="width:100%" name="pdf_nib_hidden" value="<?= $row->file_nib_pdf ?>">

                            <!-- Tombol "Perbaiki File" -->
                            <button type="button" class="button-wrc" onclick="toggleFileInput()">Perbaiki File</button>

                            <!-- Input file yang akan muncul saat tombol "Perbaiki File" diklik -->
                            <input type="file" class="button-wrc" style="width:100%; display:none" id="pdf_nib_input" name="pdf_nib" accept=".pdf, .PDF">

                            <!-- Script JavaScript untuk menampilkan input file -->
                            <script>
                                function toggleFileInput() {
                                    var fileInput = document.getElementById('pdf_nib_input');
                                    var button = document.querySelector('.button-wrc');
                                    // var button = document.querySelector('#ubah');

                                    if (fileInput.style.display === 'none' || fileInput.style.display === '') {
                                        fileInput.style.display = 'block';
                                        button.textContent = 'Tutup Perbaiki File';
                                    } else {
                                        fileInput.style.display = 'none';
                                        button.textContent = 'Perbaiki File';
                                    }
                                }
                            </script>
                      <?php }else{ ?>
                        <input type="hidden" class="button-wrc" style="width:100%" name="pdf_nib_hidden" value="">
                        <input type="file" class="button-wrc" style="width:100%" name="pdf_nib" accept=".pdf, .PDF">
                      <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td align="left" width="15%"><b>kode KBLI</b></td>
                    <td>
                        <input type="hidden" class="input-wrc" style="width:100%" name="id" value="<?= $row->id ?>">
                        <input type="text" class="input-wrc" style="width:100%" name="kbli" value="<?= $row->kbli ?>">
                    </td>
                </tr>
                <tr class="form-elements" id="nib_input">
                    <td align="left" width="15%"><b>Pelayanan Pembuatan Nomor Induk Berusaha(NIB)(Tidak Langsung)</b></td>
                    <td>
                        <div>
                    <!-- Inputan Tambahan yang Hanya Muncul untuk Layanan Tidak Langsung -->
                            <b>Alamat sesuai KTP</b>
                            <input type="text" style="width:100%" class="input-wrc" name="alamat_ktp" value="<?= $row->alamat ?>">
                            <b>Kecamatan Sesuai KTP</b>
                            <input type="text" style="width:100%" class="input-wrc" name="kecamatan_ktp" value="<?= $row->kecamatan ?>">
                            <b>Kelurahan Sesuai KTP</b>
                            <input type="text" style="width:100%" class="input-wrc" name="kelurahan_ktp" value="<?= $row->kelurahan ?>">
                            <b>Jenis Usaha</b>
                            <input type="text" style="width:100%" class="input-wrc" name="jenis_usaha" value="<?= $row->j_usaha ?>">
                            <!-- Additional inputs specific to the service "Pelayanan Pembuatan Nomor Induk Berusaha(NIB)(Tidak Langsung)" -->
                            <b>Nama Usaha</b>
                            <input type="text" style="width:100%" class="input-wrc" name="nama_usaha" value="<?= $row->n_usaha ?>">
                            <b>Luas Lahan Usaha</b>
                            <input type="text" style="width:100%" class="input-wrc" name="luas_lahan_usaha" value="<?= $row->luas_lahan ?>">
                            <b>Alamat Tempat Usaha</b>
                            <input type="text" style="width:100%" class="input-wrc" name="alamat_tempat_usaha" value="<?= $row->alamat_usaha ?>">
                            <div>
                                <b>Kecamatan Tempat Usaha</b>
                                <input type="text" style="width:100%" class="input-wrc" name="kecamatan_tempat_usaha" value="<?= $row->alamat_usaha ?>">
                            </div>
                            <!-- <div>
                                <b>Kelurahan Tempat Usaha</b>
                                <input type="text" style="width:100%" class="input-wrc" name="kelurahan_tempat_usaha" value="// $row->kelurahan_usaha ">
                            </div> -->
                            <!-- <div>
                                <b>Kode Pos Tempat Usaha</b>
                                <input type="text" style="width:100%" class="input-wrc" name="kode_pos_tempat_usaha" value="// $row->alamat_usaha ">
                            </div> -->
                            <div>
                                <b>Tahun dan Bulan Memulai Usaha</b>
                                <input type="text" style="width:100%" class="input-wrc" name="tahun_bulan_memulai_usaha" value="<?= $row->bulan_tahun_berdiri ?>">
                            </div>
                            <div>
                                <b>Modal Usaha</b>
                                <input type="text" style="width:100%" class="input-wrc" name="modal_usaha" value="<?= $row->modal_usaha ?>">
                            </div>
                            <div>
                                <b>Jumlah Tenaga Kerja</b>
                                <input type="text" style="width:100%" class="input-wrc" name="jumlah_tenaga_kerja" value="<?= $row->jumlah_tenaga_kerja ?>">
                            </div>
                            <div>
                                <b>Pendapatan/Penghasilan Per-Tahun</b>
                                <input type="text" style="width:100%" class="input-wrc" name="pendapatan_per_tahun" value="<?= $row->pndapatan ?>">
                            </div>
                             
                        </div>
                    </td>
                </tr>
                
               
              
                  <!-- <tr class="form-elements" id="nib_input">
                      <td>
                          <b><label for="kegiatan">Kegiatan:</label></b>
                      </td>
                      <td>
                          <input type="text" class="input-wrc" style="width:100%" id="kegiatan" name="kegiatan" value="<?php echo $row->kegiatan; ?>">
                      </td>
                  </tr>
                  <tr class="form-elements" id="nib_input">
                      <td>
                          <b><label for="luas_lahan">Luas Lahan Usaha:</label></b>
                      </td>
                      <td>
                          <input type="text" class="input-wrc" style="width:100%" id="luas_lahan" name="luas_lahan" value="<?php echo $row->luas_lahan; ?>">
                      </td>
                  </tr>
                  <tr class="form-elements" id="nib_input">
                      <td>
                          <b><label for="modal_usaha">Modal Usaha:</label></b>
                      </td>
                      <td>
                          <input type="text" class="input-wrc" style="width:100%" id="modal_usaha" name="modal_usaha" value="<?php echo $row->modal_usaha; ?>">
                      </td>
                  </tr>
                  <tr class="form-elements" id="nib_input">
                      <td>
                          <b><label for="jumlah_tenaga_kerja">Jumlah Tenaga Kerja:</label></b>
                      </td>
                      <td>
                          <input type="text" class="input-wrc" style="width:100%" id="jumlah_tenaga_kerja" name="jumlah_tenaga_kerja" value="<?php echo $row->jumlah_tenaga_kerja; ?>">
                      </td>
                  </tr>
                  <tr class="form-elements" id="nib_input">
                      <td>
                          <b><label for="kapasitas_produksi">Kapasitas Produksi Per Tahun:</label></b>
                      </td>
                      <td>
                          <input type="text" class="input-wrc" style="width:100%" id="kapasitas_produksi" name="kapasitas_produksi" value="<?php echo $row->kapasitas_produksi_pertahun; ?>">
                      </td>
                  </tr>
                  <tr class="form-elements" id="nib_input">
                   `   <td>
                          <b><label for="alamat_usaha">Alamat Usaha:</label></b>
                      </td>
                      <td>
                          <input type="text" class="input-wrc" style="width:100%" id="alamat_usaha" name="alamat_usaha" value="<?php echo $row->alamat_usaha; ?>">
                      </td>
                  </tr>
                  <tr class="form-elements" id="nib_input">
                      <td>
                          <b><label for="lama_usaha">Lama Usaha:</label></b>
                      </td>
                      <td>
                          <input type="text" class="input-wrc" style="width:100%" id="lama_usaha" name="lama_usaha" value="<?php echo $row->lama_usaha; ?>">
                      </td>
                  </tr> -->
            <?php } ?>
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
      <button name="button" type="button" class="button-wrc" onclick="parent.location='<?php echo site_url('pengembangan/nib'); ?>'">Batal</button>
    </div>
  </form>
  </div>
  <br style="clear: both;" />
</div>


<script>
    function toggleNibInput() {
        var layanan = document.getElementById("layanan").value;
        var additionalInputs = document.getElementById("additionalInputs");

        // Show additional inputs if the selected service is "Pelayanan Pembuatan Nomor Induk Berusaha(NIB)(Tidak Langsung)"
        if (layanan === "Pelayanan Pembuatan Nomor Induk Berusaha(NIB)(Tidak Langsung)") {
            additionalInputs.style.display = "block";
        } else {
            additionalInputs.style.display = "none";
        }
    }
</script>


<script>
    // Fungsi untuk menampilkan atau menyembunyikan input tambahan saat memilih layanan
    function toggleAdditionalInputs() {
        var layanan = document.getElementById('layanan');
        var additionalInputs = document.getElementById('additionalInputs');

        // Jika layanan yang dipilih adalah "Pelayanan Pembuatan Nomor Induk Berusaha(NIB)(Tidak Langsung)", tampilkan input tambahan
        if (layanan.value === 'Pelayanan Pembuatan Nomor Induk Berusaha(NIB)(Langsung)') {
            additionalInputs.style.display = 'block';
        } else {
            // Jika tidak, sembunyikan input tambahan
            additionalInputs.style.display = 'none';
        }
    }

    // Panggil fungsi toggleAdditionalInputs saat halaman dimuat untuk pertama kali
    window.onload = function() {
        toggleAdditionalInputs();
    };
</script>
<script>
    // Fungsi untuk menampilkan atau menyembunyikan elemen HTML berdasarkan nilai dropdown yang dipilih
    function toggleNibInput() {
        var dropdown = document.getElementById('layanan');
        var nibInput = document.getElementsByClassName('form-elements');

        // Jika nilai dropdown yang dipilih adalah 'Pelayanan Pembuatan Nomor Induk Berusaha(NIB)(Langsung)', tampilkan elemen HTML dengan ID 'nib_input'
        if (dropdown.value === 'Pelayanan Pembuatan Nomor Induk Berusaha(NIB)(Tidak Langsung)') {
            for (var i = 0; i < nibInput.length; i++) {
                nibInput[i].style.display = 'table-row';
            }
        } else {
            // Jika tidak, sembunyikan elemen HTML dengan ID 'nib_input'
            for (var i = 0; i < nibInput.length; i++) {
                nibInput[i].style.display = 'none';
            }
        }
    }

    // Panggil fungsi ketika halaman dimuat untuk pertama kali
    window.onload = function() {
        toggleNibInput();
    };
</script>
<script>
    function previewImage() {
        const image = document.querySelector('#foto');
        const imgPreview = document.querySelector('.img-preview')

        imgPreview.style.display = 'block';

        const oFReader = new FileReader();
        oFReader.readAsDataURL(image.files[0]);
        oFReader.onload = function(oFREvent) {
            imgPreview.src = oFREvent.target.result;
        }
    }
   
    var currencyInput = document.querySelectorAll( 'input[type="currency"]' );

    for ( var i = 0; i < currencyInput.length; i++ ) {

        var currency = 'IDR'
        onBlur( {
            target: currencyInput[ i ]
        } )

        currencyInput[ i ].addEventListener( 'focus', onFocus )
        currencyInput[ i ].addEventListener( 'blur', onBlur )

        function localStringToNumber( s ) {
            return Number( String( s ).replace( /[^0-9.-]+/g, "" ) )
        }

        function onFocus( e ) {
            var value = e.target.value;
            e.target.value = value ? localStringToNumber( value ) : ''
        }

        function onBlur( e ) {
            var value = e.target.value

            var options = {
                maximumFractionDigits: 0,
                currency: currency,
                style: "currency",
                currencyDisplay: "symbol"
            }

            e.target.value = ( value || value === 0 ) ?
                localStringToNumber( value ).toLocaleString( undefined, options ) :
                ''
        }
    }
    var currencyInput = document.querySelectorAll( 'input[type="currency"]' );

    for ( var i = 0; i < currencyInput.length; i++ ) {

        var currency = 'IDR'
        onBlur( {
            target: currencyInput[ i ]
        } )

        currencyInput[ i ].addEventListener( 'focus', onFocus )
        currencyInput[ i ].addEventListener( 'blur', onBlur )

        function localStringToNumber( s ) {
            return Number( String( s ).replace( /[^0-9.-]+/g, "" ) )
        }

        function onFocus( e ) {
            var value = e.target.value;
            e.target.value = value ? localStringToNumber( value ) : ''
        }

        function onBlur( e ) {
            var value = e.target.value

            var options = {
                maximumFractionDigits: 0,
                currency: currency,
                style: "currency",
                currencyDisplay: "symbol"
            }

            e.target.value = ( value || value === 0 ) ?
                localStringToNumber( value ).toLocaleString( undefined, options ) :
                ''
        }
    }
</script>
