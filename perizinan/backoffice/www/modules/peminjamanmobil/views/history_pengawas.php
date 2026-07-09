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


            <div style="margin:10px">
<a href="/jelita/backoffice/peminjamanmobil/pengawas_mobil" class="button-wrc">Beranda</a>
<a href="/jelita/backoffice/peminjamanmobil/history_pengawas" class="button-wrc">History</a>
<br>
            </div>
    <div id="barang">
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="pendataan">
        <thead>
          <tr>
            <th width="2%">No</th>
            <th width="10%">Mobil - Plat</th>
            <th width="18%">Penumpang</th>
            <th width="30%">Tanggal Berangkat - Tanggal Pulang</th>
            <th width="30%">Tujuan Keberangkatan</th>
            <th width="10%">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php 
        $i = 1;
            $wrg = '<span style="color:yellow;">';
            $dgr = '<span style="color:red;">';
            $akf = '<span style="color:green;">';
            $ttp = '</span>';
          $a = $this->m_mobil->get_user_id($id_user);
          // echo $a;
          foreach ($mobil as $row) { 
            $originalDateTime = $row->tanggal_berangkat;
            // Mengonversi string ke objek DateTime
            $dateTime = new DateTime($originalDateTime);
            // Mengubah format tanggal dan waktu
            $formattedDateTime = $dateTime->format('d F Y \J\a\m H:i');
            $asli = $row->tanggal_kembali;
            // Mengonversi string ke objek DateTime
            if($asli == NULL || $asli == ''){
                $balik_deui = '<span style="color:red;">Belum Kembali</span>';
            }else{
            $dateTime1 = new DateTime($asli);
            // Mengubah format tanggal dan waktu
            $formattedDateTime1 = $dateTime1->format('d F Y \J\a\m H:i');
                $balik_deui = $formattedDateTime1;
            }
            $string = $row->penumpang;
            $array = explode("^", $string);
            ?>
      <tr>
        <td><?php echo $i; ?></td>
        <td><?php echo $this->m_mobil->get_nama_mobil_id($row->mobil); ?> - <?php echo $this->m_mobil->get_platnomor_id($row->mobil); ?></td>
        <td><span class="highlight"><?php foreach ($array as $data) { echo $data.", "; } ?></span></td>
        <td><?php echo $formattedDateTime.' - '.$balik_deui; ?></td>
        <td><?php echo $row->tujuan; ?></td>
        <td><a href="/jelita/backoffice/peminjamanmobil/infokeberangkatan/<?= $row->id ?>"><button class="button-wrc">detail</button></a></td>
      </tr>
          <?php $i++; 
          } ?>
        </tbody>
      </table>
  </div>
</div>
  <br style="clear: both;" />
</div>