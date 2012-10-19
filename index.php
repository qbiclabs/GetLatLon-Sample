<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Google Maps JavaScript API v3 Example: Geocoding Simple</title>
    <link href="default.css" rel="stylesheet">
    <script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script>
      var geocoder;
      var map;
      var markersArray = [];
      
      function initialize() {
        geocoder = new google.maps.Geocoder();
        var latlng = new google.maps.LatLng(41.0766755, 1.14449860000002);
        var mapOptions = {
          zoom: 15,
          center: latlng,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);
      }

function clearOverlays() {      
    if (markersArray) {      
        for (i in markersArray) {  
            google.maps.event.clearListeners(map, markersArray[i]);   
            markersArray[i].setMap(null);    
        }  
    }   
}

      function codeAddress() {
        var address = document.getElementById('address').value;
        var currentLatLng;
       
        
        geocoder.geocode( { 'address': address}, function(results, status) {
          if (status == google.maps.GeocoderStatus.OK) {
          
            clearOverlays();
          
            map.setCenter(results[0].geometry.location);
            
            if (marker!==undefined){
            	marker.setMap(null);
            }
            var marker = new google.maps.Marker({
                map: map,
                title: 'Marker',
                draggable: true,
                animation: google.maps.Animation.DROP,
                position: results[0].geometry.location
            });
            
            currentLatLng=marker.getPosition();
            
            $("#mylatlon").replaceWith('<p id="mylatlon">Latitude: '+currentLatLng.lat()+'<br/>Longitude: '+currentLatLng.lng()+'</p>');
           
           markersArray.push(marker);
            google.maps.event.addListener(marker, 'drag', function() {
          	$("#mylatlon").replaceWith('<p id="mylatlon">Latitude: '+marker.getPosition().lat()+'<br/>Longitude: '+marker.getPosition().lng()+'</p>');
            });
          } else {
            alert('Geocode was not successful for the following reason: ' + status);
          }
        });
      }
    </script>
  </head>
  <body onload="initialize()">
    <div style="text-align:center;">
      <h3>Get Latitude and Longitude</h3>
      <input id="address" type="textbox" value="">
      <input type="button" value="Geocode" onclick="codeAddress()">
      <p id="mylatlon">Latitude: 0<br/>Longitude: 0</p>
      <p>Free service by <a href="http://qbiclabs.com">QbicLabs.com</a></p>
    </div>
    <div id="map_canvas" style="height:90%;top:30px"></div>
  </body>
</html>