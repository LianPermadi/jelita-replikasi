<head>
    <style>
      .card-list {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
}

.card {
  width: 300px;
  margin-bottom: 20px;
  border: 1px solid #ccc;
  border-radius: 5px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}
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
.card-img-top {
  height: 200px;
  object-fit: cover;
  border-top-left-radius: 5px;
  border-top-right-radius: 5px;
}

.card-body {
  padding: 15px;
}

.card-title {
  font-size: 18px;
  margin-bottom: 10px;
}

.card-text {
  color: #666666;
}

.btn-primary {
  background-color: #007bff;
  border-color: #007bff;
  color: #ffffff;
  text-decoration: none;
  padding: 8px 12px;
  border-radius: 4px;
}

.btn-primary:hover {
  background-color: #0069d9;
  border-color: #0062cc;
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
      <?php }
      $datea = date("Ymdgis", strtotime($tgla));
      $dateb = date("Ymdgis", strtotime($tglb));
      $date = '<span style="color:green;">'.date("l", strtotime($tgla)).', '.date("d F Y", strtotime($tgla)).'</span> Sampai <span style="color:green;">'.date("l", strtotime($tglb)).', '.date("d F Y", strtotime($tglb)).'</span>';
      if($tgla == $tglb){
        $date = date("l", strtotime($tgla)).', '.date("d F Y", strtotime($tgla));
      }
      setlocale(LC_TIME, 'id_ID');
      // Konversi tanggal ke format yang diinginkan
      $tgla_formatted = strftime("%A, %d %B %Y", strtotime($tgla));
      $tglb_formatted = strftime("%A, %d %B %Y", strtotime($tglb));
      // Mencetak hasil
      $coment = '<span style="color:green;">'.$tgla_formatted  . "</span> Sampai <span style='color:green;'>" . $tglb_formatted."</span>";
      ?>
    
    <div class="entry">
      <h1><?php echo $page_name.' pada '.$coment; ?></h1>
      <div>
    <div class="card-list">
            <!-- Card-->
            <?php
                // if($data_mobil->mobil == 18){
                  // var_dump($mobil);die();
                // }
            foreach ($mobil as $row) {
              $idmobil = $this->m_mobil->get_data_list_peminjaman($row->id);
                $status = 1;
                $status_kembali = 1;
                $plat = NULL;
              foreach ($idmobil as $data_mobil) {
                // $datejamawal = date("gis", strtotime($data_mobil->tanggal_pinjam));
                  $datejamawal = '000000';
                if (strlen($datejamawal) < 6) {
                  $datejamawal = '0'.$datejamawal;
                }
                $datetanggalawal = date("Ymd", strtotime($data_mobil->tanggal_pinjam));
                $datec = $datetanggalawal.$datejamawal;
                // $datejamakhir = date("gis", strtotime($data_mobil->tanggal_kembali));
                  $datejamakhir = '235959';
                if (strlen($datejamakhir) < 6) {
                  $datejamakhir = '0'.$datejamakhir;
                }
                $datetanggalakhir = date("Ymd", strtotime($data_mobil->tanggal_kembali));
                $dated = $datetanggalakhir.$datejamakhir;
                $datehasil = $datea - $datec;
                if($datea == $datec && $datea == $dated){
                    $status = 0;
                  $plat = $this->m_mobil->get_platnomor_id($data_mobil->mobil);
                }
                if($datea >= $datec && $datea <= $dated){
                  $status = 0;
                  $plat = $this->m_mobil->get_platnomor_id($data_mobil->mobil);
                }
                if($datea == $datec && $datea == $dated){
                    $status_kembali = 0;
                  $plat = $this->m_mobil->get_platnomor_id($data_mobil->mobil);
                }
                if($dateb >= $datec && $dateb <= $dated){
                  $status_kembali = 0;
                  $plat = $this->m_mobil->get_platnomor_id($data_mobil->mobil);
                }
              }
            if($status == '1' && $status_kembali == '1'){
              if($row->kondisi == '1' || $row->kondisi == '3'){
                if($row->on_off == '1'){
            ?>
          <div class="card">
            <center>
              <?php if($row->foto == NULL || $row->foto == '0' || $row->foto == ''){ ?>
                <img src="https://asset.kompas.com/crops/NEY_Pu1nQSWRYWCMAJwBfI_kIEE=/76x50:800x533/750x500/data/photo/2023/01/06/63b7fd75d8678.jpg" class="card-img-top" alt="<?php echo $row->nama_mobil; ?>" style="max-width: 90%; margin: 2%;">
              <?php }else{ ?>
            <img src="https://dpmptsp.jabarprov.go.id/jelita/backoffice/www/modules/peminjamanmobil/assets/img/<?php echo $row->foto; ?>" class="card-img-top" alt="<?php echo $row->nama_mobil; ?>" style="max-width: 90%; margin: 2%;">
          <?php } ?>
            </center>
            <div class="card-body">
                <h5 class="card-title"><?php echo $row->nama_mobil; ?></h5>
                <?php if($row->kondisi == '3'){ ?>
                <h1><span style="color:rgb(134,0,52);font-weight:bold; display:inline-block; animation: berjalan 5s linear infinite, jedagJedug 0.5s infinite alternate;"><b>!!Mobil Khusus Dalam Kota!!</b></span></h1>
                <?php } ?>
                <p class="card-text" style="margin-bottom: 25px;"><?php echo $row->plat.' <br> '.$row->tahun.' <br>'; ?></p>
                <?php if($button == 'mobil'){ ?>
                <a href="/jelita/backoffice/peminjamanmobil/pinjam_mobil/<?php echo $row->id.'/'.$tgla.'/'.$tglb; ?>" class="btn btn-primary">Pinjam</a>
                <?php }else{ ?>
                <a href="/jelita/backoffice/peminjamanmobil/pinjam_laptop/<?php echo $row->id.'/'.$tgla.'/'.$tglb; ?>" class="btn btn-primary">Pinjam</a>
                <?php } ?>
            </div>
        </div>
            <?php
            }
          }
            }
            $status = NULL;
            $status_kembali = NULL;
            }
            ?>
            </div>
        </div>
      </div>
    </div>
      <br style="clear: both;" />
    </div>
  </div>
</div>