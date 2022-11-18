/*---------- MI13 ------------*/

var $placeSearch, $autocomplete, $callIncidentMap;
var $ambMapMarkers = {};
var $infoWindows = [];
var $incGeocoder, $incMapMarker,$incGeoFence;

var $isExtendedMapOpened = 0;
var $ExtendMapWindow; //popup window

//var map_pin_image_hover = base_url+'themes/backend/images/select_bike_icon.png';
//var stand_map_pin_image_hover = base_url+'themes/backend/images/select_bike_icon.png';
// var map_pin_image = base_url+'themes/backend/images/select_icon_pin.png';

var map_pin_image_hover = base_url+'themes/backend/images/select_bike_icon.png';
var stand_map_pin_image_hover = base_url+'themes/backend/images/select_bike_icon.png';
var map_pin_image = base_url+'themes/backend/images/select_icon_pin.png';
var map_102_pin_image = base_url+'themes/backend/images/amb-green_102.png';
var stand_map_pin_image = base_url+'themes/backend/images/select_icon_pin.png';

var $directionsService;
var $directionsDisplay;

//var $MapPins = {
//    1:base_url+'themes/backend/images/map_pin.png',
//    2: base_url+'themes/backend/images/yellow_amb_pin.png',
// //   3: base_url+'themes/backend/images/yellow_amb_pin.png',
//    6:base_url+'themes/backend/images/orange_map_pin.png'
//};
//var $MapPins = {
//    1:base_url+'themes/backend/images/select_bike_icon.png',
//    2: base_url+'themes/backend/images/red_bike_icon.png',
// //   3: base_url+'themes/backend/images/yellow_amb_pin.png',
//    6:base_url+'themes/backend/images/yellow_bike_icon.png',
//    7:base_url+'themes/backend/images/blue_bike_icon.png'
//};
var $MapPins = {
    11:base_url+'themes/backend/images/select_bike_icon.png',
    12:base_url+'themes/backend/images/red_bike_icon.png',
    16:base_url+'themes/backend/images/yellow_bike_icon.png',
    17:base_url+'themes/backend/images/blue_bike_icon.png',
    41:base_url+'themes/backend/images/select_icon_pin.png',
    42:base_url+'themes/backend/images/red_map_pin.png',
    46:base_url+'themes/backend/images/yellow_amb_pin.png',
    47:base_url+'themes/backend/images/blue_map_pin.png',
    31:base_url+'themes/backend/images/select_icon_pin.png',
    32:base_url+'themes/backend/images/red_map_pin.png',
    36:base_url+'themes/backend/images/yellow_amb_pin.png',
    37:base_url+'themes/backend/images/blue_map_pin.png',
    21:base_url+'themes/backend/images/amb-green_102.png',
    22:base_url+'themes/backend/images/amb_busy_102.png',
    26:base_url+'themes/backend/images/yellow_amb_pin.png',
    27:base_url+'themes/backend/images/blue_map_pin.png',
    1:base_url+'themes/backend/images/select_icon_pin.png',
    2:base_url+'themes/backend/images/red_map_pin.png',
    6:base_url+'themes/backend/images/yellow_amb_pin.png',
    7:base_url+'themes/backend/images/blue_map_pin.png',
};


function initIncidentMap() {

     //var myLatLng = {lat: 33.172502, lng: 76.810170};
     var myLatLng = {lat: 23.23979546250735, lng: 77.39215854006432};
    // Create a map object and specify the DOM element for display.
    $callIncidentMap = new google.maps.Map(document.getElementById('INCIDENT_MAP'), {
      center: myLatLng,
      zoom: 7
    });
    
    $callIncidentMap.tagId = 'INCIDENT_MAP';
    
    $directionsService = new google.maps.DirectionsService();
    $directionsDisplay = new google.maps.DirectionsRenderer({suppressMarkers: true});
    

    var input = document.getElementById('inc_map_address');
    var options = {
     types: ['geocode'],
//      componentRestrictions: {country: 'in'}
    };
    
//    $callIncidentMap.data.loadGeoJson(base_url+'/google.json?t=14');
//    
//    $callIncidentMap.data.setStyle(function(feature) {
//            
//          var color = feature.getProperty('color');
//          
//          return /** @type {!google.maps.Data.StyleOptions} */({
//            fillColor: color,
//            strokeColor: color,
//            strokeWeight: 1
//          });
//    });


    $autocomplete  = new google.maps.places.SearchBox(input, options);
    $autocomplete.addListener('places_changed', auto_complete_place_changed);
    $incGeoFence = new google.maps.Circle({});
    
    
    $callIncidentMap.data.addListener('click', function(event) {
            
          //event.feature.setProperty('setaddress', true);
          district = event.feature.getProperty('district');
          state = event.feature.getProperty('state');
          var $place_details = {'state':state,'district':district,'latlng':event.latLng}
           set_inc_main_pin($place_details);
           set_inc_add_details($place_details);
   });
        
    
//     var trafficLayer = new google.maps.TrafficLayer();
//     trafficLayer.setMap($callIncidentMap);
    
}


function auto_complete_place_changed(){
    
    var places = $autocomplete.getPlaces();
    if (places.length > 0) {
        set_inc_main_pin(places[0]);
        set_inc_add_details(places[0]);
    }
    
}


function ext_auto_complete_place_changed(){
    
    var places = $ExtendMapWindow.$ext_autocomplete.getPlaces();
    if (places.length > 0) {
        set_inc_main_pin(places[0]);
        set_inc_add_details(places[0]);
    }
    
}


function load_inc_address() {
    $incGeocoder = new google.maps.Geocoder();
    var address = document.getElementById('inc_map_address').value;
    $incGeocoder.geocode( { 'address': address}, function(results, status) {
        if (status == 'OK') {
            set_inc_main_pin(results[0]);
        }
    });
}
function on_cluster_change_load_map($this){
    $incGeocoder = new google.maps.Geocoder();
    
    var cluster_lat = $($this).find(':selected').attr('data-lat');
    var cluster_lng = $($this).find(':selected').attr('data-lng');
    var address = cluster_lat+','+cluster_lng;
    console.log(address);
    $incGeocoder.geocode( { 'address': address}, function(results, status) {
        if (status == 'OK') {
            console.log(results[0]);
            set_inc_main_pin(results[0]);
            set_inc_add_details(results[0]);
        }
    });
}
function set_inc_main_pin(place){
    
    if(typeof $incMapMarker != "undefined"){
        $incMapMarker.setMap(null);
    }

//    var p_lat = place.geometry.location.lat();
//    var p_lng = place.geometry.location.lng();
    if(place.latlng){
        var p_lat = place.latlng.lat();
        var p_lng = place.latlng.lng();
    }else{
        var p_lat = place.geometry.location.lat();
        var p_lng = place.geometry.location.lng();
    }
    
    $callIncidentMap.setCenter({lat: p_lat, lng: p_lng});
    $callIncidentMap.setZoom(10);

    $incMapMarker = new google.maps.Marker({
        position: {lat: p_lat, lng: p_lng},
        map: $callIncidentMap,
        draggable: true
    });

    $incMapMarker.addListener('dragend',function(event) {
        inc_marker_dragged(this);
    });
    
    
    if($isExtendedMapOpened){
        
        if(typeof $ExtendMapWindow.$incExtMapMarker != "undefined"){
            $ExtendMapWindow.$incExtMapMarker.setMap(null);
        }
        
        $ExtendMapWindow.$ExtendMap.setCenter({lat: p_lat, lng: p_lng});
        
        $ExtendMapWindow.$incExtMapMarker = new $ExtendMapWindow.google.maps.Marker({
            position: {lat: p_lat, lng: p_lng},
            map: $ExtendMapWindow.$ExtendMap,
            draggable: true
        });

        $ExtendMapWindow.$incExtMapMarker.addListener('dragend',function(event) {
            inc_marker_dragged(this);
        });
    
    }
}

// set pin when extend map open
function set_inc_ext_pin(){
    
    if(typeof $incMapMarker == "undefined"){
        return false;
    }
    
    var p_lat_lng = $incMapMarker.getPosition();
    
    var p_lat = p_lat_lng.lat();
    var p_lng = p_lat_lng.lng();
        
    if(typeof $ExtendMapWindow.$incExtMapMarker != "undefined"){
        $ExtendMapWindow.$incExtMapMarker.setMap(null);
    }

    $ExtendMapWindow.$ExtendMap.setCenter({lat: p_lat, lng: p_lng});

    $ExtendMapWindow.$incExtMapMarker = new $ExtendMapWindow.google.maps.Marker({
        position: {lat: p_lat, lng: p_lng},
        map: $ExtendMapWindow.$ExtendMap,
        draggable: true
    });

    $ExtendMapWindow.$incExtMapMarker.addListener('dragend',function(event) {
        inc_marker_dragged(this);
    });
         
}



function set_inc_add_details(place,map_tagId){
    
    if( typeof(map_tagId)==='undefined' ){
        map_tagId = 'INCIDENT_MAP';
    }
    
//    var p_lat = place.geometry.location.lat();
//    var p_lng = place.geometry.location.lng();

    if(place.latlng){
        var p_lat = place.latlng.lat();
        var p_lng = place.latlng.lng();
    }else{
        var p_lat = place.geometry.location.lat();
        var p_lng = place.geometry.location.lng();
    }
    
    var input = document.getElementById('inc_map_address');
    
    if($isExtendedMapOpened){
        
        if( map_tagId != 'INCIDENT_MAP' ){
            $callIncidentMap.setCenter({lat: p_lat, lng: p_lng});
            $incMapMarker.setPosition({lat: p_lat, lng: p_lng});
        }else{
            $ExtendMapWindow.$ExtendMap.setCenter({lat: p_lat, lng: p_lng});
            $ExtendMapWindow.$incExtMapMarker.setPosition({lat: p_lat, lng: p_lng});
        }
    }
    $('#add_inc_details #postal_code, #add_inc_details #inc_state, #add_inc_details #inc_district, #add_inc_details #inc_city, #add_inc_details #route, #add_inc_details #street_number, #add_inc_details #area_location, #add_inc_details #lat, #add_inc_details #lng, #add_inc_details #google_formated_add').val('');
    $('#add_inc_details #postal_code, #add_inc_details #inc_state, #add_inc_details #inc_district, #add_inc_details #inc_city, #add_inc_details #route, #add_inc_details #street_number, #add_inc_details #area_location, #add_inc_details #lat, #add_inc_details #lng, #add_inc_details #google_formated_add').val('');
    
    $('#add_inc_details #inc_city input.mi_autocomplete,#add_inc_details #inc_district input.mi_autocomplete').attr('data-value','');
    $('#add_inc_details #inc_city input.mi_autocomplete_input,#add_inc_details #inc_district input.mi_autocomplete').val('');
    
    $('#add_inc_details #incient_dist input.mi_autocomplete,#add_inc_details #incient_dist input.mi_autocomplete').attr('data-value','');
    $('#add_inc_details #incient_dist input.mi_autocomplete_input,#add_inc_details #incient_dist input.mi_autocomplete').val('');

    $('#add_inc_details #incient_tahsil input.mi_autocomplete,#add_inc_details #incient_tahsil input.mi_autocomplete').attr('data-value','');
    $('#add_inc_details #incient_tahsil input.mi_autocomplete_input,#add_inc_details #incient_tahsil input.mi_autocomplete').val('');
    
    $('#add_inc_details #lat').val(p_lat);
    $('#add_inc_details #lng').val(p_lng);
    
    var $amb_type = [];
    $('input[name="amb_type[]"]:checked').each(function() {
         $amb_type.push($(this).val());
    });

     $inc_type = $('#inc_type').val();
     var $dist_id = $("#incient_dist .mi_autocomplete").val();
     
     
    $('#get_ambu_details').attr('href',base_url+'inc/get_inc_ambu?showprocess=yes&inc_type='+$inc_type+'&amb_tp='+$amb_type+'&lat='+p_lat+'&lng='+p_lng+'&district_id='+$dist_id);
    $("#get_ambu_details").click();
   
    $('.previous_inc_btn').attr('data-href',base_url+'inc/previous_incident?showprocess=yes&inc_type='+$inc_type+'lat='+p_lat+'&lng='+p_lng);
    $('.previous_inc_btn').attr('href',base_url+'inc/previous_incident?showprocess=yes&inc_type='+$inc_type+'lat='+p_lat+'&lng='+p_lng);
    $('.previous_inc_btn').attr('data-qr','output_position=previous_incident_details&inc_type='+$inc_type+'&lat='+p_lat+'&lng='+p_lng);
    $('#get_previous_inc_details').attr('data-qr','output_position=previous_incident_details&inc_type='+$inc_type+'&lat='+p_lat+'&lng='+p_lng);
   
    $("#get_previous_inc_details").click();
    
   // init_auto_address('INCIDENT_MAP');
   
    cur_autocom = $(input).attr('data-rel');
    var auto = $('.' + cur_autocom);
    dt_rel = auto.attr('data-rel');
    
    dt_state = 'yes';
    dt_dist = 'yes';
    dt_thl ='yes';
    dt_city = 'yes';
    dt_area = 'yes'
    dt_pin = 'yes'
    loc_dist = "";
    loc_state = "";
   // loc_state = "Madhya Pradesh";
    loc_thl ="";
    
    if(place.address_components){
        
        $.each(place.address_components,function(){
            

            if(this.types[0] == 'postal_code'){
                $('#add_inc_details #postal_code').val(this.long_name);
            }
            if(this.types[0] == 'administrative_area_level_1'){
                //$('#add_inc_details #incient_state input.mi_autocomplete').val(this.short_name);
                var state_code = this.short_name;

                loc_state = this.long_name;
                
                console.log(loc_state);

                 // console.log(state_code);
                $('#add_inc_details #incient_state input.mi_autocomplete').attr('value',this.short_name);
                $('#add_inc_details #incient_state input.mi_autocomplete').attr('data-value',this.long_name);
                $('#add_inc_details #incient_state input.mi_autocomplete_input').val(this.long_name);

            }else{
               // state_code = 'MH';

               // loc_state = 'Maharashtra';
            }
            
            if(this.types[0] == 'locality'){ 
                loc_dist = this.long_name;
                $('#add_inc_details #inc_district').val(this.long_name);

            }
             if(this.types[0] == 'locality'){
                loc_thl = this.long_name;
                $('#add_inc_details #inc_city').val(this.long_name);
            }
            if(this.types[0] == 'locality'){
                dt_city = this.long_name;
                $('#add_inc_details #inc_city').val(this.long_name);
            }
             if(this.types[0] == 'route'){
                $('#add_inc_details #route').val(this.long_name);
            }
            if(this.types[0] == 'neighborhood'){
                $('#add_inc_details #street_number').val(this.long_name);
            }
            if(this.types[0] == 'sublocality_level_1'){
                $('#add_inc_details #area_location').val(this.long_name);
            }

        });
    }else{
    
        console.log(place);
        loc_dist = place.district;
        dt_city = place.district;
        loc_thl = place.district;
        loc_state = place.state;
    }
     
    data_qr = "dt_auto_addr=inc_auto_addr&dt_rel=incient&dt_state=" + dt_state + "&dt_dist=" + dt_dist + "&loc_state=" + loc_state + "&loc_dist=" + loc_dist+"&dt_thl="+dt_thl+"&loc_thl="+loc_thl+"&dt_city="+dt_city+"&loc_city="+dt_city;
   

    xhttprequest($(this), base_url + 'auto/manage_addr', data_qr);
    var $formated_address = 'Bus stand ';
    
    if(typeof dt_city != ''){
        $formated_address = $formated_address+', '+dt_city;
    }
    if(typeof loc_dist != ''){
        $formated_address = $formated_address+', '+loc_dist;
    }
     if(typeof loc_state != ''){
        $formated_address = $formated_address+', '+loc_state;
    }
    
    $('#add_inc_details #google_formated_add').val($formated_address);
    
    if($('#inc_map_address').val() == ''){
        $('#inc_map_address').val($formated_address);
    }
    
    $('#add_inc_details_block input').each( function() {
        if($(this).val() == ''){
              $(this).addClass('input_focus');
        }
    });

}


// 
function inc_marker_dragged($incMarkerObj){
    
    var m_lat = $incMarkerObj.position.lat();
    var m_lng = $incMarkerObj.position.lng();
    
    var address = m_lat+','+m_lng;

    $incGeocoder = new google.maps.Geocoder();
    $incGeocoder.geocode( { 'address': address}, function(results, status) {
   // console.log(results[0].formatted_address);  
    $('#inc_map_address').val(results[0].formatted_address);
        if (status == 'OK') {
            set_inc_add_details (results[0],$incMarkerObj.map.tagId);
        } else {
            alert('Google was not successful for the following reason: ' + status);
        }
    });
    
}

// Update Ambulance Map Pins When Ambulance load
function update_ambulance_inc_map(){
    
    
    if( jQuery('#inc_map_address').length < 1 ){
        return false;
    }
     
    $.each($ambMapMarkers,function($index_amb_id,$marker_obj){
        $marker_obj.setMap(null);
    });
    
    
    $('#SelectedAmbulance').html('');
    
    $ambMapMarkers = {};
    $infoWindows   = [];
    //var $markerBounds = new google.maps.LatLngBounds();
    
    
    var inc_lat = $('#add_inc_details #lat').val();
    var inc_lng = $('#add_inc_details #lng').val();

    //$markerBounds.extend({lat: parseFloat(inc_lat), lng: parseFloat(inc_lng) });
        
    $('.inc_ambu_list .searched_ambu_item').each( function() {
        
        
        var amb_obj = this;
        var amb_id = $(this).attr('data-amb_id');
        var amb_lat = $(this).attr('data-lat');
        var amb_lng = $(this).attr('data-lng');
        var amb_title = $(this).attr('data-title');
        var amb_rto_no = $(this).attr('data-rto-no');
        var amb_status = $(this).attr('data-amb_status');
        var amb_details = $(this).find('.ambu_pin_info').html();
        
        var markerLatLng = {lat: parseFloat(amb_lat), lng: parseFloat(amb_lng) };
        //$markerBounds.extend(markerLatLng);
        var marker = new google.maps.Marker({
            position: markerLatLng,
            map: $callIncidentMap, 
            title: amb_title, 
            icon: $MapPins[amb_status]
        });
        marker.status = amb_status;
        
        //if( amb_status == 41 || amb_status == 42 || amb_status == 11 || amb_status == 12 ){ 
            
        marker.addListener('click', function() {
            $('.searched_ambu_item#Search_Amb_'+amb_id+' .amb_check_box').click();
            return false;
        });
        
        marker.addListener('dblclick', function() {
            $('.searched_ambu_item#Search_Amb_'+amb_id+' .amb_stand_check_box').click();
            return false;
        });
        
        //}
        
        var infowindow = new google.maps.InfoWindow({
            content: amb_details
        });
        $infoWindows.push(infowindow); 

        marker.addListener('mouseover', function() {
            for (var i=0;i<$infoWindows.length;i++) {
                $infoWindows[i].close();
            }
            infowindow.open($ambMapMarkers, marker);
        });

        $ambMapMarkers[amb_id] = marker; 
        
        
       
    });
    
    //$callIncidentMap.fitBounds($markerBounds);
    $callIncidentMap.setCenter({lat: parseFloat(inc_lat), lng: parseFloat(inc_lng) });
    //console.log('123');
    

    
    if(jQuery("#DefaultSelectedAmb").length >= 1 ){
        var DefaultSelectedAmb = JSON.parse(jQuery("#DefaultSelectedAmb").val());
        
        jQuery.each(DefaultSelectedAmb,function(){
            var amb_id = $('.inc_ambu_list .searched_ambu_item[data-rto-no="'+this+'"]').attr('data-amb_id');
            //google.maps.event.trigger($ambMapMarkers[amb_id] , 'click');
            $('.searched_ambu_item#Search_Amb_'+amb_id+' .amb_check_box').click();
        });
        
    }else{
        // Select First ambulance by default 
        var amb_id = $('.inc_ambu_list .searched_ambu_item').filter('[data-amb_status="41"]').eq(0).attr('data-amb_id');
        if(typeof amb_id == 'undefined'){
              var amb_id = $('.inc_ambu_list .searched_ambu_item').filter('[data-amb_status="11"]').eq(0).attr('data-amb_id');
        }
       //google.maps.event.trigger($ambMapMarkers[amb_id] , 'click');
        $('.searched_ambu_item#Search_Amb_'+amb_id+' .amb_check_box').click();
    }
    
    if($isExtendedMapOpened){
        update_ambulance_inc_ext_map();
    }
    
}


// Update Ambulance Extended Map Pins When Ambulance load
function update_ambulance_inc_ext_map(){
     
    $.each($ExtendMapWindow.$ambExtMapMarkers,function($index_amb_id,$marker_obj){
        $marker_obj.setMap(null);
    });
    
    //$('#SelectedAmbulance').html('');
    
    $ExtendMapWindow.$ambExtMapMarkers = {};
    $ExtendMapWindow.$infoExtMapWindows= [];
    //var $ExtmarkerBounds = new $ExtendMapWindow.google.maps.LatLngBounds();
    
    //mark selected ambulance 
    var $SelectedAmbulance=[];
    if(jQuery("#SelectedAmbulance input.selected_ambu_input").length >= 1 ){
        jQuery("#SelectedAmbulance input.selected_ambu_input").each(function(){
            var amb_id = $(this).attr('data-amb_id');
            $SelectedAmbulance[$SelectedAmbulance.length] = amb_id;
        });
    }

    var $StandbyAmbulance=[];
    if(jQuery("#StandbyAmbulance input.standby_ambu_input").length >= 1 ){
        jQuery("#StandbyAmbulance input.standby_ambu_input").each(function(){
            var amb_id = $(this).attr('data-amb_id');
            $StandbyAmbulance[$StandbyAmbulance.length] = amb_id;
        });
    }
    var inc_lat = $('#add_inc_details #lat').val();;
    var inc_lng = $('#add_inc_details #lng').val();;
   // $ExtmarkerBounds.extend({lat: parseFloat(inc_lat), lng: parseFloat(inc_lng) });
    
    $('.inc_ambu_list .searched_ambu_item').each( function() {
        
        var amb_obj = this;
        var amb_id = $(this).attr('data-amb_id');
        var amb_lat = $(this).attr('data-lat');
        var amb_lng = $(this).attr('data-lng');
        var amb_title = $(this).attr('data-title');
        var amb_rto_no = $(this).attr('data-rto-no');
        var amb_status = $(this).attr('data-amb_status');
        var amb_details = $(this).find('.ambu_pin_info').html();
        var amb_type = $(this).attr('data-amb_type');
        var amb_map_pin = $MapPins[amb_status];
        
        if($.inArray(amb_id,$SelectedAmbulance) > -1 ){
            if(amb_type == 2){
                 amb_map_pin = map_102_pin_image;
            }else{
                 amb_map_pin = map_pin_image_hover;
            }
            
        }
        if($.inArray(amb_id,$StandbyAmbulance) > -1 ){
             if(amb_type == 2){
                amb_map_pin = map_102_pin_image;
            }else{
                amb_map_pin = stand_map_pin_image_hover;
            }   
        }
        
        var markerLatLng = {lat: parseFloat(amb_lat), lng: parseFloat(amb_lng) };
        //$ExtmarkerBounds.extend(markerLatLng); 
        var marker = new $ExtendMapWindow.google.maps.Marker({
            position: markerLatLng,
            map: $ExtendMapWindow.$ExtendMap, 
            title: amb_title, 
            icon: amb_map_pin
        });
        marker.status = amb_status;
        
        
        //if( amb_status == 11 || amb_status == 12 || amb_status == 41 || amb_status == 42 ){ 
            
            marker.addListener('click', function() {
                $('.searched_ambu_item#Search_Amb_'+amb_id+' .amb_check_box').click();
                return false;
            });

            marker.addListener('dblclick', function() {
                $('.searched_ambu_item#Search_Amb_'+amb_id+' .amb_stand_check_box').click();
                return false;
            });
        
       // }
        
        var infowindow = new $ExtendMapWindow.google.maps.InfoWindow({
            content: amb_details
        });
        $ExtendMapWindow.$infoExtMapWindows.push(infowindow); 

        marker.addListener('mouseover', function() {
            for (var i=0;i<$ExtendMapWindow.$infoExtMapWindows.length;i++) {
                $ExtendMapWindow.$infoExtMapWindows[i].close();
            }
            infowindow.open($ExtendMapWindow.$ambExtMapMarkers, marker);
        });

        $ExtendMapWindow.$ambExtMapMarkers[amb_id] = marker; 
       
    });
    
    //$ExtendMapWindow.$ExtendMap.fitBounds($ExtmarkerBounds);
     $ExtendMapWindow.$ExtendMap.setCenter({lat: parseFloat(inc_lat), lng: parseFloat(inc_lng) });
     
    //show checked ambulance direction on extended map

    jQuery('.searched_ambu_item .amb_check_box:checked').each(function(){
        
        jQuery(this).click();
    });

}
//Set direction to amb
function set_amb_direction($origin,$destination) {
   $directionsDisplay.setMap($callIncidentMap);
   
    var request = {
        origin: $origin,
        destination: $destination,
        travelMode: 'DRIVING'
    };
    $directionsService.route(request, function(result, status) {
        if (status == 'OK') {
            $directionsDisplay.setDirections(result);
        }
    });
    
    if($isExtendedMapOpened){
        $ExtendMapWindow.$ext_directionsDisplay.setMap($ExtendMapWindow.$ExtendMap);
        
        var request = {
            origin: $origin,
            destination: $destination,
            travelMode: 'DRIVING'
        };
        $ExtendMapWindow.$ext_directionsService.route(request, function(result, status) {
            if (status == 'OK') {
                $ExtendMapWindow.$ext_directionsDisplay.setDirections(result);
            }
        });
    }

}


$(document).ready(function(){
    
    $('#container').on('change', '.inc_ambu_list .searched_ambu_item input[type="checkbox"].amb_check_box' , function () {
        
        var $amb_obj = $(this).parents('.searched_ambu_item');
        var amb_id = $amb_obj.attr('data-amb_id');
        var amb_status = $amb_obj.attr('data-amb_status');
        var amb_rto_no = $amb_obj.attr('data-rto-no');
        var amb_lat = $amb_obj.attr('data-lat');
        var amb_lng = $amb_obj.attr('data-lng');
        var amb_type =  $amb_obj.attr('data-amb_type');
        var inc_lat = $('#add_inc_details #lat').val();
        var inc_lng = $('#add_inc_details #lng').val();
        var $distance_value = $amb_obj.attr('data-amb_geofence');
        
        if($distance_value == 'defult distance' || $distance_value == '' || $distance_value == 0 ){
            $distance_value = 10;
        }
       
        
        //google.maps.event.trigger($ambMapMarkers[amb_id] , 'click');
        //$ExtendMapWindow.google.maps.event.trigger($ExtendMapWindow.$ambExtMapMarkers[amb_id] , 'click');
        if(typeof google != 'undefined'){
            $incGeoFence.setMap(null);
        }
        
        var $inc_type =  $('#inc_type').val();

        if( $.trim($inc_type) == 'non-mci' ||  $.trim($inc_type) == 'NON_MCI' ||  $.trim($inc_type) == 'VIP_CALL' ){
            //console.log($inc_type);

            $.each($ambMapMarkers,function($index_amb_id,$marker_obj){
                $marker_obj.setIcon($MapPins[$marker_obj.status]);
            });

            if($isExtendedMapOpened){
                $.each( $ExtendMapWindow.$ambExtMapMarkers, function($index_amb_id,$marker_obj){
                    $marker_obj.setIcon($MapPins[$marker_obj.status]);
                });
            }

            //$(amb_obj).find('.amb_check_box').prop('checked', true);
            $amb_obj.addClass('amb_selected');
            $('#SelectedAmbulance .selected_ambu_input').remove();
            $('.inc_ambu_list .searched_ambu_item').removeClass('amb_selected');
            $('.inc_ambu_list .searched_ambu_item').find('.amb_check_box').prop('checked', false);

        }

        if( $('#StandbyAmbulance #Standby_Amb_ID_'+amb_id).length >= 1 ){
            $ambMapMarkers[amb_id].setIcon($MapPins[amb_status]);
            if($isExtendedMapOpened){
                $ExtendMapWindow.$ambExtMapMarkers[amb_id].setIcon($MapPins[amb_status]);
            }
            $amb_obj.removeClass('amb_selected');
            $amb_obj.find('.amb_stand_check_box').prop('checked', false);
            $('#StandbyAmbulance #Standby_Amb_ID_'+amb_id).remove();
        }

        if( $('#SelectedAmbulance #Selected_Amb_ID_'+amb_id).length >= 1 ){
            $ambMapMarkers[amb_id].setIcon($MapPins[amb_status]);
            if($isExtendedMapOpened){
                $ExtendMapWindow.$ambExtMapMarkers[amb_id].setIcon($MapPins[amb_status]);
            }
            $amb_obj.removeClass('amb_selected');
            $amb_obj.find('.amb_check_box').prop('checked', false);
            $('#SelectedAmbulance #Selected_Amb_ID_'+amb_id).remove();
        }else{
             if(amb_type == 2){
                map_pin_image_hover = map_102_pin_image;
            }else if(amb_type == 1){
                map_pin_image_hover = map_pin_image_hover;
            }else{
                map_pin_image_hover = map_pin_image;
            }
            
            if(typeof google != 'undefined'){
                $ambMapMarkers[amb_id].setIcon(map_pin_image_hover);
                if($isExtendedMapOpened){  
                    $ExtendMapWindow.$ambExtMapMarkers[amb_id].setIcon(map_pin_image_hover);
                }
            }
            $amb_obj.addClass('amb_selected');
            $amb_obj.find('.amb_check_box').prop('checked', true);

            $ambulance_input = '<input type="hidden" name="incient[amb_id]['+amb_id+']" id="Selected_Amb_ID_'+amb_id+'" data-amb_id="'+amb_id+'" value="'+amb_rto_no+'" class="selected_ambu_input filter_required" data-errors="{filter_required:\'Please select Ambulance\'}">';
            $('#SelectedAmbulance').append($ambulance_input);
            
             //set direction
          //  $destination = {lat: parseFloat(inc_lat), lng:  parseFloat(inc_lng)};
            $amb_origin = {lat:  parseFloat(amb_lat), lng:  parseFloat(amb_lng)};
            $destination = inc_lat+','+inc_lng;
            $origin = amb_lat+','+amb_lng;
            
            if(typeof google != 'undefined'){
                
                set_amb_direction($origin,$destination);

                $incGeoFence = new google.maps.Circle({
                    strokeColor: '#FF0000',
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: '#FF0000',
                    fillOpacity: 0.15,
                    map: $callIncidentMap,
                    center: $amb_origin,
                    radius:  parseInt($distance_value)*1000
                });

                if($isExtendedMapOpened){

                    $ExtendMapWindow.$incExtGeoFence = new $ExtendMapWindow.google.maps.Circle({
                        strokeColor: '#FF0000',
                        strokeOpacity: 0.8,
                        strokeWeight: 2,
                        fillColor: '#FF0000',
                        fillOpacity: 0.15,
                        map: $ExtendMapWindow.$ExtendMap,
                        center: $amb_origin,
                        radius: parseInt($distance_value)*1000
                    });
                }
            }
            
        }
        
    });
    
    $('#container').on('change', '.inc_ambu_list .searched_ambu_item input[type="checkbox"].amb_stand_check_box' , function () {
        
        
        var $amb_obj = $(this).parents('.searched_ambu_item');
        var amb_id = $amb_obj.attr('data-amb_id');
        var amb_status = $amb_obj.attr('data-amb_status');
        var amb_rto_no = $amb_obj.attr('data-rto-no');
        var amb_lat = $amb_obj.attr('data-lat');
        var amb_lng = $amb_obj.attr('data-lng');
        var inc_lat = $('#add_inc_details #lat').val();
        var inc_lng = $('#add_inc_details #lng').val();
        var $distance_value = $amb_obj.attr('data-amb_geofence');
        var amb_type =  $amb_obj.attr('data-amb_type');
        
        if($distance_value == 'defult distance' || $distance_value == '' || $distance_value == 0){
            $distance_value = 5;
        }
        

        
        //google.maps.event.trigger($ambMapMarkers[amb_id] , 'dblclick');
        //$ExtendMapWindow.google.maps.event.trigger($ExtendMapWindow.$ambExtMapMarkers[amb_id] , 'dblclick');
        
        var $inc_type =  $('#inc_type').val();

        if( $('#SelectedAmbulance #Selected_Amb_ID_'+amb_id).length >= 1 ){
            if(typeof google != 'undefined'){
                $ambMapMarkers[amb_id].setIcon($MapPins[amb_status]);
                if($isExtendedMapOpened){
                    $ExtendMapWindow.$ambExtMapMarkers[amb_id].setIcon($MapPins[amb_status]);
                }
            }
            $amb_obj.removeClass('amb_selected');
            $amb_obj.find('.amb_check_box').prop('checked', false);
            $('#SelectedAmbulance #Selected_Amb_ID_'+amb_id).remove();
        }

        if( $('#StandbyAmbulance #Standby_Amb_ID_'+amb_id).length >= 1 ){
            
            if(typeof google != 'undefined'){
                $ambMapMarkers[amb_id].setIcon($MapPins[amb_status]);
                if($isExtendedMapOpened){
                    $ExtendMapWindow.$ambExtMapMarkers[amb_id].setIcon($MapPins[amb_status]);
                }
            }
            $amb_obj.removeClass('amb_selected');
            $amb_obj.find('.amb_stand_check_box').prop('checked', false);
            $('#StandbyAmbulance #Standby_Amb_ID_'+amb_id).remove();
        }else{
            
            if(amb_type == 2){
                stand_map_pin_image_hover = map_102_pin_image;
           }else if(amb_type == 1){
                stand_map_pin_image_hover = stand_map_pin_image_hover;
            } else{
                map_pin_image_hover = map_pin_image;
            }
            
            $ambMapMarkers[amb_id].setIcon(stand_map_pin_image_hover);
            if($isExtendedMapOpened){
                $ExtendMapWindow.$ambExtMapMarkers[amb_id].setIcon(stand_map_pin_image_hover);
            }
            $amb_obj.addClass('amb_selected');
            $amb_obj.find('.amb_stand_check_box').prop('checked', true);

            $ambulance_input = '<input type="hidden" name="incient[stand_amb_id]['+amb_id+']" id="Standby_Amb_ID_'+amb_id+'" data-amb_id="'+amb_id+'" value="'+amb_rto_no+'" class="standby_ambu_input filter_required" data-errors="{filter_required:\'Please select Ambulance\'}">';
            $('#StandbyAmbulance').append($ambulance_input);
            
            //set direction
          //  $destination = {lat: parseFloat(inc_lat), lng:  parseFloat(inc_lng)};
            $amb_origin = {lat:  parseFloat(amb_lat), lng:  parseFloat(amb_lng)};
            $destination = inc_lat+','+inc_lng;
            $origin = amb_lat+','+amb_lng;
            
            if(typeof google != 'undefined'){
                set_amb_direction($origin,$destination);
          
                $incGeoFence = new google.maps.Circle({
                  strokeColor: '#FF0000',
                  strokeOpacity: 0.8,
                  strokeWeight: 2,
                  fillColor: '#FF0000',
                  fillOpacity: 0.15,
                  map: $callIncidentMap,
                  center: $amb_origin,
                  radius: parseInt($distance_value)*1000
               });
               if($isExtendedMapOpened){

                  $ExtendMapWindow.$incExtGeoFence = new $ExtendMapWindow.google.maps.Circle({
                      strokeColor: '#FF0000',
                      strokeOpacity: 0.8,
                      strokeWeight: 2,
                      fillColor: '#FF0000',
                      fillOpacity: 0.15,
                      map: $ExtendMapWindow.$ExtendMap,
                      center: $amb_origin,
                      radius: parseInt($distance_value)*1000
                  });
                }
            }
        }
        
    });
    
    $('#container').on('mouseover', '.inc_ambu_list .searched_ambu_item' , function () {
        
        var amb_lat = $(this).attr('data-lat');
        var amb_lng = $(this).attr('data-lng');
        var amb_id  = $(this).attr('data-amb_id');
        if(typeof google != 'undefined'){
            google.maps.event.trigger($ambMapMarkers[amb_id] , 'mouseover');
            if($isExtendedMapOpened){
                $ExtendMapWindow.google.maps.event.trigger($ExtendMapWindow.$ambExtMapMarkers[amb_id] , 'mouseover');
            }
        }
    });
    
    $('#container').on('click', '#inc_recomended_ambu .amb_type_checkbox' , function () {
        var p_lat = $('#add_inc_details #lat').val();
        var p_lng = $('#add_inc_details #lng').val();

        var $amb_type = [];
        $('input[name="amb_type[]"]:checked').each(function() {
             $amb_type.push($(this).val());
        });

         $inc_type = $('#inc_type').val();
         var $dist_id = $("#incient_dist .mi_autocomplete").val();

        $('#get_ambu_details').attr('href',base_url+'inc/get_inc_ambu?inc_type='+$inc_type+'&amb_tp='+$amb_type+'&lat='+p_lat+'&lng='+p_lng+'&district_id='+$dist_id);
        $("#get_ambu_details").click();
    });
    $('#container').on('click', '#inc_recomended_ambu .amb_status_checkbox' , function () {
        var p_lat = $('#add_inc_details #lat').val();
        var p_lng = $('#add_inc_details #lng').val();
        
          var $amb_type = [];
        $('input[name="amb_type[]"]:checked').each(function() {
             $amb_type.push($(this).val());
        });

        var $status = [1];
        
        $('input[name="amb_status[]"]:checked').each(function() {
             $status.push($(this).val());
        });
        
        var $dist_id = $("#incient_dist .mi_autocomplete").val();

        $('#get_ambu_details').attr('href',base_url+'inc/get_inc_ambu?inc_type='+$inc_type+'&amb_tp='+$amb_type+'&lat='+p_lat+'&lng='+p_lng+'&inc_status='+$status+'&district_id='+$dist_id);
        $("#get_ambu_details").click();
    });
    
    
});


$(document).ready(function(){

    $('#container').on('change', '.inc_ambu_list .searched_ambu_item input[type="checkbox"]' , function () {
        if($(this).is(':checked')){
            $(this).parent().find('input[type="checkbox"]').prop('checked',false);
            $(this).prop('checked',true);
        }
    });

});


function get_location_by_address(address){
    
  //  var address =$('#incient_dist .mi_autocomplete_input').val();
  
    address = address;
    //address = address;
    $('#inc_map_address').val(address);
    if(typeof google != 'undefined'){
        $incGeocoder = new google.maps.Geocoder();
        $incGeocoder.geocode( { 'address': address}, function(results, status) {
            if (status == 'OK') {
                set_inc_main_pin(results[0]);
                set_inc_add_details(results[0]);
            } else {
                alert('Google was not successful for the following reason: ' + status);
            }
        });
    }
}
function get_location_by_address_tahsil(address){
    
    var dist_address =$('#incient_dist .mi_autocomplete_input').val();

    address = 'Bus stop, '+dist_address+','+address+' ';
    $('#inc_map_address').val(address);
    if(typeof google != 'undefined'){

        $incGeocoder = new google.maps.Geocoder();
        $incGeocoder.geocode( { 'address': address}, function(results, status) {
            if (status == 'OK') {
                set_inc_main_pin(results[0]);
                set_inc_add_details(results[0]);
            } else {
                alert('Google was not successful for the following reason: ' + status);
            }
        });
    }
}
function get_location_by_address_city(address){
    
    var dist_address =$('#incient_dist .mi_autocomplete_input').val();
    var tahsil_address =$('#incient_tahsil .mi_autocomplete_input').val();
    
    address = 'Bus stop, '+dist_address+','+tahsil_address+', '+address+'';
    $('#inc_map_address').val(address);

    $incGeocoder = new google.maps.Geocoder();
    $incGeocoder.geocode( { 'address': address}, function(results, status) {
        if (status == 'OK') {
            set_inc_main_pin(results[0]);
            set_inc_add_details(results[0]);
        } else {
            alert('Google was not successful for the following reason: ' + status);
        }
    });
}


function get_address_ambulance(){
    var address =$('#IncAddress').val();
   // address = 'Bus stop, '+address+', Tamil Nadu';

    $incGeocoder = new google.maps.Geocoder();
    $incGeocoder.geocode( { 'address': address}, function(results, status) {
        if (status == 'OK') {
            set_inc_add_details(results[0]);
        } else {
            alert('Google was not successful for the following reason: ' + status);
        }
    });
}
function get_new_hospital_ambulance(){
    var address =$('#facility_details .new_hos_address').val();
    var lat =$('#facility_details .new_hos_lat').val();
    var lng =$('#facility_details .new_hos_lng').val();
    address1 =lat+','+lng;
    //console.log(address);
   
    if( address1.length <= 1 ){
        return false;
    }
    $('#inc_map_address').val(address);
    
    $incGeocoder = new google.maps.Geocoder();
    $incGeocoder.geocode( { 'address': address1}, function(results, status) {
        if (status == 'OK') {
            set_inc_add_details(results[0]);
            set_inc_main_pin(results[0]);
        } else {
            alert('Google was not successful for the following reason: ' + status);
        }
    });
}


//Extent Map popup window functions


function open_extend_map(url){
    $ExtendMapWindow = window.open(url, "Incident Map", "width=800,height=600,location=no,menubar=no,left=10%,top=5%","replace=true");
    $isExtendedMapOpened = 1;
    $($ExtendMapWindow).on("beforeunload", function() { 
        $isExtendedMapOpened = 0;
    });
}

$(window).load(function(){
    
    if($isExtendedMapOpened){
        $(window).on("beforeunload", function() { 
            $ExtendMapWindow.close();
        });
    }
    
});


var $ExtendMap;
var $ambExtMapMarkers = {};
var $infoExtMapWindows = [];
var $incExtMapMarker;
var $ext_autocomplete;

var $ext_directionsService;
var $ext_directionsDisplay;

$(window).load(function(){
    
    if( $("#EXTENDED_INCIDENT_MAP").length >= 1 ){
        initExtIncidentMap();
        window.opener.update_ambulance_inc_ext_map();
        //window.opener.auto_complete_place_changed();
        window.opener.set_inc_ext_pin();
    }
    
});



function initExtIncidentMap() {

    // var myLatLng = {lat: 18.532293, lng: 73.847192};
     var myLatLng = {lat: 23.23979546250735, lng: 77.39215854006432};
    // Create a map object and specify the DOM element for display.
    
    var MapWrapId = document.getElementById('EXTENDED_INCIDENT_MAP'); 
    $ExtendMap = new google.maps.Map(MapWrapId, {
        center: myLatLng,
        zoom: 14
    });
    
    $ExtendMap.tagId = 'EXTENDED_INCIDENT_MAP';
    
    $ext_directionsService = new google.maps.DirectionsService();
    $ext_directionsDisplay = new google.maps.DirectionsRenderer({suppressMarkers: true});
    
    var input = document.getElementById('inc_ext_map_address');
    var options = {
      types: ['geocode'],
//      componentRestrictions: {country: 'in'}
    };

    $ext_autocomplete  = new google.maps.places.SearchBox(input, options);
    $ext_autocomplete.addListener('places_changed', window.opener.ext_auto_complete_place_changed );
    
    $incExtGeoFence = new google.maps.Circle({});
    
}