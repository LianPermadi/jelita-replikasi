<body>
<?php include 'v_header.php';

?>
  <div id="index-banner" class="parallax-container">
    <div class="section no-pad-bot">
      <div class="container">
        <!--<h4 class="header center">Cek <br /> Permohonan</h4>-->
      </div>
    </div>
    <div class="parallax"><img src="<?php echo base_url(); ?>assets/img/4.png" alt="Unsplashed background img 1"></div>
  </div>


  <div class="container" style="margin-top: 30px;">
    <div class="section">

      <!--   Icon Section   -->

      <div class="row">
        <div class="col s12">
          <?php 
            $error = $this->session->flashdata("error");
            if(!empty($error)){
          ?>
            <div id="pesan" style="color: red; font-size: 13px; margin-bottom: 10px; font-weight: bold;"><center><?php echo $error; ?></center></div>
          <?php } ?>
          <div class="card-panel">
             <form action="<?php echo base_url('login/aksi_login'); ?>" method="post">	
                <div class="input-field s6">
                  <input name="username" placeholder="" id="username" type="text" class="validate" required="true">
                  <label for="username">Username</label>
                </div>    
                 <div class="input-field s6">
                  <input name="password" placeholder="" id="password" type="password" class="validate" required="true">
                  <label for="password">Password</label>
                </div>  

                <button class="btn btn-block waves-effect waves-light" type="submit" name="action">Login</button>

              </form>
              <br>
              <?php echo '<center>'.$error_login.'</center>'; ?>
          </div>
        </div>
      </div>
      
    </div>
  </div>

  <footer class="page-footer teal" style="visibility: hidden;">
    <div class="container">
      <div class="row">
        <div class="col s12">
          <h5 class="white-text">Tentang DPMPTSP</h5>
          <p class="grey-text text-lighten-4" align="justify">Pelayanan perizinan terpadu yang merupakan pelayanan publik yang meliputi semua jenis perizinan dan non perizinan yang menjadi kewenangan pemerintah Kabupaten Tasikmalaya berdasarkan Peraturan Perundang-undangan yang berlaku.</p>
        </div>
      </div>
    </div>
  </footer>

  <footer class="page-footer teal">
    <div class="footer-copyright">
      <div class="container">
        <center>2018 © DPMPTSP Kabupaten Tasikmalaya v.1</center>
      </div>
    </div>
  </footer>


  <!--  Scripts-->
  <script src="<?php echo base_url(); ?>assets/js/jquery-2.1.1.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/materialize.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/init.js"></script>

  </body>
</html>
