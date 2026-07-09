<head>
  <style>
    
    body {
      font-family: Arial, sans-serif;
      background-color: #f2f2f2;
      margin: 0;
      padding: 0;
    }

    .profile-container {
      max-width: 800px;
      margin: 0px auto;
      background-color: #ffffff;
      padding: 10px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    
    .profile-wjis {
      max-width: 400px;
      margin: 0px auto;
      background-color: lightblue;
      padding: 10px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .profile-picture {
      width: 150px;
      height: 150px;
      border-radius: 50%;
      overflow: hidden;
      margin: 0 auto;
    }

    .profile-picture img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .profile-info {
      text-align: center;
      margin-top: 10px;
    }
    
    .profile-note {
    	font-family: Arial, sans-serif;
    	font-style: italic;
      text-align: right;
      margin-top: 5px;
    }
    
    .profile-info h2 {
      margin-bottom: 0;
    }

    .profile-info h3 {
      margin-bottom: 0;
    }

    .profile-info p {
      color: #555555;
    }
    
    .custom-dropdown {
      max-width: 100%; /* Ganti dengan lebar yang diinginkan */
      width: 100%; /* Opsional, membuat dropdown mengisi lebar container-nya */
    }
    
    .custom-button {
      background-color: #4CAF50; /* Warna latar belakang */
      color: white; /* Warna teks */
      border: none; /* Menghilangkan border */
      padding: 1px 20px; /* Padding tombol */
      text-align: center; /* Perataan teks */
      text-decoration: none; /* Menghilangkan garis bawah teks */
      display: inline-block; /* Menampilkan tombol secara inline */
      font-size: 16px; /* Ukuran font */
      margin: 4px 2px; /* Margin */
      cursor: pointer; /* Menampilkan kursor pointer saat hover */
      border-radius: 8px; /* Membuat sudut tombol melengkung */
      font-style: normal; /* Membuat teks tidak miring */
      height: 30px; /* Tinggi tombol */
    }

    .custom-button:hover {
      background-color: #45a049; /* Warna latar belakang saat hover */
    }
    
    .custom-text {
      color: red;
      font-style: italic;
      font-weight: normal;
    }
    .swal2-popup{
        width:850px !important;
    }
    .card {
      box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
      transition: 0.3s;
      width: 40%;
    }

    .card:hover {
      box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
    }

    .container-card {
      padding: 2px 16px;
    }
  </style>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<div class="profile-container table-responsive">
  <div class="profile-info">
    <?php
    if(empty($pegawai)){
    	echo '<div class="profile-wjis">';
    	echo '<span style="color: Blue; font-weight: bold; font-size: 35px;">WJIS 2024</span><br>'; 
      echo '<span style="color: Blue; font-weight: bold; font-size: 17px;">West Java Investment Summit 2024</span><br>';
    	echo '<br>';
    	echo '<span style="color: red; font-weight: bold; font-size: 30px;">Guest ID Not Found</span><br>'; 
    	echo '<a href="https://wjis.jabarprov.go.id" target="_blank"><b>Click Here to Register</b></a><br><br>';
    	echo '</div>';
    }else{
      foreach ($pegawai as $row) {
        # code... 
        $id_peg = $row->id;
        //$pin = $row->pin;
        $nfile_foto = str_replace(' ', '', 'foto_'.$row->id).'.png';
        $l_foto = FALSE;
        if(file_exists('backoffice/uploads/logo/'.$nfile_foto)){
          $l_foto = TRUE;
        }
        $b = '<span style="color: Green"><b>'; $be = '</b></span>';
        if($username == 'wjis' || $username == 'wjis1' || $username == 'wjis2' || $username == 'wjis3' || $username == 'wjis4'){
          echo '<div style="background-color: green;">
                  <h3 style="color: yellow; font-weight: bold;">TEAM WJIS SESSION</h3>
                </div>';
        }else{
        	echo '<div style="background-color: gray;">
                  <h3 style="color: white; font-weight: bold;">GUEST SESSION</h3>
                </div>';
        }	
        ?>
        <div class="profile-picture">
          <img src="<?php echo base_url().'/backoffice/uploads/logo/no_photo.png'; ?>" alt="Profile Picture">
        </div>
        <h3>Data Tamu</h3>
        <br>
        <table class="table">
          <tbody>
            <tr>
              <td>Nama</td>
              <td>:</td>
              <td><?php echo '<b>'.$row->full_name.'</b>'; ?></td>
            </tr>
            <tr>
              <td>email</td>
              <td>:</td>
              <td><?php echo '<b>'.$row->email.'</b>'; ?></td>
            </tr>
            <tr>
              <td>alamat</td>
              <td>:</td>
              <td><?php echo '<b>'.$row->address.'</b>'; ?></td>
            </tr>
            
            <tr>
              <td>Nomor WA (Whatsapp)</td>
              <td>:</td>
              <td><?php echo '<b>'.$row->phone_number.'</b>'; ?></td> 
            </tr>
            <tr>
              <td>Status Kehadiran</td>
              <td>:</td>
              <td>
                <?php 
                switch ($row->status) {
                  case 0:
                    echo '<span style="color: Red">';
                    echo '<b>Belum Terkonfirmasi</b>';
                    echo '</span>';
                    break;
                  case 1:
                    echo '<span style="color: Red">';
                    echo '<b>Proses Konfirmasi</b>';
                    echo '</span>';
                    break;
                  case 2:
                    echo '<span style="color: Blue">';
                    echo '<b>HADIR</b>';
                    echo '</span>';
                    break;
                  case 3:
                    echo '<span style="color: Red">';
                    echo '<b>TIDAK HADIR</b>';
                    echo '</span>';
                    break;
                  default:
                    echo '<span style="color: Red">';
                    echo '<b>Belum Terkonfirmasi</b>';
                    echo '</span>';
                    break;
                }
                ?>
              </td>
            </tr>
          </tbody>
        </table>
        <div class="profile-info" style="display: flex; justify-content: center;">
            <div class="card" style="width: 300px; background-color: lightblue;"> 
                <div class="container-card">
                    <h6><b>Nomor Kursi</b></h6> 
                    <p style="font-size: 30px; font-weight: bold; color: #FFA500;">
                        <?php 
                        if ($row->no_kursi) {
                            echo $row->no_kursi; 
                        } else {
                            echo "-"; 
                        }
                        ?>
                    </p> 
                </div>
            </div>
        </div>


        

        <br>
        <?php
           echo '<div style="background-color: lightblue;">
                <h3 style="color: black; font-weight: bold;">EVENTS ATTENDED</h3>
              </div>';
              if (strpos($row->souvenir, '1') !== false) { // Check if Ceremony is in RSVP_Information
                echo '<div style="background-color: lightgray;">
                        <h3 style="color: black; font-weight: bold;">SOUVENIR</h3>
                      </div>';
            
                if ($username == 'wjis') {
                    echo '<div class="cont">';
                    
                    // Check if souvenir_recipient is the default value
                    if ($row->souvenir_recipient === '0000-00-00 00:00:00') {
                        // Show the button if souvenir_recipient is the default value
                        ?><button class="btn btn-primary" onclick="showPopupSouvenirRecipient(<?= $row->id; ?>)">Terima</button><?php
                    } else {
                        // Display the datetime and check image if souvenir_recipient is set
                        $datetime = new DateTime($row->souvenir_recipient);

                        echo $datetime->format('d-m-Y H:i:s');
                        ?><img src="<?php echo base_url().'/backoffice/assets/images/icon/check.png'; ?>" alt="Profile Picture" style="width:25px; height:auto;"><?php
                    }
            
                    echo '</div>';
                } else {
                    if ($row->souvenir_recipient !== '0000-00-00 00:00:00') {
                        // Display the datetime and check image if souvenir_recipient is set
                        $datetime = new DateTime($row->souvenir_recipient);
                        echo $datetime->format('d-m-Y H:i:s');
                        ?><img src="<?php echo base_url().'/backoffice/assets/images/icon/check.png'; ?>" alt="Profile Picture" style="width:25px; height:auto;"><?php
                    }
                }
              }
              if (strpos($row->souvenir_bank_indonesia, '1') !== false) { // Check if Ceremony is in RSVP_Information
                echo '<div style="background-color: lightgray;">
                        <h3 style="color: black; font-weight: bold;">SOUVENIR BANK INDONESIA</h3>
                      </div>';
            
                if ($username == 'wjis') {
                    echo '<div class="cont">';
                    
                    // Check if souvenir_recipient is the default value
                    if ($row->souvenir_recipient_bank_indonesia === '0000-00-00 00:00:00') {
                        // Show the button if souvenir_recipient is the default value
                        ?><button class="btn btn-primary" onclick="showPopupSouvenirRecipientBankIndonesia(<?= $row->id; ?>)">Terima</button><?php
                    } else {
                        // Display the datetime and check image if souvenir_recipient is set
                        $datetime = new DateTime($row->souvenir_recipient_bank_indonesia);

                        echo $datetime->format('d-m-Y H:i:s');
                        ?><img src="<?php echo base_url().'/backoffice/assets/images/icon/check.png'; ?>" alt="Profile Picture" style="width:25px; height:auto;"><?php
                    }
            
                    echo '</div>';
                } else {
                    if ($row->souvenir_recipient_bank_indonesia !== '0000-00-00 00:00:00') {
                        // Display the datetime and check image if souvenir_recipient_bank_indonesia is set
                        $datetime = new DateTime($row->souvenir_recipient_bank_indonesia);
                        echo $datetime->format('d-m-Y H:i:s');
                        ?><img src="<?php echo base_url().'/backoffice/assets/images/icon/check.png'; ?>" alt="Profile Picture" style="width:25px; height:auto;"><?php
                    }
                }
              }
               
            if(strpos($row->RSVP_Information, 'Ceremony') !== false){ // Check if Ceremony is in RSVP_Information
              echo '<div style="background-color: lightgray;">
                      <h3 style="color: black; font-weight: bold;">CEREMONY</h3>
                    </div>';
              if($username == 'wjis'){
                echo '<div class="cont">';
                if($row->absen_ceremony != null){
                  $datetime = new DateTime($row->absen_ceremony);
                  echo $datetime->format('d-m-Y H:i:s');
                  ?><img src="<?php echo base_url().'/backoffice/assets/images/icon/check.png'; ?>" alt="Profile Picture" style="width:25px; height:auto;"><?php
                }else{
                  ?><button class="btn btn-primary" onclick="showPopupCeremony(<?= $row->id; ?>)">Check-in</button><?php
                }
                echo '</div>';
              }else{
                if($row->absen_ceremony != null){ 
                  $datetime = new DateTime($row->absen_ceremony);
                  echo $datetime->format('d-m-Y H:i:s');
                  ?><img src="<?php echo base_url().'/backoffice/assets/images/icon/check.png'; ?>" alt="Profile Picture" style="width:25px; height:auto;"><?php
                }  
              }
            }
                  
            if(strpos($row->RSVP_Information, 'Talkshow') !== false){ // Check if Ceremony is in RSVP_Information
              echo '<div style="background-color: lightgray;">
                      <h3 style="color: black; font-weight: bold;">TALKSHOW</h3>
                    </div>';
              if($username == 'wjis'){
                echo '<div class="cont">';
                if($row->absen_talkshow != null){
                  $datetime = new DateTime($row->absen_talkshow);
                  echo $datetime->format('d-m-Y H:i:s');
                  ?><img src="<?php echo base_url().'/backoffice/assets/images/icon/check.png'; ?>" alt="Profile Picture" style="width:25px; height:auto;"><?php
                }else{
                  ?><button class="btn btn-primary" onclick="showPopupTalkshow(<?= $row->id; ?>)">Check-in</button><?php
                }
                echo '</div>';
              }else{
                if($row->absen_talkshow != null){ 
                  $datetime = new DateTime($row->absen_talkshow);
                  echo $datetime->format('d-m-Y H:i:s');
                  ?><img src="<?php echo base_url().'/backoffice/assets/images/icon/check.png'; ?>" alt="Profile Picture" style="width:25px; height:auto;"><?php
                }  
              }
            }
            
            if(strpos($row->RSVP_Information, 'Exhibition') !== false){ // Check if Ceremony is in RSVP_Information
              echo '<div style="background-color: lightgray;">
                      <h3 style="color: black; font-weight: bold;">EXHIBITION</h3>
                    </div>';
              if($username == 'wjis'){
                echo '<div class="cont">';
                if($row->absen_exhibition != null){
                  $datetime = new DateTime($row->absen_exhibition);
                  echo $datetime->format('d-m-Y H:i:s');
                  ?><img src="<?php echo base_url().'/backoffice/assets/images/icon/check.png'; ?>" alt="Profile Picture" style="width:25px; height:auto;"><?php
                }else{
                  ?><button class="btn btn-primary" onclick="showPopupExhibition(<?= $row->id; ?>)">Check-in</button><?php
                }
                echo '</div>';
              }else{
                if($row->absen_exhibition != null){ 
                  $datetime = new DateTime($row->absen_exhibition);
                  echo $datetime->format('d-m-Y H:i:s');
                  ?><img src="<?php echo base_url().'/backoffice/assets/images/icon/check.png'; ?>" alt="Profile Picture" style="width:25px; height:auto;"><?php
                }  
              }    
            }
            echo '<br>';
            echo '<div style="background-color: lightgray;">
                <h3 style="color: black; font-weight: bold;">PROJECT PRESENTATION</h3>
              </div>';
        ?>
        <table class="table mt-4">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Time, (durasi)<br>Project<br>Pembicara/Talent</th>
              <th scope="col" style="text-align: center;">Status</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($guest_event_details as $index => $event): ?>
              <tr>
                <th scope="row"><?= $index + 1; ?></th>
                <td style="text-align: left;">
                  <?= $event->waktu_start.' - '.$event->waktu_end.', ('.$event->durasi.')'.'<br>'.
                      $b.$event->kegiatan.$be.'<br>'.
                      $event->pembicara_talent; ?>
                </td>
                <td>
                  <?php if($username == 'wjis'): ?>
                    <div class="cont">
                      <?php if ($event->status_checkin == 2): 
                        $datetime = new DateTime($event->tanggal);
                        echo $datetime->format('d-m-Y H:i:s');
                        ?>
                        <br>
                        <img src="<?php echo base_url().'/backoffice/assets/images/icon/check.png'; ?>" alt="Profile Picture" style="width:25px; height:auto;">
                      <?php else: ?>
                        <button class="btn btn-primary" onclick="showPopup(<?= $event->guest_event_selection_id; ?>)">Check-in</button>
                      <?php endif; ?>
                    </div>
                  <?php else: ?>
                    <?php if ($event->status_checkin == 2){ 
                        $datetime = new DateTime($event->tanggal);
                        echo $datetime->format('d-m-Y H:i:s');
                        ?>
                        <br>
                        <img src="<?php echo base_url().'/backoffice/assets/images/icon/check.png'; ?>" alt="Profile Picture" style="width:25px; height:auto;">
                    <?php } ?>
                  <?php endif; ?>  
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <br>
        
        <?php 
        echo '<div style="background-color: lightgray;">
                <h3 style="color: black; font-weight: bold;">ONE ON ONE MEETING</h3>
              </div>';
        ?>
        <table class="table ">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Time, (durasi)<br>Project<br>Pembicara/Talent</th>
              <th scope="col" style="text-align: center;">Status check-in</th>
              <th scope="col" style="text-align: center;">Status check-out</th>

            </tr>
          </thead>
          <tbody>
            <?php foreach ($guest_event_one_on_one_meeting_details as $index => $event_one): ?>
              <tr>
                <th scope="row"><?= $index + 1; ?></th>
                <td style="text-align: left;">
                    <?= $event_one->oom_start.' - '.$event_one->oom_end.'<br>'.
                        $b.$event_one->kegiatan.$be.'<br>'.
                        $event_one->pembicara_talent; ?>
                </td>
                <td>
                  <?php if($username == 'wjis'): ?>
                    <div class="cont">
                      <?php if ($event_one->status_checkin == 2): 
                        $datetime = new DateTime($event_one->tanggal);
                        echo $datetime->format('d-m-Y H:i:s');
                        ?>
                        <br>
                        <img src="<?php echo base_url().'/backoffice/assets/images/icon/check.png'; ?>" alt="Profile Picture" style="width:25px; height:auto;">
                      <?php else: ?>
                        <button class="btn btn-primary" onclick="showPopupOneOnOneMeeting(<?= $event_one->guest_event_selection_id; ?>)">Check-in</button>
                      <?php endif; ?>
                    </div>
                  <?php else: ?>
                    <?php if ($event_one->status_checkin == 2): 
                        $datetime = new DateTime($event_one->tanggal);
                        echo $datetime->format('d-m-Y H:i:s');
                        ?>
                        <br>
                        <img src="<?php echo base_url().'/backoffice/assets/images/icon/check.png'; ?>" alt="Profile Picture" style="width:25px; height:auto;">
                      <?php endif; ?>
                  <?php endif; ?>  
                </td>
                <td>
                  <?php if($username == 'wjis'): ?>
                    <div class="cont">
                      <?php if ($event_one->status_checkout == 2): 
                        $datetime = new DateTime($event_one->tanggal);
                        echo $datetime->format('d-m-Y H:i:s');
                        ?>
                        <br>
                        <img src="<?php echo base_url().'/backoffice/assets/images/icon/check.png'; ?>" alt="Profile Picture" style="width:25px; height:auto;">
                      <?php else: ?>
                          <?php if ($event_one->status_checkin == 0): 
                            ?>
                            <button class="btn btn-primary">Check-out</button>

                          <?php else: ?>
                            <button class="btn btn-primary" onclick="showPopupOneOnOneMeetingCheckout(<?= $event_one->guest_event_selection_id; ?>)">Check-out</button>
                          <?php endif; ?>

                      <?php endif; ?>
                    </div>
                  <?php else: ?>
                    <?php if ($event_one->status_checkout == 2): 
                        $datetime = new DateTime($event_one->tanggal);
                        echo $datetime->format('d-m-Y H:i:s');
                        ?>
                        <br>
                        <img src="<?php echo base_url().'/backoffice/assets/images/icon/check.png'; ?>" alt="Profile Picture" style="width:25px; height:auto;">
                      <?php endif; ?>
                  <?php endif; ?>  
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <?php
      }
    }
    ?>
  </div>
</div>
<br>
<br>

<div class="profile-container table-responsive">
  <div class="profile-info">
        <?php 
        echo '<div style="background-color: lightgray;">
                <h3 style="color: black; font-weight: bold;">List acara One On One Meeting</h3>
              </div>';
        ?>
        <table class="table ">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Time, (durasi)<br>Project<br>Pembicara/Talent</th>
              <th scope="col" style="text-align: center;">Tambah Data One on One Meeting</th>

            </tr>
          </thead>
          <tbody>
          <?php foreach ($jadwal_acara as $index => $event_one): ?>
            <tr>
              <th scope="row"><?= $index + 1; ?></th>
              <td style="text-align: left;">
                <?= $event_one->waktu_start . ' - ' . $event_one->waktu_end . '<br>' .
                    $event_one->kegiatan . '<br>' .
                    $event_one->pembicara_talent; ?>
              </td>
              <td>
                <?php if ($username == 'wjis'): ?>
                  <div class="cont">
                    <!-- Button to trigger popup with embedded event data -->
                    <button class="btn btn-secondary" 
                            data-one_on_one_meeting_id="<?= $event_one->jadwal_acara_id; ?>" 
                            data-waktu-start="<?= $event_one->waktu_start; ?>"
                            data-waktu-end="<?= $event_one->waktu_end; ?>"
                            data-durasi="<?= $event_one->durasi; ?>"
                            data-kegiatan="<?= $event_one->kegiatan; ?>"
                            data-pembicara="<?= $event_one->pembicara_talent; ?>"
                            onclick="showPopupOneOnOneMeetingTambah(this)"
                            style="background-color: #b6b6b6;">
                      Tambah
                    </button> 
                  </div>
                <?php else: ?>
                <?php endif; ?>  
              </td>
            </tr>
          <?php endforeach; ?>

          </tbody>
        </table>
  </div>
</div>

<?php
if(!empty($pegawai)) {
  foreach ($pegawai as $row) { ?>
   <?php if ($row->status == 2): ?>
     <div class="profile-container" style="margin-top: 30px;">
       <div class="profile-info">
         <h3>Qr Code Tamu </h3>
         <?php if($username == ''){ ?>
         <a href="https://dpmptsp.jabarprov.go.id/jelita/main/login">
           <div class="">
             <?php
               ?><img src="<?php echo base_url().'assets/qrcode_tamu_wjis/qrcode_'.$row->id.'.png'; ?>" alt="Profile Picture"><?php
             ?>
           </div>
         </a>
         <?php } else {?>
           <div class="">
             <?php
               ?><img src="<?php echo base_url().'assets/qrcode_tamu_wjis/qrcode_'.$row->id.'.png'; ?>" alt="Profile Picture"><?php
             ?>
           </div>
         <?php }?>
       </div>
     </div>
  <?php endif;
  }
}
echo form_open('main/wjisgues'); ?>
<br>
<?php

  //Proses Absensi
  //if($l_ttd){	// jika ada file ttd
  //if($l_ttd && $id_peg == 64){ 
    ?>  	
    <!-- <div class="profile-password">
      <?php	
      echo '<span>';
      echo '<center>';
      echo '<b>';
      $pil_acara['0'] = "---- Absen ----";
      $sum_acara = 0;
      //echo '#.'.$pra.' ';
      if($agenda_dinas) {
        echo 'Agenda Kegiatan Saat Ini';
        echo '</b><br>';
        foreach($agenda_dinas as $row) {
        	$check = $this->m_kemitraan->cek_absensi($id_peg,$row->id);
        	$sum_acara++;
          $pil_acara[$row->id] = $row->acara.' '.$check;
        }
        if($id_acara == 0){
          echo form_dropdown('list_opd', $pil_acara, '0', 'class="input-select-wrc custom-dropdown" id="selector"');
        }else{  
          echo form_dropdown('list_opd', $pil_acara, $id_acara, 'class="input-select-wrc custom-dropdown" id="selector"');
        }  
        echo form_hidden('id_peg',$id_peg);
        echo form_hidden('pin',$pin);
      }else{
        echo 'Tidak Ada Agenda Kegiatan Saat Ini';
        echo '</b><br>';
      }
      if($sum_acara != 0){
      	echo '<br>';
      	//if($pin == '1'){ // matikan jika sudah berlaku absensi scan
      	if($pin == ''){	
      	  $kt_absen = 'Akun Anda Belum Dilengkapi PIN'.'<br>'.'Sistem tidak dapat digunakan untuk absensi';
      	  echo '<span class="custom-text"><b>' . $kt_absen . '</b></span>';
        }else{
          echo '<span class="custom-text"><b>' . htmlspecialchars($pra) . '</b></span>';
          echo '<br>';
          echo '<label for="password">Masukkan PIN:</label><br>';
          echo '<input type="password" id="password" name="password" required><br>';
          $ok_hadir = array('name' => 'button',
                            'class' => 'button-wrc custom-button',
                            'content' => 'Hadiri',
                            'value' => 'Hadiri'
                           );
          echo '<b>'.form_submit($ok_hadir).'</b>';
        }
      }
      echo '</center>';
      echo '</span>';
      ?>
    </div>
    <br>     -->
    <?php    
  //}
  //EOF() Proses Absensi
?> 
  <script>
    function showPopup(eventId) {
        Swal.fire({
            title: "Absen Kehadiran",
            html: `
                <form id="popupForm">
                  <div>
                    <label for="kehadiran">Absen:</label><br>
                    <select class="sektor form-control" id="kehadiran" name="kehadiran" aria-label="Default select example">
                      <option value="2">Hadir</option>
                    </select>
                  </div>
                  <button class="btn btn-primary" style="margin-top:20px;" type="submit" id="submitBtn">Kirim</button>
                </form>
            `,
            showCloseButton: true,
            showConfirmButton: false,
            icon: 'info'
        });

        document.getElementById('popupForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Mencegah form submit default
            const kehadiran = document.getElementById('kehadiran').value;

            // Bangun URL dengan benar
            const url = `https://dpmptsp.jabarprov.go.id/jelita/main/update/${eventId}`;

            console.log('Request URL:', url); // Debug URL yang dihasilkan

            // Kirim data ke server melalui AJAX
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    'id': eventId,
                    'kehadiran': kehadiran,
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire('Berhasil!', data.message, 'success').then(() => {
                        location.reload(); // Refresh halaman setelah sukses
                    });
                } else {
                    Swal.fire('Gagal!', data.message, 'error');
                }
            })
            .catch(error => console.error('Error:', error));

            // Tutup popup setelah submit
            Swal.close();
        });
    }
    function showPopupSouvenirRecipient(eventId) {
        Swal.fire({
            title: "Absen Kehadiran",
            html: `
                <form id="popupForm">
                  <div>
                    <label for="kehadiran">Absen:</label><br>
                    <select class="sektor form-control" id="kehadiran" name="kehadiran" aria-label="Default select example">
                      <option value="2">Diterima</option>
                    </select>
                  </div>
                  <button class="btn btn-primary" style="margin-top:20px;" type="submit" id="submitBtn">Kirim</button>
                </form>
            `,
            showCloseButton: true,
            showConfirmButton: false,
            icon: 'info'
        });

        document.getElementById('popupForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Mencegah form submit default
            const kehadiran = document.getElementById('kehadiran').value;

            // Bangun URL dengan benar
            const url = `https://dpmptsp.jabarprov.go.id/jelita/main/update_souvenir_recipient/${eventId}`;

            console.log('Request URL:', url); // Debug URL yang dihasilkan

            // Kirim data ke server melalui AJAX
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    'id': eventId,
                    'kehadiran': kehadiran,
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire('Berhasil!', data.message, 'success').then(() => {
                        location.reload(); // Refresh halaman setelah sukses
                    });
                } else {
                    Swal.fire('Gagal!', data.message, 'error');
                }
            })
            .catch(error => console.error('Error:', error));

            // Tutup popup setelah submit
            Swal.close();
        });
    }
    function showPopupSouvenirRecipientBankIndonesia(eventId) {
        Swal.fire({
            title: "Absen Kehadiran",
            html: `
                <form id="popupForm">
                  <div>
                    <label for="kehadiran">Absen:</label><br>
                    <select class="sektor form-control" id="kehadiran" name="kehadiran" aria-label="Default select example">
                      <option value="2">Diterima</option>
                    </select>
                  </div>
                  <button class="btn btn-primary" style="margin-top:20px;" type="submit" id="submitBtn">Kirim</button>
                </form>
            `,
            showCloseButton: true,
            showConfirmButton: false,
            icon: 'info'
        });

        document.getElementById('popupForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Mencegah form submit default
            const kehadiran = document.getElementById('kehadiran').value;

            // Bangun URL dengan benar
            const url = `https://dpmptsp.jabarprov.go.id/jelita/main/update_souvenir_bank_indonesia/${eventId}`;

            console.log('Request URL:', url); // Debug URL yang dihasilkan

            // Kirim data ke server melalui AJAX
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    'id': eventId,
                    'kehadiran': kehadiran,
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire('Berhasil!', data.message, 'success').then(() => {
                        location.reload(); // Refresh halaman setelah sukses
                    });
                } else {
                    Swal.fire('Gagal!', data.message, 'error');
                }
            })
            .catch(error => console.error('Error:', error));

            // Tutup popup setelah submit
            Swal.close();
        });
    }
    function showPopupCeremony(eventId) {
        Swal.fire({
            title: "Absen Kehadiran",
            html: `
                <form id="popupForm">
                  <div>
                    <label for="kehadiran">Absen:</label><br>
                    <select class="sektor form-control" id="kehadiran" name="kehadiran" aria-label="Default select example">
                      <option value="2">Hadir</option>
                    </select>
                  </div>
                  <button class="btn btn-primary" style="margin-top:20px;" type="submit" id="submitBtn">Kirim</button>
                </form>
            `,
            showCloseButton: true,
            showConfirmButton: false,
            icon: 'info'
        });

        document.getElementById('popupForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Mencegah form submit default
            const kehadiran = document.getElementById('kehadiran').value;

            // Bangun URL dengan benar
            const url = `https://dpmptsp.jabarprov.go.id/jelita/main/update_ceremony/${eventId}`;

            console.log('Request URL:', url); // Debug URL yang dihasilkan

            // Kirim data ke server melalui AJAX
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    'id': eventId,
                    'kehadiran': kehadiran,
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire('Berhasil!', data.message, 'success').then(() => {
                        location.reload(); // Refresh halaman setelah sukses
                    });
                } else {
                    Swal.fire('Gagal!', data.message, 'error');
                }
            })
            .catch(error => console.error('Error:', error));

            // Tutup popup setelah submit
            Swal.close();
        });
    }
    function showPopupTalkshow(eventId) {
        Swal.fire({
            title: "Absen Kehadiran",
            html: `
                <form id="popupForm">
                  <div>
                    <label for="kehadiran">Absen:</label><br>
                    <select class="sektor form-control" id="kehadiran" name="kehadiran" aria-label="Default select example">
                      <option value="2">Hadir</option>
                    </select>
                  </div>
                  <button class="btn btn-primary" style="margin-top:20px;" type="submit" id="submitBtn">Kirim</button>
                </form>
            `,
            showCloseButton: true,
            showConfirmButton: false,
            icon: 'info'
        });

        document.getElementById('popupForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Mencegah form submit default
            const kehadiran = document.getElementById('kehadiran').value;

            // Bangun URL dengan benar
            const url = `https://dpmptsp.jabarprov.go.id/jelita/main/update_Talkshow/${eventId}`;

            console.log('Request URL:', url); // Debug URL yang dihasilkan

            // Kirim data ke server melalui AJAX
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    'id': eventId,
                    'kehadiran': kehadiran,
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire('Berhasil!', data.message, 'success').then(() => {
                        location.reload(); // Refresh halaman setelah sukses
                    });
                } else {
                    Swal.fire('Gagal!', data.message, 'error');
                }
            })
            .catch(error => console.error('Error:', error));

            // Tutup popup setelah submit
            Swal.close();
        });
    }
    function showPopupExhibition(eventId) {
        Swal.fire({
            title: "Absen Kehadiran",
            html: `
                <form id="popupForm">
                  <div>
                    <label for="kehadiran">Absen:</label><br>
                    <select class="sektor form-control" id="kehadiran" name="kehadiran" aria-label="Default select example">
                      <option value="2">Hadir</option>
                    </select>
                  </div>
                  <button class="btn btn-primary" style="margin-top:20px;" type="submit" id="submitBtn">Kirim</button>
                </form>
            `,
            showCloseButton: true,
            showConfirmButton: false,
            icon: 'info'
        });

        document.getElementById('popupForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Mencegah form submit default
            const kehadiran = document.getElementById('kehadiran').value;

            // Bangun URL dengan benar
            const url = `https://dpmptsp.jabarprov.go.id/jelita/main/update_exhibition/${eventId}`;

            console.log('Request URL:', url); // Debug URL yang dihasilkan

            // Kirim data ke server melalui AJAX
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    'id': eventId,
                    'kehadiran': kehadiran,
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire('Berhasil!', data.message, 'success').then(() => {
                        location.reload(); // Refresh halaman setelah sukses
                    });
                } else {
                    Swal.fire('Gagal!', data.message, 'error');
                }
            })
            .catch(error => console.error('Error:', error));

            // Tutup popup setelah submit
            Swal.close();
        });
    }
</script>



<script>
   function showPopupOneOnOneMeetingCheckout(eventId) {
    Swal.fire({
        title: "Absen Kehadiran",
        html: `
            <form id="popupForm">
              <div>
                <label for="kehadiran">Absen:</label><br>
                <select class="sektor form-control" id="kehadiran" name="kehadiran" aria-label="Default select example">
                  <option value="2">Chekout</option>
                </select>
              </div>
              <div style="margin-top: 20px;">
                <label for="questions">Pertanyaan:</label><br>
                <textarea id="questions" name="questions" class="form-control" rows="2" placeholder="Masukkan pertanyaan di sini" required></textarea>
              </div>
              <div style="margin-top: 20px;">
                <label for="answers">Jawaban:</label><br>
                <textarea id="answers" name="answers" class="form-control" rows="3" placeholder="Masukkan jawaban di sini"></textarea>
              </div>
              <button class="btn btn-primary" style="margin-top:20px;" type="submit" id="submitBtn">Kirim</button>
            </form>
        `,
        showCloseButton: true,
        showConfirmButton: false,
        icon: 'info'
    });

    document.getElementById('popupForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Mencegah form submit default
        const kehadiran = document.getElementById('kehadiran').value;
        const questions = document.getElementById('questions').value;
        const answers = document.getElementById('answers').value;

        // Bangun URL dengan benar
        const url = `https://dpmptsp.jabarprov.go.id/jelita/main/update_one_on_one_meeting_checkout/${eventId}`;

        console.log('Request URL:', url); // Debug URL yang dihasilkan

        // Kirim data ke server melalui AJAX
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                'id': eventId,
                'kehadiran': kehadiran,
                'questions': questions, // Kirim pertanyaan ke server
                'answers': answers // Kirim jawaban ke server
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                Swal.fire('Berhasil!', data.message, 'success').then(() => {
                    location.reload(); // Refresh halaman setelah sukses
                });
            } else {
                Swal.fire('Gagal!', data.message, 'error');
            }
        })
        .catch(error => console.error('Error:', error));

        // Tutup popup setelah submit
        Swal.close();
    });
  }
    function showPopupOneOnOneMeeting(eventId) {
        Swal.fire({
            title: "Absen Kehadiran",
            html: `
                <form id="popupForm">
                  <div>
                    <label for="kehadiran">Absen:</label><br>
                    <select class="sektor form-control" id="kehadiran" name="kehadiran" aria-label="Default select example">
                      <option value="2">Hadir</option>
                    </select>
                  </div>
                  <button class="btn btn-primary" style="margin-top:20px;" type="submit" id="submitBtn">Kirim</button>
                </form>
            `,
            showCloseButton: true,
            showConfirmButton: false,
            icon: 'info'
        });

        document.getElementById('popupForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Mencegah form submit default
            const kehadiran = document.getElementById('kehadiran').value;

            // Bangun URL dengan benar
            const url = `https://dpmptsp.jabarprov.go.id/jelita/main/update_one_on_one_meeting/${eventId}`;

            console.log('Request URL:', url); // Debug URL yang dihasilkan

            // Kirim data ke server melalui AJAX
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    'id': eventId,
                    'kehadiran': kehadiran,
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire('Berhasil!', data.message, 'success').then(() => {
                        location.reload(); // Refresh halaman setelah sukses
                    });
                } else {
                    Swal.fire('Gagal!', data.message, 'error');
                }
            })
            .catch(error => console.error('Error:', error));

            // Tutup popup setelah submit
            Swal.close();
        });
    }

</script>

<!-- <script>
  function showPopupOneOnOneMeetingTambah(button) {
    // Ambil data dari button
    const currentUrl = window.location.href;

    // Dapatkan bagian ID dari URL (bagian terakhir setelah "/")
    const eventId = currentUrl.split('/').pop();
    const waktuStart = button.dataset.waktuStart;
    const waktuEnd = button.dataset.waktuEnd;
    const durasi = button.dataset.durasi;
    const kegiatan = button.dataset.kegiatan;
    const pembicara = button.dataset.pembicara;
    const one_on_one_meeting_id = button.dataset.one_on_one_meeting_id;

    Swal.fire({
        title: "Absen Kehadiran",
        html: `
            <p><strong>Kegiatan:</strong> ${kegiatan}</p>

            <p><strong>Pembicara:</strong> ${pembicara}</p>
            <form id="popupForm">
              <div>
                <label for="kehadiran">Absen:</label><br>
                <select class="sektor form-control" id="kehadiran" name="kehadiran" aria-label="Default select example">
                  <option value="2">Check-in</option>
                </select>
              </div>
              <div style="margin-top: 20px">
                <label for="kehadiran">Kegiatan :</label><br>
                  <input class="sektor form-control" type="text" id="kegiatan" name="kegiatan" value="${kegiatan}">
                
              </div>
               <div style="margin-top: 20px">
                <label for="kehadiran">Pembicara :</label><br>
                  <input class="sektor form-control" type="text" id="pembicara" name="pembicara" value="${pembicara}">
                
              </div>
              <input type="hidden" id="eventId" name="eventId" value="${eventId}">
              <input type="hidden" id="waktuStart" name="waktuStart" value="${waktuStart}">
              <input type="hidden" id="waktuEnd" name="waktuEnd" value="${waktuEnd}">
              
              <input type="hidden" id="one_on_one_meeting_id" name="one_on_one_meeting_id" value="${one_on_one_meeting_id}">
              <button class="btn btn-primary" style="margin-top:20px;" type="submit" id="submitBtn">Kirim</button>
            </form>
        `,
        showCloseButton: true,
        showConfirmButton: false,
        icon: 'info'
    });

    document.getElementById('popupForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Mencegah form submit default
        const kehadiran = document.getElementById('kehadiran').value;
        const eventId = document.getElementById('eventId').value;
        const waktuStart = document.getElementById('waktuStart').value;
        const waktuEnd = document.getElementById('waktuEnd').value;
        const durasi = document.getElementById('durasi').value;
        const kegiatan = document.getElementById('kegiatan').value;
        const pembicara = document.getElementById('pembicara').value;
        const one_on_one_meeting_id = document.getElementById('one_on_one_meeting_id').value;

        // Ganti URL ke `create` endpoint
        const url = `https://dpmptsp.jabarprov.go.id/jelita/main/create_one_on_one_meeting/${eventId}`;

        console.log('Request URL:', url); // Debug URL yang dihasilkan

        // Kirim data ke server melalui AJAX
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                'event_id': eventId,
                'kehadiran': kehadiran,
                'waktu_start': waktuStart,
                'waktu_end': waktuEnd,
                'durasi': durasi,
                'kegiatan': kegiatan,
                'pembicara': pembicara,
                'one_on_one_meeting_id': one_on_one_meeting_id
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                Swal.fire('Berhasil!', data.message, 'success').then(() => {
                    location.reload(); // Refresh halaman setelah sukses
                });
            } else {
                Swal.fire('Gagal!', data.message, 'error');
            }
        })
        .catch(error => console.error('Error:', error));

        // Tutup popup setelah submit
        Swal.close();
    });
  }
</script> -->

<script>
  function showPopupOneOnOneMeetingTambah(button) {
      const currentUrl = window.location.href;
      const eventId = currentUrl.split('/').pop();
      const waktuStart = button.dataset.waktuStart;
      const waktuEnd = button.dataset.waktuEnd;
      const durasi = button.dataset.durasi;
      const kegiatan = button.dataset.kegiatan;
      const pembicara = button.dataset.pembicara;
      const one_on_one_meeting_id = button.dataset.one_on_one_meeting_id;

      Swal.fire({
          title: "Absen Kehadiran",
          html: `
              <p><strong>Kegiatan:</strong> ${kegiatan}</p>
              <p><strong>Pembicara:</strong> ${pembicara}</p>
              <form id="popupForm">
                <div>
                  <label for="kehadiran">Absen:</label><br>
                  <select class="sektor form-control" id="kehadiran" name="kehadiran" aria-label="Default select example">
                    <option value="2">Check-in</option>
                  </select>
                </div>
                <div style="margin-top: 20px">
                  <label for="kegiatan">Kegiatan :</label><br>
                  <input class="sektor form-control" type="text" id="kegiatan" name="kegiatan" value="${kegiatan}">
                </div>
                <div style="margin-top: 20px">
                  <label for="pembicara">Pembicara :</label><br>
                  <input class="sektor form-control" type="text" id="pembicara" name="pembicara" value="${pembicara}">
                </div>
                <input type="hidden" id="eventId" name="eventId" value="${eventId}">
                <input type="hidden" id="waktuStart" name="waktuStart" value="${waktuStart}">
                <input type="hidden" id="waktuEnd" name="waktuEnd" value="${waktuEnd}">
                <input type="hidden" id="one_on_one_meeting_id" name="one_on_one_meeting_id" value="${one_on_one_meeting_id}">
                <button class="btn btn-primary" style="margin-top:20px;" type="submit" id="submitBtn">Kirim</button>
              </form>
          `,
          showCloseButton: true,
          showConfirmButton: false,
          icon: 'info',
          willOpen: () => {
              document.getElementById('popupForm').addEventListener('submit', function(event) {
                  event.preventDefault();
                  const kehadiran = document.getElementById('kehadiran').value;
                  const eventId = document.getElementById('eventId').value;
                  const waktuStart = document.getElementById('waktuStart').value;
                  const waktuEnd = document.getElementById('waktuEnd').value;
                  const kegiatan = document.getElementById('kegiatan').value;
                  const pembicara = document.getElementById('pembicara').value;
                  const one_on_one_meeting_id = document.getElementById('one_on_one_meeting_id').value;

                  const url = `https://dpmptsp.jabarprov.go.id/jelita/main/create_one_on_one_meeting/${eventId}`;

                  console.log('Request URL:', url);

                  fetch(url, {
                      method: 'POST',
                      headers: {
                          'Content-Type': 'application/x-www-form-urlencoded'
                      },
                      body: new URLSearchParams({
                          'event_id': eventId,
                          'kehadiran': kehadiran,
                          'waktu_start': waktuStart,
                          'waktu_end': waktuEnd,
                          'durasi': durasi,
                          'kegiatan': kegiatan,
                          'pembicara': pembicara,
                          'one_on_one_meeting_id': one_on_one_meeting_id
                      })
                  })
                  .then(response => response.json())
                  .then(data => {
                      if (data.status === 'success') {
                          Swal.fire('Berhasil!', data.message, 'success').then(() => {
                              location.reload();
                          });
                      } else {
                          Swal.fire('Gagal!', data.message, 'error');
                      }
                  })
                  .catch(error => console.error('Error:', error));

                  Swal.close();
              });
          }
      });
  }
</script>

<?php  
echo form_close(); ?>