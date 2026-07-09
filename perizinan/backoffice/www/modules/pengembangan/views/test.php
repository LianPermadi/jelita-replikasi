<form method="post" action="<?php echo site_url().'pengembangan/nib/'.$step; ?>" enctype="multipart/form-data">
    <div class="entry">
        <div id="tabs">
            <ul>
                <li><a href="#tabs-1">Ubah Nib</a></li>
            </ul>
            <div id="tabs-1">
                <div>
                    <b>Pilih Layanan:</b>
                    <select style="width:100%" name="layanan" id="layanan" class="pilihan" onchange="toggleNibInput()">
                        <option value="" selected disabled>Pilih Layanan:</option>
                        <option value="Pelayanan Pembuatan Nomor Induk Berusaha(NIB)(Langsung)">Pelayanan Pembuatan Nomor Induk Berusaha(NIB)(Langsung)</option>
                        <option value="Pelayanan Pembuatan Nomor Induk Berusaha(NIB)(Tidak Langsung)">Pelayanan Pembuatan Nomor Induk Berusaha(NIB)(Tidak Langsung)</option>
                        <option value="Konsultasi dan Pelayanan Standar Nasional Indonesia(SNI)">Konsultasi dan Pelayanan Standar Nasional Indonesia(SNI)</option>
                        <option value="Konsultasi dan Pelayanan Sertifikasi Halal">Konsultasi dan Pelayanan Sertifikasi Halal</option>
                        <option value="Konsultasi dan Pelayanan Hak Kekayaan Intelektual(HaKi)">Konsultasi dan Pelayanan Hak Kekayaan Intelektual(HaKi)</option>
                        <option value="Konsultasi dan Pelayanan Badan Pengawas Obat dan Makanan(BPOM)">Konsultasi dan Pelayanan Badan Pengawas Obat dan Makanan(BPOM)</option>
                    </select>
                </div>
                <div>
                    <b>Nama Petugas Input NIB</b>
                    <select style="width:100%" name="petugas_nib">
                        <option value="-" selected disabled>-</option>
                        <?php foreach ($pegawai as $rows) { ?>
                        <option value="<?php echo $rows->id; ?>"><?php echo $rows->n_pegawai ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div>
                    <b>NIK (Nomor Induk Kependudukan)</b>
                    <?php if ($this->session->flashdata('nik')) { ?>
                        <div class="alert alert-danger" role="alert" style="text-align:center;">
                            <?php echo $this->session->flashdata('nik'); ?>
                        </div>
                    <?php } ?>
                    <input type="text" style="width:100%" name="nik" value="">
                </div>
                <div>
                    <b>Nomor WA (Whatsapp)</b>
                    <input type="text" style="width:100%" name="phone_number" value="">
                </div>
                <div>
                    <b>Alamat Email</b>
                    <input type="email" style="width:100%" name="email" value="">
                </div>
                <div>
                    <b>Nama Sesuai KTP</b>
                    <input type="text" style="width:100%" name="name_ktp" value="">
                </div>
                <!-- Inputan Tambahan yang Hanya Muncul untuk Layanan Tidak Langsung -->
                <div id="additionalInputs" style="display: none;">
                    <b>Alamat sesuai KTP</b>
                    <input type="text" style="width:100%" name="alamat_ktp" value="">
                    <b>Kecamatan Sesuai KTP</b>
                    <input type="text" style="width:100%" name="kecamatan_ktp" value="">
                    <b>Kelurahan Sesuai KTP</b>
                    <input type="text" style="width:100%" name="kelurahan_ktp" value="">
                    <b>Jenis Usaha</b>
                    <input type="text" style="width:100%" name="jenis_usaha" value="">
                    <!-- Additional inputs specific to the service "Pelayanan Pembuatan Nomor Induk Berusaha(NIB)(Tidak Langsung)" -->
                    <b>Nama Usaha</b>
                    <input type="text" style="width:100%" name="nama_usaha" value="">
                    <b>Luas Lahan Usaha</b>
                    <input type="text" style="width:100%" name="luas_lahan_usaha" value="">
                    <b>Alamat Tempat Usaha</b>
                    <input type="text" style="width:100%" name="alamat_tempat_usaha" value="">
                    <!-- Add more inputs here if needed -->
                </div>
            </div>
        </div>
    </div>
</form>

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
        if (layanan.value === 'Pelayanan Pembuatan Nomor Induk Berusaha(NIB)(Tidak Langsung)') {
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