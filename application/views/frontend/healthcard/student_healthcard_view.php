<?php
$CI = EMS_Controller::get_instance();
?>

<div class="width100">

    <div class="row">
        <div class="width100">
            <div class="emt_healthcard_header width100">
                <h2  class="width75 float_left">Student Health Card</h2>   
<!--                <a href="{base_url}healthcard/download_healthcard_link?student_id=<?php echo base64_encode($stud_info[0]->stud_id); ?>" class="btn click-xhttp-request float_right" data-qr="output_position=content"  style="margin-top: -5px;">Download </a>-->
                <?php 
                
                if($action != 'previous'){?>
                <form action="<?php echo base_url(); ?>healthcard/download_healthcard_link" method="post" enctype="multipart/form-data" target="form_frame">
                    <input type="hidden" value="<?php echo base64_encode($stud_info[0]->stud_id); ?>" name="student_id">
                    <input type="submit" name="submit" value="Download" TABINDEX="3" class="float_right">
                    <input type="button" name="print" value="Print" TABINDEX="3" class="float_right" onclick="printElem('healthcard_print');">
                </form>
                <?php } ?>
            </div>
        </div>
    </div>
    <hr>
    <div class="healthcard_outer">
        <div class="row">
            <div class="width75 float_left">
                <div class="list ">

                    <ul class="healthcard_registration">
                        <li class="width40">
                            <div class="item-content item-inner">
                                <div class="item-title width100">Registration No</div>
                            </div>
                        </li>
                        <li class="width_60">
                            <div class="item-content item-input">
                                <?php echo $stud_info[0]->stud_reg_no; ?>
                            </div>
                        </li>

                        <li class="width40">
                            <div class="item-content item-input">
                                <div class="item-title width100">First Name</div>
                            </div>
                        </li>
                        <li class="width_60">
                            <div class="item-content item-input">
                                <?php echo $stud_info[0]->stud_first_name; ?>
                            </div>
                        </li>
                        <li class="width40">
                            <div class="item-content item-input">
                                <div class="item-title width100">Middle Name</div>
                            </div>
                        </li>
                        <li class="width_60">
                            <div class="item-content item-input">
                                <?php echo $stud_info[0]->stud_middle_name; ?>
                            </div>
                        </li>
                        <li class="width40">
                            <div class="item-content item-input">
                                <div class="item-title width100">Last Name</div>
                            </div>
                        </li>
                        <li class="width_60">
                            <div class="item-content item-input">
                                <?php echo $stud_info[0]->stud_last_name; ?>
                            </div>
                        </li>
                    </ul>
                    <ul class="healthcard_gender">
                        <li>
                            <div class="item-content item-inner">
                                <div class="item-title width100">Gender</div>
                            </div>
                        </li>
                        <li class="width_60">
                            <div class="item-content ">
                                <div class="item-title width100"> <?php echo get_gen($stud_info[0]->stud_gender); ?></div>
                            </div>
                        </li>
                        <li>
                            <div class="item-content ">
                                <div class="item-title width100">DOB</div>
                            </div>
                        </li>
                        <li>
                            <div class="item-content ">
                                <div class="item-title width100"> <?php if($stud_info[0]->stud_dob != '0000-00-00' && $stud_info[0]->stud_dob != '') {echo date('d M Y', strtotime($stud_info[0]->stud_dob)); } ?></div>
                            </div>
                        </li>
                    </ul>

                </div>
            </div>
            <div class="width_25 float_right">
                <ul style="border:none"> 
                    <li>
                        <div class="healthcard_photo">
                            <?php 
                            if($stud_info[0]->stud_image != ''){?>
                            <img src="<?php echo base_url(); ?>upload/student/1542791014627_1.jpg" class="lazy lazy-fade-in demo-lazy" width="150px" height="150px"/>
                           <?php }else{?>
                            <img src="<?php echo base_url(); ?>upload/student/1542791014627_1.jpg" class="lazy lazy-fade-in demo-lazy"/>
                            <?php } ?>


                        </div>
                    </li>  
                </ul>

            </div>
        </div>


        <div class="row">
            <div class="width100 float_left">
                <div class="data-table card width97 description_table">
                    <table class="adhar_table">
                        <tbody> 
                        <tr>
                            <td>Aadhar Card No</td>
                            <td>Age</td>
                            <td>Height</td>
                            <td>Weight</td>
                            <td>Blood Group</td>
                        </tr>
                        <tr>
                            <td> <?php echo $stud_info[0]->stud_adhar_no; ?></td>
                            <td><?php echo $stud_info[0]->stud_age; ?></td>
                            <td><?php echo $stud_info[0]->stud_age; ?></td>
                            <td><?php echo $stud_info[0]->stud_age; ?></td>
                            <td><?php echo $stud_info[0]->stud_blood_group; ?></td> 

                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="width100 float_left">
                <div class="list ">
                    <ul class="healthcard_gaud_info">
                        <li class="width40">
                            <div class="item-content ">
                                <div class="item-title width100">Gaurdian Information</div>
                            </div>
                        </li>
                        <li  class="width60">
                            <div class="item-content ">
                                <div class="item-title width100"><?php echo $stud_info[0]->stud_gaurdian_information; ?></div>
                            </div>
                        </li>

                        <li class="width25">
                            <div class="item-content">
                                <div class="item-title width100">Relation with Student</div>
                            </div>
                        </li>
                        <li class="width25">
                            <div class="item-content ">
                                <div class="item-title width100"><?php echo $stud_info[0]->rel_with_stud; ?></div>
                            </div>

                        </li>
                        <li class="width25">
                            <div class="item-content">
                                <div class="item-title width100">Contact No</div>
                            </div>
                        </li>
                        <li class="width25">
                            <div class="item-content ">
                                <div class="item-title width100"><?php echo $stud_info[0]->contact_no; ?></div>
                            </div> 
                        </li>

                        <li class="width25">
                            <div class="item-content item-input">
                                <!--<div class="item-content item-inner">-->
                                <div class="item-title width100">House No</div>
                                <!--</div>-->
                            </div>
                        </li>
                        <li class="width25">
                            <div class="item-content ">
                                <div class="item-title width100"><?php echo $stud_info[0]->house_no; ?> </div>
                            </div> 
                        </li>
                        <li class="width25">
                            <div class="item-content item-input">
                                <!--<div class="item-content item-inner">-->
                                <div class="item-title width100">Road/street</div>
                                <!--</div>-->
                            </div>
                        </li>
                        <li class="width25">
                            <div class="item-content ">
                                <div class="item-title width100"><?php echo $stud_info[0]->road; ?></div>
                            </div> 
                        </li>

                        <li class="width25">
                            <div class="item-content item-input">
                                <!--<div class="item-content item-inner">-->
                                <div class="item-title width100">Locality</div>
                                <!--</div>-->
                            </div>
                        </li>
                        <li class="width25">
                            <div class="item-content ">
                                <div class="item-title width100"><?php echo $stud_info[0]->locality; ?></div>
                            </div> 
                        </li>
                        <li class="width25">
                            <div class="item-content item-input">
                                <!--<div class="item-content item-inner">-->
                                <div class="item-title width100">Landmark</div>
                                <!--</div>-->
                            </div>
                        </li>
                        <li class="width25">
                            <div class="item-content ">
                                <div class="item-title width100">none</div>
                            </div> 
                        </li>
                        <li class="width25">
                            <div class="item-content item-input">
                                <!--<div class="item-content item-inner">-->
                                <div class="item-title width100">City/Village</div>
                                <!--</div>-->
                            </div>
                        </li>
                        <li class="width25">
                            <div class="item-content ">
                                <div class="item-title width100"><?php echo $stud_info[0]->stud_city; ?></div>
                            </div>
                        </li>
                        <li class="width25">
                            <div class="item-content item-input">
                                <!--<div class="item-content item-inner">-->
                                <div class="item-title width100">Taluka</div>
                                <!--</div>-->
                            </div>
                        </li>
                        <li class="width25">
                            <div class="item-content ">
                                <div class="item-title width100"><?php echo $stud_info[0]->stud_taluka; ?></div>
                            </div>
                        </li>
                        <li class="width25">
                            <div class="item-content item-input">
                                <!--<div class="item-content item-inner">-->
                                <div class="item-title width100">District</div>
                                <!--</div>-->
                            </div>
                        </li>
                        <li class="width25">
                            <div class="item-content ">
                                <div class="item-title width100"><?php echo $stud_info[0]->stud_district; ?></div>
                            </div>
                        </li>
                        <li class="width25">
                            <div class="item-content item-input">
                                <!--<div class="item-content item-inner">-->
                                <div class="item-title width100">Pin Code</div>
                                <!--</div>-->
                            </div>
                        </li>
                        <li class="width25">
                            <div class="item-content ">
                                <div class="item-title width100"><?php echo $stud_info[0]->pincode; ?></div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="data-table card width100 description_table">
                <h2>  School Information</h2>
                <table class="adhar_table">
                    <tr>
                        <td class="width30">School Name</td><td><?php echo $stud_info[0]->school_name; ?></td>


                    </tr>
                    <tr>
                        <td>Address</td><td><?php echo $stud_info[0]->school_address; ?></td>
                    </tr>
                    <tr>
                        <td>Health Supervisor</td><td><?php echo $stud_info[0]->school_heathsupervisior; ?></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="data-table card width100 description_table">
                <table class="adhar_table">
                    <tr>
                        <td class="width30">Doctor ID:</td>
                        <td><?php echo $stud_basic_info[0]->added_by; ?></td>
                        <td class="width30">Check Up Date</td>
                       <td><?php if($stud_basic_info) {if($stud_basic_info[0]->added_date  != '0000-00-00' && $stud_basic_info[0]->added_date == "" ){ echo date('d M Y' ,strtotime($stud_basic_info[0]->added_date)); } }?></td>

                    </tr>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="width100 float_left">
                <h2 class="emt_healthcard_header">
                    Previous & Current Medical Records
                </h2>
            </div></div>
        <div class="row">
            <div class="data-table card width100 student_healthcard">
                <table class="description_table">
                    <tr>
                        <td class="width30">Past Medical History</td>
                        <td>
<?php echo $stud_basic_info[0]->past_medicle_history; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Previous Hospitalization</td>
                        <td>
<?php echo $stud_basic_info[0]->prev_hospitalization; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Previous Surgeries</td>
                        <td>
                        </td>
                    </tr>
                    <tr>
                        <td>Current Medication</td>
                        <td>
<?php echo $stud_basic_info[0]->current_medication; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Allergies(If Any)</td>
                        <td> <?php echo $stud_basic_info[0]->allergies; ?></td>
                    </tr>
                    <tr>
                        <td>Present History</td>
                        <td><?php
//if(is_array($diagonosis)){echo implode(',',$diagonosis);}
$diagonosis_array = array();

if ($diagonosis) {
    foreach ($diagonosis as $dia) {
        $diagonosis_array = array_merge($diagonosis_array, $dia);
    }
    echo implode(',', $diagonosis_array);
}
?></td>
                    </tr>
                    <tr>
                        <td>Current Prescriptions</td>
                        <td><?php
                            $drugs = (json_decode($stud_prescriptionp[0]->drug_details));
                            //var_dump(($drugs->drug_name));
                            if (is_array($drugs->drug_name)) {
                                echo implode(',', $drugs->drug_name);
                            }
?></td>
                    </tr>
                    <tr>
                        <td>Investigations</td>
                         <td><?php echo implode(',',$test_array); ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="data-table card width100 description_table">
                <table class="heathcard_table_date_examination">
                    <tr>
                        <td>Sr NO</td>
                        <td>Date Of Examination</td>
                        <td>Presenting Symptom's</td>
                        <td>Assessment</td>
                        <td>Treatment Given</td>
                        <td>Remarks</td>
                    </tr>
                    <?php
                    if (!empty($previous_schedules)) {
                        foreach ($previous_schedules as $key => $previous) {
                            ?>
                    <tr><td><?php echo $key + 1; ?></td>
                       
                        <td>
                            
                            <a class="click-xhttp-request action_button" data-href="{base_url}healthcard/previous_healthcard" data-qr="output_position=popup_div&stud_id=<?php echo $previous["stud_id"];?>&schedule_id=<?php echo $previous["schedule_id"];?>&action=previous" style="color:#696969;"><?php echo date('d M Y', strtotime($previous["schedule_date"])); ?></a>
                        </td>
                        <td><?php echo $previous['chief_complaint'];?>,<?php echo $previous['symptoms'];?></td>
                        <td>   <?php
                            $dia_array = array();

                            if ($previous['student_data']) {
                                foreach ($previous['student_data'] as $dia) {
                                    $dia_array = array_merge($dia_array, $dia);
                                }
                                echo implode(',', $dia_array);
                            }
                            ?>
                        </td>
                        <td><?php
                   
                            $drugs = (json_decode($previous['stud_prescription']));
                          
                            if (is_array($drugs->drug_name)) {
                                echo implode(',', $drugs->drug_name);
                            }
?></td>
                        <td><?php echo $previous['remark']; ?> </td>
                    </tr>
    <?php }
} ?>

                </table>
            </div>
        </div>
    </div>

    <div class="hide" id="healthcard_print">
        <style type = "text/css">
            @media all {
                        #healthcard_print .width_10 {
                            width: 10%;
                        }
                        #healthcard_print .width_12 {
                            width: 12%;
                        }
                        #healthcard_print .width_14 {
                            width: 14.28%;
                        }
                        #healthcard_print .width6,#healthcard_print .width_15 {
                            width: 15%;
                        }
                        #healthcard_print .width_16 {
                            width: 16.50%;
                        }
                        #healthcard_print .width_20 {
                            width: 20% !important;
                        }
                        .width_25 {
                            width: 25%;
                        }
                        .width40 {
                            width:35.6%;
                        }
                        .width30,
                        .width_30 {
                            width: 30%;
                        }
                        .width_66 {
                            width: 66.68%;
                        }
                        .width_48 {
                            width: 48%;
                        }
                        .width_60{
                            width: 60%;
                        }
                        .width100 {
                            width: 100% !important;
                            clear: both;
                        }
                        .float_left {
                            float:left;
                        }
                        .float_right {
                            float:right;
                        }
                        table {
                            color: #333333;
                            border-bottom: 5px solid #FFBF42;
                            width: 100%;
                            margin: 10px 0 25px;
                            margin-top: 10px;
                            border-collapse: collapse;
                        }
                        #healthcard_print table tr {
                            height: 44px;
                        }

                        .healthcard_outer table{
                            width:100%;
                            border-bottom: none;
                        }
                         .healthcard_outer .description_table tr td {
                            border: 2px solid gray;
                            height: 45px;
                            padding-left: 1%;
                        }
                        table > tbody > tr:nth-child(2n) > td {
                            background-color: #F3F3F3;
                        }

                        .healthcard_outer ul {
                            width: 100%;
                            display: inline-block;
                            border: 1px solid gray;
                            list-style-type: none;
                            padding: 0px;
                        }
                        .healthcard_outer .healthcard_name li, .healthcard_outer .healthcard_registration li {
                            float: left;
                            border: 1px solid gray;
                            padding-left: 20px;
                        }
                        .healthcard_outer .description_table tr {
                            border: 2px solid gray;
                        }
                        h2, h3 {
                            color: #2acfca;
                        }
                        .row {
                            margin-top: 7px;
                            line-height: 25px;
                            min-height: 40px;
                            padding: 0px;
                            width: 100%;
                        }
                        .healthcard_outer .healthcard_gaud_info li {
                            float: left;
                            border: 1px solid gray;
                            padding-left: 20px;
                        }
                         #healthcard_print .width3, #healthcard_print .width75 {
                            width:75%;
                        }
                         #healthcard_print .width70 {
                            width:70%;
                        }
                        .healthcard_outer ul{
                            width: 100%;
                            display: inline-block;
                        }
                        .healthcard_outer .healthcard_name li,
                        .healthcard_outer .healthcard_registration li {
                            float: left;
                            border: 1px solid gray;
                            padding-left: 2%;
                        }

                        .healthcard_outer .list .item-content {
                            display: -webkit-box;
                            display: -webkit-flex;
                            display: -ms-flexbox;
                            display: flex;
                            -webkit-box-pack: justify;
                            -webkit-justify-content: space-between;
                            -ms-flex-pack: justify;
                            justify-content: space-between;
                            -webkit-box-sizing: border-box;
                            box-sizing: border-box;
                            -webkit-box-align: center;
                            -webkit-align-items: center;
                            -ms-flex-align: center;
                            align-items: center;
                            min-height: 48px;
                        }
                        .healthcard_outer .list .item-title {
                            min-width: 0;
                            -webkit-flex-shrink: 1;
                            -ms-flex-negative: 1;
                            flex-shrink: 1;
                            white-space: nowrap;
                            position: relative;
                            overflow: hidden;
                            text-overflow: ellipsis;
                            max-width: 100%;
                        }
                       #healthcard_print .healthcard_outer .healthcard_gender{
                            margin-top: -18px;
                        }
                        #healthcard_print .healthcard_outer .healthcard_gender li:first-child {
                            float: left;
                            width: 30.7% !important;
                            border: 1px solid gray;
                        }
                        #healthcard_print .healthcard_outer .healthcard_gender li {
                            float: left;
                            width: 20.2% !important;
                            padding-left: 2%;
                            border: 1px solid gray;
                        }
                        #healthcard_print .healthcard_outer .healthcard_photo {
                            height: 150px;
                            width: 150px;
                            float: right;
                            margin-top: 1px;
                        }
                        #healthcard_print .width25 {
                            width: 23%;
                        }
                         #healthcard_print .width_60,
                         #healthcard_print .width60 {
                            width: 60%;
                        }
        }
        </style>
         <div class="healthcard_outer">
        <div class="row">
            <div class="width75 float_left">
                <div class="list ">

                    <ul class="healthcard_registration">
                        <li class="width40">
                            <div class="item-content item-inner">
                                <div class="item-title width100">Registration No</div>
                            </div>
                        </li>
                        <li class="width_60">
                            <div class="item-content item-input">
                                <?php echo $stud_info[0]->stud_reg_no; ?>
                            </div>
                        </li>

                        <li class="width40">
                            <div class="item-content item-input">
                                <div class="item-title width100">First Name</div>
                            </div>
                        </li>
                        <li class="width_60">
                            <div class="item-content item-input">
                                <?php echo $stud_info[0]->stud_first_name; ?>
                            </div>
                        </li>
                        <li class="width40">
                            <div class="item-content item-input">
                                <div class="item-title width100">Middle Name</div>
                            </div>
                        </li>
                        <li class="width_60">
                            <div class="item-content item-input">
                                <?php echo $stud_info[0]->stud_middle_name; ?>
                            </div>
                        </li>
                        <li class="width40">
                            <div class="item-content item-input">
                                <div class="item-title width100">Last Name</div>
                            </div>
                        </li>
                        <li class="width_60">
                            <div class="item-content item-input">
<?php echo $stud_info[0]->stud_last_name; ?>
                            </div>
                        </li>
                    </ul>
                    <ul class="healthcard_gender">
                        <li>
                            <div class="item-content item-inner">
                                <div class="item-title width100">Gender</div>
                            </div>
                        </li>
                        <li class="width_60">
                            <div class="item-content ">
                                <div class="item-title width100"> <?php echo get_gen($stud_info[0]->stud_gender); ?></div>
                            </div>
                        </li>

                        <li>
                            <div class="item-content ">
                                <div class="item-title width100">DOB</div>
                            </div>
                        </li>
                        <li>
                            <div class="item-content ">
                                <div class="item-title width100"> <?php echo date('d M Y', strtotime($stud_info[0]->stud_dob)); ?></div>
                            </div>
                        </li>
                    </ul>

                </div>
            </div>
            <div class="width_25 float_right">
                <ul style="border:none"> 
                    <li>
                        <div class="healthcard_photo">
                            <?php 
                         
                            if($stud_info[0]->stud_image != ''){?>
                                  <img src="<?php echo base_url(); ?>upload/student/<?php echo $stud_info[0]->stud_image;?>" class="lazy lazy-fade-in demo-lazy"  width="150px" height="150px"/>
                           <?php }else{?>
                            <img src="<?php echo base_url(); ?>upload/student/stud.jpg" class="lazy lazy-fade-in demo-lazy"/>
                            <?php } ?>

                        </div>
                    </li>  
                </ul>

            </div>
        </div>


        <div class="row">
            <div class="width100 float_left">
                <div class="data-table card width97 description_table">
                    <table class="adhar_table">
                        <tbody> 
                        <td>Aadhar Card No</td>
                        <td>Age</td>
                        <td>Height</td>
                        <td>Weight</td>
                        <td>Blood Group</td>
                        </tr>
                        <tr>
                            <td> <?php echo $stud_info[0]->stud_adhar_no; ?></td>
                            <td><?php echo $stud_info[0]->stud_age; ?></td>
                            <td><?php echo $stud_info[0]->stud_age; ?></td>
                            <td><?php echo $stud_info[0]->stud_age; ?></td>
                            <td><?php echo $stud_info[0]->stud_blood_group; ?></td> 

                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="width100 float_left">
                <div class="list ">
                    <ul class="healthcard_gaud_info">
                        <li class="width40">
                            <div class="item-content ">
                                <div class="item-title width100">Gaurdian Information</div>
                            </div>
                        </li>
                        <li  class="width60">
                            <div class="item-content ">
                                <div class="item-title width100"><?php echo $stud_info[0]->stud_gaurdian_information; ?></div>
                            </div>
                        </li>

                        <li class="width25">
                            <div class="item-content">
                                <div class="item-title width100">Relation with Student</div>
                            </div>
                        </li>
                        <li class="width25">
                            <div class="item-content ">
                                <div class="item-title width100"><?php echo $stud_info[0]->rel_with_stud; ?></div>
                            </div>

                        </li>
                        <li class="width25">
                            <div class="item-content">
                                <div class="item-title width100">Contact No</div>
                            </div>
                        </li>
                        <li class="width25">
                            <div class="item-content ">
                                <div class="item-title width100"><?php echo $stud_info[0]->contact_no; ?></div>
                            </div> 
                        </li>

                        <li class="width25">
                            <div class="item-content item-input">
                                <!--<div class="item-content item-inner">-->
                                <div class="item-title width100">House No</div>
                                <!--</div>-->
                            </div>
                        </li>
                        <li class="width25">
                            <div class="item-content ">
                                <div class="item-title width100"><?php echo $stud_info[0]->house_no; ?> </div>
                            </div> 
                        </li>
                        <li class="width25">
                            <div class="item-content item-input">
                                <!--<div class="item-content item-inner">-->
                                <div class="item-title width100">Road/street</div>
                                <!--</div>-->
                            </div>
                        </li>
                        <li class="width25">
                            <div class="item-content ">
                                <div class="item-title width100"><?php echo $stud_info[0]->road; ?></div>
                            </div> 
                        </li>

                        <li class="width25">
                            <div class="item-content item-input">
                                <!--<div class="item-content item-inner">-->
                                <div class="item-title width100">Locality</div>
                                <!--</div>-->
                            </div>
                        </li>
                        <li class="width25">
                            <div class="item-content ">
                                <div class="item-title width100"><?php echo $stud_info[0]->locality; ?></div>
                            </div> 
                        </li>
                        <li class="width25">
                            <div class="item-content item-input">
                                <!--<div class="item-content item-inner">-->
                                <div class="item-title width100">Landmark</div>
                                <!--</div>-->
                            </div>
                        </li>
                        <li class="width25">
                            <div class="item-content ">
                                <div class="item-title width100">none</div>
                            </div> 
                        </li>
                        <li class="width25">
                            <div class="item-content item-input">
                                <!--<div class="item-content item-inner">-->
                                <div class="item-title width100">City/Village</div>
                                <!--</div>-->
                            </div>
                        </li>
                        <li class="width25">
                            <div class="item-content ">
                                <div class="item-title width100"><?php echo $stud_info[0]->stud_city; ?></div>
                            </div>
                        </li>
                        <li class="width25">
                            <div class="item-content item-input">
                                <!--<div class="item-content item-inner">-->
                                <div class="item-title width100">Taluka</div>
                                <!--</div>-->
                            </div>
                        </li>
                        <li class="width25">
                            <div class="item-content ">
                                <div class="item-title width100"><?php echo $stud_info[0]->stud_taluka; ?></div>
                            </div>
                        </li>
                        <li class="width25">
                            <div class="item-content item-input">
                                <!--<div class="item-content item-inner">-->
                                <div class="item-title width100">District</div>
                                <!--</div>-->
                            </div>
                        </li>
                        <li class="width25">
                            <div class="item-content ">
                                <div class="item-title width100"><?php echo $stud_info[0]->stud_district; ?></div>
                            </div>
                        </li>
                        <li class="width25">
                            <div class="item-content item-input">
                                <!--<div class="item-content item-inner">-->
                                <div class="item-title width100">Pin Code</div>
                                <!--</div>-->
                            </div>
                        </li>
                        <li class="width25">
                            <div class="item-content ">
                                <div class="item-title width100"><?php echo $stud_info[0]->pincode; ?></div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="data-table card width100 description_table">
                <h2>  School Information</h2>
                <table class="adhar_table">
                    <tr>
                        <td class="width30">School Name</td><td><?php echo $stud_info[0]->school_name; ?></td>


                    </tr>
                    <tr>
                        <td>Address</td><td><?php echo $stud_info[0]->school_address; ?>Kelirumhanwadi</td>
                    </tr>
                    <tr>
                        <td>Health Supervisor</td><td><?php echo $stud_info[0]->school_heathsupervisior; ?></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="data-table card width100 description_table">
                <table class="adhar_table">
                    <tr>
                        <td class="width30">Doctor ID:</td>
                        <td><?php echo $stud_basic_info[0]->added_by; ?></td>
                        <td class="width30">Check Up Date</td>
                        <td><?php if($stud_basic_info) { if($stud_basic_info[0]->added_date  != '0000-00-00' && $stud_basic_info[0]->added_date == "" ){ echo date('d M Y', strtotime($stud_basic_info[0]->added_date)); } } ?></td>

                    </tr>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="width100 float_left">
                <h2 class="emt_healthcard_header">
                    Previous & Current Medical Records
                </h2>
            </div></div>
        <div class="row">
            <div class="data-table card width100 student_healthcard">
                <table class="description_table">
                    <tr>
                        <td class="width30">Past Medical History</td>
                        <td>
<?php echo $stud_basic_info[0]->past_medicle_history; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Previous Hospitalization</td>
                        <td>
<?php echo $stud_basic_info[0]->prev_hospitalization; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Previous Surgeries</td>
                        <td>

                        </td>
                    </tr>
                    <tr>
                        <td>Current Medication</td>
                        <td>
<?php echo $stud_basic_info[0]->current_medication; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Allergies(If Any)</td>
                        <td> <?php echo $stud_basic_info[0]->allergies; ?></td>
                    </tr>
                    <tr>
                        <td>Present History</td>
                        <td><?php
//if(is_array($diagonosis)){echo implode(',',$diagonosis);}
$diagonosis_array = array();

if ($diagonosis) {
    foreach ($diagonosis as $dia) {
        $diagonosis_array = array_merge($diagonosis_array, $dia);
    }
    echo implode(',', $diagonosis_array);
}
?></td>
                    </tr>
                    <tr>
                        <td>Current Prescriptions</td>
                        <td><?php
                            $drugs = (json_decode($stud_prescriptionp[0]->drug_details));
                            //var_dump(($drugs->drug_name));
                            if (is_array($drugs->drug_name)) {
                                echo implode(',', $drugs->drug_name);
                            }
?></td>
                    </tr>
                    <tr>
                        <td>Investigations</td>
                         <td><?php echo implode(',',$test_array); ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="data-table card width100 description_table">
                <table class="heathcard_table_date_examination">
                    <tr>
                        <td>Sr NO</td>
                        <td>Date Of Examination</td>
                        <td>Presenting Symptom's</td>
                        <td>Assessment</td>
                        <td>Treatment Given</td>
                        <td>Remarks</td>
                    </tr>
                    <?php
                    if (!empty($previous_schedules)) {
                        foreach ($previous_schedules as $key => $previous) {
                            ?>
                            <tr><td><?php echo $key + 1; ?></td>
                                <td><?php echo date('d M Y', strtotime($previous["schedule_date"])); ?></td>
                                <td><?php echo $previous['chief_complaint'];?>,<?php echo $previous['symptoms'];?></td>
                                <td>   <?php
                                    $dia_array = array();

                                    if ($previous['student_data']) {
                                        foreach ($previous['student_data'] as $dia) {
                                            $dia_array = array_merge($dia_array, $dia);
                                        }
                                        echo implode(',', $dia_array);
                                    }
                                    ?>
                                </td>
                                <td><?php
                                $drugs = (json_decode($previous['stud_prescription']));
                                //var_dump(($drugs->drug_name));
                                if (is_array($drugs->drug_name)) {
                                    echo implode(',', $drugs->drug_name);
                                }?></td>
                            <td><?php echo $previous['remark']; ?> </td>
                            </tr>
    <?php }
} ?>

                </table>
            </div>
        </div>
    </div>
    </div>
    <iframe name="form_frame" style="height: 1px; width: 1px; border:0px; background: none;"></iframe>