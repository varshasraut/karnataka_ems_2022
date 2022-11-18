<?php
$CI = EMS_Controller::get_instance();?>

<div class="width100" style="padding:15px;" id="healthcard_pdf">

<div class="row">
       <div class="width100">
           <div class="emt_healthcard_header width100">
               <h2>Student Health Card</h2>
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

                        <?php echo $stud_info[0]->stud_middle_name;?>

                    </div>
                </li>
                <li class="width40">
                    <div class="item-content item-input">

                        <div class="item-title width100">Last Name</div>

                    </div>
                </li>
                <li class="width_60">
                    <div class="item-content item-input">
                        <?php echo $stud_info[0]->stud_last_name;?>
                    </div>
                </li>
                <li class="width40">
                    <div class="item-content item-inner">
                        <div class="item-title width100">Gender</div>
                    </div>
                </li>
                <li class="width_60">

                    <div class="item-content ">
                        <div class="item-title width100"> <?php echo get_gen($stud_info[0]->stud_gender);?></div>
                    </div>
                </li>

                <li class="width40">
                    <div class="item-content ">
                        <div class="item-title width100">DOB</div>
                    </div>
                </li>
                <li class="width_60">
                    <div class="item-content ">
                        <div class="item-title width100"> <?php echo date('d M Y' ,strtotime($stud_info[0]->stud_dob));?></div>
                    </div>
                </li>
            </ul>

        </div>
    </div>
    <div class="width_25 float_right">
        <ul style="border:none"> 
            <li>
                <div class="healthcard_photo float_right">
                    <?php 
                         
                            if($stud_info[0]->stud_image != ''){?>
                                  <img src="<?php echo base_url(); ?>upload/student/<?php echo $stud_info[0]->stud_image;?>" class="lazy lazy-fade-in demo-lazy float_right"  width="150px" height="150px"/>
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
        <div class="data-table card width100 description_table">
            <table class="adhar_table">
                <tbody> 
                <td>Aadhar Card No</td>
                <td>Age</td>
                <td>Height</td>
                <td>Weight</td>
                <td>Blood Group</td>
                </tr>
                <tr>
                    <td> <?php echo $stud_info[0]->stud_adhar_no;?></td>
                    <td><?php echo $stud_info[0]->stud_age;?></td>
                    <td><?php echo $stud_info[0]->stud_age;?></td>
                    <td><?php echo $stud_info[0]->stud_age;?></td>
                    <td><?php echo $stud_info[0]->stud_blood_group;?></td> 

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
                        <div class="item-title width100"><?php echo $stud_info[0]->stud_gaurdian_information;?></div>
                    </div>
                </li>

                <li class="width25">
                    <div class="item-content">
                        <div class="item-title width100">Relation with Student</div>
                    </div>
                </li>
                <li class="width25">
                    <div class="item-content ">
                        <div class="item-title width100"><?php echo $stud_info[0]->rel_with_stud;?></div>
                    </div>

                </li>
                <li class="width25">
                    <div class="item-content">
                        <div class="item-title width100">Contact No</div>
                    </div>
                </li>
                <li class="width25">
                    <div class="item-content ">
                        <div class="item-title width100"><?php echo $stud_info[0]->contact_no;?></div>
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
                        <div class="item-title width100"><?php echo $stud_info[0]->house_no;?> </div>
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
                        <div class="item-title width100"><?php echo $stud_info[0]->road;?></div>
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
                        <div class="item-title width100"><?php echo $stud_info[0]->locality;?></div>
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
                        <div class="item-title width100"><?php echo $stud_info[0]->stud_city;?></div>
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
                        <div class="item-title width100"><?php echo $stud_info[0]->stud_taluka;?></div>
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
                        <div class="item-title width100"><?php echo $stud_info[0]->stud_district;?></div>
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
                        <div class="item-title width100"><?php echo $stud_info[0]->pincode;?></div>
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
                <td class="width30">School Name</td><td><?php echo $stud_info[0]->school_name;?></td>


            </tr>
            <tr>
                <td>Address</td><td><?php echo $stud_info[0]->school_address;?></td>
            </tr>
            <tr>
                <td>Health Supervisor</td><td><?php echo $stud_info[0]->school_heathsupervisior;?></td>
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
                <td><?php if($stud_basic_info){if($stud_basic_info[0]->added_date == ""){ echo date('d M Y' ,strtotime($stud_basic_info[0]->added_date)); }}?></td>

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
                <td><?php //if(is_array($diagonosis)){echo implode(',',$diagonosis);}
                        $diagonosis_array = array();
                
                if($diagonosis){
                      foreach($diagonosis as $dia){
                        $diagonosis_array = array_merge($diagonosis_array,$dia);
                      }
                     echo implode(',',$diagonosis_array);
                }
                ?></td>
            </tr>
            <tr>
                <td>Current Prescriptions</td>
                <td><?php $drugs = (json_decode($stud_prescriptionp[0]->drug_details));
              
                 if(is_array($drugs->drug_name)){ echo implode(',',$drugs->drug_name);}
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
          
            if(!empty($previous_schedules)){
            
            foreach($previous_schedules as $key=>$previous){  ?>
            <tr><td><?php echo $key+1;?></td><td><?php echo date('d M Y' ,strtotime($previous["schedule_date"]));?></td>
                <td><?php echo $previous['chief_complaint'];?>,<?php echo $previous['symptoms'];?></td>
                <td>   <?php $dia_array = array();
                
                    if($previous['student_data']){
                      foreach($previous['student_data'] as $dia){
                        $dia_array = array_merge($dia_array,$dia);
                      }
                     echo implode(',',$dia_array);
                    }
                      ?></td>
                <td><?php
                   
                            $drugs = (json_decode($previous['stud_prescription']));
                          
                            if (is_array($drugs->drug_name)) {
                                echo implode(',', $drugs->drug_name);
                            }
?></td>
                <td><?php echo $previous['remark']; ?> </td>
            </tr>
            <?php } }?>
           
        </table>
    </div>
</div>
</div>
   </div>
