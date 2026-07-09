<div id="content">
  <div class="post">
    <div class="title">
      <?php echo $this->lib_date->view_title($page_name); 
      $loket = $this->m_nib->get_user_loket($iduser); ?>
    </div>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Realtime</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <!-- Link CDN untuk Bootstrap CSS -->
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEJv9X4X4b+5p0m6r6ak9t4ZQJH9WzQH5Bf71dU6z6F6cB5OBljDfdz/cdn/css" crossorigin="anonymous"> -->

<!-- Script CDN untuk Bootstrap JavaScript (opsional, jika diperlukan untuk fitur Bootstrap tertentu) -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0G4DYG9K5nPtnZ37XyjoX2gdt4QQx6fLXly/8fLklr+Vbx7Z" crossorigin="anonymous"></script> -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.responsivevoice.org/responsivevoice.js?key=KQ3jY54s"></script>


    <style>


        /* Gaya umum untuk input dan dropdown */
.input-wrc {
    width: 100%;
    padding: 8px 12px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
    color: #333;
    background-color: #f9f9f9;
    box-sizing: border-box;
    transition: border-color 0.3s, box-shadow 0.3s;
}

/* Hover dan fokus untuk input dan dropdown */
.input-wrc:focus {
    border-color: #007bff; /* Warna biru */
    box-shadow: 0 0 4px rgba(0, 123, 255, 0.5);
    outline: none;
}

/* Dropdown readonly tetap tampil seperti aktif */
.input-wrc[readonly] {
    background-color: #e9ecef; /* Warna abu-abu terang */
    cursor: not-allowed;
    color: #6c757d; /* Teks abu-abu */
}

/* Gaya untuk tombol submit */
.button-wrc {
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    background-color: #007bff; /* Warna biru */
    color: #fff;
    font-size: 14px;
    cursor: pointer;
    transition: background-color 0.3s, transform 0.2s;
}

.button-wrc:hover {
    background-color: #0056b3; /* Warna biru lebih gelap */
    transform: scale(1.05); /* Efek zoom */
}

.button-wrc:active {
    background-color: #004085; /* Warna biru gelap saat aktif */
    transform: scale(0.98); /* Efek klik */
}

/* Tabel tata letak */
fieldset {
    border: 2px solid #007bff;
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 20px;
    background-color: #fff;
}

legend {
    font-weight: bold;
    font-size: 16px;
    color: #007bff;
}

table {
    width: 100%;
    border-spacing: 10px;
}

td {
    vertical-align: top;
}

/* Responsif */
@media (max-width: 768px) {
    .input-wrc,
    .button-wrc {
        font-size: 12px;
    }

    table {
        display: block;
    }

    td {
        display: block;
        width: 100%;
    }
}
/* Gaya tombol utama */
.button-wrc {
    background-color: #007bff;
    color: white;
    padding: 10px 20px;
    border: none;
    cursor: pointer;
    border-radius: 5px;
}

/* Gaya dropdown */
.dropdown {
    position: relative;
    display: inline-block;
}

/* Konten dropdown */
.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
    z-index: 1;
    border-radius: 5px;
}

/* Link dalam dropdown */
.dropdown-content a {
    color: black;
    padding: 10px 15px;
    text-decoration: none;
    display: block;
}

/* Hover efek untuk link */
.dropdown-content a:hover {
    background-color: #f1f1f1;
}

/* Tampilkan dropdown ketika aktif */
.show {
    display: block;
}
    </style>
</head>
<body>
    <div style="padding : 10px">
<fieldset>
    <legend>Filter Data Tanggal Input NIB</legend>
    <?php echo form_open('pengembangan/gpt'); ?>
    <table>
        <tr>
            <td>
                <?php 
                echo 'Tanggal Pakai Awal : ' . form_input([
                    'id' => 'tgla', 
                    'name' => 'tgla',
                    'type' => 'date',
                    'value' => isset($tgla) ? $tgla : '',
                    'class' => 'input-wrc monbulan'
                ]); 
                ?>
            </td>
            <td style="padding: 0 20px;"></td>
            <td>
                <?php 
                echo 'Tanggal Pakai Akhir : ' . form_input([
                    'id' => 'tglb', 
                    'name' => 'tglb',
                    'type' => 'date',
                    'value' => isset($tglb) ? $tglb : '',
                    'class' => 'input-wrc monbulan'
                ]); 
                ?>
            </td>
        </tr>
        <tr>
            <td style="padding-top: 10px;" colspan="3">
                <?php 
                    if ($this->All) {
                        // Jika $this->All bernilai true, tampilkan form dropdown untuk memilih layanan
                        $layanan_gpt_options = $this->m_pengembangan->layanan_gpt();
                        $selected_layanan_gpt = isset($layanan_gpt) ? $layanan_gpt : 'gpt1'; // Nilai default
                        echo 'Pilih Layanan GPT: ';
                        echo form_dropdown(
                            'layanan_gpt',
                            $layanan_gpt_options,
                            $selected_layanan_gpt,
                            'class="input-wrc monbulan" id="layanan_gpt"'
                        ); 
                    } else {
                        // Jika $this->All bernilai false, sembunyikan dropdown dan set input hidden dengan nilai akun
                        if ($this->session->userdata('level')) {
                            $selected_layanan_gpt = $this->session->userdata('level'); // Nilai default dari sesi
                            if ($selected_layanan_gpt == 0) {
                                // Tampilkan input hidden dan pesan info
                                echo form_hidden('layanan_gpt', ''); // Input hidden dengan htmlspecialchars
                                echo '<p>Anda Petugas dari Loket: ';
                                echo '<span style="color: green">';
                                echo 'Admin';
                                echo '</span></p>';
                            }
                            // Tampilkan input hidden dan pesan info
                            echo form_hidden('layanan_gpt', htmlspecialchars($selected_layanan_gpt)); // Input hidden dengan htmlspecialchars
                            echo '<p>Anda Petugas dari Loket: ';
                            echo '<span style="color: green">';
                            echo htmlspecialchars($this->m_pengembangan->get_layanan_gpt($selected_layanan_gpt));
                            echo '</span></p>';
                        } else {
                            $iduser = isset($iduser) ? $iduser : 0; // Defaultkan $iduser jika tidak terdefinisi
                            $selected_layanan_gpt = $this->m_nib->get_user_loket($iduser); // Nilai default
                            // Tampilkan input hidden dan pesan info
                            echo form_hidden('layanan_gpt', htmlspecialchars($selected_layanan_gpt)); // Input hidden dengan htmlspecialchars
                            echo '<p>Anda Petugas dari Loket: ';
                            echo '<span style="color: green">';
                            echo htmlspecialchars($this->m_pengembangan->get_layanan_gpt($selected_layanan_gpt));
                            echo '</span></p>';
                        }

                    }
                ?>
                <?php 
                // var_dump($layanan_gpt_options);die(); 
                ?>
            </td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: center; padding-top: 20px;">
                <?php
                // Tombol submit
                // echo form_submit([
                //     'id' => 'submit_filter',
                //     'name' => 'submit_filter',
                //     'type' => 'submit',
                //     'value' => 'Cari Data',
                //     'class' => 'button-wrc'
                // ]);
                ?>
                <?php if($this->session->userdata('id_auth') == 680){ ?>
                    <a href="gpt/akun_antrian"><button type="button" class="button-wrc">Refresh Akun</button></a>
                    <div class="dropdown">
                        <button type="button" class="button-wrc" onclick="toggleDropdown()">Refresh Antrian</button>
                        <div class="dropdown-content" id="dropdownMenu">
                            <?php 
                            // Loop untuk menampilkan opsi dropdown
                            foreach ($layanan_gpt_options as $key => $row) { 
                                if (!empty($row)) { // Pastikan data tidak kosong
                            ?>
                                <a href="#" onclick="refreshAkun('<?php echo htmlspecialchars($row); ?>', 'https://dpmptsp.jabarprov.go.id/jelita/backoffice/pengembangan/gpt/cek_antrian/<?php echo $key; ?>')">
                                    <?php echo htmlspecialchars($row); ?>
                                </a>
                            <?php 
                                }
                            } 
                            ?>
                        </div>
                    </div>
                <?php } ?>
            </td>
        </tr>
    </table>
    <?php echo form_close(); ?>
</fieldset>


    <h1>Data Realtime</h1>
<table id="dataGPT" class="display">
    <thead>
        <tr>
            <th>No</th>
            <th>KBLI<br>No. WhatsApp<br>Tanggal Input</th>
            <th>Nama<br>NIK<br>Email</th>
            <th>Petugas KBLI<br>Petugas NIB<br>Lokasi Event</th>
            <th>Petugas Pengubah Data<br>Tanggal<br>Layanan</th>
            <th>No Antri</th>
            <th>Panggil</th>
            <th>Status panggil</th>
            <th>Foto KTP</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <!-- Data akan diisi melalui AJAX -->
    </tbody>
</table>

<style>
    /* Tampilan Tabel */
    #dataGPT {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
        font-size: 16px;
        font-family: Arial, sans-serif;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        border-radius: 8px;
        overflow: hidden;
    }

    /* Header */
    #dataGPT thead tr {
        background: linear-gradient(45deg, #4caf50, #2196f3);
        color: white;
        text-align: center;
        font-weight: bold;
    }

    /* Isi Tabel */
    #dataGPT tbody tr {
        border-bottom: 1px solid #dddddd;
    }

    #dataGPT tbody tr:nth-of-type(even) {
        background-color: #f9f9f9;
    }

    #dataGPT tbody tr:hover {
        background-color: #f1f1f1;
        cursor: pointer;
    }

    #dataGPT td, #dataGPT th {
        padding: 12px 15px;
        text-align: center;
    }

    /* Efek Gambar */
    #dataGPT img {
        border-radius: 4px;
        transition: transform 0.2s ease;
    }

    #dataGPT img:hover {
        transform: scale(1.2);
    }

    /* Highlight Header */
    #dataGPT thead th {
        border-bottom: 2px solid white;
    }
    





/* Modal Styles */
.modal {
    display: none; /* Default hidden */
    position: fixed;
    z-index: 1; /* Ensure modal is on top */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    background-color: rgba(0, 0, 0, 0.7); /* Semi-transparent background */
    overflow: auto; /* Scrollable if content is too large */
    padding: 20px; /* Padding for modal */
}

/* Modal content */
.modal-content {
    position: relative;
    margin: auto;
    background-color: #fff;
    padding: 10px;
    border-radius: 8px;
    width: 90%; /* Ensure modal width is 90% of the screen width */
    max-width: 1000px; /* Limit max width */
    height: 80%; /* 80% height of the screen */
    overflow-y: auto; /* Enable scrolling for large content */
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

/* Modal header */
.modal-header {
    position: absolute;
    top: 20px;
    right: 20px;
    color: #fff;
    font-size: 24px;
    cursor: pointer;
    background-color: transparent;
    border: none;
}

/* Image inside modal */
#modalImage {
    max-width: 100%; /* Make sure image fits inside the modal */
    max-height: 70vh; /* Image height limit to 70% of the screen */
    object-fit: contain; /* Maintain image aspect ratio */
    border-radius: 8px;
    margin-bottom: 15px;
}

/* Information styles inside modal */
#modalInfo {
    font-family: Arial, sans-serif;
    font-size: 16px;
    color: #333;
    margin-top: 15px;
    text-align: center;
    width: 100%; /* Make sure text doesn't overflow */
    word-wrap: break-word; /* Break long words if needed */
}

/* Close button */
.close {
    font-size: 3rem;
    color: #fff;
    background: transparent;
    border: none;
    cursor: pointer;
}

.close:focus {
    outline: none;
}

/* Button Styles */
button {
    border: none;
    background: none;
    cursor: pointer;
}

/* Responsive Design for Smaller Screens */
@media screen and (max-width: 480px) {
    .modal-content {
        width: 95%; /* Make modal content narrower on smaller screens */
        height: 80%;
    }

    #modalImage {
        max-width: 100%; /* Image fits on small screens */
    }

    .close {
        font-size: 2.5rem; /* Smaller close button */
    }
}

@media screen and (max-width: 720px) {
    .modal-content {
        width: 90%; /* Adjust modal content width for medium screens */
    }

    #modalImage {
        max-height: 60vh; /* Image height adjusted for smaller screens */
    }
}

@media screen and (min-width: 1080px) {
    .modal-content {
        width: 70%; /* Slightly narrower modal on larger screens */
        height: 70%;
    }

    #modalImage {
        max-height: 60vh; /* Image height limit for larger screens */
    }
}

@media screen and (min-width: 2000px) {
    .modal-content {
        width: 50%; /* Modal will be even narrower on very large screens */
        height: 60%; /* Decrease height for better proportion */
    }

    #modalImage {
        max-height: 50vh; /* Limit the height of the image */
    }
}



</style>
</div>
<!-- Modal untuk menampilkan gambar besar -->
<div id="imageModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <img id="modalImage" class="modal-image" src="" alt="Gambar KTP">
        <p id="modalInfo"></p>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script>
function toggleDropdown() {
    const dropdownMenu = document.getElementById("dropdownMenu");
    dropdownMenu.classList.toggle("show");
}

function refreshAkun(akunName, link) {
    alert("Akun " + akunName + " di-refresh!");
    // Mengarahkan ke link
    window.location.href = link;
}

// Menutup dropdown jika klik di luar area dropdown
window.onclick = function (event) {
    if (!event.target.matches('.button-wrc')) {
        const dropdowns = document.getElementsByClassName("dropdown-content");
        for (let i = 0; i < dropdowns.length; i++) {
            const openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        }
    }
};



$(document).ready(function () {
    const table = $('#dataGPT').DataTable({
        "paging": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "stateSave": true,  // Menyimpan status pagination dan pencarian
    });
function loadData() {
    const tgla = $('#tgla').val(); // Ambil nilai dari input tanggal awal
    const tglb = $('#tglb').val(); // Ambil nilai dari input tanggal akhir
    let layanan_gpt;

    // Cek apakah dropdown layanan_gpt ada (untuk kondisi $this->All == true)
    if ($('#layanan_gpt').length > 0) {
        layanan_gpt = $('#layanan_gpt').val(); // Ambil nilai dari dropdown jika ada
    } else {
        // Jika $this->All == false, layanan_gpt akan diambil dari input hidden
        layanan_gpt = $('input[name="layanan_gpt"]').val(); // Ambil nilai dari input hidden
    }

    $.ajax({
        url: `https://dpmptsp.jabarprov.go.id/jelita/backoffice/pengembangan/gpt/fetch_data/${tgla}/${tglb}/${layanan_gpt}`, // Endpoint CodeIgniter
        method: 'GET', // Ubah metode ke GET
        dataType: 'json',
        data: {
            tgla: tgla,
            tglb: tglb
        },
        success: function (data) {
            // Simpan halaman aktif saat ini
            const currentPage = table.page();

            table.clear(); // Kosongkan data tabel
data.forEach((item, index) => {
    const imageSrc = item.foto_ktp ? item.foto_ktp : ''; // Jika foto_ktp kosong, set ke string kosong
    console.log(item.status_panggil);
    let panggilButton;

    let status_text;
    if (item.status_panggil === '1' && item.no_antri_tidak_langsung === '1') {
        panggilButton = `<button onclick="if (confirm('Apakah Anda yakin ingin membatalkan panggilan untuk No. Antri: ${item.no_antri}?')) updatePanggilStatus(${item.id}, ${item.no_antri}, ${item.nik}, 0);" 
                            style="border: none; background: none; padding: 0;" 
                            title="Batal Panggil">
                        <img src="https://cdn.pixabay.com/photo/2014/04/02/10/44/cross-mark-304374_640.png" 
                            alt="Batal Panggil" 
                            width="25px">
                    </button><br>`;
        status_text = 'red';
    } else if (item.status_panggil === '0' && item.no_antri_tidak_langsung === '0') {
        panggilButton = `<button onclick="if (confirm('Apakah Anda yakin ingin memanggil Monitor untuk No. Antri: ${item.no_antri}?')) updatePanggilStatus(${item.id}, ${item.no_antri}, ${item.nik}, 2);" 
                            style="border: none; background: none; padding: 0;" 
                            title="Panggil Monitor">
                        <img src="https://png.pngtree.com/png-clipart/20230510/original/pngtree-microphone-icon-illustration-cartoon-design-png-image_9155706.png" 
                            alt="Panggil Monitor" 
                            width="50px">
                    </button><br>`;
        status_text = 'blue';
    } else if (item.status_panggil === '0' && item.no_antri_tidak_langsung === '1') {
        panggilButton = `<span style="color:red;"> Masih Berada di loket lain </span>`;
        status_text = 'green';
    } else if (item.status_panggil === '1' && item.no_antri_tidak_langsung === '0') {
        panggilButton = `<button onclick="if (confirm('Apakah Anda yakin ingin membatalkan panggilan untuk No. Antri: ${item.no_antri}?')) updatePanggilStatus(${item.id}, ${item.no_antri}, ${item.nik}, 0);" 
                            style="border: none; background: none; padding: 0;" 
                            title="Batal Panggil">
                        <img src="https://cdn.pixabay.com/photo/2014/04/02/10/44/cross-mark-304374_640.png" 
                            alt="Batal Panggil" 
                            width="25px">
                    </button><br>`;
        status_text = 'green';
    } else {
        panggilButton = `<span style="color:blue;"> Sudah tidak memiliki urusan apapun </span>`;
        status_text = 'black';
    }

    let status_panggil;
    if (item.status_panggil === '0') {
        status_panggil = '<span style="color:green">Siap di panggil</span>';
    } else if (item.status_panggil === '1') {
        status_panggil = '<span style="color:red">Sedang di loket yang lain</span>';
    } else if (item.status_panggil === '2') {
        status_panggil = '<span style="color:blue">Sudah Selesai</span>';
    }

    table.row.add([
        index + 1, // Nomor urut
        `<span style="color:${status_text};">${item.kbli}<br>${item.whatsapp}<br>${item.tanggal_input}</span>`, // Data KBLI, WhatsApp, dan Tanggal Input
        `<span style="color:${status_text};">${item.nama}<br>${item.nik}<br>${item.email}</span>`, // Data Nama, NIK, dan Email
        `<span style="color:${status_text};">${item.petugas_kbli}<br>${item.petugas_nib}<br>${item.lokasi_event}</span>`, // Data Petugas dan Lokasi Event
        `<span style="color:${status_text};">${item.pengubah_data}<br>${item.tanggal}<br>${item.layanan}</span>`, // Data Pengubah, Tanggal, dan Layanan
        `<span style="color:${status_text};">${item.no_antri}</span>`,
        `${panggilButton}
        <button onclick="if (confirm('Apakah Anda yakin ingin memanggil Manual untuk No. Antri: ${item.no_antri}?')) speakText('${item.no_antri}', '${item.layanan}');" 
                    class="btn btn-outline-primary btn-sm bg-transparent" 
                    style="border: none; background: none; padding: 0;"
                    title="Panggil Manual">
                <img src="https://static.vecteezy.com/system/resources/previews/028/766/358/original/google-mic-microphone-icon-symbol-free-png.png" 
                     alt="Mic Icon" 
                     width="25px">
            </button><br>`,
        `${status_panggil}`,
        imageSrc ? `<img src="${imageSrc}" alt="Foto KTP" class="img-fluid" style="width: 80px;" onclick="showImageModal('${imageSrc}', '${item.whatsapp}', '${item.nik}', '${item.nama}', '${item.email}', ${item.no_antri});">` : ``,
        `<a href="javascript:void(0);" onclick="if (confirm('Apakah Anda yakin ingin Selesaikan data No. Antri: ${item.no_antri}?')) editStatus(${item.id});">
            <img src="https://banner2.cleanpng.com/20180403/lxq/avhl7l707.webp" alt="Edit" width="20px">
        </a>
        <a href="/jelita/backoffice/pengembangan/nib/qrcode_views/${item.id}">
            <img src="https://iconape.com/wp-content/png_logo_vector/qr-code-logo.png" alt="QR Code" width="20px">
        </a>
        ${item.hasDeletePermission && item.hasDeletePermission === '1' ? `
            <a href="/jelita/backoffice/pengembangan/gpt/hapus_nib/${item.id}" 
                onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                <img src="https://cdn-icons-png.flaticon.com/512/860/860778.png" alt="Hapus Data" width="20px" title="Hapus Data">
            </a><br>${item.id}` : ''}</span>`
    ]);
});




            table.draw(false); // Render ulang tabel tanpa mengubah halaman aktif
            table.page(currentPage).draw(false); // Kembali ke halaman aktif sebelumnya
        },
        error: function (xhr, status, error) {
            console.error('Error:', error);
        }
    });
}

// Panggil fungsi `loadData` saat halaman dimuat dan setiap 1 detik
loadData();
setInterval(loadData, 500);

// Tambahkan event listener untuk memuat data ketika tanggal berubah
$('#tgla, #tglb').on('change', loadData);

});

// Fungsi untuk mengubah status menggunakan AJAX
function editStatus(itemId) {
    $.ajax({
        url: 'https://dpmptsp.jabarprov.go.id/jelita/backoffice/pengembangan/gpt/selesai_panggil', // Ganti dengan URL endpoint yang sesuai
        type: 'POST',
        data: {
            id: itemId,
            status: '2', // Status baru yang diinginkan (misalnya, bisa 1, 0, dll.)
        },
        success: function(response) {
            if (response.success) {
                // Update status di halaman tanpa refresh
                $(`#status_${itemId}`).text('Status Baru'); // Ganti dengan status yang sesuai
                // alert('Status berhasil diperbarui '+response.message);
            } else {
                // alert('Status berhasil diperbarui '+response.message);
            }
        },
        error: function() {
            alert('Terjadi kesalahan saat memperbarui status '+response.message);
        }
    });
}
// Fungsi untuk menampilkan modal dengan gambar dan informasi
function showImageModal(imageSrc, whatsapp, nik, nama, email, no_antri) {
    const modal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');
    const modalInfo = document.getElementById('modalInfo');

    modal.style.display = "block"; // Tampilkan modal
    modalImage.src = imageSrc; // Set gambar modal

    // Set informasi modal dengan HTML yang lebih rapi
    modalInfo.innerHTML = `
        <div><strong>No Handphone:</strong> ${whatsapp}</div>
        <div><strong>NIK:</strong> ${nik}</div>
        <div><strong>Nama:</strong> ${nama}</div>
        <div><strong>Email:</strong> ${email}</div>
        <div><strong>No Antri:</strong> ${no_antri}</div>
    `;
}

// Fungsi untuk menutup modal
function closeModal(event) {
    const modal = document.getElementById('imageModal');
    if (event.target === modal) {  // Memeriksa apakah klik terjadi di luar modal-content
        modal.style.display = "none";  // Sembunyikan modal
    }
}



// Menutup modal saat klik di luar area gambar (latar belakang modal)
window.onclick = function(event) {
    const modal = document.getElementById('imageModal');
    if (event.target === modal) {
        modal.style.display = "none";
    }
}
function updatePanggilStatus(id, noAntri, nik, status) {
    const tgla = $('#tgla').val(); // Nilai tanggal awal
    const tglb = $('#tglb').val(); // Nilai tanggal akhir

    // Menggunakan template literal dengan benar pada URL
    const url = `https://dpmptsp.jabarprov.go.id/jelita/backoffice/pengembangan/gpt/${status === 0 ? 'batal_mic' : 'status_mic'}/${id}/${noAntri}/${nik}/${status}`;

    console.log(url); // Log untuk memastikan URL yang dibangun benar

    // Pastikan data yang dikirim melalui AJAX sudah tepat
    $.ajax({
        url: url,
        method: 'POST',
        data: {
            tgla: tgla,
            tglb: tglb
        },
        success: function (response) {
            // Menggunakan template literal yang benar dalam alert
            // alert(`${status === 0 ? 'Panggilan Dibatalkan' : 'Panggilan Dilakukan'}`);
            // Reload data tabel untuk merefleksikan perubahan
            loadData();
        },
        error: function (xhr, status, error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan. Silakan coba lagi.');
        }
    });
}

function speakText(no_antri, layanan) {
    // Pastikan teks layanan tidak kosong
    const layananText = layanan ? layanan : "tidak diketahui";
    // Pemanggilan fungsi speak dari ResponsiveVoice
    responsiveVoice.speak(
        `Nomor Antrian, ${no_antri}, menuju, loket, ${layananText}`, 
        "Indonesian Female"
    );
}
</script>

</body>
</html>
    </div>
    <br style="clear: both;" />
</div>
