<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Si Pemo</title>
    <link rel="stylesheet" href="https://dpmptsp.jabarprov.go.id/jelita/backoffice/www/modules/peminjamanmobil/assets/fonts/fontawesome-all.min.css?h=1ccd59155201f54e983ef3bc062fd66b">
    <link rel="stylesheet" href="https://dpmptsp.jabarprov.go.id/jelita/backoffice/www/modules/peminjamanmobil/assets/css/News-Cards.css?h=19de63894dd5898d7874581c81f61f35">
    <link rel="stylesheet" href="https://dpmptsp.jabarprov.go.id/jelita/backoffice/www/modules/peminjamanmobil/assets/css/Responsive-UI-Card.css?h=3effbe6b3f9e82c1c6e21bb5b85e2006">
    <link rel="stylesheet" href="https://dpmptsp.jabarprov.go.id/jelita/backoffice/www/modules/peminjamanmobil/assets/css/styles.css?h=d41d8cd98f00b204e9800998ecf8427e">
    <style>
        .card-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 20px; /* Jarak antar card */
        }
        .card {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            flex: 1 1 calc(25% - 20px); /* 4 kolom dengan jarak */
            min-width: 250px; /* Lebar minimum untuk card */
        
          }
          video {
                width: 100%; /* Buat video mengisi lebar card */
                height: 200px; /* Atur tinggi tetap untuk video */
                object-fit: cover; /* Memastikan video menutupi area yang ditentukan */
            }

        
        .card img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }
        .card-title {
            font-size: 1.2em;
            font-weight: bold;
        }

        /* Media Queries untuk responsivitas */
        @media (max-width: 992px) {
            .card {
                flex: 1 1 calc(33.33% - 20px); /* 3 kolom pada layar menengah */
            }
        }

        @media (max-width: 768px) {
            .card {
                flex: 1 1 calc(50% - 20px); /* 2 kolom pada layar kecil */
            }
        }

        @media (max-width: 576px) {
            .card {
                flex: 1 1 100%; /* 1 kolom pada layar sangat kecil */
            }
        }
    </style>
</head>
<body>
<div id="content">
    <div class="post">
        <div class="title">
            <?php echo $this->lib_date->view_title($page_name); ?>
        </div>
    </div>
   
    <button name="button" type="button" value="Tambah Mobil" class="button-wrc" onclick="parent.location='https://dpmptsp.jabarprov.go.id/jelita/backoffice/peminjamanmobil/tambahmobil'">Tambah Data Video</button>
    <button name="button" type="button" value="Tambah Mobil" class="button-wrc" onclick="parent.location='https://dpmptsp.jabarprov.go.id/jelita/backoffice/info/video_tutor/list_video'">List Video</button>

    <div class="card-container">
    <!-- Card 1 -->
    <div class="card">
        <video controls>
            <source src="https://dpmptsp.jabarprov.go.id/jelita/backoffice/www/modules/info/assets/file_video_tutor/Jelita%20(Revisi)1.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <div class="card-title">Judul Card 1</div>
        <p> <?php
              echo $role_admin 
            ?>.</p>
    </div>
    
    <!-- Card 2 -->
    <div class="card">
        <video controls>
            <source src="https://dpmptsp.jabarprov.go.id/jelita/backoffice/www/modules/info/assets/file_video_tutor/Backoffice - Adimistrasi.mkv" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <div class="card-title">Judul Card 2</div>
        <p>Deskripsi singkat untuk card 2.</p>
    </div>
    
    <!-- Card 3 -->
    <div class="card">
        <video controls>
            <source src="https://dpmptsp.jabarprov.go.id/jelita/backoffice/www/modules/info/assets/file_video_tutor/backoffice administrasi v2.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <div class="card-title">Judul Card 3</div>
        <p>Deskripsi singkat untuk card 3.</p>
    </div>
    
    <!-- Card 4 -->
    <div class="card">
        <video controls>
            <source src="https://dpmptsp.jabarprov.go.id/jelita/backoffice/www/modules/info/assets/file_video_tutor/backoffice administrasi v2.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <div class="card-title">Judul Card 4</div>
        <p>Deskripsi singkat untuk card 4.</p>
    </div>
    
    <!-- Card 5 -->
    <div class="card">
        <video controls>
            <source src="https://dpmptsp.jabarprov.go.id/jelita/backoffice/www/modules/info/assets/file_video_tutor/Kemitraan .mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <div class="card-title">Judul Card 5</div>
        <p>Deskripsi singkat untuk card 5.</p>
    </div>
    
    <!-- Card 6 -->
    <div class="card">
        <video controls>
            <source src="https://dpmptsp.jabarprov.go.id/jelita/backoffice/www/modules/info/assets/file_video_tutor/Pendaftaran Izin.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <div class="card-title">Judul Card 6</div>
        <p>Deskripsi singkat untuk card 6.</p>
    </div>
</div>

</div>

    
    <br style="clear: both;" />
</div>
