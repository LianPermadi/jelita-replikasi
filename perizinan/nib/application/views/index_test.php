<style>
        /* Tambahkan gaya CSS sesuai kebutuhan */
        .hidden {
            display: none;
        }
    </style>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet" />

<?php
$this->load->view("partial/head_pendaftaran.php");

if ($this->session->flashdata('success')) {
    ?>
    <div class="alert alert-success" role="alert" style="text-align:center;">
        <?php echo $this->session->flashdata('success'); ?>
    </div>
<?php
}

if ($this->session->flashdata('error')) {
    ?>
    <div class="alert alert-danger" role="alert" style="text-align:center;">
        <?php echo $this->session->flashdata('error'); ?>
    </div>
<?php
}
?>

<form method="post" action="/nib/home/proses_form" enctype="multipart/form-data">

    <label>Pilih Layanan:</label>
    <?php
    if ($this->session->flashdata('layanan')) {
    ?>
        <div class="alert alert-danger" role="alert" style="text-align:center;">
            <?php echo $this->session->flashdata('layanan'); ?>
        </div>
    <?php
    }
    ?>
    <select  class="form-control" name="layanan" id="layanan">
        <option value="" selected disabled>Pilih Layanan:</option>
        <?php
        if($onoff == 1){
        ?>
        <option value="Pelayanan Pembuatan Nomor Induk Berusaha(NIB)(Langsung)">Pelayanan Pembuatan Nomor Induk Berusaha(NIB)(Langsung)</option>
        <?php } ?>
        <option value="Pelayanan Pembuatan Nomor Induk Berusaha(NIB)(Tidak Langsung)">Pelayanan Pembuatan Nomor Induk Berusaha(NIB)(Tidak Langsung)</option>
        <option value="Gerakan Pelayanan Terpadu (GPT)">Gerakan Pelayanan Terpadu (GPT)</option>
        
        <!-- <option value="Konsultasi dan Pelayanan Standar Nasional Indonesia(SNI)">Konsultasi dan Pelayanan Standar Nasional Indonesia(SNI)</option>
        <option value="Konsultasi dan Pelayanan Sertifikasi Halal">Konsultasi dan Pelayanan Sertifikasi Halal</option>
        <option value="Konsultasi dan Pelayanan Hak Kekayaan Intelektual(HaKi)">Konsultasi dan Pelayanan Hak Kekayaan Intelektual(HaKi)</option> -->
        <!-- <option value="Konsultasi dan Pelayanan Badan Pengawas Obat dan Makanan(BPOM)">Konsultasi dan Pelayanan Badan Pengawas Obat dan Makanan(BPOM)</option> -->
    </select>
    <div id="agen_nib_kondisi" style="display: none; margin-top: 20px;">
    
        <label>Agen NIB:</label>
        <select  class="form-control agen-nib" name="Agen_Nib" id="Agen_Nib">
            <option value="" selected disabled>Pilih Agen NIB :</option>
            <option value="-">Tidak ada Agen NIB</option>
            <?php foreach ($pegawai as $rows) { ?>
                <option value="<?php echo $rows->n_pegawai; ?>"><?= $rows->n_pegawai ?></option>
            <?php } ?>
        </select>
    </div>

    <!-- <div id="Lokasi_Nib" style="display: none; margin-top: 20px;">
        <label>Lokasi:</label>
        <select  class="form-control lokasi-kabupaten-kota" name="lokasi_nib" id="lokasi_nib">
            <option value="" selected disabled>Pilih Lokasi :</option>
            <?php foreach ($namampp as $rows) { ?>
                <option value="<?php echo $rows->n_kabupaten; ?>"><?= $rows->n_kabupaten ?></option>
            <?php } ?>
        </select>
    </div> -->
    <div style="margin-top: 20px;">
        <label>Lokasi:</label>
        <select  class="form-control lokasi-kabupaten-kota" name="lokasi_nib">
            <option value="" selected disabled>Pilih Lokasi :</option>
            
            <?php foreach ($namampp as $rows) { ?>
                <option value="<?php echo $rows->n_kabupaten; ?>"><?= $rows->n_kabupaten ?></option>
            <?php } ?>
            <option value="WINDU">WINDU</option>
        </select>
    </div>
    <div id="public_services" style="margin-top: 20px;" >
        <label for="layanan">Sebagai pelaku usaha atau masyarakat, layanan publik apa saja yang dibutuhkan?</label>
        
        <div class="input-group mb-3 public-services-grid">
            <div>
                <input type="checkbox" class="mt-2" name="layanan_gpt[]" value="Layanan Sertifikat Halal (Kemenag Kanwil Jawa Barat)">
                Layanan Sertifikat Halal (Kemenag Kanwil Jawa Barat)<br>

                <input type="checkbox" class="mt-2" name="layanan_gpt[]" value="Layanan Sertifikasi/ Izin Edar BPOM ">
                Layanan Sertifikasi/ Izin Edar BPOM <br>

                <input type="checkbox" class="mt-2" name="layanan_gpt[]" value="Layanan SNI – Sertifikat Standar Produk (BSN Jawa Barat)">
                Layanan SNI – Sertifikat Standar Produk (BSN Jawa Barat)<br>

                <input type="checkbox" class="mt-2" name="layanan_gpt[]" value="Layanan HaKI – Hak Cipta Produk Perseroan Perseorangan (Kemenkumham Kanwil Jawa Barat)">
                Layanan HaKI – Hak Cipta Produk Perseroan Perseorangan (Kemenkumham Kanwil Jawa Barat)<br>

                <input type="checkbox" class="mt-2" name="layanan_gpt[]" value="Layanan AHU – Pendirian Badan Usaha (Kemenkumham Kanwil Jawa Barat)">
                Layanan AHU – Pendirian Badan Usaha (Kemenkumham Kanwil Jawa Barat)<br>

                <input type="checkbox" class="mt-2" name="layanan_gpt[]" value="Layanan E-Katalogue (Biro PBJ Jawa Barat)">
                Layanan E-Katalogue (Biro PBJ Jawa Barat)<br>
            </div>

            <div>
                <input type="checkbox" class="mt-2" name="layanan_gpt[]" value="Layanan NPWP (Kanwil DJP II Jawa Barat)">
                Layanan NPWP (Kanwil DJP II Jawa Barat)<br>

                <input type="checkbox" class="mt-2" name="layanan_gpt[]" value="Layanan SIINas/ Penerbitan Sertfikat TKDN (Disperindag Jabar)">
                Layanan SIINas/ Penerbitan Sertfikat TKDN (Disperindag Jabar)<br>

                <input type="checkbox" class="mt-2" name="layanan_gpt[]" value="Layanan Kependudukan ">
                Layanan Kependudukan <br>

                <input type="checkbox" class="mt-2" name="layanan_gpt[]" value="Layanan Pembiayaan Permodalan (Kredit Usaha)">
                Layanan Pembiayaan Permodalan (Kredit Usaha)<br>
            </div>
        </div>
    </div>
    <label style="margin-top: 20px;">Nama Sesuai KTP</label>
    <input type="text"  class="form-control" name="nama" required>
    
    
   
    <label >NIK (Nomor Induk Kependudukan)</label>
    <?php
    if ($this->session->flashdata('nik')) {
    ?>
        <div class="alert alert-danger" role="alert" style="text-align:center;">
            <?php echo $this->session->flashdata('nik'); ?>
        </div>
    <?php
    }
    ?>
    <input type="text"  class="form-control" name="nik" required>

    <label>Nomor WA (Whatsapp)</label>
    <input type="text"  class="form-control" name="phone_number" required>

    <label>Alamat Email</label>
    <input type="email"  class="form-control" name="email" required>

    <label>Upload KTP</label>
        <img class="img-preview img-fluid mb-3 col-sm-5" style="max-height: 250px; max-width: 250px;">
        <input type="file" id="foto" onchange="previewImage()" class="form-control" name="file" accept=".jpg, .jpeg, .png" required>
    <div id="nib_input" style="display: none;">
        
        <label for="tanggal lahir">Tanggal Lahir:</label>
        <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir">
        <br>
        <label for="nik"> Alamat sesuai KTP:</label>
        <input type="text" class="form-control" id="alamat_sesuai_ktp" name="alamat_sesuai_ktp">
        <br>
        <label for="kecamatan_sesuai_ktp">Kecamatan Sesuai KTP:</label>
        <input type="text" class="form-control" id="kecamatan_sesuai_ktp" name="kecamatan_sesuai_ktp">
        <br>
        <label for="kelurahan_sesuai_ktp"> Kelurahan Sesuai KTP:</label>
        <input type="Text" class="form-control" id="kelurahan_sesuai_ktp" name="kelurahan_sesuai_ktp">
        <br>
        


        <label for="kegiatan">Nama Usaha:</label>
        <input type="text" class="form-control" id="kegiatan" name="kegiatan">
        <br>
        <label for="j_usaha"> Jenis Usaha:</label>
        <input type="Text" class="form-control" id="j_usaha" name="j_usaha">
        <br>
        <label for="luas_lahan">Luas Lahan Usaha:</label>
        <input type="text" class="form-control" id="luas_lahan" name="luas_lahan">
        <br>
        <label for="modal_usaha">Modal Usaha:</label>
        <input type="text" class="form-control" id="modal_usaha" name="modal_usaha">
        <br>
        <label for="jumlah_tenaga_kerja">Jumlah Tenaga Kerja:</label>
        <input type="text" class="form-control" id="jumlah_tenaga_kerja" name="jumlah_tenaga_kerja">
        <br>
        <label for="kapasitas_produksi">Pendapatan/Penghasilan Per-Tahun:</label>
        <input type="text" class="form-control" id="kapasitas_produksi" name="kapasitas_produksi">
        <br>
        <label for="alamat_usaha">Alamat Tempat Usaha:</label>
        <input type="text" class="form-control" id="alamat_usaha" name="alamat_usaha">
        <br>
        <!-- baru 2024-06-06 -->
        <label for="kecamatan_tempat_usaha">Kecamatan Tempat Usaha:</label>
        <input type="text" class="form-control" id="kecamatan_tempat_usaha" name="kecamatan_tempat_usaha">
        <br>
        <label for="kelurahan_tempat_usaha">Kelurahan Tempat Usaha:</label>
        <input type="text" class="form-control" id="kelurahan_tempat_usaha" name="kelurahan_tempat_usaha">
        <br>
        <label for="kode_pos_tempat_usaha">Kode Pos Tempat Usaha:</label>
        <input type="number" class="form-control" id="kode_pos_tempat_usaha" name="kode_pos_tempat_usaha">
        <br>
            <!-- baru 2024-06-06 -->

        <label for="lama_usaha">Bulan dan Tahun Memulai Usaha (ex. Januari 2020):</label>
        <input type="text" class="form-control" id="lama_usaha" name="lama_usaha">
        <br>
      
        <br>
    </div>
    <div style="display: flex; justify-content: center;">
        <button type="submit" class="btn btn-primary btn-round">Submit</button>
    </div>
</form>

<script src='https://www.google.com/recaptcha/api.js'></script>

<?php
$this->load->view("partial/foot.php");
?>


<script>
    document.getElementById('layanan').addEventListener('change', function() {
        var selectedOption = this.value;
        var nibInput = document.getElementById('nib_input');
        // var lokasiNib = document.getElementById('Lokasi_Nib');
        var AgenNib = document.getElementById('agen_nib_kondisi');


        if (selectedOption === "Pelayanan Pembuatan Nomor Induk Berusaha(NIB)(Tidak Langsung)") {
            nibInput.style.display = 'block';
            AgenNib.style.display = 'block';
            // lokasiNib.style.display = 'none';
        } else if (selectedOption === "Gerakan Pelayanan Terpadu (GPT)") {
            nibInput.style.display = 'block';
            // lokasiNib.style.display = 'block';
            AgenNib.style.display = 'none';

        } else {
            nibInput.style.display = 'none';
            .// lokasiNib.style.display = 'none';
        }
    });
</script>


<script>
    function toggleNIBInputs() {
        var nibStatus = document.getElementById('nibStatus');
        var nibLabel = document.getElementById('nibLabel');
        var nibNumber = document.getElementById('nibNumber');
        var kbliLabel = document.getElementById('kbliLabel');
        var kbliNumber = document.getElementById('kbliNumber');

        if (nibStatus.value === 'ya') {
            nibLabel.style.display = 'block';
            nibNumber.style.display = 'block';
            kbliLabel.style.display = 'block';
            kbliNumber.style.display = 'block';
        } else {
            nibLabel.style.display = 'none';
            nibNumber.style.display = 'none';
            kbliLabel.style.display = 'none';
            kbliNumber.style.display = 'none';
        }
    }

    //     document.getElementById('birthdate').addEventListener('input', function() {
    //     var birthdateInput = this.value;

    //     // Validasi format DD/MM/YYYY menggunakan regular expression
    //     var dateRegex = /^(\d{2})\/(\d{2})\/(\d{4})$/;

    //     if (dateRegex.test(birthdateInput)) {
    //         document.getElementById('birthdate').setCustomValidity('');
    //     } else {
    //         document.getElementById('birthdate').setCustomValidity('Format harus DD/MM/YYYY');
    //     }
    // });

        // Fungsi untuk menangani perubahan dalam elemen <select>
    function handleBusinessTypeChange() {
        var selectedOption = document.getElementById('businessTypeSelect').value;
        var lainnyaInput = document.getElementById('lainnyaInput');

        // Tampilkan input tambahan hanya jika opsi "Lainnya" dipilih
        if (selectedOption === 'lainnya') {
            lainnyaInput.classList.remove('hidden');
        } else {
            lainnyaInput.classList.add('hidden');
        }
    }

    // Tambahkan event listener ke elemen <select>
    document.getElementById('businessTypeSelect').addEventListener('change', handleBusinessTypeChange);

     // Fungsi untuk menangani perubahan dalam elemen <select>
    function handleLocationChange() {
        var selectedLocation = document.getElementById('locationSelect').value;
        var eventFields = document.getElementById('eventFields');

        // Tampilkan field-event hanya jika opsi "event" dipilih
        if (selectedLocation === 'event') {
            eventFields.classList.remove('hidden');
        } else {
            eventFields.classList.add('hidden');
        }
    }

    // Tambahkan event listener ke elemen <select>
    document.getElementById('locationSelect').addEventListener('change', handleLocationChange);
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
</script>