<?php
    $CI = EMS_Controller::get_instance();
    defined('BASEPATH') OR exit('No direct script access allowed');


    $arr = array(
        'page_no' => @$page_no,
        'records_on_page' => @$page_load_count,
        'dashboard' => 'yes'
    );

    $data = json_encode($arr);
    $data = base64_encode($data);
    ?>
  

    <div class="width100">
       
        <div id="supervisor_container_amb">

            <!--<h3 class="txt_clr5 width2 float_left">ERO Dashboard</h3><br>-->

            <div id="calls_inc_list_amb">

                <form method="post" name="inc_list_form" id="inc_list">  
                    <div class="width100" id="ero_dash">

                        <div id="amb_filters">
                            <div class="width80 float_left">                   

                                <div class="search">

                                    <div class="row">

                                        <div class="width100 float_left">

                                            <div class="width20 float_left">
                                                <h3 class="txt_clr2 "><?php echo $title ?></h3>
                                            </div>

                                            <div class="width20 float_left">
                                                <input type="text"  class="controls amb_search" id="mob_no" name="call_search" value="<?php echo @$rg_no; ?>" placeholder="Search"/>
                                            </div>

                                            <div class="width20  float_left">
                
                                            <!-- <select name="dist_search" class="filter_required" data-errors="{filter_required:'District should not be blank!'}"> -->
                                                <select name="dist_search_assign">
                                                    <option value=""></option>
                                                        <?php foreach ($district_data as $key) { ?>
                                                            <option value="<?php echo $key->dst_code ?>"><?php echo $key->dst_name ?></option>
                                                        <?php  } ?>

                                                </select>
                                            </div>
                                 
                                            <div class="width20  float_left">

                                                <input name="amb_no_search_assign" class="mi_autocomplete dropdown_per_page width97" data-href="{base_url}auto/get_ambulance" placeholder="Select Ambulance" data-errors="{filter_required:'Please select state from dropdown list'}" tabindex="15" autocomplete="off" value="<?php echo $amb_reg_no; ?>" data-value="<?php echo $amb_reg_no; ?>">
                                               
                                                <input type="hidden" name="req_type" value="amb">

                                            </div>

                                            <div class="width_11 float_left">
                                                <input type="button" class="search_button float_right  form-xhttp-request" name="" value="Search" data-href="{base_url}supervisor/assign_ambulance_list" data-qr="output_position=content&amp;flt=true&amp;type=inc" />
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div id="list_table">

                            <table class="table report_table">
                                <tr>      
                                    <th>Sr.No</th>
                                    <th nowrap>Ambulance No</th>
                                    <th nowrap> Last assign time </th>
                                    <th nowrap>Base Location</th>
                                    <th nowrap>District </th>
                                    <th nowrap>Ambulance Type</th>
                                    <th nowrap>Incident ID</th>
                                    <th nowrap>Incident Address</th>
                                    <th nowrap>Caller Number -Name  </th>
                                    <th nowrap>Chief Complaint</th>
                                    <th nowrap>Closure Pending From</th>
                                    <th nowrap>Action</th>
                                    <th nowrap>Changes</th>
                                </tr>

                                <?php
                                if (!empty($result) > 0) {

                                    $total = 0;
                                    $cur_page_sr = ($cur_page - 1) * 20;
                                    foreach ($result as $key => $inc) {

                                        $current_time = date('Y-m-d H:i:s'); 

                                        $first_date = new DateTime($current_time);
                            
                                        $second_date = new DateTime($inc->timestamp);
                                    
                                        $interval = $first_date->diff($second_date);

                                        $days_passed = $interval->format('%a');
                                        $hours_diff = $interval->format('%H');
                                        $min = $interval->format('%I');
                                        $sec = $interval->format('%S');
                                 
                                        $diff_time= ($days_passed*24 + $hours_diff).':'.$min.':'.$sec ;
                                        
                                        if ($inc->clr_fullname != '') {
                                            $caller_name = $inc->clr_fullname;
                                        } else {
                                            $caller_name = $inc->clr_fname . " " . $inc->clr_mname . " " . $inc->clr_lname;
                                        }
                                        ?>

                                        <tr>
                                            <td><?php echo $cur_page_sr + $key + 1; ?></td>
                                            <td  nowrap><?php echo $inc->amb_rto_register_no; ?></td>
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

                                            <td>
                                                <a class="single onpage_popup"  data-href="{base_url}calls/single_record_view?inc_ref_id=<?php echo $inc->inc_ref_id; ?>" data-qr="output_position=popup_div" data-popupwidth="1300" data-popupheight="900"><?php echo $inc->inc_ref_id; ?>
                                        </a>
                                    </td>





                                             <td ><?php echo $inc->inc_address; ?></td>
                                          
                                            <td ><?php
                                                echo $inc->clr_mobile;
                                                echo "-";
                                                echo ucwords($caller_name);
                                                ?></td>

                                            <?php if ($inc->inc_mci_nature != '') { ?>
                                                <td ><?php echo $inc->ct_type;//get_mci_nature_service($inc->inc_mci_nature); ?></td>
                                            <?php } else { ?>
                                                <td ><?php echo $inc->ct_type; ?></td>
                                            <?php } ?>
                                            <td ><?php echo $diff_time; ?></td>

                                            <td> <a class="click-xhttp-request onpage_popup btn" data-href="{base_url}supervisor/remark?amb_rto_register_no=<?php echo $inc->amb_rto_register_no; ?>&inc_ref_id=<?php echo $inc->inc_ref_id; ?>" data-qr="output_position=cboxLoadedContent" data-popupwidth="300" data-popupheight="300">Action</a>
                                            </td>

                                            <td> <a class="click-xhttp-request onpage_popup float_left btn" data-href="{base_url}supervisor/release?amb_rto_register_no=<?php echo $inc->amb_rto_register_no; ?>&inc_ref_id=<?php echo $inc->inc_ref_id; ?>" data-qr="output_position=popup_div" data-popupwidth="300" data-popupheight="300">Release</a>
                
                                            <a class="click-xhttp-request btn" data-href="{base_url}inc/show_amb_clo_pending" data-qr="output_position=popup_div&amb_reg_no=<?php echo $inc->amb_rto_register_no;?>">Pending</a>         
                                            
                                            </td>
                                        </tr>
                                    <?php } ?>

                                <?php } else { ?>

                                    <tr><td colspan="15" class="no_record_text">No Record Found</td></tr>



                                <?php } ?>   





                            </table>



                            <div class="bottom_outer">

                                <div class="pagination"><?php echo $amb_pagination; ?></div>

                                <input type="hidden" name="submit_data" value="<?php
                                if (@$data) {
                                    echo $data;
                                }
                                ?>">

                                <div class="width33 float_right">

                                    <div class="record_per_pg">

                                        <div class="per_page_box_wrapper">

                                            <span class="dropdown_pg_txt float_left"> Records per page : </span>

                                            <select name="pg_rec_amb" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}supervisor/assign_ambulance_list" data-qr="output_position=content&amp;flt=true&amp;type=inc">

                                                <?php echo rec_perpg_sup($pg_rec); ?>

                                            </select>

                                        </div>

                                        <div class="float_right">
                                            <span> Total records: <?php
                                                if (@$amb_total_count) {
                                                    echo $amb_total_count;
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

        </div>
    </div>