<?php
$CI = EMS_Controller::get_instance();

?>
<style>

 @media print {
  footer {page-break-after: always;}
}
</style>

<div class="width100 single_record">

    <div>
        <table class="table report_table">
            <tr class="single_record_back">                                     
                <td colspan="3">User details</td>
            </tr>
            <tr>                                     
                <td><strong>User Name</strong></td>
                <td colspan="2"><?php echo ucwords(strtolower($clg_data[0]->clg_first_name));?> <?php echo ucwords(strtolower($clg_data[0]->clg_last_name));?></td>
            </tr>
            <tr>                                     
                <td><strong>User Current Status</strong></td>
                <td colspan="2"><?php if($user_status[0]->status == 'free'){ echo "Free"; } else if($user_status[0]->status == 'atnd'){ echo "On Call"; }else if($user_status[0]->status == 'break'){ echo "Break"; }?></td>
            </tr>
            <tr>
                <td><strong>Total Calls</strong></td>
                <td><strong>Emergency Calls</strong></td>
                <td><strong>Non Emergency Calls</strong></td>
            </tr>
             <tr>
                <td><?php if($clg_data[0]->clg_group == "UG-EROSupervisor" || $clg_data[0]->clg_group == "UG-DCOSupervisor" || $clg_data[0]->clg_group == "UG-ERCPSupervisor" || $clg_data[0]->clg_group == "UG-PDASupervisor" || $clg_data[0]->clg_group == "UG-FDASupervisor" || $clg_data[0]->clg_group == "UG-FeedbackManager" || $clg_data[0]->clg_group == "UG-GrievianceManager"){echo "NA";}else{ echo current_login_agents_call_count($clg_data[0]->clg_group, $clg_data[0]->clg_ref_id, 'all');} ?> </td> 
                                <td><?php if($clg_data[0]->clg_group != "UG-ERO" && $clg_data[0]->clg_group != "UG-ERO-102"){echo "NA";}else{ echo current_login_agents_call_count($clg_data[0]->clg_group, $clg_data[0]->clg_ref_id, 'eme');} ?> </td>        
                                <td><?php if($clg_data[0]->clg_group != "UG-ERO" && $clg_data[0]->clg_group != "UG-ERO-102"){echo "NA";}else{ echo current_login_agents_call_count($clg_data[0]->clg_group, $clg_data[0]->clg_ref_id, 'non');} ?> </td>     
            </tr>
        </table>
        <table class="table report_table">

                <tr class="single_record_back">     
        <!--        <th style="line-height: 20px;">Date</th>-->
                    <th style="line-height: 20px;">Call Type</th>
                    <th style="line-height: 20px;">Call Total</th>
                </tr>
                <?php

                foreach ($call_details as $calls) { //var_dump($calls);?>
                    <tr>         
                        <td><?php echo ucwords($calls->pname); ?></td>
                        <td><?php $calls_total = get_inc_total_by_call_type($clg_data[0]->clg_ref_id,$calls->pcode); 
                        if($calls_total){
                            echo $calls_total;
                        }else{
                            echo "0";
                        }
                        ?></td>
                    </tr>
                    <?php
                }
                ?>

        </table>
        <div class="break_pdf">
            
        </div>
        <table class="table report_table">

        <tr class="single_record_back">     
<!--        <th style="line-height: 20px;">Date</th>-->
            <th style="line-height: 20px;">Name</th>
            <th style="line-height: 20px;">Login time</th>
            <th style="line-height: 20px;">Logout Time</th>
        </tr>
        <?php
        
        foreach ($login_details as $inc) { //var_dump($inc);?>
            <tr>         
<!--            <td><?php echo $inc->clg_login_time; ?></td> -->
                <td><?php echo ucwords($inc->clg_first_name . ' ' . $inc->clg_mid_name . ' ' . $inc->clg_last_name); ?></td> 
                <td><?php echo $inc->clg_login_time; ?></td>
                <td><?php echo $inc->clg_logout_time; ?></td>
            </tr>
            <?php
        }
        ?>

    </table>
         <table class="table report_table">

        <tr class="single_record_back">     
<!--        <th style="line-height: 20px;">Date</th>-->
            <th style="line-height: 20px;">Name</th>
            <th style="line-height: 20px;">Break time</th>
            <th style="line-height: 20px;">Back to Break Time</th>
        </tr>
        <?php
        foreach ($break_details as $break) { //var_dump($break);?>
            <tr>         
<!--            <td><?php echo $break->clg_login_time; ?></td> -->
                <td><?php echo $break->clg_first_name . ' ' . $break->clg_mid_name . ' ' . $break->clg_last_name ?></td> 
                <td><?php echo $break->clg_break_time; ?></td>
                <td><?php echo $break->clg_back_to_break_time; ?></td>
            </tr>
            <?php
        }
        ?>

    </table>
    </div>
</div>
    