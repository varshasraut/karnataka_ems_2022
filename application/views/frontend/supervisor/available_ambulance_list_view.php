<?php $CI = EMS_Controller::get_instance(); ?>

<!--<h3 class="txt_clr5 width2 float_left">ERO Dashboard</h3><br>-->

<div id="calls_inc_list">

    <form method="post" name="inc_list_form" id="inc_list">  
        <div class="width100" id="ero_dash">
            <div id="amb_filters">
                <div class="width80 float_left">                   

                    <div class="search">

                        <div class="row">

                            <div class="width100 float_left">
                                <div class="width20 float_left">
                                    <h3 class="txt_clr2 ">Available ambulance List</h3>
                                </div>

                                <div class="width20 float_left">
                                    <input type="text"  class="controls amb_search" id="mob_no" name="call_search" value="<?php echo @$rg_no; ?>" placeholder="Search"/>
                                </div>
 
                                <div class="width20  float_left">
                
                                    <!-- <select name="dist_search" class="filter_required" data-errors="{filter_required:'District should not be blank!'}"> -->
                                    <select name="dist_search_assign">
                                        <option value="">Select District</option>
                                            <?php foreach ($district_data as $key) { ?>
                                                <option value="<?php echo $key->dst_code ?>"><?php echo $key->dst_name ?></option>
                                            <?php  } ?>

                                    </select>
                                </div>

								<div class="width20 float_left">

                                    <input name="amb_no_search_assign" class="mi_autocomplete dropdown_per_page width97" data-href="{base_url}auto/get_ambulance" placeholder="Select Ambulance" data-errors="{filter_required:'Please select state from dropdown list'}" tabindex="15" autocomplete="off" value="<?php echo $amb_reg_no; ?>" data-value="<?php echo $amb_reg_no; ?>">
                                
                                    <input type="hidden" name="req_type" value="amb">

                                </div>

                                <div class="width_17 float_left">

                                    <input type="button" class="search_button float_right  form-xhttp-request" name="" value="Search" data-href="{base_url}supervisor/available_ambulance_list" data-qr="output_position=content&amp;flt=true&amp;type=inc" />
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div id="list_table">

                <table class="table report_table tblclr table-responsive">
                    <tr>      
                        <th>Sr.No</th>
                        <th nowrap>Ambulance No</th>
                        <th nowrap>Last assign time</th>
                        <th nowrap>Base Location</th>
                        <th nowrap>District </th>
                        <th nowrap>Ambulance Type</th>
                        <th nowrap>Status</th>
                        <th nowrap>Action</th>

                    </tr>

                    <?php
                    if (count($result) > 0) {

                        $total = 0;
                        $cur_page_sr = ($cur_page - 1) * 10;
                        foreach ($result as $key => $inc) {

                            if ($inc->clr_fullname != '') {
                                $caller_name = $inc->clr_fullname;
                            } else {
                                $caller_name = $inc->clr_fname . " " . $inc->clr_mname . " " . $inc->clr_lname;
                            }
                            ?>

                            <tr>

                                <td><?php echo $cur_page_sr + $key + 1; ?></td>
                                <td  nowrap><?php echo $inc->amb_no; ?></td>
                                <td><?php
                                    if ($inc->timestamp) {
                                        echo date("d-m-Y h:i:s", strtotime($inc->timestamp));
                                    } else {
                                        echo "-";
                                    }
                                    ?></td>
                                <td><?php echo $inc->hp_name; ?></td>
                                <td ><?php echo $inc->dst_name; ?></td>
                                <td ><?php echo $inc->ambt_name; ?></td>
                                <td><?php echo $inc->ambs_name; ?> </td>   
                                <td> <a class="onpage_popup btn" data-href="{base_url}supervisor/remark?amb_rto_register_no=<?php echo $inc->amb_rto_register_no; ?>" data-qr="output_position=popup_div" data-popupwidth="300" data-popupheight="300">Action</a></td>

                            </tr>

                        <?php } ?>

<?php } else { ?>

                        <tr><td colspan="11" class="no_record_text">No Record Found</td></tr>

<?php } ?>   

                </table>

                <div class="bottom_outer">

                    <div class="pagination"><?php echo $pagination; ?></div>

                    <input type="hidden" name="submit_data" value="<?php
                    if (@$data) {
                        echo $data;
                    }
                    ?>">

                    <div class="width33 float_right">

                        <div class="record_per_pg">

                            <div class="per_page_box_wrapper">

                                <span class="dropdown_pg_txt float_left"> Records per page : </span>

                                <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}supervisor/available_ambulance_list" data-qr="output_position=content&amp;flt=true&amp;type=inc">

                                <?php echo rec_perpg($pg_rec); ?>

                                </select>

                            </div>

                            <div class="float_right">
                                <span> Total records: <?php
                                    if (@$total_count) {
                                        echo $total_count;
                                    } else {
                                        echo"0";
                                    }
                                    ?> </span>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </form>
</div>

<style>
    table.report_table,
    table.report_table td {
        border: none;
        padding: 5px;
    }

    .tblclr th {
        background-color: #39CDAB !important;
        color: white !important;
        font-weight: 600 !important;
        font-size: 13px;
        text-align: center;
        padding: 10px 5px;
    }
    .tblclr td {
        color: black !important;
        font-size: 13px;
        border: 1px solid #dee2e6 !important;

    }
</style>

