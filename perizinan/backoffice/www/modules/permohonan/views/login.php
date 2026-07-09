<style>
	.kembali{
		border-color:rgb(223, 88, 88);
		color:rgb(223, 88, 88);
	}
	.kembali:hover{
		color:white;
		border-color:rgb(223, 88, 88);
		background:rgb(223, 88, 88);
	}
	.kembali:click{
		color:white;
		border-color:rgb(223, 88, 88);
		background:rgb(223, 88, 88);
	}
</style>

<script>
// 	jQuery(function ($) {
//     grecaptcha.ready(function() {
//         // grecaptcha.execute('6Lc6JiEaAAAAAPkvRDncd0U4-770kWPppFS_H5Ol', {action: 'submit'}).then(function(token) {
//         grecaptcha.execute('6Le4xKEmAAAAAFFZNxN5FEnfbZOeh_NVkTl1sQ7G', {action: 'submit'}).then(function(token) {
//             var recaptchaResponse = document.getElementById('recaptchaResponse');
//                 recaptchaResponse.value = token;
//         });
//     });
// });
</script>

<div class="main-login col-sm-4 col-sm-offset-4">
	<div class="logo">
		<?php $base_url=base_url().'assets/pendaftaran/'; ?>
		<center><?php echo anchor("main", "<img src='".$base_url."front/images/logo.png' class='img-responsive' style='height:100px!important;margin-bottom:5px!important'>") ?></center>
	</div>
	<!-- start: LOGIN BOX -->
	<div class="box-login">
		<center>
			<h3>Login Perizinan Online<br>PAWARI</h3>
		</center>
		<br>
		<?php 
			$error 		= $this->session->flashdata("error");
			$success 	= $this->session->flashdata("success");
			if(!empty($error)){
		?>	
			<p style="color:red;"><?php echo $error; ?></p>
		<?php
			}else if(!empty($success)){
		?>	
			<p style="color:green;"><?php echo $success; ?></p>
		<?php
			}else{
		?>
			<p>
				Silahkan Masukkan Username dan Password Anda.
			</p>
		<?php } ?>
		<form action="<?php echo base_url() . 'main/login/dologin'; ?>" method="post">
			<div class="errorHandler alert alert-danger no-display">
				<i class="fa fa-remove-sign"></i> Terjadi Kesalahan. Mohon Periksa Data Anda.
			</div>
			<fieldset>
				<div class="form-group">
					<span class="input-icon">
						<input type="text" class="form-control" name="username" placeholder="Username" required>
						<i class="fa fa-user"></i> </span>
				</div>
				<div class="form-group form-actions">
					<span class="input-icon">
						<input type="password" class="form-control password" name="password" placeholder="Password" required>
						<i class="fa fa-lock"></i>
						<!--<a class="forgot" href="#">
							I forgot my password
						</a> </span>-->
				</div>
				<div class="form-actions">
					<!--<label for="remember" class="checkbox-inline">
						<input type="checkbox" class="grey remember" id="remember" name="remember">
						Keep me signed in
					</label>-->
					<!-- <input type="hidden" name="recaptcha_response" id="recaptchaResponse"> -->
					<div class="g-recaptcha" data-sitekey="6LcPEK0mAAAAANk0sSXsrrAxKPbgHBWtrMI8eMN4"></div><script src="https://www.google.com/recaptcha/api.js" async defer></script>
					<?php   echo anchor("main/", "<i class='fa fa-arrow-circle-left'></i>Ke Halaman Utama",array('class' => 'btn btn-primary pull-left kembali')) ?>
					<?php //echo anchor("main/user/", "Login <i class='fa fa-arrow-circle-right'></i>",array('class' => 'btn btn-primary pull-right')) ?>
					<button type="submit" class="btn btn-primary pull-right">
						Login <i class='fa fa-arrow-circle-right'></i>
					</button>
				</div>
				<div class="new-account">
					Lupa Password ?
					<a href="#" class="register">
						Klik Disini
					</a>
				</div>
				<div class="new-account">
					Masukkan Kode Verifikasi anda
					<a href="#" class="register">
						<?php echo anchor("main/pendaftaranbaru/konfirm", "Klik Disini",array('class' => '')) ?>
					</a>
				</div>
				<div class="new-account" style="margin-top:0px!important;">
					Belum Punya Akun ?
					<?php echo anchor("main/pendaftaranbaru", "Daftar Sekarang",array('class' => '')) ?>
				</div>
			</fieldset>
		</form>
	</div>
	<!-- end: LOGIN BOX -->
	<!-- start: FORGOT BOX -->
	<!-- start: REGISTER BOX -->
	<div class="box-register">
		<h3>Lupa Password ?</h3>
		<p>
			Masukkan E-mail Anda Untuk Mendapatkan Password.
		</p>
		<form class="form-forgot" method="post" action="<?php echo base_url() . 'main/login/password'; ?>">
			<div class="errorHandler alert alert-danger no-display">
				<i class="fa fa-remove-sign"></i> Terjadi Kesalahan. Mohon Ulangi Pengisian E-mail.
			</div>
			<fieldset>
				<div class="form-group">
					<span class="input-icon">
						<input type="email" class="form-control" name="email" placeholder="Email" required>
						<i class="fa fa-envelope"></i> </span>
				</div>
				<div class="form-actions">
					<a class="btn btn btn-primary kembali go-back">
						<i class="fa fa-circle-arrow-left"></i> Kembali
					</a>
					<?php //echo anchor("main/login/password", "Lanjutkan <i class='fa fa-arrow-circle-right'></i>",array('class' => 'btn btn-primary pull-right')) ?>
					<button type="submit" class="btn btn-primary pull-right">
						Lanjutkan <i class='fa fa-arrow-circle-right'></i>
					</button
				</div>
			</fieldset>
		</form>
	</div>
	<center>
		<br>
		<img alt="SIMPATIK JABAR" title="Sistem Informasi Pelayanan Perizinan untuk Publik" src="https://dpmptsp.jabarprov.go.id/web/themes/default/images/simpatik_logo.png" style="width:90px;height:45px;right: 0px;">
		<a href="https://play.google.com/store/apps/details?id=hantek.bsre.pdfverify" title="Balai Sertifikasi Elektronik" target="_blank"><img alt="Balai Sertifikasi Elektronik" src="https://dpmptsp.jabarprov.go.id/web/themes/default/images/logo_BSrE_3.png" style="width:120px;height:45px;right: 0px;"></a>
	</center>
	<!-- end: REGISTER BOX -->
	<!-- start: COPYRIGHT -->
	<div class="copyright">
		Copyright © 2025 DPMPTSP KABUPATEN MANOKWARI
	</div>
	<!-- end: COPYRIGHT -->
</div>