<style>
	.text{
		padding-top:7px!important;
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
			<li >Data Pemohon</li>
			<li class="active">Ubah</li>
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
						Untuk pengajuan permohonan perizinan, terlebih dahulu melengkapi <b>Data Pemohon</b> dan <b>Dokumen Legalitas</b>.<br><br>
						Data pemohon dapat dilengkapi dengan cara mengikuti petunjuk sebagai berikut :<br>
						<ol type="1">
						<li>Pastikan Anda berada di halaman <b>Data Pemohon</b>.</li>
						<li>Klik tombol <a class="buton">Ubah Data Pemohon</a> di bawah petunjuk ini</li>
						<li>Lengkapi formulir atau isian yang terdapat pada halaman ini. Tekan <a class="buton">Simpan Data</a> jika telah selesai.</li>
						<li>Setelah <b>Data Pemohon</b> berhasil diubah, silahkan lanjutkan ke pengisian <b>Dokumen Legalitas</b> dengan memilih menu <a class="buton">Dokumen Pemohon</a> untuk mengunggah <b>Dokumen Legalitas</b>.</li>
						</ol>
					</div>
				</div>
			</div>
			
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-10">Ubah Data <?php echo ucfirst($data->jenis); ?></div>
						<div class="col-md-2">
							<?php echo anchor('main/user/datapemohon', 'Kembali',array("class"=>"btn btn-block btn-primary")) ?>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<div class="col-md-12">
						<form role="form" method="post" action="<?php echo base_url() . 'main/user/doeditdata'; ?>">
						
							<?php 
								$error 	= $this->session->flashdata("error");
								if(!empty($error)){
							?>
							<div class="alert bg-danger" role="alert" style="">
								<span class="glyphicon glyphicon-check"></span> <?php echo $error; ?>
							</div>
							<?php } ?>
						
						
						
						
							<?php if($jenis=="Pemohon"){ ?>
							<div class="form-group">
								<label class="col-md-3 text">Nama Pemohon :</label>
								<div class="col-md-9">
									<input class="form-control" placeholder="" name="nama_pemohon" value="<?php echo $data->namaPerusahaan; ?>" required><br>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 text">Nama Pemegang Kuasa :</label>
								<div class="col-md-9">
									<input class="form-control" name="nama_pemegang_kuasa" value="<?php echo $data->namaPemohon; ?>"><sup><i>Boleh Dikosongkan</i></sup><br>
								</div>
							</div>
						
							<div class="form-group">
								<label class="col-md-3 text">No KTP Pemohon :</label>
								<div class="col-md-9">
									<input class="form-control numberonly" maxlength="16" placeholder="" name="no_ktp_pemohon" value="<?php echo $data->ktpPerusahaan; ?>" required><br>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 text">No NPWP Pemohon :</label>
								<div class="col-md-9">
									<input class="form-control" placeholder="" maxlength="20" name="no_npwp_pemohon" value="<?php echo $data->npwpPerusahaan; ?>"><sup><i>Boleh Dikosongkan</i></sup><br>
								</div>
							</div>
							
							<center><h4>Alamat Pemohon </h4></center>
							
							<div class="form-group">
								<label class="col-md-3 text">Provinsi :</label>
								<div class="col-md-9">
									<select class="form-control provinsi2" name="provinsi2" required>
										<?php foreach($propinsi2 as $prov){ ?>
											<option value="<?php echo $prov->kd_prov; ?>" <?php if($prov->kd_prov==$data->propinsi2){ echo "selected";} ?>><?php echo $prov->n_propinsi; ?></option>
										<?php } ?>
									</select><br>
								</div>
							</div>
							
							<script>
							$(function(){
								$('.provinsi2').on('change', function(e){
									var provinsi = $(".provinsi2").val();
									$.ajax({
										url : "../pendaftaranbaru/getkabupaten",
										type: "post",
										data:{"data":provinsi},
										success : function(data){
											$(".kabupaten2").html('');
											var myarray = JSON.parse(data);
											var myarray = myarray.split(",");

											for (i=0;i<myarray.length;i++)
											{
												if(myarray[i] != myarray[i+1])
												{
													var myarray2 = myarray[i].split("|");
													var optn2 = document.createElement("OPTION");
													
													optn2.text = myarray2[1];
													optn2.value = myarray2[0];
													$(".kabupaten2").append(optn2);
												}
											}
										}
									});
									
									$(".kecamatan2").html('');
									var optn2 = document.createElement("OPTION");
									optn2.text = "------------------------ Pilih Kecamatan ------------------------";
									optn2.value = "";
									$(".kecamatan2").append(optn2);
									
									$(".kelurahan2").html('');
									var optn2 = document.createElement("OPTION");
									optn2.text = "------------------------ Pilih Kelurahan ------------------------";
									optn2.value = "";
									$(".kelurahan2").append(optn2);
									
								});
							});
						</script>
							
							<div class="form-group">
								<label class="col-md-3 text">Kabupaten / Kota :</label>
								<div class="col-md-9">
									<select class="form-control kabupaten2" name="kabupaten2" required>
										<option  value="">------------------------ Pilih Kabupaten / Kota ------------------------</option>
								
										<?php foreach($kabupaten2 as $kab){ ?>
											<option value="<?php echo $kab->id; ?>" <?php if($kab->id==$data->kabupaten2){ echo "selected";} ?>><?php echo $kab->n_kabupaten; ?></option>
										<?php } ?>
									</select><br>
								</div>
							</div>
							
							<script>
								$(function(){
									$('.kabupaten2').on('change', function(e){
										var kabupaten = $(".kabupaten2").val();
										$.ajax({
											url : "../pendaftaranbaru/getkecamatan",
											type: "post",
											data: "data="+kabupaten,
											success : function(data){
												$(".kecamatan2").html('');
												var myarray = JSON.parse(data);
												var myarray = myarray.split(",");

												for (i=0;i<myarray.length;i++)
												{
													if(myarray[i] != myarray[i+1])
													{
														var myarray2 = myarray[i].split("|");
														var optn2 = document.createElement("OPTION");
														
														optn2.text = myarray2[1];
														optn2.value = myarray2[0];
														$(".kecamatan2").append(optn2);
													}
												}
											}
										});
										
										$(".kelurahan2").html('');
										var optn2 = document.createElement("OPTION");
										optn2.text = "------------------------ Pilih Kelurahan ------------------------";
										optn2.value = "";
										$(".kelurahan2").append(optn2);
										
									});
								});
							</script>
							
							<div class="form-group">
								<label class="col-md-3 text">Kecamatan :</label>
								<div class="col-md-9">
									<select class="form-control kecamatan2" name="kecamatan2" required>
										<option  value="">------------------------ Pilih Kecamatan ------------------------</option>
										<?php foreach($kecamatan2 as $kab){ ?>
											<option value="<?php echo $kab->id; ?>" <?php if($kab->id==$data->kecamatan2){ echo "selected";} ?>><?php echo $kab->n_kecamatan; ?></option>
										<?php } ?>
									</select><br>
								</div>
							</div>
							
							<script>
								$(function(){
									$('.kecamatan2').on('change', function(e){
										var kecamatan = $(".kecamatan2").val();
										$.ajax({
											url : "../pendaftaranbaru/getkelurahan",
											type: "post",
											data: "data="+kecamatan,
											success : function(data){
												$(".kelurahan2").html('');
												var myarray = JSON.parse(data);
												var myarray = myarray.split(",");

												for (i=0;i<myarray.length;i++)
												{
													if(myarray[i] != myarray[i+1])
													{
														var myarray2 = myarray[i].split("|");
														var optn2 = document.createElement("OPTION");
														
														optn2.text = myarray2[1];
														optn2.value = myarray2[0];
														$(".kelurahan2").append(optn2);
													}
												}
											}
										});
									});
								});
							</script>
							
							<div class="form-group">
								<label class="col-md-3 text">Kelurahan / Desa :</label>
								<div class="col-md-9">
									<select class="form-control kelurahan2" name="kelurahan2" required>
										<option  value="">------------------------ Pilih Kelurahan / Desa ------------------------</option>
										<?php foreach($kelurahan2 as $kab){ ?>
											<option value="<?php echo $kab->id; ?>" <?php if($kab->id==$data->kelurahan2){ echo "selected";} ?>><?php echo $kab->n_kelurahan; ?></option>
										<?php } ?>
									</select><br>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 text">Alamat  :</label>
								<div class="col-md-9">
									<textarea class="form-control" rows="5" name="alamat_pemohon" style="resize: vertical;"  required><?php echo str_replace("<br />","",$data->almtPerusahaan); ?></textarea><br>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 text">E-mail Pemohon :</label>
								<div class="col-md-9">
									<input class="form-control"  type="email" name="email_pemohon" value="<?php echo $data->emailPerusahaan; ?>" required><br>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 text">HP Pemohon :</label>
								<div class="col-md-9">
									<input class="form-control numberonly" name="telp_pemohon" value="<?php echo $data->telpPerusahaan; ?>" required><br>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 text">HP Pemegang Kuasa :</label>
								<div class="col-md-9">
									<input class="form-control numberonly" name="telp_pemegang_kuasa"  value="<?php echo $data->telpPemohon; ?>"><sup><i>Boleh Dikosongkan</i></sup><br>
								</div>
							</div>

							<?php } ?>
						
						
						
							<?php if($jenis=="Perusahaan"){ ?>
							
							<div class="form-group">
								<label class="col-md-3 text">Nama Perusahaan :</label>
								<div class="col-md-9">
									<input class="form-control" name="nama_perusahaan" value="<?php echo $data->namaPerusahaan; ?>" required><br>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 text">Nama Direktur :</label>
								<div class="col-md-9">
									<input class="form-control" name="nama_penanggung_jawab" value="<?php echo $data->nama_penanggung_jawab; ?>" required><br>
								</div>
							</div>
						
							<div class="form-group">
								<label class="col-md-3 text">Nama Pemegang Kuasa :</label>
								<div class="col-md-9">
									<input class="form-control"  name="nama_pemegang_kuasa" value="<?php echo $data->namaPemohon; ?>"><sup><i>Boleh Dikosongkan</i></sup><br>
								</div>
							</div>
						
							<div class="form-group">
								<label class="col-md-3 text">No KTP Direktur :</label>
								<div class="col-md-9">
									<input class="form-control numberonly" maxlength="16"  name="no_ktp_direktur" value="<?php echo $data->ktpPemohon; ?>" required><br>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 text">No NPWP Perusahaan :</label>
								<div class="col-md-9">
									<input class="form-control" maxlength="20" name="no_npwp_perusahaan" value="<?php echo $data->npwpPerusahaan; ?>" required><br>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 text">
									No Akta Perusahaan :<br>
								</label>
								<div class="col-md-9">
									<input class="form-control" name="no_akta_perusahaan" value="<?php echo $data->aktaPerusahaan; ?>" required><br>
								</div>
							</div>
							
							<center><h4>Alamat Perusahaan </h4></center>
							
							<div class="form-group">
								<label class="col-md-3 text">Provinsi :</label>
								<div class="col-md-9">
									<select class="form-control provinsi2" name="provinsi2" required>
										<?php foreach($propinsi2 as $prov){ ?>
											<option value="<?php echo $prov->kd_prov; ?>" <?php if($prov->kd_prov==$data->propinsi2){ echo "selected";} ?>><?php echo $prov->n_propinsi; ?></option>
										<?php } ?>
									</select><br>
								</div>
							</div>
							
							<script>
							$(function(){
								$('.provinsi2').on('change', function(e){
									var provinsi = $(".provinsi2").val();
									$.ajax({
										url : "../pendaftaranbaru/getkabupaten",
										type: "post",
										data:{"data":provinsi},
										success : function(data){
											$(".kabupaten2").html('');
											var myarray = JSON.parse(data);
											var myarray = myarray.split(",");

											for (i=0;i<myarray.length;i++)
											{
												if(myarray[i] != myarray[i+1])
												{
													var myarray2 = myarray[i].split("|");
													var optn2 = document.createElement("OPTION");
													
													optn2.text = myarray2[1];
													optn2.value = myarray2[0];
													$(".kabupaten2").append(optn2);
												}
											}
										}
									});
									
									$(".kecamatan2").html('');
									var optn2 = document.createElement("OPTION");
									optn2.text = "------------------------ Pilih Kecamatan ------------------------";
									optn2.value = "";
									$(".kecamatan2").append(optn2);
									
									$(".kelurahan2").html('');
									var optn2 = document.createElement("OPTION");
									optn2.text = "------------------------ Pilih Kelurahan ------------------------";
									optn2.value = "";
									$(".kelurahan2").append(optn2);
									
								});
							});
						</script>
							
							<div class="form-group">
								<label class="col-md-3 text">Kabupaten / Kota :</label>
								<div class="col-md-9">
									<select class="form-control kabupaten2" name="kabupaten2" required>
										<option  value="">------------------------ Pilih Kabupaten / Kota ------------------------</option>
								
										<?php foreach($kabupaten2 as $kab){ ?>
											<option value="<?php echo $kab->id; ?>" <?php if($kab->id==$data->kabupaten2){ echo "selected";} ?>><?php echo $kab->n_kabupaten; ?></option>
										<?php } ?>
									</select><br>
								</div>
							</div>
							
							<script>
								$(function(){
									$('.kabupaten2').on('change', function(e){
										var kabupaten = $(".kabupaten2").val();
										$.ajax({
											url : "../pendaftaranbaru/getkecamatan",
											type: "post",
											data: "data="+kabupaten,
											success : function(data){
												$(".kecamatan2").html('');
												var myarray = JSON.parse(data);
												var myarray = myarray.split(",");

												for (i=0;i<myarray.length;i++)
												{
													if(myarray[i] != myarray[i+1])
													{
														var myarray2 = myarray[i].split("|");
														var optn2 = document.createElement("OPTION");
														
														optn2.text = myarray2[1];
														optn2.value = myarray2[0];
														$(".kecamatan2").append(optn2);
													}
												}
											}
										});
										
										$(".kelurahan2").html('');
										var optn2 = document.createElement("OPTION");
										optn2.text = "------------------------ Pilih Kelurahan ------------------------";
										optn2.value = "";
										$(".kelurahan2").append(optn2);
										
									});
								});
							</script>
							
							<div class="form-group">
								<label class="col-md-3 text">Kecamatan :</label>
								<div class="col-md-9">
									<select class="form-control kecamatan2" name="kecamatan2" required>
										<option  value="">------------------------ Pilih Kecamatan ------------------------</option>
										<?php foreach($kecamatan2 as $kab){ ?>
											<option value="<?php echo $kab->id; ?>" <?php if($kab->id==$data->kecamatan2){ echo "selected";} ?>><?php echo $kab->n_kecamatan; ?></option>
										<?php } ?>
									</select><br>
								</div>
							</div>
							
							<script>
								$(function(){
									$('.kecamatan2').on('change', function(e){
										var kecamatan = $(".kecamatan2").val();
										$.ajax({
											url : "../pendaftaranbaru/getkelurahan",
											type: "post",
											data: "data="+kecamatan,
											success : function(data){
												$(".kelurahan2").html('');
												var myarray = JSON.parse(data);
												var myarray = myarray.split(",");

												for (i=0;i<myarray.length;i++)
												{
													if(myarray[i] != myarray[i+1])
													{
														var myarray2 = myarray[i].split("|");
														var optn2 = document.createElement("OPTION");
														
														optn2.text = myarray2[1];
														optn2.value = myarray2[0];
														$(".kelurahan2").append(optn2);
													}
												}
											}
										});
									});
								});
							</script>
							
							<div class="form-group">
								<label class="col-md-3 text">Kelurahan / Desa :</label>
								<div class="col-md-9">
									<select class="form-control kelurahan2" name="kelurahan2" required>
										<option  value="">------------------------ Pilih Kelurahan / Desa ------------------------</option>
										<?php foreach($kelurahan2 as $kab){ ?>
											<option value="<?php echo $kab->id; ?>" <?php if($kab->id==$data->kelurahan2){ echo "selected";} ?>><?php echo $kab->n_kelurahan; ?></option>
										<?php } ?>
									</select><br>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 text">Alamat  :</label>
								<div class="col-md-9">
									<textarea class="form-control" rows="5" name="alamat_perusahaan" style="resize: vertical;"  required><?php echo str_replace("<br />","",$data->almtPerusahaan); ?></textarea><br>
								</div>
							</div>
							
							<center><h4>Alamat Direktur</h4></center>
							
							<div class="form-group">
								<label class="col-md-3 text">Provinsi :</label>
								<div class="col-md-9">
									<select class="form-control provinsi1" name="provinsi1" required>
										<?php if($propinsi1==0){ ?>
											<?php foreach($provinsi as $prov){ ?>
												<option value="<?php echo $prov->kd_prov; ?>" <?php if($prov->kd_prov==12){ echo "selected";} ?>><?php echo $prov->n_propinsi; ?></option>
											<?php } ?>
										<?php }else{ ?>
											<?php foreach($propinsi1 as $prov){ ?>
												<option value="<?php echo $prov->kd_prov; ?>" <?php if($prov->kd_prov==$data->propinsi1){ echo "selected";} ?>><?php echo $prov->n_propinsi; ?></option>
											<?php } ?>
										<?php } ?>
									</select><br>
								</div>
							</div>
							
							<script>
							$(function(){
								$('.provinsi1').on('change', function(e){
									var provinsi = $(".provinsi1").val();
									$.ajax({
										url : "../pendaftaranbaru/getkabupaten",
										type: "post",
										data:{"data":provinsi},
										success : function(data){
											$(".kabupaten1").html('');
											var myarray = JSON.parse(data);
											var myarray = myarray.split(",");

											for (i=0;i<myarray.length;i++)
											{
												if(myarray[i] != myarray[i+1])
												{
													var myarray2 = myarray[i].split("|");
													var optn2 = document.createElement("OPTION");
													
													optn2.text = myarray2[1];
													optn2.value = myarray2[0];
													$(".kabupaten1").append(optn2);
												}
											}
										}
									});
									
									$(".kecamatan1").html('');
									var optn2 = document.createElement("OPTION");
									optn2.text = "------------------------ Pilih Kecamatan ------------------------";
									optn2.value = "";
									$(".kecamatan1").append(optn2);
									
									$(".kelurahan1").html('');
									var optn2 = document.createElement("OPTION");
									optn2.text = "------------------------ Pilih Kelurahan ------------------------";
									optn2.value = "";
									$(".kelurahan1").append(optn2);
									
								});
							});
						</script>
							
							<div class="form-group">
								<label class="col-md-3 text">Kabupaten / Kota :</label>
								<div class="col-md-9">
									<select class="form-control kabupaten1" name="kabupaten1" required>
										<option  value="">------------------------ Pilih Kabupaten / Kota ------------------------</option>
										<?php if($kabupaten1==0){ ?>
											<?php foreach($kabupaten as $kab){ ?>
												<option value="<?php echo $kab->id; ?>"><?php echo $kab->n_kabupaten; ?></option>
											<?php } ?>
										<?php }else{ ?>
											<?php foreach($kabupaten1 as $kab){ ?>
												<option value="<?php echo $kab->id; ?>" <?php if($kab->id==$data->kabupaten1){ echo "selected";} ?>><?php echo $kab->n_kabupaten; ?></option>
											<?php } ?>
										<?php } ?>
									</select><br>
								</div>
							</div>
							
							<script>
								$(function(){
									$('.kabupaten1').on('change', function(e){
										var kabupaten = $(".kabupaten1").val();
										$.ajax({
											url : "../pendaftaranbaru/getkecamatan",
											type: "post",
											data: "data="+kabupaten,
											success : function(data){
												$(".kecamatan1").html('');
												var myarray = JSON.parse(data);
												var myarray = myarray.split(",");

												for (i=0;i<myarray.length;i++)
												{
													if(myarray[i] != myarray[i+1])
													{
														var myarray2 = myarray[i].split("|");
														var optn2 = document.createElement("OPTION");
														
														optn2.text = myarray2[1];
														optn2.value = myarray2[0];
														$(".kecamatan1").append(optn2);
													}
												}
											}
										});
										
										$(".kelurahan1").html('');
										var optn2 = document.createElement("OPTION");
										optn2.text = "------------------------ Pilih Kelurahan ------------------------";
										optn2.value = "";
										$(".kelurahan1").append(optn2);
										
									});
								});
							</script>
							
							<div class="form-group">
								<label class="col-md-3 text">Kecamatan :</label>
								<div class="col-md-9">
									<select class="form-control kecamatan1" name="kecamatan1" required>
										<option value="">------------------------ Pilih Kecamatan ------------------------</option>-->
										<?php if($kecamatan1==0){ ?>
										<?php }else{ ?>
											<?php foreach($kecamatan1 as $kab){ ?>
												<option value="<?php echo $kab->id; ?>" <?php if($kab->id==$data->kecamatan1){ echo "selected";} ?>><?php echo $kab->n_kecamatan; ?></option>
											<?php } ?>
										<?php } ?>
									</select><br>
								</div>
							</div>
							
							<script>
								$(function(){
									$('.kecamatan1').on('change', function(e){
										var kecamatan = $(".kecamatan1").val();
										$.ajax({
											url : "../pendaftaranbaru/getkelurahan",
											type: "post",
											data: "data="+kecamatan,
											success : function(data){
												$(".kelurahan1").html('');
												var myarray = JSON.parse(data);
												var myarray = myarray.split(",");

												for (i=0;i<myarray.length;i++)
												{
													if(myarray[i] != myarray[i+1])
													{
														var myarray2 = myarray[i].split("|");
														var optn2 = document.createElement("OPTION");
														
														optn2.text = myarray2[1];
														optn2.value = myarray2[0];
														$(".kelurahan1").append(optn2);
													}
												}
											}
										});
									});
								});
							</script>
							
							<div class="form-group">
								<label class="col-md-3 text">Kelurahan / Desa :</label>
								<div class="col-md-9">
									<select class="form-control kelurahan1" name="kelurahan1" required>
										<option value="">------------------------ Pilih Kelurahan / Desa ------------------------</option>
										<?php if($kelurahan1==0){ ?>
										<?php }else{ ?>
											<?php foreach($kelurahan1 as $kab){ ?>
												<option value="<?php echo $kab->id; ?>" <?php if($kab->id==$data->kelurahan1){ echo "selected";} ?>><?php echo $kab->n_kelurahan; ?></option>
											<?php } ?>
										<?php } ?>
									</select><br>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 text">Alamat :</label>
								<div class="col-md-9">
									<textarea class="form-control" rows="5" name="alamat_direktur" style="resize: vertical;" required><?php echo str_replace("<br />","",$data->almtPemohon); ?></textarea><br>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 text">E-mail Direktur :</label>
								<div class="col-md-9">
									<input class="form-control"  type="email" name="email_perusahaan" value="<?php echo $data->emailPerusahaan; ?>" required><br>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 text">E-mail Perusahaan :</label>
								<div class="col-md-9">
									<input class="form-control" type="email" name="email_direktur"  value="<?php echo $data->emailPemohon; ?>" required><br>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 text">HP Direktur :</label>
								<div class="col-md-9">
									<input class="form-control numberonly" name="telp_direktur" value="<?php echo $data->telpPerusahaan; ?>" required><br>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 text">Telp Perusahaan :</label>
								<div class="col-md-9">
									<input class="form-control numberonly" name="telp_perusahaan" value="<?php echo $data->telp_penanggung_jawab; ?>" required><br>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 text">HP Pemegang Kuasa :</label>
								<div class="col-md-9">
									<input class="form-control numberonly" name="telp_pemegang_kuasa" value="<?php echo $data->telpPemohon; ?>"><sup><i>Boleh Dikosongkan</i></sup><br>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 text">Fax Perusahaan :</label>
								<div class="col-md-9">
									<input class="form-control" name="fax_perusahaan"  value="<?php echo $data->faxPerusahaan; ?>"><sup><i>Boleh Dikosongkan</i></sup><br>
								</div>
							</div>
							
							<?php } ?>
							
							
							<script>
								$(function(){
									$('.numberonly').keyup(function () { 
										this.value = this.value.replace(/[^0-9\.]/g,'');
									});
								});
							</script>
							
							<div class="form-group">
								<label class="col-md-9 text"></label>
								<div class="col-md-3">
									<button type="submit" class="btn btn-block btn-primary">
										Simpan Data
									</button>
									<?php //echo anchor("main/user/dataPerusahaan/", 'Simpan Data',array("class"=>"btn btn-block btn-primary")) ?>
								</div>
							</div>
						
							<?php /* ?>
							<div class="form-group">
								<label class="col-md-3 text">Nama <?php echo ucfirst($data->jenis); ?> :</label>
								<div class="col-md-9">
									<input class="form-control" placeholder="Nama Pemohon" name="nama_pemohon" value="<?php echo $data->namaPerusahaan; ?>" required><br>
								</div>
							</div>
							
							<?php if($data->jenis=="perusahaan"){ ?>
							<div class="form-group">
								<label class="col-md-3 text">Nama Direktur :</label>
								<div class="col-md-9">
									<input class="form-control" placeholder="Nama Direktur" name="nama_penanggung_jawab" value="<?php echo $data->nama_penanggung_jawab; ?>" required><br>
								</div>
							</div>
							<?php } ?>
						
							<div class="form-group">
								<label class="col-md-3 text">Nama Pemegang Kuasa :</label>
								<div class="col-md-9">
									<input class="form-control" placeholder="Nama Pemegang Kuasa" name="nama_pemegang_kuasa" value="<?php echo $data->namaPemohon; ?>"><br>
								</div>
							</div>
						
							<?php if($data->jenis=="pemohon"){ ?>
							<div class="form-group">
								<label class="col-md-3 text">No KTP Pemohon :</label>
								<div class="col-md-9">
									<input class="form-control numberonly" maxlength="16" placeholder="No KTP Pemegang Kuasa" name="no_ktp_pemegang_kuasa" value="<?php echo $data->ktpPemohon; ?>" required><br>
								</div>
							</div>
							<?php } ?>
							
							<div class="form-group">
								<label class="col-md-3 text">No KTP Pemegang Kuasa :</label>
								<div class="col-md-9">
									<input class="form-control numberonly" maxlength="16" placeholder="No KTP Pemegang Kuasa" name="no_ktp_pemegang_kuasa" value="<?php echo $data->ktpPemohon; ?>" ><br>
								</div>
							</div>
							
						
							<div class="form-group">
								<label class="col-md-3 text">No NPWP <?php echo ucfirst($data->jenis); ?> :</label>
								<div class="col-md-9">
									<input class="form-control" placeholder="No NPWP Pemohon" maxlength="20" name="no_npwp_pemohon" value="<?php echo $data->npwpPerusahaan; ?>" required><br>
								</div>
							</div>
							
							<?php if($data->jenis=="perusahaan"){ ?>
							<div class="form-group">
								<label class="col-md-3 text">
									No Akta Perusahaan :<br>
								</label>
								<div class="col-md-9">
									<input class="form-control" placeholder="No Akta Pemohon" name="no_akta_pemohon" value="<?php echo $data->aktaPerusahaan; ?>" required><br>
								</div>
							</div>
							<?php } ?>
							
							<center><h4>Alamat <?php echo ucfirst($data->jenis); ?> </h4></center>
							
							<div class="form-group">
								<label class="col-md-3 text">Provinsi :</label>
								<div class="col-md-9">
									<select class="form-control provinsi2" name="provinsi2" required>
										<?php foreach($propinsi2 as $prov){ ?>
											<option value="<?php echo $prov->kd_prov; ?>" <?php if($prov->kd_prov==$data->propinsi2){ echo "selected";} ?>><?php echo $prov->n_propinsi; ?></option>
										<?php } ?>
									</select><br>
								</div>
							</div>
							
							<script>
							$(function(){
								$('.provinsi2').on('change', function(e){
									var provinsi = $(".provinsi2").val();
									$.ajax({
										url : "../pendaftaranbaru/getkabupaten",
										type: "post",
										data:{"data":provinsi},
										success : function(data){
											$(".kabupaten2").html('');
											var myarray = JSON.parse(data);
											var myarray = myarray.split(",");

											for (i=0;i<myarray.length;i++)
											{
												if(myarray[i] != myarray[i+1])
												{
													var myarray2 = myarray[i].split("|");
													var optn2 = document.createElement("OPTION");
													
													optn2.text = myarray2[1];
													optn2.value = myarray2[0];
													$(".kabupaten2").append(optn2);
												}
											}
										}
									});
									
									$(".kecamatan2").html('');
									var optn2 = document.createElement("OPTION");
									optn2.text = "------------------------ Pilih Kecamatan ------------------------";
									optn2.value = "";
									$(".kecamatan2").append(optn2);
									
									$(".kelurahan2").html('');
									var optn2 = document.createElement("OPTION");
									optn2.text = "------------------------ Pilih Kelurahan ------------------------";
									optn2.value = "";
									$(".kelurahan2").append(optn2);
									
								});
							});
						</script>
							
							<div class="form-group">
								<label class="col-md-3 text">Kabupaten / Kota :</label>
								<div class="col-md-9">
									<select class="form-control kabupaten2" name="kabupaten2" required>
										<option  value="">------------------------ Pilih Kabupaten / Kota ------------------------</option>
								
										<?php foreach($kabupaten2 as $kab){ ?>
											<option value="<?php echo $kab->id; ?>" <?php if($kab->id==$data->kabupaten2){ echo "selected";} ?>><?php echo $kab->n_kabupaten; ?></option>
										<?php } ?>
									</select><br>
								</div>
							</div>
							
							<script>
								$(function(){
									$('.kabupaten2').on('change', function(e){
										var kabupaten = $(".kabupaten2").val();
										$.ajax({
											url : "../pendaftaranbaru/getkecamatan",
											type: "post",
											data: "data="+kabupaten,
											success : function(data){
												$(".kecamatan2").html('');
												var myarray = JSON.parse(data);
												var myarray = myarray.split(",");

												for (i=0;i<myarray.length;i++)
												{
													if(myarray[i] != myarray[i+1])
													{
														var myarray2 = myarray[i].split("|");
														var optn2 = document.createElement("OPTION");
														
														optn2.text = myarray2[1];
														optn2.value = myarray2[0];
														$(".kecamatan2").append(optn2);
													}
												}
											}
										});
										
										$(".kelurahan2").html('');
										var optn2 = document.createElement("OPTION");
										optn2.text = "------------------------ Pilih Kelurahan ------------------------";
										optn2.value = "";
										$(".kelurahan2").append(optn2);
										
									});
								});
							</script>
							
							<div class="form-group">
								<label class="col-md-3 text">Kecamatan :</label>
								<div class="col-md-9">
									<select class="form-control kecamatan2" name="kecamatan2" required>
										<option  value="">------------------------ Pilih Kecamatan ------------------------</option>
										<?php foreach($kecamatan2 as $kab){ ?>
											<option value="<?php echo $kab->id; ?>" <?php if($kab->id==$data->kecamatan2){ echo "selected";} ?>><?php echo $kab->n_kecamatan; ?></option>
										<?php } ?>
									</select><br>
								</div>
							</div>
							
							<script>
								$(function(){
									$('.kecamatan2').on('change', function(e){
										var kecamatan = $(".kecamatan2").val();
										$.ajax({
											url : "../pendaftaranbaru/getkelurahan",
											type: "post",
											data: "data="+kecamatan,
											success : function(data){
												$(".kelurahan2").html('');
												var myarray = JSON.parse(data);
												var myarray = myarray.split(",");

												for (i=0;i<myarray.length;i++)
												{
													if(myarray[i] != myarray[i+1])
													{
														var myarray2 = myarray[i].split("|");
														var optn2 = document.createElement("OPTION");
														
														optn2.text = myarray2[1];
														optn2.value = myarray2[0];
														$(".kelurahan2").append(optn2);
													}
												}
											}
										});
									});
								});
							</script>
							
							<div class="form-group">
								<label class="col-md-3 text">Kelurahan / Desa :</label>
								<div class="col-md-9">
									<select class="form-control kelurahan2" name="kelurahan2" required>
										<option  value="">------------------------ Pilih Kelurahan / Desa ------------------------</option>
										<?php foreach($kelurahan2 as $kab){ ?>
											<option value="<?php echo $kab->id; ?>" <?php if($kab->id==$data->kelurahan2){ echo "selected";} ?>><?php echo $kab->n_kelurahan; ?></option>
										<?php } ?>
									</select><br>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 text">Alamat  :</label>
								<div class="col-md-9">
									<textarea class="form-control" rows="5" placeholder="Alamat Pemohon" name="alamat_pemegang_kuasa" style="resize: vertical;"  required><?php echo str_replace("<br />","",$data->almtPerusahaan); ?></textarea><br>
								</div>
							</div>
							
							<center><h4>Alamat Pemegang Kuasa</h4></center>
							
							<div class="form-group">
								<label class="col-md-3 text">Provinsi :</label>
								<div class="col-md-9">
									<select class="form-control provinsi1" name="provinsi1" required>
										<?php if($propinsi1==0){ ?>
											<?php foreach($provinsi as $prov){ ?>
												<option value="<?php echo $prov->kd_prov; ?>" <?php if($prov->kd_prov==12){ echo "selected";} ?>><?php echo $prov->n_propinsi; ?></option>
											<?php } ?>
										<?php }else{ ?>
											<?php foreach($propinsi1 as $prov){ ?>
												<option value="<?php echo $prov->kd_prov; ?>" <?php if($prov->kd_prov==$data->propinsi1){ echo "selected";} ?>><?php echo $prov->n_propinsi; ?></option>
											<?php } ?>
										<?php } ?>
									</select><br>
								</div>
							</div>
							
							<script>
							$(function(){
								$('.provinsi1').on('change', function(e){
									var provinsi = $(".provinsi1").val();
									$.ajax({
										url : "../pendaftaranbaru/getkabupaten",
										type: "post",
										data:{"data":provinsi},
										success : function(data){
											$(".kabupaten1").html('');
											var myarray = JSON.parse(data);
											var myarray = myarray.split(",");

											for (i=0;i<myarray.length;i++)
											{
												if(myarray[i] != myarray[i+1])
												{
													var myarray2 = myarray[i].split("|");
													var optn2 = document.createElement("OPTION");
													
													optn2.text = myarray2[1];
													optn2.value = myarray2[0];
													$(".kabupaten1").append(optn2);
												}
											}
										}
									});
									
									$(".kecamatan1").html('');
									var optn2 = document.createElement("OPTION");
									optn2.text = "------------------------ Pilih Kecamatan ------------------------";
									optn2.value = "";
									$(".kecamatan1").append(optn2);
									
									$(".kelurahan1").html('');
									var optn2 = document.createElement("OPTION");
									optn2.text = "------------------------ Pilih Kelurahan ------------------------";
									optn2.value = "";
									$(".kelurahan1").append(optn2);
									
								});
							});
						</script>
							
							<div class="form-group">
								<label class="col-md-3 text">Kabupaten / Kota :</label>
								<div class="col-md-9">
									<select class="form-control kabupaten1" name="kabupaten1" required>
										<option  value="">------------------------ Pilih Kabupaten / Kota ------------------------</option>
										<?php if($kabupaten1==0){ ?>
											<?php foreach($kabupaten as $kab){ ?>
												<option value="<?php echo $kab->id; ?>"><?php echo $kab->n_kabupaten; ?></option>
											<?php } ?>
										<?php }else{ ?>
											<?php foreach($kabupaten1 as $kab){ ?>
												<option value="<?php echo $kab->id; ?>" <?php if($kab->id==$data->kabupaten1){ echo "selected";} ?>><?php echo $kab->n_kabupaten; ?></option>
											<?php } ?>
										<?php } ?>
									</select><br>
								</div>
							</div>
							
							<script>
								$(function(){
									$('.kabupaten1').on('change', function(e){
										var kabupaten = $(".kabupaten1").val();
										$.ajax({
											url : "../pendaftaranbaru/getkecamatan",
											type: "post",
											data: "data="+kabupaten,
											success : function(data){
												$(".kecamatan1").html('');
												var myarray = JSON.parse(data);
												var myarray = myarray.split(",");

												for (i=0;i<myarray.length;i++)
												{
													if(myarray[i] != myarray[i+1])
													{
														var myarray2 = myarray[i].split("|");
														var optn2 = document.createElement("OPTION");
														
														optn2.text = myarray2[1];
														optn2.value = myarray2[0];
														$(".kecamatan1").append(optn2);
													}
												}
											}
										});
										
										$(".kelurahan1").html('');
										var optn2 = document.createElement("OPTION");
										optn2.text = "------------------------ Pilih Kelurahan ------------------------";
										optn2.value = "";
										$(".kelurahan1").append(optn2);
										
									});
								});
							</script>
							
							<div class="form-group">
								<label class="col-md-3 text">Kecamatan :</label>
								<div class="col-md-9">
									<select class="form-control kecamatan1" name="kecamatan1" required>
										<option value="">------------------------ Pilih Kecamatan ------------------------</option>-->
										<?php if($kecamatan1==0){ ?>
										<?php }else{ ?>
											<?php foreach($kecamatan1 as $kab){ ?>
												<option value="<?php echo $kab->id; ?>" <?php if($kab->id==$data->kecamatan1){ echo "selected";} ?>><?php echo $kab->n_kecamatan; ?></option>
											<?php } ?>
										<?php } ?>
									</select><br>
								</div>
							</div>
							
							<script>
								$(function(){
									$('.kecamatan1').on('change', function(e){
										var kecamatan = $(".kecamatan1").val();
										$.ajax({
											url : "../pendaftaranbaru/getkelurahan",
											type: "post",
											data: "data="+kecamatan,
											success : function(data){
												$(".kelurahan1").html('');
												var myarray = JSON.parse(data);
												var myarray = myarray.split(",");

												for (i=0;i<myarray.length;i++)
												{
													if(myarray[i] != myarray[i+1])
													{
														var myarray2 = myarray[i].split("|");
														var optn2 = document.createElement("OPTION");
														
														optn2.text = myarray2[1];
														optn2.value = myarray2[0];
														$(".kelurahan1").append(optn2);
													}
												}
											}
										});
									});
								});
							</script>
							
							<div class="form-group">
								<label class="col-md-3 text">Kelurahan / Desa :</label>
								<div class="col-md-9">
									<select class="form-control kelurahan1" name="kelurahan1" required>
										<option value="">------------------------ Pilih Kelurahan / Desa ------------------------</option>
										<?php if($kelurahan1==0){ ?>
										<?php }else{ ?>
											<?php foreach($kelurahan1 as $kab){ ?>
												<option value="<?php echo $kab->id; ?>" <?php if($kab->id==$data->kelurahan1){ echo "selected";} ?>><?php echo $kab->n_kelurahan; ?></option>
											<?php } ?>
										<?php } ?>
									</select><br>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 text">Alamat :</label>
								<div class="col-md-9">
									<textarea class="form-control" rows="5" placeholder="Alamat Pemegang Kuasa" name="alamat_pemohon" style="resize: vertical;" required><?php echo str_replace("<br />","",$data->almtPemohon); ?></textarea><br>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 text">E-mail Pemohon :</label>
								<div class="col-md-9">
									<input class="form-control"  type="email" name="email_pemohon" placeholder="E-mail Pemohon" value="<?php echo $data->emailPerusahaan; ?>" required><br>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 text">E-mail Pemegang Kuasa :</label>
								<div class="col-md-9">
									<input class="form-control" type="email" name="email_pemegang_kuasa" placeholder="E-mail Pemegang Kuasa" value="<?php echo $data->emailPemohon; ?>" required><br>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 text">HP Pemohon :</label>
								<div class="col-md-9">
									<input class="form-control numberonly" name="telp_pemohon" placeholder="No Telp Pemohon" value="<?php echo $data->telpPerusahaan; ?>" required><br>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 text">HP Pemegang Kuasa :</label>
								<div class="col-md-9">
									<input class="form-control numberonly" name="telp_pemegang_kuasa" placeholder="No Telp Pemegang Kuasa" value="<?php echo $data->telpPemohon; ?>" required><br>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 text">Fax Pemohon :</label>
								<div class="col-md-9">
									<input class="form-control" name="fax_pemohon" placeholder="Fax <?php echo ucfirst($data->jenis); ?>" value="<?php echo $data->faxPerusahaan; ?>"><br>
								</div>
							</div>

							<script>
								$(function(){
									$('.numberonly').keyup(function () { 
										this.value = this.value.replace(/[^0-9\.]/g,'');
									});
								});
							</script>

							<div class="form-group">
								<label class="col-md-9 text"></label>
								<div class="col-md-3">
									<button type="submit" class="btn btn-block btn-primary">
										Simpan Data
									</button>
									<?php //echo anchor("main/user/dataPerusahaan/", 'Simpan Data',array("class"=>"btn btn-block btn-primary")) ?>
								</div>
							</div>
							<?php */ ?>
						</form>
					</div>
				</div>
			</div>
		</div><!-- /.col-->
	</div><!-- /.row -->
	
</div><!--/.main-->
