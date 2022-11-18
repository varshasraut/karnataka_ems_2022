<style>
    .width85{
        width:85% !important;
    }
    .margin-left{
        margin-left: -22px;
    }
</style>
<?php $CI = EMS_Controller::get_instance(); ?>

<div class="breadcrumb float_left">
    <ul>
        <li class="sms">
            <a class="click-xhttp-request" data-href="{base_url}amb/amb_listing">Ambulance</a>
        </li>
        <li>
            <span><?php if ($verify_status == "unapprove") { ?>Unapproved<?php } ?>Ambulance Odometer</span>
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
                        <div class="style6 float_left">District: </div>
                    </div>
                    <div class="width100 float_left">
                         <div id="incient_dist">
                            <?php
                           
                                $dt = array('dst_code' => $incient_district, 'st_code' => 'MP', 'auto' => 'amb_auto_addr', 'rel' => 'incient', 'disabled' => '');
                            

                            echo get_stat_dis($dt);
                            ?>
                        </div>

                    </div>
                </div>
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
                    <div class="width100 float_left">
                        <input name="from_date" tabindex="1" class="form_input filter_required width85" placeholder="From Date" type="text" data-base="search_btn" data-errors="{filter_required:'From Date should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}"  readonly="readonly" id="from_date" value="<?php echo @$from_date; ?>">
                    </div>
                </div>
                <div class="width20 drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left margin-left">To : </div>
                    </div>
                    <div class="width100 float_left">
                        <input name="to_date" tabindex="2" class="form_input filter_required width85 margin-left" placeholder="To Date" type="text" data-base="search_btn" data-errors="{filter_required:'To Date should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}"  readonly="readonly" id="to_date" value="<?php echo @$to_date; ?>">
                    </div>
                </div>
<!--                <div class="width20 float_left">
                    <div class="field_lable float_left width33"><label for="district">Date<span class="md_field">*</span></label></div>
                    <div class="filed_input float_left width50">
                          <input type="text"  class="mi_calender" name="to_date" value="<?php echo @$to_date; ?>" placeholder="Date" />

                    </div>

                </div>-->
                <div class="srch_box">
                    <!-- <input type="text" class="search_catalog" name="amb_item" value="" placeholder="Search"/> -->
                    <input type="button" class="search_button form-xhttp-request" name="Search" value="Search" data-href="{base_url}amb/amb_odometer_listing" data-qr="output_position=content&amp;flt=true" style="margin-top:29px !important;margin-left: -20px;" />

                    <input class="search_button click-xhttp-request" name="" value="Reset Filters" data-href="{base_url}amb/amb_odometer_listing" data-qr="output_position=content&amp;filters=reset" type="button" style="padding: 5px 13px !important;">
                   
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
                        <th nowrap>Base Location</th>
                        <th nowrap>District</th>
                        <th nowrap>Start odo</th>
                        <th nowrap>End Odo</th>
                        <th>Total</th>
                        <th>Odometer Type</th>
                        <th>Id of Case closure or Fleet	Timestamp</th> 
                        <th>Added by</th> 
                        <th>Modify by</th> 
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
                                  <td><?php if($value->hp_name == ''){ echo $value->ward_name; }else{ echo $value->hp_name; } ?> </td>
                                   <td><?php if($value->amb_district != ''){ echo get_district_by_id($value->amb_district); } ?></td>
                                <td><?php echo $value->start_odmeter; ?></td>
                               <td><?php echo $value->end_odmeter; ?></td>
                                <td><?php echo $value->end_odmeter - $value->start_odmeter ?></td> 
                                <td><?php 
                                $odo_type = array('closure'=> "Case Closure",'old_closure'=> "old Closure",'preventive maintenance'=>'preventive maintenance','breakdown maintenance'=>'breakdown maintenance','update breakdown maintaince'=>'update breakdown maintaince','Chng_new_fitted_odometer'=>'New fitted odometer','Updated from Back End'=>'Updated from Back End','Updated from Back End'=>'Updated from Back End','fuel_filling_during_case'=>'fuel filling during case','oxygen_filling_during_case'=>'Oxygen Filling During Case','fuel filling'=>'fuel filling');
                               // echo $odo_type[$value->odometer_type];
                                   $odometer_type = str_replace('-',' ', ucfirst($value->odometer_type));
                                   $odometer_type = str_replace('_',' ', ucfirst($odometer_type));
                                   echo $odometer_type;
                                ?></td>                            
                             
                                
                              <td><?php echo $value->inc_ref_id; ?></td> 
                              <td><?php  if($value->added_by != ''){ echo get_clg_name_by_ref_id($value->added_by); } ?></td> 
                                <td><?php if($value->modify_by != ''){ echo get_clg_name_by_ref_id($value->modify_by); }  ?></td> 
                                  <td><?php if($value->flag == '1'){ echo "Active"; }else if($value->flag == '2'){ echo "Inactive"; }  ?></td> 
                                <td> 

                                    <div class="user_action_box">

                                        <div class="colleagues_profile_actions_div"></div>

                                        <ul class="profile_actions_list">
                                             <?php if ($CI->modules->get_tool_config('MT-ODO-AMB-UPDATE', 'M-AMBU', true) != '') { ?>

                <li><a class="onpage_popup action_button" data-href="{base_url}amb/amb_odometer_update" data-qr="output_position=popup_div&amp;tm_id=<?php echo base64_encode($value->id); ?>&amp;amb_action=view&amp;amb_dst=<?php echo $value->amb_district; ?>" data-popupwidth="1000" data-popupheight="800">Update Odometer</a></li>

        <?php } ?>
                                        </ul> 
                                    </div>
                                </td>
                            </tr>
    <?php }
} else { ?>

                        <tr><td colspan="11" class="no_record_text">No history Found</td></tr>

<?php } ?>   

                </table>

                <div class="bottom_outer">

                    <div class="pagination"><?php echo $pagination; ?></div>

                    <input type="hidden" name="submit_data" value="<?php if (@$data) {
    echo $data;
} ?>">

                    <div class="width38 float_right">

                        <div class="record_per_pg">

                            <div class="per_page_box_wrapper">

                                <span class="dropdown_pg_txt float_left"> Records per page : </span>

                                <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}amb/amb_listing" data-qr="output_position=content&amp;flt=true">

<?php echo rec_perpg_sup($pg_rec); ?>

                                </select>

                            </div>

                            <div class="float_right">
                                <span> Total records: <?php echo (@$total_count) ? $total_count : "0"; ?> </span>
                            </div>
                        </div>

                    </div>

                </div>

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

</script>