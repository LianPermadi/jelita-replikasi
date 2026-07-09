<style>
	.text{
		padding-top:7px!important;
		text-align:right;
	}
</style>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
			<li >Dokumen Pemohon</li>
			<li class="active">Ubah</li>
		</ol>
	</div><!--/.row-->
	

	<div class="row">
		<div class="col-lg-12">
			<!--h1 class="page-header"></h1-->
		</div>
	</div>
			
	
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-9">Petunjuk Penggunaan</div>
					</div>
				</div>
				<div class="panel-body">
					<div class="col-md-12">
						Jika sudah mengisi data pemohon, silakan lengkapi dokumen legalitas dengan mengunggah dokumen yang dibutuhkan.<br>
						Jumlah dokumen yang harus dilengkapi ada 3 (tiga), dibawah setiap data dokumen terdapat data yang telah Anda isi sebelumnya yang bertujuan untuk memudahkan proses pembacaan.<br>
						<br>Adapun petunjuk untuk mengunggah dokumen yang diperlukan, antara lain :<br>
						<ol type="1">
						<li>Klik pada tombol <button class="btn btn-primary">Ubah Dokumen Pemohon</button> untuk melengkapi atau mengubah berkas dokumen legalitas.<br>
						    <b>Catatan</b> : <br>
						   &emsp;- Jika pemohon izin adalah perorangan, maka dokumen NPWP sifatnya tidak wajib dan dokumen akta dapat dikosongkan. <br>
						   &emsp;- Jika pemohon izin adalah perusahaan, maka wajib mengisi seluruh dokumen legalitas.</li>
						<li>Jika dokumen telah dipilih, maka tekan tombol <button class="btn btn-primary">Simpan Data</button> untuk mengunggah dokumen.</li>
						<li>Jika data telah berhasil diunggah silakan melanjutkan ke pengajuan permohonan perizinan dengan memilih menu <b>Permohonan Perizinan</b>.</li>
						</ol>
					</div>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-10">Dokumen Pemohon</div>
						<div class="col-md-2">
							<?php echo anchor('main/user/dokumenpemohon', 'Kembali',array("class"=>"btn btn-block btn-primary")) ?>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<div class="col-md-12">
						<form role="form" method="post" enctype="multipart/form-data" action="<?php echo base_url() . 'main/user/doeditdokumen'; ?>">
							
							<?php 
								$error 	= $this->session->flashdata("error");
								if(!empty($error)){
							?>
							<div class="alert bg-danger" role="alert" style="">
								<span class="glyphicon glyphicon-check"></span> <?php echo $error; ?>
							</div>
							<?php } ?>
							
							<div class="form-group">
								<label class="col-md-3 text">Scan Akta Pemohon :<br>*file berbentuk pdf<br>*wajib diisi bagi perusahaan</label>
								<div class="col-md-9">
									<input type="file" name="akta" class="uploadakta">
									 <p class="help-block">Silahkan Upload Scan Akta Terakhir Perusahaan</p><br>
								</div>
							</div>
						
							<div class="form-group">
								<label class="col-md-3 text">Scan NPWP Pemohon :<br>*file berbentuk gambar<br>*wajib diisi bagi perusahaan</label>
								<div class="col-md-9">
									<input type="file" name="npwp" class="uploadgambar">
									 <p class="help-block">Silahkan Upload Scan NPWP Terakhir Perusahaan</p><br>
								</div>
							</div>
						
							<div class="form-group">
								<label class="col-md-3 text">Scan KTP Pemegang Kuasa :<br>*file berbentuk gambar</label>
								<div class="col-md-9">
									<input type="file" name="ktp" class="uploadgambar">
									 <p class="help-block">Silahkan Upload Scan KTP Terakhir Penanggung Jawab</p><br>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-9 text"></label>
								<div class="col-md-3">
									<button type="submit" class="btn btn-block btn-primary">
										Simpan Data
									</button>
									<?php // echo anchor('main/user/dokumenperusahaan', 'Simpan Data',array("class"=>"btn btn-block btn-primary")) ?>
								</div>
							</div>
							
						</div>
					</form>
				</div>
			</div>
		</div><!-- /.col-->
	</div><!-- /.row -->
	
</div><!--/.main-->
<script>

	$(".uploadakta").change(function () {
        var fileExtension = ['pdf'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
            alert("Hanya file pdf yang dapat anda upload");
			// $('.lanjut').css('display','none');
        }else{
			// $('.lanjut').css('display','block');
		}
    });
	
	$(".uploadgambar").change(function () {
        var fileExtension 	= ['jpg'];
        var fileExtension2	= ['jpeg'];
        var fileExtension3	= ['png'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1 && $.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension2) == -1 && $.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension3) == -1) {
            alert("Hanya file gambar yang dapat anda upload");
			// $('.lanjut').css('display','none');
        }else{
			// $('.lanjut').css('display','block');
		}
    });

</script>