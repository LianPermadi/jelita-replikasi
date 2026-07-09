<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
        <title>DPMPTSP Provinsi Kalimantan Utara</title>
        <link rel="icon" href="<?php echo base_url(); ?>assets/img/favicon.png">

        <!-- CSS  -->
        <link href="<?php echo base_url(); ?>assets/css/fonts.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection"/>
        <link href="<?php echo base_url(); ?>assets/css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    </head>
<nav class="white" role="navigation">
            <div class="nav-wrapper container">
                <a id="logo-container" href="#" class="brand-logo">
                    <img width="105px" src="<?php echo base_url(); ?>assets/img/bpmpt.png" class="logo"/>
                </a>
                <ul class="right hide-on-med-and-down">
                    <li><a href="<?php echo base_url(); ?>">Beranda</a></li>
                    <li><a href="<?php echo base_url(); ?>ceksyarat">Cek Persyaratan</a></li>
                    <li><a href="<?php echo base_url(); ?>cekmohon">Cek Permohonan</a></li>
                    <li class="active"><a href="<?php echo base_url(); ?>gerai">Gerai Layanan</a></li>
                    
<?php if($this->session->userdata("nama") == null){
    ?>
    <li ><a href="<?php echo base_url('login/login_form'); ?>">Login</a></li>\
    <?php
}else {

    ?>
                    <li ><a href="<?php echo base_url('akdp_cetak'); ?>">AKDP</a></li>
                    <li ><a href="<?php echo base_url('login/logout'); ?>">Logout</a></li>
                    <li ><a href="#"><?php echo $this->session->userdata("nama"); ?></a></li>
<?php 
}
?>
                </ul>
                <ul id="nav-mobile" class="side-nav">
                    <div class="row">
                        <div class="col s12">
                            <div class="card">
                                <div class="card-image">
                                    <img src="<?php echo base_url(); ?>assets/img/preview.jpg">
                                    <!-- <img class="card-title-image logo-side-nav" src="<?php // echo base_url(); ?>assets/img/kaltara.png"/> -->
                                    <!-- <span class="card-title">
                                         BPMPT
                                         </span> -->
                                    <span class="card-title-description">DPMPTSP Provinsi Kalimantan Utara</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <li><a href="<?php echo base_url(); ?>"><img class="icon-list" src="<?php echo base_url(); ?>assets/img/home.png"/> Beranda</a></li>
                    <li><a href="<?php echo base_url(); ?>ceksyarat"><img class="icon-list" src="<?php echo base_url(); ?>assets/img/checklist.png"/> Cek Persyaratan</a></li>
                    <li><a href="<?php echo base_url(); ?>cekmohon"><img class="icon-list" src="<?php echo base_url(); ?>assets/img/process.png"/> Cek Permohonan</a></li>
                    <li class="active"><a href="<?php echo base_url(); ?>gerai"><img class="icon-list" src="<?php echo base_url(); ?>assets/img/location.png"/> Gerai Layanan</a></li>
                    <?php if($this->session->userdata("nama") == null){
                        ?>
                         <li><a href="<?php echo base_url('login/login_form');?>"><img class="icon-list" src="<?php echo base_url(); ?>assets/img/login.png"/> Login</a></li>
                        <?php }else{
                            ?>
                             <li><a href="<?php echo base_url('akdp_cetak');?>"><img class="icon-list" src="<?php echo base_url(); ?>assets/img/akdp.png"/> AKDP</a></li>
                    <li><a href="<?php echo base_url('login/logout');?>"><img class="icon-list" src="<?php echo base_url(); ?>assets/img/login.png"/> Logout</a></li>
                    <?php
                }
                ?>
                </ul>
                <a href="#" data-activates="nav-mobile" class="button-collapse"><img class="icon-menu" src="<?php echo base_url(); ?>assets/img/menu.png"/></a>
            </div>
        </nav>