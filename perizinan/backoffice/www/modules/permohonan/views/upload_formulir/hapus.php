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
<div class="col-sm-12 main">			
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
			<li >Formulir</li>
			<li class="active">Hapus</li>
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
						<div class="col-md-10">Hapus Formulir</div>
						<div class="col-md-2">
							
						</div>
					</div>
				</div>
				<div class="panel-body">
					
					<div class="alert bg-danger" role="alert" style="font-size:20px;text-align:center">
						<span class="glyphicon glyphicon-exclamation-sign"></span> Anda akan menghapus formulir pada persyaratan pada <i><?php echo $syarat->v_syarat ?></i>
					</div>
					
					<div class="" role="alert" style="font-size:20px;text-align:center">
						<div class="row">
							<div class="col-md-3">
							</div>
							<form method="post" action="<?php echo base_url() . 'main/upload_formulir/dodelete'; ?>">
							<input type="hidden" name="id_perizinan" value="<?php echo $id_perizinan; ?>">
							<input type="hidden" name="id_persyaratan" value="<?php echo $syarat->id; ?>">
							
							<div class="col-md-3">
							<input type="submit" class="btn btn-block btn-primary" style="background:#f9243f;border-color:#f9243f" value="Ya">
							</div>
							</form>
							<div class="col-md-3">
							<?php echo anchor('main/upload_formulir/step2/'.$id_perizinan, 'Tidak',array("class"=>"btn btn-block btn-primary")) ?>
							</div>
							
							<div class="col-md-3">
							</div>
						</div>
					</div>
					
				</div>	
			</div>
		</div><!-- /.col-->
	</div><!-- /.row -->
	
</div><!--/.main-->
