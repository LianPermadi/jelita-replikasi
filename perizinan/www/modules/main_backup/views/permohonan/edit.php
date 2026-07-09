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
						<ol type='1'>
							<li>Baca dahulu pesan yang diterima sebagai informasi yang membutuhkan revisi persyaratan pada <b>Asistensi Perizinan</b></li>
							<li>Unggah kembali persyaratan yang membutuhkan revisi dari BPMPT dan lengkapi data tambahan jika diperlukan</li>
							<li>Revisi persyaratan hanya dapat digunakan 1 kali upload data, pastikan anda mengunggah semua data persyaratan yang membutuhkan revisi</li>
							<li>Jika sudah, maka tekan tombol <a class="buton">Upload</a> dan pilih <b>ok</b></li>
							<li>Setelah merevisi persyaratan, pemohon dapat mengirim pesan kembali kepada BPMPT sebagai konfirmasi</li>
						</ol>
						<br>
					</div>
				</div>
			</div>
			
			
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-10">Asistensi Perizinan</div>
						<div class="col-md-2">
							<?php echo anchor('main/user/permohonan', 'Kembali',array("class"=>"btn btn-block btn-primary")) ?>
						</div>
					</div>
				</div>
				<div class="panel-body">
					
					<?php if(empty($permohonan->no_permohonan)){ ?>
					<form action="<?php echo base_url() . 'main/permohonan/addasistensi'; ?>#" method="post">
					
							<div class="form-group">
								<div class="col-md-12">
								<?php 
									$success 	= $this->session->flashdata("success");
									if(!empty($success)){
								?>
								<div class="alert bg-success" role="alert" style="background:#7EB332;">
									<span class="glyphicon glyphicon-check"></span> <?php echo $success; ?>
								</div>
								<?php } ?>
								<?php 
									$error 	= $this->session->flashdata("error");
									if(!empty($error)){
								?>
								<div class="alert bg-danger" role="alert" style="">
									<span class="glyphicon glyphicon-check"></span> <?php echo $error; ?>
								</div>
								<?php } ?>
								</div>
							</div>
						<div class="row">						
							<div class="form-group">
								<label class="col-md-2 text">Pesan Anda :</label>
								<div class="col-md-8"><input type="text" name="pesan" class="form-control" ></div>
								<input type="hidden" value="<?php echo $pemohon; ?>" name="pemohon">
								<input type="hidden" value="<?php echo $permohonan->uuid; ?>" name="uuid">
								<div class="col-md-2"><input type="submit" class="btn btn-block btn-primary" value="Kirim"></div>
							</div>
						</div>
					</form>
					<?php } ?>
					
					<table data-toggle="table"  data-search="true" data-pagination="true" data-sort-name="tanggal" data-sort-order="desc">
						<thead>
						<tr>
							<th data-field="name"  data-sortable="true" >Pesan</th>
							<th data-field="tanggal"  data-sortable="true" >Tanggal</th>
							<th data-field="oleh"  data-sortable="true" >Oleh</th>
						</tr>
						</thead>
						<tbody>
							<?php foreach($asistensi as $pesan){ ?>
								<tr>
									<td>
										<?php echo $pesan->pesan; ?>
									</td>
									<td>
										<?php echo date("H:i:s",strtotime($pesan->tanggal))." ".date("d M y",strtotime($pesan->tanggal)); ?>
									</td>
									<td>
										<?php 
										    $oleh = $pesan->oleh;
											if(substr($oleh, 0, 1) == '*') $oleh = 'Verifikatur';
										    echo $oleh; 
										?>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
					
				</div>	
			</div>
			
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-10">Ubah Syarat Permohonan Izin</div>
						<div class="col-md-2">
						
						</div>
					</div>
				</div>
				<div class="panel-body">
						<form role="form" method="post" enctype="multipart/form-data" action="<?php echo base_url() . 'main/permohonan/editpermohonanbaru'; ?>" onsubmit="return beforeSubmit()">
							<input type="hidden" name="id" value="<?php echo $id; ?>">
							<input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
							<input type="hidden" name="uuid" value="<?php echo $uuid; ?>">
							
							<div class="form-group">
								<div class="col-md-12">
									<label class="col-md-3 text">Perizinan :</label>
									<label class="col-md-9" class="text2"  style="padding-bottom:40px"><?php echo $judul; ?></label>
								</div>
							</div>
							
							<div class="form-group" >
								<div class="col-md-12">
									<label class="col-md-4">&nbsp;</label>
									<label class="col-md-4" style="padding-bottom:30px"><center>Silahkan Lengkapi Persyaratan Berikut :<br>*file berbentuk pdf</center></label>
									<label class="col-md-4">&nbsp;</label>
								</div>
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
										
											Berkas Persyaratan<input type="file" name="<?php echo "file_".$data->id; ?>" class="form-control FilUploader">
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
										<input type="submit" value="Upload" class="demo btn btn-block btn-primary lanjut">
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