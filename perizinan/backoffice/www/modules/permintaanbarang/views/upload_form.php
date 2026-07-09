// view upload_form.php
<h3>Upload Form</h3>
<?php echo $error;?>
<?php echo form_open_multipart('permintaanbarang/do_upload');?>
  <input type="file" name="gambar" size="20" />
  <br /><br />
  <input type="submit" value="Upload" />
<?php echo form_close();?>