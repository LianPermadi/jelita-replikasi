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
							Selamat, Akun Anda Telah Selesai<br>
							Silahkan cek Email dan Handphone Anda Untuk Menerima Username dan Password Anda
						</h1>
					</center>
				</div>
				
				<div class="form-group">
					<center>
						<?php echo anchor('main/login', 'Ke Halaman Login',array("class"=>"button button-blue","style"=>"float:center;margin-right:247px")) ?>
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
