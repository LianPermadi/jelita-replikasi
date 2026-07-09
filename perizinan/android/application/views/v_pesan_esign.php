<style type="text/css">
	.msg{
		width: 95%;
		height: auto;
		overflow: hidden;
		border: 1px solid red;
		margin:auto;
		float: center;
		font-size: 14px;
	}
	p{
		margin:10px;
	}
</style>
<?php
include 'v_header.php';?>

  <body>

  <div class="container">
    <div class="section">
    <div class="msg">
    <br>
    <br>
<br>
<?php 
if($pesan == 'gagal'){
  ?>
   <center> <img src="<?php echo base_url('assets/img/warning.png');?>"></center>
  <?php
echo '<center>Kode Passphrase Tidak Sesuai !<br>
Penanda Tanganan Dokumen Gagal<br>
 Silahkan Ulangi Proses Approve<br><br>';
}else{

?>  
<div class="container">
  <div class="section">
    <div class="msg">
      <br>
      <br>
      <center> <img src="<?php echo base_url('assets/img/check-mark.png');?>"></center>
      <br>
      <?php
      echo '<center>Berhasil Menandatangani Seluruh Dokumen.<br><br>';
      ?>
      <a href="<?php echo site_url('approve_permohonan'); ?> " class="btn" >OK</a></center><br>
    </div>
  </div>
</div>
<?php } ?>
 <a href="<?php echo site_url('approve_permohonan'); ?> " class="btn" >Kembali</a></center><br>
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

