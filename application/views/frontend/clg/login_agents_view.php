<?php $CI = EMS_Controller::get_instance(); ?>
<h2>Login Agent List</h2><br>
<div class="">
    <ul class="login_agents_outer">
        <li>
            <?php 
            $ero104_login = $CI->modules->get_tool_config('MT-AGENTS-ERO104-LOGIN', 'M-AGENTS-LOGIN', true);
            if($ero104_login){ ?>
            <div class="login_agents">
                <a class="click-xhttp-request action_button" data-href="{base_url}clg/show_login_user" data-qr="output_position=content&amp;module_name=login_agents&amp;tlcode=MT-AGENTS-LOGIN-LIST&amp;clg_group=UG-ERO-104&showprocess=yes"><span><?php echo $login_clg['ERO104']?$login_clg['ERO104']:0; ?></span></a>
                ERO 104
                <div>&nbsp;</div>
                <!--<div><a class="click-xhttp-request action_button" data-href="{base_url}clg/show_login_user" data-qr="output_position=content&amp;module_name=login_agents&amp;tlcode=MT-AGENTS-LOGIN-LIST&amp;clg_group=UG-ERO&showprocess=yes"><span style="font-size:10px;text-align:center;width:49%;display:inline-block;background-color: gainsboro;">108</span></a><a class="click-xhttp-request action_button" data-href="{base_url}clg/show_login_user" data-qr="output_position=content&amp;module_name=login_agents&amp;tlcode=MT-AGENTS-LOGIN-LIST&amp;clg_group=UG-ERO-102&showprocess=yes"><span style="font-size:10px;text-align:center;width:49%;display:inline-block;background-color: gainsboro;border-left: 1px solid #7d7878;">102</span></a></div>-->
            </div>
            <?php } ?>
            <?php 
            $ero_login = $CI->modules->get_tool_config('MT-AGENTS-ERO-LOGIN', 'M-AGENTS-LOGIN', true);
            if($ero_login){ ?>
            <div class="login_agents">
                <a class="click-xhttp-request action_button" data-href="{base_url}clg/show_login_user" data-qr="output_position=content&amp;module_name=login_agents&amp;tlcode=MT-AGENTS-LOGIN-LIST&amp;clg_group=UG-ERO&showprocess=yes"><span><?php echo $login_clg['ERO']?$login_clg['ERO']:0; ?></span></a>
                ERO 
                <div>&nbsp;</div>
                <!--<div><a class="click-xhttp-request action_button" data-href="{base_url}clg/show_login_user" data-qr="output_position=content&amp;module_name=login_agents&amp;tlcode=MT-AGENTS-LOGIN-LIST&amp;clg_group=UG-ERO&showprocess=yes"><span style="font-size:10px;text-align:center;width:49%;display:inline-block;background-color: gainsboro;">108</span></a><a class="click-xhttp-request action_button" data-href="{base_url}clg/show_login_user" data-qr="output_position=content&amp;module_name=login_agents&amp;tlcode=MT-AGENTS-LOGIN-LIST&amp;clg_group=UG-ERO-102&showprocess=yes"><span style="font-size:10px;text-align:center;width:49%;display:inline-block;background-color: gainsboro;border-left: 1px solid #7d7878;">102</span></a></div>-->
            </div>
            <?php } ?>
            <?php $dco_login = $CI->modules->get_tool_config('MT-AGENTS-DCO-LOGIN', 'M-AGENTS-LOGIN', true);
            if($dco_login){ 
            ?>
            <div class="login_agents">
                <a class="click-xhttp-request action_button" data-href="{base_url}clg/show_login_user" data-qr="output_position=content&amp;module_name=login_agents&amp;tlcode=MT-AGENTS-LOGIN-LIST&amp;clg_group=UG-DCO&showprocess=yes"><span><?php echo $login_clg['DCO']?$login_clg['DCO']:0; ?></span></a>
                DCO  
                <div>&nbsp;</div> 
                <!--<div><a class="click-xhttp-request action_button" data-href="{base_url}clg/show_login_user" data-qr="output_position=content&amp;module_name=login_agents&amp;tlcode=MT-AGENTS-LOGIN-LIST&amp;clg_group=UG-DCO&showprocess=yes"><span style="font-size:10px;text-align:center;width:49%;display:inline-block;background-color: gainsboro;">108</span></a><a class="click-xhttp-request action_button" data-href="{base_url}clg/show_login_user" data-qr="output_position=content&amp;module_name=login_agents&amp;tlcode=MT-AGENTS-LOGIN-LIST&amp;clg_group=UG-DCO-102&showprocess=yes"><span style="font-size:10px;text-align:center;width:49%;display:inline-block;background-color: gainsboro;border-left: 1px solid #7d7878;">102</span></a></div>-->         
            </div>
            <?php } ?>
            <?php $pda_login = $CI->modules->get_tool_config('MT-AGENTS-PDA-LOGIN', 'M-AGENTS-LOGIN', true);
            if($pda_login){ 
            ?>
            <div class="login_agents">
                <a class="click-xhttp-request action_button" data-href="{base_url}clg/show_login_user" data-qr="output_position=content&amp;module_name=login_agents&amp;tlcode=MT-AGENTS-LOGIN-LIST&amp;clg_group=UG-PDA&showprocess=yes"><span><?php echo $login_clg['PDA']?$login_clg['PDA']:0; ?></span></a>
                PDA    
                <div>&nbsp;</div>            
            </div>
            <?php } ?>
            <?php $fda_login = $CI->modules->get_tool_config('MT-AGENTS-FDA-LOGIN', 'M-AGENTS-LOGIN', true);
            if($fda_login){ 
            ?>
            <div class="login_agents">
                <a class="click-xhttp-request action_button" data-href="{base_url}clg/show_login_user" data-qr="output_position=content&amp;module_name=login_agents&amp;tlcode=MT-AGENTS-LOGIN-LIST&amp;clg_group=UG-FDA&showprocess=yes"><span><?php echo $login_clg['FDA']?$login_clg['FDA']:0; ?></span></a>
                FDA    
                <div>&nbsp;</div>            
            </div>
            <?php } ?>
            <?php $ercp_login = $CI->modules->get_tool_config('MT-AGENTS-ERCP-LOGIN', 'M-AGENTS-LOGIN', true);
            if($ercp_login){ 
            ?>
            <div class="login_agents">
                <a class="click-xhttp-request action_button" data-href="{base_url}clg/show_login_user" data-qr="output_position=content&amp;module_name=login_agents&amp;tlcode=MT-AGENTS-LOGIN-LIST&amp;clg_group=UG-ERCP&showprocess=yes"><span><?php echo $login_clg['ERCP']?$login_clg['ERCP']:0; ?></span></a>
                ERCP     
                <div>&nbsp;</div>           
            </div>
            <?php } ?>
            </li>
        <li>
            <?php $grievance_login = $CI->modules->get_tool_config('MT-AGENTS-Grievance-LOGIN', 'M-AGENTS-LOGIN', true);
            if($grievance_login){ 
            ?>
            <div class="login_agents">
                <a class="click-xhttp-request action_button" data-href="{base_url}clg/show_login_user" data-qr="output_position=content&amp;module_name=login_agents&amp;tlcode=MT-AGENTS-LOGIN-LIST&amp;clg_group=UG-Grievance&showprocess=yes"><span><?php echo $login_clg['Grievance']?$login_clg['Grievance']:0; ?></span></a>
                Grievance     
                <div>&nbsp;</div>           
            </div>
            <?php } ?>
            <?php $feedback_login = $CI->modules->get_tool_config('MT-AGENTS-Feedback-LOGIN', 'M-AGENTS-LOGIN', true);
            if($feedback_login){ 
            ?>
            <div class="login_agents">
                <a class="click-xhttp-request action_button" data-href="{base_url}clg/show_login_user" data-qr="output_position=content&amp;module_name=login_agents&amp;tlcode=MT-AGENTS-LOGIN-LIST&amp;clg_group=UG-Feedback&showprocess=yes"><span><?php echo $login_clg['Feedback']?$login_clg['Feedback']:0; ?></span></a>
                Feedback     
                <div>&nbsp;</div>           
            </div>
            <?php } ?>
            <?php $quality_login = $CI->modules->get_tool_config('MT-AGENTS-Quality-LOGIN', 'M-AGENTS-LOGIN', true);
            if($quality_login){ 
            ?>
            <div class="login_agents">
                <a class="click-xhttp-request action_button" data-href="{base_url}clg/show_login_user" data-qr="output_position=content&amp;module_name=login_agents&amp;tlcode=MT-AGENTS-LOGIN-LIST&amp;clg_group=UG-Quality&showprocess=yes"><span><?php echo $login_clg['Quality']?$login_clg['Quality']:0; ?></span></a>
                Quality     
                <div>&nbsp;</div>           
            </div>
            <?php } ?>
            <?php $teamlead_login = $CI->modules->get_tool_config('MT-AGENTS-TeamLeader-LOGIN', 'M-AGENTS-LOGIN', true);
            if($teamlead_login){ 
            ?>
            <div class="login_agents">
                <a class="click-xhttp-request action_button" data-href="{base_url}clg/show_login_user" data-qr="output_position=content&amp;module_name=login_agents&amp;tlcode=MT-AGENTS-LOGIN-LIST&amp;clg_group=Team_Lead&showprocess=yes"><span><?php echo $login_clg['EROSupervisor'] + $login_clg['DCOSupervisor'] + $login_clg['ERCTRAINING']; ?></span></a>
                Team Leader  
                <div>&nbsp;</div>           
            </div>
            <?php } ?>
            <?php $manager_login = $CI->modules->get_tool_config('MT-AGENTS-Managers-LOGIN', 'M-AGENTS-LOGIN', true);
            if($manager_login){ 
            ?>
            <div class="login_agents">
                <a class="click-xhttp-request action_button" data-href="{base_url}clg/show_login_user" data-qr="output_position=content&amp;module_name=login_agents&amp;tlcode=MT-AGENTS-LOGIN-LIST&amp;clg_group=Manager&showprocess=yes"><span><?php  echo $login_clg['ERCManager'] + $login_clg['ShiftManager'] + $login_clg['QualityManager'] + $login_clg['ERCPSupervisor'] + $login_clg['BioMedicalManager']; ?></span></a>
                Managers
                <div>&nbsp;</div>           
            </div>
            <?php } ?>
            <!--<div class="login_agents">
                <a class="click-xhttp-request action_button" data-href="{base_url}clg/show_login_user" data-qr="output_position=content&amp;module_name=login_agents&amp;tlcode=MT-AGENTS-LOGIN-LIST&amp;clg_group=UG-EROSupervisor&showprocess=yes"><span><?php echo $login_clg['DCOSupervisor']?$login_clg['EROSupervisor']:0; ?></span></a>
                ERO Supervisor   
                <div>&nbsp;</div>           
            </div>
            <div class="login_agents">
                <a class="click-xhttp-request action_button" data-href="{base_url}clg/show_login_user" data-qr="output_position=content&amp;module_name=login_agents&amp;tlcode=MT-AGENTS-LOGIN-LIST&amp;clg_group=UG-DCOSupervisor&showprocess=yes"><span><?php echo $login_clg['DCOSupervisor']?$login_clg['DCOSupervisor']:0; ?></span></a>
                DCO Supervisor        
                <div>&nbsp;</div>       
            </div>
            <div class="login_agents">
                <a class="click-xhttp-request action_button" data-href="{base_url}clg/show_login_user" data-qr="output_position=content&amp;module_name=login_agents&amp;tlcode=MT-AGENTS-LOGIN-LIST&amp;clg_group=UG-PDASupervisor&showprocess=yes"><span><?php echo $login_clg['PDASupervisor']?$login_clg['PDASupervisor']:0; ?></span></a>
                PDA Supervisor       
                <div>&nbsp;</div>         
            </div>
            <div class="login_agents">
                <a class="click-xhttp-request action_button" data-href="{base_url}clg/show_login_user" data-qr="output_position=content&amp;module_name=login_agents&amp;tlcode=MT-AGENTS-LOGIN-LIST&amp;clg_group=UG-FDASupervisor&showprocess=yes"><span><?php echo $login_clg['FDASupervisor']?$login_clg['FDASupervisor']:0; ?></span></a>
                FDA Supervisor       
                <div>&nbsp;</div>         
            </div>
            <div class="login_agents">
                <a class="click-xhttp-request action_button" data-href="{base_url}clg/show_login_user" data-qr="output_position=content&amp;module_name=login_agents&amp;tlcode=MT-AGENTS-LOGIN-LIST&amp;clg_group=UG-ERCPSupervisor&showprocess=yes"><span><?php echo $login_clg['ERCPSupervisor']?$login_clg['ERCPSupervisor']:0; ?></span></a>
                ERCP Supervisor     
                <div>&nbsp;</div>          
            </div>
            <div class="login_agents">
                <a class="click-xhttp-request action_button" data-href="{base_url}clg/show_login_user" data-qr="output_position=content&amp;module_name=login_agents&amp;tlcode=MT-AGENTS-LOGIN-LIST&amp;clg_group=UG-GrievianceManager&showprocess=yes"><span><?php echo $login_clg['GrievianceManager']?$login_clg['GrievianceManager']:0; ?></span></a>
                Grievance Manager     
                <div>&nbsp;</div>       
            </div>
            <div class="login_agents">
                <a class="click-xhttp-request action_button" data-href="{base_url}clg/show_login_user" data-qr="output_position=content&amp;module_name=login_agents&amp;tlcode=MT-AGENTS-LOGIN-LIST&amp;clg_group=UG-FeedbackManager&showprocess=yes"><span><?php echo $login_clg['FeedbackManager']?$login_clg['FeedbackManager']:0; ?></span></a>
                Feedback Manager   
                <div>&nbsp;</div>           
            </div>-->
        </li>
    </ul>
    
</div>
<div class="width100" id="login_user_list">
    
</div>