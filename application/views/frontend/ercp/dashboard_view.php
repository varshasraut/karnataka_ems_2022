<?php $CI = EMS_Controller::get_instance();?>

<!-- <h3 class="txt_clr5 width2 float_left">Dashboard</h3> <br>-->

<style>
    .headerlbl{
    margin: 8px 0 0 0 !important;
}
input[type='text'] {
    margin-top : 4px !important;
}
</style>


<form method="post" name="ercp_dash_form" id="ercp_dash">  
<?php if($this->clg->clg_group == 'UG-COUNSELOR-104') {?>
    <div id="list_table">
        <div id="amb_filters" class="float_right width100">
            <div class="float_right width100">
                <div class="search">
                        <div class="width100 float_right mt-2">
                            <div class="width10 float_left">
                                <label class="headerlbl">Dashboard</label>
                            </div>
                            <?php if($clg_senior){?>
                            <div class="width25 float_left">
                                <select id="ercp_id" name="filter[ercp_id]" class=""  data-errors="{filter_required:'Please select Call Type from dropdown list'}">
                                    <option value="">Select ERCP</option>
                                    <?php foreach ($epcr_clg as $purpose_of_call) {
                                        if($purpose_of_call->clg_ref_id == $filter['ercp_id']){
                                            $selected = "selected";
                                        }else{
                                            $selected = "";
                                        }
                                        echo "<option value='" . $purpose_of_call->clg_ref_id . "'  $selected"; 

                                        echo" >" . $purpose_of_call->clg_ref_id."-". $purpose_of_call->clg_first_name." ". $purpose_of_call->clg_first_name;
                                        echo "</option>";
                                    } ?>
                                </select>
                            </div>
                            <?php } ?>
                            <div class="width25 float_left">
                                    <input name="filter[from_date]" tabindex="1" class="form_input filter_required" placeholder="From Date" type="text" data-base="search_btn" data-errors="{filter_required:'From Date should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}"  readonly="readonly" id="from_date" value="<?php echo $filter['from_date'];?>">
                            </div>
                            <div class="width25 float_left">
                                <input name="filter[to_date]" tabindex="2" class="form_input filter_required" placeholder="To Date" type="text" data-base="search_btn" data-errors="{filter_required:'To Date should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" readonly="readonly" id="to_date" value="<?php echo $filter['to_date'];?>" >
                            </div>
                            <div class="width_14 float_left">
                            <input type="button" class="search_button form-xhttp-request" name="" value="Search" data-href="{base_url}counselor104" data-qr="output_position=content&amp;flt=true&amp;type=inc" />
                            </div>
                        </div>
                </div>
            </div>
        </div>


        <table class="table report_table table-bordered">

            <tr class="text-center">                                     
                <th>Sr.No</th>
                <th>Date</th>
                <th>Incident ID</th>
                <th>Attended By</th>
                <th>Action</th> 

            </tr>

            <?php
            if ($inc_list_help) {

                $key = 1;
                foreach ($inc_list_help as $inc) {
            
                    ?>
                    <tr>

                                <td><?php echo $key++; ?></td>


                        <?php $dtm = explode(" ", $inc->inc_datetime);    date('d-m-Y', strtotime($dtm[0])); ?>

                        <td><?php echo  date("d-m-Y h:m:i", strtotime($inc->inc_datetime)); ?></td>

                        <td><a href="{base_url}calls/single_record_view" class="onpage_popup" data-qr="output_position=popup_div&inc_ref_id=<?php echo $inc->inc_ref_id; ?>" data-popupwidth="1500" data-popupheight="800" style="color:#000;"><?php echo $inc->inc_ref_id; ?></td>

                        <td class="width25">
                            <?php $adv_emt = get_clg_data_by_ref_id($inc->cons_emt); ?>
                            <?php echo $inc->cons_emt; ?> <?php //echo $adv_emt->clg_last_name; ?>
                        </td>

                        <td>
                            <div style="position:relative;"> 
                                <div class="actions_div"></div>
                                <ul class="actions_list">

                                <li><a class="btn expand_button expand_btn" data-target="<?php echo "cl" . $inc->cons_id; ?>">VIEW</a> </li>

                                </ul>   
                            </div>
                        </td>

                    </tr>

                    <tr id="<?php echo "cl" . $inc->cons_id; ?>"  style="width:100%; position: relative; display:none;padding-left:20px;" class="expand_pan">

                        <td  class="no_before" colspan="9">

                            <?php if (!empty($prev_cl_dtl[$inc->inc_ref_id])) { ?>
                                <ul class="dtl_block">
                                    <?php
                                    //var_dump($prev_cl_dtl[$inc->inc_ref_id]);
                                    $CALL = 1;
                                    foreach ($prev_cl_dtl[$inc->inc_ref_id] as $cll_dtl) {
                                        ?>
                                        <li><a class="onpage_popup" data-href="{base_url}counselor104/prev_counslor_call_info" data-qr="output_position=popup_div&amp;cons_cl_adv_id=<?php echo $cll_dtl->cons_cl_adv_id; ?>&cons_cl_id=<?php echo $cll_dtl->cons_cl_id; ?>" data-popupwidth="1500" data-popupheight="800"><span > <?php echo "CALL " . $CALL++; ?> : <?php echo $cll_dtl->ct_type; ?> </span></a></li>
                                    <?php }
                                    ?>
                                </ul>
                            <?php } else { ?>    

                                Call details not available.

                            <?php } ?>

                        </td>
                    </tr>

                    <?php
                }
            } else {
                ?>

                <tr><td colspan="9" class="no_record_text">No Record Found</td></tr>

            <?php } ?>   


        </table>

        <div class="bottom_outer">

            <div class="pagination"><?php echo $pagination; ?></div>

            <div class="width33 float_right">

                <div class="record_per_pg">

                    <div class="per_page_box_wrapper">

                        <span class="dropdown_pg_txt float_left"> Records per page : </span>

                        <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}ercp" data-qr="output_position=content&amp;flt=true">

                            <?php echo rec_perpg($pg_rec); ?>

                        </select>

                    </div>

                    <div class="float_right">
                        <span> Total records: <?php echo ($inc_total > 0) ? $inc_total : "0"; ?> </span>
                    </div>

                </div>

            </div>

        </div>



    </div>
    <?php }
    else if($this->clg->clg_group == 'UG-ERCP-104') {?>
    <div id="list_table">
        <div id="amb_filters" class="float_right width100">
            <div class="float_right width100">
                <div class="search">
                        <div class="width100 float_right mt-2">
                            <div class="width10 float_left">
                                <label class="headerlbl">Dashboard</label>
                            </div>
                            <?php if($clg_senior){?>
                            <div class="width25 float_left">
                                <select id="ercp_id" name="filter[ercp_id]" class=""  data-errors="{filter_required:'Please select Call Type from dropdown list'}">
                                    <option value="">Select ERCP</option>
                                    <?php foreach ($epcr_clg as $purpose_of_call) {
                                        if($purpose_of_call->clg_ref_id == $filter['ercp_id']){
                                            $selected = "selected";
                                        }else{
                                            $selected = "";
                                        }
                                        echo "<option value='" . $purpose_of_call->clg_ref_id . "'  $selected"; 

                                        echo" >" . $purpose_of_call->clg_ref_id."-". $purpose_of_call->clg_first_name." ". $purpose_of_call->clg_first_name;
                                        echo "</option>";
                                    } ?>
                                </select>
                            </div>
                            <?php } ?>
                            <div class="width25 float_left">
                                    <input name="filter[from_date]" tabindex="1" class="form_input filter_required" placeholder="From Date" type="text" data-base="search_btn" data-errors="{filter_required:'From Date should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}"  readonly="readonly" id="from_date" value="<?php echo $filter['from_date'];?>">
                            </div>
                            <div class="width25 float_left">
                                <input name="filter[to_date]" tabindex="2" class="form_input filter_required" placeholder="To Date" type="text" data-base="search_btn" data-errors="{filter_required:'To Date should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" readonly="readonly" id="to_date" value="<?php echo $filter['to_date'];?>" >
                            </div>
                            <div class="width_14 float_left">
                            <input type="button" class="search_button form-xhttp-request" name="" value="Search" data-href="{base_url}ercp104" data-qr="output_position=content&amp;flt=true&amp;type=inc" />
                            </div>
                        </div>
                </div>
            </div>
        </div>


        <table class="table report_table table-bordered">

            <tr class="text-center">                                     
                <th>Sr.No</th>
                <th>Date</th>
                <th>Incident ID</th>
                <th>Attended By</th>
                <th>Action</th> 

            </tr>

            <?php
            if ($inc_list_help) {

                $key = 1;
                foreach ($inc_list_help as $inc) {
            
                    ?>
                    <tr>

                                <td><?php echo $key++; ?></td>


                        <?php $dtm = explode(" ", $inc->inc_datetime);    date('d-m-Y', strtotime($dtm[0])); ?>

                        <td><?php echo  date("d-m-Y h:m:i", strtotime($inc->inc_datetime)); ?></td>

                        <td><a href="{base_url}calls/single_record_view" class="onpage_popup" data-qr="output_position=popup_div&inc_ref_id=<?php echo $inc->inc_ref_id; ?>" data-popupwidth="1500" data-popupheight="800" style="color:#000;"><?php echo $inc->inc_ref_id; ?></td>

                        <td class="width25">
                            <?php $adv_emt = get_clg_data_by_ref_id($inc->adv_emt); ?>
                            <?php echo $inc->adv_emt; ?> <?php //echo $adv_emt->clg_last_name; ?>
                        </td>

                        <td>
                            <div style="position:relative;"> 
                                <div class="actions_div"></div>
                                <ul class="actions_list">

                                    <li><a class="btn expand_button expand_btn" data-target="<?php echo "cl" . $inc->adv_id; ?>">VIEW</a> </li>

                                </ul>   
                            </div>
                        </td>

                    </tr>

                    <tr id="<?php echo "cl" . $inc->adv_id; ?>"  style="width:100%; position: relative; display:none;padding-left:20px;" class="expand_pan">

                        <td  class="no_before" colspan="9">

                            <?php if (!empty($prev_cl_dtl[$inc->inc_ref_id])) { ?>
                                <ul class="dtl_block">
                                    <?php
                                    $CALL = 1;
                                    foreach ($prev_cl_dtl[$inc->inc_ref_id] as $cll_dtl) {
                                        ?>
                                        <li><a class="onpage_popup" data-href="{base_url}medadv/prev_help_call_info" data-qr="output_position=popup_div&amp;adv_cl_id=<?php echo $cll_dtl->adv_cl_id; ?>" data-popupwidth="1500" data-popupheight="800"><span > <?php echo "CALL " . $CALL++; ?> : <?php echo $cll_dtl->ct_type; ?> </span></a></li>

                                    <?php }
                                    ?>
                                </ul>
                            <?php } else { ?>    

                                Call details not available.

                            <?php } ?>

                        </td>
                    </tr>

                    <?php
                }
            } else {
                ?>

                <tr><td colspan="9" class="no_record_text">No Record Found</td></tr>

            <?php } ?>   


        </table>

        <div class="bottom_outer">

            <div class="pagination"><?php echo $pagination; ?></div>

            <div class="width33 float_right">

                <div class="record_per_pg">

                    <div class="per_page_box_wrapper">

                        <span class="dropdown_pg_txt float_left"> Records per page : </span>

                        <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}ercp" data-qr="output_position=content&amp;flt=true">

                            <?php echo rec_perpg($pg_rec); ?>

                        </select>

                    </div>

                    <div class="float_right">
                        <span> Total records: <?php echo ($inc_total > 0) ? $inc_total : "0"; ?> </span>
                    </div>

                </div>

            </div>

        </div>



    </div>
    <?php } else {?>
        <div id="list_table">
        <div id="amb_filters" class="float_right width100">
            <div class="float_right width100">
                <div class="search">
                        <div class="width100 float_right mt-2">
                            <div class="width10 float_left">
                                <label class="headerlbl">Dashboard</label>
                            </div>
                            <?php if($clg_senior){?>
                            <div class="width25 float_left">
                                <select id="ercp_id" name="filter[ercp_id]" class=""  data-errors="{filter_required:'Please select Call Type from dropdown list'}">
                                    <option value="">Select ERCP</option>
                                    <?php foreach ($epcr_clg as $purpose_of_call) {
                                        if($purpose_of_call->clg_ref_id == $filter['ercp_id']){
                                            $selected = "selected";
                                        }else{
                                            $selected = "";
                                        }
                                        echo "<option value='" . $purpose_of_call->clg_ref_id . "'  $selected"; 

                                        echo" >" . $purpose_of_call->clg_ref_id."-". $purpose_of_call->clg_first_name." ". $purpose_of_call->clg_first_name;
                                        echo "</option>";
                                    } ?>
                                </select>
                            </div>
                            <?php } ?>
                            <div class="width25 float_left">
                                    <input name="filter[from_date]" tabindex="1" class="form_input filter_required" placeholder="From Date" type="text" data-base="search_btn" data-errors="{filter_required:'From Date should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}"  readonly="readonly" id="from_date" value="<?php echo $filter['from_date'];?>">
                            </div>
                            <div class="width25 float_left">
                                <input name="filter[to_date]" tabindex="2" class="form_input filter_required" placeholder="To Date" type="text" data-base="search_btn" data-errors="{filter_required:'To Date should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" readonly="readonly" id="to_date" value="<?php echo $filter['to_date'];?>" >
                            </div>
                            <div class="width_14 float_left">
                                <!-- <input type="button" class="search_button float_right form-xhttp-request" name="" value="Search" data-href="{base_url}ercp" data-qr="output_position=content&amp;flt=true&amp;type=inc" /> -->
                                <input type="button" class="search_button form-xhttp-request" name="" value="Search" data-href="{base_url}ercp" data-qr="output_position=content&amp;flt=true&amp;type=inc" />
                            </div>
                        </div>
                </div>
            </div>
        </div>


        <table class="table report_table table-bordered">

            <tr class="text-center">                                     

                <th>Date</th>
                <th>Incident ID</th>
                <th>District Name</th>
                <th>Doctor Name</th>
                <th>Mobile No 1</th>
                <th>Mobile No 2</th>
                <th>Incident Address</th>
                <th>Attended By</th>
                <th>Action</th> 

            </tr>

            <?php
            if ($inc_list) {

                $key = 1;
                foreach ($inc_list as $inc) {
            
                    ?>
                    <tr>

                                <!--<td><?php echo $key++; ?></td>-->


                        <?php $dtm = explode(" ", $inc->inc_datetime);    date('d-m-Y', strtotime($dtm[0])); ?>

                        <td><?php echo  date("d-m-Y h:m:i", strtotime($inc->inc_datetime)); ?></td>

                        <td><a href="{base_url}calls/single_record_view" class="onpage_popup" data-qr="output_position=popup_div&inc_ref_id=<?php echo $inc->inc_ref_id; ?>" data-popupwidth="1500" data-popupheight="800" style="color:#000;"><?php echo $inc->inc_ref_id; ?></td>

                        <td><?php echo $inc->dst_name; ?></td>

                        <td><?php echo ucwords($inc->clg_first_name); ?> <?php echo ucwords($inc->clg_last_name); ?></td>                          
                        <td><?php echo $inc->amb_default_mobile; ?></td>
                        <td><?php echo $inc->amb_pilot_mobile; ?></td>    

                        <td class="width25"><?php echo $inc->inc_address; ?></td>

                        <td class="width25">
                            <?php $adv_emt = get_clg_data_by_ref_id($inc->adv_emt); ?>
                            <?php echo $inc->adv_emt; ?> <?php //echo $adv_emt->clg_last_name; ?>
                        </td>

                        <td>
                            <div style="position:relative;"> 
                                <div class="actions_div"></div>
                                <ul class="actions_list">

                                    <li><a class="btn expand_button expand_btn" data-target="<?php echo "cl" . $inc->adv_id; ?>">VIEW</a> </li>

                                </ul>   
                            </div>
                        </td>

                    </tr>

                    <tr id="<?php echo "cl" . $inc->adv_id; ?>"  style="width:100%; position: relative; display:none;padding-left:20px;" class="expand_pan">

                        <td  class="no_before" colspan="9">

                            <?php if (!empty($prev_cl_dtl[$inc->inc_ref_id])) { ?>

                                <ul class="dtl_block">

            <!--                                    <li><span><?php echo $inc->inc_ref_id; ?></span></li>-->


                                    <?php
                                    $CALL = 1;

                                    foreach ($prev_cl_dtl[$inc->inc_ref_id] as $cll_dtl) {
                                        ?>

                                        <li><a class="onpage_popup" data-href="{base_url}medadv/prev_call_info" data-qr="output_position=popup_div&amp;adv_cl_id=<?php echo $cll_dtl->adv_cl_id; ?>" data-popupwidth="1500" data-popupheight="800"><span > <?php echo "CALL " . $CALL++; ?> : <?php echo $cll_dtl->que_question; ?> </span></a></li>


                                    <?php }
                                    ?>
                                </ul>

                            <?php } else { ?>    

                                Call details not available.

                            <?php } ?>

                        </td>
                    </tr>

                    <?php
                }
            } else {
                ?>

                <tr><td colspan="9" class="no_record_text">No Record Found</td></tr>

            <?php } ?>   


        </table>

        <div class="bottom_outer">

            <div class="pagination"><?php echo $pagination; ?></div>

            <div class="width33 float_right">

                <div class="record_per_pg">

                    <div class="per_page_box_wrapper">

                        <span class="dropdown_pg_txt float_left"> Records per page : </span>

                        <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}ercp" data-qr="output_position=content&amp;flt=true">

                            <?php echo rec_perpg($pg_rec); ?>

                        </select>

                    </div>

                    <div class="float_right">
                        <span> Total records: <?php echo ($inc_total > 0) ? $inc_total : "0"; ?> </span>
                    </div>

                </div>

            </div>

        </div>



    </div>
        <?php } ?>

</form>
<script>;
    jQuery(document).ready(function () {

        var dateFormat = "mm/dd/yy",
                from = jQuery("#from_date")
                .datepicker({
                    defaultDate:  new Date(),
                    changeMonth: true,
                    numberOfMonths: 2
                })
                .on("change", function () {
                    to.datepicker("option", "minDate", getDate(this));
                }),
                to = jQuery("#to_date").datepicker({
            defaultDate:  new Date(),
            changeMonth: true,
            numberOfMonths: 2
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
