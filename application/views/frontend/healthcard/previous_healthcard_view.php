<?php
$CI = EMS_Controller::get_instance();?>

<div class="width100" style="padding:15px;">

<div class="row">
       <div class="width100">
           <div class="emt_healthcard_header width100">
               <h2>Student Health Card</h2>
           </div>

       </div>
    <div class="width100 float_right">
        
        <h3 class="font_weight600">Student Information</h3>
        
        <table class="student_screening" style="margin-bottom: 10px;">
            <tr>
                <td style="width: 40%;">Registration No </td>
                <td><?php echo $stud_info[0]->stud_reg_no; ?></td>
            </tr>
            
            <tr>
                <td>Student Name </td>
                <td><?php echo $stud_info[0]->stud_first_name; ?> <?php echo $stud_info[0]->stud_middle_name; ?> <?php echo $stud_info[0]->stud_last_name; ?></td>
            </tr>
             <tr>
                <td>School Name </td>
                <td><?php echo $stud_info[0]->school_name; ?></td>
            </tr>

            <tr>
                <td>Gender</td>
                <td><?php echo get_gen($stud_info[0]->stud_gender); ?></td>
            </tr>
            <tr>
                <td>DOB</td>
                <td> <?php echo date('d M Y', strtotime($stud_info[0]->stud_dob)); ?></td>
            </tr>
            <tr>
                <td>Aadhar Card No</td>
                <td> <?php echo $stud_info[0]->stud_adhar_no; ?></td>
            </tr>
            <tr>
                <td>Age</td>
                  <td><?php echo $stud_info[0]->stud_age; ?></td>
            </tr>
            <tr>
                <td>Blood Group</td>
                <td> <?php echo $stud_info[0]->stud_blood_group; ?></td>
            </tr>
            <tr>
                <td>Deworning</td>
                <td> <?php echo $stud_info[0]->deworning; ?></td>
            </tr>
            <tr>
                <td>Diagnosis Name</td>
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
            
            
        </table>
        
    </div>
    <div class="width100 float_right">

    <h3 class="font_weight600">Student Hospitalization Details</h3>
    <table class="student_screening">
        <tr><td>Admitted to hospital</td><td><?php echo $stud_hospitalization[0]->hp_name; ?></td></tr>
        <tr><td>Admitted Under</td><td><?php echo $stud_hospitalization->admitted_under; ?></td></tr>
        <tr><td>Admitted On</td><td><?php echo $stud_hospitalization->admitted_on; ?></td></tr>
        <tr><td>Discharge date</td><td><?php echo $stud_hospitalization->discharge_date; ?></td></tr>
        <tr><td>Drop back booked date time</td><td><?php echo $stud_hospitalization->drop_back_datetime; ?></td></tr>
    </table>
    
    </div>
    <div class="width100 float_right">
        
        <h3 class="font_weight600">Student Prescription Details</h3>
        
    <table class="student_screening">
        <tr><td>Drug Name</td><td>Dose</td><td>Days</td></tr>
        <?php 
        $drug_details = json_decode($stud_prescriptionp[0]->drug_details);

        for($dd=0; $dd <= count($drug_details->days)-2;$dd++){ ?>
        <tr>
            <td><?php echo $drug_details->drug_name[$dd] ?></td>
             <td><?php echo $drug_details->dose[$dd] ?></td>
              <td><?php echo $drug_details->days[$dd] ?></td>
        </tr>
        <?php
          
        }
        ?>
        
    </table>
        
    </div>
        <div class="width100 float_right">
        
        <h3 class="font_weight600">Student SickRoom Details</h3>
        
    <table class="student_screening">
        <tr><td>Doctor Note</td><td><?php echo $stud_sickroom[0]->doctor_note;?></td></tr>
        <tr><td>Treatment Order</td><td><?php echo $stud_sickroom[0]->treatment_order;?></td></tr>
        <tr><td>Health Supervisor Remark</td><td><?php echo $stud_sickroom[0]->health_supervisor_remark;?></td></tr>
        
        
    </table>
        
    </div>


   </div>
</div>