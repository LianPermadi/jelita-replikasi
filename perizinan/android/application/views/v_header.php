<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
  <title>DPMPTSP Kabupaten Tasikmalaya</title>
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
      <?php
      if($this->session->userdata("nama") == null){
        ?>
        <li><a href="<?php echo base_url(); ?>">Beranda</a></li>
        <li><a href="<?php echo base_url(); ?>ceksyarat">Cek Persyaratan</a></li>
        <li><a href="<?php echo base_url(); ?>cekmohon">Cek Permohonan</a></li>
        <!-- <li class="active"><a href="<?php echo base_url(); ?>gerai">Gerai Layanan</a></li> -->
        <li><a href="<?php echo base_url('login/login_form'); ?>">Login</a></li>\
        <?php
      }else{
        $otherdb = $this->load->database('otherdb',TRUE);
        $otherdb->select('eselon,nip');
        $otherdb->from('tmpegawai');
        $otherdb->join('tmpegawai_user','tmpegawai.id = tmpegawai_user.tmpegawai_id','left');
        $otherdb->where('tmpegawai_user.user_id',$this->session->userdata("id"));
        $ambileselon =  $otherdb->get();
        $h = '';
        $nip = '';
        if($ambileselon->num_rows() > 0) {
          foreach ($ambileselon->result() as $data2) {
            $h = $data2->eselon;
            $nip = str_replace(' ','',$data2->nip);
          }
        }else{
          $h = '9';
        }
        ?>

        <!-- <li><a href="<?php echo base_url('akdp_cetak'); ?>">AKDP</a></li> -->
        <li>
          <a href="<?php echo base_url('approve_surat'); ?>">Persuratan 1 <?php echo $this->session->userdata("lokasi"); ?> <span style="color:green">d</span>|<span style="color:blue">Sign</span>
          </a>
        </li>
          <?php  
          if ($this->session->userdata("lokasi") == "Pusat") {
            ?>
            <li><a href="<?php echo base_url('approve_ossrba'); ?>"> <img class="icon-list" src="<?php echo base_url(); ?>assets/img/permohonan.png"/> OSS RBA <span style="color:green">
            <?php 
            if ($h == 2 && $this->session->userdata("lokasi") == "Pusat") {
              if(!empty($jmlossrba)){
                echo '<sup><b><span style="color:white; background-color:red">&nbsp'.$jmlossrba.'&nbsp</span></b></sup>';
              }
            }
            ?></a></li>
          <?php } ?>
        <?php
        if($h == 2){
          ?>
        <li>
          <a href="<?php echo base_url('eperdin'); ?>">Eperdin <?php echo $this->session->userdata("lokasi"); ?> <span style="color:green">d</span>|<span style="color:blue">Sign</span>
          </a>
        </li>
          <li><a href="<?php echo base_url('approve_esign'); ?>">E-Sign</a></li>
          <li><a href="<?php echo base_url('approve_nonesign'); ?>">Non E-Sign</a></li>
          <?php
        }else{
          //if($nip == '197105212006041012'){
          ?>
          <li><a href="<?php echo base_url('approve_per_pertek'); ?>">Permohonan Pertek</a></li>
          <?php //} ?>
          <li><a href="<?php echo base_url('approve_permohonan'); ?>">Permohonan</a></li>
          <?php 
        }
        ?>
        <li><a href="<?php echo base_url('approve_permohonan/list_approve'); ?>">List Approve</a></li>
        <li><a href="<?php echo base_url('login/logout'); ?>">Logout</a></li>
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
              <!-- <span class="card-title-description">DPMPTSP Kabupaten Tasikmalaya</span> -->
            </div>
          </div>
        </div>
      </div>
      <li><a href="<?php echo base_url(); ?>"><img class="icon-list" src="<?php echo base_url(); ?>assets/img/home.png"/> Beranda</a></li>
      <li><a href="<?php echo base_url(); ?>ceksyarat"><img class="icon-list" src="<?php echo base_url(); ?>assets/img/checklist.png"/> Cek Persyaratan</a></li>
      <li><a href="<?php echo base_url(); ?>cekmohon"><img class="icon-list" src="<?php echo base_url(); ?>assets/img/process.png"/> Cek Permohonan</a></li>
      <!-- <li class=""><a href="<?php echo base_url(); ?>gerai"><img class="icon-list" src="<?php echo base_url(); ?>assets/img/location.png"/> Gerai Layanan</a></li> -->
      <?php
      if($this->session->userdata("nama") == null){
        ?>
        <li><a href="<?php echo base_url('login/login_form');?>"><img class="icon-list" src="<?php echo base_url(); ?>assets/img/login.png"/> Login</a></li>
        <?php
      }else{
        $otherdb = $this->load->database('otherdb',TRUE);
        $otherdb->select('eselon,nip');
        $otherdb->from('tmpegawai');
        $otherdb->join('tmpegawai_user','tmpegawai.id = tmpegawai_user.tmpegawai_id','left');
        $otherdb->where('tmpegawai_user.user_id',$this->session->userdata("id"));
        $ambileselon =  $otherdb->get();
        $h = '';  
        $nip = '';
        if($ambileselon->num_rows() > 0) {
          foreach($ambileselon->result() as $data2) {
            $h = $data2->eselon;
            $nip = str_replace(' ','',$data2->nip);
          }
        }else{
          $h = '9';
        }
        ?>
        <!-- <li><a href="<?php echo base_url('akdp_cetak'); ?>"><img class="icon-list" src="<?php echo base_url(); ?>assets/img/akdp.png"/>  AKDP</a></li> -->
        <li>
          <a href="<?php echo base_url('approve_surat'); ?>">
            <img class="icon-list" src="<?php echo base_url(); ?>assets/img/permohonan.png"/> Persuratan 2
            <span style="color:green">d</span>|<span style="color:blue">Sign</span>
          </a>
        </li>          
        <?php  if ($this->session->userdata("lokasi") == "Pusat") {
            ?>
            <li><a href="<?php echo base_url('approve_ossrba'); ?>"> <img class="icon-list" src="<?php echo base_url(); ?>assets/img/permohonan.png"/> OSS RBA <span style="color:green">
            <?php 
            if ($h == 2 && $this->session->userdata("lokasi") == "Pusat") {
              echo '<sup><b><span style="color:white; background-color:red">&nbsp'.$jmlossrba.'&nbsp</span></b></sup>';
            }
            ?></a></li>
          <?php } ?>
        <?php
        if($h == 2){
          ?>
          <li><a href="<?php echo base_url('approve_esign'); ?>"><img class="icon-list" src="<?php echo base_url(); ?>assets/img/login.png"/>  E-Sign</a></li>
          <li><a href="<?php echo base_url('approve_nonesign'); ?>"><img class="icon-list" src="<?php echo base_url(); ?>assets/img/checklist.png"/> Non E-Sign</a></li>
          <?php
        }else{
          //if($nip == '197105212006041012'){
          ?>
          <li><a href="<?php echo base_url('approve_per_pertek'); ?>"><img class="icon-list" src="<?php echo base_url(); ?>assets/img/permohonan.png"/> Permohonan Pertek</a></li>
          <?php //} ?>
          <li><a href="<?php echo base_url('approve_permohonan'); ?>"><img class="icon-list" src="<?php echo base_url(); ?>assets/img/permohonan.png"/> Permohonan</a></li>
          <?php 
        }
        ?>
        <li><a href="<?php echo base_url('approve_permohonan/list_approve'); ?>"><img class="icon-list" src="<?php echo base_url(); ?>assets/img/permohonan.png"/> List Approve</a></li>
        <li><a href="<?php echo base_url('login/logout'); ?>"><img class="icon-list" src="<?php echo base_url(); ?>assets/img/login.png"/> Logout</a></li>
        <?php
      }
      ?>
    </ul>
    <a href="#" data-activates="nav-mobile" class="button-collapse"><img class="icon-menu" src="<?php echo base_url(); ?>assets/img/menu.png"/></a>
  </div>
</nav>