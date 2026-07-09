<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gambar dengan Tombol</title>
    <style>
        .image-container {
            position: relative;
            display: inline-block;
        }

        .img-preview {
            display: block;
            max-height: 250px;
            max-width: 250px;
        }

        .btn-overlay {
            position: absolute;
            bottom: 10px;  /* Atur posisi tombol */
            left: 50%;
            transform: translateX(-50%);
            background-color: rgba(0, 0, 0, 0.6);
            color: white;
            border: none;
            padding: 5px 10px;
            font-size: 12px; /* Ukuran teks lebih kecil */
            cursor: pointer;
            border-radius: 3px;
        }

        .btn-overlay:hover {
            background-color: rgba(0, 0, 0, 0.8);
        }
    </style>
</head>

<?php 
  if (!empty($ruangan)) {
    $nama_ruangan = $ruangan->nama_ruangan;
    $lantai = $ruangan->lantai;
    $kapasitas = $ruangan->kapasitas;
    $fasilitas = $ruangan->fasilitas;
    $id = $ruangan->id;
    $status = $ruangan->status;
    $foto = $ruangan->foto;
  } else {
    $nama_ruangan = "";
    $lantai = "";
    $kapasitas = "";
    $fasilitas = "";
    $id = "";
    $status = "";
    $foto = "";
  }
  $foto_arr = explode(";", $foto);
  $jml_arr = count($foto_arr);
  if($foto == ""){
  	$jml_arr = 0;
  }
  //var_dump($jml_arr); die();
?>

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
      <?php
    }
    $alert = $this->session->flashdata("gagal");
    if(!empty($alert)){
      ?>
      <br>
      <div style="color: red; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;"><center><?php echo $alert; ?></center></div>
      <?php
    }
    ?>
    <form method="post" action="<?php echo site_url().'ruangan/'.$step; ?>" enctype="multipart/form-data">
      <div class="entry">
        <div id="tabs">
          <ul>
            <li><a href="#tabs-1">Input Master Ruangan</a></li>
          </ul>
          <div id="tabs-1">
          <?php 
            if ($step == "master_update") { ?>
              <input type="hidden" name="id" value="<?php echo $id; ?>">
              <?php
            }
            ?>
            <table cellpadding="0" cellspacing="0" border="0" class="display">
              <tbody>
                <tr>
                  <td align="left" width="15%">
                    <b>Nama Ruangan</b>
                  </td>
                  <td>
                    <input type="text" name="nama_ruangan" style="width:100%" class="input-wrc" value="<?php echo $nama_ruangan; ?>" required="required">
                  </td>
                </tr>
                <tr>
                  <td align="left" width="15%" class="bg-grid">
                    <b>Lantai</b>
                  </td>
                  <td class="bg-grid">
                    <input type="text" name="lantai" style="width:100%" class="input-wrc" value="<?php echo $lantai; ?>" required="required">
                  </td>
                </tr>
                <tr>
                  <td align="left" width="15%">
                    <b>Kapasitas</b>
                  </td>
                  <td>
                    <input type="text" name="kapasitas" style="width:100%" class="input-wrc" value="<?php echo $kapasitas; ?>" required="required">
                  </td>
                </tr>
                <tr>
                  <td align="left" width="15%" class="bg-grid">
                    <b>Fasilitas</b>
                  </td>
                  <td class="bg-grid">
                    <textarea name="fasilitas" style="width:100%" class="input-area-wrc"><?php echo $fasilitas; ?></textarea>
                  </td>
                </tr>
                <tr>
                  <td align="left" width="15%">
                    <b>Status Ruangan</b>
                  </td>
                  <td>
                  	<?php
                    $kat_cari = array('0' => 'Tidak Dapat Digunakan','1' => 'Dapat Digunakan');
                    echo form_dropdown('status', $kat_cari, $status, 'class = "input-select-wrc" id="selector"');
                    ?>
                    <!--<input type="text" name="status" style="width:100%" class="input-wrc" value="<?php echo $status; ?>" required="required">-->
                  </td>
                </tr>
                <?php //if($this->All){?>
                	
                <!-- Upload Area -->		
				        <tr>
                  <td align="left" width="15%" class="bg-grid">
                    <b>Foto</b>
                  </td>
                  <td style="padding:10px;" class="bg-grid">
                    <input type="hidden" name="oldfoto" value="<?php echo $foto; ?>"> 
                    <?php
                    if($foto){
                    	foreach ($foto_arr as $item) {
                        ?>
                        <div class="image-container" id="image-container">
                          <?php 
                          // var_dump($_SERVER);
                            $routees = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']); 
                            //echo $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $routees . 'assets/ruangan/image/' . $item; 
                            // die(); 
                          ?>
                          <img id="image" src="<?php echo $_SERVER['REQUEST_SCHEME']; ?>://<?php echo $_SERVER['HTTP_HOST'] . $routees; ?>assets/ruangan/image/<?php echo $item; ?>" class="img-preview">
                          <input type="checkbox" name="selected_images[]" value="<?php echo $item; ?>" class="image-checkbox">Check Hapus
                        </div>
                        <?php
                      }
                    }else{
                      ?>
                      <img class="img-preview img-fluid mb-3 col-sm-5" style="max-height: 250px; max-width: 250px;">
                      <?php
                    }
                    ?>
                    <br>
                    <input type="file" class="submit-wrc" id="foto" onchange="previewImage()" name="gambar" style="width:20%;" accept=".jpg,.jpeg,.png,.JPG,.JPEG,.PNG" value="">
                    <!-- <input type="text"  value="<?php echo $row->foto; ?>"> -->
                  </td>
                </tr>  
                <!-- EOF() Upload Area -->
                <?php
                //}?>
              </tbody>
            </table>
          </div>
        </div>
        <label>&nbsp;</label>
        <div class="spacer"></div>
      </div>
      <div class="entry" style="text-align: center;">
        <?php 
        if($step == "master_simpan"){
          ?>
          <input type="submit" name="submit" value="Simpan" class="submit-wrc" content="Simpan">
          <?php
        }else{
          ?>
          <input type="submit" name="submit" value="Ubah" class="submit-wrc" content="Ubah">
          <?php
        }
        ?>
        <span></span>
        <button name="button" type="button" class="button-wrc" onclick="parent.location='<?php echo site_url('ruangan/master'); ?>'">Batal</button>
      </div>
    </form>
  </div>
  <br style="clear: both;" />
</div>

<script>
    function deleteImage() {
        let filename = "<?php echo $item; ?>"; // Ambil nama file dari PHP
        if (confirm("Apakah Anda yakin ingin menghapus gambar ini?")) { 
            fetch('ruangan/deleteImage', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'filename=' + encodeURIComponent(filename)
            })
            .then(response => response.json()) // CI4 response dalam JSON
            .then(data => {
                if (data.status === "success") {
                    alert(data.message);
                    document.getElementById("image-container").remove(); // Hapus gambar dari tampilan
                } else {
                    alert("Gagal menghapus gambar: " + data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        }
    }

    document.getElementById("delete-btn").addEventListener("click", deleteImage);
</script>
