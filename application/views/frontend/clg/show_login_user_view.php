<?php
$CI = EMS_Controller::get_instance();

$clg_status = array('0' => 'Inactive', '1' => 'Active', '2' => 'Deleted');
$sts = array('0' => 'Active', '1' => 'Inactive');

?>

<script>
// setInterval(function(){
//            $('.show_login_user').click(); 
//        }, 60000);
</script>
<br><br>
<div class="breadcrumb float_left">
    <ul>
        <li><span>Login Employee List</span></li>
    </ul>
</div>


<div class="box3">    

    <div class="permission_list group_list">

        <form method="post" action="#" name="colleagues_list_form" class="colleagues_list_form">  

            <div id="clg_filters"> 
                <div class="width100">

                <div class="field_row width_25">

                    <div class="filed_select">
                        <div class="width50 drg float_left">
                            <div class="width100 float_left">
                                <div class="style6 float_left">Select User: </div>
                            </div>
                            <div class="width100 float_left">

            <input name="user_id" class="mi_autocomplete" data-href="<?php echo base_url();?>auto/get_auto_clg?clg_group=<?php echo $group_code; ?>&is_login=yes"  data-value="<?php echo $clg_ref_id ;?>" value="<?php echo $clg_ref_id;?>" type="text" tabindex="2" placeholder="User Name" autocomplete="off">
          
            
                            </div>
                        </div>
                        <div class="width50 drg float_left">
                            <div class="width100 float_left">
                                <div class="style6 float_left">Select Status: </div>
                            </div>
                            <div class="width100 float_left">
                                <select name="clg_is_login">
                                    <option value="">Select Status</option>
                                    
                                    <option value="break" <?php if($clg_is_login[0] == 'break'){ echo "selected"; }?>>Break</option> 
                                    <option value="free" <?php if($clg_is_login[0] == 'atnd'){ echo "selected"; }?>>Available</option> 
                                    <option value="atnd" <?php if($clg_is_login[0] == 'free'){ echo "selected"; }?>>On Call</option> 
                                    
                                </select>
                            </div>
                        </div>

                    </div>


                </div>
                <!-- <div class="field_row width50">

                    <div class="filed_select">
                        <div class="width50 drg float_left">
                            <div class="width100 float_left">
                                <div class="style6 float_left">Search: </div>
                            </div>
                            <div class="width100 float_left">

              <input type="text" class="search_catalog" name="search_user" value="<?php echo $search; ?>" placeholder="Search"/>
          
            
                            </div>
                        </div>

                    </div>


                </div> -->
                 <div class="width_25 float_left" style="margin-top: 10px;">
                    <div class="button_field_row">
                        <div class="button_box">
  <input type="hidden" value="<?php echo $group_code?>" name="clg_group">
                                <!-- <input type="submit" name="submit" value="Submit" TABINDEX="3">   -->
                            <input type="button" name="submit"  value="Submit" data-qr="output_position=list_table&amp;reports=view&amp;module_name=reports&amp;showprocess=no" data-href="<?php echo base_url(); ?>clg/show_login_user" class="form-xhttp-request btn clg_search show_login_user" >
                            <input type="reset" class="search_button btn  form-xhttp-request" name="" value="Reset Filter" data-href="{base_url}clg/login_agents" data-qr="output_position=content&amp;flt=reset&amp;type=inc" />
                        </div>
                    </div>
                </div>
            </div>
            </div>

            <div id="list_table">


                <table class="table report_table">

                    <tr>                
                        
                        <th nowrap>User Id</th>
                        <th nowrap>Name</th>
                        <!-- <th nowrap>Mobile Number</th> -->
                        <?php 
                        if($group_code == "UG-ERO"){
                            ?>
                            <th nowrap>Total Calls</th>
                            <th nowrap>Emergency Calls</th>
                            <th nowrap>Non Emergency Calls</th>
                        <?php }
                        ?>
                        <?php 
                        if($group_code == "UG-DCO"){
                            ?>
                            <th nowrap>Total Case Closed</th>
                            <th nowrap>Victim Count</th>
<!--                            <th nowrap>Total Cases Closed</th>-->
                           <th nowrap>Total Validated Case</th>
                            <th nowrap>Victim Validated</th>
                            
<!--                            <th nowrap>Total Validate Closure</th>-->
                        <?php }
                        ?>
                        <!--<th nowrap>Avaya Id</th>
                        <th>Group</th>-->
                        <th nowrap>Login Time</th>
                        <th width='200px;'>Status</th>
                        <th width='200px;'>Status from</th>
                        <?php 
                        if($group_code == "UG-DCO" || $group_code == "UG-ERO" || $group_code == "UG-Feedback" || $group_code == "UG-Grievance" || $group_code == "UG-FDA" || $group_code == "UG-PDA"){
                        ?>
                        <th>Action</th>
                        <?php
                        } 
                        ?>
                        

                    </tr>

                    <?php
                    if (count($colleagues) > 0) {

                        foreach ($colleagues as $colleague) {
                                  $JC =0;
                                    $JC_ON_SCENE_CARE=0;
                                    $Total_closure=0;
                                    $validation_count=0;
                                    $Total_closure_inc =0;
                                    $total_validation_inc =0;
                            
                           // 
                            if($colleague->clg_group == "Manager" || $colleague->clg_group == "Team_Lead" || $colleague->clg_group == "UG-EROSupervisor" || $colleague->clg_group == "UG-DCOSupervisor" || $colleague->clg_group == "UG-ERCPSupervisor" || $colleague->clg_group == "UG-PDASupervisor" || $colleague->clg_group == "UG-FDASupervisor" || $colleague->clg_group == "UG-FeedbackManager" || $colleague->clg_group == "UG-GrievianceManager"){ $total_calls = "NA"; }else{ $total_calls = current_login_agents_call_count($colleague->clg_group, $colleague->clg_ref_id, 'all'); }
                            
                            if($colleague->clg_group != "UG-ERO" && $colleague->clg_group != "UG-ERO-102"){ $eme_calls = "NA" ;}else{ $eme_calls = current_login_agents_call_count($colleague->clg_group, $colleague->clg_ref_id, 'eme'); }
                            if($colleague->clg_group != "UG-ERO" && $colleague->clg_group != "UG-ERO-102"){$non_eme_calls =  "NA";}else{ $non_eme_calls =  current_login_agents_call_count($colleague->clg_group, $colleague->clg_ref_id, 'non'); }
                            if($colleague->clg_group != "UG-DCO"){$JC =  "NA";}else{ $JC =  current_login_agents_call_count($colleague->clg_group, $colleague->clg_ref_id, 'JC'); }
                            if($colleague->clg_group != "UG-DCO"){$JC_ON_SCENE_CARE =  "NA";}else{ $JC_ON_SCENE_CARE =  current_login_agents_call_count($colleague->clg_group, $colleague->clg_ref_id, 'JC_ON_SCENE_CARE'); }
                            if($colleague->clg_group != "UG-DCO"){$validation_count =  "NA";}else{ $validation_count =  current_login_agents_call_count($colleague->clg_group, $colleague->clg_ref_id, 'validation_count'); }
                            if($colleague->clg_group != "UG-DCO"){$Total_closure_inc =  "NA";}else{ $Total_closure_inc =  current_login_agents_call_count($colleague->clg_group, $colleague->clg_ref_id, 'Total_closure_inc'); }
                            if($colleague->clg_group != "UG-DCO"){$total_validation_inc =  "NA";}else{ $total_validation_inc =  current_login_agents_call_count($colleague->clg_group, $colleague->clg_ref_id, 'total_validation_inc'); }
                            
                            ?>
                            <tr>
                              
                                <td><?php echo strtoupper($colleague->clg_ref_id); ?></td>
                                <?php if($colleague->clg_group == "UG-ERO" || $colleague->clg_group == "UG-DCO"){ ?>
                                    <td><a href="{base_url}calls/show_user_all_data" class="onpage_popup" data-qr="output_position=popup_div&clg_ref_id=<?php echo $colleague->clg_ref_id; ?>&group_code=<?php echo $group_code; ?>&showprocess=yes?action=view" data-popupwidth="1240" data-popupheight="980" style="color:#000;"><?php echo ucwords(strtolower($colleague->clg_first_name)) . " " . ucwords(strtolower($colleague->clg_last_name)); ?></a></td>
                                <?php }
                                else{ ?>
                                     <td><?php echo ucwords(strtolower($colleague->clg_first_name)) . " " . ucwords(strtolower($colleague->clg_last_name)); ?></td>
                                <?php } ?>
                               
                                <!-- <td><?php echo $colleague->clg_mobile_no; ?></td>  -->
                                <?php 
                                if($group_code == "UG-ERO"){
                                    ?>
                                <td><?php  
                                    if($eme_calls == 'NA'){ $eme_calls = 0; } 
                                    if($non_eme_calls == 'NA'){ $non_eme_calls = 0; }
                                    echo $eme_calls+$non_eme_calls; 
                                ?> 
                                </td> 
                                <td><?php echo $eme_calls;  ?> </td>        
                                <td><?php echo $non_eme_calls; ?> </td>  
                                <?php } ?>
                                <?php 
                                if($group_code == "UG-DCO"){
                                    //echo $JC; 
                                    ?>
                                    <!--<td><?php echo $JC; ?> </td>  
                                    <td><?php echo $JC_ON_SCENE_CARE/10; ?> </td>  -->
                                    <?php 
                                    $count_ON_SCENE_CARE = $JC_ON_SCENE_CARE/10;
                                    $Total_closure = $JC + $count_ON_SCENE_CARE ;
                                    $closure = $JC_ON_SCENE_CARE+$JC;
                                    ?>
                                    <td><?php echo $Total_closure_inc; ?> </td>
                                    <td><?php echo round($Total_closure); ?> </td>
<!--                                    <td><?php echo $Total_closure_inc; ?> </td>-->
                                    <td><?php echo $total_validation_inc; ?> </td>
                                    <td><?php echo $validation_count; ?> </td>
                                    
                                    
                                    <?php
                                    $JC =0;
                                    $JC_ON_SCENE_CARE=0;
                                    $Total_closure=0;
                                    $validation_count=0;
                                    $Total_closure_inc =0;
                                    $total_validation_inc =0;

                                }
                                ?>
                                
                                <!--<td><?php echo $colleague->clg_avaya_agentid; ?> </td>     
                                <td><?php echo $colleague->clg_group; ?> </td>   -->   
                                <td><?php echo $colleague->logintime; ?> </td> 
                                <td><?php 
                                
                                if($colleague->status =="free"){ echo "Available"; }else if($colleague->status =="atnd"){echo "On Call";}else if($colleague->status =="break"){ echo "Break".':'.$colleague->break_name; }else{ echo "Available"; }
                                     

?>

                                </td>  
                                <td><?php echo $colleague->brk_time; ?> </td> 
                                <?php 
                        if($group_code == "UG-DCO" || $group_code == "UG-ERO" || $group_code == "UG-Feedback" || $group_code == "UG-Grievance" || $group_code == "UG-FDA" || $group_code == "UG-PDA"){
                        ?>
                        <td><?php
                             $avaya_status_args = array('ext_no'=>$colleague->clg_avaya_extension,'agent_id'=>$colleague->clg_avaya_agentid);
                               
                $avaya_status = get_avaya_status($avaya_status_args);
             
                
    if($avaya_status->status == 'C'){ ?>
                                    <div id="call_barging_<?php echo $colleague->clg_ref_id; ?>">
                                           <a class="click-xhttp-request btn" data-href="{base_url}avaya_api/start_call_barging" data-qr="agentid=<?php echo $colleague->clg_avaya_agentid; ?>&ext=<?php echo $colleague->clg_avaya_extension; ?>&clg_id=<?php echo $colleague->clg_ref_id; ?>" name="<?php echo $colleague->clg_ref_id; ?>" style="display: block;">Start Call Barge In</a>
                                    </div>

                            <?php
                        } ?> </td>   
                        <?php
                        } 
                        ?>
                                

                            </tr>
    <?php }

} else { ?>

                        <tr><td colspan="9" class="no_record_text">No history Found</td></tr>

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

                                <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}clg/show_login_user" data-qr="output_position=content&amp;flt=true">

<?php echo rec_perpg($pg_rec); ?>

                                </select>

                            </div>

                            <div class="float_right">
                                <span> Total records: <?php if (@$total_count) {
    echo $total_count;
} else {
    echo"0";
} ?> </span>
                            </div>

                        </div>

                    </div>

                </div>

            </div>
        </form>
       
    </div>
</div>