    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Table</span> Produk</h4>

            <?php
            $alert = $this->session->flashdata("sukses");
            if (!empty($alert)) {
            ?>
                <br>
                <div class="alert alert-success alert-dismissible" role="alert">
                    <?php echo $alert; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php } ?>

            <?php
            $alert = $this->session->flashdata("gagal");
            if (!empty($alert)) {
            ?>
                <br>
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <?php echo $alert; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php } ?>

            <a href="https://dpmptsp.jabarprov.go.id/jelita/main/cms/tambah_produk" class="btn btn-primary">Tambah Produk</a>
            <hr class="my-1" />

            <div class="mt-5 mb-5">
                <h2>Daftar Produk</h2>
                <div id="data-container">
                <table class="table table-hover" id="data-table">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>NAMA</th>
                            <th>REVIEWS</th>
                            <th>HARGA</th>
                            <th>KETERANGAN</th>
                            <th>AVAILABILITY</th>
                            <th>SHIPPING</th>
                            <th>WEIGHT</th>
                            <th>DESKRIPSI</th>
                            <th>FOTO</th>
                            <th>KATEGORI</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    </thead>
                    <tbody></tbody>
                </table>
                </div>
                <div id="pagination">
                <button id="prev-page" class="btn btn-primary">Previous</button>
                <button id="next-page" class="btn btn-primary">Next</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Sertakan jQuery dan DataTables -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

    <script>
document.addEventListener('DOMContentLoaded', function () {
    const data = <?php echo json_encode($produk); ?>;
    const kategori = <?php echo json_encode($kategori); ?>;
    console.log(kategori.id);
    const itemsPerPage = 10; // Ubah sesuai jumlah item per halaman yang Anda inginkan
    let currentPage = 1;

    const renderData = () => {
        const dataContainer = document.getElementById('data-container');
        const tableBody = dataContainer.querySelector('tbody');
        tableBody.innerHTML = '';

        const startIndex = (currentPage - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        const paginatedData = data.slice(startIndex, endIndex);
        const paginatedKategori = kategori.slice();

        paginatedData.forEach((item, index) => {
            const fotoArray = item.foto.split('^');
            let fotoHTML = '';
            let datakategori = '';

            fotoArray.forEach(function (foto, key) {
                if (foto && foto !== null) {
                    fotoHTML = `<img src="https://dpmptsp.jabarprov.go.id/jelita/assets/mitrakasih/img/product/details/${foto}" style="width:100px">`;
                }
            });

            console.log(item.kategori);
            paginatedKategori.forEach((kategori) => {
                console.log(kategori.id);
                console.log(item.kategori + '===' + kategori.id);
                if(item.kategori === kategori.id){
                datakategori = kategori.kategori;
                console.log(datakategori);
                }
            })
            const row = `
                <tr>
                    <td>${startIndex + index + 1}</td>
                    <td>${item.nama}</td>
                    <td class="reviews">${item.reviews.length > 50 ? item.reviews.substring(0, 50) + '...' : item.reviews}</td>
                    <td>${item.harga}</td>
                    <td class="keterangan">${item.keterangan.length > 50 ? item.keterangan.substring(0, 50) + '...' : item.keterangan}</td>
                    <td>${item.availability}</td>
                    <td>${item.shipping}</td>
                    <td>${item.weight}</td>
                    <td class="deskripsi">${item.deskripsi.length > 50 ? item.deskripsi.substring(0, 50) + '...' : item.deskripsi}</td>
                    <td class="foto">    
                                ${fotoHTML}
                    </td>
                    <td>${datakategori}</td>
                    <td>
                    <table>
                    <tr>
                    <td>
                        <a href="https://dpmptsp.jabarprov.go.id/jelita/main/cms/detail_produk/${item.id}" class="btn btn-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sliders" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M11.5 2a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zM9.05 3a2.5 2.5 0 0 1 4.9 0H16v1h-2.05a2.5 2.5 0 0 1-4.9 0H0V3h9.05zM4.5 7a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zM2.05 8a2.5 2.5 0 0 1 4.9 0H16v1H6.95a2.5 2.5 0 0 1-4.9 0H0V8h2.05zm9.45 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zm-2.45 1a2.5 2.5 0 0 1 4.9 0H16v1h-2.05a2.5 2.5 0 0 1-4.9 0H0v-1h9.05z"/>
                        </svg>
                        </a>
                    </td>
                    <td>
                        <a href="https://dpmptsp.jabarprov.go.id/jelita/main/cms/hapus_produk/${item.id}" onclick="confirm('Ingin Menghapusnya?')" class="btn btn-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z"/>
                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z"/>
                        </svg>
                        </a>
                    </td
                    </tr>
                    </table>
                    </td>
                </tr>
            `;

            tableBody.innerHTML += row;
        });
    };

    const updatePagination = () => {
        const prevButton = document.getElementById('prev-page');
        const nextButton = document.getElementById('next-page');
        const totalPages = Math.ceil(data.length / itemsPerPage);

        prevButton.classList.toggle('disabled', currentPage === 1);
        nextButton.classList.toggle('disabled', currentPage === totalPages);

        renderData();
    };

    // Initial rendering
    updatePagination();

    // Previous page button click event
    document.getElementById('prev-page').addEventListener('click', function (e) {
        e.preventDefault();
        if (currentPage > 1) {
            currentPage--;
            updatePagination();
        }
    });

    // Next page button click event
    document.getElementById('next-page').addEventListener('click', function (e) {
        e.preventDefault();
        const totalPages = Math.ceil(data.length / itemsPerPage);
        if (currentPage < totalPages) {
            currentPage++;
            updatePagination();
        }
    });
});
</script>