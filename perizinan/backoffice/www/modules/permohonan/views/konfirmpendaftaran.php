
<h2>Pendaftaran Online</h2>
<div class="kiri" >

<div  class="alert alert-info" style="color:#fff">
Terimakasih, Permohonan Anda Akan Segera Kami Proses<br>
Silahkan Tunggu Konfirmasi Kami Melalui E-mail dan Handphone Anda
</div>

<?php 
$error = $this->session->flashdata("error");
if(!empty($error)){
?>
<div class="alert alert-danger"><?php echo $error; ?></div>
<?php } ?>
						
<form class="form-horizontal" action="<?php echo base_url() . 'main/pendaftaranbaru/dokonfirm'; ?>" method="post">

<div class="form-group">
    <label for="inputEmail3" class="col-sm-3 control-label">Masukkan Nomor Token</label>
    <div class="col-sm-6">
      <input type="text" id="" name="token" class="validate[required] text-input form-control" style="text-align:center" maxlength="17" value="" autofocus autocomplete="off" required>

    </div>
  </div>

<div class="form-group">
    <div class="col-sm-offset-3 col-sm-10">
      <input type="submit" class="button button-blue btn btn-primary" style="" value="Lanjutkan">

    </div>
  </div>

</form>

					
				
				
        </div>
        <div class="kanan">
            <?php echo "$menu" ?>
            <?php echo "$menu1" ?>
        </div>
        <div class="clear"></div>
    