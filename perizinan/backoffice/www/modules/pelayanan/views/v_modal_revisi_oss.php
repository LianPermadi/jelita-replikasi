<?=doctype('html5');?>
<?php 
  if (!empty($ossrba)) {
    $id = $ossrba->id;
    $revisi = $ossrba->revisi;
   


  } else {
    $id = "";
    $revisi = "";

    


  }
 ?>

<html>
  <head>
    <title><?=$judulapp;?></title>
  <head>
  <body>
    <?php echo heading($judulapp,2); ?>
    <form action="<?php echo site_url('pelayanan/komitmen_oss/update_revisi'); ?>" method="post" enctype="multipart/form-data">
      <?php 
			echo form_hidden('id', $id); 
			?>
      <?php
                                $revisi_input = array('name' => 'revisi',
                                                      'value' => $revisi,
                                                      'style' => 'width:100%',
                                                      'class' => 'input-area-wrc'
                                                     );
                                echo form_textarea($revisi_input);
                                ?>
       <input type="submit" name="submit" class="submit-wrc" style="text-decoration:none; float:right; width:100px;" value="Submit" />
    </form>
  </body>
</html>
