<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<div id="content">
  <div class="post">
    <div class="title">
      <?php echo $this->lib_date->view_title($page_name); ?>
      <!-- Lib Date View Title Here -->
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
    <?php
    }
    ?>
    <?php
    if ($this->session->flashdata('error')) {
    ?>
        <div class="alert alert-danger" role="alert" style="text-align:center;">
            <?php echo $this->session->flashdata('error'); ?>
        </div>
        <br>
        <div style="color: red; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;"><center><?php echo $alert; ?></center></div>
    <?php } ?>
    <?php
    if ($this->session->flashdata('success')) {
    ?>
        <div class="alert alert-danger" role="alert" style="text-align:center;">
            <?php echo $this->session->flashdata('success'); ?>
        </div>
    <?php
    }
    ?>

    <form method="post" action="<?php echo site_url().'info/invesment/store' ?>" enctype="multipart/form-data">
        <div class="entry">
            <div id="tabs">
                <ul>
                <li><a href="#tabs-1">Tambah Investasi</a></li>
                
                </ul>
            <div id="tabs-1">
                <table cellpadding="0" cellspacing="0" border="0" class="display">
                    <tbody>
                        <tr>
                            <td align="left" width="15%" class="bg-grid">
                                <b>Judul Investasi</b>
                            </td>
                            <td class="bg-grid">
                                <input type="text" class="input-wrc" style="width:100%" id="judul_investasi" placeholder="Investasi 1" name="judul_investasi">
                            </td>
                        </tr>

                        <tr>
                            <td align="left" width="15%" class="bg-grid">
                                <b>Bahasa</b>
                            </td>
                            <td class="bg-grid">
                                <select class="input-wrc" name="isBahasa" value="{!! old('isBahasa') !!}">
                                    <option value='0'>Indonesia</option>
                                    <option value='1'>Inggris</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td align="left" width="15%" class="bg-grid">
                                <b>Tipe Sektor</b>
                            </td>
                            <td class="bg-grid">
                                <select class="form-control" id="fk_sector" name="fk_sector">
                                    <?php foreach ($sectors as $sector): ?>
                                        <option value="<?= $sector['id'] ?>" <?= set_select('fk_sector', $sector['id']) ?>>
                                            <?= $sector['title'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td align="left" width="15%" class="bg-grid">
                                <b>Diskripsi Sektor</b>
                            </td>
                            <td class="bg-grid">
                                <input type="text" class="input-wrc" style="width:100%" id="investment_type" name="investment_type" placeholder="Diskripsi Sektor">
                            </td>
                        </tr>
                        <tr>
                            <td align="left" width="15%" class="bg-grid">
                                <b>Image</b>
                            </td>
                            <td class="bg-grid">
                                <input type="file" name="image" id="imageInput" accept="image/*" onchange="previewImage(event)">
                                <small>*max 100 mb</small>
                                <br>
                                <img id="imagePreview" src="#" alt="Preview" style="max-width: 200px; max-height: 200px; margin-top: 10px; display: none;">
                            </td>
                        </tr>
                        <tr>
                            <td align="left" width="15%" class="bg-grid">
                                <b>Mini Deskripsi</b>
                            </td>
                            <td class="bg-grid">
                                <textarea placeholder="Deskripsi singkat max 150 kata" style="width:100%; height: 100px;" id="mini_deskripsi" name="mini_deskripsi"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td align="left" width="15%" class="bg-grid">
                                <b>Project Value</b>
                            </td>
                            <td class="bg-grid">
                                <input type="number" class="input-wrc" style="width:100%" id="project_value" name="project_value">
                            </td>
                        </tr>
                        <tr>
                            <td align="left" width="15%" class="bg-grid">
                                <b>Kategori</b>
                            </td>
                            <td class="bg-grid">
                                <select name="kategori">
                                    <option value="building">Building</option>
                                    <option value="landscape">Landscape</option>
                                </select>
                                <!-- <input type="text" class="input-wrc" style="width:100%" id="kategori" name="kategori"> -->
                            </td>
                        </tr>
                        <tr>
                            <td align="left" width="15%" class="bg-grid">
                                <b>Author</b>
                            </td>
                            <td class="bg-grid">
                                <input type="text" class="input-wrc" style="width:100%" id="author" name="author" placeholder="author">
                            </td>
                        </tr>
                        <tr>
                            <td align="left" width="15%" class="bg-grid">
                                <b>Author Image</b>
                            </td>
                            <td class="bg-grid">
                                <input type="file" id="author_image" name="author_image" accept="image/*" onchange="previewAuthorImage(event)">
                                <small>*max 100 mb</small>
                                <br>
                                <img id="authorImagePreview" src="#" alt="Author Image Preview" style="max-width: 200px; max-height: 200px; margin-top: 10px; display: none;">
                            </td>
                        </tr>
                        <tr>
                            <td align="left" width="15%" class="bg-grid">
                                <b> Job Title</b>
                            </td>
                            <td class="bg-grid">
                                <input type="text" class="input-wrc" style="width:100%" id="job_title" name="job_title" placeholder="job title">
                            </td>
                        </tr>
                        <tr>
                            <td align="left" width="15%" class="bg-grid">
                                <b>Klik untuk mendapatkan koordinat:</b>
                            </td>
                            <td align="left" width="100%" class="bg-grid">
                                <div id="map-canvas" style="height: 400px; width: 100%; margin-top: 2%;"></div>
                            </td>
                        </tr>
                        <tr>
                            <td align="left" width="15%" class="bg-grid">
                                <b>Lokasi</b>
                            </td>
                            <td class="bg-grid">
                                <input type="text" class="input-wrc" style="width:100%" id="lokasi" name="lokasi" placeholder="Silahkan Masukan Lokasi Lalu Enter">
                            </td>
                        </tr>
                        
                        
                        <tr>
                            <td align="left" width="15%" class="bg-grid">
                                <b>Long</b>
                            </td>
                            <td class="bg-grid">
                                <input type="text" class="input-wrc" style="width:100%" id="lng" name="long">
                            </td>
                        </tr>
                        <tr>
                            <td align="left" width="15%" class="bg-grid">
                                <b>Lat</b>
                            </td>
                            <td class="bg-grid">
                                <input type="text" class="input-wrc" style="width:100%" id="lat" name="lat">
                            </td>
                        </tr>
                        
                        <tr>
                            <td align="left" width="15%" class="bg-grid">
                                <b>Project Description</b>
                            </td>
                            <td class="bg-grid">
                                <textarea  style="width:100%; height: 100px;" id="project_desc" name="project_desc"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td align="left" width="15%" class="bg-grid">
                                <b>Invest Scheme</b>
                            </td>
                            <td class="bg-grid">
                                <textarea style="width:100%; height: 100px;" id="invest_scheme" name="invest_scheme"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td align="left" width="15%" class="bg-grid">
                                <b>IRR</b>
                            </td>
                            <td class="bg-grid">
                                <input type="text" class="input-wrc" style="width:100%" id="irr" name="irr" placeholder="IRR">
                            </td>
                        </tr>
                        <tr>
                            <td align="left" width="15%" class="bg-grid">
                                <b>NPV</b>
                            </td>
                            <td class="bg-grid">
                                <input type="text" class="input-wrc" style="width:100%" id="npv" name="npv" placeholder="NPV">
                            </td>
                        </tr>
                        <tr>
                            <td align="left" width="15%" class="bg-grid">
                                <b> Payback Period</b>
                            </td>
                            <td class="bg-grid">
                                <input type="text" class="input-wrc" style="width:100%" id="payback_period" name="payback_period" placeholder="Payback Period">
                            </td>
                        </tr>
                        <tr>
                            <td align="left" width="15%" class="bg-grid">
                                <b>Support File</b>
                            </td>
                            <td class="bg-grid">
                                <input type="file" id="support_file" name="support_file">
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div style="display: flex; flex-direction: row; align-items: center; margin-top: 2%;">
                    <div style="margin-left: auto;"> <!-- Bagian kanan, tombol -->
                        <button name="button" type="submit" id="tambahDataBtn" class="button-wrc">Simpan Data Investasi</button>
                        <button name="button" type="button" value="Checkout Barang" class="button-wrc" onclick="parent.location='https://dpmptsp.jabarprov.go.id/jelita/backoffice/info/invesment'">Batal Simpan Data</button>

                    </div>
                </div>
            </div>
        </div>
    </form>
  </div>
  <br style="clear: both;" />
</div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Include jQuery UI -->
    <!-- <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!-- Include Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <!-- Include Leaflet Geocoder Plugin -->
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <!-- Tambahkan skrip JavaScript di bagian bawah -->
    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function () {
                var preview = document.getElementById('imagePreview');
                preview.src = reader.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
    <script>
        function previewAuthorImage(event) {
            var reader = new FileReader();
            reader.onload = function () {
                var preview = document.getElementById('authorImagePreview');
                preview.src = reader.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>

    <script>
        // Initialize the map OPEN Street
        var map = L.map('map-canvas').setView([-6.902485, 107.618033], 8); // Set the initial view

        // Add the OpenStreetMap tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: 'Map data © OpenStreetMap contributors',
        }).addTo(map);

        // Add a marker to the map
        var marker = L.marker([-6.902485, 107.618033], {
            draggable: true
        }).addTo(map);

        // Update the latitude and longitude inputs when the marker is dragged
        marker.on('dragend', function(e) {
            var latlng = marker.getLatLng();
            $('#lat').val(latlng.lat);
            $('#lng').val(latlng.lng);
        });

        // Search functionality
        $('#lokasi').on('keydown', function(e) {
            if (e.keyCode === 13) { // Enter key
                e.preventDefault();
                var query = $(this).val();
                if (query.trim() !== '') {
                    var geocoder = L.Control.Geocoder.nominatim();
                    geocoder.geocode(query, function(results) {
                        if (results.length > 0) {
                            var latlng = results[0].center;
                            marker.setLatLng(latlng);
                            map.setView(latlng);
                            $('#lat').val(latlng.lat);
                            $('#lng').val(latlng.lng);
                        } else {
                            console.log('Location not found');
                        }
                    });
                }
            }
        });
    </script>
