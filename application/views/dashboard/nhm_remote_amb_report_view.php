<style>
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
    tbody {
      /* display:block; */
      /* max-height:500px; */
      /* overflow-y:auto; */
    }
    /* thead, tbody tr {
        display:table;
        width:100%;
        table-layout:fixed;
    } */
    /* thead {
        width: calc( 100% - 1em )
    }  */
    #myTable {
      font-family: Arial, Helvetica, sans-serif;
      border-collapse: collapse;
      width: 100%;
    }

    #myTable td, #myTable th {
      border: 1px solid #6f6d6d;
      padding: 8px;
    }

    #myTable tr:nth-child(even){background-color: #f2f2f2;}

    #myTable tr:hover {background-color: #ddd;}

    #myTable th {
      padding-top: 12px;
      padding-bottom: 12px;
      text-align: left;
      background-color: #2F419B;
      color: white;
    }
    .date{
    padding: 10px;
    border-radius: 8px;
    border:1px solid #C0C0C0;
    width:90%;
    margin-bottom: 10px;
}
</style>
<style>
/* * {
  box-sizing: border-box;
}

#myInput {
  background-image: url('/css/searchicon.png');
  background-position: 10px 10px;
  background-repeat: no-repeat;
  width: 100%;
  font-size: 16px;
  padding: 12px 20px 12px 40px;
  border: 1px solid #ddd;
  margin-bottom: 12px;
}

#myTable {
  border-collapse: collapse;
  width: 100%;
  border: 1px solid #ddd;
  font-size: 18px;
}

#myTable th, #myTable td {
  text-align: left;
  padding: 12px;
}

#myTable tr {
  border-bottom: 1px solid #ddd;
}

#myTable tr.header, #myTable tr:hover {
  background-color: #f1f1f1;
} */
</style>
<!-- <div class="page-content--bgf7 pb-5">
    <section class="statistic statistic2">
        <div class="container-fluid">
            <div class="row pb-5">
                <div class="col-md-10 offset-md-1 col-lg-10 offset-md-1 mt-4 pt-1">
                    <select name="system"  class="" data-errors="{filter_required:'Team should not blank'}" TABINDEX="7"  >
                        <option value="">Select System Type</option>
                        <option value="all">All</option>
                        <option value="102"> 102</option>
                        <option value="108"> 108</option>
                    </select>
                    <select name="amb_district"  class="" data-errors="{filter_required:'Team should not blank'}" TABINDEX="7"  >
                            <option value="">Select District</option>
                            <?php foreach($dist as $dst){?>
                               <option value="<?php echo $dst->dst_code;?>"><?php echo $dst->dst_name;?></option>
                            <?php } ?>     
                    </select>
                    <input type="button" name="submit" value="Submit" class="btn btn-primary submit_btnt form-xhttp-request" data-href='<?php echo base_url();?>dashboard/show_ambulance_tracking' data-qr='page_no=<?php echo @$page_no; ?>&amp;output_position=content' >                     
                </div>
            </div>
        </div>
    </section>
</div> -->
<div class="page-content--bgf7 pb-5" style="min-height:550px;">
     <!-- round cirlcle icons start -->
     <!-- STATISTIC-->
    <div class="container-fluid">
        <section class="statistic statistic2">
            <div class="row text-center">
              <div class="col-md-10 offset-md-1 col-lg-10 offset-md-1">  <!--offset-md-1 col-lg-10 offset-md-1-->
                <h3>AMBULANCE REPORT</h3>
              </div>
            </div>
            <form enctype="multipart/form-data" method="post" id="amb_report" action="<?php echo base_url(); ?>dashboard/nhm_amb_report_remote1">
            <div>
         <div class="width30 drg float_left">
                 
                <div class="width100 float_left">
                        <div class="style6 float_left">From: </div>
                    </div>
                    <div class="width100 float_left">
                        <input name="amb_report_from_date" tabindex="1" class="form_input date" placeholder="From Date" type="date" data-base="search_btn" data-errors="{filter_required:'From Date should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" value="" id="from_date">
                    </div>
                </div>
                <div class="width30 drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">To : </div>
                    </div>
                    <div class="width100 float_left">
                        <input name="amb_report_to_date" tabindex="2" class="form_input date " placeholder="To Date" type="date" data-base="search_btn" data-errors="{filter_required:'To Date should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" value=""  id="to_date">
                    </div>
                </div>
                
                <div class="button_box">

                    <!--<input type="submit" name="submit" value="Submit" TABINDEX="3">  -->
                    <input type="submit" style="margin-top:40px;"name="submit"  value="Submit" data-qr="output_position=list_table_amb_div&amp;reports=view&amp;module_name=reports&amp;showprocess=yes" data-href="<?php echo base_url(); ?>dashboard/nhm_amb_report_remote1" class="form-xhttp-request btn clg_search float_left" >
                     </div>
            </div>
            </form>
            <div class="row pb-5" >
                <div class="col-md-12" id="list_table_amb_div1"> <!--offset-md-1 col-lg-10 offset-md-1 mt-4 pt-1-->
                    <table class="list_table_amb" id="myTable" style="text-align: center;">
                        <thead class="" style="">
                            <tr class="table-active">
                            <th scope="col">Ambulance No</th>
                            <th scope="col">Base Location</th>
                            <!--<th scope="col">EMT Name</th>
                            <th scope="col">Current Status</th>
                            <th scope="col">EMT Login Time</th>
                            <th scope="col">EMT Logout Time</th>-->
                            <th scope="col">Pilot Name</th>
                            <th scope="col">Current Status</th>
                            <th scope="col">Pilot Login Time</th>
                            <th scope="col">Pilot Logout Time</th>
                            </tr>
                        </thead>
                        <tbody>
    <?php
    $count = 1;
    if (is_array($amb_data)) {
        foreach ($amb_data as $amb){ 
          $clg_data_p =  get_emso_name($amb->amb_rto_register_no,'P');
         $clg_data_d =  get_emso_name($amb->amb_rto_register_no,'D');

         if($clg_data_p[0]->status==2){
          $Login_status_p = 'Logout';
         }else if($clg_data_p[0]->status==1){
          $Login_status_p = 'Login';
         }
         if($clg_data_d[0]->status==2){
          $Login_status_d = 'Logout';
         }else if($clg_data_d[0]->status==1){
          $Login_status_d = 'Login';
         }
        if($amb->amb_status == 2 ){ 
         
    ?>
    <tr>         
        <td><?php echo $amb->amb_rto_register_no; ?></td>
        <td><?php echo $amb->baselocation; ?></td>
        <!--<td><?php //echo $clg_data_p[0]->clg_first_name.' '.$clg_data_p[0]->clg_last_name; ?> </td>
        <td><?php //echo $Login_status_p; ?></td>
        <td><?php //echo $clg_data_p[0]->login_time; ?> </td>
        <td><?php //echo $clg_data_p[0]->logout_time; ?> </td>-->
        <td><?php echo $clg_data_d[0]->clg_first_name.' '.$clg_data_d[0]->clg_last_name; ?></td>
        <td><?php echo $Login_status_d; ?></td>
        <td><?php echo $clg_data_d[0]->login_time; ?></td>
        <td><?php echo $clg_data_d[0]->logout_time; ?></td>
    </tr>
    <?php  }else{ ?>
    <tr>         
    <td><?php echo $amb->amb_rto_register_no; ?></td>
        <td><?php echo $amb->baselocation; ?></td>
        <!--<td><?php// echo $clg_data_p[0]->clg_first_name.' '.$clg_data_p[0]->clg_last_name; ?> </td>
        <td><?php //echo $Login_status_p; ?></td>
        <td><?php //echo $clg_data_p[0]->login_time; ?> </td>
        <td><?php //echo $clg_data_p[0]->logout_time; ?> </td>-->
        <td><?php echo $clg_data_d[0]->clg_first_name.' '.$clg_data_d[0]->clg_last_name; ?></td>
        <td><?php echo $Login_status_d; ?></td>
        <td><?php echo $clg_data_d[0]->login_time; ?></td>
        <td><?php echo $clg_data_d[0]->logout_time; ?></td>
    </tr>
        <?php    }
        $clg_data_p = '';
        $clg_data_d = '';
     $count++; 
     $amb->amb_rto_register_no = '';
    
    }
    }

    ?>
                        </tbody> 
                    </table>
                </div>
            </div>
        </section>
    </div>
</div>
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
        <div class="row">
            <h4>EMSO</h4><br/>
        </div>
        <div class="row">
            <b class="col-4">Name : </b><label class="col-8" id="emso_name"></label><br/>
        </div>
        <div class="row">
            <b class="col-4">Contact No : </b><label class="col-8" id="emso_mob"></label>
        </div>
        <div class="row">
            <h4>Pilot</h4><br/>
        </div>
        <div class="row">
            <b class="col-4">Name : </b> <label class="col-8" id="driver_name"></label><br/>
        </div>
        <div class="row">
            <b class="col-4">Contact No : </b><label class="col-8" id="driver_mob"></label>
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
        var system = $('#system').val();
        var amb_district = $('#amb_district').val();
        var amb_district1 = $('#amb_district option:selected').text();
        $.post('<?=site_url('dashboard/show_ambulance_tracking1')?>',{system,amb_district},function(data){
            var new_var = JSON.parse(data);
            $('.list_table_amb').html("");
            var raw = '<table class="table table-bordered list_table_amb" id="myTable" style="text-align: center;">'+
                            '<tr class="table-active">'+
                            '<th scope="col">Sr.No</th>'+
                            '<th scope="col">District</th>'+
                            '<th scope="col">Ambulance No</th>'+
                            '<th scope="col">Base Location</th>'+
                            '<th scope="col">Type of Ambulance</th>'+
                            '<th scope="col">App Login</th>'+
                            '<th scope="col">Login Details</th>'+
                            '<th scope="col">Speed</th>'+
                            '<th scope="col">Ignition Status</th>'+
                            '<th scope="col">Incident Status</th>'+
                            '<th scope="col">AVLS Tracking</th>'+
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
                }else{
                    var app_status1 = '<i class="fa fa-mobile-phone" style="font-size:30px;color:red"></i>';
                }
                if(ignition == 'Ignition Off' || ignition == ""){
                    // var checked = "";
                    var checked = "<input type='checkbox' disabled='disabled'>";
                }else{
                    // var checked = "checked";
                    loginavls++;
                    var checked = "<input type='checkbox' disabled='disabled' checked>";
                }
                
               
                if(parameter_count  == 2){
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
                //$time = $inc->assigned_time;
                var status = 'Call Assigned';
                }         
                var raw = "<tr>"+
                "<td>" + j++ + "</td>"+
                "<td>" + new_var[i].dst_name + "</td>"+
                "<td>" + new_var[i].amb_rto_register_no + "</td>"+
                "<td>" + new_var[i].hp_name + "</td>"+
                "<td>" + new_var[i].ambt_name + "</td>"+
                "<td>" + app_status1 + "</td>"+
                "<td><i class='fa fa-address-book' style='font-size:25px;color: #117864;' Onclick='amb("+new_var[i].amb_id+")' ></i></td>"+
                "<td>" + new_var[i].amb_speed + "</td>"+
                "<td><label class='switch'>"+checked+"<span class='slider round'></span></label></td>"+
                "<td>" + status + "</td>"+
                "<td><button class='btn btn-primary' Onclick='track("+new_var[i].amb_id+")'>AVLS</button ></td>"+
                "<td><button class='btn btn-primary' Onclick='mdt("+new_var[i].amb_id+")'>MDT</button ></td>"+
                "</tr>";
                $('#list_table_amb_div tr:last').after(raw);
                
                
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
        $('#map3').html('')
        $('#MDTModal').modal('show');
        mdtloadmap();
      });
    }
    // $('#amb').on('click',function(){
    //     alert('id')
    // });
    function amb(amb_id){
        $.post('<?=site_url('dashboard/get_app_login_user')?>',{amb_id},function(data){
            var new_var = JSON.parse(data);
            for(var i = 0; i < new_var.length; i++){
                if(new_var[i].login_type == "P"){
                    var emsoName = new_var[i].clg_first_name+ new_var[i].clg_mid_name + new_var[i].clg_last_name;
                    $('#emso_name').html(emsoName);
                    $('#emso_mob').html(new_var[i].clg_mobile_no);
                }else{
                    var driverName = new_var[i].clg_first_name+ new_var[i].clg_mid_name + new_var[i].clg_last_name;
                    $('#driver_name').html(driverName);
                    $('#driver_mob').html(new_var[i].clg_mobile_no);
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
    // loadmap();
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