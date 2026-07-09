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
			<li class="active">Step 4</li>
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
					<li>Permohonan diterima oleh DPMPTSP apabila nomor pendaftaran sudah diberikan oleh DPMPTSP yang dapat dilihat pada halaman <b>Status Proses</b></li> 
					<li>Jika Nomor Pendaftaran belum diberikan oleh DPMPTSP, maka akan diperlukan perbaikan persyaratan permohonan yang dikonfirmasi melalui SMS dan fitur messenger pada aplikasi</li>
					<li>Setelah mengajukan permohonan izin anda dapat mengajukan permohonan kembali. Pilih <a class="buton">YA</a> apabila ingin mengajukan permohonan lain atau pilih <a class="buton">Tidak</a> jika anda ingin menyelesaikan proses permohonan izin baru.</li>
					</ol>
					</div>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-10">Permohonan Izin Baru Step 4</div>
						<div class="col-md-2">
							<?php echo anchor('main/permohonan/step3/'.$id, 'Kembali',array("class"=>"btn btn-block btn-primary")) ?>
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
							<input type="hidden" name="sektor" value="<?php echo $sektor; ?>">
							<?php 
							
								if($jml>0){ 
									
									$size_array	= count($array_properti); 
									
									for($counter=0;$counter<$size_array;$counter++){ 
								
								?>
									
										<input type="hidden" name="<?php echo $array_properti[$counter][0]; ?>" value="<?php echo $array_properti[$counter][1]; ?>">
										<!--<input type="hidden" name="<?php echo "stat_".($counter+1); ?>" value="<?php echo $array_properti[$counter][2]; ?>">-->
									
							<?php 
							
									}
								} 
							
							?>
							
							<div class="form-group">
								<label class="col-md-3 text">Bidang Perizinan :</label>
								<label class="col-md-9" class="text2"  style="*padding-bottom:40px"><?php echo $sektor; ?></label>
							</div>
							
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
									
									<?php $oo=1; foreach($syarat as $data){ ?>
									<div class="row" style="border-style:solid;border-width:1px 0px 0px;padding:10px 5px 10px">
										<div class="col-md-6" style="font-size:20px;text-align:justify">
											<?php echo $oo.". ".$data->v_syarat; ?>
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
									<?php $oo++; } ?>
									
									<div class="row" style="border-style:solid;border-width:1px 0px 0px;padding:10px 5px 10px">
										<div class="col-md-6" style="font-size:20px;text-align:justify">
											Lokasi / Objek Izin
										</div>
										<div class="col-md-6">
											<textarea class="form-control"  name="lokasi_izin" rows="5" style="resize:vertical" required></textarea>
										</div>
									</div>
									
									<div class="row" style="border-style:solid;border-width:1px 0px 0px;padding:10px 5px 10px">
										<div class="col-md-1" style="font-size:20px;">
											<input type="checkbox" class="form-control" name="tanggung_jawab" required>
										</div>
										<div class="col-md-11" style="font-size:20px;text-align:justify">
											SAYA MENYATAKAN BERTANGGUNG JAWAB BAHWA DOKUMEN YANG DIUNGGAH ADALAH HASIL SCAN DOKUMEN ASLI
										</div>
									</div>
									
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
										Dokumen Persyaratan Akan Dikirim ke DPMPTSP dan Tidak Dapat Diubah, Lanjutkan ?
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