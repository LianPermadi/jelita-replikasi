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
<div class="main-login col-sm-4 col-sm-offset-4">
	<div class="logo">
		<?php $base_url=base_url().'assets/pendaftaran/'; ?>
		<center><?php echo anchor("main", "<img src='".$base_url."front/images/logo.jpg' class='img-responsive' style='height:100px!important;margin-bottom:5px!important'>") ?></center>
	</div>
	<!-- start: LOGIN BOX -->
	<div class="box-login">
		<h3>Reset Password</h3>
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
				<?php echo $isi; ?>
			</p>
		<?php } ?>
		<form action="<?php echo base_url() . 'main/login/doganti'; ?>" method="post">
			<div class="errorHandler alert alert-danger no-display">
				<i class="fa fa-remove-sign"></i> Terjadi Kesalahan. Mohon Periksa Data Anda.
			</div>
			<fieldset>
				<div class="form-group form-actions">
					<span class="input-icon">
						<input type="hidden" name="uuid" value="<?php echo $uuid; ?>">
						<input type="password" class="form-control password" name="password" placeholder="Reset Password" required>
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
					<?php echo anchor("main/login", "<i class='fa fa-arrow-circle-left'></i>Ke Halaman Login",array('class' => 'btn btn-primary pull-left kembali')) ?>
					<?php //echo anchor("main/user/", "Login <i class='fa fa-arrow-circle-right'></i>",array('class' => 'btn btn-primary pull-right')) ?>
					<button type="submit" class="btn btn-primary pull-right">
						Reset <i class='fa fa-arrow-circle-right'></i>
					</button>
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
	<!-- end: REGISTER BOX -->
	<!-- start: COPYRIGHT -->
	<div class="copyright">
		Copyright © 2015 DPMPTSP Provinsi Jawa Barat
	</div>
	<!-- end: COPYRIGHT -->
</div>