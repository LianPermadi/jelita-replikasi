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
        .alert {
    padding: 15px;
    margin-bottom: 20px;
    border: 1px solid transparent;
    border-radius: 4px;
    position: relative;
}

.alert-success {
    color: #155724;
    background-color: #d4edda;
    border-color: #c3e6cb;
}

.alert-danger {
    color: #721c24;
    background-color: #f8d7da;
    border-color: #f5c6cb;
}

/* Optional: Add some hover effects for better UX */
.alert:hover {
    opacity: 0.9;
}

/* Optional: Add an icon to the alerts */
.alert-success::before {
    content: "✔️"; /* Success icon */
    margin-right: 10px;
}

.alert-danger::before {
    content: "❌"; /* Error icon */
    margin-right: 10px;
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
    <?php if ($this->session->flashdata('sukses')): ?>
        <div class="alert alert-success">
            <?php echo $this->session->flashdata('sukses'); ?>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('gagal')): ?>
        <div class="alert alert-danger">
            <?php echo $this->session->flashdata('gagal'); ?>
        </div>
    <?php endif; ?>
    <?php
    // Menampilkan role_admin (optional, bisa dihapus jika tidak diperlukan)
    echo $role_admin;

    // Cek apakah role_admin adalah 1
    if ($role_admin == 1) {
        // Jika role_admin bernilai 1, tampilkan tombol "Tambah Data Video"
        ?>
        <button name="button" type="button" value="Tambah Mobil" class="button-wrc" 
        onclick="parent.location='https://dpmptsp.jabarprov.go.id/jelita/backoffice/info/video_tutor/Form_Tambah_Data_Video'">
            Tambah Data Video
        </button>
        <?php
    }
    ?>
    <!-- Tombol "List Video" tetap ditampilkan tanpa syarat -->
    <button name="button" type="button" value="List Video" class="button-wrc" 
    onclick="parent.location='https://dpmptsp.jabarprov.go.id/jelita/backoffice/info/video_tutor/list_video'">
        List Video
    </button>

    <div class="card-container">
        <?php if (!empty($videos)): ?>
            <?php foreach ($videos as $video): ?>
                <div class="card">
                    <video controls>
                        <source src="<?php echo site_url('www/modules/info/assets/file_video_tutor/' . $video['file_video']); ?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    <div class="card-title"><?php echo htmlspecialchars($video['video_title']); ?></div>
                    <p><?php echo htmlspecialchars($video['description']); ?></p>

                    <?php if ($role_admin == 1): ?>
                        <!-- Tombol Edit hanya muncul jika role_admin adalah 1 -->
                        <button name="button" type="button" class="button-wrc" 
                        onclick="parent.location='https://dpmptsp.jabarprov.go.id/jelita/backoffice/info/video_tutor/edit_video/<?php echo $video['id']; ?>'">
                            Edit Video
                        </button>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Tidak ada video tutorial yang tersedia.</p>
        <?php endif; ?>
    </div>
</div>




</div>

    
    <br style="clear: both;" />
</div>
