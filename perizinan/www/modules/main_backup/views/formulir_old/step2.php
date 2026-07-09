<style>
	.text{
		*padding-top:7px!important;
		text-align:right;
	}
	.text2{
		padding-top:7px!important;
		*text-align:right;
	}
	.syarat{
		padding:15px 10px 15px;
	}
	.justify{
		text-align:justify;
	}
</style>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
			<li >Download Formulir</li>
			<li class="active">Step 2</li>
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
						<div class="col-md-10">Download Formulir Step 2</div>
						<div class="col-md-2">
							<?php echo anchor('main/formulir/step1', 'Kembali',array("class"=>"btn btn-block btn-primary")) ?>
						</div>
					</div>
				</div>
				<div class="panel-body" style="padding:0px">
					<div class="col-md-12">
						<form role="form" method="post" enctype="multipart/form-data" action="<?php echo base_url() . 'main/permohonan/addpermohonanbaru'; ?>" onsubmit="return beforeSubmit()">
							<input type="hidden" name="id" value="<?php echo $id; ?>">
							
							<div class="form-group">
								<label class="col-md-3 text">Perizinan yang Dipilih :</label>
								<label class="col-md-9" class="text2"  style="padding-bottom:40px"><?php echo $judul->n_perizinan; ?></label>
							</div>
							
							<div class="form-group" >
								<div class="col-md-12" style="padding-bottom:25px">
									<table style="padding-bottom:100px">
										<?php foreach($syarat as $data){ ?>
											<tr style="border-style:solid;border-width:1px 0px 1px;" cellpadding="100">
												<td class="col-md-4 syarat justify">
													<?php echo $data->v_syarat; ?>
												</td>
												<td class="col-md-4 syarat justify" style="text-align:center">
													<?php 
													
													if($data->formulir=="1"){
														echo anchor('assets/userassets/formulir/'.$data->nama_formulir, 'Download Formulir',array("target"=>"_blank"));
													}
													
													if($data->formulir=="0"){
														echo "Persyaratan tidak memiliki formulir";
													}
													
													
													?>
												</td>
											</tr>
										<?php } ?>
									</table>
								</div>
							</div>
							
						</div>
					</form>
				</div>
			</div>
		</div><!-- /.col-->
	</div><!-- /.row -->
	
</div><!--/.main-->