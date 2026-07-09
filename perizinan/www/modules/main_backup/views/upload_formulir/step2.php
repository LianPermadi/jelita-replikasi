<style>
	.text{
		padding-top:7px!important;
		text-align:right;
	}
	.text2{
		*padding-top:7px!important;
		text-align:right;
	}
</style>
<div class="col-sm-12  main">			
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
			<li >Upload Formulir</li>
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
						<?php echo anchor('main/upload_formulir/step1', 'Kembali',array("class"=>"btn btn-block btn-primary")) ?>
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
								<label class="col-md-2 text2">Bidang Perizinan :</label>
								<div class="col-md-10">
									<?php echo $sektor->n_sektor ?>
								</div>
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-md-12">
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
							</div>
							
							<div class="form-group" style="display:none" id="lanjut">
								<div class="col-md-12">
								<label class="col-md-9 text"></label>
								<div class="col-md-3">
									<?php echo anchor('main/upload_formulir/step3', 'Lanjutkan',array("class"=>"btn btn-block btn-primary lanjutkan")) ?>
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
