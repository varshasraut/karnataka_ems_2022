<script type="text/javascript">
var markerins = new Array();
var amblatlong = new Array();
<?php
if (is_array($amb_data)) {
	$ambids =  array();
	
    foreach ($amb_data as $amb) {
		$ambid = strtolower(str_replace('-', '', str_replace(' ', '', trim($amb->amb_rto_register_no))));
		$ambids[] = $ambid;
        ?>
            
       amblatlong['<? echo $ambid?>'] = {title:"<?php echo $amb->amb_rto_register_no; ?>", lat:parseFloat(<?php echo $amb->amb_lat; ?>), lng:parseFloat(<?php echo $amb->amb_log; ?>)};
        
    <?php
    }
	$ambids = join(",",$ambids);
}
?>
  </script>
<div class="ems_amb_map" style="width: 100%; height: 100%; position:fixed; " >

    <div id="INC_MAP" class="" style="width: 100%; height: 100%; background: #5A8E4A; " data-ambids="<?php echo $ambids?>" data-inc_lat="<?php echo $data_lat;?>" data-inc_lng="<?php echo $data_lan;?>">

    </div>

</div>


<script>

    var mark_pin = base_url + "themes/backend/images/map_pin.png";
   
    var map_obj;
	var post_data = { url: base_url +'amb/gpsapi',type: "POST",  cache: false};
    
    var directionsStart,directionsEnd,directionCount=0 ,directionsDisplay,directionsService;

   function initmarker(){
	   
                
    
               ambids = $("#INC_MAP").attr('data-ambids');
			 
			   ambids = ambids.split(",");
               
               directionsDisplay.setMap(map);
			////   alert(ambids.length);
			   for(ambin=0; ambin < ambids.length ; ambin++ ){
				  /// alert(ambids[ambin]);
				///   alert(ambids[ambin]+"=="+amblatlong[ambids[ambin]].lat);

                var markerLatLng = {lat: parseFloat(amblatlong[ambids[ambin]].lat), lng: parseFloat(amblatlong[ambids[ambin]].lng)};


                var title = amblatlong[ambids[ambin]]['title'];

                 markerins[ambids[ambin]] = new google.maps.Marker({
												position: markerLatLng,
												map: map,
												icon: mark_pin,
												title: title
											});
				/// alert(markerLatLng);

			   }
               


               
	   
	   }

 function resetmarker(ambregno,lat,long){
     
                
	  if(ambregno!=""){
		  
	    if (markerins[ambregno] != null) {
         ///   markerins[ambregno].setMap(null);
        }else{
			return true;
			}
		 
		 var markerLatLng = {lat: parseFloat(lat), lng: parseFloat(long)};
         
                         
                directionsEnd = markerLatLng;
		 markerins[ambregno].setPosition(markerLatLng);
	  }
      
      
        if(directionCount==0){
            var request = {
              origin: directionsStart,
              destination: directionsEnd,
              travelMode: 'DRIVING',
              
            };
            directionsService.route(request, function(result, status) {
              if (status == 'OK') {
                directionsDisplay.setDirections(result);
              }
            });
            directionCount++;
        }
      
	 }

 function loadmap() {
     
        directionsService = new google.maps.DirectionsService();
        directionsDisplay = new google.maps.DirectionsRenderer({ suppressMarkers: true });
     
          map_obj = document.getElementById('INC_MAP');
          var inc_lat = $("#INC_MAP").attr('data-inc_lat');
          var inc_lng = $("#INC_MAP").attr('data-inc_lng');

          //var ltlng = {lat: 18.51545, lng: 73.8696923};
          var ltlng = {lat: parseFloat(inc_lat), lng: parseFloat(inc_lng)}
          directionsStart = {lat: parseFloat(inc_lat), lng: parseFloat(inc_lng)};;

          initMap(ltlng, map_obj);
		   setTimeout(function(){
                              initmarker();
							 },1000);
    };


    timer = setInterval(function () {
    		
					
                 if(map){ 
	              $.ajax(post_data).done(function (result) {

					   if (result != '') {
			
					   var gpsdata = JSON.parse(result);
			             $.each(gpsdata, function (index, ambdata) {
												   try{
														resetmarker(ambdata.amb_rto_register_no,ambdata.amb_lat,ambdata.amb_log); 
												   }catch(e){
													   
													   }
														 });
						
			
					   }
			
					});
				 }

    }, 10000);


 window.onload = function () {	
        loadmap();

    };
</script>