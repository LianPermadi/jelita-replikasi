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
              <li>Unggah kembali persyaratan yang membutuhkan revisi dari DPMPTSP dan lengkapi data tambahan jika diperlukan</li>
              <li>Revisi persyaratan hanya dapat digunakan 1 kali upload data, pastikan anda mengunggah semua data persyaratan yang membutuhkan revisi</li>
              <li>Jika sudah, maka tekan tombol <a class="buton">Upload</a> dan pilih <b>ok</b></li>
              <li>Setelah merevisi persyaratan, pemohon dapat mengirim pesan kembali kepada DPMPTSP sebagai konfirmasi</li>
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
          
          <div class="form-group">
                <div class="col-md-12">
                  <?php 
                  $success  = $this->session->flashdata("success");
                  if(!empty($success)){
                    ?>
                    <div class="alert bg-success" role="alert" style="background:#7EB332;">
                      <span class="glyphicon glyphicon-check"></span> <?php echo $success; ?>
                    </div>
                    <?php
                  }
                  $error  = $this->session->flashdata("error");
                  if(!empty($error)){
                    ?>
                    <div class="alert bg-danger" role="alert" style="">
                      <span class="glyphicon glyphicon-check"></span> <?php echo $error; ?>
                    </div>
                    <?php
                  }
                  ?>
                </div>
              </div>

          <table data-toggle="table"  data-search="true" data-pagination="true">
            <thead>
              <tr>
                <th data-field="name"  data-sortable="true" >Pesan</th>
                <th data-field="tanggal"  data-sortable="true" >Waktu - Tanggal</th>
                <th data-field="oleh"  data-sortable="true" >Oleh</th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach($asistensi as $pesan){
                ?>
                <tr>
                  <td>
                    <?php echo $pesan->pesan; ?>
                  </td>
                  <td>
                    <?php echo date("H:i:s",strtotime($pesan->tanggal))." - ".date("d M y",strtotime($pesan->tanggal)); ?>
                  </td>
                  <td>
                    <?php 
                    $oleh = $pesan->oleh;
                    if(substr($oleh, 0, 1) == '*') $oleh = 'Verifikatur';
                    echo $oleh; 
                    ?>
                  </td>
                </tr>
                <?php
              }
              ?>
            </tbody>
          </table>
          <hr>
          <?php
          if(empty($permohonan->no_permohonan)){
            ?>
            <form action="<?php echo base_url() . 'main/permohonan/addasistensi'; ?>#" method="post">
              
              <div class="row">           
                <div class="form-group">
                  <label class="col-md-2 text">Pesan Anda :</label>
                  <div class="col-md-8"><input type="text" name="pesan" class="form-control" required="required"></div>
                  <input type="hidden" value="<?php echo $pemohon; ?>" name="pemohon">
                  <input type="hidden" value="<?php echo $permohonan->uuid; ?>" name="uuid">
                  <div class="col-md-2"><input type="submit" class="btn btn-block btn-primary" value="Kirim"></div>
                </div>
              </div>
            </form>
            <?php
          }
          ?>
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
          <!-- <form role="form" method="post" enctype="multipart/form-data" action="<?php echo base_url() . 'main/permohonan/editpermohonanbaru'; ?>" onsubmit="return beforeSubmit()"> -->
          <form role="form" method="post" enctype="multipart/form-data" action="<?php echo base_url() . 'main/permohonan/editpermohonanbaru'; ?>">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
            <input type="hidden" name="uuid" value="<?php echo $uuid; ?>">
            <div class="form-group">
              <div class="col-md-12">
                <label class="col-md-3 text">Perizinan :</label>
                <label class="col-md-9" class="text2"><?php echo $judul; ?></label>
                <label class="col-md-3 text">Objek Izin :</label>
                <label class="col-md-9" class="text3"  style="padding-bottom:40px"><?php echo $obj; ?></label>
              </div>
            </div>
            <div class="form-group" >
              <div class="col-md-12">
                <label class="col-md-4">&nbsp;</label>
                <label class="col-md-4" style="padding-bottom:30px">
                	<center>Silahkan Lengkapi Persyaratan Berikut :<br>
                    <span style="color: Red">UPLOAD HANYA FILE BENTUK PDF HASIL SCAN DOKUMEN ASLI</span>
                    <hr>
                    <span style="color: Red">SILAHKAN UPLOAD FILE PERSYARATAN "HANYA" YANG DIMINTA OLEH VERIFIKATUR/PENGOLAH SAJA <br> (DOKUMEN PERSAYARATAN YANG TIDAK BERMASALAH DAPAT DIKOSONGKAN)</span>
                  </center>
                </label>
                <label class="col-md-4">&nbsp;</label>
              </div>
            </div>
            <div class="form-group" >
              <div class="col-md-12" style="padding-bottom:25px">
                <?php
                $oo=1;
                foreach($syarat as $data){ 
                  ?>
                  <div class="row" style="border-style:solid;border-width:1px 0px 0px;padding:10px 5px 10px">
                    <div class="col-md-6" style="font-size:20px;text-align:justify">
                      <?php
                      echo '('.$oo.') <br>'.$data->v_syarat;
                      $ada = 0;
                      ?>
                    </div>
                    <div class="col-md-6">
                      Berkas Persyaratan
                      <?php //} else { 
                      if(strpos($data->v_syarat, '[RAR]')){
                        ?>
                        <input type="file" name="<?php echo "file_".$data->id; ?>" class="form-control FilUploader" accept=".RAR,.rar" onchange="ValidateSingleInput(this);">
                        <?php
                      }else{
                        ?>
                        <input type="file" name="<?php echo "file_".$data->id; ?>" class="form-control FilUploader" accept=".pdf,.PDF" onchange="ValidateSingleInput(this);">
                      <?php
                      }
                      ?>
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
                  <?php
                  $oo++;
                }
                ?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-12" style="padding-bottom:25px">
                <label class="col-md-9 text"></label>
                <div class="col-md-3">
                  <!-- <input type="submit" value="Upload" class="demo btn btn-block btn-primary lanjut"> -->
                  <input type="submit" value="Upload" class="btn btn-block btn-primary">
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
                <!-- <button type="button" data-dismiss="modal" class="btn btn-default" onClick="doConfirm(false)"> -->
                <button type="button" data-dismiss="modal" class="btn btn-default"
                  Tidak
                </button>
                <!--
                <button type="submit" data-dismiss="modal" class="btn btn-primary">
                  Ya
                </button>-->
                <!-- <button type="button" data-dismiss="modal" class="btn btn-default" onClick="doConfirm(true)"> -->
                <button type="button" data-dismiss="modal" class="btn btn-default">
                  Ya
                </button>
                <?php //echo anchor('main/user/permohonan', 'Ya',array("class"=>"btn btn-primary")) ?>
              </div>
            </div>
        	</form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
// File upload validation
$(".FilUploader").change(function () {
  var fileExtension = ["pdf", "PDF", "rar", "RAR"];
  var fileName = $(this).val();
  var fileExtensionType = fileName.split('.').pop().toLowerCase(); // Extract the file extension
  
  // Check if the file extension is not in the allowed list
  if($.inArray(fileExtensionType, fileExtension) == -1) {
    alert("Hanya file RAR/PDF yang dapat anda upload");
    $(this).val(''); // Clear the file input
  }
  // Optionally, you can show the 'lanjut' button if the file is valid
  // else {
  //   $('.lanjut').css('display','block');
  // }
});

// Confirm action before form submission
function doConfirm(flag) {
  if (flag) {
    document.forms[0].submit(); // Submit the form if user confirms
  }
}

// Before form submission, show a confirmation dialog
function beforeSubmit() {
  if (confirm("Anda yakin akan mengupload data persyaratan ?")) {
    // If confirmed, show the static modal (confirmation) for final step
    $('#static').modal('show'); // Show modal
    return false; // Prevent immediate form submission to wait for confirmation
  }
  return false; // If not confirmed, prevent submission
}

// Initialize datepicker for input fields with the class 'datepicker'
$(function () {
  $('.datepicker').datepicker({
    format: 'yyyy-mm-dd', // Set format for the date
    autoclose: true, // Close the datepicker when a date is selected
    todayHighlight: true // Highlight today's date
  });
});

</script>