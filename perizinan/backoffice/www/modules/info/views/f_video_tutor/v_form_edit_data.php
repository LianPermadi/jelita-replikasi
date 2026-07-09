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

       
        <div class="entry">
            <div id="tabs">
                <ul>
                    <li><a href="#tabs-1">Upload Video Tutorial</a></li>
                </ul>
                <div id="tabs-1">
                <form action="https://dpmptsp.jabarprov.go.id/jelita/backoffice/info/video_tutor/update" method="POST">
                        <input type="hidden" name="id" value="<?php echo $video['id']; ?>">
        
                        <table cellpadding="0" cellspacing="0" border="0" class="display">
                            <tbody>
                                <tr>
                                    <td align="left" width="15%" class="bg-grid">
                                        <b>Judul Video</b>
                                    </td>
                                    <td class="bg-grid">
                                        <input type="text" name="video_title" value="<?php echo htmlspecialchars($video['video_title']); ?>" style="width:100%" class="input-wrc" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" width="15%" class="bg-grid">
                                        <b>File Video</b>
                                    </td>
                                    <td class="bg-grid">
                                    
                                        <input type="file" class="submit-wrc" id="video_file" name="file_video" accept="video/*">
                                        <small>Unggah video baru jika ingin mengganti video yang ada.</small>
                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" width="15%">
                                        <b>Status</b>
                                    </td>
                                    <td>
                                        <select name="status" style="width:100%" class="select-wrc" required>
                                            <option value="1" <?php echo ($video['status'] == 1) ? 'selected' : ''; ?>>Aktif</option>
                                            <option value="0" <?php echo ($video['status'] == 0) ? 'selected' : ''; ?>>Non-Aktif</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" width="15%" class="bg-grid">
                                        <b>Deskripsi</b>
                                    </td>
                                    <td class="bg-grid">
                                        <textarea name="description" style="width:100%" class="text-wrc" rows="5" required><?php echo htmlspecialchars($video['description']); ?></textarea>
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
