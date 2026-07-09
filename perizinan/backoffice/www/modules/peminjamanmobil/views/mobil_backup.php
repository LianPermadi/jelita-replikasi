<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Si Pemo</title> 
    <link rel="stylesheet" href="https://dpmptsp.jabarprov.go.id/jelita/backoffice/www/modules/peminjamanmobil/assets/fonts/fontawesome-all.min.css?h=1ccd59155201f54e983ef3bc062fd66b">
    <link rel="stylesheet" href="https://dpmptsp.jabarprov.go.id/jelita/backoffice/www/modules/peminjamanmobil/assets/css/News-Cards.css?h=19de63894dd5898d7874581c81f61f35">
    <link rel="stylesheet" href="https://dpmptsp.jabarprov.go.id/jelita/backoffice/www/modules/peminjamanmobil/assets/css/Responsive-UI-Card.css?h=3effbe6b3f9e82c1c6e21bb5b85e2006">
    <link rel="stylesheet" href="https://dpmptsp.jabarprov.go.id/jelita/backoffice/www/modules/peminjamanmobil/assets/css/styles.css?h=d41d8cd98f00b204e9800998ecf8427e">
    <style type="text/css"> 
@keyframes berjalan {
  0% { transform: translateX(100%); }
  100% { transform: translateX(-100%); }
}

@keyframes jedagJedug {
  0% { transform: translateY(0); }
  50% { transform: translateY(-5px); }
  100% { transform: translateY(0); }
}

span[style*="color:rgb(253,0,253)"] {
  white-space: nowrap; /* Prevent text wrapping */
}
      h1 {
  text-align: center;
  margin-bottom: 50px;
  margin-top: 50px;
}

.blog-card-blog {
  margin-top: 30px;
}

.blog-card {
  display: inline-block;
  position: relative;
  width: 100%;
  margin-bottom: 30px;
  border-radius: 6px;
  color: rgba(0, 0, 0, 0.87);
  background: #fff;
  box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.14), 0 3px 1px -2px rgba(0, 0, 0, 0.2), 0 1px 5px 0 rgba(0, 0, 0, 0.12);
}

.blog-card .blog-card-image {
  height: 60%;
  position: relative;
  overflow: hidden;
  margin-left: 15px;
  margin-right: 15px;
  margin-top: -30px;
  border-radius: 6px;
  box-shadow: 0 16px 38px -12px rgba(0, 0, 0, 0.56), 0 4px 25px 0px rgba(0, 0, 0, 0.12), 0 8px 10px -5px rgba(0, 0, 0, 0.2);
}

.blog-card .blog-card-image img {
  width: 100%;
  height: 100%;
  border-radius: 6px;
  pointer-events: none;
}

.blog-card .blog-table {
  padding: 15px 30px;
}

.blog-table {
  margin-bottom: 0px;
}

.blog-category {
  position: relative;
  line-height: 0;
  margin: 15px 0;
}

.blog-text-success {
  color: #6f6f6f!important;
}

.blog-card-blog .blog-card-caption {
  margin-top: 5px;
}

.blog-card-caption {
  font-weight: 700;
  font-family: "Roboto Slab", "Times New Roman", serif;
}

.blog-card-caption, .blog-card-caption a {
  color: #333;
  text-decoration: none;
}

p {
  color: #3C4857;
  margin-top: 0;
  margin-bottom: 1rem;
}

.blog-card .ftr {
  margin-top: 15px;
}

.blog-card .ftr .author {
  color: #888;
}

.blog-card .ftr div {
  display: inline-block;
}

.blog-card .author .avatar {
  width: 36px;
  height: 36px;
  overflow: hidden;
  border-radius: 50%;
  margin-right: 5px;
}

.blog-card .ftr .stats {
  position: relative;
  top: 1px;
  font-size: 14px;
}

.blog-card .ftr .stats {
  float: right;
  line-height: 30px;
}

a {
  text-decoration: none;
}

      .snip1527 {
  box-shadow: 0 0 5px rgba(0, 0, 0, 0.15);
  color: #ffffff;
  float: left;
  font-family: 'Lato', Arial, sans-serif;
  font-size: 16px;
  margin: 10px 1%;
  max-width: 310px;
  min-width: 250px;
  overflow: hidden;
  position: relative;
  text-align: left;
  width: 100%;
}

.snip1527 * {
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
  -webkit-transition: all 0.25s ease;
  transition: all 0.25s ease;
}

.snip1527 img {
  max-width: 100%;
  vertical-align: top;
  position: relative;
}

.snip1527 figcaption {
  padding: 25px 20px 25px;
  position: absolute;
  bottom: 0;
  z-index: 1;
}

.snip1527 figcaption:before {
  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  background: #057a9b; /* Warna biru muda awal warna ungu #700877 */
  content: '';
  background: -moz-linear-gradient(90deg, #057a9b 0%, #00bfff 100%, #00bfff 100%); /* Gradasi biru muda */
  background: -webkit-linear-gradient(90deg, #057a9b 0%, #00bfff 100%, #00bfff 100%);
  background: linear-gradient(90deg, #057a9b 0%, #00bfff 100%, #00bfff 100%);
  /* background: -moz-linear-gradient(90deg, #700877 0%, #ff2759 100%, #ff2759 100%);
  background: -webkit-linear-gradient(90deg, #700877 0%, #ff2759 100%, #ff2759 100%);
  background: linear-gradient(90deg, #700877 0%, #ff2759 100%, #ff2759 100%); */
  opacity: 0.8;
  z-index: -1;
}

.snip1527 .date {
  background-color: #fff;
  border-radius: 50%;
  color: #700877;
  font-size: 18px;
  font-weight: 700;
  min-height: 48px;
  min-width: 48px;
  padding: 10px 0;
  position: absolute;
  right: 15px;
  text-align: center;
  text-transform: uppercase;
  top: -25px;
}

.snip1527 .date span {
  display: block;
  line-height: 14px;
}

.snip1527 .date .month {
  font-size: 11px;
}

.snip1527 h3, .snip1527 p {
  margin: 0;
  padding: 0;
}

.snip1527 h3 {
  display: inline-block;
  font-weight: 700;
  letter-spacing: -0.4px;
  margin-bottom: 5px;
}

.snip1527 p {
  font-size: 0.8em;
  line-height: 1.6em;
  margin-bottom: 0px;
}

.snip1527 a {
  left: 0;
  right: 0;
  top: 0;
  bottom: 0;
  position: absolute;
  z-index: 1;
}

.snip1527:hover img, .snip1527.hover img {
  -webkit-transform: scale(1.1);
  transform: scale(1.1);
}

img {
  border-radius: 5px;
}

img {
  border-radius: 5px;
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
      if($langkah != 1){
      ?>
  <?php 
  if($langkah != 6){
    ?>
      <table width="100%">
        <tr>
          <td bgcolor="#FFFBE7" width="25%" style="padding: 10px; height: 1px; text-align:center;"><b>Pinjam Sekarang</b>
    </td>
    <th></th>
  </tr>
  <tr>
    <td bgcolor="#FFFBE7" width="25%">
                    <form action="peminjamanmobil/check_mobil" method="post">
                    <table>
                        <tr>
                            <td>
                                <label>Tanggal Keberangkatan</label>
                            </td>
                            <td>
                                <input type="date" name="tgla" class="input-wrc">
                            </td>
                        </tr>
                            <td>
                                <label>Tanggal Pulang</label>
                            </td>
                            <td>
                                <input type="date" name="tglb" class="input-wrc">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                    <input type="submit" name="submit" class="button-wrc" value="Cari">
                </td>
                        </tr>
                    </table>
                    </form>
                  </td>
                  <td style="text-align: right;">         


      <?php
      setlocale(LC_TIME, 'id_ID');
      $hari = strftime("%A", strtotime($date));
      echo $hari.', '.date("d F Y", strtotime($date)).'<br>';
      $tanggalsekarang = $date;
    }else{
      $ctk_list = array('name' => 'button',
                        'content' => 'Kembali',
                        'value' => 'Back',
                        'class' => 'button-wrc',
                        'onclick' => 'parent.location=\''.site_url('peminjamanmobil').'\''
                       );
      echo form_button($ctk_list);  
      ?>
      <h1 style="margin: 1px;">Pilih Mobil Untuk Mengetahui Jadwal Yang Tersedia</h1>
      <?php
    }
  }


     
      include '/var/www/html/jelita/backoffice/www/modules/peminjamanmobil/assets/js/button.php';
                ?>
      <?php
        $id_user = $this->session->userdata('id_auth');
        $idpegawai = $this->m_mobil->get_user_id($id_user);
      if($langkah == 0){
      $ctk_list = array('name' => 'button',
                        'content' => 'History Peminjaman',
                        'value' => 'History Peminjaman',
                        'class' => 'button-wrc',
                        'onclick' => 'parent.location=\''.site_url('peminjamanmobil/history_user').'\''
                       );
      echo form_button($ctk_list);  
      $ctk_list = array('name' => 'button',
                        'content' => 'Jadwal Mobil',
                        'value' => 'Jadwal Mobil',
                        'class' => 'button-wrc',
                        'onclick' => 'parent.location=\''.site_url('peminjamanmobil/jadwal').'\''
                       );
      echo form_button($ctk_list);  
    }
                ?></td>
                </tr>
              </table>
      <div>
        <!-- Start: News Cards -->
        <center>
          <div style="
            margin-left: 10%;
/*            margin-right: 10%;*/
            ">
                
        <?php 
      if($langkah != 1){

            $wrg = '<span style="color:yellow;">';
            $dgr = '<span style="color:red;">';
            $akf = '<span style="color:green;">';
            $ttp = '</span>';
        foreach ($mobil as $row) {         
        
        $id_pengampu = $this->m_mobil->get_pengampu_id($row->tot);
        $pengampu = $this->m_mobil->get_tim_pengampu($id_pengampu);
        
        // Inisialisasi array kosong untuk hasil penggabungan
        $mergedArray = [];

        foreach ($pengampu as $tim) {
            // Memisahkan string menjadi array menggunakan pemisah '^' 
            $anggotaArray = explode('^', $tim->anggota);
            
            // Menggabungkan array yang dihasilkan dengan array sebelumnya
            $mergedArray = array_merge($mergedArray, $anggotaArray);
        }
        
        // Menghapus duplikat dari array yang digabungkan
        $uniqueArray = array_unique($mergedArray);


              $tanggalsekarang = date('Y-m-d g:i:s');
                    $idmobil = $this->m_mobil->get_data_list_peminjaman($row->id);
                    foreach ($idmobil as $data_mobil) {
                      if($tanggalsekarang >= $data_mobil->tanggal_pinjam && $tanggalsekarang <= $data_mobil->tanggal_kembali){
                        $status = $dgr.'Mobil Sedang Digunakan'.$ttp;
                      }
                    }
          
                    if($row->on_off == '1'){
          ?>    
<div>
<figure class="snip1527" style="min-width: 270px; max-width: 270px;max-height: 440px;min-height: 440px;">
  <?php if($row->foto == NULL || $row->foto == '0' || $row->foto == ''){ ?>
    
  <div class="image"><img src="https://asset.kompas.com/crops/NEY_Pu1nQSWRYWCMAJwBfI_kIEE=/76x50:800x533/750x500/data/photo/2023/01/06/63b7fd75d8678.jpg" alt="pr-sample23"  style="min-width: 300px;max-width: 300px;max-height: 210px; min-height:210px; object-fit: cover; object-position: center;" /></div>
<?php }else{ ?>
  <div class="image"><img src="https://dpmptsp.jabarprov.go.id/jelita/backoffice/www/modules/peminjamanmobil/assets/img/<?php echo $row->foto; ?>" alt="pr-sample23" style="min-width: 300px;max-width: 300px;max-height: 210px; min-height:210px; object-fit: cover; object-position: center;" /></div>
<?php } ?>
    
    <figcaption style="height: 230px; width:100%;">
    <div class="date">
                <?php 
                  $kondisi = $row->kondisi; 
                  if($kondisi == '1'):
                    echo '<span class="day">'.$akf.'OK'.$ttp.$ttp;
                  elseif($kondisi == '2'):
                    echo '<span class="day">'.'<span style="color:blue;">'.'OP'.$ttp.$ttp;
                  elseif($kondisi == '3'):
                    echo '<span class="day">'.$akf.'OK'.$ttp.$ttp;
                  else:
                    echo '<span class="month">'.$dgr.'BAD'.$ttp.$ttp;
                  endif;
                ?>
    </div>
    <h3><?php echo $row->nama_mobil.' '.$row->plat; ?></h3> 
    <p style="background-color: rgba(90, 20, 80, 0.7);padding: 10px; color:white;">
      <?php 
      if($row->kategori == 'laptop'){
      echo 'Tahun Laptop <b>'.$row->tahun.'</b>'; ?>
      <?php echo 'Jenis <b>'.$row->jenis.'</b> Jenis daya yang di pakai <b>'.$row->bahan_bakar.'</b>'; ?>
      <?php echo 'Bisa Menampung <b>'.$row->kapasitas.'</b><br>'; 
      }else{
      echo 'Tahun Mobil <b>'.$row->tahun.'</b>'; ?>
      <?php echo 'Jenis transmisi <b>'.$row->jenis.'</b> Jenis Bahan Bakar yang di pakai <b>'.$row->bahan_bakar.'</b>'; ?>
      <?php echo 'Bisa Menampung <b>'.$row->kapasitas.'</b><br>'; 
      }
      ?>
      <style>
        .bordered-text {
            border: 2px solid black; /* Mengatur border dengan ketebalan 2px dan warna hitam */
            padding: 10px; /* Menambahkan padding agar teks tidak terlalu dekat dengan border */
            width: 300px; /* Mengatur lebar container */
        }
        .red-text {
            color: red; /* Warna teks merah */
            border: 2px solid white; /* Border putih dengan ketebalan 2px */
            padding: 10px; /* Padding untuk memberikan ruang di sekitar teks */
            width: 300px; /* Lebar container */
        }
      </style>
      <?php 
              $tanggalsekarang = date('Y-m-d H:i:s'); 
                    $idmobil = $this->m_mobil->get_data_list_peminjaman($row->id);
                    foreach ($idmobil as $data_mobil) {
                      if($tanggalsekarang >= $data_mobil->tanggal_pinjam && $tanggalsekarang <= $data_mobil->tanggal_kembali){
                        $status = $dgr.'Mobil Sedang Digunakan'.$ttp;
                      }
                    }
                    if(!empty($status)){
                      echo $status;
                    }elseif($row->kondisi == 0){
                      echo $wrg.'Mobil tidak tersedia (maintenance)'.$ttp;
                    }elseif($row->kondisi == 1){
                      echo $akf.'Mobil Tersedia'.$ttp;
                    }elseif($row->kondisi == 3){echo '<span style="color:rgb(128,255,128)">Mobil Tersedia'.$ttp.' <br>
<span style="color:rgb(253,0,253); font-weight:bold; display:inline-block; animation: berjalan 5s linear infinite, jedagJedug 0.5s infinite alternate;">!!Mobil Khusus Dalam Kota!!</span>'.$ttp;

                    }elseif($row->kondisi == 2){
                      echo '<span style="color : cyan;">Mobil Oprasional ToT '.$this->m_mobil->get_koor_id($row->tot).$ttp;
                    }
                    $status = NULL;
                  ?>
                  <br>
                  <br>
    </p>
  </figcaption>
  <?php 
  if($langkah != '6'){
    $id_pegawai = $this->m_mobil->get_user_id($id_user);
    $anggota_tim = FALSE;
    foreach ($uniqueArray as $value) {
      if($id_pegawai == $value){
        $anggota_tim = TRUE;
      }
    }
    if($kondisi == '1'){
      ?>
      <a href="peminjamanmobil/pinjam_mobil/<?php echo $row->id; ?>"></a>
      <?php
    }elseif($kondisi == '3'){ 
      ?>
      <a href="peminjamanmobil/pinjam_mobil/<?php echo $row->id; ?>"></a>
    <?php
    }elseif($anggota_tim){
      ?>
      <a href="peminjamanmobil/pinjam_mobil/<?php echo $row->id; ?>"></a>
    <?php }else{ ?>
      <a href="peminjamanmobil/detail_mobil/<?php echo $row->id; ?>" target="_blank"></a>
    <?php
    }
  }else{
  ?>
  <a href="peminjamanmobil/detail_mobil/<?php echo $row->id; ?>" target="_blank"></a>
  <?php
}
  ?>
</figure>
</div>
       <?php }
     }
       }else{ ?>
     </div>
       </center>
<div class="container">
  <div class="row">
    <table style="margin-right: 10%;margin-left: 10%;">
      <tr>
  <?php 
            $wrg = '<span style="color:#ecb753;">';
            $dgr = '<span style="color:red;">';
            $akf = '<span style="color:rgb(128,255,128)">';
            $ttp = '</span>';
            $no = 1;
            foreach ($mobil as $row) {
              if($no == 4){
                $no = 1;
                echo '</tr><tr>';
              }
  ?>
        <td style="padding: 10px;width: 400px;">
  <div class="col-md-4">
  <div class="blog-card blog-card-blog">
    <div class="blog-card-image">
        <a href="#"> 
  <?php if($row->foto == NULL || $row->foto == '0' || $row->foto == ''){ ?>
  <div class="image"><img src="https://asset.kompas.com/crops/NEY_Pu1nQSWRYWCMAJwBfI_kIEE=/76x50:800x533/750x500/data/photo/2023/01/06/63b7fd75d8678.jpg" alt="pr-sample23"  style="min-width: 100%;max-width: 100%;max-height: 250px;min-height:250px;object-fit: cover; object-position: center;" /></div>
<?php }else{ ?>
  <div class="image"><img src="https://dpmptsp.jabarprov.go.id/jelita/backoffice/www/modules/peminjamanmobil/assets/img/<?php echo $row->foto; ?>" alt="pr-sample23" style="min-width: 100%;max-width: 100%;max-height: 250px;min-height:250px;object-fit: cover; object-position: center;" /></div>
<?php } ?> </a>
        <div class="ripple-cont"></div>
    </div>
    <div class="blog-table">
            <a href="#">
    <h6 class="blog-category blog-text-success"><i class="far fa-arrow"></i> <?php echo $row->nama_mobil.' '.$row->plat; ?></h6>
      </a>
        <h4 class="blog-card-caption">
    <div class="date">
                <?php 
                  $kondisi = $row->kondisi; 
                  if($kondisi == '1'):
                    echo '<span class="day">'.$akf.'Mobil Tersedia'.$ttp.$ttp;
                  elseif($kondisi == '2'):
                    echo '<span class="month"><span style="color:blue;">Mobil Team of Team '.$this->m_mobil->get_koor_id($row->tot).$ttp.$ttp;
                  elseif($kondisi == '3'):echo '<span style="color:rgb(128,255,128)">Mobil Tersedia'.$ttp.' <br>
<span style="color:rgb(253,0,253); font-weight:bold; display:inline-block; animation: berjalan 5s linear infinite, jedagJedug 0.5s infinite alternate;">!!Mobil Khusus Dalam Kota!!</span>'.$ttp;
                  else:
                    echo '<span class="month">'.$dgr.'Mobil Dalam Perbaikan'.$ttp.$ttp;
                  endif;
                ?>
    </div>
        </h4>
        <p class="blog-card-description">
      <?php 
      if($row->kategori == 'laptop'){
      echo 'Tahun Laptop <b>'.$row->tahun.'</b>'; ?>
      <?php echo 'Jenis <b>'.$row->jenis.'</b> Jenis daya yang di pakai <b>'.$row->bahan_bakar.'</b>'; ?>
      <?php echo 'Bisa Menampung <b>'.$row->kapasitas.'</b><br>'; 
      }else{
      echo 'Tahun Mobil <b>'.$row->tahun.'</b>'; ?>
      <?php echo 'Jenis transmisi <b>'.$row->jenis.'</b> Jenis Bahan Bakar yang di pakai <b>'.$row->bahan_bakar.'</b>'; ?>
      <?php echo 'Bisa Menampung <b>'.$row->kapasitas.'</b><br>'; 
      }
      ?>
      <?php 
              $tanggalsekarang = date('Y-m-d g:i:s');
                    $idmobil = $this->m_mobil->get_data_list_peminjaman($row->id);
                    foreach ($idmobil as $data_mobil) {
                      if($tanggalsekarang >= $data_mobil->tanggal_pinjam && $tanggalsekarang <= $data_mobil->tanggal_kembali){
                        $status = $dgr.'Mobil Sedang Digunakan'.$ttp;
                      }
                    }
                    if(!empty($status)){
                      echo $status;
                    }elseif($row->kondisi == 1){
                      echo $akf.'<span style="color:rgb(128,255,128)">Kondisi keadaan baik dan layak pakai'.$ttp;
                    }elseif($kondisi == '2'){
                    echo '<span class="month"><span style="color:blue;">Mobil Team of Team '.$this->m_mobil->get_koor_id($row->tot).$ttp.$ttp;
                    }elseif($kondisi == '3'){echo '<span style="color:rgb(128,255,128)">Mobil Tersedia'.$ttp.' <br>
<span style="color:rgb(253,0,253); font-weight:bold; display:inline-block; animation: berjalan 5s linear infinite, jedagJedug 0.5s infinite alternate;">!!Mobil Khusus Dalam Kota!!</span>'.$ttp;

                    }else{
                    echo '<span class="month">'.$dgr.'Mobil Dalam keadaan tidak baik'.$ttp.$ttp;
                    }
                    $status = NULL;
                  ?>
                  <br>
                  <br></p>
        <div class="ftr">
            <div class="author">
                <?php
              if($langkah == 1){ 
                ?>
                <a href="peminjamanmobil/edit_mobil/<?php echo $row->id; ?>">
                  <img src="https://cdn-icons-png.flaticon.com/512/3597/3597075.png" width="20px" height="20px">
                </a><span> </span>
                <?php
              }else{
                if($langkah != 1){
                ?>
                <a href="peminjamanmobil/detail_mobil/<?php echo $row->id; ?>">
                  <button class="button-wrc">
                  Detail
                  </button>
                </a>
                <?php
              }else{
                if($row->peminjam == $idpegawai){
                ?>
                <a href="peminjamanmobil/kembali_mobil/<?php echo $row->id; ?>">
                  <button class="button-wrc">
                  Kembalikan
                  </button>
                </a>
                <?php
              }else{
                echo 'Masih Di pinjam';
              }
              }
              } ?>
            </div>
        </div>
    </div>
  </div>
  </div>
</td>
  <?php 
  $no++;
    }
    ?>
      </tr></table>
     <?php
  }
  ?>
  </div>
</div>
      <br style="clear: both;" />
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://dpmptsp.jabarprov.go.id/jelita/backoffice/www/modules/peminjamanmobil/assets/bootstrap/js/bootstrap.min.js"></script>