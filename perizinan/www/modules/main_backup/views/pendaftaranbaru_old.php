<style>
    table tr td{padding-bottom: 5px; padding-left: 10px;}
    .ti_table{
        font-weight: bold; font-size: 14px; padding-bottom: 5px; padding-left: -10px;
    }
    em{font-weight: normal; font-size: 12px;}
	
	.form-group{
		width:100%;
		clear:both;
	}
	
	text{
		float:left;
		width:200px;
		text-align:right;
		font-size:13px;
		margin-top:4px;
	}

	.form{
		float:left;
		width:400px;
		padding-bottom:10px;
		margin-left:20px;
	}
	
	.text-input{
		width:80%;
	}
	
</style>
<div class="isi">
    <div id="entry">
        <h2>Pendaftaran Online</h2>
        <div class="kiri" style="margin-left:40px;width:660px">
			<?php 
				$error = $this->session->flashdata("error");
				if(!empty($error)){
			?>
				<div id="pesan" style="color: red; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;"><center><?php echo $error; ?></center></div>
			<?php } ?>
				<div id="pesan" style="font-size: 12px; margin-bottom: 10px; font-weight: bold;"><center>Silahkan Lengkapi Data Berikut</center></div>
				<form method="post" action="<?php echo base_url() . 'main/pendaftaranbaru/dopendaftaran'; ?>">
					<div class="form-group">
						<text>
							Nama Pemohon :
						</text>
						<div class="form">
							<input type="text" id="" name="nama_pemohon" class="validate[required] text-input" style="width:80%" value="" required>
						</div>
					</div>
					
					<div class="form-group">
						<text>
							Nama Pemegang Kuasa :
						</text>
						<div class="form">
							<input type="text" id="" name="nama_pemegang_kuasa" class="validate[required] text-input" style="width:80%" value="" required>
						</div>
					</div>
					
					<div class="form-group">
						<text>
							No HP Pemohon :
						</text>
						<div class="form">
							<input type="text" id="" name="telp_pemohon" class="validate[required] text-input numberonly" style="width:80%" value="" required>
						</div>
					</div>
					
					<div class="form-group">
						<text>
							No HP Pemegang Kuasa :
						</text>
						<div class="form">
							<input type="text" id="" name="telp_pemegang_kuasa" class="validate[required] text-input numberonly" style="width:80%" value="" required>
						</div>
					</div>
					
					<div class="form-group">
						<text>
							E-mail Pemohon :
						</text>
						<div class="form">
							<input type="text" id="" name="email_pemohon" class="validate[required] text-input" style="width:80%" value="" required>
						</div>
					</div>
					
					<div id="pesan" style="font-size: 12px; margin-bottom: 10px; font-weight: bold;"><center>Alamat Pemohon</center></div>
					
					<div class="form-group">
						<text>
							Provinsi :
						</text>
						<div class="form">
							<select name="provinsi" style="width:80%" class="provinsi" required>
								<!-- <option value="">------------------------ Pilih Provinsi ------------------------</option> -->
								
								<?php foreach($provinsi as $prov){ ?>
									<option value="<?php echo $prov->kd_prov; ?>" <?php if($prov->kd_prov==12){ echo "selected";} ?>><?php echo $prov->n_propinsi; ?></option>
								<?php } ?>
							
							</select>
						</div>
					</div>
					
					<script>
						$(function(){
							$('.provinsi').on('change', function(e){
								var provinsi = $(".provinsi").val();
								$.ajax({
									url : "pendaftaranbaru/getkabupaten",
									type: "post",
									data:{"data":provinsi},
									success : function(data){
										$(".kabupaten").html('');
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
												$(".kabupaten").append(optn2);
											}
										}
									}
								});
								
								$(".kecamatan").html('');
								var optn2 = document.createElement("OPTION");
								optn2.text = "------------------------ Pilih Kecamatan ------------------------";
								optn2.value = "";
								$(".kecamatan").append(optn2);
								
								$(".kelurahan").html('');
								var optn2 = document.createElement("OPTION");
								optn2.text = "------------------------ Pilih Kelurahan ------------------------";
								optn2.value = "";
								$(".kelurahan").append(optn2);
								
							});
						});
					</script>
			
					<div class="form-group">
						<text>
							Kabupaten / Kota :
						</text>
						<div class="form">
							<select name="kabupaten" style="width:80%" class="kabupaten" required>
								<option value="">------------------------ Pilih Kabupaten ------------------------</option>
								
								<?php foreach($kabupaten as $kab){ ?>
									<option value="<?php echo $kab->kd_kab; ?>"><?php echo $kab->n_kabupaten; ?></option>
								<?php } ?>
							
							</select>
						</div>
					</div>
			
					<script>
						$(function(){
							$('.kabupaten').on('change', function(e){
								var kabupaten = $(".kabupaten").val();
								$.ajax({
									url : "pendaftaranbaru/getkecamatan",
									type: "post",
									data: "data="+kabupaten,
									success : function(data){
										$(".kecamatan").html('');
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
												$(".kecamatan").append(optn2);
											}
										}
									}
								});
								
								$(".kelurahan").html('');
								var optn2 = document.createElement("OPTION");
								optn2.text = "------------------------ Pilih Kelurahan ------------------------";
								optn2.value = "";
								$(".kelurahan").append(optn2);
								
							});
						});
					</script>
					
					<div class="form-group">
						<text>
							Kecamatan :
						</text>
						<div class="form">
							<select name="kecamatan" style="width:80%" class="kecamatan" required>
								<option value="">------------------------ Pilih Kecamatan ------------------------</option>
								
								<?php /* foreach($kabupaten as $kab){ ?>
									<option value="<?php echo $kab->kd_kab; ?>"><?php echo $kab->n_kabupaten; ?></option>
								<?php } */ ?>
							
							</select>
						</div>
					</div>
					
					<script>
						$(function(){
							$('.kecamatan').on('change', function(e){
								var kecamatan = $(".kecamatan").val();
								$.ajax({
									url : "pendaftaranbaru/getkelurahan",
									type: "post",
									data: "data="+kecamatan,
									success : function(data){
										$(".kelurahan").html('');
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
												$(".kelurahan").append(optn2);
											}
										}
									}
								});
							});
						});
					</script>
					
					<div class="form-group">
						<text>
							Kelurahan / Desa :
						</text>
						<div class="form">
							<select name="kelurahan" style="width:80%" class="kelurahan" required>
								<option value="">------------------------ Pilih Kelurahan ------------------------</option>
								
								<?php /* foreach($kabupaten as $kab){ ?>
									<option value="<?php echo $kab->kd_kab; ?>"><?php echo $kab->n_kabupaten; ?></option>
								<?php } */ ?>
							
							</select>
						</div>
					</div>
					
					<div class="form-group">
						<text>
							Alamat :
						</text>
						<div class="form">
							<textarea name="alamat_pemohon" class="validate[required] text-input" style="width:80%;resize:vertical" rows="5" placeholder="Alamat Pemohon" required></textarea>
						</div>
					</div>
					
					<div class="form-group">
						<text>
							&nbsp;
						</text>
						<div class="form">
							<input type="submit" value="Simpan" class='button button-blue' style="float:left;cursor:pointer!important"/>
							<?php //echo anchor('main/pendaftaranbaru/konfirm', 'Lanjutkan',array("class"=>"button button-blue","style"=>"float:left")) ?>
						</div>
					</div>
				</form>
				
				<script>
					$(function(){
						$('.numberonly').keyup(function () { 
							this.value = this.value.replace(/[^0-9\.]/g,'');
						});
					});
				</script>

        </div>
        <div class="kanan">
            <?php echo "$menu" ?>
            <?php echo "$menu1" ?>
        </div>
        <div class="clear"></div>
    </div>
</div>
