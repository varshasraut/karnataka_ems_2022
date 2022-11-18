<?php $CI = EMS_Controller::get_instance(); ?>
<div class="margin_auto width70">
    <div class="dash_quality_marks text_align_center mt-4" >
		
		<strong>FEEDBACK CALL INFO</strong><br>
		<table >
			<tr>
				<th style="text-align: center;">Total Calls <br>(This month)</th>
				<th style="text-align: center;">Total Calls<br> (Today)</th>
                <!-- <th style="text-align: center;">Excellent  <br>(This month)</th>
                <th style="text-align: center;">Good <br>(This month)</th>
                <th style="text-align: center;">Avarage <br>(This month)</th>
                <th style="text-align: center;">Poor <br>(This month)</th> -->
            </tr>
			<tr>
				<td><?php echo $get_all_calls;?></td>
				<td><?php echo $get_all_today_calls; ?></td>
				<!-- <td><?php echo ''; ?></td>
                <td><?php echo '';?></td>
                <td><?php echo ''; ?></td>
                <td><?php echo '';?></td> -->
			</tr>
		</table>
		<span><?php //echo $audit_details[0]->quality_score;?></span>
	</div>
</div>
<br>
<!--<h3 class="txt_clr5 width2 float_left">Dashboard</h3><br>-->
<div class="width100" style="margin-top:0px;padding-top:12px;width: 100%;top: 50px;"> 
   <form method="post" name="inc_list_form" id="inc_list">  
    <div class="width_16 float_left">   <h3 class="txt_clr2  float_left">Dashboard</h3> </div>
    <div class="width_16 float_left">

        <select name="filter" class="dropdown_per_page width90" data-base="search" id="feedback_filter_list">
            <option value="">Select</option> 
            <option value="call_type" <?php
            if ($filter == 'call_type') {
                echo "selected";
            }
            ?>>Call Type</option>

            <option value="date" 
            <?php
//                                  
            ?>>Date</option>


            <option value="inc_id" 
            <?php
//                                  
            ?>>Incident ID</option>

            <!--<option value="Reopen_id" 
            <?php
//                                  
            ?>>Reopen ID</option>-->
            <option value="dst_name"  <?php
                   if ($filter == 'dst_name') {
                    echo "selected";
                }
            ?>>District</option>
            <option value="amb_id"  <?php
                 if ($filter == 'amb_id') {
                    echo "selected";
                }
             ?>>Vehicle Number</option>
             <option value="hp_id"  <?php
                 if ($filter == 'hp_id') {
                    echo "selected";
                }
             ?>>Base Location</option>
             <option value="pt_status"  <?php
                 if ($filter == 'pt_status') {
                    echo "selected";
                }
             ?>>Patient Status</option>
        </select>
    </div>

        <!--<div class="width_16 float_left">
    <select name="system_filter" class="dropdown_per_page width90 " data-base="search" id="feedback_filter_list">
    <option value="">Select System</option> 
            <option value="108" <?php
           // if ($filter == '') {
              //  echo "selected";
            //}
            ?>>108</option>
             <!-- <option value="104" <?php 
            //if ($filter == '') {
             //   echo "selected";
           // } ?>>104</option>-->
            <!--</select>
    </div>-->

    <?php // echo $filter; ?>
    <div id="call_list" class="width_16 float_left" style="<?php
    if ($filter == 'call_type') {
        echo 'display:block;';
    } else {
        echo 'display:none;';
    }
    ?>">
        <select name="call_type" class="dropdown_per_page width97" data-base="search" >
            <option value="">Select Call Type</option>
            <?php foreach ($purpose_calls as $calls) { ?>
                <option value="<?php echo $calls->pcode ?>" ><?php echo $calls->pname ?></option>
                    <?php } ?>


        </select>     
    </div>
   
    <div id="inc_id_box" class="width_16 float_left " style="<?php
    if ($filter == 'inc_id') {
        echo 'display:block;';
    } else {
        echo 'display:none;';
    }
    ?>">
        <input name="inc_id" tabindex="7.2" class=" form_input" placeholder="Incident ID" type="text"  data-errors="{filter_required:'Please select hospital from dropdown list'}" >
    </div>
    
      <div id="inc_date" class="width_16 float_left " style="<?php
    if ($filter == 'date') {
        echo 'display:block;';
    } else {
        echo 'display:none;';
    }
    ?>">
        <input name="date" tabindex="7.2" class="form_input mi_calender" placeholder="date" type="text"  data-errors="{filter_required:'Please select hospital from dropdown list'}" >
    </div>
    
    <div id="district_list" class="width_16 float_left " style="<?php
        if ($district_id != '') {
            echo 'display:block;';
        } else {
            echo 'display:none;';
                }
         ?>">                
            <input name="district_id" class="mi_autocomplete form_input" data-href="{base_url}auto/get_district" placeholder="District" data-errors="{filter_required:'Please select state from dropdown list'}" tabindex="7.2" autocomplete="off" >
    </div>
    <div id="vehicle_list" class="width_16 float_left " style="<?php
        if ($amb_rto_register_no != '') {
            echo 'display:block;';
        } else {
            echo 'display:none;';
            }
            
        ?>">                
            <input name="amb_rto_register_no" class="mi_autocomplete form_input" data-href="{base_url}auto/get_ambulance" placeholder="Vehicle Number" data-errors="{filter_required:'Please select vehicle no from dropdown list'}" tabindex="7.2" autocomplete="off" >
    </div>
        
    <div id="base_location_list" class="width_16 float_left " style="<?php
        if ($base_location_name1 != '') {
            echo 'display:block;';
        } else {
            echo 'display:none;';
            }
        ?>"> 
        <input name="base_location_name1" tabindex="7.2" class="mi_autocomplete form_input" placeholder="Base Location" type="text" data-errors="{filter_required:'Please select hospital from dropdown list'}" data-href="{base_url}auto/get_base_location">
    </div>   
    <div id="Patient_status" class="width_16 float_left " style="<?php
        if ($Patient_status != '') {
            echo 'display:block;';
        } else {
            echo 'display:none;';
            }
        ?>"> 
        <select name="patient_status_search" id ="patient_status_search"  class="dropdown_per_page width97" >
            <option value="">Select Status</option>
            <option value="Available" >Available</option>
            <option value="Not Available" >Not Available</option>
        </select>  
        
    </div>     

    <div class="float_left">
        <input type="button" class="search_button float_left form-xhttp-request" name="" value="Search" data-href="{base_url}feedback/feedback_list" data-qr="output_position=content&amp;flt=true" />  
        <input class="search_button click-xhttp-request float_right" name="" value="Reset Filters" data-href="{base_url}feedback/feedback_list" data-qr="output_position=content&amp;filters=reset" type="button">
    </div>
</div>

<form method="post" name="feedback_dash_form" id="feedack_dash">  


    <div id="list_table">
        <table class="table report_table table-bordered">
            <tr>                                     
                <th>Date & Time</th>
                <th>Incident ID</th>
                <th>Ambulance No</th>
                <th>Call Type</th>
                <th>Caller Number</th>
                <th>Caller Name</th>
                <th>Base Location Name</th>
                <th>Patient Status</th>
                <th>Action</th> 
            </tr>

            <?php
            if ($inc_info) {

                $key = 1;
                foreach ($inc_info as $inc) {
?>
                    <tr>

                        <td><?php echo $inc->inc_datetime; ?></td>

                        <td><a href="{base_url}calls/single_record_view" class="onpage_popup" data-qr="output_position=popup_div&inc_ref_id=<?php echo $inc->inc_ref_id; ?>" style="color:#000;"><?php echo $inc->inc_ref_id; ?></a></td>

                        <?php
                        if ($inc->inc_mci_nature != '') {
                            ?>
                                                                            <!--<td ><?php echo get_mci_nature_service($inc->inc_mci_nature); ?></td>-->
                        <?php } else { ?>
                                                                            <!--<td ><?php echo get_cheif_complaint($inc->inc_complaint); ?></td>-->
                        <?php } ?>
                       <td><?php echo $inc->amb_reg_id; ?> </td>

                        <td><?php
                            echo ucwords($inc->pname);
                            if ($inc->cl_name != '') {
                                ?> &nbsp; [ <?php echo ucwords($inc->cl_name); ?> ] <?php } ?> </td>                          
                        <!--<td nowrap><?php echo $inc->hp_name; ?></td>-->
                        <td><?php echo $inc->clr_mobile; ?></td>    


                        <td><?php $fullname=$inc->clr_fname.' '.$inc->clr_lname;echo ucwords($fullname); ?> </td>
                        <td><?php 
                      /*  if($inc->hp_name!=''){
                            $hp_name=$inc->hp_name;
                        }else{
                            $hp_name='Other-'.''.$inc->other_receiving_host;
                        }*/
                        echo $inc->base_location_name; ?></td> 
                        <td> <?php echo $inc->call_type; ?></td> 
                        <td> 

                            <div class="user_action_box fire_calls">

                                <div class="colleagues_profile_actions_div"></div>

                                <ul class="profile_actions_list">
                                    <!--
                                                                                <li><a class="onpage_popup action_button" data-href="{base_url}grievance/view_complaint"  data-qr="output_position=content&amp;module_name=clg&amp;tlcode=MT-CLG-EDIT&amp;gc_id=<?php echo base64_encode($inc->gc_id) ?>&amp;gc_complaint_type=<?php echo base64_encode($inc->gc_complaint_type); ?>&amp;action_type=View Work Station" data-popupwidth="1000" data-popupheight="600">View</a></li>-->
                                   <?php if($filter == 'Reopen_id'){ ?>
                                    <li><a class="onpage_popup action_button" data-href="{base_url}feedback/reopen_report_view" data-qr="output_position=content&amp;module_name=clg&amp;tlcode=MT-CLG-EDIT&amp;inc_ref_id=<?php echo base64_encode($inc->inc_ref_id) ?>&amp;action=edit_data&amp;action_type=Update"  data-popupwidth="1300" data-popupheight="700">ReopenIncident</a></li>          
                                   <?php }else{ ?>
                                    <li><a class="onpage_popup action_button" data-href="{base_url}feedback/report_view" data-qr="output_position=content&amp;module_name=clg&amp;tlcode=MT-CLG-EDIT&amp;inc_ref_id=<?php echo base64_encode($inc->inc_ref_id) ?>&amp;action=edit_data&amp;action_type=Update"  data-popupwidth="1300" data-popupheight="700">View</a></li>          
                                   <?php } ?>
                                    

                                </ul> 
                            </div>
                        </td>

                    </tr>

                    <?php
                }
            } else {
                ?>

                <tr><td colspan="7" class="no_record_text">No Record Found</td></tr>

            <?php } ?>   


        </table>

        <div class="bottom_outer">

            <div class="pagination"><?php echo $pagination; ?></div>

            <div class="width33 float_right">

                <div class="record_per_pg">

                    <div class="per_page_box_wrapper">

                        <span class="dropdown_pg_txt float_left"> Records per page : </span>

                        <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}feedback/feedback_list" data-qr="output_position=content&amp;flt=true">

                            <?php echo rec_perpg($pg_rec); ?>

                        </select>

                    </div>

                    <div class="float_right">
                        <span> Total records: <?php echo ($total_count > 0) ? $total_count : "0"; ?> </span>
                    </div>

                </div>

            </div>

        </div>



    </div>
</form>