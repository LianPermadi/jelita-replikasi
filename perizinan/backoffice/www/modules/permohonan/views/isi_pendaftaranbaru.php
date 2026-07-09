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
			
			$(".kelurahan").html('');
			var optn2 = document.createElement("OPTION");
			optn2.text = "------------------------ Pilih Kelurahan ------------------------";
			optn2.value = "";
			$(".kelurahan").append(optn2);
		});
	});

// $(function(){
//     $('.kecamatan').on('change', function(e){
//         var kecamatan = $(this).val(); // Mengambil nilai id kecamatan dari dropdown
//         if (kecamatan !== "") {
//             $.ajax({
//                 url : "pendaftaranbaru/getkelurahan",
//                 type: "post",
//                 data: {data: kecamatan}, // Mengirim id kecamatan sebagai data ke server
//                 success : function(data){
//                     $(".kelurahan").html('');
//                     var kelurahanList = JSON.parse(data);
//                     $.each(kelurahanList, function(index, kelurahan) {
//                         var optn2 = document.createElement("OPTION");
//                         optn2.text = kelurahan.n_kelurahan;
//                         optn2.value = kelurahan.kd_kel;
//                         $(".kelurahan").append(optn2);
//                     });
//                 }
//             });
//         }
//     });
// });
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
					// console.log(data);
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
			
			$(".kabupaten").html('');
			var optn2 = document.createElement("OPTION");
			optn2.text = "------------------------ Pilih Kabupaten ------------------------";
			optn2.value = "";
			$(".kabupaten").append(optn2);
			
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

<style type="text/css">
body {
    height: initial !important;
    width: initial !important;
}

html {
    height: initial !important;
    width: initial !important;
}

</style>

<h2>Pendaftaran Pemohon Online</h2>

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
// var_dump($this->konfig_izin->status);die();
								if ($this->konfig_izin->status == 1) {
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
			  <input type="radio" class="radio" name="jenis" value="pemohon" checked>
			   Perorangan
			  </label>
			</div>

			<div class="radio">
			  <label>
			  <input type="radio" class="radio" name="jenis" value="perusahaan">
			   Perusahaan
			  </label>
			</div>
	    </div>
	</div>
			
				
	<div class="form-group">
		<label class="col-sm-4 control-label" id="tipepemohon">Nama Pemohon :</label>
		<div class="col-sm-8">
			<input type="text" id="" name="nama_pemohon" class="validate[required] text-input form-control"  value="" required>
			<i><p id="ketpemohon"> *Nama Pemohon Sesuai Kartu Identitas</p></i>
		</div>
	</div>
					
	<div class="form-group" style="display:none" id="direktur">
		<label class="col-sm-4 control-label">Nama Direktur :</label>
		<div class="col-sm-8">
			<input type="text" id="direktur2" name="nama_direktur" class="validate[required] text-input form-control">
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-4 control-label">Nama Pemegang Kuasa :</label>
		<div class="col-sm-8">
			<input type="text" id="" name="nama_pemegang_kuasa" class="validate[required] text-input form-control" value=""> 
			<p><i> *Boleh Dikosongkan</i></p>
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

<!-- ===================== FORM: PROVINSI ===================== -->
<div class="form-group">
  <label class="col-sm-4 control-label">Provinsi :</label>
  <div class="col-sm-8">
    <select name="provinsi" class="form-control" id="provinsi" required>
      <option value="">-- Pilih Provinsi --</option>
      <?php foreach ($provinsi as $prov) { ?>
        <option value="<?php echo $prov->kd_prov; ?>" <?php if ($prov->kd_prov == 34) { echo 'selected'; } ?>>
          <?php echo $prov->n_propinsi; ?>
        </option>
      <?php } ?>
    </select>
  </div>
</div>

<!-- ===================== FORM: KAB/KOTA ===================== -->
<div class="form-group">
  <label class="col-sm-4 control-label">Kabupaten / Kota :</label>
  <div class="col-sm-8">
    <select name="kabupaten" class="form-control" id="kabupaten" required>
      <option value="">------------------------ Pilih Kabupaten / Kota ------------------------</option>
    </select>
  </div>
</div>

<!-- ===================== FORM: KECAMATAN ===================== -->
<div class="form-group">
  <label class="col-sm-4 control-label">Kecamatan :</label>
  <div class="col-sm-8">
    <select name="kecamatan" class="form-control" id="kecamatan" required>
      <option value="">------------------------ Pilih Kecamatan ------------------------</option>
    </select>
  </div>
</div>

<!-- ===================== FORM: KELURAHAN/DESA ===================== -->
<div class="form-group">
  <label class="col-sm-4 control-label">Kelurahan / Desa :</label>
  <div class="col-sm-8">
    <select name="kelurahan" class="form-control" id="kelurahan" required>
      <option value="">------------------------ Pilih Kelurahan / Desa ------------------------</option>
    </select>
  </div>
</div>

<!-- ===================== SCRIPTS ===================== -->
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script>
$(function () {
  // Util: bangun <option> dengan placeholder + filter duplikat nama
  function buildOptions(data, placeholder) {
    var html = '';
    if (placeholder) html += '<option value="">' + placeholder + '</option>';

    var seen = {}; // kunci normalisasi nama untuk hapus duplikat
    for (var i = 0; i < data.length; i++) {
      var id = data[i].id, name = data[i].name;
      if (!id || !name) continue;
      var key = String(name).toLowerCase().replace(/[^a-z0-9]+/g, '');
      if (seen[key]) continue;
      seen[key] = 1;
      html += '<option value="' + id + '">' + name + '</option>';
    }
    return html;
  }

  function resetKecamatanKelurahan() {
    $('#kecamatan').html('<option value="">-- Pilih Kecamatan --</option>');
    $('#kelurahan').html('<option value="">-- Pilih Kelurahan / Desa --</option>');
  }

  // AJAX: load kabupaten by provinsi
  function loadKabupaten(prov_id, done) {
    $('#kabupaten').html('<option value="">Loading kabupaten... 🌀</option>');
    resetKecamatanKelurahan();

    $.ajax({
      url: '<?php echo base_url()."main/pendaftaranbaru/getkabupaten2"; ?>/' + encodeURIComponent(prov_id),
      type: 'GET',
      dataType: 'json'
    })
    .done(function (data) {
      $('#kabupaten').html(buildOptions(data, '-- Pilih Kabupaten / Kota --'));
      if (typeof done === 'function') done();
    })
    .fail(function () {
      $('#kabupaten').html('<option value="">-- Gagal load kabupaten --</option>');
    });
  }

  // AJAX: load kecamatan by kabupaten
  function loadKecamatan(kab_id, done) {
    $('#kecamatan').html('<option value="">Loading kecamatan... 🌀</option>');
    $('#kelurahan').html('<option value="">-- Pilih Kelurahan / Desa --</option>');

    $.ajax({
      url: '<?php echo base_url()."main/pendaftaranbaru/getkecamatan2"; ?>/' + encodeURIComponent(kab_id),
      type: 'GET',
      dataType: 'json'
    })
    .done(function (data) {
      $('#kecamatan').html(buildOptions(data, '-- Pilih Kecamatan --'));
      if (typeof done === 'function') done();
    })
    .fail(function (xhr) {
      alert("Gagal mengambil data kecamatan!\n" + (xhr.responseText || ''));
      $('#kecamatan').html('<option value="">-- Gagal load kecamatan --</option>');
    });
  }

  // AJAX: load kelurahan by kecamatan
  function loadKelurahan(kec_id) {
    $('#kelurahan').html('<option value="">Loading kelurahan... 🚴</option>');

    $.ajax({
      url: '<?php echo base_url()."main/pendaftaranbaru/getkelurahan2"; ?>/' + encodeURIComponent(kec_id),
      type: 'GET',
      dataType: 'json'
    })
    .done(function (data) {
      $('#kelurahan').html(buildOptions(data, '-- Pilih Kelurahan / Desa --'));
    })
    .fail(function (xhr) {
      alert("Gagal mengambil data kelurahan!\n" + (xhr.responseText || ''));
      $('#kelurahan').html('<option value="">-- Gagal load kelurahan --</option>');
    });
  }

  // Event: perubahan provinsi
  $('#provinsi').on('change', function () {
    var prov_id = $(this).val();
    if (prov_id) {
      loadKabupaten(prov_id);
    } else {
      $('#kabupaten').html('<option value="">-- Pilih Kabupaten / Kota --</option>');
      resetKecamatanKelurahan();
    }
  });

  // Event: perubahan kabupaten
  $('#kabupaten').on('change', function () {
    var kab_id = $(this).val();
    if (kab_id) {
      loadKecamatan(kab_id);
    } else {
      resetKecamatanKelurahan();
    }
  });

  // Event: perubahan kecamatan
  $('#kecamatan').on('change', function () {
    var kec_id = $(this).val();
    if (kec_id) {
      loadKelurahan(kec_id);
    } else {
      $('#kelurahan').html('<option value="">-- Pilih Kelurahan / Desa --</option>');
    }
  });

  // AUTO-LOAD saat page selesai dimuat:
  // Jika server sudah men-set default kd_prov=34 (selected di HTML),
  // langsung muat daftar kabupaten/kota tanpa perlu action user.
  var defaultProv = $('#provinsi').val();
  if (defaultProv) {
    loadKabupaten(defaultProv);
    // Jika ingin otomatis memilih kabupaten pertama lalu muat kecamatan, aktifkan:
    // loadKabupaten(defaultProv, function () {
    //   $('#kabupaten option:eq(1)').prop('selected', true).trigger('change');
    // });
  }
});
</script>			
					
					
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
                        <div class="g-recaptcha" data-sitekey="6LfxoB0pAAAAAB7cuTnnMCbDYSPLanIIlJDl7Xlg" data-callback="enableBtn" data-expired-callback="disableBtn"></div>
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

<script>
$(document).ready(function() {
    $('#form').validate();
    $("#tabs").tabs();

    $('a[rel*=pemohon_box]').facebox();
    $('a[rel*=daftar_box]').facebox();
    $('a[rel*=perusahaan_box]').facebox();

    $("#inputTanggal1, #inputTanggal2").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        closeText: 'X'
    });

    $('#propinsi_pemohon_id').change(function() {
        $.post(base_url + 'pelayanan/pendaftaran/kabupaten_pemohon', { propinsi_id: $('#propinsi_pemohon_id').val() },
            function(data) {
                $('#show_kabupaten_pemohon').html(data);
                $('#show_kecamatan_pemohon').html('Data Tidak tersedia');
                $('#show_kelurahan_pemohon').html('Data Tidak tersedia');
            }
        );
    });

    $('#propinsi_usaha_id').change(function() {
        $.post(base_url + 'pelayanan/pendaftaran/kabupaten_usaha', { propinsi_id: $('#propinsi_usaha_id').val() },
            function(data) {
                $('#show_kabupaten_usaha').html(data);
                $('#show_kecamatan_usaha').html('Data Tidak tersedia');
                $('#show_kelurahan_usaha').html('Data Tidak tersedia');
            }
        );
    });

    $('#kabupaten_lok_id').change(function() {
        $.post(base_url + 'pelayanan/pendaftaran/kecamatan_lok', { kabupaten_id: $('#kabupaten_lok_id').val() },
            function(data) {
                $('#show_kecamatan_lok').html(data);
                $('#show_kelurahan_lok').html('Data Tidak tersedia');
            }
        );
    });
});

function show_npwp(form) {
    var reg = form.nodaftar.value;
    var npwp = form.npwp_id.value;

    if (npwp.length == 0) {
        alert('Npwp harus diisi');
        return false;
    } else if (reg.length == 0) {
        alert('No daftar Harus diisi');
        return false;
    } else {
        $.post(base_url + 'pelayanan/pendaftaran/pick_perusahaan_data/' + reg, {
                data_npwp_id: $('#npwp_id').val()
            },
            function(response) {
                setTimeout("finishAjax('tabs-2', '" + escape(response) + "')", 400);
            }
        );
        return false;
    }
}

function show_ktp(form) {
    var reg = form.no_refer.value;

    if (reg.length == 0) {
        $('#error_id').html('Id tidak Boleh Kosong');
        return false;
    } else {
        $('#error_id').html('');
        $.post(base_url + 'pelayanan/pendaftaran/pick_penduduk_data', {
                data_no_refer: $('#no_refer').val()
            },
            function(response) {
                setTimeout("finishAjax('tabs-1', '" + escape(response) + "')", 400);
            }
        );
        return false;
    }
}

function finishAjax(id, response) {
    $('#' + id).html(unescape(response)).fadeIn();
}

function Check() {
    var checkboxes = document.getElementsByName('Check_ctr');
    var form = document.forms['form'];

    if (checkboxes[0].checked) {
        form.propinsi_pemohon.disabled = false;
        form.kabupaten_pemohon.disabled = false;
        form.kecamatan_pemohon.disabled = false;
        form.kelurahan_pemohon.disabled = false;
    } else {
        form.propinsi_pemohon.disabled = true;
        form.kabupaten_pemohon.disabled = true;
        form.kecamatan_pemohon.disabled = true;
        form.kelurahan_pemohon.disabled = true;
    }
}

// Add similar function for Check() related to lok
function CheckLok() {
    // Similar logic as Check() for lok fields
}

</script>


<!--validasi-->
<script type="text/javascript">
    $.validator.addMethod('notSelect', function(value, element){
        return (value !=0);
    },'Pilih Opsi Yang Tersedia');
    
    
var site = '<?php echo base_url(); ?>';
   $("#form").validate({
        onkeyup: false,        
         rules:{
            no_refer:{
                remote:{
                    url: site + "pemohon/register_id_exist",
                    type:"post",
                    data:{
                        no_refer: function(){
                            return $("#no_refer").val();
                        }
                    }
                }
            },
            npwp:{
                remote:{
                    url: site + "perusahaan/register_npwp_exist",
                    type:"post",
                    data:{
                        npwp: function(){
                            return $("#npwp").val();
                        }
                    }
                }
            }
        }
        ,
        messages:{
            no_refer:{
                remote:'No referensi sudah digunakan!'
            }
//            ,
//            npwp:{
//                remote:'No NPWP sudah digunakan!'
//            }
//        
        }
    });
</script>

<script type="text/javascript">
$(document).ready(function(){
  $("#nonpwp").keyup(function(){ // Ketika tombol simpan di klik
    var site = '<?php echo site_url('pelayanan/pendaftaran/cek_status_npwp'); ?>';
    var npwp = $('#nonpwp').val();
    var jenis = '<?php echo $jenis_izin->id; ?>';
            $.ajax({
                url:site,
                type:"POST",
                data:"npwp="+npwp+"&jenis="+jenis,
                dataType: 'json',
                success:function(data) {
                    //console.log('ok');
                    nonpwp = data[1];
                    namanpwp = data[2];
                    statnpwp = data[3];

                    //console.log(data[4]);

                    if(data[0] == 'S'){
                        document.getElementById("connect").style.display = "inline";
                        document.getElementById("fail").style.display = "none";
                        document.getElementById("ok").style.display = "none";
                        }
                    else if(data[0] == 'V'){
                        document.getElementById("ok").style.display = "inline";
                        document.getElementById("fail").style.display = "none";
                        }
                    else{
                        document.getElementById("fail").style.display = "inline";
                        document.getElementById("ok").style.display = "none";
                        }
                    if (npwp == '') {
                            document.getElementById("fail").style.display = "none";
                            document.getElementById("ok").style.display = "none";
                            document.getElementById("connect").style.display = "none";
                        }
                },
                error: function(xhr, textStatus, errorThrown){
                   console.log(errorThrown);
                }
            });
  });
});

function statNpwp() {
                        alert("No NPWP : "+nonpwp+"\n"+
                              "Nama : "+namanpwp+"\n"+
                              "Status : "+statnpwp);
                    }
</script>