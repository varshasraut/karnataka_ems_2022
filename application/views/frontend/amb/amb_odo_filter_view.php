<style>
    #amb_list .srch_box{
        width: 40% !important;
        float: left !important;
    }
    .width85{
        width:85% !important;
    }
    .margin-left{
        margin-left: -22px;
    }
    .switch {
  position: relative;
  display: inline-block;
  width: 50px;
  height: 24px;
  margin-left:5px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 16px;
  width: 16px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  transition: .4s;
}

input:checked + .slider {
  background-color: green;
}

input:focus + .slider {
  box-shadow: 0 0 1px green;
}

input:checked + .slider:before {
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}
.slider.round:before {
  border-radius: 50%;
}
</style>
<?php $CI = EMS_Controller::get_instance(); ?>

<div class="breadcrumb float_left">
    <ul>
        <li class="sms">
            <a class="click-xhttp-request" data-href="{base_url}amb/amb_listing">Ambulance</a>
        </li>
        <li>
            <span><?php if ($verify_status == "unapprove") { ?>Unapproved<?php } ?>Update Ambulance Odometer</span>
        </li>

    </ul>
</div>


<br>

<div class="box3">    

    <div class="permission_list group_list">

        <form method="post" name="amb_form" id="amb_list">  

       
                

<div class="filters_groups">                   

    <div class="search">

        <div class="row list_actions">

            <div class="width100">
                 <div class="width20 drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">Ambulance Number: </div>
                    </div>
                    <div class="width100 float_left">
                        <div id="incient_ambulance">



                            <?php
                   
                         
                                $dt = array('dst_code' => $incient_district, 'st_code' => 'MP', 'auto' => 'amb_auto_addr', 'rel' => 'incient', 'disabled' => '','amb_ref_no'=>$incient_ambulance);
                           


                            echo get_district_ambulance($dt);
                            ?>

                        </div>

                    </div>
                </div>
                <div class="width20 drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">From: </div>
                    </div>
                    <?php if(isset($incient_ambulance)) {?>
                    <div class="width100 float_left">
                        <input name="from_date" tabindex="1" class="form_input filter_required width85" placeholder="From Date" type="text" data-base="search_btn" data-errors="{filter_required:'From Date should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}"  readonly="readonly" id="from_date" value=<?php echo  date('m/d/Y', strtotime($from_date));?> >
                    </div>
                    <?php }else{?>
                        <div class="width100 float_left">
                        <input name="from_date" tabindex="1" class="form_input filter_required width85" placeholder="From Date" type="text" data-base="search_btn" data-errors="{filter_required:'From Date should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}"  readonly="readonly" id="from_date"  >
                    </div>
                    <?php } ?>
                </div>
                <div class="width20 drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left margin-left">To : </div>
                    </div>
                    <?php if(isset($incient_ambulance)) {?>
                    <div class="width100 float_left">
                        <input name="to_date" tabindex="2" class="form_input filter_required width85 margin-left" placeholder="To Date" type="text" data-base="search_btn" data-errors="{filter_required:'To Date should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}"  readonly="readonly" id="to_date" value=<?php echo date('m/d/Y', strtotime($to_date));?>>
                </div>
                <?php }else{?>
                    <div class="width100 float_left">
                        <input name="to_date" tabindex="2" class="form_input filter_required width85 margin-left" placeholder="To Date" type="text" data-base="search_btn" data-errors="{filter_required:'To Date should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}"  readonly="readonly" id="to_date" >
                </div>
                <?php } ?>
                </div>    
            
                <div class="srch_box">
                    <input type="button" class="search_button form-xhttp-request" name="Search" value="Search" data-href="{base_url}amb/amb_odometer_listing_all" data-qr="output_position=content&amp;flt=true" style="margin-top:29px !important;margin-left: -20px;" />

                    <input class="search_button click-xhttp-request" name="" value="Reset Filters" data-href="{base_url}amb/amb_odometer_listing_all" data-qr="output_position=content&amp;filters=reset" type="button" style="padding: 5px 13px !important;">
                
                <div style="float:right;">
                    <input type="button" class="search_button form-xhttp-request" name="Enable" value="Enable All Odo" data-href="{base_url}amb/amb_odometer_enable_status_all" data-qr="output_position=content&amp;flt=true"  style="padding: 5px 13px !important; margin-top:29px;" />

                    <input type="button" class="search_button form-xhttp-request" name="Disable" value="Disable All Odo" data-href="{base_url}amb/amb_odometer_disable_status_all" data-qr="output_position=content&amp;flt=true" style="padding: 5px 13px !important; margin-top:29px;"/> 
                </div>  
                </div>
                
            </div>
           
        </div>
    </div>

</div>

                
          

            <div id="list_table">


                <table class="table report_table">


                    <tr>                
                                             
<!--                        <th nowrap>Sr No</th>-->
                        <th nowrap>Register Number</th>
                        <th nowrap>Incident ID</th>
                        <!-- <th nowrap>Base Location</th> -->
                        <!-- <th nowrap>District</th> -->
                        <th nowrap>Start Odo</th>
                        <th nowrap> On Scene Odo</th>
                        <th nowrap>From Scene Odo</th>
                        <th nowrap>Handover Odo</th>
                        <th nowrap>Hospital Odo</th>
                        <th nowrap>End Odo</th>
                        <th>Total Km</th>
                        <th>Odometer Type</th>
                        <!-- <th>Id of Case closure or Fleet	Timestamp</th>  -->
                        <!-- <th>Added by</th>  -->
                        <!-- <th>Modify by</th>  -->
                        <th>Status</th> 
                        <th>Action</th> 

                    </tr>
    <?php// var_dump(count($result));die(); ?>
                    <?php
                    if ($result) {

                        $total = 0;
                        $cur_page_sr = ($cur_page - 1) * 20;
                        foreach ($result as $key => $value) {
                           
                            ?>
                            <tr>
                                
        <?php //} ?>



                                <td><?php echo $value->amb_rto_register_no; ?></td>
                                <td><?php echo $value->inc_ref_id; ?></td>
                                <td><?php echo $value->start_odmeter; ?></td>
                                <td><?php echo $value->scene_odometer; ?></td>
                                <td><?php echo $value->from_scene_odometer; ?></td>
                                <td><?php echo $value->handover_odometer; ?></td>
                                <td><?php echo $value->hospital_odometer; ?></td>
                               <td><?php echo $value->end_odmeter; ?></td>
                                <td><?php echo $value->end_odmeter - $value->start_odmeter ?></td> 
                                <td><?php echo ucfirst($value->odometer_type);?></td>                            
                                <td>
                                    <?php
                                    if($value->flag == '1'){ ?>

                                    
                                <label class="switch">
                                <input type="checkbox" onchange=" update_flag(<?php echo $value->inc_ref_id; ?>,<?php echo $value->flag; ?>);" checked name="flag_change">
                                <span class="slider round"></span>
                                </label>
                                <?php }  
                                else {?>
                                <label class="switch">
                                <input type="checkbox" onchange=" update_flag(<?php echo $value->inc_ref_id; ?>,<?php echo $value->flag; ?>);" name="flag_change">
                                <span class="slider round"></span>
                                </label>
                                <?php } ?>

                                </td>
                                <td> 

                                    <div class="user_action_box">

                                        <div class="colleagues_profile_actions_div"></div>

                                        <ul class="profile_actions_list">
                                             <?php if ($CI->modules->get_tool_config('MT-ODO-UPDATE-AMB', 'M-AMB-UPD-ODO', true) != '') { ?>

                <li><a class="onpage_popup action_button" data-href="{base_url}amb/amb_all_odometer_update" data-qr="output_position=popup_div&amp;tm_id=<?php echo base64_encode($value->id); ?>&amp;amb_action=view" data-popupwidth="1000" data-popupheight="800">Update Odometer</a></li>

        <?php } ?>
                                        </ul> 
                                    </div>
                                </td>
                            </tr>
    <?php }
} else { ?>

                        <tr><td colspan="12" class="no_record_text">No history Found</td></tr>

<?php } ?>   

                </table>


            </div>
        </form>
    </div>
    </div>
<script>;
    jQuery(document).ready(function () {

        var dateFormat = "mm/dd/yy",
                from = jQuery("#from_date")
                .datepicker({
                    defaultDate: new Date(),
                    changeMonth: true,
                    changeYear: true,
                    numberOfMonths: 1
                })
                .on("change", function () {
                    to.datepicker("option", "minDate", getDate(this));
                }),
                to = jQuery("#to_date").datepicker({
            defaultDate:  new Date(),
            changeMonth: true,
            changeYear: true,
            numberOfMonths: 1
        })
                .on("change", function () {
                    from.datepicker("option", "maxDate", getDate(this));
                });

        function getDate(element) {
            var date;
            try {
                date = $.datepicker.parseDate(dateFormat, element.value);
            } catch (error) {
                date = null;
            }
            return date;
        }
    });

    function update_flag(id,flag){

        var $inc_ref_id = id;
    var $flag = flag;
    $.ajax({
            url: base_url + 'amb/update_amb_odo_flag',
            type:'POST',
            dataType: 'json',
             data: { inc_ref_id: $inc_ref_id, flag:$flag }   

             });
    }
   
</script>