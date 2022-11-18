<!-- <link rel="stylesheet" href="//cdn.leafletjs.com/leaflet-0.7.5/leaflet.css" />
<script type="text/javascript" src="//cdn.leafletjs.com/leaflet-0.7.5/leaflet.js"></script> -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css" integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ==" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet-src.js" integrity="sha512-IkGU/uDhB9u9F8k+2OsA6XXoowIhOuQL1NTgNZHY1nkURnqEGlDZq3GsfmdJdKFe1k1zOc6YU2K7qY+hF9AodA==" crossorigin=""></script>

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
    body {
      margin: 0;
    }
    /* html, body, #leaflet {
      height: 100%;
    } */
    #map {
      width: 900px;
      height: 600px;
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
                <h3>AMBULANCE TRACKING</h3>
              </div>
            </div>
            <div class="row pb-9">
            <div class="col-md-3 ">
                <div class="col-md-12">Select Ambulance Type : </div>
                <div class="col-md-12 "><!---->
                   <select name="amb_type" id="amb_type" data-errors="{filter_required:'Amb type should not blank'}" TABINDEX="7" onchange="ambulance_typewise_load()" >
                            <option value="all">Select Ambulance Type</option>
                            <!-- <option value="all">All</option> -->
                            <?php foreach($amb_type as $ambuance_type){ if($ambuance_type->ambt_id == '3'){?>
                               <option value="<?php echo $ambuance_type->ambt_id ;?>"><?php echo $ambuance_type->ambt_name;?></option>
                            <?php }} ?>  
                            <?php foreach($amb_type as $ambuance_type){ if($ambuance_type->ambt_id == '4'){?>
                               <option value="<?php echo $ambuance_type->ambt_id ;?>"><?php echo $ambuance_type->ambt_name;?></option>
                            <?php }} ?>     
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
                    <input type="button" name="submit" value="Submit" class="btn btn-primary submit_btnt Submit" style="margin-top:25px;">                     
                   <!-- <input type="button" name="Refresh" value="Refresh" class="btn btn-primary submit_btnt form-xhttp-request" data-href='<?php echo base_url();?>dashboard/show_ambulance_tracking_remote' data-qr='page_no=<?php echo @$page_no; ?>&amp;output_position=content' > -->
                    <b style="margin-left: 30px;">Total Ambulance : </b><label id="totalAmb"></label>
                    <b style="margin-left: 30px;">MDT Login : </b><label id="totalMdt"></label>
               
            </div>
            </div>
            <div class="row pb-5" >
                <div class="col-md-12" id="list_table_amb_div"> <!--offset-md-1 col-lg-10 offset-md-1 mt-4 pt-1-->
                    <!-- <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for names.." title="Type in a name"> -->
                    <table class="list_table_amb" id="myTable" style="text-align: center;">
                        <thead class="" style="">
                            <tr class="table-active">
                            <th scope="col">District</th>
                            <th scope="col">Ambulance No</th>
                            <th scope="col">Base Location / Ward Name</th>
                            <th scope="col">Login Details</th>
                            <!-- <th scope="col">Type of Ambulance</th> -->
                            <!-- <th scope="col">App Login</th> -->
                            
                            <!-- <th scope="col">Incident Status</th> -->
                            <!--<th scope="col">Ignition Status</th>
                            <th scope="col">AVLS Tracking</th>-->
                            <th scope="col" colspan="2">EMT</th>
                            <th scope="col" colspan="2">Pilot</th>
                            <th scope="col" colspan="2">GPS Tracking</th>
                            <th scope="col">Availability</th>
                            </tr>
                            <tr>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th>Status</th>
                              <th>Track</th>
                              <th>Status</th>
                              <th>Track</th>
                              <th></th>
                              <th></th>
                              <th></th>
                            </tr>
                        </thead>
                        <?php
                        // foreach ($amb_data as $amb) {
                          // $amb_location = $amb->hp_name;
                          // if($amb_location == null)
                          // {
                          //   $amb_location = $amb->wrdnm;
                          // }
                          // $app_status = $amb->app_status;
                          // $parameter_count = $amb->parameter_count;
                          // if($app_status == '1'){
                          //   //loginmdt++;
                          //   $app_status1 = '<i class="fa fa-mobile-phone" style="font-size:30px;color:green"></i>';
                          //   if($parameter_count  == 1){
                          //     //$time = $inc->start_from_base_loc;
                          //     $status = 'Call Assigned';
                          //      }
                          //     else if($parameter_count  == 2){
                          //     //$time = $inc->start_from_base_loc;
                          //     $status = 'Start From Base';
                          //     }else if($parameter_count  == 3){
                          //     //$time = $inc->at_scene;
                          //     $status = 'At Scene';
                          //     }else if($parameter_count  == 4){
                          //     //$time = $inc->from_scene;
                          //     $status = 'From Scene';
                          //     }else if($parameter_count  == 5){
                          //     //$time = $inc->at_hospital;
                          //     $status = 'At Hospital';
                          //     }else if($parameter_count  == 6){
                          //     //$time = $inc->patient_handover;
                          //     $status = 'Patient Handover';
                          //     }else if($parameter_count  == 7){
                          //     //$time = $inc->back_to_base_loc;
                          //     $status = 'Available';
                          //     }else{
                          //       $status = 'Login';
                          //     }
                          // }else{
                          //   $app_status1 = '<i class="fa fa-mobile-phone" style="font-size:30px;color:red"></i>';
                          //   $status = 'Logout';
                          // }

                        ?>
                        <!-- <tbody id="">
                        <td scope="col"><?php echo $amb->dst_name; ?></td>
                        <td scope="col"><?php echo $amb->amb_rto_register_no; ?></td>
                        <td scope="col"><?php echo $amb_location; ?></td>
                        <td scope="col"><?php if($status == 'Logout') { echo '-';}else{?><i class='fa fa-address-book' style='font-size:25px;color: #117864;' Onclick='amb(<?php echo $amb->amb_id; ?>)' ><?php }?></i></td>
                       
                        <td scope="col"><?php echo $app_status1; ?></td>
                        <td scope="col"><?php if($status == 'Logout') { echo '-';}else{?><button class='btn btn-primary' Onclick='mdt(<?php echo $amb->amb_id; ?>)'>MDT</button ><?php }?></td>
                        <td scope="col"><?php echo $app_status1; ?></td>
                        <td scope="col"><?php if($status == 'Logout') { echo '-';}else{?><button class='btn btn-primary' Onclick='mdtemt(<?php echo $amb->amb_id; ?>)'>MDT</button ><?php }?></td>
                        </tbody>  -->
                        <?php 
                        // } $status=''; ?>
                        
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
        <!--<button type="button" class="btn btn-primary">Save changes</button>-->
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
        <!-- <div id="map"></div> -->
       <div id="data_not_found"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <!--<button type="button" class="btn btn-primary">Save changes</button>-->
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<!-- Modal -->
<div class="modal fade modalid" id="MDTModal1" tabindex="-1" role="dialog" >
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
        <!-- <div id="map3" style="width: 900px; height: 600px; border:0px;">
        </div> -->
        <div id="map"></div>
       <div id="data_not_found"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
            <h4>EMT</h4><br/>
        </div>
        <div class="row">
            <b class="col-4">Name : </b><label class="col-8" id="emso_name"></label><br/>
        </div>
        <div class="row">
            <b class="col-4">Contact No : </b><label class="col-8" id="emso_mob"></label>
        </div>
        <div class="row">
            <b class="col-4">Login Time : </b><label class="col-8" id="emtlogin_time"></label>
        </div>
        <div class="row">
            <b class="col-4">Logout Time : </b><label class="col-8" id="emtlogout_time"></label>
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
<input type="hidden" id="mdt_user">
<input type="hidden" id="mdt_pilot">
<input type="hidden" id="mdt_emt">

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
          console.log(data);
           var new_var = JSON.parse(data);
            $('.list_table_amb').html("");
            var raw = '<table class="table table-bordered list_table_amb" id="myTable" style="text-align: center;">'+
                            '<thead class="" style="">'+
                            '<tr class="table-active">'+
                            // '<th scope="col">Sr.No</th>'+
                            '<th scope="col">District</th>'+
                            '<th scope="col">Ambulance No</th>'+
                            '<th scope="col">Base Location / Ward Name</th>'+
                            // '<th scope="col">Type of Ambulance</th>'+
                            // '<th scope="col">App Login</th>'+
                            '<th scope="col">Login Details</th>'+
                            //'<th scope="col">Speed</th>'+
                            //'<th scope="col">Ignition Status</th>'+
                            // '<th scope="col">Incident Status</th>'+
                            //'<th scope="col">AVLS Tracking</th>'+
                            '<th scope="col" colspan="2">EMT</th>'+
                            '<th scope="col" colspan="2">Pilot</th>'+
                            '<th scope="col" >GPS Tracking</th>'+
                            '<th scope="col" >Availability</th>'+
                            '</tr>'+
                            '<tr>'+
                              '<th></th>'+
                              '<th></th>'+
                              '<th></th>'+
                              '<th></th>'+
                              '<th>Status</th>'+
                              '<th>Track</th>'+
                              '<th>Status</th>'+
                              '<th>Track</th>'+
                              '<th></th>'+
                              '<th></th>'+
                            '</tr>'+
                            '</thead>'+
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
                    // var app_status1 = '<i class="fa fa-mobile-phone" style="font-size:30px;color:green"></i>';
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
                    // var app_status1 = '<i class="fa fa-mobile-phone" style="font-size:30px;color:red"></i>';
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
                
                var userlogindetails = (JSON.parse("["+new_var[i].logindetails+"]"));
                //console.log(userlogindetails);
                var loginmdt1 = 0;
                // alert(userlogindetails.length);
                for(var j = 0; j < userlogindetails.length; j++){
                  if(userlogindetails[j].logintype == "D"){
                    // alert('D');
                    var pilotmdt = "<button class='btn btn-primary' Onclick='mdt("+new_var[i].amb_id+")'>Track</button >";
                    var pilotlogin = '<i class="fa fa-mobile-phone" style="font-size:30px;color:green"></i>';
                    var pilotadd = '1';
                    loginmdt1++;
                    if(userlogindetails.length == 1 && userlogindetails[j].logintype == "D"){
                      var emtmdt = "-"
                      var emtlogin = '<i class="fa fa-mobile-phone" style="font-size:30px;color:red"></i>'; 
                    }
                  }else if(userlogindetails[j].logintype == "P"){
                    // alert('P');
                    var emtmdt = "<button class='btn btn-primary' Onclick='mdtemt("+new_var[i].amb_id+")'>Track</button >";
                    var emtlogin = '<i class="fa fa-mobile-phone" style="font-size:30px;color:green"></i>';
                    var emtadd = '1';
                    loginmdt1++;
                    if(userlogindetails.length == 1 && userlogindetails[j].logintype == "P"){
                      var pilotmdt = "-";
                      var pilotlogin = '<i class="fa fa-mobile-phone" style="font-size:30px;color:red"></i>';
                    }
                  }else{
                    var emtadd = '0';
                    var pilotadd = '0';
                  }
                }
		if(loginmdt1 == 0){
                  var pilotlogin = '<i class="fa fa-mobile-phone" style="font-size:30px;color:red"></i>';
                  var emtlogin = '<i class="fa fa-mobile-phone" style="font-size:30px;color:red"></i>';
                  var pilotmdt = "-";
                  var emtmdt = "-"
                }
                if((pilotadd == '0') && (emtadd == '0')){
                  var login_pilot_emt_details = '-';
                }else{
                  var login_pilot_emt_details = "<i class='fa fa-address-book' style='font-size:25px;color: #117864;' Onclick='amb("+new_var[i].amb_id+")' ></i>";
                }
                
                // if(status == 'Logout'){
                  // var addressbook = "-";
                  // var pilotmdt = "-";
                  // var emtmdt = "-"
                // }else{
                  // var addressbook = "<i class='fa fa-address-book' style='font-size:25px;color: #117864;' Onclick='amb("+new_var[i].amb_id+")' ></i>";
                  // var pilotmdt = "<button class='btn btn-primary' Onclick='mdt("+new_var[i].amb_id+")'>MDT</button >";
                  // var emtmdt = "<button class='btn btn-primary' Onclick='mdtemt("+new_var[i].amb_id+")'>MDT</button >";
                // }
                var raw = "<tr>"+
                // "<td>" + j++ + "</td>"+
                "<td>" + new_var[i].dst_name + "</td>"+
                "<td>" + new_var[i].amb_rto_register_no + "</td>"+
                "<td>" + amb_location + "</td>"+
                "<td>" + login_pilot_emt_details + "</td>"+
               // "<td>" + new_var[i].amb_speed + "</td>"+
               // "<td><label class='switch'>"+checked+"<span class='slider round'></span></label></td>"+
                "<td>" + emtlogin + "</td>"+
               // "<td><button class='btn btn-primary' Onclick='track("+new_var[i].amb_id+")'>AVLS</button ></td>"+
               "<td>" + emtmdt + "</td>"+
               "<td>" + pilotlogin + "</td>"+
               "<td>" + pilotmdt + "</td>"+
               "<td><button class='btn btn-primary' Onclick='track("+new_var[i].amb_id+")'>Track</button ></td>"+
               "<td><button class='btn btn-primary' Onclick='alltrack("+new_var[i].amb_id+")'>Track</button ></td>"+
                 "</tr>";
                $('#list_table_amb_div tr:last').after(raw);
                var status='';
               
            }
            $('#totalAvls').html(loginavls);
            $('#totalMdt').html(loginmdt1);
            // $('#totalMdt').html(loginmdt);
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
      $('#MDTModal1').modal('hide');
      
    }
    var veh;
    var user1;
    function mdt(amb_id){
      $('#map').hide();
      var user = "pilot";
      var space = 1;
      $.post('<?=base_url('dashboard/get_amb_no')?>',{amb_id,space},function(data){
        $('#mdt_veh').val(data);
        $('#mdt_user').val(user);
        veh += data;
        user1 += user;
        $('#map3').html('');
        $('#MDTModal').modal('show');
        $('#MDTModal1').modal('hide');
      
        mdtloadmap();
      });
    }
    function mdtemt(amb_id){
      $('#map').hide();
      var user = "emt";
      var space = 1;
      $.post('<?=base_url('dashboard/get_amb_no')?>',{amb_id,space},function(data){
        $('#mdt_veh').val(data);
        $('#mdt_user').val(user);
        veh += data;
        user1 += user;
        $('#map3').html('');
        $('#MDTModal').modal('show');
        $('#MDTModal1').modal('hide');
        mdtloadmap();
      });
    }
    // $('#amb').on('click',function(){
    //     alert('id')
    // });
    function amb(amb_id){
        $.post('<?=site_url('dashboard/get_app_login_user_remote')?>',{amb_id},function(data){
            var new_var = JSON.parse(data);
            console.log(data);
            for(var i = 0; i < new_var.length; i++){
                if(new_var[i].login_type == "P"){
                    var emsoName = new_var[i].clg_first_name+ new_var[i].clg_mid_name + new_var[i].clg_last_name;
                    $('#emso_name').html(emsoName);
                    $('#emso_mob').html(new_var[i].clg_mobile_no);
                   $('#emtlogin_time').html(new_var[i].login_time);
                   if(new_var[i].logout_time != "0000-00-00 00:00:00"){
                    $('#emtlogout_time').html(new_var[i].logout_time);
                   }else{
                    $('#emtlogout_time').html('-');
                   }
                }else{
                    var driverName = new_var[i].clg_first_name+ new_var[i].clg_mid_name + new_var[i].clg_last_name;
                    $('#driver_name').html(driverName);
                    $('#driver_mob').html(new_var[i].clg_mobile_no);
                    $('#login_time').html(new_var[i].login_time);
                    if(new_var[i].logout_time != "0000-00-00 00:00:00"){
                      $('#logout_time').html(new_var[i].logout_time);
                    }else{
                      $('#logout_time').html('-');
                    }
                }
            }
            $('#logindetails').modal('show');
        });
    }
    var vehicle_pin = new H.map.Icon(base_url + "themes/backend/images/select_icon_pin.png");
    var pilot_pin = new H.map.Icon(base_url + "themes/backend/images/pilot.png");
    var emt_pin = new H.map.Icon(base_url + "themes/backend/images/doctor.png");
    var pilot1;
    var emt1;
    var map;
    var markerLatLng;
    var packetdatetime;
    function alltrack(amb_id){
      // alert(base_url);
      $('#MDTModal').modal('hide');
      $('#MDTModal1').modal('show');
      $('#map').empty();
      $('#data_not_found').hide();
        $('#map3').hide();
       
        
        $('#map').show();
        
        var pilot = "pilot";
        var emt = "emt";
        var space = 1;
        
        $.post('<?=base_url('dashboard/get_amb_no')?>',{amb_id,space},function(data){
          $('#mdt_veh').val(data);
          $('#mdt_pilot').val(pilot);
          $('#mdt_emt').val(emt);
          veh += data;
          pilot1 += pilot;
          emt1 += emt;
          // map.removeLayer();
          if(map != undefined || map != null){
            map.remove();
            $("#map").html("");
          }
          alltrackmap();
          // loadmap();
        });
    }
    var markerLatLng;
    var map_mark_pin;
    var html;
    function loadmap(){
      $('#map3').html('');
      //var myLatLng = { lat: 19.0760, lng: 72.8777 };
      var myLatLng = {lat: 23.23979546250735, lng: 77.39215854006432};
      $A_Platform = new H.service.Platform({
          apikey: 'yrjPrIYd0xU9KJpe1xlaR1_K1wFrwc9U-_-99n040JQ',
      });
      var defaultLayers = $A_Platform.createDefaultLayers();
      $AllMap = new H.Map( document.getElementById('map3'),
          defaultLayers.vector.normal.map, {
          center: myLatLng,
          zoom: 8,
          pixelRatio: window.devicePixelRatio || 1
      });
      var behavior = new H.mapevents.Behavior(new H.mapevents.MapEvents($AllMap));
      $AllMap.tagId = 'map3';
      window.addEventListener('resize', () => $AllMap.getViewPort().resize());
      $AllMapUI = H.ui.UI.createDefault($AllMap, defaultLayers);
      
      initmarker();
      // addInfoBubble(markerLatLng="", map_mark_pin="", html="");   
    }
    function initmarker(){
      var veh = $('#mdt_veh').val();
      var pilot = $('#mdt_pilot').val();
      var emt = $('#mdt_emt').val();
      $.post('<?=base_url('avls/get_all_live_data')?>',{veh:veh,pilot:pilot,emt:emt},function(result){
        console.log(result);
        var gpsdata = JSON.parse(result);
        var amblatlng = gpsdata['amb1'];
        var pilotlatlng = gpsdata['pilot1'];
        var emtlatlng = gpsdata['emt1'];
        if(amblatlng != ''){
          markerLatLng = parseFloat(amblatlng[0].amb_lat)+','+parseFloat(amblatlng[0].amb_log);
          map_mark_pin = vehicle_pin;
          packetdatetime = amblatlng[0].amb_packet;
          // addInfoBubble(markerLatLng, map_mark_pin,atob(packetdatetime));
        }
        if(pilotlatlng != ''){
          markerLatLng = parseFloat(pilotlatlng[0].amb_lat)+','+parseFloat(pilotlatlng[0].amb_log);
          map_mark_pin = pilot_pin;
          packetdatetime = amblatlng[0].amb_packet;
          // addInfoBubble(markerLatLng, map_mark_pin,atob(packetdatetime));
        }
        if(emtlatlng != ''){
          markerLatLng = parseFloat(emtlatlng[0].amb_lat)+','+parseFloat(emtlatlng[0].amb_log);
          map_mark_pin = emt_pin;
          packetdatetime = amblatlng[0].amb_packet;
          // addInfoBubble(markerLatLng, map_mark_pin,atob(packetdatetime));
        }

        
      });
    }
    function addInfoBubble(markerLatLng, map_mark_pin, html) {
      console.log('hhh'+map_mark_pin);
      console.log('hhh'+html);
      if(markerLatLng == '' || markerLatLng == null){
          return false;
      }
      $Allgroup = new H.map.Group();
      $AllMap.addObject($Allgroup); 
      var parisMarker = new H.map.Marker(markerLatLng, {icon :map_mark_pin});
      parisMarker.addEventListener('pointerenter', function (evt) {
        var bubble =  new H.ui.InfoBubble(markerLatLng, {
          content: html
        });
        $AllMapUI.getBubbles().forEach(bub => $AllMapUI.removeBubble(bub));
        $AllMapUI.addBubble(bubble);
      }, false);
      $Allgroup.addObject(parisMarker);
      setTimeout(function(){
        initmarker(); 
      },1000);
    }
    function alltrackmap1(){
      var map = L.map('map').setView([19.601194,75.552979], 8);
            var osmUrl = 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
            var osmLayer = new L.TileLayer(osmUrl, {
                maxZoom: 819,
                attribution: 'Map data © OpenStreetMap contributors'
            });
      var veh = $('#mdt_veh').val();
      var pilot = $('#mdt_pilot').val();
      var emt = $('#mdt_emt').val();
      var amb_timer = setInterval(function () {
        // var map = L.map('map').setView([19.601194,75.552979], 8);
        $.post('<?=base_url('avls/get_all_live_data')?>',{veh:veh,pilot:pilot,emt:emt},function(result){
          
          points=[];
            var gpsdata = JSON.parse(result);
            var amblatlng = gpsdata['amb1'];
            var pilotlatlng = gpsdata['pilot1'];
            var emtlatlng = gpsdata['emt1'];
            var container = L.DomUtil.get('map');
            
            var map = L.map('map').setView([19.601194,75.552979], 8);
            var osmUrl = 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
            var osmLayer = new L.TileLayer(osmUrl, {
                maxZoom: 819,
                attribution: 'Map data © OpenStreetMap contributors'
            });
            //Boolean who let me delete marker
            let deleteBool = false

            //Button function to enable boolean
            button.addEventListener('click',()=>{
              deleteBool = true
            })

            // Function to delete marker 
            const deleteMarker = (e) => {
                if (deleteBool) {
                    e.target.removeFrom(map)
                    deleteBooly = false
                }
            }
            //Initiate map
            // var map = L.map('map').setView([51.505, -0.09], 13);

            //Create one marker
            let marker = L.marker([amblatlng[0].amb_lat,amblatlng[0].amb_log],{icon: ambIcon},{title:"marker_1"}).addTo(map).bindPopup("Marker 1");
            //Add Marker Function
            // marker.on('click', deleteMarker)
        });
      },1000);
    }
    function alltrackmap(){
      $('#map3').hide();
      
      var veh = $('#mdt_veh').val();
      var pilot = $('#mdt_pilot').val();
      var emt = $('#mdt_emt').val();
      
      $('#MDTModal1').modal('show');
      // var markers;
      var iss;
      var markers = [];
      var marker1;
      // for (i=0;i<markers.length;i++) {
      //       map.removeLayer(markers[i]);
      //     }
      
      // var amb_timer = setInterval(function () {
        // var markers = {};
         
          $.post('<?=base_url('avls/get_all_live_data')?>',{veh:veh,pilot:pilot,emt:emt},function(result){
            // console.log(result);
            var gpsdata = JSON.parse(result);
            var amblatlng = gpsdata['amb1'];
            var pilotlatlng = gpsdata['pilot1'];
            var emtlatlng = gpsdata['emt1'];
            // var amblatlng1;
            // var pilotlatlng1;
            // var emtlatlng1;
            if(amblatlng != ''){
              // var amblat = amblatlng[0].amb_lat;
              // var amblog = amblatlng[0].amb_log;
              var amblatlng1 = parseFloat(amblatlng[0].amb_lat)+','+parseFloat(amblatlng[0].amb_log);
            }
            if(pilotlatlng != ''){
              // var amblat = pilotlatlng[0].amb_lat;
              // var amblog = pilotlatlng[0].amb_log;
              var pilotlatlng1 = parseFloat(pilotlatlng[0].amb_lat)+','+parseFloat(pilotlatlng[0].amb_log);
            }
            if(emtlatlng != ''){
              // var amblat = emtlatlng[0].amb_lat;
              // var amblog = emtlatlng[0].amb_log;
              var emtlatlng1 = parseFloat(emtlatlng[0].amb_lat)+','+parseFloat(emtlatlng[0].amb_log);
            }
             console.log('emt'+emtlatlng1);
            if (gpsdata != '') {
              //console.log(amblatlng1);
              
                map = L.map('map').setView([19.601194,75.552979], 8);
                var osmUrl = 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
                var osmLayer = new L.TileLayer(osmUrl, {
                    maxZoom: 819,
                    attribution: 'Map data © OpenStreetMap contributors'
                });
                var ambIcon = new L.Icon({
                  iconUrl: base_url + "themes/backend/images/select_icon_pin.png",
                  shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                  iconSize: [25, 41],
                  iconAnchor: [12, 41],
                  popupAnchor: [1, -34],
                  shadowSize: [41, 41]
                });
                var pilotIcon = new L.Icon({
                  iconUrl: base_url + "themes/backend/images/pilot.png",
                  shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                  iconSize: [25, 41],
                  iconAnchor: [12, 41],
                  popupAnchor: [1, -34],
                  shadowSize: [41, 41]
                });
                var emtIcon = new L.Icon({
                  iconUrl: base_url + "themes/backend/images/doctor.png",
                  shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                  iconSize: [25, 41],
                  iconAnchor: [12, 41],
                  popupAnchor: [1, -34],
                  shadowSize: [41, 41]
                });
                
                map.addLayer(osmLayer);
                
                // remove previous marker
                // if (markers.length > 0) {
                //   map.removeLayer(markers.pop());
                // }
                // var id = amblatlng[0].amb_lat;
                // var latLng = [amblatlng[0].amb_lat, amblatlng[0].amb_log];
                // var popup = '<b><span> Name:</span>' + id + '</b>';

                // var latitude = amblatlng[0].amb_lat;
                // var longitude = amblatlng[0].amb_log;
                // if (!iss) {
                //     iss = L.marker([latitude,longitude]).bindPopup("I am the ISS").addTo(map);
                // }
                // iss.setLatLng([latitude,longitude]).update();
                // setTimeout(update_position, 1000);
                // if (!markers[id]) {
                //   alert('1');
                //   // If there is no marker with this id yet, instantiate a new one.
                //   markers[id] = L.marker(latLng).addTo(map).bindPopup(popup);
                //   return false;
                // } else {
                //   alert('2');
                //   // If there is already a marker with this id, simply modify its position.
                //   markers[id].setLatLng(latLng).setPopupContent(popup);
                // }
                
                var marker1 = L.marker([amblatlng[0].amb_lat,amblatlng[0].amb_log],{icon: ambIcon},{title:"Vehicle"}).addTo(map).bindPopup("Vehicle");
                // markers.addTo(map).bindPopup("Marker 1");
                markers.push(marker1);
                // markers.push(marker1);
                var marker2 = L.marker([pilotlatlng[0].amb_lat,pilotlatlng[0].amb_log],{icon: pilotIcon},{title:"Pilot"}).addTo(map).bindPopup("Pilot");
                markers.push(marker2);
                var marker3 = L.marker([emtlatlng[0].amb_lat,emtlatlng[0].amb_log],{icon: emtIcon},{title:"EMT"}).addTo(map).bindPopup("EMT");
                markers.push(marker3);
                // $('#map').show();
                // $('#data_not_found').hide();
                // $.each(gpsdata, function (index, ambdata) {
                //     addMarkersToMap(ambdata.amb_lat,ambdata.amb_log);
                //     try{
                //         //resetmarker($google_map_obj,ambdata.amb_rto_register_no,ambdata.amb_lat,ambdata.amb_log); 
                //     }catch(e){
                //     }
                // });
            }else{
                $('#map').hide();
                // $('#data_not_found').show();
                // $('#data_not_found').html('Packetdatetime not received from last 30 minutes');
                return false;
            }
            
          });
        // }, 10000);
        
        // markers.pop(marker1);
        // map.removeLayer(markers);
        // update_position();
        // map.removeLayer(marker1)
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
                    var user = $('#mdt_user').val();
                    $.post('<?=base_url('avls/get_live_data')?>',{veh:veh,user:user},function(result){
                        var gpsdata = JSON.parse(result);
                        // alert(result);
                        if (gpsdata != '') {
				                $('#map3').show();
                          	$('#data_not_found').hide();
                            $.each(gpsdata, function (index, ambdata) {
                                addMarkersToMap(ambdata.amb_lat,ambdata.amb_log);
                                try{
                                    //resetmarker($google_map_obj,ambdata.amb_rto_register_no,ambdata.amb_lat,ambdata.amb_log); 
                                }catch(e){
                                }
                            });
                        }else{
                            $('#map3').hide();
                            $('#data_not_found').show();
                            $('#data_not_found').html('Packetdatetime not received from last 30 minutes');
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