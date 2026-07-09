<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ogani Template">
    <meta name="keywords" content="Ogani, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $page_header ?></title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="https://dpmptsp.jabarprov.go.id/jelita/assets/mitrakasih/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="https://dpmptsp.jabarprov.go.id/jelita/assets/mitrakasih/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="https://dpmptsp.jabarprov.go.id/jelita/assets/mitrakasih/css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="https://dpmptsp.jabarprov.go.id/jelita/assets/mitrakasih/css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="https://dpmptsp.jabarprov.go.id/jelita/assets/mitrakasih/css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="https://dpmptsp.jabarprov.go.id/jelita/assets/mitrakasih/css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="https://dpmptsp.jabarprov.go.id/jelita/assets/mitrakasih/css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="https://dpmptsp.jabarprov.go.id/jelita/assets/mitrakasih/css/style.css" type="text/css">
</head>
<body>
    
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Humberger Begin -->
    <div class="humberger__menu__overlay"></div>
    <div class="humberger__menu__wrapper">
        <div class="humberger__menu__logo">
            <a href="#"><img src="https://dpmptsp.jabarprov.go.id/jelita/assets/mitrakasih/img/logo.png" alt=""></a>
        </div>
        <div class="humberger__menu__cart">
            <ul>
                <li><a href="#"><i class="fa fa-heart"></i> <span>1</span></a></li>
                <li><a href="#"><i class="fa fa-shopping-bag"></i> <span>3</span></a></li>
            </ul>
            <div class="header__cart__price">item: <span>$150.00</span></div>
        </div>
        <div class="humberger__menu__widget">
            <div class="header__top__right__language">
                <img src="https://dpmptsp.jabarprov.go.id/jelita/assets/mitrakasih/img/language.png" alt="">
                <div>English</div>
                <span class="arrow_carrot-down"></span>
                <ul>
                    <li><a href="#">Spanis</a></li>
                    <li><a href="#">English</a></li>
                </ul>
            </div>
            <div class="header__top__right__auth">
                <a href="https://dpmptsp.jabarprov.go.id/jelita/main/user"><i class="fa fa-user"></i> Home</a>
            </div>
        </div>
        <nav class="humberger__menu__nav mobile-menu">
            <ul>
                <li <?php if($page_header == 'index'){ echo 'class="active"'; } ?>><a href="/jelita/main/kemitraan/index">Home</a></li>
                <li <?php if($page_header == 'shopgrid'){ echo 'class="active"'; } ?>><a href="/jelita/main/kemitraan/shopgrid">Shop</a></li>
                <li <?php if($page_header == 'shopdetails' || $page_header == 'shopingcart' || $page_header == 'checkout' || $page_header == 'blogdetails'){ echo 'class="active"'; } ?>><a href="#">Pages</a>
                    <ul class="header__menu__dropdown">
                        <!-- <li <?php // if($page_header == 'shopdetails'){ echo 'class="active"'; } ?>><a href="/jelita/main/kemitraan/shopdetails">Shop Details</a></li> -->
                        <li <?php if($page_header == 'shopingcart'){ echo 'class="active"'; } ?>><a href="/jelita/main/kemitraan/shopingcart">Shoping Cart</a></li>
                        <li <?php if($page_header == 'checkout'){ echo 'class="active"'; } ?>><a href="/jelita/main/kemitraan/checkout">Check Out</a></li>
                        <li <?php if($page_header == 'blogdetails'){ echo 'class="active"'; } ?>><a href="/jelita/main/kemitraan/blogdetails">Blog Details</a></li>
                    </ul>
                </li>
                <li <?php if($page_header == 'blog'){ echo 'class="active"'; } ?>><a href="/jelita/main/kemitraan/blog">Blog</a></li>
                <li <?php if($page_header == 'contact'){ echo 'class="active"'; } ?>><a href="/jelita/main/kemitraan/contact">Contact</a></li>
            </ul>
        </nav>
        <div id="mobile-menu-wrap"></div>
        <div class="header__top__right__social">
            <a href="#"><i class="fa fa-facebook"></i></a>
            <a href="#"><i class="fa fa-twitter"></i></a>
            <a href="#"><i class="fa fa-linkedin"></i></a>
            <a href="#"><i class="fa fa-pinterest-p"></i></a>
        </div>
        <div class="humberger__menu__contact">
            <ul>
                <li><i class="fa fa-envelope"></i> hello@colorlib.com</li>
                <li>Free Shipping for all Order of $99</li>
            </ul>
        </div>
    </div>
    <!-- Humberger End -->

    <!-- Header Section Begin -->
    <header class="header">
        <div class="header__top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="header__top__left">
                            <ul>
                                <li><i class="fa fa-envelope"></i> hello@colorlib.com</li>
                                <li>Free Shipping for all Order of $99</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="header__top__right">
                            <div class="header__top__right__social">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-linkedin"></i></a>
                                <a href="#"><i class="fa fa-pinterest-p"></i></a>
                            </div>
                            <!-- <div class="header__top__right__language">
                                <img src="https://dpmptsp.jabarprov.go.id/jelita/assets/mitrakasih/img/language.png" alt="">
                                <div>English</div>
                                <span class="arrow_carrot-down"></span>
                                <ul>
                                    <li><a href="#">English</a></li>
                                </ul>
                            </div> -->
                            <div class="header__top__right__auth">
                            <?php if(!empty($this->session->userdata('user_id'))){ 
                                $id_auth = $this->session->userdata('user_id');
                                $username = $this->m_kemitraan->get_nama_perusahaan_kemitraan($id_auth);
                            ?>
                            <nav class="navbar navbar-expand-lg navbar-light bg-light navbar-sm">
                                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                                            <span class="navbar-toggler-icon"></span>
                                        </button>
                                        <div class="collapse navbar-collapse" id="navbarNav">
                                            <ul class="navbar-nav ml-auto">
                                                <li class="nav-item dropdown">
                                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fa fa-profile"></i> Akun <?php echo $username; ?>
                                                    </a>
                                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                        <a class="dropdown-item" href="https://dpmptsp.jabarprov.go.id/jelita/main/cms/profile">Profil</a>
                                                        <a class="dropdown-item" href="https://dpmptsp.jabarprov.go.id/jelita/main/cms/home">CMS</a>
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item" href="https://dpmptsp.jabarprov.go.id/jelita/main/kemitraan/logout">Keluar</a>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </nav>
                                </div>
                            <?php }else{ ?>
                            <a href="https://dpmptsp.jabarprov.go.id/jelita/main/kemitraan/login"><i class="fa fa-user"></i> Login</a>
                            <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="header__logo">
                        <a href="/jelita/main/kemitraan/index"><img src="https://dpmptsp.jabarprov.go.id/jelita/assets/mitrakasih/img/logo.png" alt="" width="200px"></a>
                    </div>
                </div>
                <div class="col-lg-9">
                    <nav class="header__menu">
                        <ul>
                            <li <?php if($page_header == 'index'){ echo 'class="active"'; } ?>><a href="/jelita/main/kemitraan/index">Home</a></li>
                            <!-- <li <?php if($page_header == 'shopgrid'){ echo 'class="active"'; } ?>><a href="/jelita/main/kemitraan/shopgrid">Shop</a></li> -->
                            <li <?php if($page_header == 'shopdetails' || $page_header == 'shopingcart' || $page_header == 'checkout' || $page_header == 'blogdetails'){ echo 'class="active"'; } ?>><a href="#">Kemitraan Investasi</a>
                                <ul class="header__menu__dropdown">
                                    <!-- <li <?php // if($page_header == 'shopdetails'){ echo 'class="active"'; } ?>><a href="/jelita/main/kemitraan/shopdetails">Shop Details</a></li> -->
                                    <li <?php if($page_header == 'checkout'){ echo 'class="active"'; } ?>><a href="/jelita/main/kemitraan/checkout">Kemitraan Investasi</a></li>
                                    <li <?php if($page_header == 'shopingcart'){ echo 'class="active"'; } ?>><a href="/jelita/main/kemitraan/shopingcart">List Kemitraan</a></li>
                                    <!-- <li <?php if($page_header == 'blogdetails'){ echo 'class="active"'; } ?>><a href="/jelita/main/kemitraan/blogdetails">Blog Details</a></li> -->
                                    <!-- <li <?php if($page_header == 'monev'){ echo 'class="active"'; } ?>><a href="/jelita/main/kemitraan/pengembangan">Monitoring & Evaluasi</a></li> -->
                                </ul>
                            </li>
                            <li <?php if($page_header == 'blog'){ echo 'class="active"'; } ?>><a href="/jelita/main/kemitraan/blog">Blog</a></li>
                            <!-- <li <?php if($page_header == 'contact'){ echo 'class="active"'; } ?>><a href="/jelita/main/kemitraan/contact">Contact</a></li> -->
                            <li <?php if($page_header == 'contact'){ echo 'class="active"'; } ?>><a href="/jelita/main/kemitraan/pengembangan">Pengendalian</a></li>
                            <li <?php if($page_header == 'monev'){ echo 'class="active"'; } ?>><a href="/jelita/main/kemitraan/pengembangan">Monitoring & Evaluasi</a></li>
                        </ul>
                    </nav>
                </div>
                <!-- <div class="col-lg-3">
                    <div class="header__cart">
                        <ul>
                            <li><a href="#"><i class="fa fa-heart"></i> <span>1</span></a></li>
                            <li><a href="#"><i class="fa fa-shopping-bag"></i> <span>3</span></a></li>
                        </ul>
                        <div class="header__cart__price">item: <span>$150.00</span></div>
                    </div>
                </div> -->
            </div>
            <div class="humberger__open">
                <i class="fa fa-bars"></i>
            </div>
        </div>
    </header>
    <!-- Header Section End -->
    <!-- Hero Section Begin -->
    <?php 
    // $this->load->model("m_kemitraan");
    $kategori = $this->m_kemitraan->get_kategori();
    if($page_header == 'index'){ //  || $page_header == 'blogdetails'
    ?>
    <section class="hero">
    <?php }else{ ?>
    <section class="hero hero-normal">
    <?php } ?>
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="hero__categories">
                        <div class="hero__categories__all">
                            <i class="fa fa-bars"></i>
                            <span>All departments</span>
                        </div>
                        <ul>
                            <?php foreach ($kategori as $row) { ?>
                            <li><a href="/jelita/main/kemitraan/kategori/<?php echo $row->id; ?>"><?php 
                                
                            $text = $row->kategori;

                            // Batasan panjang tampilan teks
                            $panjang_tampilan = 20;

                            if (strlen($text) > $panjang_tampilan) {
                                $keterangan = substr($text, 0, $panjang_tampilan) . '...';
                            } else {
                                $keterangan = $text;
                            }

                            // echo $text_singkat;
                        echo $keterangan; ?></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="hero__search">
                        <div class="hero__search__form">
                            <!-- <form action="/jelita/main/kemitraan/search" method="POST">
                                <div class="hero__search__categories">
                                    All Categories
                                    <span class="arrow_carrot-down"></span>
                                </div>
                                <input type="text" name="search" placeholder="Mencari NIB/UMK/Perusahaan?">
                                <button class="site-btn" type="submit" value="">SEARCH</button>
                            </form> -->
                            <form action="/jelita/main/kemitraan/search" method="POST">
                                <input type="text" name="search" placeholder="Mencari UMK/Perusahaan?">
                                <button class="site-btn" type="submit" value="">SEARCH</button>
                            </form>
                        </div>
                        <div class="hero__search__phone">
                            <div class="hero__search__phone__icon">
                                <i class="fa fa-phone"></i>
                            </div>
                            <div class="hero__search__phone__text">
                                <h5>(022) 73515000</h5>
                                <span>support 08.00-16.00 WIB</span>
                            </div>
                        </div>
                    </div>
    <?php if($page_header == 'index'){ //  || $page_header == 'blogdetails'?>
                    <div class="hero__item set-bg" data-setbg="https://dpmptsp.jabarprov.go.id/jelita/assets/mitrakasih/img/hero/bannerkemitraan.png">
 '                       <div class="hero__text">
                            <br>
                            <br>
                            <span>Si KERTAS</span>
                            <h2 style="color:white;">Kerja sama <br /> menjadi seru  <br />100% Berhasil</h2>
                            <p style="color:white;">Pembuatan MOU dengan instan <br /> menggunakan SIKERTAS<br />  udah ah jadi malu</p>
                            <a href="/jelita/main/kemitraan/shopgrid" class="primary-btn">JOIN NOW</a>
                        </div>
                    </div>
        <?php } ?>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->
