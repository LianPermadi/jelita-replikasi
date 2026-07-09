<?=doctype('html5');?>
<html>
  <head>
    <title><?=$judulapp;?></title>
  <head>
  <body>
      <!-- <a href="penetapan" style="text-align: right;"><span>&times;</span></a> -->
    <?php echo heading($judulapp,2); ?>
    <?php if($this->appesl2 == 0) { ?>
      <h1>Upload PDF menunggu ESS 2</h1>
    <?php } else { ?>
      <form action="<?php echo site_url('permohonan/penetapan/uploadskpdf'); ?>" method="post" enctype="multipart/form-data">
        <?php 
        echo form_hidden('id', $id); 
        ?>
        <input type="file" name="fileToUpload" id="fileToUpload" class="submit-wrc" value="Pilih file" accept=".pdf" required>
        <input type="submit" name="submit" class="submit-wrc" style="text-decoration:none; float:right; width:66px;" value="UpLoad" />
      </form>
    <?php } ?>
  </body>
</html>
