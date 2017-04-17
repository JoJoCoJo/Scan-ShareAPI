<?php 

  echo uniqid();

 ?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Marker Animations</title>
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
  </head>
  <body>
    <div id="map" style="height: 200px; width: 500px;"></div>
    <script>

      // The following example creates a marker in Stockholm, Sweden using a DROP
      // animation. Clicking on the marker will toggle the animation between a BOUNCE
      // animation and no animation.

      var marker;
      var marker2;

      function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 17,
          center: {lat: 21.0723863, lng: -89.6487123}
        });

        marker = new google.maps.Marker({
          map: map,
          draggable: true,
          animation: google.maps.Animation.DROP,
          position: {lat: 21.0723863, lng: -89.6487123}
        });

        /*marker.addListener('click', toggleBounce);*/
        marker.addListener('dragend',function(event){
          console.log("Longitud: "+event.latLng.lng());
          console.log("Latitud: "+event.latLng.lat());
        });

      }

    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCZJ99x6WrwpmMb4d8S4yC4Ac95F6eATAY&callback&callback=initMap">
    </script>
  </body>
</html>