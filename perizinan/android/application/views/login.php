</html>
  <body>
    <?php include 'v_header.php';?>
    
    <div id="index-banner" class="parallax-container">
      <!--<div class="section no-pad-bot">
        <div class="container">
          <h3 class="header center">Menu Utama</h3>
        </div>
      </div>-->
      <div class="parallax"><img src="<?php echo base_url(); ?>assets/img/4.png" alt="Unsplashed background img 1"></div>
    </div>
    
    
    <div class="container">
      <div class="section">
        <!--   Icon Section   -->
        <!-- <div class="row">
          <div class="collection">
            <a href="ceksyarat" class="collection-item waves-effect"><i class="material-icons">list</i> Cek Persyaratan</a>
            <a href="cekmohon" class="collection-item waves-effect"><i class="material-icons">thumbs_up_down</i> Cek Permohonan</a>
          </div>
        </div> -->
        
        <ul class="collapsible" data-collapsible="accordion">
          <li>
            <a href="<?php echo base_url(); ?>ceksyarat">
              <div class="collapsible-header waves-effect">
                <!-- <i class="material-icons">list</i> -->
                <img class="icon-list" src="<?php echo base_url(); ?>assets/img/checklist.png"/>
                Cek Persyaratan Perizinan
              </div>
            </a>
          </li>
          <li>
            <a href="<?php echo base_url(); ?>cekmohon">
              <div class="collapsible-header waves-effect">
                <!-- <i class="material-icons">thumbs_up_down</i> -->
                <img class="icon-list" src="<?php echo base_url(); ?>assets/img/process.png"/>
                Cek Status Permohonan
              </div>
            </a>
          </li>
          <!-- <li>
            <a href="<?php echo base_url(); ?>gerai">
              <div class="collapsible-header waves-effect">
                <!-- <i class="material-icons">place</i> -->
                <!--<img class="icon-list" src="<?php echo base_url(); ?>assets/img/location.png"/>
                Gerai Layanan
              </div>
            </a>
          </li>-->
          <?php 
          if ($this->session->userdata("nama") == null){
            ?>
            <li>
              <a href="<?php echo base_url(); ?>login/login_form">
                <div class="collapsible-header waves-effect">
                  <!-- <i class="material-icons">place</i> -->
                  <img class="icon-list" src="<?php echo base_url(); ?>assets/img/login.png"/>
                  Login
                </div>
              </a>
            </li>
            <?php
          }else{
            ?>
            <li>
              <a href="<?php echo base_url(); ?>login/logout">
                <div class="collapsible-header waves-effect">
                  <!-- <i class="material-icons">place</i> -->
                  <img class="icon-list" src="<?php echo base_url(); ?>assets/img/login.png"/>
                  Logout
                </div>
              </a>
            </li>
            <?php
          }
          ?>
        </ul>
      </div>
    </div>
  
    <footer class="page-footer teal" style="visibility: hidden;">
      <div class="container">
        <div class="row">
          <div class="col s12">
            <h5 class="white-text">Tentang DPMPTSP</h5>
            <p class="grey-text text-lighten-4" align="justify">Pelayanan perizinan terpadu yang merupakan pelayanan publik yang</p>
          </div>
        </div>
      </div>
    </footer>
    
    <footer class="page-footer teal">
      <div class="footer-copyright">
        <div class="container">
          <center><center>2018 © DPMPTSP Kabupaten Tasikmalaya v.1</center></center>
        </div>
      </div>
    </footer>
    <!--  Scripts-->
    <script src="<?php echo base_url(); ?>assets/js/jquery-2.1.1.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/materialize.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/init.js"></script>
    
  </body>
</html>
