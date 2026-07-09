
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #3498db;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        .departure-info {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .departure-info h2 {
            color: #3498db;
            margin-bottom: 10px;
        }

        .departure-info p {
            color: #555;
            line-height: 1.6;
        }

        .highlight {
            color: green;
            font-weight: bold;
        }

        .image-container {
            text-align: center;
            margin-top: 20px;
        }

        .image-container img {
            max-width: 100%;
            border-radius: 8px;
        }
        .fuel-bar {
    width: 300px;
    height: 30px;
    border: 1px solid #333;
    position: relative;
}


    </style>
</head>
      <div id="content">
        <div class="post">
            <div class="title">
                <h2><span style="font-family: Cursive; color: navy;"><b><span id="page_name"></span></b></span></h2>
            </div>

<?php
foreach ($mobil as $row) {
$string = $row->penumpang;
$array = explode("^", $string); ?>
    <header>
        <h1>Informasi Mobil <?php echo $this->m_mobil->get_nama_mobil_id($row->mobil); ?> - <?php echo $this->m_mobil->get_platnomor_id($row->mobil); ?></h1>
    </header>

    <div class="departure-info">
        <h2>Persiapkan Diri Anda untuk Petualangan yang Menarik!</h2>
        <p>Selamat datang di info keberangkatan. Kami menawarkan pengalaman perjalanan yang luar biasa. Berikut adalah beberapa highlights:</p>

        <ul>
            <li>Destinasi: <span class="highlight"><?php echo $row->tujuan; ?></span></li>
            <?php
            $originalDateTime = $row->tanggal_berangkat;

            // Mengonversi string ke objek DateTime
            $dateTime = new DateTime($originalDateTime);

            // Mengubah format tanggal dan waktu
            $formattedDateTime = $dateTime->format('d F Y \J\a\m H:i');
            ?>
            <li>Tanggal Keberangkatan: <span class="highlight"><?php echo $formattedDateTime; ?></span></li>
            <?php
            $asli = $row->tanggal_kembali;

            // Mengonversi string ke objek DateTime
            if($asli == NULL || $asli == ''){
                $balik_deui = '<span style="color:red;">Belum Kembali</span>';
            }else{
            $dateTime = new DateTime($asli);
            // Mengubah format tanggal dan waktu
            $formattedDateTime = $dateTime->format('d F Y \J\a\m H:i');
                $balik_deui = $formattedDateTime;
            }
            ?>
            <li>Tanggal Kembali: <span class="highlight"><?php echo $balik_deui; ?></span></li>
            <li>Penumpang: <span class="highlight"><?php 
                foreach ($array as $data) {
                    echo $data.", ";
                } 
            ?></span></li>
            <li>Kondisi Sebelum Pergi: <span class="highlight"><?php if($row->kondisi != NULL || $row->kondisi != ''){if($row->kondisi == '1'){ echo 'baik'; }else{ echo 'tidak baik '.$row->catatan_kondisi; } }else{echo '<span style="color:red;">Belum ada keterangan</span>';} ?></span></li>
            <li>Kondisi Sesudah Pulang: <span class="highlight"><?php if($row->kondisi_kembali != NULL || $row->kondisi_kembali != ''){if($row->kondisi_kembali == '1'){ echo 'baik'; }else{ echo 'tidak baik '.$row->catatan_kondisi_kembali; } }else{echo '<span style="color:red;">Belum ada keterangan</span>';} ?></span></li>
            <li>Keterangan Berangkat: <span class="highlight"><?php if($row->kelengkapan != NULL || $row->kelengkapan != ''){if($row->kelengkapan == '1'){ echo 'lengkap'; }else{ echo 'Tidak lengkap '.$row->catatan_kelengkapan; } }else{echo '<span style="color:red;">tidak ada keterangan</span>';} ?></span></li>
            <li>Keterangan Pulang: <span class="highlight"><?php if($row->kelengkapan_kembali != NULL || $row->kelengkapan_kembali != ''){if($row->kelengkapan_kembali == '1'){ echo 'lengkap'; }else{ echo 'Tidak lengkap '.$row->catatan_kelengkapan_kembali; } }else{echo '<span style="color:red;">Belum ada keterangan</span>';} ?></span></li>
            <li>Bensin Awal: 
                <?php if($row->bensin == '0'){
                        $bensin = '1%';

                    }elseif($row->bensin == '1'){
                        $bensin = '10%';
                    }elseif($row->bensin == '2'){
                        $bensin = '25%';

                    }elseif($row->bensin == '3'){
                        $bensin = '50%';

                    }elseif($row->bensin == '4'){
                        $bensin = '75%';

                    }elseif($row->bensin == '5'){
                        $bensin = '100%';

                    } ?>
                <style>
                    .fuel-level {
                        height: 100%;
                        background-color: #4CAF50; /* Warna hijau untuk level bensin */
                        width: <?php echo $bensin; ?>; /* Ganti persentase sesuai dengan level bensin yang diinginkan */
                    }
                </style>
                <div class="fuel-bar">
                    <div class="fuel-level" id="fuel-level"></div>
                </div>
                <span class="highlight">
                <?php if($row->foto_bensin_awal != NULL || $row->foto_bensin_awal != ''){ ?>
                <div class="image-container">
                    <img src="https://dpmptsp.jabarprov.go.id/jelita/backoffice/www/modules/peminjamanmobil/assets/img/gambar_bensin/<?php echo $row->foto_bensin_awal; ?>" alt="Nature Image" width="200px">
                </div>
                <?php }else{echo '<span style="color:red;">tidak ada foto</span>';} ?>
                </span>
            </li>
            <li>Bensin Kembali: 
                <?php if($row->bensin_kembali == '0'){
                        $bensin_kembali = '1%';

                    }elseif($row->bensin_kembali == '1'){
                        $bensin_kembali = '10%';
                    }elseif($row->bensin_kembali == '2'){
                        $bensin_kembali = '25%';

                    }elseif($row->bensin_kembali == '3'){
                        $bensin_kembali = '50%';

                    }elseif($row->bensin_kembali == '4'){
                        $bensin_kembali = '75%';

                    }elseif($row->bensin_kembali == '5'){
                        $bensin_kembali = '100%';

                    } ?>
                <style>
                    .fuel-level1 {
                        height: 100%;
                        background-color: #4CAF50; /* Warna hijau untuk level bensin */
                        width: <?php echo $bensin_kembali; ?>; /* Ganti persentase sesuai dengan level bensin yang diinginkan */
                    }
                </style>
                <div class="fuel-bar">
                    <div class="fuel-level1" id="fuel-level1"></div>
                </div>
                <span class="highlight">
                <?php if($row->foto_bensin_kembali != NULL || $row->foto_bensin_kembali != ''){ ?>
                    <div class="image-container">
                        <img src="https://dpmptsp.jabarprov.go.id/jelita/backoffice/www/modules/peminjamanmobil/assets/img/gambar_bensin/<?php echo $row->foto_bensin_kembali; ?>" alt="Nature Image" width="200px">
                    </div>
                <?php }else{echo '<span style="color:red;">Belum ada foto</span>';} ?>
                </span>
                
            </li>
            
            <li>Catatan berangkat: <span class="highlight"><?php if($row->catatan_berangkat != NULL || $row->catatan_berangkat != ''){echo $row->catatan_berangkat; }else{echo '<span style="color:red;">Belum ada keterangan</span>';} ?></span></li>
            <li>Catatan kembali: <span class="highlight"><?php if($row->catatan_kembali != NULL || $row->catatan_kembali != ''){echo $row->catatan_kembali; }else{echo '<span style="color:red;">Belum ada keterangan</span>';} ?></span></li>

        </ul>

        <p>
            Jangan lewatkan kesempatan ini untuk mengeksplorasi keindahan alam dan budaya lokal. Kami menjamin pengalaman yang tidak terlupakan.
        </p>

        <div class="image-container">
            <img src="https://dpmptsp.jabarprov.go.id/web/themes/default/images/logo_bpmpt.png" alt="Nature Image" width="100px">
        </div>
                <?php
    // Fungsi untuk membuat tombol "Back" dengan menggunakan header redirect
    function backButton() {
        echo '<button onclick="goBack()" class="button-wrc">Kembali</button>';
        echo '<script>';
        echo 'function goBack() {';
        echo 'window.history.back();';
        echo '}';
        echo '</script>';
    }

    // Memanggil fungsi tombol "Back"
    backButton();
    ?>
<?php
}
?>
    </div>

    
            </div>
        </div>
    </div>