function display_form(){

	jQuery(".add_group_form").css('display','block');

	

}



 var counter=0;
 var city_counter =0;
 var city_counter_mr=0;

 jQuery(document).ready(function(){

    jQuery("body").on('click',".add_textbox",function(){

        counter++;  
        var class_name;

        if(jQuery(this).data().qr){
            var i = jQuery(this).data().qr.split('=');
            var  var_name = i[0].toString();
                            
                if(var_name == "lang_class"){
                    class_name = i[1].toString();
                }

                }else{
                     class_name="";    
                }
             jQuery('<input type="text" class="'+class_name+'"  name="'+jQuery(this).data().bind+'['+counter+']" />').insertBefore(jQuery(this));

            return false;

    });
    
   
   
    jQuery("body").on('click',"#add_more_city",function(){

           city_counter++;
           if(city_counter % 2 ===0){
               div_float='float_left';
           }else{
               div_float='float_right';
           }
        jQuery('<div class="width2 '+div_float+'"><div class="field_row"><div class="field_lable"><label for="city_'+city_counter+'">City*</label></div><div class="filed_input"> <input id="city_'+city_counter+'" type="text" name="city['+city_counter+']" TABINDEX=16 data-href="'+base_url+'ms-admin/advertise/get_city_autocomplete" placeholder="City" data-base="adv_publish" value="" class="filter_required mi_autocomplete" data-errors="{filter_required:\'City should not be blank!\'}"/><\/div><\/div><\/div>').insertBefore(jQuery(this));

            return false;

    });
    
      jQuery("body").on('click',"#add_more_city_mr",function(){

           city_counter_mr++;
           if(city_counter_mr % 2 ===0){
               div_float='float_left';
           }else{
               div_float='float_right';
           }
        jQuery('<div class="width2 '+div_float+'"><div class="field_row"><div class="field_lable"><label for="city_'+city_counter_mr+'">City*</label></div><div class="filed_input"> <input id="city_mr_'+city_counter_mr+'" type="text" name="city['+city_counter_mr+']" TABINDEX=16 data-href="'+base_url+'gb-admin/advertise/get_city_autocomplete" placeholder="City" data-base="adv_mr_publish" value="" class="filter_required mi_autocomplete" data-errors="{filter_required:\'City should not be blank!\'}"/><\/div><\/div><\/div>').insertBefore(jQuery(this));

            return false;

    });

 });

/* MI34 */

$(document).ready(function(){ 
    
$("body").on("click",'input[name="adv_format"]',function() {     
   
    
  $(".select_file").html($(this).attr("data-label"));
  
});


$("body").on("click",'.banner_radio_btn',function() {     
 
      $('#banner_type_id').slideDown();
 });
 
$("body").on("click",'.video_radio_btn,.audio_radio_btn',function() {     
 
      $('#banner_type_id').slideUp();
     
 });
 
 $("body").on("click",'.banner_radio_btn_mr',function() {     
 
      $('#banner_type_id_mr').slideDown();
 });
 
$("body").on("click",'.video_radio_btn_mr,.audio_radio_btn_mr',function() {     
 
      $('#banner_type_id_mr').slideUp();
     
 });
 

});
/*
 * Lock screen functions
 */

//$("body").ready(function(){
var lock_screen_flag = 0;  
var LOCK_SCREEN_FLAG = 0;
var LOCK_SCREEN_TIMER = new Date().getTime();
var TIME_LIMIT = 3600*1000;
var $ck_timer_obj;

jQuery(document).ready(function(){    
    
    jQuery('body *').scroll( update_timer );
    
    jQuery(document).keydown( update_timer );
    
    jQuery(document).mousemove( update_timer );

    jQuery(document).mousedown( update_timer );

    $ck_timer_obj = setInterval( check_timer ,1000);
    
    
    
    jQuery("#lock_screen_btn").on('click', lock_screen);
    
    
    
});

function update_timer(){
    
//    console.log("clicked");
    if( LOCK_SCREEN_FLAG == 0){
        
       LOCK_SCREEN_TIMER = new Date().getTime();
       
    }
    
}

function check_timer(){
    
    if( LOCK_SCREEN_FLAG == 0 ){
       
       var CURR_LIMIT = new Date().getTime();
       var time_diff = CURR_LIMIT - LOCK_SCREEN_TIMER;
       if( time_diff > TIME_LIMIT ){
           lock_screen();
       }
       
    }    
    
}



function lock_screen(){
    
    LOCK_SCREEN_FLAG = 1;

//console.log(base_url);
    
    $.ajax({
        
        
        url: base_url+"ms-admin/clg/user_screen_lock",
        data:{
            
              LOCK_STATUS: '1'
              
        }
        
      }).done(function() {
          
            jQuery(".lock_screen_page_container").fadeIn('slow');
            jQuery(".lock_screen_page_container").addClass('lock_screen');
            
        
      });

    $(".sl_pwd_field_input").val("");

}


function unlock_screen(){
    LOCK_SCREEN_FLAG = 0;
    LOCK_SCREEN_TIMER = new Date().getTime();
        
    jQuery(".lock_screen_page_container").fadeOut('slow');    
    jQuery(".lock_screen_page_container").removeClass('lock_screen');
}


/*
 * Map event functions
 */

//var ltlng = {lat: 20.0, lng: 75.0};
//var map = new google.maps.Map(document.getElementById('googleMap'), {center: ltlng, zoom: 8});
var geocoder;

var map;
//var ltlng;
var marker;

function initMap(ltlng, map_obj) {
  
    try{
//    var ltlng = {lat: 19.62265302687665, lng: 74.65733884124757};
    
  map = new google.maps.Map(map_obj, {
    center: ltlng,
    zoom: 15
  });
  
  
  addMarker(ltlng, map);
  
    }catch(er){}
}

function addMarker(ltlng, map) {
    
     marker = new google.maps.Marker({
    position: ltlng,
    map: map,
    title: 'Click to zoom',
    draggable:true
  });

marker.addListener('drag',function(event) {
        document.getElementById('lttd').value = event.latLng.lat();
        document.getElementById('lgtd').value = event.latLng.lng();
        
        document.getElementById('lttd_m').value = event.latLng.lat();
        document.getElementById('lgtd_m').value = event.latLng.lng();
    });

    marker.addListener('dragend',function(event) {
        document.getElementById('lttd').value = event.latLng.lat();
        document.getElementById('lgtd').value = event.latLng.lng();
        
        document.getElementById('lttd_m').value = event.latLng.lat();
        document.getElementById('lgtd_m').value = event.latLng.lng();
    });
    
}

//  function placeMarker(position, map) {
//    var marker = new google.maps.Marker({
//      position: position,
//      map: map
//    });  
//    
//    
//    map.panTo(position);
//  }

function wrk_days(){ 
    
    jQuery("#all_from").on('change', function(){
        jQuery(".ui-priority-primary").on('click', function(){
            jQuery(".english .day_from").val(jQuery("#all_from").val());
        });
    });
    
    jQuery("#all_from_mar").on('change', function(){
        jQuery(".ui-priority-primary").on('click', function(){
            jQuery(".marathi .day_from").val(jQuery("#all_from_mar").val());
        });
    });
    
    jQuery("#all_to").on('change', function(){
        jQuery(".ui-priority-primary").on('click', function(){
            jQuery(".english .day_to").val(jQuery("#all_to").val());
        });
    });
    
    jQuery("#all_to_mar").on('change', function(){
        jQuery(".ui-priority-primary").on('click', function(){
            jQuery(".marathi .day_to").val(jQuery("#all_to_mar").val());
        });
    });
    
    
}




function codeAddress(address) {
    geocoder = new google.maps.Geocoder();

    geocoder.geocode( { 'address': address}, function(results, status) {
        
        console.log(address);
        console.log(status);

        if (status == google.maps.GeocoderStatus.OK) {
            map.setCenter(results[0].geometry.location);
            marker.setPosition(results[0].geometry.location);
            document.getElementById('lttd').value = results[0].geometry.location.lat();
            document.getElementById('lgtd').value = results[0].geometry.location.lng();
            $("#container .service_map_lttd").val(results[0].geometry.location.lat());
            $("#container .service_map_lgtd").val(results[0].geometry.location.lng());
            $("#container .map_lttd").val(results[0].geometry.location.lat());
            $("#container .map_lgtd").val(results[0].geometry.location.lng());
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
    
      $('body').on("change","input.map_canvas",function(){
    
        var address = $(this).val();
        codeAddress(address);
    }); 
    
    
     $('body').on("change","select.map_canvas",function(){
    
        var address = $("select.map_canvas option:selected").text();
        
        codeAddress(address);
    }); 
    
 });
