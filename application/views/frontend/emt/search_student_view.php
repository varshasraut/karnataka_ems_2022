<div class="float_left width100">
    <?php
    $CI = EMS_Controller::get_instance();
    ?>
    <div class="width100 float_left">
        <div class=""><h3 class="txt_clr2 width1">Student Search</h3> </div>     
        <form method="post" name="" id="call_dls_info" class="">
            <div class="width100 float_left">
                    <div class="width25 float_left drg">
                        <div class="width100 float_left">
                            <div class="style6 float_left">Regisration Number:</div>
                        </div>
                        <div class="width100 float_left">
                            <input name="reg_no" tabindex="1" class="form_input filter_either_or[first_name,last_name,reg_no]" placeholder="Regisration Number" type="text" data-base="search_btn" data-errors="{filter_either_or:'Regisration Number should not be blank!'}" value="" id="reg_no">
                        </div>
                    </div>
<!--                    <div class="width100 text_align_center">
                        or
                    </div>-->
                <div class="width25 float_left">
                    <div class="width100 float_left drg">
                        <div class="width100 float_left">
                            <div class="style6 float_left">First Name : </div>
                        </div>
                        <div class="width100 float_left">
                            <input name="first_name" tabindex="5" class="form_input filter_either_or[first_name,last_name,reg_no]" placeholder="First Name" type="text" data-base="send_sms" data-errors="{filter_either_or:'First Name should not be blank!'}" value="<?php echo $inc_ref_id; ?>" id="first_name">
                        </div>
                    </div>
                </div>

                    <div class="width25 float_left">
                        <div class="width100 float_left">
                            <div class="style6 float_left">Last Name :</div>
                        </div>
                        <div class="width100 float_left">
                            <input name="last_name" tabindex="2" class="form_input filter_either_or[first_name,last_name,reg_no]" placeholder="Last Name" type="text" data-base="search_btn" data-errors="{filter_either_or:'Last Name should not be blank!'}" value="" id="last_name">
                        </div>
                    </div>
            
<!--                <div class="width100 text_align_center">
                    or
                </div>-->

                <div class="width25 float_left">
                     <div class="width100 float_left">
                         <div class="style6 float_left">&nbsp;</div>
                        </div>
                        <div class="width100 float_left">
                            <input type="hidden" name="schedule_id" value="<?php echo $schedule_id; ?>">
                            <input type="button" name="accept" value="Search" class="accept_btn form-xhttp-request" data-href='{base_url}emt/student_search_list' data-qr="output_position=pat_details_block"  tabindex="25" style="margin-top:0px;">
                        </div>
                   
                </div>
            </div>
        </form>
    </div>
    <div class="width100 float_left" id="student_search_list">
        <div class="breadcrumb float_left">
            <ul>
                <li>
                    <h2>Student Listing</h2>
                </li>
            </ul>
        </div>

        <br><br>

        <div class="box3">    

            <div class="permission_list group_list">

                <form method="post" name="amb_form" id="amb_list">  

                    <div id="amb_filters"></div>

                    <div id="list_table">


                        <table class="table report_table">

                            <tr>                                   
                                <th nowrap>Sr No</th>
                                <th nowrap>Registration No</th>
                                <th nowrap>Student Name</th>
                                <th>Action</th> 

                            </tr>

                            <?php
                            if (count($result) > 0) {

                                $total = 0;
                                foreach ($result as $value) {
                                    ?>
                                    <tr>

                                        <td><?php echo $value->school_name; ?></td>

                                        <td><?php echo date("d-m-y", strtotime($inc->inc_datetime)); ?></td>

                                        <td><?php echo $value->school_mobile; ?></td>
                                        <td><?php echo $value->school_address; ?></td>

                                        <td> 
<a href="{base_url}emt/student_basic_info?stud_id=<?php echo base64_encode($value->stud_id);?>&schedule_id=<?php echo  base64_encode($schedule_id); ?>" class="btn click-xhttp-request" data-qr="output_position=content">Select</a>  
                                        </td>
                                    </tr>

                                <?php }
                            } else { ?>
                    <tr><td colspan="9" class="no_record_text">No Student Found</td></tr>

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

                                        <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}school/school_listing" data-qr="output_position=content&amp;flt=true">

<?php echo rec_perpg($pg_rec); ?>

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
    </div>
</div>