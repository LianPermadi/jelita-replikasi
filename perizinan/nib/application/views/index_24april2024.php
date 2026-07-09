    <style>
        /* Tambahkan gaya CSS sesuai kebutuhan */
        .hidden {
            display: none;
        }
    </style>
<?php
$this->load->view("partial/head.php");

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

<form method="post" action="/nib/home/proses_form">
    <label>Apakah Anda sudah memiliki Nomer Induk Berusaha (NIB)?</label>
    <select class="form-control" name="nib_status" id="nibStatus" onchange="toggleNIBInputs()">
        <option value="tidak">-</option>
        <option value="tidak">Tidak</option>
        <option value="ya">Ya</option>
    </select>

    <?php
    if ($this->session->flashdata('nib_number')) {
        ?>
        <div class="alert alert-danger" role="alert" style="text-align:center;">
            <?php echo $this->session->flashdata('nib_number'); ?>
        </div>
    <?php
    }
    ?>

    <label id="nibLabel" style="display: none;">Nomor NIB</label>
    <input type="text" class="form-control" name="nib_number" id="nibNumber" style="display: none;">

    <?php
    if ($this->session->flashdata('kbli_number')) {
        ?>
        <div class="alert alert-danger" role="alert" style="text-align:center;">
            <?php echo $this->session->flashdata('kbli_number'); ?>
        </div>
    <?php
    }
    ?>
    <label id="kbliLabel" style="display: none;">Nomor KBLI</label>
    <input type="text" class="form-control" name="kbli_number" id="kbliNumber" style="display: none;">

    <label>NIK (Nomor Induk Kependudukan)</label>
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

    <label>Nomor WA</label>
    <input type="text"  class="form-control" name="phone_number" required>

    <!-- <label>Petugas</label>
     <select class="custom-select" name="user"   id="inputGroupSelect01">
                                        <option value="" selected disabled>User</option>
                                     <?php  $sektor = ""; foreach ($user as $rowlist) { ?>                                    
                                      <option value="<?php echo $rowlist->id; ?>" <?php echo ($sektor == $rowlist->id ? "selected" : ""); ?>><?php echo $rowlist->oriname; ?></option>
                                      <?php } ?>
                                    </select>

 -->

    <label>Alamat Email</label>
    <input type="email"  class="form-control" name="email" required>

    <label>Nama Sesuai KTP</label>
    <input type="text"  class="form-control" name="name_ktp" required>

    <label>Tanggal Lahir</label>
    <input type="date" class="form-control" name="birthdate" id="birthdate" required>
    <small id="birthdateHelp" class="form-text text-muted"></small>

    <label>Alamat sesuai KTP</label>
    <input type="text"  class="form-control" name="address_ktp" required>

    <label>Kecamatan Sesuai KTP</label>
    <input type="text"  class="form-control" name="district_ktp" required>

    <label>Kelurahan Sesuai KTP</label>
    <input type="text"  class="form-control" name="subdistrict_ktp" required>

    <!-- ... Bagian formulir sebelumnya ... -->

    <!-- <label>Jenis Usaha</label>
    <small id="businessTypeHelp" class="form-text text-muted">
        i. Pendapatan/Penghasilan Per-Tahun<br>
        ii. Jasa (Jenis ini dalam kegiatan usaha memberikan layanan kepada pelanggannya contoh "salon, bengkel DLL")<br>
        iii. Industri Rumahan (Jenis ini dalam kegiatan usahanya membuat produk sendiri dari bahan mentah hingga membuat kemasan lalu memasarkannya)<br>
        iv. Kedai (Jenis ini dalam kegiatannya mengolah makanan di tempat untuk di bawa pulang oleh pelanggannya atau di di sajikan di tempat contoh "warung nasi, warung seblak, Dll)"<br>
        v. Lainnya (Bila jenis usaha tidak termasuk kedalam kategori silahkan konsultasikan kepada petugas)<br>
    </small>
    <select class="form-control" name="business_type" id="businessTypeSelect">
        <option value="pendapatan_per_tahun">Pendapatan/Penghasilan Per-Tahun</option>
        <option value="jasa">Jasa</option>
        <option value="industri_rumahan">Industri Rumahan</option>
        <option value="kedai">Kedai</option>
        <option value="lainnya">Lainnya</option>
    </select> -->
    <?php
    if ($this->session->flashdata('kbli_number')) {
        ?>
        <div class="alert alert-danger" role="alert" style="text-align:center;">
            <?php echo $this->session->flashdata('success'); ?>
        </div>
    <?php
    }
    ?>
    <!-- Input tambahan untuk "Lainnya" -->
    <div id="lainnyaInput" class="hidden">
        <label>Jenis Usaha Lainnya</label>
        <input type="text" class="form-control" name="business_type_other">
    </div>

    <label>Nama Usaha</label>
    <small id="birthdateHelp" class="form-text text-muted">(Contoh Baso Tahu Aceng, Elbi Barbershop)</small>
    <input type="text"  class="form-control" name="business_name" required>

    <label>Luas Lahan Usaha</label>
    <small id="birthdateHelp" class="form-text text-muted"> (Dalam Satuan Meter Persegi)</small>
    <input type="number"  class="form-control" name="land_area">

    <label>Alamat Tempat Usaha</label>
    <input type="text"  class="form-control" name="business_address" required>

    <label>Kecamatan Tempat Usaha</label>
    <input type="text"  class="form-control" name="district_business" required>

    <!-- <label>Kelurahan Tempat Usaha</label>
    <input type="text"  class="form-control" name="subdistrict_business" required> -->

    <label>Kode Pos Tempat Usaha</label>
    <input type="text"  class="form-control" name="postal_code_business" required>

    <label>Tahun dan Bulan Memulai Usaha </label>
    <small id="birthdateHelp" class="form-text text-muted"> (Contoh Juli 2024)</small>
    <input type="text"  class="form-control" name="start_date" required>

    <label>Modal Usaha</label>
    <small id="birthdateHelp" class="form-text text-muted">(Modal Usaha Termasuk Alat-Alat Pendukung Usaha, seperti tenda, meja, kompor, etalase dll)</small>
    <input type="text" class="form-control"  class="form-control" name="business_capital" required>

    <label>Jumlah Tenaga Kerja</label>
    <input type="number"  class="form-control" name="employees_number" required>

    <label>Pendapatan/Penghasilan Per-Tahun</label>
    <small id="birthdateHelp" class="form-text text-muted"> (Dalam satuan rupiah)</small>
    <input type="number"  class="form-control" name="annual_income" required>

    <label>Pilih Layanan:</label>
     <select  class="form-control" name="layanan">
         <option value="" selected disabled>Pilih Layanan:</option>
                                        <option value="Konsultasi dan Pelayanan Nomor Induk Berusaha(NIB)">Konsultasi dan Pelayanan Nomor Induk Berusaha(NIB)</option>
                                           <option value="Konsultasi dan Pelayanan Standar Nasional Indonesia(SNI)">Konsultasi dan Pelayanan Standar Nasional Indonesia(SNI)</option>
                                          <option value="Konsultasi dan Pelayanan Sertifikasi Halal">Konsultasi dan Pelayanan Sertifikasi Halal</option>
                                          <option value="Konsultasi dan Pelayanan Hak Kekayaan Intelektual(HaKi)">Konsultasi dan Pelayanan Hak Kekayaan Intelektual(HaKi)</option>
                                          <option value="Konsultasi dan Pelayanan Badan Pengawas Obat dan Makanan(BPOM)">Konsultasi dan Pelayanan Badan Pengawas Obat dan Makanan(BPOM)</option>
    </select>

   


    <!-- <label>Petugas pendamping</label>
    <select  class="form-control" name="accompanying_officer">
        <option value="FO">Petugas FO</option>
        <option value="MPP">Petugas MPP</option>
    </select>

        <label>Lokasi</label>
        <select class="custom-select"  class="form-control" name="location">
            <option value="MPP_Jawa_Barat">MPP di Jawa Barat</option>
            <option value="event">Event</option>
        </select> -->

    <!-- Sub-Field untuk lokasi "event" -->
        <!-- <label>Nama Event</label>
        <input type="text" class="form-control" name="event_name">

        <?php
        // $kabupaten = $this->absensi_model->kota_kabupaten(); 
        ?> -->
        <!-- Ubah "Lokasi Event" menjadi dropdown kabupaten/kota -->
        <!-- <label>Lokasi Event</label>
        <select class="form-control" name="event_location"> -->
            <!-- Gantilah opsi berikut dengan daftar kabupaten/kota di Jawa Barat -->
            <!-- <?php foreach ($kabupaten as $kota) { ?>
            <option value="<?php echo $kota->id; ?>"><?php echo $kota->n_kabupaten; ?></option>
            <?php } ?> -->
            <!-- ... tambahkan opsi lainnya sesuai kebutuhan ... -->
        <!-- </select> -->

    <button type="submit" class="btn btn-primary btn-round" >Submit</button>
</form>


<script src='https://www.google.com/recaptcha/api.js'></script>

<?php
$this->load->view("partial/foot.php");
?>

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
