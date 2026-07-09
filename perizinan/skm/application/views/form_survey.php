<?php $this->load->view("partial/head.php") ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if ($this->session->flashdata('success')): ?>
    <script type="text/javascript">
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '<?php echo $this->session->flashdata('success'); ?>',
            showConfirmButton: true,
            confirmButtonText: 'Lanjutkan',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "https://dpmptsp.jabarprov.go.id/survey_ipak";
            }
        });
    </script>
<?php endif; ?>
<?php if ($this->session->flashdata('berhasil')): ?>
    <script type="text/javascript">
        Swal.fire({
            icon: 'success',
            title: 'survey berhasil disimpan!',
            text: '<?php echo $this->session->flashdata('success'); ?>',
            showConfirmButton: true,
            confirmButtonText: 'Lanjutkan',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "https://dpmptsp.jabarprov.go.id/survey_ipak";
            }
        });
    </script>
<?php endif; ?>

<?php if ($this->session->flashdata('error')): ?>
    <script type="text/javascript">
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: '<?php echo $this->session->flashdata('error'); ?>',
            showConfirmButton: true,
            timer: 3000
        });
    </script>
<?php endif; ?>
<style>
        .checkbox-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 10px; /* Jarak antar checkbox */
        }
        .border-red-500 {
            border: 2px solid red;
        }

        .checkbox-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        /* Media query for mobile view */
        @media (max-width: 768px) {
            .checkbox-grid {
                grid-template-columns: 1fr; /* Menampilkan dalam satu kolom */
            }
        }
        .public-services-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        /* Media query for mobile view */
        @media (max-width: 768px) {
            .public-services-grid {
                display: block; /* Removes grid layout on mobile */
            }
        }
            .hidden { display: none; }
        .question-box {
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .radio-options {
            display: flex;
            justify-content: space-around;
            align-items: center;
            margin-top: 20px;
        }

        .radio-options label {
            display: flex;
            flex-direction: column;
            align-items: center;
            font-weight: bold;
        }

        .radio-options input[type="radio"] {
            transform: scale(1.5);
            margin-top: 5px;
        }
        .wide-ul {
            width: 100%;
            max-width: 600px; /* Bisa diubah sesuai kebutuhan */
            margin: 0 auto;
            padding: 10px 20px;
            border-radius: 8px;
            list-style-type: decimal;
            font-size: 16px;
        }

        .wide-ul li {
            padding: 8px 0;
        }
    </style>

                <div class="small-logo">
                    <img src="<?php echo base_url('assets/images/logo-dinas.png') ?>">
                    
                    <p>Kuesioner Indeks Persepsi Anti Korupsi (IPAK) – DPMPTSP Jawa Barat</p>

                </div>
                <h6 class="text-center">Survei ini dilakukan oleh Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu (DPMPTSP) Provinsi Jawa Barat untuk mengukur Indeks Persepsi Anti Korupsi (IPAK). 
                    Tujuan survei ini adalah untuk mengetahui sejauh mana persepsi masyarakat terhadap potensi praktik korupsi dalam pelayanan publik yang diberikan oleh DPMPTSP. Jawaban Anda sangat berharga untuk meningkatkan integritas, akuntabilitas, dan transparansi pelayanan.
                    Seluruh jawaban bersifat anonim dan rahasia.
                </h6>
                    <hr style="border-top: 1px solid rgba(0, 0, 0, .50);">
   
                <div class="container mt-5">
                    <form  id="submit" class="splash-container" action="<?php echo base_url('Home/add') ?>" method="post" enctype="multipart/form-data">
                        <div id="formPage1"> 
                            <h2>BAGIAN 1 : <br><br>
                            DATA RESPONDEN Bagian ini diisi oleh data responden bagi masyarakat penerima layanan DMPTSP Jawa Barat</h2>
                            <div class="form-group">
                                <label for="p_nama">1. Nama Lengkap/Nama Perusahaan :</label>
                                <input type="text" class="form-control" name="p_nama" id="p_nama" placeholder="Masukkan Nama Anda" required>
                            </div>
                            <div class="form-group">
                                <label for="p_jabatan">2. No Telp :</label>
                                <input type="number" class="form-control" name="n_telp" id="n_telp" placeholder="Masukkan No telepon Anda" required>
                            </div>
                            <div class="form-group">
                                <label for="p_instansi">3. E-mail :</label>
                                <input type="text" class="form-control" name="email" id="email" placeholder="Masukkan E-mail Anda" required>
                            </div>
                            <div class="form-group">
                                <label for="p_lama_bekerja">4. Jenis Kelamin:</label>
                                <div class="form-group" style="display: flex; flex-wrap: wrap; gap: 10px;">
                                    <input type="radio" id="laki-laki" name="jenis_kelamin" value="Laki-Laki" required>
                                    <label for="laki-laki" style="font-weight: bold;">Laki-Laki</label><br>

                                    <input type="radio" id="perempuan" name="jenis_kelamin" value="Perempuan" required>
                                    <label for="perempuan" style="font-weight: bold;">perempuan</label><br>
                                </div>
                            </div>
                         <div class="form-group">
                                <label for="p_sektor">5. Pendidikan Terakhir :</label>
                                <div class="form-group" style="display: flex; flex-wrap: wrap; gap: 10px;">
                                    <label style="font-weight: bold;"><input type="radio" id="SD" name="pendidikan_terakhir" value="SD" required> SD</label>
                                    <label style="font-weight: bold;"><input type="radio" id="SMP" name="pendidikan_terakhir" value="SMP" required> SMP</label>
                                    <label style="font-weight: bold;"><input type="radio" id="SMA" name="pendidikan_terakhir" value="SMA" required> SMA</label>
                                    <label style="font-weight: bold;"><input type="radio" id="D3" name="pendidikan_terakhir" value="D3" required> D3</label>
                                    <label style="font-weight: bold;"><input type="radio" id="S1" name="pendidikan_terakhir" value="S1" required> S1</label>
                                    <label style="font-weight: bold;"><input type="radio" id="S2" name="pendidikan_terakhir" value="S2" required> S2</label>
                                </div>
                            </div>



                           <div class="form-group">
                                <label for="p_sektor">6. Pekerjaan :</label>
                                <div class="form-group" style="display: flex; flex-wrap: wrap; gap: 10px; align-items: center;">

                                    <input type="radio" id="asn" name="pekerjaan" value="Aparatur Sipil Negara (ASN)" required style="font-weight: bold;">
                                    <label style="font-weight: bold;" for="asn">Aparatur Sipil Negara (ASN)</label>

                                    <input type="radio" id="swasta" name="pekerjaan" value="Pegawai Swasta" required style="font-weight: bold;">
                                    <label style="font-weight: bold;" for="swasta">Pegawai Swasta</label>

                                    <input type="radio" id="wiraswasta" name="pekerjaan" value="Wiraswasta" required style="font-weight: bold;">
                                    <label style="font-weight: bold;" for="wiraswasta">Wiraswasta</label>

                                    <input type="radio" id="tnipolri" name="pekerjaan" value="TNI/POLRI" required style="font-weight: bold;">
                                    <label style="font-weight: bold;" for="tnipolri">TNI/POLRI</label>

                                    <input type="radio" id="lainnya" name="pekerjaan" value="Lainnya">
                                    <label style="font-weight: bold;" for="lainnya">Yang Lainnya</label>

                                    <textarea class="form-control mt-2" name="Pekerjaan_lainnya" placeholder="masukan jenis pekerjaan lain nya..."></textarea>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="sektor_layanan">7. Sektor/Layanan yang diajukan:</label><br>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="sektor_layanan" id="layanan1" value="Pelayanan Perizinan" required>
                                    <label style="font-weight: bold;" class="form-check-label" for="layanan1">Pelayanan Perizinan</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="sektor_layanan" id="layanan2" value="Pelayanan Pengawasan">
                                    <label style="font-weight: bold;" class="form-check-label" for="layanan2">Pelayanan Pengawasan</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="sektor_layanan" id="layanan3" value="Pelayanan Pembinaan">
                                    <label style="font-weight: bold;" class="form-check-label" for="layanan3">Pelayanan Pembinaan</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="sektor_layanan" id="layanan4" value="Pelayanan Penyelesaian Permasalahan">
                                    <label style="font-weight: bold;" class="form-check-label" for="layanan4">Pelayanan Penyelesaian Permasalahan</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="sektor_layanan" id="layanan5" value="Lainnya">
                                    <label style="font-weight: bold;" class="form-check-label" for="layanan5">Pelayanan Lainnya:</label>
                                    <input type="text" class="form-control mt-2" id="layanan_lainnya_input" name="sektor_layanan_lainnya" placeholder="Sebutkan Layanan" style="display: none;">
                                </div>
                            </div>

                            <script>
                                // Menampilkan input teks jika 'Lainnya' dipilih
                                document.querySelectorAll('input[name="sektor_layanan"]').forEach(function(elem) {
                                    elem.addEventListener('change', function() {
                                        var inputLainnya = document.getElementById('layanan_lainnya_input');
                                        if (this.value === 'Lainnya') {
                                            inputLainnya.style.display = 'block';
                                            inputLainnya.required = true;
                                        } else {
                                            inputLainnya.style.display = 'none';
                                            inputLainnya.required = false;
                                        }
                                    });
                                });
                            </script>
                            <script>
                                const textareaLainnya = document.querySelector('textarea[name="Pekerjaan_lainnya"]');
                                const radioButtons = document.querySelectorAll('input[name="pekerjaan"]');

                                textareaLainnya.style.display = 'none';

                                radioButtons.forEach(radio => {
                                    radio.addEventListener('change', function () {
                                        if (this.value === 'Lainnya') {
                                            textareaLainnya.style.display = 'block';
                                            textareaLainnya.required = true;
                                        } else {
                                            textareaLainnya.style.display = 'none';
                                            textareaLainnya.required = false;
                                        }
                                    });
                                });
                            </script>

                            <div style="text-align: center;">
                                <button type="button" id="nextButton" class="btn btn-primary mt-3">SIMPAN & LANJUT</button>
                            </div>
                        </div>


                    <!-- Halaman Kedua -->
                    <div id="formPage2" class="hidden">
                        
                        <h2>Bagian II: <br>
                            Pernyataan Persepsi (Indikator IPAK) Isilah pernyataan persetujuan anda tentang pelayanan DMPTSP sesuai dengan pilihan berikut:</h2>
                        
                        <ul class="wide-ul" style="width: auto;">
                            <li>1. Sangat Tidak Setuju (STS)</li>
                            <li>2. Tidak Setuju (TS)</li>
                            <li>3. Setuju (S)</li>
                            <li>4. Sangat Setuju (SS)</li>
                        </ul>
                        <hr style="border-top: 1px solid rgba(0, 0, 0, .50);">

                  

                        <div class="question-box">
                            <p><strong>1. Pelayanan yang dilakukan sudah sesuai dengan prosedur dan aturan yang berlaku di lingkungan DPMPTSP Jabar</strong></p>
                            <div class="radio-options">
                                <label>
                                1
                                <input type="radio"  id="PK_pertanyaan_2_1" name="PK_pertanyaan_1" value="1" required>
                                </label>
                                <label>
                                2
                                <input type="radio"  id="PK_pertanyaan_2_2" name="PK_pertanyaan_1" value="2" required>
                                </label>
                                <label>
                                3
                                <input type="radio"  id="PK_pertanyaan_2_3" name="PK_pertanyaan_1" value="3" required>
                                </label>
                                <label>
                                4
                                <input type="radio"  id="PK_pertanyaan_2_4" name="PK_pertanyaan_1" value="4" required>
                                </label>
                            </div>
                        </div>


                        <div class="question-box">
                            <p><strong>2. Petugas  tidak pernah memanfaatkan jabatannya untuk mempengaruhi proses atau hasil pelayanan yang dilakukan</strong></p>
                            <div class="radio-options">
                                <label>
                                1
                                <input type="radio" id="PK_pertanyaan_2_1" name="PK_pertanyaan_2" value="1" required>

                                </label>
                                <label>
                                2
                                <input type="radio" id="PK_pertanyaan_2_2" name="PK_pertanyaan_2" value="2">

                                </label>
                                <label>
                                3
                                <input type="radio" id="PK_pertanyaan_2_3" name="PK_pertanyaan_2" value="3">

                                </label>
                                <label>
                                4
                                <input type="radio" id="PK_pertanyaan_2_4" name="PK_pertanyaan_2" value="4">

                                </label>
                            </div>
                        </div>
                        
                        <div class="question-box">
                            <p><strong>3. Tidak Terdapat indikasi penyalahgunaan jabatan dalam proses pelayanan di linkungan DPMTSP Jabar</strong></p>
                            <div class="radio-options">
                                <label>
                                1
                                <input type="radio" id="PK_pertanyaan_3_1" name="PK_pertanyaan_3" value="1" required>

                                </label>
                                <label>
                                2
                                <input type="radio" id="PK_pertanyaan_3_2" name="PK_pertanyaan_3" value="2" required>

                                </label>
                                <label>
                                3
                                <input type="radio" id="PK_pertanyaan_3_3" name="PK_pertanyaan_3" value="3" required>

                                </label>
                                <label>
                                4
                                <input type="radio" id="PK_pertanyaan_3_4" name="PK_pertanyaan_3" value="4" required>

                                </label>
                            </div>
                        </div>
                        <div class="question-box">
                            <p><strong>4. Informasi mengenai biaya pelayanan disampaikan secara jelas dan mudah diakses oleh masyarakat</strong></p>
                            <div class="radio-options">
                                <label>
                                1
                                <input type="radio" id="PK_pertanyaan_4_1" name="PK_pertanyaan_4" value="1" required>

                                </label>
                                <label>
                                2
                                <input type="radio" id="PK_pertanyaan_4_2" name="PK_pertanyaan_4" value="2" required>

                                </label>
                                <label>
                                3
                                <input type="radio" id="PK_pertanyaan_4_3" name="PK_pertanyaan_4" value="3" required>

                                </label>
                                <label>
                                4
                                <input type="radio" id="PK_pertanyaan_4_4" name="PK_pertanyaan_4" value="4" required>

                                </label>
                            </div>
                        </div>
                        <div class="question-box">
                            <p><strong>5. Pengguna layanan tidak pernah diminta membayar biaya tambahan di luar ketentuan resmi</strong></p>
                            <div class="radio-options">
                                <label>
                                1
                                <input type="radio" id="PK_pertanyaan_5_1" name="PK_pertanyaan_5" value="1" required>

                                </label>
                                <label>
                                2
                                <input type="radio" id="PK_pertanyaan_5_2" name="PK_pertanyaan_5" value="2" required>

                                </label>
                                <label>
                                3
                                <input type="radio" id="PK_pertanyaan_5_3" name="PK_pertanyaan_5" value="3" required>

                                </label>
                                <label>
                                4
                                <input type="radio" id="PK_pertanyaan_5_4" name="PK_pertanyaan_5" value="4" required>

                                </label>
                            </div>
                        </div>
                        <div class="question-box">
                            <p><strong>6. Tidak terdapat pemberian hadiah atau imbalan kepada petugas untuk mempercepat pelayanan</strong></p>
                            <div class="radio-options">
                                <label>
                                1
                                <input type="radio" id="PK_pertanyaan_6_1" name="PK_pertanyaan_6" value="1" required>

                                </label>
                                <label>
                                2
                                <input type="radio" id="PK_pertanyaan_6_2" name="PK_pertanyaan_6" value="2" required>

                                </label>
                                <label>
                                3
                                <input type="radio" id="PK_pertanyaan_6_3" name="PK_pertanyaan_6" value="3" required>

                                </label>
                                <label>
                                4
                                <input type="radio" id="PK_pertanyaan_6_4" name="PK_pertanyaan_6" value="4" required>

                                </label>
                            </div>
                        </div>
                        <div class="question-box">
                            <p><strong>7. Setiap transaksi pelayanan selalu disertai dengan bukti pembayaran resmi.</strong></p>
                            <div class="radio-options">
                                <label>
                                1
                                <input type="radio" id="PK_pertanyaan_7_1" name="PK_pertanyaan_7" value="1" required>

                                </label>
                                <label>
                                2
                                <input type="radio" id="PK_pertanyaan_7_2" name="PK_pertanyaan_7" value="2" required>

                                </label>
                                <label>
                                3
                                <input type="radio" id="PK_pertanyaan_7_3" name="PK_pertanyaan_7" value="3" required>

                                </label>
                                <label>
                                4
                                <input type="radio" id="PK_pertanyaan_7_4" name="PK_pertanyaan_7" value="4" required>

                                </label>
                            </div>
                        </div>

                        <div class="question-box">
                            <p><strong>8. Tidak Terdapat praktik percaloan baik dari Petugas, Dinas Teknis,  atau pihak lain  yang menjanjikan kemudahan layanan dengan imbalan tertentu.</strong></p>
                            <div class="radio-options">
                                <label>
                                1
                                <input type="radio" id="PK_pertanyaan_8_1" name="PK_pertanyaan_8" value="1" required>

                                </label>
                                <label>
                                2
                                <input type="radio" id="PK_pertanyaan_8_2" name="PK_pertanyaan_8" value="2" required>

                                </label>
                                <label>
                                3
                                <input type="radio" id="PK_pertanyaan_8_3" name="PK_pertanyaan_8" value="3" required>

                                </label>
                                <label>
                                4
                                <input type="radio" id="PK_pertanyaan_8_4" name="PK_pertanyaan_8" value="4" required>

                                </label>
                            </div>
                        </div>
                        <div class="question-box">
                            <p><strong>9. Tidak Terdapat laporan atau indikasi adanya tindakan curang dalam penyelenggaraan pelayanan publik.</strong></p>
                            <div class="radio-options">
                                <label>
                                1
                                <input type="radio" id="PK_pertanyaan_9_1" name="PK_pertanyaan_9" value="1" required>

                                </label>
                                <label>
                                2
                                <input type="radio" id="PK_pertanyaan_9_2" name="PK_pertanyaan_9" value="2" required>

                                </label>
                                <label>
                                3
                                <input type="radio" id="PK_pertanyaan_9_3" name="PK_pertanyaan_9" value="3" required>

                                </label>
                                <label>
                                4
                                <input type="radio" id="PK_pertanyaan_9_4" name="PK_pertanyaan_9" value="4" required>

                                </label>
                            </div>
                        </div>
                        <div class="question-box">
                            <p><strong>10. Tidak terdapat  transaksi rahasia atau tidak tercatat yang terjadi di DPMPTSP Jabar</strong></p>
                            <div class="radio-options">
                                <label>
                                1
                                <input type="radio" id="PK_pertanyaan_10_1" name="PK_pertanyaan_10" value="1" required>

                                </label>
                                <label>
                                2
                                <input type="radio" id="PK_pertanyaan_10_2" name="PK_pertanyaan_10" value="2" required>

                                </label>
                                <label>
                                3
                                <input type="radio" id="PK_pertanyaan_10_3" name="PK_pertanyaan_10" value="3" required>

                                </label>
                                <label>
                                4
                                <input type="radio" id="PK_pertanyaan_10_4" name="PK_pertanyaan_10" value="4" required>

                                </label>
                            </div>
                        </div>

                           
                        <div style="display: flex; justify-content: center; gap: 10px;">
                            <button type="button" id="backButton2" class="btn btn-secondary">KEMBALI</button>
                            <button type="button" id="submitButton" class="btn btn-primary">SIMPAN</button>
                        </div>

                    </form>
               
                    </div>
                </div>

           

  <script src='https://www.google.com/recaptcha/api.js'></script>                            
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<!-- <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let radioButtons = document.getElementsByName("PK_pertanyaan_b_II_5");
            let keteranganDiv = document.getElementById("keterangan");

            radioButtons.forEach(radio => {
                radio.addEventListener("change", function() {
                    if (this.value === "Dinas Teknis") {
                        keteranganDiv.style.display = "block";
                    } else {
                        keteranganDiv.style.display = "none";
                    }
                });
            });
        });
    </script>
<script>
function validatePage(pageId, isSubmit = false) {
    const inputs = document.querySelectorAll(`#${pageId} input, #${pageId} textarea, #${pageId} select`);
    console.log(inputs);
    
    let isValid = true;
    const checkedRadioGroups = new Set(); // Untuk menangani radio button agar tidak berulang

    inputs.forEach(input => {
        if (input.name === "PK_pertanyaan_1_lainnya" || input.id === "keterangan_dinas_teknis") return; // Lewati input ini

        let isEmpty = false;
        let label = document.querySelector(`label[for="${input.id}"]`);

        if (input.type === "radio") {
            if (!checkedRadioGroups.has(input.name)) {
                const group = document.querySelectorAll(`input[name="${input.name}"]:checked`);
                isEmpty = group.length === 0;
                checkedRadioGroups.add(input.name);
            } else {
                return; // Agar tidak muncul error ganda dalam satu grup radio
            }
        } else if (input.type === "checkbox") {
            const group = document.querySelectorAll(`input[name="${input.name}"]:checked`);
            isEmpty = group.length === 0;
        } else {
            isEmpty = input.value.trim() === "";
        }

        if (!label && input.type !== "radio") return; // Jika tidak ada label, skip kecuali radio

        let errorMessage = document.getElementById(`error-${input.name}`);
        if (!errorMessage) {
            errorMessage = document.createElement("small");
            errorMessage.id = `error-${input.name}`;
            errorMessage.style.color = "red";
            errorMessage.style.display = "none";

            if (input.type === "radio") {
                const firstRadio = document.querySelector(`input[name="${input.name}"]`);
                firstRadio.closest("div").insertAdjacentElement("beforebegin", errorMessage); // Pesan error di atas grup radio
            } else {
                label.insertAdjacentElement("beforebegin", errorMessage); // Pesan error di atas label
            }
        }

        if (isEmpty) {
            // input.classList.add("border-red-500");
            if (isSubmit) {
                errorMessage.textContent = "Wajib diisi!";
                errorMessage.style.display = "block";
            }
            isValid = false;
        } else {
            input.classList.remove("border-red-500");
            errorMessage.style.display = "none";
        }
    });

    return isValid;
}

function addValidationListeners(pageId) {
    const inputs = document.querySelectorAll(`#${pageId} input, #${pageId} textarea, #${pageId} select`);
    inputs.forEach(input => {
        if (input.name === "PK_pertanyaan_1_lainnya" || input.id === "keterangan_dinas_teknis") return;

        input.addEventListener("input", () => validatePage(pageId, false));
        input.addEventListener("change", () => validatePage(pageId, false));
    });
}

document.addEventListener("DOMContentLoaded", function() {
    const nextButton = document.getElementById("nextButton");
    const backButton1 = document.getElementById("backButton1");
    const nextButton2 = document.getElementById("nextButton2");
    const backButton2 = document.getElementById("backButton2");
    const submitButton = document.getElementById("submitButton");

    if (nextButton) {
        nextButton.addEventListener("click", function() {
            if (validatePage("formPage1", true)) {
                document.getElementById("formPage1").classList.add("hidden");
                document.getElementById("formPage2").classList.remove("hidden");
            }
        });
    }

    if (backButton1) {
        backButton1.addEventListener("click", function() {
            document.getElementById("formPage2").classList.add("hidden");
            document.getElementById("formPage1").classList.remove("hidden");
        });
    }

    if (nextButton2) {
        nextButton2.addEventListener("click", function() {
            if (validatePage("formPage2", true)) {
                document.getElementById("formPage2").classList.add("hidden");
                document.getElementById("formPage3").classList.remove("hidden");
            }
        });
    }
    if (backButton2) {
        backButton2.addEventListener("click", function() {
            // Ubah dari formPage3 ke formPage1 langsung (lewati formPage2)
            document.getElementById("formPage2").classList.add("hidden");
            document.getElementById("formPage1").classList.remove("hidden");
        });
    }


    if (submitButton) {
        submitButton.addEventListener("click", function() {
            if (validatePage("formPage2", true)) {
                document.forms["submit"].submit(); // Menggunakan cara lebih aman
            }
        });
    }

    // Jalankan validasi awal tanpa menampilkan error
    validatePage("formPage1", false);
    validatePage("formPage2", false);
    validatePage("formPage3", false);

    // Tambahkan event listener untuk input di setiap halaman
    addValidationListeners("formPage1");
    addValidationListeners("formPage2");
    addValidationListeners("formPage3");
});



</script>
                  
<?php $this->load->view("partial/foot.php") ?>