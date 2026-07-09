<!DOCTYPE html>
<html>
<head>
 
        <?php echo $template['partials']['header']; ?>
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
<!-- <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900' rel='stylesheet' type='text/css'> -->
   <!-- <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?&key=AIzaSyA4ViLjNIDHrK3RnRjhLffu1JvXiCaIrUE&v=3"></script> -->
  <!-- <script>
    var map;
    google.maps.event.addDomListener(window, "load", function () {
      if ($('#map_div').length){
          var map = new google.maps.Map(document.getElementById("map_div"), {
          center: new google.maps.LatLng(-6.8725635, 107.5403431),
          zoom: 15,
          draggable:true,
          styles:
              [ { "featureType": "poi", "elementType": "labels.text", "stylers": [ { "visibility": "off" } ] }, { "featureType": "poi.business", "stylers": [ { "visibility": "off" } ] }, { "featureType": "road", "elementType": "labels.icon", "stylers": [ { "visibility": "off" } ] }, { "featureType": "transit", "stylers": [ { "visibility": "off" } ] } ]
        });

                      
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
          position: new google.maps.LatLng(-6.8725635, 107.5403431),
          draggable:true,
          map: map
        });
                
                              
        marker1.addListener('click', function (event) { 
          document.getElementById("maps_latitude").value = event.latLng.lat(); 
          document.getElementById("maps_longitude").value = event.latLng.lng(); 
                              
          alert( document.getElementById("maps_latitude").value+" ,"+ document.getElementById("maps_longitude").value) 
        });
      }
    });
  </script> -->
</head>
    <body>
        <div id="pageloader">
           <img src="<?php echo base_url(). 'assets/ajax-loader.gif' ?>" alt="Harap Tunggu..." />
        </div>
        <div id="main">
            <div class="container">
                <?php echo $template['partials']['title']; ?>
                <?php echo $template['partials']['navigation']; ?>
                <?php echo $template['body']; ?>
            </div>
            <?php echo $template['partials']['footer']; ?>
        </div>
        <script type='text/javascript' src="<?php echo site_url('assets/select2/select2.min.js'); ?>"></script>
    </body>
</html>