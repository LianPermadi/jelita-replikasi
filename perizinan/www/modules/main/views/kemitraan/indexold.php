    <!-- Categories Section Begin -->
    <section class="categories">
        <div class="container">
            <div class="row">
                <div class="categories__slider owl-carousel">
                    <div class="col-lg-3">
                        <div class="categories__item set-bg" data-setbg="https://dpmptsp.jabarprov.go.id/jelita/assets/mitrakasih/img/categories/cat-1.jpg">
                            <h5><a href="#">Fresh Fruit</a></h5>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="categories__item set-bg" data-setbg="https://dpmptsp.jabarprov.go.id/jelita/assets/mitrakasih/img/categories/cat-2.jpg">
                            <h5><a href="#">Dried Fruit</a></h5>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="categories__item set-bg" data-setbg="https://dpmptsp.jabarprov.go.id/jelita/assets/mitrakasih/img/categories/cat-3.jpg">
                            <h5><a href="#">Vegetables</a></h5>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="categories__item set-bg" data-setbg="https://dpmptsp.jabarprov.go.id/jelita/assets/mitrakasih/img/categories/cat-4.jpg">
                            <h5><a href="#">drink fruits</a></h5>
                        </div>
                    </div>                    <div class="col-lg-3">
                        <div class="categories__item set-bg" data-setbg="https://dpmptsp.jabarprov.go.id/jelita/assets/mitrakasih/img/categories/cat-5.jpg">
                            <h5><a href="#">drink fruits</a></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Categories Section End -->

    <!-- Featured Section Begin -->
    <section class="featured spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Featured Product</h2>
                    </div>
                    <div class="featured__controls">
                        <ul>
                            <li class="active" data-filter="*">All</li>
                            <?php 
                            foreach ($kategori as $row) {
                                $string = $row->kategori;
                                $newString = str_replace(" ", "-", $string);
                                // echo $newString; // Output: "Halo, semua!" 
                                ?>
                            <li data-filter=".<?php echo $newString; ?>"><?php echo $row->kategori; ?></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row featured__filter">
                <?php 
                foreach ($get as $row) {
                    $foto = $row->foto;
                    $delimiter = "^"; // Delimiter yang akan digunakan untuk memecah string (dalam contoh ini, spasi)
                    $foto_array = explode($delimiter, $foto); 
                    $nama_kategori = $this->m_kemitraan->get_nama_kategori($row->kategori);
                    $string = $nama_kategori;
                    $newString = str_replace(" ", "-", $string);
                    ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mix <?php echo $newString; ?> fresh-meat">
                    <div class="featured__item">
                        <div class="featured__item__pic set-bg" data-setbg="https://dpmptsp.jabarprov.go.id/jelita/assets/mitrakasih/img/product/details/<?php echo$foto_array[0]; ?>">
                            <ul class="featured__item__pic__hover">
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                        </div>
                        <div class="featured__item__text">
                            <h6><a href="/kemitraan/kemitraan/shopdetails/<?php echo $row->id; ?>"><?php echo $row->nama; ?></a></h6>
                            <h5><?php echo $row->harga; ?></h5>
                        </div>
                    </div>
                </div>
                <?php 
            } 
        // var_dump($kategori);die();
            ?>
            </div>
        </div>
    </section>
    <!-- Featured Section End -->

    <!-- Banner Begin -->
    <div class="banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="banner__pic">
                        <img src="https://dpmptsp.jabarprov.go.id/jelita/assets/mitrakasih/img/banner/banner-1.jpg" alt="">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="banner__pic">
                        <img src="https://dpmptsp.jabarprov.go.id/jelita/assets/mitrakasih/img/banner/banner-2.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Banner End -->

    <!-- Latest Product Section Begin -->
    <section class="latest-product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6">
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
                                <a href="/kemitraan/kemitraan/shopdetails/<?php echo $row->id; ?>" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="https://dpmptsp.jabarprov.go.id/jelita/assets/mitrakasih/img/product/details/<?php echo$foto_array[0]; ?>" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6><?php echo $row->nama; ?></h6>
                                        <span><?php echo $row->harga; ?></span>
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
                <div class="col-lg-4 col-md-6">
                    <div class="latest-product__text">
                        <h4>Top Rated Products</h4>
                        <div class="latest-product__slider owl-carousel">
                            <div class="latest-prdouct__slider__item">
                                <?php 
                                    $no = 1;
                                foreach ($top as $row) {
                                    $foto = $row->foto;
                                    $delimiter = "^"; // Delimiter yang akan digunakan untuk memecah string (dalam contoh ini, spasi)
                                    $foto_array = explode($delimiter, $foto);  
                                    ?>
                                <a href="/kemitraan/kemitraan/shopdetails/<?php echo $row->id; ?>" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="https://dpmptsp.jabarprov.go.id/jelita/assets/mitrakasih/img/product/details/<?php echo$foto_array[0]; ?>" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6><?php echo $row->nama; ?></h6>
                                        <span><?php echo $row->harga; ?></span>
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
                <div class="col-lg-4 col-md-6">
                    <div class="latest-product__text">
                        <h4>New Products</h4>
                        <div class="latest-product__slider owl-carousel">
                            <div class="latest-prdouct__slider__item">
                                <?php 
                                    $no = 1;
                                foreach ($review as $row) {
                                    $foto = $row->foto;
                                    $delimiter = "^"; // Delimiter yang akan digunakan untuk memecah string (dalam contoh ini, spasi)
                                    $foto_array = explode($delimiter, $foto);  
                                    ?>
                                <a href="/kemitraan/kemitraan/shopdetails/<?php echo $row->id; ?>" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="https://dpmptsp.jabarprov.go.id/jelita/assets/mitrakasih/img/product/details/<?php echo$foto_array[0]; ?>" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6><?php echo $row->nama; ?></h6>
                                        <span><?php echo $row->harga; ?></span>
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
    </section>
    <!-- Latest Product Section End -->