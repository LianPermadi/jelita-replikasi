
<body>
  <?php include 'v_header.php';?>

  

  <div class="container">
    <div class="section">
<div class="msg">
    <?php
   $akdpkendaraan_id = $_GET['akdpkendaraan_id'];
    $id = $_GET['id'];
echo '
<center><b>PESAN REVISI</b><center>
<p>';

  ?> 
  <form action="<?php echo site_url('akdp_cetak/update_revisi'); ?>" method="post">
<div class="row">
    <form class="col s12" >
      <div class="row">
        <div class="input-field col s12">
        <input type="hidden" name="akdpkendaraan_id" value="<?php echo $akdpkendaraan_id;?>">
        <input type="hidden" name="id" value="<?php echo $id;?>">
          <textarea id="textarea1" name="msg_revisi" class="materialize-textarea"></textarea>
          <label for="textarea1">Isi Pesan</label>
        </div>

      </div>


<button type="submit" class="waves-effect waves-light btn">Revisi</button> <a href="<?php echo site_url('akdp_cetak'); ?> " class="btn" >Kembali</a>
</form>
    </form>
  </div>
	
</textarea>
  </div>

 
</div>
</div>

		  
        </div>
      </div>
    </div>
  </div>

  <footer class="page-footer teal">
    <!-- <div class="container">
      <div class="row">
        <div class="col s12">
          <h5 class="white-text">Tentang BPMPT</h5>
          <p class="grey-text text-lighten-4">Pelayanan perizinan terpadu yang merupakan pelayanan publik yang meliputi semua jenis perizinan dan non perizinan yang menjadi kewenangan pemerintah Kabupaten Tasikmalaya berdasarkan Peraturan Perundang-undangan yang berlaku.</p>
        </div>
      </div>
    </div> -->
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

