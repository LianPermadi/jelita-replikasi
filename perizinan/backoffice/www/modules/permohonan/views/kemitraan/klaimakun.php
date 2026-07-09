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
	jQuery(function ($) {
    grecaptcha.ready(function() {
        grecaptcha.execute('6Lc6JiEaAAAAAPkvRDncd0U4-770kWPppFS_H5Ol', {action: 'submit'}).then(function(token) {
            var recaptchaResponse = document.getElementById('recaptchaResponse');
                recaptchaResponse.value = token;
        });
    });
});
</script>

<div>
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
			<p style="color:red;"><?php echo $error; ?></p>
		<?php
			}else if(!empty($success)){
		?>	
			<p style="color:green;"><?php echo $success; ?></p>
		<?php
			}else{
		?>
        <div style="margin-left:25%; margin-right:25%;">
			<p>
				Silahkan Masukkan NIB anda.
			</p>
		<?php } ?>
<form action="/jelita/main/kemitraan/nibget" method="post">
    <fieldset>
        <div class="form-group">
            <div class="input-group">
                <input type="text" class="form-control" name="nib" placeholder="NIB" required>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary pull-right">
                Cek <i class='fa fa-arrow-circle-right'></i>
            </button>
        </div>
    </fieldset>
</form>
<br>
            </div>
	</div>
	<!-- end: LOGIN BOX -->
	<!-- start: FORGOT BOX -->
	<!-- start: REGISTER BOX -->
	</div>
</div>