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
									<input class="form-control" placeholder="" name="nama_pemohon" value="<?php echo $data->namaPerusahaan; ?>" required readonly><br>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 text">Nama Pemegang Kuasa :</label>
								<div class="col-md-9">
									<input class="form-control" name="nama_pemegang_kuasa" value="<?php echo $data->namaPemohon; ?>"><sup><i>Boleh Dikosongkan</i></sup><br>
								</div>
							</div>
						
							<div class="form-group">
								<label class="col-md-3 text">No KTP Perusahaan :</label>
								<div class="col-md-9">
									<!--<input class="form-control numberonly" maxlength="16" placeholder="" name="no_ktp_pemohon" value="<?php echo $data->ktpPerusahaan; ?>" required><br>-->
									<input class="form-control" maxlength="16" placeholder="" name="no_ktp_perusahaan" value="<?php echo $data->ktpPerusahaan; ?>" required><br>
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-3 text">No NPWP Perusahaan :</label>
								<div class="col-md-9">
									<input class="form-control" placeholder="" maxlength="20" name="no_npwp_pemohon" value="<?php echo $data->npwpPerusahaan; ?>"><sup><i>Boleh Dikosongkan</i></sup><br>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 text">No KTP Pemohon :</label>
								<div class="col-md-9">
									<!--<input class="form-control numberonly" maxlength="16" placeholder="" name="no_ktp_pemohon" value="<?php echo $data->ktpPerusahaan; ?>" required><br>-->
									<input class="form-control" maxlength="16" placeholder="" name="no_ktp_pemohon" value="<?php echo $data->ktpPemohon; ?>" required><br>
								</div>
							</div>
							
							<center><h4>Alamat</h4></center>
							

<!-- ===================== FORM: PROVINSI ===================== -->
<div class="form-group">
  <label class="col-sm-4 control-label">Provinsi :</label>
  <div class="col-sm-8">
    <select name="provinsi2" class="form-control" id="provinsi" required>
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
    <select name="kabupaten2" class="form-control" id="kabupaten" required>
      <option value="">------------------------ Pilih Kabupaten / Kota ------------------------</option>
    </select>
  </div>
</div>

<!-- ===================== FORM: KECAMATAN ===================== -->
<div class="form-group">
  <label class="col-sm-4 control-label">Kecamatan :</label>
  <div class="col-sm-8">
    <select name="kecamatan2" class="form-control" id="kecamatan" required>
      <option value="">------------------------ Pilih Kecamatan ------------------------</option>
    </select>
  </div>
</div>

<!-- ===================== FORM: KELURAHAN/DESA ===================== -->
<div class="form-group">
  <label class="col-sm-4 control-label">Kelurahan / Desa :</label>
  <div class="col-sm-8">
    <select name="kelurahan2" class="form-control" id="kelurahan" required>
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

  var defaultProv = $('#provinsi').val();
  if (defaultProv) {
    loadKabupaten(defaultProv);
  }
});
</script>		
							
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
									<input class="form-control" name="nama_perusahaan" value="<?php echo $data->namaPerusahaan; ?>" required readonly><br>
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
								<label class="col-md-3 text">No KTP Perusahaan :</label>
								<div class="col-md-9">
									<!--<input class="form-control numberonly" maxlength="16" placeholder="" name="no_ktp_pemohon" value="<?php echo $data->ktpPerusahaan; ?>" required><br>-->
									<input class="form-control" maxlength="16" placeholder="" name="no_ktp_perusahaan" value="<?php echo $data->ktpPerusahaan; ?>" required><br>
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
						<!-- Modularized and reusable address selection components with logging -->
<div class="form-group">
    <label class="col-md-3 text">Provinsi :</label>
    <div class="col-md-9">
        <select class="form-control provinsi2" name="provinsi2" required>
			<option value="">------------------------ Pilih Kabupaten / Kota ------------------------</option>
            <?php foreach ($propinsi2 as $prov): ?>
                <option value="<?php echo $prov->kd_prov; ?>" <?php echo ($prov->kd_prov == $data->propinsi2) ? 'selected' : ''; ?>><?php echo $prov->n_propinsi; ?></option>
            <?php endforeach; ?>
        </select><br>
    </div>
</div>

<div class="form-group">
    <label class="col-md-3 text">Kabupaten / Kota :</label>
    <div class="col-md-9">
        <select class="form-control kabupaten2" name="kabupaten2" required>
            <option value="">------------------------ Pilih Kabupaten / Kota ------------------------</option>
            <?php foreach ($kabupaten2 as $kab): ?>
                <option value="<?php echo $kab->id; ?>" <?php echo ($kab->id == $data->kabupaten2) ? 'selected' : ''; ?>><?php echo $kab->n_kabupaten; ?></option>
            <?php endforeach; ?>
        </select><br>
    </div>
</div>

<div class="form-group">
    <label class="col-md-3 text">Kecamatan :</label>
    <div class="col-md-9">
        <select class="form-control kecamatan2" name="kecamatan2" required>
            <option value="">------------------------ Pilih Kecamatan ------------------------</option>
            <?php foreach ($kecamatan2 as $kec): ?>
                <option value="<?php echo $kec->id; ?>" <?php echo ($kec->id == $data->kecamatan2) ? 'selected' : ''; ?>><?php echo $kec->n_kecamatan; ?></option>
            <?php endforeach; ?>
        </select><br>
    </div>
</div>

<div class="form-group">
    <label class="col-md-3 text">Kelurahan / Desa :</label>
    <div class="col-md-9">
        <select class="form-control kelurahan2" name="kelurahan2" required>
            <option value="">------------------------ Pilih Kelurahan / Desa ------------------------</option>
            <?php foreach ($kelurahan2 as $kel): ?>
                <option value="<?php echo $kel->id; ?>" <?php echo ($kel->id == $data->kelurahan2) ? 'selected' : ''; ?>><?php echo $kel->n_kelurahan; ?></option>
            <?php endforeach; ?>
        </select><br>
    </div>
</div>

<script>
$(function(){
    function populateOptions(selector, dataArray) {
        console.log("Mengisi data untuk", selector);
        selector.empty();
        dataArray.forEach(function(item) {
            console.log("Menambahkan opsi:", item);
            const opt = $('<option>', { value: item.id, text: item.name || item.nama });
            selector.append(opt);
        });
    }
	$('.provinsi2').on('change', function(){
        const provinsi2 = $(this).val();
        // console.log("provinsi2 dipilih:", provinsi2);

		$.get("https://perijinan.papuabaratprov.go.id/main/pendaftaranbaru/getkabupaten/" + provinsi2, function(data){
			try {
				// Jangan parse lagi, langsung pakai data
				populateOptions($('.kabupaten2'), data);
			} catch (e) {
				console.error("Gagal parse kabupaten2:", e);
			}
		});

        $('.kabupaten2').html('<option value="">------------------------ Pilih Kelurahan ------------------------</option>');
    });

    $('.kabupaten2').on('change', function(){
        const kabupaten2 = $(this).val();
        // console.log("Kabupaten2 dipilih:", kabupaten2);

		$.get("https://perijinan.papuabaratprov.go.id/main/pendaftaranbaru/getkecamatan/" + kabupaten2, function(data){
			try {
				// Jangan parse lagi, langsung pakai data
				// console.log("Kecamatan2 response:", data);
				populateOptions($('.kecamatan2'), data);
			} catch (e) {
				console.error("Gagal parse kecamatan2:", e);
			}
		});

        $('.kelurahan2').html('<option value="">------------------------ Pilih Kelurahan ------------------------</option>');
    });

    $('.kecamatan2').on('change', function(){
        const kecamatan = $(this).val();
        // console.log("Kecamatan2 dipilih:", kecamatan);

        $.post("https://perijinan.papuabaratprov.go.id/main/pendaftaranbaru/getkelurahan", { data: kecamatan }, function(data){
            try {
                const result = JSON.parse(data);
                // console.log("Kelurahan2 response:", result);
                populateOptions($('.kelurahan2'), result);
            } catch (e) {
                console.error("Gagal parse kelurahan2:", e);
            }
        });
    });
});
</script>
							
							<div class="form-group">
								<label class="col-md-3 text">Alamat  :</label>
								<div class="col-md-9">
									<textarea class="form-control" rows="5" name="alamat_perusahaan" style="resize: vertical;"  required><?php echo str_replace("<br />","",$data->almtPerusahaan); ?></textarea><br>
								</div>
							</div>
							
							<center><h4>Alamat Direktur</h4></center>
							
							<div class="form-group">
<!-- ===================== FORM: PROVINSI ===================== -->
<div class="form-group">
  <label class="col-sm-4 control-label">Provinsi :</label>
  <div class="col-sm-8">
    <select name="provinsi1" class="form-control" id="provinsi" required>
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
    <select name="kabupaten1" class="form-control" id="kabupaten" required>
      <option value="">------------------------ Pilih Kabupaten / Kota ------------------------</option>
    </select>
  </div>
</div>

<!-- ===================== FORM: KECAMATAN ===================== -->
<div class="form-group">
  <label class="col-sm-4 control-label">Kecamatan :</label>
  <div class="col-sm-8">
    <select name="kecamatan1" class="form-control" id="kecamatan" required>
      <option value="">------------------------ Pilih Kecamatan ------------------------</option>
    </select>
  </div>
</div>

<!-- ===================== FORM: KELURAHAN/DESA ===================== -->
<div class="form-group">
  <label class="col-sm-4 control-label">Kelurahan / Desa :</label>
  <div class="col-sm-8">
    <select name="kelurahan1" class="form-control" id="kelurahan" required>
      <option value="">------------------------ Pilih Kelurahan / Desa ------------------------</option>
    </select>
  </div>
</div>
							
							<div class="form-group">
								<label class="col-md-3 text">Alamat :</label>
								<div class="col-md-9">
									<textarea class="form-control" rows="5" name="alamat_direktur" style="resize: vertical;" required><?php echo str_replace("<br />","",$data->almtPemohon); ?></textarea><br>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 text">E-mail Perusahaan :</label>
								<div class="col-md-9">
									<input class="form-control"  type="email" name="email_perusahaan" value="<?php echo $data->emailPerusahaan; ?>" required><br>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 text">E-mail Direktur :</label>
								<div class="col-md-9">
									<input class="form-control" type="email" name="email_direktur"  value="<?php echo $data->emailPemohon; ?>" required><br>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 text">Telp Perusahaan :</label>
								<div class="col-md-9">
									<input class="form-control numberonly" name="telp_direktur" value="<?php echo $data->telpPerusahaan; ?>" required><br>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 text">HP Pemegang Kuasa :</label>
								<div class="col-md-9">
									<input class="form-control numberonly" name="telp_perusahaan" value="<?php echo $data->telp_penanggung_jawab; ?>"><sup><i>Boleh Dikosongkan</i></sup><br>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 text">HP Direktur :</label>
								<div class="col-md-9">
									<input class="form-control numberonly" name="telp_pemegang_kuasa" value="<?php echo $data->telpPemohon; ?>" required><br>
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
						</form>
					</div>
				</div>
			</div>
		</div><!-- /.col-->
	</div><!-- /.row -->
	
</div><!--/.main-->
