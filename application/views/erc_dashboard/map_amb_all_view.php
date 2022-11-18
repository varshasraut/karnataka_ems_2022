
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
        ob_start();
        
            
            echo  '<div style="width:300px;"><strong>'.$amb->hp_name.'</strong>'; 
            echo '<br>';
            echo '<strong>RTO No: </strong>'.$amb->amb_rto_register_no; 
            echo '<br>';
            echo '<strong>Ambulance Type: </strong>'.$amb->ambt_name; 
            // echo '<strong>Ambulance Status: </strong>'.show_amb_status_name($amb->amb_status); 
            echo '<br>';
            echo '</div>';
      
        $amb_info = ob_get_contents();
        ob_end_clean();
        ?>
            
       amblatlong['<?php echo $ambid?>'] = {title:"<?php echo trim($amb->amb_rto_register_no); ?>", lat:parseFloat(<?php echo $amb->hp_lat; ?>), lng:parseFloat(<?php echo $amb->hp_long; ?>),info:'<?php echo base64_encode($amb_info);?>',amb_status:"<?php echo $amb->amb_status;?>",amb_type:"<?php echo ($amb->amb_type);?>"};
        
    <?php
        
    }
	$ambids = join(",",$ambids);
}
?>
  </script>
<div class="ems_amb_map" style="width: 100%; height: 100%; position:fixed; "  data-inc_lat="<?php echo $inc_data[0]->inc_lat;?>" data-inc_lng="<?php echo $inc_data[0]->inc_long;?>">

    <div id="INC_MAP" class="" style="width: 100%; height: 100%; background: #5A8E4A; " data-ambids="<?php echo $ambids?>">

    </div>

</div>


<script>
  
    //here map end //
   
      var mark_pin1 = new H.map.Icon(base_url + "themes/backend/images/je_map_pin.png");
      var mark_pin2 = new H.map.Icon(base_url + "themes/backend/images/bls_map_pin.png");
      var mark_pin3 = new H.map.Icon(base_url + "themes/backend/images/als_map_pin.png");
    
    

    
    var map_obj,$google_map_obj;
	var post_data_url = { url: base_url +'amb/gpsapi',type: "POST",  cache: false};
    
    var $directionsAmb;
    var $directionsDisplayAmb;
    var $AllMapUI, $AllMap;
    var $Allgroup =null;

   function initmarker(){
	   
	       
                ambids = $("#INC_MAP").attr('data-ambids');
			 
                ambids = ambids.split(",");
//                inc_lat = $('.ems_amb_map').attr('data-inc_lat');
//                inc_lng = $('.ems_amb_map').attr('data-inc_lng');
//                $destination = inc_lat+','+inc_lng;

			   for(ambin=0; ambin < ambids.length ; ambin++ ){
                if(amblatlong[ambids[ambin]].amb_type == '1'){
                  map_mark_pin = mark_pin1;
                }
                if(amblatlong[ambids[ambin]].amb_type == '2'){
                  map_mark_pin = mark_pin2;
                }
                if(amblatlong[ambids[ambin]].amb_type == '3'){
                  map_mark_pin = mark_pin3;
                }
                
                console.log(amblatlong[ambids[ambin]].amb_type);
                
                //var information = amblatlong[ambids[ambin]].amb_rto_register_no;
              
                var markerLatLng = {lat: parseFloat(amblatlong[ambids[ambin]].lat), lng: parseFloat(amblatlong[ambids[ambin]].lng)};
              addInfoBubble(markerLatLng, map_mark_pin, atob(amblatlong[ambids[ambin]].info));

			   }
               
	   
	   }
 function set_marker_window($maker,$msg){
    
    var infowindow = new google.maps.InfoWindow({
      content: $msg
    });
    
    $infoWindows.push(infowindow);

    $maker.addListener('mouseover', function() {
        
        for (var i=0;i<$infoWindows.length;i++) {
            $infoWindows[i].close();
        }
            
      infowindow.open($maker.get('map'), $maker);
    });
    
}

 function resetmarker($google_map_obj,ambregno,lat,long){
     
        //inc_lat = $('.ems_amb_map').attr('data-inc_lat');
        //inc_lng = $('.ems_amb_map').attr('data-inc_lng');
        
       // $destination = inc_lat+','+inc_lng;
    		
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
    
    function addMarkersToMap($Allgroup, markerLatLng, map_mark_pin, $AllMap, html) {
      // console.log("markerLatLng" + markerLatLng);
        var parisMarker = new H.map.Marker(markerLatLng, {icon :map_mark_pin});
        parisMarker.setData(html);
        
        $Allgroup.addObject(parisMarker);
         
  }
 function loadmap() {
      //var myLatLng = { lat: 34.069838, lng: 76.2291 };
      var myLatLng = {lat: 23.23979546250735, lng: 77.39215854006432};
     $A_Platform = new H.service.Platform({
        apikey: 'yrjPrIYd0xU9KJpe1xlaR1_K1wFrwc9U-_-99n040JQ',
    });
    var defaultLayers = $A_Platform.createDefaultLayers();
    
    $AllMap = new H.Map( document.getElementById('INC_MAP'),
        defaultLayers.vector.normal.map, {
        center: myLatLng,
        zoom: 8,
        pixelRatio: window.devicePixelRatio || 1
    });
    
    var behavior = new H.mapevents.Behavior(new H.mapevents.MapEvents($AllMap));

    $AllMap.tagId = 'ALL_MAP';
    
    window.addEventListener('resize', () => $AllMap.getViewPort().resize());
    $AllMapUI = H.ui.UI.createDefault($AllMap, defaultLayers);
          
		    setTimeout(function(){
                              initmarker();
							 },1000);

    //     M.Map.setCenter({lat:M.Lat, lng:M.Lng});
    //   M.Map.setZoom(M.Zoom);
    addInfoBubble(markerLatLng="", map_mark_pin="", html="");       
            
    };
    

 window.onload = function () {

			
         initmarker();

    };
 loadmap();
</script>