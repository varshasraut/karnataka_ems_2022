
<?php $pcmc_amb_data = $pcmc_amb_data; 
?>
<!--<link rel="stylesheet" type="text/css" href="{css_path}/style.css">-->
<!-- <div class="container-fluid"> -->
    <div>
<div class="row">
<div>Ambulance live Tracking</div>
</div>

<div class="row">
<div class="col-md-2">Select Ambulance : </div>
<div class="col-md-3">
<input name="amb_reg_id"  id="amb_id" class="mi_autocomplete dropdown_per_page width97" data-href="{base_url}auto/get_ambulance" placeholder="Select Ambulance" data-errors="{filter_required:'Please select state from dropdown list'}" tabindex="2" autocomplete="off" value="" data-value="" data-callback-funct="single_ambulance_load">
</div>

</div>
<br>
<!-- </div> -->
<script type="text/javascript">
var markerins_pcmc = new Array();
var amblatlong_pcmc = new Array();
<?php
if (is_array($pcmc_amb_data)) {
	$ambids =  array();

    foreach ($pcmc_amb_data as $amb) {
        
        //var_dump($amb);
		$ambid_pcmc = strtolower(str_replace('-', '', str_replace(' ', '', trim($amb->amb_rto_register_no))));
		$ambids_pcmc[] = $ambid_pcmc;
        ob_start();
        
        if($amb->amb_status == 2 ){
             
            echo '<div style="width:500px;"><strong>'.$amb->hp_name.'</strong>'; 
            echo  '<br>';
            echo '<strong>Ambulance No: </strong>'.$amb->amb_rto_register_no; 
            echo '<br>';
            echo '<strong>Destination Hospital : </strong>'.$amb->destination_hos; 
            echo '<br>';
            echo '<strong>Ambulance Status: </strong>'.show_amb_status_name($amb->amb_status); 
            echo '<br>';
            if($amb->inc_complaint != '' && $amb->inc_complaint != 0){
                echo  '<strong>Chief Complaint: </strong>'. get_cheif_complaint($amb->inc_complaint); 
                echo '<br>';
            }
            if($amb->inc_complaint_other != ''){
                echo  '<strong>Chief Complaint Other: </strong>'. $amb->inc_complaint_other; 
                echo '<br>';
            }
            if($amb->inc_mci_nature != '' && $amb->inc_mci_nature != 0){
                echo  '<strong>Mci Nature: </strong>'. get_mci_nature_service($amb->inc_mci_nature); 
                echo '<br>';
            }
            echo  '<strong>Incident ID: </strong>'. $amb->inc_ref_id; 
            echo '<br>';
            echo  '<strong>Patient Name: </strong>'. $amb->ptn_fullname; 
            echo '<br>';
            echo  '<strong>Gender: </strong>'.get_gen($amb->ptn_gender); 
            echo '<br>';
            echo  '<strong>Age: </strong>'.$amb->ptn_age; 
            echo '<br>';
           echo '<strong>Pilot Mobile No: </strong><a class="click-xhttp-request" style="color:#000;" data-href="{base_url}avaya_api/soft_dial" data-qr="output_position=content&mobile_no=0'.$amb->amb_pilot_mobile.'">'.$amb->amb_pilot_mobile.'</a>';
            echo '<br>';
            echo '<strong>Dr Mobile No: </strong><a class="click-xhttp-request" style="color:#000;" data-href="{base_url}avaya_api/soft_dial" data-qr="output_position=content&mobile_no=0'.$amb->amb_default_mobile.'">'.$amb->amb_default_mobile.'</a>';
            echo '</div>';
          }else{ 
            
            echo  '<div style="width:500px;"><strong>'.$amb->hp_name.'</strong>'; 
            echo '<br>';
            echo '<strong>RTO No: </strong>'.$amb->amb_rto_register_no; 
            echo '<br>';
            echo '<strong>Ambulance Status: </strong>'.show_amb_status_name($amb->amb_status); 
            echo '</div>';
        } 
        $amb_info = ob_get_contents();
        ob_end_clean();
        ?>
            
       amblatlong_pcmc['<?php echo $ambid_pcmc; ?>'] = {title:"<?php echo trim($amb->amb_rto_register_no); ?>", lat:parseFloat(<?php echo $amb->amb_lat; ?>), lng:parseFloat(<?php echo $amb->amb_log; ?>),info:'<?php echo base64_encode($amb_info);?>',amb_status:"<?php echo $amb->amb_status;?>",amb_type:"<?php echo ($amb->amb_type);?>",thirdparty:"<?php echo ($amb->thirdparty);?>"};
        
    <?php
        
    }
	$ambids_pcmc = join(",",$ambids_pcmc);
}
?>
  </script>

    <div class="row">
        <div class="col-md-12"> 
         <div class="ems_amb_map" style="width: 100%; height: 100%; position:absolute;left: 0%; "  data-inc_lat="<?php echo $inc_data[0]->inc_lat;?>" data-inc_lng="<?php echo $inc_data[0]->inc_long;?>"> 

            <div id="PCMC_INC_MAP" class="" style="width: 100%; height: 400px; background: #5A8E4A; position:absolute; left: 0%; " data-ambids-pcmc="<?php echo $ambids_pcmc?>">

            </div>

        </div>
         </div>
    </div> 

</div>
<script>
    //here map end //
    var mark_pin = new H.map.Icon(base_url + "themes/backend/images/white_map_amb.png");
    var green_mark_pin = new H.map.Icon(base_url + "themes/backend/images/select_icon_pin.png");
    var red_mark_pin = new H.map.Icon(base_url + "themes/backend/images/red_map_pin_small.png");
    var red_102_mark_pin = new H.map.Icon(base_url + "themes/backend/images/red_map_pin_small.png");
     var green_102_mark_pin = new H.map.Icon(base_url + "themes/backend/images/select_icon_pin.png");
    var yellow_mark_pin = new H.map.Icon(base_url + "themes/backend/images/yellow_amb_pin.png");
    var pink_mark_pin = new H.map.Icon(base_url + "themes/backend/images/ambulance-icon-dark-pink.png");
    
    var map_obj_pcmc,$google_map_obj_pcmc;
	var post_data_url = { url: base_url +'amb/gpsapi',type: "POST",  cache: false};
    
    var $directionsAmb;
    var $directionsDisplayAmb;
    var $AllMapUIPCMC, $AllMapPCMC;
    var $AllgroupPCMC =null;

   function initmarker1(){
	   
	       
                ambids = $("#PCMC_INC_MAP").attr('data-ambids-pcmc');
			 
                ambids = ambids.split(",");
                console.log(ambids);
//                inc_lat = $('.ems_amb_map').attr('data-inc_lat');
//                inc_lng = $('.ems_amb_map').attr('data-inc_lng');
//                $destination = inc_lat+','+inc_lng;

			   for(ambin=0; ambin < ambids.length ; ambin++ ){

                map_mark_pin = mark_pin;
                //console.log(amblatlong_pcmc[ambids[ambin]]);
                if(parseFloat(amblatlong_pcmc[ambids[ambin]].thirdparty) == '2' || parseFloat(amblatlong_pcmc[ambids[ambin]].thirdparty) == 2){
                    if(parseFloat(amblatlong_pcmc[ambids[ambin]].amb_status) == '2' || parseFloat(amblatlong_pcmc[ambids[ambin]].amb_status) == 2){

                    map_mark_pin = red_102_mark_pin;
                    }else if(parseFloat(amblatlong_pcmc[ambids[ambin]].amb_status) == '6' || parseFloat(amblatlong_pcmc[ambids[ambin]].amb_status) == 6){

                    map_mark_pin = pink_mark_pin;
                    }else if(parseFloat(amblatlong_pcmc[ambids[ambin]].amb_status) == '1' || parseFloat(amblatlong_pcmc[ambids[ambin]].amb_status) == 1){

                    map_mark_pin = green_102_mark_pin;
                    }else{
                    map_mark_pin = pink_mark_pin;
                    }
              /*  if(parseFloat(amblatlong[ambids[ambin]].amb_type) == '2' || parseFloat(amblatlong[ambids[ambin]].amb_type) == 2){
                    if(parseFloat(amblatlong[ambids[ambin]].amb_status) == '2' || parseFloat(amblatlong[ambids[ambin]].amb_status) == 2){

                        map_mark_pin = red_102_mark_pin;
                    }else if(parseFloat(amblatlong[ambids[ambin]].amb_status) == '6' || parseFloat(amblatlong[ambids[ambin]].amb_status) == 6){

                        map_mark_pin = pink_mark_pin;
                    }else if(parseFloat(amblatlong[ambids[ambin]].amb_status) == '1' || parseFloat(amblatlong[ambids[ambin]].amb_status) == 1){

                        map_mark_pin = green_102_mark_pin;
                    }else{
                         map_mark_pin = pink_mark_pin;
                    }
                }else{*/ }else{
               // console.log("hi");
                
                    if(parseFloat(amblatlong_pcmc[ambids[ambin]].amb_status) == '2' || parseFloat(amblatlong_pcmc[ambids[ambin]].amb_status) == 2){

                        map_mark_pin = red_mark_pin;
                    }else if(parseFloat(amblatlong_pcmc[ambids[ambin]].amb_status) == '6' || parseFloat(amblatlong_pcmc[ambids[ambin]].amb_status) == 6){

                        map_mark_pin = pink_mark_pin;
                    }else if(parseFloat(amblatlong_pcmc[ambids[ambin]].amb_status) == '1' || parseFloat(amblatlongv[ambids[ambin]].amb_status) == 1){

                        map_mark_pin = green_mark_pin;
                    }else{
                         map_mark_pin = pink_mark_pin;
                    }

                }
                //var information = amblatlong[ambids[ambin]].amb_rto_register_no;
              
                var markerLatLng = {lat: parseFloat(amblatlong_pcmc[ambids[ambin]].lat), lng: parseFloat(amblatlong_pcmc[ambids[ambin]].lng)};
               //console.log(markerLatLng);
              //  console.log({lat: parseFloat(amblatlong[ambids[ambin]].lat), lng: parseFloat(amblatlong[ambids[ambin]].lng)});
              //addMarkersToMap(markerLatLng, map_mark_pin, $AllMap, atob(amblatlong[ambids[ambin]].info));
              addInfoBubble1(markerLatLng, map_mark_pin, atob(amblatlong_pcmc[ambids[ambin]].info));
                //var title = amblatlong[ambids[ambin]]['title'];

                //  markerins[ambids[ambin]] = new google.maps.Marker({
				// 								position: markerLatLng,
				// 								map: $google_map_obj,
				// 								icon: map_mark_pin,
				// 								title: title
				// 							});

                // set_amb_direction($google_map_obj,markerLatLng,$destination);
                // set_marker_window(markerins[ambids[ambin]],atob(amblatlong[ambids[ambin]].info));
 //console.log("info" + );
			   }
               
	   
	   }
 function set_marker_window1($maker,$msg){
    
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

 function resetmarker1($google_map_obj,ambregno,lat,long){
     
        //inc_lat = $('.ems_amb_map').attr('data-inc_lat');
        //inc_lng = $('.ems_amb_map').attr('data-inc_lng');
        
       // $destination = inc_lat+','+inc_lng;
    		
	  if(ambregno!=""){
		  
	    if (markerins_pcmc[ambregno] != null) {
         ///   markerins[ambregno].setMap(null);
        }else{
			return true;
			}
		 
		 var markerLatLng = {lat: parseFloat(lat), lng: parseFloat(long)};
		 markerins_pcmc[ambregno].setPosition(markerLatLng);
         
          //set_amb_direction($google_map_obj,markerLatLng,$destination);
	  }
	 }
function addInfoBubble1(markerLatLng, map_mark_pin, html) {
    //console.log(markerLatLng);
    if(markerLatLng == '' || markerLatLng == null){
        return false;
    }
    
    $AllgroupPCMC = new H.map.Group();
    $AllMapPCMC.addObject($AllgroupPCMC); 
    
    var parisMarker = new H.map.Marker(markerLatLng, {icon :map_mark_pin});
   
    parisMarker.addEventListener('pointerenter', function (evt) {
         //console.log(markerLatLng);
         
        // console.log(html);
      var bubble =  new H.ui.InfoBubble(markerLatLng, {
        content: html
      });
      
      $AllMapUIPCMC.getBubbles().forEach(bub => $AllMapUIPCMC.removeBubble(bub));
      $AllMapUIPCMC.addBubble(bubble);
    }, false);
    $AllgroupPCMC.addObject(parisMarker);
    $AllMapPCMC.getViewModel().setLookAtData({
           // bounds: $Allgroup.getBoundingBox()
    });
    
    
    //addMarkersToMap($Allgroup, markerLatLng, map_mark_pin, $AllMap, html);
    

  
  }
    
    function addMarkersToMap1($AllgroupPCMC, markerLatLng, map_mark_pin, $AllMapPCMC, html) {
      // console.log("markerLatLng" + markerLatLng);
        var parisMarker = new H.map.Marker(markerLatLng, {icon :map_mark_pin});
        parisMarker.setData(html);
        
        $AllgroupPCMC.addObject(parisMarker);
        $AllMapPCMC.getViewModel().setLookAtData({
            bounds: $AllgroupPCMC.getBoundingBox()
        });
         
  }
 function loadmap1() {
     // var myLatLng = { lat: 19.559419, lng: 75.410006 };
      var myLatLng = {lat: 23.23979546250735, lng: 77.39215854006432};
     $A_Platform = new H.service.Platform({
        apikey: 'yrjPrIYd0xU9KJpe1xlaR1_K1wFrwc9U-_-99n040JQ',
    });
    var defaultLayers = $A_Platform.createDefaultLayers();
    
    $AllMapPCMC = new H.Map( document.getElementById('PCMC_INC_MAP'),
        defaultLayers.vector.normal.map, {
        center: myLatLng,
        zoom: 7,
        pixelRatio: window.devicePixelRatio || 1
    });
    
    var behavior = new H.mapevents.Behavior(new H.mapevents.MapEvents($AllMapPCMC));

    $AllMapPCMC.tagId = 'ALL_MAP';
    
    window.addEventListener('resize', () => $AllMapPCMC.getViewPort().resize());
    $AllMapUIPCMC = H.ui.UI.createDefault($AllMapPCMC, defaultLayers);
          
		    setTimeout(function(){
                              initmarker1();
							 },1000);

    //     M.Map.setCenter({lat:M.Lat, lng:M.Lng});
    //   M.Map.setZoom(M.Zoom);
    addInfoBubble1(markerLatLng="", map_mark_pin="", html="");       
            
    };
    
    
if(typeof H != 'undefined'){
    amb_timer = setInterval(function () {

					
                 if(map_obj_pcmc){ 
	              $.ajax(post_data_url).done(function (result) {

					   if (result != '') {
			
					   var gpsdata = JSON.parse(result);
			             $.each(gpsdata, function (index, ambdata) {
												   try{

    		
														resetmarker1($google_map_obj_pcmc,ambdata.amb_rto_register_no,ambdata.amb_lat,ambdata.amb_log); 
                                                                                                               
                                           
												   }catch(e){
													   
													   }
														 });
						
			
					   }
			
					});
				 }

    }, 10000);
}
//Set direction to amb
function set_amb_direction1($google_map_obj_pcmc,$origin,$destination) {
  
  
    var $directionsAmb = new google.maps.DirectionsService();
    var $directionsDisplayAmb = new google.maps.DirectionsRenderer({suppressMarkers: true});
   
   $directionsDisplayAmb.setMap($google_map_obj_pcmc);
     //console.log($origin);
     // console.log($destination);
   
    var request = {
        origin: $origin,
        destination: $destination,
        travelMode: 'DRIVING'
    };
    
    
    $directionsAmb.route(request, function(result, status) {
        
        if (status == 'OK') {
            
            $directionsDisplayAmb.setDirections(result);
        }
    });

}

 window.onload = function () {
     
	
	  //console.log(hi);
			
         initmarker1();
        
		//addMarkersToMap();
        
	
    };
 loadmap1();
</script>
<style>
      .H_ib_top{
        background: #fff;
        padding: 5px;
        position: relative;
        width: 300px;
    }
    .H_ib_close{
        width: 10px;
        position: absolute;
        right: 3px;
        top:3px;
    }
    .H_ui{
        background: #fff;
        font-size: 12px;
    }
</style>