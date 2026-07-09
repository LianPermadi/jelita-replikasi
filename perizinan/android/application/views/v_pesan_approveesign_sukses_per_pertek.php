<style type="text/css">
	.msg{
		width: 95%;
		height: auto;
		overflow: hidden;
		border: 1px solid green;
		margin:auto;
		float: center;
		font-size: 14px;
	}
	p{
		margin:10px;
	}
</style>
<?php include 'v_header.php';?>
  <body>
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
 <a href="<?php echo site_url('approve_per_pertek'); ?> " class="btn" >OK</a></center><br>
</div>
</div>
</div>
<footer class="page-footer teal">
  <div class="footer-copyright">
    <div class="container">
    2017 © DPMPTSP Provinsi Jawa Barat v 3.0
    </div>
  </div>
</footer>
  <!--  Scripts-->
  <script src="<?php echo base_url(); ?>assets/js/jquery-2.1.1.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/materialize.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/init.js"></script>

  </body>
</html>

