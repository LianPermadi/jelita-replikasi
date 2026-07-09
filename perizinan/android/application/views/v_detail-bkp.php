
<body>
  <?php include 'v_header.php';?>

  <div id="index-banner" class="parallax-container">
    <div class="section no-pad-bot">
      <div class="container">
        <h4 class="header center">Detail <br /> Permohonan</h4>
      </div>
    </div>
    <div class="parallax"><img src="<?php echo base_url(); ?>assets/img/4.png" alt="Unsplashed background img 1"></div>
  </div>


  <div class="container">
    <div class="section">

      <!--   Icon Section   -->

      <div class="row">
        <div class="col s12">
          <div class="form-group">
            <div class="col-md-12">
            <?php 
              $success  = $this->session->flashdata("success");
              if(!empty($success)){
            ?>
            <div class="alert bg-success" role="alert" style="background:#7EB332;">
              <span class="glyphicon glyphicon-check"></span> <?php echo $success; ?>
            </div>
            <?php } ?>
            <?php 
              $error  = $this->session->flashdata("error");
              if(!empty($error)){
            ?>
            <div class="alert bg-danger" role="alert" style="">
              <span class="glyphicon glyphicon-check"></span> <?php echo $error; ?>
            </div>
            <?php } ?>
            </div>
          </div>
          <div class="card-panel">
            <table>
              <thead>
                <tr>
                  <th colspan="3">Detail Permohonan</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Nomor Pendaftaran</td>
                  <td>:</td>
                  <td><?php echo $permohonan->no_permohonan; ?></td>
                </tr>
                <tr>
                  <td>Perizinan yang Dipilih</td>
                  <td>:</td>
                  <td><?php echo $nama; ?></td>
                </tr>
                <tr>
                  <td>Tanggal Pengajuan</td>
                  <td>:</td>
                  <td><?php echo date("d m Y",strtotime($permohonan->d_entry)) ?></td>
                </tr>
                <tr>
                  <td>Status</td>
                  <td>:</td>
                  <td><?php echo $status; ?></td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="card-panel">
            <table class="striped bordered">
              <thead>
                <tr>
                  <th colspan="3">Tracking</th>
                </tr>
                <tr>
                  <th>Proses Izin</th>
                  <th>Tanggal</th>
                  <th>Waktu</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($track as $t) { ?>
                  <tr>
                    <td><?php echo $t->tr_activiti; ?></td>
                    <td><?php echo date("d m Y",strtotime($t->d_entry)); ?></td>
                    <td><?php echo date("H:i:s",strtotime($t->d_entry)); ?></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
          <div class="card-panel">
            <h5 class="title-card">Asistensi Perizinan</h5>
            <ul class="collection">
              <?php foreach($asistensi as $a) { ?>
                <li class="collection-item avatar">
                  <img src="<?php echo base_url(); ?>assets/img/asistensi.jpg" alt="" class="circle">
                  <span class="title"><?php echo $a->oleh; ?></span>
                  <p><?php echo $a->pesan; ?></p>
                  <p><?php echo date("h:i:s",strtotime($a->tanggal))." ".date("d M y",strtotime($pesan->tanggal)); ?></p>
                </li>
              <?php } ?>
            </ul>
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
