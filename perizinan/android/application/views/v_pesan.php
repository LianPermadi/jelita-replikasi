<style type="text/css">
	.msg{
		width: 95%;
		height: auto;
		overflow: hidden;
		border: 1px dotted red;
		margin:auto;
		float: center;
		font-size: 12px;
	}
	p{
		margin:10px;
	}
</style>
<body>
  <?php include 'v_header.php';?>

  

  <div class="container">
    <div class="section">
<div class="msg">
    <?php
   
echo '
<center>Warning !!<center>
<p>Terjadi perubahan data dilakukan oleh staff
<br>
Nilai 1 = ' . $_GET['kyp'].'
<br>

Nilai 2 = '.$_GET['kyt'].'

<center>Silahkan revisi data terlebih dahulu dengan mengklik tombol Revisi dihalaman sebelumnya</center><p>'

 
  ?> </div>
  <br>
  <center><a href="<?php echo site_url('approve_permohonan/detail').'/'.$_GET['id']; ?> " class="modal-action modal-close waves-effect waves-green btn ">Kembali</a></center>
 
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

