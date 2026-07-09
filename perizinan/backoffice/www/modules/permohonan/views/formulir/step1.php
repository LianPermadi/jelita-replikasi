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
			<li >Download Formulir</li>
			<li class="active">Step 1</li>
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
						<div class="col-md-10">Download Formulir Step 1</div>
						<div class="col-md-2">
						</div>
					</div>
				</div>
				<div class="panel-body">
					<div class="col-md-12">
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
								<div class="col-md-12">
								<label class="col-md-3 text">Pilih Bidang Perizinan :</label>
								<div class="col-md-9">
									<select id="basic" class="selectpicker form-control" data-live-search="true" style="background:white">
									  <option value="0">&nbsp;</option>
									  <?php foreach($perizinan as $row){ ?>
									  <option value="<?php echo $row->id; ?>"><?php echo $row->n_sektor; ?></option>
									  <?php } ?>
									</select>
									<br><br>
								</div>
								</div>
							</div>
							<div class="form-group" style="display:none" id="lanjut">
								<div class="col-md-12">
								<label class="col-md-9 text"></label>
								<div class="col-md-3">
									<?php echo anchor('main/formulir/step2', 'Lanjutkan',array("class"=>"btn btn-block btn-primary lanjutkan")) ?>
								</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div><!-- /.col-->
	</div><!-- /.row -->
	
</div><!--/.main-->
