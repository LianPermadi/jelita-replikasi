<?=doctype('html5');?>
<html>
  <head>
    <title><?=$judulapp;?></title>
  <head>
  <body>
    <?php echo heading($judulapp,2); ?>
    <form action="<?php echo site_url('petugas/petugas/uploadfileSE'); ?>" method="post" enctype="multipart/form-data">
      <?php 
			echo form_hidden('nip', $nip); 
			?>
      <input type="file" name="fileToUpload" id="fileToUpload" class="submit-wrc" value="Pilih file" required>
      <input type="submit" class="submit-wrc" style="text-decoration:none; float:right; width:100px;" value="UpLoad" />
    </form>
  </body>
</html>
