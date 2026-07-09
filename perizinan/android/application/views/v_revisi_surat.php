<?php include 'v_header.php';?>
<body>
  <div class="container">
    <div class="section">
      <h5><center>REVISI PERSURATAN</center></h5>
      <div class="msg">
          <?php
      echo '
      <center><b>PESAN REVISI</b><center>
      <p>';

        ?> 
        <form action="<?php echo site_url('approve_surat/update_revisi'); ?>" method="post">
      <div class="row">
          <form class="col s12" >
            <div class="row">
              <div class="input-field col s12">
              <input type="hidden" name="id" value="<?php echo $id;?>">
                <textarea id="textarea1" name="msg_revisi" class="materialize-textarea"></textarea>
                <label for="textarea1">Isi Pesan</label>
              </div>

            </div>


      <button type="submit" class="waves-effect waves-light btn">Revisi</button> <a href="<?php echo site_url('approve_surat/preview').'/'.$id; ?> " class="btn red" >Kembali</a>
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
    <div class="footer-copyright">
      <div class="container">
      2017 © DPMPTSP Provinsi Jawa Barat v 1.5
      </div>
    </div>
  </footer>

  <!--  Scripts-->
  <script src="<?php echo base_url(); ?>assets/js/jquery-2.1.1.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/materialize.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/init.js"></script>

  </body>
</html>

