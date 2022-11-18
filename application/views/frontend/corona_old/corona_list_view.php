<?php $CI = EMS_Controller::get_instance();?>

<script>
    <?php if($_SERVER['HTTP_HOST'] != 'www.mhems.in'){ ?>
start_incoming_call_event();
<?php  } ?>
</script>
<!--<a href="{base_url}corona/add_patient" class="btn onpage_popup float_right" data-qr="output_position=content" data-popupwidth="800" data-popupheight="700"> Add Patient </a>-->
<form method="post" name="ercp_dash_form" id="ercp_dash">  
    <h3 class="txt_clr5 width2 float_left">Corona Dashboard</h3><br>
<div id="list_table">
    <table class="table report_table">
    <tr>                                     
        <th>Name</th>
        <th>Mobile No</th>
        <th>District</th>
        <th>Address</th>
<!--        <th>Status</th>-->
        <th>Action</th>
    </tr>

            <?php
            if ($corona_list) {

                $key = 1;
                foreach ($corona_list as $corona) {

                   // var_dump($corona);
                    ?>
                    <tr>

                        <td style="width:15%;"><?php echo ucwords($corona->full_name); ?></td>
                        <td style="width:15%;"><?php echo $corona->mobile_no; ?></td>
                        <td style="width:15%;">
                            <?php //echo $corona->district_id; ?>
                            <?php if($corona->district_id == "0"){echo "NA";}else{echo get_district_by_id($corona->district_id);}?>
                        </td>
                        <td style="width:15%;"><?php echo $corona->address; ?></td>
                        <td style="width:15%;"><?php 
//                        if($corona->is_case_close == 0){
//                            echo "Case Open";
//                            
//                        }else{ "Case Closed"; } 
                        ?>
                        <a href="{base_url}corona/view_case?id=<?php echo $corona->corona_id; ?>" class="expand_button expand_btn btn" data-qr="output_position=follow_up_calls_<?php echo $corona->corona_id; ?>&id=<?php echo $corona->corona_id; ?>" data-target="<?php echo "cl" . $corona->corona_id; ?>" > View </a>
                        <a href="{base_url}corona/add_follow_up?id=<?php echo $corona->corona_id; ?>" class="btn onpage_popup" data-qr="output_position=content&id=<?php echo $corona->corona_id; ?>" data-popupwidth="1200" data-popupheight="700"> Add </a>
                        </td>
                        

                       

                    </tr>
                    <tr style="min-height: 1px; height: 1px;">
                        
                        <td colspan="5">
                            <div id="follow_up_calls_<?php echo $corona->corona_id; ?>">
                            </div>
                        </td>
                    </tr>
                    <tr id="<?php echo "cl" . $corona->corona_id; ?>"  style="width:100%; position: relative; display:none;padding-left:20px;" class="expand_pan">

                        <td  class="no_before" colspan="9">

                            <?php if (!empty($prev_cl_dtl[$corona->corona_id])) { ?>

                                <ul class="dtl_block">

            <!--                                    <li><span><?php echo $inc->inc_ref_id; ?></span></li>-->


                                    <?php
                                    $CALL = 1;

                                    foreach ($prev_cl_dtl[$corona->corona_id] as $cll_dtl) {
                                        ?>

                                        <li><a class="onpage_popup" data-href="{base_url}corona/view_call_details" data-qr="output_position=popup_div&amp;&id=<?php echo $cll_dtl->follow_up_id; ?>" data-popupwidth="1200" data-popupheight="680"><span > <?php echo "CALL " . $CALL++; ?> : <?php echo $cll_dtl->follow_up_date; ?> </span></a></li>


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
</form>
