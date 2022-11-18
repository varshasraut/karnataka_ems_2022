<?php
$step = array('BASIC', 'SCREEN', 'DENTAL', 'VISION','AUD', 'MED', 'INV', 'PRE', 'HOS', 'HPT', 'DPR');


if(!$init_step){
    foreach ($step as $stp) {

        if ($step_com) {

            if (!in_array($stp, $step_com)) {

                $filter_step[$stp] = 'incomplete_step';
            }
        } else {
            $filter_step[$stp] = 'incomplete_step';
        }
    }
}



?>



<div class="width100">
    <div class="header_top_link">
         
        <ul id="PCR_STEPS">

            <li class="hospital_trans_icon <?php echo $filter_step['BASIC']; ?>"><a class="click-xhttp-request" data-pcr_step="1" href="{base_url}emt/student_basic_info" data-qr="output_position=content">Student Basic Info</a></li>
            <li class="consents_icon <?php echo $filter_step['SCREEN']; ?>"><a class="click-xhttp-request" data-pcr_step="2" href="{base_url}emt/student_screening" data-qr="output_position=content&amp;step=2">Student Screening</a></li>

            <li class="consents_icon <?php echo $filter_step['DENTAL']; ?>"><a class="click-xhttp-request" data-pcr_step="3" href="{base_url}emt/dental" data-qr="output_position=content&amp;step=3">Dental</a></li>

            <li class="patient_ass1_icon <?php echo $filter_step['VISION']; ?>"><a class="click-xhttp-request" data-pcr_step="4"  href="{base_url}emt/vision" data-qr="output_position=content">Vision</a></li>

            <li class="trauma_ass_icon <?php echo $filter_step['AUD']; ?>"><a class="click-xhttp-request" data-pcr_step="5" href="{base_url}emt/auditary" data-qr="output_position=content">Auditary</a></li>
            <li class="patient_ass3_icon <?php echo $filter_step['MED']; ?>"><a class="click-xhttp-request" data-pcr_step="6" href="{base_url}emt/medicle_events" data-qr="output_position=content">Medical Event</a></li>

            <li class="patient_manage2_icon <?php echo $filter_step['INV']; ?>"><a class="click-xhttp-request" data-pcr_step="7" href="{base_url}emt/investigation" data-qr="output_position=content">Investigations</a></li>
            <li class="hospital_trans_icon <?php echo $filter_step['PRE']; ?>"><a class="click-xhttp-request" data-pcr_step="8" href="{base_url}emt/prescription" data-qr="output_position=content">Prescription</a></li>
            <li class="driver_pcr_icon <?php echo $filter_step['HOS']; ?>"><a class="click-xhttp-request" data-pcr_step="9" href="{base_url}emt/hospitalisation" data-qr="output_position=content">Hospitalisation</a></li>
            <li class="driver_pcr_icon <?php echo $filter_step['DPR']; ?>"><a class="click-xhttp-request" data-pcr_step="10" href="{base_url}emt/healthcard" data-qr="output_position=content">Healthcard</a></li>
                        
                          
                         
                   </ul>
               </div>

            </div>






        </div>
       





 </div>
    
     

</div>

