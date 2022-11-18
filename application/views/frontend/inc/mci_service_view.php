<?php 
$com_cheif_service = explode(',',$mci_nature_services[0]->ntr_services);

if($cmp_service){
    foreach ($cmp_service as $key=>$service) { ?>
    <div class="width_20 float_left">
        <label for="service_<?php echo $service->srv_id; ?>" class="chkbox_check">
                    <input type="checkbox" name="incient[service][<?php echo $service->srv_id; ?>]" class="check_input unit_checkbox" value="<?php echo $service->srv_id; ?>"  id="service_<?php echo $service->srv_id; ?>" <?php if (in_array($service->srv_id, $com_cheif_service)) {
            echo "checked";
        } ?>>
            <span class="chkbox_check_holder"></span><?php echo $service->srv_name; ?><br>
        </label>
    </div>
<?php } 
} ?>
<?php 

if(in_array(2, $com_cheif_service)){ 
    $police_show = ''; 
    
}else{
     $police_show = 'hide';
}?>
<!--    <div class="width100 float_left form_field float_left <?php echo $police_show;?>" id="police_cheif">
        <div class="label blue float_left width30">Police Complaint</div>
        <div class="input nature top_left float_left width70" >
            <div class="input">
            <input type="text" name="incient[police_chief_complete]" id="police_chief_complete" class="mi_autocomplete"  data-href="{base_url}auto/get_police_chief_complete"  placeholder="Police Chief Complaint" data-errors="{filter_required:'Please select complaint from dropdown list'}" data-callback-funct="police_chief_complete_change" TABINDEX="8">
            </div>
            <div class="input nature top_left hide" id="police_chief_complete_other">
                <input type="text" name="incient[police_chief_complete_other]" id="police_chief_complete_other_text"  class=""  placeholder="Other Police Chief Complaint" data-errors="{filter_required:'Please select complaint from dropdown list'}" TABINDEX="8">
            </div>
       </div>

  
    </div>-->
<?php 
if(in_array(3, $com_cheif_service)){     
    $fire_show = ''; 
    
}else{
    $fire_show = 'hide';
} ?>
<!--    <div class="width100 float_left form_field float_left <?php echo $fire_show;?>" id="fire_cheif">
        <div class="label blue float_left width30">Fire Complaint</div>
        <div class="input nature top_left float_left width70" >
             <div class="input">
                <input type="text" name="incient[fire_chief_complete]" id="fire_chief_complete" class="mi_autocomplete"  data-href="{base_url}auto/get_fire_chief_complete"  placeholder="Fire Chief Complaint" data-errors="{filter_required:'Please select complaint from dropdown list'}" data-callback-funct="fire_chief_complete_change" TABINDEX="8" >
             </div>
               <div class="input nature top_left hide" id="fire_chief_complete_other">
            <input type="text" name="incient[fire_chief_complete_other]" id="fire_chief_complete_other_text"  class=""  placeholder="Other Fire Chief Complaint" data-errors="{filter_required:'Please select complaint from dropdown list'}" TABINDEX="8" >
        </div>
        </div>
        
     
    </div>-->