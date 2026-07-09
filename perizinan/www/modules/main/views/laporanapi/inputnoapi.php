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
			<li >Laporan API</li>
			
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
						<div class="col-md-9">Petunjuk Penggunaan Pelaporan API</div>
					</div>
				</div>
				<div class="panel-body">
					<div class="col-md-12">
						Sebelum melaporkan data API pastikan terlebih dahulu anda mengisi <b>No API</b> yang dimiliki perusahaan.<br><br>
						Ikuti petunjuk sebagai berikut :<br>
						<ol type="1">
						<li>Pastikan <a class="buton">No Api</a> yang anda inputkan sudah benar, karena <a class="buton">No Api</a> yang diinput tidak dapat diubah kembali.</li>
						<li>Jika <a class="buton">No API </a>sudah Sesuai klik tombol <a class="buton">Simpan Data </a> </li>
						<li>Jika <a class="buton">No API </a>sudah dinputkan anda akan masuk ke halaman untuk pelaporan data API</li>
						
						</ol>
					</div>
				</div>
			</div>
			
			<div class="panel panel-default">
			<!--	<div class="panel-heading">
					<div class="row">
						<div class="col-md-10">Ubah Data <?php echo ucfirst($data->jenis); ?></div>
						<div class="col-md-2">
							<?php echo anchor('main/user/datapemohon', 'Kembali',array("class"=>"btn btn-block btn-primary")) ?>
						</div>
					</div>
				</div>-->
				<div class="panel-body">
					<div class="col-md-12">
						
						
						
						
						
							<?php 
$jenis = $data->jenis;
//echo $jenis;
							if($jenis=="Pemohon"){ ?>
							

							<?php } ?>
						
						
						<form role="form" method="post" action="<?php echo base_url() . 'main/laporanapiuser/saveapi'; ?>">
						
							<?php 
								$error 	= $this->session->flashdata("error");
								if(!empty($error)){
							?>
							<div class="alert bg-danger" role="alert" style="">
								<span class="glyphicon glyphicon-check"></span> <?php echo $error; ?>
							</div>
							<?php } ?>
							<?php if($jenis=="perusahaan" || $jenis=="Perusahaan"){ ?>
							<?php
							$no_api = "";
							foreach ($data_noapi as $key => $value) {
								//echo $value->no_api;
								$no_api = $value->no_api;
							}

							if($no_api == ""){
								
							
							?>
							<div class="form-group">
								<label class="col-md-3 text">Nomor API :</label>
								<div class="col-md-9">
								<input type="hidden" class="form-control" name="id" value="<?php echo $data->id;?>" required>
									<input type="text" class="form-control" name="no_api" autofocus required><br>
								</div>
							</div>
							
							
							
							
							
							<div class="form-group">
								<label class="col-md-3 text"></label>
								<div class="col-md-2">
									<button type="submit" class="btn btn-block btn-primary" onclick="return confirm('Apakah benar NO API sudah sesuai dan akan disimpan ?');">
										Simpan Data
									</button>
									
								</div>
							</div></form>
							<?php 
							}else{
//echo 'no api kosong';
								redirect('main/laporanapiuser/dataapi', 'refresh');
							}

							} ?>
						
					</div>
				</div>
			</div>
		</div><!-- /.col-->
	</div><!-- /.row -->
	
</div><!--/.main-->
