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
						Jika sudah melengkapi dokumen legalitas, silakan mulai mengajukan permohonan perizinan.<br>
					<ol type='1'>
					<li>Klik tombol <button class="btn btn-primary">Permohonan Baru</button> kemudian pilih perizinan yang akan anda ajukan, klik <button class="btn btn-primary">Lanjutkan</button></li>
					<li>Isi data teknis permohonan, klik <button class="btn btn-primary">Lanjutkan</button></li>
					<li>Silakan mengunggah dokumen persyaratan, isi nomor, tanggal, dan masa berlaku jika terlampir pada dokumen. Dokumen yang diunggah harus berbentuk file .pdf</li>
					<li>Mohon periksa kembali kelengkapan yang telah anda isikan (Dibuat Bold/Underline).</li>
					<li>klik <button class="btn btn-primary">Lanjutkan</button> apabila sudah yakin silahkan pilih <button class="btn btn-primary">YA</button>.</li>
					<li>Permohonan sudah diterima oleh BPMPT apabila nomor pendaftaran sudah diberikan oleh BPMPT yang dapat dilihat di status proses</li> 
					<li>Jika Nomor Pendaftaran belum diberikan, maka akan ada perbaikan proses permohonan yang dikonfirmasi melalui sms dan fitur messenger pada aplikasi</li> 
					<li>Selamat, permohonan anda sudah berhasil diajukan.</li> 
					</ol>

						<br>
						<p align="center">Setelah mengajukan permohonan izin anda dapat mengajukan permohonan kembali. Pilih ya apabila ingin mengajukan permohonan lain, pilih tidak jika anda ingin menyelesaikan proses permohonan izin baru.</p>
					</div>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-10">Permohonan Izin Baru Step 3</div>
						<div class="col-md-2">
							<?php echo anchor('main/permohonan/step2/'.$id, 'Kembali',array("class"=>"btn btn-block btn-primary")) ?>
						</div>
					</div>
				</div>
				<div class="panel-body" style="padding:0px">
					<div class="col-md-12">
						<form role="form" method="post" enctype="multipart/form-data" action="<?php echo base_url() . 'main/permohonan/addpermohonanbaru'; ?>" onsubmit="return beforeSubmit()">
							<input type="hidden" name="id" value="<?php echo $id; ?>">
							<input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
							<input type="hidden" name="id_pemohon" value="<?php echo $id_pemohon; ?>">
							<input type="hidden" name="jml_properti" value="<?php echo $jml; ?>">
							<?php 
							
								if($jml>0){ 
									
									$size_array	= count($array_properti); 
									
									for($counter=0;$counter<$size_array;$counter++){ 
								
								?>
									
										<input type="hidden" name="<?php echo $array_properti[$counter][0]; ?>" value="<?php echo $array_properti[$counter][1]; ?>">
									
							<?php 
							
									}
								} 
							
							?>
							
							<div class="form-group">
								<label class="col-md-3 text">Perizinan yang Dipilih :</label>
								<label class="col-md-9" class="text2"  style="padding-bottom:40px"><?php echo $judul->n_perizinan; ?></label>
							</div>
							
							<div class="form-group" >
								<label class="col-md-4">&nbsp;</label>
								<label class="col-md-4" style="padding-bottom:30px"><center>Silahkan Lengkapi Persyaratan Berikut :<br>*file berbentuk pdf</center></label>
								<label class="col-md-4">&nbsp;</label>
							</div>
							
							<div class="form-group" >
								<div class="col-md-12" style="padding-bottom:25px">
								
									<?php foreach($syarat as $data){ ?>
									<div class="row" style="border-style:solid;border-width:1px 0px 0px;padding:10px 5px 10px">
										<div class="col-md-6" style="font-size:20px;text-align:justify">
											<?php echo $data->v_syarat; ?>
											<?php 
												$ada = 0;
												
												/*
												if (in_array($data->id, $array_syarat)) {
													echo "<br><b>*data persyaratan sudah ada pada sistem kami, silahkan upload persyaratan terbaru jika ada</b>";
													$ada=1;
													
													$da	=	$this->db->get_where("tm_pemohon_persyaratan",array("id_pemohon"=>$user_id,"id_persyaratan"=>$data->id))->first_row();
													
												}
												*/
											?>
										</div>
										<div class="col-md-6">
										
											Berkas Persyaratan<input type="file" name="<?php echo "file_".$data->id; ?>" class="form-control FilUploader" 
											<?php 
												
												// if (in_array($data->id, $array_syarat)) {
												// }else{
													echo " required";
												// }
												
											?>
											>
											<div class="row" style="padding-top:10px">
											
												<div class="col-md-4">
													Nomor Surat<input type="text" name="<?php echo "nomor_surat_".$data->id; ?>" class="form-control" >
												</div>
												<div class="col-md-4">
													Tanggal<input type="text" name="<?php echo "tanggal_".$data->id; ?>" class="form-control datepicker" >
												</div>
												<div class="col-md-4">
													Masa Berlaku<input type="text" name="<?php echo "masa_berlaku_".$data->id; ?>" class="form-control datepicker" >
													<input type="hidden" name="<?php echo "teknis".$data->id; ?>" value="<?php echo $ada; ?>">
												</div>
											</div>
										</div>
									</div>
									<?php } ?>
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-md-12" style="padding-bottom:25px">
									<label class="col-md-9 text"></label>
									<div class="col-md-3">
										<?php //echo anchor('main/permohonanbaru/step3', 'Lanjutkan',array("class"=>"btn btn-block btn-primary")) ?>
										<!-- <a href="#static" data-toggle="modal" class="demo btn btn-block btn-primary">Lanjutkan</a> -->
										<input type="submit" value="Lanjutkan" class="demo btn btn-block btn-primary lanjut">
									</div>
								</div>
							</div>
							
							<div id="static" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" style="display: none;">
								<div class="modal-body">
									<p>
										Dokumen Persyaratan Akan Dikirim ke BPMPT dan Tidak Dapat Diubah, Lanjutkan ?
									</p>
								</div>
								<div class="modal-footer">
									<button type="button" data-dismiss="modal" class="btn btn-default" onClick="doConfirm(false)">
										Tidak
									</button>
									<!--
									<button type="submit" data-dismiss="modal" class="btn btn-primary">
										Ya
									</button>-->
									<button type="button" data-dismiss="modal" class="btn btn-default" onClick="doConfirm(true)">
										Ya
									</button>
									<?php //echo anchor('main/user/permohonan', 'Ya',array("class"=>"btn btn-primary")) ?>
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
	
	 $(".FilUploader").change(function () {
        var fileExtension = ['pdf'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
            alert("Hanya file pdf yang dapat anda upload");
			// $('.lanjut').css('display','none');
        }else{
			// $('.lanjut').css('display','block');
		}
    });
	
	function doConfirm(flag){
	  return flag;
	  // alert(flag);
	 }
	
	function beforeSubmit() {
		if (confirm("Anda yakin akan mengupload data persyaratan ?")) {
			return true;
		} 
		return false;
	}
	
	$(function () {
		$('.datepicker').datepicker()
	});
</script>