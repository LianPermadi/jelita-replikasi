<head>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f2f2f2;
      margin: 0;
      padding: 0;
    }

    .profile-container {
      max-width: 400px;
      margin: 0px auto;
      background-color: #ffffff;
      padding: 10px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    
    .profile-password {
      max-width: 400px;
      margin: 0px auto;
      background-color: #D3D3D3;
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
  </style>
</head>

<div class="profile-container">
  <div class="profile-info">
    <?php
    foreach ($pegawai as $row) {
      # code... 
      $id_peg = $row->id;
      $pin = $row->pin;
      $nfile_foto = str_replace(' ', '', 'foto_'.$row->id).'.png';
      $l_foto = FALSE;
      if(file_exists('backoffice/uploads/logo/'.$nfile_foto)){
        $l_foto = TRUE;
      }
      $nfile_ttd = str_replace(' ', '', $row->nip).'.png';
      $l_ttd = FALSE;
      if(file_exists('backoffice/uploads/logo/'.$nfile_ttd)){
        $l_ttd = TRUE;
      }
      ?>
      <div class="profile-picture">
      	<?php
        if($l_foto){
        	$ket_foto = '';
          ?><img src="<?php echo base_url().'/backoffice/uploads/logo/foto_'.$row->id.'.png'; ?>" alt="Profile Picture"><?php
        }else{
        	$ket_foto = ' foto ';
        	?><img src="<?php echo base_url().'/backoffice/uploads/logo/no_photo.png'; ?>" alt="Profile Picture"><?php
        }
        ?>
      </div>
      <h3><?php echo $row->n_pegawai; ?></h3>
      <br>
      <?php $gender = $row->gender; if($gender == '0'){ echo '<b>Pria</b>';}else{ echo '<b>Wanita</b>'; } ?>
      <?php
        $koor = $this->m_kemitraan->koor_tot($row->id);
        if($koor != '0'){
          echo '<br><b>Koor '.$this->m_kemitraan->koor_tot($row->id).'</b>';
        }
      ?>
      <br>
      <?php echo '<b>'.$row->n_jabatan.'</b>'; ?>
      <br>
      <h3>
        <?php
        if($simulasi == '1'){ //pakai jika untuk simulasi
          //$peringkat = $row->no_akses;
          if(in_array($peringkat, $juara)){
          	if($peringkat != 0){
              echo $text_hadiah;
            }else{
              //echo '<b style="color:blue;">Simulasi'.'</b>';
            }  
          }else{ 
          	if($peringkat != 0){
          	  echo $text_partisipan;
            }else{
            	//echo '<b style="color:red;">Simulasi'.'</b>';
            }
          }
        }  
        ?>
      </h3>  
      <div class="ttd-picture">
      	<?php
        if($l_ttd){
        	$ket_ttd = '';
          ?>
          <img src="<?php echo base_url().'/backoffice/uploads/logo/'.$row->nip.'.png'; ?>" style="width: 100px; height: auto; alt="ttd Picture;"> 
          <?php
        }else{
        	$ket_ttd = ' ttd ';
        	if($simulasi == ''){ //real
        	  $v_sign = '--no sign file--'.'<br>'.'Sistem tidak dapat digunakan untuk absensi';
        	}else{
        	  $v_sign = '--no sign file--';	
        	}  
        	echo '<span class="custom-text"><b>' . $v_sign . '</b></span>';
        }
        if($row->id==64){
          echo '<h4>'.'Jumlah Presensi - '.$this->m_kemitraan->jum_absen().'</h4>';
          foreach ($juara as $jr) { 
            //echo '<br>';
            echo '<h4>'.$jr.' - '.$this->m_kemitraan->pegawai_juara($jr).'</h4>';
          }
        }
        ?>
      </div>
      <br>
      <?php
        echo '<b>'.$this->m_kemitraan->unitkerja($row->unitkerja_id).'</b>'; 
      ?>
      <?php
    }
    ?>
  </div>
</div>

<?php echo form_open('main/absen'); ?>
<br>

  <?php
  if(!$l_foto && !$l_ttd){
    $foto_ttd = $ket_foto.' & '.$ket_ttd;
  }else{
    $foto_ttd = $ket_foto.$ket_ttd;
  }
  
  //Proses Absensi
  //if($l_ttd){	// jika ada file ttd
  //if($l_ttd && $id_peg == 64){ 
    ?>  	
    <div class="profile-password">
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
         echo form_hidden('simulasi',$simulasi);
        echo form_hidden('pin',$pin);
      }else{
        echo 'Tidak Ada Agenda Kegiatan Saat Ini';
        echo '</b><br>';
      }
      if($sum_acara != 0){
      	echo '<br>';
      	if($pin == $simulasi){
      	  $kt_absen = 'Akun Anda Belum Dilengkapi PIN'.'<br>'.'Sistem tidak dapat digunakan untuk absensi';
      	  echo '<span class="custom-text"><b>' . $kt_absen . '</b></span>';
        }else{
          echo '<span class="custom-text"><b>' . htmlspecialchars($pra) . '</b></span>';
          echo '<br>';
          echo '<label for="password">Masukkan PIN:</label><br>';
          echo '<input type="password" id="password" name="password" required><br>';
          $ok_hadir = array('name' => 'button',
                            'class' => 'button-wrc custom-button',
                            'content' => 'Hadir',
                            'value' => 'Hadir'
                           );
          echo '<b>'.form_submit($ok_hadir).'</b>';
        }
      }
      echo '</center>';
      echo '</span>';
      ?>
    </div>
    <br>    
    <?php    
  //}
  //EOF() Proses Absensi
?> 
<div class="profile-note">
<?php  
//Informasi Edit Data
//if(!$l_foto || !$l_ttd){
//  echo '<span style="font-style: italic;">'.'ctt : untuk melengkapi '.$foto_ttd.' silahkan <br> login <u><b>'.
//       anchor('https://dpmptsp.jabarprov.go.id/jelita/backoffice/petugas', 'Jelita 6.0').
//       '</b></u> dan edit menu Pegawai atau <br> hubungi Tim Digitalisasi'.'</span>';
//}else{
  echo '<span style="font-style: italic;">'.'ctt : untuk update data silahkan login dan <br> klik <u><b>'.
       anchor('https://dpmptsp.jabarprov.go.id/jelita/backoffice/petugas', 'Jelita 6.0').
       '</b></u> pilih edit menu Pegawai atau <br> hubungi Tim Digitalisasi'.'</span>';
//}
//EOF() Informasi Edit Data
?>
</div>
<?php  
echo form_close(); ?>