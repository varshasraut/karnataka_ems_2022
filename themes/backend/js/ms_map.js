var geocoder,$M_Platform,$AddressMapUI;

var $AddressMap;

var marker;

var change_drag = 0;


 var $Pins = base_url+'themes/backend/images/patient_map.png';

 

function initialize_dir_map(from, to, map_obj,base_url ) {
	
    //directionsDisplay = new google.maps.DirectionsRenderer();
	directionsDisplay = new google.maps.DirectionsRenderer({
		draggable: true,
		map: map,
        suppressMarkers: true
	});
	
    var start = new google.maps.LatLng(from.lat, from.lng);
    var end = new google.maps.LatLng(to.lat, to.lng);	
	
    var map = new google.maps.Map( map_obj, {
        center: {lat: from.lat, lng: from.lng},
        zoom: 11,
        scrollwheel: false
    });
	
	
	
    directionsDisplay.setMap(map);
    var request = {
        origin:start,
        destination:end,
		travelMode: google.maps.TravelMode.DRIVING
    };
	
	
    
    
    directionsService.route(request, function(result, status) {
        
        if (status == google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(result);

            makeMarker( map, start,base_url+'themes/glass/images/user_loc.png', "Your locatuion" );
            makeMarker( map, end,base_url+'themes/glass/images/store_loc.png',"Store Location" );
            
        }
    });
    
    
    

}
  
 function makeMarker(map, position, icon, title ) {
     
     
 new google.maps.Marker({
  position: position,
  map: map,
  icon: icon,
  title: title
 });
 
} 
      
function initMap(ltlng, map_obj) {
    
//    var map;
//    
//
//    try{  
//        map = new google.maps.Map(map_obj, {
//            center: ltlng,
//            zoom: 11,
//            mapTypeId: google.maps.MapTypeId.ROADMAP
//        });
//		
//        addMarker(ltlng, map);
//        
//        
//    }catch(er){}
//    return map;
    
    $M_Platform = new H.service.Platform({
        apikey: 'yrjPrIYd0xU9KJpe1xlaR1_K1wFrwc9U-_-99n040JQ',
    });
    var defaultLayers = $M_Platform.createDefaultLayers();
    
    $AddressMap = new H.Map( map_obj,
        defaultLayers.vector.normal.map, {
        center: ltlng,
        zoom: 8,
        pixelRatio: window.devicePixelRatio || 1
    });
    
    var behavior = new H.mapevents.Behavior(new H.mapevents.MapEvents($AddressMap));

    
    window.addEventListener('resize', () => $AddressMap.getViewPort().resize());
    $AddressMapUI = H.ui.UI.createDefault($AddressMap, defaultLayers);
}
var $ALLMapUI,$ALLMap,$ALLMapBehavior;
function initAllMap(ltlng, map_obj) {
    
     var myLatLng = {lat: 33.172502, lng: 76.810170};

    // Create a map object and specify the DOM element for display.
//    $callIncidentMap = new google.maps.Map(document.getElementById('INCIDENT_MAP'), {
//      center: myLatLng,
//      zoom: 7
//    });
    Platform = new H.service.Platform({
        apikey: 'yrjPrIYd0xU9KJpe1xlaR1_K1wFrwc9U-_-99n040JQ',
    });
    var defaultLayers = Platform.createDefaultLayers();
    
    $ALLMap = new H.Map( document.getElementById('INC_MAP'),
        defaultLayers.vector.normal.map, {
        center: myLatLng,
        zoom: 8,
        pixelRatio: window.devicePixelRatio || 1
    });
    
    $ALLMapBehavior = new H.mapevents.Behavior(new H.mapevents.MapEvents($ALLMap));

    $ALLMap.tagId = 'INC_MAP';
    
    window.addEventListener('resize', () => $ALLMap.getViewPort().resize());
    $ALLMapUI = H.ui.UI.createDefault($ALLMap, defaultLayers);
}
function addMarker(ltlng, map) {


    marker = new google.maps.Marker({
        position: ltlng,
        map: map,
        title: 'Click to zoom',
        draggable:true,
       icon: $Pins
    });

     
	marker.addListener('drag',function(event) { 
        if(jQuery('#lttd').length && jQuery('#lgtd').length){
            jQuery('#lttd').val(event.latLng.lat());
            jQuery('#lgtd').val(event.latLng.lng());
        } 
       
    });

    marker.addListener('dragend',function(event) { 
        if(jQuery('#lttd').length && jQuery('#lgtd').length){
            jQuery('#lttd').val(event.latLng.lat());
            jQuery('#lgtd').val(event.latLng.lng());
			jQuery('#drag').val(event.latLng.lng());
        }
        
       
        
    });
}
    

  

function codeAddress(address) {
    
    console.log(address);
    geocoder = new google.maps.Geocoder();
    geocoder.geocode( { 'address': address,'region':'IN'}, function(results, status) {
    
        if (status == google.maps.GeocoderStatus.OK) {
            map.setCenter(results[0].geometry.location);
            marker.setPosition(results[0].geometry.location);
            
             if(jQuery('#lttd').length && jQuery('#lgtd').length){
            document.getElementById('lttd').value = results[0].geometry.location.lat();
            document.getElementById('lgtd').value = results[0].geometry.location.lng();
			}
        } 
   });
}
 
 
function get_map_address(address_info){
    var address_info = address_info; 
    if(address_info){
        var address = address_info.value;
        codeAddress(address);
    }
}
 
 
$(document).ready(function(){

    $('body').on("change","select.map_canvas",function(){
	
        var address = '';
        $city = $("select.map_canvas option:selected").text();
        $state = $("select#hp_state option:selected").text();
        $district = $("select#hp_dis option:selected").text();
        address = $city+', '+$district+', '+$state;
        
        
        if($("#drag").hasClass('map_drag_edit'))
        {
            $("#drag").val('');
        }       
      
        
        codeAddress(address);
    }); 
    
        $('body').on("blur","input.map_canvas",function(){
	
            var address = $(this).val();

            codeAddress(address);
        }); 
        
});
 
 
 
