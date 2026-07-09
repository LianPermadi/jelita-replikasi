<?php 
	$base_url	= "assets/userassets/pemohon/".$username."/pengajuan/".$permohonan->id."/";
?>
<style>
  .text{
    *padding-top:7px!important;
    text-align:right;
  }
  .text2{
    padding-top:7px!important;
    text-align:right;
  }
</style>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
  <div class="row">
    <ol class="breadcrumb">
      <li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
      <li >Permohonan</li>
      <li class="active">Detail Penolakan</li>
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
            <div class="col-md-10">Detail Permohonan</div>
            <div class="col-md-2">
              <?php
              if($his == 'his')
                echo anchor('main/user/history', 'Kembali',array("class"=>"btn btn-block btn-primary"));
              else
                echo anchor('main/user/permohonan', 'Kembali',array("class"=>"btn btn-block btn-primary"));
              ?>
            </div>
          </div>
        </div>
        <div class="panel-body">
          <form role="form">
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
                ?>
                <?php 
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
            <div class="form-group">
              <div class="col-md-12">
                <label class="col-md-3 text">Nomor Pendaftaran :</label>
                <label class="col-md-9" class="text2">
                  <?php 
                  if($permohonan->no_permohonan == '')
                    echo '-';
                  else
                    echo $permohonan->no_permohonan; 
                  ?>
                </label>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-12">
                <label class="col-md-3 text">Perizinan yang Dipilih :</label>
                <label class="col-md-9" class="text2"><?php echo $nama; ?></label>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-12">
                <label class="col-md-3 text">Tanggal Pengajuan :</label>
                <label class="col-md-9" class="text2"><?php echo date("d - M - Y H:i:s",strtotime($permohonan->d_entry)) ?></label>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-12">
                <label class="col-md-3 text">Objek/Lokasi Izin :</label>
                <label class="col-md-9" class="text2"><?php echo $permohonan->lokasi_izin ?></label>
              </div>
            </div>
          </form>
        </div>
      </div>

      <div class="panel panel-default">
        <div class="panel-heading">
          <div class="row">
            <div class="col-md-10">Detail Penolakan</div>
            <div class="col-md-2">
            	&nbsp;
            </div>
          </div>
        </div>
        <div class="panel-body">
          <form role="form">
            <div class="form-group">
              <div class="col-md-12">
                <?php 
                $success 	= $this->session->flashdata("success");
                if(!empty($success)){
                  ?>
                  <div class="alert bg-success" role="alert" style="background:#7EB332;">
                    <span class="glyphicon glyphicon-check"></span> <?php echo $success; ?>
                  </div>
                  <?php
                }
                ?>
                <?php 
                $error 	= $this->session->flashdata("error");
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
            <div class="form-group">
              <div class="col-md-12">
                <p style="text-align: justify;">Menindaklanjuti Surat Permohonan Izin <?php echo $nama; ?> Nomor Pendaftaran <?php 
                  if($permohonan->no_permohonan == '')
                    echo '-';
                  else
                    echo $permohonan->no_permohonan; 
                  ?> Tanggal <?php echo date("d - M - Y H:i:s",strtotime($permohonan->d_entry)) ?> Bersama Ini Kami Sampaikan Hal - Hal Sebagai Berikut : </p>
              </div>
            </div>

            <div class="form-group">
              <div class="col-md-12">
                <?php foreach ($alasan as $data) { ?>
                  <p style="text-align: justify;"><?php echo $data->alasan; ?></p>
                <?php } ?>
              </div>
            </div>
          </form>
          
        </div>	
      </div>

    </div><!-- /.col-->
  </div><!-- /.row -->
</div><!--/.main-->
