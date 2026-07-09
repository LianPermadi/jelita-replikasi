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
			<li class="active">Reset Password</li>
		</ol>
	</div><!--/.row-->
	

	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header"></h1>
		</div>
	</div>
			
	
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-10">Reset Password</div>
					</div>
				</div>
				<div class="panel-body">
					<div class="col-md-12">
						<form role="form" method="post" action="<?php echo base_url() . 'main/user/doreset'; ?>">
							
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
								<label class="col-md-3 text">Password Lama</label>
								<div class="col-md-9">
									<input class="form-control" placeholder="" type="password" name="password_lama" value="" required><br>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 text">Password Baru</label>
								<div class="col-md-9">
									<input class="form-control" placeholder="" type="password" name="password_baru" value="" required><br>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 text">Konfirm Password</label>
								<div class="col-md-9">
									<input class="form-control" placeholder="" type="password" name="konfirm_password" value="" required><br>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-9 text"></label>
								<div class="col-md-3">
									<button type="submit" class="btn btn-block btn-primary">
										Simpan Data
									</button>
									<?php //echo anchor("main/user/dataPerusahaan/", 'Simpan Data',array("class"=>"btn btn-block btn-primary")) ?>
								</div>
							</div>
							
						</div>
					</form>
				</div>
			</div>
		</div><!-- /.col-->
	</div><!-- /.row -->
	
</div><!--/.main-->
