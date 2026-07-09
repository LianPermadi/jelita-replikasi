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
<?php 
if ($integrasi != 0) { ?>
  <script>
    $(document).ready(function() {
      $('#dataTables').DataTable();

    $("#reset").click(function(){
    document.getElementById('dkp').value= "";
    document.getElementById('iddkp').value= "";
  });

  } );
  </script>
<?php }
 ?>

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
          <li>Isi data teknis permohonan, Gunakan Peta yang tersedia untuk mengisi Longitude/Latitude Titik Lokasi Izin anda, jika izin tidak memiliki lokasi, silahkan arahkan titik lokasi ke alamat perusahaan/pemohon, lalu klik <a class="buton">Lanjutkan</a></li>
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
            <div class="col-md-10">Permohonan Izin Baru Step 3</div>
            <div class="col-md-2">
              <?php echo anchor('main/permohonan/step2/'.$id_sektor, 'Kembali',array("class"=>"btn btn-block btn-primary")) ?>
            </div>
          </div>
        </div>
        <div class="panel-body">
          <div class="col-md-12">
            <!-- <form role="form" method="post" action="<?php echo base_url() . 'main/permohonan/step4/'.$id.''; ?>"> -->
            <form role="form" method="post" action="<?php echo base_url() . 'main/permohonan/savestep3/'.$id.''; ?>">
              <input type="hidden" name="id" value="<?php echo $id; ?>">
              <input type="hidden" name="jml_properti" value="<?php echo $jml; ?>">
              <input type="hidden" name="sektor" value="<?php echo $sektor; ?>">
              <input type="hidden" name="uuid" value="<?php echo $uuid; ?>">
              <input type="hidden" name="integrasi" value="<?php echo $integrasi; ?>">
              
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
                <label class="col-md-3 text"><?php echo $data->n_property.'tampil dimana ini'; ?></label>
                <div class="col-md-9">
                  <input class="form-control" placeholder="<?php echo $data->n_property; ?>" name="<?php echo $data->id; ?>" value="" required><br>
                </div>
              </div>
              <?php } */ ?>
              
              <center class="notif" >
                <h4>
                  <span style="color: Red">Data wajib diisi dan pastikan format data sudah benar, lalu klik tombol Lanjutkan</span>
                </h4>
              </center>
              <br>
              
              <div class="form-group">
                <label class="col-md-3 text">
                  Nomor Induk Berusaha (NIB)
                </label>
                <div class="col-md-9">
                <input type="text" class="form-control" name="nib" required><br>  
                </div>
              </div>

              <?php if ($judul->indeks == "AKDP") { ?>
                <div class="form-group">
                <label class="col-md-3 text">
                 Nomor Sertifikat Setandar (SS)
                </label>
                <div class="col-md-9">
                <input type="text" class="form-control" name="noss" required><br>  
                </div>
              </div>
              <?php } ?>
              
              <?php 
              	
              $no=1;
              $jumlah_semua = 1;
              $eksis	= $this->db->query("select * from tmpermohonan_portal where uuid='".$uuid."' order by id desc")->first_row();
              while($no<=100){
                $tek = "var_teknis".$no;
                $dt_teknis = "dt_teknis".$no;
                $prop = $property[$tek];
              
                if(empty($prop)){
                  break;
                }
                if($uuid == ''){
                  $dt_teknis1 = '';
                }else{
                  $cek_posisi = strpos($eksis->dt_teknis1,'^'); 
                  $dt_teknis1 = substr($eksis->dt_teknis1,0,$cek_posisi);
                }
                
                $array = explode("^",$prop);
                ?>
                <?php 
                if($array[11]=="Ya" && $array[6] == "Ya"){ ?>
                  <div class="form-group">
                    <label class="col-md-3 text"><?php echo $array[1]; if($array[9]=="Integer"){ echo "<br><i>*input hanya angka</i>";} ?></label>
                    <div class="col-md-9">
                      <?php if ($array[1] == "Nomor Kendaraan") { ?>
                        <input type="hidden" class="form-control" name="nokend" value="<?php echo $array[0]; ?>">
                      <?php } ?>

                      <?php if ($array[1] == "Nomor Uji") { ?>
                        <input type="hidden" class="form-control" name="nouji" value="<?php echo $array[0]; ?>">
                      <?php } ?>

                      <?php if ($array[1] == "Lintasan Trayek/Wilayah Operasi") { ?>
                        <input type="hidden" class="form-control" name="lintasan" value="<?php echo $array[0]; ?>">
                      <?php } ?>

                      <?php 
                      if($array[9]=="TextBox"){ ?>
                        <input class="form-control" name="var_teknis<?php echo $array[0]; ?>" value="<?php echo $dt_teknis1; ?>" autocomplete="off" required><br>
                        <?php
                      }else{
                        if($array[9]=="Integer"){ ?>
                          <input class="form-control numberonly" name="var_teknis<?php echo $array[0]; ?>" value="<?php echo $dt_teknis1; ?>" autocomplete="off" required><br>
                          <?php
                        }else{
                          if($array[9]=="ComboBox"){ 
                            $option = explode(";",$array[10]);
                            ?>
                            <select class="form-control" name="var_teknis<?php echo $array[0]; ?>" required>
                              <?php
                              foreach($option as $op){ ?>
                                <option value="<?php echo $op; ?>"><?php echo $op; ?></option>
                                <?php 
                              } ?>
                            </select><br>
                            <?php 
                          }else{
                            if($array[9]=="Tanggal"){ ?>
                              <input class="form-control datepicker" type="date" name="var_teknis<?php echo $array[0]; ?>" value="<?php echo $dt_teknis1; ?>" autocomplete="off" required><br>
                              <?php
                            }else{ ?>
                              <?php echo $array[9];?>
                              <?php
                            } 
                          }
                        }
                      }
                      ?>
                    </div>
                  </div>
                  <?php 
                }else{
                  ?>	
                  <div class="form-group">
                    <input class="form-control" type="hidden" name="var_teknis<?php echo $array[0]; ?>" value=" ">
                  </div>
                  <?php 
                } 
                $no++;
              }
              ?>
              <br>

              <?php if ($integrasi == 1 && $this->session->userdata("username") == "nirwan") { //$integrasi 1 = sireon ?>
                <div class="form-group">
                  <label class="col-md-3 text">Rekomendasi DKP</label>
                  <div class="col-md-9">
                  <table width="100%" cellpadding="0" cellspacing="0" id="dataTables">
                    <thead>
                      <tr>
                        <th ><b>NO </b>  </th>
                        <th><b>NOMOR PENDAFTARAN </b>  </th>
                        <th><b>NAMA PEMOHON</b> </th>
                        <th><b>JENIS REKOMENDASI</b></th>
                        <th><b>AKSI</b></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $n=1;
                      foreach($datintegrasi as $row) {
                            echo "<tr>
                                    <td style='text-align:center;'>".$n."</td>
                                    <td id='link".$row->id."'><input type='hidden' id='int".$row->id."' value='".$row->id."'>".$row->no_pendaftaran."</td>
                                    <td>".$row->pemohon."</td>
                                    <td>".$row->jenis."</td>
                                    <td> <button type='button' class='btn btn-primary' onclick='txtValDisp($row->id);'>Pilih</button></td>
                                  </tr>
                                 ";
                            $n++;
                      }
                      ?>
                    </tbody>
                  </table>
                  <br>
                </div>
                <label class="col-md-3 text">&nbsp;</label>
                <div class="col-md-8">
                  <input type="hidden" id="iddkp" name="iddkp">
                  <input type="text" id="dkp" name="dkp" class="form-control" onkeypress="return false;" onpaste="return false;" style="background: #D3D3D3;" placeholder="Silahkan Pilih Data Diatas" required>
                </div>
                <div class="col-md-1">
                  <button type="button" class="btn btn-warning" id="reset">Reset</button>
                </div>
                <br>
              </div>
              <br>
              <br>
              <div class="form-group">
                <div class="col-md-12">
                  &nbsp;
                </div>
              </div>
              <?php } ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- ===================== FORM: PROVINSI ===================== -->
<div class="form-group">
  <label class="col-sm-4 control-label">Provinsi :</label>
  <div class="col-sm-8">
    <select name="nprov" class="form-control" id="provinsi" required>
      <option value="">-- Pilih Provinsi --</option>
      <?php foreach ($provinsi as $prov) { ?>
        <option value="<?php echo $prov->kd_prov; ?>" <?php if ($prov->kd_prov == 34) { echo 'selected'; } ?>>
          <?php echo $prov->n_propinsi; ?>
        </option>
      <?php } ?>
    </select>
  </div>
</div>
<br>

<!-- ===================== FORM: KAB/KOTA ===================== -->
<div class="form-group">
  <label class="col-sm-4 control-label">Kabupaten / Kota :</label>
  <div class="col-sm-8">
    <select name="kabupaten" class="form-control" id="kabupaten" required>
      <option value="">------------------------ Pilih Kabupaten / Kota ------------------------</option>
    </select>
  </div>
</div>

<br>
<!-- ===================== FORM: KECAMATAN ===================== -->
<div class="form-group">
  <label class="col-sm-4 control-label">Kecamatan :</label>
  <div class="col-sm-8">
    <select name="kecamatan" class="form-control" id="kecamatan" required>
      <option value="">------------------------ Pilih Kecamatan ------------------------</option>
    </select>
  </div>
</div>

<br>
<!-- ===================== FORM: KELURAHAN/DESA ===================== -->
<div class="form-group">
  <label class="col-sm-4 control-label">Kelurahan / Desa :</label>
  <div class="col-sm-8">
    <select name="kelurahan" class="form-control" id="kelurahan" required>
      <option value="">------------------------ Pilih Kelurahan / Desa ------------------------</option>
    </select>
  </div>
</div>

<br>
<br>
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
                <label class="col-md-3 text">Titik Lokasi</label>
                <div class="col-md-9">
                  <div id="map_div" style="height: 350px;"></div>
                  <br><small>Geser penanda merah <img src="<?php echo base_url(); ?>assets/images/za_marker.png">&nbsp; ke titik lokasi yang dituju kemudian klik penanda tersebut untuk memilih Longitude / Latitude lokasi anda (LOKASI HARUS DI JAWA BARAT)</small>
                </div>
              </div>
              <br><br>
<div class="form-group">
  <label class="col-md-3 text">Long / Lat</label>

  <div class="col-md-4">
    <input
      type="number"
      step="any"
      id="maps_longitude"
      name="maps_longitude"
      class="form-control"
      inputmode="decimal"
      placeholder="Longitude (contoh: 133.5123)"
      required>
  </div>

  <div class="col-md-4">
    <input
      type="number"
      step="any"
      id="maps_latitude"
      name="maps_latitude"
      class="form-control"
      inputmode="decimal"
      placeholder="Latitude (contoh: -1.2345)"
      required>
    <br>
  </div>
</div>



                <br>
               <?php 
               		if ($judul->indeks != "AKDP") { ?>
               			<div class="form-group">
		                <label class="col-md-3 text"><?php echo "Lokasi / Objek Izin"; ?></label>
		                <div class="col-md-9">
		                    <textarea class="form-control"  name="lokasi_izin" rows="5" style="resize:vertical" required></textarea>
		                </div>
		              </div>
               	<?php } ?>
              
              <br>
              <script>
                $(function(){
                  $('.numberonly').keyup(function () { 
                    this.value = this.value.replace(/[^0-9\.]/g,'');
                  });
                });
              </script>
              <?php
              if($no==1){ ?>
                <center><h2>Tidak Ada Data Properti yang Harus Anda Lengkapi, Silahkan Klik Tombol Lanjutkan</h2></center>
                <?php
              } ?>
              
              <input type="hidden" name="jml_properti" value="<?php echo $no-1; ?>">
              <div class="form-group">
                <label class="col-md-12 text">&nbsp;</label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-9 text">&nbsp;</label>
                <div class="col-md-3">
                  <button type="submit" class="btn btn-block btn-primary">Lanjutkan</button>
                  <?php //echo anchor("main/permohonan/step3/".$id."", 'Lanjutkan',array("class"=>"btn btn-block btn-primary")) ?>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div><!-- /.col-->
  </div><!-- /.row -->
</div><!--/.main-->

  </div>
</div>
<script>
  $(function () {
    $('.datepicker').datepicker()
  });
</script>
<script type="text/javascript">
function txtValDisp(rowID){
    var linkVal = document.getElementById('link'+rowID+'').innerHTML.replace(/<\/?[^>]+(>|$)/g, "\n");
    var intVal  = document.getElementById('int'+rowID+'').value;
    document.getElementById("dkp").value = linkVal;
    document.getElementById("iddkp").value = intVal;
    }
</script>
