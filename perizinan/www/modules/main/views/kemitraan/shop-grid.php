    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="https://dpmptsp.jabarprov.go.id/jelita/assets/mitrakasih/img/breadcrumb.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2><?php 
                        if($page_header != 'kategori'){
                        $nperusahaan = $this->m_kemitraan->get_nama_perusahaan_kemitraan($id_shop);
                        echo  $nperusahaan;
                        }else{
                            $header = $this->m_kemitraan->get_nama_kategori($id_shop);
                        echo  $header;
                        }
                        ?></h2>
                        <div class="breadcrumb__option">
                            <a href="https://dpmptsp.jabarprov.go.id/jelita/main/kemitraan">Home </a>
                            <span>Produk</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->
    <!-- Product Section Begin -->
    <section class="product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-5">
                    <div class="sidebar">
                        <div class="sidebar__item">
                            <h4>Department</h4>
                            <ul>
                                <?php 
                                    $kategori = $this->m_kemitraan->get_kategori();
                                    foreach ($kategori as $data) {
                                ?>
                                <li><a href="/jelita/main/kemitraan/kategori/<?php echo $data->id; ?>"><?php echo $data->kategori; ?></a></li>
                                <?php } ?>
                            </ul>
                        </div>
                        <div class="sidebar__item">
                            <h4>Price</h4>
                            <div class="price-range-wrap">
                                <div class="price-range ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"
                                    data-min="10" data-max="540">
                                    <div class="ui-slider-range ui-corner-all ui-widget-header"></div>
                                    <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
                                    <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
                                </div>
                                <div class="range-slider">
                                    <div class="price-input">
                                        <input type="text" id="minamount">
                                        <input type="text" id="maxamount">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="sidebar__item sidebar__item__color--option">
                            <h4>Colors</h4>
                            <div class="sidebar__item__color sidebar__item__color--white">
                                <label for="white">
                                    White
                                    <input type="radio" id="white">
                                </label>
                            </div>
                            <div class="sidebar__item__color sidebar__item__color--gray">
                                <label for="gray">
                                    Gray
                                    <input type="radio" id="gray">
                                </label>
                            </div>
                            <div class="sidebar__item__color sidebar__item__color--red">
                                <label for="red">
                                    Red
                                    <input type="radio" id="red">
                                </label>
                            </div>
                            <div class="sidebar__item__color sidebar__item__color--black">
                                <label for="black">
                                    Black
                                    <input type="radio" id="black">
                                </label>
                            </div>
                            <div class="sidebar__item__color sidebar__item__color--blue">
                                <label for="blue">
                                    Blue
                                    <input type="radio" id="blue">
                                </label>
                            </div>
                            <div class="sidebar__item__color sidebar__item__color--green">
                                <label for="green">
                                    Green
                                    <input type="radio" id="green">
                                </label>
                            </div>
                        </div>
                        <div class="sidebar__item">
                            <h4>Popular Size</h4>
                            <div class="sidebar__item__size">
                                <label for="large">
                                    Large
                                    <input type="radio" id="large">
                                </label>
                            </div>
                            <div class="sidebar__item__size">
                                <label for="medium">
                                    Medium
                                    <input type="radio" id="medium">
                                </label>
                            </div>
                            <div class="sidebar__item__size">
                                <label for="small">
                                    Small
                                    <input type="radio" id="small">
                                </label>
                            </div>
                            <div class="sidebar__item__size">
                                <label for="tiny">
                                    Tiny
                                    <input type="radio" id="tiny">
                                </label>
                            </div>
                        </div>
                        <div class="sidebar__item">
                            <div class="latest-product__text">
                                <h4>Latest Products</h4>
                                <div class="latest-product__slider owl-carousel">
                                    <div class="latest-prdouct__slider__item">
                                <?php 
                                
                                    $no = 1;
                                foreach ($latest as $row) {
                                    $foto = $row->foto;
                                    $delimiter = "^"; // Delimiter yang akan digunakan untuk memecah string (dalam contoh ini, spasi)
                                    $foto_array = explode($delimiter, $foto);  
                                    ?>
                                <a href="/jelita/main/kemitraan/shopdetails/<?php echo $row->id; ?>" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <?php
                                            $logo = $this->m_kemitraan->get_logo_perusahaan($row->id);
                                            if($logo == '' || $logo == NULL){
                                                ?>
                                                <img src="https://scontent-cgk1-1.xx.fbcdn.net/v/t1.30497-1/143086968_2856368904622192_1959732218791162458_n.png?_nc_cat=1&ccb=1-7&_nc_sid=2b6aad&_nc_eui2=AeEBALW1AvTfFuoyDAvYsf0Zso2H55p0AlGyjYfnmnQCUX-gTJ8XLE4-NNASRgTyOKgjvebUtXkhAxJWyrLtIPCN&_nc_ohc=FudKRIf__wkAX8lzCh6&_nc_ht=scontent-cgk1-1.xx&oh=00_AfAv90LxhetobBb2i8yVwxbtuv8VRNkADHs2OH8kuZD3Og&oe=65546B78" style="width:100px" alt class="w-px-40 h-auto rounded-circle" />
                                                <?php
                                            } else {
                                                ?>
                                                <img src="https://dpmptsp.jabarprov.go.id/jelita/assets/mitrakasih/img/logo_company/<?php echo $logo; ?>"  style="width:100px" class="w-px-40 h-auto rounded-circle" />
                                                <?php 
                                            }
                                        ?>
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6><?php echo $row->n_perusahaan; ?></h6>
                                        <span><?php echo $row->kabkota; ?></span>
                                    </div>
                                </a>
                                <?php if($no == '3'){ ?>
                            </div>
                            <div class="latest-prdouct__slider__item">
                                <?php } ?>
                                <?php $no++; } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-7">
                    <?php 
                    if('Sudah Buat MOU' != 'Belum buat'){
                    ?>
                    <div class="product__discount">
                        <center>
        <?php 
            if($page_header != 'kategori'){
                ?>
                <a href="/jelita/main/kemitraan/create_mou" class="primary-btn btn btn-lg">Create MOU</a>
           <?php }else{ ?>
                
        <?php    }
        ?>
        </center>
        </div>
        <?php 
                    }
        ?>
        <br>
                    <div class="product__discount">
                        <div class="section-title product__discount__title">
                            <h2>Best Product</h2>
                        </div>
                        <div class="row">
                            <div class="product__discount__slider owl-carousel">
                                <?php 
                                    $no = 1;
                                    foreach ($review as $row) {
                                    $foto = $row->foto;
                                    $delimiter = "^"; // Delimiter yang akan digunakan untuk memecah string (dalam contoh ini, ^)
                                    $foto_array = explode($delimiter, $foto);     ?>
                                <div class="col-lg-4">
                                    <div class="product__discount__item">
                                        <?php 
                                    if($page_header != 'kategori'){
                                        $imge = 'https://dpmptsp.jabarprov.go.id/jelita/assets/mitrakasih/img/product/details/'.$foto_array[0];
                                    }else{
                                        $imge = 'https://dpmptsp.jabarprov.go.id/jelita/assets/mitrakasih/img/logo_company/'.$foto_array[0];
                                    }
                                        if(file_exists($imge)){
                                        ?>
                                        <div class="product__discount__item__pic set-bg"
                                            data-setbg="https://cdn-icons-png.flaticon.com/512/6259/6259277.png">
                                        <?php 
                                        }else{
                                        ?>
                                        <div class="product__discount__item__pic set-bg"
                                            data-setbg="<?php echo $imge; ?>">
                                        <?php 
                                        }
                                        ?>
                                            <div class="product__discount__percent">-20%</div>
                                            <ul class="product__item__pic__hover">
                                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                                <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                                <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="product__discount__item__text">
                                            <span>Dried Fruit</span>
                                            <?php 
                        if($page_header != 'kategori'){
                                            ?>
                                            <h5><a href="/jelita/main/kemitraan/shopdetails/<?php echo $row->id; ?>"><?php echo $row->nama; ?></a></h5>
                                            <div class="product__item__price"><?php echo $row->harga; ?> <span><?php 
                                            $angka = preg_replace("/[^0-9]/", "", $row->harga); 
                                            $angka = intval($angka);
                                            echo $angka * 2; ?></span></div>
                                            <?php 
                        }else{
                                            ?>
                                            <h5><a href="/jelita/main/kemitraan/shop_usaha/<?php echo $row->id; ?>"><?php echo $row->n_perusahaan; ?></a></h5>
                                            <div class="product__item__price"><?php echo $row->kabkota; ?> <span><?php 
                                            // $angka = preg_replace("/[^0-9]/", "", $row->harga); 
                                            // $angka = intval($angka);
                                            // echo $angka * 2; 
                                            ?></span></div>
                                            <?php 
                        }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                } ?>
                            </div>
                        </div>
                    </div>
                    <div class="filter__item">
                        <div class="row">
                            <div class="col-lg-4 col-md-5">
                                <div class="filter__sort">
                                    <span>Sort By</span>
                                    <select>
                                        <option value="0">Default</option>
                                        <option value="0">Default</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="filter__found">
                                    <?php 
                                    $found = 0;
                                    foreach ($show as $row) {
                                        $found++;
                                    } ?>
                                    <h6><span><?php echo $found; ?></span> Products found</h6>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-3">
                                <div class="filter__option">
                                    <span class="icon_grid-2x2"></span>
                                    <span class="icon_ul"></span>
                                </div>
                            </div>
                        </div>
                    </div>



                        <!-- <?php 
                        // foreach ($show as $row) {
                        //             $foto = $row->foto;
                        //             $delimiter = "^"; // Delimiter yang akan digunakan untuk memecah string (dalam contoh ini, spasi)
                        //             $foto_array = explode($delimiter, $foto); 
                                    ?>
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="product__item">
                                <div class="product__item__pic set-bg" data-setbg="https://dpmptsp.jabarprov.go.id/jelita/assets/mitrakasih/img/product/details/<?php echo $foto_array[0]; ?>">
                                    <ul class="product__item__pic__hover">
                                        <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                        <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                        <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                    </ul>
                                </div>
                                <div class="product__item__text">
                                    <h6><a href="/jelita/main/kemitraan/shopdetails/<?php echo $row->id; ?>"><?php echo $row->nama; ?></a></h6>
                                    <h5><?php echo $row->harga; ?></h5>
                                </div>
                            </div>
                        </div>

                        <?php 
                    // } 
                    ?> -->


<div class="row" id="data-container">
    <!-- Data will be displayed here -->
</div>

<ul class="pagination" id="pagination">
    <li class="page-item" id="prev-page">
        <a class="page-link" href="#">Previous</a>
    </li>
    <!-- Pagination links will be added here using JavaScript -->
    <li class="page-item" id="next-page">
        <a class="page-link" href="#">Next</a>
    </li>
</ul>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Section End -->

    <script>
document.addEventListener('DOMContentLoaded', function () {
    // Sample data (you can replace this with your own data)
    const data = <?php echo json_encode($show); ?>;
    const page_header = <?php echo json_encode($page_header ); ?>;
    const itemsPerPage = 9;
    let currentPage = 1;

    const renderData = () => {
        const dataContainer = document.getElementById('data-container');
        const startIndex = (currentPage - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;

        dataContainer.innerHTML = '';

       for (let i = startIndex; i < endIndex && i < data.length; i++) {
    const item = data[i];
    const foto = item.foto;
    const delimiter = "^";
    const foto_array = foto.split(delimiter);
    let nama, ket, id, url, imageUrl;

    if (page_header !== 'kategori') {
        nama = item.nama;
        ket = item.harga;
        id = item.id;
        url = '/jelita/main/kemitraan/shopdetails/';
        imageUrl = `https://dpmptsp.jabarprov.go.id/jelita/assets/mitrakasih/img/product/details/${foto_array[0]}`;
    } else {
        nama = item.n_perusahaan;
        ket = item.kabkota;
        id = item.id;
        url = '/jelita/main/kemitraan/shop_usaha/';
        imageUrl = `https://dpmptsp.jabarprov.go.id/jelita/assets/mitrakasih/img/logo_company/${foto_array[0]}`;
    }
    
    // Menggunakan fetch untuk memeriksa keberadaan gambar
    fetch(imageUrl)
        .then(response => {
            if (response.status === 200) {
                // Gambar ada, gunakan URL gambar yang sebenarnya
                const productItem = document.createElement('div');
                productItem.className = 'col-lg-4 col-md-6 col-sm-6';
                productItem.innerHTML = `
                    <div class="product__item">
                        <div class="product__item__pic set-bg" data-setbg="${imageUrl}">
                            <img src="${imageUrl}" alt="Product Image">
                            <ul class="product__item__pic__hover">
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                        </div>
                        <div class="product__item__text">
                            <h6><a href="${url}${id}">${nama}</a></h6>
                            <h5>${ket}</h5>
                        </div>
                    </div>
                `;
                dataContainer.appendChild(productItem);
            } else {
                // Gambar tidak ada, gunakan URL gambar alternatif
                const imageUrl = 'https://cdn-icons-png.flaticon.com/512/6259/6259277.png';
                const productItem = document.createElement('div');
                productItem.className = 'col-lg-4 col-md-6 col-sm-6';
                productItem.innerHTML = `
                    <div class="product__item">
                        <div class="product__item__pic set-bg" data-setbg="${imageUrl}">
                            <img src="${imageUrl}" alt="Product Image">
                            <ul class="product__item__pic__hover">
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                        </div>
                        <div class="product__item__text">
                            <h6><a href="${url}${id}">${nama}</a></h6>
                            <h5>${ket}</h5>
                        </div>
                    </div>
                `;
                dataContainer.appendChild(productItem);
            }
        })
        .catch(error => {
            console.error('Error occurred:', error);
        });
}
    };

    const updatePagination = () => {
        const prevButton = document.getElementById('prev-page');
        const nextButton = document.getElementById('next-page');
        const pagination = document.getElementById('pagination');

        prevButton.classList.toggle('disabled', currentPage === 1);
        nextButton.classList.toggle('disabled', currentPage * itemsPerPage >= data.length);

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
        if (currentPage * itemsPerPage < data.length) {
            currentPage++;
            updatePagination();
        }
    });
});
</script>