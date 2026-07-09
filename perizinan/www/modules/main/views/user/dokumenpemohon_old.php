<?php	$base_url=base_url().'assets/userassets/pemohon/'.$username.'/dokumen/'; ?>
<style>
	.text{
		*padding-top:7px!important;
		text-align:right;
	}
	.form-group{
		padding-bottom:20px!important;
	}
	.hover:hover{
		 background-color: #30a5ff!important;
		border-color: #30a5ff!important;
	}
</style>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
			<li class="active">Dokumen Pemohon</li>
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
						<li>Klik pada tombol <button class="btn btn-primary hover">Ubah Dokumen Pemohon</button> untuk melengkapi atau mengubah berkas dokumen legalitas.<br>
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
						<div class="col-md-9">Dokumen Pemohon</div>
						<div class="col-md-3">
							<?php echo anchor('main/user/ubahdokumenpemohon', 'Ubah Dokumen Pemohon',array("class"=>"btn btn-block btn-primary")) ?>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<div class="col-md-12">
						<form role="form">
						
							<?php 
								$error 	= $this->session->flashdata("error");
								if(!empty($error)){
							?>
							<div class="alert bg-danger" role="alert" style="">
								<span class="glyphicon glyphicon-check"></span> <?php echo $error; ?>
							</div>
							<?php } ?>
							
							<?php 
								$success 	= $this->session->flashdata("success");
								if(!empty($success)){
							?>
							<div class="alert bg-success" role="alert" style="">
								<span class="glyphicon glyphicon-check"></span> <?php echo $success; ?>
							</div>
							<?php } ?>
							
							<div class="form-group">
								<label class="col-md-3 text">Scan Akta Pemohon :</label>
								<label class="col-md-9">
									<?php 
										if(!empty($data->scan_akta_pemohon)){
											echo anchor("".$base_url.$data->scan_akta_pemohon."", "Preview",array("target"=>"_blank"));
										}
									?>
								&nbsp;</label>
								
							</div>
							
							<div class="form-group">
								<label class="col-md-3 text">Nomor Akta Pemohon :</label>
								<label class="col-md-9">
									<?php echo $data->aktaPerusahaan; ?>
								&nbsp;</label>
								
							</div>
							
							<div class="form-group">
								<label class="col-md-3 text">&nbsp;</label>
								<label class="col-md-9">&nbsp;</label>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 text">Scan NPWP Pemohon :</label>
								<label class="col-md-9">
									<?php 
										if(!empty($data->scan_npwp_pemohon)){
											echo anchor("".$base_url.$data->scan_npwp_pemohon."", "<img src='".$base_url.$data->scan_npwp_pemohon."' height=100px>",array("target"=>"_blank"));
										}
									?>
									&nbsp;</label>
							</div>
						
							<div class="form-group">
								<label class="col-md-3 text">Nomor NPWP Pemohon :</label>
								<label class="col-md-9">
									<?php echo $data->npwpPerusahaan ?>
									&nbsp;</label>
							</div>
						
							<div class="form-group">
								<label class="col-md-3 text">&nbsp;</label>
								<label class="col-md-9">&nbsp;</label>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 text">Scan KTP Pemegang Kuasa :</label>
								<label class="col-md-9">
									<?php 
										if(!empty($data->scan_ktp_pemegang_kuasa)){
											echo anchor("".$base_url.$data->scan_ktp_pemegang_kuasa."", "<img src='".$base_url.$data->scan_ktp_pemegang_kuasa."' height=100px>",array("target"=>"_blank")); 
										}
									?>
									</label>
							</div>
						
							<div class="form-group">
								<label class="col-md-3 text">Nomor KTP Pemegang Kuasa :</label>
								<label class="col-md-9">
									<?php echo $data->ktpPemohon; ?>
									</label>
							</div>
						
						</div>
					</form>
				</div>
			</div>
		</div><!-- /.col-->
	</div><!-- /.row -->
	
</div><!--/.main-->
