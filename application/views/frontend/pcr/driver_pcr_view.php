<script>cur_pcr_step(10);</script>

<div class="call_purpose_form_outer">

    <div class="head_outer"><h3 class="txt_clr2 width1">DRIVER PCR</h3></div>
    
    <form method="post" name="driver_pcr" id="driver_pcr">
        
        <div class="table_wrp">
        
            <table class="style5">
                
                <tr>
                    <th>Type/Parameter</th>
                    <th>Time</th>
                    <th>Km</th>
                </tr>

                <tr>
                   <td>Call receive from desk</td>
                   <td>
                        <div class="text_align_center">
                            <input type="text" name="cl_from_dsk" class="txt mi_timepicker" value="<?php echo $driver_data[0]->dp_cl_from_desk;?>" placeholder="H:i:s" TABINDEX="1">
                       </div>
                   </td>
                   <td>
                        <div class="text_align_center">
                            <input type="text" name="cl_from_dsk_km" class="filter_number filter_if_not_blank txt" data-errors="{filter_number:'Allowed only number.'}" value="<?php if(($driver_data[0]->dp_cl_from_dsk_km)>0){ echo $driver_data[0]->dp_cl_from_dsk_km; }?>" placeholder="KM" TABINDEX="2">
                       </div>
                   </td>
                </tr>

                <tr>
                   <td>Started from base location</td>
                   <td>
                        <div class="text_align_center">
                            <input type="text" name="started_base_loc" class="txt mi_timepicker" value="<?php echo $driver_data[0]->dp_started_base_loc;?>"  placeholder="H:i:s"TABINDEX="3" >
                       </div>
                   </td>
                   <td>
                        <div class="text_align_center">
                            <input type="text" name="started_base_loc_km" class="txt filter_number filter_if_not_blank" value="<?php if(($driver_data[0]->dp_started_base_loc_km)>0){echo $driver_data[0]->dp_started_base_loc_km;}?>" data-errors="{filter_number:'Allowed only number.'}" placeholder="KM" TABINDEX="4">
                       </div>
                   </td>

                </tr>
                <tr>
                   <td>Reached on scene<span class="md_field">*</span></td>
                   <td>
                       <div class="text_align_center">
                            <input type="text" name="reached_on_scene" class=" txt mi_timepicker"  data-errors="{filter_required:'Time should not be blank'}" value="<?php echo $driver_data[0]->dp_reach_on_scene;?>"  placeholder="H:i:s" TABINDEX="5">
                       </div>
                       
                       
                   </td>
                   <td>
                        <div class="text_align_center">
                            <input type="text" name="reached_on_scene_km" class="filter_required filter_number txt"  data-errors="{filter_required:'km should not be blank',filter_number:'Allowed only number.'}" value="<?php if(($driver_data[0]->dp_reach_on_scene_km)>0){ echo $driver_data[0]->dp_reach_on_scene_km;}?>" placeholder="KM" TABINDEX="6">
                       </div>
                   </td>
                </tr>
                <tr>
                   <td>On scene time</td>
                   <td>
                        <div class="text_align_center">
                            <input type="text" name="on_scene_time" class="txt mi_timepicker" value="<?php echo $driver_data[0]->dp_on_scene;?>"  placeholder="H:i:s" TABINDEX="7">
                       </div>
                   </td>
                   <td>
                        <div class="text_align_center">
<input type="text" name="on_scene_km" class="txt filter_number filter_if_not_blank" data-errors="{filter_number:'Allowed only number.'}" value="<?php if(($driver_data[0]->dp_on_scene_km)>0){echo $driver_data[0]->dp_on_scene_km;}?>" placeholder="KM" TABINDEX="8" >
                       </div>
                   </td>
                </tr>
                
                <tr>
                   <td>Scene to Hospital time<span class="md_field">*</span></td>
                   <td>
                       <div class="text_align_center">
                            <input type="text" name="scene_hosp_time" class=" txt mi_timepicker"  data-errors="{filter_required:'Time should not be blank'}" value="<?php echo $driver_data[0]->dp_hosp_time;?>" placeholder="H:i:s" TABINDEX="9">
                   </td >
                    <td>
                       <div class="text_align_center">
                            <input type="text" name="scene_hosp_km" class="filter_if_not_blank filter_number txt"  data-errors="{filter_required:'km should not be blank',filter_number:'Allowed only number.'}" value="<?php if(($driver_data[0]->dp_hosp_time_km)>0){ echo $driver_data[0]->dp_hosp_time_km;}?>" placeholder="KM" TABINDEX="10">
                   </td>
                </tr>
                
                <tr>
                   <td>Patient handover time</td>
                    <td>
                       <div class="text_align_center">
                            <input type="text" name="pat_hand_time" class="txt mi_timepicker" value="<?php echo $driver_data[0]->dp_hand_time;?>"  placeholder="H:i:s" TABINDEX="12">
                   </td>
                    <td>
                      
                   </td>
                </tr>
                
                <tr>
                   <td>Back to base location<span class="md_field">*</span></td>
                    <td>
                       <div class="text_align_center">
                            <input type="text" name="back_to_base_loc" class="filter_required txt mi_timepicker"  data-errors="{filter_required:Time should not be blank'}" value="<?php echo $driver_data[0]->dp_back_to_loc;?>"  placeholder="H:i:s" TABINDEX="13">
                   </td>
                    <td>
                       <div class="text_align_center ">
                            <input type="text" name="back_to_base_loc_km" class="filter_required filter_number txt"  data-errors="{filter_required:'km should not be blank',filter_number:'Allowed only number.'}" value="<?php if(($driver_data[0]->dp_back_to_loc_km)>0){echo $driver_data[0]->dp_back_to_loc_km;}?>" placeholder="KM" TABINDEX="14">
                   </td>
                </tr>
            </table>
            
            <div class="accept_outer width100">


              <input type="button" name="accept" value="ACCEPT" class="accept_btn form-xhttp-request" data-href='{base_url}pcr/save_driver_pcr' data-qr=""  tabindex="25">


           </div>
        </div>
        
        
        
    </form>
    
</div>
 <div class="next_pre_outer">
           <?php  $step = $this->session->userdata('pcr_details'); 
           if(!empty($step)){
           ?>
            <a href="#" class="prev_btn btn float_left" onclick="load_next_prev_step(9)"> < Prev </a>
           <?php } ?>
</div>
                        
                       
                        