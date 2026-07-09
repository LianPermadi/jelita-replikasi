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
		<h3>Login Upload Formulir</h3>
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
		<form action="<?php echo base_url() . 'main/upload_formulir/dologin'; ?>" method="post">
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
					<?php echo anchor("main/", "<i class='fa fa-arrow-circle-left'></i>Ke Halaman Utama",array('class' => 'btn btn-primary pull-left kembali')) ?>
					<?php //echo anchor("main/user/", "Login <i class='fa fa-arrow-circle-right'></i>",array('class' => 'btn btn-primary pull-right')) ?>
					<button type="submit" class="btn btn-primary pull-right">
						Login <i class='fa fa-arrow-circle-right'></i>
					</button>
				</div>
			</fieldset>
		</form>
	</div>
	<!-- end: LOGIN BOX -->