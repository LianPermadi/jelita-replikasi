<style>
  /* body {
    font-family: Arial, sans-serif;
    background-color: #f2f2f2;
    margin: 0;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
  } */
  
  .id-card {
    width: 300px;
    background-color: #ffffff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    text-align: center;
  }
  
  .profile-picture {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    overflow: hidden;
    margin: 0 auto 10px;
  }
  
  .profile-picture img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
  
  .id-info {
    text-align: left;
    margin-top: 20px;
  }
  
  .id-info p {
    margin: 8px 0;
  }
</style>
  
<div id="content">
  <div class="post">
    <div class="title">
      <?php echo $this->lib_date->view_title($page_name); ?>
    </div>
    <div class="entry">
      <center>
        <div class="id-card">
          <div class="profile-picture">
          	<?php
          	if($nfile_foto == ''){
              $img_edit = array('src' => 'uploads/logo/no_photo.png',
                                'height' => '20%', 'width' => '20%', 'border' => '0');
            }else{
          	  $img_edit = array('src' => 'uploads/logo/'.$nfile_foto,
                                'height' => '20%', 'width' => '20%', 'border' => '0');
            }
            echo img($img_edit);
            ?>
          </div>    
          <?php
          echo '<div style="background-color: lightgray; padding: 5px;">'; echo '<b>'.$tamu->full_name.'</b>'; echo '<br>'; echo '</div>';
          echo '<div style="background-color: whitesmoke; padding: 5px;">';echo '<b>'.$tamu->phone_number.'</b>'; echo '<br>'; echo '</div>';
          echo '<div style="background-color: lightgray; padding: 5px;">'; echo '<b>'.$tamu->email.'</b>'; echo '<br>'; echo '</div>';
          echo '<div style="background-color: whitesmoke; padding: 5px;">';echo '<b>'.$tamu->position.'</b>'; echo '<br>'; echo '</div>';
          echo '<div style="background-color: lightgray; padding: 5px;">'; echo '<b>'.$tamu->company.'</b>'; echo '<br>'; echo '</div>';
          echo '<div style="background-color: whitesmoke; padding: 5px;">';echo '<b>'.$tamu->address.'</b>'; echo '<br>'; echo '</div>';
          ?>

          <div class="id-info">
            <center><b>
            	<?php
   	          echo '<div style="background-color: whitesmoke; padding: 5px;">';echo '--- EVENTS ATTENDED ---'; echo '<br>'; echo '</div>';
            	echo $tamu->RSVP_Information;
            	?>
            	</b>
              <img src="https://dpmptsp.jabarprov.go.id/jelita/assets/qrcode_tamu_wjis/qrcode_<?php echo $tamu->id; ?>.png" width="250px">
            </center>
          </div>
        </div>
      </center>
    </div>
  </div>
  <br style="clear: both;" />
</div>
