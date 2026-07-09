<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Anda</title>
    
    <!-- Tautan ke Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div id="content" class="container">
        <div class="post">
            <div class="title">
                <h1><?php echo $page_name; ?></h1>
            </div>
            <h2>Yang Bertanda tangan di bawah ini</h2>
            <img src="<?php echo $qr_code; ?>" alt="QR Code" width="400px">
            <table class="table table-bordered">
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td><?php echo $n_pegawai; ?></td>
                </tr>
                <tr>
                    <td>NIP</td>
                    <td>:</td>
                    <td><?php echo $nip; ?></td>
                </tr>
                <tr>
                    <td>Pangkat Golongan</td>
                    <td>:</td>
                    <td><?php echo $pangkat_gol; ?></td>
                </tr>
                <tr>
                    <td>Golongan</td>
                    <td>:</td>
                    <td><?php echo $golongan; ?></td>
                </tr>
                <tr>
                    <td>
                        <label class="label-wrc">Bentuk ttd</label>
                    </td>
                    <td>:</td>
                    <td>
                        <!-- https://spekta.tasikmalayakab.go.id/spekta/backoffice/uploads/logo/197104092002121005.png -->
                        <!-- https://spekta.tasikmalayakab.go.id/spekta/backoffice/uploads/logo/<?php echo $post_SE.'.png' ?> -->
                        <?php $post_SE = str_replace(' ', '', $nip); ?>
                        <img src='https://spekta.tasikmalayakab.go.id/spekta/backoffice/uploads/logo/<?php echo $post_SE.'.png' ?>' height="20%" width="20%">
                    </td>
                </tr>
                <tr>
                    <td>Tanggal Jabatan</td>
                    <td>:</td>
                    <td><?php 
                    $dateString = $tgl_jabat;
                    $timestamp = strtotime($dateString);
                    $tanggalIndonesia = date("d F Y", $timestamp);

                    echo $tanggalIndonesia; // Output: 11 Januari 2022
                    ?></td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Tautan ke Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
