    <!-- Categories Section Begin -->
    <section class="categories">
        <div class="container">
            <div class="row">
                <div class="categories__slider owl-carousel">
                    <div class="col-lg-3">
                        <div class="categories__item set-bg" data-setbg="https://logowik.com/content/uploads/images/197_suzuki.jpg" style="width:100%;background-color:white;">
                            <h5><a href="#" style="background-color:#7FFF00;">Suzuki</a></h5>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="categories__item set-bg" data-setbg="https://static.vecteezy.com/system/resources/previews/020/335/963/non_2x/honda-logo-honda-icon-free-free-vector.jpg" style="width:100%;background-color:white;">
                            <h5><a href="#" style="background-color:#7FFF00;">Honda</a></h5>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="categories__item set-bg" data-setbg="https://cdn1.iconfinder.com/data/icons/google-s-logo/150/Google_Icons-09-512.png" style="width:100%;background-color:white;">
                            <h5><a href="#" style="background-color:#7FFF00;">Google</a></h5>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="categories__item set-bg" data-setbg="https://1000logos.net/wp-content/uploads/2020/10/Intel-Inside-logo.png" style="width:100%;background-color:white;">
                            <h5><a href="#" style="background-color:#7FFF00;">Intel Inside</a></h5>
                        </div>
                    </div>                    <div class="col-lg-3">
                        <div class="categories__item set-bg" data-setbg="https://alumni.unsoed.ac.id/wp-content/uploads/2022/06/PT-Freeport-Indonesia.png"  style="width:100%;background-color:white;">
                            <h5><a href="#" style="background-color:#7FFF00;">Freeport</a></h5>
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
                            <li data-filter=".<?php echo $newString; ?>"><?php 
                            
                            $text = $row->kategori;

                            // Batasan panjang tampilan teks
                            $panjang_tampilan = 20;

                            if (strlen($text) > $panjang_tampilan) {
                                $keterangan = substr($text, 0, $panjang_tampilan) . '...';
                            } else {
                                $keterangan = $text;
                            }

                            // echo $text_singkat;
                        echo $keterangan; ?></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row featured__filter">
                <?php 
                foreach ($get as $row) {
                    $foto = $row->foto;
                    // $delimiter = "^"; // Delimiter yang akan digunakan untuk memecah string (dalam contoh ini, spasi)
                    // $foto_array = explode($delimiter, $foto); 
                    $nama_kategori = $this->m_kemitraan->get_nama_kategori($row->kategori);
                    $string = $nama_kategori;
                    $newString = str_replace(" ", "-", $string);
                    ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mix <?php echo $newString; ?> fresh-meat">
                    <div class="featured__item">
                                    <?php if($foto != NULL){ ?>
                                        <div class="featured__item__pic set-bg" data-setbg="https://dpmptsp.jabarprov.go.id/jelita/assets/mitrakasih/img/logo_company/<?php echo $foto; ?>">
                                    <?php }else{ ?>
                                        <div class="featured__item__pic set-bg" data-setbg="https://png.pngtree.com/png-vector/20200817/ourlarge/pngtree-simple-city-landscape-background-png-image_2326328.jpg">
                                    <?php } ?>
                        
                            <ul class="featured__item__pic__hover">
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                        </div>
                        <div class="featured__item__text">
                            <h6><a href="/jelita/main/kemitraan/shop_usaha/<?php echo $row->id; ?>"><?php 
                                        // $nama_perusahaan = $this->m_kemitraan->get_nama_perusahaan($row->id_perusahaan);
                                        echo $row->n_perusahaan; 
                                        ?></a></h6>
                            <h5><?php echo $row->kabkota; ?></h5>
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
                                <a href="/jelita/main/kemitraan/shop_usaha/<?php echo $row->id; ?>" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                    <?php if($foto != NULL){ ?>
                                        <img src="https://dpmptsp.jabarprov.go.id/jelita/assets/mitrakasih/img/logo_company/<?php echo $foto; ?>" alt="">
                                    <?php }else{ ?>
                                        <img src="https://png.pngtree.com/png-vector/20200817/ourlarge/pngtree-simple-city-landscape-background-png-image_2326328.jpg" alt="">
                                    <?php } ?>
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6><?php 
                                        // $nama_perusahaan = $this->m_kemitraan->get_nama_perusahaan($row->id_perusahaan);
                                        echo $row->n_perusahaan; 
                                        ?></h6>
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
                                <a href="/jelita/main/kemitraan/shop_usaha/<?php echo $row->id; ?>" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                    <?php if($foto != NULL){ ?>
                                        <img src="https://dpmptsp.jabarprov.go.id/jelita/assets/mitrakasih/img/logo_company/<?php echo $foto; ?>" alt="">
                                    <?php }else{ ?>
                                        <img src="https://png.pngtree.com/png-vector/20200817/ourlarge/pngtree-simple-city-landscape-background-png-image_2326328.jpg" alt="" width='100px'>
                                    <?php } ?>
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6><?php 
                                        // $nama_perusahaan = $this->m_kemitraan->get_nama_perusahaan($row->id_perusahaan);
                                        echo $row->n_perusahaan; 
                                        ?></h6>
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
                                <a href="/jelita/main/kemitraan/shop_usaha/<?php echo $row->id; ?>" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                    <?php if($foto != NULL){ ?>
                                        <img src="https://dpmptsp.jabarprov.go.id/jelita/assets/mitrakasih/img/logo_company/<?php echo $foto; ?>" alt="">
                                    <?php }else{ ?>
                                        <img src="https://png.pngtree.com/png-vector/20200817/ourlarge/pngtree-simple-city-landscape-background-png-image_2326328.jpg" alt="" width='100px'>
                                    <?php } ?>
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6><?php 
                                        // $nama_perusahaan = $this->m_kemitraan->get_nama_perusahaan($row->id_perusahaan);
                                        echo $row->n_perusahaan; 
                                        ?></h6>
                                        <span><?php echo $row->kabkota; ?></span>
                                    </div>
                                </a>
                                <?php if($no == '3'){ ?>
                            </div>
                            <div class="latest-prdouct__slider__item">
                                <?php } ?>
                                <?php $no++; 
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Latest Product Section End -->