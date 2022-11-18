<?php
$step = array('PCR', 'CNS', 'HIS', 'AS1', 'TRA', 'AS2', 'MG1', 'MG2', 'HPT', 'DPR');


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
           

            <li class="hospital_trans_icon <?php echo $filter_step['PCR']; ?>"><a class="click-xhttp-request" data-pcr_step="1" href="{base_url}pcr/epcr" data-qr="output_position=content">E-PCR</a></li>
            <!--                <li class="call_info_icon"><a class="click-xhttp-request" data-pcr_step="1" href="{base_url}pcr/call_info" data-qr="output_position=content">Call Information</a></li>-->
            <!--                <li class="patient_details_icon"><a class="click-xhttp-request" data-pcr_step="2" href="{base_url}pcr/patient_details" data-qr="output_position=content">Patient Details</a></li>-->
            <li class="consents_icon <?php echo $filter_step['CNS']; ?>"><a class="click-xhttp-request" data-pcr_step="2" href="{base_url}pcr/consents" data-qr="output_position=content&amp;step=2">Consents</a></li>

            <li class="consents_icon <?php echo $filter_step['HIS']; ?>"><a class="click-xhttp-request" data-pcr_step="3" href="{base_url}pcr/patient_history" data-qr="output_position=content&amp;step=3">History</a></li>

            <!--                <li class="patient_history_icon"><a class="click-xhttp-request" data-pcr_step="4"  href="{base_url}pcr?step=4" data-qr="output_position=content">Patient History</a></li>-->
            <li class="patient_ass1_icon <?php echo $filter_step['AS1']; ?>"><a class="click-xhttp-request" data-pcr_step="4"  href="{base_url}pcr/ptn_asst" data-qr="output_position=content">Assement 1</a></li>

            <li class="trauma_ass_icon <?php echo $filter_step['TRA']; ?>"><a class="click-xhttp-request" data-pcr_step="5" href="{base_url}pcr/trauma_assessment" data-qr="output_position=content">Trauma</a></li>
            <li class="patient_ass3_icon <?php echo $filter_step['AS2']; ?>"><a class="click-xhttp-request" data-pcr_step="6" href="{base_url}pcr/ptn_advasst" data-qr="output_position=content">Assement 2</a></li>
            <li class="patient_manage1_icon <?php echo $filter_step['MG1']; ?>"><a class="click-xhttp-request" data-pcr_step="7" href="{base_url}pcr/patient_mng" data-qr="output_position=content">Management 1</a></li>
            <li class="patient_manage2_icon <?php echo $filter_step['MG2']; ?>"><a class="click-xhttp-request" data-pcr_step="8" href="{base_url}pcr/ptn_inv" data-qr="output_position=content">Management 2</a></li>
            <li class="hospital_trans_icon <?php echo $filter_step['HPT']; ?>"><a class="click-xhttp-request" data-pcr_step="9" href="{base_url}pcr/hospital_transfer" data-qr="output_position=content">Hospital Transfer</a></li>
            <li class="driver_pcr_icon <?php echo $filter_step['DPR']; ?>"><a class="click-xhttp-request" data-pcr_step="10" href="{base_url}pcr/driver_pcr" data-qr="output_position=content">Driver PCR</a></li>

              <div class="list_icon float_left"><img src="{base_url}themes/backend/images/icon_img.png" class="nav_icon" alt="Menu"> <a class="hide menu_titile">MENU</a></div>
            
        </ul>
      
        
        
    </div>
       
    
    
    
    <div id="home_nav_bar" class="hide home_navigation_bar">
        <div class="ms_home_header_menu"> 


           <div class="navigation"> 
               <div class="inner">  
                   <ul>
                       
                        <li class="menu_icon"  style="display: block;">
                            <a class="click-xhttp-request">MENU</a>
                                
                        </li>
                  
                            <li class="hospital_trans_icon <?php echo $filter_step['PCR']; ?>" style="display: block;">
                                <a class="click-xhttp-request" data-pcr_step="1" href="{base_url}pcr/epcr" data-qr="output_position=content">E-PCR</a>
                                
                            </li>
                            
                      
                           <li class="consents_icon <?php echo $filter_step['CNS']; ?>" style="display: block;">
                               <a class="click-xhttp-request" data-pcr_step="2" href="{base_url}pcr/consents" data-qr="output_position=content&amp;step=2">Consents</a>
                           </li>
                  
                       
                       <li class="consents_icon <?php echo $filter_step['HIS']; ?>" style="display: block;">
                           <a class="click-xhttp-request" data-pcr_step="3" href="{base_url}pcr/patient_history" data-qr="output_position=content&amp;step=3">History</a>
                       </li>
                       
                     
                                         
                       <li class="patient_ass1_icon <?php echo $filter_step['AS1']; ?>" style="display: block;">
                           <a class="click-xhttp-request" data-pcr_step="4"  href="{base_url}pcr/ptn_asst" data-qr="output_position=content">Assement 1</a>
                       </li>

                <li class="trauma_ass_icon <?php echo $filter_step['TRA']; ?>" style="display: block;">
                    <a class="click-xhttp-request" data-pcr_step="5" href="{base_url}pcr/trauma_assessment" data-qr="output_position=content">Trauma</a>
                </li>
                
                <li class="patient_ass3_icon <?php echo $filter_step['AS2']; ?>" style="display: block;">
                    <a class="click-xhttp-request" data-pcr_step="6" href="{base_url}pcr/ptn_advasst" data-qr="output_position=content">Assement 2</a>
                </li>
                <li class="patient_manage1_icon <?php echo $filter_step['MG1']; ?> " style="display: block;">
                    <a class="click-xhttp-request" data-pcr_step="7" href="{base_url}pcr/patient_mng" data-qr="output_position=content">Management 1</a>
                </li>
                <li class="patient_manage2_icon <?php echo $filter_step['MG2']; ?>" style="display: block;"><a class="click-xhttp-request" data-pcr_step="8" href="{base_url}pcr/ptn_inv" data-qr="output_position=content">Management 2</a></li>
                <li class="hospital_trans_icon <?php echo $filter_step['HPT']; ?>" style="display: block;"><a class="click-xhttp-request" data-pcr_step="9" href="{base_url}pcr/hospital_transfer" data-qr="output_position=content">Hospital Transfer</a></li>
                <li class="driver_pcr_icon <?php echo $filter_step['DPR']; ?>" style="display: block;"><a class="click-xhttp-request" data-pcr_step="10" href="{base_url}pcr/driver_pcr" data-qr="output_position=content">Driver PCR</a></li>
                        
                          
                         
                   </ul>
               </div>

            </div>






        </div>
       





 </div>
    
     

</div>

