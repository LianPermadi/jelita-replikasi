<!DOCTYPE html>
<html>
<head>
    <title>Data Mobil</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
	<!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Data Mobil</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="https://dpmptsp.jabarprov.go.id/pengawas_mobil/">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact</a>
                </li>
            </ul>
        </div>
    </nav>
	<br>
	<br>
	<br>
    <div class="container">
        <table class="table table-bordered" id="data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Mobil</th>
                    <th>Plat</th>
                    <th>Tahun</th>
                    <th>Jenis</th>
                    <th>Bahan Bakar</th>
                    <th>Kapasitas</th>
                    <th>Status</th>
                    <th>Kondisi</th>
                    <th>Peminjam</th>
                    <th>Tanggal Pakai</th>
                    <th>Foto</th>
                    <th>On/Off</th>
                    <th>Pengawas</th>
                    <th>action</th>
                </tr>
            </thead>
            <tbody id="table-body">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // Fungsi untuk memuat data dan menambahkannya ke tabel

        function loadData() {
            $.ajax({
                url: 'data.php', // Ganti 'data.php' dengan nama file PHP Anda
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    const tableBody = $('#table-body');
                    tableBody.empty(); // Mengosongkan elemen sebelum menambahkan data baru
					let nomorUrut = 1; // Variabel untuk nomor urut
                    data.result.forEach(row => {
                        // Tentukan teks status sesuai dengan kondisi
                        const kondisi = row.kondisi === '0' ? 'Mobil dalam perbaikan' : 'Mobil tersedia';
                        const aktif = row.on_off === '1' ? 'Mobil Aktif' : 'Tidak Aktif';
                        const keluar_masuk = row.pengawas === '1' ? 'Mobil Keluar' : 'Mobil Di kantor';
						const gambar = `<img src="https://dpmptsp.jabarprov.go.id/jelita/backoffice/www/modules/peminjamanmobil/assets/img/${row.foto}" alt="${row.nama_mobil}" width="50px" />`;
						const button = row.pengawas === '0' ? `<a href='' title='Mobil Sudah Keluar?'><img src="https://cdn.pixabay.com/photo/2016/06/15/16/47/auto-1459346_1280.png" width="50px"  /></a>` : `<a href='' title='Mobil Sudah Kembali?'><img src="https://cdn.icon-icons.com/icons2/67/PNG/512/car_13260.png" width="100" /></a>`;

                        const newRow = `
                            <tr>
								<td>${nomorUrut}</td>
                                <td>${row.nama_mobil}</td>
                                <td>${row.plat}</td>
                                <td>${row.tahun}</td>
                                <td>${row.jenis}</td>
                                <td>${row.bahan_bakar}</td>
                                <td>${row.kapasitas}</td>
                                <td>${row.status}</td>
                                <td>${kondisi}</td> <!-- Menampilkan status sesuai kondisi -->
                                <td>${row.peminjam}</td>
                                <td>${row.date}</td>
                                <td>${gambar}</td>
                                <td>${aktif}</td>
                                <td>${keluar_masuk}</td>
                                <td>${button}</td>
                            </tr>
                        `;
                        tableBody.append(newRow);
                        nomorUrut++; // Increment nomor urut
                    });
                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        }

        // Memuat data saat halaman pertama kali dimuat
        loadData();
        setInterval(loadData, 3000); // Ubah angka ini sesuai dengan kebutuhan Anda

        // Anda dapat memanggil fungsi loadData kapan pun Anda ingin memperbarui data
    });
</script>
            </tbody>
        </table>
    </div>

</body>
</html>