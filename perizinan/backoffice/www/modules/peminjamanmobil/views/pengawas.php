<?php
    $i = 1;
    $n_file = '';
    $id = '';
    $n_file = '';
    $n_file_draft = '';
    $tgl_entry = '';
    $page = '';
    $no_surat = '';
    $tgl_surat = '';
	  $id_ess2 = '';
	  $id_sekdis = '';
	  $id_ess3 = '';
	  $id_ess4 = '';
    $id_jfah = '';
    $analis_hukum = '';
	  $id_konseptor = '';
?>
<head>
    <!-- <meta charset="utf-8"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Untitled</title>
    <!-- <link rel="stylesheet" href="https://dpmptsp.jabarprov.go.id/jelita/backoffice/www/modules/peminjamanmobil/assets/css/stylemodal.css"> -->
  <!-- <link href="https://dpmptsp.jabarprov.go.id/android/assets/css/fonts.css" rel="stylesheet">
  <link href="https://dpmptsp.jabarprov.go.id/android/assets/css/materialize_new.min.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="https://dpmptsp.jabarprov.go.id/android/assets/css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/> -->
  <style>
    /* Gaya umum */
.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7);
}

.modal-content {
    background-color: #fff;
    margin: 15% auto;
    padding: 20px;
    border-radius: 5px;
    width: 60%;
}

.close {
    float: right;
    font-size: 20px;
    font-weight: bold;
    cursor: pointer;
}
  </style>
</head>
<div id="content">
  <div class="post">
    <div class="title">
      <?php echo $this->lib_date->view_title($page_name); ?>
    </div>

    
    <?php 
        $alert = $this->session->flashdata("sukses");
        if(!empty($alert)){
      ?>
        <br>
        <div style="color: green; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;"><center><?php echo $alert; ?></center></div>
      <?php } ?>

      <?php 
        $alert = $this->session->flashdata("gagal");
        if(!empty($alert)){
      ?>
        <br>
        <div style="color: red; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;"><center><?php echo $alert; ?></center></div>
      <?php } ?>

    <div class="entry"> 

      <?php

      // include '/var/www/html/jelita/backoffice/www/modules/peminjamanmobil/assets/js/button.php';
      $ctk_list = array('name' => 'button',
                        'content' => 'Kembali',
                        'value' => 'Back',
                        'class' => 'button-wrc',
                        'onclick' => 'parent.location=\''.site_url('peminjamanmobil').'\''
                       );
      echo form_button($ctk_list); 
                ?>
      <?php
        $id_user = $this->session->userdata('id_auth');
        $idpegawai = $this->m_mobil->get_user_id($id_user);
      if($langkah == 100){
      $ctk_list = array('name' => 'button',
                        'content' => 'History User',
                        'value' => 'History User',
                        'class' => 'button-wrc',
                        'onclick' => 'parent.location=\''.site_url('peminjamanmobil/kembali_mobil').'\''
                       );
      echo form_button($ctk_list);  
    }
                ?>
    <div id="barang">
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="pendataan">
        <thead>
          <tr>
            <th width="2%">No</th>
            <th width="15%">Mobil</th>
            <th width="15%">Plat</th>
            <th width="20%">Tahun</th>
            <th width="15%">Jenis Transmisi</th>
            <th width="23%">Kondisi</th>
            <th width="10%">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php 

            $wrg = '<span style="color:yellow;">';
            $dgr = '<span style="color:red;">';
            $akf = '<span style="color:green;">';
            $ttp = '</span>';
          $a = $this->m_mobil->get_user_id($id_user);
          // echo $a;
          foreach ($mobil as $row) { 
                if($row->pengawas == 0){
            ?>
      <tr>
        <td><?php echo $i; ?></td>
        <td><?php echo $row->nama_mobil; ?></td>
        <td><?php echo $row->plat; ?></td>
        <td><?php echo $row->tahun; ?></td>
        <td><?php echo $row->jenis; ?></td>
        <td><?php 
        $kondisi = $row->kondisi; 
        if($kondisi == 1){
            echo $akf.'Mobil Dalam Keadaan ready'.$ttp;
        }else{
            echo $dgr.'Mobil Dalam Keadaan ready'.$ttp;
        }
        ?></td>
        <td><?php 
            if($row->pengawas == 0){
        ?>
        <a href="http://dpmptsp.jabarprov.go.id/jelita/backoffice/peminjamanmobil/mobilkeluar" title=' Konfirmasi Mobil sudah Keluar '> <img src="https://th.bing.com/th/id/R.56bdbeb85832f9970985c8402e65d8a7?rik=jmMrZBOlf00SRg&riu=http%3a%2f%2fpngimg.com%2fuploads%2fexit%2fexit_PNG30.png&ehk=GdbaGCbJBzhNQqyQ0Xs1nSegBL6jNmmpvFRFhRWIhyw%3d&risl=&pid=ImgRaw&r=0" width="50px" alt="gambar"> </a>
        <?php
            }else{
        ?>
        <a href="http://dpmptsp.jabarprov.go.id/jelita/backoffice/peminjamanmobil/mobil_kembali" title=' Konfirmasi Mobil sudah Kembali '> <img src="https://www.pinclipart.com/picdir/big/571-5719987_transparent-refresh-button-png-icon-kembali-clipart.png" width="50px" alt="gambar"> </a>
        <?php         
            }
        ?></td>
      </tr>
          <?php $i++; 

            }
          } ?>
        </tbody>
      </table>
  </div>
</div>
  <br style="clear: both;" />
</div>
    <!-- <script src="https://dpmptsp.jabarprov.go.id/android/assets/js/jquery-2.1.1.min.js"></script>
    <script src="https://dpmptsp.jabarprov.go.id/android/assets/js/materialize.js"></script>
    <script src="https://dpmptsp.jabarprov.go.id/android/assets/js/init.js"></script>
    <script type="text/javascript" src="https://dpmptsp.jabarprov.go.id/android/assets/js/jquery-1.5.2.min.js"></script>
    <script type="text/javascript">

    </script> -->
    <!--  Scripts-->
    <!-- <script src="https://dpmptsp.jabarprov.go.id/jelita/backoffice/www/modules/peminjamanmobil/assets/js/jquery-2.1.1.min.js"></script> -->
    <!-- <script src="https://dpmptsp.jabarprov.go.id/jelita/backoffice/www/modules/peminjamanmobil/assets/js/materialize.js"></script> -->
    <!-- <script src="https://dpmptsp.jabarprov.go.id/jelita/backoffice/www/modules/peminjamanmobil/assets/js/init.js"></script> -->
    <!-- <script type="text/javascript" src="https://dpmptsp.jabarprov.go.id/jelita/backoffice/www/modules/peminjamanmobil/assets/js/jquery-1.5.2.min.js"></script> -->
    <!-- <script type="text/javascript" src="https://dpmptsp.jabarprov.go.id/jelita/backoffice/www/modules/peminjamanmobil/assets/js/modal.js"></script> -->