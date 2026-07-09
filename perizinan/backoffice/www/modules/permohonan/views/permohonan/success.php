<style>
	.text{
		*padding-top:7px!important;
		text-align:right;
	}
	.text2{
		padding-top:7px!important;
		text-align:right;
	}
</style>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
			<li >Permohonan</li>
			<li class="active">Sukses</li>
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
						<div class="col-md-10">Permohonan Berhasil Diajukan</div>
						<div class="col-md-2">
							
						</div>
					</div>
				</div>
				<div class="panel-body">
					
					<div class="alert bg-success" role="alert" style="background:#7EB332;font-size:20px;text-align:center">
						<span class="glyphicon glyphicon-check"></span> Selamat Permohonan Anda Telah Berhasil Diajukan, silahkan menunggu konfirmasi penerimaan dari DPMPTSP.<br>Permohonan diterima setelah mendapatkan nomor pendaftaran dari DPMPTSP.<br>Terima Kasih
					</div>
					
					<div class="" role="alert" style="font-size:20px;text-align:center">
						Apakah anda ingin mengajukan permohonan lainnya ? 
						<?php echo anchor('main/permohonan/step1', 'Ya',array("class"=>"btn  btn-primary")) ?>
						<?php echo anchor('main/user/permohonan/', 'Tidak',array("class"=>"btn btn-primary")) ?>
					</div>
					
				</div>	
			</div>
		</div><!-- /.col-->
	</div><!-- /.row -->
	
</div><!--/.main-->
