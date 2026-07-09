<style>
	.kembali{
		border-color:rgb(223, 88, 88);
		color:#0000FF;
	}
	.kembali:hover{
		color:red;
		border-color:rgb(126, 188, 188);
		/* background:rgb(223, 88, 88); */
	}
	.kembali:click{
		color:red;
		border-color:rgb(223, 88, 88);
		/* background:rgb(223, 88, 88); */
	}
	        /* Mengubah warna latar belakang saat hover */
        .tombol {
            /* background-color: #3498db; */
            color: #fff;
            padding: 10px 20px;
            display: inline-block;
            text-decoration: none;
            transition: background-color 0.3s ease; /* Efek transisi yang halus */
        }

        .tombol:hover {
            /* background-color: #e74c3c; */
			text-emphasis-color:red;
        }
</style>

<script>
	jQuery(function ($) {
    grecaptcha.ready(function() {
        grecaptcha.execute('6Lc6JiEaAAAAAPkvRDncd0U4-770kWPppFS_H5Ol', {action: 'submit'}).then(function(token) {
            var recaptchaResponse = document.getElementById('recaptchaResponse');
                recaptchaResponse.value = token;
        });
    });
});
</script>

<div style="margin-right:25%; margin-left:25%;">
	<br>
	<br>
	<!-- <div class="logo">
		<?php $base_url=base_url().'assets/pendaftaran/'; ?>
		<center><?php echo anchor("main", "<img src='".$base_url."front/images/logo.png' class='img-responsive' style='height:100px!important;margin-bottom:5px!important'>") ?></center>
	</div> -->
	<!-- start: LOGIN BOX -->
	<div class="box-login">
		<br>
		<?php 
			$error 		= $this->session->flashdata("error");
			$success 	= $this->session->flashdata("success");
			if(!empty($error)){
		?>	
			<div class="errorHandler alert alert-danger no-display">
				<i class="fa fa-remove-sign"></i> <?php echo $error; ?>
			</div>
		<?php
			}else if(!empty($success)){
		?>	
			<p style="color:green;"><?php echo $success; ?></p>
		<?php
			}else{
		?>
			<p>
				Silahkan Masukkan Username Atau Email dan Password Anda.
			</p>
		<?php }
		
        // if ($this->session->userdata('user_id')) {
    	// 	// Pengguna telah login
        // echo "Pengguna telah login dengan ID " . $this->session->userdata('user_id');
        // } else {
        //     // Pengguna belum login
        //     echo "Pengguna belum login.". $this->session->userdata('user_id');
        // } 
		?>
	<br>
	<br>
		<form action="<?php echo base_url() . 'main/kemitraan/dologin'; ?>" method="post">
			<fieldset>
				<div class="form-group">
					<span class="input-icon">
						<input type="hidden" class="form-control" name="login" value="1">
						<input type="text" class="form-control" name="username" placeholder="Username" required>
						<i class="fa fa-user"></i> </span>
				</div>
				<div class="form-group form-actions">
					<span class="input-icon">
						<input type="password" class="form-control password" name="password" placeholder="Password" required>
						<i class="fa fa-lock"></i>
				</div>
				<div class="form-actions">
					<button type="submit" class="btn btn-primary pull-right">
						Login <i class='fa fa-arrow-circle-right'></i>
					</button>
				</div>
				<!-- <div class="new-account">
					Lupa Password ?
					<a href="#" class="register">
						Klik Disini
					</a>
				</div> -->
				<div style="margin-top:0px!important;">
					<h4>Belum Punya Akun ?
					<a class="kembali" href="/jelita/main/kemitraan/klaimakun">Klaim Akun Anda Sekarang Menggunakan NIB</a></h4>
				</div>
			</fieldset>
		</form>
	</div>
	<br>
	<br>
	<br>
	<br>
</div>