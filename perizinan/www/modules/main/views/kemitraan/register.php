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

					for (i=0;i<myarray.length;i++){
						if(myarray[i] != myarray[i+1]){
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

<script>
    // var text = $('input[name="jenis"]:checked').val();
	$(document).ready(function(){
	    $(".radio").change(function(){
		    var jenis = $(this).val();
			if(jenis=="pemohon"){
			    $('#direktur').css('display', 'none');
				$('#direktur2').prop('disabled', true);
				$('#direktur2').prop('required', false);
				$("#ketpemohon").text("*Nama Pemohon Sesuai Kartu Identitas");
				$("#tipepemohon").text("Nama Pemohon :");
				$(".text").text("Nama Pemohon :");
				$("#pesan2").text("Alamat Pemohon");
				$("#hp").text("No HP&#47;WA Pemohon :");
				$("#email").text("Email Pemohon :");
			} else { 
				if(jenis=="perusahaan"){
					$('#direktur').css('display', 'block');
					$('#direktur2').prop('disabled', false);
					$('#direktur2').prop('required', true);
					$("#ketpemohon").text("*Nama Perusahaan Sesuai Akta");
					$("#tipepemohon").text("Nama Perusahaan :");
					$(".text").text("Nama Perusahaan :");
					$("#pesan2").text("Alamat Perusahaan");
					$("#hp").text("No HP&#47;WA Direktur :");
					$("#email").text("Email Direktur :");
				}
			}
		});
	});
</script>

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

					for (i=0;i<myarray.length;i++){
						if(myarray[i] != myarray[i+1]){
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

					for (i=0;i<myarray.length;i++){
						if(myarray[i] != myarray[i+1]){
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

<style type="text/css">
body {
    height: initial !important;
    width: initial !important;
}

html {
    height: initial !important;
    width: initial !important;
}
form{
    margin:10%;
}

</style>

<h2>Pendaftaran</h2>

<div class="alert alert-info" style="color:#fff;">
( Untuk Pemohon yang belum memiliki Akun ) klik <?php echo anchor('main/login', 'Login') ?> untuk pemohon yang telah memiliki akun
</div>


<input type="hidden" value="<?php echo $sms; ?>" id="sms" name="sms">
<input type="hidden" value="<?php echo $mail; ?>" id="mail" name="mail">
     

<div class="kiri">

<?php 
$error = $this->session->flashdata("error");
if(!empty($error)){ ?>

	<div id="pesan" style="color: red; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;"><center><?php echo $error; ?></center></div>

<?php } ?>

<?php 
								if ($this->konfig_izin->status == "1") {
							 ?>
							 		<p style="text-align: center; color: red;"><?php echo $notif; ?>
							 			<a href="https://oss.go.id/portal/" target="_blank">Klik untuk Daftar Ijin di OSS RBA</a><br>
							 			<a href="https://dpmptsp.jabarprov.go.id/web/blog/1424-Pengumuman-proses-peralihan-dan-migrasi-sistem-cut-off-pada-Sistem-SIMPATIK-ke-Sistem-OSS-v11" target="_blank">Klik untuk Info Peralihan ke OSS RBA</a>
							 		</p>
							<?php
								} else {?>
<center><h4>Silahkan Lengkapi Data Berikut</h4></center>
<hr />													
<form method="post" class="form-horizontal" action="<?php echo base_url() . 'main/pendaftaranbaru/dopendaftaran'; ?>">

	<div class="form-group">
	    <label  class="col-sm-4 control-label">Jenis Pemohon : </label>
	    <div class="col-sm-8">
	    	<div class="radio">
			  <label>
			  <input type="radio" class="radio" name="jenis" value="umk" checked>
			   UMK
			  </label>
			</div>

			<div class="radio">
			  <label>
			  <input type="radio" class="radio" name="jenis" value="perusahaan">
			   Non-UMK
			  </label>
			</div>
	    </div>
	</div>
			
				
	<div class="form-group">
		<label class="col-sm-4 control-label" id="tipepemohon">NIB</label>
		<div class="col-sm-8">
			<input type="text" id="" name="nib" class="validate[required] text-input form-control"  value="" required>
			<input type="hidden" id="" name="tglnib" class="validate[required] text-input form-control"  value="<?php echo date('Y-m-d'); ?>">
			<i><p id="ketpemohon"> * Nomor Induk Berusaha</p></i>
		</div>
	</div>
					
	<div class="form-group" style="display:none" id="direktur">
		<label class="col-sm-4 control-label">Nama Perusahaan :</label>
		<div class="col-sm-8">
			<input type="text" id="direktur2" name="n_perusahaan" class="validate[required] text-input form-control">
		</div>
	</div>


	<div class="form-group">
	    <label  class="col-sm-4 control-label">Jenis Pemohon : </label>
	    <div class="col-sm-8">
	    	<div class="radio">
			  <label>
			  <input type="radio" class="radio" name="jenis" value="PMDN" checked>
			   PMDN
			  </label>
			</div>

			<div class="radio">
			  <label>
			  <input type="radio" class="radio" name="jenis" value="PMDA">
			   PMDA
			  </label>
			</div>
	    </div>
	</div>

	<div class="form-group">
		<label class="col-sm-4 control-label">No HP/WA Pemohon :</label>
		<div class="col-sm-8">
			<input type="text" id="" name="telp_pemohon" class="validate[required] text-input form-control numberonly"  value="" required>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-4 control-label">No HP/WA Pemegang Kuasa :</label>
		<div class="col-sm-8">
			<input type="text" id="" name="telp_pemegang_kuasa" class="validate[required] text-input form-control numberonly"  value=""> 
			<p><i> *Boleh Dikosongkan</i></p>
		</div>
	</div>
			
	<div class="form-group">
		<label class="col-sm-4 control-label">E-mail Pemohon :</label>
		<div class="col-sm-8">
			<input type="email" id="" name="email_pemohon" class="validate[required] form-control text-input" style="width:80%" value="" required>
		</div>
	</div>		
					
	<hr />
	<center><h4>Alamat Pemohon</h4></center>
	<hr />

	<div class="form-group">
		<label class="col-sm-4 control-label">Provinsi :</label>
		<div class="col-sm-8">
			<select name="provinsi" class="provinsi form-control" required>
				<?php foreach($provinsi as $prov){ ?>
					<option value="<?php echo $prov->kd_prov; ?>" <?php if($prov->kd_prov==12){ echo "selected";} ?>><?php echo $prov->n_propinsi; ?></option>
				<?php } ?>
			</select>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-4 control-label">Kabupaten / Kota :</label>
		<div class="col-sm-8">
			<select name="kabupaten"  class="kabupaten form-control" required>
				<option value="">------------------------ Pilih Kabupaten ------------------------</option>
				<?php foreach($kabupaten as $kab){ ?>
				<option value="<?php echo $kab->kd_kab; ?>"><?php echo $kab->n_kabupaten; ?></option>
				<?php } ?>
			</select>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-4 control-label">Kecamatan :</label>
		<div class="col-sm-8">
			<select name="kecamatan" class="kecamatan form-control" required>
				<option value="">------------------------ Pilih Kecamatan ------------------------</option>
				<?php /* foreach($kabupaten as $kab){ ?>
					<option value="<?php echo $kab->kd_kab; ?>"><?php echo $kab->n_kabupaten; ?></option>
				<?php } */ ?>
			</select>
		</div>
	</div>


	<div class="form-group">
		<label class="col-sm-4 control-label">Kelurahan / Desa :</label>
		<div class="col-sm-8">
			<select name="kelurahan" class="kelurahan form-control" required>
				<option value="">------------------------ Pilih Kelurahan ------------------------</option>
				<?php /* foreach($kabupaten as $kab){ ?>
					<option value="<?php echo $kab->kd_kab; ?>"><?php echo $kab->n_kabupaten; ?></option>
				<?php } */ ?>
			</select>
		</div>
	</div>				
					
					
	<div class="form-group">
		<label class="col-sm-4 control-label">Alamat :</label>
		<div class="col-sm-8">
			<textarea name="alamat_pemohon" class="validate[required] form-control text-input" style="width:100%;resize:vertical" rows="5" placeholder="Alamat Pemohon" required></textarea>	
		</div>
	</div>						
					
    <!--untuk capcha by PBS-->
	<div class="form-group">
	  	<div class="col-sm-offset-4 col-sm-10">
	  		<table>
                <tr>
                    <td width="5"></td>
                    <td>
                    	<!-- Update Google re-captcha Nirwan -->
                        <div class="g-recaptcha" data-sitekey="6LdJzMgZAAAAAOKKMaJ1L4GOb0f0qKsA1ZZhbfhu" data-callback="enableBtn" data-expired-callback="disableBtn"></div>
                    </td>
                    <td width="5"></td>
                    <td>
                        &nbsp;
                    </td>
                </tr>
            </table>
			<!-- <span id="capcha"></span>
            <img src="<?php //echo base_url() . '/assets/css/default/icon/reset.png' ?>" title="Lihat Gambar Lain" class="klic" onclick="reload_get()">
			<p><em>isi textbox sesuai dengan captcha yang anda lihat pada gambar diatas </em></p>
            <input type="text" id="isi_capca2" name="isi_capca2" style="width: 200px" required>
            <br/>
            <span id="isi_capca_error" style="color: red;"> </span> -->
      	</div>  
	</div>
    <!--EOF() untuk capcha by PBS-->

					
	<div class="form-group">
	    <div class="col-sm-offset-4 col-sm-10">
	    	<input type="submit" value="Simpan" class='btn btn-primary' id="btnSubmit" onclick="return ajaxFileUpload();" style="float: left; margin-right: 5px; margin-left: 0px;" disabled="disabled" />
	    </div>
	</div>
	
</form>
<?php
								} ?>
</div>

<div class="kanan">
    <?php //echo "$menu" ?>
    <?php echo "$menu1" ?>
</div>

<script>
    function enableBtn(){
        document.getElementById("btnSubmit").disabled = false;
    }

    function disableBtn(){
        document.getElementById("btnSubmit").disabled = true;
    }
</script>
				
<script>
    function reload_get(){
        $("#capcha").load(site+'main/pendaftaranbaru/get_capcha');
    }
    $(document).ready(function() {
        //ini config tiny
        $("#formID").submit(function(){
            $("#error_data").val('0');
            if ($("#isi_capca").val() != $("#isi_capca2").val()){
                $("#isi_capca_error").html("<p>Data Tidak Sama Dengan Gambar</p>");
                $("#capcha").load(site+'main/pendaftaranbaru/get_capcha');
                $("#error_data").val('1');
            }
            if ($("#error_data").val() == 1){
                return false;
            }
        });
        $("#capcha").load(site+'main/pendaftaranbaru/get_capcha');
    });
</script>

<script>
	$(function(){
		$('.numberonly').keyup(function () { 
			this.value = this.value.replace(/[^0-9\.]/g,'');
		});
	});
</script>