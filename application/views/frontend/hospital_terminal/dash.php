<div class="container my-4">
<div class="row">
    <div class="col-1"></div>
    <div class="col-1.5"><label>Select For Serch</label></div>
    <div class="col-2">
        <select class="form-control" name="dropselect" id="dropselect" onchange="drpdown();">
            <option>Select Option</option>
            <option value="1">Incident ID</option>
        </select>
    </div>
    <div class="col-2" id="inc_id_div" style="display:none">
        <input class="form-control" placeholder="Enter Incident ID" id="inc_id" >
    </div>
    <div class="col-2" id="serch_btn" style="display:none">
    <button onclick="serch_records();" type="button" class="btn">Serch</button>
</div>
</div><br>
<div class="row">
    <div class="col-12">
        <table class="table table-sm table-striped table-bordered hosp-table text-center text-nowrap list_table_amb">
        <thead class="">
            <tr>
            <th scope="col" style="width:15% !important;">No</th>
            <th scope="col" style="width:15% !important;">Patient Name</th>
            <th scope="col" style="width:15% !important;">Incident ID</th>
            <th scope="col" style="width:15% !important;">Ambulance</th>
            <th scope="col" style="width:15% !important;">Complaint</th>
         <!--   <th scope="col">Bed Type</th>-->
<!--            <th scope="col">Arrival</th>-->
            <th scope="col" style="width:15% !important;">Action</th>
            </tr>
        </thead>
        <tbody class="align-middle">
      
        <?php $i=1;
         
         foreach($inc as $inc) { 
           
            $epcr_details = get_inc_details($inc->inc_ref_id);
          
            ?>
            <?php                      
                            $str = preg_replace('/\D/', '', $duration);
                            $newtimestamp = strtotime(''.$inc->admitted_time .' + '.$str.' minute');
                            $arrival_time = date('Y-m-d H:i:s', $inc->admitted_time); ?>
            
                    <tr data-toggle="collapse" data-target="<?php echo "#".$i; ?>">
                        <td><?php echo $i; ?></th>
                        <td><?php echo $inc->ptn_fname." ".$inc->ptn_lname; ?></td>
                        <td><?php echo $inc->inc_ref_id; ?></td>
                        <td><?php echo $inc->amb_rto_register_no; ?></td>
                        <td style="white-space:normal;"><?php echo $inc->ct_type; ?></td>
                    <!--    <td style="white-space:normal;"><?php echo $inc->bed_nm; ?></td>-->
                       
<!--                        <td><?php  ?></td>-->
                        <td>
                        <button class="btn btn-xl btn-warning" data-veh='<?php echo $inc->amb_rto_register_no; ?>' data-hp_lat='<?php echo $hosp[0]->hp_lat; ?>' data-hp_lng='<?php echo $hosp[0]->hp_long;?>' data-inc_lat='<?php echo $inc->inc_lat; ?>' data-inc_lng='<?php echo $inc->inc_long;?>' data-toggle="modal" data-target="#admit_patient"> Admit Patient</button>
                        <button class="btn btn-xl btn-warning" data-veh='<?php echo $inc->amb_rto_register_no; ?>' data-hp_lat='<?php echo $hosp[0]->hp_lat; ?>' data-hp_lng='<?php echo $hosp[0]->hp_long;?>' data-amb_lat='<?php echo $inc->amb_lat; ?>' data-amb_lng='<?php echo $inc->amb_log;?>'  data-inc_lat='<?php echo $inc->inc_lat; ?>' data-inc_lng='<?php echo $inc->inc_long;?>' data-toggle="modal" data-target="#track">Track</button>
                        <!--<button class="btn btn-xl btn-warning" data-veh='<?php echo $inc->amb_rto_register_no; ?>' data-hp_lat='<?php echo $hosp[0]->hp_lat; ?>' data-hp_lng='<?php echo $hosp[0]->hp_long;?>' data-inc_lat='<?php echo $inc->inc_lat; ?>' data-inc_lng='<?php echo $inc->inc_long;?>' data-toggle="modal" data-target="#otp">OTP Verification</button>-->
                    </td>
                    
                    </tr>
               
            
                <tr id="<?php echo $i; ?>" class="collapse hosp-info">
                <!-- <td></td> -->
                    <td colspan="2">
                   

                    <div class="card bg-info text-white">
                    <div class="card-header bg-dark">Patient Information</div>
                        <div class="card-body">
                        
                            <div class="row text-left">
                                <div class="col-4">Name: </div>
                                <div class="col-6"><?php echo $inc->ptn_fname." ".$inc->ptn_lname; ?></div>
                            </div>
                            
                            <div class="row text-left">
                                <div class="col-4">Age: </div>
                                <div class="col-6"><?php echo $inc->ptn_age; ?></div>
                            </div>

                            <div class="row text-left">
                                <div class="col-4">Complaint: </div>
                                <div class="col-6"><?php echo $inc->ct_type; ?></div>
                            </div>

                            <div class="row text-left">
                                <div class="col-4">Condition: </div>
                                <div class="col-6"><?php echo $inc->ptn_condition?: 'Not Available'; ?></div>
                            </div>
                        
                        </div>
                    </div>
                    <div class="card bg-danger text-white">
                    <div class="card-header bg-dark">Incident Information</div>
                        <div class="card-body">
                        
                            <div class="row text-left">
                                <div class="col-4">Incident ID: </div>
                                <div class="col-6"><?php echo $inc->inc_ref_id; ?></div>
                            </div>
                            
                            <div class="row text-left">
                                <div class="col-4">Chief Complaint: </div>
                                <div class="col-6"><?php echo $inc->ct_type; ?></div>
                            </div>

                            <div class="row text-left">
                                <div class="col-4">Dispatch Time: </div>
                                <div class="col-6"><?php echo $inc->inc_datetime; ?></div>
                            </div>

                            <div class="row text-left">
                                <div class="col-4">Address: </div>
                                <div class="col-6"><?php echo $inc->inc_address; ?></div>
                            </div>

                        </div>
                    </div>
                    </td>
                    <td colspan="2">
                    <div class="card bg-secondary text-white">
                    <div class="card-header bg-dark">Initial Condition</div>
                        <div class="card-body">
                        
                            <div class="row text-left">
                                <div class="col-4">Airway: </div>
                                <div class="col-6"><?php echo $epcr_details[0]->ini_airway; ?></div>
                            </div>
                            <div class="row text-left">
                                <div class="col-4">LOC: </div>
                                <div class="col-6"><?php echo $epcr_details[0]->ini_airway; ?></div>
                            </div>
                            
                            <div class="row text-left">
                                <div class="col-4">Breathing: </div>
                                <?php if($epcr_details[0]->ini_breathing != ''){ ?>
                                <div class="col-6"><?php echo $epcr_details[0]->ini_breathing.'/'.$epcr_details[0]->ini_breathing_txt; ?></div>
                                <?php } ?>
                            </div>

                            <div class="row text-left">
                                <div class="col-4">Oxy Sat: </div>
                                <?php if($epcr_details[0]->ini_oxy_sat_get_nf != ''){ ?>
                                <div class="col-6"><?php echo $epcr_details[0]->ini_oxy_sat_get_nf.'/'.$epcr_details[0]->ini_oxy_sat_get_nf_txt; ?></div>
                                <?php } ?>
                            </div>

                            <div class="row text-left">
                                <div class="col-4">Pulse: </div>
                                <?php if($epcr_details[0]->ini_cir_pulse_p != ''){ ?>
                                <div class="col-6"><?php echo $epcr_details[0]->ini_cir_pulse_p.' '.$epcr_details[0]->ini_cir_pulse_p_txt; ?></div>
                                <?php } ?>
                            </div>
                            <div class="row text-left">
                                <div class="col-4">Repiression: </div>
                                <div class="col-6"><?php echo $epcr_details[0]->ini_respiression; ?></div>
                            </div>
                            <div class="row text-left">
                                <div class="col-4">Cap Refill Sec: </div>
                                <div class="col-6"><?php echo $epcr_details[0]->ini_cir_cap_refill_tsec; ?></div>
                            </div>
                            <div class="row text-left">
                                <div class="col-4">BP Sys-dia: </div>
                                <?php if($epcr_details[0]->ini_con_circulation_radial != ''){ ?>
                                <div class="col-6"><?php echo $epcr_details[0]->ini_bp_sysbp_txt.'/'.$epcr_details[0]->ini_bp_dysbp_txt; ?></div>
                                <?php } ?>
                            </div>
                            <div class="row text-left">
                                <div class="col-4">Con Injury: </div>
                                <div class="col-6"><?php 
                                 $injury=json_decode($epcr_details[0]->ini_con_injury);
                                 //var_dump($injury);
                                 if($injury){
                                 foreach($injury as $inj){
                                    $inj_data[]=$inj->name;
                                 }
                                echo implode("','",$inj_data);
                                }else{
                                    echo '';
                                } ?></div>
                            </div>
                            <div class="row text-left">
                                <div class="col-4">Cir. Radial/Cartid: </div>
                                <?php if($epcr_details[0]->ini_con_circulation_radial != ''){ ?>
                                <div class="col-6"><?php echo $epcr_details[0]->ini_con_circulation_radial.'/'.$epcr_details[0]->ini_con_circulation_carotid; ?></div>
                                <?php } ?>
                            </div>
                            <div class="row text-left">
                                <div class="col-4">Temp: </div>
                                <div class="col-6"><?php echo $epcr_details[0]->ini_con_temp; ?></div>
                            </div>
                            <div class="row text-left">
                                <div class="col-4">BSL: </div>
                                <div class="col-6"><?php echo $epcr_details[0]->ini_con_bsl; ?></div>
                            </div>
                            <div class="row text-left">
                                <div class="col-4">GCS: </div>
                                <div class="col-6"><?php echo $epcr_details[0]->ini_con_gcs; ?></div>
                            </div>
                            <div class="row text-left">
                                <div class="col-4">Skin: </div>
                                <div class="col-6"><?php echo $epcr_details[0]->ini_con_skin; ?></div>
                            </div>
                            <div class="row text-left">
                                <div class="col-4">Pupils-Left: </div>
                                <div class="col-6"><?php echo $epcr_details[0]->pp_type_left; ?></div>
                            </div>
                            <div class="row text-left">
                                <div class="col-4">Pupils-Right: </div>
                                <div class="col-6"><?php echo $epcr_details[0]->pp_type_right; ?></div>
                            </div>

                        </div>
                    </div>
                    </td>
                    <td colspan="2">
                    <div class="card bg-secondary text-white">
                    <div class="card-header bg-dark">Ongoing Condition</div>
                    <div class="card-body">
                        
                            <!--<div class="row text-left">
                                <div class="col-4">Airway: </div>
                                <div class="col-6"><?php 
                                echo $epcr_details[0]->ong_pos_airway;
                               
                                ?></div>
                            </div>-->
                            
                            <div class="row text-left">
                                <div class="col-4">Intervention: </div>
                                <div class="col-6"><?php 
                                $tervention=json_decode($epcr_details[0]->ong_intervention);
                                if($tervention){
                                    $inter_data = array();
                                foreach($tervention as $data){
                                    $inter_data1 = get_intervention_details($data->id);
                                   $inter_data[]=$inter_data1[0]->name;
                                }
                               $inter_data = implode("','",$inter_data);
                               }else{
                                $inter_data = '';   
                               }
                                echo $inter_data.' '.$epcr_details[0]->other_ong_intervention; ?></div>
                            </div>

                            <div class="row text-left">
                                <div class="col-4">Suction: </div>
                                <div class="col-6"><?php echo $epcr_details[0]->ong_suction; ?></div>
                            </div>

                            <div class="row text-left">
                                <div class="col-4">Supp Oxy thp: </div>
                                <div class="col-6"><?php echo $epcr_details[0]->ong_supp_oxy_thp.' '.$epcr_details[0]->ong_supp_oxy_thp_txt; ?></div>
                            </div>
                            <div class="row text-left">
                                <div class="col-4">Ven Supp bvm: </div>
                                <div class="col-6"><?php echo $epcr_details[0]->ong_ven_supp_bvm; ?></div>
                            </div>
                            <div class="row text-left">
                                <div class="col-4">Stretcher: </div>
                                <div class="col-6"><?php echo $epcr_details[0]->ong_stretcher; ?></div>
                            </div>
                            <div class="row text-left">
                                <div class="col-4">Wheelchair: </div>
                                <div class="col-6"><?php echo $epcr_details[0]->ong_wheelchair; ?></div>
                            </div>
                            <div class="row text-left">
                                <div class="col-4">Spine Board: </div>
                                <div class="col-6"><?php echo $epcr_details[0]->ong_spine_board; ?></div>
                            </div>
                            <div class="row text-left">
                                <div class="col-4">Scoop Stretcher: </div>
                                <div class="col-6"><?php echo $epcr_details[0]->ong_scoop_stretcher; ?></div>
                            </div>
                            <div class="row text-left">
                                <div class="col-4">Medication: </div>
                                <div class="col-6"><?php echo $epcr_details[0]->ong_medication.' '.$epcr_details[0]->ong_medication_txt; ?></div>
                            </div>
                            <div class="row text-left">
                                <div class="col-4">Past Medical History: </div>
                                <div class="col-6"><?php 
                                $past_his=json_decode($epcr_details[0]->ong_past_med_hist);
                                if($past_his){
                                    $past_data = array();
                                foreach($past_his as $his){
                                    $his_data = get_past_his_details($his->id);
                                   $past_data[]=$his_data[0]->name;
                                }
                               $past_data = implode("','",$past_data);
                               }else{
                                $past_data = '';   
                               }
                                echo $past_data.' '.$epcr_details[0]->other_ong_intervention; ?>
                                </div>
                            </div>
                            <div class="row text-left">
                                <div class="col-4">Sign Symptoms: </div>
                                <div class="col-6"><?php echo $epcr_details[0]->ct_type; ?></div>
                            </div>
                            <div class="row text-left">
                                <div class="col-4">Chief complaint: </div>
                                <div class="col-6"><?php echo $epcr_details[0]->ct_type; ?></div>
                            </div>
                            <div class="row text-left">
                                <div class="col-4">Other Sign Symptoms: </div>
                                <div class="col-6"><?php echo $epcr_details[0]->ong_other_ph_sign_symptoms; ?></div>
                            </div>
                            <div class="row text-left">
                                <div class="col-4">Allergy: </div>
                                <div class="col-6"><?php echo $epcr_details[0]->ong_ph_allergy; ?></div>
                            </div>   
                            <div class="row text-left">
                                <div class="col-4">Event Led Inc: </div>
                                <div class="col-6"><?php echo $epcr_details[0]->ong_ph_event_led_inc; ?></div>
                            </div>
                            <div class="row text-left">
                                <div class="col-4">Last Oral Intake: </div>
                                <div class="col-6"><?php echo $epcr_details[0]->ong_ph_last_oral_intake; ?></div>
                            </div>

                        </div>
                    </div>
                    </td>
                    
                </tr>
           
            
          <?php $i++; } ?>
       
        </tbody>
        </table><br>
    </div>
</div>
<!-- admit   Modal -->
<div class="modal fade" id="admit_patient">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Patient Admit Confirmation</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
            <input type="hidden" id="otp_inc_id" value="<?php echo $inc->inc_ref_id; ?>">
            <div><?php echo $inc->bed_type; ?> Bed confirmed for this Incident  Id : <?php echo $inc->inc_ref_id; ?></div>
            
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
        <!--<input type="button" name="Save" value="SAVE PAGE" class="accept_btn form-xhttp-request" data-href='{base_url}inc/otp_verification1' data-qr='' TABINDEX="33"><?php // }else{           ?>
          -->  
        <button onclick="admit_patient();" type="button" class="btn btn-secondary" data-dismiss="modal">Admit</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>
<!-- OTP Verification  Modal -->
<div class="modal fade" id="otp">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">OTP Verification</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
            <input type="hidden" id="otp_inc_id" value="<?php echo $inc->inc_ref_id; ?>">
            <div>Incident  Id : <?php echo $inc->inc_ref_id; ?></div>
            <input class="form-control" onkeyup="this.value=this.value.replace(/[^\d]/,'')" maxlength="4" type="text" name="otp" id="hos_otp"></input>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
        <input type="button" name="Save" value="SAVE PAGE" class="accept_btn form-xhttp-request" data-href='{base_url}inc/otp_verification1' data-qr='' TABINDEX="33"><?php // }else{           ?>
            
        <button   onclick="otp_verification();" type="button" class="btn btn-secondary" data-dismiss="modal">Verify</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>
<!-- The Modal -->
<div class="modal fade" id="track">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Patient Tracking</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          <div id="map" style="width:764px; height:400px;"></div>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>
</div>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDCrfpYkqNLwUaG0iipCOJec5Z9hwEL-I8&libraries=places"></script>
<script type="text/javascript">
    
     var map_mark_pin = new H.map.Icon(base_url + "themes/backend/images/ambulance.png");
     var amb_pin = new H.map.Icon(base_url + "themes/backend/images/bls_map_pin.png");
     var incident_pin = new H.map.Icon(base_url + "themes/backend/images/accident.png");
     
$(document).ready(function() {
    var $directionsAmb;
    var $directionsDisplayAmb;
    var $AllMapUI, $AllMap;
    var $Allgroup = null;
    var $DirectionLineGroup = null;
    

  function initializeGMap(veh, hp_lat, hp_lng, inc_lat, inc_lng,amb_lat,amb_lng) {

    $destination = hp_lat+','+hp_lng;
    $origin = inc_lat+','+inc_lng;
    $ambulance =  amb_lat+','+amb_lng;
   
       var myLatLng = {lat: 23.23979546250735, lng: 77.39215854006432};
        $A_Platform = new H.service.Platform({
            apikey: 'yrjPrIYd0xU9KJpe1xlaR1_K1wFrwc9U-_-99n040JQ',
        });
        var defaultLayers = $A_Platform.createDefaultLayers();

        $AllMap = new H.Map(document.getElementById('map'),
            defaultLayers.vector.normal.map, {
                center: myLatLng,
                zoom: 10,
                //pixelRatio: window.devicePixelRatio || 1
            });

        var behavior = new H.mapevents.Behavior(new H.mapevents.MapEvents($AllMap));

        $AllMap.tagId = 'ALL_MAP';

        window.addEventListener('resize', () => $AllMap.getViewPort().resize());
        $AllMapUI = H.ui.UI.createDefault($AllMap, defaultLayers);
 
        var hpLatLng = {
            lat: hp_lat,
            lng: hp_lng
        };
        addInfoBubble(hpLatLng, map_mark_pin, '<div style="width:100px">Hospital Location</div>');
        
        var incLatLng = {
            lat: inc_lat,
            lng: inc_lng
        };
        addInfoBubble(incLatLng, incident_pin, '<div style="width:100px">Incident Location</div>');
        
        
        var ambLatLng = {
            lat: amb_lat,
            lng: amb_lng
        };
        addInfoBubble(ambLatLng, amb_pin, '<div style="width:100px">Ambulance Location</div>');
        
        set_amb_direction($origin,$destination);
            
    }
   
        function addInfoBubble(markerLatLng, map_mark_pin, html) {
        if (markerLatLng == '' || markerLatLng == null) {
            return false;
        }

        $Allgroup = new H.map.Group();
        $AllMap.addObject($Allgroup);

        var parisMarker = new H.map.Marker(markerLatLng, {
            icon: map_mark_pin
        });

        parisMarker.addEventListener('pointerenter', function(evt) {

            var bubble = new H.ui.InfoBubble(markerLatLng, {
                content: html
            });

            $AllMapUI.getBubbles().forEach(bub => $AllMapUI.removeBubble(bub));
            $AllMapUI.addBubble(bubble);
        }, false);
        $Allgroup.addObject(parisMarker);
        $AllMap.getViewModel().setLookAtData({
        });

    }
    
function set_amb_direction($origin,$destination) {
    

    $DirectionLineGroup = new  H.map.Group();
    $AllMap.addObject($DirectionLineGroup);
    var request = {
        'routingMode': 'fast',
        'transportMode': 'car',
        'origin': $origin,
        'destination': $destination,
        'return': 'polyline'
    };
   
    var $directionsService = $A_Platform.getRoutingService(null, 8);
    $directionsService.calculateRoute(request, function(result) {
        
        if (result.routes.length) {
            result.routes[0].sections.forEach((section) => {

                var $linestring = H.geo.LineString.fromFlexiblePolyline(section.polyline);
                
                $DirectionLine = new H.map.Polyline(
                    $linestring, { style: { lineWidth: 5 }}
                );
                $DirectionLineGroup.addObject($DirectionLine);

                
            });
        }
        
    },
    function(error) {
        //alert(error.message);
    });
    
 
}


  
  $('#track').on('show.bs.modal', function(event) {
     $("#map").html("");  
    var button = $(event.relatedTarget);
    var inc_lat = button.data('inc_lat');
    var inc_lng = button.data('inc_lng');
    setTimeout(function(){
    initializeGMap(button.data('veh'), button.data('hp_lat'), button.data('hp_lng'),button.data('inc_lat'), button.data('inc_lng'), button.data('amb_lat'), button.data('amb_lng'));
     $("#map").css("width", "100%");
     },1000);
  });

  function addMarkersToMap(lat,log) {

        if($parisMarker != null){
            $parisMarker.setMap(null);
        }
     
       $parisMarker = new google.maps.Marker({
            position: {
            lat:parseFloat(lat), lng:parseFloat(log)},
            map: $map,
            title: "Hello World!"
        });
        $parisMarker.setMap($map);
    }

});
</script>
<script>
function admit_patient(){
    var inc_id = $("#otp_inc_id").val();
    
    $.post('<?=site_url('hospital_terminal/patient_admit_confirmation')?>',{inc_id},function(data){
           // var new_var = JSON.parse(data);
            window.location.reload();
            //location.reload(); 
        });
}
function otp_verification(){
    var otp = $("#hos_otp").val();
    var otp_inc_id = $("#otp_inc_id").val();

        $.post('<?=site_url('hospital_terminal/otp_varification1')?>',{otp_inc_id,otp},function(data){
            var new_var = JSON.parse(data);
            /* for(var i = 0; i < new_var.length; i++){
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
            $('#logindetails').modal('show');*/
        });
    }
    </script>

<script>
/* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
function myFunction() {
  document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}

function drpdown(){
    var id = document.getElementById('dropselect').value;
    
    if(id=='1'){
        document.getElementById('inc_id_div').style.display = "block";
        document.getElementById('serch_btn').style.display = "block";
        
    }else{
        document.getElementById('inc_id_div').style.display = "none";
        document.getElementById('serch_btn').style.display = "none";
    }
}
function serch_records(){
    var inc_id = document.getElementById('inc_id').value;
    $.ajax({
        type: 'POST',

            data: 'inc_id='+inc_id,

            cache: false,

            dataType: 'json',

            url: base_url + 'hospital_terminal/hos_serch_function',

            success: function(result){
               // alert(result);
              // console.log(result.bk_inc_ref_id);
              
               $('.list_table_amb').html("");
                var raw = '<table class="table table-bordered list_table_amb" id="myTable" style="text-align: center;">' +
                    '<tr class="table-active">' +
                    '<th scope="col">Sr.No</th>' +
                    '<th scope="col">Patient Name</th>' +
                    '<th scope="col">Incidnet ID</th>' +
                    '<th scope="col">Ambulance No</th>' +
                    '<th scope="col">Complaint</th>' +
                    '<th scope="col">Action</th>' +
                    '</tr>' +
                    '</table>';
                $('.list_table_amb').html(raw);
                var j = 1;
                var raw = "<tr >"+
                "<td>" + j + "</td>"+
                "<td>" + result.ptn_fname+' '+ result.ptn_lname + "</td>"+
                "<td>" + result.inc_ref_id + "</td>"+
                "<td>" + result.amb_rto_register_no + "</td>"+
                "<td>" + result.ct_type + "</td>"+
                "<td><button class='btn btn-primary' Onclick='admin_patient("+result.inc_ref_id+")'>Admint Patient</button ></td>"+
                "</tr>";
                $('.list_table_amb tr:last').after(raw);
            }

    });
}
function admin_patient(inc_id){
    $('#admit_patient').modal('show');
}
</script>
