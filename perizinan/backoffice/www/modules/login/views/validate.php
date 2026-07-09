<?php
  $this->tr_instansi = new Tr_instansi();
  $logo = $this->tr_instansi->get_by_id(14);
  $img = array('src'=>'uploads/logo/' . $logo->value, 'width'=>'80', 'height'=>'90');
?>

<html>
  <head>
    <title>Form Ganti Password</title>
    --<link type='text/css' rel='stylesheet' href="<?php echo site_url('assets/css/'.$app_folder.'/login.css'); ?>" /> 
  </head>
  <body>
    <div id="stylized">
      <div class="loginform">
        <div class="logo"><?php echo img($img); ?><br><br><br>
          <p>
            <?php
            $folder = $this->tr_instansi->get_by_id(9);
            echo "<b>"."<font size='2'>".$folder->value."</font>"."</b>";
            $app_city = $this->tr_instansi->get_by_id(4);
			      $prov = $this->tr_instansi->get_by_id(18);
            //$wilayah = new trkabupaten();
            //$wilayah->get_by_id($app_city->value);
            echo br(1)."<font size='2'>".$prov->value."</font>";
            ?>
          </p>
        </div>
        <?php
        echo form_open('login');
			  echo form_hidden('stat', $stat);
			  echo form_hidden('admin', $admin);
			  $type="type='text'";
			  if($stat == 1) $type="type='password'";
        ?>
        <div class="form">
          <ul>
			      <li><h2><?php echo $salah ?></h2></li>
            <li><h2><?php echo $judul ?></h2>&nbsp;
				    <?php if($stat == 1){ ?>
  			    	<input type="password" name="next_in" id="next_in" />
					  <?php }else{ ?>
					    <input type="text" name="next_in" id="next_in" />
				    <?php } ?>
    			  </li>
          </ul>
          <ul>
            <li><button type="submit">Login Ulang</button></li>
          </ul>
        </div>
        <?php
          echo form_close();
        ?>
      </div>
      <div class="footer">
        <h3>Copyright | <?php echo date('Y') ." ". $app_name ;?></h3>
      </div>            
    </div>
  </body>
</html>