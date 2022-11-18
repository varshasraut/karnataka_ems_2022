<?php
$CI = EMS_Controller::get_instance();
?>

<div class="msg"><?php echo $res; ?></div>
<div class="breadcrumb float_left">
    <ul>
        <li><span>Incident Listing</span></li>
    </ul>
</div>

<div class="box3">    

    <div class="permission_list group_list">

        <form method="post" action="#" name="colleagues_list_form" class="colleagues_list_form">  

            <div id="clg_filters">

                <div class="filters_groups">                   

                    <div class="search">
                        <div class="row list_actions clg_filt">

                            <div class="search_btn_width">
                                
                                <div class="filed_input float_left width_20">
                                    <input class="form_input width100" type="text" id="search_clg" placeholder="Search Name" value="<?php echo @$search; ?>" name="search" style="width: 95% !important;">
                                </div>                              
                                <div class="filed_input float_left width_20">  
                                  
                                    <input type="button" name="search_btn" value="Search" class="btn clg_search form-xhttp-request float_left" data-href="{base_url}quality_froms/view_feedback_incidence_quality" data-qr="output_position=content&amp;filter_search=search&amp;module_name=clg&amp;tlcode=MT-CLG-ACTION-MULTI&amp;action_name=search_clgs" style="float:left !important;" >
                                   
                                </div>
                            </div>


                        </div>


                    </div>

                </div>

            </div>

            <div id="list_table">


                <table class="table report_table">
                    <tr>                
                        <th nowrap>Incident ID</th>
                        <th nowrap>Date time</th>
                        <th nowrap>Caller Name</th>
                        <th nowrap>Caller Number</th>
                        <th nowrap>Call Type</th>
                        <th nowrap>Quality Audit</th>
                    </tr>

                    <?php if (count(@$inc_info) > 0) {
                        $total = 0;

                        foreach ($inc_info as $key => $inc) { 
                    
                             $caller_name = $inc->gc_caller_name;
                            ?>
                            <tr>
                                <td><?php echo $inc->inc_ref_id;?></td> 
                                <td><?php echo date("d-m-Y h:m:i", strtotime($inc->inc_datetime)); ?></td>
                                <td><?php echo ucwords($caller_name); ?></td>
                                <td><?php echo $inc->clr_mobile; ?></td>
                                <td nowrap><?php echo ucwords($inc->pname); ?></td>
                                <td nowrap>
                                    <?php if($inc->inc_audit_status == '0'){?>
                                    <a class="click-xhttp-request action_button btn" data-href="{base_url}quality_forms/open_audit"  data-qr="output_position=content&amp;tlcode=MT-PREV-MANT-VIEW&amp;inc_ref_id=<?php echo $inc->inc_ref_id; ?>&ref_id=<?php echo $ref_id;?>&user_type=<?php echo $user_type;?>" data-popupwidth="1000" data-popupheight="350">Audit</a>
                                    <?php } else{ ?>
                                    <a class="click-xhttp-request action_button btn" data-href="{base_url}quality_forms/open_audit"  data-qr="output_position=content&amp;tlcode=MT-PREV-MANT-VIEW&amp;inc_ref_id=<?php echo $inc->inc_ref_id; ?>&ref_id=<?php echo $ref_id;?>&user_type=<?php echo $user_type;?>&type=edit" data-popupwidth="1000" data-popupheight="350">Edit</a>
                                    <?php } ?>
                                
                                </td>
                                
                            </tr>
                        <?php
                        }
                    } else { ?>

                        <tr><td colspan="9" class="no_record_text">No history Found</td></tr>

                    <?php } ?>   

                </table>

                <div class="bottom_outer">

                    <div class="pagination"><?php echo $pagination; ?></div>

                    <input type="hidden" name="submit_data" value="<?php
                    if (@$data) {
                        echo $data;
                    }
                    ?>">

                    <div class="width38 float_right">

                        <div class="record_per_pg">

                            <div class="per_page_box_wrapper">

                                <span class="dropdown_pg_txt float_left"> Records per page : </span>

                                <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}quality_forms/view_feedback_incidence_quality" data-qr="output_position=content&amp;flt=true">

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
        </form>
    </div>
</div>