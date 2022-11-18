
<?php $amb_data = $amb_data; 
?>
<script type="text/javascript">
var markerins = new Array();
var amblatlong = new Array();
<?php
if (is_array($amb_data)) {
	$ambids =  array();

    foreach ($amb_data as $amb) {
        
        //var_dump($amb);
		$ambid = strtolower(str_replace('-', '', str_replace(' ', '', trim($amb->amb_rto_register_no))));
		$ambids[] = $ambid;
        ?>
            
       amblatlong['<?php echo $ambid?>'] = {title:"<?php echo trim($amb->amb_rto_register_no); ?>", lat:parseFloat(<?php echo $amb->amb_lat; ?>), lng:parseFloat(<?php echo $amb->amb_log; ?>)};
        
    <?php
        
    }
	$ambids = join(",",$ambids);
}
?>
  </script>
  <?php //var_dump($ambids); ?>
<div class="ems_amb_map" style="width: 100%; height: 100%; position:fixed; "  data-inc_lat="<?php echo $inc_data[0]->inc_lat;?>" data-inc_lng="<?php echo $inc_data[0]->inc_long;?>">

    <div id="INC_MAP" class="" style="width: 100%; height: 100%; background: #5A8E4A; " data-ambids="<?php echo $ambids?>">

    </div>

</div>


<script>

   // var mark_pin = base_url + "themes/backend/images/map_pin.png";
    //var mark_pin = base_url + "themes/backend/images/white_bike_icon.png";
   
   // var map_obj,$google_map_obj;
	var post_data = { url: base_url +'amb/gpsapi',type: "POST",  cache: false};
    
    //var $directionsAmb;
   // var $directionsDisplayAmb;

    var mark_pin = new H.map.Icon(base_url + "themes/backend/images/red_map_pin_small.png");
    var green_mark_pin = new H.map.Icon(base_url + "themes/backend/images/select_icon_pin.png");
    var red_mark_pin = new H.map.Icon(base_url + "themes/backend/images/red_map_pin_small.png");
    var red_102_mark_pin = new H.map.Icon(base_url + "themes/backend/images/amb_busy_102.png");
     var green_102_mark_pin = new H.map.Icon(base_url + "themes/backend/images/amb-green_102.png");
    var yellow_mark_pin = new H.map.Icon(base_url + "themes/backend/images/yellow_amb_pin.png");
    var pink_mark_pin = new H.map.Icon(base_url + "themes/backend/images/accident.png");
    
    var map_obj,$google_map_obj;
	var post_data_url = { url: base_url +'amb/gpsapi',type: "POST",  cache: false};
    
    var $directionsAmb;
    var $directionsDisplayAmb;
    var $directionsService;
    var $directionsDisplay;
    var $AllMapUI, $AllMap;
    var $Allgroup =null;
    var $DirectionLine = null;
var $DirectionLineGroup = null;
var $A_Platform;

   function initmarker($google_map_obj){
	   
	       
                ambids = $("#INC_MAP").attr('data-ambids');
			 
                ambids = ambids.split(",");
                inc_lat = $('.ems_amb_map').attr('data-inc_lat');
                inc_lng = $('.ems_amb_map').attr('data-inc_lng');
                $destination = inc_lat+','+inc_lng;

			   for(ambin=0; ambin < ambids.length ; ambin++ ){
                        
//console.log(amblatlong[ambids[ambin]]);

                var markerLatLng = {lat: parseFloat(amblatlong[ambids[ambin]].lat), lng: parseFloat(amblatlong[ambids[ambin]].lng)};
                var markerLatLng2 = {lat: parseFloat(inc_lat), lng: parseFloat(inc_lng)};
                var markerLatLng1 = parseFloat(amblatlong[ambids[ambin]].lat)+','+parseFloat(amblatlong[ambids[ambin]].lng);
                var title = amblatlong[ambids[ambin]]['title'];
                var title1 = "Incident Place";
                addInfoBubble(markerLatLng2, pink_mark_pin, title1);
                addInfoBubble(markerLatLng, mark_pin, title);
                
                 set_amb_direction($google_map_obj,markerLatLng1,$destination);
                 

			   }
   }
               
    function addInfoBubble(markerLatLng, map_mark_pin, html) {
    //console.log(markerLatLng);
    if(markerLatLng == '' || markerLatLng == null){
        return false;
    }
    
   
    $Allgroup = new H.map.Group();
    $AllMap.addObject($Allgroup); 
    var parisMarker = new H.map.Marker(markerLatLng, {icon :map_mark_pin});
   
    parisMarker.addEventListener('pointerenter', function (evt) {
         //console.log(markerLatLng);
         
        // console.log(html);
      var bubble =  new H.ui.InfoBubble(markerLatLng, {
        content: html
      });
      
      $AllMapUI.getBubbles().forEach(bub => $AllMapUI.removeBubble(bub));
      $AllMapUI.addBubble(bubble);
    }, false);
    $Allgroup.addObject(parisMarker);
    
    
    //addMarkersToMap($Allgroup, markerLatLng, map_mark_pin, $AllMap, html);
    

  
  }	   
  function set_amb_direction($google_map_obj,$origin,$destination) {
   // console.log($destination);
    if($DirectionLineGroup != null){
         $AllMap.removeObject($DirectionLineGroup);
         $DirectionLineGroup = null;
    }
    $DirectionLineGroup = new  H.map.Group();
    $AllMap.addObject($DirectionLineGroup);
    var request = {
        'routingMode': 'fast',
        'transportMode': 'car',
        'origin': $origin,
        'destination': $destination,
        'return': 'polyline'
    };
   console.log(request);
    var $directionsService = $A_Platform.getRoutingService(null, 8);
    $directionsService.calculateRoute(request, function(result) {
        
        if (result.routes.length) {
            result.routes[0].sections.forEach((section) => {

                var $linestring = H.geo.LineString.fromFlexiblePolyline(section.polyline);
                
                $DirectionLine = new H.map.Polyline(
                    $linestring, { style: { strokeColor: "#0000FF", lineWidth: 5 }}
                );
                $DirectionLineGroup.addObject($DirectionLine);
                //$AllMap.addObject($DirectionLine);
                $AllMap.getViewModel().setLookAtData({
                    bounds: $DirectionLine.getBoundingBox()
                });
                //$callIncidentMap.getViewModel().setLookAtData({bounds: $DirectionLine.getBoundingBox()});
                
            });
        }
        
    },
    function(error) {
        //alert(error.message);
    });
   
    
}	   

 function resetmarker($google_map_obj,ambregno,lat,long){
     
        inc_lat = $('.ems_amb_map').attr('data-inc_lat');
        inc_lng = $('.ems_amb_map').attr('data-inc_lng');
        
        $destination = inc_lat+','+inc_lng;
    		
	  if(ambregno!=""){
		  
	    if (markerins[ambregno] != null) {
         ///   markerins[ambregno].setMap(null);
        }else{
			return true;
			}
		 
		 var markerLatLng = {lat: parseFloat(lat), lng: parseFloat(long)};
		 markerins[ambregno].setPosition(markerLatLng);
         
          //set_amb_direction($google_map_obj,markerLatLng,$destination);
	  }
	 }

 function loadmap() {
     
          map_obj = document.getElementById('INC_MAP');
          
          inc_lat = $('.ems_amb_map').attr('data-inc_lat');
          inc_lng = $('.ems_amb_map').attr('data-inc_lng');
console.log(inc_lat);
         // var ltlng = {lat: parseFloat(inc_lat), lng: parseFloat(inc_lng)}
          var myLatLng = {lat: parseFloat(inc_lat), lng: parseFloat(inc_lng)};
            $A_Platform = new H.service.Platform({
                apikey: 'yrjPrIYd0xU9KJpe1xlaR1_K1wFrwc9U-_-99n040JQ',
            });
            var defaultLayers = $A_Platform.createDefaultLayers();
            
            $AllMap = new H.Map(document.getElementById('INC_MAP'),
                defaultLayers.vector.normal.map, {
                center: myLatLng,
                zoom: 8,
                pixelRatio: window.devicePixelRatio || 1
            });
            
            var behavior = new H.mapevents.Behavior(new H.mapevents.MapEvents($AllMap));

            $AllMap.tagId = 'ALL_MAP';
            
            window.addEventListener('resize', () => $AllMap.getViewPort().resize());
            $AllMapUI = H.ui.UI.createDefault($AllMap, defaultLayers);

            //$google_map_obj = initMap(ltlng, map_obj);
          
		    setTimeout(function(){
                              initmarker($google_map_obj);
							 },1000);

           
            
    };

    amb_timer = setInterval(function () {

					 //console.log(map);
                 if(map){ 
	              $.ajax(post_data).done(function (result) {
                     // console.log(result);

					   if (result != '') {
			
					   var gpsdata = JSON.parse(result);
			             $.each(gpsdata, function (index, ambdata) {
												   try{

    		
														resetmarker($google_map_obj,ambdata.amb_rto_register_no,ambdata.amb_lat,ambdata.amb_log); 
                                                                                                               
                                           
												   }catch(e){
													   
													   }
														 });
						
			
					   }
			
					});
				 }

    }, 10000);

//Set direction to amb
// function set_amb_direction($google_map_obj,$origin,$destination) {
  
  
//     var $directionsAmb = new google.maps.DirectionsService();
//     var $directionsDisplayAmb = new google.maps.DirectionsRenderer({suppressMarkers: true});
   
//    $directionsDisplayAmb .setMap($google_map_obj);
//      console.log($origin);
//       console.log($destination);
   
//     var request = {
//         origin: $origin,
//         destination: $destination,
//         travelMode: 'DRIVING'
//     };
    
    
//     $directionsAmb.route(request, function(result, status) {
        
//         if (status == 'OK') {
            
//             $directionsDisplayAmb.setDirections(result);
//         }
//     });

// }

 window.onload = function () {
	
	  
			
        loadmap();
		
	
    };

</script>