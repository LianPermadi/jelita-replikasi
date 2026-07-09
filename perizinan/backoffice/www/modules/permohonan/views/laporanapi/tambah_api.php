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
	table{
		font-size: 10px;
	}
	.th-inner{
font-size: 10px;
font-weight: bold;

	}
</style>
<?php
$no_api = "";

							foreach ($data_noapi as $key => $value) {
								//echo $value->no_api;
								$no_api = $value->no_api;
							}
?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
			<li >Laporan API</li>
			<li >Tambah Data</li>
			
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
				<!--<div class="panel-heading">
					<div class="row">
						<div class="col-md-9">Nomor API :<a class="buton"> <?php echo $no_api;?></a></div>
					</div>
				</div>-->
				<div class="panel-body">
					<div class="col-md-12">
						Perhatian : sebelum memulai upload data pastikan <a class="buton">Nomor API </a> yang ada input sudah benar.<br> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Jika ada kesalahan saat mengisi no API segera hubungi call center di <a class="buton"> ##### </a>
					
					</div>
				</div>
			</div>
			
			<div class="panel panel-default">
			<!--	<div class="panel-heading">
					<div class="row">
						<div class="col-md-10">Ubah Data <?php echo ucfirst($data->jenis); ?></div>
						<div class="col-md-2">
							<?php //echo anchor('main/user/datapemohon', 'Kembali',array("class"=>"btn btn-block btn-primary")) ?>
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
							
							if($no_api == ""){
								
							redirect('main/laporanapiuser/inputnoapi', 'refresh');
							}else{

?>

<form action="<?php echo base_url();?>main/laporanapiuser/upload_api/" method="post" enctype="multipart/form-data">

           					<div class="form-group">
								<label class="col-md-3 text">Nomor API :</label>
								<div class="col-md-9">
								<input type="text" class="form-control" name="nomorapi" value="<?php echo $no_api;?>" readonly required>
								</div>
							</div>
 
							<div class="form-group">
								<label class="col-md-3 text">Nama Perusahaan :</label>
								<div class="col-md-9">
								<input type="text" class="form-control" name="nama" value="<?php echo $data->namaPerusahaan;?>" readonly required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 text">Alamat Perusahaan :</label>
								<div class="col-md-9">
								<input type="text" class="form-control" name="alamat" value="<?php echo $data->almtPerusahaan;?>" readonly required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 text">Jenis API :</label>
								<div class="col-md-9">
									<select class="form-control" name="jenis" required>
										<option selected="true" value="API-P">API PRODUSEN</option>
										<option  value="API-U">API UMUM</option>
									</select>
								</div>

								<div class="form-group">
								<label class="col-md-3 text">Pilih File :</label>
								<div class="col-md-9">
									<input type="file" class="form-control" name="file" required>
								</div>

							</div>
					
							
							<div class="form-group">
								<label class="col-md-3 text"></label>
								<div class="col-md-3"><br>
									<button type="submit" class="btn btn-block btn-primary">
										Kirim Data
									</button>
									
								</div>
<div class="col-md-3"><br>
									<a href="<?php echo base_url();?>main/laporanapiuser/dataapi" class="btn btn-block btn-primary">Batal</a>
									
								</div>
							</div>
							</form>
							<div class="form-group">
							<label class="col-md-9 text"> *ket : type file excel : xls,xlsx</label>
							
								<div class="col-md-3">
									<a href="<?php echo base_url();?>assets/excel_api/format.xls" class="btn btn-block btn-primary">
											Contoh Format Excel
									</a>
									
								</div>
							</div>
							<?php
							}

							} ?>
<br>
							<!--<center><a class="buton"><?php echo $data->namaPerusahaan;?></a> 
<br>
<?php echo $data->almtPerusahaan .' Telepon : '. $data->telpPerusahaan;?>
</center>-->


							
								
					</div>
				</div>
			</div>
		</div><!-- /.col-->
	</div><!-- /.row -->
	
</div><!--/.main-->

       