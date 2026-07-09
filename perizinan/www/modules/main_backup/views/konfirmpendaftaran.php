<style>
    table tr td{padding-bottom: 5px; padding-left: 10px;}
    .ti_table{
        font-weight: bold; font-size: 14px; padding-bottom: 5px; padding-left: -10px;
    }
    em{font-weight: normal; font-size: 12px;}
	
	.form-group{
		width:100%;
		clear:both;
	}
	
	text{
		float:left;
		width:250px;
		text-align:right;
		font-size:13px;
		margin-top:4px;
	}

	.form-group{
		padding-top:30px;
	}
	
	.text-input{
		width:80%;
	}
	
</style>
<div class="isi">
    <div id="entry">
        <h2>Pendaftaran Online</h2>
        <div class="kiri" style="margin-left:40px;width:660px">
            <div id="pesan" style="color: red; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;"><?php //echo $error ?></div>
			
				<div class="form-group">
					<center>
						<h1>
							Terimakasih, Permohonan Anda Akan Segera Kami Proses<br>
							Silahkan Tunggu Konfirmasi Kami Melalui E-mail dan Handphone Anda
						</h1>
					</center>
				</div>
				
				<div class="form-group">
					<center>
						<?php 
							$error = $this->session->flashdata("error");
							if(!empty($error)){
						?>
							<h1 id="pesan" style="color: red; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;"><center><?php echo $error; ?></center></h1>
						<?php } ?>
						<h1>
							Masukkan Nomor Token
						</h1>
							<form action="<?php echo base_url() . 'main/pendaftaranbaru/dokonfirm'; ?>" method="post">
								<input type="text" id="" name="token" class="validate[required] text-input" style="width:80%;text-align:center" maxlength="17" value="" autofocus autocomplete="off" required><br>
								<?php //echo anchor('main/pendaftaranbaru/suksestoken', 'Lanjutkan',array("class"=>"button button-blue","style"=>"float:center")) ?>
								<input type="submit" class="button button-blue" style="float:center;cursor:pointer;margin-right:260px" value="Lanjutkan">
							</form>
					</center>
					<div class="form">
					</div>
				</div>
				
        </div>
        <div class="kanan">
            <?php echo "$menu" ?>
            <?php echo "$menu1" ?>
        </div>
        <div class="clear"></div>
    </div>
</div>
