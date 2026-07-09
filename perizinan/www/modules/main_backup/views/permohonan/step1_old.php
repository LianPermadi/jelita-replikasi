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
			<li >Permohonan</li>
			<li class="active">Baru</li>
			<li class="active">Step 1</li>
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
						Jika sudah melengkapi dokumen legalitas, silakan mulai mengajukan permohonan perizinan.<br>
						<ol type='1'>
						<li>Klik tombol <button class="btn btn-primary">Permohonan Baru</button> kemudian pilih perizinan yang akan anda ajukan, klik <button class="btn btn-primary">Lanjutkan</button></li>
						<li>Isi data teknis permohonan, klik <button class="btn btn-primary">Lanjutkan</button></li>
						<li>Silakan mengunggah dokumen persyaratan, isi nomor, tanggal, dan masa berlaku jika terlampir pada dokumen. Dokumen yang diunggah harus berbentuk file .pdf</li>
						<li>Mohon periksa kembali kelengkapan yang telah anda isikan (Dibuat Bold/Underline).</li>
						<li>klik <button class="btn btn-primary">Lanjutkan</button> apabila sudah yakin silahkan pilih <button class="btn btn-primary">YA</button>.</li>
						<li>Permohonan sudah diterima oleh BPMPT apabila nomor pendaftaran sudah diberikan oleh BPMPT yang dapat dilihat di status proses</li> 
						<li>Jika Nomor Pendaftaran belum diberikan, maka akan ada perbaikan proses permohonan yang dikonfirmasi melalui sms dan fitur messenger pada aplikasi</li> 
						<li>Selamat, permohonan anda sudah berhasil diajukan.</li> 
						</ol>
						<br>
						<p align="center">Setelah mengajukan permohonan izin anda dapat mengajukan permohonan kembali. Pilih ya apabila ingin mengajukan permohonan lain, pilih tidak jika anda ingin menyelesaikan proses permohonan izin baru.</p>
					</div>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-10">Permohonan Izin Baru Step 1</div>
						<div class="col-md-2">
							<?php echo anchor('main/user/permohonan', 'Kembali',array("class"=>"btn btn-block btn-primary")) ?>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<div class="col-md-12">
						<?php if($data->data=="0"){ ?>
						<div class="alert bg-warning" role="alert">
							<span class="glyphicon glyphicon-warning-sign"></span> Anda Belum Melengkapi Data Pemohon, <?php echo anchor('main/user/datapemohon', 'Klik Disini Untuk Melengkapi !',array("style"=>"color:white")) ?>
						</div>
						<?php } ?>
						<?php if($data->dokumen=="0"){ ?>
						<div class="alert bg-warning" role="alert">
							<span class="glyphicon glyphicon-warning-sign"></span> Anda Belum Melengkapi Dokumen Pemohon, <?php echo anchor('main/user/dokumenpemohon', 'Klik Disini Untuk Melengkapi !',array("style"=>"color:white")) ?>
						</div>
						<?php } ?>
						<?php 
							$error	= $this->session->flashdata("error");
							if(!empty($error)){ 
						?>
							<div class="alert bg-danger" role="alert">
								<span class="glyphicon glyphicon-exclamation-sign"></span> <?php echo $error; ?></a>
							</div>
						<?php } ?>
						<form role="form">
							
							
							<script>
								$(document).ready(function(){
									$("#basic").change(function(){
										var jabatan = $("#basic").val();
										//alert(jabatan);
										if(jabatan==0){
											$('#lanjut').css('display', 'none');
											$('.lanjutkan').attr({href  : 'step2'});
										}else if(jabatan!=0){
											$('#lanjut').css('display', 'block');
											$('.lanjutkan').attr({href  : 'step2/'+jabatan});
										}
									});
								});
							</script>
							
							<div class="form-group">
								<label class="col-md-2 text">Pilih Perizinan :</label>
								<div class="col-md-10">
									<select id="basic" class="selectpicker form-control" data-live-search="true" style="background:white">
									  <option value="0">&nbsp;</option>
									  <?php foreach($perizinan as $row){ ?>
									  <option value="<?php echo $row->id; ?>"><?php echo $row->n_perizinan; ?></option>
									  <?php } ?>
									</select>
									<br><br>
								</div>
							</div>
							<?php if($data->dokumen=="1" && $data->data=="1"){ ?>
							<div class="form-group" style="display:none" id="lanjut">
								<label class="col-md-9 text"></label>
								<div class="col-md-3">
									<?php echo anchor('main/permohonan/step2', 'Lanjutkan',array("class"=>"btn btn-block btn-primary lanjutkan")) ?>
								</div>
							</div>
							<?php } ?>
						</div>
					</form>
				</div>
			</div>
		</div><!-- /.col-->
	</div><!-- /.row -->
	
</div><!--/.main-->
