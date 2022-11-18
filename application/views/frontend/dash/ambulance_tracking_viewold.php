<style>
#btn.clr{
    background-color:#1ABC9C;
}
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }
    .slider.round {
        border-radius: 34px;
    }
    .slider.round:before {
        border-radius: 50%;
    }
    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }
    input:checked + .slider {
        background-color: #2196F3;
    }

    input:focus + .slider {
        box-shadow: 0 0 1px #2196F3;
    }
    input:checked + .slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }
    .switch input { 
        opacity: 0;
        width: 0;
        height: 0;
    }
     
    
</style>


        <section class="statistic statistic2">
            <div class="row text-center">
              <div class="col-md-10 offset-md-1 col-lg-10 offset-md-1">  <!--offset-md-1 col-lg-10 offset-md-1-->
                <h3>AMBULANCE TRACKING</h3>
              </div>
            </div>
            <div class="row pb-9">
            <div class="col-md-3 ">
                <div class="col-md-12">Select Ambulance Type : </div>
                <div class="col-md-12 "><!---->
                   <select name="amb_type" id="amb_type" data-errors="{filter_required:'Amb type should not blank'}" TABINDEX="7" onchange="ambulance_typewise_load()" >
                            <option value="all">Select Ambulance Type</option>
                            <option value="all">All</option>
                            <?php foreach($amb_type as $ambuance_type){?>
                               <option value="<?php echo $ambuance_type->ambt_id ;?>"><?php echo $ambuance_type->ambt_name;?></option>
                            <?php } ?>     
                  </select>
                </div>
            </div>
            <div class="col-md-3" id="amb_view"><!---->
                <div class="col-md-12">Select Ambulance : </div>
                  <div class="col-md-12 form_input">
                  <input name="amb_reg_id"  id="amb_reg_id" class="mi_autocomplete dropdown_per_page width97 " data-href="{base_url}auto/get_ambulance" placeholder="Select Ambulance" data-errors="{filter_required:'Please select state from dropdown list'}" tabindex="2" autocomplete="off" value="" data-value="" >
                  </div>
            </div>
            <div class="col-md-6">
                    <input type="button" style="background-color:#1ABC9C" name="submit" value="Submit" class="btn btn-primary submit_btnt Submit" style="margin-top:25px;">                     
                   <!-- <input type="button" name="Refresh" value="Refresh" class="btn btn-primary submit_btnt form-xhttp-request" data-href='<?php echo base_url();?>dashboard/show_ambulance_tracking_remote' data-qr='page_no=<?php echo @$page_no; ?>&amp;output_position=content' > -->
                    <b style="margin-left: 30px;">Total Ambulance : </b><label id="totalAmb"></label>
                    <b style="margin-left: 30px;">MDT Login : </b><label id="totalMdt"></label>
               
            </div>
            </div>
            <div  id="list_table_amb_div"> <!--offset-md-1 col-lg-10 offset-md-1 mt-4 pt-1-->
                    <!-- <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for names.." title="Type in a name"> -->
                    <table class="table table-bordered NHM_Dashboard list_table_amb" id="myTable" style="text-align: center;">
                        <thead class="" style="">
                            <tr class="table-active">
                            <th scope="col">District</th>
                            <th scope="col">Ambulance No</th>
                            <th scope="col">Base Location</th>
                            <th scope="col">Type of Ambulance</th>
                            <th scope="col">App Login</th>
                            <th scope="col">Login Details</th>
                            <th scope="col">Incident Status</th>
                            <!--<th scope="col">Ignition Status</th>
                            <th scope="col">AVLS Tracking</th>-->
                            <th scope="col">MDT Tracking</th>
                            </tr>
                        </thead>
                        <?php 
                        foreach ($amb_data as $amb) {
                          $amb_location = $amb->hp_name;
                          if($amb_location == null)
                          {
                            $amb_location = $amb->wrdnm;
                          }
                          $app_status = $amb->app_status;
                          $parameter_count = $amb->parameter_count;
                          if($app_status == '1'){
                            //loginmdt++;
                            $app_status1 = '<i class="fa fa-mobile-phone" style="font-size:30px;color:green"></i>';
                            if($parameter_count  == 1){
                              //$time = $inc->start_from_base_loc;
                              $status = 'Call Assigned';
                               }
                              else if($parameter_count  == 2){
                              //$time = $inc->start_from_base_loc;
                              $status = 'Start From Base';
                              }else if($parameter_count  == 3){
                              //$time = $inc->at_scene;
                              $status = 'At Scene';
                              }else if($parameter_count  == 4){
                              //$time = $inc->from_scene;
                              $status = 'From Scene';
                              }else if($parameter_count  == 5){
                              //$time = $inc->at_hospital;
                              $status = 'At Hospital';
                              }else if($parameter_count  == 6){
                              //$time = $inc->patient_handover;
                              $status = 'Patient Handover';
                              }else if($parameter_count  == 7){
                              //$time = $inc->back_to_base_loc;
                              $status = 'Available';
                              }else{
                                $status = 'Login';
                              }
                          }else{
                            $app_status1 = '<i class="fa fa-mobile-phone" style="font-size:30px;color:red"></i>';
                            $status = 'Logout';
                          }

                        ?>
                        <tbody id="">
                        <td scope="col"><?php echo $amb->dst_name; ?></td>
                        <td scope="col"><?php echo $amb->amb_rto_register_no; ?></td>
                        <td scope="col"><?php echo $amb_location; ?></td>
                        <td scope="col"><?php echo $amb->ambt_name; ?></td>
                        <td scope="col"><?php echo $app_status1; ?></td>
                        <td scope="col"><i class='fa fa-address-book' style='font-size:25px;color: #117864;' Onclick='amb(<?php echo $amb->amb_id; ?>)' ></i></td>
                        <td scope="col"><?php echo $status; ?></td>
                        <td scope="col"><button style="background-color:#1ABC9C" class='btn btn-primary' Onclick='mdt(<?php echo $amb->amb_id; ?>)'>MDT</button ></td>
                        </tbody> 
                        <?php }
                        $status=''; ?>
                        
                    </table>
                </div>
            
        </section>
   
<!-- Modal -->
<div class="modal fade modalid" id="MyModal" tabindex="-1" role="dialog" >
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="width:1000px;height:800px;right: 278px;">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ambulance live Tracking</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <a id="mapId" class="lnk_icon_btns btn float_right" target="_blank" style="background: #085b80 !important;">Extend Map</a>
        <iframe id="mapId1" style="width:100%; height: 600px; border:0px;">
        </iframe>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade modalid" id="MDTModal" tabindex="-1" role="dialog" >
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="width:1000px;height:800px;right: 278px;">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">MDT live Tracking</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- <a id="mapId" class="lnk_icon_btns btn float_right" target="_blank" style="background: #085b80 !important;">Extend Map</a> -->
        <div id="map3" style="width: 900px; height: 600px; border:0px;">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal loginmodal" tabindex="-1" role="dialog" id="logindetails">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Login User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="margin: 17px;">
       <!-- <div class="row">
            <h4>EMT</h4><br/>
        </div>
        <div class="row">
            <b class="col-4">Name : </b><label class="col-8" id="emso_name"></label><br/>
        </div>
        <div class="row">
            <b class="col-4">Contact No : </b><label class="col-8" id="emso_mob"></label>
        </div>-->
        <div class="row">
            <h4>Pilot</h4><br/>
        </div>
        <div class="row">
            <b class="col-4">Name : </b> <label class="col-8" id="driver_name"></label><br/>
        </div>
        <div class="row">
            <b class="col-4">Contact No : </b><label class="col-8" id="driver_mob"></label>
        </div>
        <div class="row">
            <b class="col-4">Login Time : </b><label class="col-8" id="login_time"></label>
        </div>
        <div class="row">
            <b class="col-4">Logout Time : </b><label class="col-8" id="logout_time"></label>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<input type="hidden" id="mdt_veh">

<script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-core.js"></script>
<script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-service.js"></script>
<script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-ui.js"></script>
<script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-mapevents.js"></script>
<link href="https://js.api.here.com/v3/3.1/mapsjs-ui.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script>
    $('.Submit').on('click', function(){
      //  alert('hi');
        var amb_type = $('#amb_type').val();
        var amb_reg_id = $('#amb_reg_id').val();
      //  alert('hi');
      //  alert(amb_type);
      //  alert(amb_reg_id);
    //  var amb_district1 = $('#amb_district option:selected').text();
        $.post('<?=site_url('dashboard/show_ambulance_tracking_remote')?>',{amb_type,amb_reg_id},function(data){
           var new_var = JSON.parse(data);
            $('.list_table_amb').html("");
            var raw = '<table class="table table-bordered list_table_amb" id="myTable" style="text-align: center;">'+
                            '<tr class="table-active">'+
                            '<th scope="col">Sr.No</th>'+
                            '<th scope="col">District</th>'+
                            '<th scope="col">Ambulance No</th>'+
                            '<th scope="col">Base Location / Ward Name</th>'+
                            '<th scope="col">Type of Ambulance</th>'+
                            '<th scope="col">App Login</th>'+
                            '<th scope="col">Login Details</th>'+
                            //'<th scope="col">Speed</th>'+
                            //'<th scope="col">Ignition Status</th>'+
                            '<th scope="col">Incident Status</th>'+
                            //'<th scope="col">AVLS Tracking</th>'+
                            '<th scope="col">MDT Tracking</th>'+
                            '</tr>'+
                    '</table>';
            $('.list_table_amb').html(raw);
            $('#totalAmb').html(new_var.length);
            var j = 1;
            var loginavls = 0;
            var loginmdt = 0;
            for(var i = 0; i < new_var.length; i++){
                var ignition = new_var[i].amb_Ignition_status;
                var app_status = new_var[i].app_status;
                var parameter_count = new_var[i].parameter_count;
                if(app_status == '1'){
                    loginmdt++;
                    var app_status1 = '<i class="fa fa-mobile-phone" style="font-size:30px;color:green"></i>';
                     if(parameter_count  == 1){
                    //$time = $inc->start_from_base_loc;
                    var status = 'Call Assigned';
                     }
                    else if(parameter_count  == 2){
                    //$time = $inc->start_from_base_loc;
                    var status = 'Start From Base';
                    }else if(parameter_count  == 3){
                    //$time = $inc->at_scene;
                    var status = 'At Scene';
                    }else if(parameter_count  == 4){
                    //$time = $inc->from_scene;
                    var status = 'From Scene';
                    }else if(parameter_count  == 5){
                    //$time = $inc->at_hospital;
                    var status = 'At Hospital';
                    }else if(parameter_count  == 6){
                    //$time = $inc->patient_handover;
                    var status = 'Patient Handover';
                    }else if(parameter_count  == 7){
                    //$time = $inc->back_to_base_loc;
                    var status = 'Available';
                    }else{
                    var status = 'Login';
                    }
                }else{
                    var app_status1 = '<i class="fa fa-mobile-phone" style="font-size:30px;color:red"></i>';
                    var status = 'Logout';
                  }
                if(ignition == 'Ignition Off' || ignition == ""){
                    // var checked = "";
                    var checked = "<input type='checkbox' disabled='disabled'>";
                }else{
                    // var checked = "checked";
                    loginavls++;
                    var checked = "<input type='checkbox' disabled='disabled' checked>";
                }
                
               
                
                var amb_location = new_var[i].hp_name;
                if(amb_location == null)
                {
                  var amb_location = new_var[i].wrdnm;
                }
                
                var raw = "<tr>"+
                "<td>" + j++ + "</td>"+
                "<td>" + new_var[i].dst_name + "</td>"+
                "<td>" + new_var[i].amb_rto_register_no + "</td>"+
                "<td>" + amb_location + "</td>"+
                "<td>" + new_var[i].ambt_name + "</td>"+
                "<td>" + app_status1 + "</td>"+
                "<td><i class='fa fa-address-book' style='font-size:25px;color: #117864;' Onclick='amb("+new_var[i].amb_id+")' ></i></td>"+
               // "<td>" + new_var[i].amb_speed + "</td>"+
               // "<td><label class='switch'>"+checked+"<span class='slider round'></span></label></td>"+
                "<td>" + status + "</td>"+
               // "<td><button class='btn btn-primary' Onclick='track("+new_var[i].amb_id+")'>AVLS</button ></td>"+
               "<td><button id='btn_clr'  class='btn btn-primary' Onclick='mdt("+new_var[i].amb_id+")'>MDT</button ></td>"+
                 "</tr>";
                $('#list_table_amb_div tr:last').after(raw);
                var status='';
                
            }
            $('#totalAvls').html(loginavls);
            $('#totalMdt').html(loginmdt);
        });
    });
    function track(amb_id){
      var space = 0;
      $.post('<?=site_url('dashboard/get_amb_no')?>',{amb_id,space},function(data){
        var strLink = 'https://www.nuevastech.com/API/API_LiveTrackVehicle.aspx?track=S&username=JKERC&accesskey=5682C1ED819E8B48FC3E&vehiclename='+data+'&tracktype=LT';
        document.getElementById("mapId").setAttribute("href",strLink);
        var strLink1="https://www.nuevastech.com/API/API_LiveTrackVehicle.aspx?track=S&username=JKERC&accesskey=5682C1ED819E8B48FC3E&vehiclename="+data+"&tracktype=LT";
        document.getElementById("mapId1").setAttribute("src",strLink1);
        // alert(data)
      });
      // alert(id);
      $('#MyModal').modal('show');
    }
    var veh;
    function mdt(amb_id){
      
      var space = 1;
      $.post('<?=site_url('dashboard/get_amb_no')?>',{amb_id,space},function(data){
        $('#mdt_veh').val(data);
        veh += data;
        $('#map3').html('');
        $('#MDTModal').modal('show');
      
        mdtloadmap();
      });
    }
    // $('#amb').on('click',function(){
    //     alert('id')
    // });
    function amb(amb_id){
       // alert(amb_id);
        $.post('<?=site_url('dashboard/get_app_login_user_remote')?>',{amb_id},function(data){
            var new_var = JSON.parse(data);
            alert(data);
            for(var i = 0; i < new_var.length; i++){
                if(new_var[i].login_type == "P"){
                    var emsoName = new_var[i].clg_first_name+ new_var[i].clg_mid_name + new_var[i].clg_last_name;
                    $('#emso_name').html(emsoName);
                    $('#emso_mob').html(new_var[i].clg_mobile_no);
                   // $('#login_time').html(new_var[i].login_time);
                   // $('#logout_time').html(new_var[i].logout_time);
                }else{
                    var driverName = new_var[i].clg_first_name+ new_var[i].clg_mid_name + new_var[i].clg_last_name;
                    $('#driver_name').html(driverName);
                    $('#driver_mob').html(new_var[i].clg_mobile_no);
                    $('#login_time').html(new_var[i].login_time);
                    $('#logout_time').html(new_var[i].logout_time);
                }
            }
            $('#logindetails').modal('show');
        });
    }
</script>
<script>
function myFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
</script>

<script>
    // mdtloadmap();
    // $( document ).ready(function(){
    //   loadmap();
    // });
    var $MdtMarkerGroup = null,$MdtMarker = null;
    var map_obj,$google_map_obj;
    
    var $directionsAmb;
    var $directionsDisplayAmb;
    var $MdtMapUI, $MdtMap;
    var markerins = new Array();
    var amblatlong = new Array();
    // var $Allgroup =null;
    function addMarkersToMap(lat,log) {
        
        if($MdtMarker != null){
           // $MdtMap.removeObject($MdtMarker);
            $MdtMap.removeObjects($MdtMap.getObjects());
            $MdtMarker = null;
        }
        
        $MdtMarker = new H.map.Marker({lat:parseFloat(lat), lng:parseFloat(log)});
        $MdtMap.addObject($MdtMarker);
      //  sleep(5000);
        $MdtMap.getViewPort().resize();
         setTimeout(function () {
             $MdtMap.getViewPort().resize();
         }, 3000);
    }
    function mdtloadmap(){
        //var myLatLng = { lat: 19.0760, lng: 72.8777 };
        var myLatLng = {lat: 23.23979546250735, lng: 77.39215854006432};
        $Mdt_Platform = new H.service.Platform({
            apikey: 'yrjPrIYd0xU9KJpe1xlaR1_K1wFrwc9U-_-99n040JQ',
        });
        var defaultLayers = $Mdt_Platform.createDefaultLayers();
        
        $MdtMap = new H.Map( document.getElementById('map3'),
            defaultLayers.vector.normal.map, {
            center: myLatLng,
            zoom: 8,
            //pixelRatio: window.devicePixelRatio || 1
        });
        
        $allmapbehavior = new H.mapevents.Behavior(new H.mapevents.MapEvents($MdtMap));

        $MdtMap.tagId = 'map3';
        
        window.addEventListener('resize', () => $MdtMap.getViewPort().resize());
        $MdtMapUI = H.ui.UI.createDefault($MdtMap, defaultLayers);

        var lat = 19.0760;
        var log = 72.8777;
        
        addMarkersToMap(lat,log);
    }
</script>

<script>
        //loadmap();
        if(typeof H != 'undefined'){
            
            var amb_timer = setInterval(function () {
                // if(map_obj){ 
                    // console.log(map_obj);
                    var veh = $('#mdt_veh').val();
                    $.post('<?=base_url('avls/get_live_data')?>',{veh:veh},function(result){
                        var gpsdata = JSON.parse(result);
                        //alert(result);
                        if (gpsdata != '') {
                            $.each(gpsdata, function (index, ambdata) {
                                
                                addMarkersToMap(ambdata.amb_lat,ambdata.amb_log);
                                try{
                                    //resetmarker($google_map_obj,ambdata.amb_rto_register_no,ambdata.amb_lat,ambdata.amb_log); 
                                }catch(e){
                                }
                            });
                        }else{
                            $('#data_not_found').html('No Data Found');
                            return false;
                        }
                    });
                // }
            }, 10000);
        }

        function resetmarker($google_map_obj,ambregno,lat,log){
            if(ambregno!=""){
                if (markerins[ambregno] != null) {
                }else{
                    return true;
                }
                var markerLatLng = {lat: parseFloat(lat), lng: parseFloat(log)};
                markerins[ambregno].setPosition(markerLatLng);
            }
        }
        
//         window.onload = function () {
//             //addMarkersToMap($google_map_obj,ambregno,lat,log);
//                   mdtloadmap();
//         }
//         mdtloadmap();
//        
    </script>