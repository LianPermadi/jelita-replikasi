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

	.form{
		float:left;
		width:360px;
		padding-bottom:10px;
		margin-left:20px;
	}
	
	.text-input{
		width:80%;
	}
	
</style>
<div class="isi">
    <div id="entry">
        <h2>Reset Password</h2>
        <div class="kiri" style="margin-left:40px;width:660px">
            <div id="pesan" style="color: red; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;"><?php //echo $error ?></div>
            <div id="pesan" style="font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;text-align:center">Silahkan Masukkan Password Baru</div>
			
				<div id="perusahaan">
					
					<?php 
						$error = $this->session->flashdata("error");
						if(!empty($error)){
					?>
						<div id="pesan" style="color: red; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;"><center><?php echo $error; ?></center></div>
					<?php } ?>
					
					<form method="post" id="formID" class="formular" action="<?php echo base_url() . 'main/login/doreset'; ?>">
						<input type="hidden" value="<?php echo $uuid; ?>" name="uuid">
						<div class="form-group">
							<text>
								Password :
							</text>
							<div class="form">
								<input type="password" id="" name="passwordbaru" class="validate[required] text-input" style="width:80%" value="" required>
							</div>
						</div>
						
						<div class="form-group">
							<text>
								Konfirm Password :
							</text>
							<div class="form">
								<input type="password" id="" name="konfirmpassword" class="validate[required] text-input" style="width:80%" value="" required>
							</div>
						</div>
						
						<div class="form-group">
							<text>
								&nbsp;
							</text>
							<div class="form">
								<input type="submit" value="Simpan" class='button button-blue' style="float:left;cursor:pointer"/>
								<?php //echo anchor('main/user/', 'Lanjutkan',array("class"=>"button button-blue","style"=>"float:left")) ?>
							</div>
						</div>
					</form>
				</div>
        </div>
        <div class="kanan">
            <?php echo "$menu" ?>
            <?php echo "$menu1" ?>
        </div>
        <div class="clear"></div>
    </div>
</div>
