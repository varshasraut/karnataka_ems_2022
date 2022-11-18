<!DOCTYPE html>
<html>
  <head>
    <title>Data Layer: Dynamic Styling</title>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map1 {
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
    <div id="map1"></div>
    <script>
      var map_layer;
       //console.log('e');
      function initMapLayer() {
             // console.log('e');
        map_layer = new google.maps.Map(document.getElementById('map1'), {
          zoom: 9,
          center: {lat: 33.885353001152, lng: 75.40759589555364}
        });

        // Load GeoJSON.
        map_layer.data.loadGeoJson(
            'http://mulikas4/spero_ems_2019/google.json?t=14');

        // Color each letter gray. Change the color when the isColorful property
        // is set to true.
        map_layer.data.setStyle(function(feature) {
            
          var color = feature.getProperty('color');
          var district = '';
          var state = '';

          if (feature.getProperty('setaddress')) {
         
            district = feature.getProperty('district');
            state = feature.getProperty('state');
          }
          return /** @type {!google.maps.Data.StyleOptions} */({
            fillColor: color,
            strokeColor: color,
            strokeWeight: 1
          });
        });

        // When the user clicks, set 'isColorful', changing the color of the letters.
        map_layer.data.addListener('click', function(event) {
            
          //event.feature.setProperty('setaddress', true);
          console.log(event);
          //console.log(event.feature.getGeometry());
          console.log(event.latLng.lat());
          console.log(event.latLng.lng());
        });
        
       

        // When the user hovers, tempt them to click by outlining the letters.
        // Call revertStyle() to remove all overrides. This will use the style rules
        // defined in the function passed to setStyle()
        map_layer.data.addListener('mouseover', function(event) {
            map_layer.data.revertStyle();
            map_layer.data.overrideStyle(event.feature, {strokeWeight: 2});
        });

        map_layer.data.addListener('mouseout', function(event) {
            map_layer.data.revertStyle();
        });
        
        
        
        map_layer.addListener('click', function(event) {
          //console.log(event);
        });
        
        var ll = {
            latLng: new google.maps.LatLng(33.92, 74.79)
        };
        google.maps.event.trigger(map_layer.data, 'click', ll);
        

      }
       //console.log('e');
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBtAZEUryIBFm-pAoQXya4TnjxrwyUIUWI&callback=initMapLayer">
    </script>
  </body>
</html>