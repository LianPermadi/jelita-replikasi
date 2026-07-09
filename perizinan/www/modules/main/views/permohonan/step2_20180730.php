<style>
	.text{
		padding-top:7px!important;
		text-align:right;
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
			<li >Permohonan</li>
			<li class="active">Baru</li>
			<li class="active">Step 2</li>
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
						Jika sudah melengkapi dokumen legalitas, silahkan mengajukan permohonan perizinan dengan petunjuk sebagai berikut.<br>
					<ol type='1'>
					<li>Klik tombol <a class="buton">Permohonan Baru</a> kemudian pilih bidang perizinan yang akan anda ajukan kemudian klik <a class="buton">Lanjutkan</a></li>
					<li>Pilih jenis izin yang akan diajukan, klik <a class="buton">Lanjutkan</a></li>
					<li>Isi data teknis permohonan, klik <a class="buton">Lanjutkan</a></li>
					<li>Silakan mengunggah dokumen persyaratan, isi nomor, tanggal, dan masa berlaku jika terlampir pada dokumen. Dokumen yang diunggah harus berbentuk file <b>.pdf</b> berdasarkan hasil scan <b>DOKUMEN ASLI</b></li>
					<li>Mohon periksa kembali Dokumen Persyaratan yang diunggah.</li>
					<li>klik <a class="buton">Lanjutkan</a> apabila sudah yakin silahkan pilih <a class="buton">YA</a>.</li>
					<li>Permohonan diterima oleh DPMPTSP apabila nomor pendaftaran sudah diberikan oleh DPMPTSP yang dapat dilihat pada halaman <b>Status Proses</b></li> 
					<li>Jika Nomor Pendaftaran belum diberikan oleh DPMPTSP, maka akan diperlukan perbaikan persyaratan permohonan yang dikonfirmasi melalui SMS dan fitur messenger pada aplikasi</li>
					<li>Setelah mengajukan permohonan izin anda dapat mengajukan permohonan kembali. Pilih <a class="buton">YA</a> apabila ingin mengajukan permohonan lain atau pilih <a class="buton">Tidak</a> jika anda ingin menyelesaikan proses permohonan izin baru.</li>
					</ol>
					</div>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-10">Permohonan Izin Baru Step 2</div>
						<div class="col-md-2">
							<?php echo anchor('main/permohonan/step1', 'Kembali',array("class"=>"btn btn-block btn-primary")) ?>
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
											$('.lanjutkan').attr({href  : '../step3'});
										}else if(jabatan!=0){
											$('#lanjut').css('display', 'block');
											$('.lanjutkan').attr({href  : '../step3/'+jabatan});
										}
									});
								});
							</script>
							
							<div class="form-group">
								<div class="col-md-12">
									<label class="col-md-2">Bidang Perizinan :</label>
									<div class="col-md-10">
										<?php echo $bidang; ?>
									</div>
								</div>
							</div>
							
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
									<?php echo anchor('main/permohonan/step3', 'Lanjutkan',array("class"=>"btn btn-block btn-primary lanjutkan")) ?>
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
