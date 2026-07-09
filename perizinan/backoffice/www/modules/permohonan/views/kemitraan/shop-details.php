

    <!-- Breadcrumb Section Begin -->
    <?php 
    $kategori = $detail[0]->kategori;
    $nama_kategori = $this->m_kemitraan->get_nama_kategori($kategori);
    // echo $nama_kategori;
    ?>
    <section class="breadcrumb-section set-bg" data-setbg="https://dpmptsp.jabarprov.go.id/jelita/assets/mitrakasih/img/breadcrumb.jpg">
    <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2><?php 
                        $nama_perusahaan = $this->m_kemitraan->get_nama_perusahaan($detail[0]->id_perusahaan);
                        echo $nama_perusahaan; 
                        ?></h2>
                        <div class="breadcrumb__option">
                            <a href="/jelita/main/kemitraan/">Home</a>
                            <a href="/jelita/main/kemitraan/kategori/<?php echo $kategori ?>"><?php echo $nama_kategori; ?></a>
                            <span><?php echo $nama_perusahaan; ?></span>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Product Details Section Begin -->
    <section class="product-details spad">
        <div class="container">
            <div class="row">
                <?php 
                foreach ($detail as $row) {
                    $foto = $row->foto;
                    $delimiter = "^"; // Delimiter yang akan digunakan untuk memecah string (dalam contoh ini, spasi)

                    $foto_array = explode($delimiter, $foto);
                ?>
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__pic">
                        <?php if($foto != NULL){ ?>
                        <div class="product__details__pic__item">
                            <img class="product__details__pic__item--large"
                                src="https://dpmptsp.jabarprov.go.id/jelita/assets/mitrakasih/img/product/details/<?php echo $foto_array[0]; ?>" alt="">
                        </div>
                        <div class="product__details__pic__slider owl-carousel">
                            <?php foreach ($foto_array as $data) { ?>
                            <img data-imgbigurl="https://dpmptsp.jabarprov.go.id/jelita/assets/mitrakasih/img/product/details/<?php echo $data; ?>"
                                src="https://dpmptsp.jabarprov.go.id/jelita/assets/mitrakasih/img/product/details/<?php echo $data; ?>" alt="">
                           <?php } ?>
                        </div>
                        <?php }else{ ?>
                        <div class="product__details__pic__item">
                            <img class="product__details__pic__item--large"
                                src="https://png.pngtree.com/png-vector/20200817/ourlarge/pngtree-simple-city-landscape-background-png-image_2326328.jpg" alt="">
                        </div>
                        <div class="product__details__pic__slider owl-carousel">
                            <?php foreach ($foto_array as $data) { ?>
                            <img data-imgbigurl="https://png.pngtree.com/png-vector/20200817/ourlarge/pngtree-simple-city-landscape-background-png-image_2326328.jpg"
                                src="https://png.pngtree.com/png-vector/20200817/ourlarge/pngtree-simple-city-landscape-background-png-image_2326328.jpg" alt="">
                           <?php } ?>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__text">
                        <h3><?php echo $nama_perusahaan; ?></h3>
                        <div class="product__details__rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star-half-o"></i>
                            <span>(18 reviews)</span>
                        </div>
                        <div class="product__details__price"><?php 
                        $kota = $this->m_kemitraan->get_kabkota_perusahaan($row->id_perusahaan);
                        $alamat = $this->m_kemitraan->get_alamat_perusahaan($row->id_perusahaan);
                        echo $kota; 
                        ?></div>
                        <p><?php echo $alamat; ?></p>
                        <div class="product__details__quantity">
                            <div class="quantity">
                                <div class="pro-qty">
                                    <input type="text" value="1">
                                </div>
                            </div>
                        </div>
                        <!-- <a href="#" class="primary-btn">Create MOU</a> -->
                        <!-- <a href="#" class="primary-btn">ADD TO CART</a> -->
                        <a href="#" class="heart-icon"><span class="icon_heart_alt"></span></a>
                        <!-- <ul>
                            <li><b>Availability</b> <span><?php echo $row->availability; ?></span></li>
                            <li><b>Shipping</b> <span>01 day shipping. <samp><?php echo $row->shipping; ?></samp></span></li>
                            <li><b>Weight</b> <span><?php echo $row->weight; ?></span></li>
                            <li><b>Share on</b>
                                <div class="share">
                                    <a href="#"><i class="fa fa-facebook"></i></a>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                    <a href="#"><i class="fa fa-instagram"></i></a>
                                    <a href="#"><i class="fa fa-pinterest"></i></a>
                                </div>
                            </li>
                        </ul> -->
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="product__details__tab">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab"
                                    aria-selected="true">Description</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab"
                                    aria-selected="false">Information</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab"
                                    aria-selected="false">Reviews <span>(1)</span></a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                <div class="product__details__tab__desc">
                                    <h6>Products Infomation</h6>
                                    <p><?php echo $row->deskripsi; ?></p>
                                </div>
                            </div>
                            <div class="tab-pane" id="tabs-2" role="tabpanel">
                                <div class="product__details__tab__desc">
                                    <h6>Products Infomation</h6>
                                    <p><?php echo $row->informasi; ?></p>
                                </div>
                            </div>
                            <div class="tab-pane" id="tabs-3" role="tabpanel">
                                <div class="product__details__tab__desc">
                                    <h6>Products Infomation</h6>
                                    <p><?php echo $row->reviews; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <!-- Product Details Section End -->

    <!-- Related Product Section Begin -->
    <section class="related-product">
        <div class="container">
                    <div class="product__discount">
                    <div class="section-title related__product__title">
                        <h2>Best Product</h2>
                    </div>
                        <div class="row">
                            <div class="product__discount__slider owl-carousel">
                                <?php 
                                    $no = 1;
                                    foreach ($review as $row) {
                                    $foto = $row->foto;
                                    $delimiter = "^"; // Delimiter yang akan digunakan untuk memecah string (dalam contoh ini, spasi)
                                    $foto_array = explode($delimiter, $foto);     ?>
                                <div class="col-lg-4">
                                    <div class="product__discount__item">
                                        <?php 
                                        $imge = 'https://dpmptsp.jabarprov.go.id/jelita/assets/mitrakasih/img/product/details/'.$foto_array[0];
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
                                            <h5><a href="/jelita/main/kemitraan/shopdetails/<?php echo $row->id; ?>"><?php echo $row->nama; ?></a></h5>
                                            <div class="product__item__price"><?php echo $row->harga; ?> <span><?php 
                                            $angka = preg_replace("/[^0-9]/", "", $row->harga); 
                                            $angka = intval($angka);
                                            echo $angka * 2; ?></span></div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                } ?>
                            </div>
                        </div>
                    </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title related__product__title">
                        <h2>Rekomendasi Product</h2>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <?php foreach ($rekomen as $row) {
                    $foto = $row->foto;
                    $delimiter = "^"; // Delimiter yang akan digunakan untuk memecah string (dalam contoh ini, spasi)
                    $foto_array = explode($delimiter, $foto); 
                    // var_dump('https://dpmptsp.jabarprov.go.id/jelita/assets/mitrakasih/img/product/details/assets/mitrakasih/img/product/details/'.$foto_array[0]);die();
                    ?>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="product__item">
                    <?php if($foto != NULL){ ?>
                        <div class="product__item__pic set-bg" data-setbg="https://dpmptsp.jabarprov.go.id/jelita/assets/mitrakasih/img/product/details/<?php echo $foto_array[0]; ?>">
                    <?php }else{ ?>
                        <div class="product__item__pic set-bg" data-setbg="https://png.pngtree.com/png-vector/20200817/ourlarge/pngtree-simple-city-landscape-background-png-image_2326328.jpg">
                    <?php } ?>
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
                <?php } ?>
            </div>
        </div>
    </section>
    <!-- Related Product Section End -->