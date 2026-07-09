<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Istana Djaya Plaza</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
</head>
<div id="content">
    <div class="post">
        <div class="title">
          <?php echo $this->lib_date->view_title($page_name); ?>
        </div>

        <?php
        foreach ($user as $row) {
            $id_user = $row->id;
            $nama = $row->n_pegawai;
        }
        $alert = $this->session->flashdata("sukses");
        if (!empty($alert)) {
        ?>
            <br>
            <div style="color: green; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;">
                <center><?php echo $alert; ?></center>
            </div>
        <?php } ?>

        <?php
        $alert = $this->session->flashdata("gagal");
        if (!empty($alert)) {
        ?>
            <br>
            <div style="color: red; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;">
                <center><?php echo $alert; ?></center>
            </div>
        <?php } ?>

        <div class="entry">
            <div id="tabs">
                <ul>
                    <li><a href="#tabs-1">Upload Video Tutorial</a></li>
                </ul>
                <div id="tabs-1">
                <form action="https://dpmptsp.jabarprov.go.id/jelita/backoffice/info/video_tutor/upload" method="POST" enctype="multipart/form-data">

                        <table cellpadding="0" cellspacing="0" border="0" class="display">
                            <tbody>
                                <tr>
                                    <td align="left" width="15%" class="bg-grid">
                                        <b>Judul Video
                                        </b>
                                    </td>
                                    <td class="bg-grid">
                                        <input type="text" name="video_title" style="width:100%" class="input-wrc" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" width="15%" class="bg-grid">
                                        <b>File Video</b>
                                    </td>
                                    <td class="bg-grid">
                                        <input type="file" class="submit-wrc" id="video_file" name="file_video" accept="video/*" required>
                                    </td>
                                </tr>
                               
                                <tr>
                                    <td align="left" width="15%">
                                        <b>Status</b>
                                    </td>
                                    <td>
                                        <select name="status" style="width:100%" class="select-wrc" required>
                                            <option value="1">Aktif</option>
                                            <option value="0">Non-Aktif</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" width="15%" class="bg-grid">
                                        <b>Deskripsi</b>
                                    </td>
                                    <td class="bg-grid">
                                        <textarea name="description" style="width:100%" class="text-wrc" rows="5" required></textarea>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                </div>
            </div>
            <label>&nbsp;</label>
            <div class="spacer"></div>  
        </div>
        <div class="entry" style="text-align: center;">
                <input type="submit" name="submit" value="Simpan" class="submit-wrc" content="Simpan">
            <span></span>
            <button name="button" type="button" class="button-wrc" onclick="parent.location='<?php echo site_url('info/video_tutor'); ?>'">Batal</button>
        </div>
        </form>
    </div>
    <br style="clear: both;" />
</div>

<script type="text/javascript">
    
    function previewVideo() {
        const video = document.querySelector('#video_file');
        const videoPreview = document.querySelector('.video-preview');

        videoPreview.style.display = 'block';

        const oFReader = new FileReader();
        oFReader.readAsDataURL(video.files[0]);
        oFReader.onload = function(oFREvent) {
            videoPreview.src = oFREvent.target.result;
        }
    }

</script>
