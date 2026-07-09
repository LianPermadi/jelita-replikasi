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
<div class="col-sm-12 main">			
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
						<div class="col-md-10">Upload Formulir Step 2</div>
						<div class="col-md-2">
							<?php echo anchor('main/upload_formulir/step1', 'Kembali',array("class"=>"btn btn-block btn-primary")) ?>
						</div>
					</div>
				</div>
				
				<div class="panel-body" style="padding:0px">
					<div class="col-md-12">
						<form role="form">
							<input type="hidden" name="id" value="<?php echo $id; ?>">
							<div class="form-group">
								
								<div class="col-md-12" style="padding-bottom:25px">
									<label class="col-md-3 text">Perizinan yang Dipilih :</label>
									<label class="col-md-9" class="text2"  style="padding-bottom:40px"><?php echo $judul->n_perizinan; ?></label>
								</div>
							</div>
						</form>
							<div class="form-group" >
								<div class="col-md-12" style="padding-bottom:25px">

									<?php 
										$error	= $this->session->flashdata("error");
										if(!empty($error)){ 
									?>
										<div class="alert bg-danger" role="alert">
											<span class="glyphicon glyphicon-exclamation-sign"></span> <?php echo $error; ?></a>
										</div>
									<?php } ?>
									
									<?php 
										$success	= $this->session->flashdata("success");
										if(!empty($success)){ 
									?>
										<div class="alert bg-success" role="alert">
											<span class="glyphicon glyphicon-exclamation-sign"></span> <?php echo $success; ?></a>
										</div>
									<?php } ?>

									<?php foreach($syarat as $data){ ?>
									<form action="<?php echo base_url() . 'main/upload_formulir/doupload'; ?>" method="post" enctype="multipart/form-data">
									<div class="row" style="border-style:solid;border-width:1px 0px 0px;padding:10px 5px 10px">
									
										<div class="col-md-4" style="padding:5px">
											<?php echo $data->v_syarat; ?>
										</div>
										<div class="col-md-2" style="padding:5px;text-align:center">
											<?php 
													
												if($data->formulir=="1"){
													echo anchor('assets/userassets/formulir/'.$data->nama_formulir, 'Download Formulir',array("target"=>"_blank"));
												}
												
												if($data->formulir=="0"){
													echo "tidak memiliki formulir";
												}												
											?>
										</div>
										<div class="col-md-1" style="padding:5px;text-align:center">
											<?php 
												if($data->formulir=="1"){
													echo anchor("main/upload_formulir/hapus/".$id."/".$data->id,"Hapus",array());
												}
											?>
										</div>
										<div class="col-md-4" style="padding:5px">
											<input type="file" class="form-control FilUploader" name="formulir" required>
											<input type="hidden" name="id_syarat" value="<?php echo $data->id; ?>">
											<input type="hidden" name="id_perizinan" value="<?php echo $id; ?>">
										</div>
										<div class="col-md-1" style="padding:5px">
											<input type="submit" value="Upload" class="demo btn btn-block btn-primary lanjut">
										</div>
									
									</div>
									</form>
									<?php } ?>
									
								</div>
							</div>
							
						</div>
				</div>
			</div>
		</div><!-- /.col-->
	</div><!-- /.row -->
	
</div><!--/.main-->

<script>
	
	 $(".FilUploader").change(function () {
        var fileExtension = ['pdf'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
            alert("Hanya file pdf yang dapat anda upload");
			// $('.lanjut').css('display','none');
        }else{
			// $('.lanjut').css('display','block');
		}
    });
	
</script>