<style>
	.text{
		padding-top:7px!important;
		text-align:right;
	}
	.text2{
		*padding-top:7px!important;
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
			<li class="active">Step 3</li>
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
					<li>Permohonan diterima oleh BPMPT apabila nomor pendaftaran sudah diberikan oleh BPMPT yang dapat dilihat pada halaman <b>Status Proses</b></li> 
					<li>Jika Nomor Pendaftaran belum diberikan oleh BPMPT, maka akan diperlukan perbaikan persyaratan permohonan yang dikonfirmasi melalui SMS dan fitur messenger pada aplikasi</li>
					<li>Setelah mengajukan permohonan izin anda dapat mengajukan permohonan kembali. Pilih <a class="buton">YA</a> apabila ingin mengajukan permohonan lain atau pilih <a class="buton">Tidak</a> jika anda ingin menyelesaikan proses permohonan izin baru.</li>
					</ol>
					</div>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-10">Permohonan Izin Baru Step 3</div>
						<div class="col-md-2">
							<?php echo anchor('main/permohonan/step2/'.$id_sektor, 'Kembali',array("class"=>"btn btn-block btn-primary")) ?>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<div class="col-md-12">
					
						<form role="form" method="post" action="<?php echo base_url() . 'main/permohonan/step4/'.$id.''; ?>">
							
							<div class="form-group">
								<div class="col-md-12">
									<label class="col-md-3 text2">Bidang Perizinan :</label>
									<label class="col-md-9"  style="*padding-bottom:40px"><?php echo $sektor; ?></label>
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-md-12">
									<label class="col-md-3 text2">Perizinan yang Dipilih :</label>
									<label class="col-md-9" class="text2"  style="padding-bottom:40px"><?php echo $judul->n_perizinan; ?></label>
								</div>
							</div>
							
							<?php /*<input type="hidden" name="jml_properti" value="<?php echo $jml; ?>"> */?>
							
							<?php /*foreach($property as $data){ ?>
								<div class="form-group">
									<label class="col-md-3 text"><?php echo $data->n_property; ?></label>
									<div class="col-md-9">
										<input class="form-control" placeholder="<?php echo $data->n_property; ?>" name="<?php echo $data->id; ?>" value="" required><br>
									</div>
								</div>
							<?php } */ ?>
						
						
							<?php 
								
								$no=1;
								$jumlah_semua = 1;
								while($no<=100){
								
								$tek = "var_teknis".$no;
								$prop = $property[$tek];
								
								
								if(empty($prop)){
									break;
								}
								
								
								$array = explode("^",$prop);
							?>
								<!--<input type="hidden" name="status_<?php echo $no; ?>" value="<?php echo $array[11]; ?>">-->
								<?php if($array[11]=="Ya"){ ?>
									<div class="form-group">
										<label class="col-md-3 text"><?php echo $array[1]; if($array[9]=="Integer"){ echo "<br><i>*input hanya angka</i>";} ?></label>
										<div class="col-md-9">
											
											<?php if($array[9]=="TextBox"){ ?>
												<!--<input class="form-control" placeholder="<?php echo $array[1]; ?>" name="var_teknis<?php echo $array[0]; ?>" value="" autocomplete="off" required><br>-->
												<input class="form-control" name="var_teknis<?php echo $array[0]; ?>" value="" autocomplete="off" required><br>
											<?php }else if($array[9]=="Integer"){ ?>
												<!--<input class="form-control numberonly" placeholder="<?php echo $array[1]; ?>" name="var_teknis<?php echo $array[0]; ?>" value="" autocomplete="off" required><br>-->
												<input class="form-control numberonly" name="var_teknis<?php echo $array[0]; ?>" value="" autocomplete="off" required><br>
											<?php }else if($array[9]=="ComboBox"){ 
												$option = explode(";",$array[10]);
											?>
													<!--<select class="form-control" name="var_teknis<?php echo $array[0]; ?>" required>-->
													<select class="form-control" name="var_teknis<?php echo $array[0]; ?>" required>
														<?php foreach($option as $op){ ?>
														<option value="<?php echo $op; ?>"><?php echo $op; ?></option>
														<?php } ?>
													</select><br>
											<?php 
												}else if($array[9]=="Tanggal"){ ?>
												<!--<input class="form-control datepicker" placeholder="<?php echo $array[1]; ?>" name="var_teknis<?php echo $array[0]; ?>" value="" autocomplete="off" required><br>-->
												<input class="form-control datepicker" name="var_teknis<?php echo $array[0]; ?>" value="" autocomplete="off" required><br>
											<?php }else{ ?>
												<?php echo $array[9];?>
											<?php } ?>
										</div>
									</div>
								<?php 
										// $jumlah_semua++;
									}else{
								?>
										<input class="form-control" type="hidden" name="var_teknis<?php echo $array[0]; ?>" value=" ">
								<?php 
									} 
								?>
							<?php 
									$no++;
									// break;
								}
							?>
							<script>
								$(function(){
									$('.numberonly').keyup(function () { 
										this.value = this.value.replace(/[^0-9\.]/g,'');
									});
								});
							</script>
							<?php if($no==1){ ?>
								<center><h2>Tidak Ada Data Properti yang Harus Anda Lengkapi, Silahkan Klik Tombol Lanjutkan</h2></center>
							<?php } ?>
						
							<input type="hidden" name="jml_properti" value="<?php echo $no-1; ?>">
							<div class="form-group">
								<label class="col-md-9 text"></label>
								<div class="col-md-3">
									<button type="submit" class="btn btn-block btn-primary">
										Lanjutkan
									</button>
									<?php //echo anchor("main/permohonan/step3/".$id."", 'Lanjutkan',array("class"=>"btn btn-block btn-primary")) ?>
								</div>
							</div>
							
						</div>
					</form>
				</div>
			</div>
		</div><!-- /.col-->
	</div><!-- /.row -->
	
</div><!--/.main-->
<script>
	$(function () {
		$('.datepicker').datepicker()
	});
</script>