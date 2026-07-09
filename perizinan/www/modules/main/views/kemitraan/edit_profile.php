
  <style type="text/css">
    #pageloader
    {
      background: rgba( 255, 255, 255, 0.8 );
      display: none;
      height: 100%;
      position: fixed;
      width: 100%;
      z-index: 9999;
    }

    #pageloader img
    {
      left: 50%;
      margin-left: -32px;
      margin-top: -32px;
      position: absolute;
      top: 50%;
    }
  </style>
  <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900' rel='stylesheet' type='text/css'>
   <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?&key=AIzaSyA4ViLjNIDHrK3RnRjhLffu1JvXiCaIrUE&v=3&amp;sensor=false"></script>
    <div class="container">
        <h2>Edit Profil Perusahaan</h2>
        <br>
        <br>
        <form action="/jelita/main/kemitraan/edit_proses" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="namaPerusahaan">Nama Perusahaan:</label>
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <input type="text" class="form-control" id="namaPerusahaan" name="namaPerusahaan" placeholder="Nama Perusahaan" value="<?php echo $n_perusahaan; ?>">
            </div>
            <div class="form-group">
                <label for="alamat">Alamat:</label>
                <input type="text" class="form-control" value="<?php echo $alamat_perusahaan; ?>" id="alamat" name="alamat" placeholder="Alamat Perusahaan">
            </div>
            <div class="form-group">
                <label for="lokasiPoint">Location Point (Longlat):</label>
            <div class="form-group">
                <label class="col-md-3 text">Titik Lokasi</label>
                <div class="col-md-9">
                  <div id="map_div" style="height: 350px;"></div>
                  <br><small>Geser penanda merah <img src="<?php echo base_url(); ?>assets/images/za_marker.png">&nbsp; ke titik lokasi yang dituju kemudian klik 2x penanda tersebut untuk memilih Longitude / Latitude lokasi anda</small>
                </div>
              </div>
              <br><br>
                <!-- <input type="text" class="form-control" value="<?php echo $maps_longitude; ?>" id="lokasiPoint" name="lokasiPoint" placeholder="Contoh: -6.926117458092356, 107.626613670755"> -->
                <input type="number" step="any" id="maps_longitude" name="maps_longitude" min="106.393405" max="108.837612"  class="form-control" value="<?php echo $maps_longitude; ?>" onkeypress="return false;" onpaste="return false;" style="background: #D3D3D3;" placeholder="Gunakan Peta diatas untuk mengisi Longitude" required>
                <input type="number" id="maps_latitude" step="any" min="-7.818470" max="-5.917956"  name="maps_latitude" class="form-control" value="<?php echo $maps_latitude; ?>" onkeypress="return false;" onpaste="return false;" style="background: #D3D3D3;" placeholder="Gunakan Peta diatas untuk mengisi Latitude" required>
            </div>
            <div class="form-group">
                <label for="deskripsi">Deskripsi Perusahaan (Toko):</label>
                <textarea class="form-control" id="deskripsi" value="<?php echo $deskripsi; ?>" name="deskripsi" placeholder="Deskripsi Perusahaan"><?php echo $deskripsi; ?></textarea>
            </div>
            <div class="form-group">
                <label for="sosmed">Sosial Media Perusahaan:</label>
                <input type="text" class="form-control" id="sosmed" value="<?php echo $sosmed; ?>" name="sosmed" placeholder="Sosial Media Perusahaan">
            </div>
            <div class="form-group">
                <label for="website">Website Perusahaan:</label>
                <input type="text" class="form-control" id="website" value="<?php echo $website; ?>" name="website" placeholder="Website Perusahaan">
            </div>
            <div class="form-group">
                <label for="telpon">Nomor Telepon:</label>
                <input type="text" class="form-control" id="telpon" value="<?php echo $telepon; ?>" name="telpon" placeholder="Nomor Telepon Perusahaan">
            </div>
            <div class="form-group">
                <label for="skPembentukan">Perlu SK Pembentukan Perusahaan:</label><br>
                <select class="form-control" id="skPembentukan" name="skPembentukan">
                    <option value="Ya">Ya</option>
                    <option value="Tidak">Tidak</option>
                </select>
            </div>
            <div class="form-group">
                <br><br><label for="email">Email Perusahaan:</label>
                <input type="email" class="form-control" id="email" value="<?php echo $email; ?>" name="email" placeholder="Email Perusahaan" readonly>
                <p><span Style="color:red;">*</span> Jika ingin mengubah Alamat Email Anda Perlu melakukan konfirmasi kepada Admin</p>
            </div>
            <div class="form-group">
                <br><br><label for="email">Logo Perusahaan :</label>
                
                    <?php if ($foto) { ?>
                        <img src="https://dpmptsp.jabarprov.go.id/jelita/assets/mitrakasih/img/logo_company/<?php echo $foto; ?>" class="img-preview img-fluid mb-3 col-sm-5" style="max-height: 250px; max-width: 250px;">
                    <?php }else{ ?>
                        <img 
                        class="img-preview img-fluid mb-3 col-sm-5" 
                        style="max-height: 250px; max-width: 250px;"
                        >
                    <?php } ?>
                    <input type="file" class="form-control" id="foto" onchange="previewImage()" name="userfile" style="width:100%;" accept=".jpg,.jpeg,.png,.JPG,.JPEG,.PNG" value="">
                <p><span Style="color:red;">*</span> Jika ingin mengubah Alamat Email Anda Perlu melakukan konfirmasi kepada Admin</p>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>
    <br><br>

<script>
    function previewImage() {
        const image = document.querySelector('#foto');
        const imgPreview = document.querySelector('.img-preview')

        imgPreview.style.display = 'block';

        const oFReader = new FileReader();
        oFReader.readAsDataURL(image.files[0]);
        oFReader.onload = function(oFREvent) {
            imgPreview.src = oFREvent.target.result;
        }
    }

    var currencyInput = document.querySelectorAll( 'input[type="currency"]' );

    for ( var i = 0; i < currencyInput.length; i++ ) {

        var currency = 'IDR'
        onBlur( {
            target: currencyInput[ i ]
        } )

        currencyInput[ i ].addEventListener( 'focus', onFocus )
        currencyInput[ i ].addEventListener( 'blur', onBlur )

        function localStringToNumber( s ) {
            return Number( String( s ).replace( /[^0-9.-]+/g, "" ) )
        }

        function onFocus( e ) {
            var value = e.target.value;
            e.target.value = value ? localStringToNumber( value ) : ''
        }

        function onBlur( e ) {
            var value = e.target.value

            var options = {
                maximumFractionDigits: 0,
                currency: currency,
                style: "currency",
                currencyDisplay: "symbol"
            }

            e.target.value = ( value || value === 0 ) ?
                localStringToNumber( value ).toLocaleString( undefined, options ) :
                ''
        }
    }
    var currencyInput = document.querySelectorAll( 'input[type="currency"]' );

    for ( var i = 0; i < currencyInput.length; i++ ) {

        var currency = 'IDR'
        onBlur( {
            target: currencyInput[ i ]
        } )

        currencyInput[ i ].addEventListener( 'focus', onFocus )
        currencyInput[ i ].addEventListener( 'blur', onBlur )

        function localStringToNumber( s ) {
            return Number( String( s ).replace( /[^0-9.-]+/g, "" ) )
        }

        function onFocus( e ) {
            var value = e.target.value;
            e.target.value = value ? localStringToNumber( value ) : ''
        }

        function onBlur( e ) {
            var value = e.target.value

            var options = {
                maximumFractionDigits: 0,
                currency: currency,
                style: "currency",
                currencyDisplay: "symbol"
            }

            e.target.value = ( value || value === 0 ) ?
                localStringToNumber( value ).toLocaleString( undefined, options ) :
                ''
        }
    }
</script>
    <script>
    var map;
    var maps_latitude = <?php echo json_encode($maps_latitude); ?>; // Ambil nilai dari PHP
    var maps_longitude = <?php echo json_encode($maps_longitude); ?>;

    function initializeMap() {
        var mapDiv = document.getElementById("map_div");

        if (maps_latitude !== null && maps_longitude !== null) {
            var centerCoords = new google.maps.LatLng(maps_latitude, maps_longitude);
        } else {
            var centerCoords = new google.maps.LatLng(-6.926117458092356, 107.626613670755);
        }

        var mapOptions = {
            center: centerCoords,
            zoom: 15,
            draggable: true,
            styles: [
                { "featureType": "poi", "elementType": "labels.text", "stylers": [{ "visibility": "off" }] },
                { "featureType": "poi.business", "stylers": [{ "visibility": "off" }] },
                { "featureType": "road", "elementType": "labels.icon", "stylers": [{ "visibility": "off" }] },
                { "featureType": "transit", "stylers": [{ "visibility": "off" }] }
            ]
        };

        map = new google.maps.Map(mapDiv, mapOptions);

        var infoWindow = new google.maps.InfoWindow();

        function createMarker(options, html) {
            var marker = new google.maps.Marker(options);
            if (html) {
                google.maps.event.addListener(marker, "click", function () {
                    infoWindow.setContent(html);
                    infoWindow.open(options.map, this);
                });
            }
            return marker;
        }

        var marker1 = createMarker({
            position: centerCoords,
            draggable: true,
            map: map
        });

        marker1.addListener('click', function (event) {
            document.getElementById("maps_latitude").value = event.latLng.lat();
            document.getElementById("maps_longitude").value = event.latLng.lng();

            alert(document.getElementById("maps_latitude").value + " ," + document.getElementById("maps_longitude").value)
        });
    }

    google.maps.event.addDomListener(window, "load", initializeMap);
</script>