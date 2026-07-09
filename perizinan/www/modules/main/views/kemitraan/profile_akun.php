   
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
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places&callback=initMap" async defer></script> -->

<div class="container mt-5">
    <div class="row">
        <div class="col-md-4">
            <!-- Gambar Profil -->
                      <?php
                if($foto == '' || $foto == NULL){
                      ?>
            <img src="https://scontent-cgk1-1.xx.fbcdn.net/v/t1.30497-1/143086968_2856368904622192_1959732218791162458_n.png?_nc_cat=1&ccb=1-7&_nc_sid=2b6aad&_nc_eui2=AeEBALW1AvTfFuoyDAvYsf0Zso2H55p0AlGyjYfnmnQCUX-gTJ8XLE4-NNASRgTyOKgjvebUtXkhAxJWyrLtIPCN&_nc_ohc=FudKRIf__wkAX8lzCh6&_nc_ht=scontent-cgk1-1.xx&oh=00_AfAv90LxhetobBb2i8yVwxbtuv8VRNkADHs2OH8kuZD3Og&oe=65546B78" alt="Foto Profil" class="img-fluid rounded-circle">
                    <?php
                } else {
                    ?>
            <img src="https://dpmptsp.jabarprov.go.id/jelita/assets/mitrakasih/img/logo_company/<?php echo $foto; ?>" alt="Foto Profil" class="img-fluid rounded-circle">
                    <?php 
                }
                    ?>
        </div>
        <div class="col-md-8">
    
		<?php 
			$error 		= $this->session->flashdata("error");
			$success 	= $this->session->flashdata("success");
			if(!empty($error)){
		?>	
			<div class="errorHandler alert alert-danger no-display">
				<i class="fa fa-remove-sign"></i> <?php echo $error; ?>
			</div>
		<?php
			}else if(!empty($success)){
		?>	
			<div class="errorHandler alert alert-success no-display">
			<i class="fa fa-edit-sign"></i><p style="color:green;"><?php echo $success; ?></p>
			</div>
		<?php
			}
		?>
        <!-- <h1 class="mt-4">Profil <?php echo $n_perusahaan; ?></h1>

        <div class="jumbotron"> -->
            <p>Selamat datang di halaman profil Anda.</p>
            
            <h2>Informasi <?php echo $n_perusahaan; ?></h2>
            <p><strong>Nama Perusahaan :</strong> <?php echo $n_perusahaan; ?></p>
            <p><strong>Alamat :</strong> <?php echo $alamat_perusahaan; ?></p>
            <div class="form-group">
                <label class="col-md-3 text">Titik Lokasi</label>
                <div class="col-md-9">
                  <div id="map_div" style="height: 350px;"></div>
                  <br><small>Geser penanda merah <img src="<?php echo base_url(); ?>assets/images/za_marker.png">&nbsp; ke titik lokasi yang dituju kemudian klik penanda tersebut untuk memilih Longitude / Latitude lokasi anda</small>
                </div>
              </div>
              <br><br>
            <p><strong>Deskripsi :</strong> <?php echo $deskripsi; ?></p>
            <p><strong>Website :</strong> <?php echo $website; ?></p>
            <p><strong>Sosmed :</strong> <?php echo $sosmed; ?></p>
            <p><strong>Email :</strong> <?php echo $email; ?></p>
            <p><strong>Nib :</strong> <?php echo $nib; ?></p>
            <p><strong>Kota/Kabupaten :</strong> <?php echo $kabkota; ?></p>
            <br>
<!-- </div> -->
<!-- <center> -->
        <!-- Tambahkan menu lainnya, seperti Edit Profil, Ganti Password, dsb. -->
        <?php
        if($username == NULL || $username == ''){
        ?>
        <form action="/jelita/main/kemitraan/cek_nib" method="post">
                <input type="hidden" class="form-control" name="nib" value="<?php echo $nib; ?>">
            <button type="submit"  class="btn btn-primary">
                Klaim Akun
            </button>
        <?php
        }else{
        ?>
        <a class="btn btn-success" href="/jelita/main/cms/edit/<?php echo base64_encode($id); ?>">Edit</a>
        <?php 
        }
        ?>      

        <!-- Tautan Logout (sesuai dengan kebutuhan aplikasi) -->
        <a class="btn btn-danger" href="javascript:history.back()">kembali</a>
        <br>
        <br>
        <br>

    <!-- </center> -->
                </div>
    </div>
    </div>
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
  <script>
    $(".readonly").keydown(function(e){
        e.preventDefault();
    });
  </script>


            <!-- <label class="col-md-3 text">Long / Lat</label>
            <?php 
            // if($maps_latitude != NULL && $maps_longitude != NULL){
            ?>
            <input type="number" step="any" id="maps_longitude" name="maps_longitude" min="106.393405" max="108.837612"  class="form-control" onkeypress="return false;" onpaste="return false;" style="background: #D3D3D3;" placeholder="Gunakan Peta diatas untuk mengisi Longitude" required>
            <input type="number" id="maps_latitude" step="any" min="-7.818470" max="-5.917956"  name="maps_latitude" class="form-control" onkeypress="return false;" onpaste="return false;" style="background: #D3D3D3;" placeholder="Gunakan Peta diatas untuk mengisi Latitude" required>
            <?php
            // }else{
            ?>
            <p><strong>maps_longitude :</strong> <?php echo $maps_longitude; ?></p>
            <p><strong>maps_latitude :</strong> <?php echo $maps_latitude; ?></p>
            <?php
            // } 
            ?> -->
