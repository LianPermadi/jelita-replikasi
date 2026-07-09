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
              <?php echo anchor('main/permohonan/step3/'.$id.'/'.$uuid, 'Kembali',array("class"=>"btn btn-block btn-primary")) ?>
            </div>
          </div>
        </div>
        <div class="panel-body" style="padding:0px">
          <div class="col-md-12">
            <form role="form" id="myform" method="post" enctype="multipart/form-data" action="<?php echo base_url() . 'main/permohonan/addpermohonanbaru'; ?>" onsubmit="return beforeSubmit()">
              <input type="hidden" name="id" value="<?php echo $id; ?>">
              <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
              <input type="hidden" name="id_pemohon" value="<?php echo $id_pemohon; ?>">
              <input type="hidden" name="jml_properti" value="<?php echo $jml; ?>">
              <input type="hidden" name="sektor" value="<?php echo $sektor; ?>">
              <input type="hidden" name="integrasi" value="<?php echo $integrasi; ?>">
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
                <label class="col-md-4" style="padding-bottom:40px">
                  <center>Silahkan Lengkapi Persyaratan Berikut :<br>
                    <span style="color: red;">UPLOAD HANYA FILE BENTUK PDF HASIL SCAN DOKUMEN ASLI</span>
                    <br><br>
                    <span style="color: red;">UNTUK PERSYARATAN IZIN LEBIH DARI 1 LEMBAR, DIBUAT 1 FILE PDF UNTUK SATU PERSYARATAN</span>
                  </center>
                </label>
                <label class="col-md-4">&nbsp;</label>
              </div>
              
              <div class="form-group" >
                <div class="col-md-12" style="padding-bottom:25px">
                  <?php $oo=1; foreach($syarat as $data){ ?>
                  <div class="row" style="border-style:solid;border-width:1px 0px 0px;padding:10px 5px 10px">
                    <div class="col-md-1" style="font-size:15px;text-align:justify">
                      <?php echo $oo; ?>
                    </div>
                    
                    <div class="col-md-6">
                      <?php 
                      echo $data->v_syarat;
                      $ada = 0;
                      ?>
                    </div>
                    
                    <div class="col-md-5">
                      Berkas Persyaratan
                      <?php //if (stripos($data->v_syarat, '.jpg') !== FALSE) { ?>
                        <!-- <input type="file" name="<?php echo "file_".$data->id; ?>" class="form-control FilUploader" accept=".jpg,.jpeg" onchange="ValidateSingleInput(this);" required> -->
                      <?php //} else { 
                      if(strpos($data->v_syarat, '[RAR]')){
                        ?>
                        <input type="file" name="<?php echo "file_".$data->id; ?>" class="form-control FilUploader" accept=".RAR,.rar" onchange="ValidateSingleInput(this);" required>
                        <?php
                      }else{
                        ?>
                        <input type="file" name="<?php echo "file_".$data->id; ?>" class="form-control FilUploader" accept=".pdf,.PDF" onchange="ValidateSingleInput(this);" required>
                      <?php
                      }
                      ?>
                      <?php //} ?>
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

                  <!-- PAS FOTO -->
                  <?php if ($judul->c_foto == "1") { ?>
                    <div class="row" style="border-style:solid;border-width:1px 0px 0px;padding:10px 5px 10px">
                      <div class="col-md-1" style="font-size:15px;text-align:justify">
                        <?php echo $oo; ?>
                      </div>
                      
                      <div class="col-md-6">
                        Pas Foto yang Dimohonkan (Format Jpg)
                      </div>
                      
                      <div class="col-md-5">
                        Berkas Persyaratan<input type="file" name="file_foto" class="form-control FilUploader" accept=".jpg" required>
                        <div class="row" style="padding-top:10px">
                          <div class="col-md-4">
                            <!-- Nomor Surat<input type="text" name="nomor_foto" class="form-control" > -->
                            &nbsp;
                          </div>
                          <div class="col-md-4">
                            <!-- Tanggal<input type="text" name="tanggal_foto" class="form-control datepicker" > -->
                            &nbsp;
                          </div>
                          <div class="col-md-4">
                            <!-- Masa Berlaku<input type="text" name="masa_berlaku_foto" class="form-control datepicker" > -->
                            &nbsp;
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php } ?>
                  <!-- END PASS FOTO -->
                  
                  <div class="row" style="border-style:solid;border-width:1px 0px 0px;padding:10px 5px 10px">
                    <div class="col-md-1" style="font-size:15px;">
                      <input type="checkbox" class="form-control" name="tanggung_jawab" required>
                    </div>
                    <div class="col-md-11" style="font-size:15px;text-align:justify">
                      <span style="color: Red"><b>
                        SAYA MENYATAKAN BERTANGGUNG JAWAB BAHWA DOKUMEN YANG DIUNGGAH ADALAH HASIL SCAN DOKUMEN ASLI DAN MENYETUJUI BAHWA PROSES VERIFIKASI DATA DILAKUKAN PADA HARI KERJA (SENIN - JUM'AT & DILUAR LIBUR NASIONAL)
                      </span>
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
           </form>   
          </div>
        </div>
      </div>
    </div><!-- /.col-->
  </div><!-- /.row -->
</div><!--/.main-->

<script>
  // $(".FilUploader").change(function () {
  //   var fileExtension = ['pdf'];
  //   if($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
  //     alert("Hanya file pdf yang dapat anda upload");
  // 	  // $('.lanjut').css('display','none');
  //   }else{
  // 	  // $('.lanjut').css('display','block');
  //   }
  // });

  $(document).ready(function(){
  $("#myform").on("submit", function(){
    $("#pageloader").fadeIn();
  });//submit
});//document ready
  
//var _validFileExtensions = [".pdf", ".PDF", ".jpg", ".jpeg", "JPG", "JPEG"];
var _validFileExtensions = [".pdf", ".PDF",".rar", ".RAR"];
function ValidateSingleInput(oInput) {
    if (oInput.type == "file") {
        var sFileName = oInput.value;
         if (sFileName.length > 0) {
            var blnValid = false;
            for (var j = 0; j < _validFileExtensions.length; j++) {
                var sCurExtension = _validFileExtensions[j];
                if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                    blnValid = true;
                    break;
                }
            }
             
            if (!blnValid) {
                alert("Maaf, " + sFileName + " tidak sesuai, file yang diperbolehkan hanya file berbentuk: " + _validFileExtensions.join(", "));
                oInput.value = "";
                return false;
            }
        }
    }
    return true;
}

  function doConfirm(flag){
    return flag;
    // alert(flag);
  }
  
  function beforeSubmit() {
    if(confirm("Anda yakin akan mengupload data persyaratan ?")) {
      return true;
    } 
    return false;
  }
  
  $(function () {
    $('.datepicker').datepicker()
  });
</script>