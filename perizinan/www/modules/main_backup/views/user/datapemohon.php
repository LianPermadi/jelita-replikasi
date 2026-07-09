<style>
	.text{
		*padding-top:7px!important;
		text-align:right;
		vertical-align: text-top;
	}
	.form-group{
		padding-bottom:20px!important;
	}
	.buton{
		font-weight:bold;
	}
	.buton:hover{
		text-decoration:none
	}
</style>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
			<li class="active">Data Pemohon</li>
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
						Untuk pengajuan permohonan perizinan, terlebih dahulu melengkapi <b>Data Pemohon</b> dan <b>Dokumen Legalitas</b>.<br><br>
						Data pemohon dapat dilengkapi dengan cara mengikuti petunjuk sebagai berikut :<br>
						<ol type="1">
						<li>Pastikan Anda berada di halaman <b>Data Pemohon</b>.</li>
						<li>Klik tombol <a class="buton">Ubah Data Pemohon</a> di bawah petunjuk ini</li>
						<li>Lengkapi formulir atau isian yang terdapat pada halaman ini. Tekan <a class="buton">Simpan Data</a> jika telah selesai.</li>
						<li>Setelah <b>Data Pemohon</b> berhasil diubah, silahkan lanjutkan ke pengisian <b>Dokumen Legalitas</b> dengan memilih menu <a class="buton">Dokumen Pemohon</a> untuk mengunggah <b>Dokumen Legalitas</b>.</li>
						</ol>
					</div>
				</div>
			</div>
		
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-12">
							<div class="col-md-9">Data <?php echo ucfirst($data->jenis); ?></div>
							<div class="col-md-3">
								<?php echo anchor("main/user/ubahdatapemohon/", 'Ubah Data '.ucfirst($data->jenis),array("class"=>"btn btn-block btn-primary")) ?>
							</div>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<div class="col-md-12">
						<form role="form">
							<?php 
								$success 	= $this->session->flashdata("success");
								if(!empty($success)){
							?>
							<div class="alert bg-success" role="alert" style="background:#7EB332;">
								<span class="glyphicon glyphicon-check"></span> <?php echo $success; ?>
							</div>
							<?php } ?>
							
							
							
							
							
							
							<?php if($jenis=="Pemohon"){ ?>
								
							<div class="form-group">
								<div class="col-md-12">
									<label class="col-md-4 text">Nama Pemohon :</label>
									<label class="col-md-8"><?php echo $data->namaPerusahaan; ?>&nbsp;</label>
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-md-12">
									<label class="col-md-4 text">Nama Pemegang Kuasa :</label>
									<label class="col-md-8"><?php echo $data->namaPemohon; ?>&nbsp;</label>
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-md-12">
									<label class="col-md-4 text">No KTP Pemohon :</label>
									<label class="col-md-8"><?php echo $data->ktpPerusahaan; ?>&nbsp;</label>
								</div>
							</div>
						
							<div class="form-group">
								<div class="col-md-12">
									<label class="col-md-4 text">No NPWP Pemohon :</label>
									<label class="col-md-8"><?php echo $data->npwpPerusahaan; ?>&nbsp;</label>
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-md-12">
									<label class="col-md-4 text">Alamat Pemohon :</label>
									<label class="col-md-8"><?php echo $alamat_pemohon; ?>&nbsp;</label>
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-md-12">
									<label class="col-md-4 text">E-mail Pemohon :</label>
									<label class="col-md-8"><?php echo $data->emailPerusahaan; ?>&nbsp;</label>
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-md-12">
									<label class="col-md-4 text">HP Pemohon :</label>
									<label class="col-md-8"><?php echo $data->telpPerusahaan; ?>&nbsp;</label>
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-md-12">
									<label class="col-md-4 text">HP Pemegang Kuasa :</label>
									<label class="col-md-8"><?php echo $data->telpPemohon; ?>&nbsp;</label>
								</div>
							</div>
								
							<?php } ?>
							
							
							<?php if($jenis=="Perusahaan"){ ?>
							
							<div class="form-group">
								<div class="col-md-12">
									<label class="col-md-4 text">Nama Perusahaan :</label>
									<label class="col-md-8"><?php echo $data->namaPerusahaan; ?>&nbsp;</label>
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-md-12">
									<label class="col-md-4 text">Nama Direktur :</label>
									<label class="col-md-8"><?php echo $data->nama_penanggung_jawab; ?>&nbsp;</label>
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-md-12">
									<label class="col-md-4 text">Nama Pemegang Kuasa :</label>
									<label class="col-md-8"><?php echo $data->namaPemohon; ?>&nbsp;</label>
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-md-12">
									<label class="col-md-4 text">No KTP Direktur :</label>
									<label class="col-md-8"><?php echo $data->ktpPemohon; ?>&nbsp;</label>
								</div>
							</div>
						
							<div class="form-group">
								<div class="col-md-12">
									<label class="col-md-4 text">No NPWP Perusahaan :</label>
									<label class="col-md-8"><?php echo $data->npwpPerusahaan; ?>&nbsp;</label>
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-md-12">
									<label class="col-md-4 text">No Akta Perusahaan :</label>
									<label class="col-md-8"><?php echo $data->aktaPerusahaan; ?>&nbsp;</label>
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-md-12">
									<label class="col-md-4 text">Alamat Perusahaan :</label>
									<label class="col-md-8"><?php echo $alamat_pemohon; ?>&nbsp;</label>
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-md-12">
									<label class="col-md-4 text">Alamat Direktur :</label>
									<label class="col-md-8"><?php echo $alamat_penanggung_jawab; ?>&nbsp;</label>
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-md-12">
									<label class="col-md-4 text">E-mail Direktur :</label>
									<label class="col-md-8"><?php echo $data->emailPerusahaan; ?>&nbsp;</label>
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-md-12">
									<label class="col-md-4 text">E-mail Perusahaan :</label>
									<label class="col-md-8"><?php echo $data->emailPemohon; ?>&nbsp;</label>
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-md-12">
									<label class="col-md-4 text">HP Direktur :</label>
									<label class="col-md-8"><?php echo $data->telpPerusahaan; ?>&nbsp;</label>
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-md-12">
									<label class="col-md-4 text">Telp Perusahaan :</label>
									<label class="col-md-8"><?php echo $data->telp_penanggung_jawab; ?>&nbsp;</label>
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-md-12">
									<label class="col-md-4 text">HP Pemegang Kuasa :</label>
									<label class="col-md-8"><?php echo $data->telpPemohon; ?>&nbsp;</label>
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-md-12">
									<label class="col-md-4 text">Fax Perusahaan :</label>
									<label class="col-md-8"><?php echo $data->faxPerusahaan; ?>&nbsp;</label>
								</div>
							</div>
							
							<?php } ?>
							
							
							
							<?php /* ?>
							<div class="form-group">
								<div class="col-md-12">
									<label class="col-md-4 text">Nama <?php echo ucfirst($data->jenis); ?> :</label>
									<label class="col-md-8"><?php echo $data->namaPerusahaan; ?>&nbsp;</label>
								</div>
							</div>
							
							<?php if($data->jenis=="perusahaan"){ ?>
							<div class="form-group">
								<div class="col-md-12">
									<label class="col-md-4 text">Nama Direktur :</label>
									<label class="col-md-8"><?php echo $data->nama_penanggung_jawab; ?>&nbsp;</label>
								</div>
							</div>
							<?php } ?>
							
							<div class="form-group">
								<div class="col-md-12">
									<label class="col-md-4 text">Nama Pemegang Kuasa :</label>
									<label class="col-md-8"><?php echo $data->namaPemohon; ?>&nbsp;</label>
								</div>
							</div>
							
							<?php if($data->jenis=="pemohon"){ ?>
							<div class="form-group">
								<div class="col-md-12">
									<label class="col-md-4 text">No KTP Pemohon :</label>
									<label class="col-md-8"><?php echo $data->aktaPerusahaan; ?>&nbsp;</label>
								</div>
							</div>
							<?php } ?>
							
							<div class="form-group">
								<div class="col-md-12">
									<label class="col-md-4 text">No KTP Pemegang Kuasa :</label>
									<label class="col-md-8"><?php echo $data->ktpPemohon; ?>&nbsp;</label>
								</div>
							</div>
						
							<div class="form-group">
								<div class="col-md-12">
									<label class="col-md-4 text">No NPWP <?php echo ucfirst($data->jenis); ?> :</label>
									<label class="col-md-8"><?php echo $data->npwpPerusahaan; ?>&nbsp;</label>
								</div>
							</div>
							
							<?php if($data->jenis=="perusahaan"){ ?>
							<div class="form-group">
								<div class="col-md-12">
									<label class="col-md-4 text">No Akta Perusahaan :</label>
									<label class="col-md-8"><?php echo $data->aktaPerusahaan; ?>&nbsp;</label>
								</div>
							</div>
							<?php } ?>
							
							<div class="form-group">
								<div class="col-md-12">
									<label class="col-md-4 text">Alamat <?php echo ucfirst($data->jenis); ?> :</label>
									<label class="col-md-8"><?php echo $alamat_pemohon; ?>&nbsp;</label>
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-md-12">
									<label class="col-md-4 text">Alamat Pemegang Kuasa :</label>
									<label class="col-md-8"><?php echo $alamat_penanggung_jawab; ?>&nbsp;</label>
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-md-12">
									<label class="col-md-4 text">E-mail <?php echo ucfirst($data->jenis); ?> :</label>
									<label class="col-md-8"><?php echo $data->emailPerusahaan; ?>&nbsp;</label>
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-md-12">
									<label class="col-md-4 text">E-mail Pemegang Kuasa :</label>
									<label class="col-md-8"><?php echo $data->emailPemohon; ?>&nbsp;</label>
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-md-12">
									<label class="col-md-4 text">HP <?php echo ucfirst($data->jenis); ?> :</label>
									<label class="col-md-8"><?php echo $data->telpPerusahaan; ?>&nbsp;</label>
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-md-12">
									<label class="col-md-4 text">HP Pemegang Kuasa :</label>
									<label class="col-md-8"><?php echo $data->telpPemohon; ?>&nbsp;</label>
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-md-12">
									<label class="col-md-4 text">Fax <?php echo ucfirst($data->jenis); ?> :</label>
									<label class="col-md-8"><?php echo $data->faxPerusahaan; ?>&nbsp;</label>
								</div>
							</div>
							
							<?php */ ?>
							
						</div>
					</form>
				</div>
			</div>
		</div><!-- /.col-->
	</div><!-- /.row -->
	
</div><!--/.main-->
