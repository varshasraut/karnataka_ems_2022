<div class="width_25 float_right" style="margin-bottom: 10px;">
    <div class="button_field_row">
        <div class="button_box">
            <form action="<?php echo base_url(); ?>quality_forms/view_quality_master_report" method="post" enctype="multipart/form-data" target="form_frame">
                <input type="hidden" value="<?php echo $report_args['to_date']; ?>" name="to_date">
                <input type="hidden" value="<?php echo $report_args['from_date']; ?>" name="from_date">
                <input type="hidden" value="<?php echo $report_type; ?>" name="report_type">
                <input type="hidden" value="<?php echo $report_args['system_type']; ?>" name="system_type">
                <input type="hidden" value="<?php echo $report_args['tl_name']; ?>" name="tl_name">
                <input type="hidden" value="<?php echo $report_args['user_id']; ?>" name="user_id">
                <input type="hidden" value="<?php echo $report_args['call_type']; ?>" name="call_type">
                <input type="hidden" value="<?php echo $report_args['tna']; ?>" name="tna">
                <input type="hidden" value="<?php echo $report_args['fatal_error_indicator']; ?>" name="fatal_error_indicator">
                 
                <input type="submit" name="submit" value="Download" TABINDEX="3" class="float_right">
            </form>
        </div>

    </div>
</div>   
<table class="table report_table">

    <tr>                              
        <?php foreach ($header as $heading) { ?>
            <th style="line-height: 20px; font-size: 11px;"><?php echo $heading; ?></th>
            <?php } ?>
    </tr> 
    <?php 
    if($inc_data){
    foreach ($inc_data as $key=>$inc) { //var_dump($inc);

            $week = weekOfMonth(date('Y-m-d', strtotime($inc->added_date)));
            if($week == '1'){
                $weeks = "1";
            }else if($week == '2'){
                $weeks = "2";
            }else if($week == '3'){
                $weeks = "3";
            }else if($week == '4'){
                $weeks = "4";
            }else if($week == '5'){
                $weeks = "5";
            }
        ?>
        <tr style="font-size: 11px;">         
        <td><?php echo $key+1; ?></td>
            <td><?php echo date('F', strtotime($inc->added_date)); ?></td>
            <td><?php echo $inc->added_date;?></td>
            <td><?php echo date('Y-m-d', strtotime($inc->inc_datetime));?></td>
            <td>Week <?php echo $weeks;?></td>
            <td><?php 
            $u_name = get_clg_data_by_ref_id($inc->qa_ad_user_ref_id); 
            echo ucwords($u_name[0]->clg_first_name.' '.$u_name[0]->clg_mid_name.' '.$u_name[0]->clg_last_name); ?>
            </td> 
            <td><?php 
           // var_dump($u_name[0]->clg_senior);
            $tl_name = get_clg_data_by_ref_id($u_name[0]->clg_senior);
            echo ucwords($tl_name[0]->clg_first_name.' '.$tl_name[0]->clg_mid_name.' '.$tl_name[0]->clg_last_name);
            ?></td>
            <td>
                <?php 
            //var_dump($tl_name[0]->clg_senior);
            $sm_name = get_clg_data_by_ref_id($tl_name[0]->clg_senior);
            echo ucwords($sm_name[0]->clg_first_name.' '.$sm_name[0]->clg_mid_name.' '.$sm_name[0]->clg_last_name);
            ?>
                
            </td>
           <td><?php 
            //echo $stat_data->qa_name;
            $qa_name = get_clg_data_by_ref_id($inc->added_by); 
            echo ucwords($qa_name[0]->clg_first_name.' '.$qa_name[0]->clg_mid_name.' '.$qa_name[0]->clg_last_name); ?>
            </td> 
<!--            <td></td>-->
            
            <td><?php  echo $inc->inc_ref_id; ?></td>
            <td><?php  echo get_parent_purpose_of_call( $inc->inc_type);?></td>
            <td ><?php echo $inc->clr_mobile; ?></td>
            <td><?php  echo ucwords(get_purpose_of_call( $inc->inc_type)); ?></td>
            <td>
                <?php 
                if($inc->inc_complaint != '' || $inc->inc_complaint != 0){
                    echo get_cheif_complaint( $inc->inc_complaint);
                }else if($inc->inc_mci_nature != '' || $inc->inc_mci_nature != 0){
                    echo get_mci_nature_service( $inc->inc_mci_nature);
                }
                ?>
            </td>
            <td><?php //$open_greet = json_decode($inc->open_greet);
           
            //if($open_greet->open_greet == 'Y'){ echo "YES";}else{ echo "NO"; }
            echo $inc->open_greet_marks;
            ?></td>
            <td><?php //$ver_mat = json_decode($inc->ver_mat);
           
            //if($ver_mat->ver_mat == 'Y'){ echo "YES"; }else{ echo "NO"; }
            echo $inc->ver_matrix_marks;
            ?></td>
            <td><?php //$comp_systm = json_decode($inc->comp_systm);
           
            //if($comp_systm->comp_systm == 'Y'){ echo "YES"; }else{ echo "NO";}
            echo $inc->comp_systm_marks;
            ?></td>
             <td><?php //$notification = json_decode($inc->notification);
           
            //if($notification->notification == 'Y'){ echo "YES";}else{ echo "NO";}
            echo $inc->notification_marks;
            ?></td>
             
            <td><?php //$hold_procedure = json_decode($inc->hold_procedure);
           
            //if($hold_procedure->hold_procedure == 'Y'){ echo "YES";}else{ echo "NO";}
            echo $inc->hold_procedure_marks;
            ?></td>
            
            <td><?php //$commu_skill = json_decode($inc->commu_skill);
           
            //if($commu_skill->commu_skill == 'Y'){ echo "YES";}else{ echo "NO";}
            echo $inc->commu_skill_marks;
            ?></td>
            <td><?php //$closing_greet = json_decode($inc->closing_greet);
           
            //if($closing_greet->closing_greet == 'Y'){ echo "YES";}else{ echo "NO";}
            echo $inc->closing_greet_marks;
            ?></td>
              
            <td>
                <?php 
                //$fetal_indicator = json_decode($inc->fetal_indicator);
                if($inc->fetal_error_indicator){
                echo $inc->fetal_error_indicator;
                }else{echo "NA";}
                ?>
            </td>
            <td><?php echo $inc->quality_score ." %"; ?></td>
            <td><?php echo $inc->performer_group; ?></td>
            <td><?php echo $inc->audit_method; ?></td>
            <td><?php echo $inc->call_observation; ?></td>
            <td><?php echo ucwords($inc->tna); ?></td>
            <td><?php echo $inc->feedback_added_date; ?></td>
            <td><?php if($inc->feedback_remark != NULL){echo "Complete";}else{echo "Pending"; } ?></td>
            <td><?php echo $inc->quality_remark; ?></td>
            <td><?php echo $inc->modify_by; ?></td>
            <td><?php echo $inc->feedback_remark; ?></td>
            <td><?php echo $inc->feedback_status; ?></td>
            <td><?php echo $inc->feedback_added_date; ?></td>
        </tr>
    <?php } }else{ ?>
        <tr>         
            <td colspan="34" style="text-align: center;">
                no record found
            </td>
          
        </tr>
    <?php 
    } ?>

</table>